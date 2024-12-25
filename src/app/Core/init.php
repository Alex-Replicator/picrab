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
$routerData = $router->getData();

$container = new \stdClass();
$container->request = $request;
$container->response = $response;
$container->router_data = $routerData;
$container->mainURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];

$componentsConfig = Config::getInstance()->get()['components'];
$dbConfig = $componentsConfig['database']['config'];
$db = Database::getInstance($dbConfig);
$container->db = $db;

$theme = $db->getCurrentTheme();
if (!$theme) {
    // Установка темы по умолчанию, если текущая не найдена
    $theme = 'default';
}

$componentsConfig['renderer']['config']['current_theme'] = $theme;
$container->themeAssets = "/themes/{$theme}/assets/";

$modulesManager = new ModulesManager($db);
$container->modulesManager = $modulesManager;

$pageId = $routerData['get']['id'] ?? 1;
$pageContent = $db->getPageContent($pageId);

$isAdmin = $routerData['is_admin'];

if (!$isAdmin && !$pageContent) {
    // Фронтенд: Перенаправление на 404, если контент отсутствует
    header("HTTP/1.0 404 Not Found");
    $pageContent = [
        'id' => 2,
        'title' => '404',
        'content' => '<h1>404 страница не найдена</h1>',
        'pageTypeSlug' => '404',
        'pageTypeID' => 2,
        'action' => 'view'
    ];
} elseif ($isAdmin && !$pageContent) {
    // Админка: Загрузка админской главной страницы, если контент отсутствует
    $pageContent = [
        'id' => 4,
        'title' => 'Админ-панель',
        'content' => '<h1>Админ-панель</h1>',
        'pageTypeSlug' => 'admin',
        'pageTypeID' => 3,
        'action' => 'view'
    ];
}

$pageAction = $routerData['get']['action'] ?? 'view';
$pageTypeData = $db->getPageType($pageId);
$pageTypeSlug = $pageTypeData['slug'] ?? 'main';
$pageTypeId = $pageTypeData['id'] ?? 1;

$container->pageContent = $pageContent;
$container->pageTypeId = $pageTypeId;
$container->pageTypeSlug = $pageTypeSlug;
$container->pageAction = $pageAction;

// Проверка на AJAX-запрос
if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    require_once __DIR__ . '/../../public/ajax_handler.php';
    exit;
}

$rendererConfig = $componentsConfig['renderer']['config'];
$modules = $modulesManager->loadModulesForPageType($pageTypeId);
$container->modules = $modules;

$globalConfig = [];
$globalConfig['core'] = $config['core'];
$globalConfig['current_page']['route'] = $routerData;
$globalConfig['current_page']['pageContent'] = $pageContent;
$globalConfig['current_page']['pageTypeID'] = $pageTypeId;
$globalConfig['current_page']['pageTypeSlug'] = $pageTypeSlug;
$globalConfig['current_page']['action'] = $pageAction;
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
