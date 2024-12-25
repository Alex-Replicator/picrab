<h1>Админ-панель</h1>
<p>Здесь вы можете управлять сайтом.</p>

<h2>Смена темы</h2>
<form id="change-theme-form">
    <div class="mb-3">
        <label for="theme-select" class="form-label">Выберите тему</label>
        <select class="form-select" id="theme-select" name="theme" required>
            <option value="">-- Выберите тему --</option>
            <?php
            $themes = $db->query("SELECT slug, title FROM hGtv_themes WHERE active = 1 OR active = 0");
            foreach ($themes as $theme) {
                echo "<option value=\"{$theme['slug']}\">{$theme['title']}</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Сменить тему</button>
</form>

<div id="change-theme-message" class="mt-3"></div>

<script>
    document.getElementById('change-theme-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const theme = document.getElementById('theme-select').value;

        if (!theme) {
            alert('Пожалуйста, выберите тему');
            return;
        }

        sendAjax('change_theme', { theme: theme }, (response) => {
            if(response.success){
                document.getElementById('change-theme-message').innerHTML = '<div class="alert alert-success">'+response.message+'</div>';
                // Перезагрузка страницы для применения новой темы
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                document.getElementById('change-theme-message').innerHTML = '<div class="alert alert-danger">'+response.error+'</div>';
            }
        });
    });
</script>
