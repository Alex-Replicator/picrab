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