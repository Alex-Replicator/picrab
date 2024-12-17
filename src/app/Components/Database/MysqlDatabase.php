<?php
namespace Picrab\Components\Database;
use mysqli;

class MysqlDatabase implements DatabaseInterface
{
    private static string $host;
    private static string $dbname;
    private static string $user;
    private static string $password;
    private static mysqli $connect;

    public function __construct(array $config)
    {
        self::$host = $config['host'];
        self::$dbname = $config['dbname'];
        self::$user = $config['user'];
        self::$password = $config['password'];
        self::$connect = $this->connect(self::$password);
    }

    public function connect(string $password): mysqli
    {
        return new mysqli(self::$host, self::$user, $password, self::$dbname, 3306);
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = self::$connect->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?: [];
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = self::$connect->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        return $stmt->execute();
    }
}