DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `uid` varchar(100) NOT NULL COMMENT 'the unique id of the social network',
  `provider` varchar(40) NOT NULL COMMENT 'provider name (local,google,facebook,twitter,vkontakte)',
  `username` varchar(40) NOT NULL COMMENT 'nickname for local',
  `password` varchar(40) NOT NULL COMMENT 'password for local',
  `hash_key` varchar(100) NOT NULL COMMENT 'key for activation account',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'flag that account is active',
  `created` datetime NOT NULL COMMENT 'created date time',
  `user_id` bigint(20) NOT NULL COMMENT 'reference to user',
  `role` enum('admin','regular') NOT NULL DEFAULT 'regular',
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;