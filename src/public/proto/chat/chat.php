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
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=htmlspecialchars($title)?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .chat-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .chat-header {
            background: #343a40;
            color: #fff;
            padding: 1rem;
        }
        .chat-header .title {
            margin: 0;
            font-size: 1.25rem;
        }
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }
        .message {
            padding: .5rem 1rem;
            border-radius: .5rem;
            margin-bottom: .5rem;
            word-wrap: break-word;
        }
        .message-user {
            background: #d1ecf1;
            align-self: flex-end;
            max-width: 75%;
        }
        .message-assistant {
            background: #f8d7da;
            align-self: flex-start;
            max-width: 75%;
        }
        .messages {
            display: flex;
            flex-direction: column;
        }
        .chat-footer {
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            background: #fff;
        }
        #spinnerContainer {
            display: none;
            justify-content: center;
            align-items: center;
            margin-bottom: .5rem;
        }
        #spinner {
            width: 2rem;
            height: 2rem;
            border: 0.3em solid rgba(0,0,0,0.2);
            border-top: 0.3em solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .code-block-wrapper {
            position: relative;
        }
        .copy-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #fff;
            border: 1px solid #ccc;
            font-size: 0.8rem;
            padding: 0.2rem 0.5rem;
            cursor: pointer;
            border-radius: 3px;
            opacity: 0.7;
        }
        .copy-button:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
<div class="chat-wrapper container py-5">
    <div class="chat-header d-flex justify-content-between align-items-center">
        <h1 class="title mb-0"><?=htmlspecialchars($title)?></h1>
        <div>
            <a href="index.php" class="btn btn-sm btn-light">Chats</a>
        </div>
    </div>
    <div class="chat-body">
        <div class="mb-3">
            <label>Credits:</label>
            <input type="number" id="creditsInput" class="form-control mb-2" value="<?=htmlspecialchars($credits)?>" readonly>
            <label>Remaining:</label>
            <input type="number" id="remainingCredits" class="form-control" value="<?=htmlspecialchars($credits)?>" readonly>
        </div>
        <div id="messages" class="messages mb-3">
            <?php foreach($messages as $m): ?>
                <div class="message <?= $m['role']=='user'?'message-user':'message-assistant'; ?>">
                    <div class="msg-content"><?= $m['content']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="spinnerContainer">
            <div id="spinner"></div>
        </div>
    </div>
    <div class="chat-footer">
        <div class="d-flex">
            <div id="editor" style="flex:1;"></div>
            <button id="sendButton" class="btn btn-primary ms-2">Send</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<script>
    function addCopyButtonToCodeBlocks(el) {
        el.querySelectorAll('pre > code').forEach(function(block) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('code-block-wrapper');
            block.parentNode.replaceWith(wrapper);
            wrapper.appendChild(block.parentNode.cloneNode(true));
            wrapper.querySelector('code').replaceWith(block);

            const copyBtn = document.createElement('button');
            copyBtn.classList.add('copy-button');
            copyBtn.textContent = 'Copy';
            copyBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(block.innerText);
                copyBtn.textContent = 'Copied!';
                setTimeout(() => { copyBtn.textContent = 'Copy'; }, 1000);
            });
            wrapper.appendChild(copyBtn);
        });
    }

    function renderMessage(el) {
        const rawText = el.textContent;
        el.innerHTML = marked.parse(rawText);
        el.querySelectorAll('pre code').forEach(function(block) {
            hljs.highlightElement(block);
        });
        addCopyButtonToCodeBlocks(el);
    }

    document.querySelectorAll('.msg-content').forEach(function(el){
        renderMessage(el);
    });

    const editor = new toastui.Editor({
        el: document.querySelector('#editor'),
        initialEditType: 'markdown',
        height: '300px',
        previewStyle: 'tab'
    });

    const messages = document.getElementById('messages');
    const spinnerContainer = document.getElementById('spinnerContainer');

    document.getElementById('sendButton').addEventListener('click', function() {
        const msg = editor.getMarkdown().trim();
        if(!msg) return;
        editor.setMarkdown('');
        const userMsg = document.createElement('div');
        userMsg.classList.add('message','message-user');
        const userMsgContent = document.createElement('div');
        userMsgContent.classList.add('msg-content');
        userMsgContent.textContent = msg;
        userMsg.appendChild(userMsgContent);
        messages.appendChild(userMsg);
        messages.scrollTop = messages.scrollHeight;
        renderMessage(userMsgContent);

        spinnerContainer.style.display = 'flex';

        fetch('api.php', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({chat_id:'<?= $id; ?>',message:msg})
        }).then(response => {
            const reader = response.body.getReader();
            const textDecoder = new TextDecoder("utf-8");
            let assistantMsg = '';
            let assistantDiv;
            let assistantContent;
            let done = false;
            let buffer = '';

            function createAssistantMessage() {
                if (!assistantDiv) {
                    assistantDiv = document.createElement('div');
                    assistantDiv.classList.add('message','message-assistant');
                    assistantContent = document.createElement('div');
                    assistantContent.classList.add('msg-content');
                    assistantDiv.appendChild(assistantContent);
                    messages.appendChild(assistantDiv);
                }
            }

            function processLine(line) {
                if (line.startsWith('data: ')) {
                    const jsonStr = line.substring(6);
                    if (jsonStr === '[DONE]') {
                        done = true;
                        fetch('save_assistant_msg.php', {
                            method: 'POST',
                            headers: {'Content-Type':'application/json'},
                            body: JSON.stringify({chat_id:'<?= $id; ?>',message:assistantMsg})
                        });
                        var remain = document.getElementById('remainingCredits');
                        remain.value = parseInt(remain.value,10)-2;
                        spinnerContainer.style.display = 'none';
                        if (assistantContent) {
                            renderMessage(assistantContent);
                        }
                        return;
                    }
                    try {
                        const obj = JSON.parse(jsonStr);
                        const delta = obj.choices[0].delta.content || '';
                        if (delta) {
                            assistantMsg += delta;
                            createAssistantMessage();
                            assistantContent.textContent += delta;
                            messages.scrollTop = messages.scrollHeight;
                        }
                    } catch(e){}
                }
            }

            function processBuffer() {
                const lines = buffer.split('\n');
                let incompleteLine = '';
                for (let i = 0; i < lines.length; i++) {
                    const line = lines[i];
                    if (i === lines.length - 1 && buffer[buffer.length - 1] !== '\n') {
                        incompleteLine = line;
                    } else {
                        if (line.trim() !== '') processLine(line.trim());
                    }
                }
                buffer = incompleteLine;
            }

            function readChunk() {
                return reader.read().then(({done: streamDone, value}) => {
                    if (streamDone) {
                        if (buffer.trim() !== '') {
                            processLine(buffer.trim());
                            buffer = '';
                        }
                        return;
                    }
                    buffer += textDecoder.decode(value, {stream:true});
                    processBuffer();
                    return readChunk();
                });
            }
            return readChunk();
        });
    });
</script>
</body>
</html>