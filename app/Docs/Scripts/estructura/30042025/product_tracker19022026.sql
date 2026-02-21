
SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

DROP TABLE IF EXISTS `product_by_package`;
DROP TABLE IF EXISTS `product_parent_by_package_params`;
DROP TABLE IF EXISTS `product_parent_by_prices`;
DROP TABLE IF EXISTS `product_parent_by_product`;
DROP TABLE IF EXISTS `product_by_meta_data`;
DROP TABLE IF EXISTS `product_by_log_inventory`;
DROP TABLE IF EXISTS `business_by_products_parent`;
DROP TABLE IF EXISTS `product_parent`;


CREATE TABLE `business_by_products_parent`
(
    `id`                int(11) NOT NULL,
    `business_id`       int(11) NOT NULL,
    `product_parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


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

CREATE TABLE `product_by_package`
(
    `product_parent_by_package_params_id` int(11) NOT NULL,
    `product_id`                          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


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







-- ============================================================
-- 1) product_parent
-- ============================================================

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
-- AUTO_INCREMENT for table `product_parent`
--
ALTER TABLE `product_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_parent`
--
ALTER TABLE `product_parent`
    ADD CONSTRAINT `fk_product_parent_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_product_parent_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`),
  ADD CONSTRAINT `fk_product_product_category10` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`),
  ADD CONSTRAINT `fk_product_product_subcategory10` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`);

-- ============================================================
-- 2) product_parent_by_prices
-- ============================================================

--
-- Indexes for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_prices_product_parent1_idx` (`product_parent_id`);

--
-- AUTO_INCREMENT for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    ADD CONSTRAINT `fk_product_parent_by_prices_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

-- ============================================================
-- 3) product_parent_by_product
-- ============================================================

--
-- Indexes for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_product_product_parent1_idx` (`product_parent_id`),
  ADD KEY `fk_product_parent_by_product_product1_idx` (`product_id`);

--
-- AUTO_INCREMENT for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    ADD CONSTRAINT `fk_product_parent_by_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_product_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

-- ============================================================
-- 4) product_parent_by_package_params
-- ============================================================

--
-- Indexes for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_parent_by_prices_product_parent1_idx` (`product_parent_id`),
  ADD KEY `fk_product_parent_by_package_params_product_parent_by_price_idx` (`product_parent_by_prices_id`);

--
-- AUTO_INCREMENT for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    ADD CONSTRAINT `fk_product_parent_by_package_params_product_parent_by_prices1` FOREIGN KEY (`product_parent_by_prices_id`) REFERENCES `product_parent_by_prices` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_prices_product_parent10` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);

-- ============================================================
-- 5) product_by_package
-- ============================================================

--
-- Indexes for table `product_by_package`
--
ALTER TABLE `product_by_package`
    ADD PRIMARY KEY (`product_parent_by_package_params_id`, `product_id`),
  ADD KEY `fk_product_by_package_product1_idx` (`product_id`);

--
-- Constraints for table `product_by_package`
--
ALTER TABLE `product_by_package`
    ADD CONSTRAINT `fk_product_by_package_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_parent_by_package_params_id1` FOREIGN KEY (`product_parent_by_package_params_id`) REFERENCES `product_parent_by_package_params` (`id`);

-- ============================================================
-- 6) product_by_meta_data
-- ============================================================

--
-- Indexes for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_meta_data_product1_idx` (`product_id`);

--
-- AUTO_INCREMENT for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_by_meta_data`
--
ALTER TABLE `product_by_meta_data`
    ADD CONSTRAINT `fk_product_by_meta_data_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

-- ============================================================
-- 7) product_by_log_inventory
-- ============================================================

--
-- Indexes for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_by_log_inventory_product1_idx` (`product_id`);

--
-- AUTO_INCREMENT for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `product_by_log_inventory`
--
ALTER TABLE `product_by_log_inventory`
    ADD CONSTRAINT `fk_product_by_log_inventory_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

-- ============================================================
-- 8) business_by_products_parent
-- ============================================================

--
-- Indexes for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_by_products_business1_idx` (`business_id`),
  ADD KEY `fk_business_by_products_parent_product_parent1_idx` (`product_parent_id`);

--
-- AUTO_INCREMENT for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    ADD CONSTRAINT `fk_business_by_products_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_products_parent_product_parent1` FOREIGN KEY (`product_parent_id`) REFERENCES `product_parent` (`id`);



SET
FOREIGN_KEY_CHECKS=1;
COMMIT;

