<?php
// Пример обработки смены темы через AJAX

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTheme = sanitaze($_POST['theme'] ?? '');

    if (empty($newTheme)) {
        echo json_encode(['success' => false, 'error' => 'Тема не указана']);
        exit;
    }

    // Проверка, существует ли тема
    $themeExists = $db->query("SELECT id FROM hGtv_themes WHERE slug = ? LIMIT 1", [$newTheme]);
    if (empty($themeExists)) {
        echo json_encode(['success' => false, 'error' => 'Тема не найдена']);
        exit;
    }

    // Установка новой темы
    $result = $db->setCurrentTheme($newTheme);
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Тема успешно изменена']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось изменить тему']);
    }
    exit;
}

// Если не POST-запрос
echo json_encode(['success' => false, 'error' => 'Неверный метод запроса']);
exit;
