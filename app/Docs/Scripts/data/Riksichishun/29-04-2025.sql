SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";
/*------------------------------------DICTIONARY-------------------------------------*/

INSERT INTO `dictionary_grammatical_class` (`id`, `name`, `description`, `status`)
VALUES (1, 'Sustantivo', 'Palabras que nombran personas, animales, cosas, lugares, ideas o conceptos.', 'ACTIVE'),
       (2, 'Verbo', 'Palabras que indican acciones, estados o procesos.', 'ACTIVE'),
       (3, 'Adjetivo', 'Palabras que califican o determinan a los sustantivos.', 'ACTIVE'),
       (4, 'Adverbio', 'Palabras que modifican a un verbo, adjetivo u otro adverbio.', 'ACTIVE'),
       (5, 'Pronombre', 'Palabras que sustituyen a un sustantivo.', 'ACTIVE'),
       (6, 'Artículo', 'Palabras que determinan al sustantivo (el, la, los, las, un, una).', 'ACTIVE'),
       (7, 'Preposición', 'Palabras que relacionan palabras o frases indicando origen, destino, lugar, tiempo, etc.',
        'ACTIVE'),
       (8, 'Conjunción', 'Palabras que enlazan oraciones o palabras.', 'ACTIVE'),
       (9, 'Interjección', 'Palabras que expresan emociones o sentimientos espontáneos.', 'ACTIVE'),
       (10, 'Determinante', 'Palabras que acompañan al sustantivo para precisar su significado (este, mi, algún).',
        'ACTIVE'),
       (11, 'Numeral', 'Palabras que expresan cantidad o el orden de los elementos.', 'ACTIVE'),
       (12, 'Partícula', 'Palabras funcionales como "sí", "no", "también".', 'ACTIVE'),
       (13, 'Auxiliar verbal', 'Verbos que se usan junto a otro verbo para formar tiempos compuestos.', 'ACTIVE');

INSERT INTO `dictionary_grammatical_class_translation`
(`id`, `dictionary_grammatical_class_id`, `language_id`, `name`, `description`, `status`)
VALUES
-- Sustantivo
(1, 1, 3, 'Sustantivo', 'Palabras que nombran personas, animales, cosas, lugares, ideas o conceptos.', 'ACTIVE'),
(2, 1, 1, 'Noun', 'Words that name people, animals, things, places, or ideas.', 'ACTIVE'),
(3, 1, 2, 'Shimikuna', 'Shimikuna rikuchin runakuna, allpakuna, uyaykuna, kikinkuna.', 'ACTIVE'),

-- Verbo
(4, 2, 3, 'Verbo', 'Palabras que indican acciones, estados o procesos.', 'ACTIVE'),
(5, 2, 1, 'Verb', 'Words that express actions, states or processes.', 'ACTIVE'),
(6, 2, 2, 'Rimakuna', 'Rimakuna rikuchin ruraykuna, kanaykuna, kuyaykuna.', 'ACTIVE'),

-- Adjetivo
(7, 3, 3, 'Adjetivo', 'Palabras que califican o determinan a los sustantivos.', 'ACTIVE'),
(8, 3, 1, 'Adjective', 'Words that describe or qualify nouns.', 'ACTIVE'),
(9, 3, 2, 'Kawsaykuna kawsari', 'Kawsaykuna chaykuna shimikunata rikuchin.', 'ACTIVE'),

-- Adverbio
(10, 4, 3, 'Adverbio', 'Palabras que modifican a un verbo, adjetivo u otro adverbio.', 'ACTIVE'),
(11, 4, 1, 'Adverb', 'Words that modify verbs, adjectives, or other adverbs.', 'ACTIVE'),
(12, 4, 2, 'Yachakuy chaymana', 'Yachakuykunata, ruraykuna chaymanata chay.', 'ACTIVE'),

-- Pronombre
(13, 5, 3, 'Pronombre', 'Palabras que sustituyen a un sustantivo.', 'ACTIVE'),
(14, 5, 1, 'Pronoun', 'Words that replace a noun.', 'ACTIVE'),
(15, 5, 2, 'Paykuna', 'Ñukaka, kan, pay - shimikunata wakinkuna yuyachin.', 'ACTIVE'),

