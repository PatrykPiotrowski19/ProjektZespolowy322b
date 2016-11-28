-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Lis 2016, 14:51
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
  `code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_time` int(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `activation`
--

INSERT INTO `activation` (`ID`, `user_id`, `code`, `expiration_time`) VALUES
(1, 2, 'jasdigas985saj89ast58', 39429200),
(2, 0, 'patryk92125a2a44703e98c359e5e7bf6db01b3a', 1479121725),
(3, 0, 'patryk92113202111cf90e7c816a472aaceb72b0', 1479121782),
(4, 34, 'patryk9211387cbdccd7c4f57001c682af769ef9', 1479121824),
(5, 35, 'yanush399e314b1b43706773153e7ef375fc68c5', 1479122086),
(6, 43, 'diedope20568692db622456cc42a2e853ca21f89', 1480273977),
(7, 44, 'utasktame1a0d53a534014217b7961d1870ee76b', 1480274587),
(15, 52, 'kamil49596a5705f4d9c0867ea0aba3be5db5677', 1480361089),
(16, 53, 'uzytkok34944ba20ccf432f83a48b0879149ea2d', 1480853627),
(10, 0, 'diedope438ce5d989374d216a867cdc8871484b4', 1480274970),
(17, 55, 'paryksmsd24110aad582c07b5b3c8a978dd167c6', 1480859242);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`ID`, `name`, `description`) VALUES
(1, 'Urządzenia mobilne', 'Urządzenia mobilne'),
(2, 'Komputery', 'Komputery');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `password_reset`
--

INSERT INTO `password_reset` (`ID`, `USER_ID`, `CODE`, `expiration_time`) VALUES
(18, 28, '99a57cbf9929486ac2e6f630447cc6f2200', 1479717852);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `product`
--

