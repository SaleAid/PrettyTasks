DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_id` bigint(20) NOT NULL COMMENT 'reference to user',
  `title` varchar(100) NOT NULL COMMENT 'task''s title',
  `date` date DEFAULT NULL COMMENT 'data and time for task',
  `time` time DEFAULT NULL COMMENT 'Flag for check time, if not set, task has only date',
  `order` tinyint(4) DEFAULT '0' COMMENT 'order for sorting tasks',
  `done` tinyint(1) DEFAULT '0' COMMENT 'Flag that task is done',
  `future` tinyint(1) DEFAULT b'0' COMMENT 'flag that task is for future',
  `repeatid` tinyint(1) DEFAULT b'0' COMMENT 'id of repeated task''s series',
  `transfer` int(11) DEFAULT '0' COMMENT 'count of transfer of task',
  `priority` int(11) DEFAULT '0' COMMENT 'priority of task',
  `created` datetime DEFAULT NULL COMMENT 'created date time ',
  `modified` datetime DEFAULT NULL COMMENT 'modified date time ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for store tasks' AUTO_INCREMENT=1 ;
