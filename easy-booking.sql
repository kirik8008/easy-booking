-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 19 2018 г., 13:05
-- Версия сервера: 10.1.33-MariaDB
-- Версия PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `easy-booking`
--

-- --------------------------------------------------------

--
-- Структура таблицы `BOOKING`
--

CREATE TABLE `BOOKING` (
  `RESERVATION_NUMBER` int(6) NOT NULL,
  `DATE` varchar(100) NOT NULL,
  `TIME` varchar(100) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `MIDDLENAME` varchar(255) NOT NULL,
  `PHONE` varchar(200) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `NOTE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `CONFIG`
--

CREATE TABLE `CONFIG` (
  `KEY_CONFIG` varchar(100) NOT NULL,
  `VALUE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `DATETIME`
--

CREATE TABLE `DATETIME` (
  `ID` int(6) NOT NULL,
  `DATE` varchar(100) NOT NULL,
  `TIME` varchar(100) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `RESERVATION_NUMBER` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `BOOKING`
--
ALTER TABLE `BOOKING`
  ADD PRIMARY KEY (`RESERVATION_NUMBER`);

--
-- Индексы таблицы `CONFIG`
--
ALTER TABLE `CONFIG`
  ADD PRIMARY KEY (`KEY_CONFIG`);

--
-- Индексы таблицы `DATETIME`
--
ALTER TABLE `DATETIME`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `DATETIME`
--
ALTER TABLE `DATETIME`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
