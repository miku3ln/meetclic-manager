`information_social_network_type`
-- Dumping data for table `information_phone_operator`
--

INSERT INTO `information_phone_operator` (`id`, `value`, `description`, `state`) VALUES
(1, 'SIN DEFINIR', NULL, 'ACTIVE'),
(2, 'MOVISTAR', 'adad', 'ACTIVE'),
(3, 'ALEGRO', 'adad', 'ACTIVE'),
(4, 'CLARO', NULL, 'ACTIVE');

--
-- Dumping data for table `information_phone_type`
--

INSERT INTO `information_phone_type` (`id`, `value`, `description`, `state`) VALUES
(1, 'SIN DEFINIR', 'sfdd ADAD', 'ACTIVE'),
(2, 'TRABAJO', NULL, 'ACTIVE'),
(3, 'CASA', 'adad', 'ACTIVE'),
(4, 'Personal', NULL, 'ACTIVE');

--
-- Dumping data for table `information_social_network`
--

INSERT INTO `information_social_network` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_social_network_type_id`) VALUES
(1, 'http://flowers.com/', 'ACTIVE', 2, 1, 4, 1);

--
-- Dumping data for table `information_social_network_type`
--

INSERT INTO `information_social_network_type` (`id`, `value`, `description`, `state`, `icon`) VALUES
(1, 'Facebook', 'adadad', 'ACTIVE', 'fa fa-facebook'),
(2, 'Instagram', 'adadad', 'ACTIVE', 'fa fa-instagram'),
(3, 'Twitter', 'adadad', 'ACTIVE', 'fa fa-twitter'),
(4, 'LinkedIn', 'adadad', 'ACTIVE', 'fa fa-linkedin'),
(5, 'Youtube', 'adadad', 'ACTIVE', 'fa fa-youtube-play'),
(6, 'Whatsapp', 'adadad', 'ACTIVE', 'fa fa-youtube-play');

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `value`, `initials`, `state`, `description`) VALUES
(1, 'Ingles', 'en', 'ACTIVE', 'Ingles'),
(2, 'Kichwa', 'ki', 'ACTIVE', NULL),
(3, 'Español', 'es', 'ACTIVE', NULL);

--
-- Dumping data for table `lodging`
--

INSERT INTO `lodging` (`id`, `entry_at`, `output_at`, `number_people`, `adults`, `children`, `number_rooms`, `total_value`, `payment_made`, `created_at`, `updated_at`, `deleted_at`, `description`, `business_id`, `status`, `arrived_made`, `rooms_add_made`, `status_delivery`, `delivery_date`) VALUES
(2, '2024-02-01 12:00:00', '2024-02-29 10:35:50', 1, 1, 0, 2, 2.00, 0, '2024-02-29 14:39:38', '2024-02-29 15:35:50', NULL, 'ADADD', 1, 'ACTIVE', 0, 1, 1, '2024-02-29 10:35:50'),
(15, '2024-02-01 12:00:00', NULL, 2, 0, 0, 2, 2.00, 0, '2024-02-29 15:34:28', '2024-02-29 15:34:28', NULL, NULL, 1, 'ACTIVE', 0, 0, 0, NULL),
(25, '2024-02-01 12:00:00', NULL, 2, 0, 0, 2, 2.00, 0, '2024-02-29 16:54:26', '2024-02-29 16:54:26', NULL, 'adad', 1, 'ACTIVE', 0, 0, 0, NULL);

--
-- Dumping data for table `lodging_by_customer`
--

INSERT INTO `lodging_by_customer` (`id`, `main`, `lodging_id`, `has_information_additional`, `customer_id`) VALUES
(1, 0, 2, 0, 87),
(2, 0, 15, 0, 86),
(9, 1, 25, 1, 88),
(10, 0, 25, 0, 86);

--
-- Dumping data for table `lodging_by_customer_location`
--

INSERT INTO `lodging_by_customer_location` (`id`, `lodging_by_customer_id`, `information_address_id`) VALUES
(1, 9, 86);

--
-- Dumping data for table `lodging_by_type_of_room`
--

INSERT INTO `lodging_by_type_of_room` (`id`, `lodging_id`, `lodging_type_of_room_by_price_id`) VALUES
(1, 2, 1);

--
-- Dumping data for table `lodging_customer_additional_information`
--

INSERT INTO `lodging_customer_additional_information` (`id`, `information_mobile_id`, `information_phone_id`, `postal_code`, `lodging_by_customer_id`, `information_mail_id`) VALUES
(1, NULL, NULL, NULL, 9, 2);

--
-- Dumping data for table `lodging_room_features`
--

INSERT INTO `lodging_room_features` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `business_id`) VALUES
(1, 'Vistas panorámicas desde grandes ventanales o balcones.', 'Vistas panorámicas desde grandes ventanales o balcones', '2024-02-29 14:31:11', '2024-02-29 14:31:11', NULL, 'ACTIVE', 1),
(2, 'Servicio de mayordomo personalizado', NULL, '2024-02-29 14:31:27', '2024-02-29 14:31:27', NULL, 'ACTIVE', 1);

--
-- Dumping data for table `lodging_room_levels`
--

INSERT INTO `lodging_room_levels` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `business_id`) VALUES
(1, 'Planta Penthouse', 'El penthouse generalmente se encuentra en la parte superior del hotel y ofrece alojamiento de lujo con comodidades adicionales.', '2024-02-29 14:24:06', '2024-02-29 14:24:06', NULL, 'ACTIVE', 1),
(2, 'Planta Baja', 'El primer piso suele ser una parte crucial del hotel, ya que es donde los huéspedes entran y salen y donde se encuentran las áreas comunes principales.', '2024-02-29 14:24:29', '2024-02-29 14:24:45', NULL, 'ACTIVE', 1),
(3, 'Primer Piso', NULL, '2024-02-29 14:24:52', '2024-02-29 14:24:52', NULL, 'ACTIVE', 1),
(4, 'Segundo Piso', NULL, '2024-02-29 14:24:57', '2024-02-29 14:24:57', NULL, 'ACTIVE', 1);

--
-- Dumping data for table `lodging_type_of_room`
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

--
-- Dumping data for table `lodging_type_of_room_by_price`
--

INSERT INTO `lodging_type_of_room_by_price` (`id`, `price`, `status`, `room_number`, `lodging_type_of_room_id`, `lodging_room_levels_id`, `description`, `name`) VALUES
(1, 0.00, 'CLEANING', '001', 2, 2, '', 'YAKU');

--
-- Dumping data for table `lodging_type_of_room_price_by_features`
--

INSERT INTO `lodging_type_of_room_price_by_features` (`lodging_type_of_room_by_price_id`, `lodging_room_features_id`) VALUES
(1, 1),
(1, 2);

--
-- Dumping data for table `management_livelihood_by_voucher`
--

INSERT INTO `management_livelihood_by_voucher` (`id`, `tax_support_id`, `voucher_type_id`, `people_type_identification_id`, `type_management`) VALUES
(1, 1, 1, 2, 0),
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

--
-- Dumping data for table `migrations`
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
-- Dumping data for table `panorama`
--

INSERT INTO `panorama` (`id`, `title`, `subtitle`, `description`, `type_panorama`, `points_allow`, `src`, `type_breakdown`) VALUES
(1, 'Foto Una', 'foto Una', 'VEREMOS UNA FOTO', 0, 0, '/uploads/panorama/markers/1708792720_02.jpg', 0),
(2, 'Solo Foto', 'foto', 'foto', 0, 0, '/uploads/panorama/markers/1708794273_04.jpg', 0);

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `name`, `value`) VALUES
(1, 'environment', 'staging'),
(2, 'host_firebase_url', 'https://us-central1-timelygas-396c4.cloudfunctions.net/api'),
(3, 'site_url', 'http://back.timelygas.com'),
(4, 'cancel_status_id', '5');

--
-- Dumping data for table `people`
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
(208, 'OBANDO FLORES', 'FATIMA DAYANE', '2021-03-27 00:00:00', 0, 1),
(209, 'Alba', 'Alex', '2024-01-02 00:00:00', 0, 0),
(210, 'Alba', 'Alex', '1987-07-24 00:00:00', 0, 1),
(211, 'AADA', 'ADAD', NULL, 25, 2),
(213, 'a', 'zcz', NULL, 2, 0),
(223, 'a', 'a', NULL, 22, 0);

--
-- Dumping data for table `people_gender`
--

INSERT INTO `people_gender` (`id`, `value`, `description`, `status`) VALUES
(1, 'Masculino', 'hom', 'ACTIVE'),
(2, 'Femenino', 'hom', 'ACTIVE'),
(3, 'LGBTI', 'hom', 'ACTIVE');

--
-- Dumping data for table `people_nationality`
--

INSERT INTO `people_nationality` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `countries_id`) VALUES
(1, 'Afgano/\nfgana', NULL, NULL, NULL, NULL, 'ACTIVE', 1),
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

--
-- Dumping data for table `people_profession`
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
(12, 'Abogado/a', 'Persona que defiende, representa o acusa a una persona en un juicio. cambiado', '2020-07-19 03:29:21', '2024-02-28 21:49:00', NULL, 'ACTIVE'),
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

--
-- Dumping data for table `people_relationship`
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

--
-- Dumping data for table `people_type_identification`
--

INSERT INTO `people_type_identification` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `code`) VALUES
(1, 'RUC', 'ada', '2019-10-26 18:19:10', '2019-10-28 09:48:48', NULL, 'ACTIVE', 'R'),
(2, 'CEDULA', 'Codigocam', '2019-10-26 18:19:11', '2024-02-28 22:52:48', NULL, 'ACTIVE', 'C'),
(3, 'OTROS', '', '2019-10-27 11:56:31', '2019-10-28 09:48:30', NULL, 'ACTIVE', '-'),
(4, 'PASAPORTE', '', '2019-10-27 11:56:39', '2019-10-28 09:48:36', NULL, 'ACTIVE', 'P'),
(5, 'CONSUMIDOR FINAL', '', '2019-10-27 11:56:47', '2019-10-28 09:48:23', NULL, 'INACTIVE', 'F'),
(6, 'PLACA-RAMV/CPN', '', '2019-10-27 11:56:57', '2019-10-28 09:48:42', NULL, 'INACTIVE', 'PL');

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `code`, `name`, `state`, `product_trademark_id`, `product_category_id`, `product_subcategory_id`, `source`, `description`, `code_provider`, `code_product`, `has_tax`, `is_service`, `user_id`, `product_measure_type_id`, `view_online`) VALUES
(1, 'CT15', 'Plan Estudiantil', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446182_Captura.PNG', 'Contrato para plan estudiantil de 15 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 1),
(2, 'CT21', 'Plan Residencial', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446266_Captura.PNG', 'Contrato para plan estudiantil de 21 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0),
(3, 'CT38', 'Plan Ciber', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446320_Captura.PNG', 'Contrato para plan estudiantil de 38 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0),
(4, 'CT75', 'Plan Corporativo', 'ACTIVE', 1, 1, 1, '/uploads/products/product/1618446385_Captura.PNG', 'Contrato para plan estudiantil de 75 USD al mes por 12 meses', 'null', 'null', 1, 1, 1, 1, 0);

--
-- Dumping data for table `product_by_details`
--

INSERT INTO `product_by_details` (`id`, `product_id`, `tax_id`, `location_details`, `stock_control`, `ice_control`, `initial_stock_control`) VALUES
(1, 1, 1, 'none', 0, 0, 0),
(2, 2, 1, 'none', 0, 0, 0),
(3, 3, 1, 'none', 0, 0, 0),
(4, 4, 1, 'none', 0, 0, 0);

--
-- Dumping data for table `product_category`
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

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`id`, `value`, `state`, `description`, `multicolored`, `color`, `business_id`) VALUES
(1, 'Morado', 'ACTIVE', NULL, 0, '#5508C0', 0),
(2, 'Amarillo', 'ACTIVE', NULL, 0, '#E3ED0F', 0),
(3, 'Negro', 'ACTIVE', NULL, 0, '#000000', 0),
(4, 'Azul', 'ACTIVE', NULL, 0, '#1811F1', 0),
(5, 'Tomate', 'ACTIVE', NULL, 0, '#B85807', 0);

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `business_id`, `avarage_kardex_value`, `tax`, `quantity_units`, `sale_price`, `total_price`, `product_id`, `tax_id`, `profit`, `profit_type`, `note`, `sale_price2`, `sale_price3`, `sale_price4`) VALUES
(1, 1, 0.0000, 'SI', 0.0000, 180.0000, 0.0000, 1, 1, 0, 0, 'Contrato para plan estudiantil de 15 USD al mes por 12 meses', 180.0000, 180.0000, 180.0000),
(2, 1, 0.0000, 'SI', 0.0000, 252.0000, 0.0000, 2, 1, 0, 0, 'Contrato para plan estudiantil de 21 USD al mes por 12 meses', 252.0000, 252.0000, 252.0000),
(3, 1, 0.0000, 'SI', 0.0000, 456.0000, 0.0000, 3, 1, 0, 0, 'Contrato para plan estudiantil de 38 USD al mes por 12 meses', 456.0000, 456.0000, 456.0000),
(4, 1, 0.0000, 'SI', 0.0000, 75.0000, 0.0000, 4, 1, 0, 0, 'Contrato para plan estudiantil de 75 USD al mes por 12 meses', 75.0000, 75.0000, 75.0000);

--
-- Dumping data for table `product_measure_type`
--

INSERT INTO `product_measure_type` (`id`, `value`, `state`, `description`, `abbreviation`, `unit`, `number_of_units`, `prefix`, `symbol`, `business_id`) VALUES
(1, 'Sin Definir', 'ACTIVE', 'SDF', 'SDF', 0, 1, 'U', 'U', 0),
(2, 'UNIDAD', 'ACTIVE', 'uNIDAD', 'U', 0, 1, 'U', 'U', 0),
(3, 'Docena', 'ACTIVE', NULL, 'Doce', 1, 12, 'DOC', 'DOC', 0),
(4, 'PAR', 'ACTIVE', 'AD', 'PAR', 1, 2, 'PAR', 'PAR', 0),
(5, 'Metro', 'ACTIVE', NULL, 'm', 0, 1, 'm', 'm', 0),
(6, 'Libra', 'ACTIVE', NULL, 'lb', 0, 1, 'lb', 'lb', 0);

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `value`, `state`, `description`, `business_id`) VALUES
(1, 'XL', 'ACTIVE', 'XL', 0),
(2, 'XXL', 'ACTIVE', NULL, 0),
(3, 'L', 'ACTIVE', NULL, 0),
(4, 'XS', 'ACTIVE', NULL, 0),
(5, 'M', 'ACTIVE', NULL, 0),
(6, 'S', 'ACTIVE', NULL, 0),
(7, 'XXS', 'ACTIVE', NULL, 0);

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`id`, `value`, `state`, `description`, `source`, `subtitle`, `product_category_id`, `business_id`) VALUES
(1, 'Sin definir', 'ACTIVE', 'null', '/uploads/products/productSubcategory/sindefinir.jpg', 'null', 1, 0),
(2, 'Artes', 'ACTIVE', 'null', '/uploads/products/productSubcategory/artes.jpg', 'null', 2, 0),
(3, 'Tecnologia', 'ACTIVE', 'null', '/uploads/products/productSubcategory/tecnologias.jpg', 'null', 7, 0),
(4, 'Videos', 'ACTIVE', 'null', '/uploads/products/productSubcategory/videos.jpg', 'null', 3, 0),
(5, 'Sistemas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/sistemas.jpg', 'null', 1, 0),
(6, 'Aplicaciones Moviles', 'ACTIVE', 'null', '/uploads/products/productSubcategory/aplicacionesmoviles.png', 'null', 7, 0),
(7, 'Hospedaje', 'ACTIVE', 'null', '/uploads/products/productSubcategory/hospedaje.png', 'null', 5, 0),
(8, 'Atracciones Deportivas', 'ACTIVE', 'null', '/uploads/products/productSubcategory/atracionesdeportivas.jpg', 'null', 8, 0),
(9, 'Asados', 'ACTIVE', 'null', '/uploads/products/productSubcategory/asados.jpg', 'null', 9, 0);

--
-- Dumping data for table `product_trademark`
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

--
-- Dumping data for table `provinces`
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

--
-- Dumping data for table `reference_piece`
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

--
-- Dumping data for table `reference_piece_position`
--

INSERT INTO `reference_piece_position` (`id`, `position`) VALUES
(1, 'TOP'),
(2, 'DOWN'),
(3, 'RIGHT'),
(4, 'LEFT'),
(5, 'CENTER'),
(6, 'COMPLETE');

--
-- Dumping data for table `reference_piece_type`
--

INSERT INTO `reference_piece_type` (`id`, `color`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `name`) VALUES
(1, '#0b0a0a', 'cambiando', '2018-09-11 22:49:22', '2024-02-29 14:13:28', NULL, 'ACTIVE', 'Lesion'),
(2, '#247b1f', NULL, '2018-09-11 22:49:44', '2018-09-12 00:37:34', NULL, 'ACTIVE', 'Pre Existencias'),
(3, '#f81111', NULL, '2018-09-11 22:50:28', '2018-09-11 22:50:28', NULL, 'ACTIVE', 'Por Hacer'),
(4, '#1ec1fb', 'ag', '2018-09-11 22:51:15', '2018-09-14 08:43:19', NULL, 'ACTIVE', 'Hecho');

--
-- Dumping data for table `retention_tax_sub_type`
--

INSERT INTO `retention_tax_sub_type` (`id`, `value`, `description`, `status`, `type`, `retention_tax_type_id`, `percentage`, `accounting_account_id`) VALUES
(1, '712', 'RETENCIÓN DEL 10%', 'ACTIVE', 0, 3, 10, 100),
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
(13, '303', 'Honorarios profesionales y demás pagos por servicios relacionados con el título profesional', 'ACTIVE', 0, 1, 10, 98),
(14, '304', 'Servicios predomina el intelecto no relacionados con el título profesional', 'ACTIVE', 0, 1, 8, 97),
(15, '304A', 'Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional', 'ACTIVE', 0, 1, 8, 97),
(16, '304B', 'Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales', 'ACTIVE', 0, 1, 8, 97),
(17, '304C', 'Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales', 'ACTIVE', 0, 1, 8, 97),
(18, '304D', 'Pagos a artistas por sus actividades ejercidas como tales', 'ACTIVE', 0, 1, 8, 97),
(19, '304E', 'Honorarios y demás pagos por servicios de docencia', 'ACTIVE', 0, 1, 8, 97),
(20, '307', 'Servicios predomina la mano de obra', 'ACTIVE', 0, 1, 2, 96),
(21, '308', 'Utilización o aprovechamiento de la imagen o renombre', 'ACTIVE', 0, 1, 10, 98),
(22, '309', 'Servicios prestados por medios de comunicación y agencias de publicidad', 'ACTIVE', 0, 1, 1, 95),
(23, '310', 'Servicio de transporte privado de pasajeros o transporte público o privado de carga', 'ACTIVE', 0, 1, 1, 95),
(24, '311', 'Pagos a través de liquidación de compra (nivel cultural o rusticidad)', 'ACTIVE', 0, 1, 2, 96),
(25, '312', 'Transferencia de bienes muebles de naturaleza corporal', 'ACTIVE', 0, 1, 1, 95),
(26, '312A', 'Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, y forestal', 'ACTIVE', 0, 1, 1, 95),
(27, '312B', 'Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera', 'ACTIVE', 0, 1, 1, 95),
(28, '314A', 'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales', 'ACTIVE', 0, 1, 8, 97),
(29, '314B', 'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales', 'ACTIVE', 0, 1, 8, 97),
(30, '314C', 'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades', 'ACTIVE', 0, 1, 8, 97),
(31, '314D', 'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades', 'ACTIVE', 0, 1, 8, 97),
(32, '319', 'Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra', 'ACTIVE', 0, 1, 1, 95),
(33, '320', 'Arrendamiento bienes inmuebles', 'ACTIVE', 0, 1, 8, 97),
(34, '322', 'Seguros y reaseguros (primas y cesiones)', 'ACTIVE', 0, 1, 1, 95),
(35, '323', 'Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)', 'ACTIVE', 0, 1, 2, 96),
(36, '323A', 'Rendimientos financieros: depósitos Cta. Corriente', 'ACTIVE', 0, 1, 2, 96),
(37, '323B1', 'Rendimientos financieros:  depósitos Cta. Ahorros Sociedades', 'ACTIVE', 0, 1, 2, 96),
(38, '323E', 'Rendimientos financieros: depósito a plazo fijo  gravados', 'ACTIVE', 0, 1, 2, 96),
(39, '323E2', 'Rendimientos financieros: depósito a plazo fijo exentos', 'ACTIVE', 0, 1, 0, 95),
(40, '323F', 'Rendimientos financieros: operaciones de reporto - repos', 'ACTIVE', 0, 1, 2, 96),
(41, '323G', 'Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs', 'ACTIVE', 0, 1, 2, 96),
(42, '323H', 'Rendimientos financieros: obligaciones', 'ACTIVE', 0, 1, 2, 96),
(43, '323I', 'Rendimientos financieros: bonos convertible en acciones', 'ACTIVE', 0, 1, 2, 96),
(44, '323 M', 'Rendimientos financieros: Inversiones en títulos valores en renta fija gravados ', 'ACTIVE', 0, 1, 2, 96),
(45, '323 N', 'Rendimientos financieros: Inversiones en títulos valores en renta fija exentos', 'ACTIVE', 0, 1, 0, 95),
(46, '323 O', 'Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria', 'ACTIVE', 0, 1, 0, 95),
(47, '323 P', 'Intereses pagados por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', 0, 1, 2, 96),
(48, '323Q', 'Otros intereses y rendimientos financieros gravados ', 'ACTIVE', 0, 1, 2, 96),
(49, '323R', 'Otros intereses y rendimientos financieros exentos', 'ACTIVE', 0, 1, 0, 95),
(50, '323S', 'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades', 'ACTIVE', 0, 1, 2, 96),
(51, '323T', 'Rendimientos financieros originados en la deuda pública ecuatoriana', 'ACTIVE', 0, 1, 0, 95),
(52, '323U', 'Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada', 'ACTIVE', 0, 1, 0, 95),
(53, '324A', 'Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.', 'ACTIVE', 0, 1, 1, 95),
(54, '324B', 'Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria', 'ACTIVE', 0, 1, 1, 95),
(55, '324C', 'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero', 'ACTIVE', 0, 1, 1, 95),
(56, '328', 'Dividendos distribuidos a sociedades residentes', 'ACTIVE', 0, 1, 0, 95),
(57, '329', 'Dividendos distribuidos a fideicomisos residentes', 'ACTIVE', 0, 1, 0, 95),
(58, '343', 'Otras retenciones aplicables el 1%', 'ACTIVE', 0, 1, 1, 95),
(59, '343A', 'Energía eléctrica', 'ACTIVE', 0, 1, 1, 95),
(60, '343B', 'Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares', 'ACTIVE', 0, 1, 1, 95),
(61, '343C', 'Impuesto Redimible a las botellas plásticas - IRBP', 'ACTIVE', 0, 1, 1, 95),
(62, '344', 'Otras retenciones aplicables el 2%', 'ACTIVE', 0, 1, 2, 96),
(63, '344A', 'Pago local tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP', 'ACTIVE', 0, 1, 2, 96),
(64, '344B', 'Adquisición de sustancias minerales dentro del territorio nacional', 'ACTIVE', 0, 1, 2, 96),
(65, '345', 'Otras retenciones aplicables el 8%', 'ACTIVE', 0, 1, 8, 97),
(66, '303', 'Honorarios profesionales y demás pagos por servicios relacionados con el título profesional', 'ACTIVE', 0, 2, 10, 27),
(67, '304', 'Servicios predomina el intelecto no relacionados con el título profesional', 'ACTIVE', 0, 2, 8, 26),
(68, '304A', 'Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional', 'ACTIVE', 0, 2, 8, 26),
(69, '304B', 'Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales', 'ACTIVE', 0, 2, 8, 26),
(70, '304C', 'Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales', 'ACTIVE', 0, 2, 8, 26),
(71, '304D', 'Pagos a artistas por sus actividades ejercidas como tales', 'ACTIVE', 0, 2, 8, 26),
(72, '304E', 'Honorarios y demás pagos por servicios de docencia', 'ACTIVE', 0, 2, 8, 26),
(73, '307', 'Servicios predomina la mano de obra', 'ACTIVE', 0, 2, 2, 25),
(74, '308', 'Utilización o aprovechamiento de la imagen o renombre', 'ACTIVE', 0, 2, 10, 27),
(75, '309', 'Servicios prestados por medios de comunicación y agencias de publicidad', 'ACTIVE', 0, 2, 1, 24),
(76, '310', 'Servicio de transporte privado de pasajeros o transporte público o privado de carga', 'ACTIVE', 0, 2, 1, 24),
(77, '311', 'Pagos a través de liquidación de compra (nivel cultural o rusticidad)', 'ACTIVE', 0, 2, 2, 25),
(78, '312', 'Transferencia de bienes muebles de naturaleza corporal', 'ACTIVE', 0, 2, 1, 24),
(79, '312A', 'Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, y forestal', 'ACTIVE', 0, 2, 1, 24),
(80, '312B', 'Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera', 'ACTIVE', 0, 2, 1, 24),
(81, '314A', 'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales', 'ACTIVE', 0, 2, 8, 26),
(82, '314B', 'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales', 'ACTIVE', 0, 2, 8, 26),
(83, '314C', 'Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades', 'ACTIVE', 0, 2, 8, 26),
(84, '314D', 'Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades', 'ACTIVE', 0, 2, 8, 26),
(85, '319', 'Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra', 'ACTIVE', 0, 2, 1, 24),
(86, '320', 'Arrendamiento bienes inmuebles', 'ACTIVE', 0, 2, 8, 26),
(87, '322', 'Seguros y reaseguros (primas y cesiones)', 'ACTIVE', 0, 2, 1, 24),
(88, '323', 'Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)', 'ACTIVE', 0, 2, 2, 25),
(89, '323A', 'Rendimientos financieros: depósitos Cta. Corriente', 'ACTIVE', 0, 2, 2, 25),
(90, '323B1', 'Rendimientos financieros:  depósitos Cta. Ahorros Sociedades', 'ACTIVE', 0, 2, 2, 25),
(91, '323E', 'Rendimientos financieros: depósito a plazo fijo  gravados', 'ACTIVE', 0, 2, 2, 25),
(92, '323E2', 'Rendimientos financieros: depósito a plazo fijo exentos', 'ACTIVE', 0, 2, 0, 24),
(93, '323F', 'Rendimientos financieros: operaciones de reporto - repos', 'ACTIVE', 0, 2, 2, 25),
(94, '323G', 'Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs', 'ACTIVE', 0, 2, 2, 25),
(95, '323H', 'Rendimientos financieros: obligaciones', 'ACTIVE', 0, 2, 2, 25),
(96, '323I', 'Rendimientos financieros: bonos convertible en acciones', 'ACTIVE', 0, 2, 2, 25),
(97, '323 M', 'Rendimientos financieros: Inversiones en títulos valores en renta fija gravados ', 'ACTIVE', 0, 2, 2, 25),
(98, '323 N', 'Rendimientos financieros: Inversiones en títulos valores en renta fija exentos', 'ACTIVE', 0, 2, 0, 24),
(99, '323 O', 'Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria', 'ACTIVE', 0, 2, 0, 24),
(100, '323 P', 'Intereses pagados por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', 0, 2, 2, 25),
(101, '323Q', 'Otros intereses y rendimientos financieros gravados ', 'ACTIVE', 0, 2, 2, 25),
(102, '323R', 'Otros intereses y rendimientos financieros exentos', 'ACTIVE', 0, 2, 0, 24),
(103, '323S', 'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades', 'ACTIVE', 0, 2, 2, 25),
(104, '323T', 'Rendimientos financieros originados en la deuda pública ecuatoriana', 'ACTIVE', 0, 2, 0, 24),
(105, '323U', 'Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada', 'ACTIVE', 0, 2, 0, 24),
(106, '324A', 'Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.', 'ACTIVE', 0, 2, 1, 24),
(107, '324B', 'Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria', 'ACTIVE', 0, 2, 1, 24),
(108, '324C', 'Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero', 'ACTIVE', 0, 2, 1, 24),
(109, '328', 'Dividendos distribuidos a sociedades residentes', 'ACTIVE', 0, 2, 0, 24),
(110, '329', 'Dividendos distribuidos a fideicomisos residentes', 'ACTIVE', 0, 2, 0, 24),
(111, '343', 'Otras retenciones aplicables el 1%', 'ACTIVE', 0, 2, 1, 24),
(112, '343A', 'Energía eléctrica', 'ACTIVE', 0, 2, 1, 24),
(113, '343B', 'Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares', 'ACTIVE', 0, 2, 1, 24),
(114, '343C', 'Impuesto Redimible a las botellas plásticas - IRBP', 'ACTIVE', 0, 2, 1, 24),
(115, '344', 'Otras retenciones aplicables el 2%', 'ACTIVE', 0, 2, 2, 25),
(116, '344A', 'Pago local tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP', 'ACTIVE', 0, 2, 2, 25),
(117, '344B', 'Adquisición de sustancias minerales dentro del territorio nacional', 'ACTIVE', 0, 2, 2, 25),
(118, '345', 'Otras retenciones aplicables el 8%', 'ACTIVE', 0, 2, 8, 26);

--
-- Dumping data for table `retention_tax_type`
--

INSERT INTO `retention_tax_type` (`id`, `value`, `description`, `status`, `type`) VALUES
(1, 'Retención IR Compras', NULL, 'ACTIVE', 1),
(2, 'Retención IR Ventas', NULL, 'ACTIVE', 1),
(3, 'Retención Iva Compras', NULL, 'ACTIVE', 0),
(4, 'Retención Iva Ventas', NULL, 'ACTIVE', 0);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GOD', 'ACTIVE', NULL, NULL),
(2, 'BUSINESS', 'ACTIVE', '2020-06-14 18:50:42', '2020-06-14 18:50:42'),
(3, 'EMPLOYER', 'ACTIVE', '2020-06-14 19:08:45', '2020-06-14 22:10:21'),
(4, 'CUSTOMER', 'ACTIVE', '2020-06-14 19:17:10', '2020-06-14 19:17:10');

--
-- Dumping data for table `routes_drawing`
--

INSERT INTO `routes_drawing` (`id`, `type`, `name`, `description`, `options_type`) VALUES
(1, 0, 'Dirección de Turismo - Otavalo', 'Información turística y entrega de guías turísticas impresas. Atención de lunes a sábado de 8:00 a 17:00', '{\"position\":{\"lat\":0.230731,\"lng\":-78.262207}}'),
(2, 0, 'Entrada a la Cascada de Peguche', '', '{\"position\":{\"lat\":0.243178,\"lng\":-78.242599}}'),
(3, 0, 'Estación de Policía', '', '{\"position\":{\"lat\":0.243348,\"lng\":-78.245392}}'),
(4, 0, 'Plaza Cultural de Peguche', '', '{\"position\":{\"lat\":0.250165,\"lng\":-78.243584}}'),
(5, 0, 'Plaza de Quinchuquí', '', '{\"position\":{\"lat\":0.252446,\"lng\":-78.234261}}'),
(6, 0, 'Rotonda', '', '{\"position\":{\"lat\":0.251294,\"lng\":-78.243927}}'),
(7, 0, 'Terminal de buses', '', '{\"position\":{\"lat\":0.230786,\"lng\":-78.257942}}'),
(8, 0, 'Wuantun Rumi', 'Elevación: 2939 m', '{\"position\":{\"lat\":0.253548,\"lng\":-78.217361}}'),
(9, 4, 'POLILINE', '', '{\"strokeColor\":\"#F01641\",\"strokeOpacity\":1,\"strokeWeight\":4,\"path\":[{\"lat\":\"0.230731\",\"lng\":\"-78.262207\"},{\"lat\":\"0.230839\",\"lng\":\"-78.262383\"},{\"lat\":\"0.230901\",\"lng\":\"-78.262451\"},{\"lat\":\"0.230969\",\"lng\":\"-78.262535\"},{\"lat\":\"0.231146\",\"lng\":\"-78.262718\"},{\"lat\":\"0.231225\",\"lng\":\"-78.262787\"},{\"lat\":\"0.231327\",\"lng\":\"-78.262856\"},{\"lat\":\"0.23142\",\"lng\":\"-78.262878\"},{\"lat\":\"0.231541\",\"lng\":\"-78.262817\"},{\"lat\":\"0.231665\",\"lng\":\"-78.262733\"},{\"lat\":\"0.231751\",\"lng\":\"-78.262642\"},{\"lat\":\"0.231813\",\"lng\":\"-78.262566\"},{\"lat\":\"0.23177\",\"lng\":\"-78.262474\"},{\"lat\":\"0.231665\",\"lng\":\"-78.26236\"},{\"lat\":\"0.231599\",\"lng\":\"-78.262299\"},{\"lat\":\"0.231521\",\"lng\":\"-78.262222\"},{\"lat\":\"0.231446\",\"lng\":\"-78.262077\"},{\"lat\":\"0.231393\",\"lng\":\"-78.261978\"},{\"lat\":\"0.231341\",\"lng\":\"-78.261894\"},{\"lat\":\"0.231286\",\"lng\":\"-78.261749\"},{\"lat\":\"0.231216\",\"lng\":\"-78.261597\"},{\"lat\":\"0.231163\",\"lng\":\"-78.26152\"},{\"lat\":\"0.231108\",\"lng\":\"-78.261444\"},{\"lat\":\"0.231053\",\"lng\":\"-78.261368\"},{\"lat\":\"0.230996\",\"lng\":\"-78.261299\"},{\"lat\":\"0.230888\",\"lng\":\"-78.261162\"},{\"lat\":\"0.230813\",\"lng\":\"-78.26107\"},{\"lat\":\"0.230713\",\"lng\":\"-78.260994\"},{\"lat\":\"0.230627\",\"lng\":\"-78.260948\"},{\"lat\":\"0.230563\",\"lng\":\"-78.26088\"},{\"lat\":\"0.230487\",\"lng\":\"-78.26078\"},{\"lat\":\"0.230414\",\"lng\":\"-78.260674\"},{\"lat\":\"0.230345\",\"lng\":\"-78.260612\"},{\"lat\":\"0.230267\",\"lng\":\"-78.260529\"},{\"lat\":\"0.230246\",\"lng\":\"-78.260414\"},{\"lat\":\"0.2302\",\"lng\":\"-78.26033\"},{\"lat\":\"0.230149\",\"lng\":\"-78.260201\"},{\"lat\":\"0.2301\",\"lng\":\"-78.260109\"},{\"lat\":\"0.230028\",\"lng\":\"-78.260025\"},{\"lat\":\"0.229954\",\"lng\":\"-78.259926\"},{\"lat\":\"0.229877\",\"lng\":\"-78.259834\"},{\"lat\":\"0.229814\",\"lng\":\"-78.259758\"},{\"lat\":\"0.229753\",\"lng\":\"-78.259689\"},{\"lat\":\"0.229681\",\"lng\":\"-78.259605\"},{\"lat\":\"0.229602\",\"lng\":\"-78.259521\"},{\"lat\":\"0.229509\",\"lng\":\"-78.259407\"},{\"lat\":\"0.229401\",\"lng\":\"-78.259277\"},{\"lat\":\"0.229307\",\"lng\":\"-78.259148\"},{\"lat\":\"0.229234\",\"lng\":\"-78.259048\"},{\"lat\":\"0.229179\",\"lng\":\"-78.258957\"},{\"lat\":\"0.229151\",\"lng\":\"-78.258858\"},{\"lat\":\"0.229208\",\"lng\":\"-78.258728\"},{\"lat\":\"0.229334\",\"lng\":\"-78.258652\"},{\"lat\":\"0.229487\",\"lng\":\"-78.258591\"},{\"lat\":\"0.22957\",\"lng\":\"-78.258545\"},{\"lat\":\"0.229712\",\"lng\":\"-78.258476\"},{\"lat\":\"0.229831\",\"lng\":\"-78.258408\"},{\"lat\":\"0.229925\",\"lng\":\"-78.258339\"},{\"lat\":\"0.230014\",\"lng\":\"-78.258286\"},{\"lat\":\"0.230098\",\"lng\":\"-78.258232\"},{\"lat\":\"0.230184\",\"lng\":\"-78.258179\"},{\"lat\":\"0.23026\",\"lng\":\"-78.258118\"},{\"lat\":\"0.230341\",\"lng\":\"-78.258057\"},{\"lat\":\"0.230468\",\"lng\":\"-78.25795\"},{\"lat\":\"0.230549\",\"lng\":\"-78.257889\"},{\"lat\":\"0.230626\",\"lng\":\"-78.257835\"},{\"lat\":\"0.230698\",\"lng\":\"-78.257767\"},{\"lat\":\"0.230788\",\"lng\":\"-78.257698\"},{\"lat\":\"0.230884\",\"lng\":\"-78.257637\"},{\"lat\":\"0.230958\",\"lng\":\"-78.257568\"},{\"lat\":\"0.231065\",\"lng\":\"-78.257492\"},{\"lat\":\"0.23117\",\"lng\":\"-78.257416\"},{\"lat\":\"0.23126\",\"lng\":\"-78.257347\"},{\"lat\":\"0.231348\",\"lng\":\"-78.257278\"},{\"lat\":\"0.231427\",\"lng\":\"-78.25721\"},{\"lat\":\"0.231514\",\"lng\":\"-78.257141\"},{\"lat\":\"0.231603\",\"lng\":\"-78.257088\"},{\"lat\":\"0.231716\",\"lng\":\"-78.257004\"},{\"lat\":\"0.231841\",\"lng\":\"-78.25692\"},{\"lat\":\"0.231968\",\"lng\":\"-78.256836\"},{\"lat\":\"0.23209\",\"lng\":\"-78.256767\"},{\"lat\":\"0.232194\",\"lng\":\"-78.256706\"},{\"lat\":\"0.232269\",\"lng\":\"-78.25666\"},{\"lat\":\"0.232376\",\"lng\":\"-78.256592\"},{\"lat\":\"0.232466\",\"lng\":\"-78.256538\"},{\"lat\":\"0.232576\",\"lng\":\"-78.25647\"},{\"lat\":\"0.232708\",\"lng\":\"-78.256393\"},{\"lat\":\"0.232861\",\"lng\":\"-78.256287\"},{\"lat\":\"0.232942\",\"lng\":\"-78.256241\"},{\"lat\":\"0.233023\",\"lng\":\"-78.256195\"},{\"lat\":\"0.233107\",\"lng\":\"-78.256149\"},{\"lat\":\"0.233194\",\"lng\":\"-78.256104\"},{\"lat\":\"0.23328\",\"lng\":\"-78.256058\"},{\"lat\":\"0.233371\",\"lng\":\"-78.25602\"},{\"lat\":\"0.23346\",\"lng\":\"-78.255974\"},{\"lat\":\"0.233551\",\"lng\":\"-78.255928\"},{\"lat\":\"0.233639\",\"lng\":\"-78.25589\"},{\"lat\":\"0.233721\",\"lng\":\"-78.255844\"},{\"lat\":\"0.233874\",\"lng\":\"-78.255775\"},{\"lat\":\"0.234006\",\"lng\":\"-78.255722\"},{\"lat\":\"0.234091\",\"lng\":\"-78.255684\"},{\"lat\":\"0.234175\",\"lng\":\"-78.25563\"},{\"lat\":\"0.23427\",\"lng\":\"-78.255585\"},{\"lat\":\"0.234399\",\"lng\":\"-78.255524\"},{\"lat\":\"0.234546\",\"lng\":\"-78.255455\"},{\"lat\":\"0.234703\",\"lng\":\"-78.255371\"},{\"lat\":\"0.234784\",\"lng\":\"-78.255325\"},{\"lat\":\"0.234868\",\"lng\":\"-78.25528\"},{\"lat\":\"0.23495\",\"lng\":\"-78.255234\"},{\"lat\":\"0.235097\",\"lng\":\"-78.25515\"},{\"lat\":\"0.235236\",\"lng\":\"-78.255074\"},{\"lat\":\"0.235356\",\"lng\":\"-78.25502\"},{\"lat\":\"0.235464\",\"lng\":\"-78.254967\"},{\"lat\":\"0.235546\",\"lng\":\"-78.254921\"},{\"lat\":\"0.235648\",\"lng\":\"-78.254852\"},{\"lat\":\"0.235647\",\"lng\":\"-78.254745\"},{\"lat\":\"0.235583\",\"lng\":\"-78.254654\"},{\"lat\":\"0.235513\",\"lng\":\"-78.254532\"},{\"lat\":\"0.23543\",\"lng\":\"-78.254379\"},{\"lat\":\"0.235387\",\"lng\":\"-78.254295\"},{\"lat\":\"0.235342\",\"lng\":\"-78.254211\"},{\"lat\":\"0.235294\",\"lng\":\"-78.254128\"},{\"lat\":\"0.235246\",\"lng\":\"-78.254044\"},{\"lat\":\"0.235154\",\"lng\":\"-78.253876\"},{\"lat\":\"0.235107\",\"lng\":\"-78.253792\"},{\"lat\":\"0.235016\",\"lng\":\"-78.253632\"},{\"lat\":\"0.234972\",\"lng\":\"-78.253548\"},{\"lat\":\"0.234929\",\"lng\":\"-78.253464\"},{\"lat\":\"0.234845\",\"lng\":\"-78.253319\"},{\"lat\":\"0.234779\",\"lng\":\"-78.253197\"},{\"lat\":\"0.234727\",\"lng\":\"-78.253098\"},{\"lat\":\"0.234671\",\"lng\":\"-78.252998\"},{\"lat\":\"0.234622\",\"lng\":\"-78.252907\"},{\"lat\":\"0.234576\",\"lng\":\"-78.252808\"},{\"lat\":\"0.234641\",\"lng\":\"-78.252731\"},{\"lat\":\"0.234766\",\"lng\":\"-78.252663\"},{\"lat\":\"0.234881\",\"lng\":\"-78.252602\"},{\"lat\":\"0.235015\",\"lng\":\"-78.252533\"},{\"lat\":\"0.235158\",\"lng\":\"-78.252464\"},{\"lat\":\"0.235303\",\"lng\":\"-78.252396\"},{\"lat\":\"0.235454\",\"lng\":\"-78.252319\"},{\"lat\":\"0.2356\",\"lng\":\"-78.252258\"},{\"lat\":\"0.235743\",\"lng\":\"-78.252182\"},{\"lat\":\"0.235876\",\"lng\":\"-78.252121\"},{\"lat\":\"0.235995\",\"lng\":\"-78.25206\"},{\"lat\":\"0.236128\",\"lng\":\"-78.251991\"},{\"lat\":\"0.236266\",\"lng\":\"-78.251923\"},{\"lat\":\"0.236365\",\"lng\":\"-78.251869\"},{\"lat\":\"0.236455\",\"lng\":\"-78.251816\"},{\"lat\":\"0.236575\",\"lng\":\"-78.25177\"},{\"lat\":\"0.236702\",\"lng\":\"-78.251709\"},{\"lat\":\"0.236793\",\"lng\":\"-78.251671\"},{\"lat\":\"0.236921\",\"lng\":\"-78.251595\"},{\"lat\":\"0.237041\",\"lng\":\"-78.251526\"},{\"lat\":\"0.237175\",\"lng\":\"-78.251465\"},{\"lat\":\"0.237307\",\"lng\":\"-78.251404\"},{\"lat\":\"0.237448\",\"lng\":\"-78.251335\"},{\"lat\":\"0.237598\",\"lng\":\"-78.251266\"},{\"lat\":\"0.23775\",\"lng\":\"-78.25119\"},{\"lat\":\"0.237894\",\"lng\":\"-78.251114\"},{\"lat\":\"0.238037\",\"lng\":\"-78.251038\"},{\"lat\":\"0.238152\",\"lng\":\"-78.250984\"},{\"lat\":\"0.238245\",\"lng\":\"-78.250954\"},{\"lat\":\"0.238358\",\"lng\":\"-78.250916\"},{\"lat\":\"0.238459\",\"lng\":\"-78.25087\"},{\"lat\":\"0.238565\",\"lng\":\"-78.250824\"},{\"lat\":\"0.238671\",\"lng\":\"-78.250771\"},{\"lat\":\"0.238748\",\"lng\":\"-78.250717\"},{\"lat\":\"0.238836\",\"lng\":\"-78.250671\"},{\"lat\":\"0.238942\",\"lng\":\"-78.250626\"},{\"lat\":\"0.239051\",\"lng\":\"-78.250587\"},{\"lat\":\"0.239138\",\"lng\":\"-78.250534\"},{\"lat\":\"0.23922\",\"lng\":\"-78.250465\"},{\"lat\":\"0.239322\",\"lng\":\"-78.250397\"},{\"lat\":\"0.239406\",\"lng\":\"-78.25032\"},{\"lat\":\"0.239485\",\"lng\":\"-78.250252\"},{\"lat\":\"0.239556\",\"lng\":\"-78.250198\"},{\"lat\":\"0.239624\",\"lng\":\"-78.250122\"},{\"lat\":\"0.239679\",\"lng\":\"-78.250046\"},{\"lat\":\"0.239755\",\"lng\":\"-78.249954\"},{\"lat\":\"0.239825\",\"lng\":\"-78.249847\"},{\"lat\":\"0.239901\",\"lng\":\"-78.249718\"},{\"lat\":\"0.239986\",\"lng\":\"-78.24958\"},{\"lat\":\"0.240066\",\"lng\":\"-78.249451\"},{\"lat\":\"0.240118\",\"lng\":\"-78.249359\"},{\"lat\":\"0.24018\",\"lng\":\"-78.249245\"},{\"lat\":\"0.240236\",\"lng\":\"-78.249146\"},{\"lat\":\"0.240306\",\"lng\":\"-78.249016\"},{\"lat\":\"0.240386\",\"lng\":\"-78.248886\"},{\"lat\":\"0.240469\",\"lng\":\"-78.248741\"},{\"lat\":\"0.240543\",\"lng\":\"-78.248619\"},{\"lat\":\"0.240592\",\"lng\":\"-78.24852\"},{\"lat\":\"0.240635\",\"lng\":\"-78.248428\"},{\"lat\":\"0.240699\",\"lng\":\"-78.248306\"},{\"lat\":\"0.240769\",\"lng\":\"-78.248177\"},{\"lat\":\"0.240844\",\"lng\":\"-78.248024\"},{\"lat\":\"0.240906\",\"lng\":\"-78.247871\"},{\"lat\":\"0.240958\",\"lng\":\"-78.247734\"},{\"lat\":\"0.240996\",\"lng\":\"-78.247574\"},{\"lat\":\"0.241012\",\"lng\":\"-78.247482\"},{\"lat\":\"0.241028\",\"lng\":\"-78.247383\"},{\"lat\":\"0.241042\",\"lng\":\"-78.247276\"},{\"lat\":\"0.241054\",\"lng\":\"-78.247169\"},{\"lat\":\"0.241065\",\"lng\":\"-78.247063\"},{\"lat\":\"0.241077\",\"lng\":\"-78.246956\"},{\"lat\":\"0.241088\",\"lng\":\"-78.246864\"},{\"lat\":\"0.2411\",\"lng\":\"-78.246712\"},{\"lat\":\"0.241103\",\"lng\":\"-78.246552\"},{\"lat\":\"0.241102\",\"lng\":\"-78.246384\"},{\"lat\":\"0.241112\",\"lng\":\"-78.246201\"},{\"lat\":\"0.24114\",\"lng\":\"-78.246033\"},{\"lat\":\"0.241224\",\"lng\":\"-78.245888\"},{\"lat\":\"0.241297\",\"lng\":\"-78.245827\"},{\"lat\":\"0.241457\",\"lng\":\"-78.245766\"},{\"lat\":\"0.241624\",\"lng\":\"-78.245705\"},{\"lat\":\"0.241791\",\"lng\":\"-78.245644\"},{\"lat\":\"0.241879\",\"lng\":\"-78.245613\"},{\"lat\":\"0.241966\",\"lng\":\"-78.245583\"},{\"lat\":\"0.242141\",\"lng\":\"-78.24556\"},{\"lat\":\"0.242318\",\"lng\":\"-78.245544\"},{\"lat\":\"0.242411\",\"lng\":\"-78.245537\"},{\"lat\":\"0.242502\",\"lng\":\"-78.245537\"},{\"lat\":\"0.242662\",\"lng\":\"-78.245544\"},{\"lat\":\"0.242802\",\"lng\":\"-78.245552\"},{\"lat\":\"0.242936\",\"lng\":\"-78.24556\"},{\"lat\":\"0.243048\",\"lng\":\"-78.245575\"},{\"lat\":\"0.243146\",\"lng\":\"-78.245567\"},{\"lat\":\"0.243275\",\"lng\":\"-78.245529\"},{\"lat\":\"0.243344\",\"lng\":\"-78.245438\"},{\"lat\":\"0.243391\",\"lng\":\"-78.245316\"},{\"lat\":\"0.243418\",\"lng\":\"-78.245201\"},{\"lat\":\"0.243436\",\"lng\":\"-78.245102\"},{\"lat\":\"0.243409\",\"lng\":\"-78.244957\"},{\"lat\":\"0.243374\",\"lng\":\"-78.244781\"},{\"lat\":\"0.243348\",\"lng\":\"-78.244621\"},{\"lat\":\"0.243331\",\"lng\":\"-78.244492\"},{\"lat\":\"0.24332\",\"lng\":\"-78.244362\"},{\"lat\":\"0.243306\",\"lng\":\"-78.244217\"},{\"lat\":\"0.243288\",\"lng\":\"-78.244064\"},{\"lat\":\"0.243262\",\"lng\":\"-78.243912\"},{\"lat\":\"0.243231\",\"lng\":\"-78.243752\"},{\"lat\":\"0.24321\",\"lng\":\"-78.2435\"},{\"lat\":\"0.243203\",\"lng\":\"-78.24334\"},{\"lat\":\"0.243198\",\"lng\":\"-78.243172\"},{\"lat\":\"0.243193\",\"lng\":\"-78.243004\"},{\"lat\":\"0.243185\",\"lng\":\"-78.242859\"},{\"lat\":\"0.243178\",\"lng\":\"-78.242722\"},{\"lat\":\"0.24317\",\"lng\":\"-78.242615\"},{\"lat\":\"0.243229\",\"lng\":\"-78.242523\"},{\"lat\":\"0.243319\",\"lng\":\"-78.242493\"},{\"lat\":\"0.243468\",\"lng\":\"-78.24247\"},{\"lat\":\"0.243611\",\"lng\":\"-78.242477\"},{\"lat\":\"0.243703\",\"lng\":\"-78.242477\"},{\"lat\":\"0.243806\",\"lng\":\"-78.242485\"},{\"lat\":\"0.243904\",\"lng\":\"-78.242493\"},{\"lat\":\"0.244009\",\"lng\":\"-78.2425\"},{\"lat\":\"0.244115\",\"lng\":\"-78.242508\"},{\"lat\":\"0.244223\",\"lng\":\"-78.242516\"},{\"lat\":\"0.244333\",\"lng\":\"-78.242523\"},{\"lat\":\"0.244452\",\"lng\":\"-78.242531\"},{\"lat\":\"0.244574\",\"lng\":\"-78.242538\"},{\"lat\":\"0.244698\",\"lng\":\"-78.242546\"},{\"lat\":\"0.244825\",\"lng\":\"-78.242554\"},{\"lat\":\"0.244954\",\"lng\":\"-78.242569\"},{\"lat\":\"0.245071\",\"lng\":\"-78.242577\"},{\"lat\":\"0.245189\",\"lng\":\"-78.242584\"},{\"lat\":\"0.245305\",\"lng\":\"-78.242592\"},{\"lat\":\"0.245424\",\"lng\":\"-78.242599\"},{\"lat\":\"0.245544\",\"lng\":\"-78.242615\"},{\"lat\":\"0.245665\",\"lng\":\"-78.24263\"},{\"lat\":\"0.24579\",\"lng\":\"-78.242638\"},{\"lat\":\"0.24592\",\"lng\":\"-78.242653\"},{\"lat\":\"0.246045\",\"lng\":\"-78.242661\"},{\"lat\":\"0.24617\",\"lng\":\"-78.242676\"},{\"lat\":\"0.246297\",\"lng\":\"-78.242691\"},{\"lat\":\"0.246418\",\"lng\":\"-78.242706\"},{\"lat\":\"0.246534\",\"lng\":\"-78.242722\"},{\"lat\":\"0.246654\",\"lng\":\"-78.242752\"},{\"lat\":\"0.246765\",\"lng\":\"-78.242775\"},{\"lat\":\"0.246873\",\"lng\":\"-78.242805\"},{\"lat\":\"0.246975\",\"lng\":\"-78.242828\"},{\"lat\":\"0.247083\",\"lng\":\"-78.242851\"},{\"lat\":\"0.247182\",\"lng\":\"-78.242859\"},{\"lat\":\"0.247279\",\"lng\":\"-78.242874\"},{\"lat\":\"0.247451\",\"lng\":\"-78.242897\"},{\"lat\":\"0.247622\",\"lng\":\"-78.242912\"},{\"lat\":\"0.247717\",\"lng\":\"-78.24292\"},{\"lat\":\"0.247917\",\"lng\":\"-78.242935\"},{\"lat\":\"0.248021\",\"lng\":\"-78.242943\"},{\"lat\":\"0.24813\",\"lng\":\"-78.24295\"},{\"lat\":\"0.248239\",\"lng\":\"-78.242966\"},{\"lat\":\"0.248342\",\"lng\":\"-78.242973\"},{\"lat\":\"0.248448\",\"lng\":\"-78.242989\"},{\"lat\":\"0.248547\",\"lng\":\"-78.243011\"},{\"lat\":\"0.248642\",\"lng\":\"-78.243019\"},{\"lat\":\"0.248736\",\"lng\":\"-78.243027\"},{\"lat\":\"0.24883\",\"lng\":\"-78.243042\"},{\"lat\":\"0.248921\",\"lng\":\"-78.24305\"},{\"lat\":\"0.249104\",\"lng\":\"-78.243073\"},{\"lat\":\"0.2492\",\"lng\":\"-78.243088\"},{\"lat\":\"0.24929\",\"lng\":\"-78.243111\"},{\"lat\":\"0.249452\",\"lng\":\"-78.243172\"},{\"lat\":\"0.249584\",\"lng\":\"-78.243271\"},{\"lat\":\"0.249773\",\"lng\":\"-78.243439\"},{\"lat\":\"0.249939\",\"lng\":\"-78.243515\"},{\"lat\":\"0.25003\",\"lng\":\"-78.243561\"},{\"lat\":\"0.25013\",\"lng\":\"-78.243591\"},{\"lat\":\"0.250231\",\"lng\":\"-78.243645\"},{\"lat\":\"0.250372\",\"lng\":\"-78.243721\"},{\"lat\":\"0.250513\",\"lng\":\"-78.243759\"},{\"lat\":\"0.250672\",\"lng\":\"-78.24379\"},{\"lat\":\"0.250779\",\"lng\":\"-78.243813\"},{\"lat\":\"0.250875\",\"lng\":\"-78.243835\"},{\"lat\":\"0.250985\",\"lng\":\"-78.243858\"},{\"lat\":\"0.251075\",\"lng\":\"-78.243904\"},{\"lat\":\"0.251171\",\"lng\":\"-78.243919\"},{\"lat\":\"0.251283\",\"lng\":\"-78.243927\"},{\"lat\":\"0.251335\",\"lng\":\"-78.243843\"},{\"lat\":\"0.251375\",\"lng\":\"-78.243721\"},{\"lat\":\"0.251421\",\"lng\":\"-78.243645\"},{\"lat\":\"0.251465\",\"lng\":\"-78.243561\"},{\"lat\":\"0.251504\",\"lng\":\"-78.243454\"},{\"lat\":\"0.251514\",\"lng\":\"-78.243332\"},{\"lat\":\"0.251522\",\"lng\":\"-78.243217\"},{\"lat\":\"0.251534\",\"lng\":\"-78.243095\"},{\"lat\":\"0.251546\",\"lng\":\"-78.242981\"},{\"lat\":\"0.251552\",\"lng\":\"-78.242867\"},{\"lat\":\"0.251563\",\"lng\":\"-78.24276\"},{\"lat\":\"0.251582\",\"lng\":\"-78.242645\"},{\"lat\":\"0.251593\",\"lng\":\"-78.242538\"},{\"lat\":\"0.251604\",\"lng\":\"-78.242447\"},{\"lat\":\"0.251624\",\"lng\":\"-78.242325\"},{\"lat\":\"0.251631\",\"lng\":\"-78.242226\"},{\"lat\":\"0.251636\",\"lng\":\"-78.242096\"},{\"lat\":\"0.251655\",\"lng\":\"-78.241959\"},{\"lat\":\"0.251668\",\"lng\":\"-78.241814\"},{\"lat\":\"0.251679\",\"lng\":\"-78.241669\"},{\"lat\":\"0.251688\",\"lng\":\"-78.241539\"},{\"lat\":\"0.251699\",\"lng\":\"-78.241432\"},{\"lat\":\"0.251705\",\"lng\":\"-78.241325\"},{\"lat\":\"0.251709\",\"lng\":\"-78.241219\"},{\"lat\":\"0.251718\",\"lng\":\"-78.241112\"},{\"lat\":\"0.251724\",\"lng\":\"-78.24099\"},{\"lat\":\"0.251734\",\"lng\":\"-78.240898\"},{\"lat\":\"0.251748\",\"lng\":\"-78.240784\"},{\"lat\":\"0.251758\",\"lng\":\"-78.240669\"},{\"lat\":\"0.251782\",\"lng\":\"-78.240547\"},{\"lat\":\"0.251795\",\"lng\":\"-78.240448\"},{\"lat\":\"0.251814\",\"lng\":\"-78.240349\"},{\"lat\":\"0.25183\",\"lng\":\"-78.24025\"},{\"lat\":\"0.251859\",\"lng\":\"-78.24012\"},{\"lat\":\"0.251881\",\"lng\":\"-78.240028\"},{\"lat\":\"0.251916\",\"lng\":\"-78.239906\"},{\"lat\":\"0.251947\",\"lng\":\"-78.239792\"},{\"lat\":\"0.251952\",\"lng\":\"-78.23967\"},{\"lat\":\"0.251956\",\"lng\":\"-78.239578\"},{\"lat\":\"0.251968\",\"lng\":\"-78.239441\"},{\"lat\":\"0.251981\",\"lng\":\"-78.239342\"},{\"lat\":\"0.251991\",\"lng\":\"-78.23925\"},{\"lat\":\"0.251936\",\"lng\":\"-78.239174\"},{\"lat\":\"0.251914\",\"lng\":\"-78.239052\"},{\"lat\":\"0.251917\",\"lng\":\"-78.23896\"},{\"lat\":\"0.251928\",\"lng\":\"-78.238861\"},{\"lat\":\"0.251939\",\"lng\":\"-78.23877\"},{\"lat\":\"0.251943\",\"lng\":\"-78.238663\"},{\"lat\":\"0.251938\",\"lng\":\"-78.238541\"},{\"lat\":\"0.251926\",\"lng\":\"-78.238449\"},{\"lat\":\"0.251925\",\"lng\":\"-78.238358\"},{\"lat\":\"0.251933\",\"lng\":\"-78.238266\"},{\"lat\":\"0.251942\",\"lng\":\"-78.238144\"},{\"lat\":\"0.251938\",\"lng\":\"-78.238037\"},{\"lat\":\"0.251917\",\"lng\":\"-78.237915\"},{\"lat\":\"0.25191\",\"lng\":\"-78.237778\"},{\"lat\":\"0.251915\",\"lng\":\"-78.237671\"},{\"lat\":\"0.251922\",\"lng\":\"-78.237541\"},{\"lat\":\"0.251937\",\"lng\":\"-78.237404\"},{\"lat\":\"0.251961\",\"lng\":\"-78.237267\"},{\"lat\":\"0.251988\",\"lng\":\"-78.237114\"},{\"lat\":\"0.252006\",\"lng\":\"-78.236954\"},{\"lat\":\"0.25201\",\"lng\":\"-78.236794\"},{\"lat\":\"0.252006\",\"lng\":\"-78.236671\"},{\"lat\":\"0.251997\",\"lng\":\"-78.236557\"},{\"lat\":\"0.251988\",\"lng\":\"-78.236443\"},{\"lat\":\"0.251983\",\"lng\":\"-78.236336\"},{\"lat\":\"0.251979\",\"lng\":\"-78.236229\"},{\"lat\":\"0.251979\",\"lng\":\"-78.236099\"},{\"lat\":\"0.251988\",\"lng\":\"-78.235954\"},{\"lat\":\"0.251991\",\"lng\":\"-78.235786\"},{\"lat\":\"0.251981\",\"lng\":\"-78.235611\"},{\"lat\":\"0.251978\",\"lng\":\"-78.235481\"},{\"lat\":\"0.251977\",\"lng\":\"-78.235359\"},{\"lat\":\"0.25198\",\"lng\":\"-78.235214\"},{\"lat\":\"0.251993\",\"lng\":\"-78.235062\"},{\"lat\":\"0.252055\",\"lng\":\"-78.234947\"},{\"lat\":\"0.25213\",\"lng\":\"-78.23484\"},{\"lat\":\"0.252209\",\"lng\":\"-78.234772\"},{\"lat\":\"0.252299\",\"lng\":\"-78.234688\"},{\"lat\":\"0.252374\",\"lng\":\"-78.234596\"},{\"lat\":\"0.25239\",\"lng\":\"-78.234489\"},{\"lat\":\"0.252379\",\"lng\":\"-78.234375\"},{\"lat\":\"0.252427\",\"lng\":\"-78.234291\"},{\"lat\":\"0.25244\",\"lng\":\"-78.234154\"},{\"lat\":\"0.252431\",\"lng\":\"-78.234016\"},{\"lat\":\"0.252421\",\"lng\":\"-78.23391\"},{\"lat\":\"0.252416\",\"lng\":\"-78.233803\"},{\"lat\":\"0.252401\",\"lng\":\"-78.233681\"},{\"lat\":\"0.252402\",\"lng\":\"-78.233574\"},{\"lat\":\"0.252395\",\"lng\":\"-78.233459\"},{\"lat\":\"0.252387\",\"lng\":\"-78.233353\"},{\"lat\":\"0.252382\",\"lng\":\"-78.233231\"},{\"lat\":\"0.25238\",\"lng\":\"-78.233109\"},{\"lat\":\"0.252379\",\"lng\":\"-78.232994\"},{\"lat\":\"0.252381\",\"lng\":\"-78.232887\"},{\"lat\":\"0.252377\",\"lng\":\"-78.23278\"},{\"lat\":\"0.252372\",\"lng\":\"-78.232666\"},{\"lat\":\"0.252367\",\"lng\":\"-78.232552\"},{\"lat\":\"0.25236\",\"lng\":\"-78.232437\"},{\"lat\":\"0.252349\",\"lng\":\"-78.232246\"},{\"lat\":\"0.25234\",\"lng\":\"-78.232124\"},{\"lat\":\"0.252339\",\"lng\":\"-78.232018\"},{\"lat\":\"0.252343\",\"lng\":\"-78.231888\"},{\"lat\":\"0.252328\",\"lng\":\"-78.231796\"},{\"lat\":\"0.252201\",\"lng\":\"-78.231743\"},{\"lat\":\"0.252085\",\"lng\":\"-78.231735\"},{\"lat\":\"0.252006\",\"lng\":\"-78.231667\"},{\"lat\":\"0.251982\",\"lng\":\"-78.23156\"},{\"lat\":\"0.252005\",\"lng\":\"-78.231468\"},{\"lat\":\"0.252011\",\"lng\":\"-78.231369\"},{\"lat\":\"0.25201\",\"lng\":\"-78.231262\"},{\"lat\":\"0.252003\",\"lng\":\"-78.231133\"},{\"lat\":\"0.251997\",\"lng\":\"-78.231003\"},{\"lat\":\"0.251993\",\"lng\":\"-78.230873\"},{\"lat\":\"0.251987\",\"lng\":\"-78.230743\"},{\"lat\":\"0.251989\",\"lng\":\"-78.230606\"},{\"lat\":\"0.251996\",\"lng\":\"-78.230476\"},{\"lat\":\"0.252003\",\"lng\":\"-78.230347\"},{\"lat\":\"0.252012\",\"lng\":\"-78.230232\"},{\"lat\":\"0.252026\",\"lng\":\"-78.23011\"},{\"lat\":\"0.252041\",\"lng\":\"-78.229996\"},{\"lat\":\"0.252048\",\"lng\":\"-78.229866\"},{\"lat\":\"0.252057\",\"lng\":\"-78.229736\"},{\"lat\":\"0.25207\",\"lng\":\"-78.229614\"},{\"lat\":\"0.252072\",\"lng\":\"-78.2295\"},{\"lat\":\"0.25207\",\"lng\":\"-78.22937\"},{\"lat\":\"0.252067\",\"lng\":\"-78.229256\"},{\"lat\":\"0.252089\",\"lng\":\"-78.229156\"},{\"lat\":\"0.252204\",\"lng\":\"-78.229118\"},{\"lat\":\"0.2523\",\"lng\":\"-78.229111\"},{\"lat\":\"0.252392\",\"lng\":\"-78.229065\"},{\"lat\":\"0.252422\",\"lng\":\"-78.228958\"},{\"lat\":\"0.252432\",\"lng\":\"-78.228851\"},{\"lat\":\"0.252439\",\"lng\":\"-78.228737\"},{\"lat\":\"0.252443\",\"lng\":\"-78.22863\"},{\"lat\":\"0.252389\",\"lng\":\"-78.228523\"},{\"lat\":\"0.252333\",\"lng\":\"-78.228447\"},{\"lat\":\"0.252303\",\"lng\":\"-78.228325\"},{\"lat\":\"0.252313\",\"lng\":\"-78.228203\"},{\"lat\":\"0.25232\",\"lng\":\"-78.228081\"},{\"lat\":\"0.252332\",\"lng\":\"-78.227966\"},{\"lat\":\"0.252334\",\"lng\":\"-78.227844\"},{\"lat\":\"0.252333\",\"lng\":\"-78.227745\"},{\"lat\":\"0.252329\",\"lng\":\"-78.227646\"},{\"lat\":\"0.252328\",\"lng\":\"-78.227531\"},{\"lat\":\"0.252319\",\"lng\":\"-78.227425\"},{\"lat\":\"0.252312\",\"lng\":\"-78.22731\"},{\"lat\":\"0.252309\",\"lng\":\"-78.227196\"},{\"lat\":\"0.252305\",\"lng\":\"-78.227097\"},{\"lat\":\"0.252301\",\"lng\":\"-78.226997\"},{\"lat\":\"0.2523\",\"lng\":\"-78.226868\"},{\"lat\":\"0.252299\",\"lng\":\"-78.226776\"},{\"lat\":\"0.252293\",\"lng\":\"-78.226677\"},{\"lat\":\"0.252297\",\"lng\":\"-78.226547\"},{\"lat\":\"0.252303\",\"lng\":\"-78.22644\"},{\"lat\":\"0.25231\",\"lng\":\"-78.226341\"},{\"lat\":\"0.252313\",\"lng\":\"-78.226242\"},{\"lat\":\"0.252314\",\"lng\":\"-78.226135\"},{\"lat\":\"0.252317\",\"lng\":\"-78.226028\"},{\"lat\":\"0.252324\",\"lng\":\"-78.225929\"},{\"lat\":\"0.252329\",\"lng\":\"-78.225822\"},{\"lat\":\"0.252328\",\"lng\":\"-78.225708\"},{\"lat\":\"0.252325\",\"lng\":\"-78.225609\"},{\"lat\":\"0.252326\",\"lng\":\"-78.225502\"},{\"lat\":\"0.25233\",\"lng\":\"-78.225403\"},{\"lat\":\"0.252334\",\"lng\":\"-78.225304\"},{\"lat\":\"0.252337\",\"lng\":\"-78.225204\"},{\"lat\":\"0.252334\",\"lng\":\"-78.22509\"},{\"lat\":\"0.252332\",\"lng\":\"-78.224983\"},{\"lat\":\"0.252331\",\"lng\":\"-78.224876\"},{\"lat\":\"0.252329\",\"lng\":\"-78.224777\"},{\"lat\":\"0.25233\",\"lng\":\"-78.224678\"},{\"lat\":\"0.252331\",\"lng\":\"-78.224571\"},{\"lat\":\"0.252333\",\"lng\":\"-78.224472\"},{\"lat\":\"0.252338\",\"lng\":\"-78.224365\"},{\"lat\":\"0.252339\",\"lng\":\"-78.224258\"},{\"lat\":\"0.252341\",\"lng\":\"-78.224152\"},{\"lat\":\"0.252343\",\"lng\":\"-78.224052\"},{\"lat\":\"0.252346\",\"lng\":\"-78.223946\"},{\"lat\":\"0.25234\",\"lng\":\"-78.223846\"},{\"lat\":\"0.25234\",\"lng\":\"-78.22374\"},{\"lat\":\"0.252345\",\"lng\":\"-78.22364\"},{\"lat\":\"0.252352\",\"lng\":\"-78.223541\"},{\"lat\":\"0.252362\",\"lng\":\"-78.223434\"},{\"lat\":\"0.252369\",\"lng\":\"-78.22332\"},{\"lat\":\"0.252374\",\"lng\":\"-78.223213\"},{\"lat\":\"0.25236\",\"lng\":\"-78.223099\"},{\"lat\":\"0.252342\",\"lng\":\"-78.223007\"},{\"lat\":\"0.252315\",\"lng\":\"-78.222893\"},{\"lat\":\"0.252275\",\"lng\":\"-78.222794\"},{\"lat\":\"0.252249\",\"lng\":\"-78.222694\"},{\"lat\":\"0.252237\",\"lng\":\"-78.222603\"},{\"lat\":\"0.252238\",\"lng\":\"-78.222511\"},{\"lat\":\"0.25223\",\"lng\":\"-78.22242\"},{\"lat\":\"0.252216\",\"lng\":\"-78.222321\"},{\"lat\":\"0.252217\",\"lng\":\"-78.222221\"},{\"lat\":\"0.252221\",\"lng\":\"-78.22213\"},{\"lat\":\"0.252237\",\"lng\":\"-78.222031\"},{\"lat\":\"0.252256\",\"lng\":\"-78.221939\"},{\"lat\":\"0.252217\",\"lng\":\"-78.22184\"},{\"lat\":\"0.252235\",\"lng\":\"-78.221748\"},{\"lat\":\"0.252254\",\"lng\":\"-78.221642\"},{\"lat\":\"0.252277\",\"lng\":\"-78.22155\"},{\"lat\":\"0.252295\",\"lng\":\"-78.221451\"},{\"lat\":\"0.252318\",\"lng\":\"-78.221344\"},{\"lat\":\"0.25232\",\"lng\":\"-78.221245\"},{\"lat\":\"0.252294\",\"lng\":\"-78.221115\"},{\"lat\":\"0.25228\",\"lng\":\"-78.221001\"},{\"lat\":\"0.252279\",\"lng\":\"-78.220894\"},{\"lat\":\"0.252275\",\"lng\":\"-78.220795\"},{\"lat\":\"0.252268\",\"lng\":\"-78.220703\"},{\"lat\":\"0.252249\",\"lng\":\"-78.220604\"},{\"lat\":\"0.252224\",\"lng\":\"-78.220497\"},{\"lat\":\"0.252184\",\"lng\":\"-78.220398\"},{\"lat\":\"0.252156\",\"lng\":\"-78.220314\"},{\"lat\":\"0.252156\",\"lng\":\"-78.220192\"},{\"lat\":\"0.252166\",\"lng\":\"-78.2201\"},{\"lat\":\"0.252181\",\"lng\":\"-78.219994\"},{\"lat\":\"0.252189\",\"lng\":\"-78.219887\"},{\"lat\":\"0.252201\",\"lng\":\"-78.219795\"},{\"lat\":\"0.252204\",\"lng\":\"-78.219681\"},{\"lat\":\"0.252211\",\"lng\":\"-78.219582\"},{\"lat\":\"0.252198\",\"lng\":\"-78.21949\"},{\"lat\":\"0.252191\",\"lng\":\"-78.219398\"},{\"lat\":\"0.252178\",\"lng\":\"-78.219276\"},{\"lat\":\"0.252169\",\"lng\":\"-78.219154\"},{\"lat\":\"0.252178\",\"lng\":\"-78.219048\"},{\"lat\":\"0.252185\",\"lng\":\"-78.218941\"},{\"lat\":\"0.252189\",\"lng\":\"-78.218834\"},{\"lat\":\"0.252204\",\"lng\":\"-78.218727\"},{\"lat\":\"0.252218\",\"lng\":\"-78.218613\"},{\"lat\":\"0.25223\",\"lng\":\"-78.218506\"},{\"lat\":\"0.252217\",\"lng\":\"-78.218407\"},{\"lat\":\"0.252216\",\"lng\":\"-78.2183\"},{\"lat\":\"0.252215\",\"lng\":\"-78.218185\"},{\"lat\":\"0.252225\",\"lng\":\"-78.218079\"},{\"lat\":\"0.252234\",\"lng\":\"-78.217964\"},{\"lat\":\"0.252245\",\"lng\":\"-78.217842\"},{\"lat\":\"0.252264\",\"lng\":\"-78.217728\"},{\"lat\":\"0.252277\",\"lng\":\"-78.217621\"},{\"lat\":\"0.252296\",\"lng\":\"-78.217529\"},{\"lat\":\"0.252289\",\"lng\":\"-78.217422\"},{\"lat\":\"0.25229\",\"lng\":\"-78.217323\"},{\"lat\":\"0.252298\",\"lng\":\"-78.217232\"},{\"lat\":\"0.252398\",\"lng\":\"-78.217209\"},{\"lat\":\"0.252503\",\"lng\":\"-78.217232\"},{\"lat\":\"0.252604\",\"lng\":\"-78.217224\"},{\"lat\":\"0.252697\",\"lng\":\"-78.217232\"},{\"lat\":\"0.252597\",\"lng\":\"-78.217247\"},{\"lat\":\"0.252687\",\"lng\":\"-78.217216\"},{\"lat\":\"0.25278\",\"lng\":\"-78.217209\"},{\"lat\":\"0.252859\",\"lng\":\"-78.217255\"},{\"lat\":\"0.252928\",\"lng\":\"-78.217194\"},{\"lat\":\"0.25302\",\"lng\":\"-78.217201\"},{\"lat\":\"0.253117\",\"lng\":\"-78.217209\"},{\"lat\":\"0.253216\",\"lng\":\"-78.217216\"},{\"lat\":\"0.253307\",\"lng\":\"-78.217209\"},{\"lat\":\"0.253406\",\"lng\":\"-78.217209\"},{\"lat\":\"0.253489\",\"lng\":\"-78.217247\"},{\"lat\":\"0.253521\",\"lng\":\"-78.217339\"}]}'),
(10, 0, 'Verificar Dato', 'verifca', '{\"position\":{\"lat\":0.22997403423843954,\"lng\":-78.25985173924583}}'),
(11, 1, '', '', '{\"fillColor\":\"#ED1F2D\",\"fillOpacity\":0.3,\"paths\":[[{\"lat\":\"0.22974336611943802\",\"lng\":\"-78.26658944829124\"},{\"lat\":\"0.22538749303729932\",\"lng\":\"-78.26583842976707\"},{\"lat\":\"0.22558061059090548\",\"lng\":\"-78.25731973393577\"},{\"lat\":\"0.22978628111859717\",\"lng\":\"-78.2529852841677\"},{\"lat\":\"0.23019397360428626\",\"lng\":\"-78.2550023053469\"},{\"lat\":\"0.2302583461009767\",\"lng\":\"-78.25727681859154\"},{\"lat\":\"0.23135267849991964\",\"lng\":\"-78.26047401173729\"},{\"lat\":\"0.23085915605592364\",\"lng\":\"-78.26392869694847\"},{\"lat\":\"0.23045146358924154\",\"lng\":\"-78.26566676839012\"}]],\"strokeColor\":\"#E01063\",\"strokeOpacity\":0.9,\"strokeWeight\":3}'),
(12, 4, 'linea verificar', '', '{\"strokeColor\":\"#000000\",\"strokeOpacity\":1,\"strokeWeight\":4,\"path\":[{\"lat\":\"0.2666293757191407\",\"lng\":\"-78.25913332818602\"},{\"lat\":\"0.2655994185666813\",\"lng\":\"-78.23132418511962\"},{\"lat\":\"0.26396865289990085\",\"lng\":\"-78.22377108453368\"}]}');

--
-- Dumping data for table `routes_map`
--

INSERT INTO `routes_map` (`id`, `type`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `options_map`, `src`) VALUES
(1, 1, 'Cómo llegar a Wuantun Rumi - Otavalo', 'Es una formación rocosa de origen volcánico de 15m de alto, a 7 km de la ciudad de Otavalo. Ideal para caminatas, senderismo, picnic, fotografía y camping.', 'ACTIVE', '2024-02-22 22:38:18', '2024-02-28 20:55:47', NULL, '{\"zoom\":14,\"tilt\":0,\"mapTypeId\":\"roadmap\",\"center\":{\"lat\":0.24545976590197432,\"lng\":-78.24587787227136}}', '/uploads/business/information/1708641498_Captura de pantalla 2024-01-16 114703.png'),
(2, 1, 'NUEVA REALZIADA', 'HOLA', 'ACTIVE', '2024-02-24 16:03:40', '2024-02-28 19:21:07', NULL, '{\"zoom\":16,\"tilt\":0,\"mapTypeId\":\"roadmap\",\"center\":{\"lat\":0.22800962246776993,\"lng\":-78.25950905973792}}', '/uploads/business/information/1708790620_punto-venta.png');

--
-- Dumping data for table `routes_map_by_routes_drawing`
--

INSERT INTO `routes_map_by_routes_drawing` (`id`, `routes_map_id`, `routes_drawing_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 2, 10),
(11, 2, 11),
(12, 1, 12);

