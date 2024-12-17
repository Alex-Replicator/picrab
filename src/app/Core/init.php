<?php
namespace Picrab\Core;

$config = require __DIR__."/../config.php";
$config = Config::getInstance($config)->get();

$helpersDir = $config['core']['base_dir'] . $config['core']['paths']['helpers_dir'];
$helpersFiles = scandir($helpersDir);
foreach ($helpersFiles as $helpersFile){
    if($helpersFile !== "." && $helpersFile !== ".."){
        require_once $helpersDir . $helpersFile;
    }
}

$request = new Request();
$response = new Response();


$config = Config::getInstance($config)->add('router', new RouterBasic($request, $response)->getData());

$config = Config::getInstance($config)->add('response', $request->getrequestConfig());

$config = Config::getInstance($config)->add('componentsList', ComponentsManager::getInstance($config)->getAll());
$config['pageContent'] = $config['componentsList']['database']::getInstance($config)->getPageContent($config['router']['get']['id']);
if(!$config['pageContent']){
    header("location: /index.php?id=404");
}
$config = Config::getInstance($config)->add('pageContent', $config['pageContent']);

$config = Config::getInstance($config)->add('modulesList', new $config['componentsList']['modulesManager']($config));



return  $config;










