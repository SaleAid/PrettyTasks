ALTER TABLE `accounts` DROP `id`;
ALTER TABLE `accounts` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `days` DROP `id`;
ALTER TABLE `days` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `faqcategories` DROP `id`;
ALTER TABLE `faqcategories` CHANGE  `newid`  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `faqs` DROP `id`;
ALTER TABLE `faqs` CHANGE  `newid`  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `feedbacks` DROP `id`;
ALTER TABLE `feedbacks` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `goals` DROP `id`;
ALTER TABLE `goals` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `invitations` DROP `id`;
ALTER TABLE `invitations` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `notes` DROP `id`;
ALTER TABLE `notes` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `ordered` DROP `id`;
ALTER TABLE `ordered` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `pages` DROP `id`;
ALTER TABLE `pages` CHANGE  `newid`  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings` DROP `id`;
ALTER TABLE `settings` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tagged` DROP `id`;
ALTER TABLE `tagged` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tags` DROP `id`;
ALTER TABLE `tags` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tasks` DROP `id`;
ALTER TABLE `tasks` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users` DROP `id`;
ALTER TABLE `users` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users_tags` DROP `id`;
ALTER TABLE `users_tags` CHANGE  `newid`  `id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;

DELETE FROM  `ordered` WHERE LENGTH( foreign_key ) >30;
DELETE FROM  `tagged` WHERE LENGTH( foreign_key ) >30;
DELETE FROM  `tagged` WHERE LENGTH( tag_id ) >30;

ALTER TABLE  `ordered` CHANGE  `foreign_key`  `foreign_key` BIGINT( 20 ) UNSIGNED NOT NULL;
ALTER TABLE  `tagged` CHANGE  `tag_id`  `tag_id` BIGINT( 20 ) UNSIGNED NOT NULL;
ALTER TABLE  `tagged` CHANGE  `foreign_key`  `foreign_key` BIGINT( 20 ) UNSIGNED NOT NULL;
ALTER TABLE  `users_tags` CHANGE  `tag_id`  `tag_id` BIGINT( 20 ) UNSIGNED NOT NULL ;
ALTER TABLE  `auth_codes` CHANGE  `user_id`  `user_id` INT( 10 ) UNSIGNED NOT NULL ;
ALTER TABLE  `faqcategories` CHANGE  `user_id`  `user_id` INT( 10 ) UNSIGNED NOT NULL ;
ALTER TABLE  `faqs` CHANGE  `faqcategory_id`  `faqcategory_id` INT( 10 ) UNSIGNED NOT NULL ;






