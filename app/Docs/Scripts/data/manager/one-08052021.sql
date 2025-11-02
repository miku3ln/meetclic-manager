-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-05-2021 a las 03:31:22
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
-- Base de datos: `shamuk2`
--

--
-- Volcado de datos para la tabla `business`
--

INSERT INTO `business` (`id`, `description`, `title`, `email`, `page_url`, `phone_value`, `street_1`, `street_2`, `street_lat`, `street_lng`, `user_id`, `business_subcategories_id`, `created_at`, `updated_at`, `deleted_at`, `status`, `qualification`, `source`, `options_map`, `has_document`, `has_about`, `has_service_delivery`, `type_business`, `type_manager_payment`, `business_name`, `keep_accounting`, `type_ruc_id`, `allow_cash_and_banks`, `entity_plans_id`, `entity_position_fiscal_id`, `document`) VALUES
(1, 'Empresa dedicada al desarrollo de software.', 'Meetclic', 'kalexmiguelalba@gmail.com', 'www.meetclic.com', '0985339457', 'Piedrahita y buenos aires', 'Buenos AIRE', 0.231448, -78.2571, 1, 44, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1598107770_Empresa.jpg', NULL, 0, 0, 0, 2, 0, 'Meetclic', 0, 4, 0, 3, 1, '1002954889'),
(2, 'Empresa proveedora de internet', 'ShamukWayra', 'leitolema@gmail.com', 'www.xywer.net', '0997868035', 'Pänamericana Norte', 'Simon Bolivar', 0.23148, -78.2719, 2, 46, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1620530997_996776_943188592437865_7216850729341917623_n.jpg', NULL, 0, 0, 0, 0, 0, '', 0, NULL, 0, 0, 0, '');


--
-- Volcado de datos para la tabla `human_resources_department`
--

INSERT INTO `human_resources_department` (`id`, `name`, `description`, `status`, `business_id`) VALUES
(1, 'Sistemas', '', 'ACTIVE', 1),
(2, 'Marketing', '', 'ACTIVE', 1),
(3, 'Diseño', '', 'ACTIVE', 1),
(4, 'Ventas', '', 'ACTIVE', 1);

--
-- Volcado de datos para la tabla `business_by_counter`
--

INSERT INTO `business_by_counter` (`id`, `count`, `business_id`, `action_name`) VALUES
(1, 4, 1, ''),
(2, 2, 1, 'business'),
(3, 1, 1, 'search'),
(4, 1, 1, 'businessDetails');

--
-- Volcado de datos para la tabla `business_by_history`
--

INSERT INTO `business_by_history` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `author`, `author_titles`, `business_id`, `main`) VALUES
(1, 'Nuestro', '<p>En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e\nimpulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros:\nacadémico, humano y espiritual, nace la Corporación Arrayanes Álamos. Esta es una entidad\nprivada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un\npatrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar\nentidades educativas.\nLa Unidad Educativa Los Arrayanes está ubicada en Ibarra, barrio la Victoria junto al Preescolar\nArrayanes-Álamos y atiende a niñas de segundo de Educación Básica a Tercero de Bachillerato.&nbsp;<br></p>', 'ACTIVE', '/uploads/web/businessByHistory/images/1605047020_3.jpg', 1, 'Historia', '2020-11-10 12:30:50', '2020-11-10 17:23:40', NULL, 'Kathy Gibson', 'Profesora en Psicología & Master en educación por la universidad de Salamanca.', 2, 1),
(2, 'Alamos', '<p>En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e\nimpulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros:\nacadémico, humano y espiritual, nace la Corporación Arrayanes Álamos. Esta es una entidad\nprivada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un\npatrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar\nentidades educativas.\nLa Unidad Educativa Los Arrayanes está ubicada en Ibarra, barrio la Victoria junto al Preescolar\nArrayanes-Álamos y atiende a niñas de segundo de Educación Básica a Tercero de Bachillerato.&nbsp;<br></p>', 'ACTIVE', '/uploads/web/businessByHistory/images/1605050126_a3 (1).jpg', 1, 'Historia', '2020-11-10 18:15:26', '2020-11-10 18:17:48', NULL, 'Alamos', 'Autor Álamos', 3, 1),
(3, 'Preescolar', '<p>En el año 1998, como una iniciativa y el fin de comprometer más a la sociedad en la creación e\nimpulso de centros educativos donde se formen niños y jóvenes bajo tres lineamientos claros:\nacadémico, humano y espiritual, nace la Corporación Arrayanes Álamos. Esta es una entidad\nprivada sin fines de lucro. Se rige por las leyes ecuatorianas y sus estatutos. Cuenta con un\npatrimonio propio y una estructura orgánica, funcional permanente, para auspiciar y desarrollar\nentidades educativas.\nEl Preescolar Arrayanes Álamos está ubicado en la ciudad de Ibarra, barrio la Victoria y atiende a\nniños y niñas de 1 a 5 años.&nbsp;<br></p>', 'ACTIVE', '/uploads/web/businessByHistory/images/1605052110_b3.jpg', 1, 'Historia', '2020-11-10 18:48:30', '2020-11-10 18:48:36', NULL, 'Preescolar', 'Historia', 4, 1);

--
-- Volcado de datos para la tabla `business_by_information_custom`
--

INSERT INTO `business_by_information_custom` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Mision', '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\">At Jonathan Carroll, we view college as a time for students to explore, exercise curiosity, and discover new interests and abilities.</p><p style=\"margin: 11px 0px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\">We provide students with an immersive, collaborative, and inspiring environment where they can develop a broadly informed, highly disciplined intellect that will help them be successful in whatever work they finally choose.</p><p style=\"margin: 11px 0px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\">Our students graduate with the values and knowledge they need to pursue meaningful work, find passion in life-long learning, and lead successful and purposeful lives.</p>', 'ACTIVE', '/uploads/web/BusinessByInformationCustom/images/1605540100_academics-01-770x480.jpg', 1, 'Undergraduate Study', '2020-11-10 14:14:41', '2020-11-16 10:21:40', NULL, 2),
(2, 'Graduate & Professional Study', '<div class=\"offset-lg-top-60\" style=\"margin-top: 60px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px;\"><p style=\"margin-right: 0px; margin-left: 0px;\">Jonathan Carroll University offers advanced degrees through its Graduate School of Arts &amp; Sciences and 12 professional schools. Browse the organizations below for information on programs of study, academic requirements, and faculty research.</p><div><br></div></div>', 'ACTIVE', 'null', 0, 'Graduate & Professional Study', '2020-11-10 14:14:52', '2020-11-16 10:22:08', NULL, 2),
(3, 'Misión', '<p>Somos una institución educativa referente en proyectos educativos innovadores, con virtudes</p><p>humanas y cristianas que busquen la verdad y desarrollen valores de libertad, responsabilidad,</p><p>fortaleza, solidaridad y tolerancia para crear un mundo más justo y solidario, asumiendo los retos</p><p>de la modernidad.</p><div><br></div>', 'ACTIVE', 'null', 0, 'Somos una institución educativa referente en proyectos educativos innovadores, con virtudes\nhumanas y cristianas que busquen la verdad y desarrollen valores de libertad, responsabilidad,\nfortaleza, solidaridad y tolerancia para crear un mundo más justo y solidario, asumiendo los retos\nde la modernidad.', '2020-11-10 18:20:47', '2020-11-10 18:20:47', NULL, 3),
(4, 'Visión', 'Promover el aprendizaje activo mediante la elaboración de proyectos que dan respuesta a<div>problemas de la vida real, pero además, la adquisición de valores de relación social vinculados a las</div><div>prácticas de la solidaridad y ayuda mutua por medio del trabajo colaborativo.</div>', 'ACTIVE', 'null', 0, 'Promover el aprendizaje activo mediante la elaboración de proyectos que dan respuesta a\nproblemas de la vida real, pero además, la adquisición de valores de relación social vinculados a las\nprácticas de la solidaridad y ayuda mutua por medio del trabajo colaborativo.', '2020-11-10 18:21:05', '2020-11-10 18:21:39', NULL, 3),
(5, 'EDUCACIÓN EN VIRTUDES HUMANAS', '<p>Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El\nobjetivo es formar alumnas cultas que además sean respetuosas, responsables, buenas\nciudadanas, con valores humanos y cristianos. La educación de la afectividad se realiza a través del\nprograma Aprender Amar, cuya finalidad es la formación integral de los alumnos en el ámbito de\nla sexualidad para la familia y la vida.&nbsp;<br></p>', 'ACTIVE', 'null', 0, 'Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El\nobjetivo es formar alumnas cultas que además sean respetuosas, responsables, buenas\nciudadanas, con valores humanos y cristianos. La educación de la afectividad se realiza a través del\nprograma Aprender Amar, cuya finalidad es la formación integral de los alumnos en el ámbito de\nla sexualidad para la familia y la vida.', '2020-11-10 18:21:27', '2020-11-10 18:21:27', NULL, 3),
(6, 'SERVICIO A LA COMUNIDAD', '<p>Participación de los estudiantes en el programa denominado Visitas de Solidaridad que se realiza\ndurante todo el año lectivo. Se visitan centros infantiles, asilos, albergues, centros de educación\nespecial. El objetivo principal es sensibilizar sobre las necesidades de los demás y promover la\nvocación de servicio<br></p>', 'ACTIVE', 'null', 0, 'Participación de los estudiantes en el programa denominado Visitas de Solidaridad que se realiza\ndurante todo el año lectivo. Se visitan centros infantiles, asilos, albergues, centros de educación\nespecial. El objetivo principal es sensibilizar sobre las necesidades de los demás y promover la\nvocación de servicio', '2020-11-10 18:21:57', '2020-11-10 18:21:57', NULL, 3),
(7, 'Misión', '<div>English learning begins at an early age. The youngest students are taught through a system that</div><div>has been designed to cover the basics required to start the second language acquisition process.</div><div>An international program developed by a team of experts is used to teach students older than 3</div><div>year old.</div>', 'ACTIVE', 'null', 0, 'Misión', '2020-11-10 18:58:58', '2020-11-16 15:16:53', NULL, 4),
(8, 'Visión', '<p>Los primeros años de un niño ofrecen períodos sensitivos importantes para aprovechar al máximo\nsus capacidades mentales y físicas. El programa de estimulación temprana se lleva a cabo a través\nde actividades estimulantes que ayudan al niño a desarrollar autonomía e independencia, así\ncomo su psicomotricidad, habilidades cognitivas, sensoriales y de lenguaje.&nbsp;<br></p>', 'ACTIVE', 'null', 0, 'Los primeros años de un niño ofrecen períodos sensitivos importantes para aprovechar al máximo\nsus capacidades mentales y físicas. El programa de estimulación temprana se lleva a cabo a través\nde actividades estimulantes que ayudan al niño a desarrollar autonomía e independencia, así\ncomo su psicomotricidad, habilidades cognitivas, sensoriales y de lenguaje.', '2020-11-10 18:59:12', '2020-11-10 18:59:12', NULL, 4),
(9, 'PROGRAMA NEUROMOTOR', '<p>El adecuado Desarrollo psicomotriz ayuda a conseguir una correcta organización neurológica y\nevitar problemas educativos. El programa neuromotor estimula la correcta maduración del\nsistema nervioso y la formación y consolidación de circuitos neuronales. Diariamente se trabajan\nejercicios motores programados y secuenciados.<br></p>', 'ACTIVE', 'null', 0, 'El adecuado Desarrollo psicomotriz ayuda a conseguir una correcta organización neurológica y\nevitar problemas educativos. El programa neuromotor estimula la correcta maduración del\nsistema nervioso y la formación y consolidación de circuitos neuronales. Diariamente se trabajan\nejercicios motores programados y secuenciados.', '2020-11-10 18:59:57', '2020-11-10 18:59:57', NULL, 4),
(10, 'TECNOLOGÍA EN EL AULA', '<p>Todas las aulas están equipadas con pantallas interactivas y sistemas de audio para el trabajo\ndiario. El proceso de alfabetización digital empieza con los alumnos menores quienes\nposteriormente alcanzarán destrezas relacionadas con las TICS: conocimiento de la tecnología,\ncompetencia lingüística y extralingüística y capacidad crítica.<br></p>', 'ACTIVE', 'null', 0, 'Todas las aulas están equipadas con pantallas interactivas y sistemas de audio para el trabajo\ndiario. El proceso de alfabetización digital empieza con los alumnos menores quienes\nposteriormente alcanzarán destrezas relacionadas con las TICS: conocimiento de la tecnología,\ncompetencia lingüística y extralingüística y capacidad crítica.', '2020-11-10 19:00:19', '2020-11-10 19:00:19', NULL, 4),
(11, 'EDUCACIÓN EN VIRTUDES', '<p>Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El\nobjetivo es formar a estudiantes que sean respetuosos, responsables, colaboradores, buenos\nciudadanos, con valores humanos y cristianos, que posean habilidades para vivir esos valores en la\ncotidianidad.&nbsp;<br></p>', 'ACTIVE', 'null', 0, 'Educar es más que enseñar habilidades intelectuales; es formar a la persona en su totalidad. El\nobjetivo es formar a estudiantes que sean respetuosos, responsables, colaboradores, buenos\nciudadanos, con valores humanos y cristianos, que posean habilidades para vivir esos valores en la\ncotidianidad.', '2020-11-10 19:00:40', '2020-11-10 19:00:40', NULL, 4);

--
-- Volcado de datos para la tabla `business_by_language`
--

INSERT INTO `business_by_language` (`id`, `language_id`, `business_id`, `state`, `main`) VALUES
(1, 1, 1, 'ACTIVE', 0),
(2, 2, 1, 'ACTIVE', 0),
(3, 3, 1, 'ACTIVE', 1);

--
-- Volcado de datos para la tabla `business_by_partner_companies`
--

INSERT INTO `business_by_partner_companies` (`id`, `value`, `description`, `status`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'NN', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049312_154887017945653869.png', 1, 'NN', '2020-11-10 18:01:52', '2020-11-10 18:01:52', NULL, 2),
(2, 'NN', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049339_1526575596947917524.png', 1, 'NN', '2020-11-10 18:02:19', '2020-11-10 18:02:19', NULL, 2),
(3, 'NN', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049357_15265756091278493406.png', 1, 'nn', '2020-11-10 18:02:37', '2020-11-10 18:02:37', NULL, 2),
(4, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049368_1526575623212107247.png', 1, 'nn', '2020-11-10 18:02:48', '2020-11-10 18:02:48', NULL, 2),
(5, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049383_15265756521297947374.png', 1, 'nn', '2020-11-10 18:03:03', '2020-11-10 18:03:03', NULL, 2),
(6, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049396_1526575662832922103.png', 1, 'nn', '2020-11-10 18:03:16', '2020-11-10 18:03:16', NULL, 2),
(7, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049406_1526575671625363269.png', 1, 'nn', '2020-11-10 18:03:26', '2020-11-10 18:03:26', NULL, 2),
(8, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049415_1528997740938585027.png', 1, 'nn', '2020-11-10 18:03:35', '2020-11-10 18:03:35', NULL, 2),
(9, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049426_15289979531424547781.png', 1, 'nn', '2020-11-10 18:03:46', '2020-11-10 18:03:46', NULL, 2),
(10, 'nn', 'null', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605049437_15488708921060058771.png', 1, 'nn', '2020-11-10 18:03:57', '2020-11-10 18:03:57', NULL, 2),
(11, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051167_154887017945653869.png', 1, 'nn', '2020-11-10 18:32:47', '2020-11-10 18:32:47', NULL, 3),
(12, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051178_1526575596947917524.png', 1, 'nn', '2020-11-10 18:32:58', '2020-11-10 18:32:58', NULL, 3),
(13, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051189_15265756091278493406.png', 1, 'nn', '2020-11-10 18:33:09', '2020-11-10 18:33:09', NULL, 3),
(14, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051204_1526575623212107247.png', 1, 'nn', '2020-11-10 18:33:24', '2020-11-10 18:33:24', NULL, 3),
(15, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051220_15265756521297947374.png', 1, 'nnn', '2020-11-10 18:33:40', '2020-11-10 18:33:40', NULL, 3),
(16, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051235_1526575662832922103.png', 1, 'nn', '2020-11-10 18:33:55', '2020-11-10 18:33:55', NULL, 3),
(17, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051247_1526575671625363269.png', 1, 'nn', '2020-11-10 18:34:07', '2020-11-10 18:34:07', NULL, 3),
(18, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051258_1528997740938585027.png', 1, 'nn', '2020-11-10 18:34:18', '2020-11-10 18:34:18', NULL, 3),
(19, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051272_15289979531424547781.png', 1, 'nn', '2020-11-10 18:34:32', '2020-11-10 18:34:32', NULL, 3),
(20, 'nn', '<p>nn</p>', 'ACTIVE', '/uploads/web/BusinessByPartnerCompanies/images/1605051286_15488708921060058771.png', 1, 'nn', '2020-11-10 18:34:46', '2020-11-10 18:34:46', NULL, 3);

--
-- Volcado de datos para la tabla `business_by_products`
--

INSERT INTO `business_by_products` (`id`, `business_id`, `products_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

--
-- Volcado de datos para la tabla `business_by_services`
--

INSERT INTO `business_by_services` (`id`, `product_id`, `business_id`, `accounting_account_id`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1);

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
(12, 0, 0, 2, 'ACTIVE', 1),
(13, 0, 0, 2, 'ACTIVE', 2),
(14, 0, 0, 2, 'ACTIVE', 3),
(15, 0, 0, 2, 'ACTIVE', 4),
(16, 0, 0, 2, 'ACTIVE', 5),
(17, 0, 0, 2, 'ACTIVE', 6),
(18, 0, 0, 2, 'ACTIVE', 7);

--
-- Volcado de datos para la tabla `business_counter_custom`
--

INSERT INTO `business_counter_custom` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_id`) VALUES
(1, 'Cifras', '<p>Cifras de este anio 2020</p>', 'ACTIVE', '2020-11-10 12:33:07', '2020-11-10 12:33:07', NULL, 2),
(2, 'Counters Alamos', 'null', 'ACTIVE', '2020-11-10 18:22:35', '2020-11-10 18:22:35', NULL, 3),
(3, 'Counters Preescolar', 'null', 'ACTIVE', '2020-11-10 18:48:50', '2020-11-10 18:48:50', NULL, 4);

--
-- Volcado de datos para la tabla `business_counter_custom_by_data`
--

INSERT INTO `business_counter_custom_by_data` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `business_counter_custom_id`, `count`, `count_percentage`, `count_symbol`) VALUES
(1, '<p>Graduados</p>', '<p>Graduado</p>', 'ACTIVE', '2020-11-10 12:33:26', '2020-11-10 17:26:21', NULL, 1, 95, 95, '%'),
(2, '<p>Egresados</p>', 'null', 'ACTIVE', '2020-11-10 12:33:39', '2020-11-10 17:25:51', NULL, 1, 96.22, 96.22, '%'),
(3, '<p>Posgrados</p>', 'null', 'ACTIVE', '2020-11-10 12:33:50', '2020-11-10 17:27:14', NULL, 1, 32, 32, '%'),
(4, '<p>Universidades Extranjeras</p>', 'null', 'ACTIVE', '2020-11-10 12:34:02', '2020-11-10 17:27:50', NULL, 1, 28, 28, '%'),
(5, '<p>Egresados</p>', '<p><span style=\"font-size: 14.4px;\">Egresados</span><br></p>', 'ACTIVE', '2020-11-10 18:22:57', '2020-11-10 18:22:57', NULL, 2, 96, 96, '%'),
(6, '<p>Graduados</p>', '<p><span style=\"font-size: 14.4px;\">Graduados</span><br></p>', 'ACTIVE', '2020-11-10 18:23:15', '2020-11-10 18:23:15', NULL, 2, 95, 95, '%'),
(7, '<p>Posgrados</p>', '<p><span style=\"font-size: 14.4px;\">Posgrados</span><br></p>', 'ACTIVE', '2020-11-10 18:23:35', '2020-11-10 18:23:35', NULL, 2, 32, 32, '%'),
(8, '<p>Extranjeros</p>', '<p><span style=\"font-size: 14.4px;\">Extranjeros</span><br></p>', 'ACTIVE', '2020-11-10 18:24:04', '2020-11-10 18:24:04', NULL, 2, 28, 28, '%'),
(9, '<p><span style=\"font-size: 14.4px;\">Egresados</span></p>', '<p>Egreados</p>', 'ACTIVE', '2020-11-10 18:49:18', '2020-11-10 18:49:18', NULL, 3, 96, 96, '%'),
(10, '<p>Graduados</p>', '<p>Graduados</p>', 'ACTIVE', '2020-11-10 18:49:59', '2020-11-10 18:49:59', NULL, 3, 95, 95, '%'),
(11, '<p>Posgrados</p>', '<p>Posgrados</p>', 'ACTIVE', '2020-11-10 18:50:24', '2020-11-10 18:50:24', NULL, 3, 32, 32, '%'),
(12, '<p>Extranjeros</p>', '<p><span style=\"font-size: 14.4px;\">Extranjeros</span><br></p>', 'ACTIVE', '2020-11-10 18:50:43', '2020-11-10 18:50:43', NULL, 3, 28, 28, '%');

--
-- Volcado de datos para la tabla `business_disbursement`
--

INSERT INTO `business_disbursement` (`id`, `business_id`, `bank_id`, `account_number`, `type_account`) VALUES
(1, 1, 1, '2201497611', 0),
(2, 2, 4, '00096', 1);

--
-- Volcado de datos para la tabla `business_history_by_data`
--

INSERT INTO `business_history_by_data` (`id`, `title`, `description`, `status`, `source`, `allow_source`, `business_by_history_id`, `title_icon`) VALUES
(1, '<p>Imagi</p>', '<p>adad</p>', 'ACTIVE', '/uploads/web/news-data/images/1605029481_4c5adfbe5fded8b97cf6e2f958ba-1568083.jpg', 1, 1, 'none'),
(2, '<p>ad</p>', '<p>ad</p>', 'ACTIVE', '/uploads/web/news-data/images/1605029500_20191202172345-regalos-clientes.jpeg', 1, 1, 'none');

--
-- Volcado de datos para la tabla `business_location`
--

INSERT INTO `business_location` (`id`, `zones_id`, `business_id`) VALUES
(1, 2, 1),
(2, 5, 2);


--
-- Volcado de datos para la tabla `counter_by_entity`
--

INSERT INTO `counter_by_entity` (`id`, `business_by_counter_id`, `created_at`, `updated_at`, `deleted_at`, `is_guess`, `user_id`, `token`, `manager_click_type`, `manager_click_id`, `action_name`) VALUES
(1, 1, '2021-04-14 23:48:12', '2021-04-14 23:48:12', NULL, 1, 0, 'xiXMP4eSV26nOp3uXFZTotn7yzGX6dsnJmlua4BG', 'NONE', 'NONE', ''),
(2, 2, '2021-04-14 23:48:58', '2021-04-14 23:48:58', NULL, 0, 1, '0li0uOGmwdxcxPLs9x7d05jJvAnu2AveUuJis9Ot', 'NONE', 'NONE', 'business'),
(3, 1, '2021-04-14 23:50:44', '2021-04-14 23:50:44', NULL, 0, 1, '0li0uOGmwdxcxPLs9x7d05jJvAnu2AveUuJis9Ot', 'NONE', 'NONE', ''),
(4, 1, '2021-04-15 00:03:13', '2021-04-15 00:03:13', NULL, 1, 0, 'ZN6n5QVQWdZVH9nOJdCpTwmU57NS2SklI73xc3uP', 'NONE', 'NONE', ''),
(5, 3, '2021-04-15 00:03:38', '2021-04-15 00:03:38', NULL, 1, 0, 'ZN6n5QVQWdZVH9nOJdCpTwmU57NS2SklI73xc3uP', 'NONE', 'NONE', 'search'),
(6, 4, '2021-04-15 00:03:44', '2021-04-15 00:03:44', NULL, 1, 0, 'ZN6n5QVQWdZVH9nOJdCpTwmU57NS2SklI73xc3uP', 'NONE', 'NONE', 'businessDetails'),
(7, 1, '2021-04-16 15:29:54', '2021-04-16 15:29:54', NULL, 1, 0, 'TEiuOobIj820vGXo6XCoJEmSBH9dPMrQUS8xLNO8', 'NONE', 'NONE', ''),
(8, 2, '2021-05-09 03:14:43', '2021-05-09 03:14:43', NULL, 0, 2, 'sfgxDAWpQq1DJRWsL9ISoo7vZpE6tlloEsBXvw4H', 'NONE', 'NONE', 'business');

--
-- Volcado de datos para la tabla `counter_by_log_user_to_business`
--

INSERT INTO `counter_by_log_user_to_business` (`id`, `created_at`, `updated_at`, `deleted_at`, `business_id`, `user_id`, `is_guess`, `manager_click_type`, `manager_click_id`, `action_name`) VALUES
(1, '2021-04-14 23:48:12', '2021-04-14 23:48:12', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
(2, '2021-04-14 23:48:58', '2021-04-14 23:48:58', NULL, 1, 1, 0, 'NONE', 'NONE', 'business'),
(3, '2021-04-14 23:50:44', '2021-04-14 23:50:44', NULL, 1, 1, 0, 'NONE', 'NONE', ''),
(4, '2021-04-14 23:51:04', '2021-04-14 23:51:04', NULL, 1, 1, 0, 'NONE', 'NONE', ''),
(5, '2021-04-14 23:52:46', '2021-04-14 23:52:46', NULL, 1, 1, 0, 'NONE', 'NONE', ''),
(6, '2021-04-15 00:03:13', '2021-04-15 00:03:13', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
(7, '2021-04-15 00:03:39', '2021-04-15 00:03:39', NULL, 1, 0, 1, 'NONE', 'NONE', 'search'),
(8, '2021-04-15 00:03:44', '2021-04-15 00:03:44', NULL, 1, 0, 1, 'NONE', 'NONE', 'businessDetails'),
(9, '2021-04-15 00:03:53', '2021-04-15 00:03:53', NULL, 1, 0, 1, 'NONE', 'NONE', 'businessDetails'),
(10, '2021-04-15 00:18:51', '2021-04-15 00:18:51', NULL, 1, 1, 0, 'NONE', 'NONE', ''),
(11, '2021-04-16 15:29:54', '2021-04-16 15:29:54', NULL, 1, 0, 1, 'NONE', 'NONE', ''),
(12, '2021-05-09 03:14:43', '2021-05-09 03:14:43', NULL, 1, 2, 0, 'NONE', 'NONE', 'business'),
(13, '2021-05-09 03:16:55', '2021-05-09 03:16:55', NULL, 1, 2, 0, 'NONE', 'NONE', 'business'),
(14, '2021-05-09 03:18:56', '2021-05-09 03:18:56', NULL, 1, 2, 0, 'NONE', 'NONE', 'business'),
(15, '2021-05-09 03:26:24', '2021-05-09 03:26:24', NULL, 1, 2, 0, 'NONE', 'NONE', 'business');


--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `identification_document`, `src`, `people_type_identification_id`, `people_id`, `business_name`, `business_reason`, `ruc_type_id`, `has_representative`, `representative_fullname`) VALUES
(1, '0401315379', NULL, 2, 13, '', '', 4, 0, NULL),
(2, '1002944468', NULL, 2, 24, '', '', 4, 0, NULL),
(3, '1003731542', NULL, 2, 26, '', '', 4, 0, NULL),
(4, '1002138707', NULL, 2, 27, '', '', 4, 0, NULL),
(5, '1003460456', NULL, 2, 28, '', '', 4, 0, NULL),
(6, '1050087418', NULL, 2, 29, '', '', 4, 0, NULL),
(7, '1102715701', NULL, 2, 30, '', '', 4, 0, NULL),
(8, '1002619946', NULL, 2, 37, '', '', 4, 0, NULL),
(9, '1002497236', NULL, 2, 55, '', '', 4, 0, NULL),
(10, '1005137011', NULL, 2, 56, '', '', 4, 0, NULL),
(11, '1050312261', NULL, 2, 65, '', '', 4, 0, NULL),
(12, '1003971072', NULL, 2, 66, '', '', 4, 0, NULL),
(13, '1003263892', NULL, 2, 67, '', '', 4, 0, NULL),
(14, '1004647614', NULL, 2, 69, '', '', 4, 0, NULL),
(15, '1050085776', NULL, 2, 70, '', '', 4, 0, NULL),
(16, '1003312939', NULL, 2, 71, '', '', 4, 0, NULL),
(17, '1003599022', NULL, 2, 72, '', '', 4, 0, NULL),
(18, '1004995385', NULL, 2, 75, '', '', 4, 0, NULL),
(19, '1001497161', NULL, 2, 76, '', '', 4, 0, NULL),
(20, '1002751574', NULL, 2, 77, '', '', 4, 0, NULL),
(21, '1050619475', NULL, 2, 78, '', '', 4, 0, NULL),
(22, '1004203863', NULL, 2, 79, '', '', 4, 0, NULL),
(23, '1002505855', NULL, 2, 89, '', '', 4, 0, NULL),
(24, '1003484597', NULL, 2, 90, '', '', 4, 0, NULL),
(25, '1004355481', NULL, 2, 91, '', '', 4, 0, NULL),
(26, '1003858113', NULL, 2, 92, '', '', 4, 0, NULL),
(27, '1005399546', NULL, 2, 93, '', '', 4, 0, NULL),
(28, '1004155758', NULL, 2, 94, '', '', 4, 0, NULL),
(29, '1003400965', NULL, 2, 95, '', '', 4, 0, NULL),
(30, '1003122320', NULL, 2, 96, '', '', 4, 0, NULL),
(31, '1002903738', NULL, 2, 97, '', '', 4, 0, NULL),
(32, '1004124390', NULL, 2, 98, '', '', 4, 0, NULL),
(33, '1000775815', NULL, 2, 99, '', '', 4, 0, NULL),
(34, '1717159089', NULL, 2, 100, '', '', 4, 0, NULL),
(35, '1204962599', NULL, 2, 101, '', '', 4, 0, NULL),
(36, '1003140066', NULL, 2, 102, '', '', 4, 0, NULL),
(37, '1002321584', NULL, 2, 103, '', '', 4, 0, NULL),
(38, '1002345419', NULL, 2, 104, '', '', 4, 0, NULL),
(39, '1004476659', NULL, 2, 105, '', '', 4, 0, NULL),
(40, '1002655361', NULL, 2, 110, '', '', 4, 0, NULL),
(41, '1003932363', NULL, 2, 111, '', '', 4, 0, NULL),
(42, '1001996642', NULL, 2, 112, '', '', 4, 0, NULL),
(43, '1003646161', NULL, 2, 113, '', '', 4, 0, NULL),
(44, '1003478664', NULL, 2, 114, '', '', 4, 0, NULL),
(45, '1050112547', NULL, 2, 115, '', '', 4, 0, NULL),
(46, '1755192422', NULL, 2, 116, '', '', 4, 0, NULL),
(47, '1003230792', NULL, 2, 117, '', '', 4, 0, NULL),
(48, '1004732846', NULL, 2, 118, '', '', 4, 0, NULL),
(49, '1004929467', NULL, 2, 119, '', '', 4, 0, NULL),
(50, '1003076328', NULL, 2, 120, '', '', 4, 0, NULL),
(51, '1003416383', NULL, 2, 121, '', '', 4, 0, NULL),
(52, '1003239298', NULL, 2, 122, '', '', 4, 0, NULL),
(53, '1003003306', NULL, 2, 123, '', '', 4, 0, NULL),
(54, '1003274030', NULL, 2, 124, '', '', 4, 0, NULL),
(55, '1004443436', NULL, 2, 125, '', '', 4, 0, NULL),
(56, '1003394739', NULL, 2, 128, '', '', 4, 0, NULL),
(57, '1004733604', NULL, 2, 129, '', '', 4, 0, NULL),
(58, '1002073748', NULL, 2, 130, '', '', 4, 0, NULL),
(59, '1001974045', NULL, 2, 138, '', '', 4, 0, NULL),
(60, '1002250627', NULL, 2, 139, '', '', 4, 0, NULL),
(61, '1001140209', NULL, 2, 140, '', '', 4, 0, NULL),
(62, '1004995922', NULL, 2, 141, '', '', 4, 0, NULL),
(63, '1003433263', NULL, 2, 142, '', '', 4, 0, NULL),
(64, '1003271614', NULL, 2, 143, '', '', 4, 0, NULL),
(65, '1004233597', NULL, 2, 144, '', '', 4, 0, NULL),
(66, '1050108743', NULL, 2, 145, '', '', 4, 0, NULL),
(67, '0401595475', NULL, 2, 146, '', '', 4, 0, NULL),
(68, '1001138922', NULL, 2, 151, '', '', 4, 0, NULL),
(69, '1002465266', NULL, 2, 152, '', '', 4, 0, NULL),
(70, '1004189518', NULL, 2, 153, '', '', 4, 0, NULL),
(71, '1001828902', NULL, 2, 154, '', '', 4, 0, NULL),
(72, '1003793419', NULL, 2, 155, '', '', 4, 0, NULL),
(73, '1001881810', NULL, 2, 156, '', '', 4, 0, NULL),
(74, '1004090211', NULL, 2, 157, '', '', 4, 0, NULL),
(75, '1002498457', NULL, 2, 158, '', '', 4, 0, NULL),
(76, '1002843603', NULL, 2, 159, '', '', 4, 0, NULL),
(77, '1050452117', NULL, 2, 160, '', '', 4, 0, NULL),
(78, '1004719181', NULL, 2, 161, '', '', 4, 0, NULL),
(79, '1002811964', NULL, 2, 162, '', '', 4, 0, NULL),
(80, '1005020050', NULL, 2, 163, '', '', 4, 0, NULL),
(81, '1001455409', NULL, 2, 164, '', '', 4, 0, NULL),
(82, '1003267596', NULL, 2, 196, '', '', 4, 0, NULL),
(83, '1005097033', NULL, 2, 200, '', '', 4, 0, NULL),
(84, '1005024631', NULL, 2, 202, '', '', 4, 0, NULL),
(85, '1004022255', NULL, 2, 208, '', '', 4, 0, NULL);

--
-- Volcado de datos para la tabla `customer_by_information`
--

INSERT INTO `customer_by_information` (`id`, `customer_id`, `people_nationality_id`, `people_profession_id`) VALUES
(1, 1, 18, 1),
(2, 2, 18, 56),
(3, 3, 18, 56),
(4, 4, 18, 56),
(5, 5, 18, 48),
(6, 6, 18, 56),
(7, 7, 18, 56),
(8, 8, 18, 56),
(9, 9, 18, 56),
(10, 10, 18, 56),
(11, 11, 18, 56),
(12, 12, 18, 56),
(13, 13, 18, 56),
(14, 14, 18, 56),
(15, 15, 18, 1),
(16, 16, 18, 56),
(17, 17, 18, 1),
(18, 18, 18, 1),
(19, 19, 71, 56),
(20, 20, 18, 56),
(21, 21, 18, 56),
(22, 22, 18, 48),
(23, 23, 18, 50),
(24, 24, 18, 56),
(25, 25, 18, 44),
(26, 26, 18, 48),
(27, 27, 18, 48),
(28, 28, 18, 48),
(29, 29, 18, 56),
(30, 30, 18, 1),
(31, 31, 18, 49),
(32, 32, 18, 1),
(33, 33, 18, 56),
(34, 34, 18, 56),
(35, 35, 18, 48),
(36, 36, 18, 56),
(37, 37, 18, 3),
(38, 38, 18, 1),
(39, 39, 18, 44),
(40, 40, 18, 44),
(41, 41, 71, 1),
(42, 42, 18, 56),
(43, 43, 18, 49),
(44, 44, 18, 3),
(45, 45, 18, 56),
(46, 46, 13, 23),
(47, 47, 18, 23),
(48, 48, 18, 48),
(49, 49, 18, 48),
(50, 50, 18, 49),
(51, 51, 18, 49),
(52, 52, 18, 48),
(53, 53, 18, 3),
(54, 54, 18, 56),
(55, 55, 18, 1),
(56, 56, 18, 3),
(57, 57, 71, 1),
(58, 58, 18, 56),
(59, 59, 18, 14),
(60, 60, 18, 56),
(61, 61, 18, 1),
(62, 62, 18, 48),
(63, 63, 18, 49),
(64, 64, 18, 23),
(65, 65, 18, 48),
(66, 66, 18, 48),
(67, 67, 18, 14),
(68, 68, 18, 23),
(69, 69, 18, 49),
(70, 70, 18, 56),
(71, 71, 18, 56),
(72, 72, 18, 56),
(73, 73, 18, 56),
(74, 74, 18, 56),
(75, 75, 18, 56),
(76, 76, 18, 56),
(77, 77, 18, 56),
(78, 78, 18, 56),
(79, 79, 18, 56),
(80, 80, 18, 56),
(81, 81, 18, 1),
(82, 82, 18, 1),
(83, 83, 18, 1),
(84, 84, 18, 1),
(85, 85, 18, 1);

--
-- Volcado de datos para la tabla `information_address`
--

INSERT INTO `information_address` (`id`, `street_one`, `street_two`, `reference`, `state`, `entity_id`, `main`, `entity_type`, `information_address_type_id`, `has_location`, `options_map`, `country_code_id`, `administrative_area_level_2`, `administrative_area_level_1`, `administrative_area_level_3`) VALUES
(1, 'CALLE SION BOLIVAR, CAMINO VIEJO  EUJENIO ESPEJO , OTAVALO ,IMABURA', 'CAMINO VIEJO', 'UBUCACION , EUJENIO ESPEJO ,  APOCOS PASOS DE LA IGLESIA EVANGELICA ISRAEL , VECINO DE ROLANDO \nPLAN RECIDENCIAL DE 21 USD , PLAN RECIDENCIAL, \nPAGOS 1 AL 5 DE CADA MES \nFECHA DE CONECCION 24 DE AGOSTO 2020\nPAGO DE EQUIPOS A PROPIEDAD SUYA VALOR 105 USD  , PAGADO AL COMPLETO \nSECTORIAL 11 LITE BEAN', 'ACTIVE', 1, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(2, 'PUERTO LAGO , CAMINO VIEJO', 'SN', 'UBICACION PUERTO LAGO ,POR EL CAMINO VIEJO QUE  DA ALA LAGUNA A POCOS METROS DE LA FAMILIA CAHUASQUI \nPLAN RECIDENCIAL , DE 21 USD \nVALOR DE EQUIPOS 105 USD , PAGADO AL CONTADO EQUIPOS A PROPIEDAD SUYA \nDIAS DE PAGO DEL 1 AL 5 DE CADA MES \nFECHA DE CONECCION 1 DE JULIO 2020', 'ACTIVE', 2, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.20461508929492941,\"lng\":-78.2390437616577}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(3, 'CHUCHUQUI', 'S/N', 'UBICACION. COMUNIDAD CHUCHUQUI- CASA CABAÑA\nFECHA DE INSTALACION : 17 -08-2020\nPLAN RESIDENCIAL DE 21.00\nEQUIPOS: VALOR 105 USD - (PAGO COMPLETO)\nPAGOS : DEL 1 AL 5 DE CADA MES', 'ACTIVE', 3, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(4, 'COMPANIA SECTOR 2', 'S/N', 'UBICACION : COMPANIA SECTOR 2\nPAGO DE RECONEXION 10 USD (EQUIPOS PROPIOS \nVALOR 0 USD\nPLAN RESIDENCIAL 21.00\nFECHA DE CONEXION: \nPAGOS DEL 1-AL 5 DE CADA MES\nTELEFONO: 0968243636', 'ACTIVE', 4, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(5, 'HUACSARA', 'S/N', 'UBICACION : HUACSARA, CERCA A FERRETERIA PASTOR \nPAGO DE EQUIPOS: 50% (55 USD - PENDIENTE 50)\nVALOR 105 USD\nPLAN RESIDENCIAL 21.00\nFECHA DE CONEXION: 12-11-2020\nPAGOS CADA 15\nTELEFONO: 0980129422', 'ACTIVE', 5, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(6, 'REY LOMA', 'S/N', 'UBICACION : REY LOMA, JUSTO A LA SEPARACION Y (A MANO DERECHA CASA PEQUEÑA)\nPAGO DE EQUIPOS: (PENDIENTE 50 DOLARES ) - ANTENA \nVALOR 80 USD\nPLAN RESIDENCIAL 21.00\nFECHA DE CONEXION: 17-06-2020\nPAGOS DEL 1-AL 5 DE CADA MES\nTELEFONO: 0969120509', 'ACTIVE', 6, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(7, 'huacasara', 'huacsara', 'plan recidecial 21 usd \nnodo mojanda \npaga del 1 al 5 de cada mes\nsector huacsara  eujenio espejo\ncelular 0988251928', 'ACTIVE', 7, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(8, 'pucara de velasquez', 'S/N', 'plan recidencial 21 usd\nplan contratado de 5mbps\nsector pucara de velasquez \nteléfono 0983401019', 'ACTIVE', 8, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(9, 'CAMUENDO', 'SN', 'PLAN RECIDENCIAL DE 21 USD \nEQUIPOS A PROPIEDAD SUYA \nPAGOS DEL 1 AL 5 DE CADA MES \nSECTOR CAMUENDO', 'ACTIVE', 9, 1, 0, 1, 1, '{\"zoom\":17,\"latLng\":{\"lat\":0.21276895060515333,\"lng\":-78.21385245458983}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(10, 'CUCHUQUI', 'sn', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS A PROPIEDAD SUYA ,VALOR 100 USD \nFECHA DE PAGOS DE 1 AL 5 DE CADA MES \nSECTOR CUCHUQUI \nTELEFONO 0969238535', 'ACTIVE', 10, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.19937944983747694,\"lng\":-78.24732642309569}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(11, 'PUERTO ALEGRE , EUJENIO ESPEJO  OTAVALO', 'sn', 'PLAN RECIDENCIAL DE 5MBPS\nEQUIPOS A PROPIEDAD SUYA VALOR 100 USD\nPAGOS DE 1 AL 5 DE CADA MES \nSECTOR PUERTO ALEGRE , OTAVALO\nTELEFONO 0990415254', 'ACTIVE', 11, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20435759886939095,\"lng\":-78.23719840185545}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(12, 'ARAQUE ALTO', 'SN', 'PLAN RECICENCIAL 21 USD \nEQUIPOS A PROPIEDAD SUYA VALOR 100 USD\nDIAS DE PAGO DE 1 AL 5 DE CADA MES \nSECTOR ARAQUE \nTELEFONO', 'ACTIVE', 12, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.20813412469414283,\"lng\":-78.20458274023436}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(13, 'PUCARA DE VELASQUEZ', 'sn', 'PLAN RECIDECIAL DE 21 USD \nPAGA DE 1 AL5 DE CADA MES \nEQUIPOS A PROPIEDAD SUYA VALOR 100USD \nSECTOR PUCARA DE VELASQUEZ', 'ACTIVE', 13, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.22152361794714812,\"lng\":-78.23685507910155}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(14, 'TOCAGON', 'SN', 'PLAN RECIDENCIAL VALOR 21 USD \nPAGA DEL 1 AL5 DE CADA MES \nEQUIPOS A PROPIEDAD SUYA VALOR 100 USD \nSECTOR TOCAGON \nTELEFONO 0991856853', 'ACTIVE', 14, 1, 0, 1, 1, '{\"zoom\":18,\"latLng\":{\"lat\":0.1806684627385664,\"lng\":-78.2234654916992}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(15, 'EUJENIO ESPEJO', 'SN', 'PLAN RECIDENCIAL DE 21 USD \nEQUIPOS PROPIOS VALOR 100 USD \nPAGA DEL 1 AL 5 DE CADA MES \nSECTOR EUGENIO ESPEJO , OTAVALO', 'ACTIVE', 15, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20967906681731166,\"lng\":-78.24990134374998}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(16, 'PUCARA DE VELASQUEZ', 'sn', 'PLAN RECIDENCIA DE 21 USD \nEQUIPOS A PROPIEDAD VALOR 100 USD \nPAGA LOS DIAS 1 AL 5 DE CADA MES \nTELEFONO 0981241164\nSECTOR PUCARA DE VELASQUEZ', 'ACTIVE', 16, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.21826207580545176,\"lng\":-78.23977332250975}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(17, 'pucara de velasquez', 'SN', 'PLAN RECIDENCIAL 21 UDS \nEQUIPOS A PROPIEDAD SUYA  , VALOR 21 USD \nPAGOS DEL 1 AL 5 DE CADA MES \nSECTOR PUCARA DE VELASQUEZ ,', 'ACTIVE', 17, 1, 0, 1, 1, '{\"zoom\":14,\"latLng\":{\"lat\":0.21621645910063708,\"lng\":-78.23967318670653}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(18, 'SAN MIGUEL', 'sn', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS A PROPIEDAD SUYA \nPAGOS DEL 1 AL 5 DE CADA MES \nTELEFONO 0968910035', 'ACTIVE', 18, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.19646122384065903,\"lng\":-78.24269156591795}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(19, 'CALPAQUI ALTO ECUEJENIO ESPEJO', 'sn', 'PLAN RECIDENCIAL DE 21 USD \nEQUIPOS A PROPIEDAD \nTELEFONO 0991540453\nSECTOR CALPAQUI ALTO JUSTO DONDE SE DA LA VUELTA EL BUS \nCASA DE COLOR DE DOS PISOS', 'ACTIVE', 19, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20521590027175038,\"lng\":-78.25367789404295}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(20, 'LA CONPANIA OTAVALO', 'sn', 'PLAN RECIDECIAL DE 21 USD \nEQUIPOS A SU PROPIEDAD\nPAGOS DEL 1 AL 5 DE CADA MES \nSECTOR CONPANIA TIENE UNA TIENDA DE MUEBLES \nTELEFONO 0984758445', 'ACTIVE', 20, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.21912037643806606,\"lng\":-78.21900229589842}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(21, 'BARRIO RUMITOLA - ESQUINA DE LA PANAMERICANA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      BARRIO RUMITOLA - ESQUINA DE PANAMERICANA\nFECHA DE CONEXION  11-03-2021', 'ACTIVE', 21, 1, 0, 1, 1, '{\"zoom\":14,\"latLng\":{\"lat\":0.21079485825594782,\"lng\":-78.25213294165037}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(22, 'PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                     COMUNIDAD PUCARA DE VELASQUEZ CASA ETERNIT - VIDRIOS REFLECTIVOS\nFECHA DE CONEXION  10-03-2021', 'ACTIVE', 22, 1, 0, 1, 1, '{\"zoom\":14,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(23, 'CENSO COPACABANA SUBIENDO POR EL CEMENTERIO', 'SN', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUTA \nSECTOR SENSO COACABANA SUBIENDO POR EL CEMENTERIO \nFECHA DE CONECCION  12 MARZO 2021 \nCONECXION NODO \nTELEFONO 0984056061', 'ACTIVE', 23, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.20315597682907255,\"lng\":-78.25402121679686}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(24, 'COMUNIDAD PUCARA ALTO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA ALTO - POR LA TERCERA CANCHA\nFECHA DE CONEXION  11-03-2021\nTELF.0987159276\nCONEXION NODO', 'ACTIVE', 24, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(25, 'COMUNIDAD 4 ESQUINAS', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD 4 ESQUINAS - IGLESIA\nFECHA DE CONEXION  9-03-2021\nTELF.0979982904\nCONEXION NODO', 'ACTIVE', 25, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(26, 'MOJANDITA DE CALPAQUI', 'SN', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUTYA \nSECTOR  MOJANDITA CALPAQUI\nFECHA DE CONECCION  9 DE MARZO 2021 \nCONECXION NODO \nTELEFONO 0993345883', 'ACTIVE', 26, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2024693356230377,\"lng\":-78.26363425390623}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(27, 'COMUNIDAD CAMUENDO CHICO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CAMUENDO CHICO - SUBIENDO LAS CABAÑAS DEL LAGO\nFECHA DE CONEXION  9-03-2021\nTELF. 0997144568\nCONEXION NODO', 'ACTIVE', 27, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(28, 'COMUNIDAD PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA DE VELASQUEZ\nFECHA DE CONEXION  9-03-2021\nTELF. 0939213137\nCONEXION NODO', 'ACTIVE', 28, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(29, 'EUGENIO ESPEJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - PANAMERICANA\nFECHA DE CONEXION  9-03-2021\nTELF. 0982914314\nCONEXION NODO', 'ACTIVE', 29, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(30, 'CUCHICOLES EUJENIO ESPEJO', 'sn', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUYA  \nSECTOR  ANITUGA CUCHICOLES EUGENIO ESPEJO  \nFECHA DE CONECCION 9 DE MARZO 2021\nCONECXION NODO \nTELEFONO 0941470761', 'ACTIVE', 30, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2151721931239088,\"lng\":-78.25041632788084}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(31, 'COMUNIDAD PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA DE VELASQUEZ A 1 CUADRA DE CANCHA \nFECHA DE CONEXION  9-03-2021\nTELF. 0982542842\nCONEXION NODO', 'ACTIVE', 31, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(32, 'CHUCHQUI SERCA DEL PRIMER TANQUE DE AGUA', 'S-N', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUYA \nSECTOR  CHUCHUQUI SERCA DEL PRIMER TANQUE DE AGUA \nFECHA DE CONECCION \nCONECXION NODO \nTELEFONO 0988631204', 'ACTIVE', 32, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.19817782743038967,\"lng\":-78.24887137548826}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(33, 'EUGENIO ESPEJO CALLE JOSE PUENTE', 'PANAMERICANA NORTE', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - BARRIO JOSE PUENTE\nFECHA DE CONEXION  8-03-2021\nTELF. \nCONEXION NODO', 'ACTIVE', 33, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(34, 'CENSO COPACABANA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CENSO COPACABANA - CASA ANTIGUA MANUEL TAMBACO\nFECHA DE CONEXION  8-03-2021\nTELF. 0992200306\nCONEXION NODO', 'ACTIVE', 34, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(35, 'PUERTO ALEGRE EUGENIO ESPEJO', 'S-N', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUTYA \nSECTOR  PUERTO LAGO JUNTO AL ANOTIO CAUHASQUI \nFECHA DE CONECCION  9 MARZO 2021 \nTELEFONO 0991702777\nCONECCION NODO', 'ACTIVE', 35, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20581671122600215,\"lng\":-78.23900084631346}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(36, 'CALPAQUI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CALPAQUI ALTO - ULTIMA VUELTA DE BUS\nFECHA DE CONEXION  8-03-2021\nTELF. 0980757156\nCONEXION NODO', 'ACTIVE', 36, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(37, 'PUERTO ALEGRE', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUERTO ALEGRE \nFECHA DE CONEXION  11-03-2021\nTELF. 0967380387\nCONEXION NODO', 'ACTIVE', 37, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(38, 'CAMUENDO JUNTO ALA IGLESIA CATOLICA Y CANHCA', 'S-N', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUYA\nSECTOR  CAMUENDO JUNTO ALA IGLESIA CATOLICA\nFECHA DE CONECCION  8 DE MARZO 2021\nTELEFONO 0969641445\nCONECCION NODO', 'ACTIVE', 38, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.21791875553868895,\"lng\":-78.2150540842285}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(39, 'CALPAQUI ALTO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CALPAQUI ALTO, ANTES DEL DESVIO A MOJANDITA\nFECHA DE CONEXION  08-03-2021\nTELF. 0979918636\nCONEXION NODO', 'ACTIVE', 39, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(40, 'BARRIO CRISTAL', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - BARRIO CRISTAL\nFECHA DE CONEXION  8-03-2021\nTELF.\nCONEXION NODO', 'ACTIVE', 40, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(41, 'pucara de velasquez', 'SN', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUTYA \nSECTOR  PUCARA  DE VELASQUEZ \nFECHA DE CONECCION 8 DE MARZO 2021\nTELEFONO 0967389636\nCONECCION NODO', 'ACTIVE', 41, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.22530013952952346,\"lng\":-78.23925833837889}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(42, 'PUERTO ALEGRE', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUERTO ALEGRE\nFECHA DE CONEXION  8-03-2021\nTELF. 0969723670\nCONEXION NODO', 'ACTIVE', 42, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(43, 'TOCAGON', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                     SAN RAFAEL  COMUNIDAD TOCAGON\nFECHA DE CONEXION  8-03-2021\nTELF. 0989476707\nCONEXION NODO', 'ACTIVE', 43, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(44, 'PUERTO ALEGRE', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUERTO ALEGRE\nFECHA DE CONEXION  9-03-2021\nTELF. 0960852834\nCONEXION NODO', 'ACTIVE', 44, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(45, 'SAN MIGUEL', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD SAN MIGUEL BAJO - FRENTE AL ESTADIO DE CUARABURO\nFECHA DE CONEXION  8-03-2021\nTELF.0985552969\nCONEXION NODO', 'ACTIVE', 45, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(46, 'COMUNIDAD HUACSARA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD HUACSARA - CASA DE PISOS\nFECHA DE CONEXION  08-03-2021\nTELF. 0994300605\nCONEXION NODO', 'ACTIVE', 46, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(47, 'CHUCHUQUI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO \nFECHA DE CONEXION  08-03-2021\nTELF. 0981503224\nCONEXION NODO', 'ACTIVE', 47, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(48, 'COMUNIDAD CALPAQUI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CALPAQUI \nFECHA DE CONEXION  8-03-2021\nTELF. 0988072838\nCONEXION NODO', 'ACTIVE', 48, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(49, 'CALUQUI ALTO - ZANJA PATA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PIJAL ALTO - ZANJA PATA \nFECHA DE CONEXION  8-03-2021\nTELF. 0983125556 - 0982723306\nCONEXION NODO', 'ACTIVE', 49, 1, 0, 1, 1, '{\"zoom\":11,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(50, 'COMUNIDAD CAMUENDO CHICO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CAMUENDO CHICO \nFECHA DE CONEXION  08-03-2021\nTELF. 0959787045\nCONEXION NODO', 'ACTIVE', 50, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(51, 'COMUNIDAD SAN MIGUEK BAJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD SAN MIGUEL BAJO \nFECHA DE CONEXION  8-03-2021\nTELF. 0989463937\nCONEXION NODO', 'ACTIVE', 51, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(52, 'COMUNIDAD PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA DE VELASQUEZ \nFECHA DE CONEXION  8-03-2021\nTELF. 0997953238\nCONEXION NODO', 'ACTIVE', 52, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(53, 'EUGENIO ESPEJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - CERCA DEL PUENTE\nFECHA DE CONEXION  13-03-2021\nTELF. 0980882116\nCONEXION NODO', 'ACTIVE', 53, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(54, 'COMUNIDAD PUCARA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA \nFECHA DE CONEXION  8-03-2021\nTELF. 0982682213\nCONEXION NODO', 'ACTIVE', 54, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(55, 'PUCARA DE  VELASQUEZ', 'S-N', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUTYA \nSECTOR  PUCARA DE VELASQUEZ \nFECHA DE CONECCION 10 MARZO 2021 \nTELEFONO\nCONECCION NODO', 'ACTIVE', 55, 1, 0, 1, 1, '{\"zoom\":14,\"latLng\":{\"lat\":0.2244418392552432,\"lng\":-78.23779921667479}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(56, 'MANUEL DIAZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - CALLE MANUEL DIAZ\nFECHA DE CONEXION  8-03-2021\nTELF. 0986499570\nCONEXION NODO', 'ACTIVE', 56, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(57, 'CHUCHUQUI BAJO', 'S-N', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUYA \nSECTOR  CHUCHUQUI \nFECHA DE CONECCION  9 DE MARZO 2021\nTELEFONO 0969479283\nCONECCION NODO', 'ACTIVE', 57, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2033276371260299,\"lng\":-78.24389319555662}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(58, 'CENSO COPACABANA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CENSO COPACABANA CERCA DEL ESTADIO\nFECHA DE CONEXION  08-03-2021\nTELF. 0999588565\nCONEXION NODO', 'ACTIVE', 58, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(59, 'EUGENIO ESPEJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - FRENTE AL GAD PARROQUIAL\nFECHA DE CONEXION  08-03-2021\nTELF. 0988490788\nCONEXION NODO', 'ACTIVE', 59, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(60, 'HUAYCOPUNGO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD HUAYCOPUNGO, CERCA AL ESTADIO\nFECHA DE CONEXION  12-03-2021\nTELF. 0985915915\nCONEXION NODO', 'ACTIVE', 60, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(61, 'CAMUENDO ALTO', 'S-N', 'PLAN RESIDENCIAL 21 USD \nEQUIPOS VALOR 100 USD \nEQUIPOS A PROPIEDAD  SUYA \nSECTOR CAMUENDO A UNOS POCOS PASOS DEL CLUB NAUTICO  \nFECHA DE CONECCION 12 DE MARZO 2021 \nTELEFONO 088657082\nCONECCION NODO', 'ACTIVE', 61, 1, 0, 1, 1, '{\"zoom\":10,\"latLng\":{\"lat\":0.21946369667734889,\"lng\":-78.21179251806639}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(62, '4 ESQUINAS', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD 4 ESQUINAS - TERMINADO EL ADOQUINADO\nFECHA DE CONEXION  11-03-2021\nTELF. 0961827866\nCONEXION NODO', 'ACTIVE', 62, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(63, 'CACHIVIRO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CACHIVIRO \nFECHA DE CONEXION  10-03-2021\nTELF. 0993374271\nCONEXION NODO', 'ACTIVE', 63, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(64, 'CUARABURO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CUARABURO, DETRAS DE IGLESIA\nFECHA DE CONEXION  9-03-2021\nTELF. 0981399811\nCONEXION NODO', 'ACTIVE', 64, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(65, 'HUACSARA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD HUACSARA . BARRIO LOS PINOS - POR LA PRIMERA ENTRADA\nFECHA DE CONEXION  11-03-2021\nTELF. 0994871717\nCONEXION NODO', 'ACTIVE', 65, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(66, 'SAN MIGUEL BAJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD SAN MIGUEL BAJO \nFECHA DE CONEXION  08-03-2021\nTELF. 0967875437\nCONEXION NODO', 'ACTIVE', 66, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(67, 'COPACABANA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD COPACABANA - JUNTO AL BOSQUE \nFECHA DE CONEXION  11-03-2021\nTELF. 0998835917\nCONEXION NODO', 'ACTIVE', 67, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(68, 'CHUCHUQUI ALTO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CHUCHUQUI ALTO, CERCA AL FINALIZAR LA COMUNIDAD\nFECHA DE CONEXION  12-03-2021\nTELF. 0965306352\nCONEXION NODO', 'ACTIVE', 68, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(69, 'CALLE EUGENIO ESPEJO - COMUNIDAD PIVARINCI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PIVARINCI CALLE EUGENIO ESPEJO - ESQUINERA \nFECHA DE CONEXION  11-03-2021\nTELF.  0981661903\nCONEXION NODO', 'ACTIVE', 69, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(70, 'CACHIVIRO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CACHIVIRO - FERRETERIA\nFECHA DE CONEXION  8-03-2021\nTELF. 0969331442\nCONEXION NODO', 'ACTIVE', 70, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(71, 'EUGENIO ESPEJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO , AL FINAL DE LINEA FERREA\nFECHA DE CONEXION  08-03-2021\nTELF. 0980089028\nCONEXION NODO', 'ACTIVE', 71, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(72, 'HUACSARA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD HUACSARA - FERRETERIA\nFECHA DE CONEXION  9-03-2021\nTELF.  0984016468\nCONEXION NODO', 'ACTIVE', 72, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(73, 'PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA DE VELASQUEZ - MUELLE\nFECHA DE CONEXION  08-03-2021\nTELF. 0959732080\nCONEXION NODO', 'ACTIVE', 73, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(74, 'EUGENIO ESPEJO BELLAVISTA', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO - SECTOR BELLAVISTA - PARQUE CONDOR\nFECHA DE CONEXION  8-03-2021\nTELF. 0993762007\nCONEXION NODO', 'ACTIVE', 74, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.2314799,\"lng\":-78.271874}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(75, 'CALUQUI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CALUQUI\nFECHA DE CONEXION  08-03-2021\nTELF. 0986443267\nCONEXION NODO', 'ACTIVE', 75, 1, 0, 1, 1, '{\"zoom\":11,\"latLng\":{\"lat\":0.16556233056309944,\"lng\":-78.21144919531248}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(76, 'PUCARA DE VELASQUEZ', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD PUCARA DE VELASQUEZ \nFECHA DE CONEXION  9-03-2021\nTELF. 0993966271\nCONEXION NODO', 'ACTIVE', 76, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.21431389226761247,\"lng\":-78.23754172460936}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(77, 'EUGENIO ESPEJO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      EUGENIO ESPEJO\nFECHA DE CONEXION  10-03-2021\nTELF.\nCONEXION NODO', 'ACTIVE', 77, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.2033276371260299,\"lng\":-78.24681143896483}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(78, 'CHUCHUQUI', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CHUCHUQUI ULTIMA PARADA DE BUS\nFECHA DE CONEXION  10-03-2021\nTELF.  0990253876\nCONEXION NODO', 'ACTIVE', 78, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.19714786529786865,\"lng\":-78.2564244760742}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(79, 'CUARABURO', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD CUARABURO - ESTADIO\nFECHA DE CONEXION  10-03-2021\nTELF. 0990263681\nCONEXION NODO', 'ACTIVE', 79, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.19783450672661865,\"lng\":-78.24303488867186}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(80, 'COMPANIA CERCA AL UPC', 'S/N', 'PLAN RESIDENCIAL   21.00  7MBPS\nVALOR DE EQUIPOS  100.00\nFECHAS DE PAGO      1 A 5 DE CADA MES\nSECTOR                      COMUNIDAD COMPANIA CERCA AL UPC\nFECHA DE CONEXION  10-03-2021\nTELF. 0979895525\nCONEXION NODO', 'ACTIVE', 80, 1, 0, 1, 1, '{\"zoom\":12,\"latLng\":{\"lat\":0.21534385328939473,\"lng\":-78.22071890966795}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(81, 'PIBARINCI', 'S-N', 'PLAN RECIDENCIAL 21 USD \nEQUIPOS A PROPIEDAD VALOR 100 USD \nPAGOS DEL 1 AL 5 DE CADA MES \nFECHA DE CONECCION  13 DE MARZO 20221\nZONA PIBARINCI EUGENIO ESPEJO \nTELEFONO \nSECTOR ANTENA', 'ACTIVE', 81, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.21345559136318795,\"lng\":-78.24354987280272}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(82, 'OTVALO', 'S-N', 'PLAN RECIDENCIAL 21 USD \nPLAN CONTRADO DE 7 MBPS\nEQUIPOS A PROPIEDAD SUYA\nDIAS DE PAGO DEL 1 AL 5 DE CADA MES \nTELEFONO 0999855879\nANTENA O NODO DIRECCIONADO AL CLIENTE', 'ACTIVE', 82, 1, 0, 1, 1, '{\"zoom\":17,\"latLng\":{\"lat\":0.3602171,\"lng\":-78.1249143}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJr5Ji-QI0Ko4RzdvyAUJFVcc', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(83, 'PIJAL BAJO', 'S-N', 'PLAN RECIDENCIAL 21 USD \nPLAN CONTRADO DE 7 MBPS\nEQUIPOS A PROPIEDAD SUYA\nDIAS DE PAGO DEL 1 AL 5 DE CADA MES \nTELEFONO  0979480193\nANTENA O NODO DIRECCIONADO AL CLIENTE', 'ACTIVE', 83, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20521590027175038,\"lng\":-78.2483563913574}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(84, 'MOJANDITA AVELINO DAVILA', 'S-N', 'EQUIPOS A PROPIEDAD SUYA  \nPAGOS DEL 1 AL 5 DE CADA MES \nVALOR DE EQUIPOS 100 USD \nFECHA DE CONECCION 25 DE MAZO 2021\nTELEFONO DE CONTACTO 0994490200\nNODO ANTENA', 'ACTIVE', 84, 1, 0, 1, 1, '{\"zoom\":13,\"latLng\":{\"lat\":0.20212601500911098,\"lng\":-78.25762610571287}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', ''),
(85, 'PARQUE ACUATICO', 'S-N', 'EQUIPOS A PROPIEDAD SUYA  \nPAGOS DEL 1 AL 5 DE CADA MES \nVALOR DE EQUIPOS 100 USD \nFECHA DE CONECCION 27 DE MAZO 2021\nTELEFONO DE CONTACTO 0979429608\nNODO ANTENA', 'ACTIVE', 85, 1, 0, 1, 1, '{\"zoom\":15,\"latLng\":{\"lat\":0.21362725154790987,\"lng\":-78.23239188330076}}', 'ChIJ1UuaqN2HI5ARAjecEQSvdp0', 'ChIJ8WXUfPdrKo4R2h0TE4mhAto', 'ChIJXTdbeKE8Ko4Ra1N65thz2_c', '');


--
-- Volcado de datos para la tabla `information_mail`
--

INSERT INTO `information_mail` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_mail_type_id`) VALUES
(1, 'kalexmigujelalba@gmail.com', 'ACTIVE', 3, 1, 1, 1);

--
-- Volcado de datos para la tabla `information_phone`
--

INSERT INTO `information_phone` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_phone_operator_id`, `information_phone_type_id`) VALUES
(1, '0969143060', 'ACTIVE', 3, 1, 1, 2, 2);

--
-- Volcado de datos para la tabla `information_social_network`
--

INSERT INTO `information_social_network` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_social_network_type_id`) VALUES
(1, 'http://flowers.com/', 'ACTIVE', 2, 1, 4, 1);

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

--
-- Volcado de datos para la tabla `parameters`
--

INSERT INTO `parameters` (`id`, `name`, `value`) VALUES
(1, 'environment', 'staging'),
(2, 'host_firebase_url', 'https://us-central1-timelygas-396c4.cloudfunctions.net/api'),
(3, 'site_url', 'http://back.timelygas.com'),
(4, 'cancel_status_id', '5');

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `last_name`, `name`, `birthdate`, `age`, `gender`) VALUES
(1, 'Suarez', 'María Mercedes', '2020-08-01 00:00:00', 0, 1),
(2, 'Llerena', 'Jessi', '2020-07-08 00:00:00', 0, 1),
(3, 'Luna', 'Anita', '2020-07-07 00:00:00', 0, 1),
(4, 'Madera', 'Ximena', '2016-01-01 00:00:00', 0, 1),
(5, 'Terán Suarez', 'José Rafael', '1988-08-20 00:00:00', 0, 0),
(6, 'Terán Jervis', 'Fernando', '2020-11-03 00:00:00', 0, 0),
(7, 'Suarez', 'María Mercedes', '2020-02-05 00:00:00', 0, 0),
(8, 'Carapaz', 'José Miguel', '2020-05-01 00:00:00', 0, 0),
(9, 'Díaz', 'Washington', '2020-03-06 00:00:00', 0, 0),
(10, 'Madera', 'Ximena', '2020-08-05 00:00:00', 0, 0),
(11, 'Suarez', 'José Rafael', '2020-09-02 00:00:00', 0, 0),
(12, 'Teran', 'Fernando', '2020-07-02 00:00:00', 0, 0),
(13, 'CALPA NARVAEZ', 'JONAR ALDEMAR', '2020-11-06 00:00:00', 0, 0),
(24, 'IASA DELACRUZ', 'MARIA DUCHICELA', '2020-07-01 00:00:00', 0, 1),
(26, 'QUINCHIGUANGO AGUILAR', 'JOSE EFRAIN', '2020-08-17 00:00:00', 0, 0),
(27, 'VEGA SANTILLAN', 'LUIS GERMAN', '2020-09-13 00:00:00', 0, 0),
(28, 'DIAZ MORENO', 'CRISTINA NATALY', '2020-11-12 00:00:00', 0, 1),
(29, 'CANDO', 'OSCAR VINICIO', '2020-06-17 00:00:00', 0, 0),
(30, 'chalan padilla', 'cesar antonio', '2021-02-01 00:00:00', 0, 0),
(37, 'maldonado velasquez', 'luis', '2021-02-01 00:00:00', 0, 0),
(55, 'CASTAÑEDA POTOSI', 'JOSE ALBERTO', '2021-02-01 00:00:00', 0, 0),
(56, 'ESPINOZA CRIOLLO', 'DIEGO ARMANDO', '2020-12-02 00:00:00', 0, 0),
(65, 'BURGA LEON', 'SEGUNDO', '2021-02-01 00:00:00', 0, 0),
(66, 'CASTAÑEDA GUERRERO', 'JOSE FRANCISCO', '2021-02-01 00:00:00', 0, 0),
(67, 'VELASQUEZ VELASQUEZ', 'LUIS ERNESTO', '2021-02-01 00:00:00', 0, 0),
(69, 'TOCAGON VILLAGRAN', 'JOSE LUIS', '2021-02-01 00:00:00', 0, 0),
(70, 'CARVAJAL MONTEROS', 'MAYRA KASANDRA', '2021-02-01 00:00:00', 0, 1),
(71, 'VELASQUEZ VELASQUEZ', 'MARTHA ERCILIA', '2021-02-01 00:00:00', 0, 0),
(72, 'ANRANGO ANRANGO', 'LUZ MILA', '2021-02-01 00:00:00', 0, 0),
(75, 'ISAMA AMAGUAÑA', 'JOEL DAVID', '2021-03-01 00:00:00', 0, 0),
(76, 'BURGA BURGA', 'MARIANO', '2021-01-01 00:00:00', 0, 0),
(77, 'CACHIGUANGO FLORES', 'NELSON RUBEN', '2021-01-01 00:00:00', 0, 0),
(78, 'VILLAGRAN CABASCANGO', 'DENISE ZENEIDA', '2021-03-11 00:00:00', 0, 1),
(79, 'ANRANGO MORALES', 'HERNAN GUILLERMO', '2021-03-10 00:00:00', 0, 0),
(89, 'MORILLO GAIBOR', 'ALICIA REBECA', '2021-01-01 00:00:00', 0, 1),
(90, 'ANRANGO ANRANGO', 'LUIS HUMBERTO', '2021-03-09 00:00:00', 0, 0),
(91, 'CACHIMUEL VASQUEZ', 'RODRIGO', '2021-03-09 00:00:00', 0, 0),
(92, 'PERALTA CACHIMUEL', 'ATIK ARIRUMA', '2021-03-09 00:00:00', 0, 0),
(93, 'CASTAÑEDA ANRRANGO', 'KEVIN ISRAEL', '2021-03-09 00:00:00', 0, 0),
(94, 'ANRANGO BURGA', 'LADY SHAKIRA', '2021-03-09 00:00:00', 0, 1),
(95, 'VERA GOMEZ', 'DIEGO ERNAN', '2021-03-09 00:00:00', 0, 0),
(96, 'HARO PASTOR', 'DIANA', '2021-03-09 00:00:00', 0, 1),
(97, 'ANRANGO CABASCANGO', 'LUZ MILA', '2021-03-09 00:00:00', 0, 1),
(98, 'QUINCHIGUANGO AGUILAR', 'JOSE EFRAIN', '2021-03-09 00:00:00', 0, 0),
(99, 'VELASQUEZ CUSHCAGUA', 'SEGUNDO', '2021-03-08 00:00:00', 0, 0),
(100, 'CABASCANGO CUASCOTA', 'SEGUNDO DIEGO', '2021-03-08 00:00:00', 0, 0),
(101, 'YUGSI BASTANTES', 'CARLOS ARMANDO', '2021-03-09 00:00:00', 0, 0),
(102, 'ARIAS CACHIMUEL', 'ROSA MARIA', '2021-03-08 00:00:00', 0, 1),
(103, 'ANGUAYA ESPINOZA', 'JOSE LUIS', '2021-03-08 00:00:00', 0, 0),
(104, 'CASTAÑEDA SALAZAR', 'JUAN MANUEL', '2021-03-08 00:00:00', 0, 0),
(105, 'CACHIMUEL QUILUMBAQUI', 'JOSE SAUL', '2021-03-08 00:00:00', 0, 0),
(110, 'CEPEDA TABANGO', 'JAIME', '2021-03-08 00:00:00', 0, 0),
(111, 'ANRANGO ANRANGO', 'LUZ MILA', '2021-03-08 00:00:00', 0, 0),
(112, 'LEON BURGA', 'SEGUNDO', '2021-03-08 00:00:00', 0, 0),
(113, 'LEON AMAGUAÑA', 'DELIA LUCILA', '2021-03-08 00:00:00', 0, 1),
(114, 'VILLEGAS BURBANO', 'PAULINA ELISA', '2021-03-09 00:00:00', 0, 1),
(115, 'ISAMA JETACAMA', 'ARMANDO GEOVANY', '2021-03-08 00:00:00', 0, 0),
(116, 'MINA CUERO', 'SEGUNDO ARTEMIO', '2021-03-08 00:00:00', 0, 0),
(117, 'JISAMA ESPINOSA', 'OSWALDO', '2021-03-08 00:00:00', 0, 0),
(118, 'AJALA PILLAJO', 'DIEGO FRANCISCO', '2021-03-08 00:00:00', 0, 0),
(119, 'GUAMBUGUETE CABASCANGO', 'MILTON GERARDO', '2021-03-08 00:00:00', 0, 0),
(120, 'SINCHICO CAÑAMAR', 'ROSA ELENA', '2021-03-08 00:00:00', 0, 0),
(121, 'MALES MALES', 'VIRGINIA', '2021-03-08 00:00:00', 0, 1),
(122, 'VELASQUEZ MALDONADO', 'JAVIER', '2021-03-08 00:00:00', 0, 0),
(123, 'ECHEVERRIA BENALCAZAR', 'DANILO MANUEL', '2021-03-13 00:00:00', 0, 0),
(124, 'MALDONADO ANRANGO', 'SEGUNDO', '2021-03-08 00:00:00', 0, 0),
(125, 'AGUILAR CAMPO', 'NESTOR ARMANDO', '2021-03-10 00:00:00', 0, 0),
(128, 'LOPEZ CABRERA', 'MIRIAN ELIZABETH', '2021-03-08 00:00:00', 0, 1),
(129, 'ANRANGO PICUASI', 'JORDY BLADIIR', '2021-03-08 00:00:00', 0, 0),
(130, 'CASTAÑEDA VELASQUEZ', 'JOSE', '2021-03-08 00:00:00', 0, 0),
(138, 'ALMENDARIZ DELGADO', 'PEDRO', '2021-03-01 00:00:00', 0, 0),
(139, 'ESPINOZA PEÑA', 'MERCEDES', '2021-03-12 00:00:00', 0, 1),
(140, 'SANTELLAN SALZAR', 'SEGUNDO', '2021-03-12 00:00:00', 0, 0),
(141, 'CHALAN ISAMA', 'JHONY FRANCISCO', '2021-03-11 00:00:00', 0, 0),
(142, 'JETACAMA GUAMAN', 'ZOILA ELENA', '2021-03-10 00:00:00', 0, 1),
(143, 'AGUILAR CACHIMUEL', 'JOSE ALBERTO', '2021-03-09 00:00:00', 0, 0),
(144, 'GUALSAQUI ALMAGOR', 'CARLOS JAVIER', '2021-03-11 00:00:00', 0, 0),
(145, 'AGUILAR MALES', 'JOSE ALFONSO', '2021-03-08 00:00:00', 0, 0),
(146, 'CUSANGUA REINA', 'CARLOS ANDRES', '2021-03-11 00:00:00', 0, 0),
(151, 'CEPEDA YACELGA', 'JOSE', '2021-03-12 00:00:00', 0, 0),
(152, 'BURGA MORALES', 'SUSANA', '2021-03-11 00:00:00', 0, 1),
(153, 'ESPINOSA CRIOLLO', 'ALEX NICOLAS', '2021-03-08 00:00:00', 0, 0),
(154, 'CASTAÑEDA CACHIMUEL', 'MARIA LUZMILA', '2021-03-08 00:00:00', 0, 1),
(155, 'CHINGO IZA', 'LUIS ANTONIO', '2021-03-09 00:00:00', 0, 0),
(156, 'ANRANGO VELASQUEZ', 'LUIS ALBERTO', '2021-03-08 00:00:00', 0, 0),
(157, 'ENRIQUES CULTID', 'JOSELIN LICED', '2021-03-08 00:00:00', 0, 1),
(158, 'INUCA', 'MARTIN', '2021-03-08 00:00:00', 0, 0),
(159, 'MALES ANRANGO', 'LUIS ALBERTO', '2021-03-09 00:00:00', 0, 0),
(160, 'MALES MASAQUIZA', 'KENNETH CRISTOFER', '2021-03-10 00:00:00', 0, 0),
(161, 'IMBAQUINGO CABASCANGO', 'MIGUEL', '2021-03-10 00:00:00', 0, 0),
(162, 'GUAMAN', 'DOLORES', '2021-03-10 00:00:00', 0, 1),
(163, 'BURGA ARIAS', 'KLEVER RENE', '2021-03-11 00:00:00', 0, 0),
(164, 'AMAGUÑA TORRES', 'PEDRO', '2021-03-13 00:00:00', 0, 0),
(196, 'HARO  CHAVARRIA', 'MARICELA CRISTINA', '2021-03-10 00:00:00', 0, 1),
(200, 'CAÑAREJO CHICAIZA', 'RICHARD AUGUSTIN', '2021-03-10 00:00:00', 0, 0),
(202, 'LEMA', 'SAYRI ATAHUALPA', '2021-03-25 00:00:00', 0, 0),
(208, 'OBANDO FLORES', 'FATIMA DAYANE', '2021-03-27 00:00:00', 0, 1);

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `code`, `name`, `state`, `product_trademark_id`, `product_category_id`, `product_subcategory_id`, `source`, `description`, `code_provider`, `code_product`, `has_tax`, `is_service`, `user_id`, `product_measure_type_id`, `view_online`) VALUES
(1, 'CT15', 'Plan Estudiantil', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446182_Captura.PNG', 'Contrato para plan estudiantil de 15 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 1),
(2, 'CT21', 'Plan Residencial', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446266_Captura.PNG', 'Contrato para plan estudiantil de 21 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0),
(3, 'CT38', 'Plan Ciber', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446320_Captura.PNG', 'Contrato para plan estudiantil de 38 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0),
(4, 'CT75', 'Plan Corporativo', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446385_Captura.PNG', 'Contrato para plan estudiantil de 75 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0);

--
-- Volcado de datos para la tabla `product_by_details`
--

INSERT INTO `product_by_details` (`id`, `product_id`, `tax_id`, `location_details`, `stock_control`, `ice_control`, `initial_stock_control`) VALUES
(1, 1, 1, 'none', 0, 0, 0),
(2, 2, 1, 'none', 0, 0, 0),
(3, 3, 1, 'none', 0, 0, 0),
(4, 4, 1, 'none', 0, 0, 0);

--
-- Volcado de datos para la tabla `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `business_id`, `avarage_kardex_value`, `tax`, `quantity_units`, `sale_price`, `total_price`, `product_id`, `tax_id`, `profit`, `profit_type`, `note`, `sale_price2`, `sale_price3`, `sale_price4`) VALUES
(1, 1, '0.0000', 'SI', '0.0000', '180.0000', '0.0000', 1, 1, 0, 0, 'Contrato para plan estudiantil de 15 USD al mes por 12 meses', '180.0000', '180.0000', '180.0000'),
(2, 1, '0.0000', 'SI', '0.0000', '252.0000', '0.0000', 2, 1, 0, 0, 'Contrato para plan estudiantil de 21 USD al mes por 12 meses', '252.0000', '252.0000', '252.0000'),
(3, 1, '0.0000', 'SI', '0.0000', '456.0000', '0.0000', 3, 1, 0, 0, 'Contrato para plan estudiantil de 38 USD al mes por 12 meses', '456.0000', '456.0000', '456.0000'),
(4, 1, '0.0000', 'SI', '0.0000', '75.0000', '0.0000', 4, 1, 0, 0, 'Contrato para plan estudiantil de 75 USD al mes por 12 meses', '75.0000', '75.0000', '75.0000');

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GOD', 'ACTIVE', NULL, NULL),
(2, 'BUSINESS', 'ACTIVE', '2020-06-14 18:50:42', '2020-06-14 18:50:42'),
(3, 'EMPLOYER', 'ACTIVE', '2020-06-14 19:08:45', '2020-06-14 22:10:21'),
(4, 'CUSTOMER', 'ACTIVE', '2020-06-14 19:17:10', '2020-06-14 19:17:10');



--
-- Volcado de datos para la tabla `tax_by_business`
--

INSERT INTO `tax_by_business` (`id`, `tax_id`, `state`, `business_id`) VALUES
(1, 1, 'ACTIVE', 1);

--
-- Volcado de datos para la tabla `template_by_source`
--

INSERT INTO `template_by_source` (`id`, `template_information_id`, `source`, `source_type`, `value`) VALUES
(1, 1, '/uploads/frontend/templateBySource/1604937642_corpar.png', 0, 'Logo Principal');

--
-- Volcado de datos para la tabla `template_information`
--

INSERT INTO `template_information` (`id`, `value`, `description`, `status`, `business_id`) VALUES
(1, 'Coorporacion Arrayanes', NULL, 'ACTIVE', 1);

--
-- Volcado de datos para la tabla `template_news`
--

INSERT INTO `template_news` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'Liberal Arts College Rankings', '<p>Liberal Arts Colleges emphasize undergradutae education.</p><p>These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605188832_b2.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:47:12', '2020-11-12 08:48:17', NULL, 0),
(2, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605188887_b1.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:48:07', '2020-11-12 08:50:58', NULL, 0),
(3, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605189112_b3.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:51:52', '2020-11-12 08:51:52', NULL, 0),
(4, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605189154_b1.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:52:34', '2020-11-12 08:52:34', NULL, 0);

--
-- Volcado de datos para la tabla `template_slider`
--

INSERT INTO `template_slider` (`id`, `value`, `description`, `status`, `template_information_id`, `position_section`) VALUES
(1, 'Slider Principal', NULL, 'ACTIVE', 1, 0);


--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `provider_id`, `provider`, `api_token`, `user_id`, `avatar`) VALUES
(1, 'Admin', 'admin@system.dev', NULL, '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', 'YD8q4rYh5b1qMa2gjtlJrZMI3IvT0kllGUOFEkJalFBub0W1Dw0rtiuYVMZ3', 'ACTIVE', '2017-11-25 15:41:16', '2017-11-25 15:41:16', 'server', 'server', NULL, NULL, NULL),
(2, 'Enrique Burga', 'eburga@system.dev', 'eburga@system.dev', '$2y$10$f./uEz6L/0aWd.tTSU3NSuRyNHn9tA4av/yoD1wyAu556y4qQIG/e', NULL, 'ACTIVE', '2021-05-09 02:23:48', '2021-05-09 02:23:48', NULL, NULL, NULL, NULL, NULL);

--
-- Volcado de datos para la tabla `users_has_roles`
--

INSERT INTO `users_has_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2);

--
-- Volcado de datos para la tabla `business_by_gamification`
--

INSERT INTO `business_by_gamification` (`id`, `gamification_id`, `business_id`, `allow_exchange`, `allow_exchange_business`, `state`) VALUES
(1, 1, 6, 0, 0, 'ACTIVE');

--
-- Volcado de datos para la tabla `gamification`
--

INSERT INTO `gamification` (`id`, `value`, `description`, `value_unit`, `state`, `maximum_exchange`) VALUES
(1, 'Configuracion Inicial Gamificacion', 'Configuracion', 0, 'ACTIVE', 0);


/*  MANAGER BUSINESS PROCESS*/
INSERT INTO `human_resources_organizational_chart_area` (`id`, `parent_id`, `weight`, `icon`, `type`, `description`,
                                                         `type_item`, `status`, `name`, `business_id`)
VALUES (1, NULL, 1, 'fa fa-developer', 2, 'Asamblea de Socios', 1, 'ACTIVE', 'Asamblea de Socios', 1),
       (2, 1, 1, 'fa fa-developer', 0, 'GERENTE GENERAL', 1, 'ACTIVE', 'GERENTE GENERAL', 1),
       (3, 2, 1, 'fa fa-developer', 0, 'ADMINISTRATIVO', 1, 'ACTIVE', 'ADMINISTRATIVO', 1),
       (4, 2, 2, 'fa fa-developer', 0, 'COMERCIAL', 1, 'ACTIVE', 'COMERCIAL', 1),
       (5, 2, 3, 'fa fa-developer', 0, 'OPERACIONES', 1, 'ACTIVE', 'OPERACIONES', 1);
INSERT INTO `human_resources_schedule_type` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`,
                                             `deleted_at`, `status`, `predetermined`, `rotary`, `business_id`)
VALUES (1, 'HORARIO OPERATIVO', '001', 'HORARIO OPERATIVO', '2023-06-14 00:05:17', NULL, NULL, 'ACTIVE', 0, 0, 1);


INSERT INTO `human_resources_department_by_organizational_chart_area` (`id`, `human_resources_department_id`,
                                                                       `human_resources_organizational_chart_area_id`)
VALUES (1, 5, 3),
       (2, 1, 3),
       (3, 4, 4),
       (4, 2, 4),
       (5, 6, 5);

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
