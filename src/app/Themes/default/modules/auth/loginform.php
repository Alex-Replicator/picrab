<form id="login-form" class="mt-4">
    <div class="mb-3">
        <label for="username" class="form-label">Имя пользователя</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>

<script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('/ajax_handler.php?ajax=true', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams(formData)
        })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    window.location.href = data.redirect || '/index.php?id=4';
                } else {
                    alert(data.error || 'Ошибка при входе');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
    });
</script>
