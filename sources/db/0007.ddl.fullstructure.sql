-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2012 at 01:33 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.9-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `besttask`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `uid` varchar(100) NOT NULL COMMENT 'the unique id of the social network',
  `provider` varchar(40) NOT NULL COMMENT 'provider name (google,facebook,twitter,vkontakte)',
  `identity` varchar(255) NOT NULL COMMENT 'identity',
  `full_name` varchar(100) NOT NULL COMMENT 'full_name',
  `activate_token` varchar(128) NOT NULL COMMENT 'key for activation account',
  `active` int(4) NOT NULL DEFAULT '0' COMMENT 'flag that account is active',
  `created` datetime NOT NULL COMMENT 'created date time',
  `user_id` int(20) NOT NULL COMMENT 'reference to user',
  `last_login` datetime NOT NULL,
  `agreed` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_id` bigint(20) NOT NULL COMMENT 'reference to user',
  `comment` text COMMENT 'comment for day',
  `rating` int(11) DEFAULT '0' COMMENT 'reference to rating',
  `date` date NOT NULL COMMENT 'date of the day',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for store days' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_id` int(20) NOT NULL COMMENT 'reference to user',
  `title` varchar(100) NOT NULL COMMENT 'task''s title',
  `date` date DEFAULT NULL COMMENT 'data and time for task',
  `time` time DEFAULT NULL COMMENT 'Flag for check time, if not set, task has only date',
  `order` int(4) DEFAULT '0' COMMENT 'order for sorting tasks',
  `done`  int(1) DEFAULT '0' COMMENT 'Flag that task is done',
  `future`  int(1) DEFAULT '0' COMMENT 'flag that task is for future',
  `repeatid`  int(1) DEFAULT '0' COMMENT 'id of repeated task''s series',
  `transfer` int(11) DEFAULT '0' COMMENT 'count of transfer of task',
  `priority` int(11) DEFAULT '0' COMMENT 'priority of task',
  `day_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL COMMENT 'created date time ',
  `modified` datetime DEFAULT NULL COMMENT 'modified date time ',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `order` (`order`),
  KEY `repeatid` (`repeatid`),
  KEY `user_date_order` (`user_id`,`date`,`order`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `username` varchar(20) NOT NULL COMMENT 'username',
  `password` varchar(40) NOT NULL COMMENT 'password',
  `password_token` varchar(128) NOT NULL COMMENT '	password_token',
  `first_name` varchar(50) NOT NULL COMMENT 'user name',
  `last_name` varchar(50) NOT NULL COMMENT 'user last name',
  `email` varchar(50) NOT NULL COMMENT 'user email',
  `activate_token` varchar(128) NOT NULL COMMENT 'activate_token',
  `timezone` int(11) NOT NULL,
  `created` datetime NOT NULL COMMENT 'created date time',
  `modified` datetime NOT NULL COMMENT 'modified date time',
  `active` int(4) NOT NULL DEFAULT '0' COMMENT 'flag that user is active',
  `agreed` int(4) NOT NULL DEFAULT '0',
  `is_blocked` int(4) NOT NULL DEFAULT '0' COMMENT 'is_blocked',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `username` (`username`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

