CREATE SCHEMA IF NOT EXISTS `eye_clinic`;

CREATE TABLE IF NOT EXISTS `user_account`(
                               `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                               `name` VARCHAR(40) NOT NULL,
                               `surname` VARCHAR(40) NOT NULL,
                               `password` VARCHAR(100) NOT NULL,
                               `username` VARCHAR(40) NOT NULL,
                               `role` ENUM(
                                   'admin',
                                   'doctor',
                                   'receptionist',
                                   'patient',
                                   'economist'
                                   ) NOT NULL,
                               PRIMARY KEY(`user_id`)
);

CREATE TABLE IF NOT EXISTS `diagnosis` (
                             `diagnosis_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(100) NOT NULL,
                             PRIMARY KEY (`diagnosis_id`)
) ;


-- ecms.`product category` definition

CREATE TABLE IF NOT EXISTS `product_category` (
                                    `category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(40) NOT NULL,
                                    PRIMARY KEY (`category_id`)
) ;


-- ecms.service definition

CREATE TABLE IF NOT EXISTS `service` (
                           `name` varchar(40) NOT NULL,
                           `description` varchar(100) DEFAULT NULL,
                           `price` int unsigned NOT NULL,
                           `service_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           PRIMARY KEY (`service_id`)
) ;


-- ecms.product definition

