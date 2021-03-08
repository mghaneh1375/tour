ALTER TABLE `drink_material_relations` CHANGE `volume` `volume` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `drinks` ADD `hotOrCold` TINYINT(1) NULL DEFAULT NULL AFTER `categoryId`;


ALTER TABLE `drinks` CHANGE `hotOrCold` `isHot` TINYINT(1) NULL DEFAULT NULL;
ALTER TABLE `newsCategories` ADD `icon` VARCHAR(50) NULL AFTER `parentId`;
