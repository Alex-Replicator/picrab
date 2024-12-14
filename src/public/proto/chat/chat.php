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