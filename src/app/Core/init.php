<?php
namespace Picrab\Core;


use Picrab\Components\Database\Database;
use Picrab\Components\ModulesManager\ModulesManager;
use Picrab\Components\Renderer\Renderer;

$config = require __DIR__."/../config.php";
Config::getInstance($config);

$helpersDir = __DIR__ . "/helpers/";
$helpersFiles = scandir($helpersDir);
foreach ($helpersFiles as $helpersFile) {
    if ($helpersFile !== "." && $helpersFile !== "..") {
        require_once $helpersDir . $helpersFile;
    }
}

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

$rendererConfig = $componentsConfig['renderer']['config'];
$renderer = new Renderer($rendererConfig);
$container->renderer = $renderer;

$modulesManager = new ModulesManager($db);
$container->modulesManager = $modulesManager;

$pageId = $container->router_data['get']['id'] ?? 1;
$pageContent = $db->getPageContent($pageId);

if (!$pageContent) {
    header("location: /index.php?id=2");
    exit;
}
$container->pageContent = $pageContent;
$pageTypeData = $db->getPageType($pageId);

$container->pageTypeId = $pageTypeData['id'] ?? 1;
$container->pageTypeSlug = $pageTypeData['slug'] ?? 'main';
$modules = $modulesManager->loadModulesForPageType($container->pageTypeId);
$container->modules = $modules;

return $container;