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
$token = $config['tokens'][0] ?? '';
$data['messages'][] = ['role'=>'user','content'=>$message];
file_put_contents($chatPath, json_encode($data));

$postData = [
    'model' => 'o1',
    'locale' => 'ru',
    'messages' => $data['messages'],
    'stream' => true
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://openaio1api.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => false,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
        'Accept: text/event-stream'
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($postData),
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