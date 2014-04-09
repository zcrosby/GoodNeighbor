-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2014 at 10:26 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `neighbor`
--
CREATE DATABASE IF NOT EXISTS `neighbor` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `neighbor`;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `CITY_ID` int(4) NOT NULL AUTO_INCREMENT,
  `CITY_NAME` varchar(25) NOT NULL,
  PRIMARY KEY (`CITY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `city`
--



-- --------------------------------------------------------

--
-- Table structure for table `favor_request`
--

CREATE TABLE IF NOT EXISTS `favor` (
  `FAVOR_ID` int(4) NOT NULL AUTO_INCREMENT,
  `FAVOR_TYPE_ID` int(4) NOT NULL,
  `DATE_SUBMITTED` date NOT NULL,
  `DATE_OF_FAVOR` date NOT NULL,
  `NEED_ASAP` char(1) NOT NULL,
  `DETAILS` text NOT NULL,
  `STATUS` char(1) NOT NULL,
  PRIMARY KEY (`FAVOR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='The favor_request table stores all active favor requests submitted by a user. ' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `favor`
--

-- --------------------------------------------------------

--
-- Table structure for table `favor_resquester`
--

CREATE TABLE IF NOT EXISTS `favor_resquester` (
  `FAVOR_ID` int(4) NOT NULL,
  `USER_ID` int(4) NOT NULL,
  `WANTS_TO_BE_CONTACTED` char(1) NOT NULL,
  PRIMARY KEY (`FAVOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this table stores all the users who have accepted to respond to any given favor.';

--
-- Dumping data for table `favor_resquester`
--


-- --------------------------------------------------------

--
-- Table structure for table `favor_responder`
--

CREATE TABLE IF NOT EXISTS `favor_responder` (
  `FAVOR_ID` int(4) NOT NULL,
  `USER_ID` int(4) NOT NULL,
  PRIMARY KEY (`FAVOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this table stores all the users who have accepted to respond to any given favor.';

--
-- Dumping data for table `favor_responder`
--


-- --------------------------------------------------------

--
-- Table structure for table `favor_type`
--

CREATE TABLE IF NOT EXISTS `favor_type` (
  `FAVOR_TYPE_ID` int(4) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(100) NOT NULL,
  PRIMARY KEY (`FAVOR_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Favor_type lists the different categories of favors users may choose from.' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `favor_type`
--



-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `FEEDBACK_ID` int(4) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) NOT NULL,
  `EMAIL` varchar(75) NOT NULL,
  `MESSAGE` text NOT NULL,
  `DATE_SUBMITTED` date NOT NULL,
  PRIMARY KEY (`FEEDBACK_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This table holds information about feedback submitted from users.' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `feedback`
--


-- --------------------------------------------------------

--
-- Table structure for table `mgmt`
--

CREATE TABLE IF NOT EXISTS `mgmt` (
  `ADMIN_ID` int(4) NOT NULL,
  `NAME` varchar(40) NOT NULL,
  `EMAIL` varchar(75) NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  PRIMARY KEY (`ADMIN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `neighborhood`
--

CREATE TABLE IF NOT EXISTS `neighborhood` (
  `NEIGHBORHOOD_ID` int(4) NOT NULL AUTO_INCREMENT,
  `NEIGHBORHOOD_NAME` varchar(25) NOT NULL,
  `CITY_ID` int(4) NOT NULL,
  PRIMARY KEY (`NEIGHBORHOOD_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `neighborhood`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `USER_ID` int(4) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) NOT NULL,
  `USER_ADDRESS` varchar(100) NOT NULL,
  `CITY_ID` int(4) NOT NULL,
  `NEIGHBORHOOD_ID` int(4) NOT NULL,
  `USER_EMAIL` varchar(75) NOT NULL,
  `USER_PHONE` varchar(20) NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `user_info`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
