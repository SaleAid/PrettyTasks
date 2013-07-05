ALTER TABLE  `users` CHANGE  `is_blocked`  `blocked` INT( 4 ) NOT NULL DEFAULT  '0' COMMENT  'is_blocked';
ALTER TABLE  `users` CHANGE  `active`  `active` BOOLEAN NOT NULL DEFAULT  '0' COMMENT  'flag that user is active',
CHANGE  `agreed`  `agreed` BOOLEAN NOT NULL DEFAULT  '0' COMMENT  'agreed user',
CHANGE  `blocked`  `blocked` BOOLEAN NOT NULL DEFAULT  '0' COMMENT  'blocked users';
ALTER TABLE  `users` ADD  `pro` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `blocked` ,
ADD  `beta` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `pro`;