CREATE TABLE `business` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(11) NOT NULL,
  `type` enum('agency','tour','restaurant','hotel') NOT NULL,
  `haghighi` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(700) DEFAULT NULL,
  `nickName` varchar(700) DEFAULT NULL,
  `nid` varchar(30) DEFAULT NULL,
  `economyCode` varchar(30) DEFAULT NULL,
  `site` varchar(500) DEFAULT NULL,
  `introduction` longtext,
  `tel` varchar(11) DEFAULT NULL,
  `mail` varchar(500) DEFAULT NULL,
  `insta` varchar(500) DEFAULT NULL,
  `telegram` varchar(500) DEFAULT NULL,
  `cityId` int(11) DEFAULT NULL,
  `address` text,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lastChangesNewsPaper` varchar(200) DEFAULT NULL,
  `hasCertificate` tinyint(1) NOT NULL DEFAULT '0',
  `hasAdditionalValue` tinyint(1) NOT NULL DEFAULT '0',
  `expireAdditionalValue` varchar(8) DEFAULT NULL,
  `additionalValue` varchar(200) DEFAULT NULL,
  `shaba` varchar(30) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `cityId` (`cityId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `businessACL` (
  `id` int(10) UNSIGNED NOT NULL,
  `businessId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `financialAccess` tinyint(1) NOT NULL DEFAULT '0',
  `contentAccess` tinyint(1) NOT NULL DEFAULT '0',
  `userAccess` tinyint(1) NOT NULL DEFAULT '0',
  `infoAccess` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `businessACL`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businessId` (`businessId`),
  ADD KEY `userId` (`userId`);

ALTER TABLE `businessACL`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `businessACL`
  ADD CONSTRAINT `businessForeign` FOREIGN KEY (`businessId`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userForeignInbusinessACL` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `businessACL` ADD `accept` BOOLEAN NOT NULL DEFAULT FALSE AFTER `infoAccess`;

ALTER TABLE `users` ADD `isForeign` BOOLEAN NOT NULL DEFAULT FALSE AFTER `updated_at`;

CREATE TABLE `contracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('agency','tour','restaurant','hotel') NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `contracts` (`id`, `type`, `description`) VALUES (NULL, 'agency', '');
INSERT INTO `contracts` (`id`, `type`, `description`) VALUES (NULL, 'tour', ''), (NULL, 'restaurant', '');
INSERT INTO `contracts` (`id`, `type`, `description`) VALUES (NULL, 'hotel', '');

ALTER TABLE `business` ADD `type_statue` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pic`, ADD `haghighi_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `type_statue`, ADD `name_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `haghighi_status`, ADD `nickName_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `name_status`, ADD `nid_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `nickName_status`, ADD `economyCode_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `nid_status`, ADD `site_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `economyCode_status`, ADD `introduction_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `site_status`, ADD `tel_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `introduction_status`, ADD `mail_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `tel_status`, ADD `insta_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `mail_status`, ADD `telegram_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `insta_status`, ADD `cityId_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `telegram_status`, ADD `address_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `cityId_status`, ADD `lat_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `address_status`, ADD `lng_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `lat_status`, ADD `lastChangesNewsPaper_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `lng_status`, ADD `hasCertificate_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `lastChangesNewsPaper_status`, ADD `hasAdditionalValue_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `hasCertificate_status`, ADD `expireAdditionalValue_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `hasAdditionalValue_status`, ADD `shaba_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `expireAdditionalValue_status`, ADD `logo_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `shaba_status`, ADD `pic_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `logo_status`, ADD `additionalValue_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pic_status`;
ALTER TABLE `business` DROP `nickName`;
ALTER TABLE `business` DROP `nickName_status`;
ALTER TABLE `business` ADD `readyForCheck` BOOLEAN NOT NULL DEFAULT FALSE AFTER `additionalValue_status`;
ALTER TABLE `business` ADD `finalStatus` BOOLEAN NOT NULL DEFAULT FALSE AFTER `readyForCheck`;

ALTER TABLE `business` ADD `afterClosedDayIsOpen` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `closedDayIsOpen` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `inWeekOpenTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `business` ADD `inWeekCloseTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `business` ADD `afterClosedDayOpenTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `business` ADD `afterClosedDayCloseTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `business` ADD `closedDayOpenTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `business` ADD `closedDayCloseTime` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL;


ALTER TABLE `business` ADD `afterClosedDayIsOpen_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `closedDayIsOpen_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `inWeekOpenTime_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `inWeekCloseTime_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `afterClosedDayOpenTime_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `afterClosedDayCloseTime_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `closedDayOpenTime_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `closedDayCloseTime_status` NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `fullOpen` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `fullOpen_status` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `business` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `fullOpen`, ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

CREATE TABLE `businessPic` (
  `id` int(10) UNSIGNED NOT NULL,
  `businessId` int(10) UNSIGNED NOT NULL,
  `pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `businessPic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businessId` (`businessId`);

ALTER TABLE `businessPic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `businessPic`
  ADD CONSTRAINT `businessForeignInPic` FOREIGN KEY (`businessId`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `business` DROP `pic`;
ALTER TABLE `business` DROP `pic_status`;
ALTER TABLE `businessPic` ADD `status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pic`;
ALTER TABLE `business` CHANGE `expireAdditionalValue` `expireAdditionalValue` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

CREATE TABLE `businessMadareks` (
  `id` int(10) UNSIGNED NOT NULL,
  `businessId` int(10) UNSIGNED NOT NULL,
  `role` int(1) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `pic1` varchar(200) NOT NULL,
  `pic2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `businessMadareks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businessId` (`businessId`);

ALTER TABLE `businessMadareks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `businessMadareks`
  ADD CONSTRAINT `businessForeignMadarek` FOREIGN KEY (`businessId`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `businessMadareks` ADD `status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pic2`;
ALTER TABLE `businessMadareks` ADD `idx` INT(2) UNSIGNED NOT NULL AFTER `status`;
ALTER TABLE `business` ADD `closedDayCloseTime_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `updated_at`;
