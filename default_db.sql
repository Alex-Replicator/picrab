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
