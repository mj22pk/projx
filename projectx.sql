-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 28 november 2011 kl 12:33
-- Serverversion: 5.1.54
-- PHP-version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `projectx`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `snippetId` int(11) NOT NULL,
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `commentText` varchar(1500) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `snippetId` (`snippetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Data i tabell `comment`
--

INSERT INTO `comment` (`snippetId`, `commentId`, `commentText`, `userId`) VALUES
(1, 129, 'detta är min första kommentar till opacityHack:-)', 6),
(2, 133, 'detta är min andra kommentar till test snippet 2', 6),
(10, 136, 'asd', 6);

-- --------------------------------------------------------

--
-- Struktur för tabell `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `code` varchar(2500) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `language` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Data i tabell `snippet`
--

INSERT INTO `snippet` (`id`, `author`, `code`, `title`, `description`, `language`) VALUES
(1, 'Kim Åström', 'selector {   filter: alpha(opacity=60); /* MSIE/PC */   -moz-opacity: 0.6; /* Mozilla 1.6 and older */   opacity: 0.6; }', 'opacityHack', 'a hack for op', 'css'),
(2, 'Marta', 'selector { code }', 'test snippet 2', 'test snippet 2', 'css'),
(12, 'kimsan', 'as', 'as', 'as', 'as'),
(11, 'kimsan', 'hej snippet', 'en title', 'en desc', 'java'),
(10, 'kimsan', 'da codeasdasd', 'Titasdle', 'desasdc', 'csasds');

-- --------------------------------------------------------

--
-- Struktur för tabell `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(1500) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Data i tabell `user`
--

INSERT INTO `user` (`userId`, `userName`) VALUES
(6, 'mania'),
(7, 'Marta');
