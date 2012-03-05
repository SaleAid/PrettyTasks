DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_id` bigint(20) NOT NULL COMMENT 'reference to user',
  `comment` text COMMENT 'comment for day',
  `rating_id` int(11) DEFAULT '0' COMMENT 'reference to rating',
  `date` date NOT NULL COMMENT 'date of the day',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for store days' AUTO_INCREMENT=1 ;