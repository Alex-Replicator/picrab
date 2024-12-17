<div class="container d-flex align-items-center justify-content-center" style="height:100vh;">
    <div class="card shadow-sm" style="max-width: 400px; width:100%;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Вход в систему</h4>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Логин</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
        </div>
    </div>
</div>