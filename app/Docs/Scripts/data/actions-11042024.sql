
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
/*------------------------------------Housing-------------------------------------*/

INSERT INTO `lodging_room_levels` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `business_id`) VALUES
(1, 'Planta Penthouse', 'El penthouse generalmente se encuentra en la parte superior del hotel y ofrece alojamiento de lujo con comodidades adicionales.', '2024-02-29 14:24:06', '2024-02-29 14:24:06', NULL, 'ACTIVE', 1),
(2, 'Planta Baja', 'El primer piso suele ser una parte crucial del hotel, ya que es donde los huéspedes entran y salen y donde se encuentran las áreas comunes principales.', '2024-02-29 14:24:29', '2024-02-29 14:24:45', NULL, 'ACTIVE', 1),
(3, 'Primer Piso', NULL, '2024-02-29 14:24:52', '2024-02-29 14:24:52', NULL, 'ACTIVE', 1),
(4, 'Segundo Piso', NULL, '2024-02-29 14:24:57', '2024-02-29 14:24:57', NULL, 'ACTIVE', 1);
INSERT INTO `lodging_room_features` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`, `business_id`) VALUES
(1, 'Vistas panorámicas desde grandes ventanales o balcones.', 'Vistas panorámicas desde grandes ventanales o balcones', '2024-02-29 14:31:11', '2024-02-29 14:31:11', NULL, 'ACTIVE', 1),
(2, 'Servicio de mayordomo personalizado', NULL, '2024-02-29 14:31:27', '2024-02-29 14:31:27', NULL, 'ACTIVE', 1);

INSERT INTO `tax_by_business` (`id`, `tax_id`, `state`, `business_id`) VALUES
(1, 1, 'ACTIVE', 1);

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `provider_id`, `provider`, `api_token`, `user_id`, `avatar`) VALUES
(1, 'Admin', 'admin@system.dev', 'good', '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', 'YD8q4rYh5b1qMa2gjtlJrZMI3IvT0kllGUOFEkJalFBub0W1Dw0rtiuYVMZ3', 'ACTIVE', '2017-11-25 15:41:16', '2017-11-25 15:41:16', 'server', 'server', NULL, NULL, NULL),
(2, 'Supervisor', 'supervisor@system.dev', 'supervisor', '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', NULL, 'ACTIVE', '2021-05-09 02:23:48', '2021-05-09 02:23:48', NULL, NULL, NULL, NULL, NULL),
(3, 'Alex', 'supervisor2@gmail.com', 'supervisor2', '$2y$10$bzHa0mwLff7MNndE5DSOpu9Ae2CZefyQnqZW9f4PV3CWsFQnG.zeS', NULL, 'ACTIVE', '2024-02-26 23:30:23', '2024-02-26 23:30:23', NULL, 'server', NULL, NULL, NULL);
INSERT INTO `users_has_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1);
INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GOD', 'ACTIVE', NULL, NULL),
(2, 'BUSINESS', 'ACTIVE', '2020-06-14 18:50:42', '2020-06-14 18:50:42'),
(3, 'EMPLOYER', 'ACTIVE', '2020-06-14 19:08:45', '2020-06-14 22:10:21'),
(4, 'CUSTOMER', 'ACTIVE', '2020-06-14 19:17:10', '2020-06-14 19:17:10');
INSERT INTO `business` (`id`, `description`, `title`, `email`, `page_url`, `phone_value`, `street_1`, `street_2`, `street_lat`, `street_lng`, `user_id`, `business_subcategories_id`, `created_at`, `updated_at`, `deleted_at`, `status`, `qualification`, `source`, `options_map`, `has_document`, `has_about`, `has_service_delivery`, `type_business`, `type_manager_payment`, `business_name`, `keep_accounting`, `type_ruc_id`, `allow_cash_and_banks`, `entity_plans_id`, `entity_position_fiscal_id`, `document`) VALUES
(1, 'Empresa dedicada al desarrollo de software.', 'Meetclic', 'kalexmiguelalba@gmail.com', 'www.meetclic.com', '0985339457', 'Piedrahita y buenos aires', 'Buenos AIRE', 0.231448, -78.2571, 1, 44, NULL, NULL, NULL, 'ACTIVE', 0, '/uploads/business/information/1598107770_Empresa.jpg', NULL, 0, 0, 0, 2, 0, 'Meetclic', 0, 4, 0, 3, 1, '1002954889');
INSERT INTO `human_resources_department` (`id`, `name`, `description`, `status`, `business_id`) VALUES
(1, 'Sistemas', '', 'ACTIVE', 1),
(2, 'Marketing', '', 'ACTIVE', 1),
(3, 'Diseño', '', 'ACTIVE', 1),
(4, 'Ventas', '', 'ACTIVE', 1);

INSERT INTO `business_by_language` (`id`, `language_id`, `business_id`, `state`, `main`) VALUES
(1, 1, 1, 'ACTIVE', 0),
(2, 2, 1, 'ACTIVE', 0),
(3, 3, 1, 'ACTIVE', 1);

INSERT INTO `business_by_schedule` (`id`, `type`, `open`, `business_id`, `status`, `schedule_days_category_id`) VALUES
(1, 0, 1, 1, 'ACTIVE', 1),
(2, 0, 1, 1, 'ACTIVE', 2),
(3, 0, 1, 1, 'ACTIVE', 3),
(4, 0, 1, 1, 'ACTIVE', 4),
(5, 0, 1, 1, 'ACTIVE', 5),
(6, 0, 1, 1, 'ACTIVE', 6),
(7, 0, 1, 1, 'ACTIVE', 7);

INSERT INTO `business_location` (`id`, `zones_id`, `business_id`) VALUES
(1, 2, 1);

INSERT INTO `information_mail` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_mail_type_id`) VALUES
(1, 'kalexmigujelalba@gmail.com', 'ACTIVE', 3, 1, 1, 1);

INSERT INTO `information_phone` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_phone_operator_id`, `information_phone_type_id`) VALUES
(1, '0969143060', 'ACTIVE', 3, 1, 1, 2, 2);


INSERT INTO `information_social_network` (`id`, `value`, `state`, `entity_id`, `main`, `entity_type`, `information_social_network_type_id`) VALUES
(1, 'http://flowers.com/', 'ACTIVE', 2, 1, 4, 1);


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
