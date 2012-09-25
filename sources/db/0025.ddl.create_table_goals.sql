DROP TABLE IF EXISTS `goals`;
CREATE TABLE `goals` (
  `id` char(36) NOT NULL, COMMENT 'primary key',
  `goal` varchar(10000) NOT NULL,
  `todate` date DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;