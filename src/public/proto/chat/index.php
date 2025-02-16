<?php
$chatDir = __DIR__ . '/chats';
if (!file_exists($chatDir)) {
    if (!mkdir($chatDir, 0777, true) && !is_dir($chatDir)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $chatDir));
    }
}
$configPath = $chatDir . '/config.json';
$config = json_decode(file_get_contents($configPath), true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'new_chat') {
        $id = uniqid('chat_', true);
        file_put_contents($chatDir . '/' . $id . '.json', json_encode([
            'messages' => [
                ['role' => 'system', 'content' => $config['system_prompt']]
            ],
            'title' => $id
        ], JSON_THROW_ON_ERROR));
        header('Location: chat.php?id=' . urlencode($id));
        exit;
    }
    if (isset($_POST['action']) && $_POST['action'] === 'save_config') {
        $nad_system_prompt = $_POST['nad_system_prompt'] ?? '';
        $system_prompt = $_POST['system_prompt'] ?? '';
        $tokens = $_POST['tokens'] ?? '';
        $tokens_list = array_filter(array_map('trim', explode("\n", $tokens)));
        if (empty($tokens_list)) {
            $tokens_list = $config['tokens'];
        }
        $config['nad_system_prompt'] = $nad_system_prompt;
        $config['system_prompt'] = $system_prompt;
        $config['tokens'] = $tokens_list;
        file_put_contents($configPath, json_encode($config, JSON_THROW_ON_ERROR));
        $config = json_decode(file_get_contents($configPath), true);
    }
    if (isset($_POST['action']) && $_POST['action'] === 'rename_chat') {
        $old_id = $_POST['old_id'] ?? '';
        $new_name = trim($_POST['new_name'] ?? '');
        if ($old_id && $new_name && file_exists($chatDir . '/' . $old_id . '.json')) {
            $data = json_decode(file_get_contents($chatDir . '/' . $old_id . '.json'), true);
            $new_id = uniqid('chat_', true);
            $data['title'] = $new_name;
            unlink($chatDir . '/' . $old_id . '.json');
            file_put_contents($chatDir . '/' . $new_id . '.json', json_encode($data));
        }
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete_chat') {
        $del_id = $_POST['del_id'] ?? '';
        if ($del_id && file_exists($chatDir . '/' . $del_id . '.json')) {
            unlink($chatDir . '/' . $del_id . '.json');
        }
    }
}
$chats = array_filter(scandir($chatDir), function($f){
    return str_contains($f, '.json') && $f !== 'config.json';
});
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;">
                <path d="M20 6L9 17l-5-5"></path>
            </svg>
            MyChat
        </a>
    </div>
</nav>
<div class="container py-5">
    <h1 class="mb-4">Chats</h1>
    <form method="post" class="mb-4">
        <input type="hidden" name="action" value="new_chat">
        <button type="submit" class="btn btn-primary mb-3">New Chat</button>
    </form>
    <form method="post" class="mb-4">
        <input type="hidden" name="action" value="save_config">
        <div class="mb-3">
            <label class="form-label">Nad-system prompt</label>
            <textarea name="nad_system_prompt" class="form-control" rows="3"><?=htmlspecialchars($config['nad_system_prompt'] ?? '')?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">System prompt (modifiable by AI)</label>
            <textarea name="system_prompt" class="form-control" rows="3"><?=htmlspecialchars($config['system_prompt'] ?? '')?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tokens (one per line)</label>
            <textarea name="tokens" class="form-control" rows="3"><?=htmlspecialchars(implode("\n", $config['tokens']))?></textarea>
        </div>
        <button type="submit" class="btn btn-secondary">Save Config</button>
    </form>
    <ul class="list-group">
        <?php foreach($chats as $chatFile):
            $id = basename($chatFile, '.json');
            $cd = json_decode(file_get_contents($chatDir . '/' . $chatFile), true);
            $title = $cd['title'] ?? $id;
            ?>
            <li class="list-group-item d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span><?=htmlspecialchars($title)?></span>
                    <a href="chat.php?id=<?=urlencode($id)?>" class="btn btn-sm btn-secondary">Open</a>
                </div>
                <div class="d-flex">
                    <form method="post" class="me-2 d-flex">
                        <input type="hidden" name="action" value="rename_chat">
                        <input type="hidden" name="old_id" value="<?=htmlspecialchars($id)?>">
                        <input type="text" name="new_name" class="form-control form-control-sm me-1" placeholder="New name">
                        <button type="submit" class="btn btn-sm btn-info">Rename</button>
                    </form>
                    <form method="post" class="d-flex">
                        <input type="hidden" name="action" value="delete_chat">
                        <input type="hidden" name="del_id" value="<?=htmlspecialchars($id)?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>