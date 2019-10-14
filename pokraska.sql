-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Окт 14 2019 г., 17:56
-- Версия сервера: 5.7.27-0ubuntu0.18.04.1
-- Версия PHP: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pokraska`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `model` varchar(100) COLLATE utf8_bin NOT NULL,
  `number` varchar(100) COLLATE utf8_bin NOT NULL,
  `fio` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `dtcreate`, `model`, `number`, `fio`, `mobile`) VALUES
(2, '2019-10-10 15:31:29', 'ВАЗ 2105', 'А354ХА', 'Пупкин Фёдор', '8726873'),
(3, '2019-10-10 19:34:00', 'ТАЗ 2019', 'Х357ЕН', 'Забегайло Валентин', '297462780482'),
(4, '2019-10-14 14:34:32', '4', 'r234', '43r34', 'rw4rw3');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - точки, 2 - заказы',
  `order_id` int(11) NOT NULL COMMENT 'id точек или заказов',
  `image` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `type`, `order_id`, `image`) VALUES
(1, 2, 1, '33121036.jpg'),
(2, 2, 1, '22127054.jpg'),
(3, 2, 1, '17543247.png'),
(4, 2, 1, '87205461.png'),
(5, 2, 1, '51468080.png'),
(6, 2, 2, '50880182.png'),
(7, 2, 2, '80766607.jpg'),
(8, 2, 2, '52747740.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `painter_id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtclose` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - новый 1 - в работе 2- законечен не оплачен 3 - закрыт',
  `comments` text COLLATE utf8_bin NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - активный, 1 - в архиве'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `car_id`, `painter_id`, `dtcreate`, `dtclose`, `status`, `comments`, `archive`) VALUES
(1, 3, 4, '2019-10-10 17:02:19', NULL, 0, '', 0),
(2, 2, 3, '2019-10-10 17:02:27', NULL, 2, '', 0),
(3, -1, -1, '2019-10-10 19:55:29', NULL, 0, '', 1),
(4, -1, -1, '2019-10-10 20:52:17', NULL, 0, '', 1),
(5, -1, -1, '2019-10-13 18:49:01', NULL, 0, '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `painters`
--

CREATE TABLE `painters` (
  `id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fio` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL,
  `image` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `painters`
--

INSERT INTO `painters` (`id`, `dtcreate`, `fio`, `mobile`, `image`) VALUES
(1, '2019-10-10 11:15:07', 'Пупкин Василий', '+79212347594', ''),
(3, '2019-10-10 12:03:10', 'Дубровина Анастасия', '6868', ''),
(4, '2019-10-10 19:32:38', 'Сидоров ТИмофей', '9434883743', '');

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '2 - материалы 3 - запчасти',
  `amount` float NOT NULL,
  `cnt` float NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `type`, `amount`, `cnt`, `comment`) VALUES
(1, 1, 1, 1.3, 2, 'www'),
(2, 1, 1, 100, 3, 'test'),
(3, 1, 2, 200, 1, 'Муфта'),
(4, 1, 2, 2000, 1, 'полуось'),
(5, 1, 3, 400, 1, 'Краска'),
(6, 1, 3, 250, 10, 'Пыво и сухарики');

-- --------------------------------------------------------

--
-- Структура таблицы `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `coors` varchar(255) COLLATE utf8_bin NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `cnt` int(11) NOT NULL DEFAULT '1',
  `comment` text COLLATE utf8_bin NOT NULL,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `points`
--

INSERT INTO `points` (`id`, `order_id`, `coors`, `amount`, `cnt`, `comment`, `photo`) VALUES
(1, 1, '[\"319\",\"46\"]', 0, 1, '', NULL),
(2, 1, '[\"223\",\"51\"]', 0, 1, '', '50800686.jpg'),
(3, 1, '[\"352\",\"87\"]', 0, 1, '', NULL),
(4, 1, '[\"122\",\"65\"]', 222, 1, '1221', '67352576.jpg'),
(5, 1, '[\"195\",\"81\"]', 0, 1, '1111111111', NULL),
(6, 1, '[\"288\",\"182\"]', 0, 1, '', NULL),
(7, 1, '[\"406\",\"191\"]', 0, 1, '', NULL),
(8, 1, '[\"131\",\"183\"]', 500, 1, '', NULL),
(9, 1, '[\"153\",\"307\"]', 0, 1, '', NULL),
(10, 1, '[\"361\",\"312\"]', 0, 1, '', NULL),
(11, 1, '[\"366\",\"176\"]', 0, 1, '', NULL),
(12, 1, '[\"263\",\"171\"]', 0, 1, '', NULL),
(13, 2, '[\"259\",\"173\"]', 0, 1, '', NULL),
(14, 2, '[\"312\",\"194\"]', 0, 1, '', NULL),
(15, 2, '[\"289\",\"142\"]', 0, 1, '', NULL),
(16, 2, '[\"126\",\"191\"]', 0, 1, '', NULL),
(17, 1, '[\"420\",\"299\"]', 700, 1, '12wde  w', NULL),
(18, 2, '[\"420\",\"302\"]', 0, 1, '', NULL),
(19, 2, '[\"341\",\"35\"]', 0, 1, '', NULL),
(20, 2, '[\"129\",\"303\"]', 22, 1, '222', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `painters`
--
ALTER TABLE `painters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `painters`
--
ALTER TABLE `painters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
