<?php
namespace Picrab\Core;

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

Config::getInstance($config);

$request = new Request();
$response = new Response();
$router = new RouterBasic($request, $response);
$container = new \stdClass();
$container->request = $request;
$container->response = $response;
$container->router_data = $router->getData();

$componentsConfig = Config::getInstance()->get()['components'];
$dbConfig = $componentsConfig['database']['config'];
$db = Database::getInstance($dbConfig);
$container->db = $db;

$theme = $db->getCurrentTheme();
$componentsConfig['renderer']['config']['current_theme'] = $theme;

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

$modules = $modulesManager->loadModulesForPageType($container->pageTypeId);
$container->modules = $modules;

$rendererConfig = $componentsConfig['renderer']['config'];
$renderer = new Renderer($rendererConfig);
$container->renderer = $renderer;

return $container;
