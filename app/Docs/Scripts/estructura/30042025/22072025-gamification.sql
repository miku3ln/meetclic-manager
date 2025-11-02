SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";
ALTER TABLE gamification_by_process
    ADD COLUMN valid_from DATETIME NULL AFTER state,
ADD COLUMN valid_until DATETIME NULL AFTER valid_from,
ADD COLUMN expiration_type ENUM('NONE', 'HOURS', 'DAYS', 'DATE') NOT NULL DEFAULT 'NONE' AFTER valid_until,
ADD COLUMN expiration_value INT NULL COMMENT 'Cantidad según expiration_type' AFTER expiration_type,
ADD COLUMN frequency_limit_type ENUM('NONE', 'ONCE', 'DAILY', 'WEEKLY', 'MONTHLY', 'TOTAL_LIMIT') NOT NULL DEFAULT 'NONE' AFTER expiration_value,
ADD COLUMN frequency_limit_value INT NULL COMMENT 'Si frequency_limit_type=TOTAL_LIMIT, cantidad máxima permitida' AFTER frequency_limit_type,
ADD COLUMN is_repetitive TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Repetible, 0=Solo una vez' AFTER frequency_limit_value,
ADD COLUMN max_times_per_user INT NULL COMMENT 'Si no es NULL, máximo de veces por usuario' AFTER is_repetitive;


-- ✅ Añadir caducidad de puntos entregados en los movimientos

ALTER TABLE account_gamification_by_movement
    ADD COLUMN expire_at DATETIME NULL COMMENT 'Fecha en que expiran los puntos otorgados' AFTER description;
ALTER TABLE account_gamification_by_movement_business
    ADD COLUMN expire_at DATETIME NULL COMMENT 'Fecha en que expiran los puntos otorgados' AFTER description;

-- ✅ (Opcional) Crear tabla de tracking de tareas asignadas / pendientes / expiradas

DROP TABLE IF EXISTS gamification_by_process_tracking;

