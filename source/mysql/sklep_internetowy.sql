
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 21 Lis 2016, 19:28
-- Wersja serwera: 10.0.22-MariaDB
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `u400782733_mymyr`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `activation`
--

CREATE TABLE IF NOT EXISTS `activation` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `code` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_time` int(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `activation`
--

INSERT INTO `activation` (`ID`, `user_id`, `code`, `expiration_time`) VALUES
(1, 2, 'jasdigas985saj89ast58', 39429200),
(2, 0, 'patryk92125a2a44703e98c359e5e7bf6db01b3a', 1479121725),
(3, 0, 'patryk92113202111cf90e7c816a472aaceb72b0', 1479121782),
(4, 34, 'patryk9211387cbdccd7c4f57001c682af769ef9', 1479121824),
(5, 35, 'yanush399e314b1b43706773153e7ef375fc68c5', 1479122086),
(6, 39, 'diedope2cbc82bed036134f08f6c26c0cce9892f', 1480274224);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`ID`, `name`, `description`) VALUES
(1, 'Produkty', 'Produkty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_session`
--

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

CREATE TABLE IF NOT EXISTS `password_reset` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(10) NOT NULL,
  `CODE` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `expiration_time` int(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Zrzut danych tabeli `password_reset`
--

INSERT INTO `password_reset` (`ID`, `USER_ID`, `CODE`, `expiration_time`) VALUES
(18, 25, '24e8db5044590f38542d093c2f44f1326123', 1479795537),
(19, 25, '9a6dfb3450f8373e9bc5953031afd75a9612', 1479795585);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ID` int(30) NOT NULL AUTO_INCREMENT,
  `subcategory_id` int(30) NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cost` float NOT NULL,
  `image` blob NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Zrzut danych tabeli `subcategory`
--

INSERT INTO `subcategory` (`ID`, `category_id`, `name`) VALUES
(1, 1, 'Elektronika'),
(2, 1, 'Motoryzacja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

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
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`, `registered`) VALUES
(21, 'januksaif', '21232f297a57a5a743894a0e4a801fc3', 'das', 'das', NULL, 'dsa', NULL, 'das', 'da', 0),
(22, 'admin123', '0192023a7bbd73250516f069df18b500', 'siakfi', 'f9akr9', NULL, 'fmisafmias', NULL, 'fasmifasi', 'fasmifasf', 0),
(23, 'Januszek192', 'f1a75b22ba29ed10d1dc24b82efe80b7', 'faskifas', 'fasmigsa', NULL, 'fasfiasf9a', NULL, 'fsakfasmif', 'fasifasf9saf', 0),
(27, 'matik12', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Łukasz', 'Miastko', NULL, 'Nowa', 'mail@wp.pl', '12-345', 'Miasteczko', 0),
(25, 'patryk191129', 'd6b083ce6ef319c05b3e62d9a9a457c6', 'Patryk', 'Piotrowski', NULL, 'Gajowa 12', 'patryk.piotrowski19@gmail.com', '77-420', 'Lipka', 0),
(28, 'cortez191', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryko', 'mfsafk', NULL, 'Ksaima', 'patryk191129@gmail.com', '22-394', 'Miskam', 0),
(29, 'cortez1911', 'c3b48a5c20b1cba52fbb55792f29d25d', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'mateusz@wp.pl', '77-420', 'Lipka', 0),
(30, 'patryk92', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.191129@gmail.com', '77-420', 'Lipka', 0),
(31, 'patryk921', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.19112.9@gmail.com', '77-420', 'Lipka', 0),
(32, 'patryk9212', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'pa.tryk.19112.9@gmail.com', '77-420', 'Lipka', 0),
(33, 'patryk9211', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'pa.tr.yk.19112.9@gmail.com', '77-420', 'Lipka', 0),
(34, 'patryk92113', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.a.tr.yk.19112.9@gmail.com', '77-420', 'Lipka', 0),
(35, 'yanush3', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.piotr.ows.ki19@gmail.com', '77-420', 'Lipka', 0),
(36, 'damiandamian', 'fa736a45fa5c935232bb541808b1196d', 'Damian', 'Raniewicz', NULL, 'Leśna 31', 'razor11991@gmail.com', '72-315', 'Resko', 0),
(37, 'damian1', 'fa736a45fa5c935232bb541808b1196d', 'Damian', 'Raniewicz', NULL, 'Leśna', 'razor1199@gmail.com', '72-315', 'Resko', 0),
(38, 'diedope', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patrykowski', NULL, 'Tak', 'fajno@cortez.szczecin.pl', '00-000', 'Miasto', 0),
(39, 'diedope2', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patrykowski', NULL, 'Tak', 'fajno2@cortez.szczecin.pl', '00-000', 'Miasto', 0),
(40, 'regist23', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patryk', NULL, 'Adres9', 'patryk1@cortez.szczecin.pl', '00-111', 'Miasto', 1),
(41, 'awalkowski', 'c54156244e0b8ebb1cb4394d87e2edfd', 'asdswe', 'aadawewqr', NULL, 'afqewrqw', 'walkowski.aleksander@gmail.com', '32-123', 'asdqwqw', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
