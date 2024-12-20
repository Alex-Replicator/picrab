<?php



namespace Picrab\Core;

ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$helpersFiles = scandir(__DIR__ . "/helpers/");
unset($helpersFiles[0], $helpersFiles[1]);
foreach ($helpersFiles as $key => $helper){
    require_once __DIR__."/helpers/".$helper;
}

require __DIR__ . "/../../vendor/autoload.php";

$config = require __DIR__ . "/../config.php";

use Picrab\Components\Database\Database;
use Picrab\Components\ModulesManager\ModulesManager;
use Picrab\Components\Renderer\Renderer;

// Инициализация конфигурации
Config::getInstance($config);

// Старт сессии
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$request = new Request();
$response = new Response();
$router = new RouterBasic($request, $response);

$container = new \stdClass();
$container->request = $request;
$container->response = $response;
$container->router_data = $router->getData();
$container->mainURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];

$componentsConfig = Config::getInstance()->get()['components'];
$dbConfig = $componentsConfig['database']['config'];
$db = Database::getInstance($dbConfig);
$container->db = $db;

$theme = $db->getCurrentTheme();
$componentsConfig['renderer']['config']['current_theme'] = $theme;
$container->themeAssets = "/themes/{$theme}/assets/";

$modulesManager = new ModulesManager($db);
$container->modulesManager = $modulesManager;

$pageId = $container->router_data['get']['id'] ??1;
$pageContent = $db->getPageContent($pageId);
if (!$pageContent) {
    header("location: /index.php?id=2");
    exit;
}

$pageAction = $container->router_data['get']['action'] ?? 'view';
$container->pageContent = $pageContent;

$pageTypeData = $db->getPageType($pageId);
$container->pageTypeId = $pageTypeData['id'] ??1;
$container->pageTypeSlug = $pageTypeData['slug'] ?? 'main';
$container->pageAction = $pageAction;

$rendererConfig = $componentsConfig['renderer']['config'];
$modules = $modulesManager->loadModulesForPageType($container->pageTypeId);
$container->modules = $modules;

$globalConfig = [];
$globalConfig['core'] = $config['core'];
$globalConfig['current_page']['route'] = $container->router_data;
$globalConfig['current_page']['pageContent'] = $pageContent;
$globalConfig['current_page']['pageTypeID'] = $container->pageTypeId;
$globalConfig['current_page']['pageTypeSlug'] = $container->pageTypeSlug;
$globalConfig['current_page']['action'] = $container->pageAction;

$globalConfig['themeAssets'] = $container->themeAssets;

// Добавляем общие данные, чтобы не дублировать в каждом модуле
$globalConfig['db'] = $db;
$globalConfig['modules'] = $modules;
$globalConfig['pageContent'] = $pageContent;

$renderer = new Renderer($rendererConfig, $globalConfig);
$container->renderer = $renderer;

$context = new Context($renderer, $db, $modules, $pageContent, $renderer->currentTheme);
foreach ($modules as $m) {
    $m->setContext($context);
}

return $container;