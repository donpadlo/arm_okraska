-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2019 at 08:12 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokraska`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
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
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `dtcreate`, `model`, `number`, `fio`, `mobile`) VALUES
(2, '2019-10-10 15:31:29', 'ВАЗ 2105', 'А354ХА', 'Пупкин Фёдор', '8726873'),
(3, '2019-10-10 19:34:00', 'ТАЗ 2019', 'Х357ЕН', 'Забегайло Валентин', '297462780482');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - точки, 2 - заказы',
  `order_id` int(11) NOT NULL COMMENT 'id точек или заказов',
  `image` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `images`
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
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `car_id`, `painter_id`, `dtcreate`, `dtclose`, `status`, `comments`, `archive`) VALUES
(1, 3, 4, '2019-10-10 17:02:19', NULL, 0, '', 0),
(2, 2, 3, '2019-10-10 17:02:27', NULL, 2, '', 0),
(3, -1, -1, '2019-10-10 19:55:29', NULL, 0, '', 1),
(4, -1, -1, '2019-10-10 20:52:17', NULL, 0, '', 1),
(5, -1, -1, '2019-10-13 18:49:01', NULL, 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `painters`
--

CREATE TABLE `painters` (
  `id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fio` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL,
  `image` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `painters`
--

INSERT INTO `painters` (`id`, `dtcreate`, `fio`, `mobile`, `image`) VALUES
(1, '2019-10-10 11:15:07', 'Пупкин Василий', '+79212347594', ''),
(3, '2019-10-10 12:03:10', 'Дубровина Анастасия', '6868', ''),
(4, '2019-10-10 19:32:38', 'Сидоров ТИмофей', '9434883743', '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - работа, 2 - материалы 3 - запчасти',
  `amount` float NOT NULL,
  `cnt` float NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `payments`
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
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `coors` varchar(255) COLLATE utf8_bin NOT NULL,
  `comments` text COLLATE utf8_bin NOT NULL,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `order_id`, `coors`, `comments`, `photo`) VALUES
(1, 1, '[\"319\",\"46\"]', '', NULL),
(2, 1, '[\"223\",\"51\"]', '', '50800686.jpg'),
(3, 1, '[\"352\",\"87\"]', '', NULL),
(4, 1, '[\"122\",\"65\"]', '1221', '67352576.jpg'),
(5, 1, '[\"195\",\"81\"]', '', NULL),
(6, 1, '[\"288\",\"182\"]', '', NULL),
(7, 1, '[\"406\",\"191\"]', '', NULL),
(8, 1, '[\"131\",\"183\"]', '', NULL),
(9, 1, '[\"153\",\"307\"]', '', NULL),
(10, 1, '[\"361\",\"312\"]', '', NULL),
(11, 1, '[\"366\",\"176\"]', '', NULL),
(12, 1, '[\"263\",\"171\"]', '', NULL),
(13, 2, '[\"259\",\"173\"]', '', NULL),
(14, 2, '[\"312\",\"194\"]', '', NULL),
(15, 2, '[\"289\",\"142\"]', '', NULL),
(16, 2, '[\"126\",\"191\"]', '', NULL),
(17, 1, '[\"420\",\"299\"]', '', NULL),
(18, 2, '[\"420\",\"302\"]', '', NULL),
(19, 2, '[\"341\",\"35\"]', '', NULL),
(20, 2, '[\"129\",\"303\"]', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `painters`
--
ALTER TABLE `painters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `painters`
--
ALTER TABLE `painters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
