<?php
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', false);
while (ob_get_level() > 0) {
    ob_end_flush();
}
ob_implicit_flush(true);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$input = json_decode(file_get_contents('php://input'),true);
$chatId = $input['chat_id'] ?? '';
$message = $input['message'] ?? '';
$chatPath = __DIR__ . '/chats/' . $chatId . '.json';

if (!file_exists($chatPath) || !$message) {
    echo "data: [DONE]\n\n";
    exit;
}

$data = json_decode(file_get_contents($chatPath),true);
$configPath = __DIR__ . '/chats/config.json';
$config = json_decode(file_get_contents($configPath),true);

// Читаем над-системный промпт и обычный системный промпт
$nadSystemPrompt = $config['nad_system_prompt'] ?? 'You are a helpful AI. This part is never changed by the AI.';
$systemPrompt    = $config['system_prompt']     ?? '';

// Склеиваем так, чтобы над-промпт всегда шел первым, затем идет тот, который модель может менять
$finalSystemPrompt = $nadSystemPrompt . "\n\n" . $systemPrompt;

// Обновляем первое сообщение (role=system) на склеенный над+системный
$data['messages'][0] = ['role'=>'system','content'=>$finalSystemPrompt];
$data['messages'][]  = ['role'=>'user','content'=>$message];

file_put_contents($chatPath, json_encode($data));

$postData = [
    'model'    => 'mistral-large-latest',
    'messages' => $data['messages'],
    'stream'   => true
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.mistral.ai/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => false,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . ($config['tokens'][0] ?? ''),
        'Accept: text/event-stream'
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_WRITEFUNCTION => function($ch, $chunk) {
        echo $chunk;
        flush();
        return strlen($chunk);
    }
]);
ignore_user_abort(true);
curl_exec($ch);
curl_close($ch);