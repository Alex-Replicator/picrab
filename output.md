#### Файл: *default_db.sql*
```
 
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: database:3306
-- Время создания: Дек 24 2024 г., 18:22
-- Версия сервера: 8.0.40
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `default_db`
--
CREATE DATABASE IF NOT EXISTS `default_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `default_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_form_fields`
--

CREATE TABLE `hGtv_form_fields` (
                                    `id` int UNSIGNED NOT NULL,
                                    `group_id` int UNSIGNED NOT NULL,
                                    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `settings` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_form_fields`
--

INSERT INTO `hGtv_form_fields` (`id`, `group_id`, `name`, `label`, `type`, `settings`) VALUES
                                                                                           (1, 1, 'subtitle', 'Subtitle', 'text', '{}'),
                                                                                           (2, 1, 'description', 'Description', 'textarea', '{}');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_form_groups`
--

CREATE TABLE `hGtv_form_groups` (
                                    `id` int UNSIGNED NOT NULL,
                                    `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_form_groups`
--

INSERT INTO `hGtv_form_groups` (`id`, `title`) VALUES
    (1, 'Main Page Fields');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_form_page_relations`
--

CREATE TABLE `hGtv_form_page_relations` (
                                            `id` int UNSIGNED NOT NULL,
                                            `page_id` int UNSIGNED NOT NULL,
                                            `pagetype_id` int UNSIGNED NOT NULL,
                                            `group_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_form_page_relations`
--

INSERT INTO `hGtv_form_page_relations` (`id`, `page_id`, `pagetype_id`, `group_id`) VALUES
    (1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_form_values`
--

CREATE TABLE `hGtv_form_values` (
                                    `id` int UNSIGNED NOT NULL,
                                    `field_id` int UNSIGNED NOT NULL,
                                    `page_id` int UNSIGNED NOT NULL,
                                    `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_form_values`
--

INSERT INTO `hGtv_form_values` (`id`, `field_id`, `page_id`, `value`) VALUES
                                                                          (1, 1, 1, 'Welcome to the main page'),
                                                                          (2, 2, 1, 'This is a sample description.');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_modules`
--

CREATE TABLE `hGtv_modules` (
                                `id` int UNSIGNED NOT NULL,
                                `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                `created_at` datetime NOT NULL,
                                `is_global` tinyint(1) NOT NULL,
                                `ver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                `config` json NOT NULL,
                                `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_modules`
--

INSERT INTO `hGtv_modules` (`id`, `title`, `slug`, `created_at`, `is_global`, `ver`, `config`, `active`) VALUES
                                                                                                             (1, 'Шапка', 'header', '2024-12-12 03:51:31', 1, '0.0.1', '{}', 1),
                                                                                                             (4, 'Футер', 'footer', '2024-12-12 15:38:43', 1, '0.0.1', '{}', 1),
                                                                                                             (5, 'Меню', 'menu', '2024-12-12 15:38:43', 1, '0.0.1', '{}', 1),
                                                                                                             (6, 'Авторизация', 'auth', '2024-12-17 13:59:18', 1, '0.0.1', '{}', 1),
                                                                                                             (7, 'Сайдбар', 'sidebar', '2024-12-19 16:49:12', 1, '0.0.1', '{}', 1),
                                                                                                             (8, 'Мета', 'meta', '2024-12-19 16:57:49', 1, '0.0.1', '{}', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_modules_pagetypes`
--

CREATE TABLE `hGtv_modules_pagetypes` (
                                          `module_id` int UNSIGNED NOT NULL,
                                          `pagetype_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_modules_pagetypes`
--

INSERT INTO `hGtv_modules_pagetypes` (`module_id`, `pagetype_id`) VALUES
                                                                      (1, 1),
                                                                      (1, 2),
                                                                      (4, 1),
                                                                      (4, 2),
                                                                      (5, 1),
                                                                      (6, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pages`
--

CREATE TABLE `hGtv_pages` (
                              `id` int UNSIGNED NOT NULL,
                              `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                              `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pages`
--

INSERT INTO `hGtv_pages` (`id`, `title`, `content`) VALUES
                                                        (1, 'Это сайт', '<h1>Это главная</h1>'),
                                                        (2, '404', '<h1>404 страница не найдена</h1>'),
                                                        (3, 'Страница входа', '<h1>Вход в систему</h1>'),
                                                        (4, 'Админ-панель', '<h1>Админ-панель</h1>');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pages_pagetypes`
--

CREATE TABLE `hGtv_pages_pagetypes` (
                                        `id` int NOT NULL,
                                        `page_id` int UNSIGNED NOT NULL,
                                        `pagetype_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pages_pagetypes`
--

INSERT INTO `hGtv_pages_pagetypes` (`id`, `page_id`, `pagetype_id`) VALUES
                                                                        (1, 1, 1),
                                                                        (2, 2, 2),
                                                                        (3, 3, 6),
                                                                        (4, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_pagetypes`
--

CREATE TABLE `hGtv_pagetypes` (
                                  `id` int NOT NULL,
                                  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_pagetypes`
--

INSERT INTO `hGtv_pagetypes` (`id`, `title`, `slug`, `is_admin`) VALUES
                                                                     (1, 'Главная страница', 'main', 0),
                                                                     (2, '404', '404', 0),
                                                                     (3, 'Админ-панель', 'admin', 1),
                                                                     (4, 'Страница', 'page', 0),
                                                                     (5, 'Редактирование', 'update', 1),
                                                                     (6, 'Страница входа', 'login', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_permissions`
--

CREATE TABLE `hGtv_permissions` (
                                    `id` int UNSIGNED NOT NULL,
                                    `module_id` int UNSIGNED NOT NULL,
                                    `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_permissions`
--

INSERT INTO `hGtv_permissions` (`id`, `module_id`, `description`) VALUES
                                                                      (1, 4, 'Доступ к модулю Footer'),
                                                                      (2, 5, 'Доступ к модулю Menu');

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_themes`
--

CREATE TABLE `hGtv_themes` (
                               `id` int NOT NULL,
                               `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `ver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_themes`
--

INSERT INTO `hGtv_themes` (`id`, `title`, `description`, `ver`, `slug`, `active`) VALUES
                                                                                      (1, 'PiCrab Default', 'Тема по умолчанию', '0.0.1', 'default', 1),
                                                                                      (2, 'Metronic', 'Описание темы', '0.0.1', 'Metronic', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_users`
--

CREATE TABLE `hGtv_users` (
                              `id` int UNSIGNED NOT NULL,
                              `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                              `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                              `is_root` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_users`
--

INSERT INTO `hGtv_users` (`id`, `username`, `password`, `is_root`) VALUES
                                                                       (1, 'alex.replicator', '$2a$12$nCFArxUpemAku.7EOREyiuHeifQzM7IYiz7wGPyWvmkQBWVd9oLm2', 1),
                                                                       (2, 'gleb', '$2a$12$YUOx05b0fzHd8Pkn1X5OKOWLILKqY22OHzn1NjzkJIqIkHgparDYG', 0),
                                                                       (3, 'david', '$2a$12$xRNgc4UQXEb/2oMDcEWsTuV/78D8BFw6JvrghwHjb6Q3R.XOS0ugS', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_user_permissions`
--

CREATE TABLE `hGtv_user_permissions` (
                                         `id` int UNSIGNED NOT NULL,
                                         `user_id` int UNSIGNED NOT NULL,
                                         `module_id` int UNSIGNED NOT NULL,
                                         `allowed` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_user_permissions`
--

INSERT INTO `hGtv_user_permissions` (`id`, `user_id`, `module_id`, `allowed`) VALUES
                                                                                  (2, 1, 1, 1),
                                                                                  (3, 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hGtv_worker_tasks`
--

CREATE TABLE `hGtv_worker_tasks` (
                                     `id` int UNSIGNED NOT NULL,
                                     `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
                                     `payload` json NOT NULL,
                                     `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                     `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hGtv_worker_tasks`
--

INSERT INTO `hGtv_worker_tasks` (`id`, `type`, `status`, `payload`, `created_at`, `updated_at`) VALUES
                                                                                                    (1, 'article_generation', 'completed', '{\"count\": 10}', '2024-12-19 22:20:57', '2024-12-19 22:34:57'),
                                                                                                    (2, 'image_generation', 'completed', '{\"size\": \"1024x768\"}', '2024-12-19 22:20:57', '2024-12-19 22:34:57'),
                                                                                                    (3, 'article_generation', 'completed', '{\"count\": 10}', '2024-12-19 22:49:08', '2024-12-19 22:49:12'),
                                                                                                    (4, 'image_generation', 'completed', '{\"size\": \"1024x768\"}', '2024-12-19 22:49:08', '2024-12-19 22:49:12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `hGtv_form_fields`
--
ALTER TABLE `hGtv_form_fields`
    ADD PRIMARY KEY (`id`),
    ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `hGtv_form_groups`
--
ALTER TABLE `hGtv_form_groups`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hGtv_form_page_relations`
--
ALTER TABLE `hGtv_form_page_relations`
    ADD PRIMARY KEY (`id`),
    ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `hGtv_form_values`
--
ALTER TABLE `hGtv_form_values`
    ADD PRIMARY KEY (`id`),
    ADD KEY `field_id` (`field_id`);

--
-- Индексы таблицы `hGtv_modules`
--
ALTER TABLE `hGtv_modules`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `hGtv_modules_pagetypes`
--
ALTER TABLE `hGtv_modules_pagetypes`
    ADD KEY `module_id` (`module_id`),
    ADD KEY `pagetype_id` (`pagetype_id`);

--
-- Индексы таблицы `hGtv_pages`
--
ALTER TABLE `hGtv_pages`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hGtv_pages_pagetypes`
--
ALTER TABLE `hGtv_pages_pagetypes`
    ADD PRIMARY KEY (`id`),
    ADD KEY `page_id` (`page_id`),
    ADD KEY `pagetype_id` (`pagetype_id`);

--
-- Индексы таблицы `hGtv_pagetypes`
--
ALTER TABLE `hGtv_pagetypes`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `slug` (`slug`),
    ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `hGtv_permissions`
--
ALTER TABLE `hGtv_permissions`
    ADD PRIMARY KEY (`id`),
    ADD KEY `module_id` (`module_id`);

--
-- Индексы таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hGtv_users`
--
ALTER TABLE `hGtv_users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `hGtv_user_permissions`
--
ALTER TABLE `hGtv_user_permissions`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`),
    ADD KEY `module_id` (`module_id`);

--
-- Индексы таблицы `hGtv_worker_tasks`
--
ALTER TABLE `hGtv_worker_tasks`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `hGtv_form_fields`
--
ALTER TABLE `hGtv_form_fields`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_form_groups`
--
ALTER TABLE `hGtv_form_groups`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `hGtv_form_page_relations`
--
ALTER TABLE `hGtv_form_page_relations`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `hGtv_form_values`
--
ALTER TABLE `hGtv_form_values`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_modules`
--
ALTER TABLE `hGtv_modules`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages`
--
ALTER TABLE `hGtv_pages`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages_pagetypes`
--
ALTER TABLE `hGtv_pages_pagetypes`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `hGtv_pagetypes`
--
ALTER TABLE `hGtv_pagetypes`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `hGtv_permissions`
--
ALTER TABLE `hGtv_permissions`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_users`
--
ALTER TABLE `hGtv_users`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `hGtv_user_permissions`
--
ALTER TABLE `hGtv_user_permissions`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `hGtv_worker_tasks`
--
ALTER TABLE `hGtv_worker_tasks`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `hGtv_form_fields`
--
ALTER TABLE `hGtv_form_fields`
    ADD CONSTRAINT `hGtv_form_fields_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `hGtv_form_groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hGtv_form_page_relations`
--
ALTER TABLE `hGtv_form_page_relations`
    ADD CONSTRAINT `hGtv_form_page_relations_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `hGtv_form_groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hGtv_form_values`
--
ALTER TABLE `hGtv_form_values`
    ADD CONSTRAINT `hGtv_form_values_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `hGtv_form_fields` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hGtv_modules_pagetypes`
--
ALTER TABLE `hGtv_modules_pagetypes`
    ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `hGtv_modules` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_2` FOREIGN KEY (`pagetype_id`) REFERENCES `hGtv_pagetypes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hGtv_permissions`
--
ALTER TABLE `hGtv_permissions`
    ADD CONSTRAINT `hGtv_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `hGtv_modules` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hGtv_user_permissions`
--
ALTER TABLE `hGtv_user_permissions`
    ADD CONSTRAINT `hGtv_user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `hGtv_users` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `hGtv_user_permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `hGtv_permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 
```
 

#### Файл: *src/app/Themes/default/assets/css/ajax.css*
```
 
/* Стиль для индикатора загрузки при AJAX-запросах */
.ajax-loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    display: none; /* Скрыт по умолчанию */
}

.ajax-loading.active {
    display: flex;
}

.ajax-loading::after {
    content: '';
    width: 50px;
    height: 50px;
    border: 5px solid #ccc;
    border-top-color: #1d72b8;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
 
```
 

#### Файл: *src/app/Themes/default/assets/css/style.css*
```
 
body{
    overflow-y: scroll;
} 
```
 

#### Файл: *src/app/Themes/default/assets/js/main.js*
```
 
console.log("qu"); 
```
 

#### Файл: *src/app/Themes/default/assets/js/ajax.js*
```
 
function sendAjax(action, data, callback) {
    fetch('/ajax_handler.php?ajax=true', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: action,
            data: JSON.stringify(data)
        })
    })
        .then(response => response.json())
        .then(callback)
        .catch(error => {
            console.error('Ошибка AJAX:', error);
        });
}
 
```
 

#### Файл: *src/app/Themes/default/modules/header/header.php*
```
 
<header>
    <div class="p-0 bg-white border-bottom">
        <div class="row bg-white">
            <div class="col-lg-2 d-flex align-items-center p-3">
                <a class="navbar-brand align-items-center" href="/">
                    <img src="<?=$themeAssets;?>images/logo.webp" width="40" height="40" class="d-inline-block rounded-4 align-top" alt="Logo">
                    <span class="fw-medium fs-3">PiCrab</span>
                </a>
            </div>
            <div class="col-md-9 col-lg-10 d-md p-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <?php echo $modules['menu']->render(); ?>
                        <div class="d-flex align-items-center">
                            <?php echo $modules['auth']->logoutAuthLink(); ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
 
```
 

#### Файл: *src/app/Themes/default/modules/auth/loginform.php*
```
 
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
 
```
 

#### Файл: *src/app/Themes/default/modules/auth/profile.php*
```
 
<a href="index.php?id=3" class="btn btn-outline-primary btn-sm">Войти</a> 
```
 

#### Файл: *src/app/Themes/default/modules/auth/admin.php*
```
 
<h1>Добро пожаловать в админ-панель</h1>
<p>Здесь вы можете управлять сайтом.</p> 
```
 

#### Файл: *src/app/Themes/default/modules/auth/logout.php*
```
 
<img src="https://www.meme-arsenal.com/memes/049bda12d7f90540e8c2c95a1f5c3d79.jpg" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
<span class="fw-medium me-3"><?=$user['login']?></span>
<a href="index.php?id=3&action=logout" class="btn btn-outline-danger btn-sm">Выйти</a> 
```
 

#### Файл: *src/app/Themes/default/modules/admin/admin.php*
```
 
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
 
```
 

#### Файл: *src/app/Themes/default/modules/admin/changeTheme.php*
```
 
<?php
// Пример обработки смены темы через AJAX

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTheme = sanitaze($_POST['theme'] ?? '');

    if (empty($newTheme)) {
        echo json_encode(['success' => false, 'error' => 'Тема не указана']);
        exit;
    }

    // Проверка, существует ли тема
    $themeExists = $db->query("SELECT id FROM hGtv_themes WHERE slug = ? LIMIT 1", [$newTheme]);
    if (empty($themeExists)) {
        echo json_encode(['success' => false, 'error' => 'Тема не найдена']);
        exit;
    }

    // Установка новой темы
    $result = $db->setCurrentTheme($newTheme);
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Тема успешно изменена']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось изменить тему']);
    }
    exit;
}

// Если не POST-запрос
echo json_encode(['success' => false, 'error' => 'Неверный метод запроса']);
exit;
 
```
 

#### Файл: *src/app/Themes/default/modules/meta/footer.php*
```
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?=$this->globalConfig['themeAssets'];?>js/main.js"></script> 
```
 

#### Файл: *src/app/Themes/default/modules/meta/meta.php*
```
 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
<link rel="stylesheet" href="<?=$this->globalConfig['themeAssets'];?>css/style.css">
<link rel="icon" href="<?=$this->globalConfig['themeAssets'];?>images/logo.webp">
<title><?=$pageContent['title']?></title> 
```
 

#### Файл: *src/app/Themes/default/modules/menu/menu.php*
```
 
<ul class="navbar-nav ms-0">
    <li class="nav-item">
        <a href="index.php?id=4" class="nav-link">Админ-панель</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">Настройки</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">Логи</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">Задачи воркера</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">|</a>
    </li>
    <li class="nav-item">
        <a href="index.php?id=1" class="nav-link">Перейти на сайт</a>
    </li>
</ul> 
```
 

#### Файл: *src/app/Themes/default/modules/sidebar/sidebar.php*
```
 
<nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar p-3 border-end">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuKeywords">
                Ключевики
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuKeywords">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Ключевики</a></li>
                    <li><a href="#" class="nav-link">Создать Ключевики</a></li>
                    <li><a href="#" class="nav-link">Архив Ключевиков</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuArticles">
                Статьи
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuArticles">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Статьи</a></li>
                    <li><a href="#" class="nav-link">Создать Статьи</a></li>
                    <li><a href="#" class="nav-link">Архив Статей</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuProfiles">
                Профили
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuProfiles">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Профили</a></li>
                    <li><a href="#" class="nav-link">Создать Профили</a></li>
                    <li><a href="#" class="nav-link">Архив Профилей</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuProxies">
                Прокси
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuProxies">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Прокси</a></li>
                    <li><a href="#" class="nav-link">Создать Прокси</a></li>
                    <li><a href="#" class="nav-link">Архив Прокси</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuAPI">
                API
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuAPI">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все API</a></li>
                    <li><a href="#" class="nav-link">Создать API</a></li>
                    <li><a href="#" class="nav-link">Архив API</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuAccounts">
                Аккаунты
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuAccounts">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Аккаунты</a></li>
                    <li><a href="#" class="nav-link">Создать Аккаунты</a></li>
                    <li><a href="#" class="nav-link">Архив Аккаунтов</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuWorkflow">
                Workflow
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menuWorkflow">
                <ul class="list-unstyled ps-3">
                    <li><a href="#" class="nav-link">Все Workflow</a></li>
                    <li><a href="#" class="nav-link">Создать Workflow</a></li>
                    <li><a href="#" class="nav-link">Архив Workflow</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav> 
```
 

#### Файл: *src/app/Themes/default/modules/footer/footer.php*
```
 
<footer>
    <div class="border-top">
        <div class="row bg-white">
            <div class="col-lg-12 p-3">
                <span>&copy; Все права защищены 2024 - <?php echo date("Y") ?></span>
            </div>
        </div>
    </div>
</footer> 
```
 

#### Файл: *src/app/Themes/default/pagetypes/main.php*
```
 
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render(); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render(); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render(); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?php if (isset($modules['FormConstructor'])): ?>
                        <?php echo $modules['FormConstructor']->render(); ?>
                    <?php else: ?>
                        <!-- Вы можете что-то вывести, если FormConstructor недоступен -->
                        <p class="text-muted">Модуль FormConstructor не загружен для этой страницы.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render(); ?>
</div>
<?php echo $modules['meta']->footer(); ?>
</body>
</html>
 
```
 

#### Файл: *src/app/Themes/default/pagetypes/admin.php*
```
 
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render(); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render(); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render(); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?=$content?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render(); ?>
</div>
<?php echo $modules['meta']->footer(); ?>
</body>
</html> 
```
 

#### Файл: *src/app/Themes/default/pagetypes/login.php*
```
 
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render(); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render(); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render(); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?=$content?>
                    <?php echo $modules['auth']->loginForm(); ?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render(); ?>
</div>
<?php echo $modules['meta']->footer(); ?>
</body>
</html> 
```
 

#### Файл: *src/app/Themes/default/pagetypes/404.php*
```
 
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render(); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render(); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render(); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?=$content?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render(); ?>
</div>
<?php echo $modules['meta']->footer(); ?>
</body>
</html> 
```
 

#### Файл: *src/app/Core/ComponentsManager.php*
```
 
<?php
namespace Picrab\Core;

use ReflectionClass;
use ReflectionMethod;
use Exception;

class ComponentsManager
{
    public array $config;
    private array $components = [];

    public static $instance;

    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }



    private function __construct(array $config)
    {
        $this->config = $config;
        $this->initializeComponents();
    }

    private function initializeComponents()
    {
        $componentsConfig = $this->config['components'];
        foreach ($componentsConfig as $componentName => $componentSettings) {
            if (isset($componentSettings['class'])) {
                $class = $componentSettings['class'];
                $conf = $componentSettings['config'] ?? [];
                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $constructor = $reflection->getConstructor();
                    if ($constructor && $constructor->getNumberOfParameters() > 0) {
                        if (!$constructor->isPublic()) {
                            if (method_exists($class, 'getInstance')) {
                                $this->components[$componentName] = $class::getInstance($conf);
                                continue;
                            } else {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                        }
                        $parameters = [];
                        foreach ($constructor->getParameters() as $param) {
                            $paramType = $param->getType();
                            if ($paramType && !$paramType->isBuiltin()) {
                                $dependencyClass = $paramType->getName();
                                $dependency = $this->getDependency($dependencyClass);
                                if ($dependency) {
                                    $parameters[] = $dependency;
                                } else {
                                    throw new Exception("Unresolved dependency {$dependencyClass} for component {$componentName}");
                                }
                            } else {
                                $parameters[] = $conf[$param->getName()] ?? null;
                            }
                        }
                        $this->components[$componentName] = $reflection->newInstanceArgs($parameters);
                    } else {
                        if (method_exists($class, "getInstance")) {
                            $this->components[$componentName] = $class::getInstance($conf);
                        } else {
                            $constructorCheck = $reflection->getConstructor();
                            if ($constructorCheck && !$constructorCheck->isPublic()) {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                            $this->components[$componentName] = new $class($conf);
                        }
                    }
                }
            }
        }
    }

    private function getDependency(string $className)
    {
        foreach ($this->components as $component) {
            if ($component instanceof $className) {
                return $component;
            }
        }
        return null;
    }

    public function get(string $componentName)
    {
        return $this->components[$componentName] ?? null;
    }

    public function getAll(): array
    {
        return $this->components;
    }
} 
```
 

#### Файл: *src/app/Core/Config.php*
```
 
<?php
namespace Picrab\Core;

class Config
{
    private static $instance;
    private array $config;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function getInstance(array $config = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get(): array
    {
        return $this->config;
    }

    public function add(string $key, $value): array
    {
        $this->config[$key] = $value;
        return $this->config;
    }

    public function set(array $config): array
    {
        $this->config = $config;
        return $this->config;
    }
} 
```
 

#### Файл: *src/app/Core/Request.php*
```
 
<?php
namespace Picrab\Core;

class Request
{
    private string $method;
    private string $uri;
    private array $get;
    private array $post;
    private array $headers;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $this->get = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->headers = function_exists('getallheaders') ? getallheaders() : [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getGet(): array
    {
        return $this->get;
    }

    public function getPost(): array
    {
        return $this->post;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
} 
```
 

#### Файл: *src/app/Core/RouterBasic.php*
```
 
<?php
namespace Picrab\Core;

class RouterBasic
{
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getData(): array {
        $uri = $this->request->getUri() ?: '/index.php';
        $method = $this->request->getMethod() ?: 'GET';
        $get = $this->request->getGet();
        $data = [];
        $data['uri'] = $uri;
        $data['method'] = $method;
        $data['get']['id'] = $get['id'] ?? '1';
        $data['get']['action'] = $get['action'] ?? 'view';
        $data['get']['pagetype'] = $get['pagetype'] ?? 'main'; // Добавляем pagetype
        $data['is_admin'] = ($data['get']['pagetype'] === 'admin'); // Определяем, админская ли это страница
        $data['is_ajax'] = isset($_GET['ajax']) && $_GET['ajax'] === 'true'; // Определяем, AJAX ли это запрос
        return $data;
    }
}
 
```
 

#### Файл: *src/app/Core/Context.php*
```
 
<?php
namespace Picrab\Core;
class Context {
    public $renderer;
    public $db;
    public $modules;
    public $pageContent;
    public $currentTheme;

    public function __construct($renderer, $db, $modules, $pageContent, $currentTheme = 'default') {
        $this->renderer = $renderer;
        $this->db = $db;
        $this->modules = $modules;
        $this->pageContent = $pageContent;
        $this->currentTheme = $currentTheme;
    }
} 
```
 

#### Файл: *src/app/Core/Container.php*
```
 
<?php

namespace Picrab\Core;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    public function singleton(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = function ($container) use ($factory) {
            if (!isset($this->instances[$abstract])) {
                $this->instances[$abstract] = $factory($container);
            }
            return $this->instances[$abstract];
        };
    }

    public function get(string $abstract)
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $factory = $this->bindings[$abstract];
            return $factory($this);
        }

        throw new \RuntimeException("No binding found for {$abstract}");
    }
} 
```
 

#### Файл: *src/app/Core/init.php*
```
 
<?php
namespace Picrab\Core;

ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$helpersFiles = scandir(__DIR__ . "/helpers/");
unset($helpersFiles[0], $helpersFiles[1]);
foreach ($helpersFiles as $key => $helper){
    require_once __DIR__."/helpers/".$helper;
}

require __DIR__ . "/../../vendor/autoload.php";

$config = require __DIR__ . "/../config.php";

use Picrab\Components\Database\Database;
use Picrab\Components\ModulesManager\ModulesManager;
use Picrab\Components\Renderer\Renderer;

// Инициализация конфигурации
Config::getInstance($config);

// Старт сессии
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$request = new Request();
$response = new Response();
$router = new RouterBasic($request, $response);
$routerData = $router->getData();

$container = new \stdClass();
$container->request = $request;
$container->response = $response;
$container->router_data = $routerData;
$container->mainURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];

$componentsConfig = Config::getInstance()->get()['components'];
$dbConfig = $componentsConfig['database']['config'];
$db = Database::getInstance($dbConfig);
$container->db = $db;

$theme = $db->getCurrentTheme();
if (!$theme) {
    // Установка темы по умолчанию, если текущая не найдена
    $theme = 'default';
}

$componentsConfig['renderer']['config']['current_theme'] = $theme;
$container->themeAssets = "/themes/{$theme}/assets/";

$modulesManager = new ModulesManager($db);
$container->modulesManager = $modulesManager;

$pageId = $routerData['get']['id'] ?? 1;
$pageContent = $db->getPageContent($pageId);

$isAdmin = $routerData['is_admin'];

if (!$isAdmin && !$pageContent) {
    // Фронтенд: Перенаправление на 404, если контент отсутствует
    header("HTTP/1.0 404 Not Found");
    $pageContent = [
        'id' => 2,
        'title' => '404',
        'content' => '<h1>404 страница не найдена</h1>',
        'pageTypeSlug' => '404',
        'pageTypeID' => 2,
        'action' => 'view'
    ];
} elseif ($isAdmin && !$pageContent) {
    // Админка: Загрузка админской главной страницы, если контент отсутствует
    $pageContent = [
        'id' => 4,
        'title' => 'Админ-панель',
        'content' => '<h1>Админ-панель</h1>',
        'pageTypeSlug' => 'admin',
        'pageTypeID' => 3,
        'action' => 'view'
    ];
}

$pageAction = $routerData['get']['action'] ?? 'view';
$pageTypeData = $db->getPageType($pageId);
$pageTypeSlug = $pageTypeData['slug'] ?? 'main';
$pageTypeId = $pageTypeData['id'] ?? 1;

$container->pageContent = $pageContent;
$container->pageTypeId = $pageTypeId;
$container->pageTypeSlug = $pageTypeSlug;
$container->pageAction = $pageAction;

// Проверка на AJAX-запрос
if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    require_once __DIR__ . '/../../public/ajax_handler.php';
    exit;
}

$rendererConfig = $componentsConfig['renderer']['config'];
$modules = $modulesManager->loadModulesForPageType($pageTypeId);
$container->modules = $modules;

$globalConfig = [];
$globalConfig['core'] = $config['core'];
$globalConfig['current_page']['route'] = $routerData;
$globalConfig['current_page']['pageContent'] = $pageContent;
$globalConfig['current_page']['pageTypeID'] = $pageTypeId;
$globalConfig['current_page']['pageTypeSlug'] = $pageTypeSlug;
$globalConfig['current_page']['action'] = $pageAction;
$globalConfig['themeAssets'] = $container->themeAssets;
// Добавляем общие данные, чтобы не дублировать в каждом модуле
$globalConfig['db'] = $db;
$globalConfig['modules'] = $modules;
$globalConfig['pageContent'] = $pageContent;

$renderer = new Renderer($rendererConfig, $globalConfig);
$container->renderer = $renderer;

$context = new Context($renderer, $db, $modules, $pageContent, $renderer->currentTheme);
foreach ($modules as $m) {
    $m->setContext($context);
}

return $container;
 
```
 

#### Файл: *src/app/Core/Response.php*
```
 
<?php
namespace Picrab\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private string $body = '';

    public function setStatusCode(int $code): void {
        $this->statusCode = $code;
    }

    public function addHeader(string $header, string $value): void {
        $this->headers[$header] = $value;
    }

    public function setBody(string $content): void {
        $this->body = $content;
    }

    public function send(): void {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        echo $this->body;
    }

    public function notFound(string $data = ''): void {
        $this->setStatusCode(404);
        $this->setBody($data);
        $this->send();
    }

    public function json(array $data, int $statusCode = 200): void {
        $this->setStatusCode($statusCode);
        $this->addHeader('Content-Type', 'application/json');
        $this->setBody(json_encode($data));
        $this->send();
    }
}
 
```
 

#### Файл: *src/app/Core/helpers/debug.php*
```
 
<?php

function __dd($var, $array = false){
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($array){
        print_r($var);
    }else{
        var_dump($var);
    }
    echo "</pre></div>";
}

function __ddd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function __d($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

function __pe($msg, $exception = false){
    ob_start();
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($exception) throw new Exception($msg);
    echo $msg;
    echo "</pre></div>";
    return ob_get_clean();
} 
```
 

#### Файл: *src/app/Core/helpers/sanitaze.php*
```
 
<?php

function sanitaze($string){
    $string = filter_var(
        $string,
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
    $string = htmlspecialchars($string);
    return $string;
} 
```
 

#### Файл: *src/app/Core/langs/ru.php*
```
 
 
```
 

#### Файл: *src/app/Modules/FormConstructor/FormConstructor.php*
```
 
<?php
namespace Picrab\Modules\FormConstructor;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;
use Picrab\Components\FormConstructor\FormConstructor as FC;

class FormConstructor implements ModuleInterface {
    protected $context;
    private $formConstructor;

    public function __construct($db) {
        $this->formConstructor = new FC($db);
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $pageId = $this->context->pageContent['id'];
        $pageTypeId = $this->context->pageContent['pageTypeID'];
        $fieldsData = $this->formConstructor->getFieldsForPage($pageId, $pageTypeId);
        $template = $this->context->renderer->getThemePath() . "/modules/formconstructor/form.php";
        return $this->context->renderer->renderTemplate($template, [
            'fieldsData' => $fieldsData,
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }

    public function save($pageId, $data) {
        $this->formConstructor->saveFields($pageId, $data);
    }
} 
```
 

#### Файл: *src/app/Modules/Sidebar/Sidebar.php*
```
 
<?php
namespace Picrab\Modules\Sidebar;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Sidebar implements ModuleInterface {
    protected $context;

    public function __construct($db) {
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/sidebar/sidebar.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }
} 
```
 

#### Файл: *src/app/Modules/Footer/Footer.php*
```
 
<?php
namespace Picrab\Modules\Footer;
use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Footer implements ModuleInterface {
    protected $context;

    public function __construct($db) {
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/footer/footer.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }
} 
```
 

#### Файл: *src/app/Modules/Meta/Meta.php*
```
 
<?php
namespace Picrab\Modules\Meta;
use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Meta implements ModuleInterface {
    protected $context;

    public function __construct($db) {
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/meta/meta.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }

    public function footer($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/meta/footer.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }
} 
```
 

#### Файл: *src/app/Modules/Menu/Menu.php*
```
 
<?php
namespace Picrab\Modules\Menu;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Menu implements ModuleInterface
{
    protected $context;

    public function __construct($db)
    {
        // Конструктор оставляем пустым }
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {
        $userId = $_SESSION['auth_user_id'] ?? 0;
        $userInfo = null;
        if ($userId > 0) {
            $res = $this->context->db->query("SELECT username FROM `hGtv_users` WHERE id=? LIMIT 1", [$userId]);
            if ($res) {
                $userInfo = $res[0];
            }
        }

        $template = $this->context->renderer->getThemePath() . "/modules/menu/menu.php";
        return $this->context->renderer->renderTemplate($template, [
            'userInfo' => $userInfo]);
    }
} 
```
 

#### Файл: *src/app/Modules/Auth/Auth.php*
```
 
<?php
namespace Picrab\Modules\Auth;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;
use Picrab\Core\Config;

class Auth implements ModuleInterface
{
    protected $context;
    private $loginPageId = 3;
    private $adminMainPageId = 4;
    private $action;
    private $pageId;
    private $authCheck;
    private $user = null;
    private $pageType;
    private $error = null;
    private array $denied;
    private $db;
    private $rolePermissions = [];

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setConfig()
    {
        $this->authCheck = $this->isAuthenticated();
        $this->action = $this->context->renderer->globalConfig['current_page']['action'];
        $this->pageType = $this->context->renderer->globalConfig['current_page']['pageTypeID'];
        $this->pageId = $this->context->renderer->globalConfig['current_page']['pageContent']['id'];
        $this->denied = [3, 5];

        if ($this->authCheck) {
            $this->loadUserRolePermissions();
        }
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {
        // Метод render может быть пустым или содержать дополнительную логику
    }

    private function isAuthenticated(): bool
    {
        if(!empty($_SESSION['auth_user_id']) && is_int($_SESSION['auth_user_id'])){
            return true;
        }
        return false;
    }

    private function loadUserRolePermissions()
    {
        $userId = $_SESSION['auth_user_id'];
        $res = $this->db->query("SELECT role FROM `hGtv_users` WHERE id = ? LIMIT 1", [$userId]);
        if (!empty($res)) {
            $role = $res[0]['role'];
            $permissions = $this->db->query("SELECT module_id, permission FROM `hGtv_role_permissions` WHERE role = ?", [$role]);
            foreach ($permissions as $perm) {
                $this->rolePermissions[$perm['module_id']][] = $perm['permission'];
            }
        }
    }

    public function logoutAuthLink($renderModule = null, $params = [])
    {
        $this->dispatch();
        $userInfo = $this->getUser();
        $view = $this->authCheck ? 'logout' : 'profile';
        $template = $this->context->renderer->getThemePath() . "/modules/auth/" . $view . ".php";
        return $this->context->renderer->renderTemplate($template, ['user' => $this->user]);
    }

    public function loginForm($renderModule = null, $params = []){
        $this->dispatch();
        $params = ['error' => $this->error];
        $template = $this->context->renderer->getThemePath() . "/modules/auth/loginform.php";
        return $this->context->renderer->renderTemplate($template, $params);
    }

    private function getUser()
    {
        if(!empty($_SESSION)){
            $id = $_SESSION['auth_user_id'];
            $res = $this->db->query("SELECT * FROM `hGtv_users` WHERE `id` = ? LIMIT 1", [$id]);
            if(!empty($res)){
                $this->user = [
                    'id' => $res[0]['id'],
                    'login' => $res[0]['username'],
                    'role' => $res[0]['role']
                ];
                return true;
            }
            return false;
        }
        return false;
    }

    public function dispatch()
    {
        $this->setConfig();
        if(($this->action == "logout") && ($this->authCheck)){
            $_SESSION = [];
            session_destroy();
            header("Location: index.php?id=".$this->pageId);
            exit();
        }
        if($this->action === 'login' && !$this->authCheck && isset($_POST['username'], $_POST['password'])){
            $password = sanitaze($_POST['password']);
            $username = sanitaze($_POST['username']);
            $res = $this->db->query("SELECT * FROM `hGtv_users` WHERE `username` = ? LIMIT 1", [$username]);
            if(empty($res) || !$res){
                $this->error = 'Пользователя с таким логином не существует';
            }
            if(!empty($res) && $res){
                $dbPassword = $res[0]['password'];
                if(password_verify($password, $dbPassword)){
                    $_SESSION = [];
                    session_destroy();
                    session_start();
                    $_SESSION['auth_user_id'] = $res[0]['id'];
                    header("Location: index.php?id=".$this->adminMainPageId);
                    exit;
                }
                else{
                    $this->error = 'Неправильный пароль';
                }
            }
        }

        if(!$this->authCheck && in_array($this->pageType, $this->denied)){
            header("Location: index.php?id=".$this->loginPageId);
            exit;
        }

        if($this->authCheck && ($this->pageId == $this->loginPageId)){
            header("Location: index.php?id=".$this->adminMainPageId);
            exit;
        }

        // Дополнительная проверка прав доступа для админских страниц
        if ($this->authCheck && $this->pageTypeSlug === 'admin') {
            // Проверка наличия необходимых разрешений
            $requiredPermissions = ['view', 'edit']; // Пример разрешений
            $adminModules = $this->db->query("SELECT module_id FROM `hGtv_modules_pagetypes` WHERE pagetype_id = ?", [$this->pageTypeId]);
            foreach ($adminModules as $module) {
                $moduleId = $module['module_id'];
                foreach ($requiredPermissions as $perm) {
                    if (!isset($this->rolePermissions[$moduleId]) || !in_array($perm, $this->rolePermissions[$moduleId])) {
                        // Отсутствие разрешения, перенаправление на страницу без доступа
                        header("Location: index.php?id=".$this->loginPageId);
                        exit;
                    }
                }
            }
        }
    }
}
 
```
 

#### Файл: *src/app/Modules/Auth/AuthModel.php*
```
 
 
```
 

#### Файл: *src/app/Modules/Header/Header.php*
```
 
<?php
namespace Picrab\Modules\Header;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Header implements ModuleInterface
{

    protected $context;

    public function __construct($db)
    {
        // Конструктор можно оставить пустым }
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {
        $template = $this->context->renderer->getThemePath() . "/modules/header/header.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules]);
    }

} 
```
 

#### Файл: *src/app/Components/ModulesManager/ModuleInterface.php*
```
 
<?php
namespace Picrab\Components\ModulesManager;

use Picrab\Core\Context;

interface ModuleInterface {
    public function setContext(Context $context): void;
    public function render($renderModule = null, $params = []);
} 
```
 

#### Файл: *src/app/Components/ModulesManager/ModulesManager.php*
```
 
<?php
namespace Picrab\Components\ModulesManager;

use Picrab\Components\Database\Database;

class ModulesManager {
    private Database $db;
    private array $modules = [];

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function loadModulesForPageType(int $pageTypeId): array {
        $sql = "SELECT m.* FROM `hGtv_modules` m WHERE m.is_global =1 AND m.active =1 UNION SELECT m.* FROM `hGtv_modules_pagetypes` mp INNER JOIN `hGtv_modules` m ON mp.module_id = m.id WHERE mp.pagetype_id = ? AND m.active =1";
        $modulesData = $this->db->query($sql, [$pageTypeId]);
        foreach ($modulesData as $m) {
            $class = "Picrab\\Modules\\" . ucfirst($m['slug']) . "\\" . ucfirst($m['slug']);
            if (class_exists($class)) {
                $this->modules[$m['slug']] = new $class($this->db);
            }
        }
        return $this->modules;
    }

    public function getModule(string $slug) {
        return $this->modules[$slug] ?? null;
    }

    public function getAllModules(): array {
        return $this->modules;
    }
} 
```
 

#### Файл: *src/app/Components/FormConstructor/FormModel.php*
```
 
<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormModel
{
    private Database $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getGroupsForPage(int $pageId, int $pageTypeId): array
    {
        $sql = "SELECT fg.* FROM hGtv_form_page_relations pr 
                INNER JOIN hGtv_form_groups fg ON pr.group_id = fg.id
                WHERE pr.page_id = ? AND pr.pagetype_id = ?";
        return $this->db->query($sql, [$pageId, $pageTypeId]);
    }

    public function getFieldsForGroup(int $groupId): array
    {
        $sql = "SELECT * FROM hGtv_form_fields WHERE group_id = ?";
        return $this->db->query($sql, [$groupId]);
    }

    public function getValuesForPage(int $pageId): array
    {
        $sql = "SELECT fv.field_id, fv.value FROM hGtv_form_values fv WHERE fv.page_id = ?";
        $res = $this->db->query($sql, [$pageId]);
        $values = [];
        foreach ($res as $r) {
            $values[$r['field_id']] = $r['value'];
        }
        return $values;
    }

    public function saveValues(int $pageId, array $data): void
    {
        foreach ($data as $fieldId => $value) {
            $check = $this->db->query("SELECT id FROM hGtv_form_values WHERE field_id = ? AND page_id = ? LIMIT 1", [$fieldId, $pageId]);
            if ($check) {
                $this->db->execute("UPDATE hGtv_form_values SET value = ? WHERE id = ?", [$value, $check[0]['id']]);
            } else {
                $this->db->execute("INSERT INTO hGtv_form_values (field_id, page_id, value) VALUES (?, ?, ?)", [$fieldId, $pageId, $value]);
            }
        }
    }
} 
```
 

#### Файл: *src/app/Components/FormConstructor/FormDataStorage.php*
```
 
<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormDataStorage
{
    private FormModel $model;

    public function __construct(Database $db)
    {
        $this->model = new FormModel($db);
    }

    public function getFormData(int $pageId, int $pageTypeId): array
    {
        $groups = $this->model->getGroupsForPage($pageId, $pageTypeId);
        $values = $this->model->getValuesForPage($pageId);
        $result = [];
        foreach ($groups as $g) {
            $fields = $this->model->getFieldsForGroup($g['id']);
            $fArr = [];
            foreach ($fields as $f) {
                $fid = $f['id'];
                $fArr[] = [
                    'id' => $fid,
                    'name' => $f['name'],
                    'label' => $f['label'],
                    'type' => $f['type'],
                    'settings' => json_decode($f['settings'], true),
                    'value' => $values[$fid] ?? ''
                ];
            }
            $result[] = [
                'group_id' => $g['id'],
                'title' => $g['title'],
                'fields' => $fArr
            ];
        }
        return $result;
    }

    public function saveFormData(int $pageId, array $data): void
    {
        $this->model->saveValues($pageId, $data);
    }
} 
```
 

#### Файл: *src/app/Components/FormConstructor/AdminInterface.php*
```
 
<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class AdminInterface
{
    private FormModel $model;

    public function __construct(Database $db)
    {
        $this->model = new FormModel($db);
    }

    public function getGroups(): array
    {
        return $this->model->getGroupsForPage(0,0);
    }

    public function createGroup(string $title): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_groups (title) VALUES (?)", [$title]);
    }

    public function deleteGroup(int $id): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_groups WHERE id = ?", [$id]);
    }

    public function createField(int $groupId, string $name, string $label, string $type, array $settings = []): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_fields (group_id, name, label, type, settings) VALUES (?,?,?,?,?)", [$groupId, $name, $label, $type, json_encode($settings)]);
    }

    public function deleteField(int $id): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_fields WHERE id = ?", [$id]);
    }

    public function attachGroupToPage(int $pageId, int $pageTypeId, int $groupId): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_page_relations (page_id, pagetype_id, group_id) VALUES (?,?,?)", [$pageId, $pageTypeId, $groupId]);
    }

    public function detachGroupFromPage(int $relationId): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_page_relations WHERE id = ?", [$relationId]);
    }

    private function getDb()
    {
        $class = new \ReflectionClass($this->model);
        $prop = $class->getProperty('db');
        $prop->setAccessible(true);
        return $prop->getValue($this->model);
    }
} 
```
 

#### Файл: *src/app/Components/FormConstructor/FormConstructor.php*
```
 
<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormConstructor
{
    private FormDataStorage $storage;

    public function __construct(Database $db)
    {
        $this->storage = new FormDataStorage($db);
    }

    public function getFieldsForPage(int $pageId, int $pageTypeId): array
    {
        return $this->storage->getFormData($pageId, $pageTypeId);
    }

    public function saveFields(int $pageId, array $data): void
    {
        $formatted = [];
        foreach ($data as $fieldId => $value) {
            $formatted[$fieldId] = $value;
        }
        $this->storage->saveFormData($pageId, $formatted);
    }
} 
```
 

#### Файл: *src/app/Components/Database/Database.php*
```
 
<?php
namespace Picrab\Components\Database;

class Database {
    private static $instance;
    private static $dbObject;

    public static function getInstance(array $config): Database {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct(array $config) {
        $class = "Picrab\\Components\\Database\\" . $config['driver'] . "Database";
        self::$dbObject = new $class($config);
    }

    public function query(string $sql, array $params = []): array {
        return self::$dbObject->query($sql, $params);
    }

    public function execute(string $sql, array $params = []): bool {
        return self::$dbObject->execute($sql, $params);
    }

    public function getPageContent(int $id): array|false {
        $res = self::$dbObject->query("SELECT p.id, p.title, p.content, pt.slug FROM hGtv_pages p INNER JOIN hGtv_pages_pagetypes pp ON p.id = pp.page_id INNER JOIN hGtv_pagetypes pt ON pp.pagetype_id = pt.id WHERE p.id = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }

    public function getPageType(int $id): array|false {
        $res = self::$dbObject->query("SELECT pt.id, pt.slug FROM hGtv_pages_pagetypes pp INNER JOIN hGtv_pagetypes pt ON pp.pagetype_id = pt.id WHERE pp.page_id = ? LIMIT 1", [$id]);
        return $res[0] ?? false;
    }

    public function getCurrentTheme(): string|false {
        // Попытка получить текущую тему из таблицы настроек
        $res = self::$dbObject->query("SELECT value FROM hGtv_settings WHERE `key` = 'current_theme' LIMIT 1", []);
        if (!empty($res)) {
            return $res[0]['value'];
        }
        // Если нет, получить активную тему из таблицы тем
        $res = self::$dbObject->query("SELECT slug FROM hGtv_themes WHERE active = 1 LIMIT 1", []);
        return $res[0]['slug'] ?? false;
    }

    public function setCurrentTheme(string $themeSlug): bool {
        // Деактивировать все темы
        self::$dbObject->execute("UPDATE hGtv_themes SET active = 0", []);
        // Активировать выбранную тему
        $result = self::$dbObject->execute("UPDATE hGtv_themes SET active = 1 WHERE slug = ?", [$themeSlug]);
        if ($result) {
            // Обновить настройку текущей темы
            self::$dbObject->execute("INSERT INTO hGtv_settings (`key`, `value`) VALUES ('current_theme', ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)", [$themeSlug]);
            return true;
        }
        return false;
    }
}
 
```
 

#### Файл: *src/app/Components/Database/MysqlDatabase.php*
```
 
<?php
namespace Picrab\Components\Database;
use mysqli;

class MysqlDatabase implements DatabaseInterface
{
    private static string $host;
    private static string $dbname;
    private static string $user;
    private static string $password;
    private static mysqli $connect;

    public function __construct(array $config)
    {
        self::$host = $config['host'];
        self::$dbname = $config['dbname'];
        self::$user = $config['user'];
        self::$password = $config['password'];
        self::$connect = $this->connect(self::$password);
    }

    public function connect(string $password): mysqli
    {
        return new mysqli(self::$host, self::$user, $password, self::$dbname, 3306);
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = self::$connect->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?: [];
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = self::$connect->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        return $stmt->execute();
    }
} 
```
 

#### Файл: *src/app/Components/Database/DatabaseInterface.php*
```
 
<?php
namespace Picrab\Components\Database;

interface DatabaseInterface
{
    public function connect(string $password);
    public function query(string $sql, array $params = []): array;
    public function execute(string $sql, array $params = []): bool;
} 
```
 

#### Файл: *src/app/Components/Files/Files.php*
```
 
<?php

namespace Picrab\Components\Files;

class Files
{
    private array $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getFile($src)
    {

    }

} 
```
 

#### Файл: *src/app/Components/TaskQueue/TaskQueue.php*
```
 
<?php
namespace Picrab\Components\TaskQueue;

use Picrab\Components\Database\Database;

class TaskQueue {
    private Database $db;

    public function __construct($config = []) {
        $this->db = Database::getInstance($config);
    }

    public function addTask(string $type, array $payload = []) {
        $this->db->execute("INSERT INTO hGtv_worker_tasks (type, status, payload) VALUES (?, ?, ?)", [$type, 'pending', json_encode($payload)]);
    }

    public function getPendingTasks(): array {
        return $this->db->query("SELECT * FROM hGtv_worker_tasks WHERE status='pending' ORDER BY id ASC");
    }

    public function updateTaskStatus(int $id, string $status) {
        $this->db->execute("UPDATE hGtv_worker_tasks SET status=? WHERE id=?", [$status, $id]);
    }
} 
```
 

#### Файл: *src/app/Components/Renderer/Renderer.php*
```
 
<?php
namespace Picrab\Components\Renderer;

class Renderer
{
    public string $currentTheme;
    public array $globalConfig;

    public function __construct(array $config, $globalConfig = [])
    {
        $this->currentTheme = $config['current_theme'] ?? $config['default_theme_name'];
        $this->globalConfig = $globalConfig;
    }

    public function renderTemplate(string $templatePath, array $data = []): string {
        if (!file_exists($templatePath)) {
            return '';
        }
        extract($this->globalConfig);
        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function getThemePath(): string {
        return __DIR__ . "/../../Themes/" . $this->currentTheme;
    }
}
 
```
 

#### Файл: *src/app/config.php*
```
 
<?php
return [
    'core' => [
        'base_dir' => '/var/www/html',
        'default_lang' => 'ru',
        'default_timezone' => 'Europe/Moscow',
        'paths' => [
            'app_dir' => '/app/',
            'core_dir' => '/app/Core/',
            'helpers_dir' => '/app/Core/helpers/',
            'components_dir' => '/app/Components/',
            'modules_dir' => '/app/Modules/',
            'themes_dir' => '/app/Themes/',
            'public_dir' => '/public/',
            'storage_dir' => '/storage/'
        ]
    ],
    'components' => [
        'database' => [
            'class' => Picrab\Components\Database\Database::class,
            'config' => [
                'driver' => 'Mysql',
                'host' => 'database',
                'dbname' => 'default_db',
                'user' => 'root',
                'password' => '6rov1BATETbLWWNA',
                'salt' => 'hGtv_'
            ]
        ],
        'files' => [
            'class' => Picrab\Components\Files\Files::class,
            'config' => [
                'include_types' => [
                    'webp', 'png', 'jpg', 'jpeg', 'pdf'
                ]
            ]
        ],
        'renderer' => [
            'class' => Picrab\Components\Renderer\Renderer::class,
            'config' => [
                'default_theme_name' => 'default'
            ]
        ],
        'modulesManager' => [
            'class' => Picrab\Components\ModulesManager\ModulesManager::class,
            'config' => []
        ],
        'FormConstructor' => [
            'class' => Picrab\Components\FormConstructor\FormConstructor::class,
            'config' => []
        ],
        'taskQueue' => [
            'class' => Picrab\Components\TaskQueue\TaskQueue::class,
            'config' => []
        ],
    ]
];
 
```
 

#### Файл: *src/app/worker.php*
```
 
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$componentsConfig = $config['components'];
$dbConfig = $componentsConfig['database']['config'];

use Picrab\Components\Database\Database;

// Инициализация БД
$db = Database::getInstance($dbConfig);

while (true) {
    $tasks = $db->query("SELECT * FROM hGtv_worker_tasks WHERE status='pending' ORDER BY id ");

    foreach ($tasks as $task) {
        echo "Processing task #{$task['id']} of type {$task['type']} with payload: " . json_encode($task['payload']) . "\n";

        sleep(2);

        // Обновляем статус задачи на 'completed'
        $db->execute("UPDATE hGtv_worker_tasks SET status='completed' WHERE id=?", [$task['id']]);
        echo "Task #{$task['id']} completed.\n";
    }

    sleep(5);
} 
```
 

#### Файл: *src/public/ajax_handler.php*
```
 
<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';
$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;
$pageTypeId = $container->pageTypeId;
$pageTypeSlug = $container->pageTypeSlug;
$pageAction = $container->pageAction;

// Проверка, является ли запрос AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

// Получение данных из POST
$action = $_POST['action'] ?? '';
$data = $_POST['data'] ?? [];

// Определение обработчика действия
switch ($action) {
    case 'save_form':
        // Пример обработки сохранения формы через модуль FormConstructor
        if (isset($container->modules['FormConstructor'])) {
            $formModule = $container->modules['FormConstructor'];
            $formModule->save($pageContent['id'], $data);
            echo json_encode(['success' => true, 'message' => 'Форма успешно сохранена']);
            exit;
        }
        break;

    case 'load_form':
        if (isset($container->modules['FormConstructor'])) {
            $formModule = $container->modules['FormConstructor'];
            $formData = $formModule->render();
            echo json_encode(['success' => true, 'form' => $formData]);
            exit;
        }
        break;

    // Добавьте дополнительные действия по мере необходимости

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action']);
        exit;
}

// Если действие не обработано
http_response_code(400);
echo json_encode(['error' => 'Action not handled']);
exit;
 
```
 

#### Файл: *src/public/index.php*
```
 
<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../app/Core/init.php';

$renderer = $container->renderer;
$db = $container->db;
$pageContent = $container->pageContent;

$pageContent['pageTypeID'] = $container->pageTypeId;
$pageContent['pageTypeSlug'] = $container->pageTypeSlug;
$pageContent['action'] = $container->pageAction;

$template = $renderer->getThemePath() . "/pagetypes/" . $pageContent['pageTypeSlug'] . ".php";

echo $renderer->renderTemplate($template, [
    'id' => $pageContent['id'],
    'title' => $pageContent['title'],
    'content' => $pageContent['content'],
    'pageTypeID' => $pageContent['pageTypeID'],
    'pageTypeSlug' => $pageContent['pageTypeSlug'],
    'action' => $pageContent['action']
]); 
```
 

