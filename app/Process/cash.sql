CREATE TABLE `business_by_cash`
(
    `id`          int(11) NOT NULL,
    `cash_id`     int(11) NOT NULL,
    `business_id` int(11) NOT NULL
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


CREATE TABLE `cash_reason`
(
    `id`          int(11) NOT NULL,
    `value`       varchar(150) NOT NULL,
    `description` text DEFAULT NULL,
    `state`       enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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


INSERT INTO `cash_reason`
    (`id`, `value`, `description`, `state`)
VALUES

-- =====================================================
-- INGRESOS
-- =====================================================

(1, 'VENTA EN EFECTIVO',
 'Ingreso de dinero proveniente de una venta realizada por la empresa.',
 'ACTIVE'),

(2, 'COBRO A CLIENTE',
 'Ingreso recibido por el cobro total o parcial de una cuenta pendiente de un cliente.',
 'ACTIVE'),

(3, 'ABONO DE CLIENTE',
 'Ingreso correspondiente a un abono realizado por un cliente.',
 'ACTIVE'),

(4, 'APORTE DEL PROPIETARIO',
 'Dinero entregado por el propietario o socio para incrementar temporal o permanentemente los fondos disponibles.',
 'ACTIVE'),

(5, 'FONDO PARA CAJA',
 'Dinero entregado para disponer de efectivo operativo o cambio en la caja.',
 'ACTIVE'),

(6, 'REPOSICIÓN DE CAJA',
 'Ingreso realizado para reponer dinero utilizado previamente por la caja.',
 'ACTIVE'),

(7, 'DEVOLUCIÓN DE PROVEEDOR',
 'Dinero recibido de un proveedor por devolución, ajuste o reintegro.',
 'ACTIVE'),

(8, 'REEMBOLSO RECIBIDO',
 'Dinero recibido como devolución o reembolso de un gasto previamente realizado.',
 'ACTIVE'),

(9, 'PRÉSTAMO RECIBIDO',
 'Ingreso de efectivo recibido en calidad de préstamo.',
 'ACTIVE'),

(10, 'TRANSFERENCIA ENTRE CAJAS - INGRESO',
 'Dinero recibido desde otra caja de la empresa.',
 'ACTIVE'),

(11, 'RETIRO DE BANCO PARA CAJA',
 'Dinero retirado de una cuenta bancaria e ingresado físicamente a la caja.',
 'ACTIVE'),

(12, 'INGRESO POR SERVICIOS',
 'Ingreso recibido por servicios prestados por la empresa.',
 'ACTIVE'),

(13, 'OTROS INGRESOS',
 'Ingreso de efectivo que no corresponde a otro motivo definido.',
 'ACTIVE'),


-- =====================================================
-- EGRESOS
-- =====================================================

(14, 'COMPRA A PROVEEDOR',
 'Salida de dinero para el pago de mercadería, materia prima, insumos o productos adquiridos a proveedores.',
 'ACTIVE'),

(15, 'PAGO A PROVEEDOR',
 'Pago total o parcial de una cuenta pendiente con un proveedor.',
 'ACTIVE'),

(16, 'ABONO A PROVEEDOR',
 'Abono realizado a una obligación pendiente con un proveedor.',
 'ACTIVE'),

(17, 'COMPRA DE INSUMOS',
 'Salida de dinero destinada a la compra de insumos necesarios para la operación.',
 'ACTIVE'),

(18, 'GASTOS DE TRANSPORTE',
 'Pago de transporte, movilización, taxi, combustible, flete u otros gastos relacionados.',
 'ACTIVE'),

(19, 'PAGO DE SERVICIOS BÁSICOS',
 'Pago de agua, energía eléctrica, telefonía, internet u otros servicios básicos.',
 'ACTIVE'),

(20, 'PAGO DE ARRIENDO',
 'Salida de dinero correspondiente al pago de arriendo de locales, oficinas, bodegas u otros espacios.',
 'ACTIVE'),

(21, 'PAGO A EMPLEADO',
 'Salida de dinero entregada a un trabajador por conceptos relacionados con la operación.',
 'ACTIVE'),

(22, 'ANTICIPO A EMPLEADO',
 'Dinero entregado anticipadamente a un trabajador.',
 'ACTIVE'),

(23, 'GASTOS DE ALIMENTACIÓN',
 'Salida de dinero por alimentación relacionada con actividades de la empresa.',
 'ACTIVE'),

(24, 'GASTOS DE LIMPIEZA',
 'Compra de productos o servicios destinados a limpieza y mantenimiento.',
 'ACTIVE'),

(25, 'GASTOS DE OFICINA',
 'Compra de suministros, papelería u otros materiales administrativos.',
 'ACTIVE'),

(26, 'MANTENIMIENTO Y REPARACIÓN',
 'Pago relacionado con mantenimiento o reparación de equipos, instalaciones o bienes de la empresa.',
 'ACTIVE'),

(27, 'DEVOLUCIÓN A CLIENTE',
 'Salida de dinero correspondiente a una devolución o reembolso realizado a un cliente.',
 'ACTIVE'),

(28, 'DEPÓSITO A BANCO',
 'Salida de efectivo de caja para ser depositado en una cuenta bancaria.',
 'ACTIVE'),

(29, 'TRANSFERENCIA ENTRE CAJAS - EGRESO',
 'Dinero entregado desde esta caja hacia otra caja de la empresa.',
 'ACTIVE'),

(30, 'RETIRO DEL PROPIETARIO',
 'Dinero retirado de la caja por el propietario o socio.',
 'ACTIVE'),

(31, 'PAGO DE PRÉSTAMO',
 'Salida de dinero destinada al pago o abono de un préstamo.',
 'ACTIVE'),

(32, 'PAGO DE IMPUESTOS O TASAS',
 'Salida de dinero destinada al pago de impuestos, tasas, contribuciones u obligaciones similares.',
 'ACTIVE'),

(33, 'GASTOS MENORES',
 'Pago de pequeños gastos necesarios para la operación cotidiana.',
 'ACTIVE'),

(34, 'OTROS EGRESOS',
 'Salida de efectivo que no corresponde a otro motivo definido.',
 'ACTIVE');



CREATE TABLE `cash_type`
(
    `id`               int(11) NOT NULL AUTO_INCREMENT,
    `code`             varchar(30)  NOT NULL,
    `value`            varchar(150) NOT NULL,
    `description`      text DEFAULT NULL,
    `requires_opening` tinyint(1) NOT NULL DEFAULT 0,
    `requires_closing` tinyint(1) NOT NULL DEFAULT 0,
    `state`            enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_cash_type_code` (`code`)
) ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;



INSERT INTO `cash_type`
(`code`, `value`, `description`, `requires_opening`, `requires_closing`)
VALUES ('GENERAL',
        'CAJA GENERAL',
        'Caja principal para la administración y control general de efectivo.',
        0,
        0),

       ('POINT_OF_SALE',
        'CAJA PUNTO DE VENTA',
        'Caja operativa utilizada por usuarios para ventas, ingresos y egresos.',
        1,
        1),

       ('PETTY_CASH',
        'CAJA CHICA',
        'Fondo destinado a gastos menores y pagos operativos de bajo valor.',
        0,
        0),

       ('COLLECTION',
        'CAJA DE RECAUDACIÓN',
        'Caja destinada principalmente a recepción y recaudación de valores.',
        1,
        1),

       ('OTHER',
        'OTRA',
        'Caja para una finalidad operativa distinta a las categorías existentes.',
        0,
        0);

CREATE TABLE `cash_by_type`
(
    `id`           int(11) NOT NULL AUTO_INCREMENT,
    `cash_id`      int(11) NOT NULL,
    `cash_type_id` int(11) NOT NULL,
    `created_at`   datetime NOT NULL,
    `update_at`    datetime DEFAULT NULL,

    PRIMARY KEY (`id`),

    UNIQUE KEY `uq_cash_by_type_cash` (`cash_id`),

    KEY            `idx_cash_by_type_type` (`cash_type_id`),

    CONSTRAINT `fk_cash_by_type_cash`
        FOREIGN KEY (`cash_id`)
            REFERENCES `cash` (`id`),

    CONSTRAINT `fk_cash_by_type_type`
        FOREIGN KEY (`cash_type_id`)
            REFERENCES `cash_type` (`id`)
) ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;

CREATE TABLE `cash_session`
(
    `id`              int(11) NOT NULL AUTO_INCREMENT,

    `cash_by_user_id` int(11) NOT NULL,

    `opening_amount`  double(20, 4
) NOT NULL DEFAULT 0.0000,
    `opening_date` datetime NOT NULL,
    `opening_details` text DEFAULT NULL,

    `expected_amount` double(20,4) DEFAULT NULL,
    `closing_amount` double(20,4) DEFAULT NULL,
    `difference_amount` double(20,4) DEFAULT NULL,

    `closing_date` datetime DEFAULT NULL,
    `closing_details` text DEFAULT NULL,

    `state` enum('OPEN','CLOSED') NOT NULL DEFAULT 'OPEN',

    `created_at` datetime NOT NULL,
    `update_at` datetime DEFAULT NULL,

    PRIMARY KEY (`id`),

    KEY `idx_cash_session_cash_by_user`
        (`cash_by_user_id`),

    KEY `idx_cash_session_state`
        (`state`),

    CONSTRAINT `fk_cash_session_cash_by_user`
        FOREIGN KEY (`cash_by_user_id`)
        REFERENCES `cash_by_user` (`id`)
) ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;

-- =========================================================
-- 1. CAJA
-- cash.user_id = usuario que creó el catálogo
-- =========================================================

INSERT INTO `cash`
(`id`,
 `accounting_account_id`,
 `name`,
 `details`,
 `user_id`,
 `state`,
 `amount_current`,
 `created_at`,
 `update_at`)
VALUES (1,
        1, -- REEMPLAZAR por la cuenta contable de Caja/Efectivo de empresa 42
        'CAJA PUNTO DE VENTA',
        'Caja operativa para ventas, ingresos y egresos del punto de venta.',
        1,
        'ACTIVE',
        0.0000,
        NOW(),
        NOW());


-- =========================================================
-- 2. RELACIONAR CAJA CON EMPRESA
-- Empresa: 42
-- =========================================================

INSERT INTO `business_by_cash`
(`id`,
 `cash_id`,
 `business_id`)
VALUES (1,
        1,
        42);


-- =========================================================
-- 3. ASIGNAR USUARIO OPERADOR A LA CAJA
-- user_id = 1
-- business_by_cash_id = 1
-- =========================================================

INSERT INTO `cash_by_user`
(`id`,
 `user_id`,
 `business_by_cash_id`,
 `owner_id`,
 `entidad_data_id`)
VALUES (1,
        41,
        1,
        1, -- REEMPLAZAR si owner_id tiene otro significado/valor
        1 -- REEMPLAZAR por entidad_data_id correspondiente
       );


-- =========================================================
-- 4. CONFIGURAR FORMA DE PAGO EN EFECTIVO
--
-- types_payments.id = 1
-- SIN UTILIZACION DEL SISTEMA FINANCIERO
-- =========================================================

INSERT INTO `cash_by_transaction_management`
(`id`,
 `created_at`,
 `update_at`,
 `state`,
 `types_payments_id`,
 `business_by_cash_id`,
 `entidad_data_id`)
VALUES (1,
        NOW(),
        NOW(),
        'ACTIVE',
        1,
        1,
        1 -- REEMPLAZAR por entidad_data_id correspondiente
       );

-- =========================================================
-- TIPO DE CAJA
-- Caja #1 -> POINT_OF_SALE
-- =========================================================

INSERT INTO `cash_by_type`
(`cash_id`,
 `cash_type_id`,
 `created_at`,
 `update_at`)
VALUES (1, -- cash.id = CAJA PUNTO DE VENTA
        2, -- cash_type.id = POINT_OF_SALE
        NOW(),
        NOW());


ALTER TABLE `cash_by_movement`
    ADD COLUMN `cash_session_id` int(11) DEFAULT NULL
AFTER `cash_id`;

ALTER TABLE `cash_by_movement`
    ADD KEY `idx_cash_by_movement_session`
    (`cash_session_id`);

ALTER TABLE `cash_by_movement`
    ADD CONSTRAINT `fk_cash_by_movement_session`
        FOREIGN KEY (`cash_session_id`)
            REFERENCES `cash_session` (`id`);
