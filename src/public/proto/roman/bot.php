<?php
// Параметры бота
$telegram_token = "7760683684:AAGV9-z8YEmmNG19tGzEf6arnZiqAjRzpe0";
$api_url = "https://api.telegram.org/bot$telegram_token/";
$script_url = "https://g2img.it-one.pro/roman/";
$bot_username = "@poznanie_v_soznanii_bot";
$system_prompt = 'Ты — Роман иноземцев и сейчас ты в чате телеграм. С тобой общаются разные люди. Ты должен общаться, спорить и вести себя как роман иноземцев.';

$mistral = [
    'agent_id' => 'ag:b8c2cf3f:20241205:roman-inozemtsev:4576d280',
    'url' => 'https://api.mistral.ai/v1/agents/completions',
    'api_key' => 'NpQYUnUNQ6RIz0O39eShaNfkueq3u4s6' // Замените на ваш реальный API-ключ
];

// Логирование
function write_log($message) {
    $log_file = __DIR__ . '/bot.log';
    $current_time = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$current_time] $message\n", FILE_APPEND);
}

// Функция для загрузки истории переписки
function load_conversation($chat_id) {
    global $system_prompt;
    $file = __DIR__ . '/conversations/' . $chat_id . '.json';
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $conversation = json_decode($json, true);
        if (is_array($conversation)) {
            write_log("История переписки загружена для чата $chat_id.");
            return $conversation;
        }
    }
    // Если история отсутствует, добавить системное сообщение
    $conversation = [
        [
            'role' => 'system',
            'content' => $system_prompt
        ]
    ];
    save_conversation($chat_id, $conversation);
    write_log("Создана новая история переписки для чата $chat_id.");
    return $conversation;
}

// Функция для сохранения истории переписки
function save_conversation($chat_id, $conversation) {
    $file = __DIR__ . '/conversations/' . $chat_id . '.json';
    if (file_put_contents($file, json_encode($conversation, JSON_PRETTY_PRINT))) {
        write_log("История переписки сохранена для чата $chat_id.");
    } else {
        write_log("Ошибка при сохранении истории переписки для чата $chat_id.");
    }
}

// Функция для добавления сообщения в историю с ограничением размера
function add_to_conversation($chat_id, $role, $content) {
    $conversation = load_conversation($chat_id);
    $conversation[] = [
        'role' => $role,
        'content' => $content
    ];
    // Ограничение истории до последних 20 сообщений
    $max_messages = 20;
    if (count($conversation) > $max_messages) {
        $conversation = array_slice($conversation, -$max_messages);
    }
    save_conversation($chat_id, $conversation);
    write_log("Добавлено сообщение от '$role' в историю чата $chat_id.");
}

// Отправка запроса к Telegram API с использованием cURL
function telegram_request($method, $params) {
    global $api_url;
    $url = $api_url . $method;

    // Инициализация cURL
    $ch = curl_init();

    // Установка опций cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Таймаут в секундах
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

    // Выполнение запроса
    $result = curl_exec($ch);

    // Проверка на ошибки cURL
    if ($result === FALSE) {
        $error_msg = curl_error($ch);
        write_log("cURL Error при вызове метода Telegram $method: " . $error_msg);
        curl_close($ch);
        return ["ok" => false];
    }

    // Получение HTTP-кода ответа
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Логирование ответа от Telegram API
    write_log("Ответ от Telegram API ($method): HTTP $http_code - $result");

    return json_decode($result, true);
}

// Получение обновлений от Telegram
$update = json_decode(file_get_contents('php://input'), TRUE);
write_log("Получено обновление: " . json_encode($update));

// Проверка, есть ли сообщение
if (!isset($update["message"])) {
    exit;
}

$message = $update["message"];

$message_id = $message["message_id"];
$chat_id = $message["chat"]["id"];
$user_id = $message["from"]["id"];
$chat_type = isset($message["chat"]["type"]) ? $message["chat"]["type"] : 'private';
$text = isset($message["text"]) ? $message["text"] : '';

// Очистка текста от упоминания бота
if ($chat_type == 'group' || $chat_type == 'supergroup') {
    $pattern = '/@' . preg_quote($bot_username, '/') . '\s*/i';
    $text = preg_replace($pattern, '', $text);
}

$is_group = ($chat_type == 'group' || $chat_type == 'supergroup');
$is_private = ($chat_type == 'private');