CREATE TABLE IF NOT EXISTS `product` (
                           `price` bigint unsigned NOT NULL,
                           `sell_price` bigint unsigned NOT NULL,
                           `quantity` int unsigned NOT NULL,
                           `product_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `name` varchar(100) NOT NULL,
                           `description` text,
                           `category_id` bigint unsigned NOT NULL,
                           PRIMARY KEY (`product_id`),
                           KEY `product_FK` (`category_id`),
                           CONSTRAINT `product_FK` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;


-- ecms.`transaction` definition

CREATE TABLE IF NOT EXISTS `transaction` (
                               `date` datetime NOT NULL,
                               `client` varchar(100) NOT NULL,
                               `total` int unsigned NOT NULL,
                               `transaction_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                               `service_id` bigint unsigned DEFAULT NULL,
                               PRIMARY KEY (`transaction_id`),
                               KEY `transaction_FK` (`service_id`),
                               CONSTRAINT `transaction_FK` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ;


-- ecms.patient definition

CREATE TABLE IF NOT EXISTS `patient` (
                           `patient_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `full_name` varchar(100) NOT NULL,
                           `email` varchar(100)  NOT NULL,
                           `address` varchar(100) DEFAULT NULL,
                           `phone` varchar(100) DEFAULT NULL,
                           `status` ENUM(
                                           'active',
                                           'passive'
                                       ) NOT NULL,
                           `birthday` date DEFAULT NULL,
                           `user_id` INT UNSIGNED DEFAULT NULL,
                           PRIMARY KEY (`patient_id`),
                           KEY `patient_FK` (`user_id`),
                           CONSTRAINT `patient_FK` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ;


-- ecms.`patient diagnosis` definition

CREATE TABLE IF NOT EXISTS `patient_diagnosis` (
                                     `details` text NOT NULL,
                                     `isCurrent` bit(1) NOT NULL,
                                     `patient_id` bigint unsigned NOT NULL,
                                     `patient_diagnosis_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                     `diagnosis_id` bigint unsigned NOT NULL,
                                     PRIMARY KEY (`patient_diagnosis_id`),
                                     KEY `Patient_Diagnosis_FK` (`patient_id`),
                                     KEY `patient_diagnosis_FK_1` (`diagnosis_id`),
                                     CONSTRAINT `Patient_Diagnosis_FK` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                     CONSTRAINT `patient_diagnosis_FK_1` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnosis` (`diagnosis_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;


-- ecms.`product instance` definition

CREATE TABLE IF NOT EXISTS `product_instance` (
                                    `product_id` bigint unsigned NOT NULL,
                                    `transaction_id` bigint unsigned NOT NULL,
                                    PRIMARY KEY (`product_id`,`transaction_id`),
                                    KEY `product_instance_FK_1` (`transaction_id`),
                                    CONSTRAINT `product_instance_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                                    CONSTRAINT `product_instance_FK_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;


-- ecms.staff definition

CREATE TABLE IF NOT EXISTS `staff` (
                         `employee_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `full_name` varchar(100) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `position` varchar(40) NOT NULL,
                         `phone` bigint unsigned NOT NULL,
                         `address` varchar(100) DEFAULT NULL,
                         `photo` blob,
                         `birthday` date NOT NULL,
                         `salary` int unsigned NOT NULL DEFAULT 25000,
                         `status` ENUM(
                                          'active',
                                          'passive'
                                      ) NOT NULL,
                         `user_id` INT UNSIGNED DEFAULT NULL,
                         PRIMARY KEY (`employee_id`),
                         KEY `staff_FK` (`user_id`),
                         CONSTRAINT `staff_FK` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

DELIMITER $$

CREATE TRIGGER after_employee_insert
    AFTER INSERT
    ON `staff` FOR EACH ROW
BEGIN
    IF NEW.salary < 25000 THEN
        UPDATE `staff` SET `salary` = 25000 WHERE `employee_id` = NEW.employee_id;
END IF;
END $$

DELIMITER ;


-- ecms.appointment definition

CREATE TABLE IF NOT EXISTS `appointment` (
                               `a_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                               `status` ENUM(
                                   'approved',
                                   'rejected',
                                   'cancelled',
                                   'requested',
                                   'completed'
                                   ) NOT NULL,
                               `time` datetime NOT NULL,
                               `assigned_to` bigint unsigned DEFAULT NULL,
                               `booked_by` bigint unsigned DEFAULT NULL,
                               `transaction_id` bigint unsigned NOT NULL,
                               `service_id` bigint unsigned DEFAULT NULL,
                               PRIMARY KEY (`a_id`),
                               KEY `appointment_FK` (`assigned_to`),
                               KEY `appointment_FK_1` (`booked_by`),
                               KEY `appointment_FK_2` (`transaction_id`),
                               KEY `appointment_FK_3` (`service_id`),
                               CONSTRAINT `appointment_FK` FOREIGN KEY (`assigned_to`) REFERENCES `staff` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
                               CONSTRAINT `appointment_FK_1` FOREIGN KEY (`booked_by`) REFERENCES `patient` (`patient_id`) ON DELETE SET NULL ON UPDATE CASCADE,
                               CONSTRAINT `appointment_FK_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                               CONSTRAINT `appointment_FK_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ;

-- ecms.`health records` definition

CREATE TABLE IF NOT EXISTS `health_records` (
                                  `record_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                  `prescription` varchar(100) NOT NULL,
                                  `description` text,
                                  `date` datetime NOT NULL,
                                  `written_by` bigint unsigned NOT NULL,
                                  `for_patient` bigint unsigned NOT NULL,
                                  `patient_diagnosis_id` bigint unsigned NOT NULL,
                                  PRIMARY KEY (`record_id`),
                                  KEY `health_records_FK` (`written_by`),
                                  KEY `health_records_FK_1` (`for_patient`),
                                  KEY `health_records_FK_2` (`patient_diagnosis_id`),
                                  CONSTRAINT `health_records_FK` FOREIGN KEY (`written_by`) REFERENCES `staff` (`employee_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                                  CONSTRAINT `health_records_FK_1` FOREIGN KEY (`for_patient`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                  CONSTRAINT `health_records_FK_2` FOREIGN KEY (`patient_diagnosis_id`) REFERENCES `patient_diagnosis` (`patient_diagnosis_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;

-- Inserting values for testing purposes


insert into `user_account` (`name`,`surname`,`username`, `password`, `role`) values ("MR.", "Admin","admin", "$2y$10$6Y5yT5HPf3JHwLv3uPobGuFWUBco.VfC.xyw0r94saz2awoIrsZEa", "admin");

insert into `staff` (`full_name`, `email`, `position`, `phone`, `birthday`, `salary`, `user_id`) values ("Denado Rabeli", "drabeli18@epoka.edu.al", "Administrator", "0692862999", "2000-06-29", 4000, 1);
