-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Paź 2016, 16:01
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
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(30) NOT NULL,
  `PASSWORD` varchar(40) NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `SURNAME` varchar(30) DEFAULT NULL,
  `DATE_OF_BIRTH` date DEFAULT NULL,
  `ADDRESS_TAB` varchar(200) DEFAULT NULL,
  `ADDRESS_TAB2` varchar(200) DEFAULT NULL,
  `POSTAL_CODE` varchar(10) DEFAULT NULL,
  `CITY` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`) VALUES
(21, 'januksai', 'fd460ace781e7dc3991f9c139802d61d', 'das', 'das', NULL, 'dsa', NULL, 'das', 'da');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
