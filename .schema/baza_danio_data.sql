-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 22 Sty 2011, 23:26
-- Wersja serwera: 5.1.41
-- Wersja PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `baza_danio`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `number` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `accounts`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `account_subtype`
--

CREATE TABLE IF NOT EXISTS `account_subtype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `subtypename` varchar(64) NOT NULL,
  `parent_type_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `account_subtype`
--

INSERT INTO `account_subtype` (`ID`, `subtypename`, `parent_type_id`) VALUES
(1, 'cash', 1),
(2, 'bank', 1),
(3, 'stock', 1),
(4, 'mutualfund', 1),
(5, 'receivable', 1),
(6, 'asset', 1),
(7, 'creditcard', 2),
(8, 'payable', 2),
(9, 'liability', 2),
(10, 'equity', 3),
(11, 'income', 4),
(12, 'expense', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `account_type`
--

CREATE TABLE IF NOT EXISTS `account_type` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `account_type`
--

INSERT INTO `account_type` (`ID`, `typename`) VALUES
(1, 'asset'),
(2, 'liability'),
(3, 'equity'),
(4, 'income'),
(5, 'expense');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `account_users`
--

CREATE TABLE IF NOT EXISTS `account_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `subaccount_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `subaccount_id` (`subaccount_id`,`user_id`,`privilege_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `account_users`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `ci_sessions`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `login_attempts`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `names_comments`
--

CREATE TABLE IF NOT EXISTS `names_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `names_comments`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `privilege_name` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `privileges`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `birthcity` varchar(128) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `profiles`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `profiles_users`
--

CREATE TABLE IF NOT EXISTS `profiles_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_id` (`profile_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `profiles_users`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `subaccounts`
--

CREATE TABLE IF NOT EXISTS `subaccounts` (
  `ID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `account_number` int(10) unsigned zerofill NOT NULL,
  `type_id` int(10) unsigned zerofill NOT NULL,
  `parent_id` int(10) unsigned zerofill NOT NULL,
  `modify_privilege_id` int(10) unsigned zerofill NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `names_comments_id` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `account_number` (`account_number`,`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `subaccounts`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `from_subaccount` int(11) NOT NULL,
  `to_subaccount` int(11) NOT NULL,
  `tvalue` double NOT NULL,
  `tdate` date NOT NULL,
  `tname_comment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `from_subaccount` (`from_subaccount`,`to_subaccount`,`tvalue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `transactions`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `users`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `user_autologin`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `user_profiles`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
