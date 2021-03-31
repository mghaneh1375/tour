ALTER TABLE `reviewPics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `users` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picture`;
ALTER TABLE `users` ADD `baner_server` TINYINT NOT NULL DEFAULT '1' AFTER `banner`;
ALTER TABLE `photographersPics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pic`;
