<?php
namespace Picrab\Components\Database;

class Database
{
    private static $instance;
    private static $dbObject;

    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct(array $config)
    {
        $class = "Picrab\\Components\\Database\\".$config['driver']."Database";
        self::$dbObject = new $class($config);
    }

    public static function connect(string $password)
    {
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

    public function getPageContent(int $id): array|false
    {
        $res = self::$dbObject->query("SELECT * FROM `hGtv_pages` WHERE `id` = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }

    public function getPageType(int $id): array|false
    {
        $res = self::$dbObject->query("SELECT `pagetype_id` FROM `hGtv_pages_pagetypes` WHERE `page_id` = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }
}