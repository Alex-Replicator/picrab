<?php
require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$componentsConfig = $config['components'];
$dbConfig = $componentsConfig['database']['config'];

use Picrab\Components\Database\Database;

// Инициализация БД
$db = Database::getInstance($dbConfig);

while (true) {
    $tasks = $db->query("SELECT * FROM hGtv_worker_tasks WHERE status='pending' ORDER BY id ");

    foreach ($tasks as $task) {
        echo "Processing task #{$task['id']} of type {$task['type']} with payload: " . json_encode($task['payload']) . "\n";

        sleep(2);

        // Обновляем статус задачи на 'completed'
        $db->execute("UPDATE hGtv_worker_tasks SET status='completed' WHERE id=?", [$task['id']]);
        echo "Task #{$task['id']} completed.\n";
    }

    sleep(5);
}