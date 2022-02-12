-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 12 2022 г., 18:45
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `date_insert` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `message`, `date_insert`, `title`, `image`) VALUES
(4, 11, 'testtesfas', '2022-02-12 16:50:29', 'test', NULL),
(5, 11, 'asdfasdf', '2022-02-12 16:52:38', 'test', NULL),
(6, 11, 'asdfasdf', '2022-02-12 16:52:51', 'test', NULL),
(17, 10, 'asdfasdf', '2022-02-12 18:26:27', 'test', NULL),
(21, 1, 'asdfasdf', '2022-02-12 18:43:22', 'asdfa', NULL),
(22, 1, 'asdf', '2022-02-12 18:43:26', 'asdf', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_insert` datetime NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `date_insert`, `password`, `admin`) VALUES
(1, 'Aleksandr', 'kav@gde.ru', '2022-01-26 23:28:59', 'b05d762d253cc98f12c2a9bad7cca85fa9aa9430', 1),
(4, 'Aleksandr', 'kav1@gde.ru', '2022-01-27 18:22:43', '3eaf7f9db9f37406f5c99ee07ee4578d6ea5e6da', NULL),
(5, 'some name', 'test@test.tst', '2022-01-27 18:27:01', '0df4905aa480b66493f41360b4723f548f12d886', NULL),
(6, 'some name', 'test1@test.tst', '2022-01-27 18:27:51', '0df4905aa480b66493f41360b4723f548f12d886', NULL),
(7, 'some name', 'test12@test.tst', '2022-01-27 18:28:09', '0df4905aa480b66493f41360b4723f548f12d886', NULL),
(8, 'some name112', 'test112@test.tst', '2022-01-27 18:38:46', 'e44222dc17b9ce88d5bcc1541e750410594a262c', NULL),
(10, 'Egor', 'alkirg@yandex.ru', '2022-02-12 16:28:14', 'b05d762d253cc98f12c2a9bad7cca85fa9aa9430', NULL),
(11, 'Egor1', 'alkirg1@yandex.ru', '2022-02-12 16:32:17', 'b05d762d253cc98f12c2a9bad7cca85fa9aa9430', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_uindex` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
