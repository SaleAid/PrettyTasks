CREATE TABLE  `besttask`.`invitations` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`email` VARCHAR( 400 ) NOT NULL COMMENT  'email of invited user',
`user_id` BIGINT UNSIGNED NOT NULL COMMENT  'user''s id who invite other user',
`created` DATETIME NOT NULL COMMENT  'Creation time',
INDEX (  `email` )
) ENGINE = INNODB COMMENT =  'User''s invitations';