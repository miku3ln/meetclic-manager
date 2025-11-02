<?php

namespace App\Models\Dictionary;

use App\Models\ModelManager;

use Illuminate\Support\Facades\DB;

class DictionaryByWords extends ModelManager
{


    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dictionary_by_words';
    protected $modelNameEntity = 'DictionaryByWords';

    protected $fillable = array('name', "description", 'status', 'diccionary_language_id', 'letters_of_the_alphabet');

    public $timestamps = true;

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required",
            "status" => "required",
            "diccionary_language_id" => "required|numeric",
            "letters_of_the_alphabet" => "required"

        ];
        return $rules;
    }

    public function getDictionaryData($params)
    {
        $resultData = $this->getDictionaryAdmin($params);
        $data = $resultData['rows'];
        $result = [];

        foreach ($resultData['rows'] as $item => $value) {
            $idMaster = $value->id;
            $setPush = $value;

            $photosCurrent = $this->getDataPhoto(['dictionary_by_words_id' => $idMaster]);
            if (count($photosCurrent) > 0) {
                $setPush->photos = $photosCurrent;

            }


            $audiosCurrent = $this->getDataAudio(['dictionary_by_words_id' => $idMaster]);
            if (count($audiosCurrent) > 0) {
                $setPush->audios = $audiosCurrent;

            }

            $pronunciationsCurrent=$this->getDataPronunciation(['dictionary_by_words_id' => $idMaster]);
            if (count($pronunciationsCurrent) > 0) {
                $setPush->pronunciations = $pronunciationsCurrent;

            }
            $examplesCurrent=$this->getDataExample(['dictionary_by_words_id' => $idMaster]);
            if (count($examplesCurrent) > 0) {
                $setPush->examples = $examplesCurrent;

            }
            $resultData['rows'][$item] = $setPush;
        }
        return $resultData;
    }

    public function getDictionaryAdmin($params)
    {
        $sort = 'asc';
        $field = 'value';
        $query = DB::table($this->table);
        $entity_manager_id = isset($params['filters']['entity_manager_id']) ? $params['filters']['entity_manager_id'] : null;

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.translation_value,$this->table.usage_context,$this->table.value,$this->table.description,$this->table.status,$this->table.diccionary_language_id,$this->table.letters_of_the_alphabet
        ,dictionary_word_by_class.dictionary_grammatical_class_id
        ,dictionary_grammatical_class.name dictionary_grammatical_class_name ";




        $query->where(
            $this->table . '.diccionary_language_id', '=', $entity_manager_id
        );
        $query->where(
            $this->table . '.status', '=', 'ACTIVE'
        );
        if ($params['searchPhrase'] != null && $params['searchPhrase'] != '') {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');

            });

        }
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('dictionary_language', 'dictionary_language.id', '=', $this->table . '.diccionary_language_id');
        $query->join('dictionary_word_by_class', 'dictionary_word_by_class.dictionary_by_words_id', '=', $this->table . '.id');
        $query->join('dictionary_grammatical_class', 'dictionary_word_by_class.dictionary_grammatical_class_id', '=',  'dictionary_grammatical_class.id');


        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }
    public function getDataExample($params)
    {
        $sort = 'asc';
        $field = 'id';
        $tableCurrent = 'dictionary_words_by_examples';
        $query = DB::table($tableCurrent);
        $entity_manager_id = $params['dictionary_by_words_id'];


        $selectString = "$tableCurrent.id,$tableCurrent.value,$tableCurrent.description,$tableCurrent.status,$tableCurrent.dictionary_by_words_id";

        $query->where(
            $tableCurrent . '.dictionary_by_words_id', '=', $entity_manager_id
        );
        $query->where(
            $tableCurrent . '.status', '=', 'ACTIVE'
        );

        $select = DB::raw($selectString);
        $query->select($select);


// sort
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }

    public function getDataPronunciation($params)
    {
        $sort = 'asc';
        $field = 'id';
        $tableCurrent = 'dictionary_words_by_pronunciation';
        $query = DB::table($tableCurrent);
        $entity_manager_id = $params['dictionary_by_words_id'];


        $selectString = "$tableCurrent.id,$tableCurrent.phonetic_value,$tableCurrent.notation_type,$tableCurrent.status,$tableCurrent.dictionary_by_words_id";

        $query->where(
            $tableCurrent . '.dictionary_by_words_id', '=', $entity_manager_id
        );
        $query->where(
            $tableCurrent . '.status', '=', 'ACTIVE'
        );

        $select = DB::raw($selectString);
        $query->select($select);


// sort
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }
    public function getDataPhoto($params)
    {
        $sort = 'asc';
        $field = 'id';
        $tableCurrent = 'dictionary_words_by_photo';
        $query = DB::table($tableCurrent);
        $entity_manager_id = $params['dictionary_by_words_id'];


        $selectString = "$tableCurrent.id,$tableCurrent.value,$tableCurrent.description,$tableCurrent.status,$tableCurrent.dictionary_by_words_id,$tableCurrent.source";

        $query->where(
            $tableCurrent . '.dictionary_by_words_id', '=', $entity_manager_id
        );
        $query->where(
            $tableCurrent . '.status', '=', 'ACTIVE'
        );

        $select = DB::raw($selectString);
        $query->select($select);


// sort
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }
    public function getDataAudio($params)
    {
        $sort = 'asc';
        $field = 'id';
        $tableCurrent = 'dictionary_words_by_audio';
        $query = DB::table($tableCurrent);
        $entity_manager_id = $params['dictionary_by_words_id'];


        $selectString = "$tableCurrent.id,$tableCurrent.value,$tableCurrent.description,$tableCurrent.status,$tableCurrent.dictionary_by_words_id,$tableCurrent.source";

        $query->where(
            $tableCurrent . '.dictionary_by_words_id', '=', $entity_manager_id
        );
        $query->where(
            $tableCurrent . '.status', '=', 'ACTIVE'
        );

        $select = DB::raw($selectString);
        $query->select($select);


// sort
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }
    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'value';
        $query = DB::table($this->table);
        $entity_manager_id = isset($params['filters']['entity_manager_id']) ? $params['filters']['entity_manager_id'] : null;

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,$this->table.diccionary_language_id,$this->table.letters_of_the_alphabet";

        $query->where(
            $this->table . '.diccionary_language_id', '=', $entity_manager_id
        );
        if ($params['searchPhrase'] != null && $params['searchPhrase'] != '') {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });

        }
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('dictionary_language', 'dictionary_language.id', '=', $this->table . '.diccionary_language_id');


        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = null;
        DB::beginTransaction();
        try {
            $modelName = $this->modelNameEntity;
            $model = new DictionaryByWords();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = DictionaryByWords::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $modelData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $modelData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if (!$createUpdate) {


                }
                $model->fill($attributesSet);
                $success = $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar  DictionaryLanguage.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $data = $model;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,

                "success" => $success
            ];

            return ($result);
        } catch (\Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public $abreviaturas = array(
        // Topónimos
        "in- terj" => 'Other',
        "in-terj" => 'Other 2',
        "amz." => "Amazonía",
        "az." => "Azuay",
        "bo." => "Bolívar",
        "Bol." => "Bolivia",
        "ca." => "Cañar",
        "chi." => "Chimborazo",
        "co." => "Cotopaxi",
        "gua." => "Guayas",
        "im." => "Imbabura",
        "lo." => "Loja",
        "na." => "Napo",
        "or." => "El Oro",
        "ore." => "Orellana",
        "pa." => "Pastaza",
        "Pe." => "Perú",
        "pi." => "Pichincha",
        "S." => "Sierra",
        "sc." => "Sierra centro (Cotopaxi, Tungurahua, Chimborazo, Bolívar)",
        "sn." => "Sierra norte (Pichincha, Imbabura)",
        "ss." => "Sierra sur (Cañar, Azuay, Loja)",
        "suc." => "Sucumbíos",
        "tu." => "Tungurahua",
        "za." => "Zamora",
        // Gramaticales
        "adj." => "adjetivo",
        "adv." => "adverbio",
        "C." => "complemento",
        "C." => "consonante",
        "cant." => "cantidad",
        "CC." => "complemento circunstancial",
        "CD." => "complemento directo",
        "CI." => "complemento Indirecto",
        "con." => "conector",
        "CV." => "consonante y vocal",
        "CVC." => "Consonante- vocal-consonante",
        "dem." => "demostrativo",
        "det." => "determinante",
        "excl." => "exclamación",
        "gen." => "Genitivo",
        "indef." => "Indefinido",
        "Interj." => "Interjección",
        "int." => "Interrogativo",
        "N." => "núcleo",
        "num." => "numeral",
        "onom." => "onomatopeya",
        "ord." => "ordinal",
        "preg." => "pregunta",
        "pron." => "pronombre",
        "s." => "sustantivo",
        "S." => "sujeto",
        "SCV." => "sujeto, complemento y verbo",
        "sin." => "Sinónimo",
        "v." => "verbo",
        "var." => "variante",
        "V." => "vocal",
        "VC." => "Vocal-consonante",
        // Siglas
        "ALKI." => "Academia de la Lengua Kichwa (ver KAMAK)",
        "ANAZPPA." => "Asociación Nacional Zápara de la Provincia de Pastaza",
        "CEE." => "Conferencia Episcopal Ecuatoriana",
        "CIEI." => "Centro de Investigaciones Educativas Indígenas",
        "CNV-Q." => "Campamento Nueva Vida - Quito",
        "CONAIE." => "Confederación de Nacionalidades Indígenas del Ecuador",
        "CONPLADEIN." => "Consejo de Planificación y Desarrollo de los Pueblos Indígenas",
        "DINEIB." => "Dirección Nacional de Educación Intercultural Bilingüe",
        "DINSE." => "Dirección Nacional de Servicios Educativos",
        "DIPEIB." => "Dirección Provincial de Educación Intercultural Bilingüe",
        "EBI." => "Educación Bilingüe Intercultural",
        "EIB." => "Educación Intercultural Bilingüe",
        "ECUARUNARI." => "Ecuador runakunapak rikcharimuy",
        "EIBAMAZ." => "Educación Intercultural Bilingüe para la Amazonía",
        "FEINE." => "Federación de Evangélicos Indígenas del Ecuador.",
        "FENOCIN-E." => "Federación Nacional de Organizaciones Campesinas, Indígenas y Negras del Ecuador.",
        "GTZ." => "Agencia Técnica de Cooperación Alemana",
        "IEQ." => "Instituto de Estudios Qichwas",
        "ILL/PUCE." => "Instituto de Lenguas y Lingüística-PUCE",
        "ILV." => "Instituto Lingüístico de Verano",
        "INCC." => "Instituto Nacional de Capacitación Campesina",
        "KAMAK." => "Kichwa Amawta Kamachik (Academia de la lengua kichwa)",
        "LAEB-UC." => "Lingüística Andina y Educación Bilingüe/Universidad de Cuenca",
        "ME." => "Ministerio de Educación",
        "ONGs." => "Organizaciones no Gubernamentales",
        "PLEIB." => "Programa de Licenciatura en Educación Intercultural Bilingüe",
        "PRODEPINE." => "Proyecto de Desarrollo de los Pueblos Indígenas y Negros del Ecuador",
        "PUCE." => "Pontificia Universidad Católica del Ecuador",

        "SEPDI." => "Subsecretaría de Educación para el Diálogo Intercultural / ME",
        "SEIC." => "Sistema de Escuelas Indígenas de Cotopaxi",
        // Simbología lingüística
        "[ ]" => "indica representación fonética",
        "/ /" => "indica representación fonológica",
        "< >" => "indica representación ortográfica",
        "( )" => "indica formas opcionales",
        ">" => "indica que lo que precede da lugar a lo que sigue",
        "<" => "indica que lo que precede se deriva de",
        "*" => "el asterisco señala una forma etimológica o reconstruida",
        "**" => "los dos asteriscos señalan que la reconstrucción se basa en concepciones y datos históricos",
        "." => "el punto señala el límite silábico",
        "-" => "el guión señala límite fonemático de monemas ligados",
        "~" => "indica la entrada que se ubica en este lugar",
        "/č/" => "señala un fonema africado palatal",
        "/l" => "señala un fonema lateral palatal",
        "/" => "señala un fonema lateral palatal",
        "//" => "señala un fonema lateral palatal",
        "/š/" => "señala un fonema fricativo palatal sordo",
        "/ž/" => "señala un fonema fricativo palatal sonoro",
        "/ts/" => "señala un fonema africado dental sordo",
        "/R/" => "señala una vibrante múltiple",
        "/0/" => "señala ausencia de fonema o marca cero",
        "FN." => "señala una frase nominal",
        "FV." => "señala una frase verbal",
        "O." => "señala una oración.",
        "OC." => "señala una oración compleja.",
        "OS." => "señala una oración simple.",
        "Rv." => "indica raíz nominal.",
        "SN." => "señala un sintagma nominal.",
        "SV." => "señala un sintagma verbal.",
        "Tv." => "indica tema verbal."
    );

    public function setManagerScriptCastellano($params)
    {
        $success = true;
        $msj = "Realizado con Exito.!";
        $result = array();
        $errors = array();
        $data = null;
        DB::beginTransaction();
        try {

            $filePathText = 'CASTELLANO-KICHWA READY-TXT.txt';

            $filePath = storage_path('app/public/' . $filePathText);
            // Abre el archivo en modo lectura
            $file = fopen($filePath, 'r');
            if ($file) {
                // Lee el archivo línea por línea
                $allText = '';
                while (($line = fgets($file)) !== false) {
                    $allText .= $line;
                }

                // Cierra el archivo después de leer
                fclose($file);

                $resultWords = $this->extractWordsCastellano($allText, $this->abreviaturas);

                $data['resultWords'] = $resultWords;
                $resultSave = [];

                $sqlAll = "INSERT INTO `dictionary_by_words` (`id`, `value`, `dictionary_grammatical_class_id`, `grammatical_classification_value`,  `description`, `status`, `diccionary_language_id`, `letters_of_the_alphabet`)";
                $countAll = count($resultWords);
                $count = 0;
                $countId = 1037;
                $diccionary_language_id = 2;
                $letters_of_the_alphabet = '-';
                $grammatical_classification_type=0;
                $translation_value='';
                foreach ($resultWords as $key => $value) {

                    $status = 'ACTIVE';
                    $word = $value['palabra'];
                    $translation_value = $value['palabra'];

                    $description = '<div class="word--description">' .
                        '             <p class="word--description">' . $value['descripcion'] . '</p> '
                        . '         </div>';
                    if ($count == 0) {

                        $sqlAll .= 'VALUES';
                    }
                    $sqlAll .= '(' . $countId . ',' . "'" . $word . "'" .',' . "'" . $grammatical_classification_type . "'" . ',' . "'" . $translation_value . "'" . ',' . "'" . $description . "'" . ',' . "'" . $status . "'" . ',' . $diccionary_language_id . ',' . "'" . $letters_of_the_alphabet . "'" . ')';
                    if ($count < $countAll - 1) {
                        $sqlAll .= ',';
                    } else {
                        $sqlAll .= ';';

                    }
                    $count++;
                    $countId++;
                    array_push($resultSave, [
                        'value' => $word,
                        'description' => $description,
                        'status' => 'ACTIVE',
                        'diccionary_language_id' => $diccionary_language_id,
                        'letters_of_the_alphabet' => '-'

                    ]);
                }
// Genera un nombre único para el archivo
                $nombreArchivo = 'sql_language_castellano_' . time() . '.sql';
                // Ruta del archivo
                $rutaArchivo = storage_path('app/public/' . $nombreArchivo);
                // Intenta abrir o crear el archivo
                $archivo = fopen($rutaArchivo, 'w');
                if ($archivo) {
                    // Escribe el contenido en el archivo
                    fwrite($archivo, $sqlAll);
                    // Cierra el archivo después de escribir
                    fclose($archivo);
                    $data['sqlAll'] = $sqlAll;
                    $data['resultSave'] = $resultSave;


                } else {
                    $success = false;
                    // Maneja el caso en que no se pueda abrir el archivo
                    $msj = "No se pudo abrir el archivo para escribir.";
                }
            } else {
                $success = false;

                // Maneja el caso en que el archivo no se pueda abrir
                $msj = "No se pudo abrir el archivo.";
            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,
                "success" => $success
            ];


        } catch (\Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => false,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );

        }
        return ($result);
    }
    public function setTxtDataByTxt($params)
    {
        $success = true;
        $msj = "Realizado con Éxito.!";
        $result = [];
        $errors = [];
        $data = null;
        try {
            // 1) Rutas (por defecto según lo que pediste)
            $inputRel  = $params['input']  ?? 'kichwa/palabras.txt'; // storage/kichwa/palabras.txt
            $outputRel = $params['output'] ?? 'kichwa/palabras-transofrmadas.txt'; // storage/kichwa/palabras-transofrmadas.txt

            $inputPath  = storage_path($inputRel);   // => {project}/storage/kichwa/palabras.txt
            $outputPath = storage_path($outputRel);  // => {project}/storage/kichwa/palabras-transofrmadas.txt

            // 2) Validaciones
            if (!file_exists($inputPath)) {
                throw new \RuntimeException("No se encontró el archivo de entrada: {$inputPath}");
            }
            if (!is_readable($inputPath)) {
                throw new \RuntimeException("El archivo de entrada no es legible: {$inputPath}");
            }

            // 3) Leer todo el texto
            $allText = file_get_contents($inputPath);
            if ($allText === false) {
                throw new \RuntimeException("No se pudo leer el archivo: {$inputPath}");
            }

            // 4) Parsear entradas: word [fonemas] SIGLAS. definición...
            $entries = $this->parseKichwaEntries($allText);

            // 5) Armar líneas "word|fonemas|significado y sigglas"
            $lines = [];
            foreach ($entries as $e) {
                $word = $e['word'];
                $phon = $e['phon'];
                $sig  = $e['siglas'];
                $def  = $e['def'];

                $third = trim($sig . (strlen($sig) && strlen($def) ? ' ' : '') . $def);
                $lines[] = "{$word}|{$phon}|{$third}";
            }

            // 6) Crear carpeta destino si no existe
            $dir = dirname($outputPath);
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException("No se pudo crear el directorio de salida: {$dir}");
                }
            }

            // 7) Escribir salida
            $written = file_put_contents($outputPath, implode(PHP_EOL, $lines) . PHP_EOL);
            if ($written === false) {
                throw new \RuntimeException("No se pudo escribir el archivo de salida: {$outputPath}");
            }

            // 8) Datos de retorno
            $data = [
                'input'           => $inputPath,
                'output'          => $outputPath,
                'entries_found'   => count($entries),
                'lines_written'   => count($lines),
                'sample_first_3'  => array_slice($lines, 0, 3),
            ];

        } catch (\Throwable $e) {

            $success = false;
            $msj = $e->getMessage();
            $errors[] = $msj;
        }

        return [
            "success" => $success,
            "msj"     => $msj,
            "data"    => $data,
            "errors"  => $errors,
        ];
    }

    /**
     * Parseador del diccionario Kichwa.
     * Devuelve array de ['word' => ..., 'phon' => ..., 'siglas' => ..., 'def' => ...]
     */
    private function parseKichwaEntries(string $text): array
    {
        // Normalizar saltos
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Captura bloques: word [fonemas] ... (hasta próxima entrada o fin)
        $entryPattern = '/^(?P<word>[^\[\n]+?)\s*\[(?P<phon>[^\]]+)\]\s*(?P<tail>.*?)(?=^[^\[\n]+?\s*\[|\Z)/msu';
        preg_match_all($entryPattern, $text, $matches, PREG_SET_ORDER);

        $out = [];
        foreach ($matches as $m) {
            $word = trim(preg_replace('/\s+/', ' ', $m['word']));
            $phon = trim(preg_replace('/\s+/', ' ', $m['phon']));
            $tail = trim($m['tail']);
            $tailOneLine = trim(preg_replace('/\s+/', ' ', $tail));

            // Siglas comunes + marcas regionales (ajustable)
            $siglasPattern = '/^((?:amz|sc|snc|sn|ss|scs|ca|bo|j|s|adj|adv|v|interj|det|pron|prep|conj)\.(?:\s*,\s*|\s+))+/u';

            $siglas = '';
            $def    = $tailOneLine;

            if (preg_match($siglasPattern, $tailOneLine, $sm)) {
                $siglas = rtrim($sm[0], ', ');
                $def    = trim(substr($tailOneLine, strlen($sm[0])));
            }

            // Cortar "Sin. ..." para dejar significado principal (opcional)
            $def = preg_split('/\bSin\.\b/u', $def)[0] ?? $def;

            // Limpieza final
            $word = preg_replace('/\s+/', ' ', $word);
            $phon = preg_replace('/\s+/', ' ', $phon);
            $siglas = preg_replace('/\s+/', ' ', $siglas);
            $def = preg_replace('/\s+/', ' ', trim($def));

            $out[] = [
                'word'   => $word,
                'phon'   => $phon,
                'siglas' => $siglas,
                'def'    => $def,
            ];
        }
        return $out;
    }

    public function setManagerScript($params)
    {
        $success = true;
        $msj = "Realizado con Exito.!";
        $result = array();
        $errors = array();
        $data = null;
        DB::beginTransaction();
        try {

            $filePathText = 'dictionary-kichwa-castellano.txt';

            $filePath = storage_path('app/public/' . $filePathText);
            // Abre el archivo en modo lectura
            $file = fopen($filePath, 'r');
            if ($file) {
                // Lee el archivo línea por línea
                $allText = '';
                while (($line = fgets($file)) !== false) {
                    $allText .= $line;
                }

                // Cierra el archivo después de leer
                fclose($file);

                $resultWords = $this->extractWords($allText, $this->abreviaturas);
                $data['resultWords'] = $resultWords;
                $resultSave = [];

                $sqlAll = "INSERT INTO `dictionary_by_words` (`id`, `value`, `grammatical_classification_type`, `translation_value`,  `description`, `status`, `diccionary_language_id`, `letters_of_the_alphabet`)";
                $countAll = count($resultWords);
                $count = 0;
                $countId = 1;
                $diccionary_language_id = 1;
                $letters_of_the_alphabet = '-';
                $grammatical_classification_type=0;
                $translation_value='';

                foreach ($resultWords as $key => $value) {
                    $status = 'ACTIVE';
                    $word = $value['palabra'];
                    $translation_value = $value['palabra'];
                    $description = '<div class="word--description">' .
                        '             <span class="word--fonetic">' . '[' . $value['fonetica'] . ']' . '</span> ' .
                        '             <p class="word--description">' . $value['descripcion'] . '</p> '
                        . '         </div>';
                    if ($count == 0) {
                        $sqlAll .= 'VALUES';
                    }
                    $sqlAll .= '(' . $countId . ',' . "'" . $word . "'" .',' . "'" . $grammatical_classification_type . "'" . ',' . "'" . $translation_value . "'" . ',' . "'" . $description . "'" . ',' . "'" . $status . "'" . ',' . $diccionary_language_id . ',' . "'" . $letters_of_the_alphabet . "'" . ')';
                    if ($count < $countAll - 1) {
                        $sqlAll .= ',';
                    } else {
                        $sqlAll .= ';';

                    }
                    $count++;
                    $countId++;
                    array_push($resultSave, [
                        'value' => $word,
                        'description' => $description,
                        'status' => 'ACTIVE',
                        'diccionary_language_id' => 1,
                        'letters_of_the_alphabet' => '-'

                    ]);
                }
// Genera un nombre único para el archivo
                $nombreArchivo = 'sql_language_' . time() . '.sql';
                // Ruta del archivo
                $rutaArchivo = storage_path('app/public/' . $nombreArchivo);
                // Intenta abrir o crear el archivo
                $archivo = fopen($rutaArchivo, 'w');
                if ($archivo) {
                    // Escribe el contenido en el archivo
                    fwrite($archivo, $sqlAll);
                    // Cierra el archivo después de escribir
                    fclose($archivo);
                    $data['sqlAll'] = $sqlAll;
                    $data['resultSave'] = $resultSave;


                } else {
                    $success = false;
                    // Maneja el caso en que no se pueda abrir el archivo
                    $msj = "No se pudo abrir el archivo para escribir.";
                }
            } else {
                $success = false;

                // Maneja el caso en que el archivo no se pueda abrir
                $msj = "No se pudo abrir el archivo.";
            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,
                "success" => $success
            ];


        } catch (\Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => false,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );

        }
        return ($result);
    }

    function extractWords($texto, $abreviaturas)
    {
        $palabras = array();
        $regex = '/\b(\w+)\s+\[(.*?)\]\s+([^\[\]]+)\.?(\s+(.+))?/'; // Expresión regular

        preg_match_all($regex, $texto, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $palabra = $match[1];
            $fonetica = $match[2];
            $descripcion = trim($match[3]);
            $descripcionProp = preg_replace('/\b(\w+)\s+\[(.*?)\]\s+/', '', $descripcion); // Eliminar la parte inicial de la descripción
            $propiedades = array(); // Inicializar array de propiedades

            foreach ($abreviaturas as $abreviatura => $valor) {
                $propiedades[$abreviatura] = $this->searchProperties($abreviaturas, $descripcionProp);
            }

            $palabras[] = array(
                'palabra' => $palabra,
                'fonetica' => $fonetica,
                'descripcion' => $descripcion,
                'propiedades' => $propiedades
            );
        }

        return $palabras;
    }

    function extractWordsCastellano($texto, $abreviaturas)
    {
        $palabras = array();
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            // Separar la línea en palabra y descripción usando la coma como separador
            $partes = explode(",", $linea);

            // Si la línea tiene más de una coma, tomar la primera parte como la palabra
            // y el resto como la descripción
            if (count($partes) > 1) {
                $palabra = trim($partes[0]);
                $descripcion = trim(implode(",", array_slice($partes, 1)));

                // Almacenar la palabra y su descripción en el arreglo asociativo

                array_push($palabras, [
                    'palabra' => $palabra,
                    'descripcion' => $descripcion,

                ]);
            }
            // Si la línea tiene solo una parte (sin coma), significa que es un salto de línea adicional
            // en cuyo caso, simplemente ignoramos esa línea
        }

        return $palabras;
    }

    function searchProperties($abreviaturas, $descripcion)
    {

        $propiedades = array(); // Inicialización del array de propiedades
        // Bucle para buscar coincidencias de abreviaturas en la descripción
        foreach ($abreviaturas as $abreviatura => $valor) {
            if (strpos($descripcion, $abreviatura) !== false) {
                // Extracción del valor de la propiedad utilizando la abreviatura como clave
                $valorAbreviatura = substr($descripcion, strpos($descripcion, $abreviatura) + strlen($abreviatura));
                $valorAbreviatura = trim($valorAbreviatura);
                // Almacenamiento de la propiedad con su valor en el array de propiedades
                $propiedades[$abreviatura] = array(
                    'significado' => $valor,
                    'valor' => $valorAbreviatura
                );
            }
        }
        return $propiedades;
    }

}
