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