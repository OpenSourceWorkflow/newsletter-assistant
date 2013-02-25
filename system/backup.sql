-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. April 2010 um 14:50
-- Server Version: 5.1.37
-- PHP-Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `newsletter_assistent`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `na_newsletter`
--

DROP TABLE IF EXISTS `na_newsletter`;
CREATE TABLE IF NOT EXISTS `na_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `html` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `plain` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Daten für Tabelle `na_newsletter`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `na_projects`
--

DROP TABLE IF EXISTS `na_projects`;
CREATE TABLE IF NOT EXISTS `na_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `na_projects`
--