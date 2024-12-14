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