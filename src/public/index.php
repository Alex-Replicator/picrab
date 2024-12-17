<?php
//phpinfo();

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../app/Core/init.php';

__dd($config['componentsList']['renderer']);