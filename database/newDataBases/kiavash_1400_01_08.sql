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




