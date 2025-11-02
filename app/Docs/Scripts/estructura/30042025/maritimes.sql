SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

CREATE TABLE maritime_departures
(
    id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id        INT UNSIGNED NOT NULL,
    user_id            INT UNSIGNED NOT NULL,
    user_management_id INT UNSIGNED NULL,
    arrival_time       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    responsible_name   VARCHAR(255) NOT NULL,
    created_at         TIMESTAMP NULL DEFAULT NULL,
    updated_at         TIMESTAMP NULL DEFAULT NULL,
    status             ENUM('DRAFT', 'CONFIRMED', 'CANCELLED') NOT NULL DEFAULT 'DRAFT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maritime_departures_customers
(
    id                     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    maritime_departures_id INT UNSIGNED NOT NULL,
    type                   ENUM('ADULT', 'CHILD') NOT NULL,
    age                    INT NOT NULL,
    customer_id            INT NOT NULL,
    created_at             TIMESTAMP NULL DEFAULT NULL,
    updated_at             TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_maritime_departures_id FOREIGN KEY (maritime_departures_id) REFERENCES maritime_departures (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
