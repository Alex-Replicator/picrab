-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: database:3306
-- Время создания: Дек 17 2024 г., 08:31
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
(6, 'Тайный модуль удаленный', 'secret', '2024-12-12 15:47:15', 0, '0.0.1', '{}', 0);

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
(1, 3),
(1, 4),
(1, 5),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5);

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
(1, 'Главная', '<h1>Это главная</h1>'),
(404, '404', '<h1>404 страница не найдена</h1>');

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
(2, 404, 2);

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
(5, 'Редактирование', 'update', 1);

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
(1, 'PiCrab Default', 'Тема по умолчанию', '0.0.1', 'default', 0),
(2, 'Metronic', 'Описание темы', '0.0.1', 'Metronic', 1);

--
-- Индексы сохранённых таблиц
--

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
-- Индексы таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `hGtv_modules`
--
ALTER TABLE `hGtv_modules`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages`
--
ALTER TABLE `hGtv_pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT для таблицы `hGtv_pages_pagetypes`
--
ALTER TABLE `hGtv_pages_pagetypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `hGtv_pagetypes`
--
ALTER TABLE `hGtv_pagetypes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `hGtv_themes`
--
ALTER TABLE `hGtv_themes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `hGtv_modules_pagetypes`
--
ALTER TABLE `hGtv_modules_pagetypes`
  ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `hGtv_modules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hGtv_modules_pagetypes_ibfk_2` FOREIGN KEY (`pagetype_id`) REFERENCES `hGtv_pagetypes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
