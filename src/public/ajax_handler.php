<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';
$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;
$pageTypeId = $container->pageTypeId;
$pageTypeSlug = $container->pageTypeSlug;
$pageAction = $container->pageAction;

// Проверка, является ли запрос AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

// Получение данных из POST
$action = $_POST['action'] ?? '';
$data = $_POST['data'] ?? [];

// Определение обработчика действия
switch ($action) {
    case 'save_form':
        // Пример обработки сохранения формы через модуль FormConstructor
        if (isset($container->modules['FormConstructor'])) {
            $formModule = $container->modules['FormConstructor'];
            $formModule->save($pageContent['id'], $data);
            echo json_encode(['success' => true, 'message' => 'Форма успешно сохранена']);
            exit;
        }
        break;

    case 'load_form':
        if (isset($container->modules['FormConstructor'])) {
            $formModule = $container->modules['FormConstructor'];
            $formData = $formModule->render();
            echo json_encode(['success' => true, 'form' => $formData]);
            exit;
        }
        break;

    // Добавьте дополнительные действия по мере необходимости

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action']);
        exit;
}

// Если действие не обработано
http_response_code(400);
echo json_encode(['error' => 'Action not handled']);
exit;
