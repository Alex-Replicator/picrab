<?php
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
            "class" => "Picrab\\Components\\Database\\Database",
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
            "class" => "Picrab\\Components\\Renderer\\Renderer",
            "config" => [
                "default_theme_name" => "default"
            ],
            "depends_on" => [
                "database"
            ]
        ],

        "modulesManager" => [
            "class" => "Picrab\\Components\\ModulesManager\\ModulesManager",
            "config" => [

            ],
            "depends_on" =>[
                "database", "renderer"
            ]
        ],



    ]
];


