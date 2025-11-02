-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2024 at 04:19 PM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

CREATE TABLE `sessions` (
                            `id` VARCHAR(255) NOT NULL PRIMARY KEY,
                            `user_id` BIGINT UNSIGNED NULL,
                            `ip_address` VARCHAR(45) NULL,
                            `user_agent` TEXT NULL,
                            `payload` TEXT NOT NULL,
                            `last_activity` INT NOT NULL,
                            INDEX `sessions_user_id_index` (`user_id`),
                            INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
