#### Файл: *default_db.sql*
```
 
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: database:3306
-- Время создания: Дек 17 2024 г., 08:31
-- Версия сервера: 8.0.40
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `default_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_modules`
--

CREATE TABLE `hGtv_modules` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_global` tinyint(1) NOT NULL,
  `ver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` json NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_modules`
--

INSERT INTO `hGtv_modules` (`id`, `title`, `slug`, `created_at`, `is_global`, `ver`, `config`, `active`) VALUES
(1, 'Шапка', 'header', '2024-12-12 03:51:31', 1, '0.0.1', '{}', 1),
(4, 'Футер', 'footer', '2024-12-12 15:38:43', 1, '0.0.1', '{}', 1),
(5, 'Меню', 'menu', '2024-12-12 15:38:43', 1, '0.0.1', '{}', 1),
(6, 'Тайный модуль удаленный', 'secret', '2024-12-12 15:47:15', 0, '0.0.1', '{}', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_modules_pagetypes`
--

CREATE TABLE `hGtv_modules_pagetypes` (
  `module_id` int UNSIGNED NOT NULL,
  `pagetype_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_modules_pagetypes`
--

INSERT INTO `hGtv_modules_pagetypes` (`module_id`, `pagetype_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pages`
--

CREATE TABLE `hGtv_pages` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pages`
--

INSERT INTO `hGtv_pages` (`id`, `title`, `content`) VALUES
(1, 'Главная', '<h1>Это главная</h1>'),
(404, '404', '<h1>404 страница не найдена</h1>');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pages_pagetypes`
--

CREATE TABLE `hGtv_pages_pagetypes` (
  `id` int NOT NULL,
  `page_id` int UNSIGNED NOT NULL,
  `pagetype_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pages_pagetypes`
--

INSERT INTO `hGtv_pages_pagetypes` (`id`, `page_id`, `pagetype_id`) VALUES
(1, 1, 1),
(2, 404, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pagetypes`
--

CREATE TABLE `hGtv_pagetypes` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pagetypes`
--

INSERT INTO `hGtv_pagetypes` (`id`, `title`, `slug`, `is_admin`) VALUES
(1, 'Главная страница', 'main', 0),
(2, '404', '404', 0),
(3, 'Админ-панель', 'admin', 1),
(4, 'Страница', 'page', 0),
(5, 'Редактирование', 'update', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_themes`
--

CREATE TABLE `hGtv_themes` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_themes`
--

INSERT INTO `hGtv_themes` (`id`, `title`, `description`, `ver`, `slug`, `active`) VALUES
(1, 'PiCrab Default', 'Тема по умолчанию', '0.0.1', 'default', 0),
(2, 'Metronic', 'Описание темы', '0.0.1', 'Metronic', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `hGtv_modules`
--
ALTER TABLE `hGtv_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `hGtv_modules_pagetypes`
--
ALTER TABLE `hGtv_modules_pagetypes`
  ADD KEY `module_id` (`module_id`),
  ADD KEY `pagetype_id` (`pagetype_id`);

--
-- Индексы таблицы `hGtv_pages`
--
ALTER TABLE `hGtv_pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hGtv_pages_pagetypes`
--
ALTER TABLE `hGtv_pages_pagetypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `pagetype_id` (`pagetype_id`);

--
-- Индексы таблицы `hGtv_pagetypes`
--
ALTER TABLE `hGtv_pagetypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `hGtv_modules`
--
ALTER TABLE `hGtv_modules`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages`
--
ALTER TABLE `hGtv_pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages_pagetypes`
--
ALTER TABLE `hGtv_pages_pagetypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_pagetypes`
--
ALTER TABLE `hGtv_pagetypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `hGtv_modules_pagetypes`
--
ALTER TABLE `hGtv_modules_pagetypes`
  ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `hGtv_modules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_2` FOREIGN KEY (`pagetype_id`) REFERENCES `hGtv_pagetypes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 
```
 

#### Файл: *src/app/Themes/default/templates/pagetypes/main.php*
```
 
<?php
__dd($config, 1);
?> 
```
 

#### Файл: *src/app/Core/ComponentsManager.php*
```
 
<?php
namespace Picrab\Core;

use ReflectionClass;
use ReflectionMethod;
use Exception;

class ComponentsManager
{
    public array $config;
    private array $components = [];

    public static $instance;

    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }



    private function __construct(array $config)
    {
        $this->config = $config;
        $this->initializeComponents();
    }

    private function initializeComponents()
    {
        $componentsConfig = $this->config['components'];
        foreach ($componentsConfig as $componentName => $componentSettings) {
            if (isset($componentSettings['class'])) {
                $class = $componentSettings['class'];
                $conf = $componentSettings['config'] ?? [];
                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $constructor = $reflection->getConstructor();
                    if ($constructor && $constructor->getNumberOfParameters() > 0) {
                        if (!$constructor->isPublic()) {
                            if (method_exists($class, 'getInstance')) {
                                $this->components[$componentName] = $class::getInstance($conf);
                                continue;
                            } else {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                        }
                        $parameters = [];
                        foreach ($constructor->getParameters() as $param) {
                            $paramType = $param->getType();
                            if ($paramType && !$paramType->isBuiltin()) {
                                $dependencyClass = $paramType->getName();
                                $dependency = $this->getDependency($dependencyClass);
                                if ($dependency) {
                                    $parameters[] = $dependency;
                                } else {
                                    throw new Exception("Unresolved dependency {$dependencyClass} for component {$componentName}");
                                }
                            } else {
                                $parameters[] = $conf[$param->getName()] ?? null;
                            }
                        }
                        $this->components[$componentName] = $reflection->newInstanceArgs($parameters);
                    } else {
                        if (method_exists($class, "getInstance")) {
                            $this->components[$componentName] = $class::getInstance($conf);
                        } else {
                            $constructorCheck = $reflection->getConstructor();
                            if ($constructorCheck && !$constructorCheck->isPublic()) {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                            $this->components[$componentName] = new $class($conf);
                        }
                    }
                }
            }
        }
    }

    private function getDependency(string $className)
    {
        foreach ($this->components as $component) {
            if ($component instanceof $className) {
                return $component;
            }
        }
        return null;
    }

    public function get(string $componentName)
    {
        return $this->components[$componentName] ?? null;
    }

    public function getAll(): array
    {
        return $this->components;
    }
} 
```
 

#### Файл: *src/app/Core/Config.php*
```
 
<?php
namespace Picrab\Core;


class Config
{

    public mixed $config;
    public static $instance;

    public static function getInstance($config){
        if(self::$instance === null){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct($config)
    {
        $this->config = $config;
        return $this->get();
    }

    public function add($key, $value)
    {
        $this->config[$key] = $value;
        return $this->get();
    }

    public function set(array $config){
        $this->config = $config;
        return $this->get();
    }

    public function get()
    {
        return $this->config;
    }




} 
```
 

#### Файл: *src/app/Core/Request.php*
```
 
<?php
namespace Picrab\Core;

class Request
{
    private mixed $method;
    private string|int|array|null|false $uri;
    private array $get;
    private array $post;
    private array|false $headers;

    private $requestConfig ;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->headers = getallheaders();
    }

    public function getrequestConfig(): array
    {
        $this->requestConfig = [
            'method' => $this->method,
            'uri' => $this->uri,
            'get' => $this->get,
            'post' => $this->post,
            'headers' => $this->headers
        ];
        return $this->requestConfig;
    }

    public function setReuqestConfig($requestConfig)
    {
        $this->requestConfig = $requestConfig;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getGet():array
    {
        return $this->get;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
} 
```
 

#### Файл: *src/app/Core/RouterBasic.php*
```
 
<?php
namespace Picrab\Core;

class RouterBasic
{
    private $request;
    private $response;

    private $defaultGet;

    private $defaultMethod;


    public function __construct(Request $request, Response $response)
    {

        $this->defaultGet = [
            'type' => '1',
            'id' => '1',
            'page' => '1',
            'action' => '1',
        ];
        $this->defaultMethod = 'GET';
        $this->request = $request;
        $this->response = $response;
    }

    public function getData()
    {
        $routerMap = [];
        $routerMap['uri'] = @$this->request->getUri() ?: '/index.php';
        $routerMap['method'] = $this->request->getMethod() ?: 'GET';
        $routerMap['get']['type'] = @$this->request->getGet()['type'] ?:  '1';
        $routerMap['get']['id'] = @$this->request->getGet()['id'] ?: '1';
        $routerMap['get']['page'] = @$this->request->getGet()['page'] ?: '1';
        $routerMap['get']['action'] = @$this->request->getGet()['action'] ?: '1';

        return $routerMap;

    }


} 
```
 

#### Файл: *src/app/Core/init.php*
```
 
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










 
```
 

#### Файл: *src/app/Core/Response.php*
```
 
<?php
namespace Picrab\Core;

class Response
{
    private $statusCode = 200;
    private $headers = [];
    private $body;

    public function setStatusCode(int $code)
    {
        $this->statusCode = $code;
    }

    public function addHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;
    }

    public function setBody(string $content)
    {
        $this->body = $content;
    }

    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        return $this->body;
    }

    public function notFound($data = null){
        $this->setStatusCode(404);
        $this->setBody($data);
        return $this->send();

    }
} 
```
 

#### Файл: *src/app/Core/helpers/debug.php*
```
 
<?php

function __dd($var, $array = false){
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($array){
        print_r($var);
     }else{
        var_dump($var);
     }
    echo "</pre></div>";
}

function  __ddd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function __d($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

function __pe($msg, $exception = false){
    ob_start();
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($exception) throw new Exception($msg);
    echo $msg;
    echo "</pre></div>";
    return ob_get_clean();


} 
```
 

#### Файл: *src/app/Core/langs/ru.php*
```
 
 
```
 

#### Файл: *src/app/Modules/Footer/Footer.php*
```
 
<?php
namespace Picrab\Modules\Footer;

class Footer
{

} 
```
 

#### Файл: *src/app/Modules/Header/Header.php*
```
 
<?php
namespace Picrab\Modules\Header;

class Header
{

} 
```
 

#### Файл: *src/app/Components/ModulesManager/ModulesManager.php*
```
 
<?php
namespace Picrab\Components\ModulesManager;

use Picrab\Components\Database\Database;

class ModulesManager
{

    private static Database $DB;

    public mixed $modules;

    public static $instance = null;



    public function __construct(mixed $config)
    {
        self::$DB = Database::getInstance($config);
        return $this->loadModules($config);
    }

    private function loadModules($config)
    {
        if (isset($config['router']['get']['type'])) {
            $query = "
                SELECT m.* 
                FROM `hGtv_modules_pagetypes` mp
                INNER JOIN `hGtv_modules` m ON mp.module_id = m.id
                WHERE mp.`pagetype_id` = ? AND m.`active` = 1
            ";
            $params = [$config['router']['get']['type']];
            $modules = self::$DB::query($query, $params);

            foreach ($modules as $module) {
                $key = ucfirst($module['slug']);
                unset($module['slug']);
                $this->modules[$key] = $module;
            }

            foreach ($this->modules as $key => $module){
                $moduleClass = "Picrab\\Modules\\$key\\{$key}";
                if(class_exists($moduleClass)){
                    $this->modules[$key]['object'] = new $moduleClass($config);
                }
            }
            return $this->modules;
        }
    }

    public function getModule($config, string $name)
    {
        return $this->modules[$name]['object'] ?? null;
    }

    public function getAll(): array
    {
        return $this->modules;
    }
} 
```
 

#### Файл: *src/app/Components/Database/Database.php*
```
 
<?php
namespace Picrab\Components\Database;

class Database{

    public static mixed $dbObjectName;
    public static mixed $dbObject;

    public static $instance;

    public static function getInstance($config)
    {
        if (self::$instance == null){
            self::$instance = new self($config);
        }
        return self::$instance;

    }

    private function __construct(array $config)
    {
        self::$dbObjectName = "Picrab\\Components\\Database\\".$config['driver']."Database";
        self::$dbObject = new self::$dbObjectName($config);
        return self::$dbObject;
    }

    public static function connect($password){
        return self::$dbObject->connect($password);
    }

    public static function query(string $sql, array $params = []): array
    {
        return self::$dbObject->query($sql, $params);
    }

    public static function execute(string $sql, array $params = []): bool
    {
        return self::$dbObject->execute($sql, $params);
    }

    public function getPageContent($id)
    {
        $query = "SELECT * FROM `hGtv_pages` WHERE `id` = ? LIMIT 1";
        $params = [];
        $params[] = $id;
        $result = self::$dbObject->query($query, $params);
        if(!$result){
            return false;
        }
        return $result[0];
    }

    public function getPageType($id){
        $query = "SELECT `pagetype_id` FROM `hGtv_pages_pagetypes` WHERE `page_id` = ? LIMIT 1";
        $params = [];
        $params[] = $id;
        $result = self::$dbObject->query($query, $params);
        if(!$result){
            return false;
        }
        return $result[0];
    }


    public function getActiveTheme(): string
    {
        $query = "SELECT `slug` FROM `hGtv_themes` WHERE `active` = ? LIMIT 1";
        $params = [1];
        $result = self::$dbObject::query($query, $params);
        if(!$result[0]['slug'] OR empty($result[0]['slug'])){
            return 'default';
        }
        return $result[0]['slug'];
    }

}

 
```
 

#### Файл: *src/app/Components/Database/MysqlDatabase.php*
```
 
<?php
namespace Picrab\Components\Database;
use mysqli;


class MysqlDatabase implements DatabaseInterface
{
    private static $host;
    private static $dbname;
    private static $user;
    private static $password;
    private static $connect;

    public function __construct(array $config)
    {
        self::$host = $config['host'];
        self::$dbname = $config['dbname'];
        self::$user = $config['user'];
        self::$password = $config['password'];
        $password =  self::$password;
        self::$connect = self::connect($password);
    }

    public function connect($password): mysqli
    {
        return new mysqli(self::$host, self::$user, $password, self::$dbname, "3306");
    }

    
    public function query(string $sql, array $params = []): array
    {
        $stmt = self::$connect->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute($params);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = self::$connect->prepare($sql);
        return $stmt->execute($params);
    }
} 
```
 

#### Файл: *src/app/Components/Database/DatabaseInterface.php*
```
 
<?php
namespace Picrab\Components\Database;

interface DatabaseInterface
{
    public function connect($password);
    public function query(string $sql, array $params = []): array;
    public function execute(string $sql, array $params = []): bool;
}
 
```
 

#### Файл: *src/app/Components/FormConstruct/FormConstruct.php*
```
 
 
```
 

#### Файл: *src/app/Components/Renderer/Renderer.php*
```
 
<?php
namespace Picrab\Components\Renderer;



class Renderer
{

    public array $pageContent;


    public function renderBlock(string $template, array $data = []): string
    {
        if (!file_exists($template)) {
            return '';
        }
        extract($data);
        ob_start();
        include $template;
        return ob_get_clean();
    }

} 
```
 

#### Файл: *src/app/config.php*
```
 
<?php


use Picrab\Components\Database\Database;
use Picrab\Components\ModulesManager\ModulesManager;
use Picrab\Components\Renderer\Renderer;

return [
    'core' => [
        'base_dir' => '/var/www/html',
        'default_lang' => 'ru',
        'default_timezone' => 'Europe/Moscow',

        'paths' =>[
            'app_dir' => '/app/',
            'core_dir' => '/app/Core/',
            'helpers_dir' => '/app/Core/helpers/',
            'components_dir' =>  '/app/Components/',
            'modules_dir' =>  '/app/Modules/',
            'themes_dir' =>  '/app/Themes/',
            'public_dir' => '/public/',
            'storage_dir' => '/storage/',
        ],
    ],
    'components' =>[

        "database" => [
            "class" => Database::class,
            "config" => [
                'driver' => 'Mysql',
                "host" => "database",
                "dbname" => "default_db",
                "user" => "root",
                "password" => "6rov1BATETbLWWNA",
                "salt" => "hGtv_"
            ],
            "depends_on" => [
            ]
        ],

        "renderer" => [
            "class" => Renderer::class,
            "config" => [
                "default_theme_name" => "default"
            ],
            "depends_on" => [
                "database"
            ]
        ],

        "modulesManager" => [
            "class" => ModulesManager::class,
            "config" => [

            ],
            "depends_on" =>[
                "database", "renderer"
            ]
        ],



    ]
];


 
```
 

#### Файл: *src/app/worker.php*
```
 
<?php

echo "its me";
$i = 0;
while(true){
    echo "qu - {$i} \n";
    $i++;
    sleep(1);
} 
```
 

#### Файл: *src/public/index.php*
```
 
<?php
//phpinfo();

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../app/Core/init.php';

__dd($config['componentsList']['renderer']); 
```
 