--
-- Dumping data for table `route_map_by_adventure_types`
--

INSERT INTO `route_map_by_adventure_types` (`id`, `business_by_routes_map_id`, `adventure_type`) VALUES
(1, 2, 0),
(2, 2, 1),
(3, 2, 2),
(4, 2, 3),
(5, 1, 1),
(6, 1, 9),
(7, 1, 10),
(8, 1, 12),
(9, 1, 13),
(10, 1, 14),
(11, 1, 15),
(12, 1, 6),
(13, 1, 5),
(14, 1, 4),
(15, 1, 11),
(16, 1, 3),
(17, 1, 2),
(18, 1, 8),
(19, 1, 0),
(20, 1, 7);

--
-- Dumping data for table `ruc_type`
--

INSERT INTO `ruc_type` (`id`, `name`, `description`) VALUES
(1, 'Persona Natural', 'Persona Natural'),
(2, 'Sociedad Privada', 'Sociedad Privada'),
(3, 'Sociedad Publica', 'Sociedad Publica'),
(4, 'Ninguno', 'Ningunos');

--
-- Dumping data for table `schedule_days_category`
--

INSERT INTO `schedule_days_category` (`id`, `name`, `weight_day`, `description`) VALUES
(1, 'Lunes', 0, NULL),
(2, 'Martes', 1, NULL),
(3, 'Miercoles', 2, NULL),
(4, 'Jueves', 3, NULL),
(5, 'Viernes', 4, NULL),
(6, 'Sabado', 5, NULL),
(7, 'Domingo', 6, NULL);

