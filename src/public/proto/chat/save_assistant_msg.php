<?php
$input = json_decode(file_get_contents('php://input'),true);
$chatId = $input['chat_id'] ?? '';
$message = $input['message'] ?? '';
$chatPath = __DIR__ . '/chats/' . $chatId . '.json';
$configChatPath = __DIR__ . '/chats/config.json';
if (!file_exists($chatPath) || !$message) {
    echo 'error';
    exit;
}
$data = json_decode(file_get_contents($chatPath), true);
$data['messages'][] = ['role'=>'assistant','content'=>$message];
file_put_contents($chatPath, json_encode($data));
$config = json_decode(file_get_contents($configChatPath), true);
$config['default_credits'] = (int)$config['default_credits'] - 2;
file_put_contents($configChatPath, json_encode($config));

echo 'ok';