// Проверка на упоминание бота в группе или любое сообщение в личке
$should_respond = false;
if ($is_group) {
    if (strpos($update['message']['text'], $bot_username) !== false) {
        $should_respond = true;
    }
} elseif ($is_private) {
    $should_respond = true;
}

if (!$should_respond) {
    exit;
}

// Добавление сообщения пользователя в историю
add_to_conversation($chat_id, 'user', $text);

// Функция для отправки сообщения
function send_message($chat_id, $text, $reply_to_message_id = null) {
    $params = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    if ($reply_to_message_id) {
        $params['reply_to_message_id'] = $reply_to_message_id;
    }
    return telegram_request("sendMessage", $params);
}

// Функция для удаления сообщения
function delete_message($chat_id, $message_id) {
    $params = [
        'chat_id' => $chat_id,
        'message_id' => $message_id
    ];
    return telegram_request("deleteMessage", $params);
}

// Функция для генерации ответа через API Мистраль с учётом истории
function generate_response($chat_id, $input_text) {
    global $mistral;

    // Загрузка истории переписки уже выполнена при добавлении сообщения пользователя

    // Загрузка обновлённой истории переписки
    $conversation = load_conversation($chat_id);

    // Подготовка данных для запроса
    $data = [
        "agent_id" => $mistral['agent_id'],
        "messages" => $conversation
    ];

    // Инициализация cURL
    $ch = curl_init();

    // Установка опций cURL
    curl_setopt($ch, CURLOPT_URL, $mistral['url']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Bearer " . $mistral['api_key']
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Таймаут в секундах
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Выполнение запроса
    $result = curl_exec($ch);

    // Проверка на ошибки cURL
    if ($result === FALSE) {
        $error_msg = curl_error($ch);
        write_log("cURL Error при вызове API Мистраль: " . $error_msg);
        curl_close($ch);
        return "Извините, я не смог сгенерировать ответ.";
    }

    // Получение HTTP-кода ответа
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Логирование полного ответа для диагностики
    write_log("Ответ от API Мистраль (HTTP $http_code): " . $result);

    // Декодирование JSON-ответа
    $response = json_decode($result, true);

    // Проверка структуры ответа и извлечение сгенерированного текста
    if (isset($response['choices'][0]['message']['content'])) {
        $reply = trim($response['choices'][0]['message']['content']);

        // Добавление ответа агента в историю
        add_to_conversation($chat_id, 'assistant', $reply);

        return $reply;
    } elseif (isset($response['error']['message'])) {
        // Если API вернул ошибку
        write_log("API Мистраль вернул ошибку: " . $response['error']['message']);
        return "Извините, произошла ошибка при генерации ответа.";
    } else {
        // Неизвестный формат ответа
        write_log("Неизвестный формат ответа от API Мистраль: " . json_encode($response));
        return "Извините, я не смог сгенерировать ответ.";
    }
}

// Отправка сообщения "Думаю."
$thinking_message = send_message($chat_id, "Думаю.", $message_id);
if (!$thinking_message["ok"]) {
    write_log("Не удалось отправить сообщение 'Думаю.'");
    exit;
}
$thinking_message_id = $thinking_message["result"]["message_id"];
write_log("Отправлено сообщение 'Думаю.' с ID: $thinking_message_id");

// Имитируем процесс "думания" добавлением точек
$dot_count = 0;
$max_dots = 3;
while ($dot_count < $max_dots) {
    usleep(100000); // 0.1 секунды
    $dot_count++;
    $new_text = "Думаю" . str_repeat('.', $dot_count);
    $params = [
        'chat_id' => $chat_id,
        'message_id' => $thinking_message_id,
        'text' => $new_text
    ];
    $edit_result = telegram_request("editMessageText", $params);
    if (!$edit_result["ok"]) {
        write_log("Не удалось обновить сообщение 'Думаю...'");
        break;
    }
    write_log("Обновлено сообщение 'Думаю' до: $new_text");
}

// Генерация ответа
$input_text = $text;
$response_text = generate_response($chat_id, $input_text);
write_log("Сгенерированный ответ: $response_text");

// Отправка ответа
$reply = send_message($chat_id, $response_text, $message_id);
if ($reply["ok"]) {
    write_log("Ответ отправлен успешно.");
} else {
    write_log("Ошибка при отправке ответа.");
}

// Удаление сообщения "Думаю..."
$delete_result = delete_message($chat_id, $thinking_message_id);
if ($delete_result["ok"]) {
    write_log("Сообщение 'Думаю...' удалено.");
} else {
    write_log("Не удалось удалить сообщение 'Думаю...'.");
}

exit;
?>