INSERT INTO `product` (`ID`, `podkategoria_id`, `nazwa_produktu`, `cena_produktu`, `ilosc`, `opis`) VALUES
(1, 1, 'Sony Xperia M', 529.22, 10, 'Sony Xperia M to smartfon ze średniej półki z 4-calowym ekranem o rozdzielczości 854x480 pikseli. Dostępny jest w dwóch wariantach - z obsługą jednej lub dwóch kart SIM. Telefon działa w oparciu o Android 4.1 Jelly Bean. Posiada 4 GB wbudowanej pamięci flash, którą można rozszerzyć za pomocą kart microSD o dodatkowe 32 GB. Aparat ma rozdzielczość 5 Mpx i umożliwia kręcenie filmów HD. Jest też przednia kamera. Telefon dostępny będzie w czterech kolorach: czarnym, białym, purpurowym oraz limonowym.'),
(2, 1, 'Microsoft Lumia 950', 1289, 30, 'Zaawansowane funkcje, stylowy wygląd i najlepsze zalety systemu Windows 10 – kup telefon, który działa jak komputer i przemień zwykłą chwilę w swoje najważniejsze osiągnięcie.'),
(3, 1, 'Samsung Galaxy S5', 1900, 10, 'Tak'),
(4, 1, 'Test3', 12.99, 15, 'Test3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_image`
--

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `product_id` int(20) NOT NULL,
  `image_id` int(3) NOT NULL,
  `imagename` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `product_image`
--

INSERT INTO `product_image` (`ID`, `product_id`, `image_id`, `imagename`) VALUES
(1, 1, 1, '1_01.png'),
(2, 1, 2, '1_02.png'),
(3, 1, 3, '1_03.png'),
(4, 1, 4, '1_04.png'),
(5, 2, 1, '2_01.png'),
(6, 3, 1, '3_01.png'),
(7, 4, 1, '1_01.png');

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `subcategory`
--

INSERT INTO `subcategory` (`ID`, `category_id`, `name`) VALUES
(1, 1, 'Telefony komórkowe'),
(2, 1, 'Tablety'),
(7, 2, 'Komputery stacjonarne'),
(8, 2, 'Laptopy');

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
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`, `registered`, `account_type`) VALUES
(21, 'januksaif', '21232f297a57a5a743894a0e4a801fc3', 'das', 'das', NULL, 'dsa', NULL, 'das', 'da', 0, 0),
(22, 'Admin', 'f1a75b22ba29ed10d1dc24b82efe80b7', 'admin', 'admin', NULL, 'Admin', 'Admin', 'Admin', 'Admin', 1, 1),
(23, 'Januszek192', 'f1a75b22ba29ed10d1dc24b82efe80b7', 'faskifas', 'fasmigsa', NULL, 'fasfiasf9a', NULL, 'fsakfasmif', 'fasifasf9saf', 0, 0),
(27, 'matik12', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Łukasz', 'Miastko', NULL, 'Nowa', 'mail@wp.pl', '12-345', 'Miasteczko', 0, 0),
(25, 'patryk191129', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa 12', 'patryk.piotrowski19@gmail.com', '77-420', 'Lipka', 1, 0),
(28, 'cortez191', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryko', 'mfsafk', NULL, 'Ksaima', 'patryk191129@gmail.com', '22-394', 'Miskam', 0, 0),
(29, 'cortez1911', 'c3b48a5c20b1cba52fbb55792f29d25d', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'mateusz@wp.pl', '77-420', 'Lipka', 0, 0),
(30, 'patryk92', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.191129@gmail.com', '77-420', 'Lipka', 0, 0),
(31, 'patryk921', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.19112.9@gmail.com', '77-420', 'Lipka', 0, 0),
(32, 'patryk9212', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'pa.tryk.19112.9@gmail.com', '77-420', 'Lipka', 0, 0),
(33, 'patryk9211', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'pa.tr.yk.19112.9@gmail.com', '77-420', 'Lipka', 0, 0),
(34, 'patryk92113', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.a.tr.yk.19112.9@gmail.com', '77-420', 'Lipka', 0, 0),
(35, 'yanush3', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.piotr.ows.ki19@gmail.com', '77-420', 'Lipka', 0, 0),
(36, 'partyk3', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.piotrow.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(37, 'partyk34', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.atryk.piotrow.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(38, 'partyk342', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.atryk.piot.row.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(39, 'partyk3421', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.atr.yk.piot.row.ski1.9@gmail.com', '77-420', 'Lipka', 1, 0),
(40, 'partyk34213', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.5atr.yk.piot.row.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(41, 'partyk342133', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.5atr.yk.pi5ot.row.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(42, 'partyk3554', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'p.5atr.5yk.pi5ot.row.ski1.9@gmail.com', '77-420', 'Lipka', 0, 0),
(43, 'diedope', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'fajno@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0),
(44, 'utasktam', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Janus', 'Janusz', NULL, 'fakifw', 'ksairt@cortez.szczecin.pl', '00-000', 'Miasto', 0, 0),
(45, 'utasktam3', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Janus', 'Janusz', NULL, 'fakifw', 'ksbairt@cortez.szczecin.pl', '00-000', 'Miasto', 1, 0),
(46, 'diedope4', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'fa3jno@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0),
(47, 'diedope43', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'fa3jn4o@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0),
(48, 'diedope92', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patryk', NULL, 'fask', 'jacek@cortez.szczecin.pl', '00-112', 'Miasto', 0, 0),
(49, 'diedope921', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patryk', NULL, 'fask', 'jac3ek@cortez.szczecin.pl', '00-112', 'Miasto', 0, 0),
(50, 'diedope121', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Patryk', NULL, 'fask', 'ja1c3ek@cortez.szczecin.pl', '00-112', 'Miasto', 0, 0),
(51, 'utasktam31', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Janus', 'Janusz', NULL, 'fakifw', 'ksba1irt@cortez.szczecin.pl', '00-000', 'Miasto', 0, 0),
(52, 'kamil49', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa 12', 'fkasfifw@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0),
(53, 'uzytkok34', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'patryk.piot.row.ski19@gmail.com', '77-420', 'Lipka', 0, 0),
(54, 'paryksm', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'dsakit@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0),
(55, 'paryksms', '76a35109ab2f8b9ada6b9aed66ba7cc8', 'Patryk', 'Piotrowski', NULL, 'Gajowa', 'dsa4kit@cortez.szczecin.pl', '77-420', 'Lipka', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