--
-- Dumping data for table `shipping_rate_business`
--

INSERT INTO `shipping_rate_business` (`id`, `title`, `description`, `state`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Servientrega', NULL, 'ACTIVE', NULL, NULL, NULL),
(2, 'DHL', NULL, 'ACTIVE', NULL, NULL, NULL);

--
-- Dumping data for table `shipping_rate_kinds_of_way`
--

INSERT INTO `shipping_rate_kinds_of_way` (`id`, `value`, `description`, `state`) VALUES
(1, 'Aereo', 'hola', 'ACTIVE'),
(2, 'Terrestre', NULL, 'ACTIVE'),
(3, 'Maritimo', NULL, 'ACTIVE');

--
-- Dumping data for table `shipping_rate_services`
--

INSERT INTO `shipping_rate_services` (`id`, `value`, `description`, `state`, `shipping_rate_business_id`) VALUES
(3, 'Servicio Express', 'adad', 'ACTIVE', 1);

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `value`, `percentage`, `state`) VALUES
(1, '12', 12, 'ACTIVE'),
(2, '0', 0, 'ACTIVE');

--
-- Dumping data for table `tax_by_business`
--

INSERT INTO `tax_by_business` (`id`, `tax_id`, `state`, `business_id`) VALUES
(1, 1, 'ACTIVE', 1);

