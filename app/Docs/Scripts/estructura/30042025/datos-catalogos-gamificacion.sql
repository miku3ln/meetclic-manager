SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


INSERT INTO `business_by_gamification` (`id`, `gamification_id`, `business_id`, `allow_exchange`,
                                        `allow_exchange_business`, `state`)
VALUES (1, 1, 1, 1, 1, 'ACTIVE');

INSERT INTO `gamification` (`id`, `value`, `description`, `value_unit`, `state`, `maximum_exchange`)
VALUES (1, 'Configuracion Inicial Gamificacion', 'Configuracion', 0, 'ACTIVE', 0);


INSERT INTO `gamification_by_process` (`id`, `source`, `title`, `subtitle`, `description`, `state`, `valid_from`,
                                       `valid_until`, `expiration_type`, `expiration_value`, `frequency_limit_type`,
                                       `frequency_limit_value`, `is_repetitive`, `max_times_per_user`, `has_source`,
                                       `entity`, `entity_id`, `url_manager`, `gamification_id`,
                                       `gamification_type_activity_id`, `is_url`, `type_manager`, `user_id`,
                                       `unique_code`, `allow_golden`, `icon_class`)
VALUES (1, '/uploads/gamification/gamificationByProcess/process_1.png', 'Ver producto', 'Ver producto (detalle)',
        'Acción relacionada con la tarea \'Ver producto\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '1', 'null', 1, 1, 0, 1, 264, 'GE-001', 0,
        'fa fa-building'),
       (2, '/uploads/gamification/gamificationByProcess/process_2.png', 'Compartir producto',
        'Compartir producto (detalle)',
        'Acción relacionada con la tarea \'Compartir producto\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '2', 'null', 1, 1, 0, 1, 192, 'GE-002', 0,
        'fa fa-calendar-times-o'),
       (3, '/uploads/gamification/gamificationByProcess/process_3.png', 'Like producto', 'Like producto (detalle)',
        'Acción relacionada con la tarea \' Like producto\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '3', 'null', 1, 1, 0, 1, 440, 'GE-003', 0,
        'fa fa-smile-o'),
       (4, '/uploads/gamification/gamificationByProcess/process_4.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        'Acción relacionada con la tarea \'Agregar al carrito\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '4', 'null', 1, 1, 0, 1, 813, 'GE-004', 0,
        'fa fa-forumbee'),
       (5, '/uploads/gamification/gamificationByProcess/process_5.png', 'Finalizar compra',
        'Finalizar compra (detalle)',
        'Acción relacionada con la tarea \'Finalizar compra\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '5', 'null', 1, 1, 0, 1, 356, 'GE-005', 0,
        'fa fa-check'),
       (6, '/uploads/gamification/gamificationByProcess/process_6.png', 'Escribir reseña', 'Escribir reseña (detalle)',
        'Acción relacionada con la tarea \'Escribir reseña\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '6', 'null', 1, 1, 0, 1, 77, 'GE-006', 0,
        'fa fa-shopping-cart'),
       (7, '/uploads/gamification/gamificationByProcess/process_7.png', 'Usar cupón', 'Usar cupón (detalle)',
        'Acción relacionada con la tarea \'Usar cupón\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '7', 'null', 1, 1, 0, 1, 301, 'GE-007', 0,
        'fa fa-shopping-cart'),
       (8, '/uploads/gamification/gamificationByProcess/process_8.png', 'Reclamar devolución',
        'Reclamar devolución (detalle)',
        'Acción relacionada con la tarea \'Reclamar devolución\' en la categoría \'GESTION_ECOMMERCE\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '8', 'null', 1, 1, 0, 1, 219, 'GE-008',
        0, 'fa fa-hand-pointer-o'),
       (9, '/uploads/gamification/gamificationByProcess/process_9.png', 'Unirse a la comunidad .',
        'Registrarse en empresa (detalle)',
        'Acción relacionada con la tarea \'Registrarse en empresa\' en la categoría \'CONOCIMIENTO_EMPRESA\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '9', 'null', 1, 2, 0, 1,
        535, 'CE-009', 0, 'fa fa-comments-o'),
       (10, '/uploads/gamification/gamificationByProcess/process_10.png', 'Ver perfil de empresa',
        'Ver perfil de empresa (detalle)',
        'Acción relacionada con la tarea \'Ver perfil de empresa\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '10', 'null', 1, 2, 0, 1, 661,
        'CE-010', 1, 'fa fa-unlock-alt'),
       (11, '/uploads/gamification/gamificationByProcess/process_11.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        'Acción relacionada con la tarea \'Compartir empresa\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '11', 'null', 1, 2, 0, 1, 238,
        'CE-011', 0, 'fa fa-calendar-times-o'),
       (12, '/uploads/gamification/gamificationByProcess/process_12.png', 'Seguir empresa', 'Seguir empresa (detalle)',
        'Acción relacionada con la tarea \'Seguir empresa\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '12', 'null', 1, 2, 0, 1, 411, 'CE-012',
        0, 'fa fa-forumbee'),
       (13, '/uploads/gamification/gamificationByProcess/process_13.png', 'Marcar como favorita',
        'Marcar como favorita (detalle)',
        'Acción relacionada con la tarea \'Marcar como favorita\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '13', 'null', 1, 2, 0, 1, 90,
        'CE-013', 0, 'fa fa-bullhorn'),
       (14, '/uploads/gamification/gamificationByProcess/process_14.png', 'Visitar enlace web',
        'Visitar enlace web (detalle)',
        'Acción relacionada con la tarea \'Visitar enlace web\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '14', 'null', 1, 2, 0, 1, 906,
        'CE-014', 0, 'fa fa-flag'),
       (15, '/uploads/gamification/gamificationByProcess/process_15.png', 'Calificar empresa',
        'Calificar empresa (detalle)',
        'Acción relacionada con la tarea \'Calificar empresa\' en la categoría \'CONOCIMIENTO_EMPRESA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '15', 'null', 1, 2, 0, 1, 994,
        'CE-015', 0, 'fa fa-heart'),
       (16, '/uploads/gamification/gamificationByProcess/process_16.png', 'Actualizar perfil',
        'Actualizar perfil (detalle)',
        'Acción relacionada con la tarea \'Actualizar perfil\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '16', 'null', 1, 3, 0, 1, 363, 'GC-016', 0,
        'fa fa-hand-pointer-o'),
       (17, '/uploads/gamification/gamificationByProcess/process_17.png', 'Actualizar dirección',
        'Actualizar dirección (detalle)',
        'Acción relacionada con la tarea \'Actualizar dirección\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '17', 'null', 1, 3, 0, 1, 846, 'GC-017', 0,
        'fa fa-flag'),
       (18, '/uploads/gamification/gamificationByProcess/process_18.png', 'Actualizar número',
        'Actualizar número (detalle)',
        'Acción relacionada con la tarea \'Actualizar número\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '18', 'null', 1, 3, 0, 1, 163, 'GC-018', 0,
        'fa fa-briefcase'),
       (19, '/uploads/gamification/gamificationByProcess/process_19.png', 'Subir foto', 'Subir foto (detalle)',
        'Acción relacionada con la tarea \'Subir foto\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '19', 'null', 1, 3, 0, 1, 305, 'GC-019', 0,
        'fa fa-users'),
       (20, '/uploads/gamification/gamificationByProcess/process_20.png', 'Agregar preferencia',
        'Agregar preferencia (detalle)',
        'Acción relacionada con la tarea \'Agregar preferencia\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '20', 'null', 1, 3, 0, 1, 942, 'GC-020', 0,
        'fa fa-comments-o'),
       (21, '/uploads/gamification/gamificationByProcess/process_21.png', 'Borrar dato', 'Borrar dato (detalle)',
        'Acción relacionada con la tarea \'Borrar dato\' en la categoría \'GESTION_CLIENTE\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '21', 'null', 21, 3, 0, 1, 409, 'GC-021', 0,
        'fa fa-check'),
       (22, '/uploads/gamification/gamificationByProcess/process_22.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        'Acción relacionada con la tarea \'Responder encuesta\' en la categoría \'ENGAGEMENT_MARKETING\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '22', 'null', 1, 4, 0, 1, 374,
        'EM-022', 0, 'fa fa-check'),
       (23, '/uploads/gamification/gamificationByProcess/process_23.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        'Acción relacionada con la tarea \'Participar en campaña\' en la categoría \'ENGAGEMENT_MARKETING\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '23', 'null', 1, 4, 0, 1, 761,
        'EM-023', 0, 'fa fa-bar-chart'),
       (24, '/uploads/gamification/gamificationByProcess/process_24.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción relacionada con la tarea \'Reaccionar a banner\' en la categoría \'ENGAGEMENT_MARKETING\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '24', 'null', 1, 4, 0, 1, 972,
        'EM-024', 0, 'fa fa-lightbulb-o'),
       (25, '/uploads/gamification/gamificationByProcess/process_25.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        'Acción relacionada con la tarea \'Compartir sorteo\' en la categoría \'ENGAGEMENT_MARKETING\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '25', 'null', 1, 4, 0, 1, 726,
        'EM-025', 0, 'fa fa-flag'),
       (26, '/uploads/gamification/gamificationByProcess/process_26.png', 'Unirse a evento de marca',
        'Unirse a evento de marca (detalle)',
        'Acción relacionada con la tarea \'Unirse a evento de marca\' en la categoría \'ENGAGEMENT_MARKETING\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '26', 'null', 1, 4, 0, 1,
        863, 'EM-026', 0, 'fa fa-tag'),
       (27, '/uploads/gamification/gamificationByProcess/process_27.png', 'Enviar queja', 'Enviar queja (detalle)',
        'Acción relacionada con la tarea \'Enviar queja\' en la categoría \'RETROALIMENTACION_CLIENTE\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '27', 'null', 1, 5, 0, 1, 597,
        'RC-027', 0, 'fa fa-check'),
       (28, '/uploads/gamification/gamificationByProcess/process_28.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        'Acción relacionada con la tarea \'Votar sugerencia\' en la categoría \'RETROALIMENTACION_CLIENTE\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '28', 'null', 1, 5, 0, 1, 794,
        'RC-028', 0, 'fa fa-envelope-o'),
       (29, '/uploads/gamification/gamificationByProcess/process_29.png', 'Calificar compra',
        'Calificar compra (detalle)',
        'Acción relacionada con la tarea \'Calificar compra\' en la categoría \'RETROALIMENTACION_CLIENTE\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '29', 'null', 1, 5, 0, 1, 485,
        'RC-029', 0, 'fa fa-unlock-alt'),
       (30, '/uploads/gamification/gamificationByProcess/process_30.png', 'Dejar retroalimentación',
        'Dejar retroalimentación (detalle)',
        'Acción relacionada con la tarea \'Dejar retroalimentación\' en la categoría \'RETROALIMENTACION_CLIENTE\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '30', 'null', 1, 5,
        0, 1, 506, 'RC-030', 0, 'fa fa-calendar-times-o'),
       (31, '/uploads/gamification/gamificationByProcess/process_31.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        'Acción relacionada con la tarea \'Hacer check-in\' en la categoría \'INTERACCION_PRESENCIAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '31', 'null', 1, 6, 0, 1, 452,
        'IP-031', 0, 'fa fa-forumbee'),
       (32, '/uploads/gamification/gamificationByProcess/process_32.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        'Acción relacionada con la tarea \'Escanear código QR\' en la categoría \'INTERACCION_PRESENCIAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '32', 'null', 1, 6, 0, 1, 602,
        'IP-032', 0, 'fa fa-flag'),
       (33, '/uploads/gamification/gamificationByProcess/process_33.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción relacionada con la tarea \'Participar en evento físico\' en la categoría \'INTERACCION_PRESENCIAL\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '33', 'null', 1, 6, 0,
        1, 611, 'IP-033', 0, 'fa fa-tag'),
       (34, '/uploads/gamification/gamificationByProcess/process_34.png', 'Solicitar visita presencial',
        'Solicitar visita presencial (detalle)',
        'Acción relacionada con la tarea \'Solicitar visita presencial\' en la categoría \'INTERACCION_PRESENCIAL\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '34', 'null', 1, 6, 0,
        1, 534, 'IP-034', 0, 'fa fa-star-o'),
       (35, '/uploads/gamification/gamificationByProcess/process_35.png', 'Referir producto',
        'Referir producto (detalle)',
        'Acción relacionada con la tarea \'Referir producto\' en la categoría \'REFERIDOS\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '35', 'null', 1, 7, 0, 1, 179, 'R-035', 0,
        'fa fa-briefcase'),
       (36, '/uploads/gamification/gamificationByProcess/process_36.png', 'Referir empresa',
        'Referir empresa (detalle)',
        'Acción relacionada con la tarea \'Referir empresa\' en la categoría \'REFERIDOS\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '36', 'null', 1, 7, 0, 1, 231, 'R-036', 0,
        'fa fa-calendar-times-o'),
       (37, '/uploads/gamification/gamificationByProcess/process_37.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        'Acción relacionada con la tarea \'Compartir código de invitación\' en la categoría \'REFERIDOS\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '37', 'null', 1, 7, 0, 1, 84, 'R-037', 0,
        'fa fa-hand-pointer-o'),
       (38, '/uploads/gamification/gamificationByProcess/process_38.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción relacionada con la tarea \'Registrar invitado\' en la categoría \'REFERIDOS\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '38', 'null', 1, 7, 0, 1, 40, 'R-038', 0,
        'fa fa-hand-pointer-o'),
       (39, '/uploads/gamification/gamificationByProcess/process_39.png', 'Leer noticia', 'Leer noticia (detalle)',
        'Acción relacionada con la tarea \'Leer noticia\' en la categoría \'CONTENIDO_EMPRESARIAL\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '39', 'null', 1, 8, 0, 1, 165, 'CE-039',
        0, 'fa fa fa-gift'),
       (40, '/uploads/gamification/gamificationByProcess/process_40.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        'Acción relacionada con la tarea \'Compartir noticia\' en la categoría \'CONTENIDO_EMPRESARIAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '40', 'null', 1, 8, 0, 1, 646,
        'CE-040', 0, 'fa fa-hand-pointer-o'),
       (41, '/uploads/gamification/gamificationByProcess/process_41.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        'Acción relacionada con la tarea \'Comentar artículo\' en la categoría \'CONTENIDO_EMPRESARIAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '41', 'null', 1, 8, 0, 1, 646,
        'CE-041', 0, 'fa fa-forumbee'),
       (42, '/uploads/gamification/gamificationByProcess/process_42.png', 'Guardar noticia',
        'Guardar noticia (detalle)',
        'Acción relacionada con la tarea \'Guardar noticia\' en la categoría \'CONTENIDO_EMPRESARIAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '42', 'null', 1, 8, 0, 1, 458,
        'CE-042', 0, 'fa fa-users'),
       (43, '/uploads/gamification/gamificationByProcess/process_43.png', 'Canjear puntos', 'Canjear puntos (detalle)',
        'Acción relacionada con la tarea \'Canjear puntos\' en la categoría \'FIDELIZACION\'.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '43', 'null', 1, 9, 0, 1, 336, 'F-043', 0,
        'fa fa-star-o'),
       (44, '/uploads/gamification/gamificationByProcess/process_44.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        'Acción relacionada con la tarea \'Logro desbloqueado\' en la categoría \'FIDELIZACION\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '44', 'null', 1, 9, 0, 1, 70, 'F-044', 0,
        'fa fa-heart'),
       (45, '/uploads/gamification/gamificationByProcess/process_45.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        'Acción relacionada con la tarea \'Completar desafío diario\' en la categoría \'FIDELIZACION\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '45', 'null', 1, 9, 0, 1, 192, 'F-045', 0,
        'fa fa-bullhorn'),
       (46, '/uploads/gamification/gamificationByProcess/process_46.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        'Acción relacionada con la tarea \'Completar reto mensual\' en la categoría \'FIDELIZACION\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '46', 'null', 1, 9, 0, 1, 685, 'F-046', 0,
        'fa fa-bar-chart'),
       (47, '/uploads/gamification/gamificationByProcess/process_47.png', 'Calificar atención',
        'Calificar atención (detalle)',
        'Acción relacionada con la tarea \'Calificar atención\' en la categoría \'MULTIDEPARTAMENTAL\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '47', 'null', 1, 10, 0, 1, 58,
        'M-047', 0, 'fa fa-heart'),
       (48, '/uploads/gamification/gamificationByProcess/process_48.png', 'Evaluar entrega',
        'Evaluar entrega (detalle)',
        'Acción relacionada con la tarea \'Evaluar entrega\' en la categoría \'MULTIDEPARTAMENTAL\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '48', 'null', 1, 10, 0, 1, 312, 'M-048', 0,
        'fa fa-comments-o'),
       (49, '/uploads/gamification/gamificationByProcess/process_49.png', 'Responder encuesta de soporte',
        'Responder encuesta de soporte (detalle)',
        'Acción relacionada con la tarea \'Responder encuesta de soporte\' en la categoría \'MULTIDEPARTAMENTAL\'.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '49', 'null', 1, 10, 0, 1,
        510, 'M-049', 0, 'fa fa-building'),
       (50, '/uploads/gamification/gamificationByProcess/process_50.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        'Acción relacionada con la tarea \'Compartir cupón\' en la categoría \'PROMOCION_MARCA\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '50', 'null', 1, 11, 0, 1, 351, 'PM-050', 0,
        'fa fa-smile-o'),
       (51, '/uploads/gamification/gamificationByProcess/process_51.png', 'Publicar en redes',
        'Publicar en redes (detalle)',
        'Acción relacionada con la tarea \'Publicar en redes\' en la categoría \'PROMOCION_MARCA\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '51', 'null', 1, 11, 0, 1, 673, 'PM-051', 0,
        'fa fa-tag'),
       (52, '/uploads/gamification/gamificationByProcess/process_52.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        'Acción relacionada con la tarea \'Recomendar públicamente\' en la categoría \'PROMOCION_MARCA\'.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '52', 'null', 1, 11, 0, 1, 193, 'PM-052',
        0, 'fa fa-star-o'),
       (53, '/uploads/gamification/gamificationByProcess/process_53.png', 'Crear publicación',
        'Crear publicación (detalle)',
        'Acción relacionada con la tarea \'Crear publicación\' en la categoría \'PROMOCION_MARCA\'.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '53', 'null', 1, 11, 0, 1, 872, 'PM-053', 0,
        'fa fa-comments-o'),
       (54, '/uploads/gamification/gamificationByProcess/process_54.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '54', 'null', 1, 4, 0, 1, 502,
        'EM-054', 0, 'fa fa-flag'),
       (55, '/uploads/gamification/gamificationByProcess/process_55.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '55', 'null', 1, 4, 0, 1, 176,
        'EM-055', 0, 'fa fa-briefcase'),
       (56, '/uploads/gamification/gamificationByProcess/process_56.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '56', 'null', 1, 7, 0, 1, 550, 'R-056', 0,
        'fa fa-briefcase'),
       (57, '/uploads/gamification/gamificationByProcess/process_57.png', 'Actualizar dirección',
        'Actualizar dirección (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '57', 'null', 1, 3, 0, 1, 799, 'GC-057',
        0, 'fa fa-smile-o'),
       (58, '/uploads/gamification/gamificationByProcess/process_58.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '58', 'null', 1, 4, 0, 1, 196,
        'EM-058', 0, 'fa fa-smile-o'),
       (59, '/uploads/gamification/gamificationByProcess/process_59.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '59', 'null', 1, 4, 0, 1, 569,
        'EM-059', 0, 'fa fa-shopping-cart'),
       (60, '/uploads/gamification/gamificationByProcess/process_60.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '60', 'null', 1, 6, 0,
        1, 329, 'IP-060', 0, 'fa fa-calendar-times-o'),
       (61, '/uploads/gamification/gamificationByProcess/process_61.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '61', 'null', 1, 6, 0,
        1, 779, 'IP-061', 0, 'fa fa-hand-pointer-o'),
       (62, '/uploads/gamification/gamificationByProcess/process_62.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '62', 'null', 1, 6, 0,
        1, 113, 'IP-062', 0, 'fa fa-star-o'),
       (63, '/uploads/gamification/gamificationByProcess/process_63.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '63', 'null', 1, 9, 0, 1, 14, 'F-063', 0,
        'fa fa-calendar-times-o'),
       (64, '/uploads/gamification/gamificationByProcess/process_64.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '64', 'null', 1, 11, 0, 1, 673, 'PM-064',
        0, 'fa fa-shopping-cart'),
       (65, '/uploads/gamification/gamificationByProcess/process_65.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '65', 'null', 1, 11, 0, 1, 126, 'PM-065',
        0, 'fa fa-bullhorn'),
       (66, '/uploads/gamification/gamificationByProcess/process_66.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '66', 'null', 1, 8, 0, 1,
        93, 'CE-066', 0, 'fa fa-tag'),
       (67, '/uploads/gamification/gamificationByProcess/process_67.png', 'Responder encuesta de soporte',
        'Responder encuesta de soporte (detalle)',
        'Acción gamificada enfocada en \'multidepartamental\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '67', 'null', 1, 10, 0, 1, 389,
        'M-067', 0, 'fa fa fa-gift'),
       (68, '/uploads/gamification/gamificationByProcess/process_68.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '68', 'null', 1, 5,
        0, 1, 352, 'RC-068', 0, 'fa fa-hand-pointer-o'),
       (69, '/uploads/gamification/gamificationByProcess/process_69.png', 'Enviar queja', 'Enviar queja (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '69', 'null', 1, 5,
        0, 1, 399, 'RC-069', 0, 'fa fa-forumbee'),
       (70, '/uploads/gamification/gamificationByProcess/process_70.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '70', 'null', 1, 7, 0, 1, 858, 'R-070', 0,
        'fa fa-star-o'),
       (71, '/uploads/gamification/gamificationByProcess/process_71.png', 'Compartir producto',
        'Compartir producto (detalle)',
        'Acción gamificada enfocada en \'gestion_ecommerce\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '71', 'null', 1, 1, 0, 1, 979,
        'GE-071', 0, 'fa fa-tag'),
       (72, '/uploads/gamification/gamificationByProcess/process_72.png', 'Calificar compra',
        'Calificar compra (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '72', 'null', 1, 5,
        0, 1, 182, 'RC-072', 0, 'fa fa-check'),
       (73, '/uploads/gamification/gamificationByProcess/process_73.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '73', 'null', 1, 7, 0, 1, 145, 'R-073', 0,
        'fa fa-bar-chart'),
       (74, '/uploads/gamification/gamificationByProcess/process_74.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '74', 'null', 1, 9, 0, 1, 780, 'F-074', 0,
        'fa fa-unlock-alt'),
       (75, '/uploads/gamification/gamificationByProcess/process_75.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '75', 'null', 1, 9, 0, 1, 297, 'F-075', 0,
        'fa fa-heart'),
       (76, '/uploads/gamification/gamificationByProcess/process_76.png', 'Calificar compra',
        'Calificar compra (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '76', 'null', 1, 5,
        0, 1, 627, 'RC-076', 0, 'fa fa-smile-o'),
       (77, '/uploads/gamification/gamificationByProcess/process_77.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '77', 'null', 1, 7, 0, 1, 689, 'R-077', 0,
        'fa fa-heart'),
       (78, '/uploads/gamification/gamificationByProcess/process_78.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '78', 'null', 1, 8, 0, 1,
        4, 'CE-078', 0, 'fa fa-heart'),
       (79, '/uploads/gamification/gamificationByProcess/process_79.png', 'Enviar queja', 'Enviar queja (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '79', 'null', 1, 5,
        0, 1, 531, 'RC-079', 0, 'fa fa-unlock-alt'),
       (80, '/uploads/gamification/gamificationByProcess/process_80.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '80', 'null', 1, 9, 0, 1, 208, 'F-080', 0,
        'fa fa-comments-o'),
       (81, '/uploads/gamification/gamificationByProcess/process_81.png', 'Publicar en redes',
        'Publicar en redes (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '81', 'null', 1, 11, 0, 1, 486, 'PM-081',
        0, 'fa fa-shopping-cart'),
       (82, '/uploads/gamification/gamificationByProcess/process_82.png', 'Referir producto',
        'Referir producto (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '82', 'null', 1, 7, 0, 1, 272, 'R-082', 0,
        'fa fa-star-o'),
       (83, '/uploads/gamification/gamificationByProcess/process_83.png', 'Referir empresa',
        'Referir empresa (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '83', 'null', 1, 7, 0, 1, 676, 'R-083', 0,
        'fa fa fa-gift'),
       (84, '/uploads/gamification/gamificationByProcess/process_84.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '84', 'null', 1, 4, 0, 1, 876,
        'EM-084', 0, 'fa fa-calendar-times-o'),
       (85, '/uploads/gamification/gamificationByProcess/process_85.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '85', 'null', 1, 7, 0, 1, 699, 'R-085', 0,
        'fa fa-hand-pointer-o'),
       (86, '/uploads/gamification/gamificationByProcess/process_86.png', 'Actualizar número',
        'Actualizar número (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '86', 'null', 1, 3, 0, 1, 251, 'GC-086',
        0, 'fa fa-tag'),
       (87, '/uploads/gamification/gamificationByProcess/process_87.png', 'Referir producto',
        'Referir producto (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '87', 'null', 1, 7, 0, 1, 924, 'R-087', 0,
        'fa fa-calendar-times-o'),
       (88, '/uploads/gamification/gamificationByProcess/process_88.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '88', 'null', 1, 6, 0,
        1, 153, 'IP-088', 0, 'fa fa-envelope-o'),
       (89, '/uploads/gamification/gamificationByProcess/process_89.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '89', 'null', 1, 6, 0,
        1, 895, 'IP-089', 0, 'fa fa-star-o'),
       (90, '/uploads/gamification/gamificationByProcess/process_90.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '90', 'null', 1, 4, 0, 1, 603,
        'EM-090', 0, 'fa fa-comments-o'),
       (91, '/uploads/gamification/gamificationByProcess/process_91.png', 'Calificar atención',
        'Calificar atención (detalle)',
        'Acción gamificada enfocada en \'multidepartamental\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '91', 'null', 1, 10, 0, 1, 599,
        'M-091', 0, 'fa fa-star-o'),
       (92, '/uploads/gamification/gamificationByProcess/process_92.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '92', 'null', 1, 9, 0, 1, 404, 'F-092', 0,
        'fa fa-lightbulb-o'),
       (93, '/uploads/gamification/gamificationByProcess/process_93.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '93', 'null', 1, 4, 0, 1, 45,
        'EM-093', 0, 'fa fa-unlock-alt'),
       (94, '/uploads/gamification/gamificationByProcess/process_94.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '94', 'null', 1, 6, 0,
        1, 445, 'IP-094', 0, 'fa fa-bullhorn'),
       (95, '/uploads/gamification/gamificationByProcess/process_95.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '95', 'null', 1, 8, 0, 1,
        623, 'CE-095', 0, 'fa fa fa-gift'),
       (96, '/uploads/gamification/gamificationByProcess/process_96.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '96', 'null', 1, 7, 0, 1, 676, 'R-096', 0,
        'fa fa-unlock-alt'),
       (97, '/uploads/gamification/gamificationByProcess/process_97.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '97', 'null', 1, 2, 0, 1, 522,
        'CE-097', 0, 'fa fa-forumbee'),
       (98, '/uploads/gamification/gamificationByProcess/process_98.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '98', 'null', 1, 6, 0,
        1, 603, 'IP-098', 0, 'fa fa-flag'),
       (99, '/uploads/gamification/gamificationByProcess/process_99.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '99', 'null', 1, 4, 0, 1, 801,
        'EM-099', 0, 'fa fa fa-gift'),
       (100, '/uploads/gamification/gamificationByProcess/process_100.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '100', 'null', 1, 6, 0,
        1, 711, 'IP-100', 0, 'fa fa-building'),
       (101, '/uploads/gamification/gamificationByProcess/process_101.png', 'Finalizar compra',
        'Finalizar compra (detalle)',
        'Acción gamificada enfocada en \'gestion_ecommerce\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '101', 'null', 1, 1, 0, 1, 71,
        'GE-101', 0, 'fa fa-building'),
       (102, '/uploads/gamification/gamificationByProcess/process_102.png', 'Actualizar número',
        'Actualizar número (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '102', 'null', 1, 3, 0, 1, 865, 'GC-102',
        0, 'fa fa-smile-o'),
       (103, '/uploads/gamification/gamificationByProcess/process_103.png', 'Actualizar número',
        'Actualizar número (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '103', 'null', 1, 3, 0, 1, 80, 'GC-103',
        0, 'fa fa-check'),
       (104, '/uploads/gamification/gamificationByProcess/process_104.png', 'Guardar noticia',
        'Guardar noticia (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '104', 'null', 1, 8, 0,
        1, 78, 'CE-104', 0, 'fa fa-smile-o'),
       (105, '/uploads/gamification/gamificationByProcess/process_105.png', 'Unirse a evento de marca',
        'Unirse a evento de marca (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '105', 'null', 1, 4, 0, 1, 686,
        'EM-105', 0, 'fa fa-building'),
       (106, '/uploads/gamification/gamificationByProcess/process_106.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '106', 'null', 1, 7, 0, 1, 34, 'R-106', 0,
        'fa fa-forumbee'),
       (107, '/uploads/gamification/gamificationByProcess/process_107.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '107', 'null', 1, 4, 0, 1, 277,
        'EM-107', 0, 'fa fa-bullhorn'),
       (108, '/uploads/gamification/gamificationByProcess/process_108.png', 'Ver perfil de empresa',
        'Ver perfil de empresa (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '108', 'null', 1, 2, 0, 1, 559,
        'CE-108', 0, 'fa fa-envelope-o'),
       (109, '/uploads/gamification/gamificationByProcess/process_109.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '109', 'null', 1, 4, 0, 1, 838,
        'EM-109', 0, 'fa fa-hand-pointer-o'),
       (110, '/uploads/gamification/gamificationByProcess/process_110.png', 'Calificar empresa',
        'Calificar empresa (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '110', 'null', 1, 2, 0, 1, 812,
        'CE-110', 0, 'fa fa-calendar-times-o'),
       (111, '/uploads/gamification/gamificationByProcess/process_111.png', 'Borrar dato', 'Borrar dato (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '111', 'null', 1, 3, 0, 1, 883, 'GC-111',
        0, 'fa fa-comments-o'),
       (112, '/uploads/gamification/gamificationByProcess/process_112.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '112', 'null', 1, 6, 0,
        1, 197, 'IP-112', 0, 'fa fa-comments-o'),
       (113, '/uploads/gamification/gamificationByProcess/process_113.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '113', 'null', 1, 11, 0, 1, 835,
        'PM-113', 0, 'fa fa-bullhorn'),
       (114, '/uploads/gamification/gamificationByProcess/process_114.png', 'Calificar compra',
        'Calificar compra (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '114', 'null', 1, 5,
        0, 1, 809, 'RC-114', 0, 'fa fa-bullhorn'),
       (115, '/uploads/gamification/gamificationByProcess/process_115.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '115', 'null', 1, 2, 0, 1, 537,
        'CE-115', 0, 'fa fa-calendar-times-o'),
       (116, '/uploads/gamification/gamificationByProcess/process_116.png', 'Hacer check-in',
        'Hacer check-in (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '116', 'null', 1, 6, 0,
        1, 697, 'IP-116', 0, 'fa fa-users'),
       (117, '/uploads/gamification/gamificationByProcess/process_117.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '117', 'null', 1, 4, 0, 1, 611,
        'EM-117', 0, 'fa fa-users'),
       (118, '/uploads/gamification/gamificationByProcess/process_118.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '118', 'null', 1, 8, 0,
        1, 802, 'CE-118', 0, 'fa fa-forumbee'),
       (119, '/uploads/gamification/gamificationByProcess/process_119.png', 'Usar cupón', 'Usar cupón (detalle)',
        'Acción gamificada enfocada en \'gestion_ecommerce\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '119', 'null', 1, 1, 0, 1, 352,
        'GE-119', 0, 'fa fa fa-gift'),
       (120, '/uploads/gamification/gamificationByProcess/process_120.png', 'Borrar dato', 'Borrar dato (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '120', 'null', 1, 3, 0, 1, 63, 'GC-120',
        0, 'fa fa-users'),
       (121, '/uploads/gamification/gamificationByProcess/process_121.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '121', 'null', 1, 5,
        0, 1, 177, 'RC-121', 0, 'fa fa-shopping-cart'),
       (122, '/uploads/gamification/gamificationByProcess/process_122.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '122', 'null', 1, 11, 0, 1, 180,
        'PM-122', 0, 'fa fa fa-gift'),
       (123, '/uploads/gamification/gamificationByProcess/process_123.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '123', 'null', 1, 4, 0, 1, 757,
        'EM-123', 0, 'fa fa-bullhorn'),
       (124, '/uploads/gamification/gamificationByProcess/process_124.png', 'Actualizar perfil',
        'Actualizar perfil (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '124', 'null', 1, 3, 0, 1, 966, 'GC-124',
        0, 'fa fa-shopping-cart'),
       (125, '/uploads/gamification/gamificationByProcess/process_125.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '125', 'null', 1, 9, 0, 1, 440, 'F-125', 0,
        'fa fa-unlock-alt'),
       (126, '/uploads/gamification/gamificationByProcess/process_126.png', 'Calificar atención',
        'Calificar atención (detalle)',
        'Acción gamificada enfocada en \'multidepartamental\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '126', 'null', 1, 10, 0, 1, 286,
        'M-126', 0, 'fa fa-tag'),
       (127, '/uploads/gamification/gamificationByProcess/process_127.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '127', 'null', 1, 4, 0, 1, 775,
        'EM-127', 0, 'fa fa-comments-o'),
       (128, '/uploads/gamification/gamificationByProcess/process_128.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '128', 'null', 1, 6, 0,
        1, 164, 'IP-128', 0, 'fa fa-smile-o'),
       (129, '/uploads/gamification/gamificationByProcess/process_129.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '129', 'null', 1, 9, 0, 1, 203, 'F-129', 0,
        'fa fa-check'),
       (130, '/uploads/gamification/gamificationByProcess/process_130.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '130', 'null', 1, 7, 0, 1, 895, 'R-130', 0,
        'fa fa-users'),
       (131, '/uploads/gamification/gamificationByProcess/process_131.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '131', 'null', 1, 4, 0, 1, 950,
        'EM-131', 0, 'fa fa-heart'),
       (132, '/uploads/gamification/gamificationByProcess/process_132.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '132', 'null', 1, 11, 0, 1, 187,
        'PM-132', 0, 'fa fa-lightbulb-o'),
       (133, '/uploads/gamification/gamificationByProcess/process_133.png', 'Enviar queja', 'Enviar queja (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '133', 'null', 1, 5,
        0, 1, 788, 'RC-133', 0, 'fa fa-flag'),
       (134, '/uploads/gamification/gamificationByProcess/process_134.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '134', 'null', 1, 9, 0, 1, 87, 'F-134', 0,
        'fa fa-bullhorn'),
       (135, '/uploads/gamification/gamificationByProcess/process_135.png', 'Dejar retroalimentación',
        'Dejar retroalimentación (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '135', 'null', 1, 5,
        0, 1, 350, 'RC-135', 0, 'fa fa-briefcase');
