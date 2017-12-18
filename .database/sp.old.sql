-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Úte 05. pro 2017, 10:34
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
DROP DATABASE IF EXISTS `sp`;
CREATE DATABASE IF NOT EXISTS `sp` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `sp`;

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `a_name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `a_abstract` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `a_filename` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `a_state` int(11) NOT NULL,
  `a_exist` tinyint(1) NOT NULL DEFAULT '1',
  `a_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_article`),
  KEY `set_state` (`a_state`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka prispevku v konferenci';

--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`id_article`, `id_user`, `a_name`, `a_abstract`, `a_filename`, `a_state`, `a_exist`, `a_date`) VALUES
(1, 2, 'Pojednani o jahodove zmrzline', 'Jahodova zmrzlina', 'zmrzlina.pdf', 1, 1, '2017-12-03 22:00:45'),
(2, 2, 'Recept na citronovou limonádu', 'Prastarý cectpt, jak si doma utvořit tuto vzácnou pochutinu', 'citronada.pdf', 1, 1, '2017-12-03 22:00:45');

-- --------------------------------------------------------

--
-- Struktura tabulky `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `a_expertise` int(11) DEFAULT NULL,
  `a_length` int(11) DEFAULT NULL,
  `a_quality` int(11) DEFAULT NULL,
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Hodnoceni clanku - odbornost, delka, kvalita zpracovani';

-- --------------------------------------------------------

--
-- Struktura tabulky `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id_right` int(11) NOT NULL AUTO_INCREMENT,
  `r_type` varchar(25) COLLATE utf8_czech_ci NOT NULL COMMENT 'Typ uzivatelskych prav',
  PRIMARY KEY (`id_right`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka s typy uzivatelskymi pravy uzivatelu';

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

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id_state` int(11) NOT NULL AUTO_INCREMENT,
  `s_type` varchar(20) COLLATE utf8_czech_ci NOT NULL COMMENT 'Typ stavu clanku',
  PRIMARY KEY (`id_state`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka s moznymi stavy vlozenych clanku';

--
-- Vypisuji data pro tabulku `states`
--

INSERT INTO `states` (`id_state`, `s_type`) VALUES
(1, 'accepted'),
(2, 'reviewed'),
(3, 'rejected');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `nick` varchar(20) COLLATE utf8_czech_ci NOT NULL COMMENT 'login',
  `passwd` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `id_right` int(11) NOT NULL DEFAULT '1' COMMENT 'Typ puzivatelskych prav',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exist` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  KEY `id_right` (`id_right`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka vsech uzivatelu';

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id_user`, `name`, `nick`, `passwd`, `email`, `id_right`, `created`, `exist`) VALUES
(1, 'Administrátor', 'admin', 'admin', 'admin@admin.com', 4, '2017-12-04 18:56:28', 1),
(2, 'Lukáš Radimerský', 'radluk', 'jahoda', 'radluk@students.zcu.cz', 2, '2017-12-04 18:56:28', 1),
(3, 'Tomáš Recenzeznáš', 'rec01', 'rec01', 'rec01@radimersky.cz', 3, '2017-12-04 18:59:06', 1),
(4, 'Kamil Všechnočet', 'rec02', 'rec02', 'rec02@radimersky.cz', 3, '2017-12-04 18:59:06', 1),
(5, 'Luděk Pochvička', 'rec03', 'rec03', 'rec03@radimersky.cz', 3, '2017-12-04 18:59:06', 1);

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
