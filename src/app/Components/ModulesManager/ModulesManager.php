<?php
namespace Picrab\Components\ModulesManager;

use Picrab\Components\Database\Database;

class ModulesManager {
    private Database $db;
    private array $modules = [];

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function loadModulesForPageType(int $pageTypeId): array {
        $sql = "SELECT m.* FROM `hGtv_modules` m WHERE m.is_global =1 AND m.active =1 UNION SELECT m.* FROM `hGtv_modules_pagetypes` mp INNER JOIN `hGtv_modules` m ON mp.module_id = m.id WHERE mp.pagetype_id = ? AND m.active =1";
        $modulesData = $this->db->query($sql, [$pageTypeId]);
        foreach ($modulesData as $m) {
            $class = "Picrab\\Modules\\" . ucfirst($m['slug']) . "\\" . ucfirst($m['slug']);
            if (class_exists($class)) {
                $this->modules[$m['slug']] = new $class($this->db);
            }
        }
        return $this->modules;
    }

    public function getModule(string $slug) {
        return $this->modules[$slug] ?? null;
    }

    public function getAllModules(): array {
        return $this->modules;
    }
}