--
-- Dumping data for table `tax_support`
--

INSERT INTO `tax_support` (`id`, `value`, `description`, `status`, `code`) VALUES
(1, ' Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)', ' Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)', 'ACTIVE', '01'),
(2, ' Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)', ' Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)', 'ACTIVE', '02'),
(3, ' Activo Fijo - Crédito Tributario para declaración de IVA', ' Activo Fijo - Crédito Tributario para declaración de IVA', 'ACTIVE', '03'),
(4, ' Activo Fijo - Costo o Gasto para declaración de IR', ' Activo Fijo - Costo o Gasto para declaración de IR', 'ACTIVE', '04'),
(5, ' Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleados y no de la empresa)', ' Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleados y no de la empresa)', 'ACTIVE', '05'),
(6, ' Inventario - Crédito Tributario para declaración de IVA', ' Inventario - Crédito Tributario para declaración de IVA', 'ACTIVE', '06'),
(7, ' Inventario - Costo o Gasto para declaración de IR', ' Inventario - Costo o Gasto para declaración de IR', 'ACTIVE', '07'),
(8, ' Valor pagado para solicitar Reembolso de Gasto (intermediario)', ' Valor pagado para solicitar Reembolso de Gasto (intermediario)', 'ACTIVE', '08'),
(9, ' Reembolso por Siniestros', ' Reembolso por Siniestros', 'ACTIVE', '09'),
(10, 'Distribución de Dividendos, Beneficios o Utilidades', 'Distribución de Dividendos, Beneficios o Utilidades', 'ACTIVE', '10'),
(11, 'Convenios de débito o recaudación para IFI´s', 'Convenios de débito o recaudación para IFI´s', 'ACTIVE', '11'),
(12, ' Impuestos y retenciones presuntivos', ' Impuestos y retenciones presuntivos', 'ACTIVE', '12'),
(13, 'Valores reconocidos por entidades del sector público a favor de sujetos pasivos', 'Valores reconocidos por entidades del sector público a favor de sujetos pasivos', 'ACTIVE', '13'),
(14, 'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)', 'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)', 'ACTIVE', '14'),
(15, 'Casos especiales cuyo sustento no aplica en las opciones anteriores', 'Casos especiales cuyo sustento no aplica en las opciones anteriores', 'ACTIVE', '00');

