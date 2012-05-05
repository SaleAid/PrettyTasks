ALTER TABLE  `tasks` ADD  `timeend` TIME NULL DEFAULT NULL AFTER  `time`;
ALTER TABLE  `tasks` ADD  `dateremind` DATE NULL DEFAULT NULL AFTER  `day_id`;
ALTER TABLE  `tasks` ADD  `datedone` DATETIME NULL DEFAULT NULL AFTER  `timeend`;