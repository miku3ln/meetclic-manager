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






INSERT INTO `dictionary_by_words` (`id`, `value`, `dictionary_grammatical_class_id`, `translation_value`, `description`,
                                   `status`, `diccionary_language_id`, `letters_of_the_alphabet`)
VALUES (1, 'yupaychana', '0', 'yupaychana', '<div class="word--description">             <span class="word--fonetic">[yupayčana]</span>              <p class="word--description">v. agradecer;
honrar. Shuk runa imatapash karakpi, sumak shimiwan rantipay.
Ñukata yanapashkamanta achkatami kan- taka yupaychani.
yupi</p>          </div>', 'ACTIVE', 1, '-'),
       (2, 'yura', '0', 'yura', '<div class="word--description">             <span class="word--fonetic">[yura, yula, ruya]</span>              <p class="word--description">s. árbol, mata, planta, vegetal. Pankakunata charik kirukuna.
Kishwar llullu yurata tarpurkani.
yurak</p>          </div>', 'ACTIVE', 1, '-'),
       (3, 'shunku', '0', 'shunku', '<div class="word--description">             <span class="word--fonetic">[yurak šunku]</span>              <p class="word--description">s. pulmón. Kawsakkunaman samayta chaskik.
Yurak shunkupi chiri ama yaykuchunka washata allitapacha killpanchik.
Sin. paruk, surkan.
yurimawas</p>          </div>', 'ACTIVE', 1, '-'),
       (4, 'yutsu', '0', 'yutsu', '<div class="word--description">             <span class="word--fonetic">[yutsu]</span>              <p class="word--description">s. amz. árbol de corteza me- dicinal. Shuk ñañu pankayuk sumakta sisak, yaku manñapi wiñak raku yura, karaka ham- pimi kan.
Yutsupa karawanmi hampirkani.
yutu</p>          </div>', 'ACTIVE', 1, '-'),
       (5, 'yuturi', '0', 'yuturi', '<div class="word--description">             <span class="word--fonetic">[yuturi, yutsuri]</span>              <p class="word--description">s. amz. hormiga conga. Hatun, yana, paypa sikipi tuksina sin- chi kashata charik, miyutapash charik añanku.
Mishki mikunapi yapatami yuturi wiwaka huntashka.
yuyak</p>          </div>', 'ACTIVE', 1, '-'),
       (6, 'yuyarina', '0', 'yuyarina', '<div class="word--description">             <span class="word--fonetic">[yuyarina, yarina]</span>              <p class="word--description">v. acordarse, re- cordar. Kunkashkakunata yuyaywan mas- kashpa kawsachina.
Ñukapa warmitaka karumanta yuyarini.
2.	estar pensativo. lmakunapipash yuyashpa tiyay.
Imashina shamuk wata llamkanata yuya- rirkanchik.
yuyay</p>          </div>', 'ACTIVE', 1, '-'),
       (7, 'yuyana', '0', 'yuyana', '<div class="word--description">             <span class="word--fonetic">[yuyana]</span>              <p class="word--description">v. pensar. Ama pantan-
kapak umawan taripashpa rurana.
Kan alli kashkamanta achkata yuyanki.
3.	suponer. Yuyarishpalla imatapash niy, rimay, rurana.
Paychari chaypi pakashka tantataka mikurka,
yuyani.
yuyaychinkana</p>          </div>', 'ACTIVE', 1, '-'),
       (8, 'yuyayyuk', '0', 'yuyayyuk', '<div class="word--description">             <span class="word--fonetic">[yuyayyux, yuyayux]</span>              <p class="word--description">s. amz. pensante. Imatapash taripashka kipa, yuya- rishka kipa rimak runa.
Yuyayyukka mana wawashina imatapash ri- manachu.

achachay</p>          </div>', 'ACTIVE', 1, '-'),
       (9, 'achachaw', '0', 'achachaw', '<div class="word--description">             <span class="word--fonetic">[ačačaw, ačučuy]</span>              <p class="word--description">interj. amz.
expresión de calor. Yapa rupay tiyakpi rimay.
achachaw, mikunaka rupakmi kashka. Sin. Araray, rupakuk.
achka</p>          </div>', 'ACTIVE', 1, '-'),
       (10, 'achik', '0', 'achik', '<div class="word--description">             <span class="word--fonetic">[ačix, ačig, ači]</span>              <p class="word--description">s. luz, claridad, claro.
Killamanta, intimanta, kuyllurmanta llukshik llipyarik; imatapash rikunkapak kak.
Tamya punchapika achikka mana rikurinchu. achiklla</p>          </div>', 'ACTIVE', 1, '-'),
       (11, 'achikmama', '0', 'achikmama', '<div class="word--description">             <span class="word--fonetic">[ačikmama, ačimama]</span>              <p class="word--description">s. S. madrina. Wawa shutirikukpi markak warmi. Achikmamaka achikwawamanka tantatami kamarin.
achikyana</p>          </div>', 'ACTIVE', 1, '-'),
       (12, 'achikyaya', '0', 'achikyaya', '<div class="word--description">             <span class="word--fonetic">[ačikyaya, ačiyaya]</span>              <p class="word--description">s. S. pa- drino. Wawata shutirikukpi markak kari.
Ñukaka, kay wawapa achikyayami kani. achillik-yaya</p>          </div>', 'ACTIVE', 1, '-'),
       (13, 'achira', '0', 'achira', '<div class="word--description">             <span class="word--fonetic">[ačira, ačera, atsira]</span>              <p class="word--description">s. achera. Pa-
pashina raku muyu, allpa ukupi pukuk mishki mikuna

Asha kunuklla allpapimi achirataka tarpun. achukcha</p>          </div>', 'ACTIVE', 1, '-'),
       (14, 'achupalla', '0', 'achupalla',
        '<div class="word--description">             <span class="word--fonetic">[ačupalya, ačupaža, ačupilya]</span>              <p class="word--description">s.s. achupalla. Kashayuk panka, uchilla cha- warshina, sunilla amuk pankayuk yura. Allpa saywapimi achupalla yurataka tarpuni. ahana</p>          </div>',
        'ACTIVE', 1, '-'),
       (15, 'akankaw', '0', 'akankaw', '<div class="word--description">             <span class="word--fonetic">[akaŋgaw, akaŋgu]</span>              <p class="word--description">s. amz. varie- dad de pava. Aw aw nishpa takik, yana pat- payuk, puka kunka hatun pishku.
Akankaw pishkuka sachapimi kawsan. akapana</p>          </div>', 'ACTIVE', 1, '-'),
       (16, 'akapana', '0', 'akapana', '<div class="word--description">             <span class="word--fonetic">[akapana]</span>              <p class="word--description">s. Júpiter. Intipa ayllupi tiyak rumpu.
akcha</p>          </div>', 'ACTIVE', 1, '-'),
       (17, 'shuwa', '0', 'shuwa', '<div class="word--description">             <span class="word--fonetic">[akča šuwa]</span>              <p class="word--description">s. s. libélula, cortapelos. Shuk chuya rikrayuk, yakupi ar- mak chillikshina rikurik.
Akchashuwaka larkapimi tiyan.
Sin. chikaru.
akichana</p>          </div>', 'ACTIVE', 1, '-'),
       (18, 'akirinri', '0', 'akirinri', '<div class="word--description">             <span class="word--fonetic">[axiriŋri, axiximbri, axikimbri]</span>              <p class="word--description">s. jen- gibre. Uchushina hayak, mishki ashnak, wiksa nanaypa, kunka nanaypa upyana hampi.

Kunka nanakpika akirinrita timpuchishpa up- yarka.
akllana</p>          </div>', 'ACTIVE', 1, '-'),
       (19, 'aklluna', '0', 'aklluna', '<div class="word--description">             <span class="word--fonetic">[axlyuna]</span>              <p class="word--description">v. tartamudear. Harkaris-
hpa harkarishpa mana alli rimana, wataris- hpa rimana.
Manuel wawaka manchaymanta akllurka. Sin. Harkarina, shimi-watarina.
akma</p>          </div>', 'ACTIVE', 1, '-'),
       (20, 'aknina', '0', 'aknina', '<div class="word--description">             <span class="word--fonetic">[agnina axnina, awnina]</span>              <p class="word--description">v. eructar. Mikushka, upyashka kipa shimimanta wayra llukshina.
Hayak aswata upyashpami payka aknirka.
2. dudar. Imatapash mana añishpashina, ma- nashina yuyay charina.
Kushipata rimashkata achkatami aknini.
Sin. akitana.
aksu</p>          </div>', 'ACTIVE', 1, '-'),
       (21, 'aktuna', '0', 'aktuna', '<div class="word--description">             <span class="word--fonetic">[axtuy]</span>              <p class="word--description">v. ss. escupir. Shimimanta tukata llukshichishpa shitana.
Yachana pachapika mana aktunichu. Sin. Tukana.
akuna</p>          </div>', 'ACTIVE', 1, '-'),
       (22, 'akwa', '0', 'akwa', '<div class="word--description">             <span class="word--fonetic">[akwa, axwa]</span>              <p class="word--description">s. amz. árbol de canelo. Mishkilla ashnak kaspi, sañu tullpuyuk kara yura.
Akwa karapa yakuta upyanaka allimi kan. akwas</p>          </div>', 'ACTIVE', 1, '-'),
       (23, 'ala', '0', 'ala', '<div class="word--description">             <span class="word--fonetic">[ala]</span>              <p class="word--description">s. amz. hongo. Sisashina, wanuku- napi, ismu kaspikunapi wiñak. Ismu kaspi- manta mikuna alata apamuni.
Sin. Kallampa.
alalay</p>          </div>', 'ACTIVE', 1, '-'),
       (24, 'alama', '0', 'alama', '<div class="word--description">             <span class="word--fonetic">[alama, ala]</span>              <p class="word--description">s. amz. Trato entre ami-
gos y compañeros. Antisuyu runakuna kari mashipura riksirinkapak rimay.
Ñukapa alamaka chuntata apamuni, nirka. alapana</p>          </div>', 'ACTIVE', 1, '-'),
       (25, 'allawka', '0', 'allawka', '<div class="word--description">             <span class="word--fonetic">[<*alyawka]</span>              <p class="word--description">s. lado derecho. Lluki chimpapi kak manya.
Wakin runakunaka allawka makiwan sinchi- tami llamkan.
Sin. Paña, alli.
allana</p>          </div>', 'ACTIVE', 1, '-'),
       (26, 'alli', '0', 'alli', '<div class="word--description">             <span class="word--fonetic">[alyi, aši, aži]</span>              <p class="word--description">adj. bueno, bien. Mana mi-
llay shunkuta charik, imatapash sumakmi kan ninkapak rimay.




Wakin mishukunallami alli shunkuyuk kan.
2. lado derecho. lluki manyapi tiyak. Wakinkunaka alli makiwan ñapash killkan. Sin. paña, allawka.
allichina</p>          </div>', 'ACTIVE', 1, '-'),
       (27, 'allikana', '0', 'allikana', '<div class="word--description">             <span class="word--fonetic">[alyikana, ažikana, alikana]</span>              <p class="word--description">s.
salud, bienestar. Mana unkuywan kana. Allikanata charinkapakka alli mikunatami mi- kuna kanchik.
allilla</p>          </div>', 'ACTIVE', 1, '-'),
       (28, 'allimanta', '0', 'allimanta', '<div class="word--description">             <span class="word--fonetic">[alyimaŋta, alimanda]</span>              <p class="word--description">adv. cuida-
dosamente, con cuidado, despacio, poco a poco. Imatapash ama pakirichun, mana sin- chita rurana.
Mankataka allimanta apamunki.
Sin. Allilla.
alliyana</p>          </div>', 'ACTIVE', 1, '-'),
       (29, 'allku', '0', 'allku', '<div class="word--description">             <span class="word--fonetic">[alyku, alku, ažku, ačku, ašku]</span>              <p class="word--description">s. perro. Runakunawan mashiyarishpa kawsak wiwa. Wasita kamachun nishpa piñak allkuta cha- rini.
allpa</p>          </div>', 'ACTIVE', 1, '-'),
       (30, 'allpaka', '0', 'allpaka', '<div class="word--description">             <span class="word--fonetic">[alypaka]</span>              <p class="word--description">s. alpaca, camélido an-dino. Puna suyupi kawsak, llamashina wiwa. Allpaka millmaka awankapakmi allipacha kan.
allpamama</p>          </div>', 'ACTIVE', 1, '-'),
       (31, 'allu', '0', 'allu', '<div class="word--description">             <span class="word--fonetic">[alyu]</span>              <p class="word--description">adj. amz. moho. Rupashka kaspi- kunapi, sara kuruntakunapi wiñak, puka uch- pashina.
Rupashka yantapika allumi rikurin.
2. s. amz. chicha de yuca asada. Kusashka lumukunamanta rurashka aswa.
Alluta rurankapak lumuta kusakuni.
Sin. Pula.
almayari</p>          </div>', 'ACTIVE', 1, '-'),
       (32, 'ama', '0', 'ama', '<div class="word--description">             <span class="word--fonetic">[ama]</span>              <p class="word--description">adv. no. Ima rurashkata harkan- kapak, sakichinkapak rimay.
Wasimanka ama rinkichu.
amakulu</p>          </div>', 'ACTIVE', 1, '-'),
       (33, 'amallatak', '0', 'amallatak', '<div class="word--description">             <span class="word--fonetic">[amalyatak]</span>              <p class="word--description">adv. sn. ni dios quiera. Mana munashka ama paktachun.
Amallatak yachashkata kunkarinkichu. Sin. amatak.
amankay</p>          </div>', 'ACTIVE', 1, '-'),
       (34, 'amapash', '0', 'amapash', '<div class="word--description">             <span class="word--fonetic">[amapaš, amapiš]</span>              <p class="word--description">adv. aunque no. Ama nikpipash imatapash ruray.
Paykuna amapash shamukpi ñuka rirkani. amarak</p>          </div>', 'ACTIVE', 1, '-'),
       (35, 'amaru', '0', 'amaru', '<div class="word--description">             <span class="word--fonetic">[amaru, amarun]</span>              <p class="word--description">s. boa. Tukuy ma- chakuymanta ashtawan yalli suni, runata, wi- watapash mikuklla, yakupipash sachapipash kawsak.
Ñukapa allkuta kunan puncha shuk


amatak</p>          </div>', 'ACTIVE', 1, '-'),
       (36, 'amawta', '0', 'amawta', '<div class="word--description">             <span class="word--fonetic">[amauta, amawtax]</span>              <p class="word--description">s. sabio, cien-
tífico del incario. Inkakuna kawsashka pa- chapi yuyaysapa runa, yalli yachak runa.
Tawantin	suyupika	achka	amawtami kawsarka.
Sin. Yachak.
aminta</p>          </div>', 'ACTIVE', 1, '-'),
       (37, 'amina', '0', 'amina', '<div class="word--description">             <span class="word--fonetic">[amina]</span>              <p class="word--description">v. hastiar, empalagar, hartar.
Ima mikunamanta, shukkunamantapash shaykuna.
Payka aswa upyanataka mana amirkachu. ampana</p>          </div>', 'ACTIVE', 1, '-'),
       (38, 'ampuku', '0', 'ampuku',
        '<div class="word--description">             <span class="word--fonetic">[aŋbuku]</span>              <p class="word--description">interj. expresión que de- nota ironía (no friegues). Pipash watukashpa asikpi yankami niwanki ninkapak rimay. Pay ñukata asikpimi ampuku nirkani. amsa</p>          </div>',
        'ACTIVE', 1, '-'),
       (39, 'amullina', '0', 'amullina', '<div class="word--description">             <span class="word--fonetic">[amulyina, amužina, amulina]</span>              <p class="word--description">v.
engullir; traer algo en la boca. Mikunata shimi ukuman kachana.
Amuklla sara kamchata amullini.
ana</p>          </div>', 'ACTIVE', 1, '-'),
       (40, 'anak', '0', 'anak', '<div class="word--description">             <span class="word--fonetic">[anak]</span>              <p class="word--description">adj. duro. Imapash sinchi kak.
Kay rumika anakmi kan.
Sin. Sinchi.
anaku</p>          </div>', 'ACTIVE', 1, '-'),
       (41, 'ananas', '0', 'ananas', '<div class="word--description">             <span class="word--fonetic">[ananas, anunas]</span>              <p class="word--description">s. amz. fruta si- milar a la chirimoya. Killu pukuk, mishki yurak mikunayuk muyu.
Ananas muyuta paktanarayku yuramanta ur- markani.
anchayana</p>          </div>', 'ACTIVE', 1, '-'),
       (42, 'anchuchina', '0', 'anchuchina', '<div class="word--description">             <span class="word--fonetic">[ančučina]</span>              <p class="word--description">v. quitar, mermar. Ima harkakunatapash shuktak kuskaman churana.
Antawa purichun ñanmanta rumita anchu- chirkani.
2.	restar. Achkamanta mashnatapash kichus- hka kipa mashna puchushkata yachana. Yalli kuykuna mirakpi katushpa anchuchini.
3.	s. resta. Achkamanta mashna puchus- hkata yupaykunawan yachay.
Kunanka anchuchiykunataka ñami yacha- kunchik.
Sin. suchuchina.
anchurina</p>          </div>', 'ACTIVE', 1, '-'),
       (43, 'anka', '0', 'anka', '<div class="word--description">             <span class="word--fonetic">[aŋga]</span>              <p class="word--description">s. ave de rapiña, águila. Chu- chita, urpita mikuk pawak hatun pishku.
Sisapa chuchita anka mikun.
ankara</p>          </div>', 'ACTIVE', 1, '-'),
       (44, 'ankas', '0', 'ankas', '<div class="word--description">             <span class="word--fonetic">[angas, aŋgaš]</span>              <p class="word--description">adj. azul. Hawapa- chashina rikurik tullpu.
Ñukanchikka ankas muchikutami charin- chik.
2.	adj. amz. pintón. Manarak pukushka mu- yukuna.
Kay pakayka chayrak ankasmi rikurin.




anku</p>          </div>', 'ACTIVE', 1, '-'),
       (45, 'ankulla', '0', 'ankulla', '<div class="word--description">             <span class="word--fonetic">[aŋgulya, aŋguža, angura]</span>              <p class="word--description">adj. cau- choso; enserenado. Kanchapi pakarichikpi asha llampuyashka.
Kay ukshaka ankulla pakarishka.
2. adj. medio mojado. Manarak alli chakiris- hka takshashkakuna.
Ankulla kaspika mana rupanchu. ankuyana</p>          </div>', 'ACTIVE', 1, '-'),
       (46, 'ansa', '0', 'ansa', '<div class="word--description">             <span class="word--fonetic">[aŋsa]</span>              <p class="word--description">det. sc. amz. poco. Ashalla, mana achka.
Ansa allpata charini.
Sin. asha.
anta</p>          </div>', 'ACTIVE', 1, '-'),
       (47, 'antawa', '0', 'antawa', '<div class="word--description">             <span class="word--fonetic">[aŋtawa, antawiwa]</span>              <p class="word--description">s. carro, vehì- culo. Antamanta rurashka, pirurushina chusku chakiyuk, runata, kipita aparik.
Tukuykuna antawapi shamunchik. Sin. Anta-chuna.
anti</p>          </div>', 'ACTIVE', 1, '-'),
       (48, 'suyu', '0', 'suyu', '<div class="word--description">             <span class="word--fonetic">[aŋtisuyu]</span>              <p class="word--description">s. región oriental del Tawantin suyu. Inkakunapa pachapi inti lluks- hina Cuzco llaktaman sakirik suyu.
Kanka Antisuyu markamantami kanki. Sin. inti suyu, sacha suyu.
antuchi</p>          </div>', 'ACTIVE', 1, '-'),
       (49, 'anku', '0', 'anku', '<div class="word--description">             <span class="word--fonetic">[añaŋgu, añiŋgu]</span>              <p class="word--description">s. hormiga. Usas- hina rumi ukupi, yurapi kawsak puka, yana uchilla wiwa.
Runakunaka añankushinami tantanakunchik. añañay</p>          </div>', 'ACTIVE', 1, '-'),
       (50, 'as', '0', 'as', '<div class="word--description">             <span class="word--fonetic">[añas, añaŋgu, añiŋgu]</span>              <p class="word--description">s. zorrillo. As- hnak aychayuk uchilla allkushina allpata allankapak tuta llukshirik.
Kay tuta añas ukata allashka.
apachi</p>          </div>', 'ACTIVE', 1, '-'),
       (51, 'apachina', '0', 'apachina', '<div class="word--description">             <span class="word--fonetic">[apačina]</span>              <p class="word--description">v. hacer cargar. Imaku-
natapash washapi churana.
Kurika yantatami wiwaman apachin. apamama</p>          </div>', 'ACTIVE', 1, '-'),
       (52, 'apamuna', '0', 'apamuna', '<div class="word--description">             <span class="word--fonetic">[apamuna]</span>              <p class="word--description">v. traer. Imatapash karumanta paktachimuna.
Juan mashika wakrata ¿ñachu apamurka? apankura</p>          </div>', 'ACTIVE', 1, '-'),
       (53, 'apapa', '0', 'apapa', '<div class="word--description">             <span class="word--fonetic">[apapa]</span>              <p class="word--description">s. amz. bùho negro de pecho amarillento. Uchpa tullpu millmayuk tutapi tun tun rikrata uyachik pishku.
Wawaka apapa wakakpilla ña mancharin.
Sin. Kukupa.
aparina</p>          </div>', 'ACTIVE', 1, '-'),
       (54, 'aparina', '0', 'aparina', '<div class="word--description">             <span class="word--fonetic">[aparina]</span>              <p class="word--description">v. cargar. Imatapash
waskawan watashpa washapi churay. Palantawan ashankataka llashak kakpimi mana aparirkani.
2. cargar frutos el árbol. Ima yurakunapash muyuyuk tukuk.
Shañu yuraka ñami aparishka.
apay</p>          </div>', 'ACTIVE', 1, '-'),
       (55, 'apana', '0', 'apana', '<div class="word--description">             <span class="word--fonetic">[apana]</span>              <p class="word--description">v. llevar. Imatapash kay- manta maymanpash yallichina.
Kay kamuta yachanawasiman apakunchik. api</p>          </div>', 'ACTIVE', 1, '-'),
       (56, 'apichu', '0', 'apichu', '<div class="word--description">             <span class="word--fonetic">[apiču]</span>              <p class="word--description">s. camote. Papashina allpa
ukupi pukuk.
Apichutaka ñuñuntin mikunchik.
Sin. kumal.
apiw</p>          </div>', 'ACTIVE', 1, '-'),
       (57, 'apiyana', '0', 'apiyana', '<div class="word--description">             <span class="word--fonetic">[apiyana]</span>              <p class="word--description">v. suavizarse. Muyuku- nata, ima murutapash yanukpi amukyana. Mutika yanukukpillatak apiyarka.
Sin. Kapiyana.
apu</p>          </div>', 'ACTIVE', 1, '-'),
       (58, 'apu', '0', 'apu', '<div class="word--description">             <span class="word--fonetic">[apu]</span>              <p class="word--description">s. amz. tipo de insecto. Uchilla chillikshina, hapikpi ashnak wiwa.
Apu kuruta hapishka makiwan hilluta hapini.
Sin. Manchu.
apunchik</p>          </div>', 'ACTIVE', 1, '-'),
       (59, 'wasi', '0', 'wasi', '<div class="word--description">             <span class="word--fonetic">[apunčik wasi]</span>              <p class="word--description">s. iglesia,
templo. Pachakamakta willankapak, mañan- kapak rurashka wasi.
Iñikkunaka punchantami apunchikwasiman rin.
Apya yala</p>          </div>', 'ACTIVE', 1, '-'),
       (60, 'ara', '0', 'ara', '<div class="word--description">             <span class="word--fonetic">[ara]</span>              <p class="word--description">s. sc. Tipo de piedra; mineral. Allpa ukupi tiyak rumi.
Chay urkupika kuri ara rumimi kaman. araray</p>          </div>', 'ACTIVE', 1, '-'),
       (61, 'araw', '0', 'araw', '<div class="word--description">             <span class="word--fonetic">[araw]</span>              <p class="word--description">s. amz. variedad de lora. Way- lla patpayuk, rimayta yachapayak, uma chawpipi killu patpayuk, araw araw kaparik hatun pishku.
Kanka ¿llullu arawtachu hapirkanki?. arawi</p>          </div>', 'ACTIVE', 1, '-'),
       (62, 'arawikuk', '0', 'arawikuk', '<div class="word--description">             <span class="word--fonetic">[arawik, arawikuk]</span>              <p class="word--description">adj. poeta. Al-
lichishka rimayta rimak, killkak runa.
Arawikukka wawakunata kusichinmi.
ari</p>          </div>', 'ACTIVE', 1, '-'),
       (63, 'arina', '0', 'arina', '<div class="word--description">             <span class="word--fonetic">[arina]</span>              <p class="word--description">v. estrenar; impermeabilizar.
Mushukta imatapash yachachina.
Mushuk mankata arikuni.




armana</p>          </div>', 'ACTIVE', 1, '-'),
       (64, 'asha', '0', 'asha', '<div class="word--description">             <span class="word--fonetic">[aša]</span>              <p class="word--description">det. poco. Mana achka. Asha kullkita mañankapak rikuni.
Sin. Ansa, piti.
ashalla</p>          </div>', 'ACTIVE', 1, '-'),
       (65, 'ashanka', '0', 'ashanka', '<div class="word--description">             <span class="word--fonetic">[ašanka, ašanga]</span>              <p class="word--description">s. canasta de fibra de palma. Ukshamanta rurashka, ya- nuna ukupi mikunata, aychata churankapak warkurayak.
Ashankapi aychata churani.
ashi</p>          </div>', 'ACTIVE', 1, '-'),
       (66, 'ashnak', '0', 'ashnak', '<div class="word--description">             <span class="word--fonetic">[ašnax, asna, ašnak, asnak, ašnag, asnag]</span>              <p class="word--description">adj. oloroso (agradable o desa- gradable). Imapash alli, mana alli mutkirik. Mishki ashnak sisata tarimuni.
ashnana</p>          </div>', 'ACTIVE', 1, '-'),
       (67, 'ashtawan', '0', 'ashtawan', '<div class="word--description">             <span class="word--fonetic">[aštawan, astawan, aštaun]</span>              <p class="word--description">adv. más, además. Imapash charishka, tiyashka, munashka hawa yapa kak.
Mishki mikunata ashtawan mikunayan. Sin. yapana.
ashtana</p>          </div>', 'ACTIVE', 1, '-'),
       (68, 'asichik', '0', 'asichik', '<div class="word--description">             <span class="word--fonetic">[asičik]</span>              <p class="word--description">s. bromista. Imatapash asichinkapak rimashka.
Imata nishpapash asichik runaka tukuyta asichinllami.
Sin. nuspa.
asina</p>          </div>', 'ACTIVE', 1, '-'),
       (69, 'aspi', '0', 'aspi', '<div class="word--description">             <span class="word--fonetic">[aspi]</span>              <p class="word--description">s. raya. Sunipash, kutupash ñañu rawashina kak.
Allpapi shuk aspita rurashpa sakini.
aspina</p>          </div>', 'ACTIVE', 1, '-'),
       (70, 'aswa', '0', 'aswa', '<div class="word--description">             <span class="word--fonetic">[aswa, asa, asuwa]</span>              <p class="word--description">s. chicha. Muru kutashkata yakuwan mishkiwanpash yanushpa, pukuchishpa upyana.
Raymipika hura aswatami upyani. aswana</p>          </div>', 'ACTIVE', 1, '-'),
       (71, 'atakapi', '0', 'atakapi', '<div class="word--description">             <span class="word--fonetic">[atakapi]</span>              <p class="word--description">s. variedad de boa gi- gante. Runata mikuklla hatun, yapa millay amaru.
Yaku manñakunapi tuta purinaka llakillami
atakapi rikurin.
ataku</p>          </div>', 'ACTIVE', 1, '-'),
       (72, 'atallpa', '0', 'atallpa', '<div class="word--description">             <span class="word--fonetic">[atalypa, atalpa, atažpa, atawallpa, atapa, ataba, atiža, atilpa, atilba, atilypa, atulba, atil]</span>              <p class="word--description">s. snc. gallina. Runapa wasipi kawsak, ishkay chakiyuk, lulunta wachak hatun pishku.
Ñukapa wasipika atallpata mikurkani. Sin. Wallpa.
atatay</p>          </div>', 'ACTIVE', 1, '-'),
       (73, 'atina', '0', 'atina', '<div class="word--description">             <span class="word--fonetic">[atiy]</span>              <p class="word--description">v. vencer, poder, sobresalir. Ut- kalla imatapash mishashpa rurana.
Utkashun nishpa payta llankaypi atirkani.
2.	porfiar, exigir, insistir, apurar, prevalecer. Mañashka kipa, mana utka tukuchikpi kutin mañana.
Kanka, ¿ima nishpatak atikunki?
3.	sc. hablar demasiado.Yapata rimana. Payka imata rimashpapash atikunmi. Sin.1 Mishana; 2 utkana.
atsikyana</p>          </div>', 'ACTIVE', 1, '-'),
       (74, 'atuk', '0', 'atuk', '<div class="word--description">             <span class="word--fonetic">[atux, atug, atuk, atu]</span>              <p class="word--description">s. S. lobo. Al-
lkushina rikurik: waykupi, kakapi, chiri urkupi kawsak wiwa.


ATUK SARA
Atukka puka atallpata hapishka.
atuk sara</p>          </div>', 'ACTIVE', 1, '-'),
       (75, 'atupa', '0', 'atupa', '<div class="word--description">             <span class="word--fonetic">[atupa]</span>              <p class="word--description">s. s. maíz plagado.Yana ku- tawan chakrurishpa ismushkashina tukushka sara.
Kunanpika chukllukunapash atupami tukun.
2.	s. vieja. Atupa warmi, paya warmi.
Kanka atupa warmishinami mana kallpanata ushanki.
3.	ss. necio. Mana imatapash uyak. Atupa kashkamanta yachakukta kamirka. Sin. 2 Paya; 3 uparinri.
atyak</p>          </div>', 'ACTIVE', 1, '-'),
       (76, 'awanakaspi', '0', 'awanakaspi', '<div class="word--description">             <span class="word--fonetic">[awanakaspi]</span>              <p class="word--description">s. s.	telar. Chakatashpa rurashka kaspi.
José awanakaspipimi makanataka awan. awasi</p>          </div>', 'ACTIVE', 1, '-'),
       (77, 'awana', '0', 'awana', '<div class="word--description">             <span class="word--fonetic">[awana]</span>              <p class="word--description">v. tejer. Churanakunata, imakunatapash achka puchkata chimpachis- hpa rurana.
Maykankunaka chumpikunata awan.
2.	v. amz. Poner cubierta a la casa. Ñukapa wasita wayuriwan awarkani.
3.	v. amz. Hacer objetos de barro. Manka all- pawan kallanata ruray.
Anti   suyupika   shinami	mukawatapash
awanchik.
awinchina</p>          </div>', 'ACTIVE', 1, '-'),
       (78, 'awka', '0', 'awka', '<div class="word--description">             <span class="word--fonetic">[awka, awkak]</span>              <p class="word--description">adj. guerrero, militar,
soldado. Ñawpamanta pacha sinchi runa, mi- llay, makanakuk runa.


Rumi ñawika sinchi awkami karka.
2. persona inadaptable a las costumbres de un pueblo. Mana llaktakunapi yacharik runa. Payka kay llaktapika awkami kan.
Sin. 1. makanakuk.
awki</p>          </div>', 'ACTIVE', 1, '-'),
       (79, 'awkish', '0', 'awkish', '<div class="word--description">             <span class="word--fonetic">[aukiš]</span>              <p class="word--description">s. comida ritual de los fune- rales. Runa wañuypi chakrushka mikuna- kuna.
Awkish mikunata ruraytami yachani. awkish</p>          </div>', 'ACTIVE', 1, '-'),
       (80, 'awlakanu', '0', 'awlakanu', '<div class="word--description">             <span class="word--fonetic">[awlaxanu, alwaxanu, alwakanu]</span>              <p class="word--description">s. sc. repartidor de alimentos en las fiestas. Raymipi mikunata rakik.
Churi sawarikpika awlakanukuna mikunata rakirka.
Sin. Mulumasha.
awllina</p>          </div>', 'ACTIVE', 1, '-'),
       (81, 'aya', '0', 'aya', '<div class="word--description">             <span class="word--fonetic">[aya]</span>              <p class="word--description">s. cadáver. Wañushka runa.
Kaynaka ayata wantushpa aparkachik.
2.	fantasma, espíritu; poder, fuerza. Chawpi tuta unkushkapa ñawipi runashina rikurik. Runa yuyaypi manchachishpa purik.
Uchilla wamrataka ayami manchachishka.
3.	silvestre. Imapash mana tarpushpa wiñak.
Aya kiwaka achkata wiñanllami.
Sin. 1. wañuska; 2. ushay, kallpa, samay; 3 sacha.
ayampakuna</p>          </div>', 'ACTIVE', 1, '-'),
       (82, 'ayapampa', '0', 'ayapampa', '<div class="word--description">             <span class="word--fonetic">[ayapamba, ayapampa]</span>              <p class="word--description">s. ce- menterio, panteón. Wañushka runapa ay- chata pampana.
Tukuy runakunami ayapampapi ayak



AYSANA

ayar (<*ayar) s. noviembre. Chunka shuk- niki killa.
Ayar killapika aya pampaman wañushkaku- nata rikunkapak yuyarinkapakpash rinchik. aycha</p>          </div>', 'ACTIVE',
        1, '-'),
       (83, 'ayki', '0', 'ayki', '<div class="word--description">             <span class="word--fonetic">[ayki]</span>              <p class="word--description">s. bo. estafa. Imatapash uma- chishpa kushka.
Kachita rantikukpi aykita rurarka.
aykina</p>          </div>', 'ACTIVE', 1, '-'),
       (84, 'ayllu', '0', 'ayllu', '<div class="word--description">             <span class="word--fonetic">[aylyu, ayžu]</span>              <p class="word--description">s. familia, pariente, linaje, genealogía; sistema. Yaya, mama, churi- kuna, hachi, hatunyayamama tantalla kaw- sakkuna.
Kay punchakuna ayllukunata muyunkapak

ayllu llakta</p>          </div>', 'ACTIVE', 1, '-'),
       (85, 'shuti', '0', 'shuti', '<div class="word--description">             <span class="word--fonetic">[aylyu šuti, ayžu šuti]</span>              <p class="word--description">s. apellido. Yayamamamanta chaskishka, mana chinkar- ishpa katimuk shuti.
Ñukapa mashipa ayllushutika “Pichisakami” kan.
aymuray (<*aymuray) s. mayo. Pichkaniki
killa.
Aymuray killapika llamkakpa punchami kan. ayri</p>          </div>', 'ACTIVE', 1, '-'),
       (86, 'aysana', '0', 'aysana', '<div class="word--description">             <span class="word--fonetic">[aysana]</span>              <p class="word--description">v. halar, extender, estirar, deslizar, arrastrar. Imatapash makiwan chu- tay.
Mamaka makimanta wawata aysarka.
Sin. Chutana, shitana.




























chachina</p>          </div>', 'ACTIVE', 1, '-'),
       (87, 'chaka', '0', 'chaka', '<div class="word--description">             <span class="word--fonetic">[čaka]</span>              <p class="word--description">s.	puente. Mayu hawata chimpankapak kaspikunawan, mana kas- hpaka rumi-kutawan rurashka ñan.
Yachakuk wawakunaka chakatami yallin.
2. cadera, anca. Runapa washa tulluwan is- hkantin chankawan tinkichik siki tullu. Payka chaka tullutami nanachikun. chakana</p>          </div>',
        'ACTIVE', 1, '-'),
       (88, 'chakata', '0', 'chakata', '<div class="word--description">             <span class="word--fonetic">[čakata]</span>              <p class="word--description">s. cruz. Shayak kaspipi
umaman kinray watashka kaspi. Ayapampapika achka chakatami rikurin. chakatana</p>          </div>', 'ACTIVE', 1, '-'),
       (89, 'chakchuna', '0', 'chakchuna', '<div class="word--description">             <span class="word--fonetic">[čaxčuna, čakčuna, čagčuna]</span>              <p class="word--description">v. s. descomponer, regar, botar, esparcir agua o granos. lmatapash karu karupi shita- na.
Pichankapak ama allpa hatarichunka yaku- wan chakchun.
2. v. hacer algo a escondidas. Imatapash pa- kalla rurana.
Churika mana chariymanta yayapa ruwanata raymiman chakchun.
Sin. 1 Hichana, chiwana, shitana, tallina, par- kuna.
chakchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (90, 'chaki', '0', 'chaki', '<div class="word--description">             <span class="word--fonetic">[čaki]</span>              <p class="word--description">s. pie, pata. Runakuna, wiwa- kuna purinkapak mutsurik ukku.
Tiyu allpata sarukpi chaki pamparirka. chakichina</p>          </div>', 'ACTIVE', 1, '-'),
       (91, 'chichu', '0', 'chichu', '<div class="word--description">             <span class="word--fonetic">[čaki čiču]</span>              <p class="word--description">s. pantorilla. Ru-
nakunapa kunkuri washa uraypi sakirik ay- chasapami kan.
Mamapa chaki chichupi chupu llukshishka. chaki kati</p>          </div>', 'ACTIVE', 1, '-'),
       (92, 'chakka', '0', 'chakka', '<div class="word--description">             <span class="word--fonetic">[čaxa, čaga]</span>              <p class="word--description">s. amz. variedad de raposa. Uchilla añasshina, ashnak yakuta is- hpak.
Millay chakkaka atallpa lulunta mikurka.
Sin. chucha, sinik.
chaklla</p>          </div>', 'ACTIVE', 1, '-'),
       (93, 'chakmana', '0', 'chakmana', '<div class="word--description">             <span class="word--fonetic">[čakmana, tsakmana]</span>              <p class="word--description">v. bo. cul-
tivar la tierra para sembrar; virar la tierra con el azadón. Llachuwan allpata ukumanta ha- waman tikrachiy.
Yana allpapi papata tarpunkapak chakmani. chakmay (<*čakmay) s. agosto. Pusakniki killa.
Chakmay	killapika,	Sallka	suyupika yachakuk wawakunaka sumakta samakun. chaknana</p>          </div>',
        'ACTIVE', 1, '-'),
       (94, 'chakra', '0', 'chakra', '<div class="word--description">             <span class="word--fonetic">[čakra, čagra]</span>              <p class="word--description">s. sementera, chacra. Muyukunata tarpushka pampa.
Tukuy ayllumi sara chakrata hallman. chakrana</p>          </div>', 'ACTIVE', 1, '-'),
       (95, 'chakruna', '0', 'chakruna', '<div class="word--description">             <span class="word--fonetic">[čakruna, čagruna]</span>              <p class="word--description">v. mezclar, combinar. Imatapash shukkunawan cha- puna.
Alli mikuyta charinkapakka tukuy sami muru- kunatami chakrun.
Sin. Chapuna.
chakuk</p>          </div>', 'ACTIVE', 1, '-'),
       (96, 'chakukina', '0', 'chakukina', '<div class="word--description">             <span class="word--fonetic">[čakukina]</span>              <p class="word--description">v. emitir sonidos los
cerdos al masticar. Kuchikuna mikunakunata akuna.
Kuchiman ismu sarata karakpika achkatami
chakukin.
chakuna</p>          </div>', 'ACTIVE', 1, '-'),
       (97, 'challa', '0', 'challa', '<div class="word--description">             <span class="word--fonetic">[čalya, čala]</span>              <p class="word--description">s. ss. Planta seca del maíz; productos o granos que se quedan después de la cosecha. Murukuna pallas- hkapi sakirishka.
Papa allaypika challa sakirinmi.
challana</p>          </div>', 'ACTIVE', 1, '-'),
       (98, 'challana', '0', 'challana', '<div class="word--description">             <span class="word--fonetic">[čalyana, čažana, čalana]</span>              <p class="word--description">v. ss.


descriarse, dañarse, descarriarse, desviarse de los valores. Maykanpash wakllirishka tukuna.
Wakcha wawakuna hatun llaktakunaman ris- hpaka achkatami challan.
Sin. Wakllina.
challchina</p>          </div>', 'ACTIVE', 1, '-'),
       (99, 'challina', '0', 'challina', '<div class="word--description">             <span class="word--fonetic">[čalyina, čažina]</span>              <p class="word--description">v. s. recoger resi-
duos de cosechas. Murukunata pallay washa puchushkakunata tantachina.
Ayllullakta wamrakunaka papata challin.
2. v. descarriarse. Maytapash riklla.
Ayllu wakllirikpika wawakunaka challin.
Sin. 1 challana, chukchiyna
challun</p>          </div>', 'ACTIVE', 1, '-'),
       (100, 'challwa', '0', 'challwa', '<div class="word--description">             <span class="word--fonetic">[čalywa, čazwa, čalua, čawla]</span>              <p class="word--description">s. pescado, variedad de pez bocachico. Yakupi kawsak wiwa. Hatun turuta chumkak, tanta- nakushpa purik wiwa.
Katu pampapi challwata rantinkapak rikuni.
Sin. Yaku aycha.
chamcha</p>          </div>', 'ACTIVE', 1, '-'),
       (101, 'chamiku', '0', 'chamiku', '<div class="word--description">             <span class="word--fonetic">[čamiku]</span>              <p class="word--description">s. s. chamico, planta sil-
vestre pequeña. Sisa ukupi kashayuk, waylla tullpuyuk yura.
Sara chakra ukumanta chamiku yurakunata tantanchik.
chamka</p>          </div>', 'ACTIVE', 1, '-'),
       (102, 'chamkana', '0', 'chamkana', '<div class="word--description">             <span class="word--fonetic">[čamkana, čankana, tsamkana, tsankana]</span>              <p class="word--description">v. triturar, moler grueso. Ima mu-



rukunata raku rakulla kutana.
Chuchiman karankapakmi kutana rumipi sa- rata chamkanchik.
champa</p>          </div>', 'ACTIVE', 1, '-'),
       (103, 'champira', '0', 'champira', '<div class="word--description">             <span class="word--fonetic">[čambira]</span>              <p class="word--description">s. chambira. Sacha ukupi tiyak, killu puchkayuk yurami, pitashi- nalla.
Champiramanta puchkawan unkutami awar- kani.
champuru</p>          </div>', 'ACTIVE', 1, '-'),
       (104, 'chamuk', '0', 'chamuk', '<div class="word--description">             <span class="word--fonetic">[čamuk, čamux, čamug, xamun, čama, čamak]</span>              <p class="word--description">adj. insípido, desabrido, soso. Ima mikuykunapash mishkita, kachita mana charik.
Unkushpaka chamuk mikunatallami mikun.
2. apático, sin gracia. Killaysiki, imatapash mana munak.
Tantanakuypi Juan mashika chamukmi ya- llin.
Sin. Ñukñu, hamlla, upa, chamcha, aminta. chanchana</p>          </div>', 'ACTIVE', 1, '-'),
       (105, 'chani', '0', 'chani', '<div class="word--description">             <span class="word--fonetic">[čani]</span>              <p class="word--description">s. precio, valor. Imakuna mas- hna kak.
Kay kuchika kimsa pachak waranka chani-


yukmi kan.
chanka</p>          </div>', 'ACTIVE', 1, '-'),
       (106, 'chankana', '0', 'chankana', '<div class="word--description">             <span class="word--fonetic">[čaŋgana]</span>              <p class="word--description">v. entrecruzar las
piernas, sujetar con las piernas. Pitapash chankawan pilluna.
Hatun yuraman sikankapakka chankawan
chankani.
chantasu</p>          </div>', 'ACTIVE', 1, '-'),
       (107, 'awi', '0', 'awi', '<div class="word--description">             <span class="word--fonetic">[čañawi]</span>              <p class="word--description">s. amz. variedad de pá- jaro que imita a los demás de su especie. Ya- nawan, killuwan muru pishku, tukuy pishkukunata yachapak.
Anti suyupika chañawi pishkuka sumaktami takin.
chapa</p>          </div>', 'ACTIVE', 1, '-'),
       (108, 'chapak', '0', 'chapak', '<div class="word--description">             <span class="word--fonetic">[čapak]</span>              <p class="word--description">s. vigilante, policía, agente, detective. Awka runashina, llaktapi kawsak runakunata kamak.
Chapakkunaka	millay	runakunamanta kaman.
chapana</p>          </div>', 'ACTIVE', 1, '-'),
       (109, 'chapul', '0', 'chapul', '<div class="word--description">             <span class="word--fonetic">[čabul]</span>              <p class="word--description">s. mariposa. Sumak tullpuyuk patak rikra, pawashpa chuspishina purik.
Sisa yurakunapika sumaktami chapulkunaka tiyarin.
Sin. Pillpintu.
chapuna</p>          </div>', 'ACTIVE', 1, '-'),
       (110, 'charapa', '0', 'charapa', '<div class="word--description">             <span class="word--fonetic">[čarapa]</span>              <p class="word--description">s. amz. variedad de tor- tuga acuática. Yakupi kawsak yawatishina.




Charapa wiwaka hatun mayukunapimi kawsan.
charina</p>          </div>', 'ACTIVE', 1, '-'),
       (111, 'charina', '0', 'charina', '<div class="word--description">             <span class="word--fonetic">[čarina]</span>              <p class="word--description">v. sujetar, sostener, tener.
Imatapash harkana, hapina.
Yayaka   wawa ama urmachun makimanta
charin.
charki</p>          </div>', 'ACTIVE', 1, '-'),
       (112, 'charkina', '0', 'charkina', '<div class="word--description">             <span class="word--fonetic">[čarkina, tsarkina]</span>              <p class="word--description">v. cecinar, secar carne al sol. Aychata kayman chayman kuchushpa chakichina.
Llama aychata sumakta mishkichishpa intipi
charkinki.
chas</p>          </div>', 'ACTIVE', 1, '-'),
       (113, 'chaska', '0', 'chaska', '<div class="word--description">             <span class="word--fonetic">[časka]</span>              <p class="word--description">s. planeta Venus. Hawa pa- chapi intishina llipyak, tutamantata, chishi- yakpipash rikurik rumpu.
Ñawpa pachapika, inkakunaka chaskata muchak karka.
chaski</p>          </div>', 'ACTIVE', 1, '-'),
       (114, 'chaskina', '0', 'chaskina', '<div class="word--description">             <span class="word--fonetic">[časkina]</span>              <p class="word--description">v. recibir, aceptar, admi- tir. Imakunatapash hapina.
Wawa wasiman tikramukpi mamaka kushilla
chaskin.
2. s. Recibimiento y bendiciones que dan los padres y padrinos a los novios. Yayamama, achikyayamama kunaykunata kushka.
Ruku yaya sawariypika chaskiyta kun. chaspina</p>          </div>', 'ACTIVE', 1, '-'),
       (115, 'chasu', '0', 'chasu', '<div class="word--description">             <span class="word--fonetic">[času, čazu]</span>              <p class="word--description">adj. ss. aculturado. Ki- kinpa sapi kawsayta mana charik. Shuktak- kunapa kawsayta hapik.


Chasukunaka runa kashkataka mana yuyan- chu.
Sin. Chinkarishka.
chawa</p>          </div>', 'ACTIVE', 1, '-'),
       (116, 'chawamanku', '0', 'chawamanku', '<div class="word--description">             <span class="word--fonetic">[čawamanku]</span>              <p class="word--description">s. amz. pá-
jaro chaguamango. Sumak patpayuk pishku. Chawamankuka anti suyupimi tiyan. chawar</p>          </div>', 'ACTIVE', 1,
        '-'),
       (117, 'chawana', '0', 'chawana', '<div class="word--description">             <span class="word--fonetic">[čawana]</span>              <p class="word--description">v. ordeñar, exprimir, es-
currir. Wakra ñuñuta, takshashkata, yanushka murukunatapash kapina.
Payka lumu yanushkata aswa rurankapak
chawan.
Sin. Kapina.
chawcha</p>          </div>', 'ACTIVE', 1, '-'),
       (118, 'chawcha', '0', 'chawcha', '<div class="word--description">             <span class="word--fonetic">[čawča]</span>              <p class="word--description">adj. amz. chistoso. Ima- kunatapash nishpa asichik, kushiyachik.
Raymipika tawka chawcha mashimi asichin.
Sin. asichik.
chawpi</p>          </div>', 'ACTIVE', 1, '-'),
       (119, 'chawpina', '0', 'chawpina', '<div class="word--description">             <span class="word--fonetic">[čawpina]</span>              <p class="word--description">v. dividir, partir en mi- tades; partir un entero en quebrados. Imaku- natapash ishkaypi pakta pakta rakiy.
Allpataka ishkantillami chawpirkanchik. chawsirina</p>          </div>', 'ACTIVE', 1, '-'),
       (120, 'chay', '0', 'chay', '<div class="word--description">             <span class="word--fonetic">[čay, čiy]</span>              <p class="word--description">det. ese, eso, esa. Maykan- pash imapash karulla kashkata ninkapak shimi.
Chay urkumanka ninanta purishpami cha- yanchik.
chayamuna</p>          </div>', 'ACTIVE', 1, '-'),
       (121, 'chay', '0', 'chay', '<div class="word--description">             <span class="word--fonetic">[čay čay]</span>              <p class="word--description">interj. amz. sensación que deja la picadura de un gusano. Kasha- yuk kuru chinikpi aychayachishka.
Chinik kuru makipi chinishkami chay chay
nanan.
chaymanta</p>          </div>', 'ACTIVE', 1, '-'),
       (122, 'chayrak', '0', 'chayrak', '<div class="word--description">             <span class="word--fonetic">[čayrak, čayrig]</span>              <p class="word--description">adv. todavía, aún.


Imatapash manarak tukuchishkata ninkapak shimi.
Yachana wasimantami chayrak rikuni. chayrayku</p>          </div>', 'ACTIVE', 1, '-'),
       (123, 'shina', '0', 'shina', '<div class="word--description">             <span class="word--fonetic">[čay šina, časna, čažna, čazna]</span>              <p class="word--description">adv. así, de esta manera. Imakunatapash shinami nik shimi.
Killkana pankapika chay shina shuyunki.
Sin. Kashna, shina.
chi</p>          </div>', 'ACTIVE', 1, '-'),
       (124, 'chichiku', '0', 'chichiku', '<div class="word--description">             <span class="word--fonetic">[čičiku]</span>              <p class="word--description">s. amz. el más pequeño
de los monos. Yana millmayuk, yurak shimiyuk uchilla kushillu.
Chichikukunataka kuyashpami charina kanchik.
chichu</p>          </div>', 'ACTIVE', 1, '-'),
       (125, 'chichuyana', '0', 'chichuyana', '<div class="word--description">             <span class="word--fonetic">[čičuyana]</span>              <p class="word--description">v. embarazarse; preñarse. Warmikuna, wiwakuna wiksapi wawa-muyuwan sakirina
Yaku aychakunaka kay killapimi chichuyan. chika</p>          </div>', 'ACTIVE', 1, '-'),
       (126, 'chikaksu', '0', 'chikaksu', '<div class="word--description">             <span class="word--fonetic">[čikaxsu]</span>              <p class="word--description">s. amz. tipo de fruta co- mestible. Yanushpa mikuna sacha muyu.
Mamaka chikaksu muyuta yanushpa karan.
Sin. tikasu.
chikan</p>          </div>', 'ACTIVE', 1, '-'),
       (127, 'chikanyachina', '0', 'chikanyachina', '<div class="word--description">             <span class="word--fonetic">[čikanyačina, šikanyačina, čhikanyačina]</span>              <p class="word--description">v. clasificar, separar, apartar, diferenciar. Imakunatapash tantarishka- manta karuyachishpa churana.
Wawakuna pukllaykunata riksichunka tanta- chichishpa, chikanyachina.
chikaru</p>          </div>', 'ACTIVE', 1, '-'),
       (128, 'chiki', '0', 'chiki', '<div class="word--description">             <span class="word--fonetic">[čiki]</span>              <p class="word--description">adj. mal augurio, desgracia, ad- versidad, infortunio, crisis. Llaki shamunata rikuchik.
2. amz. inepto en casería. Wiwakunata hapi- napi mana ushak.
Sin. 1 Tapya.
chikin chikin</p>          </div>', 'ACTIVE', 1, '-'),
       (129, 'chikta', '0', 'chikta', '<div class="word--description">             <span class="word--fonetic">[čixta]</span>              <p class="word--description">s. grieta, partido, resquebra- jado, rajado. Mama allpa kashpa, ima sinchi pirkakuna, kaspikuna chawpirishka.
Cotopaxi urku umapi chiktami tiyan.
2. amz. brazo del río. Hatun mayupa yaku rikra.
Uray chiktapimi yaku aychakunataka hapirkani.
chiktana</p>          </div>', 'ACTIVE', 1, '-'),
       (130, 'chikwan', '0', 'chikwan', '<div class="word--description">             <span class="word--fonetic">[čikwan]</span>              <p class="word--description">s. amz. pájarito de plu- maje café. Uki patpayuk uchilla pishku.
Anti suyu runakunaka chikwan pishkutami wasipi charin.
chilina</p>          </div>', 'ACTIVE', 1, '-'),
       (131, 'chillchill', '0', 'chillchill', '<div class="word--description">             <span class="word--fonetic">[čilčil, čilžil]</span>              <p class="word--description">s. s. variedad de planta medicinal. Uchilla tawrishina yura.
Llama uhu hapikpi chillchill yurawan ham- pinchik.
chilli</p>          </div>', 'ACTIVE', 1, '-'),
       (132, 'chillik', '0', 'chillik', '<div class="word--description">             <span class="word--fonetic">[čilyik]</span>              <p class="word--description">s. amz. Langosta. Achkata mi-
rarik, puriykachak, yurakunapi kawsak pala- maku.
Chillikka tukuy yurata mikurka.
chillina</p>          </div>', 'ACTIVE', 1, '-'),
       (133, 'chilliwakan', '0', 'chilliwakan', '<div class="word--description">             <span class="word--fonetic">[čilyiwakan, čiwalkan]</span>              <p class="word--description">s. sn. chamburo pequeño. Papaya yurashina, ñu- ñushina yakuta charik yura.
Chilliwakan yurakunata wanuwan tar- pushunchik.
Sin. Champuru.
chillka</p>          </div>', 'ACTIVE', 1, '-'),
       (134, 'chillpina', '0', 'chillpina', '<div class="word--description">             <span class="word--fonetic">[čilypina]</span>              <p class="word--description">v. s. sacar tiras, partir en fragmentos o tiras. Imatapash llikishpa sa- kina.
Chawarta pitishpaka imatapash watanka- pakmi chillpinchik.
2.	desramar. Mallkikunata mukupi pitina. Yurakuna ama chakrata makachun mallkiku- nata chillpin.
3.	abrir algo a presión manual. Imatapash


CHIMPA
makiwan paskay.
Ñawi karata hampinkapakka makiwan allilla
chillpinchik.
Sin. 1 Challchina, 2 rawmana; 3 paskana. chimpa</p>          </div>', 'ACTIVE', 1, '-'),
       (135, 'chimpa', '0', 'chimpa', '<div class="word--description">             <span class="word--fonetic">[simba, simpa, čimba, čiŋba, šimba, šiŋba]</span>              <p class="word--description">s. trenza. Akchata, puchkaku- natapash, kimsapi rakishpa awashkashinata ruray.
Warmikapa akcha chimpaka achka rakumi kan.
chimpalu</p>          </div>', 'ACTIVE', 1, '-'),
       (136, 'chimpaluk', '0', 'chimpaluk', '<div class="word--description">             <span class="word--fonetic">[čimpaluk, čimbalux]</span>              <p class="word--description">s. rena- cuajo. Uchilla kuru, chupasapa hampatu, ya- kullapitak kawsakuk, manarak chupapash pitirishka.
Wawakunaka chimpalukta yaku kucha- manta hapishpa pukllan.
Sin. Putu kulu, willi willi. chimpapurachina</p>          </div>', 'ACTIVE', 1, '-'),
       (137, 'chimpana', '0', 'chimpana', '<div class="word--description">             <span class="word--fonetic">[čimbana, čimbana, šimbana, čiŋbana]</span>              <p class="word--description">v. cruzar. Shuk manyamanta shuk manyakama yalliy.
Kay mayutaka alli rumikunata rikushpami
chimpanchik.
chimpana</p>          </div>', 'ACTIVE', 1, '-'),
       (138, 'chimpi', '0', 'chimpi', '<div class="word--description">             <span class="word--fonetic">[čimpi, čimbi, čiŋbi]</span>              <p class="word--description">s. sc. verruga.
Murukunashina chakikunapi, makikunapi wiñak aycha.
Chimpi llukshikpika atallpa chaki karata kunuchishpami kakuna kan.
Sin. Mitsa, misha.


chimpilaku</p>          </div>', 'ACTIVE', 1, '-'),
       (139, 'china', '0', 'china', '<div class="word--description">             <span class="word--fonetic">[čina]</span>              <p class="word--description">adj. hembra. tukuy wiwakuna wachak kak, mana kari kak.
Yana china kuchika sukta wawa kuchitami wacharka.
china</p>          </div>', 'ACTIVE', 1, '-'),
       (140, 'chinanku', '0', 'chinanku', '<div class="word--description">             <span class="word--fonetic">[činanku, tsinaŋgu, tsinaku]</span>              <p class="word--description">s. amz. caracol grande. Sachapi kawsak hatun churu.
Chinanku aychataka mikunallami kan. chincha</p>          </div>', 'ACTIVE', 1, '-'),
       (141, 'chinchay', '0', 'chinchay', '<div class="word--description">             <span class="word--fonetic">[čiŋčay]</span>              <p class="word--description">s. norte. Alaska llakta- man sakirik suyu.
Inka pachapika Quito llaktaka chinchaypi sakirishka.
chinchina</p>          </div>', 'ACTIVE', 1, '-'),
       (142, 'chini', '0', 'chini', '<div class="word--description">             <span class="word--fonetic">[čini, tsini, sini]</span>              <p class="word--description">s. hortiga. Pankapi ñutu kashayuk yura, nanaykunata upayachinka- pak alli.
Chini yurakunaka chakra ukukunapi wiñan- llami.
chinina</p>          </div>', 'ACTIVE', 1, '-'),
       (143, 'chinkana', '0', 'chinkana', '<div class="word--description">             <span class="word--fonetic">[čiŋgana]</span>              <p class="word--description">s. sc casucha. Uchilla uksha wasi.
Wakrakunata kamankapakka shuk chinka-




natami urkupika charinchik.
2. s. cueva, laberinto, caverna. Machayshina.
Wawakunaka chinkanata pakakun.
Sin. chuklla; 2 machay.
chinkana</p>          </div>', 'ACTIVE', 1, '-'),
       (144, 'chinkarina', '0', 'chinkarina', '<div class="word--description">             <span class="word--fonetic">[čiŋgarina,	šiŋgarina]</span>              <p class="word--description">v. perderse. Shunku shuwarishpa pantashpa purina.
Karumanta wawakuna sachaman rishpaka
chinkarin.
chinkillis</p>          </div>', 'ACTIVE', 1, '-'),
       (145, 'chinku', '0', 'chinku', '<div class="word--description">             <span class="word--fonetic">[čiŋgu]</span>              <p class="word--description">s. amz. palmera no comesti- ble. Kasha ankuyuk taraputushina rikurik yura.
Puna suyumanta runakunaka chinku mu- yuta mikunata munanllami.
chinlla</p>          </div>', 'ACTIVE', 1, '-'),
       (146, 'chinlus', '0', 'chinlus', '<div class="word--description">             <span class="word--fonetic">[činlus]</span>              <p class="word--description">s. pa. pez sardina. Killu wik-
sayuk uchilla challwa.
Ayllukuna shamukpi karankapakka chinlus
challwatami hapina kanchik.
chinta</p>          </div>', 'ACTIVE', 1, '-'),
       (147, 'chintana', '0', 'chintana', '<div class="word--description">             <span class="word--fonetic">[čiŋtana, čiŋdana]</span>              <p class="word--description">v. amz. depo- sitar maleza en las orillas de la chacra. Cha- kra manyakunapi kiwakunata muyuntinta kimichina.
José mashipa chakraman wiwakuna ama yaykuchun. Kiwawan, yurawan chintakun- chik.
chipu</p>          </div>', 'ACTIVE', 1, '-'),
       (148, 'chirapa', '0', 'chirapa', '<div class="word--description">             <span class="word--fonetic">[čirapa, tsirapa]</span>              <p class="word--description">s. llovizna, lluvia menuda con sol. Intikukpi ñutu tamya.
Chirapaka tarpushkata wakllin. chirapana</p>          </div>', 'ACTIVE', 1, '-'),
       (149, 'chiri', '0', 'chiri', '<div class="word--description">             <span class="word--fonetic">[čiri]</span>              <p class="word--description">s. frío. Ima kashpapash mana kunuk.
Chirimantami tullu nanayka hapin. chirisiki</p>          </div>', 'ACTIVE', 1, '-'),
       (150, 'chisha', '0', 'chisha', '<div class="word--description">             <span class="word--fonetic">[čiša čiša]</span>              <p class="word--description">expresión para ahuyentar o adelantar animales. Wakin wi- wakunata karuyachinkapak manchachik rimay.
Wakrakuna utka yapuchunka chisha chisha
nishpami manchachin.
Sin. Chi, kushi kushi, hishi hishi, hushu hushu.
chishi</p>          </div>', 'ACTIVE', 1, '-'),
       (151, 'chishinmikuna', '0', 'chishinmikuna', '<div class="word--description">             <span class="word--fonetic">[čišinmikuna]</span>              <p class="word--description">v. merendar. Tutayakpi mikuna.
Tutapika ashallata chishinmikurka.
chita</p>          </div>', 'ACTIVE', 1, '-'),
       (152, 'chitus', '0', 'chitus', '<div class="word--description">             <span class="word--fonetic">[čitus]</span>              <p class="word--description">s. amz. tallos del racimo, ex- traído los frutos. Palantata, chuntata, lumuta, shiwa muyutapash ishkukpi chushak sakirik tullu.
Chituskunata wanu rurak kuykakunaman karanchik.
Sin. Watu.
chiwarina</p>          </div>', 'ACTIVE', 1, '-'),
       (153, 'chiwilla', '0', 'chiwilla', '<div class="word--description">             <span class="word--fonetic">[čiwilya, čiwiža]</span>              <p class="word--description">s. piña. Achupa-
llashina pankayuk, yunka llaktapi pukuk mis- hki hatun muyu.
Aswa mishki kachunka chiwillatami churan. chiwillu</p>          </div>', 'ACTIVE', 1, '-'),
       (154, 'chiwlli', '0', 'chiwlli', '<div class="word--description">             <span class="word--fonetic">[čiwlyi]</span>              <p class="word--description">s. amz. pájaro de verano. Uchpa patpayuk, suni chakiyuk allpapi, chiw- lli chiwlli nishpa wakak pishku.
Usya pacha chayamukpika achka chiwlli
pishkumi chakrakunapika purin.
chiya</p>          </div>', 'ACTIVE', 1, '-'),
       (155, 'chiyun', '0', 'chiyun', '<div class="word--description">             <span class="word--fonetic">[čiyun]</span>              <p class="word--description">s. amz. pájaro que habita a
la orilla de los ríos. Yana patpayuk chiyun chiyun nishpa wakak, yaku manyakunapi kawsak pishku.
Mayu manyapi churashka kukayutaka chi- yun pishkumi mikushka.
chucha</p>          </div>', 'ACTIVE', 1, '-'),
       (156, 'chuchi', '0', 'chuchi', '<div class="word--description">             <span class="word--fonetic">[čuči]</span>              <p class="word--description">s. pollo, polluelo. Lulunmanta chayrak llukshishkalla llullu atallpa.
Chuchitaka kuyashpami wiñachina kanchik. chuchu</p>          </div>', 'ACTIVE', 1, '-'),
       (157, 'chuchuk', '0', 'chuchuk', '<div class="word--description">             <span class="word--fonetic">[čučuk]</span>              <p class="word--description">s. mamífero. Ñuñuta chumkak.
Wawa allkuka chuchuk wiwami kan.


chuchuka</p>          </div>', 'ACTIVE', 1, '-'),
       (158, 'awi', '0', 'awi', '<div class="word--description">             <span class="word--fonetic">[čuču ñawi]</span>              <p class="word--description">s. pezón. Chu-
chupa umashina.
Llullu wawaka chuchu ñawita chumkan. chuchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (159, 'chukchina', '0', 'chukchina', '<div class="word--description">             <span class="word--fonetic">[čuxčina, čugčina]</span>              <p class="word--description">v. recoger re- síduos de las cosechas. Chakrakunapi pu- chushka murukunata pallay.
Yayaka achka papatami chukchin. Sin. Challay, challiy.
chukchu-unkuy</p>          </div>', 'ACTIVE', 1, '-'),
       (160, 'chukchuwasu', '0', 'chukchuwasu', '<div class="word--description">             <span class="word--fonetic">[čukčawasa, čučuwasa, čučwaša]</span>              <p class="word--description">s. árbol cuya corteza se usa para curar el reumatismo. Puka karayuk, kara- manta yawarshina llukshik yura. Kara yanus- hka yakuta upyakpi tullu nanayta hampik.
Chukchuy unkuy hapikpika chukchuwasu
kaspi yakuta upyani.
Sin. Kurikaspi.
chukchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (161, 'chuki', '0', 'chuki', '<div class="word--description">             <span class="word--fonetic">[čuki]</span>              <p class="word--description">s. tipo de arma. Imapash ma- kanakuypi ima. Makanakuypika runakuna- taka chukiwan wañuchishka.
chuki</p>          </div>', 'ACTIVE', 1, '-'),
       (162, 'chukirawa', '0', 'chukirawa', '<div class="word--description">             <span class="word--fonetic">[čukirawa, čukira]</span>              <p class="word--description">s. s. chuqui- rahua. Killu sisayuk, kashalla pankayuk hampi kiwa, urkukunapi wiñak.
Chukirawa yakuwanmi washa nanaytaka hampin.
chuklla</p>          </div>', 'ACTIVE', 1, '-'),
       (163, 'chukllu', '0', 'chukllu', '<div class="word--description">             <span class="word--fonetic">[čuxžu, čuxlyu, čuklyu, čukžu, čugžu]</span>              <p class="word--description">s. choclo. Llullu sara mishkilla mikuyta charik muru.
Chuklluta tullpapi kusashpa karaway. chukni</p>          </div>', 'ACTIVE', 1, '-'),
       (164, 'chukri', '0', 'chukri', '<div class="word--description">             <span class="word--fonetic">[čukri, čugri]</span>              <p class="word--description">s. herida. Ukku aycha llikirishka.
Sachaman yura kashaka rikrapi chukrita ru- rarka.
chukririna</p>          </div>', 'ACTIVE', 1, '-'),
       (165, 'chuku', '0', 'chuku', '<div class="word--description">             <span class="word--fonetic">[čuku]</span>              <p class="word--description">s. amz. árbol cuyas semillas se usan para collares. Kashayuk hatun yura, pukata sisak, purutushina pakayta aparik.
Wawakuna chuku muyuwan wallkata ruran. chuku</p>          </div>', 'ACTIVE', 1, '-'),
       (166, 'chuku', '0', 'chuku', '<div class="word--description">             <span class="word--fonetic">[čuku, čugu]</span>              <p class="word--description">s. ss. variedad de ave cantora. Killu patpayuk yana pishku, sumakta takik.
Tutamantakunaka chuku pishkuka sumak- tami punchayakushkata willashpa takin.
Sin. wirakchuru.
chukuri</p>          </div>', 'ACTIVE', 1, '-'),
       (167, 'chulakyana', '0', 'chulakyana', '<div class="word--description">             <span class="word--fonetic">[čulaxyana]</span>              <p class="word--description">v. ampollarse, re- ventarse. Aycha karakunapi yaku purushina llukshirina.
Inti raymipi achka tushushkamanta chaki
chulakyan.
Sin. Huklluyana, chullpukyana.
chulla</p>          </div>', 'ACTIVE', 1, '-'),
       (168, 'chullanik', '0', 'chullanik', '<div class="word--description">             <span class="word--fonetic">[čulyanik]</span>              <p class="word--description">adj. det. impar. Ima- pash shuklla tiyana.
Kimsa yupayka chullanmi kan.
chullku</p>          </div>', 'ACTIVE', 1, '-'),
       (169, 'chullpi', '0', 'chullpi', '<div class="word--description">             <span class="word--fonetic">[čulypi, čulpi]</span>              <p class="word--description">s. s. variedad de maíz. Chununyashka, sipuyashkapash uchilla mis- hki sarami.
Chullpi kamchaka sumak mikunami kan. chullpukyana</p>          </div>', 'ACTIVE', 1, '-'),
       (170, 'chullu', '0', 'chullu', '<div class="word--description">             <span class="word--fonetic">[čulyu]</span>              <p class="word--description">s. amz. tipo de grillo. Chill- ishina rikurik. Punchayakpi, inti punchaku- napi wakak wiwa.
Anti suyupika sapan punchayaykunapika achkatami chullukunaka wakan. chullumpi</p>          </div>', 'ACTIVE', 1, '-'),
       (171, 'chulunlla', '0', 'chulunlla', '<div class="word--description">             <span class="word--fonetic">[čulunlya, čulunža, čunlya]</span>              <p class="word--description">adj. si-
lencioso, desolado. Imapash mana uyarik upashina.
Yachanawasika samay pachapika chulun- llami kan.
Sin. Upalla.
chulunyana</p>          </div>', 'ACTIVE', 1, '-'),
       (172, 'chumkana', '0', 'chumkana', '<div class="word--description">             <span class="word--fonetic">[čumkana, tsumgana, sum- kana, suŋgana]</span>              <p class="word--description">v. chupar, absorber, succio- nar. Ima yakutapash shimiwan chuchukshina rurashpa llukshichina.
Llullu wawakunaka yarkaywan chuchuta
chumkan.
chumpi</p>          </div>', 'ACTIVE', 1, '-'),
       (173, 'chuna', '0', 'chuna', '<div class="word--description">             <span class="word--fonetic">[čuna]</span>              <p class="word--description">s. ss. Variedad de escarabajo
negro y rojo. Hatun katsu, antawashina uya- rik, chuspirukuman rikchakmi.
Wawaka chunawanmi pukllan.
chunchu</p>          </div>', 'ACTIVE', 1, '-'),
       (174, 'chunka', '0', 'chunka', '<div class="word--description">             <span class="word--fonetic">[čunka, čuŋga]</span>              <p class="word--description">num. diez. Iskun yu- paymanta katik yupay.
Chunka watayuk wawaka aylluta yanapan. chunkana</p>          </div>', 'ACTIVE', 1, '-'),
       (175, 'chunta', '0', 'chunta', '<div class="word--description">             <span class="word--fonetic">[čunta]</span>              <p class="word--description">s. chonta. Kunuk llaktapi wiñak, sinchi, suni, yana tullpuyuk kiru.
Anti suyu machikunaka Chunta raymita ru- ranmi.
chunu</p>          </div>', 'ACTIVE', 1, '-'),
       (176, 'chunyarina', '0', 'chunyarina', '<div class="word--description">             <span class="word--fonetic">[čuŋyarina]</span>              <p class="word--description">v. callarse, silen- ciarse. Imatapash achiklla uyankapak upa- yana.
Ima rimashkata alli hamutankapak chunyan- chik.
Sin. chulunyana, Upallana, kasiyana. chupa</p>          </div>', 'ACTIVE', 1, '-'),
       (177, 'chupana', '0', 'chupana', '<div class="word--description">             <span class="word--fonetic">[čupana]</span>              <p class="word--description">v. sn. remendar. Chura- nakuna llikirishkata tinkishpa siray.
Wakcha runakunaka churanakuna llikirikpika
chupankuna.
Sin. Lampana, putyuna, llachapana. chupu</p>          </div>', 'ACTIVE', 1, '-'),
       (178, 'churana', '0', 'churana', '<div class="word--description">             <span class="word--fonetic">[čurana]</span>              <p class="word--description">s. ropa, vestimenta. Ru- nakunapa ukkuta killparinkapak awashka. Mapa churanata takshanaka achka sinchimi kan.
Sin. pacha, phacha.
churana</p>          </div>', 'ACTIVE', 1, '-'),
       (179, 'churi', '0', 'churi', '<div class="word--description">             <span class="word--fonetic">[čuri]</span>              <p class="word--description">s. hijo. Yaya-mamamanta wacharishka kari wawa.
Paymi ñukapa ñawpa churi kan.
churu</p>          </div>', 'ACTIVE', 1, '-'),
       (180, 'anka', '0', 'anka', '<div class="word--description">             <span class="word--fonetic">[čuru anka]</span>              <p class="word--description">s. amz. tipo de pá- jaro. Suni shimiyuk, yana patpayuk, suni




chakiyuk churuta mikuk anka, shuk markakunapika churu anka shutiyuk.
Churu ankami churuta mikushka rikurin.
Sin. Pusayu.
chushak</p>          </div>', 'ACTIVE', 1, '-'),
       (181, 'chushik', '0', 'chushik', '<div class="word--description">             <span class="word--fonetic">[čušix]</span>              <p class="word--description">s. s. lechuza. Ankashina
achka patpayuk tuta pishku.
Chushikka shuwa puriktami willan. chusku</p>          </div>', 'ACTIVE', 1, '-'),
       (182, 'chuspi', '0', 'chuspi', '<div class="word--description">             <span class="word--fonetic">[čuspi]</span>              <p class="word--description">s. mosco. Ishkay patpashina rikrayuk, ñawisapa millay kuru, pawashpa kawsak, mishkikunapi, mikunakunapi, ku- pakunapi ashtawan tantarik.
Kupa tantachishkapimi achka chuspika wiñarin.
Sin. Mama kuru, waña, challun, pumpushi. chusu</p>          </div>', 'ACTIVE', 1, '-'),
       (183, 'chusulunku', '0', 'chusulunku', '<div class="word--description">             <span class="word--fonetic">[čusuluŋgu, čuzaluŋgu]</span>              <p class="word--description">s. duende. Hatun muchikuyuk, suni ulluyuk, uchilla aya, tutakunapi runakunata mancha- chik.
Chusulunkuka urkupi kawsan, ninmi.


chutanakuna</p>          </div>', 'ACTIVE', 1, '-'),
       (184, 'chutana', '0', 'chutana', '<div class="word--description">             <span class="word--fonetic">[čutana]</span>              <p class="word--description">v.estirar, halar, extender, lanzar. Imatapash aysashpa wiñachiy.
Yurata maymanpash urmachinkapakka was- kawan chutanchik.
Sin. Aysay, shitay.
chuti</p>          </div>', 'ACTIVE', 1, '-'),
       (185, 'chuwalli', '0', 'chuwalli', '<div class="word--description">             <span class="word--fonetic">[čuwalyi, čuliwalyi]</span>              <p class="word--description">s. amz. gavilán
grande. Hatun anka kushilluta mikuk. Chuwallika pawashpa kushilluta mikunkpak aparka.
chuya</p>          </div>', 'ACTIVE', 1, '-'),
       (186, 'chuyaklla', '0', 'chuyaklla', '<div class="word--description">             <span class="word--fonetic">[čuyaxlya, čiyuxlya]</span>              <p class="word--description">adj. bien ba-
rrido, limpio. Imatapash sumakta pichashka mapa illak.
Wasika chuyakllami rikurin.
chuyan</p>          </div>', 'ACTIVE', 1, '-'),
       (187, 'hachi', '0', 'hachi', '<div class="word--description">             <span class="word--fonetic">[xači, ači]</span>              <p class="word--description">s. amz. tío. Yayapa, mamapa wawki.
Ñukapa hachi Julián kayman pakta- murkachu?
2. señor, don. Inti llukshina llaktamanta runa- kuna chikan rukuta llakishpa, kuyashpa rimay.
¿Maymantatak kikinpa hachika kan?
Sin. 2 yaya.
hakan</p>          </div>', 'ACTIVE', 1, '-'),
       (188, 'haku', '0', 'haku', '<div class="word--description">             <span class="word--fonetic">[xaku. aku]</span>              <p class="word--description">v. Vámos. Rishun ninka- pak rimana.
Raymita rikunkapak haku, nirka. hakuchik</p>          </div>', 'ACTIVE', 1, '-'),
       (189, 'hakuna', '0', 'hakuna', '<div class="word--description">             <span class="word--fonetic">[xakuna, akuna]</span>              <p class="word--description">v. amz. desmenu- zar. Imatapash makiwan ñutuchina.
Yurak sarata makiwan hakuni.
hallinka</p>          </div>', 'ACTIVE', 1, '-'),
       (190, 'hallkan', '0', 'hallkan', '<div class="word--description">             <span class="word--fonetic">[kalykaŋ, alykan]</span>              <p class="word--description">s. amz. variedad de cucaracha. Wasipi mirak uchilla yana hi- kishina.
Tamyapi yapa hallkan mirarka.
hallma</p>          </div>', 'ACTIVE', 1, '-'),
       (191, 'hallmana', '0', 'hallmana', '<div class="word--description">             <span class="word--fonetic">[xalymana, xažmana]</span>              <p class="word--description">v. desyer- bar. Chakramanta kiwakunata anchuchiy, all- pata yura chakipi churana.
Kaynaka sara chakrata hallmarkani.
Sin. Kiwana.

halunzu</p>          </div>', 'ACTIVE', 1, '-'),
       (192, 'hamallina', '0', 'hamallina', '<div class="word--description">             <span class="word--fonetic">[xamažina]</span>              <p class="word--description">v. ss. estar depri- mido (decaimiento físico e interno). Mana mi- kushpa, shunku kashpa llakiwan unkurina.
¿Ima nishpatak payka hamallin?
Sin. Impayana, kalakyana.
hamchi</p>          </div>', 'ACTIVE', 1, '-'),
       (193, 'hamlla', '0', 'hamlla', '<div class="word--description">             <span class="word--fonetic">[xamlya, xamža]</span>              <p class="word--description">adj. sc. desabrido,
insípido. Kachita mishkita mana charik mi- kuna. Mana mishki churakpika hamlla miku- nami llukshin.
2. sc. Apático, sin gracia. Shuk killaysiki, mana imatapash munak.
Chay mishuka hamllami karka.
Sin. 2 Chamuk, upa, chamcha, aminta, hamu.
hampara</p>          </div>', 'ACTIVE', 1, '-'),
       (194, 'hampatu', '0', 'hampatu', '<div class="word--description">             <span class="word--fonetic">[xambatu, xaŋbatu]</span>              <p class="word--description">s. s. variedad de sapo. Waykukunapi kawsak yana karayuk uchilla kuwa.
Hampatu wakakpika, ñami tamyanka, nin- chik.





HATUKU MAMA

dio, medicina. Alliyachik, sinchiyachik, tukuy unkuykunata wañuchik kiwakuna, aychata sinchiyachik muyukuna.
Kanka ¿ima hampikunata upyashpatak alli- yarkanki?
2. veneno. Imakunatapash wañuchik.
Hillu allkuman hampita rantimupanki. hampirina</p>          </div>', 'ACTIVE', 1, '-'),
       (195, 'hampiwasi', '0', 'hampiwasi', '<div class="word--description">             <span class="word--fonetic">[xampiwasi, xaŋbiwasi]</span>              <p class="word--description">s. hos- pital, centro de salud. Unkushkakunata alli- yachik wasi.
Wawaka uhu unkuywan ninantami ruparikun,
hampiwasiman apanki.
hampina</p>          </div>', 'ACTIVE', 1, '-'),
       (196, 'hamun', '0', 'hamun', '<div class="word--description">             <span class="word--fonetic">[xamun, gamuŋ, čamun]</span>              <p class="word--description">adj. tu. casi desabrido Ashalla kachiyuk mikuna, ashalla mishkiyuk mikuna.
Kay chawar mishkika hamunmi kashka. hamutana</p>          </div>', 'ACTIVE', 1, '-'),
       (197, 'hanak', '0', 'hanak', '<div class="word--description">             <span class="word--fonetic">[xanax, anax, xana, xanan, ana]</span>              <p class="word--description">adv. arriba, encima, alto, parte superior, elevado. Mana uray, wichayman rikuypak.
Juanchu yayaka hanakpi yapunkapak rikun. hanak pata</p>          </div>', 'ACTIVE', 1, '-'),
       (198, 'hankana', '0', 'hankana', '<div class="word--description">             <span class="word--fonetic">[xaŋkana, aŋgana, xaŋgana]</span>              <p class="word--description">v. cojear. Chaki unkushka kakpi wishtu wishtu puriy.
¿Yuramanta urmashpachu kankakunki? hapina</p>          </div>', 'ACTIVE', 1, '-'),
       (199, 'hapina', '0', 'hapina', '<div class="word--description">             <span class="word--fonetic">[xapina, apina]</span>              <p class="word--description">v. coger, apresar, asir Imatapash makiwan chariy.
¿Yayapa ushutatachu hapirkanki?
2. entender. Ima nishkakunata umapi yayku- china.
Kanka ¿yachachik willashkataka hapirkanki- chu?
hapiyu</p>          </div>', 'ACTIVE', 1, '-'),
       (200, 'harka', '0', 'harka', '<div class="word--description">             <span class="word--fonetic">[xarka, arka]</span>              <p class="word--description">s. obstáculo, barrera. Ama llukshichun, ama yaykuchun churas- hka.
Paykunami punkupi harkata churarka.
2. barras divisorias verticales. Ama yallichun shayachishka kaspikuna.
Wakra ama yallichun pallta pallta kaspi har- kata churarkani.
harkashka</p>          </div>', 'ACTIVE', 1, '-'),
       (201, 'harkana', '0', 'harkana', '<div class="word--description">             <span class="word--fonetic">[xarkana, arkana]</span>              <p class="word--description">v. atajar, obsta- culizar, detener, estorbar. Rurakukta sakichiy. Ama larka yaku tallirichun nishpa harkarkan- chik.
harnina</p>          </div>', 'ACTIVE', 1, '-'),
       (202, 'hatarina', '0', 'hatarina', '<div class="word--description">             <span class="word--fonetic">[xatarina, atarina]</span>              <p class="word--description">v. levantarse, al- zarse, pararse, ponerse de pie. Tiyakushpa, sirikushpa shayarina.
Unkushka warmika ñami hatarirka. hatuku mama</p>          </div>', 'ACTIVE', 1, '-'),
       (203, 'yaya', '0', 'yaya', '<div class="word--description">             <span class="word--fonetic">[xatuku yaya]</span>              <p class="word--description">s. abuelo. Yayamamakunapa yaya.
Hatuku yayaka allimantami purin. Sin. hatun yaya, hatun tayta.
hatun</p>          </div>', 'ACTIVE', 1, '-'),
       (204, 'hatunmama', '0', 'hatunmama', '<div class="word--description">             <span class="word--fonetic">[xatunmama]</span>              <p class="word--description">s. abuela. Ma- makunapa mama.
Hatunmamaka imatapash yallitami yachan. Sin. Wachaku, hatuku, hatuku mama. hatunyachaywasi</p>          </div>',
        'ACTIVE', 1, '-'),
       (205, 'hatunyaya', '0', 'hatunyaya', '<div class="word--description">             <span class="word--fonetic">[xatunyaya]</span>              <p class="word--description">s. abuelo. Yayapa, mamapa yaya.
Hatunyayawan imashina tapunata yachar- kani.
Sin. Hatuku, hatuku yaya, wachaku.
haw</p>          </div>', 'ACTIVE', 1, '-'),
       (206, 'hawa', '0', 'hawa', '<div class="word--description">             <span class="word--fonetic">[xawa, awa]</span>              <p class="word--description">adv.
arriba, alto, afuera. Mana wichaypi, mana ukupi kak.
María mashipa wasika rumi hawapimi riku- rin.
hawalla</p>          </div>', 'ACTIVE', 1, '-'),
       (207, 'haway', '0', 'haway', '<div class="word--description">             <span class="word--fonetic">[xaway]</span>              <p class="word--description">s. chim. canción de la cose- cha del trigo.
Siwara kuchuypi taki.
Chimborazo llaktapika siwara kuchuypimi ha- wayta takinchik.
haway (<**xaway) s. miércoles. Kimsaniki
puncha.
hawcha</p>          </div>', 'ACTIVE', 1, '-'),
       (208, 'hawchana', '0', 'hawchana', '<div class="word--description">             <span class="word--fonetic">[xawčana, xawtsana]</span>              <p class="word--description">v. sc. san- cochar, cocer a medias. Hawa hawalla ya- nushka mikunakuna.
Maria tiyaka yuyuta hawcharka.
hawina</p>          </div>', 'ACTIVE', 1, '-'),
       (209, 'hawina', '0', 'hawina', '<div class="word--description">             <span class="word--fonetic">[xawina, awina, xabina, kawina, ča- wina]</span>              <p class="word--description">v. sc. meterse en discusiones. Ima lla- kipipash satirina.
Kaypika yankamanta hawirishkanki. hawkay</p>          </div>', 'ACTIVE', 1, '-'),
       (210, 'hawriyana', '0', 'hawriyana', '<div class="word--description">             <span class="word--fonetic">[xawriyana]</span>              <p class="word--description">v. sc. carbonizarse los granos. Imatapash kamchakukpi shinki- tukushpa rupay.
Sara kamchaka hawriyashkami.
2. sn. Hacerse amargos los alimentos. Mi- kunakuna yalli wakllirina.
Sampu muyuta yalli kamchashpa hawriyas- hka.
hawya</p>          </div>', 'ACTIVE', 1, '-'),
       (211, 'hay', '0', 'hay', '<div class="word--description">             <span class="word--fonetic">[xay]</span>              <p class="word--description">interj. sn. amz. expresión desobe- diente. Killawan kashpa kutipay rimay.
¡Hay!, ¿imapaktak ñalla ñalla mashka- wanki?.




2. sn. expresión con llamada de atención en una conversación. Shuk rimaypi rik- chachinkapak rimay, imatapash rimakushpa tikrachiy.
¡Hay!, kayka karimi.
hayak</p>          </div>', 'ACTIVE', 1, '-'),
       (212, 'hayakin', '0', 'hayakin', '<div class="word--description">             <span class="word--fonetic">[kayakin]</span>              <p class="word--description">s. bilis.
Wiwakunapa, runakunapa yana shunkupi tiyak waylla rikurik hayak yaku.
Wiksayuk kashpaka ama shunku millanka- pakka kuy hayakintami millpuna kan.
Sin. chinkilis, hayak.
hayampi</p>          </div>', 'ACTIVE', 1, '-'),
       (213, 'haycha', '0', 'haycha', '<div class="word--description">             <span class="word--fonetic">[xayča]</span>              <p class="word--description">s. canción triunfal de la co-
secha o de la guerra. Sara pallay tukurikpi kushilla taki.
Inka pachapika awkakkunaka haycha takita takishka.
Sin. haylli.
haycha (<**haycha) s. viernes. Pichkaniki puncha.
hayka</p>          </div>', 'ACTIVE', 1, '-'),
       (214, 'haykamanta', '0', 'haykamanta', '<div class="word--description">             <span class="word--fonetic">[haykamanta]</span>              <p class="word--description">adv. s. de golpe, de pronto, el momento menos pen- sado, en seguida, sorpresivamente, súbita- mente. Shuk mana yuyashkapi utka utkalla, rurak katimuk, yallimuk.

HIKI
Haykamanta wawakunaka wakarkalla.
Sin. Kunkaymanta, zas.
haylli</p>          </div>', 'ACTIVE', 1, '-'),
       (215, 'haynallina', '0', 'haynallina', '<div class="word--description">             <span class="word--fonetic">[xaynažina]</span>              <p class="word--description">v. ss. bostezar. Ru- nakuna yarkachishpa, shaykushpa shimita paskay.
Yachachikka shaykushpa haynallirka.
Sin. Ampana.
hayñina</p>          </div>', 'ACTIVE', 1, '-'),
       (216, 'haytana', '0', 'haytana', '<div class="word--description">             <span class="word--fonetic">[xaytay, aytay]</span>              <p class="word--description">v. patear, cocear, pisar el arado. Chakiwan imatapash waktay. Juan wawaka hatun rumpata haytarka.
2. amz. pisar. Chakiwan imatapash allpapi si- rikta saruy.
Tuta purikuymanta machakuyta haytarkani.
Sin. 1ñitkay; 2 saruy.
hichana</p>          </div>', 'ACTIVE', 1, '-'),
       (217, 'hichuna', '0', 'hichuna', '<div class="word--description">             <span class="word--fonetic">[xičuna, ičuna]</span>              <p class="word--description">v. abandonar, des- amparar. Churikunata yaya mama piñana, imatapash shitay kunkarina.
Kanpa kuyashkataka ¿ñachu hichurkanki? hikama</p>          </div>', 'ACTIVE', 1, '-'),
       (218, 'hiki', '0', 'hiki', '<div class="word--description">             <span class="word--fonetic">[xiki, xixi, ixi]</span>              <p class="word--description">s. amz. saltamontes.
Sachapi kawsak llukllushina, shuk llaktaku- napi chillik nishka.



HIKIÑAS
Sachapi hikita rikurkani.
2. variedad de grillo. Chuklla ukupi kawsak yana chillik.
Yana hikita sachamanta apamuni.
Sin. Chillik.
hikiñas</p>          </div>', 'ACTIVE', 1, '-'),
       (219, 'hikyana', '0', 'hikyana', '<div class="word--description">             <span class="word--fonetic">[xikyana, xigyana, xixyana]</span>              <p class="word--description">v. so- llozar. Hatun llakiwan wakay.
Wawaka mamamanta hikyarka.
hillay</p>          </div>', 'ACTIVE', 1, '-'),
       (220, 'hilli', '0', 'hilli', '<div class="word--description">             <span class="word--fonetic">[xilyi]</span>              <p class="word--description">s. caldo, jugo, zumo; savia. Ima- kunapash yaku mikuna.
Atallpa hillitami yanunchik.
hillu</p>          </div>', 'ACTIVE', 1, '-'),
       (221, 'hipana', '0', 'hipana', '<div class="word--description">             <span class="word--fonetic">[xipana]</span>              <p class="word--description">v. sc. pujar. Uku wiksa- manta sinchi samayta tankashpa kachay. Rukuyaymanta, unkuymanta yalli aparishka- mantapash kalakyashpa samayta sinchita kachay.
Killa runaka, ashatalla aparishpapash hipan- llami.
hishi hishi</p>          </div>', 'ACTIVE', 1, '-'),
       (222, 'hita', '0', 'hita', '<div class="word--description">             <span class="word--fonetic">[xita]</span>              <p class="word--description">s. amz. lago, laguna. Sachapi, urku chakipi sakirishka hatun kucha.
Kay hitapika achka charapami tiyan.
Sin. Kucha.
hucha</p>          </div>', 'ACTIVE', 1, '-'),
       (223, 'huchanchina', '0', 'huchanchina', '<div class="word--description">             <span class="word--fonetic">[xučančina ,xučačina]</span>              <p class="word--description">v. cul- par. Pitapash kakpi, mana kakpi rurashkanki nina shimi.


Payka yankamanta huchanchirka.
huchu</p>          </div>', 'ACTIVE', 1, '-'),
       (224, 'huka', '0', 'huka', '<div class="word--description">             <span class="word--fonetic">[xuka]</span>              <p class="word--description">s. sc. huero. Lulunta ukllachik-
pi mana wawa pishku tukuk.
Huka lulunta ama mikunkichu upa wawatami wachanki, mana kashpaka kuyashkakuna hichunkami.
hukana</p>          </div>', 'ACTIVE', 1, '-'),
       (225, 'hukipuna', '0', 'hukipuna', '<div class="word--description">             <span class="word--fonetic">[xuxipuna, uxipuna]</span>              <p class="word--description">v. amz. Sil- bar. Wirpawan pinkullu takikshina uyachiy. Kanchaman llukshichun nishpa kuytsata hu- kipuni.
huklluyana</p>          </div>', 'ACTIVE', 1, '-'),
       (226, 'huku', '0', 'huku', '<div class="word--description">             <span class="word--fonetic">[xuku]</span>              <p class="word--description">adj. húmedo, mojado. Imapash ashalla ankuyashka kak.
Huku churanatami intiman churanki. hukuna</p>          </div>', 'ACTIVE', 1, '-'),
       (227, 'hullu', '0', 'hullu', '<div class="word--description">             <span class="word--fonetic">[xužu]</span>              <p class="word--description">adj. sc. desconocido, forastero,
extraño, extranjero, ajeno. Imapash mana ki- kinpashina kakpi shuk llaktamanta shamus- hka.
Payka, kay llaktapi hullumi kan.
Sin. Chikan, chuku, ista.
hulun</p>          </div>', 'ACTIVE', 1, '-'),
       (228, 'hulunchi', '0', 'hulunchi', '<div class="word--description">             <span class="word--fonetic">[xuluŋči]</span>              <p class="word--description">s. amz. tipo de árbol de madera incorruptible que se usa en construc- ción. Killu sisayuk, wasi chakita rurana, achka watapipash mana ismuk kaspi.




Hulunchi kaspiwan wasichirkani.


humpi</p>          </div>', 'ACTIVE', 1, '-'),
       (229, 'hunta', '0', 'hunta', '<div class="word--description">             <span class="word--fonetic">[xuŋda]</span>              <p class="word--description">adj. lleno, satisfecho, sa- ciado; entero. Imapash mana chushaklla, paktakta churashka.
Kay mankapi yakuta huntata apamunki. huntachina</p>          </div>', 'ACTIVE', 1, '-'),
       (230, 'huntana', '0', 'huntana', '<div class="word--description">             <span class="word--fonetic">[xuŋdana]</span>              <p class="word--description">v. llenarse, inundarse. Achkata tamyakpi yakukuna manchanayakta achkayay.
Kunan puncha sara chakrapi yaku huntarka.
Sin. Nuyuy, kuchayay.
hunu</p>          </div>', 'ACTIVE', 1, '-'),
       (231, 'hupi', '0', 'hupi', '<div class="word--description">             <span class="word--fonetic">[xupi]</span>              <p class="word--description">adj. sn. inútil. Mana imatapash ruranata ushak runa.
Chay runaka killamanta hupi tukushpa katin. hura</p>          </div>', 'ACTIVE', 1, '-'),
       (232, 'hushu', '0', 'hushu', '<div class="word--description">             <span class="word--fonetic">[xusu xusu]</span>              <p class="word--description">interj. amz. ex- presión para ahuyentar a los animales. Wi- wakunata manchachinkapak rimay.
¡Hushu hushu!, wakrakuna katiychik.
Sin. chisha, hishi, chi, kisha.
hutku</p>          </div>', 'ACTIVE', 1, '-'),
       (233, 'huwin', '0', 'huwin', '<div class="word--description">             <span class="word--fonetic">[xuwiŋ]</span>              <p class="word--description">s. amz. variedad de sapo co- mestible. Muru karayuk, tamya siririshka kipa, tutayakukpi win win kaparik hatun kuwa.
Huwinka kunanmi wakan.























icha</p>          </div>', 'ACTIVE', 1, '-'),
       (234, 'ichapash', '0', 'ichapash', '<div class="word--description">             <span class="word--fonetic">[ičapaš]</span>              <p class="word--description">adv. ss. quizá, quizás. Imapash ushay tukunkacha nirik shimi.
Luís yayaka ichapash kullkita mañachinka- wachari.
Sin. Icha, -cha, -chari.
ichillu</p>          </div>', 'ACTIVE', 1, '-'),
       (235, 'ichu', '0', 'ichu', '<div class="word--description">             <span class="word--fonetic">[iču]</span>              <p class="word--description">adj. rápido, apurado, ligero. Ima- tapash hawalla rurashpa mishashpa rurak runa.
Ñukapa yayaka ichu kashpami Hawalla wa- sita ruran.
ichu</p>          </div>', 'ACTIVE', 1, '-'),
       (236, 'ichuk', '0', 'ichuk', '<div class="word--description">             <span class="word--fonetic">[ičuk]</span>              <p class="word--description">adv. lado izquierdo. Imapash allawka makiman sakirik.
Shuk wawaka ichuk makiwanmi pukllak kan.
Sin. lluki.
ichuna</p>          </div>', 'ACTIVE', 1, '-'),
       (237, 'ichuna', '0', 'ichuna', '<div class="word--description">             <span class="word--fonetic">[ičuna]</span>              <p class="word--description">v. segar, cortar. Kiwakunata, yurakunata, murukunata pitina.
Puna suyu ayllullaktakunapika minkawanmi siwarata ichunchik.
ikina</p>          </div>', 'ACTIVE', 1, '-'),
       (238, 'ila', '0', 'ila', '<div class="word--description">             <span class="word--fonetic">[ila]</span>              <p class="word--description">s. amz. higuerón. Hatun yura ñañu pankayuk, yurak wiki llukshik yura.
Ila kaspiwanmi mikuypak patakukunataka ru- rashka kan.
illak</p>          </div>', 'ACTIVE', 1, '-'),
       (239, 'illapa', '0', 'illapa', '<div class="word--description">             <span class="word--fonetic">[ilyapa]</span>              <p class="word--description">s. escopeta. Pukuna kaspis- hina chawpika kaspimanta chawpika hillay- manta rurashka, nina-muruta tukyachikpi wiwakunata wañuchik anta.
Wiwakunata kamashpa charinkapakka illa- pataka chinkachinami kanchik.
Sin. tukyana.
illana</p>          </div>', 'ACTIVE', 1, '-'),
       (240, 'illimpu', '0', 'illimpu', '<div class="word--description">             <span class="word--fonetic">[ižimbu, ižiŋbu]</span>              <p class="word--description">s. sc. planta espi- nosa. Kashayuk uchilla yura, urkukunapi wiñak.
Wawapa chakipi illimpu kasha yaykushka. illulli</p>          </div>', 'ACTIVE', 1, '-'),
       (241, 'ilta', '0', 'ilta', '<div class="word--description">             <span class="word--fonetic">[ilta]</span>              <p class="word--description">s. amz. variedad de guaba. Hatun pakay mishki mikunayuk.
Wawakunaka anti suyupika iltataka sumakta mikurka.
ima</p>          </div>', 'ACTIVE', 1, '-'),
       (242, 'imamanta', '0', 'imamanta', '<div class="word--description">             <span class="word--fonetic">[imamaŋta, imamaŋda, ima- munda]</span>              <p class="word--description">adv. amz. ¿por qué? Imarayku, ima nishpa tapunkapak shimi.
¿Imamantatak warmikunaka yalli wacharin? imashi imashi</p>          </div>', 'ACTIVE', 1, '-'),
       (243, 'imashnaray', '0', 'imashnaray', '<div class="word--description">             <span class="word--fonetic">[imašnaray, imanaray]</span>              <p class="word--description">exp.
amz. muletilla del habla. Shutita kunkashpa rimay.
Imashnaray, chay runaka piñachu, kushichu kan?
Sin. Imashti.
imashti</p>          </div>', 'ACTIVE', 1, '-'),
       (244, 'impayana', '0', 'impayana', '<div class="word--description">             <span class="word--fonetic">[imbayana, iŋbayana]</span>              <p class="word--description">v. estar
deprimido física y espiritualmente. Unkus- hkashina, llakikunamanta kalakyashka kaw- say.
Payka mama wañushkamanta impayarka.
2. resentirse. Piñarishka tukushpa sakiriy. Yachachik rimashkamanta wawaka impaya- kun.
Sin. 1 Hamallina, kalakyana; 2 nanakyana. inchik</p>          </div>', 'ACTIVE', 1, '-'),
       (245, 'inka', '0', 'inka', '<div class="word--description">             <span class="word--fonetic">[iŋga, iŋka]</span>              <p class="word--description">s. emperador, rey, suprema
autoridad. Ñawpa pachapi tukuyta kamak apu.
España runakuna shamushpa wañuchishka- mantami mana inkataka charinchikchu. inku</p>          </div>', 'ACTIVE', 1,
        '-'),
       (246, 'inlli', '0', 'inlli', '<div class="word--description">             <span class="word--fonetic">[iŋlyi]</span>              <p class="word--description">adj. amz. tibio, caliente. Kunuklla
yaku.
Chiri tutamantaka inlli yakuwan ñawita may- llanchik.
Sin. Kunuk.


2. s. carne a medio asar. Ninapi ashalla ku- sarishka aycha.
Inlli aychataka wakaychinapimi sakin.
inta</p>          </div>', 'ACTIVE', 1, '-'),
       (247, 'inta', '0', 'inta', '<div class="word--description">             <span class="word--fonetic">[iŋta, iŋda]</span>              <p class="word--description">s. amz. tizón, leña con fuego. Tullpamanta surkushka ninayuk yanta. Yana tutapika inta nina kaspiwanllami purin- chik.
inti</p>          </div>', 'ACTIVE', 1, '-'),
       (248, 'anka', '0', 'anka', '<div class="word--description">             <span class="word--fonetic">[inti anka]</span>              <p class="word--description">s. amz. variedad de gavilán. Takik, inti punchakuna hawapi wampurayak pishku.
Inti ankaka sara chakra hawapi wampuraya- kun.
Sin. usturiw.
intillama</p>          </div>', 'ACTIVE', 1, '-'),
       (249, 'ayllu', '0', 'ayllu', '<div class="word--description">             <span class="word--fonetic">[intipa aylyu]</span>              <p class="word--description">s. sistema solar. Hawa pachapi tiyak rumpukuna.
Intipa aylluka pusak rumpuyukmi kan. intipacha</p>          </div>', 'ACTIVE', 1, '-'),
       (250, 'raymi', '0', 'raymi', '<div class="word--description">             <span class="word--fonetic">[inti raymi]</span>              <p class="word--description">s. fiesta del sol. Inti- manta hatun raymi. Kunanpipash inti ray- mita ruranchik.
intina</p>          </div>', 'ACTIVE', 1, '-'),
       (251, 'intiyana', '0', 'intiyana', '<div class="word--description">             <span class="word--fonetic">[intiyana]</span>              <p class="word--description">v. salir el sol. Inti rikuri- muna.
Tutamantataka inti yayaka sumaktami inti- yan.
intuna</p>          </div>', 'ACTIVE', 1, '-'),
       (252, 'intuna', '0', 'intuna', '<div class="word--description">             <span class="word--fonetic">[iŋduna]</span>              <p class="word--description">v. amz. amontonarse per-
sonas o animales. Wiwakuna, runakuna tan- tarina.
Rimanakuypika achka runami inturka.
2. s. colaboración. Imapipash yanapana. Minkapika intuykunawan utkalla llamkan- chik.
Sin. 1 Waykana; 2 yanapana.
iñil</p>          </div>', 'ACTIVE', 1, '-'),
       (253, 'ina', '0', 'ina', '<div class="word--description">             <span class="word--fonetic">[iñina]</span>              <p class="word--description">v. creer, asentir, testimoniar, tener fe. Shukpa yuyaykunata alli kakpi mana alli kakpipash chaskiy.
Umu willashkataka tukuykuna iñinllami.
iñu</p>          </div>', 'ACTIVE', 1, '-'),
       (254, 'irki', '0', 'irki', '<div class="word--description">             <span class="word--fonetic">[irki]</span>              <p class="word--description">adj. s. débil; flaco, raquítico. Runa kashpa, wiwa kashpapash mana mikushpa wañunalla tukushka. Yapa tsalamanta tullulla rikurik.
Chay irki runaka llakillami tikramushka.
Sin. Api, chusu, sampa.
ishkantin</p>          </div>', 'ACTIVE', 1, '-'),
       (255, 'ishkantishun', '0', 'ishkantishun', '<div class="word--description">             <span class="word--fonetic">[iškaŋdišun]</span>              <p class="word--description">expresión para brindar. Mashipura imatapash upyakushpa rimay.
Pushakkuna shamushkamantami ishkantis- hun.
Sin. Upyashun.


ishkay</p>          </div>', 'ACTIVE', 1, '-'),
       (256, 'ishkuna', '0', 'ishkuna', '<div class="word--description">             <span class="word--fonetic">[iškuna, iskuna, wiškuna]</span>              <p class="word--description">v. des- granar. Karata paskashpa murukunata sur- kuy.
Usya pachapika sarata chakichinkapakmi is- hkunchik.
Sin. Chiwana.
ishpapuru</p>          </div>', 'ACTIVE', 1, '-'),
       (257, 'ishpana', '0', 'ishpana', '<div class="word--description">             <span class="word--fonetic">[išpana]</span>              <p class="word--description">v. orinar. Ishpapurupi tan-
tarishka yakukunata pakchaman llukshi- china.
Yakuta yalli upyashpaka achkatami ishpan- chik.
Sin. Yaku-ishpana.
ishpinku</p>          </div>', 'ACTIVE', 1, '-'),
       (258, 'isi', '0', 'isi', '<div class="word--description">             <span class="word--fonetic">[izi, igzi]</span>              <p class="word--description">exp. amz. expresión despectiva
a los niños (mocosos). Wawata piñashpa rimay.
Isi wawakunataka ama tantanakuyman yay- kuchinkichu.
isi</p>          </div>', 'ACTIVE', 1, '-'),
       (259, 'isiyana', '0', 'isiyana', '<div class="word--description">             <span class="word--fonetic">[iziyana, idziyana]</span>              <p class="word--description">v. sc. empe-
rrarse. Wawa yapata wakashpa mamamanta mana karuyana.
Kay wawaka mamamanta isiyanka.
iska</p>          </div>', 'ACTIVE', 1, '-'),
       (260, 'isku', '0', 'isku', '<div class="word--description">             <span class="word--fonetic">[isku, išku]</span>              <p class="word--description">s. cal, yeso. Yurak allpas- hina wasi pirkakunata tullpukpi yurakta sakik. Kunan pacha wasikunaka iskuwan yurakya- chishkallami kan.
Sin. Pukshi.
islampu</p>          </div>', 'ACTIVE', 1, '-'),
       (261, 'isma', '0', 'isma', '<div class="word--description">             <span class="word--fonetic">[isma, izma]</span>              <p class="word--description">s. excremento, heces, mierda, abono, estiércol, deposición. Mikus- hka kipa sikimanta llukshik wanu.
Wiwakunapa ismawan imatapash tarpukpika achkatami murukunaka pukun.
ismana</p>          </div>', 'ACTIVE', 1, '-'),
       (262, 'ismu', '0', 'ismu', '<div class="word--description">             <span class="word--fonetic">[ismu]</span>              <p class="word--description">adj. podrido. Imapash ña wak- llirishka mana alli.
Ismu aychataka mana mikuy ushanchikchu.
Sin. ismushka.
ismushka</p>          </div>', 'ACTIVE', 1, '-'),
       (263, 'ismuna', '0', 'ismuna', '<div class="word--description">             <span class="word--fonetic">[ismuna]</span>              <p class="word--description">v. podrirse, descompo- nerse. Imapash wakllirishka tukuna.
Wanuka allpapimi ismun.
itsipu</p>          </div>', 'ACTIVE', 1, '-'),
       (264, 'itsipuna', '0', 'itsipuna', '<div class="word--description">             <span class="word--fonetic">[itsibuna]</span>              <p class="word--description">v. im. cerrar los ojos. Pu- ñunayakpi ñawita ñalla ñalla sipuy.
Ñawipi allpa yaykukpimi itsipun.
Sin. Sipuna, pimpinrana.
iwa</p>          </div>', 'ACTIVE', 1, '-'),
       (265, 'iwilan', '0', 'iwilan', '<div class="word--description">             <span class="word--fonetic">[iwilyan]</span>              <p class="word--description">s. arbusto. Allpa ukupi raku- yak, takakpi puskuyak, umata armankapak alli anku.
Rukuka, iwilan ankuwan umata arman.





























kacharina</p>          </div>', 'ACTIVE', 1, '-'),
       (266, 'kachana', '0', 'kachana', '<div class="word--description">             <span class="word--fonetic">[kačana]</span>              <p class="word--description">v. enviar, mandar. Ima- kunatapash maymanpash chayachiy.
Ñukapa killkashkata yayaman kachakuni.
2. echar, despedir. Millay kashkamanta pita- pash ukumanta llukshichiy.
Raymipi makanakuymanta kacharka.
Sin. 2 karkuna.
kachi</p>          </div>', 'ACTIVE', 1, '-'),
       (267, 'kachik', '0', 'kachik', '<div class="word--description">             <span class="word--fonetic">[kačix]</span>              <p class="word--description">s. amz, ss. guaba pequeña. Uchilla pakay, mayu manyakunapi pukuk, shuk llaktakunapi yaku pakay nishka yura. Sachapika kachik murutami mikun.
Sin. Pakay.
kachi kachi</p>          </div>', 'ACTIVE', 1, '-'),
       (268, 'kachun', '0', 'kachun', '<div class="word--description">             <span class="word--fonetic">[kačuŋ, xačuŋ]</span>              <p class="word--description">s. nuera. Churipa
warmi.
Ñukapa kachunka Cotacachi llaktamanta warmimi kan.
2. cuñada. Wawkipa warmi.
Kachunka ñukapa wawkita kuyashpami kawsan.
kahalli</p>          </div>', 'ACTIVE', 1, '-'),
       (269, 'kahas', '0', 'kahas', '<div class="word--description">             <span class="word--fonetic">[kaxas]</span>              <p class="word--description">s. cordillera. hatun urkuna kak.
Kahaskunapika papata, siwarata tarpunchik. kaka</p>          </div>', 'ACTIVE', 1, '-'),
       (270, 'kaka', '0', 'kaka', '<div class="word--description">             <span class="word--fonetic">[khaka, kaka]</span>              <p class="word--description">s. vaso redondo de ma- dera de cuello largo.
Suni kunkayuk kiru.
Kakapi aswata churani.
kakuna</p>          </div>', 'ACTIVE', 1, '-'),
       (271, 'kalak', '0', 'kalak', '<div class="word--description">             <span class="word--fonetic">[kalax]</span>              <p class="word--description">adj. snc. ss. deprimido; depre-
sión física y/o espiritual. Aychapash, yuyay samaypash unkushka.
Mishuka kalakllami kan.
kalamatu</p>          </div>', 'ACTIVE', 1, '-'),
       (272, 'kalatis', '0', 'kalatis', '<div class="word--description">             <span class="word--fonetic">[kalatis]</span>              <p class="word--description">s. amz. bejuco. Millmayuk pakayta aparik sacha anku, yaku manyapi wiñak yura.
Wawakunaka kalatis ankuwanmi pukllan.
Sin. Pulanti.
kallampa</p>          </div>', 'ACTIVE', 1, '-'),
       (273, 'kallana', '0', 'kallana', '<div class="word--description">             <span class="word--fonetic">[kalyana, kažana]</span>              <p class="word--description">s. tiesto. Turu all-


pamanta rurashka hatun pukushina rikurik. Murukunata kamchankapak, tantata kusan- kapak may alli.
Allpa kallanapi kusashka tantataka may mishkimi kan.
kallari</p>          </div>', 'ACTIVE', 1, '-'),
       (274, 'kallarina', '0', 'kallarina', '<div class="word--description">             <span class="word--fonetic">[kalyarina, kažarina]</span>              <p class="word--description">v. comenzar, principiar, iniciar, empezar.
Imatapash shuknikimanta rurarina. Runakunaka inti rikurishkamantami llam- kayta kallarin.
kallcha</p>          </div>', 'ACTIVE', 1, '-'),
       (275, 'pacha', '0', 'pacha',
        '<div class="word--description">             <span class="word--fonetic">[kalyčay pača]</span>              <p class="word--description">s. tiempo de siega. Ima chakishka tarpushkata kuchuy. Kallchay pachapika aswata upyanchik. kalli kalli</p>          </div>',
        'ACTIVE', 1, '-'),
       (276, 'kallpana', '0', 'kallpana', '<div class="word--description">             <span class="word--fonetic">[kalypana, kažpana, kalpana]</span>              <p class="word--description">v.
correr, trotar. Utka utka tatkishpa purina. Ñukapa churika yachanawasiman ñami kall- parka.
kallwa</p>          </div>', 'ACTIVE', 1, '-'),
       (277, 'kallu', '0', 'kallu', '<div class="word--description">             <span class="word--fonetic">[xažu, kažu, khažu, khalyu, xalyu, kalyu]</span>              <p class="word--description">s. lengua. Shimi ukupi kuyurishpa rimachik aycha.
Manuel runaka wakra kalluta rantinkapak rin.
kaluk</p>          </div>', 'ACTIVE', 1, '-'),
       (278, 'kamachik', '0', 'kamachik', '<div class="word--description">             <span class="word--fonetic">[kamačik]</span>              <p class="word--description">s. juez, autoridad. Ka-
machiyta paktachichik runa.
Ñukapa kitipika alli kamachikta charinchik.
kamachinakuy (<**kamachinakuy) s. De-


recho: conjunto de leyes que regulan el com- portamiento recíproco de los hombres.
Kichwa kamachinakuyka rimayllapimi tiyan, chayrak killkakunmi.
kamachina</p>          </div>', 'ACTIVE', 1, '-'),
       (279, 'kamachiy', '0', 'kamachiy', '<div class="word--description">             <span class="word--fonetic">[kamačiy]</span>              <p class="word--description">s. ley, reglamento, ar- tículo. Ama pantachun. Alli kunay yuyayyukta killkashka.
Alli rurashka kamachiymi kay llaktapika illan.
kamari</p>          </div>', 'ACTIVE', 1, '-'),
       (280, 'kamarina', '0', 'kamarina', '<div class="word--description">             <span class="word--fonetic">[kamarina]</span>              <p class="word--description">v. regalar. Pimanpash imallatapash yanka karay.
Raymipika rantipak mikunataka kamarinchik.
Sin. karana.
kamana</p>          </div>', 'ACTIVE', 1, '-'),
       (281, 'kamana', '0', 'kamana', '<div class="word--description">             <span class="word--fonetic">[kamana]</span>              <p class="word--description">v. amz. competir. Imaku- napipash shukkunawan chimpapurachishpa maykan maykan alli kashkata yachankapak tupuna.
Wawakunaka yachana wasipa muyuntin ñankunata kallpashpami kaman.
Sin. Mishana.
kamana</p>          </div>', 'ACTIVE', 1, '-'),
       (282, 'kamana', '0', 'kamana', '<div class="word--description">             <span class="word--fonetic">[kamana]</span>              <p class="word--description">v. cuidar; gobernar. Ru- nakuna, apukkuna llaktakunata rikushpa kawsay.




Ñukapa yayaka wakrata chukllapi kaman.
Sin. Pushana, wakaychina.
kamay (<*kamay) s. enero. Shukniki killa. Kamay killapika, wakin kichwa llaktakuna- pika Reyes raymita ruran.
kamcha</p>          </div>', 'ACTIVE', 1, '-'),
       (283, 'kamina', '0', 'kamina', '<div class="word--description">             <span class="word--fonetic">[kamina]</span>              <p class="word--description">v. insultar. Pitapash millay shimiwan rimana.
Shuwataka achka yayakunami kamikun.
Sin. ahana, takurina.
kampik</p>          </div>', 'ACTIVE', 1, '-'),
       (284, 'kan', '0', 'kan', '<div class="word--description">             <span class="word--fonetic">[kan, xam]</span>              <p class="word--description">pron. Tú, usted. Ishkayniki shutipa ranti ninkapak rimay.
¿Kanllachu kayna punchaka llamkarkanki? kancha</p>          </div>', 'ACTIVE', 1, '-'),
       (285, 'kanchis', '0', 'kanchis', '<div class="word--description">             <span class="word--fonetic">[kaŋčis]</span>              <p class="word--description">num. siete. Suktaniki yu-
payta katik yupay.
Kanchis llamata urkupi charini. kanichina</p>          </div>', 'ACTIVE', 1, '-'),
       (286, 'kanina', '0', 'kanina', '<div class="word--description">             <span class="word--fonetic">[kanina]</span>              <p class="word--description">v. morder, picar (insectos). Chuspishina wiwakuna, shimiwan nanakta aychata hapina.
Añanku wiwaka chakita kanirka.


Sin. Mikuna, kashtuna.
kankik</p>          </div>', 'ACTIVE', 1, '-'),
       (287, 'kankil', '0', 'kankil', '<div class="word--description">             <span class="word--fonetic">[kaŋgil]</span>              <p class="word--description">s. amz. canguil. Kamchakpi
tukyak uchilla killu sara.
Mamaka kankilta pallankapak rirka. kankuna</p>          </div>', 'ACTIVE', 1, '-'),
       (288, 'kantina', '0', 'kantina', '<div class="word--description">             <span class="word--fonetic">[kaŋtina]</span>              <p class="word--description">v. amz. buscar peces bajo
piedras. Challwakunata rumi sikipi maskay.
Hatun rumi sikipi challwata kantini.
2. mecer. Mikuna apita, shukkunatapash kaspiwan kuyuchina.
Mishkita hampi yakupi kantirka.
kapak</p>          </div>', 'ACTIVE', 1, '-'),
       (289, 'kaparina', '0', 'kaparina', '<div class="word--description">             <span class="word--fonetic">[kaparina]</span>              <p class="word--description">v. gritar, chillar. Yapa
sinchita rimana.
Ñukapa turika shuwata kaparirka.
2. ladrar. Allku, runatapash, wiwatapash aw aw nina.
Marìapa allkuka hillu misita kaparikun. Sin. 2 Awnina.
kapi runa</p>          </div>', 'ACTIVE', 1, '-'),
       (290, 'kapina', '0', 'kapina', '<div class="word--description">             <span class="word--fonetic">[kapina]</span>              <p class="word--description">v. ordeñar, exprimir. Wakra ñuñuta chawana.
Rosa mamaka wakra ñuñutaka kaynami ka- pirka.
Sin. Chawana.
kapuli</p>          </div>', 'ACTIVE', 1, '-'),
       (291, 'kapya', '0', 'kapya', '<div class="word--description">             <span class="word--fonetic">[kabya]</span>              <p class="word--description">adj. ss. frágil, muy suave.


riyakun
Sin. Alliyana, hampirina.



Imakunapash may amuklla, yapa ñutu kak.
Yanushka mutika ñami kapya tukun.
Sin. Ñutu, api, llampu, amuk, ishkurik. kapyarina</p>          </div>', 'ACTIVE', 1, '-'),
       (292, 'kara', '0', 'kara', '<div class="word--description">             <span class="word--fonetic">[kara]</span>              <p class="word--description">s. piel, cuero, pellejo, cáscara.
Tukuy runakunapa, wiwakunapa ukkuta pi- llurik.
Maki karapimi sisu unkuyka hapin.
2. cáscara, corteza. Yura kaspikunata, muyu- kunata pilluriyashpa killpak.
Habas karata llushtikuni.
karacha</p>          </div>', 'ACTIVE', 1, '-'),
       (293, 'karachi', '0', 'karachi', '<div class="word--description">             <span class="word--fonetic">[karachi, karatsi]</span>              <p class="word--description">s. sn. estopa de cabuya. Chawar karata takakpi llukshik puntsu.
Chawar karachita apamuni.
Sin. Pakpa, pala, puntsu, hamchi.
karana</p>          </div>', 'ACTIVE', 1, '-'),
       (294, 'kari', '0', 'kari', '<div class="word--description">             <span class="word--fonetic">[xari, kari, khari]</span>              <p class="word--description">adj. hombre, varón; macho. Runa kashpa, wiwa kashpapash mana chichuk. Yurakunaka raku, sinchipashmi kan.
Urkukunapika kari wakrakunatalla char- inchik.
2. amz. esposo, marido. Kuyashka warmi- wan kawsankapak sawarik runa.
Kanpak karika ¿ima shutitak kan?
Sin. 2 kusa.
kariyana</p>          </div>', 'ACTIVE', 1, '-'),
       (295, 'karkayana', '0', 'karkayana', '<div class="word--description">             <span class="word--fonetic">[karkayana]</span>              <p class="word--description">v. s. ensuciarse, mancharse el rostro y el pecho. Ñawi kas- hpa, churana kashpa, ima kashpapash turu- yay, yana tukuy, mapayaymi kan.
Wawaka apita mikushpa karkayan.
Sin. Mapayana, wikiyana, hawiyana, llunchi- yana.
karkuna</p>          </div>', 'ACTIVE', 1, '-'),
       (296, 'karpa', '0', 'karpa', '<div class="word--description">             <span class="word--fonetic">[karpa]</span>              <p class="word--description">s. cubierta grande, toldo. Wa- sitashina rurashpa katallata churashka. Tam- yamanta, intimantapash mitikunkapak alli. Pintushina hatun kata rurashka wasi.
Wakrakamakka karpa ukupimi puñun. karu</p>          </div>', 'ACTIVE', 1, '-'),
       (297, 'karuyana', '0', 'karuyana', '<div class="word--description">             <span class="word--fonetic">[karuyana]</span>              <p class="word--description">v. alejarse. Kuchu- manta anchurishpa karuyana.
¿Imamantatak kanka warmimanta karuya-
kunki?
kasa</p>          </div>', 'ACTIVE', 1, '-'),
       (298, 'kasana', '0', 'kasana', '<div class="word--description">             <span class="word--fonetic">[kasana]</span>              <p class="word--description">v. s. helar, caer la helada.
Chakishka rasu chakrakunapi urmay. Kunan tutami papa chakrapi kasashka. kasha</p>          </div>', 'ACTIVE', 1, '-'),
       (299, 'kashtuna', '0', 'kashtuna', '<div class="word--description">             <span class="word--fonetic">[kaštuna]</span>              <p class="word--description">v. s. mascar, masticar.
Mikunata kirukunawan mukuna.
Kiru illak rukukunaka mana alli kashtunchu.
Sin. Kaskana, mukuna.
kashuk</p>          </div>', 'ACTIVE', 1, '-'),
       (300, 'kasilla', '0', 'kasilla', '<div class="word--description">             <span class="word--fonetic">[kasilla]</span>              <p class="word--description">adj. quieto, tranquilo, pací- fico, sereno. Wawa kashpa, wiwa kashpa- pash upalla tukuy.




KASKU
Pushak runaka may kasillami kan.
kasku</p>          </div>', 'ACTIVE', 1, '-'),
       (301, 'kaskana', '0', 'kaskana', '<div class="word--description">             <span class="word--fonetic">[kaskana]</span>              <p class="word--description">v. scs. desgastar, roer, pelar con los dientes. Mikunakunata, shuk- kunatapash kirukunawan mukuna.
Chay allkuka wakra tullutami kaskakun. Sin. Kashtuna, mukuna.
kaspa</p>          </div>', 'ACTIVE', 1, '-'),
       (302, 'kaspana', '0', 'kaspana', '<div class="word--description">             <span class="word--fonetic">[kaspana]</span>              <p class="word--description">v. s. chamuscar. Wi-
wapa millmata rupachishpa anchuchina. Kuchitaka raymipi mikunkapakmi kaspar- kani.
Sin. Rupachina.
kaspi</p>          </div>', 'ACTIVE', 1, '-'),
       (303, 'kastilla', '0', 'kastilla', '<div class="word--description">             <span class="word--fonetic">[kastilya, kaštilya]</span>              <p class="word--description">adj. España, de Castilla. Españamanta kak.
Kaypika kastilla shimitapash riman. katana</p>          </div>', 'ACTIVE', 1, '-'),
       (304, 'katana', '0', 'katana', '<div class="word--description">             <span class="word--fonetic">[katana, khatana, xatana]</span>              <p class="word--description">v. cobijar, cubrir. Imawanpash hawamanta killpay.
Urkupika wayta ukshawan katanchik.
2 s. techar. Pankakunawan, ukshawan, shukkunawanpash wasita killpay.
Lisan pankawan wasitaka katarkanchik. katichina</p>          </div>', 'ACTIVE', 1, '-'),
       (305, 'kati', '0', 'kati', '<div class="word--description">             <span class="word--fonetic">[kati kati]</span>              <p class="word--description">interj. expresión para hacer caminar a personas o animales. Yapu- kuk wakrakuna wachuta purishpa richun nina


shinchi rimay.
Yayaka wakra yuntata kati kati nishpami ya- pukun.
Sin. Richun.
katina</p>          </div>', 'ACTIVE', 1, '-'),
       (306, 'katsu', '0', 'katsu', '<div class="word--description">             <span class="word--fonetic">[katsu, kazu, xatsu]</span>              <p class="word--description">s. sn, sc. escara- bajo. Kuzu kuru rukuyashpa chuspiman ti- krashka wiwa. Tamya pachakunapi ashtawan pawashpa purik, wakinkunaka mikunkapak allimi.
Imbabura llaktapika katsukunata kamchas- hpami mikun.
Sin. chuna.
katu</p>          </div>', 'ACTIVE', 1, '-'),
       (307, 'katuwasi', '0', 'katuwasi', '<div class="word--description">             <span class="word--fonetic">[katuwasi, xatukwasi]</span>              <p class="word--description">s. alma-
cén, tienda. Mutsurishkakunata katunkapak charik.
Katuwasimanta kachita rantirkani.
katuna</p>          </div>', 'ACTIVE', 1, '-'),
       (308, 'kaw', '0', 'kaw', '<div class="word--description">             <span class="word--fonetic">[kaw]</span>              <p class="word--description">adj. choclo bien maduro. Chukllu
pukurishpa saraman tikray kallarik. Manarak chakirishka muru.
Kaw sarawanmi chukllu tantataka ruran. Sin. Walu, paruk, halun.
kawana</p>          </div>', 'ACTIVE', 1, '-'),
       (309, 'kawchu', '0', 'kawchu', '<div class="word--description">             <span class="word--fonetic">[kawču]</span>              <p class="word--description">s. piola, soguilla. Ima puchkakunatapash pillushpa pillushpa sinchi rurashka ñañu waska.




Wayakata watankapak kawchuta apani. kawchushka</p>          </div>', 'ACTIVE', 1, '-'),
       (310, 'kawchuna', '0', 'kawchuna', '<div class="word--description">             <span class="word--fonetic">[kawčuna]</span>              <p class="word--description">v. torcer. Puchka-
pura pilluchishpa ishkay makiwan waskana.
Kanka ¿chawartachu kawchukunki?
2. hacer soga. Puchkapura pilluchishpa waskata ruray.
Kanka ¿waskata rurankapakchu kaw- chunki?
Sin. Kawpuna.
kawina</p>          </div>', 'ACTIVE', 1, '-'),
       (311, 'kawirina', '0', 'kawirina', '<div class="word--description">             <span class="word--fonetic">[kawirina]</span>              <p class="word--description">v. amz. revolcarse; ha- cerse un movimiento en vaivén. Kayman chayman kuyurina.
Kanpa wawaka turupimi kawirikun. kawitu</p>          </div>', 'ACTIVE', 1, '-'),
       (312, 'kawina', '0', 'kawina', '<div class="word--description">             <span class="word--fonetic">[kawina, xawina, kabina]</span>              <p class="word--description">v. batir,
mecer, menear, mover. Imatapash muyuchis- hpa kuyuchina.
Aswata rurankapak sara akuta kaspiwanmi
kawin.
Sin. Muyuchina, kuyuchina.
kawka</p>          </div>', 'ACTIVE', 1, '-'),
       (313, 'kawlla', '0', 'kawlla', '<div class="word--description">             <span class="word--fonetic">[kawlya]</span>              <p class="word--description">adv. amz. crocante. Imata- pash mikukpi kaw kaw uyarik.
Sarataka kawlla uyarayarichunmi kam- chanki.
kawllarina</p>          </div>', 'ACTIVE', 1, '-'),
       (314, 'kawpi', '0', 'kawpi', '<div class="word--description">             <span class="word--fonetic">[gawpi]</span>              <p class="word--description">s. amz. variedad de tucán pequeño. Uchilla suni kiruyuk, sikwankashina pishku.
Kawpika chunta yurapimi tiyakun. kawpuna</p>          </div>', 'ACTIVE', 1, '-'),
       (315, 'kawsak', '0', 'kawsak', '<div class="word--description">             <span class="word--fonetic">[kawsak]</span>              <p class="word--description">s. ser vivo, viviente. May- kanpash wañunkakama tiyak.
Kay llaktapi kawsakkunaka tantalla tarpun. kawsay</p>          </div>', 'ACTIVE', 1, '-'),
       (316, 'kawtayana', '0', 'kawtayana', '<div class="word--description">             <span class="word--fonetic">[kawtayana]</span>              <p class="word--description">v. amz. aplastar, machacar. Ñitikpi waklliriy, llapiriy.
Ashanka hawapi ama tiyarichun kawtayan- kami.
kana</p>          </div>', 'ACTIVE', 1, '-'),
       (317, 'kay', '0', 'kay', '<div class="word--description">             <span class="word--fonetic">[kay]</span>              <p class="word--description">pron. este, esta, esto. Imatapash rikuchinkapak rimay.
Kaymi ñukapa wasi.
kaya</p>          </div>', 'ACTIVE', 1, '-'),
       (318, 'kayantin', '0', 'kayantin', '<div class="word--description">             <span class="word--fonetic">[kayantin]</span>              <p class="word--description">adv.
Kayapa washa punchami kan.
¿Kayantintaka shamusha ninkichu?.
Sin. MIncha.
kayas</p>          </div>', 'ACTIVE', 1, '-'),
       (319, 'kayana', '0', 'kayana', '<div class="word--description">             <span class="word--fonetic">[kayana]</span>              <p class="word--description">v. llamar. Runakunata, wi- wakunatapash, shamuy nishpa kuchuya- china. Wawa kuchita kayakuni.
2.	invitar. Raymikunaman, mikuykunaman, tushuykunaman, upyaykunamanpash sha- muy nina.
Kaya puncha ñuka raymiman mashikunata
kayasha.
3.	citar, convocar. Maypipash, ima pachapi- pash, piwanpash rikurinkapak yuyariy.
Quito llaktaman tantanakuypak kayarka. kayka</p>          </div>', 'ACTIVE', 1, '-'),
       (320, 'kayllayana', '0', 'kayllayana', '<div class="word--description">             <span class="word--fonetic">[kaylyayana, kayžayana]</span>              <p class="word--description">v. snc, amz. acercarse. Kuchuyashpa kimirina.
Mashi yachachikka wasiman kayllayarka. Sin. Kuchuyana, manyayana, llutarina, kimi- rina.
kayna</p>          </div>', 'ACTIVE', 1, '-'),
       (321, 'kaynarina', '0', 'kaynarina', '<div class="word--description">             <span class="word--fonetic">[kaynarina]</span>              <p class="word--description">v. demorarse, holga- zanear. Ashtawan yalli pachata sakirina.
Kanka kaynaka, ¿maypitak kaynarkanki? kaypi</p>          </div>', 'ACTIVE', 1, '-'),
       (322, 'kaytu', '0', 'kaytu', '<div class="word--description">             <span class="word--fonetic">[kaytu]</span>              <p class="word--description">s. hebra de hilo. Imapash puchkashina.
Kay kaytuwan sirakuni.
kazuk</p>          </div>', 'ACTIVE', 1, '-'),
       (323, 'kicha', '0', 'kicha', '<div class="word--description">             <span class="word--fonetic">[kiča, xiča]</span>              <p class="word--description">s. diarrea. Wiksa waklli- rikpi yaku tukushpa llukshik isma.
Kanpa wawaka kicha unkuywanmi kan. kichana</p>          </div>', 'ACTIVE', 1, '-'),
       (324, 'kichki', '0', 'kichki', '<div class="word--description">             <span class="word--fonetic">[kički, kiški, kičixi, kiski]</span>              <p class="word--description">adj. estrecho, angosto, tupido. Imapash mana chushaklla rikurik.
Sacha ñankunaka achka kichkimi kan.
kichuna</p>          </div>', 'ACTIVE', 1, '-'),
       (325, 'kiki', '0', 'kiki', '<div class="word--description">             <span class="word--fonetic">[kiki]</span>              <p class="word--description">s. choclo en formación. Llullu sara
chayrak kutulyay kallarik.
Ñukapa sara chakraka chayrak kikillami kan. kikin</p>          </div>', 'ACTIVE', 1, '-'),
       (326, 'kikin', '0', 'kikin', '<div class="word--description">             <span class="word--fonetic">[kikiŋ]</span>              <p class="word--description">pron. usted. Kanta ninkapak shimi.
Kikinka sinchi yuyayyuk hatun yayami kanki.
Sin. kan.
kila</p>          </div>', 'ACTIVE', 1, '-'),
       (327, 'kilampu', '0', 'kilampu', '<div class="word--description">             <span class="word--fonetic">[kilampu, kilambu]</span>              <p class="word--description">s. amz. varie- dad de bejuco. Kashayuk waskashina yura. Sachapi wiñak.
Allpa manyakunata ama pipash yallichunka
kilampu yuratami tarpunkuna.
killa</p>          </div>', 'ACTIVE', 1, '-'),
       (328, 'killa', '0', 'killa', '<div class="word--description">             <span class="word--fonetic">[kilya, kiža]</span>              <p class="word--description">s. luna. Tutakunalla intishina punchayachik.
Llullu killapi churanakunata takshakpika ña- pashmi hutkurin.
2. mes (kamay, panchiy, pawkar, ayriwa, ay- muray, inti raymi, purun, chakmay, kuya raymi, yaku raymi, ayarmaka, kapak inti raymi). Kimsa chunka punchayuk pacha. Usya killakuna pallay kan. murukunataka pa- llay kan.
killiku</p>          </div>', 'ACTIVE', 1, '-'),
       (329, 'killimsa', '0', 'killimsa', '<div class="word--description">             <span class="word--fonetic">[kilyimsa]</span>              <p class="word--description">s. carbón. Yanta kaspi ru- pashkakunapi puchuk yana tukushka kaspi. Sacha rupachishkamanta killimsakunata tantanchik.
Sin. shinki.
killin</p>          </div>', 'ACTIVE', 1, '-'),
       (330, 'killka', '0', 'killka', '<div class="word--description">             <span class="word--fonetic">[kilyka, kiška, kilka]</span>              <p class="word--description">s. letra. Killkanka- pak shuyu.
Kichwa shimipika: a, ch, h, i, k… killkakunami tiyan.
Wawakunaka killkakunata ruran. killkakatina</p>          </div>', 'ACTIVE', 1, '-'),
       (331, 'killkana', '0', 'killkana', '<div class="word--description">             <span class="word--fonetic">[kilykana]</span>              <p class="word--description">v. escribir. Killkana kaspi- wan pankapi killkakunata shuyuna.
Payka killa llamkay willayta killkan. killpana</p>          </div>', 'ACTIVE', 1, '-'),
       (332, 'killpuntu', '0', 'killpuntu', '<div class="word--description">             <span class="word--fonetic">[kilpuŋdu]</span>              <p class="word--description">s. amz. pájaro verde.
Waylla patpayuk allpa hutkupi kawsak uchilla pishku.
Sara chakra ukupika achka killpuntumi kaw- san.
killu</p>          </div>', 'ACTIVE', 1, '-'),
       (333, 'kimirina', '0', 'kimirina', '<div class="word--description">             <span class="word--fonetic">[kimirina]</span>              <p class="word--description">v. acercarse. Shukpa ku-
chuman chayarina.
Wawakuna ña wasiman kimirin.
Sin. Kayllayana, kuchuyana, manyayana, llu- tarina.
kimina</p>          </div>', 'ACTIVE', 1, '-'),
       (334, 'kimsa', '0', 'kimsa', '<div class="word--description">             <span class="word--fonetic">[kimsa, kiŋsa]</span>              <p class="word--description">num. tres. Ishkay
washata katik yupay.
Payka kimsa wallinkutami charin.
kincha</p>          </div>', 'ACTIVE', 1, '-'),
       (335, 'kinchana', '0', 'kinchana', '<div class="word--description">             <span class="word--fonetic">[kiŋčana, kiŋžana]</span>              <p class="word--description">v. hacer un co- rral o cerca. Kaspikunawan pirkatashina ru- rashpa harkana.
Wawakuna	pukllachun,	yachana	wasi manya muyuntinta kinchanchik.
kinku</p>          </div>', 'ACTIVE', 1, '-'),
       (336, 'kinkuna', '0', 'kinkuna', '<div class="word--description">             <span class="word--fonetic">[kiŋkuna]</span>              <p class="word--description">v. curvar, ir en zig-zag.
Alliman llukiman muyushpa rurana, purina. Kay urku chakita manyashpaka alliman kinkushun.
kinray</p>          </div>', 'ACTIVE', 1, '-'),
       (337, 'kinti', '0', 'kinti', '<div class="word--description">             <span class="word--fonetic">[kinti, kiŋdi]</span>              <p class="word--description">s. colibrí. Waylla patpayuk
suni chupayuk, sisa mishkita	chumkak uchilla pishku.
Kinti pishkutaka mana hapinachu kan. kintiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (338, 'kinuwa', '0', 'kinuwa', '<div class="word--description">             <span class="word--fonetic">[kinwa, kinuwa, kiniwa, kiñiwa]</span>              <p class="word--description">(<*kiwña) s. quinoa. Rumpashina uchilla yurak muru, sisapi muruyuk.
Puna suyupika achkatami kinuwa murutaka tarpunkuna.
kinzhullina</p>          </div>', 'ACTIVE', 1, '-'),
       (339, 'kipa', '0', 'kipa', '<div class="word--description">             <span class="word--fonetic">[kipa, khipa, xipa]</span>              <p class="word--description">adv. después, a con- tinuación, seguidamente. Ñawpakkunata katik.
Ambato llaktamanta tikramushka, kipaka ya-



punkapakmi rini.
kipa</p>          </div>', 'ACTIVE', 1, '-'),
       (340, 'kipana', '0', 'kipana', '<div class="word--description">             <span class="word--fonetic">[khipana, kipana, xipana]</span>              <p class="word--description">v. ss. tocar la “quipa”. Kipapi pukushpa uyachina.
Utkalla tantarinkapak mashikunaka kipan. kipchan</p>          </div>', 'ACTIVE', 1, '-'),
       (341, 'kipi', '0', 'kipi', '<div class="word--description">             <span class="word--fonetic">[kipi]</span>              <p class="word--description">s. maleta, bulto, fardo. Hatun shi- krashina ukupi imatapash churashpa apana- llata rurashka.
Ñuka, kipita antawapi kacharkani.
kipu</p>          </div>', 'ACTIVE', 1, '-'),
       (342, 'kipuna', '0', 'kipuna', '<div class="word--description">             <span class="word--fonetic">[kipuna]</span>              <p class="word--description">v. escribir en nudos. Inka-
kunapa waskapi killkay.
Amawtakunaka kikin kawsayta kipushka. kiru</p>          </div>', 'ACTIVE', 1, '-'),
       (343, 'kiru', '0', 'kiru', '<div class="word--description">             <span class="word--fonetic">[kiru, kero]</span>              <p class="word--description">s. palo que nace del cabuyo.
Chawar sapimanta suni kaspi wiñashka. Puna suyumanta ñawpa runakunaka chawar kiruwanllami wasikunataka rurarka.
2.	madera. Hatun yurakunapa kaspikuna. Ukalitu	kirukunata	wasichinkapak	al- lichikunchik.
3.	viga. Pallkayachishka kaspi.
Wasipi ishkay shayak kirukunatami al- lichikunchik.
kiruyana</p>          </div>', 'ACTIVE', 1, '-'),
       (344, 'kiruyuk', '0', 'kiruyuk', '<div class="word--description">             <span class="word--fonetic">[kiruyux]</span>              <p class="word--description">s. amz. pez grande con dientes, similar al bocachico. Kiruyuk hatun challwa.
Kiruyuk challwata kusakmi rini.
kisha</p>          </div>', 'ACTIVE', 1, '-'),
       (345, 'kisha', '0', 'kisha', '<div class="word--description">             <span class="word--fonetic">[kiša kiša, kiši]</span>              <p class="word--description">expresión para ahuyentar a los animales. Wiwakunata kall- pachinkapak kaparina.
Wakrata kisha kisha nishpa kaparishpa ut- kata kallpachin.
Sin. chi, hushu hushu, chisha chisha, kisha kisha.
kishpichina</p>          </div>', 'ACTIVE', 1, '-'),
       (346, 'kishpirina', '0', 'kishpirina', '<div class="word--description">             <span class="word--fonetic">[kišpirina]</span>              <p class="word--description">v. salvarse, liberarse.
Llakimanta llukshirina.
Ñukanchikka kichwa shimita rimashpami kis- hpirishun.
Sin. Kishpikuna.
kishpina</p>          </div>', 'ACTIVE', 1, '-'),
       (347, 'kita', '0', 'kita', '<div class="word--description">             <span class="word--fonetic">[xita, kita]</span>              <p class="word--description">adj. arisco, indómito. Yapa manchaysiki wiwa.
Kita kuchi kashkamantami katunkapak rini.
Sin. Millay.
kiti</p>          </div>', 'ACTIVE', 1, '-'),
       (348, 'kitilli', '0', 'kitilli', '<div class="word--description">             <span class="word--fonetic">[kitilli]</span>              <p class="word--description">s. parroquia. Tawka ayllu llakta- kunata shukllapi tantachishkata rikuchik shuti.
Sapan kitikunami kitillipi rakirishka kan. kitina</p>          </div>', 'ACTIVE', 1, '-'),
       (349, 'kitiwpi', '0', 'kitiwpi', '<div class="word--description">             <span class="word--fonetic">[kitiwpi, kityupi]</span>              <p class="word--description">s. amz. tipo de pá- jaro. Kunkamanta chupakama killu patpayuk, umapilla yurak tullpuyuk, kitiwpi kitiwpi nis- hpa takik pishku.
Kitiwpi pishkuka sumaktami yura hawa- manta sapan tutamanta takin.




kitu</p>          </div>', 'ACTIVE', 1, '-'),
       (350, 'kiwa', '0', 'kiwa', '<div class="word--description">             <span class="word--fonetic">[kiwa, xiwa, khiwa]</span>              <p class="word--description">s. hierba en gene-
ral. Tukuy allpapi wiñak uchilla yurakuna. Chakrakunata mana allichikpika aya kiwaku- naka huntanllami.
kiwana</p>          </div>', 'ACTIVE', 1, '-'),
       (351, 'kiwina', '0', 'kiwina', '<div class="word--description">             <span class="word--fonetic">[kiwina, kibina]</span>              <p class="word--description">v. lisiar, torcer, dislo- car. Chaki tullu, maki tullu kuyurishpa waklli- rina, wishtushpa kuyuchina.
Atallpata wañuchinkapakka kunkata kiwin- chik.
kiya</p>          </div>', 'ACTIVE', 1, '-'),
       (352, 'kiyayana', '0', 'kiyayana', '<div class="word--description">             <span class="word--fonetic">[kiyayana, kiayana]</span>              <p class="word--description">v. enconarse,
infectarse las heridas. Chukrishkakuna, chu- pukuna killu sanku apiyuk tukuna.
Chukrika mana alli hampishkmanta kiyayas- hka.
kucha</p>          </div>', 'ACTIVE', 1, '-'),
       (353, 'kuchayana', '0', 'kuchayana', '<div class="word--description">             <span class="word--fonetic">[kučayana]</span>              <p class="word--description">v. inundarse, for- marse un lago, charco o algo similar. Yapata tamyakpi yaku huntashpa sakiriy.
Yalli tamyakpi kaypika manchanay kucha- yashka.
Sin. Huntana, nuyuna.
kuchi</p>          </div>', 'ACTIVE', 1, '-'),
       (354, 'kuchu', '0', 'kuchu', '<div class="word--description">             <span class="word--fonetic">[kuču]</span>              <p class="word--description">s. rincón. Maypipash sakirik

Puñuna kuchupimi kullkitaka tarirka.
2.	s. esquina. Ishkay pirkakuna tantarina kus- kapi sakirik uku.
Kancha kuchupi tiyakun.
3.	adv. al lado, cerca. Imakunapash shukpa manyapi tiyak.
Quito kuchupimi kawsani.
Sin. 3 manya, kaylla.
kuchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (355, 'kuchuyarina', '0', 'kuchuyarina', '<div class="word--description">             <span class="word--fonetic">[kučuyarina]</span>              <p class="word--description">v. acercarse.
Karumanta kimirina.
Yachana punchakunaka ñami kuchuyarin. Sin. Manyayana, kayllayana, kimirina. kukawi</p>          </div>', 'ACTIVE', 1,
        '-'),
       (356, 'kukupa', '0', 'kukupa', '<div class="word--description">             <span class="word--fonetic">[kukupa]</span>              <p class="word--description">s. búho negro de pecho amarillo. Yana patpayuk, misishina ñawiyuk, tutapi tun tun nishpa rikrata uyachik anka. Kukupa ñawika manchanayaymi kan.
Sin. Apapa, kuskunku, pukunku.
kula</p>          </div>', 'ACTIVE', 1, '-'),
       (357, 'kulla', '0', 'kulla', '<div class="word--description">             <span class="word--fonetic">[gulya]</span>              <p class="word--description">s. martes. Ishkayniki puncha. Wakin hampikkunaka kulla punchapi allita alliyachin.
kullan</p>          </div>', 'ACTIVE', 1, '-'),
       (358, 'suyu', '0', 'suyu',
        '<div class="word--description">             <span class="word--fonetic">[kulyay suyu, kulya suyu]</span>              <p class="word--description">s. re- gión sur. Argentina llaktaman sakirik suyu. Bolivia llaktaka kullay suyupimi sakirin. kullishtiti</p>          </div>',
        'ACTIVE', 1, '-'),
       (359, 'kullki', '0', 'kullki', '<div class="word--description">             <span class="word--fonetic">[kulyki, kužki, kulki]</span>              <p class="word--description">s. plata. Allpa ukupi taririk achiklla yurak anta.
Warmi tupullinaka kullkimanta rurashkami kan.
2. s. dinero. Rantinkapak rurashka antakuna, pankakunapash.
Ishkay chunka panka kullkita apamuy. kullpina</p>          </div>', 'ACTIVE', 1, '-'),
       (360, 'kullu', '0', 'kullu', '<div class="word--description">             <span class="word--fonetic">[kulyu, kužu, xužu]</span>              <p class="word--description">s. tronco. Yuraku- nata asha asha pitishka.
Yantata rurankapakmi kullutaka kuchurkani.
Sin. Putu.
kulluna</p>          </div>', 'ACTIVE', 1, '-'),
       (361, 'kulta', '0', 'kulta', '<div class="word--description">             <span class="word--fonetic">[kulta]</span>              <p class="word--description">s. pato. Yakupi wampuk, atall- pashina pishku.
Pedroka kultata wampuchishpa pukllan. kulun</p>          </div>', 'ACTIVE', 1, '-'),
       (362, 'kumal', '0', 'kumal', '<div class="word--description">             <span class="word--fonetic">[kumal, kumar]</span>              <p class="word--description">s. amz. camote. Uchilla lumushina allpa ukupi aparik anku yura.
Kumalka mishkipash kachipashmi tiyan.
Sin. apichu.
kumir</p>          </div>', 'ACTIVE', 1, '-'),
       (363, 'kumu', '0', 'kumu', '<div class="word--description">             <span class="word--fonetic">[kumu]</span>              <p class="word--description">adj. scs. jorobado, corcobado. Washa kunka tullukuna wakllirishpa kipishi- nata aparishka runa.
Manuel mashika uchillamantami kumu kan. kumuna</p>          </div>', 'ACTIVE', 1, '-'),
       (364, 'kunampu', '0', 'kunampu', '<div class="word--description">             <span class="word--fonetic">[kunaŋ]</span>              <p class="word--description">s. amz. variedad de pal- mera. Chillishina pankayuk raku yura.
Anti suyu wasikunaka kunampu panka-


wanmi rurashkakuna kan.
Sin. lukata.
kunan</p>          </div>', 'ACTIVE', 1, '-'),
       (365, 'kunawaru', '0', 'kunawaru', '<div class="word--description">             <span class="word--fonetic">[kunawaru]</span>              <p class="word--description">s. amz. variedad de sapo pequeño. Waylla karayuk, yura hut- kukunapi kawsak uchilla hampatu.
Wawakuna kunawaruta maskashpa pukllan. kunana</p>          </div>', 'ACTIVE', 1, '-'),
       (366, 'kunchu', '0', 'kunchu', '<div class="word--description">             <span class="word--fonetic">[kunchu]</span>              <p class="word--description">s. s. residuo de la chicha. Sanku puchukay aswa.
Kunchu aswata mana munanichu.
Sin. tikti.
kunti suyu</p>          </div>', 'ACTIVE', 1, '-'),
       (367, 'kunuk', '0', 'kunuk', '<div class="word--description">             <span class="word--fonetic">[kunuk]</span>              <p class="word--description">adj. caliente, abrigado. Mana chiri kak.
Yunka llaktaka kunukmi kan.
kuña</p>          </div>', 'ACTIVE', 1, '-'),
       (368, 'kupa', '0', 'kupa', '<div class="word--description">             <span class="word--fonetic">[kupa, xupa]</span>              <p class="word--description">s. basura. Imapash shi- tashka kak. Kupaka wanuman tikran.
Sin. Ñuku, mapa.
kuri</p>          </div>', 'ACTIVE', 1, '-'),
       (369, 'kaspi', '0', 'kaspi', '<div class="word--description">             <span class="word--fonetic">[kuri kaspi]</span>              <p class="word--description">s. oro. árbol cuya corteza se usa para curar el reumatismo. Pu- ka karayuk, karamanta yawarshina llukshik yura. Kara yanushka yakuta upyakpi tullu na- nayta hampik.
Chukchuy unkuy hapikpika kuri kaspi yakuta upyani.
Sin. Chukchu wasu.
kurikinki</p>          </div>', 'ACTIVE', 1, '-'),
       (370, 'kurpa', '0', 'kurpa', '<div class="word--description">             <span class="word--fonetic">[kurpa, kulpa]</span>              <p class="word--description">s. s. terrón. Rumiyas- hka allpa muru.
Sañuta rurankapakmi allpa kurpakunataka ñutuy kallarin.
2. adj. enano, rechoncho. Rukuyashka uchi- lla runa.
Kurpa kashkamanta mana paktarka.
Sin. 2 Piruru.
kuru</p>          </div>', 'ACTIVE', 1, '-'),
       (371, 'kurumama', '0', 'kurumama', '<div class="word--description">             <span class="word--fonetic">[kurumama, kuruma]</span>              <p class="word--description">s. amz. mosca grande que no pica. Kurukunata wa- chak hatun chuspi. Mishkikunapi, mikunaku- napi, mapakunapi tantarik.
Mishki mankapi kurumamaka tiyarishka.
Sin. Pinkala.
kurunta</p>          </div>', 'ACTIVE', 1, '-'),
       (372, 'kururu', '0', 'kururu', '<div class="word--description">             <span class="word--fonetic">[kururu]</span>              <p class="word--description">s. ovillo. Puchkata pillushka rumpashina rikurik.
Puka, waylla kururukunata tantachini. kururu</p>          </div>', 'ACTIVE', 1, '-'),
       (373, 'kururuna', '0', 'kururuna', '<div class="word--description">             <span class="word--fonetic">[kururuna]</span>              <p class="word--description">v. ovillar. Puchkata pi- lluy.
Llama millmamanta puchkatami kururuni. kuruna</p>          </div>', 'ACTIVE', 1, '-'),
       (374, 'kuruyana', '0', 'kuruyana', '<div class="word--description">             <span class="word--fonetic">[kuruyana, xuruyana, khuruyana]</span>              <p class="word--description">v. agusanarse; apolillarse. Aychakunapi, mu- yukunapi, shukkunapipash kurukuna mirariy. Mana hampishka papaka achkatami kuru- yan.
Sin. kuruna, susuna.
kuruyana</p>          </div>', 'ACTIVE', 1, '-'),
       (375, 'kusa', '0', 'kusa', '<div class="word--description">             <span class="word--fonetic">[kusa]</span>              <p class="word--description">s. marido, esposo. Kuyashka
warmiwan kawsankapak sawarik kari. Kanpak kusaka ¿ima shutitak kan? Sin. Kari.
kusana</p>          </div>', 'ACTIVE', 1, '-'),
       (376, 'kushi', '0', 'kushi', '<div class="word--description">             <span class="word--fonetic">[kuši, kusi]</span>              <p class="word--description">s. alegría, felicidad, dicha, ventura; fortaleza, energía. Llakikuna illak sumak kay.
Karu llaktamanta churi tikramukpimi kushi
tukuni.
2. s. amz. canas. Rukuyakpi umapi akcha yu- rakyana.
Kanpa umapika ñami kushi wiñashka.
Sin. sami.
kushilla</p>          </div>', 'ACTIVE', 1, '-'),
       (377, 'kushma', '0', 'kushma', '<div class="word--description">             <span class="word--fonetic">[kušma, kužma]</span>              <p class="word--description">s. especie de tú- nica, camisa, camiseta. Ukkuta killpankapak rikra illak churana.
Kanpa kushmata takshashpa intipi cha- kichikun.
Sin. Unku.
kushni</p>          </div>', 'ACTIVE', 1, '-'),
       (378, 'kushnichina', '0', 'kushnichina', '<div class="word--description">             <span class="word--fonetic">[kušničina]</span>              <p class="word--description">v. humear. Imata-
pash rupachishpa puyushinata llukshichiy. Kushita hapichun wamrata kushnichirka. kushniyana</p>          </div>',
        'ACTIVE', 1, '-'),
       (379, 'kushparina', '0', 'kushparina', '<div class="word--description">             <span class="word--fonetic">[kušparina]</span>              <p class="word--description">v. sc, amz. pata-
lear. Runakuna, wiwakuna chakita sinchita kuyuchiy.
Kasilla puñunki, ama kushparinkichu.
2. molestar. Shayarishpa, tiyarishpa, kuyu- rishpa tukuykunata kushpachiy.
Yachakuk wawaka mashikunata kushparin.
kushpana</p>          </div>', 'ACTIVE', 1, '-'),
       (380, 'kushpi', '0', 'kushpi', '<div class="word--description">             <span class="word--fonetic">[kušpi]</span>              <p class="word--description">s. peonza. muyuchinkapak pukllana.
Wawaka kushpiwanmi pukllan.
Sin. piruru.
kuska</p>          </div>', 'ACTIVE', 1, '-'),
       (381, 'kuskunku', '0', 'kuskunku', '<div class="word--description">             <span class="word--fonetic">[kuskuŋgu]</span>              <p class="word--description">s. sns. búho. Uchpa patpayuk, misi ñawishina tutapi pawak anka. Kuskunku wakakpika wañuy tiyachun ninku- nami.
Sin. Pukunku, apapa.
kutama</p>          </div>', 'ACTIVE', 1, '-'),
       (382, 'kutashka', '0', 'kutashka', '<div class="word--description">             <span class="word--fonetic">[kutaška]</span>              <p class="word--description">s. harina. Murukunata
ñutukpi llukshik haku. Kutashkata utka yanunki. Sin. kuta, haku.
kutana</p>          </div>', 'ACTIVE', 1, '-'),
       (383, 'kutichina', '0', 'kutichina', '<div class="word--description">             <span class="word--fonetic">[kutičina]</span>              <p class="word--description">v. contestar. Pipash,
maykanpash imata nikpi rimashpa tikrachiy.
Wawakuna ñuka nishkata kutichirka.
2. devolver. Mañashkakunata tikrachiy. Mañachishka llamata ñami kutichirka. Sin. 1 Kutipana, tikrachina, rantimpana.
kutimpu</p>          </div>', 'ACTIVE', 1, '-'),
       (384, 'kutimuna', '0', 'kutimuna', '<div class="word--description">             <span class="word--fonetic">[kutimuna]</span>              <p class="word--description">v. retornar, regresar,
volver. Maymantapash kikin suyuman tikray. Wakin kichwa runakunaka kikin llaktaman kutimun.
kutin</p>          </div>', 'ACTIVE', 1, '-'),
       (385, 'kutsi', '0', 'kutsi', '<div class="word--description">             <span class="word--fonetic">[kutsi, kusi]</span>              <p class="word--description">adj. s. ligero, ágil. Imata- pash hawalla utka utka rurak runa.
Chay runataka kutsi kakpimi sawarirka.
2. amz. laborioso. Mana killa runa. Payka kutsi kashpami alli kawsan. Sin. 1 Utka.
kutu</p>          </div>', 'ACTIVE', 1, '-'),
       (386, 'kutu', '0', 'kutu', '<div class="word--description">             <span class="word--fonetic">[kutu]</span>              <p class="word--description">s. amz. variedad de mono. Killu millmayuk, sinchita kaparik sachapi kawsak shuktak sami kushillu wiwa.
Sachapi kututa riksinkapak rini.
kutul</p>          </div>', 'ACTIVE', 1, '-'),
       (387, 'kutuyana', '0', 'kutuyana', '<div class="word--description">             <span class="word--fonetic">[kutuyana]</span>              <p class="word--description">v. s. encogerse. Awashkakunata takshakpi kichkiyashpa uchi- lla tukuy.
Ruwana awashkata timpushka yakuwan sa- rukpi alli kutuyarin.
Sin. Kuruyay, kurullayay, kurpayay.
kuwa</p>          </div>', 'ACTIVE', 1, '-'),
       (388, 'kuwayu', '0', 'kuwayu', '<div class="word--description">             <span class="word--fonetic">[kuwayu]</span>              <p class="word--description">s. amz. pájaro nocturno denominado huacharro. Muru patpayuk uchilla pishku, tutalla llukshik, mikunkapak mana alli.
Kunan tutamantaka kuwayumi yallita wa- karka.
kuwayu</p>          </div>', 'ACTIVE', 1, '-'),
       (389, 'kuna', '0', 'kuna', '<div class="word--description">             <span class="word--fonetic">[kuna]</span>              <p class="word--description">v. dar. Ima charishkakunata shukman karay.
Kanpa shuyushkataka payman kurkani.
Sin. karana.
kuy</p>          </div>', 'ACTIVE', 1, '-'),
       (390, 'kuya', '0', 'kuya', '<div class="word--description">             <span class="word--fonetic">[kuya, koya]</span>              <p class="word--description">s. esposa del inka.


ukllarishpa kushikuy. Ñukapa wawkitami kuyarka. Sin. 1. llakina, munana.

KUZU

Ñawpa kawsaypi inkapa warmi.
Inka pachapika shuk killapi kuyakuna ray- mita rurak karka.
kuya</p>          </div>', 'ACTIVE', 1, '-'),
       (391, 'kuyachina', '0', 'kuyachina', '<div class="word--description">             <span class="word--fonetic">[kuyačina, xuyačina]</span>              <p class="word--description">v. seducir,
acariciar. Imallatapash huchachishpa mishki rimaywan kimirayak tukushpa kakuriy.
Alli shunkuta rikuchishpa kuyachirkani.
Sin. munachina.
Kuyachina</p>          </div>', 'ACTIVE', 1, '-'),
       (392, 'kuyachina', '0', 'kuyachina', '<div class="word--description">             <span class="word--fonetic">[kuyačina, xuyačina]</span>              <p class="word--description">v. s. amz.
regalo de ahijados a sus padrinos. Achikwa- wakuna imatapash achikyayaman karana. Kusaman kuyachiyta kararkani.
kuyana</p>          </div>', 'ACTIVE', 1, '-'),
       (393, 'kuyana', '0', 'kuyana', '<div class="word--description">             <span class="word--fonetic">[kuyana, xuyana, khuyana]</span>              <p class="word--description">v. rega- lar, obsequiar. Imatapash tukuy shunkuwan karay.
Kay mishki muyuta kuyani.
Sin. Karana, kuna.
kuyaylla</p>          </div>', 'ACTIVE', 1, '-'),
       (394, 'kuytsa', '0', 'kuytsa', '<div class="word--description">             <span class="word--fonetic">[kuytsa]</span>              <p class="word--description">s. sn. muchacha, señorita, jovencita. Manarak sawarishka mallta warmi. Chay kuytsaka sumak yuyayyukmi kan.
Sin. Wamra, chinunka, mallta, pasña. kuyuchina</p>          </div>', 'ACTIVE', 1, '-'),
       (395, 'kuyuna', '0', 'kuyuna', '<div class="word--description">             <span class="word--fonetic">[kuyuna]</span>              <p class="word--description">v. moverse, agitarse. Ima- pash mana shuklla kuskapi tiyak.
Allpa chukchukpimi wasika kuyurirka. kuzu</p>          </div>', 'ACTIVE', 1, '-'),
       (396, 'kuzu', '0', 'kuzu', '<div class="word--description">             <span class="word--fonetic">[kusu, kuzu, gusu, guzu, xuzu]</span>              <p class="word--description">s. ss. ciénega, fango, pantano. Turu pampakuna, urkumanta llukshik yaku.
Kuzupi kuchika yaykushpa pamparirka.


lalu</p>          </div>', 'ACTIVE', 1, '-'),
       (397, 'lampa', '0', 'lampa', '<div class="word--description">             <span class="word--fonetic">[lampa]</span>              <p class="word--description">s. pala. Llamkana hillay.
Larkataka lampawan pichani.
lampana</p>          </div>', 'ACTIVE', 1, '-'),
       (398, 'lan', '0', 'lan', '<div class="word--description">             <span class="word--fonetic">[laŋ]</span>              <p class="word--description">s. amz. árbol cuya resina es medi- cinal. Balsa yurashina pankayuk, puka wi- kiyuk, yaku manyakunapi wiñak hampi yura. Lan yurataka hampi kashkamantami achkata maskan.
lancha</p>          </div>', 'ACTIVE', 1, '-'),
       (399, 'lanchana', '0', 'lanchana', '<div class="word--description">             <span class="word--fonetic">[laŋčana]</span>              <p class="word--description">v. destruir plantas y/o frutos por plaga. Tamya urmakpi tarpushka yurakuna, murukuna, ismushpa, wakllishpa, chakirina.
Kay llullu papa chakrataka achkatami lan- chan.
Sin. Sulayana.
lanta</p>          </div>', 'ACTIVE', 1, '-'),
       (400, 'lapukyana', '0', 'lapukyana', '<div class="word--description">             <span class="word--fonetic">[lapukyana]</span>              <p class="word--description">v.
estilarse, empaparse, mojarse. Churanakuna shutunkakama yakuwan, tamyawan huku- yay.
Yayaka allpapi llankakushpa yallita lapuk- yarka.
Sin. mutiyana, hukuyana, zutukyana.

lapuna</p>          </div>', 'ACTIVE', 1, '-'),
       (401, 'larka', '0', 'larka', '<div class="word--description">             <span class="word--fonetic">[larka, larga, rarka]</span>              <p class="word--description">s. acequia. Allpa ukuta wachushina allashkata yaku purichun rurashka, yakupa ñan.
Ayllullaktakunapika larkakunataka allitami charinkuna.
larkana</p>          </div>', 'ACTIVE', 1, '-'),
       (402, 'latsik', '0', 'latsik', '<div class="word--description">             <span class="word--fonetic">[latsix, lačix]</span>              <p class="word--description">s. amz. gusano blanco. Yurak, suni, ñañu kuru.
Yachachikka yachakukkunaman yachachin- kapakka latsik kuruta hapin.
laychu</p>          </div>', 'ACTIVE', 1, '-'),
       (403, 'liklik', '0', 'liklik', '<div class="word--description">             <span class="word--fonetic">[liglik, ligli]</span>              <p class="word--description">s. ave que anuncia la lluvia. Tamya shamuchun liklik liklik nishpa takik pis- hku.
Ñallami tamyanka, liklik nishpa pishkunaka takikunmi.
linchi</p>          </div>', 'ACTIVE', 1, '-'),
       (404, 'linchi', '0', 'linchi', '<div class="word--description">             <span class="word--fonetic">[linči]</span>              <p class="word--description">s. arbusto. Purun pampakunapi
wiñak yura.
Mamaka	linchi	kiwata	wiwakunaman kuchun.
lisan</p>          </div>', 'ACTIVE', 1, '-'),
       (405, 'lukarya', '0', 'lukarya', '<div class="word--description">             <span class="word--fonetic">[lukarya, ukarya]</span>              <p class="word--description">s. amz. variedad de sapo. Shuk uchilla hampatu puka pukalla karayuk, tutakunapi lukarya lukarya nishpa kaparik.
Lukarya hampatuka tamya shamunata ñaw- pashpatakmi kaparin.
lukata</p>          </div>', 'ACTIVE', 1, '-'),
       (406, 'lukllikirina', '0', 'lukllikirina', '<div class="word--description">             <span class="word--fonetic">[luglyikirina]</span>              <p class="word--description">v. bo. buscar insis- tentemente hasta encontrar. Imatapash ash- tawan kutin, kutin, hapinkakama mashkay. Mama Rosa mashika kuchita chinkachishpa lukllikirin.
Sin. maskapayana.
lukma</p>          </div>', 'ACTIVE', 1, '-'),
       (407, 'lulun', '0', 'lulun', '<div class="word--description">             <span class="word--fonetic">[luluŋ, ruruŋ]</span>              <p class="word--description">s. huevo; testículo. Pis-
hkukuna wachashka aycha tukuna muyu- kuna, karikunapa ullu sapipi warkuriyak ishkay rumpashina aychakuna.
Wirayachunmi kuchitaka lulunta surkukun- chik.
lumarisu</p>          </div>', 'ACTIVE', 1, '-'),
       (408, 'lumu', '0', 'lumu', '<div class="word--description">             <span class="word--fonetic">[lumu]</span>              <p class="word--description">s. amz. yuca. Papashina allpa ukupi pukuk, yunka llaktakunapi wiñak muru. Chawpi puncha mikunataka atallpata lumu- wan yanunki.
lumucha</p>          </div>', 'ACTIVE', 1, '-'),
       (409, 'kuchi', '0', 'kuchi', '<div class="word--description">             <span class="word--fonetic">[lumukuči]</span>              <p class="word--description">s. amz. saíno. Suni
sinkayuk, karu karullapi suni akchayuk, kutu chupayuk, kunka washa chawpipi pupushi- namanta ashnak samayta shitak sachapi kawsak kuchi.
Anti suyupika lumu kuchitaka wasi kuchu- kunapimi wiñachinkuna.
lunchik</p>          </div>', 'ACTIVE', 1, '-'),
       (410, 'lunkuchina', '0', 'lunkuchina', '<div class="word--description">             <span class="word--fonetic">[luŋkučina]</span>              <p class="word--description">v. amz. cubrir la ca-
beza. Umata imawanpash killpay. Wawataka pintuwan umata lunkuchin. Sin. Tiyunkullina, killpana.
luntsa</p>          </div>', 'ACTIVE', 1, '-'),
       (411, 'lupi', '0', 'lupi', '<div class="word--description">             <span class="word--fonetic">[lupi]</span>              <p class="word--description">s. amz. pez pequeño. Uchilla challwa rumi ukupi kawsak.
Lupi yaku aychataka kusashpami mish- kichishpa mikunchik.
lutsana</p>          </div>', 'ACTIVE', 1, '-'),
       (412, 'lutsu', '0', 'lutsu', '<div class="word--description">             <span class="word--fonetic">[lutsu]</span>              <p class="word--description">det. sc. puñado. Imakunata- pash maki huntakta hapina.
Shuk lutsu sarata atallpakunaman karay.
Sin. Maki, tsutsuk.
luyu luyu</p>          </div>', 'ACTIVE', 1, '-'),
       (413, 'llachapa', '0', 'llachapa', '<div class="word--description">             <span class="word--fonetic">[lyačapa, žačapa]</span>              <p class="word--description">s. trapos, pañal, remiendo. Awashkakunamanta pitishka uchi- lla pintukunami, llullu wawakunata sikita pi- llunkapak rurashka.
Mawka churanakunataka llachapakunatami wawakunaman ruran.
2. adj. mendigo. Imatapash mana charik runa.
Llachapa runaka ñantakunata mañashpa- llami kawsan.
Sin. 2 wakcha.
llachapana</p>          </div>', 'ACTIVE', 1, '-'),
       (414, 'llachu', '0', 'llachu', '<div class="word--description">             <span class="word--fonetic">[lyaču, žaču]</span>              <p class="word--description">s. azadón. Suni kaspi- wan manyapi patak hillaywan rurashka takl- lashina.
Sara chakrataka llachuwanmi hallmanchik. llakana</p>          </div>', 'ACTIVE', 1, '-'),
       (415, 'llaki', '0', 'llaki', '<div class="word--description">             <span class="word--fonetic">[lyaki, žaki]</span>              <p class="word--description">s. dolor, sufrimiento, pena,
amargura, desventura, problema, accidente, lástima. Nanariy tiyaymanta rimana shimi, kuyaytapash nina shimi.
Ñukanchikka	mama	wañushkamantaka achka llakitami charinchik.
llakinayak</p>          </div>', 'ACTIVE', 1, '-'),
       (416, 'llakina', '0', 'llakina', '<div class="word--description">             <span class="word--fonetic">[lyakina, žakina]</span>              <p class="word--description">v. sufrir, lamentar, apenar, tener pena. Nanayta charina Kikinpa wawakunataka achkatami llakinchik.
2. amz. amar, querer. pitapash yuyashpalla kawsay.
Ñukapa wawata achkata llakikuni.
Sin. 2 kuyana, munana.
llakirina</p>          </div>', 'ACTIVE', 1, '-'),
       (417, 'llakllana', '0', 'llakllana', '<div class="word--description">             <span class="word--fonetic">[lyaklyana, žaxlyana, žagžana]</span>              <p class="word--description">s.
amz. azuela.Uchilla llachushina, kaspikunata ñañuyachinkapak anta.
Kaspitaka llakllanawan llampuyachini. llakllana</p>          </div>', 'ACTIVE', 1, '-'),
       (418, 'llakta', '0', 'llakta', '<div class="word--description">             <span class="word--fonetic">[lyakta, lyaxta, žaxta, žagta]</span>              <p class="word--description">s. pueblo, ciudad, comarca. Maypipash runakunapura tantalla kawsana kuska.
Kichwa runa llaktakunaka achkami kan.
2. s. nación, patria, país. Mama llaktayuk ru- nakuna kawsana.
Ecuador llaktaka chinchay suyu shutiyukmi karka.
Sin. 1 ayllullakta; 2 Mamallakta.
llaktana</p>          </div>', 'ACTIVE', 1, '-'),
       (419, 'llakwarina', '0', 'llakwarina', '<div class="word--description">             <span class="word--fonetic">[lyakwarina]</span>              <p class="word--description">v.    almorzar.
Chawpi punchapi mikuy.
Kuy aychata papantinmi llakwarinchik.
llama</p>          </div>', 'ACTIVE', 1, '-'),
       (420, 'uhu', '0', 'uhu', '<div class="word--description">             <span class="word--fonetic">[lyama uhu]</span>              <p class="word--description">s. coscoja, tos per-
sistente. Tunkurita rawrachik unkuy.
Llama uhu hapikpi chillchill yurawan ham- pinchik.
llaminku</p>          </div>', 'ACTIVE', 1, '-'),
       (421, 'llamkana', '0', 'llamkana', '<div class="word--description">             <span class="word--fonetic">[lyamkana, lyaŋkana, žaŋgana, lyaŋgana, žaŋkana]</span>              <p class="word--description">v. trabajar. Imakunata- pash ruray.
Ayllullaktapika tukuykunami makita kushpa
llamkanchik.
Sin. rurana.
llamkana</p>          </div>', 'ACTIVE', 1, '-'),
       (422, 'llampu', '0', 'llampu', '<div class="word--description">             <span class="word--fonetic">[lyambu, žambu]</span>              <p class="word--description">adv. totalidad, todos. Tukuylla ninkapak shimi.
Minkamanka llampullami shamunkichik.
Sin. tukuy.
llampu</p>          </div>', 'ACTIVE', 1, '-'),
       (423, 'llampuna', '0', 'llampuna', '<div class="word--description">             <span class="word--fonetic">[lyaŋbuna, žaŋbuna]</span>              <p class="word--description">v. cepillar, li- mar, pulir. Kaspipa mukukunata, chamkaku- nata anchuchiy.
Payka awana kaspikunatami kaynamanta
llampukun.
2.	v. suavisarse, ablandarse. Imapash apiya- riy, murukuna pukushpa apiyarina. Timpuska yakupika papakunaka tukuyllami llampun.
3.	v. amz. enlucir. Pirka hutkukunata llutarik allpawan chinkachishpa sakiy.
Ayllullakta wasikunataka yurak iskuwanmi
llampunkuna.
llantu</p>          </div>', 'ACTIVE', 1, '-'),
       (424, 'llapitukuna', '0', 'llapitukuna', '<div class="word--description">             <span class="word--fonetic">[lyapitukuna, žapitukuna]</span>              <p class="word--description">v. tener pesadillas. Puñuypi ayakunata rikus- hpa kaparina.
Payka yallita mikushpa puñukushpaka llapi- tukun.
Sin. nuspana.
llapina</p>          </div>', 'ACTIVE', 1, '-'),
       (425, 'llapitukuna', '0', 'llapitukuna', '<div class="word--description">             <span class="word--fonetic">[lyapitukuna]</span>              <p class="word--description">v. tener pesadi-
llas.
Puñuypi ayakunata rikushpa kaparina. Payka yallita mikushpa puñukushpaka llapi- tukun.
Sin. nuspana.
llashak</p>          </div>', 'ACTIVE', 1, '-'),
       (426, 'llashana', '0', 'llashana', '<div class="word--description">             <span class="word--fonetic">[lyašana, žašana]</span>              <p class="word--description">v. pesar. Ima-
tapash tupuna.
Kay ruwana kipika llashakun.
llatan</p>          </div>', 'ACTIVE', 1, '-'),
       (427, 'llatanana', '0', 'llatanana', '<div class="word--description">             <span class="word--fonetic">[lyatanana, žatanana]</span>              <p class="word--description">v. desves- tirse, desnudarse. Churanakunata anchu- chishpa lluchulla sakiriy.
Wawaka armankapak allimanta llatanan.
2. v. im. alzar el vestido hasta la cintura. Churanata wiksakama hawayachiy. Wayraka anakuta hawakamami llatanarka.




Sin. 1 Llushtina, lluchuna.
llawana</p>          </div>', 'ACTIVE', 1, '-'),
       (428, 'llawsa', '0', 'llawsa', '<div class="word--description">             <span class="word--fonetic">[lyawsa, žawsa]</span>              <p class="word--description">s. savia de las plan- tas; baba. Yura karakunata purishpa llukshik yaku.
Wakin yurakunamanta llukshik llawsaka hampimi kan.
2. adj. viscoso. Apishina tukushka yaku. Sávila pankamanta llukshik llawsaka hampi yakumi kan.
llawtu</p>          </div>', 'ACTIVE', 1, '-'),
       (429, 'llika', '0', 'llika',
        '<div class="word--description">             <span class="word--fonetic">[lyika]</span>              <p class="word--description">s. amz. red para pescar. Chall- wakunata hapinkapak awashka hatun linchi. Katunkapakmi llikataka awakuni. llikchalla</p>          </div>',
        'ACTIVE', 1, '-'),
       (430, 'lliki', '0', 'lliki', '<div class="word--description">             <span class="word--fonetic">[lyiki, lyiki]</span>              <p class="word--description">adj. destrozado, despe- dazado. Imapash llikishka.
Wakcha runaka lliki lliki churanakunata chu- rarishka kawsan.
llikina</p>          </div>', 'ACTIVE', 1, '-'),
       (431, 'lliklla', '0', 'lliklla', '<div class="word--description">             <span class="word--fonetic">[lyiglya, žigža]</span>              <p class="word--description">s. ss. rebozo. Warmiku- napa hatun pachallina.
Kayka ñukapa warmipa llikllami kan.
2. s. rebozo matrimonial. Sawarik warmi ru- rarichun rurashka pachallina.
Sawariypak llikllata maskakuni.
llikuy</p>          </div>', 'ACTIVE', 1, '-'),
       (432, 'llimpi', '0', 'llimpi', '<div class="word--description">             <span class="word--fonetic">[lyimpi, žimpi]</span>              <p class="word--description">adv. pa. Cuerdo, en sus cabales. Tukuy yuyayyuk mana machashka. Wawakunata yachachinkapakka alli llimpi- wanmi rina kan.
llimpina</p>          </div>', 'ACTIVE', 1, '-'),
       (433, 'llipinshi', '0', 'llipinshi', '<div class="word--description">             <span class="word--fonetic">[lypinši]</span>              <p class="word--description">s. pa. pestañas. Ñawi hutku manyapi tiyak millmakuna.
Rosa warmika hatun llipinshita charin. llipyana</p>          </div>', 'ACTIVE', 1, '-'),
       (434, 'lluchka', '0', 'lluchka', '<div class="word--description">             <span class="word--fonetic">[lyučka, lyuča, lyuška, žučka, žuška]</span>              <p class="word--description">adj. resbaloso. Imakunapash yakulla llushpi- rinalla kak.
Wichay ñankunaka tamyakpika achka lluch- kami tukun.
2. adj. liso. Ima kakpipash sumak llampus- hkami kan.
Wasichinkapak maru kulluka may lluchkami kan.
Sin. 2 Llampu.
lluchkana</p>          </div>', 'ACTIVE', 1, '-'),
       (435, 'lluchu', '0', 'lluchu', '<div class="word--description">             <span class="word--fonetic">[lyuču, žuču]</span>              <p class="word--description">adj. desnudo, pobre.
Millma illak wiwa, churana illak runa. Wawataka mana lluchullata charinachu kanchik.
Sin. Llatan, llushti.
lluchunka</p>          </div>', 'ACTIVE', 1, '-'),
       (436, 'lluchuna', '0', 'lluchuna', '<div class="word--description">             <span class="word--fonetic">[lyučuna, žučuna]</span>              <p class="word--description">v. pelar, despe-
llejar por completo. Muyukunapa karata llus- htina, wiwakunapa karatapash surkuna.
Raymipi karankapak wakrata lluchukunchik.
Sin. Llushtina.
llukana</p>          </div>', 'ACTIVE', 1, '-'),
       (437, 'lluki', '0', 'lluki', '<div class="word--description">             <span class="word--fonetic">[lyuki, žuki]</span>              <p class="word--description">adj. izquierdo, zurdo. Ima-

pash allawka makiman sakirik.
yak murukunami.



Shuk wawaka lluki makiwanmi pukllak kan.
Sin. ichuk.
llukllu</p>          </div>', 'ACTIVE', 1, '-'),
       (438, 'llukshichina', '0', 'llukshichina', '<div class="word--description">             <span class="word--fonetic">[lyuxšičina,lyuxčina,žuxšičina, žuxčičina, žugčina]</span>              <p class="word--description">v. sacar. Ukumanta kan- chaman surkuy.
Tantanakuymanta allkukunata kanchaman
llukshichinchik.
Sin. Surkuna.
llukshina</p>          </div>', 'ACTIVE', 1, '-'),
       (439, 'llulla', '0', 'llulla', '<div class="word--description">             <span class="word--fonetic">[lyulya, žuža]</span>              <p class="word--description">adj. mentiroso, falso. Umachik runa. Imatapash yanka rimak.
Wakin pushakkunaka llulla runakunami kan. llullawawa</p>          </div>', 'ACTIVE', 1, '-'),
       (440, 'llullana', '0', 'llullana', '<div class="word--description">             <span class="word--fonetic">[lyulyana, žužana]</span>              <p class="word--description">v. mentir, falsear.
Imatapash yanka rimana.
Wakin runakunaka tukuyta llullan.
llullu</p>          </div>', 'ACTIVE', 1, '-'),
       (441, 'llulluk', '0', 'llulluk', '<div class="word--description">             <span class="word--fonetic">[lyulyux,lyulyu]</span>              <p class="word--description">s. amz. retoño. Yuraku- namanta, kiwakunamanta mushuk wiñarik pankakuna, mallkikunami.
Lumupa llullukta aswapi churankapak apa- muni.
2. cogollo. Chuntakunamanta, lisankuna- manta llukshik mushuk panka.
Shiwa yuraka llulluk illakka achka yuyutami charin.
Sin. 1 Ñawi, mallki.
llumi</p>          </div>', 'ACTIVE', 1, '-'),
       (442, 'llunchina', '0', 'llunchina', '<div class="word--description">             <span class="word--fonetic">[žuŋčina, žunžina]</span>              <p class="word--description">v. snc. pintar.
Imatapash ima tullpuwanpash hawina.
Ñukami wasita llunchikuni.
2. im. co. manchar. Imatapash, imawanpash mapayachina.
Paymi	ñukapa	churanataka	tukuyta
llunchikurka.
Sin. 1. llimpina; 2 mapayachina, hawina, kar- kayachina, wikiyachina.
lluru</p>          </div>', 'ACTIVE', 1, '-'),
       (443, 'llushpina', '0', 'llushpina', '<div class="word--description">             <span class="word--fonetic">[lyušpina, žušpina]</span>              <p class="word--description">v. resbalarse, deslizarse. Turu allpapi, ima karakunapipash sarushpa chakikuna ñitkariy.
Kay turu allpa ñanta rikushpa llushpirka.
Sin. Lluchkana.
llushti</p>          </div>', 'ACTIVE', 1, '-'),
       (444, 'llushtina', '0', 'llushtina', '<div class="word--description">             <span class="word--fonetic">[lyuština, žuština]</span>              <p class="word--description">v. pelar. Ima ka- rakunatapash anchuchiy.
Papata yanunkapakka karata llushtinchik.
2. ss. despellejar por completo. Wiwa karata anchuchiy.
Wakra wañukpika karataka tukuytami llus- htinchik.
Sin. 1-2 Lluchuna.
llutarina</p>          </div>', 'ACTIVE', 1, '-'),
       (445, 'llutana', '0', 'llutana', '<div class="word--description">             <span class="word--fonetic">[lyutana, žutana]</span>              <p class="word--description">v. pegar con subs- tancias adherentes. Hapiriklla llawsawan ki- michina.
Kay pankakunata pirkapi llutay.
2. tu. amz. juntar, unir. Ishkurishkata, pitirish- kata, pakirishkata chayllapitak churashpa ha- pichina.
Kay kaspita chayshuk kaspiwan llutani.
Sin. Tinkuna, tantana, hawina.
llutipa</p>          </div>', 'ACTIVE', 1, '-'),
       (446, 'lluya', '0', 'lluya', '<div class="word--description">             <span class="word--fonetic">[lyuya]</span>              <p class="word--description">s. na. gaviota. Shuk kari a-
tallpashina rikurik puka patpayuk hatun pishku.
Sumak lluya pishkuka anti suyu sachapimi kawsan.





































94


machakuy</p>          </div>', 'ACTIVE', 1, '-'),
       (447, 'machana', '0', 'machana', '<div class="word--description">             <span class="word--fonetic">[mačana]</span>              <p class="word--description">s. borrachera. Hayak yakuta upyakpi yuyay chinkariy.
Machayka alli yuyayta chinkachik unkuymi kan.
2. v. emborracharse, embriagarse. Machana yakuta upyashpa yuyayta chinkachina.
Karu llaktamanta shuk ayllu shamukpi ray- mishpa macharkani.
Sin. 2 Shinkayana.
machay</p>          </div>', 'ACTIVE', 1, '-'),
       (448, 'machin', '0', 'machin', '<div class="word--description">             <span class="word--fonetic">[mačin]</span>              <p class="word--description">s. amz. mico, variedad de
mono. Shuk uchpa millmayuk, tsala ñawiyuk kushillushina sacha wiwa.
Shuk machinta sachapi rikurkani. machka</p>          </div>', 'ACTIVE', 1, '-'),
       (449, 'machu', '0', 'machu', '<div class="word--description">             <span class="word--fonetic">[maču]</span>              <p class="word--description">s. amz. alimento envuelto en hojas para cocer. Mikunata yanunkapak pan- kapi maytushka.
Mamaka machuta yanukun.
makana</p>          </div>', 'ACTIVE', 1, '-'),
       (450, 'makana', '0', 'makana', '<div class="word--description">             <span class="word--fonetic">[makana]</span>              <p class="word--description">s. amz. mazo. Wiwaku- nata wañuchinkapak, makanakunkapak llakl- lashka kaspi.
Shuwataka makanawan waktarka. makana</p>          </div>', 'ACTIVE', 1, '-'),
       (451, 'maki', '0', 'maki', '<div class="word--description">             <span class="word--fonetic">[maki]</span>              <p class="word--description">s. mano, antebrazo. Pichka ru- kayuk rikra tukuri tullu. Imatapash hapinka- pak alli.
Makiwan rurashka churanatami churanchik. makipura</p>          </div>', 'ACTIVE', 1, '-'),
       (452, 'makiwatana', '0', 'makiwatana', '<div class="word--description">             <span class="word--fonetic">[makiwatana]</span>              <p class="word--description">s.   pulsera,
manillas. Makipi pillunkapak pallashka mul- lukuna.
Otavalo kuytsakunaka puka wallkawanmi
makiwatanata ruran.
mallik</p>          </div>', 'ACTIVE', 1, '-'),
       (453, 'mallik', '0', 'mallik', '<div class="word--description">             <span class="word--fonetic">[malyix, mažix]</span>              <p class="word--description">s. co. tipo de hierba. Shuk uchilla puzu kiwa.
Mallik kiwata sacha ukupi tarirkani. mallina</p>          </div>', 'ACTIVE', 1, '-'),
       (454, 'mallki', '0', 'mallki', '<div class="word--description">             <span class="word--fonetic">[malyki, malki, mažki]</span>              <p class="word--description">s. s. rama; planta en general. Yurakunamanta rikraku- nashina wiñashka pallka.
Yurapa mallkitaka mana pakinachu kan.
Sin. Pallka.
mallta</p>          </div>', 'ACTIVE', 1, '-'),
       (455, 'mallta', '0', 'mallta', '<div class="word--description">             <span class="word--fonetic">[malyta, malta]</span>              <p class="word--description">adj. mediano; a-
dolescente, joven. Runa kashpapash mana rukuchu.
Mallta wawaka chayrak yachana wasipimi yachakun.
mama</p>          </div>', 'ACTIVE', 1, '-'),
       (456, 'mamachanka', '0', 'mamachanka', '<div class="word--description">             <span class="word--fonetic">[mamačanga]</span>              <p class="word--description">s. muslo. Runapa, wiwapa raku ñutu aychayuk chanka.
Wawaka mamachankapimi haytarishpa na- nachikun.
Sin. raku chanka.
Mamaku</p>          </div>', 'ACTIVE', 1, '-'),
       (457, 'mamakucha', '0', 'mamakucha', '<div class="word--description">             <span class="word--fonetic">[mamakuča]</span>              <p class="word--description">s. mar, océano. Allpa mamata yalli killpak yaku kucha.
Mamakuchapika achka sami challwakunami tiyan.
Sin. hatun kucha.
mamallakta</p>          </div>', 'ACTIVE', 1, '-'),
       (458, 'mamallaw', '0', 'mamallaw', '<div class="word--description">             <span class="word--fonetic">[mamažau]</span>              <p class="word--description">interj. pi. amz. ex- presión de temor o susto. Mancharishpa ka- pariy.
May hatun kurumi, ¡mamallaw!.
mamapuzun</p>          </div>', 'ACTIVE', 1, '-'),
       (459, 'tullu', '0', 'tullu', '<div class="word--description">             <span class="word--fonetic">[mama tulyu]</span>              <p class="word--description">s. fémur. Mama
chanka ukupi tiyak suni tullu.
Mama tullutaka allita rikurayanami kan. mama wiksa</p>          </div>', 'ACTIVE', 1, '-'),
       (460, 'mana', '0', 'mana', '<div class="word--description">             <span class="word--fonetic">[mana, na]</span>              <p class="word--description">adv. no. Imatapash ama


ari ninkapak shimi.
Mana ñuka chaytaka rurarkanichu. manachu</p>          </div>', 'ACTIVE', 1, '-'),
       (461, 'ima', '0', 'ima', '<div class="word--description">             <span class="word--fonetic">[mana-ima]</span>              <p class="word--description">det. Nada. Imapash illak.
Mana-imata yachashpaka mana rimanachu. manapi</p>          </div>', 'ACTIVE', 1, '-'),
       (462, 'manapipash', '0', 'manapipash', '<div class="word--description">             <span class="word--fonetic">[manapipaš, manapiš, man- apiwas, manapi, nipipaš]</span>              <p class="word--description">det. s. nadie. Maykanpash mana rikurishkata ninkapak shimi.
Kunan	tutamantaka	manapipash
shamurkachu.
Sin. Manapi.
manarak</p>          </div>', 'ACTIVE', 1, '-'),
       (463, 'manchachina', '0', 'manchachina', '<div class="word--description">             <span class="word--fonetic">[mančačina, manžačina]</span>              <p class="word--description">v. espantar, asustar, hacer tener miedo. Pita- pash shunkuta chukchuchina.
Wawakunataka mana manchachinkichu.
Sin. kallpachina.
manchanayana</p>          </div>', 'ACTIVE', 1, '-'),
       (464, 'manchariy', '0', 'manchariy', '<div class="word--description">             <span class="word--fonetic">[mančariy]</span>              <p class="word--description">s. espanto, susto,
miedo. Shunku chukchuy.
Puma rikurikpi, wawaka manchariymanta kaparirka.
manchana</p>          </div>', 'ACTIVE', 1, '-'),
       (465, 'manchu', '0', 'manchu', '<div class="word--description">             <span class="word--fonetic">[manču]</span>              <p class="word--description">s. amz. insecto. Hapikpi ashnakta ishpak uchpa karayuk chuspi.
Manchutaka ama hapinkichu.
Sin. Apu.




manka</p>          </div>', 'ACTIVE', 1, '-'),
       (466, 'manku', '0', 'manku', '<div class="word--description">             <span class="word--fonetic">[maŋgu]</span>              <p class="word--description">s. amz. tipo de pájaro.
Yurak kiruyuk, killu sikiyuk, killu rikrayuk, yana patpayuk, chuntata mikuk pishku.
Manku chunta muyuta mikushka rikurin. mantakakiru</p>          </div>', 'ACTIVE', 1, '-'),
       (467, 'mantana', '0', 'mantana', '<div class="word--description">             <span class="word--fonetic">[mandana]</span>              <p class="word--description">v. tender, extender. Imatapash katay, chutachina.
Takshashkakunata mantanki.
manya</p>          </div>', 'ACTIVE', 1, '-'),
       (468, 'manyayana', '0', 'manyayana', '<div class="word--description">             <span class="word--fonetic">[manyayana, manñayana]</span>              <p class="word--description">v.
s. acercarse. Maymanpash kimiriy.
Yakuman manyayana.
Sin. Kuchuyana, kayllayana, llutarina, kimi- rina.
maña</p>          </div>', 'ACTIVE', 1, '-'),
       (469, 'achina', '0', 'achina', '<div class="word--description">             <span class="word--fonetic">[mañačina, mañčina]</span>              <p class="word--description">v. pres- tar. Imatapash tikrachichun nishpa shukman kuna.
Kaya tikrachipashallami kullkita mañachi-
way.
mañana</p>          </div>', 'ACTIVE', 1, '-'),
       (470, 'ayachina', '0', 'ayachina', '<div class="word--description">             <span class="word--fonetic">[mañayačina]</span>              <p class="word--description">v. amz. en- rollar bejuco. Suni ankuta pillushpa rumpay- achina.
Wamputa watankapak ankuta mañayachi-
pay.


mapa</p>          </div>', 'ACTIVE', 1, '-'),
       (471, 'mapamari', '0', 'mapamari', '<div class="word--description">             <span class="word--fonetic">[mapamari]</span>              <p class="word--description">s.amz. sanguijuela. Pala rikurik, yana washayuk, yurak wiksayuk, turu kuchakunapi kawsak, yawarta tsunkak palamaku.
Mapamari wiwaka anti suyu kuchakunapimi tiyan.
mapayana</p>          </div>', 'ACTIVE', 1, '-'),
       (472, 'mara', '0', 'mara', '<div class="word--description">             <span class="word--fonetic">[mara]</span>              <p class="word--description">adj. niño, niña. Wachashkalla, kawsay kallariy pachapi kak.
Kanpa maraka wayrallami kallpan.
Sin. wawa.
marka</p>          </div>', 'ACTIVE', 1, '-'),
       (473, 'markakmama', '0', 'markakmama', '<div class="word--description">             <span class="word--fonetic">[markakmama]</span>              <p class="word--description">s. madrina de bautizo. Chikan mama wawata markash- pa shutichichik.
Paymi, ñukapa markakmama kan.
Sin. Achikmama, achiku.
markakyaya</p>          </div>', 'ACTIVE', 1, '-'),
       (474, 'markana', '0', 'markana', '<div class="word--description">             <span class="word--fonetic">[markana]</span>              <p class="word--description">v. llevar en brazos. Imatapash maki rikrawan mikllay.
Wawata maytushpa markay.
marku</p>          </div>', 'ACTIVE', 1, '-'),
       (475, 'masha', '0', 'masha', '<div class="word--description">             <span class="word--fonetic">[maša]</span>              <p class="word--description">s. yerno. Ushushipa kusa.
Kanpa mashaka amawta yuyaytami charin. mashalli</p>          </div>', 'ACTIVE', 1, '-'),
       (476, 'mashana', '0', 'mashana', '<div class="word--description">             <span class="word--fonetic">[mašana]</span>              <p class="word--description">v. ss. solear, asolear. Inti rupaypi ukunta rupakyarina.
Ñukanchikka tutamanta intipimi mashanchik. mashi</p>          </div>', 'ACTIVE', 1, '-'),
       (477, 'mashna', '0', 'mashna', '<div class="word--description">             <span class="word--fonetic">[mašna,mažna, masna]</span>              <p class="word--description">pron.
¿cuántos?. Ima charishkakunata tapuchik shimi.
¿Mashna llamakunatatak charinki?
mashu</p>          </div>', 'ACTIVE', 1, '-'),
       (478, 'mashu', '0', 'mashu', '<div class="word--description">             <span class="word--fonetic">[mašu, masu]</span>              <p class="word--description">s. amz. tejón. Muru millmayuk, muru chupayuk wiwa, achkapura tantarishpa purik. 2 s. murciélago. Sin. chim- pilaku.
Mashuta chay pampapi rikumuni. mashuwa</p>          </div>', 'ACTIVE', 1, '-'),
       (479, 'maskana', '0', 'maskana', '<div class="word--description">             <span class="word--fonetic">[maskana, maškana]</span>              <p class="word--description">v. buscar el sustento o la vida. Ima kawsaytapash, chin- kashkatapash tapuna.
Tukuykuna alli kawsayta maskashun. maskana</p>          </div>', 'ACTIVE', 1, '-'),
       (480, 'mati', '0', 'mati', '<div class="word--description">             <span class="word--fonetic">[mati]</span>              <p class="word--description">s. mate. Imatapash wishinkapak hatun pillchishina.
Kay mati hunta aswata upyachiway. mawka</p>          </div>', 'ACTIVE', 1, '-'),
       (481, 'mawma', '0', 'mawma', '<div class="word--description">             <span class="word--fonetic">[mawma, magma, maxma]</span>              <p class="word--description">s. sncs. vasija grande de barro, tinaja. Yapa hatun allpa manka, aswata pukuchik manka. Mawmapi yakuta huntachirkani.


may</p>          </div>', 'ACTIVE', 1, '-'),
       (482, 'maykama', '0', 'maykama', '<div class="word--description">             <span class="word--fonetic">[maykama]</span>              <p class="word--description">pron. ¿hasta
dónde?. May kuskakama nishpa tapuchik shimi.
¿Maykama rikunki?.
maykan</p>          </div>', 'ACTIVE', 1, '-'),
       (483, 'mayllakshunku', '0', 'mayllakshunku', '<div class="word--description">             <span class="word--fonetic">[mayža šuŋku]</span>              <p class="word--description">adj. s. en ayunas. Imatapash manarak mikushka, chushak wiksa.
Yawarta	surkuchinkapakka	mayllak shunkumi rini.
mayllana</p>          </div>', 'ACTIVE', 1, '-'),
       (484, 'mayma', '0', 'mayma', '<div class="word--description">             <span class="word--fonetic">[mayma]</span>              <p class="word--description">adj. sn. inmenso. Yapa hatun.
Napo mayuka mayma yakupimi yaykun. mayman</p>          </div>', 'ACTIVE', 1, '-'),
       (485, 'maypi', '0', 'maypi', '<div class="word--description">             <span class="word--fonetic">[maypi]</span>              <p class="word--description">pron. en dónde. Llaktapa kuskata tapuchik shimi.
Kanka ¿maypitak kanki?
mayta</p>          </div>', 'ACTIVE', 1, '-'),
       (486, 'maytu', '0', 'maytu', '<div class="word--description">             <span class="word--fonetic">[maytu]</span>              <p class="word--description">s. envoltorio, envuelto. Ima- kunawanpash pillushka kipi.
Chaki nanakpi chillca pankawan, maytu-
wanpash waktarkani.
2. amz. paquete atado en hojas . Imatapash pankawan pillushka kipi.
Maytutaka anti suyupimi yanunkuna. maytuna</p>          </div>', 'ACTIVE', 1, '-'),
       (487, 'mayu', '0', 'mayu', '<div class="word--description">             <span class="word--fonetic">[ mayu]</span>              <p class="word--description">s. río. Tukuy pacha hatun ñanshinata purik yaku .
¿Tukuy mayukunapi wampuwan puriyta ushanchikchu?.
Sin. Hatun yaku.
mayu (<*mayu) s. vía láctea. Hawa pachapi ñuñushina suni ñan.
Mayupika achka kuylluryukmi kan.
Sin. kasa anku.
maywa</p>          </div>', 'ACTIVE', 1, '-'),
       (488, 'mayzana', '0', 'mayzana', '<div class="word--description">             <span class="word--fonetic">[mayzana, mayzina]</span>              <p class="word--description">v. ss. perder el conocimiento. Uma muyushkashina unkuy. Paytaka irki runa kakpimi mayzarka.
Sin. Shinkana.
michik</p>          </div>', 'ACTIVE', 1, '-'),
       (489, 'michina', '0', 'michina', '<div class="word--description">             <span class="word--fonetic">[mičina]</span>              <p class="word--description">v. s. pastar, pastorear.
Achka wiwakunata pampakunaman pushas- hpa mapa kiwakunata mikuchiy.
Wakin wawakunami llamakunata michin. mikllana</p>          </div>', 'ACTIVE', 1, '-'),
       (490, 'mikmichu', '0', 'mikmichu', '<div class="word--description">             <span class="word--fonetic">[mixmiču]</span>              <p class="word--description">s. amz. variedad de gavilán. Inti punchapi mik mik mik kaparish- pa purik anka.
Mikmichu anka wakakta uyarkani. mikuna</p>          </div>', 'ACTIVE', 1, '-'),
       (491, 'mikuna', '0', 'mikuna', '<div class="word--description">             <span class="word--fonetic">[mikuna]</span>              <p class="word--description">v. comer, alimentarse. Yarkay richun mikunata millpuna.
Kunanka tantata mikukuni.
mikya</p>          </div>', 'ACTIVE', 1, '-'),
       (492, 'millay', '0', 'millay', '<div class="word--description">             <span class="word--fonetic">[milyay, mižay, milyi, milyik, milyig]</span>              <p class="word--description">adj.
mal genio, mal humorado. Piñak runa, mana

Wakin runakunaka millay yuyaytami charin. millana</p>          </div>', 'ACTIVE', 1, '-'),
       (493, 'millayana', '0', 'millayana', '<div class="word--description">             <span class="word--fonetic">[milyayana, milyiyana, mižayana]</span>              <p class="word--description">v. enojarse, enfurecerse, malhumorarse. Alli kashpa piñariy.
Kan millay kakpimi millayani.
Sin. Piñarina.
millchina</p>          </div>', 'ACTIVE', 1, '-'),
       (494, 'millma', '0', 'millma', '<div class="word--description">             <span class="word--fonetic">[milyma, mišma, mižma, wilyma, ilyma]</span>              <p class="word--description">s. lana, vello, cerda. Runapa, wiwapa karapipash akchashina tiyak.
Wawapa rinri mana uyakpika llaminku mill- matami rinri hutkupi satirka.
millpuna</p>          </div>', 'ACTIVE', 1, '-'),
       (495, 'milluku', '0', 'milluku', '<div class="word--description">             <span class="word--fonetic">[milyuku, mižuku, ulluku]</span>              <p class="word--description">s. s. me- lloco. Llawsayuk, papashina allpa ukupi pu- kuk muru.
Minkaman rinkapak millukuta timpuchipanki. mimish</p>          </div>', 'ACTIVE', 1, '-'),
       (496, 'mincha', '0', 'mincha', '<div class="word--description">             <span class="word--fonetic">[minča, minža]</span>              <p class="word--description">adv. pasado ma- ñana, traspasado mañana. Kayapa washa punchami kan.
¿Minchataka shamusha ninkichu?.
Sin. Kayantin.
minka</p>          </div>', 'ACTIVE', 1, '-'),
       (497, 'minkachina', '0', 'minkachina', '<div class="word--description">             <span class="word--fonetic">[miŋgačina]</span>              <p class="word--description">v. brindar posada, hospedar. Kikinpa wasipi shuk kuchuta pu- ñuchun mañachiy.
Kayaka kikinpa wasipi minkachiwanki.
minkarina</p>          </div>', 'ACTIVE', 1, '-'),
       (498, 'minkana', '0', 'minkana', '<div class="word--description">             <span class="word--fonetic">[miŋgana]</span>              <p class="word--description">v. pedir ayuda a otro. Shuktak mashikunata yanapachun mañay. Llakta mashiman wasita rikuchun minkar- kani.
2. encargar, encomendar. Imakunatapash shukman kushpa sakiy.
Churana kipita Quito llaktaman minkarkani. mintalana</p>          </div>', 'ACTIVE', 1, '-'),
       (499, 'mirachina', '0', 'mirachina', '<div class="word--description">             <span class="word--fonetic">[miračina]</span>              <p class="word--description">v. multiplicar, acre- centar. Chayllatak tawka kutin yapachishpa achkayachiy.
Kay yupaykunata mirachirka.
mirana</p>          </div>', 'ACTIVE', 1, '-'),
       (500, 'mirka', '0', 'mirka', '<div class="word--description">             <span class="word--fonetic">[mirka, mirga]</span>              <p class="word--description">s. peca. Aycha karapi
llukshik yana shuyu.
Chay warmika achka mirkayukmi kan.
2. manchas del rostro (paño).Yana sisushina ñawipi llukshik.
Kanpa uyapi mirka llukshishka.
misha</p>          </div>', 'ACTIVE', 1, '-'),
       (501, 'mishana', '0', 'mishana', '<div class="word--description">             <span class="word--fonetic">[mišana]</span>              <p class="word--description">v. s. competir, ganar. Chayllatatak rurakushpa ñawpashpa tuku- chiy.
Yachaykunapi mishakuni.
Sin. Kamana, yallina.
mishki</p>          </div>', 'ACTIVE', 1, '-'),
       (502, 'mishkichina', '0', 'mishkichina', '<div class="word--description">             <span class="word--fonetic">[miškičina]</span>              <p class="word--description">s. condimento. Mi- kunata sumakyachik kiwakuna, kutakuna, shukkunapashmi kan.
Chawpi puncha mikunata mishkichinawan yanunki.
mishkichuspi</p>          </div>', 'ACTIVE', 1, '-'),
       (503, 'mishkishimi', '0', 'mishkishimi', '<div class="word--description">             <span class="word--fonetic">[miški šimi]</span>              <p class="word--description">adj. lisonjero. Imatapash mishkilla rimak.
Chay wamraka mishki shimimi kashka, pak- tarak.
mishu</p>          </div>', 'ACTIVE', 1, '-'),
       (504, 'mishun', '0', 'mishun', '<div class="word--description">             <span class="word--fonetic">[mišun]</span>              <p class="word--description">s. herramienta para desho- jar. Atallpa chankamanta llukshichishka tullu. Sarata tipinkapak rurashka tullu.
Mishunwanmi sarata sumakta tipinchik.
Sin. Tipina.
misi</p>          </div>', 'ACTIVE', 1, '-'),
       (505, 'mita', '0', 'mita', '<div class="word--description">             <span class="word--fonetic">[mita]</span>              <p class="word--description">s. época, período, edad. Tukuy- kuna kawsay pacha.
Chay mashika ñukanchikpa mitamantami kan.
Sin. pacha.
mitayu</p>          </div>', 'ACTIVE', 1, '-'),
       (506, 'mitayuna', '0', 'mitayuna', '<div class="word--description">             <span class="word--fonetic">[mitayuna]</span>              <p class="word--description">s. amz. ir de cacería y pesca. Sachaman wiwakunata hapinkapak riy.




Ñawpa Wao mashikunaka sachapillami wi- wakunata mitayushka.
Sin. Purina.
mitikuna</p>          </div>', 'ACTIVE', 1, '-'),
       (507, 'mitsa', '0', 'mitsa', '<div class="word--description">             <span class="word--fonetic">[miča, mitsa, miša]</span>              <p class="word--description">s. verruga. Chaki aychapi, maki aychapi wiñak muyushina.
Chay uchilla wawapa makipika mitsami wiñakun.
Sin. Chimpi, michamuyu.
mitsak</p>          </div>', 'ACTIVE', 1, '-'),
       (508, 'mitsamuyu', '0', 'mitsamuyu', '<div class="word--description">             <span class="word--fonetic">[mičamuyu, mitsamuyu, miša- muyu]</span>              <p class="word--description">s. verruga. Chakipi makipi wiñak mu- yushina.
Chay uchilla wawapa makipika mitsamu- yumi wiñakun.
Sin. Chimpi, mitsa, micha.
mitsana</p>          </div>', 'ACTIVE', 1, '-'),
       (509, 'miyu', '0', 'miyu', '<div class="word--description">             <span class="word--fonetic">[miyu]</span>              <p class="word--description">s. veneno. Wañuchina hampi. Shanshi muyuka miyumi kan.
miyuna</p>          </div>', 'ACTIVE', 1, '-'),
       (510, 'muchana', '0', 'muchana', '<div class="word--description">             <span class="word--fonetic">[mučana]</span>              <p class="word--description">v. besar, respetar, ve- nerar. Shimipura tantachiy.
Kuyashkamanta, llakishkamanta payta mu- chani.
2. adorar, invocar. Apunchikta, apukunata kuyay.
Iñikkunaka apunchikta yanapachun nishpami
mucharka.
Sin. 2 mañana.
mukawa</p>          </div>', 'ACTIVE', 1, '-'),
       (511, 'muklupuna', '0', 'muklupuna', '<div class="word--description">             <span class="word--fonetic">[muxlupuna]</span>              <p class="word--description">v. amz. hacer gár- garas. Yakuta amullishpa kunkakama ka- chashpa, kutinllatak tikrachishpa shitay.
Wayusata kashtushpa muklupuni.
muku</p>          </div>', 'ACTIVE', 1, '-'),
       (512, 'mukuna', '0', 'mukuna', '<div class="word--description">             <span class="word--fonetic">[mukuna]</span>              <p class="word--description">v. sn, amz. mascar, mas-
ticar. Kiruwan mikunata ñutuna. Sara kamchataka allitami mukunki. Sin. Kaskana, kashtuna, akuna.
mullapa</p>          </div>', 'ACTIVE', 1, '-'),
       (513, 'mullchi', '0', 'mullchi', '<div class="word--description">             <span class="word--fonetic">[mulychi]</span>              <p class="word--description">s. amz. árbol silvestre con
fruto. Muyuyuk sacha yura. Pishkukuna mi- kuna muyuyuk.
Wakamayuka mullchi muyuta mikun. mullu</p>          </div>', 'ACTIVE', 1, '-'),
       (514, 'mulu', '0', 'mulu',
        '<div class="word--description">             <span class="word--fonetic">[mulu, muluku]</span>              <p class="word--description">s. ss. plato. Mikunata churankapak rurashka kallanashina rikurik. Apitaka ¿anta mulupichu kararka? munachina</p>          </div>',
        'ACTIVE', 1, '-'),
       (515, 'munanayay', '0', 'munanayay', '<div class="word--description">             <span class="word--fonetic">[munanayay]</span>              <p class="word--description">adv. hermoso, bello, lindo. Imakunapash sumak rikurikta ninkapak shimi.
Chay urkupika rasuka munanayaytami rikurin.



Sin. munanayak, sumak.
munana</p>          </div>', 'ACTIVE', 1, '-'),
       (516, 'munchi', '0', 'munchi', '<div class="word--description">             <span class="word--fonetic">[muŋči]</span>              <p class="word--description">s. ss. ave, pájaro. Tukuy pishkunapa shuti.
Wamra	kashpaka	munchikunata hapirkanchik.
Sin. zhuta, pisku.
munchi</p>          </div>', 'ACTIVE', 1, '-'),
       (517, 'muntiti', '0', 'muntiti', '<div class="word--description">             <span class="word--fonetic">[munditi]</span>              <p class="word--description">s. amz. pavo nocturno. Punchayakpi titiri titiri kaparik hatun sacha pishku.
Muntitika tutami pawashpa purin.
Sin. Waturitu.
munzira</p>          </div>', 'ACTIVE', 1, '-'),
       (518, 'murintu', '0', 'murintu', '<div class="word--description">             <span class="word--fonetic">[murindu]</span>              <p class="word--description">s. amz. variedad de sapo. Hatun muru, puka karayuk, pur pur nik mikuna hampatu.
Chay waykupi murintu wakakun.
Sin. Puy.
muriti</p>          </div>', 'ACTIVE', 1, '-'),
       (519, 'muru', '0', 'muru', '<div class="word--description">             <span class="word--fonetic">[muru]</span>              <p class="word--description">s. s. fruto. Tawka yuramanta wiñarik muyu, ashtawanka sisatukuk.
Sara murukunata wayrachini.
Sin. muyu, ñawi.
muru</p>          </div>', 'ACTIVE', 1, '-'),
       (520, 'unkuy', '0', 'unkuy', '<div class="word--description">             <span class="word--fonetic">[muru uŋkuy]</span>              <p class="word--description">s. viruela, sa- rampión. Puka murukunawan aychata katak wakinpika wañuchik unkuy.
Wakin llaktakunapika muru-unkuyka ña chinkarirkami.
mushuk</p>          </div>', 'ACTIVE', 1, '-'),
       (521, 'muskuna', '0', 'muskuna', '<div class="word--description">             <span class="word--fonetic">[muskuna, nuskuna]</span>              <p class="word--description">v. soñar. Puñukuy pacha imakunatapash mana usha- rinata rikuy.
Kunan tutaka¿ imatatak muskurkanki? muspa</p>          </div>', 'ACTIVE', 1, '-'),
       (522, 'muspana', '0', 'muspana', '<div class="word--description">             <span class="word--fonetic">[muspana]</span>              <p class="word--description">v. tontear. Rimak kas- hpapash ñapash upa tukuy.
Rikchariy, ama wawashina muspakuychu. muspayana</p>          </div>', 'ACTIVE', 1, '-'),
       (523, 'musyana', '0', 'musyana', '<div class="word--description">             <span class="word--fonetic">[musyana, misyana]</span>              <p class="word--description">v. amz. pre- veer. Imatapash ña paktarinata yachay.
Ñukapa yaya shamunata ñami musyarkani. mutilun</p>          </div>', 'ACTIVE', 1, '-'),
       (524, 'mutiyana', '0', 'mutiyana', '<div class="word--description">             <span class="word--fonetic">[mutiyana]</span>              <p class="word--description">v. amz. estilarse, em- paparse, mojarse. Churanakuna shutunka- kama yakuwan, tamyawan hukuyana.
Yayaka allpapi llamkakushpa yallita muti- yarka.
Sin. Lapukyana, hukuna, zutukyana.
mutki</p>          </div>', 'ACTIVE', 1, '-'),
       (525, 'mutkina', '0', 'mutkina', '<div class="word--description">             <span class="word--fonetic">[mutkina, muxtina]</span>              <p class="word--description">v. oler. Sinka- wan samayta aysashpa, ima samaytapash riksina.
Pay warmika may sumak ashnak yakutami
mutkirka.
mutul</p>          </div>', 'ACTIVE', 1, '-'),
       (526, 'mutulu', '0', 'mutulu', '<div class="word--description">             <span class="word--fonetic">[mutulu]</span>              <p class="word--description">s. amz. serpiente mataca- ballo. Uchpa tullpuyuk hatun machakuy zar zar nishpa tutakunapi wakak.
Chay sachapimi mutuluka tutapi wakarka. muya</p>          </div>', 'ACTIVE', 1, '-'),
       (527, 'muyan', '0', 'muyan', '<div class="word--description">             <span class="word--fonetic">[muyaŋ muyaŋ]</span>              <p class="word--description">adj. amz. fruto desagradable. Wakin chuntata, mikukpi shimita shikshichik muyu.
Muyan muyan chuntata mikurkani, chayka shimita shikshirka.
muyu</p>          </div>', 'ACTIVE', 1, '-'),
       (528, 'muyuntin', '0', 'muyuntin', '<div class="word--description">             <span class="word--fonetic">[muyuŋdiŋ, muyuŋdi]</span>              <p class="word--description">adv. alre- dedor. Imakunatapash muyushpa tiyak.
Wasi muyuntintami sisakunataka tarpurkani. muyuna</p>          </div>', 'ACTIVE', 1, '-'),
       (529, 'nanakllakana', '0', 'nanakllakana', '<div class="word--description">             <span class="word--fonetic">[(<*nanakllakana)]</span>              <p class="word--description">v. abun- dar. Muyukuna, mikunakuna, churanakuna, imakunapash achka tiyay, achka tukuy.
Ñukapa chakrapi achka palantami nanaklla- kan.
Sin. kamana, usuna.
nanakyana</p>          </div>', 'ACTIVE', 1, '-'),
       (530, 'nanampi', '0', 'nanampi',
        '<div class="word--description">             <span class="word--fonetic">[nanambi, nanaŋbi]</span>              <p class="word--description">s. amz. be- juco. Suniyashka waska yura, pallkapi wiñak. Tiyarinataka nanampi ankuwanmi rurashka. nanarina</p>          </div>',
        'ACTIVE', 1, '-'),
       (531, 'nanay', '0', 'nanay', '<div class="word--description">             <span class="word--fonetic">[nanay]</span>              <p class="word--description">s. dolor. Aycha ukku unkuriy.
Uma nanaywan llakillami kan.
2. v. doler. Imatapash yapa rurakpi aycha unkuriy.
Yapa purishkamanta chakika yapata nana-
wan.
napana</p>          </div>', 'ACTIVE', 1, '-'),
       (532, 'napaykuna', '0', 'napaykuna', '<div class="word--description">             <span class="word--fonetic">[napaykuna, napana]</span>              <p class="word--description">v. salu- dar. Maypipash, piwanpash rikurishpa makita kushpapash rimariy.
Kankunata tukuy shunkuwan napaykuni. nina</p>          </div>', 'ACTIVE', 1, '-'),
       (533, 'ninan', '0', 'ninan', '<div class="word--description">             <span class="word--fonetic">[ninan]</span>              <p class="word--description">adv. s. muy, mucho; exage-

ración. Imatapash yalli hatunyachishpa nirik shimi.
Ninan karuta purimuni. Sin. Yapa, may, yalli.
ninanta</p>          </div>', 'ACTIVE', 1, '-'),
       (534, 'ninanta', '0', 'ninanta', '<div class="word--description">             <span class="word--fonetic">[ninanta]</span>              <p class="word--description">adv. Rapidísimo, veloz. Utka ruray.
Yachanawasimanka ninanta kallpashpa pak- tarkani.
Sin. Utka.
nitkana</p>          </div>', 'ACTIVE', 1, '-'),
       (535, 'nina', '0', 'nina', '<div class="word--description">             <span class="word--fonetic">[nina, ñina]</span>              <p class="word--description">v. decir. Ñukapa yuyayta shukman uyachinkapak rimana.
Sumak yuyaytami wawaman nini.
2.	v. forma verbal auxiliar para expresar ono- matopeyas. Rimaypi uyarishkakunata chu- ray.
Tamyakpika sinchitami kulun nin.
nuna</p>          </div>', 'ACTIVE', 1, '-'),
       (536, 'nuspa', '0', 'nuspa', '<div class="word--description">             <span class="word--fonetic">[nuspa]</span>              <p class="word--description">s. pa. bromista. Imatapash asichinkapak rimashka.
Imata nishpapash nuspa runaka tukuyta asi- chinllami.
Sin. asichik.
nuspana</p>          </div>', 'ACTIVE', 1, '-'),
       (537, 'nuya', '0', 'nuya', '<div class="word--description">             <span class="word--fonetic">[nuya]</span>              <p class="word--description">s. variedad de haba. Shuk ha- basshina muru.


Llullu nuyuka mishki mikuymi kan.
nuyuna</p>          </div>', 'ACTIVE', 1, '-'),
       (538, 'a', '0', 'a', '<div class="word--description">             <span class="word--fonetic">[ña]</span>              <p class="word--description">adv. ya, al instante. Ari ninkapak ranti shimimi kan.
Ña llaktamanta shamunimi.
ñachak</p>          </div>', 'ACTIVE', 1, '-'),
       (539, 'aka', '0', 'aka', '<div class="word--description">             <span class="word--fonetic">[ñaka, ñaxa]</span>              <p class="word--description">adv. antes. Yallishka pa-
chata rikuchinkapak shimi.
Wasipika ñakami purikurkani.
ñakalla</p>          </div>', 'ACTIVE', 1, '-'),
       (540, 'akarina', '0', 'akarina', '<div class="word--description">             <span class="word--fonetic">[ñakarina, ñaxarina]</span>              <p class="word--description">v. atorme- tarse, lamentarse. Ima llakikunamantapash shunkupi nanarina.
Paypa warmi wañushkamanta achkatami ña- karin.
Sin. nanarina.
ñakchana</p>          </div>', 'ACTIVE', 1, '-'),
       (541, 'alla', '0', 'alla', '<div class="word--description">             <span class="word--fonetic">[ñalya, ñaža]</span>              <p class="word--description">adv. casi, ya mismo, en- seguida. Imatapash utkarinmi nina shimi.
Pachamamaka mana alli kamakpika ñallami achkata llakichinka.
ñan</p>          </div>', 'ACTIVE', 1, '-'),
       (542, 'a', '0', 'a', '<div class="word--description">             <span class="word--fonetic">[ñaña]</span>              <p class="word--description">s. hermana a hermana. Chay mamamantallatak wacharishka ushushipura nina shimi.
Paymi ñukapa kipa ñaña kan, María nirka. ñañu</p>          </div>', 'ACTIVE', 1, '-'),
       (543, 'atak', '0', 'atak', '<div class="word--description">             <span class="word--fonetic">[ñatak, ñatax, ñata, ñatag]</span>              <p class="word--description">interj. ex- presión prohibitiva ¡cuidado!. Ama chayta ru- raychu ninkapak shimi.

Ama tamyapi rinkichu, ñatak urmankiman.
Sin. paktarak.
ñawchi</p>          </div>', 'ACTIVE', 1, '-'),
       (544, 'awi', '0', 'awi', '<div class="word--description">             <span class="word--fonetic">[ñawi, ñabi, ñiwi]</span>              <p class="word--description">s. ojo, vista. Runaku- napi, wiwakunapi tukuyta rikuk.
Rukuyakpika ñawika ñawsatami rikun.
2.	s. cogollo. Yurakunapi, kiwakunapi chaw- pimanta llukshik llullu panka.
Yakuta, wanuta churakpika yurapa ñawika sumaktami wiñan.
3.	cara, rostro. Shimi, sinka, rinri, tirkutapash charik, shuk llaktakunapi uya shutiyukmi kan. Runakunapa ñawika kushillami kan.
Sin. 2 llulluk, 3 uya.
ñawpa</p>          </div>', 'ACTIVE', 1, '-'),
       (545, 'awpana', '0', 'awpana', '<div class="word--description">             <span class="word--fonetic">[ñawpana, ñaŋpana]</span>              <p class="word--description">v. adelan- tarse, anticiparse. Imapipash shukta yallish- pa ruray.
Yachachikka hatun ñanta ñawpakun. ñawsa</p>          </div>', 'ACTIVE', 1, '-'),
       (546, 'irak', '0', 'irak', '<div class="word--description">             <span class="word--fonetic">[ñirak, nirak]</span>              <p class="word--description">comp. Clase, variedad. Kayka chayshina rikurikmi kan nishpa rimay. Kay sisaka amankayñirakmi kan.
Sin. sami, -shina.
ñitina</p>          </div>', 'ACTIVE', 1, '-'),
       (547, 'uka', '0', 'uka', '<div class="word--description">             <span class="word--fonetic">[ñuka, ñuxa, ñux, ñuku]</span>              <p class="word--description">pron. yo. Kikin shutipa ranti ninkapak shimi.
Ñukaka kaypimi kawsani.
ñukanchik</p>          </div>', 'ACTIVE', 1, '-'),
       (548, 'u', '0', 'u', '<div class="word--description">             <span class="word--fonetic">[ñugñu]</span>              <p class="word--description">adj. soso, desabrido. Mana
kachita, mana mishkita charik mikuna.
Kachi illak mikunaka ñukñumi kashka.
2. tu. empalagoso. Yapa mishkiyuk. Kay mikuyka ñukñu mikuymi kan. Sin. 1 Chamuk, chamcha.
ñuku</p>          </div>', 'ACTIVE', 1, '-'),
       (549, 'u', '0', 'u', '<div class="word--description">             <span class="word--fonetic">[ñuñu]</span>              <p class="word--description">s. leche materna humana. War- mikunapa chuchumanta llukshik yurak yaku, mikuypa may alli.
Llullu wawaka mamapa ñuñutami chuchun.
ñuñukina</p>          </div>', 'ACTIVE', 1, '-'),
       (550, 'usta', '0', 'usta', '<div class="word--description">             <span class="word--fonetic">[ñusta]</span>              <p class="word--description">s. princesa, reina soltera.


Tawka kuytsakunamanta akllashka sumak warmi.
Sara ñustaka, may sumak warmimi kan. ñutku</p>          </div>', 'ACTIVE', 1, '-'),
       (551, 'utu', '0', 'utu',
        '<div class="word--description">             <span class="word--fonetic">[ñutu]</span>              <p class="word--description">s. amz. planta que da fruto. Mis- hki mikunata aparik kiwashina uchilla yura. Anti suyuman rishpaka ñututami mikunchik. ñutu</p>          </div>',
        'ACTIVE', 1, '-'),
       (552, 'utuna', '0', 'utuna', '<div class="word--description">             <span class="word--fonetic">[ñutuna]</span>              <p class="word--description">v. pulverizar, suavizar, re-
finar. Imakunatapash kutatashina ruray.
Yayaka ukata tarpunkapakmi allpata ñutun.
























pacha</p>          </div>', 'ACTIVE', 1, '-'),
       (553, 'pachak', '0', 'pachak', '<div class="word--description">             <span class="word--fonetic">[pačak, patsax, patsak, patsag, pasak]</span>              <p class="word--description">num. cien, ciento. Chunka kutin chun- kachikpi tukuk yupay.
Shuk apiwta pachak kullkipimi katurkani. pachakamak</p>          </div>', 'ACTIVE', 1, '-'),
       (554, 'pachallina', '0', 'pachallina',
        '<div class="word--description">             <span class="word--fonetic">[pačalyina]</span>              <p class="word--description">s. Ima puchkawan- pash awashka, warmipa washata pillurina. Kusaka pachallinata warmipakmi awan. pachamama</p>          </div>',
        'ACTIVE', 1, '-'),
       (555, 'pakarichina', '0', 'pakarichina', '<div class="word--description">             <span class="word--fonetic">[pakaričina]</span>              <p class="word--description">v. amz. alumbrar, dar a luz. Chichu warmi wachariy.
Rosa mashika wachana wasipimi pakari- chirka.
Sin. Wacharina, mirarina. pakarinmikuna</p>          </div>', 'ACTIVE', 1, '-'),
       (556, 'pakarina', '0', 'pakarina', '<div class="word--description">             <span class="word--fonetic">[pakarina]</span>              <p class="word--description">v. amanecer. Inti lluks- hinkapak achikyashpa punchayay.
Hatun mayupi challwakukpi pakarirka.

2.	trasnochar. Tutapi mana puñuy.
Shuwata chapashpa pakarirkani.
pakana</p>          </div>', 'ACTIVE', 1, '-'),
       (557, 'pakay', '0', 'pakay', '<div class="word--description">             <span class="word--fonetic">[pakay]</span>              <p class="word--description">s. sns, amz. guaba. Mishki
mikunata kara ukupi charik, yana muyuyuk hatun purutushina.
Juanchuka tulupi pakayta pallankapak rirka.
Sin. Kachik.
pakcha</p>          </div>', 'ACTIVE', 1, '-'),
       (558, 'paki', '0', 'paki', '<div class="word--description">             <span class="word--fonetic">[paki, phaki, faki]</span>              <p class="word--description">adj. pedazo, rotura, fractura; fracción (quebrado en matemáti- cas). Llikishka, ñutuyachiska, chiktarishka. Paki lumuta kuchiman shitay.
Sin. piti, chawpi, iki.
pakina</p>          </div>', 'ACTIVE', 1, '-'),
       (559, 'paklla', '0', 'paklla', '<div class="word--description">             <span class="word--fonetic">[paxlya, pakža]</span>              <p class="word--description">adj. amz. despejado, claro. Sachapi yurata, kiwata pitikpi chushak punchaklla sakirina.
Paklla pampata yallimuni.
pakllana</p>          </div>', 'ACTIVE', 1, '-'),
       (560, 'pakta', '0', 'pakta', '<div class="word--description">             <span class="word--fonetic">[paxta]</span>              <p class="word--description">adj. amz. concluido, termi- nado, finalizado. Imatapash tukuchinkakama llamkay.
Yachaytaka paktami kan.
Sin. Tukurishka, tukuchishka.
paktachina</p>          </div>', 'ACTIVE', 1, '-'),
       (561, 'paktalla', '0', 'paktalla', '<div class="word--description">             <span class="word--fonetic">[paxtalya, paktaža]</span>              <p class="word--description">adj. mediano.


takyashka.
Mashika pala kaspita rantirka.
Sin. patak.



Imapash chawpiyashka, mana hatun, mana uchillachu.
Paktalla wakrata katushpa warata rantirka.
Sin. Mallta.
paktamuna</p>          </div>', 'ACTIVE', 1, '-'),
       (562, 'paktarak', '0', 'paktarak', '<div class="word--description">             <span class="word--fonetic">[paxtarak]</span>              <p class="word--description">interj. expresión prohi- bitiva ¡cuidado!. Ama chayta ruraychu ninka- pak shimi.
Ama tamyapi rinkichu, paktarak, urmanki- man.
Sin. ñatak.
paktana</p>          </div>', 'ACTIVE', 1, '-'),
       (563, 'paku', '0', 'paku', '<div class="word--description">             <span class="word--fonetic">[paku, paxu, paxo]</span>              <p class="word--description">s. amz. brujo, cu-
randero. Imatapash hawalla usharik hampik runa. Ayawaskata, sayrita, wakinpika kiwaku- natapash upyashpa rikuk.
Paku runaka yurakunawan unkushkata ham- pikun.
Sin. sakra, salamanka, yachak.
paku</p>          </div>', 'ACTIVE', 1, '-'),
       (564, 'paku', '0', 'paku', '<div class="word--description">             <span class="word--fonetic">[paku, pako]</span>              <p class="word--description">adj. sn. color café oscuro.
Turu allpashina rikurik tullpu.
Paku rumita waykumanta apamuni.
paku</p>          </div>', 'ACTIVE', 1, '-'),
       (565, 'pala', '0', 'pala', '<div class="word--description">             <span class="word--fonetic">[pala]</span>              <p class="word--description">adj. amz. ancho. Kinrayman pa-

palak</p>          </div>', 'ACTIVE', 1, '-'),
       (566, 'palamaku', '0', 'palamaku', '<div class="word--description">             <span class="word--fonetic">[palamaku, falamaku, palama]</span>              <p class="word--description">s. bo. divinidad que originó los insectos. Ñawpa pacha runapa yuyaypika tukuysami chuspita wachachishka.
Palamaku apuka tukuy chuspita wiñachis- hka.
2. bo. insecto en general. Tukuy uchilla chus- pikunapa, kurukunapa shuti.
Chay wawa mashika mana rikshishka pala- makuwan unkurka.
palanikuk</p>          </div>', 'ACTIVE', 1, '-'),
       (567, 'palanina', '0', 'palanina', '<div class="word--description">             <span class="word--fonetic">[phalanina]</span>              <p class="word--description">v. brillar, resplandecer.
Ima antakunapash llipyarik.
Kunan tutamantaka intika ¡manchanay! pa- lanin.
Sin. Llipyana.
palanta</p>          </div>', 'ACTIVE', 1, '-'),
       (568, 'palata', '0', 'palata', '<div class="word--description">             <span class="word--fonetic">[palata, balata]</span>              <p class="word--description">s. amz. caucho. Shuk hatun pankayuk, achka yurak wikiyuk yura.
Palata yuraka anti suyu sachapimi wiñan. palik</p>          </div>', 'ACTIVE', 1, '-'),
       (569, 'palikina', '0', 'palikina', '<div class="word--description">             <span class="word--fonetic">[palikina, phalikina, pharikina]</span>              <p class="word--description">v. bo. desmenuzar. Imatapash ñutuy.
Pedro mashimi, misiman tantata palikirka.
Sin. Hakuna.
palla</p>          </div>', 'ACTIVE', 1, '-'),
       (570, 'palla', '0', 'palla', '<div class="word--description">             <span class="word--fonetic">[palya]</span>              <p class="word--description">s. rondador. Sukus pitishkaku- nata kimichishpa watashka pukuna takik.



Wamrakuna pallapi takishpa rikuchirka. pallana</p>          </div>', 'ACTIVE', 1, '-'),
       (571, 'pallka', '0', 'pallka', '<div class="word--description">             <span class="word--fonetic">[palyka, pažka, palka, parka]</span>              <p class="word--description">s. hor- queta, bifurcación. Yura wiñarishpa ishkaypi rakirishka.
Pallka kaspiwan kupata wayrachirkani.
2. catapulta. Rumita warakankapak rurashka kaspi.
Andres wamraka pallkawan rumita karuman shitarka.
Sin. 1 mantakakiru.
pallkayana</p>          </div>', 'ACTIVE', 1, '-'),
       (572, 'pallta', '0', 'pallta', '<div class="word--description">             <span class="word--fonetic">[palytay, palta]</span>              <p class="word--description">s. aguacate. Waylla ka-
rayuk, waylla mikunayuk, sinchi muyuyuk muru.
Salasaca llaktapika, aya punchakunapimi, achka palltataka mikunchik.
palltana</p>          </div>', 'ACTIVE', 1, '-'),
       (573, 'palu', '0', 'palu', '<div class="word--description">             <span class="word--fonetic">[palu]</span>              <p class="word--description">s. lagartija. Uchilla waksashina, allpapi llukashpa purik wiwa.
Chay sirik kaspi hawata paluka kallparka.
2. amz. culebra. Witapi kawsak machakuy. Ishpinku yurapi shuk sumak tullpuyuk pa- lumi llukan.
Sin. 2 Machakuy.
pampa</p>          </div>', 'ACTIVE', 1, '-'),
       (574, 'pampa', '0', 'pampa', '<div class="word--description">             <span class="word--fonetic">[pamba, paŋba]</span>              <p class="word--description">adj. común, gene- ral. Tukuyta ninkapak shimi.
Pampa unkuyta warwar yakuwan hampirini. pampana</p>          </div>', 'ACTIVE', 1, '-'),
       (575, 'pani', '0', 'pani', '<div class="word--description">             <span class="word--fonetic">[pani]</span>              <p class="word--description">s. de hermano a hermana. Chay mamamantallatak llukshishka kari churi warmi ushushita ninkapak.
Mashi, kanpa paniwanmi sawarina kani. panka</p>          </div>', 'ACTIVE', 1, '-'),
       (576, 'pankalla', '0', 'pankalla', '<div class="word--description">             <span class="word--fonetic">[paŋgalya]</span>              <p class="word--description">adj. ágil, veloz, liviano. Imapash Hawalla, mana llashak kak.
Wawakunaka pankallami kallpan.
Sin. wayralla.
panshi</p>          </div>', 'ACTIVE', 1, '-'),
       (577, 'pantay', '0', 'pantay', '<div class="word--description">             <span class="word--fonetic">[panday]</span>              <p class="word--description">s. error, equivocación, confusión. Waklliy ruraykuna, yuyaykunapas- hmi kan.
Kay pantayta allichipay.
pantana</p>          </div>', 'ACTIVE', 1, '-'),
       (578, 'panti', '0', 'panti', '<div class="word--description">             <span class="word--fonetic">[paŋti]</span>              <p class="word--description">s. yerba para teñir. Imatapash
tullpuk kiwa.
Panti kiwawan tullpuyta yachachishunchik. Pantinsaya	(<**	paŋtinsaya: pa+ntin+saya) s. Continente americano. Pa- cificopa, Atlanticopa chawpipi sakirik suyu, hatunllakta.
Pantinsayapika azteca, maya, chibcha, inka, guarani runami kawsan.
Sin Apya Yala.
pantu</p>          </div>', 'ACTIVE', 1, '-'),
       (579, 'panwa', '0', 'panwa', '<div class="word--description">             <span class="word--fonetic">[paŋwa, paŋgua]</span>              <p class="word--description">s. amz. trampa de cacería para animales pequeños. Uchilla




sacha wiwakunata hapinkapak rurashka. Kay tutamanta shuk siku panwapi urmashka panzaw</p>          </div>', 'ACTIVE', 1,
        '-'),
       (580, 'a', '0', 'a', '<div class="word--description">             <span class="word--fonetic">[paña]</span>              <p class="word--description">s. amz. piraña. Puka ñawiyuk, sinchi shinchi kiruyuk, aycha mikuk, yakupi kawsak challwa.
Paña aychapash sumakmi kan.
paña</p>          </div>', 'ACTIVE', 1, '-'),
       (581, 'papa', '0', 'papa', '<div class="word--description">             <span class="word--fonetic">[papa]</span>              <p class="word--description">s. papa, patata. Allpa ukupi tiyak ankukunapi mikuna muruta aparik yuyu.
¿Mashna ashanka papatatak kanpa chakra- manta allarkanki?.
paparawa</p>          </div>', 'ACTIVE', 1, '-'),
       (582, 'paramuna', '0', 'paramuna', '<div class="word--description">             <span class="word--fonetic">[paramuna, paramuyana]</span>              <p class="word--description">v. s. lloviznar. Ñutu tamya urmay.
Kunan chishipimi paramurka.
parawaku</p>          </div>', 'ACTIVE', 1, '-'),
       (583, 'parkuna', '0', 'parkuna', '<div class="word--description">             <span class="word--fonetic">[parkuna, parkona]</span>              <p class="word--description">v. ss. regar o esparcir agua. Tarpushkakunapi yakuta talliy, hichay.
Papa chakrapi parkurkani.
Sin. Tallina, chakchuna.
paruk</p>          </div>', 'ACTIVE', 1, '-'),
       (584, 'paskana', '0', 'paskana', '<div class="word--description">             <span class="word--fonetic">[paskana]</span>              <p class="word--description">v. abrir, despegar. Wichkashkata, watashkatapash kachachiriy, karuyachiy.
¿Imaraykutak punkutaka mana utka paskar- kanki?
Sin. pakllana.


pasña</p>          </div>', 'ACTIVE', 1, '-'),
       (585, 'paspa', '0', 'paspa', '<div class="word--description">             <span class="word--fonetic">[paspa]</span>              <p class="word--description">s. paspa. Aycha kara chaki- rishpa karachashka.
¿Imamantatak paspa ñawi kanki?. paspayana</p>          </div>', 'ACTIVE', 1, '-'),
       (586, 'pasu', '0', 'pasu', '<div class="word--description">             <span class="word--fonetic">[pasu]</span>              <p class="word--description">s. amz. tipo de árbol de frutos comestibles. Raku yura ñañu pankayuk, mi- kuna muyuta aparik.
Pasuta hapinkapakmi mamaka rirka.
pata</p>          </div>', 'ACTIVE', 1, '-'),
       (587, 'patak', '0', 'patak', '<div class="word--description">             <span class="word--fonetic">[phatax, phatix]</span>              <p class="word--description">adj. ancho. Tupuypi imapash hatun pankashina.
Patak rinriyuk wakrami achka aychata charin.
Sin. Pala.
pataku</p>          </div>', 'ACTIVE', 1, '-'),
       (588, 'patara', '0', 'patara', '<div class="word--description">             <span class="word--fonetic">[patara]</span>              <p class="word--description">s. hoja, página. Killkanka- pak rurashka karallashina.
Kay patarapi killkashpa katinki.
Sin. panka.
patarina</p>          </div>', 'ACTIVE', 1, '-'),
       (589, 'patas', '0', 'patas', '<div class="word--description">             <span class="word--fonetic">[patas]</span>              <p class="word--description">s. amz. cacao blanco. Killu karayuk pukurishpa payllatak urmak, ukupi achka yurak muyukunata charik hatun muru.


Pukushka patasta yunkamanta apamuni.
Sin. Kula, kila.
pati</p>          </div>', 'ACTIVE', 1, '-'),
       (590, 'patpa', '0', 'patpa', '<div class="word--description">             <span class="word--fonetic">[patpa]</span>              <p class="word--description">s. s. pluma. Tukuy pishkuku- napa millma.
Kintipa patpaka wayllami kan.
patpana</p>          </div>', 'ACTIVE', 1, '-'),
       (591, 'patsak', '0', 'patsak', '<div class="word--description">             <span class="word--fonetic">[patsak, patsya, batsak]</span>              <p class="word--description">s. co. baga- zo. Muyukunapa kara.
Wanu tukuchun, wiru patsakta allpapi pam- panki.
patsak</p>          </div>', 'ACTIVE', 1, '-'),
       (592, 'pawana', '0', 'pawana', '<div class="word--description">             <span class="word--fonetic">[pawana, phawana, fawana]</span>              <p class="word--description">v. volar. Imakunapash hawa wayrata puriy.
Uchilla pishkuka mana karuta pawarkachu.
2. brincar. Maykanpash wichayman, uray- man, tukuy manyaman tushukshina tukuy. Ñukapa wawaka patamantami pukllashpa pawarka.
Sin. 1wampuna; 2 tushuna.
pawkar (<*pawkar) s. marzo. Kimsaniki killa.
Pawkar killapi, 21-22 punchaka equinoc- ciomi kan.
pawshi</p>          </div>', 'ACTIVE', 1, '-'),
       (593, 'pay', '0', 'pay', '<div class="word--description">             <span class="word--fonetic">[pay]</span>              <p class="word--description">pron. él, ella. Karullapi tiyak runata
mana shutichishpalla rimay.
Paymi ñukapa kuyashka warmi.
paya</p>          </div>', 'ACTIVE', 1, '-'),
       (594, 'payaku', '0', 'payaku', '<div class="word--description">             <span class="word--fonetic">[payagu]</span>              <p class="word--description">exp. amz. expresión para referirse a la hija apreciada. Kuyashka us- hushita nina shimi.
Payaku, aswata upyachiway.
Sin. Mamaku.
paychi</p>          </div>', 'ACTIVE', 1, '-'),
       (595, 'payku', '0', 'payku', '<div class="word--description">             <span class="word--fonetic">[payku, payko]</span>              <p class="word--description">s. s. yerba medicinal. Mishkilla ashnarik uchilla yura. Yuyayta ka- machik, kuykapak hampi, lukrupi churashpa mishkichina.
Yuyay mirarichun payku yakuta rurashpa up- yanki.
paykuna</p>          </div>', 'ACTIVE', 1, '-'),
       (596, 'paza', '0', 'paza', '<div class="word--description">             <span class="word--fonetic">[paza]</span>              <p class="word--description">adj. áspero, escabroso, tosco.
Ima karakunapash kapulí yurapa karashina kashallalla.
Yapa chiripi, wayrapi paza maki tukushkanki.
Sin. lluru, sakra.
pi</p>          </div>', 'ACTIVE', 1, '-'),
       (597, 'pichana', '0', 'pichana', '<div class="word--description">             <span class="word--fonetic">[fičana, pičana, phičana]</span>              <p class="word--description">s. escoba, borrador. Sunilla sinchi kiwakunata shuk kaspi manyapi watashka. Pampakunata chuyachinkapak rurashka.
Llaktamanta shuk pichanata rantimuni. pichana</p>          </div>', 'ACTIVE', 1, '-'),
       (598, 'pichka', '0', 'pichka', '<div class="word--description">             <span class="word--fonetic">[pička, pičika, piška, piča]</span>              <p class="word--description">num. cinco. Chusku yupayta katik yupay.
Pichka wiralla kuchita charini.
piki</p>          </div>', 'ACTIVE', 1, '-'),
       (599, 'pilis', '0', 'pilis', '<div class="word--description">             <span class="word--fonetic">[pilis, pigli]</span>              <p class="word--description">s. s. piojo blanco. Kuchiku- napi, runakunapipash tiyak usashina yawarta tsunkashpa kawsak.
Kay kuchika pilis huntashpami irkiyashka. pilis</p>          </div>', 'ACTIVE', 1, '-'),
       (600, 'pillchi', '0', 'pillchi', '<div class="word--description">             <span class="word--fonetic">[pilyči, pilči]</span>              <p class="word--description">s. recipiente de la cás- cara del coco. Shuk kuku karamanta chaw- pishka rumpalla rikurik. Yakuta, aswata upyankapak rurashka.
Shuk pillchi aswata karaway.
2. amz. tipo de árbol. Pillchi muyu nishkata aparik yura.
Ankarata rurankapak, yuramanta shuk pill- chi muyuta apamuni.
Sin. 2 kuya.
pilluna</p>          </div>', 'ACTIVE', 1, '-'),
       (601, 'pillpintu', '0', 'pillpintu', '<div class="word--description">             <span class="word--fonetic">[pilypiŋtu, piŋpilyitu, pimpillitu pil- piŋdi]</span>              <p class="word--description">s. mariposa. Tawka tullpuyuk uchilla ri- krayuk pawashpa purik chapul.
Pillpintuka sumak tullpukunatami charin.
Sin. Chapul.
pimpirana</p>          </div>', 'ACTIVE', 1, '-'),
       (602, 'pimpis', '0', 'pimpis', '<div class="word--description">             <span class="word--fonetic">[pimpis, piŋpis]</span>              <p class="word--description">s. amz. aleta de pez. Challwakunapa waytarik uchilla rikrashina tullu.
Challwakunaka pimpiswan utkashpa way- tan.
Sin. Winkanas.
pinchi</p>          </div>', 'ACTIVE', 1, '-'),
       (603, 'pinkala', '0', 'pinkala', '<div class="word--description">             <span class="word--fonetic">[piŋgala]</span>              <p class="word--description">s. amz. mosca grande que no pica. Kurukunata wachak hatun chuspi, mishkikunapi, mikunakunapi, mapa-

Mishki mankapi pinkalaka tiyarishka.
Sin. kurumama.
pinkay</p>          </div>', 'ACTIVE', 1, '-'),
       (604, 'pinkana', '0', 'pinkana', '<div class="word--description">             <span class="word--fonetic">[piŋgana]</span>              <p class="word--description">v. avergonzarse, rubo- rizarse. Runapa ñawi pukayay, llakishina sa- kiriy.
Mana riksishka ayllu kakpi pinkarkani. pinkullu</p>          </div>', 'ACTIVE', 1, '-'),
       (605, 'pinllu', '0', 'pinllu', '<div class="word--description">             <span class="word--fonetic">[piŋlyu, pinžu]</span>              <p class="word--description">s. lechero. Mallkita, pankata pitikpi yurak ñuñushina llukshik yura.
Pinllu yurapi anka tiyakun.
pintu</p>          </div>', 'ACTIVE', 1, '-'),
       (606, 'pintuk', '0', 'pintuk', '<div class="word--description">             <span class="word--fonetic">[piŋtuk, pintu]</span>              <p class="word--description">s. amz. caña brava.
Ashankata, kawituta, wasi chakllatapash ru- rana, waykukunapi wiñak sukusshina hut- kuyuk yura.
Anti suyupika pintukwanmi wasikataka ru- rankuna.
piña</p>          </div>', 'ACTIVE', 1, '-'),
       (607, 'arina', '0', 'arina', '<div class="word--description">             <span class="word--fonetic">[fiñarina, piñarina, phiñarina]</span>              <p class="word--description">v. re- sentirse, enojarse, encapricharse. Rimas- hkamanta, piñashkamanta shunkupi nanariy. Paypa shutita hapishpa llullakpika, payka pi- ñarinmi.
Sin. Impayana, nanakyana.
piñana</p>          </div>', 'ACTIVE', 1, '-'),
       (608, 'pircha', '0', 'pircha', '<div class="word--description">             <span class="word--fonetic">[pirča]</span>              <p class="word--description">s. bo. cardo. Sisapi sinchi kashayuk uchilla yura. Millmakunata ñak- chankapak alli.
Pirchawan llama millmata amukyachini. piripiri</p>          </div>', 'ACTIVE', 1, '-'),
       (609, 'piripiri', '0', 'piripiri', '<div class="word--description">             <span class="word--fonetic">[piripiri]</span>              <p class="word--description">s. amz. ceremonial para la
lluvia y como talismán en la caza y pesca. Sinchi tamyata kayankapak kapariy Tamyankami, ñami piripiri takiyta kaparin. pirka</p>          </div>',
        'ACTIVE', 1, '-'),
       (610, 'piruru', '0', 'piruru', '<div class="word--description">             <span class="word--fonetic">[piruru]</span>              <p class="word--description">s. tortero para hilar, disco. Rumpashina chawpipi hutkuyuk kallana paki. Puchkana siksikpi llashakyachun churana. Puchkana piruruwanmi wawaka pukllakun.
2. sn. trompo. Allpaman shitashpa pukllan- kapak rurashka kushpishina kaspi muyu. Piruruwan haku pukllashun.
piruru</p>          </div>', 'ACTIVE', 1, '-'),
       (611, 'pishi', '0', 'pishi', '<div class="word--description">             <span class="word--fonetic">[piši]</span>              <p class="word--description">adv. poco, escaso. imapash as- halla kak.
Wiwakunamanka pishi kachita kunchik.
Sin. asha.
pishiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (612, 'pishku', '0', 'pishku', '<div class="word--description">             <span class="word--fonetic">[pišku, pisku, piško]</span>              <p class="word--description">s. ave, pájaro. Patpayuk wiwakuna. Wakinka pawak, wa- kinka mana pawakkuna.
Kay pishkupa shutika chawamankumi kan.
Sin. zhuta, munchi.
pishña</p>          </div>', 'ACTIVE', 1, '-'),
       (613, 'pitakaya', '0', 'pitakaya', '<div class="word--description">             <span class="word--fonetic">[pitakaya]</span>              <p class="word--description">s. amz. tipo de fruta. Yurak mishki mikunayuk muyuta aparik kas- hayuk yura.
Wamraka pitakaya muyuta yachana wasi- man aparka.
pitalala</p>          </div>', 'ACTIVE', 1, '-'),
       (614, 'piti', '0', 'piti', '<div class="word--description">             <span class="word--fonetic">[piti]</span>              <p class="word--description">det. Mana achka.
Piti tantatami mikun.
Sin. Asha.
pitirina</p>          </div>', 'ACTIVE', 1, '-'),
       (615, 'pitita', '0', 'pitita', '<div class="word--description">             <span class="word--fonetic">[pitita]</span>              <p class="word--description">s. departamento, alcoba. Wasi ukupi pirkawan, imawanpash rakishka.
Pititapika sumakta puñunchik.
Sin. Killi.
pitina</p>          </div>', 'ACTIVE', 1, '-'),
       (616, 'pitsik', '0', 'pitsik', '<div class="word--description">             <span class="word--fonetic">[pitsik]</span>              <p class="word--description">s. planta silvestre proliferante. Purun yura maypipash mirariklla.
Inchik chakrapi pitsik wiñashka.
pitun</p>          </div>', 'ACTIVE', 1, '-'),
       (617, 'piyan', '0', 'piyan',
        '<div class="word--description">             <span class="word--fonetic">[piyan piyan]</span>              <p class="word--description">s. amz. tipo de pájaro. Muru patpayuk, killu wiksayuk uchilla pishku. Lisan muyuta mikuk, piyan piyan nik. Piyan piyan pishkuka lulunta wachashkami. puchka</p>          </div>',
        'ACTIVE', 1, '-'),
       (618, 'puchkana', '0', 'puchkana', '<div class="word--description">             <span class="word--fonetic">[pučakana, puškana, pučana]</span>              <p class="word--description">v. hilar. Millmata, chawarta, champirata ñañu ankuta awankapak ruray.
Punchuta awankapak llama millmata puch- kakuni.
puchu</p>          </div>', 'ACTIVE', 1, '-'),
       (619, 'puchukay', '0', 'puchukay', '<div class="word--description">             <span class="word--fonetic">[pučukay]</span>              <p class="word--description">adv. último. Imapash washapi, tukuripi sakirik.
Kallpakuymantaka puchukaypi sakirirkanki.
Sin. Chupa.
puchukana</p>          </div>', 'ACTIVE', 1, '-'),
       (620, 'puchul', '0', 'puchul', '<div class="word--description">             <span class="word--fonetic">[pučul, fučul]</span>              <p class="word--description">s. sc. Vainas trilladas luego de sacar los granos. Wayrachishka murukunapa, muyukunapapash kara.
Purutu puchulta ismuchikuni.
puchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (621, 'puka', '0', 'puka', '<div class="word--description">             <span class="word--fonetic">[puka]</span>              <p class="word--description">adj. rojo. Yawarshina rikurik tullpu.
Puka chuntamanta rurashka aswami kan. pukara</p>          </div>', 'ACTIVE', 1, '-'),
       (622, 'shunku', '0', 'shunku', '<div class="word--description">             <span class="word--fonetic">[puka šungo]</span>              <p class="word--description">s. corazón. Tu- kuy runakunapa, wiwakunapa yawarta rakik aycha.


Imamantapash yalli piñarikpika shunkuka nananllami.
Sin. shunku.
pukla</p>          </div>', 'ACTIVE', 1, '-'),
       (623, 'pukllana', '0', 'pukllana', '<div class="word--description">             <span class="word--fonetic">[puglyana, pugžana]</span>              <p class="word--description">v. jugar.
Imata rurashpapash kushiyay. Wawakunaka rumpawan pukllan. Sin. Chunkana.
pukru</p>          </div>', 'ACTIVE', 1, '-'),
       (624, 'pukshi', '0', 'pukshi', '<div class="word--description">             <span class="word--fonetic">[puxši]</span>              <p class="word--description">s. ss. cal. Yurak ñutu kutas- hina allpa, wasi pirkata yurakyachina.
Wasita tullpunkapak pukshita rantina kan- chik.
Sin. Isku.
puku</p>          </div>', 'ACTIVE', 1, '-'),
       (625, 'pukuna', '0', 'pukuna', '<div class="word--description">             <span class="word--fonetic">[pukuna, phukuna]</span>              <p class="word--description">s. bodoquera. Chuntata, kuyata aspishpa rurashka suni kaspi. Pishkukunata, wiwakunata wañuchin- kapak alli.
Sachaman rishpaka pukunata apanki. pukuna</p>          </div>', 'ACTIVE', 1, '-'),
       (626, 'pukuy', '0', 'pukuy', '<div class="word--description">             <span class="word--fonetic">[phukuy]</span>              <p class="word--description">s. soplo de curación. Un- kuyta kallpachiy, llukshichiy.
Mancharishka unkuy anchurichun pukuyku- nata rurarkani.
pukuna</p>          </div>', 'ACTIVE', 1, '-'),
       (627, 'pukyu', '0', 'pukyu', '<div class="word--description">             <span class="word--fonetic">[pukyu]</span>              <p class="word--description">s. vertiente, pozo, manantial.
Allpa ukumanta yaku llukshirik.
Chachimbiru llaktapika kunuk yaku pukyumi tiyan.
pulak</p>          </div>', 'ACTIVE', 1, '-'),
       (628, 'pulanti', '0', 'pulanti', '<div class="word--description">             <span class="word--fonetic">[bulandi]</span>              <p class="word--description">s. amz. variedad de be- juco. Taruka ñawi nishka muyuta aparik anku, shuk llaktakunapika kalatis anku nis- hka.
Pulanti muyuwanka wallkakunatami ruran- chik.
Sin. kalatis
pullu</p>          </div>', 'ACTIVE', 1, '-'),
       (629, 'pullukuku', '0', 'pullukuku', '<div class="word--description">             <span class="word--fonetic">[bulyukuku]</span>              <p class="word--description">s. amz. variedad de lechuza. Uchilla muru patpayuk, tutalla purik, puka ñawiyuk pishku.
Pullukukuka tutami pawashpa purin. puluna</p>          </div>', 'ACTIVE', 1, '-'),
       (630, 'puma', '0', 'puma', '<div class="word--description">             <span class="word--fonetic">[puma]</span>              <p class="word--description">s. amz. Tigre, puma. Hatun misishina rikurik, muru millmayuk, yurapi, hutkukunapi puñuk, aychallata mikuk sacha wiwa.
Sacha pumakunataka mana wañuchinachu kanchik.
puna</p>          </div>', 'ACTIVE', 1, '-'),
       (631, 'suyu', '0', 'suyu', '<div class="word--description">             <span class="word--fonetic">[puna suyu]</span>              <p class="word--description">s. región de la sie- rra. Urkukunayuk chirisapa llakta.
Puna suyupika chiri chirimi kan, shinapash achka kichwa runami kawsan.
Sin. sallka suyu.
puncha</p>          </div>', 'ACTIVE', 1, '-'),
       (632, 'punchana', '0', 'punchana', '<div class="word--description">             <span class="word--fonetic">[puŋžana, puŋčana]</span>              <p class="word--description">s. guatusa. Kuyshina umayuk, puka rinriyuk, yana mill- mayuk, lumuta chakrapi mikuk sacha wiwa. Punchana aychaka sumak mishkimi kan.
Sin. Siku.
punchantin</p>          </div>', 'ACTIVE', 1, '-'),
       (633, 'punkara', '0', 'punkara', '<div class="word--description">             <span class="word--fonetic">[puŋgara]</span>              <p class="word--description">s. amz. tipo de fruta.
Killu wikiyuk mishki mikuna muyu.
Punkara yura wikita sinchiyachishka.
2. petróleo. Allpa mamapi tiyak yana wira. Punkaraka tukuy runakunapakmi kan. Sin. 1 Kuytansiw; 2 allpawira.
punkina</p>          </div>', 'ACTIVE', 1, '-'),
       (634, 'punku', '0', 'punku', '<div class="word--description">             <span class="word--fonetic">[punku, puŋgu]</span>              <p class="word--description">s. puerta, entrada. Wasi ukuta wichkankapak rurashka.
Wasi punkuta wichkay.
punsa</p>          </div>', 'ACTIVE', 1, '-'),
       (635, 'puntu', '0', 'puntu', '<div class="word--description">             <span class="word--fonetic">[fuŋdu]</span>              <p class="word--description">s. s. vasija, pondo. Ñañu siki- yuk manka. Yakuta apankapak rurashka.
¿Puntupi aswata ña churankichu?. puntulunku</p>          </div>', 'ACTIVE', 1, '-'),
       (636, 'punzu', '0', 'punzu', '<div class="word--description">             <span class="word--fonetic">[puŋzu, puŋtsu, phuŋtsu]</span>              <p class="word--description">s. s. resíduo de hierba o paja que dejan los animales luego de alimentarse. Ima kiwakunapash wi- wakuna mikushka kipa tamushina sakirik.
Wakra mikushka puchu punzuta rupachini.
2.	adj. enredado. Patanyashka llama mill- mashina kak.
Sachamanta punzu kiwata tantamuni.
3.	s. amz. viruta. Kaspita aspikpi llukshik ñutu hamchikuna.
Punzuta llukshichinkapak kaspita llakllarkani.

punzuyana</p>          </div>', 'ACTIVE', 1, '-'),
       (637, 'u', '0', 'u', '<div class="word--description">             <span class="word--fonetic">[puñu, puyñu]</span>              <p class="word--description">s. s. cántaro de una
oreja; pondo. Turu allpamanta rurashka shuk rinriyuk manka.
Apita yanunkapak puñu mankata rantini. puñuna</p>          </div>', 'ACTIVE', 1, '-'),
       (638, 'pupu', '0', 'pupu', '<div class="word--description">             <span class="word--fonetic">[pupu]</span>              <p class="word--description">s. ombligo. Wacharishka an- kuta pitishka wiksapi tiyak hutku.


llakta runa tantarikunata ñawpachik.
Alli pushak runata charinchik.
Sin. Kuraka, apu.



Pupupi ama wayra shitachun kushmawan katariy.
purina</p>          </div>', 'ACTIVE', 1, '-'),
       (639, 'puru', '0', 'puru', '<div class="word--description">             <span class="word--fonetic">[puru]</span>              <p class="word--description">s. tutuma. Pillchishina ukupi chushakyuk.
¿Puruwan takinata ushankichu?
2. amz. objetos pequeños de barro. Turu all- pamanta rurashka uchilla mankakuna, wallu- kuna.
Purupi yakuta apakuni.
purun</p>          </div>', 'ACTIVE', 1, '-'),
       (640, 'purun', '0', 'purun', '<div class="word--description">             <span class="word--fonetic">[purun, purum]</span>              <p class="word--description">sc. planta silvestre.
Hicharishka muyukunamanta wiñak yura. Kuykunaka purun kiwatapash mikunllami. Sin. chas, wala, ushun.
purun (<**purun) s. julio. Kanchisniki killa.
Purun killapipash wakin llaktakunapika inti raymita tushun.
purutu</p>          </div>', 'ACTIVE', 1, '-'),
       (641, 'pusak', '0', 'pusak', '<div class="word--description">             <span class="word--fonetic">[pusax, pusak, pusag, pusa, pusux, pusuk, pusug, pusu]</span>              <p class="word--description">num. ocho. Kanchis yu- payta katik yupay.
Pusak watayuk wawata charini.
pusayu</p>          </div>', 'ACTIVE', 1, '-'),
       (642, 'pushak', '0', 'pushak', '<div class="word--description">             <span class="word--fonetic">[pušax, pušak, pušag, puša]</span>              <p class="word--description">s. di- rigente, líder, presidente, gobernante. Ayllu-

pushana</p>          </div>', 'ACTIVE', 1, '-'),
       (643, 'pushinshi', '0', 'pushinshi', '<div class="word--description">             <span class="word--fonetic">[pušiŋši]</span>              <p class="word--description">s. amz. hormiga conga. Shuk yana, uchilla, yuturishina sikipi tuksinayuk añanku.
Pushinshika sinchitami tuksiyta yachan. pushllu</p>          </div>', 'ACTIVE', 1, '-'),
       (644, 'pusku', '0', 'pusku', '<div class="word--description">             <span class="word--fonetic">[pusku, putsuxu]</span>              <p class="word--description">s. espuma; fer- mento, levadura. Yaku timpurishpa yurak si- sashina tukushka.
Yaku puskuwan pukllani.
puskuna</p>          </div>', 'ACTIVE', 1, '-'),
       (645, 'puskuyana', '0', 'puskuyana', '<div class="word--description">             <span class="word--fonetic">[puskuyana]</span>              <p class="word--description">v. agriarse, ha- cerse agrio. Yanushka mikunata achka pa- chakunata sakikpi hayakyay.
Atallpawan yanushka mikunaka puskuyarka. pusun</p>          </div>', 'ACTIVE', 1, '-'),
       (646, 'chuspi', '0', 'chuspi', '<div class="word--description">             <span class="word--fonetic">[putan čuspi]</span>              <p class="word--description">s. abeja. Mis- hkita kuk chuspi.
Putan chuspika sisakunata mishkita maska- kun.
Sin. Mishki chuspi, chullumpi.
putasyana</p>          </div>', 'ACTIVE', 1, '-'),
       (647, 'putsa', '0', 'putsa', '<div class="word--description">             <span class="word--fonetic">[phutsa]</span>              <p class="word--description">s. sc. racimo pequeño. Uchi-



lla watushina, luntsashina.
Kapuli putsata paktashpa kupay.
2. bo. nido mal formado. Yanka rurashka pis- hku kisha.
Urpika putsapi lulunta churashka.
Sin. 1 Luntsa, 2 kisha.
putsu</p>          </div>', 'ACTIVE', 1, '-'),
       (648, 'putu', '0', 'putu', '<div class="word--description">             <span class="word--fonetic">[putu]</span>              <p class="word--description">adj. snc, mocho. Kutushina. Chay allkuka putu chupayuk kashka.
2. s. sn. tronco. Kuchushka yurakunamanta llukshik kullu.
Pututa apamupay.
putu</p>          </div>', 'ACTIVE', 1, '-'),
       (649, 'putukulu', '0', 'putukulu', '<div class="word--description">             <span class="word--fonetic">[putukulu]</span>              <p class="word--description">s. amz. renacuajo. Llu- llu wawa hampatu.
Putukulukunaka chinkarikunmi.


Sin. willi willi.
puy</p>          </div>', 'ACTIVE', 1, '-'),
       (650, 'puyu', '0', 'puyu', '<div class="word--description">             <span class="word--fonetic">[puyu, phuyu, fuyu]</span>              <p class="word--description">s. nube, niebla, ne- blina. Hawa pachapi yurak, yana, puka kus- hnishina tiyak.
Puyu punchapi ñanta pantarini.
puzu</p>          </div>', 'ACTIVE', 1, '-'),
       (651, 'puzun', '0', 'puzun', '<div class="word--description">             <span class="word--fonetic">[pusun, puzun, buzun, uspun]</span>              <p class="word--description">s. panza. Runa wiksapi, wiwa wiksakunapi tiyak mikushka tantarina hatun chunchulli.
Wakra puzunta yanunkapak rantiklla rini.
Sin. uspun.



























raka</p>          </div>', 'ACTIVE', 1, '-'),
       (652, 'rakiy', '0', 'rakiy', '<div class="word--description">             <span class="word--fonetic">[rakiy, řakiy]</span>              <p class="word--description">s. división, parte, pedazo.
Imatapash chay tupullapi chawpina.
Yayapa chunka waranka kullkitaka pich- kantinmi rakiyta ruranchik.
rakina</p>          </div>', 'ACTIVE', 1, '-'),
       (653, 'rakrayana', '0', 'rakrayana', '<div class="word--description">             <span class="word--fonetic">[řagrayana]</span>              <p class="word--description">v. resquebrajarse, agrietarse. Ima sinchikunapash yantashina chiktariy, chillpiriy.
Allpa kuyuymanta wasi pirkaka rakrayarka.
Sin. chiktay.
raku</p>          </div>', 'ACTIVE', 1, '-'),
       (654, 'rakuyana', '0', 'rakuyana', '<div class="word--description">             <span class="word--fonetic">[rakuyana]</span>              <p class="word--description">v. engrosarse. Ima- pash hatunlla tukuy.
Papaka ñami rakuyakun.
ransiw</p>          </div>', 'ACTIVE', 1, '-'),
       (655, 'ranti', '0', 'ranti', '<div class="word--description">             <span class="word--fonetic">[randi, řandi]</span>              <p class="word--description">adv. a cambio de, reci- procidad. Shukmanta shuktak ruray, shuktak yanapay.
Tushuymanka yayapa ranti churimi rirka. rantimpa</p>          </div>', 'ACTIVE', 1, '-'),
       (656, 'rantina', '0', 'rantina', '<div class="word--description">             <span class="word--fonetic">[řandina, randina]</span>              <p class="word--description">v. comprar, inter- cambiar Imatapash kullkita kushpa hapina. Otavalo llaktapi kay ruwanata rantimuni.
Sin. mintalana.
rapyana</p>          </div>', 'ACTIVE', 1, '-'),
       (657, 'rasu', '0', 'rasu', '<div class="word--description">             <span class="word--fonetic">[řasu, rasu]</span>              <p class="word--description">s. nieve, hielo.  Rumishina chiriwan sinchiyashka yaku.
Rasuwan chakrushka yakuka chirikllami kan.
Sin. riti.
rasuna</p>          </div>', 'ACTIVE', 1, '-'),
       (658, 'rawa', '0', 'rawa', '<div class="word--description">             <span class="word--fonetic">[řawa]</span>              <p class="word--description">v. sc. surco. Allpapi larkashina
kak.
Rawapika sarata tarpunchik.
Sin. wachu.
rawana</p>          </div>', 'ACTIVE', 1, '-'),
       (659, 'rawchana', '0', 'rawchana', '<div class="word--description">             <span class="word--fonetic">[řawčana]</span>              <p class="word--description">v. desramar. Mallki-
kunata mukupi pitina.
Kapuli yurapa mallkikunata rawchankichik.
2. tu. deshojar. Pankakunata anchuchiy. Wirunkapak nishpami sarata rawchani. Sin. 1-2 Rawmana, chillpina.
rawmana</p>          </div>', 'ACTIVE', 1, '-'),
       (660, 'rawrana', '0', 'rawrana', '<div class="word--description">             <span class="word--fonetic">[řawrana,  rawrana,  lawrana]</span>              <p class="word--description">v.
119

RAYMI
arder. Imapipash ninata churakpi rupay. Rupay unkuywan tukuy aycha rupariy.
Uksha wasipi ninata churakpimi rawrakun. raymi</p>          </div>', 'ACTIVE', 1, '-'),
       (661, 'rikchak', '0', 'rikchak', '<div class="word--description">             <span class="word--fonetic">[řixčak, řigčak]</span>              <p class="word--description">adj. idéntico, igual,
semejanza. Imakunapash chayshina pakta, pakta rikurik.
Churika yayashina rikchakmi kashka.
2. fotografía, retrato, imagen figura. Runa- kunapa shukkunapash kikinshinata pankapi shuyushka llukchirishka.
Kay rikchakka ñukapa yayashinami kan. rikcharina</p>          </div>', 'ACTIVE', 1, '-'),
       (662, 'rikchana', '0', 'rikchana', '<div class="word--description">             <span class="word--fonetic">[řixčana,  řigčana]</span>              <p class="word--description">v.  parecerse, asemejarse. Imapash chayshinallatak rikuriy. Ñukapa panika hatun mamaman rikchan.
2. s. imitar. Imatapash chayllatatak katishpa ruray.
Yachachik mana alli rimashkata wawakuna
rikchan.
Sin. 2 katina.
rikra</p>          </div>', 'ACTIVE', 1, '-'),
       (663, 'riksina', '0', 'riksina', '<div class="word--description">             <span class="word--fonetic">[řixsina, řiksina, rigsina]</span>              <p class="word--description">v. conocer. Rikushpa, uyashpa, hapishpa, mallishpa umapi hapiy, yachay.
Chikan runata riksini.
rikuchina</p>          </div>', 'ACTIVE', 1, '-'),
       (664, 'rikurina', '0', 'rikurina', '<div class="word--description">             <span class="word--fonetic">[řikurina]</span>              <p class="word--description">v. asomarse, aparecerse, presentarse. Imakunapash maymantapash llukshiy.
Mashika chakra ukumanta ñapash rikurin. rikuna</p>          </div>', 'ACTIVE', 1, '-'),
       (665, 'rimanakuna', '0', 'rimanakuna', '<div class="word--description">             <span class="word--fonetic">[řimanakuna]</span>              <p class="word--description">v.  dialogar. Ñawi ñawi rimay.
Tantanakuypika yuyashpalla rimanakunchik. rimana</p>          </div>', 'ACTIVE', 1, '-'),
       (666, 'rimay', '0', 'rimay', '<div class="word--description">             <span class="word--fonetic">[řimay, rimay]</span>              <p class="word--description">s. palabra, expresión.
Ima shimipash kak.
Wawaka asha rimayta nikun.
Sin. shimi.
rimsi (<**rimsi) s. mercurio, el planeta. Inti- man kuchulla sakirik rumpu.
rinri</p>          </div>', 'ACTIVE', 1, '-'),
       (667, 'rinriwarkuna', '0', 'rinriwarkuna', '<div class="word--description">             <span class="word--fonetic">[rinriwarkuna]</span>              <p class="word--description">s. aretes, zar- cillos. rinripi warkuska ima.
Saraguro warmika sumak rinriwarkunata rikuchin.
rirpu</p>          </div>', 'ACTIVE', 1, '-'),
       (668, 'riti', '0', 'riti', '<div class="word--description">             <span class="word--fonetic">[riti]</span>              <p class="word--description">s. nieve, hielo. Rumishina chiriwan sinchiyashka yaku.
Ritiwan chakrushka yakuka chirikllami kan.
Sin. rasu.
riti</p>          </div>', 'ACTIVE', 1, '-'),
       (669, 'rina', '0', 'rina', '<div class="word--description">             <span class="word--fonetic">[řina, rina]</span>              <p class="word--description">v. ir, viajar. Shuk llaktamanta shukman purishpa, pawashpa imashinapash anchuriy.
Ñukapa llaktamanta rini.
ruku</p>          </div>', 'ACTIVE', 1, '-'),
       (670, 'rumi', '0', 'rumi', '<div class="word--description">             <span class="word--fonetic">[řumi, rumi]</span>              <p class="word--description">s. piedra, roca. Yapa sin- chi kurpa tika.
Hatun rumipi takarishpa wampu tikrarka.
rumikuta</p>          </div>', 'ACTIVE', 1, '-'),
       (671, 'rumiyana', '0', 'rumiyana', '<div class="word--description">             <span class="word--fonetic">[rumiyana]</span>              <p class="word--description">v. petrificarse. Ima- pash sinchitukuy.
Kay shitashka allpaka sinchita rumiyashka. rumpa</p>          </div>', 'ACTIVE', 1, '-'),
       (672, 'runa', '0', 'runa', '<div class="word--description">             <span class="word--fonetic">[řuna, runa]</span>              <p class="word--description">s. ser humano; persona.
Kari kashpa, warmi kashpapash tukuy yu- yayyuk shimiwan rimak.
Tukuy runapurami tantanakushpa kawsana kanchik.
runakay</p>          </div>', 'ACTIVE', 1, '-'),
       (673, 'runtu', '0', 'runtu', '<div class="word--description">             <span class="word--fonetic">[řuŋdu, ruŋdu]</span>              <p class="word--description">s. granizo. Yana puyu-
manta yakumi rasu muru tukushpa urmak. Runtu urmakpi tukuy pampa yuraklla saqui- rirka.
runtuna</p>          </div>', 'ACTIVE', 1, '-'),
       (674, 'rupachina', '0', 'rupachina', '<div class="word--description">             <span class="word--fonetic">[řupačina, rupačina]</span>              <p class="word--description">v. quemar, incendiar. Imatapash ninawan hapichiy.
Sacha yurakunataka ama rupachinkichu. ruparina</p>          </div>', 'ACTIVE', 1, '-'),
       (675, 'rupay', '0', 'rupay', '<div class="word--description">             <span class="word--fonetic">[řupay, rupay]</span>              <p class="word--description">s. calor. Imakuna kash- papash sinchita kunuk.
Kunanka sinchi rupaymi kan.
2. calentura. Rupay unkuy.
Rupay unkuywanmi kani.
rurana</p>          </div>', 'ACTIVE', 1, '-'),
       (676, 'ruru', '0', 'ruru', '<div class="word--description">             <span class="word--fonetic">[ruru]</span>              <p class="word--description">s. pepa, semilla. Imapash muyus-
hina. Palltaka hatun ruruta charin.
rutuna</p>          </div>', 'ACTIVE', 1, '-'),
       (677, 'ruwana', '0', 'ruwana', '<div class="word--description">             <span class="word--fonetic">[ruwana, ruana]</span>              <p class="word--description">s. tipo de poncho. Awashka churakuna. Ruwanaka mushukmi kan.





















sacha</p>          </div>', 'ACTIVE', 1, '-'),
       (678, 'sacha', '0', 'sacha', '<div class="word--description">             <span class="word--fonetic">[sača]</span>              <p class="word--description">adj. salvaje; silvestre; medio-
cre. Imatapash mana rikuk, mana riksik; mana alli yachak; manchaysiki wiwa.
Uturunkuka sacha wiwami kan.
Sin. Aya.
sacharuna</p>          </div>', 'ACTIVE', 1, '-'),
       (679, 'sachawakra', '0', 'sachawakra', '<div class="word--description">             <span class="word--fonetic">[sačawagra, sačawakra]</span>              <p class="word--description">s. danta. Kachu illak, suni sinkayuk, kurulla chu- payuk, sachapi kawsak wakrashina hatun wiwa.
Anti suyupika sachawakratami yallika mi- kunkuna.
sakina</p>          </div>', 'ACTIVE', 1, '-'),
       (680, 'saklana', '0', 'saklana', '<div class="word--description">             <span class="word--fonetic">[saglana, saklana]</span>              <p class="word--description">v. deshojar el maíz. Sara pankakunata chukllumanta an- chuchina.
Chukllu wiruta kuchikunaman saklanchik.
Sin. Pitina.
sakra</p>          </div>', 'ACTIVE', 1, '-'),
       (681, 'sakra', '0', 'sakra', '<div class="word--description">             <span class="word--fonetic">[sagra, šagra, tsagra]</span>              <p class="word--description">s. amz. brujo, curandero. Imatapash hawalla usharik ham- pik runa. Ayawaskata, sayrita, wakinpika ki- wakunatapash upyashpa rikuk.
Sakra runaka yurakunawan unkushkata hampikun.

Sin. Paku, salamanka, yachak.
saksana</p>          </div>', 'ACTIVE', 1, '-'),
       (682, 'salamanka', '0', 'salamanka', '<div class="word--description">             <span class="word--fonetic">[salamaŋga, tsalaŋga]</span>              <p class="word--description">s. brujo.
Imakunawampash hawalla hampinata ya- chak runa.
Shuk salamanka runaka alli hampikmi kan.
Sin. Sakra, yachak, paku.
salinana</p>          </div>', 'ACTIVE', 1, '-'),
       (683, 'sallka', '0', 'sallka', '<div class="word--description">             <span class="word--fonetic">[salyka, salka]</span>              <p class="word--description">s. sierra, páramo. Chi- rilla urkuman sakirik suyu.
Sallkamantami kanchik.
Sin. puna.
sallka runa</p>          </div>', 'ACTIVE', 1, '-'),
       (684, 'samarina', '0', 'samarina', '<div class="word--description">             <span class="word--fonetic">[samarina]</span>              <p class="word--description">v. calmarse, cesarse.
Imakunapash chinkarina, tukurina, upayana.
¿Kanpa nanayka samarinchu?.
Sin. Tukurina.
samay</p>          </div>', 'ACTIVE', 1, '-'),
       (685, 'samana', '0', 'samana', '<div class="word--description">             <span class="word--fonetic">[samana]</span>              <p class="word--description">v. descansar. Sampa- yashpa, shaykushpa rurakushkata sakina.
¿Achka llamkay kipaka samankichikchu?
sami</p>          </div>', 'ACTIVE', 1, '-'),
       (686, 'sami', '0', 'sami', '<div class="word--description">             <span class="word--fonetic">[-sami]</span>              <p class="word--description">comp. Clase, variedad. Kayka
chayshina rikurikmi kan nishpa rimay.
Kaysami sisakunami tiyan. Sin. Ñirak, shina.
sampa</p>          </div>', 'ACTIVE', 1, '-'),
       (687, 'sampayana', '0', 'sampayana', '<div class="word--description">             <span class="word--fonetic">[sambayana, saŋbayana]</span>              <p class="word--description">v. amz. cansarse, fatigarse, agotarse. Imata- pash achkata llamkashpa shaykuriy.
Kayna tukuy puncha tarpushpami achkata
sampayarkani.
Sin. Shaykuna.
sampi</p>          </div>', 'ACTIVE', 1, '-'),
       (688, 'sampu', '0', 'sampu', '<div class="word--description">             <span class="word--fonetic">[sampu, zambu, zaŋbu]</span>              <p class="word--description">s. s. sambo, mate, calabaza. Waylla karayuk suni sapa- llushina mikuna muyu.
Waylla samputa turiman kararkani.
san</p>          </div>', 'ACTIVE', 1, '-'),
       (689, 'sanku', '0', 'sanku', '<div class="word--description">             <span class="word--fonetic">[saŋgu]</span>              <p class="word--description">adj. turbio. Uki yaku, mana
chuyaklla.
Sanku aswata upyankapak munani.
2. adj. espeso. Imapash apishina. Mishki mikuyka achka sankumi karka. Sin. 1 Lanta, 2 tikti.
sañi</p>          </div>', 'ACTIVE', 1, '-'),
       (690, 'u', '0', 'u', '<div class="word--description">             <span class="word--fonetic">[sañu]</span>              <p class="word--description">s. teja . Turu allpawan rurashka

Sañuwan rurashka wasika sumakmi rikurin. sapalla</p>          </div>', 'ACTIVE', 1, '-'),
       (691, 'sapallu', '0', 'sapallu', '<div class="word--description">             <span class="word--fonetic">[sapalyu, sapažu]</span>              <p class="word--description">s. sapallo. Pan-
kasapa ankuyashpa wiñak yura, shuk hatun rumpashina killu mikunayuk muyu.
Chamuk mikunataka sapalluwanmi yanun- chik.
sapan</p>          </div>', 'ACTIVE', 1, '-'),
       (692, 'sapi', '0', 'sapi', '<div class="word--description">             <span class="word--fonetic">[sapi]</span>              <p class="word--description">s. raíz; origen, cimiento, principio. Yurakunapi anku wiñay kallari kuska.
Allpapi tarpunkapak yurapa sapikunata surkukunchik.
Sin. Anku.
sapiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (693, 'sara', '0', 'sara', '<div class="word--description">             <span class="word--fonetic">[sara]</span>              <p class="word--description">s. maíz. Hatunlla suni yura, suni
pankayuk, wiruyuk, kutul ukupi wiñak muru. Minkakunamanka sara kamcha kukayu- wanmi rinchik.
sara panka</p>          </div>', 'ACTIVE', 1, '-'),
       (694, 'sarpa', '0', 'sarpa', '<div class="word--description">             <span class="word--fonetic">[sarpa]</span>              <p class="word--description">s. rocío, escarcha. Tutamanta shuk tamyashina urmak.
Sarpa kiwata mikushpa wiwakunaka wiksa punkishpa wañunkuna.
Sin. shulla.
sarpana</p>          </div>', 'ACTIVE', 1, '-'),
       (695, 'sarun', '0', 'sarun', '<div class="word--description">             <span class="word--fonetic">[saruŋ]</span>              <p class="word--description">adv. pasado, antes, hace



SARUSHKA
tiempo. Yallishka pachakunata nina shimi. Sarun pachapika kaypi mikuk karkanchik. Sin. ñawpa.
sarushka</p>          </div>', 'ACTIVE', 1, '-'),
       (696, 'saruna', '0', 'saruna', '<div class="word--description">             <span class="word--fonetic">[saruna]</span>              <p class="word--description">v. pisar, atropellar. Imata- pash, imawanpash allpapi llapichiy.
Aya kiwakunataka hutkupi shitashpa sarun- chik.
Sin. Haytana.
sasi</p>          </div>', 'ACTIVE', 1, '-'),
       (697, 'sasina', '0', 'sasina', '<div class="word--description">             <span class="word--fonetic">[sasina]</span>              <p class="word--description">v. ayunar. Imatapash mana mikushpalla yalliy.
Kunan punchallami sasikuni.
satina</p>          </div>', 'ACTIVE', 1, '-'),
       (698, 'warmi', '0', 'warmi', '<div class="word--description">             <span class="word--fonetic">[sawarinalya warmi]</span>              <p class="word--description">s. novia. Karipa warmi tukuna kuytsa. Raymipika sawarinalla warmiwan tushur- kani.
sawarina</p>          </div>', 'ACTIVE', 1, '-'),
       (699, 'sawna', '0', 'sawna', '<div class="word--description">             <span class="word--fonetic">[sawna]</span>              <p class="word--description">s. cabecera, almohada. Ka- witupi puñunkapak umata kimichina kipi.
Sawnata umapi churankapak mañachipay. sawnana</p>          </div>', 'ACTIVE', 1, '-'),
       (700, 'sayri', '0', 'sayri', '<div class="word--description">             <span class="word--fonetic">[sayri, šayri]</span>              <p class="word--description">s. tabaco, cigarrillo. As-
hnak ñutu kiwata pankapi pilluchishka tsun- kankapak rurashka.
Wakin	runakunaka	chirimanta	sayrita kunukyankapak tsunkan.
sayrina</p>          </div>', 'ACTIVE', 1, '-'),
       (701, 'sayti', '0', 'sayti', '<div class="word--description">             <span class="word--fonetic">[sayti, siti]</span>              <p class="word--description">s. muñeca, muñeco. Imata- pash wawashinata rurashpa pukllana.
Wawaka saytikunawanmi pukllan.
Sin. llullawawa.
saywa</p>          </div>', 'ACTIVE', 1, '-'),
       (702, 'saywana', '0', 'saywana', '<div class="word--description">             <span class="word--fonetic">[saywana]</span>              <p class="word--description">v. limitar, poner lindero o mojón. Harkayta churay.
Ñawpa pachamanta allpa manyapika say- wankuna.
sichi</p>          </div>', 'ACTIVE', 1, '-'),
       (703, 'sikana', '0', 'sikana', '<div class="word--description">             <span class="word--fonetic">[sikana]</span>              <p class="word--description">v. montar, subir, ascender. Hawaman wichiyay.
Kapulita hapinkapakka yurapimi sikanchik.
Sin. Wichiyana.
siki</p>          </div>', 'ACTIVE', 1, '-'),
       (704, 'siksik', '0', 'siksik', '<div class="word--description">             <span class="word--fonetic">[sixsix, sixsi, sigsix, sigsi]</span>              <p class="word--description">s. s. paja
gruesa de hojas ásperas. Ukshashina, ak- chashinata charik yura.
Wasita katankapakmi siksikta pitinchik. siku</p>          </div>', 'ACTIVE', 1, '-'),
       (705, 'sillu', '0', 'sillu', '<div class="word--description">             <span class="word--fonetic">[silyu, sižu]</span>              <p class="word--description">s. uña, casco, pezuña. Tul- lushina, maki, chaki rukakunapi llukshik.
Ñukapa	chakitaka	wakra	sillumi chukrichirka.
simpa</p>          </div>', 'ACTIVE', 1, '-'),
       (706, 'simpana', '0', 'simpana', '<div class="word--description">             <span class="word--fonetic">[simpana, čimbana]</span>              <p class="word--description">v. trenzar.




Akchakunata, puchkakunata kimsa wankupi rakishpa, kawpushkashina ruray.


Ñawita ñalla ñalla, wichkay.
Payta kayankapakmi ñawita sipuni.

SUCHU

Imbaya, Cañar runakunapash akchataka ñakchashpami simpan.
sinchi</p>          </div>', 'ACTIVE', 1, '-'),
       (707, 'sinik', '0', 'sinik', '<div class="word--description">             <span class="word--fonetic">[sinix]</span>              <p class="word--description">s. pa. variedad de raposa. Atall- pata maskashpa tuta purik ashnak aychayuk wiwa.
Sinik wiwaka ishkay atallpatami mikushka.
Sin. Chakka, chucha.
sinka</p>          </div>', 'ACTIVE', 1, '-'),
       (708, 'sinkuna', '0', 'sinkuna', '<div class="word--description">             <span class="word--fonetic">[siŋguna]</span>              <p class="word--description">v. revolcarse, rodar. Ur-
mashpa kushpariy.
Wawakunaka uray muya pampapi sinkun. Sin. Kawirina.
sipichi</p>          </div>', 'ACTIVE', 1, '-'),
       (709, 'sipina', '0', 'sipina', '<div class="word--description">             <span class="word--fonetic">[sipina]</span>              <p class="word--description">v. ajustar, estrangular, ahor-
car. Imakunatapash kunkapi sinchita watas- hpa, llapishpapash wañuchiy.
Wakin llaktakunapika wallinkuta wañuchinka- pakka sipinkunami.
sipri</p>          </div>', 'ACTIVE', 1, '-'),
       (710, 'sipu', '0', 'sipu', '<div class="word--description">             <span class="word--fonetic">[sipu, tsipu]</span>              <p class="word--description">s. arruga. Imapash mana chutalla kak.
Hatuku yayaka achka siputami charin. sipuru</p>          </div>', 'ACTIVE', 1, '-'),
       (711, 'sipuna', '0', 'sipuna', '<div class="word--description">             <span class="word--fonetic">[sipuna, tsipuna]</span>              <p class="word--description">v. pestañar, guiñar.

2. fruncir, arrugar. Ñawi lulun karata wichkay. Kay wawa piñarishpaka sinchimi ñawita sipun.
sirana</p>          </div>', 'ACTIVE', 1, '-'),
       (712, 'sirichiy', '0', 'sirichiy', '<div class="word--description">             <span class="word--fonetic">[siričiy]</span>              <p class="word--description">s. ceremonia nupcial. Sawarishkakunata kari warmiwan chankachishpa puñuchiy.
Sawarikpika sirichiyta rurashpami achka mashikuna kushiyashpa upyan.
siririna</p>          </div>', 'ACTIVE', 1, '-'),
       (713, 'aspi', '0', 'aspi', '<div class="word--description">             <span class="word--fonetic">[sirik aspi]</span>              <p class="word--description">s. línea horizontal. Kin- ray wachushina sunilla rikurik.
Pankapi shuk sirik aspita shuyuy.
sisa</p>          </div>', 'ACTIVE', 1, '-'),
       (714, 'pacha', '0', 'pacha', '<div class="word--description">             <span class="word--fonetic">[sisa pača]</span>              <p class="word--description">s. primavera.Yura-
kuna sisana pacha.
Sisa pachapi purinaka sumakmi kan.
sisa pampa</p>          </div>', 'ACTIVE', 1, '-'),
       (715, 'sisu', '0', 'sisu', '<div class="word--description">             <span class="word--fonetic">[sisu]</span>              <p class="word--description">s. hongos de la piel. Aycha karata
wakllichik kallampa unkuy.
Kallampa unkuy hapikpimi sisu chaki tukus- hkani.
2.	bo. ronchas. Chuspikuna kanikpi aychapi chupushina llukshik.
Chakipi chuspi kanikpi sisu tukushpa purin.
3.	im. enfermedad de un ser mítico. Runa- kuna yuyaypi, ayamanta shamuk aychata chupuyachik unkuy.
Paypa makipika ayami sisuta churashka. suchu</p>          </div>', 'ACTIVE', 1, '-'),
       (716, 'suchuchina', '0', 'suchuchina', '<div class="word--description">             <span class="word--fonetic">[sučučina]</span>              <p class="word--description">v. retirar, apartar. Chaymanta anchuchishpa shukman churay. Kay rumikunata achka llashak kashkamanta wayka tukushpami suchuchinchik.
Sin. Anchuchina.
suchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (717, 'suksu', '0', 'suksu', '<div class="word--description">             <span class="word--fonetic">[suxsu, sugsu, tsuxtsu]</span>              <p class="word--description">s. mirlo. Killu chakiyuk, killu tapsayuk, yana patpayuk pis- hku.
Suksu pishkutaka kuyashpami charina kan- chik.
sukta</p>          </div>', 'ACTIVE', 1, '-'),
       (718, 'sukus', '0', 'sukus', '<div class="word--description">             <span class="word--fonetic">[sukus]</span>              <p class="word--description">s. carrizo. Ashankata, kawi-
tuta, wasi chakllatapash rurana, waykuku- napi wiñak pintukshina ñañu yura.
Puna suyupika sukuswanmi wasikataka ru- rankuna.
sullka</p>          </div>', 'ACTIVE', 1, '-'),
       (719, 'sulluy', '0', 'sulluy', '<div class="word--description">             <span class="word--fonetic">[sulyuy, suzuy]</span>              <p class="word--description">s. aborto. Shuk wawa manarak puncha paktashkapi llukshiy.
Sulluyka mana allichu, shuk hatun llakimi kan.
sumak</p>          </div>', 'ACTIVE', 1, '-'),
       (720, 'sumakyachina', '0', 'sumakyachina', '<div class="word--description">             <span class="word--fonetic">[sumakyačina]</span>              <p class="word--description">v. arreglar, componer, adornar, decorar, mejorar. Mana alli rikurikta sumak rikurikta ruray, wakllichis- hkata allichiy.
Payka yura shuyuta sumakyachin.
Sin. Allichina.
sumpu</p>          </div>', 'ACTIVE', 1, '-'),
       (721, 'suni', '0', 'suni', '<div class="word--description">             <span class="word--fonetic">[suni]</span>              <p class="word--description">adj. largo, extenso. Imakunapash
wichayman, urayman, maymanpash kashpa hatun kak.
Ayllu llaktaman chayankapakka kay suni


ñantami rina kanchik.
sunka</p>          </div>', 'ACTIVE', 1, '-'),
       (722, 'supay', '0', 'supay', '<div class="word--description">             <span class="word--fonetic">[supay]</span>              <p class="word--description">s. espíritu, ser mítico. Mana tukuypak ñawipi rikurik ayashina.
Wawaka supayta manchashpami tutaka mana llukshinchu.
supi</p>          </div>', 'ACTIVE', 1, '-'),
       (723, 'supina', '0', 'supina', '<div class="word--description">             <span class="word--fonetic">[supina]</span>              <p class="word--description">s. peer. Supita llukshichiy.
Chawa mikukpika supinllami.
surkan</p>          </div>', 'ACTIVE', 1, '-'),
       (724, 'surkuna', '0', 'surkuna', '<div class="word--description">             <span class="word--fonetic">[surkuna, surkona]</span>              <p class="word--description">v. sacar. Hutku ukumanta imatapash pakllaman aysay.
Mankamanta yanushka papata surkunchik.
Sin. Llukshichina.
suru</p>          </div>', 'ACTIVE', 1, '-'),
       (725, 'susu', '0', 'susu', '<div class="word--description">             <span class="word--fonetic">[susu]</span>              <p class="word--description">s. polilla. Kaspita, churanata, murukunata mikushpa ismuchik uchilla wiwa. Sara wakaychishkataka susuka tukuytami mikushka.
susuna</p>          </div>', 'ACTIVE', 1, '-'),
       (726, 'sutukyana', '0', 'sutukyana', '<div class="word--description">             <span class="word--fonetic">[sutukyana, zutuxyana, zutug- yana]</span>              <p class="word--description">v. sc. humedecerse, mojarse; gotear. Yakuwan hawa hawalla hukuy.
Armashka kipa umaka sutukyan.
Sin. hukuna, mutiyana.
suyu</p>          </div>', 'ACTIVE', 1, '-'),
       (727, 'suyu', '0', 'suyu', '<div class="word--description">             <span class="word--fonetic">[suyu]</span>              <p class="word--description">s. na. variedad de golondrina. Yana patpayuk, wayrapi, tamyapi pawak pishku.

SUYU
Suyu	pishkukunaka	mana	tamyapi hukunchu.
Sin. Shillishilli.















































shakalli</p>          </div>', 'ACTIVE', 1, '-'),
       (728, 'shakan', '0', 'shakan', '<div class="word--description">             <span class="word--fonetic">[šakaŋ]</span>              <p class="word--description">s. na. variedad de lora. Waylla patpayuk, yurak ñawiyuk uchilla wa- kamayushina pishku.
Shakan pishkukunaka anti suyu sachapimi kawsan.
Sin. Kayas.
shallipu</p>          </div>', 'ACTIVE', 1, '-'),
       (729, 'shallina', '0', 'shallina', '<div class="word--description">             <span class="word--fonetic">[šalyina, čalyina]</span>              <p class="word--description">v. amz. rajar, hen-
der. Yantata rurankapak kaspita chiktay.
Payka yantatami shallirka.
Sin. Chiktana.
shampana</p>          </div>', 'ACTIVE', 1, '-'),
       (730, 'shamuk', '0', 'shamuk', '<div class="word--description">             <span class="word--fonetic">[šamux]</span>              <p class="word--description">adv. futuro, venidero, lo que vendrá. Kipapa yuyarishka, pacha kipa- lla chayamuk.
Shamuk killakunapimi wasita rurasha.
2. s. el que viene. Pipash shuk kuskaman chayamuk, rikurik.
Payka sapan punchakunami shamuk runa kan.
Sin. chayak.
shamuna</p>          </div>', 'ACTIVE', 1, '-'),
       (731, 'u', '0', 'u', '<div class="word--description">             <span class="word--fonetic">[šañu]</span>              <p class="word--description">s. café, planta y bebida. Yun-
kapi pukuk hatunlla yura, puka muruyukmi tukun.
Shañu yakuka puñuyta anchuchinmi.

shapaka</p>          </div>', 'ACTIVE', 1, '-'),
       (732, 'shayak', '0', 'shayak', '<div class="word--description">             <span class="word--fonetic">[šayak]</span>              <p class="word--description">adv. vertical. Hawamanta
urayman tiyak.
Hatun runaka shayakmi rikurin.
shayak aspi</p>          </div>', 'ACTIVE', 1, '-'),
       (733, 'shayarina', '0', 'shayarina', '<div class="word--description">             <span class="word--fonetic">[šayarina]</span>              <p class="word--description">v. detenerse, pararse; ponerse de pie. Maypipash harkariy, sakiriy, tiyakushkamanta hatariy.
Shuk mashi rikurikpimi rimanakunkapak sha- yarirkani.
shayana</p>          </div>', 'ACTIVE', 1, '-'),
       (734, 'shaykuna', '0', 'shaykuna', '<div class="word--description">             <span class="word--fonetic">[šaykuna]</span>              <p class="word--description">v. s. cansar, fatigar, a-
gotar. Achkata imatapash rurashpa sampa- yashpa sakirina.
Tukuy puncha llamkashpa achkata shayku-
ni.
Sin. Sampayana, kalakyana.
shikitu</p>          </div>', 'ACTIVE', 1, '-'),
       (735, 'shikina', '0', 'shikina', '<div class="word--description">             <span class="word--fonetic">[šiŋkina]</span>              <p class="word--description">v. amz. descamar. Yaku aychapa karapi llutarayakuk hawa karata an- chuchiy.
Payka, yaku aychata kusankapak shikikun.
2. amz. rallar. Lumuta, palantata, chuntata, karata llukshichiy.
Challwawan sankuyachishpa yanunkapakmi palantata shikikuni.
Sin. 1-2 shikitana.
shikra</p>          </div>', 'ACTIVE', 1, '-'),
       (736, 'shikshi', '0', 'shikshi', '<div class="word--description">             <span class="word--fonetic">[šixši, šigši]</span>              <p class="word--description">s. sarna. Runa aychapi muyuklla llukshishpa yapa shikshichik unkuy. Wawataka hatun shikshi unkuymi hapishka, hampinami kan.
2. comezón. Imamantapash ukkuta aspina- yachiy.
Ama chawarta llikishpa pukllankichu, shik- shita kunkami.
Sin. 1 Isi.
shikshina</p>          </div>', 'ACTIVE', 1, '-'),
       (737, 'shiktikuy', '0', 'shiktikuy', '<div class="word--description">             <span class="word--fonetic">[šixtikuy]</span>              <p class="word--description">s. na. ciempiés. Yana tullpuyuk, achka chakiyuk kuru.
Tarpuna allpakunapika achka shiktikuymi purin.
Sin. Shiway, tatis.
shila</p>          </div>', 'ACTIVE', 1, '-'),
       (738, 'shillinkuk', '0', 'shillinkuk', '<div class="word--description">             <span class="word--fonetic">[šilyiŋkux]</span>              <p class="word--description">adj. travieso. Imata- pash hapishpa yapa piñachik wawa.
Wawakuna ama yapa shillinkukkuna ka- chunka pukllashpa, rurachishpami llamkana kan.
shillinkuna</p>          </div>', 'ACTIVE', 1, '-'),
       (739, 'shillishilli', '0', 'shillishilli', '<div class="word--description">             <span class="word--fonetic">[šilyišilyi]</span>              <p class="word--description">s. amz. variedad de
golondrina. Yana tullpu, sinchita wayrata musyashpa, achkapura tantarishpa shillishilli nishpa takik, hawapi wampurik pishku.
Shillishillimi wayrata pawan.
Sin. Suyu.
shilltipu</p>          </div>', 'ACTIVE', 1, '-'),
       (740, 'shimi', '0', 'shimi', '<div class="word--description">             <span class="word--fonetic">[šimi, simi]</span>              <p class="word--description">s. idioma, lenguaje articu-
lado. Runakunapa shuk shuk rimaykuna.
Kanka ¿ima shimipitak rimanki?
2. Boca. Rimay llukshina, mikuna yaykuchina hutku.
Ama shimita manchanayta paskaychu.

SHINAMI
shimi-chinkachina</p>          </div>', 'ACTIVE', 1, '-'),
       (741, 'shiminchina', '0', 'shiminchina', '<div class="word--description">             <span class="word--fonetic">[šiminčina, šimiŋžina]</span>              <p class="word--description">v. hacer bordes. Imakunapipash manyakunata churay.
Sawariypak llikllata shiminchikuni. shimiyuk</p>          </div>', 'ACTIVE', 1, '-'),
       (742, 'shimpi', '0', 'shimpi', '<div class="word--description">             <span class="word--fonetic">[šiŋbi, šimbu, čimpu]</span>              <p class="word--description">s. variedad de
palmera. Shiwashina mikuna muyuta aparik yura.
Kayashkakunaman karankapak shimpi mu- yuta pallakunchik.
shina</p>          </div>', 'ACTIVE', 1, '-'),
       (743, 'shinallatak', '0', 'shinallatak', '<div class="word--description">             <span class="word--fonetic">[šinallatax, šinaladig, činala- dig]</span>              <p class="word--description">conj. pero. Shinapash ninkapak rimay. Ñuka llaktaman tikranata munani; shinalla- tak, wasi illak kashpa mana ushani.
2. igualmente, de la misma manera, así mismo, de la misma forma. Chaypuralla kachun ninkapak rimay.
Imashinami kanman kullkita mañachirkani,
shinallatak kutichiway.
shinami</p>          </div>', 'ACTIVE', 1, '-'),
       (744, 'shinapash', '0', 'shinapash', '<div class="word--description">             <span class="word--fonetic">[šinapaš, šinapiš]</span>              <p class="word--description">conj. pero, de todas maneras. Chashna kakpipash, ninka- pak rimay.
Kimsa tantanakuyman mana shamushkachu,
shinapash yallichishunchik.
shinana</p>          </div>', 'ACTIVE', 1, '-'),
       (745, 'shinayka', '0', 'shinayka',
        '<div class="word--description">             <span class="word--fonetic">[šinayga, šinaga]</span>              <p class="word--description">adv. na. por su- puesto. Chashna kakpika ninkapak rimay. Shinayka, raymipika tushuk rishallatakmari. Sin. Manakayari, shinaymi, shinaykuti. shinaykuti</p>          </div>',
        'ACTIVE', 1, '-'),
       (746, 'shinka', '0', 'shinka', '<div class="word--description">             <span class="word--fonetic">[šinga]</span>              <p class="word--description">adj. borracho, chumado, em- briagado. Pukushka aswata upyashpa yuyay chinkay.
shinka runaka, aswata upyashpa alliman- tami shamurkani.
Sin. Machashka.
shinkana</p>          </div>', 'ACTIVE', 1, '-'),
       (747, 'shinkayana', '0', 'shinkayana', '<div class="word--description">             <span class="word--fonetic">[šiŋgayana]</span>              <p class="word--description">v. emborracharse, chumarse, embriagarse. Aswata, hayak ya- kuta upyashpa machay.
Ayllullakta raymipi mashikunawan shinka- yarkani.
Sin. Machay.
shinki</p>          </div>', 'ACTIVE', 1, '-'),
       (748, 'shinshin', '0', 'shinshin', '<div class="word--description">             <span class="word--fonetic">[šiŋšiŋ, šinšiŋ]</span>              <p class="word--description">s. amz. serpiente pequeña. Muru karayuk, killu chupayuk, wañuy hampiyuk uchilla machakuy.
Anti suyuman rishpaka shinshin machakuy- taka alli rikushpami purinchik.
shinshin</p>          </div>', 'ACTIVE', 1, '-'),
       (749, 'shipati', '0', 'shipati', '<div class="word--description">             <span class="word--fonetic">[šipati]</span>              <p class="word--description">s. na. Una variedad de pal-
mera. Chillishina kashpallatak uchilla, pan- kaka wasi awankapak; muyuka mikunkapak; shuk llaktakunapika chincha nishka yura.
Ashankapi shipati muyuta katunkapakmi pa- llani.
Sin. Chincha.
shirinka</p>          </div>', 'ACTIVE', 1, '-'),
       (750, 'shitana', '0', 'shitana', '<div class="word--description">             <span class="word--fonetic">[šitana]</span>              <p class="word--description">v. botar, arrojar, tirar, lan-
zar. Imatapash kachariy, hichuy, tuksiy.
Palanta karakunataka chintapi shitanchik.
2. amz. cazar con bodoquera. Wiwakunata wañuchinkapak yawrita pukuna ukupi chu- rashkata sinchita pukuy.
Ñukapa churika sacha wiwakunata hapinka- pak shitakun.
Sin. 1 Chutana, aysana, karkuna.
shitana</p>          </div>', 'ACTIVE', 1, '-'),
       (751, 'shiwa', '0', 'shiwa', '<div class="word--description">             <span class="word--fonetic">[šiwa]</span>              <p class="word--description">s. pa. variedad de palmera.
Mishki yuyuta charik, achka yana muyuta aparik, sachapi wiñak chuntashina yura.
Akchata shiwa muyu wirawan armakpika sumakmi wiñan.
Sin. Unkurawa.
shiway</p>          </div>', 'ACTIVE', 1, '-'),
       (752, 'shiwi', '0', 'shiwi',
        '<div class="word--description">             <span class="word--fonetic">[šiwi, siwi]</span>              <p class="word--description">s. anillo, sortija. Maki rukapi churachinkapak antakunamanta rurashka. Payka sawarinkapak shiwita rantin. shiwtana</p>          </div>',
        'ACTIVE', 1, '-'),
       (753, 'shuk', '0', 'shuk', '<div class="word--description">             <span class="word--fonetic">[šuk, šug, šux, šu]</span>              <p class="word--description">num. uno. Kallarik yupay.
Ñukaka shuk watayuk wawatami charini.




shukkuna</p>          </div>', 'ACTIVE', 1, '-'),
       (754, 'shukarina', '0', 'shukarina', '<div class="word--description">             <span class="word--fonetic">[šukarina, čukarina]</span>              <p class="word--description">v. atrancar. Imatapash mikushpa harkariy.
Yachakukka challwata mikukushpami shuka- rirka.
2. hincharse. Yallikta mikushpa wiksa punkis- hkashina tukuy.
Yapa chirita yallishpami wiksa shukarishka.
Sin. 2 Punkina.
shuklla</p>          </div>', 'ACTIVE', 1, '-'),
       (755, 'shulla', '0', 'shulla', '<div class="word--description">             <span class="word--fonetic">[šulya ]</span>              <p class="word--description">s. rocío, escarcha. Tutamanta shuk tamyashina urmak.
Shulla kiwata mikushpa wiwakunaka wiksa punkishpa wañunkuna.
Sin. sarpa.
shullana</p>          </div>', 'ACTIVE', 1, '-'),
       (756, 'shulluy', '0', 'shulluy', '<div class="word--description">             <span class="word--fonetic">[šulyuy, šužuy]</span>              <p class="word--description">s. aborto. Shuk wawa manarak puncha paktashkapi llukshiy. Warmikunapa shulluyka mana allichu, lla- kimi kan.
2. v. abortar. Chichu kashpa manarak pun- cha paktakpi wacharina.
Imatapash munashpa wakin warmikunaka
shullunllami.
shunku</p>          </div>', 'ACTIVE', 1, '-'),
       (757, 'shunkuchina', '0', 'shunkuchina', '<div class="word--description">             <span class="word--fonetic">[šunkučina]</span>              <p class="word--description">v. curar del es- panto. Ima unkuykunata, mancharishkaku- nata anchuchishpa hampina.
Wawataka manchariy unkuywan kakpimi

shunkuy</p>          </div>', 'ACTIVE', 1, '-'),
       (758, 'shunkuna', '0', 'shunkuna', '<div class="word--description">             <span class="word--fonetic">[šuŋguna]</span>              <p class="word--description">v. amz. indicar, seña- lar. Ama pantachun, kashna ruranki nishpa shukta yachachiy.
Payka ñukapa wasiman paktamushkallami pitakshi alli shunkuchishka.
shunkuyuk</p>          </div>', 'ACTIVE', 1, '-'),
       (759, 'shushuna', '0', 'shushuna', '<div class="word--description">             <span class="word--fonetic">[šušuna]</span>              <p class="word--description">s. cedazo. Huku huku- yuk rurashka hillay.
Ñukaka shushunapimi kutata shushukuni. shushuna</p>          </div>', 'ACTIVE', 1, '-'),
       (760, 'shuti', '0', 'shuti', '<div class="word--description">             <span class="word--fonetic">[šuti]</span>              <p class="word--description">s. nombre. Runakunata, llak- takunata imashina rimanata yachay.
Kay allkuka ¿ima shutiyuktak kan?
shutu</p>          </div>', 'ACTIVE', 1, '-'),
       (761, 'shuturina', '0', 'shuturina', '<div class="word--description">             <span class="word--fonetic">[šuturina]</span>              <p class="word--description">v. mojarse. Ima yakupi, tamyapi mutiyay.
Tamyapimi shuturirkani.
Sin. Hukuna, mutiyana.
shutuna</p>          </div>', 'ACTIVE', 1, '-'),
       (762, 'shuwa', '0', 'shuwa', '<div class="word--description">             <span class="word--fonetic">[šuwa, šua]</span>              <p class="word--description">s. ladrón. Shukpa ima- kunatapash hapishpa apak.
Tawka shuwami ñukapa wasiman yaykurka. shuwana</p>          </div>', 'ACTIVE', 1, '-'),
       (763, 'shuyana', '0', 'shuyana', '<div class="word--description">             <span class="word--fonetic">[šuyana]</span>              <p class="word--description">v. esperar,  aguardar.
lmatapash chapay.
Tukuy llama chayamuchun shuyakuni. shuyu</p>          </div>', 'ACTIVE', 1, '-'),
       (764, 'shuyuna', '0', 'shuyuna', '<div class="word--description">             <span class="word--fonetic">[šuyuna]</span>              <p class="word--description">v. manchar. Imakunata- pash mapayachiy.


Pirkapi shuyunki.
2. dibujar. Llimpiwan rikuchiy.
Tránsito Amaguaña warmita shuyushun.
Sin. 1 Llunchina; 2. llimpina.














































takallina</p>          </div>', 'ACTIVE', 1, '-'),
       (765, 'takarina', '0', 'takarina', '<div class="word--description">             <span class="word--fonetic">[takarina]</span>              <p class="word--description">v. rozarse, golpearse, tropezarse. lmapipash waktariy.
Yayaka shinka shamukushpa yurapi chakita
takarirka.
Sin. Waktarina.
takarpu</p>          </div>', 'ACTIVE', 1, '-'),
       (766, 'takana', '0', 'takana', '<div class="word--description">             <span class="word--fonetic">[takana]</span>              <p class="word--description">v. machacar, pedacear, martillar. Imakunatapash waktashpa ñutuya- chiy.
Aswata rurankapak lumuta takakuni.
2. sc. afilar. Imatapash kuchunkapak antaku- nata llampuyachiy.
Kiwata pitinkapak kuchunata takak riy.
Sin. 1 Waktana.
taki</p>          </div>', 'ACTIVE', 1, '-'),
       (767, 'taki', '0', 'taki', '<div class="word--description">             <span class="word--fonetic">[taki, take]</span>              <p class="word--description">s. troje. Muyukunata wakaychinkapak rurashka kincha.
Papata takipi wakaychirkani.
takina</p>          </div>', 'ACTIVE', 1, '-'),
       (768, 'takla', '0', 'takla', '<div class="word--description">             <span class="word--fonetic">[taxla]</span>              <p class="word--description">adj. amz. flojo. Shuk yapa hatun churay, churarikpi mana allita rikurik. Kay waraka taklami sakirin.
taklla</p>          </div>', 'ACTIVE', 1, '-'),
       (769, 'takllana', '0', 'takllana', '<div class="word--description">             <span class="word--fonetic">[taxlyana]</span>              <p class="word--description">v. amz. ajustar. Imata- pash, imapipash sinchi sinchi watay, llapiy, churaypashmi kan.

Kay muchikuta takllapay.
takllu</p>          </div>', 'ACTIVE', 1, '-'),
       (770, 'takshana', '0', 'takshana', '<div class="word--description">             <span class="word--fonetic">[taxšana, tagšana, taxsana]</span>              <p class="word--description">v. lavar ropa. Ima churanakunata yakupi chu- yayachina.
Kanka ¿ñachu warata taksharkanki? taksu</p>          </div>', 'ACTIVE', 1, '-'),
       (771, 'taktarina', '0', 'taktarina', '<div class="word--description">             <span class="word--fonetic">[taxtarina]</span>              <p class="word--description">v. ss. endurarse. Turu allpa, millmapash, ima kashpapash sinchi tukuy.
Yalli tamyakpi tarpuna allpa taktarishka. takurina</p>          </div>', 'ACTIVE', 1, '-'),
       (772, 'unkuy', '0', 'unkuy', '<div class="word--description">             <span class="word--fonetic">[taxyay-uŋkuy]</span>              <p class="word--description">s. bo. enfer- medad persistente. Mana utka, utka hampirik unkuy.
Ñukapa yayapa unkuyka takyak-unkuypimi tikrashka.
takyarina</p>          </div>', 'ACTIVE', 1, '-'),
       (773, 'tallika', '0', 'tallika', '<div class="word--description">             <span class="word--fonetic">[talyiga]</span>              <p class="word--description">s.collar de pepas. Muyuku- nawan, tullukunawan, millmakunawan rurashka aparina wallka.
Tallikata watarishpa raymiman haku.
Sin. Hallinka.
tallirina</p>          </div>', 'ACTIVE', 1, '-'),
       (774, 'tallina', '0', 'tallina', '<div class="word--description">             <span class="word--fonetic">[talyina]</span>              <p class="word--description">v. S. regar, esparcir. Imapi- pash huntachishkata chawsichiy, imapipash

TALPA
churay.
¿Pitak sara huntachishkataka tallirka?
2. verter, regar agua. Yakuta, aswata, ima ya- kutapash shitay.
¿Pitak kawitupi aswata tallirka?.
Sin. 1 chakchuna, hichana, chiwana, 2 par- kuna.
talpa</p>          </div>', 'ACTIVE', 1, '-'),
       (775, 'tampu', '0', 'tampu', '<div class="word--description">             <span class="word--fonetic">[tampu, taŋbu]</span>              <p class="word--description">s. depósitos del inca- rio; posada. Mikuna muyukunata wakay- chinkapak, samankapakpash ñankunapi rurashka wasikuna.
Kunanpipashmi tampu llaktakunaka tiyan. tamya</p>          </div>', 'ACTIVE', 1, '-'),
       (776, 'pacha', '0', 'pacha', '<div class="word--description">             <span class="word--fonetic">[tamya pacha]</span>              <p class="word--description">s. invierno. Ashtawan yapa tamyana killakuna.
Tamya pachapika sumak wayllallami rikurin. tamyana</p>          </div>', 'ACTIVE', 1, '-'),
       (777, 'tanampu', '0', 'tanampu', '<div class="word--description">             <span class="word--fonetic">[tanaŋbu]</span>              <p class="word--description">s. amz. arbusto cuyas hojas se usan como barbasco. Challwaku- nata hapinkapak yura, shuk llaktakunapi ka- halli nishka.
Tananpu yurataka mana yapa yakupi shita- nachu, tukuylla challwakunami wañun.
Sin. kahalli.
tani</p>          </div>', 'ACTIVE', 1, '-'),
       (778, 'tankana', '0', 'tankana', '<div class="word--description">             <span class="word--fonetic">[taŋgana]</span>              <p class="word--description">s. amz. variedad de árbol. Yurakta sisak, wasikunata rurana kaspi Tankana yurata ama pitiychu.
tankana</p>          </div>', 'ACTIVE', 1, '-'),
       (779, 'tanla', '0', 'tanla', '<div class="word--description">             <span class="word--fonetic">[tanla]</span>              <p class="word--description">s. amz. variedad de pez. Killu- wan yanawan tullpuyuk hatun challwa.
Tanlaka hatun mayupimi kawsan.
tanta</p>          </div>', 'ACTIVE', 1, '-'),
       (780, 'tantachiy', '0', 'tantachiy', '<div class="word--description">             <span class="word--fonetic">[taŋdačiy]</span>              <p class="word--description">s. agrupación, unión.
Imatapash shukllapi churay.
Kullkita tantachiyka allimi kan.
2. v. amontonar, agrupar, reunir. Tukuyta shukllapi tawkachiy.
Papata kay uksha chukllapi tantachirkani.
Sin. 1 Tantana.
tantanakuy</p>          </div>', 'ACTIVE', 1, '-'),
       (781, 'tantana', '0', 'tantana', '<div class="word--description">             <span class="word--fonetic">[taŋdana]</span>              <p class="word--description">v. recolectar, recoger,
juntar. Shukllapi mikuna muyukunata shuk- llapi churay.
Kay sarata kancha pampapimi tantarkani.
Sin. Llutana, tinkina, tantachina.
tapsa</p>          </div>', 'ACTIVE', 1, '-'),
       (782, 'tapuna', '0', 'tapuna', '<div class="word--description">             <span class="word--fonetic">[tapuna]</span>              <p class="word--description">v. preguntar, averiguar, in- terrogar. Yachankapak, riksinkapak shuk- kunata taripay.
Shamushkata yachak chayankapakmi tapur- kani.
tapya</p>          </div>', 'ACTIVE', 1, '-'),
       (783, 'tapyana', '0', 'tapyana', '<div class="word--description">             <span class="word--fonetic">[tabyana]</span>              <p class="word--description">v. sc, amz. hablar sin sentido, desvariar. Imatapash mana yuyay- wan rimay.
Kanka mana alli kachun tapyashkanki.
Sin. pantayrimay.
taraputu</p>          </div>', 'ACTIVE', 1, '-'),
       (784, 'tarinakuna', '0', 'tarinakuna', '<div class="word--description">             <span class="word--fonetic">[tarinakuna]</span>              <p class="word--description">v. encontrarse. Ashtawanka runapuralla shuk pampapi, shuk wasipi maypipash rikunakuy.
Mamawan yayawanka Napo llaktapimi ta-




rinakushka.


Sin. chusku.

TIKASU

Sin. Rikunakuna, tinkunakuna.
taripay</p>          </div>', 'ACTIVE', 1, '-'),
       (785, 'tarina', '0', 'tarina', '<div class="word--description">             <span class="word--fonetic">[tarina]</span>              <p class="word--description">v. encontrar, hallar. Hi- chushkata, kunkashkata, pay munay rikurikta hapiriy.
Shuk muchikuta ñanpimi tarirkani. tarpuna</p>          </div>', 'ACTIVE', 1, '-'),
       (786, 'taruka', '0', 'taruka', '<div class="word--description">             <span class="word--fonetic">[taruka, taruga]</span>              <p class="word--description">s. venado. Shuk puka millmayuk, yurak chupayuk, umapi is- hkay kachuyuk hatun wiwa.
Urkupika puka tarukatami rikurkani.
taski</p>          </div>', 'ACTIVE', 1, '-'),
       (787, 'taslla', '0', 'taslla', '<div class="word--description">             <span class="word--fonetic">[taslya]</span>              <p class="word--description">adj. amz. elegante, gallardo. Karilla runa, mana unkushka runa, llakipash illak runa.
Taslla churakushka hachitami charini. tatis</p>          </div>', 'ACTIVE', 1, '-'),
       (788, 'tatki', '0', 'tatki', '<div class="word--description">             <span class="word--fonetic">[tatki, taxti, tiyaxti]</span>              <p class="word--description">s. paso. Purinkapak shuk chakita ñawpachiy.
Llukiwan shuk tatkita kupay.
2. s. metro. Shuk tatkishina tupu.
Chunka tatkita tupushpa yurataka pitinki. tatkina</p>          </div>', 'ACTIVE', 1, '-'),
       (789, 'tawa', '0', 'tawa', '<div class="word--description">             <span class="word--fonetic">[tawa]</span>              <p class="word--description">num. cuatro. Kimsapa katik
yupay.
Wakraka tawa chakiyukmi kan.

Tawantin suyu</p>          </div>', 'ACTIVE', 1, '-'),
       (790, 'tawka', '0', 'tawka', '<div class="word--description">             <span class="word--fonetic">[tawka]</span>              <p class="word--description">det. algunos, bastante. Ima-
tapash ashalla kashkata hawalla yupay.
Kay llaktapika tawka wasimi tiyashka.
Sin. Achka, ashtaka, manchayakta, pachan, llashak.
tawna</p>          </div>', 'ACTIVE', 1, '-'),
       (791, 'tawnana', '0', 'tawnana', '<div class="word--description">             <span class="word--fonetic">[tawnana]</span>              <p class="word--description">v. apoyar en el bastón, apuntalar. Shuk kaspiwan yanaparishpa sin- chita shayariy.
Kay llampushka kaspiwanmi tawnarinki. tawri</p>          </div>', 'ACTIVE', 1, '-'),
       (792, 'taylla', '0', 'taylla', '<div class="word--description">             <span class="word--fonetic">[taylya]</span>              <p class="word--description">adj. duro, resistente. Muyu, kaspi, imapash mana pakiypak tukushka ya- pakta sinchiyashka.
Taylla chakami kan.
Sin Sinchi.
taznu</p>          </div>', 'ACTIVE', 1, '-'),
       (793, 'tika', '0', 'tika', '<div class="word--description">             <span class="word--fonetic">[th ika, tika]</span>              <p class="word--description">s. adobe. Wasita, pirkata ru- rankapak rurashka allpa paki.
Wasita rurankapakmi tikata apakuni.
tika</p>          </div>', 'ACTIVE', 1, '-'),
       (794, 'tikasu', '0', 'tikasu', '<div class="word--description">             <span class="word--fonetic">[tikasu, čikaksu]</span>              <p class="word--description">s. amz. tipo de fruta. Ankupi aparik, yanushpa, kusashpapash mi- kuna muyu.
Tikasu muyuta apamurkani.



TIKAYANA
Sin. Chikaksu.
tikayana</p>          </div>', 'ACTIVE', 1, '-'),
       (795, 'tiklla', '0', 'tiklla', '<div class="word--description">             <span class="word--fonetic">[tixlya, tixža]</span>              <p class="word--description">s. snc. mancha. Ima wi-
kipash aychapi, churanapi urmashpa ya- nayachishka,	pukayachishka, mapayachishka.
Mushuk warapi tikllami rikurin.
Adj. manchado. Ima wiki urmashkamanta mapayasha. Tiklla muchikutami churas- hkanki.
tikrachina</p>          </div>', 'ACTIVE', 1, '-'),
       (796, 'tikramuna', '0', 'tikramuna', '<div class="word--description">             <span class="word--fonetic">[tigramuna]</span>              <p class="word--description">v. retornar, regre-
sar, volver. Maymanta llukshishpa chayman- llatak rina.
Hachika Quito llaktaman mana paktashpalla- tak unkushpa tikramurka.
Sin. Tikrana.
tikrana</p>          </div>', 'ACTIVE', 1, '-'),
       (797, 'tiksimuyu', '0', 'tiksimuyu', '<div class="word--description">             <span class="word--fonetic">[tigsimuyu]</span>              <p class="word--description">s. planeta tierra. In- tipa ayllupa tiyak rumpu.
Runakuna, wiwakuna, yurakuna tiksimuyupi kawsan.
tiksimuyuyachay</p>          </div>', 'ACTIVE', 1, '-'),
       (798, 'tikta', '0', 'tikta', '<div class="word--description">             <span class="word--fonetic">[tixta]</span>              <p class="word--description">s. amz. trampa de cacería para
animales grandes. Kaspiwan waskawan sachapi kawsak wiwakunata hapinkapak rurashka.
Tiktawanmi sikuta hapirkani.
tikti</p>          </div>', 'ACTIVE', 1, '-'),
       (799, 'tillimanku', '0', 'tillimanku', '<div class="word--description">             <span class="word--fonetic">[tilyimaŋgu]</span>              <p class="word--description">s. amz. garrapata pequeña. Uchilla añankushina aychapi lluta- rishpa yawarta tsumkak.
Wawa allkuta tillimanku katishpa yapata ir- kiyachikun.
Sin Waku.
tillimpu</p>          </div>', 'ACTIVE', 1, '-'),
       (800, 'timpuna', '0', 'timpuna', '<div class="word--description">             <span class="word--fonetic">[timbuna, tiŋbuna]</span>              <p class="word--description">v. hervir, borbo- tear, fermentarse. Yakuta ninapi churakpi achkata rupakyay, aswakuna ima upyanaku- napash pukuriy.
¡Chay yakuka ñami timpukun!.
tinkana</p>          </div>', 'ACTIVE', 1, '-'),
       (801, 'tinki', '0', 'tinki',
        '<div class="word--description">             <span class="word--fonetic">[tinki]</span>              <p class="word--description">s. sábado. Suktaniki puncha. tinkina</p>          </div>',
        'ACTIVE', 1, '-'),
       (802, 'tinkula', '0', 'tinkula', '<div class="word--description">             <span class="word--fonetic">[tiŋgula]</span>              <p class="word--description">s. amz. variedad de lora. Waylla millmayuk, tinkula tinkula tinkula ka- parik waylla pishku.
Tinkula pishkutami hapirkani.
tinkullpa</p>          </div>', 'ACTIVE', 1, '-'),
       (803, 'tinkuna', '0', 'tinkuna', '<div class="word--description">             <span class="word--fonetic">[tiŋguna]</span>              <p class="word--description">v. ss. tambalear, Kayman





chayman tikray tikray riy, shayakuy.
Tawka runami tushuypi tinkurka.
2. unir. Imatapash shukwan shuktawan llutay Ishkay mayuka kaypimi tinkun.
tipina</p>          </div>', 'ACTIVE', 1, '-'),
       (804, 'tipina', '0', 'tipina', '<div class="word--description">             <span class="word--fonetic">[tipina]</span>              <p class="word--description">v. deshojar el maíz. Sara- manta, chukllumantapash kutuluta anchu- china.
Kunan yanunkapakmi chuklluta tipirkani. tisana</p>          </div>', 'ACTIVE', 1, '-'),
       (805, 'titi', '0', 'titi', '<div class="word--description">             <span class="word--fonetic">[th iti, titi]</span>              <p class="word--description">s. plomo . Chuya rikurik mana yapa sinchi anta.
Titika ñukanchikpa ukunpakka mana allichu kan.
tiwinkulu</p>          </div>', 'ACTIVE', 1, '-'),
       (806, 'tiw', '0', 'tiw', '<div class="word--description">             <span class="word--fonetic">[tiw tiw tiw]</span>              <p class="word--description">interj. amz. expre-
sión que se dice a los perros cazadores para seguir el rastro de personas o animales. Shuk sacha wiwata katichun nishpa allkuta kaparina shimi.
Juan mashika tiw tiw tiw nishpami allkuta kayarka.
tiyamshi</p>          </div>', 'ACTIVE', 1, '-'),
       (807, 'tiyarina', '0', 'tiyarina', '<div class="word--description">             <span class="word--fonetic">[tiyarina, tyarina]</span>              <p class="word--description">s. banco, silla, asiento. Sikiwan samankapak rurashka ima. Sumak tiyarinata rurarkani.
tiyarina</p>          </div>', 'ACTIVE', 1, '-'),
       (808, 'tiyarpa', '0', 'tiyarpa', '<div class="word--description">             <span class="word--fonetic">[thyarpa, thyapa]</span>              <p class="word--description">adj. tartamudo.
Waktarishpa, unayashpa rimak. Shuk tiyarpa wawkitami charini. Sin. Takllu, tyatiu.

TUKILU
tiyaskan</p>          </div>', 'ACTIVE', 1, '-'),
       (809, 'tiyatina', '0', 'tiyatina', '<div class="word--description">             <span class="word--fonetic">[tiyatina]</span>              <p class="word--description">s. amz. planta medicinal desinflamante. Shuk uchilla ñañu pankayuk chaki shikshita hampik kiwa.
Tiyatina kiwata chaki shikshipak apamuni. tiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (810, 'tiyu', '0', 'tiyu', '<div class="word--description">             <span class="word--fonetic">[tiyu, thiu, tiu]</span>              <p class="word--description">s. arena fina. Ñutu tsatsa. Wasi pirkata llutachinkapak tiyu allpata ran- timuni.
Sin. illul.
tiyunkullina</p>          </div>', 'ACTIVE', 1, '-'),
       (811, 'tiyunti', '0', 'tiyunti', '<div class="word--description">             <span class="word--fonetic">[tiuŋdi, tiuŋdi, tindi]</span>              <p class="word--description">s. amz. tipo de pájaro. Yana millmayuk, achkapura tan- tanakushpa purik, sara chakrakunata mikushpa tukuchik pishku.
Tiyunti pishkukuna sara chakrapi wakakun. tiyuti</p>          </div>', 'ACTIVE', 1, '-'),
       (812, 'tuka', '0', 'tuka', '<div class="word--description">             <span class="word--fonetic">[tuka, thiuka, tiyuka, tiwka, čuka]</span>              <p class="word--description">s. sa- liva. Shimimanta llukshik pusku, llawsalla yaku.
Ama wasi ukupika tukata shitankichu.
Sin. Llawsa.
tukana</p>          </div>', 'ACTIVE', 1, '-'),
       (813, 'tukilu', '0', 'tukilu', '<div class="word--description">             <span class="word--fonetic">[tukilu, tugilu]</span>              <p class="word--description">s. amz. variedad de perdiz. Uchpa millmayuk allpata purik uchilla yutu.
Tukilu kishata rikurkani.
Sin. yutu.



TUKLLA
tuklla</p>          </div>', 'ACTIVE', 1, '-'),
       (814, 'tukru', '0', 'tukru', '<div class="word--description">             <span class="word--fonetic">[tugru]</span>              <p class="word--description">s. cuágulo. Aychamanta lluks- hishpa sinchiyashka yawar.
Ñukapa rukataka tukru yawarmi killpashka. tuksik</p>          </div>', 'ACTIVE', 1, '-'),
       (815, 'tuksina', '0', 'tuksina', '<div class="word--description">             <span class="word--fonetic">[tuksina]</span>              <p class="word--description">s. jeringuilla. Hampita
ukunman yaykuchinkapak.
Hampik runaka tuksinapi hampita churarka. tuksina</p>          </div>', 'ACTIVE', 1, '-'),
       (816, 'tuktu', '0', 'tuktu', '<div class="word--description">             <span class="word--fonetic">[tuxtu, tugtu]</span>              <p class="word--description">s. flor de maíz. Sara
sisa.
Tuktuta mikuchunmi wakraman shitani. tuktuma</p>          </div>', 'ACTIVE', 1, '-'),
       (817, 'tuktuma', '0', 'tuktuma', '<div class="word--description">             <span class="word--fonetic">[tuxtuma, tuktuna ]</span>              <p class="word--description">adj. amz. ga-
llina que empolla. Lulunkunata ukllakuk mama atallpa.
Puka tuktuma atallpa putsamanta pawan.
Sin. Turuk.
tuku</p>          </div>', 'ACTIVE', 1, '-'),
       (818, 'tuku', '0', 'tuku',
        '<div class="word--description">             <span class="word--fonetic">[tuku, toko]</span>              <p class="word--description">s. ventana. Wasi ukuman achik yaykuchun pirkata hutkushka kak. Ni- nakuruka tukuta ukuman yaykushka. tukuchishka</p>          </div>',
        'ACTIVE', 1, '-'),
       (819, 'tukuchina', '0', 'tukuchina', '<div class="word--description">             <span class="word--fonetic">[tukučina]</span>              <p class="word--description">v. terminar, acabar, finalizar. Ima ruraykunatapash puchukay.
Ñuka, kallarishka shuyuta kunan puncha tu- kuchisha.
tukuri</p>          </div>', 'ACTIVE', 1, '-'),
       (820, 'tukurishka', '0', 'tukurishka', '<div class="word--description">             <span class="word--fonetic">[tukuriška]</span>              <p class="word--description">adj. concluido, ter-
minado, finalizado. Imatapash tukuchin- kakama llamkay.
Kay yachayka tukurishkami kan.
Sin. Tukuchishka.
tukurina</p>          </div>', 'ACTIVE', 1, '-'),
       (821, 'tukurpilla', '0', 'tukurpilla', '<div class="word--description">             <span class="word--fonetic">[tukurpilya, tukurpiža, thyukurpi- lya, thyukur]</span>              <p class="word--description">s. scns. variedad de tórtola. Uchpa patpayuk, uchilla yapa kita, urpishina pishku.
Tukurpillataka mana katiykachanachu kan- chik.
tukuy</p>          </div>', 'ACTIVE', 1, '-'),
       (822, 'tukuna', '0', 'tukuna', '<div class="word--description">             <span class="word--fonetic">[tukuna]</span>              <p class="word--description">v. volverse, transformarse, convertirse, hacerse, fingir, aparentar; suce- der. Shukshina kay, shukman tikrariy.
Achiklla yuyayka mana shukman tukunchu. Sin. 1. Llampu, illakta, mashnalla kak. tukuymashna</p>          </div>',
        'ACTIVE', 1, '-'),
       (823, 'tukuypacha', '0', 'tukuypacha', '<div class="word--description">             <span class="word--fonetic">[tukuypača]</span>              <p class="word--description">adv. snc. abso- lutamente todo. Tukuy tiyakkunata kayanka- pak shimi.




Tukuypachami raymiman rirka. tukyachina</p>          </div>', 'ACTIVE', 1, '-'),
       (824, 'tukyana', '0', 'tukyana', '<div class="word--description">             <span class="word--fonetic">[tuxyana, tugyana]</span>              <p class="word--description">v. reventarse, erupcionar; brotar vegetales. Imatapash ni- napi churakpi sinchita uyarishpa rakiriy.
Ninapi churashka lulunmi tukyarka.
2. amz. despostillarse. Allpamanta rurashka mankakunata ninapi kusakukpi wakinpi hutku, hutku tukushpa waklliriy.
Chay kallanaka nina ukupi churakpimi tuk- yarka.
tula</p>          </div>', 'ACTIVE', 1, '-'),
       (825, 'tularina', '0', 'tularina', '<div class="word--description">             <span class="word--fonetic">[tularina]</span>              <p class="word--description">v. derrumbarse. Yura, all- papash pay munay tuñirishpa urmay.
Yapa tamyakpi allpa tularishka.
2. erosionarse. Tarpuna allpa tuñirishpa tullu allpa sakiriy.
Tarpuna allpa kunan wata tularishka.
Sin. 1 tuñirina.
tulana</p>          </div>', 'ACTIVE', 1, '-'),
       (826, 'tullik', '0', 'tullik', '<div class="word--description">             <span class="word--fonetic">[tulyix]</span>              <p class="word--description">s. amz. tipo de pájaro. Yana
millmayuk, tullik tullik nishpa sachapi allpata purik pishku.
Kayna tamyakuk pacha tullikta rikurkani.
tullpa</p>          </div>', 'ACTIVE', 1, '-'),
       (827, 'tullpu', '0', 'tullpu', '<div class="word--description">             <span class="word--fonetic">[tulypu, tušpu, tulpu]</span>              <p class="word--description">s. color, tintura, pintura. Puka, yana, yurak, waylla, killu, sani, shukkunapash tukuy rikurikkuna.
Kanpa ruwanapa tullpuka yanami kan.
Sin. Llimpi.
tullu</p>          </div>', 'ACTIVE', 1, '-'),
       (828, 'tullumpa', '0', 'tullumpa', '<div class="word--description">             <span class="word--fonetic">[tulyumba, tulyuŋba]</span>              <p class="word--description">s. amz. varie- dad de rana comestible. Uchpa karayuk, tuta tutalla kaparik, karata anchuchishpa mikuna kuwa.
Tullumpata mikunkapak aysamunimi. tullumpa</p>          </div>', 'ACTIVE', 1, '-'),
       (829, 'tulu', '0', 'tulu', '<div class="word--description">             <span class="word--fonetic">[tulu]</span>              <p class="word--description">s. ss. saquillo, bolso. Shikrashina awashka.
¿Mashna kullkipitak kanpa tulutaka katur- kanki?
Sin. Wayaka.
tulun</p>          </div>', 'ACTIVE', 1, '-'),
       (830, 'tumi', '0', 'tumi', '<div class="word--description">             <span class="word--fonetic">[*tumi]</span>              <p class="word--description">s. variedad de cuchillo, como segur. Yantata chiktankapak antamanta ru- rashka hillay.
Tumiwan aychata kuchuni.
tumpana</p>          </div>', 'ACTIVE', 1, '-'),
       (831, 'tumpiki', '0', 'tumpiki', '<div class="word--description">             <span class="word--fonetic">[tumbiki, tuŋbiki, dumbiki, duŋbiki]</span>              <p class="word--description">s. amz. pájaro tucán. Suni kiruyuk, kunkapi millmayuk achkapura tantanakushpa purik hatun pishku.
Tumpiki pawakushpa patpata pampamanmi shitarka.



TUMPINA
tumpina</p>          </div>', 'ACTIVE', 1, '-'),
       (832, 'tunchi', '0', 'tunchi', '<div class="word--description">             <span class="word--fonetic">[tuŋči]</span>              <p class="word--description">s amz. una variedad de pá- jaro. Witapi tunchi tunchi kaparik uchilla pishku.
Tunchi kapariktami uyarkani.
tunchi</p>          </div>', 'ACTIVE', 1, '-'),
       (833, 'tunkuri', '0', 'tunkuri', '<div class="word--description">             <span class="word--fonetic">[tuŋguri]</span>              <p class="word--description">s. garganta, esófago. Mi-
kunata millpuk hutku, mikunata wiksa u- kuman yaykuchik hutku.
Yalli uhukpi tunkuri nanawan.
tunsa</p>          </div>', 'ACTIVE', 1, '-'),
       (834, 'tuntu', '0', 'tuntu', '<div class="word--description">             <span class="word--fonetic">[tuŋdu]</span>              <p class="word--description">s. amz. tipo de pájaro. Tuntu
tuntu kaparishpa purik muru millmayuk uchi- lla pishku.
Tuntu pishkutaka tukuykunami kamana kan- chik.
tuñirina</p>          </div>', 'ACTIVE', 1, '-'),
       (835, 'tupana', '0', 'tupana', '<div class="word--description">             <span class="word--fonetic">[tupana]</span>              <p class="word--description">v. encontrarse. Shukku- nawan ñanpi, wasipi maypipash tarinakuy. Mashi Juan Quito llaktapimi tuparka.
Sin Tarinakuna, tinkunakuna.
tupu</p>          </div>', 'ACTIVE', 1, '-'),
       (836, 'tupuna', '0', 'tupuna', '<div class="word--description">             <span class="word--fonetic">[tupu]</span>              <p class="word--description">v. medir. Imapash mashna kashkata shuk hillaywan yachay.
Allpata rantinkapak tupushunchik.
turi</p>          </div>', 'ACTIVE', 1, '-'),
       (837, 'turu', '0', 'turu', '<div class="word--description">             <span class="word--fonetic">[turu]</span>              <p class="word--description">s. lodo, barro. Api allpa, yakuyas-
hka.
Turupi urmarkani.
turuk</p>          </div>', 'ACTIVE', 1, '-'),
       (838, 'turumanya', '0', 'turumanya', '<div class="word--description">             <span class="word--fonetic">[turumanya]</span>              <p class="word--description">s. planeta nep- tuno. Intipa ayllupi tiyak rumpa.
turuyana</p>          </div>', 'ACTIVE', 1, '-'),
       (839, 'tushuna', '0', 'tushuna', '<div class="word--description">             <span class="word--fonetic">[tušuna]</span>              <p class="word--description">v. bailar. Takishkakunapi, ishkantin, shukllapash sumakta kuyurishpa kushiyay.
Shamuy, ñukawan tushushun.
2.	v. s. brincar. Hawaman pawarikshina ruray.
Chay sarami kallanapi tushukun.
3.	insultar. Runata piñashpa kapariy. Wasiman mana utka chayakpimi tushurkani. Sin 2. Kushparina, 3 kamina.
tuta</p>          </div>', 'ACTIVE', 1, '-'),
       (840, 'tutamanta', '0', 'tutamanta', '<div class="word--description">             <span class="word--fonetic">[tutamanda]</span>              <p class="word--description">s. la madrugada, la mañana. Manarak allita punchayashpa llantu llantu kak.
Payakunaka tutamantapi rimanakunñami. tuta pishku</p>          </div>', 'ACTIVE', 1, '-'),
       (841, 'tutayana', '0', 'tutayana',
        '<div class="word--description">             <span class="word--fonetic">[tutayana]</span>              <p class="word--description">v. anochecerse. Inti yaykukpi, puncha tukurikpi llantu paktamuy. Ñukapa wawkika paypa wasipimi tutayarka. tutipa</p>          </div>',
        'ACTIVE', 1, '-'),
       (842, 'tutu', '0', 'tutu', '<div class="word--description">             <span class="word--fonetic">[tutu]</span>              <p class="word--description">s. sc. Caña hueca delgada; tubo. Hutkuyuk kaspi, sukusshina.
Siwara tulluka tutumi kan.
tutuna</p>          </div>', 'ACTIVE', 1, '-'),
       (843, 'tuwaman', '0', 'tuwaman', '<div class="word--description">             <span class="word--fonetic">[tuwaman]</span>              <p class="word--description">adv. amz. boca abajo. Washata hawaman churashpa; wiksata, ña- wita allpaman kimichishpa siriy.
Yayaka wiksa nanaywan tuwaman sirikun.
Sin. uray sinka.
tuwi</p>          </div>', 'ACTIVE', 1, '-'),
       (844, 'tuyaka', '0', 'tuyaka', '<div class="word--description">             <span class="word--fonetic">[tuyaka]</span>              <p class="word--description">s. remanso. Purik yaku all-
paman yaykushpa hawalla kucha tukushka.
Ñan pampapi tuyakakuna tiyarishka.
Sin. Walun.
tuylla</p>          </div>', 'ACTIVE', 1, '-'),
       (845, 'tuzuyana', '0', 'tuzuyana', '<div class="word--description">             <span class="word--fonetic">[tuzuyana]</span>              <p class="word--description">v. ss. encogerse, achicarse. Ima kashpapash uchillayay.
Wamrapa churanaka tuzuyashkami.
Sin. Wañurina, kintiyana, kuruyana, aysarina, yaykurina, kichkiyana.



































tsala</p>          </div>', 'ACTIVE', 1, '-'),
       (846, 'manku', '0', 'manku', '<div class="word--description">             <span class="word--fonetic">[tsalax manku]</span>              <p class="word--description">s. amz. tipo de pájaro. Shuk hatun manku, tsalak tsalak kaparik, shuk llaktakunapika tsalak tsalak shutiyuk.
Tsalak manku pishkuta yuramanta pawa- chirkani.
Sin. Tsalak tsalak.
tsalakulun</p>          </div>', 'ACTIVE', 1, '-'),
       (847, 'tsalak', '0', 'tsalak', '<div class="word--description">             <span class="word--fonetic">[tsalax tsalax]</span>              <p class="word--description">s. amz. tipo de pájaro. Shuk hatun manku, tsalak tsalak kaparik, shuk llaktakunapika tsalak manku shutiyuk.
Tsalak tsalak pishkuta yuramanta pawachir- kani.
Sin. Tsalak manku.
tsalanchuspi</p>          </div>', 'ACTIVE', 1, '-'),
       (848, 'tsalayarina', '0', 'tsalayarina', '<div class="word--description">             <span class="word--fonetic">[tsalayarina]</span>              <p class="word--description">v. palidecer; adel- gazarse. Imapash ñañulla tukuy.
Wakraka mana mikushkarayku tsalayaris- hkami.
tsan</p>          </div>', 'ACTIVE', 1, '-'),
       (849, 'tsatsa', '0', 'tsatsa', '<div class="word--description">             <span class="word--fonetic">[tsatsa]</span>              <p class="word--description">s. amz.	tipo de arena
142

gruesa. Killu rikurik raku tiyu.
Hatun mayumanta tsatsata surkurkanchik. tsawata</p>          </div>', 'ACTIVE', 1, '-'),
       (850, 'tsiklla', '0', 'tsiklla', '<div class="word--description">             <span class="word--fonetic">[tsixlya]</span>              <p class="word--description">adj. amz. recto; directo (hacia una dirección). Shuk mana wistu, mu- kupash illak kaspi.
Tawnarayku tsiklla kaspita rikushpa piti- munki.
tsili anku</p>          </div>', 'ACTIVE', 1, '-'),
       (851, 'tsilinkitsi', '0', 'tsilinkitsi', '<div class="word--description">             <span class="word--fonetic">[tsiliŋkitsi, tsilyikitsin]</span>              <p class="word--description">s. sc. va- riedad de lagartija. Shuk puzu ñañu palu.
Tsilinkitsi intipi kununkapak llukshishka. tsimpiyu</p>          </div>', 'ACTIVE', 1, '-'),
       (852, 'tsimukina', '0', 'tsimukina', '<div class="word--description">             <span class="word--fonetic">[tsimukina]</span>              <p class="word--description">v. sc. Pestañear. Ñawita ñalla ñalla sipuy.
Mapa ñawi ukuman yaykukpi kutin kutin tsi- mukin.
Sin. sipuna, kimllana, pimpirana. tsintsimpu</p>          </div>', 'ACTIVE', 1, '-'),
       (853, 'tsinzu', '0', 'tsinzu', '<div class="word--description">             <span class="word--fonetic">[tsiŋzu, tsintsu]</span>              <p class="word--description">s. variedad de planta
denominada tsinzu. Ashnak yuyu, wayras- hkata pichankapak kak.
Wayrashkata tsinzuwan pichaway.
tsinzu</p>          </div>', 'ACTIVE', 1, '-'),
       (854, 'tsitsi', '0', 'tsitsi', '<div class="word--description">             <span class="word--fonetic">[tsitsi]</span>              <p class="word--description">adj. arruga de la piel de los ojos. Ñawipi sipuyashka.
Yayapa ñawika tsitsiyukmi kan.
tsitsikina</p>          </div>', 'ACTIVE', 1, '-'),
       (855, 'tsiwi', '0', 'tsiwi', '<div class="word--description">             <span class="word--fonetic">[tsiwi]</span>              <p class="word--description">s. sc. choclo maduro. Shuk pukushka chukllu ashtawan sumak mishki kak.
Tsiwita akllashpa kamchanki.
Sin Kaw.
tsiyampitsu</p>          </div>', 'ACTIVE', 1, '-'),
       (856, 'tsuklupuna', '0', 'tsuklupuna', '<div class="word--description">             <span class="word--fonetic">[tsuglupuna, čukulpuna, tsulu- puna]</span>              <p class="word--description">v. amz. enfriar líquidos. Shuk timpuk yakuta shuk pillchiwan wishishpa, achka kutin chiriyankakama talliy.
Apita shuk pillchiwan utkalla chiriyachun tsu- klupunki.
2. agitar. Timpuk yakuta shuk kaspiwan chi- riyachinkapak kawina, kuyuchina.
Allkupa mikunata tsuklupurkani. tsumkana</p>          </div>', 'ACTIVE', 1, '-'),
       (857, 'tsunzu', '0', 'tsunzu', '<div class="word--description">             <span class="word--fonetic">[tsuŋtsu, tsunzu]</span>              <p class="word--description">adj. andrajoso;
pobre. Piti, piti, lliki, lliki churanakunata chu- rarishka runa; allpata, kullkita, imatapash

Runaka sachapi chinkashpami tsuntsu tuku- mushka.
Sin. wakcha.
tsutsuk</p>          </div>', 'ACTIVE', 1, '-'),
       (858, 'tsutsukina', '0', 'tsutsukina', '<div class="word--description">             <span class="word--fonetic">[tsutsukina, tsuktsukina]</span>              <p class="word--description">v. sc. estrujar, apuñar. Imatapash maki ukupi char- ishpa sinchita llapiy.
¿Imatatak lluki makiwanka tsutsukirkanki?
2. atar. Kipi shimikunata ñañu waskawan watay.
Mushuk shikra shimita watuwan tsutsuk- ishka.
Sin. 1 lutsana, llapina, 2 wankuna, watana. tsutu</p>          </div>', 'ACTIVE', 1, '-'),
       (859, 'tsutuna', '0', 'tsutuna', '<div class="word--description">             <span class="word--fonetic">[tsutuna]</span>              <p class="word--description">v. sc. Amarrar, anudar (las
esquinas de mantel o pañuelo). Tsututa ruray.
Kullkitaka pintupimi tsutuni.
tsuwan</p>          </div>', 'ACTIVE', 1, '-'),
       (860, 'uchilla', '0', 'uchilla', '<div class="word--description">             <span class="word--fonetic">[učilya, učiža, učuylya, ičuklya, ičila, utila]</span>              <p class="word--description">adj. pequeño. Mana yapa hatun, mana yapa suni, mana raku.
Uchilla allpata charishkamanta mana maypi tarpuyta ushanchik.
2. Niño. Chayrak wiñakuk wamra.
Uchillakunaka maypipas pukllan.
Sin. 1 Chusu, wawa, hamchi, ñutu; 2 wamra, wawa.
uchpa</p>          </div>', 'ACTIVE', 1, '-'),
       (861, 'uchu', '0', 'uchu', '<div class="word--description">             <span class="word--fonetic">[uču]</span>              <p class="word--description">s. ají. Puka, killu, waylla tullpuyuk,	hayakyachik,	mikunakunapi churashpa mikuna muyu.
Chiri pachapika mikunata uchuwan cha- pushpa mikuyka sumakmi.
uchukutak</p>          </div>', 'ACTIVE', 1, '-'),
       (862, 'uchutikan', '0', 'uchutikan', '<div class="word--description">             <span class="word--fonetic">[učutikan]</span>              <p class="word--description">s. (mit.) amz. ser mí- tico. Tamya punchakuna hatun yura ankuku- napi makanawan takashpa purik supay.
Machashka purikpika uchutikanmi rikurin. uchuna</p>          </div>', 'ACTIVE', 1, '-'),
       (863, 'uhu', '0', 'uhu', '<div class="word--description">             <span class="word--fonetic">[uxu]</span>              <p class="word--description">s. tos. Kunkata shikshichishpa hapik unkuy, kunka unkuy.
Kayka, uhu chinkachik hampimi kan. uhuna</p>          </div>', 'ACTIVE', 1, '-'),
       (864, 'uka', '0', 'uka', '<div class="word--description">             <span class="word--fonetic">[uka]</span>              <p class="word--description">s. oca. Mishki mashuwashina, allpa ukupi pukuk muyu.

Karuman rishpaka uka timputami kukayus- hpa apanchik.
ukku</p>          </div>', 'ACTIVE', 1, '-'),
       (865, 'ukllana', '0', 'ukllana', '<div class="word--description">             <span class="word--fonetic">[uglyana, ugžana]</span>              <p class="word--description">v. abrazar. Rikra- wan kunkapi, imapi kashpapash muyuchis- hpa hapiy.
Ñukapa warmitaka kuyaymanta ukllani.
2. empollar. Wawa pishkukuna llukshichun nishpa, lulunkunapa hawapi mama pishku- kuna siririy.
Ñukapa atallpaka chunka ishkay lulunta uk- llakun.
uksha</p>          </div>', 'ACTIVE', 1, '-'),
       (866, 'uku', '0', 'uku', '<div class="word--description">             <span class="word--fonetic">[ukhu, uku]</span>              <p class="word--description">adv. interior; debajo de.
Tukuy harkashka chawpipi sakirik.
Puñuna ukuka washaman sakirin.
2. s. cuarto. Wasikunapi pirkakunawan har- kashka kuchukuna.
Ñukapa kawsana ukuka kunukllami kan.
Sin. 2 Pitita, killi.
ukucha</p>          </div>', 'ACTIVE', 1, '-'),
       (867, 'ukumpi', '0', 'ukumpi', '<div class="word--description">             <span class="word--fonetic">[ukumbi]</span>              <p class="word--description">s. amz. culebra subterrá-
nea. Shuk killuwan, yanawan, pukawan hawirishka mana kanik machakuy.
Ukumpi machakuy rikurikpika mana man- charinachu kanchik.
ukun</p>          </div>', 'ACTIVE', 1, '-'),
       (868, 'ukunchina', '0', 'ukunchina', '<div class="word--description">             <span class="word--fonetic">[ukunčina, ukunči, ukunča]</span>              <p class="word--description">s. refajo, debajero. Ukuman churana ñutulla anaku.
Waynaka ukunchinata awakun.
ukuy</p>          </div>', 'ACTIVE', 1, '-'),
       (869, 'ullawanka', '0', 'ullawanka', '<div class="word--description">             <span class="word--fonetic">[ulyawaŋga, ilyawaŋga]</span>              <p class="word--description">s. galli- nazo. Ismu aychakunata mikuk, yana patpa- yuk pishku.
Ullawankakunaka ashnak ismushka aycha- kunata mikushpa anchuchin.
Sin. Ushku.
ullkana</p>          </div>', 'ACTIVE', 1, '-'),
       (870, 'ullu', '0', 'ullu', '<div class="word--description">             <span class="word--fonetic">[ulyu, užu]</span>              <p class="word--description">s. pene. Yumankapak, is- hpankapakpash kari charishka ankushina aycha.
Ullutaka rikurayanami kan.
uma</p>          </div>', 'ACTIVE', 1, '-'),
       (871, 'umana', '0', 'umana', '<div class="word--description">             <span class="word--fonetic">[umana]</span>              <p class="word--description">v. engañar, embobar. Pan- tata, mana kikintak, llullashpa rimay.
Hampi katuk runami umarka.
Sin. pantachiy.
umu</p>          </div>', 'ACTIVE', 1, '-'),
       (872, 'umutu', '0', 'umutu', '<div class="word--description">             <span class="word--fonetic">[umutu]</span>              <p class="word--description">adj. enano. Mana hatun wi-
ñashka runa.
Umutu runaka achkatami pukllak kan.
Sin. Hatak, antsala, uchilla.
unancha</p>          </div>', 'ACTIVE', 1, '-'),
       (873, 'unanchaywasi', '0', 'unanchaywasi', '<div class="word--description">             <span class="word--fonetic">[unančaywasi]</span>              <p class="word--description">s. colegio
secundario. Chunka pata yachashka kipa ya- chay wasi.
Ñukapa churika ñami unanchaywasiman rirka.

UPALLA
unay</p>          </div>', 'ACTIVE', 1, '-'),
       (874, 'unayana', '0', 'unayana', '<div class="word--description">             <span class="word--fonetic">[unayana, uniyana]</span>              <p class="word--description">v. demorarse, tardarse. Mayman rishpa achka pachata sa- kiriy.
¿Imamantatak achkata unayarkanki? unaylla</p>          </div>', 'ACTIVE', 1, '-'),
       (875, 'unaynik', '0', 'unaynik', '<div class="word--description">             <span class="word--fonetic">[unaynik]</span>              <p class="word--description">adv. hace un momento.
Mana yapa unaylla ninkapak shimi.
Paypa	wasiman	paktay	unaynikpimi shamurka.
Sin. Unaylla.
unku</p>          </div>', 'ACTIVE', 1, '-'),
       (876, 'unkurawa', '0', 'unkurawa', '<div class="word--description">             <span class="word--fonetic">[uŋgurawa]</span>              <p class="word--description">s. na. variedad de palmera. Chuntashina kashpapash kasha illak, achka yana muyuta aparik, muyuta, yu- yutapash mikuna, sachapi wiñak yura.
Akchata unkurawa wirawan armakpika su- maktami wiñan.
Sin. Shiwa.
unkushka</p>          </div>', 'ACTIVE', 1, '-'),
       (877, 'unkuy', '0', 'unkuy', '<div class="word--description">             <span class="word--fonetic">[uŋguy]</span>              <p class="word--description">s. enfermedad. Runakuna-
ta, wiwakunatapash ukkuta wakllichik nanay. Ñukapa wakrata unkuy hapishpa wañuchir- ka.
unkuna</p>          </div>', 'ACTIVE', 1, '-'),
       (878, 'upa', '0', 'upa', '<div class="word--description">             <span class="word--fonetic">[upa]</span>              <p class="word--description">adj. mudo, bruto, idiota. Shuk mana rimak runa.
Yaya kashpa, mama kashpapash unkuywan kakpika wawaka upami wacharin.
upalla</p>          </div>', 'ACTIVE', 1, '-'),
       (879, 'upallana', '0', 'upallana', '<div class="word--description">             <span class="word--fonetic">[upalyana, upažana]</span>              <p class="word--description">v. callarse.
Mana rimana.
Ima yuyaykunata rimashkata alli hamutanka- pakka upallanchik.
Sin. Chunyana.
upayana</p>          </div>', 'ACTIVE', 1, '-'),
       (880, 'upina', '0', 'upina', '<div class="word--description">             <span class="word--fonetic">[upina]</span>              <p class="word--description">v. ss. copular, hacer el amor, tener relaciones sexuales. Kariwan warmi- wan yumanakuy.
Warmi unkushka kakpimi mana upirkanichu.
Sin. Yukuna, yumana.
uputinti</p>          </div>', 'ACTIVE', 1, '-'),
       (881, 'upyanayana', '0', 'upyanayana', '<div class="word--description">             <span class="word--fonetic">[upyanayana, upinayana]</span>              <p class="word--description">v. tener sed, tener ganas o deseos de beber algo. Ñukanchikpa aycha yakunayay.
Pukllashpa shaykushka kipaka yakuta upya- nayan.
upyana</p>          </div>', 'ACTIVE', 1, '-'),
       (882, 'uray', '0', 'uray', '<div class="word--description">             <span class="word--fonetic">[uray, ura, uri, urin]</span>              <p class="word--description">adv. abajo. Hawa-
manta allpaman sakirik, urku umamanta urku chakiman sakirik.
Kikinpa tarpuna allpaka uray waykupimi sa- kirin.
2. s. declive. Ima pampapash waykuman sirik.
Ñukapa ayllullaktaka uray allpami kan. urayana</p>          </div>', 'ACTIVE', 1, '-'),
       (883, 'uraykuna', '0', 'uraykuna', '<div class="word--description">             <span class="word--fonetic">[uraykuna, urayguna, urayxuna, urikuna, urixuna, uriguna, igruna]</span>              <p class="word--description">v. bajar, descender, apearse. Hawamanta, patakuna- manta, wiwakunamantapash allpaman sha- yariy.
Payka, Quito llaktamanta apiwpi shamushpa, shaykushka uraykun.
Sin. Urayana.
uray sinka</p>          </div>', 'ACTIVE', 1, '-'),
       (884, 'uritu', '0', 'uritu', '<div class="word--description">             <span class="word--fonetic">[uritu]</span>              <p class="word--description">s. amz. lora. Waylla patpayuk, uritu uritu nishpa kaparik arawshina hatun pishku.
Uritu pishkuka sumaktami paypa shutita ta- kishpa yurapi tiyakun.
urku</p>          </div>', 'ACTIVE', 1, '-'),
       (885, 'urmarina', '0', 'urmarina', '<div class="word--description">             <span class="word--fonetic">[urmarina]</span>              <p class="word--description">v. tu. decaerse, mar- chitarse. Wañunalla, champayashka tukuy; yurakuna wañuriy.
Kay sisakunaka yaku illaymanta urmarishka.
2. tu. avergonzarse. Pinkaymanta ñawi pu- kayay, uma kumurishpa sakiriy.
Llulla runaka tukuyta chimpapurakpika urma- rirka.
Sin. 1 Wañurina, ankuyana, champayana; 2 pinkarina.
urmana</p>          </div>', 'ACTIVE', 1, '-'),
       (886, 'urpi', '0', 'urpi', '<div class="word--description">             <span class="word--fonetic">[urpi, urpay]</span>              <p class="word--description">s. tórtola. Uchpa patpayuk, puka chakiyuk, allpata purik, hawatapash pa- wak pishku.
Puna suyupika ñawpakunaka illapawanmi
urpikunataka hapikkuna karka.
uru</p>          </div>', 'ACTIVE', 1, '-'),
       (887, 'usa', '0', 'usa', '<div class="word--description">             <span class="word--fonetic">[usa]</span>              <p class="word--description">s. piojo. Mana armakpika akchapi




kawsak, pilisshina mirarik.
Wamrapa umapika ñami usa huntashka. usana</p>          </div>', 'ACTIVE', 1, '-'),
       (888, 'ushay', '0', 'ushay', '<div class="word--description">             <span class="word--fonetic">[ušay]</span>              <p class="word--description">v. poder, ser capaz de... Ima llamkaytapash rurayta utipana.
Allpata wachuy punchapika minkata ruray
ushanchik.
ushku</p>          </div>', 'ACTIVE', 1, '-'),
       (889, 'ushpitu', '0', 'ushpitu', '<div class="word--description">             <span class="word--fonetic">[ušpitu]</span>              <p class="word--description">s. amz. variedad de ve- nado. Uchpa millmayuk uchilla taruka.
Ushpitu wiwaka sacha ukullapimi kawsan. Sin. Taruka.
ushu</p>          </div>', 'ACTIVE', 1, '-'),
       (890, 'ushukullin', '0', 'ushukullin', '<div class="word--description">             <span class="word--fonetic">[ušukulyin]</span>              <p class="word--description">s. na. variedad de
culebra. Pala aychayuk, ismu panka ukupi sirik millay machakuy.
Ushukullin kanikpika wañunallami kan.
Sin. Pushllu.
ushun</p>          </div>', 'ACTIVE', 1, '-'),
       (891, 'ushushi', '0', 'ushushi', '<div class="word--description">             <span class="word--fonetic">[ušuši, uši]</span>              <p class="word--description">s. hija. Yaya, mamapa warmi wawa.
Kanpa ushushika kunan punchakunaka hatun pushak warmimi tukushka.
ushuta</p>          </div>', 'ACTIVE', 1, '-'),
       (892, 'uspun', '0', 'uspun', '<div class="word--description">             <span class="word--fonetic">[uspun, puzun, pusun]</span>              <p class="word--description">s. s. panza. Runa wiksapi, wiwa wiksakunapi tiyak mikus- hka tantarina hatun chunchulli.
Wakra uspunta yanunkapak rantiklla rini.
Sin. pusun.
usturiw</p>          </div>', 'ACTIVE', 1, '-'),
       (893, 'usuchina', '0', 'usuchina', '<div class="word--description">             <span class="word--fonetic">[usučina]</span>              <p class="word--description">v. amz. derrochar, des- perdiciar. Achka murukuna pukukpi mana wakaychishpa usu usu mikuy.
Achka muru pukukpika ama usuchinkichu. usun</p>          </div>', 'ACTIVE', 1, '-'),
       (894, 'usuna', '0', 'usuna', '<div class="word--description">             <span class="word--fonetic">[usuna]</span>              <p class="word--description">v. amz. abundar. Muyukuna, mikunakuna, churanakuna, imakunapash achka tiyay, achka tukuy.
Ñukapa chakrapi achka palantami usukun.
Sin. kamana, nanakllakana.
usu usu</p>          </div>', 'ACTIVE', 1, '-'),
       (895, 'pacha', '0', 'pacha', '<div class="word--description">             <span class="word--fonetic">[usyay pača]</span>              <p class="word--description">s. verano. Rupay killakunami kan. Tamyaka manallatak tiyanchu.
Usyay pachapimi murukunata pallanchik.
Sin. Inti pacha.
utipana</p>          </div>', 'ACTIVE', 1, '-'),
       (896, 'utka', '0', 'utka', '<div class="word--description">             <span class="word--fonetic">[utka, uxta, ugta, utixa, utya, uča]</span>              <p class="word--description">adv. rápido, pronto, breve, apurado. Mana una- yay, wayrashina imatapash ruray.
Ñalla tamyanka, wasiman utka shamuy.
Sin. Ninanta.
utkana</p>          </div>', 'ACTIVE', 1, '-'),
       (897, 'utku', '0', 'utku', '<div class="word--description">             <span class="word--fonetic">[utku]</span>              <p class="word--description">s. algodón. Yurak millmashina, yurapi pukuk, puchkashpa churanakunata awana yura millma.
Utku churanakunami ñukanchikpa ukkun- pakka alli kan.
uturunku</p>          </div>', 'ACTIVE', 1, '-'),
       (898, 'uya', '0', 'uya', '<div class="word--description">             <span class="word--fonetic">[uya]</span>              <p class="word--description">s. ss. cara, rostro, faz. Runaku- napa, wiwakunapapash ñawipi, ñawpa kak. Urmashpami uyata chukrirkani.
uyana</p>          </div>', 'ACTIVE', 1, '-'),
       (899, 'wachansu', '0', 'wachansu', '<div class="word--description">             <span class="word--fonetic">[wačaŋsu, wačaŋsi, ačaŋsu]</span>              <p class="word--description">s. amz. maní del monte. Hatun sacha yura, in- chikshina muyuta aparik, chay muyu kam- chashpa mikuna.
Wachansu yurataka mana pitinachu. wacharina</p>          </div>', 'ACTIVE', 1, '-'),
       (900, 'wachana', '0', 'wachana', '<div class="word--description">             <span class="word--fonetic">[wačana]</span>              <p class="word--description">v. sns, amz. dar a luz, alumbrar; parir; poner huevos. Maykan war- mikuna wawata wiksa ukumanta llukshichiy. Kanpa paniwa ¿ñachu wawata wacharka? Sin. 1 pakarichina, mirachina.
wachi</p>          </div>', 'ACTIVE', 1, '-'),
       (901, 'wachi', '0', 'wachi', '<div class="word--description">             <span class="word--fonetic">[wači]</span>              <p class="word--description">s. amz. tejón. Suni ñañu sin- kayuk, achkapura purik, sacha wiwa.
Wachi purikukta rikuni.
wachu</p>          </div>', 'ACTIVE', 1, '-'),
       (902, 'wachuna', '0', 'wachuna', '<div class="word--description">             <span class="word--fonetic">[wačuna]</span>              <p class="word--description">s. surcar, hacer surcos.
Allpapi yapushka shuk ñanshinata ruray. Sarata tarpunkapak ka wachunchik.
Sin. Rawana.
waka</p>          </div>', 'ACTIVE', 1, '-'),
       (903, 'waka', '0', 'waka', '<div class="word--description">             <span class="word--fonetic">[waka]</span>              <p class="word--description">s. lugar u objeto sagrado, tumba antigua, dios familiar. Ñawpa pachapi wañushka apukunata pampana ukukuna.
Ñawpa yayakunaka wakapimi Pachakamak- taka mañak karka.
wakamayu</p>          </div>', 'ACTIVE', 1, '-'),
       (904, 'wakar', '0', 'wakar', '<div class="word--description">             <span class="word--fonetic">[wakar]</span>              <p class="word--description">s. garza. Sunilla yuraklla kunkayuk kultashina pishku.
Wakarkunaka kucha manyapi purin. wakarina</p>          </div>', 'ACTIVE', 1, '-'),
       (905, 'wakana', '0', 'wakana', '<div class="word--description">             <span class="word--fonetic">[wakana, waxana]</span>              <p class="word--description">v. llorar. Llaki- manta, nanaymanta ñawimanta wiki talliriy. Wawaka nanaymantami achka wakarka.
2. v. emitir voces o sonidos los animales. Wi- wakunapa kapariy.
Wakrami achkata wakarka.
wakayana</p>          </div>', 'ACTIVE', 1, '-'),
       (906, 'wakaychina', '0', 'wakaychina', '<div class="word--description">             <span class="word--fonetic">[wakayčina, wakičina]</span>              <p class="word--description">v. guar- dar, ahorrar, conservar. Mikuna kakpi, kullki kakpi, imatapash kipa punchakunapak nis- hpa allichiy.
Kay papa muyuta tarpunkapakmi wakaychi-
kuni.
Sin. Allichina.
wakcha</p>          </div>', 'ACTIVE', 1, '-'),
       (907, 'wakin', '0', 'wakin', '<div class="word--description">             <span class="word--fonetic">[wakin]</span>              <p class="word--description">det. algún, -no, -a. Ashalla kashkata achiklla rikuchik. Wakin wawaka mana unkushkachu.
wakllichina</p>          </div>', 'ACTIVE', 1, '-'),
       (908, 'wakllina', '0', 'wakllina', '<div class="word--description">             <span class="word--fonetic">[waglyina, wagžana, waglina]</span>              <p class="word--description">v. dañar Imapash alli kashkamanta kipa mana alli tukuy.
¿Ima nishpatak wakllirikunki?
Sin. Challana.
wakra</p>          </div>', 'ACTIVE', 1, '-'),
       (909, 'waksa', '0', 'waksa', '<div class="word--description">             <span class="word--fonetic">[waxsa, wagza]</span>              <p class="word--description">s. variedad de lagar-
tija. Shuk hatun raku palu.
Wawaka waksa paluwanmi mancharirka. waktarina</p>          </div>', 'ACTIVE', 1, '-'),
       (910, 'waktaway', '0', 'waktaway', '<div class="word--description">             <span class="word--fonetic">[waxtaway, wastawi]</span>              <p class="word--description">s. amz. ga- vilán que se alimenta de culebras. Waktaway waktaway nishpa kaparik anka, machakuyta mikushpa kawsak.
Waktawayka machakuytami mikukun. waktana</p>          </div>', 'ACTIVE', 1, '-'),
       (911, 'waku', '0', 'waku', '<div class="word--description">             <span class="word--fonetic">[waku]</span>              <p class="word--description">s. amz. variedad de garrapata pequeña. Uchilla añankushina aychapi lluta-


rishpa yawarta chumkak.
Ñukapa chankapi waku llutarishka.
Sin. Tillimanku.
wakuyashka</p>          </div>', 'ACTIVE', 1, '-'),
       (912, 'wal', '0', 'wal', '<div class="word--description">             <span class="word--fonetic">[wal]</span>              <p class="word--description">s. amz. variedad de pez grande
con dientes, similar al bocachico. Kiruyuk hatun challwa.
Kayna punchaka wal kusashkata mikurkani.
Sin. Kiruyuk.
wala</p>          </div>', 'ACTIVE', 1, '-'),
       (913, 'wala', '0', 'wala', '<div class="word--description">             <span class="word--fonetic">[wala]</span>              <p class="word--description">s. sc. surcos muy apegados.
Llutariklla wachukunata rurashka.
Wala wachuta allichikuni.
Sin. waru.
walak</p>          </div>', 'ACTIVE', 1, '-'),
       (914, 'walampariw', '0', 'walampariw', '<div class="word--description">             <span class="word--fonetic">[walambariu, walaŋbariu]</span>              <p class="word--description">s. im. (mit.) tipo de arco iris, ser mítico referente a la sexualidad. Pakchakunapi tiyak kuychis- hina, warmikunata hapishpaka wiksayuk sakik; karikunata hapishpaka shikshi unkuyta hapichik aya.
Kakakunapi, pakchakunapipash walampa- riwtaka rikurkanchik.
walinyana</p>          </div>', 'ACTIVE', 1, '-'),
       (915, 'wallinku', '0', 'wallinku', '<div class="word--description">             <span class="word--fonetic">[walliŋku]</span>              <p class="word--description">s. s. conejo. Shuk llak- takunapi kunu shutiwan riksishka wiwa.
Wallinkuta sumakta kusashpa mikurkanchik.
Sin. Kunu.
wallka</p>          </div>', 'ACTIVE', 1, '-'),
       (916, 'wallpa', '0', 'wallpa', '<div class="word--description">             <span class="word--fonetic">[walypa, wašpa]</span>              <p class="word--description">s. ss. gallina. Ayl- luwan kawsak, kishapi lulunta wachak hatun




pishku.
Kullkiyukman mana wallpata kurkanichu.
Sin. Atallpa.
wallu</p>          </div>', 'ACTIVE', 1, '-'),
       (917, 'waluk', '0', 'waluk', '<div class="word--description">             <span class="word--fonetic">[walux]</span>              <p class="word--description">adj. ropa sucia. Mapayashka
churanakuna.
Waluk churanaka unkuytami katichin. walun</p>          </div>', 'ACTIVE', 1, '-'),
       (918, 'walun', '0', 'walun', '<div class="word--description">             <span class="word--fonetic">[walun, walu]</span>              <p class="word--description">s. sn. charco. Allpapi kuchashina yaku tantarishka.
Kuchikunaka walunpimi sinkurin.
2. sn. remanso. Mana sinchita purik yaku.
Walun yakuta purimuni.
Sin. 1 hita, kucha, punza; 2 tuyaka. wamak</p>          </div>', 'ACTIVE', 1, '-'),
       (919, 'waman', '0', 'waman', '<div class="word--description">             <span class="word--fonetic">[waman, guaman]</span>              <p class="word--description">s. gavilán, hal- cón. Shuk atallpashina hatun pishku, mallta chuchita, urpita mikuk. Shuk llaktakunapika anka shutiyukmi.
Waman chuchita ama mikuchun kaparinki. wamintsi</p>          </div>', 'ACTIVE', 1, '-'),
       (920, 'wampu', '0', 'wampu', '<div class="word--description">             <span class="word--fonetic">[wambu]</span>              <p class="word--description">s. barco. yakuta, mayuta purina.
Puna runakunaka wampukunapi purik karka. wampula</p>          </div>', 'ACTIVE', 1, '-'),
       (921, 'wampuna', '0', 'wampuna', '<div class="word--description">             <span class="word--fonetic">[wambuna, waŋbuna]</span>              <p class="word--description">v. s. nave- gar, nadar, flotar. Runa kashpa, ima kashpa- pash yaku hawapi chutariy.
Hatun yakupi wampurkani.
2. volar. Ima pishkukuna, ankakuna hawata paway.
Chay yuramantaka ñami pishkuna wam- purka.
Sin. 1 waytana; 2 pawana.
wamra</p>          </div>', 'ACTIVE', 1, '-'),
       (922, 'wanaku', '0', 'wanaku', '<div class="word--description">             <span class="word--fonetic">[wanaku]</span>              <p class="word--description">s. s. variedad de llama.
Chantazushina, llamashina wiwa. Perumanta shuk wanakuta apamuni. wanchaka</p>          </div>', 'ACTIVE', 1, '-'),
       (923, 'wanka', '0', 'wanka', '<div class="word--description">             <span class="word--fonetic">[waŋka]</span>              <p class="word--description">s. palanca. Tankana kaspi. Wasi kaspita wantunkapak wankakunata markamukmi rini.
2. amz. bastón o remo para impulsar canoas. Tawnarishpa wampupi tankashpa purina kaspi.
Wamputa wankawan tankashun.
Sin. 1 tula, 2 tawna.
wankana</p>          </div>', 'ACTIVE', 1, '-'),
       (924, 'wankar', '0', 'wankar', '<div class="word--description">             <span class="word--fonetic">[waŋkar]</span>              <p class="word--description">s. tambor. Piruru kaspipi wiwa karata pillushka, takinkapak	wik- sashina rikurik.
Wankarpi takishpa tushunchik.
wankana</p>          </div>', 'ACTIVE', 1, '-'),
       (925, 'wanku', '0', 'wanku', '<div class="word--description">             <span class="word--fonetic">[waŋgu]</span>              <p class="word--description">s. atado, carga. Imatapash
watashpa kipishinata rurashka. Wasichinkapak sacha panka wankuta rurani. wankurina</p>          </div>', 'ACTIVE', 1,
        '-'),
       (926, 'wankuna', '0', 'wankuna', '<div class="word--description">             <span class="word--fonetic">[waŋguna]</span>              <p class="word--description">v. atar, amarrar, liar.
Imakunatapash pillushpa watay. Raku kulluta yantapak wankurkani. Sin. Tsutsukina, sipuna.
wanlla</p>          </div>', 'ACTIVE', 1, '-'),
       (927, 'wanllana', '0', 'wanllana', '<div class="word--description">             <span class="word--fonetic">[waŋlyana, waŋžana]</span>              <p class="word--description">v. guardar comida	para	llevar.	Mashipa	wasipi karakushka sumak mishki mikunata wasiman apay.
Sisa tiyaka atallpa raku aychata churiman
wanllamurka.
wantuk</p>          </div>', 'ACTIVE', 1, '-'),
       (928, 'shimi', '0', 'shimi', '<div class="word--description">             <span class="word--fonetic">[waŋtug šimi]</span>              <p class="word--description">adj. labio lep- orino Llikirishka shimi wacharik wawa.
Kay wawaka wantukshimi wacharirka, ku- nanka ñami alliyashka.
Sin. Waka.
wantuna</p>          </div>', 'ACTIVE', 1, '-'),
       (929, 'wanu', '0', 'wanu', '<div class="word--description">             <span class="word--fonetic">[wanu]</span>              <p class="word--description">s. abono. Tukuy wiwakunapa isma.
Yapushkapi churankapak wanuta ñutukuni. waña</p>          </div>', 'ACTIVE', 1, '-'),
       (930, 'uchina', '0', 'uchina',
        '<div class="word--description">             <span class="word--fonetic">[wañučina, wančina]</span>              <p class="word--description">v. matar, asesinar. Pikunatapash kawsayta kichuy. An- tawa llapishpa allkutaka wañuchirka. wañurina</p>          </div>',
        'ACTIVE', 1, '-'),
       (931, 'ushka', '0', 'ushka', '<div class="word--description">             <span class="word--fonetic">[wañuška]</span>              <p class="word--description">adj. s. mortecina.
Runapash, wiwapash kawsayta mana charik.
Ushkukuna wañushka wakrata mikurka.
2. muerto, difunto, cadáver. Kawsay illak. Unkuywan wañushka wiwataka mana miku- nachu.
Sin. 1 ismu; 2 aya.
wañuna</p>          </div>', 'ACTIVE', 1, '-'),
       (932, 'uy', '0', 'uy', '<div class="word--description">             <span class="word--fonetic">[wañuy]</span>              <p class="word--description">s. muerte. kawsay pitirik pacha.
Wañuyka tukuy kawsakkunapak chayan.
Sin. pitiriy.
wapsi</p>          </div>', 'ACTIVE', 1, '-'),
       (933, 'wara', '0', 'wara', '<div class="word--description">             <span class="word--fonetic">[wara]</span>              <p class="word--description">s. pantalón. Siki tullumanta chakikama ishkay tutuyuk churana.
Inka pachapika warata churankapakka wa- rachikuy raymita rurak kashka.
warak warak</p>          </div>', 'ACTIVE', 1, '-'),
       (934, 'waranka', '0', 'waranka', '<div class="word--description">             <span class="word--fonetic">[waraŋga]</span>              <p class="word--description">num. mil. Chunka
kutin patsakyashka.
Waranka kullkita mana charinichu, chay- manta mana rantinipashchu.
waranku</p>          </div>', 'ACTIVE', 1, '-'),
       (935, 'warapu', '0', 'warapu', '<div class="word--description">             <span class="word--fonetic">[warapu]</span>              <p class="word--description">s. jugo fermentado de


Wasipunku allpatalla charini.

WAWA

caña de azúcar Pukuchishka puskuk wiru yaku.
Minkapi warapu yakuta upyashkani. warkuna</p>          </div>', 'ACTIVE', 1, '-'),
       (936, 'warma', '0', 'warma', '<div class="word--description">             <span class="word--fonetic">[wama]</span>              <p class="word--description">adj. adolescente, mucha- cho. Sukta watayukmanta, chunka ishkay watayukkama runa.
Chay warmaka ñami sawariyta munan.
Sin. Mara, wamra.
warmi</p>          </div>', 'ACTIVE', 1, '-'),
       (937, 'waru', '0', 'waru', '<div class="word--description">             <span class="word--fonetic">[waru]</span>              <p class="word--description">s. sc. surcos muy apegados. Llutariklla wachukunata rurashka.
Waru wachuta allichikuni.
Sin. wala.
warwar</p>          </div>', 'ACTIVE', 1, '-'),
       (938, 'was', '0', 'was', '<div class="word--description">             <span class="word--fonetic">[was]</span>              <p class="word--description">interj. amz. hojas y yerbas rese- cas convertible en polvo. Kiwakuna, wayta- kuna, pankakunapash sumakta intipi chakirishkata ninkapak rimay.
Chakirishka pankata hapirikpi was nin. washa</p>          </div>', 'ACTIVE', 1, '-'),
       (939, 'washakuna', '0', 'washakuna', '<div class="word--description">             <span class="word--fonetic">[wašakuna]</span>              <p class="word--description">v. sumergirse, hundirse. Maymanpash urmay.
Chantazuka waykuman washakushka.
Sin. Matuyana.
wasi</p>          </div>', 'ACTIVE', 1, '-'),
       (940, 'wasipunku', '0', 'wasipunku', '<div class="word--description">             <span class="word--fonetic">[wasipuŋku]</span>              <p class="word--description">s. s. retazo de tie- rra entregada a los trabajadores por prestar servicios en las haciendas. Hatun allpayuk- man llankashkamanta, shuk runaman karas- hka uchilla allpa.

waska</p>          </div>', 'ACTIVE', 1, '-'),
       (941, 'waska', '0', 'waska', '<div class="word--description">             <span class="word--fonetic">[waska]</span>              <p class="word--description">s. amz. bejuco. Tukuy sachapi rikurik ankukuna.
Kay waskataka sachamanta apamuni.
Sin. Anku.
wata</p>          </div>', 'ACTIVE', 1, '-'),
       (942, 'watawata', '0', 'watawata', '<div class="word--description">             <span class="word--fonetic">[watawata]</span>              <p class="word--description">s. amz. salaman- quesa Mawka wasikunapi kawsak tsalakulun tupu uchpa karayuk hayampishina.
Chay shitashka wasipika manchanayakta
watawataka mirashka.
watana</p>          </div>', 'ACTIVE', 1, '-'),
       (943, 'watu', '0', 'watu', '<div class="word--description">             <span class="word--fonetic">[watu]</span>              <p class="word--description">s. s. cordel, cadena. Imatapash
watankapak ñañu waskashina rurashka. Wawa kuchita watankapak shuk watuta apa- munki.
2. ss. especie de pretina. Anakupi, shuktak churanakunapipash sirashka, chumpishina watarinkapak kak.
Chumpi watupi kupa aparishka.
watu</p>          </div>', 'ACTIVE', 1, '-'),
       (944, 'waturitu', '0', 'waturitu', '<div class="word--description">             <span class="word--fonetic">[waturitu]</span>              <p class="word--description">s. amz. pavo nocturno. Punchayakpi titiri titiri kaparik hatun sacha pishku.
Waturituka tukuy tutami pawashpa purin.
Sin. Muntiti.
watuna</p>          </div>', 'ACTIVE', 1, '-'),
       (945, 'wawa', '0', 'wawa', '<div class="word--description">             <span class="word--fonetic">[wawa]</span>              <p class="word--description">s. niño, bebé. Wachashkalla runa.
Kanpa wawaka ¿ima shutiyuk kan?.



WAWA MAMA
2. adj. pequeño. Chayrak wiñakuk wamra, uchilla wamra, wiwapash.
Wawa llamata makimanta chutamuni.
Sin. 1. mara; 2 chusu, uchilla, hamchi. wawa mama</p>          </div>', 'ACTIVE', 1, '-'),
       (946, 'muyu', '0', 'muyu', '<div class="word--description">             <span class="word--fonetic">[wawa muyu]</span>              <p class="word--description">s. feto. Wiksa ukupi kawsay kak.
Wawamuyuka punchanta punchanta runa- man tukun.
wawa tiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (947, 'wawki', '0', 'wawki', '<div class="word--description">             <span class="word--fonetic">[wawki, wuki, wawke]</span>              <p class="word--description">s. hermano de hermano. Shuk mamamantallatak lluk- shishka kari churipura rimay.
Ñukaka chusku wawkiyukmi kani. wayaka</p>          </div>', 'ACTIVE', 1, '-'),
       (948, 'wayka', '0', 'wayka', '<div class="word--description">             <span class="word--fonetic">[wayka]</span>              <p class="word--description">det. s. aglomeración, tu- multo. Minkapi, makanakuypi tukuylla tanta- riy.
Wayka runaka wasi rurayta tukuchirka.
Sin. tantariy.
waykana</p>          </div>', 'ACTIVE', 1, '-'),
       (949, 'wayku', '0', 'wayku', '<div class="word--description">             <span class="word--fonetic">[wayku, wayko]</span>              <p class="word--description">s. quebrada, ba-
rranco Tuñirishpa uray pukru tukushka allpa.
Rumika waykuman urmarka.
waylla</p>          </div>', 'ACTIVE', 1, '-'),
       (950, 'aycha', '0', 'aycha', '<div class="word--description">             <span class="word--fonetic">[waylya aycha]</span>              <p class="word--description">s. col. Winku sinchilla pankayuk yuyu.
Rupariypika waylla aycha pankata churan. wayna</p>          </div>', 'ACTIVE', 1, '-'),
       (951, 'wayra', '0', 'wayra', '<div class="word--description">             <span class="word--fonetic">[wayra]</span>              <p class="word--description">s. viento. Sinchita pukuk samay.
Kunuk wayrawan pukllani.
wayra apamushka</p>          </div>', 'ACTIVE', 1, '-'),
       (952, 'pacha', '0', 'pacha', '<div class="word--description">             <span class="word--fonetic">[wayra pača]</span>              <p class="word--description">s. otoño. Yura- kunamanta pankakuna urmana pacha.
Kishwar pankaka wayra pacha kakpimi ur- marka.
wayrana</p>          </div>', 'ACTIVE', 1, '-'),
       (953, 'wayru', '0', 'wayru', '<div class="word--description">             <span class="word--fonetic">[wayru]</span>              <p class="word--description">s. hueso de juego en vela- ciones. Wañushkakunapi pukllankapak llak- llashka tullu.
Sarun pachapika wayruwanmi pukllashka- kuna.
wayta</p>          </div>', 'ACTIVE', 1, '-'),
       (954, 'waytana', '0', 'waytana', '<div class="word--description">             <span class="word--fonetic">[waytana]</span>              <p class="word--description">v.   nadar.   Rikrata,
chakita kuyuchishpa yakuta chimpay. Wampu illakpimi hatun mayuta waytarkani. Sin. Wampuna.
wayunka</p>          </div>', 'ACTIVE', 1, '-'),
       (955, 'wayunkana', '0', 'wayunkana', '<div class="word--description">             <span class="word--fonetic">[wayungana, wayuŋgina]</span>              <p class="word--description">v. s.
estar, colgado. Tinkishpa warkurayachiy. Wawakunaka tukuy punchami kapuli yurapi wayunkan.
wayuri</p>          </div>', 'ACTIVE', 1, '-'),
       (956, 'wazik', '0', 'wazik', '<div class="word--description">             <span class="word--fonetic">[wazix]</span>              <p class="word--description">s. sc. instrumento para peda- cear la cabuya. Chawarta chillpinkapak, wakra chaki tullumanta rurashka hillay.




Chawar pankata wazikwan chillpirka. wazikina</p>          </div>', 'ACTIVE', 1, '-'),
       (957, 'wichayana', '0', 'wichayana', '<div class="word--description">             <span class="word--fonetic">[wičayana, wičiyana, bitsyana, ičiyana]</span>              <p class="word--description">v. subir, ascender. Hawaman sikay. Yachakukkunaka urkuman wichayarka.
Sin. Sikana.
wichi</p>          </div>', 'ACTIVE', 1, '-'),
       (958, 'wichkana', '0', 'wichkana', '<div class="word--description">             <span class="word--fonetic">[wičkana, wičikana, wiškana, wičana, bičana, ičkana]</span>              <p class="word--description">v. cerrar, encerrar. Ama llukshichun, ama yaykuchun nishpa punkukunata, hutkukunata imawanpash har- kay.
Hillu misita manka ukupi wichkarka. wichu</p>          </div>', 'ACTIVE', 1, '-'),
       (959, 'wichu', '0', 'wichu', '<div class="word--description">             <span class="word--fonetic">[wiču]</span>              <p class="word--description">s. amz. perico. Waylla millma- yuk, wichu wichu wichu nisha kaparik yapa uchilla pishku.
Llullu wichuta yuramanta hapini.
Sin. ichu, chuki.
wiki</p>          </div>', 'ACTIVE', 1, '-'),
       (960, 'wikiyana', '0', 'wikiyana', '<div class="word--description">             <span class="word--fonetic">[wikiyama]</span>              <p class="word--description">v. lagrimear. Runapa,
wiwapa ñawi urmay.
Ñawika allpa yaykushpa wikiyashka.
2. amz. mancharse. Churarina yura wikipi ya- nayay.
Ñukapa churanaka wikiyashka.
Sin. 2 Mapayana.
wiksa</p>          </div>', 'ACTIVE', 1, '-'),
       (961, 'wiksayuk', '0', 'wiksayuk', '<div class="word--description">             <span class="word--fonetic">[wigsayuk, bixsayux]</span>              <p class="word--description">adj. en
cinta, embarazada, preñada. Wiksa ukupi wawata charik, chichu warmi.

WIPALA
Wiksayuk warmika may alli mikunatami mi- kuna kan.
Sin. Chichu, unkunalla.
willak</p>          </div>', 'ACTIVE', 1, '-'),
       (962, 'willana', '0', 'willana', '<div class="word--description">             <span class="word--fonetic">[wilyana, wižana, bilyana, bižana]</span>              <p class="word--description">v. avisar, informar, advertir, declarar. Ima ya- chashkata shukman chimpachiy.
Churi rimashkata yayaman willarka.
willi willi</p>          </div>', 'ACTIVE', 1, '-'),
       (963, 'winkanas', '0', 'winkanas', '<div class="word--description">             <span class="word--fonetic">[wiŋkanas]</span>              <p class="word--description">s. amz. aletas de
pescado. Challwapa washapi, kunka sapipi wiñak, pala uchilla rikrashina.
Kay challwapa winkanastami kuchurkani.
Sin. Pimpis.
winku</p>          </div>', 'ACTIVE', 1, '-'),
       (964, 'achik', '0', 'achik', '<div class="word--description">             <span class="word--fonetic">[wiñačix, wiñačik, wiñačig, biñačix, iñačix]</span>              <p class="word--description">adj. adoptivo. Chikan wawata kikinpa churitashina kuyashpa hatunyachiy. Wiñachik yaya chayamun.
wiñachishka</p>          </div>', 'ACTIVE', 1, '-'),
       (965, 'ana', '0', 'ana', '<div class="word--description">             <span class="word--fonetic">[wiñana, biñana, iñana]</span>              <p class="word--description">v. crecer, desarrollarse; retoñar. Llullumanta hatunyas- hpa katiy.
Ñukapa churika mana unkuysiki kashpa ha- tunta wiñarka.
wiñakun.
wiñay</p>          </div>', 'ACTIVE', 1, '-'),
       (966, 'wipala', '0', 'wipala', '<div class="word--description">             <span class="word--fonetic">[wipala]</span>              <p class="word--description">s. bandera, emblema del
Tawantin suyu. Kanchis tullpuwan kuychishi- nata awashka.
Abya Yalapa unanchaka wipalami kan.


WIRA
Sin. Unancha.
wira</p>          </div>', 'ACTIVE', 1, '-'),
       (967, 'wirakchuru', '0', 'wirakchuru', '<div class="word--description">             <span class="word--fonetic">[wirakčuru, virakčuru]</span>              <p class="word--description">s. huirac churo. variedad de ave cantora. Killu patpa- yuk yana pishku, sumakta takik.
Tutamantakunaka wirak churu pishkuka su- maktami takin.
Sin. chuku.
wirakucha</p>          </div>', 'ACTIVE', 1, '-'),
       (968, 'wirakwirak', '0', 'wirakwirak', '<div class="word--description">             <span class="word--fonetic">[wirakwirax]</span>              <p class="word--description">interj. sc. grito in-
inteligible. Achka runakunapa kapariy. Upa runami wirakwirak rik uyarin.
wiriwiri</p>          </div>', 'ACTIVE', 1, '-'),
       (969, 'wirpa', '0', 'wirpa', '<div class="word--description">             <span class="word--fonetic">[wirpa]</span>              <p class="word--description">s. labio superior (ver sipri). Ri- makpi, mikukpi kuyurik hawa shimi kara.
Payka waku wirpatami charin.
wiru</p>          </div>', 'ACTIVE', 1, '-'),
       (970, 'wishina', '0', 'wishina', '<div class="word--description">             <span class="word--fonetic">[wišina, bišina, išina, wiša]</span>              <p class="word--description">s. cu- chara. Kallanamanta mikuna sankuta wishin- kapak rurashka.
Kaspi wishinata rantimuni.
wishinka</p>          </div>', 'ACTIVE', 1, '-'),
       (971, 'wishina', '0', 'wishina', '<div class="word--description">             <span class="word--fonetic">[wišina, bišina, išina]</span>              <p class="word--description">v. coger líqui- dos y granos. Murukunata, mikunata, ya- kuta, mulupi hapishpa churay.
Aswata pillchipi wishiy.
wisiyana</p>          </div>', 'ACTIVE', 1, '-'),
       (972, 'wistu', '0', 'wistu', '<div class="word--description">             <span class="word--fonetic">[wistu, wištu, wiksu, ]</span>              <p class="word--description">adj. encorvado; deforme de la boca, torcido, baldado. Ima- pash chulla chulla kak; patay pukru kakmi. Paypa shimika wistumi kan.
Sin. winku.
wistuna</p>          </div>', 'ACTIVE', 1, '-'),
       (973, 'wita', '0', 'wita', '<div class="word--description">             <span class="word--fonetic">[wita]</span>              <p class="word--description">s. amz. lugar lleno de maleza. Achka kiwayuk, kashayuk, ankukunayuk, uchilla yurakunayuk pampa.
Kayaka witaman risha nini.
witayana</p>          </div>', 'ACTIVE', 1, '-'),
       (974, 'wituk', '0', 'wituk', '<div class="word--description">             <span class="word--fonetic">[witux, itux]</span>              <p class="word--description">s. amz. árbol con fruto colorante para pintar la cara y el cabello.
Akchata yanayachinkapak, ñawita, rikrata shuyurinkapak yana yakuyuk muyu.
Pukllashpa wituwan ñawita yanayachini. wiwa</p>          </div>', 'ACTIVE', 1, '-'),
       (975, 'wiwana', '0', 'wiwana', '<div class="word--description">             <span class="word--fonetic">[wiwana, wibana, uyway]</span>              <p class="word--description">v. amz.
domesticar, amansar. Wiwata wasipi yacha- chiy.
Andréska wawa kushilluta wiwarka.






yachachik</p>          </div>', 'ACTIVE', 1, '-'),
       (976, 'yachachikuy', '0', 'yachachikuy', '<div class="word--description">             <span class="word--fonetic">[yačačikuy]</span>              <p class="word--description">s. educación. Ya- chaykunata riksichiy.
Kunan pachapika mushuk yachachikuytami katinchik.
yachak</p>          </div>', 'ACTIVE', 1, '-'),
       (977, 'yachakuk', '0', 'yachakuk', '<div class="word--description">             <span class="word--fonetic">[yačakux, yačakuk, yačakug, yačagux, yačaxuk, yačaxug]</span>              <p class="word--description">s. alumno, aprendiz, estudiante. Yachachikpa yachayta katik runa.
Chunka yachakukllami yachana wasimanka purinchik.
yachakuna</p>          </div>', 'ACTIVE', 1, '-'),
       (978, 'yachanawasi', '0', 'yachanawasi', '<div class="word--description">             <span class="word--fonetic">[yačanawasi]</span>              <p class="word--description">s. escuela. Killkayta, yupayta, shukkunatapash yacha- kunkapak ukukuna.
Killkata yachakunkapakka yachanawasiman rinami kanchik.
Sin. Yachay wasi.
yacharina</p>          </div>', 'ACTIVE', 1, '-'),
       (979, 'yachana', '0', 'yachana', '<div class="word--description">             <span class="word--fonetic">[yačana]</span>              <p class="word--description">v. saber. Imatapash rik-
siy, alli ruray.

Yupayta, mirachiyta, anchuchiytapash allita
yacharkani.
yachay</p>          </div>', 'ACTIVE', 1, '-'),
       (980, 'wasi', '0', 'wasi', '<div class="word--description">             <span class="word--fonetic">[yačaywasi]</span>              <p class="word--description">s. escuela. Kill- kayta, yupayta, shukkunatapash yachakun- kapak uku.
Killkata yachakunkapakka yachay wasiman rinami kanchik.
Sin. Yachana wasi.
yachik</p>          </div>', 'ACTIVE', 1, '-'),
       (981, 'yachina', '0', 'yachina', '<div class="word--description">             <span class="word--fonetic">[yačina]</span>              <p class="word--description">v. amz. saber a. Wakin mi-
kunakuna chay mikuy shinallatakmi kan nin- kapak rimay.
Yutu aychaka atallpa aychashina yachinmi. yakami</p>          </div>', 'ACTIVE', 1, '-'),
       (982, 'yaku', '0', 'yaku', '<div class="word--description">             <span class="word--fonetic">[yaku]</span>              <p class="word--description">s. agua, líquido. Tukuy kaw- sakkunapa upyana.
Yakuta upyashpami kawsanchik.
yaku (<*yaku) s. octubre. Chunkaniki killa. Yaku killapika, Inka pachapika, uma raymita, para mañaytapash rurashka.
yaku aycha</p>          </div>', 'ACTIVE', 1, '-'),
       (983, 'ishpana', '0', 'ishpana', '<div class="word--description">             <span class="word--fonetic">[yaku išpana]</span>              <p class="word--description">v. ss. orinar. Ukkunmanta llukshik mapayashka yaku.
Rupak yakuta upyashkamanta yaku-ishpa-
kun.
Sin. ishpana.
yaku ukucha</p>          </div>', 'ACTIVE', 1, '-'),
       (984, 'yakuyachina', '0', 'yakuyachina', '<div class="word--description">             <span class="word--fonetic">[yakuyačina]</span>              <p class="word--description">v. desleír, di- solver, diluír. Imata kashpapash yakuman ti- krachiy.
Kay rasuta yakuyachishun.
yalli</p>          </div>', 'ACTIVE', 1, '-'),
       (985, 'yallika', '0', 'yallika', '<div class="word--description">             <span class="word--fonetic">[yalyika]</span>              <p class="word--description">s. amz. bejuco para tejer canastos. Hatun yurakunamanta warkurimuk ashanka awana waska.
Yallikawan ashankata awani.
yallina</p>          </div>', 'ACTIVE', 1, '-'),
       (986, 'yami', '0', 'yami', '<div class="word--description">             <span class="word--fonetic">[yami, yakami]</span>              <p class="word--description">s. amz. variedad de ave
trompetero. Uchpa millmayuk, suni kunka- yuk, suni chakiyuk allpata purik hatun pishku. Yami pishkuka kaypi sachapimi kawsan. yana</p>          </div>',
        'ACTIVE', 1, '-'),
       (987, 'yana', '0', 'yana', '<div class="word--description">             <span class="word--fonetic">[yana]</span>              <p class="word--description">adj. ayudante, criado, servidor, sirviente. Imapipash yanapak runa.
Inkakunaka achka yana runata charik kashka. yanapana</p>          </div>', 'ACTIVE', 1, '-'),
       (988, 'yanapay', '0', 'yanapay',
        '<div class="word--description">             <span class="word--fonetic">[yanapay]</span>              <p class="word--description">s. ayuda, auxilio, coo- peración. Imapipash shukman rurayta kuy. Yanapayta munashpaka, kayawankilla. yana shunku</p>          </div>',
        'ACTIVE', 1, '-'),
       (989, 'yanka', '0', 'yanka', '<div class="word--description">             <span class="word--fonetic">[yaŋga]</span>              <p class="word--description">adv. gratuitamente, de balde. Imatapash mana rantina, imatapash mana kullkipak rurana.
Antonio mashika kayna chawpi tutamanta
yanka shuyakurka.


2. inservible, en vano. Imapakpash mana alli kak.
Kayka yankatakmi kaypi ñitkarikun.
Sin. 2 yankamanta, yankata. yankamanta</p>          </div>', 'ACTIVE', 1, '-'),
       (990, 'yankata', '0', 'yankata', '<div class="word--description">             <span class="word--fonetic">[yaŋgata]</span>              <p class="word--description">adv. de balde, en vano, sin motivo. Imamantapash yanka huchachiy tukuy.
Yankata ñukata piñawarkanki.
Sin. Yanka, yankamanta.
yanta</p>          </div>', 'ACTIVE', 1, '-'),
       (991, 'yantana', '0', 'yantana', '<div class="word--description">             <span class="word--fonetic">[yaŋdana]</span>              <p class="word--description">v. hacer leña, leñar, ir a
buscar leña. Shuk yurata shallishpa, chiktas- hpa ñutuyachiy. Yurakunamanta urmashka kaspikunata, pankakunata pallashpa ninapi churay.
Chakishka kapuli yurata yantani.
yanuna</p>          </div>', 'ACTIVE', 1, '-'),
       (992, 'yapa', '0', 'yapa', '<div class="word--description">             <span class="word--fonetic">[yapa]</span>              <p class="word--description">adv. demasiado, mucho, muy.
Yalli ninkapak shimi.
Yapa hillumi kanki.
2. s. vendaje. Rantishka hawapi ashtawan churay.
Kayka yapami kan.
Sin. 1 yalli, may, ninan.
yapachina</p>          </div>', 'ACTIVE', 1, '-'),
       (993, 'yapay', '0', 'yapay', '<div class="word--description">             <span class="word--fonetic">[yapay]</span>              <p class="word--description">s. suma. Chaypurallata shuk-
llapi tantachishpa mashna kashkata yachay. Yachachikka kay yapaykunata rurachun ma- ñarka.
yapana</p>          </div>', 'ACTIVE', 1, '-'),
       (994, 'yapuna', '0', 'yapuna', '<div class="word--description">             <span class="word--fonetic">[yapuna]</span>              <p class="word--description">v. s. arar. Muyukunata
tarpunkapak allpata sumakta allichina. Ñukapa wawkika paypa allpata yapurka. yarina</p>          </div>', 'ACTIVE', 1,
        '-'),
       (995, 'yarkay', '0', 'yarkay', '<div class="word--description">             <span class="word--fonetic">[yarkay, yarxay, yarikay, yarixiy]</span>              <p class="word--description">s. hambre. Runakunata, wiwakunata mikuna- yay hapiy.
Wawaka tukuy punchata yarkaywanmi kay- narka.
yarkana</p>          </div>', 'ACTIVE', 1, '-'),
       (996, 'yata', '0', 'yata', '<div class="word--description">             <span class="word--fonetic">[yata]</span>              <p class="word--description">s. terreno pisoteado de anima-
les, paredes de una casa abandonada. Wi- wakuna achkata sarushpa sakishka pampa, hichushka wasipa pirkakuna.
Mushuk wasita wasichinkapak yatata picha- kunchik.
yawar</p>          </div>', 'ACTIVE', 1, '-'),
       (997, 'yawari', '0', 'yawari', '<div class="word--description">             <span class="word--fonetic">[yawari]</span>              <p class="word--description">s. na. animal amazónico.
Sachapi kawsak wiwa. Ruku llaktapi yawari-
kuna tiyan.
yawar kicha</p>          </div>', 'ACTIVE', 1, '-'),
       (998, 'yawati', '0', 'yawati', '<div class="word--description">             <span class="word--fonetic">[yawati, tsawata]</span>              <p class="word--description">s. amz. tortuga terrestre y acuática. Sachapi, yaku ukupi- pash kawsak, charapashina rikurik, shuk llak- takunapi tsawata shutiyuk wiwa.
Kayna	chishika	yawati	aychata mikurkanchik.
Sin. Mutilun, tsawata.
yawati suyu</p>          </div>', 'ACTIVE', 1, '-'),
       (999, 'yawisun', '0', 'yawisun', '<div class="word--description">             <span class="word--fonetic">[yawisun]</span>              <p class="word--description">s. amz. variedad de pez.

YUPANA
Shuk yanawan killuwan tullpuyuk uchilla challwa.
Ñukapa yayaka yawisunkunatami mayupi hapirka.
yawri</p>          </div>', 'ACTIVE', 1, '-'),
       (1000, 'yaya', '0', 'yaya', '<div class="word--description">             <span class="word--fonetic">[yaya]</span>              <p class="word--description">s. papá, padre, tayta; semental.
Taytata ninkapak shimi.
Ñuka yaya rimashkata katirkani.
yaykuna</p>          </div>', 'ACTIVE', 1, '-'),
       (1001, 'yayu', '0', 'yayu', '<div class="word--description">             <span class="word--fonetic">[yayu]</span>              <p class="word--description">s. amz. variedad de pez. Shuk yana, raku challwa.
Raku yayutami kunanka hapishka. yayuna</p>          </div>', 'ACTIVE', 1, '-'),
       (1002, 'yuksi', '0', 'yuksi', '<div class="word--description">             <span class="word--fonetic">[yukzi]</span>              <p class="word--description">s. cc. arena fina. Wayrapi pa- wariklla allpa, yapa ñutu rumi allpa.
Mayu manyapimi yuksi allpaka tiyan.
Sin. Tiyu.
yukuna</p>          </div>', 'ACTIVE', 1, '-'),
       (1003, 'yumana', '0', 'yumana', '<div class="word--description">             <span class="word--fonetic">[yumana]</span>              <p class="word--description">v. s. hacer el amor, tener relaciones sexuales, copular. Shuk kari paypa ulluta warmipa rakapi satiy.
Machashka kashpaka mana yumanachu.
Sin. Upina, yukuna, rurana.
yunkarak</p>          </div>', 'ACTIVE', 1, '-'),
       (1004, 'yupay', '0', 'yupay', '<div class="word--description">             <span class="word--fonetic">[yupay]</span>              <p class="word--description">s. número. Imakunatapash
yupankapak killkashkakuna.
¿Ima yupaytatak killkana kanchik?. yupana</p>          </div>', 'ACTIVE', 1, '-'),
       (1005, 'yupaychana', '0', 'yupaychana', '<div class="word--description">             <span class="word--fonetic">[yupayčana]</span>              <p class="word--description">v. agradecer;
honrar. Shuk runa imatapash karakpi, sumak shimiwan rantipay.
Ñukata yanapashkamanta achkatami kan- taka yupaychani.
yupi</p>          </div>', 'ACTIVE', 1, '-'),
       (1006, 'yura', '0', 'yura', '<div class="word--description">             <span class="word--fonetic">[yura, yula, ruya]</span>              <p class="word--description">s. árbol, mata, planta, vegetal. Pankakunata charik kirukuna.
Kishwar llullu yurata tarpurkani.
yurak</p>          </div>', 'ACTIVE', 1, '-'),
       (1007, 'shunku', '0', 'shunku', '<div class="word--description">             <span class="word--fonetic">[yurak šunku]</span>              <p class="word--description">s. pulmón. Kawsakkunaman samayta chaskik.
Yurak shunkupi chiri ama yaykuchunka washata allitapacha killpanchik.
Sin. paruk, surkan.
yurimawas</p>          </div>', 'ACTIVE', 1, '-'),
       (1008, 'yutsu', '0', 'yutsu', '<div class="word--description">             <span class="word--fonetic">[yutsu]</span>              <p class="word--description">s. amz. árbol de corteza me- dicinal. Shuk ñañu pankayuk sumakta sisak, yaku manñapi wiñak raku yura, karaka ham- pimi kan.
Yutsupa karawanmi hampirkani.
yutu</p>          </div>', 'ACTIVE', 1, '-'),
       (1009, 'yuturi', '0', 'yuturi', '<div class="word--description">             <span class="word--fonetic">[yuturi, yutsuri]</span>              <p class="word--description">s. amz. hormiga conga. Hatun, yana, paypa sikipi tuksina sin- chi kashata charik, miyutapash charik añanku.
Mishki mikunapi yapatami yuturi wiwaka huntashka.
yuyak</p>          </div>', 'ACTIVE', 1, '-'),
       (1010, 'yuyarina', '0', 'yuyarina', '<div class="word--description">             <span class="word--fonetic">[yuyarina, yarina]</span>              <p class="word--description">v. acordarse, re- cordar. Kunkashkakunata yuyaywan mas- kashpa kawsachina.
Ñukapa warmitaka karumanta yuyarini.
4.	estar pensativo. lmakunapipash yuyashpa tiyay.
Imashina shamuk wata llamkanata yuya- rirkanchik.
yuyay</p>          </div>', 'ACTIVE', 1, '-'),
       (1011, 'yuyana', '0', 'yuyana', '<div class="word--description">             <span class="word--fonetic">[yuyana]</span>              <p class="word--description">v. pensar. Ama pantan-
kapak umawan taripashpa rurana.
Kan alli kashkamanta achkata yuyanki.
5.	suponer. Yuyarishpalla imatapash niy, rimay, rurana.
Paychari chaypi pakashka tantataka mikurka,
yuyani.
yuyaychinkana</p>          </div>', 'ACTIVE', 1, '-'),
       (1012, 'yuyayyuk', '0', 'yuyayyuk', '<div class="word--description">             <span class="word--fonetic">[yuyayyux, yuyayux]</span>              <p class="word--description">s. amz. pensante. Imatapash taripashka kipa, yuya- rishka kipa rimak runa.
Yuyayyukka mana wawashina imatapash ri- manachu.
Sin. Yuyak, shunkuyuk.
yuyu</p>          </div>', 'ACTIVE', 1, '-'),
       (1013, 'yuyuna', '0', 'yuyuna', '<div class="word--description">             <span class="word--fonetic">[yuyuna]</span>              <p class="word--description">v. amz. descogollar pal- meras. Chuntamanta, taraputumanta, ku- nampumanta, shiwamanta, chillimanta yuyuta mikunkapak surkuy.
Tukuy chuntatami yuyunkichik.





zakzikina</p>          </div>', 'ACTIVE', 1, '-'),
       (1014, 'zalan', '0', 'zalan', '<div class="word--description">             <span class="word--fonetic">[zalipa, lazipa]</span>              <p class="word--description">s. s. tipo de árbol. Hatun suni yura.
Zalan yurata rikurayani.
zalipa</p>          </div>', 'ACTIVE', 1, '-'),
       (1015, 'zalipana', '0', 'zalipana', '<div class="word--description">             <span class="word--fonetic">[zalipana, lazipana]</span>              <p class="word--description">v. s. transmi- tir la enfermedad zalipa. Zalipa unkuyta shuk wasiman apay.
Wawaka ñapash zalipakun.
zanzan</p>          </div>', 'ACTIVE', 1, '-'),
       (1016, 'zas', '0', 'zas', '<div class="word--description">             <span class="word--fonetic">[zas]</span>              <p class="word--description">adv. amz. de golpe, de pronto, mo-
mento menos pensado, rápido, sorpresiva- mente, en seguida, súbitamente. Kunkaymanta imatapash mana unayashpa ruray.
Chay warmika zaslla yakumanta shamus- hka.
Sin. Haykamanta, kunkaymanta. zimpunina</p>          </div>', 'ACTIVE', 1, '-'),
       (1017, 'zinzin', '0', 'zinzin', '<div class="word--description">             <span class="word--fonetic">[zinzin]</span>              <p class="word--description">adj. ss. resistencia que pone la persona al ser halada. Mana munakta ay- sakukpi sinchita shayariy.
Zinzin nishpa mana shamusha nirka. zinzin</p>          </div>', 'ACTIVE', 1, '-'),
       (1018, 'zipi', '0', 'zipi', '<div class="word--description">             <span class="word--fonetic">[zipi]</span>              <p class="word--description">s. ss. paspa. Aycha karata inti ru- pachikpi karachashina tukuy.
Zipi ñawita hampikunimi.
zirka</p>          </div>', 'ACTIVE', 1, '-'),
       (1019, 'zulayana', '0', 'zulayana', '<div class="word--description">             <span class="word--fonetic">[zulayana]</span>              <p class="word--description">v. ss. dañarse los fru- tos. Muyukuna yana tukushpa ismuriy, cha- kiriy.
Papa muyuka hukushpa zulayan.
Sin. Lanchana.
zullu</p>          </div>', 'ACTIVE', 1, '-'),
       (1020, 'zupu', '0', 'zupu', '<div class="word--description">             <span class="word--fonetic">[zupu]</span>              <p class="word--description">s. ss. chichón, chibolo. Runaku- napa, wiwakunapa umapi chupushina lluk- shik.
Yayapa umapika zupumi llukshishka.













zhapra</p>          </div>', 'ACTIVE', 1, '-'),
       (1021, 'zharpi', '0', 'zharpi', '<div class="word--description">             <span class="word--fonetic">[žarpi, žirpi, žarpi, žarpa]</span>              <p class="word--description">s. maíz de tusa fina con grano abundante. Achka muyu- yuk sara.
Zharpi sara apika mishkimi kan.
zharu</p>          </div>', 'ACTIVE', 1, '-'),
       (1022, 'zharu', '0', 'zharu', '<div class="word--description">             <span class="word--fonetic">[žaru]</span>              <p class="word--description">s. especie de arroz hecho de
maíz. Chamka sarashina.
Zharu apita mikunchik.
zhilik</p>          </div>', 'ACTIVE', 1, '-'),
       (1023, 'zhima', '0', 'zhima', '<div class="word--description">             <span class="word--fonetic">[žima, čima]</span>              <p class="word--description">adj. ss. Maíz perla. Yu- raklla pukalla sara.
Zhima saraka allita wiñan.
zhiripi</p>          </div>', 'ACTIVE', 1, '-'),
       (1024, 'zhiru', '0', 'zhiru', '<div class="word--description">             <span class="word--fonetic">[žiru]</span>              <p class="word--description">adj. ss. color gris. Ukillashina llimpi. Llama millmaka mapamanta zhirumi kan.
2. lana de oveja blanca y negra. Yanantin yu- raknintin llama millma.
Zhiru millmawan awakun.
zhuta</p>          </div>', 'ACTIVE', 1, '-'),
       (1025, 'yuyu', '0', 'yuyu', '<div class="word--description">             <span class="word--fonetic">[yuyu]</span>              <p class="word--description">s. s. verduras, yerbas comesti- bles; hortalizas. Mikuna kiwa.
Uka yuyuta kuyman karankapak apakllami rini.
2. cogollo comestible de las palmeras. Chun- takunapi, kiwakunapi llukshik mikuna llullu panka.
Chunta yuyuta pitishpa mikunata rurashun.
Sin. 1 kiwa.
yuyuna</p>          </div>', 'ACTIVE', 1, '-'),
       (1026, 'zakzikina', '0', 'zakzikina',
        '<div class="word--description">             <span class="word--fonetic">[zagzikina]</span>              <p class="word--description">s. bo. extenderse las guías de un bejuco o calabaza. Mallki anku- kunata pushay. Sapalluka ñami zaksikikun. zalan</p>          </div>',
        'ACTIVE', 1, '-'),
       (1027, 'zalipa', '0', 'zalipa', '<div class="word--description">             <span class="word--fonetic">[zalipa, lazipa]</span>              <p class="word--description">s. s. energía sexual negativa que causa enfermedad diarreica, no definida ni identificada por la medicina actual. Shuk kari, shuk warmi yumashpa wasiman ti- krakpi wawakunata, kuykunatapash unkuchik unkuy.
¿Wawaka zalipawanchu unkushka? zalipana</p>          </div>', 'ACTIVE', 1, '-'),
       (1028, 'zanzan', '0', 'zanzan', '<div class="word--description">             <span class="word--fonetic">[zaŋzan, saŋsaŋ]</span>              <p class="word--description">adj. ss. mujer de trabajo lento. Unayashpa llamkak warmi.
Zanzan warmi kashpami mana utka utka ya- nuyta ushanchu.
zas</p>          </div>', 'ACTIVE', 1, '-'),
       (1029, 'zimpunina', '0', 'zimpunina', '<div class="word--description">             <span class="word--fonetic">[zimbunina, ziŋbunina]</span>              <p class="word--description">v. sc. aglomerarse, conglomerarse. Runakuna taw-

kariy.
Hatun llaki tiyakpimi runakunaka zimpunirka.
Sin. waykana.
zinzin</p>          </div>', 'ACTIVE', 1, '-'),
       (1030, 'zinzin', '0', 'zinzin', '<div class="word--description">             <span class="word--fonetic">[zinzin]</span>              <p class="word--description">s. amz. dolor agudo por tu- mores, heridas, etc. Tuksikukpishina nanay. Ñukapa kunkuri zinzin nikun.
Sin. shikshik.
zipi</p>          </div>', 'ACTIVE', 1, '-'),
       (1031, 'zirka', '0', 'zirka', '<div class="word--description">             <span class="word--fonetic">[zirga, řizka, řirka]</span>              <p class="word--description">s.
ss. Árbol de cuya madera se fabrican cucha- ras. Mikuna wishinakunata, kallanakunata- pash rurana yura.
Zirka yuraka pukru ukupi wiñakun. zulayana</p>          </div>', 'ACTIVE', 1, '-'),
       (1032, 'zullu', '0', 'zullu', '<div class="word--description">             <span class="word--fonetic">[zulyu, žuyu,]</span>              <p class="word--description">s. amz. cigarra. Pakari- napi, inti punchakuna kaparik chillik.
Zulluka chay yurapi yaykun.
zupu</p>          </div>', 'ACTIVE', 1, '-'),
       (1033, 'zharpi', '0', 'zharpi', '<div class="word--description">             <span class="word--fonetic">[žarpi, žirpi, žarpi, žarpa]</span>              <p class="word--description">s. maíz de tusa fina con grano abundante. Achka muyu- yuk sara.
Zharpi sara apika mishkimi kan.
zharu</p>          </div>', 'ACTIVE', 1, '-'),
       (1034, 'zharu', '0', 'zharu', '<div class="word--description">             <span class="word--fonetic">[žaru]</span>              <p class="word--description">s. especie de arroz hecho de
maíz. Chamka sarashina.
Zharu apita mikunchik.
zhilik</p>          </div>', 'ACTIVE', 1, '-'),
       (1035, 'zhima', '0', 'zhima', '<div class="word--description">             <span class="word--fonetic">[žima, čima]</span>              <p class="word--description">adj. ss. Maíz perla. Yu- raklla pukalla sara.
Zhima saraka allita wiñan.
zhiripi</p>          </div>', 'ACTIVE', 1, '-'),
       (1036, 'zhiru', '0', 'zhiru', '<div class="word--description">             <span class="word--fonetic">[žiru]</span>              <p class="word--description">adj. ss. color gris. Ukillashina llimpi. Llama millmaka mapamanta zhirumi kan.
2. lana de oveja blanca y negra. Yanantin yu- raknintin llama millma.
Zhiru millmawan awakun.
zhuta</p>          </div>', 'ACTIVE', 1, '-');

INSERT INTO `dictionary_by_words` (`id`, `value`, `dictionary_grammatical_class_id`, `translation_value`, `description`,
                                   `status`, `diccionary_language_id`, `letters_of_the_alphabet`)
VALUES (1037, 'a cambio de', '0', 'a cambio de',
        '<div class="word--description">             <p class="word--description">adv. ranti, rantimpa.	acelerar, v. utkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1038, 'a continuación', '0', 'a continuación',
        '<div class="word--description">             <p class="word--description">adv. kipa; chaymanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1039, 'a diario', '0', 'a diario',
        '<div class="word--description">             <p class="word--description">adv. punchanta punchanta, pun- chantin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1040, 'a gusto', '0', 'a gusto',
        '<div class="word--description">             <p class="word--description">adv. ninantak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1041, 'a tiempo', '0', 'a tiempo',
        '<div class="word--description">             <p class="word--description">adv. llikchalla, kachka. abaco qichwa (objeto), s. yupana. abajo, adv. uray, wayku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1042, 'abandonado', '0', 'abandonado',
        '<div class="word--description">             <p class="word--description">adj. sapalla, sakishka, shi-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1043, 'tashka', '0', 'tashka',
        '<div class="word--description">             <p class="word--description">hichushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1044, 'abandonar', '0', 'abandonar',
        '<div class="word--description">             <p class="word--description">v. sakina, hichuna, shitana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1045, 'abdómen', '0', 'abdómen',
        '<div class="word--description">             <p class="word--description">s. wiksa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1046, 'abeja', '0', 'abeja',
        '<div class="word--description">             <p class="word--description">s. wayrunku, chullumpi, putan chuspi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1047, 'abismo', '0', 'abismo',
        '<div class="word--description">             <p class="word--description">s. kaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1048, 'ablandarse', '0', 'ablandarse',
        '<div class="word--description">             <p class="word--description">v. llampuna, apiyana. abonanzar, v. kasiyachina. abonar, el terreno, s. wanuna. abono, s. wanu, isma. aborrecer, v. chiknina, millana. abortar, v. shulluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1049, 'aborto', '0', 'aborto',
        '<div class="word--description">             <p class="word--description">s. shullu, shullushka, shullushka</p>          </div>',
        'ACTIVE', 2, '-'),
       (1050, 'abrazar', '0', 'abrazar',
        '<div class="word--description">             <p class="word--description">s. ukllana. abrigado, adj. kunuk. abril, s. <*ayriwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1051, 'abrir', '0', 'abrir',
        '<div class="word--description">             <p class="word--description">v. paskana, chiktana; a presión ma-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1052, 'absolutamente todo', '0', 'absolutamente todo',
        '<div class="word--description">             <p class="word--description">adj. tukuypacha, illakta, tukuymashna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1053, 'absorber', '0', 'absorber',
        '<div class="word--description">             <p class="word--description">v. chumkana, tsumkana. abuela, s. hatuku mama, hatunmama. abuelo, s. hatuku yaya, hatunyaya. abultado, adj. raku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1054, 'abundar', '0', 'abundar',
        '<div class="word--description">             <p class="word--description">v. kamana, nanakllakana. acabar, v. puchukana, tukuchina. acabarse, v. tukurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1055, 'acariciar', '0', 'acariciar',
        '<div class="word--description">             <p class="word--description">v. kuyachina, kuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1056, 'acarrear', '0', 'acarrear',
        '<div class="word--description">             <p class="word--description">v. astana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1057, 'accidente (desgracia)', '0', 'accidente (desgracia)',
        '<div class="word--description">             <p class="word--description">s. llaki, kulluy. acechar, v. <*qaway; kawana; chapana. aceite, s. wira.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1058, 'aceptar', '0', 'aceptar',
        '<div class="word--description">             <p class="word--description">v. chaskina, hapina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1059, 'acequia', '0', 'acequia',
        '<div class="word--description">             <p class="word--description">s. larka; hacer acequias: larkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1060, 'acercar', '0', 'acercar',
        '<div class="word--description">             <p class="word--description">v. kimina, kuchuyachina. acercarse (en el espacio), v. kayllayana, kimirina, kuchuyana, llutarina, manyayana. achera, s. achira.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1061, 'achicarse', '0', 'achicarse',
        '<div class="word--description">             <p class="word--description">v. kintiyana, tuzuyana, waniu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1062, 'achiote', '0', 'achiote',
        '<div class="word--description">             <p class="word--description">s. mantur, manturu. achogcha, s. achukcha. achupalla, s. achupalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1063, 'aclarar problemas', '0', 'aclarar problemas',
        '<div class="word--description">             <p class="word--description">v. chimpapurachina. aclararse el día, v. punchayana. aconsejar, v. kunana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1064, 'acordarse', '0', 'acordarse',
        '<div class="word--description">             <p class="word--description">v. yuyarina. acostarse, v. siririna. acostumbrado, adj. yacharishka. acostumbrarse, v. yacharina. acrecentar, v. mirachina. actividad, s. ruray, llamkay. actual, adv. kunan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1065, 'aculturado', '0', 'aculturado',
        '<div class="word--description">             <p class="word--description">adj. chasu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1066, 'acuniar', '0', 'acuniar',
        '<div class="word--description">             <p class="word--description">v. kanichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1067, 'adelantar', '0', 'adelantar',
        '<div class="word--description">             <p class="word--description">v. niawpana; expresión para hacer adelantar a los animales: chi, chisha chisha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1068, 'adelantarse', '0', 'adelantarse',
        '<div class="word--description">             <p class="word--description">v. niawparina. ademas, adv. ashtawan. adherirse, v. llutarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1069, 'adivinanza', '0', 'adivinanza',
        '<div class="word--description">             <p class="word--description">s. watuy; expresión de ~:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1070, 'imashi imashi. adivinar', '0', 'imashi imashi. adivinar',
        '<div class="word--description">             <p class="word--description">v. watuna. adivino, s. watuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1071, 'admiración', '0', 'admiración',
        '<div class="word--description">             <p class="word--description">expresión de, hayka, ima-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1072, 'nash', '0', 'nash',
        '<div class="word--description">             <p class="word--description">manchanay, natikala.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1073, 'admitir', '0', 'admitir',
        '<div class="word--description">             <p class="word--description">v. chaskina, hapina, arinina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1074, 'adobe', '0', 'adobe',
        '<div class="word--description">             <p class="word--description">s. tika.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1075, 'adolescente', '0', 'adolescente',
        '<div class="word--description">             <p class="word--description">adj. varón: wamra; ambos: mallta, mara; mujer: pasnia, kuytsa. adónde?, preg. ¿maymantak?. adoptado, adj. winiachishka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1076, 'adoptivo', '0', 'adoptivo',
        '<div class="word--description">             <p class="word--description">adj. winiachik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1077, 'adorar', '0', 'adorar',
        '<div class="word--description">             <p class="word--description">v. muchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1078, 'adornar', '0', 'adornar',
        '<div class="word--description">             <p class="word--description">v. allichina, sumakyachina. adulto, adj. shunkuyuk. adversidad, adj. chiki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1079, 'advertir', '0', 'advertir',
        '<div class="word--description">             <p class="word--description">v. willana. aferrado, adj. llumi. aficionar, v. munana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1080, 'afilar', '0', 'afilar',
        '<div class="word--description">             <p class="word--description">v. cuchillo: mulana; sacar punta en la</p>          </div>',
        'ACTIVE', 2, '-'),
       (1081, 'madera: nianiuyachina. afiliarse', '0', 'madera: nianiuyachina. afiliarse',
        '<div class="word--description">             <p class="word--description">v. llutarina. afligirse, v. llakirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1082, 'afrecho', '0', 'afrecho',
        '<div class="word--description">             <p class="word--description">s. hamchi; de cebada: palak. afuera, adv. hawa, kancha. agachar, v. kumuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1083, 'agente', '0', 'agente',
        '<div class="word--description">             <p class="word--description">s. chapak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1084, 'agil', '0', 'agil',
        '<div class="word--description">             <p class="word--description">adj. kutsi, pantalla, hawalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1085, 'agitar', '0', 'agitar',
        '<div class="word--description">             <p class="word--description">v. kuyuchina; cosas líquidas: tsuklu- puna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1086, 'agitarse', '0', 'agitarse',
        '<div class="word--description">             <p class="word--description">v. kuyuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1087, 'aglomeración', '0', 'aglomeración',
        '<div class="word--description">             <p class="word--description">s. wankuriy, talliriy, wayka. aglomerado, adj. tallirishka, wankurishka. aglomerarse, v. tallirina, wankurina, zim- punina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1088, 'agolpar', '0', 'agolpar',
        '<div class="word--description">             <p class="word--description">v. niitina. agónico, adj. ayakara. agosto, s. <**chakmay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1089, 'agotarse', '0', 'agotarse',
        '<div class="word--description">             <p class="word--description">v. tukurina; físicamente: sampa-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1090, 'yana', '0', 'yana',
        '<div class="word--description">             <p class="word--description">shaykuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1091, 'agradable', '0', 'agradable',
        '<div class="word--description">             <p class="word--description">adj. mishkichiypak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1092, 'agradecer', '0', 'agradecer',
        '<div class="word--description">             <p class="word--description">v. yupaychana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1093, 'agravarse de enfermedad', '0', 'agravarse de enfermedad',
        '<div class="word--description">             <p class="word--description">v. ancha- yana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1094, 'agregar', '0', 'agregar',
        '<div class="word--description">             <p class="word--description">v. yapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1095, 'agriarse', '0', 'agriarse',
        '<div class="word--description">             <p class="word--description">hacerse agrio, v. puskuyana. agrietado, adj. waka, chiktashka. agrietarse, v. chiktarina, rakrayana; la piel: paspayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1096, 'agrio', '0', 'agrio',
        '<div class="word--description">             <p class="word--description">adj. hayak, tani.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1097, 'agrupación', '0', 'agrupación',
        '<div class="word--description">             <p class="word--description">s. tantachiy, tantanakuy, wan- kuriy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1098, 'agrupar', '0', 'agrupar',
        '<div class="word--description">             <p class="word--description">v. tantachina; de la misma espe- cie: paypurachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1099, 'agruparse para acelerar un trabajo', '0', 'agruparse para acelerar un trabajo',
        '<div class="word--description">             <p class="word--description">v. way- kana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1100, 'agua', '0', 'agua',
        '<div class="word--description">             <p class="word--description">s. yaku. aguacate, s. pallta. aguado, adj. chuya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1101, 'aguamiel', '0', 'aguamiel',
        '<div class="word--description">             <p class="word--description">s. chawar mishki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1102, 'aguardar', '0', 'aguardar',
        '<div class="word--description">             <p class="word--description">v. shuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1103, 'agudo (filo', '0', 'agudo (filo',
        '<div class="word--description">             <p class="word--description">puntiagudo), adj. niawchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1104, 'aguila', '0', 'aguila',
        '<div class="word--description">             <p class="word--description">s. anka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1105, 'aguja', '0', 'aguja',
        '<div class="word--description">             <p class="word--description">s. yawri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1106, 'agujereado', '0', 'agujereado',
        '<div class="word--description">             <p class="word--description">adj. hutku. agujerear, v. hutkuyachina, puluna. agujero, s. hutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1107, 'agusanado', '0', 'agusanado',
        '<div class="word--description">             <p class="word--description">adj. kuruyashka. agusanarse, v. kuruyana. aguzado, adj. niawchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1108, 'ahí', '0', 'ahí',
        '<div class="word--description">             <p class="word--description">adv. chaypi. ahora, adv. kunan. ahorcar, v. sipina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1109, 'ahorrar', '0', 'ahorrar',
        '<div class="word--description">             <p class="word--description">v. wakaychina, allichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1110, 'ahuyentar', '0', 'ahuyentar',
        '<div class="word--description">             <p class="word--description">v. manchachina, kallpachina; expresión para hacer adelantar a los anima- les: chi, chisha chisha, hishi hishi, hushu hushu, kisha kisha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1111, 'aire', '0', 'aire',
        '<div class="word--description">             <p class="word--description">s. samay, wayra.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1112, 'ajeno (distinto)', '0', 'ajeno (distinto)',
        '<div class="word--description">             <p class="word--description">adj. chikan, chuku, hullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1113, 'ají', '0', 'ají',
        '<div class="word--description">             <p class="word--description">s. uchu; rukutu, piki uchu. ajustar, v. sipina, takllana. alargado, v. suniyashka. alargar, v. suniyachina. alargarse, v. suniyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1114, 'al frente', '0', 'al frente',
        '<div class="word--description">             <p class="word--description">adv. chimpa, niawpa. al instante, adv. nia, niapash. al lado, adv. kuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1115, 'allí', '0', 'allí',
        '<div class="word--description">             <p class="word--description">adv. chakaypi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1116, 'al otro lado', '0', 'al otro lado',
        '<div class="word--description">             <p class="word--description">adv. chimpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1117, 'ala', '0', 'ala',
        '<div class="word--description">             <p class="word--description">s. rikra.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1118, 'alabarse', '0', 'alabarse',
        '<div class="word--description">             <p class="word--description">v. chakchuna. alacran, s. uputinti. alcanzar, v. paktana, chayana. alcoba, s. (<*pitita, killi). alegre, adv. kushilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1119, 'alegría', '0', 'alegría',
        '<div class="word--description">             <p class="word--description">s. kushikuy, kushi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1120, 'alejarse', '0', 'alejarse',
        '<div class="word--description">             <p class="word--description">en el espacio, v. karuyana. aleta(s) del pez, s. pimpis, winkanas. alforja, s. wayaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1121, 'algodón', '0', 'algodón',
        '<div class="word--description">             <p class="word--description">s. usual: utku; silvestre: putu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1122, 'algun', '0', 'algun',
        '<div class="word--description">             <p class="word--description">-o, -a, det.  wakin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1123, 'algunos', '0', 'algunos',
        '<div class="word--description">             <p class="word--description">det. tawka, achka, wakinkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1124, 'aliento', '0', 'aliento',
        '<div class="word--description">             <p class="word--description">s. samay. alimentar, v. karana. alimentarse, v. mikuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1125, 'alimento', '0', 'alimento',
        '<div class="word--description">             <p class="word--description">s. mikuy; envuelto en hojas para</p>          </div>',
        'ACTIVE', 2, '-'),
       (1126, 'cocer: machu; enmohecido: pulak. alma', '0', 'cocer: machu; enmohecido: pulak. alma',
        '<div class="word--description">             <p class="word--description">s. nuna, samay; tunchi. almacen, s. katuwasi. almohada, s. sawna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1127, 'almorzar', '0', 'almorzar',
        '<div class="word--description">             <p class="word--description">v. (<*llaqwariy), llakwarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1128, 'alpaca', '0', 'alpaca',
        '<div class="word--description">             <p class="word--description">s. allpaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1129, 'alrededor de', '0', 'alrededor de',
        '<div class="word--description">             <p class="word--description">adv. muyuntin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1130, 'alto', '0', 'alto',
        '<div class="word--description">             <p class="word--description">-a, adj. hatun, suni; lugar alto: hanak, hawa; persona alta y delgada: chawar kiru. altamisa, s. marku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1131, 'alterarse', '0', 'alterarse',
        '<div class="word--description">             <p class="word--description">v. piniarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1132, 'alumbrar', '0', 'alumbrar',
        '<div class="word--description">             <p class="word--description">dar a luz, v. pakarina, wa- chana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1133, 'alumno', '0', 'alumno',
        '<div class="word--description">             <p class="word--description">-a, s. yachakuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1134, 'alzamiento', '0', 'alzamiento',
        '<div class="word--description">             <p class="word--description">s. hatariy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1135, 'alzar', '0', 'alzar',
        '<div class="word--description">             <p class="word--description">v. hawayachina; el vestido hasta la cintura: llatanana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1136, 'alzarse', '0', 'alzarse',
        '<div class="word--description">             <p class="word--description">v. hatarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1137, 'amado', '0', 'amado',
        '<div class="word--description">             <p class="word--description">adj. kuyashka, munashka. amamantar, v. chuchuchina. amancebado, adj. wayna. amanecer, v. pakarina. amansar, v. wiwana, uywana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1138, 'amante', '0', 'amante',
        '<div class="word--description">             <p class="word--description">s. kayak, munak; adj. varón:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1139, 'amaniar', '0', 'amaniar',
        '<div class="word--description">             <p class="word--description">v. chaknana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1140, 'amar', '0', 'amar',
        '<div class="word--description">             <p class="word--description">v. kuyana, maywana, llakina, munana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1141, 'amargo', '0', 'amargo',
        '<div class="word--description">             <p class="word--description">adj. hayak, tani. amargura (dolor), s. llaki. amarillo, adj. karwa, killu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1142, 'amarrado', '0', 'amarrado',
        '<div class="word--description">             <p class="word--description">adj. watashka; las puntas del</p>          </div>',
        'ACTIVE', 2, '-'),
       (1143, 'paniuelo o tela: tsutu', '0', 'paniuelo o tela: tsutu',
        '<div class="word--description">             <p class="word--description">sutu.</p>          </div>', 'ACTIVE',
        2, '-'),
       (1144, 'amarrar', '0', 'amarrar',
        '<div class="word--description">             <p class="word--description">v. watana, wankuna; las esquinas de un mantel o paniuelo: tsutuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1145, 'Amazonia', '0', 'Amazonia',
        '<div class="word--description">             <p class="word--description">s. Anti llakta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1146, 'amazónico', '0', 'amazónico',
        '<div class="word--description">             <p class="word--description">persona del oriente, s. anti- runa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1147, 'ambos', '0', 'ambos',
        '<div class="word--description">             <p class="word--description">adv. ishkantin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1148, 'America', '0', 'America',
        '<div class="word--description">             <p class="word--description">continente, s. Pantinsaya; Apya yala.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1149, 'amigo', '0', 'amigo',
        '<div class="word--description">             <p class="word--description">s. mashi; trato entre los amigos: alama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1150, 'amontonar', '0', 'amontonar',
        '<div class="word--description">             <p class="word--description">v. tantachina. amontonarse (personas, animales), v. tantarina, intuna, wankurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1151, 'amoroso', '0', 'amoroso',
        '<div class="word--description">             <p class="word--description">-a, adj. kuyaylla. amortiguarse, v. upayana, waniurina. amplio, adj. hatun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1152, 'ampollarse', '0', 'ampollarse',
        '<div class="word--description">             <p class="word--description">v. chulakyana, huklluyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1153, 'amuleto', '0', 'amuleto',
        '<div class="word--description">             <p class="word--description">s. (<*wakanki).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1154, 'anaconda', '0', 'anaconda',
        '<div class="word--description">             <p class="word--description">s. yakumama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1155, 'ananas', '0', 'ananas',
        '<div class="word--description">             <p class="word--description">fruta similar a la chirimoya, s. ana- nas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1156, 'anatomía', '0', 'anatomía',
        '<div class="word--description">             <p class="word--description">s. <*ukunyachay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1157, 'anca', '0', 'anca',
        '<div class="word--description">             <p class="word--description">s. chaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1158, 'ancho', '0', 'ancho',
        '<div class="word--description">             <p class="word--description">adj. patak, pala; excesivamente ancho: ankara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1159, 'anciana', '0', 'anciana',
        '<div class="word--description">             <p class="word--description">adj. paya. anciano, adj. ruku, machu. andar, v. purina. andariego, adj. yanka purik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1160, 'andrajoso', '0', 'andrajoso',
        '<div class="word--description">             <p class="word--description">adj. tsuntsu, tsunzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1161, 'angosto', '0', 'angosto',
        '<div class="word--description">             <p class="word--description">adj. kichki. anillo, s. shiwi, siwi. animal, s. wiwa, uywa. ano, s. ukuti, hutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1162, 'anochecer(se)', '0', 'anochecer(se)',
        '<div class="word--description">             <p class="word--description">v. tutayana. anonadarse, v. upayana. anormal, adj. paku. antebrazo, s. nianiurikra, maki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1163, 'antes', '0', 'antes',
        '<div class="word--description">             <p class="word--description">adv. recien: niaka; hace mucho</p>          </div>',
        'ACTIVE', 2, '-'),
       (1164, 'tiempo: sarun', '0', 'tiempo: sarun',
        '<div class="word--description">             <p class="word--description">niawpa, unay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1165, 'anticiparse', '0', 'anticiparse',
        '<div class="word--description">             <p class="word--description">v. niawpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1166, 'antiguo (en tiempo', '0', 'antiguo (en tiempo',
        '<div class="word--description">             <p class="word--description">edad), adv. niawpa; para objetos: adj. mawka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1167, 'antojar', '0', 'antojar',
        '<div class="word--description">             <p class="word--description">v. munana. antropófago, s. runamikuk. anudar el kipu, v. kipuna. anular, dedo, s. shiwi ruka. anunciar, w. willana. anzuelo, s. (<*yawrina); yawri. anio, s. wata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1168, 'apachurrar', '0', 'apachurrar',
        '<div class="word--description">             <p class="word--description">v. niitina. apaciguar, v. kasiyachina. apagar la luz, v. waniuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1169, 'apagarse (la candela o el fuego)', '0', 'apagarse (la candela o el fuego)',
        '<div class="word--description">             <p class="word--description">v. waniu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1170, 'rina', '0', 'rina',
        '<div class="word--description">             <p class="word--description">waniuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1171, 'aparato digestivo', '0', 'aparato digestivo',
        '<div class="word--description">             <p class="word--description">s. mikuyhilli tukuna. aparear, estar en celo, en epoca de apare- amiento, v. napana, salinana. aparecerse, v. rikurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1172, 'aparecido', '0', 'aparecido',
        '<div class="word--description">             <p class="word--description">adj. rikurishka. aparejo, s. hallma. aparentar, v. tukuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1173, 'apartar', '0', 'apartar',
        '<div class="word--description">             <p class="word--description">v. akllana, chikanyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1174, 'aparte', '0', 'aparte',
        '<div class="word--description">             <p class="word--description">adj. chikan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1175, 'apatico', '0', 'apatico',
        '<div class="word--description">             <p class="word--description">adj. aminta, chamcha, chamuk, hamlla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1176, 'apearse', '0', 'apearse',
        '<div class="word--description">             <p class="word--description">v. uraykuna, waykuykuna. apegar, v. kimina, tinkina. apegarse, v. llutarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1177, 'apellido', '0', 'apellido',
        '<div class="word--description">             <p class="word--description">s. ayllushuti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1178, 'apenarse', '0', 'apenarse',
        '<div class="word--description">             <p class="word--description">tener pena, v. llakina, llakirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1179, 'apiniar', '0', 'apiniar',
        '<div class="word--description">             <p class="word--description">v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1180, 'aplanar', '0', 'aplanar',
        '<div class="word--description">             <p class="word--description">v. allana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1181, 'aplastar', '0', 'aplastar',
        '<div class="word--description">             <p class="word--description">v. kawtayana, llapina. apolillarse, v. kuruyana, susuna. apoyar en el bastón, v. tawnana. aprender, v. yachakuna. aprendiz, s. yachakuk. aprendizaje, s. yachakuy. apresar, v. hapina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1182, 'apresurarse', '0', 'apresurarse',
        '<div class="word--description">             <p class="word--description">v. utkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1183, 'apretar', '0', 'apretar',
        '<div class="word--description">             <p class="word--description">v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1184, 'apuntalar', '0', 'apuntalar',
        '<div class="word--description">             <p class="word--description">v. tawnana, tumpina. apuniar, v. llapina, tsutsukina. apurado, adv. ichu, utka. apurar, v. atina, utkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1185, 'aquel', '0', 'aquel',
        '<div class="word--description">             <p class="word--description">-llo, -a, pron. chakay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1186, 'aquí', '0', 'aquí',
        '<div class="word--description">             <p class="word--description">adv. kaypi. arado, s. yapuna, taklla. arania, s. uru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1187, 'araniar', '0', 'araniar',
        '<div class="word--description">             <p class="word--description">v. aspina, sillkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1188, 'arar', '0', 'arar',
        '<div class="word--description">             <p class="word--description">v. yapuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1189, 'arbol (variedades)', '0', 'arbol (variedades)',
        '<div class="word--description">             <p class="word--description">s. yura: champuru, chukchuwasu, chuku, chulan, chunchu, hu- lunchi, kapi runa, kapuli, kuya, lan, lunchik,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1190, 'mullchi', '0', 'mullchi',
        '<div class="word--description">             <p class="word--description">paparawa, pasu, pillchi, pitun, sipi- chi, sirak, shallipu, tankana, tukti, wampula, waranku, wawal, wituk, yutsu, zirka. arbusto, s. variedades: iwilan, kahalli, lin- chi, tanampu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1191, 'arco iris', '0', 'arco iris',
        '<div class="word--description">             <p class="word--description">s. kuychi. arder, v. rawrana. arderse, v. ruparina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1192, 'ardilla', '0', 'ardilla',
        '<div class="word--description">             <p class="word--description">s. chukuri, waywash.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1193, 'arena', '0', 'arena',
        '<div class="word--description">             <p class="word--description">s. fina: tiyu, yuksi; gruesa: tsatsa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1194, 'arenal', '0', 'arenal',
        '<div class="word--description">             <p class="word--description">s. tiyu tiyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1195, 'arenilla', '0', 'arenilla',
        '<div class="word--description">             <p class="word--description">tipo de mosquito, s. hikinias.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1196, 'aretes', '0', 'aretes',
        '<div class="word--description">             <p class="word--description">s. rinriwarkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1197, 'arisco', '0', 'arisco',
        '<div class="word--description">             <p class="word--description">adj. kita.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1198, 'armadillo', '0', 'armadillo',
        '<div class="word--description">             <p class="word--description">s. kirkinchu, kutimpu. armazón (palos pequenios colocados den- tro de la olla para cocinar) s. panshi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1199, 'arrastrar', '0', 'arrastrar',
        '<div class="word--description">             <p class="word--description">v. aysana. arrastrarse, v. suchuna. arrear, v. karkuna. arrebatar, v. kichuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1200, 'arreglar', '0', 'arreglar',
        '<div class="word--description">             <p class="word--description">v. allichina, sumakyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1201, 'arrepentirse', '0', 'arrepentirse',
        '<div class="word--description">             <p class="word--description">v. nanarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1202, 'arriba', '0', 'arriba',
        '<div class="word--description">             <p class="word--description">adv. hanak, hawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1203, 'arrimar', '0', 'arrimar',
        '<div class="word--description">             <p class="word--description">v. kimina; la cabeza sobre la almo- hada: sawnana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1204, 'arrojar', '0', 'arrojar',
        '<div class="word--description">             <p class="word--description">v. shitana, yayuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1205, 'arruga', '0', 'arruga',
        '<div class="word--description">             <p class="word--description">s. sipu; de los parpados: tsitsi. arrugado, adj. sipushka, chunu, chuniu; por mojarse: chuchuka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1206, 'arrugar', '0', 'arrugar',
        '<div class="word--description">             <p class="word--description">v. sipuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1207, 'arteria', '0', 'arteria',
        '<div class="word--description">             <p class="word--description">s. anku, sirka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1208, 'articulación (del cuerpo)', '0', 'articulación (del cuerpo)',
        '<div class="word--description">             <p class="word--description">s. muku. artículo (legal), s. kamachiy. arvejas, s. alwis.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1209, 'asamblea', '0', 'asamblea',
        '<div class="word--description">             <p class="word--description">s. tantanakuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1210, 'asar', '0', 'asar',
        '<div class="word--description">             <p class="word--description">v. kusana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1211, 'ascender', '0', 'ascender',
        '<div class="word--description">             <p class="word--description">v. sikana, wichayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1212, 'asco', '0', 'asco',
        '<div class="word--description">             <p class="word--description">expresión que denota, interj. atatay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1213, 'asemejarse', '0', 'asemejarse',
        '<div class="word--description">             <p class="word--description">v. rikchana. asentir, v. iniina. asesinar, v. waniuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1214, 'así mismo', '0', 'así mismo',
        '<div class="word--description">             <p class="word--description">conj. shinallatak. así, adv. chay shina, chashna. asiento, s. tiyarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1215, 'asir', '0', 'asir',
        '<div class="word--description">             <p class="word--description">v. hapina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1216, 'asno', '0', 'asno',
        '<div class="word--description">             <p class="word--description">s. chantasu, upawiwa, ushu (¿?).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1217, 'asolear', '0', 'asolear',
        '<div class="word--description">             <p class="word--description">v. mashana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1218, 'asomarse', '0', 'asomarse',
        '<div class="word--description">             <p class="word--description">v. rikurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1219, 'aspero', '0', 'aspero',
        '<div class="word--description">             <p class="word--description">adj. lluru, paza, sakra, tsaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1220, 'asquear', '0', 'asquear',
        '<div class="word--description">             <p class="word--description">v. millana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1221, 'astrólogo', '0', 'astrólogo',
        '<div class="word--description">             <p class="word--description">s. (<*pacha-unanchaq). asustar, v. manchachina. asustarse, v. mancharina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1222, 'atado', '0', 'atado',
        '<div class="word--description">             <p class="word--description">adj. watashka, wanku; de frutos que</p>          </div>',
        'ACTIVE', 2, '-'),
       (1223, 'atajar', '0', 'atajar',
        '<div class="word--description">             <p class="word--description">v. harkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1224, 'atar', '0', 'atar',
        '<div class="word--description">             <p class="word--description">v. watana, tsutsukina, wankuna; pies o manos: chaknana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1225, 'atardecer', '0', 'atardecer',
        '<div class="word--description">             <p class="word--description">v. chishiyana. atemorizar, v. manchachina. atemorizarse, v. mancharina. atender, v. uyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1226, 'atleta', '0', 'atleta',
        '<div class="word--description">             <p class="word--description">s. kallpak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1227, 'atmósfera', '0', 'atmósfera',
        '<div class="word--description">             <p class="word--description">s. <**wapsi. atormentarse, v. niakarina. atracar, v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1228, 'atrancarse', '0', 'atrancarse',
        '<div class="word--description">             <p class="word--description">v. chukarina, tukarina, shuka-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1229, 'atras', '0', 'atras',
        '<div class="word--description">             <p class="word--description">adv. kipa, washa. atrasarse, v. kipayana. atropellar, v. saruna, llapina. augurio malo, adj. chiki, tapya. aumentar, v. yapana, mirachina. aumento, s. miray.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1230, 'aun', '0', 'aun',
        '<div class="word--description">             <p class="word--description">adv. chayrak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1231, 'aun no', '0', 'aun no',
        '<div class="word--description">             <p class="word--description">adv. manarak. aunque no, adv. amapash. ausentarse, v. rina, illana. ausente, s. illak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1232, 'austral', '0', 'austral',
        '<div class="word--description">             <p class="word--description">s. hanansuyu. autoridad, s. apu, kamachik. auxiliar, v. yanapana. auxilio, s. yanapay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1233, 'avaro', '0', 'avaro',
        '<div class="word--description">             <p class="word--description">-a, adj. michak, mitsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1234, 'ave', '0', 'ave',
        '<div class="word--description">             <p class="word--description">s. munchi, variedades: anka, chuku, ki- lliku, kuntur, lluta, munchi, pishku, tsuwan, zhuta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1235, 'avena', '0', 'avena',
        '<div class="word--description">             <p class="word--description">tipo de gramínea, s. <* waylla. avergonzarse, v. pinkana, urmarina. averiguar, v. tapuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1236, 'avión', '0', 'avión',
        '<div class="word--description">             <p class="word--description">s. antanka. avisar, v. willana. aviso, s. willay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1237, 'axila', '0', 'axila',
        '<div class="word--description">             <p class="word--description">s. (<*wallwaku), kashuk, rikra-uku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1238, 'ayer', '0', 'ayer',
        '<div class="word--description">             <p class="word--description">adv. kayna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1239, 'ayuda', '0', 'ayuda',
        '<div class="word--description">             <p class="word--description">s. yanapay; mutua: rantimpa. ayudante, adj. yana, yanapak. ayudar, v. yanapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1240, 'ayunar', '0', 'ayunar',
        '<div class="word--description">             <p class="word--description">v. sasina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1241, 'ayuno', '0', 'ayuno',
        '<div class="word--description">             <p class="word--description">s. sasi; día de ayuno: sasi puncha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1242, 'azadón', '0', 'azadón',
        '<div class="word--description">             <p class="word--description">s. llachu. azucar, s. <**akumishki. azucena, s. amankay. azuela, s. llakllana. azul, adj. ankas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1243, 'babosa', '0', 'babosa',
        '<div class="word--description">             <p class="word--description">s. unik, atyak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1244, 'badea', '0', 'badea',
        '<div class="word--description">             <p class="word--description">s. hulun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1245, 'bagazo', '0', 'bagazo',
        '<div class="word--description">             <p class="word--description">s. patsak, patsuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1246, 'bailar', '0', 'bailar',
        '<div class="word--description">             <p class="word--description">v. tushuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1247, 'lampu', '0', 'lampu',
        '<div class="word--description">             <p class="word--description">nanampi, pulanti, tiyamshi, tsili-anku, waska; para tejer canastos: yallika; amarrado en forma circular: mania.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1248, 'bello', '0', 'bello',
        '<div class="word--description">             <p class="word--description">adj. sumak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1249, 'bajar', '0', 'bajar',
        '<div class="word--description">             <p class="word--description">v. urayana, uraykuna; los precios o costos: urayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1250, 'balancearse', '0', 'balancearse',
        '<div class="word--description">             <p class="word--description">v. walinyana. balanza, s. <* aysana. baldado, adj. wistu. baldío, adj. chushak, purum.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1251, 'banca', '0', 'banca',
        '<div class="word--description">             <p class="word--description">-o (para sentarse), s. tiyarina. bandera, s. (<*unancha), wipala. baniarse, v. armarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1252, 'barba', '0', 'barba',
        '<div class="word--description">             <p class="word--description">s. sunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1253, 'barbechar', '0', 'barbechar',
        '<div class="word--description">             <p class="word--description">v. chakmana, tulana. barbudo, adj. munza shimi. barco, s. wampu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1254, 'barnizar', '0', 'barnizar',
        '<div class="word--description">             <p class="word--description">v. hawina, llunchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1255, 'barranco', '0', 'barranco',
        '<div class="word--description">             <p class="word--description">s. wayku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1256, 'barra(s) (divisorias verticales)', '0', 'barra(s) (divisorias verticales)',
        '<div class="word--description">             <p class="word--description">s. harka. barredor, (persona), s. pichak. barrendero, s. pichak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1257, 'barrer', '0', 'barrer',
        '<div class="word--description">             <p class="word--description">v. pichana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1258, 'barrera', '0', 'barrera',
        '<div class="word--description">             <p class="word--description">s. harka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1259, 'barrido', '0', 'barrido',
        '<div class="word--description">             <p class="word--description">adj. pichashka; muy bien: chuyak- lla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1260, 'barriga', '0', 'barriga',
        '<div class="word--description">             <p class="word--description">s. wiksa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1261, 'barro', '0', 'barro',
        '<div class="word--description">             <p class="word--description">s. turu; hacer barro: turuyay, chapuy. bastante, det. achka, llashak, tawka, pa- chan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1262, 'bastón (en general)', '0', 'bastón (en general)',
        '<div class="word--description">             <p class="word--description">s. tawna; para impul- sar canoas: wanka, tawna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1263, 'basura', '0', 'basura',
        '<div class="word--description">             <p class="word--description">s. kupa, niuku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1264, 'basurero', '0', 'basurero',
        '<div class="word--description">             <p class="word--description">objeto: kupachurana; lugar donde se amontona: kupashitana; lugar donde se amontona la maleza: chinta. batir, v. kuyuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1265, 'bebe', '0', 'bebe',
        '<div class="word--description">             <p class="word--description">s. wawa, llullu wawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1266, 'beber', '0', 'beber',
        '<div class="word--description">             <p class="word--description">v. upyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1267, 'bebida', '0', 'bebida',
        '<div class="word--description">             <p class="word--description">s. upyana; extraida de la base del penco: chawarmishki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1268, 'bejuco (variedades)', '0', 'bejuco (variedades)',
        '<div class="word--description">             <p class="word--description">s.: anku, kalatis, ki-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1269, 'besar', '0', 'besar',
        '<div class="word--description">             <p class="word--description">v. muchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1270, 'bicolor', '0', 'bicolor',
        '<div class="word--description">             <p class="word--description">de pintas negras con blancas, adj. muru, muru muru; blanco y negro: pazil, puzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1271, 'bien', '0', 'bien',
        '<div class="word--description">             <p class="word--description">adj. alli; adv. allilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1272, 'bienes (recursos)', '0', 'bienes (recursos)',
        '<div class="word--description">             <p class="word--description">s. <* kaqnin; kaknin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1273, 'bienestar', '0', 'bienestar',
        '<div class="word--description">             <p class="word--description">s. allikay. bifurcación, s. pallka. bigote, s. sunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1274, 'bilingüe', '0', 'bilingüe',
        '<div class="word--description">             <p class="word--description">adj. ishkantinshimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1275, 'bilis (glandula biliar)', '0', 'bilis (glandula biliar)',
        '<div class="word--description">             <p class="word--description">s. (<*hayaqin), haya- kin, chinkillis.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1276, 'blanco', '0', 'blanco',
        '<div class="word--description">             <p class="word--description">color, adj. yurak. blando, adj. llullu, apilla. blusa, s. tallpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1277, 'boa', '0', 'boa',
        '<div class="word--description">             <p class="word--description">s. amaru; atakapi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1278, 'bobo', '0', 'bobo',
        '<div class="word--description">             <p class="word--description">adj. muspa, upa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1279, 'boca', '0', 'boca',
        '<div class="word--description">             <p class="word--description">s. shimi; boca abajo: uray shimi, tu- waman; boca arriba: wichay shimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1280, 'bocio', '0', 'bocio',
        '<div class="word--description">             <p class="word--description">s. kutu. bodoquera, s. pukuna. bola, (<*rumpu), rumpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1281, 'bolso', '0', 'bolso',
        '<div class="word--description">             <p class="word--description">-a, s. islampu, pati, shikra, tulu, wa-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1282, 'bonito', '0', 'bonito',
        '<div class="word--description">             <p class="word--description">-a, adj. kuyaylla, sumak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1283, 'borbotear', '0', 'borbotear',
        '<div class="word--description">             <p class="word--description">v. timpuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1284, 'borde', '0', 'borde',
        '<div class="word--description">             <p class="word--description">s. manya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1285, 'bordes', '0', 'bordes',
        '<div class="word--description">             <p class="word--description">hacer, v. shiminchina. borrachera, s. machay, shinkay. borracho, adj. machashka, shinka. borrador (objeto), s. pichana. borrar, v. pichana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1286, 'borrego', '0', 'borrego',
        '<div class="word--description">             <p class="word--description">s. uwiha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1287, 'bosque', '0', 'bosque',
        '<div class="word--description">             <p class="word--description">s. sacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1288, 'bostezar', '0', 'bostezar',
        '<div class="word--description">             <p class="word--description">v. ampana, haynallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1289, 'botar', '0', 'botar',
        '<div class="word--description">             <p class="word--description">v. shitana, chakchuna, chiwana, hi- chana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1290, 'brazo', '0', 'brazo',
        '<div class="word--description">             <p class="word--description">s. rikra, rakurikra; del río: chikta,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1291, 'breve', '0', 'breve',
        '<div class="word--description">             <p class="word--description">adv. utka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1292, 'brillante', '0', 'brillante',
        '<div class="word--description">             <p class="word--description">adj. punchalla, hakan, palanikuk. brillar, v. achikyana, llipyana, palanina. brincar, v. kushparina, pawana, tushuna. brindar (alimentos), v. karana. brindemos, expresión para brindar, ishkan- tishun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1293, 'bromista', '0', 'bromista',
        '<div class="word--description">             <p class="word--description">adj. asichik, nuspa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1294, 'brotar (lo sembrado)', '0', 'brotar (lo sembrado)',
        '<div class="word--description">             <p class="word--description">v. kiruyana, tukyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1295, 'brujear', '0', 'brujear',
        '<div class="word--description">             <p class="word--description">v. pukuna, shitana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1296, 'brujo', '0', 'brujo',
        '<div class="word--description">             <p class="word--description">s. chuntapala, sakra, salamanka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1297, 'bruto', '0', 'bruto',
        '<div class="word--description">             <p class="word--description">adj. muspa, upa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1298, 'buen', '0', 'buen',
        '<div class="word--description">             <p class="word--description">-o, -a, adj. alli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1299, 'buho', '0', 'buho',
        '<div class="word--description">             <p class="word--description">s. apapa, kukupa, kuskunku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1300, 'bulla', '0', 'bulla',
        '<div class="word--description">             <p class="word--description">s. wanlla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1301, 'bulto', '0', 'bulto',
        '<div class="word--description">             <p class="word--description">s. kipi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1302, 'burlar', '0', 'burlar',
        '<div class="word--description">             <p class="word--description">v. asipayana, asina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1303, 'burro', '0', 'burro',
        '<div class="word--description">             <p class="word--description">s. chantasu, ushu, muspa wiwa (¿?). buscar, el sustento o alimento: v. mas- kana; con insistencia: lukllikirina; peces de- bajo de las piedras: kantina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1304, 'caballo', '0', 'caballo',
        '<div class="word--description">             <p class="word--description">s. (<*hatun paqu), apiw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1305, 'cabania', '0', 'cabania',
        '<div class="word--description">             <p class="word--description">s. chuklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1306, 'cabecera', '0', 'cabecera',
        '<div class="word--description">             <p class="word--description">s. sawna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1307, 'cabello', '0', 'cabello',
        '<div class="word--description">             <p class="word--description">s. akcha; blanco o gris: puzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1308, 'cabeza', '0', 'cabeza',
        '<div class="word--description">             <p class="word--description">s. uma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1309, 'camote', '0', 'camote',
        '<div class="word--description">             <p class="word--description">s. apichu, kumal. canas, s. kushi, puzu. canasta, s. ashanka, saparu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1310, 'canción', '0', 'canción',
        '<div class="word--description">             <p class="word--description">s. taki; de la cosecha del trigo:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1311, 'cabeza de mate (animal similar al tigre)', '0', 'cabeza de mate (animal similar al tigre)',
        '<div class="word--description">             <p class="word--description"></p>          </div>', 'ACTIVE', 2,
        '-'),
       (1312, 's. pantu', '0', 's. pantu',
        '<div class="word--description">             <p class="word--description">tuwi.</p>          </div>', 'ACTIVE',
        2, '-'),
       (1313, 'cabuyo', '0', 'cabuyo',
        '<div class="word--description">             <p class="word--description">s. chawar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1314, 'cacao blanco', '0', 'cacao blanco',
        '<div class="word--description">             <p class="word--description">s. kila, kula, patas; silves- tre: kampik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1315, 'cada', '0', 'cada',
        '<div class="word--description">             <p class="word--description">det. sapan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1316, 'cadaver', '0', 'cadaver',
        '<div class="word--description">             <p class="word--description">adj. aya, waniushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1317, 'cadera', '0', 'cadera',
        '<div class="word--description">             <p class="word--description">s. chaka, kankik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1318, 'caer el rocío', '0', 'caer el rocío',
        '<div class="word--description">             <p class="word--description">v. shullana, sarpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1319, 'caerse', '0', 'caerse',
        '<div class="word--description">             <p class="word--description">v. urmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1320, 'cafe', '0', 'cafe',
        '<div class="word--description">             <p class="word--description">color, adj. paku; planta y bebida: shaniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1321, 'caimito', '0', 'caimito',
        '<div class="word--description">             <p class="word--description">s. hapiyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1322, 'cal', '0', 'cal',
        '<div class="word--description">             <p class="word--description">s. isku, pukshi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1323, 'calabaza', '0', 'calabaza',
        '<div class="word--description">             <p class="word--description">s. kitu, sampu; cortada tierna: walak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1324, 'caldo', '0', 'caldo',
        '<div class="word--description">             <p class="word--description">s. hilli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1325, 'calendario', '0', 'calendario',
        '<div class="word--description">             <p class="word--description">s. (<*pachakipu).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1326, 'calentura', '0', 'calentura',
        '<div class="word--description">             <p class="word--description">s. rupay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1327, 'calida región', '0', 'calida región',
        '<div class="word--description">             <p class="word--description">s. yunka suyu. caliente, adj. inlli, kunuk. calladamente, adv. chulunlla, upalla. callarse, v. chunyana, upallana. calmar, v. kasiyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1328, 'calmarse', '0', 'calmarse',
        '<div class="word--description">             <p class="word--description">v. kasiyarina, samarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1329, 'calor', '0', 'calor',
        '<div class="word--description">             <p class="word--description">s. rupay; expresión de calor: acha- chaw; expresión por el calor de algo que- mante: araray.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1330, 'cama', '0', 'cama',
        '<div class="word--description">             <p class="word--description">s. <*puniuna; rustica: kawitu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1331, 'camarón', '0', 'camarón',
        '<div class="word--description">             <p class="word--description">s. lluchunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1332, 'camilla', '0', 'camilla',
        '<div class="word--description">             <p class="word--description">s. chakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1333, 'caminar', '0', 'caminar',
        '<div class="word--description">             <p class="word--description">v. purina; empezar a caminar los bebes: tatkina; expresión para hacer cami- nar, a personas o animales: kati kati. camino, s. nian.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1334, 'camisa', '0', 'camisa',
        '<div class="word--description">             <p class="word--description">s. kushma, unku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1335, 'camiseta', '0', 'camiseta',
        '<div class="word--description">             <p class="word--description">s. kushma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1336, 'la guerra: haylli; matrimonial: mashalla', '0', 'la guerra: haylli; matrimonial: mashalla',
        '<div class="word--description">             <p class="word--description">kay- nawisu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1337, 'candela', '0', 'candela',
        '<div class="word--description">             <p class="word--description">s. nina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1338, 'canelo', '0', 'canelo',
        '<div class="word--description">             <p class="word--description">arbol de, s. akwa, ishpinku, pinchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1339, 'cangrejo', '0', 'cangrejo',
        '<div class="word--description">             <p class="word--description">s. apankura.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1340, 'canguil', '0', 'canguil',
        '<div class="word--description">             <p class="word--description">variedad de maíz, s. kankil. canilla, s. pinkullu, sampi. cansarse, v. sampayana, shaykuna. cantante, s. takik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1341, 'cantar', '0', 'cantar',
        '<div class="word--description">             <p class="word--description">v. takina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1342, 'cantaro', '0', 'cantaro',
        '<div class="word--description">             <p class="word--description">s. wallu; de una oreja: puyniu, puniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1343, 'cantón', '0', 'cantón',
        '<div class="word--description">             <p class="word--description">s. kiti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1344, 'cania', '0', 'cania',
        '<div class="word--description">             <p class="word--description">s. wiru; guadua: wamak. capulí, arbol y fruto, s. kapuli, usun. cara, s. uya; niawi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1345, 'caracol', '0', 'caracol',
        '<div class="word--description">             <p class="word--description">s. churu; instrumento musical:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1346, 'carbón', '0', 'carbón',
        '<div class="word--description">             <p class="word--description">s. killimsa, shinki. carbonizarse (los granos), v. hawriyana. carcel, s. wataywasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1347, 'cardar', '0', 'cardar',
        '<div class="word--description">             <p class="word--description">v. tisana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1348, 'cardo', '0', 'cardo',
        '<div class="word--description">             <p class="word--description">s. pircha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1349, 'carear', '0', 'carear',
        '<div class="word--description">             <p class="word--description">v. chimpapurachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1350, 'carga', '0', 'carga',
        '<div class="word--description">             <p class="word--description">s. apachi, kipi, wanku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1351, 'cargar', '0', 'cargar',
        '<div class="word--description">             <p class="word--description">v. aparina; al bebe: tutuna; frutos el arbol: aparina; hacer cargar: apachina. carne, s. aycha; seca al sol: charki; ahu- mada: mitayu; a medio asarse: inlli. carnero, s. inku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1352, 'carnívoro', '0', 'carnívoro',
        '<div class="word--description">             <p class="word--description">s. aychamikuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1353, 'carpa', '0', 'carpa',
        '<div class="word--description">             <p class="word--description">s. karpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1354, 'carrizo', '0', 'carrizo',
        '<div class="word--description">             <p class="word--description">s. sukus.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1355, 'carro', '0', 'carro',
        '<div class="word--description">             <p class="word--description">s. anta-shuntu, anta wiwa, antawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1356, 'cartílago', '0', 'cartílago',
        '<div class="word--description">             <p class="word--description">s. mutul.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1357, 'casa', '0', 'casa',
        '<div class="word--description">             <p class="word--description">s. wasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1358, 'casado', '0', 'casado',
        '<div class="word--description">             <p class="word--description">-da, adj. sawarishka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1359, 'casarse', '0', 'casarse',
        '<div class="word--description">             <p class="word--description">v. sawarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1360, 'cascada', '0', 'cascada',
        '<div class="word--description">             <p class="word--description">s. pakcha, taski.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1361, 'cascara', '0', 'cascara',
        '<div class="word--description">             <p class="word--description">s. kara; de arroz, cebada o trigo: kushma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1362, 'casco', '0', 'casco',
        '<div class="word--description">             <p class="word--description">s. sillu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1363, 'casi', '0', 'casi',
        '<div class="word--description">             <p class="word--description">adv. nialla. castellano, s. kastilla. castillo, s. pukara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1364, 'cernir', '0', 'cernir',
        '<div class="word--description">             <p class="word--description">v. shushuna, akichana. cero, det. illak. cerramiento, s. kincha. cerrar, v. wichkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1365, 'cerro', '0', 'cerro',
        '<div class="word--description">             <p class="word--description">s. urku. cesar, v. tukurina. cesarse, v. samarina. ciego, adj. niawsa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1366, 'casucha', '0', 'casucha',
        '<div class="word--description">             <p class="word--description">s. chinkana. catapulta, s. pallka. catre, s. kawitu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1367, 'caucho', '0', 'caucho',
        '<div class="word--description">             <p class="word--description">s. palata, shirinka. cauchoso, adj. ankulla. caverna, s. chinkana, machay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1368, 'cazar', '0', 'cazar',
        '<div class="word--description">             <p class="word--description">v. chakuna; purina; con bodoquera:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1369, 'cazuela', '0', 'cazuela',
        '<div class="word--description">             <p class="word--description">s. wichi. cebada, s. siwara. cecina, s. charki. cecinar, v. charkina. cedazo, s. shushuna. ceibo, s. putu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1370, 'ceja', '0', 'ceja',
        '<div class="word--description">             <p class="word--description">s. niawi pata; cejas-pelos: niawi millma. celar (tener celos), v. tumpana. cementerio, s. ayapampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1371, 'cemento', '0', 'cemento',
        '<div class="word--description">             <p class="word--description">s. rumikuta. cenit, s. <* tiknu. ceniza, s. uchpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1372, 'centro de salud', '0', 'centro de salud',
        '<div class="word--description">             <p class="word--description">s. hampiwasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1373, 'centro educativo', '0', 'centro educativo',
        '<div class="word--description">             <p class="word--description">s. yachaywasi (ver: es- cuela, colegio, universidad).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1374, 'centro', '0', 'centro',
        '<div class="word--description">             <p class="word--description">adv. chawpi; parte central de cosas, minerales o vegetales: s. shunku. ceniirse, v. chumpillina; de forma cruzada: tahallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1375, 'cepillar (madera)', '0', 'cepillar (madera)',
        '<div class="word--description">             <p class="word--description">v. llampuna. cerbatana, s. pukuna. cerca, adv. kuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1376, 'cercar', '0', 'cercar',
        '<div class="word--description">             <p class="word--description">hacer cercas, v. kinchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1377, 'cerco', '0', 'cerco',
        '<div class="word--description">             <p class="word--description">-a, s. kincha. cerda, pelo, s. millma. cerdo, s. kuchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1378, 'cereales a medio cocer', '0', 'cereales a medio cocer',
        '<div class="word--description">             <p class="word--description">adj. kawka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1379, 'cereal', '0', 'cereal',
        '<div class="word--description">             <p class="word--description">s. <* murir.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1380, 'cerebro', '0', 'cerebro',
        '<div class="word--description">             <p class="word--description">s. niutku; cerebro izquierdo: lluki niutku; cerebro derecho: allawka niutku. ceremonia nupcial, s. sirichiy; para lla- mar la lluvia, s. piripiri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1381, 'ciempies', '0', 'ciempies',
        '<div class="word--description">             <p class="word--description">s. tatis, shiktikuy, shiway.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1382, 'cien', '0', 'cien',
        '<div class="word--description">             <p class="word--description">ciento, num. pachak, patsak. cienega, s. kuzu, guzu. científico, s. alli-yachak, amawta. cierto, adv. (<*chiqa), chika. cigarra, s. kiskis, zullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1383, 'cigarrillo', '0', 'cigarrillo',
        '<div class="word--description">             <p class="word--description">s. sayri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1384, 'cimiento', '0', 'cimiento',
        '<div class="word--description">             <p class="word--description">s. sapi, tiqsi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1385, 'cinco mil', '0', 'cinco mil',
        '<div class="word--description">             <p class="word--description">num. pichka waranka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1386, 'cinco', '0', 'cinco',
        '<div class="word--description">             <p class="word--description">num. pichka. cincuenta, num. pichka chunka. cintura, s. wikaw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1387, 'cinturón', '0', 'cinturón',
        '<div class="word--description">             <p class="word--description">s. chumpi. círculo, s. muyu. circunferencia, s. muyu. ciruela, s. usun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1388, 'citar', '0', 'citar',
        '<div class="word--description">             <p class="word--description">v. kayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1389, 'ciudad', '0', 'ciudad',
        '<div class="word--description">             <p class="word--description">s. hatunllakta, llakta. claridad, s. achik, achiklla. claro, adj. achik, paklla. clase, comp. sami. clasificar, v. chikanyachina. clavar, v. tuksina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1390, 'clavel', '0', 'clavel',
        '<div class="word--description">             <p class="word--description">flor, s. wayta. clavo, s. takarpu. cobarde, adj. sampa. cobertor, s. katana. cobija, s. katana, pullu. cobijar, v. katana. cobre, s. anta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1391, 'coca', '0', 'coca',
        '<div class="word--description">             <p class="word--description">planta medicinal, s. kuka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1392, 'cocear', '0', 'cocear',
        '<div class="word--description">             <p class="word--description">v. haytana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1393, 'cocido', '0', 'cocido',
        '<div class="word--description">             <p class="word--description">adj. yanushka; a medias: chawa, hawtsa, kawka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1394, 'cocina', '0', 'cocina',
        '<div class="word--description">             <p class="word--description">objeto, s. yanuna; cuarto de cocina: ninapata, yanunakilli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1395, 'cocinar', '0', 'cocinar',
        '<div class="word--description">             <p class="word--description">v. yanuna; a medias: hawchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1396, 'cocinero', '0', 'cocinero',
        '<div class="word--description">             <p class="word--description">-a, s. yanuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1397, 'codo', '0', 'codo',
        '<div class="word--description">             <p class="word--description">s. kuchus, kuchush.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1398, 'coger', '0', 'coger',
        '<div class="word--description">             <p class="word--description">v. hapina; líquidos o granos en un</p>          </div>',
        'ACTIVE', 2, '-'),
       (1399, 'cogollo', '0', 'cogollo',
        '<div class="word--description">             <p class="word--description">s. llulluk, niawi, yuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1400, 'cojear', '0', 'cojear',
        '<div class="word--description">             <p class="word--description">v. hankana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1401, 'col(es)', '0', 'col(es)',
        '<div class="word--description">             <p class="word--description">s. waylla-aycha; coles y nabos a medio cocer: hawcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1402, 'cola (parte del cuerpo del animal)', '0', 'cola (parte del cuerpo del animal)',
        '<div class="word--description">             <p class="word--description">s. chupa. colaboración, s. intuy, yanapay. colación, s. kukayu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1403, 'colada', '0', 'colada',
        '<div class="word--description">             <p class="word--description">s. api; de maíz pelado: kawka; de</p>          </div>',
        'ACTIVE', 2, '-'),
       (1404, 'colegio secundario', '0', 'colegio secundario',
        '<div class="word--description">             <p class="word--description">s. <**unanchaywasi; hatunyachaywasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1405, 'colgado', '0', 'colgado',
        '<div class="word--description">             <p class="word--description">adj. warkushka. colgar, s. warkuna. colibrí, s. kinti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1406, 'colina', '0', 'colina',
        '<div class="word--description">             <p class="word--description">s. urku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1407, 'collar', '0', 'collar',
        '<div class="word--description">             <p class="word--description">s. wallka; de semillas silvestres: ha- llinka, tallika.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1408, 'colocar', '0', 'colocar',
        '<div class="word--description">             <p class="word--description">v. churana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1409, 'color', '0', 'color',
        '<div class="word--description">             <p class="word--description">s. (<*llimpi); tullpu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1410, 'colores (para colorear', '0', 'colores (para colorear',
        '<div class="word--description">             <p class="word--description">pintar), s. llimpina- kuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1411, 'columna', '0', 'columna',
        '<div class="word--description">             <p class="word--description">s. (<*tunu).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1412, 'coma', '0', 'coma',
        '<div class="word--description">             <p class="word--description">signo diacrítico, s. samay. comadreja, s. chukuri. comarca, s. llakta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1413, 'combinar', '0', 'combinar',
        '<div class="word--description">             <p class="word--description">v. chakruna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1414, 'comenzar', '0', 'comenzar',
        '<div class="word--description">             <p class="word--description">v. kallarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1415, 'comer', '0', 'comer',
        '<div class="word--description">             <p class="word--description">v. mikuna; colada especial realizada en las fiestas: uchuna (ver desayunar, almor- zar, merendar).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1416, 'comercializar', '0', 'comercializar',
        '<div class="word--description">             <p class="word--description">v. mintalana. comerciante, s. mintala, rantinakuk. cometa, s. <*sasaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1417, 'comezón', '0', 'comezón',
        '<div class="word--description">             <p class="word--description">s. shikshi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1418, 'comida', '0', 'comida',
        '<div class="word--description">             <p class="word--description">s. mikuna; comida que se ofrece en los funerales: awkish.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1419, 'comienzo', '0', 'comienzo',
        '<div class="word--description">             <p class="word--description">adv. kallari. como, adv. shina. cómo?, interj. ¿haw?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1420, 'companiero', '0', 'companiero',
        '<div class="word--description">             <p class="word--description">s. mashi; trato entre compa-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1421, 'compas', '0', 'compas',
        '<div class="word--description">             <p class="word--description">s. muyuchik, muyuchina. compatriota, s. llaktamashi. competir, v. kamana, mishana. complementado, adj. paktachishka. complementar, v. paktachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1422, 'complemento gramatical', '0', 'complemento gramatical',
        '<div class="word--description">             <p class="word--description">s. paktachiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1423, 'completar', '0', 'completar',
        '<div class="word--description">             <p class="word--description">v. paktachina. componer, v. allichina, sumakyachina. comprar, v. rantina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1424, 'comprender', '0', 'comprender',
        '<div class="word--description">             <p class="word--description">v. hamutana, hapina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1425, 'comprimir', '0', 'comprimir',
        '<div class="word--description">             <p class="word--description">v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1426, 'compuesto', '0', 'compuesto',
        '<div class="word--description">             <p class="word--description">adj. allichishka, sumakyachis- hka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1427, 'comunicador', '0', 'comunicador',
        '<div class="word--description">             <p class="word--description">-ra, s. willak. comunicar, v. willana. comunidad, pueblo, s. ayllu-llakta. con cuidado, adv. allilla, allimanta. concho (de la chicha), s. tikti. concluido, adj. tukurishka, pakta. concluir, v. tukurina, puchukana. condimento, s. mishkichina. conducir, v. pushana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1428, 'conductor', '0', 'conductor',
        '<div class="word--description">             <p class="word--description">v. purichik, pushak. conejillo de indias, s. kuwi, kuy. conejo, s. wallinku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1429, 'confrontar', '0', 'confrontar',
        '<div class="word--description">             <p class="word--description">v. niawinchina; ideas: chimpa-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1430, 'confundir', '0', 'confundir',
        '<div class="word--description">             <p class="word--description">v. pantachina, chapuna. confundirse, v. pantana. confusión, s. pantay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1431, 'conglomerarse', '0', 'conglomerarse',
        '<div class="word--description">             <p class="word--description">v. tantarinakuna, wayka-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1432, 'rina', '0', 'rina',
        '<div class="word--description">             <p class="word--description">zimpunina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1433, 'congreso', '0', 'congreso',
        '<div class="word--description">             <p class="word--description">s. tantanakuy. conocedor, s. riksik; yachak. conocer, v. riksina. consejero, s. kunak. consejo, s. kunay, kunakuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1434, 'conservar', '0', 'conservar',
        '<div class="word--description">             <p class="word--description">v. wakaychina; allichina. constelación un tipo de, s. munzira. construir, v. rurana; acequias: larkana, rar- kana; casas: wasichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1435, 'consuegra', '0', 'consuegra',
        '<div class="word--description">             <p class="word--description">s. hawya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1436, 'contador qichwa (objeto)', '0', 'contador qichwa (objeto)',
        '<div class="word--description">             <p class="word--description">s. yupana; per- sona que cuenta, persona: yupak; de fabu- las: hawarikuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1437, 'contaminación', '0', 'contaminación',
        '<div class="word--description">             <p class="word--description">s. miyuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1438, 'contaminar', '0', 'contaminar',
        '<div class="word--description">             <p class="word--description">v. miyuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1439, 'contar', '0', 'contar',
        '<div class="word--description">             <p class="word--description">s. numeros: yupana; contar fabu- las: hawarikuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1440, 'contento', '0', 'contento',
        '<div class="word--description">             <p class="word--description">adv. kushilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1441, 'contestar', '0', 'contestar',
        '<div class="word--description">             <p class="word--description">v. kutichina, rantipana, tikra- china.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1442, 'contraer el mal aire', '0', 'contraer el mal aire',
        '<div class="word--description">             <p class="word--description">v. wayrana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1443, 'contraerse los musculos', '0', 'contraerse los musculos',
        '<div class="word--description">             <p class="word--description">v. rapyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1444, 'contratiempo', '0', 'contratiempo',
        '<div class="word--description">             <p class="word--description">s. llaki, harkay. convalecerse, v. kariyana, alliyana. conversación, s. rimanakuy. conversar, v. rimana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1445, 'convertirse en', '0', 'convertirse en',
        '<div class="word--description">             <p class="word--description">v. tukuna. convidar, v. karana. convocar, v. kayana. cooperación, s. yanapay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1446, 'copular', '0', 'copular',
        '<div class="word--description">             <p class="word--description">v. upina, yukuna, yumana. corazón, s. shunku, puka shunku; de los animales: <*puywan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1447, 'corcobado', '0', 'corcobado',
        '<div class="word--description">             <p class="word--description">adj. kumu. cordel, s. watu. cordillera, s. kahas, puna. corona, s. llawtu. coronilla, s. mukuku. corral, s. harkashka, kincha. correa, s. chumpi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1448, 'corredor (atleta)', '0', 'corredor (atleta)',
        '<div class="word--description">             <p class="word--description">s. kallpak; parte de la</p>          </div>',
        'ACTIVE', 2, '-'),
       (1449, 'casa: kanchapunku. correo', '0', 'casa: kanchapunku. correo',
        '<div class="word--description">             <p class="word--description">persona, s. chaski. correr, v. kallpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1450, 'cortapelos', '0', 'cortapelos',
        '<div class="word--description">             <p class="word--description">s. tsikaru, akcha shuwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1451, 'cortar', '0', 'cortar',
        '<div class="word--description">             <p class="word--description">v. kuchuna, pitina; gramíneas: pi- tina, ichuna; hierba: kiwana; el pelo y la lana: rutuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1452, 'corte del cabello', '0', 'corte del cabello',
        '<div class="word--description">             <p class="word--description">s. rutuchikuy, rutuy. cortesía, dirijida a las mujeres, expr. mikya. corteza, s. kara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1453, 'corto', '0', 'corto',
        '<div class="word--description">             <p class="word--description">adj. kuru, kutu. cosa, s. ima. coscoja, s. llama uhu. cosecha, s. pallay. cosechador, s. pallak. cosechar, v. pallana. coser, v. sirana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1454, 'costa', '0', 'costa',
        '<div class="word--description">             <p class="word--description">región costenia, s. yunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1455, 'costal', '0', 'costal',
        '<div class="word--description">             <p class="word--description">s. kutama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1456, 'costenio', '0', 'costenio',
        '<div class="word--description">             <p class="word--description">persona de la costa, adj. (<*yun- karuna).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1457, 'costra', '0', 'costra',
        '<div class="word--description">             <p class="word--description">s. karacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1458, 'costurero', '0', 'costurero',
        '<div class="word--description">             <p class="word--description">-a, v. sirak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1459, 'coya', '0', 'coya',
        '<div class="word--description">             <p class="word--description">s. kuya, esposa del inka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1460, 'craneo', '0', 'craneo',
        '<div class="word--description">             <p class="word--description">s. uma tullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1461, 'creador', '0', 'creador',
        '<div class="word--description">             <p class="word--description">s. kamak, wallpak, rurak, yacha- chik; divinidad: pacha yachachik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1462, 'crear', '0', 'crear',
        '<div class="word--description">             <p class="word--description">v. kamana, wallpana, rurana, yacha-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1463, 'crecer', '0', 'crecer',
        '<div class="word--description">             <p class="word--description">v. winiana; pegado los frutos: pall- kayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1464, 'creencia', '0', 'creencia',
        '<div class="word--description">             <p class="word--description">s. iniikuy. creer, v. iniina. creyente, s. iniikuk. criado, adj. china. criado, adj. yana. crisis, adj. chiki, llaki. criticar, v. washarimana. crocante, adj. kawlla. crucificar, v. chakatana. crudo, adj. chawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1465, 'cruz', '0', 'cruz',
        '<div class="word--description">             <p class="word--description">s. chakata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1466, 'cruzar (al frente', '0', 'cruzar (al frente',
        '<div class="word--description">             <p class="word--description">al otro lado de la calle o del río), v. chimpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1467, 'cuaderno', '0', 'cuaderno',
        '<div class="word--description">             <p class="word--description">s. killkanapatma, killkanapanka. cuadro, recuadro, s. (<*tapta); shuyu. cuagulo, s. tukru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1468, 'cual?', '0', 'cual?',
        '<div class="word--description">             <p class="word--description">pron. ¿maykan?. cuando?, adv. ¿hayka?. cuantos?, pron. ¿mashna?. cuarenta, num. chusku chunka. cuarto, s. (<*pitita, killi); uku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1469, 'cuatro mil', '0', 'cuatro mil',
        '<div class="word--description">             <p class="word--description">num. chusku waranka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1470, 'cuatro', '0', 'cuatro',
        '<div class="word--description">             <p class="word--description">num. chusku, tawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1471, 'cuatro cientos', '0', 'cuatro cientos',
        '<div class="word--description">             <p class="word--description">num. chusku pachak, chusku patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1472, 'cubrir', '0', 'cubrir',
        '<div class="word--description">             <p class="word--description">v. katana, killpana; la cabeza: lunku- china.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1473, 'cubrirse', '0', 'cubrirse',
        '<div class="word--description">             <p class="word--description">v. killparina; la cabeza: tiyunku- llina; de maleza un lugar: witayana. cucaracha, s. hallkan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1474, 'cuchara', '0', 'cuchara',
        '<div class="word--description">             <p class="word--description">s. (<*wislla), wishina. cucharón, s. mama wishina, mamawislla. cuchillo, s. kuchuna; cuchillo, como el segur: (<* tumi).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1475, 'cuello', '0', 'cuello',
        '<div class="word--description">             <p class="word--description">s. kunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1476, 'cuenco de la mano', '0', 'cuenco de la mano',
        '<div class="word--description">             <p class="word--description">s. maki uku. cuentas (de collares), s. mullu, wallka. cuento (antiguo), s. niawparimay. cuerdo, adj. llimpi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1477, 'cuero', '0', 'cuero',
        '<div class="word--description">             <p class="word--description">s. kara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1478, 'cuerpo', '0', 'cuerpo',
        '<div class="word--description">             <p class="word--description">s. aycha, ukku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1479, 'cueva', '0', 'cueva',
        '<div class="word--description">             <p class="word--description">s. chinkana, hutku, machay, uku. cuidado!, expresión prohibitiva, ¡niatak!. cuidador, s. kamak; de la casa: wasika- mak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1480, 'cuidadosamente', '0', 'cuidadosamente',
        '<div class="word--description">             <p class="word--description">adv. allilla, allimanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1481, 'cuidar', '0', 'cuidar',
        '<div class="word--description">             <p class="word--description">v. kamana, rikuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1482, 'culebra', '0', 'culebra',
        '<div class="word--description">             <p class="word--description">s. machakuy, machakway, palu, ushukullin, ukumpi, illulli, pitalala. culminación, s. tukuri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1483, 'culminar', '0', 'culminar',
        '<div class="word--description">             <p class="word--description">v. tukuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1484, 'culo', '0', 'culo',
        '<div class="word--description">             <p class="word--description">s. siki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1485, 'culpa', '0', 'culpa',
        '<div class="word--description">             <p class="word--description">s. hucha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1486, 'culpar', '0', 'culpar',
        '<div class="word--description">             <p class="word--description">v. huchanchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1487, 'cultivar (la tierra para la siembra)', '0', 'cultivar (la tierra para la siembra)',
        '<div class="word--description">             <p class="word--description">v. chak- mana, chakrana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1488, 'cultura', '0', 'cultura',
        '<div class="word--description">             <p class="word--description">s. (<**ayarqapaq), ayarkapak;</p>          </div>',
        'ACTIVE', 2, '-'),
       (1489, 'cumbre', '0', 'cumbre',
        '<div class="word--description">             <p class="word--description">s. uma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1490, 'cuniada', '0', 'cuniada',
        '<div class="word--description">             <p class="word--description">s. kachun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1491, 'curandero', '0', 'curandero',
        '<div class="word--description">             <p class="word--description">s. hampik, chuntapala, sakra. curar, v. hampina; del espanto: shunku- china.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1492, 'curarse', '0', 'curarse',
        '<div class="word--description">             <p class="word--description">v. alliyana, hampirina. curiquingue, ave, s. kurikinki. curso escolar, s. pata. curva, adj. kinku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1493, 'curvar', '0', 'curvar',
        '<div class="word--description">             <p class="word--description">v. kinkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1494, 'cuy', '0', 'cuy',
        '<div class="word--description">             <p class="word--description">s. (<*quwi); kuwi, kuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1495, 'chacra', '0', 'chacra',
        '<div class="word--description">             <p class="word--description">s. chakra.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1496, 'chalina (a colores)', '0', 'chalina (a colores)',
        '<div class="word--description">             <p class="word--description">s. makana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1497, 'chistoso', '0', 'chistoso',
        '<div class="word--description">             <p class="word--description">(<*hawkaq), chawcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1498, 'chivo', '0', 'chivo',
        '<div class="word--description">             <p class="word--description">s. chita.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1499, 'chamburo', '0', 'chamburo',
        '<div class="word--description">             <p class="word--description">s. champuru; pequenio: chilli- wakan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1500, 'chamico (planta silvestre pequenia)', '0', 'chamico (planta silvestre pequenia)',
        '<div class="word--description">             <p class="word--description">s. chamiku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1501, 'chamisa', '0', 'chamisa',
        '<div class="word--description">             <p class="word--description">s. chinta. chamuscar, v. kaspana. chancho, s. kuchi. charco, s. kucha, punsa. chibolo, s. zupu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1502, 'chicha', '0', 'chicha',
        '<div class="word--description">             <p class="word--description">s. aswa; de maiz tierno: antuchi;</p>          </div>',
        'ACTIVE', 2, '-'),
       (1503, 'chichón', '0', 'chichón',
        '<div class="word--description">             <p class="word--description">s. zupu. chilca, s. chillka. chillar, v. kaparina. chímbalo, s. chimpalu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1504, 'chocho', '0', 'chocho',
        '<div class="word--description">             <p class="word--description">s. (<*tarwi), tawri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1505, 'choclo', '0', 'choclo',
        '<div class="word--description">             <p class="word--description">s. chukllu; en proceso de for- mación: kiki; maduro: tsiwi; bien maduro: kaw; deshidratado: chuchuka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1506, 'chofer', '0', 'chofer',
        '<div class="word--description">             <p class="word--description">s. purichik. chorrear, v. shutuna. chorrera, s. pakcha. choza, s. chuklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1507, 'chulpi', '0', 'chulpi',
        '<div class="word--description">             <p class="word--description">variedad de maíz, s. chullpi. chumado, adj. shinka. chumarse, v. shinkayana. chonta, s. chunta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1508, 'chupar', '0', 'chupar',
        '<div class="word--description">             <p class="word--description">v. chumkana, tsumkana, lutsana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1509, 'chuquirahua', '0', 'chuquirahua',
        '<div class="word--description">             <p class="word--description">s. chukirawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1510, 'churo', '0', 'churo',
        '<div class="word--description">             <p class="word--description">s. caracolillo: churu; tipo de juego con canicas, s. churu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1511, 'danta', '0', 'danta',
        '<div class="word--description">             <p class="word--description">s. sachawakra. danzante, s. tushuk. danza, s. tushuy. danzar, v. tushuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1512, 'llana; algo en testamento: sakina. delante', '0', 'llana; algo en testamento: sakina. delante',
        '<div class="word--description">             <p class="word--description">adv. niawpak. delantero, s. niawpak. delgado, adj. hamchi, nianiu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1513, 'daniar', '0', 'daniar',
        '<div class="word--description">             <p class="word--description">v. wakllichina, wakllina; la lancha a</p>          </div>',
        'ACTIVE', 2, '-'),
       (1514, 'daniarse', '0', 'daniarse',
        '<div class="word--description">             <p class="word--description">v. challana; los frutos: zulayana. dar, v. kuna; dar de comer: karana; dar a luz: pakarina, wachana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1515, 'de ahí', '0', 'de ahí',
        '<div class="word--description">             <p class="word--description">conj. chaymanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1516, 'de balde', '0', 'de balde',
        '<div class="word--description">             <p class="word--description">adv. yanka, yankamanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1517, 'de esta manera', '0', 'de esta manera',
        '<div class="word--description">             <p class="word--description">adv. kay shina, kashna. de esa manera, adv. chay shina, chashna. de golpe, adv. haykamanta, zas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1518, 'de la misma forma o manera', '0', 'de la misma forma o manera',
        '<div class="word--description">             <p class="word--description">conj. shi-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1519, 'de nuevo', '0', 'de nuevo',
        '<div class="word--description">             <p class="word--description">adv. kutin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1520, 'de pronto', '0', 'de pronto',
        '<div class="word--description">             <p class="word--description">adv. haykamanta, kunkay- manta, zas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1521, 'de todas maneras', '0', 'de todas maneras',
        '<div class="word--description">             <p class="word--description">conj. shinapash.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1522, 'debajero', '0', 'debajero',
        '<div class="word--description">             <p class="word--description">s. ukunchina. debajo de, adv. uku. debil, adj. api, irki, sampa. decada, adv. chunkawata. decaerse, v. urmarina. decir, v. nina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1523, 'declamar', '0', 'declamar',
        '<div class="word--description">             <p class="word--description">v. luwana. declarado, adj. willashka. declarar, v. willana. declive, adv. kinray, uray.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1524, 'decorar', '0', 'decorar',
        '<div class="word--description">             <p class="word--description">v. allichina, sumakyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1525, 'dedo', '0', 'dedo',
        '<div class="word--description">             <p class="word--description">s. (<*rukana), ruka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1526, 'defecar', '0', 'defecar',
        '<div class="word--description">             <p class="word--description">v. ismana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1527, 'defender', '0', 'defender',
        '<div class="word--description">             <p class="word--description">v. mitsana, michana, mitsana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1528, 'deformarse', '0', 'deformarse',
        '<div class="word--description">             <p class="word--description">v. wistuna. deforme de la boca, adj. wistu. degollado, adj. nakashka. degollador, s. nakak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1529, 'degollar', '0', 'degollar',
        '<div class="word--description">             <p class="word--description">v. nakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1530, 'deidad', '0', 'deidad',
        '<div class="word--description">             <p class="word--description">s. wirakucha, pachakamak, pacha yachachik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1531, 'dejar', '0', 'dejar',
        '<div class="word--description">             <p class="word--description">v. sakina; algo al descubierto: pak-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1532, 'delicado', '0', 'delicado',
        '<div class="word--description">             <p class="word--description">adj. chawcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1533, 'delicioso', '0', 'delicioso',
        '<div class="word--description">             <p class="word--description">adj. (<*niukniu), mishki. delirar, v. musparina, shimi-chinkachina. demas, adv. yalli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1534, 'demasiado', '0', 'demasiado',
        '<div class="word--description">             <p class="word--description">adv. yalliymana, yalli, yapa. demorarse, v. kaynana, unayana. demostrar, v. rikuchina. demostrativo, s. rikuchik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1535, 'dentro', '0', 'dentro',
        '<div class="word--description">             <p class="word--description">adv. uku. departamento, s. (<*pitita, killi). deposición, s. isma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1536, 'depositar', '0', 'depositar',
        '<div class="word--description">             <p class="word--description">v. wakaychina, churana; male-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1537, 'zas en las orillas de la chacra: chintana. depósito', '0',
        'zas en las orillas de la chacra: chintana. depósito',
        '<div class="word--description">             <p class="word--description">mesón del incario, s. tampu. depresión (anímica), s. kalakyay. deprimirse, v. hamallina, impayana, llakirina. derecho, leyes, s. <*kamachinakuy. derecho, lado, adv. allawka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1538, 'derramar', '0', 'derramar',
        '<div class="word--description">             <p class="word--description">v. hichana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1539, 'derritirse', '0', 'derritirse',
        '<div class="word--description">             <p class="word--description">v. nuyuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1540, 'derrochar', '0', 'derrochar',
        '<div class="word--description">             <p class="word--description">v. usuchina, yakuyachina. derrumbarse, v. tuniirina, tularina. desabrido, adj. chamcha, chamuk, hamlla, hamun, niukniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1541, 'desamparar', '0', 'desamparar',
        '<div class="word--description">             <p class="word--description">v. hichuna, sakina, shitana. desarrollarse, v. winiakuna, winiana. desauciado (a punto de morir), adj. aya- kara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1542, 'desayunar', '0', 'desayunar',
        '<div class="word--description">             <p class="word--description">v. (<*paqarinmikuy), pakarinmi- kuna, chinchina, shunkuna, shunkunchina. desayuno, s. (<*paqarinmikuy), pakarinmi- kuy, chinchiy, shunkuy, shunkunchiy. desbordarse, v. tallina, shiwtana. descalzo, adj. lluchu chaki, llapanku. descamar, v. shikina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1543, 'descansar', '0', 'descansar',
        '<div class="word--description">             <p class="word--description">v. samana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1544, 'descanso', '0', 'descanso',
        '<div class="word--description">             <p class="word--description">s. samay; día de descanso: samay puncha; tiempo de descanso: samay</p>          </div>',
        'ACTIVE', 2, '-'),
       (1545, 'descarriarse', '0', 'descarriarse',
        '<div class="word--description">             <p class="word--description">v. challana, challina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1546, 'descascarar', '0', 'descascarar',
        '<div class="word--description">             <p class="word--description">v. llakana, rawmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1547, 'despacio', '0', 'despacio',
        '<div class="word--description">             <p class="word--description">adv. allilla, allimanta. despedir, v. kachana, karkuna. despejado, adj. paklla. despejar, v. pakllana, paskana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1548, 'descender', '0', 'descender',
        '<div class="word--description">             <p class="word--description">v. urayana, uraykuna, way- kuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1549, 'descogollar palmeras', '0', 'descogollar palmeras',
        '<div class="word--description">             <p class="word--description">v. yuyuna. descomposición, s. conducta: wakllikuy; daniarse las cosas: putasyay. descomponer, v. chakchuna. descomponerse (daniarse), v. putasyana. desconocido, adj. mana riksishka, chuku, hullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1550, 'descriarse', '0', 'descriarse',
        '<div class="word--description">             <p class="word--description">v. challana. descuartizado, adj. nakashka. descuartizar, v. nakana. desdeniar, v. hunkana. desear, v. munana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1551, 'desenredar (el pelo o cosas semejantes)', '0', 'desenredar (el pelo o cosas semejantes)',
        '<div class="word--description">             <p class="word--description"></p>          </div>', 'ACTIVE', 2,
        '-'),
       (1552, 'v. shampana. desgajar', '0', 'v. shampana. desgajar',
        '<div class="word--description">             <p class="word--description">v. llakllana. desgastar, v. kaskana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1553, 'desgracia', '0', 'desgracia',
        '<div class="word--description">             <p class="word--description">adj. chiki, llaki. desgranar, v. chiwana, ishkuna. deshierbar, v. kiwana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1554, 'deshojar', '0', 'deshojar',
        '<div class="word--description">             <p class="word--description">v. llakana, rawchana, rawmana;</p>          </div>',
        'ACTIVE', 2, '-'),
       (1555, 'el maíz: tipina', '0', 'el maíz: tipina',
        '<div class="word--description">             <p class="word--description">saklana. desigual, adj. waka. desigualar, v. wakayachina. desigualarse, v. wakayana. desleír, v. yakuyachina. desleirse, v. nuyuna, yakuyana. deslizar, v. aysana, lluchkana. deslizarse, v. llushpina. desmayarse, v. shinkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1556, 'desmenuzar', '0', 'desmenuzar',
        '<div class="word--description">             <p class="word--description">v. hakuna, palikina. desmontar maleza, v. chakuna. desmoronarse, v. tuniirina, chiwana. desnudarse, v. llatanana. desnudo, adj. llatan, lluchu, llushti. desobedecer, v. mana-uyana. desobediente, adj. mana-uyak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1557, 'desobediencia', '0', 'desobediencia',
        '<div class="word--description">             <p class="word--description">adj. mana-uyay; expre-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1558, 'sión de desobediencia: hay. desolado', '0', 'sión de desobediencia: hay. desolado',
        '<div class="word--description">             <p class="word--description">adv. chulunlla. desordenar, v. wakllina, chapuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1559, 'desovar (los peces hembras sus huevos)', '0', 'desovar (los peces hembras sus huevos)',
        '<div class="word--description">             <p class="word--description"></p>          </div>', 'ACTIVE', 2,
        '-'),
       (1560, 'despellejar', '0', 'despellejar',
        '<div class="word--description">             <p class="word--description">v. llakana, lluchuna, llushtina, rawmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1561, 'despeniadero', '0', 'despeniadero',
        '<div class="word--description">             <p class="word--description">s. kaka. desperdiciar, v. <*usuchiy. despertarse, v. rikcharina. despiojar, v. usana. despostillarse, v. tukyana. despreciar, v. chiknina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1562, 'desprecio', '0', 'desprecio',
        '<div class="word--description">             <p class="word--description">s. chikniy; expresión de despre-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1563, 'despues', '0', 'despues',
        '<div class="word--description">             <p class="word--description">adv. kipa, washa; conj. chay- manta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1564, 'desramar', '0', 'desramar',
        '<div class="word--description">             <p class="word--description">v. chillpina, rawchana, raw- mana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1565, 'destrucción grande', '0', 'destrucción grande',
        '<div class="word--description">             <p class="word--description">general, s. pacha- kuti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1566, 'destruir plantas y/o frutos una plaga', '0', 'destruir plantas y/o frutos una plaga',
        '<div class="word--description">             <p class="word--description">v. lanchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1567, 'desvariar', '0', 'desvariar',
        '<div class="word--description">             <p class="word--description">v. tapyana. desventura, s. llaki. desvestirse, v. llatanarina. desviar un río, v. chiktana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1568, 'desviarse (de los valores)', '0', 'desviarse (de los valores)',
        '<div class="word--description">             <p class="word--description">v. challiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1569, 'desyerbar', '0', 'desyerbar',
        '<div class="word--description">             <p class="word--description">v. hallmay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1570, 'detener', '0', 'detener',
        '<div class="word--description">             <p class="word--description">v. harkana, shayarichina. detenerse, v. shayana. deteriorar, v. wakllichina. deuda, s. <*manu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1571, 'devolver', '0', 'devolver',
        '<div class="word--description">             <p class="word--description">v. kutichina, tikrachina; la vista a</p>          </div>',
        'ACTIVE', 2, '-'),
       (1572, 'día', '0', 'día',
        '<div class="word--description">             <p class="word--description">s. puncha; medio día: chawpi puncha; el día siguiente, adv.: kaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1573, 'diadema', '0', 'diadema',
        '<div class="word--description">             <p class="word--description">s. llawtu. dialogar, v. rimanakuna. dialogo, s. rimanakuy. diamante, s. <*yurak uminia.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1574, 'diariamente', '0', 'diariamente',
        '<div class="word--description">             <p class="word--description">adv. punchanta punchanta,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1575, 'diarrea', '0', 'diarrea',
        '<div class="word--description">             <p class="word--description">s. kicha; tener diarrea: kichay. dibujar, v. <*llimpikuy, hawina, shuyuna. dibujo, s. (<*llimpisqa), shuyu. diccionario, s. shimiyuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1576, 'diciembre', '0', 'diciembre',
        '<div class="word--description">             <p class="word--description">s. <*kapak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1577, 'dicha', '0', 'dicha',
        '<div class="word--description">             <p class="word--description">s. kushi, sami.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1578, 'dicho', '0', 'dicho',
        '<div class="word--description">             <p class="word--description">adj. nishka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1579, 'dichoso', '0', 'dichoso',
        '<div class="word--description">             <p class="word--description">adj. kushilla, samiyuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1580, 'diente', '0', 'diente',
        '<div class="word--description">             <p class="word--description">s. kiru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1581, 'diez mil', '0', 'diez mil',
        '<div class="word--description">             <p class="word--description">num. (<*hunu). diez, num. chunka. diferenciar, v. chikanyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1582, 'difícil', '0', 'difícil',
        '<div class="word--description">             <p class="word--description">adj. sinchi; de cocinarse: kaluk, llumi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1583, 'difunto', '0', 'difunto',
        '<div class="word--description">             <p class="word--description">adj. waniushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1584, 'digno de lastima', '0', 'digno de lastima',
        '<div class="word--description">             <p class="word--description">adj. kuyaylla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1585, 'diluír', '0', 'diluír',
        '<div class="word--description">             <p class="word--description">v. yakuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1586, 'diluirse', '0', 'diluirse',
        '<div class="word--description">             <p class="word--description">v. yakuyarina. diminuta, cosa, s. iniu; chusu. dinero, s. kullki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1587, 'dios no lo quiera', '0', 'dios no lo quiera',
        '<div class="word--description">             <p class="word--description">adv. amallatak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1588, 'dios', '0', 'dios',
        '<div class="word--description">             <p class="word--description">s. achillik-yaya; dios de los incas: wi- rakucha, pachakamak; dios familiar: waka. dirección, s. kuska.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1589, 'dirigente', '0', 'dirigente',
        '<div class="word--description">             <p class="word--description">s. pushak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1590, 'dirigir', '0', 'dirigir',
        '<div class="word--description">             <p class="word--description">v. pushana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1591, 'disco', '0', 'disco',
        '<div class="word--description">             <p class="word--description">s. piruru; disco musical: takik-piruru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1592, 'disculpar', '0', 'disculpar',
        '<div class="word--description">             <p class="word--description">v. kishpichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1593, 'discursar', '0', 'discursar',
        '<div class="word--description">             <p class="word--description">v. luwana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1594, 'discutir', '0', 'discutir',
        '<div class="word--description">             <p class="word--description">meterse en discusiones, v. hawina. disentería, s. yawarkicha. disgustarse, v. piniarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1595, 'dislocar', '0', 'dislocar',
        '<div class="word--description">             <p class="word--description">v. kiwina. disparar, v. tukyachina. dispensar, v. kishpichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1596, 'dispersarse', '0', 'dispersarse',
        '<div class="word--description">             <p class="word--description">v. chawsirina, tallirina. distante, en el espacio, adv. karu. distinguido, adj. kapak; sumak. distinto, adj. chikan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1597, 'distribuir', '0', 'distribuir',
        '<div class="word--description">             <p class="word--description">v. rakina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1598, 'dividir', '0', 'dividir',
        '<div class="word--description">             <p class="word--description">v. pakina, rakina; en la mitad: chaw- pina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1599, 'divinidad del incario', '0', 'divinidad del incario',
        '<div class="word--description">             <p class="word--description">s. wirakucha, pa- chakamak; divinidad que creó los insectos: palamaku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1600, 'división', '0', 'división',
        '<div class="word--description">             <p class="word--description">s. rakiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1601, 'doblar', '0', 'doblar',
        '<div class="word--description">             <p class="word--description">v. lapuna, patarina. docente, s. yachachik. doler, v. nanana. dolerse, v. nanarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1602, 'dolor', '0', 'dolor',
        '<div class="word--description">             <p class="word--description">s. llaki, nanay; agudo por tumores,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1603, 'domesticar', '0', 'domesticar',
        '<div class="word--description">             <p class="word--description">v. wiwana, uywana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1604, 'domingo', '0', 'domingo',
        '<div class="word--description">             <p class="word--description">s. <*hawkay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1605, 'don', '0', 'don',
        '<div class="word--description">             <p class="word--description">s. hachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1606, 'dónde?', '0', 'dónde?',
        '<div class="word--description">             <p class="word--description">preg. ¿mayman?. donia, s. mama. dormido, adj. puniushka. dormiente, s. puniukuk. dormir, v. puniuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1607, 'dorso de la mano', '0', 'dorso de la mano',
        '<div class="word--description">             <p class="word--description">s. maki washa. dos mil, num. ishkay waranka. dos, num. ishkay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1608, 'doscientos', '0', 'doscientos',
        '<div class="word--description">             <p class="word--description">num. ishkay pachak, ishkay</p>          </div>',
        'ACTIVE', 2, '-'),
       (1609, 'dudar', '0', 'dudar',
        '<div class="word--description">             <p class="word--description">v. tunkina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1610, 'duende', '0', 'duende',
        '<div class="word--description">             <p class="word--description">s. chusulunku, aya, tunchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1611, 'duenio de casa', '0', 'duenio de casa',
        '<div class="word--description">             <p class="word--description">s. wasiyuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1612, 'dulce', '0', 'dulce',
        '<div class="word--description">             <p class="word--description">adj. mishki, chawcha; de cabuya: chawar mishki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1613, 'duro', '0', 'duro',
        '<div class="word--description">             <p class="word--description">adj. anak, sinchi, taylla; de cocinarse: akma, kaluk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1614, 'duo', '0', 'duo',
        '<div class="word--description">             <p class="word--description">s. ishkantin, yanantin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1615, 'echar', '0', 'echar',
        '<div class="word--description">             <p class="word--description">v. kachana; fuera: karkuna. echarse (en el suelo), v. siririna. edad, s. winiay, mita. educación, s. yachachikuy. educador, -a, s. yachachik. ejemplar, s. shina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1616, 'ejemplo', '0', 'ejemplo',
        '<div class="word--description">             <p class="word--description">s. shina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1617, 'el', '0', 'el',
        '<div class="word--description">             <p class="word--description">pron. pay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1618, 'electricidad', '0', 'electricidad',
        '<div class="word--description">             <p class="word--description">s. <**illariy; zirmay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1619, 'elegante', '0', 'elegante',
        '<div class="word--description">             <p class="word--description">adj. taslla. elegir, v. akllana. elevado, adv. hanak. ella, pron. pay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1620, 'ellas', '0', 'ellas',
        '<div class="word--description">             <p class="word--description">-os, pron. paykuna. embarazada, adj. chichu, wiksayuk. embarrar, v. hawina. embarrarse, v. turuyarina. embellecer, v. sumakyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1621, 'en cinta', '0', 'en cinta',
        '<div class="word--description">             <p class="word--description">adj. chichu, wiksayuk. en dónde?, preg. ¿maypitak?. enero, s. <*kamay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1622, 'en exceso', '0', 'en exceso',
        '<div class="word--description">             <p class="word--description">adv. manchanay, llashak, yalli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1623, 'en sano juicio', '0', 'en sano juicio',
        '<div class="word--description">             <p class="word--description">adj. mayllik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1624, 'en seguida', '0', 'en seguida',
        '<div class="word--description">             <p class="word--description">adv. haykamanta, niapash, zas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1625, 'en silencio', '0', 'en silencio',
        '<div class="word--description">             <p class="word--description">adv. chulunlla, upalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1626, 'en sus cabales', '0', 'en sus cabales',
        '<div class="word--description">             <p class="word--description">adj. mayllik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1627, 'en vano', '0', 'en vano',
        '<div class="word--description">             <p class="word--description">adv. yanka, yankamanta. enano, adj. kurpa, umutu. encanijarse, v. kintiyarina. encapricharse, v. nanakyarina. encargar, v. minkana. encender la luz, v. hapichina. encerrar, v. wichkay. encharcarse, v. kuchayarina. encías, s. mimish.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1628, 'encima', '0', 'encima',
        '<div class="word--description">             <p class="word--description">adv. hanak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1629, 'emblema', '0', 'emblema',
        '<div class="word--description">             <p class="word--description">s. unancha; del Tawantin suyu: wipala.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1630, 'embobar', '0', 'embobar',
        '<div class="word--description">             <p class="word--description">v. umana, upayachina. embobarse, v. upayarina. emborracharse, v. machay, shinkayay. embriagado, adj. totalmente: machashka; semiembriagado: shinka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1631, 'embriagarse', '0', 'embriagarse',
        '<div class="word--description">             <p class="word--description">v. machana, shinkayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1632, 'embustero', '0', 'embustero',
        '<div class="word--description">             <p class="word--description">adj. challi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1633, 'embutir', '0', 'embutir',
        '<div class="word--description">             <p class="word--description">v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1634, 'emitir sonidos (los animales)', '0', 'emitir sonidos (los animales)',
        '<div class="word--description">             <p class="word--description">v. wakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1635, 'empalagar', '0', 'empalagar',
        '<div class="word--description">             <p class="word--description">v. amina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1636, 'empalagoso (dulcísimo)', '0', 'empalagoso (dulcísimo)',
        '<div class="word--description">             <p class="word--description">adj. niukniu. empaparse, v. hukuna, mutiyana. empeorarse, v. anchayana. empeine del pie, s. pichuski. emperrado, adj. llumi, llumiyashka. emperrarse, v. llumiyana, isiyana. empezado, v. kallarishka. empezar, v. kallarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1637, 'empollar', '0', 'empollar',
        '<div class="word--description">             <p class="word--description">s. ukllay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1638, 'empujar', '0', 'empujar',
        '<div class="word--description">             <p class="word--description">v. suchuchina, tankana; arboles para derribarlos: tulay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1639, 'en ayunas', '0', 'en ayunas',
        '<div class="word--description">             <p class="word--description">adv. mayllakshunku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1640, 'encogerse', '0', 'encogerse',
        '<div class="word--description">             <p class="word--description">v. kintiyarina, kuruyana, kutu- yana, tuzuyana, waniurina. encolerizarse, v. piniarina. encomendar, v. minkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1641, 'enconarse las heridas', '0', 'enconarse las heridas',
        '<div class="word--description">             <p class="word--description">v. kiyayay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1642, 'encontrar', '0', 'encontrar',
        '<div class="word--description">             <p class="word--description">v. tarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1643, 'encontrarse (con alguien)', '0', 'encontrarse (con alguien)',
        '<div class="word--description">             <p class="word--description">v. tarinakurina. encorralar, hacer corrales, v. kinchana. endurarse, v. taktariy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1644, 'energía', '0', 'energía',
        '<div class="word--description">             <p class="word--description">s. kallpa, kushi; energía sexual ne-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1645, 'gativa que causa enfermedad diarreica', '0', 'gativa que causa enfermedad diarreica',
        '<div class="word--description">             <p class="word--description">no identificada por la medicina actual: zalipa. enero, s. <*kamay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1646, 'enfermarse', '0', 'enfermarse',
        '<div class="word--description">             <p class="word--description">v.	unkurina;	persisten-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1647, 'enfermedad', '0', 'enfermedad',
        '<div class="word--description">             <p class="word--description">s. unkuy; persistente: takyak- unkuy; que provoca un ser mítico: s. sisu. enfermo, adj. unkushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1648, 'enfriar', '0', 'enfriar',
        '<div class="word--description">             <p class="word--description">líquidos: v. chiriyachina, tsuklupuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1649, 'enfurecerse', '0', 'enfurecerse',
        '<div class="word--description">             <p class="word--description">v. millayarina. enganiar, v. umachina, umakuna. engrosarse, v. rakuyana. engullir, v. amullina. enlagunarse, formarse un lago:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1650, 'enlodarse', '0', 'enlodarse',
        '<div class="word--description">             <p class="word--description">v. turuyana. enlucir, v. llampuna, llunchina. enmudecerse, v. upayarina. enojado, adj. pinia, piniashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1651, 'enojarse', '0', 'enojarse',
        '<div class="word--description">             <p class="word--description">v. piniarina, nanakyarina, millaya-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1652, 'rina', '0', 'rina',
        '<div class="word--description">             <p class="word--description">waniurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1653, 'enraizarse', '0', 'enraizarse',
        '<div class="word--description">             <p class="word--description">v. sapiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1654, 'enredado', '0', 'enredado',
        '<div class="word--description">             <p class="word--description">adj. chaknarishka, pillurishka; (hilos) punzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1655, 'enredar', '0', 'enredar',
        '<div class="word--description">             <p class="word--description">v. pilluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1656, 'enrollar', '0', 'enrollar',
        '<div class="word--description">             <p class="word--description">v. pilluna, maytuna; bejuco: mania- yachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1657, 'enseguida', '0', 'enseguida',
        '<div class="word--description">             <p class="word--description">adv. nialla, niapash. enseniado, habituado, adj. yacharishka. enseniar, v. yachachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1658, 'enseniarse', '0', 'enseniarse',
        '<div class="word--description">             <p class="word--description">v. yacharina. enserenado, adj. ankulla. ensordecerse, v. rinri-upayarina. ensuciar, v. hawina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1659, 'ensuciarse', '0', 'ensuciarse',
        '<div class="word--description">             <p class="word--description">v. karkayarina, mapayarina,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1660, 'matayarina', '0', 'matayarina',
        '<div class="word--description">             <p class="word--description">tikayarina. entablillar, v. chanchay. entechar, v. awana, kumpana. entender, v. hamutana, hapina. entero, det. tukuy, hunta. enterrar, v. pampana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1661, 'entonar (un instrumento musical)', '0', 'entonar (un instrumento musical)',
        '<div class="word--description">             <p class="word--description">v. takina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1662, 'entrada', '0', 'entrada',
        '<div class="word--description">             <p class="word--description">s. punku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1663, 'entrar', '0', 'entrar',
        '<div class="word--description">             <p class="word--description">v. yaykuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1664, 'entrecruzar', '0', 'entrecruzar',
        '<div class="word--description">             <p class="word--description">v. chakatana; las piernas: chankana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1665, 'entrelazar', '0', 'entrelazar',
        '<div class="word--description">             <p class="word--description">v. chakatana. entretejer, v. alapana. entristecerse, v. llakirina. enumerar, s. yupay. envenenar, v. hampina, miyuna. enviar, v. kachana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1666, 'envoltorio', '0', 'envoltorio',
        '<div class="word--description">             <p class="word--description">s. maytu, mullapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1667, 'envolver', '0', 'envolver',
        '<div class="word--description">             <p class="word--description">v. maytuna, pilluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1668, 'envuelto', '0', 'envuelto',
        '<div class="word--description">             <p class="word--description">s. maytu, mullapa; adj. maytushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1669, 'epoca', '0', 'epoca',
        '<div class="word--description">             <p class="word--description">s. mita, pacha. equivocación, s. pantay. equivocado, adj. pantashka. equivocarse, v. pantarina. erizarse, v. punzuyarina. erosionarse, v. tularina. errado, adv. pantashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1670, 'errar', '0', 'errar',
        '<div class="word--description">             <p class="word--description">v. pantana. error, s. pantay. eructar, v. aknina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1671, 'erupcionar (el volcan)', '0', 'erupcionar (el volcan)',
        '<div class="word--description">             <p class="word--description">v. tukyana. es verdad? adv. ¿manachu?. esa, pron. chay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1672, 'escabroso', '0', 'escabroso',
        '<div class="word--description">             <p class="word--description">adj. sakra, paza, tsaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1673, 'escalera', '0', 'escalera',
        '<div class="word--description">             <p class="word--description">s. chakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1674, 'escamar', '0', 'escamar',
        '<div class="word--description">             <p class="word--description">v. tisana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1675, 'escarabajo', '0', 'escarabajo',
        '<div class="word--description">             <p class="word--description">s. shuntu, katsu, chuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1676, 'escarbar', '0', 'escarbar',
        '<div class="word--description">             <p class="word--description">v. aspina. escarcha, s. shulla. escasear, v. pishiyana. escaso, adv. pishi. escoba, s. pichana. escogedor, adj. akllak. escoger, v. akllana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1677, 'escogida', '0', 'escogida',
        '<div class="word--description">             <p class="word--description">adv. aklla, akllashka. esconder, v. pakana. esconderse, v. mitikurina. escopeta, s. illapa. escorbuto, s. wichu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1678, 'escribir', '0', 'escribir',
        '<div class="word--description">             <p class="word--description">v. killkana; escribir en nudos o en</p>          </div>',
        'ACTIVE', 2, '-'),
       (1679, 'escrito', '0', 'escrito',
        '<div class="word--description">             <p class="word--description">adj. killkashka. escritor, s. killkaykamayuk. escritorio, s. (<*chakiqiru). escuchar,v. uyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1680, 'escuela', '0', 'escuela',
        '<div class="word--description">             <p class="word--description">s. (<*yachaywasi), yachanawasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1681, 'esculpir', '0', 'esculpir',
        '<div class="word--description">             <p class="word--description">v. llakllana. escupir, v. aktuna, tukana. escurrir, v. chawana. ese, pron. chay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1682, 'esfera', '0', 'esfera',
        '<div class="word--description">             <p class="word--description">s. (<*rumpu), rumpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1683, 'esferografico', '0', 'esferografico',
        '<div class="word--description">             <p class="word--description">s. killkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1684, 'esmeralda', '0', 'esmeralda',
        '<div class="word--description">             <p class="word--description">s. <*qumir uminia, kumir uminia.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1685, 'eso', '0', 'eso',
        '<div class="word--description">             <p class="word--description">pron. chay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1686, 'esófago', '0', 'esófago',
        '<div class="word--description">             <p class="word--description">s. millpuna, tunkuri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1687, 'espacio', '0', 'espacio',
        '<div class="word--description">             <p class="word--description">s. pacha; exterior: hawa pacha; espacio superior: hanan pacha; espacio in- ferior: uku pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1688, 'espalda', '0', 'espalda',
        '<div class="word--description">             <p class="word--description">s. washa. espantado, adj. mancharishka. espantar, v. manchachina. espantarse, v. mancharina. espanto, s. manchay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1689, 'espaniol', '0', 'espaniol',
        '<div class="word--description">             <p class="word--description">termino que se refiere al, s. wira-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1690, 'esparcir', '0', 'esparcir',
        '<div class="word--description">             <p class="word--description">v. hichana, tallina; agua o granos: chakchuy; agua de regadío: parkuy. espejo, s. rirpu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1691, 'esperanza', '0', 'esperanza',
        '<div class="word--description">             <p class="word--description">s. shuyay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1692, 'esperar', '0', 'esperar',
        '<div class="word--description">             <p class="word--description">v. shuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1693, 'espermatozoide', '0', 'espermatozoide',
        '<div class="word--description">             <p class="word--description">s. (<*yumaynin), ullu-api.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1694, 'espeso', '0', 'espeso',
        '<div class="word--description">             <p class="word--description">adj. sanku, tikti. espíar, v. chapana. espina, -o, s. kasha. espinazo, s. washa tullu. espiral, adj. churu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1695, 'espíritu', '0', 'espíritu',
        '<div class="word--description">             <p class="word--description">s. aya, nuna, samay, supay. esposa, s. warmi; esposa del inka: (<*quya), kuya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1696, 'esposo', '0', 'esposo',
        '<div class="word--description">             <p class="word--description">s. kusa; esposo de la coya: inka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1697, 'espuma', '0', 'espuma',
        '<div class="word--description">             <p class="word--description">s. pusku. espumarse, v. puskuyarina. esquina, s. kuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1698, 'esta', '0', 'esta',
        '<div class="word--description">             <p class="word--description">pron. kay. estaca, s. takarpu. estacar, v. takarpuna. estafa, s. ayki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1699, 'estado', '0', 'estado',
        '<div class="word--description">             <p class="word--description">s. <**aylluntintinkuy. estafar, v. aykina, shuwana. estanio, s. titi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1700, 'estar', '0', 'estar',
        '<div class="word--description">             <p class="word--description">v. kana, tiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1701, 'este', '0', 'este',
        '<div class="word--description">             <p class="word--description">pron. kay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1702, 'este', '0', 'este',
        '<div class="word--description">             <p class="word--description">oriente, s. intillukshina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1703, 'esteril', '0', 'esteril',
        '<div class="word--description">             <p class="word--description">el terreno, adj. tsala, kankawa, killin, tullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1704, 'estiercol', '0', 'estiercol',
        '<div class="word--description">             <p class="word--description">s. isma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1705, 'estilarse', '0', 'estilarse',
        '<div class="word--description">             <p class="word--description">v. hukurina, mutiyarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1706, 'estirar', '0', 'estirar',
        '<div class="word--description">             <p class="word--description">v. chutana. estirpe, s. panaka. esto, pron. kay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1707, 'estómago', '0', 'estómago',
        '<div class="word--description">             <p class="word--description">s. mamapusun, mama uspun,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1708, 'estopa (de cabuya)', '0', 'estopa (de cabuya)',
        '<div class="word--description">             <p class="word--description">s. hamchi, karachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1709, 'estorbar', '0', 'estorbar',
        '<div class="word--description">             <p class="word--description">v. harkana. estorbo, s. harka. estornudar, v. atsikyana. estrangular, v. sipina. estrecho, adj. kichki. estrella, s. kuyllur. estrenar, v. arina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1710, 'estrujar', '0', 'estrujar',
        '<div class="word--description">             <p class="word--description">v. llapina, lutsana, tsutsukina. estudiado, adj. yachakushka. estudiante, s. yachakuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1711, 'estudiar', '0', 'estudiar',
        '<div class="word--description">             <p class="word--description">v. yachakuna. exageración, adv. may, manchanay. examen, s. <*taripay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1712, 'examinador', '0', 'examinador',
        '<div class="word--description">             <p class="word--description">s. <*taripak. examinar, v. <*taripay. excavar, v. allana. exceder, v. yallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1713, 'excesivamente', '0', 'excesivamente',
        '<div class="word--description">             <p class="word--description">adv. yalli, yalliymana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1714, 'excremento', '0', 'excremento',
        '<div class="word--description">             <p class="word--description">s. isma. excusar, v. kishpichina. exigir, v. atina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1715, 'existir', '0', 'existir',
        '<div class="word--description">             <p class="word--description">v. tiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1716, 'expandirse', '0', 'expandirse',
        '<div class="word--description">             <p class="word--description">v. mirarina; substancias grasosas: wisiyay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1717, 'expirar', '0', 'expirar',
        '<div class="word--description">             <p class="word--description">v. pitirina, tukurina, waniurina. exprimir, v. chawana, kapina. expulgar, v. millchina, usana. extender, v. aysana, chutana, mantana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1718, 'extenderse', '0', 'extenderse',
        '<div class="word--description">             <p class="word--description">v. aysarina, chutarina; las</p>          </div>',
        'ACTIVE', 2, '-'),
       (1719, 'extenso', '0', 'extenso',
        '<div class="word--description">             <p class="word--description">adj. suni.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1720, 'exterior', '0', 'exterior',
        '<div class="word--description">             <p class="word--description">adv. hawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1721, 'extranjero', '0', 'extranjero',
        '<div class="word--description">             <p class="word--description">adj. chuku, hullu, ransiw. extranio, adj. chuku, hullu. extremidad, s. puchukaynin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1722, 'faja', '0', 'faja',
        '<div class="word--description">             <p class="word--description">s. chumpi; la grande: mamachumpi; la pequenia: wawachumpi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1723, 'falda', '0', 'falda',
        '<div class="word--description">             <p class="word--description">s. aksu, anaku. fallecer, v. tukurina, waniuna. falsear, v. llullana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1724, 'falso', '0', 'falso',
        '<div class="word--description">             <p class="word--description">adj. llulla. falta, s. hucha. faltar, v. illana. familia, s. ayllu. fango, s. kuzu, guzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1725, 'fantasma', '0', 'fantasma',
        '<div class="word--description">             <p class="word--description">s. aya, atsinku, supay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1726, 'fardo', '0', 'fardo',
        '<div class="word--description">             <p class="word--description">s. kipi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1727, 'fastidiar', '0', 'fastidiar',
        '<div class="word--description">             <p class="word--description">v. kushparina, shillinkuna. fatigarse, v. sampayana, shaykuna. favorecer, v. yanapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1728, 'faz', '0', 'faz',
        '<div class="word--description">             <p class="word--description">s. uya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1729, 'fe', '0', 'fe',
        '<div class="word--description">             <p class="word--description">s. iniikuy; tener fe: iniiy. febrero, s. <**panchiy. felicidad, s. kushi, kushikuy. feliz, adv. kushilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1730, 'femur', '0', 'femur',
        '<div class="word--description">             <p class="word--description">s. mama tullu. fermentarse, v. timpurina. festividad, s. raymi. fiambre, s. kukayu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1731, 'fiesta', '0', 'fiesta',
        '<div class="word--description">             <p class="word--description">s. raymi; fiesta del sol: inti raymi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1732, 'figura', '0', 'figura',
        '<div class="word--description">             <p class="word--description">s. rikchak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1733, 'fila', '0', 'fila',
        '<div class="word--description">             <p class="word--description">s. wachu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1734, 'filo o agudo', '0', 'filo o agudo',
        '<div class="word--description">             <p class="word--description">adj. niawchi; filo u orilla: manya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1735, 'filtrar', '0', 'filtrar',
        '<div class="word--description">             <p class="word--description">v. shutuna. fin, s. tukuri. fingir, v. tukuna. firmar, v. aspina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1736, 'flaco', '0', 'flaco',
        '<div class="word--description">             <p class="word--description">adj. irki, tsala, tullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1737, 'flecha', '0', 'flecha',
        '<div class="word--description">             <p class="word--description">s. wachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1738, 'flojo', '0', 'flojo',
        '<div class="word--description">             <p class="word--description">adj. takla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1739, 'flor', '0', 'flor',
        '<div class="word--description">             <p class="word--description">s. sisa; macho de maíz: tuktu, tuktuma; flor hembra del maíz: chukllu akcha. floripondio, s. wantuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1740, 'flotar', '0', 'flotar',
        '<div class="word--description">             <p class="word--description">v. wampuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1741, 'fogón', '0', 'fogón',
        '<div class="word--description">             <p class="word--description">s. ninapata, tullpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1742, 'forastero', '0', 'forastero',
        '<div class="word--description">             <p class="word--description">adj. chuku, hullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1743, 'forcejear (uno con otro)', '0', 'forcejear (uno con otro)',
        '<div class="word--description">             <p class="word--description">v. chutanakuna. fortaleza (construcción), s. pukara; del cuerpo: kushi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1744, 'fósforo', '0', 'fósforo',
        '<div class="word--description">             <p class="word--description">s. ninayuk; iska.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1745, 'fotografía', '0', 'fotografía',
        '<div class="word--description">             <p class="word--description">s. (<*uyap rikchay), rikchak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1746, 'fracasar', '0', 'fracasar',
        '<div class="word--description">             <p class="word--description">v. kulluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1747, 'fracaso', '0', 'fracaso',
        '<div class="word--description">             <p class="word--description">acción fallida, s. kulluy. fracción, en matematicas, s. paki. fraccionar, v. ikina, pakina. fractura, s. paki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1748, 'fracturar', '0', 'fracturar',
        '<div class="word--description">             <p class="word--description">v. pakina. fragante, adj. mishki. fragil, adj. kapya. fregar, v. kakuna, kitina. frejol, s. purutu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1749, 'frente', '0', 'frente',
        '<div class="word--description">             <p class="word--description">parte del cuerpo, s. tirku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1750, 'frío', '0', 'frío',
        '<div class="word--description">             <p class="word--description">s. chiri; expresión de frío: achachay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1751, 'friolento', '0', 'friolento',
        '<div class="word--description">             <p class="word--description">adj. chirisiki. frotar, v. kakuna, kitina. fruncir, v. sipuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1752, 'fruta (variedades)', '0', 'fruta (variedades)',
        '<div class="word--description">             <p class="word--description">s. wayuri: chikaksu, pi-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1753, 'tajaya', '0', 'tajaya',
        '<div class="word--description">             <p class="word--description">punkara, tikasu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1754, 'fruto', '0', 'fruto',
        '<div class="word--description">             <p class="word--description">s. muru; caído antes de madurarse: pilis; desagradable: muyan muyan; pequenio: chusu; fruto verde: llullu; dos pegados: chapa, misha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1755, 'fucsia', '0', 'fucsia',
        '<div class="word--description">             <p class="word--description">adj. wamintsi, chiyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1756, 'fuego', '0', 'fuego',
        '<div class="word--description">             <p class="word--description">s. nina; para llevar: iska. fuente de agua, s. pukyu; pakcha. fuera, adv. kancha, hawa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1757, 'fuerte', '0', 'fuerte',
        '<div class="word--description">             <p class="word--description">adj. sinchi. fugarse, v. mitikuna. fumar, v. sayrina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1758, 'fundamento', '0', 'fundamento',
        '<div class="word--description">             <p class="word--description">s. (<*tiqsi), sapi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1759, 'futuro', '0', 'futuro',
        '<div class="word--description">             <p class="word--description">adv. kipa, shamuk; tiempo futuro: kipa pacha; pasado maniana: mincha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1760, 'galaxia', '0', 'galaxia',
        '<div class="word--description">             <p class="word--description">s. <**muyukchuru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1761, 'gallardo', '0', 'gallardo',
        '<div class="word--description">             <p class="word--description">adj. taslla</p>          </div>',
        'ACTIVE', 2, '-'),
       (1762, 'grada', '0', 'grada',
        '<div class="word--description">             <p class="word--description">s. pata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1763, 'graderío', '0', 'graderío',
        '<div class="word--description">             <p class="word--description">s. pata pata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1764, 'gallina', '0', 'gallina',
        '<div class="word--description">             <p class="word--description">s. atallpa, wallpa; que empolla: tuk- tuma; tuktu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1765, 'gallinazo', '0', 'gallinazo',
        '<div class="word--description">             <p class="word--description">s. ullawanka, ushku. ganado vacuno, s. wakra. ganar, v. mishana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1766, 'ganglios', '0', 'ganglios',
        '<div class="word--description">             <p class="word--description">inflamación de, s. amakulu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1767, 'garganta', '0', 'garganta',
        '<div class="word--description">             <p class="word--description">s. tunkuri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1768, 'gargarizar', '0', 'gargarizar',
        '<div class="word--description">             <p class="word--description">hacer gargaras, v. muklupuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1769, 'garrapata', '0', 'garrapata',
        '<div class="word--description">             <p class="word--description">v. tillimanku, waku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1770, 'garza', '0', 'garza',
        '<div class="word--description">             <p class="word--description">s. wakar, mashalli. gas, s. yanta, samay-yanta. gatear, v. llukana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1771, 'gato', '0', 'gato',
        '<div class="word--description">             <p class="word--description">-a, s. misi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1772, 'gavilan', '0', 'gavilan',
        '<div class="word--description">             <p class="word--description">s. waman, mikmichu, usturiw, chu- walli, waktaway.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1773, 'gaviota', '0', 'gaviota',
        '<div class="word--description">             <p class="word--description">s. lluya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1774, 'gemido', '0', 'gemido',
        '<div class="word--description">             <p class="word--description">onomatopeya: shinshin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1775, 'genealogía', '0', 'genealogía',
        '<div class="word--description">             <p class="word--description">s. ayllu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1776, 'geografía', '0', 'geografía',
        '<div class="word--description">             <p class="word--description">s. <*tiksimuyuyachay. Ver tierra, planeta</p>          </div>',
        'ACTIVE', 2, '-'),
       (1777, 'geógrafo', '0', 'geógrafo',
        '<div class="word--description">             <p class="word--description">s. <*tiksimuyuyachak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1778, 'girar', '0', 'girar',
        '<div class="word--description">             <p class="word--description">v. muyuna; kuyuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1779, 'glandula biliar', '0', 'glandula biliar',
        '<div class="word--description">             <p class="word--description">s. (<*hayaqin), hayakin, chinkillis.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1780, 'gluteos', '0', 'gluteos',
        '<div class="word--description">             <p class="word--description">s. siki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1781, 'gobernación', '0', 'gobernación',
        '<div class="word--description">             <p class="word--description">acto de gobernar: v. pusha- kuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1782, 'gobernante', '0', 'gobernante',
        '<div class="word--description">             <p class="word--description">s. pushak, kamak. gobernar, v. kamana, pushana. golondrina, variedad de, s. suyu, shillishi- lli, wayanay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1783, 'goloso', '0', 'goloso',
        '<div class="word--description">             <p class="word--description">hillu.</p>          </div>', 'ACTIVE',
        2, '-'),
       (1784, 'golpear', '0', 'golpear',
        '<div class="word--description">             <p class="word--description">v. makana, waktana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1785, 'golpearse', '0', 'golpearse',
        '<div class="word--description">             <p class="word--description">v. takarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1786, 'goma para pegar: s. (<*tuquru)', '0', 'goma para pegar: s. (<*tuquru)',
        '<div class="word--description">             <p class="word--description">tukuru; lluta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1787, 'gordo', '0', 'gordo',
        '<div class="word--description">             <p class="word--description">-a, adj. wira. gota, s. shutu, wiki. gotear, v. shutuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1788, 'grado escolar', '0', 'grado escolar',
        '<div class="word--description">             <p class="word--description">s. pata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1789, 'granadilla', '0', 'granadilla',
        '<div class="word--description">             <p class="word--description">s. <*tintin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1790, 'grande', '0', 'grande',
        '<div class="word--description">             <p class="word--description">adj. hatun, kapak, mama, yaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1791, 'grandeza', '0', 'grandeza',
        '<div class="word--description">             <p class="word--description">adj. kapak. granillo, s. sharu, zharu. granizar, v. runtuna. granizo, s. runtu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1792, 'grano', '0', 'grano',
        '<div class="word--description">             <p class="word--description">s. muru; granos tostados y cocina-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1793, 'dos', '0', 'dos',
        '<div class="word--description">             <p class="word--description">s. taznu, kallpu. grasa, s. wira. grasoso, adj. wirasapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1794, 'gratuitamente', '0', 'gratuitamente',
        '<div class="word--description">             <p class="word--description">adv. yanka, yankamanta,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1795, 'grieta', '0', 'grieta',
        '<div class="word--description">             <p class="word--description">s. chikta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1796, 'grillo', '0', 'grillo',
        '<div class="word--description">             <p class="word--description">s. chipu, chullu, hiki. gris, color, adj. puzu, uchpa. gritar, v. kaparina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1797, 'grito', '0', 'grito',
        '<div class="word--description">             <p class="word--description">s. kapariy; ininteligible: wirakwirak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1798, 'grueso', '0', 'grueso',
        '<div class="word--description">             <p class="word--description">adj. raku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1799, 'gruta', '0', 'gruta',
        '<div class="word--description">             <p class="word--description">s. machay, matsi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1800, 'guaba', '0', 'guaba',
        '<div class="word--description">             <p class="word--description">s. pakay, kachik, ilta, llutipa. guacamayo, s. wakamayu. guanta, s. lumucha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1801, 'guardar', '0', 'guardar',
        '<div class="word--description">             <p class="word--description">v. wakaychina, allichina; en el</p>          </div>',
        'ACTIVE', 2, '-'),
       (1802, 'guardería', '0', 'guardería',
        '<div class="word--description">             <p class="word--description">s. wawawasi. guatusa,s. punchana, siku. guerra, s. awka, awkanakuy. guerrero, s. awka, awkak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1803, 'guía', '0', 'guía',
        '<div class="word--description">             <p class="word--description">s. persona: pushak; de una planta o</p>          </div>',
        'ACTIVE', 2, '-'),
       (1804, 'del bejuco: anku. guiar', '0', 'del bejuco: anku. guiar',
        '<div class="word--description">             <p class="word--description">v. pushana. guineo, s. palanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1805, 'guiniar el ojo', '0', 'guiniar el ojo',
        '<div class="word--description">             <p class="word--description">v. sipuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1806, 'guión', '0', 'guión',
        '<div class="word--description">             <p class="word--description">s. (<*sillkuska), aspi. gusano, s. kuru, kuzu, latsik, tuku. guzhan, s. kullan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1807, 'haba', '0', 'haba',
        '<div class="word--description">             <p class="word--description">variedad de, s. nuya. haber, v. tiyana. habitación, s. pitita, killi. habitar, v. kawsana, tiyana. habitat, s. pachamama. habito, s. yachariy. habituado, adj. yacharishka. habituarse, v. yacharina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1808, 'habla', '0', 'habla',
        '<div class="word--description">             <p class="word--description">acto del habla, s. rimay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1809, 'hablante', '0', 'hablante',
        '<div class="word--description">             <p class="word--description">s. rimak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1810, 'hender', '0', 'hender',
        '<div class="word--description">             <p class="word--description">v. chiktana, shallina. hendido, adj. chiktashka, waka. herida, s. chukri; adj. chukrishka. herirse, v. chukrina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1811, 'hermana de hermana', '0', 'hermana de hermana',
        '<div class="word--description">             <p class="word--description">s. niania; hermana</p>          </div>',
        'ACTIVE', 2, '-'),
       (1812, 'de hermano', '0', 'de hermano',
        '<div class="word--description">             <p class="word--description">s. pani.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1813, 'hermano de hermano', '0', 'hermano de hermano',
        '<div class="word--description">             <p class="word--description">s. wawki; her- mano de hermana, s. turi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1814, 'hermoso', '0', 'hermoso',
        '<div class="word--description">             <p class="word--description">-a, adj. kuyaylla, sumak; expre- sión para describir lo hermoso: ananay, mu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1815, 'hablar', '0', 'hablar',
        '<div class="word--description">             <p class="word--description">v. rimana; demasiado: atina; sin</p>          </div>',
        'ACTIVE', 2, '-'),
       (1816, 'sentido: musparina', '0', 'sentido: musparina',
        '<div class="word--description">             <p class="word--description">tapyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1817, 'hace mucho tiempo', '0', 'hace mucho tiempo',
        '<div class="word--description">             <p class="word--description">adv. unay, niawpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1818, 'hace poco', '0', 'hace poco',
        '<div class="word--description">             <p class="word--description">adv. niakalla, kunanlla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1819, 'hace tiempo', '0', 'hace tiempo',
        '<div class="word--description">             <p class="word--description">adv. sarun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1820, 'hace un momento', '0', 'hace un momento',
        '<div class="word--description">             <p class="word--description">adv. kunanlla. hacer, v. rurana; siguiendo un modelo: shi- nana; algo a escondidas: chakchuna; hoyos para sembrar platano, maíz, frejol: tulana; el amor: upina, yukuna, yumana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1821, 'hacerse (transformarse)', '0', 'hacerse (transformarse)',
        '<div class="word--description">             <p class="word--description">v. tukuna; hacerse o malograrse los  alimentos: hawriyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1822, 'hacha', '0', 'hacha',
        '<div class="word--description">             <p class="word--description">s. (<*ayri).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1823, 'halar', '0', 'halar',
        '<div class="word--description">             <p class="word--description">v. aysana, chutana. halcón, s. waman. hallar, v. tarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1824, 'hambre', '0', 'hambre',
        '<div class="word--description">             <p class="word--description">s. yarkay; tener hambre, tener:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1825, 'harina', '0', 'harina',
        '<div class="word--description">             <p class="word--description">s. <*aku; kuta, kutashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1826, 'hartar', '0', 'hartar',
        '<div class="word--description">             <p class="word--description">v. amina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1827, 'hartarse', '0', 'hartarse',
        '<div class="word--description">             <p class="word--description">v. saksana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1828, 'harto', '0', 'harto',
        '<div class="word--description">             <p class="word--description">det. achka, llashak, pachan. hasta dónde?, preg. ¿maykama?. hastiar, v. amina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1829, 'he aquí', '0', 'he aquí',
        '<div class="word--description">             <p class="word--description">toma, exp. kayka. hebra, s. puchka, kaytu. heces, s. isma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1830, 'helada (fenómeno atmosferico)', '0', 'helada (fenómeno atmosferico)',
        '<div class="word--description">             <p class="word--description">s. kasa. helar, caer la helada, v. kasana. helecho, s. llashipa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1831, 'helicóptero', '0', 'helicóptero',
        '<div class="word--description">             <p class="word--description">s. antachikaru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1832, 'hembra', '0', 'hembra',
        '<div class="word--description">             <p class="word--description">adj. china; warmi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1833, 'hernia', '0', 'hernia',
        '<div class="word--description">             <p class="word--description">s. pawacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1834, 'hervir', '0', 'hervir',
        '<div class="word--description">             <p class="word--description">v. timpuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1835, 'hervívoro', '0', 'hervívoro',
        '<div class="word--description">             <p class="word--description">s. kiwamikuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1836, 'hielo', '0', 'hielo',
        '<div class="word--description">             <p class="word--description">s. rasu; hacerse hielo, v. rasuna. hierba, en general, s. kiwa; morada: sanii; espinosa: putsu; aromatica del paramo: sumpu; un tipo de hierba: mallik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1837, 'hierro', '0', 'hierro',
        '<div class="word--description">             <p class="word--description">s. killay, hillay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1838, 'hígado', '0', 'hígado',
        '<div class="word--description">             <p class="word--description">s. kipchan, yana shunku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1839, 'higuerón', '0', 'higuerón',
        '<div class="word--description">             <p class="word--description">s. ila.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1840, 'hija', '0', 'hija',
        '<div class="word--description">             <p class="word--description">s. ushushi; hija unica; murushka us- hushi; expresión que indica hijita apreciada: payaku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1841, 'hijo', '0', 'hijo',
        '<div class="word--description">             <p class="word--description">s. churi; hijo unico, murushka churi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1842, 'hilado', '0', 'hilado',
        '<div class="word--description">             <p class="word--description">adj. puchkashka. hilar, v. puchkana. hilera, s. wachu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1843, 'hilo', '0', 'hilo',
        '<div class="word--description">             <p class="word--description">s. puchka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1844, 'hincharse', '0', 'hincharse',
        '<div class="word--description">             <p class="word--description">v. punkirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1845, 'hoja que cubre al choclo', '0', 'hoja que cubre al choclo',
        '<div class="word--description">             <p class="word--description">s. kutul, panka; hoja de la cania del maíz: sarapanka; hoja delgada de cabuya seca: anku; hoja y yerba</p>          </div>',
        'ACTIVE', 2, '-'),
       (1846, 'reseca convertible en polvo: was; hoja de papel: (<*patma)', '0',
        'reseca convertible en polvo: was; hoja de papel: (<*patma)',
        '<div class="word--description">             <p class="word--description">panka.</p>          </div>', 'ACTIVE',
        2, '-'),
       (1847, 'holgazanear', '0', 'holgazanear',
        '<div class="word--description">             <p class="word--description">v. killakuna, kaynana. hombre, adj. kari; hombre comun: <*hatun- runa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1848, 'hombro', '0', 'hombro',
        '<div class="word--description">             <p class="word--description">s. wamani, waman rikra.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1849, 'honda', '0', 'honda',
        '<div class="word--description">             <p class="word--description">objeto, s. waraka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1850, 'hondonada', '0', 'hondonada',
        '<div class="word--description">             <p class="word--description">adj. pukru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1851, 'hongo', '0', 'hongo',
        '<div class="word--description">             <p class="word--description">s. kallampa, ala; de la piel: sisu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1852, 'honrar', '0', 'honrar',
        '<div class="word--description">             <p class="word--description">v. yupaychana. hora, s. <**muray. horcón, s. mantakakiru. horizontal, adv. sirik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1853, 'hormiga', '0', 'hormiga',
        '<div class="word--description">             <p class="word--description">s. anianku; comestible:    ukuy;</p>          </div>',
        'ACTIVE', 2, '-'),
       (1854, 'conga: pushinshi', '0', 'conga: pushinshi',
        '<div class="word--description">             <p class="word--description">yuturi. horqueta, s. mantakakiru, pallka. hortalizas, s. yuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1855, 'hospedar', '0', 'hospedar',
        '<div class="word--description">             <p class="word--description">v. minkachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1856, 'hospedarse', '0', 'hospedarse',
        '<div class="word--description">             <p class="word--description">v. minkarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1857, 'hospital', '0', 'hospital',
        '<div class="word--description">             <p class="word--description">s. hampiwasi, hampina wasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1858, 'hotel', '0', 'hotel',
        '<div class="word--description">             <p class="word--description">s. tampu. hoy, adv. kunan. hoya, adj. pukru. hoyo, s. hutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1859, 'hoz', '0', 'hoz',
        '<div class="word--description">             <p class="word--description">s. <*kuchuna, ichuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1860, 'huaino', '0', 'huaino',
        '<div class="word--description">             <p class="word--description">s. wayniu, waynu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1861, 'huanaco', '0', 'huanaco',
        '<div class="word--description">             <p class="word--description">camelido andino, s. wanaku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1862, 'hueco', '0', 'hueco',
        '<div class="word--description">             <p class="word--description">s. hutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1863, 'huella', '0', 'huella',
        '<div class="word--description">             <p class="word--description">s. (<*yupi); chaki kati.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1864, 'huerfano (animal o persona)', '0', 'huerfano (animal o persona)',
        '<div class="word--description">             <p class="word--description">adj. mana mamayuk, mana yayayuk; wakcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1865, 'huero', '0', 'huero',
        '<div class="word--description">             <p class="word--description">huevo, adj. huka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1866, 'huerta', '0', 'huerta',
        '<div class="word--description">             <p class="word--description">-o, s. muya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1867, 'hueso', '0', 'hueso',
        '<div class="word--description">             <p class="word--description">s. tullu; de jugar en los velorios: wayru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1868, 'huevo', '0', 'huevo',
        '<div class="word--description">             <p class="word--description">s. lulun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1869, 'huir', '0', 'huir',
        '<div class="word--description">             <p class="word--description">v. mitikuna. humanidad, s. runakay. humareda, s. kushni. humear, v. kushnichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1870, 'humedecerse', '0', 'humedecerse',
        '<div class="word--description">             <p class="word--description">v. hukuna, sutukyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1871, 'humedo', '0', 'humedo',
        '<div class="word--description">             <p class="word--description">adj. huku. humita, s. (<*huminta). humo, s. kushni. humear, v. kushnichina. hundirse, v. washaykuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1872, 'idea', '0', 'idea',
        '<div class="word--description">             <p class="word--description">s. yuyay. identico, adj. rikchak. idioma, s. shimi. idiota, adj. muspa, upa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1873, 'iglesia', '0', 'iglesia',
        '<div class="word--description">             <p class="word--description">s. wakawasi, apunchikwasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1874, 'inicio', '0', 'inicio',
        '<div class="word--description">             <p class="word--description">adv. kallari. inmediamente, adv. niapash. inmenso, adj. hatun, mayma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1875, 'inquieto', '0', 'inquieto',
        '<div class="word--description">             <p class="word--description">adj. kushpachik, shillinakuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1876, 'insecto', '0', 'insecto',
        '<div class="word--description">             <p class="word--description">s. apu, manchu, palamaku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1877, 'igual o parejo', '0', 'igual o parejo',
        '<div class="word--description">             <p class="word--description">adv. <* kuska; rikchak; que otra cosa: shina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1878, 'igualar', '0', 'igualar',
        '<div class="word--description">             <p class="word--description">v. allana, paktachina. igualmente, conj. shinallatak. iguana, s. hayampi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1879, 'imagen', '0', 'imagen',
        '<div class="word--description">             <p class="word--description">s. rikchak. imbecil, adj. muspa. imitar, v. katina, rikchana. impar, det. chullanik, chulla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1880, 'impermeabilizar (objetos de barro)', '0', 'impermeabilizar (objetos de barro)',
        '<div class="word--description">             <p class="word--description">v. wi-</p>          </div>', 'ACTIVE',
        2, '-'),
       (1881, 'importante', '0', 'importante',
        '<div class="word--description">             <p class="word--description">adj. hatun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1882, 'inadaptable (a las costumbres de un pue- blo)', '0', 'inadaptable (a las costumbres de un pue- blo)',
        '<div class="word--description">             <p class="word--description">adj. awka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1883, 'inca', '0', 'inca',
        '<div class="word--description">             <p class="word--description">suprema autoridad en el Tawantin suyu, s. inka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1884, 'incendiar', '0', 'incendiar',
        '<div class="word--description">             <p class="word--description">v. rupachina. inclinado, adj. kinray, tsan. inclinar, v. kumuna. indicación, s. rikuchiy. indicar, v. rikuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1885, 'índice', '0', 'índice',
        '<div class="word--description">             <p class="word--description">dedo, s. tuksina ruka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1886, 'indómito', '0', 'indómito',
        '<div class="word--description">             <p class="word--description">adj. kita.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1887, 'inepto (para la cacería o la pesca)', '0', 'inepto (para la cacería o la pesca)',
        '<div class="word--description">             <p class="word--description">adj. awasi, chiki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1888, 'infectarse (las heridas)', '0', 'infectarse (las heridas)',
        '<div class="word--description">             <p class="word--description">v. kiyayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1889, 'inferior', '0', 'inferior',
        '<div class="word--description">             <p class="word--description">adj. sullka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1890, 'inflamación (por heridas', '0', 'inflamación (por heridas',
        '<div class="word--description">             <p class="word--description">golpes, picadu- ras), s. inta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1891, 'inflamarse', '0', 'inflamarse',
        '<div class="word--description">             <p class="word--description">v. ruparina. inflarse, v. punkina. informar, v. willana. infortunio, adj. chiki. ingenuo, adj. muspa. inhumar, v. pampana. iniciar, v. kallarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1892, 'inseminar', '0', 'inseminar',
        '<div class="word--description">             <p class="word--description">v. yayuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1893, 'inservible', '0', 'inservible',
        '<div class="word--description">             <p class="word--description">adv. mana-alli, yanka. insípido, adj. aminta, chamcha, chamuk, hamlla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1894, 'insistir', '0', 'insistir',
        '<div class="word--description">             <p class="word--description">v. atina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1895, 'instantanemente', '0', 'instantanemente',
        '<div class="word--description">             <p class="word--description">adv. nia, nialla. instrumento, s. hillay; para pedacear la cabuya: wazik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1896, 'insultar', '0', 'insultar',
        '<div class="word--description">             <p class="word--description">v. kamina, takurina, tushuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1897, 'inteligencia', '0', 'inteligencia',
        '<div class="word--description">             <p class="word--description">s. yuyay. inteligente, adj. yuyaysapa. inter, mon. –naku-. interacción, s. ruranakuy. intercambiar, v. rantinakuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1898, 'intercomunicación', '0', 'intercomunicación',
        '<div class="word--description">             <p class="word--description">s. rimanakuy, willa-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1899, 'interior', '0', 'interior',
        '<div class="word--description">             <p class="word--description">adv. uku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1900, 'interrogativo', '0', 'interrogativo',
        '<div class="word--description">             <p class="word--description">el que interroga, v. tapuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1901, 'interrogar', '0', 'interrogar',
        '<div class="word--description">             <p class="word--description">v. tapuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1902, 'intestinos', '0', 'intestinos',
        '<div class="word--description">             <p class="word--description">s. chunchulli; grueso: raku chunchulli; delgado: nianiu chunchulli. introducir, v. satina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1903, 'inundarse', '0', 'inundarse',
        '<div class="word--description">             <p class="word--description">v. huntana, kuchayana, nu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1904, 'inutil', '0', 'inutil',
        '<div class="word--description">             <p class="word--description">adj. hupi, mana-alli, yanka. investigar, v. <*kuskikuy; mashkana, tari- pana, lukllikirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1905, 'invierno', '0', 'invierno',
        '<div class="word--description">             <p class="word--description">s. tamya pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1906, 'invisible', '0', 'invisible',
        '<div class="word--description">             <p class="word--description">cosa, s. mana rikuypak, iniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1907, 'invitar', '0', 'invitar',
        '<div class="word--description">             <p class="word--description">v. kayana. invocar, v. maniana. inyectar, v. tuksina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1908, 'ir', '0', 'ir',
        '<div class="word--description">             <p class="word--description">v. rina; en aglomeración: tallirina, wanku-</p>          </div>',
        'ACTIVE', 2, '-'),
       (1909, 'rina; de cacería y pezca: mitayuna', '0', 'rina; de cacería y pezca: mitayuna',
        '<div class="word--description">             <p class="word--description">purina; a buscar lenia: yantana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1910, 'izquierdo', '0', 'izquierdo',
        '<div class="word--description">             <p class="word--description">-a, adj. ichuk, lluki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1911, 'jabalí', '0', 'jabalí',
        '<div class="word--description">             <p class="word--description">s. wankana. jardín, s. sisa pampa. jarra, s. shila. jaspeado, adj. puzu. jefe, s. apu, kuraka. jengibre, s. akirinri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1912, 'jesus', '0', 'jesus',
        '<div class="word--description">             <p class="word--description">jesucristo, s. apunchik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1913, 'jicama', '0', 'jicama',
        '<div class="word--description">             <p class="word--description">tipo de tuberculo, s. hikama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1914, 'juez', '0', 'juez',
        '<div class="word--description">             <p class="word--description">s. (<*kuskachaq), kuskachak, kama- chik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1915, 'jugar (juegos de movimientos físicos y de competencias)', '0',
        'jugar (juegos de movimientos físicos y de competencias)',
        '<div class="word--description">             <p class="word--description">v. pukllana; juegos de azar o de fortuna: chunkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1916, 'jugo', '0', 'jugo',
        '<div class="word--description">             <p class="word--description">s. hilli; del penco: chawar mishki; fer- mentado de cania de azucar: warapu. juicio (inteligencia), s. yuyay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1917, 'jora', '0', 'jora',
        '<div class="word--description">             <p class="word--description">maíz germinado utilizado en la prepa- ración de la chicha, s. hura.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1918, 'jorobado', '0', 'jorobado',
        '<div class="word--description">             <p class="word--description">adj. kumu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1919, 'joven', '0', 'joven',
        '<div class="word--description">             <p class="word--description">adj. ambos: mallta; varón: wayna; mujer: pasnia, kuytsa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1920, 'juego', '0', 'juego',
        '<div class="word--description">             <p class="word--description">s. pukllay, chunkay; juego y tablero, similar al ajedrez: <*tapta, taptana; otros: wayru, pichka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1921, 'jueves', '0', 'jueves',
        '<div class="word--description">             <p class="word--description">s. <**patma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1922, 'juicioso', '0', 'juicioso',
        '<div class="word--description">             <p class="word--description">adj. yuyaysapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1923, 'julio', '0', 'julio',
        '<div class="word--description">             <p class="word--description">s. <**purun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1924, 'junio', '0', 'junio',
        '<div class="word--description">             <p class="word--description">s. <*inti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1925, 'juntar', '0', 'juntar',
        '<div class="word--description">             <p class="word--description">v. tantachina, llutana, tinkina; hierba: kiwana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1926, 'junto', '0', 'junto',
        '<div class="word--description">             <p class="word--description">al lado, adv. kuchu, kuchulla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1927, 'jupiter', '0', 'jupiter',
        '<div class="word--description">             <p class="word--description">s. <**akapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1928, 'justicia', '0', 'justicia',
        '<div class="word--description">             <p class="word--description">s. <*kuskachaq, kuskachak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1929, 'juzgar', '0', 'juzgar',
        '<div class="word--description">             <p class="word--description">v. taripana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1930, 'laberinto', '0', 'laberinto',
        '<div class="word--description">             <p class="word--description">s. chinkana.	kastilla shimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1931, 'labio', '0', 'labio',
        '<div class="word--description">             <p class="word--description">s. inferior: sipri; superior: wirpa; lepo- rino: waka, wantukshimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1932, 'laborioso', '0', 'laborioso',
        '<div class="word--description">             <p class="word--description">-a, adj. llamkak, kutsi. labrar madera, v. llakllana. lactar, v. chuchuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1933, 'ladrar', '0', 'ladrar',
        '<div class="word--description">             <p class="word--description">v. awniina, kaparina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1934, 'ladrón', '0', 'ladrón',
        '<div class="word--description">             <p class="word--description">s. shuwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1935, 'lagania', '0', 'lagania',
        '<div class="word--description">             <p class="word--description">chukni.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1936, 'lagartija', '0', 'lagartija',
        '<div class="word--description">             <p class="word--description">s. palu, sacharuna, tsalakulun, tsilinkitsi, tulipa, waksa, yaku palu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1937, 'lago', '0', 'lago',
        '<div class="word--description">             <p class="word--description">s. kucha, hita, mamakucha, hatun kucha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1938, 'lagrima', '0', 'lagrima',
        '<div class="word--description">             <p class="word--description">s. wiki. lagrimear, v. wikiyana. laguna, s. kucha, hita. lamentar, v. llakina. lamentarse, v. niakarina. lamer, v. llawana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1939, 'lana', '0', 'lana',
        '<div class="word--description">             <p class="word--description">s. millma. langosta, s. chillik. lanza, s. wachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1940, 'lanzar', '0', 'lanzar',
        '<div class="word--description">             <p class="word--description">v. shitana, chutana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1941, 'lapiz', '0', 'lapiz',
        '<div class="word--description">             <p class="word--description">s. killkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1942, 'largo', '0', 'largo',
        '<div class="word--description">             <p class="word--description">adj. suni.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1943, 'lastima', '0', 'lastima',
        '<div class="word--description">             <p class="word--description">s. llaki; expresión de lastima: ala- lay, llakinayakta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1944, 'lastimarse', '0', 'lastimarse',
        '<div class="word--description">             <p class="word--description">v. chukrina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1945, 'lavar', '0', 'lavar',
        '<div class="word--description">             <p class="word--description">v. el cuerpo o la cabeza: armana; par- tes del cuerpo u objetos:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1946, 'lazo', '0', 'lazo',
        '<div class="word--description">             <p class="word--description">agujero de una cuerda, s. tuklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1947, 'leche', '0', 'leche',
        '<div class="word--description">             <p class="word--description">s. niuniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1948, 'lechero', '0', 'lechero',
        '<div class="word--description">             <p class="word--description">tipo de arbol, s. pinllu. lechuza, s. chushik, pullukuku. leer, v. (<*qillqaktarikuy), killkakatina. legislador, s. kamachik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1949, 'legislar', '0', 'legislar',
        '<div class="word--description">             <p class="word--description">v. kamachina. lejano, adv. karu. lejos, adv. karu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1950, 'lengua', '0', 'lengua',
        '<div class="word--description">             <p class="word--description">órgano articulatorio, s. kallu. lengua(je) articulado, s. shimi; lengua quichua: kichwa shimi; lengua castellana;</p>          </div>',
        'ACTIVE', 2, '-'),
       (1951, 'lengüeta', '0', 'lengüeta',
        '<div class="word--description">             <p class="word--description">s. kallwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1952, 'lenia', '0', 'lenia',
        '<div class="word--description">             <p class="word--description">s. yanta; verde: chawa; con fuego: inta; hacer leniar: yantay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1953, 'lerdo', '0', 'lerdo',
        '<div class="word--description">             <p class="word--description">-da, adj. sampa; lerda, mujer: zanzan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1954, 'letra', '0', 'letra',
        '<div class="word--description">             <p class="word--description">s. killka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1955, 'levantamiento', '0', 'levantamiento',
        '<div class="word--description">             <p class="word--description">s. hatariy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1956, 'levantar', '0', 'levantar',
        '<div class="word--description">             <p class="word--description">v. hawayachina; con palanca: wankana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1957, 'levantarse', '0', 'levantarse',
        '<div class="word--description">             <p class="word--description">v. hatarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1958, 'ley(es)', '0', 'ley(es)',
        '<div class="word--description">             <p class="word--description">s. (<*kamachikuska), kamachiy; hacer leyes: kamachiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1959, 'leyenda', '0', 'leyenda',
        '<div class="word--description">             <p class="word--description">s. niawparimay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1960, 'liar', '0', 'liar',
        '<div class="word--description">             <p class="word--description">v. wankuna, alapana; pies o manos: chaknana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1961, 'libelula', '0', 'libelula',
        '<div class="word--description">             <p class="word--description">s. chikaru, tsikaru, akcha shuwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1962, 'liberar', '0', 'liberar',
        '<div class="word--description">             <p class="word--description">v. kishpichina. liberarse, v. kishpirina, kishpina. librar, v. kishpichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1963, 'libro', '0', 'libro',
        '<div class="word--description">             <p class="word--description">s. (<*qillqa, qillqa kipu, qillqaykusqa),</p>          </div>',
        'ACTIVE', 2, '-'),
       (1964, 'killka', '0', 'killka',
        '<div class="word--description">             <p class="word--description">killka kipu, killkaykushka; kamu (¿?).</p>          </div>',
        'ACTIVE', 2, '-'),
       (1965, 'líder', '0', 'líder',
        '<div class="word--description">             <p class="word--description">s. apu, pushak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1966, 'liendre', '0', 'liendre',
        '<div class="word--description">             <p class="word--description">s. chiya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1967, 'ligero', '0', 'ligero',
        '<div class="word--description">             <p class="word--description">adj. ichu, kutsi; adv.: utkay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1968, 'lila', '0', 'lila',
        '<div class="word--description">             <p class="word--description">adj. maywa. limar, v. llampuna. límitar, v. saywana. limón, s. ishnul. límite, s. saywa. limpiar, v. pichana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1969, 'limpio', '0', 'limpio',
        '<div class="word--description">             <p class="word--description">adj. chuya, chuyaklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1970, 'linaje', '0', 'linaje',
        '<div class="word--description">             <p class="word--description">s. ayllu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1971, 'linderar', '0', 'linderar',
        '<div class="word--description">             <p class="word--description">v. saywana, kimina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1972, 'lindero', '0', 'lindero',
        '<div class="word--description">             <p class="word--description">s. saywa</p>          </div>',
        'ACTIVE', 2, '-'),
       (1973, 'lindo', '0', 'lindo',
        '<div class="word--description">             <p class="word--description">adj. kuyaylla, sumak</p>          </div>',
        'ACTIVE', 2, '-'),
       (1974, 'línea', '0', 'línea',
        '<div class="word--description">             <p class="word--description">s. (<*siqi); aspi, wachu; horizontal: sirik aspi; vertical, s. shayak aspi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1975, 'líquido', '0', 'líquido',
        '<div class="word--description">             <p class="word--description">s. yaku. lirio, s. amankay. lisiar, v. kiwina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1976, 'liso', '0', 'liso',
        '<div class="word--description">             <p class="word--description">adj. llampu, lluchka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1977, 'lisonjero', '0', 'lisonjero',
        '<div class="word--description">             <p class="word--description">adj. mishkishimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1978, 'liviano', '0', 'liviano',
        '<div class="word--description">             <p class="word--description">adj. pankalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1979, 'lucma', '0', 'lucma',
        '<div class="word--description">             <p class="word--description">tipo de fruta, s. lukma, rukma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1980, 'lobanillo', '0', 'lobanillo',
        '<div class="word--description">             <p class="word--description">s. pukla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1981, 'lobo', '0', 'lobo',
        '<div class="word--description">             <p class="word--description">s. atuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1982, 'lóbulo', '0', 'lóbulo',
        '<div class="word--description">             <p class="word--description">parte inferior carnosa de la oreja: s. llutu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1983, 'lodo', '0', 'lodo',
        '<div class="word--description">             <p class="word--description">s. turu; hacerse lodo, v.: turuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1984, 'loma', '0', 'loma',
        '<div class="word--description">             <p class="word--description">s. urku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1985, 'lomo', '0', 'lomo',
        '<div class="word--description">             <p class="word--description">s. washa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1986, 'lora', '0', 'lora',
        '<div class="word--description">             <p class="word--description">-o, s. uritu, kayas, araw, tinkula, llikuy, kalli kalli, shakalli, shakan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1987, 'lucero', '0', 'lucero',
        '<div class="word--description">             <p class="word--description">s. kuyllur.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1988, 'luciernaga', '0', 'luciernaga',
        '<div class="word--description">             <p class="word--description">s. ninakuru, tillimpu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1989, 'luego', '0', 'luego',
        '<div class="word--description">             <p class="word--description">conj. chaymanta, chay kipa, kipaman. lugar, donde esta algo: <*tiyaskan; lugar, re- gión o parte: suyu; kuska; sagrado: pukara,</p>          </div>',
        'ACTIVE', 2, '-'),
       (1990, 'lumbre', '0', 'lumbre',
        '<div class="word--description">             <p class="word--description">s. nina. luminoso, adj. hakan. luna, s. killa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1991, 'lunar', '0', 'lunar',
        '<div class="word--description">             <p class="word--description">s. ana. lunes, s. <**sullka. luz, s. achik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1992, 'llama', '0', 'llama',
        '<div class="word--description">             <p class="word--description">camelido andino, s. llama¸ un tipo de llama: chantasu, llaminku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1993, 'llamar', '0', 'llamar',
        '<div class="word--description">             <p class="word--description">v. kayana; expresión para llamar al ganado: kachi kachi; llamar la atención en una conversación: hay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1994, 'llanura', '0', 'llanura',
        '<div class="word--description">             <p class="word--description">s. pampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1995, 'llegar', '0', 'llegar',
        '<div class="word--description">             <p class="word--description">v. chayamuna, paktamuna. llenar, v. huntachina, paktachina. lleno, adj. hunta, huntashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1996, 'llevar', '0', 'llevar',
        '<div class="word--description">             <p class="word--description">v. cosas: apay; llevar algo en la falda:</p>          </div>',
        'ACTIVE', 2, '-'),
       (1997, 'llorar', '0', 'llorar',
        '<div class="word--description">             <p class="word--description">v. wakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1998, 'llover', '0', 'llover',
        '<div class="word--description">             <p class="word--description">v. tamyana, paramuna; en forma me- nuda mientras hay sol: chirapana. lloviznar, v. paramuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (1999, 'lluvia', '0', 'lluvia',
        '<div class="word--description">             <p class="word--description">s. tamya; menuda con sol: chirapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2000, 'machacar', '0', 'machacar',
        '<div class="word--description">             <p class="word--description">v. kawtayana, takana.	mandar, v. kachana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2001, 'machica', '0', 'machica',
        '<div class="word--description">             <p class="word--description">harina de cebada, s. machka. macho, adj. (<*ullqu), ullku; kari. madera, s. (<*qiru) kiru; kaspi; del penco: chawar kiru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2002, 'madre', '0', 'madre',
        '<div class="word--description">             <p class="word--description">s. mama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2003, 'madrecita', '0', 'madrecita',
        '<div class="word--description">             <p class="word--description">expresión cariniosa para las mujeres adultas o jóvenes: mamaku. madrina de bautizo, s. achikmama, mar- kakmama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2004, 'madrugada', '0', 'madrugada',
        '<div class="word--description">             <p class="word--description">adv. tutamanta. madurar, v. (<*puquy), pukuna. madurarse, el choclo, v. kawllarina. maestro, -a, s. yachachik. maguey, s. chawar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2005, 'magullar', '0', 'magullar',
        '<div class="word--description">             <p class="word--description">v. llakana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2006, 'magullarse', '0', 'magullarse',
        '<div class="word--description">             <p class="word--description">v. rawmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2007, 'maíz', '0', 'maíz',
        '<div class="word--description">             <p class="word--description">s. sara; variedades: zhima, wantanku; plagado: atupa; silvestre: atuk sara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2008, 'mal', '0', 'mal',
        '<div class="word--description">             <p class="word--description">-o, -a, adj. mana-alli; mal acostum- brado: paku; mal genio: millay; mal molido: chamka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2009, 'malestar', '0', 'malestar',
        '<div class="word--description">             <p class="word--description">tener, v. champayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2010, 'maleta', '0', 'maleta',
        '<div class="word--description">             <p class="word--description">s. kipi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2011, 'maleza', '0', 'maleza',
        '<div class="word--description">             <p class="word--description">s. sacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2012, 'malhumorado', '0', 'malhumorado',
        '<div class="word--description">             <p class="word--description">de mal humor, adj. millay, warak warak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2013, 'malhumorarse', '0', 'malhumorarse',
        '<div class="word--description">             <p class="word--description">v. millayana. malograrse, no empollar los huevos, v. hukana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2014, 'mama', '0', 'mama',
        '<div class="word--description">             <p class="word--description">s. mama. mamar, v. chuchuna. mamífero, s. chuchuk. manantial, s. pukyu. mancera, s. charina. mancha, s. tiílla, mapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2015, 'manchado', '0', 'manchado',
        '<div class="word--description">             <p class="word--description">adj. tiílla, shuyushka. manchar, v. hawina, llunchina, shuyuna. mancharse, v. karkayana, mapayana, wikiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2016, 'mancha', '0', 'mancha',
        '<div class="word--description">             <p class="word--description">s. mapa, tiklla; del rostro o panio: mirka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2017, 'maní', '0', 'maní',
        '<div class="word--description">             <p class="word--description">s. inchik, wachansu. maniatar, v. watana. manillas, s. makiwatana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2018, 'mano', '0', 'mano',
        '<div class="word--description">             <p class="word--description">s. maki; dorso de la mano: maki</p>          </div>',
        'ACTIVE', 2, '-'),
       (2019, 'manosear', '0', 'manosear',
        '<div class="word--description">             <p class="word--description">v. llamkana, hawina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2020, 'manta', '0', 'manta',
        '<div class="word--description">             <p class="word--description">s. mantana; para cargar: aparina; para cosechar el maíz: halunzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2021, 'manteca', '0', 'manteca',
        '<div class="word--description">             <p class="word--description">s. wira.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2022, 'maniana', '0', 'maniana',
        '<div class="word--description">             <p class="word--description">adv. kaya; la maniana: tutamanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2023, 'maquenio', '0', 'maquenio',
        '<div class="word--description">             <p class="word--description">s. yurimawas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2024, 'mar', '0', 'mar',
        '<div class="word--description">             <p class="word--description">s. mamakucha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2025, 'marcador', '0', 'marcador',
        '<div class="word--description">             <p class="word--description">para escribir, s. killkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2026, 'marchar', '0', 'marchar',
        '<div class="word--description">             <p class="word--description">v. tatkina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2027, 'marchitarse', '0', 'marchitarse',
        '<div class="word--description">             <p class="word--description">v. ankuyana, urmarina, wa- niurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2028, 'marearse', '0', 'marearse',
        '<div class="word--description">             <p class="word--description">v. shinkana. marfil vegetal, s. yarina. marido, s. kusa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2029, 'mariposa', '0', 'mariposa',
        '<div class="word--description">             <p class="word--description">s. pillpintu, chapul.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2030, 'marrano', '0', 'marrano',
        '<div class="word--description">             <p class="word--description">s. kuchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2031, 'marte', '0', 'marte',
        '<div class="word--description">             <p class="word--description">planeta, s. <**mullu. martes, s. <**kulla. marzo, s. <*pawkar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2032, 'mas', '0', 'mas',
        '<div class="word--description">             <p class="word--description">adv. ashtawan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2033, 'masa', '0', 'masa',
        '<div class="word--description">             <p class="word--description">hacer, v. chapuna. mascar, v. kashtuna, mukuna. mashua, s. mashuwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2034, 'masticar', '0', 'masticar',
        '<div class="word--description">             <p class="word--description">v. akuna, kashtuna, mukuna;</p>          </div>',
        'ACTIVE', 2, '-'),
       (2035, 'mata', '0', 'mata',
        '<div class="word--description">             <p class="word--description">s. yura. matar, v. waniuchina. mate, s. mati, zampu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2036, 'matrimoniarse', '0', 'matrimoniarse',
        '<div class="word--description">             <p class="word--description">contraer matrimonio, v.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2037, 'matrimonio', '0', 'matrimonio',
        '<div class="word--description">             <p class="word--description">s. sawari, sawariy. matrona, s. mama; mamakuna. mayo, s. <*aymuray.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2038, 'mayor', '0', 'mayor',
        '<div class="word--description">             <p class="word--description">adj. kurak, kuraka. mazamorra, s. api. mazo, s. makana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2039, 'mazorca (de gramíneas y cereales)', '0', 'mazorca (de gramíneas y cereales)',
        '<div class="word--description">             <p class="word--description">s.</p>          </div>', 'ACTIVE', 2,
        '-'),
       (2040, 'mecer', '0', 'mecer',
        '<div class="word--description">             <p class="word--description">v. kuyuchina, kawina, kantina. mediano, -a (objetos, personas y anima- les), adj. mallta, paktalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2041, 'medicina', '0', 'medicina',
        '<div class="word--description">             <p class="word--description">s. hampi; especialidad: hampi- yachay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2042, 'medico', '0', 'medico',
        '<div class="word--description">             <p class="word--description">s. hampik; yachak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2043, 'medida', '0', 'medida',
        '<div class="word--description">             <p class="word--description">s. tupu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2044, 'medio ambiente', '0', 'medio ambiente',
        '<div class="word--description">             <p class="word--description">s. pachamama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2045, 'medio', '0', 'medio',
        '<div class="word--description">             <p class="word--description">det. chawpi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2046, 'medio', '0', 'medio',
        '<div class="word--description">             <p class="word--description">el dedo, s. chawpi ruka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2047, 'mediocre', '0', 'mediocre',
        '<div class="word--description">             <p class="word--description">adj. sacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2048, 'medir', '0', 'medir',
        '<div class="word--description">             <p class="word--description">v. tupuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2049, 'medula', '0', 'medula',
        '<div class="word--description">             <p class="word--description">s. (<*chillina), chillona; niutku; de vegetales: shunku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2050, 'mejorar', '0', 'mejorar',
        '<div class="word--description">             <p class="word--description">v. allichina, sumakyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2051, 'melga', '0', 'melga',
        '<div class="word--description">             <p class="word--description">s. milka. melloco, s. milluku. memoria, s. yuyay. mencionado, adj. nishka. mencionar, v. nina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2052, 'menear', '0', 'menear',
        '<div class="word--description">             <p class="word--description">v. kawina; hacer menear: kuyuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2053, 'menor', '0', 'menor',
        '<div class="word--description">             <p class="word--description">adj. sullka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2054, 'menos pensado', '0', 'menos pensado',
        '<div class="word--description">             <p class="word--description">adv. haykamanta, kun- kaymanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2055, 'mensaje', '0', 'mensaje',
        '<div class="word--description">             <p class="word--description">s. willay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2056, 'mensajero', '0', 'mensajero',
        '<div class="word--description">             <p class="word--description">s. chaski.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2057, 'menstración', '0', 'menstración',
        '<div class="word--description">             <p class="word--description">s. <*yawarikuy, mapakuy; yawarta rikuy, killa unkuy, mapa killa; primera menstruación: <*kikuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2058, 'menstruar', '0', 'menstruar',
        '<div class="word--description">             <p class="word--description">v. <*yawarikuy, mapakuna; killa unkuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2059, 'mentir', '0', 'mentir',
        '<div class="word--description">             <p class="word--description">v. llullana. mentira, s. llulla. mentiroso, adj. llulla. mentón, s. kakichu, sintu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2060, 'meniique', '0', 'meniique',
        '<div class="word--description">             <p class="word--description">dedo, s. sullka ruka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2061, 'mercurio', '0', 'mercurio',
        '<div class="word--description">             <p class="word--description">s. <**rimsi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2062, 'merendar', '0', 'merendar',
        '<div class="word--description">             <p class="word--description">v. (<*chishinmikuy), chishinmi- kuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2063, 'merienda', '0', 'merienda',
        '<div class="word--description">             <p class="word--description">s. (<*chishinmikuy), chishinmikuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2064, 'mermar', '0', 'mermar',
        '<div class="word--description">             <p class="word--description">v. anchuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2065, 'mes', '0', 'mes',
        '<div class="word--description">             <p class="word--description">s. killa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2066, 'mesa', '0', 'mesa',
        '<div class="word--description">             <p class="word--description">s. (<*chakiqiru); pataku, hampara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2067, 'mestizo', '0', 'mestizo',
        '<div class="word--description">             <p class="word--description">adj. laychu, mishu, tsala, wiraku- cha, misti, mishu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2068, 'metal', '0', 'metal',
        '<div class="word--description">             <p class="word--description">s. anta</p>          </div>',
        'ACTIVE', 2, '-'),
       (2069, 'meter', '0', 'meter',
        '<div class="word--description">             <p class="word--description">v. satina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2070, 'metro (medida)', '0', 'metro (medida)',
        '<div class="word--description">             <p class="word--description">s. tatki. mezclar, v. chakruna, chapuna. mezquinar, v. michana, mitsana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2071, 'mezquino', '0', 'mezquino',
        '<div class="word--description">             <p class="word--description">-a, adj. michak, mitsak. miedo, s. manchanayay; expresión de miedo: alalay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2072, 'miel de abeja', '0', 'miel de abeja',
        '<div class="word--description">             <p class="word--description">s. chullumpi. miercoles, s. <**haway. mierda, s. isma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2073, 'migaja', '0', 'migaja',
        '<div class="word--description">             <p class="word--description">s. palik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2074, 'mil', '0', 'mil',
        '<div class="word--description">             <p class="word--description">num. waranka. milenio, adv. warankawata. militar, s. awka, awkak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2075, 'millón', '0', 'millón',
        '<div class="word--description">             <p class="word--description">num. (<*hachuntinhachu, hachu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2076, 'mimar', '0', 'mimar',
        '<div class="word--description">             <p class="word--description">v. kuyana. mimbre, s. tiyamshi. mina, s. charka, kuya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2077, 'mineral', '0', 'mineral',
        '<div class="word--description">             <p class="word--description">tipo de piedra, s. ara rumi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2078, 'minuto', '0', 'minuto',
        '<div class="word--description">             <p class="word--description">s. <*hayri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2079, 'mirar', '0', 'mirar',
        '<div class="word--description">             <p class="word--description">v. chapana, kawana, rikuna. mirarnos, nos volveremos a encontrar, exp. rikunakushun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2080, 'mirlo', '0', 'mirlo',
        '<div class="word--description">             <p class="word--description">s. suksu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2081, 'miserable', '0', 'miserable',
        '<div class="word--description">             <p class="word--description">adj. michak, mitsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2082, 'mismo', '0', 'mismo',
        '<div class="word--description">             <p class="word--description">-a, adj. kikin. mitad, det. chawpi. mocho, adj. putu. moco, s. kunia, lumarisu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2083, 'mocosos', '0', 'mocosos',
        '<div class="word--description">             <p class="word--description">expresión despectiva a los</p>          </div>',
        'ACTIVE', 2, '-'),
       (2084, 'modificar', '0', 'modificar',
        '<div class="word--description">             <p class="word--description">v. allichiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2085, 'moho', '0', 'moho',
        '<div class="word--description">             <p class="word--description">s. allu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2086, 'mojado', '0', 'mojado',
        '<div class="word--description">             <p class="word--description">adj. huku; semimojado: ankulla. mojarse, v. hukuna, mutiyana, shuturina, sutukyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2087, 'moler', '0', 'moler',
        '<div class="word--description">             <p class="word--description">v. kutana; grueso: chamkana. molestar, v. kushparina, shillinkuna. molido, adj. kuta, kutashka; grueso: chamka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2088, 'molle', '0', 'molle',
        '<div class="word--description">             <p class="word--description">planta y frutos, s. mulli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2089, 'mollera', '0', 'mollera',
        '<div class="word--description">             <p class="word--description">niupu.</p>          </div>', 'ACTIVE',
        2, '-'),
       (2090, 'mono', '0', 'mono',
        '<div class="word--description">             <p class="word--description">s. chichiku, kushillu, intillama, kutu, machin, parawaku, shilltipu, sipuru, tsiyam-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2091, 'montania', '0', 'montania',
        '<div class="word--description">             <p class="word--description">s. urku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2092, 'montar', '0', 'montar',
        '<div class="word--description">             <p class="word--description">v. sikana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2093, 'monte', '0', 'monte',
        '<div class="word--description">             <p class="word--description">s. urku; monte y maleza: sacha. morada, lugar donde se vive, s. tiyana, kawsana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2094, 'morado', '0', 'morado',
        '<div class="word--description">             <p class="word--description">adj. maywa, sanii.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2095, 'morder', '0', 'morder',
        '<div class="word--description">             <p class="word--description">v. kanina; hacer morder: kanichina. morir, v. waniuna, pitirina, tukurina. morirse de iras, v. waniurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2096, 'morocho', '0', 'morocho',
        '<div class="word--description">             <p class="word--description">s. muruchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2097, 'mortecina', '0', 'mortecina',
        '<div class="word--description">             <p class="word--description">adj. ismushka, waniushka. mosca, -o, s. chuspi, hikinias; kurumama. mosquearse, v. intuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2098, 'mostrar', '0', 'mostrar',
        '<div class="word--description">             <p class="word--description">v. rikuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2099, 'mote', '0', 'mote',
        '<div class="word--description">             <p class="word--description">maíz o choclo cocido, s. muti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2100, 'moteado', '0', 'moteado',
        '<div class="word--description">             <p class="word--description">adj. luyu luyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2101, 'moverse', '0', 'moverse',
        '<div class="word--description">             <p class="word--description">v. kuyuna; en vaiven: kawirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2102, 'movilizar', '0', 'movilizar',
        '<div class="word--description">             <p class="word--description">v. kuyuchina. mozuela, adj. pasnia, kuytsa. muchacha, adj. kuytsa, pasnia. muchacho, adj. wamra.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2103, 'mucho', '0', 'mucho',
        '<div class="word--description">             <p class="word--description">det. achka, llashak, may, yapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2104, 'mudo', '0', 'mudo',
        '<div class="word--description">             <p class="word--description">adj. upa. muela, s. mamakiru. muerte, s. waniuy. muerto, adj. waniushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2105, 'mujer', '0', 'mujer',
        '<div class="word--description">             <p class="word--description">s. warmi; noble, escogida en el</p>          </div>',
        'ACTIVE', 2, '-'),
       (2106, 'tiempo del incario: palla; mujer mítica: mama awaduna', '0',
        'tiempo del incario: palla; mujer mítica: mama awaduna',
        '<div class="word--description">             <p class="word--description">chificha, mama hataba; lenta en el trabajo: zanzan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2107, 'mujercita', '0', 'mujercita',
        '<div class="word--description">             <p class="word--description">expresión cariniosa para las</p>          </div>',
        'ACTIVE', 2, '-'),
       (2108, 'muletilla en el habla', '0', 'muletilla en el habla',
        '<div class="word--description">             <p class="word--description">exp. imashnaray, imashti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2109, 'multiplicar', '0', 'multiplicar',
        '<div class="word--description">             <p class="word--description">v. mirachina. multiplicarse, v. mirana. mundo, s. pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2110, 'munieca', '0', 'munieca',
        '<div class="word--description">             <p class="word--description">-o, s. llullawawa; sayti (?). murcielago, s. mashu, chimpilaku. muro, s. pirka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2111, 'muslo', '0', 'muslo',
        '<div class="word--description">             <p class="word--description">s. raku chanka, mama chanka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2112, 'mutilar', '0', 'mutilar',
        '<div class="word--description">             <p class="word--description">v. kulluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2113, 'muy', '0', 'muy',
        '<div class="word--description">             <p class="word--description">adv. may, yapa, ancha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2114, 'nacer', '0', 'nacer',
        '<div class="word--description">             <p class="word--description">v. wacharina, pakarina.	no es cierto?, adv. ¿manachu?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2115, 'nacido', '0', 'nacido',
        '<div class="word--description">             <p class="word--description">en algun lugar, adj. wacharishka. nación, s. llakta, mamallakta. nacionalidad, s. <**suyukawsay, ayllu- suyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2116, 'nada', '0', 'nada',
        '<div class="word--description">             <p class="word--description">det. mana-ima.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2117, 'nadar', '0', 'nadar',
        '<div class="word--description">             <p class="word--description">v. waytana, wampuna. nadie, det. manapi, manapipash. nalga, s. siki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2118, 'nalgadas', '0', 'nalgadas',
        '<div class="word--description">             <p class="word--description">dar, v. kullpina. naranja, s. laranka, laranha, chilina. nariz, s. sinka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2119, 'narrador de cuentos', '0', 'narrador de cuentos',
        '<div class="word--description">             <p class="word--description">s. hawarikuk. narrar (cuentos, fabulas), v. hawarikuy. naturaleza, s. pacha, pachamama. nausear, v. <*kuynay); kuynana, millana. navegante, s. wampuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2120, 'navegar', '0', 'navegar',
        '<div class="word--description">             <p class="word--description">v. wampuna. neblina, s. puyu. necio, adj. atupa. negro, color, adj. yana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2121, 'neptuno', '0', 'neptuno',
        '<div class="word--description">             <p class="word--description">s. <**turumanya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2122, 'nevado', '0', 'nevado',
        '<div class="word--description">             <p class="word--description">el cerro, s. rasu urku; rasushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2123, 'nevar', '0', 'nevar',
        '<div class="word--description">             <p class="word--description">v. rasuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2124, 'ni dios lo quiera', '0', 'ni dios lo quiera',
        '<div class="word--description">             <p class="word--description">adv. amallatak. nido, s. kisha, kuzha, putsa. niebla, s. puyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2125, 'nieve', '0', 'nieve',
        '<div class="word--description">             <p class="word--description">s. rasu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2126, 'nigua', '0', 'nigua',
        '<div class="word--description">             <p class="word--description">s. iniu, piki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2127, 'ninia de los ojos', '0', 'ninia de los ojos',
        '<div class="word--description">             <p class="word--description">s. pichiw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2128, 'ninio', '0', 'ninio',
        '<div class="word--description">             <p class="word--description">s. wawa, uchilla; que sigue a sus pa- dres: chupa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2129, 'nivelar', '0', 'nivelar',
        '<div class="word--description">             <p class="word--description">v. allana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2130, 'no', '0', 'no',
        '<div class="word--description">             <p class="word--description">adv. ama, mana. noble, adj. kapak. noche, s. tuta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2131, 'no friegues', '0', 'no friegues',
        '<div class="word--description">             <p class="word--description">expresión: ampuku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2132, 'nogal', '0', 'nogal',
        '<div class="word--description">             <p class="word--description">s. tukti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2133, 'nombre', '0', 'nombre',
        '<div class="word--description">             <p class="word--description">s. shuti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2134, 'norte (región)', '0', 'norte (región)',
        '<div class="word--description">             <p class="word--description">s. chinchay; punto cardinal: uraysuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2135, 'nosotros', '0', 'nosotros',
        '<div class="word--description">             <p class="word--description">pron. niukanchik. novecientos, num. iskun pachak, iskun patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2136, 'noventa', '0', 'noventa',
        '<div class="word--description">             <p class="word--description">num. iskun chunka. novia, s. sawarina kuytsa. noviembre, s. <**ayar. novio, s. sawarina wamra. nube, s. puyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2137, 'nublado', '0', 'nublado',
        '<div class="word--description">             <p class="word--description">adj. puyu puyu, puyushka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2138, 'nublarse', '0', 'nublarse',
        '<div class="word--description">             <p class="word--description">v. puyuna. nuca, s. washa kunka. nucleo, s. shunku. nudo, s. kipu, muku, sutu. nuera, s. kachun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2139, 'nuestro senior', '0', 'nuestro senior',
        '<div class="word--description">             <p class="word--description">s. (Jesucristo) s. Apunchik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2140, 'nuevamente', '0', 'nuevamente',
        '<div class="word--description">             <p class="word--description">adv. kutin. nueve mil, num. iskun waranka. nueve, num. iskun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2141, 'nuevo (persona', '0', 'nuevo (persona',
        '<div class="word--description">             <p class="word--description">objeto, tiempo), adj. mus-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2142, 'huk', '0', 'huk',
        '<div class="word--description">             <p class="word--description">wamak.</p>          </div>', 'ACTIVE',
        2, '-'),
       (2143, 'numerado', '0', 'numerado',
        '<div class="word--description">             <p class="word--description">adj. yupashka. numerar, s. yupana. numero, s. yupay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2144, 'nutria', '0', 'nutria',
        '<div class="word--description">             <p class="word--description">s. pishnia; yaku ukucha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2145, 'objeto', '0', 'objeto',
        '<div class="word--description">             <p class="word--description">s. ima; sagrado: waka; de barro: puru; hacer objetos de barro: v. awana. obsequiar, v. kamarina, kuyana. observar, v. rikuna, chapana. obstaculizar, v. harkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2146, 'obstaculo', '0', 'obstaculo',
        '<div class="word--description">             <p class="word--description">s. harka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2147, 'oca', '0', 'oca',
        '<div class="word--description">             <p class="word--description">s. uka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2148, 'occidente', '0', 'occidente',
        '<div class="word--description">             <p class="word--description">s. inti yaykuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2149, 'oceano', '0', 'oceano',
        '<div class="word--description">             <p class="word--description">s. mama kucha; oceano pacífico:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2150, '<*wirakuchap kutimunkan. ochenta', '0', '<*wirakuchap kutimunkan. ochenta',
        '<div class="word--description">             <p class="word--description">num. pusak chunka. ocho cientos, num. pusak pachak. ocho mil, num. pusak waranka. ocho, num. pusak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2151, 'ocioso', '0', 'ocioso',
        '<div class="word--description">             <p class="word--description">adj. (<*qilla), killa. octubre, s. <*yaku. ocultar, v. killpana, pakana. odiar, v. chiknina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2152, 'oeste', '0', 'oeste',
        '<div class="word--description">             <p class="word--description">s. inti yaykuna. ofrecer, v. kuna. oído, s. rinri hutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2153, 'oido', '0', 'oido',
        '<div class="word--description">             <p class="word--description">adj. uyashka, uyarishka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2154, 'oir', '0', 'oir',
        '<div class="word--description">             <p class="word--description">v. uyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2155, 'ojo', '0', 'ojo',
        '<div class="word--description">             <p class="word--description">s. niawi; cerrar los ojos: v. itsipuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2156, 'oler', '0', 'oler',
        '<div class="word--description">             <p class="word--description">v. ashnana, mutkina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2157, 'olfato', '0', 'olfato',
        '<div class="word--description">             <p class="word--description">s. mutki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2158, 'olla', '0', 'olla',
        '<div class="word--description">             <p class="word--description">s. manka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2159, 'oloroso', '0', 'oloroso',
        '<div class="word--description">             <p class="word--description">adj. ashnak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2160, 'olvidado', '0', 'olvidado',
        '<div class="word--description">             <p class="word--description">adj. kunkashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2161, 'olvidar', '0', 'olvidar',
        '<div class="word--description">             <p class="word--description">v. kunkana. olvido, s. kunkay. ombligo, s. pupu. omnívoro, adj. tukuymikuk. omóplato, s. karmin. oprimir, v. niitina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2162, 'ordenar', '0', 'ordenar',
        '<div class="word--description">             <p class="word--description">poner en orden, en buena dispo-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2163, 'sición', '0', 'sición',
        '<div class="word--description">             <p class="word--description">v. (<*hichyay), hichyana. ordeniar, v. chawana, kapina. oreja, s. rinri, rinri kara. orientación, s. rikuchiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2164, 'oriente', '0', 'oriente',
        '<div class="word--description">             <p class="word--description">s. punto cardinal: inti llukshina; re-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2165, 'gión: anti suyu. origen', '0', 'gión: anti suyu. origen',
        '<div class="word--description">             <p class="word--description">s. sapi. orilla, s. manya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2166, 'orinar', '0', 'orinar',
        '<div class="word--description">             <p class="word--description">v. ishpana; yaku-ishpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2167, 'ortiga', '0', 'ortiga',
        '<div class="word--description">             <p class="word--description">s. chini. ortigar, v. chinina. orzuelo, s. itsipu. oscilar, v. walinyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2168, 'oscuro', '0', 'oscuro',
        '<div class="word--description">             <p class="word--description">adj. amsa, llantu, pakna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2169, 'oso', '0', 'oso',
        '<div class="word--description">             <p class="word--description">s. ukumari. otonio, s. wayra pacha. otra vez, adv. kutin. oveja, s. llama. ovillar, v. kururuna. ovillo, s. kururu. oxidarse, v. wakarina. oyente, s. uyak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2170, 'pacífico', '0', 'pacífico',
        '<div class="word--description">             <p class="word--description">adj. kasilla; oceano pacífico: <*wi- rakuchap kutimunkan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2171, 'padre', '0', 'padre',
        '<div class="word--description">             <p class="word--description">s. yaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2172, 'padrino de bautizo', '0', 'padrino de bautizo',
        '<div class="word--description">             <p class="word--description">s. markakyaya, achikyaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2173, 'pagina', '0', 'pagina',
        '<div class="word--description">             <p class="word--description">s. (<*patara), patara, panka. paico, yerba medicinal, s. payku. país, s. llakta, mamallakta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2174, 'paja (variedades', '0', 'paja (variedades',
        '<div class="word--description">             <p class="word--description">s. uksha, siksik, wayuri,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2175, 'pajaro (varidedades)', '0', 'pajaro (varidedades)',
        '<div class="word--description">             <p class="word--description">s. munchi, chaniawi, chikwan, chiwlli, chiyun, killpuntu, kitiwpi, ku- llishtiti, kuwayu, chikin chikin, liklik, lluta, manku, panzaw, pishku, piyan piyan, pusayu,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2176, 'tiwinkulu', '0', 'tiwinkulu',
        '<div class="word--description">             <p class="word--description">tiyunti, tiyuti, tsalak tsalak, tullik, tunchi, tuntu, wiriwiri, zhuta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2177, 'pala', '0', 'pala',
        '<div class="word--description">             <p class="word--description">tipo de, s. wallmu. palanca, s. tula, wanka. palla, tipo de rondador, s. palla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2178, 'palma de la mano', '0', 'palma de la mano',
        '<div class="word--description">             <p class="word--description">s. maki pampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2179, 'palmadas', '0', 'palmadas',
        '<div class="word--description">             <p class="word--description">dar, v. kuyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2180, 'palmera (variedades)', '0', 'palmera (variedades)',
        '<div class="word--description">             <p class="word--description">s. chilli, chincha, chinku, kuya, lukata, murito, shapaka, shimpi, shipati, shiwa, unkurawa, yarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2181, 'palo', '0', 'palo',
        '<div class="word--description">             <p class="word--description">s. kaspi; que nace del cabuyo: (<*qiru),</p>          </div>',
        'ACTIVE', 2, '-'),
       (2182, 'kiru; palos y carrizos para cubiertas y paredes de casas', '0',
        'kiru; palos y carrizos para cubiertas y paredes de casas',
        '<div class="word--description">             <p class="word--description">corrales y cercas: chaklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2183, 'palpar', '0', 'palpar',
        '<div class="word--description">             <p class="word--description">v. llamkana, hawina. paludismo, s. chukchu-unkuy. pan, s. tanta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2184, 'pancreas', '0', 'pancreas',
        '<div class="word--description">             <p class="word--description">s. iducha; kantsapata. pantalón, s. wara; poner pantalones: wara- chikuy; ponerse pantalones: warallikuy. pantano, s. guzu, kuzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2185, 'pantorilla', '0', 'pantorilla',
        '<div class="word--description">             <p class="word--description">s. chakichichu. panza, s. (<*uspun), pusun. panial, s. llachapa, pintu, akawara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2186, 'panio (manchas del rostro)', '0', 'panio (manchas del rostro)',
        '<div class="word--description">             <p class="word--description">s. mirka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2187, 'papa', '0', 'papa',
        '<div class="word--description">             <p class="word--description">s. papa; rojiza: yunkarak; deshidra- tada: chunu, chuniu, muray; pelada y amari- llenta: akma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2188, 'papa', '0', 'papa',
        '<div class="word--description">             <p class="word--description">s. yaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2189, 'papel', '0', 'papel',
        '<div class="word--description">             <p class="word--description">s. (<*patara); panka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2190, 'papirotear', '0', 'papirotear',
        '<div class="word--description">             <p class="word--description">v. tinkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2191, 'paquete', '0', 'paquete',
        '<div class="word--description">             <p class="word--description">s. apay; atado en hojas: maytu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2192, 'par', '0', 'par',
        '<div class="word--description">             <p class="word--description">adv. ishkantin, yanantin. paramo, s. puna, sallka. parar, v. shayarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2193, 'pararse', '0', 'pararse',
        '<div class="word--description">             <p class="word--description">v. hatarina, shayana. parecerse, v. rikchana. parecido, -a, adv. rikchaklla, shina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2194, 'pared', '0', 'pared',
        '<div class="word--description">             <p class="word--description">s. pirka; de una casa abandonada:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2195, 'pareja', '0', 'pareja',
        '<div class="word--description">             <p class="word--description">adv. ishkantin, yanantin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2196, 'pariente', '0', 'pariente',
        '<div class="word--description">             <p class="word--description">s. ayllu. parir, v. wachana. parpado, s. niawi kara. parque, s. sisa pampa. parroquia, s. kitilli (¿?).</p>          </div>',
        'ACTIVE', 2, '-'),
       (2197, 'parte alta de la casa', '0', 'parte alta de la casa',
        '<div class="word--description">             <p class="word--description">cuesta, pared o</p>          </div>',
        'ACTIVE', 2, '-'),
       (2198, 'penia', '0', 'penia',
        '<div class="word--description">             <p class="word--description">adv. hanak pata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2199, 'parte', '0', 'parte',
        '<div class="word--description">             <p class="word--description">s. rakiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2200, 'partido (político)', '0', 'partido (político)',
        '<div class="word--description">             <p class="word--description">s. (<*suyuchakuska); par- tido o semi, medio: chikta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2201, 'partir', '0', 'partir',
        '<div class="word--description">             <p class="word--description">v. chiktana, ikina, rakina, chillpina; en la mitad: chawpina, patmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2202, 'pasado', '0', 'pasado',
        '<div class="word--description">             <p class="word--description">adj. yallishka; pasado maniana: mincha; tiempo pasado: sarun pacha, niawpa pacha, unay pacha, wayma pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2203, 'pasar', '0', 'pasar',
        '<div class="word--description">             <p class="word--description">v. yallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2204, 'pasarse', '0', 'pasarse',
        '<div class="word--description">             <p class="word--description">el tiempo, v. (<* yalliriy), yallirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2205, 'pasear', '0', 'pasear',
        '<div class="word--description">             <p class="word--description">v. puriykachana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2206, 'paso', '0', 'paso',
        '<div class="word--description">             <p class="word--description">s. tatki; dar pasos el ninio: tatkiy. paspa, grieta en la piel, s. paspa, zipi. pastar, v. michina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2207, 'pasto', '0', 'pasto',
        '<div class="word--description">             <p class="word--description">s. waylla, muya; lugar de pasto: mi-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2208, 'pastor', '0', 'pastor',
        '<div class="word--description">             <p class="word--description">-a, s. michik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2209, 'pastorear', '0', 'pastorear',
        '<div class="word--description">             <p class="word--description">v. michina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2210, 'pata', '0', 'pata',
        '<div class="word--description">             <p class="word--description">cosas o animales, s. chaki. patalear, v. kushparina. patata, s. papa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2211, 'patear', '0', 'patear',
        '<div class="word--description">             <p class="word--description">v. haytana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2212, 'patio', '0', 'patio',
        '<div class="word--description">             <p class="word--description">s. kancha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2213, 'pato', '0', 'pato',
        '<div class="word--description">             <p class="word--description">variedad de, s. kulta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2214, 'patria', '0', 'patria',
        '<div class="word--description">             <p class="word--description">s. <*pakarishka llakta; llakta, mama- llakta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2215, 'patrono', '0', 'patrono',
        '<div class="word--description">             <p class="word--description">s. llamkayyuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2216, 'pausa', '0', 'pausa',
        '<div class="word--description">             <p class="word--description">s. samay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2217, 'pava', '0', 'pava',
        '<div class="word--description">             <p class="word--description">-o, s. akankaw, muntiti, pawshi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2218, 'peca', '0', 'peca',
        '<div class="word--description">             <p class="word--description">s. mirka. pecado, s. hucha. pecador, s. huchallik. pecar, v. huchallina. pecho, s. kasku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2219, 'pedacear', '0', 'pedacear',
        '<div class="word--description">             <p class="word--description">v. pakina, takana; la ropa: chall-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2220, 'pedazo', '0', 'pedazo',
        '<div class="word--description">             <p class="word--description">s. paki, rakiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2221, 'pedir', '0', 'pedir',
        '<div class="word--description">             <p class="word--description">v. maniana; ayuda a otro: minkana; la mano de la novia por segunda vez: paktana. pedo, s. supi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2222, 'peer', '0', 'peer',
        '<div class="word--description">             <p class="word--description">v. supina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2223, 'pegar (golpear)', '0', 'pegar (golpear)',
        '<div class="word--description">             <p class="word--description">v. makana, waktana; con substancias adherentes: llutana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2224, 'peinar', '0', 'peinar',
        '<div class="word--description">             <p class="word--description">v. niakchana. peine, s. niakcha. peinilla, s. niakcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2225, 'pelar', '0', 'pelar',
        '<div class="word--description">             <p class="word--description">v. lluchuna, llushtina; con los dientes:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2226, 'pelea', '0', 'pelea',
        '<div class="word--description">             <p class="word--description">s. makanakuy; pelea ritual: tinkuy, pukara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2227, 'pelear', '0', 'pelear',
        '<div class="word--description">             <p class="word--description">v. makanakuna; las mujeres: ala- pana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2228, 'pellejo', '0', 'pellejo',
        '<div class="word--description">             <p class="word--description">s. kara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2229, 'pellizcar', '0', 'pellizcar',
        '<div class="word--description">             <p class="word--description">v. tispina, tsitsikina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2230, 'pelo', '0', 'pelo',
        '<div class="word--description">             <p class="word--description">s. akcha. pelota, rumpa. pelusa, s. akwas. pena, s. llaki, llakikuy. penco, s. chawar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2231, 'pender', '0', 'pender',
        '<div class="word--description">             <p class="word--description">estar colgado, v. wayunkana,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2232, 'wayurina', '0', 'wayurina',
        '<div class="word--description">             <p class="word--description">warkurina. pene, s. ullu. pensamiento, s. yuyay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2233, 'pensante', '0', 'pensante',
        '<div class="word--description">             <p class="word--description">adj. yuyak, yuyayyuk, shunkuyuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2234, 'pensar', '0', 'pensar',
        '<div class="word--description">             <p class="word--description">v. yuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2235, 'pensativo', '0', 'pensativo',
        '<div class="word--description">             <p class="word--description">adj. yuyarikuk; estar pensativo,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2236, 'penia', '0', 'penia',
        '<div class="word--description">             <p class="word--description">s. kaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2237, 'pepa', '0', 'pepa',
        '<div class="word--description">             <p class="word--description">s. muyu, ruru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2238, 'pequenio', '0', 'pequenio',
        '<div class="word--description">             <p class="word--description">adj. uchilla, wawa; chusu, hamchi, niutu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2239, 'perder', '0', 'perder',
        '<div class="word--description">             <p class="word--description">v. chinkana; el conocimiento: may- zana, yuyaychinkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2240, 'perderse', '0', 'perderse',
        '<div class="word--description">             <p class="word--description">v. chinkarina. perdiz, s. yutu, tukilu. perdón?, interj. ¿haw?. perdonar, v. kishpichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2241, 'perezoso', '0', 'perezoso',
        '<div class="word--description">             <p class="word--description">adj. killasapa, sampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2242, 'perico ligero', '0', 'perico ligero',
        '<div class="word--description">             <p class="word--description">s. intillama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2243, 'perico', '0', 'perico',
        '<div class="word--description">             <p class="word--description">tipo de pajaro, s. chuki, ichu, wichu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2244, 'período', '0', 'período',
        '<div class="word--description">             <p class="word--description">s. mita.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2245, 'permitir', '0', 'permitir',
        '<div class="word--description">             <p class="word--description">v. kacharina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2246, 'pero', '0', 'pero',
        '<div class="word--description">             <p class="word--description">conj. shinallatak, shinapash.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2247, 'perro', '0', 'perro',
        '<div class="word--description">             <p class="word--description">s. allku; expresión para los perros ca- zadores que siguen el rastro de personas o animales: tiw tiw tiw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2248, 'perseguir', '0', 'perseguir',
        '<div class="word--description">             <p class="word--description">v. katiykachana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2249, 'persona', '0', 'persona',
        '<div class="word--description">             <p class="word--description">s. runa; inadaptable a las costum- bres de un pueblo: awka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2250, 'pesadillas', '0', 'pesadillas',
        '<div class="word--description">             <p class="word--description">s. <* llapik; tener pesadillas, v. llapitukuna; nuspana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2251, 'pesado', '0', 'pesado',
        '<div class="word--description">             <p class="word--description">adj. llashak, llashashka. pesar en balanza, v. llashana. pescado, s., adj. challwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2252, 'pescar', '0', 'pescar',
        '<div class="word--description">             <p class="word--description">v. challwana; buscando debajo de</p>          </div>',
        'ACTIVE', 2, '-'),
       (2253, 'pestaniar', '0', 'pestaniar',
        '<div class="word--description">             <p class="word--description">v. kimllana, pimpirana, sipuna. pestanias, s. kichipra, llipinshi. petrificarse, v. rumiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2254, 'petróleo', '0', 'petróleo',
        '<div class="word--description">             <p class="word--description">s. punkara, allpawira.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2255, 'pez (variedad)', '0', 'pez (variedad)',
        '<div class="word--description">             <p class="word--description">s. challwa, chinlus, chuti, ka- lamatu, kiruyuk, kururu, lupi, paku, paychi, pi- ruru, sichi, siklli, shikitu, tanla, tuksik, tunsa, wal, yaku-aycha, yawisun, yayu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2256, 'pezón', '0', 'pezón',
        '<div class="word--description">             <p class="word--description">s. chuchu niawi, chuchu muyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2257, 'pezunia', '0', 'pezunia',
        '<div class="word--description">             <p class="word--description">s. sillu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2258, 'picadura', '0', 'picadura',
        '<div class="word--description">             <p class="word--description">adj. kanishka; que deja el gu- sano: chay chay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2259, 'picante', '0', 'picante',
        '<div class="word--description">             <p class="word--description">adj. hayak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2260, 'picar', '0', 'picar',
        '<div class="word--description">             <p class="word--description">dar comezón, v. shikshina; los insec- tos: kanina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2261, 'pícaro', '0', 'pícaro',
        '<div class="word--description">             <p class="word--description">adj. challi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2262, 'pico (de ave)', '0', 'pico (de ave)',
        '<div class="word--description">             <p class="word--description">s. tapsa; shimi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2263, 'pie', '0', 'pie',
        '<div class="word--description">             <p class="word--description">s. chaki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2264, 'piedra', '0', 'piedra',
        '<div class="word--description">             <p class="word--description">rumi; piedra preciosa: <* uminia; pie- dra pequenia: sharu, zharu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2265, 'piel', '0', 'piel',
        '<div class="word--description">             <p class="word--description">s. kara.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2266, 'pierna', '0', 'pierna',
        '<div class="word--description">             <p class="word--description">s. chanka; chuscha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2267, 'pieza', '0', 'pieza',
        '<div class="word--description">             <p class="word--description">musical: s. taki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2268, 'pincel', '0', 'pincel',
        '<div class="word--description">             <p class="word--description">s. tullpuk-kaspi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2269, 'pinchar', '0', 'pinchar',
        '<div class="word--description">             <p class="word--description">v. tuksina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2270, 'pingullo', '0', 'pingullo',
        '<div class="word--description">             <p class="word--description">tipo de flauta, s. pinkullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2271, 'pintar con colores', '0', 'pintar con colores',
        '<div class="word--description">             <p class="word--description">v. (<*llimpiy), llimpina, hawina, llunchina; pintar con pintura una casa u otro objeto: tullpuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2272, 'pintón', '0', 'pintón',
        '<div class="word--description">             <p class="word--description">adj. ankas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2273, 'pintor', '0', 'pintor',
        '<div class="word--description">             <p class="word--description">de artes plasticas, adj. (<*llim- pik), shuyuk, hawik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2274, 'pintura del dibujante o artista', '0', 'pintura del dibujante o artista',
        '<div class="word--description">             <p class="word--description">s. (<*llimpi- nakuna); para teniir: (<*tullpuna), tullpu. pinia, s. chiwilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2275, 'piojo', '0', 'piojo',
        '<div class="word--description">             <p class="word--description">s. usa, pikli, pilis. piola, s. kawchu. pirania, s. pania.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2276, 'pisada', '0', 'pisada',
        '<div class="word--description">             <p class="word--description">s. (<*yupi), chaki kati. pisar, v. saruna, haytana. piso, s. pata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2277, 'pizarrón', '0', 'pizarrón',
        '<div class="word--description">             <p class="word--description">s. killkanapirka. placenta, s. wawamama. plaga de plantas, s. lancha. planeta, s. <**rumpu. planicie, s. pampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2278, 'planta del pie', '0', 'planta del pie',
        '<div class="word--description">             <p class="word--description">s. chaki pampa, chaki uku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2279, 'planta', '0', 'planta',
        '<div class="word--description">             <p class="word--description">general, s. yura, mallki; (varieda- des): chill chill, chullku, illimpu, iniil, lalu, mun- chi, niutu, pitsik, purun, tsimpiyu, tsintsimpu, tsinzu, tiyatina, ushun, wala, wamintsi, wa- ranku; planta seca del maíz: challa, kallcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2280, 'plata', '0', 'plata',
        '<div class="word--description">             <p class="word--description">mineral, s. kullki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2281, 'platano', '0', 'platano',
        '<div class="word--description">             <p class="word--description">s. palanta; maquenio: yurimawas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2282, 'plato', '0', 'plato',
        '<div class="word--description">             <p class="word--description">s. mulu, puku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2283, 'plaza', '0', 'plaza',
        '<div class="word--description">             <p class="word--description">s. kancha, pata, pampa; plaza de en- tretenimientos, en el Cuzco antiguo: (<*kussi pata); kushipata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2284, 'plegar', '0', 'plegar',
        '<div class="word--description">             <p class="word--description">v. patarina. plomo, s. titi. pluma, s. patpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2285, 'plutón', '0', 'plutón',
        '<div class="word--description">             <p class="word--description">planeta, s. <**riti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2286, 'poblar', '0', 'poblar',
        '<div class="word--description">             <p class="word--description">v. llaktana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2287, 'pobre', '0', 'pobre',
        '<div class="word--description">             <p class="word--description">adj. wakcha, tsunzu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2288, 'poco a poco', '0', 'poco a poco',
        '<div class="word--description">             <p class="word--description">adv. allimanta. poco, det. asha, ansa, aslla, pishi. poder, v. atipana, atina, ushana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2289, 'podrido', '0', 'podrido',
        '<div class="word--description">             <p class="word--description">adj. ismu, ismushka, misha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2290, 'podrirse', '0', 'podrirse',
        '<div class="word--description">             <p class="word--description">v. ismuna. poesía, s. arawiku, harawi. poeta, adj. arawikuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2291, 'policía', '0', 'policía',
        '<div class="word--description">             <p class="word--description">s. chapak. polilla, s. susu. polinizar, v. yayuna. pollo, s. chuchi, chiwchi. polvo, s. allpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2292, 'ponderarse', '0', 'ponderarse',
        '<div class="word--description">             <p class="word--description">v. chakchuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2293, 'pondo', '0', 'pondo',
        '<div class="word--description">             <p class="word--description">s. puntu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2294, 'poner', '0', 'poner',
        '<div class="word--description">             <p class="word--description">v. churana; una cosa sobre otra: pall- tay; huevos las aves o peces: wachana; boca abajo: tikrachina; poner algo en el seno: kin- chullina; poner cubierta a la casa: awana. ponerse de pie, v. shayarina, hatarina. por dónde?, preg. ¿maytatak?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2295, 'por ello', '0', 'por ello',
        '<div class="word--description">             <p class="word--description">conj. chayrayku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2296, 'por eso', '0', 'por eso',
        '<div class="word--description">             <p class="word--description">conj. chaymanta, chayrayku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2297, 'por que?', '0', 'por que?',
        '<div class="word--description">             <p class="word--description">preg. ¿imamantatak?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2298, 'por supuesto', '0', 'por supuesto',
        '<div class="word--description">             <p class="word--description">adv. shinami, shinayka, shi- naykuti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2299, 'porfiar', '0', 'porfiar',
        '<div class="word--description">             <p class="word--description">v. atina. posada, s. tampu. potrero, s. muya. pozo, s. pukyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2300, 'precepto', '0', 'precepto',
        '<div class="word--description">             <p class="word--description">s. (<*kamachikuska).</p>          </div>',
        'ACTIVE', 2, '-'),
       (2301, 'precio', '0', 'precio',
        '<div class="word--description">             <p class="word--description">s. chanin. precioso, adj. sumak. predecesor, s. niawpak. preguntar, v. tapuna. prendedor, s. tupu. preniada, adj. chichu. preniarse, v. chichuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2302, 'preparar', '0', 'preparar',
        '<div class="word--description">             <p class="word--description">v. allichina; la chicha: aswana; la</p>          </div>',
        'ACTIVE', 2, '-'),
       (2303, 'tierra para la siembra: chakrana. presentador', '0', 'tierra para la siembra: chakrana. presentador',
        '<div class="word--description">             <p class="word--description">v. riksichik, rikuchik. presentar, v. riksichina, rikuchina. presentarse, v. rikurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2304, 'presente', '0', 'presente',
        '<div class="word--description">             <p class="word--description">adv. kunan; tiempo presente:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2305, 'presidente', '0', 'presidente',
        '<div class="word--description">             <p class="word--description">s. pushak. presionar, v. atina; algo: niitina. prestar, v. maniachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2306, 'preterito', '0', 'preterito',
        '<div class="word--description">             <p class="word--description">adv. niawpa pacha, sarun pacha. pretina, especie de, s. watu. prevalecer, v. atina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2307, 'prever', '0', 'prever',
        '<div class="word--description">             <p class="word--description">v. musyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2308, 'primavera', '0', 'primavera',
        '<div class="word--description">             <p class="word--description">s. pawkar waray, sisa pacha. primero, adv. niawpak, shukniki; hijo,-a pri- meros: niawi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2309, 'princesa', '0', 'princesa',
        '<div class="word--description">             <p class="word--description">s. niusta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2310, 'principal', '0', 'principal',
        '<div class="word--description">             <p class="word--description">adj. hatun, kuraka, kapak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2311, 'príncipe', '0', 'príncipe',
        '<div class="word--description">             <p class="word--description">adj. awki. principiar, v. kallarina. principio, s. sapi; adv. kallari. prisión, s. wataywasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2312, 'puesto', '0', 'puesto',
        '<div class="word--description">             <p class="word--description">s. kuska. pujar, v. hipana. pulga, s. piki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2313, 'pulgar', '0', 'pulgar',
        '<div class="word--description">             <p class="word--description">dedo: s. mama ruka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2314, 'pulir', '0', 'pulir',
        '<div class="word--description">             <p class="word--description">v. llampuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2315, 'probar', '0', 'probar',
        '<div class="word--description">             <p class="word--description">v. kamana, mallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2316, 'problema o contratiempo', '0', 'problema o contratiempo',
        '<div class="word--description">             <p class="word--description">s. llaki. producto óptimo, adj. wanlla; productos o granos que se quedan despues de la co- secha: challa, chukchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2317, 'profesor', '0', 'profesor',
        '<div class="word--description">             <p class="word--description">-a, s. yachachik. pronto, adv. utka, hayka. propagación, s. miray. propio (de suyo), adj. kikin. provincia, s. marka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2318, 'provocar', '0', 'provocar',
        '<div class="word--description">             <p class="word--description">hacer antojar, v. munachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2319, 'pueblo', '0', 'pueblo',
        '<div class="word--description">             <p class="word--description">s. llakta. puente, s. chaka. puerco, -a, s. kuchi. puerta, s. punku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2320, 'pulmón', '0', 'pulmón',
        '<div class="word--description">             <p class="word--description">s. (<*surqan), surkan; paruk, yurak shunku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2321, 'pulque', '0', 'pulque',
        '<div class="word--description">             <p class="word--description">de cabuya: s. chawarmishki, mishki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2322, 'pulsera', '0', 'pulsera',
        '<div class="word--description">             <p class="word--description">s. makiwatana. pulverizado, adj. niutu, kutashka, kuta. pulverizar, v. niutuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2323, 'puma', '0', 'puma',
        '<div class="word--description">             <p class="word--description">felino americano, s. puma. pumamaki, tipo de arbol, s. pumamaki. punta, adj. niawchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2324, 'punto', '0', 'punto',
        '<div class="word--description">             <p class="word--description">s. iniu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2325, 'punzar', '0', 'punzar',
        '<div class="word--description">             <p class="word--description">v. tuksina, tulana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2326, 'puniado', '0', 'puniado',
        '<div class="word--description">             <p class="word--description">det. lutsu, tsutsuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2327, 'punio cerrado', '0', 'punio cerrado',
        '<div class="word--description">             <p class="word--description">s. <*chuqmi; chukmi. pupitre, s. (<*chakiqiru), pataku. pus, s. kiya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2328, 'que dijo?', '0', 'que dijo?',
        '<div class="word--description">             <p class="word--description">interj. ¿haw?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2329, 'quieto', '0', 'quieto',
        '<div class="word--description">             <p class="word--description">adj. kasilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2330, 'quilico', '0', 'quilico',
        '<div class="word--description">             <p class="word--description">variedad de ave, s. killiku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2331, 'quebrada (depresión geografica)', '0', 'quebrada (depresión geografica)',
        '<div class="word--description">             <p class="word--description">s. wayku. quebrado, adj. paki, pakishka; fracción en matematicas: paki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2332, 'quebrar', '0', 'quebrar',
        '<div class="word--description">             <p class="word--description">v. pakina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2333, 'quemado por el sol', '0', 'quemado por el sol',
        '<div class="word--description">             <p class="word--description">adj. ruparishka, kazuk, kazukyashka, muzuklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2334, 'quemar', '0', 'quemar',
        '<div class="word--description">             <p class="word--description">v. rupachina. quemarse, v. ruparina. querer, v. munana, llakina. quichua, adj. kichwa. quien?, pron. ¿pi?.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2335, 'quinientos', '0', 'quinientos',
        '<div class="word--description">             <p class="word--description">num. pichka pachak, pichka patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2336, 'quinoa', '0', 'quinoa',
        '<div class="word--description">             <p class="word--description">s. kinuwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2337, 'quipa', '0', 'quipa',
        '<div class="word--description">             <p class="word--description">instrumento musical, s. kipa. quipo, nudos del registro y administración incasica, s. kipu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2338, 'quipocamayoc', '0', 'quipocamayoc',
        '<div class="word--description">             <p class="word--description">s. kipukamayuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2339, 'quishuar', '0', 'quishuar',
        '<div class="word--description">             <p class="word--description">s. kishwar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2340, 'quitar', '0', 'quitar',
        '<div class="word--description">             <p class="word--description">v. anchuchina, kichuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2341, 'quitarse', '0', 'quitarse',
        '<div class="word--description">             <p class="word--description">v. anchurina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2342, 'quiza', '0', 'quiza',
        '<div class="word--description">             <p class="word--description">quizas, adv. icha, ichapash.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2343, 'rabo', '0', 'rabo',
        '<div class="word--description">             <p class="word--description">s. chupa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2344, 'recuerdo', '0', 'recuerdo',
        '<div class="word--description">             <p class="word--description">s. yuyariy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2345, 'racimo', '0', 'racimo',
        '<div class="word--description">             <p class="word--description">s. luntsa, putsa, watu; de chonta: tika.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2346, 'raíz', '0', 'raíz',
        '<div class="word--description">             <p class="word--description">s. sapi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2347, 'rajar', '0', 'rajar',
        '<div class="word--description">             <p class="word--description">v. chiktana, shallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2348, 'rallar', '0', 'rallar',
        '<div class="word--description">             <p class="word--description">v. shikina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2349, 'rama', '0', 'rama',
        '<div class="word--description">             <p class="word--description">s. mallki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2350, 'rapidamente', '0', 'rapidamente',
        '<div class="word--description">             <p class="word--description">adv. niapash, utkalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2351, 'rapidísimo', '0', 'rapidísimo',
        '<div class="word--description">             <p class="word--description">adv. ninantak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2352, 'rapido', '0', 'rapido',
        '<div class="word--description">             <p class="word--description">adv. ichu, utka, hayka, zas; rapido de cocinarse o de madurarse: chawcha. raposa, s. chakka, chucha, sinik, wanchaka. raquítico, adj. irki, tsala, tsinzu, tullu. rascar, v. aspina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2353, 'rasgar', '0', 'rasgar',
        '<div class="word--description">             <p class="word--description">v. llikina, challchina. raspadura (dulce), s. mishki. raspar, v. aspina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2354, 'rastro', '0', 'rastro',
        '<div class="word--description">             <p class="word--description">s. chaki kati. ratón, s. ukucha. raya, s. aspi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2355, 'razonamiento', '0', 'razonamiento',
        '<div class="word--description">             <p class="word--description">s. hamutana, yuyana. realizar, v. rurana, llamkana. reanimarse, v. alliyana, kariyana. rebasar, v. hichana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2356, 'rebozo (matrimonial)', '0', 'rebozo (matrimonial)',
        '<div class="word--description">             <p class="word--description">s. lliklla. recelo, s. pinkay. rechoncho, adj. kurpa. recibir, v. chaskina, hapina. recien, adv. niakalla, kunanlla. recio, adj. sinchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2357, 'recipiente', '0', 'recipiente',
        '<div class="word--description">             <p class="word--description">s. de la cascara del coco: pill-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2358, 'reciprocidad', '0', 'reciprocidad',
        '<div class="word--description">             <p class="word--description">adv. ranti, ranti ranti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2359, 'reclamar', '0', 'reclamar',
        '<div class="word--description">             <p class="word--description">con enojo, v. piniana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2360, 'recoger', '0', 'recoger',
        '<div class="word--description">             <p class="word--description">v. tantana; recoger granos: pa- llana; los primeros frutos de la sementera: chakrana; los residuos de cosechas: challina, chukchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2361, 'recolectar', '0', 'recolectar',
        '<div class="word--description">             <p class="word--description">v. tantachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2362, 'recordar', '0', 'recordar',
        '<div class="word--description">             <p class="word--description">v. yuyarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2363, 'recto (hacia una dirección)', '0', 'recto (hacia una dirección)',
        '<div class="word--description">             <p class="word--description">adj. tsiklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2364, 'recuadro', '0', 'recuadro',
        '<div class="word--description">             <p class="word--description">cuadro, s. (<*tapta); shuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2365, 'red', '0', 'red',
        '<div class="word--description">             <p class="word--description">s. llika, linchi; pequenia para pescar: wishinka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2366, 'redondo', '0', 'redondo',
        '<div class="word--description">             <p class="word--description">macizo esferico, adj. (<*rumpu); rumpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2367, 'refajo', '0', 'refajo',
        '<div class="word--description">             <p class="word--description">s. ukunchina. refinar, v. niutuna. reforzar, v. kimina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2368, 'regalar', '0', 'regalar',
        '<div class="word--description">             <p class="word--description">v. kamarina, karana, kuyana. regalo, s. kamari; que se da en las fiestas: hucha; que dan los ahijados a sus padrinos: kuyachiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2369, 'reganiar', '0', 'reganiar',
        '<div class="word--description">             <p class="word--description">v. piniachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2370, 'regar', '0', 'regar',
        '<div class="word--description">             <p class="word--description">v. hichana, chakchuna, chiwana, shi- wana, tallina; agua de regadío: parkuna. regarse, v. hicharina, tallirina, shiwtana. región, s. suyu; región oriental: anti suyu; región occidental: kunti suyu; región del norte: chinchay suyu; región del sur: kullay suyu; región de la sierra: puna suyu; región de la costa o calida: yunka suyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2371, 'regla', '0', 'regla',
        '<div class="word--description">             <p class="word--description">objeto escolar, s. (<*siqina).</p>          </div>',
        'ACTIVE', 2, '-'),
       (2372, 'reglamento', '0', 'reglamento',
        '<div class="word--description">             <p class="word--description">s. kamachiy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2373, 'regresar', '0', 'regresar',
        '<div class="word--description">             <p class="word--description">v. kutimuna, tikramuna, tikrana; al lugar de origen, a la tierra materna: llaktana. reina soltera, s. niusta; reina casada: (<*quya, kuya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2374, 'reir', '0', 'reir',
        '<div class="word--description">             <p class="word--description">v. asina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2375, 'relaciones sexuales', '0', 'relaciones sexuales',
        '<div class="word--description">             <p class="word--description">(tener), v. yukuna, yumana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2376, 'relampaguear', '0', 'relampaguear',
        '<div class="word--description">             <p class="word--description">v. llipyana. rellenar, v. awinchina, huntachina. reloj, s. (<*pacha-unanchanqa). remanso, s. tuyaka, walun, rematar, v. alapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2377, 'remedio', '0', 'remedio',
        '<div class="word--description">             <p class="word--description">s. hampi. remellar, v. llakana. remellarse, v. rawmana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2378, 'remendar', '0', 'remendar',
        '<div class="word--description">             <p class="word--description">v. llachapana, chupana, lampana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2379, 'remiendo', '0', 'remiendo',
        '<div class="word--description">             <p class="word--description">s. llachapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2380, 'remo', '0', 'remo',
        '<div class="word--description">             <p class="word--description">s. kawina, tawna, wanka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2381, 'remojarse', '0', 'remojarse',
        '<div class="word--description">             <p class="word--description">v. nuyuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2382, 'remolino', '0', 'remolino',
        '<div class="word--description">             <p class="word--description">de viento: s. akapana; de agua: muyuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2383, 'remorderse', '0', 'remorderse',
        '<div class="word--description">             <p class="word--description">tener remordimiento, v. nana- rina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2384, 'remoto', '0', 'remoto',
        '<div class="word--description">             <p class="word--description">pasado, adv. niawpa, unay, sarun. renacuajo, s. chimpaluk, putukulu, willi willi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2385, 'rendir cuentas', '0', 'rendir cuentas',
        '<div class="word--description">             <p class="word--description">v. chimpapurachina. repartidor de comida y bebida en las fies- tas, s. awlakanu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2386, 'repartir (alimentos', '0', 'repartir (alimentos',
        '<div class="word--description">             <p class="word--description">objetos), v. rakina. reprender, v. piniachina. reprodución, s. mirana, muruna. reproducir, v. mirana, muruna. reproductor, s. mirak, muruk. repugnar, v. millana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2387, 'resbalar', '0', 'resbalar',
        '<div class="word--description">             <p class="word--description">v. lluchkana. resbalarse, v. llushpina. resbaloso, adj. lluchka. resembrar, v. awinchina, katichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2388, 'resentirse', '0', 'resentirse',
        '<div class="word--description">             <p class="word--description">v. impayarina, nanakyana. reserva de alimentos que se lleva a la casa, adj. wanlla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2389, 'residuo', '0', 'residuo',
        '<div class="word--description">             <p class="word--description">s. hamchi, kupa, niuku; de la chi- cha: tikti; de hierba o de paja que dejan los animales luego de alimentarse: punzu; resi- duo matematico: puchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2390, 'resistencia que pone la persona al ser ha- lada', '0', 'resistencia que pone la persona al ser ha- lada',
        '<div class="word--description">             <p class="word--description">s. zinzin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2391, 'resistente', '0', 'resistente',
        '<div class="word--description">             <p class="word--description">adj. sinchi, taylla. respetar, v. muchana. respiración, s. samakuy. resplandecer, v. llipyana, palanina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2392, 'resplandeciente', '0', 'resplandeciente',
        '<div class="word--description">             <p class="word--description">adj. hakan, palanikuk. responder, v. kutichina, tikrachina, rantipana. resquebrajar, v. chiktana, chillpina. resquebrajarse, v. chiktarina, chillpirina, rakrayana; la piel: paspayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2393, 'resta', '0', 'resta',
        '<div class="word--description">             <p class="word--description">s. anchuchiy. restar, v. anchuchina. resto, s. puchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2394, 'retazo (tela', '0', 'retazo (tela',
        '<div class="word--description">             <p class="word--description">madera, hierba), s. puchu; de</p>          </div>',
        'ACTIVE', 2, '-'),
       (2395, 'retirar', '0', 'retirar',
        '<div class="word--description">             <p class="word--description">v. anchuchina, suchuchina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2396, 'retirarse', '0', 'retirarse',
        '<div class="word--description">             <p class="word--description">v. anchurina. retoniar, v. winiana. retonio, s. llulluk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2397, 'retornar', '0', 'retornar',
        '<div class="word--description">             <p class="word--description">v. kutimuna, tikramuna, tikrana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2398, 'retrasarse', '0', 'retrasarse',
        '<div class="word--description">             <p class="word--description">v. kipayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2399, 'retrato', '0', 'retrato',
        '<div class="word--description">             <p class="word--description">s. (<*uyap rikchay), rikchak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2400, 'reunión', '0', 'reunión',
        '<div class="word--description">             <p class="word--description">s. tantanakuy. reunir, v. tantachina. reventar, v. tukyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2401, 'reventarse', '0', 'reventarse',
        '<div class="word--description">             <p class="word--description">v. tukyarina, chulakyarina. revolcarse, v. sinkuna, kawirina. rezar, v. maniana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2402, 'rincón', '0', 'rincón',
        '<div class="word--description">             <p class="word--description">s. kuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2403, 'riñón', '0', 'riñón',
        '<div class="word--description">             <p class="word--description">s. rurun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2404, 'río', '0', 'río',
        '<div class="word--description">             <p class="word--description">s. mayu, hatun yaku. ripio, s. sharu, zharu. robar, v. shuwana. robusto, adj. sinchi. roca, wanka, rumi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2405, 'rocío', '0', 'rocío',
        '<div class="word--description">             <p class="word--description">s. shulla; caer el rocío: v. shullana,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2406, 'rodar', '0', 'rodar',
        '<div class="word--description">             <p class="word--description">v. sinkuna. rodilla, s. kunkuri. roer, v . kaskana. rogar, v. maniana. rojo, adj. puka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2407, 'romper', '0', 'romper',
        '<div class="word--description">             <p class="word--description">v. llikina, pakina; en pedazos pe-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2408, 'quenios: pitina. roncar', '0', 'quenios: pitina. roncar',
        '<div class="word--description">             <p class="word--description">v. harnina. roncha, s. pukla, sisu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2409, 'ropa', '0', 'ropa',
        '<div class="word--description">             <p class="word--description">s. churana, churarina; sucia: waluk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2410, 'rosca', '0', 'rosca',
        '<div class="word--description">             <p class="word--description">adj. churu. rostro, s. uya; niawi. rótula, s. piruru. rotura, s. paki. rozar, v. waktana. rozarse, v. takarina. rubí, s. <*puka uminia. rubor, s. pinkay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2411, 'ruborizarse', '0', 'ruborizarse',
        '<div class="word--description">             <p class="word--description">v. pinkarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2412, 'rustico', '0', 'rustico',
        '<div class="word--description">             <p class="word--description">adj. purun.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2413, 'sabado', '0', 'sabado',
        '<div class="word--description">             <p class="word--description">s. (<**tinki).</p>          </div>',
        'ACTIVE', 2, '-'),
       (2414, 'saber', '0', 'saber',
        '<div class="word--description">             <p class="word--description">v. yachana; saber a: yachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2415, 'sabiduría', '0', 'sabiduría',
        '<div class="word--description">             <p class="word--description">s. yachay. sabio, s. amawta, yachak. sabor, s. yachik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2416, 'saborear', '0', 'saborear',
        '<div class="word--description">             <p class="word--description">v. kamana, mallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2417, 'nawaru', '0', 'nawaru',
        '<div class="word--description">             <p class="word--description">kuwa, kuwayu, lukarya, murintu, pi- ripiri, tullumpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2418, 'saquillo', '0', 'saquillo',
        '<div class="word--description">             <p class="word--description">s. tulu. sarampión, s. muru-unkuy. sarna, s. shikshi, isi, akwas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2419, 'satisfecho (de comer)', '0', 'satisfecho (de comer)',
        '<div class="word--description">             <p class="word--description">adj. hunta, saksashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2420, 'sabrosa', '0', 'sabrosa',
        '<div class="word--description">             <p class="word--description">-o, adj. (<*niukniu), chawcha, mishki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2421, 'sacapuntas', '0', 'sacapuntas',
        '<div class="word--description">             <p class="word--description">s. niawchichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2422, 'sacar', '0', 'sacar',
        '<div class="word--description">             <p class="word--description">v. surkuna, llukshichina; productos de la tierra: allana; sacar tiras: chillpina. sacerdote (principal del incario), s. umu; kushipata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2423, 'saciado', '0', 'saciado',
        '<div class="word--description">             <p class="word--description">adj. hunta, saksashka. sacudirse, v. shiwarina; las plumas, el ave: patpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2424, 'sacudir', '0', 'sacudir',
        '<div class="word--description">             <p class="word--description">v. chaspina, chawsirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2425, 'saeta', '0', 'saeta',
        '<div class="word--description">             <p class="word--description">s. wachi. safar, v. kacharina. saíno, s. lumukuchi. sal, s. kachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2426, 'sala', '0', 'sala',
        '<div class="word--description">             <p class="word--description">s. <*pitita.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2427, 'salamanquesa', '0', 'salamanquesa',
        '<div class="word--description">             <p class="word--description">s. watawata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2428, 'salir', '0', 'salir',
        '<div class="word--description">             <p class="word--description">v. llukshina; salir el sol: intiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2429, 'saliva', '0', 'saliva',
        '<div class="word--description">             <p class="word--description">tuka.</p>          </div>', 'ACTIVE',
        2, '-'),
       (2430, 'salivar', '0', 'salivar',
        '<div class="word--description">             <p class="word--description">v. tukana. saltamontes, s. chipu, hiki. saltar, v. kushpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2431, 'salud (de bienestar)', '0', 'salud (de bienestar)',
        '<div class="word--description">             <p class="word--description">s. allikay. saludar, v. napaykuna. salvaje, adj. sacha, awka. salvar, v. kishpichina. salvarse, v. kishpirina. sambo, s. sampu, zampu, kitu. sanarse, v. alliyana, hampirina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2432, 'sancochar', '0', 'sancochar',
        '<div class="word--description">             <p class="word--description">v. hawchana, ayumpakuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2433, 'sandalia', '0', 'sandalia',
        '<div class="word--description">             <p class="word--description">s. ushuta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2434, 'sango', '0', 'sango',
        '<div class="word--description">             <p class="word--description">tipo de pan, s. sanku. sangorache, s. ataku. sangre, s. yawar. sanguijuela, s. mapamari.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2435, 'sapallo', '0', 'sapallo',
        '<div class="word--description">             <p class="word--description">tipo de calabaza, s. sapallu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2436, 'sapo (variedades)', '0', 'sapo (variedades)',
        '<div class="word--description">             <p class="word--description">s. hampatu, huwin, ku-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2437, 'saturno', '0', 'saturno',
        '<div class="word--description">             <p class="word--description">s. <**chimpu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2438, 'sauce', '0', 'sauce',
        '<div class="word--description">             <p class="word--description">s. wayaw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2439, 'savia (de las plantas)', '0', 'savia (de las plantas)',
        '<div class="word--description">             <p class="word--description">s. llawsa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2440, 'saya', '0', 'saya',
        '<div class="word--description">             <p class="word--description">s. anaku, aksu; ponerse la saya: ana- kullikuy, aksullikuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2441, 'secar', '0', 'secar',
        '<div class="word--description">             <p class="word--description">v. chakichina; la carne al sol: charkina. secarse, v. ankuyana, chakirina, waniurina. sediento estar, v. upyanayana. seducir, v. kuyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2442, 'segar', '0', 'segar',
        '<div class="word--description">             <p class="word--description">v. pitina, ichuna. seguidamente, adv. kipa, kipalla. seguir, v. katina; hacer seguir: katichina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2443, 'segundo', '0', 'segundo',
        '<div class="word--description">             <p class="word--description">tiempo, s. <*tuylla. En lugar o es-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2444, 'seis', '0', 'seis',
        '<div class="word--description">             <p class="word--description">num. sukta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2445, 'seis cientos', '0', 'seis cientos',
        '<div class="word--description">             <p class="word--description">num. sukta pachak, sukta patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2446, 'seleccionado', '0', 'seleccionado',
        '<div class="word--description">             <p class="word--description">-a, adj. aklla, akllashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2447, 'seleccionar', '0', 'seleccionar',
        '<div class="word--description">             <p class="word--description">v. akllana. selva, s. sacha. semana, s. <**sillkukis.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2448, 'sembrado', '0', 'sembrado',
        '<div class="word--description">             <p class="word--description">adj. tarpushka. sembrador, s. tarpuk. sembrar, s. tarpuna. semejante, adv. shina. semejanza, s. rikchak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2449, 'sementera', '0', 'sementera',
        '<div class="word--description">             <p class="word--description">s. chakra, tarpushka allpa. semilla, s. muyu; caída en las sementeras: chas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2450, 'sendero', '0', 'sendero',
        '<div class="word--description">             <p class="word--description">s. nian.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2451, 'seno', '0', 'seno',
        '<div class="word--description">             <p class="word--description">s. chuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2452, 'sentar a los ninios', '0', 'sentar a los ninios',
        '<div class="word--description">             <p class="word--description">v. chachichina. sentarse, v. tiyarina; sentarse los ninios: chachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2453, 'senialar', '0', 'senialar',
        '<div class="word--description">             <p class="word--description">v. rikuchina, riksichina, shunkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2454, 'senior', '0', 'senior',
        '<div class="word--description">             <p class="word--description">s. yaya, hachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2455, 'seniora', '0', 'seniora',
        '<div class="word--description">             <p class="word--description">s. mama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2456, 'seniorita', '0', 'seniorita',
        '<div class="word--description">             <p class="word--description">adj. pasnia, kuytsa; expresión cari- niosa dirigida a las senioritas: mamaku, payaku. separar, v. chikanyachina, karuyachina. septentrión, s. uraysuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2457, 'septiembre', '0', 'septiembre',
        '<div class="word--description">             <p class="word--description">s. <*kuya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2458, 'ser capaz de', '0', 'ser capaz de',
        '<div class="word--description">             <p class="word--description">v. atipana, ushana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2459, 'ser humano (hombre y mujer)', '0', 'ser humano (hombre y mujer)',
        '<div class="word--description">             <p class="word--description">s. runa. ser, s. kak, vivo: kak, kawsak; ser fantas- tico: atsinku, chificha, chusulunku, chuyan, ishkay umayuk waksa, sacharuna, supay, uchutikan, walampariw, mama awaduna, mama hataba.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2460, 'ser', '0', 'ser',
        '<div class="word--description">             <p class="word--description">v. kana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2461, 'sereno', '0', 'sereno',
        '<div class="word--description">             <p class="word--description">adj. kasilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2462, 'serpiente', '0', 'serpiente',
        '<div class="word--description">             <p class="word--description">s. amaru, machakuy, mutulu, pushllu, shinshin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2463, 'serrano', '0', 'serrano',
        '<div class="word--description">             <p class="word--description">persona de la sierra, adj. sallka runa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2464, 'servidor', '0', 'servidor',
        '<div class="word--description">             <p class="word--description">adj. yana, yanapak; el que sirve</p>          </div>',
        'ACTIVE', 2, '-'),
       (2465, 'las comidas en las fiestas: rakik', '0', 'las comidas en las fiestas: rakik',
        '<div class="word--description">             <p class="word--description">awalahanu. servir, v. yanapana; servir alimentos: karana. sesenta, num. sukta chunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2466, 'sesenta mil', '0', 'sesenta mil',
        '<div class="word--description">             <p class="word--description">num. sukta waranka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2467, 'seso', '0', 'seso',
        '<div class="word--description">             <p class="word--description">s. niutku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2468, 'seta', '0', 'seta',
        '<div class="word--description">             <p class="word--description">s. kallampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2469, 'setecientos', '0', 'setecientos',
        '<div class="word--description">             <p class="word--description">num. kanchis pachak, kan- chis patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2470, 'setenta', '0', 'setenta',
        '<div class="word--description">             <p class="word--description">num. kanchis chunka. setenta mil, num. kanchis waranka. si, adv. ari.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2471, 'siega', '0', 'siega',
        '<div class="word--description">             <p class="word--description">tiempo de, s. kallchay pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2472, 'siembra', '0', 'siembra',
        '<div class="word--description">             <p class="word--description">s. tarpuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2473, 'siempre', '0', 'siempre',
        '<div class="word--description">             <p class="word--description">adv. winiay, winiaypak, tukuy pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2474, 'sien', '0', 'sien',
        '<div class="word--description">             <p class="word--description">s. <*waniuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2475, 'sierra', '0', 'sierra',
        '<div class="word--description">             <p class="word--description">s. puna, sallka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2476, 'siete mil', '0', 'siete mil',
        '<div class="word--description">             <p class="word--description">num. kanchis waranka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2477, 'siete', '0', 'siete',
        '<div class="word--description">             <p class="word--description">num. kanchis. siglo, adv. pachak-wata. sigse, s. siksik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2478, 'silbar', '0', 'silbar',
        '<div class="word--description">             <p class="word--description">v. hukipuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2479, 'silenciarse', '0', 'silenciarse',
        '<div class="word--description">             <p class="word--description">v. upallayana, chunyana. silenciosamente, adv. upalla, chulunlla. silla, s. tiyarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2480, 'silvestre', '0', 'silvestre',
        '<div class="word--description">             <p class="word--description">adj. allpa, aya, purun, sacha, mapa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2481, 'similar', '0', 'similar',
        '<div class="word--description">             <p class="word--description">adv. shina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2482, 'sin gracia', '0', 'sin gracia',
        '<div class="word--description">             <p class="word--description">adj. aminta, chamcha, chamuk,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2483, 'sin motivo', '0', 'sin motivo',
        '<div class="word--description">             <p class="word--description">adv. yankamanta. sinuosidad, adj. kinku. sirviente, adj. yana, yanapak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2484, 'sistema', '0', 'sistema',
        '<div class="word--description">             <p class="word--description">s. llika; sistema solar: intipa ayllu. sitio o lugar, s. <*tiyaskan; ceremonial: pukara, waka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2485, 'soasar', '0', 'soasar',
        '<div class="word--description">             <p class="word--description">v. ayampakuna. sobar, v. kakuna. soberano, s. apu, kapak. sobra, s. puchu, sikiyashka. sobrar, v. puchuna. sobrepasar, v. yallina. sobresalir, v. yallina, atina. sobrio, adj. mayllik. sociable, adj. maylla. socorrer, v. yanapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2486, 'soga', '0', 'soga',
        '<div class="word--description">             <p class="word--description">s. waska; soga delgada o soguilla: kawchu; hacer sogas: kawchuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2487, 'sol', '0', 'sol',
        '<div class="word--description">             <p class="word--description">s. inti; salir el sol: intiyay. soldado, s. awka, awkak. solear (el sol), v. intina. solearse, v. mashana. solicitado, adj. maniashka. solicitar, v. maniana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2488, 'sólido', '0', 'sólido',
        '<div class="word--description">             <p class="word--description">adj. sinchi, kaspiyashka, rumiyashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2489, 'solista', '0', 'solista',
        '<div class="word--description">             <p class="word--description">det. sapalla, shuklla. solitario, pajaro, s. chiwillu. sollozar, v. hikina, hikiyana. solo, adj. sapalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2490, 'soltar', '0', 'soltar',
        '<div class="word--description">             <p class="word--description">v. kacharina. sombra, s. llantu. sombrero, s. muchiku. sombrilla, s. <*achiwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2491, 'sonar', '0', 'sonar',
        '<div class="word--description">             <p class="word--description">v. <*unyay, rukyay), unyana, rukyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2492, 'soniador', '0', 'soniador',
        '<div class="word--description">             <p class="word--description">s. muskuk. soniar, v. muskuna. sopa, s. api.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2493, 'soplar', '0', 'soplar',
        '<div class="word--description">             <p class="word--description">v. pukuna; el espanto: tukana. soplo de curación, s. pukuy. sordo, adj. rinri-illak, uparinri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2494, 'sorpresivamente', '0', 'sorpresivamente',
        '<div class="word--description">             <p class="word--description">adv. haykamanta, kun-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2495, 'kaymanta', '0', 'kaymanta',
        '<div class="word--description">             <p class="word--description">zas.</p>          </div>', 'ACTIVE',
        2, '-'),
       (2496, 'sortija', '0', 'sortija',
        '<div class="word--description">             <p class="word--description">s. shiwi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2497, 'sosegar', '0', 'sosegar',
        '<div class="word--description">             <p class="word--description">v. kasiyachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2498, 'soso', '0', 'soso',
        '<div class="word--description">             <p class="word--description">adj. chamuk, chamcha, niukniu. sostener, v. charina; lo que esta por caerse: kimina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2499, 'soto', '0', 'soto',
        '<div class="word--description">             <p class="word--description">s. sutu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2500, 'suave', '0', 'suave',
        '<div class="word--description">             <p class="word--description">adj. kapya, niutu, api.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2501, 'suavecito', '0', 'suavecito',
        '<div class="word--description">             <p class="word--description">adv. hawalla, amuklla, apilla. suavizar, v. niutuna, apiyachina, amukya- china.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2502, 'brazos: ukllana. suma', '0', 'brazos: ukllana. suma',
        '<div class="word--description">             <p class="word--description">s. yapay. sumar, v. yapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2503, 'sumergirse', '0', 'sumergirse',
        '<div class="word--description">             <p class="word--description">v. washaykuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2504, 'superficial', '0', 'superficial',
        '<div class="word--description">             <p class="word--description">adv. hawalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2505, 'suavizarse', '0', 'suavizarse',
        '<div class="word--description">             <p class="word--description">v. apiyana, kapyana, llampuna. subir, v. sikana, wichayana; los precios o costos: wichayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2506, 'subitamente', '0', 'subitamente',
        '<div class="word--description">             <p class="word--description">adv. haykamanta, kunkay- manta; zas.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2507, 'succionar', '0', 'succionar',
        '<div class="word--description">             <p class="word--description">v. chumkana, tsumkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2508, 'suceder', '0', 'suceder',
        '<div class="word--description">             <p class="word--description">v. tukuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2509, 'sucio', '0', 'sucio',
        '<div class="word--description">             <p class="word--description">adj. mapa, karka, tiklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2510, 'sudar', '0', 'sudar',
        '<div class="word--description">             <p class="word--description">v. humpina. sudor, s. humpi. suelo, s. pampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2511, 'suenio de dormir', '0', 'suenio de dormir',
        '<div class="word--description">             <p class="word--description">s. puniuy; suenio de soniar:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2512, 'muskuy. sufrimiento', '0', 'muskuy. sufrimiento',
        '<div class="word--description">             <p class="word--description">s. llaki. sufrir, v. llakina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2513, 'sujetar', '0', 'sujetar',
        '<div class="word--description">             <p class="word--description">con las manos, v. charina; sujetar</p>          </div>',
        'ACTIVE', 2, '-'),
       (2514, 'superficialmente', '0', 'superficialmente',
        '<div class="word--description">             <p class="word--description">adv. hawalla, hawalla. superior, adj. kurak; parte, adv. hanak. supervisar, v. tukuyrikuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2515, 'supervisor', '0', 'supervisor',
        '<div class="word--description">             <p class="word--description">s. tukuyrikuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2516, 'suplicar', '0', 'suplicar',
        '<div class="word--description">             <p class="word--description">v. maniana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2517, 'suponer', '0', 'suponer',
        '<div class="word--description">             <p class="word--description">v. (<*watuy), watuna, waturina; yuyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2518, 'sur', '0', 'sur',
        '<div class="word--description">             <p class="word--description">(punto cardinal), s. hanansuyu; kullay suyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2519, 'surcar', '0', 'surcar',
        '<div class="word--description">             <p class="word--description">v. wachuna, rawana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2520, 'surco', '0', 'surco',
        '<div class="word--description">             <p class="word--description">s. wachu, rawa; surcos muy apega- dos: wala.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2521, 'suro', '0', 'suro',
        '<div class="word--description">             <p class="word--description">variedad de carrizo, s. suru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2522, 'sustantivo', '0', 'sustantivo',
        '<div class="word--description">             <p class="word--description">s. shuti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2523, 'susto', '0', 'susto',
        '<div class="word--description">             <p class="word--description">s. manchay; que produce susto: manchanayay; expresión de susto: mama- llaw, yayawalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2524, 'tabaco', '0', 'tabaco',
        '<div class="word--description">             <p class="word--description">s. sayri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2525, 'taita', '0', 'taita',
        '<div class="word--description">             <p class="word--description">s. yaya.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2526, 'talar', '0', 'talar',
        '<div class="word--description">             <p class="word--description">v. kuchuna, waktana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2527, 'talega', '0', 'talega',
        '<div class="word--description">             <p class="word--description">s. wayaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2528, 'alalay', '0', 'alalay',
        '<div class="word--description">             <p class="word--description">mamallaw.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2529, 'templo', '0', 'templo',
        '<div class="word--description">             <p class="word--description">s. wakawasi; apunchikwasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2530, 'tender', '0', 'tender',
        '<div class="word--description">             <p class="word--description">v. mantana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2531, 'tener o sostener', '0', 'tener o sostener',
        '<div class="word--description">             <p class="word--description">v. charina; tener pena:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2532, 'talisman', '0', 'talisman',
        '<div class="word--description">             <p class="word--description">s. para el amor: wakanki; el maíz de granos bicolor que se hallan durante la cosecha: misha; utilizado en la caza y en la pesca: piripiri.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2533, 'tallo', '0', 'tallo',
        '<div class="word--description">             <p class="word--description">s. tullu; tallo y hojas de maíz seco:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2534, 'kallcha', '0', 'kallcha',
        '<div class="word--description">             <p class="word--description">sarapanka; tallo de un racimo sin fru- tos: watu; tallo del racimo, extraído los fru- tos: chitus.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2535, 'talón', '0', 'talón',
        '<div class="word--description">             <p class="word--description">s. tayku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2536, 'tambalear', '0', 'tambalear',
        '<div class="word--description">             <p class="word--description">v. sinkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2537, 'tambor', '0', 'tambor',
        '<div class="word--description">             <p class="word--description">s. wankar; pequenio: tuntulli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2538, 'tamo', '0', 'tamo',
        '<div class="word--description">             <p class="word--description">s. tamu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2539, 'tantear', '0', 'tantear',
        '<div class="word--description">             <p class="word--description">v. llamkana, hawina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2540, 'tapa', '0', 'tapa',
        '<div class="word--description">             <p class="word--description">s. killpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2541, 'tapar', '0', 'tapar',
        '<div class="word--description">             <p class="word--description">v. killpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2542, 'tardarse', '0', 'tardarse',
        '<div class="word--description">             <p class="word--description">v. kaynana, kipayana, unayana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2543, 'tarde', '0', 'tarde',
        '<div class="word--description">             <p class="word--description">la, adv. chishi. tarea, s. ruray. tartamudear, v. aklluna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2544, 'tartamudo', '0', 'tartamudo',
        '<div class="word--description">             <p class="word--description">adj. akllu, tiyarpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2545, 'Tawantin suyu', '0', 'Tawantin suyu',
        '<div class="word--description">             <p class="word--description">las cuatro regiones del area inca, s. Tawantin suyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2546, 'taxo', '0', 'taxo',
        '<div class="word--description">             <p class="word--description">s. kullan, gullan, taksu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2547, 'teatro', '0', 'teatro',
        '<div class="word--description">             <p class="word--description">s. (<*hawkaypata), hawtaypata.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2548, 'techar', '0', 'techar',
        '<div class="word--description">             <p class="word--description">v. katana. teja, s. saniu. tejer, v. awana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2549, 'tejido rustico', '0', 'tejido rustico',
        '<div class="word--description">             <p class="word--description">comun: awashka; tejido fino:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2550, 'kumpi; de hojas de palmera: almayari', '0', 'kumpi; de hojas de palmera: almayari',
        '<div class="word--description">             <p class="word--description">san.</p>          </div>', 'ACTIVE',
        2, '-'),
       (2551, 'tejón', '0', 'tejón',
        '<div class="word--description">             <p class="word--description">mashu, wachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2552, 'tela', '0', 'tela',
        '<div class="word--description">             <p class="word--description">s. pintu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2553, 'telar', '0', 'telar',
        '<div class="word--description">             <p class="word--description">s. awanakaspi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2554, 'telarania', '0', 'telarania',
        '<div class="word--description">             <p class="word--description">s. (<*urup llikan), urupa llika.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2555, 'tematico', '0', 'tematico',
        '<div class="word--description">             <p class="word--description">adj. paku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2556, 'temblar', '0', 'temblar',
        '<div class="word--description">             <p class="word--description">v. chukchuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2557, 'temblor de tierra', '0', 'temblor de tierra',
        '<div class="word--description">             <p class="word--description">s. allpa chukchuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2558, 'temer', '0', 'temer',
        '<div class="word--description">             <p class="word--description">tener miedo, v. manchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2559, 'temor', '0', 'temor',
        '<div class="word--description">             <p class="word--description">s. manchay; expresión de temor:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2560, 'llakina; tener relaciones sexuales: upina', '0', 'llakina; tener relaciones sexuales: upina',
        '<div class="word--description">             <p class="word--description">yu- mana, yukuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2561, 'terminado', '0', 'terminado',
        '<div class="word--description">             <p class="word--description">adj. pakta; tukurishka. terminar, v. tukuchina. terminarse, v. paktarina; tukurina. terremoto, s. allpa chukchuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2562, 'terreno', '0', 'terreno',
        '<div class="word--description">             <p class="word--description">s. allpa; duro, esteril, erosionado:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2563, 'terrón', '0', 'terrón',
        '<div class="word--description">             <p class="word--description">s. kurpa; terrón de cesped: champa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2564, 'testículo', '0', 'testículo',
        '<div class="word--description">             <p class="word--description">s. lulun. testimoniar, v. iniina. teta, s. chuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2565, 'tibio', '0', 'tibio',
        '<div class="word--description">             <p class="word--description">adj. inlli, kunuklla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2566, 'tiempo', '0', 'tiempo',
        '<div class="word--description">             <p class="word--description">s. pacha; tiempo presente: kunan</p>          </div>',
        'ACTIVE', 2, '-'),
       (2567, 'pacha; tiempo pasado: niawpa pacha', '0', 'pacha; tiempo pasado: niawpa pacha',
        '<div class="word--description">             <p class="word--description">sarun pacha, yallirik pacha; tiempo futuro: kipa pacha. tienda, s. katuwasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2568, 'tierno', '0', 'tierno',
        '<div class="word--description">             <p class="word--description">adj. llullu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2569, 'tierra', '0', 'tierra',
        '<div class="word--description">             <p class="word--description">s. allpa; lugar donde se vive: allpa- mama.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2570, 'tierra', '0', 'tierra',
        '<div class="word--description">             <p class="word--description">planeta, s. <*tiksimuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2571, 'tiesto', '0', 'tiesto',
        '<div class="word--description">             <p class="word--description">s. kallana. tigre, s. uturunku. tinaja, s. mawma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2572, 'tiniebla', '0', 'tiniebla',
        '<div class="word--description">             <p class="word--description">adj. amsa, llantu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2573, 'tintura', '0', 'tintura',
        '<div class="word--description">             <p class="word--description">s. tullpu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2574, 'tío', '0', 'tío',
        '<div class="word--description">             <p class="word--description">s. hachi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2575, 'tipina', '0', 'tipina',
        '<div class="word--description">             <p class="word--description">objeto para deshojar el maíz durante la cosecha, s. tipina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2576, 'tirar', '0', 'tirar',
        '<div class="word--description">             <p class="word--description">v. shitana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2577, 'tiritar', '0', 'tiritar',
        '<div class="word--description">             <p class="word--description">por escalofríos, v. chukchuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2578, 'tiza', '0', 'tiza',
        '<div class="word--description">             <p class="word--description">s. aspina, aspik. tiznarse, v. kushniyana. tizón, s. inta.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2579, 'tocar', '0', 'tocar',
        '<div class="word--description">             <p class="word--description">algun instrumento musical: takina;</p>          </div>',
        'ACTIVE', 2, '-'),
       (2580, 'tocar la quipa: kipana; alguna cosa: llam- kana', '0', 'tocar la quipa: kipana; alguna cosa: llam- kana',
        '<div class="word--description">             <p class="word--description">hawina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2581, 'tocte', '0', 'tocte',
        '<div class="word--description">             <p class="word--description">s. tukti.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2582, 'todavía no', '0', 'todavía no',
        '<div class="word--description">             <p class="word--description">adv. manarak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2583, 'todavía', '0', 'todavía',
        '<div class="word--description">             <p class="word--description">adv. amarak; chayrak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2584, 'trapo(s)', '0', 'trapo(s)',
        '<div class="word--description">             <p class="word--description">s. llachapa. trasladar, v. ashtana. trasnocharse, v. pakarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2585, 'todo (s)', '0', 'todo (s)',
        '<div class="word--description">             <p class="word--description">det. tukuy, llampu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2586, 'toma', '0', 'toma',
        '<div class="word--description">             <p class="word--description">he aquí, exp. kayka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2587, 'tomar líquidos', '0', 'tomar líquidos',
        '<div class="word--description">             <p class="word--description">v. upyana; algo con las manos: hapina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2588, 'tonga', '0', 'tonga',
        '<div class="word--description">             <p class="word--description">s. kukayu, kukawi. tontear, v. muspana. tonto, adj. muspa, upa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2589, 'torcer', '0', 'torcer',
        '<div class="word--description">             <p class="word--description">v. kawchuna; torcer lana o hilo: kaw-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2590, 'torcerse', '0', 'torcerse',
        '<div class="word--description">             <p class="word--description">v. wistuna; dislocarse: kiwina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2591, 'torcido', '0', 'torcido',
        '<div class="word--description">             <p class="word--description">adj. wistu, winku. torpe, adj. muspa, upa. tortero para hilar, s. piruru. tórtola, s. urpi, tukurpilla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2592, 'tortuga', '0', 'tortuga',
        '<div class="word--description">             <p class="word--description">s. acuatica: charapa; terrestre, s.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2593, 'mutilun', '0', 'mutilun',
        '<div class="word--description">             <p class="word--description">tsawata; anfibio: yawati.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2594, 'tos', '0', 'tos',
        '<div class="word--description">             <p class="word--description">s. uhu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2595, 'tosco', '0', 'tosco',
        '<div class="word--description">             <p class="word--description">adj. paza, sakra, tsaka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2596, 'toser', '0', 'toser',
        '<div class="word--description">             <p class="word--description">v. uhuna. tostado, s. kamcha. tostar, v. kamchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2597, 'totalidad', '0', 'totalidad',
        '<div class="word--description">             <p class="word--description">adv. tukuylla, llampu. trabajador, s. llamkak. trabajar, v. rurana, llamkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2598, 'trabajo', '0', 'trabajo',
        '<div class="word--description">             <p class="word--description">s. llamkay, ruray; comunal, colec-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2599, 'tivo: minka; familiar: ayniiy; trabajo recíproco: makipura', '0',
        'tivo: minka; familiar: ayniiy; trabajo recíproco: makipura',
        '<div class="word--description">             <p class="word--description">rantimpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2600, 'traducir', '0', 'traducir',
        '<div class="word--description">             <p class="word--description">v. tikrachina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2601, 'traer', '0', 'traer',
        '<div class="word--description">             <p class="word--description">v. apamuna, pushamuna; traer algo en la boca: amullimuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2602, 'tragar', '0', 'tragar',
        '<div class="word--description">             <p class="word--description">v. millpuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2603, 'trampa', '0', 'trampa',
        '<div class="word--description">             <p class="word--description">s. tuklla, hapina, panwa, tikta. tranquilizar, v. kasiyachina. tranquilo, adj. kasilla. transformación, s. pachakuti. transformarse, v. tukuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2604, 'transmitir la enfermedad zalipa', '0', 'transmitir la enfermedad zalipa',
        '<div class="word--description">             <p class="word--description">s.</p>          </div>', 'ACTIVE', 2,
        '-'),
       (2605, 'transparente', '0', 'transparente',
        '<div class="word--description">             <p class="word--description">adj. chuya, chuyalla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2606, 'transpirar', '0', 'transpirar',
        '<div class="word--description">             <p class="word--description">v. humpina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2607, 'traspasado maniana', '0', 'traspasado maniana',
        '<div class="word--description">             <p class="word--description">adv. kaya mincha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2608, 'trasquilar', '0', 'trasquilar',
        '<div class="word--description">             <p class="word--description">v. rutuna. travieso, adj. sayti, shillinkuk. treinta, num. kimsa chunka. tren, s. <**antatatis, antakuru. trenza, s. (<*simpa); chimpa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2609, 'trenzar', '0', 'trenzar',
        '<div class="word--description">             <p class="word--description">v. (<*simpay); chimpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2610, 'tres cientos', '0', 'tres cientos',
        '<div class="word--description">             <p class="word--description">num. kimsa pachak, kimsa patsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2611, 'tres mil', '0', 'tres mil',
        '<div class="word--description">             <p class="word--description">num. kimsa waranka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2612, 'tres', '0', 'tres',
        '<div class="word--description">             <p class="word--description">num. kimsa. trigo, s. triku, wania. tripa(s), s. chunchulli.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2613, 'triste', '0', 'triste',
        '<div class="word--description">             <p class="word--description">adj. kuyaylla, llakilla. triturado, adj. chamka, chamkashka. triturar, v. chamkana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2614, 'troje', '0', 'troje',
        '<div class="word--description">             <p class="word--description">s. (<*taqi), taki. trompa, s. sinka. trompetero, ave, s. yakami. trompo, s. piruru, kushpi. tronco, s. kullu, pulla, putu. tropezar, v. niitkana. tropezarse, v. niitkarina. trotar, v. kallpana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2615, 'trozar', '0', 'trozar',
        '<div class="word--description">             <p class="word--description">v. llakana, kiwina. trueno, onom. kulun, tulun. tu, pron. kan.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2616, 'tuberculo', '0', 'tuberculo',
        '<div class="word--description">             <p class="word--description">s. <**allpapimuruk; tipo de tu-</p>          </div>',
        'ACTIVE', 2, '-'),
       (2617, 'berculo: papa', '0', 'berculo: papa',
        '<div class="word--description">             <p class="word--description">rakacha, apichu, iwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2618, 'tubo', '0', 'tubo',
        '<div class="word--description">             <p class="word--description">s. tutu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2619, 'tucan', '0', 'tucan',
        '<div class="word--description">             <p class="word--description">s. kawpi, tumpiki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2620, 'tullido', '0', 'tullido',
        '<div class="word--description">             <p class="word--description">adj. suchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2621, 'tumba', '0', 'tumba',
        '<div class="word--description">             <p class="word--description">s.- aya-utku; antigua: waka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2622, 'tumor', '0', 'tumor',
        '<div class="word--description">             <p class="word--description">s. chupu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2623, 'tumulto', '0', 'tumulto',
        '<div class="word--description">             <p class="word--description">s. wayka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2624, 'tunica', '0', 'tunica',
        '<div class="word--description">             <p class="word--description">especie de, s. kushma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2625, 'tupido', '0', 'tupido',
        '<div class="word--description">             <p class="word--description">adj. kichki.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2626, 'turbio', '0', 'turbio',
        '<div class="word--description">             <p class="word--description">adj. lanta, sanku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2627, 'tusa', '0', 'tusa',
        '<div class="word--description">             <p class="word--description">s. kurunta; sin choclo: wakuyashka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2628, 'tutuma', '0', 'tutuma',
        '<div class="word--description">             <p class="word--description">s. puru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2629, 'ubicar', '0', 'ubicar',
        '<div class="word--description">             <p class="word--description">v. churana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2630, 'ubre', '0', 'ubre',
        '<div class="word--description">             <p class="word--description">s. chuchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2631, 'ultimo', '0', 'ultimo',
        '<div class="word--description">             <p class="word--description">adv. puchukay, chupa; kunchu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2632, 'un(o)', '0', 'un(o)',
        '<div class="word--description">             <p class="word--description">num. shuk. untar, v. hawina, kakuna. unia, s. sillu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2633, 'unico', '0', 'unico',
        '<div class="word--description">             <p class="word--description">adj. sapan, sapalla, shuklla; unica hija:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2634, 'murushka ushushi; unico hijo', '0', 'murushka ushushi; unico hijo',
        '<div class="word--description">             <p class="word--description">murushka churi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2635, 'unidad(es)', '0', 'unidad(es)',
        '<div class="word--description">             <p class="word--description">s. shuk(kuna) unión, s. tantachiy, tinkiy, tinkuy. unir, v. tinkina, tinkuna, llutana. universidad, s. hamutaywasi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2636, 'urano', '0', 'urano',
        '<div class="word--description">             <p class="word--description">planeta, s. <**tinkullpa. urdir, v. awllina, allwina. usado, adj. mawka, paya. usted, pron. kan, kikin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2637, 'ustedes', '0', 'ustedes',
        '<div class="word--description">             <p class="word--description">pron. kankuna, kikinkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2638, 'utero', '0', 'utero',
        '<div class="word--description">             <p class="word--description">s. wawatiyana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2639, 'vacío', '0', 'vacío',
        '<div class="word--description">             <p class="word--description">adj. chushak, illak. vagina, s. rakakara, raka. vagabundo, adj. yanka purik. vago, adj. (<*qilla), killa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2640, 'ver', '0', 'ver',
        '<div class="word--description">             <p class="word--description">v. rikuna, kawana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2641, 'verano', '0', 'verano',
        '<div class="word--description">             <p class="word--description">s. intipacha, usyay pacha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2642, 'verbo', '0', 'verbo',
        '<div class="word--description">             <p class="word--description">s. willak; verbo auxiliar para expresar onomatopeyas: nina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2643, 'vainas trilladas', '0', 'vainas trilladas',
        '<div class="word--description">             <p class="word--description">como tamo, s. puchul,</p>          </div>',
        'ACTIVE', 2, '-'),
       (2644, 'valeroso', '0', 'valeroso',
        '<div class="word--description">             <p class="word--description">adj. sinchi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2645, 'valle', '0', 'valle',
        '<div class="word--description">             <p class="word--description">s. pampa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2646, 'valor en precio', '0', 'valor en precio',
        '<div class="word--description">             <p class="word--description">s. chanin.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2647, 'vamonos', '0', 'vamonos',
        '<div class="word--description">             <p class="word--description">exp. hakupashun, hakupashun- chik.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2648, 'vamos', '0', 'vamos',
        '<div class="word--description">             <p class="word--description">exp. haku, hakuchik. vapor, s. <*wapsi. variedad, comp. sami. varón, adj. kari.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2649, 'vasija de barro (variedades)', '0', 'vasija de barro (variedades)',
        '<div class="word--description">             <p class="word--description">s.: puntu; de</p>          </div>',
        'ACTIVE', 2, '-'),
       (2650, 'vaso', '0', 'vaso',
        '<div class="word--description">             <p class="word--description">s. (<*qiru), kiru; redondo de madera</p>          </div>',
        'ACTIVE', 2, '-'),
       (2651, 'de cuello largo: kaka. vecino', '0', 'de cuello largo: kaka. vecino',
        '<div class="word--description">             <p class="word--description">adj. wasi mashi. vegetal, s. yura.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2652, 'vehículo', '0', 'vehículo',
        '<div class="word--description">             <p class="word--description">s. antawa, anta-shuntu, antawiwa.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2653, 'veinte', '0', 'veinte',
        '<div class="word--description">             <p class="word--description">num. ishkay chunka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2654, 'vejiga', '0', 'vejiga',
        '<div class="word--description">             <p class="word--description">s. ishpapuru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2655, 'vello', '0', 'vello',
        '<div class="word--description">             <p class="word--description">s. millma; vello axilar: kashuk millma; vello pubiano masculino: ullu millma; vello pubiano femenino: raka millma.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2656, 'velludo', '0', 'velludo',
        '<div class="word--description">             <p class="word--description">adj. millmasapa. veloz, adj. pankalla, wayralla. vena, s. anku, sirka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2657, 'venado', '0', 'venado',
        '<div class="word--description">             <p class="word--description">s. taruka, ushpitu, yamala.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2658, 'vencer', '0', 'vencer',
        '<div class="word--description">             <p class="word--description">v. atina. vendaje, s. yapa. vender, v. katuna. veneno, s. miyu, hampi. venerar, v. muchana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2659, 'venidero', '0', 'venidero',
        '<div class="word--description">             <p class="word--description">el o lo que vendra, adv. shamuk.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2660, 'venir', '0', 'venir',
        '<div class="word--description">             <p class="word--description">v. shamuna. ventana, s. (<*tuqu), tuku. ventura, s. kushi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2661, 'venus', '0', 'venus',
        '<div class="word--description">             <p class="word--description">planeta, s. <*chaska.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2662, 'verdad', '0', 'verdad',
        '<div class="word--description">             <p class="word--description">adv. (<*chiqa), chika. verdadero, adj. chiqallatak; kikin. verde, color, adj. (<*qumir), kumir, waylla.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2663, 'verduras', '0', 'verduras',
        '<div class="word--description">             <p class="word--description">s. yuyu; verduras sancochadas:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2664, 'vergüenza', '0', 'vergüenza',
        '<div class="word--description">             <p class="word--description">s. pinkay.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2665, 'verruga', '0', 'verruga',
        '<div class="word--description">             <p class="word--description">s. micha, mitsa, michamuyu, chimpi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2666, 'verter', '0', 'verter',
        '<div class="word--description">             <p class="word--description">v. tallina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2667, 'vertical', '0', 'vertical',
        '<div class="word--description">             <p class="word--description">adj. shayak, tsan. vertiente, s. pukyu. vestimenta, s. <* pacha; churana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2668, 'vestirse', '0', 'vestirse',
        '<div class="word--description">             <p class="word--description">v. <*pachallikuy; churarina.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2669, 'vía', '0', 'vía',
        '<div class="word--description">             <p class="word--description">s. nian.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2670, 'vía lactea', '0', 'vía lactea',
        '<div class="word--description">             <p class="word--description">s. <* mayu; kasa-anku, kasa nian.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2671, 'viajar', '0', 'viajar',
        '<div class="word--description">             <p class="word--description">v. rina, illana. vicunia, s. wikunia. vida, s. kawsay. vidrio, s. kispi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2672, 'vieja (animados)', '0', 'vieja (animados)',
        '<div class="word--description">             <p class="word--description">adj. paya, atupa; ruku;</p>          </div>',
        'ACTIVE', 2, '-'),
       (2673, 'viejo (animado', '0', 'viejo (animado',
        '<div class="word--description">             <p class="word--description">no animado), adj. ruku; para objetos: mawka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2674, 'viento', '0', 'viento',
        '<div class="word--description">             <p class="word--description">s. wayra; fuerte: akapana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2675, 'vientre', '0', 'vientre',
        '<div class="word--description">             <p class="word--description">s. wiksa. viernes, s. <**haycha. viga, s. (<*qiru), kiru.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2676, 'vigilante', '0', 'vigilante',
        '<div class="word--description">             <p class="word--description">s. chapak; vigilante de la casa:</p>          </div>',
        'ACTIVE', 2, '-'),
       (2677, 'wasikamak. viniente', '0', 'wasikamak. viniente',
        '<div class="word--description">             <p class="word--description">s. shamuk. violar, v. wakllichina. virar, v. tikrana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2678, 'viruela', '0', 'viruela',
        '<div class="word--description">             <p class="word--description">s. muru-unkuy. viruta, adj. punzu. viscoso, adj. llawsa. vista, s. niawi.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2679, 'viuda', '0', 'viuda',
        '<div class="word--description">             <p class="word--description">-o, adj. (<*ikma), wakcha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2680, 'vivienda', '0', 'vivienda',
        '<div class="word--description">             <p class="word--description">s. wasi; sin paredes, cubierta de</p>          </div>',
        'ACTIVE', 2, '-'),
       (2681, 'viviente', '0', 'viviente',
        '<div class="word--description">             <p class="word--description">s. kawsak.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2682, 'vivir', '0', 'vivir',
        '<div class="word--description">             <p class="word--description">v. kawsana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2683, 'volar', '0', 'volar',
        '<div class="word--description">             <p class="word--description">v. pawana, wampuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2684, 'volcan', '0', 'volcan',
        '<div class="word--description">             <p class="word--description">s. urku; en erupción: nina urku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2685, 'voltear', '0', 'voltear',
        '<div class="word--description">             <p class="word--description">v. tikrana, sinkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2686, 'volver', '0', 'volver',
        '<div class="word--description">             <p class="word--description">v. kutimuna, tikramuna, tikrana. volverse en, transformarse, v. tukuna. vomitar, v. <*kipnay; kuynana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2687, 'vulva', '0', 'vulva',
        '<div class="word--description">             <p class="word--description">s. raka</p>          </div>',
        'ACTIVE', 2, '-'),
       (2688, 'ya', '0', 'ya',
        '<div class="word--description">             <p class="word--description">adv. nia; ya mismo: nialla.	yeso, s. isku.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2689, 'yerba en general', '0', 'yerba en general',
        '<div class="word--description">             <p class="word--description">s. kiwa; para teniir: panti; yerbas comestibles: yuyu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2690, 'yerno', '0', 'yerno',
        '<div class="word--description">             <p class="word--description">s. masha.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2691, 'yo', '0', 'yo',
        '<div class="word--description">             <p class="word--description">pron. niuka.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2692, 'yuca', '0', 'yuca',
        '<div class="word--description">             <p class="word--description">s. lumu.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2693, 'zapallo', '0', 'zapallo',
        '<div class="word--description">             <p class="word--description">s. sapallu, kitu. zapato, s. ushuta. zarcillos, s. rinriwarkuna.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2694, 'zig-zag', '0', 'zig-zag',
        '<div class="word--description">             <p class="word--description">adj. kinku; ir en zig-zag: kinkuy.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2695, 'zonzo', '0', 'zonzo',
        '<div class="word--description">             <p class="word--description">adj. muspa, upa</p>          </div>',
        'ACTIVE', 2, '-'),
       (2696, 'zorrillo', '0', 'zorrillo',
        '<div class="word--description">             <p class="word--description">s. anias.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2697, 'zumo', '0', 'zumo',
        '<div class="word--description">             <p class="word--description">s. hilli; zumo del floripondio: warwar.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2698, 'zurcir', '0', 'zurcir',
        '<div class="word--description">             <p class="word--description">v. sirana, chupana.</p>          </div>',
        'ACTIVE', 2, '-'),
       (2699, 'zurdo', '0', 'zurdo',
        '<div class="word--description">             <p class="word--description">-a, adj. lluki, ichuk.</p>          </div>',
        'ACTIVE', 2, '-');



INSERT INTO `dictionary_words_by_audio` (`id`, `value`, `description`, `status`, `dictionary_by_words_id`, `source`)
VALUES (1, 'achachaw', 'achachaw', 'ACTIVE', 9, '/uploads/dictionary/words-by-audio/achachaw-01.mp3'),
       (2, 'achachaw', 'achachaw', 'ACTIVE', 9, '/uploads/dictionary/words-by-audio/achachaw-02.mp3');
INSERT INTO `dictionary_words_by_photo` (`id`, `value`, `description`, `status`, `dictionary_by_words_id`, `source`)
VALUES (1, 'achachaw', 'achachaw', 'ACTIVE', 9, '/uploads/dictionary/words-by-photos/achachaw-01.png'),
       (2, 'achachaw', 'achachaw', 'ACTIVE', 9, '/uploads/dictionary/words-by-photos/achachaw-02.jpeg'),
       (3, 'achik', 'achik', 'ACTIVE', 964, '/uploads/dictionary/words-by-photos/achik-01.png'),
       (4, 'achikmama', 'achikmama', 'ACTIVE', 11, '/uploads/dictionary/words-by-photos/achikmama-01.png'),
       (5, 'ña', 'ña', 'ACTIVE', 538, '/uploads/dictionary/words-by-photos/ña-01.jpg'),
       (6, 'ñaña', 'ñaña', 'ACTIVE', 542, '/uploads/dictionary/words-by-photos/ñaña-01.png');

INSERT INTO `language_course` (`id`, `value`, `description`, `status`, `dictionary_language_id`)
VALUES (1, 'KICHWA NIVEL INICIAL', 'KICHWA NIVEL INICIAL', 'ACTIVE', 1);

INSERT INTO `language_course_by_section` (`id`, `value`, `description`, `status`, `language_course_id`, `type`,
                                          `source`)
VALUES (1, 'HUNKAYPA PUNCHAKUNA - DÍAS DE LA SEMANA', 'HUNKAYPA PUNCHAKUNA - DÍAS DE LA SEMANA.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/1/1.jpg'),
       (2, 'TULLPUKUNA-LOS COLORES', 'TULLPUKUNA-LOS COLORES\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/2/2.jpg'),
       (3, 'YUPAYKUNA-LOS NÚMEROS', 'YUPAYKUNA-LOS NÚMEROS.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/3/3.jpg'),
       (4, 'KICHWA KILLAN LLIKA-ALFABETO', 'KICHWA KILLAN LLIKA-ALFABETO\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/4/4.jpg'),
       (5, 'MISHKIMURUKUNA-FRUTAS', 'MISHKIMURUKUNA-FRUTAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/5/5.jpg'),
       (6, 'CHUYAYANKAPA HILLAYKUNA-IMPLEMENTOS DE ASEO', 'CHUYAYANKAPA HILLAYKUNA-IMPLEMENTOS DE ASEO\r.', 'ACTIVE', 1,
        0, '/uploads/Riksichishun/level-initial/6/6.jpg'),
       (7, 'YACHANAWAKUPA HILLAYKUNA-IMPLEMENTOS DEL AULA', 'YACHANAWAKUPA HILLAYKUNA-IMPLEMENTOS DEL AULA\r.',
        'ACTIVE', 1, 0, '/uploads/Riksichishun/level-initial/7/7.jpg'),
       (8, 'SHUTI RANTIKUNA-PRONOMBRES PERSONALES', 'SHUTI RANTIKUNA-PRONOMBRES PERSONALES\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/8/8.jpg'),
       (9, 'SHUYUTUPUMANYA-FIGURAS GEOMÉTRICAS', 'SHUYUTUPUMANYA-FIGURAS GEOMÉTRICAS.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/9/9.jpg'),
       (10, 'YUPAY UNANCHAKUNA-SÍMBOLOS MATEMÁTICOS', 'YUPAY UNANCHAKUNA-SÍMBOLOS MATEMÁTICOS.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/10/10.jpg'),
       (11, 'SACHA WIWAKUNA-ANIMALES SALVAJES', 'SACHA WIWAKUNA-ANIMALES SALVAJES\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/11/11.jpg'),
       (12, 'RUNAPA UKKU SHUTIKUNA -CUERPO HUMANO', 'RUNAPA UKKU SHUTIKUNA -CUERPO HUMANO\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/12/12.jpg'),
       (13, 'RUNAPA UKKU SHUTIKUNA-CUERPO HUMANO', 'RUNAPA UKKU SHUTIKUNA-CUERPO HUMANO\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/13/13.jpg'),
       (14, 'RUNA UKKUPA TULLUKUNA -HUESOS DEL CUERPO HUMANO', 'RUNA UKKUPA TULLUKUNA -HUESOS DEL CUERPO HUMANO\r.',
        'ACTIVE', 1, 0, '/uploads/Riksichishun/level-initial/14/14.jpg'),
       (15, 'APARIYKANCHA- MEDIOS DE TRANSPORTE', 'APARIYKANCHA- MEDIOS DE TRANSPORTE\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/15/15.jpg'),
       (16, 'UYAYWAKUNA - LAS VOCALES', 'UYAYWAKUNA - LAS VOCALES\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/16/16.jpg'),
       (17, 'ECUADOR MAMALLAKTAPA HAYLLI-HIMNO NACIONAL DEL ECUADOR',
        'ECUADOR MAMALLAKTAPA HAYLLI-HIMNO NACIONAL DEL ECUADOR\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/17/17.jpg'),
       (18, 'CHAYLLATKSHIMI, CHIMPANAKUY YUYAY - SINÓNIMOS Y ANTÓNIMOS',
        'CHAYLLATKSHIMI, CHIMPANAKUY YUYAY - SINÓNIMOS Y ANTÓNIMOS\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/18/18.jpg'),
       (19, 'CHAYLLATAKSHIMI, CHIMPANAKUY YUYAY-SINÓNIMOS Y ANTÓNIMOS',
        'CHAYLLATAKSHIMI, CHIMPANAKUY YUYAY -  SINÓNIMOS Y ANTÓNIMOS\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/19/19.jpg'),
       (20, 'IMACHIKKUNA -VERBOS', 'IMACHIKKUNA -VERBOS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/20/20.jpg'),
       (21, 'RUNAWAN KAWSAYK WIWAKUNA - ANIMALES DOMÉSTICOS\n.', 'RUNAWAN KAWSAYK WIWAKUNA - ANIMALES DOMÉSTICOS\n.',
        'ACTIVE', 1, 0, '/uploads/Riksichishun/level-initial/21/21.jpg'),
       (22, 'WATAPA KILLAKUNA - MESES DEL AÑO', 'WATAPA KILLAKUNA - MESES DEL AÑO\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/22/22.jpg'),
       (23, 'MIKUNA YUYUKUNA - HORTALIZAS', 'MIKUNA YUYUKUNA - HORTALIZAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/23/23.jpg'),
       (24, 'MIKUNA YUYUKUNA - HORTALIZAS', 'MIKUNA YUYUKUNA - HORTALIZAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/24/24.jpg'),
       (25, 'AYLLUKUNA - LA FAMILIA', 'AYLLUKUNA - LA FAMILIA\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/25/25.jpg'),
       (26, 'CHAKANAPA YACHAY - CONOCIMIENTOS DE LA CRUZ ANDINA',
        'CHAKANAPA YACHAY - CONOCIMIENTOS DE LA CRUZ ANDINA\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/26/26.jpg'),
       (27, 'RIKSIRISHUN - PRESENTACIÓN\n.', 'RIKSIRISHUN - PRESENTACIÓN\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/27/27.jpg'),
       (28, 'IMASHINAKAY - EMOCIONES', 'IMASHINAKAY - EMOCIONES\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/28/28.jpg'),
       (29, 'PUÑUNAWKU-DORMITORIO', 'PUÑUNAWKU-DORMITORIO\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/29/29.jpg'),
       (30, 'TAPUYKUNA - PREGUNTAS', 'TAPUYKUNA - PREGUNTAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/30/30.jpg'),
       (31, 'TAPUYKUNA - PREGUNTAS', 'TAPUYKUNA - PREGUNTAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/31/31.jpg'),
       (32, 'GRAMATICA KICHWA - KICHWA SHIMI KAMACHIKKUNA', 'GRAMATICA KICHWA - KICHWA SHIMI KAMACHIKKUNA\r.', 'ACTIVE',
        1, 0, '/uploads/Riksichishun/level-initial/32/32.jpg'),
       (33, 'YUPAYPA UNACHAKUNA - SÍMBOLOS MATEMÁTICOS', 'YUPAYPA UNACHAKUNA - SÍMBOLOS MATEMÁTICOS.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/33/33.jpg'),
       (34, 'NAPAYKUNA - SALUDOS', 'NAPAYKUNA - SALUDOS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/34/34.jpg'),
       (35, 'HUNINAKUYKUNA - CONJUGACIÓN EN TIEMPOS', 'HUNINAKUYKUNA - CONJUGACIÓN EN TIEMPOS\n.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/35/35.jpg'),
       (36, 'UPYANAKUNA - BEBIDAS', 'UPYANAKUNA - BEBIDAS\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/36/36.jpg'),
       (37, 'CHURAKUNAKUNA -VESTIMENTA', 'CHURAKUNAKUNA -VESTIMENTA\r.', 'ACTIVE', 1, 0,
        '/uploads/Riksichishun/level-initial/37/37.jpg');


SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