--
-- Dumping data for table `template_about_us`
--

INSERT INTO `template_about_us` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`) VALUES
(1, 'Quienes Somos', '<p>Quienes Somos<br></p>', 'ACTIVE', 1, 'null', 0, 'Quienes Somos');

--
-- Dumping data for table `template_by_source`
--

INSERT INTO `template_by_source` (`id`, `template_information_id`, `source`, `source_type`, `value`) VALUES
(1, 1, '/uploads/frontend/templateBySource/1604937642_corpar.png', 0, 'Logo Principal');

--
-- Dumping data for table `template_information`
--

INSERT INTO `template_information` (`id`, `value`, `description`, `status`, `business_id`) VALUES
(1, 'Coorporacion Arrayanes', NULL, 'ACTIVE', 1);

--
-- Dumping data for table `template_news`
--

INSERT INTO `template_news` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'Liberal Arts College Rankings', '<p>Liberal Arts Colleges emphasize undergradutae education.</p><p>These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605188832_b2.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:47:12', '2020-11-12 08:48:17', NULL, 0),
(2, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605188887_b1.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:48:07', '2020-11-12 08:50:58', NULL, 0),
(3, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605189112_b3.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:51:52', '2020-11-12 08:51:52', NULL, 0),
(4, 'Liberal Arts College Rankings', '<p style=\"font-size: 14.4px;\">Liberal Arts Colleges emphasize undergradutae education.</p><p style=\"font-size: 14.4px;\">These institutions award at least half of their degrees inte he arts and sciences, wichs is.</p>', 'ACTIVE', 2, '/uploads/web/news/images/1605189154_b1.jpg', 1, 'Liberal Arts College Rankings', '2020-11-12 08:52:34', '2020-11-12 08:52:34', NULL, 0),
(5, 'ada', '<p>adad</p>', 'ACTIVE', 1, 'null', 0, 'ad', '2024-02-28 19:56:53', '2024-02-28 19:56:53', NULL, 1);

--
-- Dumping data for table `template_policies`
--

INSERT INTO `template_policies` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`, `type`) VALUES
(1, 'Politica 1', '<p>Politica 1<br></p>', 'ACTIVE', 1, 'null', 0, 'Politica 1', 0);

