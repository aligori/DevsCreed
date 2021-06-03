CREATE SCHEMA `eye_clinic`;

CREATE TABLE `user_account`(
    `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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

insert into `user_account` (username, password, role) values ("admin", "admin", "admin");