<?php
$chatDir = __DIR__ . '/chats';
if (!file_exists($chatDir)) {
    mkdir($chatDir, 0777, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = uniqid('chat_', true);
    file_put_contents($chatDir . '/' . $id . '.json', json_encode([
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Ты просто умный собеседник'
            ]
        ]
    ]));
    header('Location: chat.php?id=' . urlencode($id));
    exit;
}
$chats = array_filter(scandir($chatDir), function($f){
    return strpos($f,'.json') !== false;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Chats</h1>
    <form method="post" class="mb-4">
        <button type="submit" class="btn btn-primary">New Chat</button>
    </form>
    <ul class="list-group">
        <?php foreach($chats as $chatFile): $id=basename($chatFile,'.json'); ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo htmlspecialchars($id); ?></span>
                <a href="chat.php?id=<?php echo urlencode($id); ?>" class="btn btn-sm btn-secondary">Open</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>