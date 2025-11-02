-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2024 at 01:35 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.17

SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

CREATE TABLE `tracking_click_types` (
                                        `id` int(11) NOT NULL,
                                        `uid` varchar(32) NOT NULL,
                                        `code` varchar(32) NOT NULL,
                                        `description` text NOT NULL,
                                        `icon_type` varchar(10) DEFAULT 'icon',
                                        `icon_class` varchar(100) DEFAULT NULL,
                                        `icon_url` text DEFAULT NULL,
                                        `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracking_events`
--

CREATE TABLE `tracking_events` (
                                   `id` int(11) NOT NULL,
                                   `session_id` int(11) NOT NULL,
                                   `click_type_id` int(11) NOT NULL,
                                   `action_name` text DEFAULT NULL,
                                   `manager_click_id` text DEFAULT NULL,
                                   `manager_click_type` varchar(45) DEFAULT NULL,
                                   `count` int(11) DEFAULT 0,
                                   `url` text DEFAULT NULL,
                                   `section` varchar(100) DEFAULT 'default',
                                   `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracking_sessions`
--

CREATE TABLE `tracking_sessions` (
                                     `id` int(11) NOT NULL,
                                     `token` varchar(250) NOT NULL,
                                     `user_id` int(11) DEFAULT NULL,
                                     `business_id` int(11) NOT NULL,
                                     `business_by_counter_id` int(11) DEFAULT NULL,
                                     `is_guest` tinyint(1) NOT NULL DEFAULT 0,
                                     `source_id` int(11) NOT NULL,
                                     `referer_url` varchar(255) NOT NULL DEFAULT 'internal',
                                     `campaign_code` text DEFAULT NULL,
                                     `device_agent` varchar(255) NOT NULL DEFAULT 'default-agent',
                                     `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
                                     `country` varchar(250) DEFAULT NULL,
                                     `region` varchar(250) DEFAULT NULL,
                                     `city` varchar(250) DEFAULT NULL,
                                     `latitude` decimal(10,7) DEFAULT NULL,
                                     `longitude` decimal(10,7) DEFAULT NULL,
                                     `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracking_sources`
--

CREATE TABLE `tracking_sources` (
                                    `id` int(11) NOT NULL,
                                    `uid` varchar(32) NOT NULL,
                                    `code` varchar(32) NOT NULL,
                                    `description` text NOT NULL,
                                    `icon_type` varchar(10) DEFAULT 'icon',
                                    `icon_class` varchar(100) DEFAULT NULL,
                                    `icon_url` text DEFAULT NULL,
                                    `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tracking_click_types`
--
ALTER TABLE `tracking_click_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tracking_events`
--
ALTER TABLE `tracking_events`
    ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `click_type_id` (`click_type_id`);

--
-- Indexes for table `tracking_sessions`
--
ALTER TABLE `tracking_sessions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`);

--
-- Indexes for table `tracking_sources`
--
ALTER TABLE `tracking_sources`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tracking_events`
--
ALTER TABLE `tracking_events`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracking_sessions`
--
ALTER TABLE `tracking_sessions`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tracking_events`
--
ALTER TABLE `tracking_events`
    ADD CONSTRAINT `tracking_events_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `tracking_sessions` (`id`),
  ADD CONSTRAINT `tracking_events_ibfk_2` FOREIGN KEY (`click_type_id`) REFERENCES `tracking_click_types` (`id`);

--
-- Constraints for table `tracking_sessions`
--
ALTER TABLE `tracking_sessions`
    ADD CONSTRAINT `tracking_sessions_ibfk_1` FOREIGN KEY (`source_id`) REFERENCES `tracking_sources` (`id`);
SET

FOREIGN_KEY_CHECKS=1;
COMMIT;

