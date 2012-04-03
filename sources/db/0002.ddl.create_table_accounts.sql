DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `uid` varchar(100) NOT NULL COMMENT 'the unique id of the social network',
  `provider` varchar(40) NOT NULL COMMENT 'provider name (google,facebook,twitter,vkontakte)',
  `identity` varchar(255) NOT NULL COMMENT 'identity',
  `full_name` varchar(100) NOT NULL COMMENT 'full_name',
  `activate_token` varchar(128) NOT NULL COMMENT 'key for activation account',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'flag that account is active',
  `created` datetime NOT NULL COMMENT 'created date time',
  `user_id` bigint(20) NOT NULL COMMENT 'reference to user',
  `last_login` datetime NOT NULL,
  `agreed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
