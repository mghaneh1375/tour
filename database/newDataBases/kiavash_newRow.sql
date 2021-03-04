ALTER TABLE `users` ADD `isKoochitaTv` TINYINT(1) NOT NULL DEFAULT '0' AFTER `googleId`;
ALTER TABLE `state` ADD `countryId` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `name`;
ALTER TABLE `state` ADD `description` TEXT NULL DEFAULT NULL AFTER `countryId`, ADD `folder` VARCHAR(255) NULL DEFAULT NULL AFTER `description`, ADD `image` VARCHAR(300) NULL DEFAULT NULL AFTER `folder`;
ALTER TABLE `state` CHANGE `countryId` `isCountry` TINYINT UNSIGNED NOT NULL DEFAULT '0';

INSERT INTO `place` (`id`, `name`, `visibility`, `tableName`, `fileName`, `mainSearch`) VALUES ('14', 'نوشیدنی', '1', 'drinks', 'drinks', '1');
