DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `uid` varchar(100) NOT NULL, COMMENT 'the unique id of the social network',
  `provider` varchar(40) NOT NULL, COMMENT 'provider name (google,facebook,twitter,vkontakte)', 
  `username` varchar(40) NOT NULL, COMMENT 'user nickname',
  `password` varchar(40) NOT NULL, COMMENT 'user password',
  `hash_key` varchar(100) NOT NULL, COMMENT 'key for activation account', 
  `active` tinyint(4) NOT NULL DEFAULT '0', COMMENT 'Flag that user is active',
  `created` datetime NOT NULL, COMMENT 'created date time ',
  `profile_id` bigint(20) NOT NULL, COMMENT 'reference to profile',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for store users accounts' AUTO_INCREMENT=1 ;