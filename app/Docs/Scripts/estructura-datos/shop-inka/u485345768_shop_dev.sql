-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 28, 2024 at 11:57 AM
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

--
-- Dumping data for table `accounting_account`
--

INSERT INTO `accounting_account` (`id`, `value`, `status`, `accounting_account_type_id`, `accounting_level_id`,
                                  `description`, `parent_key`, `has_parent`, `is_parent`, `movement`, `rfc`,
                                  `cost_center`, `base_amount`, `base_amount_percentage`, `base_amount_value`,
                                  `business_id`)
VALUES (1, '1', 'ACTIVE', 1, 1, 'ACTIVE', 0, 0, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (2, '1.1', 'ACTIVE', 1, 2, 'ACTIVE corriente', 1, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (3, '1.1.01', 'ACTIVE', 1, 3, 'ACTIVEs disponibles', 2, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (4, '1.1.01.01', 'ACTIVE', 1, 4, 'Caja', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (5, '1.1.01.01.001', 'ACTIVE', 1, 5, 'Caja General', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (6, '1.1.01.02', 'ACTIVE', 1, 4, 'Bancos', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (7, '1.1.01.02.001', 'ACTIVE', 1, 5, 'Banco Pichincha Luxury', 6, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (8, '1.1.01.03', 'ACTIVE', 1, 4, 'Clientes', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (9, '1.1.01.03.001', 'ACTIVE', 1, 5, 'Clientes ', 8, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (10, '1.1.01.03.002', 'ACTIVE', 1, 5, 'Cuentas por Cobrar', 8, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (11, '1.1.01.04', 'ACTIVE', 1, 4, 'Provisiones incobrables', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (12, '1.1.01.04.001', 'ACTIVE', 1, 5, 'Provisiones incobrables', 11, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (13, '1.1.01.05', 'ACTIVE', 1, 4, 'Documentos por cobrar', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (14, '1.1.01.05.001', 'ACTIVE', 1, 5, 'Documentos por cobrar', 13, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (15, '1.1.01.05.002', 'ACTIVE', 1, 5, 'Cheques devueltos o protestados', 13, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (16, '1.1.01.06', 'ACTIVE', 1, 4, 'Otras cuentas por cobrar', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (17, '1.1.01.06.001', 'ACTIVE', 1, 5, 'Anticipo proveedores', 16, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (18, '1.1.01.06.002', 'ACTIVE', 1, 5, 'Anticipo empleados', 16, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (19, '1.1.01.07', 'ACTIVE', 1, 4, 'Cuentas por cobrar terceros', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (20, '1.1.01.07.001', 'ACTIVE', 1, 5, 'Préstamos terceros', 19, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (21, '1.1.01.08', 'ACTIVE', 1, 4, 'Impuestos', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (22, '1.1.01.08.001', 'ACTIVE', 1, 5, 'Iva pagado', 21, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (23, '1.1.01.09', 'ACTIVE', 1, 4, 'Impuesto a la renta', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (24, '1.1.01.09.001', 'ACTIVE', 1, 5, 'retención en la fuente 1%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (25, '1.1.01.09.002', 'ACTIVE', 1, 5, 'retención en la fuente 2%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (26, '1.1.01.09.003', 'ACTIVE', 1, 5, 'retención en la fuente 8%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (27, '1.1.01.09.004', 'ACTIVE', 1, 5, 'retención en la fuente 10%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (28, '1.1.01.09.005', 'ACTIVE', 1, 5, 'retención en la fuente 25%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (29, '1.1.01.09.006', 'ACTIVE', 1, 5, 'Anticipo impuesto a la renta', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (30, '1.1.01.09.007', 'ACTIVE', 1, 5, 'Retencion IVA 10%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (31, '1.1.01.09.008', 'ACTIVE', 1, 5, 'Retencion IVA 20%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (32, '1.1.01.09.009', 'ACTIVE', 1, 5, 'Retencion IVA 30%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (33, '1.1.01.09.010', 'ACTIVE', 1, 5, 'Retencion IVA 50%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (34, '1.1.01.09.011', 'ACTIVE', 1, 5, 'Retencion IVA 70%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (35, '1.1.01.09.012', 'ACTIVE', 1, 5, 'Retencion IVA 100%', 23, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (36, '1.1.01.10', 'ACTIVE', 1, 4, 'Gastos anticipados', 3, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (37, '1.1.01.10.001', 'ACTIVE', 1, 5, 'Seguros prepagados', 36, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (38, '1.1.01.10.002', 'ACTIVE', 1, 5, 'intereses prepagados', 36, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (39, '1.1.01.10.003', 'ACTIVE', 1, 5, 'Arriendos prepagados', 36, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (40, '1.1.02', 'ACTIVE', 1, 3, 'ACTIVEs realizables', 2, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (41, '1.1.02.01', 'ACTIVE', 1, 4, 'Inventario materia prima', 40, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (42, '1.1.02.01.001', 'ACTIVE', 1, 5, 'Tela ', 41, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (43, '1.1.02.01.002', 'ACTIVE', 1, 5, 'Plumón', 41, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (44, '1.1.02.02', 'ACTIVE', 1, 4, 'Materia prima indirecta confección', 40, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (45, '1.1.02.02.001', 'ACTIVE', 1, 5, 'materiales confección', 44, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (46, '1.1.02.03', 'ACTIVE', 1, 4, 'Inventario de productos en proceso', 40, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (47, '1.1.02.03.001', 'ACTIVE', 1, 5, 'P.p. materia prima confección', 46, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (48, '1.1.02.03.002', 'ACTIVE', 1, 5, 'P.p. mano de obra confección', 46, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (49, '1.1.02.03.003', 'ACTIVE', 1, 5, 'P.p. cif confección', 46, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (50, '1.1.02.04', 'ACTIVE', 1, 4, 'Inventario de productos terminados', 40, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (51, '1.1.02.04.001', 'ACTIVE', 1, 5, 'Inventario', 50, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (52, '1.2', 'ACTIVE', 1, 2, 'ACTIVE no corriente', 1, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (53, '1.2.01', 'ACTIVE', 1, 3, 'Propiedad planta y equipo', 52, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (54, '1.2.01.01', 'ACTIVE', 1, 4, 'Depreciables', 53, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (55, '1.2.01.01.001', 'ACTIVE', 1, 5, 'Equipo de oficina', 54, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (56, '1.2.01.01.002', 'ACTIVE', 1, 5, 'Equipos de computación', 54, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (57, '1.2.01.01.003', 'ACTIVE', 1, 5, 'Maquinaria y equipo', 54, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (58, '1.2.01.01.004', 'ACTIVE', 1, 5, 'Muebles y enseres', 54, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (59, '1.2.01.01.005', 'ACTIVE', 1, 5, 'Vehículos', 54, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (60, '1.2.01.02', 'ACTIVE', 1, 4, 'Depreciación acumulada', 53, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (61, '1.2.01.02.001', 'ACTIVE', 1, 5, 'Dep. Acum. Equipo de oficina', 60, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (62, '1.2.01.02.002', 'ACTIVE', 1, 5, 'Dep. Acum. Equipos de computación', 60, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (63, '1.2.01.02.003', 'ACTIVE', 1, 5, 'Dep. Acum. Maquinaria y equipo', 60, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (64, '1.2.01.02.004', 'ACTIVE', 1, 5, 'Dep. Acum. Muebles y enseres', 60, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (65, '1.2.01.02.005', 'ACTIVE', 1, 5, 'Dep. Acum. Vehículos', 60, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (66, '1.2.01.03', 'ACTIVE', 1, 4, 'No depreciables', 53, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (67, '1.2.01.03.001', 'ACTIVE', 1, 5, 'Terrenos', 66, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (68, '2', 'ACTIVE', 2, 1, 'Pasivo', 0, 0, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (69, '2.1', 'ACTIVE', 2, 2, 'Pasivo corriente', 68, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (70, '2.1.01', 'ACTIVE', 2, 3, 'Pasivo corriente', 69, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (71, '2.1.01.01', 'ACTIVE', 2, 4, 'Proveedores', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (72, '2.1.01.01.001', 'ACTIVE', 2, 5, 'Proveedores', 71, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (73, '2.1.01.01.002', 'ACTIVE', 2, 5, 'Cuentas por Pagar', 71, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (74, '2.1.01.02', 'ACTIVE', 2, 4, 'Obligaciones con el personal ', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (75, '2.1.01.02.001', 'ACTIVE', 2, 5, 'Remuneraciones', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (76, '2.1.01.02.002', 'ACTIVE', 2, 5, 'Décimo tercer sueldo ', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (77, '2.1.01.02.003', 'ACTIVE', 2, 5, 'Décimo cuarto sueldo ', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (78, '2.1.01.02.004', 'ACTIVE', 2, 5, 'Aporte patronal IESS', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (79, '2.1.01.02.005', 'ACTIVE', 2, 5, 'Fondos de reserva IESS', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (80, '2.1.01.02.006', 'ACTIVE', 2, 5, 'Vacaciones', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (81, '2.1.01.02.007', 'ACTIVE', 2, 5, 'Participación empleados ', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (82, '2.1.01.02.008', 'ACTIVE', 2, 5, 'Liquidaciones e indemnizaciones', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (83, '2.1.01.02.009', 'ACTIVE', 2, 5, 'Desahucio', 74, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (84, '2.1.01.03', 'ACTIVE', 2, 4, 'Deducciones patronales', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (85, '2.1.01.03.001', 'ACTIVE', 2, 5, 'Aporte personal IESS', 84, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (86, '2.1.01.03.002', 'ACTIVE', 2, 5, 'Préstamos IESS', 84, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (87, '2.1.01.03.003', 'ACTIVE', 2, 5, 'Descuentos varios', 84, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (88, '2.1.01.04', 'ACTIVE', 2, 4, 'Obligaciones financieras', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (89, '2.1.01.04.001', 'ACTIVE', 2, 5, 'Préstamos bancarios', 88, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (90, '2.1.01.04.002', 'ACTIVE', 2, 5, 'Sobregiros bancarios', 88, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (91, '2.1.01.04.003', 'ACTIVE', 2, 5, 'Sociedades financieras', 88, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (92, '2.1.01.05', 'ACTIVE', 2, 4, 'Impuestos por pagar ', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (93, '2.1.01.05.001', 'ACTIVE', 2, 5, 'Iva por pagar', 92, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (94, '2.1.01.06', 'ACTIVE', 2, 4, 'Impuesto a la renta', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (95, '2.1.01.06.001', 'ACTIVE', 2, 5, 'Impuesto a la renta por pagar 1%', 94, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (96, '2.1.01.06.002', 'ACTIVE', 2, 5, 'Impuesto a la renta por pagar 2%', 94, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (97, '2.1.01.06.003', 'ACTIVE', 2, 5, 'Impuesto a la renta por pagar 8%', 94, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (98, '2.1.01.06.004', 'ACTIVE', 2, 5, 'Impuesto a la renta por pagar 10%', 94, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (99, '2.1.01.07', 'ACTIVE', 2, 4, 'Retencion IVA ', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (100, '2.1.01.07.001', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 10%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (101, '2.1.01.07.002', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 20%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (102, '2.1.01.07.003', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 30%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (103, '2.1.01.07.004', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 50%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (104, '2.1.01.07.005', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 70%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (105, '2.1.01.07.006', 'ACTIVE', 2, 5, 'Retencion IVA por pagar 100%', 99, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (106, '2.1.01.08', 'ACTIVE', 2, 4, 'Otras cuentas por pagar', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (107, '2.1.01.08.001', 'ACTIVE', 2, 5, 'Préstamos terceros', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (108, '2.1.01.08.002', 'ACTIVE', 2, 5, 'Anticipo a clientes', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (109, '2.1.01.08.003', 'ACTIVE', 2, 5, 'Documentos por pagar', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (110, '2.1.01.08.004', 'ACTIVE', 2, 5, 'Comisiones por pagar', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (111, '2.1.01.08.005', 'ACTIVE', 2, 5, 'Honorarios por pagar', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (112, '2.1.01.08.006', 'ACTIVE', 2, 5, 'Otras cuentas por pagar', 106, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (113, '2.1.01.09', 'ACTIVE', 2, 4, 'Gastos por pagar', 70, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (114, '2.1.01.09.001', 'ACTIVE', 2, 5, 'Servicios básicos por pagar', 113, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (115, '2.1.01.09.002', 'ACTIVE', 2, 5, 'intereses por pagar', 113, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (116, '2.1.01.09.003', 'ACTIVE', 2, 5, 'Seguros por pagar', 113, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (117, '2.1.01.09.004', 'ACTIVE', 2, 5, 'Servicios bancarios por pagar', 113, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (118, '2.2', 'ACTIVE', 2, 2, 'Pasivo no corriente', 68, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (119, '2.2.01', 'ACTIVE', 2, 3, 'Pasivo no corriente', 118, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (120, '2.2.01.01', 'ACTIVE', 2, 4, 'Instituciones financieras', 119, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (121, '2.2.01.01.001', 'ACTIVE', 2, 5, 'Instituciones financieras', 120, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (122, '2.2.01.01.002', 'ACTIVE', 2, 5, 'Sociedades financieras Media', 120, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (123, '2.2.01.02', 'ACTIVE', 2, 4, 'Obligaciones con el personal', 119, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (124, '2.2.01.02.001', 'ACTIVE', 2, 5, 'desahucio', 123, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (125, '2.2.01.02.002', 'ACTIVE', 2, 5, 'Jubilación patronal', 123, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (126, '2.2.01.03', 'ACTIVE', 2, 4, 'Préstamos terceros', 119, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (127, '2.2.01.03.001', 'ACTIVE', 2, 5, 'Préstamos terceros', 126, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (128, '3', 'ACTIVE', 3, 1, 'Patrimonio', 0, 0, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (129, '3.1', 'ACTIVE', 3, 2, 'Patrimonio neto', 128, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (130, '3.1.01', 'ACTIVE', 3, 3, 'Patrimonio neto', 129, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (131, '3.1.01.01', 'ACTIVE', 3, 4, 'Capital', 130, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (132, '3.1.01.01.001', 'ACTIVE', 3, 5, 'Capital', 131, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (133, '3.1.01.01.002', 'ACTIVE', 3, 5, 'Resultado del ejercicio', 131, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (134, '3.1.01.01.003', 'ACTIVE', 3, 5, 'Resultado de ejercicios anteriores', 131, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (135, '3.1.01.01.004', 'ACTIVE', 3, 5, 'Utilidades retenidas', 131, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (136, '3.1.01.01.005', 'ACTIVE', 3, 5, 'Pérdidas acumuladas', 131, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (137, '4', 'ACTIVE', 4, 1, 'Ingresos', 0, 0, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (138, '4.1', 'ACTIVE', 4, 2, 'Ingresos operacionales', 137, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (139, '4.1.01', 'ACTIVE', 4, 3, 'Venta netas', 138, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (140, '4.1.01.01', 'ACTIVE', 4, 4, 'Ventas', 139, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (141, '4.1.01.01.001', 'ACTIVE', 4, 5, 'Ventas', 140, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (142, '4.1.01.01.002', 'ACTIVE', 4, 5, 'Descuento en Ventas', 140, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (143, '4.1.01.01.003', 'ACTIVE', 4, 5, 'Devolución en Ventas', 140, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (144, '4.1.01.02', 'ACTIVE', 4, 4, 'Servicios Prestados', 139, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (145, '4.1.01.02.001', 'ACTIVE', 4, 5, 'Servicios Prestados', 144, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (146, '4.1.01.02.002', 'ACTIVE', 4, 5, 'Descuento en Servicios Prestados', 144, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (147, '4.1.01.02.003', 'ACTIVE', 4, 5, 'Devolución en Servicios Prestados', 144, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (148, '4.2', 'ACTIVE', 4, 2, 'Otros ingresos operacionales', 137, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (149, '4.2.01', 'ACTIVE', 4, 3, 'Otros ingresos', 148, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (150, '4.2.01.01', 'ACTIVE', 4, 4, 'Otros ingresos', 149, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (151, '4.2.01.01.001', 'ACTIVE', 4, 5, 'intereses ganados', 150, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (152, '4.2.01.01.002', 'ACTIVE', 4, 5, 'Descuento en compras', 150, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (153, '4.2.01.01.003', 'ACTIVE', 4, 5, 'Fletes cobrados a clientes', 150, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (154, '4.2.01.01.004', 'ACTIVE', 4, 5, 'Sobrantes de caja', 150, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (155, '5', 'ACTIVE', 5, 1, 'Costos y gastos', 0, 0, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (156, '5.1', 'ACTIVE', 5, 2, 'Costos', 155, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (157, '5.1.01', 'ACTIVE', 5, 3, 'Costos de venta', 156, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (158, '5.1.01.01', 'ACTIVE', 5, 4, 'Costos de venta', 157, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (159, '5.1.01.01.001', 'ACTIVE', 5, 5, 'Costo de venta inventario', 158, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (160, '5.1.01.01.002', 'ACTIVE', 5, 5, 'Pérdida de inventarios', 158, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (161, '5.1.02', 'ACTIVE', 5, 3, 'Costos indirectos de Fabricación', 156, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (162, '5.1.02.01', 'ACTIVE', 5, 4, 'Consumo materiales indirectos', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (163, '5.1.02.01.001', 'ACTIVE', 5, 5, 'Consumo materiales de confección', 162, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (164, '5.1.02.02', 'ACTIVE', 5, 4, 'Mano de obra', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (165, '5.1.02.02.001', 'ACTIVE', 5, 5, 'Sueldos', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (166, '5.1.02.02.002', 'ACTIVE', 5, 5, 'Horas extras', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (167, '5.1.02.02.003', 'ACTIVE', 5, 5, 'Aporte patronal IESS', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (168, '5.1.02.02.004', 'ACTIVE', 5, 5, 'Décimo tercer sueldo ', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (169, '5.1.02.02.005', 'ACTIVE', 5, 5, 'Décimo cuarto sueldo ', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (170, '5.1.02.02.006', 'ACTIVE', 5, 5, 'Vacaciones', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (171, '5.1.02.02.007', 'ACTIVE', 5, 5, 'Fondos de reserva IESS', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (172, '5.1.02.02.008', 'ACTIVE', 5, 5, 'Desahucio', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (173, '5.1.02.02.009', 'ACTIVE', 5, 5, 'Uniformes', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (174, '5.1.02.02.010', 'ACTIVE', 5, 5, 'Capacitación', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (175, '5.1.02.02.011', 'ACTIVE', 5, 5, 'Agasajos ', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (176, '5.1.02.02.012', 'ACTIVE', 5, 5, 'atención al personal', 164, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (177, '5.1.02.03', 'ACTIVE', 5, 4, 'Costos indirectos de Fabricación', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (178, '5.1.02.03.001', 'ACTIVE', 5, 5, 'Suministros', 177, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (179, '5.1.02.03.002', 'ACTIVE', 5, 5, 'Repuestos y herramientas', 177, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (180, '5.1.02.03.003', 'ACTIVE', 5, 5, 'Complementos', 177, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (181, '5.1.02.04', 'ACTIVE', 5, 4, 'Servicios básicos', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (182, '5.1.02.04.001', 'ACTIVE', 5, 5, 'Agua potable', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (183, '5.1.02.04.002', 'ACTIVE', 5, 5, 'Energía eléctrica', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (184, '5.1.02.04.003', 'ACTIVE', 5, 5, 'Telefonía fija', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (185, '5.1.02.04.004', 'ACTIVE', 5, 5, 'Telefonía celular', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (186, '5.1.02.04.005', 'ACTIVE', 5, 5, 'Transportes y fletes', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (187, '5.1.02.04.006', 'ACTIVE', 5, 5, 'Publicidad y propaganda', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (188, '5.1.02.04.007', 'ACTIVE', 5, 5, 'Seguros', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (189, '5.1.02.04.008', 'ACTIVE', 5, 5, 'Peajes y garajes', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (190, '5.1.02.04.009', 'ACTIVE', 5, 5, 'Honorarios profesionales', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (191, '5.1.02.04.010', 'ACTIVE', 5, 5, 'Servicios técnicos', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (192, '5.1.02.04.011', 'ACTIVE', 5, 5, 'Capacitación ', 181, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (193, '5.1.02.05', 'ACTIVE', 5, 4, 'Depreciaciones', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (194, '5.1.02.05.001', 'ACTIVE', 5, 5, 'Depreciación equipo de oficina', 193, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (195, '5.1.02.05.002', 'ACTIVE', 5, 5, 'Depreciación equipo de computación', 193, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (196, '5.1.02.05.003', 'ACTIVE', 5, 5, 'Depreciación muebles y enseres', 193, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (197, '5.1.02.05.004', 'ACTIVE', 5, 5, 'Depreciación maquinaria y equipo', 193, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (198, '5.1.02.06', 'ACTIVE', 5, 4, 'Arriendo', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (199, '5.1.02.06.001', 'ACTIVE', 5, 5, 'Arriendo empresa', 198, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (200, '5.1.02.07', 'ACTIVE', 5, 4, 'Mantenimiento', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (201, '5.1.02.07.001', 'ACTIVE', 5, 5, 'Mantenimiento equipo computo y hardware', 200, 1, 0, 0, 0, 0, 0, NULL,
        NULL, 1),
       (202, '5.1.02.07.002', 'ACTIVE', 5, 5, 'Mantenimiento muebles y enseres', 200, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (203, '5.1.02.07.003', 'ACTIVE', 5, 5, 'Mantenimiento maquinaria y equipo', 200, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (204, '5.1.02.07.004', 'ACTIVE', 5, 5, 'Mantenimiento edificios', 200, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (205, '5.1.02.08', 'ACTIVE', 5, 4, 'Otros', 161, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (206, '5.1.02.08.001', 'ACTIVE', 5, 5, 'Implementos de aseo y limpieza', 205, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (207, '5.1.02.08.002', 'ACTIVE', 5, 5, 'Útiles y papelería', 205, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (208, '5.1.02.08.003', 'ACTIVE', 5, 5, 'materiales de embalaje', 205, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (209, '5.1.03', 'ACTIVE', 5, 3, 'CIF aplicado', 156, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (210, '5.2', 'ACTIVE', 5, 2, 'Gastos', 155, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (211, '5.2.01', 'ACTIVE', 5, 3, 'Gastos de administración y ventas', 210, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (212, '5.2.01.01', 'ACTIVE', 5, 4, 'Gastos de personal', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (213, '5.2.01.01.001', 'ACTIVE', 5, 5, 'Sueldos', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (214, '5.2.01.01.002', 'ACTIVE', 5, 5, 'Horas extras', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (215, '5.2.01.01.003', 'ACTIVE', 5, 5, 'Aporte patronal IESS ', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (216, '5.2.01.01.004', 'ACTIVE', 5, 5, 'Décimo tercer sueldo ', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (217, '5.2.01.01.005', 'ACTIVE', 5, 5, 'Décimo cuarto sueldo ', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (218, '5.2.01.01.006', 'ACTIVE', 5, 5, 'Vacaciones', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (219, '5.2.01.01.007', 'ACTIVE', 5, 5, 'Fondos de reserva IESS', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (220, '5.2.01.01.008', 'ACTIVE', 5, 5, 'Desahucio', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (221, '5.2.01.01.009', 'ACTIVE', 5, 5, 'Uniformes', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (222, '5.2.01.01.010', 'ACTIVE', 5, 5, 'Capacitación', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (223, '5.2.01.01.011', 'ACTIVE', 5, 5, 'Agasajos ', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (224, '5.2.01.01.012', 'ACTIVE', 5, 5, 'atención al personal', 212, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (225, '5.2.01.02', 'ACTIVE', 5, 4, 'Gastos indirectos - servicios', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (226, '5.2.01.02.001', 'ACTIVE', 5, 5, 'Agua potable', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (227, '5.2.01.02.002', 'ACTIVE', 5, 5, 'Energía eléctrica', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (228, '5.2.01.02.003', 'ACTIVE', 5, 5, 'Telefonía fija', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (229, '5.2.01.02.004', 'ACTIVE', 5, 5, 'Telefonía celular', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (230, '5.2.01.02.005', 'ACTIVE', 5, 5, 'Transportes y fletes', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (231, '5.2.01.02.006', 'ACTIVE', 5, 5, 'Publicidad y propaganda', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (232, '5.2.01.02.007', 'ACTIVE', 5, 5, 'Seguros', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (233, '5.2.01.02.008', 'ACTIVE', 5, 5, 'Peajes y garajes', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (234, '5.2.01.02.009', 'ACTIVE', 5, 5, 'Combustibles y lubricantes', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (235, '5.2.01.02.010', 'ACTIVE', 5, 5, 'Implementos de aseo y limpieza', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (236, '5.2.01.02.011', 'ACTIVE', 5, 5, 'Útiles y papelería', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (237, '5.2.01.02.012', 'ACTIVE', 5, 5, 'materiales de embalaje', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (238, '5.2.01.02.013', 'ACTIVE', 5, 5, 'Movilizaciones', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (239, '5.2.01.02.014', 'ACTIVE', 5, 5, 'Arriendo', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (240, '5.2.01.02.015', 'ACTIVE', 5, 5, 'Suministros', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (241, '5.2.01.02.016', 'ACTIVE', 5, 5, 'Internet satelital', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (242, '5.2.01.02.017', 'ACTIVE', 5, 5, 'Atención clientes', 225, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (243, '5.2.01.03', 'ACTIVE', 5, 4, 'Honorarios profesionales', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (244, '5.2.01.03.001', 'ACTIVE', 5, 5, 'Honorarios profesionales', 243, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (245, '5.2.01.03.002', 'ACTIVE', 5, 5, 'Servicios técnicos', 243, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (246, '5.2.01.04', 'ACTIVE', 5, 4, 'Mantenimiento', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (247, '5.2.01.04.001', 'ACTIVE', 5, 5, 'Mantenimiento equipo de oficina', 246, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (248, '5.2.01.04.002', 'ACTIVE', 5, 5, 'Mantenimiento equipo de computación', 246, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (249, '5.2.01.04.003', 'ACTIVE', 5, 5, 'Mantenimiento mueble y enseres', 246, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (250, '5.2.01.04.004', 'ACTIVE', 5, 5, 'Mantenimiento maquinaria y equipo', 246, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (251, '5.2.01.04.005', 'ACTIVE', 5, 5, 'Mantenimiento Vehículos', 246, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (252, '5.2.01.04.006', 'ACTIVE', 5, 5, 'Mantenimientos edificios', 246, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (253, '5.2.01.05', 'ACTIVE', 5, 4, 'Impuestos y tasas', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (254, '5.2.01.05.001', 'ACTIVE', 5, 5, 'Matriculas Vehículos', 253, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (255, '5.2.01.05.002', 'ACTIVE', 5, 5, 'Impuestos prediales, patentes, otros', 253, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (256, '5.2.01.06', 'ACTIVE', 5, 4, 'Depreciaciones', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (257, '5.2.01.06.001', 'ACTIVE', 5, 5, 'Depreciación equipo de oficina', 256, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (258, '5.2.01.06.002', 'ACTIVE', 5, 5, 'Depreciación equipo de computación', 256, 1, 0, 0, 0, 0, 0, NULL, NULL,
        1),
       (259, '5.2.01.06.003', 'ACTIVE', 5, 5, 'Depreciación muebles y enseres', 256, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (260, '5.2.01.06.004', 'ACTIVE', 5, 5, 'Depreciación maquinaria y equipo', 256, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (261, '5.2.01.06.005', 'ACTIVE', 5, 5, 'Depreciación Vehículos', 256, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (262, '5.2.01.07', 'ACTIVE', 5, 4, 'Amortizaciones', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (263, '5.2.01.07.002', 'ACTIVE', 5, 5, 'Amortización seguro', 262, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (264, '5.2.01.08', 'ACTIVE', 5, 4, 'Provisiones', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (265, '5.2.01.08.001', 'ACTIVE', 5, 5, 'Provisión para incobrables', 264, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (266, '5.2.01.09', 'ACTIVE', 5, 4, 'Gastos financieros', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (267, '5.2.01.09.001', 'ACTIVE', 5, 5, 'intereses', 266, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (268, '5.2.01.09.002', 'ACTIVE', 5, 5, 'Gastos bancarios', 266, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (269, '5.2.01.09.003', 'ACTIVE', 5, 5, 'Multas y otros', 266, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (270, '5.2.01.10', 'ACTIVE', 5, 4, 'Comisiones bancarias', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (271, '5.2.01.10.001', 'ACTIVE', 5, 5, 'Tarjetas de Crédito', 270, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (272, '5.2.01.11', 'ACTIVE', 5, 4, 'Gastos varios', 211, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (273, '5.2.01.11.001', 'ACTIVE', 5, 5, 'interés y multas organismos', 272, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (274, '5.2.01.11.002', 'ACTIVE', 5, 5, 'Pérdida en venta de ACTIVEs', 272, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (275, '5.2.01.11.003', 'ACTIVE', 5, 5, 'Pérdida de inventarios', 272, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (276, '5.2.01.11.004', 'ACTIVE', 5, 5, 'Diferencias de cajas', 272, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (277, '5.2.01.11.005', 'ACTIVE', 5, 5, 'Iva enviado al gasto', 272, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (278, '5.3', 'ACTIVE', 5, 2, 'Impuesto a la renta', 155, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (279, '5.3.01', 'ACTIVE', 5, 3, 'Impuesto a la renta', 278, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (280, '5.3.01.01', 'ACTIVE', 5, 4, 'Impuesto a la renta', 279, 1, 1, 0, 0, 0, 0, NULL, NULL, 1),
       (281, '5.3.01.01.001', 'ACTIVE', 5, 5, 'Impuesto a renta empresa', 280, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (282, '5.2.01.01.013', 'ACTIVE', 5, 5, 'Gastos Operacionales', 280, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (283, '1.1.01.10.004', 'ACTIVE', 1, 5, 'Importaciones', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (284, '1.1.01.10.005', 'ACTIVE', 1, 5, 'Crédito Tributario IVA', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (285, '1.1.01.02.003', 'ACTIVE', 1, 5, 'BANCO PICHINCHA 3068', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (286, '1.1.01.01.002', 'ACTIVE', 1, 5, 'Caja Chica', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (287, '1.1.01.01.003', 'ACTIVE', 1, 5, 'Caja AP Principal', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1),
       (288, '1.1.01.01.004', 'ACTIVE', 4, 5, 'Caja Principal Edf Ecuador', 4, 1, 0, 0, 0, 0, 0, NULL, NULL, 1);

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

--
-- Dumping data for table `accounting_account_type`
--

INSERT INTO `accounting_account_type` (`id`, `value`, `description`, `status`)
VALUES (1, 'ACTIVE', NULL, 'ACTIVE'),
       (2, 'Pasivo', NULL, 'ACTIVE'),
       (3, 'Patrimonio', NULL, 'ACTIVE'),
       (4, 'Ingresos', NULL, 'ACTIVE'),
       (5, 'Costos y Gastos', NULL, 'ACTIVE');

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

--
-- Dumping data for table `accounting_config_modules_account_by_account`
--

INSERT INTO `accounting_config_modules_account_by_account` (`id`, `accounting_account_id`, `description`, `code`,
                                                            `accounting_config_modules_types_id`, `type_of_income`,
                                                            `status`)
VALUES (1, 5, 'Caja general', '01', 1, 0, 'ACTIVE'),
       (2, 10, 'Cheques por cobrar', '02', 1, 0, 'ACTIVE'),
       (3, 109, 'Cheques por pagar', '03', 1, 0, 'ACTIVE'),
       (4, 22, 'IVA pagado', '04', 2, 0, 'ACTIVE'),
       (5, 22, 'ICE pagado	', '05', 2, 0, 'ACTIVE'),
       (6, 135, 'Descuento en compras', '06', 2, 0, 'ACTIVE'),
       (7, 135, 'Desc. solidario en compras', '07', 2, 0, 'ACTIVE'),
       (8, 30, 'Renteción IVA 10%', '08', 2, 0, 'ACTIVE'),
       (9, 30, 'Renteción IVA 20%', '09', 2, 0, 'ACTIVE'),
       (10, 30, 'Renteción IVA 30%', '10', 2, 0, 'ACTIVE'),
       (11, 30, 'Renteción IVA 70%	', '11', 2, 0, 'ACTIVE'),
       (12, 30, 'Renteción IVA 100%	', '12', 2, 0, 'ACTIVE'),
       (13, 25, 'Renteción RENTA 1%', '13', 2, 0, 'ACTIVE'),
       (14, 26, 'Renteción RENTA 2%', '14', 2, 0, 'ACTIVE'),
       (15, 26, 'Renteción RENTA 5%	', '15', 2, 0, 'ACTIVE'),
       (16, 27, 'Renteción RENTA 8%	', '16', 2, 0, 'ACTIVE'),
       (17, 24, 'Renteción RENTA 10%	', '17', 2, 0, 'ACTIVE'),
       (18, 24, 'Otras renteciones realizadas	', '18', 2, 0, 'ACTIVE'),
       (19, 73, 'Cuentas por pagar	', '19', 2, 0, 'ACTIVE'),
       (20, 17, 'Anticipo a proveedores	', '20', 2, 0, 'ACTIVE'),
       (21, 135, 'Devolución de compra	', '21', 2, 0, 'ACTIVE'),
       (22, 51, 'Inventario y mercaderías', '22', 3, 0, 'ACTIVE'),
       (23, 143, 'Sobrantes de inventario	', '23', 3, 0, 'ACTIVE'),
       (24, 258, 'Faltantes de inventario	', '24', 3, 0, 'ACTIVE'),
       (25, 258, 'Inventario en transito	', '25', 3, 0, 'ACTIVE'),
       (26, 41, 'Inventario en producción	', '26', 3, 0, 'ACTIVE'),
       (27, 174, 'Costos de mano obra	', '27', 3, 0, 'ACTIVE'),
       (28, 174, 'Costos indirectos	', '28', 3, 0, 'ACTIVE'),
       (29, 159, 'Costo de ventas	', '29', 4, 0, 'ACTIVE'),
       (30, 10, 'Cuentas por cobrar', '30', 4, 0, 'ACTIVE'),
       (31, 30, 'Retenciones IVA		', '31', 4, 0, 'ACTIVE'),
       (32, 24, 'Retenciones RENTA	', '32', 4, 0, 'ACTIVE'),
       (33, 93, 'Ventas con IVA gravado	', '33', 4, 0, 'ACTIVE'),
       (34, 126, 'Ventas tarifa 0%	', '34', 4, 0, 'ACTIVE'),
       (35, 93, 'IVA cobrado	', '35', 4, 0, 'ACTIVE'),
       (36, 129, 'Descuento en ventas	', '36', 4, 0, 'ACTIVE'),
       (37, 82, 'Desc. solidario en ventas	', '37', 4, 0, 'ACTIVE'),
       (38, 93, 'Anticipo clientes', '38', 4, 0, 'ACTIVE'),
       (39, 1, 'ICE cobrado	', '39', 4, 0, 'ACTIVE'),
       (40, 130, 'Devolución de venta con IVA gravado', '40', 4, 0, 'ACTIVE'),
       (41, 130, 'Devolución de venta con IVA 0%	', '41', 4, 0, 'ACTIVE'),
       (42, 72, 'Proveedores', '42', 2, 0, 'ACTIVE'),
       (43, 186, 'Transportes y Fletes', '43', 2, 0, 'ACTIVE'),
       (44, 5, 'Caja chica', '44', 1, 0, 'ACTIVE'),
       (45, 271, 'Tarjeta de Credito', '45', 1, 0, 'ACTIVE'),
       (46, 9, 'Clientes', '46', 4, 0, 'ACTIVE'),
       (47, 141, 'Ventas', '47', 4, 0, 'ACTIVE'),
       (48, 145, 'Servicios Prestados', '48', 4, 0, 'ACTIVE'),
       (49, 282, 'Gastos Operacionales', '49', 2, 0, 'ACTIVE'),
       (50, 132, 'Ajustes de Inventario', '01', 3, 0, 'ACTIVE');

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

--
-- Dumping data for table `accounting_config_modules_types`
--

INSERT INTO `accounting_config_modules_types` (`id`, `value`, `description`, `status`)
VALUES (1, 'CAJA Y BANCOS', NULL, 'ACTIVE'),
       (2, 'COMPRAS', NULL, 'ACTIVE'),
       (3, 'INVENTARIOS', NULL, 'ACTIVE'),
       (4, 'VENTAS', NULL, 'ACTIVE');

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

--
-- Dumping data for table `accounting_level`
--

INSERT INTO `accounting_level` (`id`, `value`, `description`, `status`, `color`)
VALUES (1, '1', 'NIVEL 1', 'ACTIVE', '#6b0542'),
       (2, '2', 'NIVEL 2', 'ACTIVE', '#f00404'),
       (3, '3', 'NIVEL 3', 'ACTIVE', '#b30a0a'),
       (4, '4', 'NIVEL 4', 'ACTIVE', '#80082c'),
       (5, '5', 'NIVEL 5', 'ACTIVE', '#8a0808'),
       (6, '6', 'NIVEL 6', 'ACTIVE', '#d90c9f');

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
    `id`                      int(11) NOT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `updated_at`              timestamp NULL DEFAULT NULL,
    `deleted_at`              timestamp NULL DEFAULT NULL,
    `account_gamification_id` int(11) NOT NULL,
    `amount`                  int(11) NOT NULL,
    `type`                    int(11) NOT NULL COMMENT '0=Cash or check deposit(DE) - I\n1= Cash withdrawal(EX)-O\n2=Banking expenses(GB)-O\n3=Collection of card coupons(CC)-I\n4=Negotiated checks(NE)-I\n',
    `input_movement`          int(11) NOT NULL COMMENT '0=OUTPUT\n1=INPUT',
    `description`             text NOT NULL,
    `user_transaction_id`     int(11) NOT NULL COMMENT 'IT CAN BE A NULL ID ONLY IF IT IS OWN OF THE SYSTEM AND IT IS DONE X BEEHIVE',
    `type_money`              int(11) NOT NULL DEFAULT 0 COMMENT '0=BEE\n1=QUEEN'
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

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`)
VALUES (1, 'RBAC', '#', NULL, 2, 'fas fa-user-cog', 2, '#', 1),
       (2, 'Gestion Usuarios', 'user', 1, 3, NULL, 0, 'user', 1),
       (3, 'ADMIN GRID-RBAC', 'user/list', 1, 4, NULL, 1, 'user/list', 1),
       (4, 'Create Formulario', 'user/form', 1, 5, NULL, 1, 'user/form', 1),
       (5, 'Update Formulario', 'user/form', 1, 6, NULL, 1, 'user/form', 1),
       (6, 'Email Validacion', 'user/unique-email', 1, 7, NULL, 1, 'user/unique-email', 1),
       (7, 'Nombre de Usuario Validacion', 'user/unique-username', 1, 8, NULL, 1, 'user/unique-username', 1),
       (8, 'Obtencion de Datos Roles', 'role/list/select', 1, 9, NULL, 1, 'role/list/select', 1),
       (9, 'Cambio de contraseña Validacion anterior contraseña', 'user/check-password-old', 1, 10, NULL, 1,
        'user/check-password-old', 1),
       (10, 'Cambio de contraseña Validacion anterior contraseña', 'user/save', 1, 11, NULL, 1, 'user/save', 1),
       (11, 'Cambio de contraseña Validacion anterior contraseña', 'user/save', 1, 12, NULL, 1, 'user/save', 1),
       (12, 'Gestion Roles', 'role', 1, 13, NULL, 0, 'role', 1),
       (13, 'ADMIN GRID-RBAC', 'role/list', 12, 14, NULL, 1, 'role/list', 1),
       (14, 'Create Formulario', 'role/form', 12, 15, NULL, 1, 'role/form', 1),
       (15, 'Update Formulario', 'role/form', 12, 16, NULL, 1, 'role/form', 1),
       (16, 'Guardar Registro Formulario Roles', 'role/save', 12, 17, NULL, 1, 'role/save', 1),
       (17, 'Gestion Menu', 'actions/manager', 1, 18, NULL, 0, 'actions/manager', 1),
       (18, 'ADMIN GRID-GESTION MENU', 'actions/admin', 17, 19, NULL, 1, 'actions/admin', 1),
       (19, 'Select datos de subproceso Actions', 'actions/listActionsParent', 17, 20, NULL, 1,
        'actions/listActionsParent', 1),
       (20, 'Guardar Registro Formulario Actions', 'actions/save', 17, 21, NULL, 1, 'actions/save', 1),
       (21, 'Guardar Registro Formulario Actions', 'actions/save', 17, 22, NULL, 1, 'actions/save', 1),
       (22, 'Contabilidad', '#', NULL, 23, 'fas fa-cash-register', 2, '#', 1),
       (23, 'Gestion Iva', 'tax/manager', 22, 24, NULL, 0, 'tax/manager', 1),
       (24, 'ADMIN GRID-IVA', 'tax/admin', 22, 25, NULL, 1, 'tax/admin', 1),
       (25, 'Creacion registro Formulario Tax', 'tax/save', 22, 26, NULL, 1, 'tax/save', 1),
       (26, 'Creacion registro Formulario Tax', 'tax/save', 22, 27, NULL, 1, 'tax/save', 1),
       (27, 'Contabilidad Cuentas', 'accountingAccount/manager', 22, 28, NULL, 0, 'accountingAccount/manager', 1),
       (28, 'ADMIN GRID-CONTABILIDAD CUENTAS', 'accountingAccount/admin', 27, 29, NULL, 1, 'accountingAccount/admin',
        1),
       (29, 'Update registro Formulario Accounting', 'accountingAccount/save', 27, 30, NULL, 1,
        'accountingAccount/save', 1),
       (30, 'Creacion registro Formulario Accounting', 'accountingAccount/save', 27, 31, NULL, 1,
        'accountingAccount/save', 1),
       (31, 'Gestion Tipos de Ruc', 'rucType/manager', 22, 32, NULL, 0, 'rucType/manager', 1),
       (32, 'ADMIN GRID-CONTABILIDAD CUENTAS', 'rucType/admin', 31, 33, NULL, 1, 'rucType/admin', 1),
       (33, 'Update registro Formulario Accounting', 'rucType/save', 31, 34, NULL, 1, 'rucType/save', 1),
       (34, 'Creacion registro Formulario Accounting', 'rucType/save', 31, 35, NULL, 1, 'rucType/save', 1),
       (35, 'Gestion Modulos Tipos', 'accountingConfigModulesTypes/manager', 22, 36, NULL, 0,
        'accountingConfigModulesTypes/manager', 1),
       (36, 'ADMIN GRID-CONTABILIDAD MODULOS TIPOS', 'accountingConfigModulesTypes/admin', 35, 37, NULL, 1,
        'accountingConfigModulesTypes/admin', 1),
       (37, 'Update registro Formulario MODULOS TIPOS', 'accountingConfigModulesTypes/save', 35, 38, NULL, 1,
        'accountingConfigModulesTypes/save', 1),
       (38, 'Creacion registro Formulario MODULOS TIPOS', 'accountingConfigModulesTypes/save', 35, 39, NULL, 1,
        'accountingConfigModulesTypes/save', 1),
       (39, 'Gestion Niveles', 'accountingLevel/manager', 22, 40, NULL, 0, 'accountingLevel/manager', 1),
       (40, 'ADMIN GRID-CONTABILIDAD NIVELES', 'accountingLevel/admin', 39, 41, NULL, 1, 'accountingLevel/admin', 1),
       (41, 'Update registro Formulario NIVELES', 'accountingLevel/save', 39, 42, NULL, 1, 'accountingLevel/save', 1),
       (42, 'Creacion registro Formulario NIVELES', 'accountingLevel/save', 39, 43, NULL, 1, 'accountingLevel/save', 1),
       (43, 'Gestion Modulos Contables', 'accountingConfigModulesAccountByAccount/manager', 22, 44, NULL, 0,
        'accountingConfigModulesAccountByAccount/manager', 1),
       (44, 'ADMIN GRID-CONTABILIDAD MODULOS CONTABLES', 'accountingConfigModulesAccountByAccount/admin', 43, 45, NULL,
        1, 'accountingConfigModulesAccountByAccount/admin', 1),
       (45, 'Update registro Formulario MODULOS CONTABLES', 'accountingConfigModulesAccountByAccount/save', 43, 46,
        NULL, 1, 'accountingConfigModulesAccountByAccount/save', 1),
       (46, 'Creacion registro Formulario MODULOS CONTABLES', 'accountingConfigModulesAccountByAccount/save', 43, 47,
        NULL, 1, 'accountingConfigModulesAccountByAccount/save', 1),
       (47, 'Ubicacion', '#', NULL, 48, 'fas fa-map-marked-alt', 2, '#', 1),
       (48, 'Gestion Paises', 'country', 47, 49, NULL, 0, 'country', 1),
       (49, 'ADMIN GRID-country', 'country/list', 48, 50, NULL, 1, 'country/list', 1),
       (50, 'Create Formulario country', 'country/form', 48, 51, NULL, 1, 'country/form', 1),
       (51, 'Update Formulario country', 'country/form', 48, 52, NULL, 1, 'country/form', 1),
       (52, 'Nombre de Usuario Validacion', 'country/unique-name', 48, 53, NULL, 1, 'country/unique-name', 1),
       (53, 'Actualizar Registro country', 'country/save', 48, 54, NULL, 1, 'country/save', 1),
       (54, 'Save Registro country', 'country/save', 48, 55, NULL, 1, 'country/save', 1),
       (55, 'Gestion Provincias/Estados', 'province', 47, 56, NULL, 0, 'province', 1),
       (56, 'ADMIN GRID-country', 'province/list', 55, 57, NULL, 1, 'province/list', 1),
       (57, 'Create Formulario country', 'province/form', 55, 58, NULL, 1, 'province/form', 1),
       (58, 'Update Formulario country', 'province/form', 55, 59, NULL, 1, 'province/form', 1),
       (59, 'Obtencion Valores Paises', 'country/list/select', 55, 60, NULL, 1, 'country/list/select', 1),
       (60, 'Nombre Validacion', 'province/unique-name', 55, 61, NULL, 1, 'province/unique-name', 1),
       (61, 'Actualizar Registro country', 'province/save', 55, 62, NULL, 1, 'province/save', 1),
       (62, 'Save Registro country', 'province/save', 55, 63, NULL, 1, 'province/save', 1),
       (63, 'Gestion Ciudades', 'city', 47, 64, NULL, 0, 'city', 1),
       (64, 'ADMIN MANAGER PAISES-CIUDADES', 'country/list/select', 63, 65, NULL, 1, 'country/list/select', 1),
       (65, 'ADMIN MANAGER PROVINCIAS-CIUDADES', 'province/list/select', 63, 66, NULL, 1, 'province/list/select', 1),
       (66, 'ADMIN GRID-CIUDADES', 'city/list', 63, 67, NULL, 1, 'city/list', 1),
       (67, 'Create Formulario CIUDADES', 'city/form', 63, 68, NULL, 1, 'city/form', 1),
       (68, 'Update Formulario CIUDADES', 'city/form', 63, 69, NULL, 1, 'city/form', 1),
       (69, 'Actualizar Registro CIUDADES', 'city/save', 63, 70, NULL, 1, 'city/save', 1),
       (70, 'Save Registro CIUDADES', 'city/save', 63, 71, NULL, 1, 'city/save', 1),
       (71, 'Gestion Zonas', 'zone', 47, 72, NULL, 0, 'zone', 1),
       (72, 'ADMIN MANAGER PAISES-ZONAS', 'country/list/select', 71, 73, NULL, 1, 'country/list/select', 1),
       (73, 'ADMIN MANAGER PROVINCIAS-ZONAS', 'province/list/select', 71, 74, NULL, 1, 'province/list/select', 1),
       (74, 'ADMIN MANAGER ciudades-ZONAS', 'city/list/select', 71, 75, NULL, 1, 'city/list/select', 1),
       (75, 'ADMIN MANAGER mapa-ZONAS', 'zone/list/map', 71, 76, NULL, 1, 'zone/list/map', 1),
       (76, 'ADMIN GRID-ZONAS', 'zone/list', 71, 77, NULL, 1, 'zone/list', 1),
       (77, 'Create Formulario ZONAS', 'zone/form', 71, 78, NULL, 1, 'zone/form', 1),
       (78, 'Unique Formulario ZONAS', 'zone/unique-name', 71, 79, NULL, 1, 'zone/unique-name', 1),
       (79, 'Update Formulario ZONAS', 'zone/form', 71, 80, NULL, 1, 'zone/form', 1),
       (80, 'Actualizar Registro ZONAS', 'zone/save', 71, 81, NULL, 1, 'zone/save', 1),
       (81, 'Save Registro ZONAS', 'zone/save', 71, 82, NULL, 1, 'zone/save', 1),
       (82, 'Config Envios', '#', NULL, 83, 'fas fa-truck', 2, '#', 1),
       (83, 'Formas de Envio', 'shippingRateKindsOfWay/manager', 82, 84, NULL, 0, 'shippingRateKindsOfWay/manager', 1),
       (84, 'ADMIN GRID-FORMAS DE ENVIO', 'shippingRateKindsOfWay/admin', 83, 85, NULL, 1,
        'shippingRateKindsOfWay/admin', 1),
       (85, 'Creacion registro Formulario FORMAS DE ENVIO', 'shippingRateKindsOfWay/save', 83, 86, NULL, 1,
        'shippingRateKindsOfWay/save', 1),
       (86, 'Creacion registro Formulario FORMAS DE ENVIO', 'shippingRateKindsOfWay/save', 83, 87, NULL, 1,
        'shippingRateKindsOfWay/save', 1),
       (87, 'Empresas de Envio', 'shippingRateBusiness/manager', 82, 88, NULL, 0, 'shippingRateBusiness/manager', 1),
       (88, 'ADMIN GRID-EMPRESAS DE ENVIO', 'shippingRateBusiness/admin', 87, 89, NULL, 1, 'shippingRateBusiness/admin',
        1),
       (89, 'Creacion registro Formulario EMPRESAS DE ENVIO', 'shippingRateBusiness/save', 87, 90, NULL, 1,
        'shippingRateBusiness/save', 1),
       (90, 'Creacion registro Formulario EMPRESAS DE ENVIO', 'shippingRateBusiness/save', 87, 91, NULL, 1,
        'shippingRateBusiness/save', 1),
       (91, 'Boton Administracion de Servicios Envios', 'shippingRateServices/admin', 87, 92, NULL, 1,
        'shippingRateServices/admin', 1),
       (92, 'ADMIN GRID-Servicios Envios', 'shippingRateServices/admin', 91, 93, NULL, 1, 'shippingRateServices/admin',
        1),
       (93, 'Creacion registro Formulario Servicios Envios', 'shippingRateServices/save', 91, 94, NULL, 1,
        'shippingRateServices/save', 1),
       (94, 'Creacion registro Formulario Servicios Envios', 'shippingRateServices/save', 91, 95, NULL, 1,
        'shippingRateServices/save', 1),
       (95, 'Boton Administracion de Factor de Conversion', 'shippingRateBusinessByConversionFactor/admin', 87, 96,
        NULL, 1, 'shippingRateBusinessByConversionFactor/admin', 1),
       (96, 'ADMIN GRID-Factor de Conversion', 'shippingRateBusinessByConversionFactor/admin', 95, 97, NULL, 1,
        'shippingRateBusinessByConversionFactor/admin', 1),
       (97, 'Creacion registro Formulario Factor de Conversion', 'shippingRateBusinessByConversionFactor/save', 95, 98,
        NULL, 1, 'shippingRateBusinessByConversionFactor/save', 1),
       (98, 'Creacion registro Formulario Factor de Conversion', 'shippingRateBusinessByConversionFactor/save', 95, 99,
        NULL, 1, 'shippingRateBusinessByConversionFactor/save', 1),
       (99, 'form Get Servicios', 'shippingRateKindsOfWay/listSelect2', 95, 100, NULL, 1,
        'shippingRateKindsOfWay/listSelect2', 1),
       (100, 'form Get Formas de envio', 'shippingRateKindsOfWay/listSelect2', 95, 101, NULL, 1,
        'shippingRateKindsOfWay/listSelect2', 1),
       (101, 'form Get Medidas', 'productMeasureType/listSelect2', 95, 102, NULL, 1, 'productMeasureType/listSelect2',
        1),
       (102, 'Informacion Adicional', '#', NULL, 103, 'fas fa-address-card', 2, '#', 1),
       (103, 'Tipo de Email', 'informationMailType/manager', 102, 104, NULL, 0, 'informationMailType/manager', 1),
       (104, 'ADMIN GRID-Tipo de Email', 'informationMailType/admin', 103, 105, NULL, 1, 'informationMailType/admin',
        1),
       (105, 'Creacion registro Formulario Tipo de Email', 'informationMailType/save', 103, 106, NULL, 1,
        'informationMailType/save', 1),
       (106, 'Creacion registro Formulario Tipo de Email', 'informationMailType/save', 103, 107, NULL, 1,
        'informationMailType/save', 1),
       (107, 'Tipos de Redes Sociales', 'informationSocialNetworkType/manager', 102, 108, NULL, 0,
        'informationSocialNetworkType/manager', 1),
       (108, 'ADMIN GRID-Tipos de Redes Sociales', 'informationSocialNetworkType/admin', 107, 109, NULL, 1,
        'informationSocialNetworkType/admin', 1),
       (109, 'Creacion registro Formulario Tipos de Redes Sociales', 'informationSocialNetworkType/save', 107, 110,
        NULL, 1, 'informationSocialNetworkType/save', 1),
       (110, 'Creacion registro Formulario Tipos de Redes Sociales', 'informationSocialNetworkType/save', 107, 111,
        NULL, 1, 'informationSocialNetworkType/save', 1),
       (111, 'Tipos de Telefonos', 'informationPhoneType/manager', 102, 112, NULL, 0, 'informationPhoneType/manager',
        1),
       (112, 'ADMIN GRID-Tipos de Telefonos', 'informationPhoneType/admin', 111, 113, NULL, 1,
        'informationPhoneType/admin', 1),
       (113, 'Creacion registro Formulario Tipos de Telefonos', 'informationPhoneType/save', 111, 114, NULL, 1,
        'informationPhoneType/save', 1),
       (114, 'Creacion registro Formulario Tipos de Telefonos', 'informationPhoneType/save', 111, 115, NULL, 1,
        'informationPhoneType/save', 1),
       (115, 'Tipos de Direccion', 'informationAddressType/manager', 102, 116, NULL, 0,
        'informationAddressType/manager', 1),
       (116, 'ADMIN GRID-Tipos de Direccion', 'informationAddressType/admin', 115, 117, NULL, 1,
        'informationAddressType/admin', 1),
       (117, 'Creacion registro Formulario Tipos de Direccion', 'informationAddressType/save', 115, 118, NULL, 1,
        'informationAddressType/save', 1),
       (118, 'Creacion registro Formulario Tipos de Direccion', 'informationAddressType/save', 115, 119, NULL, 1,
        'informationAddressType/save', 1),
       (119, 'Config Productos', '#', NULL, 120, 'fab fa-product-hunt', 2, '#', 1),
       (120, 'Categorias', 'productCategory/manager', 119, 121, NULL, 0, 'productCategory/manager', 1),
       (121, 'ADMIN GRID-Categorias', 'productCategory/admin', 120, 122, NULL, 1, 'productCategory/admin', 1),
       (122, 'Creacion registro Formulario Categorias', 'productCategory/save', 120, 123, NULL, 1,
        'productCategory/save', 1),
       (123, 'Creacion registro Formulario Categorias', 'productCategory/save', 120, 124, NULL, 1,
        'productCategory/save', 1),
       (124, 'Boton Administracion Traduccion', 'languageProductCategory/admin', 120, 125, NULL, 1,
        'languageProductCategory/admin', 1),
       (125, 'ADMIN GRID-Traduccion', 'languageProductCategory/admin', 124, 126, NULL, 1,
        'languageProductCategory/admin', 1),
       (126, 'Creacion registro Formulario Traduccion', 'languageProductCategory/save', 124, 127, NULL, 1,
        'languageProductCategory/save', 1),
       (127, 'Creacion registro Formulario Traduccion', 'languageProductCategory/save', 124, 128, NULL, 1,
        'languageProductCategory/save', 1),
       (128, 'Get Formulario Idiomas', 'language/listSelect2', 124, 129, NULL, 1, 'language/listSelect2', 1),
       (129, 'Boton Eliminar Grid', 'languageProductCategory/delete', 120, 130, NULL, 1,
        'languageProductCategory/delete', 1),
       (130, 'SubCategorias', 'productSubcategory/manager', 119, 131, NULL, 0, 'productSubcategory/manager', 1),
       (131, 'ADMIN GRID-SubCategorias', 'productSubcategory/admin', 130, 132, NULL, 1, 'productSubcategory/admin', 1),
       (132, 'Creacion registro Formulario SubCategorias', 'productSubcategory/save', 130, 133, NULL, 1,
        'productSubcategory/save', 1),
       (133, 'Creacion registro Formulario SubCategorias', 'productCategory/save', 130, 134, NULL, 1,
        'productCategory/save', 1),
       (134, 'Obtencion de Datos Categorias', 'productCategory/listSelect2', 130, 135, NULL, 1,
        'productCategory/listSelect2', 1),
       (135, 'Boton Administracion Traduccion Subcategoria Producto', 'languageProductCategory/admin', 130, 136, NULL,
        1, 'languageProductCategory/admin', 1),
       (136, 'ADMIN GRID- Traduccion Subcategoria Producto', 'languageProductSubcategory/admin', 135, 137, NULL, 1,
        'languageProductSubcategory/admin', 1),
       (137, 'Creacion registro Formulario Traduccion Subcategoria Producto', 'languageProductSubcategory/save', 135,
        138, NULL, 1, 'languageProductSubcategory/save', 1),
       (138, 'Creacion registro Formulario Traduccion Subcategoria Producto', 'languageProductSubcategory/save', 135,
        139, NULL, 1, 'languageProductSubcategory/save', 1),
       (139, 'Get Formulario Idiomas Subcategoria Producto', 'language/listSelect2', 135, 140, NULL, 1,
        'language/listSelect2', 1),
       (140, 'Boton Eliminar Grid', 'languageProductSubcategory/delete', 130, 141, NULL, 1,
        'languageProductSubcategory/delete', 1),
       (141, 'Colores', 'productColor/manager', 119, 142, NULL, 0, 'productColor/manager', 1),
       (142, 'ADMIN GRID-Colores', 'productColor/admin', 141, 143, NULL, 1, 'productColor/admin', 1),
       (143, 'Creacion registro Formulario Colores', 'productColor/save', 141, 144, NULL, 1, 'productColor/save', 1),
       (144, 'Creacion registro Formulario Colores', 'productColor/save', 141, 145, NULL, 1, 'productColor/save', 1),
       (145, 'Boton Administracion Traduccion Colores', 'languageProductColor/admin', 141, 146, NULL, 1,
        'languageProductColor/admin', 1),
       (146, 'ADMIN GRID-Traduccion Colores', 'languageProductColor/admin', 145, 147, NULL, 1,
        'languageProductColor/admin', 1),
       (147, 'Creacion registro Formulario Traduccion Colores', 'languageProductColor/save', 145, 148, NULL, 1,
        'languageProductColor/save', 1),
       (148, 'Creacion registro Formulario Traduccion Colores', 'languageProductColor/save', 145, 149, NULL, 1,
        'languageProductColor/save', 1),
       (149, 'Get Formulario Idiomas Colores', 'language/listSelect2', 145, 150, NULL, 1, 'language/listSelect2', 1),
       (150, 'Boton Eliminar Grid Colores', 'languageProductColor/delete', 141, 151, NULL, 1,
        'languageProductColor/delete', 1),
       (151, 'Tamaños', 'productSizes/manager', 119, 152, NULL, 0, 'productSizes/manager', 1),
       (152, 'ADMIN GRID-Tamaños', 'productSizes/admin', 151, 153, NULL, 1, 'productSizes/admin', 1),
       (153, 'Creacion registro Formulario Tamaños', 'productSizes/save', 151, 154, NULL, 1, 'productSizes/save', 1),
       (154, 'Creacion registro Formulario Tamaños', 'productSizes/save', 151, 155, NULL, 1, 'productSizes/save', 1),
       (155, 'Marcas', 'productTrademark/manager', 119, 156, NULL, 0, 'productTrademark/manager', 1),
       (156, 'ADMIN GRID-Marcas', 'productTrademark/admin', 155, 157, NULL, 1, 'productTrademark/admin', 1),
       (157, 'Creacion registro Formulario Marcas', 'productTrademark/save', 155, 158, NULL, 1, 'productTrademark/save',
        1),
       (158, 'Creacion registro Formulario Marcas', 'productTrademark/save', 155, 159, NULL, 1, 'productTrademark/save',
        1),
       (159, 'Boton Administracion Traduccion Marcas', 'languageProductTrademark/admin', 155, 160, NULL, 1,
        'languageProductTrademark/admin', 1),
       (160, 'ADMIN GRID-Traduccion Marcas', 'languageProductTrademark/admin', 159, 161, NULL, 1,
        'languageProductTrademark/admin', 1),
       (161, 'Creacion registro Formulario Traduccion Marcas', 'languageProductTrademark/save', 159, 162, NULL, 1,
        'languageProductTrademark/save', 1),
       (162, 'Creacion registro Formulario Traduccion Marcas', 'languageProductTrademark/save', 159, 163, NULL, 1,
        'languageProductTrademark/save', 1),
       (163, 'Get Formulario Idiomas Marcas', 'language/listSelect2', 159, 164, NULL, 1, 'language/listSelect2', 1),
       (164, 'Boton Eliminar Grid Traduccion Marcas', 'languageProductTrademark/delete', 155, 165, NULL, 1,
        'languageProductTrademark/delete', 1),
       (165, 'Medidas', 'productMeasureType/manager', 119, 166, NULL, 0, 'productMeasureType/manager', 1),
       (166, 'ADMIN GRID-Medidas', 'productMeasureType/admin', 165, 167, NULL, 1, 'productMeasureType/admin', 1),
       (167, 'Creacion registro Formulario Medidas', 'productMeasureType/save', 165, 168, NULL, 1,
        'productMeasureType/save', 1),
       (168, 'Creacion registro Formulario Medidas', 'productMeasureType/save', 165, 169, NULL, 1,
        'productMeasureType/save', 1),
       (169, 'Boton Administracion Traduccion Medidas', 'languageProductMeasureType/admin', 165, 170, NULL, 1,
        'languageProductMeasureType/admin', 1),
       (170, 'ADMIN GRID-Traduccion Medidas', 'languageProductMeasureType/admin', 169, 171, NULL, 1,
        'languageProductMeasureType/admin', 1),
       (171, 'Creacion registro Formulario Traduccion Medidas', 'languageProductMeasureType/save', 169, 172, NULL, 1,
        'languageProductMeasureType/save', 1),
       (172, 'Creacion registro Formulario Traduccion Medidas', 'languageProductMeasureType/save', 169, 173, NULL, 1,
        'languageProductMeasureType/save', 1),
       (173, 'Get Formulario Idiomas Medidas', 'language/listSelect2', 169, 174, NULL, 1, 'language/listSelect2', 1),
       (174, 'Boton Eliminar Grid Traduccion Medidas', 'languageProductMeasureType/delete', 165, 175, NULL, 1,
        'languageProductMeasureType/delete', 1),
       (175, 'Persona', '#', NULL, 176, 'fas fa-user-clock', 2, '#', 1),
       (176, 'Nacionalidad', 'peopleNationality/manager', 175, 177, NULL, 0, 'peopleNationality/manager', 1),
       (177, 'ADMIN GRID-Nacionalidad', 'peopleNationality/admin', 176, 178, NULL, 1, 'peopleNationality/admin', 1),
       (178, 'Creacion registro Formulario Nacionalidad', 'peopleNationality/save', 176, 179, NULL, 1,
        'peopleNationality/save', 1),
       (179, 'Creacion registro Formulario Nacionalidad', 'peopleNationality/save', 176, 180, NULL, 1,
        'peopleNationality/save', 1),
       (180, 'Get Formulario Paises', 'country/list/select2', 176, 181, NULL, 1, 'country/list/select2', 1),
       (181, 'Tipos de Identificacion', 'peopleTypeIdentification/manager', 175, 182, NULL, 0,
        'peopleTypeIdentification/manager', 1),
       (182, 'ADMIN GRID-Tipos de Identificacion', 'peopleTypeIdentification/admin', 181, 183, NULL, 1,
        'peopleTypeIdentification/admin', 1),
       (183, 'Creacion registro Formulario Tipos de Identificacion', 'peopleTypeIdentification/save', 181, 184, NULL, 1,
        'peopleTypeIdentification/save', 1),
       (184, 'Creacion registro Formulario Tipos de Identificacion', 'peopleTypeIdentification/save', 181, 185, NULL, 1,
        'peopleTypeIdentification/save', 1),
       (185, 'Profesion', 'peopleProfession/manager', 175, 186, NULL, 0, 'peopleProfession/manager', 1),
       (186, 'ADMIN GRID-Profesion', 'peopleProfession/admin', 185, 187, NULL, 1, 'peopleProfession/admin', 1),
       (187, 'Creacion registro Formulario Profesion', 'peopleProfession/save', 185, 188, NULL, 1,
        'peopleProfession/save', 1),
       (188, 'Creacion registro Formulario Profesion', 'peopleProfession/save', 185, 189, NULL, 1,
        'peopleProfession/save', 1),
       (189, 'Genero', 'peopleGender/manager', 175, 190, NULL, 0, 'peopleGender/manager', 1),
       (190, 'ADMIN GRID-Genero', 'peopleGender/admin', 189, 191, NULL, 1, 'peopleGender/admin', 1),
       (191, 'Creacion registro Formulario Genero', 'peopleGender/save', 189, 192, NULL, 1, 'peopleGender/save', 1),
       (192, 'Creacion registro Formulario Genero', 'peopleGender/save', 189, 193, NULL, 1, 'peopleGender/save', 1),
       (193, 'Odontograma', '#', NULL, 194, 'fas fa-user-cog', 2, '#', 1),
       (194, 'Piezas Posiciones', 'referencePiecePosition', 193, 195, NULL, 0, 'referencePiecePosition', 1),
       (195, 'ADMIN GRID-Piezas Posiciones', 'referencePiecePosition/list', 194, 196, NULL, 1,
        'referencePiecePosition/list', 1),
       (196, 'Create Formulario Piezas Posiciones', 'referencePiecePosition/form', 194, 197, NULL, 1,
        'referencePiecePosition/form', 1),
       (197, 'Update Formulario Piezas Posiciones', 'referencePiecePosition/form', 194, 198, NULL, 1,
        'referencePiecePosition/form', 1),
       (198, 'Actualizar Informacion Piezas Posiciones', 'referencePiecePosition/save', 194, 199, NULL, 1,
        'referencePiecePosition/save', 1),
       (199, 'Crear Informacion Piezas Posiciones', 'referencePiecePosition/save', 194, 200, NULL, 1,
        'referencePiecePosition/save', 1),
       (200, 'Piezas Dentales', 'dentalPiece', 193, 201, NULL, 0, 'dentalPiece', 1),
       (201, 'ADMIN GRID-Piezas Dentales', 'dentalPiece/list', 200, 202, NULL, 1, 'dentalPiece/list', 1),
       (202, 'Create Formulario Piezas Dentales', 'dentalPiece/form', 200, 203, NULL, 1, 'dentalPiece/form', 1),
       (203, 'Update Formulario Piezas Dentales', 'dentalPiece/form', 200, 204, NULL, 1, 'dentalPiece/form', 1),
       (204, 'Actualizar Informacion Piezas Dentales', 'dentalPiece/save', 200, 205, NULL, 1, 'dentalPiece/save', 1),
       (205, 'Crear Informacion Piezas Dentales', 'dentalPiece/save', 200, 206, NULL, 1, 'dentalPiece/save', 1),
       (206, 'Piezas Referencia', 'referencePiece', 193, 213, NULL, 0, 'referencePiece', 1),
       (207, 'ADMIN GRID-Piezas Referencia', 'referencePiece/list', 206, 208, NULL, 1, 'referencePiece/list', 1),
       (208, 'Create Formulario Piezas Referencia', 'referencePiece/form', 206, 209, NULL, 1, 'referencePiece/form', 1),
       (209, 'Update Formulario Piezas Referencia', 'referencePiece/form', 206, 210, NULL, 1, 'referencePiece/form', 1),
       (210, 'Actualizar Informacion Piezas Referencia', 'referencePiece/save', 206, 211, NULL, 1,
        'referencePiece/save', 1),
       (211, 'Crear Informacion Piezas Referencia', 'referencePiece/save', 206, 212, NULL, 1, 'referencePiece/save', 1),
       (212, 'Referencias Tipos', 'referencePieceType', 193, 207, NULL, 0, 'referencePieceType', 1),
       (213, 'ADMIN GRID-Referencias Tipos', 'referencePieceType/list', 212, 214, NULL, 1, 'referencePieceType/list',
        1),
       (214, 'Create Formulario Referencias Tipos', 'referencePieceType/form', 212, 215, NULL, 1,
        'referencePieceType/form', 1),
       (215, 'Update Formulario Piezas Referencia', 'referencePieceType/form', 212, 216, NULL, 1,
        'referencePieceType/form', 1),
       (216, 'Actualizar Informacion Referencias Tipos', 'referencePieceType/save', 212, 217, NULL, 1,
        'referencePieceType/save', 1),
       (217, 'Crear Informacion Referencias Tipos', 'referencePieceType/save', 212, 218, NULL, 1,
        'referencePieceType/save', 1),
       (218, 'Antecedentes', 'antecedent', 193, 219, NULL, 0, 'antecedent', 1),
       (219, 'ADMIN GRID-Antecedentes', 'antecedent/list', 218, 220, NULL, 1, 'antecedent/list', 1),
       (220, 'Create Formulario Antecedentes', 'antecedent/form', 218, 221, NULL, 1, 'antecedent/form', 1),
       (221, 'Update Formulario Antecedentes', 'antecedent/form', 218, 222, NULL, 1, 'antecedent/form', 1),
       (222, 'Actualizar Informacion Antecedentes', 'antecedent/save', 218, 223, NULL, 1, 'antecedent/save', 1),
       (223, 'Crear Informacion Antecedentes', 'antecedent/save', 218, 224, NULL, 1, 'antecedent/save', 1),
       (224, 'Examenes Clinicos', 'clinicalExam', 193, 225, NULL, 0, 'clinicalExam', 1),
       (225, 'ADMIN GRID-Examenes Clinicos', 'clinicalExam/list', 224, 226, NULL, 1, 'clinicalExam/list', 1),
       (226, 'Create Formulario Examenes Clinicos', 'clinicalExam/form', 224, 227, NULL, 1, 'clinicalExam/form', 1),
       (227, 'Update Formulario Examenes Clinicos', 'clinicalExam/form', 224, 228, NULL, 1, 'clinicalExam/form', 1),
       (228, 'Actualizar Informacion Examenes Clinicos', 'clinicalExam/save', 224, 229, NULL, 1, 'clinicalExam/save',
        1),
       (229, 'Crear Informacion Examenes Clinicos', 'clinicalExam/save', 224, 230, NULL, 1, 'clinicalExam/save', 1),
       (230, 'Config Eventos', '#', NULL, 231, 'fas fa-table-tennis', 2, '#', 1),
       (231, 'Tipos de Eventos', 'eventsTrailsTypes/manager', 230, 232, NULL, 0, 'eventsTrailsTypes/manager', 1),
       (232, 'ADMIN GRID-Nacionalidad', 'eventsTrailsTypes/admin', 231, 233, NULL, 1, 'eventsTrailsTypes/admin', 1),
       (233, 'Creacion registro Formulario Nacionalidad', 'eventsTrailsTypes/save', 231, 234, NULL, 1,
        'eventsTrailsTypes/save', 1),
       (234, 'Creacion registro Formulario Nacionalidad', 'eventsTrailsTypes/save', 231, 235, NULL, 1,
        'eventsTrailsTypes/save', 1),
       (235, 'Dashboard', 'dashboardManager', NULL, 1, 'remixicon-dashboard-line', 0, 'home', 0),
       (236, 'Dashboard Business', 'managerBusiness', NULL, 236, 'remixicon-dashboard-line', 1, 'managerBusiness', 0),
       (237, 'Empresa', '#', NULL, 237, 'fas fa-business-time', 1, '#', 1),
       (238, 'Idiomas', 'businessByLanguage/admin', 237, 238, NULL, 1, 'businessByLanguage/admin', 1),
       (239, 'ADMIN GRID-Idiomas', 'businessByLanguage/admin', 238, 239, NULL, 1, 'businessByLanguage/admin', 1),
       (240, 'Update registro Formulario Idiomas', 'businessByLanguage/save', 238, 240, NULL, 1,
        'businessByLanguage/save', 1),
       (241, 'Creacion registro Formulario Idiomas', 'businessByLanguage/save', 238, 241, NULL, 1,
        'businessByLanguage/save', 1),
       (242, 'Obtencion Valores Formulario Idiomas', 'language/listSelect2', 238, 242, NULL, 1, 'language/listSelect2',
        1),
       (243, 'Iva', 'taxByBusiness/admin', 237, 243, NULL, 1, 'taxByBusiness/admin', 1),
       (244, 'ADMIN GRID-Iva', 'taxByBusiness/admin', 243, 244, NULL, 1, 'taxByBusiness/admin', 1),
       (245, 'Update registro Formulario Iva', 'taxByBusiness/save', 243, 245, NULL, 1, 'taxByBusiness/save', 1),
       (246, 'Creacion registro Formulario Iva', 'taxByBusiness/save', 243, 246, NULL, 1, 'taxByBusiness/save', 1),
       (247, 'Obtencion Valores Formulario Iva', 'tax/listSelect2', 243, 247, NULL, 1, 'tax/listSelect2', 1),
       (248, 'Galeria Empresa', 'business/gallery/adminBusiness', 237, 248, NULL, 1, 'business/gallery/adminBusiness',
        1),
       (249, 'ADMIN GRID- Galeria Empresa', 'business/gallery/adminBusiness', 248, 249, NULL, 1,
        'business/gallery/adminBusiness', 1),
       (250, 'Update registro Formulario Galeria Empresa', 'business/gallery/saveBusiness', 248, 250, NULL, 1,
        'business/gallery/saveBusiness', 1),
       (251, 'Creacion registro Formulario Galeria Empresa', 'business/gallery/saveBusiness', 248, 251, NULL, 1,
        'business/gallery/saveBusiness', 1),
       (252, 'Horarios', 'business/schedules', 237, 252, NULL, 1, 'business/schedules', 1),
       (253, 'ADMIN GRID- Horarios', 'business/schedules', 252, 253, NULL, 1, 'business/schedules', 1),
       (254, 'Update registro Formulario Horarios', 'business/businessBySchedules/saveSchedules', 252, 254, NULL, 1,
        'business/businessBySchedules/saveSchedules', 1),
       (255, 'Creacion registro Formulario Horarios', 'business/businessBySchedules/saveSchedules', 252, 255, NULL, 1,
        'business/businessBySchedules/saveSchedules', 1),
       (256, 'Historia', 'businessByHistory/admin', 237, 256, NULL, 1, 'businessByHistory/admin', 1),
       (257, 'ADMIN GRID- Historia', 'businessByHistory/admin', 256, 257, NULL, 1, 'businessByHistory/admin', 1),
       (258, 'Update registro Formulario Historia', 'businessByHistory/save', 256, 258, NULL, 1,
        'businessByHistory/save', 1),
       (259, 'Creacion registro Formulario Historia', 'businessByHistory/save', 256, 259, NULL, 1,
        'businessByHistory/save', 1),
       (260, 'Button Manager- Multmedia Historia', 'businessByHistoryByData/admin', 256, 260, NULL, 1,
        'businessByHistoryByData/admin', 1),
       (261, 'ADMIN GRID- Multmedia Historia', 'businessByHistoryByData/admin', 260, 261, NULL, 1,
        'businessByHistoryByData/admin', 1),
       (262, 'Update registro Formulario Multmedia Historia', 'businessByHistoryByData/save', 260, 262, NULL, 1,
        'businessByHistoryByData/save', 1),
       (263, 'Creacion registro Formulario Multmedia Historia', 'businessByHistoryByData/save', 260, 263, NULL, 1,
        'businessByHistoryByData/save', 1),
       (264, 'Mision/Vision', 'businessByInformationCustom/admin', 237, 264, NULL, 1,
        'businessByInformationCustom/admin', 1),
       (265, 'ADMIN GRID- Mision/Vision', 'businessByInformationCustom/admin', 264, 265, NULL, 1,
        'businessByInformationCustom/admin', 1),
       (266, 'Update registro Formulario Mision/Vision', 'businessByInformationCustom/save', 264, 266, NULL, 1,
        'businessByInformationCustom/save', 1),
       (267, 'Creacion registro Formulario Mision/Vision', 'businessByInformationCustom/save', 264, 267, NULL, 1,
        'businessByInformationCustom/save', 1),
       (268, 'Counters', 'businessCounterCustom/admin', 237, 268, NULL, 1, 'businessCounterCustom/admin', 1),
       (269, 'ADMIN GRID- Counters', 'businessCounterCustomByData/admin', 268, 269, NULL, 1,
        'businessCounterCustomByData/admin', 1),
       (270, 'Update registro Formulario Counters', 'businessCounterCustom/save', 268, 270, NULL, 1,
        'businessCounterCustom/save', 1),
       (271, 'Creacion registro Formulario Counters', 'businessCounterCustom/save', 268, 271, NULL, 1,
        'businessCounterCustom/save', 1),
       (272, 'Button Manager- Multmedia Counters', 'businessCounterCustomByData/admin', 268, 272, NULL, 1,
        'businessCounterCustomByData/admin', 1),
       (273, 'ADMIN GRID- Datos Counters', 'businessCounterCustomByData/admin', 272, 273, NULL, 1,
        'businessCounterCustomByData/admin', 1),
       (274, 'Update registro Formulario Datos Counters', 'businessCounterCustomByData/save', 272, 274, NULL, 1,
        'businessCounterCustomByData/save', 1),
       (275, 'Creacion registro Formulario Datos Counters', 'businessCounterCustomByData/save', 272, 275, NULL, 1,
        'businessCounterCustomByData/save', 1),
       (276, 'Empresas Aliadas', 'businessByPartnerCompanies/admin', 237, 276, NULL, 1,
        'businessByPartnerCompanies/admin', 1),
       (277, 'ADMIN GRID- Empresas Aliadas', 'businessByPartnerCompanies/admin', 276, 277, NULL, 1,
        'businessByPartnerCompanies/admin', 1),
       (278, 'Update registro Formulario Empresas Aliadas', 'businessByPartnerCompanies/save', 276, 278, NULL, 1,
        'businessByPartnerCompanies/save', 1),
       (279, 'Creacion registro Formulario Empresas Aliadas', 'businessByPartnerCompanies/save', 276, 279, NULL, 1,
        'businessByPartnerCompanies/save', 1),
       (280, 'RRHH', '#', NULL, 280, 'fa fa-sitemap', 1, '#', 1),
       (281, 'Departamentos', 'business/humanResourcesDepartment/admin', 280, 281, NULL, 1,
        'business/humanResourcesDepartment/admin', 1),
       (282, 'ADMIN GRID - Departamentos', 'business/humanResourcesDepartment/admin', NULL, 282, NULL, 1,
        'business/humanResourcesDepartment/admin', 1),
       (283, 'Update registro Formulario Departamentos', 'business/humanResourcesDepartment/save', NULL, 283, NULL, 1,
        'business/humanResourcesDepartment/save', 1),
       (284, 'Creacion registro Formulario Departamentos', 'business/humanResourcesDepartment/save', NULL, 284, NULL, 1,
        'business/humanResourcesDepartment/save', 1),
       (285, 'Personal', 'business/humanResourcesEmployeeProfile/admin', 280, 285, NULL, 1,
        'business/humanResourcesEmployeeProfile/admin', 1),
       (286, 'ADMIN GRID - Personal', 'business/humanResourcesEmployeeProfile/admin', 285, 286, NULL, 1,
        'business/humanResourcesEmployeeProfile/admin', 1),
       (287, 'Update registro Formulario Personal', 'business/humanResourcesEmployeeProfile/save', 285, 287, NULL, 1,
        'business/humanResourcesEmployeeProfile/save', 1),
       (288, 'Creacion registro Formulario Personal', 'business/humanResourcesEmployeeProfile/save', 285, 288, NULL, 1,
        'business/humanResourcesEmployeeProfile/save', 1),
       (289, 'Obtencion de datos o Formulario Departamentos Personal', 'business/humanResourcesDepartment/listAll', 285,
        289, NULL, 1, 'business/humanResourcesDepartment/listAll', 1),
       (290, 'Button Manager- Direcciones Personal', 'business/informationAddress/admin', 285, 290, NULL, 1,
        'business/informationAddress/admin', 1),
       (291, 'ADMIN GRID - Direcciones Personal', 'business/informationAddress/admin', 290, 291, NULL, 1,
        'business/informationAddress/admin', 1),
       (292, 'Update registro Formulario Direcciones Personal', 'business/informationAddress/save', 290, 292, NULL, 1,
        'business/informationAddress/save', 1),
       (293, 'Creacion registro Formulario Direcciones Personal', 'business/informationAddress/save', 290, 293, NULL, 1,
        'business/informationAddress/save', 1),
       (294, 'Obtencion datos Tipos de Direccion Formulario Direcciones Personal', 'business/informationAddress/save',
        290, 294, NULL, 1, 'business/informationAddress/save', 1),
       (295, 'Button Manager- Telefonos Personal', 'business/informationAddress/admin', 285, 295, NULL, 1,
        'business/informationAddress/admin', 1),
       (296, 'ADMIN GRID - Telefonos Personal', 'business/informationAddress/admin', 295, 296, NULL, 1,
        'business/informationAddress/admin', 1),
       (297, 'Update registro Formulario Telefonos Personal', 'business/informationAddress/save', 295, 297, NULL, 1,
        'business/informationAddress/save', 1),
       (298, 'Creacion registro Formulario Telefonos Personal', 'business/informationAddress/save', 295, 298, NULL, 1,
        'business/informationAddress/save', 1),
       (299, 'Obtencion datos Tipos de Telefonos Formulario Direcciones Personal', 'informationPhoneType/listSelect2',
        295, 299, NULL, 1, 'informationPhoneType/listSelect2', 1),
       (300, 'Obtencion datos Tipos de Operadoras Formulario Direcciones Personal',
        'informationPhoneOperator/listSelect2', 295, 300, NULL, 1, 'informationPhoneOperator/listSelect2', 1),
       (301, 'Button Manager- Emails Personal', 'business/informationMail/admin', 285, 301, NULL, 1,
        'business/informationMail/admin', 1),
       (302, 'ADMIN GRID - Emails Personal', 'business/informationMail/admin', 301, 302, NULL, 1,
        'business/informationMail/admin', 1),
       (303, 'Update registro Formulario Emails Personal', 'business/informationMail/save', 301, 303, NULL, 1,
        'business/informationMail/save', 1),
       (304, 'Creacion registro Formulario Emails Personal', 'business/informationMail/save', 301, 304, NULL, 1,
        'business/informationMail/save', 1),
       (305, 'Obtencion datos Tipos de Emails Formulario Personal', 'informationMailType/listSelect2', 301, 305, NULL,
        1, 'informationMailType/listSelect2', 1),
       (306, 'Button Manager- Emails Personal', 'business/informationMail/admin', 285, 306, NULL, 1,
        'business/informationMail/admin', 1),
       (307, 'ADMIN GRID - Emails Personal', 'business/informationMail/admin', 306, 307, NULL, 1,
        'business/informationMail/admin', 1),
       (308, 'Update registro Formulario Emails Personal', 'business/informationMail/save', 306, 308, NULL, 1,
        'business/informationMail/save', 1),
       (309, 'Creacion registro Formulario Emails Personal', 'business/informationMail/save', 306, 309, NULL, 1,
        'business/informationMail/save', 1),
       (310, 'Obtencion datos Tipos de Emails Formulario Personal', 'informationMailType/listSelect2', 306, 310, NULL,
        1, 'informationMailType/listSelect2', 1),
       (311, 'Button Manager- Redes Sociales Personal', 'business/informationSocialNetwork/admin', 285, 311, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (312, 'ADMIN GRID - Redes Sociales Personal', 'business/informationSocialNetwork/admin', 311, 312, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (313, 'Update registro Formulario Redes Sociales Personal', 'business/informationSocialNetwork/save', 311, 313,
        NULL, 1, 'business/informationSocialNetwork/save', 1),
       (314, 'Creacion registro Formulario Redes Sociales Personal', 'business/informationSocialNetwork/save', 311, 314,
        NULL, 1, 'business/informationSocialNetwork/save', 1),
       (315, 'Obtencion datos Tipos de Redes Sociales Formulario Personal', 'informationSocialNetworkType/listSelect2',
        311, 315, NULL, 1, 'informationSocialNetworkType/listSelect2', 1),
       (316, 'Button Manager- Usuario Personal', 'business/informationSocialNetwork/admin', 285, 316, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (317, 'ADMIN GRID - Usuario Personal', 'business/informationSocialNetwork/admin', 316, 317, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (318, 'Update registro Formulario Usuario Personal', 'business/businessByEmployeeProfile/save', 316, 318, NULL,
        1, 'business/businessByEmployeeProfile/save', 1),
       (319, 'Creacion registro Formulario Usuario Personal', 'business/businessByEmployeeProfile/save', 316, 319, NULL,
        1, 'business/businessByEmployeeProfile/save', 1),
       (320, 'Obtencion datos Tipos de Roles Usuario Formulario Personal', 'business/roles/listAll', 316, 320, NULL, 1,
        'business/roles/listAll', 1),
       (321, 'Validacion user Usuario Formulario Personal', 'user/unique/username', 316, 321, NULL, 1,
        'user/unique/username', 1),
       (322, 'Validacion emailUsuario Formulario Personal', 'user/unique/email', 316, 322, NULL, 1, 'user/unique/email',
        1),
       (323, 'Validacion passwor change Usuario Formulario Personal', 'user/unique/email', 316, 323, NULL, 1,
        'user/unique/email', 1),
       (324, 'MARKETING', '#', NULL, 324, 'fa fa-sitemap', 1, '#', 1),
       (325, 'Plantillas', 'mailingTemplate/admin', 324, 325, NULL, 1, 'mailingTemplate/admin', 1),
       (326, 'ADMIN GRID - Plantillas', 'mailingTemplate/admin', 325, 326, NULL, 1, 'mailingTemplate/admin', 1),
       (327, 'Update registro Formulario Plantillas', 'mailingTemplate/save', 325, 327, NULL, 1, 'mailingTemplate/save',
        1),
       (328, 'Creacion registro Formulario Plantillas', 'mailingTemplate/save', 325, 328, NULL, 1,
        'mailingTemplate/save', 1),
       (329, 'CRM', '#', NULL, 329, 'fas fa-users', 1, '#', 1),
       (330, 'Clientes', 'business/customer/admin', 329, 330, NULL, 1, 'business/customer/admin', 1),
       (331, 'ADMIN GRID - Clientes', 'business/customer/admin', 330, 331, NULL, 1, 'business/customer/admin', 1),
       (332, 'Update registro Formulario Clientes', 'business/customer/save', 330, 332, NULL, 1,
        'business/customer/save', 1),
       (333, 'Creacion registro Formulario Clientes', 'business/customer/save', 330, 333, NULL, 1,
        'business/customer/save', 1),
       (334, 'Button Manager- Direcciones Clientes', 'business/informationAddress/admin', 330, 334, NULL, 1,
        'business/informationAddress/admin', 1),
       (335, 'ADMIN GRID - Direcciones Clientes', 'business/informationAddress/admin', 334, 335, NULL, 1,
        'business/informationAddress/admin', 1),
       (336, 'Update registro Formulario Direcciones Clientes', 'business/informationAddress/save', 334, 336, NULL, 1,
        'business/informationAddress/save', 1),
       (337, 'Creacion registro Formulario Direcciones Clientes', 'business/informationAddress/save', 334, 337, NULL, 1,
        'business/informationAddress/save', 1),
       (338, 'Obtencion datos Tipos de Direccion Formulario Direcciones Clientes', 'business/informationAddress/save',
        334, 338, NULL, 1, 'business/informationAddress/save', 1),
       (339, 'Button Manager- Telefonos Clientes', 'business/informationAddress/admin', 330, 339, NULL, 1,
        'business/informationAddress/admin', 1),
       (340, 'ADMIN GRID - Telefonos Clientes', 'business/informationAddress/admin', 339, 340, NULL, 1,
        'business/informationAddress/admin', 1),
       (341, 'Update registro Formulario Telefonos Clientes', 'business/informationAddress/save', 339, 341, NULL, 1,
        'business/informationAddress/save', 1),
       (342, 'Creacion registro Formulario Telefonos Clientes', 'business/informationAddress/save', 339, 342, NULL, 1,
        'business/informationAddress/save', 1),
       (343, 'Obtencion datos Tipos de Telefonos Formulario Direcciones Clientes', 'informationPhoneType/listSelect2',
        339, 343, NULL, 1, 'informationPhoneType/listSelect2', 1),
       (344, 'Obtencion datos Tipos de Operadoras Formulario Direcciones Clientes',
        'informationPhoneOperator/listSelect2', 339, 344, NULL, 1, 'informationPhoneOperator/listSelect2', 1),
       (345, 'Button Manager- Emails Clientes', 'business/informationMail/admin', 330, 345, NULL, 1,
        'business/informationMail/admin', 1),
       (346, 'ADMIN GRID - Emails Clientes', 'business/informationMail/admin', 345, 346, NULL, 1,
        'business/informationMail/admin', 1),
       (347, 'Update registro Formulario Emails Clientes', 'business/informationMail/save', 345, 347, NULL, 1,
        'business/informationMail/save', 1),
       (348, 'Creacion registro Formulario Emails Clientes', 'business/informationMail/save', 345, 348, NULL, 1,
        'business/informationMail/save', 1),
       (349, 'Obtencion datos Tipos de Emails Formulario Clientes', 'informationMailType/listSelect2', 345, 349, NULL,
        1, 'informationMailType/listSelect2', 1),
       (350, 'Button Manager- Emails Clientes', 'business/informationMail/admin', 330, 350, NULL, 1,
        'business/informationMail/admin', 1),
       (351, 'ADMIN GRID - Emails Clientes', 'business/informationMail/admin', 350, 351, NULL, 1,
        'business/informationMail/admin', 1),
       (352, 'Update registro Formulario Emails Clientes', 'business/informationMail/save', 350, 352, NULL, 1,
        'business/informationMail/save', 1),
       (353, 'Creacion registro Formulario Emails Clientes', 'business/informationMail/save', 350, 353, NULL, 1,
        'business/informationMail/save', 1),
       (354, 'Obtencion datos Tipos de Emails Formulario Clientes', 'informationMailType/listSelect2', 350, 354, NULL,
        1, 'informationMailType/listSelect2', 1),
       (355, 'Button Manager- Redes Sociales Clientes', 'business/informationSocialNetwork/admin', 330, 355, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (356, 'ADMIN GRID - Redes Sociales Clientes', 'business/informationSocialNetwork/admin', 355, 356, NULL, 1,
        'business/informationSocialNetwork/admin', 1),
       (357, 'Update registro Formulario Redes Sociales Clientes', 'business/informationSocialNetwork/save', 355, 357,
        NULL, 1, 'business/informationSocialNetwork/save', 1),
       (358, 'Creacion registro Formulario Redes Sociales Clientes', 'business/informationSocialNetwork/save', 355, 358,
        NULL, 1, 'business/informationSocialNetwork/save', 1),
       (359, 'Obtencion datos Tipos de Redes Sociales Formulario Clientes', 'informationSocialNetworkType/listSelect2',
        355, 359, NULL, 1, 'informationSocialNetworkType/listSelect2', 1),
       (360, 'Button Manager- Enviar Correos Clientes', 'business/customer/adminEmails', 330, 360, NULL, 1,
        'business/customer/adminEmails', 1),
       (361, 'ADMIN GRID - Emails Clientes', 'business/customer/adminEmails', 360, 361, NULL, 1,
        'business/customer/adminEmails', 1),
       (362, 'Send registro Formulario Email Clientes', 'mailingByDataSend/saveDataSend', 360, 362, NULL, 1,
        'mailingByDataSend/saveDataSend', 1),
       (363, 'Datos Plantillas registro Formulario Clientes', 'mailingTemplate/listSelect2', 360, 363, NULL, 1,
        'mailingTemplate/listSelect2', 1),
       (364, 'Button Manager- Ubicacion Clientes', 'business/customer/listAllInformationAddress', 330, 364, NULL, 1,
        'business/customer/listAllInformationAddress', 1),
       (365, 'Datos Personas Clientes registro Formulario Ubicacion Clientes',
        'business/customer/listS2InformationAddress', 364, 365, NULL, 1, 'business/customer/listS2InformationAddress',
        1),
       (366, 'Rutas-Mapas', '#', NULL, 366, 'fa fa-map-signs', 1, '#', 1),
       (367, 'Chakiñanes', 'business/routes/adminBusiness', 366, 367, NULL, 1, 'business/routes/adminBusiness', 1),
       (368, 'ADMIN GRID - Chakiñanes', 'business/routes/adminBusiness', 367, 368, NULL, 1,
        'business/routes/adminBusiness', 1),
       (369, 'Update registro Formulario Chakiñanes', 'business/routes/saveBusiness', 367, 369, NULL, 1,
        'business/routes/saveBusiness', 1),
       (370, 'Creacion registro Formulario Chakiñanes', 'business/routes/saveBusiness', 367, 370, NULL, 1,
        'business/routes/saveBusiness', 1),
       (371, 'Galeria Markers', 'business/panorama/adminBusiness', 366, 371, NULL, 1, 'business/panorama/adminBusiness',
        1),
       (372, 'ADMIN GRID - Galeria Markers', 'business/panorama/adminBusiness', 371, 372, NULL, 1,
        'business/panorama/adminBusiness', 1),
       (373, 'Update registro Formulario Galeria Markers', 'business/panorama/saveToBusiness', 371, 373, NULL, 1,
        'business/panorama/saveToBusiness', 1),
       (374, 'Creacion registro Formulario Galeria Markers', 'business/panorama/saveToBusiness', 371, 374, NULL, 1,
        'business/panorama/saveToBusiness', 1),
       (375, 'Datos Markers Chakinianes registro Formulario Galeria Markers', 'business/routes/markers/select', 371,
        375, NULL, 1, 'business/routes/markers/select', 1),
       (376, 'Tienda', '#', NULL, 376, 'fas fa-clipboard', 1, '#', 1),
       (377, 'Productos', 'product/admin', 376, 377, NULL, 1, 'product/admin', 1),
       (378, 'ADMIN GRID - Productos', 'product/admin', 377, 378, NULL, 1, 'product/admin', 1),
       (379, 'Update registro Formulario Productos', 'product/save', 377, 379, NULL, 1, 'product/save', 1),
       (380, 'Creacion registro Formulario Productos', 'product/save', 377, 380, NULL, 1, 'product/save', 1),
       (381, 'Datos Marcas registro Formulario Productos', 'productTrademark/listSelect2', 377, 381, NULL, 1,
        'productTrademark/listSelect2', 1),
       (382, 'Datos Categorias registro Formulario Productos', 'productCategory/listSelect2', 377, 382, NULL, 1,
        'productCategory/listSelect2', 1),
       (383, 'Datos Subcategorias registro Formulario Productos', 'productSubcategory/listSelect2', 377, 383, NULL, 1,
        'productSubcategory/listSelect2', 1),
       (384, 'Datos Medida registro Formulario Productos', 'productMeasureType/listSelect2', 377, 384, NULL, 1,
        'productMeasureType/listSelect2', 1),
       (385, 'Datos Tamanio registro Formulario Productos', 'productSizes/listSelect2', 377, 385, NULL, 1,
        'productSizes/listSelect2', 1),
       (386, 'Datos Colores registro Formulario Productos', 'productColor/listSelect2', 377, 386, NULL, 1,
        'productColor/listSelect2', 1),
       (387, 'Button Manager- Inventario Administracion', 'product/saveDataInputOutput', 377, 387, NULL, 1,
        'product/saveDataInputOutput', 1),
       (388, 'Button Manager- Galeria Productos', 'productByMultimedia/admin', 377, 388, NULL, 1,
        'productByMultimedia/admin', 1),
       (389, 'ADMIN GRID - Galeria Productos', 'productByMultimedia/admin', 388, 389, NULL, 1,
        'productByMultimedia/admin', 1),
       (390, 'Update registro Formulario Galeria Productos', 'productByMultimedia/save', 388, 390, NULL, 1,
        'productByMultimedia/save', 1),
       (391, 'Creacion registro Formulario Galeria Productos', 'productByMultimedia/save', 388, 391, NULL, 1,
        'productByMultimedia/save', 1),
       (392, 'Button Manager- Croquis Producto', 'productByRouteMap/getRouteProduct', 377, 392, NULL, 1,
        'productByRouteMap/getRouteProduct', 1),
       (393, 'Update registro Formulario Croquis Producto', 'productByRouteMap/save', 392, 393, NULL, 1,
        'productByRouteMap/save', 1),
       (394, 'Creacion registro Formulario Croquis Producto', 'productByRouteMap/save', 392, 394, NULL, 1,
        'productByRouteMap/save', 1),
       (395, 'Datos CHASQUIS registro Formulario Productos', 'routesMap/listSelect2', 392, 395, NULL, 1,
        'routesMap/listSelect2', 1),
       (396, 'eLIMINAR CHASQUIS registro Formulario Productos', 'productByRouteMap/deleteRouteProduct', 392, 396, NULL,
        1, 'productByRouteMap/deleteRouteProduct', 1),
       (397, 'Button Manager- Traduccion Producto', 'languageProduct/admin', 377, 397, NULL, 1, 'languageProduct/admin',
        1),
       (398, 'Update registro Formulario Traduccion Producto', 'languageProduct/save', 397, 398, NULL, 1,
        'languageProduct/save', 1),
       (399, 'Creacion registro Formulario Traduccion Producto', 'languageProduct/save', 397, 399, NULL, 1,
        'languageProduct/save', 1),
       (400, 'Datos Idiomas registro Formulario Traduccion Producto', 'language/listSelect2', 397, 400, NULL, 1,
        'language/listSelect2', 1),
       (401, 'Eliminar Idiomas registro Formulario Traduccion Producto', 'languageProduct/delete', 377, 401, NULL, 1,
        'languageProduct/delete', 1),
       (402, 'Desc. Productos', 'businessByDiscount/admin', 376, 402, NULL, 1, 'businessByDiscount/admin', 1),
       (403, 'ADMIN GRID - Desc. Productos', 'businessByDiscount/admin', 402, 403, NULL, 1, 'businessByDiscount/admin',
        1),
       (404, 'Update registro Formulario Desc. Productos', 'businessByDiscount/save', 402, 404, NULL, 1,
        'businessByDiscount/save', 1),
       (405, 'Creacion registro Formulario Desc. Productos', 'businessByDiscount/save', 402, 405, NULL, 1,
        'businessByDiscount/save', 1),
       (406, 'Datos Get Data Update registro Formulario Desc. Productos', 'discountByProducts/detailsProducts', 402,
        406, NULL, 1, 'discountByProducts/detailsProducts', 1),
       (407, 'Datos Admin registro Formulario Productos', 'discountByProducts/adminProducts', 402, 407, NULL, 1,
        'discountByProducts/adminProducts', 1),
       (414, 'Servicios', 'productService/admin', 376, 408, NULL, 1, 'productService/admin', 1),
       (415, 'ADMIN GRID - Servicios', 'productService/admin', 414, 409, NULL, 1, 'productService/admin', 1),
       (416, 'Update registro Formulario Servicios', 'productService/save', 414, 410, NULL, 1, 'productService/save',
        1),
       (417, 'Creacion registro Formulario Servicios', 'productService/save', 414, 411, NULL, 1, 'productService/save',
        1),
       (418, 'Datos Marcas registro Formulario Servicios', 'productTrademark/listSelect2', 414, 412, NULL, 1,
        'productTrademark/listSelect2', 1),
       (419, 'Datos Categorias registro Formulario Servicios', 'productCategory/listSelect2', 414, 413, NULL, 1,
        'productCategory/listSelect2', 1),
       (420, 'Datos Subcategorias registro Formulario Servicios', 'productSubcategory/listSelect2', 414, 414, NULL, 1,
        'productSubcategory/listSelect2', 1),
       (421, 'Datos Medida registro Formulario Servicios', 'productMeasureType/listSelect2', 414, 415, NULL, 1,
        'productMeasureType/listSelect2', 1),
       (422, 'Eccomerce', 'orderPaymentsManager/admin', 376, 416, NULL, 1, 'orderPaymentsManager/admin', 1),
       (423, 'ADMIN GRID - Eccomerce', 'productService/admin', 422, 417, NULL, 1, 'productService/admin', 1),
       (424, 'Buttons Manager- Configuracion de Tienda Diseño y Estructura', 'businessByInventoryManagement/admin', 422,
        418, NULL, 1, 'businessByInventoryManagement/admin', 1),
       (425, 'Update registro Formulario Configuracion de Tienda Diseño y Estructura',
        'businessByInventoryManagement/saveData', 424, 419, NULL, 1, 'businessByInventoryManagement/saveData', 1);
INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`)
VALUES (426, 'Creacion registro Formulario Configuracion de Tienda Diseño y Estructura',
        'businessByInventoryManagement/saveData', 424, 420, NULL, 1, 'businessByInventoryManagement/saveData', 1),
       (427, 'Buttons Manager- Configuracion Subcategorias Publicidad',
        'businessByInventoryManagementSubcategory/getAdmin', 422, 421, NULL, 1,
        'businessByInventoryManagementSubcategory/getAdmin', 1),
       (428, 'ADMIN GRID - Configuracion Subcategorias Publicidad', 'businessByInventoryManagementSubcategory/getAdmin',
        427, 422, NULL, 1, 'businessByInventoryManagementSubcategory/getAdmin', 1),
       (429, 'Update registro Formulario Configuracion Subcategorias Publicidad',
        'businessByInventoryManagementSubcategory/saveData', 427, 423, NULL, 1,
        'businessByInventoryManagementSubcategory/saveData', 1),
       (430, 'Creacion registro Formulario Configuracion Subcategorias Publicidad',
        'businessByInventoryManagementSubcategory/saveData', 427, 424, NULL, 1,
        'businessByInventoryManagementSubcategory/saveData', 1),
       (431, 'Datos Subcategorias Productos registro Formulario Configuracion Subcategorias Publicidad',
        'productSubcategory/listSelect2Config', 427, 425, NULL, 1, 'productSubcategory/listSelect2Config', 1),
       (432, 'Buttons Manager Grid- Ver Pedido', 'businessByInventoryManagementSubcategory/getAdmin', 427, 426, NULL, 1,
        'businessByInventoryManagementSubcategory/getAdmin', 1),
       (433, 'Buttons Manager Grid- Manager Pedido', 'orderPaymentsManager/changeStateBankOrder', 422, 427, NULL, 1,
        'orderPaymentsManager/changeStateBankOrder', 1),
       (434, 'REalizar Entrega registro Formulario Manager Pedido', 'orderPaymentsManager/deliverOrder', 433, 428, NULL,
        1, 'orderPaymentsManager/deliverOrder', 1),
       (435, 'Creacion De verificacion de deposito registro Formulario Manager Pedido',
        'orderPaymentsManager/changeStateBankOrder', 433, 429, NULL, 1, 'orderPaymentsManager/changeStateBankOrder', 1),
       (436, 'Gamificacion', '#', NULL, 430, 'fas fa-gamepad', 1, '#', 1),
       (437, 'Tipos de Actividad', 'gamificationTypeActivity/admin', 436, 431, NULL, 1,
        'gamificationTypeActivity/admin', 1),
       (438, 'ADMIN GRID - Tipos de Actividad', 'gamificationTypeActivity/admin', 437, 432, NULL, 1,
        'gamificationTypeActivity/admin', 1),
       (439, 'Update registro Formulario Tipos de Actividad', 'gamificationTypeActivity/save', 437, 433, NULL, 1,
        'gamificationTypeActivity/save', 1),
       (440, 'Creacion registro Formulario Tipos de Actividad', 'gamificationTypeActivity/save', 437, 434, NULL, 1,
        'gamificationTypeActivity/save', 1),
       (441, 'Administracion', 'businessByGamification/admin', 436, 435, NULL, 1, 'businessByGamification/admin', 1),
       (442, 'ADMIN GRID - Administracion', 'businessByGamification/admin', 441, 436, NULL, 1,
        'businessByGamification/admin', 1),
       (443, 'Update registro Formulario Administracion', 'businessByGamification/save', 441, 437, NULL, 1,
        'businessByGamification/save', 1),
       (444, 'Creacion registro Formulario Administracion', 'businessByGamification/save', 441, 438, NULL, 1,
        'businessByGamification/save', 1),
       (445, 'Buttons Manager- Administracion Puntos', 'gamificationByProcess/admin', 441, 439, NULL, 1,
        'gamificationByProcess/admin', 1),
       (446, 'ADMIN GRID - Administracion Puntos', 'gamificationByProcess/admin', 445, 440, NULL, 1,
        'gamificationByProcess/admin', 1),
       (447, 'Update registro Formulario Administracion Puntos', 'gamificationByProcess/save', 445, 441, NULL, 1,
        'gamificationByProcess/save', 1),
       (448, 'Creacion registro Formulario Administracion Puntos', 'gamificationByProcess/save', 445, 442, NULL, 1,
        'gamificationByProcess/save', 1),
       (449, 'Datos tIPOS DE actividad registro Formulario Administracion Puntos',
        'gamificationTypeActivity/listSelect2', 445, 443, NULL, 1, 'gamificationTypeActivity/listSelect2', 1),
       (450, 'Buttons Manager- Administracion Premios', 'gamificationByRewards/admin', 441, 444, NULL, 1,
        'gamificationByRewards/admin', 1),
       (451, 'ADMIN GRID - Administracion Premios', 'gamificationByRewards/admin', 450, 445, NULL, 1,
        'gamificationByRewards/admin', 1),
       (452, 'Update registro Formulario Administracion Premios', 'gamificationByRewards/save', 450, 446, NULL, 1,
        'gamificationByRewards/save', 1),
       (453, 'Creacion registro Formulario Administracion Premios', 'gamificationByRewards/save', 450, 447, NULL, 1,
        'gamificationByRewards/save', 1),
       (454, 'Datos Productos registro Formulario Administracion Premios', 'business/products/listSelect2', 450, 448,
        NULL, 1, 'business/products/listSelect2', 1),
       (455, 'Datos Servicios registro Formulario Administracion Premios', 'business/products/listSelect2', NULL, 449,
        NULL, 1, 'business/products/listSelect2', 1),
       (456, 'Pagina Web', 'templateInformation/admin', NULL, 450, 'fab fa-html5', 1, 'templateInformation/admin', 0),
       (457, 'ADMIN GRID - Pagina Web', 'templateInformation/admin', 456, 451, NULL, 1, 'templateInformation/admin', 1),
       (458, 'Update registro Formulario Pagina Web', 'templateInformation/save', 456, 452, NULL, 1,
        'templateInformation/save', 1),
       (459, 'Creacion registro Formulario Pagina Web', 'templateInformation/save', 456, 453, NULL, 1,
        'templateInformation/save', 1),
       (460, 'Buttons Manager- Administracion Web', 'frontend/manager', 456, 454, NULL, 1, 'frontend/manager', 1),
       (461, 'Gestion de Reparacion', '#', NULL, 455, 'fas fa-toolbox', 1, '#', 1),
       (462, 'Partes/Otros', 'repairProductByBusiness/admin', 461, 456, NULL, 1, 'repairProductByBusiness/admin', 1),
       (463, 'ADMIN GRID - Partes/Otros', 'product/admin', 462, 457, NULL, 1, 'product/admin', 1),
       (464, 'Update registro Formulario Partes/Otros', 'repairProductByBusiness/save', 462, 458, NULL, 1,
        'repairProductByBusiness/save', 1),
       (465, 'Creacion registro Formulario Partes/Otros', 'repairProductByBusiness/save', 462, 459, NULL, 1,
        'repairProductByBusiness/save', 1),
       (466, 'Reparaciones', 'repairProductByBusiness/admin', 461, 460, NULL, 1, 'repairProductByBusiness/admin', 1),
       (467, 'ADMIN GRID - Reparaciones', 'product/admin', 466, 461, NULL, 1, 'product/admin', 1),
       (468, 'Update registro Formulario Reparaciones', 'repairProductByBusiness/save', 466, 462, NULL, 1,
        'repairProductByBusiness/save', 1),
       (469, 'Creacion registro Formulario Reparaciones', 'repairProductByBusiness/save', 466, 463, NULL, 1,
        'repairProductByBusiness/save', 1),
       (470, 'Datos Clientes registro Formulario Reparaciones', 'business/customer/listRepair', 466, 464, NULL, 1,
        'business/customer/listRepair', 1),
       (471, 'Datos Partes registro Formulario Reparaciones', 'repairProductByBusiness/listSelect2', 466, 465, NULL, 1,
        'repairProductByBusiness/listSelect2', 1),
       (472, 'Datos Marcas registro Formulario Reparaciones', 'productTrademark/listSelect2', 466, 466, NULL, 1,
        'productTrademark/listSelect2', 1),
       (473, 'Datos Colores registro Formulario Reparaciones', 'productColor/listSelect2', 466, 467, NULL, 1,
        'productColor/listSelect2', 1),
       (474, 'Datos Log Formulario Reparaciones', 'repair/getResults', 466, 468, NULL, 1, 'repair/getResults', 1),
       (475, 'Clinica', '#', NULL, 469, 'far fa-hospital', 1, '#', 1),
       (476, 'Alergias', 'allergies/admin', 475, 470, NULL, 1, 'allergies/admin', 1),
       (477, 'ADMIN GRID - Alergias', 'allergies/admin', 476, 471, NULL, 1, 'allergies/admin', 1),
       (478, 'Update registro Formulario Alergias', 'allergies/save', 476, 472, NULL, 1, 'allergies/save', 1),
       (479, 'Creacion registro Formulario Alergias', 'allergies/save', 476, 473, NULL, 1, 'allergies/save', 1),
       (480, 'Habitos', 'habits/admin', 475, 474, NULL, 1, 'habits/admin', 1),
       (481, 'ADMIN GRID - Habitos', 'habits/admin', 480, 475, NULL, 1, 'habits/admin', 1),
       (482, 'Update registro Formulario Habitos', 'habits/save', 480, 476, NULL, 1, 'habits/save', 1),
       (483, 'Creacion registro Formulario Habitos', 'habits/save', 480, 477, NULL, 1, 'habits/save', 1),
       (484, 'Pacientes', 'patient/admin', 475, 478, NULL, 1, 'patient/admin', 1),
       (485, 'ADMIN GRID - Pacientes', 'patient/admin', 484, 479, NULL, 1, 'patient/admin', 1),
       (486, 'Update registro Formulario Pacientes', 'historyClinic/saveDataProfilePatient', 484, 480, NULL, 1,
        'historyClinic/saveDataProfilePatient', 1),
       (487, 'Creacion registro Formulario Pacientes', 'historyClinic/saveDataProfilePatient', 484, 481, NULL, 1,
        'historyClinic/saveDataProfilePatient', 1),
       (488, 'Buttons Manager- Historial Clinico', 'gamificationByRewards/admin', 484, 482, NULL, 1,
        'gamificationByRewards/admin', 1),
       (489, 'Historia Clinica-Paciente', 'historyClinic/getDataHistoryClinicLog', 484, 483, NULL, 1,
        'historyClinic/getDataHistoryClinicLog', 1),
       (490, 'Historia Clinica-Paciente- Obtencion Datos Historial de Paciente',
        'historyClinic/getDataHistoryClinicLog', 489, 484, NULL, 1, 'historyClinic/getDataHistoryClinicLog', 1),
       (491, 'Historia Clinica-Antecedentes', 'antecedentByHistoryClinic/admin', 484, 485, NULL, 1,
        'antecedentByHistoryClinic/admin', 1),
       (492, 'Historia Clinica-Antecedentes Admin', 'antecedentByHistoryClinic/admin', 491, 486, NULL, 1,
        'antecedentByHistoryClinic/admin', 1),
       (493, 'Historia Clinica-Antecedentes Registrar', 'antecedentByHistoryClinic/save', 491, 487, NULL, 1,
        'antecedentByHistoryClinic/save', 1),
       (494, 'Historia Clinica-Antecedentes Actualizar', 'antecedentByHistoryClinic/save', 491, 488, NULL, 1,
        'antecedentByHistoryClinic/save', 1),
       (495, 'Historia Clinica-Consulta', 'medicalConsultationByPatient/admin', 484, 489, NULL, 1,
        'medicalConsultationByPatient/admin', 1),
       (496, 'Historia Clinica-Consulta Admin', 'medicalConsultationByPatient/admin', 495, 490, NULL, 1,
        'medicalConsultationByPatient/admin', 1),
       (497, 'Historia Clinica-ConsultaRegistrar', 'medicalConsultationByPatient/save', 495, 491, NULL, 1,
        'medicalConsultationByPatient/save', 1),
       (498, 'Historia Clinica-ConsultaActualizar', 'medicalConsultationByPatient/save', 495, 492, NULL, 1,
        'medicalConsultationByPatient/save', 1),
       (499, 'Historia Clinica-Tratamientos', 'treatmentByPatient/admin', 484, 493, NULL, 1, 'treatmentByPatient/admin',
        1),
       (500, 'Historia Clinica - TratamientosAdmin', 'treatmentByPatient/admin', 499, 494, NULL, 1,
        'treatmentByPatient/admin', 1),
       (501, 'Historia Clinica- Tratamientos Registrar', 'treatmentByPatient/save', 499, 495, NULL, 1,
        'treatmentByPatient/save', 1),
       (502, 'Historia Clinica - Tratamientos Actualizar', 'treatmentByPatient/save', 499, 496, NULL, 1,
        'treatmentByPatient/save', 1),
       (503, 'Historia Clinica - Tratamientos Datos Obtencion Servicios', 'product/getProductService', 499, 497, NULL,
        1, 'product/getProductService', 1),
       (504, 'Historia Clinica-Odontograma', 'odontogramByPatient/admin', 484, 498, NULL, 1,
        'odontogramByPatient/admin', 1),
       (505, 'Historia Clinica - Odontograma Admin', 'odontogramByPatient/admin', 504, 499, NULL, 1,
        'odontogramByPatient/admin', 1),
       (506, 'Historia Clinica- OdontogramaRegistrar', 'odontogramByPatient/save', 504, 500, NULL, 1,
        'odontogramByPatient/save', 1),
       (507, 'Historia Clinica - Obtencion Datos Registro', 'dentalPieceByOdontogram/list/byOdontogramodontogramId',
        504, 501, NULL, 1, 'dentalPieceByOdontogram/list/byOdontogramodontogramId', 1),
       (508, 'Historia Clinica - Odontograma Actualizar', 'odontogramByPatient/save', 504, 502, NULL, 1,
        'odontogramByPatient/save', 1),
       (509, 'Historia Clinica - Odontograma Datos Referencia Pieza', 'referencePiece/list/select', 504, 503, NULL, 1,
        'referencePiece/list/select', 1),
       (510, 'Hoteleria', '#', NULL, 504, 'fa fa-building', 1, '#', 1),
       (511, 'Tipos de Habitacion', 'business/lodgingTypeOfRoom/admin', 510, 505, NULL, 1,
        'business/lodgingTypeOfRoom/admin', 1),
       (512, 'ADMIN GRID - Tipos de Habitacion', 'business/lodgingTypeOfRoom/admin', NULL, 506, NULL, 1,
        'business/lodgingTypeOfRoom/admin', 1),
       (513, 'Update registro Formulario Tipos de Habitacion', 'business/lodgingTypeOfRoom/save', NULL, 507, NULL, 1,
        'business/lodgingTypeOfRoom/save', 1),
       (514, 'Creacion registro Formulario Tipos de Habitacion', 'business/lodgingTypeOfRoom/save', NULL, 508, NULL, 1,
        'business/lodgingTypeOfRoom/save', 1),
       (515, 'Nivel de Habitacion', 'business/lodgingRoomLevels/admin', 510, 509, NULL, 1,
        'business/lodgingRoomLevels/admin', 1),
       (516, 'ADMIN GRID - Nivel de Habitacion', 'business/lodgingRoomLevels/admin', NULL, 510, NULL, 1,
        'business/lodgingRoomLevels/admin', 1),
       (517, 'Update registro Formulario Nivel de Habitacion', 'business/lodgingRoomLevels/save', NULL, 511, NULL, 1,
        'business/lodgingRoomLevels/save', 1),
       (518, 'Creacion registro Formulario Nivel de Habitacion', 'business/lodgingRoomLevels/save', NULL, 512, NULL, 1,
        'business/lodgingRoomLevels/save', 1),
       (519, 'Caracteristicas Habitaciones', 'business/lodgingRoomFeatures/admin', 510, 513, NULL, 1,
        'business/lodgingRoomFeatures/admin', 1),
       (520, 'ADMIN GRID - Caracteristicas Habitaciones', 'business/lodgingRoomFeatures/admin', NULL, 514, NULL, 1,
        'business/lodgingRoomFeatures/admin', 1),
       (521, 'Update registro Formulario Caracteristicas Habitaciones', 'business/lodgingRoomFeatures/save', NULL, 515,
        NULL, 1, 'business/lodgingRoomFeatures/save', 1),
       (522, 'Creacion registro Formulario Caracteristicas Habitaciones', 'business/lodgingRoomFeatures/save', NULL,
        516, NULL, 1, 'business/lodgingRoomFeatures/save', 1),
       (523, 'Habitaciones', 'business/lodgingTypeOfRoomByPrice/admin', 510, 517, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/admin', 1),
       (524, 'ADMIN GRID - Habitaciones', 'business/lodgingTypeOfRoomByPrice/admin', 523, 518, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/admin', 1),
       (525, 'Update registro Formulario Habitaciones', 'business/lodgingTypeOfRoomByPrice/save', 523, 519, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/save', 1),
       (526, 'Creacion registro Formulario Habitaciones', 'business/lodgingTypeOfRoomByPrice/save', 523, 520, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/save', 1),
       (527, 'Habitaciones Datos Obtencion de Tipos de Habitacion', 'business/lodgingTypeOfRoom/listSelect2', 523, 521,
        NULL, 1, 'business/lodgingTypeOfRoom/listSelect2', 1),
       (528, 'Habitaciones Datos Obtencion de Niveles de Habitacion', 'business/lodgingRoomLevels/listSelect2', 523,
        522, NULL, 1, 'business/lodgingRoomLevels/listSelect2', 1),
       (529, 'Habitaciones Datos Obtencion de Caracteristicas de Habitacion',
        'business/lodgingRoomFeatures/listSelect2', 523, 523, NULL, 1, 'business/lodgingRoomFeatures/listSelect2', 1),
       (530, 'Recepcion', 'business/lodging/adminBusiness', 523, 524, NULL, 1, 'business/lodging/adminBusiness', 1),
       (531, 'ADMIN GRID - Recepcion', 'business/lodging/adminBusiness', 523, 525, NULL, 1,
        'business/lodging/adminBusiness', 1),
       (532, 'Update registro Formulario Recepcion', 'business/lodging/saveBusiness', 523, 526, NULL, 1,
        'business/lodging/saveBusiness', 1),
       (533, 'Creacion registro Formulario Recepcion', 'business/lodging/saveBusiness', 523, 527, NULL, 1,
        'business/lodging/saveBusiness', 1),
       (534, 'Recepcion Datos Obtencion de Clientes Registrados', 'business/customer/listSelect2NotLodging', 523, 528,
        NULL, 1, 'business/customer/listSelect2NotLodging', 1),
       (535, 'Buttons Manager- Gestion de Pagos', 'business/lodgingByPayment/savePayment', 530, 529, NULL, 1,
        'business/lodgingByPayment/savePayment', 1),
       (536, 'Creacion registro Formulario Gestion de Pagos', 'business/lodgingByPayment/savePayment', 535, 530, NULL,
        1, 'business/lodgingByPayment/savePayment', 1),
       (537, 'Buttons Manager- Recopilacion Informativa', 'business/lodgingByArrived/saveArrived', 530, 531, NULL, 1,
        'business/lodgingByArrived/saveArrived', 1),
       (538, 'Creacion registro Formulario Recopilacion Informativa', 'business/lodgingByArrived/saveArrived', 537, 532,
        NULL, 1, 'business/lodgingByArrived/saveArrived', 1),
       (539, 'Buttons Manager- Asignacion de Habitaciones', 'business/lodgingByTypeOfRoom/saveBusiness', 530, 533, NULL,
        1, 'business/lodgingByTypeOfRoom/saveBusiness', 1),
       (540, 'Creacion registro Formulario Asignacion de Habitaciones', 'business/lodgingByTypeOfRoom/saveBusiness',
        539, 534, NULL, 1, 'business/lodgingByTypeOfRoom/saveBusiness', 1),
       (541, 'Buttons Manager- Entrega de Habitaciones', 'business/lodging/delivery', 530, 535, NULL, 1,
        'business/lodging/delivery', 1),
       (542, 'Creacion registro Formulario Entrega de Habitaciones', 'business/lodging/delivery', 541, 536, NULL, 1,
        'business/lodging/delivery', 1),
       (543, 'Manager- Habitaciones Recepcion', 'business/lodgingTypeOfRoomByPrice/adminReception', 530, 537, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/adminReception', 1),
       (544, 'ADMIN Habitaciones Recepcion', 'business/lodgingTypeOfRoomByPrice/adminReception', 543, 538, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/adminReception', 1),
       (545, 'Creacion registro Formulario Manager- Habitaciones Entrega',
        'business/lodgingTypeOfRoomByPrice/saveReception', 543, 539, NULL, 1,
        'business/lodgingTypeOfRoomByPrice/saveReception', 1),
       (546, 'Reportes Estadisticos', 'business/lodging/results', 510, 540, NULL, 1, 'business/lodging/results', 1),
       (547, 'Obtencion de Datos - Reportes Estadisticos', 'business/lodging/results', 546, 541, NULL, 1,
        'business/lodging/results', 1),
       (548, 'Gestion Formularios\n', '#', NULL, 542, 'fa fa-list', 1, '#', 1),
       (549, 'Tipos', 'business/educationalInstitutionAskwerType/admin', 548, 543, NULL, 1,
        'business/educationalInstitutionAskwerType/admin', 1),
       (550, 'ADMIN GRID - Tipos', 'business/educationalInstitutionAskwerType/admin', 549, 544, NULL, 1,
        'business/educationalInstitutionAskwerType/admin', 1),
       (551, 'Update registro Formulario Tipos', 'business/educationalInstitutionAskwerType/save', 549, 545, NULL, 1,
        'business/educationalInstitutionAskwerType/save', 1),
       (552, 'Creacion registro Formulario Tipos', 'business/educationalInstitutionAskwerType/save', 549, 546, NULL, 1,
        'business/educationalInstitutionAskwerType/save', 1),
       (553, 'Formularios', 'business/educationalInstitutionByBusiness/admin', 548, 547, NULL, 1,
        'business/educationalInstitutionByBusiness/admin', 1),
       (554, 'ADMIN GRID - Formularios', 'business/educationalInstitutionByBusiness/admin', 553, 548, NULL, 1,
        'business/educationalInstitutionByBusiness/admin', 1),
       (555, 'Update registro Formulario Formularios', 'business/educationalInstitutionByBusiness/dataAskwer', 553, 549,
        NULL, 1, 'business/educationalInstitutionByBusiness/dataAskwer', 1),
       (556, 'Creacion registro Formulario Formularios', 'business/educationalInstitutionByBusiness/save', 553, 550,
        NULL, 1, 'business/educationalInstitutionByBusiness/save', 1),
       (557, 'Datos Obtencion de Tipos de Formulario Formularios',
        'business/educationalInstitutionAskwerType/listSelect2', 553, 551, NULL, 1,
        'business/educationalInstitutionAskwerType/listSelect2', 1),
       (558, 'Buttons Manager- Ver Formularios', 'business/educationalInstitutionByBusiness/dataAskwerForm', 553, 552,
        NULL, 1, 'business/educationalInstitutionByBusiness/dataAskwerForm', 1),
       (559, 'Buttons Manager- Guardar Formularios', 'business/askwerForm/saveAskwer', 553, 553, NULL, 1,
        'business/askwerForm/saveAskwer', 1),
       (560, 'Buttons Manager- Resultados Formularios', 'business/askwerForm/getDataSolutionsAskwer', 553, 554, NULL, 1,
        'business/askwerForm/getDataSolutionsAskwer', 1),
       (561, 'Eventos Deportes\n', '#', NULL, 555, 'fa fa-calendar', 1, '#', 1),
       (562, 'Eventos Deportes\n', 'eventsTrailsProject/admin', 561, 556, NULL, 1, 'eventsTrailsProject/admin', 1),
       (563, 'ADMIN GRID - Eventos Deportes', 'eventsTrailsProject/admin', 562, 557, NULL, 1,
        'eventsTrailsProject/admin', 1),
       (564, 'Update registro Formulario Eventos Deportes', 'business/educationalInstitutionByBusiness/dataAskwer', 562,
        558, NULL, 1, 'business/educationalInstitutionByBusiness/dataAskwer', 1),
       (565, 'Creacion registro Formulario Eventos Deportes', 'business/educationalInstitutionByBusiness/save', 562,
        559, NULL, 1, 'business/educationalInstitutionByBusiness/save', 1),
       (566, 'Datos Obtencion de Tipos de Formulario Formularios',
        'business/educationalInstitutionAskwerType/listSelect2', 562, 560, NULL, 1,
        'business/educationalInstitutionAskwerType/listSelect2', 1),
       (567, 'Buttons Manager- Administracion Eventos', 'eventsTrailsProject/manager', 561, 561, NULL, 1,
        'eventsTrailsProject/manager', 1),
       (568, 'Dashboard', 'frontend/manager', NULL, 562, 'remixicon-dashboard-line', 1, 'frontend/manager', 0),
       (569, 'Sliders', '#', NULL, 563, 'fas fa-business-time', 1, '#', 1),
       (570, 'Principal', 'templateSlider/admin', 569, 564, NULL, 1, 'templateSlider/admin', 1),
       (571, 'ADMIN GRID-Principal', 'templateSlider/admin', 570, 565, NULL, 1, 'templateSlider/admin', 1),
       (572, 'Update registro Formulario Principal', 'templateSlider/save', 570, 566, NULL, 1, 'templateSlider/save',
        1),
       (573, 'Creacion registro Formulario Principal', 'templateSlider/save', 570, 567, NULL, 1, 'templateSlider/save',
        1),
       (574, 'Button Manager- Agregar Fotografias Principal', 'templateSliderByImages/admin', 570, 568, NULL, 1,
        'templateSliderByImages/admin', 1),
       (575, 'ADMIN GRID-Agregar Fotografias Principal', 'templateSliderByImages/admin', 574, 569, NULL, 1,
        'templateSliderByImages/admin', 1),
       (576, 'Update registro Formulario Agregar Fotografias Principal', 'templateSliderByImages/save', 574, 570, NULL,
        1, 'templateSliderByImages/save', 1),
       (577, 'Creacion registro Formulario Agregar Fotografias Principal', 'templateSliderByImages/save', 574, 571,
        NULL, 1, 'templateSliderByImages/save', 1),
       (578, 'Button Manager- Traduccion Administracion Fotografias Principal', 'languageTemplateSliderByImages/admin',
        570, 572, NULL, 1, 'languageTemplateSliderByImages/admin', 1),
       (579, 'ADMIN GRID- Traduccion Administracion Fotografias Principal', 'languageTemplateSliderByImages/admin', 578,
        573, NULL, 1, 'languageTemplateSliderByImages/admin', 1),
       (580, 'Update registro Formulario Traduccion Administracion Fotografias Principal',
        'languageTemplateSliderByImages/save', 578, 574, NULL, 1, 'languageTemplateSliderByImages/save', 1),
       (581, 'Creacion registro Formulario Traduccion Administracion Fotografias Principal',
        'languageTemplateSliderByImages/save', 578, 575, NULL, 1, 'languageTemplateSliderByImages/save', 1),
       (582, 'Obtencion de datos o Formulario Traduccion Administracion Fotografias Principal', 'language/listSelect2',
        578, 576, NULL, 1, 'language/listSelect2', 1),
       (583, 'Delete registro Formulario Traduccion Administracion Fotografias Principal',
        'languageTemplateSliderByImages/delete', 578, 577, NULL, 1, 'languageTemplateSliderByImages/delete', 1),
       (584, 'Actividades Gamificacion', 'templateSlider/adminActivitiesGamification', 569, 578, NULL, 1,
        'templateSlider/adminActivitiesGamification', 1),
       (585, 'ADMIN GRID-Actividades Gamificacion', 'templateSlider/adminActivitiesGamification', 584, 579, NULL, 1,
        'templateSlider/adminActivitiesGamification', 1),
       (586, 'Update registro Formulario Actividades Gamificacion', 'templateSlider/saveActivitiesGamification', 584,
        580, NULL, 1, 'templateSlider/saveActivitiesGamification', 1),
       (587, 'Creacion registro Formulario Actividades Gamificacion', 'templateSlider/saveActivitiesGamification', 584,
        581, NULL, 1, 'templateSlider/saveActivitiesGamification', 1),
       (588, 'Button Manager- Agregar Fotografias Actividades Gamificacion',
        'templateSliderByImages/adminActivitiesGamification', 584, 582, NULL, 1,
        'templateSliderByImages/adminActivitiesGamification', 1),
       (589, 'ADMIN GRID- Agregar Fotografias Actividades Gamificacion',
        'templateSliderByImages/adminActivitiesGamification', 588, 583, NULL, 1,
        'templateSliderByImages/adminActivitiesGamification', 1),
       (590, 'Update registro Formulario Agregar Fotografias Actividades Gamificacion',
        'templateSliderByImages/saveActivitiesGamification', 588, 584, NULL, 1,
        'templateSliderByImages/saveActivitiesGamification', 1),
       (591, 'Creacion registro Formulario Agregar Fotografias Actividades Gamificacion',
        'templateSliderByImages/saveActivitiesGamification', 588, 585, NULL, 1,
        'templateSliderByImages/saveActivitiesGamification', 1),
       (592, 'Button Manager- Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/adminActivitiesGamification', 588, 586, NULL, 1,
        'languageTemplateSliderByImages/adminActivitiesGamification', 1),
       (593, 'ADMIN GRID- Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/adminActivitiesGamification', 592, 587, NULL, 1,
        'languageTemplateSliderByImages/adminActivitiesGamification', 1),
       (594, 'Update registro Formulario Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/saveActivitiesGamification', 592, 588, NULL, 1,
        'languageTemplateSliderByImages/saveActivitiesGamification', 1),
       (595, 'Creacion registro Formulario Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/saveActivitiesGamification', 592, 589, NULL, 1,
        'languageTemplateSliderByImages/saveActivitiesGamification', 1),
       (596, 'Obtencion de datos o Formulario Traduccion Administracion Fotografias Actividades Gamificacion',
        'language/listSelect2', 592, 590, NULL, 1, 'language/listSelect2', 1),
       (597, 'Delete registro Formulario Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/delete', 592, 591, NULL, 1, 'languageTemplateSliderByImages/delete', 1),
       (598, 'Premios Gamificacion', 'templateSlider/adminRewardsGamification', 569, 592, NULL, 1,
        'templateSlider/adminRewardsGamification', 1),
       (599, 'ADMIN GRID-Premios Gamificacion', 'templateSlider/adminRewardsGamification', 598, 593, NULL, 1,
        'templateSlider/adminRewardsGamification', 1),
       (600, 'Update registro Formulario Premios Gamificacion', 'templateSlider/saveRewardsGamification', 598, 594,
        NULL, 1, 'templateSlider/saveRewardsGamification', 1),
       (601, 'Creacion registro Formulario Premios Gamificacion', 'templateSlider/saveRewardsGamification', 598, 595,
        NULL, 1, 'templateSlider/saveRewardsGamification', 1),
       (602, 'Button Manager- Agregar Fotografias Premios Gamificacion',
        'templateSliderByImages/adminActivitiesGamification', 598, 596, NULL, 1,
        'templateSliderByImages/adminActivitiesGamification', 1),
       (603, 'ADMIN GRID- Agregar Fotografias Premios Gamificacion', 'templateSliderByImages/adminRewardsGamification',
        602, 597, NULL, 1, 'templateSliderByImages/adminRewardsGamification', 1),
       (604, 'Update registro Formulario Agregar Fotografias Premios Gamificacion',
        'templateSliderByImages/saveRewardsGamification', 602, 598, NULL, 1,
        'templateSliderByImages/saveRewardsGamification', 1),
       (605, 'Creacion registro Formulario Agregar Fotografias Premios Gamificacion',
        'templateSliderByImages/saveRewardsGamification', 602, 599, NULL, 1,
        'templateSliderByImages/saveRewardsGamification', 1),
       (606, 'Button Manager- Traduccion Administracion Fotografias Premios Gamificacion',
        'languageTemplateSliderByImages/adminRewardsGamification', 602, 600, NULL, 1,
        'languageTemplateSliderByImages/adminRewardsGamification', 1),
       (607, 'ADMIN GRID- Traduccion Administracion Fotografias Actividades Gamificacion',
        'languageTemplateSliderByImages/adminRewardsGamification', 606, 601, NULL, 1,
        'languageTemplateSliderByImages/adminRewardsGamification', 1),
       (608, 'Update registro Formulario Traduccion Administracion Fotografias Premios Gamificacion',
        'languageTemplateSliderByImages/saveRewardsGamification', 606, 602, NULL, 1,
        'languageTemplateSliderByImages/saveRewardsGamification', 1),
       (609, 'Creacion registro Formulario Traduccion Administracion Fotografias Premios Gamificacion',
        'languageTemplateSliderByImages/saveRewardsGamification', 606, 603, NULL, 1,
        'languageTemplateSliderByImages/saveRewardsGamification', 1),
       (610, 'Obtencion de datos o Formulario Traduccion Administracion Fotografias Premios Gamificacion',
        'language/listSelect2', 606, 604, NULL, 1, 'language/listSelect2', 1),
       (611, 'Delete registro Formulario Traduccion Administracion Fotografias Premios Gamificacion',
        'languageTemplateSliderByImages/delete', 606, 605, NULL, 1, 'languageTemplateSliderByImages/delete', 1),
       (612, 'Secciones Pagina', '#', NULL, 606, 'fas fa-sitemap', 1, '#', 1),
       (613, 'Quienes Somos', 'templateAboutUs/admin', 612, 607, NULL, 1, 'templateAboutUs/admin', 1),
       (614, 'ADMIN GRID-Quienes Somos', 'templateAboutUs/admin', 613, 608, NULL, 1, 'templateAboutUs/admin', 1),
       (615, 'Update registro Formulario Quienes Somos', 'templateAboutUs/save', 613, 609, NULL, 1,
        'templateAboutUs/save', 1),
       (616, 'Creacion registro Formulario Quienes Somos', 'templateAboutUs/save', 613, 610, NULL, 1,
        'templateAboutUs/save', 1),
       (617, 'Button Manager- Agregar Fotografias Quienes Somos', 'templateAboutUsByData/admin', 613, 611, NULL, 1,
        'templateAboutUsByData/admin', 1),
       (618, 'ADMIN GRID-Agregar Fotografias Quienes Somos', 'templateAboutUsByData/admin', 617, 612, NULL, 1,
        'templateAboutUsByData/admin', 1),
       (619, 'Update registro Formulario Agregar Fotografias Quienes Somos', 'templateAboutUsByData/save', 617, 613,
        NULL, 1, 'templateAboutUsByData/save', 1),
       (620, 'Creacion registro Formulario Agregar Fotografias Quienes Somos', 'templateAboutUsByData/save', 617, 614,
        NULL, 1, 'templateAboutUsByData/save', 1),
       (621, 'Button Manager- Traduccion Administracion Fotografias Quienes Somos',
        'languageTemplateAboutUsByData/admin', 617, 615, NULL, 1, 'languageTemplateAboutUsByData/admin', 1),
       (622, 'ADMIN GRID- Traduccion Administracion Fotografias Quienes Somos', 'languageTemplateAboutUsByData/admin',
        621, 616, NULL, 1, 'languageTemplateAboutUsByData/admin', 1),
       (623, 'Update registro Formulario Traduccion Administracion Fotografias Quienes Somos',
        'languageTemplateAboutUsByData/save', 621, 617, NULL, 1, 'languageTemplateAboutUsByData/save', 1),
       (624, 'Creacion registro Formulario Traduccion Administracion Fotografias Quienes Somos',
        'languageTemplateAboutUsByData/save', 621, 618, NULL, 1, 'languageTemplateAboutUsByData/save', 1),
       (625, 'Obtencion de datos o Formulario Traduccion Administracion Fotografias Quienes Somos',
        'language/listSelect2', 621, 619, NULL, 1, 'language/listSelect2', 1),
       (626, 'Delete registro Formulario Traduccion Administracion Fotografias Quienes Somos',
        'languageTemplateAboutUsByData/delete', 621, 620, NULL, 1, 'languageTemplateAboutUsByData/delete', 1),
       (627, 'Button Manager- Traduccion Quienes Somos', 'languageTemplateAboutUs/admin', 617, 621, NULL, 1,
        'languageTemplateAboutUs/admin', 1),
       (628, 'ADMIN GRID- Traduccion Administracion Quienes Somos', 'languageTemplateAboutUs/admin', 627, 622, NULL, 1,
        'languageTemplateAboutUs/admin', 1),
       (629, 'Update registro Formulario Traduccion Administracion Quienes Somos', 'languageTemplateAboutUs/save', 627,
        623, NULL, 1, 'languageTemplateAboutUs/save', 1),
       (630, 'Creacion registro Formulario Traduccion Administracion Quienes Somos', 'languageTemplateAboutUs/save',
        627, 624, NULL, 1, 'languageTemplateAboutUs/save', 1),
       (631, 'Obtencion de datos o Formulario Traduccion Administracion Quienes Somos', 'language/listSelect2', 627,
        625, NULL, 1, 'language/listSelect2', 1),
       (632, 'Delete registro Formulario Traduccion Administracion Quienes Somos', 'languageTemplateAboutUs/delete',
        627, 626, NULL, 1, 'languageTemplateAboutUs/delete', 1),
       (633, 'Politicas/Terminos', 'templatePolicies/admin', 612, 627, NULL, 1, 'templatePolicies/admin', 1),
       (634, 'ADMIN GRID-Politicas/Terminos', 'templatePolicies/admin', 633, 628, NULL, 1, 'templatePolicies/admin', 1),
       (635, 'Update registro Formulario Politicas/Terminos', 'templatePolicies/save', 633, 629, NULL, 1,
        'templatePolicies/save', 1),
       (636, 'Creacion registro Formulario Politicas/Terminos', 'templatePolicies/save', 633, 630, NULL, 1,
        'templatePolicies/save', 1),
       (637, 'Button Manager- Traduccion Politicas/Terminos', 'languageTemplatePolicies/admin', 633, 631, NULL, 1,
        'languageTemplatePolicies/admin', 1),
       (638, 'ADMIN GRID- Traduccion Administracion Politicas/Terminos', 'languageTemplatePolicies/admin', 637, 632,
        NULL, 1, 'languageTemplatePolicies/admin', 1),
       (639, 'Update registro Formulario Traduccion Administracion Politicas/Terminos', 'languageTemplatePolicies/save',
        637, 633, NULL, 1, 'languageTemplatePolicies/save', 1),
       (640, 'Creacion registro Formulario Traduccion Administracion Politicas/Terminos',
        'languageTemplatePolicies/save', 637, 634, NULL, 1, 'languageTemplatePolicies/save', 1),
       (641, 'Obtencion de datos o Formulario Traduccion Administracion Politicas/Terminos', 'language/listSelect2',
        637, 635, NULL, 1, 'language/listSelect2', 1),
       (642, 'Delete registro Formulario Traduccion Administracion Politicas/Terminos',
        'languageTemplatePolicies/delete', 637, 636, NULL, 1, 'languageTemplatePolicies/delete', 1),
       (643, 'Servicios', 'templateServices/admin', 612, 637, NULL, 1, 'templateServices/admin', 1),
       (644, 'ADMIN GRID-Servicios', 'templateServices/admin', 643, 638, NULL, 1, 'templateServices/admin', 1),
       (645, 'Update registro Formulario Servicios', 'templateServices/save\n', 643, 639, NULL, 1,
        'templateServices/save\n', 1),
       (646, 'Creacion registro Formulario Servicios', 'templateServices/save\n', 643, 640, NULL, 1,
        'templateServices/save\n', 1),
       (647, 'Button Manager- Agregar Fotografias Servicios', 'templateServicesByData/admin', 643, 641, NULL, 1,
        'templateServicesByData/admin', 1),
       (648, 'ADMIN GRID-Agregar Fotografias Servicios', 'templateServicesByData/admin', 647, 642, NULL, 1,
        'templateServicesByData/admin', 1),
       (649, 'Update registro Formulario Agregar Fotografias Servicios', 'templateServicesByData/save', 647, 643, NULL,
        1, 'templateServicesByData/save', 1),
       (650, 'Creacion registro Formulario Agregar Fotografias Servicios', 'templateServicesByData/save', 647, 644,
        NULL, 1, 'templateServicesByData/save', 1),
       (651, 'Button Manager- Traduccion Administracion Fotografias Servicios', 'languageTemplateServicesByData/admin',
        647, 645, NULL, 1, 'languageTemplateServicesByData/admin', 1),
       (652, 'ADMIN GRID- Traduccion Administracion Fotografias Servicios', 'languageTemplateServicesByData/admin', 651,
        646, NULL, 1, 'languageTemplateServicesByData/admin', 1),
       (653, 'Update registro Formulario Traduccion Administracion Fotografias Servicios',
        'languageTemplateServicesByData/save', 651, 647, NULL, 1, 'languageTemplateServicesByData/save', 1),
       (654, 'Creacion registro Formulario Traduccion Administracion Fotografias Servicios',
        'languageTemplateServicesByData/save', 651, 648, NULL, 1, 'languageTemplateServicesByData/save', 1),
       (655, 'Obtencion de datos o Formulario Traduccion Administracion Fotografias Servicios', 'language/listSelect2',
        651, 649, NULL, 1, 'language/listSelect2', 1),
       (656, 'Delete registro Formulario Traduccion Administracion Fotografias Servicios',
        'languageTemplateAboutUsByData/delete', 651, 650, NULL, 1, 'languageTemplateAboutUsByData/delete', 1),
       (657, 'Button Manager- Traduccion Servicios', 'languageTemplateServicesByData/admin', 643, 651, NULL, 1,
        'languageTemplateServicesByData/admin', 1),
       (658, 'ADMIN GRID- Traduccion Administracion Servicios', 'languageTemplateServicesByData/admin', 657, 652, NULL,
        1, 'languageTemplateServicesByData/admin', 1),
       (659, 'Update registro Formulario Traduccion Administracion Servicios', 'languageTemplateServicesByData/save',
        657, 653, NULL, 1, 'languageTemplateServicesByData/save', 1),
       (660, 'Creacion registro Formulario Traduccion Administracion Servicios', 'languageTemplateServicesByData/save',
        657, 654, NULL, 1, 'languageTemplateServicesByData/save', 1),
       (661, 'Obtencion de datos o Formulario Traduccion Administracion Servicios', 'language/listSelect2', 657, 655,
        NULL, 1, 'language/listSelect2', 1),
       (662, 'Delete registro Formulario Traduccion Administracion Servicios', 'languageTemplateServicesByData/delete',
        657, 656, NULL, 1, 'languageTemplateServicesByData/delete', 1),
       (663, 'Noticias', 'templateNews/admin', 612, 657, NULL, 1, 'templateNews/admin', 1),
       (664, 'ADMIN GRID-Noticias', 'templateNews/admin', 663, 658, NULL, 1, 'templateNews/admin', 1),
       (665, 'Update registro Formulario Noticias', 'templateNews/save\n', 663, 659, NULL, 1, 'templateNews/save\n', 1),
       (666, 'Creacion registro Formulario Noticias', 'templateNews/save\n', 663, 660, NULL, 1, 'templateNews/save\n',
        1),
       (667, 'Button Manager- Agregar Fotografias Noticias', 'templateNewsByData/admin', 663, 661, NULL, 1,
        'templateNewsByData/admin', 1),
       (668, 'ADMIN GRID-Agregar Fotografias Noticias', 'templateNewsByData/admin', 667, 662, NULL, 1,
        'templateNewsByData/admin', 1),
       (669, 'Update registro Formulario Agregar Fotografias Noticias', 'templateNewsByData/save', 667, 663, NULL, 1,
        'templateNewsByData/save', 1),
       (670, 'Creacion registro Formulario Agregar Fotografias Noticias', 'templateNewsByData/save', 667, 664, NULL, 1,
        'templateNewsByData/save', 1),
       (671, 'Contactanos-Informacion', 'templateContactUs/getContactUsData', 612, 665, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (672, 'ADMIN GRID-Contactanos-Informacion', 'templateContactUs/getContactUsData', 671, 666, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (673, 'Update registro Formulario Contactanos-Informacion', 'templateContactUs/uploadImage\n', 671, 667, NULL, 1,
        'templateContactUs/uploadImage\n', 1),
       (674, 'Creacion registro Formulario Contactanos-Informacion', 'templateContactUs/uploadImage\n', 671, 668, NULL,
        1, 'templateContactUs/uploadImage\n', 1),
       (675, 'Contactanos-Informacion Direccion', 'templateContactUs/getContactUsData', 671, 669, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (676, 'ADMIN GRID- Contactanos-Informacion Direccion', 'templateContactUs/getContactUsData', 675, 670, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (677, 'Update registro Formulario Contactanos-Informacion Direccion', 'business/saveDataFrontend\n', 675, 671,
        NULL, 1, 'business/saveDataFrontend\n', 1),
       (678, 'Creacion registro Formulario Contactanos-Informacion Direccion', 'business/saveDataFrontend\n', 675, 672,
        NULL, 1, 'business/saveDataFrontend\n', 1),
       (679, 'Contactanos-Redes Sociales', 'templateContactUs/getContactUsData', 671, 673, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (680, 'ADMIN GRID- Contactanos- Redes Sociales', 'templateContactUs/getContactUsData', 679, 674, NULL, 1,
        'templateContactUs/getContactUsData', 1),
       (681, 'Update registro Formulario Contactanos - Redes Sociales', 'informationSocialNetwork/saveFrontend\n', 679,
        675, NULL, 1, 'informationSocialNetwork/saveFrontend\n', 1),
       (682, 'Creacion registro Formulario Contactanos - Redes Sociales', 'informationSocialNetwork/saveFrontend\n',
        679, 676, NULL, 1, 'informationSocialNetwork/saveFrontend\n', 1),
       (683, 'Contactanos- Correos Contáctanos', 'templateConfigMailingByEmails/admin', 671, 677, NULL, 1,
        'templateConfigMailingByEmails/admin', 1),
       (684, 'ADMIN GRID- Contactanos- Correos Contáctanos', 'templateConfigMailingByEmails/admin', 683, 678, NULL, 1,
        'templateConfigMailingByEmails/admin', 1),
       (685, 'Update registro Formulario Contactanos - Correos Contáctanos', 'templateConfigMailingByEmails/save\n',
        683, 679, NULL, 1, 'templateConfigMailingByEmails/save\n', 1),
       (686, 'Creacion registro Formulario Contactanos -Correos Contáctanos', 'templateConfigMailingByEmails/save\n',
        683, 680, NULL, 1, 'templateConfigMailingByEmails/save\n', 1),
       (687, 'Delete registro Formulario Contactanos - Correos Contáctanos',
        'templateConfigMailingByEmails/deleteFrontend\n', 683, 681, NULL, 1,
        'templateConfigMailingByEmails/deleteFrontend\n', 1),
       (688, 'Contactanos- Chat Facebook Configuración', 'templateChatApi/save', 671, 682, NULL, 1,
        'templateChatApi/save', 1),
       (689, 'ADMIN GRID- Contactanos- Chat Facebook Configuración', 'templateConfigMailingByEmails/admin', 688, 683,
        NULL, 1, 'templateConfigMailingByEmails/admin', 1),
       (690, 'Update registro Formulario Contactanos - Chat Facebook Configuración', 'templateChatApi/save\n', 688, 684,
        NULL, 1, 'templateChatApi/save\n', 1),
       (691, 'Creacion registro Formulario Contactanos - Chat Facebook Configuración', 'templateChatApi/save\n', 688,
        685, NULL, 1, 'templateChatApi/save\n', 1),
       (692, 'Configuraciones', '#', NULL, 686, 'fa fa-cog', 1, '#', 1),
       (693, 'Imagenes-Logo Header Principal', 'templateBySource/getSourcesTypesData', 692, 687, NULL, 1,
        'templateBySource/getSourcesTypesData', 1),
       (694, 'ADMIN GRID-Logo Header Principal', 'templateBySource/getSourcesTypesData', 693, 688, NULL, 1,
        'templateBySource/getSourcesTypesData', 1),
       (695, 'Update registro Formulario Logo Header Principal', 'templateBySource/save', 693, 689, NULL, 1,
        'templateBySource/save', 1),
       (696, 'Creacion registro Formulario Logo Header Principal', 'templateBySource/save', 693, 690, NULL, 1,
        'templateBySource/save', 1),
       (697, 'Imagenes-Favicon', 'templateBySource/getSourcesTypesData', 692, 691, NULL, 1,
        'templateBySource/getSourcesTypesData', 1),
       (698, 'ADMIN GRID-Favicon', 'templateBySource/getSourcesTypesData', 697, 692, NULL, 1,
        'templateBySource/getSourcesTypesData', 1),
       (699, 'Update registro Formulario Favicon', 'templateBySource/save', 697, 693, NULL, 1, 'templateBySource/save',
        1),
       (700, 'Creacion registro Formulario Favicon', 'templateBySource/save', 697, 694, NULL, 1,
        'templateBySource/save', 1),
       (701, 'Formas de Pago', 'templatePayments/admin', 692, 695, NULL, 1, 'templatePayments/admin', 1),
       (702, 'ADMIN GRID- Formas de Pago', 'templatePayments/admin', 701, 696, NULL, 1, 'templatePayments/admin', 1),
       (703, 'Update registro Formulario Formas de Pago', 'templatePayments/save', 701, 697, NULL, 1,
        'templatePayments/save', 1),
       (704, 'Creacion registro Formulario Formas de Pago', 'templatePayments/save', 701, 698, NULL, 1,
        'templatePayments/save', 1),
       (705, 'Dashboard', 'managerDashboard', NULL, 699, 'remixicon-dashboard-line', 1, 'managerDashboard', 0),
       (706, 'Configuracion', '#', NULL, 700, 'fa fa-cog', 1, '#', 1),
       (707, 'Equipos', 'eventsTrailsTypeTeams/admin', 706, 701, NULL, 1, 'eventsTrailsTypeTeams/admin', 1),
       (708, 'ADMIN GRID-Equipos', 'eventsTrailsTypeTeams/admin', 707, 702, NULL, 1, 'eventsTrailsTypeTeams/admin', 1),
       (709, 'Update registro Formulario Equipos', 'eventsTrailsTypeTeams/save', 707, 703, NULL, 1,
        'eventsTrailsTypeTeams/save', 1),
       (710, 'Creacion registro Formulario Equipos', 'eventsTrailsTypeTeams/save', 707, 704, NULL, 1,
        'eventsTrailsTypeTeams/save', 1),
       (711, 'Categorias', 'eventsTrailsTypeOfCategories/admin', 706, 705, NULL, 1,
        'eventsTrailsTypeOfCategories/admin', 1),
       (712, 'ADMIN GRID-Categorias', 'eventsTrailsTypeOfCategories/admin', 711, 706, NULL, 1,
        'eventsTrailsTypeOfCategories/admin', 1),
       (713, 'Update registro Formulario Categorias', 'eventsTrailsTypeOfCategories/save', 711, 707, NULL, 1,
        'eventsTrailsTypeOfCategories/save', 1),
       (714, 'Creacion registro Formulario Categorias', 'eventsTrailsTypeOfCategories/save', 711, 708, NULL, 1,
        'eventsTrailsTypeOfCategories/save', 1),
       (715, 'Distancias', 'eventsTrailsDistances/admin', 706, 709, NULL, 1, 'eventsTrailsDistances/admin', 1),
       (716, 'ADMIN GRID-Distancias', 'eventsTrailsDistances/admin', 715, 710, NULL, 1, 'eventsTrailsDistances/admin',
        1),
       (717, 'Update registro Formulario Distancias', 'eventsTrailsDistances/save', 715, 711, NULL, 1,
        'eventsTrailsDistances/save', 1),
       (718, 'Creacion registro Formulario Distancias', 'eventsTrailsDistances/save', 715, 712, NULL, 1,
        'eventsTrailsDistances/save', 1),
       (719, 'Obtencion Valores Formulario Equipos', 'eventsTrailsTypeTeams/listSelect2', 715, 713, NULL, 1,
        'eventsTrailsTypeTeams/listSelect2', 1),
       (720, 'Kits', 'eventsTrailsByKit/admin', 706, 714, NULL, 1, 'eventsTrailsByKit/admin', 1),
       (721, 'ADMIN GRID-Kits', 'eventsTrailsByKit/admin', 720, 715, NULL, 1, 'eventsTrailsByKit/admin', 1),
       (722, 'Update registro Formulario Kits', 'eventsTrailsByKit/save', 720, 716, NULL, 1, 'eventsTrailsByKit/save',
        1),
       (723, 'Creacion registro Formulario Kits', 'eventsTrailsByKit/save', 720, 717, NULL, 1, 'eventsTrailsByKit/save',
        1),
       (724, 'Obtencion Valores Prendas Piezas Formulario Kits', 'product/events/getProductService', 720, 718, NULL, 1,
        'product/events/getProductService', 1),
       (725, 'Puntos de Venta', 'eventsTrailsRegistrationPoints/admin', 706, 719, NULL, 1,
        'eventsTrailsRegistrationPoints/admin', 1),
       (726, 'ADMIN GRID- Puntos de Venta', 'eventsTrailsRegistrationPoints/admin', 725, 720, NULL, 1,
        'eventsTrailsRegistrationPoints/admin', 1),
       (727, 'Update registro Formulario Puntos de Venta', 'eventsTrailsRegistrationPoints/save', 725, 721, NULL, 1,
        'eventsTrailsRegistrationPoints/save', 1),
       (728, 'Creacion registro Formulario Puntos de Venta', 'eventsTrailsRegistrationPoints/save', 725, 722, NULL, 1,
        'eventsTrailsRegistrationPoints/save', 1),
       (729, 'Obtencion Valores Empresas Puntos de Venta', 'business/managementBusinessEvents', 725, 723, NULL, 1,
        'business/managementBusinessEvents', 1),
       (730, 'Button Manager-Eliminar', 'eventsTrailsRegistrationPoints/deletePointSale', 725, 724, NULL, 1,
        'eventsTrailsRegistrationPoints/deletePointSale', 1),
       (731, 'Button Manager-Administracion pagos', 'getDataPaymentsManagementEvent', 725, 725, NULL, 1,
        'getDataPaymentsManagementEvent', 1),
       (732, 'Menu Frontend', 'businessByMenuManagementFrontend/admin', 237, 726, NULL, 1,
        'businessByMenuManagementFrontend/admin', 1),
       (733, 'ADMIN GRID - Menu Frontend', 'businessByMenuManagementFrontend/admin', 732, 727, NULL, 1,
        'businessByMenuManagementFrontend/admin', 1),
       (734, 'Update registro Formulario Menu Frontend', 'businessByMenuManagementFrontend/save', 732, 728, NULL, 1,
        'businessByMenuManagementFrontend/save', 1),
       (735, 'Creacion registro Formulario Menu Frontend', 'businessByMenuManagementFrontend/save', 732, 729, NULL, 1,
        'businessByMenuManagementFrontend/save', 1),
       (736, 'Obtencion Valores Formulario Menu Frontend', 'businessByMenuManagementFrontend/listActionsParent', 732,
        730, NULL, 1, 'businessByMenuManagementFrontend/listActionsParent', 1),
       (737, 'Ofertas Academicas Slider\n', 'businessByAcademicOfferings/admin', 237, 731, NULL, 1,
        'businessByAcademicOfferings/admin', 1),
       (738, 'ADMIN GRID - Ofertas Academicas Slider\n', 'businessByAcademicOfferings/admin', 737, 732, NULL, 1,
        'businessByAcademicOfferings/admin', 1),
       (739, 'Update registro Formulario Ofertas Academicas Slider\n', 'businessByAcademicOfferings/save', 737, 733,
        NULL, 1, 'businessByAcademicOfferings/save', 1),
       (740, 'Creacion registro Formulario Ofertas Academicas Slider\n', 'businessByAcademicOfferings/save', 737, 734,
        NULL, 1, 'businessByAcademicOfferings/save', 1),
       (741, 'Obtencion Valores Formulario Ofertas Academicas Slider\n',
        'businessByMenuManagementFrontend/listActionsParent', 737, 735, NULL, 1,
        'businessByMenuManagementFrontend/listActionsParent', 1),
       (742, 'Buttons Manager- Administracion Ofertas Datos', 'businessAcademicOfferingsByData/admin', 237, 736, NULL,
        1, 'businessAcademicOfferingsByData/admin', 1),
       (743, 'ADMIN GRID - Administracion Ofertas Datos\n', 'businessAcademicOfferingsByData/admin', 742, 737, NULL, 1,
        'businessAcademicOfferingsByData/admin', 1),
       (744, 'Update registro Formulario Administracion Ofertas Datos', 'businessAcademicOfferingsByData/save', 742,
        738, NULL, 1, 'businessAcademicOfferingsByData/save', 1),
       (745, 'Creacion registro Formulario Administracion Ofertas Datos\n', 'businessAcademicOfferingsByData/save', 742,
        739, NULL, 1, 'businessAcademicOfferingsByData/save', 1),
       (746, 'Ofertas Academicas \n', 'businessByAcademicOfferingsInstitution/admin\n', 237, 740, NULL, 1,
        'businessByAcademicOfferings/admin', 1),
       (747, 'ADMIN GRID - Ofertas Academicas', 'businessByAcademicOfferingsInstitution/admin', 746, 741, NULL, 1,
        'businessByAcademicOfferings/admin', 1),
       (748, 'Update registro Formulario Ofertas Academicas', 'businessByAcademicOfferingsInstitution/save', 746, 742,
        NULL, 1, 'businessByAcademicOfferings/save', 1),
       (749, 'Creacion registro Formulario Ofertas Academicas \n', 'businessByAcademicOfferingsInstitution/save', 746,
        743, NULL, 1, 'businessByAcademicOfferings/save', 1),
       (750, 'Preguntas Frecuentes\n', 'businessByFrequentQuestion/admin\n', 237, 744, NULL, 1,
        'businessByFrequentQuestion/admin\n', 1),
       (751, 'ADMIN GRID - Preguntas Frecuentes\n', 'businessByFrequentQuestion/admin', 750, 745, NULL, 1,
        'businessByFrequentQuestion/admin', 1),
       (752, 'Update registro Formulario Preguntas Frecuentes\n', 'businessByFrequentQuestion/save', 750, 746, NULL, 1,
        'businessByFrequentQuestion/save', 1),
       (753, 'Creacion registro Formulario Preguntas Frecuentes\n', 'businessByFrequentQuestion/save', 750, 747, NULL,
        1, 'businessByFrequentQuestion/save', 1),
       (754, 'Requerimientos\n', 'businessByRequirements/admin\n', 237, 748, NULL, 1, 'businessByRequirements/admin\n',
        1),
       (755, 'ADMIN GRID - Requerimientos\n', 'businessByRequirements/admin', 754, 749, NULL, 1,
        'businessByRequirements/admin', 1),
       (756, 'Update registro Formulario Requerimientos\n', 'businessByRequirements/save', 754, 750, NULL, 1,
        'businessByRequirements/save', 1),
       (757, 'Creacion registro Formulario Requerimientos\n', 'businessByRequirements/save', 754, 751, NULL, 1,
        'businessByRequirements/save', 1),
       (758, 'Cuenta', '#', NULL, 726, 'fas fa-business-time', 1, '#', 1),
       (759, 'Tablero', 'account', 732, 727, 'NULL', 1, 'account', 1),
       (760, 'ADMIN Information Perfil', 'myProfile', 732, 728, 'NULL', 1, 'myProfile', 1),
       (761, 'Creacion/Actualizacion registro Perfil', 'customerProfile/save', 732, 729, 'NULL', 1,
        'customerProfile/save', 1),
       (762, 'ADMIN Pasword', 'password', 732, 730, 'NULL', 1, 'password', 1),
       (763, 'Creacion/Actualizacion registro Contrasenia', 'user/save/changePassword', 732, 731, 'NULL', 1,
        'user/save/changePassword', 1),
       (764, 'ADMIN Pasword', 'suggestionsMailBox', 732, 732, 'NULL', 1, 'suggestionsMailBox', 1),
       (765, 'Administracion Meetclic', '#', NULL, 733, 'fas fa-business-time', 1, '#', 1),
       (766, 'Mis Negocios Manager', 'business', 739, 734, 'NULL', 1, 'business', 1),
       (767, 'ADMIN GRID- Mis Negocios', 'business/admin', 739, 735, 'NULL', 1, 'business/admin', 1),
       (768, 'Update registro Formulario Mis Negocios', 'business/save', 739, 736, 'NULL', 1, 'business/save', 1),
       (769, 'Creacion registro Formulario Mis Negocios', 'business/save', 739, 737, 'NULL', 1, 'business/save', 1),
       (770, 'Button Manager- Manager Business', 'managerBusiness', 740, 738, 'NULL', 1, 'managerBusiness', 1),
       (771, 'ADMIN GRID- Empresas Amigas', 'listingsQueen', 739, 739, 'NULL', 1, 'listingsQueen', 1),
       (772, 'ADMIN GRID- Amigos', 'bee', 739, 740, 'NULL', 1, 'bee', 1),
       (773, 'ADMIN GRID- Mis Sugerencias', 'reviewsTo', 739, 741, 'NULL', 1, 'reviewsTo', 1),
       (774, 'Puntos de Venta Manager', 'pointsSales', 739, 742, 'NULL', 1, 'pointsSales', 1),
       (775, 'ADMIN GRID- Puntos de Venta', 'pointsSales/admin', 739, 743, 'NULL', 1, 'pointsSales/admin', 1),
       (776, 'Update registro Formulario Puntos de Venta', 'pointsSales/save', 739, 744, 'NULL', 1, 'pointsSales/save',
        1),
       (777, 'Creacion registro Formulario Puntos de Venta', 'pointsSales/save', 739, 745, 'NULL', 1,
        'pointsSales/save', 1),
       (778, 'Historiales', '#', NULL, 746, 'fas fa-business-time', 1, '#', 1),
       (779, 'Ordenes Manager', 'orders', 752, 747, 'NULL', 1, 'orders', 1),
       (780, 'ADMIN GRID- Ordenes', 'orderPaymentsManager/adminCustomers', 752, 748, 'NULL', 1,
        'orderPaymentsManager/adminCustomers', 1);
INSERT INTO `actions` (`id`, `name`, `link`, `parent_id`, `weight`, `icon`, `type`, `description`, `type_item`)
VALUES (781, 'Update registro Formulario  Ordenes', 'orderPaymentsManager/save', 752, 749, 'NULL', 1,
        'orderPaymentsManager/save', 1),
       (782, 'Creacion registro Formulario Ordenes', 'orderPaymentsManager/save', 752, 750, 'NULL', 1,
        'orderPaymentsManager/save', 1);

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

--
-- Dumping data for table `allergies`
--

INSERT INTO `allergies` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`)
VALUES (1, 'Polen', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (2, 'Ácaros del polvo', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (3, 'Esporas de moho', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (4, 'Caspa de animales', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (5, 'Picaduras de insectos', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (6, 'Fármacos Cetirizina (Zyrtec Allergy)', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (7, 'Alimento', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (8, 'Veneno de insectos', NULL, NULL, NULL, NULL, 'ACTIVE'),
       (9, 'Farmacos Insulina', '(en particular, fuentes animales de insulina)', NULL, NULL, NULL, 'ACTIVE'),
       (10, 'Farmaco Medios de contraste',
        'Medios de contraste para rayos X con yodo (pueden causar reacciones similares a las alergias)', NULL, NULL,
        NULL, 'ACTIVE'),
       (11, 'Farmaco Penicilina y antibióticos conexos', 'Penicilina y antibióticos conexos', NULL, NULL, NULL,
        'ACTIVE'),
       (12, 'Farmaco Sulfamidas', 'Sulfamidas', NULL, NULL, NULL, 'ACTIVE');

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

--
-- Dumping data for table `antecedent`
--

INSERT INTO `antecedent` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 'Caries', 'Caries', 'ACTIVE', '2024-02-29 14:21:10', '2024-02-29 14:21:10', NULL),
       (2, 'Endodoncias', 'Endodoncias', 'ACTIVE', '2024-02-29 14:21:37', '2024-02-29 14:21:37', NULL),
       (3, 'Extracciones', '', 'ACTIVE', '2024-02-29 14:21:45', '2024-02-29 14:21:45', NULL);

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

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `value`, `description`, `status`)
VALUES (1, 'PICHINCHA', 'PICHINCHA', 'ACTIVE'),
       (2, 'PACIFICO', 'PACIFICO', 'ACTIVE'),
       (3, 'AUSTRO', 'AUSTRO', 'ACTIVE'),
       (4, 'GUAYAQUIL', 'GUAYAQUIL', 'ACTIVE');

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

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `description`, `title`, `email`, `page_url`, `phone_value`, `street_1`, `street_2`,
                        `street_lat`, `street_lng`, `user_id`, `business_subcategories_id`, `created_at`, `updated_at`,
                        `deleted_at`, `status`, `qualification`, `source`, `options_map`, `has_document`, `has_about`,
                        `has_service_delivery`, `type_business`, `type_manager_payment`, `business_name`,
                        `keep_accounting`, `type_ruc_id`, `allow_cash_and_banks`, `entity_plans_id`,
                        `entity_position_fiscal_id`, `document`)
VALUES (1, 'ADD', 'INKA', 'inka@gmail.COM', 'null', '0994838506', 'CALLE UNO', 'CALLE DOS', 0.23148, -78.2685, 1, 69,
        NULL, NULL, NULL, 'ACTIVE', 0,
        '/uploads/business/information/1662390741_295794136_1472633853164606_2532871475146847925_n.jpg', NULL, 0, 0, 0,
        0, 0, '', 0, 4, 0, 3, 1, '');

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

--
-- Dumping data for table `business_amenities`
--

INSERT INTO `business_amenities` (`id`, `value`, `description`, `state`, `source`, `type_source`,
                                  `business_subcategories_id`)
VALUES (1, 'Estacionamiento', NULL, 'ACTIVE', 'fa fa-rocket', 0, 1),
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

--
-- Dumping data for table `business_by_counter`
--

INSERT INTO `business_by_counter` (`id`, `count`, `business_id`, `action_name`)
VALUES (1, 7, 1, 'shopPage'),
       (2, 6, 1, 'homeEatPura'),
       (3, 4, 1, ''),
       (4, 1, 1, 'business'),
       (5, 1, 1, 'myProfile'),
       (6, 1, 1, 'userAccount');

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

--
-- Dumping data for table `business_by_gamification`
--

INSERT INTO `business_by_gamification` (`id`, `gamification_id`, `business_id`, `allow_exchange`,
                                        `allow_exchange_business`, `state`)
VALUES (1, 1, 6, 0, 0, 'ACTIVE');

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

--
-- Dumping data for table `business_by_language`
--

INSERT INTO `business_by_language` (`id`, `language_id`, `business_id`, `state`, `main`)
VALUES (1, 1, 1, 'ACTIVE', 0),
       (2, 2, 1, 'ACTIVE', 0),
       (3, 3, 1, 'ACTIVE', 1);

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

--
-- Dumping data for table `business_by_products`
--

INSERT INTO `business_by_products` (`id`, `business_id`, `products_id`)
VALUES (1, 1, 1),
       (2, 1, 2),
       (3, 1, 3),
       (4, 1, 4),
       (5, 1, 5),
       (6, 1, 6),
       (7, 1, 7),
       (8, 1, 8),
       (9, 1, 9),
       (10, 1, 10),
       (11, 1, 11),
       (12, 1, 12),
       (13, 1, 13),
       (14, 1, 14),
       (15, 1, 15),
       (16, 1, 16),
       (17, 1, 17),
       (18, 1, 18),
       (19, 1, 19),
       (20, 1, 20);

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

--
-- Dumping data for table `business_by_products_parent`
--

INSERT INTO `business_by_products_parent` (`id`, `business_id`, `product_parent_id`)
VALUES (1, 1, 1);

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

--
-- Dumping data for table `business_by_schedule`
--

INSERT INTO `business_by_schedule` (`id`, `type`, `open`, `business_id`, `status`, `schedule_days_category_id`)
VALUES (1, 0, 1, 1, 'ACTIVE', 1),
       (2, 0, 1, 1, 'ACTIVE', 2),
       (3, 0, 1, 1, 'ACTIVE', 3),
       (4, 0, 1, 1, 'ACTIVE', 4),
       (5, 0, 1, 1, 'ACTIVE', 5),
       (6, 0, 1, 1, 'ACTIVE', 6),
       (7, 0, 1, 1, 'ACTIVE', 7);

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

--
-- Dumping data for table `business_categories`
--
INSERT INTO `business_categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`, `src`, `has_icon`,
                                   `icon_class`, `description`)
VALUES (1, 'Comida y Bebida', 'ACTIVE', NULL, '2020-05-05 13:31:21', NULL, '/uploads/business/categories/6.png', 1,
        'fa fa-cutlery',
        'Descubre sabores locales, apoya emprendimientos culinarios y disfruta cada bocado con sentido.'),
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

--
-- Dumping data for table `business_location`
--

INSERT INTO `business_location` (`id`, `zones_id`, `business_id`)
VALUES (1, 2, 1);

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

--
-- Dumping data for table `business_subcategories`
--

INSERT INTO `business_subcategories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`,
                                      `business_categories_id`, `src`, `has_icon`, `icon_class`, `description`)
VALUES (1, 'Restaurantes', 'ACTIVE', NULL, NULL, NULL, 1, 'no-manager', 0, 'anyone', ''),
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

--
-- Dumping data for table `caja_catalogo_billete`
--

INSERT INTO `caja_catalogo_billete` (`id`, `caja_tipo_billete_id`, `value`, `caja_catalogo_tipo_fraccion_id`, `valor`)
VALUES (1, 1, '10 Dolares', 2, 10);

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

--
-- Dumping data for table `caja_catalogo_tipo_fraccion`
--

INSERT INTO `caja_catalogo_tipo_fraccion` (`id`, `value`, `descripcion`)
VALUES (1, 'Moneda', NULL),
       (2, 'Billete', NULL);

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

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `location`, `province_id`, `status`, `created_at`, `updated_at`, `deleted_at`,
                      `place_id`)
VALUES (1, 'Otavalo', 0x000000000101000000254774aeac9053c004eae6459ab6cd3f, 15, 'ACTIVE', '2020-05-20 21:41:43',
        '2020-05-20 21:41:43', NULL, 'none-id'),
       (2, 'Ibarra', 0x00000000010100000010c935aa788853c01b199aa1a737d63f, 15, 'ACTIVE', '2020-05-20 21:50:44',
        '2020-05-20 21:50:44', NULL, 'none-id'),
       (3, 'Atuntaqui', 0x000000000101000000da1d10f0fd8a53c0d60769f8dc2ad53f, 15, 'ACTIVE', '2020-05-20 21:50:57',
        '2024-02-29 12:51:14', NULL, 'none-id'),
       (4, 'Cotacachi', 0x0000000001010000003d4ff2d9f09053c0451559c6e1a7d33f, 15, 'ACTIVE', '2020-05-20 21:51:09',
        '2020-05-20 21:51:09', NULL, 'none-id'),
       (5, 'Huaca', 0x000000000101000000173f32c2806e53c0372dc25e722de43f, 12, 'ACTIVE', '2020-07-14 05:34:28',
        '2020-07-16 09:54:27', NULL, 'none-id'),
       (6, 'Tulcán', 0x000000000101000000c503caa6dc6d53c095c84ff40a15ea3f, 12, 'ACTIVE', '2020-07-16 09:48:28',
        '2020-07-16 09:48:28', NULL, 'none-id'),
       (7, 'Bolívar', 0x00000000010100000040f61f3ed57953c0be8eeed6e80be03f, 12, 'ACTIVE', '2020-07-16 09:54:12',
        '2020-07-16 09:54:12', NULL, 'none-id'),
       (8, 'Espejo', 0x000000000101000000a1919df1dc7a53c039260f343418e03f, 12, 'ACTIVE', '2020-07-16 09:56:36',
        '2020-07-16 09:56:55', NULL, 'none-id'),
       (9, 'Mira', 0x000000000101000000f04284c99e8253c090279364679be13f, 12, 'ACTIVE', '2020-07-16 09:57:14',
        '2020-07-16 09:57:14', NULL, 'none-id'),
       (10, 'Montufar', 0x000000000101000000cc7c073f717153c023d74d29af15e23f, 12, 'ACTIVE', '2020-07-16 09:57:36',
        '2020-07-16 09:57:36', NULL, 'none-id'),
       (11, 'Cuenca', 0x0000000001010000004caab69b60c053c08e942d92763307c0, 9, 'ACTIVE', '2020-07-16 09:58:36',
        '2020-07-16 09:58:36', NULL, 'none-id'),
       (12, 'Camilo Ponce Enríquez', 0x000000000101000000600c9bb7a0ef53c0af42ca4faa7d08c0, 9, 'ACTIVE',
        '2020-07-16 09:58:52', '2020-07-16 09:58:52', NULL, 'none-id'),
       (13, 'Chordeleg', 0x00000000010100000038ff65add7b153c029835957bb6c07c0, 9, 'ACTIVE', '2020-07-16 09:59:11',
        '2020-07-16 10:00:50', NULL, 'none-id'),
       (14, 'El Pan', 0x000000000101000000cbc1c7bb7eaa53c06ab3fb9f0d4a06c0, 9, 'ACTIVE', '2020-07-16 09:59:32',
        '2020-07-16 09:59:32', NULL, 'none-id'),
       (15, 'Girón', 0x0000000001010000003ba4bd665ec953c0abfead090e4409c0, 9, 'ACTIVE', '2020-07-16 09:59:48',
        '2020-07-16 09:59:48', NULL, 'none-id'),
       (16, 'Guachapala', 0x000000000101000000cc33e5f9c2ad53c0bbb0daa1062806c0, 9, 'ACTIVE', '2020-07-16 10:00:06',
        '2020-07-16 10:00:06', NULL, 'none-id'),
       (17, 'Gualaceo', 0x000000000101000000d968ef42a9b153c0d751d504511707c0, 9, 'ACTIVE', '2020-07-16 10:00:25',
        '2020-07-16 10:00:25', NULL, 'none-id'),
       (18, 'Nabon', 0x00000000010100000066a60fb809c453c00de94bca38b10ac0, 9, 'ACTIVE', '2020-07-16 10:01:20',
        '2020-07-16 10:01:20', NULL, 'none-id'),
       (19, 'Oña', 0x000000000101000000e2b43bffd1c953c0e26def6481c00bc0, 9, 'ACTIVE', '2020-07-16 10:01:40',
        '2020-07-16 10:01:40', NULL, 'none-id'),
       (20, 'Paute', 0x00000000010100000032079c001eb153c0dc0da2b5a25d06c0, 9, 'ACTIVE', '2020-07-16 10:02:00',
        '2020-07-16 10:02:00', NULL, 'none-id'),
       (21, 'Pucará', 0x0000000001010000009d41e84512de53c03058bb37d0bd09c0, 9, 'ACTIVE', '2020-07-16 10:02:17',
        '2020-07-16 10:02:17', NULL, 'none-id'),
       (22, 'San Fernando', 0x000000000101000000d5bb2eb253d053c023d74d29af2509c0, 9, 'ACTIVE', '2020-07-16 10:05:56',
        '2020-07-16 10:05:56', NULL, 'none-id'),
       (23, 'Santa Isabel', 0x0000000001010000004a46cec21ed453c081bd78f5e0340ac0, 9, 'ACTIVE', '2020-07-16 10:06:12',
        '2020-07-16 10:06:12', NULL, 'none-id'),
       (24, 'Sevilla de Oro', 0x0000000001010000003c743051f3a953c0ed6877a3ea6206c0, 9, 'ACTIVE', '2020-07-16 10:06:29',
        '2020-07-16 10:06:29', NULL, 'none-id'),
       (25, 'Sigsig', 0x0000000001010000002da8b926eeb253c0bfa9fef7966808c0, 9, 'ACTIVE', '2020-07-16 10:06:44',
        '2020-07-16 10:06:44', NULL, 'none-id'),
       (26, 'Guaranda', 0x000000000101000000bbfda83cf0bf53c0f77deeba6d75f9bf, 10, 'ACTIVE', '2020-07-16 10:08:53',
        '2020-07-16 10:08:53', NULL, 'none-id'),
       (27, 'Caluma', 0x00000000010100000012f8c3cf7fd053c0a222f36d6619fabf, 10, 'ACTIVE', '2020-07-16 10:09:34',
        '2020-07-16 10:09:34', NULL, 'none-id'),
       (28, 'Chillanes', 0x000000000101000000252eb6ff37c453c0b31fce685019ffbf, 10, 'ACTIVE', '2020-07-16 10:09:56',
        '2020-07-16 10:09:56', NULL, 'none-id'),
       (29, 'Chimbo', 0x0000000001010000006c596375d0c153c041834d9d47e5fabf, 10, 'ACTIVE', '2020-07-16 10:10:15',
        '2020-07-16 10:10:15', NULL, 'none-id'),
       (30, 'Echeandía', 0x000000000101000000a06cca15ded153c0ed815660c8eaf6bf, 10, 'ACTIVE', '2020-07-16 10:10:32',
        '2020-07-16 10:10:32', NULL, 'none-id'),
       (31, 'Las Naves', 0x00000000010100000039ed293927d453c0c7455acfb594f4bf, 10, 'ACTIVE', '2020-07-16 10:10:51',
        '2020-07-16 10:10:51', NULL, 'none-id'),
       (32, 'San Miguel', 0x0000000001010000008395f9fd51c253c0c319b2704879fbbf, 10, 'ACTIVE', '2020-07-16 10:12:03',
        '2020-07-16 10:12:03', NULL, 'none-id'),
       (33, 'Azogues', 0x0000000001010000008e26721c53b653c0418754ac75ed05c0, 11, 'ACTIVE', '2020-07-16 10:17:12',
        '2020-07-16 10:17:12', NULL, 'none-id'),
       (34, 'Biblián', 0x00000000010100000000f1a952e9b853c03345ca60d6b505c0, 11, 'ACTIVE', '2020-07-16 10:17:28',
        '2020-07-16 10:17:28', NULL, 'none-id'),
       (35, 'Cañar', 0x00000000010100000019ee128bcebb53c0e0675c38107204c0, 11, 'ACTIVE', '2020-07-16 10:17:51',
        '2020-07-16 10:17:51', NULL, 'none-id'),
       (36, 'Déleg', 0x000000000101000000902fa18243bb53c0a327c00bb64c06c0, 11, 'ACTIVE', '2020-07-16 10:18:07',
        '2020-07-16 10:18:07', NULL, 'none-id'),
       (37, 'El Tambo', 0x000000000101000000902fa18243bb53c08c92a174331d04c0, 11, 'ACTIVE', '2020-07-16 10:18:27',
        '2020-07-16 10:18:27', NULL, 'none-id'),
       (38, 'La Troncal', 0x00000000010100000030568ad3ffd553c0c23d85121c5d03c0, 11, 'ACTIVE', '2020-07-16 10:18:46',
        '2020-07-16 10:18:46', NULL, 'none-id'),
       (39, 'Suscal', 0x00000000010100000018891a9650c353c00bf956da987d03c0, 11, 'ACTIVE', '2020-07-16 10:19:02',
        '2020-07-16 10:19:02', NULL, 'none-id'),
       (40, 'Riobamba', 0x00000000010100000031c225112baa53c0d98fb9d7eea3fabf, 14, 'ACTIVE', '2020-07-16 10:19:44',
        '2020-07-16 10:19:44', NULL, 'none-id'),
       (41, 'Alausí', 0x0000000001010000004c080c4831b653c0aa0d4e44bf9601c0, 14, 'ACTIVE', '2020-07-16 10:19:57',
        '2020-07-16 10:19:57', NULL, 'none-id'),
       (42, 'Chambo', 0x0000000001010000003bd972d30ba653c01989754fc3bcfbbf, 14, 'ACTIVE', '2020-07-16 10:20:15',
        '2020-07-16 10:20:15', NULL, 'none-id'),
       (43, 'Chunchi', 0x0000000001010000000781f0fcfdba53c09fa97c748f5102c0, 14, 'ACTIVE', '2020-07-16 10:20:28',
        '2020-07-16 10:20:28', NULL, 'none-id'),
       (44, 'Colta', 0x000000000101000000a9f17794efb053c0a96a82a8fbc0fbbf, 14, 'ACTIVE', '2020-07-16 10:22:06',
        '2020-07-16 10:22:06', NULL, 'none-id'),
       (45, 'Cumanda', 0x000000000101000000f3db210f8ec853c0c689af7614a701c0, 14, 'ACTIVE', '2020-07-16 10:22:23',
        '2020-07-16 10:22:23', NULL, 'none-id'),
       (46, 'Guamote', 0x00000000010100000019d8744e7dad53c0ea8fd552e500ffbf, 14, 'ACTIVE', '2020-07-16 10:22:41',
        '2020-07-16 10:22:41', NULL, 'none-id'),
       (47, 'Guano', 0x00000000010100000024fbd63d68a853c09b30abc145b8f9bf, 14, 'ACTIVE', '2020-07-16 10:22:55',
        '2020-07-16 10:22:55', NULL, 'none-id'),
       (48, 'Pallatanga', 0x000000000101000000caa31b6151be53c0b5d320167b2900c0, 14, 'ACTIVE', '2020-07-16 10:23:10',
        '2020-07-16 10:23:10', NULL, 'none-id'),
       (49, 'Penipe', 0x0000000001010000009a9fd10c98a253c0412553aae9dff8bf, 14, 'ACTIVE', '2020-07-16 10:23:23',
        '2020-07-16 10:23:23', NULL, 'none-id'),
       (50, 'Latacunga', 0x0000000001010000000612143fc6a653c0fc8f4c874ecfedbf, 13, 'ACTIVE', '2020-07-16 10:23:56',
        '2020-07-16 10:23:56', NULL, 'none-id'),
       (51, 'La Maná', 0x00000000010100000071276c9ad2ce53c0062f55c4441eeebf, 13, 'ACTIVE', '2020-07-16 10:24:12',
        '2020-07-16 10:24:12', NULL, 'none-id'),
       (52, 'Pujilí', 0x0000000001010000000d1f6c0c95ac53c0c51c041dadaaeebf, 13, 'ACTIVE', '2020-07-16 10:24:54',
        '2020-07-16 10:24:54', NULL, 'none-id'),
       (53, 'Salcedo', 0x00000000010100000001c34da1cea553c0aedbfbafceacf0bf, 13, 'ACTIVE', '2020-07-16 10:25:10',
        '2020-07-16 10:25:10', NULL, 'none-id'),
       (54, 'Saquisilí', 0x0000000001010000004e999b6fc4aa53c0a4e771738552eabf, 13, 'ACTIVE', '2020-07-16 10:25:29',
        '2020-07-16 10:25:29', NULL, 'none-id'),
       (55, 'Sigchos', 0x000000000101000000cc892c88b7b853c08cf1063d405ce6bf, 13, 'ACTIVE', '2020-07-16 10:25:41',
        '2020-07-16 10:25:41', NULL, 'none-id'),
       (56, 'Pangua', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 13, 'ACTIVE', '2020-07-16 10:26:08',
        '2020-07-16 10:26:32', NULL, 'none-id'),
       (57, 'Machala', 0x00000000010100000034362a2625fd53c0bcd9d59a9c100ac0, 8, 'ACTIVE', '2020-07-16 10:27:30',
        '2020-07-16 10:27:30', NULL, 'none-id'),
       (58, 'Arenillas', 0x000000000101000000a4479dca330454c0647b88a130730cc0, 8, 'ACTIVE', '2020-07-16 10:27:42',
        '2020-07-16 10:27:42', NULL, 'none-id'),
       (59, 'Atahualpa', 0x000000000101000000c507d1b58a3154c022fc8ba0318302c0, 8, 'ACTIVE', '2020-07-16 10:28:01',
        '2020-07-16 10:28:01', NULL, 'none-id'),
       (60, 'Balsas', 0x00000000010100000075b05989d4f453c082154ca198110ec0, 8, 'ACTIVE', '2020-07-16 10:28:17',
        '2020-07-16 10:28:17', NULL, 'none-id'),
       (61, 'Chilla', 0x00000000010100000067ce9fdbf0e453c0a3eb1dc940a90bc0, 8, 'ACTIVE', '2020-07-16 10:28:37',
        '2020-07-16 10:28:37', NULL, 'none-id'),
       (62, 'El Guabo', 0x000000000101000000ceb348c961f453c03912c3691ce509c0, 8, 'ACTIVE', '2020-07-16 10:28:50',
        '2020-07-16 10:28:50', NULL, 'none-id'),
       (63, 'Huaquillas', 0x00000000010100000045798b2c3e0e54c06625f785a1cf0bc0, 8, 'ACTIVE', '2020-07-16 10:29:10',
        '2020-07-16 10:29:10', NULL, 'none-id'),
       (64, 'Marcabelí', 0x000000000101000000d9ffa5b162fa53c022235635f7460ec0, 8, 'ACTIVE', '2020-07-16 10:29:46',
        '2020-07-16 10:29:46', NULL, 'none-id'),
       (65, 'Las Lajas', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 8, 'ACTIVE', '2020-07-16 10:30:05',
        '2020-07-16 10:30:05', NULL, 'none-id'),
       (66, 'Pasaje', 0x000000000101000000bcbf8b0890f353c0e3fa1cc4739b0ac0, 8, 'ACTIVE', '2020-07-16 10:30:21',
        '2020-07-16 10:30:21', NULL, 'none-id'),
       (67, 'Piñas', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 8, 'ACTIVE', '2020-07-16 10:30:44',
        '2020-07-16 10:30:44', NULL, 'none-id'),
       (68, 'Portovelo', 0x000000000101000000d59ddd1019e753c0f34b0ee901bd0dc0, 8, 'ACTIVE', '2020-07-16 10:31:06',
        '2020-07-16 10:31:06', NULL, 'none-id'),
       (69, 'Santa Rosa', 0x000000000101000000feb04a8ee0fd53c082300109d4ac0bc0, 8, 'ACTIVE', '2020-07-16 10:31:21',
        '2020-07-16 10:31:21', NULL, 'none-id'),
       (70, 'Zaruma', 0x000000000101000000d59ddd1019e753c088765fdf987f0dc0, 8, 'ACTIVE', '2020-07-16 10:31:36',
        '2020-07-16 10:31:36', NULL, 'none-id'),
       (71, 'Esmeraldas', 0x0000000001010000002049a4c8b5e953c011ac055152fbee3f, 2, 'ACTIVE', '2020-07-16 10:32:20',
        '2020-07-16 10:32:20', NULL, 'none-id'),
       (72, 'Atacames', 0x0000000001010000001fad20bc2cf653c0024466d3b6c6eb3f, 2, 'ACTIVE', '2020-07-16 10:32:35',
        '2020-07-16 10:32:35', NULL, 'none-id'),
       (73, 'Eloy Alfaro', 0x0000000001010000008d11e4fbbdf553c093fe5e0a0f5a01c0, 2, 'ACTIVE', '2020-07-16 10:32:44',
        '2020-07-16 10:32:44', NULL, 'none-id'),
       (74, 'Muisne', 0x000000000101000000ee5f5969520154c04523e9e45692e33f, 2, 'ACTIVE', '2020-07-16 10:33:38',
        '2020-07-16 10:33:38', NULL, 'none-id'),
       (75, 'Quinindé', 0x000000000101000000637891aebedd53c091f8cbdd9debd43f, 2, 'ACTIVE', '2020-07-16 10:33:59',
        '2020-07-16 10:35:16', NULL, 'none-id'),
       (76, 'Río Verde', 0x0000000001010000004e4354e1cfd953c0f279c5538ff4f03f, 2, 'ACTIVE', '2020-07-16 10:34:36',
        '2020-07-16 10:34:36', NULL, 'none-id'),
       (77, 'San Lorenzo', 0x000000000101000000f38d8de502b653c07c708802c74ff43f, 2, 'ACTIVE', '2020-07-16 10:35:00',
        '2020-07-16 10:35:00', NULL, 'none-id'),
       (78, 'San Cristóbal, Galápagos', 0x000000000101000000778ab03ca36356c07c04a337810eedbf, 1, 'ACTIVE',
        '2020-07-16 10:36:35', '2020-07-16 10:36:35', NULL, 'none-id'),
       (79, 'Isabella', 0x000000000101000000ce6a05768a1754c00c86c6555d3efb3f, 1, 'ACTIVE', '2020-07-16 10:38:03',
        '2020-07-16 10:39:50', NULL, 'none-id'),
       (80, 'Santa Cruz', 0x00000000010100000066666666669656c0d42f6c281011e1bf, 1, 'ACTIVE', '2020-07-16 10:39:08',
        '2020-07-16 10:39:08', NULL, 'none-id'),
       (81, 'Guayaquil', 0x000000000101000000a83eeb75e6f853c0e18cabdbea8301c0, 6, 'ACTIVE', '2020-07-16 23:12:05',
        '2020-07-16 23:12:05', NULL, 'none-id'),
       (82, 'Alfredo Baquerizo Moreno', 0x00000000010100000032cdcf6886e353c04dafdef2a240febf, 6, 'ACTIVE',
        '2020-07-16 23:12:29', '2020-07-16 23:12:29', NULL, 'none-id'),
       (83, 'Balao', 0x000000000101000000eb3b1ae233f453c0c0ab8a15da4e07c0, 6, 'ACTIVE', '2020-07-16 23:15:26',
        '2020-07-16 23:15:26', NULL, 'none-id'),
       (84, 'Balzar', 0x000000000101000000ae19cf5694f953c0d9a0e52fe3dcf5bf, 6, 'ACTIVE', '2020-07-16 23:15:40',
        '2020-07-16 23:15:40', NULL, 'none-id'),
       (85, 'Colimes', 0x000000000101000000995423aaa60054c091e2d2e759bff8bf, 6, 'ACTIVE', '2020-07-16 23:16:03',
        '2020-07-16 23:16:16', NULL, 'none-id'),
       (86, 'Daule', 0x0000000001010000000954ff2092fe53c0963e74417dcbfdbf, 6, 'ACTIVE', '2020-07-16 23:16:29',
        '2020-07-16 23:16:29', NULL, 'none-id'),
       (87, 'Durán', 0x0000000001010000008d11e4fbbdf553c093fe5e0a0f5a01c0, 6, 'ACTIVE', '2020-07-16 23:16:42',
        '2020-07-16 23:16:42', NULL, 'none-id'),
       (88, 'El Empalme', 0x0000000001010000008ed36b0eebe653c0b89d6cb9e9c5f0bf, 6, 'ACTIVE', '2020-07-16 23:16:53',
        '2020-07-16 23:16:53', NULL, 'none-id'),
       (89, 'El Triunfo', 0x000000000101000000642c89a2f6d953c01dc6490625a102c0, 6, 'ACTIVE', '2020-07-17 03:11:56',
        '2020-07-17 03:11:56', NULL, 'none-id'),
       (90, 'General Antonio Elizalde', 0x000000000101000000b4194c68b7cb53c01f6228cc208301c0, 6, 'ACTIVE',
        '2020-07-17 03:14:04', '2020-07-17 03:14:04', NULL, 'none-id'),
       (91, 'Isidro Ayora', 0x0000000001010000003b2bb352520954c02dba50549125febf, 6, 'ACTIVE', '2020-07-17 03:14:29',
        '2020-07-17 03:14:29', NULL, 'none-id'),
       (92, 'Lomas de Sargentillo', 0x000000000101000000285426eba60554c0925ed4ee5701febf, 6, 'ACTIVE',
        '2020-07-17 03:14:48', '2020-07-17 03:14:48', NULL, 'none-id'),
       (93, 'Coronel Marcelino Maridueña', 0x0000000001010000004ccfaa85c8d953c0853d923765f301c0, 6, 'ACTIVE',
        '2020-07-17 03:15:07', '2020-07-17 03:15:07', NULL, 'none-id'),
       (94, 'Milagro', 0x000000000101000000edfe678302e653c05f950b957f1d01c0, 6, 'ACTIVE', '2020-07-17 03:15:22',
        '2020-07-17 03:15:22', NULL, 'none-id'),
       (95, 'Naranjal', 0x000000000101000000d768de16d1e753c0c7c33181115a05c0, 6, 'ACTIVE', '2020-07-17 03:15:34',
        '2020-07-17 03:15:34', NULL, 'none-id'),
       (96, 'Naranjito', 0x000000000101000000ef9705c9f1db53c050fbad9d286901c0, 6, 'ACTIVE', '2020-07-17 03:17:40',
        '2020-07-17 03:17:40', NULL, 'none-id'),
       (97, 'Nobol', 0x00000000010100000076995077d40054c0f156a71485a7febf, 6, 'ACTIVE', '2020-07-17 03:17:56',
        '2020-07-17 03:17:56', NULL, 'none-id'),
       (98, 'Palestina', 0x000000000101000000b24813ef80fe53c0a1061dbe9601fabf, 6, 'ACTIVE', '2020-07-17 03:18:32',
        '2020-07-17 03:18:32', NULL, 'none-id'),
       (99, 'Pedro Carbo', 0x00000000010100000043c0c69a360f54c0d1b01875ad1dfdbf, 6, 'ACTIVE', '2020-07-17 03:18:53',
        '2020-07-17 03:18:53', NULL, 'none-id'),
       (100, 'Playas', 0x0000000001010000003ef90505ef1854c0ed9458631a0705c0, 6, 'ACTIVE', '2020-07-17 03:19:09',
        '2020-07-17 03:19:09', NULL, 'none-id'),
       (101, 'Salitre', 0x000000000101000000eb3b1ae233f453c0fe96a542e158fdbf, 6, 'ACTIVE', '2020-07-17 03:20:07',
        '2020-07-17 03:20:07', NULL, 'none-id'),
       (102, 'Samborondón', 0x00000000010100000060556243dcf753c08ffe976bd1b200c0, 6, 'ACTIVE', '2020-07-17 03:20:22',
        '2020-07-17 03:20:22', NULL, 'none-id'),
       (103, 'Santa Lucía', 0x000000000101000000015130630aff53c0b16d5166836cfbbf, 6, 'ACTIVE', '2020-07-17 03:21:10',
        '2020-07-17 03:21:10', NULL, 'none-id'),
       (104, 'Simón Bolívar', 0x000000000101000000e18cabdb6a5c53c04ceabaa6f6d89cbf, 6, 'ACTIVE', '2020-07-17 03:21:25',
        '2020-07-17 03:21:25', NULL, 'none-id'),
       (105, 'Yaguachi', 0x0000000001010000007e575fb84eec53c079f475cf70c900c0, 6, 'ACTIVE', '2020-07-17 03:21:52',
        '2020-07-17 03:21:52', NULL, 'none-id'),
       (106, 'Pimampiro', 0x000000000101000000c54d57c1397c53c04e588748f201d93f, 15, 'ACTIVE', '2020-07-17 03:23:07',
        '2020-07-17 03:23:07', NULL, 'none-id'),
       (107, 'Urcuqui', 0x0000000001010000004cb093556c8c53c0a2f14410e7e1da3f, 15, 'ACTIVE', '2020-07-17 03:23:22',
        '2020-07-17 03:23:22', NULL, 'none-id'),
       (108, 'Loja', 0x0000000001010000009ef98b8f85cd53c078be558d140810c0, 16, 'ACTIVE', '2020-07-17 03:25:45',
        '2020-07-17 03:25:45', NULL, 'none-id'),
       (109, 'Calvas', 0x00000000010100000073486aa164e353c0d90a9a96584911c0, 16, 'ACTIVE', '2020-07-17 03:26:01',
        '2020-07-17 03:26:01', NULL, 'none-id'),
       (110, 'Celica', 0x00000000010100000009ac771357fd53c0288293c8996910c0, 16, 'ACTIVE', '2020-07-17 03:27:19',
        '2020-07-17 03:27:19', NULL, 'none-id'),
       (111, 'Catamayo', 0x0000000001010000005c621ba7d7d653c074e151746ee40fc0, 16, 'ACTIVE', '2020-07-17 03:27:42',
        '2020-07-17 03:27:42', NULL, 'none-id'),
       (112, 'Chaguarpamba', 0x00000000010100000085aa3d914ce953c037c2a2224e070fc0, 16, 'ACTIVE', '2020-07-17 03:31:25',
        '2020-07-17 03:31:34', NULL, 'none-id'),
       (113, 'Gonzanamá', 0x000000000101000000729879bcdadb53c006f52d73baec10c0, 16, 'ACTIVE', '2020-07-17 03:32:04',
        '2020-07-17 03:32:04', NULL, 'none-id'),
       (114, 'Macará', 0x0000000001010000008599113958fc53c01c0d3be7028a11c0, 16, 'ACTIVE', '2020-07-17 03:35:34',
        '2020-07-17 03:35:34', NULL, 'none-id'),
       (115, 'Olmedo', 0x000000000101000000d154f42c2d8553c02fe065868db2c13f, 16, 'ACTIVE', '2020-07-17 03:35:51',
        '2020-07-17 03:35:51', NULL, 'none-id'),
       (116, 'Paltas', 0x000000000101000000c4d155babbcb53c0befa78e8bbbb09c0, 16, 'ACTIVE', '2020-07-17 03:36:08',
        '2020-07-17 03:36:08', NULL, 'none-id'),
       (117, 'Quilanga', 0x0000000001010000008731e9efa5d953c021883dfe1c3011c0, 16, 'ACTIVE', '2020-07-17 03:42:21',
        '2020-07-17 03:42:21', NULL, 'none-id'),
       (118, 'Saraguro', 0x000000000101000000b191da7a3ccf53c07ada86f656f90cc0, 16, 'ACTIVE', '2020-07-17 03:42:36',
        '2020-07-17 03:42:36', NULL, 'none-id'),
       (119, 'Zapotillo', 0x00000000010100000074a37ecda80f54c0c563f5fd8a8b11c0, 16, 'ACTIVE', '2020-07-17 03:43:14',
        '2020-07-17 03:43:14', NULL, 'none-id'),
       (120, 'Sozoranga', 0x000000000101000000b9f2a32ba2f253c073f15c84ce5011c0, 16, 'ACTIVE', '2020-07-17 03:43:31',
        '2020-07-17 03:43:31', NULL, 'none-id'),
       (121, 'Pindal', 0x00000000010100000000506ad4e80654c07c2aa73d257710c0, 16, 'ACTIVE', '2020-07-17 03:45:54',
        '2020-07-17 03:45:54', NULL, 'none-id'),
       (122, 'Babahoyo', 0x00000000010100000031dc6fa337e253c058fe7c5bb0d4fcbf, 4, 'ACTIVE', '2020-07-17 03:48:38',
        '2020-07-17 03:48:38', NULL, 'none-id'),
       (123, 'Baba', 0x000000000101000000481adcd696eb53c08e9da685817dfcbf, 4, 'ACTIVE', '2020-07-17 03:48:55',
        '2020-07-17 03:48:55', NULL, 'none-id'),
       (124, 'Buena Fe', 0x0000000001010000008e45894c2fdf53c01bb226bb3e58ecbf, 4, 'ACTIVE', '2020-07-17 03:49:09',
        '2020-07-17 03:49:09', NULL, 'none-id'),
       (125, 'Mocache', 0x000000000101000000b5519d0e64e053c08ac8b08a37f2f2bf, 4, 'ACTIVE', '2020-07-17 03:49:26',
        '2020-07-17 03:49:26', NULL, 'none-id'),
       (126, 'Montalvo', 0x0000000001010000008ba141af64d253c0480845a9739bfcbf, 4, 'ACTIVE', '2020-07-17 03:49:41',
        '2020-07-17 03:49:41', NULL, 'none-id'),
       (127, 'Palenque', 0x000000000101000000207d93a641f053c0186426ace8eaf6bf, 4, 'ACTIVE', '2020-07-17 03:49:57',
        '2020-07-17 03:49:57', NULL, 'none-id'),
       (128, 'Puebloviejo', 0x0000000001010000002a38bc2022e253c0cdccccccccccf8bf, 4, 'ACTIVE', '2020-07-17 03:50:15',
        '2020-07-17 03:50:15', NULL, 'none-id'),
       (129, 'Quevedo', 0x000000000101000000b1dd3d4077dd53c050125cf6355cf0bf, 4, 'ACTIVE', '2020-07-17 03:50:27',
        '2020-07-17 03:50:27', NULL, 'none-id'),
       (130, 'Quinsaloma', 0x0000000001010000007965cd7e13d453c093a7aca6eb49f3bf, 4, 'ACTIVE', '2020-07-17 03:50:43',
        '2020-07-17 03:50:43', NULL, 'none-id'),
       (131, 'Urdaneta', 0x000000000101000000de3994a12acd53c0bb287ae063d00cc0, 4, 'ACTIVE', '2020-07-17 03:50:57',
        '2020-07-17 03:50:57', NULL, 'none-id'),
       (132, 'Valencia', 0x0000000001010000004da9013997d653c0a6d7c11c9877eebf, 4, 'ACTIVE', '2020-07-17 03:51:11',
        '2020-07-17 03:51:11', NULL, 'none-id'),
       (133, 'Ventanas', 0x000000000101000000ced9a78878dd53c0434e0416651bf7bf, 4, 'ACTIVE', '2020-07-17 03:51:19',
        '2020-07-17 03:51:19', NULL, 'none-id'),
       (134, 'Vínces', 0x0000000001010000000fd99b73cbf053c0d33252efa9dcf8bf, 4, 'ACTIVE', '2020-07-17 03:51:39',
        '2020-07-17 03:51:51', NULL, 'none-id'),
       (135, 'Portoviejo', 0x0000000001010000007610e099f51c54c0946c753925e0f0bf, 3, 'ACTIVE', '2020-07-17 03:52:23',
        '2020-07-17 03:52:23', NULL, 'none-id'),
       (136, '24 de Mayo', 0x000000000101000000731e04d39fe053c02a5ec026c66df0bf, 3, 'ACTIVE', '2020-07-17 03:52:41',
        '2020-07-17 03:52:53', NULL, 'none-id'),
       (137, 'Chone', 0x000000000101000000ada580b4ff0654c0a5b448241bd9e6bf, 3, 'ACTIVE', '2020-07-17 03:53:22',
        '2020-07-17 03:53:22', NULL, 'none-id'),
       (138, 'El Carmen', 0x000000000101000000637891aebedd53c03ed57cf0355fd1bf, 3, 'ACTIVE', '2020-07-17 03:53:56',
        '2020-07-17 03:53:56', NULL, 'none-id'),
       (139, 'Flavio Alfaro', 0x000000000101000000ff918e17f7f953c0ba241818c3e6d9bf, 3, 'ACTIVE', '2020-07-17 03:55:08',
        '2020-07-17 03:55:19', NULL, 'none-id'),
       (140, 'Jama', 0x0000000001010000000c0f50d0dc1054c01e4e603aaddbc9bf, 3, 'ACTIVE', '2020-07-17 03:55:33',
        '2020-07-17 03:55:33', NULL, 'none-id'),
       (141, 'Jaramijó', 0x00000000010100000077ab9d17dd2854c0d2f654f3c197eebf, 3, 'ACTIVE', '2020-07-17 03:55:53',
        '2020-07-17 03:56:03', NULL, 'none-id'),
       (142, 'Jipijapa', 0x000000000101000000569f06674b2554c01f20a9cf1fa4f5bf, 3, 'ACTIVE', '2020-07-17 03:56:20',
        '2020-07-17 03:56:20', NULL, 'none-id'),
       (143, 'Junín', 0x000000000101000000c14c8006400d54c01a8e42ed12b0edbf, 3, 'ACTIVE', '2020-07-17 03:56:34',
        '2020-07-17 03:56:43', NULL, 'none-id'),
       (144, 'Manta', 0x00000000010100000076d377c85e2d54c02ebaab0d04f7eebf, 3, 'ACTIVE', '2020-07-17 03:56:56',
        '2020-07-17 03:56:56', NULL, 'none-id'),
       (145, 'Montecristi', 0x000000000101000000affdae192a2a54c0bc1fb75f3eb9f0bf, 3, 'ACTIVE', '2020-07-17 03:58:50',
        '2020-07-17 03:59:01', NULL, 'none-id'),
       (146, 'Paján', 0x000000000101000000daff006b551b54c061a417b5fbd5f8bf, 3, 'ACTIVE', '2020-07-17 03:59:46',
        '2020-07-17 04:00:14', NULL, 'none-id'),
       (147, 'Pedernales', 0x000000000101000000fecf06054a0354c06be33e28deb7b23f, 3, 'ACTIVE', '2020-07-17 04:01:01',
        '2020-07-17 04:01:01', NULL, 'none-id'),
       (148, 'Pichincha', 0x000000000101000000b7dc4f7cebf453c0012f336c94b5f0bf, 3, 'ACTIVE', '2020-07-17 06:07:21',
        '2020-07-17 06:07:45', NULL, 'none-id'),
       (149, 'Puerto López', 0x00000000010100000090f1cddb7d3354c0a738b302e8dcf8bf, 3, 'ACTIVE', '2020-07-17 06:08:31',
        '2020-07-17 06:08:44', NULL, 'none-id'),
       (150, 'Rocafuerte', 0x000000000101000000605b9ab6da1c54c0f9b605f0bb8eedbf, 3, 'ACTIVE', '2020-07-17 06:09:13',
        '2020-07-17 06:09:13', NULL, 'none-id'),
       (151, 'San Vicente', 0x00000000010100000005db8827bb1954c046ae4099eb59e3bf, 3, 'ACTIVE', '2020-07-17 06:09:50',
        '2020-07-17 06:09:50', NULL, 'none-id'),
       (152, 'Santa Ana', 0x0000000001010000006bed22f1971754c0acadd85f764ff3bf, 3, 'ACTIVE', '2020-07-17 06:10:21',
        '2020-07-17 06:10:21', NULL, 'none-id'),
       (153, 'Sucre', 0x00000000010100000012691b7fa29f53c0d34d62105839f4bf, 3, 'ACTIVE', '2020-07-17 06:10:38',
        '2020-07-17 06:10:38', NULL, 'none-id'),
       (154, 'Tosagua', 0x000000000101000000c55d1844ff0e54c081f91a385618e9bf, 3, 'ACTIVE', '2020-07-17 06:10:51',
        '2020-07-17 06:10:51', NULL, 'none-id'),
       (155, 'Morona', 0x0000000001010000000a9e42ae54c053c022437d810f34fbbf, 19, 'ACTIVE', '2020-07-17 06:11:25',
        '2020-07-17 06:12:29', NULL, 'none-id'),
       (156, 'Gualaquiza', 0x000000000101000000d0e341c497a453c0ce0b660234400bc0, 19, 'ACTIVE', '2020-07-17 07:24:31',
        '2020-07-17 07:24:31', NULL, 'none-id'),
       (157, 'Huamboya', 0x000000000101000000cf6bec12557f53c0687748314022ffbf, 19, 'ACTIVE', '2020-07-17 07:24:49',
        '2020-07-17 07:24:49', NULL, 'none-id'),
       (158, 'Indanza', 0x00000000010100000041a264cd239f53c0d50792770e8508c0, 19, 'ACTIVE', '2020-07-17 07:25:59',
        '2020-07-17 07:25:59', NULL, 'none-id'),
       (159, 'Logroño', 0x0000000001010000003f8b4a8f4b8d53c0e0ee512404f004c0, 19, 'ACTIVE', '2020-07-17 07:26:16',
        '2020-07-17 07:26:16', NULL, 'none-id'),
       (160, 'Pablo Sexto', 0x000000000101000000c740e8ead88f53c0d457a192844efdbf, 19, 'ACTIVE', '2020-07-17 07:26:37',
        '2020-07-17 07:26:37', NULL, 'none-id'),
       (161, 'Palora', 0x000000000101000000a05edf3df67d53c00b1fb699af37fbbf, 19, 'ACTIVE', '2020-07-17 07:26:55',
        '2020-07-17 07:26:55', NULL, 'none-id'),
       (162, 'San Juan Bosco', 0x000000000101000000aef204c24ea153c02db0c7444ad308c0, 19, 'ACTIVE',
        '2020-07-17 07:27:30', '2020-07-17 07:27:30', NULL, 'none-id'),
       (163, 'Santiago de Mendez', 0x00000000010100000027f6d03e569453c01764cbf275b905c0, 19, 'ACTIVE',
        '2020-07-17 07:27:57', '2020-07-17 07:27:57', NULL, 'none-id'),
       (164, 'Sucúa', 0x000000000101000000515557f4bd8a53c04e5fcfd72ca703c0, 19, 'ACTIVE', '2020-07-17 07:28:41',
        '2020-07-17 07:28:41', NULL, 'none-id'),
       (165, 'Taisha', 0x0000000001010000008599b67f655d53c018946934b9b802c0, 19, 'ACTIVE', '2020-07-17 07:29:01',
        '2020-07-17 07:29:01', NULL, 'none-id'),
       (166, 'tiwintza', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 19, 'ACTIVE', '2020-07-17 07:29:26',
        '2020-07-17 07:29:26', NULL, 'none-id'),
       (167, 'Tena', 0x000000000101000000501a6a14127453c0791563aaaae1efbf, 20, 'ACTIVE', '2020-07-17 07:32:31',
        '2020-07-17 07:32:31', NULL, 'none-id'),
       (168, 'Archidona', 0x00000000010100000078cd5081b87353c037024c74f112edbf, 20, 'ACTIVE', '2020-07-17 07:32:56',
        '2020-07-17 07:32:56', NULL, 'none-id'),
       (169, 'Carlos Julio Arosemena Tola', 0x000000000101000000935e8a61bd7653c0ea002d0208a4f2bf, 20, 'ACTIVE',
        '2020-07-17 07:33:18', '2020-07-17 07:33:18', NULL, 'none-id'),
       (170, 'El Chaco', 0x000000000101000000d1dc54eecf7353c04eb0a481c49bd5bf, 20, 'ACTIVE', '2020-07-17 07:33:39',
        '2020-07-17 07:33:39', NULL, 'none-id'),
       (171, 'Francisco de Orellana', 0x000000000101000000991a57128f3f53c0d6f95c120c8cddbf, 21, 'ACTIVE',
        '2020-07-17 07:34:44', '2020-07-17 07:34:44', NULL, 'none-id'),
       (172, 'Aguarico', 0x0000000001010000007061dd7877f752c0132a38bc2022d2bf, 21, 'ACTIVE', '2020-07-17 07:35:00',
        '2020-07-17 07:35:00', NULL, 'none-id'),
       (173, 'La Joya de los Sachas', 0x00000000010100000084ec61d4da3653c0af33cf5b8649d3bf, 21, 'ACTIVE',
        '2020-07-17 07:35:23', '2020-07-17 07:35:23', NULL, 'none-id'),
       (174, 'Loreto', 0x000000000101000000891e42a6c65353c07d9b59a6ba1be6bf, 21, 'ACTIVE', '2020-07-17 07:35:41',
        '2020-07-17 07:35:41', NULL, 'none-id'),
       (175, 'Arajuno', 0x000000000101000000348639419b6b53c0726bd26d89dcf3bf, 22, 'ACTIVE', '2020-07-17 07:36:40',
        '2020-07-17 07:36:40', NULL, 'none-id'),
       (176, 'Mera', 0x0000000001010000008e42ed12308753c0fd2a65be2866f7bf, 22, 'ACTIVE', '2020-07-17 07:37:01',
        '2020-07-17 07:37:01', NULL, 'none-id'),
       (177, 'Santa Clara', 0x000000000101000000f7764b72c07853c068d608b3bf42f4bf, 22, 'ACTIVE', '2020-07-17 07:37:21',
        '2020-07-17 07:37:21', NULL, 'none-id'),
       (178, 'Quito', 0x0000000001010000007334a20ff19d53c0be78f5e0a41fc7bf, 17, 'ACTIVE', '2020-07-17 07:38:29',
        '2020-07-17 07:38:29', NULL, 'none-id'),
       (179, 'Cayambe', 0x00000000010100000027c8be1a568953c0d93add1e29c7a53f, 17, 'ACTIVE', '2020-07-17 07:40:12',
        '2020-07-17 07:40:12', NULL, 'none-id'),
       (180, 'Mejia', 0x0000000001010000009b2ca4b2171e54c08768194e3ea2efbf, 17, 'ACTIVE', '2020-07-17 07:40:29',
        '2020-07-17 07:40:29', NULL, 'none-id'),
       (181, 'Pedro Vicente Maldonado', 0x0000000001010000003082c64c22c353c0f59f353ffed2b43f, 17, 'ACTIVE',
        '2020-07-17 07:40:53', '2020-07-17 07:40:53', NULL, 'none-id'),
       (182, 'Puerto Quito', 0x00000000010100000009fb761211d153c01bbe8575e3ddbd3f, 17, 'ACTIVE', '2020-07-17 07:41:18',
        '2020-07-17 07:41:18', NULL, 'none-id'),
       (183, 'San Miguel de Los Bancos', 0x0000000001010000001e25654117b953c00facf424fac6993f, 17, 'ACTIVE',
        '2020-07-17 07:42:07', '2020-07-17 07:42:07', NULL, 'none-id'),
       (184, 'Santa Elena', 0x0000000001010000001e8cd827003754c0134abac1abd001c0, 5, 'ACTIVE', '2020-07-17 07:43:30',
        '2020-07-17 07:43:30', NULL, 'none-id'),
       (185, 'La Libertad', 0x000000000101000000aab3ffa69c3954c0de0951195ad801c0, 5, 'ACTIVE', '2020-07-17 07:43:53',
        '2020-07-17 07:43:53', NULL, 'none-id'),
       (186, 'Salinas', 0x0000000001010000005c1d0071573d54c05a03a5b272c901c0, 5, 'ACTIVE', '2020-07-17 07:44:13',
        '2020-07-17 07:44:13', NULL, 'none-id'),
       (187, 'La Concordia', 0x000000000101000000cefc6a0e10d953c0682f91c140c6823f, 7, 'ACTIVE', '2020-07-17 07:44:47',
        '2020-07-17 07:44:47', NULL, 'none-id'),
       (188, 'Santo Domingo', 0x000000000101000000f8718f0049cb53c014bcd7ffef3ed0bf, 7, 'ACTIVE', '2020-07-17 07:45:08',
        '2020-07-17 07:45:08', NULL, 'none-id'),
       (189, 'Cuyabeno', 0x0000000001010000006b44d554bbe752c03a2e9919ec3cd7bf, 23, 'ACTIVE', '2020-07-17 07:48:24',
        '2020-07-17 07:48:24', NULL, 'none-id'),
       (190, 'Gonzalo Pizarro', 0x000000000101000000b0e42a16bf5653c01eb0613c39f9abbf, 23, 'ACTIVE',
        '2020-07-17 07:48:46', '2020-07-17 07:48:46', NULL, 'none-id'),
       (191, 'Putumayo', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 07:49:19',
        '2020-07-17 07:49:19', NULL, 'none-id'),
       (192, 'Shushufindi', 0x000000000101000000c97cf612192953c037b75384e519c8bf, 23, 'ACTIVE', '2020-07-17 07:49:39',
        '2020-07-17 07:49:39', NULL, 'none-id'),
       (193, 'Sucumbios', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 07:50:07',
        '2020-07-17 07:50:07', NULL, 'none-id'),
       (194, 'Cascales', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 07:50:24',
        '2020-07-17 07:50:24', NULL, 'none-id'),
       (195, 'Lago Agrio', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 23, 'ACTIVE', '2020-07-17 07:50:45',
        '2020-07-17 07:50:45', NULL, 'none-id'),
       (196, 'Rumiñahui', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 17, 'ACTIVE', '2020-07-17 07:51:17',
        '2020-07-27 06:54:24', NULL, 'none-id'),
       (197, 'Ambato', 0x0000000001010000003c93ecc7dca753c09a9da0a8c711f4bf, 18, 'ACTIVE', '2020-07-17 07:52:01',
        '2020-07-17 07:52:01', NULL, 'none-id'),
       (198, 'Baños', 0x0000000001010000000c1de0ee519b53c088e64bb90c49f6bf, 18, 'ACTIVE', '2020-07-17 07:52:20',
        '2020-07-17 07:52:20', NULL, 'none-id'),
       (199, 'Cevallos', 0x0000000001010000002a73f38d68a753c06379fc83edacf5bf, 18, 'ACTIVE', '2020-07-17 07:52:36',
        '2020-07-17 07:52:36', NULL, 'none-id'),
       (200, 'Mocha', 0x000000000101000000482355ca21aa53c047cf882d98b3f6bf, 18, 'ACTIVE', '2020-07-17 07:52:51',
        '2020-07-17 07:52:51', NULL, 'none-id'),
       (201, 'Patate', 0x00000000010100000071a9efa169a053c0fe65f7e46101f5bf, 18, 'ACTIVE', '2020-07-17 07:53:07',
        '2020-07-17 07:53:07', NULL, 'none-id'),
       (202, 'Quero', 0x000000000101000000fa2d9512dda653c0d091a68b5e17f6bf, 18, 'ACTIVE', '2020-07-17 07:53:23',
        '2020-07-17 07:53:23', NULL, 'none-id'),
       (203, 'Pelileo', 0x000000000101000000d4e29d8da6a253c0017f42870a3ff5bf, 18, 'ACTIVE', '2020-07-17 07:53:48',
        '2020-07-17 07:53:48', NULL, 'none-id'),
       (204, 'Píllaro', 0x000000000101000000f2666897caa253c00a4b3ca06ccaf2bf, 18, 'ACTIVE', '2020-07-17 07:54:08',
        '2020-07-17 07:54:08', NULL, 'none-id'),
       (205, 'Tisaleo', 0x00000000010100000024e18cabdbaa53c0ee2c301ae890f5bf, 18, 'ACTIVE', '2020-07-17 07:54:25',
        '2020-07-17 07:54:25', NULL, 'none-id'),
       (206, 'Zamora', 0x000000000101000000f04e3e3db6bc53c025198398953f10c0, 24, 'ACTIVE', '2020-07-17 07:55:37',
        '2020-07-17 07:55:37', NULL, 'none-id'),
       (207, 'Centinela', 0x000000000101000000f70489edeefe52c00492b06f2711913f, 24, 'ACTIVE', '2020-07-17 07:56:19',
        '2020-07-17 07:56:19', NULL, 'none-id'),
       (208, 'Nangaritza', 0x00000000010100000006781c5080a553c0fffe3971de040dc0, 24, 'ACTIVE', '2020-07-17 07:57:12',
        '2020-07-17 07:57:12', NULL, 'none-id'),
       (209, 'Chinchipe', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 07:57:30',
        '2020-07-17 07:57:30', NULL, 'none-id'),
       (210, 'Palanda', 0x0000000001010000006a50340f60c853c02accd655dc9b12c0, 24, 'ACTIVE', '2020-07-17 07:57:52',
        '2020-07-17 07:57:52', NULL, 'none-id'),
       (211, 'Paquisha', 0x0000000001010000001fe10f9a38ab53c0399105f126740fc0, 24, 'ACTIVE', '2020-07-17 07:58:17',
        '2020-07-17 07:58:17', NULL, 'none-id'),
       (212, 'Yacuambi', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 07:58:43',
        '2020-07-17 07:58:43', NULL, 'none-id'),
       (213, 'Yantzaza', 0x000000000101000000567ce827c1b053c0206dd223fca10ec0, 24, 'ACTIVE', '2020-07-17 07:59:02',
        '2020-07-17 07:59:02', NULL, 'none-id'),
       (214, 'Pangui', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 24, 'ACTIVE', '2020-07-17 07:59:49',
        '2020-07-17 07:59:49', NULL, 'none-id'),
       (215, 'Sin registro', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 25, 'ACTIVE', '2020-07-27 06:32:30',
        '2020-07-27 06:32:30', NULL, 'none-id'),
       (216, 'SR', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 26, 'INACTIVE', '2020-07-27 06:33:26',
        '2020-07-27 06:33:40', NULL, 'none-id'),
       (217, 'SR1', 0x00000000010100000014090154cc9e53c07af643098635c5bf, 27, 'INACTIVE', '2020-07-27 06:34:04',
        '2020-07-27 06:34:24', NULL, 'none-id'),
       (218, 'San Antonio', 0x000000000101000000573de456168b53c0bec21fd14626d53f, 15, 'ACTIVE', '2024-02-29 12:44:09',
        '2024-02-29 12:55:12', NULL, 'none-id');

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

--
-- Dumping data for table `clinical_exam`
--

INSERT INTO `clinical_exam` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 'Examen Visual y Evaluación de la Cavidad Oral', '', 'ACTIVE', '2024-02-29 14:18:58', '2024-02-29 14:18:58',
        NULL),
       (2, 'Radiografías Dentales', '', 'ACTIVE', '2024-02-29 14:19:06', '2024-02-29 14:19:06', NULL),
       (3, 'Exploración de la Articulación Temporomandibular (ATM)', '', 'ACTIVE', '2024-02-29 14:19:15',
        '2024-02-29 14:19:15', NULL),
       (4, 'Pruebas de Vitalidad Dental', '', 'ACTIVE', '2024-02-29 14:19:23', '2024-02-29 14:19:23', NULL),
       (5, 'Exploración Periodontal', '', 'ACTIVE', '2024-02-29 14:19:29', '2024-02-29 14:19:29', NULL),
       (6, 'Examen Oclusal', '', 'ACTIVE', '2024-02-29 14:19:35', '2024-02-29 14:19:35', NULL),
       (7, 'Examen de la Mucosa Oral', '', 'ACTIVE', '2024-02-29 14:19:41', '2024-02-29 14:19:41', NULL),
       (8, 'Análisis de la Saliva', '', 'ACTIVE', '2024-02-29 14:19:49', '2024-02-29 14:19:49', NULL);

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

--
-- Dumping data for table `counter_by_entity`
--

INSERT INTO `counter_by_entity` (`id`, `business_by_counter_id`, `created_at`, `updated_at`, `deleted_at`, `is_guess`,
                                 `user_id`, `token`, `manager_click_type`, `manager_click_id`, `action_name`)
VALUES (1, 1, '2024-10-27 10:08:43', '2024-10-27 10:08:43', NULL, 1, 0, 'kVKR9LKtxamZrO9r0A0CAfzTaDf2LGMpSVz8esHS',
        'NONE', 'NONE', 'shopPage'),
       (2, 2, '2024-10-27 10:13:02', '2024-10-27 10:13:02', NULL, 0, 1, 'Uz8pbHRGPUMBfdckW85OQT9zxR9ZM1zwjDas2bSo',
        'NONE', 'NONE', 'homeEatPura'),
       (3, 3, '2024-10-27 10:13:12', '2024-10-27 10:13:12', NULL, 0, 1, 'Uz8pbHRGPUMBfdckW85OQT9zxR9ZM1zwjDas2bSo',
        'NONE', 'NONE', ''),
       (4, 4, '2024-10-27 10:13:23', '2024-10-27 10:13:23', NULL, 0, 1, 'Uz8pbHRGPUMBfdckW85OQT9zxR9ZM1zwjDas2bSo',
        'NONE', 'NONE', 'business'),
       (5, 5, '2024-10-27 10:17:16', '2024-10-27 10:17:16', NULL, 0, 1, 'Uz8pbHRGPUMBfdckW85OQT9zxR9ZM1zwjDas2bSo',
        'NONE', 'NONE', 'myProfile'),
       (6, 1, '2024-10-27 10:39:17', '2024-10-27 10:39:17', NULL, 0, 1, 'Uz8pbHRGPUMBfdckW85OQT9zxR9ZM1zwjDas2bSo',
        'NONE', 'NONE', 'shopPage'),
       (7, 3, '2024-10-27 19:26:54', '2024-10-27 19:26:54', NULL, 1, 0, 'SCvCdOarknnzzYfM813FpO8xsRoxMYSdnHlmu8Kl',
        'NONE', 'NONE', ''),
       (8, 3, '2024-10-27 21:05:56', '2024-10-27 21:05:56', NULL, 1, 0, 'qWEUFMrJYxHWOslOKq2GmKMIlxL92E9ThkoUHNUf',
        'NONE', 'NONE', ''),
       (9, 6, '2024-10-27 21:07:34', '2024-10-27 21:07:34', NULL, 0, 1, 'Ih36gfmyS4jhQ5f9BcDK4TLrMf1GYJpk6yvKOmdp',
        'NONE', 'NONE', 'userAccount'),
       (10, 2, '2024-10-27 21:07:42', '2024-10-27 21:07:42', NULL, 1, 0, 'Ih36gfmyS4jhQ5f9BcDK4TLrMf1GYJpk6yvKOmdp',
        'NONE', 'NONE', 'homeEatPura'),
       (11, 1, '2024-10-27 21:08:05', '2024-10-27 21:08:05', NULL, 1, 0, 'Ih36gfmyS4jhQ5f9BcDK4TLrMf1GYJpk6yvKOmdp',
        'NONE', 'NONE', 'shopPage'),
       (12, 2, '2024-10-27 21:38:24', '2024-10-27 21:38:24', NULL, 1, 0, 'BOyb7QEIEQFME08XGAfWvNK5wzeuSb2CnTXBRhj1',
        'NONE', 'NONE', 'homeEatPura'),
       (13, 2, '2024-10-27 21:38:28', '2024-10-27 21:38:28', NULL, 1, 0, 'yI1rrcAuGc9Pu3k3uY8b7f0PTqg3JtPsW57J1rCa',
        'NONE', 'NONE', 'homeEatPura'),
       (14, 2, '2024-10-27 21:38:29', '2024-10-27 21:38:29', NULL, 1, 0, 'B9kxFiSV4ZO8mWv5gNsYAiU6j6mcT3jD1uJsdtpW',
        'NONE', 'NONE', 'homeEatPura'),
       (15, 2, '2024-10-27 21:38:29', '2024-10-27 21:38:29', NULL, 1, 0, 'tG4bEZcRHJD7lMJ2mRW3QuwbbSBgTzA89CpvEsTn',
        'NONE', 'NONE', 'homeEatPura'),
       (16, 1, '2024-10-27 21:38:33', '2024-10-27 21:38:33', NULL, 1, 0, 'BOyb7QEIEQFME08XGAfWvNK5wzeuSb2CnTXBRhj1',
        'NONE', 'NONE', 'shopPage'),
       (17, 1, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 'ueFODAO6mviAJWhFr1xfU1rvmOVgrajbdz9LtOk9',
        'NONE', 'NONE', 'shopPage'),
       (18, 1, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 'N40f8yvCAwmY1LNcbmS0AaBDAfNFegA3niWL3XMh',
        'NONE', 'NONE', 'shopPage'),
       (19, 1, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 'XF0IsKkfE0dimJvjCN9lmokNwrLdOZAAvcsCbVdZ',
        'NONE', 'NONE', 'shopPage'),
       (20, 3, '2024-10-27 23:53:22', '2024-10-27 23:53:22', NULL, 1, 0, 'DC2KTTKuD9LFqIWGZQKocm69diRCIRUwF6dpouly',
        'NONE', 'NONE', '');

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

--
-- Dumping data for table `counter_by_log_user_to_business`
--

INSERT INTO `counter_by_log_user_to_business` (`id`, `created_at`, `updated_at`, `deleted_at`, `business_id`, `user_id`,
                                               `is_guess`, `manager_click_type`, `manager_click_id`, `action_name`)
VALUES (1, '2024-10-27 10:08:43', '2024-10-27 10:08:43', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (2, '2024-10-27 10:08:44', '2024-10-27 10:08:44', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (3, '2024-10-27 10:13:02', '2024-10-27 10:13:02', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (4, '2024-10-27 10:13:12', '2024-10-27 10:13:12', NULL, 1, 1, 0, 'NONE', 'NONE', ''),
       (5, '2024-10-27 10:13:23', '2024-10-27 10:13:23', NULL, 1, 1, 0, 'NONE', 'NONE', 'business'),
       (6, '2024-10-27 10:17:16', '2024-10-27 10:17:16', NULL, 1, 1, 0, 'NONE', 'NONE', 'myProfile'),
       (7, '2024-10-27 10:20:04', '2024-10-27 10:20:04', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (8, '2024-10-27 10:20:09', '2024-10-27 10:20:09', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (9, '2024-10-27 10:21:10', '2024-10-27 10:21:10', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (10, '2024-10-27 10:39:17', '2024-10-27 10:39:17', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (11, '2024-10-27 10:39:18', '2024-10-27 10:39:18', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (12, '2024-10-27 10:39:24', '2024-10-27 10:39:24', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (13, '2024-10-27 10:39:25', '2024-10-27 10:39:25', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (14, '2024-10-27 10:39:40', '2024-10-27 10:39:40', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (15, '2024-10-27 10:39:40', '2024-10-27 10:39:40', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (16, '2024-10-27 19:26:54', '2024-10-27 19:26:54', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
       (17, '2024-10-27 21:05:56', '2024-10-27 21:05:56', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
       (18, '2024-10-27 21:06:05', '2024-10-27 21:06:05', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
       (19, '2024-10-27 21:06:28', '2024-10-27 21:06:28', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (20, '2024-10-27 21:06:40', '2024-10-27 21:06:40', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (21, '2024-10-27 21:06:40', '2024-10-27 21:06:40', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (22, '2024-10-27 21:06:54', '2024-10-27 21:06:54', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (23, '2024-10-27 21:07:02', '2024-10-27 21:07:02', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (24, '2024-10-27 21:07:02', '2024-10-27 21:07:02', NULL, 1, 1, 0, 'NONE', 'NONE', 'shopPage'),
       (25, '2024-10-27 21:07:19', '2024-10-27 21:07:19', NULL, 1, 1, 0, 'NONE', 'NONE', 'homeEatPura'),
       (26, '2024-10-27 21:07:34', '2024-10-27 21:07:34', NULL, 1, 1, 0, 'NONE', 'NONE', 'userAccount'),
       (27, '2024-10-27 21:07:37', '2024-10-27 21:07:37', NULL, 1, 1, 0, 'NONE', 'NONE', 'userAccount'),
       (28, '2024-10-27 21:07:42', '2024-10-27 21:07:42', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (29, '2024-10-27 21:07:54', '2024-10-27 21:07:54', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (30, '2024-10-27 21:08:05', '2024-10-27 21:08:05', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (31, '2024-10-27 21:08:05', '2024-10-27 21:08:05', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (32, '2024-10-27 21:38:24', '2024-10-27 21:38:24', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (33, '2024-10-27 21:38:28', '2024-10-27 21:38:28', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (34, '2024-10-27 21:38:29', '2024-10-27 21:38:29', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (35, '2024-10-27 21:38:29', '2024-10-27 21:38:29', NULL, 1, 0, 1, 'NONE', 'NONE', 'homeEatPura'),
       (36, '2024-10-27 21:38:33', '2024-10-27 21:38:33', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (37, '2024-10-27 21:38:33', '2024-10-27 21:38:33', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (38, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (39, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (40, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (41, '2024-10-27 21:38:37', '2024-10-27 21:38:37', NULL, 1, 0, 1, 'NONE', 'NONE', 'shopPage'),
       (42, '2024-10-27 23:53:22', '2024-10-27 23:53:22', NULL, 1, 0, 1, 'NONE', 'NONE', '');

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

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`, `iso_codes`,
                         `phone_code`)
VALUES (1, 'Afghanistan', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'AF / AFG', '93'),
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
       (30, 'British Indian Ocean Territory', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'IO / IOT',
        '246'),
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
       (51, 'Democratic Republic of the Congo', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'CD / COD',
        '243'),
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
       (203, 'Saint Vincent and the Grenadines', 'ACTIVE', NULL, NULL, NULL, 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'VC / VCT',
        '1'),
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

--
-- Dumping data for table `dental_piece`
--

INSERT INTO `dental_piece` (`id`, `name`, `piece`, `dentition`)
VALUES (1, 'Tercer Molar Superior', '18', 'Perm-FDI'),
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
       (14, 'Canino Inferior.', '43', 'Perm-FDI'),
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

--
-- Dumping data for table `entity_plans`
--

INSERT INTO `entity_plans` (`id`, `name`, `description`, `state`)
VALUES (1, 'PLAN_PRO', NULL, 'ACTIVE'),
       (2, 'PLAN_LINE', NULL, 'ACTIVE'),
       (3, 'PLAN_SIMPLE', NULL, 'ACTIVE'),
       (4, 'PLAN_BASIC', NULL, 'ACTIVE');

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

--
-- Dumping data for table `entity_position_fiscal`
--

INSERT INTO `entity_position_fiscal` (`id`, `value`, `state`, `description`)
VALUES (1, 'Posicion Fiscal 1', 'ACTIVE', NULL);

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

--
-- Dumping data for table `gamification`
--

INSERT INTO `gamification` (`id`, `value`, `description`, `value_unit`, `state`, `maximum_exchange`)
VALUES (1, 'Configuracion Inicial Gamificacion', 'Configuracion', 0, 'ACTIVE', 0);

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
    unique_code                     VARCHAR(50)  NOT NULL UNIQUE
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

--
-- Dumping data for table `gamification_type_activity`
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

--
-- Dumping data for table `habits`
--

INSERT INTO `habits` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`)
VALUES (1, 'Fumar', NULL, NULL, NULL, NULL, 'ACTIVE'),
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

--
-- Dumping data for table `human_resources_department`
--

INSERT INTO `human_resources_department` (`id`, `name`, `description`, `status`, `business_id`, `color`)
VALUES (1, 'Sistemas', '', 'ACTIVE', 1, '#DEC63D'),
       (2, 'Marketing', '', 'ACTIVE', 1, '#DEC63D'),
       (3, 'Diseño', '', 'ACTIVE', 1, '#DEC63D'),
       (4, 'Ventas', '', 'ACTIVE', 1, '#DEC63D');

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

--
-- Dumping data for table `human_resources_department_by_organizational_chart_area`
--

INSERT INTO `human_resources_department_by_organizational_chart_area` (`id`, `human_resources_department_id`,
                                                                       `human_resources_organizational_chart_area_id`)
VALUES (1, 5, 3),
       (2, 1, 3),
       (3, 4, 4),
       (4, 2, 4),
       (5, 6, 5);

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

--
-- Dumping data for table `human_resources_organizational_chart_area`
--

INSERT INTO `human_resources_organizational_chart_area` (`id`, `parent_id`, `weight`, `icon`, `type`, `description`,
                                                         `type_item`, `status`, `name`, `business_id`)
VALUES (1, NULL, 1, 'fa fa-developer', 2, 'Asamblea de Socios', 1, 'ACTIVE', 'Asamblea de Socios', 1),
       (2, 1, 1, 'fa fa-developer', 0, 'GERENTE GENERAL', 1, 'ACTIVE', 'GERENTE GENERAL', 1),
       (3, 2, 1, 'fa fa-developer', 0, 'ADMINISTRATIVO', 1, 'ACTIVE', 'ADMINISTRATIVO', 1),
       (4, 2, 2, 'fa fa-developer', 0, 'COMERCIAL', 1, 'ACTIVE', 'COMERCIAL', 1),
       (5, 2, 3, 'fa fa-developer', 0, 'OPERACIONES', 1, 'ACTIVE', 'OPERACIONES', 1);

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

--
-- Dumping data for table `human_resources_schedule_type`
--

INSERT INTO `human_resources_schedule_type` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`,
                                             `deleted_at`, `status`, `predetermined`, `rotary`, `business_id`)
VALUES (1, 'HORARIO OPERATIVO', '001', 'HORARIO OPERATIVO', '2023-06-14 00:05:17', NULL, NULL, 'ACTIVE', 0, 0, 1);

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

--
-- Dumping data for table `information_address_type`
--

INSERT INTO `information_address_type` (`id`, `value`, `description`, `state`)
VALUES (1, 'Domicilio', 'Domicilio', 'ACTIVE'),
       (2, 'Trabajo', 'Trabajo', 'ACTIVE'),
       (3, 'Sin Especificación', 'Sin Especificación', 'ACTIVE');

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

--
-- Dumping data for table `information_mail`
--

INSERT INTO `information_mail` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_mail_type_id`)
VALUES (1, 'inkacorreo@gmail.com', 'ACTIVE', 3, 1, 1, 1);

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

--
-- Dumping data for table `information_mail_type`
--

INSERT INTO `information_mail_type` (`id`, `value`, `description`, `state`)
VALUES (1, 'Coorporativo', 'Coorporativo', 'ACTIVE'),
       (2, 'Personal', 'Personal', 'ACTIVE'),
       (3, 'Sin Especificación', 'Sin Especificación', 'ACTIVE');

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

--
-- Dumping data for table `information_phone_operator`
--

INSERT INTO `information_phone_operator` (`id`, `value`, `description`, `state`)
VALUES (1, 'SIN DEFINIR', NULL, 'ACTIVE'),
       (2, 'MOVISTAR', 'adad', 'ACTIVE'),
       (3, 'ALEGRO', 'adad', 'ACTIVE'),
       (4, 'CLARO', NULL, 'ACTIVE');

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

--
-- Dumping data for table `information_phone_type`
--

INSERT INTO `information_phone_type` (`id`, `value`, `description`, `state`)
VALUES (1, 'SIN DEFINIR', 'sfdd ADAD', 'ACTIVE'),
       (2, 'TRABAJO', NULL, 'ACTIVE'),
       (3, 'CASA', 'adad', 'ACTIVE'),
       (4, 'Personal', NULL, 'ACTIVE');

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

--
-- Dumping data for table `information_social_network`
--

INSERT INTO `information_social_network` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`,
                                          `information_social_network_type_id`)
VALUES (1, 'http://flowers.com/', 'ACTIVE', 2, 1, 4, 1);

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

--
-- Dumping data for table `information_social_network_type`
--

INSERT INTO `information_social_network_type` (`id`, `value`, `description`, `state`, `icon`)
VALUES (1, 'Facebook', 'adadad', 'ACTIVE', 'fa fa-facebook'),
       (2, 'Instagram', 'adadad', 'ACTIVE', 'fa fa-instagram'),
       (3, 'Twitter', 'adadad', 'ACTIVE', 'fa fa-twitter'),
       (4, 'LinkedIn', 'adadad', 'ACTIVE', 'fa fa-linkedin'),
       (5, 'Youtube', 'adadad', 'ACTIVE', 'fa fa-youtube-play'),
       (6, 'Whatsapp', 'adadad', 'ACTIVE', 'fa fa-youtube-play'),
       (7, 'TikTok', 'TikTok', 'ACTIVE', 'fa fa-youtube-play');

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

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `value`, `initials`, `state`, `description`)
VALUES (1, 'Ingles', 'en', 'ACTIVE', 'Ingles'),
       (2, 'Kichwa', 'ki', 'ACTIVE', NULL),
       (3, 'Español', 'es', 'ACTIVE', NULL);

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

--
-- Dumping data for table `language_course`
--

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

--
-- Dumping data for table `lodging_room_features`
--

INSERT INTO `lodging_room_features` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`,
                                     `business_id`)
VALUES (1, 'Vistas panorámicas desde grandes ventanales o balcones.',
        'Vistas panorámicas desde grandes ventanales o balcones', '2024-02-29 14:31:11', '2024-02-29 14:31:11', NULL,
        'ACTIVE', 1),
       (2, 'Servicio de mayordomo personalizado', NULL, '2024-02-29 14:31:27', '2024-02-29 14:31:27', NULL, 'ACTIVE',
        1);

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

--
-- Dumping data for table `lodging_room_levels`
--

INSERT INTO `lodging_room_levels` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`,
                                   `business_id`)
VALUES (1, 'Planta Penthouse',
        'El penthouse generalmente se encuentra en la parte superior del hotel y ofrece alojamiento de lujo con comodidades adicionales.',
        '2024-02-29 14:24:06', '2024-02-29 14:24:06', NULL, 'ACTIVE', 1),
       (2, 'Planta Baja',
        'El primer piso suele ser una parte crucial del hotel, ya que es donde los huéspedes entran y salen y donde se encuentran las áreas comunes principales.',
        '2024-02-29 14:24:29', '2024-02-29 14:24:45', NULL, 'ACTIVE', 1),
       (3, 'Primer Piso', NULL, '2024-02-29 14:24:52', '2024-02-29 14:24:52', NULL, 'ACTIVE', 1),
       (4, 'Segundo Piso', NULL, '2024-02-29 14:24:57', '2024-02-29 14:24:57', NULL, 'ACTIVE', 1);

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

--
-- Dumping data for table `lodging_type_of_room`
--

INSERT INTO `lodging_type_of_room` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`)
VALUES (1, 'Habitación individual o habitación simple',
        'Habitación estándar destinada a la pernoctación y\r\nalojamiento turístico de una sola persona.', NULL, NULL,
        NULL, 'ACTIVE'),
       (2, 'Habitación doble',
        'Habitación estándar destinada a la pernoctación y alojamiento turístico de dos\r\npersonas.\r\n', NULL, NULL,
        NULL, 'ACTIVE'),
       (3, 'Habitación triple',
        'Habitación estándar destinada a la pernoctación y alojamiento turístico de tres\r\npersonas.\r\n', NULL, NULL,
        NULL, 'ACTIVE'),
       (4, 'Habitación cuádruple',
        'Habitación estándar destinada a la pernoctación y alojamiento turístico de\r\ncuatro personas. Este tipo de habitaciones están prohibidas en establecimientos de alojamiento turístico de cinco estrellas.\r\n',
        NULL, NULL, NULL, 'ACTIVE'),
       (5, 'Habitación múltiple',
        'Habitación estándar destinada a la pernoctación y alojamiento turístico de\r\ncinco o más personas. Este tipo de habitación no aplica para establecimientos de cinco estrellas.\r\n',
        NULL, NULL, NULL, 'ACTIVE'),
       (6, 'Habitación júnior suite',
        'Habitación destinada al alojamiento turístico compuesto por un ambiente\r\nadicional que se encuentre en funcionamiento.\r\n',
        NULL, NULL, NULL, 'ACTIVE'),
       (7, 'Habitación suite',
        ' Unidad habitacional destinada al alojamiento turístico compuesta de una o más\r\náreas, al menos un baño privado y un ambiente separado que incluya sala de estar, área de trabajo,\r\nentre otros.\r\n',
        NULL, NULL, NULL, 'ACTIVE'),
       (8, 'Otras', NULL, NULL, NULL, NULL, 'ACTIVE');

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

--
-- Dumping data for table `management_livelihood_by_voucher`
--

INSERT INTO `management_livelihood_by_voucher` (`id`, `tax_support_id`, `voucher_type_id`,
                                                `people_type_identification_id`, `type_management`)
VALUES (1, 1, 1, 2, 0),
       (2, 2, 1, 2, 0),
       (3, 3, 1, 2, 0),
       (4, 4, 1, 2, 0),
       (5, 5, 1, 2, 0),
       (6, 6, 1, 2, 0),
       (7, 7, 1, 2, 0),
       (8, 8, 1, 2, 0),
       (9, 9, 1, 2, 0),
       (10, 14, 1, 2, 0),
       (11, 15, 1, 2, 0),
       (12, 2, 2, 2, 0),
       (13, 4, 2, 2, 0),
       (14, 5, 2, 2, 0),
       (15, 7, 2, 2, 0),
       (16, 8, 2, 2, 0),
       (17, 14, 2, 2, 0),
       (18, 15, 2, 2, 0),
       (19, 1, 3, 1, 0),
       (20, 2, 3, 1, 0),
       (21, 3, 3, 1, 0),
       (22, 4, 3, 1, 0),
       (23, 5, 3, 1, 0),
       (24, 6, 3, 1, 0),
       (25, 7, 3, 1, 0),
       (26, 8, 3, 1, 0),
       (27, 14, 3, 1, 0),
       (28, 1, 3, 3, 0),
       (29, 2, 3, 3, 0),
       (30, 3, 3, 3, 0),
       (31, 4, 3, 3, 0),
       (32, 5, 3, 3, 0),
       (33, 6, 3, 3, 0),
       (34, 7, 3, 3, 0),
       (35, 8, 3, 3, 0),
       (36, 14, 3, 3, 0);

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

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `name`, `value`)
VALUES (1, 'environment', 'staging'),
       (2, 'host_firebase_url', 'https://us-central1-timelygas-396c4.cloudfunctions.net/api'),
       (3, 'site_url', 'http://back.timelygas.com'),
       (4, 'cancel_status_id', '5');

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

--
-- Dumping data for table `people_gender`
--

INSERT INTO `people_gender` (`id`, `value`, `description`, `status`)
VALUES (1, 'Masculino', 'hom', 'ACTIVE'),
       (2, 'Femenino', 'hom', 'ACTIVE'),
       (3, 'LGBTI', 'hom', 'ACTIVE');

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

--
-- Dumping data for table `people_nationality`
--

INSERT INTO `people_nationality` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`,
                                  `countries_id`)
VALUES (1, 'Afgano/\nfgana', NULL, NULL, NULL, NULL, 'ACTIVE', 1),
       (2, 'Alemán/\n/Alemana', NULL, NULL, NULL, NULL, 'ACTIVE', 2),
       (3, 'Arabe', NULL, NULL, NULL, NULL, 'ACTIVE', 3),
       (4, 'Argentino\n/Argentina', NULL, NULL, '2024-02-28 23:07:38', NULL, 'ACTIVE', 4),
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

--
-- Dumping data for table `people_profession`
--

INSERT INTO `people_profession` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`,
                                 `codigo_iess`, `rmu`, `dts`, `dcs`)
VALUES (1, 'Ninguna',
        'Escoger esta opción cuando no se encuentra dentro del catálogo una sugerencia apropiada para paciente. Por ejemplo: niño/a menor de 4 años.',
        '2020-07-26 23:20:08', '2020-07-26 23:50:18', NULL, 'ACTIVE', '000', 0, 0, 0),
       (2, 'Mecánico/a', 'Persona que repara máquinas, autos, camiones, motores, etc.', NULL, '2020-07-19 03:48:39',
        NULL, 'ACTIVE', '000', 0, 0, 0),
       (3, 'Otras',
        'En caso de que dentro del catálogo no exista la profesión u oficio del paciente escoger la opción Otras.',
        NULL, '2020-07-26 23:50:53', NULL, 'ACTIVE', '000', 0, 0, 0),
       (4, 'Diseñador/a',
        'Persona que diseña creativa mente diferentes cosas, por ejemplo, ropa, muebles, papelería, etc.\nHace referencia a las profesiones de diseñador gráfico, de productos, de moda, entre otros.',
        '2019-10-26 18:24:13', '2020-07-19 03:38:00', NULL, 'ACTIVE', '000', 0, 0, 0),
       (5, 'Arquitecto/a', 'Persona que diseña edificios y casas, los diseños los representa en planos.',
        '2020-07-19 03:17:07', '2020-07-19 03:30:19', NULL, 'ACTIVE', '000', 0, 0, 0),
       (6, 'Bombero/a', 'Persona que apaga el fuego en un incendio.', '2020-07-19 03:20:15', '2020-07-19 03:31:42',
        NULL, 'ACTIVE', '000', 0, 0, 0),
       (7, 'Contador/a', 'Persona que trabaja con el dinero y trabaja con las cuentas de una compañía.',
        '2020-07-19 03:20:28', '2020-07-19 03:34:34', NULL, 'ACTIVE', '000', 0, 0, 0),
       (8, 'Doctor/a',
        'Persona que se dedica a curar o prevenir enfermedades. Hace referencia a doctor en medicina general y a todas sus especialidades.',
        '2020-07-19 03:20:41', '2020-07-19 03:39:56', NULL, 'ACTIVE', '000', 0, 0, 0),
       (9, 'Enfermero/a',
        'Persona que cuida a enfermos o a personas que están en un proceso de recuperación siguiendo las ordenes del doctor.',
        '2020-07-19 03:20:47', '2020-07-19 03:40:57', NULL, 'ACTIVE', '000', 0, 0, 0),
       (10, 'Agente de viaje', 'Persona que vende y organiza viajes, vacaciones y vuelos.', '2020-07-19 03:27:53',
        '2020-07-19 03:29:52', NULL, 'ACTIVE', '000', 0, 0, 0),
       (11, 'Carnicero/a', 'Persona que trabaja con carne. Ellos cortan la carne y la venden.', '2020-07-19 03:28:13',
        '2020-07-19 03:32:10', NULL, 'ACTIVE', '000', 0, 0, 0),
       (12, 'Abogado/a', 'Persona que defiende, representa o acusa a una persona en un juicio. cambiado',
        '2020-07-19 03:29:21', '2024-02-28 21:49:00', NULL, 'ACTIVE', '000', 0, 0, 0),
       (13, 'Carpintero/a', 'Persona que trabaja con madera haciendo casas o creando muebles.', '2020-07-19 03:32:44',
        '2020-07-19 03:32:44', NULL, 'ACTIVE', '000', 0, 0, 0),
       (14, 'Chofer', 'Persona que conduce o maneja vehículos, buses , transporte publico o privado, etc.',
        '2020-07-19 03:34:08', '2020-07-19 03:34:08', NULL, 'ACTIVE', '000', 0, 0, 0),
       (15, 'Chef/Cocinero/a', 'Persona que prepara comida para otros, comúnmente en un restaurante.',
        '2020-07-19 03:35:07', '2020-07-19 03:35:07', NULL, 'ACTIVE', '000', 0, 0, 0),
       (16, 'Estilista',
        'Persona que corta el cabello y hace peinados, generalmente trabaja en un salón de belleza o peluquería.',
        '2020-07-19 03:41:52', '2020-07-19 03:41:52', NULL, 'ACTIVE', '000', 0, 0, 0),
       (17, 'Farmacéutico/a',
        'Persona calificada que trabaja en una farmacia, chequea las prescripciones médicas o aconseja a los enfermos a comprar algún tipo de medicamentos.',
        '2020-07-19 03:42:19', '2020-07-19 03:42:19', NULL, 'ACTIVE', '000', 0, 0, 0),
       (18, 'Fontanero/a',
        'Persona que repara las tuberías de agua o gas y realiza instalaciones de agua potable. Sinónimo: Plomero',
        '2020-07-19 03:42:50', '2020-07-19 03:42:50', NULL, 'ACTIVE', '000', 0, 0, 0),
       (19, 'Florista', 'Persona que trabaja en la producción de flores y diseña arreglos florales.',
        '2020-07-19 03:43:20', '2020-07-19 03:43:20', NULL, 'ACTIVE', '000', 0, 0, 0),
       (20, 'Fotógrafo/a',
        'Persona que toma fotos de distintas cosas, por ejemplo de paisajes, personas, detalles, etc.',
        '2020-07-19 03:44:38', '2020-07-19 03:44:38', NULL, 'ACTIVE', '000', 0, 0, 0),
       (21, 'Jardinero/a',
        'Persona que trabaja en el cuidado de un jardín, corta el pasto, realiza riegos periódicos, etc.',
        '2020-07-19 03:46:52', '2020-07-19 03:46:52', NULL, 'ACTIVE', '000', 0, 0, 0),
       (22, 'Juez/a', 'Persona que decide en un juicio si el acusado o demandado es culpable o inocente.',
        '2020-07-19 03:47:26', '2020-07-19 03:47:26', NULL, 'ACTIVE', '000', 0, 0, 0),
       (23, 'Maestro de construcción', 'Persona que construye casas o edificios y realiza diversas reparaciones.',
        '2020-07-19 03:48:02', '2020-07-19 03:48:02', NULL, 'ACTIVE', '000', 0, 0, 0),
       (24, 'Mesero/a',
        'Persona que trabaja por lo general en un restaurante, atiende y sirve la comida a los clientes.',
        '2020-07-19 03:49:25', '2020-07-19 03:49:25', NULL, 'ACTIVE', '000', 0, 0, 0),
       (25, 'Modelo/a', 'Persona que muestra ropa o accesorios en un desfile de modas o revistas.',
        '2020-07-19 03:50:06', '2020-07-19 03:50:06', NULL, 'ACTIVE', '000', 0, 0, 0),
       (26, 'Oftalmólogo/a',
        'Doctor especializado en el cuidado de la visión y corrige problemas relacionados con los ojos,',
        '2020-07-19 03:53:51', '2020-07-19 03:53:51', NULL, 'ACTIVE', '000', 0, 0, 0),
       (27, 'Panadero/a', 'Persona que hace pan y trabaja generalmente en una panadería.', '2020-07-19 03:54:52',
        '2020-07-19 03:54:52', NULL, 'ACTIVE', '000', 0, 0, 0),
       (28, 'Periodista',
        'Persona que investiga e informa sobre las noticias, puede ser a través de un diario, revista, radio o televisión.',
        '2020-07-19 03:55:24', '2020-07-19 03:55:24', NULL, 'ACTIVE', '000', 0, 0, 0),
       (29, 'Pintor/a',
        '(1) Persona que pinta cuadros u obras de arte. \n(2) Persona que pinta casas por dentro o por fuera.',
        '2020-07-19 03:56:46', '2020-07-19 03:56:46', NULL, 'ACTIVE', '000', 0, 0, 0),
       (30, 'Piloto', 'Persona que pilotea aviones o aeroplanos.', '2020-07-19 03:57:12', '2020-07-19 03:57:12', NULL,
        'ACTIVE', '000', 0, 0, 0),
       (31, 'Policía', 'Persona que estar encargado de velar por el mantenimiento del orden público.',
        '2020-07-19 03:59:42', '2020-07-19 03:59:42', NULL, 'ACTIVE', '000', 0, 0, 0),
       (32, 'Político', 'Persona que trabaja en la política.', '2020-07-19 04:00:05', '2020-07-19 04:00:05', NULL,
        'ACTIVE', '000', 0, 0, 0),
       (33, 'Profesor/a',
        'Persona que enseña en una escuela, instituto, universidad y entrega el conocimiento y potencia las destrezas de un estudiante.',
        '2020-07-19 04:00:35', '2020-07-19 04:00:35', NULL, 'ACTIVE', '000', 0, 0, 0),
       (34, 'Psiquiatra',
        'Especialista que evalua, diagnostica, trata o rehabilita a las personas con trastornos mentales.',
        '2020-07-19 04:01:07', '2020-07-19 04:01:07', NULL, 'ACTIVE', '000', 0, 0, 0),
       (35, 'Recepcionista',
        'Persona que trabaja en la recepción de una compañía, entrega información, realiza llamadas, entre otras responsabilidades.',
        '2020-07-19 04:02:10', '2020-07-19 04:02:10', NULL, 'ACTIVE', '000', 0, 0, 0),
       (36, 'Sastre', 'Persona que hace ropas para otros, generalmente crea diseños únicos y exclusivos.',
        '2020-07-19 04:02:45', '2020-07-19 04:02:45', NULL, 'ACTIVE', '000', 0, 0, 0),
       (37, 'Secretario/a',
        'Persona que trabaja en una compañía escribiendo cartas, atendiendo el teléfono, organizando el horario de su jefe, etc.',
        '2020-07-19 04:03:12', '2020-07-19 04:03:12', NULL, 'ACTIVE', '000', 0, 0, 0),
       (38, 'Soldado', 'Persona que está en un batallón de guerra.', '2020-07-19 04:03:35', '2020-07-19 04:03:35', NULL,
        'ACTIVE', '000', 0, 0, 0),
       (39, 'Taxista', 'Persona que conduce un auto y cobra una cantidad de dinero por el recorrido.',
        '2020-07-19 04:03:58', '2020-07-19 04:03:58', NULL, 'ACTIVE', '000', 0, 0, 0),
       (40, 'Traductor/a',
        'Persona que traduce un texto o conversaciones de un lenguaje a otro sin perder la idea original.',
        '2020-07-19 04:20:04', '2020-07-19 04:20:04', NULL, 'ACTIVE', '000', 0, 0, 0),
       (41, 'Vendedor/a', 'Persona que trabaja en un lugar vendiendo productos o servicios.', '2020-07-19 04:20:32',
        '2020-07-19 04:20:32', NULL, 'ACTIVE', '000', 0, 0, 0),
       (42, 'Veterinario/a',
        'Persona que atiende a los animales cuando están enfermos y les receta algún medicamento para que se sanen.',
        '2020-07-19 04:20:57', '2020-07-19 04:20:57', NULL, 'ACTIVE', '000', 0, 0, 0),
       (43, 'Agricultor',
        'Persona que se dedica a cultivar la tierra en una explotación agraria para la extracción y explotación de los recursos que origina, tales como: alimentos vegetales como cereales, frutas, hortalizas, entre otros.',
        '2020-07-19 04:23:12', '2020-07-19 04:23:12', NULL, 'ACTIVE', '000', 0, 0, 0),
       (44, 'Artesano',
        'Persona que realiza objetos artesanales o artesanías. Los artesanos realizan su trabajo a mano o con distintos instrumentos propios, por lo que hay que tener cierta destreza y habilidad para realizar su trabajo.',
        '2020-07-19 04:24:23', '2020-07-19 04:24:23', NULL, 'ACTIVE', '000', 0, 0, 0),
       (45, 'Cajero',
        'Persona responsable de sumar la cantidad debida por una compra, cargar al consumidor esa cantidad y después, recoger el pago por las mercancías o servicios proporcionado.',
        '2020-07-19 04:25:26', '2020-07-19 04:25:26', NULL, 'ACTIVE', '000', 0, 0, 0),
       (46, 'Ingeniero/a',
        'Persona que profesa la ingeniería o alguna de sus ramas.  Hace referencia a todas las profesiones de ingeniería. Por ejemplo: Ingeniero civil, en sistemas, minas y petroleo, redes, telecomunicaciones, turístico, entre otros.',
        '2020-07-19 04:27:52', '2020-07-25 18:13:22', NULL, 'ACTIVE', '000', 0, 0, 0),
       (47, 'Administrador',
        'Persona que se ocupa de realizar la tarea administrativa por medio de la planificación, organización, dirección y control de todas las tareas dentro de un grupo social o de una organización para lograr los objetivos mediante el uso eficiente de los recursos.',
        '2020-07-19 04:29:20', '2020-07-19 04:29:20', NULL, 'ACTIVE', '000', 0, 0, 0),
       (48, 'Estudiante',
        'Hace referencia a pacientes que se encuentren en educación primaria, educación secundaria, educación universitaria (sin egresar), cursos de profesionalizacion, tecnologias, otros.',
        '2020-07-25 18:01:07', '2020-07-25 18:01:07', NULL, 'ACTIVE', '000', 0, 0, 0),
       (49, 'Quehaceres domésticos',
        'Persona que realiza oficios domésticos en instituciones, entidades publicas o privadas, establecimientos académicos, otros. Se refiere a un lugar distinto del propio hogar.',
        '2020-07-25 18:03:53', '2020-07-25 18:03:53', NULL, 'ACTIVE', '000', 0, 0, 0),
       (50, 'Ama de casa',
        'Persona que se dedica netamente a desarrollar actividades dentro del hogar. Ya sea como madre de familia, esposa, hija, entre otros.',
        '2020-07-25 18:05:03', '2020-07-25 18:05:03', NULL, 'ACTIVE', '000', 0, 0, 0),
       (51, 'Técnico de sonido',
        'Personas que trabajan en estudios de grabación. Preparan el equipo para hacer grabaciones musicales, equipos para cubrir una actuación u eventos. Entre otras funciones.',
        '2020-07-25 18:18:36', '2020-07-25 18:18:36', NULL, 'ACTIVE', '000', 0, 0, 0),
       (52, 'Psicólogo',
        'Persona que busca orientar a sus pacientes en sesiones grupales o individuales, con la finalidad de evaluar sus problemas y ayudarles a lidiar con diferentes circunstancias y conflictos, mejorando su salud mental. Entre otras funciones.',
        '2020-07-25 18:19:57', '2020-07-25 18:19:57', NULL, 'ACTIVE', '000', 0, 0, 0),
       (53, 'Músico', 'Persona que se dedica a la composición, interpretación o edición de la música.',
        '2020-07-25 18:21:19', '2020-07-25 18:21:19', NULL, 'ACTIVE', '000', 0, 0, 0),
       (54, 'Economista',
        'Persona capaz de realizar tablas, gráficos e informes que ilustren de forma clara la realidad que atraviesa la economía de la entidad para la que cumplen funciones, de tal forma que analiza los datos una entidad o de algunas y las compara estadisticamente.',
        '2020-07-25 18:24:40', '2020-07-25 18:24:40', NULL, 'ACTIVE', '000', 0, 0, 0),
       (55, 'Catedrático Universitario',
        'Docente superior que ejerce funciones en universidades o instituciones. Además, se puede considerar a personas que forman parte de las autoridades académicas de una institución.',
        '2020-07-25 18:26:32', '2020-07-25 18:26:32', NULL, 'ACTIVE', '000', 0, 0, 0),
       (56, 'Comerciante',
        'Persona que realiza actividades comerciales en las cuales se realiza la acción de comprar y vender.',
        '2020-07-26 23:20:08', '2020-07-30 22:44:38', NULL, 'ACTIVE', '000', 0, 0, 0),
       (57, 'Sociologo/a',
        'Persona que se dedica a analizar la estructura de la sociedad y sus problemas, ademas de entender los comportamientos que se dan entre los grupos de personas.',
        '2020-07-26 23:20:08', '2020-07-30 23:00:01', NULL, 'ACTIVE', '000', 0, 0, 0),
       (58, 'Oficinista',
        'Persona que realiza funciones administrativas u operativas dentro de una empresa o institución, ya sea pública o privada.',
        '2020-07-26 23:20:08', '2020-07-30 22:53:34', NULL, 'ACTIVE', '000', 0, 0, 0),
       (59, 'Artista', 'Persona que hace o practica arte, ya sea por talento innato o profesionalmente.',
        '2020-07-26 23:20:08', '2020-07-30 22:41:52', NULL, 'ACTIVE', '000', 0, 0, 0),
       (60, 'Bibliotecario/a',
        'Persona que trabaja en una biblioteca manteniendo el orden de los libros, vídeos, discos, etc.', NULL,
        '2020-07-19 03:31:07', NULL, 'ACTIVE', '000', 0, 0, 0),
       (61, 'Odontólogo/a', 'Profesional encargado de la salud oral.', '2020-07-30 22:38:53', '2020-07-30 22:38:53',
        NULL, 'ACTIVE', '000', 0, 0, 0);

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

--
-- Dumping data for table `people_relationship`
--

INSERT INTO `people_relationship` (`id`, `name`, `description`, `status`)
VALUES (1, 'Padre', 'DESCRIPCION', 'ACTIVE'),
       (2, 'Madre', 'DESCRIPCION', 'ACTIVE'),
       (3, 'Tio', 'DESCRIPCION', 'ACTIVE'),
       (4, 'Tia', 'DESCRIPCION', 'ACTIVE'),
       (5, 'Abuelo Paterno', 'DESCRIPCION', 'ACTIVE'),
       (6, 'Abuela Paterna', 'DESCRIPCION', 'ACTIVE'),
       (7, 'Hermano', 'DESCRIPCION', 'ACTIVE'),
       (8, 'Hermana', 'DESCRIPCION', 'ACTIVE');

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

--
-- Dumping data for table `people_type_identification`
--

INSERT INTO `people_type_identification` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`,
                                          `status`, `code`)
VALUES (1, 'RUC', 'ada', '2019-10-26 18:19:10', '2019-10-28 09:48:48', NULL, 'ACTIVE', 'R'),
       (2, 'CEDULA', 'Codigocam', '2019-10-26 18:19:11', '2024-02-28 22:52:48', NULL, 'ACTIVE', 'C'),
       (3, 'OTROS', '', '2019-10-27 11:56:31', '2019-10-28 09:48:30', NULL, 'ACTIVE', '-'),
       (4, 'PASAPORTE', '', '2019-10-27 11:56:39', '2019-10-28 09:48:36', NULL, 'ACTIVE', 'P'),
       (5, 'CONSUMIDOR FINAL', '', '2019-10-27 11:56:47', '2019-10-28 09:48:23', NULL, 'INACTIVE', 'F'),
       (6, 'PLACA-RAMV/CPN', '', '2019-10-27 11:56:57', '2019-10-28 09:48:42', NULL, 'INACTIVE', 'PL');

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

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `code`, `name`, `state`, `product_trademark_id`, `product_category_id`,
                       `product_subcategory_id`, `source`, `description`, `code_provider`, `code_product`, `has_tax`,
                       `is_service`, `user_id`, `product_measure_type_id`, `view_online`)
VALUES (1, 'PR-001-001', 'PR-001-001', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000001', 1, 0, 1, 1, 1),
       (2, 'PR-001-002', 'PR-001-002', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000002', 1, 0, 1, 1, 0),
       (3, 'PR-001-003', 'PR-001-003', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000003', 1, 0, 1, 1, 1),
       (4, 'PR-001-004', 'PR-001-004', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000004', 1, 0, 1, 1, 1),
       (5, 'PR-001-005', 'PR-001-005', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000005', 1, 0, 1, 1, 1),
       (6, 'PR-001-006', 'PR-001-006', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000006', 1, 0, 1, 1, 1),
       (7, 'PR-001-007', 'PR-001-007', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000007', 1, 0, 1, 1, 0),
       (8, 'PR-001-008', 'PR-001-008', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000008', 1, 0, 1, 1, 0),
       (9, 'PR-001-009', 'PR-001-009', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000009', 1, 0, 1, 1, 0),
       (10, 'PR-001-010', 'PR-001-010', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000010', 1, 0, 1, 1, 0),
       (11, 'PR-001-011', 'PR-001-011', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000011', 1, 0, 1, 1, 1),
       (12, 'PR-001-012', 'PR-001-012', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000012', 1, 0, 1, 1, 0),
       (13, 'PR-001-013', 'PR-001-013', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000013', 1, 0, 1, 1, 0),
       (14, 'PR-001-014', 'PR-001-014', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000014', 1, 0, 1, 1, 0),
       (15, 'PR-001-015', 'PR-001-015', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000015', 1, 0, 1, 1, 0),
       (16, 'PR-001-016', 'PR-001-016', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000016', 1, 0, 1, 1, 0),
       (17, 'PR-001-017', 'PR-001-017', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000017', 1, 0, 1, 1, 0),
       (18, 'PR-001-018', 'PR-001-018', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000018', 1, 0, 1, 1, 1),
       (19, 'PR-001-019', 'PR-001-019', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000019', 1, 0, 1, 1, 1),
       (20, 'PR-001-020', 'PR-001-020', 'ACTIVE', 1, 1, 1, 'none', 'S/N', 'S/N', 'PA-00100000000000020', 1, 0, 1, 1, 1);

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

--
-- Dumping data for table `product_by_color`
--

INSERT INTO `product_by_color` (`product_id`, `product_color_id`)
VALUES (6, 2);

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

--
-- Dumping data for table `product_by_details`
--

INSERT INTO `product_by_details` (`id`, `product_id`, `tax_id`, `location_details`, `stock_control`, `ice_control`,
                                  `initial_stock_control`)
VALUES (1, 1, 2, 'none', 0, 0, 0),
       (2, 2, 2, 'none', 0, 0, 0),
       (3, 3, 2, 'none', 0, 0, 0),
       (4, 4, 2, 'none', 0, 0, 0),
       (5, 5, 2, 'none', 0, 0, 0),
       (6, 6, 2, 'none', 0, 0, 0),
       (7, 7, 2, 'none', 0, 0, 0),
       (8, 8, 2, 'none', 0, 0, 0),
       (9, 9, 2, 'none', 0, 0, 0),
       (10, 10, 2, 'none', 0, 0, 0),
       (11, 11, 2, 'none', 0, 0, 0),
       (12, 12, 2, 'none', 0, 0, 0),
       (13, 13, 2, 'none', 0, 0, 0),
       (14, 14, 2, 'none', 0, 0, 0),
       (15, 15, 2, 'none', 0, 0, 0),
       (16, 16, 2, 'none', 0, 0, 0),
       (17, 17, 2, 'none', 0, 0, 0),
       (18, 18, 2, 'none', 0, 0, 0),
       (19, 19, 2, 'none', 0, 0, 0),
       (20, 20, 2, 'none', 0, 0, 0);

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

--
-- Dumping data for table `product_by_meta_data`
--

INSERT INTO `product_by_meta_data` (`id`, `product_id`, `title`, `keyword`, `description`)
VALUES (1, 1, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (2, 2, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (3, 3, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (4, 4, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (5, 5, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (6, 6, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (7, 7, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (8, 8, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (9, 9, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (10, 10, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (11, 11, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (12, 12, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (13, 13, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (14, 14, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (15, 15, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (16, 16, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (17, 17, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (18, 18, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (19, 19, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N'),
       (20, 20, 'Titulo Producto Meta S/N', 'keyword Producto Meta S/N', 'Descripcion Producto Meta S/N');

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

--
-- Dumping data for table `product_by_multimedia`
--

INSERT INTO `product_by_multimedia` (`id`, `title`, `subtitle`, `description`, `type`, `priority`, `view`, `product_id`,
                                     `source`)
VALUES (1, '1730042896_1.jpeg', '1730042896_1.jpeg', '1730042896_1.jpeg', 1, 1, 1, 1,
        '/uploads/products/productChildren/1/1730042896_1.jpeg'),
       (2, '1730042952_2.jpeg', '1730042952_2.jpeg', '1730042952_2.jpeg', 1, 1, 1, 2,
        '/uploads/products/productChildren/2/1730042952_2.jpeg'),
       (3, '1730042987_3.jpeg', '1730042987_3.jpeg', '1730042987_3.jpeg', 1, 1, 1, 3,
        '/uploads/products/productChildren/3/1730042987_3.jpeg'),
       (4, '1730043006_4.jpeg', '1730043006_4.jpeg', '1730043006_4.jpeg', 1, 1, 1, 4,
        '/uploads/products/productChildren/4/1730043006_4.jpeg'),
       (5, '1730043098_5.jpeg', '1730043098_5.jpeg', '1730043098_5.jpeg', 1, 1, 1, 5,
        '/uploads/products/productChildren/5/1730043098_5.jpeg'),
       (6, '1730043146_6.jpeg', '1730043146_6.jpeg', '1730043146_6.jpeg', 1, 1, 1, 6,
        '/uploads/products/productChildren/6/1730043146_6.jpeg'),
       (7, '1730043169_7.jpeg', '1730043169_7.jpeg', '1730043169_7.jpeg', 1, 1, 1, 7,
        '/uploads/products/productChildren/7/1730043169_7.jpeg'),
       (8, '1730043186_8.jpeg', '1730043186_8.jpeg', '1730043186_8.jpeg', 1, 1, 1, 8,
        '/uploads/products/productChildren/8/1730043186_8.jpeg'),
       (9, '1730043209_9.jpeg', '1730043209_9.jpeg', '1730043209_9.jpeg', 1, 1, 1, 9,
        '/uploads/products/productChildren/9/1730043209_9.jpeg'),
       (13, '1730043332_11.jpeg', '1730043332_11.jpeg', '1730043332_11.jpeg', 1, 1, 1, 11,
        '/uploads/products/productChildren/11/1730043332_11.jpeg'),
       (14, '1730043348_10.jpeg', '1730043348_10.jpeg', '1730043348_10.jpeg', 1, 1, 1, 10,
        '/uploads/products/productChildren/10/1730043348_10.jpeg'),
       (15, '1730043379_12.jpeg', '1730043379_12.jpeg', '1730043379_12.jpeg', 1, 1, 1, 12,
        '/uploads/products/productChildren/12/1730043379_12.jpeg'),
       (16, '1730043400_13.jpeg', '1730043400_13.jpeg', '1730043400_13.jpeg', 1, 1, 1, 13,
        '/uploads/products/productChildren/13/1730043400_13.jpeg'),
       (17, '1730043415_14.jpeg', '1730043415_14.jpeg', '1730043415_14.jpeg', 1, 1, 1, 14,
        '/uploads/products/productChildren/14/1730043415_14.jpeg'),
       (18, '1730043431_15.jpeg', '1730043431_15.jpeg', '1730043431_15.jpeg', 1, 1, 1, 15,
        '/uploads/products/productChildren/15/1730043431_15.jpeg'),
       (19, '1730043452_16.jpeg', '1730043452_16.jpeg', '1730043452_16.jpeg', 1, 1, 1, 16,
        '/uploads/products/productChildren/16/1730043452_16.jpeg'),
       (20, '1730043469_17.jpeg', '1730043469_17.jpeg', '1730043469_17.jpeg', 1, 1, 1, 17,
        '/uploads/products/productChildren/17/1730043469_17.jpeg'),
       (21, '1730043498_18.jpeg', '1730043498_18.jpeg', '1730043498_18.jpeg', 1, 1, 1, 18,
        '/uploads/products/productChildren/18/1730043498_18.jpeg'),
       (22, '1730043506_18.jpeg', '1730043506_18.jpeg', '1730043506_18.jpeg', 1, 2, 1, 18,
        '/uploads/products/productChildren/18/1730043506_18.jpeg'),
       (23, '1730043527_19.jpeg', '1730043527_19.jpeg', '1730043527_19.jpeg', 1, 1, 1, 19,
        '/uploads/products/productChildren/19/1730043527_19.jpeg'),
       (24, '1730043546_20 (1).jpeg', '1730043546_20 (1).jpeg', '1730043546_20 (1).jpeg', 1, 1, 1, 20,
        '/uploads/products/productChildren/20/1730043546_20 (1).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `product_by_package`
--

CREATE TABLE `product_by_package`
(
    `product_parent_by_package_params_id` int(11) NOT NULL,
    `product_id`                          int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_by_package`
--

INSERT INTO `product_by_package` (`product_parent_by_package_params_id`, `product_id`)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 6),
       (1, 7),
       (1, 8),
       (1, 9),
       (1, 10),
       (1, 11),
       (1, 12),
       (1, 13),
       (1, 14),
       (1, 15),
       (1, 16),
       (1, 17),
       (1, 18),
       (1, 19),
       (1, 20);

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

--
-- Dumping data for table `product_by_sizes`
--

INSERT INTO `product_by_sizes` (`product_sizes_id`, `product_id`)
VALUES (3, 6);

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

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `value`, `state`, `description`, `subtitle`, `source`, `business_id`)
VALUES (1, 'Sin definir', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042310_category-6.jpg', 0),
       (2, 'Software', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042318_category-7.jpg', 0),
       (3, 'Diseño', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042273_category-1.jpg', 0),
       (4, 'Multimedia', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042295_category-4.jpg', 0),
       (5, 'Hoteleria', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042287_category-3.jpg', 0),
       (6, 'Tecnologia', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042331_category-9.jpg', 0),
       (7, 'Hardware', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042281_category-2.jpg', 0),
       (8, 'Ocio', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042302_category-5.jpg', 0),
       (9, 'Comida', 'ACTIVE', 'null', 'null', '/uploads/products/productCategory/1730042262_category-8.jpg', 0);

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

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`id`, `value`, `state`, `description`, `multicolored`, `color`, `business_id`)
VALUES (1, 'Morado', 'ACTIVE', NULL, 0, '#5508C0', 0),
       (2, 'Amarillo', 'ACTIVE', NULL, 0, '#E3ED0F', 0),
       (3, 'Negro', 'ACTIVE', NULL, 0, '#000000', 0),
       (4, 'Azul', 'ACTIVE', NULL, 0, '#1811F1', 0),
       (5, 'Tomate', 'ACTIVE', NULL, 0, '#B85807', 0);

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

--
-- Dumping data for table `product_details_shipping_fee`
--

INSERT INTO `product_details_shipping_fee` (`id`, `height`, `length`, `width`, `weight`, `product_id`)
VALUES (1, 0, 0, 0, 0, 1),
       (2, 0, 0, 0, 0, 2),
       (3, 0, 0, 0, 0, 3),
       (4, 0, 0, 0, 0, 4),
       (5, 0, 0, 0, 0, 5),
       (6, 0, 0, 0, 0, 6),
       (7, 0, 0, 0, 0, 7),
       (8, 0, 0, 0, 0, 8),
       (9, 0, 0, 0, 0, 9),
       (10, 0, 0, 0, 0, 10),
       (11, 0, 0, 0, 0, 11),
       (12, 0, 0, 0, 0, 12),
       (13, 0, 0, 0, 0, 13),
       (14, 0, 0, 0, 0, 14),
       (15, 0, 0, 0, 0, 15),
       (16, 0, 0, 0, 0, 16),
       (17, 0, 0, 0, 0, 17),
       (18, 0, 0, 0, 0, 18),
       (19, 0, 0, 0, 0, 19),
       (20, 0, 0, 0, 0, 20);

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

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `business_id`, `avarage_kardex_value`, `tax`, `quantity_units`, `sale_price`,
                                 `total_price`, `product_id`, `tax_id`, `profit`, `profit_type`, `note`, `sale_price2`,
                                 `sale_price3`, `sale_price4`)
VALUES (1, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 1, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (2, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 2, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (3, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 3, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (4, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 4, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (5, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 5, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (6, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 6, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (7, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 7, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (8, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 8, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (9, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 9, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (10, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 10, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (11, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 11, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (12, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 12, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (13, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 13, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (14, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 14, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (15, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 15, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (16, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 16, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (17, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 17, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (18, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 18, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (19, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 19, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000),
       (20, 1, 0.0000, 'SI', 0.0000, 0.0000, 0.0000, 20, 2, 0, 0, 'S/N', 0.0000, 0.0000, 0.0000);

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

--
-- Dumping data for table `product_measure_type`
--

INSERT INTO `product_measure_type` (`id`, `value`, `state`, `description`, `abbreviation`, `unit`, `number_of_units`,
                                    `prefix`, `symbol`, `business_id`)
VALUES (1, 'UNIDAD', 'ACTIVE', NULL, 'UNI', 1, 1, 'U', 'U', 0),
       (2, 'MASA', 'ACTIVE', NULL, 'KG', 1, 1, 'KG', 'KG', 0),
       (3, 'LONGITUD', 'ACTIVE', NULL, 'M', 1, 1, 'M', 'M', 0),
       (4, 'CAPACIDAD(VOLUMEN)', 'ACTIVE', NULL, 'M3', 1, 1, 'M3', 'M3', 0),
       (5, 'SUPERFICIE (Área)', 'ACTIVE', NULL, 'M2', 1, 1, 'M2', 'M2', 0);

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

--
-- Dumping data for table `product_parent`
--

INSERT INTO `product_parent` (`id`, `code`, `name`, `state`, `product_category_id`, `product_subcategory_id`, `source`,
                              `description`, `has_tax`, `is_service`, `user_id`, `product_measure_type_id`, `tax_id`)
VALUES (1, 'PA-001', 'PA-001', 'ACTIVE', 1, 1, '', 'S/N', 0, 0, 1, 1, 2);

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

--
-- Dumping data for table `product_parent_by_package_params`
--

INSERT INTO `product_parent_by_package_params` (`id`, `name`, `type_param`, `product_parent_id`, `limit_one`,
                                                `limit_two`, `product_parent_by_prices_id`)
VALUES (1, 'Paquete  1', 0, 1, 1, 0, 2),
       (2, 'Paquete  2', 0, 1, 1, 0, 1),
       (3, 'Paquete  3', 0, 1, 1, 0, 3);

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

--
-- Dumping data for table `product_parent_by_prices`
--

INSERT INTO `product_parent_by_prices` (`id`, `price`, `priority`, `utility`, `type_price`, `measurement_type`,
                                        `manager_equivalence_id`, `type_of_income`, `description`, `product_parent_id`)
VALUES (1, 1.0000, 1, 1, 0, 0, 1, 0, 'Precio General', 1),
       (2, 2.0000, 1, 1, 0, 0, 1, 0, 'Precio por Mayor', 1),
       (3, 3.0000, 1, 1, 0, 0, 1, 0, 'Precio por Docena', 1);

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

--
-- Dumping data for table `product_parent_by_product`
--

INSERT INTO `product_parent_by_product` (`id`, `product_parent_id`, `product_id`)
VALUES (1, 1, 1),
       (2, 1, 2),
       (3, 1, 3),
       (4, 1, 4),
       (5, 1, 5),
       (6, 1, 6),
       (7, 1, 7),
       (8, 1, 8),
       (9, 1, 9),
       (10, 1, 10),
       (11, 1, 11),
       (12, 1, 12),
       (13, 1, 13),
       (14, 1, 14),
       (15, 1, 15),
       (16, 1, 16),
       (17, 1, 17),
       (18, 1, 18),
       (19, 1, 19),
       (20, 1, 20);

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

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `value`, `state`, `description`, `business_id`)
VALUES (1, 'XL', 'ACTIVE', 'XL', 0),
       (2, 'XXL', 'ACTIVE', NULL, 0),
       (3, 'L', 'ACTIVE', NULL, 0),
       (4, 'XS', 'ACTIVE', NULL, 0),
       (5, 'M', 'ACTIVE', NULL, 0),
       (6, 'S', 'ACTIVE', NULL, 0),
       (7, 'XXS', 'ACTIVE', NULL, 0);

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

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`id`, `value`, `state`, `description`, `source`, `subtitle`, `product_category_id`,
                                   `business_id`)
VALUES (1, 'Sin definir', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042379_category-7.jpg', 'null', 1,
        0),
       (2, 'Artes', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042348_category-2.jpg', 'null', 2, 0),
       (3, 'Tecnologia', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042391_category-9.jpg', 'null', 7,
        0),
       (4, 'Videos', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042398_category-10.jpg', 'null', 3, 0),
       (5, 'Sistemas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042385_category-8.jpg', 'null', 1,
        0),
       (6, 'Aplicaciones Moviles', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042342_category-1.jpg',
        'null', 7, 0),
       (7, 'Hospedaje', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042371_category-5.jpg', 'null', 5,
        0),
       (8, 'Atracciones Deportivas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042365_category-4.jpg',
        'null', 8, 0),
       (9, 'Asados', 'ACTIVE', 'null', '/uploads/products/productSubcategory/1730042356_category-3.jpg', 'null', 9, 0);

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

--
-- Dumping data for table `product_trademark`
--

INSERT INTO `product_trademark` (`id`, `value`, `state`, `description`, `business_id`)
VALUES (1, 'Propia', 'ACTIVE', NULL, 0),
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

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `country_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`)
VALUES (1, 'Galapagos', 18, 'ACTIVE', NULL, NULL, NULL, 'none-id'),
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
       (25, 'Amazonas', 48, 'ACTIVE', '2020-07-27 06:20:14', '2020-07-27 06:20:14', NULL, 'none-id'),
       (26, 'Antioquia', 48, 'ACTIVE', '2020-07-27 06:20:39', '2020-07-27 06:20:39', NULL, 'none-id'),
       (27, 'Arauca', 48, 'ACTIVE', '2020-07-27 06:20:56', '2020-07-27 06:20:56', NULL, 'none-id'),
       (28, 'Atlántico', 48, 'ACTIVE', '2020-07-27 06:21:19', '2020-07-27 06:21:19', NULL, 'none-id'),
       (29, 'Bogotá', 48, 'ACTIVE', '2020-07-27 06:21:38', '2020-07-27 06:21:38', NULL, 'none-id'),
       (30, 'Bolivar Co', 48, 'ACTIVE', '2020-07-27 06:22:42', '2020-07-27 06:22:42', NULL, 'none-id'),
       (31, 'Boyacá', 48, 'ACTIVE', '2020-07-27 06:23:03', '2020-07-27 06:23:03', NULL, 'none-id'),
       (32, 'Caldas', 48, 'ACTIVE', '2020-07-27 06:23:24', '2020-07-27 06:23:24', NULL, 'none-id'),
       (33, 'Caquetá', 48, 'ACTIVE', '2020-07-27 06:23:44', '2020-07-27 06:23:44', NULL, 'none-id'),
       (34, 'Casanare', 48, 'ACTIVE', '2020-07-27 06:24:01', '2020-07-27 06:24:01', NULL, 'none-id'),
       (35, 'Cauca', 48, 'ACTIVE', '2020-07-27 06:24:16', '2020-07-27 06:24:16', NULL, 'none-id'),
       (36, 'Cesar', 48, 'ACTIVE', '2020-07-27 06:24:32', '2020-07-27 06:24:32', NULL, 'none-id'),
       (37, 'Chocó', 48, 'ACTIVE', '2020-07-27 06:24:44', '2020-07-27 06:24:44', NULL, 'none-id'),
       (38, 'Córdoba', 48, 'ACTIVE', '2020-07-27 06:25:04', '2020-07-27 06:25:04', NULL, 'none-id'),
       (39, 'Cundinamarca', 48, 'ACTIVE', '2020-07-27 06:25:21', '2020-07-27 06:25:21', NULL, 'none-id'),
       (40, 'Guainía', 48, 'ACTIVE', '2020-07-27 06:25:39', '2020-07-27 06:25:39', NULL, 'none-id'),
       (41, 'Guaviare', 48, 'ACTIVE', '2020-07-27 06:27:29', '2020-07-27 06:27:29', NULL, 'none-id'),
       (42, 'Huila', 48, 'ACTIVE', '2020-07-27 06:27:45', '2020-07-27 06:27:45', NULL, 'none-id'),
       (43, 'La Guajira', 48, 'ACTIVE', '2020-07-27 06:28:00', '2020-07-27 06:28:00', NULL, 'none-id'),
       (44, 'Magdalena', 48, 'ACTIVE', '2020-07-27 06:28:16', '2020-07-27 06:28:16', NULL, 'none-id'),
       (45, 'Meta', 48, 'ACTIVE', '2020-07-27 06:28:31', '2020-07-27 06:28:31', NULL, 'none-id'),
       (46, 'Nariño', 48, 'ACTIVE', '2020-07-27 06:28:45', '2020-07-27 06:28:45', NULL, 'none-id'),
       (47, 'Norte de Santander', 48, 'ACTIVE', '2020-07-27 06:29:02', '2020-07-27 06:29:02', NULL, 'none-id'),
       (48, 'Putumayo', 48, 'ACTIVE', '2020-07-27 06:29:15', '2020-07-27 06:29:15', NULL, 'none-id'),
       (49, 'Quindío', 48, 'ACTIVE', '2020-07-27 06:29:31', '2020-07-27 06:29:31', NULL, 'none-id'),
       (50, 'Risaralda', 48, 'ACTIVE', '2020-07-27 06:29:57', '2020-07-27 06:29:57', NULL, 'none-id'),
       (51, 'San Andrés y Providencia', 48, 'ACTIVE', '2020-07-27 06:30:12', '2020-07-27 06:30:12', NULL, 'none-id'),
       (52, 'Santander', 48, 'ACTIVE', '2020-07-27 06:30:27', '2020-07-27 06:30:27', NULL, 'none-id'),
       (53, 'Sucre', 48, 'ACTIVE', '2020-07-27 06:30:43', '2020-07-27 06:30:43', NULL, 'none-id'),
       (54, 'Tolima', 48, 'ACTIVE', '2020-07-27 06:30:58', '2020-07-27 06:30:58', NULL, 'none-id'),
       (55, 'Valle del Cauca', 48, 'ACTIVE', '2020-07-27 06:31:16', '2020-07-27 06:31:16', NULL, 'none-id'),
       (56, 'Vaupés', 48, 'ACTIVE', '2020-07-27 06:31:32', '2020-07-27 06:31:32', NULL, 'none-id'),
       (57, 'Vichada', 48, 'ACTIVE', '2020-07-27 06:31:48', '2020-07-27 06:31:48', NULL, 'none-id'),
       (58, 'Amazonas', 48, 'ACTIVE', '2024-02-28 15:13:05', '2024-02-28 15:13:05', NULL, 'none-id'),
       (59, 'Amazonas', 48, 'ACTIVE', '2024-02-29 12:25:01', '2024-02-29 12:25:01', NULL, 'none-id');

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

--
-- Dumping data for table `reference_piece`
--

INSERT INTO `reference_piece` (`id`, `name`, `type`, `status`, `reference_type_id`)
VALUES (1, 'Sin detalles', 'INDIVIDUAL', 'ACTIVE', 1),
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
-- Table structure for table `reference_piece_position`
--

CREATE TABLE `reference_piece_position`
(
    `id`       int(11) NOT NULL,
    `position` enum('TOP','DOWN','RIGHT','LEFT','CENTER','COMPLETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reference_piece_position`
--

INSERT INTO `reference_piece_position` (`id`, `position`)
VALUES (1, 'TOP'),
       (2, 'DOWN'),
       (3, 'RIGHT'),
       (4, 'LEFT'),
       (5, 'CENTER'),
       (6, 'COMPLETE');

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

--
-- Dumping data for table `reference_piece_type`
--

INSERT INTO `reference_piece_type` (`id`, `color`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`,
                                    `name`)
VALUES (1, '#0b0a0a', 'cambiando', '2018-09-11 22:49:22', '2024-02-29 14:13:28', NULL, 'ACTIVE', 'Lesion'),
       (2, '#247b1f', NULL, '2018-09-11 22:49:44', '2018-09-12 00:37:34', NULL, 'ACTIVE', 'Pre Existencias'),
       (3, '#f81111', NULL, '2018-09-11 22:50:28', '2018-09-11 22:50:28', NULL, 'ACTIVE', 'Por Hacer'),
       (4, '#1ec1fb', 'ag', '2018-09-11 22:51:15', '2018-09-14 08:43:19', NULL, 'ACTIVE', 'Hecho');

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

--
-- Dumping data for table `retention_tax_sub_type`
--

INSERT INTO `retention_tax_sub_type` (`id`, `value`, `description`, `status`, `type`, `retention_tax_type_id`,
                                      `percentage`, `accounting_account_id`)
VALUES (1, '712', 'RETENCIÓN DEL 10%', 'ACTIVE', 0, 3, 10, 100),
       (2, '723', 'RETENCIÓN DEL 20%', 'ACTIVE', 0, 3, 20, 101),
       (3, '725', 'RETENCIÓN DEL 30%', 'ACTIVE', 0, 3, 30, 102),
       (4, '727', 'RETENCIÓN DEL 50%', 'ACTIVE', 0, 3, 50, 103),
       (5, '729', 'RETENCIÓN DEL 70%', 'ACTIVE', 0, 3, 70, 104),
       (6, '731', 'RETENCIÓN DEL 100%', 'ACTIVE', 0, 3, 100, 105),
       (7, '712', 'RETENCIÓN DEL 10%', 'ACTIVE', 0, 4, 10, 30),
       (8, '723', 'RETENCIÓN DEL 20%', 'ACTIVE', 0, 4, 20, 31),
       (9, '725', 'RETENCIÓN DEL 30%', 'ACTIVE', 0, 4, 30, 32),
       (10, '727', 'RETENCIÓN DEL 50%', 'ACTIVE', 0, 4, 50, 33),
       (11, '729', 'RETENCIÓN DEL 70%', 'ACTIVE', 0, 4, 70, 34),
       (12, '731', 'RETENCIÓN DEL 100%', 'ACTIVE', 0, 4, 100, 35),
       (13, '303', 'Honorarios profesionales y demás pagos por servicios relacionados con el título profesional',
        'ACTIVE', 0, 1, 10, 98),
       (14, '304', 'Servicios predomina el intelecto no relacionados con el título profesional', 'ACTIVE', 0, 1, 8, 97),
       (15, '304A',
        'Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional',
        'ACTIVE', 0, 1, 8, 97),
       (16, '304B',
        'Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales',
        'ACTIVE', 0, 1, 8, 97),
       (17, '304C',
        'Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales',
        'ACTIVE', 0, 1, 8, 97),
       (18, '304D', 'Pagos a artistas por sus actividades ejercidas como tales', 'ACTIVE', 0, 1, 8, 97),
       (19, '304E', 'Honorarios y demás pagos por servicios de docencia', 'ACTIVE', 0, 1, 8, 97),
       (20, '307', 'Servicios predomina la mano de obra', 'ACTIVE', 0, 1, 2, 96),
       (21, '308', 'Utilización o aprovechamiento de la imagen o renombre', 'ACTIVE', 0, 1, 10, 98),
       (22, '309', 'Servicios prestados por medios de comunicación y agencias de publicidad', 'ACTIVE', 0, 1, 1, 95),
       (23, '310', 'Servicio de transporte privado de pasajeros o transporte público o privado de carga', 'ACTIVE', 0,
        1, 1, 95),
       (24, '311', 'Pagos a través de liquidación de compra (nivel cultural o rusticidad)', 'ACTIVE', 0, 1, 2, 96),
       (25, '312', 'Transferencia de bienes muebles de naturaleza corporal', 'ACTIVE', 0, 1, 1, 95),
       (26, '312A',
        'Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, y forestal', 'ACTIVE',
        0, 1, 1, 95),
       (27, '312B', 'Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera', 'ACTIVE',
        0, 1, 1, 95),
       (28, '314A',
        'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales',
        'ACTIVE', 0, 1, 8, 97),
       (29, '314B',
        'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales',
        'ACTIVE', 0, 1, 8, 97),
       (30, '314C',
        'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades', 'ACTIVE',
        0, 1, 8, 97),
       (31, '314D',
        'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades',
        'ACTIVE', 0, 1, 8, 97),
       (32, '319', 'Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra',
        'ACTIVE', 0, 1, 1, 95),
       (33, '320', 'Arrendamiento bienes inmuebles', 'ACTIVE', 0, 1, 8, 97),
       (34, '322', 'Seguros y reaseguros (primas y cesiones)', 'ACTIVE', 0, 1, 1, 95),
       (35, '323', 'Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)', 'ACTIVE', 0, 1, 2, 96),
       (36, '323A', 'Rendimientos financieros: depósitos Cta. Corriente', 'ACTIVE', 0, 1, 2, 96),
       (37, '323B1', 'Rendimientos financieros:  depósitos Cta. Ahorros Sociedades', 'ACTIVE', 0, 1, 2, 96),
       (38, '323E', 'Rendimientos financieros: depósito a plazo fijo  gravados', 'ACTIVE', 0, 1, 2, 96),
       (39, '323E2', 'Rendimientos financieros: depósito a plazo fijo exentos', 'ACTIVE', 0, 1, 0, 95),
       (40, '323F', 'Rendimientos financieros: operaciones de reporto - repos', 'ACTIVE', 0, 1, 2, 96),
       (41, '323G', 'Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs', 'ACTIVE', 0, 1, 2,
        96),
       (42, '323H', 'Rendimientos financieros: obligaciones', 'ACTIVE', 0, 1, 2, 96),
       (43, '323I', 'Rendimientos financieros: bonos convertible en acciones', 'ACTIVE', 0, 1, 2, 96),
       (44, '323 M', 'Rendimientos financieros: Inversiones en títulos valores en renta fija gravados ', 'ACTIVE', 0, 1,
        2, 96),
       (45, '323 N', 'Rendimientos financieros: Inversiones en títulos valores en renta fija exentos', 'ACTIVE', 0, 1,
        0, 95),
       (46, '323 O',
        'Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria',
        'ACTIVE', 0, 1, 0, 95),
       (47, '323 P', 'Intereses pagados por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', 0, 1, 2,
        96),
       (48, '323Q', 'Otros intereses y rendimientos financieros gravados ', 'ACTIVE', 0, 1, 2, 96),
       (49, '323R', 'Otros intereses y rendimientos financieros exentos', 'ACTIVE', 0, 1, 0, 95),
       (50, '323S',
        'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades',
        'ACTIVE', 0, 1, 2, 96),
       (51, '323T', 'Rendimientos financieros originados en la deuda pública ecuatoriana', 'ACTIVE', 0, 1, 0, 95),
       (52, '323U',
        'Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada',
        'ACTIVE', 0, 1, 0, 95),
       (53, '324A',
        'Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.',
        'ACTIVE', 0, 1, 1, 95),
       (54, '324B', 'Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria',
        'ACTIVE', 0, 1, 1, 95),
       (55, '324C',
        'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero',
        'ACTIVE', 0, 1, 1, 95),
       (56, '328', 'Dividendos distribuidos a sociedades residentes', 'ACTIVE', 0, 1, 0, 95),
       (57, '329', 'Dividendos distribuidos a fideicomisos residentes', 'ACTIVE', 0, 1, 0, 95),
       (58, '343', 'Otras retenciones aplicables el 1%', 'ACTIVE', 0, 1, 1, 95),
       (59, '343A', 'Energía eléctrica', 'ACTIVE', 0, 1, 1, 95),
       (60, '343B',
        'Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares',
        'ACTIVE', 0, 1, 1, 95),
       (61, '343C', 'Impuesto Redimible a las botellas plásticas - IRBP', 'ACTIVE', 0, 1, 1, 95),
       (62, '344', 'Otras retenciones aplicables el 2%', 'ACTIVE', 0, 1, 2, 96),
       (63, '344A', 'Pago local tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP',
        'ACTIVE', 0, 1, 2, 96),
       (64, '344B', 'Adquisición de sustancias minerales dentro del territorio nacional', 'ACTIVE', 0, 1, 2, 96),
       (65, '345', 'Otras retenciones aplicables el 8%', 'ACTIVE', 0, 1, 8, 97),
       (66, '303', 'Honorarios profesionales y demás pagos por servicios relacionados con el título profesional',
        'ACTIVE', 0, 2, 10, 27),
       (67, '304', 'Servicios predomina el intelecto no relacionados con el título profesional', 'ACTIVE', 0, 2, 8, 26),
       (68, '304A',
        'Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional',
        'ACTIVE', 0, 2, 8, 26),
       (69, '304B',
        'Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales',
        'ACTIVE', 0, 2, 8, 26),
       (70, '304C',
        'Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales',
        'ACTIVE', 0, 2, 8, 26),
       (71, '304D', 'Pagos a artistas por sus actividades ejercidas como tales', 'ACTIVE', 0, 2, 8, 26),
       (72, '304E', 'Honorarios y demás pagos por servicios de docencia', 'ACTIVE', 0, 2, 8, 26),
       (73, '307', 'Servicios predomina la mano de obra', 'ACTIVE', 0, 2, 2, 25),
       (74, '308', 'Utilización o aprovechamiento de la imagen o renombre', 'ACTIVE', 0, 2, 10, 27),
       (75, '309', 'Servicios prestados por medios de comunicación y agencias de publicidad', 'ACTIVE', 0, 2, 1, 24),
       (76, '310', 'Servicio de transporte privado de pasajeros o transporte público o privado de carga', 'ACTIVE', 0,
        2, 1, 24),
       (77, '311', 'Pagos a través de liquidación de compra (nivel cultural o rusticidad)', 'ACTIVE', 0, 2, 2, 25),
       (78, '312', 'Transferencia de bienes muebles de naturaleza corporal', 'ACTIVE', 0, 2, 1, 24),
       (79, '312A',
        'Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, y forestal', 'ACTIVE',
        0, 2, 1, 24),
       (80, '312B', 'Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera', 'ACTIVE',
        0, 2, 1, 24),
       (81, '314A',
        'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales',
        'ACTIVE', 0, 2, 8, 26),
       (82, '314B',
        'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales',
        'ACTIVE', 0, 2, 8, 26),
       (83, '314C',
        'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades', 'ACTIVE',
        0, 2, 8, 26),
       (84, '314D',
        'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades',
        'ACTIVE', 0, 2, 8, 26),
       (85, '319', 'Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra',
        'ACTIVE', 0, 2, 1, 24),
       (86, '320', 'Arrendamiento bienes inmuebles', 'ACTIVE', 0, 2, 8, 26),
       (87, '322', 'Seguros y reaseguros (primas y cesiones)', 'ACTIVE', 0, 2, 1, 24),
       (88, '323', 'Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)', 'ACTIVE', 0, 2, 2, 25),
       (89, '323A', 'Rendimientos financieros: depósitos Cta. Corriente', 'ACTIVE', 0, 2, 2, 25),
       (90, '323B1', 'Rendimientos financieros:  depósitos Cta. Ahorros Sociedades', 'ACTIVE', 0, 2, 2, 25),
       (91, '323E', 'Rendimientos financieros: depósito a plazo fijo  gravados', 'ACTIVE', 0, 2, 2, 25),
       (92, '323E2', 'Rendimientos financieros: depósito a plazo fijo exentos', 'ACTIVE', 0, 2, 0, 24),
       (93, '323F', 'Rendimientos financieros: operaciones de reporto - repos', 'ACTIVE', 0, 2, 2, 25),
       (94, '323G', 'Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs', 'ACTIVE', 0, 2, 2,
        25),
       (95, '323H', 'Rendimientos financieros: obligaciones', 'ACTIVE', 0, 2, 2, 25),
       (96, '323I', 'Rendimientos financieros: bonos convertible en acciones', 'ACTIVE', 0, 2, 2, 25),
       (97, '323 M', 'Rendimientos financieros: Inversiones en títulos valores en renta fija gravados ', 'ACTIVE', 0, 2,
        2, 25),
       (98, '323 N', 'Rendimientos financieros: Inversiones en títulos valores en renta fija exentos', 'ACTIVE', 0, 2,
        0, 24),
       (99, '323 O',
        'Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria',
        'ACTIVE', 0, 2, 0, 24),
       (100, '323 P', 'Intereses pagados por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', 0, 2,
        2, 25),
       (101, '323Q', 'Otros intereses y rendimientos financieros gravados ', 'ACTIVE', 0, 2, 2, 25),
       (102, '323R', 'Otros intereses y rendimientos financieros exentos', 'ACTIVE', 0, 2, 0, 24),
       (103, '323S',
        'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades',
        'ACTIVE', 0, 2, 2, 25),
       (104, '323T', 'Rendimientos financieros originados en la deuda pública ecuatoriana', 'ACTIVE', 0, 2, 0, 24),
       (105, '323U',
        'Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada',
        'ACTIVE', 0, 2, 0, 24),
       (106, '324A',
        'Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.',
        'ACTIVE', 0, 2, 1, 24),
       (107, '324B', 'Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria',
        'ACTIVE', 0, 2, 1, 24),
       (108, '324C',
        'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero',
        'ACTIVE', 0, 2, 1, 24),
       (109, '328', 'Dividendos distribuidos a sociedades residentes', 'ACTIVE', 0, 2, 0, 24),
       (110, '329', 'Dividendos distribuidos a fideicomisos residentes', 'ACTIVE', 0, 2, 0, 24),
       (111, '343', 'Otras retenciones aplicables el 1%', 'ACTIVE', 0, 2, 1, 24),
       (112, '343A', 'Energía eléctrica', 'ACTIVE', 0, 2, 1, 24),
       (113, '343B',
        'Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares',
        'ACTIVE', 0, 2, 1, 24),
       (114, '343C', 'Impuesto Redimible a las botellas plásticas - IRBP', 'ACTIVE', 0, 2, 1, 24),
       (115, '344', 'Otras retenciones aplicables el 2%', 'ACTIVE', 0, 2, 2, 25),
       (116, '344A', 'Pago local tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP',
        'ACTIVE', 0, 2, 2, 25),
       (117, '344B', 'Adquisición de sustancias minerales dentro del territorio nacional', 'ACTIVE', 0, 2, 2, 25),
       (118, '345', 'Otras retenciones aplicables el 8%', 'ACTIVE', 0, 2, 8, 26);

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

--
-- Dumping data for table `retention_tax_type`
--

INSERT INTO `retention_tax_type` (`id`, `value`, `description`, `status`, `type`)
VALUES (1, 'Retención IR Compras', NULL, 'ACTIVE', 1),
       (2, 'Retención IR Ventas', NULL, 'ACTIVE', 1),
       (3, 'Retención Iva Compras', NULL, 'ACTIVE', 0),
       (4, 'Retención Iva Ventas', NULL, 'ACTIVE', 0);

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

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`)
VALUES (1, 'GOD', 'ACTIVE', NULL, NULL),
       (2, 'BUSINESS', 'ACTIVE', '2020-06-14 18:50:42', '2020-06-14 18:50:42'),
       (3, 'EMPLOYER', 'ACTIVE', '2020-06-14 19:08:45', '2020-06-14 22:10:21'),
       (4, 'CUSTOMER', 'ACTIVE', '2020-06-14 19:17:10', '2020-06-14 19:17:10');

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

--
-- Dumping data for table `ruc_type`
--

INSERT INTO `ruc_type` (`id`, `name`, `description`)
VALUES (1, 'Persona Natural', 'Persona Natural'),
       (2, 'Sociedad Privada', 'Sociedad Privada'),
       (3, 'Sociedad Publica', 'Sociedad Publica'),
       (4, 'Ninguno', 'Ningunos');

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

--
-- Dumping data for table `schedule_days_category`
--

INSERT INTO `schedule_days_category` (`id`, `name`, `weight_day`, `description`)
VALUES (1, 'Lunes', 0, NULL),
       (2, 'Martes', 1, NULL),
       (3, 'Miercoles', 2, NULL),
       (4, 'Jueves', 3, NULL),
       (5, 'Viernes', 4, NULL),
       (6, 'Sabado', 5, NULL),
       (7, 'Domingo', 6, NULL);

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

--
-- Dumping data for table `shipping_rate_business`
--

INSERT INTO `shipping_rate_business` (`id`, `title`, `description`, `state`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 'Servientrega', NULL, 'ACTIVE', NULL, NULL, NULL),
       (2, 'DHL', NULL, 'ACTIVE', NULL, NULL, NULL);

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

--
-- Dumping data for table `shipping_rate_kinds_of_way`
--

INSERT INTO `shipping_rate_kinds_of_way` (`id`, `value`, `description`, `state`)
VALUES (1, 'Aereo', 'hola', 'ACTIVE'),
       (2, 'Terrestre', NULL, 'ACTIVE'),
       (3, 'Maritimo', NULL, 'ACTIVE');

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

--
-- Dumping data for table `shipping_rate_services`
--

INSERT INTO `shipping_rate_services` (`id`, `value`, `description`, `state`, `shipping_rate_business_id`)
VALUES (3, 'Servicio Express', 'adad', 'ACTIVE', 1);

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

--
-- Dumping data for table `subtipo_medicion`
--

INSERT INTO `subtipo_medicion` (`id`, `nombre`, `descripcion`, `estado`, `simbolo`, `prefijo`, `has_equivalencia`,
                                `decimal_number`, `is_base`)
VALUES (1, 'Kilogramo ', NULL, 'ACTIVO', 'kg', 'kg', 1, 3, 0),
       (2, 'Hectogramo ', NULL, 'ACTIVO', 'hg', 'hg', 1, 3, 0),
       (3, 'Decagramo ', NULL, 'ACTIVO', 'dag', 'dag', 1, 3, 0),
       (4, 'Gramo ', NULL, 'ACTIVO', 'g', 'g', 1, 3, 1),
       (5, 'Decigramo ', NULL, 'ACTIVO', 'dg', 'dg', 1, 3, 0),
       (6, 'Centigramo ', 'sdd', 'ACTIVO', 'cg', 'cg', 1, 3, 0),
       (7, 'Miligramo ', NULL, 'ACTIVO', 'mg', 'mg', 1, 3, 0),
       (8, 'Kilómetro', NULL, 'ACTIVO', 'km', 'km', 1, 3, 0),
       (9, 'Hectómetro', NULL, 'ACTIVO', 'hm', 'hm', 1, 3, 0),
       (10, 'Decámetro', NULL, 'ACTIVO', 'dam', 'dam', 1, 3, 0),
       (11, 'Metro', NULL, 'ACTIVO', 'm', 'm', 1, 3, 1),
       (12, 'Decímetro', NULL, 'ACTIVO', 'dm', 'dm', 1, 3, 0),
       (13, 'Centímetro', NULL, 'ACTIVO', 'cm', 'cm', 1, 3, 0),
       (14, 'Milímetro', NULL, 'ACTIVO', 'mm', 'mm', 1, 3, 0),
       (15, 'Kilolitro', NULL, 'ACTIVO', 'kl', 'kl', 1, 3, 0),
       (16, 'Hectolitro ', NULL, 'ACTIVO', 'hl', 'hl', 1, 3, 0),
       (17, 'Decalitro ', NULL, 'ACTIVO', 'dal', 'dal', 1, 3, 0),
       (18, 'Litro ', NULL, 'ACTIVO', 'l', 'l', 1, 3, 1),
       (19, 'Decilitro ', NULL, 'ACTIVO', 'dl', 'dl', 1, 3, 0),
       (20, 'Centilitro ', NULL, 'ACTIVO', 'cl', 'cl', 1, 3, 0),
       (21, 'Mililitro ', NULL, 'ACTIVO', 'ml', 'ml', 1, 3, 0),
       (22, 'Kilómetro Cuadrado', NULL, 'ACTIVO', 'km2', 'km2', 1, 3, 0),
       (23, 'Hectómetro Cuadrado', NULL, 'ACTIVO', 'hm2', 'hm2', 1, 3, 0),
       (24, 'Decámetro Cuadrado', NULL, 'ACTIVO', 'dam2', 'dam2', 1, 3, 0),
       (25, 'Metro Cuadrado', NULL, 'ACTIVO', 'm2', 'm2', 1, 3, 1),
       (26, 'Decímetro Cuadrado', NULL, 'ACTIVO', 'dm2', 'dm2', 1, 3, 0),
       (27, 'Centímetro Cuadrado', NULL, 'ACTIVO', 'cm2', 'cm2', 1, 3, 0),
       (28, 'Milímetro Cuadrado', NULL, 'ACTIVO', 'mm2', 'mm2', 1, 3, 0),
       (29, 'UNIDAD', NULL, 'ACTIVO', 'U', 'PAS', 1, 0, 0),
       (30, 'PASTILLA', NULL, 'ACTIVO', 'PAS', 'PAS', 1, 0, 0),
       (31, 'BLISTER', NULL, 'ACTIVO', 'BLIS', 'BLIS', 1, 0, 0),
       (32, 'CAJA', 'PAQ', 'ACTIVO', 'CAJ', 'CAJ', 1, 0, 0),
       (33, 'PAQUETE', 'BULT', 'ACTIVO', 'PAQ', 'PAQ', 1, 0, 0),
       (34, 'BULTO', NULL, 'ACTIVO', 'BUL', 'BUL', 1, 0, 0);

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

--
-- Dumping data for table `subtipo_medicion_has_equivalencias`
--

INSERT INTO `subtipo_medicion_has_equivalencias` (`id`, `valor`, `subtipo_medicion_id`,
                                                  `subtipo_medicion_equivalencia_id`, `tipo_medida_manager_id`,
                                                  `position_matrix`)
VALUES (1, 1, 29, 29, 6, '0,0'),
       (2, 1, 30, 30, 5, '0,0'),
       (3, 0.1, 30, 31, 5, '0,1'),
       (4, 0.01, 30, 32, 5, '0,2'),
       (5, 0.001, 30, 33, 5, '0,3'),
       (6, 0.0001, 30, 34, 5, '0,4'),
       (7, 10, 31, 30, 5, '1,0'),
       (8, 1, 31, 31, 5, '1,1'),
       (9, 0.1, 31, 32, 5, '1,2'),
       (10, 0.01, 31, 33, 5, '1,3'),
       (11, 0.001, 31, 34, 5, '1,4'),
       (12, 100, 32, 30, 5, '2,0'),
       (13, 10, 32, 31, 5, '2,1'),
       (14, 1, 32, 32, 5, '2,2'),
       (15, 0.1, 32, 33, 5, '2,3'),
       (16, 0.01, 32, 34, 5, '2,4'),
       (17, 1000, 33, 30, 5, '3,0'),
       (18, 100, 33, 31, 5, '3,1'),
       (19, 10, 33, 32, 5, '3,2'),
       (20, 1, 33, 33, 5, '3,3'),
       (21, 0.1, 33, 34, 5, '3,4'),
       (22, 10000, 34, 30, 5, '4,0'),
       (23, 1000, 34, 31, 5, '4,1'),
       (24, 100, 34, 32, 5, '4,2'),
       (25, 10, 34, 33, 5, '4,3'),
       (26, 1, 29, 29, 5, '4,4');

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

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `value`, `percentage`, `state`)
VALUES (1, '12', 12, 'ACTIVE'),
       (2, '0', 0, 'ACTIVE'),
       (3, '13', 13, 'ACTIVE'),
       (4, '15', 15, 'ACTIVE');

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

--
-- Dumping data for table `tax_by_business`
--

INSERT INTO `tax_by_business` (`id`, `tax_id`, `state`, `business_id`)
VALUES (1, 1, 'ACTIVE', 1);

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

--
-- Dumping data for table `tax_support`
--

INSERT INTO `tax_support` (`id`, `value`, `description`, `status`, `code`)
VALUES (1, ' Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)',
        ' Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)',
        'ACTIVE', '01'),
       (2, ' Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)',
        ' Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)', 'ACTIVE',
        '02'),
       (3, ' Activo Fijo - Crédito Tributario para declaración de IVA',
        ' Activo Fijo - Crédito Tributario para declaración de IVA', 'ACTIVE', '03'),
       (4, ' Activo Fijo - Costo o Gasto para declaración de IR', ' Activo Fijo - Costo o Gasto para declaración de IR',
        'ACTIVE', '04'),
       (5,
        ' Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleados y no de la empresa)',
        ' Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleados y no de la empresa)',
        'ACTIVE', '05'),
       (6, ' Inventario - Crédito Tributario para declaración de IVA',
        ' Inventario - Crédito Tributario para declaración de IVA', 'ACTIVE', '06'),
       (7, ' Inventario - Costo o Gasto para declaración de IR', ' Inventario - Costo o Gasto para declaración de IR',
        'ACTIVE', '07'),
       (8, ' Valor pagado para solicitar Reembolso de Gasto (intermediario)',
        ' Valor pagado para solicitar Reembolso de Gasto (intermediario)', 'ACTIVE', '08'),
       (9, ' Reembolso por Siniestros', ' Reembolso por Siniestros', 'ACTIVE', '09'),
       (10, 'Distribución de Dividendos, Beneficios o Utilidades',
        'Distribución de Dividendos, Beneficios o Utilidades', 'ACTIVE', '10'),
       (11, 'Convenios de débito o recaudación para IFI´s', 'Convenios de débito o recaudación para IFI´s', 'ACTIVE',
        '11'),
       (12, ' Impuestos y retenciones presuntivos', ' Impuestos y retenciones presuntivos', 'ACTIVE', '12'),
       (13, 'Valores reconocidos por entidades del sector público a favor de sujetos pasivos',
        'Valores reconocidos por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', '13'),
       (14, 'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)',
        'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)',
        'ACTIVE', '14'),
       (15, 'Casos especiales cuyo sustento no aplica en las opciones anteriores',
        'Casos especiales cuyo sustento no aplica en las opciones anteriores', 'ACTIVE', '00');

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

--
-- Dumping data for table `tipo_medida_has_subtipo`
--

INSERT INTO `tipo_medida_has_subtipo` (`id`, `subtipo_medicion_id`, `is_base`, `state`, `type_manager_condition`,
                                       `ratio`, `decimal_number`, `tipo_medida_manager_id`)
VALUES (1, 1, 0, 1, 1, 0, 0, 1),
       (2, 2, 0, 1, 1, 0, 0, 1),
       (3, 3, 0, 1, 1, 0, 0, 1),
       (4, 4, 0, 1, 1, 0, 0, 1),
       (5, 5, 0, 1, 1, 0, 0, 1),
       (6, 6, 0, 1, 1, 0, 0, 1),
       (7, 7, 0, 1, 1, 0, 0, 1),
       (8, 8, 0, 1, 1, 0, 0, 2),
       (9, 9, 0, 1, 1, 0, 0, 2),
       (10, 10, 0, 1, 1, 0, 0, 2),
       (11, 11, 0, 1, 1, 0, 0, 2),
       (12, 12, 0, 1, 1, 0, 0, 2),
       (13, 13, 0, 1, 1, 0, 0, 2),
       (14, 14, 0, 1, 1, 0, 0, 2),
       (15, 15, 0, 1, 1, 0, 0, 3),
       (16, 16, 0, 1, 1, 0, 0, 3),
       (17, 17, 0, 1, 1, 0, 0, 3),
       (18, 18, 0, 1, 1, 0, 0, 3),
       (19, 19, 0, 1, 1, 0, 0, 3),
       (20, 20, 0, 1, 1, 0, 0, 3),
       (21, 21, 0, 1, 1, 0, 0, 3),
       (22, 22, 0, 1, 1, 0, 0, 4),
       (23, 23, 0, 1, 1, 0, 0, 4),
       (24, 24, 0, 1, 1, 0, 0, 4),
       (25, 25, 0, 1, 1, 2.5, 0, 4),
       (26, 26, 0, 1, 1, 0, 0, 4),
       (27, 27, 0, 1, 1, 0, 0, 4),
       (28, 28, 0, 1, 1, 0, 0, 4),
       (29, 30, 0, 1, 0, 1, 0.01, 5),
       (30, 31, 0, 1, 1, 1, 0.01, 5),
       (31, 32, 0, 1, 1, 1, 0.01, 5),
       (32, 33, 0, 1, 1, 1, 0.01, 5),
       (33, 34, 0, 1, 1, 1, 0.01, 5),
       (34, 29, 0, 1, 0, 1, 0.01, 6);

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

--
-- Dumping data for table `tipo_medida_manager`
--

INSERT INTO `tipo_medida_manager` (`id`, `description`, `name`, `business_manager_id`, `state`,
                                   `producto_tipo_medida_id`)
VALUES (1, 'Medidas de MASA', 'Medidas de MASA', 1, 1, 2),
       (2, 'Medidas de Longitud', 'Medidas de Longitud', 1, 1, 3),
       (3, 'Medidas de Volumen', 'Medidas de Volumen', 1, 1, 4),
       (4, 'Medidas de Superficie', 'Medidas de Superficie', 1, 1, 5),
       (5, 'Medidas Medicamento con 5 nivele\nPastilla,Blister,Caja,Paquete,Bulto.', 'Medidas Medicamento', 1, 1, 1),
       (6, 'UNIDAD PARA LA GESTION DE PRODUCTOS DE TIPO UNIDAD', 'UNIDAD', 1, 1, 1);

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

--
-- Dumping data for table `types_payments`
--

INSERT INTO `types_payments` (`id`, `value`, `description`, `status`, `code`, `type_payment`)
VALUES (1, 'SIN UTILIZACION DEL SISTEMA FINANCIERO', NULL, 'ACTIVE', '01', 0),
       (2, 'TARJETA DE CRÉDITO', NULL, 'ACTIVE', '19', 0),
       (3, 'CHEQUE PROPIO', NULL, 'ACTIVE', '02', 0),
       (4, 'TRANSFERENCIA PROPIO BANCO', NULL, 'ACTIVE', '07', 0),
       (5, 'DINERO ELECTRÓNICO', NULL, 'ACTIVE', '17', 0),
       (6, 'TARJETA DE DÉBITO', NULL, 'ACTIVE', '16', 0),
       (7, 'TARJETA PREPAGO', NULL, 'ACTIVE', '18', 0),
       (8, 'TRANSFERENCIA OTRO BANCO NACIONAL', NULL, 'INACTIVE', '08', 0),
       (9, 'TRANSFERENCIA  BANCO EXTERIOR', NULL, 'INACTIVE', '09', 0),
       (10, 'TARJETA DE CRÉDITO NACIONAL', NULL, 'INACTIVE', '10', 0),
       (11, 'TARJETA DE CRÉDITO INTERNACIONAL', NULL, 'INACTIVE', '11', 0),
       (12, 'GIRO', NULL, 'INACTIVE', '12', 0),
       (13, 'DEPOSITO EN CUENTA (CORRIENTE/AHORROS)', NULL, 'INACTIVE', '13', 0),
       (14, 'ENDOSO DE INVERSIÓN', NULL, 'INACTIVE', '14', 0),
       (15, 'COMPENSACIÓN DE DEUDAS', NULL, 'ACTIVE', '15', 0),
       (16, 'CHEQUE CERTIFICADO', NULL, 'INACTIVE', '03', 0),
       (17, 'CHEQUE DEL EXTERIOR', NULL, 'INACTIVE', '05', 0),
       (18, 'CHEQUE DE GERENCIA', NULL, 'INACTIVE', '04', 0),
       (19, 'DÉBITO DE CUENTA', NULL, 'INACTIVE', '06', 0),
       (20, 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO', NULL, 'ACTIVE', '20', 0),
       (21, 'ENDOSO DE TÍTULOS', NULL, 'ACTIVE', '21', 0);

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

--
-- Dumping data for table `type_ruc`
--

INSERT INTO `type_ruc` (`id`, `value`, `descripcion`)
VALUES (1, 'Persona Natural', NULL),
       (2, 'Sociedad Privada', NULL),
       (3, 'Sociedad Pública', NULL),
       (4, 'Sin Ruc', NULL);

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `status`, `created_at`,
                     `updated_at`, `provider_id`, `provider`, `api_token`, `user_id`, `avatar`)
VALUES (1, 'Admin', 'admin@system.dev', NULL, '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS',
        '90tzVrBg9xqQZv9G2sNoMZFfpFp9ssy19kfUQdcONm4vQzueRVLQsePy2Pqg', 'ACTIVE', '2017-11-25 15:41:16',
        '2017-11-25 15:41:16', 'server', 'server', NULL, NULL, NULL);

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

--
-- Dumping data for table `users_has_roles`
--

INSERT INTO `users_has_roles` (`user_id`, `role_id`)
VALUES (1, 1);

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

--
-- Dumping data for table `voucher_type`
--

INSERT INTO `voucher_type` (`id`, `value`, `description`, `status`, `code`)
VALUES (1, 'Factura', 'Factura', 'ACTIVE', '1'),
       (2, 'Nota o boleta de venta', 'Nota o boleta de venta', 'ACTIVE', '2'),
       (3, 'Liquidación de compra de Bienes o Prestación de servicios',
        'Liquidación de compra de Bienes o Prestación de servicios', 'ACTIVE', '3'),
       (4, 'Nota de crédito', 'Nota de crédito', 'ACTIVE', '4'),
       (5, 'Nota de débito', 'Nota de débito', 'ACTIVE', '5'),
       (6, 'Guías de Remisión', 'Guías de Remisión', 'ACTIVE', '6'),
       (7, 'Comprobante de Retención', 'Comprobante de Retención', 'ACTIVE', '7'),
       (8, 'Boletos o entradas a espectáculos públicos', 'Boletos o entradas a espectáculos públicos', 'ACTIVE', '8'),
       (9, 'Tiquetes o vales emitidos por máquinas registradoras',
        'Tiquetes o vales emitidos por máquinas registradoras', 'ACTIVE', '9'),
       (10, 'Pasajes expedidos por empresas de aviación', 'Pasajes expedidos por empresas de aviación', 'ACTIVE', '11'),
       (11, 'Documentos emitidos por instituciones financieras', 'Documentos emitidos por instituciones financieras',
        'ACTIVE', '12'),
       (12, 'Comprobante de venta emitido en el Exterior', 'Comprobante de venta emitido en el Exterior', 'ACTIVE',
        '15'),
       (13,
        'Formulario Único de Exportación (FUE) o Declaración Aduanera Única (DAU) o Declaración Andina de Valor (DAV)',
        'Formulario Único de Exportación (FUE) o Declaración Aduanera Única (DAU) o Declaración Andina de Valor (DAV)',
        'ACTIVE', '16'),
       (14, 'Documentos autorizados utilizados en ventas excepto N/C N/D',
        'Documentos autorizados utilizados en ventas excepto N/C N/D', 'ACTIVE', '18'),
       (15, 'Comprobantes de Pago de Cuotas o Aportes', 'Comprobantes de Pago de Cuotas o Aportes', 'ACTIVE', '19'),
       (16, 'Documentos por Servicios Administrativos emitidos por Inst. del Estado',
        'Documentos por Servicios Administrativos emitidos por Inst. del Estado', 'ACTIVE', '20'),
       (17, 'Carta de Porte Aéreo', 'Carta de Porte Aéreo', 'ACTIVE', '21'),
       (18, 'RECAP', 'RECAP', 'ACTIVE', '22'),
       (19, 'Nota de Crédito TC', 'Nota de Crédito TC', 'ACTIVE', '23'),
       (20, 'Nota de Débito TC', 'Nota de Débito TC', 'ACTIVE', '24'),
       (21, 'Comprobante de venta emitido por reembolso', 'Comprobante de venta emitido por reembolso', 'ACTIVE', '41'),
       (22, 'Documento agente de retención Presuntiva', 'Documento agente de retención Presuntiva', 'ACTIVE', '42'),
       (23, 'Liquidación para Explotación y Exploracion de Hidrocarburos',
        'Liquidación para Explotación y Exploracion de Hidrocarburos', 'ACTIVE', '43'),
       (24, 'Comprobante de Contribuciones y Aportes', 'Comprobante de Contribuciones y Aportes', 'ACTIVE', '44'),
       (25, 'Liquidación por reclamos de aseguradoras', 'Liquidación por reclamos de aseguradoras', 'ACTIVE', '45'),
       (26, 'Nota de Crédito por Reembolso Emitida por Intermediario',
        'Nota de Crédito por Reembolso Emitida por Intermediario', 'ACTIVE', '47'),
       (27, 'Nota de Débito por Reembolso Emitida por Intermediario',
        'Nota de Débito por Reembolso Emitida por Intermediario', 'ACTIVE', '48'),
       (28, 'Proveedor Directo de Exportador Bajo Régimen Especial',
        'Proveedor Directo de Exportador Bajo Régimen Especial', 'ACTIVE', '49'),
       (29, 'A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta',
        'A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '50'),
       (30, 'N/C A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta',
        'N/C A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '51'),
       (31, 'N/D A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta',
        'N/D A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '52'),
       (32, 'Liquidación de compra de Bienes Muebles Usados', 'Liquidación de compra de Bienes Muebles Usados',
        'ACTIVE', '294'),
       (33, 'Liquidación de compra de vehículos usados', 'Liquidación de compra de vehículos usados', 'ACTIVE', '344'),
       (34, 'Acta Entrega-Recepción PET', 'Acta Entrega-Recepción PET', 'ACTIVE', '364'),
       (35, 'Factura operadora transporte / socio', 'Factura operadora transporte / socio', 'ACTIVE', '370'),
       (36, 'Comprobante socio a operadora de transporte', 'Comprobante socio a operadora de transporte', 'ACTIVE',
        '371'),
       (37, 'Nota de crédito operadora transporte / socio', 'Nota de crédito operadora transporte / socio', 'ACTIVE',
        '372'),
       (38, 'Nota de débito operadora transporte / socio', 'Nota de débito operadora transporte / socio', 'ACTIVE',
        '373');

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
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `city_id`, `color`, `zip_code`, `polygon_coordinates`, `polygon_spatial`, `status`,
                     `created_at`, `updated_at`, `deleted_at`, `place_id`)
VALUES (1, 'Gonzales Suares', 1, '#ffa8b8', '100450',
        '[[0.19898877729791498,-78.25823140153514],[0.2015636822213178,-78.25724434861766],[0.2033232003518515,-78.25707268724071],[0.20400984152158985,-78.25625729570018],[0.20319445512926707,-78.25475525865184],[0.20336611542581728,-78.25376820573436],[0.20495397308212226,-78.25260949143993],[0.20611267992122725,-78.25153660783397],[0.2074001318658086,-78.25084996232616],[0.20873049876517405,-78.24801754960643],[0.2101466956634176,-78.24660134324657],[0.21083333653760608,-78.2446272374116],[0.21164872253637973,-78.24303936967479],[0.21023252577434026,-78.24007821092235],[0.21083333653760608,-78.23801827439891],[0.21860095929455028,-78.23741745957958],[0.2194163448782743,-78.23964905747997],[0.21993132522405012,-78.24200940141307],[0.21598314212208675,-78.25007748612987],[0.21302200412154337,-78.25557065019237],[0.21109082685763916,-78.25921845445262],[0.20662766071159372,-78.25994801530467]]',
        0x0000000001030000000100000017000000281900dd869053c091fd61d97678c93f4a1900b1769053c00fd899b7d6ccc93f471900e1739053c083be03a07e06ca3f25190085669053c015ddb296fe1cca3f3d1900e94d9053c0db1ec1a14602ca3f191900bd3d9053c0a2296f9fe607ca3f371900c12a9053c01257c989ee3bca3f3419002d199053c08ebbc679e661ca3f271900ed0d9053c0ed5dc667168cca3f14190085df8f53c0ebe4ef54aeb7ca3f50190051c88f53c03b519e4016e6ca3f4e1900f9a78f53c0d6f4aa3696fcca3f411900f58d8f53c0d457c42a4e17cb3f191900715d8f53c05fcd603fe6e8ca3f381900b13b8f53c0d6f4aa3696fcca3f501900d9318f53c043ac85c11dfbcb3f34190069568f53c028e2bab4d515cc3f2d1900157d8f53c098039aacb526cc3f3b190045019053c0cb6af3e955a5cb3f181900455b9053c0dee383164e44cb3f4d190009979053c0ab69eb320605cb3f491900fda29053c010469a72c672ca3f281900dd869053c091fd61d97678c93f,
        'ACTIVE', '2020-05-20 21:54:53', '2020-05-20 22:02:44', NULL, 'none-id'),
       (2, 'El Jordan', 1, '#e5bedd', NULL,
        '[[0.2170141185930993,-78.2193915055365],[0.2086027691489902,-78.20892016154237],[0.20877442938728538,-78.19621721964783],[0.2175290990212006,-78.19175402384705],[0.2231938825614229,-78.20874850016541],[0.22370886277591814,-78.21424166422791],[0.22096230142418116,-78.22024981242127]]',
        0x00000000010300000001000000080000004e53ab820a8e53c02e56105f1ec7cb3f1153abf25e8d53c028cbacdb7eb3ca3f3753abd28e8c53c0f9cf3ad91eb9ca3f2753abb2458c53c020b91c57fed7cb3f0e53ab225c8d53c04b6022fd9d91cc3f3153ab22b68d53c0b655b9f47da2cc3f1853ab92188e53c0020422217e48cc3f4e53ab820a8e53c02e56105f1ec7cb3f,
        'ACTIVE', '2020-05-20 21:58:17', '2020-05-20 22:02:44', NULL, 'none-id'),
       (3, 'San Rafael de la laguna', 1, '#e5bedd', NULL,
        '[[0.2048400917519579,-78.24626876404871],[0.19351050934756264,-78.2485003619491],[0.19351050934756264,-78.22481109192957],[0.20724333548969276,-78.23974563172449]]',
        0x00000000010300000001000000050000007ae70fdec28f53c0cafd7d3b3338ca3f5ee70f6ee78f53c0d13f8acef3c4c83f83e70f4e638e53c0d13f8acef3c4c83f43e70ffe578f53c095ff1e1af386ca3f7ae70fdec28f53c0cafd7d3b3338ca3f,
        'ACTIVE', '2020-05-20 21:58:17', '2020-05-20 22:02:44', NULL, 'none-id'),
       (4, 'San Juan de Iluman', 1, '#e5bedd', NULL,
        '[[0.23111585890298292,-78.28933583598388],[0.22673852873244676,-78.28933583598388],[0.22862678896981717,-78.28555928569091],[0.23051504895887534,-78.28444348674071]]',
        0x00000000010300000001000000050000002d47747a849253c0c7a1c9573495cd3f2d47747a849253c06313d3a2c405cd3f2a47749a469253c013b4ce82a443cd3f38477452349253c03dd241628481cd3f2d47747a849253c0c7a1c9573495cd3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (5, 'San Luis', 1, '#e5bedd', NULL,
        '[[0.2251935883549699,-78.2782636771704],[0.2168680735304996,-78.27208386760009],[0.21901382521895926,-78.26659070353759],[0.22261868736255455,-78.2683931479956]]',
        0x000000000103000000010000000500000008477412cf9153c01e72a0bc24d3cc3f1e4774d2699153c02915ae4155c2cb3f414774d20f9153c03af95720a508cc3f4047745a2d9153c049add9e6c47ecc3f08477412cf9153c01e72a0bc24d3cc3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (6, 'San Pedro de Pataqui', 1, '#e5bedd', NULL,
        '[[0.22819763893760353,-78.2441888938452],[0.2242494580436194,-78.25002538066161],[0.22510775832918428,-78.25174199443114],[0.2297425789935009,-78.250454534104],[0.22957091899551568,-78.24796544413817]]',
        0x0000000001030000000100000006000000164774caa08f53c0d375218a9435cd3f3f47746a009053c096b638cc34b4cc3f1a47748a1c9053c0f6c20cbe54d0cc3f24477472079053c0bb4ca36f3468cd3f184774aade8f53c0f26599729462cd3f164774caa08f53c0d375218a9435cd3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (7, 'San Jose de Quichinche', 1, '#e5bedd', NULL,
        '[[0.23403407826881503,-78.23337422709716],[0.23060087895244827,-78.23637830119384],[0.23635148733308337,-78.23663579325927],[0.2379822564430687,-78.23165761332763]]',
        0x00000000010300000001000000050000001947749aef8e53c0fa332824d4f4cd3f2f4774d2208f53c0d5cac3605484cd3f1147740a258f53c0cd6f3afac340ce3f3e47747ad38e53c03fc339dc3376ce3f1947749aef8e53c0fa332824d4f4cd3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (8, 'Dr Miguel Egas', 1, '#e5bedd', NULL,
        '[[0.2289701089863594,-78.23886739115966],[0.2289701089863594,-78.23054181437743],[0.22570856849904763,-78.23792325358642]]',
        0x00000000010300000001000000040000003c47749a498f53c006d2ed7ce44ecd3f06477432c18e53c006d2ed7ce44ecd3f074774223a8f53c0cdb010b404e4cc3f3c47749a498f53c006d2ed7ce44ecd3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (9, 'Selva Alegra', 1, '#e5bedd', NULL,
        '[[0.22845512895847364,-78.22702275614989],[0.23214581874799814,-78.22230206828368],[0.23300411856156872,-78.22693692546142]]',
        0x00000000010300000001000000040000002c47748a878e53c0a173bd85043ecd3f3a4774323a8e53c0bc80b645f4b6cd3f07477422868e53c06c12873614d3cd3f2c47748a878e53c0a173bd85043ecd3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (10, 'Eugenio Espejo', 1, '#e5bedd', NULL,
        '[[0.22570856849904763,-78.22775231700194],[0.22648103868095426,-78.22234498362792],[0.22304783755930466,-78.22414742808593]]',
        0x00000000010300000001000000040000002847747e938e53c0cdb010b404e4cc3f2a4774e63a8e53c0ca3e26a754fdcc3f2947746e588e53c0135fe1dfd48ccc3f2847747e938e53c0cdb010b404e4cc3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (11, 'San Pablo del Lago', 1, '#e5bedd', NULL,
        '[[0.24286668310337173,-78.20816716087256],[0.2347128385193923,-78.20773800743018],[0.23454117858174858,-78.21649273765479],[0.2382318667746855,-78.21563443077002]]',
        0x00000000010300000001000000050000003f035b9c528d53c0acc59b664116cf3f13035b944b8d53c0a230b2fe110bce3f2f035b04db8d53c0f275c9017205ce3f1e035bf4cc8d53c0fcc654be617ece3f3f035b9c528d53c0acc59b664116cf3f,
        'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
       (12, 'Cristoba Colon', 5, '#e5bedd', NULL,
        '[[0.6402458478000177,-77.74711566851752],[0.6382718648346677,-77.72600131915229],[0.6232524045846296,-77.73612934039252]]',
        0x00000000010300000001000000040000004ca73cbed06f53c09b6d36dce47ce43f16a73cce766e53c0b77f2d1eb96ce43f4ca73cbe1c6f53c0e304db06aff1e33f4ca73cbed06f53c09b6d36dce47ce43f,
        'ACTIVE', '2020-07-14 05:36:18', '2020-07-27 06:47:56', NULL, 'none-id'),
       (13, 'Por definir', 215, '#e5bedd', NULL,
        '[[-0.16509509768396524,-78.48976135350341],[-0.15556792857568008,-78.47680091954345],[-0.16226269652208958,-78.46504211522216]]',
        0x0000000001030000000100000004000000f7080140589f53c0772ba40ed621c5bff40801e8839e53c043fec45ea6e9c3bf09090140c39d53c0c329762706c5c4bff7080140589f53c0772ba40ed621c5bf,
        'ACTIVE', '2020-07-27 06:35:16', '2020-07-27 06:35:16', NULL, 'none-id'),
       (14, 'Chical', 6, '#e5bedd', NULL,
        '[[0.8239941784795906,-77.73905868270874],[0.8251956836756045,-77.72554034927369],[0.814167568858249,-77.73279304244996]]',
        0x0000000001030000000100000004000000d703cabc4c6f53c05741150a295eea3fdb03ca406f6e53c06cfc45c70068ea3fc803ca14e66e53c06bb83625a90dea3fd703cabc4c6f53c05741150a295eea3f,
        'ACTIVE', '2020-07-27 06:43:50', '2020-07-31 19:46:56', NULL, 'none-id'),
       (15, 'Tulcan', 6, '#e5bedd', NULL,
        '[[0.7997494433501385,-77.76096696594239],[0.8400857356430022,-77.71582002380372],[0.8189735992815355,-77.67067308166504],[0.7769206414113045,-77.75976533630372]]',
        0x0000000001030000000100000005000000aa03caaeb37053c098db05258c97e93fd903cafecf6d53c078870d7bfbe1ea3fc203ca4eec6a53c0b373261f0835ea3fd903cafe9f7053c0335d4ead88dce83faa03caaeb37053c098db05258c97e93f,
        'ACTIVE', '2020-07-27 06:45:25', '2020-07-31 19:46:57', NULL, 'none-id'),
       (16, 'Sin registro', 8, '#e5bedd', NULL,
        '[[0.5087050120222935,-77.94235172641358],[0.5141121299966296,-77.89222660434326],[0.5026112704647144,-77.93488445651612]]',
        0x0000000001030000000100000004000000bf919d7d4f7c53c0024ebebb4f47e03f8e919d3d1a7953c066ff19489b73e03f99919d25d57b53c0efe6273b6415e03fbf919d7d4f7c53c0024ebebb4f47e03f,
        'ACTIVE', '2020-07-27 06:46:34', '2020-07-31 20:02:25', NULL, 'none-id'),
       (17, 'Sin registro', 7, '#e5bedd', NULL,
        '[[0.5048868951487201,-77.91947606202393],[0.5078050246003604,-77.87690404053956],[0.4932143643209043,-77.89492848511964]]',
        0x000000000103000000010000000400000045f61fb2d87a53c0acf7da8f0828e03f5ff61f321f7853c08ee5ac52f03fe03f5af61f82467953c0953e2bfbd290df3f45f61fb2d87a53c0acf7da8f0828e03f,
        'ACTIVE', '2020-07-27 06:46:58', '2020-07-31 19:57:51', NULL, 'none-id'),
       (18, 'Sin registro', 9, '#e5bedd', NULL,
        '[[0.5557989348868654,-78.0542882720581],[0.5591461732930796,-78.01446283260498],[0.5430107502734334,-78.02175844112548]]',
        0x0000000001030000000100000004000000e9428475798353c025b40fd91ac9e13ff24284f5ec8053c04446ff8386e4e13fce42847d648153c032a0b9145860e13fe9428475798353c025b40fd91ac9e13f,
        'ACTIVE', '2020-07-27 06:48:18', '2020-07-27 06:48:18', NULL, 'none-id'),
       (19, 'Sin registro', 10, '#e5bedd', NULL,
        '[[0.5724422490199026,-77.79592586260988],[0.5746737351073109,-77.75747371417238],[0.5551052893286973,-77.7585036824341]]',
        0x0000000001030000000100000004000000d67c0773f07253c0fd734c687251e23fb27c07737a7053c079fe442cba63e23fc67c07538b7053c0b91bf02a6cc3e13fd67c0773f07253c0fd734c687251e23f,
        'ACTIVE', '2020-07-27 06:48:40', '2020-07-27 06:48:40', NULL, 'none-id'),
       (20, 'Zona Dos', 3, '#e5bedd', 'ZP01',
        '[[0.33538922308889224,-78.2347798133667],[0.34534540726068297,-78.20413825758057],[0.32242900270425207,-78.1959843421753],[0.32066950129918675,-78.22242019422607]]',
        0x0000000001030000000100000005000000060be9a1068f53c0953f265c0477d53f0f0be999108d53c0fb89809f231ad63fdc0ae9018b8c53c0b4627941ada2d43fec0ae9213c8e53c0cbe5395fd985d43f060be9a1068f53c0953f265c0477d53f,
        'ACTIVE', '2020-07-27 06:49:26', '2024-02-22 22:31:08', NULL, 'none-id'),
       (21, 'Sin registro', 4, '#e5bedd', NULL,
        '[[0.3016286134508392,-78.2825102678589],[0.3193953049827574,-78.27504299796144],[0.3081516534151998,-78.23573254263917]]',
        0x0000000001030000000100000004000000454ff2a5149253c0aac99319e24dd33f1f4ff24d9a9153c0cf665901f970d43f324ff23d168f53c0641a68b6c1b8d33f454ff2a5149253c0aac99319e24dd33f,
        'ACTIVE', '2020-07-27 06:49:58', '2020-07-27 06:49:58', NULL, 'none-id'),
       (22, 'Sin registro', 2, '#e5bedd', NULL,
        '[[0.3499792603059938,-78.15326457264403],[0.35040840573245896,-78.09592967274169],[0.33049603763935254,-78.13043360950927]]',
        0x00000000010300000001000000040000000dc93516cf8953c04ab852690f66d63f25c935b6238653c09252b760176dd63ffcc83506598853c0089747dad826d53f0dc93516cf8953c04ab852690f66d63f,
        'ACTIVE', '2020-07-27 06:50:21', '2020-07-27 06:50:21', NULL, 'none-id'),
       (23, 'Sin registro', 106, '#e5bedd', NULL,
        '[[0.3970092922055667,-77.96046575093995],[0.3981250642942425,-77.90991147542725],[0.37426467510040734,-77.93557485128174]]',
        0x0000000001030000000100000004000000c94d5745787d53c036c98ea99968d93fb34d57fd3b7a53c06825b78ce17ad93fd74d5775e07b53c049ade6d2f3f3d73fc94d5745787d53c036c98ea99968d93f,
        'ACTIVE', '2020-07-27 06:50:55', '2020-07-27 06:50:55', NULL, 'none-id'),
       (24, 'Sin registro', 107, '#e5bedd', NULL,
        '[[0.42724758074649016,-78.21046294615479],[0.42922163144264264,-78.18402709410401],[0.41917971613256977,-78.18497123167725]]',
        0x00000000010300000001000000040000005bb09339788d53c0997ba63c0658db3f4bb09319c78b53c0b70a72015e78db3f3ab09391d68b53c0a2e6fb28d7d3da3f5bb09339788d53c0997ba63c0658db3f,
        'ACTIVE', '2020-07-27 06:51:21', '2020-07-27 06:51:21', NULL, 'none-id'),
       (25, 'Sin registro', 178, '#e5bedd', NULL,
        '[[-0.1773058194818411,-78.49062624779052],[-0.17043939602472563,-78.44487849083251],[-0.19155363991854032,-78.4537190517456]]',
        0x00000000010300000001000000040000009434a26b669f53c058510804f5b1c6bf9534a2e3789c53c09327f047f5d0c5bf8f34a2bb099d53c037a07065d484c8bf9434a26b669f53c058510804f5b1c6bf,
        'ACTIVE', '2020-07-27 06:52:12', '2020-07-27 06:52:12', NULL, 'none-id'),
       (26, 'Sin registro', 179, '#e5bedd', NULL,
        '[[0.04184845467835922,-78.17012756949462],[0.05111816597312691,-78.12575310355224],[0.030347144724432343,-78.12970131522216]]',
        0x000000000103000000010000000400000041c8be5ee38a53c016a07620296da53f16c8be560c8853c0be122c06292caa3f1bc8be064d8853c09e41796852139f3f41c8be5ee38a53c016a07620296da53f,
        'ACTIVE', '2020-07-27 06:52:34', '2020-07-27 06:52:34', NULL, 'none-id'),
       (27, 'Sin registro', 181, '#e5bedd', NULL,
        '[[0.08220280601059479,-79.073644822937],[0.09378993526952253,-79.02557963739012],[0.0690707221450119,-79.03244609246825]]',
        0x00000000010300000001000000040000002f82c698b6c453c0cd76743b3e0bb53f2682c618a3c153c0ec32ad009e02b83f1e82c69813c253c07253b96c9eaeb13f2f82c698b6c453c0cd76743b3e0bb53f,
        'ACTIVE', '2020-07-27 06:53:03', '2020-07-27 06:53:03', NULL, 'none-id'),
       (28, 'Sin registro', 182, '#e5bedd', NULL,
        '[[0.11580869488155088,-79.28464852923585],[0.13160150470171353,-79.24645387286378],[0.10619567582393855,-79.24430810565187]]',
        0x000000000103000000010000000400000014fb76ae37d253c0c1d31b7da3a5bd3f19fb76e6c5cf53c08e2c666f51d8c03f13fb76bea2cf53c0e3f3a3caa32fbb3f14fb76ae37d253c0c1d31b7da3a5bd3f,
        'ACTIVE', '2020-07-27 06:53:23', '2020-07-27 06:53:23', NULL, 'none-id'),
       (29, 'Sin registro', 183, '#e5bedd', NULL,
        '[[0.027748020379505172,-78.914918278479],[0.035129458472160056,-78.86676726224366],[0.015045079396745178,-78.8743203628296]]',
        0x00000000010300000001000000040000001e2565058eba53c0e91f3c20fa699c3f3625651d79b753c0633a87067dfca13f3b2565ddf4b753c02846cc5ff4cf8e3f1e2565058eba53c0e91f3c20fa699c3f,
        'ACTIVE', '2020-07-27 06:53:57', '2020-07-27 06:53:57', NULL, 'none-id'),
       (30, 'Julio Andrade', 6, '#e5bedd', NULL,
        '[[0.7685111958183863,-77.81431054565819],[0.795116231990742,-77.75937890503319],[0.7546078525605212,-77.77036523315819]]',
        0x0000000001030000000100000004000000e698faa91d7453c077cb94caa497e83fe698faa9997053c043689d989771e93fe698faa94d7153c0d0ab015ebf25e83fe698faa91d7453c077cb94caa497e83f,
        'ACTIVE', '2020-07-31 19:41:33', '2020-07-31 19:46:57', NULL, 'none-id'),
       (31, 'El Carmelo', 6, '#e5bedd', NULL,
        '[[0.7825907871309515,-77.81736632249496],[0.7743518015755979,-77.6930834855809],[0.6995136371567818,-77.74938841722152],[0.7839639498214088,-77.82354613206527],[0.8141734136839461,-77.78990050218246]]',
        0x0000000001030000000100000006000000f1fdd5ba4f7453c0431b9cd5fb0ae93ff5fdd57a5b6c53c051b5eb6d7dc7e83f0ffed5faf56f53c05e38566c6a62e63fdbfdd5fab47453c0e93ab7903b16e93fcdfdd5ba8d7253c0a4722167b50dea3ff1fdd5ba4f7453c0431b9cd5fb0ae93f,
        'ACTIVE', '2020-07-31 19:42:52', '2020-07-31 19:46:57', NULL, 'none-id'),
       (32, 'Maldonado', 6, '#e5bedd', NULL,
        '[[0.8264210430190453,-77.75603649999455],[0.8339733507241377,-77.71415112401799],[0.8017042999160229,-77.7368104257758],[0.830540485373964,-77.74985669042424]]',
        0x0000000001030000000100000005000000e583eae6627053c0e4c60f8b0a72ea3fc683eaa6b46d53c0221063e1e8afea3fd383eae6276f53c0d075a6c68fa7e93fb483eaa6fd6f53c08aecd5a3c993ea3fe583eae6627053c0e4c60f8b0a72ea3f,
        'ACTIVE', '2020-07-31 19:43:32', '2020-07-31 19:46:57', NULL, 'none-id'),
       (33, 'Pioter', 6, '#e5bedd', NULL,
        '[[0.8304957739278666,-77.6912247669671],[0.8170217485745882,-77.6816975605462],[0.8179657900482247,-77.69543047070245],[0.8310965255865157,-77.691568089721]]',
        0x0000000001030000000100000005000000be13ce063d6c53c0ae908fdf6b93ea3fb713ceeea06b53c085f447cb0a25ea3fa513ceee816c53c00220b097c62cea3fc513cea6426c53c09bd3a6bd5798ea3fbe13ce063d6c53c0ae908fdf6b93ea3f,
        'ACTIVE', '2020-07-31 19:44:11', '2020-07-31 19:46:57', NULL, 'none-id'),
       (34, 'Tobar Donoso', 6, '#e5bedd', NULL,
        '[[0.821017235860916,-77.7534520161126],[0.8318307776351835,-77.74186487316827],[0.8028229569129044,-77.75061960339288]]',
        0x0000000001030000000100000004000000e113ce8e387053c0f4322ff0c545ea3fb213ceb67a6f53c0a5fa37945b9eea3fce13ce260a7053c0d0670dc5b9b0e93fe113ce8e387053c0f4322ff0c545ea3f,
        'ACTIVE', '2020-07-31 19:44:48', '2020-07-31 19:46:57', NULL, 'none-id'),
       (35, 'Tufiño', 6, '#e5bedd', NULL,
        '[[0.8296375571142417,-77.76160593151788],[0.8238874996707007,-77.73199434399346],[0.8054357670465262,-77.75448198437432]]',
        0x0000000001030000000100000004000000ce13ce26be7053c008d9ea0f648cea3fa413cefed86e53c05c675551495dea3fae13ce6e497053c0eccacf3a21c6e93fce13ce26be7053c008d9ea0f648cea3f,
        'ACTIVE', '2020-07-31 19:45:23', '2020-07-31 19:46:57', NULL, 'none-id'),
       (36, 'Urbina', 6, '#e5bedd', NULL,
        '[[0.8315716915271679,-77.7913321258852],[0.8336314105574412,-77.7441252472231],[0.7963846609581579,-77.7609480621645]]',
        0x0000000001030000000100000004000000d13c802fa57253c0606f6c3c3c9cea3fd83c80bf9f6f53c0d766a8c71badea3f023d805fb37053c0383e3baffb7be93fd13c802fa57253c0606f6c3c3c9cea3f,
        'ACTIVE', '2020-07-31 19:46:18', '2020-07-31 19:46:57', NULL, 'none-id'),
       (37, 'Santa Marta de Cuba', 6, '#e5bedd', NULL,
        '[[0.81738828727564,-77.8087556010715],[0.802283595069792,-77.6769196635715],[0.7658947914361117,-77.69786235155978],[0.7923281991995731,-77.86609050097384]]',
        0x0000000001030000000100000005000000a243daa6c27353c0386f3f7b0b28ea3fa243daa6526b53c050255ea54eace93fd543dac6a96c53c079a22ccb3582e83fd043da066e7753c0df57e8aac05ae93fa243daa6c27353c0386f3f7b0b28ea3f,
        'ACTIVE', '2020-07-31 19:46:57', '2020-07-31 19:46:57', NULL, 'none-id'),
       (38, 'Los Andes', 7, '#e5bedd', NULL,
        '[[0.505419146267689,-77.94539216535577],[0.5132294303139098,-77.92436364667901],[0.48524968833363424,-77.91629556196222],[0.49305999633706504,-77.95191529767999]]',
        0x00000000010300000001000000050000005006244e817c53c036beffc5642ce03f3f0624c6287b53c0e25f5120606ce03f31062496a47a53c0666072b5540edf3f4106242eec7c53c03af3ce834b8edf3f5006244e817c53c036beffc5642ce03f,
        'ACTIVE', '2020-07-31 19:53:10', '2020-07-31 19:57:51', NULL, 'none-id'),
       (39, 'Garcia Moreno', 7, '#e5bedd', NULL,
        '[[0.511018515557544,-77.92083376257777],[0.4972003096062016,-77.87954920142055],[0.4824379706957606,-77.92203539221644]]',
        0x0000000001030000000100000004000000cfd4bbf0ee7a53c0120b7f80435ae03fdfd4bb884a7853c00676543f21d2df3fa0d4bba0027b53c04c299f8243e0de3fcfd4bbf0ee7a53c0120b7f80435ae03f,
        'ACTIVE', '2020-07-31 19:56:34', '2020-07-31 19:57:51', NULL, 'none-id'),
       (40, 'Monte Olivo', 7, '#e5bedd', NULL,
        '[[0.4878721982842548,-77.90359262006768],[0.5041794179193684,-77.87561181562432],[0.4902753700083286,-77.86943200605401]]',
        0x000000000103000000010000000400000056062476d47953c0f48a10504c39df3f290624060a7853c0d9f5e8df3c22e03f3f0624c6a47753c0bc150ef2ab60df3f56062476d47953c0f48a10504c39df3f,
        'ACTIVE', '2020-07-31 19:57:04', '2020-07-31 19:57:51', NULL, 'none-id'),
       (41, 'San Vicente de Pusir', 7, '#e5bedd', NULL,
        '[[0.49763567652737084,-77.94800523676622],[0.49471754254438155,-77.87195924677599],[0.48081347489604076,-77.91470292963731]]',
        0x00000000010300000001000000040000003016281eac7c53c04181004f43d9df3f4116282ece7753c015147fc473a9df3f2a16287e8a7a53c01ce589e1a5c5de3f3016281eac7c53c04181004f43d9df3f,
        'ACTIVE', '2020-07-31 19:57:51', '2020-07-31 19:57:51', NULL, 'none-id'),
       (42, '27 de septiembre', 8, '#e5bedd', NULL,
        '[[0.5059313233342333,-77.95679202727482],[0.49202727911922695,-77.90529361418888],[0.48018307041973923,-77.9586803024213]]',
        0x00000000010300000001000000040000000f8ea0143c7d53c0b8c2f7e29630e03f0b8ea054f07953c02da523fc5f7ddf3fed8da0045b7d53c0e7ebe2c551bbde3f0f8ea0143c7d53c0b8c2f7e29630e03f,
        'ACTIVE', '2020-07-31 20:00:39', '2020-07-31 20:02:25', NULL, 'none-id'),
       (43, 'El Goaltal', 8, '#e5bedd', NULL,
        '[[0.49106867390987624,-77.96324196988145],[0.4905537086739361,-77.92135659390489],[0.466865265656445,-77.92993966275255]]',
        0x000000000103000000010000000400000081b1a5c1a57d53c00d1da24dab6ddf3fa9b1a581f77a53c0cce8eb613b65df3fc1b1a521847b53c02b7fe8d91ee1dd3f81b1a5c1a57d53c00d1da24dab6ddf3f,
        'ACTIVE', '2020-07-31 20:01:17', '2020-07-31 20:02:25', NULL, 'none-id'),
       (44, 'La Libertad', 8, '#e5bedd', NULL,
        '[[0.5032838029756448,-77.94571137076949],[0.5217366626606419,-77.9313776457939],[0.497705021078201,-77.91815971976851]]',
        0x0000000001030000000100000004000000203afc88867c53c055614ca2e61ae03f493afcb09b7b53c0610de81511b2e03f643afc20c37a53c0ba7e252966dadf3f203afc88867c53c055614ca2e61ae03f,
        'ACTIVE', '2020-07-31 20:01:54', '2020-07-31 20:02:25', NULL, 'none-id'),
       (45, 'San Isidro', 8, '#e5bedd', NULL,
        '[[0.5082454804903404,-77.94681015762627],[0.5018084289241144,-77.91144791397393],[0.4914233057463509,-77.91788521560967],[0.5009501549016235,-77.95522156509698]]',
        0x00000000010300000001000000050000008ea1a189987c53c05477a1068c43e03fa6a1a129557a53c018c2e28cd00ee03fb8a1a1a1be7a53c0dd0eabbc7a73df3fa3a1a159227d53c0a050879ec807e03f8ea1a189987c53c05477a1068c43e03f,
        'ACTIVE', '2020-07-31 20:02:25', '2020-07-31 20:02:25', NULL, 'none-id'),
       (46, 'Zona 1', 3, '#e5bedd', NULL,
        '[[0.33538922308889224,-78.2347798133667],[0.34534540726068297,-78.20413825758057],[0.32242900270425207,-78.1959843421753],[0.32066950129918675,-78.22242019422607]]',
        0x0000000001030000000100000005000000060be9a1068f53c0953f265c0477d53f0f0be999108d53c0fb89809f231ad63fdc0ae9018b8c53c0b4627941ada2d43fec0ae9213c8e53c0cbe5395fd985d43f060be9a1068f53c0953f265c0477d53f,
        'ACTIVE', '2024-02-22 22:30:49', '2024-02-22 22:30:49', NULL, 'none-id'),
       (47, 'Zona uno', 218, '#e5bedd', NULL,
        '[[0.34174373807838776,-78.1954257229712],[0.3350490611458787,-78.20606872834229],[0.32998513580720057,-78.19971725739502],[0.32938433093416936,-78.19113418854737],[0.3401129838673165,-78.17774460114502],[0.34449027086001627,-78.18529770173096],[0.34268785881096353,-78.18958923615479]]',
        0x0000000001030000000100000008000000493de4da818c53c0d634aa2021dfd53f433de43a308d53c0ef540b9e7171d53f553de42ac88c53c092509df9791ed53f3d3de48a3b8c53c0a1554b04a214d53f553de42a608b53c067eda93f69c4d53f5a3de4eadb8b53c0ed92c8eb200cd63f663de43a228c53c0e213950e99eed53f493de4da818c53c0d634aa2021dfd53f,
        'ACTIVE', '2024-02-29 12:56:04', '2024-02-29 12:56:04', NULL, 'none-id');

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT for table `accounting_account_by_balances`
--
ALTER TABLE `accounting_account_by_balances`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'Contabilidad cuenta saldos';

--
-- AUTO_INCREMENT for table `accounting_account_type`
--
ALTER TABLE `accounting_account_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `accounting_bank`
--
ALTER TABLE `accounting_bank`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_config_modules_account_by_account`
--
ALTER TABLE `accounting_config_modules_account_by_account`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `accounting_config_modules_types`
--
ALTER TABLE `accounting_config_modules_types`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accounting_level`
--
ALTER TABLE `accounting_level`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=783;

--
-- AUTO_INCREMENT for table `actions_by_role`
--
ALTER TABLE `actions_by_role`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `business_by_products_parent`
--
ALTER TABLE `business_by_products_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `caja_catalogo_tipo_fraccion`
--
ALTER TABLE `caja_catalogo_tipo_fraccion`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `clinical_by_history_clinic`
--
ALTER TABLE `clinical_by_history_clinic`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinical_exam`
--
ALTER TABLE `clinical_exam`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `counter_by_entity`
--
ALTER TABLE `counter_by_entity`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `counter_by_log_user_to_business`
--
ALTER TABLE `counter_by_log_user_to_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2700;

--
-- AUTO_INCREMENT for table `dictionary_language`
--
ALTER TABLE `dictionary_language`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dictionary_words_by_audio`
--
ALTER TABLE `dictionary_words_by_audio`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dictionary_words_by_examples`
--
ALTER TABLE `dictionary_words_by_examples`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictionary_words_by_photo`
--
ALTER TABLE `dictionary_words_by_photo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `entity_position_fiscal`
--
ALTER TABLE `entity_position_fiscal`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gaminification_by_log_customers`
--
ALTER TABLE `gaminification_by_log_customers`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `human_resources_department_by_manager`
--
ALTER TABLE `human_resources_department_by_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `human_resources_department_by_organizational_chart_area`
--
ALTER TABLE `human_resources_department_by_organizational_chart_area`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `information_mail`
--
ALTER TABLE `information_mail`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `information_mail_type`
--
ALTER TABLE `information_mail_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `information_phone`
--
ALTER TABLE `information_phone`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_phone_operator`
--
ALTER TABLE `information_phone_operator`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `information_phone_type`
--
ALTER TABLE `information_phone_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `information_social_network`
--
ALTER TABLE `information_social_network`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `information_social_network_type`
--
ALTER TABLE `information_social_network_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `language_course`
--
ALTER TABLE `language_course`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_course_by_photo`
--
ALTER TABLE `language_course_by_photo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_course_by_section`
--
ALTER TABLE `language_course_by_section`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lodging_room_levels`
--
ALTER TABLE `lodging_room_levels`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lodging_type_of_room`
--
ALTER TABLE `lodging_type_of_room`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_gender`
--
ALTER TABLE `people_gender`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `people_nationality`
--
ALTER TABLE `people_nationality`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `people_profession`
--
ALTER TABLE `people_profession`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `people_relationship`
--
ALTER TABLE `people_relationship`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `people_type_identification`
--
ALTER TABLE `people_type_identification`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prices_by_zones`
--
ALTER TABLE `prices_by_zones`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_aplication`
--
ALTER TABLE `product_aplication`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_by_details`
--
ALTER TABLE `product_by_details`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_by_multimedia`
--
ALTER TABLE `product_by_multimedia`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_defect`
--
ALTER TABLE `product_defect`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details_shipping_fee`
--
ALTER TABLE `product_details_shipping_fee`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_parent`
--
ALTER TABLE `product_parent`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_parent_by_package_params`
--
ALTER TABLE `product_parent_by_package_params`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_parent_by_prices`
--
ALTER TABLE `product_parent_by_prices`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_parent_by_product`
--
ALTER TABLE `product_parent_by_product`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_trademark`
--
ALTER TABLE `product_trademark`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `reference_piece`
--
ALTER TABLE `reference_piece`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reference_piece_position`
--
ALTER TABLE `reference_piece_position`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reference_piece_type`
--
ALTER TABLE `reference_piece_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `retention_tax_type`
--
ALTER TABLE `retention_tax_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule_days_category`
--
ALTER TABLE `schedule_days_category`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `secretary_processes_by_customer_presentation`
--
ALTER TABLE `secretary_processes_by_customer_presentation`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rate_business`
--
ALTER TABLE `shipping_rate_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_rate_services`
--
ALTER TABLE `shipping_rate_services`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `subtipo_medicion_has_equivalencias`
--
ALTER TABLE `subtipo_medicion_has_equivalencias`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax_support`
--
ALTER TABLE `tax_support`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tipo_medida_manager`
--
ALTER TABLE `tipo_medida_manager`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `types_payments_by_account`
--
ALTER TABLE `types_payments_by_account`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT COMMENT 'TYPOS DE PAGOS HAS CUENTA ENTIDAD';

--
-- AUTO_INCREMENT for table `type_ruc`
--
ALTER TABLE `type_ruc`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `universidad_titulos`
--
ALTER TABLE `universidad_titulos`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_by_about_us`
--
ALTER TABLE `users_by_about_us`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_type`
--
ALTER TABLE `voucher_type`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
    `updated_at`   TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET
FOREIGN_KEY_CHECKS=1;



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
