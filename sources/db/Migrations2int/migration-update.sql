
UPDATE users, access_tokens SET access_tokens.user_id=users.newid WHERE users.id=access_tokens.user_id;
UPDATE users, accounts SET accounts.user_id=users.newid WHERE users.id=accounts.user_id;
UPDATE users, clients SET clients.user_id=users.newid WHERE users.id=clients.user_id;
UPDATE users, days SET days.user_id=users.newid WHERE users.id=days.user_id;
UPDATE users, faqcategories SET faqcategories.user_id=users.newid WHERE users.id=faqcategories.user_id;
UPDATE users, faqs SET faqs.user_id=users.newid WHERE users.id=faqs.user_id;
UPDATE users, feedbacks SET feedbacks.user_id=users.newid WHERE users.id=feedbacks.user_id;
UPDATE users, goals SET goals.user_id=users.newid WHERE users.id=goals.user_id;
UPDATE users, invitations SET invitations.user_id=users.newid WHERE users.id=invitations.user_id;
UPDATE users, notes SET notes.user_id=users.newid WHERE users.id=notes.user_id;
UPDATE users, ordered SET ordered.user_id=users.newid WHERE users.id=ordered.user_id;
UPDATE users, refresh_tokens SET refresh_tokens.user_id=users.newid WHERE users.id=refresh_tokens.user_id;
UPDATE users, settings SET settings.user_id=users.newid WHERE users.id=settings.user_id;
UPDATE users, tagged SET tagged.user_id=users.newid WHERE users.id=tagged.user_id;
UPDATE users, tasks SET tasks.user_id=users.newid WHERE users.id=tasks.user_id;
UPDATE users, users_tags SET users_tags.user_id=users.newid WHERE users.id=users_tags.user_id;

ALTER TABLE  `access_tokens` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `accounts` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `clients` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `days` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `faqs` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `feedbacks` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `goals` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `invitations` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `notes` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `ordered` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `refresh_tokens` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `settings` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `tagged` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `tasks` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;
ALTER TABLE  `users_tags` CHANGE  `user_id`  `user_id` INT UNSIGNED NOT NULL;


UPDATE tasks, ordered SET ordered.foreign_key=tasks.newid WHERE ordered.model='Task' and ordered.foreign_key=tasks.id;

UPDATE notes, ordered SET ordered.foreign_key=notes.newid WHERE ordered.model='Note' and ordered.foreign_key=notes.id;

UPDATE tags, ordered SET ordered.list=tags.newid WHERE ordered.list_id ='TagList' and ordered.list=tags.id;


UPDATE tasks, tagged SET tagged.foreign_key=tasks.newid WHERE tagged.model='Task' and tagged.foreign_key=tasks.id;

UPDATE notes, tagged SET tagged.foreign_key=notes.newid WHERE tagged.model='Note' and tagged.foreign_key=notes.id;

UPDATE tags, tagged SET tagged.tag_id=tags.newid WHERE tagged.tag_id=tags.id;


UPDATE tags, users_tags SET users_tags.tag_id=tags.newid WHERE users_tags.tag_id=tags.id;





