-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Pon 18. pro 2017, 00:49
-- Verze serveru: 5.7.19
-- Verze PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `sp`
--
CREATE DATABASE IF NOT EXISTS `sp` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `sp`;

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--
-- Vytvořeno: Ned 17. pro 2017, 13:49
-- Poslední změna: Pon 18. pro 2017, 00:48
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `a_name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `a_abstract` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `a_filename` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `a_state` int(11) NOT NULL DEFAULT '4',
  `a_exist` tinyint(1) NOT NULL DEFAULT '1',
  `a_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_article`),
  KEY `set_state` (`a_state`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka prispevku v konferenci';

--
-- Vyprázdnit tabulku před vkládáním `articles`
--

TRUNCATE TABLE `articles`;
--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`id_article`, `id_user`, `a_name`, `a_abstract`, `a_filename`, `a_state`, `a_exist`, `a_date`) VALUES
(1, 2, 'Pojednani o jahodove zmrzline', 'Jahodova zmrzlina', 'zmrzlina.pdf', 3, 1, '2017-12-03 22:00:45'),
(2, 2, 'Recept na citronovou limonádu', 'Prastarý recept, jak si doma utvořit tuto vzácnou pochutinu', 'citronada.pdf', 1, 1, '2017-12-03 22:00:45'),
(3, 2, 'Hromadný odchod do exilu', 'Článek pojednává o hromadném odchodu občanů jisté země do naprostého exilu.', 'test2.pdf', 4, 1, '2017-12-14 18:27:56'),
(4, 8, 'Nokia 3310', 'Nejlepší telefon vesmíru', '3310.pdf', 2, 0, '2017-12-16 22:19:28'),
(5, 7, 'Sony-Ericsson K770i', 'Fotomobil? Jedině přístroj od SONY-Ericsson', 'SEk770i.pdf', 2, 1, '2017-12-16 22:19:28'),
(6, 9, 'Bosch 509e', 'Německý robustní telefon', 'bosch509e.pdf', 1, 1, '2017-12-16 22:19:28'),
(7, 10, 'iPhone 3g', 'Opravdový dotykáč!', 'iPhone36.pdf', 2, 1, '2017-12-16 22:19:28'),
(8, 11, 'Xiaomi Mi A1', 'Čínský zázrak přichází i do vašich kapes', 'xiaomiA1.pdf', 2, 1, '2017-12-16 22:19:28');

-- --------------------------------------------------------

--
-- Struktura tabulky `evaluation`
--
-- Vytvořeno: Ned 17. pro 2017, 18:34
-- Poslední změna: Pon 18. pro 2017, 00:31
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id_eval` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `a_expertise` int(11) DEFAULT NULL,
  `a_length` int(11) DEFAULT NULL,
  `a_quality` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_eval`),
  KEY `id_user` (`id_user`) USING BTREE,
  KEY `id_article` (`id_article`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Hodnoceni clanku - odbornost, delka, kvalita zpracovani';

--
-- Vyprázdnit tabulku před vkládáním `evaluation`
--

TRUNCATE TABLE `evaluation`;
--
-- Vypisuji data pro tabulku `evaluation`
--

INSERT INTO `evaluation` (`id_eval`, `id_user`, `id_article`, `a_expertise`, `a_length`, `a_quality`) VALUES
(1, 3, 1, 6, 3, 2),
(5, 7, 8, NULL, NULL, NULL),
(9, 10, 7, NULL, NULL, NULL),
(11, 7, 1, NULL, NULL, NULL),
(12, 7, 1, NULL, NULL, NULL),
(14, 3, 8, 2, 3, 1),
(16, 3, 5, 6, 4, 8),
(17, 7, 1, NULL, NULL, NULL),
(18, 4, 1, NULL, NULL, NULL),
(19, 7, 1, NULL, NULL, NULL),
(20, 5, 7, NULL, NULL, NULL),
(24, 10, 8, NULL, NULL, NULL),
(25, 2, 4, NULL, NULL, NULL),
(26, 2, 7, NULL, NULL, NULL),
(27, 7, 6, NULL, NULL, NULL),
(28, 5, 6, NULL, NULL, NULL),
(29, 10, 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `rights`
--
-- Vytvořeno: Ned 03. pro 2017, 20:21
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id_right` int(11) NOT NULL AUTO_INCREMENT,
  `r_type` varchar(25) COLLATE utf8_czech_ci NOT NULL COMMENT 'Typ uzivatelskych prav',
  PRIMARY KEY (`id_right`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka s typy uzivatelskymi pravy uzivatelu';

--
-- Vyprázdnit tabulku před vkládáním `rights`
--

TRUNCATE TABLE `rights`;
--
-- Vypisuji data pro tabulku `rights`
--

INSERT INTO `rights` (`id_right`, `r_type`) VALUES
(1, 'visitor'),
(2, 'author'),
(3, 'reviewer'),
(4, 'administrator');

-- --------------------------------------------------------

--
-- Struktura tabulky `states`
--
-- Vytvořeno: Ned 03. pro 2017, 20:21
-- Poslední změna: Sob 16. pro 2017, 22:44
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id_state` int(11) NOT NULL AUTO_INCREMENT,
  `s_type` varchar(20) COLLATE utf8_czech_ci NOT NULL COMMENT 'Typ stavu clanku',
  PRIMARY KEY (`id_state`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka s moznymi stavy vlozenych clanku';

--
-- Vyprázdnit tabulku před vkládáním `states`
--

TRUNCATE TABLE `states`;
--
-- Vypisuji data pro tabulku `states`
--

INSERT INTO `states` (`id_state`, `s_type`) VALUES
(1, 'accepted'),
(2, 'reviewed'),
(3, 'rejected'),
(4, 'uploaded');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--
-- Vytvořeno: Úte 12. pro 2017, 19:15
-- Poslední změna: Ned 17. pro 2017, 23:50
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `nick` varchar(20) COLLATE utf8_czech_ci NOT NULL COMMENT 'login',
  `passwd` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `id_right` int(11) NOT NULL DEFAULT '2' COMMENT 'Typ puzivatelskych prav',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exist` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nick` (`nick`),
  KEY `id_right` (`id_right`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka vsech uzivatelu';

--
-- Vyprázdnit tabulku před vkládáním `users`
--

TRUNCATE TABLE `users`;
--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id_user`, `name`, `nick`, `passwd`, `email`, `id_right`, `created`, `exist`) VALUES
(1, 'Administrátor', 'admin', 'admin', 'admin@admin.com', 4, '2017-12-04 18:56:28', 1),
(2, 'Lukáš Radimerský', 'radluk', 'jahoda', 'radluk@students.zcu.cz', 3, '2017-12-04 18:56:28', 1),
(3, 'Tomáš Recenzeznáš', 'rec01', 'rec01', 'rec01@radimersky.cz', 3, '2017-12-04 18:59:06', 1),
(4, 'Kamil Všechnočet', 'rec02', 'rec02', 'rec02@radimersky.cz', 3, '2017-12-04 18:59:06', 1),
(5, 'Luděk Pochvička', 'rec03', 'rec03', 'rec03@radimersky.cz', 3, '2017-12-04 18:59:06', 1),
(6, 'Stanislav Smrdutý', 'smrduch', 'smrduch2', 'smrduty@jakoprase.com', 2, '2017-12-12 21:03:08', 0),
(7, 'Waldemar Hroznýš', 'waldik', 'okamura555', 'walda@stromvyvrcholeni.eu', 3, '2017-12-12 21:05:32', 1),
(8, 'Kateřina Konstelovaná', 'kachnickab', 'amarouny889', 'kachnickab@tiscali.ne', 2, '2017-12-12 21:11:22', 1),
(9, 'Zbyšek Vučeta', 'vucetic', 'jarmark', 'jarmark@namesti.cz', 2, '2017-12-14 17:31:18', 1),
(10, 'Zubatý Vlk', 'zuvlk', 'kopretina5562', 'kopretina@napoli.cz', 3, '2017-12-14 17:38:37', 1),
(11, 'Lenka Sečtečkou', 'jetady', 'jetady2', 'prijela@proknizky.cz', 2, '2017-12-16 02:15:50', 1);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `set_state` FOREIGN KEY (`a_state`) REFERENCES `states` (`id_state`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_right`) REFERENCES `rights` (`id_right`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
