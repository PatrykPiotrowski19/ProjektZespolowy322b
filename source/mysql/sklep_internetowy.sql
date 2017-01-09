-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Sty 2017, 13:40
-- Wersja serwera: 5.7.9
-- Wersja PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep_internetowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `activation`
--

DROP TABLE IF EXISTS `activation`;
CREATE TABLE IF NOT EXISTS `activation` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `code` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_time` int(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `comment` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `product_quality` int(3) NOT NULL,
  `service_quality` int(3) NOT NULL,
  `speed_service` int(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `delivery_options`
--

DROP TABLE IF EXISTS `delivery_options`;
CREATE TABLE IF NOT EXISTS `delivery_options` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `nazwa_przesylki` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `koszt` float NOT NULL,
  `opcja` int(3) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_session`
--

DROP TABLE IF EXISTS `login_session`;
CREATE TABLE IF NOT EXISTS `login_session` (
  `ID` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_date` int(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
CREATE TABLE IF NOT EXISTS `password_reset` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(10) NOT NULL,
  `CODE` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `expiration_time` int(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `payment_status` int(3) NOT NULL DEFAULT '0',
  `buy_time` int(40) NOT NULL,
  `delivery_id` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments_products`
--

DROP TABLE IF EXISTS `payments_products`;
CREATE TABLE IF NOT EXISTS `payments_products` (
  `ID` int(30) NOT NULL AUTO_INCREMENT,
  `payment_id` int(30) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_cost` float NOT NULL,
  `product_count` int(20) NOT NULL,
  `commented` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pending_comments`
--

DROP TABLE IF EXISTS `pending_comments`;
CREATE TABLE IF NOT EXISTS `pending_comments` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `comment_token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `podkategoria_id` int(20) NOT NULL,
  `nazwa_produktu` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cena_produktu` float NOT NULL,
  `ilosc` int(20) NOT NULL,
  `opis` varchar(4096) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_image`
--

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `product_id` int(20) NOT NULL,
  `image_id` int(3) NOT NULL,
  `imagename` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `PASSWORD` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `SURNAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `DATE_OF_BIRTH` date DEFAULT NULL,
  `ADDRESS_TAB` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `ADDRESS_TAB2` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `POSTAL_CODE` varchar(10) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `CITY` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `registered` tinyint(1) DEFAULT '0',
  `account_type` int(3) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
