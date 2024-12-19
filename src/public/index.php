<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';
$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;
$pageTypeId = $container->pageTypeId;
$modulesManager = $container->modulesManager;
$pageTypeSlug = $container->pageTypeSlug;
$template = $renderer->getThemePath() . "/pagetypes/" . $pageTypeSlug . ".php";
$pageContent['pageTypeID'] = $container->pageTypeId;
$pageContent['pageTypeSlug'] = $container->pageTypeSlug;
$pageContent['action'] = $container->pageAction;

$renderModule = static function($slug, $submodule = null) use ($db, $modulesManager, $renderer, &$renderModule, $pageContent) {
    $module = $modulesManager->getModule($slug);
    $defaultMethod = $submodule ?? 'render';

    if ($module && method_exists($module, $defaultMethod)) {
        return $module->$defaultMethod($renderer, $renderModule, [
            'pageContent' => $pageContent,
            'db' => $db
        ]);
    }
    return '';
};


echo $renderer->renderTemplate($template, [
    'id' => $pageContent['id'],
    'title' => $pageContent['title'],
    'content' => $pageContent['content'],
    'pageTypeID' => $pageContent['pageTypeID'],
    'pageTypeSlug' => $pageContent['pageTypeSlug'],
    'action' => $pageContent['action'],
    'renderModule' => $renderModule
]);

