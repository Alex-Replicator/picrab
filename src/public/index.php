<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';
$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;
$pageTypeId = $container->pageTypeId;
$modulesManager = $container->modulesManager;
$data = $db->query("SELECT slug FROM hGtv_pagetypes WHERE id = ? LIMIT 1", [$pageTypeId]);
$pageTypeSlug = $data[0]['slug'] ?? 'main';
$template = $renderer->getThemePath() . "/pagetypes/" . $pageTypeSlug . ".php";
$renderModule = function($slug) use ($modulesManager, $renderer) {
    $module = $modulesManager->getModule($slug);
    if ($module && method_exists($module, 'render')) {
        return $module->render($renderer);
    }
    return '';
};
echo $renderer->renderTemplate($template, [
    'title' => $pageContent['title'],
    'content' => $pageContent['content'],
    'renderModule' => $renderModule
]);