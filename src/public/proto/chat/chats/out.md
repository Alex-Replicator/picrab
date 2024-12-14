**Файл: src/public/proto/chat/index.php**

```php
<?php
$chatDir = __DIR__ . '/chats';
if (!file_exists($chatDir)) {
mkdir($chatDir, 0777, true);
}
$configPath = $chatDir . '/config.json';
if (!file_exists($configPath)) {
file_put_contents($configPath, json_encode([
'system_prompt' => 'Ты помогаешь мне разрабатывать сервис, используя чистый HTML, CSS, JS, PHP и MySQL. Когда я прошу у тебя коды файлов, мне нужны их полные, максимально завершённые и функциональные версии. Не добавляй комментарии типа // Другие методы по необходимости или // Другие вспомогательные функции по необходимости и не включай документацию. В свободной форме отвечай только тогда, когда я специально попрошу об этом. В остальных случаях — только полные коды файлов.',
'tokens' => ['sk-dbqbZAuIDdGvcnInnb3R01OGbExYiaEfi0id6LqNOk1bkwK3'],
'default_credits' => 100
]));
}
$config = json_decode(file_get_contents($configPath), true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST['action']) && $_POST['action'] === 'new_chat') {
$id = uniqid('chat_', true);
file_put_contents($chatDir . '/' . $id . '.json', json_encode([
'messages' => [
['role' => 'system', 'content' => $config['system_prompt']]
],
'credits' => $config['default_credits'],
'title' => $id
]));
header('Location: chat.php?id=' . urlencode($id));
exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'save_config') {
$system_prompt = $_POST['system_prompt'] ?? '';
$tokens = $_POST['tokens'] ?? '';
$default_credits = (int)($_POST['default_credits'] ?? 100);
$tokens_list = array_filter(array_map('trim', explode("\n", $tokens)));
if (empty($tokens_list)) {
$tokens_list = $config['tokens'];
}
file_put_contents($configPath, json_encode([
'system_prompt' => $system_prompt,
'tokens' => $tokens_list,
'default_credits' => $default_credits
]));
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
return strpos($f,'.json') !== false && $f !== 'config.json';
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
<input type="hidden" name="action" value="new_chat">
<button type="submit" class="btn btn-primary mb-3">New Chat</button>
</form>
<form method="post" class="mb-4">
<input type="hidden" name="action" value="save_config">
<div class="mb-3">
<label class="form-label">System prompt</label>
<textarea name="system_prompt" class="form-control" rows="3"><?=htmlspecialchars($config['system_prompt'])?></textarea>
</div>
<div class="mb-3">
<label class="form-label">Tokens (one per line)</label>
<textarea name="tokens" class="form-control" rows="3"><?=htmlspecialchars(implode("\n", $config['tokens']))?></textarea>
</div>
<div class="mb-3">
<label class="form-label">Default credits</label>
<input type="number" name="default_credits" class="form-control" value="<?=htmlspecialchars($config['default_credits'])?>">
</div>
<button type="submit" class="btn btn-secondary">Save Config</button>
</form>
<ul class="list-group">
<?php foreach($chats as $chatFile):
$id = basename($chatFile,'.json');
$cd = json_decode(file_get_contents($chatDir.'/'.$chatFile),true);
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
```

---

**Файл: src/public/proto/chat/chat.php**