--
-- Dumping data for table `template_services`
--

INSERT INTO `template_services` (`id`, `value`, `description`, `status`, `template_information_id`, `source`, `allow_source`, `subtitle`) VALUES
(1, 'Servicio 1', '<p>Servicio 1<br></p>', 'ACTIVE', 1, 'null', 0, 'Servicio 1');

--
-- Dumping data for table `template_services_by_data`
--

INSERT INTO `template_services_by_data` (`id`, `title`, `description`, `status`, `source`, `allow_source`, `template_services_id`, `title_icon`) VALUES
(1, '<p>foto</p>', '<p>foto</p>', 'ACTIVE', 'null', 0, 1, 'none');

--
-- Dumping data for table `template_slider`
--

INSERT INTO `template_slider` (`id`, `value`, `description`, `status`, `template_information_id`, `position_section`) VALUES
(1, 'Slider Principal', NULL, 'ACTIVE', 1, 0);

--
-- Dumping data for table `template_slider_by_images`
--

INSERT INTO `template_slider_by_images` (`id`, `source`, `template_slider_id`, `title`, `subtitle`, `options_title`, `button_name`, `options_button`, `options_subtitle`, `options_all`, `options_source`, `position`, `status`, `type_button`, `type_multimedia`) VALUES
(1, '/uploads/web/slider/images/1708986661_main.jpg', 1, 'only-background', 'only-background', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'1\',\'1\',\'10\',\'-3\']\" data-y=\"[\'top\',\'middle\',\'middle\',\'middle\']\" data-voffset=\"[\'279\',\'0\',\'-22\',\'-25\']\"data-fontsize=\"[\'90\',\'90\',\'90\',\'60\']\" data-lineheight=\"[\'110\',\'100\',\'100\',\'70\']\" data-width=\"none\" data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\" data-frames=\'[{\"delay\":610,\"split\":\"chars\",\"splitdelay\":0.05,\"speed\":1850,\"split_direction\":\"forward\",\"frame\":\"0\",\"from\":\"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;\",\"mask\":\"x:0px;y:0px;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power4.easeInOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power2.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\" style=\"z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;\"', 'not-button', '{\"data\":[{\"name\":\"not-button\",\"link\":null}]}', 'class=\"tp-caption   tp-resizeme\"data-x=\"[\'center\',\'center\',\'center\',\'center\']\" data-hoffset=\"[\'0\',\'3\',\'5\',\'0\']\" data-y=\"[\'top\',\'top\',\'top\',\'top\']\" data-voffset=\"[\'230\',\'260\',\'339\',\'228\']\" data-width=\"none\"data-height=\"none\" data-whitespace=\"nowrap\" data-type=\"text\" data-responsive_offset=\"on\"data-frames=\'[{\"delay\":610,\"speed\":1500,\"frame\":\"0\",\"from\":\"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;\",\"mask\":\"x:[100%];y:0;s:inherit;e:inherit;\",\"to\":\"o:1;\",\"ease\":\"Power3.easeOut\"},{\"delay\":\"wait\",\"speed\":300,\"frame\":\"999\",\"to\":\"opacity:0;\",\"ease\":\"Power3.easeInOut\"}]\'data-textAlign=\"[\'inherit\',\'inherit\',\'inherit\',\'inherit\']\" data-paddingtop=\"[0,0,0,0]\"data-paddingright=\"[0,0,0,0]\" data-paddingbottom=\"[0,0,0,0]\" data-paddingleft=\"[0,0,0,0]\"style=\"z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;\"', 'data-transition=\"slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical\"data-slotamount=\"default,default,default,default\" data-hideafterloop=\"0\" data-hideslideonmobile=\"off\"data-easein=\"default,default,default,default\" data-easeout=\"default,default,default,default\"data-masterspeed=\"1010,default,default,default\" data-thumb=\"\" data-delay=\"7010\" data-rotate=\"0,0,0,0\"data-saveperformance=\"off\" data-title=\"Slide\" data-param1=\"\" data-param2=\"\" data-param3=\"\"data-param4=\"\" data-param5=\"\" data-param6=\"\" data-param7=\"\" data-param8=\"\" data-param9=\"\"data-param10=\"\" data-description=\"\"', 'data-bgposition=\"center center\" data-bgfit=\"cover\" data-bgrepeat=\"no-repeat\" class=\"rev-slidebg\"data-no-retina', 1, 'ACTIVE', 0, 0);

--
-- Dumping data for table `types_payments`
--

INSERT INTO `types_payments` (`id`, `value`, `description`, `status`, `code`, `type_payment`) VALUES
(1, 'SIN UTILIZACION DEL SISTEMA FINANCIERO', NULL, 'ACTIVE', '01', 0),
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

--
-- Dumping data for table `type_ruc`
--

INSERT INTO `type_ruc` (`id`, `value`, `descripcion`) VALUES
(1, 'Persona Natural', NULL),
(2, 'Sociedad Privada', NULL),
(3, 'Sociedad Pública', NULL),
(4, 'Sin Ruc', NULL);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `provider_id`, `provider`, `api_token`, `user_id`, `avatar`) VALUES
(1, 'Admin', 'admin@system.dev', NULL, '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', 'YD8q4rYh5b1qMa2gjtlJrZMI3IvT0kllGUOFEkJalFBub0W1Dw0rtiuYVMZ3', 'ACTIVE', '2017-11-25 15:41:16', '2017-11-25 15:41:16', 'server', 'server', NULL, NULL, NULL),
(2, 'Enrique Burga', 'eburga@system.dev', 'eburga@system.dev', '$2y$10$f./uEz6L/0aWd.tTSU3NSuRyNHn9tA4av/yoD1wyAu556y4qQIG/e', NULL, 'ACTIVE', '2021-05-09 02:23:48', '2021-05-09 02:23:48', NULL, NULL, NULL, NULL, NULL),
(3, 'Alex', 'kalexmiguelalba@gmail.com', NULL, '$2y$10$Wr.ASVnNaR7hZLXBl2iIzetcQ7MVyUM7tmeP9qKip1sXH4.eOIQfq', NULL, 'ACTIVE', '2024-02-26 23:30:23', '2024-02-26 23:30:23', NULL, 'server', NULL, NULL, NULL);

--
-- Dumping data for table `users_has_roles`
--

