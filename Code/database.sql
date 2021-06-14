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

ALTER TABLE `user_account` ADD `isOnline` ENUM('online', 'offline') DEFAULT 'offline';

CREATE TABLE IF NOT EXISTS `diagnosis` (
    `diagnosis_id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    PRIMARY KEY (`diagnosis_id`)
) ;

CREATE TABLE IF NOT EXISTS `patient` (
                                         `patient_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                         `full_name` varchar(100) NOT NULL,
    `email` varchar(100)  NOT NULL,
    `address` varchar(100) DEFAULT NULL,
    `phone` varchar(60) NOT NULL,
    `status` ENUM('active', 'passive') NOT NULL,
    `birthday` date DEFAULT NULL,
    `user_id` INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`patient_id`),
    KEY `patient_FK` (`user_id`),
    CONSTRAINT `patient_FK` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
    ) ;

ALTER TABLE `patient` ADD `personal_no` varchar(10) DEFAULT NULL;


CREATE TABLE IF NOT EXISTS `patient_diagnosis` (
    `patient_id` bigint unsigned NOT NULL,
    `patient_diagnosis_id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `diagnosis_id` bigint unsigned NOT NULL,
    `details` text NOT NULL,
    `isCurrent` ENUM('current', 'past') NOT NULL,
    PRIMARY KEY (`patient_diagnosis_id`),
    CONSTRAINT `Patient_Diagnosis_FK` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `patient_diagnosis_FK_1` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnosis` (`diagnosis_id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ;

CREATE TABLE IF NOT EXISTS `product_category` (
    `category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NOT NULL,
    PRIMARY KEY (`category_id`)
) ;

CREATE TABLE IF NOT EXISTS `service` (
    `name` varchar(40) NOT NULL,
    `description` varchar(100) DEFAULT NULL,
    `price` int unsigned NOT NULL,
    `service_id` bigint unsigned NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`service_id`)
);

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

CREATE TABLE IF NOT EXISTS `transaction` (
     `date` datetime NOT NULL,
     `client` varchar(100) NOT NULL,
     `total` int unsigned NOT NULL,
     `transaction_id` bigint unsigned NOT NULL AUTO_INCREMENT,
     `service_id` bigint unsigned DEFAULT NULL,
     `type` ENUM(
         'income',
         'expenditure'
         ) NOT NULL,
     PRIMARY KEY (`transaction_id`),
     KEY `transaction_FK` (`service_id`),
     CONSTRAINT `transaction_FK` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ;

CREATE TABLE IF NOT EXISTS `sold_product` (
     `product_id` bigint unsigned NOT NULL,
     `transaction_id` bigint unsigned NOT NULL,
     PRIMARY KEY (`product_id`,`transaction_id`),
     KEY `product_instance_FK_1` (`transaction_id`),
     CONSTRAINT `product_instance_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
     CONSTRAINT `product_instance_FK_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;


CREATE TABLE IF NOT EXISTS `staff` (
     `employee_id` bigint unsigned NOT NULL AUTO_INCREMENT,
     `full_name` varchar(100) NOT NULL,
     `email` varchar(100) NOT NULL,
     `position` varchar(40) NOT NULL,
     `phone` varchar(30) NOT NULL,
     `address` varchar(100) DEFAULT NULL,
     `photo_uri` varchar(100) DEFAULT NULL,
     `birthday` date NOT NULL,
     `salary` int unsigned NOT NULL DEFAULT 25000,
     `status` ENUM('active','passive') NOT NULL,
     `user_id` INT UNSIGNED DEFAULT NULL,
     PRIMARY KEY (`employee_id`),
     KEY `staff_FK` (`user_id`),
     CONSTRAINT `staff_FK` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `appointment` (
      `a_id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `full_name` varchar(60) NOT NULL,
      `email` varchar(60) NOT NULL,
      `phone` varchar(30) NOT NULL,
      `status` ENUM(
             'approved',
             'rejected',
             'cancelled',
             'requested',
             'completed'
      ) NOT NULL,
      `time` datetime NOT NULL,
      `doctor_id` bigint unsigned DEFAULT NULL,
      `patient_id` bigint unsigned DEFAULT NULL,
      `transaction_id` bigint unsigned DEFAULT NULL,
      `service_id` bigint unsigned DEFAULT NULL,
      `description` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`a_id`),
      CONSTRAINT `appointment_FK` FOREIGN KEY (`doctor_id`) REFERENCES `staff` (`employee_id`) ON DELETE SET NULL,
      CONSTRAINT `appointment_FK_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE SET NULL,
      CONSTRAINT `appointment_FK_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE RESTRICT,
      CONSTRAINT `appointment_FK_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL
) ;


CREATE TABLE IF NOT EXISTS `health_records` (
      `record_id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `prescription` varchar(100) NOT NULL,
      `description` text,
      `date` datetime NOT NULL,
      `written_by` bigint unsigned NOT NULL,
      `patient_id` bigint unsigned NOT NULL,
      `patient_diagnosis_id` bigint unsigned NOT NULL,
      PRIMARY KEY (`record_id`),
      CONSTRAINT `health_records_FK` FOREIGN KEY (`written_by`) REFERENCES `staff` (`employee_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
      CONSTRAINT `health_records_FK_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `health_records_FK_2` FOREIGN KEY (`patient_diagnosis_id`) REFERENCES `patient_diagnosis` (`patient_diagnosis_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ;

-- Triggers

DELIMITER $$
CREATE TRIGGER Employee_salary
    BEFORE INSERT
    ON `staff` FOR EACH ROW
BEGIN
    IF NEW.salary < 25000 THEN
        UPDATE `staff` SET NEW.`salary` = 25000 WHERE `employee_id` = NEW.employee_id;
    END IF;
END $$
DELIMITER ;

DELIMITER //
CREATE TRIGGER AppointmentDate BEFORE INSERT ON Appointment
    FOR EACH ROW
BEGIN
    DECLARE currentdate DATE;
    SELECT CURDATE() INTO currentdate;
    IF NEW.status = 'Requested' or NEW.status = 'Approved' and  NEW.time < currentdate THEN
	SET NEW.time = DATE_ADD(currentdate, INTERVAL 7 DAY);
END IF;
END//
DELIMITER ;


-- Inserting values for testing purposes

INSERT INTO `diagnosis` (`name`) VALUES
('Refractive Errors'),
('Cataract'),
('Glaucoma'),
('Age Related Macular Degeneration'),
('Night Blindness'),
('Corneal Disease'),
('Myopia');

INSERT INTO `user_account` (`name`, `surname`, `password`, `username`, `role`) VALUES ("Denado", "Rabeli", "$2y$10$LFNAi.BqSeLNzJshHeSUCeSPNesayH7ryFF4qDyDJmJcV8yvSay1i","admin", 'admin');

/*
`date` datetime NOT NULL,
     `client` varchar(100) NOT NULL,
     `total` int unsigned NOT NULL,
     `transaction_id` bigint unsigned NOT NULL AUTO_INCREMENT,
     `service_id` bigint unsigned DEFAULT NULL,
     `type` ENUM(
         'income',
         'expenditure'
         ) NOT NULL,

*/
INSERT INTO `service` (`name`, `description`, `price`) VALUES ("Operation", "...", 400);
INSERT INTO `transaction` (`date`, `client`, `total`, `service_id`, `type`) VALUES ("2021-06-15", "unknown", 500, 1,"income");