SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

TRUNCATE TABLE account_gamification_business;
TRUNCATE TABLE account_gamification_by_movement_business;
TRUNCATE TABLE account_gamification_movement_by_business;


-- Paso 1: Crear o asegurar cuenta del usuario en la tabla de gamificación
INSERT INTO account_gamification_business (id, business_id, balance_available_bee, balance_available_queen, created_at,
                                           updated_at)
VALUES (1, 1, 0, 0, NOW(), NOW());

-- Paso 2: Insertar movimientos CLIENTE_A_EMPRESA (procesos 163–174)
-- Paso 1: Insertar movimientos CLIENTE_A_EMPRESA (IDs 163–174)
-- CLIENTE_A_EMPRESA
INSERT INTO `account_gamification_by_movement_business` (`id`, `created_at`, `updated_at`, `deleted_at`,
                                                `account_gamification_id`, `amount`, `type`, `input_movement`,
                                                `description`, `expire_at`, `user_transaction_id`, `type_money`,
                                                `gamification_by_process_id`, `related_entity_id`,
                                                `related_entity_type`)
VALUES (1, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 1, 'Recibio puntos a de un cliente', NULL, 0, 0, 163,
        1, 'CLIENTE'),
-- EMPRESA_A_CLIENTE (todos INPUT = 1, tipo = 0)
       (2, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Premió fidelidad del cliente', NULL, 0,
        0, 175, 1, 'CLIENTE'),
       (3, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Bonificó al cliente por referidos', NULL,
        0, 0, 176, 1, 'CLIENTE'),
       (4, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Reconoció participación del cliente',
        NULL, 0, 0, 177, 1, 'CLIENTE'),
       (5, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Otorgó puntos por encuestas', NULL, 0, 0,
        178, 1, 'CLIENTE'),
       (6, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Bonificó compras recientes', NULL, 0, 0,
        179, 1, 'CLIENTE'),
       (7, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Premió feedback constructivo', NULL, 0,
        0, 180, 1, 'CLIENTE'),
       (8, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Activó bono de bienvenida', NULL, 0, 0,
        181, 1, 'CLIENTE'),
       (9, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Recompensó colaboración del cliente',
        NULL, 0, 0, 182, 1, 'CLIENTE'),
       (10, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Agradeció comentarios útiles', NULL, 0,
        0, 183, 1, 'CLIENTE'),
       (11, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Otorgó puntos por asistencia a evento',
        NULL, 0, 0, 184, 1, 'CLIENTE'),
       (12, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Premió uso de cupones', NULL, 0, 0, 185,
        1, 'CLIENTE'),
       (13, '2025-07-22 23:42:00', '2025-07-22 23:42:00', NULL, 1, 100, 0, 0, 'Activó logro especial', NULL, 0, 0, 186,
        1, 'CLIENTE');

UPDATE account_gamification_business
SET balance_available_bee = (
    SELECT
        IFNULL(SUM(
                   CASE
                       WHEN type IN (0, 3, 4) THEN amount
                       WHEN type IN (1, 2) THEN -amount
                       ELSE 0
                       END
                   ), 0)
    FROM account_gamification_by_movement_business
    WHERE account_gamification_id = 1
      AND type_money = 'bee'
)
WHERE id = 1;


INSERT INTO reputation_movement_client (account_gamification_id, user_id, gamification_by_process_id, description, reputation_points, type_manager)
VALUES
    (1, 1, 166, 'Comentó producto de una empresa', 10, 1),
    (1, 1, 173, 'Publicó testimonio de empresa', 15, 1),
    (1, 1, 174, 'Se unió a grupo de fidelización', 20, 1),
    (1, 1, 170, 'Propuso mejora a empresa, pero fue rechazada', 5, 0),
    (1, 1, 165, 'Valoró negativamente a empresa', 10, 0),
    (1, 1, 169, 'Subió contenido que no cumplía reglas', -15, 0);

INSERT INTO reputation_movement_business (account_gamification_business_id, user_id, gamification_by_process_id, description, reputation_points, type_manager)
VALUES
    (1, 1, 175, 'Premió fidelidad del cliente', 15, 1),
    (1, 1, 176, 'Bonificó al cliente por referidos', 10, 1),
    (1, 1, 180, 'Premió feedback constructivo', 20, 1),
    (1, 1, 179, 'Bonificó compras, pero no entregó productos', 20, 0),
    (1, 1, 183, 'Recibió varios reportes por mal servicio', 30, 0),
    (1, 1, 177, 'No reconoció participación de cliente', 10, 0);