CREATE TABLE gamification_by_process_tracking
(
    id                         INT AUTO_INCREMENT PRIMARY KEY,
    gamification_by_process_id INT NOT NULL,
    max_uses_per_user          INT NOT NULL DEFAULT 0 COMMENT '0 = sin límite por usuario',
    expiration_type            ENUM('NONE', 'DAILY', 'WEEKLY', 'MONTHLY') NOT NULL DEFAULT 'NONE',
    start_date                 DATE         DEFAULT NULL,
    end_date                   DATE         DEFAULT NULL,
    state                      ENUM('ACTIVE', 'INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    created_at                 TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at                 TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `account_gamification_by_movement_business`
(
    `id`                         int(11) NOT NULL,
    `created_at`                 timestamp NULL DEFAULT NULL,
    `updated_at`                 timestamp NULL DEFAULT NULL,
    `deleted_at`                 timestamp NULL DEFAULT NULL,
    `account_gamification_id`    int(11) NOT NULL,
    `amount`                     int(11) NOT NULL,
    `type`                       int(11) NOT NULL COMMENT '0=Cash or check deposit(DE) - I\n1= Cash withdrawal(EX)-O\n2=Banking expenses(GB)-O\n3=Collection of card coupons(CC)-I\n4=Negotiated checks(NE)-I\n',
    `input_movement`             int(11) NOT NULL COMMENT '0=OUTPUT\n1=INPUT',
    `description`                text NOT NULL,
    `user_transaction_id`        int(11) NOT NULL COMMENT 'IT CAN BE A NULL ID ONLY IF IT IS OWN OF THE SYSTEM AND IT IS DONE X BEEHIVE',
    `type_money`                 int(11) NOT NULL DEFAULT 0 COMMENT '0=BEE\n1=QUEEN',
    `gamification_by_process_id` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


ALTER TABLE `account_gamification_by_movement_business`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_by_movement_account_gamification1_idx_business` (`account_gamification_id`);
ALTER TABLE `account_gamification_by_movement_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `account_gamification_by_movement_business`
    ADD CONSTRAINT `fk_account_by_movement_account_gamification1_business` FOREIGN KEY (`account_gamification_id`) REFERENCES `account_gamification_business` (`id`);



CREATE TABLE `account_gamification_business`
(
    `id`                      int(11) NOT NULL,
    `created_at`              timestamp NULL DEFAULT NULL,
    `updated_at`              timestamp NULL DEFAULT NULL,
    `deleted_at`              timestamp NULL DEFAULT NULL,
    `business_id`             int(11) NOT NULL,
    `balance_available_bee`   int(11) NOT NULL,
    `balance_available_queen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `account_gamification_business`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `account_gamification_business`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `account_gamification_by_movement`
    ADD COLUMN `related_entity_id` INT(11) NULL COMMENT 'ID de la empresa o usuario con quien se relaciona el movimiento',
  ADD COLUMN `related_entity_type` ENUM('USER', 'BUSINESS', 'SYSTEM') NOT NULL DEFAULT 'USER' COMMENT 'Tipo de entidad relacionada';

ALTER TABLE `account_gamification_by_movement_business`
    ADD COLUMN `related_entity_id` INT(11) NULL COMMENT 'ID del cliente, empresa u origen externo',
  ADD COLUMN `related_entity_type` ENUM('USER', 'BUSINESS', 'SYSTEM') NOT NULL DEFAULT 'BUSINESS' COMMENT 'Tipo de entidad relacionada';


CREATE TABLE reputation_movement_client
(
    id                         INT AUTO_INCREMENT PRIMARY KEY,
    account_gamification_id    INT     NOT NULL,
    user_id                    INT     NOT NULL, -- quien hizo el cambio (cliente, admin, etc.)
    gamification_by_process_id INT,              -- si aplica
    description                VARCHAR(255),
    type                       TINYINT NOT NULL, -- 0 = input (gana), 1 = output (pierde)
    reputation_points          INT     NOT NULL,
    type_manager               ENUM('GAMIFICATION', 'ADMIN', 'SYSTEM', 'CLIENT_REPORT') DEFAULT 'GAMIFICATION',
    created_at                 DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at                 DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (account_gamification_id) REFERENCES account_gamification (id),
    FOREIGN KEY (gamification_by_process_id) REFERENCES gamification_by_process (id)
);

CREATE TABLE reputation_movement_business
(
    id                               INT AUTO_INCREMENT PRIMARY KEY,
    account_gamification_business_id INT     NOT NULL,
    user_id                          INT     NOT NULL, -- quien hizo el cambio (cliente, admin, etc.)
    gamification_by_process_id       INT,
    description                      VARCHAR(255),
    type                             TINYINT NOT NULL, -- 0 = input (gana), 1 = output (pierde)
    reputation_points                INT     NOT NULL,
    type_manager                     ENUM('GAMIFICATION', 'ADMIN', 'SYSTEM', 'CLIENT_REPORT') DEFAULT 'GAMIFICATION',
    created_at                       DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at                       DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (account_gamification_business_id) REFERENCES account_gamification_business (id),
    FOREIGN KEY (gamification_by_process_id) REFERENCES gamification_by_process (id)
);
ALTER TABLE reputation_movement_client
    MODIFY COLUMN type_manager TINYINT NOT NULL COMMENT '0 = salida, 1 = entrada';
ALTER TABLE reputation_movement_business
    MODIFY COLUMN type_manager TINYINT NOT NULL COMMENT '0 = salida, 1 = entrada';
ALTER TABLE reputation_movement_client
DROP
COLUMN type;
ALTER TABLE reputation_movement_business
DROP
COLUMN type;

CREATE TABLE rating_movement_client
(
    id                         INT AUTO_INCREMENT PRIMARY KEY,
    user_id                    INT NOT NULL, -- Cliente que recibe el rating
    reviewer_id                INT NOT NULL, -- Quién hizo la calificación
    stars                      INT NOT NULL, -- Valor: 1 a 5
    comment                    TEXT,         -- Comentario opcional
    gamification_by_process_id INT NULL,     -- Relación opcional con gamificación
    created_at                 DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at                 DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE rating_movement_business
(
    id                         INT AUTO_INCREMENT PRIMARY KEY,
    business_id                INT NOT NULL, -- Empresa que recibe el rating
    reviewer_id                INT NOT NULL, -- Quién hizo la calificación
    stars                      INT NOT NULL, -- Valor: 1 a 5
    comment                    TEXT,
    gamification_by_process_id INT NULL,     -- Relación opcional con gamificación
    created_at                 DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at                 DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE rating_scale_config
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    stars       INT NOT NULL UNIQUE, -- Valor de estrellas (ej: 1, 2, 3, 4, 5)
    label       VARCHAR(100),        -- Ej: "Muy Malo", "Bueno", "Excelente"
    description TEXT,                -- Explicación si hace falta
    color_hex   VARCHAR(10),         -- Color opcional para mostrar en UI
    active      TINYINT(1) DEFAULT 1
);


CREATE TABLE social_follow_movement
(
    id                         INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID único del movimiento de seguimiento',

    manager_id                 INT     NOT NULL COMMENT 'Usuario A QIEN SIGE ,qien l sige, a q empresa sige',
    type_process               TINYINT NOT NULL COMMENT 'Tipo de relación: 1 = cliente a cliente (mashikuna), 2 = cliente a empresa',
    input_movement             TINYINT(1) NOT NULL COMMENT 'Dirección del movimiento: 1 = seguir, 0 = dejar de seguir',
    is_active                  TINYINT(1) DEFAULT 1 COMMENT 'Estado del movimiento: 1 = activo, 0 = inactivo o revertido',
    gamification_by_process_id INT      DEFAULT NULL COMMENT 'Proceso de gamificación asociado, si aplica',
    description                VARCHAR(255) COMMENT 'Descripción del contexto o razón del seguimiento',
    created_at                 DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del movimiento',
    updated_at                 DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última actualización',
    social_follow_summary_id   INT     NOT NULL COMMENT 'ID del resumen asociado a este movimiento',
    CONSTRAINT fk_follow_summary FOREIGN KEY (social_follow_summary_id) REFERENCES social_follow_summary (id)


) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Historial de acciones de seguimiento entre usuarios y empresas';
CREATE TABLE social_follow_summary
(
    id                 INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID único del resumen de seguimiento',

    user_id            INT NOT NULL COMMENT 'ID del usuario que realiza los seguimientos',

    followers          INT      DEFAULT 0 COMMENT 'Número total de personas que siguen a este usuario',
    following          INT      DEFAULT 0 COMMENT 'Número total de personas que este usuario sigue (mashikuna)',
    business_following INT      DEFAULT 0 COMMENT 'Número de empresas que este usuario sigue',

    created_at         DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del resumen',
    updated_at         DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Última fecha de actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Resumen acumulado de relaciones sociales (seguimientos) para cada usuario';


SET
FOREIGN_KEY_CHECKS=1;
COMMIT;

