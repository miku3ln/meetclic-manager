<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AskwerField;
use App\Utils\Util;

class AskwerFieldValue extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'askwer_field_value';

    protected $fillable = array(
        'solutions',
        'askwer_field_id',//*
        'field_type',//*
        'askwer_entity_answer_id'//*

    );
    protected $attributesData = [
        ['column' => 'solutions', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'askwer_field_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'field_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'askwer_entity_answer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'solutions';

    public static function getRulesModel()
    {
        $rules = ["askwer_field_id" => "required|numeric",
            "field_type" => "required|numeric",
            "askwer_entity_answer_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.solutions,askwer_field.label as askwer_field,
askwer_field.id as askwer_field_id,
$this->table.field_type,askwer_entity_answer.creation_date as askwer_entity_answer,
askwer_entity_answer.id as askwer_entity_answer_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('askwer_field', 'askwer_field.id', '=', $this->table . '.askwer_field_id');
        $query->join('askwer_entity_answer', 'askwer_entity_answer.id', '=', $this->table . '.askwer_entity_answer_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.solutions', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_field.label", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.field_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_entity_answer.creation_date", 'like', '%' . $likeSet . '%');;

        }

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
        DB::beginTransaction();
        try {
            $modelName = 'AskwerFieldValue';
            $model = new AskwerFieldValue();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AskwerFieldValue::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $askwerFieldValueData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $askwerFieldValueData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  AskwerFieldValue.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('askwer_field', 'askwer_field.id', '=', $this->table . '.askwer_field_id');
        $query->join('askwer_entity_answer', 'askwer_entity_answer.id', '=', $this->table . '.askwer_entity_answer_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.solutions', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_field.label", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.field_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_entity_answer.creation_date", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataAskwerResults($params)
    {

    }

    public function getDataObjectSolution($params)
    {
        $rowSolutions = $this->getRowsSolutionsEntity($params);
        $rowsManagerSolutions = array();
        $array_ready_section = array();
        $array_sections = array();
        $allow = false;
        $count = count($rowSolutions) - 1;
        $countAux = 0;
        $stringIds = "";
        foreach ($rowSolutions as $key => $value) { //FOREACH PARA CADA UNA DE LAS PREGUNTAS Y RESPUESTAS
            $askwer_field_id = $value->askwer_field_id;

            if ($countAux < $count) {
                $stringIds .= $askwer_field_id . ",";
            } else {
                $stringIds .= $askwer_field_id;
            }
            $countAux++;
            $setPush = json_decode(json_encode($value), true);
            $setPush["answer"] = true;
            $rowsManagerSolutions[$key] = $setPush;

        }
        if (isset($params["filters"]["allow"])) {
            $allow = true;
            $paramsCurrent = array();
            $paramsCurrent["filters"]["askwer_form_id"] = $params["filters"]["askwer_form_id"];
            $paramsCurrent["filters"]["fields_keys"] = $stringIds;

            $fieldsData = $this->getFieldsNotFieldValues($paramsCurrent);

            foreach ($fieldsData as $key => $value) { //FOREACH PARA CADA UNA DE LAS PREGUNTAS Y RESPUESTAS
                $fieldsData[$key]["answer"] = false;
                $fieldsData[$key]["solutions"] = "";
                $fieldsData[$key]["manager_id"] = null;

            }

            $rowsManagerSolutions = array_merge($rowsManagerSolutions, $fieldsData);


        }
        foreach ($rowsManagerSolutions as $key => $value) { //FOREACH PARA CADA UNA DE LAS PREGUNTAS Y RESPUESTAS
            $section_id = $value["section_id"];
            $section_name = $value["section_name"];
            $weight = $value["as_weight"];
            $exist_key = array_key_exists($section_id, $array_sections);
            if ($exist_key == false) {
                $fields_data = $this->getSolutionsSection($rowsManagerSolutions, $section_id, $allow);
                $data_section = array("section_name" => $section_name,
                    "section_id" => $section_id,
                    "weight" => $weight,
                    "fields" => $fields_data);
                array_push($array_ready_section, $data_section);
                $array_sections[$section_id][] = $section_id;
            }
        }
        $array_ready_section = Util:: SortByKeyValue($array_ready_section, "weight", SORT_DESC);
        $result = array();
        foreach ($array_ready_section as $key => $value) { //FOREACH PARA CADA UNA DE LAS PREGUNTAS Y RESPUESTAS
            $section_name = $value["section_name"];
            $section_id = $value["section_id"];
            $fields_data = $value["fields"];
            $fields_data = Util:: SortByKeyValue($fields_data, "weight", SORT_DESC);
            $data_section = array("section_name" => $section_name,
                "section_id" => $section_id,
                "fields" => $fields_data,
            );
            array_push($result, $data_section);

        }
        return $result;
    }

    public function getRowsSolutionsEntity($params)
    {
        $askwer_entity_answer_id = $params["filters"]["askwer_entity_answer_id"];
        $allow = isset($params["filters"]["allow"]) ? $params["filters"]["allow"] : false;
        $query = DB::table($this->table);
        $selectString = "$this->table.id manager_id ,askwer_field.comment_allow , askwer_field.weight,askwer_field.widget_type,askwer_field.id as askwer_field_id, $this->table.solutions,$this->table.field_type,askwer_field.label ,askwer_field.validations,askwer_section.name section_name,askwer_section.id section_id,askwer_section.weight as_weight";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('askwer_entity_answer', 'askwer_entity_answer.id', '=', $this->table . '.askwer_entity_answer_id');
        $query->leftJoin('askwer_field', 'askwer_field.id', '=', $this->table . '.askwer_field_id');
        $query->leftJoin('askwer_section', 'askwer_section.id', '=', 'askwer_field.askwer_section_id');
        $query->where($this->table . ".askwer_entity_answer_id", '=', $askwer_entity_answer_id);
        $query->orderBy('askwer_section.weight', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getFieldsNotFieldValues($params)
    {
        $askwer_form_id = $params["filters"]["askwer_form_id"];
        $fields_keys = $params["filters"]["fields_keys"];

        $selectString = "$this->table.name,$this->table.description
        ,af.comment_allow , af.weight, af.widget_type,af.id as askwer_field_id,af.label ,af.validations,af.field_type,as.name section_name,as.id section_id,as.weight as_weight";
        $query = DB::table($this->table);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('askwer_section as', 'as.askwer_form_id', '=', $this->table . '.id');
        $query->join('askwer_field af', 'af.anskwer_section_id', '=', 'as.id');
        $query->where("t.id", '=', $askwer_form_id);

        if ($fields_keys != "") {
            $query->whereNotIn('af.id', '[' . $fields_keys . ']');
        }
        $query->orderBy('as.weight', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getSolutionsSection($rowSolutions, $section_id_search, $allow = false)
    {
        $array_ready = array(); // ARRAY PARA COJER LA INFORMACION PARA INGRESAR EN ANGULARJS
        $count_solutions = count($rowSolutions); //

        $array_ready = array(); // ARRAY PARA COJER LA INFORMACION PARA INGRESAR EN ANGULARJS
        $count = 0; // VARIABLE PARA LA POSICION DEL ARREGLO $array_ready
        $askwere_suma_option_score = 0; //VARIABLE PARA GUARDAR EL PUNTAJE TOTAL DE LA ENCUESTA


        foreach ($rowSolutions as $key => $value) { //FOREACH PARA CADA UNA DE LAS PREGUNTAS Y RESPUESTAS
            $section_id = $value["section_id"];
            if ((int)$section_id_search === (int)$section_id) {
                $weight = $value["weight"];
                $field_id = $value["askwer_field_id"];
                $field_type = $value["field_type"];
                $widget_type = $value["widget_type"];
                $widget_type_name = isset($value["widget_type_name"]) ? $value["widget_type_name"] : 'none-tye-name';

                $comment_allow = $value["comment_allow"];
                $array_ready[$count]["name"] = "  " . $value["label"] . "  ";
                $array_ready[$count]["field_type"] = $field_type;
                $array_ready[$count]["widget_type"] = $widget_type;
                $array_ready[$count]["widget_type_name"] = $widget_type_name;

                $array_ready[$count]["weight"] = $weight;
                $array_ready[$count]["comment_allow"] = $comment_allow;
                $array_ready[$count]["field_id"] = $field_id;
                $array_ready[$count]['availableWidgets'] = AskwerForm::getAvailableWidgets($field_type);
                $array_ready[$count]['availableValidations'] = AskwerForm::getAvailableValidations($field_type);
                $array_ready[$count]['allowOptions'] = AskwerForm::getAllowOptions($field_type);
                $array_ready[$count]['name_parent'] = AskwerForm::getNameElementForm($field_id, $field_type);
                $validations_rules = json_decode($value["validations"]);
                $answer = $value["answer"];
                $array_ready[$count]['answer'] = $answer;
                $array_ready[$count]['manager_id'] = $value["manager_id"];


                $validar_cuestion = false;
//-----------PARA PODER ASIGNAR SI ES REQUERIDO ----
                foreach ($validations_rules as $key_validations => $validation) {

                    if (($validation) == AskwerField::VALIDATION_TYPE_REQUIRED) {
                        $validar_cuestion = true;
                    }

                }
                $array_ready[$count]['validations'] = $validations_rules;
                $array_ready[$count]['validate'] = $validar_cuestion;


                $widget_type_name = "-1";
                $field_type_name = "none";
//             -------TIPOS DE WIDGET A UTILIZAR-------
                switch ($widget_type) {
                    case AskwerField::WIDGET_TYPE_TEXT:
                        $widget_type_name = "input";
                        break;
                    case AskwerField::WIDGET_TYPE_TEXTAREA:
                        $widget_type_name = "textarea";
                        break;
                    case AskwerField::WIDGET_TYPE_RADIO:
                        $widget_type_name = "radio";
                        break;
                    case AskwerField::WIDGET_TYPE_CHECKBOX:
                        $widget_type_name = "checkbox";
                        break;
                    case AskwerField::WIDGET_TYPE_SELECT:
                        $widget_type_name = "select";
                        break;
                    case AskwerField::WIDGET_TYPE_STAR_RATING:
                        $widget_type_name = "rating";
                        break;
                    case AskwerField::WIDGET_TYPE_DATE:
                        $widget_type_name = "date";
                        break;
                }
                switch ($field_type) {

                    case AskwerField::FIELD_TYPE_TEXT:
                        $solutions_array = json_decode($value["solutions"], true); // COJER LOS VALORES DE TEXT O DATA
                        $array_ready[$count]["label"] = $solutions_array; //INGRESO AL $array_ready EN LA PSOCION LABEL
                        $array_ready[$count]["option_score"] = 0; // EL PUNTAJE ES CERO PORQUE ESTE TYPO DE FIELD ES DE TYPO TEXTO QUE INGRESA EL USUARIO
                        $askwere_suma_option_score += 0; // SUMA DE LA RESPUESTA
                        $field_type_name = "text";
                        break;
                    case AskwerField::FIELD_TYPE_TEXTAREA:
                        $solutions_array = json_decode($value["solutions"], true); // COJER LOS VALORES DE TEXT O DATA
                        $array_ready[$count]["label"] = $solutions_array; //INGRESO AL $array_ready EN LA PSOCION LABEL
                        $array_ready[$count]["option_score"] = 0; // EL PUNTAJE ES CERO PORQUE ESTE TYPO DE FIELD ES DE TYPO TEXTO QUE INGRESA EL USUARIO
                        $askwere_suma_option_score += 0; // SUMA DE LA RESPUESTA
                        $field_type_name = "text";
                        break;
                    case AskwerField::FIELD_TYPE_DATE:
                        $solutions_array = json_decode($value["solutions"], true); // COJER LOS VALORES DE TEXT O DATA
                        $array_ready[$count]["label"] = $solutions_array; //INGRESO AL $array_ready EN LA PSOCION LABEL
                        $array_ready[$count]["option_score"] = 0; // EL PUNTAJE ES CERO PORQUE ESTE TYPO DE FIELD ES DE TYPO TEXTO QUE INGRESA EL USUARIO
                        $askwere_suma_option_score += 0; // SUMA DE LA RESPUESTA
                        $field_type_name = "date";

                        break;
                    case AskwerField::FIELD_TYPE_MULTIPLE://CHECKBOX

                        $solutions_array = json_decode($value["solutions"], true); // COJER LAS SOLUCIONES DE CADA PREGUNTA ATRAVES DE JASON
                        $solutions_data = array();
                        $dataOptions = array();
                        $suma_option_score = 0;
                        $cadena_label = 0;
                        /*------OPTIONS FIELD-------*/
                        $modelAF = AskwerField::find($field_id);

                        $modelOptionsAll = $modelAF->optionsByField;
                        foreach ($modelOptionsAll as $key2 => $modelOption) {// FOREACH PARA EL TYPO CHECKBOS YA QUE TIENE VARIOS RESUTADOS
                            $model_ao = $modelOption; // BUSQUEDA Y OBTENICION DE MODELO DE LA TABLA aSKWERE OPTION
                            $dataOptions[$key2] = $model_ao->attributes;
                            $id = $model_ao->id;
                            $array_data = array();
                            $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $id, $model_ao->label);
                            $array_dataResult = $resultOptions["data"];
                            $dataOptions[$key2]["name"] = $resultOptions["name"];
                            $data_options_field = array_merge($dataOptions[$key2], $array_dataResult);
                            $dataOptions[$key2] = $data_options_field;
                        }
                        if ($solutions_array !== "") {

                            if ($answer) {
                                if (!$comment_allow) {

                                    foreach ($solutions_array as $key2 => $value2) {// FOREACH PARA EL TYPO CHECKBOS YA QUE TIENE VARIOS RESUTADOS
                                        $id = $value2; // ID DE LA PREGUNTA

                                        $model_ao = AskwerOption::find($id); // BUSQUEDA Y OBTENICION DE MODELO DE LA TABLA aSKWERE OPTION
                                        if ($model_ao) {
                                            $solutions_data[$key2] = $model_ao->attributes;

                                            $array_data = array();
                                            $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $id, $model_ao->label);
                                            $array_dataResult = $resultOptions["data"];
                                            $solutions_data[$key2]["name"] = $resultOptions["name"];
                                            $data_options_field = array_merge($solutions_data[$key2], $array_dataResult);
                                            $solutions_data[$key2] = $data_options_field;
                                        } else {

                                        }
                                    }

                                } else {

                                    $stringObj = json_decode($value["solutions"], true);
                                    $resultArrayOptions = explode(",", $stringObj);
                                    foreach ($resultArrayOptions as $key2 => $value2) {
                                        $resultArrayOption = explode("/", $value2);

                                        $resultOptionId = explode(":", $resultArrayOption[0])[1];
                                        $resultOptionComment = explode(":", $resultArrayOption[1])[1];
                                        $model_ao = AskwerOption::find($resultOptionId); // BUSQUEDA Y OBTENICION DE MODELO DE LA TABLA aSKWERE OPTION
                                        if ($model_ao) {

                                            $solutions_data[$key2] = $model_ao->attributes;
                                            $solutions_data[$key2]["option_comment"] = $resultOptionComment;

                                            $array_data = array();
                                            $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $resultOptionId, $model_ao->label);
                                            $array_dataResult = $resultOptions["data"];
                                            $solutions_data[$key2]["name"] = $resultOptions["name"];
                                            $data_options_field = array_merge($solutions_data[$key2], $array_dataResult);
                                            $solutions_data[$key2] = $data_options_field;
                                        }
                                    }

                                }
                            }

                        }


                        $array_ready[$count]["data"] = $solutions_data;
                        $array_ready[$count]["dataOptions"] = $dataOptions;

                        $array_ready[$count]["exist"] = true;
                        $field_type_name = "checkbox";
                        break;
                    case AskwerField::FIELD_TYPE_SIMPLE://RADIOBUTTONS

                        $dataOptions = array();
                        $solutions_data = array();
                        $label = "";
                        $option_score = "";
                        $askwere_suma_option_score = 0;
                        $option_comment = "";
                        $modelAF = AskwerField::find($field_id);
                        $modelOptionsAll = $modelAF->optionsByField;

                        foreach ($modelOptionsAll as $key2 => $modelOption) {// FOREACH PARA EL TYPO CHECKBOS YA QUE TIENE VARIOS RESUTADOS

                            $model_ao = $modelOption; // BUSQUEDA Y OBTENICION DE MODELO DE LA TABLA aSKWERE OPTION
                            if ($model_ao) {

                                $dataOptions[$key2] = $model_ao->attributes;
                                $id = $model_ao->id;
                                $array_data = array();
                                $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $id, $model_ao->label);
                                $array_dataResult = $resultOptions["data"];
                                $dataOptions[$key2]["name"] = $resultOptions["name"];
                                $data_options_field = array_merge($dataOptions[$key2], $array_dataResult);
                                $dataOptions[$key2] = $data_options_field;
                            }
                        }


                        if ($answer) {

                            $string = $value["solutions"];

                            if (!$comment_allow) {

                                $string = json_decode($string, true);

                                $solutions_array = explode(",", $string);

                                if (count($solutions_array) >= 2) {

                                    $resultArray = explode(":", $solutions_array[0]);
                                    $resultArrayComment = explode(":", $solutions_array[1]);
                                    $option_id = $resultArray[1];
                                    $option_comment = $resultArrayComment[1];
                                } else {
                                    $option_id = $string;
                                }

                                $model_ao = AskwerOption::find($option_id);
                                if ($model_ao) {
                                    $option_score = $model_ao->option_score;
                                    $label = $model_ao->label;

                                    $array_data = array();
                                    $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $model_ao->id, $model_ao->label);
                                    $array_dataResult = $resultOptions["data"];
                                    $solutions_data = $model_ao->attributes;
                                    $solutions_data["name"] = $resultOptions["name"];
                                    $data_options_field = array_merge($solutions_data, $array_dataResult);
                                    $solutions_data = $data_options_field;

                                }


                            } else {
                                $string = json_decode($string, true);
                                $solutions_array = explode(",", $string);
                                $resultArray = explode(":", $solutions_array[0]);
                                $resultArrayComment = explode(":", $solutions_array[1]);

                                $option_id = $resultArray[1];
                                $option_comment = $resultArrayComment[1];
                                $model_ao = AskwerOption::find($option_id);
                                if ($model_ao) {
                                    $option_score = $model_ao->option_score;
                                    $label = $model_ao->label;
                                    $array_data = array();
                                    $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field_type, $model_ao->id, $model_ao->label);
                                    $array_dataResult = $resultOptions["data"];
                                    $solutions_data = $model_ao->attributes;
                                    $solutions_data["name"] = $resultOptions["name"];
                                    $solutions_data["option_comment"] = $option_comment;
                                    $data_options_field = array_merge($solutions_data, $array_dataResult);
                                    $solutions_data = $data_options_field;
                                }
                            }


                        }

                        $array_ready[$count]["label"] = $label;
                        $array_ready[$count]["option_score"] = $option_score;
                        $array_ready[$count]["option_comment"] = $option_comment;
                        $array_ready[$count]["dataOptions"] = $dataOptions;
                        $array_ready[$count]["data"] = $solutions_data;
                        if ($option_score != '') {
                            $askwere_suma_option_score += $option_score;

                        }
                        $field_type_name = "radio";

                        break;
                    case AskwerField::FIELD_TYPE_BOOLEAN:
                        $solutions_value = "";
                        if ($answer) {
                            $solutions_array = json_decode($value["solutions"], true);

                            $id = $value["solutions"];
                            if ($solutions_array == "true") { // 0 PARA LA CONDICION NO 1 PARA LA CONDICION SI
                                $solutions_value = "SI";
                            } else {
                                $solutions_value = "NO";
                            }
                        }

                        $array_ready[$count]["label"] = $solutions_value; // INGRESO DE LA RESPUESTA EN $array_ready
                        $array_ready[$count]["option_score"] = 0;
                        $field_type_name = "boolean";

                        break;
                    case AskwerField::FIELD_TYPE_RATING:
                        $id = $value["solutions"];
                        $solutions_array = json_decode($value["solutions"], true); //OBTENCION DE LAS SOLUCIONES O LA CALIFICACION QUE DIO CON EL TYPO ESTRELLA
                        $array_ready[$count]["label"] = $solutions_array; //soluciones o respuestas
                        $array_ready[$count]["option_score"] = $solutions_array; // puntaje de la respuesta
                        $askwere_suma_option_score += $solutions_array; //suma de puntaje total
                        $field_type_name = "rating";
                        break;
                }
                $array_ready[$count]["widget_type_name"] = $widget_type_name;
                $array_ready[$count]["field_type_name"] = $field_type_name;
                $count++;
            }
        }

        return $array_ready;
    }

}