```php
<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$chatPath = __DIR__ . '/chats/' . $id . '.json';
if (!file_exists($chatPath)) {
header('Location: index.php');
exit;
}
$data = json_decode(file_get_contents($chatPath), true);
$messages = $data['messages'];
$credits = $data['credits'] ?? 0;
$title = $data['title'] ?? $id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chat</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<style>
.chat-container { max-width: 600px; margin: 0 auto; }
.message { padding: .5rem 1rem; border-radius: .5rem; margin-bottom: .5rem; }
.message-user { background: #d1ecf1; align-self: flex-end; }
.message-assistant { background: #f8d7da; align-self: flex-start; }
.messages { display: flex; flex-direction: column; }
#preview { border: 1px solid #ccc; padding: .5rem; min-height: 100px; margin-top: .5rem; background: #fff; }
#progressBar { height: 5px; background: #007bff; width: 0%; transition: width 0.2s; }
</style>
</head>
<body class="bg-light">
<div class="container py-5 chat-container">
<h1 class="mb-4"><?=htmlspecialchars($title)?></h1>
<div class="mb-3"><a href="index.php" class="btn btn-secondary btn-sm">Back to list</a></div>
<div class="mb-3">
<label class="form-label">Credits:</label>
<input type="number" id="creditsInput" class="form-control mb-2" value="<?=htmlspecialchars($credits)?>" readonly>
<label class="form-label">Remaining:</label>
<input type="number" id="remainingCredits" class="form-control" value="<?=htmlspecialchars($credits)?>" readonly>
</div>
<div id="messages" class="messages mb-4">
<?php foreach($messages as $m): ?>
<div class="message <?php echo $m['role']=='user'?'message-user':'message-assistant'; ?>">
<div class="msg-content"><?php echo $m['content']; ?></div>
</div>
<?php endforeach; ?>
</div>
<div class="mb-3">
<label class="form-label">Your message (Markdown):</label>
<textarea id="userInput" class="form-control" rows="4"></textarea>
<div id="preview"></div>
</div>
<form id="chatForm" class="input-group mb-3">
<button class="btn btn-primary" type="submit">Send</button>
</form>
<div id="progressBar"></div>
</div>
<script>
function renderAllMessages() {
document.querySelectorAll('.msg-content').forEach(function(el){
el.innerHTML = marked.parse(el.textContent);
});
}
renderAllMessages();
document.getElementById('userInput').addEventListener('input', function() {
document.getElementById('preview').innerHTML = marked.parse(this.value);
});
document.getElementById('chatForm').addEventListener('submit', function(e) {
e.preventDefault();
var input = document.getElementById('userInput');
var msg = input.value.trim();
if(!msg) return;
input.value='';
document.getElementById('preview').innerHTML='';
var messages = document.getElementById('messages');
var userMsg = document.createElement('div');
userMsg.classList.add('message','message-user');
var userMsgContent = document.createElement('div');
userMsgContent.classList.add('msg-content');
userMsgContent.textContent = msg;
userMsg.appendChild(userMsgContent);
messages.appendChild(userMsg);
messages.scrollTop = messages.scrollHeight;
renderAllMessages();
var progressBar = document.getElementById('progressBar');
progressBar.style.width = '0%';
progressBar.style.display = 'block';
fetch('api.php', {
method: 'POST',
headers: {'Content-Type':'application/json'},
body: JSON.stringify({chat_id:'<?php echo $id; ?>',message:msg})
}).then(response => {
const reader = response.body.getReader();
let assistantMsg = '';
function readChunk() {
return reader.read().then(({done, value}) => {
if (done) {
progressBar.style.width='0%';
progressBar.style.display='none';
if (assistantMsg) {
var assistantDiv = document.createElement('div');
assistantDiv.classList.add('message','message-assistant');
var assistantContent = document.createElement('div');
assistantContent.classList.add('msg-content');
assistantContent.textContent = assistantMsg;
assistantDiv.appendChild(assistantContent);
messages.appendChild(assistantDiv);
messages.scrollTop = messages.scrollHeight;
renderAllMessages();
var remain = document.getElementById('remainingCredits');
remain.value = parseInt(remain.value,10)-2;
}
return;
}
var chunk = new TextDecoder("utf-8").decode(value);
assistantMsg += chunk;
progressBar.style.width='50%';
return readChunk();
});
}
return readChunk();
});
});
</script>
</body>
</html>
```

---

**Файл: src/public/proto/chat/api.php**

```php
<?php
$chatId = '';
$message = '';
$input = json_decode(file_get_contents('php://input'),true);
$chatId = $input['chat_id'] ?? '';
$message = $input['message'] ?? '';
$chatPath = __DIR__ . '/chats/' . $chatId . '.json';
if (!file_exists($chatPath) || !$message) {
header('Content-Type: text/plain');
echo '';
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
header('Content-Type: text/plain');
ignore_user_abort(true);
ob_implicit_flush(true);
ob_end_flush();
curl_exec($ch);
curl_close($ch);
$assistantMsg = file_get_contents('php://input');
```

---

Данные изменения включают все требуемые функции.