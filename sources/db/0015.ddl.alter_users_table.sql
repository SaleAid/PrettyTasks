ALTER TABLE  `users` ADD  `invite_token` VARCHAR( 32 ) NULL DEFAULT NULL COMMENT  'token for invitations' AFTER  `activate_token` ,
ADD UNIQUE (
`invite_token`
);