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

