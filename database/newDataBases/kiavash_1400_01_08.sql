ALTER TABLE `reviewPics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `users` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picture`;
ALTER TABLE `photographersPics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `users` ADD `baner_server` TINYINT NOT NULL DEFAULT '1' AFTER `banner`;
ALTER TABLE `safarnameh` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `safarnamehLimboPics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `userAddPlaces` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pics`;
ALTER TABLE `localShopsPictures` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `placePics` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `amaken` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `restaurant` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `hotels` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `majara` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `sogatSanaies` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `mahaliFood` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `boomgardies` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `drinks` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `picNumber`;
ALTER TABLE `news` ADD `server` TINYINT(1) NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `newsLimboPics` ADD `server` TINYINT(1) NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `news` ADD `videoServer` TINYINT(1) NOT NULL DEFAULT '1' AFTER `video`;
ALTER TABLE `localShops` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `placeId`;
ALTER TABLE `cityPics` ADD `server` TINYINT(1) NOT NULL DEFAULT '1' AFTER `pic`;
ALTER TABLE `cities` ADD `server` TINYINT(1) NOT NULL DEFAULT '1' AFTER `image`;
ALTER TABLE `state` ADD `server` TINYINT(1) NOT NULL DEFAULT '1' AFTER `image`;
ALTER TABLE `localShopsCategories` ADD `onlyOnMap` TINYINT NOT NULL DEFAULT '0' AFTER `parentId`;
ALTER TABLE `localShopsCategories` ADD `server` TINYINT NOT NULL DEFAULT '1' AFTER `mapIcon`;
ALTER TABLE `localShops` ADD `seen` INT(11) NOT NULL DEFAULT '0' AFTER `fullRate`;
ALTER TABLE `tour` ADD `codeNumber` VARCHAR(30) NULL DEFAULT NULL AFTER `code`;
ALTER TABLE `tickets` ADD `businessId` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `to_`;
ALTER TABLE `tickets` CHANGE `from_` `userId` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `tickets` CHANGE `to_` `adminId` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `tickets` ADD `adminSeen` TINYINT NOT NULL DEFAULT '0' AFTER `seen`;
ALTER TABLE `tickets` ADD `fileName` VARCHAR(200) NULL DEFAULT NULL AFTER `msg`;
ALTER TABLE `tour` ADD `type` ENUM('cityTourism','onDay','multiDay','package') NULL AFTER `codeNumber`;
ALTER TABLE `tourTimes` ADD `cost` VARCHAR(20) NOT NULL DEFAULT '0' AFTER `code`;
ALTER TABLE `tourTimes` CHANGE `eDate` `eDate` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `tour` CHANGE `destId` `destId` INT(10) UNSIGNED NULL;
ALTER TABLE `tourScheduleDetails` CHANGE `detailKindId` `detailKindId` BIGINT(20) UNSIGNED NULL;
INSERT INTO `tourScheduleDetailKinds` (`id`, `name`, `color`, `icon`, `code`) VALUES (NULL, 'وعده غذایی', 'green', NULL, '9');
ALTER TABLE `tour` ADD `tourGuidPhone` VARCHAR(20) NULL DEFAULT NULL AFTER `tourGuidSex`;
ALTER TABLE `tourDiscounts` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `remainingDay`;
ALTER TABLE `tourGuids` ADD `phone` VARCHAR(20) NULL DEFAULT NULL AFTER `sex`;
ALTER TABLE `tourTimes` ADD `isInsurance` TINYINT(1) NULL AFTER `cost`;
ALTER TABLE `tourTimes` ADD `minCapacity` SMALLINT NOT NULL AFTER `eDate`, ADD `maxCapacity` SMALLINT NOT NULL AFTER `minCapacity`;
ALTER TABLE `tourDiscounts` ADD `tourTimeId` INT(11) NOT NULL AFTER `tourId`;










