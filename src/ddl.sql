-- This is a DDL specification using MariaDB SQL dialect

-- ecms.diagnosis definition

CREATE TABLE `diagnosis` (
                             `diagnosis_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(100) NOT NULL,
                             PRIMARY KEY (`diagnosis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.`role` definition

CREATE TABLE `role` (
                        `role_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `name` varchar(40) NOT NULL,
                        PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.`user account` definition

CREATE TABLE `user account` (
                                `uuid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                                `password` varchar(100) NOT NULL,
                                `username` varchar(40) NOT NULL,
                                `role_id` bigint unsigned NOT NULL,
                                PRIMARY KEY (`uuid`),
                                KEY `user_account_FK_1` (`role_id`),
                                CONSTRAINT `user_account_FK_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.patient definition

CREATE TABLE `patient` (
                           `patient_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `full name` varchar(100) NOT NULL,
                           `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                           `address` varchar(100) DEFAULT NULL,
                           `phone` varchar(100) DEFAULT NULL,
                           `birthday` date DEFAULT NULL,
                           `uuid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                           PRIMARY KEY (`patient_id`),
                           KEY `patient_FK` (`uuid`),
                           CONSTRAINT `patient_FK` FOREIGN KEY (`uuid`) REFERENCES `user account` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.`patient diagnosis` definition

CREATE TABLE `patient diagnosis` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.staff definition

CREATE TABLE `staff` (
                         `employee_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                         `full name` varchar(100) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `phone` bigint unsigned NOT NULL,
                         `photo` blob,
                         `birthday` date NOT NULL,
                         `salary` int unsigned NOT NULL,
                         `status` bit(1) NOT NULL,
                         `uuid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                         PRIMARY KEY (`employee_id`),
                         KEY `staff_FK` (`uuid`),
                         CONSTRAINT `staff_FK` FOREIGN KEY (`uuid`) REFERENCES `user account` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.appointment definition

CREATE TABLE `appointment` (
                               `a_id` bigint unsigned NOT NULL AUTO_INCREMENT,
                               `status` bit(1) NOT NULL,
                               `time` datetime NOT NULL,
                               `assigned_to` bigint unsigned DEFAULT NULL,
                               `booked_by` bigint unsigned DEFAULT NULL,
                               PRIMARY KEY (`a_id`),
                               KEY `appointment_FK` (`assigned_to`),
                               KEY `appointment_FK_1` (`booked_by`),
                               CONSTRAINT `appointment_FK` FOREIGN KEY (`assigned_to`) REFERENCES `staff` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
                               CONSTRAINT `appointment_FK_1` FOREIGN KEY (`booked_by`) REFERENCES `patient` (`patient_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ecms.`health records` definition

CREATE TABLE `health records` (
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
                                  CONSTRAINT `health_records_FK_2` FOREIGN KEY (`patient_diagnosis_id`) REFERENCES `patient diagnosis` (`patient_diagnosis_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;