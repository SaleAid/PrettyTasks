DROP TABLE IF EXISTS `access_tokens`;
CREATE TABLE IF NOT EXISTS `access_tokens` (
  `oauth_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oauth_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `user_id` char(36) NOT NULL COMMENT 'reference to user',
  `uid` varchar(100) DEFAULT NULL COMMENT 'the unique id of the social network',
  `master` int(1) NOT NULL DEFAULT '0',
  `provider` varchar(40) NOT NULL COMMENT 'provider name (google,facebook,twitter,vkontakte)',
  `login` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `password_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL COMMENT 'full_name',
  `activate_token` varchar(128) NOT NULL COMMENT 'key for activation account',
  `active` int(4) NOT NULL DEFAULT '0' COMMENT 'flag that account is active',
  `created` datetime NOT NULL COMMENT 'created date time',
  `modified` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `agreed` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `accounts` DROP PRIMARY KEY;
ALTER TABLE `accounts` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `accounts`;
ALTER TABLE `accounts` AUTO_INCREMENT =1125879;


DROP TABLE IF EXISTS `auth_codes`;
CREATE TABLE IF NOT EXISTS `auth_codes` (
  `code` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` char(20) NOT NULL,
  `client_secret` char(40) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `user_id` char(36) NOT NULL COMMENT 'reference to user',
  `comment` text COMMENT 'comment for day',
  `rating` int(11) DEFAULT '0' COMMENT 'reference to rating',
  `date` date NOT NULL COMMENT 'date of the day',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for store days';
ALTER TABLE `days` DROP PRIMARY KEY;
ALTER TABLE `days` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `days`;
ALTER TABLE `days` AUTO_INCREMENT =1125987;


DROP TABLE IF EXISTS `faqcategories`;
CREATE TABLE IF NOT EXISTS `faqcategories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` char(36) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `faqcategories` DROP PRIMARY KEY;
ALTER TABLE `faqcategories` ADD `newid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `faqcategories`;
ALTER TABLE `faqcategories` AUTO_INCREMENT =1;


DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` char(36) NOT NULL,
  `faqcategory_id` char(36) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `annotation` text,
  `content` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `faqcategory_id` (`faqcategory_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `faqs` DROP PRIMARY KEY;
ALTER TABLE `faqs` ADD `newid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `faqs`;
ALTER TABLE `faqs` AUTO_INCREMENT =1;


DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` char(36) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `email` varchar(400) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `processed` tinyint(1) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `processed` (`processed`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `feedbacks` DROP PRIMARY KEY;
ALTER TABLE `feedbacks` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `feedbacks`;
ALTER TABLE `feedbacks` AUTO_INCREMENT =11550;


DROP TABLE IF EXISTS `goals`;
CREATE TABLE IF NOT EXISTS `goals` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `goal` varchar(10000) NOT NULL,
  `todate` date DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `goals` DROP PRIMARY KEY;
ALTER TABLE `goals` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `goals`;
ALTER TABLE `goals` AUTO_INCREMENT =1125786;


DROP TABLE IF EXISTS `invitations`;
CREATE TABLE IF NOT EXISTS `invitations` (
  `id` char(36) NOT NULL,
  `email` varchar(400) NOT NULL COMMENT 'email of invited user',
  `user_id` char(36) NOT NULL COMMENT 'user''s id who invite other user',
  `created` datetime NOT NULL COMMENT 'Creation time',
  PRIMARY KEY (`id`),
  KEY `email` (`email`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User''s invitations';
ALTER TABLE `invitations` DROP PRIMARY KEY;
ALTER TABLE `invitations` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `invitations`;
ALTER TABLE `invitations` AUTO_INCREMENT =11550;


DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `title` varchar(10000) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`,`modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `notes` DROP PRIMARY KEY;
ALTER TABLE `notes` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `notes`;
ALTER TABLE `notes` AUTO_INCREMENT =1125765;


DROP TABLE IF EXISTS `ordered`;
CREATE TABLE IF NOT EXISTS `ordered` (
  `id` char(36) NOT NULL,
  `model` varchar(36) NOT NULL,
  `list` varchar(36) NOT NULL,
  `list_id` varchar(36) NOT NULL,
  `foreign_key` char(36) NOT NULL,
  `order` int(11) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`list`,`list_id`,`foreign_key`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `ordered` DROP PRIMARY KEY;
ALTER TABLE `ordered` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `ordered`;
ALTER TABLE `ordered` AUTO_INCREMENT =1125658;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `url` varchar(45) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `metakeywords` text NOT NULL,
  `metadescription` text NOT NULL,
  `content` longtext NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `pages` DROP PRIMARY KEY;
ALTER TABLE `pages` ADD `newid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `pages`;
ALTER TABLE `pages` AUTO_INCREMENT =1;


DROP TABLE IF EXISTS `refresh_tokens`;
CREATE TABLE IF NOT EXISTS `refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_key` (`user_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `settings` DROP PRIMARY KEY;
ALTER TABLE `settings` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `settings`;
ALTER TABLE `settings` AUTO_INCREMENT =1125678;


DROP TABLE IF EXISTS `tagged`;
CREATE TABLE IF NOT EXISTS `tagged` (
  `id` varchar(36) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `tag_id` varchar(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAGGING` (`model`,`foreign_key`,`tag_id`),
  KEY `INDEX_TAGGED` (`model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tagged` DROP PRIMARY KEY;
ALTER TABLE `tagged` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `tagged`;
ALTER TABLE `tagged` AUTO_INCREMENT =11252345;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` varchar(36) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAG` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tags` DROP PRIMARY KEY;
ALTER TABLE `tags` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `tags`;
ALTER TABLE `tags` AUTO_INCREMENT =1125546;


DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `user_id` char(36) NOT NULL COMMENT 'reference to user',
  `title` varchar(255) NOT NULL COMMENT 'task''s title',
  `comment` text,
  `date` date DEFAULT NULL COMMENT 'data and time for task',
  `time` time DEFAULT NULL COMMENT 'Flag for check time, if not set, task has only date',
  `timeend` time DEFAULT NULL,
  `datedone` datetime DEFAULT NULL,
  `done` int(1) DEFAULT '0' COMMENT 'Flag that task is done',
  `future` int(1) DEFAULT '0' COMMENT 'flag that task is for future',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `continued` int(1) DEFAULT '0' COMMENT 'flag that task is for continued',
  `repeatid` int(1) DEFAULT '0' COMMENT 'id of repeated task''s series',
  `transfer` int(11) DEFAULT '0' COMMENT 'count of transfer of task',
  `priority` int(11) DEFAULT '0' COMMENT 'priority of task',
  `day_id` char(36) NOT NULL,
  `dateremind` date DEFAULT NULL,
  `created` datetime DEFAULT NULL COMMENT 'created date time ',
  `modified` datetime DEFAULT NULL COMMENT 'modified date time ',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `user_date_order` (`user_id`,`date`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tasks` DROP PRIMARY KEY;
ALTER TABLE `tasks` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `tasks`;
ALTER TABLE `tasks` AUTO_INCREMENT =1125565;


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `invite_token` varchar(32) DEFAULT NULL COMMENT 'token for invitations',
  `timezone` varchar(60) DEFAULT NULL,
  `timezone_offset` varchar(6) DEFAULT NULL,
  `language` varchar(3) DEFAULT NULL,
  `created` datetime NOT NULL COMMENT 'created date time',
  `modified` datetime NOT NULL COMMENT 'modified date time',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'flag that user is active',
  `agreed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'agreed user',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'blocked users',
  `pro` tinyint(1) NOT NULL DEFAULT '0',
  `beta` tinyint(1) NOT NULL DEFAULT '0',
  `rmb_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invite_token` (`invite_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=' ';
ALTER TABLE `users` DROP PRIMARY KEY;
ALTER TABLE `users` ADD `newid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `users`;
ALTER TABLE `users` AUTO_INCREMENT =1125432;


DROP TABLE IF EXISTS `users_tags`;
CREATE TABLE IF NOT EXISTS `users_tags` (
  `id` varchar(36) NOT NULL,
  `tag_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `comment` varchar(10000) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '0',
  `occurrence` int(11) NOT NULL DEFAULT '0',
  `task_occurrence` int(11) NOT NULL DEFAULT '0',
  `note_occurrence` int(11) NOT NULL DEFAULT '0',
  `goal_occurrence` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `users_tags` ADD `newid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
TRUNCATE TABLE `users_tags`;
ALTER TABLE `users_tags` AUTO_INCREMENT =1125342;