-- Artículo (no existe en kichwa)
(16, 6, 3, 'Artículo', 'Palabras que determinan al sustantivo.', 'ACTIVE'),
(17, 6, 1, 'Article', 'Words like "the", "a", "an".', 'ACTIVE'),
(18, 6, 2, '', 'Mana kawsan Kichwa shimipi. (No existe en kichwa)', 'ACTIVE'),

-- Preposición (como sufijos en kichwa)
(19, 7, 3, 'Preposición', 'Palabras que relacionan palabras o frases indicando lugar, tiempo, origen.', 'ACTIVE'),
(20, 7, 1, 'Preposition', 'Words that show relationships: in, on, to, from.', 'ACTIVE'),
(21, 7, 2, 'Sufijokuna', 'Chaykuna "-pi", "-manta", "-kama" rikuchin shimikunawan chay mana shimipi.', 'ACTIVE'),

-- Conjunción
(22, 8, 3, 'Conjunción', 'Palabras que enlazan oraciones o palabras.', 'ACTIVE'),
(23, 8, 1, 'Conjunction', 'Words that join words or sentences.', 'ACTIVE'),
(24, 8, 2, 'Yuyaykuna wakinkuna', 'Mana shimikuna. Kichwapim conjunciónka mashi yuyachik kan.', 'ACTIVE'),

-- Interjección
(25, 9, 3, 'Interjección', 'Palabras que expresan emociones o sentimientos espontáneos.', 'ACTIVE'),
(26, 9, 1, 'Interjection', 'Words that express emotions or spontaneous reactions.', 'ACTIVE'),
(27, 9, 2, 'Achachaw', 'Wakinkuna shimipi: “¡achachaw!”, “¡ayayay!”, etc.', 'ACTIVE'),

-- Determinante
(28, 10, 3, 'Determinante', 'Palabras que acompañan al sustantivo para precisar su significado.', 'ACTIVE'),
(29, 10, 1, 'Determiner', 'Words that limit or specify nouns.', 'ACTIVE'),
(30, 10, 2, 'Kikinchik mana kan', 'Kikinchik shimikunapi mana yuyaykuna riksishka.', 'ACTIVE'),

-- Numeral
(31, 11, 3, 'Numeral', 'Palabras que expresan cantidad u orden.', 'ACTIVE'),
(32, 11, 1, 'Numeral', 'Words that indicate number or order.', 'ACTIVE'),
(33, 11, 2, 'Yupaykuna', 'Shimikuna: shuk, iskay, kimsa, ñukanchik yupayta rikuchin.', 'ACTIVE'),

-- Partícula
(34, 12, 3, 'Partícula', 'Palabras funcionales como "sí", "no", "también".', 'ACTIVE'),
(35, 12, 1, 'Particle', 'Functional words: yes, no, also.', 'ACTIVE'),
(36, 12, 2, 'Yuyana shimita', 'Shimikuna mana chaykuna ruraykuna, shinallatak riksiykuna.', 'ACTIVE'),

-- Auxiliar verbal
(37, 13, 3, 'Auxiliar verbal', 'Verbos que ayudan a otros verbos a formar tiempos compuestos.', 'ACTIVE'),
(38, 13, 1, 'Auxiliary verb', 'Verbs used with other verbs to form complex tenses.', 'ACTIVE'),
(39, 13, 2, 'Yanapak rimakuna', 'Yanapana rimakuna rurayta rikuchin: kani, shina.', 'ACTIVE');

INSERT INTO `dictionary_language` (`id`, `value`, `description`, `status`, `from_language_id`,
                                   `to_language_id`)
VALUES (1, 'Kichwa - Castellano', 'Kichwa - Castellano', 'ACTIVE', 2, 3),
       (2, 'Castellano-Kichwa', 'Castellano-Kichwa', 'ACTIVE', 3, 2);







SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
