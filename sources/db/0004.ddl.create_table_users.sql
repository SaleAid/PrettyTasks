DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
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
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'flag that user is active',
  `agreed` tinyint(4) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'is_blocked',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
