<?php
$config = [
    'api' => [
        'url' => 'https://openaio1api.com/v1/chat/completions',
        'token' => 'sk-dbqbZAuIDdGvcnInnb3R01OGbExYiaEfi0id6LqNOk1bkwK3'
    ]
];
$input = json_decode(file_get_contents('php://input'),true);
$chatId = $input['chat_id'] ?? '';
$message = $input['message'] ?? '';
$chatPath = __DIR__ . '/chats/' . $chatId . '.json';
if (!file_exists($chatPath) || !$message) {
    echo json_encode(['response'=>'']);
    exit;
}
$data = json_decode(file_get_contents($chatPath),true);
$data['messages'][] = ['role'=>'user','content'=>$message];
$postData = [
    'model' => 'o1',
    'locale' => 'ru',
    'messages' => $data['messages'],
    'stream' => false
];
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $config['api']['url'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $config['api']['token'],
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($postData),
    CURLOPT_FOLLOWLOCATION => true,
]);
$response = curl_exec($ch);
if($response===false){
    echo json_encode(['response'=>'']);
    exit;
}
curl_close($ch);
$res = json_decode($response,true);
$assistantMsg = $res['choices'][0]['message']['content'] ?? '';
$data['messages'][] = ['role'=>'assistant','content'=>$assistantMsg];
file_put_contents($chatPath, json_encode($data));
echo json_encode(['response'=>$assistantMsg]);