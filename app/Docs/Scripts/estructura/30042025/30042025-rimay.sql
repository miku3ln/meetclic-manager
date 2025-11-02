-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2024 at 01:35 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.17

SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

CREATE TABLE `dictionary_grammatical_class_translation`
(
    `id`                              INT          NOT NULL,
    `dictionary_grammatical_class_id` INT          NOT NULL,
    `language_id`                     INT          NOT NULL, -- FK a tabla `language`
    `name`                            VARCHAR(100) NOT NULL,
    `description`                     TEXT,
    `status`                          ENUM('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
);
CREATE TABLE `dictionary_grammatical_class`
(
    `id`          INT                                                          NOT NULL,
    `name`        VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `status`      ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dictionary_words_by_pronunciation`
(
    `id`                     INT                                                           NOT NULL,
    `dictionary_by_words_id` INT                                                           NOT NULL,
    `phonetic_value`         VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `notation_type`          VARCHAR(50) DEFAULT 'custom', -- ejemplo: 'AFI', 'regional', 'didactic',
    `notation_type_write_form`          VARCHAR(50) DEFAULT 'custom', -- ejemplo: 'AFI', 'regional', 'didactic',
    `value_written_form`         VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `status`                 ENUM('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
);
CREATE TABLE `dictionary_word_by_class`
(
    `id`                              INT NOT NULL,
    `dictionary_by_words_id`          INT NOT NULL,
    `dictionary_grammatical_class_id` INT NOT NULL
);

CREATE TABLE `dictionary_by_words`
(
    `id`                      INT                                                           NOT NULL,
    `value`                   VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `description`             TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `status`                  ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `diccionary_language_id`  INT                                                           NOT NULL,
    `letters_of_the_alphabet` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL,
    `translation_value`       TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `phonetic`                VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
    `usage_context`           TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `dictionary_language`
(
    `id`               int          NOT NULL,
    `value`            varchar(150) NOT NULL,
    `description`      text,
    `status`           enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `from_language_id` int          NOT NULL,
    `to_language_id`   int          NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_words_by_audio`
--

CREATE TABLE `dictionary_words_by_audio`
(
    `id`                     int          NOT NULL,
    `value`                  varchar(150) NOT NULL,
    `description`            text,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `dictionary_by_words_id` int          NOT NULL,
    `source`                 text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_words_by_examples`
--

CREATE TABLE `dictionary_words_by_examples`
(
    `id`                     int          NOT NULL,
    `value`                  varchar(150) NOT NULL,
    `description`            text,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `dictionary_by_words_id` int          NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



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

-- --------------------------------------------------------

--
-- Table structure for table `language_course_section_by_dictionary_words`
--

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


CREATE TABLE `dictionary_words_by_photo`
(
    `id`                     int          NOT NULL,
    `value`                  varchar(150) NOT NULL,
    `description`            text,
    `status`                 enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    `dictionary_by_words_id` int          NOT NULL,
    `source`                 text         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- =====================
-- 1. Claves primarias y AUTO_INCREMENT
-- =====================

ALTER TABLE `dictionary_grammatical_class`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_grammatical_class_translation`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_words_by_pronunciation`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_word_by_class`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_by_words`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_language`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_words_by_audio`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_words_by_examples`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

ALTER TABLE `dictionary_words_by_photo`
    MODIFY `id` INT NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (`id`);

-- =====================
-- 2. Índices secundarios requeridos (para claves foráneas)
-- =====================

ALTER TABLE `dictionary_by_words`
    ADD KEY `fk_diccionary_by_words_diccionary_language1_idx` (`diccionary_language_id`);

ALTER TABLE `dictionary_grammatical_class_translation`
    ADD KEY `fk_translation_class_idx` (`dictionary_grammatical_class_id`),
    ADD KEY `fk_translation_language_idx` (`language_id`);

ALTER TABLE `dictionary_words_by_pronunciation`
    ADD KEY `fk_pronunciation_word_idx` (`dictionary_by_words_id`);

ALTER TABLE `dictionary_word_by_class`
    ADD KEY `fk_word_by_class_word_idx` (`dictionary_by_words_id`),
    ADD KEY `fk_word_by_class_class_idx` (`dictionary_grammatical_class_id`);

ALTER TABLE `dictionary_words_by_audio`
    ADD KEY `fk_audio_word_idx` (`dictionary_by_words_id`);

ALTER TABLE `dictionary_words_by_examples`
    ADD KEY `fk_example_word_idx` (`dictionary_by_words_id`);

ALTER TABLE `dictionary_words_by_photo`
    ADD KEY `fk_photo_word_idx` (`dictionary_by_words_id`);

-- =====================
-- 3. Relaciones (FOREIGN KEY)
-- =====================

-- Relaciones en dictionary_by_words
ALTER TABLE `dictionary_by_words`
    ADD CONSTRAINT `fk_diccionary_by_words_diccionary_language1`
        FOREIGN KEY (`diccionary_language_id`) REFERENCES `dictionary_language` (`id`);

-- Relaciones de traducciones de clases gramaticales
ALTER TABLE `dictionary_grammatical_class_translation`
    ADD CONSTRAINT `fk_translation_class`
        FOREIGN KEY (`dictionary_grammatical_class_id`) REFERENCES `dictionary_grammatical_class` (`id`),
    ADD CONSTRAINT `fk_translation_language`
        FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

-- Relaciones de pronunciaciones
ALTER TABLE `dictionary_words_by_pronunciation`
    ADD CONSTRAINT `fk_pronunciation_word`
        FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

-- Relaciones de clasificación de palabra
ALTER TABLE `dictionary_word_by_class`
    ADD CONSTRAINT `fk_word_by_class_word`
        FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`),
    ADD CONSTRAINT `fk_word_by_class_class`
        FOREIGN KEY (`dictionary_grammatical_class_id`) REFERENCES `dictionary_grammatical_class` (`id`);

-- Relaciones para audios
ALTER TABLE `dictionary_words_by_audio`
    ADD CONSTRAINT `fk_dictionary_by_audio_word`
        FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

-- Relaciones para ejemplos
ALTER TABLE `dictionary_words_by_examples`
    ADD CONSTRAINT `fk_dictionary_words_by_examples_word`
        FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);

-- Relaciones para fotos
ALTER TABLE `dictionary_words_by_photo`
    ADD CONSTRAINT `fk_dictionary_words_by_photo_word`
        FOREIGN KEY (`dictionary_by_words_id`) REFERENCES `dictionary_by_words` (`id`);


SET

FOREIGN_KEY_CHECKS=1;
COMMIT;

