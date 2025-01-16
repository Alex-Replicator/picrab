<?php
$input = json_decode(file_get_contents('php://input'),true);
$chatId = $input['chat_id'] ?? '';
$message = $input['message'] ?? '';
$chatPath = __DIR__ . '/chats/' . $chatId . '.json';
if (!file_exists($chatPath) || !$message) {
    echo 'error';
    exit;
}
$data = json_decode(file_get_contents($chatPath), true);
$data['messages'][] = ['role'=>'assistant','content'=>$message];
file_put_contents($chatPath, json_encode($data));
echo 'ok';