INSERT INTO `users_has_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 4);

--
-- Dumping data for table `voucher_type`
--

INSERT INTO `voucher_type` (`id`, `value`, `description`, `status`, `code`) VALUES
(1, 'Factura', 'Factura', 'ACTIVE', '1'),
(2, 'Nota o boleta de venta', 'Nota o boleta de venta', 'ACTIVE', '2'),
(3, 'Liquidación de compra de Bienes o Prestación de servicios', 'Liquidación de compra de Bienes o Prestación de servicios', 'ACTIVE', '3'),
(4, 'Nota de crédito', 'Nota de crédito', 'ACTIVE', '4'),
(5, 'Nota de débito', 'Nota de débito', 'ACTIVE', '5'),
(6, 'Guías de Remisión', 'Guías de Remisión', 'ACTIVE', '6'),
(7, 'Comprobante de Retención', 'Comprobante de Retención', 'ACTIVE', '7'),
(8, 'Boletos o entradas a espectáculos públicos', 'Boletos o entradas a espectáculos públicos', 'ACTIVE', '8'),
(9, 'Tiquetes o vales emitidos por máquinas registradoras', 'Tiquetes o vales emitidos por máquinas registradoras', 'ACTIVE', '9'),
(10, 'Pasajes expedidos por empresas de aviación', 'Pasajes expedidos por empresas de aviación', 'ACTIVE', '11'),
(11, 'Documentos emitidos por instituciones financieras', 'Documentos emitidos por instituciones financieras', 'ACTIVE', '12'),
(12, 'Comprobante de venta emitido en el Exterior', 'Comprobante de venta emitido en el Exterior', 'ACTIVE', '15'),
(13, 'Formulario Único de Exportación (FUE) o Declaración Aduanera Única (DAU) o Declaración Andina de Valor (DAV)', 'Formulario Único de Exportación (FUE) o Declaración Aduanera Única (DAU) o Declaración Andina de Valor (DAV)', 'ACTIVE', '16'),
(14, 'Documentos autorizados utilizados en ventas excepto N/C N/D', 'Documentos autorizados utilizados en ventas excepto N/C N/D', 'ACTIVE', '18'),
(15, 'Comprobantes de Pago de Cuotas o Aportes', 'Comprobantes de Pago de Cuotas o Aportes', 'ACTIVE', '19'),
(16, 'Documentos por Servicios Administrativos emitidos por Inst. del Estado', 'Documentos por Servicios Administrativos emitidos por Inst. del Estado', 'ACTIVE', '20'),
(17, 'Carta de Porte Aéreo', 'Carta de Porte Aéreo', 'ACTIVE', '21'),
(18, 'RECAP', 'RECAP', 'ACTIVE', '22'),
(19, 'Nota de Crédito TC', 'Nota de Crédito TC', 'ACTIVE', '23'),
(20, 'Nota de Débito TC', 'Nota de Débito TC', 'ACTIVE', '24'),
(21, 'Comprobante de venta emitido por reembolso', 'Comprobante de venta emitido por reembolso', 'ACTIVE', '41'),
(22, 'Documento agente de retención Presuntiva', 'Documento agente de retención Presuntiva', 'ACTIVE', '42'),
(23, 'Liquidación para Explotación y Exploracion de Hidrocarburos', 'Liquidación para Explotación y Exploracion de Hidrocarburos', 'ACTIVE', '43'),
(24, 'Comprobante de Contribuciones y Aportes', 'Comprobante de Contribuciones y Aportes', 'ACTIVE', '44'),
(25, 'Liquidación por reclamos de aseguradoras', 'Liquidación por reclamos de aseguradoras', 'ACTIVE', '45'),
(26, 'Nota de Crédito por Reembolso Emitida por Intermediario', 'Nota de Crédito por Reembolso Emitida por Intermediario', 'ACTIVE', '47'),
(27, 'Nota de Débito por Reembolso Emitida por Intermediario', 'Nota de Débito por Reembolso Emitida por Intermediario', 'ACTIVE', '48'),
(28, 'Proveedor Directo de Exportador Bajo Régimen Especial', 'Proveedor Directo de Exportador Bajo Régimen Especial', 'ACTIVE', '49'),
(29, 'A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '50'),
(30, 'N/C A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'N/C A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '51'),
(31, 'N/D A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'N/D A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta', 'ACTIVE', '52'),
(32, 'Liquidación de compra de Bienes Muebles Usados', 'Liquidación de compra de Bienes Muebles Usados', 'ACTIVE', '294'),
(33, 'Liquidación de compra de vehículos usados', 'Liquidación de compra de vehículos usados', 'ACTIVE', '344'),
(34, 'Acta Entrega-Recepción PET', 'Acta Entrega-Recepción PET', 'ACTIVE', '364'),
(35, 'Factura operadora transporte / socio', 'Factura operadora transporte / socio', 'ACTIVE', '370'),
(36, 'Comprobante socio a operadora de transporte', 'Comprobante socio a operadora de transporte', 'ACTIVE', '371'),
(37, 'Nota de crédito operadora transporte / socio', 'Nota de crédito operadora transporte / socio', 'ACTIVE', '372'),
(38, 'Nota de débito operadora transporte / socio', 'Nota de débito operadora transporte / socio', 'ACTIVE', '373');

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `city_id`, `color`, `zip_code`, `polygon_coordinates`, `polygon_spatial`, `status`, `created_at`, `updated_at`, `deleted_at`, `place_id`) VALUES
(1, 'Gonzales Suares', 1, '#ffa8b8', '100450', '[[0.19898877729791498,-78.25823140153514],[0.2015636822213178,-78.25724434861766],[0.2033232003518515,-78.25707268724071],[0.20400984152158985,-78.25625729570018],[0.20319445512926707,-78.25475525865184],[0.20336611542581728,-78.25376820573436],[0.20495397308212226,-78.25260949143993],[0.20611267992122725,-78.25153660783397],[0.2074001318658086,-78.25084996232616],[0.20873049876517405,-78.24801754960643],[0.2101466956634176,-78.24660134324657],[0.21083333653760608,-78.2446272374116],[0.21164872253637973,-78.24303936967479],[0.21023252577434026,-78.24007821092235],[0.21083333653760608,-78.23801827439891],[0.21860095929455028,-78.23741745957958],[0.2194163448782743,-78.23964905747997],[0.21993132522405012,-78.24200940141307],[0.21598314212208675,-78.25007748612987],[0.21302200412154337,-78.25557065019237],[0.21109082685763916,-78.25921845445262],[0.20662766071159372,-78.25994801530467]]', 0x0000000001030000000100000017000000281900dd869053c091fd61d97678c93f4a1900b1769053c00fd899b7d6ccc93f471900e1739053c083be03a07e06ca3f25190085669053c015ddb296fe1cca3f3d1900e94d9053c0db1ec1a14602ca3f191900bd3d9053c0a2296f9fe607ca3f371900c12a9053c01257c989ee3bca3f3419002d199053c08ebbc679e661ca3f271900ed0d9053c0ed5dc667168cca3f14190085df8f53c0ebe4ef54aeb7ca3f50190051c88f53c03b519e4016e6ca3f4e1900f9a78f53c0d6f4aa3696fcca3f411900f58d8f53c0d457c42a4e17cb3f191900715d8f53c05fcd603fe6e8ca3f381900b13b8f53c0d6f4aa3696fcca3f501900d9318f53c043ac85c11dfbcb3f34190069568f53c028e2bab4d515cc3f2d1900157d8f53c098039aacb526cc3f3b190045019053c0cb6af3e955a5cb3f181900455b9053c0dee383164e44cb3f4d190009979053c0ab69eb320605cb3f491900fda29053c010469a72c672ca3f281900dd869053c091fd61d97678c93f, 'ACTIVE', '2020-05-20 21:54:53', '2020-05-20 22:02:44', NULL, 'none-id'),
(2, 'El Jordan', 1, '#e5bedd', NULL, '[[0.2170141185930993,-78.2193915055365],[0.2086027691489902,-78.20892016154237],[0.20877442938728538,-78.19621721964783],[0.2175290990212006,-78.19175402384705],[0.2231938825614229,-78.20874850016541],[0.22370886277591814,-78.21424166422791],[0.22096230142418116,-78.22024981242127]]', 0x00000000010300000001000000080000004e53ab820a8e53c02e56105f1ec7cb3f1153abf25e8d53c028cbacdb7eb3ca3f3753abd28e8c53c0f9cf3ad91eb9ca3f2753abb2458c53c020b91c57fed7cb3f0e53ab225c8d53c04b6022fd9d91cc3f3153ab22b68d53c0b655b9f47da2cc3f1853ab92188e53c0020422217e48cc3f4e53ab820a8e53c02e56105f1ec7cb3f, 'ACTIVE', '2020-05-20 21:58:17', '2020-05-20 22:02:44', NULL, 'none-id'),
(3, 'San Rafael de la laguna', 1, '#e5bedd', NULL, '[[0.2048400917519579,-78.24626876404871],[0.19351050934756264,-78.2485003619491],[0.19351050934756264,-78.22481109192957],[0.20724333548969276,-78.23974563172449]]', 0x00000000010300000001000000050000007ae70fdec28f53c0cafd7d3b3338ca3f5ee70f6ee78f53c0d13f8acef3c4c83f83e70f4e638e53c0d13f8acef3c4c83f43e70ffe578f53c095ff1e1af386ca3f7ae70fdec28f53c0cafd7d3b3338ca3f, 'ACTIVE', '2020-05-20 21:58:17', '2020-05-20 22:02:44', NULL, 'none-id'),
(4, 'San Juan de Iluman', 1, '#e5bedd', NULL, '[[0.23111585890298292,-78.28933583598388],[0.22673852873244676,-78.28933583598388],[0.22862678896981717,-78.28555928569091],[0.23051504895887534,-78.28444348674071]]', 0x00000000010300000001000000050000002d47747a849253c0c7a1c9573495cd3f2d47747a849253c06313d3a2c405cd3f2a47749a469253c013b4ce82a443cd3f38477452349253c03dd241628481cd3f2d47747a849253c0c7a1c9573495cd3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(5, 'San Luis', 1, '#e5bedd', NULL, '[[0.2251935883549699,-78.2782636771704],[0.2168680735304996,-78.27208386760009],[0.21901382521895926,-78.26659070353759],[0.22261868736255455,-78.2683931479956]]', 0x000000000103000000010000000500000008477412cf9153c01e72a0bc24d3cc3f1e4774d2699153c02915ae4155c2cb3f414774d20f9153c03af95720a508cc3f4047745a2d9153c049add9e6c47ecc3f08477412cf9153c01e72a0bc24d3cc3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(6, 'San Pedro de Pataqui', 1, '#e5bedd', NULL, '[[0.22819763893760353,-78.2441888938452],[0.2242494580436194,-78.25002538066161],[0.22510775832918428,-78.25174199443114],[0.2297425789935009,-78.250454534104],[0.22957091899551568,-78.24796544413817]]', 0x0000000001030000000100000006000000164774caa08f53c0d375218a9435cd3f3f47746a009053c096b638cc34b4cc3f1a47748a1c9053c0f6c20cbe54d0cc3f24477472079053c0bb4ca36f3468cd3f184774aade8f53c0f26599729462cd3f164774caa08f53c0d375218a9435cd3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(7, 'San Jose de Quichinche', 1, '#e5bedd', NULL, '[[0.23403407826881503,-78.23337422709716],[0.23060087895244827,-78.23637830119384],[0.23635148733308337,-78.23663579325927],[0.2379822564430687,-78.23165761332763]]', 0x00000000010300000001000000050000001947749aef8e53c0fa332824d4f4cd3f2f4774d2208f53c0d5cac3605484cd3f1147740a258f53c0cd6f3afac340ce3f3e47747ad38e53c03fc339dc3376ce3f1947749aef8e53c0fa332824d4f4cd3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(8, 'Dr Miguel Egas', 1, '#e5bedd', NULL, '[[0.2289701089863594,-78.23886739115966],[0.2289701089863594,-78.23054181437743],[0.22570856849904763,-78.23792325358642]]', 0x00000000010300000001000000040000003c47749a498f53c006d2ed7ce44ecd3f06477432c18e53c006d2ed7ce44ecd3f074774223a8f53c0cdb010b404e4cc3f3c47749a498f53c006d2ed7ce44ecd3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(9, 'Selva Alegra', 1, '#e5bedd', NULL, '[[0.22845512895847364,-78.22702275614989],[0.23214581874799814,-78.22230206828368],[0.23300411856156872,-78.22693692546142]]', 0x00000000010300000001000000040000002c47748a878e53c0a173bd85043ecd3f3a4774323a8e53c0bc80b645f4b6cd3f07477422868e53c06c12873614d3cd3f2c47748a878e53c0a173bd85043ecd3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(10, 'Eugenio Espejo', 1, '#e5bedd', NULL, '[[0.22570856849904763,-78.22775231700194],[0.22648103868095426,-78.22234498362792],[0.22304783755930466,-78.22414742808593]]', 0x00000000010300000001000000040000002847747e938e53c0cdb010b404e4cc3f2a4774e63a8e53c0ca3e26a754fdcc3f2947746e588e53c0135fe1dfd48ccc3f2847747e938e53c0cdb010b404e4cc3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(11, 'San Pablo del Lago', 1, '#e5bedd', NULL, '[[0.24286668310337173,-78.20816716087256],[0.2347128385193923,-78.20773800743018],[0.23454117858174858,-78.21649273765479],[0.2382318667746855,-78.21563443077002]]', 0x00000000010300000001000000050000003f035b9c528d53c0acc59b664116cf3f13035b944b8d53c0a230b2fe110bce3f2f035b04db8d53c0f275c9017205ce3f1e035bf4cc8d53c0fcc654be617ece3f3f035b9c528d53c0acc59b664116cf3f, 'ACTIVE', '2020-05-20 22:02:44', '2020-05-20 22:02:44', NULL, 'none-id'),
(12, 'Cristoba Colon', 5, '#e5bedd', NULL, '[[0.6402458478000177,-77.74711566851752],[0.6382718648346677,-77.72600131915229],[0.6232524045846296,-77.73612934039252]]', 0x00000000010300000001000000040000004ca73cbed06f53c09b6d36dce47ce43f16a73cce766e53c0b77f2d1eb96ce43f4ca73cbe1c6f53c0e304db06aff1e33f4ca73cbed06f53c09b6d36dce47ce43f, 'ACTIVE', '2020-07-14 05:36:18', '2020-07-27 06:47:56', NULL, 'none-id'),
(13, 'Por definir', 215, '#e5bedd', NULL, '[[-0.16509509768396524,-78.48976135350341],[-0.15556792857568008,-78.47680091954345],[-0.16226269652208958,-78.46504211522216]]', 0x0000000001030000000100000004000000f7080140589f53c0772ba40ed621c5bff40801e8839e53c043fec45ea6e9c3bf09090140c39d53c0c329762706c5c4bff7080140589f53c0772ba40ed621c5bf, 'ACTIVE', '2020-07-27 06:35:16', '2020-07-27 06:35:16', NULL, 'none-id'),
(14, 'Chical', 6, '#e5bedd', NULL, '[[0.8239941784795906,-77.73905868270874],[0.8251956836756045,-77.72554034927369],[0.814167568858249,-77.73279304244996]]', 0x0000000001030000000100000004000000d703cabc4c6f53c05741150a295eea3fdb03ca406f6e53c06cfc45c70068ea3fc803ca14e66e53c06bb83625a90dea3fd703cabc4c6f53c05741150a295eea3f, 'ACTIVE', '2020-07-27 06:43:50', '2020-07-31 19:46:56', NULL, 'none-id'),
(15, 'Tulcan', 6, '#e5bedd', NULL, '[[0.7997494433501385,-77.76096696594239],[0.8400857356430022,-77.71582002380372],[0.8189735992815355,-77.67067308166504],[0.7769206414113045,-77.75976533630372]]', 0x0000000001030000000100000005000000aa03caaeb37053c098db05258c97e93fd903cafecf6d53c078870d7bfbe1ea3fc203ca4eec6a53c0b373261f0835ea3fd903cafe9f7053c0335d4ead88dce83faa03caaeb37053c098db05258c97e93f, 'ACTIVE', '2020-07-27 06:45:25', '2020-07-31 19:46:57', NULL, 'none-id'),
(16, 'Sin registro', 8, '#e5bedd', NULL, '[[0.5087050120222935,-77.94235172641358],[0.5141121299966296,-77.89222660434326],[0.5026112704647144,-77.93488445651612]]', 0x0000000001030000000100000004000000bf919d7d4f7c53c0024ebebb4f47e03f8e919d3d1a7953c066ff19489b73e03f99919d25d57b53c0efe6273b6415e03fbf919d7d4f7c53c0024ebebb4f47e03f, 'ACTIVE', '2020-07-27 06:46:34', '2020-07-31 20:02:25', NULL, 'none-id'),
(17, 'Sin registro', 7, '#e5bedd', NULL, '[[0.5048868951487201,-77.91947606202393],[0.5078050246003604,-77.87690404053956],[0.4932143643209043,-77.89492848511964]]', 0x000000000103000000010000000400000045f61fb2d87a53c0acf7da8f0828e03f5ff61f321f7853c08ee5ac52f03fe03f5af61f82467953c0953e2bfbd290df3f45f61fb2d87a53c0acf7da8f0828e03f, 'ACTIVE', '2020-07-27 06:46:58', '2020-07-31 19:57:51', NULL, 'none-id'),
(18, 'Sin registro', 9, '#e5bedd', NULL, '[[0.5557989348868654,-78.0542882720581],[0.5591461732930796,-78.01446283260498],[0.5430107502734334,-78.02175844112548]]', 0x0000000001030000000100000004000000e9428475798353c025b40fd91ac9e13ff24284f5ec8053c04446ff8386e4e13fce42847d648153c032a0b9145860e13fe9428475798353c025b40fd91ac9e13f, 'ACTIVE', '2020-07-27 06:48:18', '2020-07-27 06:48:18', NULL, 'none-id'),
(19, 'Sin registro', 10, '#e5bedd', NULL, '[[0.5724422490199026,-77.79592586260988],[0.5746737351073109,-77.75747371417238],[0.5551052893286973,-77.7585036824341]]', 0x0000000001030000000100000004000000d67c0773f07253c0fd734c687251e23fb27c07737a7053c079fe442cba63e23fc67c07538b7053c0b91bf02a6cc3e13fd67c0773f07253c0fd734c687251e23f, 'ACTIVE', '2020-07-27 06:48:40', '2020-07-27 06:48:40', NULL, 'none-id'),
(20, 'Zona Dos', 3, '#e5bedd', 'ZP01', '[[0.33538922308889224,-78.2347798133667],[0.34534540726068297,-78.20413825758057],[0.32242900270425207,-78.1959843421753],[0.32066950129918675,-78.22242019422607]]', 0x0000000001030000000100000005000000060be9a1068f53c0953f265c0477d53f0f0be999108d53c0fb89809f231ad63fdc0ae9018b8c53c0b4627941ada2d43fec0ae9213c8e53c0cbe5395fd985d43f060be9a1068f53c0953f265c0477d53f, 'ACTIVE', '2020-07-27 06:49:26', '2024-02-22 22:31:08', NULL, 'none-id'),
(21, 'Sin registro', 4, '#e5bedd', NULL, '[[0.3016286134508392,-78.2825102678589],[0.3193953049827574,-78.27504299796144],[0.3081516534151998,-78.23573254263917]]', 0x0000000001030000000100000004000000454ff2a5149253c0aac99319e24dd33f1f4ff24d9a9153c0cf665901f970d43f324ff23d168f53c0641a68b6c1b8d33f454ff2a5149253c0aac99319e24dd33f, 'ACTIVE', '2020-07-27 06:49:58', '2020-07-27 06:49:58', NULL, 'none-id'),
(22, 'Sin registro', 2, '#e5bedd', NULL, '[[0.3499792603059938,-78.15326457264403],[0.35040840573245896,-78.09592967274169],[0.33049603763935254,-78.13043360950927]]', 0x00000000010300000001000000040000000dc93516cf8953c04ab852690f66d63f25c935b6238653c09252b760176dd63ffcc83506598853c0089747dad826d53f0dc93516cf8953c04ab852690f66d63f, 'ACTIVE', '2020-07-27 06:50:21', '2020-07-27 06:50:21', NULL, 'none-id'),
(23, 'Sin registro', 106, '#e5bedd', NULL, '[[0.3970092922055667,-77.96046575093995],[0.3981250642942425,-77.90991147542725],[0.37426467510040734,-77.93557485128174]]', 0x0000000001030000000100000004000000c94d5745787d53c036c98ea99968d93fb34d57fd3b7a53c06825b78ce17ad93fd74d5775e07b53c049ade6d2f3f3d73fc94d5745787d53c036c98ea99968d93f, 'ACTIVE', '2020-07-27 06:50:55', '2020-07-27 06:50:55', NULL, 'none-id'),
(24, 'Sin registro', 107, '#e5bedd', NULL, '[[0.42724758074649016,-78.21046294615479],[0.42922163144264264,-78.18402709410401],[0.41917971613256977,-78.18497123167725]]', 0x00000000010300000001000000040000005bb09339788d53c0997ba63c0658db3f4bb09319c78b53c0b70a72015e78db3f3ab09391d68b53c0a2e6fb28d7d3da3f5bb09339788d53c0997ba63c0658db3f, 'ACTIVE', '2020-07-27 06:51:21', '2020-07-27 06:51:21', NULL, 'none-id'),
(25, 'Sin registro', 178, '#e5bedd', NULL, '[[-0.1773058194818411,-78.49062624779052],[-0.17043939602472563,-78.44487849083251],[-0.19155363991854032,-78.4537190517456]]', 0x00000000010300000001000000040000009434a26b669f53c058510804f5b1c6bf9534a2e3789c53c09327f047f5d0c5bf8f34a2bb099d53c037a07065d484c8bf9434a26b669f53c058510804f5b1c6bf, 'ACTIVE', '2020-07-27 06:52:12', '2020-07-27 06:52:12', NULL, 'none-id'),
(26, 'Sin registro', 179, '#e5bedd', NULL, '[[0.04184845467835922,-78.17012756949462],[0.05111816597312691,-78.12575310355224],[0.030347144724432343,-78.12970131522216]]', 0x000000000103000000010000000400000041c8be5ee38a53c016a07620296da53f16c8be560c8853c0be122c06292caa3f1bc8be064d8853c09e41796852139f3f41c8be5ee38a53c016a07620296da53f, 'ACTIVE', '2020-07-27 06:52:34', '2020-07-27 06:52:34', NULL, 'none-id'),
(27, 'Sin registro', 181, '#e5bedd', NULL, '[[0.08220280601059479,-79.073644822937],[0.09378993526952253,-79.02557963739012],[0.0690707221450119,-79.03244609246825]]', 0x00000000010300000001000000040000002f82c698b6c453c0cd76743b3e0bb53f2682c618a3c153c0ec32ad009e02b83f1e82c69813c253c07253b96c9eaeb13f2f82c698b6c453c0cd76743b3e0bb53f, 'ACTIVE', '2020-07-27 06:53:03', '2020-07-27 06:53:03', NULL, 'none-id'),
(28, 'Sin registro', 182, '#e5bedd', NULL, '[[0.11580869488155088,-79.28464852923585],[0.13160150470171353,-79.24645387286378],[0.10619567582393855,-79.24430810565187]]', 0x000000000103000000010000000400000014fb76ae37d253c0c1d31b7da3a5bd3f19fb76e6c5cf53c08e2c666f51d8c03f13fb76bea2cf53c0e3f3a3caa32fbb3f14fb76ae37d253c0c1d31b7da3a5bd3f, 'ACTIVE', '2020-07-27 06:53:23', '2020-07-27 06:53:23', NULL, 'none-id'),
(29, 'Sin registro', 183, '#e5bedd', NULL, '[[0.027748020379505172,-78.914918278479],[0.035129458472160056,-78.86676726224366],[0.015045079396745178,-78.8743203628296]]', 0x00000000010300000001000000040000001e2565058eba53c0e91f3c20fa699c3f3625651d79b753c0633a87067dfca13f3b2565ddf4b753c02846cc5ff4cf8e3f1e2565058eba53c0e91f3c20fa699c3f, 'ACTIVE', '2020-07-27 06:53:57', '2020-07-27 06:53:57', NULL, 'none-id'),
(30, 'Julio Andrade', 6, '#e5bedd', NULL, '[[0.7685111958183863,-77.81431054565819],[0.795116231990742,-77.75937890503319],[0.7546078525605212,-77.77036523315819]]', 0x0000000001030000000100000004000000e698faa91d7453c077cb94caa497e83fe698faa9997053c043689d989771e93fe698faa94d7153c0d0ab015ebf25e83fe698faa91d7453c077cb94caa497e83f, 'ACTIVE', '2020-07-31 19:41:33', '2020-07-31 19:46:57', NULL, 'none-id'),
(31, 'El Carmelo', 6, '#e5bedd', NULL, '[[0.7825907871309515,-77.81736632249496],[0.7743518015755979,-77.6930834855809],[0.6995136371567818,-77.74938841722152],[0.7839639498214088,-77.82354613206527],[0.8141734136839461,-77.78990050218246]]', 0x0000000001030000000100000006000000f1fdd5ba4f7453c0431b9cd5fb0ae93ff5fdd57a5b6c53c051b5eb6d7dc7e83f0ffed5faf56f53c05e38566c6a62e63fdbfdd5fab47453c0e93ab7903b16e93fcdfdd5ba8d7253c0a4722167b50dea3ff1fdd5ba4f7453c0431b9cd5fb0ae93f, 'ACTIVE', '2020-07-31 19:42:52', '2020-07-31 19:46:57', NULL, 'none-id'),
(32, 'Maldonado', 6, '#e5bedd', NULL, '[[0.8264210430190453,-77.75603649999455],[0.8339733507241377,-77.71415112401799],[0.8017042999160229,-77.7368104257758],[0.830540485373964,-77.74985669042424]]', 0x0000000001030000000100000005000000e583eae6627053c0e4c60f8b0a72ea3fc683eaa6b46d53c0221063e1e8afea3fd383eae6276f53c0d075a6c68fa7e93fb483eaa6fd6f53c08aecd5a3c993ea3fe583eae6627053c0e4c60f8b0a72ea3f, 'ACTIVE', '2020-07-31 19:43:32', '2020-07-31 19:46:57', NULL, 'none-id'),
(33, 'Pioter', 6, '#e5bedd', NULL, '[[0.8304957739278666,-77.6912247669671],[0.8170217485745882,-77.6816975605462],[0.8179657900482247,-77.69543047070245],[0.8310965255865157,-77.691568089721]]', 0x0000000001030000000100000005000000be13ce063d6c53c0ae908fdf6b93ea3fb713ceeea06b53c085f447cb0a25ea3fa513ceee816c53c00220b097c62cea3fc513cea6426c53c09bd3a6bd5798ea3fbe13ce063d6c53c0ae908fdf6b93ea3f, 'ACTIVE', '2020-07-31 19:44:11', '2020-07-31 19:46:57', NULL, 'none-id'),
(34, 'Tobar Donoso', 6, '#e5bedd', NULL, '[[0.821017235860916,-77.7534520161126],[0.8318307776351835,-77.74186487316827],[0.8028229569129044,-77.75061960339288]]', 0x0000000001030000000100000004000000e113ce8e387053c0f4322ff0c545ea3fb213ceb67a6f53c0a5fa37945b9eea3fce13ce260a7053c0d0670dc5b9b0e93fe113ce8e387053c0f4322ff0c545ea3f, 'ACTIVE', '2020-07-31 19:44:48', '2020-07-31 19:46:57', NULL, 'none-id'),
(35, 'Tufiño', 6, '#e5bedd', NULL, '[[0.8296375571142417,-77.76160593151788],[0.8238874996707007,-77.73199434399346],[0.8054357670465262,-77.75448198437432]]', 0x0000000001030000000100000004000000ce13ce26be7053c008d9ea0f648cea3fa413cefed86e53c05c675551495dea3fae13ce6e497053c0eccacf3a21c6e93fce13ce26be7053c008d9ea0f648cea3f, 'ACTIVE', '2020-07-31 19:45:23', '2020-07-31 19:46:57', NULL, 'none-id'),
(36, 'Urbina', 6, '#e5bedd', NULL, '[[0.8315716915271679,-77.7913321258852],[0.8336314105574412,-77.7441252472231],[0.7963846609581579,-77.7609480621645]]', 0x0000000001030000000100000004000000d13c802fa57253c0606f6c3c3c9cea3fd83c80bf9f6f53c0d766a8c71badea3f023d805fb37053c0383e3baffb7be93fd13c802fa57253c0606f6c3c3c9cea3f, 'ACTIVE', '2020-07-31 19:46:18', '2020-07-31 19:46:57', NULL, 'none-id'),
(37, 'Santa Marta de Cuba', 6, '#e5bedd', NULL, '[[0.81738828727564,-77.8087556010715],[0.802283595069792,-77.6769196635715],[0.7658947914361117,-77.69786235155978],[0.7923281991995731,-77.86609050097384]]', 0x0000000001030000000100000005000000a243daa6c27353c0386f3f7b0b28ea3fa243daa6526b53c050255ea54eace93fd543dac6a96c53c079a22ccb3582e83fd043da066e7753c0df57e8aac05ae93fa243daa6c27353c0386f3f7b0b28ea3f, 'ACTIVE', '2020-07-31 19:46:57', '2020-07-31 19:46:57', NULL, 'none-id'),
(38, 'Los Andes', 7, '#e5bedd', NULL, '[[0.505419146267689,-77.94539216535577],[0.5132294303139098,-77.92436364667901],[0.48524968833363424,-77.91629556196222],[0.49305999633706504,-77.95191529767999]]', 0x00000000010300000001000000050000005006244e817c53c036beffc5642ce03f3f0624c6287b53c0e25f5120606ce03f31062496a47a53c0666072b5540edf3f4106242eec7c53c03af3ce834b8edf3f5006244e817c53c036beffc5642ce03f, 'ACTIVE', '2020-07-31 19:53:10', '2020-07-31 19:57:51', NULL, 'none-id'),
(39, 'Garcia Moreno', 7, '#e5bedd', NULL, '[[0.511018515557544,-77.92083376257777],[0.4972003096062016,-77.87954920142055],[0.4824379706957606,-77.92203539221644]]', 0x0000000001030000000100000004000000cfd4bbf0ee7a53c0120b7f80435ae03fdfd4bb884a7853c00676543f21d2df3fa0d4bba0027b53c04c299f8243e0de3fcfd4bbf0ee7a53c0120b7f80435ae03f, 'ACTIVE', '2020-07-31 19:56:34', '2020-07-31 19:57:51', NULL, 'none-id'),
(40, 'Monte Olivo', 7, '#e5bedd', NULL, '[[0.4878721982842548,-77.90359262006768],[0.5041794179193684,-77.87561181562432],[0.4902753700083286,-77.86943200605401]]', 0x000000000103000000010000000400000056062476d47953c0f48a10504c39df3f290624060a7853c0d9f5e8df3c22e03f3f0624c6a47753c0bc150ef2ab60df3f56062476d47953c0f48a10504c39df3f, 'ACTIVE', '2020-07-31 19:57:04', '2020-07-31 19:57:51', NULL, 'none-id'),
(41, 'San Vicente de Pusir', 7, '#e5bedd', NULL, '[[0.49763567652737084,-77.94800523676622],[0.49471754254438155,-77.87195924677599],[0.48081347489604076,-77.91470292963731]]', 0x00000000010300000001000000040000003016281eac7c53c04181004f43d9df3f4116282ece7753c015147fc473a9df3f2a16287e8a7a53c01ce589e1a5c5de3f3016281eac7c53c04181004f43d9df3f, 'ACTIVE', '2020-07-31 19:57:51', '2020-07-31 19:57:51', NULL, 'none-id'),
(42, '27 de septiembre', 8, '#e5bedd', NULL, '[[0.5059313233342333,-77.95679202727482],[0.49202727911922695,-77.90529361418888],[0.48018307041973923,-77.9586803024213]]', 0x00000000010300000001000000040000000f8ea0143c7d53c0b8c2f7e29630e03f0b8ea054f07953c02da523fc5f7ddf3fed8da0045b7d53c0e7ebe2c551bbde3f0f8ea0143c7d53c0b8c2f7e29630e03f, 'ACTIVE', '2020-07-31 20:00:39', '2020-07-31 20:02:25', NULL, 'none-id'),
(43, 'El Goaltal', 8, '#e5bedd', NULL, '[[0.49106867390987624,-77.96324196988145],[0.4905537086739361,-77.92135659390489],[0.466865265656445,-77.92993966275255]]', 0x000000000103000000010000000400000081b1a5c1a57d53c00d1da24dab6ddf3fa9b1a581f77a53c0cce8eb613b65df3fc1b1a521847b53c02b7fe8d91ee1dd3f81b1a5c1a57d53c00d1da24dab6ddf3f, 'ACTIVE', '2020-07-31 20:01:17', '2020-07-31 20:02:25', NULL, 'none-id'),
(44, 'La Libertad', 8, '#e5bedd', NULL, '[[0.5032838029756448,-77.94571137076949],[0.5217366626606419,-77.9313776457939],[0.497705021078201,-77.91815971976851]]', 0x0000000001030000000100000004000000203afc88867c53c055614ca2e61ae03f493afcb09b7b53c0610de81511b2e03f643afc20c37a53c0ba7e252966dadf3f203afc88867c53c055614ca2e61ae03f, 'ACTIVE', '2020-07-31 20:01:54', '2020-07-31 20:02:25', NULL, 'none-id'),
(45, 'San Isidro', 8, '#e5bedd', NULL, '[[0.5082454804903404,-77.94681015762627],[0.5018084289241144,-77.91144791397393],[0.4914233057463509,-77.91788521560967],[0.5009501549016235,-77.95522156509698]]', 0x00000000010300000001000000050000008ea1a189987c53c05477a1068c43e03fa6a1a129557a53c018c2e28cd00ee03fb8a1a1a1be7a53c0dd0eabbc7a73df3fa3a1a159227d53c0a050879ec807e03f8ea1a189987c53c05477a1068c43e03f, 'ACTIVE', '2020-07-31 20:02:25', '2020-07-31 20:02:25', NULL, 'none-id'),
(46, 'Zona 1', 3, '#e5bedd', NULL, '[[0.33538922308889224,-78.2347798133667],[0.34534540726068297,-78.20413825758057],[0.32242900270425207,-78.1959843421753],[0.32066950129918675,-78.22242019422607]]', 0x0000000001030000000100000005000000060be9a1068f53c0953f265c0477d53f0f0be999108d53c0fb89809f231ad63fdc0ae9018b8c53c0b4627941ada2d43fec0ae9213c8e53c0cbe5395fd985d43f060be9a1068f53c0953f265c0477d53f, 'ACTIVE', '2024-02-22 22:30:49', '2024-02-22 22:30:49', NULL, 'none-id'),
(47, 'Zona uno', 218, '#e5bedd', NULL, '[[0.34174373807838776,-78.1954257229712],[0.3350490611458787,-78.20606872834229],[0.32998513580720057,-78.19971725739502],[0.32938433093416936,-78.19113418854737],[0.3401129838673165,-78.17774460114502],[0.34449027086001627,-78.18529770173096],[0.34268785881096353,-78.18958923615479]]', 0x0000000001030000000100000008000000493de4da818c53c0d634aa2021dfd53f433de43a308d53c0ef540b9e7171d53f553de42ac88c53c092509df9791ed53f3d3de48a3b8c53c0a1554b04a214d53f553de42a608b53c067eda93f69c4d53f5a3de4eadb8b53c0ed92c8eb200cd63f663de43a228c53c0e213950e99eed53f493de4da818c53c0d634aa2021dfd53f, 'ACTIVE', '2024-02-29 12:56:04', '2024-02-29 12:56:04', NULL, 'none-id');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
