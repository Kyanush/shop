-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 20 2019 г., 14:38
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `onepoint`
--

-- --------------------------------------------------------

--
-- Структура таблицы `t_statuses`
--

CREATE TABLE `t_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `where_use` varchar(20) NOT NULL,
  `default` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `t_statuses`
--

INSERT INTO `t_statuses` (`id`, `name`, `class`, `where_use`, `default`, `sort`) VALUES
(1, 'Новый', ' fa fa-plus-square status-new', 'callbacks_status_id', 1, 1),
(2, 'Заказал', 'fa fa-check-circle status-completed', 'callbacks_status_id', 0, 2),
(3, 'Не заказал', 'fa fa-ban status-canceled', 'callbacks_status_id', 0, 3),
(4, 'Оформление заказа', '', 'orders_type', 0, 1),
(5, 'Купить в 1 клик', '', 'orders_type', 0, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `t_statuses`
--
ALTER TABLE `t_statuses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `t_statuses`
--
ALTER TABLE `t_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
