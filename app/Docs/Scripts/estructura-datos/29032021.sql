-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-03-2021 a las 14:58:51
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `arraya5_`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_account`
--

DROP TABLE IF EXISTS `accounting_account`;
CREATE TABLE IF NOT EXISTS `accounting_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `accounting_account_type_id` int(11) NOT NULL,
  `accounting_level_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `parent_key` int(11) DEFAULT NULL,
  `has_parent` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL,
  `movement` int(11) NOT NULL,
  `rfc` int(11) NOT NULL,
  `cost_center` int(11) NOT NULL,
  `base_amount` int(11) NOT NULL,
  `base_amount_percentage` float DEFAULT NULL,
  `base_amount_value` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounting_account_accounting_level1_idx` (`accounting_level_id`),
  KEY `fk_accounting_account_accounting_account_type1_idx` (`accounting_account_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_account_by_balances`
--

DROP TABLE IF EXISTS `accounting_account_by_balances`;
CREATE TABLE IF NOT EXISTS `accounting_account_by_balances` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Contabilidad cuenta saldos',
  `register_manager_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `amount` decimal(10,4) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `manager_type` int(11) NOT NULL COMMENT '1=INGRESO 0=EGRESO',
  `accounting_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounting_account_balances_accounting_account1_idx` (`accounting_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_account_type`
--

DROP TABLE IF EXISTS `accounting_account_type`;
CREATE TABLE IF NOT EXISTS `accounting_account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accounting_account_type`
--

INSERT INTO `accounting_account_type` (`id`, `value`, `description`, `status`) VALUES
(1, 'ACTIVE', NULL, 'ACTIVE'),
(2, 'Pasivo', NULL, 'ACTIVE'),
(3, 'Patrimonio', NULL, 'ACTIVE'),
(4, 'Ingresos', NULL, 'ACTIVE'),
(5, 'Costos y Gastos', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_config_modules_account_by_account`
--

DROP TABLE IF EXISTS `accounting_config_modules_account_by_account`;
CREATE TABLE IF NOT EXISTS `accounting_config_modules_account_by_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accounting_account_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `code` varchar(45) NOT NULL,
  `accounting_config_modules_types_id` int(11) NOT NULL,
  `type_of_income` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_accounting_config_modules_account_by_modules_accounting__idx` (`accounting_config_modules_types_id`),
  KEY `fk_accounting_config_modules_account_by_account_accounting__idx` (`accounting_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_config_modules_types`
--

DROP TABLE IF EXISTS `accounting_config_modules_types`;
CREATE TABLE IF NOT EXISTS `accounting_config_modules_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accounting_config_modules_types`
--

INSERT INTO `accounting_config_modules_types` (`id`, `value`, `description`, `status`) VALUES
(1, 'CAJA Y BANCOS', NULL, 'ACTIVE'),
(2, 'COMPRAS', NULL, 'ACTIVE'),
(3, 'INVENTARIOS', NULL, 'ACTIVE'),
(4, 'VENTAS', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting_level`
--

DROP TABLE IF EXISTS `accounting_level`;
CREATE TABLE IF NOT EXISTS `accounting_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `color` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accounting_level`
--

INSERT INTO `accounting_level` (`id`, `value`, `description`, `status`, `color`) VALUES
(1, '1', 'NIVEL 1', 'ACTIVE', '#6b0542'),
(2, '2', 'NIVEL 2', 'ACTIVE', '#f00404'),
(3, '3', 'NIVEL 3', 'ACTIVE', '#b30a0a'),
(4, '4', 'NIVEL 4', 'ACTIVE', '#80082c'),
(5, '5', 'NIVEL 5', 'ACTIVE', '#8a0808'),
(6, '6', 'NIVEL 6', 'ACTIVE', '#d90c9f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_gamification`
--

DROP TABLE IF EXISTS `account_gamification`;
CREATE TABLE IF NOT EXISTS `account_gamification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `balance_available_bee` int(11) NOT NULL,
  `balance_available_queen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_gamification_by_movement`
--

DROP TABLE IF EXISTS `account_gamification_by_movement`;
CREATE TABLE IF NOT EXISTS `account_gamification_by_movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `account_gamification_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=Cash or check deposit(DE) - I\n1= Cash withdrawal(EX)-O\n2=Banking expenses(GB)-O\n3=Collection of card coupons(CC)-I\n4=Negotiated checks(NE)-I\n',
  `input_movement` int(11) NOT NULL COMMENT '0=OUTPUT\n1=INPUT',
  `description` text NOT NULL,
  `user_transaction_id` int(11) NOT NULL COMMENT 'IT CAN BE A NULL ID ONLY IF IT IS OWN OF THE SYSTEM AND IT IS DONE X BEEHIVE',
  `type_money` int(11) NOT NULL DEFAULT '0' COMMENT '0=BEE\n1=QUEEN',
  PRIMARY KEY (`id`),
  KEY `fk_account_by_movement_account_gamification1_idx` (`account_gamification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_gamification_movement_by_business`
--

DROP TABLE IF EXISTS `account_gamification_movement_by_business`;
CREATE TABLE IF NOT EXISTS `account_gamification_movement_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_gamification_by_movement_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_account_gamification_movement_by_business_account_gamifi_idx` (`account_gamification_by_movement_id`),
  KEY `fk_account_gamification_movement_by_business_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `link` varchar(125) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=manager is link\n1=METHOD \n2=ROOT init menu root',
  `description` text NOT NULL,
  `type_item` int(11) NOT NULL DEFAULT '1' COMMENT '1=HAS CHILDRENS\n0=NOT CHILDREN',
  PRIMARY KEY (`id`),
  KEY `fk_actions_actions1_idx` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actions`
--

INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`) VALUES
(1, 'Inicio', 'home', NULL, 1, 'remixicon-dashboard-line', 1, 'Pizzarra que permite conocer información necesaria de la información que al cliente le interese', 0),
(2, 'Cuenta', 'customer/manager', NULL, 2, 'remixicon-dashboard-line', 1, 'Pizarra que permite conocer la información que al propietario del sistema le interese, esto es un resumento de todo movimiento y que dando clic en cada acción podra tener una prespectiva especifica de los movimientos del sistema con respecto a la empresa', 0),
(3, 'Rbac', 'user', NULL, 3, ' fas fa-user-cog', 2, 'Módulo que permite la administración de los usuarios que van a ingresar en el sistema, esto abarca desde la creación de usuarios, los roles que los usuarios pueden tener en el sistema y los accesos que los usuarios pueden tener con sus roles especificados.', 1),
(4, 'Gestión Users', 'user', 3, 4, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(5, 'Usuarios', 'user', 4, 5, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(6, 'Grid', 'user/list', 5, 6, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(7, 'Guardar/Actualizar', 'user/save ', 5, 7, 'not-icon', 1, 'Creación/Actualización de información', 1),
(8, 'Editar ', 'user/form', 5, 8, 'not-icon', 1, 'Formulario de Información para editar', 1),
(9, 'Formulario-Lista Roles', 'role/list/select', 5, 9, 'not-icon', 1, 'Obtiene los roles  existentes', 1),
(10, 'Formulario-Unique User', 'user/unique-username', 5, 10, 'not-icon', 1, 'Verifica si es unico el usuario asignar', 1),
(11, 'Formulario-Unique Email', 'user/unique-email', 5, 11, 'not-icon', 1, 'Verifica si es unico el email asignar', 1),
(12, 'Formulario-Verify Password', 'user/check-password-old', 5, 12, 'not-icon', 1, 'Verifica si es la contrasenia anterior', 1),
(13, 'Add User ', 'user/form', 5, 13, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(14, 'Gestión  Roles', 'role', 3, 14, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(15, 'Roles', 'role', 14, 15, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(16, 'Grid', 'role/list', 15, 16, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(17, 'Guardar/Actualizar', 'role/save', 15, 17, 'not-icon', 1, 'Creación/Actualización de información', 1),
(18, 'Editar ', 'role/form', 15, 18, 'not-icon', 1, 'Formulario de Información para editar', 1),
(19, 'Add', 'role/form', 15, 19, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(20, 'Gestión  Menu ', 'actions/manager', 3, 20, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(21, 'Menu Procesos', 'actions/manager', 20, 21, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(22, 'Grid', 'actions/admin', 21, 22, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(23, 'Guardar/Actualizar', 'actions/save', 21, 23, 'not-icon', 1, 'Creación/Actualización de información', 1),
(24, 'Editar ', 'none', 21, 24, 'not-icon', 1, 'Formulario de Información para editar', 1),
(25, 'Form-Parents Procesos Search', 'actions/listActionsParent', 21, 25, 'not-icon', 1, 'Permite obtener el listado Acciónes o Procesos ya agregados.', 1),
(26, 'Contabilidad', 'tax/manager', NULL, 26, 'fas fa-cash-register', 2, 'Todo La administración de este modulo de contabilidad va enfocado a sus herramientas de configuración, permiten conocer ciertos catalogos que no son totalmente variables pero que pueden ser cambiados alguna vez en la trayectoria del sistema.', 1),
(27, 'Gestión Iva', 'tax/manager', 26, 27, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(28, 'Admin. Iva', 'tax/manager', 27, 28, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(29, 'Grid', 'tax/admin', 28, 29, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(30, 'Guardar/Actualizar', 'tax/save', 28, 30, 'not-icon', 1, 'Creación/Actualización de información', 1),
(31, 'Editar ', '0', 28, 31, 'not-icon', 1, 'Formulario de Información para editar', 1),
(32, 'Ges. Contabilidad Cuentas', 'accountingAccount/manager', 26, 32, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(33, 'Adm. Contabilidad Cuentas', 'accountingAccount/manager', 32, 33, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(34, 'Grid', 'accountingAccount/admin', 33, 34, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(35, 'Guardar/Actualizar', 'accountingAccount/save', 33, 35, 'not-icon', 1, 'Creación/Actualización de información', 1),
(36, 'Editar ', '0', 33, 36, 'not-icon', 1, 'Formulario de Información para editar', 1),
(37, 'Form-Tipos de Cuenta', 'accountingAccountType/listSelect2', 33, 37, 'not-icon', 1, 'Permite obtener el listado de TIPOS de CUENTA', 1),
(38, 'Form-Niveles', 'accountingLevel/listSelect2', 33, 38, 'not-icon', 1, 'Permite obtener el listado de TIPOS de NIVELES CUENTA', 1),
(39, 'Ges. Contabilidad - Tipos de Ruc', 'rucType/manager', 26, 39, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(40, 'Contabilidad - Tipos de Ruc', 'rucType/manager', 39, 40, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(41, 'Grid', 'rucType/admin', 40, 41, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(42, 'Guardar/Actualizar', 'rucType/save', 40, 42, 'not-icon', 1, 'Creación/Actualización de información', 1),
(43, 'Editar ', '0', 40, 43, 'not-icon', 1, 'Formulario de Información para editar', 1),
(44, 'Ges. Contabilidad - Modulos Tipos', 'accountingConfigModulesTypes/manager', 26, 44, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(45, 'Modulos Tipo', 'accountingConfigModulesTypes/manager', 44, 45, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(46, 'Grid', 'accountingConfigModulesTypes/admin', 45, 46, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(47, 'Guardar/Actualizar', 'accountingConfigModulesTypes/save', 45, 47, 'not-icon', 1, 'Creación/Actualización de información', 1),
(48, 'Editar ', 'none', 45, 48, 'not-icon', 1, 'Formulario de Información para editar', 1),
(49, 'Contabilidad - Niveles', 'accountingLevel/manager', 26, 49, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(50, 'Contabilidad - Niveles', 'accountingLevel/manager', 49, 50, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(51, 'Grid', 'accountingLevel/admin', 50, 51, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(52, 'Guardar/Actualizar', 'accountingLevel/save', 50, 52, 'not-icon', 1, 'Creación/Actualización de información', 1),
(53, 'Editar ', '0', 50, 53, 'not-icon', 1, 'Formulario de Información para editar', 1),
(54, 'Contabilidad - Modulos Contables', 'accountingConfigModulesAccountByAccount/manager', 26, 54, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(55, 'Contabilidad - Modulos Contables', 'accountingConfigModulesAccountByAccount/manager', 54, 55, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(56, 'Grid', 'accountingConfigModulesAccountByAccount/admin', 55, 56, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(57, 'Guardar/Actualizar', 'accountingConfigModulesAccountByAccount/save', 55, 57, 'not-icon', 1, 'Creación/Actualización de información', 1),
(58, 'Editar ', '0', 55, 58, 'not-icon', 1, 'Formulario de Información para editar', 1),
(59, 'Form-Tipo Cuentas Contables Search', 'accountingAccount/listSelect2', 55, 59, 'not-icon', 1, 'Permite obtener el listado de cuentas contables', 1),
(60, 'Form-Tipo Modulos Tipos Search', 'accountingConfigModulesTypes/listSelect2', 55, 60, 'not-icon', 1, 'Permite obtener el listado de modulos', 1),
(61, 'Ubicación', 'country', NULL, 61, ' fas fa-map-marked-alt', 2, 'Catalogo que permite manipular la información que apareceran en los formularios de creación de personas, clientes, o empresas donde solicitan mostrar su ubicación. Esta información debe ser actualizada por personas con información media o avanzada en el sistema', 1),
(62, 'Ges. Pais', 'country', 61, 62, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(63, 'Administración Pais', 'country', 62, 63, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(64, 'Grid', 'country/list', 63, 64, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(65, 'Guardar/Actualizar', 'country/save', 63, 65, 'not-icon', 1, 'Creación/Actualización de información', 1),
(66, 'Editar ', 'country/form', 63, 66, 'not-icon', 1, 'Formulario de Información para editar', 1),
(67, 'Add ', 'country/form', 63, 67, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(68, 'Provincia/Estado', 'province', 61, 68, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(69, 'Administración Provincia/Estado', 'province', 68, 69, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(70, 'Grid', 'province/list', 69, 70, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(71, 'Guardar/Actualizar', 'province/save', 69, 71, 'not-icon', 1, 'Creación/Actualización de información', 1),
(72, 'Editar ', 'province/form', 69, 72, 'not-icon', 1, 'Formulario de Información para editar', 1),
(73, 'Add ', 'province/form', 69, 73, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(74, 'Form-Pais Search', 'country/list/select', 69, 74, 'not-icon', 1, 'Permite obtener el listado de paises', 1),
(75, 'Ciudad', 'city', 61, 75, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(76, 'Administración Ciudad', 'city', 75, 76, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(77, 'Grid', 'city/list', 76, 77, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(78, 'Guardar/Actualizar', 'city/save', 76, 78, 'not-icon', 1, 'Creación/Actualización de información', 1),
(79, 'Editar ', 'city/form', 76, 79, 'not-icon', 1, 'Formulario de Información para editar', 1),
(80, 'Add ', 'city/form', 76, 80, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(81, 'Form-Pais Search', 'country/list/select', 76, 81, 'not-icon', 1, 'Permite obtener el listado de paises', 1),
(82, 'Form-Provincia/Estado Search', 'province/list/select', 76, 82, 'not-icon', 1, 'Permite obtener el listado de PROVINCIAS/ESTADOS', 1),
(83, 'Zona', 'zone', 61, 83, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(84, 'Administración Zona', 'zone', 83, 84, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(85, 'Grid', 'zone/list', 84, 85, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(86, 'Guardar/Actualizar', 'zone/save', 84, 86, 'not-icon', 1, 'Creación/Actualización de información', 1),
(87, 'Editar ', 'zone/form', 84, 87, 'not-icon', 1, 'Formulario de Información para editar', 1),
(88, 'Add', 'zone/form', 84, 88, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(89, 'Form-Pais Search', 'country/list/select', 84, 89, 'not-icon', 1, 'Permite obtener el listado de paises', 1),
(90, 'Form-Provincia/Estado Search', 'province/list/select', 84, 90, 'not-icon', 1, 'Permite obtener el listado de PROVINCIAS/ESTADOS', 1),
(91, 'Form-Ciudad Search', 'city/list/select', 84, 91, 'not-icon', 1, 'Permite obtener el listado de CIUDADES', 1),
(92, 'Form-Data Map Get', 'zone/list/map', 84, 92, 'not-icon', 1, 'Permite obtener el listado ZONAS los mapas', 1),
(93, 'Guardar/Actualizar Map', 'zone/save/zones', 84, 93, 'not-icon', 1, 'Creación/Actualización de información', 1),
(94, 'Config Envios', 'shippingRateKindsOfWay/manager', NULL, 94, ' fas fa-truck', 2, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(95, 'Formas de Envio', 'shippingRateKindsOfWay/manager', 94, 95, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(96, 'Administración de Envio', 'shippingRateKindsOfWay/manager', 95, 96, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(97, 'Grid', 'shippingRateKindsOfWay/admin', 96, 97, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(98, 'Guardar/Actualizar', 'shippingRateKindsOfWay/save', 96, 98, 'not-icon', 1, 'Creación/Actualización de información', 1),
(99, 'Editar ', 'none', 96, 99, 'not-icon', 1, 'Formulario de Información para editar', 1),
(100, 'Empresas de Envio', 'shippingRateBusiness/manager', 94, 100, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(101, 'Gestión de Empresas de Envio', 'shippingRateBusiness/manager', 100, 101, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(102, 'Grid', 'shippingRateBusiness/admin', 101, 102, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(103, 'Guardar/Actualizar', 'shippingRateBusiness/save', 101, 103, 'not-icon', 1, 'Creación/Actualización de información', 1),
(104, 'Editar ', '0', 101, 104, 'not-icon', 1, 'Formulario de Información para editar', 1),
(105, 'Gestión de Servicios de Envio', 'shippingRateServices/admin', 101, 105, 'not-icon', 1, 'Gestión de Servicios de Envio', 1),
(106, 'Gestión de Factor Conversión', 'shippingRateBusinessByConversionFactor/admin', 101, 106, 'not-icon', 1, 'Gestión de Factor Conversión', 1),
(107, 'Empresas de Envio - Gestión de Servicios de Envio', 'shippingRateServices/admin', 94, 107, 'not-icon', 0, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(108, 'Grid', 'shippingRateServices/admin', 107, 108, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(109, 'Guardar/Actualizar', 'shippingRateServices/save', 108, 109, 'not-icon', 1, 'Creación/Actualización de información', 1),
(110, 'Editar ', '0', 108, 110, 'not-icon', 1, 'Formulario de Información para editar', 1),
(111, 'Empresas de Envio - Gestión Conversión Factor', 'shippingRateBusinessByConversionFactor/admin', 94, 111, 'not-icon', 0, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(112, 'Grid', 'shippingRateBusinessByConversionFactor/admin', 111, 112, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(113, 'Guardar/Actualizar', 'shippingRateBusinessByConversionFactor/save', 112, 113, 'not-icon', 1, 'Creación/Actualización de información', 1),
(114, 'Editar ', '0', 112, 114, 'not-icon', 1, 'Formulario de Información para editar', 1),
(115, 'Form Servicios Search', 'shippingRateServices/listSelect2', 112, 115, 'not-icon', 1, 'Permite obtener el listado de servicios', 1),
(116, 'Form Formas de Envio Search', 'shippingRateKindsOfWay/listSelect2', 112, 116, 'not-icon', 1, 'Permite obtener el listado de FORMAS de NVIO', 1),
(117, 'Form Medida Search', 'productMeasureType/listSelect2', 112, 117, 'not-icon', 1, 'Permite obtener el listado de medidas', 1),
(118, 'Información Adiciónal', 'informationMailType/manager', NULL, 118, 'fas fa-address-card', 2, 'Son catalogos que influyen directamente en los formularios de contactos. Por lo tanto si van a crear nuevos tipos de datos dentro los listados actuales que se tienen como redes sociales, información de nuevas lineas o tipos de telefonos, email o direcciónes esta opción permite actualizar incrementar y eliminar esa información', 1),
(119, 'Tipo de Email', 'informationMailType/manager', 118, 119, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(120, 'Administración Tipo de Email', 'informationMailType/manager', 119, 120, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(121, 'Grid', 'informationMailType/admin', 120, 121, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(122, 'Guardar/Actualizar', 'informationMailType/save', 120, 122, 'not-icon', 1, 'Creación/Actualización de información', 1),
(123, 'Editar ', '0', 120, 123, 'not-icon', 1, 'Formulario de Información para editar', 1),
(124, 'Tipos de Redes Sociales', 'informationSocialNetworkType/manager', 118, 124, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(125, 'Administración Tipos de Redes Sociales', 'informationSocialNetworkType/manager', 124, 125, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(126, 'Grid', 'informationSocialNetworkType/admin', 125, 126, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(127, 'Guardar/Actualizar', 'informationSocialNetworkType/save', 125, 127, 'not-icon', 1, 'Creación/Actualización de información', 1),
(128, 'Editar ', '0', 125, 128, 'not-icon', 1, 'Formulario de Información para editar', 1),
(129, 'Tipos de Telefono', 'informationPhoneType/manager', 118, 129, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(130, 'Administración Tipos de Telefono', 'informationPhoneType/manager', 129, 130, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(131, 'Grid', 'informationPhoneType/admin', 130, 131, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(132, 'Guardar/Actualizar', 'informationPhoneType/save', 130, 132, 'not-icon', 1, 'Creación/Actualización de información', 1),
(133, 'Editar ', 'none-link', 130, 133, 'not-icon', 1, 'Formulario de Información para editar', 1),
(134, 'Tipos de Dirección', 'informationAddressType/manager', 118, 134, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(135, 'Administración Tipos de Dirección', 'informationAddressType/manager', 134, 135, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(136, 'Grid', 'informationAddressType/admin', 135, 136, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(137, 'Guardar/Actualizar', 'informationAddressType/save', 135, 137, 'not-icon', 1, 'Creación/Actualización de información', 1),
(138, 'Editar ', '0', 135, 138, 'not-icon', 1, 'Formulario de Información para editar', 1),
(139, 'Config Productos', 'productCategory/manager', NULL, 139, 'fab fa-product-hunt', 2, 'Todo producto tiene caracteristicas directas e indirectas que influyen para su creación. En este modulo esa información puede ser manipulada, desde la creación de una categoria nueva para un producto o productos especificos, sub categorias, en fin. Toda información adiciónal que el producto puede tener, sera manipulado desde este modulo', 1),
(140, 'Categorias Productos', 'productCategory/manager', 139, 140, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(141, 'Administración Categorias Productos', 'productCategory/manager', 140, 141, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(142, 'Grid', 'productCategory/admin', 141, 142, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(143, 'Guardar/Actualizar', 'productCategory/save', 141, 143, 'not-icon', 1, 'Creación/Actualización de información', 1),
(144, 'Editar ', '0', 141, 144, 'not-icon', 1, 'Formulario de Información para editar', 1),
(145, 'Categorias Productos-Traducción', 'languageProductCategory/manager', 139, 145, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(146, 'Administración Categorias Productos-Traducción', 'languageProductCategory/manager', 145, 146, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(147, 'Grid', 'languageProductCategory/admin', 146, 147, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(148, 'Delete   ', 'languageProductCategory/delete', 146, 148, 'not-icon', 1, 'Permite obtener Eliminar registro', 1),
(149, 'Guardar/Actualizar', 'languageProductCategory/save', 146, 149, 'not-icon', 1, 'Creación/Actualización de información', 1),
(150, 'Editar ', '0', 146, 150, 'not-icon', 1, 'Formulario de Información para editar', 1),
(151, 'Form  Idiomas Search', 'language/listSelect2', 146, 151, 'not-icon', 1, 'Permite obtener el listado de medidas', 1),
(152, 'Subcategorias Productos', 'productSubcategory/manager', 139, 152, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(153, 'Administración Subcategorias Productos', 'productSubcategory/manager', 152, 153, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(154, 'Grid', 'productSubcategory/admin', 153, 154, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(155, 'Guardar/Actualizar', 'productSubcategory/save', 153, 155, 'not-icon', 1, 'Creación/Actualización de información', 1),
(156, 'Editar ', '0', 153, 156, 'not-icon', 1, 'Formulario de Información para editar', 1),
(157, 'Form  Categorias Search', 'productCategory/listSelect2', 153, 157, 'not-icon', 1, 'Permite obtener el listado de medidas', 1),
(158, 'Subcategorias Productos-Traducción', 'languageProductSubcategory/admin', 139, 158, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(159, 'Administración Subcategorias Productos-Traducción', 'languageProductSubcategory/admin', 158, 159, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(160, 'Grid', 'languageProductSubcategory/admin', 159, 160, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(161, 'Delete  ', 'languageProductSubcategory/delete', 159, 161, 'not-icon', 1, 'Permite obtener Eliminar registro', 1),
(162, 'Guardar/Actualizar', 'languageProductSubcategory/save', 159, 162, 'not-icon', 1, 'Creación/Actualización de información', 1),
(163, 'Editar ', '0', 159, 163, 'not-icon', 1, 'Formulario de Información para editar', 1),
(164, 'Form  Idiomas Search', 'language/listSelect2', 159, 164, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(165, 'Colores', 'productColor/manager', 139, 165, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(166, 'Administración Colores', 'productColor/manager', 165, 166, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(167, 'Grid', 'productColor/admin', 166, 167, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(168, 'Guardar/Actualizar', 'productColor/save', 166, 168, 'not-icon', 1, 'Creación/Actualización de información', 1),
(169, 'Editar ', '0', 166, 169, 'not-icon', 1, 'Formulario de Información para editar', 1),
(170, 'Colores-Traducción', 'languageProductColor/manager', 139, 170, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(171, 'Administración Colores-Traducción', 'languageProductColor/manager', 170, 171, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(172, 'Grid', 'languageProductColor/admin', 171, 172, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(173, 'Delete', 'languageProductColor/delete', 171, 173, 'not-icon', 1, 'Permite obtener Eliminar registro', 1),
(174, 'Guardar/Actualizar', 'languageProductColor/save', 171, 174, 'not-icon', 1, 'Creación/Actualización de información', 1),
(175, 'Editar ', '0', 171, 175, 'not-icon', 1, 'Formulario de Información para editar', 1),
(176, 'Form  Idiomas Search', 'language/listSelect2', 171, 176, 'not-icon', 1, 'Permite obtener el listado de idiomas', 1),
(177, 'Tamaños', 'productSizes/manager', 139, 177, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(178, 'Administración Tamaños', 'productSizes/manager', 177, 178, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(179, 'Grid', 'productSizes/admin', 178, 179, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(180, 'Guardar/Actualizar', 'productSizes/save', 178, 180, 'not-icon', 1, 'Creación/Actualización de información', 1),
(181, 'Editar ', '0', 178, 181, 'not-icon', 1, 'Formulario de Información para editar', 1),
(182, 'Marcas', 'productTrademark/manager', 139, 182, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(183, 'Administración Marcas', 'productTrademark/manager', 182, 183, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(184, 'Grid', 'productTrademark/admin', 183, 184, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(185, 'Guardar/Actualizar', 'productTrademark/save', 183, 185, 'not-icon', 1, 'Creación/Actualización de información', 1),
(186, 'Editar ', '0', 183, 186, 'not-icon', 1, 'Formulario de Información para editar', 1),
(187, 'Medidas', 'productMeasureType/manager', 139, 187, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(188, 'Administración Medidas', 'productMeasureType/manager', 187, 188, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(189, 'Grid', 'productMeasureType/admin', 188, 189, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(190, 'Guardar/Actualizar', 'productMeasureType/save', 188, 190, 'not-icon', 1, 'Creación/Actualización de información', 1),
(191, 'Editar ', '0', 188, 191, 'not-icon', 1, 'Formulario de Información para editar', 1),
(192, 'Medidas-Traducción', 'languageProductMeasureType/manager', 139, 192, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(193, 'Administración Medidas-Traducción', 'languageProductMeasureType/manager', 192, 193, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(194, 'Grid', 'languageProductMeasureType/admin', 193, 194, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(195, 'Delete  ', 'languageProductMeasureType/delete', 193, 195, 'not-icon', 1, 'Permite obtener Eliminar registro', 1),
(196, 'Guardar/Actualizar', 'languageProductMeasureType/save', 193, 196, 'not-icon', 1, 'Creación/Actualización de información', 1),
(197, 'Editar ', '0', 193, 197, 'not-icon', 1, 'Formulario de Información para editar', 1),
(198, 'Form  Idiomas Search', 'language/listSelect2', 193, 198, 'not-icon', 1, 'Permite obtener el listado de medidas', 1),
(199, 'Persona', 'peopleNationality/manager', NULL, 199, ' fas fa-user-clock', 2, 'Para poder crear el registro de una persona en el sistema, se debe tener en cuenta cierta información para esto debemos manipular aquí información de catalogo como son todos los detallados en este modulo', 1),
(200, 'Naciónalidad', 'peopleNationality/manager', 199, 200, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(201, 'Administración Naciónalidad', 'peopleNationality/manager', 200, 201, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(202, 'Grid', 'peopleNationality/admin', 201, 202, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(203, 'Guardar/Actualizar', 'peopleNationality/save', 201, 203, 'not-icon', 1, 'Creación/Actualización de información', 1),
(204, 'Editar ', '0', 201, 204, 'not-icon', 1, 'Formulario de Información para editar', 1),
(205, 'Tipo de Identificación', 'peopleTypeIdentification/manager', 199, 205, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(206, 'Administración Tipo de Identificación', 'peopleTypeIdentification/manager', 205, 206, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(207, 'Grid', 'peopleTypeIdentification/admin', 206, 207, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(208, 'Guardar/Actualizar', 'peopleTypeIdentification/save', 206, 208, 'not-icon', 1, 'Creación/Actualización de información', 1),
(209, 'Editar ', '0', 206, 209, 'not-icon', 1, 'Formulario de Información para editar', 1),
(210, 'Profesión', 'peopleProfession/manager', 199, 210, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(211, 'Administración Profesión', 'peopleProfession/manager', 210, 211, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(212, 'Grid', 'peopleProfession/admin', 211, 212, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(213, 'Guardar/Actualizar', 'peopleProfession/save', 211, 213, 'not-icon', 1, 'Creación/Actualización de información', 1),
(214, 'Editar ', '0', 211, 214, 'not-icon', 1, 'Formulario de Información para editar', 1),
(215, 'Genero', 'peopleGender/manager', 199, 215, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(216, 'Administración Genero', 'peopleGender/manager', 215, 216, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(217, 'Grid', 'peopleGender/admin', 216, 217, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(218, 'Guardar/Actualizar', 'peopleGender/save', 216, 218, 'not-icon', 1, 'Creación/Actualización de información', 1),
(219, 'Editar ', '0', 216, 219, 'not-icon', 1, 'Formulario de Información para editar', 1),
(220, 'Odontograma', 'referencePiecePosition', NULL, 220, 'fas fa-tooth', 2, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(221, 'Piezas Posiciónes', 'referencePiecePosition', 220, 221, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(222, 'Administración Piezas Posiciónes', 'referencePiecePosition', 221, 222, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(223, 'Grid', 'referencePiecePosition/list', 222, 223, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(224, 'Guardar/Actualizar', 'referencePiecePosition/save', 222, 224, 'not-icon', 1, 'Creación/Actualización de información', 1),
(225, 'Editar ', 'referencePiecePosition/form', 222, 225, 'not-icon', 1, 'Formulario de Información para editar', 1),
(226, 'Add ', 'referencePiecePosition/form', 222, 226, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(227, 'Piezas Dentales', 'dentalPiece', 220, 227, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(228, 'Administración Piezas Dentales', 'dentalPiece', 227, 228, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(229, 'Grid', 'dentalPiece/list', 228, 229, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(230, 'Guardar/Actualizar', 'dentalPiece/save', 228, 230, 'not-icon', 1, 'Creación/Actualización de información', 1),
(231, 'Editar ', 'dentalPiece/form', 228, 231, 'not-icon', 1, 'Formulario de Información para editar', 1),
(232, 'Add ', 'dentalPiece/form', 228, 232, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(233, 'Piezas Referencia', 'referencePiece', 220, 233, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(234, 'Administración Piezas Referencia', 'referencePiece', 233, 234, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(235, 'Grid', 'referencePiece/list', 234, 235, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(236, 'Guardar/Actualizar', 'referencePiece/save', 234, 236, 'not-icon', 1, 'Creación/Actualización de información', 1),
(237, 'Editar ', 'referencePiece/form', 234, 237, 'not-icon', 1, 'Formulario de Información para editar', 1),
(238, 'Add', 'referencePiece/form', 234, 238, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(239, 'Referencia Tipos', 'referencePieceType', 220, 239, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(240, 'Administración Referencia Tipos', 'referencePieceType', 239, 240, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(241, 'Grid', 'referencePieceType/list', 240, 241, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(242, 'Guardar/Actualizar', 'referencePieceType/save', 240, 242, 'not-icon', 1, 'Creación/Actualización de información', 1),
(243, 'Editar ', 'referencePieceType/form', 240, 243, 'not-icon', 1, 'Formulario de Información para editar', 1),
(244, 'Add ', 'referencePieceType/form', 240, 244, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(245, 'Antecedentes', 'antecedent', 220, 245, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(246, 'Administración Antecedentes', 'antecedent', 245, 246, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(247, 'Grid', 'antecedent/list', 246, 247, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(248, 'Guardar/Actualizar', 'antecedent/save', 246, 248, 'not-icon', 1, 'Creación/Actualización de información', 1),
(249, 'Editar ', 'antecedent/form', 246, 249, 'not-icon', 1, 'Formulario de Información para editar', 1),
(250, 'Add ', 'antecedent/form', 246, 250, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(251, 'Examenes Clinicos', 'clinicalExam', 220, 251, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(252, 'Administración Examenes Clinicos', 'clinicalExam', 251, 252, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(253, 'Grid', 'clinicalExam/list', 252, 253, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(254, 'Guardar/Actualizar', 'clinicalExam/save', 252, 254, 'not-icon', 1, 'Creación/Actualización de información', 1),
(255, 'Editar ', 'clinicalExam/form', 252, 255, 'not-icon', 1, 'Formulario de Información para editar', 1),
(256, 'Add ', 'clinicalExam/form', 252, 256, 'not-icon', 1, 'Formulario de Información para agregar', 1),
(257, 'Panel de Administrador', 'myProfile', NULL, 257, 'not-icon', 1, 'Cuando eres una persona registrada, tendras un panel para poder manipular tu información. Datos como tus credenciales, usuarios contraseñas, acciónes como compras, sugerencias, etc, que realices en el sistema y demas seran los que puedas revisar editar y obtener un historial de tus actuaciónes e interacciónes dentro de nuestro sistema', 1),
(258, 'Vista Perfil de Usuario', 'myProfile', 257, 258, 'not-icon', 0, 'Muestra la administración de del perfil,formulario.', 1),
(259, 'Perfil', 'myProfile', 258, 259, 'not-icon', 1, 'Muestra la administración de del perfil,formulario.', 1),
(260, 'Guardar/Actualizar Perfil', 'customerProfile/save', 259, 260, 'not-icon', 1, 'Actualiza la información de un perfil', 1),
(261, 'Cuenta/Dashboard', 'account', 257, 261, 'not-icon', 0, 'Información detallada de la cuenta,actividades,resumen de información gestiónada o realizada ,puntos ,recompensas etc.', 1),
(262, 'Tablero', 'account', 261, 262, 'not-icon', 1, 'Información detallada de la cuenta,actividades,resumen de información gestiónada o realizada ,puntos ,recompensas etc.', 1),
(263, 'Cambio Contraseña', 'password', 257, 263, 'not-icon', 0, '0', 1),
(264, 'Cambiar Contraseña', 'password', 263, 264, 'not-icon', 1, '0', 1),
(265, 'Verificar Contraseña ', 'user/equals/changePassword', 264, 265, 'not-icon', 1, 'Permite verificar si la contreseña es igual a la actual en el sistema para asi permitir cambiar la contraseña', 1),
(266, 'Guardar Contraseña', 'user/save/changePassword', 264, 266, 'not-icon', 1, 'Actualiza la información ', 1),
(267, 'Buzon de Sugerencias', 'suggestionsMailBox', 257, 267, 'not-icon', 0, 'Administración de buzon de sugerencias ,creadas por los usuarios hacia  todas las empresas gestiónadas por el usuario.', 1),
(268, 'Administración Buzon de Sugerencias', 'suggestionsMailBox', 267, 268, 'not-icon', 1, 'Administración de buzon de sugerencias ,creadas por los usuarios hacia  todas las empresas gestiónadas por el usuario.', 1),
(269, 'Mis Negocios', 'business', 257, 269, 'not-icon', 0, 'Administración de las empresas de un usuario,grid', 1),
(270, 'Administración Mis Negocios', 'business', 269, 270, 'not-icon', 1, 'Administración de las empresas de un usuario,grid', 1),
(271, 'Admin Grid Empresas', 'business/admin', 270, 271, 'not-icon', 1, 'Lista de Empresas de un usuario,Search', 1),
(272, 'Guardar/Actualizar Empresa', 'business/save', 270, 272, 'not-icon', 1, 'Creación/Actualización de información de una empresa.', 1),
(273, 'Administrar Empresa', 'managerBusiness', 270, 273, 'not-icon', 1, 'Administración empresarial de UNA EMPRESA :CRM,CONTABILIDAD,VENTAS ETC.', 1),
(274, 'Ver Empresa', 'businessDetails', 270, 274, 'not-icon', 1, 'Muestra la información gestiónada de una empresa en el pagina web ,PRODUCTOS,HORARIOS,CONTACTO,ABOUT US,', 1),
(275, 'Ver Empresa Información', 'managerBusiness', 270, 275, 'not-icon', 1, 'Muestra un formulario de la información de una empresa', 1),
(276, 'Guardar/Actualizar Empresa', 'business/saveBusiness', 270, 276, 'not-icon', 1, 'Creación/Actualización de información de una empresa.', 1),
(277, 'Editar Empresa', '0', 270, 277, 'not-icon', 1, 'Formulario de Información para editar una empresa.', 1),
(278, 'Administración de Empresas Amigas', 'listingsQueen', 257, 278, 'not-icon', 0, 'Administración de todas las empresas agregadas como amigas o conocidas..', 1),
(279, 'Administración de Empresas Amigas', 'listingsQueen', 278, 279, 'not-icon', 1, 'Administración de todas las empresas agregadas como amigas o conocidas..', 1),
(280, 'Ordenes Gestión', 'orders', 257, 280, 'not-icon', 0, 'Administración de todas las ordenes realizadas por el cliente.', 1),
(281, 'Ordenes Gestión', 'orders', 280, 281, 'not-icon', 1, 'Administración de todas las ordenes realizadas por el cliente.', 1),
(282, 'Grid', 'orderPaymentsManager/changeStateBankOrder', 281, 282, 'not-icon', 1, 'Gestión de Ordenes', 1),
(283, 'Administración Amigos Usuarios', 'bee', 257, 283, 'not-icon', 0, 'Administración de todas los usuarios agregadas como amigas o conocidas..', 1),
(284, 'Administración Amigos Usuarios', 'bee', 283, 284, 'not-icon', 1, 'Administración de todas los usuarios agregadas como amigas o conocidas..', 1),
(285, 'Administración Mis Sugerencias', 'reviewsTo', 257, 285, 'not-icon', 0, 'Administración de todas las sugerencias realizadas a una empresa por un usuario.', 1),
(286, 'Administración Mis Sugerencias', 'reviewsTo', 285, 286, 'not-icon', 1, 'Administración de todas las sugerencias realizadas a una empresa por un usuario.', 1),
(287, 'Empresa', 'businessByLanguage/admin', NULL, 287, 'not-icon', 1, 'Tienes una empresa registrada, aquí con este modulo puede tener la gestión de la información de toda tu empresa. Información basica de tu empresa, horarios de atención, ubicaciónes y demas acciónes que maneje tu negocio dentro del sistema seran manipulados desde este modulo.', 1),
(288, 'Información Empresa', 'businessByLanguage/admin', 287, 288, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(289, 'Idiomas', 'businessByLanguage/admin', 288, 289, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(290, 'Grid', 'businessByLanguage/admin', 289, 290, 'not-icon', 1, 'Permite ver el listado existente  Configurados ,para poder realizar las traducciónes existentes en la pagina web y busqueda', 1),
(291, 'Formulario-Lista Idiomas', 'language/listSelect2', 289, 291, 'not-icon', 1, 'Obtiene listado de idiomas creados por el administrador total.', 1),
(292, 'Guardar/Actualizar', 'businessByLanguage/save', 289, 292, 'not-icon', 1, 'Creación/Actualización de información Idioma', 1),
(293, 'Editar ', '0', 289, 293, 'not-icon', 1, 'Formulario de Información para editar', 1),
(294, 'Iva', 'taxByBusiness/admin', 287, 294, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(295, 'Administración Iva', 'taxByBusiness/admin', 294, 295, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(296, 'Grid', 'taxByBusiness/admin', 295, 296, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad.', 1),
(297, 'Formulario-Lista de Iva', 'tax/listSelect2', 295, 297, 'not-icon', 1, 'Obtiene listado de Iva creados por el administrador total.', 1),
(298, 'Guardar/Actualizar', 'taxByBusiness/save', 295, 298, 'not-icon', 1, 'Creación/Actualización de información Idioma', 1),
(299, 'Editar ', '0', 295, 299, 'not-icon', 1, 'Formulario de Información para editar', 1),
(300, 'Galeria', 'business/gallery/adminBusiness', 287, 300, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(301, 'Administración Galeria', 'business/gallery/adminBusiness', 300, 301, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(302, 'Grid', 'business/gallery/adminBusiness', 301, 302, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(303, 'Guardar/Actualizar', 'business/gallery/saveBusiness', 301, 303, 'not-icon', 1, 'Creación/Actualización de información Idioma', 1),
(304, 'Editar ', '0', 301, 304, 'not-icon', 1, 'Formulario de Información para editar', 1),
(305, 'Gestión de Horarios', 'business/businessBySchedules/saveSchedules', 287, 305, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(306, 'Administración Gestión de Horarios', 'business/businessBySchedules/saveSchedules', 305, 306, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(307, 'Delete', 'business/businessBySchedules/deleteSchedule', 306, 307, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(308, 'Rrhh', 'business/humanResourcesDepartment/admin', NULL, 308, 'not-icon', 1, 'Los recursos humanos dentro de nuestro sistema pueden ser directos o indirectos. Directos por que puedes ingresar tu propio organigrama estructura y enfocarte a tu manejo en fisico y en el sistema, o indirecto que permite mediante un organigrama ya establecido en el sistema el manejo del mismo. en este modulo puedes agregar departamentos, roles y los usuarios creados asignarlos por departamentos, cargos y sus roles dentro del sistema y su manera de acciónar dentro del sistema', 1),
(309, 'Departamentos', 'business/humanResourcesDepartment/admin', 308, 309, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(310, 'Administración Departamentos', 'business/humanResourcesDepartment/admin', 309, 310, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(311, 'Grid', 'business/humanResourcesDepartment/admin', 310, 311, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(312, 'Guardar/Actualizar', 'business/humanResourcesDepartment/save', 310, 312, 'not-icon', 1, 'Creación/Actualización de información Idioma', 1),
(313, 'Editar ', '0', 310, 313, 'not-icon', 1, 'Formulario de Información para editar', 1),
(314, 'Personal', 'business/humanResourcesEmployeeProfile/admin', 308, 314, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(315, 'Administración Personal', 'business/humanResourcesEmployeeProfile/admin', 314, 315, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(316, 'Grid', 'business/humanResourcesEmployeeProfile/admin', 315, 316, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(317, 'Guardar/Actualizar', 'business/humanResourcesEmployeeProfile/save', 315, 317, 'not-icon', 1, 'Creación/Actualización de información ', 1);
INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`) VALUES
(318, 'Editar ', '0', 315, 318, 'not-icon', 1, 'Formulario de Información para editar', 1),
(319, 'Formulario-Lista Departamentos', 'business/humanResourcesDepartment/listAll', 315, 319, 'not-icon', 1, 'Obtiene los departamentos existentes', 1),
(320, 'Personal-Gestión Usuario/Crear-Actualizar', '0', 315, 320, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(321, 'Administración Personal-Gestión Usuario/Crear-Actualizar', '0', 315, 321, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(322, 'Guardar/Actualizar', 'business/businessByEmployeeProfile/save', 315, 322, 'not-icon', 1, 'Creación/Actualización de información', 1),
(323, 'Formulario-Lista Roles', 'business/roles/listAll', 315, 323, 'not-icon', 1, 'Obtiene los roles  existentes', 1),
(324, 'Formulario-Unique User', 'user/unique/username', 315, 324, 'not-icon', 1, 'Verifica si es unico el usuario asignar', 1),
(325, 'Formulario-Unique Email', 'user/unique/email', 315, 325, 'not-icon', 1, 'Verifica si es unico el email asignar', 1),
(326, 'Formulario-Verify Password', 'user/equals/password', 315, 326, 'not-icon', 1, 'Verifica si es la contrasenia anterior', 1),
(327, 'Crm', 'business/customer/admin', NULL, 327, 'not-icon', 1, 'La necesidad de manipular la información del cliente es mayor cada dia, por lo tanto este modulo permite la directa adminsitración de información de tus clientes, como estan creados, donde estan y detalles que te permiten estar muy cerca del cliente', 1),
(328, 'Clientes', 'business/customer/admin', 327, 328, 'not-icon', 0, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(329, 'Grid', 'business/customer/admin', 328, 329, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(330, 'Clientes', 'business/customer/admin', 329, 330, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(331, 'Guardar/Actualizar', 'business/customer/save', 329, 331, 'not-icon', 1, 'Creación/Actualización de información', 1),
(332, 'Editar ', '0', 329, 332, 'not-icon', 1, 'Formulario de Información para editar', 1),
(333, 'Clientes-Direcciónes', 'business/informationAddress/admin', 327, 333, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(334, 'Gestión de Direcciónes', 'business/informationAddress/admin', 333, 334, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(335, 'Guardar/Actualizar', 'business/informationAddress/save', 334, 335, 'not-icon', 1, 'Creación/Actualización de información', 1),
(336, 'Editar ', '0', 334, 336, 'not-icon', 1, 'Formulario de Información para editar', 1),
(337, 'Grid', 'business/informationAddress/admin', 334, 337, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(338, 'Formulario-Tipo', 'informationAddressType/listSelect2', 334, 338, 'not-icon', 1, 'Permite obtener el listado de tipos de domicilio', 1),
(339, 'Clientes-Telefonos', 'business/informationPhone/admin', 327, 339, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(340, 'Gestión de Telefonos', 'business/informationPhone/admin', 339, 340, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(341, 'Guardar/Actualizar', 'business/informationPhone/save', 340, 341, 'not-icon', 1, 'Creación/Actualización de información', 1),
(342, 'Editar ', '0', 340, 342, 'not-icon', 1, 'Formulario de Información para editar', 1),
(343, 'Grid', 'business/informationPhone/admin', 340, 343, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(344, 'Formulario-Operador', 'informationPhoneOperator/listSelect2', 340, 344, 'not-icon', 1, 'Permite obtener el listado de tipos OPERADOR', 1),
(345, 'Formulario-Tipo', 'informationPhoneType/listSelect2', 340, 345, 'not-icon', 1, 'Permite obtener el listado de tipos ,CASA,PERSONAL..', 1),
(346, 'Clientes-Emails', 'business/informationMail/admin', 327, 346, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(347, 'Gestión de Emails', 'business/informationMail/admin', 346, 347, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(348, 'Guardar/Actualizar', 'business/informationMail/save', 347, 348, 'not-icon', 1, 'Creación/Actualización de información', 1),
(349, 'Editar ', '0', 347, 349, 'not-icon', 1, 'Formulario de Información para editar', 1),
(350, 'Grid', 'business/informationMail/admin', 347, 350, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(351, 'Formulario-Tipo', 'informationMailType/listSelect2', 347, 351, 'not-icon', 1, 'Permite obtener el listado de tipos de emails', 1),
(352, 'Clientes-Redes Sociales', 'business/informationSocialNetwork/admin', 327, 352, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(353, 'Gestión de Redes Sociales', 'business/informationSocialNetwork/admin', 352, 353, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(354, 'Guardar/Actualizar', 'business/informationSocialNetwork/save', 353, 354, 'not-icon', 1, 'Creación/Actualización de información', 1),
(355, 'Editar ', '0', 353, 355, 'not-icon', 1, 'Formulario de Información para editar', 1),
(356, 'Clientes Busqueda Map', 'business/informationSocialNetwork/admin', 327, 356, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(357, 'Grid', 'business/informationSocialNetwork/admin', 356, 357, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(358, 'Formulario-Tipo', 'informationSocialNetworkType/listSelect2', 357, 358, 'not-icon', 1, 'Permite obtener el listado de tipos de emails', 1),
(359, 'Gamificación', '0', NULL, 359, 'not-icon', 1, 'Formulario de Información de Clientes con direcciónes', 1),
(360, 'Tipos de Actividad', '0', 359, 360, 'not-icon', 1, 'Formulario de Información de Clientes con direcciónes', 1),
(361, 'Ver ', '0', 360, 361, 'not-icon', 1, 'Formulario de Información de Clientes con direcciónes', 1),
(362, 'Manager Search', 'business/customer/listAllInformationAddress', 361, 362, 'not-icon', 1, 'Obtiene todos los clientes unicamente con dirección', 1),
(363, 'Form-Search Cliente', 'business/customer/listS2InformationAddress', 361, 363, 'not-icon', 1, 'Lista de clientes con direcciónes', 1),
(364, 'Administración Actividades', 'gamificationTypeActivity/admin', 359, 364, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(365, 'Tipos de Actividad', 'gamificationTypeActivity/admin', 364, 365, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(366, 'Grid', 'gamificationTypeActivity/admin', 365, 366, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(367, 'Guardar/Actualizar', 'gamificationTypeActivity/save', 365, 367, 'not-icon', 1, 'Creación/Actualización de información', 1),
(368, 'Editar ', '0', 365, 368, 'not-icon', 1, 'Formulario de Información para editar', 1),
(369, 'Administración-Puntos Con Sus Actividades', 'businessByGamification/admin', 359, 369, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(370, 'Administración-Entity', 'businessByGamification/admin', 369, 370, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(371, 'Grid', 'businessByGamification/admin', 370, 371, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(372, 'Guardar/Actualizar', 'businessByGamification/save', 370, 372, 'not-icon', 1, 'Creación/Actualización de información', 1),
(373, 'Editar ', '0', 370, 373, 'not-icon', 1, 'Formulario de Información para editar', 1),
(374, 'Administración - Premios', 'gamificationByProcess/admin', 359, 374, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(375, 'Administración-Puntos', 'gamificationByProcess/admin', 374, 375, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(376, 'Grid', 'gamificationByProcess/admin', 375, 376, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(377, 'Guardar/Actualizar', 'gamificationByProcess/save', 375, 377, 'not-icon', 1, 'Creación/Actualización de información', 1),
(378, 'Editar ', '0', 375, 378, 'not-icon', 1, 'Formulario de Información para editar', 1),
(379, 'Form-Search Tipo Actividad Gamificación', 'gamificationTypeActivity/listSelect2', 375, 379, 'not-icon', 1, 'Permite obtener el listado de tipos de Actividad', 1),
(380, 'Puntos ', 'gamificationByRewards/admin', 359, 380, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(381, 'Administración', 'gamificationByRewards/admin', 380, 381, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(382, 'Grid', 'gamificationByRewards/admin', 381, 382, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(383, 'Guardar/Actualizar', 'gamificationByRewards/save', 381, 383, 'not-icon', 1, 'Creación/Actualización de información', 1),
(384, 'Editar ', '0', 381, 384, 'not-icon', 1, 'Formulario de Información para editar', 1),
(385, 'Form-Search Productos', 'business/products/listSelect2', 381, 385, 'not-icon', 1, 'Permite obtener el listado de productos.', 1),
(386, 'Form-Search Servicios', 'business/services/listSelect2', 381, 386, 'not-icon', 1, 'Permite obtener el listado de servicios', 1),
(387, 'Tienda', 'product/admin', NULL, 387, 'not-icon', 1, 'El modulo tienda te permite manipular la información directa de tus productos, listado de tus productos, descuentos, inventarios y logistica seran administrados desde este modulo.', 1),
(388, 'Productos', 'product/admin', 387, 388, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(389, 'Administración de Productos', 'product/admin', 388, 389, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(390, 'Grid', 'product/admin', 389, 390, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(391, 'Guardar/Actualizar', 'product/save', 389, 391, 'not-icon', 1, 'Creación/Actualización de información', 1),
(392, 'Editar ', '0', 389, 392, 'not-icon', 1, 'Formulario de Información para editar', 1),
(393, 'Form-Search Productos Marca', 'productTrademark/listSelect2', 389, 393, 'not-icon', 1, 'Permite obtener el listado de MARCAS', 1),
(394, 'Form-Search Categoria', 'productCategory/listSelect2', 389, 394, 'not-icon', 1, 'Permite obtener el listado de CATEGORIAS', 1),
(395, 'Form-Search Subcategoria', 'productCategory/listSelect2', 389, 395, 'not-icon', 1, 'Permite obtener el listado de SUBCATEGORIAS', 1),
(396, 'Form-Search Medidas', 'productMeasureType/listSelect2', 389, 396, 'not-icon', 1, 'Permite obtener el listado de MEDIDAS', 1),
(397, 'Productos-Galeria', 'productByMultimedia/admin', 387, 397, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(398, 'Productos Galeria', 'productByMultimedia/admin', 397, 398, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(399, 'Grid', 'productByMultimedia/admin', 398, 399, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(400, 'Guardar/Actualizar', 'productByMultimedia/save', 398, 400, 'not-icon', 1, 'Creación/Actualización de información', 1),
(401, 'Editar ', '0', 398, 401, 'not-icon', 1, 'Formulario de Información para editar', 1),
(402, 'Productos - Traducción', 'languageProduct/admin', 387, 402, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(403, 'Traducción', 'languageProduct/admin', 402, 403, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(404, 'Grid', 'languageProduct/admin', 403, 404, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(405, 'Guardar/Actualizar', 'languageProduct/save', 403, 405, 'not-icon', 1, 'Creación/Actualización de información', 1),
(406, 'Editar ', '0', 403, 406, 'not-icon', 1, 'Formulario de Información para editar', 1),
(407, 'Form-Search Idioma', 'language/listSelect2', 403, 407, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(408, 'Gestión Servicios', 'productService/admin', 387, 408, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(409, 'Servicios', 'productService/admin', 408, 409, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(410, 'Guardar/Actualizar', 'productService/save', 409, 410, 'not-icon', 1, 'Creación/Actualización de información', 1),
(411, 'Productos Descuentos', 'businessByDiscount/admin', 387, 411, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(412, 'Productos Descuentos', 'businessByDiscount/admin', 411, 412, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(413, 'Grid', 'businessByDiscount/admin', 412, 413, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(414, 'Guardar/Actualizar', 'businessByDiscount/save', 412, 414, 'not-icon', 1, 'Creación/Actualización de información', 1),
(415, 'Editar ', '0', 412, 415, 'not-icon', 1, 'Formulario de Información para editar', 1),
(416, 'Form - Grid Productos', 'discountByProducts/adminProducts', 412, 416, 'not-icon', 1, 'Permite obtener el listado de productos.', 1),
(417, 'Configuración - Logistica Envio', 'businessByShippingRate/admin', 387, 417, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(418, 'Logistica Gestión', 'businessByShippingRate/admin', 417, 418, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(419, 'Grid', 'businessByShippingRate/admin', 418, 419, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(420, 'Guardar/Actualizar', 'businessByShippingRate/save', 418, 420, 'not-icon', 1, 'Creación/Actualización de información', 1),
(421, 'Editar ', '0', 418, 421, 'not-icon', 1, 'Formulario de Información para editar', 1),
(422, 'Form - Empresas de Envio', 'shippingRateBusiness/listSelect2', 418, 422, 'not-icon', 1, 'Permite obtener el listado de empresas en el sistema.', 1),
(423, 'Administración - Ordenes de Compras', 'orderPaymentsManager/admin', 387, 423, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(424, 'Grid', 'orderPaymentsManager/admin', 423, 424, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(425, 'Gestión Ordenes de Compra', 'orderPaymentsManager/admin', 424, 425, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(426, 'Revisión  Pedido - Deposito', 'orderPaymentsManager/changeStateBankOrder', 424, 426, 'not-icon', 1, 'Cambiar de estado de un pedido realizado atraves de un deposito bancario.', 1),
(427, 'Realizar Entrega - Deposito', 'orderPaymentsManager/deliverOrder', 424, 427, 'not-icon', 1, 'Realizar la gestión de la orden de un pedido realizado atraves de un deposito bancario.', 1),
(428, 'Realizar Entrega - Tarjeta de Credito', 'orderPaymentsManager/deliverOrder', 424, 428, 'not-icon', 1, 'Realizar la gestión de la orden de un pedido realizado atraves de una tarjeta de credito.', 1),
(429, 'Rutas-Mapas', 'business/routes/adminBusiness', NULL, 429, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(430, 'Chaquiñanes', 'business/routes/adminBusiness', 429, 430, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(431, 'Administración de Chaquiñanes', 'business/routes/adminBusiness', 430, 431, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(432, 'Grid', 'business/routes/adminBusiness', 431, 432, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(433, 'Guardar/Actualizar', 'business/routes/saveBusiness', 431, 433, 'not-icon', 1, 'Creación/Actualización de información', 1),
(434, 'Editar ', '0', 431, 434, 'not-icon', 1, 'Formulario de Información para editar', 1),
(435, 'Chaquiñanes - Galeria', 'business/panorama/adminBusiness', 429, 435, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(436, 'Administración de Galeria Chaquiñanes', 'business/panorama/adminBusiness', 435, 436, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(437, 'Grid', 'business/panorama/adminBusiness', 436, 437, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(438, 'Guardar/Actualizar', 'business/panorama/saveToBusiness', 436, 438, 'not-icon', 1, 'Creación/Actualización de información', 1),
(439, 'Editar ', '0', 436, 439, 'not-icon', 1, 'Formulario de Información para editar', 1),
(440, 'Form-Search Chaquiñanes', 'business/routes/markers/select', 436, 440, 'not-icon', 1, 'Permite obtener listado de los chaquiñanes creados.', 1),
(441, 'Web-Cms', 'templateInformation/admin', NULL, 441, 'not-icon', 1, 'Los modulos web y cms info te permiten adminsitrar directamente la información que como empresa estas interesado en mostrar a tu cliente final. En la vida real buscas un local para dentro de tu espacio decorarlo y poder mostrar al publico tus productos o tus servicios, en este modulo es similar pero virtual. Todo lo que deseas mostrar de tu negocio lo manipularas y explotaras de una manera mas clara la información a tus clientes', 1),
(442, 'Administrar Web ', 'templateInformation/admin', 441, 442, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(443, 'Administración de Chaquiñanes', 'templateInformation/admin', 442, 443, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(444, 'Grid', 'templateInformation/admin', 443, 444, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(445, 'Guardar/Actualizar', 'templateInformation/save', 443, 445, 'not-icon', 1, 'Creación/Actualización de información', 1),
(446, 'Editar ', '0', 443, 446, 'not-icon', 1, 'Formulario de Información para editar', 1),
(447, 'Cms-Info', 'frontend/manager', NULL, 447, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(448, 'Gestión Web', 'frontend/manager', 447, 448, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(449, 'Administración Web', 'frontend/manager', 448, 449, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(450, 'Cms-Slider', 'templateSlider/admin', NULL, 450, 'not-icon', 1, 'La administración del Slider te permite mostrar con una imagen o varias imágenes cual es la información principal que quieres que tu cliente conozca, El slider principal es una valla o letrero que sera tu primera impresión ante tus clientes. Y tendras total manejo del mismo con su administración y detalles', 1),
(451, 'Principal', 'templateSlider/admin', 450, 451, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(452, 'Gestión Galeria Principal', 'templateSlider/admin', 451, 452, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(453, 'Grid', 'templateSlider/admin', 452, 453, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(454, 'Guardar/Actualizar', 'templateSlider/save', 452, 454, 'not-icon', 1, 'Creación/Actualización de información', 1),
(455, 'Editar ', '0', 452, 455, 'not-icon', 1, 'Formulario de Información para editar', 1),
(456, 'Principal-Data', 'templateSliderByImages/admin', 450, 456, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(457, 'Gestión de Galeria', 'templateSliderByImages/admin', 456, 457, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(458, 'Grid', 'templateSliderByImages/admin', 457, 458, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(459, 'Guardar/Actualizar', 'templateSliderByImages/save', 457, 459, 'not-icon', 1, 'Creación/Actualización de información', 1),
(460, 'Editar ', '0', 457, 460, 'not-icon', 1, 'Formulario de Información para editar', 1),
(461, 'Principal - Data - Traducción', 'languageTemplateSliderByImages/admin', 450, 461, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(462, 'Gestión de Traducción', 'languageTemplateSliderByImages/admin', 461, 462, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(463, 'Grid', 'languageTemplateSliderByImages/admin', 462, 463, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(464, 'Guardar/Actualizar', 'templateSliderByImages/save', 462, 464, 'not-icon', 1, 'Creación/Actualización de información', 1),
(465, 'Editar ', '0', 462, 465, 'not-icon', 1, 'Formulario de Información para editar', 1),
(466, 'Form-Idioma Search', 'language/listSelect2', 462, 466, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(467, 'Eliminar ', 'languageTemplateSliderByImages/delete', 462, 467, 'not-icon', 1, 'Elimina un registro.', 1),
(468, 'Actividades Gamificación', 'templateSlider/adminActivitiesGamification', 450, 468, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(469, 'Actividades Gamificación', 'templateSlider/adminActivitiesGamification', 468, 469, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(470, 'Grid', 'templateSlider/adminActivitiesGamification', 469, 470, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(471, 'Guardar/Actualizar', 'templateSlider/saveActivitiesGamification', 469, 471, 'not-icon', 1, 'Creación/Actualización de información', 1),
(472, 'Editar ', '0', 469, 472, 'not-icon', 1, 'Formulario de Información para editar', 1),
(473, 'Actividades Gamificación-Data', 'templateSliderByImages/adminActivitiesGamification', 450, 473, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(474, 'Gestión de Galeria', 'templateSliderByImages/adminActivitiesGamification', 473, 474, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(475, 'Grid', 'templateSliderByImages/adminActivitiesGamification', 474, 475, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(476, 'Guardar/Actualizar', 'templateSliderByImages/saveActivitiesGamification', 474, 476, 'not-icon', 1, 'Creación/Actualización de información', 1),
(477, 'Editar ', '0', 474, 477, 'not-icon', 1, 'Formulario de Información para editar', 1),
(478, 'Actividades Gamificación - Data - Traducción', 'languageTemplateSliderByImages/adminActivitiesGamification', 450, 478, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(479, 'Gestión de Traducción', 'languageTemplateSliderByImages/adminActivitiesGamification', 478, 479, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(480, 'Grid', 'languageTemplateSliderByImages/adminActivitiesGamification', 479, 480, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(481, 'Guardar/Actualizar', 'languageTemplateSliderByImages/saveActivitiesGamification', 479, 481, 'not-icon', 1, 'Creación/Actualización de información', 1),
(482, 'Editar ', '0', 479, 482, 'not-icon', 1, 'Formulario de Información para editar', 1),
(483, 'Form-Idioma Search', 'language/listSelect2', 479, 483, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(484, 'Eliminar ', 'languageTemplateSliderByImages/delete', 479, 484, 'not-icon', 1, 'Elimina un registro.', 1),
(485, 'Premios Gamificación', 'templateSlider/adminRewardsGamification', 450, 485, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(486, 'Premios Gamificación', 'templateSlider/adminRewardsGamification', 485, 486, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(487, 'Grid', 'templateSlider/adminRewardsGamification', 486, 487, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(488, 'Guardar/Actualizar', 'templateSlider/saveRewardsGamification', 486, 488, 'not-icon', 1, 'Creación/Actualización de información', 1),
(489, 'Editar ', '0', 486, 489, 'not-icon', 1, 'Formulario de Información para editar', 1),
(490, 'Premios Gamificación-Data', 'templateSliderByImages/adminRewardsGamification', 450, 490, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(491, 'Gestión de Galeria', 'templateSliderByImages/adminRewardsGamification', 490, 491, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(492, 'Grid', 'templateSliderByImages/adminRewardsGamification', 491, 492, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(493, 'Guardar/Actualizar', 'templateSliderByImages/saveRewardsGamification', 491, 493, 'not-icon', 1, 'Creación/Actualización de información', 1),
(494, 'Editar ', '0', 491, 494, 'not-icon', 1, 'Formulario de Información para editar', 1),
(495, 'Premios Gamificación - Data - Traducción', 'languageTemplateSliderByImages/adminRewardsGamification', 450, 495, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(496, 'Gestión de Traducción', 'languageTemplateSliderByImages/adminRewardsGamification', 495, 496, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(497, 'Grid', 'languageTemplateSliderByImages/adminRewardsGamification', 496, 497, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(498, 'Guardar/Actualizar', 'languageTemplateSliderByImages/saveRewardsGamification', 496, 498, 'not-icon', 1, 'Creación/Actualización de información', 1),
(499, 'Editar ', '0', 496, 499, 'not-icon', 1, 'Formulario de Información para editar', 1),
(500, 'Form-Idioma Search', 'language/listSelect2', 496, 500, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(501, 'Eliminar ', 'languageTemplateSliderByImages/delete', 496, 501, 'not-icon', 1, 'Elimina un registro.', 1),
(502, 'Csm-Sectións', 'templateAboutUs/admin', NULL, 502, 'not-icon', 1, 'Las secciónes del CMS te permiten mostrar mucho mas de tu empresa, cada sección creada aquí es una ventana nueva en dentro de tu pagina web, cada una de estas seran secciónes que con detalles, ilustraciónes, texto y demas puedas explicar a tu cliente cosas como: Quienes somos, nuestros servicios, como contactarnos y si tienes un ecommerce detalles como nuestras politicas de ventas y nuestros terminos.', 1),
(503, 'Quienes Somos', 'templateAboutUs/admin', 502, 503, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(504, 'Administración Quienes Somos', 'templateAboutUs/admin', 503, 504, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(505, 'Grid', 'templateAboutUs/admin', 504, 505, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(506, 'Guardar/Actualizar', 'templateAboutUs/save', 504, 506, 'not-icon', 1, 'Creación/Actualización de información', 1),
(507, 'Editar ', '0', 504, 507, 'not-icon', 1, 'Formulario de Información para editar', 1),
(508, 'Quienes Somos-Traducción', 'languageTemplateAboutUs/admin', 502, 508, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(509, 'Quienes Somos-Traducción', 'languageTemplateAboutUs/admin', 508, 509, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(510, 'Grid', 'languageTemplateAboutUs/admin', 509, 510, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(511, 'Guardar/Actualizar', 'languageTemplateAboutUs/save', 509, 511, 'not-icon', 1, 'Creación/Actualización de información', 1),
(512, 'Form-Idioma Search', 'language/listSelect2', 509, 512, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(513, 'Eliminar ', 'languageTemplateAboutUs/delete', 509, 513, 'not-icon', 1, 'Elimina un registro.', 1),
(514, 'Editar ', '0', 509, 514, 'not-icon', 1, 'Formulario de Información para editar', 1),
(515, 'Quienes Somos - Data', 'templateAboutUsByData/admin', 502, 515, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(516, 'Gestión de Traducción', 'templateAboutUsByData/admin', 515, 516, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(517, 'Grid', 'templateAboutUsByData/admin', 516, 517, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(518, 'Guardar/Actualizar', 'templateAboutUsByData/save', 516, 518, 'not-icon', 1, 'Creación/Actualización de información', 1),
(519, 'Editar ', '0', 516, 519, 'not-icon', 1, 'Formulario de Información para editar', 1),
(520, 'Quienes Somos - Data - Traducción', 'languageTemplateAboutUsByData/admin', 502, 520, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(521, 'Gestión de Traducción', 'languageTemplateAboutUsByData/admin', 520, 521, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(522, 'Grid', 'languageTemplateAboutUsByData/admin', 521, 522, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(523, 'Guardar/Actualizar', 'languageTemplateAboutUsByData/save', 521, 523, 'not-icon', 1, 'Creación/Actualización de información', 1),
(524, 'Editar ', '0', 521, 524, 'not-icon', 1, 'Formulario de Información para editar', 1),
(525, 'Form-Idioma Search', 'language/listSelect2', 521, 525, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(526, 'Eliminar ', 'languageTemplateAboutUsByData/delete', 521, 526, 'not-icon', 1, 'Elimina un registro.', 1),
(527, 'Politicas/Terminos', 'templatePolicies/admin', 502, 527, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(528, 'Administración Politicas/Terminos', 'templatePolicies/admin', 527, 528, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(529, 'Grid', 'templatePolicies/admin', 528, 529, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(530, 'Guardar/Actualizar', 'templatePolicies/save', 528, 530, 'not-icon', 1, 'Creación/Actualización de información', 1),
(531, 'Editar ', '0', 528, 531, 'not-icon', 1, 'Formulario de Información para editar', 1),
(532, 'Politicas/Terminos - Traducción', 'languageTemplatePolicies/admin', 502, 532, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(533, 'Politicas/Terminos-Traducción', 'languageTemplatePolicies/admin', 532, 533, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(534, 'Grid', 'languageTemplatePolicies/admin', 533, 534, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(535, 'Guardar/Actualizar', 'languageTemplatePolicies/save', 533, 535, 'not-icon', 1, 'Creación/Actualización de información', 1),
(536, 'Form-Idioma Search', 'language/listSelect2', 533, 536, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(537, 'Eliminar ', 'languageTemplatePolicies/delete', 533, 537, 'not-icon', 1, 'Elimina un registro.', 1),
(538, 'Editar ', '0', 533, 538, 'not-icon', 1, 'Formulario de Información para editar', 1),
(539, 'Servicios', 'templateServices/admin', 502, 539, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(540, 'Administración Servicios', 'templateServices/admin', 539, 540, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(541, 'Grid', 'templateServices/admin', 540, 541, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(542, 'Guardar/Actualizar', 'templateServices/save', 540, 542, 'not-icon', 1, 'Creación/Actualización de información', 1),
(543, 'Editar ', '0', 540, 543, 'not-icon', 1, 'Formulario de Información para editar', 1),
(544, 'Servicios-Traducción', 'languageTemplateServices/admin', 502, 544, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(545, 'Servicios - Traducción', 'languageTemplateServices/admin', 544, 545, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(546, 'Grid', 'languageTemplateServices/admin', 545, 546, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(547, 'Guardar/Actualizar', 'languageTemplateServices/save', 545, 547, 'not-icon', 1, 'Creación/Actualización de información', 1),
(548, 'Form-Idioma Search', 'language/listSelect2', 545, 548, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(549, 'Eliminar ', 'languageTemplateServices/delete', 545, 549, 'not-icon', 1, 'Elimina un registro.', 1),
(550, 'Editar ', '0', 545, 550, 'not-icon', 1, 'Formulario de Información para editar', 1),
(551, 'Servicios - Data - Traducción', 'templateServicesByData/admin', 502, 551, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(552, 'Gestión de Traducción', 'templateServicesByData/admin', 551, 552, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(553, 'Grid', 'templateServicesByData/admin', 552, 553, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(554, 'Guardar/Actualizar', 'templateServicesByData/save', 552, 554, 'not-icon', 1, 'Creación/Actualización de información', 1),
(555, 'Editar ', '0', 552, 555, 'not-icon', 1, 'Formulario de Información para editar', 1),
(556, 'Contactanos', 'languageTemplateServicesByData/admin', 502, 556, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(557, 'Gestión de Traducción', 'languageTemplateServicesByData/admin', 556, 557, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(558, 'Grid', 'languageTemplateServicesByData/admin', 557, 558, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(559, 'Guardar/Actualizar', 'languageTemplateServicesByData/save', 557, 559, 'not-icon', 1, 'Creación/Actualización de información', 1),
(560, 'Editar ', '0', 557, 560, 'not-icon', 1, 'Formulario de Información para editar', 1),
(561, 'Form-Idioma Search', 'language/listSelect2', 557, 561, 'not-icon', 1, 'Permite obtener el listado de IDIOMAS', 1),
(562, 'Eliminar ', 'languageTemplateServicesByData/delete', 557, 562, 'not-icon', 1, 'Elimina un registro.', 1),
(563, 'Contactanos', 'templateContactUs/getContactUsData', 557, 563, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(564, 'Obtención de Datos Contactanos', 'templateContactUs/getContactUsData', 557, 564, 'not-icon', 1, '0', 1),
(565, 'Upload Marker ', 'templateContactUs/uploadImage', 557, 565, 'not-icon', 1, 'Administra la subida de un marker que se mostrara en un mapa ', 1),
(566, 'Guardar/Actualizar Información Empresarial', 'business/saveDataFrontend', 557, 566, 'not-icon', 1, 'Administra y guarda información de una empresa tales como dirección y contacto email y telefono prinicpal ,ubicación.', 1),
(567, 'Add - Redes Sociales', '0', 557, 567, 'not-icon', 1, 'Mostrar Formulario para agregar una red Social', 1),
(568, 'Guardar/Actualizar - Redes Sociales', 'informationSocialNetwork/saveFrontend', 557, 568, 'not-icon', 1, 'Creación/Actualización de información', 1),
(569, 'Editar - Redes Sociales', '0', 557, 569, 'not-icon', 1, 'Formulario de Información para editar', 1),
(570, 'Eliminar  - Redes Sociales', 'informationSocialNetwork/deleteFrontend', 557, 570, 'not-icon', 1, 'Elimina un registro.', 1),
(571, 'Add - Correos Contactanos', '0', 557, 571, 'not-icon', 1, 'Mostrar Formulario para agregar un Correos Contactanos', 1),
(572, 'Guardar/Actualizar - Correos Contactanos', 'templateConfigMailingByEmails/save', 557, 572, 'not-icon', 1, 'Creación/Actualización de información', 1),
(573, 'Editar - Correos Contactanos', '0', 557, 573, 'not-icon', 1, 'Formulario de Información para editar', 1),
(574, 'Eliminar  - Correos Contactanos', 'templateConfigMailingByEmails/deleteFrontend', 557, 574, 'not-icon', 1, 'Elimina un registro.', 1),
(575, 'Grid-Correo Contactanos', 'templateConfigMailingByEmails/admin', 557, 575, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(576, 'Chat Facebook Configuración', 'templateChatApi/save', 557, 576, 'not-icon', 1, 'Creación/Actualización de información', 1),
(577, 'Configuraciónes', 'templateBySource/getSourcesTypesData\n\n', NULL, 577, 'not-icon', 1, 'Del mismo modo, la pagina web del sistema no es solo información se necesita de detalles como es el logo que estara presente en todo el sistema web y su ICO que es una imagen mucho mas pequeña pero que apareceran en todas las miniaturas de pestañas de varios navegadores. Las formas de pago del mismo modo apareceran en esta opción aunque para poder manipular estas se debe tener autorizaciónes de los adminsitradores del sistema debido a que para autorizar muchos de estos tipos de pagos no solo conllevan activarlos por parte de los desarrolladores del producto sino mas bien de personas o entidades como son bancos o empresas que ofrecen el servicio de pasarela de pagos', 1),
(578, 'Recursos Imagenes', 'templateBySource/getSourcesTypesData\n\n', 577, 578, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(579, 'Administración Recursos Imagenes', 'templateBySource/getSourcesTypesData\n\n', 578, 579, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(580, 'Obtención de Datos Recursos', 'templateBySource/getSourcesTypesData', 579, 580, 'not-icon', 1, '0', 1),
(581, 'Guardar/Actualizar - Logo Principal', 'templateBySource/save', 579, 581, 'not-icon', 1, 'Creación/Actualización Logo principal', 1),
(582, 'Guardar/Actualizar - Favicon', 'templateBySource/save', 579, 582, 'not-icon', 1, 'Creación/Actualización Favicon', 1),
(583, 'Formas de Pago', 'templatePayments/admin', 577, 583, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(584, 'Administración Formas de Pago', 'templatePayments/admin', 583, 584, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(585, 'Grid', 'templatePayments/admin', 584, 585, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(586, 'Guardar/Actualizar', 'templatePayments/save', 584, 586, 'not-icon', 1, 'Creación/Actualización de información', 1),
(587, 'Editar ', '0', 584, 587, 'not-icon', 1, 'Formulario de Información para editar', 1),
(588, 'Gestión Reparación', 'repairProductByBusiness/admin', NULL, 588, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(589, 'Partes/Otros', 'repairProductByBusiness/admin', 588, 589, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(590, 'Administración Partes/Otros', 'repairProductByBusiness/admin', 589, 590, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(591, 'Grid', 'repairProductByBusiness/admin', 590, 591, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(592, 'Guardar/Actualizar', 'repairProductByBusiness/save', 590, 592, 'not-icon', 1, 'Creación/Actualización de información', 1),
(593, 'Editar ', '0', 590, 593, 'not-icon', 1, 'Formulario de Información para editar', 1),
(594, 'Administración Reparación', 'repair/admin', 588, 594, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(595, 'Partes/Otros', 'repair/admin', 594, 595, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(596, 'Grid', 'repair/admin', 595, 596, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(597, 'Guardar/Actualizar', 'repair/save', 595, 597, 'not-icon', 1, 'Creación/Actualización de información', 1),
(598, 'Editar ', '0', 595, 598, 'not-icon', 1, 'Formulario de Información para editar', 1),
(599, 'Form-Clientes Search', 'business/customer/listRepair', 595, 599, 'not-icon', 1, 'Permite obtener el listado de Clientes', 1),
(600, 'Form-Marca Search', 'productTrademark/listSelect2', 595, 600, 'not-icon', 1, 'Permite obtener el listado de Marcas', 1),
(601, 'Form-Color Search', 'productColor/listSelect2', 595, 601, 'not-icon', 1, 'Permite obtener el listado de Colores', 1),
(602, 'Form-Partes Otros Search', 'repairProductByBusiness/listSelect2', 595, 602, 'not-icon', 1, 'Permite obtener el listado de Partes /Otros', 1),
(603, 'Grid-Data ', 'repair/getResults', 595, 603, 'not-icon', 1, 'Permite obtener DATOS ESTADISTICOS', 1),
(604, 'Save Customer ', 'business/customer/saveFix', 595, 604, 'not-icon', 1, 'Permite GUARDAR UN CLIENTE', 1),
(605, 'Hoteleria', 'business/lodgingTypeOfRoom/admin', NULL, 605, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(606, 'Tipos de Habitación', 'business/lodgingTypeOfRoom/admin', 605, 606, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(607, 'Administración Tipos de Habitación', 'business/lodgingTypeOfRoom/admin', 606, 607, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(608, 'Grid', 'business/lodgingTypeOfRoom/admin', 607, 608, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(609, 'Guardar/Actualizar', 'business/lodgingTypeOfRoom/save', 607, 609, 'not-icon', 1, 'Creación/Actualización de información', 1),
(610, 'Niveles de Habitación', 'business/lodgingRoomLevels/admin', 605, 610, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(611, 'Niveles de Habitación', 'business/lodgingRoomLevels/admin', 610, 611, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(612, 'Editar ', '0', 611, 612, 'not-icon', 1, 'Formulario de Información para editar', 1),
(613, 'Grid', 'business/lodgingRoomLevels/admin', 611, 613, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(614, 'Guardar/Actualizar', 'business/lodgingRoomLevels/save', 611, 614, 'not-icon', 1, 'Creación/Actualización de información', 1),
(615, 'Caracteristicas de Habitación', 'business/lodgingRoomFeatures/admin', 605, 615, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(616, 'Caracteristicas de Habitación', 'business/lodgingRoomFeatures/admin', 615, 616, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(617, 'Editar ', '0', 616, 617, 'not-icon', 1, 'Formulario de Información para editar', 1),
(618, 'Grid', 'business/lodgingRoomFeatures/admin', 616, 618, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(619, 'Guardar/Actualizar', 'business/lodgingRoomFeatures/save', 616, 619, 'not-icon', 1, 'Creación/Actualización de información', 1),
(620, 'Habitaciónes', 'business/lodgingTypeOfRoomByPrice/admin', 605, 620, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(621, 'Caracteristicas de Habitación', 'business/lodgingTypeOfRoomByPrice/admin', 620, 621, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(622, 'Editar ', '0', 621, 622, 'not-icon', 1, 'Formulario de Información para editar', 1),
(623, 'Grid', 'business/lodgingTypeOfRoomByPrice/admin', 621, 623, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1);
INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`) VALUES
(624, 'Guardar/Actualizar', 'business/lodgingTypeOfRoomByPrice/save', 621, 624, 'not-icon', 1, 'Creación/Actualización de información', 1),
(625, 'Editar ', '0', 621, 625, 'not-icon', 1, 'Formulario de Información para editar', 1),
(626, 'Form-Tipo Habitación Search', 'business/lodgingTypeOfRoom/listSelect2', 621, 626, 'not-icon', 1, 'Permite obtener el listado de Tipo Habitación', 1),
(627, 'Form-Niveles Search', 'business/lodgingRoomLevels/listSelect2', 621, 627, 'not-icon', 1, 'Permite obtener el listado de niveles', 1),
(628, 'Reportes Estadisticos', 'business/lodgingRoomFeatures/listSelect2', 605, 628, 'not-icon', 0, 'Permite obtener el listado de caracteristicas de habitación', 1),
(629, 'Form-Caracteristicas Habitación Search', 'business/lodgingRoomFeatures/listSelect2', 628, 629, 'not-icon', 1, 'Permite obtener el listado de caracteristicas de habitación', 1),
(630, 'Recepción', 'business/lodging/results', 605, 630, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(631, 'Reportes Estadisticos', 'business/lodging/results', 630, 631, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(632, 'Recepción', 'business/lodging/adminBusiness', 631, 632, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(633, 'Grid', 'business/lodging/adminBusiness', 631, 633, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(634, 'Guardar/Actualizar', 'business/lodging/saveBusiness', 631, 634, 'not-icon', 1, 'Creación/Actualización de información', 1),
(635, 'Editar ', '0', 631, 635, 'not-icon', 1, 'Formulario de Información para editar', 1),
(636, 'Recepción - Gestión de Pagos', 'business/customer/listSelect2NotLodging', 605, 636, 'not-icon', 1, 'Permite obtener el listado de CLIENTES', 1),
(637, 'Form-Clientes Search', 'business/customer/listSelect2NotLodging', 636, 637, 'not-icon', 1, 'Permite obtener el listado de CLIENTES', 1),
(638, 'Recepción - Recopilación Información', 'business/lodgingByPayment/savePayment', 605, 638, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(639, 'Gestión de Pagos', 'business/lodgingByPayment/savePayment', 638, 639, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(640, 'Recepción - Asignación de Habitaciónes', 'business/lodgingByArrived/saveArrived', 605, 640, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(641, 'Recepción - Recopilación Información', 'business/lodgingByArrived/saveArrived', 640, 641, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(642, 'Recepción - Entrega de Habitaciónes', 'business/lodgingByTypeOfRoom/saveBusiness', 605, 642, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(643, 'Recepción - Asignación de Habitaciónes', 'business/lodgingByTypeOfRoom/saveBusiness', 642, 643, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(644, 'Gestión de Formularios ', 'business/lodging/delivery', NULL, 644, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(645, 'Tipos', 'business/lodging/delivery', 644, 645, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(646, 'Recepción - Entrega de Habitaciónes', 'business/lodging/delivery', 645, 646, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(647, 'Tipos', 'business/educationalInstitutionAskwerType/admin', 646, 647, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(648, 'Grid', 'business/educationalInstitutionAskwerType/admin', 646, 648, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(649, 'Guardar/Actualizar', 'business/educationalInstitutionAskwerType/save', 646, 649, 'not-icon', 1, 'Creación/Actualización de información', 1),
(650, 'Formularios', 'business/educationalInstitutionByBusiness/admin', 644, 650, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(651, 'Administración Formularios', 'business/educationalInstitutionByBusiness/admin', 650, 651, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(652, 'Editar ', '0', 651, 652, 'not-icon', 1, 'Formulario de Información para editar', 1),
(653, 'Grid', 'business/educationalInstitutionByBusiness/admin', 651, 653, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(654, 'Guardar/Actualizar', 'business/educationalInstitutionByBusiness/save', 651, 654, 'not-icon', 1, 'Creación/Actualización de información', 1),
(655, 'Editar ', '0', 651, 655, 'not-icon', 1, 'Formulario de Información para editar', 1),
(656, 'Formularios-Test', 'business/educationalInstitutionByBusiness/dataAskwerForm', 644, 656, 'not-icon', 1, 'Formulario de l test ', 1),
(657, 'Formulario Test', 'business/educationalInstitutionByBusiness/dataAskwerForm', 656, 657, 'not-icon', 1, 'Formulario de l test ', 1),
(658, 'Form-Tipo Search', 'business/educationalInstitutionAskwerType/listSelect2', 657, 658, 'not-icon', 1, 'Permite obtener el listado de tipos formulario', 1),
(659, 'Formulario Resultados', 'business/askwerForm/saveAskwer', 644, 659, 'not-icon', 1, 'Creación/Actualización de información', 1),
(660, 'Guardar/Actualizar Realizar-Test', 'business/askwerForm/saveAskwer', 659, 660, 'not-icon', 1, 'Creación/Actualización de información', 1),
(661, 'Administración de Deportes', 'eventsTrailsProject/admin', NULL, 661, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(662, 'Administración de Deportes', 'eventsTrailsProject/admin', 661, 662, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(663, 'Administración de Deportes', 'eventsTrailsProject/admin', 662, 663, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(664, 'Formulario Resultados', 'business/educationalInstitutionByBusiness/dataAskwerForm', 663, 664, 'not-icon', 1, 'Formulario de l test ', 1),
(665, 'Grid', 'business/educationalInstitutionByBusiness/admin', 663, 665, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(666, 'Guardar/Actualizar', 'eventsTrailsProject/save', 663, 666, 'not-icon', 1, 'Creación/Actualización de información', 1),
(667, 'Editar ', '0', 663, 667, 'not-icon', 1, 'Formulario de Información para editar', 1),
(668, 'Form-Tipo Search', 'eventsTrailsTypes/listSelect2', 663, 668, 'not-icon', 1, 'Permite obtener el listado de tipos Eventos', 1),
(669, 'Gestión de Categorias', 'eventsTrailsTypeOfCategories/admin', 661, 669, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(670, 'Administración Gestión de Categorias', 'eventsTrailsTypeOfCategories/admin', 669, 670, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(671, 'Gestión Evento', 'eventsTrailsProject/manager', 670, 671, 'not-icon', 1, 'Permite Gestiónar Eventos', 1),
(672, 'Grid', 'eventsTrailsTypeOfCategories/admin', 670, 672, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(673, 'Guardar/Actualizar', 'eventsTrailsTypeOfCategories/save', 670, 673, 'not-icon', 1, 'Creación/Actualización de información', 1),
(674, 'Gestión Equipos', 'eventsTrailsTypeTeams/admin', 661, 674, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(675, 'Administración Gestión Equipos', 'eventsTrailsTypeTeams/admin', 674, 675, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(676, 'Editar ', '0', 675, 676, 'not-icon', 1, 'Formulario de Información para editar', 1),
(677, 'Grid', 'eventsTrailsTypeTeams/admin', 675, 677, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(678, 'Guardar/Actualizar', 'eventsTrailsTypeTeams/save', 675, 678, 'not-icon', 1, 'Creación/Actualización de información', 1),
(679, 'Gestión Distancias', 'eventsTrailsDistances/admin', 661, 679, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(680, 'Administración Gestión Distancias', 'eventsTrailsDistances/admin', 679, 680, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(681, 'Editar ', '0', 680, 681, 'not-icon', 1, 'Formulario de Información para editar', 1),
(682, 'Grid', 'eventsTrailsDistances/admin', 680, 682, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(683, 'Guardar/Actualizar', 'eventsTrailsDistances/save', 680, 683, 'not-icon', 1, 'Creación/Actualización de información', 1),
(684, 'Editar ', '0', 680, 684, 'not-icon', 1, 'Formulario de Información para editar', 1),
(685, 'Gestión de Kits', 'eventsTrailsByKit/admin', 661, 685, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(686, 'Administración Gestión de Kits', 'eventsTrailsByKit/admin', 685, 686, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(687, 'Editar ', '0', 686, 687, 'not-icon', 1, 'Formulario de Información para editar', 1),
(688, 'Grid', 'eventsTrailsByKit/admin', 686, 688, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(689, 'Guardar/Actualizar', 'eventsTrailsByKit/save', 686, 689, 'not-icon', 1, 'Creación/Actualización de información', 1),
(690, 'Editar ', '0', 686, 690, 'not-icon', 1, 'Formulario de Información para editar', 1),
(691, 'Gestión de Puntos de Venta', 'eventsTrailsRegistrationPoints/admin', 661, 691, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(692, 'Administración Gestión de Puntos de Venta', 'eventsTrailsRegistrationPoints/admin', 691, 692, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(693, 'Form-Tipo Piezas Search', 'eventsTrailsByKit/listSelect2PiecesClothes', 692, 693, 'not-icon', 1, 'Permite obtener el listado de tipos PIEZAS', 1),
(694, 'Grid', 'eventsTrailsRegistrationPoints/admin', 692, 694, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(695, 'Guardar/Actualizar', 'eventsTrailsRegistrationPoints/save', 692, 695, 'not-icon', 1, 'Creación/Actualización de información', 1),
(696, 'Hospital/Clinica', 'allergies/admin', NULL, 696, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(697, 'Gestión de Alergias', 'allergies/admin', 696, 697, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(698, 'Administración Gestión Alergias', 'allergies/admin', 697, 698, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(699, 'Guardar/Actualizar', 'allergies/save', 698, 699, 'not-icon', 1, 'Creación/Actualización de información', 1),
(700, 'Grid', 'allergies/admin', 698, 700, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(701, 'Gestión de Habitos', 'habits/admin', 696, 701, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(702, 'Administración Gestión Habitos', 'habits/admin', 701, 702, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(703, 'Guardar/Actualizar', 'habits/save', 702, 703, 'not-icon', 1, 'Creación/Actualización de información', 1),
(704, 'Grid', 'habits/admin', 702, 704, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(705, 'Gestión de Pacientes', 'habits/admin', 696, 705, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(706, 'Administración Gestión Pacientes', 'habits/admin', 705, 706, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(707, 'Guardar/Actualizar', 'historyClinic/saveDataProfilePatient', 706, 707, 'not-icon', 1, 'Creación/Actualización de información', 1),
(708, 'Grid', 'historyClinic/admin', 706, 708, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(709, 'Gestión Antecedentes', 'antecedentByHistoryClinic/admin', 696, 709, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(710, 'Administración Antecedentes', 'antecedentByHistoryClinic/admin', 709, 710, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(711, 'Guardar/Actualizar', 'antecedentByHistoryClinic/save', 710, 711, 'not-icon', 1, 'Creación/Actualización de información', 1),
(712, 'Grid', 'antecedentByHistoryClinic/admin', 710, 712, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(713, 'Gestión de Consultas', 'medicalConsultationByPatient/admin', 696, 713, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(714, 'Administración Consultas', 'medicalConsultationByPatient/admin', 713, 714, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(715, 'Guardar/Actualizar', 'medicalConsultationByPatient/save', 714, 715, 'not-icon', 1, 'Creación/Actualización de información', 1),
(716, 'Grid', 'medicalConsultationByPatient/admin', 714, 716, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(717, 'Gestión de Tratamientos', 'treatmentByPatient/admin', 696, 717, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(718, 'Administración Tratamientos', 'treatmentByPatient/admin', 717, 718, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(719, 'Guardar/Actualizar', 'treatmentByPatient/save', 718, 719, 'not-icon', 1, 'Creación/Actualización de información', 1),
(720, 'Grid', 'treatmentByPatient/admin', 718, 720, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(721, 'Form-Tratamiento Search', 'product/getProductService', 718, 721, 'not-icon', 1, 'Permite obtener el listado de PRODUCTOS TIPO de SERVICIOS', 1),
(722, 'Gestión de Pagos - Tratamientos Acuerdos', 'treatmentByIndebtednessPayingInit/getManagement', 696, 722, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(723, 'Administración Acuerdo Pagos', 'treatmentByIndebtednessPayingInit/getManagement', 722, 723, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(724, 'Guardar/Actualizar', 'treatmentByIndebtednessPayingInit/save', 723, 724, 'not-icon', 1, 'Creación/Actualización de información', 1),
(725, 'Grid', 'treatmentByIndebtednessPayingInit/admin', 723, 725, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(726, 'Pagos Tratamientos', 'treatmentByPayment/admin', 696, 726, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(727, 'Administración Pagos Tratamientos', 'treatmentByPayment/admin', 726, 727, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(728, 'Guardar/Actualizar', 'treatmentByPayment/save', 727, 728, 'not-icon', 1, 'Creación/Actualización de información', 1),
(729, 'Grid', 'treatmentByPayment/admin', 727, 729, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(730, 'Form-Tratamiento Search', 'treatmentByBreakdownPayment/listSelect2', 727, 730, 'not-icon', 1, 'Permite obtener el listado de tratamientos sin pagar.', 1),
(731, 'Odontograma', 'odontogramByPatient/admin', 696, 731, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(732, 'Administración Odontograma', 'odontogramByPatient/admin', 731, 732, 'not-icon', 1, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(733, 'Guardar/Actualizar', 'odontogramByPatient/save', 732, 733, 'not-icon', 1, 'Creación/Actualización de información', 1),
(734, 'Grid', 'odontogramByPatient/admin', 732, 734, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(735, 'Form-Referencias Search', 'referencePiece/list/select', 732, 735, 'not-icon', 1, 'Permite obtener el listado de REFERENCIAS PIEAS sin pagar.', 1),
(736, 'Get Data Row', 'dentalPieceByOdontogram/list/byOdontogramodontogramId', 732, 736, 'not-icon', 1, 'Obtiene toda la información de la entidadad', 1),
(737, 'Config Eventos', 'eventsTrailsTypes/manager', NULL, 737, 'fas fa-table-tennis', 2, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(738, 'Gestión de Tipos de Eventos', 'eventsTrailsTypes/manager', 737, 738, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(739, 'Config. Eventos', 'eventsTrailsTypes/manager', 738, 739, 'not-icon', 0, 'Administración delos procesos ,editar,crear,actualizar ,este permite saber si tiene acceso a este proceso.', 1),
(740, 'Grid', 'eventsTrailsTypes/admin', 739, 740, 'not-icon', 1, 'Permite ver el listado existente del proceso Configurados ,para poder realizar alguna actividad,buscar.', 1),
(741, 'Guardar/Actualizar', 'eventsTrailsTypes/save', 739, 741, 'not-icon', 1, 'Creación/Actualización de información', 1),
(742, 'Editar ', 'eventsTrailsTypes/save', 739, 742, 'not-icon', 1, 'Formulario de Información para editar', 1),
(743, 'Administracion de Puntos de ventas', 'pointsSales', 257, 743, 'not-icon', 1, 'Administracion y gestion de puntos de ventas asiganados', 1),
(744, 'Administracion de Puntos de ventas', 'pointsSales', 743, 744, 'not-icon', 1, 'Administracion y gestion de puntos de ventas asiganados', 1),
(745, 'Admin Grid Puntos Asignados', 'eventsTrailsRegistrationPoints/adminBusiness', 744, 745, 'not-icon', 1, 'Listado de registros', 1),
(746, 'Guardar Evento usuarios', 'executePaymentCashEvents', 744, 746, 'not-icon', 1, 'Guarda la informacion del evento con respectivo cliente y sus participantes', 1),
(747, 'Obtener Valores/Pagos', 'getDataPaymentsManagement', 744, 747, 'not-icon', 1, ' valores totales de los pagos realiZado  en la gestion de los puntos de venta.', 1),
(748, 'Obtener Valores/Pagos', 'getDataPaymentsManagementEvent', 661, 748, 'not-icon', 1, ' valores totales de los pagos realiZado  en la gestion de los puntos de venta.', 1),
(749, 'Obtener Valores/Pagos', 'getDataPaymentsManagementEvent', 748, 749, 'not-icon', 1, ' valores totales de los pagos realiZado  en la gestion de los puntos de venta.', 1),
(750, 'Eliminar Punto de Venta', 'eventsTrailsRegistrationPoints/deletePointSale', 749, 750, 'not-icon', 1, 'Elimina el registro del sistema el punto de venta gestionado ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actions_by_role`
--

DROP TABLE IF EXISTS `actions_by_role`;
CREATE TABLE IF NOT EXISTS `actions_by_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actions_by_role_roles1_idx` (`role_id`),
  KEY `fk_actions_by_role_actions1_idx` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergies`
--

DROP TABLE IF EXISTS `allergies`;
CREATE TABLE IF NOT EXISTS `allergies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `allergies`
--

INSERT INTO `allergies` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Polen', NULL, NULL, NULL, NULL, 'ACTIVE'),
(2, 'Ácaros del polvo', NULL, NULL, NULL, NULL, 'ACTIVE'),
(3, 'Esporas de moho', NULL, NULL, NULL, NULL, 'ACTIVE'),
(4, 'Caspa de animales', NULL, NULL, NULL, NULL, 'ACTIVE'),
(5, 'Picaduras de insectos', NULL, NULL, NULL, NULL, 'ACTIVE'),
(6, 'Fármacos Cetirizina (Zyrtec Allergy)', NULL, NULL, NULL, NULL, 'ACTIVE'),
(7, 'Alimento', NULL, NULL, NULL, NULL, 'ACTIVE'),
(8, 'Veneno de insectos', NULL, NULL, NULL, NULL, 'ACTIVE'),
(9, 'Farmacos Insulina', '(en particular, fuentes animales de insulina)', NULL, NULL, NULL, 'ACTIVE'),
(10, 'Farmaco Medios de contraste', 'Medios de contraste para rayos X con yodo (pueden causar reacciones similares a las alergias)', NULL, NULL, NULL, 'ACTIVE'),
(11, 'Farmaco Penicilina y antibióticos conexos', 'Penicilina y antibióticos conexos', NULL, NULL, NULL, 'ACTIVE'),
(12, 'Farmaco Sulfamidas', 'Sulfamidas', NULL, NULL, NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergies_by_history_clinic`
--

DROP TABLE IF EXISTS `allergies_by_history_clinic`;
CREATE TABLE IF NOT EXISTS `allergies_by_history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allergies_id` int(11) NOT NULL,
  `history_clinic_id` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_allergies_by_history_clinic_allergies1_idx` (`allergies_id`),
  KEY `fk_allergies_by_history_clinic_history_clinic1_idx` (`history_clinic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allowed_actions`
--

DROP TABLE IF EXISTS `allowed_actions`;
CREATE TABLE IF NOT EXISTS `allowed_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_allowed_actions_actions1_idx` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedent`
--

DROP TABLE IF EXISTS `antecedent`;
CREATE TABLE IF NOT EXISTS `antecedent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedent_by_history_clinic`
--

DROP TABLE IF EXISTS `antecedent_by_history_clinic`;
CREATE TABLE IF NOT EXISTS `antecedent_by_history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_clinic_id` int(11) NOT NULL,
  `antecedent_id` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_antecedent_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  KEY `fk_antecedent_by_history_clinic_antecedent1_idx` (`antecedent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedent_family_members_by_history_clinic`
--

DROP TABLE IF EXISTS `antecedent_family_members_by_history_clinic`;
CREATE TABLE IF NOT EXISTS `antecedent_family_members_by_history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_clinic_id` int(11) NOT NULL,
  `antecedent_id` int(11) NOT NULL,
  `description` text,
  `people_relationship_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_antecedent_family_members_by_history_clinic_history_clin_idx` (`history_clinic_id`),
  KEY `fk_antecedent_family_members_by_history_clinic_antecedent1_idx` (`antecedent_id`),
  KEY `fk_antecedent_family_members_by_history_clinic_people_relat_idx` (`people_relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_entity_answer`
--

DROP TABLE IF EXISTS `askwer_entity_answer`;
CREATE TABLE IF NOT EXISTS `askwer_entity_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `askwer_form_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_field`
--

DROP TABLE IF EXISTS `askwer_field`;
CREATE TABLE IF NOT EXISTS `askwer_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` text NOT NULL,
  `field_type` int(11) NOT NULL,
  `widget_type` int(11) DEFAULT NULL,
  `validations` text,
  `weight` int(11) DEFAULT NULL,
  `askwer_section_id` int(11) NOT NULL,
  `description` text,
  `style_option` text,
  `element_configuration` text,
  `comment_allow` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_askwer_field_askwer_section1_idx` (`askwer_section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_field_value`
--

DROP TABLE IF EXISTS `askwer_field_value`;
CREATE TABLE IF NOT EXISTS `askwer_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solutions` text,
  `askwer_field_id` int(11) NOT NULL,
  `field_type` int(11) NOT NULL,
  `askwer_entity_answer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_askwer_field_value_askwer_field1_idx` (`askwer_field_id`),
  KEY `fk_askwer_field_value_askwer_entity_answer1_idx` (`askwer_entity_answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_form`
--

DROP TABLE IF EXISTS `askwer_form`;
CREATE TABLE IF NOT EXISTS `askwer_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  `description` text,
  `welcome_msg` varchar(254) DEFAULT NULL,
  `leave_msg` varchar(254) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_option`
--

DROP TABLE IF EXISTS `askwer_option`;
CREATE TABLE IF NOT EXISTS `askwer_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(254) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `askwer_field_id` int(11) NOT NULL,
  `option_score` float NOT NULL,
  `option_score_point` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_askwer_option_askwer_field1_idx` (`askwer_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_section`
--

DROP TABLE IF EXISTS `askwer_section`;
CREATE TABLE IF NOT EXISTS `askwer_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `askwer_form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_askwer_section_askwer_form1_idx` (`askwer_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `askwer_type`
--

DROP TABLE IF EXISTS `askwer_type`;
CREATE TABLE IF NOT EXISTS `askwer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(75) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `average_kardex`
--

DROP TABLE IF EXISTS `average_kardex`;
CREATE TABLE IF NOT EXISTS `average_kardex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `units` float NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `income_type` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `transaction_details` text,
  `entity_id` int(11) DEFAULT NULL,
  `entity` varchar(45) DEFAULT NULL,
  `existing_amount` float NOT NULL,
  `existing_punitary` decimal(10,4) NOT NULL,
  `existing_ptotal` decimal(10,4) NOT NULL,
  `entity_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_average_kardex_product1_idx` (`product_id`),
  KEY `fk_average_kardex_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bank`
--

INSERT INTO `bank` (`id`, `value`, `description`, `status`) VALUES
(1, 'Banco del Pichincha', NULL, 'ACTIVE'),
(2, 'Banco del Austro', NULL, 'ACTIVE'),
(3, 'Banco del Pacifico', NULL, 'ACTIVE'),
(4, 'Banc Ecuador', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business`
--

DROP TABLE IF EXISTS `business`;
CREATE TABLE IF NOT EXISTS `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `title` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `page_url` varchar(250) DEFAULT NULL,
  `phone_value` varchar(45) NOT NULL,
  `street_1` varchar(250) NOT NULL,
  `street_2` varchar(250) NOT NULL,
  `street_lat` float NOT NULL,
  `street_lng` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_subcategories_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `qualification` float NOT NULL DEFAULT '0',
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `options_map` text COMMENT 'location,zoom',
  `has_document` int(11) NOT NULL DEFAULT '0',
  `has_about` int(11) NOT NULL DEFAULT '0',
  `has_service_delivery` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT HAS\n1=HAS',
  `type_business` int(11) NOT NULL COMMENT '0=PRODUCT\n1=SERVICE\n2=MIXT',
  `type_manager_payment` int(11) NOT NULL COMMENT '0=OWNER PAYMENTE EFECTIVE\n1=COLMENA SE ENCARGA',
  PRIMARY KEY (`id`),
  KEY `fk_business_business_subcategories_idx` (`business_subcategories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business`
--

INSERT INTO `business` (`id`, `description`, `title`, `email`, `page_url`, `phone_value`, `street_1`, `street_2`, `street_lat`, `street_lng`, `user_id`, `business_subcategories_id`, `created_at`, `updated_at`, `deleted_at`, `status`, `qualification`, `source`, `options_map`, `has_document`, `has_about`, `has_service_delivery`, `type_business`, `type_manager_payment`) VALUES
(1, 'Corporación Arrayanes', 'Corpar', 'comunicaciones@arrayanesalamos.edu.ec', 'www.arrayanealamos.edu.ec', '+59362603072', 'Av 17 de Julio 10108, Ibarra', 'Aurelio Espinoza Polit', 0.348081, -78.1102, 1, 71, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1605046435_favicon.png', NULL, 0, 0, 0, 0, 0),
(2, 'Los Arrayanes', 'U. E. Los Arrayanes', 'comunicaciones@arrayanesalamos.edu.ec', 'www.arrayanesalamos.edu.ec', '062616192', 'Av 17 de julio 10108', 'Aurelio Espinoza Polit', 0.44048, -78.1858, 1, 71, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1605046528_3ef3181d09cca249f89f78d54576c60c7b85b0c5.png', '{\"zoom\":4,\"title\":0,\"mapTypeId\":\"roadmap\",\"center\":{\"lat\":0.22229121000317115,\"lng\":-78.26220911073837}}', 0, 0, 0, 0, 0),
(3, 'Colegio Álamos', 'Unidad Educativa Álamos', 'comunicaciones@arrayanesalamos.edu.ec', 'www.arrayanesalamos.edu.ec', '62258099', 'Piñan', 'C-14', 0.371202, -78.3855, 1, 71, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1605046489_f3174e5d3be88b2639b7d5e48b260b16f0f0015d.png', NULL, 0, 0, 0, 0, 0),
(4, 'Colegio Arrayanes Ibarra', 'Preescolar Arrayanes-Álamos', 'comunicaciones@arrayanesalamos.edu.ec', 'www.arrayanealamos.edu.ec', '062603072', 'Av 17 de Julio 10108', 'Aurelio Espinoza Polit', 0.348081, -78.1102, 1, 72, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1605046567_b98a9c5cfe26eb150221955d495c9eaed8ef33ef.png', NULL, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_academic_offerings_by_data`
--

DROP TABLE IF EXISTS `business_academic_offerings_by_data`;
CREATE TABLE IF NOT EXISTS `business_academic_offerings_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(1) NOT NULL DEFAULT '0',
  `title_icon` varchar(15) DEFAULT NULL,
  `business_by_academic_offerings_id` int(11) NOT NULL,
  `link` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_academic_offerings_by_data_business_by_academic_idx` (`business_by_academic_offerings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_academic_offerings_by_data`
--

INSERT INTO `business_academic_offerings_by_data` (`id`, `title`, `description`, `status`, `source`, `allow_source`, `title_icon`, `business_by_academic_offerings_id`, `link`) VALUES
(1, '<p>Arrayanes<br></p>', '<p>Conoce más de nuestra oferta educativa en la sección primaria.<br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616947651_Mask Group 18.png', 1, 'none', 1, 'www.google.com'),
(2, '<p>Preescolar&nbsp;</p><p>Arrayanes-Álamos</p>', '<p>Conoce más de nuestra oferta educativa en la sección secundaria.<br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616947678_Mask Group 20.png', 1, 'none', 1, 'www.google.com'),
(3, '<p>Álamos<br></p>', '<p>Conoce más de nuestra oferta educativa en la sección preescolar.<br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616947701_Mask Group 19.png', 1, 'none', 1, 'www.google.com'),
(4, '<p><span style=\"font-size: 14.4px;\">Arrayanes</span><br></p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección primaria.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616947962_Mask Group 18.png', 1, 'none', 2, 'www.google.com'),
(5, '<p style=\"font-size: 14.4px;\">Preescolar&nbsp;</p><p style=\"font-size: 14.4px;\">Arrayanes-Álamos</p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección secundaria.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616948002_Mask Group 20.png', 1, 'none', 2, 'www.google.com'),
(6, '<p><span style=\"font-size: 14.4px;\">Álamos</span><br></p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección preescolar.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616948030_Mask Group 20.png', 1, 'none', 2, 'www.google.com'),
(7, '<p><span style=\"font-size: 14.4px;\">Arrayanes</span><br></p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección primaria.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616948108_Mask Group 18.png', 1, 'none', 3, 'www.google.com'),
(8, '<p style=\"font-size: 14.4px;\">Preescolar&nbsp;</p><p style=\"font-size: 14.4px;\">Arrayanes-Álamos</p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección secundaria.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616948135_Mask Group 20.png', 1, 'none', 3, 'www.google.com'),
(9, '<p><span style=\"font-size: 14.4px;\">Álamos</span><br></p>', '<p><span style=\"font-size: 14.4px;\">Conoce más de nuestra oferta educativa en la sección preescolar.</span><br></p>', 'ACTIVE', '/uploads/web/news-data/images/1616948167_Mask Group 19.png', 1, 'none', 3, 'www.google.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_academic_offerings_data_by_information`
--

DROP TABLE IF EXISTS `business_academic_offerings_data_by_information`;
CREATE TABLE IF NOT EXISTS `business_academic_offerings_data_by_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(1) NOT NULL DEFAULT '0',
  `title_icon` varchar(15) DEFAULT NULL,
  `business_academic_offerings_by_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_amenities`
--

DROP TABLE IF EXISTS `business_amenities`;
CREATE TABLE IF NOT EXISTS `business_amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT NULL,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=ICON\n1=IMAGE',
  `business_subcategories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_amenities_business_subcategories1_idx` (`business_subcategories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_amenities`
--

INSERT INTO `business_amenities` (`id`, `value`, `description`, `state`, `source`, `type_source`, `business_subcategories_id`) VALUES
(1, 'Estacionamiento', NULL, 'ACTIVE', 'fa fa-rocket', 0, 1),
(2, 'Nivel de ruido', 'HOTEL', 'ACTIVE', 'fa fa-paw', 0, 1),
(3, 'Auto-servicio', 'HOTEL', 'ACTIVE', 'fa fa-shopping-cart', 0, 1),
(4, 'Wi.Fi', 'HOTEL', 'ACTIVE', 'fa fa-wifi', 0, 26),
(5, 'Sala de Espera', 'HOTEL', 'ACTIVE', 'fa fa-cloud', 0, 1),
(6, 'Servicio de Camarero', 'HOTEL', 'ACTIVE', 'fa fa-wheelchair', 0, 1),
(7, 'Area para niños', 'HOTEL', 'ACTIVE', 'fa fa-tree', 0, 26),
(8, 'Zona de fumadores', 'HOTEL', 'ACTIVE', 'fa fa-wheelchair', 0, 1),
(9, 'Servicio de Bar', 'HOTEL', 'ACTIVE', 'fa fa-wheelchair', 0, 26),
(10, 'Servicio de Entrega', 'HOTEL', 'ACTIVE', 'fa fa-motorcycle', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_about`
--

DROP TABLE IF EXISTS `business_by_about`;
CREATE TABLE IF NOT EXISTS `business_by_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `title_about` varchar(150) NOT NULL,
  `description_about` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_about_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_academic_offerings`
--

DROP TABLE IF EXISTS `business_by_academic_offerings`;
CREATE TABLE IF NOT EXISTS `business_by_academic_offerings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(1) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  `main` int(1) NOT NULL DEFAULT '0' COMMENT '0=not main\n1=main',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_academic_offerings`
--

INSERT INTO `business_by_academic_offerings` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`, `main`) VALUES
(1, 'Proyecto Educativo', '<p>A continuación, encontrarás información referente a los servicios que te ofrecemos</p><p>y los beneficios que tu hijo recibirá en nuestra institución.</p>', 'ACTIVE', 'null', 0, 'A continuación, encontrarás información referente a los servicios que te ofrecemos\ny los beneficios que tu hijo recibirá en nuestra institución.', '2021-03-28 16:04:58', '2021-03-28 16:12:12', NULL, 2, 0),
(2, 'Proyecto Educativo', '<p style=\"font-size: 14.4px;\">A continuación, encontrarás información referente a los servicios que te ofrecemos</p><p style=\"font-size: 14.4px;\">y los beneficios que tu hijo recibirá en nuestra institución.</p>', 'ACTIVE', 'null', 0, 'A continuación, encontrarás información referente a los servicios que te ofrecemos\ny los beneficios que tu hijo recibirá en nuestra institución.', '2021-03-28 16:12:10', '2021-03-28 16:12:10', NULL, 3, 0),
(3, 'Proyecto Educativo', '<p style=\"font-size: 14.4px;\">A continuación, encontrarás información referente a los servicios que te ofrecemos</p><p style=\"font-size: 14.4px;\">y los beneficios que tu hijo recibirá en nuestra institución.</p>', 'ACTIVE', 'null', 0, 'A continuación, encontrarás información referente a los servicios que te ofrecemos\ny los beneficios que tu hijo recibirá en nuestra institución.', '2021-03-28 16:14:41', '2021-03-28 16:14:41', NULL, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_academic_offerings_institution`
--

DROP TABLE IF EXISTS `business_by_academic_offerings_institution`;
CREATE TABLE IF NOT EXISTS `business_by_academic_offerings_institution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(1) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_academic_offerings_institution`
--

INSERT INTO `business_by_academic_offerings_institution` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Proyecto', '<p class=\"MsoNormal\" style=\"text-align:justify\">Ofrecemos un Proyecto Educativo\nde Calidad que busca la innovación y que promueve la excelencia académica\nbasado en una formación integral sólida.&nbsp;\nTe presentamos los medios que tenemos para lograrlo:<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'Proyecto Educativo', '2021-03-28 16:17:38', '2021-03-28 16:25:28', NULL, 4),
(2, 'Educación Bilingüe', '<p class=\"MsoNormal\" style=\"text-align:justify\">La metodología CLIL (Content and\nLanguage Integrated Learning) permite el aprendizaje de una asignatura y un\nsegundo idioma a la vez.&nbsp; Nuestro\ncurrículo incluye materias que se dictan en idioma inglés desde el Segundo de\nBásica.&nbsp; La suficiencia en el idioma es\nevaluada anualmente a través de pruebas internacionales.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', '/uploads/web/BusinessByAcademicOfferingsInstitution/images/1616948282_1610386411_mm1.jpg', 1, 'La metodología CLIL', '2021-03-28 16:18:02', '2021-03-28 16:27:37', NULL, 4),
(3, 'Aprendizaje Basado en Proyectos – ABP', '<p class=\"MsoNormal\" style=\"text-align:justify\">ABP es un método de enseñanza en\nel cual nuestros niños y niñas aprenden involucrándose activamente en proyectos\nsignificativos y relacionados con el mundo real.&nbsp; La metodología consolida un aprendizaje a\nlargo plazo, así como el desarrollo de las habilidades del siglo XXI sugeridas\npor la UNESCO.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'ABP como método de enseñanza', '2021-03-28 16:18:19', '2021-03-28 16:28:18', NULL, 4),
(4, 'Estimulación Temprana', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Nuestro\nprograma de Estimulación Temprana, nos permite potencializar el desarrollo de\nlas capacidades en los niños, fomentando y fortaleciendo las conexiones\nneuronales en cada uno de los períodos sensitivos de los infantes, brindando\nbases firmes para aprendizajes posteriores, abordando de forma integral a nivel\nmotor, lenguaje, cognitivo, psicológico y en valores.<o:p></o:p></span></p>', 'ACTIVE', 'null', 0, 'La Estimulación Temprana', '2021-03-28 16:18:36', '2021-03-28 16:26:53', NULL, 4),
(5, 'PEIS', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">El\nprograma lector PEIS, considera al LENGUAJE como eje del desarrollo cognitivo,\nsiendo la puerta para futuros aprendizajes, trabajando con un currículo\nintegrador que promueve una curiosidad intelectual y aprendizajes\nsignificativos.<o:p></o:p></span></p><p>\n\n</p><p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Consiste\nen la aplicación de un conjunto de estrategias ideadas </span><span class=\"hgkelc\"><span style=\"color: rgb(32, 33, 36); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">para mejorar la competencia lectora\ny el desarrollo del hábito&nbsp;lector&nbsp;en nuestros niños. A través, de un\ntrabajo cálido y la aplicación de la disciplina positiva.<o:p></o:p></span></span></p>', 'ACTIVE', 'null', 0, 'PEIS – Programa lector', '2021-03-28 16:18:51', '2021-03-28 16:26:07', NULL, 4),
(6, 'Acompañamiento personalizado y Educación Integral', '<p class=\"MsoNormal\" style=\"text-align:justify\">La preceptoría es un pilar\nfundamental de nuestro proyecto educativo porque a través del autoconocimiento,\nla aceptación y la superación personal buscamos el crecimiento de nuestros\nniños.&nbsp; Nuestro proyecto trabaja valores,\nvirtudes, habilidades sociales que favorecen su crecimiento humano y\nespiritual.&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'La preceptoría pilar', '2021-03-28 16:19:07', '2021-03-28 16:29:03', NULL, 4),
(7, 'Proyecto', '<p class=\"MsoNormal\" style=\"text-align:justify\">Ofrecemos un Proyecto Educativo\nde Calidad que busca la innovación y que promueve la excelencia académica\nbasado en una formación integral sólida.&nbsp;\nTe presentamos los medios que tenemos para lograrlo:<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'Proyecto Educativo', '2021-03-28 16:19:52', '2021-03-28 16:25:27', NULL, 3),
(8, 'Educación Bilingüe', '<p class=\"MsoNormal\" style=\"text-align:justify\">La metodología CLIL (Content and\nLanguage Integrated Learning) permite el aprendizaje de una asignatura y un\nsegundo idioma a la vez.&nbsp; Nuestro\ncurrículo incluye materias que se dictan en idioma inglés desde el Segundo de\nBásica.&nbsp; La suficiencia en el idioma es\nevaluada anualmente a través de pruebas internacionales.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', '/uploads/web/BusinessByAcademicOfferingsInstitution/images/1616948410_1610386411_mm1.jpg', 1, 'La metodología CLIL', '2021-03-28 16:20:10', '2021-03-28 16:27:39', NULL, 3),
(9, 'Aprendizaje Basado en Proyectos – ABP', '<p class=\"MsoNormal\" style=\"text-align:justify\">ABP es un método de enseñanza en\nel cual nuestros niños y niñas aprenden involucrándose activamente en proyectos\nsignificativos y relacionados con el mundo real.&nbsp; La metodología consolida un aprendizaje a\nlargo plazo, así como el desarrollo de las habilidades del siglo XXI sugeridas\npor la UNESCO.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'ABP como método de enseñanza', '2021-03-28 16:20:23', '2021-03-28 16:28:16', NULL, 3),
(10, 'Estimulación Temprana', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Nuestro\nprograma de Estimulación Temprana, nos permite potencializar el desarrollo de\nlas capacidades en los niños, fomentando y fortaleciendo las conexiones\nneuronales en cada uno de los períodos sensitivos de los infantes, brindando\nbases firmes para aprendizajes posteriores, abordando de forma integral a nivel\nmotor, lenguaje, cognitivo, psicológico y en valores.<o:p></o:p></span></p>', 'ACTIVE', 'null', 0, 'La Estimulación Temprana', '2021-03-28 16:20:35', '2021-03-28 16:27:00', NULL, 3),
(11, 'PEIS', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">El\nprograma lector PEIS, considera al LENGUAJE como eje del desarrollo cognitivo,\nsiendo la puerta para futuros aprendizajes, trabajando con un currículo\nintegrador que promueve una curiosidad intelectual y aprendizajes\nsignificativos.<o:p></o:p></span></p><p>\n\n</p><p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Consiste\nen la aplicación de un conjunto de estrategias ideadas </span><span class=\"hgkelc\"><span style=\"color: rgb(32, 33, 36); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">para mejorar la competencia lectora\ny el desarrollo del hábito&nbsp;lector&nbsp;en nuestros niños. A través, de un\ntrabajo cálido y la aplicación de la disciplina positiva.<o:p></o:p></span></span></p>', 'ACTIVE', 'null', 0, 'PEIS – Programa lector', '2021-03-28 16:20:48', '2021-03-28 16:26:16', NULL, 3),
(12, 'Acompañamiento personalizado y Educación Integral', '<p class=\"MsoNormal\" style=\"text-align:justify\">La preceptoría es un pilar\nfundamental de nuestro proyecto educativo porque a través del autoconocimiento,\nla aceptación y la superación personal buscamos el crecimiento de nuestros\nniños.&nbsp; Nuestro proyecto trabaja valores,\nvirtudes, habilidades sociales que favorecen su crecimiento humano y\nespiritual.&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'La preceptoría pilar', '2021-03-28 16:20:59', '2021-03-28 16:29:05', NULL, 3),
(13, 'Proyecto', '<p class=\"MsoNormal\" style=\"text-align:justify\">Ofrecemos un Proyecto Educativo\nde Calidad que busca la innovación y que promueve la excelencia académica\nbasado en una formación integral sólida.&nbsp;\nTe presentamos los medios que tenemos para lograrlo:<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'Proyecto Educativo', '2021-03-28 16:21:32', '2021-03-28 16:25:31', NULL, 2),
(14, 'Educación Bilingüe', '<p class=\"MsoNormal\" style=\"text-align:justify\">La metodología CLIL (Content and\nLanguage Integrated Learning) permite el aprendizaje de una asignatura y un\nsegundo idioma a la vez.&nbsp; Nuestro\ncurrículo incluye materias que se dictan en idioma inglés desde el Segundo de\nBásica.&nbsp; La suficiencia en el idioma es\nevaluada anualmente a través de pruebas internacionales.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', '/uploads/web/BusinessByAcademicOfferingsInstitution/images/1616948507_1610386411_mm1.jpg', 1, 'La metodología CLIL', '2021-03-28 16:21:47', '2021-03-28 16:27:35', NULL, 2),
(15, 'Aprendizaje Basado en Proyectos – ABP', '<p class=\"MsoNormal\" style=\"text-align:justify\">ABP es un método de enseñanza en\nel cual nuestros niños y niñas aprenden involucrándose activamente en proyectos\nsignificativos y relacionados con el mundo real.&nbsp; La metodología consolida un aprendizaje a\nlargo plazo, así como el desarrollo de las habilidades del siglo XXI sugeridas\npor la UNESCO.&nbsp;&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'ABP como método de enseñanza', '2021-03-28 16:21:59', '2021-03-28 16:28:19', NULL, 2),
(16, 'Estimulación Temprana', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Nuestro\nprograma de Estimulación Temprana, nos permite potencializar el desarrollo de\nlas capacidades en los niños, fomentando y fortaleciendo las conexiones\nneuronales en cada uno de los períodos sensitivos de los infantes, brindando\nbases firmes para aprendizajes posteriores, abordando de forma integral a nivel\nmotor, lenguaje, cognitivo, psicológico y en valores.<o:p></o:p></span></p>', 'ACTIVE', 'null', 0, 'La Estimulación Temprana', '2021-03-28 16:22:11', '2021-03-28 16:27:03', NULL, 2),
(17, 'PEIS', '<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">El\nprograma lector PEIS, considera al LENGUAJE como eje del desarrollo cognitivo,\nsiendo la puerta para futuros aprendizajes, trabajando con un currículo\nintegrador que promueve una curiosidad intelectual y aprendizajes\nsignificativos.<o:p></o:p></span></p><p>\n\n</p><p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"color: rgb(29, 33, 41); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Consiste\nen la aplicación de un conjunto de estrategias ideadas </span><span class=\"hgkelc\"><span style=\"color: rgb(32, 33, 36); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">para mejorar la competencia lectora\ny el desarrollo del hábito&nbsp;lector&nbsp;en nuestros niños. A través, de un\ntrabajo cálido y la aplicación de la disciplina positiva.<o:p></o:p></span></span></p>', 'ACTIVE', 'null', 0, 'PEIS – Programa lector', '2021-03-28 16:22:28', '2021-03-28 16:26:19', NULL, 2),
(18, 'Acompañamiento personalizado y Educación Integral', '<p class=\"MsoNormal\" style=\"text-align:justify\">La preceptoría es un pilar\nfundamental de nuestro proyecto educativo porque a través del autoconocimiento,\nla aceptación y la superación personal buscamos el crecimiento de nuestros\nniños.&nbsp; Nuestro proyecto trabaja valores,\nvirtudes, habilidades sociales que favorecen su crecimiento humano y\nespiritual.&nbsp;<o:p></o:p></p>', 'ACTIVE', 'null', 0, 'La preceptoría pilar', '2021-03-28 16:22:38', '2021-03-28 16:29:00', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_amenities`
--

DROP TABLE IF EXISTS `business_by_amenities`;
CREATE TABLE IF NOT EXISTS `business_by_amenities` (
  `business_amenities_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`business_amenities_id`,`business_id`),
  KEY `fk_business_by_amenities_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_counter`
--

DROP TABLE IF EXISTS `business_by_counter`;
CREATE TABLE IF NOT EXISTS `business_by_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL DEFAULT '0',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_counter_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_counter`
--

INSERT INTO `business_by_counter` (`id`, `count`, `business_id`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_coupon`
--

DROP TABLE IF EXISTS `business_by_coupon`;
CREATE TABLE IF NOT EXISTS `business_by_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `days` int(11) NOT NULL,
  `discount` float NOT NULL,
  `business_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_coupon_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_daily_book_seat`
--

DROP TABLE IF EXISTS `business_by_daily_book_seat`;
CREATE TABLE IF NOT EXISTS `business_by_daily_book_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daily_book_seat_id` int(11) NOT NULL,
  `diary_book_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `entity` varchar(100) DEFAULT NULL COMMENT 'un objeto id: y d qien entidad:factura_venta entidad:factura_compra id:id_factura	',
  `entity_id` int(11) DEFAULT NULL COMMENT 'id:id_factura',
  `user_id` int(11) NOT NULL,
  `level_4` varchar(150) DEFAULT '	SIN ASIGNAR',
  PRIMARY KEY (`id`),
  KEY `fk_business_by_daily_book_seat_daily_book_seat1_idx` (`daily_book_seat_id`),
  KEY `fk_business_by_daily_book_seat_diary_book1_idx` (`diary_book_id`),
  KEY `fk_business_by_daily_book_seat_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_discount`
--

DROP TABLE IF EXISTS `business_by_discount`;
CREATE TABLE IF NOT EXISTS `business_by_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(150) NOT NULL,
  `name` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=PERCENTAGE\n1=Cantidad Fija\n2=Free shipping\n3=Buy X, get Y',
  `type_apply` int(11) NOT NULL DEFAULT '0' COMMENT '1=Complete order /Customers\n0=Products',
  `value` float NOT NULL,
  `has_limit` int(11) NOT NULL DEFAULT '0' COMMENT '0=not has limit days\n1=has',
  `has_limit_end` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT HAS\n1=HAS',
  `limit_init` datetime DEFAULT NULL,
  `limit_end` datetime DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  `minimum_requirements` int(11) NOT NULL DEFAULT '0' COMMENT '0=None\n1=Minimum purchase amount\n2=Minimum quantity of articles',
  `apply_amount_min_products` int(11) NOT NULL DEFAULT '0',
  `amount_min_use` int(11) NOT NULL DEFAULT '0' COMMENT '0=FOREVER\n1=LIMIT USE\n',
  `type_add_customers` int(11) NOT NULL DEFAULT '0' COMMENT '0=ANY ONE\n1=SELECT CUSTOMERS\n2= GROUPS CUSTOMERS',
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_discount_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_documents`
--

DROP TABLE IF EXISTS `business_by_documents`;
CREATE TABLE IF NOT EXISTS `business_by_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_documents_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_employee_profile`
--

DROP TABLE IF EXISTS `business_by_employee_profile`;
CREATE TABLE IF NOT EXISTS `business_by_employee_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `human_resources_employee_profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_employee_profile_human_resources_employee_pr_idx` (`human_resources_employee_profile_id`),
  KEY `fk_business_by_employee_profile_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_frequent_question`
--

DROP TABLE IF EXISTS `business_by_frequent_question`;
CREATE TABLE IF NOT EXISTS `business_by_frequent_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_gallery`
--

DROP TABLE IF EXISTS `business_by_gallery`;
CREATE TABLE IF NOT EXISTS `business_by_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text COMMENT 'text',
  `src` varchar(250) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `type` int(11) DEFAULT '0' COMMENT '0=CAPTION\\n1=CUSTOM-TEXT\\n2=IMAGE\\n3=SLOT\\n4=aspetct-ratio',
  `config` text COMMENT 'styles css',
  `business_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `title` varchar(150) NOT NULL COMMENT 'name',
  `subtitle` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_gallery_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_gamification`
--

DROP TABLE IF EXISTS `business_by_gamification`;
CREATE TABLE IF NOT EXISTS `business_by_gamification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gamification_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `allow_exchange` int(11) NOT NULL DEFAULT '0' COMMENT '0=not exchange to points\n1=allow exchange to points',
  `allow_exchange_business` int(11) NOT NULL DEFAULT '0' COMMENT '0=not exchange to points the other business\n1=allow exchange to points  the other business',
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_business_by_gamification_gamification1_idx` (`gamification_id`),
  KEY `fk_business_by_gamification_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_history`
--

DROP TABLE IF EXISTS `business_by_history`;
CREATE TABLE IF NOT EXISTS `business_by_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `author` varchar(150) NOT NULL,
  `author_titles` text,
  `business_id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MAIN\n1=MAIN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_history`
--

INSERT INTO `business_by_history` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `author`, `author_titles`, `business_id`, `main`) VALUES
(1, 'Nuestra <font color=\"#8D2119\">Historia</font>', '<span id=\"docs-internal-guid-d19f6313-7fff-5ec3-ef09-2c79a0967433\"><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos. Esta es una entidad privada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un patrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar entidades educativas.</span></p><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">La Unidad Educativa Álamos está ubicada en Ibarra en el barrio Santa Rosa de Priorato junto a la laguna de Yahuarcocha, atiende a niños de segundo de Educación Básica a Tercero de Bachillerato. </span></p><div><span style=\"font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\"><br></span></div></span>', 'ACTIVE', '/uploads/web/businessByHistory/images/1614295294_d5.jpg', 1, 'En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos.', '2020-11-10 12:30:50', '2021-03-02 13:02:08', NULL, 'Áreas Recreativas', 'Colegio \"Los Arrayanes\"', 2, 1),
(2, 'Nuestra <font color=\"#8D2119\">Historia</font>', '<blockquote style=\"line-height: 1.295; margin-top: 0pt; margin-bottom: 8pt;\" class=\"blockquote\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos. Esta es una entidad privada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un patrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar entidades educativas.<br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">La Unidad Educativa Álamos está ubicada en Ibarra en el barrio Santa Rosa de Priorato junto a la laguna de Yahuarcocha, atiende a niños de segundo de Educación Básica a Tercero de Bachillerato. </span></blockquote><p><span id=\"docs-internal-guid-aed83fc7-7fff-b8e1-81a2-025d528a3368\"></span></p>', 'ACTIVE', '/uploads/web/businessByHistory/images/1614709417_b1.jpg', 1, 'En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos.', '2020-11-10 18:15:26', '2021-03-03 11:19:52', NULL, 'Colegio Álamos', 'Áreas Académicas y Administrativas', 3, 1),
(3, 'Nuestra <font color=\"#f3d745\">Historia</font>', '<p style=\"margin: 11px 0px;\">En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos.</p><p style=\"margin: 11px 0px;\">Esta es una entidad privada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un patrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar entidades educativas.</p><p style=\"margin: 11px 0px;\">El Preescolar Arrayanes Álamos está ubicado en la ciudad de Ibarra, barrio la Victoria y atiende a niños y niñas de 1 a 5 años.&nbsp;</p>', 'ACTIVE', '/uploads/web/businessByHistory/images/1614710419_c2.jpg', 1, 'En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e impulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros: académico, humano y espiritual, nace la Corporación Arrayanes Álamos.', '2020-11-10 18:48:30', '2021-03-26 21:26:27', NULL, 'Infraestructura Educativa', 'Preescolar Arrayanes-Álamos', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_information_custom`
--

DROP TABLE IF EXISTS `business_by_information_custom`;
CREATE TABLE IF NOT EXISTS `business_by_information_custom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_information_custom`
--

INSERT INTO `business_by_information_custom` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Filosofía Educativa', '<blockquote style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px;\" class=\"blockquote\"><span id=\"docs-internal-guid-7f69eba7-7fff-4e1f-459e-6f5fa7e2a418\" style=\"\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Somos una institución educativa referente en proyectos educativos innovadores, con virtudes humanas y cristianas que busquen la verdad y desarrollen valores de libertad, responsabilidad, fortaleza, solidaridad y tolerancia para crear un mundo más justo y solidario, asumiendo los retos de la modernidad. </span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614782792_a.jpg', 1, 'Nuestra Filosofía', '2020-11-10 14:14:41', '2021-03-03 09:46:32', NULL, 2),
(2, 'Metodología', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-f1dba379-7fff-756f-e9a9-f22fface52ac\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Promover el aprendizaje activo mediante la elaboración de proyectos que dan respuesta a problemas de la vida real, pero además, la adquisición de valores de relación social vinculados a las prácticas de la solidaridad y ayuda mutua por medio del trabajo colaborativo. </span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614783496_a1.jpg', 1, 'Metodología de Aprendizaje', '2020-11-10 14:14:52', '2021-03-03 09:58:16', NULL, 2),
(3, 'Filosofía', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-b5db438a-7fff-0ba9-fa0e-8860b2911eee\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Somos una institución educativa referente en proyectos educativos innovadores, con virtudes humanas y cristianas que busquen la verdad y desarrollen valores de libertad, responsabilidad, fortaleza, solidaridad y tolerancia para crear un mundo más justo y solidario, asumiendo los retos de la modernidad.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785102_85175613_1160822937593339_3635130306379382784_o.jpg', 1, 'Filosofía Educativa', '2020-11-10 18:20:47', '2021-03-03 10:25:02', NULL, 3),
(4, 'Metodología', '<blockquote class=\"blockquote\">Promover el aprendizaje activo mediante la elaboración de proyectos que dan respuesta a problemas de la vida real, pero además, la adquisición de valores de relación social vinculados a las prácticas de la solidaridad y ayuda mutua por medio del trabajo colaborativo.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785123_87995974_1160823544259945_611541658630094848_o.jpg', 1, 'Metodología de Aprendizaje', '2020-11-10 18:21:05', '2021-03-03 10:25:23', NULL, 3),
(5, 'Bilingualism', '<blockquote class=\"blockquote\">A second language provides countless benefits. The Natural Approach is used to teach students at elementary school. Science and an International Reading and Writing program has been incorporated to the curriculum.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785137_76706745_1090041164671517_1550426702151155712_o.jpg', 1, 'Bilingualism', '2020-11-10 18:21:27', '2021-03-03 10:25:37', NULL, 3),
(6, 'Virtudes', '<blockquote class=\"blockquote\">Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El objetivo es formar alumnas cultas que además sean respetuosas, responsables, buenas ciudadanas, con valores humanos y cristianos. La educación de la afectividad se realiza a través del programa Aprender Amar, cuya finalidad es la formación integral de los alumnos en el ámbito de la sexualidad para la familia y la vida.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785169_34162109_675041402838164_955297204480770048_o.jpg', 1, 'Educación en Virtudes Humanas, Cristianas y de la Afectividad', '2020-11-10 18:21:57', '2021-03-03 10:26:09', NULL, 3),
(7, 'English', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-43547e1b-7fff-6e4b-0110-53fcfcbc3fde\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">English learning begins at an early age. The youngest students are taught through a system that has been designed to cover the basics required to start the second language acquisition process. An international program developed by a team of experts is used to teach students older than 3 year old.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614790721_c4.jpg', 1, 'English as a Second language', '2020-11-10 18:58:58', '2021-03-03 11:58:41', NULL, 4),
(8, 'Estimulación temprana', '<p><span id=\"docs-internal-guid-9150d5b4-7fff-bb28-e986-98cf34cc3009\"></span></p><blockquote style=\"line-height: 1.295; margin-top: 0pt; margin-bottom: 8pt;\" class=\"blockquote\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Los primeros años de un niño ofrecen períodos sensitivos importantes para aprovechar al máximo sus capacidades mentales y físicas. El programa de estimulación temprana se lleva a cabo a través de actividades estimulantes que ayudan al niño a desarrollar autonomía e independencia, así como su psicomotricidad, habilidades cognitivas, sensoriales y de lenguaje.&nbsp;</span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614790750_c3.jpg', 1, 'Estimulación temprana', '2020-11-10 18:59:12', '2021-03-03 11:59:10', NULL, 4),
(9, 'Neuromotores', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-8a93ad0d-7fff-e652-91f2-1fc0c8f6ca9f\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">El adecuado Desarrollo psicomotriz ayuda a conseguir una correcta organización neurológica y evitar problemas educativos. El programa neuromotor estimula la correcta maduración del sistema nervioso y la formación y consolidación de circuitos neuronales. Diariamente se trabajan ejercicios motores programados y secuenciados.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614792349_c6.jpg', 1, 'Programa Neuromotor', '2020-11-10 18:59:57', '2021-03-03 12:25:49', NULL, 4),
(10, 'Tecnología', '<blockquote class=\"blockquote\">Todas las aulas están equipadas con pantallas interactivas y sistemas de audio para el trabajo\ndiario. El proceso de alfabetización digital empieza con los alumnos menores quienes\nposteriormente alcanzarán destrezas relacionadas con las TICS: conocimiento de la tecnología,\ncompetencia lingüística y extralingüística y capacidad crítica.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614792481_a10.jpg', 1, 'Tecnología en el Aula', '2020-11-10 19:00:19', '2021-03-03 12:28:01', NULL, 4),
(11, 'Virtudes', '<blockquote class=\"blockquote\">Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El\nobjetivo es formar a estudiantes que sean respetuosos, responsables, colaboradores, buenos\nciudadanos, con valores humanos y cristianos, que posean habilidades para vivir esos valores en la\ncotidianidad.&nbsp;</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614793847_c7.jpg', 1, 'Educación en Virtudes Humanas y Cristianas', '2020-11-10 19:00:40', '2021-03-03 12:51:08', NULL, 4),
(12, 'Bilingualism', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-fbc9e9db-7fff-8f47-bc13-3bc9615bf5dc\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">A second language provides countless benefits. The Natural Approach is used to teach students at elementary school. Science and an International Reading and Writing program has been incorporated to the curriculum. </span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785343_a7.jpg', 1, 'Bilingualism', '2020-12-14 09:52:04', '2021-03-03 10:29:03', NULL, 2),
(13, 'Virtudes', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-9bb1df84-7fff-8f97-beac-33008edc6cd5\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El objetivo es formar alumnas cultas que además sean respetuosas, responsables, buenas ciudadanas, con valores humanos y cristianos. La educación de la afectividad se realiza a través del programa Aprender Amar, cuya finalidad es la formación integral de los alumnos en el ámbito de la sexualidad para la familia y la vida.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614784320_a3.jpg', 1, 'Educación en Virtudes Humanas, Cristianas y de la Afectividad', '2020-12-14 09:54:13', '2021-03-03 10:12:00', NULL, 2),
(14, 'Servicio a la Comunidad', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-02714900-7fff-49c7-7bc3-a3c4362cf998\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Participación de los estudiantes en el programa denominado Visitas de Solidaridad que se realiza durante todo el año lectivo. Se visitan centros infantiles, asilos, albergues, centros de educación especial. El objetivo principal es sensibilizar sobre las necesidades de los demás y promover la vocación de servicio.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614784503_a4.jpg', 1, 'Servicio a la Comunidad', '2020-12-14 09:54:43', '2021-03-03 11:43:24', NULL, 2),
(15, 'Tecnología en el aula', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-3580bdd3-7fff-7afe-c427-f22f3cfe64fa\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Todas las aulas están equipadas con pantallas interactivas y sistema de audio para el trabajo diario. Se cuenta con acceso a plataformas educativas específicas para cada área del conocimiento. Este trabajo permite el desarrollo de destrezas relacionadas con las TICS: conocimiento de la tecnología, competencia lingüística y extralingüística y capacidad crítica.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614788660_a10.jpg', 1, 'Tecnología en el Aula', '2020-12-14 09:55:35', '2021-03-03 11:43:55', NULL, 2),
(16, 'Robótica', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-8f0fa9ad-7fff-74c4-d9b1-1df97bb203d5\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Este sistema de enseñanza interdisciplinaria permite el desarrollo del pensamiento lógico, resolución de problemas y creatividad. Se trabajan áreas de Ciencias, Tecnología, Ingeniería y Matemáticas (STEM), así como Lingüística.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614789730_a11.jpg', 1, 'Robótica Educativa', '2020-12-14 09:56:16', '2021-03-03 11:42:10', NULL, 2),
(17, 'Deportes', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-94f19053-7fff-eba4-f64c-786e7a05af33\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">A través del DEPORTE desarrollamos no solamente las habilidades físicas sino también la transmisión de valores, hábitos y actitudes tales como la cooperación, el diálogo, el trabajo en equipo. </span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614795264_a9ok.jpg', 1, 'Deportes', '2020-12-14 09:56:45', '2021-03-03 13:14:24', NULL, 2),
(18, 'Servicio a la Comunidad', '<blockquote class=\"blockquote\">Participación de los estudiantes en el programa denominado Visitas de Solidaridad que se realiza durante todo el año lectivo. Se visitan centros infantiles, asilos, albergues, centros de educación especial. El objetivo principal es sensibilizar sobre las necesidades de los demás y promover la vocación de servicio.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614786812_76995724_1072841029724864_3228820133820497920_o.jpg', 1, 'Servicio a la Comunidad', '2020-12-14 11:40:04', '2021-03-03 10:53:32', NULL, 3),
(19, 'Tecnología', '<blockquote class=\"blockquote\">Todas las aulas están equipadas con pantallas interactivas y sistema de audio para el trabajo diario. Se cuenta con acceso a plataformas educativas específicas para cada área del conocimiento. Este trabajo permite el desarrollo de destrezas relacionadas con las TICS: conocimiento de la tecnología, competencia lingüística y extralingüística y capacidad crítica.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614788609_b1.jpg', 1, 'Tecnología en el Aula', '2020-12-14 11:41:27', '2021-03-03 11:23:29', NULL, 3),
(20, 'Robótica Educativa', '<blockquote class=\"blockquote\">Este sistema de enseñanza interdisciplinaria permite el desarrollo del pensamiento lógico, resolución de problemas y creatividad. Se trabajan áreas de Ciencias, Tecnología, Ingeniería y Matemáticas (STEM), así como Lingüística.</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614794502_b6.jpg', 1, 'Robótica Educativa', '2020-12-14 11:43:03', '2021-03-03 13:01:42', NULL, 3),
(21, 'Deportes', '<blockquote class=\"blockquote\">A través del DEPORTE desarrollamos no solamente las habilidades físicas sino también la transmisión de valores, hábitos y actitudes tales como la cooperación, el diálogo, el trabajo en equipo</blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614785288_77248117_1068316153510685_6896157244606382080_o.jpg', 1, 'Deportes', '2020-12-14 11:45:05', '2021-03-03 10:28:08', NULL, 3),
(22, 'Metodología', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-87d3ea61-7fff-b3ad-70e7-fb1efcf45d55\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Promover el aprendizaje activo es el objetivo del Aprendizaje Basado en Proyectos. Es una metodología que permite a los alumnos adquirir los conocimientos y competencias clave en el siglo XXI mediante la elaboración de proyectos que dan respuesta a problemas de la vida real.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614795378_c9ok.jpg', 1, 'Aprendizaje Basado en Proyectos', '2020-12-14 13:05:35', '2021-03-03 13:16:18', NULL, 4),
(23, 'Proyectos', '<blockquote class=\"blockquote\"><span id=\"docs-internal-guid-d2860a01-7fff-f848-801b-a32e46f29a10\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Fomentar el cuidado y protección del medio ambiente es el objetivo de este proyecto. Los niños trabajan en el huerto escolar y desarrollan actividades que están encaminadas a incrementar el contacto con la naturaleza y el amor y cuidado de la misma.</span></span></blockquote>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1614795950_c11ok.jpg', 1, 'Huerto Escolar', '2020-12-14 13:06:01', '2021-03-03 13:25:50', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_inventory_management`
--

DROP TABLE IF EXISTS `business_by_inventory_management`;
CREATE TABLE IF NOT EXISTS `business_by_inventory_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal ,categorias left and subcategories right\n1=categories horizontal and subcategories horizontal',
  `config_management_inventory` mediumtext NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_inventory_management_subcategory`
--

DROP TABLE IF EXISTS `business_by_inventory_management_subcategory`;
CREATE TABLE IF NOT EXISTS `business_by_inventory_management_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_management` mediumtext NOT NULL,
  `business_id` int(11) NOT NULL,
  `product_subcategory_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_invoice_buy`
--

DROP TABLE IF EXISTS `business_by_invoice_buy`;
CREATE TABLE IF NOT EXISTS `business_by_invoice_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`business_id`),
  KEY `fk_business_by_invoice_buy_invoice_buy1_idx` (`invoice_buy_id`),
  KEY `fk_business_by_invoice_buy_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_invoice_sale`
--

DROP TABLE IF EXISTS `business_by_invoice_sale`;
CREATE TABLE IF NOT EXISTS `business_by_invoice_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`business_id`),
  KEY `fk_business_by_invoice_buy_business1_idx` (`business_id`),
  KEY `fk_business_by_invoice_sale_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_language`
--

DROP TABLE IF EXISTS `business_by_language`;
CREATE TABLE IF NOT EXISTS `business_by_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `main` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_business_by_language_language1_idx` (`language_id`),
  KEY `fk_business_by_language_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_language`
--

INSERT INTO `business_by_language` (`id`, `language_id`, `business_id`, `state`, `main`) VALUES
(1, 1, 1, 'ACTIVE', 0),
(2, 2, 1, 'ACTIVE', 0),
(3, 3, 1, 'ACTIVE', 1),
(4, 1, 2, 'ACTIVE', 0),
(5, 2, 2, 'ACTIVE', 0),
(6, 3, 2, 'ACTIVE', 1),
(7, 1, 3, 'ACTIVE', 0),
(8, 2, 3, 'ACTIVE', 0),
(9, 3, 3, 'ACTIVE', 1),
(10, 1, 4, 'ACTIVE', 0),
(11, 2, 4, 'ACTIVE', 0),
(12, 3, 4, 'ACTIVE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_lodging_by_price`
--

DROP TABLE IF EXISTS `business_by_lodging_by_price`;
CREATE TABLE IF NOT EXISTS `business_by_lodging_by_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `lodging_type_of_room_by_price_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_room_by_price_business1_idx` (`business_id`),
  KEY `fk_business_by_lodging_by_price_lodging_type_of_room_by_pri_idx` (`lodging_type_of_room_by_price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_menu_management_frontend`
--

DROP TABLE IF EXISTS `business_by_menu_management_frontend`;
CREATE TABLE IF NOT EXISTS `business_by_menu_management_frontend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `name` varchar(125) NOT NULL,
  `link` varchar(125) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=manager is link\n1=METHOD \n2=ROOT init menu root',
  `description` text NOT NULL,
  `type_item` int(1) NOT NULL DEFAULT '1' COMMENT '0=LEVEL BASIC SIN CHILDRENS\n1=HAS CHILDREN\n2= HAS CHILDREN TO CHILDREN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_menu_management_frontend`
--

INSERT INTO `business_by_menu_management_frontend` (`id`, `business_id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`) VALUES
(1, 1, 'Los Arrayanes', '/arrayanes/es/arrayanes', NULL, 1, 'fa-fa', 0, 'Menu Corpar 1', 0),
(2, 1, 'Álamos', '/arrayanes/es/alamos', NULL, 2, 'fa-fa', 0, 'Menu Corpar 2', 0),
(3, 1, 'Preescolar', '/arrayanes/es/preescolar', NULL, 3, 'fa-fa', 0, 'Menur Corpar 3', 0),
(4, 2, 'Home', '/arrayanes/es/arrayanes', NULL, 1, 'fa-fa', 0, 'Menu Arrayanes 1', 0),
(5, 2, 'Nuestro Colegio', '#', NULL, 2, 'not-icon', 1, 'Menu arrayanes 2', 1),
(6, 2, 'Quienes Somos', '/arrayanes/es/aboutUsArrayanes', 5, 1, 'fa-fa', 2, 'Menu arrayanes columna 2 pos 1', 1),
(10, 2, 'Proyecto Educativo', '/arrayanes/es/academicOfferingArrayanes', 5, 2, 'fa-fa', 2, 'menu arryaanes columna 2 pos 2', 1),
(11, 2, 'Admisiones', '#', NULL, 3, 'fa-fa', 1, 'Menu arrayanes columna 3', 1),
(12, 2, 'Requisitos de Admisión', '/arrayanes/es/requirementsArrayanes', 11, 1, 'fa-fa', 2, 'Menu arrayane columna 3 pos 1', 1),
(13, 2, 'Matriculas Online', 'https://schoolnet.colegium.com/webapp/es_CL/login', 11, 2, 'fa-fa', 2, 'Menu arrayanes columna 3 pos 2', 1),
(14, 2, 'Preguntas Frecuentes', '/arrayanes/es/frequentQuestionArrayanes', 11, 3, 'fa-fa', 2, 'Menu arrayanes columna 3 pos 3', 1),
(15, 2, 'Plataforma', 'https://schoolnet.colegium.com/webapp/es_CL/login', NULL, 4, 'fa-fa', 0, 'Menu arrayanes columan 4', 0),
(16, 2, 'Álamos', '/arrayanes/es/alamos', NULL, 5, 'fa-fa', 0, 'menu arryanaes col 5', 0),
(17, 2, 'Preescolar', '/arrayanes/es/preescolar', NULL, 6, 'fa-fa', 0, 'menu arrayanes col 6', 0),
(18, 2, 'Contáctanos', '/arrayanes/es/contactUsArrayanes', NULL, 7, 'fa-fa', 0, 'menu arrayanes col 7', 0),
(19, 3, 'Home', '/arrayanes/es/alamos', NULL, 1, 'fa-fa', 0, 'Menu alamos col 1', 0),
(20, 3, 'Nuestro Colegio', '#', NULL, 2, 'fa-fa', 1, 'Menu alamos col 2', 1),
(21, 3, 'Quienes Somos', '/arrayanes/es/aboutUsAlamos', 20, 1, 'fa-fa', 2, 'Menu alamos columna 2 pos 1', 1),
(25, 3, 'Proyecto Educativo', '/arrayanes/es/academicOfferingAlamos', 20, 2, 'fa-fa', 2, 'Menu alamos col 2 pos 2', 1),
(26, 3, 'Admisiones', '#', NULL, 3, 'fa-fa', 1, 'Menu alamos col 3', 1),
(27, 3, 'Requisitos de Admisión', '/arrayanes/es/requirementsAlamos', 26, 1, 'fa-fa', 2, 'Menu alamos col 3 pos 1', 1),
(28, 3, 'Matricula Online', 'https://schoolnet.colegium.com/webapp/es_CL/login', 26, 2, 'fa-fa', 2, 'Menu alamos col 3 pos 2', 1),
(29, 3, 'Preguntas Frecuentes', '/arrayanes/es/frequentQuestionAlamos', 26, 3, 'fa-fa', 2, 'Menu alamos col 3 pos 3', 1),
(30, 3, 'Plataforma', 'https://schoolnet.colegium.com/webapp/es_CL/login', NULL, 4, 'fa-fa', 0, 'Menu alamos col 4', 0),
(31, 3, 'Arrayanes', '/arrayanes/es/arrayanes', NULL, 5, 'fa-fa', 0, 'Menu alamos col 5', 0),
(32, 3, 'Preescolar', '/arrayanes/es/preescolar', NULL, 6, 'fa-fa', 0, 'Menu alamos col 6', 0),
(33, 3, 'Contáctanos', '/arrayanes/es/contactUsAlamos', NULL, 7, 'fa-fa', 0, 'Menu alamos col 7', 0),
(34, 4, 'Home', '/arrayanes/es/preescolar', NULL, 1, 'fa-fa', 0, 'Menu pre col 1', 0),
(35, 4, 'Nuestro Colegio', '#', NULL, 2, 'fa-fa', 1, 'Menu pre col 2', 1),
(36, 4, 'Quienes Somos', '/arrayanes/es/aboutUsPreescolar', 35, 1, 'fa-fa', 2, 'Menu pre col 2 pos 1', 1),
(37, 4, 'Proyecto Educativo', '/arrayanes/es/academicOfferingPreescolar', 35, 2, 'fa-fa', 2, 'Menu pre col 2 pos 2', 1),
(39, 4, 'Admisiones', '#', NULL, 3, 'fa-fa', 1, 'Menu pre col 3', 1),
(40, 4, 'Requisitos de Admisión', '/arrayanes/es/requirementsPreescolar', 39, 1, 'fa-fa', 2, 'Menu pre col 3 pos 1', 1),
(41, 4, 'Matriculas Online', 'https://schoolnet.colegium.com/webapp/es_CL/login', 39, 2, 'fa-fa', 2, 'Menu pre col 3 pos 2', 1),
(42, 4, 'Preguntas Frecuentes', '/arrayanes/es/frequentQuestionPreescolar', 39, 3, 'fa-fa', 2, 'Menu pre col 3 pos 3', 1),
(43, 4, 'Plataforma', 'https://schoolnet.colegium.com/webapp/', NULL, 4, 'fa-fa', 0, 'Menu pre col 4', 0),
(44, 4, 'Álamos', '/arrayanes/es/alamos', NULL, 5, 'fa-fa', 0, 'Menu pre col 5', 0),
(45, 4, 'Arrayanes', '/arrayanes/es/arrayanes', NULL, 6, 'fa-fa', 0, 'Menu pre col 6', 0),
(46, 4, 'Contáctanos', '/arrayanes/es/contactUsPreescolar', NULL, 7, 'fa-fa', 0, 'Menu pre col 7', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_panorama`
--

DROP TABLE IF EXISTS `business_by_panorama`;
CREATE TABLE IF NOT EXISTS `business_by_panorama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `panorama_id` int(11) NOT NULL,
  `routes_map_by_routes_drawing_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_panorama_business1_idx` (`business_id`),
  KEY `fk_business_by_panorama_panorama1_idx` (`panorama_id`),
  KEY `fk_business_by_panorama_routes_map_by_routes_drawing1_idx` (`routes_map_by_routes_drawing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_partner_companies`
--

DROP TABLE IF EXISTS `business_by_partner_companies`;
CREATE TABLE IF NOT EXISTS `business_by_partner_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_partner_companies`
--

INSERT INTO `business_by_partner_companies` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Alianza Francesa', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1606701321_f1.png', 1, 'https://www.afquito.org.ec/home-page/', '2020-11-10 18:01:52', '2020-11-29 20:55:21', NULL, 2),
(2, 'NN', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049339_1526575596947917524.png', 1, 'http://www.cambridgeenglish.org/exams-and-tests/qualifications/', '2020-11-10 18:02:19', '2020-11-29 21:31:36', NULL, 2),
(3, 'NN', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613867901_a.png', 1, 'https://www.colegium.com/', '2020-11-10 18:02:37', '2021-02-21 00:38:21', NULL, 2),
(4, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868269_b1.png', 1, 'https://www.amco.me/', '2020-11-10 18:02:48', '2021-02-21 00:44:29', NULL, 2),
(5, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868784_c.png', 1, 'https://edu.google.com/products/workspace-for-education/education-fundamentals/', '2020-11-10 18:03:03', '2021-02-21 00:53:04', NULL, 2),
(6, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049396_1526575662832922103.png', 1, 'https://www.uhemisferios.edu.ec/', '2020-11-10 18:03:16', '2020-11-29 21:33:47', NULL, 2),
(7, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049406_1526575671625363269.png', 1, 'http://www.bk2usa.com/', '2020-11-10 18:03:26', '2020-11-29 21:34:07', NULL, 2),
(8, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049415_1528997740938585027.png', 1, 'https://www.efqm.org/', '2020-11-10 18:03:35', '2020-11-29 21:34:38', NULL, 2),
(9, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049426_15289979531424547781.png', 1, 'https://www.cambridgelms.org/main/p/splash', '2020-11-10 18:03:46', '2020-11-29 21:35:15', NULL, 2),
(10, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049437_15488708921060058771.png', 1, 'https://www.up.edu.mx/es', '2020-11-10 18:03:57', '2020-11-29 21:35:50', NULL, 2),
(11, 'Alianza Francesa', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051167_154887017945653869.png', 1, 'https://www.afquito.org.ec/home-page/#/', '2020-11-10 18:32:47', '2020-11-29 22:00:36', NULL, 3),
(12, 'Cambridge', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051178_1526575596947917524.png', 1, 'https://www.cambridgelms.org/main/p/splash', '2020-11-10 18:32:58', '2020-11-29 22:01:08', NULL, 3),
(13, 'Colegium', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868857_a.png', 1, 'https://www.colegium.com/', '2020-11-10 18:33:09', '2021-02-21 00:54:17', NULL, 3),
(14, 'amco', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868885_b1.png', 1, 'https://www.amco.me/', '2020-11-10 18:33:24', '2021-02-21 00:54:45', NULL, 3),
(15, 'Google for education', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868917_c.png', 1, 'https://edu.google.com/products/workspace-for-education/education-fundamentals/', '2020-11-10 18:33:40', '2021-02-21 00:55:17', NULL, 3),
(16, 'Universidad de los hemisferios', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051235_1526575662832922103.png', 1, 'https://www.uhemisferios.edu.ec/', '2020-11-10 18:33:55', '2020-11-29 22:03:01', NULL, 3),
(17, 'Bk2', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051247_1526575671625363269.png', 1, 'http://www.bk2usa.com/es/', '2020-11-10 18:34:07', '2020-11-29 22:03:22', NULL, 3),
(18, 'Efqm', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051258_1528997740938585027.png', 1, 'https://www.efqm.org/', '2020-11-10 18:34:18', '2020-11-29 22:03:46', NULL, 3),
(19, 'Cambridge', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051272_15289979531424547781.png', 1, 'https://www.cambridgelms.org/main/p/splash', '2020-11-10 18:34:32', '2020-11-29 22:04:05', NULL, 3),
(20, 'UP', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051286_15488708921060058771.png', 1, 'https://www.up.edu.mx/es', '2020-11-10 18:34:46', '2020-11-29 22:04:19', NULL, 3),
(21, 'Alianza Francesa', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607359584_1606701321_f1.png', 1, 'https://www.afquito.org.ec/home-page/', '2020-12-07 11:46:24', '2020-12-07 11:46:24', NULL, 4),
(22, 'Cambridge', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988301_h1.png', 1, 'https://www.cambridgelms.org/main/p/splash', '2020-12-14 18:25:01', '2020-12-14 18:25:01', NULL, 4),
(23, 'colegium', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868971_a.png', 1, 'https://www.colegium.com/', '2020-12-14 18:25:55', '2021-02-21 00:56:11', NULL, 4),
(24, 'amco', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613868997_b1.png', 1, 'https://www.amco.me/', '2020-12-14 18:26:29', '2021-02-21 00:56:37', NULL, 4),
(25, 'google', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1613869024_c.png', 1, 'https://edu.google.com/products/workspace-for-education/education-fundamentals/', '2020-12-14 18:28:03', '2021-02-21 00:57:04', NULL, 4),
(26, 'Universidad de los hemisferios', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988520_h5.png', 1, 'https://www.uhemisferios.edu.ec/', '2020-12-14 18:28:40', '2020-12-14 18:28:40', NULL, 4),
(27, 'Bk2', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988623_h6.png', 1, 'http://www.bk2usa.com/es/', '2020-12-14 18:30:23', '2020-12-14 18:30:23', NULL, 4),
(28, 'Efqm', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988671_h7.png', 1, 'https://www.efqm.org/', '2020-12-14 18:31:11', '2020-12-14 18:31:11', NULL, 4),
(29, 'Cambridge', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988739_h8.png', 1, 'https://www.cambridgelms.org/main/p/splash', '2020-12-14 18:32:19', '2020-12-14 18:32:19', NULL, 4),
(30, 'UP', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1607988789_h9.png', 1, 'https://www.up.edu.mx/es', '2020-12-14 18:33:09', '2020-12-14 18:33:09', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_products`
--

DROP TABLE IF EXISTS `business_by_products`;
CREATE TABLE IF NOT EXISTS `business_by_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_products_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_promotion`
--

DROP TABLE IF EXISTS `business_by_promotion`;
CREATE TABLE IF NOT EXISTS `business_by_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL,
  `en_time` datetime NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `products_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_promotion_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_qualification`
--

DROP TABLE IF EXISTS `business_by_qualification`;
CREATE TABLE IF NOT EXISTS `business_by_qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_qualification_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_requirements`
--

DROP TABLE IF EXISTS `business_by_requirements`;
CREATE TABLE IF NOT EXISTS `business_by_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_routes_map`
--

DROP TABLE IF EXISTS `business_by_routes_map`;
CREATE TABLE IF NOT EXISTS `business_by_routes_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `routes_map_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `type_shortcut` int(11) NOT NULL DEFAULT '0' COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico',
  PRIMARY KEY (`id`),
  KEY `fk_business_by_routes_map_business1_idx` (`business_id`),
  KEY `fk_business_by_routes_map_routes_map1_idx` (`routes_map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_schedule`
--

DROP TABLE IF EXISTS `business_by_schedule`;
CREATE TABLE IF NOT EXISTS `business_by_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '0=24\n1=SHEDULE DESGLOCE\n',
  `open` int(11) NOT NULL DEFAULT '0' COMMENT '0=CERRRADO\n1=ABIERTO',
  `business_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `schedule_days_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_shedule_business1_idx` (`business_id`),
  KEY `fk_business_by_schedule_schedule_days_category1_idx` (`schedule_days_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_by_schedule`
--

INSERT INTO `business_by_schedule` (`id`, `type`, `open`, `business_id`, `status`, `schedule_days_category_id`) VALUES
(1, 0, 1, 1, 'ACTIVE', 1),
(2, 0, 1, 1, 'ACTIVE', 2),
(3, 0, 1, 1, 'ACTIVE', 3),
(4, 0, 1, 1, 'ACTIVE', 4),
(5, 0, 1, 1, 'ACTIVE', 5),
(6, 0, 1, 1, 'ACTIVE', 6),
(7, 0, 1, 1, 'ACTIVE', 7),
(8, 0, 1, 2, 'ACTIVE', 1),
(9, 0, 1, 2, 'ACTIVE', 2),
(10, 0, 1, 2, 'ACTIVE', 3),
(11, 0, 1, 2, 'ACTIVE', 4),
(12, 0, 1, 2, 'ACTIVE', 5),
(13, 0, 1, 2, 'ACTIVE', 6),
(14, 0, 1, 2, 'ACTIVE', 7),
(15, 0, 1, 3, 'ACTIVE', 1),
(16, 0, 1, 3, 'ACTIVE', 2),
(17, 0, 1, 3, 'ACTIVE', 3),
(18, 0, 1, 3, 'ACTIVE', 4),
(19, 0, 1, 3, 'ACTIVE', 5),
(20, 0, 1, 3, 'ACTIVE', 6),
(21, 0, 1, 3, 'ACTIVE', 7),
(22, 0, 1, 4, 'ACTIVE', 1),
(23, 0, 1, 4, 'ACTIVE', 2),
(24, 0, 1, 4, 'ACTIVE', 3),
(25, 0, 1, 4, 'ACTIVE', 4),
(26, 0, 1, 4, 'ACTIVE', 5),
(27, 0, 1, 4, 'ACTIVE', 6),
(28, 0, 1, 4, 'ACTIVE', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_scheduling_date`
--

DROP TABLE IF EXISTS `business_by_scheduling_date`;
CREATE TABLE IF NOT EXISTS `business_by_scheduling_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheduling_date_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entity` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_scheduling_date_scheduling_date1_idx` (`scheduling_date_id`),
  KEY `fk_business_by_scheduling_date_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_shipping_rate`
--

DROP TABLE IF EXISTS `business_by_shipping_rate`;
CREATE TABLE IF NOT EXISTS `business_by_shipping_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_rate_business_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_business_by_shipping_rate_shipping_rate_business1_idx` (`shipping_rate_business_id`),
  KEY `fk_business_by_shipping_rate_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_social_networks`
--

DROP TABLE IF EXISTS `business_by_social_networks`;
CREATE TABLE IF NOT EXISTS `business_by_social_networks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '0=FACEBOOK\\n1=INSTAGRAM\\n',
  `url` varchar(500) NOT NULL,
  `business_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_social_networks_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_by_tax`
--

DROP TABLE IF EXISTS `business_by_tax`;
CREATE TABLE IF NOT EXISTS `business_by_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `taxes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_by_tax_business1_idx` (`business_id`),
  KEY `fk_business_by_tax_taxes1_idx` (`taxes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_categories`
--

DROP TABLE IF EXISTS `business_categories`;
CREATE TABLE IF NOT EXISTS `business_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `src` varchar(250) NOT NULL,
  `has_icon` int(11) NOT NULL DEFAULT '0',
  `icon_class` varchar(20) NOT NULL DEFAULT 'anyone',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `business_categories`
--
INSERT INTO `business_categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`, `src`, `has_icon`,
                                   `icon_class`, `description`)
VALUES
    (1, 'Comida y Bebida', 'ACTIVE', NULL, '2020-05-05 13:31:21', NULL, '/uploads/business/categories/6.png', 1,
     'fa fa-cutlery', 'Descubre sabores locales, apoya emprendimientos culinarios y disfruta cada bocado con sentido.'),
    (2, 'Ocio', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/5.png', 1, 'fa fa-futbol-o',
     'Comparte momentos de alegría, relájate y vive experiencias únicas en tu ciudad.'),
    (3, 'Comercios / Establecimientos', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/3.png', 1,
     'fa fa-shopping-bag', 'Compra con propósito, conecta con negocios que transforman tu comunidad.'),
    (4, 'Oficios / Servicios', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/4.png', 1, 'fa fa-users',
     'Valora el trabajo local. Encuentra y recomienda servicios confiables de tu zona.'),
    (5, 'Salud', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/10.jpg', 1, 'fa fa-users',
     'Tu bienestar empieza por aquí. Accede a servicios que cuidan cuerpo, mente y alma.'),
    (6, 'Construccion', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/11.jpg', 1, 'fa fa-users',
     'Impulsa proyectos con talento local en construcción, remodelación y mejoras.'),
    (7, 'Textil', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/12.jpg', 1, 'fa fa-users',
     'Apoya el arte de vestir con identidad. Diseños, bordados y confección con historia.'),
    (8, 'Transporte', 'ACTIVE', NULL, NULL, NULL, '/uploads/business/categories/13.jpg', 1, 'fa fa-users',
     'Conecta caminos. Encuentra servicios de transporte confiables, rápidos y solidarios.');

--
-- Estructura de tabla para la tabla `business_counter_custom`
--

DROP TABLE IF EXISTS `business_counter_custom`;
CREATE TABLE IF NOT EXISTS `business_counter_custom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_counter_custom`
--

INSERT INTO `business_counter_custom` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Cifras', '<p>Cifras de este año 2020</p>', 'ACTIVE', '2020-11-10 12:33:07', '2021-03-16 07:34:35', NULL, 2),
(2, 'Cifras', 'null', 'ACTIVE', '2020-11-10 18:22:35', '2021-03-22 21:35:30', NULL, 3),
(3, 'Cifras', 'null', 'INACTIVE', '2020-11-10 18:48:50', '2021-03-04 23:45:24', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_counter_custom_by_data`
--

DROP TABLE IF EXISTS `business_counter_custom_by_data`;
CREATE TABLE IF NOT EXISTS `business_counter_custom_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_counter_custom_id` int(11) NOT NULL,
  `count` float NOT NULL,
  `count_percentage` float NOT NULL,
  `count_symbol` varchar(75) DEFAULT '%',
  PRIMARY KEY (`id`),
  KEY `fk_business_counter_custom_by_data_business_counter_custom1_idx` (`business_counter_custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_counter_custom_by_data`
--

INSERT INTO `business_counter_custom_by_data` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_counter_custom_id`, `count`, `count_percentage`, `count_symbol`) VALUES
(18, '<p><img src=\"data:image/png;base64,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\" data-filename=\"Group 184.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p><font color=\"#B4102C\">9699</font></p><p>Beneficiarios de Proyectos Solidarios</p>', '<p>No tiene destino</p>', 'ACTIVE', '2021-02-20 20:25:32', '2021-03-26 20:50:45', NULL, 1, 25, 67, '%'),
(19, '<p><img src=\"data:image/png;base64,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\" data-filename=\"Group 186.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font><p></p><p><font color=\"#B4102C\">9699</font></p><p>Horas de Ingles</p></p>', 'null', 'ACTIVE', '2021-02-20 20:28:19', '2021-02-20 20:33:42', NULL, 1, 0, 0, '%'),
(20, '<p><img src=\"data:image/png;base64,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\" data-filename=\"Group 188.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p></p><p></p><p><font color=\"#B4102C\">+853</font></p><p>Horas de Tutorías Personalizadas</p><p></p><p></p>', 'null', 'ACTIVE', '2021-02-20 20:35:31', '2021-02-21 00:08:32', NULL, 1, 0, 0, '%'),
(21, '<p><img src=\"data:image/png;base64,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\" data-filename=\"Group 190.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p></p><p></p><p><span style=\"font-size: 0.9rem;\"><font color=\"#b4102c\">+853</font></span></p><p><span style=\"font-size: 0.9rem;\">Aulas con Tecnología Educativa</span><br></p><p></p><p></p>', '<p>Desript</p>', 'ACTIVE', '2021-02-20 20:36:45', '2021-02-21 00:08:55', NULL, 1, 0, 0, '%'),
(22, '<p style=\"font-size: 14.4px;\"><span style=\"color: rgb(180, 16, 44); font-size: 14.4px;\">9699</span><br></p><p style=\"font-size: 14.4px;\">Beneficiarios de Proyectos Solidarios</p>', '<p>null</p>', 'ACTIVE', '2021-02-21 00:14:12', '2021-03-22 21:35:53', NULL, 2, 546, 75, '+'),
(23, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 186.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><font color=\"#B4102C\">9699</font></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\">Horas de Ingles</p>', '<p>null</p>', 'ACTIVE', '2021-02-21 00:14:51', '2021-02-21 00:14:51', NULL, 2, 0, 0, '%'),
(24, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 188.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><font color=\"#B4102C\">+853</font></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\">Horas de Tutorías Personalizadas</p>', '<p>null</p>', 'ACTIVE', '2021-02-21 00:15:29', '2021-02-21 00:16:45', NULL, 2, 0, 0, '%'),
(25, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 190.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><span style=\"font-size: 0.9rem;\"><font color=\"#b4102c\">+853</font></span></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\"><span style=\"font-size: 0.9rem;\">Aulas con Tecnología Educativa</span></p>', '<p>null</p>', 'ACTIVE', '2021-02-21 00:16:10', '2021-02-21 00:16:10', NULL, 2, 0, 0, '%');
INSERT INTO `business_counter_custom_by_data` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_counter_custom_id`, `count`, `count_percentage`, `count_symbol`) VALUES
(26, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 184.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"><font color=\"#B4102C\">9699</font></p><p style=\"font-size: 14.4px;\">Beneficiarios de Proyectos Solidarios</p>', '<p>0</p>', 'ACTIVE', '2021-02-21 00:58:49', '2021-03-26 22:41:55', NULL, 3, 50, 60, '%'),
(27, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAABHNCSVQICAgIfAhkiAAAEtpJREFUeF7tXQvUHEWV/u5M90xXD5GwwCKEAMojIDHyiOyBgEfDQ8IKwXNQAoF1l8gCAQ+uKyEinKOCIGHBZXkEcJNVAiGgu2xYCbgSghB1d5GDEnAJyiPhJS4oAaa7/5meuXtu/9Pz9/+cmZ5+ze/UOX/++TNV1XXv17fq1q17bxEmQWHmqY7jzqoTH0h12p8JHyLGVCY2CSgxk0mEEgBTyGXGHwkog9hiRpmI3gP4JTA9ncvRM8z5Z5SilyYBa0C9SES5UjmUXJrLhLlgHESE98dARxmMTcjhJzlgQ7GoPUpEdgzPibXLngDYsng656onUp2OZsLRBGw/kitEQI4IuRyB5AcAyX96v0fzkHnw/xgs/6DOjHqdwfXBz+OURwh4uJ7nB0uFwuOxIhNR55kFmJm3c5zaAgafDuATQXo9MHODYHo/YyHYJYMEYwG8+TMKdH6OQKuYte+ZJr3c5eNia545gB2n+sk685kALQxSrWk5D8x8Lr0h+2C7tbqs48HyKIG+Zxj51UTkxIZWiI7T41ZgsMycs+3aZxj1S4holv9VPk/Q8oPAZq0IwAK069abQ2PG7wm4VintJiIqZ2HMqXPOtt2zGfWLAdrbXy9FWgXYXiki2QJ0rT4o1gy8A+B609CuI6K306QjNYAtyz0NVL8aoOk+sLqWh0htrxaR6mq11gQagE3At5TSv5EWTYlz03F47zq7twGYO1mAHQneaKD5eQKdpZT+aNJAJwYwMxctx72EgKUACkJoQe9tiW0Flmy3KpVaQCHju5Shf4mIfteqbVTfJwKwZ5io4W5/nZU1Vtd6Z43tltm1GqNSrfndvAums01Tu7vbfttpHzvAZaeymJhuksGINixSG8O2tR1aU69TdQNaN9PNpqmdH/egYgOYmUu27X4XhFNEsdT1HPWSZhwX4xvTNjODmPnJHOknK0Vb43peLAA7Ds+oc3UtQDOIwMWC5lsN46Kj5/qVtVm2VQxsyxNONQz9R3EQETnAllU9nAkPiL1YtjwyJffL2BxorM2epYRAZyulrYyaV5ECbFnuZ0C8CkBRlChRpvplYg7IlD0wUBMLCTFwVUnpl0TJs8gAtqzql0FYJgPV9d6yREXJ0DB9yb7ZGXA9kMH4vlLaQiKqhulrZJtIALas6nUg/J103gc3HCwNkP3G602lHxOup+GtugbYtquXMPBN6XayGy6iYPhEfQwDmXGfUtqniWjoNCPEALoCeNCezKv7khuC8+M0CYLM4BUlVfh8N72HBthxqsfVGesA5PsKVTcQjG7bULy8Lxj4eknpXwv7hFAAW5XKX6BGjwAwxHgh626/RMsBOYIcqAyaNwn0t0pp3wnzhI4BZuZdLNv9FRF26e9zw7C8/TZiCBGDCACX83xEGD+wjgD2PC8cdyOAw8UPqljsGzHahytcTXEkEBs2GK8qpc3s1IGgI4Atu3oVBo/7YBhab/rchuNzqq1kqvY8PoEHTUM7gUhsIu2VtgFuKFWevbRYyGfST6o9knuzlu24jfUYlyqle9vSdkpbADPzzpbtbibCDn2lqh22Rl8nqHRxng9rdz1uC+CyXVkhLidyjmsUtehH3++xLQ7458nM/ETJLMxup1FLgMuVymyqkefF35+a22FpvHWcAddzAWp36zQhwMxMllP9FYE+nIUt0dvvWNj4xGZsejazgQQt0f3LTxyEWfvv0bLeeBX8qVrOkU1D26uVVj0hwEF3G2WkOzXffMePceXytdj2bs/Ff43C6sMzpuOWy88KDbTvLECgW5TSzpvobRkXYIkNsmx3CxH+LO1DhCVX34Xldz4U+q3PYsPtpyisW7EkFMhBe3U+p32oWKT/HY/GcQG2rOpFcr6btmL12OPP4oRF12QRo67HdNTsGVi3ckmofpoKF/j2kip8riOAmblg2e6rRNgpbek959IVWH3fz0IxoRcarVtxEY766P6hhtrYG9cI2j7jBayPKcGWU7kATDekLb1C9YHHL8HW194KxYBeaPSVc0/CJYvnhxqqL8UEWq6UtnisTkYBzMyaZbtbibBr2tIrA54ya1Eo4nulUTcAC40NKa4qQ5tGRP83ku5RANu2eyaDb8+C9PYBbv2aVqt1L4yVgStLSv9qS4Atu7oBwMez4ls1kQR3+/a3Zl80NeKkoalRM14zTX3ahACXmXcjx31FzpjT3vf6A42TOdHA17qXuGnwT5tyhGMNQx+2nxw2Rdt29asMXCExRGKWzEKJmzlJ0Bg3DX5wmyytI7dMwwC27MoLAH0gC8qVz/jDT/kann5ubNNkf4oeej0bylZZGdpOwTwhTYAbflb/JU2yMj0HpUvs0Js2b8V/PPwk7lz7U7zzno0+wEMcCpgvz1BKu9P/ZgjghrdGFg4V2pk271j7U6/aGfPntFM91TpxT9FC3JD/Ft9jqsKpowAuW5UniOiQLE3PqaIS4cOTANjfEzPjDyVT33EYwMy8ve24XjaYLEzPW159Ey+//hbeftfCtncs7DltJ0zfdUfvdy+WpAAeGKh5WfryOW1WsUibhFfeFG1Z7qkgXpO2cUOOBGXq3bR5bKVKjtlkSj79pDmY+j4vr2hPlKQAbmYQIL7QNAr/1AS4bFf+mUCL0vK3EsVp6bK72rY5y1Hb8ssX4cS5B/cBDnCg6bfFWGua+slDEmxXngfog4VCPvFUgVctv887yA9TFp9xLK5esiBM00TbJCXBzXUY2FZS+lQPYGZWtuNaaay/N636MZZes6YrZp+38Bgsu/i0rvqIu3GSAPvrMEHbU3J/UKXCH3Fr7i+TBjjKg/zV/3hBpqfrJAGWdE1i2coRjpe8H9RIu3BP0qEoUZ7z7rHbjnjmQUkukM2SJMDNUJeGokW2Xb2UgcuTNHCIpnzeZdHmG/nWRQtw/pnHZhLhJAH27dK+EwBZdmUVQGckGeO74MIbcP8Gb1WIrMgW6mffDx1GG9k4xuooSYADscUbTKXPJcuuisPT4UlasOLy0nh54w2Z3B8nCbCvSQP8sqkKe1DZrjwlju1JRS2IlWrmvItjkZhuHNhiGVCj03QAhmMqXckU/RuA9pGYoyRySEapPY8EpQ/wIEf8SERlaIosq/oKCNP6AMcnw0lLsB+/xIa2G5Wt6lsSvZDUIUN/ih7+IsVxpu0DnM9pB4qSJVYslRTAQt60Iy7wDuyjLu8+tSLqLiPpL2kJ9n20CDhKAPbSASQJcBzRChK1t+b6L0QCSNSdJA2w792RI/pUKhIch6K1/PKzMuvdkTTAQ16WdIKswW8Q4c+TlGCRkHl/czU2PvFcJMJy5KH74YF/iWfrFcUA0wK4MUUPHhUmpUX7DHvq2a2Yd9ayrtfi922n8MDKcGGYUYDXTh9JA+wrWVpeO4jKVuWXRPSRpAEWxshB/+lfvLEdHo1bJ6qpWZaNjb8IN6McOXu/CSME0wI4R9resgY/BuDIpCxZI5ESxi648MaOJVkk9+qLT4ts3b3y5rW46pb7Qr1srbY6SQMcMHTsTGW7ej8BJ6QFsHBU9sbnXrqi7TVZ1lwBt5tcFyORnIwAm0onsm13OYPPzUKwmUizTNs/fPhJz6syWMSr8qiPzvAkNmzA9ETiOVkA9oPRmPG7kqnvSpZT+SKYvp2Ww91ETBdFTEqUkjre8yYLwIGEaT8xlf5xchx3Xp15XZYCzkIthF02miwAS6ywxAwz+LaSKpxDjcsif5u2T3SX+HTdfLIA7AeEg/Fl09SvHXR8t6uS6TKftLGja1Qi7GCyANzMTEt0YsnQfugBXLYrmwg0M6m9sEQK3r9hUJna8tqbzUgGcbsRBUqUqalTTMhWaPspZjOM5bHHN0MUMT/yQervudtO+NTcg3Hk7BnjhrZEZVSJ8H1qdtVqi9XpMx3HlXQOyJG2j2HQ8z7At8nNW3Fr0gKs+EFL+GccZeH8OV5I6VgxTFkFOUqAAxr02yVT30F47Mcmeben5OV20Jgi+8WTUsJTkkhFOJ51KwrLWdQvZpQA+woWwHebquCFfHgAM/P7bcd9XT7HsQ5fvGwNJLAsySLSLPkgR5Y4jiq7oStKN6PmhZfE55SMgtyyPpSVv2xXfk2gA+QeBnGCj6p0o7x0O4axQI7To6TT8c7cbzp+/oPoXH19E2WOtH0Ng347DGDLcm8E8flR+kdnYUoca7rOQnLTqE/BAumUXjFNfbr/sjVFtTzgnkx1vjeq/bAoVDPnLUlkzZ1IciTU9OkHlg3zlxaFa85nv96pwEVWXyT31ivCpxMeayCB5KTDbktrAszMuu24fwCwXRTbpTSn5pEMGEuRkfGlUWRLF4fp1d8eEXC0UvrDoyS4sR++VVLFR2GX3n3OBalLbxDArDrkRfGSBQK/X1NK2z147c7IRGhHMiDnw11p02lPgWMxLeshpt0A7YeMjnXB9Ch12bKqL4OwezexSlmann3GnX7SEbj1ismZuXboTiXtg0rRi8GXZRTAZbv6DQIu6+Z0KY7owW7ecGmbdce8sPQFrr573DT1w0b2MxrgwYSkWwBoYb08ovSYDEv4yHaTFeAh6aXPKaXd3hLghrLlXYQVVor7AEf1Wk7cT8A0uUUZ+j5ENHj/XaCMabJyHN6vzq7c5JELY9nKmjlQ6M1y5EPY16EZZEa8uGQUlo/Vz/i3rtiVuwH6bJgDiDgiF8IywW8XlXttt+OIqn0zhTDjTVN56fwrHQE8MMAza3XXS4cXRoqzpGhFbfONCqRu+vGlF4yLTFP/h/H6mvBUwbIrawA6NYz5UkyV5162IvJcHJ0yRZSru67/QiZTO3RKi18/oDm/opQ2g4i8PGcdSbBUbhwj/kbMl2H3xTJdy1nw1lffDEtPqHZ7TBNPj0MynT8rDGHirSFmSSk5wnGGoU94DtvyXDBL9xeGYchka+NbrcD4V9PUT2lFX0uAvRtI7erjRHSopuUgx4n9kg4HAimS3lOGJtuiN1qNpCXA0kFD4ZLEVvkwClerQfS/b48DgW3ReSWjcEs7rdoCWDryb2SRBkbKV822Q9hkq9OcmoH1ytCODZ4YTURr2wDLVG077iMAPhbWwjXZmJ4UPSP2vAcQUdsaa9sA+1q1Zbu/JsIOcbvYJsW8rD+n4YojyrPsVo9RSl/fyZg7Alg6tgbcT6PO/yaf++txJ6wOVzdg0Pi2aepf6rSXjgEeXI8HQ05lq2wUNYrQCbPT8U/q+s0wFPCmkirMCkNsKIDlClrbcX8EYK50UEwoDWIYAnu1jQ+uJBVVhj6biH4fhpZQADfW45KkfyCig8OYMsMM9k+lTdMFh/FWPqcdZhj0QljaQwPcAHlH26n+HKB9+yCHhWB4u2b4J2Bznj9WKhR+0U3PXQE8uB7zHnV2/4cIuwjIxUIyWWu7ITqrbf3QEwAuAccqpcu2tKvSNcDy9MEg8up6gPaUv6Pwq+6Kqh5sPLTmwsoR5o+8BzgsSZEA3Jiud7bs6n8S0UH9LVRncPhX4UjiFF3T5hUKFNl9B5EB3FS8HPcHBBwvf4c9YuyMPb1bW4wYAxUX8hvgZ8H6caZJY9/rF5LMSAH2x1C2K98h0Ofl7yRvcwnJg1SaDTnMeY/fqAztRCLyLgiNssQC8KDy5S5isOQpNPrK13DIAsqUBPBeq4ra0rE8IqMAOjaAZXCVCh/k1qr3ArSX/B1laGoUxCfdh8QQCbjejAy8xzk6s1TU/j3OccQKcGNdnmLb7h0gnCR//6lKc+C4T3JYbcpBnz8yzCQOoGMHuLkuO5VziOkaAFPk/6KIYIyDIVH32Tjq806DvBce+GZJ6ZdG/Zzx+ksM4IY072w71evkpjVPmgHW9TyJIjbZirjXiFVKpuVGeSRH2rmGQZuTpDUVzlpW9QgQrwRoRgNoiL+X/PR6qdUZ4tbqAyt72xzR3yulrU6DtlQADkzb5xHjKwA1c0rI1C1A99oRpGx7BNjBPa24HOOPINxoGtq1RLQtDXB94Unr2Q1GsOY4tb9i1JfKoYU/GHELkqlbAM9qESkVYGWd9Qsz3iDgOqW0m4ionPbYU5XgkcRblruAUb+IiA4JfifxUXktl/j182OBI2urACrSOrzwC0y41izqK4nISRtY//mZAtgf1MAAH1Bj969Rx0K5di/ILE+yc4RcniLN5zUeIDLliqTW6sMl1Z+Gc0T3MPMq09Tjyc/Y5ZuSSYCDNDlO9Zg68yJm+qQ4+42kVwCXxG2yZlPgc6d8ESCZGSKh3uf60OcRfVlgPIQ8fdcsavd2+pyk62ce4CBDypXKoeTS0Uw4Wu4EklwxrRjmEdig0nMeE/AatiRfIWrVB4DHCFjPjIeyKqnj0dBTAI9es6tziGjfOvgDAO9FIO93UCtvA7yGsofXifAiwC8x6MUc6CWAnzcM7b8nit5rt/+06vU0wBMxjZlLAEqOAzOXg+lStZSrkWLmSj6vl5lRLhYhYZdlIno3LQDifu7/A/8NDCZtejmIAAAAAElFTkSuQmCC\" data-filename=\"Group 186.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><font color=\"#B4102C\">9699</font></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\">Horas de Ingles</p>', '<p>0</p>', 'ACTIVE', '2021-02-21 00:59:43', '2021-02-21 00:59:43', NULL, 3, 0, 0, '%'),
(28, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 188.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><font color=\"#B4102C\">+853</font></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\">Horas de Tutorías Personalizadas</p>', '<p>0</p>', 'ACTIVE', '2021-02-21 01:00:22', '2021-02-21 01:00:22', NULL, 3, 0, 0, '%'),
(29, '<p style=\"font-size: 14.4px;\"><img src=\"data:image/png;base64,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\" data-filename=\"Group 190.png\" style=\"width: 120px;\"><font color=\"#B4102C\"><br></font></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"></p><p style=\"font-size: 14.4px;\"><span style=\"font-size: 0.9rem;\"><font color=\"#b4102c\">+853</font></span></p><p style=\"margin-bottom: 1rem; font-size: 14.4px;\"><span style=\"font-size: 0.9rem;\">Aulas con Tecnología Educativa</span></p>', '<p>0</p>', 'ACTIVE', '2021-02-21 01:01:01', '2021-02-21 01:01:01', NULL, 3, 0, 0, '%'),
(30, '<p><span style=\"color: rgb(180, 16, 44); font-size: 0.9rem;\">9699</span><br></p><p>Beneficiarios de Proyectos Solidarios</p>', 'null', 'ACTIVE', '2021-03-22 21:24:35', '2021-03-22 21:26:16', NULL, 1, 4865, 75, '%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_disbursement`
--

DROP TABLE IF EXISTS `business_disbursement`;
CREATE TABLE IF NOT EXISTS `business_disbursement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `account_number` varchar(150) NOT NULL,
  `type_account` int(11) NOT NULL DEFAULT '0' COMMENT '0=CORRIENTE\n1=AHORROS',
  PRIMARY KEY (`id`),
  KEY `fk_business_disbursement_business1_idx` (`business_id`),
  KEY `fk_business_disbursement_bank1_idx` (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_disbursement`
--

INSERT INTO `business_disbursement` (`id`, `business_id`, `bank_id`, `account_number`, `type_account`) VALUES
(1, 1, 1, '2201497611', 0),
(2, 2, 4, '2201497611', 1),
(3, 3, 4, '00096', 1),
(4, 4, 4, '00096', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_discount_by_product`
--

DROP TABLE IF EXISTS `business_discount_by_product`;
CREATE TABLE IF NOT EXISTS `business_discount_by_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL,
  `en_time` datetime NOT NULL,
  `percentage` float NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `products_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_promotion_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_history_by_data`
--

DROP TABLE IF EXISTS `business_history_by_data`;
CREATE TABLE IF NOT EXISTS `business_history_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `business_by_history_id` int(11) NOT NULL,
  `title_icon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_history_by_data_business_by_history1_idx` (`business_by_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_history_by_data`
--

INSERT INTO `business_history_by_data` (`id`, `title`, `description`, `status`, `source`, `allow_source`, `business_by_history_id`, `title_icon`) VALUES
(1, '<p>Imagi</p>', '<p>adad</p>', 'ACTIVE', '/uploads/web/news-data/images/1614708149_a1.jpg', 1, 1, 'none'),
(2, '<p>ad</p>', '<p>ad</p>', 'ACTIVE', '/uploads/web/news-data/images/1614708392_a2.jpg', 1, 1, 'none'),
(3, '<p>Nuestras Aulas</p>', '<p>Tecnología de Punta&nbsp;</p>', 'ACTIVE', '/uploads/web/news-data/images/1614710085_c1.jpg', 1, 3, 'none'),
(4, '<p>2</p>', '<p>2</p>', 'ACTIVE', '/uploads/web/news-data/images/1614710487_a1.jpg', 1, 3, 'none'),
(5, '<p>3</p>', '<p>3</p>', 'ACTIVE', '/uploads/web/news-data/images/1614710504_a2.jpg', 1, 3, 'none'),
(6, '<p>1</p>', '<p>1</p>', 'ACTIVE', '/uploads/web/news-data/images/1614709615_b2.jpg', 1, 2, 'none'),
(7, '<p>2</p>', '<p>2</p>', 'ACTIVE', '/uploads/web/news-data/images/1614711422_d1.jpg', 1, 2, 'none'),
(8, '<p>3</p>', '<p>3</p>', 'ACTIVE', '/uploads/web/news-data/images/1614711464_b3.jpg', 1, 2, 'none'),
(9, '<p>3</p>', '<p>3</p>', 'ACTIVE', '/uploads/web/news-data/images/1614709041_a3.jpg', 1, 1, 'none');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_location`
--

DROP TABLE IF EXISTS `business_location`;
CREATE TABLE IF NOT EXISTS `business_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zones_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_location_business1_idx` (`business_id`),
  KEY `fk_business_location_zones1_idx` (`zones_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_location`
--

INSERT INTO `business_location` (`id`, `zones_id`, `business_id`) VALUES
(1, 2, 1),
(2, 22, 2),
(3, 22, 3),
(4, 5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_panorama_by_points`
--

DROP TABLE IF EXISTS `business_panorama_by_points`;
CREATE TABLE IF NOT EXISTS `business_panorama_by_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_by_panorama_id` int(11) NOT NULL,
  `panorama_points_id` int(11) NOT NULL,
  `panorama_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_panorama_by_breakdown_business_by_panorama1_idx` (`business_by_panorama_id`),
  KEY `fk_business_panorama_by_breakdown_panorama_points1_idx` (`panorama_points_id`),
  KEY `fk_business_panorama_by_points_panorama1_idx` (`panorama_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_schedule_by_breakdown`
--

DROP TABLE IF EXISTS `business_schedule_by_breakdown`;
CREATE TABLE IF NOT EXISTS `business_schedule_by_breakdown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` time NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `business_by_schedule_id` int(11) NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_schedule_by_breakdown_business_by_schedule1_idx` (`business_by_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_subcategories`
--

DROP TABLE IF EXISTS `business_subcategories`;
CREATE TABLE IF NOT EXISTS `business_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_categories_id` int(11) NOT NULL,
  `src` varchar(250) NOT NULL,
  `has_icon` int(11) NOT NULL DEFAULT '0',
  `icon_class` varchar(20) NOT NULL DEFAULT 'anyone',
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_business_subcategories_business_categories1_idx` (`business_categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `business_subcategories`
--

INSERT INTO `business_subcategories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_categories_id`, `src`, `has_icon`, `icon_class`, `description`) VALUES
(1, 'Restaurantes', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(2, 'Cafeterias', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(3, 'Heladerias', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(4, 'Reposteria ', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(5, 'Bar', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(6, 'Vegetariana', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(7, 'Carnes al Carbon', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(8, 'Mariscos', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(9, 'Italiana', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(10, 'Peruana', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(11, 'Francesas', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(12, 'Mexicanas', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(13, 'Chifas', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(14, 'Fast Food', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(15, 'Arabe', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(16, 'Otros', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(17, 'Parques', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(18, 'Gimnasio', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(19, 'Galeria de Arte', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(20, 'Atracciones', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(21, 'Musica en Vivo', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(22, 'Cine', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(23, 'Museo', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(24, 'Naturaleza', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(25, 'Bibliotecas', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(26, 'Otros', 'ACTIVE', NULL, NULL, NULL, 2, 'no-manager', 0, 'anyone', ''),
(27, 'Limpieza e higiene', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(28, 'Estetica y belleza', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(29, 'Tiendas y bazares', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(30, 'Papelerias', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(31, 'Supermercados', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(32, 'Electrodomesticos', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(33, 'Mobiliario', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(34, 'Abarrotes ', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(35, 'Motos/Bicicletas', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(36, 'Automotriz', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(37, 'Calzado', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(38, 'Agricultura', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(39, 'Otros', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(40, 'Oficios', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
(41, 'Hospedaje', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(42, 'Servicios financieros ', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(43, 'Servicios profesionales', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(44, 'Servicios empresariales', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(45, 'Logistica', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(46, 'Educacion', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(47, 'Otros', 'ACTIVE', NULL, NULL, NULL, 4, 'no-manager', 0, 'anyone', ''),
(48, 'Hospitales', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(49, 'Industria Farmaceutica', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(50, 'Consultorio medico ', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(51, 'Clinicas ', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(52, 'Veterinaria', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(53, 'Otros', 'ACTIVE', NULL, NULL, NULL, 5, 'no-manager', 0, 'anyone', ''),
(54, 'Ferreterias', 'ACTIVE', NULL, NULL, NULL, 6, 'no-manager', 0, 'anyone', ''),
(55, 'Materiales de construccion', 'ACTIVE', NULL, NULL, NULL, 6, 'no-manager', 0, 'anyone', ''),
(56, 'Maquinaria pesada', 'ACTIVE', NULL, NULL, NULL, 6, 'no-manager', 0, 'anyone', ''),
(57, 'Constructoras', 'ACTIVE', NULL, NULL, NULL, 6, 'no-manager', 0, 'anyone', ''),
(58, 'Otros', 'ACTIVE', NULL, NULL, NULL, 6, 'no-manager', 0, 'anyone', ''),
(59, 'Empresa textil', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(60, 'Venta de ropa', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(61, 'Venta de telas', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(62, 'Boutique', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(63, 'Produccion textil', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(64, 'Ropa y complementos', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(65, 'Otros', 'ACTIVE', NULL, NULL, NULL, 7, 'no-manager', 0, 'anyone', ''),
(66, 'Terrestre', 'ACTIVE', NULL, NULL, NULL, 8, 'no-manager', 0, 'anyone', ''),
(67, 'Aereo', 'ACTIVE', NULL, NULL, NULL, 8, 'no-manager', 0, 'anyone', ''),
(68, 'Acuatico', 'ACTIVE', NULL, NULL, NULL, 8, 'no-manager', 0, 'anyone', ''),
(69, 'Otros', 'ACTIVE', NULL, NULL, NULL, 8, 'no-manager', 0, 'anyone', ''),
(70, 'Escuelas', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(71, 'Colegios', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(72, 'Educacion Inicial ', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(73, 'Educacion Inicial 2 ', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(74, 'Universidades', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', ''),
(75, 'Universidad de 4 Nivel', 'ACTIVE', NULL, NULL, NULL, 3, 'no-manager', 0, 'anyone', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bussiness_by_repair`
--

DROP TABLE IF EXISTS `bussiness_by_repair`;
CREATE TABLE IF NOT EXISTS `bussiness_by_repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repair_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bussiness_by_repair_repair1_idx` (`repair_id`),
  KEY `fk_bussiness_by_repair_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `location` point NOT NULL,
  `province_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `place_id` varchar(200) DEFAULT 'none-id',
  PRIMARY KEY (`id`),
  KEY `fk_cities_provinces1_idx` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `name`, `location`, `province_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`) VALUES
(1, 'Otavalo', 0x000000000101000000254774aeac9053c004eae6459ab6cd3f, 15, 'ACTIVE', '2020-05-20 16:41:43', '2020-05-20 16:41:43', NULL, 'none-id'),
(2, 'Ibarra', 0x00000000010100000010c935aa788853c01b199aa1a737d63f, 15, 'ACTIVE', '2020-05-20 16:50:44', '2020-05-20 16:50:44', NULL, 'none-id'),
(3, 'Atuntaqui', 0x000000000101000000f10ae995d78d53c0af29eb92cc45d53f, 15, 'ACTIVE', '2020-05-20 16:50:57', '2020-07-16 22:24:50', NULL, 'none-id'),
(4, 'Cotacachi', 0x0000000001010000003d4ff2d9f09053c0451559c6e1a7d33f, 15, 'ACTIVE', '2020-05-20 16:51:09', '2020-05-20 16:51:09', NULL, 'none-id'),
(5, 'Huaca', 0x000000000101000000173f32c2806e53c0372dc25e722de43f, 12, 'ACTIVE', '2020-07-14 00:34:28', '2020-07-16 04:54:27', NULL, 'none-id'),
(6, 'Tulcán', 0x000000000101000000c503caa6dc6d53c095c84ff40a15ea3f, 12, 'ACTIVE', '2020-07-16 04:48:28', '2020-07-16 04:48:28', NULL, 'none-id'),
(7, 'Bolívar', 0x00000000010100000040f61f3ed57953c0be8eeed6e80be03f, 12, 'ACTIVE', '2020-07-16 04:54:12', '2020-07-16 04:54:12', NULL, 'none-id'),
(8, 'Espejo', 0x000000000101000000a1919df1dc7a53c039260f343418e03f, 12, 'ACTIVE', '2020-07-16 04:56:36', '2020-07-16 04:56:55', NULL, 'none-id'),
(9, 'Mira', 0x000000000101000000f04284c99e8253c090279364679be13f, 12, 'ACTIVE', '2020-07-16 04:57:14', '2020-07-16 04:57:14', NULL, 'none-id'),
(10, 'Montufar', 0x000000000101000000cc7c073f717153c023d74d29af15e23f, 12, 'ACTIVE', '2020-07-16 04:57:36', '2020-07-16 04:57:36', NULL, 'none-id'),
(11, 'Cuenca', 0x0000000001010000004caab69b60c053c08e942d92763307c0, 9, 'ACTIVE', '2020-07-16 04:58:36', '2020-07-16 04:58:36', NULL, 'none-id'),
(12, 'Camilo Ponce Enríquez', 0x000000000101000000600c9bb7a0ef53c0af42ca4faa7d08c0, 9, 'ACTIVE', '2020-07-16 04:58:52', '2020-07-16 04:58:52', NULL, 'none-id'),
(13, 'Chordeleg', 0x00000000010100000038ff65add7b153c029835957bb6c07c0, 9, 'ACTIVE', '2020-07-16 04:59:11', '2020-07-16 05:00:50', NULL, 'none-id'),
(14, 'El Pan', 0x000000000101000000cbc1c7bb7eaa53c06ab3fb9f0d4a06c0, 9, 'ACTIVE', '2020-07-16 04:59:32', '2020-07-16 04:59:32', NULL, 'none-id'),
(15, 'Girón', 0x0000000001010000003ba4bd665ec953c0abfead090e4409c0, 9, 'ACTIVE', '2020-07-16 04:59:48', '2020-07-16 04:59:48', NULL, 'none-id'),
(16, 'Guachapala', 0x000000000101000000cc33e5f9c2ad53c0bbb0daa1062806c0, 9, 'ACTIVE', '2020-07-16 05:00:06', '2020-07-16 05:00:06', NULL, 'none-id'),
(17, 'Gualaceo', 0x000000000101000000d968ef42a9b153c0d751d504511707c0, 9, 'ACTIVE', '2020-07-16 05:00:25', '2020-07-16 05:00:25', NULL, 'none-id'),
(18, 'Nabon', 0x00000000010100000066a60fb809c453c00de94bca38b10ac0, 9, 'ACTIVE', '2020-07-16 05:01:20', '2020-07-16 05:01:20', NULL, 'none-id'),
(19, 'Oña', 0x000000000101000000e2b43bffd1c953c0e26def6481c00bc0, 9, 'ACTIVE', '2020-07-16 05:01:40', '2020-07-16 05:01:40', NULL, 'none-id'),
(20, 'Paute', 0x00000000010100000032079c001eb153c0dc0da2b5a25d06c0, 9, 'ACTIVE', '2020-07-16 05:02:00', '2020-07-16 05:02:00', NULL, 'none-id'),
(21, 'Pucará', 0x0000000001010000009d41e84512de53c03058bb37d0bd09c0, 9, 'ACTIVE', '2020-07-16 05:02:17', '2020-07-16 05:02:17', NULL, 'none-id'),
(22, 'San Fernando', 0x000000000101000000d5bb2eb253d053c023d74d29af2509c0, 9, 'ACTIVE', '2020-07-16 05:05:56', '2020-07-16 05:05:56', NULL, 'none-id'),
(23, 'Santa Isabel', 0x0000000001010000004a46cec21ed453c081bd78f5e0340ac0, 9, 'ACTIVE', '2020-07-16 05:06:12', '2020-07-16 05:06:12', NULL, 'none-id'),
(24, 'Sevilla de Oro', 0x0000000001010000003c743051f3a953c0ed6877a3ea6206c0, 9, 'ACTIVE', '2020-07-16 05:06:29', '2020-07-16 05:06:29', NULL, 'none-id'),
(25, 'Sigsig', 0x0000000001010000002da8b926eeb253c0bfa9fef7966808c0, 9, 'ACTIVE', '2020-07-16 05:06:44', '2020-07-16 05:06:44', NULL, 'none-id'),
(26, 'Guaranda', 0x000000000101000000bbfda83cf0bf53c0f77deeba6d75f9bf, 10, 'ACTIVE', '2020-07-16 05:08:53', '2020-07-16 05:08:53', NULL, 'none-id'),
(27, 'Caluma', 0x00000000010100000012f8c3cf7fd053c0a222f36d6619fabf, 10, 'ACTIVE', '2020-07-16 05:09:34', '2020-07-16 05:09:34', NULL, 'none-id'),
(28, 'Chillanes', 0x000000000101000000252eb6ff37c453c0b31fce685019ffbf, 10, 'ACTIVE', '2020-07-16 05:09:56', '2020-07-16 05:09:56', NULL, 'none-id'),
(29, 'Chimbo', 0x0000000001010000006c596375d0c153c041834d9d47e5fabf, 10, 'ACTIVE', '2020-07-16 05:10:15', '2020-07-16 05:10:15', NULL, 'none-id'),
(30, 'Echeandía', 0x000000000101000000a06cca15ded153c0ed815660c8eaf6bf, 10, 'ACTIVE', '2020-07-16 05:10:32', '2020-07-16 05:10:32', NULL, 'none-id'),
(31, 'Las Naves', 0x00000000010100000039ed293927d453c0c7455acfb594f4bf, 10, 'ACTIVE', '2020-07-16 05:10:51', '2020-07-16 05:10:51', NULL, 'none-id'),
(32, 'San Miguel', 0x0000000001010000008395f9fd51c253c0c319b2704879fbbf, 10, 'ACTIVE', '2020-07-16 05:12:03', '2020-07-16 05:12:03', NULL, 'none-id'),
(33, 'Azogues', 0x0000000001010000008e26721c53b653c0418754ac75ed05c0, 11, 'ACTIVE', '2020-07-16 05:17:12', '2020-07-16 05:17:12', NULL, 'none-id'),
(34, 'Biblián', 0x00000000010100000000f1a952e9b853c03345ca60d6b505c0, 11, 'ACTIVE', '2020-07-16 05:17:28', '2020-07-16 05:17:28', NULL, 'none-id'),
(35, 'Cañar', 0x00000000010100000019ee128bcebb53c0e0675c38107204c0, 11, 'ACTIVE', '2020-07-16 05:17:51', '2020-07-16 05:17:51', NULL, 'none-id'),
(36, 'Déleg', 0x000000000101000000902fa18243bb53c0a327c00bb64c06c0, 11, 'ACTIVE', '2020-07-16 05:18:07', '2020-07-16 05:18:07', NULL, 'none-id'),
(37, 'El Tambo', 0x000000000101000000902fa18243bb53c08c92a174331d04c0, 11, 'ACTIVE', '2020-07-16 05:18:27', '2020-07-16 05:18:27', NULL, 'none-id'),
(38, 'La Troncal', 0x00000000010100000030568ad3ffd553c0c23d85121c5d03c0, 11, 'ACTIVE', '2020-07-16 05:18:46', '2020-07-16 05:18:46', NULL, 'none-id'),
(39, 'Suscal', 0x00000000010100000018891a9650c353c00bf956da987d03c0, 11, 'ACTIVE', '2020-07-16 05:19:02', '2020-07-16 05:19:02', NULL, 'none-id'),
(40, 'Riobamba', 0x00000000010100000031c225112baa53c0d98fb9d7eea3fabf, 14, 'ACTIVE', '2020-07-16 05:19:44', '2020-07-16 05:19:44', NULL, 'none-id'),
(41, 'Alausí', 0x0000000001010000004c080c4831b653c0aa0d4e44bf9601c0, 14, 'ACTIVE', '2020-07-16 05:19:57', '2020-07-16 05:19:57', NULL, 'none-id'),
(42, 'Chambo', 0x0000000001010000003bd972d30ba653c01989754fc3bcfbbf, 14, 'ACTIVE', '2020-07-16 05:20:15', '2020-07-16 05:20:15', NULL, 'none-id'),
(43, 'Chunchi', 0x0000000001010000000781f0fcfdba53c09fa97c748f5102c0, 14, 'ACTIVE', '2020-07-16 05:20:28', '2020-07-16 05:20:28', NULL, 'none-id'),
(44, 'Colta', 0x000000000101000000a9f17794efb053c0a96a82a8fbc0fbbf, 14, 'ACTIVE', '2020-07-16 05:22:06', '2020-07-16 05:22:06', NULL, 'none-id'),
(45, 'Cumanda', 0x000000000101000000f3db210f8ec853c0c689af7614a701c0, 14, 'ACTIVE', '2020-07-16 05:22:23', '2020-07-16 05:22:23', NULL, 'none-id'),
(46, 'Guamote', 0x00000000010100000019d8744e7dad53c0ea8fd552e500ffbf, 14, 'ACTIVE', '2020-07-16 05:22:41', '2020-07-16 05:22:41', NULL, 'none-id'),
(47, 'Guano', 0x00000000010100000024fbd63d68a853c09b30abc145b8f9bf, 14, 'ACTIVE', '2020-07-16 05:22:55', '2020-07-16 05:22:55', NULL, 'none-id'),
(48, 'Pallatanga', 0x000000000101000000caa31b6151be53c0b5d320167b2900c0, 14, 'ACTIVE', '2020-07-16 05:23:10', '2020-07-16 05:23:10', NULL, 'none-id'),
(49, 'Penipe', 0x0000000001010000009a9fd10c98a253c0412553aae9dff8bf, 14, 'ACTIVE', '2020-07-16 05:23:23', '2020-07-16 05:23:23', NULL, 'none-id'),
(50, 'Latacunga', 0x0000000001010000000612143fc6a653c0fc8f4c874ecfedbf, 13, 'ACTIVE', '2020-07-16 05:23:56', '2020-07-16 05:23:56', NULL, 'none-id'),
(51, 'La Maná', 0x00000000010100000071276c9ad2ce53c0062f55c4441eeebf, 13, 'ACTIVE', '2020-07-16 05:24:12', '2020-07-16 05:24:12', NULL, 'none-id'),
(52, 'Pujilí', 0x0000000001010000000d1f6c0c95ac53c0c51c041dadaaeebf, 13, 'ACTIVE', '2020-07-16 05:24:54', '2020-07-16 05:24:54', NULL, 'none-id'),
(53, 'Salcedo', 0x00000000010100000001c34da1cea553c0aedbfbafceacf0bf, 13, 'ACTIVE', '2020-07-16 05:25:10', '2020-07-16 05:25:10', NULL, 'none-id'),
(54, 'Saquisilí', 0x0000000001010000004e999b6fc4aa53c0a4e771738552eabf, 13, 'ACTIVE', '2020-07-16 05:25:29', '2020-07-16 05:25:29', NULL, 'none-id'),
(55, 'Sigchos', 0x000000000101000000cc892c88b7b853c08cf1063d405ce6bf, 13, 'ACTIVE', '2020-07-16 05:25:41', '2020-07-16 05:25:41', NULL, 'none-id'),
(56, 'Pangua', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 13, 'ACTIVE', '2020-07-16 05:26:08', '2020-07-16 05:26:32', NULL, 'none-id'),
(57, 'Machala', 0x00000000010100000034362a2625fd53c0bcd9d59a9c100ac0, 8, 'ACTIVE', '2020-07-16 05:27:30', '2020-07-16 05:27:30', NULL, 'none-id'),
(58, 'Arenillas', 0x000000000101000000a4479dca330454c0647b88a130730cc0, 8, 'ACTIVE', '2020-07-16 05:27:42', '2020-07-16 05:27:42', NULL, 'none-id'),
(59, 'Atahualpa', 0x000000000101000000c507d1b58a3154c022fc8ba0318302c0, 8, 'ACTIVE', '2020-07-16 05:28:01', '2020-07-16 05:28:01', NULL, 'none-id'),
(60, 'Balsas', 0x00000000010100000075b05989d4f453c082154ca198110ec0, 8, 'ACTIVE', '2020-07-16 05:28:17', '2020-07-16 05:28:17', NULL, 'none-id'),
(61, 'Chilla', 0x00000000010100000067ce9fdbf0e453c0a3eb1dc940a90bc0, 8, 'ACTIVE', '2020-07-16 05:28:37', '2020-07-16 05:28:37', NULL, 'none-id'),
(62, 'El Guabo', 0x000000000101000000ceb348c961f453c03912c3691ce509c0, 8, 'ACTIVE', '2020-07-16 05:28:50', '2020-07-16 05:28:50', NULL, 'none-id'),
(63, 'Huaquillas', 0x00000000010100000045798b2c3e0e54c06625f785a1cf0bc0, 8, 'ACTIVE', '2020-07-16 05:29:10', '2020-07-16 05:29:10', NULL, 'none-id'),
(64, 'Marcabelí', 0x000000000101000000d9ffa5b162fa53c022235635f7460ec0, 8, 'ACTIVE', '2020-07-16 05:29:46', '2020-07-16 05:29:46', NULL, 'none-id'),
(65, 'Las Lajas', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 8, 'ACTIVE', '2020-07-16 05:30:05', '2020-07-16 05:30:05', NULL, 'none-id'),
(66, 'Pasaje', 0x000000000101000000bcbf8b0890f353c0e3fa1cc4739b0ac0, 8, 'ACTIVE', '2020-07-16 05:30:21', '2020-07-16 05:30:21', NULL, 'none-id'),
(67, 'Piñas', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 8, 'ACTIVE', '2020-07-16 05:30:44', '2020-07-16 05:30:44', NULL, 'none-id'),
(68, 'Portovelo', 0x000000000101000000d59ddd1019e753c0f34b0ee901bd0dc0, 8, 'ACTIVE', '2020-07-16 05:31:06', '2020-07-16 05:31:06', NULL, 'none-id'),
(69, 'Santa Rosa', 0x000000000101000000feb04a8ee0fd53c082300109d4ac0bc0, 8, 'ACTIVE', '2020-07-16 05:31:21', '2020-07-16 05:31:21', NULL, 'none-id'),
(70, 'Zaruma', 0x000000000101000000d59ddd1019e753c088765fdf987f0dc0, 8, 'ACTIVE', '2020-07-16 05:31:36', '2020-07-16 05:31:36', NULL, 'none-id'),
(71, 'Esmeraldas', 0x0000000001010000002049a4c8b5e953c011ac055152fbee3f, 2, 'ACTIVE', '2020-07-16 05:32:20', '2020-07-16 05:32:20', NULL, 'none-id'),
(72, 'Atacames', 0x0000000001010000001fad20bc2cf653c0024466d3b6c6eb3f, 2, 'ACTIVE', '2020-07-16 05:32:35', '2020-07-16 05:32:35', NULL, 'none-id'),
(73, 'Eloy Alfaro', 0x0000000001010000008d11e4fbbdf553c093fe5e0a0f5a01c0, 2, 'ACTIVE', '2020-07-16 05:32:44', '2020-07-16 05:32:44', NULL, 'none-id'),
(74, 'Muisne', 0x000000000101000000ee5f5969520154c04523e9e45692e33f, 2, 'ACTIVE', '2020-07-16 05:33:38', '2020-07-16 05:33:38', NULL, 'none-id'),
(75, 'Quinindé', 0x000000000101000000637891aebedd53c091f8cbdd9debd43f, 2, 'ACTIVE', '2020-07-16 05:33:59', '2020-07-16 05:35:16', NULL, 'none-id'),
(76, 'Río Verde', 0x0000000001010000004e4354e1cfd953c0f279c5538ff4f03f, 2, 'ACTIVE', '2020-07-16 05:34:36', '2020-07-16 05:34:36', NULL, 'none-id'),
(77, 'San Lorenzo', 0x000000000101000000f38d8de502b653c07c708802c74ff43f, 2, 'ACTIVE', '2020-07-16 05:35:00', '2020-07-16 05:35:00', NULL, 'none-id'),
(78, 'San Cristóbal, Galápagos', 0x000000000101000000778ab03ca36356c07c04a337810eedbf, 1, 'ACTIVE', '2020-07-16 05:36:35', '2020-07-16 05:36:35', NULL, 'none-id'),
(79, 'Isabella', 0x000000000101000000ce6a05768a1754c00c86c6555d3efb3f, 1, 'ACTIVE', '2020-07-16 05:38:03', '2020-07-16 05:39:50', NULL, 'none-id'),
(80, 'Santa Cruz', 0x00000000010100000066666666669656c0d42f6c281011e1bf, 1, 'ACTIVE', '2020-07-16 05:39:08', '2020-07-16 05:39:08', NULL, 'none-id'),
(81, 'Guayaquil', 0x000000000101000000a83eeb75e6f853c0e18cabdbea8301c0, 6, 'ACTIVE', '2020-07-16 18:12:05', '2020-07-16 18:12:05', NULL, 'none-id'),
(82, 'Alfredo Baquerizo Moreno', 0x00000000010100000032cdcf6886e353c04dafdef2a240febf, 6, 'ACTIVE', '2020-07-16 18:12:29', '2020-07-16 18:12:29', NULL, 'none-id'),
(83, 'Balao', 0x000000000101000000eb3b1ae233f453c0c0ab8a15da4e07c0, 6, 'ACTIVE', '2020-07-16 18:15:26', '2020-07-16 18:15:26', NULL, 'none-id'),
(84, 'Balzar', 0x000000000101000000ae19cf5694f953c0d9a0e52fe3dcf5bf, 6, 'ACTIVE', '2020-07-16 18:15:40', '2020-07-16 18:15:40', NULL, 'none-id'),
(85, 'Colimes', 0x000000000101000000995423aaa60054c091e2d2e759bff8bf, 6, 'ACTIVE', '2020-07-16 18:16:03', '2020-07-16 18:16:16', NULL, 'none-id'),
(86, 'Daule', 0x0000000001010000000954ff2092fe53c0963e74417dcbfdbf, 6, 'ACTIVE', '2020-07-16 18:16:29', '2020-07-16 18:16:29', NULL, 'none-id'),
(87, 'Durán', 0x0000000001010000008d11e4fbbdf553c093fe5e0a0f5a01c0, 6, 'ACTIVE', '2020-07-16 18:16:42', '2020-07-16 18:16:42', NULL, 'none-id'),
(88, 'El Empalme', 0x0000000001010000008ed36b0eebe653c0b89d6cb9e9c5f0bf, 6, 'ACTIVE', '2020-07-16 18:16:53', '2020-07-16 18:16:53', NULL, 'none-id'),
(89, 'El Triunfo', 0x000000000101000000642c89a2f6d953c01dc6490625a102c0, 6, 'ACTIVE', '2020-07-16 22:11:56', '2020-07-16 22:11:56', NULL, 'none-id'),
(90, 'General Antonio Elizalde', 0x000000000101000000b4194c68b7cb53c01f6228cc208301c0, 6, 'ACTIVE', '2020-07-16 22:14:04', '2020-07-16 22:14:04', NULL, 'none-id'),
(91, 'Isidro Ayora', 0x0000000001010000003b2bb352520954c02dba50549125febf, 6, 'ACTIVE', '2020-07-16 22:14:29', '2020-07-16 22:14:29', NULL, 'none-id'),
(92, 'Lomas de Sargentillo', 0x000000000101000000285426eba60554c0925ed4ee5701febf, 6, 'ACTIVE', '2020-07-16 22:14:48', '2020-07-16 22:14:48', NULL, 'none-id'),
(93, 'Coronel Marcelino Maridueña', 0x0000000001010000004ccfaa85c8d953c0853d923765f301c0, 6, 'ACTIVE', '2020-07-16 22:15:07', '2020-07-16 22:15:07', NULL, 'none-id'),
(94, 'Milagro', 0x000000000101000000edfe678302e653c05f950b957f1d01c0, 6, 'ACTIVE', '2020-07-16 22:15:22', '2020-07-16 22:15:22', NULL, 'none-id'),
(95, 'Naranjal', 0x000000000101000000d768de16d1e753c0c7c33181115a05c0, 6, 'ACTIVE', '2020-07-16 22:15:34', '2020-07-16 22:15:34', NULL, 'none-id'),
(96, 'Naranjito', 0x000000000101000000ef9705c9f1db53c050fbad9d286901c0, 6, 'ACTIVE', '2020-07-16 22:17:40', '2020-07-16 22:17:40', NULL, 'none-id'),
(97, 'Nobol', 0x00000000010100000076995077d40054c0f156a71485a7febf, 6, 'ACTIVE', '2020-07-16 22:17:56', '2020-07-16 22:17:56', NULL, 'none-id'),
(98, 'Palestina', 0x000000000101000000b24813ef80fe53c0a1061dbe9601fabf, 6, 'ACTIVE', '2020-07-16 22:18:32', '2020-07-16 22:18:32', NULL, 'none-id'),
(99, 'Pedro Carbo', 0x00000000010100000043c0c69a360f54c0d1b01875ad1dfdbf, 6, 'ACTIVE', '2020-07-16 22:18:53', '2020-07-16 22:18:53', NULL, 'none-id'),
(100, 'Playas', 0x0000000001010000003ef90505ef1854c0ed9458631a0705c0, 6, 'ACTIVE', '2020-07-16 22:19:09', '2020-07-16 22:19:09', NULL, 'none-id'),
(101, 'Salitre', 0x000000000101000000eb3b1ae233f453c0fe96a542e158fdbf, 6, 'ACTIVE', '2020-07-16 22:20:07', '2020-07-16 22:20:07', NULL, 'none-id'),
(102, 'Samborondón', 0x00000000010100000060556243dcf753c08ffe976bd1b200c0, 6, 'ACTIVE', '2020-07-16 22:20:22', '2020-07-16 22:20:22', NULL, 'none-id'),
(103, 'Santa Lucía', 0x000000000101000000015130630aff53c0b16d5166836cfbbf, 6, 'ACTIVE', '2020-07-16 22:21:10', '2020-07-16 22:21:10', NULL, 'none-id'),
(104, 'Simón Bolívar', 0x000000000101000000e18cabdb6a5c53c04ceabaa6f6d89cbf, 6, 'ACTIVE', '2020-07-16 22:21:25', '2020-07-16 22:21:25', NULL, 'none-id'),
(105, 'Yaguachi', 0x0000000001010000007e575fb84eec53c079f475cf70c900c0, 6, 'ACTIVE', '2020-07-16 22:21:52', '2020-07-16 22:21:52', NULL, 'none-id'),
(106, 'Pimampiro', 0x000000000101000000c54d57c1397c53c04e588748f201d93f, 15, 'ACTIVE', '2020-07-16 22:23:07', '2020-07-16 22:23:07', NULL, 'none-id'),
(107, 'Urcuqui', 0x0000000001010000004cb093556c8c53c0a2f14410e7e1da3f, 15, 'ACTIVE', '2020-07-16 22:23:22', '2020-07-16 22:23:22', NULL, 'none-id'),
(108, 'Loja', 0x0000000001010000009ef98b8f85cd53c078be558d140810c0, 16, 'ACTIVE', '2020-07-16 22:25:45', '2020-07-16 22:25:45', NULL, 'none-id'),
(109, 'Calvas', 0x00000000010100000073486aa164e353c0d90a9a96584911c0, 16, 'ACTIVE', '2020-07-16 22:26:01', '2020-07-16 22:26:01', NULL, 'none-id'),
(110, 'Celica', 0x00000000010100000009ac771357fd53c0288293c8996910c0, 16, 'ACTIVE', '2020-07-16 22:27:19', '2020-07-16 22:27:19', NULL, 'none-id'),
(111, 'Catamayo', 0x0000000001010000005c621ba7d7d653c074e151746ee40fc0, 16, 'ACTIVE', '2020-07-16 22:27:42', '2020-07-16 22:27:42', NULL, 'none-id'),
(112, 'Chaguarpamba', 0x00000000010100000085aa3d914ce953c037c2a2224e070fc0, 16, 'ACTIVE', '2020-07-16 22:31:25', '2020-07-16 22:31:34', NULL, 'none-id'),
(113, 'Gonzanamá', 0x000000000101000000729879bcdadb53c006f52d73baec10c0, 16, 'ACTIVE', '2020-07-16 22:32:04', '2020-07-16 22:32:04', NULL, 'none-id'),
(114, 'Macará', 0x0000000001010000008599113958fc53c01c0d3be7028a11c0, 16, 'ACTIVE', '2020-07-16 22:35:34', '2020-07-16 22:35:34', NULL, 'none-id'),
(115, 'Olmedo', 0x000000000101000000d154f42c2d8553c02fe065868db2c13f, 16, 'ACTIVE', '2020-07-16 22:35:51', '2020-07-16 22:35:51', NULL, 'none-id'),
(116, 'Paltas', 0x000000000101000000c4d155babbcb53c0befa78e8bbbb09c0, 16, 'ACTIVE', '2020-07-16 22:36:08', '2020-07-16 22:36:08', NULL, 'none-id'),
(117, 'Quilanga', 0x0000000001010000008731e9efa5d953c021883dfe1c3011c0, 16, 'ACTIVE', '2020-07-16 22:42:21', '2020-07-16 22:42:21', NULL, 'none-id'),
(118, 'Saraguro', 0x000000000101000000b191da7a3ccf53c07ada86f656f90cc0, 16, 'ACTIVE', '2020-07-16 22:42:36', '2020-07-16 22:42:36', NULL, 'none-id'),
(119, 'Zapotillo', 0x00000000010100000074a37ecda80f54c0c563f5fd8a8b11c0, 16, 'ACTIVE', '2020-07-16 22:43:14', '2020-07-16 22:43:14', NULL, 'none-id'),
(120, 'Sozoranga', 0x000000000101000000b9f2a32ba2f253c073f15c84ce5011c0, 16, 'ACTIVE', '2020-07-16 22:43:31', '2020-07-16 22:43:31', NULL, 'none-id'),
(121, 'Pindal', 0x00000000010100000000506ad4e80654c07c2aa73d257710c0, 16, 'ACTIVE', '2020-07-16 22:45:54', '2020-07-16 22:45:54', NULL, 'none-id'),
(122, 'Babahoyo', 0x00000000010100000031dc6fa337e253c058fe7c5bb0d4fcbf, 4, 'ACTIVE', '2020-07-16 22:48:38', '2020-07-16 22:48:38', NULL, 'none-id'),
(123, 'Baba', 0x000000000101000000481adcd696eb53c08e9da685817dfcbf, 4, 'ACTIVE', '2020-07-16 22:48:55', '2020-07-16 22:48:55', NULL, 'none-id'),
(124, 'Buena Fe', 0x0000000001010000008e45894c2fdf53c01bb226bb3e58ecbf, 4, 'ACTIVE', '2020-07-16 22:49:09', '2020-07-16 22:49:09', NULL, 'none-id'),
(125, 'Mocache', 0x000000000101000000b5519d0e64e053c08ac8b08a37f2f2bf, 4, 'ACTIVE', '2020-07-16 22:49:26', '2020-07-16 22:49:26', NULL, 'none-id'),
(126, 'Montalvo', 0x0000000001010000008ba141af64d253c0480845a9739bfcbf, 4, 'ACTIVE', '2020-07-16 22:49:41', '2020-07-16 22:49:41', NULL, 'none-id'),
(127, 'Palenque', 0x000000000101000000207d93a641f053c0186426ace8eaf6bf, 4, 'ACTIVE', '2020-07-16 22:49:57', '2020-07-16 22:49:57', NULL, 'none-id'),
(128, 'Puebloviejo', 0x0000000001010000002a38bc2022e253c0cdccccccccccf8bf, 4, 'ACTIVE', '2020-07-16 22:50:15', '2020-07-16 22:50:15', NULL, 'none-id'),
(129, 'Quevedo', 0x000000000101000000b1dd3d4077dd53c050125cf6355cf0bf, 4, 'ACTIVE', '2020-07-16 22:50:27', '2020-07-16 22:50:27', NULL, 'none-id'),
(130, 'Quinsaloma', 0x0000000001010000007965cd7e13d453c093a7aca6eb49f3bf, 4, 'ACTIVE', '2020-07-16 22:50:43', '2020-07-16 22:50:43', NULL, 'none-id'),
(131, 'Urdaneta', 0x000000000101000000de3994a12acd53c0bb287ae063d00cc0, 4, 'ACTIVE', '2020-07-16 22:50:57', '2020-07-16 22:50:57', NULL, 'none-id'),
(132, 'Valencia', 0x0000000001010000004da9013997d653c0a6d7c11c9877eebf, 4, 'ACTIVE', '2020-07-16 22:51:11', '2020-07-16 22:51:11', NULL, 'none-id'),
(133, 'Ventanas', 0x000000000101000000ced9a78878dd53c0434e0416651bf7bf, 4, 'ACTIVE', '2020-07-16 22:51:19', '2020-07-16 22:51:19', NULL, 'none-id'),
(134, 'Vínces', 0x0000000001010000000fd99b73cbf053c0d33252efa9dcf8bf, 4, 'ACTIVE', '2020-07-16 22:51:39', '2020-07-16 22:51:51', NULL, 'none-id'),
(135, 'Portoviejo', 0x0000000001010000007610e099f51c54c0946c753925e0f0bf, 3, 'ACTIVE', '2020-07-16 22:52:23', '2020-07-16 22:52:23', NULL, 'none-id'),
(136, '24 de Mayo', 0x000000000101000000731e04d39fe053c02a5ec026c66df0bf, 3, 'ACTIVE', '2020-07-16 22:52:41', '2020-07-16 22:52:53', NULL, 'none-id'),
(137, 'Chone', 0x000000000101000000ada580b4ff0654c0a5b448241bd9e6bf, 3, 'ACTIVE', '2020-07-16 22:53:22', '2020-07-16 22:53:22', NULL, 'none-id'),
(138, 'El Carmen', 0x000000000101000000637891aebedd53c03ed57cf0355fd1bf, 3, 'ACTIVE', '2020-07-16 22:53:56', '2020-07-16 22:53:56', NULL, 'none-id'),
(139, 'Flavio Alfaro', 0x000000000101000000ff918e17f7f953c0ba241818c3e6d9bf, 3, 'ACTIVE', '2020-07-16 22:55:08', '2020-07-16 22:55:19', NULL, 'none-id'),
(140, 'Jama', 0x0000000001010000000c0f50d0dc1054c01e4e603aaddbc9bf, 3, 'ACTIVE', '2020-07-16 22:55:33', '2020-07-16 22:55:33', NULL, 'none-id'),
(141, 'Jaramijó', 0x00000000010100000077ab9d17dd2854c0d2f654f3c197eebf, 3, 'ACTIVE', '2020-07-16 22:55:53', '2020-07-16 22:56:03', NULL, 'none-id'),
(142, 'Jipijapa', 0x000000000101000000569f06674b2554c01f20a9cf1fa4f5bf, 3, 'ACTIVE', '2020-07-16 22:56:20', '2020-07-16 22:56:20', NULL, 'none-id'),
(143, 'Junín', 0x000000000101000000c14c8006400d54c01a8e42ed12b0edbf, 3, 'ACTIVE', '2020-07-16 22:56:34', '2020-07-16 22:56:43', NULL, 'none-id'),
(144, 'Manta', 0x00000000010100000076d377c85e2d54c02ebaab0d04f7eebf, 3, 'ACTIVE', '2020-07-16 22:56:56', '2020-07-16 22:56:56', NULL, 'none-id'),
(145, 'Montecristi', 0x000000000101000000affdae192a2a54c0bc1fb75f3eb9f0bf, 3, 'ACTIVE', '2020-07-16 22:58:50', '2020-07-16 22:59:01', NULL, 'none-id'),
(146, 'Paján', 0x000000000101000000daff006b551b54c061a417b5fbd5f8bf, 3, 'ACTIVE', '2020-07-16 22:59:46', '2020-07-16 23:00:14', NULL, 'none-id'),
(147, 'Pedernales', 0x000000000101000000fecf06054a0354c06be33e28deb7b23f, 3, 'ACTIVE', '2020-07-16 23:01:01', '2020-07-16 23:01:01', NULL, 'none-id'),
(148, 'Pichincha', 0x000000000101000000b7dc4f7cebf453c0012f336c94b5f0bf, 3, 'ACTIVE', '2020-07-17 01:07:21', '2020-07-17 01:07:45', NULL, 'none-id'),
(149, 'Puerto López', 0x00000000010100000090f1cddb7d3354c0a738b302e8dcf8bf, 3, 'ACTIVE', '2020-07-17 01:08:31', '2020-07-17 01:08:44', NULL, 'none-id'),
(150, 'Rocafuerte', 0x000000000101000000605b9ab6da1c54c0f9b605f0bb8eedbf, 3, 'ACTIVE', '2020-07-17 01:09:13', '2020-07-17 01:09:13', NULL, 'none-id'),
(151, 'San Vicente', 0x00000000010100000005db8827bb1954c046ae4099eb59e3bf, 3, 'ACTIVE', '2020-07-17 01:09:50', '2020-07-17 01:09:50', NULL, 'none-id'),
(152, 'Santa Ana', 0x0000000001010000006bed22f1971754c0acadd85f764ff3bf, 3, 'ACTIVE', '2020-07-17 01:10:21', '2020-07-17 01:10:21', NULL, 'none-id'),
(153, 'Sucre', 0x00000000010100000012691b7fa29f53c0d34d62105839f4bf, 3, 'ACTIVE', '2020-07-17 01:10:38', '2020-07-17 01:10:38', NULL, 'none-id'),
(154, 'Tosagua', 0x000000000101000000c55d1844ff0e54c081f91a385618e9bf, 3, 'ACTIVE', '2020-07-17 01:10:51', '2020-07-17 01:10:51', NULL, 'none-id'),
(155, 'Morona', 0x0000000001010000000a9e42ae54c053c022437d810f34fbbf, 19, 'ACTIVE', '2020-07-17 01:11:25', '2020-07-17 01:12:29', NULL, 'none-id'),
(156, 'Gualaquiza', 0x000000000101000000d0e341c497a453c0ce0b660234400bc0, 19, 'ACTIVE', '2020-07-17 02:24:31', '2020-07-17 02:24:31', NULL, 'none-id'),
(157, 'Huamboya', 0x000000000101000000cf6bec12557f53c0687748314022ffbf, 19, 'ACTIVE', '2020-07-17 02:24:49', '2020-07-17 02:24:49', NULL, 'none-id'),
(158, 'Indanza', 0x00000000010100000041a264cd239f53c0d50792770e8508c0, 19, 'ACTIVE', '2020-07-17 02:25:59', '2020-07-17 02:25:59', NULL, 'none-id'),
(159, 'Logroño', 0x0000000001010000003f8b4a8f4b8d53c0e0ee512404f004c0, 19, 'ACTIVE', '2020-07-17 02:26:16', '2020-07-17 02:26:16', NULL, 'none-id'),
(160, 'Pablo Sexto', 0x000000000101000000c740e8ead88f53c0d457a192844efdbf, 19, 'ACTIVE', '2020-07-17 02:26:37', '2020-07-17 02:26:37', NULL, 'none-id'),
(161, 'Palora', 0x000000000101000000a05edf3df67d53c00b1fb699af37fbbf, 19, 'ACTIVE', '2020-07-17 02:26:55', '2020-07-17 02:26:55', NULL, 'none-id'),
(162, 'San Juan Bosco', 0x000000000101000000aef204c24ea153c02db0c7444ad308c0, 19, 'ACTIVE', '2020-07-17 02:27:30', '2020-07-17 02:27:30', NULL, 'none-id'),
(163, 'Santiago de Mendez', 0x00000000010100000027f6d03e569453c01764cbf275b905c0, 19, 'ACTIVE', '2020-07-17 02:27:57', '2020-07-17 02:27:57', NULL, 'none-id'),
(164, 'Sucúa', 0x000000000101000000515557f4bd8a53c04e5fcfd72ca703c0, 19, 'ACTIVE', '2020-07-17 02:28:41', '2020-07-17 02:28:41', NULL, 'none-id'),
(165, 'Taisha', 0x0000000001010000008599b67f655d53c018946934b9b802c0, 19, 'ACTIVE', '2020-07-17 02:29:01', '2020-07-17 02:29:01', NULL, 'none-id'),
(166, 'tiwintza', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 19, 'ACTIVE', '2020-07-17 02:29:26', '2020-07-17 02:29:26', NULL, 'none-id'),
(167, 'Tena', 0x000000000101000000501a6a14127453c0791563aaaae1efbf, 20, 'ACTIVE', '2020-07-17 02:32:31', '2020-07-17 02:32:31', NULL, 'none-id'),
(168, 'Archidona', 0x00000000010100000078cd5081b87353c037024c74f112edbf, 20, 'ACTIVE', '2020-07-17 02:32:56', '2020-07-17 02:32:56', NULL, 'none-id'),
(169, 'Carlos Julio Arosemena Tola', 0x000000000101000000935e8a61bd7653c0ea002d0208a4f2bf, 20, 'ACTIVE', '2020-07-17 02:33:18', '2020-07-17 02:33:18', NULL, 'none-id'),
(170, 'El Chaco', 0x000000000101000000d1dc54eecf7353c04eb0a481c49bd5bf, 20, 'ACTIVE', '2020-07-17 02:33:39', '2020-07-17 02:33:39', NULL, 'none-id'),
(171, 'Francisco de Orellana', 0x000000000101000000991a57128f3f53c0d6f95c120c8cddbf, 21, 'ACTIVE', '2020-07-17 02:34:44', '2020-07-17 02:34:44', NULL, 'none-id'),
(172, 'Aguarico', 0x0000000001010000007061dd7877f752c0132a38bc2022d2bf, 21, 'ACTIVE', '2020-07-17 02:35:00', '2020-07-17 02:35:00', NULL, 'none-id'),
(173, 'La Joya de los Sachas', 0x00000000010100000084ec61d4da3653c0af33cf5b8649d3bf, 21, 'ACTIVE', '2020-07-17 02:35:23', '2020-07-17 02:35:23', NULL, 'none-id'),
(174, 'Loreto', 0x000000000101000000891e42a6c65353c07d9b59a6ba1be6bf, 21, 'ACTIVE', '2020-07-17 02:35:41', '2020-07-17 02:35:41', NULL, 'none-id'),
(175, 'Arajuno', 0x000000000101000000348639419b6b53c0726bd26d89dcf3bf, 22, 'ACTIVE', '2020-07-17 02:36:40', '2020-07-17 02:36:40', NULL, 'none-id'),
(176, 'Mera', 0x0000000001010000008e42ed12308753c0fd2a65be2866f7bf, 22, 'ACTIVE', '2020-07-17 02:37:01', '2020-07-17 02:37:01', NULL, 'none-id'),
(177, 'Santa Clara', 0x000000000101000000f7764b72c07853c068d608b3bf42f4bf, 22, 'ACTIVE', '2020-07-17 02:37:21', '2020-07-17 02:37:21', NULL, 'none-id'),
(178, 'Quito', 0x0000000001010000007334a20ff19d53c0be78f5e0a41fc7bf, 17, 'ACTIVE', '2020-07-17 02:38:29', '2020-07-17 02:38:29', NULL, 'none-id'),
(179, 'Cayambe', 0x00000000010100000027c8be1a568953c0d93add1e29c7a53f, 17, 'ACTIVE', '2020-07-17 02:40:12', '2020-07-17 02:40:12', NULL, 'none-id'),
(180, 'Mejia', 0x0000000001010000009b2ca4b2171e54c08768194e3ea2efbf, 17, 'ACTIVE', '2020-07-17 02:40:29', '2020-07-17 02:40:29', NULL, 'none-id'),
(181, 'Pedro Vicente Maldonado', 0x0000000001010000003082c64c22c353c0f59f353ffed2b43f, 17, 'ACTIVE', '2020-07-17 02:40:53', '2020-07-17 02:40:53', NULL, 'none-id'),
(182, 'Puerto Quito', 0x00000000010100000009fb761211d153c01bbe8575e3ddbd3f, 17, 'ACTIVE', '2020-07-17 02:41:18', '2020-07-17 02:41:18', NULL, 'none-id'),
(183, 'San Miguel de Los Bancos', 0x0000000001010000001e25654117b953c00facf424fac6993f, 17, 'ACTIVE', '2020-07-17 02:42:07', '2020-07-17 02:42:07', NULL, 'none-id'),
(184, 'Santa Elena', 0x0000000001010000001e8cd827003754c0134abac1abd001c0, 5, 'ACTIVE', '2020-07-17 02:43:30', '2020-07-17 02:43:30', NULL, 'none-id'),
(185, 'La Libertad', 0x000000000101000000aab3ffa69c3954c0de0951195ad801c0, 5, 'ACTIVE', '2020-07-17 02:43:53', '2020-07-17 02:43:53', NULL, 'none-id'),
(186, 'Salinas', 0x0000000001010000005c1d0071573d54c05a03a5b272c901c0, 5, 'ACTIVE', '2020-07-17 02:44:13', '2020-07-17 02:44:13', NULL, 'none-id'),
(187, 'La Concordia', 0x000000000101000000cefc6a0e10d953c0682f91c140c6823f, 7, 'ACTIVE', '2020-07-17 02:44:47', '2020-07-17 02:44:47', NULL, 'none-id'),
(188, 'Santo Domingo', 0x000000000101000000f8718f0049cb53c014bcd7ffef3ed0bf, 7, 'ACTIVE', '2020-07-17 02:45:08', '2020-07-17 02:45:08', NULL, 'none-id'),
(189, 'Cuyabeno', 0x0000000001010000006b44d554bbe752c03a2e9919ec3cd7bf, 23, 'ACTIVE', '2020-07-17 02:48:24', '2020-07-17 02:48:24', NULL, 'none-id'),
(190, 'Gonzalo Pizarro', 0x000000000101000000b0e42a16bf5653c01eb0613c39f9abbf, 23, 'ACTIVE', '2020-07-17 02:48:46', '2020-07-17 02:48:46', NULL, 'none-id'),
(191, 'Putumayo', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 02:49:19', '2020-07-17 02:49:19', NULL, 'none-id'),
(192, 'Shushufindi', 0x000000000101000000c97cf612192953c037b75384e519c8bf, 23, 'ACTIVE', '2020-07-17 02:49:39', '2020-07-17 02:49:39', NULL, 'none-id'),
(193, 'Sucumbios', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 02:50:07', '2020-07-17 02:50:07', NULL, 'none-id'),
(194, 'Cascales', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 02:50:24', '2020-07-17 02:50:24', NULL, 'none-id'),
(195, 'Lago Agrio', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 02:50:45', '2020-07-17 02:50:45', NULL, 'none-id'),
(196, 'Rumiñahui', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 17, 'ACTIVE', '2020-07-17 02:51:17', '2020-07-27 01:54:24', NULL, 'none-id'),
(197, 'Ambato', 0x0000000001010000003c93ecc7dca753c09a9da0a8c711f4bf, 18, 'ACTIVE', '2020-07-17 02:52:01', '2020-07-17 02:52:01', NULL, 'none-id'),
(198, 'Baños', 0x0000000001010000000c1de0ee519b53c088e64bb90c49f6bf, 18, 'ACTIVE', '2020-07-17 02:52:20', '2020-07-17 02:52:20', NULL, 'none-id'),
(199, 'Cevallos', 0x0000000001010000002a73f38d68a753c06379fc83edacf5bf, 18, 'ACTIVE', '2020-07-17 02:52:36', '2020-07-17 02:52:36', NULL, 'none-id'),
(200, 'Mocha', 0x000000000101000000482355ca21aa53c047cf882d98b3f6bf, 18, 'ACTIVE', '2020-07-17 02:52:51', '2020-07-17 02:52:51', NULL, 'none-id'),
(201, 'Patate', 0x00000000010100000071a9efa169a053c0fe65f7e46101f5bf, 18, 'ACTIVE', '2020-07-17 02:53:07', '2020-07-17 02:53:07', NULL, 'none-id'),
(202, 'Quero', 0x000000000101000000fa2d9512dda653c0d091a68b5e17f6bf, 18, 'ACTIVE', '2020-07-17 02:53:23', '2020-07-17 02:53:23', NULL, 'none-id'),
(203, 'Pelileo', 0x000000000101000000d4e29d8da6a253c0017f42870a3ff5bf, 18, 'ACTIVE', '2020-07-17 02:53:48', '2020-07-17 02:53:48', NULL, 'none-id'),
(204, 'Píllaro', 0x000000000101000000f2666897caa253c00a4b3ca06ccaf2bf, 18, 'ACTIVE', '2020-07-17 02:54:08', '2020-07-17 02:54:08', NULL, 'none-id'),
(205, 'Tisaleo', 0x00000000010100000024e18cabdbaa53c0ee2c301ae890f5bf, 18, 'ACTIVE', '2020-07-17 02:54:25', '2020-07-17 02:54:25', NULL, 'none-id'),
(206, 'Zamora', 0x000000000101000000f04e3e3db6bc53c025198398953f10c0, 24, 'ACTIVE', '2020-07-17 02:55:37', '2020-07-17 02:55:37', NULL, 'none-id'),
(207, 'Centinela', 0x000000000101000000f70489edeefe52c00492b06f2711913f, 24, 'ACTIVE', '2020-07-17 02:56:19', '2020-07-17 02:56:19', NULL, 'none-id'),
(208, 'Nangaritza', 0x00000000010100000006781c5080a553c0fffe3971de040dc0, 24, 'ACTIVE', '2020-07-17 02:57:12', '2020-07-17 02:57:12', NULL, 'none-id'),
(209, 'Chinchipe', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 02:57:30', '2020-07-17 02:57:30', NULL, 'none-id'),
(210, 'Palanda', 0x0000000001010000006a50340f60c853c02accd655dc9b12c0, 24, 'ACTIVE', '2020-07-17 02:57:52', '2020-07-17 02:57:52', NULL, 'none-id'),
(211, 'Paquisha', 0x0000000001010000001fe10f9a38ab53c0399105f126740fc0, 24, 'ACTIVE', '2020-07-17 02:58:17', '2020-07-17 02:58:17', NULL, 'none-id'),
(212, 'Yacuambi', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 02:58:43', '2020-07-17 02:58:43', NULL, 'none-id'),
(213, 'Yantzaza', 0x000000000101000000567ce827c1b053c0206dd223fca10ec0, 24, 'ACTIVE', '2020-07-17 02:59:02', '2020-07-17 02:59:02', NULL, 'none-id'),
(214, 'Pangui', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 02:59:49', '2020-07-17 02:59:49', NULL, 'none-id'),
(215, 'Sin registro', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 25, 'ACTIVE', '2020-07-27 01:32:30', '2020-07-27 01:32:30', NULL, 'none-id'),
(216, 'SR', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 26, 'INACTIVE', '2020-07-27 01:33:26', '2020-07-27 01:33:40', NULL, 'none-id'),
(217, 'SR1', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 27, 'INACTIVE', '2020-07-27 01:34:04', '2020-07-27 01:34:24', NULL, 'none-id');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinical_by_history_clinic`
--

DROP TABLE IF EXISTS `clinical_by_history_clinic`;
CREATE TABLE IF NOT EXISTS `clinical_by_history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_clinic_id` int(11) NOT NULL,
  `clinical_exam_id` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clinical_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  KEY `fk_clinical_by_history_clinic_clinical_exam1_idx` (`clinical_exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinical_exam`
--

DROP TABLE IF EXISTS `clinical_exam`;
CREATE TABLE IF NOT EXISTS `clinical_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `counter_by_entity`
--

DROP TABLE IF EXISTS `counter_by_entity`;
CREATE TABLE IF NOT EXISTS `counter_by_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_by_counter_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_guess` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_counter_by_schedule_entity_business_by_counter1_idx` (`business_by_counter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `counter_by_entity`
--

INSERT INTO `counter_by_entity` (`id`, `business_by_counter_id`, `created_at`, `updated_at`, `deleted_at`, `is_guess`, `user_id`, `token`) VALUES
(1, 1, '2020-11-24 03:18:44', '2020-11-24 03:18:44', NULL, 0, 1, 'Fm7Ro9YUXltFqfAhoAbEBFwteGURYjXxm07ESKJ9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `counter_by_log_user_to_business`
--

DROP TABLE IF EXISTS `counter_by_log_user_to_business`;
CREATE TABLE IF NOT EXISTS `counter_by_log_user_to_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_guess` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_counter_by_log_user_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `counter_by_log_user_to_business`
--

INSERT INTO `counter_by_log_user_to_business` (`id`, `created_at`, `updated_at`, `deleted_at`, `business_id`, `user_id`, `is_guess`) VALUES
(1, '2020-11-24 03:18:44', '2020-11-24 03:18:44', NULL, 3, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `place_id` varchar(200) DEFAULT 'none-id',
  `iso_codes` varchar(8) NOT NULL,
  `phone_code` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`, `iso_codes`, `phone_code`) VALUES
(1, 'Afghanistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AF / AFG', '93'),
(2, 'Albania', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AL / ALB', '355'),
(3, 'Algeria', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DZ / DZA', '213'),
(4, 'American Samoa', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AS / ASM', '1'),
(5, 'Andorra', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AD / AND', '376'),
(6, 'Angola', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AO / AGO', '244'),
(7, 'Anguilla', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AI / AIA', '1'),
(8, 'Antarctica', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AQ / ATA', '672'),
(9, 'Antigua and Barbuda', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AG / ATG', '1'),
(10, 'Argentina', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AR / ARG', '54'),
(11, 'Armenia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AM / ARM', '374'),
(12, 'Aruba', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AW / ABW', '297'),
(13, 'Australia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AU / AUS', '61'),
(14, 'Austria', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AT / AUT', '43'),
(15, 'Azerbaijan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AZ / AZE', '994'),
(16, 'Bahamas', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BS / BHS', '1'),
(17, 'Bahrain', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BH / BHR', '973'),
(18, 'Ecuador', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'EC / ECU', '593'),
(19, 'Barbados', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BB / BRB', '1'),
(20, 'Belarus', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BY / BLR', '375'),
(21, 'Belgium', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BE / BEL', '32'),
(22, 'Belize', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BZ / BLZ', '501'),
(23, 'Benin', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BJ / BEN', '229'),
(24, 'Bermuda', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BM / BMU', '1'),
(25, 'Bhutan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BT / BTN', '975'),
(26, 'Bolivia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BO / BOL', '591'),
(27, 'Bosnia and Herzegovina', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BA / BIH', '387'),
(28, 'Botswana', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BW / BWA', '267'),
(29, 'Brazil', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BR / BRA', '55'),
(30, 'British Indian Ocean Territory', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IO / IOT', '246'),
(31, 'British Virgin Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VG / VGB', '1'),
(32, 'Brunei', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BN / BRN', '673'),
(33, 'Bulgaria', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BG / BGR', '359'),
(34, 'Burkina Faso', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BF / BFA', '226'),
(35, 'Myanmar', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MM / MMR', '95'),
(36, 'Burundi', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BI / BDI', '257'),
(37, 'Cambodia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KH / KHM', '855'),
(38, 'Cameroon', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CM / CMR', '237'),
(39, 'Canada', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CA / CAN', '1'),
(40, 'Cape Verde', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CV / CPV', '238'),
(41, 'Cayman Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KY / CYM', '1'),
(42, 'Central African Republic', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CF / CAF', '236'),
(43, 'Chad', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TD / TCD', '235'),
(44, 'Chile', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CL / CHL', '56'),
(45, 'China', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CN / CHN', '86'),
(46, 'Christmas Island', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CX / CXR', '61'),
(47, 'Cocos Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CC / CCK', '61'),
(48, 'Colombia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CO / COL', '57'),
(49, 'Comoros', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KM / COM', '269'),
(50, 'Republic of the Congo', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CG / COG', '242'),
(51, 'Democratic Republic of the Congo', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CD / COD', '243'),
(52, 'Cook Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CK / COK', '682'),
(53, 'Costa Rica', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CR / CRI', '506'),
(54, 'Croatia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'HR / HRV', '385'),
(55, 'Cuba', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CU / CUB', '53'),
(56, 'Curacao', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CW / CUW', '599'),
(57, 'Cyprus', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CY / CYP', '357'),
(58, 'Czech Republic', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CZ / CZE', '420'),
(59, 'Denmark', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DK / DNK', '45'),
(60, 'Djibouti', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DJ / DJI', '253'),
(61, 'Dominica', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DM / DMA', '1'),
(62, 'Dominican Republic', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DO / DOM', '1'),
(63, 'East Timor', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TL / TLS', '670'),
(64, 'Bangladesh', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BD / BGD', '880'),
(65, 'Egypt', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'EG / EGY', '20'),
(66, 'El Salvador', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SV / SLV', '503'),
(67, 'Equatorial Guinea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GQ / GNQ', '240'),
(68, 'Eritrea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ER / ERI', '291'),
(69, 'Estonia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'EE / EST', '372'),
(70, 'Ethiopia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ET / ETH', '251'),
(71, 'Sin Especificar', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ZW / ZWE', '263'),
(72, 'Faroe Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FO / FRO', '298'),
(73, 'Fiji', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FJ / FJI', '679'),
(74, 'Finland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FI / FIN', '358'),
(75, 'France', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FR / FRA', '33'),
(76, 'French Polynesia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PF / PYF', '689'),
(77, 'Gabon', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GA / GAB', '241'),
(78, 'Gambia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GM / GMB', '220'),
(79, 'Georgia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GE / GEO', '995'),
(80, 'Germany', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'DE / DEU', '49'),
(81, 'Ghana', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GH / GHA', '233'),
(82, 'Gibraltar', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GI / GIB', '350'),
(83, 'Greece', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GR / GRC', '30'),
(84, 'Greenland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GL / GRL', '299'),
(85, 'Grenada', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GD / GRD', '1'),
(86, 'Guam', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GU / GUM', '1'),
(87, 'Guatemala', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GT / GTM', '502'),
(88, 'Guernsey', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GG / GGY', '44'),
(89, 'Guinea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GN / GIN', '224'),
(90, 'Guinea-Bissau', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GW / GNB', '245'),
(91, 'Guyana', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GY / GUY', '592'),
(92, 'Haiti', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'HT / HTI', '509'),
(93, 'Honduras', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'HN / HND', '504'),
(94, 'Hong Kong', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'HK / HKG', '852'),
(95, 'Hungary', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'HU / HUN', '36'),
(96, 'Iceland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IS / ISL', '354'),
(97, 'India', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IN / IND', '91'),
(98, 'Indonesia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ID / IDN', '62'),
(99, 'Iran', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IR / IRN', '98'),
(100, 'Iraq', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IQ / IRQ', '964'),
(101, 'Ireland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IE / IRL', '353'),
(102, 'Isle of Man', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IM / IMN', '44'),
(103, 'Israel', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IL / ISR', '972'),
(104, 'Italy', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IT / ITA', '39'),
(105, 'Ivory Coast', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CI / CIV', '225'),
(106, 'Jamaica', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'JM / JAM', '1'),
(107, 'Japan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'JP / JPN', '81'),
(108, 'Jersey', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'JE / JEY', '44'),
(109, 'Jordan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'JO / JOR', '962'),
(110, 'Kazakhstan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KZ / KAZ', '7'),
(111, 'Kenya', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KE / KEN', '254'),
(112, 'Kiribati', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KI / KIR', '686'),
(113, 'Kosovo', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'XK / XKX', '383'),
(114, 'Kuwait', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KW / KWT', '965'),
(115, 'Kyrgyzstan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KG / KGZ', '996'),
(116, 'Laos', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LA / LAO', '856'),
(117, 'Latvia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LV / LVA', '371'),
(118, 'Lebanon', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LB / LBN', '961'),
(119, 'Lesotho', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LS / LSO', '266'),
(120, 'Liberia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LR / LBR', '231'),
(121, 'Libya', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LY / LBY', '218'),
(122, 'Liechtenstein', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LI / LIE', '423'),
(123, 'Lithuania', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LT / LTU', '370'),
(124, 'Luxembourg', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LU / LUX', '352'),
(125, 'Macau', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MO / MAC', '853'),
(126, 'Macedonia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MK / MKD', '389'),
(127, 'Madagascar', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MG / MDG', '261'),
(128, 'Malawi', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MW / MWI', '265'),
(129, 'Malaysia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MY / MYS', '60'),
(130, 'Maldives', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MV / MDV', '960'),
(131, 'Mali', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ML / MLI', '223'),
(132, 'Malta', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MT / MLT', '356'),
(133, 'Marshall Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MH / MHL', '692'),
(134, 'Mauritania', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MR / MRT', '222'),
(135, 'Mauritius', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MU / MUS', '230'),
(136, 'Mayotte', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'YT / MYT', '262'),
(137, 'Mexico', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MX / MEX', '52'),
(138, 'Micronesia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FM / FSM', '691'),
(139, 'Moldova', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MD / MDA', '373'),
(140, 'Monaco', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MC / MCO', '377'),
(141, 'Mongolia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MN / MNG', '976'),
(142, 'Montenegro', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ME / MNE', '382'),
(143, 'Montserrat', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MS / MSR', '1'),
(144, 'Morocco', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MA / MAR', '212'),
(145, 'Mozambique', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MZ / MOZ', '258'),
(146, 'Namibia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NA / NAM', '264'),
(147, 'Nauru', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NR / NRU', '674'),
(148, 'Nepal', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NP / NPL', '977'),
(149, 'Netherlands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NL / NLD', '31'),
(150, 'Netherlands Antilles', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AN / ANT', '599'),
(151, 'New Caledonia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NC / NCL', '687'),
(152, 'New Zealand', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NZ / NZL', '64'),
(153, 'Nicaragua', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NI / NIC', '505'),
(154, 'Niger', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NE / NER', '227'),
(155, 'Nigeria', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NG / NGA', '234'),
(156, 'Niue', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NU / NIU', '683'),
(157, 'Northern Mariana Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MP / MNP', '1'),
(158, 'North Korea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KP / PRK', '850'),
(159, 'Norway', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'NO / NOR', '47'),
(160, 'Oman', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'OM / OMN', '968'),
(161, 'Pakistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PK / PAK', '92'),
(162, 'Palau', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PW / PLW', '680'),
(163, 'Palestine', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PS / PSE', '970'),
(164, 'Panama', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PA / PAN', '507'),
(165, 'Papua New Guinea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PG / PNG', '675'),
(166, 'Paraguay', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PY / PRY', '595'),
(167, 'Peru', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PE / PER', '51'),
(168, 'Philippines', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PH / PHL', '63'),
(169, 'Pitcairn', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PN / PCN', '64'),
(170, 'Poland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PL / POL', '48'),
(172, 'Puerto Rico', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PR / PRI', '1, 1'),
(173, 'Qatar', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'QA / QAT', '974'),
(174, 'Reunion', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'RE / REU', '262'),
(175, 'Romania', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'RO / ROU', '40'),
(176, 'Russia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'RU / RUS', '7'),
(177, 'Rwanda', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'RW / RWA', '250'),
(178, 'Saint Barthelemy', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'BL / BLM', '590'),
(179, 'Samoa', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'WS / WSM', '685'),
(180, 'San Marino', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SM / SMR', '378'),
(181, 'Sao Tome and Principe', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ST / STP', '239'),
(182, 'Saudi Arabia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SA / SAU', '966'),
(183, 'Senegal', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SN / SEN', '221'),
(184, 'Serbia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'RS / SRB', '381'),
(185, 'Seychelles', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SC / SYC', '248'),
(186, 'Sierra Leone', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SL / SLE', '232'),
(187, 'Singapore', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SG / SGP', '65'),
(188, 'Sint Maarten', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SX / SXM', '1'),
(189, 'Slovakia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SK / SVK', '421'),
(190, 'Slovenia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SI / SVN', '386'),
(191, 'Solomon Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SB / SLB', '677'),
(192, 'Somalia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SO / SOM', '252'),
(193, 'South Africa', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ZA / ZAF', '27'),
(194, 'South Korea', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KR / KOR', '82'),
(195, 'South Sudan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SS / SSD', '211'),
(196, 'Spain', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ES / ESP', '34'),
(197, 'Sri Lanka', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LK / LKA', '94'),
(198, 'Saint Helena', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SH / SHN', '290'),
(199, 'Saint Kitts and Nevis', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'KN / KNA', '1'),
(200, 'Saint Lucia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'LC / LCA', '1'),
(201, 'Saint Martin', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'MF / MAF', '590'),
(202, 'Saint Pierre and Miquelon', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PM / SPM', '508'),
(203, 'Saint Vincent and the Grenadines', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VC / VCT', '1'),
(204, 'Sudan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SD / SDN', '249'),
(205, 'Suriname', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SR / SUR', '597'),
(206, 'Svalbard and Jan Mayen', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SJ / SJM', '47'),
(207, 'Swaziland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SZ / SWZ', '268'),
(208, 'Sweden', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SE / SWE', '46'),
(209, 'Switzerland', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CH / CHE', '41'),
(210, 'Syria', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'SY / SYR', '963'),
(211, 'Taiwan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TW / TWN', '886'),
(212, 'Tajikistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TJ / TJK', '992'),
(213, 'Tanzania', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TZ / TZA', '255'),
(214, 'Thailand', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TH / THA', '66'),
(215, 'Togo', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TG / TGO', '228'),
(216, 'Tokelau', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TK / TKL', '690'),
(217, 'Tonga', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TO / TON', '676'),
(218, 'Trinidad and Tobago', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TT / TTO', '1'),
(219, 'Tunisia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TN / TUN', '216'),
(220, 'Turkey', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TR / TUR', '90'),
(221, 'Turkmenistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TM / TKM', '993'),
(222, 'Turks and Caicos Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TC / TCA', '1'),
(223, 'Tuvalu', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'TV / TUV', '688'),
(224, 'United Arab Emirates', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AE / ARE', '971'),
(225, 'Uganda', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'UG / UGA', '256'),
(226, 'United Kingdom', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'GB / GBR', '44'),
(227, 'Ukraine', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'UA / UKR', '380'),
(228, 'Uruguay', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'UY / URY', '598'),
(229, 'United States', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'US / USA', '1'),
(230, 'Uzbekistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'UZ / UZB', '998'),
(231, 'Vanuatu', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VU / VUT', '678'),
(232, 'Vatican', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VA / VAT', '379'),
(233, 'Venezuela', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VE / VEN', '58'),
(234, 'Vietnam', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VN / VNM', '84'),
(235, 'U.S. Virgin Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VI / VIR', '1'),
(236, 'Wallis and Futuna', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'WF / WLF', '681'),
(237, 'Western Sahara', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'EH / ESH', '212'),
(238, 'Yemen', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'YE / YEM', '967'),
(239, 'Zambia', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ZM / ZMB', '260'),
(240, 'Zimbabwe', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ZW / ZWE', '263'),
(241, 'Falkland Islands', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'FK / FLK', '500'),
(242, 'Portugal', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'PT / PRT', '351');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `course_faculty_id` int(11) NOT NULL,
  `course_subject_matter_id` int(11) NOT NULL,
  `online` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT ONLINE\n1=ONLINE',
  PRIMARY KEY (`id`),
  KEY `fk_course_course_faculty1_idx` (`course_faculty_id`),
  KEY `fk_course_course_subject_matter1_idx` (`course_subject_matter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course_faculty`
--

DROP TABLE IF EXISTS `course_faculty`;
CREATE TABLE IF NOT EXISTS `course_faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course_subject_matter`
--

DROP TABLE IF EXISTS `course_subject_matter`;
CREATE TABLE IF NOT EXISTS `course_subject_matter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification_document` varchar(45) NOT NULL,
  `src` varchar(250) DEFAULT NULL,
  `people_type_identification_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `business_name` varchar(150) DEFAULT NULL COMMENT 'razon social',
  `business_reason` varchar(150) DEFAULT NULL COMMENT 'razon comercial',
  `ruc_type_id` int(11) NOT NULL,
  `has_representative` int(11) NOT NULL DEFAULT '0',
  `representative_fullname` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_people1_idx` (`people_id`),
  KEY `fk_customer_people_type_identification1_idx` (`people_type_identification_id`),
  KEY `fk_customer_ruc_type1_idx` (`ruc_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_by_information`
--

DROP TABLE IF EXISTS `customer_by_information`;
CREATE TABLE IF NOT EXISTS `customer_by_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `people_nationality_id` int(11) NOT NULL,
  `people_profession_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_by_information_customer1_idx` (`customer_id`),
  KEY `fk_customer_by_information_people_nationality1_idx` (`people_nationality_id`),
  KEY `fk_customer_by_information_people_profession1_idx` (`people_profession_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_by_profile`
--

DROP TABLE IF EXISTS `customer_by_profile`;
CREATE TABLE IF NOT EXISTS `customer_by_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_by_profile_customer1_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_by_student`
--

DROP TABLE IF EXISTS `customer_by_student`;
CREATE TABLE IF NOT EXISTS `customer_by_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_by_student_customer1_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_profile_by_location`
--

DROP TABLE IF EXISTS `customer_profile_by_location`;
CREATE TABLE IF NOT EXISTS `customer_profile_by_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zones_id` int(11) NOT NULL,
  `customer_by_profile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_by_location_zones1_idx` (`zones_id`),
  KEY `fk_users_by_location_customer_by_profile1_idx` (`customer_by_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `daily_book_seat`
--

DROP TABLE IF EXISTS `daily_book_seat`;
CREATE TABLE IF NOT EXISTS `daily_book_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(350) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `register_manager_date` datetime NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dental_piece`
--

DROP TABLE IF EXISTS `dental_piece`;
CREATE TABLE IF NOT EXISTS `dental_piece` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `piece` varchar(5) NOT NULL,
  `dentition` enum('Perm-FDI') DEFAULT 'Perm-FDI',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dental_piece`
--

INSERT INTO `dental_piece` (`id`, `name`, `piece`, `dentition`) VALUES
(1, 'Tercer Molar Superior', '18', 'Perm-FDI'),
(2, 'Segundo Molar Superior', '17', 'Perm-FDI'),
(3, 'Primer Molar Superior', '16', 'Perm-FDI'),
(4, 'Segundo Premolar Superior', '15', 'Perm-FDI'),
(5, 'Primer Premolar Superior', '14', 'Perm-FDI'),
(6, 'Canino Superior', '13', 'Perm-FDI'),
(7, 'Incisivo Lateral Superior', '12', 'Perm-FDI'),
(8, 'Incisivo Central Superior', '11', 'Perm-FDI'),
(9, 'Tercer Molar Inferior', '48', 'Perm-FDI'),
(10, 'Segundo Molar Inferior', '47', 'Perm-FDI'),
(11, 'Primer Molar Inferior', '46', 'Perm-FDI'),
(12, 'Segundo Premolar Inferior', '45', 'Perm-FDI'),
(13, 'Primer Premolar Inferior', '44', 'Perm-FDI'),
(14, 'Canino Inferior', '43', 'Perm-FDI'),
(15, 'Incisivo Lateral Inferior', '42', 'Perm-FDI'),
(16, 'Incisivo Central Inferior', '41', 'Perm-FDI'),
(17, 'Tercer Molar Inferior', '38', 'Perm-FDI'),
(18, 'Segundo Molar Inferior', '37', 'Perm-FDI'),
(19, 'Primer Molar Inferior', '36', 'Perm-FDI'),
(20, 'Segundo Premolar Inferior', '35', 'Perm-FDI'),
(21, 'Primer Premolar Inferior', '34', 'Perm-FDI'),
(22, 'Canino Inferior', '33', 'Perm-FDI'),
(23, 'Incisivo Lateral Inferior', '32', 'Perm-FDI'),
(24, 'Incisivo Central Inferior', '31', 'Perm-FDI'),
(25, 'Tercer Molar Inferior', '28', 'Perm-FDI'),
(26, 'Segundo Molar Superior', '27', 'Perm-FDI'),
(27, 'Primer Molar Superior', '26', 'Perm-FDI'),
(28, 'Segundo Premolar Superior', '25', 'Perm-FDI'),
(29, 'Primer Premolar Superior', '24', 'Perm-FDI'),
(30, 'Canino Superior', '23', 'Perm-FDI'),
(31, 'Incisivo Lateral Superior', '22', 'Perm-FDI'),
(32, 'Incisivo Central Superior', '21', 'Perm-FDI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dental_piece_by_odontogram`
--

DROP TABLE IF EXISTS `dental_piece_by_odontogram`;
CREATE TABLE IF NOT EXISTS `dental_piece_by_odontogram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `type` enum('PERMANENT','TEMPORARY') NOT NULL DEFAULT 'PERMANENT',
  `dental_piece_id` int(11) NOT NULL,
  `reference_piece_position_id` int(11) NOT NULL,
  `reference_piece_id` int(11) NOT NULL,
  `odontogram_by_patient_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dental_piece_by_odontogram_dental_piece1_idx` (`dental_piece_id`),
  KEY `fk_dental_piece_by_odontogram_reference_piece_position1_idx` (`reference_piece_position_id`),
  KEY `fk_dental_piece_by_odontogram_reference_piece1_idx` (`reference_piece_id`),
  KEY `fk_dental_piece_by_odontogram_odontogram_by_patient1_idx` (`odontogram_by_patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diary_book`
--

DROP TABLE IF EXISTS `diary_book`;
CREATE TABLE IF NOT EXISTS `diary_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(10,4) NOT NULL,
  `manager_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 =DEBE entra 1=HABER sale',
  `accounting_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_diary_book_accounting_account1_idx` (`accounting_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discount_by_customers`
--

DROP TABLE IF EXISTS `discount_by_customers`;
CREATE TABLE IF NOT EXISTS `discount_by_customers` (
  `business_by_discount_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`business_by_discount_id`,`customer_id`),
  KEY `fk_discount_by_customers_customer1_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discount_by_products`
--

DROP TABLE IF EXISTS `discount_by_products`;
CREATE TABLE IF NOT EXISTS `discount_by_products` (
  `business_by_discount_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`business_by_discount_id`,`product_id`),
  KEY `fk_discount_by_products_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_askwer_type`
--

DROP TABLE IF EXISTS `educational_institution_askwer_type`;
CREATE TABLE IF NOT EXISTS `educational_institution_askwer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_askwer_type_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_by_business`
--

DROP TABLE IF EXISTS `educational_institution_by_business`;
CREATE TABLE IF NOT EXISTS `educational_institution_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `educational_institution_askwer_type_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `askwer_form_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_by_askwer_educational_institutio_idx` (`educational_institution_askwer_type_id`),
  KEY `fk_educational_institution_by_askwer_business1_idx` (`business_id`),
  KEY `fk_educational_institution_by_business_askwer_form1_idx` (`askwer_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_by_course`
--

DROP TABLE IF EXISTS `educational_institution_by_course`;
CREATE TABLE IF NOT EXISTS `educational_institution_by_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `number_students` int(11) NOT NULL,
  `number_hours` decimal(10,2) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_by_course_course1_idx` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_course_activities_by_askwer`
--

DROP TABLE IF EXISTS `educational_institution_course_activities_by_askwer`;
CREATE TABLE IF NOT EXISTS `educational_institution_course_activities_by_askwer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `educational_institution_by_business_id` int(11) NOT NULL,
  `educational_institution_course_by_activities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_course_activities_by_askwer_educ_idx` (`educational_institution_by_business_id`),
  KEY `fk_educational_institution_course_activities_by_askwer_educ_idx1` (`educational_institution_course_by_activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_course_by_activities`
--

DROP TABLE IF EXISTS `educational_institution_course_by_activities`;
CREATE TABLE IF NOT EXISTS `educational_institution_course_by_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `educational_institution_course_by_supervisor_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `type` int(11) NOT NULL COMMENT '	0=there is no form 1= form exists',
  `allow_resources` int(11) NOT NULL COMMENT '	0=not allow 1=allow',
  `type_test` int(11) NOT NULL COMMENT '0=no test 1=test',
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_course_by_activities_educational_idx` (`educational_institution_course_by_supervisor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_course_by_students`
--

DROP TABLE IF EXISTS `educational_institution_course_by_students`;
CREATE TABLE IF NOT EXISTS `educational_institution_course_by_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `status_course` int(11) NOT NULL DEFAULT '0' COMMENT '	0=INICIADO 1=FINALIZADO Y LISTO 3=NO APROBADO	',
  `business_id` int(11) NOT NULL,
  `educational_institution_by_course_id` int(11) NOT NULL,
  `students_information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_course_by_students_educational_i_idx` (`educational_institution_by_course_id`),
  KEY `fk_educational_institution_course_by_students_students_info_idx` (`students_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_course_by_supervisor`
--

DROP TABLE IF EXISTS `educational_institution_course_by_supervisor`;
CREATE TABLE IF NOT EXISTS `educational_institution_course_by_supervisor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_by_employee_profile_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `educational_institution_by_course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_course_by_supervisor_business_by_idx` (`business_by_employee_profile_id`),
  KEY `fk_educational_institution_course_by_supervisor_educational_idx` (`educational_institution_by_course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_students_course_by_activities`
--

DROP TABLE IF EXISTS `educational_institution_students_course_by_activities`;
CREATE TABLE IF NOT EXISTS `educational_institution_students_course_by_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `educational_institution_course_by_activities_id` int(11) NOT NULL,
  `educational_institution_course_by_students_id` int(11) NOT NULL,
  `status_activity` int(11) NOT NULL DEFAULT '0' COMMENT '1=REVIEWED 0=TO CHECK	',
  `status_score` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT APPROVED 1=APPROVED 2=REPEAT',
  `score` float NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_student_course_by_activities_edu_idx` (`educational_institution_course_by_activities_id`),
  KEY `fk_educational_institution_student_course_by_activities_edu_idx1` (`educational_institution_course_by_students_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educational_institution_test_by_answers`
--

DROP TABLE IF EXISTS `educational_institution_test_by_answers`;
CREATE TABLE IF NOT EXISTS `educational_institution_test_by_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `askwer_entity_answer_id` int(11) NOT NULL,
  `educational_institution_students_course_by_activities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_educational_institution_test_by_answers_askwer_entity_an_idx` (`askwer_entity_answer_id`),
  KEY `fk_educational_institution_test_by_answers_educational_inst_idx` (`educational_institution_students_course_by_activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_by_kit`
--

DROP TABLE IF EXISTS `events_trails_by_kit`;
CREATE TABLE IF NOT EXISTS `events_trails_by_kit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` int(11) NOT NULL COMMENT '0=PRENDA,VESTIMENTA,events_trails_kit_pieces_id\n1=kit,utencillo extra',
  `entity_id` int(11) NOT NULL COMMENT '1=service\n0=product',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_by_clothing_kit_events_trails_project1_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_by_registration_points`
--

DROP TABLE IF EXISTS `events_trails_by_registration_points`;
CREATE TABLE IF NOT EXISTS `events_trails_by_registration_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `events_trails_registration_by_customer_id` int(11) NOT NULL,
  `events_trails_registration_points_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_by_registration_points_events_trails_regis_idx` (`events_trails_registration_by_customer_id`),
  KEY `fk_events_trails_by_registration_points_events_trails_regis_idx1` (`events_trails_registration_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_distances`
--

DROP TABLE IF EXISTS `events_trails_distances`;
CREATE TABLE IF NOT EXISTS `events_trails_distances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `value_distance` float NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `type` enum('SINGLE','COUPLE') NOT NULL DEFAULT 'SINGLE' COMMENT 'SING=INDIVIDUAL\n',
  `events_trails_type_teams_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_distances_events_trails_project1_idx` (`events_trails_project_id`),
  KEY `fk_events_trails_distances_events_trails_type_teams1_idx` (`events_trails_type_teams_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_kit_pieces`
--

DROP TABLE IF EXISTS `events_trails_kit_pieces`;
CREATE TABLE IF NOT EXISTS `events_trails_kit_pieces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_kit_pieces_events_trails_project1_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_project`
--

DROP TABLE IF EXISTS `events_trails_project`;
CREATE TABLE IF NOT EXISTS `events_trails_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `date_init_project` datetime NOT NULL,
  `date_end_project` datetime NOT NULL,
  `business_id` int(11) NOT NULL,
  `events_trails_types_id` int(11) NOT NULL,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_project_business1_idx` (`business_id`),
  KEY `fk_events_trails_project_events_trails_types1_idx` (`events_trails_types_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_project_by_routes_map`
--

DROP TABLE IF EXISTS `events_trails_project_by_routes_map`;
CREATE TABLE IF NOT EXISTS `events_trails_project_by_routes_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `type_shortcut` int(11) NOT NULL DEFAULT '0' COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico',
  `routes_map_id` int(11) NOT NULL,
  `events_trails_project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_by_routes_map_routes_map1_idx` (`routes_map_id`),
  KEY `fk_events_trails_project_by_routes_map_events_trails_projec_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_registration_by_customer`
--

DROP TABLE IF EXISTS `events_trails_registration_by_customer`;
CREATE TABLE IF NOT EXISTS `events_trails_registration_by_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `events_trails_project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `events_trails_type_of_categories_id` int(11) NOT NULL,
  `events_trails_distances_id` int(11) NOT NULL,
  `type_registration` int(11) NOT NULL DEFAULT '0' COMMENT '0=BY PAGE PROJECT\n1=POINT OF SALE',
  `manager_id` int(11) NOT NULL COMMENT 'order_shopping_cart_by_details',
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_registration_by_customer_events_trails_pro_idx` (`events_trails_project_id`),
  KEY `fk_events_trails_registration_by_customer_events_trails_typ_idx` (`events_trails_type_of_categories_id`),
  KEY `fk_events_trails_registration_by_customer_events_trails_dis_idx` (`events_trails_distances_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_registration_payments_by_business`
--

DROP TABLE IF EXISTS `events_trails_registration_payments_by_business`;
CREATE TABLE IF NOT EXISTS `events_trails_registration_payments_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `events_trails_registration_points_id` int(11) NOT NULL,
  `order_shopping_cart_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_registration_by_business_events_trails_reg_idx` (`events_trails_registration_points_id`),
  KEY `fk_events_trails_registration_by_business_order_shopping_ca_idx` (`order_shopping_cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_registration_points`
--

DROP TABLE IF EXISTS `events_trails_registration_points`;
CREATE TABLE IF NOT EXISTS `events_trails_registration_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_registration_points_events_trails_project1_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_types`
--

DROP TABLE IF EXISTS `events_trails_types`;
CREATE TABLE IF NOT EXISTS `events_trails_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_type_of_categories`
--

DROP TABLE IF EXISTS `events_trails_type_of_categories`;
CREATE TABLE IF NOT EXISTS `events_trails_type_of_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  `has_limit` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT\n1=HAS',
  `init_limit` int(11) NOT NULL DEFAULT '0',
  `end_limit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_type_of_categories_events_trails_project1_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_trails_type_teams`
--

DROP TABLE IF EXISTS `events_trails_type_teams`;
CREATE TABLE IF NOT EXISTS `events_trails_type_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `events_trails_project_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_trails_type_teams_events_trails_project1_idx` (`events_trails_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification`
--

DROP TABLE IF EXISTS `gamification`;
CREATE TABLE IF NOT EXISTS `gamification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `description` text,
  `value_unit` float NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `maximum_exchange` int(11) NOT NULL DEFAULT '0' COMMENT 'LIMIT FOR ALLOW EXCHANGE POINTS',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_allies`
--

DROP TABLE IF EXISTS `gamification_by_allies`;
CREATE TABLE IF NOT EXISTS `gamification_by_allies` (
  `id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `gamification_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_allies_business1_idx` (`business_id`),
  KEY `fk_gamification_by_allies_gamification1_idx` (`gamification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_badges`
--

DROP TABLE IF EXISTS `gamification_by_badges`;
CREATE TABLE IF NOT EXISTS `gamification_by_badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `title` text NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `gamification_id` int(11) NOT NULL,
  `has_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=Nothing\n1=have resource',
  `points` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_badges_gamification1_idx` (`gamification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_levels`
--

DROP TABLE IF EXISTS `gamification_by_levels`;
CREATE TABLE IF NOT EXISTS `gamification_by_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `title` text NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `has_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=Nothing\n1=have resource',
  `gamification_id` int(11) NOT NULL,
  `points` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_levels_gamification1_idx` (`gamification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_points`
--

DROP TABLE IF EXISTS `gamification_by_points`;
CREATE TABLE IF NOT EXISTS `gamification_by_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gamification_by_process_id` int(11) NOT NULL,
  `points` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_points_gamification_by_process1_idx` (`gamification_by_process_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_process`
--

DROP TABLE IF EXISTS `gamification_by_process`;
CREATE TABLE IF NOT EXISTS `gamification_by_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `title` text NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `has_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=Nothing\n1=have resource',
  `entity` varchar(200) NOT NULL COMMENT 'product',
  `entity_id` varchar(200) NOT NULL,
  `url_manager` text NOT NULL,
  `gamification_id` int(11) NOT NULL,
  `gamification_type_activity_id` int(11) NOT NULL,
  `is_url` int(11) NOT NULL DEFAULT '0',
  `type_manager` int(11) NOT NULL DEFAULT '0' COMMENT '0=output\n1=input\n',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_process_gamification1_idx` (`gamification_id`),
  KEY `fk_gamification_by_process_gamification_type_activity1_idx` (`gamification_type_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_by_rewards`
--

DROP TABLE IF EXISTS `gamification_by_rewards`;
CREATE TABLE IF NOT EXISTS `gamification_by_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `title` text NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `has_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=Nothing\n1=have resource',
  `gamification_id` int(11) NOT NULL,
  `points` float NOT NULL,
  `entity` int(11) NOT NULL COMMENT 'product\ncoupon\ndiscount',
  `entity_id` int(11) DEFAULT NULL,
  `percentage` float NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `specific` int(11) NOT NULL DEFAULT '0' COMMENT '0=ALL\n1=choose',
  PRIMARY KEY (`id`),
  KEY `fk_gamification_by_rewards_gamification1_idx` (`gamification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamification_type_activity`
--

DROP TABLE IF EXISTS `gamification_type_activity`;
CREATE TABLE IF NOT EXISTS `gamification_type_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `title` text NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `has_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=Nothing\n1=have resource',
  `url_manager` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gamification_type_activity`
--
INSERT INTO `gamification_type_activity` (`id`, `source`, `title`, `subtitle`, `description`, `interaction_type`,
                                          `state`, `has_source`, `url_manager`)
VALUES (1, '/uploads/gamification/gamificationTypeActivity/ecommerce.png', 'Gestión de E-commerce',
        'Interacción directa con productos y servicios',
        'Acciones enfocadas en la experiencia de compra, desde visualizar productos hasta calificar servicios. Ej: Comprar, referir, dar like a productos.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (2, '/uploads/gamification/gamificationTypeActivity/business_insight.png', 'Conocimiento de la Empresa',
        'Promoción del perfil empresarial',
        'Acciones que fortalecen la identidad y visibilidad de la empresa. Ej: Compartir el perfil de la empresa, seguir una empresa, recomendar sus servicios.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (3, '/uploads/gamification/gamificationTypeActivity/client_profile.png', 'Gestión de Datos del Cliente',
        'Actualización y personalización de perfil',
        'Tareas relacionadas con el mantenimiento del perfil del cliente para mejorar la segmentación. Ej: Actualizar datos, subir foto, preferencias.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (4, '/uploads/gamification/gamificationTypeActivity/marketing_engagement.png', 'Participación en Marketing',
        'Acciones útiles para estrategias de promoción',
        'Actividades que sirven para obtener insights para campañas de marketing. Ej: Responder encuestas, participar en campañas o sorteos, referir usuarios.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (5, '/uploads/gamification/gamificationTypeActivity/customer_feedback.png', 'Retroalimentación del Cliente',
        'Canales de mejora y respuesta',
        'Recopilación de información útil para mejorar procesos. Ej: Enviar quejas, votar por sugerencias, calificar compras y servicios.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (6, '/uploads/gamification/gamificationTypeActivity/physical_engagement.png', 'Interacción Presencial',
        'Acciones en lugares físicos de la empresa',
        'Visitas, escaneos QR, check-ins o participación en eventos físicos. Ej: Visitar local, asistir a eventos con QR.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (7, '/uploads/gamification/gamificationTypeActivity/referrals.png', 'Sistema de Referidos',
        'Expansión de red mediante invitaciones',
        'Acciones para invitar y hacer crecer la comunidad. Ej: Referir a un amigo para que compre, comparta una promoción.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (8, '/uploads/gamification/gamificationTypeActivity/news_updates.png', 'Interacción con Contenido Empresarial',
        'Lectura y difusión de información clave',
        'Actividades ligadas a la visibilidad del contenido de la empresa. Ej: Leer noticias, compartir comunicados, comentar artículos.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (9, '/uploads/gamification/gamificationTypeActivity/campaign_engagement.png',
        'Participación en Campañas de Fidelización', 'Suma puntos por tu actividad',
        'Actividades que ayudan a medir la fidelidad y constancia del cliente. Ej: Logros, tareas diarias, puntos acumulados, canje de premios.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (10, '/uploads/gamification/gamificationTypeActivity/cross_departments.png', 'Interacción Multidepartamental',
        'Datos para decisiones empresariales',
        'Permite generar datos útiles para áreas como atención al cliente, marketing, operaciones. Ej: Responder encuesta de satisfacción, evaluar tiempo de respuesta.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (11, '/uploads/gamification/gamificationTypeActivity/brand_promotion.png', 'Promoción de Marca y Reputación',
        'Acciones que impulsan la marca',
        'Visibilidad de marca a través de acciones sociales. Ej: Compartir cupones, recomendar productos, publicar reseñas positivas.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (12, '/uploads/gamification/gamificationTypeActivity/client_to_client.png', 'Cliente a Cliente',
        'Interacción entre usuarios', 'Ej: compartir puntos, premiar apoyo, colaborar en tareas.', 'CLIENTE-CLIENTE',
        'ACTIVE', 1, 'null'),
       (13, '/uploads/gamification/gamificationTypeActivity/client_to_business.png', 'Cliente a Empresa',
        'Apoyo o reconocimiento a empresas', 'Ej: donar puntos a campañas, agradecer con puntos, contribuir en retos.',
        'CLIENTE-EMPRESA', 'ACTIVE', 1, 'null'),
       (14, '/uploads/gamification/gamificationTypeActivity/business_to_client.png', 'Empresa a Cliente',
        'Reconocimiento o incentivo a usuarios', 'Ej: premiar fidelidad, puntos por tareas o feedback.',
        'EMPRESA-CLIENTE', 'ACTIVE', 1, 'null'),
       (15, '/uploads/gamification/gamificationTypeActivity/business_to_business.png', 'Empresa a Empresa',
        'Colaboración entre empresas', 'Ej: alianzas, apoyo entre marcas, compartir puntos.', 'EMPRESA-EMPRESA',
        'ACTIVE', 1, 'null');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gaminification_by_log_customers`
--

DROP TABLE IF EXISTS `gaminification_by_log_customers`;
CREATE TABLE IF NOT EXISTS `gaminification_by_log_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `entity_type` int(11) NOT NULL,
  `account_gamification_by_movement_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_gaminification_by_log_customers_account_gamification_by__idx` (`account_gamification_by_movement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habits`
--

DROP TABLE IF EXISTS `habits`;
CREATE TABLE IF NOT EXISTS `habits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habits`
--

INSERT INTO `habits` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Fumar', NULL, NULL, NULL, NULL, 'ACTIVE'),
(2, 'Toma Alcohol', NULL, NULL, NULL, NULL, 'ACTIVE'),
(3, 'Drogas', NULL, NULL, NULL, NULL, 'ACTIVE'),
(4, 'Micción', NULL, NULL, NULL, NULL, 'ACTIVE'),
(5, 'Deposición', NULL, NULL, NULL, NULL, 'ACTIVE'),
(6, 'Alimentación', NULL, NULL, NULL, NULL, 'ACTIVE'),
(7, 'Sedentarismo', NULL, NULL, NULL, NULL, 'ACTIVE'),
(8, 'Actividad Física', NULL, NULL, NULL, NULL, 'ACTIVE'),
(9, 'Sueño', NULL, NULL, NULL, NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habits_by_history_clinic`
--

DROP TABLE IF EXISTS `habits_by_history_clinic`;
CREATE TABLE IF NOT EXISTS `habits_by_history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_clinic_id` int(11) NOT NULL,
  `habits_id` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_habits_by_history_clinic_history_clinic1_idx` (`history_clinic_id`),
  KEY `fk_habits_by_history_clinic_habits1_idx` (`habits_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `history_clinic`
--

DROP TABLE IF EXISTS `history_clinic`;
CREATE TABLE IF NOT EXISTS `history_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `human_resources_department`
--

DROP TABLE IF EXISTS `human_resources_department`;
CREATE TABLE IF NOT EXISTS `human_resources_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_human_resources_department_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `human_resources_department`
--

INSERT INTO `human_resources_department` (`id`, `name`, `description`, `status`, `business_id`) VALUES
(1, 'Gerencia', 'Gerente administración Arrayanes', 'ACTIVE', 2),
(2, 'Coordinador Académico Secundaria', '', 'ACTIVE', 2),
(3, 'Coordinador Académico Primaria', '', 'ACTIVE', 2),
(4, 'Directora del DECE', '', 'ACTIVE', 2),
(5, 'Departamento de Marketing', '', 'ACTIVE', 2),
(6, 'Administrador Financiero', '', 'ACTIVE', 2),
(7, 'Gerencia', '', 'ACTIVE', 3),
(8, 'Coordinador Académico Secundaria', '', 'ACTIVE', 3),
(9, 'Coordinador Académico Primaria', '', 'ACTIVE', 3),
(10, 'Director del DECE', '', 'ACTIVE', 3),
(11, 'Administrador Financiero', '', 'ACTIVE', 3),
(12, 'Marketing', '', 'ACTIVE', 3),
(13, 'Directora General', 'Directora General', 'ACTIVE', 4),
(14, 'Administrador Financiero', '', 'ACTIVE', 4),
(15, 'Marketing y Comunicación', '', 'ACTIVE', 4),
(16, 'Coordinadora Académico', '', 'ACTIVE', 4),
(17, 'Directora DECE', '', 'ACTIVE', 4),
(18, 'Asistente Administrativo', 'Asistente Administrativo', 'ACTIVE', 3),
(19, 'Directora de Preescolar', 'Directora de Preescolar', 'ACTIVE', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `human_resources_employee_profile`
--

DROP TABLE IF EXISTS `human_resources_employee_profile`;
CREATE TABLE IF NOT EXISTS `human_resources_employee_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `summary_web` text,
  `people_id` int(11) NOT NULL,
  `people_type_identification_id` int(11) NOT NULL,
  `identification_document` varchar(45) NOT NULL,
  `src` varchar(250) DEFAULT NULL,
  `date_of_birth` datetime NOT NULL,
  `people_nationality_id` int(11) NOT NULL,
  `people_profession_id` int(11) NOT NULL,
  `contract_date` datetime NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  `human_resources_department_id` int(11) NOT NULL,
  `allow_view_page_web` int(1) NOT NULL DEFAULT '0' COMMENT '0=NOT\n1=YES',
  PRIMARY KEY (`id`),
  KEY `fk_human_resources_employee_profile_people1_idx` (`people_id`),
  KEY `fk_human_resources_employee_profile_people_type_identificat_idx` (`people_type_identification_id`),
  KEY `fk_human_resources_employee_profile_people_nationality1_idx` (`people_nationality_id`),
  KEY `fk_human_resources_employee_profile_people_profession1_idx` (`people_profession_id`),
  KEY `fk_human_resources_employee_profile_business1_idx` (`business_id`),
  KEY `fk_human_resources_employee_profile_human_resources_departm_idx` (`human_resources_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `human_resources_employee_profile`
--

INSERT INTO `human_resources_employee_profile` (`id`, `description`, `summary_web`, `people_id`, `people_type_identification_id`, `identification_document`, `src`, `date_of_birth`, `people_nationality_id`, `people_profession_id`, `contract_date`, `status`, `business_id`, `human_resources_department_id`, `allow_view_page_web`) VALUES
(1, '<span id=\"docs-internal-guid-33adb9e2-7fff-3765-94d4-93dfd8aad437\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Parte de las familias fundadoras de la Corporación Arrayanes Álamos. Tiene una trayectoria de 21 años como rectora de nuestra institución Educativa. Se ha capacitado por varios años en orientación familiar con el IMF (Instituto de Matrimonio y Familia).&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ha realizado visitas de aprendizaje en 5 colegios de Barcelona y 4 colegios en Santiago de Chile con alto nivel académico, para así implementar lo aprendido en nuestras instituciones.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ha realizado varias capacitaciones en el tema de calidad y posee un certificado de evaluación en el Modelo Europeo de Calidad.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Título:</span></p><ul style=\"margin-bottom: 0px;\"><li dir=\"ltr\" style=\"list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Magíster en Gerencia Educativa en la Universidad Técnica Particular de Loja</span></p></li><li dir=\"ltr\" style=\"list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\" role=\"presentation\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Licenciada en Ciencias Jurídicas en la Pontificia Universidad Católica del Ecuador</span></p></li></ul></span>', '<font color=\"#F5F7FA\">1</font>Directora General', 1, 2, '1001974426', '/uploads/humanResourcesEmployeeProfile/profile/1610386855_mm1.jpg', '2020-08-01 00:00:00', 18, 47, '2020-08-01 00:00:00', 'ACTIVE', 2, 1, 1),
(2, '<span id=\"docs-internal-guid-4ba10887-7fff-bc14-bd26-30c956631692\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Tiene una trayectoria de 20 años practicando la docencia, 14 años en nuestra Institución educativa, desempeñando el cargo de directora académica en secundaria y docente de química y física. Ha tenido experiencia en el manejo de gestión educativa y aplica estrategias para mejorar el desarrollo óptimo de nuestras estudiantes.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Títulos:</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">-Ingeniera Química en la Escuela Politécnica Nacional </span></p><div><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\"><br></span></div></span>', '<font color=\"#F5F7FA\">1</font>Directora Académica de Secundaria', 2, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607527045_7.jpg', '2020-07-08 00:00:00', 18, 46, '2020-07-07 00:00:00', 'ACTIVE', 2, 2, 1),
(3, '<div>Parte de las familias fundadoras de la Corporación Arrayanes Álamos. Tiene una</div><div>trayectoria de 21 años como rectora de nuestra institución Educativa. Se ha capacitado</div><div>por varios años en orientación familiar con el IMF (Instituto de Matrimonio y Familia).</div><div>Ha realizado visitas de aprendizaje en 5 colegios de Barcelona y 4 colegios en Santiago de</div><div>Chile con alto nivel académico, para así implementar lo aprendido en nuestras</div><div>instituciones.</div><div>Ha realizado varias capacitaciones en el tema de calidad y posee un certificado de</div><div>evaluación en el Modelo Europeo de Calidad.</div>', '<font color=\"#F5F7FA\">1</font>Directora Académica de Secundaria', 3, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1613875711_Foto-lore-1.jpg', '2020-07-07 00:00:00', 18, 47, '2020-07-07 00:00:00', 'ACTIVE', 2, 3, 1),
(4, '<p><span id=\"docs-internal-guid-d3e7b4a5-7fff-6c82-24d6-2524f46be9d1\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Parte de las familias fundadoras de la Corporación Arrayanes Álamos. Tiene una trayectoria de 25 años ejerciendo la docencia, 23 en nuestra institución educativa. Actualmente se desempeña como psicóloga en el Departamento psicopedagógico ayudando a nuestras estudiantes con dificultades en el aprendizaje y familiares. </span></span></p><p><span id=\"docs-internal-guid-d3e7b4a5-7fff-6c82-24d6-2524f46be9d1\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Títulos:</span></span></p><p><span id=\"docs-internal-guid-d3e7b4a5-7fff-6c82-24d6-2524f46be9d1\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">-</span></span><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">Magíster en “Arts in Teaching”en Brattleboro, Estados Unidos</span></p><p><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Graduada en la Pontificia Universidad Católica del Ecuador como Psicóloga Clínica</span></p>', '<font color=\"#F5F7FA\">1</font>Directora del DECE', 4, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607526844_3.jpg', '2016-01-01 00:00:00', 18, 52, '2020-07-09 00:00:00', 'ACTIVE', 2, 4, 1),
(5, '<span id=\"docs-internal-guid-5177b538-7fff-c85f-8cd1-c7f49ce09ee1\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ex alumno del colegio Álamos de la primera promoción. Posee 10 años de experiencia en el desarrollo de marcas, colaborando con importantes empresas a nivel nacional. Desde el año 2014 se desempeña como jefe del Departamento de Marketing. Ha participado en el posicionamiento activo de redes sociales y en la mejora de la salud de la marca en vistas a nivel nacional y local, desarrollando un rejuvenecimiento de la marca CORPAR Y sus instituciones. Actualmente está construyendo, junto al departamento, un sistema de comunicación empresarial más eficiente.&nbsp;&nbsp;&nbsp;&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Títulos:</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Tecnólogo en Diseño Gráfico del Instituto Tecnológico Superior Ibarra.</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-</span><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">Diplomado en Marketing Manager de la Universidad de Berklee, Estados Unidos</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Cursando máster en dirección de cuentas publicitarias por la universidad autónoma de Barcelona</span></p></span>', '<font color=\"#F5F7FA\">1</font>Directora Académica de Primaria', 5, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1613875616_grace.jpg', '1988-08-20 00:00:00', 18, 33, '2020-11-02 00:00:00', 'ACTIVE', 2, 3, 1),
(6, '<div>Tiene una trayectoria de 21 años ejerciendo la docencia, 14 en nuestra institución</div><div>educativa. Actualmente se desempeña como docente de educación básica y coordinadora</div><div>de la sección de primaria. Recibió una capacitación en el proyecto PEIS en Santiago de</div><div>Chile para aplicarlo en nuestras aulas y así lograr un mejor nivel educativo en nuestras</div><div>estudiantes.</div><div><br></div><div>Titulación:</div><div><br></div><div><div>-Magister en Neuropsicología Educativa en la Universidad de Rioja&nbsp;</div><div>-Licenciada en Ciencias de la Educación en la Pontificia Universidad Católica del Ecuador.</div></div>', '<font color=\"#F5F7FA\">1</font>Directora Académica de Primaria', 6, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607526439_4.jpg', '2020-11-03 00:00:00', 18, 33, '2020-11-10 00:00:00', 'ACTIVE', 2, 3, 1),
(7, '<p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Parte de las familias fundadoras de la Corporación Arrayanes Álamos. Tiene una trayectoria de 21 años como rectora de nuestra institución Educativa. Se ha capacitado por varios años en orientación familiar con el IMF (Instituto de Matrimonio y Familia).&nbsp;</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ha realizado visitas de aprendizaje en 5 colegios de Barcelona y 4 colegios en Santiago de Chile con alto nivel académico, para así implementar lo aprendido en nuestras instituciones.&nbsp;</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ha realizado varias capacitaciones en el tema de calidad y posee un certificado de evaluación en el Modelo Europeo de Calidad.&nbsp;</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Título:</span></p><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; list-style: none; padding: 0px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\"><li dir=\"ltr\" style=\"display: block; list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" role=\"presentation\" style=\"margin: 0pt 0px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">-Magíster en Gerencia Educativa en la Universidad Técnica Particular de Loja</span></p></li><li dir=\"ltr\" style=\"display: block; list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" role=\"presentation\" style=\"margin: 0pt 0px 8pt; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">-Licenciada en Ciencias Jurídicas en la Pontificia Universidad Católica del Ecuador</span></p></li></ul>', 'Directora General', 7, 2, '1001974426', '/uploads/humanResourcesEmployeeProfile/profile/1610386411_mm1.jpg', '2020-02-05 00:00:00', 18, 47, '2020-05-06 00:00:00', 'ACTIVE', 3, 7, 1),
(8, '<span id=\"docs-internal-guid-6fdd8163-7fff-786a-0d36-d0edf3cb551e\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Tiene una trayectoria de 6 años en la docencia, 3 en nuestra institución. Actualmente se desempeña como coordinador de secundaria en la Unidad Educativa Álamos.&nbsp; Realizó un masterado en Tecnología e Innovación Educativa, además de poseer una constante capacitación en el área educativa. Aplica estrategias de aprendizaje para la comprensión y aprendizaje basado en proyectos para lograr un desempeño óptimo en nuestros estudiantes.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Títulos:&nbsp;</span></p><ul style=\"margin-bottom: 0px;\"><li dir=\"ltr\" style=\"list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Máster en Tecnología e Innovación Educativa de la Universidad Técnica del Norte.</span></p></li><li dir=\"ltr\" style=\"list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Licenciado en Física y Matemática en la Universidad Técnica del Norte&nbsp;</span></p></li><li dir=\"ltr\" style=\"list-style-type: disc; font-size: 12pt; font-family: &quot;Noto Sans Symbols&quot;, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre;\"><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Licenciado en Mecatrónica en la Universidad Técnica del Norte</span></p></li></ul></span>', 'Director Académico de Secundaria', 8, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607967845_5.jpg', '2020-05-01 00:00:00', 18, 46, '2020-07-02 00:00:00', 'ACTIVE', 3, 8, 1),
(9, '<span id=\"docs-internal-guid-ce02b1a4-7fff-1514-02c3-9e85a37261ca\"><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Tiene una trayectoria de 23 años en la docencia, 20 en nuestra institución. Se desempeña como Director de la Primaria en la Unidad Educativa Álamos y docente de 2do de básica. Actualmente está cursando una maestría en Organización de centros educativos de la Universidad Iberoamericana de México.</span><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; color: rgb(128, 128, 128); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\"> </span><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Realizó un curso de actualización pedagógica PEIS y Lectura Comprensiva, en Santiago de Chile para aplicarlo en nuestras aulas y así lograr un mejor nivel educativo en nuestros estudiantes.&nbsp;&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Título:&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;text-align: justify;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">-Licenciado en Ciencias de la educación con mención Educación Básica por la Universidad Tecnológica Indoamérica</span></p><div><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\"><br></span></div></span>', 'Director Académico de Primara', 9, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607968112_1.jpg', '2020-03-06 00:00:00', 18, 33, '2020-08-05 00:00:00', 'ACTIVE', 3, 9, 1),
(10, '<span id=\"docs-internal-guid-e556904c-7fff-9e6a-3c13-9899e13048cf\"><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Parte de las familias fundadoras de la Corporación Arrayanes Álamos. Tiene una trayectoria de 25 años ejerciendo la docencia, 23 en nuestra institución educativa. Actualmente se desempeña como psicóloga en el Departamento psicopedagógico ayudando a nuestras estudiantes con dificultades en el aprendizaje y familiares.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\"><br></span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Título:&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Magíster en “Arts in Teaching”en Brattleboro, Estados Unidos.</span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Graduada en la Pontificia Universidad Católica del Ecuador como Psicóloga Clínica</span></p></span>', 'Director Administrativo Álamos', 10, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1613877163_renato-ok.jpg', '2020-08-05 00:00:00', 18, 33, '2020-09-03 00:00:00', 'ACTIVE', 3, 18, 1),
(11, '<p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Ex alumno del colegio Álamos de la primera promoción. Posee 10 años de experiencia en el desarrollo de marcas, colaborando con importantes empresas a nivel nacional. Desde el año 2014 se desempeña como jefe del Departamento de Marketing. Ha participado en el posicionamiento activo de redes sociales y en la mejora de la salud de la marca en vistas a nivel nacional y local, desarrollando un rejuvenecimiento de la marca CORPAR Y sus instituciones. Actualmente está construyendo, junto al departamento, un sistema de comunicación empresarial más eficiente.&nbsp;&nbsp;&nbsp;&nbsp;</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"font-size: 12pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Títulos:</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Tecnólogo en Diseño Gráfico del Instituto Tecnológico Superior Ibarra.</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-</span><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">Diplomado en Marketing Manager de la Universidad de Berklee, Estados Unidos</span></p><p dir=\"ltr\" style=\"margin: 0pt 0px 8pt; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.295;\"><span style=\"background-color: transparent; font-family: Calibri, sans-serif; font-size: 12pt; white-space: pre-wrap;\">-Cursando máster en dirección de cuentas publicitarias por la universidad autónoma de Barcelona</span></p>', 'Jefe del Departamento de Marketing', 11, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1607968517_8.jpg', '2020-09-02 00:00:00', 18, 47, '2020-09-01 00:00:00', 'ACTIVE', 3, 12, 1),
(12, 'Null', 'Administrador Financiero', 12, 2, '1001055563', '/uploads/humanResourcesEmployeeProfile/profile/1610386395_ft1.jpg', '2020-07-02 00:00:00', 18, 47, '2020-09-02 00:00:00', 'ACTIVE', 3, 11, 1),
(19, '<p>Directora de Preescolar</p>', 'Directora de Preescolar', 19, 2, '1001115524', '/uploads/humanResourcesEmployeeProfile/profile/1613871641_1607970108_6.jpg', '2021-02-18 00:00:00', 18, 33, '2021-02-18 00:00:00', 'ACTIVE', 4, 19, 1),
(20, '<p>&nbsp; &nbsp;&nbsp;<span style=\"font-size: 14.4px;\">Directora General</span></p>', 'Directora General', 20, 2, '1001115524', '/uploads/humanResourcesEmployeeProfile/profile/1613871649_1610386411_mm1.jpg', '2021-02-18 00:00:00', 18, 33, '2021-02-16 00:00:00', 'ACTIVE', 4, 13, 1),
(21, '<p><span style=\"font-size: 14.4px;\">Directora de Preescolar</span></p>', 'Directora de Preescolar', 21, 2, '1001115524', '/uploads/humanResourcesEmployeeProfile/profile/1613871658_1607969543_2.jpg', '2021-02-09 00:00:00', 18, 33, '2021-02-17 00:00:00', 'ACTIVE', 4, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_address`
--

DROP TABLE IF EXISTS `information_address`;
CREATE TABLE IF NOT EXISTS `information_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_one` varchar(150) NOT NULL,
  `street_two` varchar(150) NOT NULL,
  `reference` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `entity_id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MAIN\n1=MAIN',
  `entity_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=customer\n',
  `information_address_type_id` int(11) NOT NULL,
  `has_location` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT \n1=YES',
  `options_map` text NOT NULL COMMENT 'location,zoom',
  `country_code_id` varchar(250) NOT NULL COMMENT 'google code types',
  `administrative_area_level_2` varchar(250) NOT NULL COMMENT 'google code types Ciudad',
  `administrative_area_level_1` varchar(250) DEFAULT NULL COMMENT 'google code types Provincia',
  `administrative_area_level_3` varchar(250) DEFAULT NULL COMMENT 'google code types parroquia ,comunidad',
  PRIMARY KEY (`id`),
  KEY `fk_information_address_information_address_type1_idx` (`information_address_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_address_by_multimedia`
--

DROP TABLE IF EXISTS `information_address_by_multimedia`;
CREATE TABLE IF NOT EXISTS `information_address_by_multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nothing',
  `information_address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounting_account_accounting_level1_idx` (`information_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_address_type`
--

DROP TABLE IF EXISTS `information_address_type`;
CREATE TABLE IF NOT EXISTS `information_address_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_address_type`
--

INSERT INTO `information_address_type` (`id`, `value`, `description`, `state`) VALUES
(1, 'Domicilio', 'Domicilio', 'ACTIVE'),
(2, 'Trabajo', 'Trabajo', 'ACTIVE'),
(3, 'Sin Especificación', 'Sin Especificación', 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_mail`
--

DROP TABLE IF EXISTS `information_mail`;
CREATE TABLE IF NOT EXISTS `information_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `entity_id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MAIN\n1=MAIN',
  `entity_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=customer\n',
  `information_mail_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_information_mail_information_mail_type1_idx` (`information_mail_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_mail`
--

INSERT INTO `information_mail` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_mail_type_id`) VALUES
(2, 'analuna@arrayanesalamos.edu.ec', 'ACTIVE', 6, 1, 1, 1),
(6, 'carocorrales@arrayanesalamos.edu.ec', 'ACTIVE', 13, 1, 1, 1),
(7, 'mariamercedes@arrayanesalamos.edu.ec', 'ACTIVE', 1, 1, 1, 1),
(8, 'gracegarcia@arrayanesalamos.edu.ec', 'ACTIVE', 5, 1, 1, 1),
(9, 'jessillerena@arrayanesalamos.edu.ec', 'ACTIVE', 2, 1, 1, 1),
(10, 'ximenamadera@arrayanesalamos.edu.ec', 'ACTIVE', 4, 1, 1, 1),
(11, 'lorenaalbuja@arrayanesalamos.edu.ec', 'ACTIVE', 3, 1, 1, 1),
(12, 'washingtondiaz@arrayanesalamos.edu.ec', 'ACTIVE', 9, 1, 1, 1),
(13, 'mariamercedes@arrayanesalamos.edu.ec', 'ACTIVE', 7, 1, 1, 1),
(14, 'jcarapaz@arrayanesalamos.edu.ec', 'ACTIVE', 8, 1, 1, 1),
(15, 'joseteran@arrayanesalamos.edu.ec', 'ACTIVE', 11, 1, 1, 1),
(16, 'renatocazar@arrayanesalamos.edu.ec', 'ACTIVE', 10, 1, 1, 1),
(17, 'fernandoteran@arrayanesalamos.edu.ec', 'ACTIVE', 12, 1, 1, 1),
(18, 'maruvillareal@arrayanesalamos.edu.ec', 'ACTIVE', 19, 1, 1, 1),
(19, 'mariamercedes@arrayanesalamos.edu.ec', 'ACTIVE', 20, 1, 1, 1),
(20, 'carolinacorrales@arrayanesalamos.edu.ec', 'ACTIVE', 21, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_mail_type`
--

DROP TABLE IF EXISTS `information_mail_type`;
CREATE TABLE IF NOT EXISTS `information_mail_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_mail_type`
--

INSERT INTO `information_mail_type` (`id`, `value`, `description`, `state`) VALUES
(1, 'Coorporativo', 'Coorporativo', 'ACTIVE'),
(2, 'Personal', 'Personal', 'ACTIVE'),
(3, 'Sin Especificación', 'Sin Especificación', 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_phone`
--

DROP TABLE IF EXISTS `information_phone`;
CREATE TABLE IF NOT EXISTS `information_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `entity_id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MAIN\n1=MAIN',
  `entity_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=customer\n',
  `information_phone_operator_id` int(11) NOT NULL,
  `information_phone_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_information_phone_information_phone_operator1_idx` (`information_phone_operator_id`),
  KEY `fk_information_phone_information_phone_type1_idx` (`information_phone_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_phone_operator`
--

DROP TABLE IF EXISTS `information_phone_operator`;
CREATE TABLE IF NOT EXISTS `information_phone_operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_phone_operator`
--

INSERT INTO `information_phone_operator` (`id`, `value`, `description`, `state`) VALUES
(1, 'SIN DEFINIR', NULL, 'ACTIVE'),
(2, 'MOVISTAR', 'adad', 'ACTIVE'),
(3, 'ALEGRO', 'adad', 'ACTIVE'),
(4, 'CLARO', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_phone_type`
--

DROP TABLE IF EXISTS `information_phone_type`;
CREATE TABLE IF NOT EXISTS `information_phone_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_phone_type`
--

INSERT INTO `information_phone_type` (`id`, `value`, `description`, `state`) VALUES
(1, 'SIN DEFINIR', 'sfdd ADAD', 'ACTIVE'),
(2, 'TRABAJO', NULL, 'ACTIVE'),
(3, 'CASA', 'adad', 'ACTIVE'),
(4, 'Personal', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_social_network`
--

DROP TABLE IF EXISTS `information_social_network`;
CREATE TABLE IF NOT EXISTS `information_social_network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `entity_id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MAIN\n1=MAIN',
  `entity_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=customer\n',
  `information_social_network_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_information_social_network_information_social_network_ty_idx` (`information_social_network_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_social_network_type`
--

DROP TABLE IF EXISTS `information_social_network_type`;
CREATE TABLE IF NOT EXISTS `information_social_network_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `icon` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `information_social_network_type`
--

INSERT INTO `information_social_network_type` (`id`, `value`, `description`, `state`, `icon`) VALUES
(1, 'Facebook', 'adadad', 'ACTIVE', 'fa fa-facebook'),
(2, 'Instagram', 'adadad', 'ACTIVE', 'fa fa-instagram'),
(3, 'Twitter', 'adadad', 'ACTIVE', 'fa fa-twitter'),
(4, 'LinkedIn', 'adadad', 'ACTIVE', 'fa fa-linkedin'),
(5, 'Youtube', 'adadad', 'ACTIVE', 'fa fa-youtube-play'),
(6, 'Whatsapp', 'adadad', 'ACTIVE', 'fa fa-youtube-play');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `initial_status_product`
--

DROP TABLE IF EXISTS `initial_status_product`;
CREATE TABLE IF NOT EXISTS `initial_status_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` float NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_initial_status_product_product1_idx` (`product_id`),
  KEY `fk_initial_status_product_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy`
--

DROP TABLE IF EXISTS `invoice_buy`;
CREATE TABLE IF NOT EXISTS `invoice_buy` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_code` varchar(45) NOT NULL,
  `invoice_value` decimal(10,4) NOT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `status` enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED',
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `observations` text,
  `value_taxes` decimal(10,4) NOT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `authorization_number` varchar(150) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `establishment` varchar(3) NOT NULL,
  `emission_point` varchar(3) NOT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `mixed_payment` int(11) NOT NULL DEFAULT '1' COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS',
  `has_retention` int(11) NOT NULL DEFAULT '1' COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion',
  `debt` int(11) NOT NULL DEFAULT '0' COMMENT '0=sin DEUDA\n 1=DEUDA',
  `freight` int(11) NOT NULL DEFAULT '0',
  `type_of_discount` int(11) NOT NULL DEFAULT '0' COMMENT '0=% \n1=$',
  `discount_type_invoice` int(11) NOT NULL DEFAULT '0' COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	',
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_voucher_type1_idx` (`voucher_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_book_seat`
--

DROP TABLE IF EXISTS `invoice_buy_by_book_seat`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_book_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=REGISTRO FACTURA 1=REGISTRO DEVOLUCION 2=REGISTRO DE PAGOS CUALQIER ES UN EJEMPLO TOCARIA DEFINIR',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `invoice_buy_id` int(11) NOT NULL,
  `diary_book_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_book_seat_invoice_buy1_idx` (`invoice_buy_id`),
  KEY `fk_invoice_buy_by_book_seat_diary_book1_idx` (`diary_book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_breakdown_payment`
--

DROP TABLE IF EXISTS `invoice_buy_by_breakdown_payment`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_breakdown_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_by_indebtedness_paying_init_id` int(11) NOT NULL,
  `date_agreement` datetime NOT NULL,
  `payment_value` decimal(10,4) NOT NULL,
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '0=pagado 1=deuda',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_breakdown_payment_invoice_buy_by_indebted_idx` (`invoice_buy_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_details`
--

DROP TABLE IF EXISTS `invoice_buy_by_details`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,4) DEFAULT NULL,
  `quantity_unit` decimal(10,4) DEFAULT NULL,
  `discount_percentage` decimal(10,4) DEFAULT NULL,
  `discount_percentage_unit` decimal(10,4) DEFAULT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `discount_value_unit` decimal(10,4) DEFAULT NULL,
  `unit_price` decimal(10,4) DEFAULT NULL,
  `unit_price_unit` decimal(10,4) DEFAULT NULL,
  `management_type` char(3) DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
  `tax_percentage` int(11) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `description` text,
  `product_type` varchar(45) DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND',
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_details_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_details_devolution`
--

DROP TABLE IF EXISTS `invoice_buy_by_details_devolution`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_details_devolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,4) DEFAULT NULL,
  `quantity_unit` decimal(10,4) DEFAULT NULL,
  `discount_percentage` decimal(10,4) DEFAULT NULL,
  `discount_percentage_unit` decimal(10,4) DEFAULT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `discount_value_unit` decimal(10,4) DEFAULT NULL,
  `unit_price` decimal(10,4) DEFAULT NULL,
  `unit_price_unit` decimal(10,4) DEFAULT NULL,
  `management_type` char(3) DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
  `tax_percentage` int(11) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_details_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_devolution_product`
--

DROP TABLE IF EXISTS `invoice_buy_by_devolution_product`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_devolution_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_defect_id` int(11) NOT NULL,
  `details` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `invoice_buy_by_details_devolution_id` int(11) NOT NULL,
  `types_payments_id` int(11) NOT NULL,
  `accounting_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_devolution_product_product_defect1_idx` (`product_defect_id`),
  KEY `fk_invoice_buy_by_devolution_product_invoice_buy_by_details_idx` (`invoice_buy_by_details_devolution_id`),
  KEY `fk_invoice_buy_by_devolution_product_types_payments1_idx` (`types_payments_id`),
  KEY `fk_invoice_buy_by_devolution_product_accounting_account1_idx` (`accounting_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_indebtedness_paying_init`
--

DROP TABLE IF EXISTS `invoice_buy_by_indebtedness_paying_init`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_indebtedness_paying_init` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_payments` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_buy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_indebtedness_paying_init_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_overridden`
--

DROP TABLE IF EXISTS `invoice_buy_by_overridden`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_overridden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `register_manager_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_buy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_overridden_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_payment`
--

DROP TABLE IF EXISTS `invoice_buy_by_payment`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_date` datetime NOT NULL,
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '	1=puntual 0=atrasado',
  `details` text,
  `types_payments_by_account_id` int(11) NOT NULL,
  `accounting_account_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_buy_by_breakdown_payment_id` int(11) NOT NULL,
  `invoice_buy_by_indebtedness_paying_init_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  KEY `fk_invoice_buy_by_payment_invoice_buy_by_breakdown_payment1_idx` (`invoice_buy_by_breakdown_payment_id`),
  KEY `fk_invoice_buy_by_payment_invoice_buy_by_indebtedness_payin_idx` (`invoice_buy_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_pendient`
--

DROP TABLE IF EXISTS `invoice_buy_by_pendient`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_pendient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indebtedness_paying` decimal(10,4) NOT NULL,
  `invoice_buy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_pendient_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_retention`
--

DROP TABLE IF EXISTS `invoice_buy_by_retention`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_retention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_id` int(11) NOT NULL,
  `retention_tax_sub_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `retained_value` decimal(10,4) DEFAULT NULL,
  `establishment` varchar(3) DEFAULT NULL,
  `emission_point` varchar(3) NOT NULL,
  `number_authorization` varchar(3) NOT NULL,
  `number_retention` varchar(250) NOT NULL,
  `invoice_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_retention_invoice_buy1_idx` (`invoice_buy_id`),
  KEY `fk_invoice_buy_by_retention_retention_tax_sub_type1_idx` (`retention_tax_sub_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_transactional_annex`
--

DROP TABLE IF EXISTS `invoice_buy_by_transactional_annex`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_transactional_annex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_buy_id` int(11) NOT NULL,
  `management_livelihood_by_voucher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_transactional_annex_invoice_buy1_idx` (`invoice_buy_id`),
  KEY `fk_invoice_buy_by_transactional_annex_management_livelihood_idx` (`management_livelihood_by_voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_buy_by_transactions`
--

DROP TABLE IF EXISTS `invoice_buy_by_transactions`;
CREATE TABLE IF NOT EXISTS `invoice_buy_by_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percentage_discount` decimal(10,4) DEFAULT NULL,
  `value_discount` decimal(10,4) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `account` varchar(45) DEFAULT NULL,
  `accounting_account_id` int(11) NOT NULL,
  `way_to_pay` varchar(250) NOT NULL,
  `type_payment_id` int(11) NOT NULL,
  `invoice_buy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_factura_buy_by_transactions_accounting_account1_idx` (`accounting_account_id`),
  KEY `fk_invoice_buy_by_transactions_invoice_buy1_idx` (`invoice_buy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale`
--

DROP TABLE IF EXISTS `invoice_sale`;
CREATE TABLE IF NOT EXISTS `invoice_sale` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_code` varchar(45) NOT NULL,
  `invoice_value` decimal(10,4) NOT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `status` enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED',
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `observations` text,
  `value_taxes` decimal(10,4) NOT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `authorization_number` varchar(150) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `establishment` varchar(3) NOT NULL,
  `emission_point` varchar(3) NOT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `mixed_payment` int(11) NOT NULL DEFAULT '1' COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS',
  `has_retention` int(11) NOT NULL DEFAULT '1' COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion',
  `debt` int(11) NOT NULL DEFAULT '0' COMMENT '0=sin DEUDA\n 1=DEUDA',
  `freight` int(11) NOT NULL DEFAULT '0',
  `type_of_discount` int(11) NOT NULL DEFAULT '0' COMMENT '0=% \n1=$',
  `discount_type_invoice` int(11) NOT NULL DEFAULT '0' COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	',
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_voucher_type1_idx` (`voucher_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_breakdown_payment`
--

DROP TABLE IF EXISTS `invoice_sale_by_breakdown_payment`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_breakdown_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_agreement` datetime NOT NULL,
  `payment_value` decimal(10,4) NOT NULL,
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '0=pagado 1=deuda',
  `user_id` int(11) NOT NULL,
  `invoice_sale_by_indebtedness_paying_init_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_breakdown_payment_invoice_sale_by_indebt_idx` (`invoice_sale_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_details`
--

DROP TABLE IF EXISTS `invoice_sale_by_details`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,4) DEFAULT NULL,
  `quantity_unit` decimal(10,4) DEFAULT NULL,
  `discount_percentage` decimal(10,4) DEFAULT NULL,
  `discount_percentage_unit` decimal(10,4) DEFAULT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `discount_value_unit` decimal(10,4) DEFAULT NULL,
  `unit_price` decimal(10,4) DEFAULT NULL,
  `unit_price_unit` decimal(10,4) DEFAULT NULL,
  `management_type` char(3) DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
  `tax_percentage` int(11) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `description` text,
  `product_type` varchar(45) DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND',
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_details_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_details_devolution`
--

DROP TABLE IF EXISTS `invoice_sale_by_details_devolution`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_details_devolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,4) DEFAULT NULL,
  `quantity_unit` decimal(10,4) DEFAULT NULL,
  `discount_percentage` decimal(10,4) DEFAULT NULL,
  `discount_percentage_unit` decimal(10,4) DEFAULT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `discount_value_unit` decimal(10,4) DEFAULT NULL,
  `unit_price` decimal(10,4) DEFAULT NULL,
  `unit_price_unit` decimal(10,4) DEFAULT NULL,
  `management_type` char(3) DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.',
  `tax_percentage` int(11) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_details_devolution_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_devolution_product`
--

DROP TABLE IF EXISTS `invoice_sale_by_devolution_product`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_devolution_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_defect_id` int(11) NOT NULL,
  `details` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `types_payments_id` int(11) NOT NULL,
  `accounting_account_id` int(11) NOT NULL,
  `invoice_sale_by_details_devolution_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_devolution_product_product_defect1_idx` (`product_defect_id`),
  KEY `fk_invoice_buy_by_devolution_product_types_payments1_idx` (`types_payments_id`),
  KEY `fk_invoice_buy_by_devolution_product_accounting_account1_idx` (`accounting_account_id`),
  KEY `fk_invoice_sale_by_devolution_product_invoice_sale_by_detai_idx` (`invoice_sale_by_details_devolution_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_indebtedness_paying_init`
--

DROP TABLE IF EXISTS `invoice_sale_by_indebtedness_paying_init`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_indebtedness_paying_init` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_payments` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_indebtedness_paying_init_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_overridden`
--

DROP TABLE IF EXISTS `invoice_sale_by_overridden`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_overridden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `register_manager_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_overridden_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_payment`
--

DROP TABLE IF EXISTS `invoice_sale_by_payment`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_date` datetime NOT NULL,
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '	1=puntual 0=atrasado',
  `details` text,
  `types_payments_by_account_id` int(11) NOT NULL,
  `accounting_account_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_sale_by_breakdown_payment_id` int(11) NOT NULL,
  `invoice_sale_by_indebtedness_paying_init_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  KEY `fk_invoice_sale_by_payment_invoice_sale_by_breakdown_paymen_idx` (`invoice_sale_by_breakdown_payment_id`),
  KEY `fk_invoice_sale_by_payment_invoice_sale_by_indebtedness_pay_idx` (`invoice_sale_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_pendient`
--

DROP TABLE IF EXISTS `invoice_sale_by_pendient`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_pendient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indebtedness_paying` decimal(10,4) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_sale_by_pendient_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_retention`
--

DROP TABLE IF EXISTS `invoice_sale_by_retention`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_retention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retention_tax_sub_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `retained_value` decimal(10,4) DEFAULT NULL,
  `establishment` varchar(3) DEFAULT NULL,
  `emission_point` varchar(3) NOT NULL,
  `number_authorization` varchar(3) NOT NULL,
  `number_retention` varchar(250) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_retention_retention_tax_sub_type1_idx` (`retention_tax_sub_type_id`),
  KEY `fk_invoice_sale_by_retention_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_transactional_annex`
--

DROP TABLE IF EXISTS `invoice_sale_by_transactional_annex`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_transactional_annex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `management_livelihood_by_voucher_id` int(11) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_transactional_annex_management_livelihood_idx` (`management_livelihood_by_voucher_id`),
  KEY `fk_invoice_sale_by_transactional_annex_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_sale_by_transactions`
--

DROP TABLE IF EXISTS `invoice_sale_by_transactions`;
CREATE TABLE IF NOT EXISTS `invoice_sale_by_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percentage_discount` decimal(10,4) DEFAULT NULL,
  `value_discount` decimal(10,4) DEFAULT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `total` decimal(10,4) NOT NULL,
  `account` varchar(45) DEFAULT NULL,
  `accounting_account_id` int(11) NOT NULL,
  `way_to_pay` varchar(250) NOT NULL,
  `type_payment_id` int(11) NOT NULL,
  `invoice_sale_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_factura_buy_by_transactions_accounting_account1_idx` (`accounting_account_id`),
  KEY `fk_invoice_sale_by_transactions_invoice_sale1_idx` (`invoice_sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `initials` varchar(4) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `language`
--

INSERT INTO `language` (`id`, `value`, `initials`, `state`, `description`) VALUES
(1, 'Ingles', 'en', 'ACTIVE', 'Ingles'),
(2, 'Kichwa', 'ki', 'ACTIVE', NULL),
(3, 'Español', 'es', 'ACTIVE', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product`
--

DROP TABLE IF EXISTS `language_product`;
CREATE TABLE IF NOT EXISTS `language_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_product_language1_idx` (`language_id`),
  KEY `fk_language_product_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product_category`
--

DROP TABLE IF EXISTS `language_product_category`;
CREATE TABLE IF NOT EXISTS `language_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `subtitle` varchar(250) DEFAULT NULL,
  `language_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_product_category_language1_idx` (`language_id`),
  KEY `fk_language_product_category_product_category1_idx` (`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product_color`
--

DROP TABLE IF EXISTS `language_product_color`;
CREATE TABLE IF NOT EXISTS `language_product_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_color_id` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_language_product_trademark_language1_idx` (`language_id`),
  KEY `fk_language_product_color_product_color1_idx` (`product_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product_measure_type`
--

DROP TABLE IF EXISTS `language_product_measure_type`;
CREATE TABLE IF NOT EXISTS `language_product_measure_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_measure_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_product_measure_type_language1_idx` (`language_id`),
  KEY `fk_language_product_measure_type_product_measure_type1_idx` (`product_measure_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product_subcategory`
--

DROP TABLE IF EXISTS `language_product_subcategory`;
CREATE TABLE IF NOT EXISTS `language_product_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `value` varchar(200) NOT NULL,
  `description` text,
  `subtitle` varchar(250) DEFAULT NULL,
  `product_subcategory_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_language_product_category_language1_idx` (`language_id`),
  KEY `fk_language_product_subcategory_product_subcategory1_idx` (`product_subcategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_product_trademark`
--

DROP TABLE IF EXISTS `language_product_trademark`;
CREATE TABLE IF NOT EXISTS `language_product_trademark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_trademark_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_product_trademark_language1_idx` (`language_id`),
  KEY `fk_language_product_trademark_product_trademark1_idx` (`product_trademark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_about_us`
--

DROP TABLE IF EXISTS `language_template_about_us`;
CREATE TABLE IF NOT EXISTS `language_template_about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `subtitle` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_about_us_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_about_us_language1_idx` (`language_id`),
  KEY `fk_language_template_about_us_template_about_us1_idx` (`template_about_us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_about_us_by_data`
--

DROP TABLE IF EXISTS `language_template_about_us_by_data`;
CREATE TABLE IF NOT EXISTS `language_template_about_us_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_about_us_by_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_about_us_by_data_language1_idx` (`language_id`),
  KEY `fk_language_template_about_us_by_data_template_about_us_by__idx` (`template_about_us_by_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_policies`
--

DROP TABLE IF EXISTS `language_template_policies`;
CREATE TABLE IF NOT EXISTS `language_template_policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_policies_id` int(11) NOT NULL,
  `subtitle` text,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_services_language1_idx` (`language_id`),
  KEY `fk_language_template_policies_template_policies1_idx` (`template_policies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_services`
--

DROP TABLE IF EXISTS `language_template_services`;
CREATE TABLE IF NOT EXISTS `language_template_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_services_id` int(11) NOT NULL,
  `subtitle` text,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_services_language1_idx` (`language_id`),
  KEY `fk_language_template_services_template_services1_idx` (`template_services_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_services_by_data`
--

DROP TABLE IF EXISTS `language_template_services_by_data`;
CREATE TABLE IF NOT EXISTS `language_template_services_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_services_by_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_services_by_data_language1_idx` (`language_id`),
  KEY `fk_language_template_services_by_data_template_services_by__idx` (`template_services_by_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_template_slider_by_images`
--

DROP TABLE IF EXISTS `language_template_slider_by_images`;
CREATE TABLE IF NOT EXISTS `language_template_slider_by_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text,
  `language_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `subtitle` text,
  `template_slider_by_images_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_language_template_services_language1_idx` (`language_id`),
  KEY `fk_language_template_slider_by_images_template_slider_by_im_idx` (`template_slider_by_images_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging`
--

DROP TABLE IF EXISTS `lodging`;
CREATE TABLE IF NOT EXISTS `lodging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_at` datetime NOT NULL,
  `output_at` datetime DEFAULT NULL,
  `number_people` int(11) NOT NULL,
  `adults` int(11) DEFAULT NULL COMMENT '0=no\n1=si',
  `children` int(11) DEFAULT NULL COMMENT '0=no\n1=si',
  `number_rooms` int(11) NOT NULL,
  `total_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_made` int(11) NOT NULL DEFAULT '0' COMMENT '0=NO\n1=YES',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text,
  `business_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `arrived_made` int(11) NOT NULL DEFAULT '0',
  `rooms_add_made` int(11) NOT NULL DEFAULT '0',
  `status_delivery` int(11) NOT NULL DEFAULT '0' COMMENT '0=INIT\n1=FINALIZED\n',
  `delivery_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_arrived_by_social_networks`
--

DROP TABLE IF EXISTS `lodging_arrived_by_social_networks`;
CREATE TABLE IF NOT EXISTS `lodging_arrived_by_social_networks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_social_networks` int(11) NOT NULL DEFAULT '0' COMMENT '0=FACEBOOK\n1=INSTAGRAM\n2=TWitter\n3=youtube\n4=spotify',
  `lodging_by_arrived_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lodging_arrived_by_social_networks_lodging_by_arrived1_idx` (`lodging_by_arrived_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_arrived`
--

DROP TABLE IF EXISTS `lodging_by_arrived`;
CREATE TABLE IF NOT EXISTS `lodging_by_arrived` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lodging_id` int(11) NOT NULL,
  `way_to_contact` int(11) NOT NULL DEFAULT '0' COMMENT '0=REDES SOCIALES\n1=COMERCIO\n2=RECOMDANCIONES PERSONAS\n3=',
  PRIMARY KEY (`id`),
  KEY `fk_lodging_by_contact_lodging1_idx` (`lodging_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_customer`
--

DROP TABLE IF EXISTS `lodging_by_customer`;
CREATE TABLE IF NOT EXISTS `lodging_by_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` int(11) NOT NULL DEFAULT '1' COMMENT '0=NOT MAIN\n1=MAIN',
  `lodging_id` int(11) NOT NULL,
  `has_information_additional` int(11) NOT NULL DEFAULT '0' COMMENT '0=not has\n1=has',
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_loding_by_customer_lodging1_idx` (`lodging_id`),
  KEY `fk_lodging_by_customer_customer1_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_customer_location`
--

DROP TABLE IF EXISTS `lodging_by_customer_location`;
CREATE TABLE IF NOT EXISTS `lodging_by_customer_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lodging_by_customer_id` int(11) NOT NULL,
  `information_address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_loding_by_customer_location_lodging_by_customer1_idx` (`lodging_by_customer_id`),
  KEY `fk_lodging_by_customer_location_information_address1_idx` (`information_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_payment`
--

DROP TABLE IF EXISTS `lodging_by_payment`;
CREATE TABLE IF NOT EXISTS `lodging_by_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `way_to_pay` int(11) NOT NULL COMMENT '0=EFECTIVO\n1=TARJETA DE CREDITO\n2=DOCUMENTOS DE PAGO',
  `lodging_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lodging_by_payment_lodging1_idx` (`lodging_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_payment_credit_card`
--

DROP TABLE IF EXISTS `lodging_by_payment_credit_card`;
CREATE TABLE IF NOT EXISTS `lodging_by_payment_credit_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_credit_card` int(11) NOT NULL COMMENT '0=DINERS\n1=VISA\n2=MASTERCARD\n3=OTRAS',
  `lodging_by_payment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_loding_by_payment_credit_card_lodging_by_payment1_idx` (`lodging_by_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_reasons`
--

DROP TABLE IF EXISTS `lodging_by_reasons`;
CREATE TABLE IF NOT EXISTS `lodging_by_reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lodging_id` int(11) NOT NULL,
  `reason` int(11) NOT NULL COMMENT '0=job\n1=holidays\n2= spend the night\n',
  PRIMARY KEY (`id`),
  KEY `fk_lodging_by_reasons_lodging1_idx` (`lodging_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_by_type_of_room`
--

DROP TABLE IF EXISTS `lodging_by_type_of_room`;
CREATE TABLE IF NOT EXISTS `lodging_by_type_of_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lodging_id` int(11) NOT NULL,
  `lodging_type_of_room_by_price_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lodging_by_type_of_room_lodging1_idx` (`lodging_id`),
  KEY `fk_lodging_by_type_of_room_lodging_type_of_room_by_price1_idx` (`lodging_type_of_room_by_price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_customer_additional_information`
--

DROP TABLE IF EXISTS `lodging_customer_additional_information`;
CREATE TABLE IF NOT EXISTS `lodging_customer_additional_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_mobile_id` int(11) DEFAULT NULL,
  `information_phone_id` int(11) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `lodging_by_customer_id` int(11) NOT NULL,
  `information_mail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lodging_customer_additional_information_lodging_by_custo_idx` (`lodging_by_customer_id`),
  KEY `fk_lodging_customer_additional_information_information_mail_idx` (`information_mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_room_features`
--

DROP TABLE IF EXISTS `lodging_room_features`;
CREATE TABLE IF NOT EXISTS `lodging_room_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_room_levels`
--

DROP TABLE IF EXISTS `lodging_room_levels`;
CREATE TABLE IF NOT EXISTS `lodging_room_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_type_of_room`
--

DROP TABLE IF EXISTS `lodging_type_of_room`;
CREATE TABLE IF NOT EXISTS `lodging_type_of_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lodging_type_of_room`
--

INSERT INTO `lodging_type_of_room` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Habitación individual o habitación simple', 'Habitación estándar destinada a la pernoctación y\r\nalojamiento turístico de una sola persona.', NULL, NULL, NULL, 'ACTIVE'),
(2, 'Habitación doble', 'Habitación estándar destinada a la pernoctación y alojamiento turístico de dos\r\npersonas.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(3, 'Habitación triple', 'Habitación estándar destinada a la pernoctación y alojamiento turístico de tres\r\npersonas.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(4, 'Habitación cuádruple', 'Habitación estándar destinada a la pernoctación y alojamiento turístico de\r\ncuatro personas. Este tipo de habitaciones están prohibidas en establecimientos de alojamiento turístico de cinco estrellas.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(5, 'Habitación múltiple', 'Habitación estándar destinada a la pernoctación y alojamiento turístico de\r\ncinco o más personas. Este tipo de habitación no aplica para establecimientos de cinco estrellas.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(6, 'Habitación júnior suite', 'Habitación destinada al alojamiento turístico compuesto por un ambiente\r\nadicional que se encuentre en funcionamiento.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(7, 'Habitación suite', ' Unidad habitacional destinada al alojamiento turístico compuesta de una o más\r\náreas, al menos un baño privado y un ambiente separado que incluya sala de estar, área de trabajo,\r\nentre otros.\r\n', NULL, NULL, NULL, 'ACTIVE'),
(8, 'Otras', NULL, NULL, NULL, NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_type_of_room_by_price`
--

DROP TABLE IF EXISTS `lodging_type_of_room_by_price`;
CREATE TABLE IF NOT EXISTS `lodging_type_of_room_by_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('ACTIVE','INACTIVE','FREE','OCCUPIED','CLEANING') NOT NULL DEFAULT 'ACTIVE',
  `room_number` varchar(150) NOT NULL,
  `lodging_type_of_room_id` int(11) NOT NULL,
  `lodging_room_levels_id` int(11) NOT NULL,
  `description` text,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lodging_type_of_room_by_price_lodging_type_of_room1_idx` (`lodging_type_of_room_id`),
  KEY `fk_lodging_type_of_room_by_price_lodging_room_levels1_idx` (`lodging_room_levels_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lodging_type_of_room_price_by_features`
--

DROP TABLE IF EXISTS `lodging_type_of_room_price_by_features`;
CREATE TABLE IF NOT EXISTS `lodging_type_of_room_price_by_features` (
  `lodging_type_of_room_by_price_id` int(11) NOT NULL,
  `lodging_room_features_id` int(11) NOT NULL,
  PRIMARY KEY (`lodging_type_of_room_by_price_id`,`lodging_room_features_id`),
  KEY `fk_lodging_type_of_room_price_by_features_lodging_room_feat_idx` (`lodging_room_features_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailing_by_data_send`
--

DROP TABLE IF EXISTS `mailing_by_data_send`;
CREATE TABLE IF NOT EXISTS `mailing_by_data_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `entity_type` int(11) NOT NULL DEFAULT '1' COMMENT '1=OWNER API\n2=MAILCHIMP',
  `mailing_template_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mailing_by_data_send_customer1_idx` (`customer_id`),
  KEY `fk_mailing_by_data_sendmai_mailing_template1_idx` (`mailing_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailing_template`
--

DROP TABLE IF EXISTS `mailing_template`;
CREATE TABLE IF NOT EXISTS `mailing_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `user_id` int(11) NOT NULL,
  `source_main` varchar(250) NOT NULL,
  `type_template` int(11) NOT NULL DEFAULT '1' COMMENT '1=ONLY IMAGE\n2=IMAGE AND MESSAGE',
  PRIMARY KEY (`id`),
  KEY `fk_mailing_template_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `management_livelihood_by_voucher`
--

DROP TABLE IF EXISTS `management_livelihood_by_voucher`;
CREATE TABLE IF NOT EXISTS `management_livelihood_by_voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_support_id` int(11) NOT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `people_type_identification_id` int(11) NOT NULL,
  `type_management` int(11) NOT NULL DEFAULT '0' COMMENT '0=buys\n1=sales\netc',
  PRIMARY KEY (`id`),
  KEY `fk_management_livelihood_by_voucher_tax_support1_idx` (`tax_support_id`),
  KEY `fk_management_livelihood_by_voucher_voucher_type1_idx` (`voucher_type_id`),
  KEY `fk_management_livelihood_by_voucher_people_type_identificat_idx` (`people_type_identification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `measure_subtype_by_equivalence`
--

DROP TABLE IF EXISTS `measure_subtype_by_equivalence`;
CREATE TABLE IF NOT EXISTS `measure_subtype_by_equivalence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` double NOT NULL,
  `measurent_subtype_id` int(11) NOT NULL,
  `product_measurent_subtype_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_measure_subtype_by_equivalence_product_measurent_subtype_idx` (`measurent_subtype_id`),
  KEY `fk_measure_subtype_by_equivalence_product_measurent_subtype_idx1` (`product_measurent_subtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_consultation_by_patient`
--

DROP TABLE IF EXISTS `medical_consultation_by_patient`;
CREATE TABLE IF NOT EXISTS `medical_consultation_by_patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason_consultation` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `history_clinic_id` int(11) NOT NULL,
  `payment_state` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT PAYMENT\n1=PAYMENT\n3=OTHERS',
  `user_id` int(11) NOT NULL COMMENT 'USER MANAGER ADD CONSULT',
  `prepayment` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '0=NOT PAYMENT\n1=PAYMENT\n2=OTHERS',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'PRICE BY CONSULT',
  `description` text NOT NULL COMMENT 'OBSERVATION',
  PRIMARY KEY (`id`),
  KEY `fk_medical_consultation_by_patient_history_clinic1_idx` (`history_clinic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(6, '2016_06_01_000004_create_oauth_clients_table', 2),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontogram_by_patient`
--

DROP TABLE IF EXISTS `odontogram_by_patient`;
CREATE TABLE IF NOT EXISTS `odontogram_by_patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `history_clinic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_odontogram_by_patient_history_clinic1_idx` (`history_clinic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_event_kits_by_customer`
--

DROP TABLE IF EXISTS `order_event_kits_by_customer`;
CREATE TABLE IF NOT EXISTS `order_event_kits_by_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `events_trails_registration_by_customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `delivery` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT DELIVERY\n1=DELIVERY',
  PRIMARY KEY (`id`),
  KEY `fk_order_event_customer_events_trails_registration_by_custo_idx` (`events_trails_registration_by_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_payments_document`
--

DROP TABLE IF EXISTS `order_payments_document`;
CREATE TABLE IF NOT EXISTS `order_payments_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_payments_manager_id` int(11) NOT NULL,
  `source` varchar(250) NOT NULL,
  `account_bank` varchar(150) NOT NULL,
  `number_bank` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_payments_document_order_payments_manager1_idx` (`order_payments_manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_payments_manager`
--

DROP TABLE IF EXISTS `order_payments_manager`;
CREATE TABLE IF NOT EXISTS `order_payments_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `manager_state` int(11) NOT NULL DEFAULT '0' COMMENT '0=CREADA\n1=EJECUTADA\n',
  `start` datetime NOT NULL,
  `manager_id` text COMMENT 'Dependiendo dela forma de pago generara un id unico de la transaccion\npaypal=pay_id',
  `payer_id` text,
  `token` varchar(350) DEFAULT NULL COMMENT 'todo depende dl typo d pago realizado al realizar l checkout',
  `type_payment_customer` int(11) NOT NULL DEFAULT '0' COMMENT '0=PAYPAL\n1=API CREDIT CARDS\n2=DEPOSITO',
  `end` datetime DEFAULT NULL,
  `type_user` int(11) NOT NULL DEFAULT '0' COMMENT '0=GUEST\n1=USER MANAGER ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_shopping_by_customer_delivery`
--

DROP TABLE IF EXISTS `order_shopping_by_customer_delivery`;
CREATE TABLE IF NOT EXISTS `order_shopping_by_customer_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `payer_email` varchar(350) NOT NULL,
  `company` varchar(150) DEFAULT NULL,
  `address_secondary` text NOT NULL,
  `city` varchar(150) NOT NULL,
  `state_province_id` int(11) DEFAULT NULL,
  `zipcode` varchar(80) NOT NULL,
  `country_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address_main` text NOT NULL,
  `document` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_shoping_by_customer_delivery_people1_idx` (`people_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_shopping_by_delivery`
--

DROP TABLE IF EXISTS `order_shopping_by_delivery`;
CREATE TABLE IF NOT EXISTS `order_shopping_by_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `payer_email` varchar(350) NOT NULL,
  `company` varchar(150) DEFAULT NULL,
  `address_secondary` text NOT NULL,
  `city` varchar(150) NOT NULL,
  `state_province_id` int(11) DEFAULT NULL,
  `zipcode` varchar(80) NOT NULL,
  `country_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address_main` text NOT NULL,
  `order_shopping_cart_id` int(11) NOT NULL,
  `document` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_shoping_by_customer_delivery_people1_idx` (`people_id`),
  KEY `fk_order_shopping_by_delivery_order_shopping_cart1_idx` (`order_shopping_cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_shopping_cart`
--

DROP TABLE IF EXISTS `order_shopping_cart`;
CREATE TABLE IF NOT EXISTS `order_shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_payments_manager_id` int(11) NOT NULL,
  `state` enum('CANCELED','TO DELIVER','DELIVERED','CREATED') NOT NULL DEFAULT 'TO DELIVER',
  `subtotal` float NOT NULL,
  `description` text NOT NULL,
  `shipping` float NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_shopping_by_customer_delivery_id` int(11) NOT NULL,
  `same_billing_address` int(11) NOT NULL DEFAULT '0' COMMENT '0=SAME BILLING\n1=OTHER BILLING DELIVERY',
  PRIMARY KEY (`id`),
  KEY `fk_order_shopping_cart_order_payments_manager1_idx` (`order_payments_manager_id`),
  KEY `fk_order_shopping_cart_order_shopping_by_customer_delivery1_idx` (`order_shopping_by_customer_delivery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_shopping_cart_by_details`
--

DROP TABLE IF EXISTS `order_shopping_cart_by_details`;
CREATE TABLE IF NOT EXISTS `order_shopping_cart_by_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `measure_id` varchar(45) DEFAULT NULL,
  `measure` varchar(45) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `price_before` float DEFAULT NULL,
  `price_discount` float DEFAULT NULL,
  `allow_discount` int(11) NOT NULL DEFAULT '0',
  `promotion_id` int(11) DEFAULT NULL,
  `name` varchar(350) DEFAULT NULL,
  `order_shopping_cart_id` int(11) NOT NULL,
  `product_color` varchar(100) DEFAULT NULL,
  `product_color_id` int(11) DEFAULT NULL,
  `product_sizes_id` int(11) DEFAULT NULL,
  `product_sizes` varchar(150) DEFAULT NULL,
  `type_variant` int(11) NOT NULL DEFAULT '0' COMMENT '0:anyOneVariant,\n1: sizeSearch,\n2: colorSearch,\n3: colorAndSizeSearch',
  PRIMARY KEY (`id`),
  KEY `fk_order_shopping_cart_by_details_order_shopping_cart1_idx` (`order_shopping_cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panorama`
--

DROP TABLE IF EXISTS `panorama`;
CREATE TABLE IF NOT EXISTS `panorama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text,
  `type_panorama` int(11) NOT NULL DEFAULT '0' COMMENT '0=NORMAL\n1=IMAGE RESUMEN MAP',
  `points_allow` int(11) NOT NULL DEFAULT '1' COMMENT '0=not breakdown\n1= breakdown',
  `src` varchar(250) NOT NULL,
  `type_breakdown` int(11) NOT NULL DEFAULT '0' COMMENT '0=PARENT\n1=CHILDREN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panorama_points`
--

DROP TABLE IF EXISTS `panorama_points`;
CREATE TABLE IF NOT EXISTS `panorama_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text,
  `next_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=DEFAULT IMAGE\n1=OTHERS',
  `coordinate_x` decimal(10,6) NOT NULL,
  `coordinate_y` decimal(10,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parameters`
--

INSERT INTO `parameters` (`id`, `name`, `value`) VALUES
(1, 'environment', 'staging'),
(2, 'host_firebase_url', 'https://us-central1-timelygas-396c4.cloudfunctions.net/api'),
(3, 'site_url', 'http://back.timelygas.com'),
(4, 'cancel_status_id', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` datetime DEFAULT NULL,
  `age` int(11) NOT NULL DEFAULT '0',
  `gender` int(11) NOT NULL COMMENT '0=MAN\n1=FEMALE\n2=LBTBI\n3=OTROS',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `last_name`, `name`, `birthdate`, `age`, `gender`) VALUES
(1, 'Suarez', '<font color=\"#F5F7FA\">2</font>María Mercedes', '2020-08-01 00:00:00', 0, 1),
(2, 'Llerena', '<font color=\"#F5F7FA\">4</font>Jessy', '2020-07-08 00:00:00', 0, 1),
(3, 'Albuja', '<font color=\"#F5F7FA\">6</font>Lorena', '2020-07-07 00:00:00', 0, 1),
(4, 'Madera', '<font color=\"#F5F7FA\">5</font>Ximena', '2016-01-01 00:00:00', 0, 1),
(5, 'Garcia', '<font color=\"#F5F7FA\">3</font>Grace', '1988-08-20 00:00:00', 0, 1),
(6, 'Luna', '<font color=\"#F5F7FA\">1</font>Ana', '2020-11-03 00:00:00', 0, 1),
(7, 'Suarez', '<font color=\"#F5F7FA\">2</font>María Mercedes', '2020-02-05 00:00:00', 0, 1),
(8, 'Carapaz', '<font color=\"#F5F7FA\">3</font>José Miguel', '2020-05-01 00:00:00', 0, 0),
(9, 'Díaz', '<font color=\"#F5F7FA\">1</font>Washington', '2020-03-06 00:00:00', 0, 0),
(10, 'Cazar', '<font color=\"#F5F7FA\">5</font>Renato', '2020-08-05 00:00:00', 0, 0),
(11, 'Suarez', '<font color=\"#F5F7FA\">4</font>José Rafael', '2020-09-02 00:00:00', 0, 0),
(12, 'Terán', '<font color=\"#F5F7FA\">6</font>Fernando', '2020-07-02 00:00:00', 0, 0),
(19, 'Villareal', '<font color=\"#F5F7FA\">1</font>María Isabel', '2021-02-18 00:00:00', 0, 1),
(20, 'Suarez', '<font color=\"#F5F7FA\">2</font>María Mercedes', '2021-02-18 00:00:00', 0, 1),
(21, 'Corrales', '<font color=\"#F5F7FA\">3</font>Carolina', '2021-02-09 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people_gender`
--

DROP TABLE IF EXISTS `people_gender`;
CREATE TABLE IF NOT EXISTS `people_gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people_gender`
--

INSERT INTO `people_gender` (`id`, `value`, `description`, `status`) VALUES
(1, 'Masculino', 'hom', 'ACTIVE'),
(2, 'Femenino', 'hom', 'ACTIVE'),
(3, 'LGBTI', 'hom', 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people_nationality`
--

DROP TABLE IF EXISTS `people_nationality`;
CREATE TABLE IF NOT EXISTS `people_nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `countries_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people_nationality`
--

INSERT INTO `people_nationality` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `countries_id`) VALUES
(1, 'Afgano/\nfgana', NULL, NULL, NULL, NULL, 'ACTIVE', 1),
(2, 'Alemán/\n/Alemana', NULL, NULL, NULL, NULL, 'ACTIVE', 2),
(3, 'Arabe', NULL, NULL, NULL, NULL, 'ACTIVE', 3),
(4, '	Argentino\n/Argentina', NULL, NULL, NULL, NULL, 'ACTIVE', 4),
(5, 'Australiano\n/Australiana', NULL, NULL, NULL, NULL, 'ACTIVE', 5),
(6, 'Belga\n', NULL, NULL, NULL, NULL, 'ACTIVE', 6),
(7, 'Boliviano\n/Boliviana', NULL, NULL, NULL, NULL, 'ACTIVE', 7),
(8, '	Brasileño\n/Brasileña', NULL, NULL, NULL, NULL, 'ACTIVE', 8),
(9, 'Camboyano\n/Camboyana', NULL, NULL, NULL, NULL, 'ACTIVE', 9),
(10, 'canadiense\ncanadiense', NULL, NULL, NULL, NULL, 'ACTIVE', 10),
(11, 'Chileno\n/Chilena', NULL, NULL, NULL, NULL, 'ACTIVE', 11),
(12, 'Chino\n/China', NULL, NULL, NULL, NULL, 'ACTIVE', 12),
(13, 'Colombiano\n/Colombiana', NULL, NULL, NULL, NULL, 'ACTIVE', 13),
(14, 'Coreano\n/Coreana', NULL, NULL, NULL, NULL, 'ACTIVE', 14),
(15, 'Costarricense\n/Costarricense', NULL, NULL, NULL, NULL, 'ACTIVE', 15),
(16, 'Cubano\n/Cubana', NULL, NULL, NULL, NULL, 'ACTIVE', 16),
(17, 'Danés\n/Danesa', NULL, NULL, NULL, NULL, 'ACTIVE', 17),
(18, 'Ecuatoriano\n/Ecuatoriana', NULL, NULL, NULL, NULL, 'ACTIVE', 18),
(19, 'Egipcio\n/Egipcia', NULL, NULL, NULL, NULL, 'ACTIVE', 19),
(20, 'Salvadoreño\n/Salvadoreña', NULL, NULL, NULL, NULL, 'ACTIVE', 20),
(21, 'Escocés\nEscocesa', NULL, NULL, NULL, NULL, 'ACTIVE', 21),
(22, 'Español\n/Española', NULL, NULL, NULL, NULL, 'ACTIVE', 22),
(23, 'Estadounidense', NULL, NULL, NULL, NULL, 'ACTIVE', 23),
(24, 'Estonio\n/Estonia', NULL, NULL, NULL, NULL, 'ACTIVE', 24),
(25, 'Etiope', NULL, NULL, NULL, NULL, 'ACTIVE', 25),
(26, 'Filipino\n/Filipina', NULL, NULL, NULL, NULL, 'ACTIVE', 26),
(27, 'Finlandés\n/Finlandesa', NULL, NULL, NULL, NULL, 'ACTIVE', 27),
(28, 'Francés\n/Francesa', NULL, NULL, NULL, NULL, 'ACTIVE', 28),
(29, 'Galés\n/Galesa', NULL, NULL, NULL, NULL, 'ACTIVE', 29),
(30, 'Griego\n/Griega', NULL, NULL, NULL, NULL, 'ACTIVE', 30),
(31, 'Guatemalteco\n/Guatemalteca', NULL, NULL, NULL, NULL, 'ACTIVE', 31),
(32, 'Haitiano\n/Haitiana', NULL, NULL, NULL, NULL, 'ACTIVE', 32),
(33, 'Holandés\n/Holandesa', NULL, NULL, NULL, NULL, 'ACTIVE', 33),
(34, 'Hondureño\n/Hondureña', NULL, NULL, NULL, NULL, 'ACTIVE', 34),
(35, 'Indonés\n/Indonesa', NULL, NULL, NULL, NULL, 'ACTIVE', 35),
(36, 'Inglés\n/Inglesa', NULL, NULL, NULL, NULL, 'ACTIVE', 36),
(37, 'Iraquí', NULL, NULL, NULL, NULL, 'ACTIVE', 37),
(38, 'Iraní', NULL, NULL, NULL, NULL, 'ACTIVE', 38),
(39, 'Irlandés\n/Irlandesa', NULL, NULL, NULL, NULL, 'ACTIVE', 39),
(40, 'Israelí', NULL, NULL, NULL, NULL, 'ACTIVE', 40),
(41, 'Italiano\nItaliana', NULL, NULL, NULL, NULL, 'ACTIVE', 41),
(42, 'Japonés\nJaponesa', NULL, NULL, NULL, NULL, 'ACTIVE', 42),
(43, 'Jordano\n/Jordana', NULL, NULL, NULL, NULL, 'ACTIVE', 43),
(44, 'Laosiano\n/Laosiana', NULL, NULL, NULL, NULL, 'ACTIVE', 44),
(45, 'Letón\n/Letona', NULL, NULL, NULL, NULL, 'ACTIVE', 45),
(46, 'Letonés\n/Letonesa', NULL, NULL, NULL, NULL, 'ACTIVE', 46),
(47, 'Malayo\n/Malaya', NULL, NULL, NULL, NULL, 'ACTIVE', 47),
(48, 'Marroquí', NULL, NULL, NULL, NULL, 'ACTIVE', 48),
(49, 'Mexicano\n/Mexicana', NULL, NULL, NULL, NULL, 'ACTIVE', 49),
(50, 'Nicaragüense', NULL, NULL, NULL, NULL, 'ACTIVE', 50),
(51, 'Noruego\n/Noruega', NULL, NULL, NULL, NULL, 'ACTIVE', 51),
(52, 'Neozelandés\n/Neozelandesa', NULL, NULL, NULL, NULL, 'ACTIVE', 52),
(53, 'Panameño\n/Panameña', NULL, NULL, NULL, NULL, 'ACTIVE', 53),
(54, 'Paraguayo\n/Paraguaya', NULL, NULL, NULL, NULL, 'ACTIVE', 54),
(55, 'Peruano\n/Peruana', NULL, NULL, NULL, NULL, 'ACTIVE', 55),
(56, 'Polaco\n/Polaca', NULL, NULL, NULL, NULL, 'ACTIVE', 56),
(57, 'Portugués\nPortuguesa', NULL, NULL, NULL, NULL, 'ACTIVE', 57),
(58, 'Puertorriqueño', NULL, NULL, NULL, NULL, 'ACTIVE', 58),
(59, 'Dominicano\n/Dominicana', NULL, NULL, NULL, NULL, 'ACTIVE', 59),
(60, 'Rumano\n/Rumana', NULL, NULL, NULL, NULL, 'ACTIVE', 60),
(61, 'Ruso\n/Rusa', NULL, NULL, NULL, NULL, 'ACTIVE', 61),
(62, 'Sueco/\nSueca', NULL, NULL, NULL, NULL, 'ACTIVE', 62),
(63, 'Suizo\n/Suiza', NULL, NULL, NULL, NULL, 'ACTIVE', 63),
(64, 'Tailandés\n/Tailandesa', NULL, NULL, NULL, NULL, 'ACTIVE', 64),
(65, 'Taiwanes\n/Taiwanesa', NULL, NULL, NULL, NULL, 'ACTIVE', 65),
(66, 'Turco\n/Turca', NULL, NULL, NULL, NULL, 'ACTIVE', 66),
(67, 'Ucraniano\n/Ucraniana', NULL, NULL, NULL, NULL, 'ACTIVE', 67),
(68, 'Uruguayo\n/Uruguaya', NULL, NULL, NULL, NULL, 'ACTIVE', 68),
(69, 'Venezolano\n/Venezolana', NULL, NULL, NULL, NULL, 'ACTIVE', 69),
(70, 'Vietnamita', NULL, NULL, NULL, NULL, 'ACTIVE', 70),
(71, 'Sin Especificación', NULL, NULL, NULL, NULL, 'ACTIVE', 71);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people_profession`
--

DROP TABLE IF EXISTS `people_profession`;
CREATE TABLE IF NOT EXISTS `people_profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people_profession`
--

INSERT INTO `people_profession` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Ninguna', 'Escoger esta opción cuando no se encuentra dentro del catálogo una sugerencia apropiada para paciente. Por ejemplo: niño/a menor de 4 años.', '2020-07-26 23:20:08', '2020-07-26 23:50:18', NULL, 'ACTIVE'),
(2, 'Mecánico/a', 'Persona que repara máquinas, autos, camiones, motores, etc.', NULL, '2020-07-19 03:48:39', NULL, 'ACTIVE'),
(3, 'Otras', 'En caso de que dentro del catálogo no exista la profesión u oficio del paciente escoger la opción Otras.', NULL, '2020-07-26 23:50:53', NULL, 'ACTIVE'),
(4, 'Diseñador/a', 'Persona que diseña creativa mente diferentes cosas, por ejemplo, ropa, muebles, papelería, etc.\nHace referencia a las profesiones de diseñador gráfico, de productos, de moda, entre otros.', '2019-10-26 18:24:13', '2020-07-19 03:38:00', NULL, 'ACTIVE'),
(5, 'Arquitecto/a', 'Persona que diseña edificios y casas, los diseños los representa en planos.', '2020-07-19 03:17:07', '2020-07-19 03:30:19', NULL, 'ACTIVE'),
(6, 'Bombero/a', 'Persona que apaga el fuego en un incendio.', '2020-07-19 03:20:15', '2020-07-19 03:31:42', NULL, 'ACTIVE'),
(7, 'Contador/a', 'Persona que trabaja con el dinero y trabaja con las cuentas de una compañía.', '2020-07-19 03:20:28', '2020-07-19 03:34:34', NULL, 'ACTIVE'),
(8, 'Doctor/a', 'Persona que se dedica a curar o prevenir enfermedades. Hace referencia a doctor en medicina general y a todas sus especialidades.', '2020-07-19 03:20:41', '2020-07-19 03:39:56', NULL, 'ACTIVE'),
(9, 'Enfermero/a', 'Persona que cuida a enfermos o a personas que están en un proceso de recuperación siguiendo las ordenes del doctor.', '2020-07-19 03:20:47', '2020-07-19 03:40:57', NULL, 'ACTIVE'),
(10, 'Agente de viaje', 'Persona que vende y organiza viajes, vacaciones y vuelos.', '2020-07-19 03:27:53', '2020-07-19 03:29:52', NULL, 'ACTIVE'),
(11, 'Carnicero/a', 'Persona que trabaja con carne. Ellos cortan la carne y la venden.', '2020-07-19 03:28:13', '2020-07-19 03:32:10', NULL, 'ACTIVE'),
(12, 'Abogado/a', 'Persona que defiende, representa o acusa a una persona en un juicio.', '2020-07-19 03:29:21', '2020-07-19 03:29:21', NULL, 'ACTIVE'),
(13, 'Carpintero/a', 'Persona que trabaja con madera haciendo casas o creando muebles.', '2020-07-19 03:32:44', '2020-07-19 03:32:44', NULL, 'ACTIVE'),
(14, 'Chofer', 'Persona que conduce o maneja vehículos, buses , transporte publico o privado, etc.', '2020-07-19 03:34:08', '2020-07-19 03:34:08', NULL, 'ACTIVE'),
(15, 'Chef/Cocinero/a', 'Persona que prepara comida para otros, comúnmente en un restaurante.', '2020-07-19 03:35:07', '2020-07-19 03:35:07', NULL, 'ACTIVE'),
(16, 'Estilista', 'Persona que corta el cabello y hace peinados, generalmente trabaja en un salón de belleza o peluquería.', '2020-07-19 03:41:52', '2020-07-19 03:41:52', NULL, 'ACTIVE'),
(17, 'Farmacéutico/a', 'Persona calificada que trabaja en una farmacia, chequea las prescripciones médicas o aconseja a los enfermos a comprar algún tipo de medicamentos.', '2020-07-19 03:42:19', '2020-07-19 03:42:19', NULL, 'ACTIVE'),
(18, 'Fontanero/a', 'Persona que repara las tuberías de agua o gas y realiza instalaciones de agua potable. Sinónimo: Plomero', '2020-07-19 03:42:50', '2020-07-19 03:42:50', NULL, 'ACTIVE'),
(19, 'Florista', 'Persona que trabaja en la producción de flores y diseña arreglos florales.', '2020-07-19 03:43:20', '2020-07-19 03:43:20', NULL, 'ACTIVE'),
(20, 'Fotógrafo/a', 'Persona que toma fotos de distintas cosas, por ejemplo de paisajes, personas, detalles, etc.', '2020-07-19 03:44:38', '2020-07-19 03:44:38', NULL, 'ACTIVE'),
(21, 'Jardinero/a', 'Persona que trabaja en el cuidado de un jardín, corta el pasto, realiza riegos periódicos, etc.', '2020-07-19 03:46:52', '2020-07-19 03:46:52', NULL, 'ACTIVE'),
(22, 'Juez/a', 'Persona que decide en un juicio si el acusado o demandado es culpable o inocente.', '2020-07-19 03:47:26', '2020-07-19 03:47:26', NULL, 'ACTIVE'),
(23, 'Maestro de construcción', 'Persona que construye casas o edificios y realiza diversas reparaciones.', '2020-07-19 03:48:02', '2020-07-19 03:48:02', NULL, 'ACTIVE'),
(24, 'Mesero/a', 'Persona que trabaja por lo general en un restaurante, atiende y sirve la comida a los clientes.', '2020-07-19 03:49:25', '2020-07-19 03:49:25', NULL, 'ACTIVE'),
(25, 'Modelo/a', 'Persona que muestra ropa o accesorios en un desfile de modas o revistas.', '2020-07-19 03:50:06', '2020-07-19 03:50:06', NULL, 'ACTIVE'),
(26, 'Oftalmólogo/a', 'Doctor especializado en el cuidado de la visión y corrige problemas relacionados con los ojos,', '2020-07-19 03:53:51', '2020-07-19 03:53:51', NULL, 'ACTIVE'),
(27, 'Panadero/a', 'Persona que hace pan y trabaja generalmente en una panadería.', '2020-07-19 03:54:52', '2020-07-19 03:54:52', NULL, 'ACTIVE'),
(28, 'Periodista', 'Persona que investiga e informa sobre las noticias, puede ser a través de un diario, revista, radio o televisión.', '2020-07-19 03:55:24', '2020-07-19 03:55:24', NULL, 'ACTIVE'),
(29, 'Pintor/a', '(1) Persona que pinta cuadros u obras de arte. \n(2) Persona que pinta casas por dentro o por fuera.', '2020-07-19 03:56:46', '2020-07-19 03:56:46', NULL, 'ACTIVE'),
(30, 'Piloto', 'Persona que pilotea aviones o aeroplanos.', '2020-07-19 03:57:12', '2020-07-19 03:57:12', NULL, 'ACTIVE'),
(31, 'Policía', 'Persona que estar encargado de velar por el mantenimiento del orden público.', '2020-07-19 03:59:42', '2020-07-19 03:59:42', NULL, 'ACTIVE'),
(32, 'Político', 'Persona que trabaja en la política.', '2020-07-19 04:00:05', '2020-07-19 04:00:05', NULL, 'ACTIVE'),
(33, 'Profesor/a', 'Persona que enseña en una escuela, instituto, universidad y entrega el conocimiento y potencia las destrezas de un estudiante.', '2020-07-19 04:00:35', '2020-07-19 04:00:35', NULL, 'ACTIVE'),
(34, 'Psiquiatra', 'Especialista que evalua, diagnostica, trata o rehabilita a las personas con trastornos mentales.', '2020-07-19 04:01:07', '2020-07-19 04:01:07', NULL, 'ACTIVE'),
(35, 'Recepcionista', 'Persona que trabaja en la recepción de una compañía, entrega información, realiza llamadas, entre otras responsabilidades.', '2020-07-19 04:02:10', '2020-07-19 04:02:10', NULL, 'ACTIVE'),
(36, 'Sastre', 'Persona que hace ropas para otros, generalmente crea diseños únicos y exclusivos.', '2020-07-19 04:02:45', '2020-07-19 04:02:45', NULL, 'ACTIVE'),
(37, 'Secretario/a', 'Persona que trabaja en una compañía escribiendo cartas, atendiendo el teléfono, organizando el horario de su jefe, etc.', '2020-07-19 04:03:12', '2020-07-19 04:03:12', NULL, 'ACTIVE'),
(38, 'Soldado', 'Persona que está en un batallón de guerra.', '2020-07-19 04:03:35', '2020-07-19 04:03:35', NULL, 'ACTIVE'),
(39, 'Taxista', 'Persona que conduce un auto y cobra una cantidad de dinero por el recorrido.', '2020-07-19 04:03:58', '2020-07-19 04:03:58', NULL, 'ACTIVE'),
(40, 'Traductor/a', 'Persona que traduce un texto o conversaciones de un lenguaje a otro sin perder la idea original.', '2020-07-19 04:20:04', '2020-07-19 04:20:04', NULL, 'ACTIVE'),
(41, 'Vendedor/a', 'Persona que trabaja en un lugar vendiendo productos o servicios.', '2020-07-19 04:20:32', '2020-07-19 04:20:32', NULL, 'ACTIVE'),
(42, 'Veterinario/a', 'Persona que atiende a los animales cuando están enfermos y les receta algún medicamento para que se sanen.', '2020-07-19 04:20:57', '2020-07-19 04:20:57', NULL, 'ACTIVE'),
(43, 'Agricultor', 'Persona que se dedica a cultivar la tierra en una explotación agraria para la extracción y explotación de los recursos que origina, tales como: alimentos vegetales como cereales, frutas, hortalizas, entre otros.', '2020-07-19 04:23:12', '2020-07-19 04:23:12', NULL, 'ACTIVE'),
(44, 'Artesano', 'Persona que realiza objetos artesanales o artesanías. Los artesanos realizan su trabajo a mano o con distintos instrumentos propios, por lo que hay que tener cierta destreza y habilidad para realizar su trabajo.', '2020-07-19 04:24:23', '2020-07-19 04:24:23', NULL, 'ACTIVE'),
(45, 'Cajero', 'Persona responsable de sumar la cantidad debida por una compra, cargar al consumidor esa cantidad y después, recoger el pago por las mercancías o servicios proporcionado.', '2020-07-19 04:25:26', '2020-07-19 04:25:26', NULL, 'ACTIVE'),
(46, 'Ingeniero/a', 'Persona que profesa la ingeniería o alguna de sus ramas.  Hace referencia a todas las profesiones de ingeniería. Por ejemplo: Ingeniero civil, en sistemas, minas y petroleo, redes, telecomunicaciones, turístico, entre otros.', '2020-07-19 04:27:52', '2020-07-25 18:13:22', NULL, 'ACTIVE'),
(47, 'Administrador', 'Persona que se ocupa de realizar la tarea administrativa por medio de la planificación, organización, dirección y control de todas las tareas dentro de un grupo social o de una organización para lograr los objetivos mediante el uso eficiente de los recursos.', '2020-07-19 04:29:20', '2020-07-19 04:29:20', NULL, 'ACTIVE'),
(48, 'Estudiante', 'Hace referencia a pacientes que se encuentren en educación primaria, educación secundaria, educación universitaria (sin egresar), cursos de profesionalizacion, tecnologias, otros.', '2020-07-25 18:01:07', '2020-07-25 18:01:07', NULL, 'ACTIVE'),
(49, 'Quehaceres domésticos', 'Persona que realiza oficios domésticos en instituciones, entidades publicas o privadas, establecimientos académicos, otros. Se refiere a un lugar distinto del propio hogar.', '2020-07-25 18:03:53', '2020-07-25 18:03:53', NULL, 'ACTIVE'),
(50, 'Ama de casa', 'Persona que se dedica netamente a desarrollar actividades dentro del hogar. Ya sea como madre de familia, esposa, hija, entre otros.', '2020-07-25 18:05:03', '2020-07-25 18:05:03', NULL, 'ACTIVE'),
(51, 'Técnico de sonido', 'Personas que trabajan en estudios de grabación. Preparan el equipo para hacer grabaciones musicales, equipos para cubrir una actuación u eventos. Entre otras funciones.', '2020-07-25 18:18:36', '2020-07-25 18:18:36', NULL, 'ACTIVE'),
(52, 'Psicólogo', 'Persona que busca orientar a sus pacientes en sesiones grupales o individuales, con la finalidad de evaluar sus problemas y ayudarles a lidiar con diferentes circunstancias y conflictos, mejorando su salud mental. Entre otras funciones.', '2020-07-25 18:19:57', '2020-07-25 18:19:57', NULL, 'ACTIVE'),
(53, 'Músico', 'Persona que se dedica a la composición, interpretación o edición de la música.', '2020-07-25 18:21:19', '2020-07-25 18:21:19', NULL, 'ACTIVE'),
(54, 'Economista', 'Persona capaz de realizar tablas, gráficos e informes que ilustren de forma clara la realidad que atraviesa la economía de la entidad para la que cumplen funciones, de tal forma que analiza los datos una entidad o de algunas y las compara estadisticamente.', '2020-07-25 18:24:40', '2020-07-25 18:24:40', NULL, 'ACTIVE'),
(55, 'Catedrático Universitario', 'Docente superior que ejerce funciones en universidades o instituciones. Además, se puede considerar a personas que forman parte de las autoridades académicas de una institución.', '2020-07-25 18:26:32', '2020-07-25 18:26:32', NULL, 'ACTIVE'),
(56, 'Comerciante', 'Persona que realiza actividades comerciales en las cuales se realiza la acción de comprar y vender.', '2020-07-26 23:20:08', '2020-07-30 22:44:38', NULL, 'ACTIVE'),
(57, 'Sociologo/a', 'Persona que se dedica a analizar la estructura de la sociedad y sus problemas, ademas de entender los comportamientos que se dan entre los grupos de personas.', '2020-07-26 23:20:08', '2020-07-30 23:00:01', NULL, 'ACTIVE'),
(58, 'Oficinista', 'Persona que realiza funciones administrativas u operativas dentro de una empresa o institución, ya sea pública o privada.', '2020-07-26 23:20:08', '2020-07-30 22:53:34', NULL, 'ACTIVE'),
(59, 'Artista', 'Persona que hace o practica arte, ya sea por talento innato o profesionalmente.', '2020-07-26 23:20:08', '2020-07-30 22:41:52', NULL, 'ACTIVE'),
(60, 'Bibliotecario/a', 'Persona que trabaja en una biblioteca manteniendo el orden de los libros, vídeos, discos, etc.', NULL, '2020-07-19 03:31:07', NULL, 'ACTIVE'),
(61, 'Odontólogo/a', 'Profesional encargado de la salud oral.', '2020-07-30 22:38:53', '2020-07-30 22:38:53', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people_relationship`
--

DROP TABLE IF EXISTS `people_relationship`;
CREATE TABLE IF NOT EXISTS `people_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people_relationship`
--

INSERT INTO `people_relationship` (`id`, `name`, `description`, `status`) VALUES
(1, 'Padre', 'DESCRIPCION', 'ACTIVE'),
(2, 'Madre', 'DESCRIPCION', 'ACTIVE'),
(3, 'Tio', 'DESCRIPCION', 'ACTIVE'),
(4, 'Tia', 'DESCRIPCION', 'ACTIVE'),
(5, 'Abuelo Paterno', 'DESCRIPCION', 'ACTIVE'),
(6, 'Abuela Paterna', 'DESCRIPCION', 'ACTIVE'),
(7, 'Hermano', 'DESCRIPCION', 'ACTIVE'),
(8, 'Hermana', 'DESCRIPCION', 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people_type_identification`
--

DROP TABLE IF EXISTS `people_type_identification`;
CREATE TABLE IF NOT EXISTS `people_type_identification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `code` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `people_type_identification`
--

INSERT INTO `people_type_identification` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `code`) VALUES
(1, 'RUC', 'ada', '2019-10-26 18:19:10', '2019-10-28 09:48:48', NULL, 'ACTIVE', 'R'),
(2, 'CEDULA', 'Codigo', '2019-10-26 18:19:11', '2019-10-28 09:48:17', NULL, 'ACTIVE', 'C'),
(3, 'OTROS', '', '2019-10-27 11:56:31', '2019-10-28 09:48:30', NULL, 'ACTIVE', '-'),
(4, 'PASAPORTE', '', '2019-10-27 11:56:39', '2019-10-28 09:48:36', NULL, 'ACTIVE', 'P'),
(5, 'CONSUMIDOR FINAL', '', '2019-10-27 11:56:47', '2019-10-28 09:48:23', NULL, 'INACTIVE', 'F'),
(6, 'PLACA-RAMV/CPN', '', '2019-10-27 11:56:57', '2019-10-28 09:48:42', NULL, 'INACTIVE', 'PL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prices_by_zones`
--

DROP TABLE IF EXISTS `prices_by_zones`;
CREATE TABLE IF NOT EXISTS `prices_by_zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,4) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_price_by_zone_zones1_idx` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `name` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_trademark_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_subcategory_id` int(11) NOT NULL,
  `source` varchar(250) DEFAULT NULL,
  `description` text,
  `code_provider` varchar(80) DEFAULT NULL,
  `code_product` varchar(80) DEFAULT NULL,
  `has_tax` int(11) NOT NULL DEFAULT '0',
  `is_service` int(11) NOT NULL COMMENT '0=product\n1=service\n2=expense',
  `user_id` int(11) NOT NULL,
  `product_measure_type_id` int(11) NOT NULL,
  `view_online` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT VIEW\n1=VIEW ONLINE',
  PRIMARY KEY (`id`),
  KEY `fk_product_product_trademark1_idx` (`product_trademark_id`),
  KEY `fk_product_product_category1_idx` (`product_category_id`),
  KEY `fk_product_product_subcategory1_idx` (`product_subcategory_id`),
  KEY `fk_product_product_measure_type1_idx` (`product_measure_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_aplication`
--

DROP TABLE IF EXISTS `product_aplication`;
CREATE TABLE IF NOT EXISTS `product_aplication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_aplication`
--

DROP TABLE IF EXISTS `product_by_aplication`;
CREATE TABLE IF NOT EXISTS `product_by_aplication` (
  `product_id` int(11) NOT NULL,
  `product_aplication_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`product_aplication_id`),
  KEY `fk_product_by_aplication_product_aplication1_idx` (`product_aplication_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_color`
--

DROP TABLE IF EXISTS `product_by_color`;
CREATE TABLE IF NOT EXISTS `product_by_color` (
  `product_id` int(11) NOT NULL,
  `product_color_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`product_color_id`),
  KEY `fk_product_by_color_product_color1_idx` (`product_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_details`
--

DROP TABLE IF EXISTS `product_by_details`;
CREATE TABLE IF NOT EXISTS `product_by_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `location_details` text,
  `stock_control` int(11) NOT NULL,
  `ice_control` int(11) NOT NULL,
  `initial_stock_control` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_details_product1_idx` (`product_id`),
  KEY `fk_product_by_details_tax1_idx` (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_discount`
--

DROP TABLE IF EXISTS `product_by_discount`;
CREATE TABLE IF NOT EXISTS `product_by_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` float NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_discount_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_ice`
--

DROP TABLE IF EXISTS `product_by_ice`;
CREATE TABLE IF NOT EXISTS `product_by_ice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_ice_id` int(11) NOT NULL,
  `value` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_ice_product1_idx` (`product_id`),
  KEY `fk_product_by_ice_product_ice1_idx` (`product_ice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_multimedia`
--

DROP TABLE IF EXISTS `product_by_multimedia`;
CREATE TABLE IF NOT EXISTS `product_by_multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `subtitle` varchar(45) DEFAULT NULL,
  `description` text,
  `type` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `source` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_multimedia_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_route_map`
--

DROP TABLE IF EXISTS `product_by_route_map`;
CREATE TABLE IF NOT EXISTS `product_by_route_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `routes_map_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_route_product1_idx` (`product_id`),
  KEY `fk_product_by_route_routes_map1_idx` (`routes_map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_sizes`
--

DROP TABLE IF EXISTS `product_by_sizes`;
CREATE TABLE IF NOT EXISTS `product_by_sizes` (
  `product_sizes_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_sizes_id`,`product_id`),
  KEY `fk_product_by_sizes_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_by_stock`
--

DROP TABLE IF EXISTS `product_by_stock`;
CREATE TABLE IF NOT EXISTS `product_by_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_stock_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `subtitle` varchar(250) DEFAULT NULL,
  `source` varchar(250) DEFAULT NULL,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_category`
--

INSERT INTO `product_category` (`id`, `value`, `state`, `description`, `subtitle`, `source`, `business_id`) VALUES
(1, 'Sin definir', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/sindefinir.jpg', 0),
(2, 'Software', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/software.jpg', 0),
(3, 'Diseño', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/disenio.jpg', 0),
(4, 'Multimedia', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/multimedia.jpg', 0),
(5, 'Hoteleria', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/hoteleria.png', 0),
(6, 'Tecnologia', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/tecnologia.png', 0),
(7, 'Hardware', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/hardware.png', 0),
(8, 'Ocio', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/ocio.jpg', 0),
(9, 'Comida', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/comida.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_color`
--

DROP TABLE IF EXISTS `product_color`;
CREATE TABLE IF NOT EXISTS `product_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `multicolored` int(11) NOT NULL,
  `color` varchar(45) NOT NULL,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_color`
--

INSERT INTO `product_color` (`id`, `value`, `state`, `description`, `multicolored`, `color`, `business_id`) VALUES
(1, 'Morado', 'ACTIVE', NULL, 0, '#5508C0', 0),
(2, 'Amarillo', 'ACTIVE', NULL, 0, '#E3ED0F', 0),
(3, 'Negro', 'ACTIVE', NULL, 0, '#000000', 0),
(4, 'Azul', 'ACTIVE', NULL, 0, '#1811F1', 0),
(5, 'Tomate', 'ACTIVE', NULL, 0, '#B85807', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_defect`
--

DROP TABLE IF EXISTS `product_defect`;
CREATE TABLE IF NOT EXISTS `product_defect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_details_shipping_fee`
--

DROP TABLE IF EXISTS `product_details_shipping_fee`;
CREATE TABLE IF NOT EXISTS `product_details_shipping_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `height` float NOT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `weight` float NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_details_shipping_fee_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_ice`
--

DROP TABLE IF EXISTS `product_ice`;
CREATE TABLE IF NOT EXISTS `product_ice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `product_ice_types_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_ice_product_ice_types1_idx` (`product_ice_types_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_ice_types`
--

DROP TABLE IF EXISTS `product_ice_types`;
CREATE TABLE IF NOT EXISTS `product_ice_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_inventory`
--

DROP TABLE IF EXISTS `product_inventory`;
CREATE TABLE IF NOT EXISTS `product_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `avarage_kardex_value` decimal(10,4) DEFAULT NULL,
  `tax` enum('SI','NO') DEFAULT 'NO',
  `quantity_units` decimal(10,4) DEFAULT NULL,
  `sale_price` decimal(10,4) NOT NULL,
  `total_price` decimal(10,4) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `profit` float NOT NULL,
  `profit_type` tinyint(1) NOT NULL,
  `note` text,
  `sale_price2` decimal(10,4) NOT NULL,
  `sale_price3` decimal(10,4) NOT NULL,
  `sale_price4` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_inventory_product1_idx` (`product_id`),
  KEY `fk_product_inventory_tax1_idx` (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_inventory_by_prices`
--

DROP TABLE IF EXISTS `product_inventory_by_prices`;
CREATE TABLE IF NOT EXISTS `product_inventory_by_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_inventory_id` int(11) NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `priority` int(11) NOT NULL,
  `utility` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_inventory_by_prices_product_inventory1_idx` (`product_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_inventory_by_price_unity_box`
--

DROP TABLE IF EXISTS `product_inventory_by_price_unity_box`;
CREATE TABLE IF NOT EXISTS `product_inventory_by_price_unity_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,4) NOT NULL,
  `product_inventory_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `utility` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_unity_inventory_product_inventory1_idx` (`product_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_inventory_by_unity`
--

DROP TABLE IF EXISTS `product_inventory_by_unity`;
CREATE TABLE IF NOT EXISTS `product_inventory_by_unity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `units` int(11) NOT NULL,
  `product_inventory_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_by_unity_inventory_product_inventory1_idx` (`product_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_measurement_subtype`
--

DROP TABLE IF EXISTS `product_measurement_subtype`;
CREATE TABLE IF NOT EXISTS `product_measurement_subtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `symbol` varchar(10) NOT NULL,
  `prefix` varchar(10) NOT NULL,
  `has_equivalence` tinyint(4) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_measure_by_subtype`
--

DROP TABLE IF EXISTS `product_measure_by_subtype`;
CREATE TABLE IF NOT EXISTS `product_measure_by_subtype` (
  `product_measure_type_id` int(11) NOT NULL,
  `product_measurement_subtype_id` int(11) NOT NULL,
  PRIMARY KEY (`product_measure_type_id`,`product_measurement_subtype_id`),
  KEY `fk_product_measure_by_subtype_product_measurement_subtype1_idx` (`product_measurement_subtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_measure_type`
--

DROP TABLE IF EXISTS `product_measure_type`;
CREATE TABLE IF NOT EXISTS `product_measure_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `abbreviation` varchar(100) DEFAULT NULL,
  `unit` tinyint(4) DEFAULT NULL,
  `number_of_units` float DEFAULT NULL,
  `prefix` varchar(10) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_measure_type`
--

INSERT INTO `product_measure_type` (`id`, `value`, `state`, `description`, `abbreviation`, `unit`, `number_of_units`, `prefix`, `symbol`, `business_id`) VALUES
(1, 'Sin Definir', 'ACTIVE', 'SDF', 'SDF', 0, 1, 'U', 'U', 0),
(2, 'UNIDAD', 'ACTIVE', 'uNIDAD', 'U', 0, 1, 'U', 'U', 0),
(3, 'Docena', 'ACTIVE', NULL, 'Doce', 1, 12, 'DOC', 'DOC', 0),
(4, 'PAR', 'ACTIVE', 'AD', 'PAR', 1, 2, 'PAR', 'PAR', 0),
(5, 'Metro', 'ACTIVE', NULL, 'm', 0, 1, 'm', 'm', 0),
(6, 'Libra', 'ACTIVE', NULL, 'lb', 0, 1, 'lb', 'lb', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_sizes`
--

DROP TABLE IF EXISTS `product_sizes`;
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `value`, `state`, `description`, `business_id`) VALUES
(1, 'XL', 'ACTIVE', 'XL', 0),
(2, 'XXL', 'ACTIVE', NULL, 0),
(3, 'L', 'ACTIVE', NULL, 0),
(4, 'XS', 'ACTIVE', NULL, 0),
(5, 'M', 'ACTIVE', NULL, 0),
(6, 'S', 'ACTIVE', NULL, 0),
(7, 'XXS', 'ACTIVE', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_subcategory`
--

DROP TABLE IF EXISTS `product_subcategory`;
CREATE TABLE IF NOT EXISTS `product_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `source` varchar(250) DEFAULT NULL,
  `subtitle` varchar(250) DEFAULT NULL,
  `product_category_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_product_subcategory_product_category1_idx` (`product_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_subcategory`
--
INSERT INTO `product_subcategory` (`id`, `value`, `state`, `description`, `source`, `subtitle`, `product_category_id`, `business_id`) VALUES
                                                                                                                                          (1, 'Sin definir', 'ACTIVE', 'null', '/uploads/products/productSubcategory/sindefinir.jpg', 'null', 1, 1),
                                                                                                                                          (2, 'Artes', 'ACTIVE', 'null', '/uploads/products/productSubcategory/artes.jpg', 'null', 2, 1),
                                                                                                                                          (3, 'Tecnologia', 'ACTIVE', 'null', '/uploads/products/productSubcategory/tecnologia.jpg', 'null', 7, 1),
                                                                                                                                          (4, 'Videos', 'ACTIVE', 'null', '/uploads/products/productSubcategory/videos.jpg', 'null', 3, 1),
                                                                                                                                          (5, 'Sistemas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/sistemas.jpg', 'null', 1, 1),
                                                                                                                                          (6, 'Aplicaciones Moviles', 'ACTIVE', 'null', '/uploads/products/productSubcategory/aplicacionesmoviles.png', 'null', 7, 1),
                                                                                                                                          (7, 'Hospedaje', 'ACTIVE', 'null', '/uploads/products/productSubcategory/hospedaje.png', 'null', 5, 1),
                                                                                                                                          (8, 'Atracciones Deportivas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/atracionesdeportivas.jpg', 'null', 8, 1),
                                                                                                                                          (9, 'Asados', 'ACTIVE', 'null', '/uploads/products/productSubcategory/asados.jpg', 'null', 9,1);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_trademark`
--

DROP TABLE IF EXISTS `product_trademark`;
CREATE TABLE IF NOT EXISTS `product_trademark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `business_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_trademark`
--

INSERT INTO `product_trademark` (`id`, `value`, `state`, `description`, `business_id`) VALUES
(1, 'Propia', 'ACTIVE', NULL, 0),
(2, 'La Favorita', 'ACTIVE', NULL, 0),
(3, 'ASUS', 'ACTIVE', NULL, 0),
(4, 'ACER', 'ACTIVE', NULL, 0),
(5, 'COMPAC', 'ACTIVE', NULL, 0),
(6, 'MAC', 'ACTIVE', NULL, 0),
(7, 'TOSHIBA', 'ACTIVE', NULL, 0),
(8, 'SONY VAIO', 'ACTIVE', NULL, 0),
(9, 'MSI', 'ACTIVE', NULL, 0),
(10, 'DELL', 'ACTIVE', NULL, 0),
(11, 'LG', 'ACTIVE', NULL, 0),
(12, 'HP', 'ACTIVE', NULL, 0),
(13, 'IBM', 'ACTIVE', NULL, 0),
(14, 'SONY', 'ACTIVE', NULL, 0),
(15, 'LENOVO', 'ACTIVE', NULL, 0),
(16, 'COMPAC', 'ACTIVE', NULL, 0),
(17, 'ALCATEL', 'ACTIVE', NULL, 0),
(18, 'NOKIA', 'ACTIVE', NULL, 0),
(19, 'HUAWEI', 'ACTIVE', NULL, 0),
(20, 'PHILIPS', 'ACTIVE', NULL, 0),
(21, 'SAMSUNG', 'ACTIVE', NULL, 0),
(22, 'MOTOROLA', 'ACTIVE', NULL, 0),
(23, 'XPERIA', 'ACTIVE', NULL, 0),
(24, 'GALAXY', 'ACTIVE', NULL, 0),
(25, 'SM', 'ACTIVE', NULL, 0),
(26, 'Otras', 'ACTIVE', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `place_id` varchar(200) DEFAULT 'none-id',
  PRIMARY KEY (`id`),
  KEY `fk_provinces_countries_idx` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `country_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`) VALUES
(1, 'Galapagos', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(2, 'Esmeraldas', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(3, 'Manabí ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(4, 'Los Ríos', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(5, 'Santa Elena', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(6, 'Guayas ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(7, 'Santo Domingo de los Tsáchilas ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(8, 'El Oro', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(9, 'Azuay ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(10, 'Bolívar ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(11, 'Cañar ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(12, 'Carchi', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(13, 'Cotopaxi', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(14, 'Chimborazo', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(15, 'Imbabura ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(16, 'Loja', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(17, 'Pichincha ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(18, 'Tungurahua', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(19, 'Morona Santiago ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(20, 'Napo ', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(21, 'Orellana', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(22, 'Pastaza', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(23, 'Sucumbíos', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(24, 'Zamora Chinchipe', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
(25, 'Amazonas', 48, 'ACTIVE', '2020-07-27 01:20:14', '2020-07-27 01:20:14', NULL, 'none-id'),
(26, 'Antioquia', 48, 'ACTIVE', '2020-07-27 01:20:39', '2020-07-27 01:20:39', NULL, 'none-id'),
(27, 'Arauca', 48, 'ACTIVE', '2020-07-27 01:20:56', '2020-07-27 01:20:56', NULL, 'none-id'),
(28, 'Atlántico', 48, 'ACTIVE', '2020-07-27 01:21:19', '2020-07-27 01:21:19', NULL, 'none-id'),
(29, 'Bogotá', 48, 'ACTIVE', '2020-07-27 01:21:38', '2020-07-27 01:21:38', NULL, 'none-id'),
(30, 'Bolivar Co', 48, 'ACTIVE', '2020-07-27 01:22:42', '2020-07-27 01:22:42', NULL, 'none-id'),
(31, 'Boyacá', 48, 'ACTIVE', '2020-07-27 01:23:03', '2020-07-27 01:23:03', NULL, 'none-id'),
(32, 'Caldas', 48, 'ACTIVE', '2020-07-27 01:23:24', '2020-07-27 01:23:24', NULL, 'none-id'),
(33, 'Caquetá', 48, 'ACTIVE', '2020-07-27 01:23:44', '2020-07-27 01:23:44', NULL, 'none-id'),
(34, 'Casanare', 48, 'ACTIVE', '2020-07-27 01:24:01', '2020-07-27 01:24:01', NULL, 'none-id'),
(35, 'Cauca', 48, 'ACTIVE', '2020-07-27 01:24:16', '2020-07-27 01:24:16', NULL, 'none-id'),
(36, 'Cesar', 48, 'ACTIVE', '2020-07-27 01:24:32', '2020-07-27 01:24:32', NULL, 'none-id'),
(37, 'Chocó', 48, 'ACTIVE', '2020-07-27 01:24:44', '2020-07-27 01:24:44', NULL, 'none-id'),
(38, 'Córdoba', 48, 'ACTIVE', '2020-07-27 01:25:04', '2020-07-27 01:25:04', NULL, 'none-id'),
(39, 'Cundinamarca', 48, 'ACTIVE', '2020-07-27 01:25:21', '2020-07-27 01:25:21', NULL, 'none-id'),
(40, 'Guainía', 48, 'ACTIVE', '2020-07-27 01:25:39', '2020-07-27 01:25:39', NULL, 'none-id'),
(41, 'Guaviare', 48, 'ACTIVE', '2020-07-27 01:27:29', '2020-07-27 01:27:29', NULL, 'none-id'),
(42, 'Huila', 48, 'ACTIVE', '2020-07-27 01:27:45', '2020-07-27 01:27:45', NULL, 'none-id'),
(43, 'La Guajira', 48, 'ACTIVE', '2020-07-27 01:28:00', '2020-07-27 01:28:00', NULL, 'none-id'),
(44, 'Magdalena', 48, 'ACTIVE', '2020-07-27 01:28:16', '2020-07-27 01:28:16', NULL, 'none-id'),
(45, 'Meta', 48, 'ACTIVE', '2020-07-27 01:28:31', '2020-07-27 01:28:31', NULL, 'none-id'),
(46, 'Nariño', 48, 'ACTIVE', '2020-07-27 01:28:45', '2020-07-27 01:28:45', NULL, 'none-id'),
(47, 'Norte de Santander', 48, 'ACTIVE', '2020-07-27 01:29:02', '2020-07-27 01:29:02', NULL, 'none-id'),
(48, 'Putumayo', 48, 'ACTIVE', '2020-07-27 01:29:15', '2020-07-27 01:29:15', NULL, 'none-id'),
(49, 'Quindío', 48, 'ACTIVE', '2020-07-27 01:29:31', '2020-07-27 01:29:31', NULL, 'none-id'),
(50, 'Risaralda', 48, 'ACTIVE', '2020-07-27 01:29:57', '2020-07-27 01:29:57', NULL, 'none-id'),
(51, 'San Andrés y Providencia', 48, 'ACTIVE', '2020-07-27 01:30:12', '2020-07-27 01:30:12', NULL, 'none-id'),
(52, 'Santander', 48, 'ACTIVE', '2020-07-27 01:30:27', '2020-07-27 01:30:27', NULL, 'none-id'),
(53, 'Sucre', 48, 'ACTIVE', '2020-07-27 01:30:43', '2020-07-27 01:30:43', NULL, 'none-id'),
(54, 'Tolima', 48, 'ACTIVE', '2020-07-27 01:30:58', '2020-07-27 01:30:58', NULL, 'none-id'),
(55, 'Valle del Cauca', 48, 'ACTIVE', '2020-07-27 01:31:16', '2020-07-27 01:31:16', NULL, 'none-id'),
(56, 'Vaupés', 48, 'ACTIVE', '2020-07-27 01:31:32', '2020-07-27 01:31:32', NULL, 'none-id'),
(57, 'Vichada', 48, 'ACTIVE', '2020-07-27 01:31:48', '2020-07-27 01:31:48', NULL, 'none-id');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reference_piece`
--

DROP TABLE IF EXISTS `reference_piece`;
CREATE TABLE IF NOT EXISTS `reference_piece` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `type` enum('INDIVIDUAL','COMPLETE') NOT NULL DEFAULT 'INDIVIDUAL',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `reference_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reference_piece`
--

INSERT INTO `reference_piece` (`id`, `name`, `type`, `status`, `reference_type_id`) VALUES
(1, 'Sin detalles', 'INDIVIDUAL', 'ACTIVE', 1),
(2, 'En Observacion', 'INDIVIDUAL', 'ACTIVE', 1),
(3, 'Ausente', 'COMPLETE', 'INACTIVE', 2),
(4, 'Remanente radicular', 'INDIVIDUAL', 'ACTIVE', 1),
(5, 'Caries', 'COMPLETE', 'ACTIVE', 1),
(6, 'Edentulo', 'INDIVIDUAL', 'ACTIVE', 1),
(7, 'Incrustacion', 'INDIVIDUAL', 'ACTIVE', 1),
(8, 'Obturacion', 'INDIVIDUAL', 'ACTIVE', 1),
(9, 'Intrusion', 'INDIVIDUAL', 'ACTIVE', 1),
(10, 'Extrusion', 'INDIVIDUAL', 'ACTIVE', 1),
(11, 'Protesis Removible', 'COMPLETE', 'ACTIVE', 2),
(12, 'Implante', 'COMPLETE', 'ACTIVE', 2),
(13, 'Ortodoncia', 'INDIVIDUAL', 'ACTIVE', 1),
(14, 'Clavija', 'INDIVIDUAL', 'ACTIVE', 1),
(15, 'Amalgama', 'INDIVIDUAL', 'ACTIVE', 1),
(16, 'Endodoncia', 'COMPLETE', 'ACTIVE', 2),
(17, 'Otro', 'INDIVIDUAL', 'ACTIVE', 3),
(18, 'No Erupcionada', 'COMPLETE', 'INACTIVE', 1),
(19, 'Corona', 'COMPLETE', 'ACTIVE', 2),
(20, 'Corona a realizar', 'COMPLETE', 'ACTIVE', 3),
(21, 'Corona realizada', 'COMPLETE', 'ACTIVE', 4),
(22, 'A extraer', 'COMPLETE', 'INACTIVE', 2),
(23, 'Extraida', 'COMPLETE', 'INACTIVE', 1),
(24, 'Fractura', 'COMPLETE', 'ACTIVE', 1),
(25, 'Infeccion Pulpar', 'COMPLETE', 'ACTIVE', 1),
(26, 'Movilidad', 'COMPLETE', 'ACTIVE', 1),
(27, 'Residuo Radicular', 'COMPLETE', 'ACTIVE', 1),
(28, 'Otro', 'COMPLETE', 'ACTIVE', 2),
(29, 'Restauracion', 'COMPLETE', 'ACTIVE', 2),
(30, 'Perno Muñon', 'COMPLETE', 'ACTIVE', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reference_piece_position`
--

DROP TABLE IF EXISTS `reference_piece_position`;
CREATE TABLE IF NOT EXISTS `reference_piece_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` enum('TOP','DOWN','RIGHT','LEFT','CENTER','COMPLETE') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reference_piece_position`
--

INSERT INTO `reference_piece_position` (`id`, `position`) VALUES
(1, 'TOP'),
(2, 'DOWN'),
(3, 'RIGHT'),
(4, 'LEFT'),
(5, 'CENTER'),
(6, 'COMPLETE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reference_piece_type`
--

DROP TABLE IF EXISTS `reference_piece_type`;
CREATE TABLE IF NOT EXISTS `reference_piece_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(15) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `name` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reference_piece_type`
--

INSERT INTO `reference_piece_type` (`id`, `color`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `name`) VALUES
(1, '#0b0a0a', NULL, '2018-09-11 22:49:22', '2018-09-11 22:49:22', NULL, 'ACTIVE', 'Lesion'),
(2, '#247b1f', NULL, '2018-09-11 22:49:44', '2018-09-12 00:37:34', NULL, 'ACTIVE', 'Pre Existencias'),
(3, '#f81111', NULL, '2018-09-11 22:50:28', '2018-09-11 22:50:28', NULL, 'ACTIVE', 'Por Hacer'),
(4, '#1ec1fb', 'ag', '2018-09-11 22:51:15', '2018-09-14 08:43:19', NULL, 'ACTIVE', 'Hecho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repair`
--

DROP TABLE IF EXISTS `repair`;
CREATE TABLE IF NOT EXISTS `repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `register_manager_date` datetime NOT NULL,
  `description` text NOT NULL,
  `customer_id` int(11) NOT NULL,
  `value_taxes` decimal(10,4) NOT NULL,
  `subtotal` decimal(10,4) NOT NULL,
  `discount_value` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `user_id` int(11) NOT NULL,
  `observations_fix` text,
  `status` enum('IN OBSERVATION','INITIATED','FINISHED','CANCELLED') NOT NULL DEFAULT 'IN OBSERVATION',
  `advance` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(10,4) NOT NULL,
  `delivery_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repair_by_details_parts`
--

DROP TABLE IF EXISTS `repair_by_details_parts`;
CREATE TABLE IF NOT EXISTS `repair_by_details_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repair_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_color_id` int(11) NOT NULL,
  `repair_product_by_business_id` int(11) NOT NULL,
  `product_trademark_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_repair_by_details_parts_repair1_idx` (`repair_id`),
  KEY `fk_repair_by_details_parts_product_color1_idx` (`product_color_id`),
  KEY `fk_repair_by_details_parts_repair_product_by_business1_idx` (`repair_product_by_business_id`),
  KEY `fk_repair_by_details_parts_product_trademark1_idx` (`product_trademark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repair_product_by_business`
--

DROP TABLE IF EXISTS `repair_product_by_business`;
CREATE TABLE IF NOT EXISTS `repair_product_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `description` text,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_repair_product_by_business_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repair_product_by_color`
--

DROP TABLE IF EXISTS `repair_product_by_color`;
CREATE TABLE IF NOT EXISTS `repair_product_by_color` (
  `repair_by_details_parts_id` int(11) NOT NULL,
  `product_color_id` int(11) NOT NULL,
  PRIMARY KEY (`repair_by_details_parts_id`,`product_color_id`),
  KEY `fk_repair_product_by_color_product_color1_idx` (`product_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retention_tax_sub_type`
--

DROP TABLE IF EXISTS `retention_tax_sub_type`;
CREATE TABLE IF NOT EXISTS `retention_tax_sub_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `type` int(11) NOT NULL COMMENT '0=IVA \n1=RENTA',
  `retention_tax_type_id` int(11) NOT NULL,
  `percentage` float NOT NULL,
  `accounting_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_retention_tax_sub_type_retention_tax_type1_idx` (`retention_tax_type_id`),
  KEY `fk_retention_tax_sub_type_accounting_account1_idx` (`accounting_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retention_tax_type`
--

DROP TABLE IF EXISTS `retention_tax_type`;
CREATE TABLE IF NOT EXISTS `retention_tax_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `type` int(11) NOT NULL COMMENT '0=IVA \n1=RENTA',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GOD', 'ACTIVE', NULL, NULL),
(2, 'BUSINESS', 'ACTIVE', '2020-06-14 18:50:42', '2020-06-14 18:50:42'),
(3, 'EMPLOYER', 'ACTIVE', '2020-06-14 19:08:45', '2020-06-14 22:10:21'),
(4, 'CUSTOMER', 'ACTIVE', '2020-06-14 19:17:10', '2020-06-14 19:17:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routes_drawing`
--

DROP TABLE IF EXISTS `routes_drawing`;
CREATE TABLE IF NOT EXISTS `routes_drawing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '0=marker ,singular\n1=polygon,singular\n2=rectangle,singular\n3=circle,singular\n4=polyline,many',
  `name` varchar(150) NOT NULL,
  `description` text,
  `options_type` longtext NOT NULL COMMENT 'coordinates,styles',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routes_map`
--

DROP TABLE IF EXISTS `routes_map`;
CREATE TABLE IF NOT EXISTS `routes_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `options_map` text NOT NULL,
  `src` varchar(250) NOT NULL DEFAULT 'nothing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routes_map_by_routes_drawing`
--

DROP TABLE IF EXISTS `routes_map_by_routes_drawing`;
CREATE TABLE IF NOT EXISTS `routes_map_by_routes_drawing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `routes_map_id` int(11) NOT NULL,
  `routes_drawing_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_routes_map_by_drawing_routes_map1_idx` (`routes_map_id`),
  KEY `fk_routes_map_by_drawing_routes_drawing1_idx` (`routes_drawing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `route_map_by_adventure_types`
--

DROP TABLE IF EXISTS `route_map_by_adventure_types`;
CREATE TABLE IF NOT EXISTS `route_map_by_adventure_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_by_routes_map_id` int(11) NOT NULL,
  `adventure_type` int(11) NOT NULL COMMENT '0=Apnea (deporte)\n1=cicloturismo\n2=bungee o puenting\n3=rafting\n4=cabalgata\n5=montañismo o andinismo\n6=senderismo\n7=Ciclismo de montaña\n8=escalada\n9=canopy\n10=tirolesas\n11=overlanding\n12=rápel\n13=vías ferratas\n14=barranquismo\n15=parapente',
  PRIMARY KEY (`id`),
  KEY `fk_route_by_adventure_types_business_by_routes_map1_idx` (`business_by_routes_map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruc_type`
--

DROP TABLE IF EXISTS `ruc_type`;
CREATE TABLE IF NOT EXISTS `ruc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ruc_type`
--

INSERT INTO `ruc_type` (`id`, `name`, `description`) VALUES
(1, 'Persona Natural', 'Persona Natural'),
(2, 'Sociedad Privada', 'Sociedad Privada'),
(3, 'Sociedad Publica', 'Sociedad Publica'),
(4, 'Ninguno', 'Ningunos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_days_category`
--

DROP TABLE IF EXISTS `schedule_days_category`;
CREATE TABLE IF NOT EXISTS `schedule_days_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `weight_day` int(11) NOT NULL COMMENT 'MONDAY=0\nTUESDAY=1\nWEDNESDAY=2\nTHURSDAY=3\nFRIDAY=4\nSATURDAY=5\nSUNDAY=6',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `schedule_days_category`
--

INSERT INTO `schedule_days_category` (`id`, `name`, `weight_day`, `description`) VALUES
(1, 'Lunes', 0, NULL),
(2, 'Martes', 1, NULL),
(3, 'Miercoles', 2, NULL),
(4, 'Jueves', 3, NULL),
(5, 'Viernes', 4, NULL),
(6, 'Sabado', 5, NULL),
(7, 'Domingo', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scheduling_date`
--

DROP TABLE IF EXISTS `scheduling_date`;
CREATE TABLE IF NOT EXISTS `scheduling_date` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text,
  `options` text COMMENT '1)constraint:\n businessHours,availableForMeeting\n2)color\n3)rendering\n4)overlap\n5)url',
  `start` datetime NOT NULL,
  `type_start` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT FRACTION DATE\n1=YES FRACTION DATE',
  `end` datetime DEFAULT NULL,
  `state` enum('ACTIVE','INACTIVE','CANCELLED','FINISHED') NOT NULL DEFAULT 'ACTIVE',
  `type_end` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT FRACTION DATE\n1=YES FRACTION DATE',
  `type_scheduling` int(11) NOT NULL DEFAULT '0' COMMENT '0=only start\n1=only start and end\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_rate_business`
--

DROP TABLE IF EXISTS `shipping_rate_business`;
CREATE TABLE IF NOT EXISTS `shipping_rate_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `shipping_rate_business`
--

INSERT INTO `shipping_rate_business` (`id`, `title`, `description`, `state`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Servientrega', NULL, 'ACTIVE', NULL, NULL, NULL),
(2, 'DHL', NULL, 'ACTIVE', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_rate_business_by_conversion_factor`
--

DROP TABLE IF EXISTS `shipping_rate_business_by_conversion_factor`;
CREATE TABLE IF NOT EXISTS `shipping_rate_business_by_conversion_factor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_rate_services_id` int(11) NOT NULL,
  `shipping_rate_kinds_of_way_id` int(11) NOT NULL,
  `product_measure_type_id` int(11) NOT NULL,
  `shipping_rate_business_id` int(11) NOT NULL,
  `type_local` int(11) NOT NULL COMMENT '0=OWNER COUNTRY\n1=OUT COUNTRY',
  `value_factor` float NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `fk_shipping_rate_by_conversion_factor_shipping_rate_service_idx` (`shipping_rate_services_id`),
  KEY `fk_shipping_rate_by_conversion_factor_shipping_rate_kinds_o_idx` (`shipping_rate_kinds_of_way_id`),
  KEY `fk_shipping_rate_by_conversion_factor_product_measure_type1_idx` (`product_measure_type_id`),
  KEY `fk_shipping_rate_business_by_conversion_factor_shipping_rat_idx` (`shipping_rate_business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_rate_business_by_min_weight`
--

DROP TABLE IF EXISTS `shipping_rate_business_by_min_weight`;
CREATE TABLE IF NOT EXISTS `shipping_rate_business_by_min_weight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_rate_business_id` int(11) NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shipping_rate_business_by_min_weight_shipping_rate_busin_idx` (`shipping_rate_business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_rate_kinds_of_way`
--

DROP TABLE IF EXISTS `shipping_rate_kinds_of_way`;
CREATE TABLE IF NOT EXISTS `shipping_rate_kinds_of_way` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `shipping_rate_kinds_of_way`
--

INSERT INTO `shipping_rate_kinds_of_way` (`id`, `value`, `description`, `state`) VALUES
(1, 'Aereo', 'hola', 'ACTIVE'),
(2, 'Terrestre', NULL, 'ACTIVE'),
(3, 'Maritimo', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_rate_services`
--

DROP TABLE IF EXISTS `shipping_rate_services`;
CREATE TABLE IF NOT EXISTS `shipping_rate_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL COMMENT 'aereo\nterrestro\nmaritimo\n',
  `description` text,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `shipping_rate_business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shipping_rate_services_shipping_rate_business1_idx` (`shipping_rate_business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `shipping_rate_services`
--

INSERT INTO `shipping_rate_services` (`id`, `value`, `description`, `state`, `shipping_rate_business_id`) VALUES
(3, 'Servicio Express', 'adad', 'ACTIVE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_by_business`
--

DROP TABLE IF EXISTS `students_by_business`;
CREATE TABLE IF NOT EXISTS `students_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `students_information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_representative_by_business_business1_idx` (`business_id`),
  KEY `fk_students_by_business_students_information1_idx` (`students_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_by_representative`
--

DROP TABLE IF EXISTS `students_by_representative`;
CREATE TABLE IF NOT EXISTS `students_by_representative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `students_information_id` int(11) NOT NULL,
  `students_representative_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_by_representative_students_information1_idx` (`students_information_id`),
  KEY `fk_students_by_representative_students_representative1_idx` (`students_representative_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_course_activities_by_resource`
--

DROP TABLE IF EXISTS `students_course_activities_by_resource`;
CREATE TABLE IF NOT EXISTS `students_course_activities_by_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(450) NOT NULL,
  `type_multimedia` int(11) NOT NULL DEFAULT '0' COMMENT '	0=IMAGE 1=VIDEO',
  `educational_institution_course_by_activities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_course_activities_by_resource_educational_insti_idx` (`educational_institution_course_by_activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_information`
--

DROP TABLE IF EXISTS `students_information`;
CREATE TABLE IF NOT EXISTS `students_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `identification` varchar(45) DEFAULT NULL,
  `institution` varchar(45) DEFAULT NULL,
  `course` varchar(45) DEFAULT NULL,
  `representative_has` int(11) NOT NULL DEFAULT '0' COMMENT '0\n1',
  PRIMARY KEY (`id`),
  KEY `fk_students_information_people1_idx` (`people_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_representative`
--

DROP TABLE IF EXISTS `students_representative`;
CREATE TABLE IF NOT EXISTS `students_representative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification` varchar(45) NOT NULL,
  `people_id` int(11) NOT NULL,
  `people_relationship_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_representative_people1_idx` (`people_id`),
  KEY `fk_students_representative_people_relationship1_idx` (`people_relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_representative_by_business`
--

DROP TABLE IF EXISTS `students_representative_by_business`;
CREATE TABLE IF NOT EXISTS `students_representative_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `students_representative_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_representative_by_business_students_representat_idx` (`students_representative_id`),
  KEY `fk_students_representative_by_business_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tax`
--

DROP TABLE IF EXISTS `tax`;
CREATE TABLE IF NOT EXISTS `tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `percentage` float NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tax`
--

INSERT INTO `tax` (`id`, `value`, `percentage`, `state`) VALUES
(1, '12', 12, 'ACTIVE'),
(2, '0', 0, 'ACTIVE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxes`
--

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE IF NOT EXISTS `taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `value` decimal(10,4) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxes_by_cities`
--

DROP TABLE IF EXISTS `taxes_by_cities`;
CREATE TABLE IF NOT EXISTS `taxes_by_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_taxes_by_cities_cities1_idx` (`city_id`),
  KEY `fk_taxes_by_cities_taxes1_idx` (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tax_by_business`
--

DROP TABLE IF EXISTS `tax_by_business`;
CREATE TABLE IF NOT EXISTS `tax_by_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_id` int(11) NOT NULL,
  `state` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tax_by_business_tax1_idx` (`tax_id`),
  KEY `fk_tax_by_business_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tax_by_business`
--

INSERT INTO `tax_by_business` (`id`, `tax_id`, `state`, `business_id`) VALUES
(1, 1, 'ACTIVE', 1),
(2, 1, 'ACTIVE', 2),
(3, 1, 'ACTIVE', 3),
(4, 1, 'ACTIVE', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tax_support`
--

DROP TABLE IF EXISTS `tax_support`;
CREATE TABLE IF NOT EXISTS `tax_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `code` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_about_us`
--

DROP TABLE IF EXISTS `template_about_us`;
CREATE TABLE IF NOT EXISTS `template_about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_about_us`
--

INSERT INTO `template_about_us` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`) VALUES
(1, 'A', '<p>aaaaaaaaaa</p>', 'ACTIVE', 2, 'null', 0, 'AB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_about_us_by_data`
--

DROP TABLE IF EXISTS `template_about_us_by_data`;
CREATE TABLE IF NOT EXISTS `template_about_us_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `template_about_us_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_about_us_by_data_template_about_us1_idx` (`template_about_us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_blog`
--

DROP TABLE IF EXISTS `template_blog`;
CREATE TABLE IF NOT EXISTS `template_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_blog_by_comments`
--

DROP TABLE IF EXISTS `template_blog_by_comments`;
CREATE TABLE IF NOT EXISTS `template_blog_by_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `user_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `template_blog_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_blog_by_comments_template_blog1_idx` (`template_blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_blog_by_counters`
--

DROP TABLE IF EXISTS `template_blog_by_counters`;
CREATE TABLE IF NOT EXISTS `template_blog_by_counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_blog_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_blog_by_counters_template_blog1_idx` (`template_blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_blog_by_data`
--

DROP TABLE IF EXISTS `template_blog_by_data`;
CREATE TABLE IF NOT EXISTS `template_blog_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  `icon_class` varchar(15) DEFAULT NULL,
  `template_blog_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_blog_by_data_template_blog1_idx` (`template_blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_by_products`
--

DROP TABLE IF EXISTS `template_by_products`;
CREATE TABLE IF NOT EXISTS `template_by_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_information_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_by_products_template_information1_idx` (`template_information_id`),
  KEY `fk_template_by_products_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_by_source`
--

DROP TABLE IF EXISTS `template_by_source`;
CREATE TABLE IF NOT EXISTS `template_by_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_information_id` int(11) NOT NULL,
  `source` varchar(250) NOT NULL,
  `source_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=logo template\netc..',
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_by_source_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_by_source`
--

INSERT INTO `template_by_source` (`id`, `template_information_id`, `source`, `source_type`, `value`) VALUES
(1, 1, '/uploads/frontend/templateBySource/1604937642_corpar.png', 0, 'Logo Principal'),
(2, 2, '/uploads/frontend/templateBySource/1606691466_a2ok.png', 0, 'Logo Principal'),
(3, 3, '/uploads/frontend/templateBySource/1606690861_aok.png', 0, 'Logo Principal'),
(4, 4, '/uploads/frontend/templateBySource/1605052955_a.png', 0, 'Logo Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_chat_api`
--

DROP TABLE IF EXISTS `template_chat_api`;
CREATE TABLE IF NOT EXISTS `template_chat_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=MESSENGER FACEBOOK\n1 OTHERS',
  `options` text NOT NULL,
  `page_id` varchar(45) DEFAULT NULL COMMENT 'only facebook chat',
  `allow` int(11) NOT NULL DEFAULT '1' COMMENT '0=not\n1=yes',
  `template_information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_chat_api_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_chat_api`
--

INSERT INTO `template_chat_api` (`id`, `type`, `options`, `page_id`, `allow`, `template_information_id`) VALUES
(1, 0, '{\"attribution\":\"setup_tool\",\"logged_in_greeting\":\"Hola como estas, como te podemos ayudar.\",\"theme_color\":\"#black\",\"logged_out_greeting\":\"gracias\"}', '100000512387961', 0, 3),
(2, 0, '{\"attribution\":\"setup_tool\",\"logged_in_greeting\":\"Hola como estas, como te podemos ayudar.\",\"theme_color\":\"#44bec7\",\"logged_out_greeting\":\"Hola como estas, como te podemos ayudar.\"}', '100000512387961', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_config_mailing`
--

DROP TABLE IF EXISTS `template_config_mailing`;
CREATE TABLE IF NOT EXISTS `template_config_mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `provider_type` int(11) NOT NULL COMMENT '0=server\n1=mandril\n2=mailchimp\n3=etc',
  `template_information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_config_mailing_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_config_mailing_by_emails`
--

DROP TABLE IF EXISTS `template_config_mailing_by_emails`;
CREATE TABLE IF NOT EXISTS `template_config_mailing_by_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=CONTACT US\n1=SERVICES\n2=ABOUT US',
  `template_information_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_config_mailing_by_emails_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_config_mailing_by_emails`
--

INSERT INTO `template_config_mailing_by_emails` (`id`, `email`, `type`, `template_information_id`) VALUES
(1, 'contactanos@gmail.com', 0, 2),
(2, 'servicios@gmail.com', 1, 2),
(3, 'footer@gmail.com', 3, 2),
(4, 'comunicaciones@arrayanesalamos.edu.ec', 0, 3),
(5, 'mmsuarez4@gmail.com', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_contact_us`
--

DROP TABLE IF EXISTS `template_contact_us`;
CREATE TABLE IF NOT EXISTS `template_contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL COMMENT 'image icono maps ',
  `template_information_id` int(11) NOT NULL,
  `allow_routes` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT\n1=YES',
  PRIMARY KEY (`id`),
  KEY `fk_template_contact_us_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_contact_us`
--

INSERT INTO `template_contact_us` (`id`, `source`, `template_information_id`, `allow_routes`) VALUES
(1, '/uploads/frontend/contact-us/iconMap/1605282306_a.png', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_contact_us_by_routes_map`
--

DROP TABLE IF EXISTS `template_contact_us_by_routes_map`;
CREATE TABLE IF NOT EXISTS `template_contact_us_by_routes_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `type_shortcut` int(11) NOT NULL DEFAULT '0' COMMENT '0=ruta turistica\n1=ruta de transito\n2=ruta historica\n3=ruta tematica\n4=chakiñan\n5=atractivo turistico\n6=Géologico\n7=no geologico',
  `routes_map_id` int(11) NOT NULL,
  `template_contact_us_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_by_routes_map_routes_map1_idx` (`routes_map_id`),
  KEY `fk_template_contact_us_by_routes_map_template_contact_us1_idx` (`template_contact_us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_faq`
--

DROP TABLE IF EXISTS `template_faq`;
CREATE TABLE IF NOT EXISTS `template_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_faq_by_data`
--

DROP TABLE IF EXISTS `template_faq_by_data`;
CREATE TABLE IF NOT EXISTS `template_faq_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_faq_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_faq_by_data_template_faq1_idx` (`template_faq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_information`
--

DROP TABLE IF EXISTS `template_information`;
CREATE TABLE IF NOT EXISTS `template_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_information_business1_idx` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_information`
--

INSERT INTO `template_information` (`id`, `value`, `description`, `status`, `business_id`) VALUES
(1, 'Coorporacion Arrayanes', NULL, 'ACTIVE', 1),
(2, 'Unidad Educativa Arrayanes', 'Unidad Educativa Arrayanes', 'ACTIVE', 2),
(3, 'Unidad Educativa Alamos', NULL, 'ACTIVE', 3),
(4, 'Unidad Educativa Preescolar', NULL, 'ACTIVE', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_language_customer`
--

DROP TABLE IF EXISTS `template_language_customer`;
CREATE TABLE IF NOT EXISTS `template_language_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_key` varchar(250) NOT NULL,
  `spanish` int(11) NOT NULL DEFAULT '0' COMMENT '0 ENGLISH 1=SPANISH	',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_multimedia_sections`
--

DROP TABLE IF EXISTS `template_multimedia_sections`;
CREATE TABLE IF NOT EXISTS `template_multimedia_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  `section` int(11) NOT NULL DEFAULT '0' COMMENT '0=about us',
  `button_has` int(11) NOT NULL DEFAULT '0',
  `button_options` text COMMENT 'URL',
  `multimedia_has` int(11) NOT NULL DEFAULT '0',
  `multimedia_options` text,
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_news`
--

DROP TABLE IF EXISTS `template_news`;
CREATE TABLE IF NOT EXISTS `template_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` mediumtext,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_news`
--

INSERT INTO `template_news` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'RECONOCIMIENTO \"ÁREAS PROTEGIDAS\" CATEGORÍA PLATA', '<p><span id=\"docs-internal-guid-eb5fa6cf-7fff-5811-885f-5595d4eaa404\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental. Dicho evento contó con la presencia de miembros del Ministerio del Ambiente y Directivos de las Instituciones que participan en este proyecto. Patricio Toro, representante de la Corporación Arrayanes, agradeció el reconocimiento de plata y reiteró el compromiso de su Institución con la Reserva Nacional Ecológica “Cotacachi-Cayapas” para seguir trabajando a favor de la educación y el cuidado del ambiente.</span></span><br></p>', 'ACTIVE', 2, '/uploads/web/news/images/1614353994_a1.jpg', 1, 'La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental', '2020-11-12 08:47:12', '2021-02-26 12:06:50', NULL, 0),
(2, 'PROYECTO DE SOLIDARIDAD “DESPRENDIENDO ALEGRÍA”', '<p style=\"\"><span id=\"docs-internal-guid-c0662fc7-7fff-9d83-5f08-3b7253be5df6\" style=\"\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020. El objetivo del proyecto fue entregar a cientos de familias vulnerables y de escasos recursos de la ciudad; alimentos, prendas de vestir, juguetes, productos de bioseguridad, materiales para el hogar, entre otros. La participación y colaboración de padres de familia, estudiantes, docentes y autoridades de la institución fueron claves para realizar este importante evento en beneficio de las familias ibarreñas. </span></span><br></p>', 'ACTIVE', 2, '/uploads/web/news/images/1614358321_000A9997.jpg', 1, 'La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020.', '2020-11-12 08:48:07', '2021-02-26 12:06:42', NULL, 0),
(3, 'COMUNICADO Medidas Educativas', '<p style=\"font-size: 14.4px;\"><span id=\"docs-internal-guid-b6f732b0-7fff-f2ae-8be0-755887e81270\"></span></p><p dir=\"ltr\" style=\"line-height:1.295;margin-top:0pt;margin-bottom:8pt;\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos. Para lo cual seguiremos las siguientes directrices, mientras la emergencia sanitaria esté vigente:</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">1.-Las clases presenciales han sido suspendidas, por tal motivo será impartidas de manera virtual, vía ON-LINE. A través de los siguientes canales:</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Primaria.- La plataforma a utilizar es Idukay, donde se subirán, recursos y actividades de forma periódica y acorde a los lineamientos académicos determinados por los directores académicos.</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Secundaria: La plataforma a utilizar es G-Suite for Education.</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">2.- Los docentes estarán impartiendo las clases virtuales en los horarios de 7:30 a 13:30.</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">3.-En caso de existir dudas u observaciones en cuanto al desarrollo académico o de sus respectivos procesos, se pone a su consideración los correos institucionales de los directores académicos.</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Primaria: analuna@arrayanesalamos.edu.ec</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Secundaria: lorenaalbuja@arrayanesalamos.edu.ec</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\"><br></span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">Seguros de contar con su apoyo, agradecemos su confianza y colaboración.</span></p>', 'ACTIVE', 2, '/uploads/web/news/images/1606697989_l4.png', 1, 'Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos. Seguiremos las siguientes directrices, mientras la emergencia sanitaria esté vigente.', '2020-11-12 08:51:52', '2021-02-26 12:07:03', NULL, 0),
(4, 'CORPORACIÓN ARRAYANES Y OEA', '<p style=\"\"><span id=\"docs-internal-guid-2249d3bf-7fff-8fc9-145d-865b63a618c8\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">En las instalaciones de la Unidad Educativa \"Los Arrayanes\", se realizó la firma del convenio entre Martha Hurtado directora ejecutiva de la organización Young Americas Business Trust que es parte de la Organización de Estados Americanos, OEA y Roberto Arends Presidente de la Corporación Arrayanes. El objetivo de esta alianza es implementar, capacitar, fortalecer y dar soporte a estudiantes y maestros sobre programas y proyectos de emprendimiento para que los jóvenes puedan crear, manejar y sostener sus negocios.</span></span><br></p>', 'ACTIVE', 2, '/uploads/web/news/images/1606698183_h.jpg', 1, 'Firma del Convenio con \"Young Americas Business Trust\", entre Martha Hurtado directora ejecutiva de la organización parte de la Organización de Estados Americanos.', '2020-11-12 08:52:34', '2021-02-26 12:07:14', NULL, 0),
(5, 'RECONOCIMIENTO \"ÁREAS PROTEGIDAS\" CATEGORÍA PLATA', '<p><span style=\"color: rgb(136, 136, 136); font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental. Dicho evento contó con la presencia de miembros del Ministerio del Ambiente y Directivos de las Instituciones que participan en este proyecto. Patricio Toro, representante de la Corporación Arrayanes, agradeció el reconocimiento de plata y reiteró el compromiso de su Institución con la Reserva Nacional Ecológica “Cotacachi-Cayapas” para seguir trabajando a favor de la educación y el cuidado del ambiente.</span><br></p>', 'ACTIVE', 3, '/uploads/web/news/images/1614358845_a1.jpg', 1, 'La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental.', '2020-11-29 18:41:20', '2021-02-26 12:00:45', NULL, 0),
(6, 'CONVENIO CORPORACIÓN ARRAYANES Y ALIANZA FRANCESA', '<p><span style=\"color: rgb(38, 62, 121); font-family: Montserrat; font-size: 14px; letter-spacing: 0.5px; text-align: justify;\">El 26 de noviembre del 2018 en las instalaciones del colegio Arrayanes, se desarrolló la firma del convenio entre la Corporación Arrayanes Álamos y la Alianza Francesa con el fin de dar la oportunidad a la comunidad educativa de fortalecer el idioma francés, acceder a universidades en Francia como intercambio cultural y obtener la Certificación Internacional en el idioma. La Alianza Francesa es el único que otorga dicha certificación en el país y la Corporación Arrayanes Álamos es la única institución en la provincia que posee este convenio.</span><br></p>', 'ACTIVE', 3, '/uploads/web/news/images/1614740549_a1.jpg', 1, 'El 26 de noviembre del 2018 en las instalaciones del colegio Arrayanes, se desarrolló la firma del convenio entre la Corporación Arrayanes Álamos y la Alianza Francesa.', '2020-11-29 18:44:22', '2021-03-02 22:02:29', NULL, 0),
(7, 'PROYECTO DE SOLIDARIDAD “DESPRENDIENDO ALEGRÍA”', '<p>La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020. El objetivo del proyecto fue entregar a cientos de familias vulnerables y de escasos recursos de la ciudad; alimentos, prendas de vestir, juguetes, productos de bioseguridad, materiales para el hogar, entre otros. La participación y colaboración de padres de familia, estudiantes, docentes y autoridades de la institución fueron claves para realizar este importante evento en beneficio de las familias ibarreñas. <br></p>', 'ACTIVE', 3, '/uploads/web/news/images/1614359005_000A9997.jpg', 1, 'La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020.', '2020-11-29 18:46:52', '2021-02-26 12:03:25', NULL, 0),
(8, 'COMUNICADO Medidas Educativas COVID-19', '<p><span style=\"text-align: justify;\">Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos. Para lo cual seguiremos las siguientes directrices, mientras la emergencia sanitaria esté vigente:</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">1.-Las clases presenciales han sido suspendidas, por tal motivo será impartidas de manera virtual, vía ON-LINE. A través de los siguientes canales:</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">Primaria.- La plataforma a utilizar es Idukay, donde se subirán, recursos y actividades de forma periódica y acorde a los lineamientos académicos determinados por los directores académicos.</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">Secundaria: La plataforma a utilizar es G-Suite for Education.</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">2.- Los docentes estarán impartiendo las clases virtuales en los horarios de 7:30 a 13:30.</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">3.-En caso de existir dudas u observaciones en cuanto al desarrollo académico o de sus respectivos procesos, se pone a su consideración los correos institucionales de los directores académicos.</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">Primaria: washingtondiaz@arrayanesalamos.edu.ec</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">Secundaria: patriciotoro@arrayanesalamos.edu.ec</span><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><br style=\"font-variant-numeric: lining-nums; font-feature-settings: &quot;lnum&quot;; margin: 0px; padding: 0px; text-align: justify;\"><span style=\"text-align: justify;\">Seguros de contar con su apoyo, agradecemos su confianza y colaboración.</span><br></p>', 'ACTIVE', 3, '/uploads/web/news/images/1606694453_l4.png', 1, 'Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos.', '2020-11-29 18:50:59', '2021-02-26 12:04:05', NULL, 0),
(9, 'RECONOCIMIENTO \"ÁREAS PROTEGIDAS\" CATEGORÍA PLATA', '<p><span id=\"docs-internal-guid-025fb6fd-7fff-52f8-3fb6-ce0750d616e4\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental. Dicho evento contó con la presencia de miembros del Ministerio del Ambiente y Directivos de las Instituciones que participan en este proyecto. Patricio Toro, representante de la Corporación Arrayanes, agradeció el reconocimiento de plata y reiteró el compromiso de su Institución con la Reserva Nacional Ecológica “Cotacachi-Cayapas” para seguir trabajando a favor de la educación y el cuidado del ambiente.</span></span><br></p>', 'ACTIVE', 4, '/uploads/web/news/images/1614359420_a1.jpg', 1, 'La Corporación Arrayanes fue galardonada el 28 de agosto del 2020 en Cuicocha; con motivo de su segundo año de participación activa en el convenio de apadrinamiento y cuidado ambiental.', '2020-11-29 19:40:54', '2021-02-26 12:10:20', NULL, 0),
(10, 'CORPORACIÓN ARRAYANES YA TIENE SU CUARTA ESTRELLA EFQM', '<p><span id=\"docs-internal-guid-3b003b02-7fff-5990-24d8-c4300ec652da\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;\">La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020. El objetivo del proyecto fue entregar a cientos de familias vulnerables y de escasos recursos de la ciudad; alimentos, prendas de vestir, juguetes, productos de bioseguridad, materiales para el hogar, entre otros. La participación y colaboración de padres de familia, estudiantes, docentes y autoridades de la institución fueron claves para realizar este importante evento en beneficio de las familias ibarreñas. </span></span><br></p>', 'ACTIVE', 4, '/uploads/web/news/images/1614359671_000A9997.jpg', 1, 'La Corporación Arrayanes Álamos desarrolló el Proyecto Solidario “Desprendiendo Alegría”. Dicha actividad inicio desde el mes de noviembre y se llevó a cabo el sábado 19 y domingo 20 de diciembre del 2020.', '2020-11-29 19:42:23', '2021-02-26 12:14:31', NULL, 0),
(11, 'COMUNICADO Medidas Educativas', '<p>Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos.</p><p><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 0.9rem;\">Además, como parte de las medidas tomadas por la suspensión de clases, nos acogemos al envío de actividades de refuerzo en casa en las áreas de español e inglés, las mismas que enviaremos diariamente a sus correos electrónicos y WhatsApp. Sugerimos que dichas actividades sean realizadas a diario, estableciendo horarios en casa y sin omitir ninguna actividad.</span><br></p><p><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 0.9rem;\">En el caso específico de los niños de 5 años - Preparatoria, les recordamos que para el proceso Lecto-escritor es necesario un repaso constante. Cualquier inquietud con respecto a las actividades que se enviarán, pueden comunicarse con la profe del aula de su niño.</span></p><p><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 0.9rem;\">Seguras de contar con su apoyo, agradecemos su confianza y colaboración. Atentamente,</span><br></p><p><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 0.9rem;\">Coordinación Preescolar.</span><br></p>', 'ACTIVE', 4, '/uploads/web/news/images/1606697109_l4.png', 1, 'Debido a la situación que nuestro país atraviesa y a las recomendaciones generales entorno a la alerta de salud que estamos viviendo, solicitamos muy comedidamente el compromiso de todos para afrontar estos momentos.', '2020-11-29 19:45:09', '2020-11-29 19:45:09', NULL, 0),
(12, 'CONVENIO CORPORACIÓN ARRAYANES Y ALIANZA FRANCESA', '<p><span style=\"color: rgb(115, 144, 202); font-family: Montserrat; font-size: 14px; letter-spacing: 0.5px; text-align: justify;\">El 26 de noviembre del 2018 en las instalaciones del colegio Arrayanes, se desarrolló la firma del convenio entre la Corporación Arrayanes Álamos y la Alianza Francesa con el fin de dar la oportunidad a la comunidad educativa de fortalecer el idioma francés, acceder a universidades en Francia como intercambio cultural y obtener la Certificación Internacional en el idioma. La Alianza Francesa es el único que otorga dicha certificación en el país y la Corporación Arrayanes Álamos es la única institución en la provincia que posee este convenio.</span><br></p>', 'ACTIVE', 4, '/uploads/web/news/images/1606697232_o.jpg', 1, 'El 26 de noviembre del 2018 en las instalaciones del colegio Arrayanes, se desarrolló la firma del convenio entre la Corporación Arrayanes Álamos y la Alianza Francesa.', '2020-11-29 19:47:12', '2020-11-29 19:47:12', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_news_by_data`
--

DROP TABLE IF EXISTS `template_news_by_data`;
CREATE TABLE IF NOT EXISTS `template_news_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `template_news_id` int(11) NOT NULL,
  `title_icon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_news_by_data_template_news1` (`template_news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_news_by_data`
--

INSERT INTO `template_news_by_data` (`id`, `title`, `description`, `status`, `source`, `allow_source`, `template_news_id`, `title_icon`) VALUES
(1, '<p>1</p>', '<p>1.1</p>', 'ACTIVE', '/uploads/web/news-data/images/1614354096_a2.jpg', 1, 1, 'none');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_our_team`
--

DROP TABLE IF EXISTS `template_our_team`;
CREATE TABLE IF NOT EXISTS `template_our_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_our_team_by_data`
--

DROP TABLE IF EXISTS `template_our_team_by_data`;
CREATE TABLE IF NOT EXISTS `template_our_team_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  `template_our_team_id` int(11) NOT NULL,
  `human_resources_employee_profile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_our_team_by_data_template_our_team1_idx` (`template_our_team_id`),
  KEY `fk_template_our_team_by_data_human_resources_employee_profi_idx` (`human_resources_employee_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_payments`
--

DROP TABLE IF EXISTS `template_payments`;
CREATE TABLE IF NOT EXISTS `template_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_payment` int(11) NOT NULL DEFAULT '0' COMMENT '0=PAYPAL\n1=PAYU',
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `template_information_id` int(11) NOT NULL,
  `type_manager` int(11) NOT NULL DEFAULT '0' COMMENT '0=MODE TEST\n1=LIVE PRODUCTION',
  `user` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `test_id` text COMMENT 'API_LIVE_CLIENT_ID',
  `test_secret` text COMMENT 'API_LIVE_SECRET',
  `live_id` text COMMENT 'SAND_BOX_CLIENT_ID',
  `live_secret` text COMMENT 'SAND_BOX_SECRET',
  `msj_to_customer` text,
  `manager_type_modal` int(11) NOT NULL DEFAULT '0' COMMENT '0=NOT MODAL\n1=MODAL',
  `priority` int(11) NOT NULL DEFAULT '0' COMMENT '0,1,2',
  PRIMARY KEY (`id`),
  KEY `fk_template_payments_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_policies`
--

DROP TABLE IF EXISTS `template_policies`;
CREATE TABLE IF NOT EXISTS `template_policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0=POLICIES\n1=TERMS',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_services`
--

DROP TABLE IF EXISTS `template_services`;
CREATE TABLE IF NOT EXISTS `template_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_services_by_data`
--

DROP TABLE IF EXISTS `template_services_by_data`;
CREATE TABLE IF NOT EXISTS `template_services_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `template_services_id` int(11) NOT NULL,
  `title_icon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_services_by_data_template_services1_idx` (`template_services_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_slider`
--

DROP TABLE IF EXISTS `template_slider`;
CREATE TABLE IF NOT EXISTS `template_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `position_section` int(11) NOT NULL DEFAULT '0' COMMENT '0=SLIDER MAIN\n1=SLIDER ACTIVITY GAMIFICATION\n2=SLIDER REWARD GAMIFICATION',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_slider`
--

INSERT INTO `template_slider` (`id`, `value`, `description`, `status`, `template_information_id`, `position_section`) VALUES
(1, 'Slider Principal', NULL, 'ACTIVE', 1, 0),
(2, 'Principal Arrayanes', NULL, 'INACTIVE', 2, 0),
(3, 'Principal Alamos', NULL, 'ACTIVE', 3, 0),
(4, 'a', 'ad', 'ACTIVE', 4, 0),
(5, 'a', 'a', 'ACTIVE', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_slider_by_images`
--

DROP TABLE IF EXISTS `template_slider_by_images`;
CREATE TABLE IF NOT EXISTS `template_slider_by_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(350) NOT NULL DEFAULT 'nothing',
  `template_slider_id` int(11) NOT NULL,
  `title` text,
  `subtitle` text,
  `options_title` text,
  `button_name` varchar(45) DEFAULT NULL,
  `options_button` text,
  `options_subtitle` text,
  `options_all` text,
  `options_source` text,
  `position` int(11) NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `type_button` int(11) NOT NULL DEFAULT '0' COMMENT '0=not button',
  `type_multimedia` int(1) NOT NULL DEFAULT '1' COMMENT '0=ONLY BACKGROUND\n1=BACKGROUND AND TEXT',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_by_images_template_slider1_idx` (`template_slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `template_slider_by_images`
--

INSERT INTO `template_slider_by_images` (`id`, `source`, `template_slider_id`, `title`, `subtitle`, `options_title`, `button_name`, `options_button`, `options_subtitle`, `options_all`, `options_source`, `position`, `status`, `type_button`, `type_multimedia`) VALUES
(1, '/uploads/web/slider/images/1614792542_q.png', 1, 'U. E. Los Arrayanes<br>Admisiones Abiertas<br>Reserva tu cupo', '<blockquote> Queremos verlos convertirse en las personas del mañana<br>Para mayor información ingrese a nuestro sitio web </blockquote>', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Conoce Más', '{\"data\":[{\"name\":\"Conoce Más\",\"link\":\"http://test.arrayanesalamos.edu.ec/es/arrayanes\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 1, 'ACTIVE', 1, 1),
(2, '/uploads/web/slider/images/1614792603_q2.png', 1, 'U. E. Álamos<br>Admisiones Abiertas<br>Reserva tu cupo', '<blockquote> Queremos verlos convertirse en las personas del mañana<br>Para mayor información ingrese a nuestro sitio web </blockquote>', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Conoce Más', '{\"data\":[{\"name\":\"Conoce Más\",\"link\":\"http://test.arrayanesalamos.edu.ec/es/alamos\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 2, 'ACTIVE', 1, 1),
(3, '/uploads/web/slider/images/1614793569_preesco.png', 1, 'Preescolar<br>Admisiones Abiertas<br>Reserva tu cupo', '<blockquote> Queremos verlos convertirse en las personas del mañana<br>Para mayor información ingrese a nuestro sitio web </blockquote>', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Conoce Más', '{\"data\":[{\"name\":\"Conoce Más\",\"link\":\"http://test.arrayanesalamos.edu.ec/es/preescolar\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 3, 'ACTIVE', 1, 1),
(4, '/uploads/web/slider/images/1606694983_lw2.jpg', 2, 'only-background', 'only-background', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'not-button', '{\"data\":[{\"name\":\"not-button\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 1, 'ACTIVE', 0, 0),
(5, '/uploads/web/slider/images/1606694999_lw1.jpg', 2, 'only-background', 'only-background', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'not-button', '{\"data\":[{\"name\":\"not-button\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 0, 'ACTIVE', 0, 0),
(6, '/uploads/web/slider/images/1614705637_ok.jpg', 3, 'All together Now', 'Trabajamos con G-Suite for Education, aplicaciones inteligentes para mantener a nuestros alumnos y profesores, trabajando en equipo.', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Síguenos en Facebook', '{\"data\":[{\"name\":\"Síguenos en Facebook\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 2, 'ACTIVE', 0, 1),
(7, '/uploads/web/slider/images/1614706439_efqm.jpg', 3, 'EFQM 4 Estrellas <br>\nAcreditación de Calidad Europea', 'Excelencia Educativa con Calidad Europea', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Conoce más', '{\"data\":[{\"name\":\"Conoce más\",\"link\":\"https://www.facebook.com/882171281848193/videos/1558570724208242\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 3, 'ACTIVE', 1, 1),
(8, '/uploads/web/slider/images/1614612693_alamos.png', 3, '<font color=\"#ffffff\"> Admisiones Abiertas <br>Ciclo Escolar 21-22</font>', 'Queremos verlos convertirse en las personas del mañana. <br> Reserva tu cupo', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Admisiones', '{\"data\":[{\"name\":\"Admisiones\",\"link\":\"https://corporacionarrayanes.postulaciones.colegium.com/loginColegio\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 1, 'ACTIVE', 1, 1),
(9, '/uploads/web/slider/images/1614707144_ok.jpg', 5, 'All together Now', 'Trabajamos con G-Suite for Education, aplicaciones inteligentes para mantener a nuestros alumnos y profesores, trabajando en equipo.', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Saber Más', '{\"data\":[{\"name\":\"Saber Más\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 2, 'ACTIVE', 0, 1),
(10, '/uploads/web/slider/images/1614706931_efqm.jpg', 5, 'EFQM 4 Estrellas\nAcreditación de Calidad Europea', 'Excelencia Educativa con Calidad Europea', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Conoce Más', '{\"data\":[{\"name\":\"Conoce Más\",\"link\":\"https://www.facebook.com/882171281848193/videos/1558570724208242\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 3, 'ACTIVE', 1, 1),
(11, '/uploads/web/slider/images/1614363538_q3.png', 5, 'Admisiones Abiertas\nCiclo Escolar 21-22', 'Queremos verlos convertirse en las personas del mañana.<br>\nReserva tu cupo.', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Admisiones Abiertas', '{\"data\":[{\"name\":\"Admisiones Abiertas\",\"link\":\"https://corporacionarrayanes.postulaciones.colegium.com/loginColegio\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 1, 'ACTIVE', 1, 1),
(12, '/uploads/web/slider/images/1614796411_q2.jpg', 4, 'EFQM 4 Estrellas Acreditación de Calidad Europea', 'Excelencia Educativa con Calidad Europea', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Saber Más', '{\"data\":[{\"name\":\"Saber Más\",\"link\":\"https://www.facebook.com/882171281848193/videos/1558570724208242\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 3, 'ACTIVE', 1, 1);
INSERT INTO `template_slider_by_images` (`id`, `source`, `template_slider_id`, `title`, `subtitle`, `options_title`, `button_name`, `options_button`, `options_subtitle`, `options_all`, `options_source`, `position`, `status`, `type_button`, `type_multimedia`) VALUES
(13, '/uploads/web/slider/images/1614192191_base1.jpg', 4, 'only-background', 'only-background', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'A', '{\"data\":[{\"name\":\"A\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 4, 'INACTIVE', 0, 0),
(14, '/uploads/web/slider/images/1614612053_PREESCO.png', 4, 'Admisiones Abiertas Ciclo Escolar 21-22', 'Queremos verlos convertirse en las personas del mañana.\nReserva tu cupo.', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'Admisiones Abiertas', '{\"data\":[{\"name\":\"Admisiones Abiertas\",\"link\":\"https://corporacionarrayanes.postulaciones.colegium.com/loginColegio\"}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 1, 'ACTIVE', 1, 1),
(15, '/uploads/web/slider/images/1614711075_ok.jpg', 4, 'All together Now', 'Trabajamos con G-Suite for Education, aplicaciones inteligentes para mantener a nuestros alumnos y profesores, trabajando en equipo.', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'asfsdf', '{\"data\":[{\"name\":\"asfsdf\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 2, 'ACTIVE', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_steps`
--

DROP TABLE IF EXISTS `template_steps`;
CREATE TABLE IF NOT EXISTS `template_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_steps_by_data`
--

DROP TABLE IF EXISTS `template_steps_by_data`;
CREATE TABLE IF NOT EXISTS `template_steps_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  `icon_class` varchar(15) DEFAULT NULL,
  `template_steps_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_steps_by_data_template_steps1_idx` (`template_steps_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_support`
--

DROP TABLE IF EXISTS `template_support`;
CREATE TABLE IF NOT EXISTS `template_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(150) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `template_information_id` int(11) NOT NULL,
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `subtitle` text,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  PRIMARY KEY (`id`),
  KEY `fk_template_slider_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_support_by_data`
--

DROP TABLE IF EXISTS `template_support_by_data`;
CREATE TABLE IF NOT EXISTS `template_support_by_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `source` varchar(350) DEFAULT 'nothing',
  `allow_source` int(11) NOT NULL DEFAULT '0',
  `template_support_id` int(11) NOT NULL,
  `type_source` int(11) NOT NULL DEFAULT '0' COMMENT '0=NONE\n1=SOURCE\n2=LINK IMAGE\n3=ICON CLASS',
  PRIMARY KEY (`id`),
  KEY `fk_template_support_by_data_template_support1_idx` (`template_support_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_wish_list_by_user`
--

DROP TABLE IF EXISTS `template_wish_list_by_user`;
CREATE TABLE IF NOT EXISTS `template_wish_list_by_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `template_information_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_template_wish_list_by_user_template_information1_idx` (`template_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_advance`
--

DROP TABLE IF EXISTS `treatment_by_advance`;
CREATE TABLE IF NOT EXISTS `treatment_by_advance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'ad',
  `type_input` int(11) NOT NULL DEFAULT '0' COMMENT '0=OUTPUT\n1=INPUT s',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'c',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'u',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'd',
  `treatment_by_patient_id` int(11) NOT NULL COMMENT 'a',
  PRIMARY KEY (`id`),
  KEY `fk_treatment_by_advance_treatment_by_patient1_idx` (`treatment_by_patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_breakdown_payment`
--

DROP TABLE IF EXISTS `treatment_by_breakdown_payment`;
CREATE TABLE IF NOT EXISTS `treatment_by_breakdown_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `date_agreement` datetime NOT NULL COMMENT 'da',
  `payment_value` decimal(10,4) NOT NULL COMMENT 'value',
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '0=pagado\n 1=deuda',
  `user_id` int(11) NOT NULL,
  `treatment_by_indebtedness_paying_init_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_treatment_by_breakdown_payment_treatment_by_indebtedness_idx` (`treatment_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_details`
--

DROP TABLE IF EXISTS `treatment_by_details`;
CREATE TABLE IF NOT EXISTS `treatment_by_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT 'service or product',
  `quantity` decimal(10,4) DEFAULT NULL COMMENT 'qu',
  `quantity_unit` decimal(10,4) DEFAULT NULL COMMENT 'u',
  `discount_percentage` decimal(10,4) DEFAULT NULL COMMENT 'per',
  `discount_percentage_unit` decimal(10,4) DEFAULT NULL COMMENT 'per uni',
  `discount_value` decimal(10,4) DEFAULT NULL COMMENT 'dis',
  `discount_value_unit` decimal(10,4) DEFAULT NULL COMMENT 'dis',
  `unit_price` decimal(10,4) DEFAULT NULL COMMENT 'unit pri',
  `unit_price_unit` decimal(10,4) DEFAULT NULL COMMENT 'unit',
  `management_type` char(3) DEFAULT 'U' COMMENT '// PARA VERIFICAR SI ES UNIDA/CAJA\n //U=UNIDAD VENTA NORMAL \n//C=CAJA VENTA CAJA\n //CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.\n\n',
  `tax_percentage` int(11) DEFAULT NULL COMMENT '2',
  `subtotal` decimal(10,4) NOT NULL COMMENT 's',
  `total` decimal(10,4) NOT NULL COMMENT 't',
  `description` text COMMENT 'des\n',
  `product_type` varchar(45) DEFAULT '0' COMMENT '	0=PRODUCTO \n1=EXPEND\n\n',
  `treatment_by_patient_id` int(11) NOT NULL COMMENT 'f',
  PRIMARY KEY (`id`),
  KEY `fk_treatment_by_details_treatment_by_patient1_idx` (`treatment_by_patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_indebtedness_paying_init`
--

DROP TABLE IF EXISTS `treatment_by_indebtedness_paying_init`;
CREATE TABLE IF NOT EXISTS `treatment_by_indebtedness_paying_init` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_payments` int(11) NOT NULL COMMENT 'numvber',
  `user_id` int(11) NOT NULL COMMENT 'user',
  `treatment_by_patient_id` int(11) NOT NULL COMMENT 'tl',
  PRIMARY KEY (`id`),
  KEY `fk_treatment_by_indebtedness_paying_init_treatment_by_patie_idx` (`treatment_by_patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_patient`
--

DROP TABLE IF EXISTS `treatment_by_patient`;
CREATE TABLE IF NOT EXISTS `treatment_by_patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'customer',
  `invoice_code` varchar(45) NOT NULL COMMENT 'invo',
  `invoice_value` decimal(10,4) NOT NULL COMMENT 'value',
  `discount_value` decimal(10,4) DEFAULT NULL COMMENT 'dis',
  `status` enum('PENDING','ISSUED','COLLECTED','CANCELED') NOT NULL DEFAULT 'ISSUED' COMMENT 'sta',
  `created_at` datetime NOT NULL COMMENT 'c',
  `user_id` int(11) NOT NULL,
  `observations` text COMMENT 'o',
  `value_taxes` decimal(10,4) NOT NULL COMMENT 'tx',
  `subtotal` decimal(10,4) NOT NULL COMMENT 'sub',
  `authorization_number` varchar(150) NOT NULL COMMENT 'aut',
  `invoice_date` datetime NOT NULL COMMENT 'invo',
  `establishment` varchar(3) NOT NULL COMMENT 'e',
  `emission_point` varchar(3) NOT NULL COMMENT 'ee',
  `mixed_payment` int(11) NOT NULL DEFAULT '1' COMMENT '1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO\n 0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS\n',
  `has_retention` int(11) NOT NULL DEFAULT '1' COMMENT '1= siempre habra retenciones a lo legal\n 0= no hay retencion\n',
  `debt` int(11) NOT NULL DEFAULT '0' COMMENT '0=sin DEUDA\n 1=DEUDA\n\n',
  `freight` int(11) NOT NULL DEFAULT '0' COMMENT 'fre',
  `type_of_discount` int(11) NOT NULL DEFAULT '0' COMMENT '0=% \n1=$\n1',
  `discount_type_invoice` int(11) NOT NULL DEFAULT '0' COMMENT '0=INVOICE\n 1= PRODUCTO/SERVICIO	\ns',
  `history_clinic_id` int(11) NOT NULL COMMENT 'key',
  PRIMARY KEY (`id`),
  KEY `fk_treatment_by_patient_history_clinic1_idx` (`history_clinic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_by_payment`
--

DROP TABLE IF EXISTS `treatment_by_payment`;
CREATE TABLE IF NOT EXISTS `treatment_by_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `payment_date` datetime NOT NULL COMMENT 'oa',
  `state_payment` int(11) NOT NULL DEFAULT '1' COMMENT '1=puntual\n 0=atrasado',
  `details` text COMMENT 'det',
  `types_payments_by_account_id` int(11) NOT NULL COMMENT 's',
  `accounting_account_id` int(11) DEFAULT NULL COMMENT 'd',
  `user_id` int(11) NOT NULL COMMENT '1',
  `treatment_by_breakdown_payment_id` int(11) NOT NULL COMMENT '2',
  `treatment_by_indebtedness_paying_init_id` int(11) NOT NULL COMMENT '2',
  PRIMARY KEY (`id`),
  KEY `fk_invoice_buy_by_payment_types_payments_by_account1_idx` (`types_payments_by_account_id`),
  KEY `fk_treatment_by_payment_treatment_by_breakdown_payment1_idx` (`treatment_by_breakdown_payment_id`),
  KEY `fk_treatment_by_payment_treatment_by_indebtedness_paying_in_idx` (`treatment_by_indebtedness_paying_init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types_payments`
--

DROP TABLE IF EXISTS `types_payments`;
CREATE TABLE IF NOT EXISTS `types_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `code` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `types_payments`
--

INSERT INTO `types_payments` (`id`, `value`, `description`, `status`, `code`) VALUES
(1, 'SIN UTILIZACION DEL SISTEMA FINANCIERO', NULL, 'ACTIVE', '01'),
(2, 'CHEQUE PROPIO', NULL, 'INACTIVE', '02'),
(3, 'CHEQUE CERTIFICADO', NULL, 'INACTIVE', '03'),
(4, 'CHEQUE DE GERENCIA', NULL, 'INACTIVE', '04'),
(5, 'CHEQUE DEL EXTERIOR', NULL, 'INACTIVE', '05'),
(6, 'DÉBITO DE CUENTA', NULL, 'INACTIVE', '06'),
(7, 'TRANSFERENCIA PROPIO BANCO', NULL, 'INACTIVE', '07'),
(8, 'TRANSFERENCIA OTRO BANCO NACIONAL', NULL, 'INACTIVE', '08'),
(9, 'TRANSFERENCIA  BANCO EXTERIOR', NULL, 'INACTIVE', '09'),
(10, 'TARJETA DE CRÉDITO NACIONAL', NULL, 'INACTIVE', '10'),
(11, 'TARJETA DE CRÉDITO INTERNACIONAL', NULL, 'INACTIVE', '11'),
(12, 'GIRO', NULL, 'INACTIVE', '12'),
(13, 'DEPOSITO EN CUENTA (CORRIENTE/AHORROS)', NULL, 'INACTIVE', '13'),
(14, 'ENDOSO DE INVERSIÓN', NULL, 'INACTIVE', '14'),
(15, 'COMPENSACIÓN DE DEUDAS', NULL, 'ACTIVE', '15'),
(16, 'TARJETA DE DÉBITO', NULL, 'ACTIVE', '16'),
(17, 'DINERO ELECTRÓNICO', NULL, 'ACTIVE', '17'),
(18, 'TARJETA PREPAGO', NULL, 'ACTIVE', '18'),
(19, 'TARJETA DE CRÉDITO', NULL, 'ACTIVE', '19'),
(20, 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO', NULL, 'ACTIVE', '20'),
(21, 'ENDOSO DE TÍTULOS', NULL, 'ACTIVE', '21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types_payments_by_account`
--

DROP TABLE IF EXISTS `types_payments_by_account`;
CREATE TABLE IF NOT EXISTS `types_payments_by_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TYPOS DE PAGOS HAS CUENTA ENTIDAD',
  `accounting_account_id` int(11) NOT NULL,
  `types_payments_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_types_payments_by_account_accounting_account1_idx` (`accounting_account_id`),
  KEY `fk_types_payments_by_account_types_payments1_idx` (`types_payments_id`),
  KEY `fk_types_payments_by_account_business1_idx` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider_id` text COLLATE utf8mb4_unicode_ci COMMENT 'is user id login red social',
  `provider` text COLLATE utf8mb4_unicode_ci COMMENT '0=owner server\n1=facebook\n2=gmail\n3=others',
  `api_token` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL COMMENT 'social network id',
  `avatar` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `provider_id`, `provider`, `api_token`, `user_id`, `avatar`) VALUES
(1, 'Admin', 'admin@system.dev', NULL, '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', 'nAGzKTF8YykNA2STsUy1kDslX7dRjSS1BOUdvYPXG8LwDNN0g0LiLInHd4RM', 'ACTIVE', '2017-11-25 15:41:16', '2017-11-25 15:41:16', 'server', 'server', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_by_about_us`
--

DROP TABLE IF EXISTS `users_by_about_us`;
CREATE TABLE IF NOT EXISTS `users_by_about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `web` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_by_profile_users1_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_has_roles`
--

DROP TABLE IF EXISTS `users_has_roles`;
CREATE TABLE IF NOT EXISTS `users_has_roles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_users_has_roles_roles1_idx` (`role_id`),
  KEY `fk_users_has_roles_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users_has_roles`
--

INSERT INTO `users_has_roles` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voucher_type`
--

DROP TABLE IF EXISTS `voucher_type`;
CREATE TABLE IF NOT EXISTS `voucher_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `description` text,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `code` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `city_id` int(11) NOT NULL,
  `color` varchar(7) NOT NULL,
  `zip_code` varchar(45) DEFAULT NULL,
  `polygon_coordinates` text,
  `polygon_spatial` polygon DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `place_id` varchar(200) DEFAULT 'none-id',
  PRIMARY KEY (`id`),
  KEY `fk_zones_cities1_idx` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zones`
--

INSERT INTO `zones` (`id`, `name`, `city_id`, `color`, `zip_code`, `polygon_coordinates`, `polygon_spatial`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`) VALUES
(1, 'Gonzales Suares', 1, '#ffa8b8', '100450', '[[0.19898877729791498,-78.25823140153514],[0.2015636822213178,-78.25724434861766],[0.2033232003518515,-78.25707268724071],[0.20400984152158985,-78.25625729570018],[0.20319445512926707,-78.25475525865184],[0.20336611542581728,-78.25376820573436],[0.20495397308212226,-78.25260949143993],[0.20611267992122725,-78.25153660783397],[0.2074001318658086,-78.25084996232616],[0.20873049876517405,-78.24801754960643],[0.2101466956634176,-78.24660134324657],[0.21083333653760608,-78.2446272374116],[0.21164872253637973,-78.24303936967479],[0.21023252577434026,-78.24007821092235],[0.21083333653760608,-78.23801827439891],[0.21860095929455028,-78.23741745957958],[0.2194163448782743,-78.23964905747997],[0.21993132522405012,-78.24200940141307],[0.21598314212208675,-78.25007748612987],[0.21302200412154337,-78.25557065019237],[0.21109082685763916,-78.25921845445262],[0.20662766071159372,-78.25994801530467]]', 0x0000000001030000000100000017000000281900dd869053c091fd61d97678c93f4a1900b1769053c00fd899b7d6ccc93f471900e1739053c083be03a07e06ca3f25190085669053c015ddb296fe1cca3f3d1900e94d9053c0db1ec1a14602ca3f191900bd3d9053c0a2296f9fe607ca3f371900c12a9053c01257c989ee3bca3f3419002d199053c08ebbc679e661ca3f271900ed0d9053c0ed5dc667168cca3f14190085df8f53c0ebe4ef54aeb7ca3f50190051c88f53c03b519e4016e6ca3f4e1900f9a78f53c0d6f4aa3696fcca3f411900f58d8f53c0d457c42a4e17cb3f191900715d8f53c05fcd603fe6e8ca3f381900b13b8f53c0d6f4aa3696fcca3f501900d9318f53c043ac85c11dfbcb3f34190069568f53c028e2bab4d515cc3f2d1900157d8f53c098039aacb526cc3f3b190045019053c0cb6af3e955a5cb3f181900455b9053c0dee383164e44cb3f4d190009979053c0ab69eb320605cb3f491900fda29053c010469a72c672ca3f281900dd869053c091fd61d97678c93f, 'ACTIVE', '2020-05-20 16:54:53', '2020-05-20 17:02:44', NULL, 'none-id'),
(2, 'El Jordan', 1, '#e5bedd', NULL, '[[0.2170141185930993,-78.2193915055365],[0.2086027691489902,-78.20892016154237],[0.20877442938728538,-78.19621721964783],[0.2175290990212006,-78.19175402384705],[0.2231938825614229,-78.20874850016541],[0.22370886277591814,-78.21424166422791],[0.22096230142418116,-78.22024981242127]]', 0x00000000010300000001000000080000004e53ab820a8e53c02e56105f1ec7cb3f1153abf25e8d53c028cbacdb7eb3ca3f3753abd28e8c53c0f9cf3ad91eb9ca3f2753abb2458c53c020b91c57fed7cb3f0e53ab225c8d53c04b6022fd9d91cc3f3153ab22b68d53c0b655b9f47da2cc3f1853ab92188e53c0020422217e48cc3f4e53ab820a8e53c02e56105f1ec7cb3f, 'ACTIVE', '2020-05-20 16:58:17', '2020-05-20 17:02:44', NULL, 'none-id'),
(3, 'San Rafael de la laguna', 1, '#e5bedd', NULL, '[[0.2048400917519579,-78.24626876404871],[0.19351050934756264,-78.2485003619491],[0.19351050934756264,-78.22481109192957],[0.20724333548969276,-78.23974563172449]]', 0x00000000010300000001000000050000007ae70fdec28f53c0cafd7d3b3338ca3f5ee70f6ee78f53c0d13f8acef3c4c83f83e70f4e638e53c0d13f8acef3c4c83f43e70ffe578f53c095ff1e1af386ca3f7ae70fdec28f53c0cafd7d3b3338ca3f, 'ACTIVE', '2020-05-20 16:58:17', '2020-05-20 17:02:44', NULL, 'none-id'),
(4, 'San Juan de Iluman', 1, '#e5bedd', NULL, '[[0.23111585890298292,-78.28933583598388],[0.22673852873244676,-78.28933583598388],[0.22862678896981717,-78.28555928569091],[0.23051504895887534,-78.28444348674071]]', 0x00000000010300000001000000050000002d47747a849253c0c7a1c9573495cd3f2d47747a849253c06313d3a2c405cd3f2a47749a469253c013b4ce82a443cd3f38477452349253c03dd241628481cd3f2d47747a849253c0c7a1c9573495cd3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(5, 'San Luis', 1, '#e5bedd', NULL, '[[0.2251935883549699,-78.2782636771704],[0.2168680735304996,-78.27208386760009],[0.21901382521895926,-78.26659070353759],[0.22261868736255455,-78.2683931479956]]', 0x000000000103000000010000000500000008477412cf9153c01e72a0bc24d3cc3f1e4774d2699153c02915ae4155c2cb3f414774d20f9153c03af95720a508cc3f4047745a2d9153c049add9e6c47ecc3f08477412cf9153c01e72a0bc24d3cc3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(6, 'San Pedro de Pataqui', 1, '#e5bedd', NULL, '[[0.22819763893760353,-78.2441888938452],[0.2242494580436194,-78.25002538066161],[0.22510775832918428,-78.25174199443114],[0.2297425789935009,-78.250454534104],[0.22957091899551568,-78.24796544413817]]', 0x0000000001030000000100000006000000164774caa08f53c0d375218a9435cd3f3f47746a009053c096b638cc34b4cc3f1a47748a1c9053c0f6c20cbe54d0cc3f24477472079053c0bb4ca36f3468cd3f184774aade8f53c0f26599729462cd3f164774caa08f53c0d375218a9435cd3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(7, 'San Jose de Quichinche', 1, '#e5bedd', NULL, '[[0.23403407826881503,-78.23337422709716],[0.23060087895244827,-78.23637830119384],[0.23635148733308337,-78.23663579325927],[0.2379822564430687,-78.23165761332763]]', 0x00000000010300000001000000050000001947749aef8e53c0fa332824d4f4cd3f2f4774d2208f53c0d5cac3605484cd3f1147740a258f53c0cd6f3afac340ce3f3e47747ad38e53c03fc339dc3376ce3f1947749aef8e53c0fa332824d4f4cd3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(8, 'Dr Miguel Egas', 1, '#e5bedd', NULL, '[[0.2289701089863594,-78.23886739115966],[0.2289701089863594,-78.23054181437743],[0.22570856849904763,-78.23792325358642]]', 0x00000000010300000001000000040000003c47749a498f53c006d2ed7ce44ecd3f06477432c18e53c006d2ed7ce44ecd3f074774223a8f53c0cdb010b404e4cc3f3c47749a498f53c006d2ed7ce44ecd3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(9, 'Selva Alegra', 1, '#e5bedd', NULL, '[[0.22845512895847364,-78.22702275614989],[0.23214581874799814,-78.22230206828368],[0.23300411856156872,-78.22693692546142]]', 0x00000000010300000001000000040000002c47748a878e53c0a173bd85043ecd3f3a4774323a8e53c0bc80b645f4b6cd3f07477422868e53c06c12873614d3cd3f2c47748a878e53c0a173bd85043ecd3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(10, 'Eugenio Espejo', 1, '#e5bedd', NULL, '[[0.22570856849904763,-78.22775231700194],[0.22648103868095426,-78.22234498362792],[0.22304783755930466,-78.22414742808593]]', 0x00000000010300000001000000040000002847747e938e53c0cdb010b404e4cc3f2a4774e63a8e53c0ca3e26a754fdcc3f2947746e588e53c0135fe1dfd48ccc3f2847747e938e53c0cdb010b404e4cc3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(11, 'San Pablo del Lago', 1, '#e5bedd', NULL, '[[0.24286668310337173,-78.20816716087256],[0.2347128385193923,-78.20773800743018],[0.23454117858174858,-78.21649273765479],[0.2382318667746855,-78.21563443077002]]', 0x00000000010300000001000000050000003f035b9c528d53c0acc59b664116cf3f13035b944b8d53c0a230b2fe110bce3f2f035b04db8d53c0f275c9017205ce3f1e035bf4cc8d53c0fcc654be617ece3f3f035b9c528d53c0acc59b664116cf3f, 'ACTIVE', '2020-05-20 17:02:44', '2020-05-20 17:02:44', NULL, 'none-id'),
(12, 'Cristoba Colon', 5, '#e5bedd', NULL, '[[0.6402458478000177,-77.74711566851752],[0.6382718648346677,-77.72600131915229],[0.6232524045846296,-77.73612934039252]]', 0x00000000010300000001000000040000004ca73cbed06f53c09b6d36dce47ce43f16a73cce766e53c0b77f2d1eb96ce43f4ca73cbe1c6f53c0e304db06aff1e33f4ca73cbed06f53c09b6d36dce47ce43f, 'ACTIVE', '2020-07-14 00:36:18', '2020-07-27 01:47:56', NULL, 'none-id'),
(13, 'Por definir', 215, '#e5bedd', NULL, '[[-0.16509509768396524,-78.48976135350341],[-0.15556792857568008,-78.47680091954345],[-0.16226269652208958,-78.46504211522216]]', 0x0000000001030000000100000004000000f7080140589f53c0772ba40ed621c5bff40801e8839e53c043fec45ea6e9c3bf09090140c39d53c0c329762706c5c4bff7080140589f53c0772ba40ed621c5bf, 'ACTIVE', '2020-07-27 01:35:16', '2020-07-27 01:35:16', NULL, 'none-id'),
(14, 'Chical', 6, '#e5bedd', NULL, '[[0.8239941784795906,-77.73905868270874],[0.8251956836756045,-77.72554034927369],[0.814167568858249,-77.73279304244996]]', 0x0000000001030000000100000004000000d703cabc4c6f53c05741150a295eea3fdb03ca406f6e53c06cfc45c70068ea3fc803ca14e66e53c06bb83625a90dea3fd703cabc4c6f53c05741150a295eea3f, 'ACTIVE', '2020-07-27 01:43:50', '2020-07-31 14:46:56', NULL, 'none-id'),
(15, 'Tulcan', 6, '#e5bedd', NULL, '[[0.7997494433501385,-77.76096696594239],[0.8400857356430022,-77.71582002380372],[0.8189735992815355,-77.67067308166504],[0.7769206414113045,-77.75976533630372]]', 0x0000000001030000000100000005000000aa03caaeb37053c098db05258c97e93fd903cafecf6d53c078870d7bfbe1ea3fc203ca4eec6a53c0b373261f0835ea3fd903cafe9f7053c0335d4ead88dce83faa03caaeb37053c098db05258c97e93f, 'ACTIVE', '2020-07-27 01:45:25', '2020-07-31 14:46:57', NULL, 'none-id'),
(16, 'Sin registro', 8, '#e5bedd', NULL, '[[0.5087050120222935,-77.94235172641358],[0.5141121299966296,-77.89222660434326],[0.5026112704647144,-77.93488445651612]]', 0x0000000001030000000100000004000000bf919d7d4f7c53c0024ebebb4f47e03f8e919d3d1a7953c066ff19489b73e03f99919d25d57b53c0efe6273b6415e03fbf919d7d4f7c53c0024ebebb4f47e03f, 'ACTIVE', '2020-07-27 01:46:34', '2020-07-31 15:02:25', NULL, 'none-id'),
(17, 'Sin registro', 7, '#e5bedd', NULL, '[[0.5048868951487201,-77.91947606202393],[0.5078050246003604,-77.87690404053956],[0.4932143643209043,-77.89492848511964]]', 0x000000000103000000010000000400000045f61fb2d87a53c0acf7da8f0828e03f5ff61f321f7853c08ee5ac52f03fe03f5af61f82467953c0953e2bfbd290df3f45f61fb2d87a53c0acf7da8f0828e03f, 'ACTIVE', '2020-07-27 01:46:58', '2020-07-31 14:57:51', NULL, 'none-id'),
(18, 'Sin registro', 9, '#e5bedd', NULL, '[[0.5557989348868654,-78.0542882720581],[0.5591461732930796,-78.01446283260498],[0.5430107502734334,-78.02175844112548]]', 0x0000000001030000000100000004000000e9428475798353c025b40fd91ac9e13ff24284f5ec8053c04446ff8386e4e13fce42847d648153c032a0b9145860e13fe9428475798353c025b40fd91ac9e13f, 'ACTIVE', '2020-07-27 01:48:18', '2020-07-27 01:48:18', NULL, 'none-id'),
(19, 'Sin registro', 10, '#e5bedd', NULL, '[[0.5724422490199026,-77.79592586260988],[0.5746737351073109,-77.75747371417238],[0.5551052893286973,-77.7585036824341]]', 0x0000000001030000000100000004000000d67c0773f07253c0fd734c687251e23fb27c07737a7053c079fe442cba63e23fc67c07538b7053c0b91bf02a6cc3e13fd67c0773f07253c0fd734c687251e23f, 'ACTIVE', '2020-07-27 01:48:40', '2020-07-27 01:48:40', NULL, 'none-id'),
(20, 'Sin registro', 3, '#e5bedd', NULL, '[[0.33538922308889224,-78.2347798133667],[0.34251304557036877,-78.20533988721924],[0.32242900270425207,-78.1959843421753]]', 0x0000000001030000000100000004000000060be9a1068f53c0953f265c0477d53fe00ae949248d53c0f0654bd6bbebd53fdc0ae9018b8c53c0b4627941ada2d43f060be9a1068f53c0953f265c0477d53f, 'ACTIVE', '2020-07-27 01:49:26', '2020-07-27 01:49:26', NULL, 'none-id'),
(21, 'Sin registro', 4, '#e5bedd', NULL, '[[0.3016286134508392,-78.2825102678589],[0.3193953049827574,-78.27504299796144],[0.3081516534151998,-78.23573254263917]]', 0x0000000001030000000100000004000000454ff2a5149253c0aac99319e24dd33f1f4ff24d9a9153c0cf665901f970d43f324ff23d168f53c0641a68b6c1b8d33f454ff2a5149253c0aac99319e24dd33f, 'ACTIVE', '2020-07-27 01:49:58', '2020-07-27 01:49:58', NULL, 'none-id'),
(22, 'Sin registro', 2, '#e5bedd', NULL, '[[0.3499792603059938,-78.15326457264403],[0.35040840573245896,-78.09592967274169],[0.33049603763935254,-78.13043360950927]]', 0x00000000010300000001000000040000000dc93516cf8953c04ab852690f66d63f25c935b6238653c09252b760176dd63ffcc83506598853c0089747dad826d53f0dc93516cf8953c04ab852690f66d63f, 'ACTIVE', '2020-07-27 01:50:21', '2020-07-27 01:50:21', NULL, 'none-id'),
(23, 'Sin registro', 106, '#e5bedd', NULL, '[[0.3970092922055667,-77.96046575093995],[0.3981250642942425,-77.90991147542725],[0.37426467510040734,-77.93557485128174]]', 0x0000000001030000000100000004000000c94d5745787d53c036c98ea99968d93fb34d57fd3b7a53c06825b78ce17ad93fd74d5775e07b53c049ade6d2f3f3d73fc94d5745787d53c036c98ea99968d93f, 'ACTIVE', '2020-07-27 01:50:55', '2020-07-27 01:50:55', NULL, 'none-id'),
(24, 'Sin registro', 107, '#e5bedd', NULL, '[[0.42724758074649016,-78.21046294615479],[0.42922163144264264,-78.18402709410401],[0.41917971613256977,-78.18497123167725]]', 0x00000000010300000001000000040000005bb09339788d53c0997ba63c0658db3f4bb09319c78b53c0b70a72015e78db3f3ab09391d68b53c0a2e6fb28d7d3da3f5bb09339788d53c0997ba63c0658db3f, 'ACTIVE', '2020-07-27 01:51:21', '2020-07-27 01:51:21', NULL, 'none-id'),
(25, 'Sin registro', 178, '#e5bedd', NULL, '[[-0.1773058194818411,-78.49062624779052],[-0.17043939602472563,-78.44487849083251],[-0.19155363991854032,-78.4537190517456]]', 0x00000000010300000001000000040000009434a26b669f53c058510804f5b1c6bf9534a2e3789c53c09327f047f5d0c5bf8f34a2bb099d53c037a07065d484c8bf9434a26b669f53c058510804f5b1c6bf, 'ACTIVE', '2020-07-27 01:52:12', '2020-07-27 01:52:12', NULL, 'none-id'),
(26, 'Sin registro', 179, '#e5bedd', NULL, '[[0.04184845467835922,-78.17012756949462],[0.05111816597312691,-78.12575310355224],[0.030347144724432343,-78.12970131522216]]', 0x000000000103000000010000000400000041c8be5ee38a53c016a07620296da53f16c8be560c8853c0be122c06292caa3f1bc8be064d8853c09e41796852139f3f41c8be5ee38a53c016a07620296da53f, 'ACTIVE', '2020-07-27 01:52:34', '2020-07-27 01:52:34', NULL, 'none-id'),
(27, 'Sin registro', 181, '#e5bedd', NULL, '[[0.08220280601059479,-79.073644822937],[0.09378993526952253,-79.02557963739012],[0.0690707221450119,-79.03244609246825]]', 0x00000000010300000001000000040000002f82c698b6c453c0cd76743b3e0bb53f2682c618a3c153c0ec32ad009e02b83f1e82c69813c253c07253b96c9eaeb13f2f82c698b6c453c0cd76743b3e0bb53f, 'ACTIVE', '2020-07-27 01:53:03', '2020-07-27 01:53:03', NULL, 'none-id'),
(28, 'Sin registro', 182, '#e5bedd', NULL, '[[0.11580869488155088,-79.28464852923585],[0.13160150470171353,-79.24645387286378],[0.10619567582393855,-79.24430810565187]]', 0x000000000103000000010000000400000014fb76ae37d253c0c1d31b7da3a5bd3f19fb76e6c5cf53c08e2c666f51d8c03f13fb76bea2cf53c0e3f3a3caa32fbb3f14fb76ae37d253c0c1d31b7da3a5bd3f, 'ACTIVE', '2020-07-27 01:53:23', '2020-07-27 01:53:23', NULL, 'none-id'),
(29, 'Sin registro', 183, '#e5bedd', NULL, '[[0.027748020379505172,-78.914918278479],[0.035129458472160056,-78.86676726224366],[0.015045079396745178,-78.8743203628296]]', 0x00000000010300000001000000040000001e2565058eba53c0e91f3c20fa699c3f3625651d79b753c0633a87067dfca13f3b2565ddf4b753c02846cc5ff4cf8e3f1e2565058eba53c0e91f3c20fa699c3f, 'ACTIVE', '2020-07-27 01:53:57', '2020-07-27 01:53:57', NULL, 'none-id'),
(30, 'Julio Andrade', 6, '#e5bedd', NULL, '[[0.7685111958183863,-77.81431054565819],[0.795116231990742,-77.75937890503319],[0.7546078525605212,-77.77036523315819]]', 0x0000000001030000000100000004000000e698faa91d7453c077cb94caa497e83fe698faa9997053c043689d989771e93fe698faa94d7153c0d0ab015ebf25e83fe698faa91d7453c077cb94caa497e83f, 'ACTIVE', '2020-07-31 14:41:33', '2020-07-31 14:46:57', NULL, 'none-id'),
(31, 'El Carmelo', 6, '#e5bedd', NULL, '[[0.7825907871309515,-77.81736632249496],[0.7743518015755979,-77.6930834855809],[0.6995136371567818,-77.74938841722152],[0.7839639498214088,-77.82354613206527],[0.8141734136839461,-77.78990050218246]]', 0x0000000001030000000100000006000000f1fdd5ba4f7453c0431b9cd5fb0ae93ff5fdd57a5b6c53c051b5eb6d7dc7e83f0ffed5faf56f53c05e38566c6a62e63fdbfdd5fab47453c0e93ab7903b16e93fcdfdd5ba8d7253c0a4722167b50dea3ff1fdd5ba4f7453c0431b9cd5fb0ae93f, 'ACTIVE', '2020-07-31 14:42:52', '2020-07-31 14:46:57', NULL, 'none-id'),
(32, 'Maldonado', 6, '#e5bedd', NULL, '[[0.8264210430190453,-77.75603649999455],[0.8339733507241377,-77.71415112401799],[0.8017042999160229,-77.7368104257758],[0.830540485373964,-77.74985669042424]]', 0x0000000001030000000100000005000000e583eae6627053c0e4c60f8b0a72ea3fc683eaa6b46d53c0221063e1e8afea3fd383eae6276f53c0d075a6c68fa7e93fb483eaa6fd6f53c08aecd5a3c993ea3fe583eae6627053c0e4c60f8b0a72ea3f, 'ACTIVE', '2020-07-31 14:43:32', '2020-07-31 14:46:57', NULL, 'none-id'),
(33, 'Pioter', 6, '#e5bedd', NULL, '[[0.8304957739278666,-77.6912247669671],[0.8170217485745882,-77.6816975605462],[0.8179657900482247,-77.69543047070245],[0.8310965255865157,-77.691568089721]]', 0x0000000001030000000100000005000000be13ce063d6c53c0ae908fdf6b93ea3fb713ceeea06b53c085f447cb0a25ea3fa513ceee816c53c00220b097c62cea3fc513cea6426c53c09bd3a6bd5798ea3fbe13ce063d6c53c0ae908fdf6b93ea3f, 'ACTIVE', '2020-07-31 14:44:11', '2020-07-31 14:46:57', NULL, 'none-id'),
(34, 'Tobar Donoso', 6, '#e5bedd', NULL, '[[0.821017235860916,-77.7534520161126],[0.8318307776351835,-77.74186487316827],[0.8028229569129044,-77.75061960339288]]', 0x0000000001030000000100000004000000e113ce8e387053c0f4322ff0c545ea3fb213ceb67a6f53c0a5fa37945b9eea3fce13ce260a7053c0d0670dc5b9b0e93fe113ce8e387053c0f4322ff0c545ea3f, 'ACTIVE', '2020-07-31 14:44:48', '2020-07-31 14:46:57', NULL, 'none-id'),
(35, 'Tufiño', 6, '#e5bedd', NULL, '[[0.8296375571142417,-77.76160593151788],[0.8238874996707007,-77.73199434399346],[0.8054357670465262,-77.75448198437432]]', 0x0000000001030000000100000004000000ce13ce26be7053c008d9ea0f648cea3fa413cefed86e53c05c675551495dea3fae13ce6e497053c0eccacf3a21c6e93fce13ce26be7053c008d9ea0f648cea3f, 'ACTIVE', '2020-07-31 14:45:23', '2020-07-31 14:46:57', NULL, 'none-id'),
(36, 'Urbina', 6, '#e5bedd', NULL, '[[0.8315716915271679,-77.7913321258852],[0.8336314105574412,-77.7441252472231],[0.7963846609581579,-77.7609480621645]]', 0x0000000001030000000100000004000000d13c802fa57253c0606f6c3c3c9cea3fd83c80bf9f6f53c0d766a8c71badea3f023d805fb37053c0383e3baffb7be93fd13c802fa57253c0606f6c3c3c9cea3f, 'ACTIVE', '2020-07-31 14:46:18', '2020-07-31 14:46:57', NULL, 'none-id'),
(37, 'Santa Marta de Cuba', 6, '#e5bedd', NULL, '[[0.81738828727564,-77.8087556010715],[0.802283595069792,-77.6769196635715],[0.7658947914361117,-77.69786235155978],[0.7923281991995731,-77.86609050097384]]', 0x0000000001030000000100000005000000a243daa6c27353c0386f3f7b0b28ea3fa243daa6526b53c050255ea54eace93fd543dac6a96c53c079a22ccb3582e83fd043da066e7753c0df57e8aac05ae93fa243daa6c27353c0386f3f7b0b28ea3f, 'ACTIVE', '2020-07-31 14:46:57', '2020-07-31 14:46:57', NULL, 'none-id'),
(38, 'Los Andes', 7, '#e5bedd', NULL, '[[0.505419146267689,-77.94539216535577],[0.5132294303139098,-77.92436364667901],[0.48524968833363424,-77.91629556196222],[0.49305999633706504,-77.95191529767999]]', 0x00000000010300000001000000050000005006244e817c53c036beffc5642ce03f3f0624c6287b53c0e25f5120606ce03f31062496a47a53c0666072b5540edf3f4106242eec7c53c03af3ce834b8edf3f5006244e817c53c036beffc5642ce03f, 'ACTIVE', '2020-07-31 14:53:10', '2020-07-31 14:57:51', NULL, 'none-id'),
(39, 'Garcia Moreno', 7, '#e5bedd', NULL, '[[0.511018515557544,-77.92083376257777],[0.4972003096062016,-77.87954920142055],[0.4824379706957606,-77.92203539221644]]', 0x0000000001030000000100000004000000cfd4bbf0ee7a53c0120b7f80435ae03fdfd4bb884a7853c00676543f21d2df3fa0d4bba0027b53c04c299f8243e0de3fcfd4bbf0ee7a53c0120b7f80435ae03f, 'ACTIVE', '2020-07-31 14:56:34', '2020-07-31 14:57:51', NULL, 'none-id'),
(40, 'Monte Olivo', 7, '#e5bedd', NULL, '[[0.4878721982842548,-77.90359262006768],[0.5041794179193684,-77.87561181562432],[0.4902753700083286,-77.86943200605401]]', 0x000000000103000000010000000400000056062476d47953c0f48a10504c39df3f290624060a7853c0d9f5e8df3c22e03f3f0624c6a47753c0bc150ef2ab60df3f56062476d47953c0f48a10504c39df3f, 'ACTIVE', '2020-07-31 14:57:04', '2020-07-31 14:57:51', NULL, 'none-id'),
(41, 'San Vicente de Pusir', 7, '#e5bedd', NULL, '[[0.49763567652737084,-77.94800523676622],[0.49471754254438155,-77.87195924677599],[0.48081347489604076,-77.91470292963731]]', 0x00000000010300000001000000040000003016281eac7c53c04181004f43d9df3f4116282ece7753c015147fc473a9df3f2a16287e8a7a53c01ce589e1a5c5de3f3016281eac7c53c04181004f43d9df3f, 'ACTIVE', '2020-07-31 14:57:51', '2020-07-31 14:57:51', NULL, 'none-id'),
(42, '27 de septiembre', 8, '#e5bedd', NULL, '[[0.5059313233342333,-77.95679202727482],[0.49202727911922695,-77.90529361418888],[0.48018307041973923,-77.9586803024213]]', 0x00000000010300000001000000040000000f8ea0143c7d53c0b8c2f7e29630e03f0b8ea054f07953c02da523fc5f7ddf3fed8da0045b7d53c0e7ebe2c551bbde3f0f8ea0143c7d53c0b8c2f7e29630e03f, 'ACTIVE', '2020-07-31 15:00:39', '2020-07-31 15:02:25', NULL, 'none-id'),
(43, 'El Goaltal', 8, '#e5bedd', NULL, '[[0.49106867390987624,-77.96324196988145],[0.4905537086739361,-77.92135659390489],[0.466865265656445,-77.92993966275255]]', 0x000000000103000000010000000400000081b1a5c1a57d53c00d1da24dab6ddf3fa9b1a581f77a53c0cce8eb613b65df3fc1b1a521847b53c02b7fe8d91ee1dd3f81b1a5c1a57d53c00d1da24dab6ddf3f, 'ACTIVE', '2020-07-31 15:01:17', '2020-07-31 15:02:25', NULL, 'none-id'),
(44, 'La Libertad', 8, '#e5bedd', NULL, '[[0.5032838029756448,-77.94571137076949],[0.5217366626606419,-77.9313776457939],[0.497705021078201,-77.91815971976851]]', 0x0000000001030000000100000004000000203afc88867c53c055614ca2e61ae03f493afcb09b7b53c0610de81511b2e03f643afc20c37a53c0ba7e252966dadf3f203afc88867c53c055614ca2e61ae03f, 'ACTIVE', '2020-07-31 15:01:54', '2020-07-31 15:02:25', NULL, 'none-id'),
(45, 'San Isidro', 8, '#e5bedd', NULL, '[[0.5082454804903404,-77.94681015762627],[0.5018084289241144,-77.91144791397393],[0.4914233057463509,-77.91788521560967],[0.5009501549016235,-77.95522156509698]]', 0x00000000010300000001000000050000008ea1a189987c53c05477a1068c43e03fa6a1a129557a53c018c2e28cd00ee03fb8a1a1a1be7a53c0dd0eabbc7a73df3fa3a1a159227d53c0a050879ec807e03f8ea1a189987c53c05477a1068c43e03f, 'ACTIVE', '2020-07-31 15:02:25', '2020-07-31 15:02:25', NULL, 'none-id');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accounting_account`
--
ALTER TABLE `accounting_account`
  ADD CONSTRAINT `fk_accounting_account_accounting_account_type1` FOREIGN KEY (`accounting_account_type_id`) REFERENCES `accounting_account_type` (`id`),
  ADD CONSTRAINT `fk_accounting_account_accounting_level1` FOREIGN KEY (`accounting_level_id`) REFERENCES `accounting_level` (`id`);

--
-- Filtros para la tabla `accounting_account_by_balances`
--
ALTER TABLE `accounting_account_by_balances`
  ADD CONSTRAINT `fk_accounting_account_balances_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`);

--
-- Filtros para la tabla `accounting_config_modules_account_by_account`
--
ALTER TABLE `accounting_config_modules_account_by_account`
  ADD CONSTRAINT `fk_accounting_config_modules_account_by_account_accounting_ac1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_accounting_config_modules_account_by_modules_accounting_co1` FOREIGN KEY (`accounting_config_modules_types_id`) REFERENCES `accounting_config_modules_types` (`id`);

--
-- Filtros para la tabla `account_gamification_by_movement`
--
ALTER TABLE `account_gamification_by_movement`
  ADD CONSTRAINT `fk_account_by_movement_account_gamification1` FOREIGN KEY (`account_gamification_id`) REFERENCES `account_gamification` (`id`);

--
-- Filtros para la tabla `account_gamification_movement_by_business`
--
ALTER TABLE `account_gamification_movement_by_business`
  ADD CONSTRAINT `fk_account_gamification_movement_by_business_account_gamifica1` FOREIGN KEY (`account_gamification_by_movement_id`) REFERENCES `account_gamification_by_movement` (`id`),
  ADD CONSTRAINT `fk_account_gamification_movement_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `fk_actions_actions1` FOREIGN KEY (`parent_id`) REFERENCES `actions` (`id`);

--
-- Filtros para la tabla `actions_by_role`
--
ALTER TABLE `actions_by_role`
  ADD CONSTRAINT `fk_actions_by_role_actions1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `fk_actions_by_role_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `allergies_by_history_clinic`
--
ALTER TABLE `allergies_by_history_clinic`
  ADD CONSTRAINT `fk_allergies_by_history_clinic_allergies1` FOREIGN KEY (`allergies_id`) REFERENCES `allergies` (`id`),
  ADD CONSTRAINT `fk_allergies_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `allowed_actions`
--
ALTER TABLE `allowed_actions`
  ADD CONSTRAINT `fk_allowed_actions_actions1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Filtros para la tabla `antecedent_by_history_clinic`
--
ALTER TABLE `antecedent_by_history_clinic`
  ADD CONSTRAINT `fk_antecedent_by_history_clinic_antecedent1` FOREIGN KEY (`antecedent_id`) REFERENCES `antecedent` (`id`),
  ADD CONSTRAINT `fk_antecedent_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `antecedent_family_members_by_history_clinic`
--
ALTER TABLE `antecedent_family_members_by_history_clinic`
  ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_antecedent1` FOREIGN KEY (`antecedent_id`) REFERENCES `antecedent` (`id`),
  ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`),
  ADD CONSTRAINT `fk_antecedent_family_members_by_history_clinic_people_relatio1` FOREIGN KEY (`people_relationship_id`) REFERENCES `people_relationship` (`id`);

--
-- Filtros para la tabla `askwer_field`
--
ALTER TABLE `askwer_field`
  ADD CONSTRAINT `fk_askwer_field_askwer_section1` FOREIGN KEY (`askwer_section_id`) REFERENCES `askwer_section` (`id`);

--
-- Filtros para la tabla `askwer_field_value`
--
ALTER TABLE `askwer_field_value`
  ADD CONSTRAINT `fk_askwer_field_value_askwer_entity_answer1` FOREIGN KEY (`askwer_entity_answer_id`) REFERENCES `askwer_entity_answer` (`id`),
  ADD CONSTRAINT `fk_askwer_field_value_askwer_field1` FOREIGN KEY (`askwer_field_id`) REFERENCES `askwer_field` (`id`);

--
-- Filtros para la tabla `askwer_option`
--
ALTER TABLE `askwer_option`
  ADD CONSTRAINT `fk_askwer_option_askwer_field1` FOREIGN KEY (`askwer_field_id`) REFERENCES `askwer_field` (`id`);

--
-- Filtros para la tabla `askwer_section`
--
ALTER TABLE `askwer_section`
  ADD CONSTRAINT `fk_askwer_section_askwer_form1` FOREIGN KEY (`askwer_form_id`) REFERENCES `askwer_form` (`id`);

--
-- Filtros para la tabla `average_kardex`
--
ALTER TABLE `average_kardex`
  ADD CONSTRAINT `fk_average_kardex_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_average_kardex_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `fk_business_business_subcategories` FOREIGN KEY (`business_subcategories_id`) REFERENCES `business_subcategories` (`id`);

--
-- Filtros para la tabla `business_academic_offerings_by_data`
--
ALTER TABLE `business_academic_offerings_by_data`
  ADD CONSTRAINT `fk_business_academic_offerings_by_data_business_by_academic_o1` FOREIGN KEY (`business_by_academic_offerings_id`) REFERENCES `business_by_academic_offerings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `business_amenities`
--
ALTER TABLE `business_amenities`
  ADD CONSTRAINT `fk_business_amenities_business_subcategories1` FOREIGN KEY (`business_subcategories_id`) REFERENCES `business_subcategories` (`id`);

--
-- Filtros para la tabla `business_by_about`
--
ALTER TABLE `business_by_about`
  ADD CONSTRAINT `fk_business_by_about_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_counter`
--
ALTER TABLE `business_by_counter`
  ADD CONSTRAINT `fk_business_by_counter_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_coupon`
--
ALTER TABLE `business_by_coupon`
  ADD CONSTRAINT `fk_business_by_coupon_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_daily_book_seat`
--
ALTER TABLE `business_by_daily_book_seat`
  ADD CONSTRAINT `fk_business_by_daily_book_seat_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_daily_book_seat_daily_book_seat1` FOREIGN KEY (`daily_book_seat_id`) REFERENCES `daily_book_seat` (`id`),
  ADD CONSTRAINT `fk_business_by_daily_book_seat_diary_book1` FOREIGN KEY (`diary_book_id`) REFERENCES `diary_book` (`id`);

--
-- Filtros para la tabla `business_by_discount`
--
ALTER TABLE `business_by_discount`
  ADD CONSTRAINT `fk_business_by_discount_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_documents`
--
ALTER TABLE `business_by_documents`
  ADD CONSTRAINT `fk_business_by_documents_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_employee_profile`
--
ALTER TABLE `business_by_employee_profile`
  ADD CONSTRAINT `fk_business_by_employee_profile_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_employee_profile_human_resources_employee_prof1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`);

--
-- Filtros para la tabla `business_by_gallery`
--
ALTER TABLE `business_by_gallery`
  ADD CONSTRAINT `fk_business_by_gallery_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_gamification`
--
ALTER TABLE `business_by_gamification`
  ADD CONSTRAINT `fk_business_by_gamification_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_gamification_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Filtros para la tabla `business_by_invoice_buy`
--
ALTER TABLE `business_by_invoice_buy`
  ADD CONSTRAINT `fk_business_by_invoice_buy_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_invoice_buy_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `business_by_invoice_sale`
--
ALTER TABLE `business_by_invoice_sale`
  ADD CONSTRAINT `fk_business_by_invoice_buy_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_invoice_sale_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `business_by_language`
--
ALTER TABLE `business_by_language`
  ADD CONSTRAINT `fk_business_by_language_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_language_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Filtros para la tabla `business_by_lodging_by_price`
--
ALTER TABLE `business_by_lodging_by_price`
  ADD CONSTRAINT `fk_business_by_lodging_by_price_lodging_type_of_room_by_price1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`),
  ADD CONSTRAINT `fk_business_by_room_by_price_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_panorama`
--
ALTER TABLE `business_by_panorama`
  ADD CONSTRAINT `fk_business_by_panorama_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_panorama_panorama1` FOREIGN KEY (`panorama_id`) REFERENCES `panorama` (`id`),
  ADD CONSTRAINT `fk_business_by_panorama_routes_map_by_routes_drawing1` FOREIGN KEY (`routes_map_by_routes_drawing_id`) REFERENCES `routes_map_by_routes_drawing` (`id`);

--
-- Filtros para la tabla `business_by_products`
--
ALTER TABLE `business_by_products`
  ADD CONSTRAINT `fk_business_by_products_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_promotion`
--
ALTER TABLE `business_by_promotion`
  ADD CONSTRAINT `fk_business_promotion_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_qualification`
--
ALTER TABLE `business_by_qualification`
  ADD CONSTRAINT `fk_business_by_qualification_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_routes_map`
--
ALTER TABLE `business_by_routes_map`
  ADD CONSTRAINT `fk_business_by_routes_map_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_routes_map_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Filtros para la tabla `business_by_schedule`
--
ALTER TABLE `business_by_schedule`
  ADD CONSTRAINT `fk_business_by_schedule_schedule_days_category1` FOREIGN KEY (`schedule_days_category_id`) REFERENCES `schedule_days_category` (`id`),
  ADD CONSTRAINT `fk_business_shedule_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_scheduling_date`
--
ALTER TABLE `business_by_scheduling_date`
  ADD CONSTRAINT `fk_business_by_scheduling_date_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_scheduling_date_scheduling_date1` FOREIGN KEY (`scheduling_date_id`) REFERENCES `scheduling_date` (`id`);

--
-- Filtros para la tabla `business_by_shipping_rate`
--
ALTER TABLE `business_by_shipping_rate`
  ADD CONSTRAINT `fk_business_by_shipping_rate_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_shipping_rate_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Filtros para la tabla `business_by_social_networks`
--
ALTER TABLE `business_by_social_networks`
  ADD CONSTRAINT `fk_business_by_social_networks_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_by_tax`
--
ALTER TABLE `business_by_tax`
  ADD CONSTRAINT `fk_business_by_tax_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_by_tax_taxes1` FOREIGN KEY (`taxes_id`) REFERENCES `taxes` (`id`);

--
-- Filtros para la tabla `business_disbursement`
--
ALTER TABLE `business_disbursement`
  ADD CONSTRAINT `fk_business_disbursement_bank1` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`id`),
  ADD CONSTRAINT `fk_business_disbursement_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_discount_by_product`
--
ALTER TABLE `business_discount_by_product`
  ADD CONSTRAINT `fk_business_promotion_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `business_location`
--
ALTER TABLE `business_location`
  ADD CONSTRAINT `fk_business_location_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_business_location_zones1` FOREIGN KEY (`zones_id`) REFERENCES `zones` (`id`);

--
-- Filtros para la tabla `business_panorama_by_points`
--
ALTER TABLE `business_panorama_by_points`
  ADD CONSTRAINT `fk_business_panorama_by_breakdown_business_by_panorama1` FOREIGN KEY (`business_by_panorama_id`) REFERENCES `business_by_panorama` (`id`),
  ADD CONSTRAINT `fk_business_panorama_by_breakdown_panorama_points1` FOREIGN KEY (`panorama_points_id`) REFERENCES `panorama_points` (`id`),
  ADD CONSTRAINT `fk_business_panorama_by_points_panorama1` FOREIGN KEY (`panorama_id`) REFERENCES `panorama` (`id`);

--
-- Filtros para la tabla `business_subcategories`
--
ALTER TABLE `business_subcategories`
  ADD CONSTRAINT `fk_business_subcategories_business_categories1` FOREIGN KEY (`business_categories_id`) REFERENCES `business_categories` (`id`);

--
-- Filtros para la tabla `bussiness_by_repair`
--
ALTER TABLE `bussiness_by_repair`
  ADD CONSTRAINT `fk_bussiness_by_repair_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_bussiness_by_repair_repair1` FOREIGN KEY (`repair_id`) REFERENCES `repair` (`id`);

--
-- Filtros para la tabla `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_cities_provinces1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Filtros para la tabla `clinical_by_history_clinic`
--
ALTER TABLE `clinical_by_history_clinic`
  ADD CONSTRAINT `fk_clinical_by_history_clinic_clinical_exam1` FOREIGN KEY (`clinical_exam_id`) REFERENCES `clinical_exam` (`id`),
  ADD CONSTRAINT `fk_clinical_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `counter_by_entity`
--
ALTER TABLE `counter_by_entity`
  ADD CONSTRAINT `fk_counter_by_schedule_entity_business_by_counter1` FOREIGN KEY (`business_by_counter_id`) REFERENCES `business_by_counter` (`id`);

--
-- Filtros para la tabla `counter_by_log_user_to_business`
--
ALTER TABLE `counter_by_log_user_to_business`
  ADD CONSTRAINT `fk_counter_by_log_user_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_course_course_faculty1` FOREIGN KEY (`course_faculty_id`) REFERENCES `course_faculty` (`id`),
  ADD CONSTRAINT `fk_course_course_subject_matter1` FOREIGN KEY (`course_subject_matter_id`) REFERENCES `course_subject_matter` (`id`);

--
-- Filtros para la tabla `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_customer_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`),
  ADD CONSTRAINT `fk_customer_ruc_type1` FOREIGN KEY (`ruc_type_id`) REFERENCES `ruc_type` (`id`);

--
-- Filtros para la tabla `customer_by_information`
--
ALTER TABLE `customer_by_information`
  ADD CONSTRAINT `fk_customer_by_information_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_customer_by_information_people_nationality1` FOREIGN KEY (`people_nationality_id`) REFERENCES `people_nationality` (`id`),
  ADD CONSTRAINT `fk_customer_by_information_people_profession1` FOREIGN KEY (`people_profession_id`) REFERENCES `people_profession` (`id`);

--
-- Filtros para la tabla `customer_by_profile`
--
ALTER TABLE `customer_by_profile`
  ADD CONSTRAINT `fk_customer_by_profile_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Filtros para la tabla `customer_by_student`
--
ALTER TABLE `customer_by_student`
  ADD CONSTRAINT `fk_customer_by_student_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Filtros para la tabla `customer_profile_by_location`
--
ALTER TABLE `customer_profile_by_location`
  ADD CONSTRAINT `fk_users_by_location_customer_by_profile1` FOREIGN KEY (`customer_by_profile_id`) REFERENCES `customer_by_profile` (`id`),
  ADD CONSTRAINT `fk_users_by_location_zones1` FOREIGN KEY (`zones_id`) REFERENCES `zones` (`id`);

--
-- Filtros para la tabla `dental_piece_by_odontogram`
--
ALTER TABLE `dental_piece_by_odontogram`
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_dental_piece1` FOREIGN KEY (`dental_piece_id`) REFERENCES `dental_piece` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_odontogram_by_patient1` FOREIGN KEY (`odontogram_by_patient_id`) REFERENCES `odontogram_by_patient` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_reference_piece1` FOREIGN KEY (`reference_piece_id`) REFERENCES `reference_piece` (`id`),
  ADD CONSTRAINT `fk_dental_piece_by_odontogram_reference_piece_position1` FOREIGN KEY (`reference_piece_position_id`) REFERENCES `reference_piece_position` (`id`);

--
-- Filtros para la tabla `diary_book`
--
ALTER TABLE `diary_book`
  ADD CONSTRAINT `fk_diary_book_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`);

--
-- Filtros para la tabla `discount_by_customers`
--
ALTER TABLE `discount_by_customers`
  ADD CONSTRAINT `fk_discount_by_customers_business_by_discount1` FOREIGN KEY (`business_by_discount_id`) REFERENCES `business_by_discount` (`id`),
  ADD CONSTRAINT `fk_discount_by_customers_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Filtros para la tabla `discount_by_products`
--
ALTER TABLE `discount_by_products`
  ADD CONSTRAINT `fk_discount_by_products_business_by_discount1` FOREIGN KEY (`business_by_discount_id`) REFERENCES `business_by_discount` (`id`),
  ADD CONSTRAINT `fk_discount_by_products_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `educational_institution_askwer_type`
--
ALTER TABLE `educational_institution_askwer_type`
  ADD CONSTRAINT `fk_educational_institution_askwer_type_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `educational_institution_by_business`
--
ALTER TABLE `educational_institution_by_business`
  ADD CONSTRAINT `fk_educational_institution_by_askwer_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_educational_institution_by_askwer_educational_institution_1` FOREIGN KEY (`educational_institution_askwer_type_id`) REFERENCES `educational_institution_askwer_type` (`id`),
  ADD CONSTRAINT `fk_educational_institution_by_business_askwer_form1` FOREIGN KEY (`askwer_form_id`) REFERENCES `askwer_form` (`id`);

--
-- Filtros para la tabla `educational_institution_by_course`
--
ALTER TABLE `educational_institution_by_course`
  ADD CONSTRAINT `fk_educational_institution_by_course_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Filtros para la tabla `educational_institution_course_activities_by_askwer`
--
ALTER TABLE `educational_institution_course_activities_by_askwer`
  ADD CONSTRAINT `fk_educational_institution_course_activities_by_askwer_educat1` FOREIGN KEY (`educational_institution_by_business_id`) REFERENCES `educational_institution_by_business` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_activities_by_askwer_educat2` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`);

--
-- Filtros para la tabla `educational_institution_course_by_activities`
--
ALTER TABLE `educational_institution_course_by_activities`
  ADD CONSTRAINT `fk_educational_institution_course_by_activities_educational_i1` FOREIGN KEY (`educational_institution_course_by_supervisor_id`) REFERENCES `educational_institution_course_by_supervisor` (`id`);

--
-- Filtros para la tabla `educational_institution_course_by_students`
--
ALTER TABLE `educational_institution_course_by_students`
  ADD CONSTRAINT `fk_educational_institution_course_by_students_educational_ins1` FOREIGN KEY (`educational_institution_by_course_id`) REFERENCES `educational_institution_by_course` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_by_students_students_inform1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`);

--
-- Filtros para la tabla `educational_institution_course_by_supervisor`
--
ALTER TABLE `educational_institution_course_by_supervisor`
  ADD CONSTRAINT `fk_educational_institution_course_by_supervisor_business_by_e1` FOREIGN KEY (`business_by_employee_profile_id`) REFERENCES `business_by_employee_profile` (`id`),
  ADD CONSTRAINT `fk_educational_institution_course_by_supervisor_educational_i1` FOREIGN KEY (`educational_institution_by_course_id`) REFERENCES `educational_institution_by_course` (`id`);

--
-- Filtros para la tabla `educational_institution_students_course_by_activities`
--
ALTER TABLE `educational_institution_students_course_by_activities`
  ADD CONSTRAINT `fk_educational_institution_student_course_by_activities_educa1` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`),
  ADD CONSTRAINT `fk_educational_institution_student_course_by_activities_educa2` FOREIGN KEY (`educational_institution_course_by_students_id`) REFERENCES `educational_institution_course_by_students` (`id`);

--
-- Filtros para la tabla `educational_institution_test_by_answers`
--
ALTER TABLE `educational_institution_test_by_answers`
  ADD CONSTRAINT `fk_educational_institution_test_by_answers_askwer_entity_answ1` FOREIGN KEY (`askwer_entity_answer_id`) REFERENCES `askwer_entity_answer` (`id`),
  ADD CONSTRAINT `fk_educational_institution_test_by_answers_educational_instit1` FOREIGN KEY (`educational_institution_students_course_by_activities_id`) REFERENCES `educational_institution_students_course_by_activities` (`id`);

--
-- Filtros para la tabla `events_trails_by_kit`
--
ALTER TABLE `events_trails_by_kit`
  ADD CONSTRAINT `fk_events_trails_by_clothing_kit_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `events_trails_by_registration_points`
--
ALTER TABLE `events_trails_by_registration_points`
  ADD CONSTRAINT `fk_events_trails_by_registration_points_events_trails_registr1` FOREIGN KEY (`events_trails_registration_by_customer_id`) REFERENCES `events_trails_registration_by_customer` (`id`),
  ADD CONSTRAINT `fk_events_trails_by_registration_points_events_trails_registr2` FOREIGN KEY (`events_trails_registration_points_id`) REFERENCES `events_trails_registration_points` (`id`);

--
-- Filtros para la tabla `events_trails_distances`
--
ALTER TABLE `events_trails_distances`
  ADD CONSTRAINT `fk_events_trails_distances_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`),
  ADD CONSTRAINT `fk_events_trails_distances_events_trails_type_teams1` FOREIGN KEY (`events_trails_type_teams_id`) REFERENCES `events_trails_type_teams` (`id`);

--
-- Filtros para la tabla `events_trails_kit_pieces`
--
ALTER TABLE `events_trails_kit_pieces`
  ADD CONSTRAINT `fk_events_trails_kit_pieces_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `events_trails_project`
--
ALTER TABLE `events_trails_project`
  ADD CONSTRAINT `fk_events_trails_project_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_events_trails_project_events_trails_types1` FOREIGN KEY (`events_trails_types_id`) REFERENCES `events_trails_types` (`id`);

--
-- Filtros para la tabla `events_trails_project_by_routes_map`
--
ALTER TABLE `events_trails_project_by_routes_map`
  ADD CONSTRAINT `fk_events_by_routes_map_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`),
  ADD CONSTRAINT `fk_events_trails_project_by_routes_map_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `events_trails_registration_by_customer`
--
ALTER TABLE `events_trails_registration_by_customer`
  ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_dista1` FOREIGN KEY (`events_trails_distances_id`) REFERENCES `events_trails_distances` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_proje1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_customer_events_trails_type_1` FOREIGN KEY (`events_trails_type_of_categories_id`) REFERENCES `events_trails_type_of_categories` (`id`);

--
-- Filtros para la tabla `events_trails_registration_payments_by_business`
--
ALTER TABLE `events_trails_registration_payments_by_business`
  ADD CONSTRAINT `fk_events_trails_registration_by_business_events_trails_regis1` FOREIGN KEY (`events_trails_registration_points_id`) REFERENCES `events_trails_registration_points` (`id`),
  ADD CONSTRAINT `fk_events_trails_registration_by_business_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Filtros para la tabla `events_trails_registration_points`
--
ALTER TABLE `events_trails_registration_points`
  ADD CONSTRAINT `fk_events_trails_registration_points_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `events_trails_type_of_categories`
--
ALTER TABLE `events_trails_type_of_categories`
  ADD CONSTRAINT `fk_events_trails_type_of_categories_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `events_trails_type_teams`
--
ALTER TABLE `events_trails_type_teams`
  ADD CONSTRAINT `fk_events_trails_type_teams_events_trails_project1` FOREIGN KEY (`events_trails_project_id`) REFERENCES `events_trails_project` (`id`);

--
-- Filtros para la tabla `gamification_by_allies`
--
ALTER TABLE `gamification_by_allies`
  ADD CONSTRAINT `fk_gamification_by_allies_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_gamification_by_allies_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Filtros para la tabla `gamification_by_badges`
--
ALTER TABLE `gamification_by_badges`
  ADD CONSTRAINT `fk_gamification_by_badges_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Filtros para la tabla `gamification_by_levels`
--
ALTER TABLE `gamification_by_levels`
  ADD CONSTRAINT `fk_gamification_by_levels_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Filtros para la tabla `gamification_by_points`
--
ALTER TABLE `gamification_by_points`
  ADD CONSTRAINT `fk_gamification_by_points_gamification_by_process1` FOREIGN KEY (`gamification_by_process_id`) REFERENCES `gamification_by_process` (`id`);

--
-- Filtros para la tabla `gamification_by_process`
--
ALTER TABLE `gamification_by_process`
  ADD CONSTRAINT `fk_gamification_by_process_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`),
  ADD CONSTRAINT `fk_gamification_by_process_gamification_type_activity1` FOREIGN KEY (`gamification_type_activity_id`) REFERENCES `gamification_type_activity` (`id`);

--
-- Filtros para la tabla `gamification_by_rewards`
--
ALTER TABLE `gamification_by_rewards`
  ADD CONSTRAINT `fk_gamification_by_rewards_gamification1` FOREIGN KEY (`gamification_id`) REFERENCES `gamification` (`id`);

--
-- Filtros para la tabla `habits_by_history_clinic`
--
ALTER TABLE `habits_by_history_clinic`
  ADD CONSTRAINT `fk_habits_by_history_clinic_habits1` FOREIGN KEY (`habits_id`) REFERENCES `habits` (`id`),
  ADD CONSTRAINT `fk_habits_by_history_clinic_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `human_resources_department`
--
ALTER TABLE `human_resources_department`
  ADD CONSTRAINT `fk_human_resources_department_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `human_resources_employee_profile`
--
ALTER TABLE `human_resources_employee_profile`
  ADD CONSTRAINT `fk_human_resources_employee_profile_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_human_resources_department1` FOREIGN KEY (`human_resources_department_id`) REFERENCES `human_resources_department` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_nationality1` FOREIGN KEY (`people_nationality_id`) REFERENCES `people_nationality` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_profession1` FOREIGN KEY (`people_profession_id`) REFERENCES `people_profession` (`id`),
  ADD CONSTRAINT `fk_human_resources_employee_profile_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`);

--
-- Filtros para la tabla `information_address`
--
ALTER TABLE `information_address`
  ADD CONSTRAINT `fk_information_address_information_address_type1` FOREIGN KEY (`information_address_type_id`) REFERENCES `information_address_type` (`id`);

--
-- Filtros para la tabla `information_address_by_multimedia`
--
ALTER TABLE `information_address_by_multimedia`
  ADD CONSTRAINT `fk_information_address_by_multimedia_information_address1` FOREIGN KEY (`information_address_id`) REFERENCES `information_address` (`id`);

--
-- Filtros para la tabla `information_mail`
--
ALTER TABLE `information_mail`
  ADD CONSTRAINT `fk_information_mail_information_mail_type1` FOREIGN KEY (`information_mail_type_id`) REFERENCES `information_mail_type` (`id`);

--
-- Filtros para la tabla `information_phone`
--
ALTER TABLE `information_phone`
  ADD CONSTRAINT `fk_information_phone_information_phone_operator1` FOREIGN KEY (`information_phone_operator_id`) REFERENCES `information_phone_operator` (`id`),
  ADD CONSTRAINT `fk_information_phone_information_phone_type1` FOREIGN KEY (`information_phone_type_id`) REFERENCES `information_phone_type` (`id`);

--
-- Filtros para la tabla `information_social_network`
--
ALTER TABLE `information_social_network`
  ADD CONSTRAINT `fk_information_social_network_information_social_network_type1` FOREIGN KEY (`information_social_network_type_id`) REFERENCES `information_social_network_type` (`id`);

--
-- Filtros para la tabla `initial_status_product`
--
ALTER TABLE `initial_status_product`
  ADD CONSTRAINT `fk_initial_status_product_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_initial_status_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `invoice_buy`
--
ALTER TABLE `invoice_buy`
  ADD CONSTRAINT `fk_invoice_buy_voucher_type1` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_book_seat`
--
ALTER TABLE `invoice_buy_by_book_seat`
  ADD CONSTRAINT `fk_invoice_buy_by_book_seat_diary_book1` FOREIGN KEY (`diary_book_id`) REFERENCES `diary_book` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_book_seat_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_breakdown_payment`
--
ALTER TABLE `invoice_buy_by_breakdown_payment`
  ADD CONSTRAINT `fk_invoice_buy_by_breakdown_payment_invoice_buy_by_indebtedne1` FOREIGN KEY (`invoice_buy_by_indebtedness_paying_init_id`) REFERENCES `invoice_buy_by_indebtedness_paying_init` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_details`
--
ALTER TABLE `invoice_buy_by_details`
  ADD CONSTRAINT `fk_invoice_buy_details_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_details_devolution`
--
ALTER TABLE `invoice_buy_by_details_devolution`
  ADD CONSTRAINT `fk_invoice_buy_details_invoice_buy10` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_devolution_product`
--
ALTER TABLE `invoice_buy_by_devolution_product`
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_invoice_buy_by_details_d1` FOREIGN KEY (`invoice_buy_by_details_devolution_id`) REFERENCES `invoice_buy_by_details_devolution` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_product_defect1` FOREIGN KEY (`product_defect_id`) REFERENCES `product_defect` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_types_payments1` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_buy_by_indebtedness_paying_init`
  ADD CONSTRAINT `fk_invoice_buy_indebtedness_paying_init_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_overridden`
--
ALTER TABLE `invoice_buy_by_overridden`
  ADD CONSTRAINT `fk_invoice_buy_overridden_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_payment`
--
ALTER TABLE `invoice_buy_by_payment`
  ADD CONSTRAINT `fk_invoice_buy_by_payment_invoice_buy_by_breakdown_payment1` FOREIGN KEY (`invoice_buy_by_breakdown_payment_id`) REFERENCES `invoice_buy_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_payment_invoice_buy_by_indebtedness_paying_1` FOREIGN KEY (`invoice_buy_by_indebtedness_paying_init_id`) REFERENCES `invoice_buy_by_indebtedness_paying_init` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account1` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_pendient`
--
ALTER TABLE `invoice_buy_by_pendient`
  ADD CONSTRAINT `fk_invoice_buy_by_pendient_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_retention`
--
ALTER TABLE `invoice_buy_by_retention`
  ADD CONSTRAINT `fk_invoice_buy_by_retention_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_retention_retention_tax_sub_type1` FOREIGN KEY (`retention_tax_sub_type_id`) REFERENCES `retention_tax_sub_type` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_transactional_annex`
--
ALTER TABLE `invoice_buy_by_transactional_annex`
  ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_management_livelihood_b1` FOREIGN KEY (`management_livelihood_by_voucher_id`) REFERENCES `management_livelihood_by_voucher` (`id`);

--
-- Filtros para la tabla `invoice_buy_by_transactions`
--
ALTER TABLE `invoice_buy_by_transactions`
  ADD CONSTRAINT `fk_factura_buy_by_transactions_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_transactions_invoice_buy1` FOREIGN KEY (`invoice_buy_id`) REFERENCES `invoice_buy` (`id`);

--
-- Filtros para la tabla `invoice_sale`
--
ALTER TABLE `invoice_sale`
  ADD CONSTRAINT `fk_invoice_buy_voucher_type10` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_breakdown_payment`
--
ALTER TABLE `invoice_sale_by_breakdown_payment`
  ADD CONSTRAINT `fk_invoice_sale_by_breakdown_payment_invoice_sale_by_indebted1` FOREIGN KEY (`invoice_sale_by_indebtedness_paying_init_id`) REFERENCES `invoice_sale_by_indebtedness_paying_init` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_details`
--
ALTER TABLE `invoice_sale_by_details`
  ADD CONSTRAINT `fk_invoice_sale_by_details_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_details_devolution`
--
ALTER TABLE `invoice_sale_by_details_devolution`
  ADD CONSTRAINT `fk_invoice_sale_by_details_devolution_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_devolution_product`
--
ALTER TABLE `invoice_sale_by_devolution_product`
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_accounting_account10` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_product_defect10` FOREIGN KEY (`product_defect_id`) REFERENCES `product_defect` (`id`),
  ADD CONSTRAINT `fk_invoice_buy_by_devolution_product_types_payments10` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_devolution_product_invoice_sale_by_details1` FOREIGN KEY (`invoice_sale_by_details_devolution_id`) REFERENCES `invoice_sale_by_details_devolution` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_indebtedness_paying_init`
--
ALTER TABLE `invoice_sale_by_indebtedness_paying_init`
  ADD CONSTRAINT `fk_invoice_sale_by_indebtedness_paying_init_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_overridden`
--
ALTER TABLE `invoice_sale_by_overridden`
  ADD CONSTRAINT `fk_invoice_sale_by_overridden_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_payment`
--
ALTER TABLE `invoice_sale_by_payment`
  ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account10` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_payment_invoice_sale_by_breakdown_payment1` FOREIGN KEY (`invoice_sale_by_breakdown_payment_id`) REFERENCES `invoice_sale_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_payment_invoice_sale_by_indebtedness_payin1` FOREIGN KEY (`invoice_sale_by_indebtedness_paying_init_id`) REFERENCES `invoice_sale_by_indebtedness_paying_init` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_pendient`
--
ALTER TABLE `invoice_sale_by_pendient`
  ADD CONSTRAINT `fk_invoice_sale_by_pendient_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_retention`
--
ALTER TABLE `invoice_sale_by_retention`
  ADD CONSTRAINT `fk_invoice_buy_by_retention_retention_tax_sub_type10` FOREIGN KEY (`retention_tax_sub_type_id`) REFERENCES `retention_tax_sub_type` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_retention_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_transactional_annex`
--
ALTER TABLE `invoice_sale_by_transactional_annex`
  ADD CONSTRAINT `fk_invoice_buy_by_transactional_annex_management_livelihood_b10` FOREIGN KEY (`management_livelihood_by_voucher_id`) REFERENCES `management_livelihood_by_voucher` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_transactional_annex_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `invoice_sale_by_transactions`
--
ALTER TABLE `invoice_sale_by_transactions`
  ADD CONSTRAINT `fk_factura_buy_by_transactions_accounting_account10` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_invoice_sale_by_transactions_invoice_sale1` FOREIGN KEY (`invoice_sale_id`) REFERENCES `invoice_sale` (`id`);

--
-- Filtros para la tabla `language_product`
--
ALTER TABLE `language_product`
  ADD CONSTRAINT `fk_language_product_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `language_product_category`
--
ALTER TABLE `language_product_category`
  ADD CONSTRAINT `fk_language_product_category_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_category_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`);

--
-- Filtros para la tabla `language_product_color`
--
ALTER TABLE `language_product_color`
  ADD CONSTRAINT `fk_language_product_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_language_product_trademark_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Filtros para la tabla `language_product_measure_type`
--
ALTER TABLE `language_product_measure_type`
  ADD CONSTRAINT `fk_language_product_measure_type_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_measure_type_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`);

--
-- Filtros para la tabla `language_product_subcategory`
--
ALTER TABLE `language_product_subcategory`
  ADD CONSTRAINT `fk_language_product_category_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_subcategory_product_subcategory1` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`);

--
-- Filtros para la tabla `language_product_trademark`
--
ALTER TABLE `language_product_trademark`
  ADD CONSTRAINT `fk_language_product_trademark_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_product_trademark_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`);

--
-- Filtros para la tabla `language_template_about_us`
--
ALTER TABLE `language_template_about_us`
  ADD CONSTRAINT `fk_language_template_about_us_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_about_us_template_about_us1` FOREIGN KEY (`template_about_us_id`) REFERENCES `template_about_us` (`id`);

--
-- Filtros para la tabla `language_template_about_us_by_data`
--
ALTER TABLE `language_template_about_us_by_data`
  ADD CONSTRAINT `fk_language_template_about_us_by_data_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_about_us_by_data_template_about_us_by_da1` FOREIGN KEY (`template_about_us_by_data_id`) REFERENCES `template_about_us_by_data` (`id`);

--
-- Filtros para la tabla `language_template_policies`
--
ALTER TABLE `language_template_policies`
  ADD CONSTRAINT `fk_language_template_policies_template_policies1` FOREIGN KEY (`template_policies_id`) REFERENCES `template_policies` (`id`),
  ADD CONSTRAINT `fk_language_template_services_language10` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Filtros para la tabla `language_template_services`
--
ALTER TABLE `language_template_services`
  ADD CONSTRAINT `fk_language_template_services_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_services_template_services1` FOREIGN KEY (`template_services_id`) REFERENCES `template_services` (`id`);

--
-- Filtros para la tabla `language_template_services_by_data`
--
ALTER TABLE `language_template_services_by_data`
  ADD CONSTRAINT `fk_language_template_services_by_data_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_services_by_data_template_services_by_da1` FOREIGN KEY (`template_services_by_data_id`) REFERENCES `template_services_by_data` (`id`);

--
-- Filtros para la tabla `language_template_slider_by_images`
--
ALTER TABLE `language_template_slider_by_images`
  ADD CONSTRAINT `fk_language_template_services_language100` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_language_template_slider_by_images_template_slider_by_imag1` FOREIGN KEY (`template_slider_by_images_id`) REFERENCES `template_slider_by_images` (`id`);

--
-- Filtros para la tabla `lodging_arrived_by_social_networks`
--
ALTER TABLE `lodging_arrived_by_social_networks`
  ADD CONSTRAINT `fk_lodging_arrived_by_social_networks_lodging_by_arrived1` FOREIGN KEY (`lodging_by_arrived_id`) REFERENCES `lodging_by_arrived` (`id`);

--
-- Filtros para la tabla `lodging_by_arrived`
--
ALTER TABLE `lodging_by_arrived`
  ADD CONSTRAINT `fk_lodging_by_contact_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Filtros para la tabla `lodging_by_customer`
--
ALTER TABLE `lodging_by_customer`
  ADD CONSTRAINT `fk_lodging_by_customer_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_loding_by_customer_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Filtros para la tabla `lodging_by_customer_location`
--
ALTER TABLE `lodging_by_customer_location`
  ADD CONSTRAINT `fk_lodging_by_customer_location_information_address1` FOREIGN KEY (`information_address_id`) REFERENCES `information_address` (`id`),
  ADD CONSTRAINT `fk_loding_by_customer_location_lodging_by_customer1` FOREIGN KEY (`lodging_by_customer_id`) REFERENCES `lodging_by_customer` (`id`);

--
-- Filtros para la tabla `lodging_by_payment`
--
ALTER TABLE `lodging_by_payment`
  ADD CONSTRAINT `fk_lodging_by_payment_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Filtros para la tabla `lodging_by_payment_credit_card`
--
ALTER TABLE `lodging_by_payment_credit_card`
  ADD CONSTRAINT `fk_loding_by_payment_credit_card_lodging_by_payment1` FOREIGN KEY (`lodging_by_payment_id`) REFERENCES `lodging_by_payment` (`id`);

--
-- Filtros para la tabla `lodging_by_reasons`
--
ALTER TABLE `lodging_by_reasons`
  ADD CONSTRAINT `fk_lodging_by_reasons_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`);

--
-- Filtros para la tabla `lodging_by_type_of_room`
--
ALTER TABLE `lodging_by_type_of_room`
  ADD CONSTRAINT `fk_lodging_by_type_of_room_lodging1` FOREIGN KEY (`lodging_id`) REFERENCES `lodging` (`id`),
  ADD CONSTRAINT `fk_lodging_by_type_of_room_lodging_type_of_room_by_price1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`);

--
-- Filtros para la tabla `lodging_customer_additional_information`
--
ALTER TABLE `lodging_customer_additional_information`
  ADD CONSTRAINT `fk_lodging_customer_additional_information_information_mail1` FOREIGN KEY (`information_mail_id`) REFERENCES `information_mail` (`id`),
  ADD CONSTRAINT `fk_lodging_customer_additional_information_lodging_by_customer1` FOREIGN KEY (`lodging_by_customer_id`) REFERENCES `lodging_by_customer` (`id`);

--
-- Filtros para la tabla `lodging_type_of_room_by_price`
--
ALTER TABLE `lodging_type_of_room_by_price`
  ADD CONSTRAINT `fk_lodging_type_of_room_by_price_lodging_room_levels1` FOREIGN KEY (`lodging_room_levels_id`) REFERENCES `lodging_room_levels` (`id`),
  ADD CONSTRAINT `fk_lodging_type_of_room_by_price_lodging_type_of_room1` FOREIGN KEY (`lodging_type_of_room_id`) REFERENCES `lodging_type_of_room` (`id`);

--
-- Filtros para la tabla `lodging_type_of_room_price_by_features`
--
ALTER TABLE `lodging_type_of_room_price_by_features`
  ADD CONSTRAINT `fk_lodging_type_of_room_price_by_features_lodging_room_featur1` FOREIGN KEY (`lodging_room_features_id`) REFERENCES `lodging_room_features` (`id`),
  ADD CONSTRAINT `fk_lodging_type_of_room_price_by_features_lodging_type_of_roo1` FOREIGN KEY (`lodging_type_of_room_by_price_id`) REFERENCES `lodging_type_of_room_by_price` (`id`);

--
-- Filtros para la tabla `management_livelihood_by_voucher`
--
ALTER TABLE `management_livelihood_by_voucher`
  ADD CONSTRAINT `fk_management_livelihood_by_voucher_people_type_identification1` FOREIGN KEY (`people_type_identification_id`) REFERENCES `people_type_identification` (`id`),
  ADD CONSTRAINT `fk_management_livelihood_by_voucher_tax_support1` FOREIGN KEY (`tax_support_id`) REFERENCES `tax_support` (`id`),
  ADD CONSTRAINT `fk_management_livelihood_by_voucher_voucher_type1` FOREIGN KEY (`voucher_type_id`) REFERENCES `voucher_type` (`id`);

--
-- Filtros para la tabla `measure_subtype_by_equivalence`
--
ALTER TABLE `measure_subtype_by_equivalence`
  ADD CONSTRAINT `fk_measure_subtype_by_equivalence_product_measurent_subtype1` FOREIGN KEY (`measurent_subtype_id`) REFERENCES `product_measurement_subtype` (`id`),
  ADD CONSTRAINT `fk_measure_subtype_by_equivalence_product_measurent_subtype2` FOREIGN KEY (`product_measurent_subtype_id`) REFERENCES `product_measurement_subtype` (`id`);

--
-- Filtros para la tabla `medical_consultation_by_patient`
--
ALTER TABLE `medical_consultation_by_patient`
  ADD CONSTRAINT `fk_medical_consultation_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `odontogram_by_patient`
--
ALTER TABLE `odontogram_by_patient`
  ADD CONSTRAINT `fk_odontogram_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `order_event_kits_by_customer`
--
ALTER TABLE `order_event_kits_by_customer`
  ADD CONSTRAINT `fk_order_event_customer_events_trails_registration_by_customer1` FOREIGN KEY (`events_trails_registration_by_customer_id`) REFERENCES `events_trails_registration_by_customer` (`id`);

--
-- Filtros para la tabla `order_payments_document`
--
ALTER TABLE `order_payments_document`
  ADD CONSTRAINT `fk_order_payments_document_order_payments_manager1` FOREIGN KEY (`order_payments_manager_id`) REFERENCES `order_payments_manager` (`id`);

--
-- Filtros para la tabla `order_shopping_by_customer_delivery`
--
ALTER TABLE `order_shopping_by_customer_delivery`
  ADD CONSTRAINT `fk_order_shoping_by_customer_delivery_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);

--
-- Filtros para la tabla `order_shopping_by_delivery`
--
ALTER TABLE `order_shopping_by_delivery`
  ADD CONSTRAINT `fk_order_shoping_by_customer_delivery_people10` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_order_shopping_by_delivery_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Filtros para la tabla `order_shopping_cart`
--
ALTER TABLE `order_shopping_cart`
  ADD CONSTRAINT `fk_order_shopping_cart_order_payments_manager1` FOREIGN KEY (`order_payments_manager_id`) REFERENCES `order_payments_manager` (`id`),
  ADD CONSTRAINT `fk_order_shopping_cart_order_shopping_by_customer_delivery1` FOREIGN KEY (`order_shopping_by_customer_delivery_id`) REFERENCES `order_shopping_by_customer_delivery` (`id`);

--
-- Filtros para la tabla `order_shopping_cart_by_details`
--
ALTER TABLE `order_shopping_cart_by_details`
  ADD CONSTRAINT `fk_order_shopping_cart_by_details_order_shopping_cart1` FOREIGN KEY (`order_shopping_cart_id`) REFERENCES `order_shopping_cart` (`id`);

--
-- Filtros para la tabla `prices_by_zones`
--
ALTER TABLE `prices_by_zones`
  ADD CONSTRAINT `fk_price_by_zone_zones1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`),
  ADD CONSTRAINT `fk_product_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_product_product_subcategory1` FOREIGN KEY (`product_subcategory_id`) REFERENCES `product_subcategory` (`id`),
  ADD CONSTRAINT `fk_product_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`);

--
-- Filtros para la tabla `product_by_aplication`
--
ALTER TABLE `product_by_aplication`
  ADD CONSTRAINT `fk_product_by_aplication_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_aplication_product_aplication1` FOREIGN KEY (`product_aplication_id`) REFERENCES `product_aplication` (`id`);

--
-- Filtros para la tabla `product_by_color`
--
ALTER TABLE `product_by_color`
  ADD CONSTRAINT `fk_product_by_color_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`);

--
-- Filtros para la tabla `product_by_details`
--
ALTER TABLE `product_by_details`
  ADD CONSTRAINT `fk_product_by_details_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_details_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Filtros para la tabla `product_by_discount`
--
ALTER TABLE `product_by_discount`
  ADD CONSTRAINT `fk_product_by_discount_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `product_by_ice`
--
ALTER TABLE `product_by_ice`
  ADD CONSTRAINT `fk_product_by_ice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_ice_product_ice1` FOREIGN KEY (`product_ice_id`) REFERENCES `product_ice` (`id`);

--
-- Filtros para la tabla `product_by_multimedia`
--
ALTER TABLE `product_by_multimedia`
  ADD CONSTRAINT `fk_product_by_multimedia_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `product_by_route_map`
--
ALTER TABLE `product_by_route_map`
  ADD CONSTRAINT `fk_product_by_route_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_route_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Filtros para la tabla `product_by_sizes`
--
ALTER TABLE `product_by_sizes`
  ADD CONSTRAINT `fk_product_by_sizes_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_by_sizes_product_sizes1` FOREIGN KEY (`product_sizes_id`) REFERENCES `product_sizes` (`id`);

--
-- Filtros para la tabla `product_by_stock`
--
ALTER TABLE `product_by_stock`
  ADD CONSTRAINT `fk_product_by_stock_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `product_details_shipping_fee`
--
ALTER TABLE `product_details_shipping_fee`
  ADD CONSTRAINT `fk_product_details_shipping_fee_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `product_ice`
--
ALTER TABLE `product_ice`
  ADD CONSTRAINT `fk_product_ice_product_ice_types1` FOREIGN KEY (`product_ice_types_id`) REFERENCES `product_ice_types` (`id`);

--
-- Filtros para la tabla `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD CONSTRAINT `fk_product_inventory_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_inventory_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Filtros para la tabla `product_inventory_by_prices`
--
ALTER TABLE `product_inventory_by_prices`
  ADD CONSTRAINT `fk_product_inventory_by_prices_product_inventory1` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Filtros para la tabla `product_inventory_by_price_unity_box`
--
ALTER TABLE `product_inventory_by_price_unity_box`
  ADD CONSTRAINT `fk_product_by_unity_inventory_product_inventory10` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Filtros para la tabla `product_inventory_by_unity`
--
ALTER TABLE `product_inventory_by_unity`
  ADD CONSTRAINT `fk_product_by_unity_inventory_product_inventory1` FOREIGN KEY (`product_inventory_id`) REFERENCES `product_inventory` (`id`);

--
-- Filtros para la tabla `product_measure_by_subtype`
--
ALTER TABLE `product_measure_by_subtype`
  ADD CONSTRAINT `fk_product_measure_by_subtype_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_product_measure_by_subtype_product_measurement_subtype1` FOREIGN KEY (`product_measurement_subtype_id`) REFERENCES `product_measurement_subtype` (`id`);

--
-- Filtros para la tabla `product_subcategory`
--
ALTER TABLE `product_subcategory`
  ADD CONSTRAINT `fk_product_subcategory_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`);

--
-- Filtros para la tabla `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `fk_provinces_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Filtros para la tabla `repair_by_details_parts`
--
ALTER TABLE `repair_by_details_parts`
  ADD CONSTRAINT `fk_repair_by_details_parts_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_product_trademark1` FOREIGN KEY (`product_trademark_id`) REFERENCES `product_trademark` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_repair1` FOREIGN KEY (`repair_id`) REFERENCES `repair` (`id`),
  ADD CONSTRAINT `fk_repair_by_details_parts_repair_product_by_business1` FOREIGN KEY (`repair_product_by_business_id`) REFERENCES `repair_product_by_business` (`id`);

--
-- Filtros para la tabla `repair_product_by_business`
--
ALTER TABLE `repair_product_by_business`
  ADD CONSTRAINT `fk_repair_product_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `repair_product_by_color`
--
ALTER TABLE `repair_product_by_color`
  ADD CONSTRAINT `fk_repair_product_by_color_product_color1` FOREIGN KEY (`product_color_id`) REFERENCES `product_color` (`id`),
  ADD CONSTRAINT `fk_repair_product_by_color_repair_by_details_parts1` FOREIGN KEY (`repair_by_details_parts_id`) REFERENCES `repair_by_details_parts` (`id`);

--
-- Filtros para la tabla `retention_tax_sub_type`
--
ALTER TABLE `retention_tax_sub_type`
  ADD CONSTRAINT `fk_retention_tax_sub_type_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_retention_tax_sub_type_retention_tax_type1` FOREIGN KEY (`retention_tax_type_id`) REFERENCES `retention_tax_type` (`id`);

--
-- Filtros para la tabla `routes_map_by_routes_drawing`
--
ALTER TABLE `routes_map_by_routes_drawing`
  ADD CONSTRAINT `fk_routes_map_by_drawing_routes_drawing1` FOREIGN KEY (`routes_drawing_id`) REFERENCES `routes_drawing` (`id`),
  ADD CONSTRAINT `fk_routes_map_by_drawing_routes_map1` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`);

--
-- Filtros para la tabla `route_map_by_adventure_types`
--
ALTER TABLE `route_map_by_adventure_types`
  ADD CONSTRAINT `fk_route_by_adventure_types_business_by_routes_map1` FOREIGN KEY (`business_by_routes_map_id`) REFERENCES `business_by_routes_map` (`id`);

--
-- Filtros para la tabla `shipping_rate_business_by_conversion_factor`
--
ALTER TABLE `shipping_rate_business_by_conversion_factor`
  ADD CONSTRAINT `fk_shipping_rate_business_by_conversion_factor_shipping_rate_2` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_product_measure_type1` FOREIGN KEY (`product_measure_type_id`) REFERENCES `product_measure_type` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_shipping_rate_kinds_of_1` FOREIGN KEY (`shipping_rate_kinds_of_way_id`) REFERENCES `shipping_rate_kinds_of_way` (`id`),
  ADD CONSTRAINT `fk_shipping_rate_by_conversion_factor_shipping_rate_services1` FOREIGN KEY (`shipping_rate_services_id`) REFERENCES `shipping_rate_services` (`id`);

--
-- Filtros para la tabla `shipping_rate_business_by_min_weight`
--
ALTER TABLE `shipping_rate_business_by_min_weight`
  ADD CONSTRAINT `fk_shipping_rate_business_by_min_weight_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Filtros para la tabla `shipping_rate_services`
--
ALTER TABLE `shipping_rate_services`
  ADD CONSTRAINT `fk_shipping_rate_services_shipping_rate_business1` FOREIGN KEY (`shipping_rate_business_id`) REFERENCES `shipping_rate_business` (`id`);

--
-- Filtros para la tabla `students_by_business`
--
ALTER TABLE `students_by_business`
  ADD CONSTRAINT `fk_students_by_business_students_information1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`),
  ADD CONSTRAINT `fk_students_representative_by_business_business10` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `students_by_representative`
--
ALTER TABLE `students_by_representative`
  ADD CONSTRAINT `fk_students_by_representative_students_information1` FOREIGN KEY (`students_information_id`) REFERENCES `students_information` (`id`),
  ADD CONSTRAINT `fk_students_by_representative_students_representative1` FOREIGN KEY (`students_representative_id`) REFERENCES `students_representative` (`id`);

--
-- Filtros para la tabla `students_course_activities_by_resource`
--
ALTER TABLE `students_course_activities_by_resource`
  ADD CONSTRAINT `fk_students_course_activities_by_resource_educational_institu1` FOREIGN KEY (`educational_institution_course_by_activities_id`) REFERENCES `educational_institution_course_by_activities` (`id`);

--
-- Filtros para la tabla `students_information`
--
ALTER TABLE `students_information`
  ADD CONSTRAINT `fk_students_information_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);

--
-- Filtros para la tabla `students_representative`
--
ALTER TABLE `students_representative`
  ADD CONSTRAINT `fk_students_representative_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `fk_students_representative_people_relationship1` FOREIGN KEY (`people_relationship_id`) REFERENCES `people_relationship` (`id`);

--
-- Filtros para la tabla `students_representative_by_business`
--
ALTER TABLE `students_representative_by_business`
  ADD CONSTRAINT `fk_students_representative_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_students_representative_by_business_students_representative1` FOREIGN KEY (`students_representative_id`) REFERENCES `students_representative` (`id`);

--
-- Filtros para la tabla `taxes_by_cities`
--
ALTER TABLE `taxes_by_cities`
  ADD CONSTRAINT `fk_taxes_by_cities_cities1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_taxes_by_cities_taxes1` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`);

--
-- Filtros para la tabla `tax_by_business`
--
ALTER TABLE `tax_by_business`
  ADD CONSTRAINT `fk_tax_by_business_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_tax_by_business_tax1` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`id`);

--
-- Filtros para la tabla `template_about_us`
--
ALTER TABLE `template_about_us`
  ADD CONSTRAINT `fk_template_slider_template_information10` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_about_us_by_data`
--
ALTER TABLE `template_about_us_by_data`
  ADD CONSTRAINT `fk_template_about_us_by_data_template_about_us1` FOREIGN KEY (`template_about_us_id`) REFERENCES `template_about_us` (`id`);

--
-- Filtros para la tabla `template_blog`
--
ALTER TABLE `template_blog`
  ADD CONSTRAINT `fk_template_slider_template_information102011` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_blog_by_comments`
--
ALTER TABLE `template_blog_by_comments`
  ADD CONSTRAINT `fk_template_blog_by_comments_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Filtros para la tabla `template_blog_by_counters`
--
ALTER TABLE `template_blog_by_counters`
  ADD CONSTRAINT `fk_template_blog_by_counters_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Filtros para la tabla `template_blog_by_data`
--
ALTER TABLE `template_blog_by_data`
  ADD CONSTRAINT `fk_template_blog_by_data_template_blog1` FOREIGN KEY (`template_blog_id`) REFERENCES `template_blog` (`id`);

--
-- Filtros para la tabla `template_by_products`
--
ALTER TABLE `template_by_products`
  ADD CONSTRAINT `fk_template_by_products_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_template_by_products_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_by_source`
--
ALTER TABLE `template_by_source`
  ADD CONSTRAINT `fk_template_by_source_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_chat_api`
--
ALTER TABLE `template_chat_api`
  ADD CONSTRAINT `fk_template_chat_api_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_config_mailing`
--
ALTER TABLE `template_config_mailing`
  ADD CONSTRAINT `fk_template_config_mailing_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_config_mailing_by_emails`
--
ALTER TABLE `template_config_mailing_by_emails`
  ADD CONSTRAINT `fk_template_config_mailing_by_emails_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_contact_us`
--
ALTER TABLE `template_contact_us`
  ADD CONSTRAINT `fk_template_contact_us_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_contact_us_by_routes_map`
--
ALTER TABLE `template_contact_us_by_routes_map`
  ADD CONSTRAINT `fk_events_by_routes_map_routes_map10` FOREIGN KEY (`routes_map_id`) REFERENCES `routes_map` (`id`),
  ADD CONSTRAINT `fk_template_contact_us_by_routes_map_template_contact_us1` FOREIGN KEY (`template_contact_us_id`) REFERENCES `template_contact_us` (`id`);

--
-- Filtros para la tabla `template_faq`
--
ALTER TABLE `template_faq`
  ADD CONSTRAINT `fk_template_slider_template_information102010` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_faq_by_data`
--
ALTER TABLE `template_faq_by_data`
  ADD CONSTRAINT `fk_template_faq_by_data_template_faq1` FOREIGN KEY (`template_faq_id`) REFERENCES `template_faq` (`id`);

--
-- Filtros para la tabla `template_information`
--
ALTER TABLE `template_information`
  ADD CONSTRAINT `fk_template_information_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

--
-- Filtros para la tabla `template_multimedia_sections`
--
ALTER TABLE `template_multimedia_sections`
  ADD CONSTRAINT `fk_template_slider_template_information10200` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_our_team`
--
ALTER TABLE `template_our_team`
  ADD CONSTRAINT `fk_template_slider_template_information1020` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_our_team_by_data`
--
ALTER TABLE `template_our_team_by_data`
  ADD CONSTRAINT `fk_template_our_team_by_data_human_resources_employee_profile1` FOREIGN KEY (`human_resources_employee_profile_id`) REFERENCES `human_resources_employee_profile` (`id`),
  ADD CONSTRAINT `fk_template_our_team_by_data_template_our_team1` FOREIGN KEY (`template_our_team_id`) REFERENCES `template_our_team` (`id`);

--
-- Filtros para la tabla `template_payments`
--
ALTER TABLE `template_payments`
  ADD CONSTRAINT `fk_template_payments_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_policies`
--
ALTER TABLE `template_policies`
  ADD CONSTRAINT `fk_template_slider_template_information101` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_services`
--
ALTER TABLE `template_services`
  ADD CONSTRAINT `fk_template_slider_template_information100` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_services_by_data`
--
ALTER TABLE `template_services_by_data`
  ADD CONSTRAINT `fk_template_services_by_data_template_services1` FOREIGN KEY (`template_services_id`) REFERENCES `template_services` (`id`);

--
-- Filtros para la tabla `template_slider`
--
ALTER TABLE `template_slider`
  ADD CONSTRAINT `fk_template_slider_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_slider_by_images`
--
ALTER TABLE `template_slider_by_images`
  ADD CONSTRAINT `fk_template_slider_by_images_template_slider1` FOREIGN KEY (`template_slider_id`) REFERENCES `template_slider` (`id`);

--
-- Filtros para la tabla `template_steps`
--
ALTER TABLE `template_steps`
  ADD CONSTRAINT `fk_template_slider_template_information10201` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_steps_by_data`
--
ALTER TABLE `template_steps_by_data`
  ADD CONSTRAINT `fk_template_steps_by_data_template_steps1` FOREIGN KEY (`template_steps_id`) REFERENCES `template_steps` (`id`);

--
-- Filtros para la tabla `template_support`
--
ALTER TABLE `template_support`
  ADD CONSTRAINT `fk_template_slider_template_information102` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `template_support_by_data`
--
ALTER TABLE `template_support_by_data`
  ADD CONSTRAINT `fk_template_support_by_data_template_support1` FOREIGN KEY (`template_support_id`) REFERENCES `template_support` (`id`);

--
-- Filtros para la tabla `template_wish_list_by_user`
--
ALTER TABLE `template_wish_list_by_user`
  ADD CONSTRAINT `fk_template_wish_list_by_user_template_information1` FOREIGN KEY (`template_information_id`) REFERENCES `template_information` (`id`);

--
-- Filtros para la tabla `treatment_by_advance`
--
ALTER TABLE `treatment_by_advance`
  ADD CONSTRAINT `fk_treatment_by_advance_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Filtros para la tabla `treatment_by_breakdown_payment`
--
ALTER TABLE `treatment_by_breakdown_payment`
  ADD CONSTRAINT `fk_treatment_by_breakdown_payment_treatment_by_indebtedness_p1` FOREIGN KEY (`treatment_by_indebtedness_paying_init_id`) REFERENCES `treatment_by_indebtedness_paying_init` (`id`);

--
-- Filtros para la tabla `treatment_by_details`
--
ALTER TABLE `treatment_by_details`
  ADD CONSTRAINT `fk_treatment_by_details_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Filtros para la tabla `treatment_by_indebtedness_paying_init`
--
ALTER TABLE `treatment_by_indebtedness_paying_init`
  ADD CONSTRAINT `fk_treatment_by_indebtedness_paying_init_treatment_by_patient1` FOREIGN KEY (`treatment_by_patient_id`) REFERENCES `treatment_by_patient` (`id`);

--
-- Filtros para la tabla `treatment_by_patient`
--
ALTER TABLE `treatment_by_patient`
  ADD CONSTRAINT `fk_treatment_by_patient_history_clinic1` FOREIGN KEY (`history_clinic_id`) REFERENCES `history_clinic` (`id`);

--
-- Filtros para la tabla `treatment_by_payment`
--
ALTER TABLE `treatment_by_payment`
  ADD CONSTRAINT `fk_invoice_buy_by_payment_types_payments_by_account100` FOREIGN KEY (`types_payments_by_account_id`) REFERENCES `types_payments_by_account` (`id`),
  ADD CONSTRAINT `fk_treatment_by_payment_treatment_by_breakdown_payment1` FOREIGN KEY (`treatment_by_breakdown_payment_id`) REFERENCES `treatment_by_breakdown_payment` (`id`),
  ADD CONSTRAINT `fk_treatment_by_payment_treatment_by_indebtedness_paying_init1` FOREIGN KEY (`treatment_by_indebtedness_paying_init_id`) REFERENCES `treatment_by_indebtedness_paying_init` (`id`);

--
-- Filtros para la tabla `types_payments_by_account`
--
ALTER TABLE `types_payments_by_account`
  ADD CONSTRAINT `fk_types_payments_by_account_accounting_account1` FOREIGN KEY (`accounting_account_id`) REFERENCES `accounting_account` (`id`),
  ADD CONSTRAINT `fk_types_payments_by_account_business1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  ADD CONSTRAINT `fk_types_payments_by_account_types_payments1` FOREIGN KEY (`types_payments_id`) REFERENCES `types_payments` (`id`);

--
-- Filtros para la tabla `users_by_about_us`
--
ALTER TABLE `users_by_about_us`
  ADD CONSTRAINT `fk_users_by_profile_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users_has_roles`
--
ALTER TABLE `users_has_roles`
  ADD CONSTRAINT `fk_users_has_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_users_has_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
