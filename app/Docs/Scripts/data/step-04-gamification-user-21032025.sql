SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

TRUNCATE TABLE account_gamification;
TRUNCATE TABLE account_gamification_by_movement;
TRUNCATE TABLE account_gamification_movement_by_business;
TRUNCATE TABLE gaminification_by_log_customers;

-- Paso 1: Crear o asegurar cuenta del usuario en la tabla de gamificación
INSERT INTO account_gamification (id, user_id, balance_available_bee, balance_available_queen, created_at, updated_at)
VALUES (1, 1, 0, 0, NOW(), NOW());

-- Paso 2: Insertar movimientos CLIENTE_A_EMPRESA (procesos 163–174)
-- Paso 1: Insertar movimientos CLIENTE_A_EMPRESA (IDs 163–174)
-- CLIENTE_A_EMPRESA
INSERT INTO account_gamification_by_movement (id, account_gamification_id, amount, type, input_movement,
                                              gamification_by_process_id, type_money, description, created_at,
                                              updated_at)
VALUES (1, 1, 100.0, 1, 0, 163, 'bee', 'Donó puntos a empresa', NOW(), NOW()),
       (2, 1, 100.0, 1, 0, 164, 'bee', 'Participó en campaña solidaria', NOW(), NOW()),
       (3, 1, 100.0, 0, 1, 165, 'bee', 'Valoró positivamente a empresa', NOW(), NOW()),
       (4, 1, 100.0, 0, 1, 166, 'bee', 'Comentó producto de empresa', NOW(), NOW()),
       (5, 1, 100.0, 0, 1, 167, 'bee', 'Compartió empresa en redes', NOW(), NOW()),
       (6, 1, 100.0, 1, 0, 168, 'bee', 'Contribuyó en reto de empresa', NOW(), NOW()),
       (7, 1, 100.0, 0, 1, 169, 'bee', 'Subió contenido en campaña', NOW(), NOW()),
       (8, 1, 100.0, 0, 1, 170, 'bee', 'Propuso mejora a empresa', NOW(), NOW()),
       (9, 1, 100.0, 1, 0, 171, 'bee', 'Apoyó evento de empresa', NOW(), NOW()),
       (10, 1, 100.0, 0, 1, 172, 'bee', 'Sugirió empresa a otros', NOW(), NOW()),
       (11, 1, 100.0, 0, 1, 173, 'bee', 'Publicó testimonio de empresa', NOW(), NOW()),
       (12, 1, 100.0, 0, 1, 174, 'bee', 'Se unió a grupo de fidelización', NOW(), NOW());

-- EMPRESA_A_CLIENTE (todos INPUT = 1, tipo = 0)
INSERT INTO account_gamification_by_movement (id, account_gamification_id, amount, type, input_movement,
                                              gamification_by_process_id, type_money, description, created_at,
                                              updated_at)
VALUES (13, 1, 100.0, 0, 1, 175, 'bee', 'Premió fidelidad del cliente', NOW(), NOW()),
       (14, 1, 100.0, 0, 1, 176, 'bee', 'Bonificó al cliente por referidos', NOW(), NOW()),
       (15, 1, 100.0, 0, 1, 177, 'bee', 'Reconoció participación del cliente', NOW(), NOW()),
       (16, 1, 100.0, 0, 1, 178, 'bee', 'Otorgó puntos por encuestas', NOW(), NOW()),
       (17, 1, 100.0, 0, 1, 179, 'bee', 'Bonificó compras recientes', NOW(), NOW()),
       (18, 1, 100.0, 0, 1, 180, 'bee', 'Premió feedback constructivo', NOW(), NOW()),
       (19, 1, 100.0, 0, 1, 181, 'bee', 'Activó bono de bienvenida', NOW(), NOW()),
       (20, 1, 100.0, 0, 1, 182, 'bee', 'Recompensó colaboración del cliente', NOW(), NOW()),
       (21, 1, 100.0, 0, 1, 183, 'bee', 'Agradeció comentarios útiles', NOW(), NOW()),
       (22, 1, 100.0, 0, 1, 184, 'bee', 'Otorgó puntos por asistencia a evento', NOW(), NOW()),
       (23, 1, 100.0, 0, 1, 185, 'bee', 'Premió uso de cupones', NOW(), NOW()),
       (24, 1, 100.0, 0, 1, 186, 'bee', 'Activó logro especial', NOW(), NOW());
