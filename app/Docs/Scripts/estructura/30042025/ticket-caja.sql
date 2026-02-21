SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =========================================================
-- 1) MÉTODOS DE PAGO (catalog)
--    Seeds en ESPAÑOL, naming en INGLÉS
-- =========================================================
CREATE TABLE IF NOT EXISTS `pos_payment_method` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `code` VARCHAR(30) NOT NULL,   -- CASH / TRANSFER / CARD / DEPOSIT
    `name` VARCHAR(80) NOT NULL,   -- Efectivo, Transferencia, Tarjeta, Depósito
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ux_pos_payment_method_code` (`code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pos_payment_method` (`code`, `name`, `is_active`) VALUES
                                                                   ('CASH', 'Efectivo', 1),
                                                                   ('TRANSFER', 'Transferencia', 1),
                                                                   ('CARD', 'Tarjeta', 1),
                                                                   ('DEPOSIT', 'Depósito', 1)
    ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `is_active`=VALUES(`is_active`);


-- =========================================================
-- 2) TIPOS DE MOVIMIENTO DE CAJA (what happened?) + direction
-- =========================================================
CREATE TABLE IF NOT EXISTS `pos_cash_movement_type` (
                                                        `id` INT NOT NULL AUTO_INCREMENT,
                                                        `code` VARCHAR(40) NOT NULL,            -- TICKET_PAYMENT, TICKET_REFUND, CASH_IN, CASH_OUT...
    `name` VARCHAR(120) NOT NULL,           -- (en español)
    `direction` ENUM('IN','OUT') NOT NULL,  -- IN suma, OUT resta
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ux_pos_cash_movement_type_code` (`code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pos_cash_movement_type` (`code`, `name`, `direction`, `is_active`) VALUES
                                                                                    ('TICKET_PAYMENT', 'Cobro de ticket', 'IN', 1),
                                                                                    ('TICKET_REFUND', 'Devolución de ticket', 'OUT', 1),
                                                                                    ('CASH_IN', 'Ingreso manual', 'IN', 1),
                                                                                    ('CASH_OUT', 'Egreso manual', 'OUT', 1)
    ON DUPLICATE KEY UPDATE
                         `name`=VALUES(`name`),
                         `direction`=VALUES(`direction`),
                         `is_active`=VALUES(`is_active`);


-- =========================================================
-- 3) TICKET (sale order)
-- ticket: customer_id,user_id,fecha,estado
-- + caja_id para amarrar al turno
-- =========================================================
CREATE TABLE IF NOT EXISTS `pos_ticket` (
                                            `id` BIGINT NOT NULL AUTO_INCREMENT,
                                            `caja_id` INT NOT NULL,          -- sesión/turno (caja.id)
                                            `customer_id` INT NOT NULL,
                                            `user_id` INT NOT NULL,
                                            `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                                            `estado` ENUM(
                                            'OPEN',        -- creado / editable
                                            'PENDING',     -- pendiente (opcional)
                                            'PAID',        -- pagado
                                            'CANCELLED',   -- anulado
                                            'DELIVERED'    -- entregado
) NOT NULL DEFAULT 'OPEN',

    `subtotal` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,
    `tax_value` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,
    `discount_value` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,
    `total` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,

    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    KEY `ix_pos_ticket_caja` (`caja_id`),
    KEY `ix_pos_ticket_user` (`user_id`),
    KEY `ix_pos_ticket_customer` (`customer_id`),
    KEY `ix_pos_ticket_estado_fecha` (`estado`, `fecha`),

    CONSTRAINT `fk_pos_ticket_caja`
    FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- =========================================================
-- 4) TICKET ITEMS (linked to menu_item)
-- CAMBIO NUEVO: tax por item (has_tax + tax_percentage + tax_value)
-- =========================================================
CREATE TABLE IF NOT EXISTS `pos_ticket_item` (
                                                 `id` BIGINT NOT NULL AUTO_INCREMENT,
                                                 `ticket_id` BIGINT NOT NULL,
                                                 `menu_item_id` INT NOT NULL,

                                                 `quantity` DECIMAL(10,4) NOT NULL DEFAULT 1,
    `unit_price` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,

    -- TAX per item
    `has_tax` TINYINT(1) NOT NULL DEFAULT 0,
    `tax_percentage` DECIMAL(10,4) NOT NULL DEFAULT 0.0000,
    -- totals per item
    `subtotal` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,   -- sin impuesto
    `notes` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),

    KEY `ix_pos_ticket_item_ticket` (`ticket_id`),
    KEY `ix_pos_ticket_item_menu_item` (`menu_item_id`),

    CONSTRAINT `fk_pos_ticket_item_ticket`
    FOREIGN KEY (`ticket_id`) REFERENCES `pos_ticket` (`id`) ON DELETE CASCADE,

    CONSTRAINT `fk_pos_ticket_item_menu_item`
    FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`id`) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- =========================================================
-- 5) CASH MOVEMENTS (money movements inside caja session)
-- linked to tickets (NO invoice)
-- =========================================================
CREATE TABLE IF NOT EXISTS `pos_cash_movement` (
                                                   `id` BIGINT NOT NULL AUTO_INCREMENT,

                                                   `caja_id` INT NOT NULL,
                                                   `owner_id` INT NOT NULL,

                                                   `movement_type_id` INT NOT NULL,        -- pos_cash_movement_type
                                                   `payment_method_id` INT NOT NULL,       -- pos_payment_method

                                                   `amount` DOUBLE(20,4) NOT NULL DEFAULT 0.0000,

    `ticket_id` BIGINT DEFAULT NULL,

    `details` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    KEY `ix_pos_cash_movement_caja` (`caja_id`),
    KEY `ix_pos_cash_movement_owner` (`owner_id`),
    KEY `ix_pos_cash_movement_type` (`movement_type_id`),
    KEY `ix_pos_cash_movement_method` (`payment_method_id`),
    KEY `ix_pos_cash_movement_ticket` (`ticket_id`),

    CONSTRAINT `fk_pos_cash_movement_caja`
    FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`) ON DELETE CASCADE,

    CONSTRAINT `fk_pos_cash_movement_type`
    FOREIGN KEY (`movement_type_id`) REFERENCES `pos_cash_movement_type` (`id`) ON DELETE RESTRICT,

    CONSTRAINT `fk_pos_cash_movement_method`
    FOREIGN KEY (`payment_method_id`) REFERENCES `pos_payment_method` (`id`) ON DELETE RESTRICT,

    CONSTRAINT `fk_pos_cash_movement_ticket`
    FOREIGN KEY (`ticket_id`) REFERENCES `pos_ticket` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET FOREIGN_KEY_CHECKS=1;
COMMIT;
