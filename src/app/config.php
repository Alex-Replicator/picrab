<?php

use Picrab\Components\Database\Database;
use Picrab\Components\ModulesManager\ModulesManager;
use Picrab\Components\Renderer\Renderer;

return [
    'core' => [
        'base_dir' => '/var/www/html',
        'default_lang' => 'ru',
        'default_timezone' => 'Europe/Moscow',
        'paths' => [
            'app_dir' => '/app/',
            'core_dir' => '/app/Core/',
            'helpers_dir' => '/app/Core/helpers/',
            'components_dir' => '/app/Components/',
            'modules_dir' => '/app/Modules/',
            'themes_dir' => '/app/Themes/',
            'public_dir' => '/public/',
            'storage_dir' => '/storage/',
        ]
    ],
    'components' => [
        'database' => [
            'class' => Database::class,
            'config' => [
                'driver' => 'Mysql',
                'host' => 'database',
                'dbname' => 'default_db',
                'user' => 'root',
                'password' => '6rov1BATETbLWWNA',
                'salt' => 'hGtv_'
            ]
        ],
        'renderer' => [
            'class' => Renderer::class,
            'config' => [
                'default_theme_name' => 'default'
            ]
        ],
        'modulesManager' => [
            'class' => ModulesManager::class,
            'config' => []
        ]
    ]
];