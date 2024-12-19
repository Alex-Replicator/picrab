<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';

$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;

$pageContent['pageTypeID'] = $container->pageTypeId;
$pageContent['pageTypeSlug'] = $container->pageTypeSlug;
$pageContent['action'] = $container->pageAction;

$modules = $container->modules;

$template = $renderer->getThemePath() . "/pagetypes/" . $pageContent['pageTypeSlug'] . ".php";

echo $renderer->renderTemplate($template, [
    'id' => $pageContent['id'],
    'title' => $pageContent['title'],
    'content' => $pageContent['content'],
    'pageTypeID' => $pageContent['pageTypeID'],
    'pageTypeSlug' => $pageContent['pageTypeSlug'],
    'action' => $pageContent['action'],
    'pageContent' => $pageContent,
    'modules' => $modules,
    'db' => $db,
    'renderer' => $renderer
]);