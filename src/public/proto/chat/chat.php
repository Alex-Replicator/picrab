<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$chatPath = __DIR__ . '/chats/' . $id . '.json';
if (!file_exists($chatPath)) {
    header('Location: index.php');
    exit;
}
$data = json_decode(file_get_contents($chatPath), true);
$messages = $data['messages'];
$title = $data['title'] ?? $id;
$configPath = __DIR__ . '/chats/config.json';
$config = json_decode(file_get_contents($configPath), true);
$nadSystemPrompt = $config['nad_system_prompt'] ?? '';
$systemPrompt = $config['system_prompt'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_prompts') {
    $newNad = $_POST['nad_system_prompt'] ?? '';
    $newSys = $_POST['system_prompt'] ?? '';
    $config['nad_system_prompt'] = $newNad;
    $config['system_prompt'] = $newSys;
    file_put_contents($configPath, json_encode($config, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    header("Location: chat.php?id=".urlencode($id));
    exit;
}
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
        .container-full {
            width: 100%;
            height: calc(100vh - 56px);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
        }
        .left-panel {
            width: 33%;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }
        .right-panel {
            width: 67%;
            display: flex;
            flex-direction: column;
        }
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }
        .messages {
            display: flex;
            flex-direction: column;
        }
        .message {
            padding: .5rem 1rem;
            border-radius: .5rem;
            margin-bottom: .5rem;
            word-wrap: break-word;
            max-width: 85%;
        }
        .message-user {
            background: #d1ecf1;
            align-self: flex-end;
        }
        .message-assistant {
            background: #f8d7da;
            align-self: flex-start;
        }
        .message-system {
            background: #e2e3e5;
            align-self: center;
            font-style: italic;
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
        #notification {
            display: none;
            background-color: #ffc107;
            padding: 0.5rem;
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;">
                <path d="M20 6L9 17l-5-5"></path>
            </svg>
            MyChat
        </a>
        <button class="btn btn-outline-light ms-auto" data-bs-toggle="modal" data-bs-target="#promptsModal">
            View / Edit Prompts
        </button>
    </div>
</nav>
<div class="container-full">
    <div class="left-panel">
        <div class="chat-body d-flex flex-column">
            <div class="flex-grow-1 d-flex flex-column">
                <div id="notification"></div>
                <div id="editor" style="flex:1;"></div>
            </div>
            <div class="chat-footer d-flex justify-content-end">
                <button id="sendButton" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
    <div class="right-panel">
        <div class="chat-body">
            <div id="messages" class="messages mb-3">
                <?php foreach($messages as $m): ?>
                    <?php
                    $r = $m['role'] ?? 'assistant';
                    $cls = 'message-assistant';
                    if ($r === 'user') $cls = 'message-user';
                    if ($r === 'system') $cls = 'message-system';
                    ?>
                    <div class="message <?= $cls ?>">
                        <div class="msg-content"><?= $m['content']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="spinnerContainer">
                <div id="spinner"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="promptsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" name="action" value="update_prompts">
                <div class="modal-header">
                    <h5 class="modal-title">Prompts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nad-system Prompt</label>
                        <textarea name="nad_system_prompt" class="form-control" rows="3"><?=htmlspecialchars($nadSystemPrompt)?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">System Prompt</label>
                        <textarea name="system_prompt" class="form-control" rows="3"><?=htmlspecialchars($systemPrompt)?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save & Reload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
    const notificationDiv = document.getElementById('notification');
    function parseSystemUpdate(fullText) {
        const regex = /=system_update=([\s\S]*?)=system_update=/;
        const match = fullText.match(regex);
        if (match) {
            notificationDiv.textContent = 'System prompt has been updated.';
            notificationDiv.style.display = 'block';
            fetch('system_update.php', {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify({new_prompt: match[1]})
            });
            setTimeout(function() {
                notificationDiv.style.display = 'none';
            }, 3000);
            return fullText.replace(regex, '');
        }
        return fullText;
    }
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
                        const finalText = parseSystemUpdate(assistantMsg);
                        assistantMsg = finalText;
                        fetch('save_assistant_msg.php', {
                            method: 'POST',
                            headers: {'Content-Type':'application/json'},
                            body: JSON.stringify({chat_id:'<?= $id; ?>',message:assistantMsg})
                        });
                        spinnerContainer.style.display = 'none';
                        if (assistantContent) {
                            assistantContent.textContent = assistantMsg;
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