-- Usuario 1 calificó con 5 estrella(s): Experiencia excelente, en armonía con los valores andinos.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 1, 5, 'Experiencia excelente, en armonía con los valores andinos.', '2025-06-29 00:00:00');
-- Usuario 2 calificó con 3 estrella(s): Interacción funcional pero sin fortalecer el tejido comunitario.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 2, 3, 'Interacción funcional pero sin fortalecer el tejido comunitario.', '2025-05-22 00:00:00');
-- Usuario 3 calificó con 3 estrella(s): Interacción funcional pero sin fortalecer el tejido comunitario.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 3, 3, 'Interacción funcional pero sin fortalecer el tejido comunitario.', '2025-07-13 00:00:00');
-- Usuario 4 calificó con 1 estrella(s): El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 4, 1, 'El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.', '2025-06-09 00:00:00');
-- Usuario 5 calificó con 4 estrella(s): Relación con respeto, escucha y buena intención de servicio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 5, 4, 'Relación con respeto, escucha y buena intención de servicio.', '2025-07-03 00:00:00');
-- Usuario 6 calificó con 4 estrella(s): Se sintió cumplimiento con energía circular de dar y recibir.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 6, 4, 'Se sintió cumplimiento con energía circular de dar y recibir.', '2025-05-09 00:00:00');
-- Usuario 7 calificó con 5 estrella(s): Conexión auténtica, cuidado y propósito compartido.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 7, 5, 'Conexión auténtica, cuidado y propósito compartido.', '2025-05-27 00:00:00');
-- Usuario 8 calificó con 5 estrella(s): Conexión auténtica, cuidado y propósito compartido.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 8, 5, 'Conexión auténtica, cuidado y propósito compartido.', '2025-05-21 00:00:00');
-- Usuario 9 calificó con 2 estrella(s): La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 9, 2, 'La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.', '2025-05-02 00:00:00');
-- Usuario 10 calificó con 2 estrella(s): La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 10, 2, 'La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.', '2025-06-03 00:00:00');
-- Usuario 11 calificó con 2 estrella(s): La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 11, 2, 'La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.', '2025-06-08 00:00:00');
-- Usuario 12 calificó con 2 estrella(s): Hubo intención, pero la experiencia generó desequilibrio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 12, 2, 'Hubo intención, pero la experiencia generó desequilibrio.', '2025-05-13 00:00:00');
-- Usuario 13 calificó con 5 estrella(s): Conexión auténtica, cuidado y propósito compartido.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 13, 5, 'Conexión auténtica, cuidado y propósito compartido.', '2025-07-01 00:00:00');
-- Usuario 14 calificó con 2 estrella(s): Hubo intención, pero la experiencia generó desequilibrio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 14, 2, 'Hubo intención, pero la experiencia generó desequilibrio.', '2025-05-23 00:00:00');
-- Usuario 15 calificó con 1 estrella(s): Falta total de conexión, experiencia negativa que rompió la armonía.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 15, 1, 'Falta total de conexión, experiencia negativa que rompió la armonía.', '2025-05-13 00:00:00');
-- Usuario 16 calificó con 2 estrella(s): Hubo intención, pero la experiencia generó desequilibrio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 16, 2, 'Hubo intención, pero la experiencia generó desequilibrio.', '2025-07-16 00:00:00');
-- Usuario 17 calificó con 3 estrella(s): Interacción funcional pero sin fortalecer el tejido comunitario.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 17, 3, 'Interacción funcional pero sin fortalecer el tejido comunitario.', '2025-06-25 00:00:00');
-- Usuario 18 calificó con 2 estrella(s): La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 18, 2, 'La relación no fluyó con respeto ni calidez, se alejó del suma kawsay.', '2025-07-30 00:00:00');
-- Usuario 19 calificó con 4 estrella(s): Relación con respeto, escucha y buena intención de servicio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 19, 4, 'Relación con respeto, escucha y buena intención de servicio.', '2025-05-01 00:00:00');
-- Usuario 20 calificó con 4 estrella(s): Relación con respeto, escucha y buena intención de servicio.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 20, 4, 'Relación con respeto, escucha y buena intención de servicio.', '2025-06-25 00:00:00');
-- Usuario 21 calificó con 1 estrella(s): El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 21, 1, 'El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.', '2025-06-25 00:00:00');
-- Usuario 22 calificó con 3 estrella(s): Interacción funcional pero sin fortalecer el tejido comunitario.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 22, 3, 'Interacción funcional pero sin fortalecer el tejido comunitario.', '2025-06-29 00:00:00');
-- Usuario 23 calificó con 1 estrella(s): El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.
INSERT INTO rating_movement_business (business_id, reviewer_id, stars, comment, created_at)
VALUES (1, 23, 1, 'El servicio careció de reciprocidad. No hubo equilibrio ni respeto a la comunidad.', '2025-07-13 00:00:00');

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
