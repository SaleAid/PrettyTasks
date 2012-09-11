DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` char(36) NOT NULL COMMENT 'primary key',
  `note` varchar(10000) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime DEFAULT NOT NULL,
  `modified` datetime DEFAULT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;