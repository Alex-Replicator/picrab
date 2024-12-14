<?php
//phpinfo();

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once __DIR__ . '/../app/Core/init.php';
$config['componentsList']['renderer']->renderPage($config);