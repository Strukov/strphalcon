-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 01 2016 г., 11:39
-- Версия сервера: 5.5.45
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `strphalcon`
--

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `middle_name` varchar(250) DEFAULT NULL COMMENT 'middle name',
  `last_name` varchar(250) DEFAULT NULL COMMENT 'last name',
  `post` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `home_phone` varchar(30) DEFAULT NULL,
  `description` text,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_coordinates` (`lft`,`rgt`,`root`),
  KEY `employee_root` (`root`),
  KEY `employee_lft` (`lft`),
  KEY `employee_lft_root` (`lft`,`root`),
  KEY `employee_rgt` (`rgt`),
  KEY `employee_rgt_root` (`rgt`,`root`),
  KEY `employee_level` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `name`, `middle_name`, `last_name`, `post`, `email`, `phone`, `home_phone`, `description`, `root`, `lft`, `rgt`, `level`) VALUES
(1, 'root', '', '', 'root', 'root@gmail.com', '', '', '', NULL, 1, 8, 1),
(20, 'Devid', '', '', 'director', 'director@gmail.com', '', '', '', 1, 2, 7, 2),
(21, 'Rijard', '', '', 'chief programmer', 'Rijard@gmail.com', '', '', '', 20, 3, 4, 3),
(22, 'John', '', '', 'php developer', 'John@gmail.com', '', '', '', 20, 5, 6, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
