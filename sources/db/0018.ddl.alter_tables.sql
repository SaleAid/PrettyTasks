ALTER TABLE  `tasks` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL COMMENT  'primary key';

ALTER TABLE  `tasks` CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL COMMENT  'reference to user';

ALTER TABLE  `users` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL COMMENT  'primary key';

ALTER TABLE  `invitations` CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL COMMENT  'user''s id who invite other user';

ALTER TABLE  `days` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL COMMENT  'primary key',
CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL COMMENT  'reference to user';

ALTER TABLE  `accounts` CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL COMMENT  'reference to user';

ALTER TABLE  `faqcategories` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL ,
CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL DEFAULT  '';

ALTER TABLE  `faqs` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL ,
CHANGE  `faqcategory_id`  `faqcategory_id` CHAR( 36 ) NOT NULL;

ALTER TABLE  `faqs` CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL;

ALTER TABLE  `feedbacks` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL ,
CHANGE  `user_id`  `user_id` CHAR( 36 ) NOT NULL;

ALTER TABLE  `invitations` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL;

ALTER TABLE  `accounts` CHANGE  `id`  `id` CHAR( 36 ) NOT NULL COMMENT  'primary key';

ALTER TABLE  `tasks` CHANGE  `day_id`  `day_id` CHAR( 36 ) NOT NULL;