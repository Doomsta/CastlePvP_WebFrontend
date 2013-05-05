-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Mai 2013 um 00:25
-- Server Version: 5.5.30
-- PHP-Version: 5.3.24-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `martin_castlepvp`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `by_battleground`
--

CREATE TABLE IF NOT EXISTS `by_battleground` (
  `timestamp` int(16) NOT NULL,
  `bg` int(3) NOT NULL COMMENT 'map id',
  `players_a` int(4) NOT NULL,
  `players_h` int(4) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `by_character`
--

CREATE TABLE IF NOT EXISTS `by_character` (
  `timestamp` int(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `guild` varchar(32) NOT NULL,
  `faction` int(1) NOT NULL,
  `race` int(2) NOT NULL,
  `class` int(2) NOT NULL,
  `bg` int(3) NOT NULL,
  PRIMARY KEY (`timestamp`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `by_class`
--

CREATE TABLE IF NOT EXISTS `by_class` (
  `timestamp` int(16) NOT NULL,
  `cnt_warrior_bg_a` int(4) NOT NULL,
  `cnt_warrior_bg_h` int(4) NOT NULL,
  `cnt_warrior_total` int(4) NOT NULL,
  `cnt_shaman_bg_a` int(4) NOT NULL,
  `cnt_shaman_bg_h` int(4) NOT NULL,
  `cnt_shaman_total` int(4) NOT NULL,
  `cnt_hunter_bg_a` int(4) NOT NULL,
  `cnt_hunter_bg_h` int(4) NOT NULL,
  `cnt_hunter_total` int(4) NOT NULL,
  `cnt_warlock_bg_a` int(4) NOT NULL,
  `cnt_warlock_bg_h` int(4) NOT NULL,
  `cnt_warlock_total` int(4) NOT NULL,
  `cnt_priest_bg_a` int(4) NOT NULL,
  `cnt_priest_bg_h` int(4) NOT NULL,
  `cnt_priest_total` int(4) NOT NULL,
  `cnt_mage_bg_a` int(4) NOT NULL,
  `cnt_mage_bg_h` int(4) NOT NULL,
  `cnt_mage_total` int(4) NOT NULL,
  `cnt_paladin_bg_a` int(4) NOT NULL,
  `cnt_paladin_bg_h` int(4) NOT NULL,
  `cnt_paladin_total` int(4) NOT NULL,
  `cnt_rogue_bg_a` int(4) NOT NULL,
  `cnt_rogue_bg_h` int(4) NOT NULL,
  `cnt_rogue_total` int(4) NOT NULL,
  `cnt_druid_bg_a` int(4) NOT NULL,
  `cnt_druid_bg_h` int(4) NOT NULL,
  `cnt_druid_total` int(4) NOT NULL,
  `cnt_deathknight_bg_a` int(4) NOT NULL,
  `cnt_deathknight_bg_h` int(4) NOT NULL,
  `cnt_deathknight_total` int(4) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `global`
--

CREATE TABLE IF NOT EXISTS `global` (
  `timestamp` int(16) NOT NULL,
  `players_a` int(4) NOT NULL,
  `players_h` int(4) NOT NULL,
  `players80_a` int(4) NOT NULL,
  `players80_h` int(4) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shoubox`
--

CREATE TABLE IF NOT EXISTS `shoubox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(111) NOT NULL,
  `name` varchar(32) NOT NULL,
  `message` longtext NOT NULL,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

