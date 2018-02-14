DROP TABLE IF EXISTS `speleo_booking`;
DROP TABLE IF EXISTS `speleo_formule`;
DROP TABLE IF EXISTS `speleo_period`;
DROP TABLE IF EXISTS `speleo_formule_period`;
DROP TABLE IF EXISTS `speleo_formule_date`;
DROP TABLE IF EXISTS `speleo_formule_image`;

CREATE TABLE `speleo_booking` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`formule_id` INT(11) NOT NULL,
	`nbr_person` INT(11) NOT NULL,
	`price` float(5) NOT NULL,
	`date` DATE NOT NULL,
	`is_canceled` INT(11) DEFAULT 0,
	`is_private` INT(11) DEFAULT 0,
	`is_comfirmed` INT(11) DEFAULT 0,
	`period_id` INT(11) NOT NULL,
	`firstname` VARCHAR(255) NOT NULL,
	`lastname` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`phone` VARCHAR(255) NOT NULL,
	`ip` VARCHAR(255) NOT NULL,
	`address` VARCHAR(255) DEFAULT NULL,
	`zip_code` VARCHAR(255) DEFAULT NULL,
	`country` VARCHAR(255) DEFAULT NULL,
	`encrypt` VARCHAR(255) NOT NULL,
	`cdate` DATETIME NOT NULL DEFAULT 0,
	`udate` DATETIME NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`formule_id`) REFERENCES speleo_formule(id),
	FOREIGN KEY (`period_id`) REFERENCES speleo_period(id)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_formule` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sys_name` VARCHAR(255) NOT NULL,
	`price` float(5) NOT NULL,
	`min_person_allowed` INT(11) NOT NULL,
	`max_person_allowed` INT(11) NOT NULL,
	`google_place` VARCHAR(255) DEFAULT NULL,
	`lat` VARCHAR(255) DEFAULT NULL,
	`lng` VARCHAR(255) DEFAULT NULL,
	`is_published` INT(11) DEFAULT 1,
	`order` INT(11) DEFAULT 0,
	`cdate` DATETIME NOT NULL DEFAULT 0,
	`udate` DATETIME NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_period` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sys_name` VARCHAR(255) NOT NULL,
	`hour` VARCHAR(255) DEFAULT NULL,
	`cdate` DATETIME NOT NULL DEFAULT 0,
	`udate` DATETIME NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_formule_period` (
	`formule_id` INT(11) NOT NULL,
	`period_id` INT(11) NOT NULL,
	FOREIGN KEY (`formule_id`) REFERENCES speleo_formule(id),
	FOREIGN KEY (`period_id`) REFERENCES speleo_period(id)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_booking_localized` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`entity_type` VARCHAR(55) NOT NULL,
	`entity_id` INT(11) NOT NULL,
	`language` VARCHAR(7) NOT NULL,
	`code` VARCHAR(255) NOT NULL,
	`value` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_formule_date` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`formule_id` INT(11) NOT NULL,
	`period_id` INT(11) NOT NULL,
	`date` DATE NOT NULL,
	`place_remaining` INT(1) DEFAULT 0,
	PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

CREATE TABLE `speleo_formule_image` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(255) NOT NULL,
	`formule_id` INT(11) NOT NULL,
	`path` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

	INSERT INTO `speleo_extensions` VALUES (805,0,'Booking','component','com_booking','',1,1,0,0,'{\"name\":\"Booking\",\"type\":\"component\",\"creationDate\":\"December 2017\",\"author\":\"Raphael Colboc\",\"copyright\":\"Copyright Info\",\"authorEmail\":\"racol@smile.fr\",\"authorUrl\":\"\",\"version\":\"0.0.1\",\"description\":\"\",\"group\":\"\",\"filename\":\"booking\"}','{}','','',0,'0000-00-00 00:00:00',0,0);
