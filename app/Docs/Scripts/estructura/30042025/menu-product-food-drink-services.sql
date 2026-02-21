SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =============================================
-- 1) MENU GROUP
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_group` (
                                            `id` INT AUTO_INCREMENT PRIMARY KEY,
                                            `code` VARCHAR(50) NOT NULL,
                                            `name` VARCHAR(120) NOT NULL,
                                            `description` TEXT,
                                            `icon` VARCHAR(100) NULL,
                                            `sort_order` INT DEFAULT 0,
                                            `is_active` TINYINT(1) DEFAULT 1,
                                            `business_id` INT NOT NULL,
                                            UNIQUE KEY `ux_menu_group_business_code` (`business_id`, `code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- 2) MENU ITEM
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item` (
                                           `id` INT AUTO_INCREMENT PRIMARY KEY,
                                           `code` VARCHAR(80) NOT NULL,
                                           `name` VARCHAR(160) NOT NULL,
                                           `description` TEXT,

                                           `category_type` ENUM('FOOD','DRINK','SERVICE','EXPERIENCE') DEFAULT 'FOOD',
                                           `menu_type` ENUM('SINGLE','COMBO') DEFAULT 'SINGLE',

    -- manda si se descuenta o no inventario
                                           `requires_inventory` TINYINT(1) DEFAULT 1,

                                           `price` DECIMAL(10,4) NOT NULL DEFAULT 0,
                                           `has_tax` TINYINT(1) DEFAULT 0,
                                           `tax_id` INT NULL,

                                           `is_active` TINYINT(1) DEFAULT 1,
                                           `sort_order` INT DEFAULT 0,
                                           `business_id` INT NOT NULL,

                                           UNIQUE KEY `ux_menu_item_business_code` (`business_id`, `code`),
                                           KEY `ix_menu_item_tax_id` (`tax_id`),

                                           CONSTRAINT `fk_menu_item_tax`
                                               FOREIGN KEY (`tax_id`) REFERENCES `tax`(`id`)
                                                   ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- 3) MENU ITEM GROUP (M:N)
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item_group` (
                                                 `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                 `menu_item_id` INT NOT NULL,
                                                 `menu_group_id` INT NOT NULL,
                                                 `sort_order` INT DEFAULT 0,
                                                 UNIQUE KEY `ux_menu_item_group` (`menu_item_id`, `menu_group_id`),
                                                 CONSTRAINT `fk_menu_item_group_item`
                                                     FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item`(`id`) ON DELETE CASCADE,
                                                 CONSTRAINT `fk_menu_item_group_group`
                                                     FOREIGN KEY (`menu_group_id`) REFERENCES `menu_group`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- 4) MENU ITEM IMAGE
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item_image` (
                                                 `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                 `menu_item_id` INT NOT NULL,
                                                 `image_url` VARCHAR(250) NOT NULL,
                                                 `is_main` TINYINT(1) DEFAULT 0,
                                                 `sort_order` INT DEFAULT 0,
                                                 CONSTRAINT `fk_menu_item_image_item`
                                                     FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- solo 1 imagen principal por item
CREATE UNIQUE INDEX `ux_menu_item_main_image`
    ON `menu_item_image` ((CASE WHEN is_main = 1 THEN menu_item_id END));

-- =============================================
-- 5) COMPONENTS (receta / combo)
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item_component` (
                                                     `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                     `menu_item_id` INT NOT NULL,
                                                     `product_id` INT NOT NULL,
                                                     `quantity` DECIMAL(10,4) DEFAULT 1,
                                                     `is_optional` TINYINT(1) DEFAULT 0,

                                                     KEY `ix_menu_item_component_product` (`product_id`),

                                                     CONSTRAINT `fk_menu_item_component_item`
                                                         FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item`(`id`) ON DELETE CASCADE,
                                                     CONSTRAINT `fk_menu_item_component_product`
                                                         FOREIGN KEY (`product_id`) REFERENCES `product`(`id`)
                                                             ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- 6) OPTIONS (extras)
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item_option_group` (
                                                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                        `menu_item_id` INT NOT NULL,
                                                        `name` VARCHAR(120) NOT NULL,
                                                        `is_required` TINYINT(1) DEFAULT 0,
                                                        `max_selection` INT DEFAULT 1,
                                                        CONSTRAINT `fk_menu_item_option_group_item`
                                                            FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `menu_item_option` (
                                                  `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                  `option_group_id` INT NOT NULL,
                                                  `product_id` INT NOT NULL,
                                                  `extra_price` DECIMAL(10,4) DEFAULT 0,

                                                  KEY `ix_menu_item_option_product` (`product_id`),

                                                  CONSTRAINT `fk_menu_item_option_group`
                                                      FOREIGN KEY (`option_group_id`) REFERENCES `menu_item_option_group`(`id`) ON DELETE CASCADE,
                                                  CONSTRAINT `fk_menu_item_option_product`
                                                      FOREIGN KEY (`product_id`) REFERENCES `product`(`id`)
                                                          ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- 7) CAPACITY (solo si es service/experience)
-- =============================================
CREATE TABLE IF NOT EXISTS `menu_item_capacity` (
                                                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                                                    `menu_item_id` INT NOT NULL,
                                                    `max_capacity` INT,
                                                    `duration_minutes` INT,
                                                    CONSTRAINT `fk_menu_item_capacity_item`
                                                        FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
