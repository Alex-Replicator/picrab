<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';

$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;

$pageTypeId = $container->pageTypeId;
$modulesManager = $container->modulesManager;

$pageTypeSlug = $container->pageTypeSlug;
$template = $renderer->getThemePath() . "/pagetypes/" . $pageTypeSlug . ".php";

$renderModule = function($slug) use ($modulesManager, $renderer, &$renderModule, $pageContent) {
    $module = $modulesManager->getModule($slug);
    if ($module && method_exists($module, 'render')) {
        return $module->render($renderer, $renderModule, [
            'pageContent' => $pageContent
        ]);
    }
    return '';
};

echo $renderer->renderTemplate($template, [
    'title' => $pageContent['title'],
    'content' => $pageContent['content'],
    'renderModule' => $renderModule
]);