INSERT INTO `gamification_by_process` (`id`, `source`, `title`, `subtitle`, `description`, `state`, `valid_from`,
                                       `valid_until`, `expiration_type`, `expiration_value`, `frequency_limit_type`,
                                       `frequency_limit_value`, `is_repetitive`, `max_times_per_user`, `has_source`,
                                       `entity`, `entity_id`, `url_manager`, `gamification_id`,
                                       `gamification_type_activity_id`, `is_url`, `type_manager`, `user_id`,
                                       `unique_code`, `allow_golden`, `icon_class`)
VALUES (136, '/uploads/gamification/gamificationByProcess/process_136.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        'Acción gamificada enfocada en \'contenido_empresarial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONTENIDO_EMPRESARIAL', '136', 'null', 1, 8, 0,
        1, 200, 'CE-136', 0, 'fa fa-users'),
       (137, '/uploads/gamification/gamificationByProcess/process_137.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        'Acción gamificada enfocada en \'gestion_ecommerce\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '137', 'null', 1, 1, 0, 1, 387,
        'GE-137', 0, 'fa fa-bullhorn'),
       (138, '/uploads/gamification/gamificationByProcess/process_138.png', 'Evaluar entrega',
        'Evaluar entrega (detalle)',
        'Acción gamificada enfocada en \'multidepartamental\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'MULTIDEPARTAMENTAL', '138', 'null', 1, 10, 0, 1, 288,
        'M-138', 0, 'fa fa-hand-pointer-o'),
       (139, '/uploads/gamification/gamificationByProcess/process_139.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        'Acción gamificada enfocada en \'retroalimentacion_cliente\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'RETROALIMENTACION_CLIENTE', '139', 'null', 1, 5,
        0, 1, 82, 'RC-139', 0, 'fa fa-unlock-alt'),
       (140, '/uploads/gamification/gamificationByProcess/process_140.png', 'Borrar dato', 'Borrar dato (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '140', 'null', 1, 3, 0, 1, 482, 'GC-140',
        0, 'fa fa-users'),
       (141, '/uploads/gamification/gamificationByProcess/process_141.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '141', 'null', 1, 2, 0, 1, 282,
        'CE-141', 0, 'fa fa-heart'),
       (142, '/uploads/gamification/gamificationByProcess/process_142.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '142', 'null', 1, 6, 0,
        1, 46, 'IP-142', 0, 'fa fa-calendar-times-o'),
       (143, '/uploads/gamification/gamificationByProcess/process_143.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        'Acción gamificada enfocada en \'engagement_marketing\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'ENGAGEMENT_MARKETING', '143', 'null', 1, 4, 0, 1, 788,
        'EM-143', 0, 'fa fa-forumbee'),
       (144, '/uploads/gamification/gamificationByProcess/process_144.png', 'Marcar como favorita',
        'Marcar como favorita (detalle)',
        'Acción gamificada enfocada en \'conocimiento_empresa\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'CONOCIMIENTO_EMPRESA', '144', 'null', 1, 2, 0, 1, 927,
        'CE-144', 0, 'fa fa-check'),
       (145, '/uploads/gamification/gamificationByProcess/process_145.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        'Acción gamificada enfocada en \'interaccion_presencial\' para mejorar la experiencia empresa-cliente.',
        'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'INTERACCION_PRESENCIAL', '145', 'null', 1, 6, 0,
        1, 305, 'IP-145', 0, 'fa fa-forumbee'),
       (146, '/uploads/gamification/gamificationByProcess/process_146.png', 'Agregar preferencia',
        'Agregar preferencia (detalle)',
        'Acción gamificada enfocada en \'gestion_cliente\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_CLIENTE', '146', 'null', 1, 3, 0, 1, 227, 'GC-146',
        0, 'fa fa-briefcase'),
       (147, '/uploads/gamification/gamificationByProcess/process_147.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        'Acción gamificada enfocada en \'gestion_ecommerce\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'GESTION_ECOMMERCE', '147', 'null', 1, 1, 0, 1, 711,
        'GE-147', 0, 'fa fa-lightbulb-o'),
       (148, '/uploads/gamification/gamificationByProcess/process_148.png', 'Referir empresa',
        'Referir empresa (detalle)',
        'Acción gamificada enfocada en \'referidos\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'REFERIDOS', '148', 'null', 1, 7, 0, 1, 325, 'R-148', 0,
        'fa fa-calendar-times-o'),
       (149, '/uploads/gamification/gamificationByProcess/process_149.png', 'Crear publicación',
        'Crear publicación (detalle)',
        'Acción gamificada enfocada en \'promocion_marca\' para mejorar la experiencia empresa-cliente.', 'ACTIVE',
        NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'PROMOCION_MARCA', '149', 'null', 1, 11, 0, 1, 837,
        'PM-149', 0, 'fa fa-envelope-o'),
       (150, '/uploads/gamification/gamificationByProcess/process_150.png', 'Canjear puntos',
        'Canjear puntos (detalle)',
        'Acción gamificada enfocada en \'fidelizacion\' para mejorar la experiencia empresa-cliente.', 'ACTIVE', NULL,
        NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'FIDELIZACION', '150', 'null', 1, 9, 0, 1, 934, 'F-150', 0,
        'fa fa-bullhorn'),
       (151, '/uploads/gamification/gamificationByProcess/process_151.png', 'Envió puntos a otro cliente',
        'Envió puntos a otro cliente', 'Envió puntos a otro cliente.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-001', 0, 'fa fa-handshake'),
       (152, '/uploads/gamification/gamificationByProcess/process_152.png', 'Premió colaboración de un cliente',
        'Premió colaboración de un cliente', 'Premió colaboración de un cliente.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-002', 0,
        'fa fa-handshake'),
       (153, '/uploads/gamification/gamificationByProcess/process_153.png', 'Compartió experiencia útil con cliente',
        'Compartió experiencia útil con cliente', 'Compartió experiencia útil con cliente.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-003', 0,
        'fa fa-handshake'),
       (154, '/uploads/gamification/gamificationByProcess/process_154.png', 'Ayudó a resolver duda de otro usuario',
        'Ayudó a resolver duda de otro usuario', 'Ayudó a resolver duda de otro usuario.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-004', 0,
        'fa fa-handshake'),
       (155, '/uploads/gamification/gamificationByProcess/process_155.png', 'Participó con otro cliente en reto',
        'Participó con otro cliente en reto', 'Participó con otro cliente en reto.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-005', 0,
        'fa fa-handshake'),
       (156, '/uploads/gamification/gamificationByProcess/process_156.png', 'Compartió código con cliente',
        'Compartió código con cliente', 'Compartió código con cliente.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-006', 0, 'fa fa-handshake'),
       (157, '/uploads/gamification/gamificationByProcess/process_157.png', 'Compartió recursos útiles con cliente',
        'Compartió recursos útiles con cliente', 'Compartió recursos útiles con cliente.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-007', 0,
        'fa fa-handshake'),
       (158, '/uploads/gamification/gamificationByProcess/process_158.png', 'Reconoció públicamente a un cliente',
        'Reconoció públicamente a un cliente', 'Reconoció públicamente a un cliente.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-008', 0,
        'fa fa-handshake'),
       (159, '/uploads/gamification/gamificationByProcess/process_159.png', 'Donó puntos en actividad grupal',
        'Donó puntos en actividad grupal', 'Donó puntos en actividad grupal.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-009', 0,
        'fa fa-handshake'),
       (160, '/uploads/gamification/gamificationByProcess/process_160.png', 'Colaboró en encuesta compartida',
        'Colaboró en encuesta compartida', 'Colaboró en encuesta compartida.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-010', 0,
        'fa fa-handshake'),
       (161, '/uploads/gamification/gamificationByProcess/process_161.png', 'Recomendó producto a cliente',
        'Recomendó producto a cliente', 'Recomendó producto a cliente.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-011', 0, 'fa fa-handshake'),
       (162, '/uploads/gamification/gamificationByProcess/process_162.png', 'Invitó a otro cliente a MeetClic',
        'Invitó a otro cliente a MeetClic', 'Invitó a otro cliente a MeetClic.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 12, 0, 0, 1, 'CLIENTE_A_CLIENTE-012', 0,
        'fa fa-handshake'),
       (163, '/uploads/gamification/gamificationByProcess/process_163.png', 'Donó puntos a empresa',
        'Donó puntos a empresa', 'Donó puntos a empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1,
        'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-001', 0, 'fa fa fa-building-circle-arrow-right'),
       (164, '/uploads/gamification/gamificationByProcess/process_164.png', 'Participó en campaña solidaria',
        'Participó en campaña solidaria', 'Participó en campaña solidaria.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-002', 0,
        'fa fa fa-building-circle-arrow-right'),
       (165, '/uploads/gamification/gamificationByProcess/process_165.png', 'Valoró positivamente a empresa',
        'Valoró positivamente a empresa', 'Valoró positivamente a empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-003', 0,
        'fa fa fa-building-circle-arrow-right'),
       (166, '/uploads/gamification/gamificationByProcess/process_166.png', 'Comentó producto de empresa',
        'Comentó producto de empresa', 'Comentó producto de empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-004', 0,
        'fa fa fa-building-circle-arrow-right'),
       (167, '/uploads/gamification/gamificationByProcess/process_167.png', 'Compartió empresa en redes',
        'Compartió empresa en redes', 'Compartió empresa en redes.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-005', 0,
        'fa fa fa-building-circle-arrow-right'),
       (168, '/uploads/gamification/gamificationByProcess/process_168.png', 'Contribuyó en reto de empresa',
        'Contribuyó en reto de empresa', 'Contribuyó en reto de empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-006', 0,
        'fa fa fa-building-circle-arrow-right'),
       (169, '/uploads/gamification/gamificationByProcess/process_169.png', 'Subió contenido en campaña',
        'Subió contenido en campaña', 'Subió contenido en campaña.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-007', 0,
        'fa fa fa-building-circle-arrow-right'),
       (170, '/uploads/gamification/gamificationByProcess/process_170.png', 'Propuso mejora a empresa',
        'Propuso mejora a empresa', 'Propuso mejora a empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1,
        NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-008', 0,
        'fa fa fa-building-circle-arrow-right'),
       (171, '/uploads/gamification/gamificationByProcess/process_171.png', 'Apoyó evento de empresa',
        'Apoyó evento de empresa', 'Apoyó evento de empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1,
        NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-009', 0,
        'fa fa fa-building-circle-arrow-right'),
       (172, '/uploads/gamification/gamificationByProcess/process_172.png', 'Sugirió empresa a otros',
        'Sugirió empresa a otros', 'Sugirió empresa a otros.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1,
        NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-010', 0,
        'fa fa fa-building-circle-arrow-right'),
       (173, '/uploads/gamification/gamificationByProcess/process_173.png', 'Publicó testimonio de empresa',
        'Publicó testimonio de empresa', 'Publicó testimonio de empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-011', 0,
        'fa fa fa-building-circle-arrow-right'),
       (174, '/uploads/gamification/gamificationByProcess/process_174.png', 'Se unió a grupo de fidelización',
        'Se unió a grupo de fidelización', 'Se unió a grupo de fidelización.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 13, 0, 0, 1, 'CLIENTE_A_EMPRESA-012', 0,
        'fa fa fa-building-circle-arrow-right'),
       (175, '/uploads/gamification/gamificationByProcess/process_175.png', 'Premió fidelidad del cliente',
        'Premió fidelidad del cliente', 'Premió fidelidad del cliente.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-001', 0, 'fa fa-gift'),
       (176, '/uploads/gamification/gamificationByProcess/process_176.png', 'Bonificó al cliente por referidos',
        'Bonificó al cliente por referidos', 'Bonificó al cliente por referidos.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-002', 0, 'fa fa-gift'),
       (177, '/uploads/gamification/gamificationByProcess/process_177.png', 'Reconoció participación del cliente',
        'Reconoció participación del cliente', 'Reconoció participación del cliente.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-003', 0,
        'fa fa-gift'),
       (178, '/uploads/gamification/gamificationByProcess/process_178.png', 'Otorgó puntos por encuestas',
        'Otorgó puntos por encuestas', 'Otorgó puntos por encuestas.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-004', 0, 'fa fa-gift'),
       (179, '/uploads/gamification/gamificationByProcess/process_179.png', 'Bonificó compras recientes',
        'Bonificó compras recientes', 'Bonificó compras recientes.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-005', 0, 'fa fa-gift'),
       (180, '/uploads/gamification/gamificationByProcess/process_180.png', 'Premió feedback constructivo',
        'Premió feedback constructivo', 'Premió feedback constructivo.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-006', 0, 'fa fa-gift'),
       (181, '/uploads/gamification/gamificationByProcess/process_181.png', 'Activó bono de bienvenida',
        'Activó bono de bienvenida', 'Activó bono de bienvenida.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1,
        NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-007', 0, 'fa fa-gift'),
       (182, '/uploads/gamification/gamificationByProcess/process_182.png', 'Recompensó colaboración del cliente',
        'Recompensó colaboración del cliente', 'Recompensó colaboración del cliente.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-008', 0,
        'fa fa-gift'),
       (183, '/uploads/gamification/gamificationByProcess/process_183.png', 'Agradeció comentarios útiles',
        'Agradeció comentarios útiles', 'Agradeció comentarios útiles.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-009', 0, 'fa fa-gift'),
       (184, '/uploads/gamification/gamificationByProcess/process_184.png', 'Otorgó puntos por asistencia a evento',
        'Otorgó puntos por asistencia a evento', 'Otorgó puntos por asistencia a evento.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-010', 0,
        'fa fa-gift'),
       (185, '/uploads/gamification/gamificationByProcess/process_185.png', 'Premió uso de cupones',
        'Premió uso de cupones', 'Premió uso de cupones.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1,
        'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-011', 0, 'fa fa-gift'),
       (186, '/uploads/gamification/gamificationByProcess/process_186.png', 'Activó logro especial',
        'Activó logro especial', 'Activó logro especial.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL, 1, NULL, 1,
        'nothing', '0', 'null', 1, 14, 0, 0, 1, 'EMPRESA_A_CLIENTE-012', 0, 'fa fa-gift'),
       (187, '/uploads/gamification/gamificationByProcess/process_187.png', 'Compartió puntos por alianza',
        'Compartió puntos por alianza', 'Compartió puntos por alianza.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE',
        NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-001', 0, 'fa fa-people-arrows'),
       (188, '/uploads/gamification/gamificationByProcess/process_188.png', 'Apoyó campaña de empresa aliada',
        'Apoyó campaña de empresa aliada', 'Apoyó campaña de empresa aliada.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-002', 0,
        'fa fa-people-arrows'),
       (189, '/uploads/gamification/gamificationByProcess/process_189.png', 'Reconoció colaboración interempresarial',
        'Reconoció colaboración interempresarial', 'Reconoció colaboración interempresarial.', 'ACTIVE', NULL, NULL,
        'NONE', NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-003', 0,
        'fa fa-people-arrows'),
       (190, '/uploads/gamification/gamificationByProcess/process_190.png', 'Premió a otra empresa por sinergia',
        'Premió a otra empresa por sinergia', 'Premió a otra empresa por sinergia.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-004', 0,
        'fa fa-people-arrows'),
       (191, '/uploads/gamification/gamificationByProcess/process_191.png', 'Recomendó productos de empresa aliada',
        'Recomendó productos de empresa aliada', 'Recomendó productos de empresa aliada.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-005', 0,
        'fa fa-people-arrows'),
       (192, '/uploads/gamification/gamificationByProcess/process_192.png', 'Participó en reto entre empresas',
        'Participó en reto entre empresas', 'Participó en reto entre empresas.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-006', 0,
        'fa fa-people-arrows'),
       (193, '/uploads/gamification/gamificationByProcess/process_193.png', 'Contribuyó a promoción conjunta',
        'Contribuyó a promoción conjunta', 'Contribuyó a promoción conjunta.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-007', 0,
        'fa fa-people-arrows'),
       (194, '/uploads/gamification/gamificationByProcess/process_194.png', 'Cedió cupón entre empresas',
        'Cedió cupón entre empresas', 'Cedió cupón entre empresas.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-008', 0, 'fa fa-people-arrows'),
       (195, '/uploads/gamification/gamificationByProcess/process_195.png', 'Validó experiencia de otra empresa',
        'Validó experiencia de otra empresa', 'Validó experiencia de otra empresa.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-009', 0,
        'fa fa-people-arrows'),
       (196, '/uploads/gamification/gamificationByProcess/process_196.png', 'Impulsó visibilidad cruzada',
        'Impulsó visibilidad cruzada', 'Impulsó visibilidad cruzada.', 'ACTIVE', NULL, NULL, 'NONE', NULL, 'NONE', NULL,
        1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-010', 0, 'fa fa-people-arrows'),
       (197, '/uploads/gamification/gamificationByProcess/process_197.png', 'Participó en evento interempresarial',
        'Participó en evento interempresarial', 'Participó en evento interempresarial.', 'ACTIVE', NULL, NULL, 'NONE',
        NULL, 'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-011', 0,
        'fa fa-people-arrows'),
       (198, '/uploads/gamification/gamificationByProcess/process_198.png', 'Se unió a red de empresas aliadas',
        'Se unió a red de empresas aliadas', 'Se unió a red de empresas aliadas.', 'ACTIVE', NULL, NULL, 'NONE', NULL,
        'NONE', NULL, 1, NULL, 1, 'nothing', '0', 'null', 1, 15, 0, 0, 1, 'EMPRESA_A_EMPRESA-012', 0,
        'fa fa-people-arrows');

INSERT INTO gamification_by_points
VALUES (1.0, 1.0, 150.0);
INSERT INTO gamification_by_points
VALUES (2.0, 2.0, 50.0);
INSERT INTO gamification_by_points
VALUES (3.0, 3.0, 150.0);
INSERT INTO gamification_by_points
VALUES (4.0, 4.0, 200.0);
INSERT INTO gamification_by_points
VALUES (5.0, 5.0, 200.0);
INSERT INTO gamification_by_points
VALUES (6.0, 6.0, 50.0);
INSERT INTO gamification_by_points
VALUES (7.0, 7.0, 200.0);
INSERT INTO gamification_by_points
VALUES (8.0, 8.0, 50.0);
INSERT INTO gamification_by_points
VALUES (9.0, 9.0, 50.0);
INSERT INTO gamification_by_points
VALUES (10.0, 10.0, 200.0);
INSERT INTO gamification_by_points
VALUES (11.0, 11.0, 300.0);
INSERT INTO gamification_by_points
VALUES (12.0, 12.0, 100.0);
INSERT INTO gamification_by_points
VALUES (13.0, 13.0, 100.0);
INSERT INTO gamification_by_points
VALUES (14.0, 14.0, 100.0);
INSERT INTO gamification_by_points
VALUES (15.0, 15.0, 50.0);
INSERT INTO gamification_by_points
VALUES (16.0, 16.0, 250.0);
INSERT INTO gamification_by_points
VALUES (17.0, 17.0, 250.0);
INSERT INTO gamification_by_points
VALUES (18.0, 18.0, 300.0);
INSERT INTO gamification_by_points
VALUES (19.0, 19.0, 150.0);
INSERT INTO gamification_by_points
VALUES (20.0, 20.0, 300.0);
INSERT INTO gamification_by_points
VALUES (21.0, 21.0, 200.0);
INSERT INTO gamification_by_points
VALUES (22.0, 22.0, 100.0);
INSERT INTO gamification_by_points
VALUES (23.0, 23.0, 200.0);
INSERT INTO gamification_by_points
VALUES (24.0, 24.0, 250.0);
INSERT INTO gamification_by_points
VALUES (25.0, 25.0, 200.0);
INSERT INTO gamification_by_points
VALUES (26.0, 26.0, 250.0);
INSERT INTO gamification_by_points
VALUES (27.0, 27.0, 300.0);
INSERT INTO gamification_by_points
VALUES (28.0, 28.0, 100.0);
INSERT INTO gamification_by_points
VALUES (29.0, 29.0, 50.0);
INSERT INTO gamification_by_points
VALUES (30.0, 30.0, 300.0);
INSERT INTO gamification_by_points
VALUES (31.0, 31.0, 300.0);
INSERT INTO gamification_by_points
VALUES (32.0, 32.0, 50.0);
INSERT INTO gamification_by_points
VALUES (33.0, 33.0, 200.0);
INSERT INTO gamification_by_points
VALUES (34.0, 34.0, 200.0);
INSERT INTO gamification_by_points
VALUES (35.0, 35.0, 150.0);
INSERT INTO gamification_by_points
VALUES (36.0, 36.0, 250.0);
INSERT INTO gamification_by_points
VALUES (37.0, 37.0, 150.0);
INSERT INTO gamification_by_points
VALUES (38.0, 38.0, 150.0);
INSERT INTO gamification_by_points
VALUES (39.0, 39.0, 150.0);
INSERT INTO gamification_by_points
VALUES (40.0, 40.0, 150.0);
INSERT INTO gamification_by_points
VALUES (41.0, 41.0, 250.0);
INSERT INTO gamification_by_points
VALUES (42.0, 42.0, 100.0);
INSERT INTO gamification_by_points
VALUES (43.0, 43.0, 250.0);
INSERT INTO gamification_by_points
VALUES (44.0, 44.0, 250.0);
INSERT INTO gamification_by_points
VALUES (45.0, 45.0, 50.0);
INSERT INTO gamification_by_points
VALUES (46.0, 46.0, 150.0);
INSERT INTO gamification_by_points
VALUES (47.0, 47.0, 50.0);
INSERT INTO gamification_by_points
VALUES (48.0, 48.0, 100.0);
INSERT INTO gamification_by_points
VALUES (49.0, 49.0, 200.0);
INSERT INTO gamification_by_points
VALUES (50.0, 50.0, 300.0);
INSERT INTO gamification_by_points
VALUES (51.0, 51.0, 150.0);
INSERT INTO gamification_by_points
VALUES (52.0, 52.0, 300.0);
INSERT INTO gamification_by_points
VALUES (53.0, 53.0, 50.0);
INSERT INTO gamification_by_points
VALUES (54.0, 54.0, 150.0);
INSERT INTO gamification_by_points
VALUES (55.0, 55.0, 200.0);
INSERT INTO gamification_by_points
VALUES (56.0, 56.0, 250.0);
INSERT INTO gamification_by_points
VALUES (57.0, 57.0, 150.0);
INSERT INTO gamification_by_points
VALUES (58.0, 58.0, 200.0);
INSERT INTO gamification_by_points
VALUES (59.0, 59.0, 300.0);
INSERT INTO gamification_by_points
VALUES (60.0, 60.0, 150.0);
INSERT INTO gamification_by_points
VALUES (61.0, 61.0, 300.0);
INSERT INTO gamification_by_points
VALUES (62.0, 62.0, 300.0);
INSERT INTO gamification_by_points
VALUES (63.0, 63.0, 50.0);
INSERT INTO gamification_by_points
VALUES (64.0, 64.0, 300.0);
INSERT INTO gamification_by_points
VALUES (65.0, 65.0, 50.0);
INSERT INTO gamification_by_points
VALUES (66.0, 66.0, 300.0);
INSERT INTO gamification_by_points
VALUES (67.0, 67.0, 200.0);
INSERT INTO gamification_by_points
VALUES (68.0, 68.0, 150.0);
INSERT INTO gamification_by_points
VALUES (69.0, 69.0, 50.0);
INSERT INTO gamification_by_points
VALUES (70.0, 70.0, 150.0);
INSERT INTO gamification_by_points
VALUES (71.0, 71.0, 200.0);
INSERT INTO gamification_by_points
VALUES (72.0, 72.0, 100.0);
INSERT INTO gamification_by_points
VALUES (73.0, 73.0, 150.0);
INSERT INTO gamification_by_points
VALUES (74.0, 74.0, 300.0);
INSERT INTO gamification_by_points
VALUES (75.0, 75.0, 300.0);
INSERT INTO gamification_by_points
VALUES (76.0, 76.0, 300.0);
INSERT INTO gamification_by_points
VALUES (77.0, 77.0, 50.0);
INSERT INTO gamification_by_points
VALUES (78.0, 78.0, 100.0);
INSERT INTO gamification_by_points
VALUES (79.0, 79.0, 50.0);
INSERT INTO gamification_by_points
VALUES (80.0, 80.0, 150.0);
INSERT INTO gamification_by_points
VALUES (81.0, 81.0, 50.0);
INSERT INTO gamification_by_points
VALUES (82.0, 82.0, 250.0);
INSERT INTO gamification_by_points
VALUES (83.0, 83.0, 250.0);
INSERT INTO gamification_by_points
VALUES (84.0, 84.0, 150.0);
INSERT INTO gamification_by_points
VALUES (85.0, 85.0, 50.0);
INSERT INTO gamification_by_points
VALUES (86.0, 86.0, 250.0);
INSERT INTO gamification_by_points
VALUES (87.0, 87.0, 50.0);
INSERT INTO gamification_by_points
VALUES (88.0, 88.0, 200.0);
INSERT INTO gamification_by_points
VALUES (89.0, 89.0, 150.0);
INSERT INTO gamification_by_points
VALUES (90.0, 90.0, 300.0);
INSERT INTO gamification_by_points
VALUES (91.0, 91.0, 100.0);
INSERT INTO gamification_by_points
VALUES (92.0, 92.0, 200.0);
INSERT INTO gamification_by_points
VALUES (93.0, 93.0, 150.0);
INSERT INTO gamification_by_points
VALUES (94.0, 94.0, 100.0);
INSERT INTO gamification_by_points
VALUES (95.0, 95.0, 50.0);
INSERT INTO gamification_by_points
VALUES (96.0, 96.0, 150.0);
INSERT INTO gamification_by_points
VALUES (97.0, 97.0, 100.0);
INSERT INTO gamification_by_points
VALUES (98.0, 98.0, 100.0);
INSERT INTO gamification_by_points
VALUES (99.0, 99.0, 300.0);
INSERT INTO gamification_by_points
VALUES (100.0, 100.0, 50.0);
INSERT INTO gamification_by_points
VALUES (101.0, 101.0, 200.0);
INSERT INTO gamification_by_points
VALUES (102.0, 102.0, 100.0);
INSERT INTO gamification_by_points
VALUES (103.0, 103.0, 50.0);
INSERT INTO gamification_by_points
VALUES (104.0, 104.0, 250.0);
INSERT INTO gamification_by_points
VALUES (105.0, 105.0, 250.0);
INSERT INTO gamification_by_points
VALUES (106.0, 106.0, 150.0);
INSERT INTO gamification_by_points
VALUES (107.0, 107.0, 200.0);
INSERT INTO gamification_by_points
VALUES (108.0, 108.0, 50.0);
INSERT INTO gamification_by_points
VALUES (109.0, 109.0, 150.0);
INSERT INTO gamification_by_points
VALUES (110.0, 110.0, 200.0);
INSERT INTO gamification_by_points
VALUES (111.0, 111.0, 200.0);
INSERT INTO gamification_by_points
VALUES (112.0, 112.0, 150.0);
INSERT INTO gamification_by_points
VALUES (113.0, 113.0, 250.0);
INSERT INTO gamification_by_points
VALUES (114.0, 114.0, 300.0);
INSERT INTO gamification_by_points
VALUES (115.0, 115.0, 250.0);
INSERT INTO gamification_by_points
VALUES (116.0, 116.0, 250.0);
INSERT INTO gamification_by_points
VALUES (117.0, 117.0, 200.0);
INSERT INTO gamification_by_points
VALUES (118.0, 118.0, 300.0);
INSERT INTO gamification_by_points
VALUES (119.0, 119.0, 250.0);
INSERT INTO gamification_by_points
VALUES (120.0, 120.0, 100.0);
INSERT INTO gamification_by_points
VALUES (121.0, 121.0, 200.0);
INSERT INTO gamification_by_points
VALUES (122.0, 122.0, 150.0);
INSERT INTO gamification_by_points
VALUES (123.0, 123.0, 50.0);
INSERT INTO gamification_by_points
VALUES (124.0, 124.0, 300.0);
INSERT INTO gamification_by_points
VALUES (125.0, 125.0, 300.0);
INSERT INTO gamification_by_points
VALUES (126.0, 126.0, 300.0);
INSERT INTO gamification_by_points
VALUES (127.0, 127.0, 50.0);
INSERT INTO gamification_by_points
VALUES (128.0, 128.0, 250.0);
INSERT INTO gamification_by_points
VALUES (129.0, 129.0, 300.0);
INSERT INTO gamification_by_points
VALUES (130.0, 130.0, 300.0);
INSERT INTO gamification_by_points
VALUES (131.0, 131.0, 50.0);
INSERT INTO gamification_by_points
VALUES (132.0, 132.0, 300.0);
INSERT INTO gamification_by_points
VALUES (133.0, 133.0, 250.0);
INSERT INTO gamification_by_points
VALUES (134.0, 134.0, 150.0);
INSERT INTO gamification_by_points
VALUES (135.0, 135.0, 50.0);
INSERT INTO gamification_by_points
VALUES (136.0, 136.0, 50.0);
INSERT INTO gamification_by_points
VALUES (137.0, 137.0, 100.0);
INSERT INTO gamification_by_points
VALUES (138.0, 138.0, 50.0);
INSERT INTO gamification_by_points
VALUES (139.0, 139.0, 150.0);
INSERT INTO gamification_by_points
VALUES (140.0, 140.0, 50.0);
INSERT INTO gamification_by_points
VALUES (141.0, 141.0, 200.0);
INSERT INTO gamification_by_points
VALUES (142.0, 142.0, 50.0);
INSERT INTO gamification_by_points
VALUES (143.0, 143.0, 100.0);
INSERT INTO gamification_by_points
VALUES (144.0, 144.0, 150.0);
INSERT INTO gamification_by_points
VALUES (145.0, 145.0, 100.0);
INSERT INTO gamification_by_points
VALUES (146.0, 146.0, 250.0);
INSERT INTO gamification_by_points
VALUES (147.0, 147.0, 150.0);
INSERT INTO gamification_by_points
VALUES (148.0, 148.0, 150.0);
INSERT INTO gamification_by_points
VALUES (149.0, 149.0, 150.0);
INSERT INTO gamification_by_points
VALUES (150.0, 150.0, 150.0);

INSERT INTO gamification_by_points
VALUES (151, 151, 100.0),
       (152, 152, 100.0),
       (153, 153, 100.0),
       (154, 154, 100.0),
       (155, 155, 100.0),
       (156, 156, 100.0),
       (157, 157, 100.0),
       (158, 158, 100.0),
       (159, 159, 100.0),
       (160, 160, 100.0),
       (161, 161, 100.0),
       (162, 162, 100.0),
       (163, 163, 100.0),
       (164, 164, 100.0),
       (165, 165, 100.0),
       (166, 166, 100.0),
       (167, 167, 100.0),
       (168, 168, 100.0),
       (169, 169, 100.0),
       (170, 170, 100.0),
       (171, 171, 100.0),
       (172, 172, 100.0),
       (173, 173, 100.0),
       (174, 174, 100.0),
       (175, 175, 100.0),
       (176, 176, 100.0),
       (177, 177, 100.0),
       (178, 178, 100.0),
       (179, 179, 100.0),
       (180, 180, 100.0),
       (181, 181, 100.0),
       (182, 182, 100.0),
       (183, 183, 100.0),
       (184, 184, 100.0),
       (185, 185, 100.0),
       (186, 186, 100.0),
       (187, 187, 100.0),
       (188, 188, 100.0),
       (189, 189, 100.0),
       (190, 190, 100.0),
       (191, 191, 100.0),
       (192, 192, 100.0),
       (193, 193, 100.0),
       (194, 194, 100.0),
       (195, 195, 100.0),
       (196, 196, 100.0),
       (197, 197, 100.0),
       (198, 198, 100.0);

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