-- Paso 4: Actualizar el saldo total de puntos (opcional)
UPDATE account_gamification
SET balance_available_bee = (SELECT IFNULL(SUM(
                                               CASE
                                                   WHEN type IN (0, 3, 4) THEN amount
                                                   WHEN type IN (1, 2) THEN -amount
                                                   ELSE 0
                                                   END
                                               ), 0)
                             FROM account_gamification_by_movement
                             WHERE account_gamification_id = 1
                               AND type_money = 'bee')
WHERE id = 1;
INSERT INTO social_follow_summary (user_id,
                                   followers,
                                   following,
                                   business_following,
                                   created_at,
                                   updated_at)
VALUES (1, -- user_id
        0, -- aún nadie lo sigue
        0, -- aún no sigue a otros clientes
        1, -- sigue a 1 empresa
        NOW(),
        NOW());
INSERT INTO social_follow_movement (manager_id,
                                    type_process,
                                    input_movement,
                                    is_active,
                                    gamification_by_process_id,
                                    description,
                                    created_at,
                                    updated_at,
                                    social_follow_summary_id)
VALUES (1, -- manager_id: el usuario 1 realiza la acción
        2, -- tipo de proceso: 2 = cliente a empresa
        1, -- dirección: 1 = seguir
        1, -- activo
        162, -- ejemplo: ID del proceso de gamificación si aplica (verifica en tu tabla)
        'El usuario siguió a la empresa 1 por interés en sus productos.',
        NOW(),
        NOW(),
        1 -- ID del resumen (social_follow_summary.id)
       );



INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 2, 2, 'Me atendieron, pero sin calidez ni claridad.', '2024-07-16 00:00:00', '2024-07-16 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 3, 4, 'Muy buena atención, sentí conexión y profesionalismo.', '2024-07-12 00:00:00', '2024-07-12 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 4, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-04-19 00:00:00', '2025-04-19 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 5, 1, 'No hubo atención ni respeto. No volvería a interactuar.', '2024-11-11 00:00:00',
        '2024-11-11 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 6, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-03-11 00:00:00', '2025-03-11 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 7, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-06-09 00:00:00', '2025-06-09 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 8, 3, 'Todo fue normal, nada destacable.', '2024-11-07 00:00:00', '2024-11-07 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 9, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-07-04 00:00:00', '2025-07-04 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 10, 4, 'Muy buena atención, sentí conexión y profesionalismo.', '2024-08-23 00:00:00',
        '2024-08-23 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 11, 4, 'Muy buena atención, sentí conexión y profesionalismo.', '2024-09-04 00:00:00',
        '2024-09-04 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 12, 3, 'Todo fue normal, nada destacable.', '2024-12-24 00:00:00', '2024-12-24 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 13, 5, 'Excelente trato, muy humana la experiencia. ¡Gracias!', '2025-07-01 00:00:00',
        '2025-07-01 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 14, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-07-01 00:00:00', '2025-07-01 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 15, 1, 'No hubo atención ni respeto. No volvería a interactuar.', '2024-10-31 00:00:00',
        '2024-10-31 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 16, 3, 'Todo fue normal, nada destacable.', '2025-07-17 00:00:00', '2025-07-17 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 17, 2, 'Me atendieron, pero sin calidez ni claridad.', '2025-02-11 00:00:00', '2025-02-11 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 18, 1, 'No hubo atención ni respeto. No volvería a interactuar.', '2024-09-25 00:00:00',
        '2024-09-25 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 19, 5, 'Excelente trato, muy humana la experiencia. ¡Gracias!', '2024-08-26 00:00:00',
        '2024-08-26 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 20, 2, 'Me atendieron, pero sin calidez ni claridad.', '2024-05-27 00:00:00', '2024-05-27 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 21, 3, 'Todo fue normal, nada destacable.', '2024-09-29 00:00:00', '2024-09-29 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 22, 3, 'Todo fue normal, nada destacable.', '2024-09-16 00:00:00', '2024-09-16 00:00:00');
INSERT INTO rating_movement_client (user_id, reviewer_id, stars, comment, created_at, updated_at)
VALUES (1, 23, 5, 'Excelente trato, muy humana la experiencia. ¡Gracias!', '2024-07-28 00:00:00',
        '2024-07-28 00:00:00');
SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
