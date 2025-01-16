<?php
$input = json_decode(file_get_contents('php://input'), true);
$newPrompt = $input['new_prompt'] ?? '';
$configPath = __DIR__ . '/chats/config.json';
if (!file_exists($configPath) || !$newPrompt) {
    echo 'error';
    exit;
}
$config = json_decode(file_get_contents($configPath), true);
$config['system_prompt'] = $newPrompt;
file_put_contents($configPath, json_encode($config));
echo 'ok';