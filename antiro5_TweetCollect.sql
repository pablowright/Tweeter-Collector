-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 26, 2016 at 08:40 PM
-- Server version: 5.6.29-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `antiro5_TweetCollect`
--
CREATE DATABASE IF NOT EXISTS `TweetCollect` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `antiro5_TweetCollect`;

-- --------------------------------------------------------

--
-- Table structure for table `Search_String`
--

CREATE TABLE IF NOT EXISTS `Search_String` (
  `record` int(11) NOT NULL AUTO_INCREMENT,
  `userID` varchar(50) NOT NULL,
  `search_key` varchar(10) NOT NULL,
  `string` mediumtext NOT NULL,
  PRIMARY KEY (`record`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE IF NOT EXISTS `tweets` (
  `tweetID` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `screen_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tweet` varchar(140) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `search_key` int(2) NOT NULL,
  `sent` int(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `tweetID` (`tweetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20669 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tweet_Replies`
--

CREATE TABLE IF NOT EXISTS `Tweet_Replies` (
  `record` int(100) NOT NULL AUTO_INCREMENT,
  `userID` varchar(50) NOT NULL,
  `search_key` varchar(10) NOT NULL,
  `tweet` mediumtext NOT NULL,
  PRIMARY KEY (`record`),
  KEY `record` (`record`),
  KEY `record_2` (`record`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=526 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
