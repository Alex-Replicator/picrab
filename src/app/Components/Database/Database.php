<?php
namespace Picrab\Components\Database;

class Database {
    private static $instance;
    private static $dbObject;

    public static function getInstance(array $config): Database {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct(array $config) {
        $class = "Picrab\\Components\\Database\\" . $config['driver'] . "Database";
        self::$dbObject = new $class($config);
    }

    public function query(string $sql, array $params = []): array {
        return self::$dbObject->query($sql, $params);
    }

    public function execute(string $sql, array $params = []): bool {
        return self::$dbObject->execute($sql, $params);
    }

    public function getPageContent(int $id): array|false {
        $res = self::$dbObject->query("SELECT p.id, p.title, p.content, pt.slug FROM hGtv_pages p INNER JOIN hGtv_pages_pagetypes pp ON p.id = pp.page_id INNER JOIN hGtv_pagetypes pt ON pp.pagetype_id = pt.id WHERE p.id = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }

    public function getPageType(int $id): array|false {
        $res = self::$dbObject->query("SELECT pt.id, pt.slug FROM hGtv_pages_pagetypes pp INNER JOIN hGtv_pagetypes pt ON pp.pagetype_id = pt.id WHERE pp.page_id = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }

    public function getCurrentTheme(): string|false {
        // Попытка получить текущую тему из таблицы настроек
        $res = self::$dbObject->query("SELECT value FROM hGtv_settings WHERE `key` = 'current_theme' LIMIT 1", []);
        if (!empty($res)) {
            return $res[0]['value'];
        }
        // Если нет, получить активную тему из таблицы тем
        $res = self::$dbObject->query("SELECT slug FROM hGtv_themes WHERE active = 1 LIMIT 1", []);
        return $res[0]['slug'] ?? false;
    }

    public function setCurrentTheme(string $themeSlug): bool {
        // Деактивировать все темы
        self::$dbObject->execute("UPDATE hGtv_themes SET active = 0", []);
        // Активировать выбранную тему
        $result = self::$dbObject->execute("UPDATE hGtv_themes SET active = 1 WHERE slug = ?", [$themeSlug]);
        if ($result) {
            // Обновить настройку текущей темы
            self::$dbObject->execute("INSERT INTO hGtv_settings (`key`, `value`) VALUES ('current_theme', ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)", [$themeSlug]);
            return true;
        }
        return false;
    }
}
