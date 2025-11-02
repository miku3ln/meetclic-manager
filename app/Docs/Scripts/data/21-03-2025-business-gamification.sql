SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


INSERT INTO `business_by_gamification` (`id`, `gamification_id`, `business_id`, `allow_exchange`,
                                        `allow_exchange_business`, `state`)
VALUES (1, 1, 1, 0, 0, 'ACTIVE');

INSERT INTO `gamification` (`id`, `value`, `description`, `value_unit`, `state`, `maximum_exchange`)
VALUES (1, 'Configuracion Inicial Gamificacion', 'Configuracion', 0, 'ACTIVE', 0);

INSERT INTO gamification_by_process
VALUES (1, '/uploads/gamification/gamificationByProcess/process_1.png', 'Ver producto', 'Ver producto (detalle)',
        "Acción relacionada con la tarea 'Ver producto' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '1', 'null', 1, 1, 0, 1, 264, 'GE-001');
INSERT INTO gamification_by_process
VALUES (2, '/uploads/gamification/gamificationByProcess/process_2.png', 'Compartir producto',
        'Compartir producto (detalle)',
        "Acción relacionada con la tarea 'Compartir producto' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '2', 'null', 2, 1, 0, 1, 192, 'GE-002');
INSERT INTO gamification_by_process
VALUES (3, '/uploads/gamification/gamificationByProcess/process_3.png', 'Like producto', 'Like producto (detalle)',
        "Acción relacionada con la tarea 'Like producto' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '3', 'null', 3, 1, 0, 1, 440, 'GE-003');
INSERT INTO gamification_by_process
VALUES (4, '/uploads/gamification/gamificationByProcess/process_4.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        "Acción relacionada con la tarea 'Agregar al carrito' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '4', 'null', 4, 1, 0, 1, 813, 'GE-004');
INSERT INTO gamification_by_process
VALUES (5, '/uploads/gamification/gamificationByProcess/process_5.png', 'Finalizar compra',
        'Finalizar compra (detalle)',
        "Acción relacionada con la tarea 'Finalizar compra' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '5', 'null', 5, 1, 0, 1, 356, 'GE-005');
INSERT INTO gamification_by_process
VALUES (6, '/uploads/gamification/gamificationByProcess/process_6.png', 'Escribir reseña', 'Escribir reseña (detalle)',
        "Acción relacionada con la tarea 'Escribir reseña' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '6', 'null', 6, 1, 0, 1, 77, 'GE-006');
INSERT INTO gamification_by_process
VALUES (7, '/uploads/gamification/gamificationByProcess/process_7.png', 'Usar cupón', 'Usar cupón (detalle)',
        "Acción relacionada con la tarea 'Usar cupón' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '7', 'null', 7, 1, 0, 1, 301, 'GE-007');
INSERT INTO gamification_by_process
VALUES (8, '/uploads/gamification/gamificationByProcess/process_8.png', 'Reclamar devolución',
        'Reclamar devolución (detalle)',
        "Acción relacionada con la tarea 'Reclamar devolución' en la categoría 'GESTION_ECOMMERCE'.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '8', 'null', 8, 1, 0, 1, 219, 'GE-008');
INSERT INTO gamification_by_process
VALUES (9, '/uploads/gamification/gamificationByProcess/process_9.png', 'Registrarse en empresa',
        'Registrarse en empresa (detalle)',
        "Acción relacionada con la tarea 'Registrarse en empresa' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '9', 'null', 9, 2, 0, 1, 535, 'CE-009');
INSERT INTO gamification_by_process
VALUES (10, '/uploads/gamification/gamificationByProcess/process_10.png', 'Ver perfil de empresa',
        'Ver perfil de empresa (detalle)',
        "Acción relacionada con la tarea 'Ver perfil de empresa' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '10', 'null', 10, 2, 0, 1, 661, 'CE-010');
INSERT INTO gamification_by_process
VALUES (11, '/uploads/gamification/gamificationByProcess/process_11.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        "Acción relacionada con la tarea 'Compartir empresa' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '11', 'null', 11, 2, 0, 1, 238, 'CE-011');
INSERT INTO gamification_by_process
VALUES (12, '/uploads/gamification/gamificationByProcess/process_12.png', 'Seguir empresa', 'Seguir empresa (detalle)',
        "Acción relacionada con la tarea 'Seguir empresa' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '12', 'null', 12, 2, 0, 1, 411, 'CE-012');
INSERT INTO gamification_by_process
VALUES (13, '/uploads/gamification/gamificationByProcess/process_13.png', 'Marcar como favorita',
        'Marcar como favorita (detalle)',
        "Acción relacionada con la tarea 'Marcar como favorita' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '13', 'null', 13, 2, 0, 1, 90, 'CE-013');
INSERT INTO gamification_by_process
VALUES (14, '/uploads/gamification/gamificationByProcess/process_14.png', 'Visitar enlace web',
        'Visitar enlace web (detalle)',
        "Acción relacionada con la tarea 'Visitar enlace web' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '14', 'null', 14, 2, 0, 1, 906, 'CE-014');
INSERT INTO gamification_by_process
VALUES (15, '/uploads/gamification/gamificationByProcess/process_15.png', 'Calificar empresa',
        'Calificar empresa (detalle)',
        "Acción relacionada con la tarea 'Calificar empresa' en la categoría 'CONOCIMIENTO_EMPRESA'.", 'ACTIVE', 1,
        'CONOCIMIENTO_EMPRESA', '15', 'null', 15, 2, 0, 1, 994, 'CE-015');
INSERT INTO gamification_by_process
VALUES (16, '/uploads/gamification/gamificationByProcess/process_16.png', 'Actualizar perfil',
        'Actualizar perfil (detalle)',
        "Acción relacionada con la tarea 'Actualizar perfil' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '16', 'null', 16, 3, 0, 1, 363, 'GC-016');
INSERT INTO gamification_by_process
VALUES (17, '/uploads/gamification/gamificationByProcess/process_17.png', 'Actualizar dirección',
        'Actualizar dirección (detalle)',
        "Acción relacionada con la tarea 'Actualizar dirección' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '17', 'null', 17, 3, 0, 1, 846, 'GC-017');
INSERT INTO gamification_by_process
VALUES (18, '/uploads/gamification/gamificationByProcess/process_18.png', 'Actualizar número',
        'Actualizar número (detalle)',
        "Acción relacionada con la tarea 'Actualizar número' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '18', 'null', 18, 3, 0, 1, 163, 'GC-018');
INSERT INTO gamification_by_process
VALUES (19, '/uploads/gamification/gamificationByProcess/process_19.png', 'Subir foto', 'Subir foto (detalle)',
        "Acción relacionada con la tarea 'Subir foto' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '19', 'null', 19, 3, 0, 1, 305, 'GC-019');
INSERT INTO gamification_by_process
VALUES (20, '/uploads/gamification/gamificationByProcess/process_20.png', 'Agregar preferencia',
        'Agregar preferencia (detalle)',
        "Acción relacionada con la tarea 'Agregar preferencia' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '20', 'null', 20, 3, 0, 1, 942, 'GC-020');
INSERT INTO gamification_by_process
VALUES (21, '/uploads/gamification/gamificationByProcess/process_21.png', 'Borrar dato', 'Borrar dato (detalle)',
        "Acción relacionada con la tarea 'Borrar dato' en la categoría 'GESTION_CLIENTE'.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '21', 'null', 21, 3, 0, 1, 409, 'GC-021');
INSERT INTO gamification_by_process
VALUES (22, '/uploads/gamification/gamificationByProcess/process_22.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        "Acción relacionada con la tarea 'Responder encuesta' en la categoría 'ENGAGEMENT_MARKETING'.", 'ACTIVE', 1,
        'ENGAGEMENT_MARKETING', '22', 'null', 22, 4, 0, 1, 374, 'EM-022');
INSERT INTO gamification_by_process
VALUES (23, '/uploads/gamification/gamificationByProcess/process_23.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        "Acción relacionada con la tarea 'Participar en campaña' en la categoría 'ENGAGEMENT_MARKETING'.", 'ACTIVE', 1,
        'ENGAGEMENT_MARKETING', '23', 'null', 23, 4, 0, 1, 761, 'EM-023');
INSERT INTO gamification_by_process
VALUES (24, '/uploads/gamification/gamificationByProcess/process_24.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción relacionada con la tarea 'Reaccionar a banner' en la categoría 'ENGAGEMENT_MARKETING'.", 'ACTIVE', 1,
        'ENGAGEMENT_MARKETING', '24', 'null', 24, 4, 0, 1, 972, 'EM-024');
INSERT INTO gamification_by_process
VALUES (25, '/uploads/gamification/gamificationByProcess/process_25.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        "Acción relacionada con la tarea 'Compartir sorteo' en la categoría 'ENGAGEMENT_MARKETING'.", 'ACTIVE', 1,
        'ENGAGEMENT_MARKETING', '25', 'null', 25, 4, 0, 1, 726, 'EM-025');
INSERT INTO gamification_by_process
VALUES (26, '/uploads/gamification/gamificationByProcess/process_26.png', 'Unirse a evento de marca',
        'Unirse a evento de marca (detalle)',
        "Acción relacionada con la tarea 'Unirse a evento de marca' en la categoría 'ENGAGEMENT_MARKETING'.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '26', 'null', 26, 4, 0, 1, 863, 'EM-026');
INSERT INTO gamification_by_process
VALUES (27, '/uploads/gamification/gamificationByProcess/process_27.png', 'Enviar queja', 'Enviar queja (detalle)',
        "Acción relacionada con la tarea 'Enviar queja' en la categoría 'RETROALIMENTACION_CLIENTE'.", 'ACTIVE', 1,
        'RETROALIMENTACION_CLIENTE', '27', 'null', 27, 5, 0, 1, 597, 'RC-027');
INSERT INTO gamification_by_process
VALUES (28, '/uploads/gamification/gamificationByProcess/process_28.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        "Acción relacionada con la tarea 'Votar sugerencia' en la categoría 'RETROALIMENTACION_CLIENTE'.", 'ACTIVE', 1,
        'RETROALIMENTACION_CLIENTE', '28', 'null', 28, 5, 0, 1, 794, 'RC-028');
INSERT INTO gamification_by_process
VALUES (29, '/uploads/gamification/gamificationByProcess/process_29.png', 'Calificar compra',
        'Calificar compra (detalle)',
        "Acción relacionada con la tarea 'Calificar compra' en la categoría 'RETROALIMENTACION_CLIENTE'.", 'ACTIVE', 1,
        'RETROALIMENTACION_CLIENTE', '29', 'null', 29, 5, 0, 1, 485, 'RC-029');
INSERT INTO gamification_by_process
VALUES (30, '/uploads/gamification/gamificationByProcess/process_30.png', 'Dejar retroalimentación',
        'Dejar retroalimentación (detalle)',
        "Acción relacionada con la tarea 'Dejar retroalimentación' en la categoría 'RETROALIMENTACION_CLIENTE'.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '30', 'null', 30, 5, 0, 1, 506, 'RC-030');
INSERT INTO gamification_by_process
VALUES (31, '/uploads/gamification/gamificationByProcess/process_31.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        "Acción relacionada con la tarea 'Hacer check-in' en la categoría 'INTERACCION_PRESENCIAL'.", 'ACTIVE', 1,
        'INTERACCION_PRESENCIAL', '31', 'null', 31, 6, 0, 1, 452, 'IP-031');
INSERT INTO gamification_by_process
VALUES (32, '/uploads/gamification/gamificationByProcess/process_32.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        "Acción relacionada con la tarea 'Escanear código QR' en la categoría 'INTERACCION_PRESENCIAL'.", 'ACTIVE', 1,
        'INTERACCION_PRESENCIAL', '32', 'null', 32, 6, 0, 1, 602, 'IP-032');
INSERT INTO gamification_by_process
VALUES (33, '/uploads/gamification/gamificationByProcess/process_33.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción relacionada con la tarea 'Participar en evento físico' en la categoría 'INTERACCION_PRESENCIAL'.",
        'ACTIVE', 1, 'INTERACCION_PRESENCIAL', '33', 'null', 33, 6, 0, 1, 611, 'IP-033');
INSERT INTO gamification_by_process
VALUES (34, '/uploads/gamification/gamificationByProcess/process_34.png', 'Solicitar visita presencial',
        'Solicitar visita presencial (detalle)',
        "Acción relacionada con la tarea 'Solicitar visita presencial' en la categoría 'INTERACCION_PRESENCIAL'.",
        'ACTIVE', 1, 'INTERACCION_PRESENCIAL', '34', 'null', 34, 6, 0, 1, 534, 'IP-034');
INSERT INTO gamification_by_process
VALUES (35, '/uploads/gamification/gamificationByProcess/process_35.png', 'Referir producto',
        'Referir producto (detalle)', "Acción relacionada con la tarea 'Referir producto' en la categoría 'REFERIDOS'.",
        'ACTIVE', 1, 'REFERIDOS', '35', 'null', 35, 7, 0, 1, 179, 'R-035');
INSERT INTO gamification_by_process
VALUES (36, '/uploads/gamification/gamificationByProcess/process_36.png', 'Referir empresa',
        'Referir empresa (detalle)', "Acción relacionada con la tarea 'Referir empresa' en la categoría 'REFERIDOS'.",
        'ACTIVE', 1, 'REFERIDOS', '36', 'null', 36, 7, 0, 1, 231, 'R-036');
INSERT INTO gamification_by_process
VALUES (37, '/uploads/gamification/gamificationByProcess/process_37.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        "Acción relacionada con la tarea 'Compartir código de invitación' en la categoría 'REFERIDOS'.", 'ACTIVE', 1,
        'REFERIDOS', '37', 'null', 37, 7, 0, 1, 84, 'R-037');
INSERT INTO gamification_by_process
VALUES (38, '/uploads/gamification/gamificationByProcess/process_38.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción relacionada con la tarea 'Registrar invitado' en la categoría 'REFERIDOS'.", 'ACTIVE', 1, 'REFERIDOS',
        '38', 'null', 38, 7, 0, 1, 40, 'R-038');
INSERT INTO gamification_by_process
VALUES (39, '/uploads/gamification/gamificationByProcess/process_39.png', 'Leer noticia', 'Leer noticia (detalle)',
        "Acción relacionada con la tarea 'Leer noticia' en la categoría 'CONTENIDO_EMPRESARIAL'.", 'ACTIVE', 1,
        'CONTENIDO_EMPRESARIAL', '39', 'null', 39, 8, 0, 1, 165, 'CE-039');
INSERT INTO gamification_by_process
VALUES (40, '/uploads/gamification/gamificationByProcess/process_40.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        "Acción relacionada con la tarea 'Compartir noticia' en la categoría 'CONTENIDO_EMPRESARIAL'.", 'ACTIVE', 1,
        'CONTENIDO_EMPRESARIAL', '40', 'null', 40, 8, 0, 1, 646, 'CE-040');
INSERT INTO gamification_by_process
VALUES (41, '/uploads/gamification/gamificationByProcess/process_41.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        "Acción relacionada con la tarea 'Comentar artículo' en la categoría 'CONTENIDO_EMPRESARIAL'.", 'ACTIVE', 1,
        'CONTENIDO_EMPRESARIAL', '41', 'null', 41, 8, 0, 1, 646, 'CE-041');
INSERT INTO gamification_by_process
VALUES (42, '/uploads/gamification/gamificationByProcess/process_42.png', 'Guardar noticia',
        'Guardar noticia (detalle)',
        "Acción relacionada con la tarea 'Guardar noticia' en la categoría 'CONTENIDO_EMPRESARIAL'.", 'ACTIVE', 1,
        'CONTENIDO_EMPRESARIAL', '42', 'null', 42, 8, 0, 1, 458, 'CE-042');
INSERT INTO gamification_by_process
VALUES (43, '/uploads/gamification/gamificationByProcess/process_43.png', 'Canjear puntos', 'Canjear puntos (detalle)',
        "Acción relacionada con la tarea 'Canjear puntos' en la categoría 'FIDELIZACION'.", 'ACTIVE', 1, 'FIDELIZACION',
        '43', 'null', 43, 9, 0, 1, 336, 'F-043');
INSERT INTO gamification_by_process
VALUES (44, '/uploads/gamification/gamificationByProcess/process_44.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        "Acción relacionada con la tarea 'Logro desbloqueado' en la categoría 'FIDELIZACION'.", 'ACTIVE', 1,
        'FIDELIZACION', '44', 'null', 44, 9, 0, 1, 70, 'F-044');
INSERT INTO gamification_by_process
VALUES (45, '/uploads/gamification/gamificationByProcess/process_45.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        "Acción relacionada con la tarea 'Completar desafío diario' en la categoría 'FIDELIZACION'.", 'ACTIVE', 1,
        'FIDELIZACION', '45', 'null', 45, 9, 0, 1, 192, 'F-045');
INSERT INTO gamification_by_process
VALUES (46, '/uploads/gamification/gamificationByProcess/process_46.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        "Acción relacionada con la tarea 'Completar reto mensual' en la categoría 'FIDELIZACION'.", 'ACTIVE', 1,
        'FIDELIZACION', '46', 'null', 46, 9, 0, 1, 685, 'F-046');
INSERT INTO gamification_by_process
VALUES (47, '/uploads/gamification/gamificationByProcess/process_47.png', 'Calificar atención',
        'Calificar atención (detalle)',
        "Acción relacionada con la tarea 'Calificar atención' en la categoría 'MULTIDEPARTAMENTAL'.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '47', 'null', 47, 10, 0, 1, 58, 'M-047');
INSERT INTO gamification_by_process
VALUES (48, '/uploads/gamification/gamificationByProcess/process_48.png', 'Evaluar entrega',
        'Evaluar entrega (detalle)',
        "Acción relacionada con la tarea 'Evaluar entrega' en la categoría 'MULTIDEPARTAMENTAL'.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '48', 'null', 48, 10, 0, 1, 312, 'M-048');
INSERT INTO gamification_by_process
VALUES (49, '/uploads/gamification/gamificationByProcess/process_49.png', 'Responder encuesta de soporte',
        'Responder encuesta de soporte (detalle)',
        "Acción relacionada con la tarea 'Responder encuesta de soporte' en la categoría 'MULTIDEPARTAMENTAL'.",
        'ACTIVE', 1, 'MULTIDEPARTAMENTAL', '49', 'null', 49, 10, 0, 1, 510, 'M-049');
INSERT INTO gamification_by_process
VALUES (50, '/uploads/gamification/gamificationByProcess/process_50.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        "Acción relacionada con la tarea 'Compartir cupón' en la categoría 'PROMOCION_MARCA'.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '50', 'null', 50, 11, 0, 1, 351, 'PM-050');
INSERT INTO gamification_by_process
VALUES (51, '/uploads/gamification/gamificationByProcess/process_51.png', 'Publicar en redes',
        'Publicar en redes (detalle)',
        "Acción relacionada con la tarea 'Publicar en redes' en la categoría 'PROMOCION_MARCA'.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '51', 'null', 51, 11, 0, 1, 673, 'PM-051');
INSERT INTO gamification_by_process
VALUES (52, '/uploads/gamification/gamificationByProcess/process_52.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        "Acción relacionada con la tarea 'Recomendar públicamente' en la categoría 'PROMOCION_MARCA'.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '52', 'null', 52, 11, 0, 1, 193, 'PM-052');
INSERT INTO gamification_by_process
VALUES (53, '/uploads/gamification/gamificationByProcess/process_53.png', 'Crear publicación',
        'Crear publicación (detalle)',
        "Acción relacionada con la tarea 'Crear publicación' en la categoría 'PROMOCION_MARCA'.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '53', 'null', 53, 11, 0, 1, 872, 'PM-053');
INSERT INTO gamification_by_process
VALUES (54, '/uploads/gamification/gamificationByProcess/process_54.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '54', 'null', 54, 4, 0, 1, 502, 'EM-054');
INSERT INTO gamification_by_process
VALUES (55, '/uploads/gamification/gamificationByProcess/process_55.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '55', 'null', 55, 4, 0, 1, 176, 'EM-055');
INSERT INTO gamification_by_process
VALUES (56, '/uploads/gamification/gamificationByProcess/process_56.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '56', 'null', 56, 7, 0, 1, 550, 'R-056');
INSERT INTO gamification_by_process
VALUES (57, '/uploads/gamification/gamificationByProcess/process_57.png', 'Actualizar dirección',
        'Actualizar dirección (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '57', 'null', 57, 3, 0, 1, 799, 'GC-057');
INSERT INTO gamification_by_process
VALUES (58, '/uploads/gamification/gamificationByProcess/process_58.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '58', 'null', 58, 4, 0, 1, 196, 'EM-058');
INSERT INTO gamification_by_process
VALUES (59, '/uploads/gamification/gamificationByProcess/process_59.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '59', 'null', 59, 4, 0, 1, 569, 'EM-059');
INSERT INTO gamification_by_process
VALUES (60, '/uploads/gamification/gamificationByProcess/process_60.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '60', 'null', 60, 6, 0, 1, 329, 'IP-060');
INSERT INTO gamification_by_process
VALUES (61, '/uploads/gamification/gamificationByProcess/process_61.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '61', 'null', 61, 6, 0, 1, 779, 'IP-061');
INSERT INTO gamification_by_process
VALUES (62, '/uploads/gamification/gamificationByProcess/process_62.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '62', 'null', 62, 6, 0, 1, 113, 'IP-062');
INSERT INTO gamification_by_process
VALUES (63, '/uploads/gamification/gamificationByProcess/process_63.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '63', 'null', 63, 9, 0, 1, 14, 'F-063');
INSERT INTO gamification_by_process
VALUES (64, '/uploads/gamification/gamificationByProcess/process_64.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '64', 'null', 64, 11, 0, 1, 673, 'PM-064');
INSERT INTO gamification_by_process
VALUES (65, '/uploads/gamification/gamificationByProcess/process_65.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '65', 'null', 65, 11, 0, 1, 126, 'PM-065');
INSERT INTO gamification_by_process
VALUES (66, '/uploads/gamification/gamificationByProcess/process_66.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '66', 'null', 66, 8, 0, 1, 93, 'CE-066');
INSERT INTO gamification_by_process
VALUES (67, '/uploads/gamification/gamificationByProcess/process_67.png', 'Responder encuesta de soporte',
        'Responder encuesta de soporte (detalle)',
        "Acción gamificada enfocada en 'multidepartamental' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '67', 'null', 67, 10, 0, 1, 389, 'M-067');
INSERT INTO gamification_by_process
VALUES (68, '/uploads/gamification/gamificationByProcess/process_68.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '68', 'null', 68, 5, 0, 1, 352, 'RC-068');
INSERT INTO gamification_by_process
VALUES (69, '/uploads/gamification/gamificationByProcess/process_69.png', 'Enviar queja', 'Enviar queja (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '69', 'null', 69, 5, 0, 1, 399, 'RC-069');
INSERT INTO gamification_by_process
VALUES (70, '/uploads/gamification/gamificationByProcess/process_70.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '70', 'null', 70, 7, 0, 1, 858, 'R-070');
INSERT INTO gamification_by_process
VALUES (71, '/uploads/gamification/gamificationByProcess/process_71.png', 'Compartir producto',
        'Compartir producto (detalle)',
        "Acción gamificada enfocada en 'gestion_ecommerce' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '71', 'null', 71, 1, 0, 1, 979, 'GE-071');
INSERT INTO gamification_by_process
VALUES (72, '/uploads/gamification/gamificationByProcess/process_72.png', 'Calificar compra',
        'Calificar compra (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '72', 'null', 72, 5, 0, 1, 182, 'RC-072');
INSERT INTO gamification_by_process
VALUES (73, '/uploads/gamification/gamificationByProcess/process_73.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '73', 'null', 73, 7, 0, 1, 145, 'R-073');
INSERT INTO gamification_by_process
VALUES (74, '/uploads/gamification/gamificationByProcess/process_74.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '74', 'null', 74, 9, 0, 1, 780, 'F-074');
INSERT INTO gamification_by_process
VALUES (75, '/uploads/gamification/gamificationByProcess/process_75.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '75', 'null', 75, 9, 0, 1, 297, 'F-075');
INSERT INTO gamification_by_process
VALUES (76, '/uploads/gamification/gamificationByProcess/process_76.png', 'Calificar compra',
        'Calificar compra (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '76', 'null', 76, 5, 0, 1, 627, 'RC-076');
INSERT INTO gamification_by_process
VALUES (77, '/uploads/gamification/gamificationByProcess/process_77.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '77', 'null', 77, 7, 0, 1, 689, 'R-077');
INSERT INTO gamification_by_process
VALUES (78, '/uploads/gamification/gamificationByProcess/process_78.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '78', 'null', 78, 8, 0, 1, 4, 'CE-078');
INSERT INTO gamification_by_process
VALUES (79, '/uploads/gamification/gamificationByProcess/process_79.png', 'Enviar queja', 'Enviar queja (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '79', 'null', 79, 5, 0, 1, 531, 'RC-079');
INSERT INTO gamification_by_process
VALUES (80, '/uploads/gamification/gamificationByProcess/process_80.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '80', 'null', 80, 9, 0, 1, 208, 'F-080');
INSERT INTO gamification_by_process
VALUES (81, '/uploads/gamification/gamificationByProcess/process_81.png', 'Publicar en redes',
        'Publicar en redes (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '81', 'null', 81, 11, 0, 1, 486, 'PM-081');
INSERT INTO gamification_by_process
VALUES (82, '/uploads/gamification/gamificationByProcess/process_82.png', 'Referir producto',
        'Referir producto (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '82', 'null', 82, 7, 0, 1, 272, 'R-082');
INSERT INTO gamification_by_process
VALUES (83, '/uploads/gamification/gamificationByProcess/process_83.png', 'Referir empresa',
        'Referir empresa (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '83', 'null', 83, 7, 0, 1, 676, 'R-083');
INSERT INTO gamification_by_process
VALUES (84, '/uploads/gamification/gamificationByProcess/process_84.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '84', 'null', 84, 4, 0, 1, 876, 'EM-084');
INSERT INTO gamification_by_process
VALUES (85, '/uploads/gamification/gamificationByProcess/process_85.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '85', 'null', 85, 7, 0, 1, 699, 'R-085');
INSERT INTO gamification_by_process
VALUES (86, '/uploads/gamification/gamificationByProcess/process_86.png', 'Actualizar número',
        'Actualizar número (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '86', 'null', 86, 3, 0, 1, 251, 'GC-086');
INSERT INTO gamification_by_process
VALUES (87, '/uploads/gamification/gamificationByProcess/process_87.png', 'Referir producto',
        'Referir producto (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '87', 'null', 87, 7, 0, 1, 924, 'R-087');
INSERT INTO gamification_by_process
VALUES (88, '/uploads/gamification/gamificationByProcess/process_88.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '88', 'null', 88, 6, 0, 1, 153, 'IP-088');
INSERT INTO gamification_by_process
VALUES (89, '/uploads/gamification/gamificationByProcess/process_89.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '89', 'null', 89, 6, 0, 1, 895, 'IP-089');
INSERT INTO gamification_by_process
VALUES (90, '/uploads/gamification/gamificationByProcess/process_90.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '90', 'null', 90, 4, 0, 1, 603, 'EM-090');
INSERT INTO gamification_by_process
VALUES (91, '/uploads/gamification/gamificationByProcess/process_91.png', 'Calificar atención',
        'Calificar atención (detalle)',
        "Acción gamificada enfocada en 'multidepartamental' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '91', 'null', 91, 10, 0, 1, 599, 'M-091');
INSERT INTO gamification_by_process
VALUES (92, '/uploads/gamification/gamificationByProcess/process_92.png', 'Completar desafío diario',
        'Completar desafío diario (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '92', 'null', 92, 9, 0, 1, 404, 'F-092');
INSERT INTO gamification_by_process
VALUES (93, '/uploads/gamification/gamificationByProcess/process_93.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '93', 'null', 93, 4, 0, 1, 45, 'EM-093');
INSERT INTO gamification_by_process
VALUES (94, '/uploads/gamification/gamificationByProcess/process_94.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '94', 'null', 94, 6, 0, 1, 445, 'IP-094');
INSERT INTO gamification_by_process
VALUES (95, '/uploads/gamification/gamificationByProcess/process_95.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '95', 'null', 95, 8, 0, 1, 623, 'CE-095');
INSERT INTO gamification_by_process
VALUES (96, '/uploads/gamification/gamificationByProcess/process_96.png', 'Registrar invitado',
        'Registrar invitado (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '96', 'null', 96, 7, 0, 1, 676, 'R-096');
INSERT INTO gamification_by_process
VALUES (97, '/uploads/gamification/gamificationByProcess/process_97.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '97', 'null', 97, 2, 0, 1, 522, 'CE-097');
INSERT INTO gamification_by_process
VALUES (98, '/uploads/gamification/gamificationByProcess/process_98.png', 'Hacer check-in', 'Hacer check-in (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '98', 'null', 98, 6, 0, 1, 603, 'IP-098');
INSERT INTO gamification_by_process
VALUES (99, '/uploads/gamification/gamificationByProcess/process_99.png', 'Responder encuesta',
        'Responder encuesta (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '99', 'null', 99, 4, 0, 1, 801, 'EM-099');
INSERT INTO gamification_by_process
VALUES (100, '/uploads/gamification/gamificationByProcess/process_100.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '100', 'null', 100, 6, 0, 1, 711, 'IP-100');
INSERT INTO gamification_by_process
VALUES (101, '/uploads/gamification/gamificationByProcess/process_101.png', 'Finalizar compra',
        'Finalizar compra (detalle)',
        "Acción gamificada enfocada en 'gestion_ecommerce' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '101', 'null', 101, 1, 0, 1, 71, 'GE-101');
INSERT INTO gamification_by_process
VALUES (102, '/uploads/gamification/gamificationByProcess/process_102.png', 'Actualizar número',
        'Actualizar número (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '102', 'null', 102, 3, 0, 1, 865, 'GC-102');
INSERT INTO gamification_by_process
VALUES (103, '/uploads/gamification/gamificationByProcess/process_103.png', 'Actualizar número',
        'Actualizar número (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '103', 'null', 103, 3, 0, 1, 80, 'GC-103');
INSERT INTO gamification_by_process
VALUES (104, '/uploads/gamification/gamificationByProcess/process_104.png', 'Guardar noticia',
        'Guardar noticia (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '104', 'null', 104, 8, 0, 1, 78, 'CE-104');
INSERT INTO gamification_by_process
VALUES (105, '/uploads/gamification/gamificationByProcess/process_105.png', 'Unirse a evento de marca',
        'Unirse a evento de marca (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '105', 'null', 105, 4, 0, 1, 686, 'EM-105');
INSERT INTO gamification_by_process
VALUES (106, '/uploads/gamification/gamificationByProcess/process_106.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '106', 'null', 106, 7, 0, 1, 34, 'R-106');
INSERT INTO gamification_by_process
VALUES (107, '/uploads/gamification/gamificationByProcess/process_107.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '107', 'null', 107, 4, 0, 1, 277, 'EM-107');
INSERT INTO gamification_by_process
VALUES (108, '/uploads/gamification/gamificationByProcess/process_108.png', 'Ver perfil de empresa',
        'Ver perfil de empresa (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '108', 'null', 108, 2, 0, 1, 559, 'CE-108');
INSERT INTO gamification_by_process
VALUES (109, '/uploads/gamification/gamificationByProcess/process_109.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '109', 'null', 109, 4, 0, 1, 838, 'EM-109');
INSERT INTO gamification_by_process
VALUES (110, '/uploads/gamification/gamificationByProcess/process_110.png', 'Calificar empresa',
        'Calificar empresa (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '110', 'null', 110, 2, 0, 1, 812, 'CE-110');
INSERT INTO gamification_by_process
VALUES (111, '/uploads/gamification/gamificationByProcess/process_111.png', 'Borrar dato', 'Borrar dato (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '111', 'null', 111, 3, 0, 1, 883, 'GC-111');
INSERT INTO gamification_by_process
VALUES (112, '/uploads/gamification/gamificationByProcess/process_112.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '112', 'null', 112, 6, 0, 1, 197, 'IP-112');
INSERT INTO gamification_by_process
VALUES (113, '/uploads/gamification/gamificationByProcess/process_113.png', 'Compartir cupón',
        'Compartir cupón (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '113', 'null', 113, 11, 0, 1, 835, 'PM-113');
INSERT INTO gamification_by_process
VALUES (114, '/uploads/gamification/gamificationByProcess/process_114.png', 'Calificar compra',
        'Calificar compra (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '114', 'null', 114, 5, 0, 1, 809, 'RC-114');
INSERT INTO gamification_by_process
VALUES (115, '/uploads/gamification/gamificationByProcess/process_115.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '115', 'null', 115, 2, 0, 1, 537, 'CE-115');
INSERT INTO gamification_by_process
VALUES (116, '/uploads/gamification/gamificationByProcess/process_116.png', 'Hacer check-in',
        'Hacer check-in (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '116', 'null', 116, 6, 0, 1, 697, 'IP-116');
INSERT INTO gamification_by_process
VALUES (117, '/uploads/gamification/gamificationByProcess/process_117.png', 'Compartir sorteo',
        'Compartir sorteo (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '117', 'null', 117, 4, 0, 1, 611, 'EM-117');
INSERT INTO gamification_by_process
VALUES (118, '/uploads/gamification/gamificationByProcess/process_118.png', 'Comentar artículo',
        'Comentar artículo (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '118', 'null', 118, 8, 0, 1, 802, 'CE-118');
INSERT INTO gamification_by_process
VALUES (119, '/uploads/gamification/gamificationByProcess/process_119.png', 'Usar cupón', 'Usar cupón (detalle)',
        "Acción gamificada enfocada en 'gestion_ecommerce' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '119', 'null', 119, 1, 0, 1, 352, 'GE-119');
INSERT INTO gamification_by_process
VALUES (120, '/uploads/gamification/gamificationByProcess/process_120.png', 'Borrar dato', 'Borrar dato (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '120', 'null', 120, 3, 0, 1, 63, 'GC-120');
INSERT INTO gamification_by_process
VALUES (121, '/uploads/gamification/gamificationByProcess/process_121.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '121', 'null', 121, 5, 0, 1, 177, 'RC-121');
INSERT INTO gamification_by_process
VALUES (122, '/uploads/gamification/gamificationByProcess/process_122.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '122', 'null', 122, 11, 0, 1, 180, 'PM-122');
INSERT INTO gamification_by_process
VALUES (123, '/uploads/gamification/gamificationByProcess/process_123.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '123', 'null', 123, 4, 0, 1, 757, 'EM-123');
INSERT INTO gamification_by_process
VALUES (124, '/uploads/gamification/gamificationByProcess/process_124.png', 'Actualizar perfil',
        'Actualizar perfil (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '124', 'null', 124, 3, 0, 1, 966, 'GC-124');
INSERT INTO gamification_by_process
VALUES (125, '/uploads/gamification/gamificationByProcess/process_125.png', 'Logro desbloqueado',
        'Logro desbloqueado (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '125', 'null', 125, 9, 0, 1, 440, 'F-125');
INSERT INTO gamification_by_process
VALUES (126, '/uploads/gamification/gamificationByProcess/process_126.png', 'Calificar atención',
        'Calificar atención (detalle)',
        "Acción gamificada enfocada en 'multidepartamental' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '126', 'null', 126, 10, 0, 1, 286, 'M-126');
INSERT INTO gamification_by_process
VALUES (127, '/uploads/gamification/gamificationByProcess/process_127.png', 'Reaccionar a banner',
        'Reaccionar a banner (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '127', 'null', 127, 4, 0, 1, 775, 'EM-127');
INSERT INTO gamification_by_process
VALUES (128, '/uploads/gamification/gamificationByProcess/process_128.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '128', 'null', 128, 6, 0, 1, 164, 'IP-128');
INSERT INTO gamification_by_process
VALUES (129, '/uploads/gamification/gamificationByProcess/process_129.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '129', 'null', 129, 9, 0, 1, 203, 'F-129');
INSERT INTO gamification_by_process
VALUES (130, '/uploads/gamification/gamificationByProcess/process_130.png', 'Compartir código de invitación',
        'Compartir código de invitación (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '130', 'null', 130, 7, 0, 1, 895, 'R-130');
INSERT INTO gamification_by_process
VALUES (131, '/uploads/gamification/gamificationByProcess/process_131.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '131', 'null', 131, 4, 0, 1, 950, 'EM-131');
INSERT INTO gamification_by_process
VALUES (132, '/uploads/gamification/gamificationByProcess/process_132.png', 'Recomendar públicamente',
        'Recomendar públicamente (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '132', 'null', 132, 11, 0, 1, 187, 'PM-132');
INSERT INTO gamification_by_process
VALUES (133, '/uploads/gamification/gamificationByProcess/process_133.png', 'Enviar queja', 'Enviar queja (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '133', 'null', 133, 5, 0, 1, 788, 'RC-133');
INSERT INTO gamification_by_process
VALUES (134, '/uploads/gamification/gamificationByProcess/process_134.png', 'Completar reto mensual',
        'Completar reto mensual (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '134', 'null', 134, 9, 0, 1, 87, 'F-134');
INSERT INTO gamification_by_process
VALUES (135, '/uploads/gamification/gamificationByProcess/process_135.png', 'Dejar retroalimentación',
        'Dejar retroalimentación (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '135', 'null', 135, 5, 0, 1, 350, 'RC-135');
INSERT INTO gamification_by_process
VALUES (136, '/uploads/gamification/gamificationByProcess/process_136.png', 'Compartir noticia',
        'Compartir noticia (detalle)',
        "Acción gamificada enfocada en 'contenido_empresarial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONTENIDO_EMPRESARIAL', '136', 'null', 136, 8, 0, 1, 200, 'CE-136');
INSERT INTO gamification_by_process
VALUES (137, '/uploads/gamification/gamificationByProcess/process_137.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        "Acción gamificada enfocada en 'gestion_ecommerce' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '137', 'null', 137, 1, 0, 1, 387, 'GE-137');
INSERT INTO gamification_by_process
VALUES (138, '/uploads/gamification/gamificationByProcess/process_138.png', 'Evaluar entrega',
        'Evaluar entrega (detalle)',
        "Acción gamificada enfocada en 'multidepartamental' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'MULTIDEPARTAMENTAL', '138', 'null', 138, 10, 0, 1, 288, 'M-138');
INSERT INTO gamification_by_process
VALUES (139, '/uploads/gamification/gamificationByProcess/process_139.png', 'Votar sugerencia',
        'Votar sugerencia (detalle)',
        "Acción gamificada enfocada en 'retroalimentacion_cliente' para mejorar la experiencia empresa-cliente.",
        'ACTIVE', 1, 'RETROALIMENTACION_CLIENTE', '139', 'null', 139, 5, 0, 1, 82, 'RC-139');
INSERT INTO gamification_by_process
VALUES (140, '/uploads/gamification/gamificationByProcess/process_140.png', 'Borrar dato', 'Borrar dato (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '140', 'null', 140, 3, 0, 1, 482, 'GC-140');
INSERT INTO gamification_by_process
VALUES (141, '/uploads/gamification/gamificationByProcess/process_141.png', 'Compartir empresa',
        'Compartir empresa (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '141', 'null', 141, 2, 0, 1, 282, 'CE-141');
INSERT INTO gamification_by_process
VALUES (142, '/uploads/gamification/gamificationByProcess/process_142.png', 'Escanear código QR',
        'Escanear código QR (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '142', 'null', 142, 6, 0, 1, 46, 'IP-142');
INSERT INTO gamification_by_process
VALUES (143, '/uploads/gamification/gamificationByProcess/process_143.png', 'Participar en campaña',
        'Participar en campaña (detalle)',
        "Acción gamificada enfocada en 'engagement_marketing' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'ENGAGEMENT_MARKETING', '143', 'null', 143, 4, 0, 1, 788, 'EM-143');
INSERT INTO gamification_by_process
VALUES (144, '/uploads/gamification/gamificationByProcess/process_144.png', 'Marcar como favorita',
        'Marcar como favorita (detalle)',
        "Acción gamificada enfocada en 'conocimiento_empresa' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'CONOCIMIENTO_EMPRESA', '144', 'null', 144, 2, 0, 1, 927, 'CE-144');
INSERT INTO gamification_by_process
VALUES (145, '/uploads/gamification/gamificationByProcess/process_145.png', 'Participar en evento físico',
        'Participar en evento físico (detalle)',
        "Acción gamificada enfocada en 'interaccion_presencial' para mejorar la experiencia empresa-cliente.", 'ACTIVE',
        1, 'INTERACCION_PRESENCIAL', '145', 'null', 145, 6, 0, 1, 305, 'IP-145');
INSERT INTO gamification_by_process
VALUES (146, '/uploads/gamification/gamificationByProcess/process_146.png', 'Agregar preferencia',
        'Agregar preferencia (detalle)',
        "Acción gamificada enfocada en 'gestion_cliente' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_CLIENTE', '146', 'null', 146, 3, 0, 1, 227, 'GC-146');
INSERT INTO gamification_by_process
VALUES (147, '/uploads/gamification/gamificationByProcess/process_147.png', 'Agregar al carrito',
        'Agregar al carrito (detalle)',
        "Acción gamificada enfocada en 'gestion_ecommerce' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'GESTION_ECOMMERCE', '147', 'null', 147, 1, 0, 1, 711, 'GE-147');
INSERT INTO gamification_by_process
VALUES (148, '/uploads/gamification/gamificationByProcess/process_148.png', 'Referir empresa',
        'Referir empresa (detalle)',
        "Acción gamificada enfocada en 'referidos' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'REFERIDOS', '148', 'null', 148, 7, 0, 1, 325, 'R-148');
INSERT INTO gamification_by_process
VALUES (149, '/uploads/gamification/gamificationByProcess/process_149.png', 'Crear publicación',
        'Crear publicación (detalle)',
        "Acción gamificada enfocada en 'promocion_marca' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'PROMOCION_MARCA', '149', 'null', 149, 11, 0, 1, 837, 'PM-149');
INSERT INTO gamification_by_process
VALUES (150, '/uploads/gamification/gamificationByProcess/process_150.png', 'Canjear puntos',
        'Canjear puntos (detalle)',
        "Acción gamificada enfocada en 'fidelizacion' para mejorar la experiencia empresa-cliente.", 'ACTIVE', 1,
        'FIDELIZACION', '150', 'null', 150, 9, 0, 1, 934, 'F-150');
INSERT INTO gamification_by_process
VALUES (151, '/uploads/gamification/gamificationByProcess/process_151.png', 'Envió puntos a otro cliente',
        'Envió puntos a otro cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-001', 12),
       (152, '/uploads/gamification/gamificationByProcess/process_152.png', 'Premió colaboración de un cliente',
        'Premió colaboración de un cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-002', 12),
       (153, '/uploads/gamification/gamificationByProcess/process_153.png', 'Compartió experiencia útil con cliente',
        'Compartió experiencia útil con cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-003', 12),
       (154, '/uploads/gamification/gamificationByProcess/process_154.png', 'Ayudó a resolver duda de otro usuario',
        'Ayudó a resolver duda de otro usuario.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-004', 12),
       (155, '/uploads/gamification/gamificationByProcess/process_155.png', 'Participó con otro cliente en reto',
        'Participó con otro cliente en reto.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-005', 12),
       (156, '/uploads/gamification/gamificationByProcess/process_156.png', 'Compartió código con cliente',
        'Compartió código con cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-006', 12),
       (157, '/uploads/gamification/gamificationByProcess/process_157.png', 'Compartió recursos útiles con cliente',
        'Compartió recursos útiles con cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-007', 12),
       (158, '/uploads/gamification/gamificationByProcess/process_158.png', 'Reconoció públicamente a un cliente',
        'Reconoció públicamente a un cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-008', 12),
       (159, '/uploads/gamification/gamificationByProcess/process_159.png', 'Donó puntos en actividad grupal',
        'Donó puntos en actividad grupal.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-009', 12),
       (160, '/uploads/gamification/gamificationByProcess/process_160.png', 'Colaboró en encuesta compartida',
        'Colaboró en encuesta compartida.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-010', 12),
       (161, '/uploads/gamification/gamificationByProcess/process_161.png', 'Recomendó producto a cliente',
        'Recomendó producto a cliente.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-011', 12),
       (162, '/uploads/gamification/gamificationByProcess/process_162.png', 'Invitó a otro cliente a MeetClic',
        'Invitó a otro cliente a MeetClic.', 'ACTIVE', 1, 'CLIENTE_A_CLIENTE-012', 12),
       (163, '/uploads/gamification/gamificationByProcess/process_163.png', 'Donó puntos a empresa',
        'Donó puntos a empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-001', 13),
       (164, '/uploads/gamification/gamificationByProcess/process_164.png', 'Participó en campaña solidaria',
        'Participó en campaña solidaria.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-002', 13),
       (165, '/uploads/gamification/gamificationByProcess/process_165.png', 'Valoró positivamente a empresa',
        'Valoró positivamente a empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-003', 13),
       (166, '/uploads/gamification/gamificationByProcess/process_166.png', 'Comentó producto de empresa',
        'Comentó producto de empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-004', 13),
       (167, '/uploads/gamification/gamificationByProcess/process_167.png', 'Compartió empresa en redes',
        'Compartió empresa en redes.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-005', 13),
       (168, '/uploads/gamification/gamificationByProcess/process_168.png', 'Contribuyó en reto de empresa',
        'Contribuyó en reto de empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-006', 13),
       (169, '/uploads/gamification/gamificationByProcess/process_169.png', 'Subió contenido en campaña',
        'Subió contenido en campaña.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-007', 13),
       (170, '/uploads/gamification/gamificationByProcess/process_170.png', 'Propuso mejora a empresa',
        'Propuso mejora a empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-008', 13),
       (171, '/uploads/gamification/gamificationByProcess/process_171.png', 'Apoyó evento de empresa',
        'Apoyó evento de empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-009', 13),
       (172, '/uploads/gamification/gamificationByProcess/process_172.png', 'Sugirió empresa a otros',
        'Sugirió empresa a otros.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-010', 13),
       (173, '/uploads/gamification/gamificationByProcess/process_173.png', 'Publicó testimonio de empresa',
        'Publicó testimonio de empresa.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-011', 13),
       (174, '/uploads/gamification/gamificationByProcess/process_174.png', 'Se unió a grupo de fidelización',
        'Se unió a grupo de fidelización.', 'ACTIVE', 1, 'CLIENTE_A_EMPRESA-012', 13),
       (175, '/uploads/gamification/gamificationByProcess/process_175.png', 'Premió fidelidad del cliente',
        'Premió fidelidad del cliente.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-001', 14),
       (176, '/uploads/gamification/gamificationByProcess/process_176.png', 'Bonificó al cliente por referidos',
        'Bonificó al cliente por referidos.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-002', 14),
       (177, '/uploads/gamification/gamificationByProcess/process_177.png', 'Reconoció participación del cliente',
        'Reconoció participación del cliente.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-003', 14),
       (178, '/uploads/gamification/gamificationByProcess/process_178.png', 'Otorgó puntos por encuestas',
        'Otorgó puntos por encuestas.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-004', 14),
       (179, '/uploads/gamification/gamificationByProcess/process_179.png', 'Bonificó compras recientes',
        'Bonificó compras recientes.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-005', 14),
       (180, '/uploads/gamification/gamificationByProcess/process_180.png', 'Premió feedback constructivo',
        'Premió feedback constructivo.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-006', 14),
       (181, '/uploads/gamification/gamificationByProcess/process_181.png', 'Activó bono de bienvenida',
        'Activó bono de bienvenida.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-007', 14),
       (182, '/uploads/gamification/gamificationByProcess/process_182.png', 'Recompensó colaboración del cliente',
        'Recompensó colaboración del cliente.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-008', 14),
       (183, '/uploads/gamification/gamificationByProcess/process_183.png', 'Agradeció comentarios útiles',
        'Agradeció comentarios útiles.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-009', 14),
       (184, '/uploads/gamification/gamificationByProcess/process_184.png', 'Otorgó puntos por asistencia a evento',
        'Otorgó puntos por asistencia a evento.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-010', 14),
       (185, '/uploads/gamification/gamificationByProcess/process_185.png', 'Premió uso de cupones',
        'Premió uso de cupones.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-011', 14),
       (186, '/uploads/gamification/gamificationByProcess/process_186.png', 'Activó logro especial',
        'Activó logro especial.', 'ACTIVE', 1, 'EMPRESA_A_CLIENTE-012', 14),
       (187, '/uploads/gamification/gamificationByProcess/process_187.png', 'Compartió puntos por alianza',
        'Compartió puntos por alianza.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-001', 15),
       (188, '/uploads/gamification/gamificationByProcess/process_188.png', 'Apoyó campaña de empresa aliada',
        'Apoyó campaña de empresa aliada.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-002', 15),
       (189, '/uploads/gamification/gamificationByProcess/process_189.png', 'Reconoció colaboración interempresarial',
        'Reconoció colaboración interempresarial.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-003', 15),
       (190, '/uploads/gamification/gamificationByProcess/process_190.png', 'Premió a otra empresa por sinergia',
        'Premió a otra empresa por sinergia.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-004', 15),
       (191, '/uploads/gamification/gamificationByProcess/process_191.png', 'Recomendó productos de empresa aliada',
        'Recomendó productos de empresa aliada.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-005', 15),
       (192, '/uploads/gamification/gamificationByProcess/process_192.png', 'Participó en reto entre empresas',
        'Participó en reto entre empresas.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-006', 15),
       (193, '/uploads/gamification/gamificationByProcess/process_193.png', 'Contribuyó a promoción conjunta',
        'Contribuyó a promoción conjunta.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-007', 15),
       (194, '/uploads/gamification/gamificationByProcess/process_194.png', 'Cedió cupón entre empresas',
        'Cedió cupón entre empresas.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-008', 15),
       (195, '/uploads/gamification/gamificationByProcess/process_195.png', 'Validó experiencia de otra empresa',
        'Validó experiencia de otra empresa.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-009', 15),
       (196, '/uploads/gamification/gamificationByProcess/process_196.png', 'Impulsó visibilidad cruzada',
        'Impulsó visibilidad cruzada.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-010', 15),
       (197, '/uploads/gamification/gamificationByProcess/process_197.png', 'Participó en evento interempresarial',
        'Participó en evento interempresarial.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-011', 15),
       (198, '/uploads/gamification/gamificationByProcess/process_198.png', 'Se unió a red de empresas aliadas',
        'Se unió a red de empresas aliadas.', 'ACTIVE', 1, 'EMPRESA_A_EMPRESA-012', 15);

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


INSERT INTO gamification_by_points (id, gamification_by_process_id, value)
VALUES (151, 151, 0.0),
       (152, 152, 0.0),
       (153, 153, 0.0),
       (154, 154, 0.0),
       (155, 155, 0.0),
       (156, 156, 0.0),
       (157, 157, 0.0),
       (158, 158, 0.0),
       (159, 159, 0.0),
       (160, 160, 0.0),
       (161, 161, 0.0),
       (162, 162, 0.0),
       (163, 163, 0.0),
       (164, 164, 0.0),
       (165, 165, 0.0),
       (166, 166, 0.0),
       (167, 167, 0.0),
       (168, 168, 0.0),
       (169, 169, 0.0),
       (170, 170, 0.0),
       (171, 171, 0.0),
       (172, 172, 0.0),
       (173, 173, 0.0),
       (174, 174, 0.0),
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
       (187, 187, 0.0),
       (188, 188, 0.0),
       (189, 189, 0.0),
       (190, 190, 0.0),
       (191, 191, 0.0),
       (192, 192, 0.0),
       (193, 193, 0.0),
       (194, 194, 0.0),
       (195, 195, 0.0),
       (196, 196, 0.0),
       (197, 197, 0.0),
       (198, 198, 0.0);
SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
