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


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u485345768_shop_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounting_account`
--

CREATE TABLE `accounting_account`
(
    `id`                         int(11) NOT NULL,
    `value`                      varchar(150) NOT NULL,
    `status`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `accounting_account_type_id` int(11) NOT NULL,
    `accounting_level_id`        int(11) NOT NULL,
    `description`                text         NOT NULL,
    `parent_key`                 int(11) DEFAULT NULL,
    `has_parent`                 int(11) NOT NULL,
    `is_parent`                  int(11) NOT NULL,
    `movement`                   int(11) NOT NULL,
    `rfc`                        int(11) NOT NULL,
    `cost_center`                int(11) NOT NULL,
    `base_amount`                int(11) NOT NULL,
    `base_amount_percentage`     float DEFAULT NULL,
    `base_amount_value`          float DEFAULT NULL,
    `business_id`                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_account_by_balances`
--

CREATE TABLE `accounting_account_by_balances`
(
    `id`                    int(11) NOT NULL COMMENT 'Contabilidad cuenta saldos',
    `register_manager_date` datetime       NOT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    `deleted_at`            timestamp NULL DEFAULT NULL,
    `amount`                decimal(10, 4) NOT NULL,
    `description`           text           NOT NULL,
    `user_id`               int(11) NOT NULL,
    `manager_type`          int(11) NOT NULL COMMENT '1=INGRESO 0=EGRESO',
    `accounting_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_account_type`
--

CREATE TABLE `accounting_account_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_bank`
--

CREATE TABLE `accounting_bank`
(
    `id`                    int(11) NOT NULL,
    `accounting_account_id` int(11) NOT NULL,
    `name`                  varchar(120) NOT NULL,
    `details`               text DEFAULT NULL,
    `user_id`               int(11) NOT NULL,
    `state`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `amount_current`        double(20, 4
) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_config_modules_account_by_account`
--

CREATE TABLE `accounting_config_modules_account_by_account`
(
    `id`                                 int(11) NOT NULL,
    `accounting_account_id`              int(11) NOT NULL,
    `description`                        text        NOT NULL,
    `code`                               varchar(45) NOT NULL,
    `accounting_config_modules_types_id` int(11) NOT NULL,
    `type_of_income`                     int(11) NOT NULL,
    `status`                             enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_config_modules_types`
--

CREATE TABLE `accounting_config_modules_types`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_level`
--

CREATE TABLE `accounting_level`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `color`       varchar(45)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_gamification`
--

CREATE TABLE `account_gamification`
(
    `id`                      int(11) NOT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `updated_at`              timestamp NULL DEFAULT NULL,
    `deleted_at`              timestamp NULL DEFAULT NULL,
    `user_id`                 int(11) NOT NULL,
    `balance_available_bee`   int(11) NOT NULL,
    `balance_available_queen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_gamification_by_movement`
--

CREATE TABLE `account_gamification_by_movement`
(
    `id`                         int(11) NOT NULL,
    `created_at`                 timestamp NULL DEFAULT NULL,
    `updated_at`                 timestamp NULL DEFAULT NULL,
    `deleted_at`                 timestamp NULL DEFAULT NULL,
    `account_gamification_id`    int(11) NOT NULL,
    `amount`                     int(11) NOT NULL,
    `type`                       int(11) NOT NULL COMMENT '0=Cash or check deposit(DE) - I\n1= Cash withdrawal(EX)-O\n2=Banking expenses(GB)-O\n3=Collection of card coupons(CC)-I\n4=Negotiated checks(NE)-I\n',
    `input_movement`             int(11) NOT NULL COMMENT '0=OUTPUT\n1=INPUT',
    `description`                text NOT NULL,
    `user_transaction_id`        int(11) NOT NULL COMMENT 'IT CAN BE A NULL ID ONLY IF IT IS OWN OF THE SYSTEM AND IT IS DONE X BEEHIVE',
    `type_money`                 int(11) NOT NULL DEFAULT 0 COMMENT '0=BEE\n1=QUEEN',
    `gamification_by_process_id` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_gamification_movement_by_business`
--

CREATE TABLE `account_gamification_movement_by_business`
(
    `id`                                  int(11) NOT NULL,
    `account_gamification_by_movement_id` int(11) NOT NULL,
    `business_id`                         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(125) DEFAULT NULL,
    `link`        varchar(125) NOT NULL,
    `parent_id`   int(11) DEFAULT NULL,
    `weight`      int(11) DEFAULT NULL,
    `icon`        varchar(100) DEFAULT NULL,
    `type`        int(11) NOT NULL DEFAULT 0 COMMENT '0=manager is link\n1=METHOD \n2=ROOT init menu root',
    `description` text         NOT NULL,
    `type_item`   int(11) NOT NULL DEFAULT 1 COMMENT '1=HAS CHILDRENS\n0=NOT CHILDREN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions_by_role`
--

CREATE TABLE `actions_by_role`
(
    `id`        int(11) NOT NULL,
    `action_id` int(11) NOT NULL,
    `role_id`   int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE `allergies`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allergies_by_history_clinic`
--

CREATE TABLE `allergies_by_history_clinic`
(
    `id`                int(11) NOT NULL,
    `allergies_id`      int(11) NOT NULL,
    `history_clinic_id` int(11) NOT NULL,
    `description`       text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowed_actions`
--

CREATE TABLE `allowed_actions`
(
    `id`        int(11) NOT NULL,
    `url`       varchar(45) NOT NULL,
    `action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allow_processes_threads`
--

CREATE TABLE `allow_processes_threads`
(
    `id`              int(11) NOT NULL,
    `name_process`    text NOT NULL,
    `thread_name`     text NOT NULL,
    `allow`           int(11) NOT NULL DEFAULT 1 COMMENT '0=no permitido\n1=permitido',
    `entity_plans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antecedent`
--

CREATE TABLE `antecedent`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(75) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antecedent_by_history_clinic`
--

CREATE TABLE `antecedent_by_history_clinic`
(
    `id`                int(11) NOT NULL,
    `history_clinic_id` int(11) NOT NULL,
    `antecedent_id`     int(11) NOT NULL,
    `description`       text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antecedent_family_members_by_history_clinic`
--

CREATE TABLE `antecedent_family_members_by_history_clinic`
(
    `id`                     int(11) NOT NULL,
    `history_clinic_id`      int(11) NOT NULL,
    `antecedent_id`          int(11) NOT NULL,
    `description`            text DEFAULT NULL,
    `people_relationship_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_entity_answer`
--

CREATE TABLE `askwer_entity_answer`
(
    `id`             int(11) NOT NULL,
    `askwer_form_id` int(11) NOT NULL,
    `creation_date`  datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_field`
--

CREATE TABLE `askwer_field`
(
    `id`                    int(11) NOT NULL,
    `label`                 text NOT NULL,
    `field_type`            int(11) NOT NULL,
    `widget_type`           int(11) DEFAULT NULL,
    `validations`           text DEFAULT NULL,
    `weight`                int(11) DEFAULT NULL,
    `askwer_section_id`     int(11) NOT NULL,
    `description`           text DEFAULT NULL,
    `style_option`          text DEFAULT NULL,
    `element_configuration` text DEFAULT NULL,
    `comment_allow`         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_field_value`
--

CREATE TABLE `askwer_field_value`
(
    `id`                      int(11) NOT NULL,
    `solutions`               text DEFAULT NULL,
    `askwer_field_id`         int(11) NOT NULL,
    `field_type`              int(11) NOT NULL,
    `askwer_entity_answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_form`
--

CREATE TABLE `askwer_form`
(
    `id`               int(11) NOT NULL,
    `name`             varchar(254) NOT NULL,
    `description`      text         DEFAULT NULL,
    `welcome_msg`      varchar(254) DEFAULT NULL,
    `leave_msg`        varchar(254) DEFAULT NULL,
    `creation_date`    datetime     DEFAULT NULL,
    `creation_user_id` int(11) DEFAULT NULL,
    `last_update_date` datetime     DEFAULT NULL,
    `update_user_id`   int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_option`
--

CREATE TABLE `askwer_option`
(
    `id`                 int(11) NOT NULL,
    `label`              varchar(254) NOT NULL,
    `weight`             int(11) DEFAULT NULL,
    `askwer_field_id`    int(11) NOT NULL,
    `option_score`       float        NOT NULL,
    `option_score_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_section`
--

CREATE TABLE `askwer_section`
(
    `id`             int(11) NOT NULL,
    `name`           varchar(254) NOT NULL,
    `weight`         int(11) DEFAULT NULL,
    `askwer_form_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `askwer_type`
--

CREATE TABLE `askwer_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(75) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `average_kardex`
--

CREATE TABLE `average_kardex`
(
    `id`                  int(11) NOT NULL,
    `units`               float          NOT NULL,
    `price`               decimal(10, 4) NOT NULL,
    `total`               decimal(10, 4) NOT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `product_id`          int(11) NOT NULL,
    `income_type`         int(11) NOT NULL,
    `business_id`         int(11) NOT NULL,
    `transaction_details` text        DEFAULT NULL,
    `entity_id`           int(11) DEFAULT NULL,
    `entity`              varchar(45) DEFAULT NULL,
    `existing_amount`     float          NOT NULL,
    `existing_punitary`   decimal(10, 4) NOT NULL,
    `existing_ptotal`     decimal(10, 4) NOT NULL,
    `entity_date`         datetime    DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_by_movement`
--

CREATE TABLE `bank_by_movement`
(
    `id`                    int(11) NOT NULL,
    `user_id`               int(11) NOT NULL,
    `state`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `movement_type`         int(11) NOT NULL COMMENT '0=INPUT\n1=OUTPUT',
    `accounting_account_id` int(11) NOT NULL,
    `details`               text DEFAULT NULL,
    `rode`                  double(20, 4
) NOT NULL,
  `date_current` datetime NOT NULL,
  `transaction_type` int(11) NOT NULL COMMENT '0=INDIRECTO\n1=DIRECTO',
  `entity_type` int(11) NOT NULL COMMENT '0=COMPRAS\n1=VENTAS\n2=DEVOLUCION EN COMPRAS\n3=DEVOLUCION EN VENTAS\n4=cash',
  `entity_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `available_balance` double(20,4) NOT NULL,
  `bank_reason_id` int(11) NOT NULL,
  `accounting_bank_id` int(11) NOT NULL,
  `document_number` int(11) NOT NULL,
  `transaction` int(11) NOT NULL DEFAULT 0 COMMENT '0=CHEQUE\n1=TRANSFERENCIAS\n2=DEPOSITOS\n3=RETIROS\n4=VENTAS\n5=COMPRAS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_by_transaction_management`
--

CREATE TABLE `bank_by_transaction_management`
(
    `id`                  int(11) NOT NULL,
    `created_at`          datetime NOT NULL,
    `update_at`           datetime DEFAULT NULL,
    `state`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `types_payments_id`   int(11) NOT NULL,
    `business_by_bank_id` int(11) NOT NULL,
    `entidad_data_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_movement_by_accounting_seat`
--

CREATE TABLE `bank_movement_by_accounting_seat`
(
    `id`                  int(11) NOT NULL,
    `daily_book_seat_id`  int(11) NOT NULL,
    `bank_by_movement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_reason`
--

CREATE TABLE `bank_reason`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business`
(
    `id`                        int(11) NOT NULL,
    `description`               text                  DEFAULT NULL,
    `title`                     varchar(150) NOT NULL,
    `email`                     varchar(150) NOT NULL,
    `page_url`                  varchar(250)          DEFAULT NULL,
    `phone_value`               varchar(45)  NOT NULL,
    `street_1`                  varchar(250) NOT NULL,
    `street_2`                  varchar(250) NOT NULL,
    `street_lat`                float        NOT NULL,
    `street_lng`                float        NOT NULL,
    `user_id`                   int(11) NOT NULL,
    `business_subcategories_id` int(11) NOT NULL,
    `created_at`                timestamp NULL DEFAULT NULL,
    `updated_at`                timestamp NULL DEFAULT NULL,
    `deleted_at`                timestamp NULL DEFAULT NULL,
    `status`                    enum('ACTIVE','INACTIVE') NOT NULL,
    `qualification`             float        NOT NULL DEFAULT 0,
    `source`                    varchar(350) NOT NULL DEFAULT 'nothing',
    `options_map`               text                  DEFAULT NULL COMMENT 'location,zoom',
    `has_document`              int(11) NOT NULL DEFAULT 0,
    `has_about`                 int(11) NOT NULL DEFAULT 0,
    `has_service_delivery`      int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT HAS\n1=HAS',
    `type_business`             int(11) NOT NULL COMMENT '0=PRODUCT\n1=SERVICE\n2=MIXT',
    `type_manager_payment`      int(11) NOT NULL COMMENT '0=OWNER PAYMENTE EFECTIVE\n1=COLMENA SE ENCARGA',
    `business_name`             text         NOT NULL,
    `keep_accounting`           int(11) NOT NULL DEFAULT 0,
    `type_ruc_id`               int(11) DEFAULT NULL,
    `allow_cash_and_banks`      int(11) NOT NULL DEFAULT 0,
    `entity_plans_id`           int(11) NOT NULL,
    `entity_position_fiscal_id` int(11) NOT NULL,
    `document`                  varchar(20)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_academic_offerings_by_data`
--

CREATE TABLE `business_academic_offerings_by_data`
(
    `id`                                int(11) NOT NULL,
    `title`                             text         NOT NULL,
    `description`                       text         NOT NULL,
    `status`                            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`                            varchar(350) DEFAULT 'nothing',
    `allow_source`                      int(11) NOT NULL DEFAULT 0,
    `title_icon`                        varchar(15)  DEFAULT NULL,
    `business_by_academic_offerings_id` int(11) NOT NULL,
    `link`                              varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_academic_offerings_data_by_information`
--

CREATE TABLE `business_academic_offerings_data_by_information`
(
    `id`                                     int(11) NOT NULL,
    `title`                                  text NOT NULL,
    `description`                            text NOT NULL,
    `status`                                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`                                 varchar(350) DEFAULT 'nothing',
    `allow_source`                           int(11) NOT NULL DEFAULT 0,
    `title_icon`                             varchar(15)  DEFAULT NULL,
    `business_academic_offerings_by_data_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_amenities`
--

CREATE TABLE `business_amenities`
(
    `id`                        int(11) NOT NULL,
    `value`                     varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
    `description`               text         DEFAULT NULL,
    `state`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`                    varchar(350) DEFAULT NULL,
    `type_source`               int(11) NOT NULL DEFAULT 0 COMMENT '0=ICON\n1=IMAGE',
    `business_subcategories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_about`
--

CREATE TABLE `business_by_about`
(
    `id`                int(11) NOT NULL,
    `business_id`       int(11) NOT NULL,
    `title_about`       varchar(150) NOT NULL,
    `description_about` text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_academic_offerings`
--

CREATE TABLE `business_by_academic_offerings`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(150) NOT NULL,
    `description`  text         DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`       varchar(350) DEFAULT 'nothing',
    `allow_source` int(11) NOT NULL DEFAULT 0,
    `subtitle`     text         DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `deleted_at`   timestamp NULL DEFAULT NULL,
    `business_id`  int(11) NOT NULL,
    `main`         int(11) NOT NULL DEFAULT 0 COMMENT '0=not main\n1=main'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_academic_offerings_institution`
--

CREATE TABLE `business_by_academic_offerings_institution`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(150) NOT NULL,
    `description`  text         DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`       varchar(350) DEFAULT 'nothing',
    `allow_source` int(11) NOT NULL DEFAULT 0,
    `subtitle`     text         DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `deleted_at`   timestamp NULL DEFAULT NULL,
    `business_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_amenities`
--

CREATE TABLE `business_by_amenities`
(
    `business_amenities_id` int(11) NOT NULL,
    `business_id`           int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_bank`
--

CREATE TABLE `business_by_bank`
(
    `id`                 int(11) NOT NULL,
    `accounting_bank_id` int(11) NOT NULL,
    `business_id`        int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_cash`
--

CREATE TABLE `business_by_cash`
(
    `id`          int(11) NOT NULL,
    `cash_id`     int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_cash_main`
--

CREATE TABLE `business_by_cash_main`
(
    `id`                  int(11) NOT NULL,
    `business_by_cash_id` int(11) NOT NULL,
    `user_id`             int(11) NOT NULL,
    `created_at`          datetime NOT NULL,
    `update_at`           datetime NOT NULL,
    `state`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `entidad_data_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_counter`
--

CREATE TABLE `business_by_counter`
(
    `id`          int(11) NOT NULL,
    `count`       int(11) NOT NULL DEFAULT 0,
    `business_id` int(11) NOT NULL,
    `action_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_coupon`
--

CREATE TABLE `business_by_coupon`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `days`        int(11) NOT NULL,
    `discount`    float        NOT NULL,
    `business_id` int(11) NOT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_daily_book_seat`
--

CREATE TABLE `business_by_daily_book_seat`
(
    `id`                 int(11) NOT NULL,
    `daily_book_seat_id` int(11) NOT NULL,
    `diary_book_id`      int(11) NOT NULL,
    `business_id`        int(11) NOT NULL,
    `entity`             varchar(100) DEFAULT NULL COMMENT 'un objeto id: y d qien entidad:factura_venta entidad:factura_compra id:id_factura	',
    `entity_id`          int(11) DEFAULT NULL COMMENT 'id:id_factura',
    `user_id`            int(11) NOT NULL,
    `level_4`            varchar(150) DEFAULT '	SIN ASIGNAR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_discount`
--

CREATE TABLE `business_by_discount`
(
    `id`                        int(11) NOT NULL,
    `code`                      varchar(150) NOT NULL,
    `name`                      text         NOT NULL,
    `type`                      int(11) NOT NULL DEFAULT 0 COMMENT '0=PERCENTAGE\n1=Cantidad Fija\n2=Free shipping\n3=Buy X, get Y',
    `type_apply`                int(11) NOT NULL DEFAULT 0 COMMENT '1=Complete order /Customers\n0=Products',
    `value`                     float        NOT NULL,
    `has_limit`                 int(11) NOT NULL DEFAULT 0 COMMENT '0=not has limit days\n1=has',
    `has_limit_end`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT HAS\n1=HAS',
    `limit_init`                datetime DEFAULT NULL,
    `limit_end`                 datetime DEFAULT NULL,
    `business_id`               int(11) NOT NULL,
    `minimum_requirements`      int(11) NOT NULL DEFAULT 0 COMMENT '0=None\n1=Minimum purchase amount\n2=Minimum quantity of articles',
    `apply_amount_min_products` int(11) NOT NULL DEFAULT 0,
    `amount_min_use`            int(11) NOT NULL DEFAULT 0 COMMENT '0=FOREVER\n1=LIMIT USE\n',
    `type_add_customers`        int(11) NOT NULL DEFAULT 0 COMMENT '0=ANY ONE\n1=SELECT CUSTOMERS\n2= GROUPS CUSTOMERS',
    `state`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`                timestamp NULL DEFAULT NULL,
    `updated_at`                timestamp NULL DEFAULT NULL,
    `deleted_at`                timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_documents`
--

CREATE TABLE `business_by_documents`
(
    `id`          int(11) NOT NULL,
    `title`       varchar(150) NOT NULL,
    `source`      varchar(350) NOT NULL DEFAULT 'nothing',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_employee_profile`
--

CREATE TABLE `business_by_employee_profile`
(
    `id`                                  int(11) NOT NULL,
    `human_resources_employee_profile_id` int(11) NOT NULL,
    `user_id`                             int(11) NOT NULL,
    `business_id`                         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_final_customer`
--

CREATE TABLE `business_by_final_customer`
(
    `id`          int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_frequent_question`
--

CREATE TABLE `business_by_frequent_question`
(
    `id`          int(11) NOT NULL,
    `title`       text NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_gallery`
--

CREATE TABLE `business_by_gallery`
(
    `id`          int(11) NOT NULL,
    `description` text         DEFAULT NULL COMMENT 'text',
    `src`         varchar(250) NOT NULL,
    `position`    int(11) NOT NULL DEFAULT 0,
    `type`        int(11) DEFAULT 0 COMMENT '0=CAPTION\\n1=CUSTOM-TEXT\\n2=IMAGE\\n3=SLOT\\n4=aspetct-ratio',
    `config`      text         DEFAULT NULL COMMENT 'styles css',
    `business_id` int(11) NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `title`       varchar(150) NOT NULL COMMENT 'name',
    `subtitle`    varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_gamification`
--

CREATE TABLE `business_by_gamification`
(
    `id`                      int(11) NOT NULL,
    `gamification_id`         int(11) NOT NULL,
    `business_id`             int(11) NOT NULL,
    `allow_exchange`          int(11) NOT NULL DEFAULT 0 COMMENT '0=not exchange to points\n1=allow exchange to points',
    `allow_exchange_business` int(11) NOT NULL DEFAULT 0 COMMENT '0=not exchange to points the other business\n1=allow exchange to points  the other business',
    `state`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_history`
--

CREATE TABLE `business_by_history`
(
    `id`            int(11) NOT NULL,
    `value`         varchar(150) NOT NULL,
    `description`   text         DEFAULT NULL,
    `status`        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`        varchar(350) DEFAULT 'nothing',
    `allow_source`  int(11) NOT NULL DEFAULT 0,
    `subtitle`      text         DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL,
    `deleted_at`    timestamp NULL DEFAULT NULL,
    `author`        varchar(150) NOT NULL,
    `author_titles` text         DEFAULT NULL,
    `business_id`   int(11) NOT NULL,
    `main`          int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MAIN\n1=MAIN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_information_custom`
--

CREATE TABLE `business_by_information_custom`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(150) NOT NULL,
    `description`  text         DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`       varchar(350) DEFAULT 'nothing',
    `allow_source` int(11) NOT NULL DEFAULT 0,
    `subtitle`     text         DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `deleted_at`   timestamp NULL DEFAULT NULL,
    `business_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_inventory_management`
--

CREATE TABLE `business_by_inventory_management`
(
    `id`                          int(11) NOT NULL,
    `type`                        int(11) NOT NULL DEFAULT 0 COMMENT '0=normal ,categorias left and subcategories right\n1=categories horizontal and subcategories horizontal',
    `config_management_inventory` mediumtext NOT NULL,
    `business_id`                 int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_inventory_management_subcategory`
--

CREATE TABLE `business_by_inventory_management_subcategory`
(
    `id`                     int(11) NOT NULL,
    `config_management`      mediumtext NOT NULL,
    `business_id`            int(11) NOT NULL,
    `product_subcategory_id` int(11) NOT NULL,
    `source`                 varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_invoice_buy`
--

CREATE TABLE `business_by_invoice_buy`
(
    `id`             int(11) NOT NULL,
    `invoice_buy_id` int(11) NOT NULL,
    `business_id`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_invoice_sale`
--

CREATE TABLE `business_by_invoice_sale`
(
    `id`              int(11) NOT NULL,
    `business_id`     int(11) NOT NULL,
    `invoice_sale_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_language`
--

CREATE TABLE `business_by_language`
(
    `id`          int(11) NOT NULL,
    `language_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `main`        int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_lodging_by_price`
--

CREATE TABLE `business_by_lodging_by_price`
(
    `id`                               int(11) NOT NULL,
    `business_id`                      int(11) NOT NULL,
    `lodging_type_of_room_by_price_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_menu_management_frontend`
--

CREATE TABLE `business_by_menu_management_frontend`
(
    `id`          int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `name`        varchar(125) NOT NULL,
    `link`        varchar(125) NOT NULL,
    `parent_id`   int(11) DEFAULT NULL,
    `weight`      int(11) DEFAULT NULL,
    `icon`        varchar(100) DEFAULT NULL,
    `type`        int(11) NOT NULL DEFAULT 0 COMMENT '0=manager is link\n1=METHOD \n2=ROOT init menu root',
    `description` text         NOT NULL,
    `type_item`   int(11) NOT NULL DEFAULT 1 COMMENT '0=LEVEL BASIC SIN CHILDRENS\n1=HAS CHILDREN\n2= HAS CHILDREN TO CHILDREN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_panorama`
--

CREATE TABLE `business_by_panorama`
(
    `id`                              int(11) NOT NULL,
    `business_id`                     int(11) NOT NULL,
    `status`                          enum('ACTIVE','INACTIVE') NOT NULL,
    `panorama_id`                     int(11) NOT NULL,
    `routes_map_by_routes_drawing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_partner_companies`
--

CREATE TABLE `business_by_partner_companies`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(150) NOT NULL,
    `description`  text         DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`       varchar(350) DEFAULT 'nothing',
    `allow_source` int(11) NOT NULL DEFAULT 0,
    `subtitle`     text         DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `deleted_at`   timestamp NULL DEFAULT NULL,
    `business_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_products`
--

CREATE TABLE `business_by_products`
(
    `id`          int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_products_parent`
--

CREATE TABLE `business_by_products_parent`
(
    `id`                int(11) NOT NULL,
    `business_id`       int(11) NOT NULL,
    `product_parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_promotion`
--

CREATE TABLE `business_by_promotion`
(
    `id`          int(11) NOT NULL,
    `start_time`  datetime     NOT NULL,
    `en_time`     datetime     NOT NULL,
    `name`        varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `products_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_qualification`
--

CREATE TABLE `business_by_qualification`
(
    `id`          int(11) NOT NULL,
    `value`       float NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `user_id`     int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_requirements`
--

CREATE TABLE `business_by_requirements`
(
    `id`          int(11) NOT NULL,
    `title`       text NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_routes_map`
--

CREATE TABLE `business_by_routes_map`
(
    `id`            int(11) NOT NULL,
    `business_id`   int(11) NOT NULL,
    `routes_map_id` int(11) NOT NULL,
    `status`        enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL,
    `deleted_at`    timestamp NULL DEFAULT NULL,
    `type_shortcut` int(11) NOT NULL DEFAULT 0 COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_schedule`
--

CREATE TABLE `business_by_schedule`
(
    `id`                        int(11) NOT NULL,
    `type`                      int(11) NOT NULL COMMENT '0=24\n1=SHEDULE DESGLOCE\n',
    `open`                      int(11) NOT NULL DEFAULT 0 COMMENT '0=CERRRADO\n1=ABIERTO',
    `business_id`               int(11) NOT NULL,
    `status`                    enum('ACTIVE','INACTIVE') NOT NULL,
    `schedule_days_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_scheduling_date`
--

CREATE TABLE `business_by_scheduling_date`
(
    `id`                 int(11) NOT NULL,
    `scheduling_date_id` int(11) NOT NULL,
    `business_id`        int(11) NOT NULL,
    `owner_id`           int(11) NOT NULL,
    `user_id`            int(11) NOT NULL,
    `entity`             int(11) NOT NULL,
    `entity_id`          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_services`
--

CREATE TABLE `business_by_services`
(
    `id`                    int(11) NOT NULL,
    `product_id`            int(11) NOT NULL,
    `business_id`           int(11) NOT NULL,
    `accounting_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_shipping_rate`
--

CREATE TABLE `business_by_shipping_rate`
(
    `id`                        int(11) NOT NULL,
    `shipping_rate_business_id` int(11) NOT NULL,
    `business_id`               int(11) NOT NULL,
    `state`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_social_networks`
--

CREATE TABLE `business_by_social_networks`
(
    `id`          int(11) NOT NULL,
    `type`        int(11) NOT NULL COMMENT '0=FACEBOOK\\n1=INSTAGRAM\\n',
    `url`         varchar(500) NOT NULL,
    `business_id` int(11) NOT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_by_tax`
--

CREATE TABLE `business_by_tax`
(
    `id`          int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `taxes_id`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_categories`
--

CREATE TABLE `business_categories`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45)  NOT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `src`         varchar(250) NOT NULL,
    `has_icon`    int(11) NOT NULL DEFAULT 0,
    `icon_class`  varchar(20)  NOT NULL DEFAULT 'anyone',
    `description` text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_counter_custom`
--

CREATE TABLE `business_counter_custom`
(
    `id`          int(11) NOT NULL,
    `title`       text NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_counter_custom_by_data`
--

CREATE TABLE `business_counter_custom_by_data`
(
    `id`                         int(11) NOT NULL,
    `title`                      text  NOT NULL,
    `description`                text        DEFAULT NULL,
    `status`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`                 timestamp NULL DEFAULT NULL,
    `updated_at`                 timestamp NULL DEFAULT NULL,
    `deleted_at`                 timestamp NULL DEFAULT NULL,
    `business_counter_custom_id` int(11) NOT NULL,
    `count`                      float NOT NULL,
    `count_percentage`           float NOT NULL,
    `count_symbol`               varchar(75) DEFAULT '%'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_disbursement`
--

CREATE TABLE `business_disbursement`
(
    `id`             int(11) NOT NULL,
    `business_id`    int(11) NOT NULL,
    `bank_id`        int(11) NOT NULL,
    `account_number` varchar(150) NOT NULL,
    `type_account`   int(11) NOT NULL DEFAULT 0 COMMENT '0=CORRIENTE\n1=AHORROS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_discount_by_product`
--

CREATE TABLE `business_discount_by_product`
(
    `id`          int(11) NOT NULL,
    `start_time`  datetime NOT NULL,
    `en_time`     datetime NOT NULL,
    `percentage`  float    NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `products_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_history_by_data`
--

CREATE TABLE `business_history_by_data`
(
    `id`                     int(11) NOT NULL,
    `title`                  text NOT NULL,
    `description`            text NOT NULL,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`                 varchar(350) DEFAULT 'nothing',
    `allow_source`           int(11) NOT NULL DEFAULT 0,
    `business_by_history_id` int(11) NOT NULL,
    `title_icon`             varchar(15)  DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_location`
--

CREATE TABLE `business_location`
(
    `id`          int(11) NOT NULL,
    `zones_id`    int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_panorama_by_points`
--

CREATE TABLE `business_panorama_by_points`
(
    `id`                      int(11) NOT NULL,
    `business_by_panorama_id` int(11) NOT NULL,
    `panorama_points_id`      int(11) NOT NULL,
    `panorama_id`             int(11) NOT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_schedule_by_breakdown`
--

CREATE TABLE `business_schedule_by_breakdown`
(
    `id`                      int(11) NOT NULL,
    `start_time`              time NOT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL,
    `business_by_schedule_id` int(11) NOT NULL,
    `end_time`                time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_subcategories`
--

CREATE TABLE `business_subcategories`
(
    `id`                     int(11) NOT NULL,
    `name`                   varchar(45)  NOT NULL,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`             timestamp NULL DEFAULT NULL,
    `updated_at`             timestamp NULL DEFAULT NULL,
    `deleted_at`             timestamp NULL DEFAULT NULL,
    `business_categories_id` int(11) NOT NULL,
    `src`                    varchar(250) NOT NULL,
    `has_icon`               int(11) NOT NULL DEFAULT 0,
    `icon_class`             varchar(20)  NOT NULL DEFAULT 'anyone',
    `description`            text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bussiness_by_repair`
--

CREATE TABLE `bussiness_by_repair`
(
    `id`          int(11) NOT NULL,
    `repair_id`   int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caja`
--

CREATE TABLE `caja`
(
    `id`                       int(11) NOT NULL,
    `owner_id`                 int(11) NOT NULL,
    `fecha_apertura`           datetime NOT NULL,
    `fecha_cierre`             datetime DEFAULT NULL,
    `estado`                   enum('ABIERTA','CERRADA') NOT NULL DEFAULT 'ABIERTA',
    `caja_inicio`              float    NOT NULL COMMENT 'El monto del valor iniciado en l momento de d iniciar la sesion',
    `caja_cierre_value`        float    NOT NULL COMMENT 'El monto del valor finalizado en l momento de d iniciar la sesion',
    `caja_terminal_gestion_id` int(11) NOT NULL,
    `fecha_creacion`           datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caja_catalogo_billete`
--

CREATE TABLE `caja_catalogo_billete`
(
    `id`                             int(11) NOT NULL,
    `caja_tipo_billete_id`           int(11) NOT NULL,
    `value`                          varchar(100) NOT NULL COMMENT '50 cvs,50 dolares',
    `caja_catalogo_tipo_fraccion_id` int(11) NOT NULL,
    `valor`                          float DEFAULT NULL COMMENT 'el valor de la moneda en entero o billete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caja_catalogo_tipo_fraccion`
--

CREATE TABLE `caja_catalogo_tipo_fraccion`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caja_has_entidad`
--

CREATE TABLE `caja_has_entidad`
(
    `id`          int(11) NOT NULL,
    `business_id` int(11) NOT NULL,
    `caja_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caja_tipo_billete`
--

CREATE TABLE `caja_tipo_billete`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capacitaciones`
--

CREATE TABLE `capacitaciones`
(
    `id`                     int(11) NOT NULL,
    `tema`                   varchar(45) NOT NULL,
    `fecha_inicio`           date         DEFAULT NULL,
    `fecha_fin`              date         DEFAULT NULL,
    `duracion`               varchar(45)  DEFAULT NULL,
    `certificado`            varchar(200) DEFAULT NULL,
    `capacitaciones_tipo_id` int(11) NOT NULL,
    `entidad_id`             varchar(45) NOT NULL,
    `entidad_tipo`           varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capacitaciones_tipo`
--

CREATE TABLE `capacitaciones_tipo`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(75) NOT NULL,
    `descripcion` text DEFAULT NULL,
    `estado`      enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash`
--

CREATE TABLE `cash`
(
    `id`                    int(11) NOT NULL,
    `accounting_account_id` int(11) NOT NULL,
    `name`                  varchar(120) NOT NULL,
    `details`               text DEFAULT NULL,
    `user_id`               int(11) NOT NULL,
    `state`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `amount_current`        double(20, 4
) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_by_movement`
--

CREATE TABLE `cash_by_movement`
(
    `id`                    int(11) NOT NULL,
    `user_id`               int(11) NOT NULL,
    `state`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `cash_id`               int(11) NOT NULL,
    `movement_type`         int(11) NOT NULL COMMENT '0=INPUT\n1=OUTPUT',
    `cash_reason_id`        int(11) NOT NULL,
    `accounting_account_id` int(11) NOT NULL,
    `details`               text DEFAULT NULL,
    `rode`                  double(20, 4
) NOT NULL,
  `date_current` datetime NOT NULL,
  `transaction_type` int(11) NOT NULL COMMENT '0=INDIRECTO\n1=DIRECTO',
  `entity_type` int(11) NOT NULL COMMENT '0=COMPRAS\n1=VENTAS\n2=DEVOLUCION EN COMPRAS\n3=DEVOLUCION EN VENTAS\n4=cash',
  `entity_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `available_balance` double(20,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_by_transaction_management`
--

CREATE TABLE `cash_by_transaction_management`
(
    `id`                  int(11) NOT NULL,
    `created_at`          datetime NOT NULL,
    `update_at`           datetime DEFAULT NULL,
    `state`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `types_payments_id`   int(11) NOT NULL,
    `business_by_cash_id` int(11) NOT NULL,
    `entidad_data_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_by_user`
--

CREATE TABLE `cash_by_user`
(
    `id`                  int(11) NOT NULL,
    `user_id`             int(11) NOT NULL,
    `business_by_cash_id` int(11) NOT NULL,
    `owner_id`            int(11) NOT NULL,
    `entidad_data_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_movement_by_accounting_seat`
--

CREATE TABLE `cash_movement_by_accounting_seat`
(
    `id`                  int(11) NOT NULL,
    `cash_by_movement_id` int(11) NOT NULL,
    `daily_book_seat_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_reason`
--

CREATE TABLE `cash_reason`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `location`    point       NOT NULL,
    `province_id` int(11) NOT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `place_id`    varchar(200) DEFAULT 'none-id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinical_by_history_clinic`
--

CREATE TABLE `clinical_by_history_clinic`
(
    `id`                int(11) NOT NULL,
    `history_clinic_id` int(11) NOT NULL,
    `clinical_exam_id`  int(11) NOT NULL,
    `description`       varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinical_exam`
--

CREATE TABLE `clinical_exam`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(75) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counter_by_entity`
--

CREATE TABLE `counter_by_entity`
(
    `id`                     int(11) NOT NULL,
    `business_by_counter_id` int(11) NOT NULL,
    `created_at`             timestamp NULL DEFAULT NULL,
    `updated_at`             timestamp NULL DEFAULT NULL,
    `deleted_at`             timestamp NULL DEFAULT NULL,
    `is_guess`               int(11) NOT NULL,
    `user_id`                int(11) NOT NULL DEFAULT 0,
    `token`                  varchar(250) NOT NULL,
    `manager_click_type`     varchar(45) DEFAULT NULL,
    `manager_click_id`       text        DEFAULT NULL,
    `action_name`            text        DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counter_by_log_user_to_business`
--

CREATE TABLE `counter_by_log_user_to_business`
(
    `id`                 int(11) NOT NULL,
    `created_at`         timestamp NULL DEFAULT NULL,
    `updated_at`         timestamp NULL DEFAULT NULL,
    `deleted_at`         timestamp NULL DEFAULT NULL,
    `business_id`        int(11) NOT NULL,
    `user_id`            int(11) NOT NULL,
    `is_guess`           int(11) NOT NULL,
    `manager_click_type` varchar(45) DEFAULT NULL,
    `manager_click_id`   text        DEFAULT NULL,
    `action_name`        text        DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries`
(
    `id`         int(11) NOT NULL,
    `name`       varchar(64) NOT NULL,
    `status`     enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `deleted_at` timestamp NULL DEFAULT NULL,
    `place_id`   varchar(200) DEFAULT 'none-id',
    `iso_codes`  varchar(8)  NOT NULL,
    `phone_code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course`
(
    `id`                       int(11) NOT NULL,
    `value`                    varchar(250) NOT NULL,
    `description`              text DEFAULT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `course_faculty_id`        int(11) NOT NULL,
    `course_subject_matter_id` int(11) NOT NULL,
    `online`                   int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT ONLINE\n1=ONLINE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_faculty`
--

CREATE TABLE `course_faculty`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_subject_matter`
--

CREATE TABLE `course_subject_matter`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer`
(
    `id`                            int(11) NOT NULL,
    `identification_document`       varchar(45) NOT NULL,
    `src`                           varchar(250) DEFAULT NULL,
    `people_type_identification_id` int(11) NOT NULL,
    `people_id`                     int(11) NOT NULL,
    `business_name`                 varchar(150) DEFAULT NULL COMMENT 'razon social',
    `business_reason`               varchar(150) DEFAULT NULL COMMENT 'razon comercial',
    `ruc_type_id`                   int(11) NOT NULL,
    `has_representative`            int(11) NOT NULL DEFAULT 0,
    `representative_fullname`       varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_by_contacts`
--

CREATE TABLE `customer_by_contacts`
(
    `id`                  int(11) NOT NULL,
    `customer_id`         int(11) NOT NULL,
    `customer_contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_by_information`
--

CREATE TABLE `customer_by_information`
(
    `id`                    int(11) NOT NULL,
    `customer_id`           int(11) NOT NULL,
    `people_nationality_id` int(11) NOT NULL,
    `people_profession_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_by_profile`
--

CREATE TABLE `customer_by_profile`
(
    `id`          int(11) NOT NULL,
    `customer_id` int(11) NOT NULL,
    `user_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_by_student`
--

CREATE TABLE `customer_by_student`
(
    `id`          int(11) NOT NULL,
    `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_profile_by_location`
--

CREATE TABLE `customer_profile_by_location`
(
    `id`                     int(11) NOT NULL,
    `zones_id`               int(11) NOT NULL,
    `customer_by_profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_book_seat`
--

CREATE TABLE `daily_book_seat`
(
    `id`                    int(11) NOT NULL,
    `value`                 varchar(350) NOT NULL,
    `description`           text DEFAULT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    `deleted_at`            timestamp NULL DEFAULT NULL,
    `register_manager_date` datetime     NOT NULL,
    `entidad_data_id`       int(11) NOT NULL,
    `status`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_by_business_manager`
--

CREATE TABLE `delivery_by_business_manager`
(
    `id`             int(11) NOT NULL,
    `customer_id`    int(11) NOT NULL,
    `number_box`     int(11) NOT NULL,
    `description`    text         NOT NULL,
    `address_id`     int(11) NOT NULL,
    `phone_id`       int(11) NOT NULL,
    `status`         enum('ACTIVE','INACTIVE','INITIALIZED','DELIVERED','CANCELLED','DELETED') NOT NULL DEFAULT 'ACTIVE',
    `user_id`        int(11) NOT NULL DEFAULT 0,
    `number_invoice` varchar(300) NOT NULL DEFAULT '000',
    `created_at`     datetime              DEFAULT NULL,
    `updated_at`     datetime              DEFAULT NULL,
    `business_id`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dental_piece`
--

CREATE TABLE `dental_piece`
(
    `id`        int(11) NOT NULL,
    `name`      varchar(45) NOT NULL,
    `piece`     varchar(5)  NOT NULL,
    `dentition` enum('Perm-FDI') DEFAULT 'Perm-FDI'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dental_piece_by_odontogram`
--

CREATE TABLE `dental_piece_by_odontogram`
(
    `id`                          int(11) NOT NULL,
    `created_at`                  timestamp NULL DEFAULT NULL,
    `updated_at`                  timestamp NULL DEFAULT NULL,
    `deleted_at`                  timestamp NULL DEFAULT NULL,
    `status`                      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`                 text DEFAULT NULL,
    `type`                        enum('PERMANENT','TEMPORARY') NOT NULL DEFAULT 'PERMANENT',
    `dental_piece_id`             int(11) NOT NULL,
    `reference_piece_position_id` int(11) NOT NULL,
    `reference_piece_id`          int(11) NOT NULL,
    `odontogram_by_patient_id`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diary_book`
--

CREATE TABLE `diary_book`
(
    `id`                    int(11) NOT NULL,
    `value`                 decimal(10, 4) NOT NULL,
    `manager_type`          int(11) NOT NULL DEFAULT 0 COMMENT '0 =DEBE entra 1=HABER sale',
    `accounting_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_by_words`
--


CREATE TABLE `discount_by_customers`
(
    `business_by_discount_id` int(11) NOT NULL,
    `customer_id`             int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount_by_products`
--

CREATE TABLE `discount_by_products`
(
    `business_by_discount_id` int(11) NOT NULL,
    `product_id`              int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_askwer_type`
--

CREATE TABLE `educational_institution_askwer_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_by_business`
--

CREATE TABLE `educational_institution_by_business`
(
    `id`                                     int(11) NOT NULL,
    `educational_institution_askwer_type_id` int(11) NOT NULL,
    `business_id`                            int(11) NOT NULL,
    `askwer_form_id`                         int(11) NOT NULL,
    `create_user_id`                         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_by_course`
--

CREATE TABLE `educational_institution_by_course`
(
    `id`              int(11) NOT NULL,
    `course_id`       int(11) NOT NULL,
    `business_id`     int(11) NOT NULL,
    `number_students` int(11) NOT NULL,
    `number_hours`    decimal(10, 2) NOT NULL,
    `status`          enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_course_activities_by_askwer`
--

CREATE TABLE `educational_institution_course_activities_by_askwer`
(
    `id`                                              int(11) NOT NULL,
    `educational_institution_by_business_id`          int(11) NOT NULL,
    `educational_institution_course_by_activities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_course_by_activities`
--

CREATE TABLE `educational_institution_course_by_activities`
(
    `id`                                              int(11) NOT NULL,
    `educational_institution_course_by_supervisor_id` int(11) NOT NULL,
    `name`                                            varchar(120) NOT NULL,
    `description`                                     text         NOT NULL,
    `status`                                          enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `type`                                            int(11) NOT NULL COMMENT '	0=there is no form 1= form exists',
    `allow_resources`                                 int(11) NOT NULL COMMENT '	0=not allow 1=allow',
    `type_test`                                       int(11) NOT NULL COMMENT '0=no test 1=test'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_course_by_students`
--

CREATE TABLE `educational_institution_course_by_students`
(
    `id`                                   int(11) NOT NULL,
    `status`                               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `status_course`                        int(11) NOT NULL DEFAULT 0 COMMENT '	0=INICIADO 1=FINALIZADO Y LISTO 3=NO APROBADO	',
    `business_id`                          int(11) NOT NULL,
    `educational_institution_by_course_id` int(11) NOT NULL,
    `students_information_id`              int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_course_by_supervisor`
--

CREATE TABLE `educational_institution_course_by_supervisor`
(
    `id`                                   int(11) NOT NULL,
    `business_by_employee_profile_id`      int(11) NOT NULL,
    `business_id`                          int(11) NOT NULL,
    `educational_institution_by_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_students_course_by_activities`
--

CREATE TABLE `educational_institution_students_course_by_activities`
(
    `id`                                              int(11) NOT NULL,
    `educational_institution_course_by_activities_id` int(11) NOT NULL,
    `educational_institution_course_by_students_id`   int(11) NOT NULL,
    `status_activity`                                 int(11) NOT NULL DEFAULT 0 COMMENT '1=REVIEWED 0=TO CHECK	',
    `status_score`                                    int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT APPROVED 1=APPROVED 2=REPEAT',
    `score`                                           float    NOT NULL DEFAULT 0,
    `created_at`                                      datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `educational_institution_test_by_answers`
--

CREATE TABLE `educational_institution_test_by_answers`
(
    `id`                                                       int(11) NOT NULL,
    `askwer_entity_answer_id`                                  int(11) NOT NULL,
    `educational_institution_students_course_by_activities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_authorization_configuration`
--

CREATE TABLE `entity_authorization_configuration`
(
    `id`                        int(11) NOT NULL,
    `authorization_code`        varchar(700) NOT NULL,
    `entity_data_id`            int(11) NOT NULL,
    `description`               text DEFAULT NULL,
    `type`                      enum('INVOICE','REFERENCE GUIDE','RETENTIONS','RETENTION RECEIPT','CREDIT NOTES','DEBIT NOTES') NOT NULL,
    `state`                     enum('ACTIVE','INACTIVE') DEFAULT NULL COMMENT 'solo debe haber una ',
    `establishment_number`      int(11) DEFAULT NULL,
    `expiration_date`           datetime     NOT NULL,
    `allow_authorization_code`  int(11) NOT NULL DEFAULT 1 COMMENT '0=NO\n1=SI',
    `type_of_document_issuance` int(11) NOT NULL DEFAULT 0 COMMENT '0=FISICO\n1=DIGITAL',
    `type_process`              int(11) NOT NULL DEFAULT 0 COMMENT '0=manual=NO\n1=sequential=SI=automatico'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_has_invoice_sale`
--

CREATE TABLE `entity_has_invoice_sale`
(
    `id`               int(11) NOT NULL,
    `factura_venta_id` int(11) NOT NULL,
    `entidad_data_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_plans`
--

CREATE TABLE `entity_plans`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_position_fiscal`
--

CREATE TABLE `entity_position_fiscal`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(45) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_resources`
--

CREATE TABLE `entity_resources`
(
    `id`            int(11) NOT NULL,
    `url_img`       varchar(500) NOT NULL,
    `entity`        enum('LOGO','LOGO PROFORMAS','LOGO PUNTO VENTA','LOGO COMPRAS','FACTURA','COMPROBANTE DE RETENCION','GUIA REMISION','NOTAS DE CREDITO','NOTAS DE DEBITO') DEFAULT NULL,
    `date_registre` datetime     NOT NULL,
    `main`          int(11) NOT NULL DEFAULT 1 COMMENT '1=PRINCIPAL \n0=NO PRINCIPAL',
    `business_id`   int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_by_kit`
--

CREATE TABLE `events_trails_by_kit`
(
    `id`                       int(11) NOT NULL,
    `entity_type`              int(11) NOT NULL COMMENT '0=PRENDA,VESTIMENTA,events_trails_kit_pieces_id\n1=kit,utencillo extra',
    `entity_id`                int(11) NOT NULL COMMENT '1=service\n0=product',
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_by_registration_points`
--

CREATE TABLE `events_trails_by_registration_points`
(
    `id`                                        int(11) NOT NULL,
    `events_trails_registration_by_customer_id` int(11) NOT NULL,
    `events_trails_registration_points_id`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_distances`
--

CREATE TABLE `events_trails_distances`
(
    `id`                          int(11) NOT NULL,
    `value`                       varchar(250) NOT NULL,
    `value_distance`              float        NOT NULL,
    `description`                 text DEFAULT NULL,
    `status`                      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id`    int(11) NOT NULL,
    `price`                       float        NOT NULL,
    `type`                        enum('SINGLE','COUPLE') NOT NULL DEFAULT 'SINGLE' COMMENT 'SING=INDIVIDUAL\n',
    `events_trails_type_teams_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_kit_pieces`
--

CREATE TABLE `events_trails_kit_pieces`
(
    `id`                       int(11) NOT NULL,
    `value`                    varchar(250) NOT NULL,
    `description`              text DEFAULT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_project`
--

CREATE TABLE `events_trails_project`
(
    `id`                     int(11) NOT NULL,
    `value`                  varchar(250) NOT NULL,
    `description`            text                  DEFAULT NULL,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `date_init_project`      datetime     NOT NULL,
    `date_end_project`       datetime     NOT NULL,
    `business_id`            int(11) NOT NULL,
    `events_trails_types_id` int(11) NOT NULL,
    `source`                 varchar(350) NOT NULL DEFAULT 'nothing'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_project_by_routes_map`
--

CREATE TABLE `events_trails_project_by_routes_map`
(
    `id`                       int(11) NOT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`               timestamp NULL DEFAULT NULL,
    `updated_at`               timestamp NULL DEFAULT NULL,
    `deleted_at`               timestamp NULL DEFAULT NULL,
    `type_shortcut`            int(11) NOT NULL DEFAULT 0 COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico',
    `routes_map_id`            int(11) NOT NULL,
    `events_trails_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_registration_by_customer`
--

CREATE TABLE `events_trails_registration_by_customer`
(
    `id`                                  int(11) NOT NULL,
    `events_trails_project_id`            int(11) NOT NULL,
    `user_id`                             int(11) NOT NULL,
    `events_trails_type_of_categories_id` int(11) NOT NULL,
    `events_trails_distances_id`          int(11) NOT NULL,
    `type_registration`                   int(11) NOT NULL DEFAULT 0 COMMENT '0=BY PAGE PROJECT\n1=POINT OF SALE',
    `manager_id`                          int(11) NOT NULL COMMENT 'order_shopping_cart_by_details'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_registration_payments_by_business`
--

CREATE TABLE `events_trails_registration_payments_by_business`
(
    `id`                                   int(11) NOT NULL,
    `events_trails_registration_points_id` int(11) NOT NULL,
    `order_shopping_cart_id`               int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_registration_points`
--

CREATE TABLE `events_trails_registration_points`
(
    `id`                       int(11) NOT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id` int(11) NOT NULL,
    `business_id`              int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_types`
--

CREATE TABLE `events_trails_types`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_type_of_categories`
--

CREATE TABLE `events_trails_type_of_categories`
(
    `id`                       int(11) NOT NULL,
    `value`                    varchar(250) NOT NULL,
    `description`              text DEFAULT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id` int(11) NOT NULL,
    `has_limit`                int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT\n1=HAS',
    `init_limit`               int(11) NOT NULL DEFAULT 0,
    `end_limit`                int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_trails_type_teams`
--

CREATE TABLE `events_trails_type_teams`
(
    `id`                       int(11) NOT NULL,
    `value`                    varchar(250) NOT NULL,
    `description`              text DEFAULT NULL,
    `status`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `events_trails_project_id` int(11) NOT NULL,
    `quantity`                 int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_by_assistance`
--

CREATE TABLE `event_by_assistance`
(
    `id`          int(11) NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `customer_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formacion_academica`
--

CREATE TABLE `formacion_academica`
(
    `id`                     int(11) NOT NULL,
    `profesion`              varchar(45) DEFAULT NULL,
    `titulo_academico`       varchar(45) DEFAULT NULL,
    `universidad_titulos_id` int(11) NOT NULL,
    `entidad_id`             varchar(45) NOT NULL,
    `entidad_tipo`           varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification`
--

CREATE TABLE `gamification`
(
    `id`               int(11) NOT NULL,
    `value`            varchar(200) NOT NULL,
    `description`      text DEFAULT NULL,
    `value_unit`       float        NOT NULL,
    `state`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `maximum_exchange` int(11) NOT NULL DEFAULT 0 COMMENT 'LIMIT FOR ALLOW EXCHANGE POINTS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_allies`
--

CREATE TABLE `gamification_by_allies`
(
    `id`              int(11) NOT NULL,
    `business_id`     int(11) NOT NULL,
    `gamification_id` int(11) NOT NULL,
    `state`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL,
    `deleted_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_badges`
--

CREATE TABLE `gamification_by_badges`
(
    `id`              int(11) NOT NULL,
    `source`          varchar(350) NOT NULL DEFAULT 'nothing',
    `title`           text         NOT NULL,
    `subtitle`        text                  DEFAULT NULL,
    `description`     text         NOT NULL,
    `state`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `gamification_id` int(11) NOT NULL,
    `has_source`      int(11) NOT NULL DEFAULT 0 COMMENT '0=Nothing\n1=have resource',
    `points`          float        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_levels`
--

CREATE TABLE `gamification_by_levels`
(
    `id`              int(11) NOT NULL,
    `source`          varchar(350) NOT NULL DEFAULT 'nothing',
    `title`           text         NOT NULL,
    `subtitle`        text                  DEFAULT NULL,
    `description`     text         NOT NULL,
    `state`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `has_source`      int(11) NOT NULL DEFAULT 0 COMMENT '0=Nothing\n1=have resource',
    `gamification_id` int(11) NOT NULL,
    `points`          float        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_points`
--

CREATE TABLE `gamification_by_points`
(
    `id`                         int(11) NOT NULL,
    `gamification_by_process_id` int(11) NOT NULL,
    `points`                     float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_process`
--

CREATE TABLE `gamification_by_process`
(
    `id`                            int(11) NOT NULL,
    `source`                        varchar(350) NOT NULL DEFAULT 'nothing',
    `title`                         text         NOT NULL,
    `subtitle`                      text                  DEFAULT NULL,
    `description`                   text         NOT NULL,
    `state`                         enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `has_source`                    int(11) NOT NULL DEFAULT 0 COMMENT '0=Nothing\n1=have resource',
    `entity`                        varchar(200) NOT NULL COMMENT 'product',
    `entity_id`                     varchar(200) NOT NULL,
    `url_manager`                   text         NOT NULL,
    `gamification_id`               int(11) NOT NULL,
    `gamification_type_activity_id` int(11) NOT NULL,
    `is_url`                        int(11) NOT NULL DEFAULT 0,
    `type_manager`                  int(11) NOT NULL DEFAULT 0 COMMENT '0=output\n1=input\n',
    `user_id`                       int(11) NOT NULL,
    unique_code                     VARCHAR(50)  NOT NULL UNIQUE,
    `allow_golden`                  int          NOT NULL,
    `icon_class`                    varchar(50)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_by_rewards`
--

CREATE TABLE `gamification_by_rewards`
(
    `id`              int(11) NOT NULL,
    `source`          varchar(350) NOT NULL DEFAULT 'nothing',
    `title`           text         NOT NULL,
    `subtitle`        text                  DEFAULT NULL,
    `description`     text         NOT NULL,
    `state`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `has_source`      int(11) NOT NULL DEFAULT 0 COMMENT '0=Nothing\n1=have resource',
    `gamification_id` int(11) NOT NULL,
    `points`          float        NOT NULL,
    `entity`          int(11) NOT NULL COMMENT 'product\ncoupon\ndiscount',
    `entity_id`       int(11) DEFAULT NULL,
    `percentage`      float        NOT NULL DEFAULT 0,
    `amount`          int(11) NOT NULL DEFAULT 0,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL,
    `deleted_at`      timestamp NULL DEFAULT NULL,
    `user_id`         int(11) NOT NULL,
    `specific`        int(11) NOT NULL DEFAULT 0 COMMENT '0=ALL\n1=choose'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_type_activity`
--

CREATE TABLE `gamification_type_activity`
(
    `id`          int(11) NOT NULL,
    `source`      varchar(350) NOT NULL DEFAULT 'nothing',
    `title`       text         NOT NULL,
    `subtitle`    text                  DEFAULT NULL,
    `description` text         NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `has_source`  int(11) NOT NULL DEFAULT 0 COMMENT '0=Nothing\n1=have resource',
    `url_manager` text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gaminification_by_log_customers`
--

CREATE TABLE `gaminification_by_log_customers`
(
    `id`                                  int(11) NOT NULL,
    `entity_id`                           int(11) NOT NULL,
    `entity_type`                         int(11) NOT NULL,
    `account_gamification_by_movement_id` int(11) NOT NULL,
    `business_id`                         int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

CREATE TABLE `habits`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habits_by_history_clinic`
--

CREATE TABLE `habits_by_history_clinic`
(
    `id`                int(11) NOT NULL,
    `history_clinic_id` int(11) NOT NULL,
    `habits_id`         int(11) NOT NULL,
    `description`       text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_desk_header`
--

CREATE TABLE `help_desk_header`
(
    `id`                                                int(11) NOT NULL,
    `name`                                              varchar(45) NOT NULL,
    `description`                                       text DEFAULT NULL,
    `created_at`                                        timestamp NULL DEFAULT NULL,
    `status`                                            enum('ACTIVE','INACTIVE','INIT','END') NOT NULL DEFAULT 'ACTIVE',
    `predetermined`                                     int(11) DEFAULT 0,
    `year`                                              int(11) DEFAULT NULL,
    `business_id`                                       int(11) NOT NULL,
    `user_id`                                           int(11) NOT NULL,
    `help_desk_human_resources_employee_profile_id`     int(11) NOT NULL,
    `administrator_human_resources_employee_profile_id` int(11) NOT NULL,
    `type_manager_process`                              int(11) DEFAULT NULL,
    `human_resources_department_id`                     int(11) NOT NULL,
    `help_desk_types_id`                                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_desk_header_by_resources`
--

CREATE TABLE `help_desk_header_by_resources`
(
    `id`                  int(11) NOT NULL,
    `type_multimedia`     int(11) NOT NULL DEFAULT 0 COMMENT '0=imagen\n1=video\n3=youtube,paginas de ',
    `url`                 text NOT NULL,
    `description`         text DEFAULT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `status`              enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `help_desk_header_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_desk_types`
--

CREATE TABLE `help_desk_types`
(
    `id`            int(11) NOT NULL,
    `name`          varchar(45) NOT NULL,
    `description`   text DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `status`        enum('ACTIVE','INACTIVE','INIT','END') NOT NULL DEFAULT 'ACTIVE',
    `predetermined` int(11) DEFAULT 0,
    `year`          int(11) DEFAULT NULL,
    `business_id`   int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_clinic`
--

CREATE TABLE `history_clinic`
(
    `id`          int(11) NOT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `customer_id` int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_department`
--

CREATE TABLE `human_resources_department`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(80) NOT NULL,
    `description` text        DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL,
    `color`       varchar(80) DEFAULT '#DEC63D'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_department_by_manager`
--

CREATE TABLE `human_resources_department_by_manager`
(
    `id`                                  int(11) NOT NULL,
    `human_resources_department_id`       int(11) NOT NULL,
    `human_resources_employee_profile_id` int(11) NOT NULL,
    `type_manager`                        int(11) DEFAULT 0,
    `range`                               int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_department_by_organizational_chart_area`
--

CREATE TABLE `human_resources_department_by_organizational_chart_area`
(
    `id`                                           int(11) NOT NULL,
    `human_resources_department_id`                int(11) NOT NULL,
    `human_resources_organizational_chart_area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_department_by_rest_day`
--

CREATE TABLE `human_resources_department_by_rest_day`
(
    `id`                            int(11) NOT NULL,
    `human_resources_department_id` int(11) NOT NULL,
    `days`                          int(11) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id`                   int(11) NOT NULL,
    `predetermined`                 int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_employee_permission_by_details`
--

CREATE TABLE `human_resources_employee_permission_by_details`
(
    `id`                                                int(11) NOT NULL,
    `human_resources_permission_type_id`                int(11) NOT NULL,
    `hours`                                             varchar(45)        DEFAULT NULL,
    `created_at`                                        timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp (),
    `year`                                              int(11) DEFAULT NULL,
    `hours_since`                                       time               DEFAULT NULL,
    `hours_until`                                       time               DEFAULT NULL,
    `note`                                              text               DEFAULT NULL,
    `day_name`                                          varchar(100)       DEFAULT NULL,
    `human_resources_employee_profile_by_permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_employee_profile`
--

CREATE TABLE `human_resources_employee_profile`
(
    `id`                                           int(11) NOT NULL,
    `description`                                  text         DEFAULT NULL,
    `summary_web`                                  text         DEFAULT NULL,
    `people_id`                                    int(11) NOT NULL,
    `people_type_identification_id`                int(11) NOT NULL,
    `identification_document`                      varchar(45) NOT NULL,
    `src`                                          varchar(250) DEFAULT NULL,
    `date_of_birth`                                datetime    NOT NULL,
    `people_nationality_id`                        int(11) NOT NULL,
    `people_profession_id`                         int(11) NOT NULL,
    `contract_date`                                datetime    NOT NULL,
    `status`                                       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id`                                  int(11) NOT NULL,
    `human_resources_department_id`                int(11) NOT NULL,
    `allow_view_page_web`                          int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT\n1=YES',
    `human_resources_organizational_chart_area_id` int(11) NOT NULL,
    `human_resources_schedule_type_id`             int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_employee_profile_by_log_area`
--

CREATE TABLE `human_resources_employee_profile_by_log_area`
(
    `id`                                           int(11) NOT NULL,
    `date_init`                                    timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp (),
    `date_end`                                     timestamp NULL DEFAULT NULL,
    `status`                                       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description_end`                              text               DEFAULT NULL,
    `human_resources_organizational_chart_area_id` int(11) NOT NULL,
    `human_resources_employee_profile_id`          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_employee_profile_by_permission`
--

CREATE TABLE `human_resources_employee_profile_by_permission`
(
    `id`                                  int(11) NOT NULL,
    `human_resources_permission_type_id`  int(11) NOT NULL,
    `human_resources_employee_profile_id` int(11) NOT NULL,
    `date_since`                          datetime NOT NULL,
    `date_until`                          datetime NOT NULL,
    `year`                                int(11) DEFAULT NULL,
    `note`                                text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_organizational_chart_area`
--

CREATE TABLE `human_resources_organizational_chart_area`
(
    `id`          int(11) NOT NULL,
    `parent_id`   int(11) DEFAULT NULL,
    `weight`      int(11) DEFAULT NULL,
    `icon`        varchar(100) DEFAULT NULL,
    `type`        int(11) NOT NULL DEFAULT 0 COMMENT '0=manager is link\\n1=METHOD \\n2=ROOT init menu root',
    `description` text        NOT NULL,
    `type_item`   int(11) NOT NULL DEFAULT 1 COMMENT '1=HAS CHILDRENS\\n0=NOT CHILDREN',
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `name`        varchar(80) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_organizational_chart_area_by_manager`
--

CREATE TABLE `human_resources_organizational_chart_area_by_manager`
(
    `id`                                           int(11) NOT NULL,
    `type_manager`                                 int(11) DEFAULT 0,
    `human_resources_employee_profile_id`          int(11) NOT NULL,
    `human_resources_organizational_chart_area_id` int(11) NOT NULL,
    `range`                                        int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_permission_type`
--

CREATE TABLE `human_resources_permission_type`
(
    `id`                        int(11) NOT NULL,
    `name`                      varchar(45) NOT NULL,
    `code`                      varchar(45) NOT NULL,
    `description`               text DEFAULT NULL,
    `created_at`                timestamp NULL DEFAULT NULL,
    `updated_at`                timestamp NULL DEFAULT NULL,
    `deleted_at`                timestamp NULL DEFAULT NULL,
    `status`                    enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `recoverable_permit`        int(11) DEFAULT 0,
    `control_by_hours`          int(11) DEFAULT 0,
    `control_by_hours_duration` int(11) DEFAULT 0,
    `predetermined`             int(11) DEFAULT 0,
    `business_id`               int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_schedule_type`
--

CREATE TABLE `human_resources_schedule_type`
(
    `id`            int(11) NOT NULL,
    `name`          varchar(45) NOT NULL,
    `code`          varchar(45) NOT NULL,
    `description`   text DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL,
    `deleted_at`    timestamp NULL DEFAULT NULL,
    `status`        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `predetermined` int(11) DEFAULT 0,
    `rotary`        int(11) DEFAULT 0,
    `business_id`   int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_schedule_type_by_shift`
--

CREATE TABLE `human_resources_schedule_type_by_shift`
(
    `id`                               int(11) NOT NULL,
    `human_resources_shift_id`         int(11) NOT NULL,
    `human_resources_schedule_type_id` int(11) NOT NULL,
    `day_name`                         varchar(100) DEFAULT NULL,
    `day_number`                       int(11) DEFAULT NULL,
    `rest_day`                         int(11) DEFAULT 0,
    `complementary`                    int(11) DEFAULT 0,
    `optional_day`                     int(11) DEFAULT 0,
    `weekend`                          int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `human_resources_shift`
--

CREATE TABLE `human_resources_shift`
(
    `id`                   int(11) NOT NULL,
    `name`                 varchar(45) NOT NULL,
    `code`                 varchar(45) NOT NULL,
    `description`          text DEFAULT NULL,
    `created_at`           timestamp NULL DEFAULT NULL,
    `updated_at`           timestamp NULL DEFAULT NULL,
    `deleted_at`           timestamp NULL DEFAULT NULL,
    `status`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `predetermined`        int(11) DEFAULT 0,
    `pay_overtime`         int(11) DEFAULT 0,
    `entry_time`           time        NOT NULL,
    `departure_time`       time        NOT NULL,
    `entry_time_break`     time        NOT NULL,
    `departure_time_break` time        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_address`
--

CREATE TABLE `information_address`
(
    `id`                          int(11) NOT NULL,
    `street_one`                  varchar(150) NOT NULL,
    `street_two`                  varchar(150) NOT NULL,
    `reference`                   text         NOT NULL,
    `state`                       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `entity_id`                   int(11) NOT NULL,
    `main`                        int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MAIN\n1=MAIN',
    `entity_type`                 int(11) NOT NULL DEFAULT 0 COMMENT '0=customer\n',
    `information_address_type_id` int(11) NOT NULL,
    `has_location`                int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT \n1=YES',
    `options_map`                 text         NOT NULL COMMENT 'location,zoom',
    `country_code_id`             varchar(250) NOT NULL COMMENT 'google code types',
    `administrative_area_level_2` varchar(250) NOT NULL COMMENT 'google code types Ciudad',
    `administrative_area_level_1` varchar(250) DEFAULT NULL COMMENT 'google code types Provincia',
    `administrative_area_level_3` varchar(250) DEFAULT NULL COMMENT 'google code types parroquia ,comunidad'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_address_by_multimedia`
--

CREATE TABLE `information_address_by_multimedia`
(
    `id`                     int(11) NOT NULL,
    `source`                 varchar(350) NOT NULL DEFAULT 'nothing',
    `information_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_address_type`
--

CREATE TABLE `information_address_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_mail`
--

CREATE TABLE `information_mail`
(
    `id`                       int(11) NOT NULL,
    `value`                    varchar(150) NOT NULL,
    `state`                    enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `entity_id`                int(11) NOT NULL,
    `main`                     int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MAIN\n1=MAIN',
    `entity_type`              int(11) NOT NULL DEFAULT 0 COMMENT '0=customer\n',
    `information_mail_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_mail_type`
--

CREATE TABLE `information_mail_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_phone`
--

CREATE TABLE `information_phone`
(
    `id`                            int(11) NOT NULL,
    `value`                         varchar(150) NOT NULL,
    `state`                         enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `entity_id`                     int(11) NOT NULL,
    `main`                          int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MAIN\n1=MAIN',
    `entity_type`                   int(11) NOT NULL DEFAULT 0 COMMENT '0=customer\n',
    `information_phone_operator_id` int(11) NOT NULL,
    `information_phone_type_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_phone_operator`
--

CREATE TABLE `information_phone_operator`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_phone_type`
--

CREATE TABLE `information_phone_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_social_network`
--

CREATE TABLE `information_social_network`
(
    `id`                                 int(11) NOT NULL,
    `value`                              varchar(150) NOT NULL,
    `state`                              enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `entity_id`                          int(11) NOT NULL,
    `main`                               int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MAIN\n1=MAIN',
    `entity_type`                        int(11) NOT NULL DEFAULT 0 COMMENT '0=customer\n',
    `information_social_network_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_social_network_type`
--

CREATE TABLE `information_social_network_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `icon`        varchar(45)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `initial_status_product`
--

CREATE TABLE `initial_status_product`
(
    `id`          int(11) NOT NULL,
    `amount`      float          NOT NULL,
    `value`       decimal(10, 2) NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `product_id`  int(11) NOT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy`
--

CREATE TABLE `invoice_buy`
(
    `id`                    int(11) NOT NULL,
    `customer_id`           int(11) NOT NULL,
    `invoice_code`          varchar(45)    NOT NULL,
    `invoice_value`         decimal(10, 4) NOT NULL,
    `discount_value`        decimal(10, 4) DEFAULT NULL,
    `status`                enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED',
    `created_at`            datetime       NOT NULL,
    `user_id`               int(11) NOT NULL,
    `observations`          text           DEFAULT NULL,
    `value_taxes`           decimal(10, 4) NOT NULL,
    `subtotal`              decimal(10, 4) NOT NULL,
    `authorization_number`  varchar(150)   NOT NULL,
    `invoice_date`          datetime       NOT NULL,
    `establishment`         varchar(3)     NOT NULL,
    `emission_point`        varchar(3)     NOT NULL,
    `voucher_type_id`       int(11) NOT NULL,
    `mixed_payment`         int(11) NOT NULL DEFAULT 1 COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS',
    `has_retention`         int(11) NOT NULL DEFAULT 1 COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion',
    `debt`                  int(11) NOT NULL DEFAULT 0 COMMENT '0=sin DEUDA\n 1=DEUDA',
    `freight`               int(11) NOT NULL DEFAULT 0,
    `type_of_discount`      int(11) NOT NULL DEFAULT 0 COMMENT '0=% \n1=$',
    `discount_type_invoice` int(11) NOT NULL DEFAULT 0 COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_book_seat`
--

CREATE TABLE `invoice_buy_by_book_seat`
(
    `id`             int(11) NOT NULL,
    `manager_type`   int(11) NOT NULL DEFAULT 0 COMMENT '0=REGISTRO FACTURA 1=REGISTRO DEVOLUCION 2=REGISTRO DE PAGOS CUALQIER ES UN EJEMPLO TOCARIA DEFINIR',
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL,
    `deleted_at`     timestamp NULL DEFAULT NULL,
    `invoice_buy_id` int(11) NOT NULL,
    `diary_book_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_breakdown_payment`
--

CREATE TABLE `invoice_buy_by_breakdown_payment`
(
    `id`                                         int(11) NOT NULL,
    `invoice_buy_by_indebtedness_paying_init_id` int(11) NOT NULL,
    `date_agreement`                             datetime       NOT NULL,
    `payment_value`                              decimal(10, 4) NOT NULL,
    `state_payment`                              int(11) NOT NULL DEFAULT 1 COMMENT '0=pagado 1=deuda',
    `user_id`                                    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_details`
--

CREATE TABLE `invoice_buy_by_details`
(
    `id`                       int(11) NOT NULL,
    `invoice_buy_id`           int(11) NOT NULL,
    `product_id`               int(11) NOT NULL,
    `quantity`                 decimal(10, 4) DEFAULT NULL,
    `quantity_unit`            decimal(10, 4) DEFAULT NULL,
    `discount_percentage`      decimal(10, 4) DEFAULT NULL,
    `discount_percentage_unit` decimal(10, 4) DEFAULT NULL,
    `discount_value`           decimal(10, 4) DEFAULT NULL,
    `discount_value_unit`      decimal(10, 4) DEFAULT NULL,
    `unit_price`               decimal(10, 4) DEFAULT NULL,
    `unit_price_unit`          decimal(10, 4) DEFAULT NULL,
    `management_type`          char(3)        DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
    `tax_percentage`           int(11) DEFAULT NULL,
    `subtotal`                 decimal(10, 4) NOT NULL,
    `total`                    decimal(10, 4) NOT NULL,
    `description`              text           DEFAULT NULL,
    `product_type`             varchar(45)    DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_details_devolution`
--

CREATE TABLE `invoice_buy_by_details_devolution`
(
    `id`                       int(11) NOT NULL,
    `invoice_buy_id`           int(11) NOT NULL,
    `product_id`               int(11) NOT NULL,
    `quantity`                 decimal(10, 4) DEFAULT NULL,
    `quantity_unit`            decimal(10, 4) DEFAULT NULL,
    `discount_percentage`      decimal(10, 4) DEFAULT NULL,
    `discount_percentage_unit` decimal(10, 4) DEFAULT NULL,
    `discount_value`           decimal(10, 4) DEFAULT NULL,
    `discount_value_unit`      decimal(10, 4) DEFAULT NULL,
    `unit_price`               decimal(10, 4) DEFAULT NULL,
    `unit_price_unit`          decimal(10, 4) DEFAULT NULL,
    `management_type`          char(3)        DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
    `tax_percentage`           int(11) DEFAULT NULL,
    `subtotal`                 decimal(10, 4) NOT NULL,
    `total`                    decimal(10, 4) NOT NULL,
    `created_at`               timestamp NULL DEFAULT NULL,
    `updated_at`               timestamp NULL DEFAULT NULL,
    `deleted_at`               timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_devolution_product`
--

CREATE TABLE `invoice_buy_by_devolution_product`
(
    `id`                                   int(11) NOT NULL,
    `product_defect_id`                    int(11) NOT NULL,
    `details`                              text DEFAULT NULL,
    `created_at`                           timestamp NULL DEFAULT NULL,
    `updated_at`                           timestamp NULL DEFAULT NULL,
    `deleted_at`                           timestamp NULL DEFAULT NULL,
    `invoice_buy_by_details_devolution_id` int(11) NOT NULL,
    `types_payments_id`                    int(11) NOT NULL,
    `accounting_account_id`                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_indebtedness_paying_init`
--

CREATE TABLE `invoice_buy_by_indebtedness_paying_init`
(
    `id`              int(11) NOT NULL,
    `number_payments` int(11) NOT NULL,
    `user_id`         int(11) NOT NULL,
    `invoice_buy_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_overridden`
--

CREATE TABLE `invoice_buy_by_overridden`
(
    `id`                    int(11) NOT NULL,
    `description`           text     NOT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    `deleted_at`            timestamp NULL DEFAULT NULL,
    `register_manager_date` datetime NOT NULL,
    `user_id`               int(11) NOT NULL,
    `invoice_buy_id`        int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_payment`
--

CREATE TABLE `invoice_buy_by_payment`
(
    `id`                                         int(11) NOT NULL,
    `payment_date`                               datetime NOT NULL,
    `state_payment`                              int(11) NOT NULL DEFAULT 1 COMMENT '	1=puntual 0=atrasado',
    `details`                                    text DEFAULT NULL,
    `types_payments_by_account_id`               int(11) NOT NULL,
    `accounting_account_id`                      int(11) DEFAULT NULL,
    `user_id`                                    int(11) NOT NULL,
    `invoice_buy_by_breakdown_payment_id`        int(11) NOT NULL,
    `invoice_buy_by_indebtedness_paying_init_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_pendient`
--

CREATE TABLE `invoice_buy_by_pendient`
(
    `id`                  int(11) NOT NULL,
    `indebtedness_paying` decimal(10, 4) NOT NULL,
    `invoice_buy_id`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_retention`
--

CREATE TABLE `invoice_buy_by_retention`
(
    `id`                        int(11) NOT NULL,
    `invoice_buy_id`            int(11) NOT NULL,
    `retention_tax_sub_type_id` int(11) NOT NULL,
    `created_at`                timestamp NULL DEFAULT NULL,
    `updated_at`                timestamp NULL DEFAULT NULL,
    `deleted_at`                timestamp NULL DEFAULT NULL,
    `retained_value`            decimal(10, 4) DEFAULT NULL,
    `establishment`             varchar(3)     DEFAULT NULL,
    `emission_point`            varchar(3)   NOT NULL,
    `number_authorization`      varchar(3)   NOT NULL,
    `number_retention`          varchar(250) NOT NULL,
    `invoice_date`              datetime     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_transactional_annex`
--

CREATE TABLE `invoice_buy_by_transactional_annex`
(
    `id`                                  int(11) NOT NULL,
    `invoice_buy_id`                      int(11) NOT NULL,
    `management_livelihood_by_voucher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_buy_by_transactions`
--

CREATE TABLE `invoice_buy_by_transactions`
(
    `id`                    int(11) NOT NULL,
    `percentage_discount`   decimal(10, 4) DEFAULT NULL,
    `value_discount`        decimal(10, 4) DEFAULT NULL,
    `subtotal`              decimal(10, 4) NOT NULL,
    `total`                 decimal(10, 4) NOT NULL,
    `account`               varchar(45)    DEFAULT NULL,
    `accounting_account_id` int(11) NOT NULL,
    `way_to_pay`            varchar(250)   NOT NULL,
    `type_payment_id`       int(11) NOT NULL,
    `invoice_buy_id`        int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale`
--

CREATE TABLE `invoice_sale`
(
    `id`                        int(11) NOT NULL,
    `customer_id`               int(11) NOT NULL,
    `invoice_code`              varchar(45)    NOT NULL,
    `invoice_value`             decimal(10, 4) NOT NULL,
    `discount_value`            decimal(10, 4) DEFAULT NULL,
    `status`                    enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED',
    `created_at`                datetime       NOT NULL,
    `user_id`                   int(11) NOT NULL,
    `observations`              text           DEFAULT NULL,
    `value_taxes`               decimal(10, 4) NOT NULL,
    `subtotal`                  decimal(10, 4) NOT NULL,
    `invoice_date`              datetime       NOT NULL,
    `establishment`             varchar(3)     NOT NULL,
    `emission_point`            varchar(3)     NOT NULL,
    `voucher_type_id`           int(11) NOT NULL,
    `mixed_payment`             int(11) NOT NULL DEFAULT 1 COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS',
    `has_retention`             int(11) NOT NULL DEFAULT 1 COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion',
    `now_after_retention`       int(11) NOT NULL DEFAULT 1 COMMENT '1= RETENCION AL DIA LEGAL PARA L LIBRO DIARIO\n0= RETENCION NO REALIZADA A LO LEGAL LUEGO DE VARIOS DIAS TOCARA EDITAR\n',
    `debt`                      int(11) NOT NULL DEFAULT 0 COMMENT '0=sin DEUDA\n 1=DEUDA',
    `type_of_discount`          int(11) NOT NULL DEFAULT 0 COMMENT '0=% \n1=$',
    `discount_type_invoice`     int(11) NOT NULL DEFAULT 0 COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	',
    `authorization_number`      varchar(150)   NOT NULL,
    `type_of_document_issuance` int(11) NOT NULL DEFAULT 0 COMMENT '0=FISICO\n1=DIGITAL'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_book_seat`
--

CREATE TABLE `invoice_sale_by_book_seat`
(
    `id`                 int(11) NOT NULL,
    `manager_type`       int(11) NOT NULL DEFAULT 0 COMMENT '0=REGISTRO FACTURA 1=REGISTRO DEVOLUCION 2=REGISTRO DE PAGOS CUALQIER ES UN EJEMPLO TOCARIA DEFINIR',
    `created_at`         timestamp NULL DEFAULT NULL,
    `updated_at`         timestamp NULL DEFAULT NULL,
    `deleted_at`         timestamp NULL DEFAULT NULL,
    `invoice_sale_id`    int(11) NOT NULL,
    `daily_book_seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_breakdown_payment`
--

CREATE TABLE `invoice_sale_by_breakdown_payment`
(
    `id`                                          int(11) NOT NULL,
    `date_agreement`                              datetime       NOT NULL,
    `payment_value`                               decimal(10, 4) NOT NULL,
    `state_payment`                               int(11) NOT NULL DEFAULT 1 COMMENT '0=pagado 1=deuda',
    `user_id`                                     int(11) NOT NULL,
    `description`                                 text DEFAULT NULL,
    `invoice_sale_by_indebtedness_paying_init_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_details`
--

CREATE TABLE `invoice_sale_by_details`
(
    `id`                       int(11) NOT NULL,
    `product_id`               int(11) NOT NULL,
    `quantity`                 decimal(10, 4) DEFAULT NULL,
    `quantity_unit`            decimal(10, 4) DEFAULT NULL,
    `discount_percentage`      decimal(10, 4) DEFAULT NULL,
    `discount_percentage_unit` decimal(10, 4) DEFAULT NULL,
    `discount_value`           decimal(10, 4) DEFAULT NULL,
    `discount_value_unit`      decimal(10, 4) DEFAULT NULL,
    `unit_price`               decimal(10, 4) DEFAULT NULL,
    `unit_price_unit`          decimal(10, 4) DEFAULT NULL,
    `management_type`          char(3)        DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
    `tax_percentage`           int(11) DEFAULT NULL,
    `subtotal`                 decimal(10, 4) NOT NULL,
    `total`                    decimal(10, 4) NOT NULL,
    `description`              text           DEFAULT NULL,
    `product_type`             varchar(45)    DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND',
    `invoice_sale_id`          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_details_devolution`
--

CREATE TABLE `invoice_sale_by_details_devolution`
(
    `id`                       int(11) NOT NULL,
    `product_id`               int(11) NOT NULL,
    `quantity`                 decimal(10, 4) DEFAULT NULL,
    `quantity_unit`            decimal(10, 4) DEFAULT NULL,
    `discount_percentage`      decimal(10, 4) DEFAULT NULL,
    `discount_percentage_unit` decimal(10, 4) DEFAULT NULL,
    `discount_value`           decimal(10, 4) DEFAULT NULL,
    `discount_value_unit`      decimal(10, 4) DEFAULT NULL,
    `unit_price`               decimal(10, 4) DEFAULT NULL,
    `unit_price_unit`          decimal(10, 4) DEFAULT NULL,
    `management_type`          char(3)        DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
    `tax_percentage`           int(11) DEFAULT NULL,
    `subtotal`                 decimal(10, 4) NOT NULL,
    `total`                    decimal(10, 4) NOT NULL,
    `created_at`               timestamp NULL DEFAULT NULL,
    `updated_at`               timestamp NULL DEFAULT NULL,
    `deleted_at`               timestamp NULL DEFAULT NULL,
    `invoice_sale_id`          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_devolution_product`
--

CREATE TABLE `invoice_sale_by_devolution_product`
(
    `id`                                    int(11) NOT NULL,
    `product_defect_id`                     int(11) NOT NULL,
    `details`                               text DEFAULT NULL,
    `created_at`                            timestamp NULL DEFAULT NULL,
    `updated_at`                            timestamp NULL DEFAULT NULL,
    `deleted_at`                            timestamp NULL DEFAULT NULL,
    `types_payments_id`                     int(11) NOT NULL,
    `accounting_account_id`                 int(11) NOT NULL,
    `invoice_sale_by_details_devolution_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_indebtedness_paying_init`
--

CREATE TABLE `invoice_sale_by_indebtedness_paying_init`
(
    `id`              int(11) NOT NULL,
    `number_payments` int(11) NOT NULL,
    `user_id`         int(11) NOT NULL,
    `invoice_sale_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_overridden`
--

CREATE TABLE `invoice_sale_by_overridden`
(
    `id`                    int(11) NOT NULL,
    `description`           text     NOT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    `deleted_at`            timestamp NULL DEFAULT NULL,
    `register_manager_date` datetime NOT NULL,
    `user_id`               int(11) NOT NULL,
    `invoice_sale_id`       int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_payment`
--

CREATE TABLE `invoice_sale_by_payment`
(
    `id`                                          int(11) NOT NULL,
    `payment_date`                                datetime NOT NULL,
    `state_payment`                               int(11) NOT NULL DEFAULT 1 COMMENT '	1=puntual 0=atrasado',
    `details`                                     text DEFAULT NULL,
    `types_payments_by_account_id`                int(11) NOT NULL,
    `accounting_account_id`                       int(11) DEFAULT NULL,
    `user_id`                                     int(11) NOT NULL,
    `invoice_sale_by_breakdown_payment_id`        int(11) NOT NULL,
    `invoice_sale_by_indebtedness_paying_init_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_pendient`
--

CREATE TABLE `invoice_sale_by_pendient`
(
    `id`                  int(11) NOT NULL,
    `indebtedness_paying` decimal(10, 4) NOT NULL,
    `invoice_sale_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_retention`
--

CREATE TABLE `invoice_sale_by_retention`
(
    `id`                        int(11) NOT NULL,
    `retention_tax_sub_type_id` int(11) NOT NULL,
    `created_at`                timestamp NULL DEFAULT NULL,
    `updated_at`                timestamp NULL DEFAULT NULL,
    `deleted_at`                timestamp NULL DEFAULT NULL,
    `retained_value`            decimal(10, 4) DEFAULT NULL,
    `establishment`             varchar(3)     DEFAULT NULL,
    `emission_point`            varchar(3)   NOT NULL,
    `number_authorization`      varchar(3)   NOT NULL,
    `number_retention`          varchar(250) NOT NULL,
    `invoice_date`              datetime     NOT NULL,
    `invoice_sale_id`           int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_transactional_annex`
--

CREATE TABLE `invoice_sale_by_transactional_annex`
(
    `id`                                  int(11) NOT NULL,
    `management_livelihood_by_voucher_id` int(11) NOT NULL,
    `invoice_sale_id`                     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale_by_transactions`
--

CREATE TABLE `invoice_sale_by_transactions`
(
    `id`                    int(11) NOT NULL,
    `percentage_discount`   decimal(10, 4) DEFAULT NULL,
    `value_discount`        decimal(10, 4) DEFAULT NULL,
    `subtotal`              decimal(10, 4) NOT NULL,
    `total`                 decimal(10, 4) NOT NULL,
    `account`               varchar(45)    DEFAULT NULL,
    `accounting_account_id` int(11) NOT NULL,
    `way_to_pay`            varchar(250)   NOT NULL,
    `type_payment_id`       int(11) NOT NULL,
    `invoice_sale_id`       int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `initials`    varchar(4)   NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course`
--

CREATE TABLE `language_course`
(
    `id`                     int(11) NOT NULL,
    `value`                  varchar(150) NOT NULL,
    `description`            text DEFAULT NULL,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `dictionary_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_by_photo`
--

CREATE TABLE `language_course_by_photo`
(
    `id`                 int(11) NOT NULL,
    `title`              text         NOT NULL,
    `subtitle`           varchar(45) DEFAULT NULL,
    `description`        text        DEFAULT NULL,
    `type`               int(11) NOT NULL,
    `priority`           int(11) NOT NULL,
    `view`               int(11) NOT NULL,
    `source`             varchar(250) NOT NULL,
    `language_course_id` int(11) NOT NULL,
    `status`             enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_by_section`
--

CREATE TABLE `language_course_by_section`
(
    `id`                 int(11) NOT NULL,
    `value`              varchar(150) NOT NULL,
    `description`        text DEFAULT NULL COMMENT 'PERO TODO LO Q SE HAGA DEBE AGREGARSE LAS PALABRAS QUE VAN HA ESTAR DENTRO DE LA SECCION\n',
    `status`             enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `language_course_id` int(11) NOT NULL,
    `type`               int(11) DEFAULT 0 COMMENT '0=ONLY BACKGROUND SECTIONS\n1=STRUCTURE BY COLS',
    `source`             varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_dictionary_words`
--

CREATE TABLE `language_course_section_by_dictionary_words`
(
    `id`                            int(11) NOT NULL,
    `language_course_by_section_id` int(11) NOT NULL,
    `dictionary_by_words_id`        int(11) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_logo`
--

CREATE TABLE `language_course_section_by_logo`
(
    `id`                            int(11) NOT NULL,
    `title`                         text         NOT NULL,
    `subtitle`                      varchar(45) DEFAULT NULL,
    `description`                   text        DEFAULT NULL,
    `type`                          int(11) NOT NULL,
    `priority`                      int(11) NOT NULL,
    `view`                          int(11) NOT NULL,
    `source`                        varchar(250) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `language_course_by_section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_photo`
--

CREATE TABLE `language_course_section_by_photo`
(
    `id`                            int(11) NOT NULL,
    `title`                         text         NOT NULL,
    `subtitle`                      varchar(45) DEFAULT NULL,
    `description`                   text        DEFAULT NULL,
    `type`                          int(11) NOT NULL,
    `priority`                      int(11) NOT NULL,
    `view`                          int(11) NOT NULL,
    `source`                        varchar(250) NOT NULL,
    `language_course_by_section_id` int(11) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_rows`
--

CREATE TABLE `language_course_section_by_rows`
(
    `id`                            int(11) NOT NULL,
    `language_course_by_section_id` int(11) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `style`                         text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_sticky_note`
--

CREATE TABLE `language_course_section_by_sticky_note`
(
    `id`                            int(11) NOT NULL,
    `title`                         text NOT NULL,
    `subtitle`                      text DEFAULT NULL,
    `description`                   text DEFAULT NULL,
    `language_course_by_section_id` int(11) NOT NULL,
    `status`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_rows_by_columns`
--

CREATE TABLE `language_course_section_rows_by_columns`
(
    `id`                                 int(11) NOT NULL,
    `status`                             enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `language_course_section_by_rows_id` int(11) NOT NULL,
    `style_column`                       text DEFAULT NULL,
    `dictionary_by_words_id`             int(11) NOT NULL,
    `style_word`                         text DEFAULT NULL,
    `style_title`                        text DEFAULT NULL,
    `title`                              text DEFAULT NULL,
    `type_title`                         int(11) DEFAULT 1 COMMENT '0=abajo\n1=arriba',
    `type_word`                          int(11) DEFAULT 0 COMMENT '0=abajo\n1=arriba',
    `type_image_word`                    int(11) DEFAULT 1 COMMENT '1=IMAGEN PROPIA DE WORD\n2=IMAGEN CUSTOM'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product`
--

CREATE TABLE `language_product`
(
    `id`          int(11) NOT NULL,
    `name`        text NOT NULL,
    `description` text DEFAULT NULL,
    `language_id` int(11) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product_category`
--

CREATE TABLE `language_product_category`
(
    `id`                  int(11) NOT NULL,
    `value`               varchar(200) NOT NULL,
    `state`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`         text         DEFAULT NULL,
    `subtitle`            varchar(250) DEFAULT NULL,
    `language_id`         int(11) NOT NULL,
    `product_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product_color`
--

CREATE TABLE `language_product_color`
(
    `id`               int(11) NOT NULL,
    `value`            varchar(200) NOT NULL,
    `language_id`      int(11) NOT NULL,
    `state`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_color_id` int(11) NOT NULL,
    `description`      text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product_measure_type`
--

CREATE TABLE `language_product_measure_type`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(100) NOT NULL,
    `description`             text DEFAULT NULL,
    `language_id`             int(11) NOT NULL,
    `state`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_measure_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product_subcategory`
--

CREATE TABLE `language_product_subcategory`
(
    `id`                     int(11) NOT NULL,
    `language_id`            int(11) NOT NULL,
    `value`                  varchar(200) NOT NULL,
    `description`            text         DEFAULT NULL,
    `subtitle`               varchar(250) DEFAULT NULL,
    `product_subcategory_id` int(11) NOT NULL,
    `state`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_product_trademark`
--

CREATE TABLE `language_product_trademark`
(
    `id`                   int(11) NOT NULL,
    `value`                varchar(200) NOT NULL,
    `description`          text DEFAULT NULL,
    `language_id`          int(11) NOT NULL,
    `state`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_trademark_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_about_us`
--

CREATE TABLE `language_template_about_us`
(
    `id`                   int(11) NOT NULL,
    `value`                varchar(150) NOT NULL,
    `description`          text DEFAULT NULL,
    `subtitle`             text DEFAULT NULL,
    `language_id`          int(11) NOT NULL,
    `state`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_about_us_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_about_us_by_data`
--

CREATE TABLE `language_template_about_us_by_data`
(
    `id`                           int(11) NOT NULL,
    `title`                        text NOT NULL,
    `description`                  text NOT NULL,
    `language_id`                  int(11) NOT NULL,
    `state`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_about_us_by_data_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_policies`
--

CREATE TABLE `language_template_policies`
(
    `id`                   int(11) NOT NULL,
    `value`                varchar(150) NOT NULL,
    `description`          text DEFAULT NULL,
    `language_id`          int(11) NOT NULL,
    `state`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_policies_id` int(11) NOT NULL,
    `subtitle`             text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_services`
--

CREATE TABLE `language_template_services`
(
    `id`                   int(11) NOT NULL,
    `value`                varchar(150) NOT NULL,
    `description`          text DEFAULT NULL,
    `language_id`          int(11) NOT NULL,
    `state`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_services_id` int(11) NOT NULL,
    `subtitle`             text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_services_by_data`
--

CREATE TABLE `language_template_services_by_data`
(
    `id`                           int(11) NOT NULL,
    `title`                        text NOT NULL,
    `description`                  text NOT NULL,
    `language_id`                  int(11) NOT NULL,
    `state`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_services_by_data_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_template_slider_by_images`
--

CREATE TABLE `language_template_slider_by_images`
(
    `id`                           int(11) NOT NULL,
    `title`                        text NOT NULL,
    `description`                  text DEFAULT NULL,
    `language_id`                  int(11) NOT NULL,
    `state`                        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `subtitle`                     text DEFAULT NULL,
    `template_slider_by_images_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging`
--

CREATE TABLE `lodging`
(
    `id`              int(11) NOT NULL,
    `entry_at`        datetime       NOT NULL,
    `output_at`       datetime                DEFAULT NULL,
    `number_people`   int(11) NOT NULL,
    `adults`          int(11) DEFAULT NULL COMMENT '0=no\n1=si',
    `children`        int(11) DEFAULT NULL COMMENT '0=no\n1=si',
    `number_rooms`    int(11) NOT NULL,
    `total_value`     decimal(10, 2) NOT NULL DEFAULT 0.00,
    `payment_made`    int(11) NOT NULL DEFAULT 0 COMMENT '0=NO\n1=YES',
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL,
    `deleted_at`      timestamp NULL DEFAULT NULL,
    `description`     text                    DEFAULT NULL,
    `business_id`     int(11) NOT NULL,
    `status`          enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `arrived_made`    int(11) NOT NULL DEFAULT 0,
    `rooms_add_made`  int(11) NOT NULL DEFAULT 0,
    `status_delivery` int(11) NOT NULL DEFAULT 0 COMMENT '0=INIT\n1=FINALIZED\n',
    `delivery_date`   datetime                DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_arrived_by_social_networks`
--

CREATE TABLE `lodging_arrived_by_social_networks`
(
    `id`                    int(11) NOT NULL,
    `type_social_networks`  int(11) NOT NULL DEFAULT 0 COMMENT '0=FACEBOOK\n1=INSTAGRAM\n2=TWitter\n3=youtube\n4=spotify',
    `lodging_by_arrived_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_arrived`
--

CREATE TABLE `lodging_by_arrived`
(
    `id`             int(11) NOT NULL,
    `lodging_id`     int(11) NOT NULL,
    `way_to_contact` int(11) NOT NULL DEFAULT 0 COMMENT '0=REDES SOCIALES\n1=COMERCIO\n2=RECOMDANCIONES PERSONAS\n3='
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_customer`
--

CREATE TABLE `lodging_by_customer`
(
    `id`                         int(11) NOT NULL,
    `main`                       int(11) NOT NULL DEFAULT 1 COMMENT '0=NOT MAIN\n1=MAIN',
    `lodging_id`                 int(11) NOT NULL,
    `has_information_additional` int(11) NOT NULL DEFAULT 0 COMMENT '0=not has\n1=has',
    `customer_id`                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_customer_location`
--

CREATE TABLE `lodging_by_customer_location`
(
    `id`                     int(11) NOT NULL,
    `lodging_by_customer_id` int(11) NOT NULL,
    `information_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_payment`
--

CREATE TABLE `lodging_by_payment`
(
    `id`         int(11) NOT NULL,
    `way_to_pay` int(11) NOT NULL COMMENT '0=EFECTIVO\n1=TARJETA DE CREDITO\n2=DOCUMENTOS DE PAGO',
    `lodging_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_payment_credit_card`
--

CREATE TABLE `lodging_by_payment_credit_card`
(
    `id`                    int(11) NOT NULL,
    `type_credit_card`      int(11) NOT NULL COMMENT '0=DINERS\n1=VISA\n2=MASTERCARD\n3=OTRAS',
    `lodging_by_payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_reasons`
--

CREATE TABLE `lodging_by_reasons`
(
    `id`         int(11) NOT NULL,
    `lodging_id` int(11) NOT NULL,
    `reason`     int(11) NOT NULL COMMENT '0=job\n1=holidays\n2= spend the night\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_by_type_of_room`
--

CREATE TABLE `lodging_by_type_of_room`
(
    `id`                               int(11) NOT NULL,
    `lodging_id`                       int(11) NOT NULL,
    `lodging_type_of_room_by_price_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_customer_additional_information`
--

CREATE TABLE `lodging_customer_additional_information`
(
    `id`                     int(11) NOT NULL,
    `information_mobile_id`  int(11) DEFAULT NULL,
    `information_phone_id`   int(11) DEFAULT NULL,
    `postal_code`            varchar(45) DEFAULT NULL,
    `lodging_by_customer_id` int(11) NOT NULL,
    `information_mail_id`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_room_features`
--

CREATE TABLE `lodging_room_features`
(
    `id`          int(11) NOT NULL,
    `name`        text NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_room_levels`
--

CREATE TABLE `lodging_room_levels`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_type_of_room`
--

CREATE TABLE `lodging_type_of_room`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_type_of_room_by_price`
--

CREATE TABLE `lodging_type_of_room_by_price`
(
    `id`                      int(11) NOT NULL,
    `price`                   decimal(10, 2) NOT NULL DEFAULT 0.00,
    `status`                  enum('ACTIVE','INACTIVE','FREE','OCCUPIED','CLEANING') NOT NULL DEFAULT 'ACTIVE',
    `room_number`             varchar(150)   NOT NULL,
    `lodging_type_of_room_id` int(11) NOT NULL,
    `lodging_room_levels_id`  int(11) NOT NULL,
    `description`             text                    DEFAULT NULL,
    `name`                    varchar(200)   NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lodging_type_of_room_price_by_features`
--

CREATE TABLE `lodging_type_of_room_price_by_features`
(
    `lodging_type_of_room_by_price_id` int(11) NOT NULL,
    `lodging_room_features_id`         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_by_issuance_bank`
--

CREATE TABLE `log_by_issuance_bank`
(
    `id`           int(11) NOT NULL,
    `caja_id`      int(11) NOT NULL,
    `issuance_id`  int(11) NOT NULL COMMENT 'esto es cash o bank',
    `date_current` date NOT NULL,
    `user_id`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_by_issuance_cash`
--

CREATE TABLE `log_by_issuance_cash`
(
    `id`           int(11) NOT NULL,
    `caja_id`      int(11) NOT NULL,
    `issuance_id`  int(11) NOT NULL COMMENT 'esto es cash o bank',
    `date_current` date NOT NULL,
    `user_id`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mailing_by_data_send`
--

CREATE TABLE `mailing_by_data_send`
(
    `id`                  int(11) NOT NULL,
    `customer_id`         int(11) NOT NULL,
    `entity_type`         int(11) NOT NULL DEFAULT 1 COMMENT '1=OWNER API\n2=MAILCHIMP',
    `mailing_template_id` int(11) NOT NULL,
    `email`               varchar(150) NOT NULL,
    `date`                datetime     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mailing_template`
--

CREATE TABLE `mailing_template`
(
    `id`            int(11) NOT NULL,
    `business_id`   int(11) NOT NULL,
    `name`          varchar(150) NOT NULL,
    `message`       text         NOT NULL,
    `status`        enum('ACTIVE','INACTIVE') NOT NULL,
    `user_id`       int(11) NOT NULL,
    `source_main`   varchar(250) NOT NULL,
    `type_template` int(11) NOT NULL DEFAULT 1 COMMENT '1=ONLY IMAGE\n2=IMAGE AND MESSAGE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `management_livelihood_by_voucher`
--

CREATE TABLE `management_livelihood_by_voucher`
(
    `id`                            int(11) NOT NULL,
    `tax_support_id`                int(11) NOT NULL,
    `voucher_type_id`               int(11) NOT NULL,
    `people_type_identification_id` int(11) NOT NULL,
    `type_management`               int(11) NOT NULL DEFAULT 0 COMMENT '0=buys\n1=sales\netc'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_consultation_by_patient`
--

CREATE TABLE `medical_consultation_by_patient`
(
    `id`                  int(11) NOT NULL,
    `reason_consultation` text                    DEFAULT NULL,
    `status`              enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `deleted_at`          timestamp NULL DEFAULT NULL,
    `history_clinic_id`   int(11) NOT NULL,
    `payment_state`       int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT PAYMENT\n1=PAYMENT\n3=OTHERS',
    `user_id`             int(11) NOT NULL COMMENT 'USER MANAGER ADD CONSULT',
    `prepayment`          decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '0=NOT PAYMENT\n1=PAYMENT\n2=OTHERS',
    `price`               decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'PRICE BY CONSULT',
    `description`         text           NOT NULL COMMENT 'OBSERVATION'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations`
(
    `id`        int(10) UNSIGNED NOT NULL,
    `migration` varchar(255) NOT NULL,
    `batch`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mikrotik_by_customer_engagement`
--

CREATE TABLE `mikrotik_by_customer_engagement`
(
    `id`                              int(11) NOT NULL,
    `customer_id`                     int(11) NOT NULL,
    `address`                         text         NOT NULL,
    `engagement_number`               int(11) NOT NULL,
    `invoice_sale_id`                 int(11) NOT NULL,
    `type_ethernet`                   int(11) NOT NULL COMMENT '0=FIBRA OPTICA\n1=BANDA ANCHA',
    `mikrotik_rate_limit_id`          int(11) NOT NULL,
    `assigned_ip`                     varchar(200) NOT NULL,
    `mac_computer`                    varchar(200) NOT NULL,
    `computer_state`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `antenna_assigned_ip`             varchar(200) DEFAULT NULL,
    `antenna_mac_computer`            varchar(200) DEFAULT NULL,
    `antenna_state`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `mikrotik_dhcp_server_id`         int(11) NOT NULL,
    `antenna_mikrotik_dhcp_server_id` int(11) DEFAULT NULL,
    `business_id`                     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mikrotik_dhcp_server`
--

CREATE TABLE `mikrotik_dhcp_server`
(
    `id`                         int(11) NOT NULL,
    `name`                       varchar(200) NOT NULL,
    `interface`                  varchar(200) NOT NULL,
    `addres_pool`                varchar(200) NOT NULL,
    `address`                    varchar(200) NOT NULL,
    `business_id`                int(11) NOT NULL,
    `state`                      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `mikrotik_type_conection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mikrotik_rate_limit`
--

CREATE TABLE `mikrotik_rate_limit`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(200) NOT NULL,
    `business_id` int(11) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mikrotik_type_conection`
--

CREATE TABLE `mikrotik_type_conection`
(
    `id`           int(11) NOT NULL,
    `name`         varchar(200) NOT NULL,
    `user`         varchar(100) NOT NULL,
    `password`     varchar(100) NOT NULL,
    `ip_conection` varchar(200) NOT NULL,
    `business_id`  int(11) NOT NULL,
    `state`        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens`
(
    `id`         varchar(100) NOT NULL,
    `user_id`    int(11) DEFAULT NULL,
    `client_id`  int(11) NOT NULL,
    `name`       varchar(255) DEFAULT NULL,
    `scopes`     text         DEFAULT NULL,
    `revoked`    tinyint(1) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `expires_at` datetime     DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes`
(
    `id`         varchar(100) NOT NULL,
    `user_id`    int(11) NOT NULL,
    `client_id`  int(11) NOT NULL,
    `scopes`     text     DEFAULT NULL,
    `revoked`    tinyint(1) NOT NULL,
    `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients`
(
    `id`                     int(10) UNSIGNED NOT NULL,
    `user_id`                int(11) DEFAULT NULL,
    `name`                   varchar(255) NOT NULL,
    `secret`                 varchar(100) NOT NULL,
    `redirect`               text         NOT NULL,
    `personal_access_client` tinyint(1) NOT NULL,
    `password_client`        tinyint(1) NOT NULL,
    `revoked`                tinyint(1) NOT NULL,
    `created_at`             timestamp NULL DEFAULT NULL,
    `updated_at`             timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `client_id`  int(11) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens`
(
    `id`              varchar(100) NOT NULL,
    `access_token_id` varchar(100) NOT NULL,
    `revoked`         tinyint(1) NOT NULL,
    `expires_at`      datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `odontogram_by_patient`
--

CREATE TABLE `odontogram_by_patient`
(
    `id`                int(11) NOT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL,
    `deleted_at`        timestamp NULL DEFAULT NULL,
    `status`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`       text     NOT NULL,
    `date`              datetime NOT NULL,
    `history_clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_event_kits_by_customer`
--

CREATE TABLE `order_event_kits_by_customer`
(
    `id`                                        int(11) NOT NULL,
    `events_trails_registration_by_customer_id` int(11) NOT NULL,
    `product_id`                                int(11) NOT NULL,
    `size_id`                                   int(11) DEFAULT NULL,
    `color_id`                                  int(11) DEFAULT NULL,
    `delivery`                                  int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT DELIVERY\n1=DELIVERY'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments_document`
--

CREATE TABLE `order_payments_document`
(
    `id`                        int(11) NOT NULL,
    `order_payments_manager_id` int(11) NOT NULL,
    `source`                    varchar(250) NOT NULL,
    `account_bank`              varchar(150) NOT NULL,
    `number_bank`               varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments_manager`
--

CREATE TABLE `order_payments_manager`
(
    `id`                    int(11) NOT NULL,
    `business_id`           int(11) NOT NULL,
    `manager_state`         int(11) NOT NULL DEFAULT 0 COMMENT '0=CREADA\n1=EJECUTADA\n',
    `start`                 datetime NOT NULL,
    `manager_id`            text         DEFAULT NULL COMMENT 'Dependiendo dela forma de pago generara un id unico de la transaccion\npaypal=pay_id',
    `payer_id`              text         DEFAULT NULL,
    `token`                 varchar(350) DEFAULT NULL COMMENT 'todo depende dl typo d pago realizado al realizar l checkout',
    `type_payment_customer` int(11) NOT NULL DEFAULT 0 COMMENT '0=PAYPAL\n1=API CREDIT CARDS\n2=DEPOSITO',
    `end`                   datetime     DEFAULT NULL,
    `type_user`             int(11) NOT NULL DEFAULT 0 COMMENT '0=GUEST\n1=USER MANAGER '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_shopping_by_customer_delivery`
--

CREATE TABLE `order_shopping_by_customer_delivery`
(
    `id`                int(11) NOT NULL,
    `people_id`         int(11) NOT NULL,
    `payer_email`       varchar(350) NOT NULL,
    `company`           varchar(150) DEFAULT NULL,
    `address_secondary` text         NOT NULL,
    `city`              varchar(150) NOT NULL,
    `state_province_id` int(11) DEFAULT NULL,
    `zipcode`           varchar(80)  NOT NULL,
    `country_id`        int(11) NOT NULL,
    `user_id`           int(11) DEFAULT NULL,
    `phone`             varchar(45)  DEFAULT NULL,
    `address_main`      text         NOT NULL,
    `document`          varchar(45)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_shopping_by_delivery`
--

CREATE TABLE `order_shopping_by_delivery`
(
    `id`                     int(11) NOT NULL,
    `people_id`              int(11) NOT NULL,
    `payer_email`            varchar(350) NOT NULL,
    `company`                varchar(150) DEFAULT NULL,
    `address_secondary`      text         NOT NULL,
    `city`                   varchar(150) NOT NULL,
    `state_province_id`      int(11) DEFAULT NULL,
    `zipcode`                varchar(80)  NOT NULL,
    `country_id`             int(11) NOT NULL,
    `user_id`                int(11) DEFAULT NULL,
    `phone`                  varchar(45)  DEFAULT NULL,
    `address_main`           text         NOT NULL,
    `order_shopping_cart_id` int(11) NOT NULL,
    `document`               varchar(45)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_shopping_cart`
--

CREATE TABLE `order_shopping_cart`
(
    `id`                                     int(11) NOT NULL,
    `order_payments_manager_id`              int(11) NOT NULL,
    `state`                                  enum('CANCELED','TO DELIVER','DELIVERED','CREATED') NOT NULL DEFAULT 'TO DELIVER',
    `subtotal`                               float NOT NULL,
    `description`                            text  NOT NULL,
    `shipping`                               float NOT NULL DEFAULT 0,
    `created_at`                             timestamp NULL DEFAULT NULL,
    `updated_at`                             timestamp NULL DEFAULT NULL,
    `deleted_at`                             timestamp NULL DEFAULT NULL,
    `user_id`                                int(11) DEFAULT NULL,
    `order_shopping_by_customer_delivery_id` int(11) NOT NULL,
    `same_billing_address`                   int(11) NOT NULL DEFAULT 0 COMMENT '0=SAME BILLING\n1=OTHER BILLING DELIVERY'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_shopping_cart_by_details`
--

CREATE TABLE `order_shopping_cart_by_details`
(
    `id`                     int(11) NOT NULL,
    `product_id`             int(11) NOT NULL,
    `quantity`               float NOT NULL,
    `measure_id`             varchar(45)  DEFAULT NULL,
    `measure`                varchar(45)  DEFAULT NULL,
    `price`                  float        DEFAULT NULL,
    `price_before`           float        DEFAULT NULL,
    `price_discount`         float        DEFAULT NULL,
    `allow_discount`         int(11) NOT NULL DEFAULT 0,
    `promotion_id`           int(11) DEFAULT NULL,
    `name`                   varchar(350) DEFAULT NULL,
    `order_shopping_cart_id` int(11) NOT NULL,
    `product_color`          varchar(100) DEFAULT NULL,
    `product_color_id`       int(11) DEFAULT NULL,
    `product_sizes_id`       int(11) DEFAULT NULL,
    `product_sizes`          varchar(150) DEFAULT NULL,
    `type_variant`           int(11) NOT NULL DEFAULT 0 COMMENT '0:anyOneVariant,\n1: sizeSearch,\n2: colorSearch,\n3: colorAndSizeSearch'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panorama`
--

CREATE TABLE `panorama`
(
    `id`             int(11) NOT NULL,
    `title`          varchar(150) NOT NULL,
    `subtitle`       varchar(150) DEFAULT NULL,
    `description`    text         DEFAULT NULL,
    `type_panorama`  int(11) NOT NULL DEFAULT 0 COMMENT '0=NORMAL\n1=IMAGE RESUMEN MAP',
    `points_allow`   int(11) NOT NULL DEFAULT 1 COMMENT '0=not breakdown\n1= breakdown',
    `src`            varchar(250) NOT NULL,
    `type_breakdown` int(11) NOT NULL DEFAULT 0 COMMENT '0=PARENT\n1=CHILDREN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panorama_points`
--

CREATE TABLE `panorama_points`
(
    `id`           int(11) NOT NULL,
    `title`        varchar(150)   NOT NULL,
    `subtitle`     varchar(150) DEFAULT NULL,
    `description`  text         DEFAULT NULL,
    `next_type`    int(11) NOT NULL DEFAULT 0 COMMENT '0=DEFAULT IMAGE\n1=OTHERS',
    `coordinate_x` decimal(10, 6) NOT NULL,
    `coordinate_y` decimal(10, 6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters`
(
    `id`    int(11) NOT NULL,
    `name`  varchar(100) NOT NULL,
    `value` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets`
(
    `email`      varchar(255) NOT NULL,
    `token`      varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people`
(
    `id`        int(11) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `name`      varchar(100) NOT NULL,
    `birthdate` datetime DEFAULT NULL,
    `age`       int(11) NOT NULL DEFAULT 0,
    `gender`    int(11) NOT NULL COMMENT '0=MAN\n1=FEMALE\n2=LBTBI\n3=OTROS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_gender`
--

CREATE TABLE `people_gender`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_nationality`
--

CREATE TABLE `people_nationality`
(
    `id`           int(11) NOT NULL,
    `name`         varchar(45) NOT NULL,
    `description`  text DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL,
    `deleted_at`   timestamp NULL DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `countries_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_profession`
--

CREATE TABLE `people_profession`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text                 DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `codigo_iess` varchar(75) NOT NULL DEFAULT '000',
    `rmu`         float       NOT NULL DEFAULT 0,
    `dts`         float       NOT NULL DEFAULT 0,
    `dcs`         float       NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_relationship`
--

CREATE TABLE `people_relationship`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_type_identification`
--

CREATE TABLE `people_type_identification`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(45) NOT NULL,
    `description` text       DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `code`        varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prices_by_zones`
--

CREATE TABLE `prices_by_zones`
(
    `id`         int(11) NOT NULL,
    `price`      decimal(10, 4) NOT NULL,
    `zone_id`    int(11) NOT NULL,
    `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product`
(
    `id`                      int(11) NOT NULL,
    `code`                    varchar(64) NOT NULL,
    `name`                    text        NOT NULL,
    `state`                   enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_trademark_id`    int(11) NOT NULL,
    `product_category_id`     int(11) NOT NULL,
    `product_subcategory_id`  int(11) NOT NULL,
    `source`                  varchar(250) DEFAULT NULL,
    `description`             text         DEFAULT NULL,
    `code_provider`           varchar(80)  DEFAULT NULL,
    `code_product`            varchar(80)  DEFAULT NULL,
    `has_tax`                 int(11) NOT NULL DEFAULT 0,
    `is_service`              int(11) NOT NULL COMMENT '0=product\n1=service\n2=expense',
    `user_id`                 int(11) NOT NULL,
    `product_measure_type_id` int(11) NOT NULL,
    `view_online`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT VIEW\n1=VIEW ONLINE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `producto_has_precios`
--

CREATE TABLE `producto_has_precios`
(
    `id`     int(11) NOT NULL,
    `precio` double(20, 4
) NOT NULL,
  `prioridad` int(11) NOT NULL DEFAULT 1,
  `producto_inventario_id` int(11) NOT NULL,
  `utilidad` float NOT NULL DEFAULT 0,
  `type_price` int(11) NOT NULL DEFAULT 0 COMMENT '0=price product,1=price sale,2=price mitad',
  `measurement_type` int(11) NOT NULL DEFAULT 0 COMMENT '1=MEDIDA PRINCIPAL 0= MEDIDA SECUNDARIA',
  `manager_equivalence_id` int(11) NOT NULL DEFAULT 0 COMMENT 'RELACION DE LAS EQIVALENCIAS O MEDIDAS PARA PODER REALIZAR ALG ESTION',
  `type_of_income` int(11) NOT NULL DEFAULT 0 COMMENT '0=OUPTUT 1=INPUT',
  `description` text DEFAULT NULL COMMENT 'DESCRIPTION DATA OF PRICE '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_aplication`
--

CREATE TABLE `product_aplication`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(200) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_aplication`
--

CREATE TABLE `product_by_aplication`
(
    `product_id`            int(11) NOT NULL,
    `product_aplication_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_color`
--

CREATE TABLE `product_by_color`
(
    `product_id`       int(11) NOT NULL,
    `product_color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_details`
--

CREATE TABLE `product_by_details`
(
    `id`                    int(11) NOT NULL,
    `product_id`            int(11) NOT NULL,
    `tax_id`                int(11) NOT NULL,
    `location_details`      text DEFAULT NULL,
    `stock_control`         int(11) NOT NULL,
    `ice_control`           int(11) NOT NULL,
    `initial_stock_control` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_discount`
--

CREATE TABLE `product_by_discount`
(
    `id`         int(11) NOT NULL,
    `value`      float NOT NULL,
    `state`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_ice`
--

CREATE TABLE `product_by_ice`
(
    `id`             int(11) NOT NULL,
    `product_id`     int(11) NOT NULL,
    `product_ice_id` int(11) NOT NULL,
    `value`          decimal(10, 4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_log_inventory`
--

CREATE TABLE `product_by_log_inventory`
(
    `id`                     int(11) NOT NULL,
    `product_id`             int(11) NOT NULL,
    `type_of_income`         int(11) DEFAULT 0 COMMENT '0=OUPTUT 1=INPUT',
    `price_unit`             float DEFAULT NULL,
    `amount`                 float NOT NULL,
    `manager_equivalence_id` int(11) DEFAULT 0 COMMENT 'RELACION DE LAS EQIVALENCIAS O MEDIDAS PARA PODER REALIZAR ALG ESTION',
    `description`            text  DEFAULT NULL COMMENT 'Description data view '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_meta_data`
--

CREATE TABLE `product_by_meta_data`
(
    `id`          int(11) NOT NULL,
    `product_id`  int(11) NOT NULL,
    `title`       varchar(150) NOT NULL,
    `keyword`     varchar(45) DEFAULT NULL,
    `description` text        DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_multimedia`
--

CREATE TABLE `product_by_multimedia`
(
    `id`          int(11) NOT NULL,
    `title`       text         NOT NULL,
    `subtitle`    text DEFAULT NULL,
    `description` text DEFAULT NULL,
    `type`        int(11) NOT NULL,
    `priority`    int(11) NOT NULL,
    `view`        int(11) NOT NULL,
    `product_id`  int(11) NOT NULL,
    `source`      varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_package`
--

CREATE TABLE `product_by_package`
(
    `product_parent_by_package_params_id` int(11) NOT NULL,
    `product_id`                          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_route_map`
--

CREATE TABLE `product_by_route_map`
(
    `id`            int(11) NOT NULL,
    `product_id`    int(11) NOT NULL,
    `routes_map_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_sizes`
--

CREATE TABLE `product_by_sizes`
(
    `product_sizes_id` int(11) NOT NULL,
    `product_id`       int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_stock`
--

CREATE TABLE `product_by_stock`
(
    `id`         int(11) NOT NULL,
    `min`        float NOT NULL,
    `max`        float NOT NULL,
    `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_by_unity_inventory`
--

CREATE TABLE `product_by_unity_inventory`
(
    `id`                   int(11) NOT NULL,
    `units`                int(11) NOT NULL,
    `product_inventory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(200) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text         DEFAULT NULL,
    `subtitle`    varchar(250) DEFAULT NULL,
    `source`      varchar(250) DEFAULT NULL,
    `business_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(200) NOT NULL,
    `state`        enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`  text DEFAULT NULL,
    `multicolored` int(11) NOT NULL,
    `color`        varchar(45)  NOT NULL,
    `business_id`  int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_defect`
--

CREATE TABLE `product_defect`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(200) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_details_shipping_fee`
--

CREATE TABLE `product_details_shipping_fee`
(
    `id`         int(11) NOT NULL,
    `height`     float NOT NULL,
    `length`     float NOT NULL,
    `width`      float NOT NULL,
    `weight`     float NOT NULL,
    `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_ice`
--

CREATE TABLE `product_ice`
(
    `id`                   int(11) NOT NULL,
    `value`                varchar(45) NOT NULL,
    `description`          text DEFAULT NULL,
    `state`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `product_ice_types_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_ice_types`
--

CREATE TABLE `product_ice_types`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(45) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory`
--

CREATE TABLE `product_inventory`
(
    `id`                   int(11) NOT NULL,
    `business_id`          int(11) NOT NULL,
    `avarage_kardex_value` decimal(10, 4) DEFAULT NULL,
    `tax`                  enum('SI','NO') DEFAULT 'NO',
    `quantity_units`       decimal(10, 4) DEFAULT NULL,
    `sale_price`           decimal(10, 4) NOT NULL,
    `total_price`          decimal(10, 4) DEFAULT NULL,
    `product_id`           int(11) NOT NULL,
    `tax_id`               int(11) NOT NULL,
    `profit`               float          NOT NULL,
    `profit_type`          tinyint(1) NOT NULL,
    `note`                 text           DEFAULT NULL,
    `sale_price2`          decimal(10, 4) NOT NULL,
    `sale_price3`          decimal(10, 4) NOT NULL,
    `sale_price4`          decimal(10, 4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory_by_prices`
--

CREATE TABLE `product_inventory_by_prices`
(
    `id`                     int(11) NOT NULL,
    `product_inventory_id`   int(11) NOT NULL,
    `price`                  decimal(10, 4) NOT NULL,
    `priority`               int(11) NOT NULL,
    `utility`                float          NOT NULL,
    `type_price`             int(11) NOT NULL DEFAULT 0 COMMENT '0=price product,1=price sale,2=price mitad',
    `measurement_type`       int(11) NOT NULL DEFAULT 0 COMMENT '1=MEDIDA PRINCIPAL 0= MEDIDA SECUNDARIA',
    `manager_equivalence_id` int(11) NOT NULL DEFAULT 0 COMMENT 'RELACION DE LAS EQIVALENCIAS O MEDIDAS PARA PODER REALIZAR ALG ESTION',
    `type_of_income`         int(11) NOT NULL DEFAULT 0 COMMENT '0=OUPTUT 1=INPUT',
    `description`            text DEFAULT NULL COMMENT 'DESCRIPTION DATA OF PRICE '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory_by_price_unity_box`
--

CREATE TABLE `product_inventory_by_price_unity_box`
(
    `id`                   int(11) NOT NULL,
    `price`                decimal(10, 4) NOT NULL,
    `product_inventory_id` int(11) NOT NULL,
    `priority`             int(11) NOT NULL,
    `utility`              float          NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory_by_unity`
--

CREATE TABLE `product_inventory_by_unity`
(
    `id`                   int(11) NOT NULL,
    `units`                int(11) NOT NULL,
    `product_inventory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_measure_type`
--

CREATE TABLE `product_measure_type`
(
    `id`              int(11) NOT NULL,
    `value`           varchar(100) NOT NULL,
    `state`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`     text         DEFAULT NULL,
    `abbreviation`    varchar(100) DEFAULT NULL,
    `unit`            tinyint(4) DEFAULT NULL,
    `number_of_units` float        DEFAULT NULL,
    `prefix`          varchar(10)  NOT NULL,
    `symbol`          varchar(10)  DEFAULT NULL,
    `business_id`     int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_parent`
--

CREATE TABLE `product_parent`
(
    `id`                      int(11) NOT NULL,
    `code`                    varchar(64) NOT NULL,
    `name`                    text        NOT NULL,
    `state`                   enum('ACTIVE','INACTIVE','ERASER') NOT NULL DEFAULT 'ACTIVE',
    `product_category_id`     int(11) NOT NULL,
    `product_subcategory_id`  int(11) NOT NULL,
    `source`                  varchar(250) DEFAULT NULL,
    `description`             text         DEFAULT NULL,
    `has_tax`                 int(11) NOT NULL DEFAULT 0,
    `is_service`              int(11) NOT NULL COMMENT '0=product\n1=service\n2=expense',
    `user_id`                 int(11) NOT NULL,
    `product_measure_type_id` int(11) NOT NULL,
    `tax_id`                  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_parent_by_package_params`
--

CREATE TABLE `product_parent_by_package_params`
(
    `id`                          int(11) NOT NULL,
    `name`                        text  NOT NULL COMMENT 'Description data view ',
    `type_param`                  int(11) DEFAULT 0 COMMENT '0=igual a\n1=mayor y menor a\n2=mayor o igual a',
    `product_parent_id`           int(11) NOT NULL,
    `limit_one`                   float NOT NULL DEFAULT 1,
    `limit_two`                   float          DEFAULT 1,
    `product_parent_by_prices_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_parent_by_prices`
--

CREATE TABLE `product_parent_by_prices`
(
    `id`                     int(11) NOT NULL,
    `price`                  decimal(10, 4) NOT NULL,
    `priority`               int(11) NOT NULL,
    `utility`                float          NOT NULL,
    `type_price`             int(11) DEFAULT 0 COMMENT '0=price product,1=price sale,2=price mitad',
    `measurement_type`       int(11) DEFAULT 0 COMMENT '1=MEDIDA PRINCIPAL 0= MEDIDA SECUNDARIA',
    `manager_equivalence_id` int(11) DEFAULT 0 COMMENT 'RELACION DE LAS EQIVALENCIAS O MEDIDAS PARA PODER REALIZAR ALG ESTION',
    `type_of_income`         int(11) DEFAULT 0 COMMENT '0=OUPTUT 1=INPUT',
    `description`            text DEFAULT NULL COMMENT 'Description data view ',
    `product_parent_id`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_parent_by_product`
--

CREATE TABLE `product_parent_by_product`
(
    `id`                int(11) NOT NULL,
    `product_parent_id` int(11) NOT NULL,
    `product_id`        int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(200) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL,
    `business_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

CREATE TABLE `product_subcategory`
(
    `id`                  int(11) NOT NULL,
    `value`               varchar(200) NOT NULL,
    `state`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description`         text         DEFAULT NULL,
    `source`              varchar(250) DEFAULT NULL,
    `subtitle`            varchar(250) DEFAULT NULL,
    `product_category_id` int(11) NOT NULL,
    `business_id`         int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_trademark`
--

CREATE TABLE `product_trademark`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(200) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL,
    `business_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_header`
--

CREATE TABLE `project_header`
(
    `id`                                                int(11) NOT NULL,
    `name`                                              varchar(45) NOT NULL,
    `description`                                       text         DEFAULT NULL,
    `created_at`                                        timestamp NULL DEFAULT NULL,
    `status`                                            enum('ACTIVE','INACTIVE','INIT','END') NOT NULL DEFAULT 'ACTIVE',
    `predetermined`                                     int(11) DEFAULT 0,
    `year`                                              int(11) DEFAULT NULL,
    `business_id`                                       int(11) NOT NULL,
    `user_id`                                           int(11) NOT NULL,
    `contractor_company_name`                           varchar(250) DEFAULT NULL,
    `responsible_company_name`                          varchar(250) DEFAULT NULL,
    `help_desk_human_resources_employee_profile_id`     int(11) NOT NULL,
    `administrator_human_resources_employee_profile_id` int(11) NOT NULL,
    `countries_id`                                      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_header_by_resources`
--

CREATE TABLE `project_header_by_resources`
(
    `id`                int(11) NOT NULL,
    `type_multimedia`   int(11) NOT NULL DEFAULT 0 COMMENT '0=imagen\n1=video\n3=youtube,paginas de ',
    `url`               text NOT NULL,
    `description`       text DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `status`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `project_header_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces`
(
    `id`         int(11) NOT NULL,
    `name`       varchar(128) NOT NULL,
    `country_id` int(11) NOT NULL,
    `status`     enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `deleted_at` timestamp NULL DEFAULT NULL,
    `place_id`   varchar(200) DEFAULT 'none-id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference_piece`
--

CREATE TABLE `reference_piece`
(
    `id`                int(11) NOT NULL,
    `name`              varchar(45) NOT NULL,
    `type`              enum('INDIVIDUAL','COMPLETE') NOT NULL DEFAULT 'INDIVIDUAL',
    `status`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `reference_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference_piece_position`
--

CREATE TABLE `reference_piece_position`
(
    `id`       int(11) NOT NULL,
    `position` enum('TOP','DOWN','RIGHT','LEFT','CENTER','COMPLETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference_piece_type`
--

CREATE TABLE `reference_piece_type`
(
    `id`          int(11) NOT NULL,
    `color`       varchar(15) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `name`        varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair`
(
    `id`                    int(11) NOT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    `deleted_at`            timestamp NULL DEFAULT NULL,
    `register_manager_date` datetime       NOT NULL,
    `description`           text           NOT NULL,
    `customer_id`           int(11) NOT NULL,
    `value_taxes`           decimal(10, 4) NOT NULL,
    `subtotal`              decimal(10, 4) NOT NULL,
    `discount_value`        decimal(10, 4) NOT NULL DEFAULT 0.0000,
    `user_id`               int(11) NOT NULL,
    `observations_fix`      text                    DEFAULT NULL,
    `status`                enum('IN OBSERVATION','INITIATED','FINISHED','CANCELLED') NOT NULL DEFAULT 'IN OBSERVATION',
    `advance`               decimal(10, 4) NOT NULL DEFAULT 0.0000,
    `total`                 decimal(10, 4) NOT NULL,
    `delivery_date`         datetime       NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_by_details_parts`
--

CREATE TABLE `repair_by_details_parts`
(
    `id`                            int(11) NOT NULL,
    `repair_id`                     int(11) NOT NULL,
    `quantity`                      int(11) NOT NULL,
    `product_color_id`              int(11) NOT NULL,
    `repair_product_by_business_id` int(11) NOT NULL,
    `product_trademark_id`          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_product_by_business`
--

CREATE TABLE `repair_product_by_business`
(
    `id`          int(11) NOT NULL,
    `name`        text NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `description` text DEFAULT NULL,
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_product_by_color`
--

CREATE TABLE `repair_product_by_color`
(
    `repair_by_details_parts_id` int(11) NOT NULL,
    `product_color_id`           int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retention_tax_sub_type`
--

CREATE TABLE `retention_tax_sub_type`
(
    `id`                    int(11) NOT NULL,
    `value`                 varchar(250) NOT NULL,
    `description`           text DEFAULT NULL,
    `status`                enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `type`                  int(11) NOT NULL COMMENT '0=IVA \n1=RENTA',
    `retention_tax_type_id` int(11) NOT NULL,
    `percentage`            float        NOT NULL,
    `accounting_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retention_tax_type`
--

CREATE TABLE `retention_tax_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `type`        int(11) NOT NULL COMMENT '0=IVA \n1=RENTA'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles`
(
    `id`         int(11) NOT NULL,
    `name`       varchar(45) NOT NULL,
    `status`     enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes_drawing`
--

CREATE TABLE `routes_drawing`
(
    `id`           int(11) NOT NULL,
    `type`         int(11) NOT NULL COMMENT '0=marker ,singular\n1=polygon,singular\n2=rectangle,singular\n3=circle,singular\n4=polyline,many',
    `name`         varchar(150) NOT NULL,
    `description`  text DEFAULT NULL,
    `options_type` longtext     NOT NULL COMMENT 'coordinates,styles'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes_map`
--

CREATE TABLE `routes_map`
(
    `id`          int(11) NOT NULL,
    `type`        int(11) NOT NULL,
    `name`        varchar(150) NOT NULL,
    `description` text                  DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL,
    `options_map` text         NOT NULL,
    `src`         varchar(250) NOT NULL DEFAULT 'nothing'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes_map_by_routes_drawing`
--

CREATE TABLE `routes_map_by_routes_drawing`
(
    `id`                int(11) NOT NULL,
    `routes_map_id`     int(11) NOT NULL,
    `routes_drawing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `route_map_by_adventure_types`
--

CREATE TABLE `route_map_by_adventure_types`
(
    `id`                        int(11) NOT NULL,
    `business_by_routes_map_id` int(11) NOT NULL,
    `adventure_type`            int(11) NOT NULL COMMENT '0=Apnea (deporte)\n1=cicloturismo\n2=bungee o puenting\n3=rafting\n4=cabalgata\n5=montañismo o andinismo\n6=senderismo\n7=Ciclismo de montaña\n8=escalada\n9=canopy\n10=tirolesas\n11=overlanding\n12=rápel\n13=vías ferratas\n14=barranquismo\n15=parapente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruc_type`
--

CREATE TABLE `ruc_type`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(150) NOT NULL,
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_days_category`
--

CREATE TABLE `schedule_days_category`
(
    `id`          int(11) NOT NULL,
    `name`        varchar(250) NOT NULL,
    `weight_day`  int(11) NOT NULL COMMENT 'MONDAY=0\nTUESDAY=1\nWEDNESDAY=2\nTHURSDAY=3\nFRIDAY=4\nSATURDAY=5\nSUNDAY=6',
    `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scheduling_date`
--

CREATE TABLE `scheduling_date`
(
    `id`              int(11) NOT NULL,
    `title`           varchar(150) NOT NULL,
    `subtitle`        varchar(150) DEFAULT NULL,
    `description`     text         DEFAULT NULL,
    `options`         text         DEFAULT NULL COMMENT '1)constraint:\n businessHours,availableForMeeting\n2)color\n3)rendering\n4)overlap\n5)url',
    `start`           datetime     NOT NULL,
    `type_start`      int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT FRACTION DATE\n1=YES FRACTION DATE',
    `end`             datetime     DEFAULT NULL,
    `state`           enum('ACTIVE','INACTIVE','CANCELLED','FINISHED') NOT NULL DEFAULT 'ACTIVE',
    `type_end`        int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT FRACTION DATE\n1=YES FRACTION DATE',
    `type_scheduling` int(11) NOT NULL DEFAULT 0 COMMENT '0=only start\n1=only start and end\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `secretary_processes_by_customer_presentation`
--

CREATE TABLE `secretary_processes_by_customer_presentation`
(
    `id`                         int(11) NOT NULL,
    `customer_id`                int(11) NOT NULL,
    `state`                      int(11) NOT NULL COMMENT '0=INICIADA\n1=ELIMINADA\n\n2=PRESENTADA\n2=NO PRESENTADA\n',
    `owner_id`                   int(11) NOT NULL,
    `prosecution_process_number` varchar(150) DEFAULT NULL,
    `judical_process_number`     varchar(150) DEFAULT NULL,
    `date_of_presentation`       datetime     DEFAULT NULL,
    `due_date`                   datetime     DEFAULT NULL,
    `observation`                text         DEFAULT NULL,
    `date_of_state`              datetime     DEFAULT NULL,
    `business_id`                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rate_business`
--

CREATE TABLE `shipping_rate_business`
(
    `id`          int(11) NOT NULL,
    `title`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    `deleted_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rate_business_by_conversion_factor`
--

CREATE TABLE `shipping_rate_business_by_conversion_factor`
(
    `id`                            int(11) NOT NULL,
    `shipping_rate_services_id`     int(11) NOT NULL,
    `shipping_rate_kinds_of_way_id` int(11) NOT NULL,
    `product_measure_type_id`       int(11) NOT NULL,
    `shipping_rate_business_id`     int(11) NOT NULL,
    `type_local`                    int(11) NOT NULL COMMENT '0=OWNER COUNTRY\n1=OUT COUNTRY',
    `value_factor`                  float NOT NULL,
    `state`                         enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rate_business_by_min_weight`
--

CREATE TABLE `shipping_rate_business_by_min_weight`
(
    `id`                        int(11) NOT NULL,
    `shipping_rate_business_id` int(11) NOT NULL,
    `value`                     float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rate_kinds_of_way`
--

CREATE TABLE `shipping_rate_kinds_of_way`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rate_services`
--

CREATE TABLE `shipping_rate_services`
(
    `id`                        int(11) NOT NULL,
    `value`                     varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
    `description`               text DEFAULT NULL,
    `state`                     enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `shipping_rate_business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_by_business`
--

CREATE TABLE `students_by_business`
(
    `id`                      int(11) NOT NULL,
    `business_id`             int(11) NOT NULL,
    `user_id`                 int(11) NOT NULL,
    `students_information_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_by_representative`
--

CREATE TABLE `students_by_representative`
(
    `id`                         int(11) NOT NULL,
    `students_information_id`    int(11) NOT NULL,
    `students_representative_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_course_activities_by_resource`
--

CREATE TABLE `students_course_activities_by_resource`
(
    `id`                                              int(11) NOT NULL,
    `url`                                             varchar(450) NOT NULL,
    `type_multimedia`                                 int(11) NOT NULL DEFAULT 0 COMMENT '	0=IMAGE 1=VIDEO',
    `educational_institution_course_by_activities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_information`
--

CREATE TABLE `students_information`
(
    `id`                 int(11) NOT NULL,
    `people_id`          int(11) NOT NULL,
    `identification`     varchar(45) DEFAULT NULL,
    `institution`        varchar(45) DEFAULT NULL,
    `course`             varchar(45) DEFAULT NULL,
    `representative_has` int(11) NOT NULL DEFAULT 0 COMMENT '0\n1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_representative`
--

CREATE TABLE `students_representative`
(
    `id`                     int(11) NOT NULL,
    `identification`         varchar(45) NOT NULL,
    `people_id`              int(11) NOT NULL,
    `people_relationship_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_representative_by_business`
--

CREATE TABLE `students_representative_by_business`
(
    `id`                         int(11) NOT NULL,
    `students_representative_id` int(11) NOT NULL,
    `business_id`                int(11) NOT NULL,
    `user_id`                    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtipo_medicion`
--

CREATE TABLE `subtipo_medicion`
(
    `id`               int(11) NOT NULL,
    `nombre`           varchar(100) NOT NULL,
    `descripcion`      text DEFAULT NULL,
    `estado`           enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
    `simbolo`          varchar(10)  NOT NULL,
    `prefijo`          varchar(10)  NOT NULL,
    `has_equivalencia` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0= no tiene equivalencia\n1=tiene eqivalencia\nkm-> m\nm->km\nlitros->mll',
    `decimal_number`   int(11) NOT NULL,
    `is_base`          int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtipo_medicion_has_equivalencias`
--

CREATE TABLE `subtipo_medicion_has_equivalencias`
(
    `id`                               int(11) NOT NULL,
    `valor`                            double     NOT NULL,
    `subtipo_medicion_id`              int(11) NOT NULL,
    `subtipo_medicion_equivalencia_id` int(11) NOT NULL,
    `tipo_medida_manager_id`           int(11) NOT NULL,
    `position_matrix`                  varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax`
(
    `id`         int(11) NOT NULL,
    `value`      varchar(45) NOT NULL,
    `percentage` float       NOT NULL,
    `state`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes`
(
    `id`     int(11) NOT NULL,
    `name`   varchar(45)    NOT NULL,
    `value`  decimal(10, 4) NOT NULL,
    `status` enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes_by_cities`
--

CREATE TABLE `taxes_by_cities`
(
    `id`      int(11) NOT NULL,
    `city_id` int(11) NOT NULL,
    `tax_id`  int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_by_business`
--

CREATE TABLE `tax_by_business`
(
    `id`          int(11) NOT NULL,
    `tax_id`      int(11) NOT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_support`
--

CREATE TABLE `tax_support`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `code`        varchar(6)   NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_about_us`
--

CREATE TABLE `template_about_us`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_about_us_by_data`
--

CREATE TABLE `template_about_us_by_data`
(
    `id`                   int(11) NOT NULL,
    `title`                text NOT NULL,
    `description`          text NOT NULL,
    `status`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`               varchar(350) DEFAULT 'nothing',
    `allow_source`         int(11) NOT NULL DEFAULT 0,
    `template_about_us_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_blog`
--

CREATE TABLE `template_blog`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
    `user_id`                 int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_blog_by_comments`
--

CREATE TABLE `template_blog_by_comments`
(
    `id`               int(11) NOT NULL,
    `description`      text NOT NULL,
    `status`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `user_id`          int(11) NOT NULL,
    `name`             varchar(150) DEFAULT NULL,
    `email`            varchar(150) DEFAULT NULL,
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL,
    `deleted_at`       timestamp NULL DEFAULT NULL,
    `template_blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_blog_by_counters`
--

CREATE TABLE `template_blog_by_counters`
(
    `id`               int(11) NOT NULL,
    `template_blog_id` int(11) NOT NULL,
    `count`            int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_blog_by_data`
--

CREATE TABLE `template_blog_by_data`
(
    `id`               int(11) NOT NULL,
    `value`            varchar(45) NOT NULL,
    `description`      text        NOT NULL,
    `status`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`           varchar(350) DEFAULT 'nothing',
    `allow_source`     int(11) NOT NULL DEFAULT 0,
    `type_source`      int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
    `icon_class`       varchar(15)  DEFAULT NULL,
    `template_blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_by_products`
--

CREATE TABLE `template_by_products`
(
    `id`                      int(11) NOT NULL,
    `template_information_id` int(11) NOT NULL,
    `product_id`              int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_by_source`
--

CREATE TABLE `template_by_source`
(
    `id`                      int(11) NOT NULL,
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(250) NOT NULL,
    `source_type`             int(11) NOT NULL DEFAULT 0 COMMENT '0=logo template\netc..',
    `value`                   varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_chat_api`
--

CREATE TABLE `template_chat_api`
(
    `id`                      int(11) NOT NULL,
    `type`                    int(11) NOT NULL DEFAULT 0 COMMENT '0=MESSENGER FACEBOOK\n1 OTHERS',
    `options`                 text NOT NULL,
    `page_id`                 varchar(45) DEFAULT NULL COMMENT 'only facebook chat',
    `allow`                   int(11) NOT NULL DEFAULT 1 COMMENT '0=not\n1=yes',
    `template_information_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_config_mailing`
--

CREATE TABLE `template_config_mailing`
(
    `id`                      int(11) NOT NULL,
    `user`                    varchar(45) NOT NULL,
    `password`                varchar(45) NOT NULL,
    `provider_type`           int(11) NOT NULL COMMENT '0=server\n1=mandril\n2=mailchimp\n3=etc',
    `template_information_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_config_mailing_by_emails`
--

CREATE TABLE `template_config_mailing_by_emails`
(
    `id`                      int(11) NOT NULL,
    `email`                   varchar(150) NOT NULL,
    `type`                    int(11) NOT NULL DEFAULT 0 COMMENT '0=CONTACT US\n1=SERVICES\n2=ABOUT US',
    `template_information_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_contact_us`
--

CREATE TABLE `template_contact_us`
(
    `id`                      int(11) NOT NULL,
    `source`                  varchar(350) NOT NULL COMMENT 'image icono maps ',
    `template_information_id` int(11) NOT NULL,
    `allow_routes`            int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT\n1=YES'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_contact_us_by_routes_map`
--

CREATE TABLE `template_contact_us_by_routes_map`
(
    `id`                     int(11) NOT NULL,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`             timestamp NULL DEFAULT NULL,
    `updated_at`             timestamp NULL DEFAULT NULL,
    `deleted_at`             timestamp NULL DEFAULT NULL,
    `type_shortcut`          int(11) NOT NULL DEFAULT 0 COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico',
    `routes_map_id`          int(11) NOT NULL,
    `template_contact_us_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_faq`
--

CREATE TABLE `template_faq`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_faq_by_data`
--

CREATE TABLE `template_faq_by_data`
(
    `id`              int(11) NOT NULL,
    `value`           varchar(45) NOT NULL,
    `description`     text        NOT NULL,
    `status`          enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_faq_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_information`
--

CREATE TABLE `template_information`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_language_customer`
--

CREATE TABLE `template_language_customer`
(
    `id`          int(11) NOT NULL,
    `session_key` varchar(250) NOT NULL,
    `spanish`     int(11) NOT NULL DEFAULT 0 COMMENT '0 ENGLISH 1=SPANISH	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_multimedia_sections`
--

CREATE TABLE `template_multimedia_sections`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
    `section`                 int(11) NOT NULL DEFAULT 0 COMMENT '0=about us',
    `button_has`              int(11) NOT NULL DEFAULT 0,
    `button_options`          text         DEFAULT NULL COMMENT 'URL',
    `multimedia_has`          int(11) NOT NULL DEFAULT 0,
    `multimedia_options`      text         DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_news`
--

CREATE TABLE `template_news`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             mediumtext   DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `updated_at`              timestamp NULL DEFAULT NULL,
    `deleted_at`              timestamp NULL DEFAULT NULL,
    `user_id`                 int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_news_by_data`
--

CREATE TABLE `template_news_by_data`
(
    `id`               int(11) NOT NULL,
    `title`            text NOT NULL,
    `description`      text NOT NULL,
    `status`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`           varchar(350) DEFAULT 'nothing',
    `allow_source`     int(11) NOT NULL DEFAULT 0,
    `template_news_id` int(11) NOT NULL,
    `title_icon`       varchar(15)  DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_our_team`
--

CREATE TABLE `template_our_team`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_our_team_by_data`
--

CREATE TABLE `template_our_team_by_data`
(
    `id`                                  int(11) NOT NULL,
    `description`                         text NOT NULL,
    `status`                              enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`                              varchar(350) DEFAULT 'nothing',
    `allow_source`                        int(11) NOT NULL DEFAULT 0,
    `type_source`                         int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
    `template_our_team_id`                int(11) NOT NULL,
    `human_resources_employee_profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_payments`
--

CREATE TABLE `template_payments`
(
    `id`                      int(11) NOT NULL,
    `type_payment`            int(11) NOT NULL DEFAULT 0 COMMENT '0=PAYPAL\n1=PAYU',
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL,
    `template_information_id` int(11) NOT NULL,
    `type_manager`            int(11) NOT NULL DEFAULT 0 COMMENT '0=MODE TEST\n1=LIVE PRODUCTION',
    `user`                    varchar(150) DEFAULT NULL,
    `password`                varchar(150) DEFAULT NULL,
    `test_id`                 text         DEFAULT NULL COMMENT 'API_LIVE_CLIENT_ID',
    `test_secret`             text         DEFAULT NULL COMMENT 'API_LIVE_SECRET',
    `live_id`                 text         DEFAULT NULL COMMENT 'SAND_BOX_CLIENT_ID',
    `live_secret`             text         DEFAULT NULL COMMENT 'SAND_BOX_SECRET',
    `msj_to_customer`         text         DEFAULT NULL,
    `manager_type_modal`      int(11) NOT NULL DEFAULT 0 COMMENT '0=NOT MODAL\n1=MODAL',
    `priority`                int(11) NOT NULL DEFAULT 0 COMMENT '0,1,2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_policies`
--

CREATE TABLE `template_policies`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type`                    int(11) NOT NULL DEFAULT 0 COMMENT '0=POLICIES\n1=TERMS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_services`
--

CREATE TABLE `template_services`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_services_by_data`
--

CREATE TABLE `template_services_by_data`
(
    `id`                   int(11) NOT NULL,
    `title`                text NOT NULL,
    `description`          text NOT NULL,
    `status`               enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`               varchar(350) DEFAULT 'nothing',
    `allow_source`         int(11) NOT NULL DEFAULT 0,
    `template_services_id` int(11) NOT NULL,
    `title_icon`           varchar(15)  DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_slider`
--

CREATE TABLE `template_slider`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `position_section`        int(11) NOT NULL DEFAULT 0 COMMENT '0=SLIDER MAIN\n1=SLIDER ACTIVITY GAMIFICATION\n2=SLIDER REWARD GAMIFICATION',
    `code`                    VARCHAR(150) NOT NULL COMMENT 'codigo unico para la creacion de slider asi podremos saber en q posicion estara en las paginas del eccomerce'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_slider_by_images`
--

CREATE TABLE `template_slider_by_images`
(
    `id`                 int(11) NOT NULL,
    `source`             varchar(350) NOT NULL DEFAULT 'nothing',
    `template_slider_id` int(11) NOT NULL,
    `title`              text                  DEFAULT NULL,
    `subtitle`           text                  DEFAULT NULL,
    `options_title`      text                  DEFAULT NULL,
    `button_name`        varchar(45)           DEFAULT NULL,
    `options_button`     text                  DEFAULT NULL,
    `options_subtitle`   text                  DEFAULT NULL,
    `options_all`        text                  DEFAULT NULL,
    `options_source`     text                  DEFAULT NULL,
    `position`           int(11) NOT NULL DEFAULT 0,
    `status`             enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `type_button`        int(11) NOT NULL DEFAULT 0 COMMENT '0=not button',
    `type_multimedia`    int(11) NOT NULL DEFAULT 1 COMMENT '0=ONLY BACKGROUND\n1=BACKGROUND AND TEXT'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_steps`
--

CREATE TABLE `template_steps`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_steps_by_data`
--

CREATE TABLE `template_steps_by_data`
(
    `id`                int(11) NOT NULL,
    `value`             varchar(45) NOT NULL,
    `description`       text        NOT NULL,
    `status`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`            varchar(350) DEFAULT 'nothing',
    `allow_source`      int(11) NOT NULL DEFAULT 0,
    `type_source`       int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
    `icon_class`        varchar(15)  DEFAULT NULL,
    `template_steps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_support`
--

CREATE TABLE `template_support`
(
    `id`                      int(11) NOT NULL,
    `value`                   varchar(150) NOT NULL,
    `description`             text         DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `template_information_id` int(11) NOT NULL,
    `source`                  varchar(350) DEFAULT 'nothing',
    `allow_source`            int(11) NOT NULL DEFAULT 0,
    `subtitle`                text         DEFAULT NULL,
    `type_source`             int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_support_by_data`
--

CREATE TABLE `template_support_by_data`
(
    `id`                  int(11) NOT NULL,
    `title`               text NOT NULL,
    `description`         text NOT NULL,
    `status`              enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `source`              varchar(350) DEFAULT 'nothing',
    `allow_source`        int(11) NOT NULL DEFAULT 0,
    `template_support_id` int(11) NOT NULL,
    `type_source`         int(11) NOT NULL DEFAULT 0 COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_wish_list_by_user`
--

CREATE TABLE `template_wish_list_by_user`
(
    `id`                      int(11) NOT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `updated_at`              timestamp NULL DEFAULT NULL,
    `deleted_at`              timestamp NULL DEFAULT NULL,
    `template_information_id` int(11) NOT NULL,
    `product_id`              int(11) NOT NULL,
    `user_id`                 int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_medida_has_subtipo`
--

CREATE TABLE `tipo_medida_has_subtipo`
(
    `id`                     int(11) NOT NULL,
    `subtipo_medicion_id`    int(11) NOT NULL,
    `is_base`                int(11) DEFAULT 0 COMMENT '0=no,1=si',
    `state`                  int(11) DEFAULT 1 COMMENT '1=active,0=inactive',
    `type_manager_condition` int(11) DEFAULT 1 COMMENT '0=Unidad de medida de referencia para esta categoría,1=Unidad de medida de referencia para esta categoría,2=Más grande que la unidad de medida de referencia',
    `ratio`                  double NOT NULL DEFAULT 0,
    `decimal_number`         double NOT NULL DEFAULT 0,
    `tipo_medida_manager_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_medida_manager`
--

CREATE TABLE `tipo_medida_manager`
(
    `id`                      int(11) NOT NULL,
    `description`             text        NOT NULL,
    `name`                    varchar(75) NOT NULL,
    `business_manager_id`     int(11) NOT NULL COMMENT 'empresa gestion',
    `state`                   int(11) DEFAULT 1 COMMENT '1=active,0=inactive',
    `producto_tipo_medida_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_advance`
--

CREATE TABLE `treatment_by_advance`
(
    `id`                      int(11) NOT NULL,
    `advance`                 decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'ad',
    `type_input`              int(11) NOT NULL DEFAULT 0 COMMENT '0=OUTPUT\n1=INPUT s',
    `created_at`              timestamp NULL DEFAULT NULL COMMENT 'c',
    `updated_at`              timestamp NULL DEFAULT NULL COMMENT 'u',
    `deleted_at`              timestamp NULL DEFAULT NULL COMMENT 'd',
    `treatment_by_patient_id` int(11) NOT NULL COMMENT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_breakdown_payment`
--

CREATE TABLE `treatment_by_breakdown_payment`
(
    `id`                                       int(11) NOT NULL COMMENT 'id',
    `date_agreement`                           datetime       NOT NULL COMMENT 'da',
    `payment_value`                            decimal(10, 4) NOT NULL COMMENT 'value',
    `state_payment`                            int(11) NOT NULL DEFAULT 1 COMMENT '0=pagado\n 1=deuda',
    `user_id`                                  int(11) NOT NULL,
    `treatment_by_indebtedness_paying_init_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_details`
--

CREATE TABLE `treatment_by_details`
(
    `id`                       int(11) NOT NULL,
    `product_id`               int(11) NOT NULL COMMENT 'service or product',
    `quantity`                 decimal(10, 4) DEFAULT NULL COMMENT 'qu',
    `quantity_unit`            decimal(10, 4) DEFAULT NULL COMMENT 'u',
    `discount_percentage`      decimal(10, 4) DEFAULT NULL COMMENT 'per',
    `discount_percentage_unit` decimal(10, 4) DEFAULT NULL COMMENT 'per uni',
    `discount_value`           decimal(10, 4) DEFAULT NULL COMMENT 'dis',
    `discount_value_unit`      decimal(10, 4) DEFAULT NULL COMMENT 'dis',
    `unit_price`               decimal(10, 4) DEFAULT NULL COMMENT 'unit pri',
    `unit_price_unit`          decimal(10, 4) DEFAULT NULL COMMENT 'unit',
    `management_type`          char(3)        DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.\n\n',
    `tax_percentage`           int(11) DEFAULT NULL COMMENT '2',
    `subtotal`                 decimal(10, 4) NOT NULL COMMENT 's',
    `total`                    decimal(10, 4) NOT NULL COMMENT 't',
    `description`              text           DEFAULT NULL COMMENT 'des\n',
    `product_type`             varchar(45)    DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND\n\n',
    `treatment_by_patient_id`  int(11) NOT NULL COMMENT 'f'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_indebtedness_paying_init`
--

CREATE TABLE `treatment_by_indebtedness_paying_init`
(
    `id`                      int(11) NOT NULL,
    `number_payments`         int(11) NOT NULL COMMENT 'numvber',
    `user_id`                 int(11) NOT NULL COMMENT 'user',
    `treatment_by_patient_id` int(11) NOT NULL COMMENT 'tl'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_patient`
--

CREATE TABLE `treatment_by_patient`
(
    `id`                    int(11) NOT NULL,
    `customer_id`           int(11) NOT NULL COMMENT 'customer',
    `invoice_code`          varchar(45)    NOT NULL COMMENT 'invo',
    `invoice_value`         decimal(10, 4) NOT NULL COMMENT 'value',
    `discount_value`        decimal(10, 4) DEFAULT NULL COMMENT 'dis',
    `status`                enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED' COMMENT 'sta',
    `created_at`            datetime       NOT NULL COMMENT 'c',
    `user_id`               int(11) NOT NULL,
    `observations`          text           DEFAULT NULL COMMENT 'o',
    `value_taxes`           decimal(10, 4) NOT NULL COMMENT 'tx',
    `subtotal`              decimal(10, 4) NOT NULL COMMENT 'sub',
    `authorization_number`  varchar(150)   NOT NULL COMMENT 'aut',
    `invoice_date`          datetime       NOT NULL COMMENT 'invo',
    `establishment`         varchar(3)     NOT NULL COMMENT 'e',
    `emission_point`        varchar(3)     NOT NULL COMMENT 'ee',
    `mixed_payment`         int(11) NOT NULL DEFAULT 1 COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS\n',
    `has_retention`         int(11) NOT NULL DEFAULT 1 COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion\n',
    `debt`                  int(11) NOT NULL DEFAULT 0 COMMENT '0=sin DEUDA\n 1=DEUDA\n\n',
    `freight`               int(11) NOT NULL DEFAULT 0 COMMENT 'fre',
    `type_of_discount`      int(11) NOT NULL DEFAULT 0 COMMENT '0=% \n1=$\n1',
    `discount_type_invoice` int(11) NOT NULL DEFAULT 0 COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	\ns',
    `history_clinic_id`     int(11) NOT NULL COMMENT 'key'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_by_payment`
--

CREATE TABLE `treatment_by_payment`
(
    `id`                                       int(11) NOT NULL COMMENT 'id',
    `payment_date`                             datetime NOT NULL COMMENT 'oa',
    `state_payment`                            int(11) NOT NULL DEFAULT 1 COMMENT '1=puntual\n 0=atrasado',
    `details`                                  text DEFAULT NULL COMMENT 'det',
    `types_payments_by_account_id`             int(11) NOT NULL COMMENT 's',
    `accounting_account_id`                    int(11) DEFAULT NULL COMMENT 'd',
    `user_id`                                  int(11) NOT NULL COMMENT '1',
    `treatment_by_breakdown_payment_id`        int(11) NOT NULL COMMENT '2',
    `treatment_by_indebtedness_paying_init_id` int(11) NOT NULL COMMENT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types_payments`
--

CREATE TABLE `types_payments`
(
    `id`           int(11) NOT NULL,
    `value`        varchar(250) NOT NULL,
    `description`  text DEFAULT NULL,
    `status`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `code`         varchar(6)   NOT NULL,
    `type_payment` int(11) NOT NULL COMMENT '0=CASH\n1=BANK\n2=CREDIT CARD\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types_payments_by_account`
--

CREATE TABLE `types_payments_by_account`
(
    `id`                    int(11) NOT NULL COMMENT 'TYPOS DE PAGOS HAS CUENTA ENTIDAD',
    `accounting_account_id` int(11) NOT NULL,
    `types_payments_id`     int(11) NOT NULL,
    `business_id`           int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_ruc`
--

CREATE TABLE `type_ruc`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `universidad_titulos`
--

CREATE TABLE `universidad_titulos`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(75) NOT NULL,
    `descripcion` text DEFAULT NULL,
    `estado`      enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
    `id`             int(10) UNSIGNED NOT NULL,
    `name`           varchar(255) NOT NULL,
    `email`          varchar(255) NOT NULL,
    `username`       varchar(45)  DEFAULT NULL,
    `password`       varchar(255) NOT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `status`         enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL,
    `provider_id`    text         DEFAULT NULL COMMENT 'is user id login red social',
    `provider`       text         DEFAULT NULL COMMENT '0=owner server\n1=facebook\n2=gmail\n3=others',
    `api_token`      text         DEFAULT NULL,
    `user_id`        int(11) DEFAULT NULL COMMENT 'social network id',
    `avatar`         text         DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_by_about_us`
--

CREATE TABLE `users_by_about_us`
(
    `id`          int(11) NOT NULL,
    `users_id`    int(10) UNSIGNED NOT NULL,
    `description` text NOT NULL,
    `web`         varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_has_roles`
--

CREATE TABLE `users_has_roles`
(
    `user_id` int(10) UNSIGNED NOT NULL,
    `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_type`
--

CREATE TABLE `voucher_type`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(250) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `code`        varchar(6)   NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_planning_header`
--

CREATE TABLE `work_planning_header`
(
    `id`            int(11) NOT NULL,
    `name`          varchar(45) NOT NULL,
    `description`   text DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `status`        enum('ACTIVE','INACTIVE','INIT','END') NOT NULL DEFAULT 'ACTIVE',
    `predetermined` int(11) DEFAULT 0,
    `year`          int(11) DEFAULT NULL,
    `hours`         time        NOT NULL,
    `business_id`   int(11) NOT NULL,
    `user_id`       int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_planning_header_by_resources`
--

CREATE TABLE `work_planning_header_by_resources`
(
    `id`                      int(11) NOT NULL,
    `type_multimedia`         int(11) NOT NULL DEFAULT 0 COMMENT '0=imagen\n1=video\n3=youtube,paginas de ',
    `url`                     text NOT NULL,
    `description`             text DEFAULT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `status`                  enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `work_planning_header_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones`
(
    `id`                  int(11) NOT NULL,
    `name`                varchar(256) NOT NULL,
    `city_id`             int(11) NOT NULL,
    `color`               varchar(7)   NOT NULL,
    `zip_code`            varchar(45)  DEFAULT NULL,
    `polygon_coordinates` text         DEFAULT NULL,
    `polygon_spatial`     polygon      DEFAULT NULL,
    `status`              enum('ACTIVE','INACTIVE') NOT NULL,
    `created_at`          timestamp NULL DEFAULT NULL,
    `updated_at`          timestamp NULL DEFAULT NULL,
    `deleted_at`          timestamp NULL DEFAULT NULL,
    `place_id`            varchar(200) DEFAULT 'none-id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounting_account`
--
ALTER TABLE `accounting_account`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounting_account_accounting_level1_idx` (`accounting_level_id`),
  ADD KEY `fk_accounting_account_accounting_account_type1_idx` (`accounting_account_type_id`);

--
-- Indexes for table `accounting_account_by_balances`
--
ALTER TABLE `accounting_account_by_balances`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounting_account_balances_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `accounting_account_type`
--
ALTER TABLE `accounting_account_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounting_bank`
--
ALTER TABLE `accounting_bank`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `accounting_config_modules_account_by_account`
--
ALTER TABLE `accounting_config_modules_account_by_account`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounting_config_modules_account_by_modules_accounting__idx` (`accounting_config_modules_types_id`),
  ADD KEY `fk_accounting_config_modules_account_by_account_accounting__idx` (`accounting_account_id`);

--
-- Indexes for table `accounting_config_modules_types`
--
ALTER TABLE `accounting_config_modules_types`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounting_level`
--
ALTER TABLE `accounting_level`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_gamification`
--
ALTER TABLE `account_gamification`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_gamification_by_movement`
--
ALTER TABLE `account_gamification_by_movement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_by_movement_account_gamification1_idx` (`account_gamification_id`);

--
-- Indexes for table `account_gamification_movement_by_business`
--
ALTER TABLE `account_gamification_movement_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_gamification_movement_by_business_account_gamifi_idx` (`account_gamification_by_movement_id`),
  ADD KEY `fk_account_gamification_movement_by_business_business1_idx` (`business_id`);

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actions_actions1_idx` (`parent_id`);

--
-- Indexes for table `actions_by_role`
--
ALTER TABLE `actions_by_role`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actions_by_role_roles1_idx` (`role_id`),
  ADD KEY `fk_actions_by_role_actions1_idx` (`action_id`);

--
-- Indexes for table `allergies`
--
ALTER TABLE `allergies`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allergies_by_history_clinic`
--
ALTER TABLE `allergies_by_history_clinic`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_allergies_by_history_clinic_allergies1_idx` (`allergies_id`),
  ADD KEY `fk_allergies_by_history_clinic_history_clinic1_idx` (`history_clinic_id`);

--
-- Indexes for table `allowed_actions`
--
ALTER TABLE `allowed_actions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_allowed_actions_actions1_idx` (`action_id`);

--
-- Indexes for table `allow_processes_threads`
--
ALTER TABLE `allow_processes_threads`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antecedent`
--
ALTER TABLE `antecedent`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antecedent_by_history_clinic`
--
ALTER TABLE `antecedent_by_history_clinic`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_antecedent_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  ADD KEY `fk_antecedent_by_history_clinic_antecedent1_idx` (`antecedent_id`);

--
-- Indexes for table `antecedent_family_members_by_history_clinic`
--
ALTER TABLE `antecedent_family_members_by_history_clinic`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_antecedent_family_members_by_history_clinic_history_clin_idx` (`history_clinic_id`),
  ADD KEY `fk_antecedent_family_members_by_history_clinic_antecedent1_idx` (`antecedent_id`),
  ADD KEY `fk_antecedent_family_members_by_history_clinic_people_relat_idx` (`people_relationship_id`);

--
-- Indexes for table `askwer_entity_answer`
--
ALTER TABLE `askwer_entity_answer`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `askwer_field`
--
ALTER TABLE `askwer_field`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_askwer_field_askwer_section1_idx` (`askwer_section_id`);

--
-- Indexes for table `askwer_field_value`
--
ALTER TABLE `askwer_field_value`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_askwer_field_value_askwer_field1_idx` (`askwer_field_id`),
  ADD KEY `fk_askwer_field_value_askwer_entity_answer1_idx` (`askwer_entity_answer_id`);

--
-- Indexes for table `askwer_form`
--
ALTER TABLE `askwer_form`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `askwer_option`
--
ALTER TABLE `askwer_option`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_askwer_option_askwer_field1_idx` (`askwer_field_id`);

--
-- Indexes for table `askwer_section`
--
ALTER TABLE `askwer_section`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_askwer_section_askwer_form1_idx` (`askwer_form_id`);

--
-- Indexes for table `askwer_type`
--
ALTER TABLE `askwer_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `average_kardex`
--
ALTER TABLE `average_kardex`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_average_kardex_product1_idx` (`product_id`),
  ADD KEY `fk_average_kardex_business1_idx` (`business_id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_by_movement`
--
ALTER TABLE `bank_by_movement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_by_movement_accounting_account1_idx` (`accounting_account_id`),
  ADD KEY `fk_bank_by_movement_bank_reason1_idx` (`bank_reason_id`),
  ADD KEY `fk_bank_by_movement_accounting_bank1_idx` (`accounting_bank_id`);

--
-- Indexes for table `bank_by_transaction_management`
--
ALTER TABLE `bank_by_transaction_management`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_by_transaction_management_types_payments1_idx` (`types_payments_id`),
  ADD KEY `fk_bank_by_transaction_management_business_by_bank1_idx` (`business_by_bank_id`),
  ADD KEY `fk_bank_by_transaction_management_entidad_data1_idx` (`entidad_data_id`);

--
-- Indexes for table `bank_movement_by_accounting_seat`
--
ALTER TABLE `bank_movement_by_accounting_seat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_movement_by_accounting_seat_daily_book_seat1_idx` (`daily_book_seat_id`),
  ADD KEY `fk_cash_movement_by_accounting_seat_copy1_bank_by_movement1_idx` (`bank_by_movement_id`);

--
-- Indexes for table `bank_reason`
--
ALTER TABLE `bank_reason`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_business_subcategories_idx` (`business_subcategories_id`);

--
-- Indexes for table `business_academic_offerings_by_data`
--
ALTER TABLE `business_academic_offerings_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_academic_offerings_by_data_business_by_academic_idx` (`business_by_academic_offerings_id`);

--
-- Indexes for table `business_academic_offerings_data_by_information`
--
ALTER TABLE `business_academic_offerings_data_by_information`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_amenities`
--
ALTER TABLE `business_amenities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_amenities_business_subcategories1_idx` (`business_subcategories_id`);

--
-- Indexes for table `business_by_about`
--
ALTER TABLE `business_by_about`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_about_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_academic_offerings`
--
ALTER TABLE `business_by_academic_offerings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_academic_offerings_institution`
--
ALTER TABLE `business_by_academic_offerings_institution`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_amenities`
--
ALTER TABLE `business_by_amenities`
    ADD PRIMARY KEY (`business_amenities_id`, `business_id`),
  ADD KEY `fk_business_by_amenities_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_bank`
--
ALTER TABLE `business_by_bank`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_bank_accounting_bank1_idx` (`accounting_bank_id`),
  ADD KEY `fk_business_by_bank_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_cash`
--
ALTER TABLE `business_by_cash`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_cash_cash1_idx` (`cash_id`),
  ADD KEY `fk_business_by_cash_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_cash_main`
--
ALTER TABLE `business_by_cash_main`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_cash_main_business_by_cash1_idx` (`business_by_cash_id`);

--
-- Indexes for table `business_by_counter`
--
ALTER TABLE `business_by_counter`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_counter_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_coupon`
--
ALTER TABLE `business_by_coupon`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_coupon_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_daily_book_seat`
--
ALTER TABLE `business_by_daily_book_seat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_daily_book_seat_daily_book_seat1_idx` (`daily_book_seat_id`),
  ADD KEY `fk_business_by_daily_book_seat_diary_book1_idx` (`diary_book_id`),
  ADD KEY `fk_business_by_daily_book_seat_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_discount`
--
ALTER TABLE `business_by_discount`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_discount_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_documents`
--
ALTER TABLE `business_by_documents`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_documents_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_employee_profile`
--
ALTER TABLE `business_by_employee_profile`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_employee_profile_human_resources_employee_pr_idx` (`human_resources_employee_profile_id`),
  ADD KEY `fk_business_by_employee_profile_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_final_customer`
--
ALTER TABLE `business_by_final_customer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_final_customer_customer1_idx` (`customer_id`);

--
-- Indexes for table `business_by_frequent_question`
--
ALTER TABLE `business_by_frequent_question`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_gallery`
--
ALTER TABLE `business_by_gallery`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_gallery_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_gamification`
--
ALTER TABLE `business_by_gamification`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_gamification_gamification1_idx` (`gamification_id`),
  ADD KEY `fk_business_by_gamification_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_history`
--
ALTER TABLE `business_by_history`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_information_custom`
--
ALTER TABLE `business_by_information_custom`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_inventory_management`
--
ALTER TABLE `business_by_inventory_management`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_inventory_management_subcategory`
--
ALTER TABLE `business_by_inventory_management_subcategory`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_invoice_buy`
--
ALTER TABLE `business_by_invoice_buy`
    ADD PRIMARY KEY (`id`, `business_id`),
  ADD KEY `fk_business_by_invoice_buy_invoice_buy1_idx` (`invoice_buy_id`),
  ADD KEY `fk_business_by_invoice_buy_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_invoice_sale`
--
ALTER TABLE `business_by_invoice_sale`
    ADD PRIMARY KEY (`id`, `business_id`),
  ADD KEY `fk_business_by_invoice_buy_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_invoice_sale_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `business_by_language`
--
ALTER TABLE `business_by_language`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_language_language1_idx` (`language_id`),
  ADD KEY `fk_business_by_language_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_lodging_by_price`
--
ALTER TABLE `business_by_lodging_by_price`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_room_by_price_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_lodging_by_price_lodging_type_of_room_by_pri_idx` (`lodging_type_of_room_by_price_id`);

--
-- Indexes for table `business_by_menu_management_frontend`
--
ALTER TABLE `business_by_menu_management_frontend`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_panorama`
--
ALTER TABLE `business_by_panorama`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_panorama_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_panorama_panorama1_idx` (`panorama_id`),
  ADD KEY `fk_business_by_panorama_routes_map_by_routes_drawing1_idx` (`routes_map_by_routes_drawing_id`);

--
-- Indexes for table `business_by_partner_companies`
--
ALTER TABLE `business_by_partner_companies`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_products`
--
ALTER TABLE `business_by_products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_products_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_products_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_products_parent_product_parent1_idx` (`product_parent_id`);

--
-- Indexes for table `business_by_promotion`
--
ALTER TABLE `business_by_promotion`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_promotion_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_qualification`
--
ALTER TABLE `business_by_qualification`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_qualification_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_requirements`
--
ALTER TABLE `business_by_requirements`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_by_routes_map`
--
ALTER TABLE `business_by_routes_map`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_routes_map_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_routes_map_routes_map1_idx` (`routes_map_id`);

--
-- Indexes for table `business_by_schedule`
--
ALTER TABLE `business_by_schedule`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_shedule_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_schedule_schedule_days_category1_idx` (`schedule_days_category_id`);

--
-- Indexes for table `business_by_scheduling_date`
--
ALTER TABLE `business_by_scheduling_date`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_scheduling_date_scheduling_date1_idx` (`scheduling_date_id`),
  ADD KEY `fk_business_by_scheduling_date_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_services`
--
ALTER TABLE `business_by_services`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_services_product1_idx` (`product_id`),
  ADD KEY `fk_business_by_services_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_services_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `business_by_shipping_rate`
--
ALTER TABLE `business_by_shipping_rate`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_shipping_rate_shipping_rate_business1_idx` (`shipping_rate_business_id`),
  ADD KEY `fk_business_by_shipping_rate_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_social_networks`
--
ALTER TABLE `business_by_social_networks`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_social_networks_business1_idx` (`business_id`);

--
-- Indexes for table `business_by_tax`
--
ALTER TABLE `business_by_tax`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_tax_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_tax_taxes1_idx` (`taxes_id`);

--
-- Indexes for table `business_categories`
--
ALTER TABLE `business_categories`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_counter_custom`
--
ALTER TABLE `business_counter_custom`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_counter_custom_by_data`
--
ALTER TABLE `business_counter_custom_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_counter_custom_by_data_business_counter_custom1_idx` (`business_counter_custom_id`);

--
-- Indexes for table `business_disbursement`
--
ALTER TABLE `business_disbursement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_disbursement_business1_idx` (`business_id`),
  ADD KEY `fk_business_disbursement_bank1_idx` (`bank_id`);

--
-- Indexes for table `business_discount_by_product`
--
ALTER TABLE `business_discount_by_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_promotion_business1_idx` (`business_id`);

--
-- Indexes for table `business_history_by_data`
--
ALTER TABLE `business_history_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_history_by_data_business_by_history1_idx` (`business_by_history_id`);

--
-- Indexes for table `business_location`
--
ALTER TABLE `business_location`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_location_business1_idx` (`business_id`),
  ADD KEY `fk_business_location_zones1_idx` (`zones_id`);

--
-- Indexes for table `business_panorama_by_points`
--
ALTER TABLE `business_panorama_by_points`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_panorama_by_breakdown_business_by_panorama1_idx` (`business_by_panorama_id`),
  ADD KEY `fk_business_panorama_by_breakdown_panorama_points1_idx` (`panorama_points_id`),
  ADD KEY `fk_business_panorama_by_points_panorama1_idx` (`panorama_id`);

--
-- Indexes for table `business_schedule_by_breakdown`
--
ALTER TABLE `business_schedule_by_breakdown`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_schedule_by_breakdown_business_by_schedule1_idx` (`business_by_schedule_id`);

--
-- Indexes for table `business_subcategories`
--
ALTER TABLE `business_subcategories`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_subcategories_business_categories1_idx` (`business_categories_id`);

--
-- Indexes for table `bussiness_by_repair`
--
ALTER TABLE `bussiness_by_repair`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bussiness_by_repair_repair1_idx` (`repair_id`),
  ADD KEY `fk_bussiness_by_repair_business1_idx` (`business_id`);

--
-- Indexes for table `caja`
--
ALTER TABLE `caja`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caja_caja_terminal_gestion1_idx` (`caja_terminal_gestion_id`);

--
-- Indexes for table `caja_catalogo_billete`
--
ALTER TABLE `caja_catalogo_billete`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caja_catalogo_billete_caja_tipo_billete1_idx` (`caja_tipo_billete_id`),
  ADD KEY `fk_caja_catalogo_billete_caja_catalogo_tipo_fraccion1_idx` (`caja_catalogo_tipo_fraccion_id`);

--
-- Indexes for table `caja_catalogo_tipo_fraccion`
--
ALTER TABLE `caja_catalogo_tipo_fraccion`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caja_has_entidad`
--
ALTER TABLE `caja_has_entidad`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caja_has_entidad_business1_idx` (`business_id`),
  ADD KEY `fk_caja_has_entidad_caja1_idx` (`caja_id`);

--
-- Indexes for table `caja_tipo_billete`
--
ALTER TABLE `caja_tipo_billete`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `capacitaciones`
--
ALTER TABLE `capacitaciones`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_capacitaciones_capacitaciones_tipo1_idx` (`capacitaciones_tipo_id`);

--
-- Indexes for table `capacitaciones_tipo`
--
ALTER TABLE `capacitaciones_tipo`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash`
--
ALTER TABLE `cash`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `cash_by_movement`
--
ALTER TABLE `cash_by_movement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_by_movement_cash1_idx` (`cash_id`),
  ADD KEY `fk_cash_by_movement_cash_reason1_idx` (`cash_reason_id`),
  ADD KEY `fk_cash_by_movement_accounting_account_idx` (`accounting_account_id`);

--
-- Indexes for table `cash_by_transaction_management`
--
ALTER TABLE `cash_by_transaction_management`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_by_transaction_management_types_payments1_idx` (`types_payments_id`),
  ADD KEY `fk_cash_by_transaction_management_business_by_cash1_idx` (`business_by_cash_id`),
  ADD KEY `fk_cash_by_transaction_management_entidad_data1_idx` (`entidad_data_id`);

--
-- Indexes for table `cash_by_user`
--
ALTER TABLE `cash_by_user`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_by_user_business_by_cash1_idx` (`business_by_cash_id`);

--
-- Indexes for table `cash_movement_by_accounting_seat`
--
ALTER TABLE `cash_movement_by_accounting_seat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_movement_by_accounting_seat_cash_by_movement1_idx` (`cash_by_movement_id`),
  ADD KEY `fk_cash_movement_by_accounting_seat_daily_book_seat1_idx` (`daily_book_seat_id`);

--
-- Indexes for table `cash_reason`
--
ALTER TABLE `cash_reason`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cities_provinces1_idx` (`province_id`);

--
-- Indexes for table `clinical_by_history_clinic`
--
ALTER TABLE `clinical_by_history_clinic`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clinical_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  ADD KEY `fk_clinical_by_history_clinic_clinical_exam1_idx` (`clinical_exam_id`);

--
-- Indexes for table `clinical_exam`
--
ALTER TABLE `clinical_exam`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counter_by_entity`
--
ALTER TABLE `counter_by_entity`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_counter_by_schedule_entity_business_by_counter1_idx` (`business_by_counter_id`);

--
-- Indexes for table `counter_by_log_user_to_business`
--
ALTER TABLE `counter_by_log_user_to_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_counter_by_log_user_business1_idx` (`business_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_course_faculty1_idx` (`course_faculty_id`),
  ADD KEY `fk_course_course_subject_matter1_idx` (`course_subject_matter_id`);

--
-- Indexes for table `course_faculty`
--
ALTER TABLE `course_faculty`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_subject_matter`
--
ALTER TABLE `course_subject_matter`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_people1_idx` (`people_id`),
  ADD KEY `fk_customer_people_type_identification1_idx` (`people_type_identification_id`),
  ADD KEY `fk_customer_ruc_type1_idx` (`ruc_type_id`);

--
-- Indexes for table `customer_by_contacts`
--
ALTER TABLE `customer_by_contacts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_by_contacts1_idx` (`customer_id`);

--
-- Indexes for table `customer_by_information`
--
ALTER TABLE `customer_by_information`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_by_information_customer1_idx` (`customer_id`),
  ADD KEY `fk_customer_by_information_people_nationality1_idx` (`people_nationality_id`),
  ADD KEY `fk_customer_by_information_people_profession1_idx` (`people_profession_id`);

--
-- Indexes for table `customer_by_profile`
--
ALTER TABLE `customer_by_profile`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_by_profile_customer1_idx` (`customer_id`);

--
-- Indexes for table `customer_by_student`
--
ALTER TABLE `customer_by_student`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_by_student_customer1_idx` (`customer_id`);

--
-- Indexes for table `customer_profile_by_location`
--
ALTER TABLE `customer_profile_by_location`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_by_location_zones1_idx` (`zones_id`),
  ADD KEY `fk_users_by_location_customer_by_profile1_idx` (`customer_by_profile_id`);

--
-- Indexes for table `daily_book_seat`
--
ALTER TABLE `daily_book_seat`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_by_business_manager`
--
ALTER TABLE `delivery_by_business_manager`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dental_piece`
--
ALTER TABLE `dental_piece`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dental_piece_by_odontogram`
--
ALTER TABLE `dental_piece_by_odontogram`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dental_piece_by_odontogram_dental_piece1_idx` (`dental_piece_id`),
  ADD KEY `fk_dental_piece_by_odontogram_reference_piece_position1_idx` (`reference_piece_position_id`),
  ADD KEY `fk_dental_piece_by_odontogram_reference_piece1_idx` (`reference_piece_id`),
  ADD KEY `fk_dental_piece_by_odontogram_odontogram_by_patient1_idx` (`odontogram_by_patient_id`);

--
-- Indexes for table `diary_book`
--
ALTER TABLE `diary_book`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diary_book_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `dictionary_by_words`
--
ALTER TABLE `dictionary_by_words`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diccionary_by_words_diccionary_language1_idx` (`diccionary_language_id`);

--
-- Indexes for table `dictionary_language`
--
ALTER TABLE `dictionary_language`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dictionary_from_language_id` (`from_language_id`),
  ADD KEY `fk_dictionary_to_language_id` (`to_language_id`);

--
-- Indexes for table `dictionary_words_by_audio`
--
ALTER TABLE `dictionary_words_by_audio`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dictionary_by_photo_dictionary_by_words1_idx` (`dictionary_by_words_id`);

--
-- Indexes for table `dictionary_words_by_examples`
--
ALTER TABLE `dictionary_words_by_examples`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dictionary_words_by_examples_dictionary_by_words1_idx` (`dictionary_by_words_id`);

--
-- Indexes for table `dictionary_words_by_photo`
--
ALTER TABLE `dictionary_words_by_photo`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dictionary_by_photo_dictionary_by_words1_idx` (`dictionary_by_words_id`);

--
-- Indexes for table `discount_by_customers`
--
ALTER TABLE `discount_by_customers`
    ADD PRIMARY KEY (`business_by_discount_id`, `customer_id`),
  ADD KEY `fk_discount_by_customers_customer1_idx` (`customer_id`);

--
-- Indexes for table `discount_by_products`
--
ALTER TABLE `discount_by_products`
    ADD PRIMARY KEY (`business_by_discount_id`, `product_id`),
  ADD KEY `fk_discount_by_products_product1_idx` (`product_id`);

--
-- Indexes for table `educational_institution_askwer_type`
--
ALTER TABLE `educational_institution_askwer_type`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_askwer_type_business1_idx` (`business_id`);

--
-- Indexes for table `educational_institution_by_business`
--
ALTER TABLE `educational_institution_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_by_askwer_educational_institutio_idx` (`educational_institution_askwer_type_id`),
  ADD KEY `fk_educational_institution_by_askwer_business1_idx` (`business_id`),
  ADD KEY `fk_educational_institution_by_business_askwer_form1_idx` (`askwer_form_id`);

--
-- Indexes for table `educational_institution_by_course`
--
ALTER TABLE `educational_institution_by_course`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_by_course_course1_idx` (`course_id`);

--
-- Indexes for table `educational_institution_course_activities_by_askwer`
--
ALTER TABLE `educational_institution_course_activities_by_askwer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_course_activities_by_askwer_educ_idx` (`educational_institution_by_business_id`),
  ADD KEY `fk_educational_institution_course_activities_by_askwer_educ_idx1` (`educational_institution_course_by_activities_id`);

--
-- Indexes for table `educational_institution_course_by_activities`
--
ALTER TABLE `educational_institution_course_by_activities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_course_by_activities_educational_idx` (`educational_institution_course_by_supervisor_id`);

--
-- Indexes for table `educational_institution_course_by_students`
--
ALTER TABLE `educational_institution_course_by_students`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_course_by_students_educational_i_idx` (`educational_institution_by_course_id`),
  ADD KEY `fk_educational_institution_course_by_students_students_info_idx` (`students_information_id`);

--
-- Indexes for table `educational_institution_course_by_supervisor`
--
ALTER TABLE `educational_institution_course_by_supervisor`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_course_by_supervisor_business_by_idx` (`business_by_employee_profile_id`),
  ADD KEY `fk_educational_institution_course_by_supervisor_educational_idx` (`educational_institution_by_course_id`);

--
-- Indexes for table `educational_institution_students_course_by_activities`
--
ALTER TABLE `educational_institution_students_course_by_activities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_student_course_by_activities_edu_idx` (`educational_institution_course_by_activities_id`),
  ADD KEY `fk_educational_institution_student_course_by_activities_edu_idx1` (`educational_institution_course_by_students_id`);

--
-- Indexes for table `educational_institution_test_by_answers`
--
ALTER TABLE `educational_institution_test_by_answers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educational_institution_test_by_answers_askwer_entity_an_idx` (`askwer_entity_answer_id`),
  ADD KEY `fk_educational_institution_test_by_answers_educational_inst_idx` (`educational_institution_students_course_by_activities_id`);

--
-- Indexes for table `entity_authorization_configuration`
--
ALTER TABLE `entity_authorization_configuration`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_authorization_configuration1_idx` (`entity_data_id`);

--
-- Indexes for table `entity_has_invoice_sale`
--
ALTER TABLE `entity_has_invoice_sale`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entidad_has_factura_venta_factura_venta1_idx` (`factura_venta_id`),
  ADD KEY `fk_entidad_has_factura_venta_entidad_data1_idx` (`entidad_data_id`);

--
-- Indexes for table `entity_plans`
--
ALTER TABLE `entity_plans`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entity_position_fiscal`
--
ALTER TABLE `entity_position_fiscal`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entity_resources`
--
ALTER TABLE `entity_resources`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_resources1_idx` (`business_id`);

--
-- Indexes for table `events_trails_by_kit`
--
ALTER TABLE `events_trails_by_kit`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_by_clothing_kit_events_trails_project1_idx` (`events_trails_project_id`);

--
-- Indexes for table `events_trails_by_registration_points`
--
ALTER TABLE `events_trails_by_registration_points`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_by_registration_points_events_trails_regis_idx` (`events_trails_registration_by_customer_id`),
  ADD KEY `fk_events_trails_by_registration_points_events_trails_regis_idx1` (`events_trails_registration_points_id`);

--
-- Indexes for table `events_trails_distances`
--
ALTER TABLE `events_trails_distances`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_distances_events_trails_project1_idx` (`events_trails_project_id`),
  ADD KEY `fk_events_trails_distances_events_trails_type_teams1_idx` (`events_trails_type_teams_id`);

--
-- Indexes for table `events_trails_kit_pieces`
--
ALTER TABLE `events_trails_kit_pieces`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_kit_pieces_events_trails_project1_idx` (`events_trails_project_id`);

--
-- Indexes for table `events_trails_project`
--
ALTER TABLE `events_trails_project`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_project_business1_idx` (`business_id`),
  ADD KEY `fk_events_trails_project_events_trails_types1_idx` (`events_trails_types_id`);

--
-- Indexes for table `events_trails_project_by_routes_map`
--
ALTER TABLE `events_trails_project_by_routes_map`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_by_routes_map_routes_map1_idx` (`routes_map_id`),
  ADD KEY `fk_events_trails_project_by_routes_map_events_trails_projec_idx` (`events_trails_project_id`);

--
-- Indexes for table `events_trails_registration_by_customer`
--
ALTER TABLE `events_trails_registration_by_customer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_registration_by_customer_events_trails_pro_idx` (`events_trails_project_id`),
  ADD KEY `fk_events_trails_registration_by_customer_events_trails_typ_idx` (`events_trails_type_of_categories_id`),
  ADD KEY `fk_events_trails_registration_by_customer_events_trails_dis_idx` (`events_trails_distances_id`);

--
-- Indexes for table `events_trails_registration_payments_by_business`
--
ALTER TABLE `events_trails_registration_payments_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_registration_by_business_events_trails_reg_idx` (`events_trails_registration_points_id`),
  ADD KEY `fk_events_trails_registration_by_business_order_shopping_ca_idx` (`order_shopping_cart_id`);

--
-- Indexes for table `events_trails_registration_points`
--
ALTER TABLE `events_trails_registration_points`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_registration_points_events_trails_project1_idx` (`events_trails_project_id`);

--
-- Indexes for table `events_trails_types`
--
ALTER TABLE `events_trails_types`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_trails_type_of_categories`
--
ALTER TABLE `events_trails_type_of_categories`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_type_of_categories_events_trails_project1_idx` (`events_trails_project_id`);

--
-- Indexes for table `events_trails_type_teams`
--
ALTER TABLE `events_trails_type_teams`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_trails_type_teams_events_trails_project1_idx` (`events_trails_project_id`);

--
-- Indexes for table `event_by_assistance`
--
ALTER TABLE `event_by_assistance`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_by_assistance1_idx` (`customer_id`);

--
-- Indexes for table `formacion_academica`
--
ALTER TABLE `formacion_academica`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_formacion_academica_universidad_titulos1_idx` (`universidad_titulos_id`);

--
-- Indexes for table `gamification`
--
ALTER TABLE `gamification`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamification_by_allies`
--
ALTER TABLE `gamification_by_allies`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_allies_business1_idx` (`business_id`),
  ADD KEY `fk_gamification_by_allies_gamification1_idx` (`gamification_id`);

--
-- Indexes for table `gamification_by_badges`
--
ALTER TABLE `gamification_by_badges`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_badges_gamification1_idx` (`gamification_id`);

--
-- Indexes for table `gamification_by_levels`
--
ALTER TABLE `gamification_by_levels`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_levels_gamification1_idx` (`gamification_id`);

--
-- Indexes for table `gamification_by_points`
--
ALTER TABLE `gamification_by_points`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_points_gamification_by_process1_idx` (`gamification_by_process_id`);

--
-- Indexes for table `gamification_by_process`
--
ALTER TABLE `gamification_by_process`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_process_gamification1_idx` (`gamification_id`),
  ADD KEY `fk_gamification_by_process_gamification_type_activity1_idx` (`gamification_type_activity_id`);

--
-- Indexes for table `gamification_by_rewards`
--
ALTER TABLE `gamification_by_rewards`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gamification_by_rewards_gamification1_idx` (`gamification_id`);

--
-- Indexes for table `gamification_type_activity`
--
ALTER TABLE `gamification_type_activity`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gaminification_by_log_customers`
--
ALTER TABLE `gaminification_by_log_customers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gaminification_by_log_customers_account_gamification_by__idx` (`account_gamification_by_movement_id`);

--
-- Indexes for table `habits`
--
ALTER TABLE `habits`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habits_by_history_clinic`
--
ALTER TABLE `habits_by_history_clinic`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_habits_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  ADD KEY `fk_habits_by_history_clinic_habits1_idx` (`habits_id`);

--
-- Indexes for table `help_desk_header`
--
ALTER TABLE `help_desk_header`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_header_human_resources_employee_profile1_idx` (`help_desk_human_resources_employee_profile_id`),
  ADD KEY `fk_project_header_human_resources_employee_profile2_idx` (`administrator_human_resources_employee_profile_id`),
  ADD KEY `fk_help_desk_header_human_resources_department1_idx` (`human_resources_department_id`),
  ADD KEY `fk_help_desk_header_help_desk_types1_idx` (`help_desk_types_id`);

--
-- Indexes for table `help_desk_header_by_resources`
--
ALTER TABLE `help_desk_header_by_resources`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_help_desk_header_by_resources_help_desk_header1_idx` (`help_desk_header_id`);

--
-- Indexes for table `help_desk_types`
--
ALTER TABLE `help_desk_types`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_clinic`
--
ALTER TABLE `history_clinic`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `human_resources_department`
--
ALTER TABLE `human_resources_department`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_department_business1_idx` (`business_id`);

--
-- Indexes for table `human_resources_department_by_manager`
--
ALTER TABLE `human_resources_department_by_manager`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_department_by_manager_human_resources_de_idx` (`human_resources_department_id`),
  ADD KEY `fk_human_resources_department_by_manager_human_resources_em_idx` (`human_resources_employee_profile_id`);

--
-- Indexes for table `human_resources_department_by_organizational_chart_area`
--
ALTER TABLE `human_resources_department_by_organizational_chart_area`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_department_by_organizational_chart_area__idx` (`human_resources_department_id`),
  ADD KEY `fk_human_resources_department_by_organizational_chart_area__idx1` (`human_resources_organizational_chart_area_id`);

--
-- Indexes for table `human_resources_department_by_rest_day`
--
ALTER TABLE `human_resources_department_by_rest_day`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_department_by_rest_day_human_resources_d_idx` (`human_resources_department_id`);

--
-- Indexes for table `human_resources_employee_permission_by_details`
--
ALTER TABLE `human_resources_employee_permission_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_employee_profile_by_log_rest_day_human_r_idx1` (`human_resources_permission_type_id`),
  ADD KEY `fk_human_resources_employee_permission_by_details_human_res_idx` (`human_resources_employee_profile_by_permission_id`);

--
-- Indexes for table `human_resources_employee_profile`
--
ALTER TABLE `human_resources_employee_profile`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_employee_profile_people1_idx` (`people_id`),
  ADD KEY `fk_human_resources_employee_profile_people_type_identificat_idx` (`people_type_identification_id`),
  ADD KEY `fk_human_resources_employee_profile_people_nationality1_idx` (`people_nationality_id`),
  ADD KEY `fk_human_resources_employee_profile_people_profession1_idx` (`people_profession_id`),
  ADD KEY `fk_human_resources_employee_profile_business1_idx` (`business_id`),
  ADD KEY `fk_human_resources_employee_profile_human_resources_departm_idx` (`human_resources_department_id`),
  ADD KEY `fk_human_resources_employee_profile_human_resources_organiz_idx` (`human_resources_organizational_chart_area_id`),
  ADD KEY `fk_human_resources_employee_profile_human_resources_shedule_idx` (`human_resources_schedule_type_id`);

--
-- Indexes for table `human_resources_employee_profile_by_log_area`
--
ALTER TABLE `human_resources_employee_profile_by_log_area`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_employee_profile_by_log_area_human_resou_idx` (`human_resources_organizational_chart_area_id`),
  ADD KEY `fk_human_resources_employee_profile_by_log_area_human_resou_idx1` (`human_resources_employee_profile_id`);

--
-- Indexes for table `human_resources_employee_profile_by_permission`
--
ALTER TABLE `human_resources_employee_profile_by_permission`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_employee_profile_by_permission_human_res_idx` (`human_resources_permission_type_id`),
  ADD KEY `fk_human_resources_employee_profile_by_permission_human_res_idx1` (`human_resources_employee_profile_id`);

--
-- Indexes for table `human_resources_organizational_chart_area`
--
ALTER TABLE `human_resources_organizational_chart_area`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `human_resources_organizational_chart_area_by_manager`
--
ALTER TABLE `human_resources_organizational_chart_area_by_manager`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_organizational_chart_area_by_manager_hum_idx` (`human_resources_employee_profile_id`),
  ADD KEY `fk_human_resources_organizational_chart_area_by_manager_hum_idx1` (`human_resources_organizational_chart_area_id`);

--
-- Indexes for table `human_resources_permission_type`
--
ALTER TABLE `human_resources_permission_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `human_resources_schedule_type`
--
ALTER TABLE `human_resources_schedule_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `human_resources_schedule_type_by_shift`
--
ALTER TABLE `human_resources_schedule_type_by_shift`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_human_resources_shift_idx` (`human_resources_shift_id`),
  ADD KEY `fk_human_resources_schedule_type_idx1` (`human_resources_schedule_type_id`);

--
-- Indexes for table `human_resources_shift`
--
ALTER TABLE `human_resources_shift`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_address`
--
ALTER TABLE `information_address`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_information_address_information_address_type1_idx` (`information_address_type_id`);

--
-- Indexes for table `information_address_by_multimedia`
--
ALTER TABLE `information_address_by_multimedia`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounting_account_accounting_level1_idx` (`information_address_id`);

--
-- Indexes for table `information_address_type`
--
ALTER TABLE `information_address_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_mail`
--
ALTER TABLE `information_mail`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_information_mail_information_mail_type1_idx` (`information_mail_type_id`);

--
-- Indexes for table `information_mail_type`
--
ALTER TABLE `information_mail_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_phone`
--
ALTER TABLE `information_phone`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_information_phone_information_phone_operator1_idx` (`information_phone_operator_id`),
  ADD KEY `fk_information_phone_information_phone_type1_idx` (`information_phone_type_id`);

--
-- Indexes for table `information_phone_operator`
--
ALTER TABLE `information_phone_operator`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_phone_type`
--
ALTER TABLE `information_phone_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_social_network`
--
ALTER TABLE `information_social_network`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_information_social_network_information_social_network_ty_idx` (`information_social_network_type_id`);

--
-- Indexes for table `information_social_network_type`
--
ALTER TABLE `information_social_network_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initial_status_product`
--
ALTER TABLE `initial_status_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_initial_status_product_product1_idx` (`product_id`),
  ADD KEY `fk_initial_status_product_business1_idx` (`business_id`);

--
-- Indexes for table `invoice_buy`
--
ALTER TABLE `invoice_buy`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_voucher_type1_idx` (`voucher_type_id`);

--
-- Indexes for table `invoice_buy_by_book_seat`
--
ALTER TABLE `invoice_buy_by_book_seat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_book_seat_invoice_buy1_idx` (`invoice_buy_id`),
  ADD KEY `fk_invoice_buy_by_book_seat_diary_book1_idx` (`diary_book_id`);

--
-- Indexes for table `invoice_buy_by_breakdown_payment`
--
ALTER TABLE `invoice_buy_by_breakdown_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_breakdown_payment_invoice_buy_by_indebted_idx` (`invoice_buy_by_indebtedness_paying_init_id`);

--
-- Indexes for table `invoice_buy_by_details`
--
ALTER TABLE `invoice_buy_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_details_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_buy_by_details_devolution`
--
ALTER TABLE `invoice_buy_by_details_devolution`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_details_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_buy_by_devolution_product`
--
ALTER TABLE `invoice_buy_by_devolution_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_product_defect1_idx` (`product_defect_id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_invoice_buy_by_details_idx` (`invoice_buy_by_details_devolution_id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_types_payments1_idx` (`types_payments_id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `invoice_buy_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_buy_by_indebtedness_paying_init`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_indebtedness_paying_init_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_buy_by_overridden`
--
ALTER TABLE `invoice_buy_by_overridden`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_overridden_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_buy_by_payment`
--
ALTER TABLE `invoice_buy_by_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  ADD KEY `fk_invoice_buy_by_payment_invoice_buy_by_breakdown_payment1_idx` (`invoice_buy_by_breakdown_payment_id`),
  ADD KEY `fk_invoice_buy_by_payment_invoice_buy_by_indebtedness_payin_idx` (`invoice_buy_by_indebtedness_paying_init_id`);

--
-- Indexes for table `invoice_buy_by_pendient`
--
ALTER TABLE `invoice_buy_by_pendient`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_pendient_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_buy_by_retention`
--
ALTER TABLE `invoice_buy_by_retention`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_retention_invoice_buy1_idx` (`invoice_buy_id`),
  ADD KEY `fk_invoice_buy_by_retention_retention_tax_sub_type1_idx` (`retention_tax_sub_type_id`);

--
-- Indexes for table `invoice_buy_by_transactional_annex`
--
ALTER TABLE `invoice_buy_by_transactional_annex`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_transactional_annex_invoice_buy1_idx` (`invoice_buy_id`),
  ADD KEY `fk_invoice_buy_by_transactional_annex_management_livelihood_idx` (`management_livelihood_by_voucher_id`);

--
-- Indexes for table `invoice_buy_by_transactions`
--
ALTER TABLE `invoice_buy_by_transactions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_factura_buy_by_transactions_accounting_account1_idx` (`accounting_account_id`),
  ADD KEY `fk_invoice_buy_by_transactions_invoice_buy1_idx` (`invoice_buy_id`);

--
-- Indexes for table `invoice_sale`
--
ALTER TABLE `invoice_sale`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_voucher_type1_idx` (`voucher_type_id`);

--
-- Indexes for table `invoice_sale_by_book_seat`
--
ALTER TABLE `invoice_sale_by_book_seat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_book_seat_invoice_sale1_idx` (`invoice_sale_id`),
  ADD KEY `fk_invoice_sale_by_book_seat_daily_book_seat1_idx` (`daily_book_seat_id`);

--
-- Indexes for table `invoice_sale_by_breakdown_payment`
--
ALTER TABLE `invoice_sale_by_breakdown_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_breakdown_payment_invoice_sale_by_indebt_idx` (`invoice_sale_by_indebtedness_paying_init_id`);

--
-- Indexes for table `invoice_sale_by_details`
--
ALTER TABLE `invoice_sale_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_details_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_details_devolution`
--
ALTER TABLE `invoice_sale_by_details_devolution`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_details_devolution_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_devolution_product`
--
ALTER TABLE `invoice_sale_by_devolution_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_product_defect1_idx` (`product_defect_id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_types_payments1_idx` (`types_payments_id`),
  ADD KEY `fk_invoice_buy_by_devolution_product_accounting_account1_idx` (`accounting_account_id`),
  ADD KEY `fk_invoice_sale_by_devolution_product_invoice_sale_by_detai_idx` (`invoice_sale_by_details_devolution_id`);

--
-- Indexes for table `invoice_sale_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_sale_by_indebtedness_paying_init`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_indebtedness_paying_init_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_overridden`
--
ALTER TABLE `invoice_sale_by_overridden`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_overridden_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_payment`
--
ALTER TABLE `invoice_sale_by_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  ADD KEY `fk_invoice_sale_by_payment_invoice_sale_by_breakdown_paymen_idx` (`invoice_sale_by_breakdown_payment_id`),
  ADD KEY `fk_invoice_sale_by_payment_invoice_sale_by_indebtedness_pay_idx` (`invoice_sale_by_indebtedness_paying_init_id`);

--
-- Indexes for table `invoice_sale_by_pendient`
--
ALTER TABLE `invoice_sale_by_pendient`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_sale_by_pendient_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_retention`
--
ALTER TABLE `invoice_sale_by_retention`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_retention_retention_tax_sub_type1_idx` (`retention_tax_sub_type_id`),
  ADD KEY `fk_invoice_sale_by_retention_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_transactional_annex`
--
ALTER TABLE `invoice_sale_by_transactional_annex`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_transactional_annex_management_livelihood_idx` (`management_livelihood_by_voucher_id`),
  ADD KEY `fk_invoice_sale_by_transactional_annex_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `invoice_sale_by_transactions`
--
ALTER TABLE `invoice_sale_by_transactions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_factura_buy_by_transactions_accounting_account1_idx` (`accounting_account_id`),
  ADD KEY `fk_invoice_sale_by_transactions_invoice_sale1_idx` (`invoice_sale_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_course`
--
ALTER TABLE `language_course`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_dictionary_language1_idx` (`dictionary_language_id`);

--
-- Indexes for table `language_course_by_photo`
--
ALTER TABLE `language_course_by_photo`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_by_photo_language_course1_idx` (`language_course_id`);

--
-- Indexes for table `language_course_by_section`
--
ALTER TABLE `language_course_by_section`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_by_section_language_course1_idx` (`language_course_id`);

--
-- Indexes for table `language_course_section_by_dictionary_words`
--
ALTER TABLE `language_course_section_by_dictionary_words`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_dictionary_words_language_cou_idx` (`language_course_by_section_id`),
  ADD KEY `fk_language_course_section_by_dictionary_words_dictionary_b_idx` (`dictionary_by_words_id`);

--
-- Indexes for table `language_course_section_by_logo`
--
ALTER TABLE `language_course_section_by_logo`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_logo_language_course_by_secti_idx` (`language_course_by_section_id`);

--
-- Indexes for table `language_course_section_by_photo`
--
ALTER TABLE `language_course_section_by_photo`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_photo_language_course_by_sect_idx` (`language_course_by_section_id`);

--
-- Indexes for table `language_course_section_by_rows`
--
ALTER TABLE `language_course_section_by_rows`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_rows_language_course_by_secti_idx` (`language_course_by_section_id`);

--
-- Indexes for table `language_course_section_by_sticky_note`
--
ALTER TABLE `language_course_section_by_sticky_note`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_sticky_note_language_course_b_idx` (`language_course_by_section_id`);

--
-- Indexes for table `language_course_section_rows_by_columns`
--
ALTER TABLE `language_course_section_rows_by_columns`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_course_section_by_cols_language_course_section__idx` (`language_course_section_by_rows_id`),
  ADD KEY `fk_language_course_section_rows_by_columns_dictionary_by_wo_idx` (`dictionary_by_words_id`);

--
-- Indexes for table `language_product`
--
ALTER TABLE `language_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_product1_idx` (`product_id`);

--
-- Indexes for table `language_product_category`
--
ALTER TABLE `language_product_category`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_category_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_category_product_category1_idx` (`product_category_id`);

--
-- Indexes for table `language_product_color`
--
ALTER TABLE `language_product_color`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_trademark_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_color_product_color1_idx` (`product_color_id`);

--
-- Indexes for table `language_product_measure_type`
--
ALTER TABLE `language_product_measure_type`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_measure_type_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_measure_type_product_measure_type1_idx` (`product_measure_type_id`);

--
-- Indexes for table `language_product_subcategory`
--
ALTER TABLE `language_product_subcategory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_category_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_subcategory_product_subcategory1_idx` (`product_subcategory_id`);

--
-- Indexes for table `language_product_trademark`
--
ALTER TABLE `language_product_trademark`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_product_trademark_language1_idx` (`language_id`),
  ADD KEY `fk_language_product_trademark_product_trademark1_idx` (`product_trademark_id`);

--
-- Indexes for table `language_template_about_us`
--
ALTER TABLE `language_template_about_us`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_about_us_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_about_us_template_about_us1_idx` (`template_about_us_id`);

--
-- Indexes for table `language_template_about_us_by_data`
--
ALTER TABLE `language_template_about_us_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_about_us_by_data_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_about_us_by_data_template_about_us_by__idx` (`template_about_us_by_data_id`);

--
-- Indexes for table `language_template_policies`
--
ALTER TABLE `language_template_policies`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_services_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_policies_template_policies1_idx` (`template_policies_id`);

--
-- Indexes for table `language_template_services`
--
ALTER TABLE `language_template_services`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_services_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_services_template_services1_idx` (`template_services_id`);

--
-- Indexes for table `language_template_services_by_data`
--
ALTER TABLE `language_template_services_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_services_by_data_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_services_by_data_template_services_by__idx` (`template_services_by_data_id`);

--
-- Indexes for table `language_template_slider_by_images`
--
ALTER TABLE `language_template_slider_by_images`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_language_template_services_language1_idx` (`language_id`),
  ADD KEY `fk_language_template_slider_by_images_template_slider_by_im_idx` (`template_slider_by_images_id`);

--
-- Indexes for table `lodging`
--
ALTER TABLE `lodging`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lodging_arrived_by_social_networks`
--
ALTER TABLE `lodging_arrived_by_social_networks`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_arrived_by_social_networks_lodging_by_arrived1_idx` (`lodging_by_arrived_id`);

--
-- Indexes for table `lodging_by_arrived`
--
ALTER TABLE `lodging_by_arrived`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_by_contact_lodging1_idx` (`lodging_id`);

--
-- Indexes for table `lodging_by_customer`
--
ALTER TABLE `lodging_by_customer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_loding_by_customer_lodging1_idx` (`lodging_id`),
  ADD KEY `fk_lodging_by_customer_customer1_idx` (`customer_id`);

--
-- Indexes for table `lodging_by_customer_location`
--
ALTER TABLE `lodging_by_customer_location`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_loding_by_customer_location_lodging_by_customer1_idx` (`lodging_by_customer_id`),
  ADD KEY `fk_lodging_by_customer_location_information_address1_idx` (`information_address_id`);

--
-- Indexes for table `lodging_by_payment`
--
ALTER TABLE `lodging_by_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_by_payment_lodging1_idx` (`lodging_id`);

--
-- Indexes for table `lodging_by_payment_credit_card`
--
ALTER TABLE `lodging_by_payment_credit_card`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_loding_by_payment_credit_card_lodging_by_payment1_idx` (`lodging_by_payment_id`);

--
-- Indexes for table `lodging_by_reasons`
--
ALTER TABLE `lodging_by_reasons`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_by_reasons_lodging1_idx` (`lodging_id`);

--
-- Indexes for table `lodging_by_type_of_room`
--
ALTER TABLE `lodging_by_type_of_room`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_by_type_of_room_lodging1_idx` (`lodging_id`),
  ADD KEY `fk_lodging_by_type_of_room_lodging_type_of_room_by_price1_idx` (`lodging_type_of_room_by_price_id`);

--
-- Indexes for table `lodging_customer_additional_information`
--
ALTER TABLE `lodging_customer_additional_information`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_customer_additional_information_lodging_by_custo_idx` (`lodging_by_customer_id`),
  ADD KEY `fk_lodging_customer_additional_information_information_mail_idx` (`information_mail_id`);

--
-- Indexes for table `lodging_room_features`
--
ALTER TABLE `lodging_room_features`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lodging_room_levels`
--
ALTER TABLE `lodging_room_levels`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lodging_type_of_room`
--
ALTER TABLE `lodging_type_of_room`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lodging_type_of_room_by_price`
--
ALTER TABLE `lodging_type_of_room_by_price`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lodging_type_of_room_by_price_lodging_type_of_room1_idx` (`lodging_type_of_room_id`),
  ADD KEY `fk_lodging_type_of_room_by_price_lodging_room_levels1_idx` (`lodging_room_levels_id`);

--
-- Indexes for table `lodging_type_of_room_price_by_features`
--
ALTER TABLE `lodging_type_of_room_price_by_features`
    ADD PRIMARY KEY (`lodging_type_of_room_by_price_id`, `lodging_room_features_id`),
  ADD KEY `fk_lodging_type_of_room_price_by_features_lodging_room_feat_idx` (`lodging_room_features_id`);

--
-- Indexes for table `log_by_issuance_bank`
--
ALTER TABLE `log_by_issuance_bank`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_by_issuance_cash`
--
ALTER TABLE `log_by_issuance_cash`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailing_by_data_send`
--
ALTER TABLE `mailing_by_data_send`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mailing_by_data_send_customer1_idx` (`customer_id`),
  ADD KEY `fk_mailing_by_data_sendmai_mailing_template1_idx` (`mailing_template_id`);

--
-- Indexes for table `mailing_template`
--
ALTER TABLE `mailing_template`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mailing_template_business1_idx` (`business_id`);

--
-- Indexes for table `management_livelihood_by_voucher`
--
ALTER TABLE `management_livelihood_by_voucher`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_management_livelihood_by_voucher_tax_support1_idx` (`tax_support_id`),
  ADD KEY `fk_management_livelihood_by_voucher_voucher_type1_idx` (`voucher_type_id`),
  ADD KEY `fk_management_livelihood_by_voucher_people_type_identificat_idx` (`people_type_identification_id`);

--
-- Indexes for table `medical_consultation_by_patient`
--
ALTER TABLE `medical_consultation_by_patient`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medical_consultation_by_patient_history_clinic1_idx` (`history_clinic_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mikrotik_by_customer_engagement`
--
ALTER TABLE `mikrotik_by_customer_engagement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mikrotik_by_customer_engagement_customer1_idx` (`customer_id`),
  ADD KEY `fk_mikrotik_by_customer_engagement_invoice_sale1_idx` (`invoice_sale_id`),
  ADD KEY `fk_mikrotik_by_customer_engagement_mikrotik_rate_limit1_idx` (`mikrotik_rate_limit_id`),
  ADD KEY `fk_mikrotik_by_customer_engagement_mikrotik_dhcp_server1_idx` (`mikrotik_dhcp_server_id`);

--
-- Indexes for table `mikrotik_dhcp_server`
--
ALTER TABLE `mikrotik_dhcp_server`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mikrotik_dhcp_server_mikrotik_type_conection1_idx` (`mikrotik_type_conection_id`);

--
-- Indexes for table `mikrotik_rate_limit`
--
ALTER TABLE `mikrotik_rate_limit`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mikrotik_type_conection`
--
ALTER TABLE `mikrotik_type_conection`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
    ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
    ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
    ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
    ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `odontogram_by_patient`
--
ALTER TABLE `odontogram_by_patient`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_odontogram_by_patient_history_clinic1_idx` (`history_clinic_id`);

--
-- Indexes for table `order_event_kits_by_customer`
--
ALTER TABLE `order_event_kits_by_customer`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_event_customer_events_trails_registration_by_custo_idx` (`events_trails_registration_by_customer_id`);

--
-- Indexes for table `order_payments_document`
--
ALTER TABLE `order_payments_document`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_payments_document_order_payments_manager1_idx` (`order_payments_manager_id`);

--
-- Indexes for table `order_payments_manager`
--
ALTER TABLE `order_payments_manager`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_shopping_by_customer_delivery`
--
ALTER TABLE `order_shopping_by_customer_delivery`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_shoping_by_customer_delivery_people1_idx` (`people_id`);

--
-- Indexes for table `order_shopping_by_delivery`
--
ALTER TABLE `order_shopping_by_delivery`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_shoping_by_customer_delivery_people1_idx` (`people_id`),
  ADD KEY `fk_order_shopping_by_delivery_order_shopping_cart1_idx` (`order_shopping_cart_id`);

--
-- Indexes for table `order_shopping_cart`
--
ALTER TABLE `order_shopping_cart`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_shopping_cart_order_payments_manager1_idx` (`order_payments_manager_id`),
  ADD KEY `fk_order_shopping_cart_order_shopping_by_customer_delivery1_idx` (`order_shopping_by_customer_delivery_id`);

--
-- Indexes for table `order_shopping_cart_by_details`
--
ALTER TABLE `order_shopping_cart_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_shopping_cart_by_details_order_shopping_cart1_idx` (`order_shopping_cart_id`);

--
-- Indexes for table `panorama`
--
ALTER TABLE `panorama`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panorama_points`
--
ALTER TABLE `panorama_points`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
    ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_gender`
--
ALTER TABLE `people_gender`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_nationality`
--
ALTER TABLE `people_nationality`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_profession`
--
ALTER TABLE `people_profession`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_relationship`
--
ALTER TABLE `people_relationship`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_type_identification`
--
ALTER TABLE `people_type_identification`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices_by_zones`
--
ALTER TABLE `prices_by_zones`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_price_by_zone_zones1_idx` (`zone_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_product_trademark1_idx` (`product_trademark_id`),
  ADD KEY `fk_product_product_category1_idx` (`product_category_id`),
  ADD KEY `fk_product_product_subcategory1_idx` (`product_subcategory_id`),
  ADD KEY `fk_product_product_measure_type1_idx` (`product_measure_type_id`);

--
-- Indexes for table `product_aplication`
--
ALTER TABLE `product_aplication`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_by_aplication`
--
ALTER TABLE `product_by_aplication`
    ADD PRIMARY KEY (`product_id`, `product_aplication_id`),
  ADD KEY `fk_product_by_aplication_product_aplication1_idx` (`product_aplication_id`);

--
-- Indexes for table `product_by_color`
--
ALTER TABLE `product_by_color`
    ADD PRIMARY KEY (`product_id`, `product_color_id`),
  ADD KEY `fk_product_by_color_product_color1_idx` (`product_color_id`);

--
-- Indexes for table `product_by_details`
--
ALTER TABLE `product_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_details_product1_idx` (`product_id`),
  ADD KEY `fk_product_by_details_tax1_idx` (`tax_id`);

--
-- Indexes for table `product_by_discount`
--
ALTER TABLE `product_by_discount`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_discount_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_ice`
--
ALTER TABLE `product_by_ice`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_ice_product1_idx` (`product_id`),
  ADD KEY `fk_product_by_ice_product_ice1_idx` (`product_ice_id`);

--
-- Indexes for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_log_inventory_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_meta_data_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_multimedia`
--
ALTER TABLE `product_by_multimedia`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_multimedia_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_package`
--
ALTER TABLE `product_by_package`
    ADD PRIMARY KEY (`product_parent_by_package_params_id`, `product_id`),
  ADD KEY `fk_product_by_package_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_route_map`
--
ALTER TABLE `product_by_route_map`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_route_product1_idx` (`product_id`),
  ADD KEY `fk_product_by_route_routes_map1_idx` (`routes_map_id`);

--
-- Indexes for table `product_by_sizes`
--
ALTER TABLE `product_by_sizes`
    ADD PRIMARY KEY (`product_sizes_id`, `product_id`),
  ADD KEY `fk_product_by_sizes_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_stock`
--
ALTER TABLE `product_by_stock`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_stock_product1_idx` (`product_id`);

--
-- Indexes for table `product_by_unity_inventory`
--
ALTER TABLE `product_by_unity_inventory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_unity_inventory_product_inventory1_idx` (`product_inventory_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_defect`
--
ALTER TABLE `product_defect`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_details_shipping_fee`
--
ALTER TABLE `product_details_shipping_fee`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_details_shipping_fee_product1_idx` (`product_id`);

--
-- Indexes for table `product_ice`
--
ALTER TABLE `product_ice`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_ice_product_ice_types1_idx` (`product_ice_types_id`);

--
-- Indexes for table `product_ice_types`
--
ALTER TABLE `product_ice_types`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inventory`
--
ALTER TABLE `product_inventory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_inventory_product1_idx` (`product_id`),
  ADD KEY `fk_product_inventory_tax1_idx` (`tax_id`);

--
-- Indexes for table `product_inventory_by_prices`
--
ALTER TABLE `product_inventory_by_prices`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_inventory_by_prices_product_inventory1_idx` (`product_inventory_id`);

--
-- Indexes for table `product_inventory_by_price_unity_box`
--
ALTER TABLE `product_inventory_by_price_unity_box`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_unity_inventory_product_inventory1_idx` (`product_inventory_id`);

--
-- Indexes for table `product_inventory_by_unity`
--
ALTER TABLE `product_inventory_by_unity`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_unity_inventory_product_inventory1_idx` (`product_inventory_id`);

--
-- Indexes for table `product_measure_type`
--
ALTER TABLE `product_measure_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_parent`
--
ALTER TABLE `product_parent`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_product_category1_idx` (`product_category_id`),
  ADD KEY `fk_product_product_subcategory1_idx` (`product_subcategory_id`),
  ADD KEY `fk_product_parent_product_measure_type1_idx` (`product_measure_type_id`),
  ADD KEY `fk_product_parent_tax1_idx` (`tax_id`);

--
-- Indexes for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_prices_product_parent1_idx` (`product_parent_id`),
  ADD KEY `fk_product_parent_by_package_params_product_parent_by_price_idx` (`product_parent_by_prices_id`);

--
-- Indexes for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_prices_product_parent1_idx` (`product_parent_id`);

--
-- Indexes for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_product_product_parent1_idx` (`product_parent_id`),
  ADD KEY `fk_product_parent_by_product_product1_idx` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_subcategory_product_category1_idx` (`product_category_id`);

--
-- Indexes for table `product_trademark`
--
ALTER TABLE `product_trademark`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_header`
--
ALTER TABLE `project_header`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_header_human_resources_employee_profile1_idx` (`help_desk_human_resources_employee_profile_id`),
  ADD KEY `fk_project_header_human_resources_employee_profile2_idx` (`administrator_human_resources_employee_profile_id`),
  ADD KEY `fk_project_header_countries1_idx` (`countries_id`);

--
-- Indexes for table `project_header_by_resources`
--
ALTER TABLE `project_header_by_resources`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_header_by_resources_project_header1_idx` (`project_header_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_provinces_countries_idx` (`country_id`);

--
-- Indexes for table `reference_piece`
--
ALTER TABLE `reference_piece`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_piece_position`
--
ALTER TABLE `reference_piece_position`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_piece_type`
--
ALTER TABLE `reference_piece_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repair_by_details_parts`
--
ALTER TABLE `repair_by_details_parts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_repair_by_details_parts_repair1_idx` (`repair_id`),
  ADD KEY `fk_repair_by_details_parts_product_color1_idx` (`product_color_id`),
  ADD KEY `fk_repair_by_details_parts_repair_product_by_business1_idx` (`repair_product_by_business_id`),
  ADD KEY `fk_repair_by_details_parts_product_trademark1_idx` (`product_trademark_id`);

--
-- Indexes for table `repair_product_by_business`
--
ALTER TABLE `repair_product_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_repair_product_by_business_business1_idx` (`business_id`);

--
-- Indexes for table `repair_product_by_color`
--
ALTER TABLE `repair_product_by_color`
    ADD PRIMARY KEY (`repair_by_details_parts_id`, `product_color_id`),
  ADD KEY `fk_repair_product_by_color_product_color1_idx` (`product_color_id`);

--
-- Indexes for table `retention_tax_sub_type`
--
ALTER TABLE `retention_tax_sub_type`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_retention_tax_sub_type_retention_tax_type1_idx` (`retention_tax_type_id`),
  ADD KEY `fk_retention_tax_sub_type_accounting_account1_idx` (`accounting_account_id`);

--
-- Indexes for table `retention_tax_type`
--
ALTER TABLE `retention_tax_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes_drawing`
--
ALTER TABLE `routes_drawing`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes_map`
--
ALTER TABLE `routes_map`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes_map_by_routes_drawing`
--
ALTER TABLE `routes_map_by_routes_drawing`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_routes_map_by_drawing_routes_map1_idx` (`routes_map_id`),
  ADD KEY `fk_routes_map_by_drawing_routes_drawing1_idx` (`routes_drawing_id`);

--
-- Indexes for table `route_map_by_adventure_types`
--
ALTER TABLE `route_map_by_adventure_types`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_route_by_adventure_types_business_by_routes_map1_idx` (`business_by_routes_map_id`);

--
-- Indexes for table `ruc_type`
--
ALTER TABLE `ruc_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_days_category`
--
ALTER TABLE `schedule_days_category`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduling_date`
--
ALTER TABLE `scheduling_date`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secretary_processes_by_customer_presentation`
--
ALTER TABLE `secretary_processes_by_customer_presentation`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_secretary_processes_by_customer_presentation_customer1_idx` (`customer_id`);

--
-- Indexes for table `shipping_rate_business`
--
ALTER TABLE `shipping_rate_business`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_rate_business_by_conversion_factor`
--
ALTER TABLE `shipping_rate_business_by_conversion_factor`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shipping_rate_by_conversion_factor_shipping_rate_service_idx` (`shipping_rate_services_id`),
  ADD KEY `fk_shipping_rate_by_conversion_factor_shipping_rate_kinds_o_idx` (`shipping_rate_kinds_of_way_id`),
  ADD KEY `fk_shipping_rate_by_conversion_factor_product_measure_type1_idx` (`product_measure_type_id`),
  ADD KEY `fk_shipping_rate_business_by_conversion_factor_shipping_rat_idx` (`shipping_rate_business_id`);

--
-- Indexes for table `shipping_rate_business_by_min_weight`
--
ALTER TABLE `shipping_rate_business_by_min_weight`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shipping_rate_business_by_min_weight_shipping_rate_busin_idx` (`shipping_rate_business_id`);

--
-- Indexes for table `shipping_rate_kinds_of_way`
--
ALTER TABLE `shipping_rate_kinds_of_way`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_rate_services`
--
ALTER TABLE `shipping_rate_services`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shipping_rate_services_shipping_rate_business1_idx` (`shipping_rate_business_id`);

--
-- Indexes for table `students_by_business`
--
ALTER TABLE `students_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_representative_by_business_business1_idx` (`business_id`),
  ADD KEY `fk_students_by_business_students_information1_idx` (`students_information_id`);

--
-- Indexes for table `students_by_representative`
--
ALTER TABLE `students_by_representative`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_by_representative_students_information1_idx` (`students_information_id`),
  ADD KEY `fk_students_by_representative_students_representative1_idx` (`students_representative_id`);

--
-- Indexes for table `students_course_activities_by_resource`
--
ALTER TABLE `students_course_activities_by_resource`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_course_activities_by_resource_educational_insti_idx` (`educational_institution_course_by_activities_id`);

--
-- Indexes for table `students_information`
--
ALTER TABLE `students_information`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_information_people1_idx` (`people_id`);

--
-- Indexes for table `students_representative`
--
ALTER TABLE `students_representative`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_representative_people1_idx` (`people_id`),
  ADD KEY `fk_students_representative_people_relationship1_idx` (`people_relationship_id`);

--
-- Indexes for table `students_representative_by_business`
--
ALTER TABLE `students_representative_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_representative_by_business_students_representat_idx` (`students_representative_id`),
  ADD KEY `fk_students_representative_by_business_business1_idx` (`business_id`);

--
-- Indexes for table `subtipo_medicion`
--
ALTER TABLE `subtipo_medicion`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtipo_medicion_has_equivalencias`
--
ALTER TABLE `subtipo_medicion_has_equivalencias`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subtipo_medicion_has_equivalencias_subtipo_medicion1_idx` (`subtipo_medicion_id`),
  ADD KEY `fk_subtipo_medicion_has_equivalencias_subtipo_medicion2_idx` (`subtipo_medicion_equivalencia_id`),
  ADD KEY `fk_tipo_medida_manager_idx` (`tipo_medida_manager_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes_by_cities`
--
ALTER TABLE `taxes_by_cities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_taxes_by_cities_cities1_idx` (`city_id`),
  ADD KEY `fk_taxes_by_cities_taxes1_idx` (`tax_id`);

--
-- Indexes for table `tax_by_business`
--
ALTER TABLE `tax_by_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tax_by_business_tax1_idx` (`tax_id`),
  ADD KEY `fk_tax_by_business_business1_idx` (`business_id`);

--
-- Indexes for table `tax_support`
--
ALTER TABLE `tax_support`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_about_us`
--
ALTER TABLE `template_about_us`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_about_us_by_data`
--
ALTER TABLE `template_about_us_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_about_us_by_data_template_about_us1_idx` (`template_about_us_id`);

--
-- Indexes for table `template_blog`
--
ALTER TABLE `template_blog`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_blog_by_comments`
--
ALTER TABLE `template_blog_by_comments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_blog_by_comments_template_blog1_idx` (`template_blog_id`);

--
-- Indexes for table `template_blog_by_counters`
--
ALTER TABLE `template_blog_by_counters`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_blog_by_counters_template_blog1_idx` (`template_blog_id`);

--
-- Indexes for table `template_blog_by_data`
--
ALTER TABLE `template_blog_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_blog_by_data_template_blog1_idx` (`template_blog_id`);

--
-- Indexes for table `template_by_products`
--
ALTER TABLE `template_by_products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_by_products_template_information1_idx` (`template_information_id`),
  ADD KEY `fk_template_by_products_product1_idx` (`product_id`);

--
-- Indexes for table `template_by_source`
--
ALTER TABLE `template_by_source`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_by_source_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_chat_api`
--
ALTER TABLE `template_chat_api`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_chat_api_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_config_mailing`
--
ALTER TABLE `template_config_mailing`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_config_mailing_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_config_mailing_by_emails`
--
ALTER TABLE `template_config_mailing_by_emails`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_config_mailing_by_emails_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_contact_us`
--
ALTER TABLE `template_contact_us`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_contact_us_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_contact_us_by_routes_map`
--
ALTER TABLE `template_contact_us_by_routes_map`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_by_routes_map_routes_map1_idx` (`routes_map_id`),
  ADD KEY `fk_template_contact_us_by_routes_map_template_contact_us1_idx` (`template_contact_us_id`);

--
-- Indexes for table `template_faq`
--
ALTER TABLE `template_faq`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_faq_by_data`
--
ALTER TABLE `template_faq_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_faq_by_data_template_faq1_idx` (`template_faq_id`);

--
-- Indexes for table `template_information`
--
ALTER TABLE `template_information`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_information_business1_idx` (`business_id`);

--
-- Indexes for table `template_language_customer`
--
ALTER TABLE `template_language_customer`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_multimedia_sections`
--
ALTER TABLE `template_multimedia_sections`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_news`
--
ALTER TABLE `template_news`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_news_by_data`
--
ALTER TABLE `template_news_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_news_by_data_template_news1` (`template_news_id`);

--
-- Indexes for table `template_our_team`
--
ALTER TABLE `template_our_team`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_our_team_by_data`
--
ALTER TABLE `template_our_team_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_our_team_by_data_template_our_team1_idx` (`template_our_team_id`),
  ADD KEY `fk_template_our_team_by_data_human_resources_employee_profi_idx` (`human_resources_employee_profile_id`);

--
-- Indexes for table `template_payments`
--
ALTER TABLE `template_payments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_payments_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_policies`
--
ALTER TABLE `template_policies`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_services`
--
ALTER TABLE `template_services`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_services_by_data`
--
ALTER TABLE `template_services_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_services_by_data_template_services1_idx` (`template_services_id`);

--
-- Indexes for table `template_slider`
--
ALTER TABLE `template_slider`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_slider_by_images`
--
ALTER TABLE `template_slider_by_images`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_by_images_template_slider1_idx` (`template_slider_id`);

--
-- Indexes for table `template_steps`
--
ALTER TABLE `template_steps`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_steps_by_data`
--
ALTER TABLE `template_steps_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_steps_by_data_template_steps1_idx` (`template_steps_id`);

--
-- Indexes for table `template_support`
--
ALTER TABLE `template_support`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_slider_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `template_support_by_data`
--
ALTER TABLE `template_support_by_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_support_by_data_template_support1_idx` (`template_support_id`);

--
-- Indexes for table `template_wish_list_by_user`
--
ALTER TABLE `template_wish_list_by_user`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_template_wish_list_by_user_template_information1_idx` (`template_information_id`);

--
-- Indexes for table `tipo_medida_has_subtipo`
--
ALTER TABLE `tipo_medida_has_subtipo`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo_medida_manager_id1_idx` (`tipo_medida_manager_id`),
  ADD KEY `fk_tipo_medida_has_subtipo_subtipo_medicion1_idx` (`subtipo_medicion_id`);

--
-- Indexes for table `tipo_medida_manager`
--
ALTER TABLE `tipo_medida_manager`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_tipo_medida_id1_idx` (`producto_tipo_medida_id`);

--
-- Indexes for table `treatment_by_advance`
--
ALTER TABLE `treatment_by_advance`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treatment_by_advance_treatment_by_patient1_idx` (`treatment_by_patient_id`);

--
-- Indexes for table `treatment_by_breakdown_payment`
--
ALTER TABLE `treatment_by_breakdown_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treatment_by_breakdown_payment_treatment_by_indebtedness_idx` (`treatment_by_indebtedness_paying_init_id`);

--
-- Indexes for table `treatment_by_details`
--
ALTER TABLE `treatment_by_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treatment_by_details_treatment_by_patient1_idx` (`treatment_by_patient_id`);

--
-- Indexes for table `treatment_by_indebtedness_paying_init`
--
ALTER TABLE `treatment_by_indebtedness_paying_init`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treatment_by_indebtedness_paying_init_treatment_by_patie_idx` (`treatment_by_patient_id`);

--
-- Indexes for table `treatment_by_patient`
--
ALTER TABLE `treatment_by_patient`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treatment_by_patient_history_clinic1_idx` (`history_clinic_id`);

--
-- Indexes for table `treatment_by_payment`
--
ALTER TABLE `treatment_by_payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  ADD KEY `fk_treatment_by_payment_treatment_by_breakdown_payment1_idx` (`treatment_by_breakdown_payment_id`),
  ADD KEY `fk_treatment_by_payment_treatment_by_indebtedness_paying_in_idx` (`treatment_by_indebtedness_paying_init_id`);

--
-- Indexes for table `types_payments`
--
ALTER TABLE `types_payments`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types_payments_by_account`
--
ALTER TABLE `types_payments_by_account`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_types_payments_by_account_accounting_account1_idx` (`accounting_account_id`),
  ADD KEY `fk_types_payments_by_account_types_payments1_idx` (`types_payments_id`),
  ADD KEY `fk_types_payments_by_account_business1_idx` (`business_id`);

--
-- Indexes for table `type_ruc`
--
ALTER TABLE `type_ruc`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `universidad_titulos`
--
ALTER TABLE `universidad_titulos`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_by_about_us`
--
ALTER TABLE `users_by_about_us`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_by_profile_users1_idx` (`users_id`);

--
-- Indexes for table `users_has_roles`
--
ALTER TABLE `users_has_roles`
    ADD PRIMARY KEY (`user_id`, `role_id`),
  ADD KEY `fk_users_has_roles_roles1_idx` (`role_id`),
  ADD KEY `fk_users_has_roles_users1_idx` (`user_id`);

--
-- Indexes for table `voucher_type`
--
ALTER TABLE `voucher_type`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_planning_header`
--
ALTER TABLE `work_planning_header`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_planning_header_by_resources`
--
ALTER TABLE `work_planning_header_by_resources`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_work_planning_header_by_resources_work_planning_header1_idx` (`work_planning_header_id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zones_cities1_idx` (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounting_account`
--
ALTER TABLE `accounting_account`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_account_by_balances`
--
ALTER TABLE `accounting_account_by_balances`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'Contabilidad cuenta saldos';

--
-- AUTO_INCREMENT for table `accounting_account_type`
--
ALTER TABLE `accounting_account_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_bank`
--
ALTER TABLE `accounting_bank`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_config_modules_account_by_account`
--
ALTER TABLE `accounting_config_modules_account_by_account`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_config_modules_types`
--
ALTER TABLE `accounting_config_modules_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_level`
--
ALTER TABLE `accounting_level`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_gamification`
--
ALTER TABLE `account_gamification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_gamification_by_movement`
--
ALTER TABLE `account_gamification_by_movement`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_gamification_movement_by_business`
--
ALTER TABLE `account_gamification_movement_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actions_by_role`
--
ALTER TABLE `actions_by_role`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergies_by_history_clinic`
--
ALTER TABLE `allergies_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowed_actions`
--
ALTER TABLE `allowed_actions`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allow_processes_threads`
--
ALTER TABLE `allow_processes_threads`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antecedent`
--
ALTER TABLE `antecedent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antecedent_by_history_clinic`
--
ALTER TABLE `antecedent_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antecedent_family_members_by_history_clinic`
--
ALTER TABLE `antecedent_family_members_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_entity_answer`
--
ALTER TABLE `askwer_entity_answer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_field`
--
ALTER TABLE `askwer_field`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_field_value`
--
ALTER TABLE `askwer_field_value`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_form`
--
ALTER TABLE `askwer_form`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_option`
--
ALTER TABLE `askwer_option`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_section`
--
ALTER TABLE `askwer_section`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `askwer_type`
--
ALTER TABLE `askwer_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `average_kardex`
--
ALTER TABLE `average_kardex`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_by_movement`
--
ALTER TABLE `bank_by_movement`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_by_transaction_management`
--
ALTER TABLE `bank_by_transaction_management`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_movement_by_accounting_seat`
--
ALTER TABLE `bank_movement_by_accounting_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_reason`
--
ALTER TABLE `bank_reason`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_academic_offerings_by_data`
--
ALTER TABLE `business_academic_offerings_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_academic_offerings_data_by_information`
--
ALTER TABLE `business_academic_offerings_data_by_information`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_amenities`
--
ALTER TABLE `business_amenities`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_about`
--
ALTER TABLE `business_by_about`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_academic_offerings`
--
ALTER TABLE `business_by_academic_offerings`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_academic_offerings_institution`
--
ALTER TABLE `business_by_academic_offerings_institution`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_bank`
--
ALTER TABLE `business_by_bank`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_cash`
--
ALTER TABLE `business_by_cash`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_cash_main`
--
ALTER TABLE `business_by_cash_main`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_counter`
--
ALTER TABLE `business_by_counter`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_coupon`
--
ALTER TABLE `business_by_coupon`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_daily_book_seat`
--
ALTER TABLE `business_by_daily_book_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_discount`
--
ALTER TABLE `business_by_discount`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_documents`
--
ALTER TABLE `business_by_documents`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_employee_profile`
--
ALTER TABLE `business_by_employee_profile`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_final_customer`
--
ALTER TABLE `business_by_final_customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_frequent_question`
--
ALTER TABLE `business_by_frequent_question`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_gallery`
--
ALTER TABLE `business_by_gallery`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_gamification`
--
ALTER TABLE `business_by_gamification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_history`
--
ALTER TABLE `business_by_history`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_information_custom`
--
ALTER TABLE `business_by_information_custom`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_inventory_management`
--
ALTER TABLE `business_by_inventory_management`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_inventory_management_subcategory`
--
ALTER TABLE `business_by_inventory_management_subcategory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_invoice_buy`
--
ALTER TABLE `business_by_invoice_buy`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_invoice_sale`
--
ALTER TABLE `business_by_invoice_sale`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_language`
--
ALTER TABLE `business_by_language`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_lodging_by_price`
--
ALTER TABLE `business_by_lodging_by_price`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_menu_management_frontend`
--
ALTER TABLE `business_by_menu_management_frontend`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_panorama`
--
ALTER TABLE `business_by_panorama`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_partner_companies`
--
ALTER TABLE `business_by_partner_companies`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_products`
--
ALTER TABLE `business_by_products`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_promotion`
--
ALTER TABLE `business_by_promotion`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_qualification`
--
ALTER TABLE `business_by_qualification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_requirements`
--
ALTER TABLE `business_by_requirements`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_routes_map`
--
ALTER TABLE `business_by_routes_map`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_schedule`
--
ALTER TABLE `business_by_schedule`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_scheduling_date`
--
ALTER TABLE `business_by_scheduling_date`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_services`
--
ALTER TABLE `business_by_services`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_shipping_rate`
--
ALTER TABLE `business_by_shipping_rate`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_social_networks`
--
ALTER TABLE `business_by_social_networks`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_by_tax`
--
ALTER TABLE `business_by_tax`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_categories`
--
ALTER TABLE `business_categories`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_counter_custom`
--
ALTER TABLE `business_counter_custom`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_counter_custom_by_data`
--
ALTER TABLE `business_counter_custom_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_disbursement`
--
ALTER TABLE `business_disbursement`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_discount_by_product`
--
ALTER TABLE `business_discount_by_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_history_by_data`
--
ALTER TABLE `business_history_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_location`
--
ALTER TABLE `business_location`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_panorama_by_points`
--
ALTER TABLE `business_panorama_by_points`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_schedule_by_breakdown`
--
ALTER TABLE `business_schedule_by_breakdown`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_subcategories`
--
ALTER TABLE `business_subcategories`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bussiness_by_repair`
--
ALTER TABLE `bussiness_by_repair`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caja`
--
ALTER TABLE `caja`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caja_catalogo_billete`
--
ALTER TABLE `caja_catalogo_billete`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caja_catalogo_tipo_fraccion`
--
ALTER TABLE `caja_catalogo_tipo_fraccion`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caja_has_entidad`
--
ALTER TABLE `caja_has_entidad`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caja_tipo_billete`
--
ALTER TABLE `caja_tipo_billete`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capacitaciones`
--
ALTER TABLE `capacitaciones`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capacitaciones_tipo`
--
ALTER TABLE `capacitaciones_tipo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash`
--
ALTER TABLE `cash`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_by_movement`
--
ALTER TABLE `cash_by_movement`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_by_transaction_management`
--
ALTER TABLE `cash_by_transaction_management`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_by_user`
--
ALTER TABLE `cash_by_user`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_movement_by_accounting_seat`
--
ALTER TABLE `cash_movement_by_accounting_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_reason`
--
ALTER TABLE `cash_reason`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinical_by_history_clinic`
--
ALTER TABLE `clinical_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinical_exam`
--
ALTER TABLE `clinical_exam`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counter_by_entity`
--
ALTER TABLE `counter_by_entity`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counter_by_log_user_to_business`
--
ALTER TABLE `counter_by_log_user_to_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_faculty`
--
ALTER TABLE `course_faculty`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_subject_matter`
--
ALTER TABLE `course_subject_matter`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_by_contacts`
--
ALTER TABLE `customer_by_contacts`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_by_information`
--
ALTER TABLE `customer_by_information`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_by_profile`
--
ALTER TABLE `customer_by_profile`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_by_student`
--
ALTER TABLE `customer_by_student`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_profile_by_location`
--
ALTER TABLE `customer_profile_by_location`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_book_seat`
--
ALTER TABLE `daily_book_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_by_business_manager`
--
ALTER TABLE `delivery_by_business_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dental_piece`
--
ALTER TABLE `dental_piece`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dental_piece_by_odontogram`
--
ALTER TABLE `dental_piece_by_odontogram`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diary_book`
--
ALTER TABLE `diary_book`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_by_words`
--
ALTER TABLE `dictionary_by_words`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_language`
--
ALTER TABLE `dictionary_language`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_words_by_audio`
--
ALTER TABLE `dictionary_words_by_audio`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_words_by_examples`
--
ALTER TABLE `dictionary_words_by_examples`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_words_by_photo`
--
ALTER TABLE `dictionary_words_by_photo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_askwer_type`
--
ALTER TABLE `educational_institution_askwer_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_by_business`
--
ALTER TABLE `educational_institution_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_by_course`
--
ALTER TABLE `educational_institution_by_course`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_course_activities_by_askwer`
--
ALTER TABLE `educational_institution_course_activities_by_askwer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_course_by_activities`
--
ALTER TABLE `educational_institution_course_by_activities`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_course_by_students`
--
ALTER TABLE `educational_institution_course_by_students`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_course_by_supervisor`
--
ALTER TABLE `educational_institution_course_by_supervisor`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_students_course_by_activities`
--
ALTER TABLE `educational_institution_students_course_by_activities`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `educational_institution_test_by_answers`
--
ALTER TABLE `educational_institution_test_by_answers`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_authorization_configuration`
--
ALTER TABLE `entity_authorization_configuration`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_has_invoice_sale`
--
ALTER TABLE `entity_has_invoice_sale`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_plans`
--
ALTER TABLE `entity_plans`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_position_fiscal`
--
ALTER TABLE `entity_position_fiscal`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_resources`
--
ALTER TABLE `entity_resources`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_by_kit`
--
ALTER TABLE `events_trails_by_kit`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_by_registration_points`
--
ALTER TABLE `events_trails_by_registration_points`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_distances`
--
ALTER TABLE `events_trails_distances`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_kit_pieces`
--
ALTER TABLE `events_trails_kit_pieces`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_project`
--
ALTER TABLE `events_trails_project`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_project_by_routes_map`
--
ALTER TABLE `events_trails_project_by_routes_map`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_registration_by_customer`
--
ALTER TABLE `events_trails_registration_by_customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_registration_payments_by_business`
--
ALTER TABLE `events_trails_registration_payments_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_registration_points`
--
ALTER TABLE `events_trails_registration_points`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_types`
--
ALTER TABLE `events_trails_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_type_of_categories`
--
ALTER TABLE `events_trails_type_of_categories`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_trails_type_teams`
--
ALTER TABLE `events_trails_type_teams`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_by_assistance`
--
ALTER TABLE `event_by_assistance`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formacion_academica`
--
ALTER TABLE `formacion_academica`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification`
--
ALTER TABLE `gamification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_by_badges`
--
ALTER TABLE `gamification_by_badges`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_by_levels`
--
ALTER TABLE `gamification_by_levels`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_by_points`
--
ALTER TABLE `gamification_by_points`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_by_process`
--
ALTER TABLE `gamification_by_process`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_by_rewards`
--
ALTER TABLE `gamification_by_rewards`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_type_activity`
--
ALTER TABLE `gamification_type_activity`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaminification_by_log_customers`
--
ALTER TABLE `gaminification_by_log_customers`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habits_by_history_clinic`
--
ALTER TABLE `habits_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_desk_header`
--
ALTER TABLE `help_desk_header`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_desk_header_by_resources`
--
ALTER TABLE `help_desk_header_by_resources`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_desk_types`
--
ALTER TABLE `help_desk_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_clinic`
--
ALTER TABLE `history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_department`
--
ALTER TABLE `human_resources_department`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_department_by_manager`
--
ALTER TABLE `human_resources_department_by_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_department_by_organizational_chart_area`
--
ALTER TABLE `human_resources_department_by_organizational_chart_area`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_department_by_rest_day`
--
ALTER TABLE `human_resources_department_by_rest_day`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_employee_permission_by_details`
--
ALTER TABLE `human_resources_employee_permission_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_employee_profile`
--
ALTER TABLE `human_resources_employee_profile`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_employee_profile_by_log_area`
--
ALTER TABLE `human_resources_employee_profile_by_log_area`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_employee_profile_by_permission`
--
ALTER TABLE `human_resources_employee_profile_by_permission`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_organizational_chart_area`
--
ALTER TABLE `human_resources_organizational_chart_area`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_organizational_chart_area_by_manager`
--
ALTER TABLE `human_resources_organizational_chart_area_by_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_permission_type`
--
ALTER TABLE `human_resources_permission_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_schedule_type`
--
ALTER TABLE `human_resources_schedule_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_schedule_type_by_shift`
--
ALTER TABLE `human_resources_schedule_type_by_shift`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_shift`
--
ALTER TABLE `human_resources_shift`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_address`
--
ALTER TABLE `information_address`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_address_by_multimedia`
--
ALTER TABLE `information_address_by_multimedia`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_address_type`
--
ALTER TABLE `information_address_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_mail`
--
ALTER TABLE `information_mail`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_mail_type`
--
ALTER TABLE `information_mail_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_phone`
--
ALTER TABLE `information_phone`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_phone_operator`
--
ALTER TABLE `information_phone_operator`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_phone_type`
--
ALTER TABLE `information_phone_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_social_network`
--
ALTER TABLE `information_social_network`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_social_network_type`
--
ALTER TABLE `information_social_network_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `initial_status_product`
--
ALTER TABLE `initial_status_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_book_seat`
--
ALTER TABLE `invoice_buy_by_book_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_breakdown_payment`
--
ALTER TABLE `invoice_buy_by_breakdown_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_details`
--
ALTER TABLE `invoice_buy_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_details_devolution`
--
ALTER TABLE `invoice_buy_by_details_devolution`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_devolution_product`
--
ALTER TABLE `invoice_buy_by_devolution_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_buy_by_indebtedness_paying_init`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_overridden`
--
ALTER TABLE `invoice_buy_by_overridden`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_payment`
--
ALTER TABLE `invoice_buy_by_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_pendient`
--
ALTER TABLE `invoice_buy_by_pendient`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_retention`
--
ALTER TABLE `invoice_buy_by_retention`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_transactional_annex`
--
ALTER TABLE `invoice_buy_by_transactional_annex`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_buy_by_transactions`
--
ALTER TABLE `invoice_buy_by_transactions`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale`
--
ALTER TABLE `invoice_sale`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_book_seat`
--
ALTER TABLE `invoice_sale_by_book_seat`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_breakdown_payment`
--
ALTER TABLE `invoice_sale_by_breakdown_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_details`
--
ALTER TABLE `invoice_sale_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_details_devolution`
--
ALTER TABLE `invoice_sale_by_details_devolution`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_devolution_product`
--
ALTER TABLE `invoice_sale_by_devolution_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_sale_by_indebtedness_paying_init`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_overridden`
--
ALTER TABLE `invoice_sale_by_overridden`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_payment`
--
ALTER TABLE `invoice_sale_by_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_pendient`
--
ALTER TABLE `invoice_sale_by_pendient`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_retention`
--
ALTER TABLE `invoice_sale_by_retention`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_transactional_annex`
--
ALTER TABLE `invoice_sale_by_transactional_annex`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale_by_transactions`
--
ALTER TABLE `invoice_sale_by_transactions`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course`
--
ALTER TABLE `language_course`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_by_photo`
--
ALTER TABLE `language_course_by_photo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_by_section`
--
ALTER TABLE `language_course_by_section`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_by_dictionary_words`
--
ALTER TABLE `language_course_section_by_dictionary_words`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_by_logo`
--
ALTER TABLE `language_course_section_by_logo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_by_photo`
--
ALTER TABLE `language_course_section_by_photo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_by_rows`
--
ALTER TABLE `language_course_section_by_rows`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_by_sticky_note`
--
ALTER TABLE `language_course_section_by_sticky_note`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_section_rows_by_columns`
--
ALTER TABLE `language_course_section_rows_by_columns`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product`
--
ALTER TABLE `language_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product_category`
--
ALTER TABLE `language_product_category`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product_color`
--
ALTER TABLE `language_product_color`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product_measure_type`
--
ALTER TABLE `language_product_measure_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product_subcategory`
--
ALTER TABLE `language_product_subcategory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_product_trademark`
--
ALTER TABLE `language_product_trademark`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_about_us`
--
ALTER TABLE `language_template_about_us`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_about_us_by_data`
--
ALTER TABLE `language_template_about_us_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_policies`
--
ALTER TABLE `language_template_policies`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_services`
--
ALTER TABLE `language_template_services`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_services_by_data`
--
ALTER TABLE `language_template_services_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_template_slider_by_images`
--
ALTER TABLE `language_template_slider_by_images`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging`
--
ALTER TABLE `lodging`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_arrived_by_social_networks`
--
ALTER TABLE `lodging_arrived_by_social_networks`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_arrived`
--
ALTER TABLE `lodging_by_arrived`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_customer`
--
ALTER TABLE `lodging_by_customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_customer_location`
--
ALTER TABLE `lodging_by_customer_location`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_payment`
--
ALTER TABLE `lodging_by_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_payment_credit_card`
--
ALTER TABLE `lodging_by_payment_credit_card`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_reasons`
--
ALTER TABLE `lodging_by_reasons`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_by_type_of_room`
--
ALTER TABLE `lodging_by_type_of_room`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_customer_additional_information`
--
ALTER TABLE `lodging_customer_additional_information`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_room_features`
--
ALTER TABLE `lodging_room_features`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_room_levels`
--
ALTER TABLE `lodging_room_levels`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_type_of_room`
--
ALTER TABLE `lodging_type_of_room`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lodging_type_of_room_by_price`
--
ALTER TABLE `lodging_type_of_room_by_price`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_by_issuance_bank`
--
ALTER TABLE `log_by_issuance_bank`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_by_issuance_cash`
--
ALTER TABLE `log_by_issuance_cash`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mailing_by_data_send`
--
ALTER TABLE `mailing_by_data_send`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mailing_template`
--
ALTER TABLE `mailing_template`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `management_livelihood_by_voucher`
--
ALTER TABLE `management_livelihood_by_voucher`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_consultation_by_patient`
--
ALTER TABLE `medical_consultation_by_patient`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mikrotik_by_customer_engagement`
--
ALTER TABLE `mikrotik_by_customer_engagement`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mikrotik_dhcp_server`
--
ALTER TABLE `mikrotik_dhcp_server`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mikrotik_rate_limit`
--
ALTER TABLE `mikrotik_rate_limit`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mikrotik_type_conection`
--
ALTER TABLE `mikrotik_type_conection`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `odontogram_by_patient`
--
ALTER TABLE `odontogram_by_patient`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_event_kits_by_customer`
--
ALTER TABLE `order_event_kits_by_customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payments_document`
--
ALTER TABLE `order_payments_document`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payments_manager`
--
ALTER TABLE `order_payments_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_shopping_by_customer_delivery`
--
ALTER TABLE `order_shopping_by_customer_delivery`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_shopping_by_delivery`
--
ALTER TABLE `order_shopping_by_delivery`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_shopping_cart`
--
ALTER TABLE `order_shopping_cart`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_shopping_cart_by_details`
--
ALTER TABLE `order_shopping_cart_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panorama`
--
ALTER TABLE `panorama`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panorama_points`
--
ALTER TABLE `panorama_points`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_gender`
--
ALTER TABLE `people_gender`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_nationality`
--
ALTER TABLE `people_nationality`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_profession`
--
ALTER TABLE `people_profession`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_relationship`
--
ALTER TABLE `people_relationship`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_type_identification`
--
ALTER TABLE `people_type_identification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_by_zones`
--
ALTER TABLE `prices_by_zones`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_aplication`
--
ALTER TABLE `product_aplication`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_details`
--
ALTER TABLE `product_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_discount`
--
ALTER TABLE `product_by_discount`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_ice`
--
ALTER TABLE `product_by_ice`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_multimedia`
--
ALTER TABLE `product_by_multimedia`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_route_map`
--
ALTER TABLE `product_by_route_map`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_stock`
--
ALTER TABLE `product_by_stock`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_unity_inventory`
--
ALTER TABLE `product_by_unity_inventory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_defect`
--
ALTER TABLE `product_defect`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details_shipping_fee`
--
ALTER TABLE `product_details_shipping_fee`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_ice`
--
ALTER TABLE `product_ice`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_ice_types`
--
ALTER TABLE `product_ice_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_inventory`
--
ALTER TABLE `product_inventory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_inventory_by_prices`
--
ALTER TABLE `product_inventory_by_prices`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_inventory_by_price_unity_box`
--
ALTER TABLE `product_inventory_by_price_unity_box`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_inventory_by_unity`
--
ALTER TABLE `product_inventory_by_unity`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_measure_type`
--
ALTER TABLE `product_measure_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_parent`
--
ALTER TABLE `product_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_trademark`
--
ALTER TABLE `product_trademark`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_header`
--
ALTER TABLE `project_header`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_header_by_resources`
--
ALTER TABLE `project_header_by_resources`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reference_piece`
--
ALTER TABLE `reference_piece`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reference_piece_position`
--
ALTER TABLE `reference_piece_position`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reference_piece_type`
--
ALTER TABLE `reference_piece_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair`
--
ALTER TABLE `repair`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_by_details_parts`
--
ALTER TABLE `repair_by_details_parts`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_product_by_business`
--
ALTER TABLE `repair_product_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retention_tax_sub_type`
--
ALTER TABLE `retention_tax_sub_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retention_tax_type`
--
ALTER TABLE `retention_tax_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes_drawing`
--
ALTER TABLE `routes_drawing`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes_map`
--
ALTER TABLE `routes_map`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes_map_by_routes_drawing`
--
ALTER TABLE `routes_map_by_routes_drawing`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `route_map_by_adventure_types`
--
ALTER TABLE `route_map_by_adventure_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruc_type`
--
ALTER TABLE `ruc_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_days_category`
--
ALTER TABLE `schedule_days_category`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secretary_processes_by_customer_presentation`
--
ALTER TABLE `secretary_processes_by_customer_presentation`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_business`
--
ALTER TABLE `shipping_rate_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_business_by_conversion_factor`
--
ALTER TABLE `shipping_rate_business_by_conversion_factor`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_business_by_min_weight`
--
ALTER TABLE `shipping_rate_business_by_min_weight`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_kinds_of_way`
--
ALTER TABLE `shipping_rate_kinds_of_way`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_services`
--
ALTER TABLE `shipping_rate_services`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_by_business`
--
ALTER TABLE `students_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_by_representative`
--
ALTER TABLE `students_by_representative`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_course_activities_by_resource`
--
ALTER TABLE `students_course_activities_by_resource`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_information`
--
ALTER TABLE `students_information`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_representative`
--
ALTER TABLE `students_representative`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_representative_by_business`
--
ALTER TABLE `students_representative_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtipo_medicion`
--
ALTER TABLE `subtipo_medicion`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtipo_medicion_has_equivalencias`
--
ALTER TABLE `subtipo_medicion_has_equivalencias`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes_by_cities`
--
ALTER TABLE `taxes_by_cities`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_by_business`
--
ALTER TABLE `tax_by_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_support`
--
ALTER TABLE `tax_support`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_about_us`
--
ALTER TABLE `template_about_us`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_about_us_by_data`
--
ALTER TABLE `template_about_us_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_blog`
--
ALTER TABLE `template_blog`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_blog_by_comments`
--
ALTER TABLE `template_blog_by_comments`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_blog_by_counters`
--
ALTER TABLE `template_blog_by_counters`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_blog_by_data`
--
ALTER TABLE `template_blog_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_by_products`
--
ALTER TABLE `template_by_products`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_by_source`
--
ALTER TABLE `template_by_source`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_chat_api`
--
ALTER TABLE `template_chat_api`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_config_mailing`
--
ALTER TABLE `template_config_mailing`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_config_mailing_by_emails`
--
ALTER TABLE `template_config_mailing_by_emails`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_contact_us`
--
ALTER TABLE `template_contact_us`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_contact_us_by_routes_map`
--
ALTER TABLE `template_contact_us_by_routes_map`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_faq`
--
ALTER TABLE `template_faq`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_faq_by_data`
--
ALTER TABLE `template_faq_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_information`
--
ALTER TABLE `template_information`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_language_customer`
--
ALTER TABLE `template_language_customer`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_multimedia_sections`
--
ALTER TABLE `template_multimedia_sections`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_news`
--
ALTER TABLE `template_news`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_news_by_data`
--
ALTER TABLE `template_news_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_our_team`
--
ALTER TABLE `template_our_team`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_our_team_by_data`
--
ALTER TABLE `template_our_team_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_payments`
--
ALTER TABLE `template_payments`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_policies`
--
ALTER TABLE `template_policies`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_services`
--
ALTER TABLE `template_services`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_services_by_data`
--
ALTER TABLE `template_services_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_slider`
--
ALTER TABLE `template_slider`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_slider_by_images`
--
ALTER TABLE `template_slider_by_images`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_steps`
--
ALTER TABLE `template_steps`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_steps_by_data`
--
ALTER TABLE `template_steps_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_support`
--
ALTER TABLE `template_support`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_support_by_data`
--
ALTER TABLE `template_support_by_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_wish_list_by_user`
--
ALTER TABLE `template_wish_list_by_user`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_medida_has_subtipo`
--
ALTER TABLE `tipo_medida_has_subtipo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_medida_manager`
--
ALTER TABLE `tipo_medida_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment_by_advance`
--
ALTER TABLE `treatment_by_advance`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment_by_breakdown_payment`
--
ALTER TABLE `treatment_by_breakdown_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `treatment_by_details`
--
ALTER TABLE `treatment_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment_by_indebtedness_paying_init`
--
ALTER TABLE `treatment_by_indebtedness_paying_init`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment_by_patient`
--
ALTER TABLE `treatment_by_patient`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment_by_payment`
--
ALTER TABLE `treatment_by_payment`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `types_payments`
--
ALTER TABLE `types_payments`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types_payments_by_account`
--
ALTER TABLE `types_payments_by_account`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'TYPOS DE PAGOS HAS CUENTA ENTIDAD';

--
-- AUTO_INCREMENT for table `type_ruc`
--
ALTER TABLE `type_ruc`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `universidad_titulos`
--
ALTER TABLE `universidad_titulos`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_by_about_us`
--
ALTER TABLE `users_by_about_us`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_type`
--
ALTER TABLE `voucher_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_planning_header`
--
ALTER TABLE `work_planning_header`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_planning_header_by_resources`
--
ALTER TABLE `work_planning_header_by_resources`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounting_account`
--
ALTER TABLE `accounting_account`
    ADD CONSTRAINT `fk_accounting_account_accounting_account_type1` FOREIGN KEY (`accounting_account_type_id`) REFERENCES `accounting_account_type` (`id`),
  ADD CONSTRAINT `fk_accounting_account_accounting_level1` FOREIGN KEY (`accounting_level_id`) REFERENCES `accounting_level` (`id`);

--
-- Constraints for table `accounting_account_by_balances`
--
ALTER TABLE `accounting_account_by_balances`
    ADD CONSTRAINT `fk_accounting_account_balances_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`);

--
-- Constraints for table `accounting_config_modules_account_by_account`
--
ALTER TABLE `accounting_config_modules_account_by_account`
    ADD CONSTRAINT `fk_accounting_config_modules_account_by_account_accounting_ac1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_accounting_config_modules_account_by_modules_accounting_co1` FOREIGN KEY (`accounting_config_modules_types_id`) REFERENCES `accounting_config_modules_types` (`id`);

--
-- Constraints for table `account_gamification_by_movement`
--
ALTER TABLE `account_gamification_by_movement`
    ADD CONSTRAINT `fk_account_by_movement_account_gamification1` FOREIGN KEY (`account_gamification_id`) REFERENCES `account_gamification` (`id`);

--
-- Constraints for table `account_gamification_movement_by_business`
--
ALTER TABLE `account_gamification_movement_by_business`
    ADD CONSTRAINT `fk_account_gamification_movement_by_business_account_gamifica1` FOREIGN KEY (`account_gamification_by_movement_id`) REFERENCES `account_gamification_by_movement` (`id`),
  ADD CONSTRAINT `fk_account_gamification_movement_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
    ADD CONSTRAINT `fk_actions_actions1` FOREIGN KEY (`parent_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `actions_by_role`
--
ALTER TABLE `actions_by_role`
    ADD CONSTRAINT `fk_actions_by_role_actions1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `fk_actions_by_role_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `allergies_by_history_clinic`
--
ALTER TABLE `allergies_by_history_clinic`
    ADD CONSTRAINT `fk_allergies_by_history_clinic_allergies1` FOREIGN KEY (`allergies_id`) REFERENCES `allergies` (`id`),
  ADD CONSTRAINT `fk_allergies_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `allowed_actions`
--
ALTER TABLE `allowed_actions`
    ADD CONSTRAINT `fk_allowed_actions_actions1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `antecedent_by_history_clinic`
--
ALTER TABLE `antecedent_by_history_clinic`
    ADD CONSTRAINT `fk_antecedent_by_history_clinic_antecedent1` FOREIGN KEY (`antecedent_id`) REFERENCES `antecedent` (`id`),
  ADD CONSTRAINT `fk_antecedent_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `antecedent_family_members_by_history_clinic`
--
ALTER TABLE `antecedent_family_members_by_history_clinic`
    ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_antecedent1` FOREIGN KEY (`antecedent_id`) REFERENCES `antecedent` (`id`),
  ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`),
  ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_people_relatio1` FOREIGN KEY (`people_relationship_id`) REFERENCES `people_relationship` (`id`);

--
-- Constraints for table `askwer_field`
--
ALTER TABLE `askwer_field`
    ADD CONSTRAINT `fk_askwer_field_askwer_section1` FOREIGN KEY (`askwer_section_id`) REFERENCES `askwer_section` (`id`);

--
-- Constraints for table `askwer_field_value`
--
ALTER TABLE `askwer_field_value`
    ADD CONSTRAINT `fk_askwer_field_value_askwer_entity_answer1` FOREIGN KEY (`askwer_entity_answer_id`) REFERENCES `askwer_entity_answer` (`id`),
  ADD CONSTRAINT `fk_askwer_field_value_askwer_field1` FOREIGN KEY (`askwer_field_id`) REFERENCES `askwer_field` (`id`);

--
-- Constraints for table `askwer_option`
--
ALTER TABLE `askwer_option`
    ADD CONSTRAINT `fk_askwer_option_askwer_field1` FOREIGN KEY (`askwer_field_id`) REFERENCES `askwer_field` (`id`);

--
-- Constraints for table `askwer_section`
--
ALTER TABLE `askwer_section`
    ADD CONSTRAINT `fk_askwer_section_askwer_form1` FOREIGN KEY (`askwer_form_id`) REFERENCES `askwer_form` (`id`);

--
-- Constraints for table `average_kardex`
--
ALTER TABLE `average_kardex`
    ADD CONSTRAINT `fk_average_kardex_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_average_kardex_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `business`
--
ALTER TABLE `business`
    ADD CONSTRAINT `fk_business_business_subcategories` FOREIGN KEY (`business_subcategories_id`) REFERENCES `business_subcategories` (`id`);

--
-- Constraints for table `business_academic_offerings_by_data`
--
ALTER TABLE `business_academic_offerings_by_data`
    ADD CONSTRAINT `fk_business_academic_offerings_by_data_business_by_academic_o1` FOREIGN KEY (`business_by_academic_offerings_id`) REFERENCES `business_by_academic_offerings` (`id`);

--
-- Constraints for table `business_amenities`
--
ALTER TABLE `business_amenities`
    ADD CONSTRAINT `fk_business_amenities_business_subcategories1` FOREIGN KEY (`business_subcategories_id`) REFERENCES `business_subcategories` (`id`);

--
-- Constraints for table `business_by_about`
--
ALTER TABLE `business_by_about`
    ADD CONSTRAINT `fk_business_by_about_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_counter`
--
ALTER TABLE `business_by_counter`
    ADD CONSTRAINT `fk_business_by_counter_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_coupon`
--
ALTER TABLE `business_by_coupon`
    ADD CONSTRAINT `fk_business_by_coupon_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_daily_book_seat`
--
ALTER TABLE `business_by_daily_book_seat`
    ADD CONSTRAINT `fk_business_by_daily_book_seat_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_daily_book_seat_daily_book_seat1` FOREIGN KEY (`daily_book_seat_id`) REFERENCES `daily_book_seat` (`id`),
  ADD CONSTRAINT `fk_business_by_daily_book_seat_diary_book1` FOREIGN KEY (`diary_book_id`) REFERENCES `diary_book` (`id`);

--
-- Constraints for table `business_by_discount`
--
ALTER TABLE `business_by_discount`
    ADD CONSTRAINT `fk_business_by_discount_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_documents`
--
ALTER TABLE `business_by_documents`
    ADD CONSTRAINT `fk_business_by_documents_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_employee_profile`
--
ALTER TABLE `business_by_employee_profile`
    ADD CONSTRAINT `fk_business_by_employee_profile_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_employee_profile_human_resources_employee_prof1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `business_by_gallery`
--
ALTER TABLE `business_by_gallery`
    ADD CONSTRAINT `fk_business_by_gallery_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_gamification`
--
ALTER TABLE `business_by_gamification`
    ADD CONSTRAINT `fk_business_by_gamification_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_gamification_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Constraints for table `business_by_invoice_buy`
--
ALTER TABLE `business_by_invoice_buy`
    ADD CONSTRAINT `fk_business_by_invoice_buy_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_invoice_buy_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `business_by_invoice_sale`
--
ALTER TABLE `business_by_invoice_sale`
    ADD CONSTRAINT `fk_business_by_invoice_buy_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_invoice_sale_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `business_by_language`
--
ALTER TABLE `business_by_language`
    ADD CONSTRAINT `fk_business_by_language_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_language_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `business_by_lodging_by_price`
--
ALTER TABLE `business_by_lodging_by_price`
    ADD CONSTRAINT `fk_business_by_lodging_by_price_lodging_type_of_room_by_price1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`),
  ADD CONSTRAINT `fk_business_by_room_by_price_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_panorama`
--
ALTER TABLE `business_by_panorama`
    ADD CONSTRAINT `fk_business_by_panorama_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_panorama_panorama1` FOREIGN KEY (`panorama_id`) REFERENCES `panorama` (`id`),
  ADD CONSTRAINT `fk_business_by_panorama_routes_map_by_routes_drawing1` FOREIGN KEY (`routes_map_by_routes_drawing_id`) REFERENCES `routes_map_by_routes_drawing` (`id`);

--
-- Constraints for table `business_by_products`
--
ALTER TABLE `business_by_products`
    ADD CONSTRAINT `fk_business_by_products_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    ADD CONSTRAINT `fk_business_by_products_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_products_parent_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

--
-- Constraints for table `business_by_promotion`
--
ALTER TABLE `business_by_promotion`
    ADD CONSTRAINT `fk_business_promotion_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_qualification`
--
ALTER TABLE `business_by_qualification`
    ADD CONSTRAINT `fk_business_by_qualification_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_routes_map`
--
ALTER TABLE `business_by_routes_map`
    ADD CONSTRAINT `fk_business_by_routes_map_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_routes_map_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Constraints for table `business_by_schedule`
--
ALTER TABLE `business_by_schedule`
    ADD CONSTRAINT `fk_business_by_schedule_schedule_days_category1` FOREIGN KEY (`schedule_days_category_id`) REFERENCES `schedule_days_category` (`id`),
  ADD CONSTRAINT `fk_business_shedule_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_scheduling_date`
--
ALTER TABLE `business_by_scheduling_date`
    ADD CONSTRAINT `fk_business_by_scheduling_date_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_scheduling_date_scheduling_date1` FOREIGN KEY (`scheduling_date_id`) REFERENCES `scheduling_date` (`id`);

--
-- Constraints for table `business_by_shipping_rate`
--
ALTER TABLE `business_by_shipping_rate`
    ADD CONSTRAINT `fk_business_by_shipping_rate_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_shipping_rate_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Constraints for table `business_by_social_networks`
--
ALTER TABLE `business_by_social_networks`
    ADD CONSTRAINT `fk_business_by_social_networks_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_by_tax`
--
ALTER TABLE `business_by_tax`
    ADD CONSTRAINT `fk_business_by_tax_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_tax_taxes1` FOREIGN KEY (`taxes_id`) REFERENCES `taxes` (`id`);

--
-- Constraints for table `business_disbursement`
--
ALTER TABLE `business_disbursement`
    ADD CONSTRAINT `fk_business_disbursement_bank1` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`id`),
  ADD CONSTRAINT `fk_business_disbursement_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_discount_by_product`
--
ALTER TABLE `business_discount_by_product`
    ADD CONSTRAINT `fk_business_promotion_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `business_location`
--
ALTER TABLE `business_location`
    ADD CONSTRAINT `fk_business_location_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_location_zones1` FOREIGN KEY (`zones_id`) REFERENCES `zones` (`id`);

--
-- Constraints for table `business_panorama_by_points`
--
ALTER TABLE `business_panorama_by_points`
    ADD CONSTRAINT `fk_business_panorama_by_breakdown_business_by_panorama1` FOREIGN KEY (`business_by_panorama_id`) REFERENCES `business_by_panorama` (`id`),
  ADD CONSTRAINT `fk_business_panorama_by_breakdown_panorama_points1` FOREIGN KEY (`panorama_points_id`) REFERENCES `panorama_points` (`id`),
  ADD CONSTRAINT `fk_business_panorama_by_points_panorama1` FOREIGN KEY (`panorama_id`) REFERENCES `panorama` (`id`);

--
-- Constraints for table `business_subcategories`
--
ALTER TABLE `business_subcategories`
    ADD CONSTRAINT `fk_business_subcategories_business_categories1` FOREIGN KEY (`business_categories_id`) REFERENCES `business_categories` (`id`);

--
-- Constraints for table `bussiness_by_repair`
--
ALTER TABLE `bussiness_by_repair`
    ADD CONSTRAINT `fk_bussiness_by_repair_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_bussiness_by_repair_repair1` FOREIGN KEY (`repair_id`) REFERENCES `repair` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
    ADD CONSTRAINT `fk_cities_provinces1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `clinical_by_history_clinic`
--
ALTER TABLE `clinical_by_history_clinic`
    ADD CONSTRAINT `fk_clinical_by_history_clinic_clinical_exam1` FOREIGN KEY (`clinical_exam_id`) REFERENCES `clinical_exam` (`id`),
  ADD CONSTRAINT `fk_clinical_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `counter_by_entity`
--
ALTER TABLE `counter_by_entity`
    ADD CONSTRAINT `fk_counter_by_schedule_entity_business_by_counter1` FOREIGN KEY (`business_by_counter_id`) REFERENCES `business_by_counter` (`id`);

--
-- Constraints for table `counter_by_log_user_to_business`
--
ALTER TABLE `counter_by_log_user_to_business`
    ADD CONSTRAINT `fk_counter_by_log_user_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
    ADD CONSTRAINT `fk_course_course_faculty1` FOREIGN KEY (`course_faculty_id`) REFERENCES `course_faculty` (`id`),
  ADD CONSTRAINT `fk_course_course_subject_matter1` FOREIGN KEY (`course_subject_matter_id`) REFERENCES `course_subject_matter` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
    ADD CONSTRAINT `fk_customer_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_customer_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`),
  ADD CONSTRAINT `fk_customer_ruc_type1` FOREIGN KEY (`ruc_type_id`) REFERENCES `ruc_type` (`id`);

--
-- Constraints for table `customer_by_contacts`
--
ALTER TABLE `customer_by_contacts`
    ADD CONSTRAINT `fk_customer_by_contacts1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `customer_by_information`
--
ALTER TABLE `customer_by_information`
    ADD CONSTRAINT `fk_customer_by_information_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_customer_by_information_people_nationality1` FOREIGN KEY (`people_nationality_id`) REFERENCES `people_nationality` (`id`),
  ADD CONSTRAINT `fk_customer_by_information_people_profession1` FOREIGN KEY (`people_profession_id`) REFERENCES `people_profession` (`id`);

--
-- Constraints for table `customer_by_profile`
--
ALTER TABLE `customer_by_profile`
    ADD CONSTRAINT `fk_customer_by_profile_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `customer_by_student`
--
ALTER TABLE `customer_by_student`
    ADD CONSTRAINT `fk_customer_by_student_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `customer_profile_by_location`
--
ALTER TABLE `customer_profile_by_location`
    ADD CONSTRAINT `fk_users_by_location_customer_by_profile1` FOREIGN KEY (`customer_by_profile_id`) REFERENCES `customer_by_profile` (`id`),
  ADD CONSTRAINT `fk_users_by_location_zones1` FOREIGN KEY (`zones_id`) REFERENCES `zones` (`id`);

--
-- Constraints for table `dental_piece_by_odontogram`
--
ALTER TABLE `dental_piece_by_odontogram`
    ADD CONSTRAINT `fk_dental_piece_by_odontogram_dental_piece1` FOREIGN KEY (`dental_piece_id`) REFERENCES `dental_piece` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_odontogram_by_patient1` FOREIGN KEY (`odontogram_by_patient_id`) REFERENCES `odontogram_by_patient` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_reference_piece1` FOREIGN KEY (`reference_piece_id`) REFERENCES `reference_piece` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_reference_piece_position1` FOREIGN KEY (`reference_piece_position_id`) REFERENCES `reference_piece_position` (`id`);

--
-- Constraints for table `diary_book`
--
ALTER TABLE `diary_book`
    ADD CONSTRAINT `fk_diary_book_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`);

--
-- Constraints for table `dictionary_by_words`
--
ALTER TABLE `dictionary_by_words`
    ADD CONSTRAINT `fk_diccionary_by_words_diccionary_language1` FOREIGN KEY (`diccionary_language_id`) REFERENCES `dictionary_language` (`id`);

--
-- Constraints for table `dictionary_language`
--
ALTER TABLE `dictionary_language`
    ADD CONSTRAINT `fk_dictionary_from_language_id` FOREIGN KEY (`from_language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_dictionary_to_language_id` FOREIGN KEY (`to_language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `dictionary_words_by_audio`
--
ALTER TABLE `dictionary_words_by_audio`
    ADD CONSTRAINT `fk_dictionary_by_photo_dictionary_by_words10` FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

--
-- Constraints for table `dictionary_words_by_examples`
--
ALTER TABLE `dictionary_words_by_examples`
    ADD CONSTRAINT `fk_dictionary_words_by_examples_dictionary_by_words1` FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

--
-- Constraints for table `dictionary_words_by_photo`
--
ALTER TABLE `dictionary_words_by_photo`
    ADD CONSTRAINT `fk_dictionary_by_photo_dictionary_by_words1` FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

--
-- Constraints for table `discount_by_customers`
--
ALTER TABLE `discount_by_customers`
    ADD CONSTRAINT `fk_discount_by_customers_business_by_discount1` FOREIGN KEY (`business_by_discount_id`) REFERENCES `business_by_discount` (`id`),
  ADD CONSTRAINT `fk_discount_by_customers_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `discount_by_products`
--
ALTER TABLE `discount_by_products`
    ADD CONSTRAINT `fk_discount_by_products_business_by_discount1` FOREIGN KEY (`business_by_discount_id`) REFERENCES `business_by_discount` (`id`),
  ADD CONSTRAINT `fk_discount_by_products_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `educational_institution_askwer_type`
--
ALTER TABLE `educational_institution_askwer_type`
    ADD CONSTRAINT `fk_educational_institution_askwer_type_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `educational_institution_by_business`
--
ALTER TABLE `educational_institution_by_business`
    ADD CONSTRAINT `fk_educational_institution_by_askwer_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_educational_institution_by_askwer_educational_institution_1` FOREIGN KEY (`educational_institution_askwer_type_id`) REFERENCES `educational_institution_askwer_type` (`id`),
  ADD CONSTRAINT `fk_educational_institution_by_business_askwer_form1` FOREIGN KEY (`askwer_form_id`) REFERENCES `askwer_form` (`id`);

--
-- Constraints for table `educational_institution_by_course`
--
ALTER TABLE `educational_institution_by_course`
    ADD CONSTRAINT `fk_educational_institution_by_course_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Constraints for table `educational_institution_course_activities_by_askwer`
--
ALTER TABLE `educational_institution_course_activities_by_askwer`
    ADD CONSTRAINT `fk_educational_institution_course_activities_by_askwer_educat1` FOREIGN KEY (`educational_institution_by_business_id`) REFERENCES `educational_institution_by_business` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_activities_by_askwer_educat2` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`);

--
-- Constraints for table `educational_institution_course_by_activities`
--
ALTER TABLE `educational_institution_course_by_activities`
    ADD CONSTRAINT `fk_educational_institution_course_by_activities_educational_i1` FOREIGN KEY (`educational_institution_course_by_supervisor_id`) REFERENCES `educational_institution_course_by_supervisor` (`id`);

--
-- Constraints for table `educational_institution_course_by_students`
--
ALTER TABLE `educational_institution_course_by_students`
    ADD CONSTRAINT `fk_educational_institution_course_by_students_educational_ins1` FOREIGN KEY (`educational_institution_by_course_id`) REFERENCES `educational_institution_by_course` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_by_students_students_inform1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`);

--
-- Constraints for table `educational_institution_course_by_supervisor`
--
ALTER TABLE `educational_institution_course_by_supervisor`
    ADD CONSTRAINT `fk_educational_institution_course_by_supervisor_business_by_e1` FOREIGN KEY (`business_by_employee_profile_id`) REFERENCES `business_by_employee_profile` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_by_supervisor_educational_i1` FOREIGN KEY (`educational_institution_by_course_id`) REFERENCES `educational_institution_by_course` (`id`);

--
-- Constraints for table `educational_institution_students_course_by_activities`
--
ALTER TABLE `educational_institution_students_course_by_activities`
    ADD CONSTRAINT `fk_educational_institution_student_course_by_activities_educa1` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`),
  ADD CONSTRAINT `fk_educational_institution_student_course_by_activities_educa2` FOREIGN KEY (`educational_institution_course_by_students_id`) REFERENCES `educational_institution_course_by_students` (`id`);

--
-- Constraints for table `educational_institution_test_by_answers`
--
ALTER TABLE `educational_institution_test_by_answers`
    ADD CONSTRAINT `fk_educational_institution_test_by_answers_askwer_entity_answ1` FOREIGN KEY (`askwer_entity_answer_id`) REFERENCES `askwer_entity_answer` (`id`),
  ADD CONSTRAINT `fk_educational_institution_test_by_answers_educational_instit1` FOREIGN KEY (`educational_institution_students_course_by_activities_id`) REFERENCES `educational_institution_students_course_by_activities` (`id`);

--
-- Constraints for table `events_trails_by_kit`
--
ALTER TABLE `events_trails_by_kit`
    ADD CONSTRAINT `fk_events_trails_by_clothing_kit_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `events_trails_by_registration_points`
--
ALTER TABLE `events_trails_by_registration_points`
    ADD CONSTRAINT `fk_events_trails_by_registration_points_events_trails_registr1` FOREIGN KEY (`events_trails_registration_by_customer_id`) REFERENCES `events_trails_registration_by_customer` (`id`),
  ADD CONSTRAINT `fk_events_trails_by_registration_points_events_trails_registr2` FOREIGN KEY (`events_trails_registration_points_id`) REFERENCES `events_trails_registration_points` (`id`);

--
-- Constraints for table `events_trails_distances`
--
ALTER TABLE `events_trails_distances`
    ADD CONSTRAINT `fk_events_trails_distances_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`),
  ADD CONSTRAINT `fk_events_trails_distances_events_trails_type_teams1` FOREIGN KEY (`events_trails_type_teams_id`) REFERENCES `events_trails_type_teams` (`id`);

--
-- Constraints for table `events_trails_kit_pieces`
--
ALTER TABLE `events_trails_kit_pieces`
    ADD CONSTRAINT `fk_events_trails_kit_pieces_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `events_trails_project`
--
ALTER TABLE `events_trails_project`
    ADD CONSTRAINT `fk_events_trails_project_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_events_trails_project_events_trails_types1` FOREIGN KEY (`events_trails_types_id`) REFERENCES `events_trails_types` (`id`);

--
-- Constraints for table `events_trails_project_by_routes_map`
--
ALTER TABLE `events_trails_project_by_routes_map`
    ADD CONSTRAINT `fk_events_by_routes_map_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`),
  ADD CONSTRAINT `fk_events_trails_project_by_routes_map_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `events_trails_registration_by_customer`
--
ALTER TABLE `events_trails_registration_by_customer`
    ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_dista1` FOREIGN KEY (`events_trails_distances_id`) REFERENCES `events_trails_distances` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_proje1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_type_1` FOREIGN KEY (`events_trails_type_of_categories_id`) REFERENCES `events_trails_type_of_categories` (`id`);

--
-- Constraints for table `events_trails_registration_payments_by_business`
--
ALTER TABLE `events_trails_registration_payments_by_business`
    ADD CONSTRAINT `fk_events_trails_registration_by_business_events_trails_regis1` FOREIGN KEY (`events_trails_registration_points_id`) REFERENCES `events_trails_registration_points` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_business_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Constraints for table `events_trails_registration_points`
--
ALTER TABLE `events_trails_registration_points`
    ADD CONSTRAINT `fk_events_trails_registration_points_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `events_trails_type_of_categories`
--
ALTER TABLE `events_trails_type_of_categories`
    ADD CONSTRAINT `fk_events_trails_type_of_categories_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `events_trails_type_teams`
--
ALTER TABLE `events_trails_type_teams`
    ADD CONSTRAINT `fk_events_trails_type_teams_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Constraints for table `event_by_assistance`
--
ALTER TABLE `event_by_assistance`
    ADD CONSTRAINT `fk_event_by_assistance1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `gamification_by_allies`
--
ALTER TABLE `gamification_by_allies`
    ADD CONSTRAINT `fk_gamification_by_allies_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_gamification_by_allies_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Constraints for table `gamification_by_badges`
--
ALTER TABLE `gamification_by_badges`
    ADD CONSTRAINT `fk_gamification_by_badges_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Constraints for table `gamification_by_levels`
--
ALTER TABLE `gamification_by_levels`
    ADD CONSTRAINT `fk_gamification_by_levels_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Constraints for table `gamification_by_points`
--
ALTER TABLE `gamification_by_points`
    ADD CONSTRAINT `fk_gamification_by_points_gamification_by_process1` FOREIGN KEY (`gamification_by_process_id`) REFERENCES `gamification_by_process` (`id`);

--
-- Constraints for table `gamification_by_process`
--
ALTER TABLE `gamification_by_process`
    ADD CONSTRAINT `fk_gamification_by_process_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`),
  ADD CONSTRAINT `fk_gamification_by_process_gamification_type_activity1` FOREIGN KEY (`gamification_type_activity_id`) REFERENCES `gamification_type_activity` (`id`);

--
-- Constraints for table `gamification_by_rewards`
--
ALTER TABLE `gamification_by_rewards`
    ADD CONSTRAINT `fk_gamification_by_rewards_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Constraints for table `habits_by_history_clinic`
--
ALTER TABLE `habits_by_history_clinic`
    ADD CONSTRAINT `fk_habits_by_history_clinic_habits1` FOREIGN KEY (`habits_id`) REFERENCES `habits` (`id`),
  ADD CONSTRAINT `fk_habits_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `help_desk_header`
--
ALTER TABLE `help_desk_header`
    ADD CONSTRAINT `fk_help_desk_header_help_desk_types1` FOREIGN KEY (`help_desk_types_id`) REFERENCES `help_desk_types` (`id`),
  ADD CONSTRAINT `fk_help_desk_header_human_resources_department1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`),
  ADD CONSTRAINT `fk_project_header_human_resources_employee_profile10` FOREIGN KEY (`help_desk_human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`),
  ADD CONSTRAINT `fk_project_header_human_resources_employee_profile20` FOREIGN KEY (`administrator_human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `help_desk_header_by_resources`
--
ALTER TABLE `help_desk_header_by_resources`
    ADD CONSTRAINT `fk_help_desk_header_by_resources_help_desk_header1` FOREIGN KEY (`help_desk_header_id`) REFERENCES `help_desk_header` (`id`);

--
-- Constraints for table `human_resources_department`
--
ALTER TABLE `human_resources_department`
    ADD CONSTRAINT `fk_human_resources_department_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `human_resources_department_by_manager`
--
ALTER TABLE `human_resources_department_by_manager`
    ADD CONSTRAINT `fk_human_resources_department_by_manager_human_resources_depa1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`),
  ADD CONSTRAINT `fk_human_resources_department_by_manager_human_resources_empl1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `human_resources_department_by_organizational_chart_area`
--
ALTER TABLE `human_resources_department_by_organizational_chart_area`
    ADD CONSTRAINT `fk_human_resources_department_by_organizational_chart_area_hu1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`),
  ADD CONSTRAINT `fk_human_resources_department_by_organizational_chart_area_hu2` FOREIGN KEY (`human_resources_organizational_chart_area_id`) REFERENCES `human_resources_organizational_chart_area` (`id`);

--
-- Constraints for table `human_resources_department_by_rest_day`
--
ALTER TABLE `human_resources_department_by_rest_day`
    ADD CONSTRAINT `fk_human_resources_department_by_rest_day_human_resources_dep1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`);

--
-- Constraints for table `human_resources_employee_permission_by_details`
--
ALTER TABLE `human_resources_employee_permission_by_details`
    ADD CONSTRAINT `fk_human_resources_employee_permission_by_details_human_resou1` FOREIGN KEY (`human_resources_employee_profile_by_permission_id`) REFERENCES `human_resources_employee_profile_by_permission` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_by_log_rest_day_human_res2` FOREIGN KEY (`human_resources_permission_type_id`) REFERENCES `human_resources_permission_type` (`id`);

--
-- Constraints for table `human_resources_employee_profile`
--
ALTER TABLE `human_resources_employee_profile`
    ADD CONSTRAINT `fk_human_resources_employee_profile_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_human_resources_department1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_human_resources_organizat1` FOREIGN KEY (`human_resources_organizational_chart_area_id`) REFERENCES `human_resources_organizational_chart_area` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_human_resources_shedule_t1` FOREIGN KEY (`human_resources_schedule_type_id`) REFERENCES `human_resources_schedule_type` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_nationality1` FOREIGN KEY (`people_nationality_id`) REFERENCES `people_nationality` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_profession1` FOREIGN KEY (`people_profession_id`) REFERENCES `people_profession` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`);

--
-- Constraints for table `human_resources_employee_profile_by_log_area`
--
ALTER TABLE `human_resources_employee_profile_by_log_area`
    ADD CONSTRAINT `fk_human_resources_employee_profile_by_log_area_human_resourc1` FOREIGN KEY (`human_resources_organizational_chart_area_id`) REFERENCES `human_resources_organizational_chart_area` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_by_log_area_human_resourc2` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `human_resources_employee_profile_by_permission`
--
ALTER TABLE `human_resources_employee_profile_by_permission`
    ADD CONSTRAINT `fk_human_resources_employee_profile_by_permission_human_resou1` FOREIGN KEY (`human_resources_permission_type_id`) REFERENCES `human_resources_permission_type` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_by_permission_human_resou2` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `human_resources_organizational_chart_area_by_manager`
--
ALTER TABLE `human_resources_organizational_chart_area_by_manager`
    ADD CONSTRAINT `fk_human_resources_organizational_chart_area_by_manager_human1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`),
  ADD CONSTRAINT `fk_human_resources_organizational_chart_area_by_manager_human2` FOREIGN KEY (`human_resources_organizational_chart_area_id`) REFERENCES `human_resources_organizational_chart_area` (`id`);

--
-- Constraints for table `human_resources_schedule_type_by_shift`
--
ALTER TABLE `human_resources_schedule_type_by_shift`
    ADD CONSTRAINT `fk_human_resources_schedule_type_by_shift_human_resources_shed1` FOREIGN KEY (`human_resources_schedule_type_id`) REFERENCES `human_resources_schedule_type` (`id`),
  ADD CONSTRAINT `fk_human_resources_schedule_type_by_shift_human_resources_shift1` FOREIGN KEY (`human_resources_shift_id`) REFERENCES `human_resources_shift` (`id`);

--
-- Constraints for table `information_address`
--
ALTER TABLE `information_address`
    ADD CONSTRAINT `fk_information_address_information_address_type1` FOREIGN KEY (`information_address_type_id`) REFERENCES `information_address_type` (`id`);

--
-- Constraints for table `information_address_by_multimedia`
--
ALTER TABLE `information_address_by_multimedia`
    ADD CONSTRAINT `fk_information_address_by_multimedia_information_address1` FOREIGN KEY (`information_address_id`) REFERENCES `information_address` (`id`);

--
-- Constraints for table `information_mail`
--
ALTER TABLE `information_mail`
    ADD CONSTRAINT `fk_information_mail_information_mail_type1` FOREIGN KEY (`information_mail_type_id`) REFERENCES `information_mail_type` (`id`);

--
-- Constraints for table `information_phone`
--
ALTER TABLE `information_phone`
    ADD CONSTRAINT `fk_information_phone_information_phone_operator1` FOREIGN KEY (`information_phone_operator_id`) REFERENCES `information_phone_operator` (`id`),
  ADD CONSTRAINT `fk_information_phone_information_phone_type1` FOREIGN KEY (`information_phone_type_id`) REFERENCES `information_phone_type` (`id`);

--
-- Constraints for table `information_social_network`
--
ALTER TABLE `information_social_network`
    ADD CONSTRAINT `fk_information_social_network_information_social_network_type1` FOREIGN KEY (`information_social_network_type_id`) REFERENCES `information_social_network_type` (`id`);

--
-- Constraints for table `initial_status_product`
--
ALTER TABLE `initial_status_product`
    ADD CONSTRAINT `fk_initial_status_product_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_initial_status_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `invoice_buy`
--
ALTER TABLE `invoice_buy`
    ADD CONSTRAINT `fk_invoice_buy_voucher_type1` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Constraints for table `invoice_buy_by_book_seat`
--
ALTER TABLE `invoice_buy_by_book_seat`
    ADD CONSTRAINT `fk_invoice_buy_by_book_seat_diary_book1` FOREIGN KEY (`diary_book_id`) REFERENCES `diary_book` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_book_seat_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_breakdown_payment`
--
ALTER TABLE `invoice_buy_by_breakdown_payment`
    ADD CONSTRAINT `fk_invoice_buy_by_breakdown_payment_invoice_buy_by_indebtedne1` FOREIGN KEY (`invoice_buy_by_indebtedness_paying_init_id`) REFERENCES `invoice_buy_by_indebtedness_paying_init` (`id`);

--
-- Constraints for table `invoice_buy_by_details`
--
ALTER TABLE `invoice_buy_by_details`
    ADD CONSTRAINT `fk_invoice_buy_details_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_details_devolution`
--
ALTER TABLE `invoice_buy_by_details_devolution`
    ADD CONSTRAINT `fk_invoice_buy_details_invoice_buy10` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_devolution_product`
--
ALTER TABLE `invoice_buy_by_devolution_product`
    ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_invoice_buy_by_details_d1` FOREIGN KEY (`invoice_buy_by_details_devolution_id`) REFERENCES `invoice_buy_by_details_devolution` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_product_defect1` FOREIGN KEY (`product_defect_id`) REFERENCES `product_defect` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_types_payments1` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`);

--
-- Constraints for table `invoice_buy_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_buy_by_indebtedness_paying_init`
    ADD CONSTRAINT `fk_invoice_buy_indebtedness_paying_init_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_overridden`
--
ALTER TABLE `invoice_buy_by_overridden`
    ADD CONSTRAINT `fk_invoice_buy_overridden_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_payment`
--
ALTER TABLE `invoice_buy_by_payment`
    ADD CONSTRAINT `fk_invoice_buy_by_payment_invoice_buy_by_breakdown_payment1` FOREIGN KEY (`invoice_buy_by_breakdown_payment_id`) REFERENCES `invoice_buy_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_payment_invoice_buy_by_indebtedness_paying_1` FOREIGN KEY (`invoice_buy_by_indebtedness_paying_init_id`) REFERENCES `invoice_buy_by_indebtedness_paying_init` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account1` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`);

--
-- Constraints for table `invoice_buy_by_pendient`
--
ALTER TABLE `invoice_buy_by_pendient`
    ADD CONSTRAINT `fk_invoice_buy_by_pendient_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_buy_by_retention`
--
ALTER TABLE `invoice_buy_by_retention`
    ADD CONSTRAINT `fk_invoice_buy_by_retention_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_retention_retention_tax_sub_type1` FOREIGN KEY (`retention_tax_sub_type_id`) REFERENCES `retention_tax_sub_type` (`id`);

--
-- Constraints for table `invoice_buy_by_transactional_annex`
--
ALTER TABLE `invoice_buy_by_transactional_annex`
    ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_management_livelihood_b1` FOREIGN KEY (`management_livelihood_by_voucher_id`) REFERENCES `management_livelihood_by_voucher` (`id`);

--
-- Constraints for table `invoice_buy_by_transactions`
--
ALTER TABLE `invoice_buy_by_transactions`
    ADD CONSTRAINT `fk_factura_buy_by_transactions_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_transactions_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Constraints for table `invoice_sale`
--
ALTER TABLE `invoice_sale`
    ADD CONSTRAINT `fk_invoice_buy_voucher_type10` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Constraints for table `invoice_sale_by_book_seat`
--
ALTER TABLE `invoice_sale_by_book_seat`
    ADD CONSTRAINT `fk_invoice_sale_by_book_seat_daily_book_seat1` FOREIGN KEY (`daily_book_seat_id`) REFERENCES `daily_book_seat` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_book_seat_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_breakdown_payment`
--
ALTER TABLE `invoice_sale_by_breakdown_payment`
    ADD CONSTRAINT `fk_invoice_sale_by_breakdown_payment_invoice_sale_by_indebted1` FOREIGN KEY (`invoice_sale_by_indebtedness_paying_init_id`) REFERENCES `invoice_sale_by_indebtedness_paying_init` (`id`);

--
-- Constraints for table `invoice_sale_by_details`
--
ALTER TABLE `invoice_sale_by_details`
    ADD CONSTRAINT `fk_invoice_sale_by_details_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_details_devolution`
--
ALTER TABLE `invoice_sale_by_details_devolution`
    ADD CONSTRAINT `fk_invoice_sale_by_details_devolution_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_devolution_product`
--
ALTER TABLE `invoice_sale_by_devolution_product`
    ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_accounting_account10` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_product_defect10` FOREIGN KEY (`product_defect_id`) REFERENCES `product_defect` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_types_payments10` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_devolution_product_invoice_sale_by_details1` FOREIGN KEY (`invoice_sale_by_details_devolution_id`) REFERENCES `invoice_sale_by_details_devolution` (`id`);

--
-- Constraints for table `invoice_sale_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_sale_by_indebtedness_paying_init`
    ADD CONSTRAINT `fk_invoice_sale_by_indebtedness_paying_init_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_overridden`
--
ALTER TABLE `invoice_sale_by_overridden`
    ADD CONSTRAINT `fk_invoice_sale_by_overridden_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_payment`
--
ALTER TABLE `invoice_sale_by_payment`
    ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account10` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_payment_invoice_sale_by_breakdown_payment1` FOREIGN KEY (`invoice_sale_by_breakdown_payment_id`) REFERENCES `invoice_sale_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_payment_invoice_sale_by_indebtedness_payin1` FOREIGN KEY (`invoice_sale_by_indebtedness_paying_init_id`) REFERENCES `invoice_sale_by_indebtedness_paying_init` (`id`);

--
-- Constraints for table `invoice_sale_by_pendient`
--
ALTER TABLE `invoice_sale_by_pendient`
    ADD CONSTRAINT `fk_invoice_sale_by_pendient_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_retention`
--
ALTER TABLE `invoice_sale_by_retention`
    ADD CONSTRAINT `fk_invoice_buy_by_retention_retention_tax_sub_type10` FOREIGN KEY (`retention_tax_sub_type_id`) REFERENCES `retention_tax_sub_type` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_retention_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_transactional_annex`
--
ALTER TABLE `invoice_sale_by_transactional_annex`
    ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_management_livelihood_b10` FOREIGN KEY (`management_livelihood_by_voucher_id`) REFERENCES `management_livelihood_by_voucher` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_transactional_annex_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `invoice_sale_by_transactions`
--
ALTER TABLE `invoice_sale_by_transactions`
    ADD CONSTRAINT `fk_factura_buy_by_transactions_accounting_account10` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_transactions_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Constraints for table `language_course`
--
ALTER TABLE `language_course`
    ADD CONSTRAINT `fk_language_course_dictionary_language1` FOREIGN KEY (`dictionary_language_id`) REFERENCES `dictionary_language` (`id`);

--
-- Constraints for table `language_course_by_photo`
--
ALTER TABLE `language_course_by_photo`
    ADD CONSTRAINT `fk_language_course_by_photo_language_course1` FOREIGN KEY (`language_course_id`) REFERENCES `language_course` (`id`);

--
-- Constraints for table `language_course_by_section`
--
ALTER TABLE `language_course_by_section`
    ADD CONSTRAINT `fk_language_course_by_section_language_course1` FOREIGN KEY (`language_course_id`) REFERENCES `language_course` (`id`);

--
-- Constraints for table `language_course_section_by_dictionary_words`
--
ALTER TABLE `language_course_section_by_dictionary_words`
    ADD CONSTRAINT `fk_language_course_section_by_dictionary_words_dictionary_by_1` FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`),
  ADD CONSTRAINT `fk_language_course_section_by_dictionary_words_language_cours1` FOREIGN KEY (`language_course_by_section_id`) REFERENCES `language_course_by_section` (`id`);

--
-- Constraints for table `language_course_section_by_logo`
--
ALTER TABLE `language_course_section_by_logo`
    ADD CONSTRAINT `fk_language_course_section_by_logo_language_course_by_section1` FOREIGN KEY (`language_course_by_section_id`) REFERENCES `language_course_by_section` (`id`);

--
-- Constraints for table `language_course_section_by_photo`
--
ALTER TABLE `language_course_section_by_photo`
    ADD CONSTRAINT `fk_language_course_section_by_photo_language_course_by_section1` FOREIGN KEY (`language_course_by_section_id`) REFERENCES `language_course_by_section` (`id`);

--
-- Constraints for table `language_course_section_by_rows`
--
ALTER TABLE `language_course_section_by_rows`
    ADD CONSTRAINT `fk_language_course_section_by_rows_language_course_by_section1` FOREIGN KEY (`language_course_by_section_id`) REFERENCES `language_course_by_section` (`id`);

--
-- Constraints for table `language_course_section_by_sticky_note`
--
ALTER TABLE `language_course_section_by_sticky_note`
    ADD CONSTRAINT `fk_language_course_section_by_sticky_note_language_course_by_1` FOREIGN KEY (`language_course_by_section_id`) REFERENCES `language_course_by_section` (`id`);

--
-- Constraints for table `language_course_section_rows_by_columns`
--
ALTER TABLE `language_course_section_rows_by_columns`
    ADD CONSTRAINT `fk_language_course_section_by_cols_language_course_section_by1` FOREIGN KEY (`language_course_section_by_rows_id`) REFERENCES `language_course_section_by_rows` (`id`),
  ADD CONSTRAINT `fk_language_course_section_rows_by_columns_dictionary_by_words1` FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

--
-- Constraints for table `language_product`
--
ALTER TABLE `language_product`
    ADD CONSTRAINT `fk_language_product_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `language_product_category`
--
ALTER TABLE `language_product_category`
    ADD CONSTRAINT `fk_language_product_category_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_category_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `language_product_color`
--
ALTER TABLE `language_product_color`
    ADD CONSTRAINT `fk_language_product_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_language_product_trademark_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `language_product_measure_type`
--
ALTER TABLE `language_product_measure_type`
    ADD CONSTRAINT `fk_language_product_measure_type_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_measure_type_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`);

--
-- Constraints for table `language_product_subcategory`
--
ALTER TABLE `language_product_subcategory`
    ADD CONSTRAINT `fk_language_product_category_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_subcategory_product_subcategory1` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`);

--
-- Constraints for table `language_product_trademark`
--
ALTER TABLE `language_product_trademark`
    ADD CONSTRAINT `fk_language_product_trademark_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_trademark_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`);

--
-- Constraints for table `language_template_about_us`
--
ALTER TABLE `language_template_about_us`
    ADD CONSTRAINT `fk_language_template_about_us_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_about_us_template_about_us1` FOREIGN KEY (`template_about_us_id`) REFERENCES `template_about_us` (`id`);

--
-- Constraints for table `language_template_about_us_by_data`
--
ALTER TABLE `language_template_about_us_by_data`
    ADD CONSTRAINT `fk_language_template_about_us_by_data_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_about_us_by_data_template_about_us_by_da1` FOREIGN KEY (`template_about_us_by_data_id`) REFERENCES `template_about_us_by_data` (`id`);

--
-- Constraints for table `language_template_policies`
--
ALTER TABLE `language_template_policies`
    ADD CONSTRAINT `fk_language_template_policies_template_policies1` FOREIGN KEY (`template_policies_id`) REFERENCES `template_policies` (`id`),
  ADD CONSTRAINT `fk_language_template_services_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `language_template_services`
--
ALTER TABLE `language_template_services`
    ADD CONSTRAINT `fk_language_template_services_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_services_template_services1` FOREIGN KEY (`template_services_id`) REFERENCES `template_services` (`id`);

--
-- Constraints for table `language_template_services_by_data`
--
ALTER TABLE `language_template_services_by_data`
    ADD CONSTRAINT `fk_language_template_services_by_data_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_services_by_data_template_services_by_da1` FOREIGN KEY (`template_services_by_data_id`) REFERENCES `template_services_by_data` (`id`);

--
-- Constraints for table `language_template_slider_by_images`
--
ALTER TABLE `language_template_slider_by_images`
    ADD CONSTRAINT `fk_language_template_services_language100` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_slider_by_images_template_slider_by_imag1` FOREIGN KEY (`template_slider_by_images_id`) REFERENCES `template_slider_by_images` (`id`);

--
-- Constraints for table `lodging_arrived_by_social_networks`
--
ALTER TABLE `lodging_arrived_by_social_networks`
    ADD CONSTRAINT `fk_lodging_arrived_by_social_networks_lodging_by_arrived1` FOREIGN KEY (`lodging_by_arrived_id`) REFERENCES `lodging_by_arrived` (`id`);

--
-- Constraints for table `lodging_by_arrived`
--
ALTER TABLE `lodging_by_arrived`
    ADD CONSTRAINT `fk_lodging_by_contact_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Constraints for table `lodging_by_customer`
--
ALTER TABLE `lodging_by_customer`
    ADD CONSTRAINT `fk_lodging_by_customer_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_loding_by_customer_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Constraints for table `lodging_by_customer_location`
--
ALTER TABLE `lodging_by_customer_location`
    ADD CONSTRAINT `fk_lodging_by_customer_location_information_address1` FOREIGN KEY (`information_address_id`) REFERENCES `information_address` (`id`),
  ADD CONSTRAINT `fk_loding_by_customer_location_lodging_by_customer1` FOREIGN KEY (`lodging_by_customer_id`) REFERENCES `lodging_by_customer` (`id`);

--
-- Constraints for table `lodging_by_payment`
--
ALTER TABLE `lodging_by_payment`
    ADD CONSTRAINT `fk_lodging_by_payment_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Constraints for table `lodging_by_payment_credit_card`
--
ALTER TABLE `lodging_by_payment_credit_card`
    ADD CONSTRAINT `fk_loding_by_payment_credit_card_lodging_by_payment1` FOREIGN KEY (`lodging_by_payment_id`) REFERENCES `lodging_by_payment` (`id`);

--
-- Constraints for table `lodging_by_reasons`
--
ALTER TABLE `lodging_by_reasons`
    ADD CONSTRAINT `fk_lodging_by_reasons_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Constraints for table `lodging_by_type_of_room`
--
ALTER TABLE `lodging_by_type_of_room`
    ADD CONSTRAINT `fk_lodging_by_type_of_room_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`),
  ADD CONSTRAINT `fk_lodging_by_type_of_room_lodging_type_of_room_by_price1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`);

--
-- Constraints for table `lodging_customer_additional_information`
--
ALTER TABLE `lodging_customer_additional_information`
    ADD CONSTRAINT `fk_lodging_customer_additional_information_information_mail1` FOREIGN KEY (`information_mail_id`) REFERENCES `information_mail` (`id`),
  ADD CONSTRAINT `fk_lodging_customer_additional_information_lodging_by_customer1` FOREIGN KEY (`lodging_by_customer_id`) REFERENCES `lodging_by_customer` (`id`);

--
-- Constraints for table `lodging_type_of_room_by_price`
--
ALTER TABLE `lodging_type_of_room_by_price`
    ADD CONSTRAINT `fk_lodging_type_of_room_by_price_lodging_room_levels1` FOREIGN KEY (`lodging_room_levels_id`) REFERENCES `lodging_room_levels` (`id`),
  ADD CONSTRAINT `fk_lodging_type_of_room_by_price_lodging_type_of_room1` FOREIGN KEY (`lodging_type_of_room_id`) REFERENCES `lodging_type_of_room` (`id`);

--
-- Constraints for table `lodging_type_of_room_price_by_features`
--
ALTER TABLE `lodging_type_of_room_price_by_features`
    ADD CONSTRAINT `fk_lodging_type_of_room_price_by_features_lodging_room_featur1` FOREIGN KEY (`lodging_room_features_id`) REFERENCES `lodging_room_features` (`id`),
  ADD CONSTRAINT `fk_lodging_type_of_room_price_by_features_lodging_type_of_roo1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`);

--
-- Constraints for table `management_livelihood_by_voucher`
--
ALTER TABLE `management_livelihood_by_voucher`
    ADD CONSTRAINT `fk_management_livelihood_by_voucher_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`),
  ADD CONSTRAINT `fk_management_livelihood_by_voucher_tax_support1` FOREIGN KEY (`tax_support_id`) REFERENCES `tax_support` (`id`),
  ADD CONSTRAINT `fk_management_livelihood_by_voucher_voucher_type1` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Constraints for table `medical_consultation_by_patient`
--
ALTER TABLE `medical_consultation_by_patient`
    ADD CONSTRAINT `fk_medical_consultation_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `mikrotik_by_customer_engagement`
--
ALTER TABLE `mikrotik_by_customer_engagement`
    ADD CONSTRAINT `fk_mikrotik_by_customer_engagement_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_mikrotik_by_customer_engagement_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`),
  ADD CONSTRAINT `fk_mikrotik_by_customer_engagement_mikrotik_dhcp_server1` FOREIGN KEY (`mikrotik_dhcp_server_id`) REFERENCES `mikrotik_dhcp_server` (`id`),
  ADD CONSTRAINT `fk_mikrotik_by_customer_engagement_mikrotik_rate_limit1` FOREIGN KEY (`mikrotik_rate_limit_id`) REFERENCES `mikrotik_rate_limit` (`id`);

--
-- Constraints for table `mikrotik_dhcp_server`
--
ALTER TABLE `mikrotik_dhcp_server`
    ADD CONSTRAINT `fk_mikrotik_dhcp_server_mikrotik_type_conection1` FOREIGN KEY (`mikrotik_type_conection_id`) REFERENCES `mikrotik_type_conection` (`id`);

--
-- Constraints for table `odontogram_by_patient`
--
ALTER TABLE `odontogram_by_patient`
    ADD CONSTRAINT `fk_odontogram_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `order_event_kits_by_customer`
--
ALTER TABLE `order_event_kits_by_customer`
    ADD CONSTRAINT `fk_order_event_customer_events_trails_registration_by_customer1` FOREIGN KEY (`events_trails_registration_by_customer_id`) REFERENCES `events_trails_registration_by_customer` (`id`);

--
-- Constraints for table `order_payments_document`
--
ALTER TABLE `order_payments_document`
    ADD CONSTRAINT `fk_order_payments_document_order_payments_manager1` FOREIGN KEY (`order_payments_manager_id`) REFERENCES `order_payments_manager` (`id`);

--
-- Constraints for table `order_shopping_by_customer_delivery`
--
ALTER TABLE `order_shopping_by_customer_delivery`
    ADD CONSTRAINT `fk_order_shoping_by_customer_delivery_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);

--
-- Constraints for table `order_shopping_by_delivery`
--
ALTER TABLE `order_shopping_by_delivery`
    ADD CONSTRAINT `fk_order_shoping_by_customer_delivery_people10` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_order_shopping_by_delivery_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Constraints for table `order_shopping_cart`
--
ALTER TABLE `order_shopping_cart`
    ADD CONSTRAINT `fk_order_shopping_cart_order_payments_manager1` FOREIGN KEY (`order_payments_manager_id`) REFERENCES `order_payments_manager` (`id`),
  ADD CONSTRAINT `fk_order_shopping_cart_order_shopping_by_customer_delivery1` FOREIGN KEY (`order_shopping_by_customer_delivery_id`) REFERENCES `order_shopping_by_customer_delivery` (`id`);

--
-- Constraints for table `order_shopping_cart_by_details`
--
ALTER TABLE `order_shopping_cart_by_details`
    ADD CONSTRAINT `fk_order_shopping_cart_by_details_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Constraints for table `prices_by_zones`
--
ALTER TABLE `prices_by_zones`
    ADD CONSTRAINT `fk_price_by_zone_zones1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
    ADD CONSTRAINT `fk_product_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`),
  ADD CONSTRAINT `fk_product_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_product_product_subcategory1` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`),
  ADD CONSTRAINT `fk_product_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`);

--
-- Constraints for table `product_by_aplication`
--
ALTER TABLE `product_by_aplication`
    ADD CONSTRAINT `fk_product_by_aplication_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_aplication_product_aplication1` FOREIGN KEY (`product_aplication_id`) REFERENCES `product_aplication` (`id`);

--
-- Constraints for table `product_by_color`
--
ALTER TABLE `product_by_color`
    ADD CONSTRAINT `fk_product_by_color_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`);

--
-- Constraints for table `product_by_details`
--
ALTER TABLE `product_by_details`
    ADD CONSTRAINT `fk_product_by_details_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_details_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Constraints for table `product_by_discount`
--
ALTER TABLE `product_by_discount`
    ADD CONSTRAINT `fk_product_by_discount_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_by_ice`
--
ALTER TABLE `product_by_ice`
    ADD CONSTRAINT `fk_product_by_ice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_ice_product_ice1` FOREIGN KEY (`product_ice_id`) REFERENCES `product_ice` (`id`);

--
-- Constraints for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    ADD CONSTRAINT `fk_product_by_log_inventory_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    ADD CONSTRAINT `fk_product_by_meta_data_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_by_multimedia`
--
ALTER TABLE `product_by_multimedia`
    ADD CONSTRAINT `fk_product_by_multimedia_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_by_package`
--
ALTER TABLE `product_by_package`
    ADD CONSTRAINT `fk_product_by_package_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_package_params_id1` FOREIGN KEY (`product_parent_by_package_params_id`) REFERENCES `product_parent_by_package_params` (`id`);

--
-- Constraints for table `product_by_route_map`
--
ALTER TABLE `product_by_route_map`
    ADD CONSTRAINT `fk_product_by_route_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_route_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Constraints for table `product_by_sizes`
--
ALTER TABLE `product_by_sizes`
    ADD CONSTRAINT `fk_product_by_sizes_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_sizes_product_sizes1` FOREIGN KEY (`product_sizes_id`) REFERENCES `product_sizes` (`id`);

--
-- Constraints for table `product_by_stock`
--
ALTER TABLE `product_by_stock`
    ADD CONSTRAINT `fk_product_by_stock_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_details_shipping_fee`
--
ALTER TABLE `product_details_shipping_fee`
    ADD CONSTRAINT `fk_product_details_shipping_fee_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_ice`
--
ALTER TABLE `product_ice`
    ADD CONSTRAINT `fk_product_ice_product_ice_types1` FOREIGN KEY (`product_ice_types_id`) REFERENCES `product_ice_types` (`id`);

--
-- Constraints for table `product_inventory`
--
ALTER TABLE `product_inventory`
    ADD CONSTRAINT `fk_product_inventory_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_inventory_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Constraints for table `product_inventory_by_prices`
--
ALTER TABLE `product_inventory_by_prices`
    ADD CONSTRAINT `fk_product_inventory_by_prices_product_inventory1` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Constraints for table `product_inventory_by_price_unity_box`
--
ALTER TABLE `product_inventory_by_price_unity_box`
    ADD CONSTRAINT `fk_product_by_unity_inventory_product_inventory10` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Constraints for table `product_inventory_by_unity`
--
ALTER TABLE `product_inventory_by_unity`
    ADD CONSTRAINT `fk_product_by_unity_inventory_product_inventory1` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Constraints for table `product_parent`
--
ALTER TABLE `product_parent`
    ADD CONSTRAINT `fk_product_parent_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_product_parent_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`),
  ADD CONSTRAINT `fk_product_product_category10` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`),
  ADD CONSTRAINT `fk_product_product_subcategory10` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`);

--
-- Constraints for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    ADD CONSTRAINT `fk_product_parent_by_package_params_product_parent_by_prices1` FOREIGN KEY (`product_parent_by_prices_id`) REFERENCES `product_parent_by_prices` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_prices_product_parent10` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

--
-- Constraints for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    ADD CONSTRAINT `fk_product_parent_by_prices_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

--
-- Constraints for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    ADD CONSTRAINT `fk_product_parent_by_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_product_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

--
-- Constraints for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
    ADD CONSTRAINT `fk_product_subcategory_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `project_header`
--
ALTER TABLE `project_header`
    ADD CONSTRAINT `fk_project_header_countries1` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `fk_project_header_human_resources_employee_profile1` FOREIGN KEY (`help_desk_human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`),
  ADD CONSTRAINT `fk_project_header_human_resources_employee_profile2` FOREIGN KEY (`administrator_human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Constraints for table `project_header_by_resources`
--
ALTER TABLE `project_header_by_resources`
    ADD CONSTRAINT `fk_project_header_by_resources_project_header1` FOREIGN KEY (`project_header_id`) REFERENCES `project_header` (`id`);

--
-- Constraints for table `provinces`
--
ALTER TABLE `provinces`
    ADD CONSTRAINT `fk_provinces_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `repair_by_details_parts`
--
ALTER TABLE `repair_by_details_parts`
    ADD CONSTRAINT `fk_repair_by_details_parts_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_repair1` FOREIGN KEY (`repair_id`) REFERENCES `repair` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_repair_product_by_business1` FOREIGN KEY (`repair_product_by_business_id`) REFERENCES `repair_product_by_business` (`id`);

--
-- Constraints for table `repair_product_by_business`
--
ALTER TABLE `repair_product_by_business`
    ADD CONSTRAINT `fk_repair_product_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `repair_product_by_color`
--
ALTER TABLE `repair_product_by_color`
    ADD CONSTRAINT `fk_repair_product_by_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_repair_product_by_color_repair_by_details_parts1` FOREIGN KEY (`repair_by_details_parts_id`) REFERENCES `repair_by_details_parts` (`id`);

--
-- Constraints for table `retention_tax_sub_type`
--
ALTER TABLE `retention_tax_sub_type`
    ADD CONSTRAINT `fk_retention_tax_sub_type_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_retention_tax_sub_type_retention_tax_type1` FOREIGN KEY (`retention_tax_type_id`) REFERENCES `retention_tax_type` (`id`);

--
-- Constraints for table `routes_map_by_routes_drawing`
--
ALTER TABLE `routes_map_by_routes_drawing`
    ADD CONSTRAINT `fk_routes_map_by_drawing_routes_drawing1` FOREIGN KEY (`routes_drawing_id`) REFERENCES `routes_drawing` (`id`),
  ADD CONSTRAINT `fk_routes_map_by_drawing_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Constraints for table `route_map_by_adventure_types`
--
ALTER TABLE `route_map_by_adventure_types`
    ADD CONSTRAINT `fk_route_by_adventure_types_business_by_routes_map1` FOREIGN KEY (`business_by_routes_map_id`) REFERENCES `business_by_routes_map` (`id`);

--
-- Constraints for table `secretary_processes_by_customer_presentation`
--
ALTER TABLE `secretary_processes_by_customer_presentation`
    ADD CONSTRAINT `fk_secretary_processes_by_customer_presentation_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `shipping_rate_business_by_conversion_factor`
--
ALTER TABLE `shipping_rate_business_by_conversion_factor`
    ADD CONSTRAINT `fk_shipping_rate_business_by_conversion_factor_shipping_rate_2` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_shipping_rate_kinds_of_1` FOREIGN KEY (`shipping_rate_kinds_of_way_id`) REFERENCES `shipping_rate_kinds_of_way` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_shipping_rate_services1` FOREIGN KEY (`shipping_rate_services_id`) REFERENCES `shipping_rate_services` (`id`);

--
-- Constraints for table `shipping_rate_business_by_min_weight`
--
ALTER TABLE `shipping_rate_business_by_min_weight`
    ADD CONSTRAINT `fk_shipping_rate_business_by_min_weight_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Constraints for table `shipping_rate_services`
--
ALTER TABLE `shipping_rate_services`
    ADD CONSTRAINT `fk_shipping_rate_services_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Constraints for table `students_by_business`
--
ALTER TABLE `students_by_business`
    ADD CONSTRAINT `fk_students_by_business_students_information1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`),
  ADD CONSTRAINT `fk_students_representative_by_business_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `students_by_representative`
--
ALTER TABLE `students_by_representative`
    ADD CONSTRAINT `fk_students_by_representative_students_information1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`),
  ADD CONSTRAINT `fk_students_by_representative_students_representative1` FOREIGN KEY (`students_representative_id`) REFERENCES `students_representative` (`id`);

--
-- Constraints for table `students_course_activities_by_resource`
--
ALTER TABLE `students_course_activities_by_resource`
    ADD CONSTRAINT `fk_students_course_activities_by_resource_educational_institu1` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`);

--
-- Constraints for table `students_information`
--
ALTER TABLE `students_information`
    ADD CONSTRAINT `fk_students_information_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);

--
-- Constraints for table `students_representative`
--
ALTER TABLE `students_representative`
    ADD CONSTRAINT `fk_students_representative_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_students_representative_people_relationship1` FOREIGN KEY (`people_relationship_id`) REFERENCES `people_relationship` (`id`);

--
-- Constraints for table `students_representative_by_business`
--
ALTER TABLE `students_representative_by_business`
    ADD CONSTRAINT `fk_students_representative_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_students_representative_by_business_students_representative1` FOREIGN KEY (`students_representative_id`) REFERENCES `students_representative` (`id`);

--
-- Constraints for table `taxes_by_cities`
--
ALTER TABLE `taxes_by_cities`
    ADD CONSTRAINT `fk_taxes_by_cities_cities1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_taxes_by_cities_taxes1` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`);

--
-- Constraints for table `tax_by_business`
--
ALTER TABLE `tax_by_business`
    ADD CONSTRAINT `fk_tax_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_tax_by_business_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Constraints for table `template_about_us`
--
ALTER TABLE `template_about_us`
    ADD CONSTRAINT `fk_template_slider_template_information10` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_about_us_by_data`
--
ALTER TABLE `template_about_us_by_data`
    ADD CONSTRAINT `fk_template_about_us_by_data_template_about_us1` FOREIGN KEY (`template_about_us_id`) REFERENCES `template_about_us` (`id`);

--
-- Constraints for table `template_blog`
--
ALTER TABLE `template_blog`
    ADD CONSTRAINT `fk_template_slider_template_information102011` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_blog_by_comments`
--
ALTER TABLE `template_blog_by_comments`
    ADD CONSTRAINT `fk_template_blog_by_comments_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Constraints for table `template_blog_by_counters`
--
ALTER TABLE `template_blog_by_counters`
    ADD CONSTRAINT `fk_template_blog_by_counters_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Constraints for table `template_blog_by_data`
--
ALTER TABLE `template_blog_by_data`
    ADD CONSTRAINT `fk_template_blog_by_data_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Constraints for table `template_by_products`
--
ALTER TABLE `template_by_products`
    ADD CONSTRAINT `fk_template_by_products_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_template_by_products_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_by_source`
--
ALTER TABLE `template_by_source`
    ADD CONSTRAINT `fk_template_by_source_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_chat_api`
--
ALTER TABLE `template_chat_api`
    ADD CONSTRAINT `fk_template_chat_api_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_config_mailing`
--
ALTER TABLE `template_config_mailing`
    ADD CONSTRAINT `fk_template_config_mailing_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_config_mailing_by_emails`
--
ALTER TABLE `template_config_mailing_by_emails`
    ADD CONSTRAINT `fk_template_config_mailing_by_emails_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_contact_us`
--
ALTER TABLE `template_contact_us`
    ADD CONSTRAINT `fk_template_contact_us_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_contact_us_by_routes_map`
--
ALTER TABLE `template_contact_us_by_routes_map`
    ADD CONSTRAINT `fk_events_by_routes_map_routes_map10` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`),
  ADD CONSTRAINT `fk_template_contact_us_by_routes_map_template_contact_us1` FOREIGN KEY (`template_contact_us_id`) REFERENCES `template_contact_us` (`id`);

--
-- Constraints for table `template_faq`
--
ALTER TABLE `template_faq`
    ADD CONSTRAINT `fk_template_slider_template_information102010` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_faq_by_data`
--
ALTER TABLE `template_faq_by_data`
    ADD CONSTRAINT `fk_template_faq_by_data_template_faq1` FOREIGN KEY (`template_faq_id`) REFERENCES `template_faq` (`id`);

--
-- Constraints for table `template_information`
--
ALTER TABLE `template_information`
    ADD CONSTRAINT `fk_template_information_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Constraints for table `template_multimedia_sections`
--
ALTER TABLE `template_multimedia_sections`
    ADD CONSTRAINT `fk_template_slider_template_information10200` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_our_team`
--
ALTER TABLE `template_our_team`
    ADD CONSTRAINT `fk_template_slider_template_information1020` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_our_team_by_data`
--
ALTER TABLE `template_our_team_by_data`
    ADD CONSTRAINT `fk_template_our_team_by_data_human_resources_employee_profile1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`),
  ADD CONSTRAINT `fk_template_our_team_by_data_template_our_team1` FOREIGN KEY (`template_our_team_id`) REFERENCES `template_our_team` (`id`);

--
-- Constraints for table `template_payments`
--
ALTER TABLE `template_payments`
    ADD CONSTRAINT `fk_template_payments_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_policies`
--
ALTER TABLE `template_policies`
    ADD CONSTRAINT `fk_template_slider_template_information101` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_services`
--
ALTER TABLE `template_services`
    ADD CONSTRAINT `fk_template_slider_template_information100` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_services_by_data`
--
ALTER TABLE `template_services_by_data`
    ADD CONSTRAINT `fk_template_services_by_data_template_services1` FOREIGN KEY (`template_services_id`) REFERENCES `template_services` (`id`);

--
-- Constraints for table `template_slider`
--
ALTER TABLE `template_slider`
    ADD CONSTRAINT `fk_template_slider_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_slider_by_images`
--
ALTER TABLE `template_slider_by_images`
    ADD CONSTRAINT `fk_template_slider_by_images_template_slider1` FOREIGN KEY (`template_slider_id`) REFERENCES `template_slider` (`id`);

--
-- Constraints for table `template_steps`
--
ALTER TABLE `template_steps`
    ADD CONSTRAINT `fk_template_slider_template_information10201` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_steps_by_data`
--
ALTER TABLE `template_steps_by_data`
    ADD CONSTRAINT `fk_template_steps_by_data_template_steps1` FOREIGN KEY (`template_steps_id`) REFERENCES `template_steps` (`id`);

--
-- Constraints for table `template_support`
--
ALTER TABLE `template_support`
    ADD CONSTRAINT `fk_template_slider_template_information102` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `template_support_by_data`
--
ALTER TABLE `template_support_by_data`
    ADD CONSTRAINT `fk_template_support_by_data_template_support1` FOREIGN KEY (`template_support_id`) REFERENCES `template_support` (`id`);

--
-- Constraints for table `template_wish_list_by_user`
--
ALTER TABLE `template_wish_list_by_user`
    ADD CONSTRAINT `fk_template_wish_list_by_user_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Constraints for table `treatment_by_advance`
--
ALTER TABLE `treatment_by_advance`
    ADD CONSTRAINT `fk_treatment_by_advance_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Constraints for table `treatment_by_breakdown_payment`
--
ALTER TABLE `treatment_by_breakdown_payment`
    ADD CONSTRAINT `fk_treatment_by_breakdown_payment_treatment_by_indebtedness_p1` FOREIGN KEY (`treatment_by_indebtedness_paying_init_id`) REFERENCES `treatment_by_indebtedness_paying_init` (`id`);

--
-- Constraints for table `treatment_by_details`
--
ALTER TABLE `treatment_by_details`
    ADD CONSTRAINT `fk_treatment_by_details_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Constraints for table `treatment_by_indebtedness_paying_init`
--
ALTER TABLE `treatment_by_indebtedness_paying_init`
    ADD CONSTRAINT `fk_treatment_by_indebtedness_paying_init_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Constraints for table `treatment_by_patient`
--
ALTER TABLE `treatment_by_patient`
    ADD CONSTRAINT `fk_treatment_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Constraints for table `treatment_by_payment`
--
ALTER TABLE `treatment_by_payment`
    ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account100` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`),
  ADD CONSTRAINT `fk_treatment_by_payment_treatment_by_breakdown_payment1` FOREIGN KEY (`treatment_by_breakdown_payment_id`) REFERENCES `treatment_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_treatment_by_payment_treatment_by_indebtedness_paying_init1` FOREIGN KEY (`treatment_by_indebtedness_paying_init_id`) REFERENCES `treatment_by_indebtedness_paying_init` (`id`);

--
-- Constraints for table `types_payments_by_account`
--
ALTER TABLE `types_payments_by_account`
    ADD CONSTRAINT `fk_types_payments_by_account_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_types_payments_by_account_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_types_payments_by_account_types_payments1` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`);

--
-- Constraints for table `users_by_about_us`
--
ALTER TABLE `users_by_about_us`
    ADD CONSTRAINT `fk_users_by_profile_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_has_roles`
--
ALTER TABLE `users_has_roles`
    ADD CONSTRAINT `fk_users_has_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_users_has_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `work_planning_header_by_resources`
--
ALTER TABLE `work_planning_header_by_resources`
    ADD CONSTRAINT `fk_work_planning_header_by_resources_work_planning_header1` FOREIGN KEY (`work_planning_header_id`) REFERENCES `work_planning_header` (`id`);


ALTER TABLE `counter_by_log_user_to_business`
    ADD COLUMN `type_process` VARCHAR(100) NOT NULL DEFAULT 'web-tracking' COMMENT 'Ej: share,click,view,referral,web-tracking',
  ADD COLUMN `source_origin` VARCHAR(100) NOT NULL DEFAULT 'meetclick' COMMENT 'Ej: facebook, whatsapp, google, meetclick, qr-code',
  ADD COLUMN `referer_url` VARCHAR(255) NOT NULL DEFAULT 'internal' COMMENT 'Desde qué URL llegó (Referer header)',
ADD COLUMN `campaign_code` TEXT  NOT NULL  COMMENT 'Código único de campaña o tracking (Ej: fb_234)',
  ADD COLUMN `device_agent` VARCHAR(255) NOT NULL DEFAULT 'default-agent' COMMENT 'User-Agent del navegador y dispositivo',
  ADD COLUMN `ip_address` VARCHAR(45) NOT NULL DEFAULT '0.0.0.0' COMMENT 'IP del visitante'
;
ALTER TABLE `business_by_counter`
    ADD COLUMN `type_process` VARCHAR(100) NOT NULL DEFAULT 'web-tracking' COMMENT 'Ej: share,click,view,referral,web-tracking',
  ADD COLUMN `source_origin` VARCHAR(100) NOT NULL DEFAULT 'meetclick' COMMENT 'Ej: facebook, whatsapp, google, meetclick, qr-code',
  ADD COLUMN `referer_url` VARCHAR(255) NOT NULL DEFAULT 'internal' COMMENT 'Desde qué URL llegó (Referer header)',
ADD COLUMN `campaign_code` TEXT  NOT NULL  COMMENT 'Código único de campaña o tracking (Ej: fb_234)',
  ADD COLUMN `device_agent` VARCHAR(255) NOT NULL DEFAULT 'default-agent' COMMENT 'User-Agent del navegador y dispositivo',
  ADD COLUMN `ip_address` VARCHAR(45) NOT NULL DEFAULT '0.0.0.0' COMMENT 'IP del visitante';



ALTER TABLE `counter_by_entity`
    ADD COLUMN `type_process` VARCHAR(100) NOT NULL DEFAULT 'web-tracking' COMMENT 'Ej: share,click,view,referral,web-tracking',
  ADD COLUMN `source_origin` VARCHAR(100) NOT NULL DEFAULT 'meetclick' COMMENT 'Ej: facebook, whatsapp, google, meetclick, qr-code',
  ADD COLUMN `referer_url` VARCHAR(255) NOT NULL DEFAULT 'internal' COMMENT 'Desde qué URL llegó (Referer header)',
ADD COLUMN `campaign_code` TEXT  NOT NULL  COMMENT 'Código único de campaña o tracking (Ej: fb_234)',
  ADD COLUMN `device_agent` VARCHAR(255) NOT NULL DEFAULT 'default-agent' COMMENT 'User-Agent del navegador y dispositivo',
  ADD COLUMN `ip_address` VARCHAR(45) NOT NULL DEFAULT '0.0.0.0' COMMENT 'IP del visitante';

CREATE TABLE `counter_tracking_registry`
(
    `id`           INT(11) NOT NULL AUTO_INCREMENT,
    -- Identificador del registro original y su origen
    `source_table` ENUM('business_by_counter', 'counter_by_entity', 'counter_by_log_user_to_business') NOT NULL COMMENT 'Origen del registro',
    `source_id`    INT(11) NOT NULL COMMENT 'ID del registro original en la tabla de origen',
    -- Localización geográfica (como la que ya agregaste a log_user_to_business)
    `country`      VARCHAR(100)   DEFAULT NULL,
    `region`       VARCHAR(100)   DEFAULT NULL,
    `city`         VARCHAR(100)   DEFAULT NULL,
    `latitude`     DECIMAL(10, 7) DEFAULT NULL,
    `longitude`    DECIMAL(10, 7) DEFAULT NULL,
    `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
