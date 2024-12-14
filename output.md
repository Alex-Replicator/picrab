#### Файл: *src/public/proto/chat_old/chat.php*
```
 
<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$chatPath = __DIR__ . '/chats/' . $id . '.json';
if (!file_exists($chatPath)) {
    header('Location: index.php');
    exit;
}
$data = json_decode(file_get_contents($chatPath), true);
$messages = $data['messages'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container { max-width: 600px; margin: 0 auto; }
        .message { padding: .5rem 1rem; border-radius: .5rem; margin-bottom: .5rem; }
        .message-user { background: #d1ecf1; align-self: flex-end; }
        .message-assistant { background: #f8d7da; align-self: flex-start; }
        .messages { display: flex; flex-direction: column; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5 chat-container">
    <h1 class="mb-4">Chat</h1>
    <div class="mb-3"><a href="index.php" class="btn btn-secondary btn-sm">Back to list</a></div>
    <div id="messages" class="messages mb-4">
        <?php foreach($messages as $m): ?>
            <div class="message <?php echo $m['role']=='user'?'message-user':'message-assistant'; ?>">
                <?php echo nl2br(htmlspecialchars($m['content'])); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <form id="chatForm" class="input-group mb-3">
        <textarea type="text" id="userInput" class="form-control" placeholder="Type your message..."></textarea>
        <button class="btn btn-primary" type="submit">Send</button>
    </form>
</div>
<script>

    function escapeHTML(str) {
        var element = document.createElement('div');
        if (str) {
            element.innerText = str;
            element.textContent = str;
        }
        return element.innerHTML;
    }

    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var input = document.getElementById('userInput');
        var msg = escapeHTML(input.value.trim());
        if(!msg) return;
        input.value='';
        var messages = document.getElementById('messages');
        var userMsg = document.createElement('div');
        userMsg.classList.add('message','message-user');
        userMsg.innerHTML = msg.replace(/\n/g,'<br>');
        messages.appendChild(userMsg);
        messages.scrollTop = messages.scrollHeight;
        fetch('api.php', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({chat_id:'<?php echo $id; ?>',message:msg})
        })
            .then(r=>r.json())
            .then(j=>{
                var assistantMsg = document.createElement('div');
                assistantMsg.classList.add('message','message-assistant');
                assistantMsg.innerHTML = (j.response||'').replace(/\n/g,'<br>');
                messages.appendChild(assistantMsg);
                messages.scrollTop = messages.scrollHeight;
            });
    });
</script>
</body>
</html> 
```
 

#### Файл: *src/public/proto/chat_old/api.php*
```
 
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
```
 

#### Файл: *src/public/proto/chat_old/index.php*
```
 
<?php
$chatDir = __DIR__ . '/chats';
if (!file_exists($chatDir)) {
    mkdir($chatDir, 0777, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = uniqid('chat_', true);
    file_put_contents($chatDir . '/' . $id . '.json', json_encode([
        'messages' => [
            ['role' => 'system', 'content' => 'Ты помогаешь мне разрабатывать сервис, используя чистый HTML, CSS, JS, PHP и MySQL. Когда я прошу у тебя коды файлов, мне нужны их полные, максимально завершённые и функциональные версии. Не добавляй комментарии типа \/\/ Другие методы по необходимости или \/\/ Другие вспомогательные функции по необходимости и не включай документацию. В свободной форме отвечай только тогда, когда я специально попрошу об этом. В остальных случаях — только полные коды файлов.']
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
```
 

