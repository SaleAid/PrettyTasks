-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 11, 2012 at 09:12 PM
-- Server version: 5.1.62
-- PHP Version: 5.3.9-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `besttask`
--

-- --------------------------------------------------------

--
-- Table structure for table `faqcategories`
--

DROP TABLE IF EXISTS `faqcategories`;
CREATE TABLE IF NOT EXISTS `faqcategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faqcategory_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(3) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `annotation` text,
  `content` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `faqcategory_id` (`faqcategory_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lang` varchar(3) NOT NULL,
  `email` varchar(400) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `processed` tinyint(1) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `processed` (`processed`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
