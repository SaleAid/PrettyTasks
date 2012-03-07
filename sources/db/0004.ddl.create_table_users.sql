DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `first_name` varchar(50) NOT NULL COMMENT 'user name',
  `last_name` varchar(50) NOT NULL COMMENT 'user last name',
  `email` varchar(50) NOT NULL COMMENT 'user email',
  `created` datetime NOT NULL COMMENT 'created date time',
  `modified` datetime NOT NULL COMMENT 'modified date time',
  `active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'flag that user is active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;