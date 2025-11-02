<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AskwerEntityAnswer;
use App\Models\AskwerField;
use App\Models\AskwerFieldValue;
use App\Models\AskwerOption;
use App\Models\AskwerSection;
use App\Models\AskwerType;


class AskwerForm extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'askwer_form';

    protected $fillable = array(
        'name',//*
        'description',
        'welcome_msg',
        'leave_msg',
        'creation_date',
        'creation_user_id',
        'last_update_date',
        'update_user_id'

    );
    protected $attributesData = [
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'welcome_msg', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'leave_msg', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'creation_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'creation_user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'last_update_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'update_user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'name';


    public $form_structure;
    public $ko_data;
    public $label;
    public $content;
    public $inicio;
    public $fin;
    public $welcome;
    public $leave;
    //public $cliente_nombre_search;
    public $date_first;
    public $date_last;
    public $fields;

    public function sectionsByForm()
    {
        return $this->hasMany(AskwerSection::class, 'askwer_form_id');
    }

    public function answersByForm()
    {
        return $this->hasMany(AskwerEntityAnswer::class, 'askwer_form_id');
    }

    public static function getRulesModel()
    {
        $rules = ["name" => "required|max:254",
            "welcome_msg" => "max:254",
            "leave_msg" => "max:254",
            "creation_user_id" => "numeric",
            "update_user_id" => "numeric"
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

        $selectString = "$this->table.id,$this->table.name,$this->table.description,$this->table.welcome_msg,$this->table.leave_msg,$this->table.creation_date,$this->table.creation_user_id,$this->table.last_update_date,$this->table.update_user_id";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.welcome_msg', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.leave_msg', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.creation_date', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.creation_user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.last_update_date', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.update_user_id', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'AskwerForm';
            $model = new AskwerForm();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AskwerForm::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $askwerFormData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $askwerFormData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AskwerForm.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.welcome_msg', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.leave_msg', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.creation_date', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.creation_user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.last_update_date', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.update_user_id', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getModelsProcess()
    {
        $modelAEA = new AskwerEntityAnswer();
        $modelAFI = new AskwerField();
        $modelAFV = new AskwerFieldValue();
        $modelAF = new AskwerForm();
        $modelAO = new AskwerOption();
        $modelAS = new AskwerSection();
        $modelAT = new AskwerType();

        $result = array(
            'modelAEA' => $modelAEA,
            'modelAFI' => $modelAFI,
            'modelAFV' => $modelAFV,
            'modelAF' => $modelAF,
            'modelAO' => $modelAO,
            'modelAS' => $modelAS,
            'modelAT' => $modelAT,

        );
        return $result;
    }

    public function saveManagerAskwer($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];

        $errors = array();
        $modelName = 'AskwerForm';
        $model = new AskwerForm();
        $createUpdate = true;
        if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
            $model = AskwerForm::find($attributesPost[$modelName]['id']);
            $createUpdate = false;
        } else {
            $createUpdate = true;

        }
        $modelAttributes = array();

        $askwerFormData = $attributesPost[$modelName];


        $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $askwerFormData, 'attributesData' => $this->attributesData));
        $paramsValidate = array(
            'inputs' => $attributesSet,
            'rules' => self::getRulesModel(),

        );
        $validateResult = $this->validateModel($paramsValidate);
        $success = $validateResult["success"];
        if ($success) {
            $model->fill($attributesSet);
            $success = $model->save();
            $modelAttributes = $attributesSet;
            $modelAttributes['id'] = $model->id;
        } else {
            $success = false;
            $msj = "Problemas al guardar  AskwerForm.";
            $errors = $validateResult["errors"];
        }

        $result = [
            "errors" => $errors,
            "msj" => $msj,
            'modelAttributes' => $modelAttributes,
            "success" => $success
        ];

        return ($result);

    }

    public function saveManagerAskwerSections($params)
    {
        $formStructure = $params['formStructure'];
        $deletedSections = isset($formStructure['deletedSections']) ? $formStructure['deletedSections'] : array();
        $listSectionsDelete = array();

        foreach ($deletedSections as $deleteSection) {
            $sectionId = $deleteSection['id'];
            $sectionModel = AskwerSection::find($sectionId);
            $fields = $sectionModel->fieldsBySection;
            foreach ($fields as $field) {
                $options = $field->optionsByField; //
                foreach ($options as $option) {
                    $option->delete();
                }
                $field->delete();
            }
            $sectionModel->delete();
            $listSectionsDelete[] = $sectionId;
        }
        $sections = $formStructure['sections'];
        $askwer_form_id = $params['askwer_form_id'];
        $user = $params['user'];
        $userId = $user->id;
        $msj = 'Ok';
        $errors = array();
        $modelAS = new AskwerSection;
        $modelAF = new AskwerField;
        $modelAO = new AskwerOption;
        $success = false;

        foreach ($sections as $section) {


            $countSections = 0;

            $createUpdate = isset($section['id']);
            $makeManager = true;
            if ($createUpdate) {
                $section_id = $section['id'];
                $searchDeleted = in_array($section_id, $listSectionsDelete);
                if ($searchDeleted) {
                    $makeManager = false;
                }
            }
            if ($makeManager) {
                if ($createUpdate) {
                    $modelSection = AskwerSection::find($section['id']);
                } else {
                    $modelSection = new AskwerSection;
                }
                $modelCurrent = $modelAS;

                $setPush = array();
                $setPush = $section;
                $setPush['askwer_form_id'] = $askwer_form_id;

                $attributesSet = $modelCurrent->getValuesModel(array('type' => 'section', 'fillAble' => $modelCurrent->getfillable(), 'haystack' => $setPush, 'attributesData' => $modelCurrent->getAttributesData()));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => $modelCurrent::getRulesModel(),

                );
                $validateResult = $modelCurrent->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $modelSection->fill($attributesSet);
                    $success = $modelSection->save();
                    $askwer_section_id = $modelSection->id;
                    $countSections++;
                    $countFields = 0;

                    $listFieldsDelete = array();
                    $allowFieldsDelete = false;
                    if (isset($section['deletedFields'])) {

                        foreach ($section['deletedFields'] as $field) {
                            $field_id = $field['id'];
                            $fieldModel = AskwerField::find($field_id);
                            $options = $fieldModel->optionsByField; //todas las opciones :) del field
                            foreach ($options as $optionModel) {
                                $optionModel->delete();
                            }
                            $fieldModel->delete();
                            $listFieldsDelete[] = $field_id;
                        }
                    }
                    $allowFieldsDelete = count($listFieldsDelete);
                    $fields = $section['fields'];

                    foreach ($fields as $field) {
                        $createUpdate = isset($field['id']);
                        $makeManager = true;
                        if ($createUpdate) {//es actualizar si es verdadero
                            $id = $field['id'];
                            $searchDeleted = in_array($id, $listFieldsDelete);
                            if ($searchDeleted) {
                                $makeManager = false;
                            }
                        }
                        if ($makeManager) {
                            $modelCurrent = $modelAF;
                            $setPush = array();
                            $setPush = $field;
                            if ($createUpdate) {
                                $modelField = AskwerField::find($field['id']);
                            } else {
                                $modelField = new AskwerField;

                            }
                            $setPush['askwer_section_id'] = $askwer_section_id;
                            $setPush['validations'] = json_encode($setPush['validations']);
                            $comment_allow = 0;
                            foreach ($field["validations"] as $validation) {
                                if ($validation == "comment_allow") {
                                    $comment_allow = 1;
                                }
                            }
                            $setPush['comment_allow'] = $comment_allow;
                            $attributesSet = $modelCurrent->getValuesModel(array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $setPush, 'attributesData' => $modelCurrent->getAttributesData()));
                            $paramsValidate = array(
                                'inputs' => $attributesSet,
                                'rules' => $modelCurrent::getRulesModel(),

                            );
                            $validateResult = $modelCurrent->validateModel($paramsValidate);
                            $success = $validateResult["success"];
                            if ($success) {
                                $modelField->fill($attributesSet);
                                $success = $modelField->save();
                                $askwer_field_id = $modelField->id;
                                $countFields++;
                                $countOption = 0;

                                $fieldOptions = $field['fieldOptions'];
                                foreach ($fieldOptions as $option) {
                                    if (isset($option['id'])) {
                                        $modelOption = AskwerOption::find($option['id']);
                                    } else {
                                        $modelOption = new AskwerOption;

                                    }
                                    $modelCurrent = $modelAO;
                                    $setPush = array();
                                    $setPush = $option;
                                    $setPush['option_score'] = isset($setPush['option_score']) ? $setPush['option_score'] : 0;
                                    $setPush['option_score_point'] = isset($setPush['option_score_point']) ? $setPush['option_score_point'] : 0;
                                    $setPush['askwer_field_id'] = $askwer_field_id;
                                    $attributesSet = $modelCurrent->getValuesModel(array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $setPush, 'attributesData' => $modelCurrent->getAttributesData()));
                                    $paramsValidate = array(
                                        'inputs' => $attributesSet,
                                        'rules' => $modelCurrent::getRulesModel(),

                                    );
                                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                                    $success = $validateResult["success"];
                                    if ($success) {
                                        $modelOption->fill($attributesSet);
                                        $success = $modelOption->save();
                                    } else {
                                        $success = false;
                                        $msj = "Problemas al guardar  Option.";
                                        $errors["sections"][$countSections][$countFields][$countOption]["errors"] = $validateResult["errors"];


                                    }
                                    $countOption++;
                                }
                            } else {
                                $success = false;
                                $msj = "Problemas al guardar  Field.";
                                $errors["sections"][$countSections][$countFields]["errors"] = $validateResult["errors"];


                            }
                        }

                    }

                } else {
                    $success = false;
                    $msj = "Problemas al guardar  AskwerForm.";
                    $errors["sections"][$countSections]["errors"] = $validateResult["errors"];

                }
            }


        }
        $result = array(
            'success' => $success,
            'msj' => $msj,
            'errors' => $errors
        );

        return $result;
    }

    public static function getNameElementForm($fieldId, $fieldType)
    {
        $ng_model_name_parent = "";

        switch ($fieldType) {
            case AskwerField::FIELD_TYPE_TEXT:
                $ng_model_name_parent = "n" . $fieldId . '_' . $fieldType;

                break;
            case AskwerField::FIELD_TYPE_SIMPLE:


                $ng_model_name_parent = "formData2.parentCheckChekee" . $fieldId;

                break;
            case AskwerField::FIELD_TYPE_MULTIPLE:

                $ng_model_name_parent = "formData.parentCheckChekee" . $fieldId;


                break;
            case AskwerField::FIELD_TYPE_DATE:
                $ng_model_name_parent = "soluccions.n" . $fieldId . '_' . $fieldType;

                break;
            case AskwerField::FIELD_TYPE_BOOLEAN:

                $ng_model_name_parent = 'formDataboolean.parentCheckChekee' . $fieldId;

                break;
            case AskwerField::FIELD_TYPE_RATING:
                $ng_model_name_parent = 'formDatastart.parentCheckChekee' . $fieldId;
                break;
            default:
                break;
        }
        return $ng_model_name_parent;
    }

    public static function getStructureKo($model)
    {
        $result = array();
        $sections = $model->sectionsByForm;

        foreach ($sections as $k => $section) {

            $result[$k] = $section->attributes;
            $result[$k]['fields'] = array();
            $fields = $section->fieldsBySection;
            foreach ($fields as $j => $field) {
                $result[$k]['fields'][$j] = $field->attributes;
                $result[$k]['fields'][$j]['validations'] = json_decode($field->validations);
                $result[$k]['fields'][$j]['availableWidgets'] = array();
                $result[$k]['fields'][$j]['availableValidations'] = array();
                $result[$k]['fields'][$j]['availableWidgets'] = self::getAvailableWidgets($field->field_type);
                $result[$k]['fields'][$j]['availableValidations'] = self::getAvailableValidations($field->field_type);
                $result[$k]['fields'][$j]['allowOptions'] = self::getAllowOptions($field->field_type);
                $result[$k]['fields'][$j]['fieldOptions'] = array();
                $options = $field->optionsByField;
                foreach ($options as $option) {
                    $result[$k]['fields'][$j]['fieldOptions'][] = $option->attributes;
                }
            }
        }

        return $result;
    }

    public static function getAvailableWidgets($field_type)
    {
        $result = array();

        switch ($field_type) {
            case AskwerField::FIELD_TYPE_TEXT:
                $result[] = array('value' => AskwerField::WIDGET_TYPE_TEXT, 'text' => 'Textfield');
                $result[] = array('value' => AskwerField::WIDGET_TYPE_TEXTAREA, 'text' => 'Text Area');
                break;
            case AskwerField::FIELD_TYPE_SIMPLE:

                $result[] = array('value' => AskwerField::WIDGET_TYPE_RADIO, 'text' => 'Radio Buttons');
                $result[] = array('value' => AskwerField::WIDGET_TYPE_SELECT, 'text' => 'Dropdown');
                break;
            case AskwerField::FIELD_TYPE_MULTIPLE:

                $result[] = array('value' => AskwerField::WIDGET_TYPE_CHECKBOX, 'text' => 'Checkboxes');
                $result[] = array('value' => AskwerField::WIDGET_TYPE_SELECT, 'text' => 'Dropdown');


                break;
            case AskwerField::FIELD_TYPE_DATE:
                $result[] = array('value' => AskwerField::WIDGET_TYPE_DATE, 'text' => 'Date');

                break;
            case AskwerField::FIELD_TYPE_BOOLEAN:
                $result[] = array('value' => AskwerField::WIDGET_TYPE_CHECKBOX, 'text' => 'Checkboxes');


                break;
            case AskwerField::FIELD_TYPE_RATING:

                $result[] = array('value' => AskwerField::WIDGET_TYPE_STAR_RATING, 'text' => 'Star Rating');
                $result[] = array('value' => AskwerField::WIDGET_TYPE_SELECT, 'text' => 'Dropdown');
                break;
            default:
                break;
        }
        return $result;
    }

    public static function getAvailableValidations($field_type)
    {
        $result = array();

        switch ($field_type) {
            case AskwerField::FIELD_TYPE_TEXT:
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_REQUIRED, 'text' => 'Required');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_NUMERICAL, 'text' => 'Numerical');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_DIGITS, 'text' => 'Digits');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_EMAIL, 'text' => 'Email');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_URL, 'text' => 'URL');

                break;
            case AskwerField::FIELD_TYPE_SIMPLE:

                $result[] = array('value' => AskwerField::VALIDATION_TYPE_REQUIRED, 'text' => 'Required');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_COMMENT_ALLOW, 'text' => 'Agregar Cantidad');

                break;
            case AskwerField::FIELD_TYPE_MULTIPLE:

                $result[] = array('value' => AskwerField::VALIDATION_TYPE_REQUIRED, 'text' => 'Required');
                $result[] = array('value' => AskwerField::VALIDATION_TYPE_COMMENT_ALLOW, 'text' => 'Agregar Cantidad');

                break;
            case AskwerField::FIELD_TYPE_DATE:


                break;
            case AskwerField::FIELD_TYPE_BOOLEAN:

                $result[] = array('value' => AskwerField::VALIDATION_TYPE_REQUIRED, 'text' => 'Required');
                break;
            case AskwerField::FIELD_TYPE_RATING:

                $result[] = array('value' => AskwerField::VALIDATION_TYPE_REQUIRED, 'text' => 'Required');

                break;
            default:
                break;
        }
        return $result;
    }

    public static function getAllowOptions($field_type)
    {
        $result = false;

        switch ($field_type) {
            case AskwerField::FIELD_TYPE_TEXT:
                $result = false;

                break;
            case AskwerField::FIELD_TYPE_SIMPLE:
                $result = true;
                break;
            case AskwerField::FIELD_TYPE_MULTIPLE:
                $result = true;
                break;
            case AskwerField::FIELD_TYPE_DATE:

                $result = false;

                break;
            case AskwerField::FIELD_TYPE_BOOLEAN:
                $result = false;

                break;
            case AskwerField::FIELD_TYPE_RATING:
                $result = true;

                break;
            default:
                break;
        }
        return $result;
    }

    public static function getDataAskwerForm($model)
    {
        $sections = array();
        foreach ($model->sectionsByForm as $k => $section) {
            $sections[$k] = $section->attributes;
            $sections[$k]['fields'] = array();
            foreach ($section->fieldsBySection as $j => $field) {
                $field_id = $field->id;
                $field_type = $field->field_type;
                $data_field = $field->attributes;
                $validations_rules = json_decode($field->validations);
                $validar_cuestion = false;
//-----------PARA PODER ASIGNAR SI ES REQUERIDO ----
                foreach ($validations_rules as $key_validations => $validation) {

                    if (($validation) == AskwerField::VALIDATION_TYPE_REQUIRED) {
                        $validar_cuestion = true;
                    }

                }

                $ng_model_name_parent = "";
                //aqui en esta posicion se encuentra las validaciones para cada
                //field(pregunta)

                $sections[$k]['fields'][$j]['availableWidgets'] = array();
                $sections[$k]['fields'][$j]['availableValidations'] = array();
                $sections[$k]['fields'][$j] = $data_field;
                $sections[$k]['fields'][$j]['availableWidgets'] = AskwerForm::getAvailableWidgets($field_type);
                $sections[$k]['fields'][$j]['validationss'] = $validations_rules;
                $sections[$k]['fields'][$j]['validate'] = $validar_cuestion;
                $sections[$k]['fields'][$j]['availableValidations'] = AskwerForm::getAvailableValidations($field_type);
                $sections[$k]['fields'][$j]['name_parent'] = AskwerForm::getNameElementForm($field_id, $field_type);
                $sections[$k]['fields'][$j]['allowOptions'] = AskwerForm::getAllowOptions($field_type);

                switch ($field_type) {
                    case AskwerField::FIELD_TYPE_TEXT:
//                        ---ASIGNAR SI TIENE MULTIPLE INFORMACION---

                        $type = "text";
                        foreach ($validations_rules as $key_validations => $validation) {
                            if ($validation == AskwerField::VALIDATION_TYPE_EMAIL) {
                                $type = $validation;
                            }
                            if (($validation) == AskwerField::VALIDATION_TYPE_REQUIRED) {
                                $validar_cuestion = true;
                            }
                        }

                        $sections[$k]['fields'][$j]['validate'] = $validar_cuestion;
                        break;
                    case AskwerField::FIELD_TYPE_SIMPLE:
                        $type = "radio";

                        /*   var_dump($validar_cuestion);*/

                        break;
                    case AskwerField::FIELD_TYPE_MULTIPLE:
                        $type = "checkbox";


                        break;
                    case AskwerField::FIELD_TYPE_DATE:

                        $type = "text";


                        break;
                    case AskwerField::FIELD_TYPE_BOOLEAN:

                        $type = "text";

                        break;
                    case AskwerField::FIELD_TYPE_RATING:
                        $type = "text";

                        break;
                    default:
                        break;
                }
                $sections[$k]['fields'][$j]['type'] = $type;

//----------ASIGNACIONES DE INFORMACION DE LS OPCIONES--

                $sections[$k]['fields'][$j]['fieldOptions'] = array();
                $ng_model_name_parent_children = "";
                foreach ($field->optionsByField as $option) {
                    $option_id = $option->id;
                    $data_options_field = $option->attributes;
                    $array_data = array();
                    $resultOptions = AskwerForm::getResultConfigFormOptions($field_id, $field->field_type, $option_id, $data_options_field['label']);
                    $array_dataResult = $resultOptions["data"];
                    $array_data["name"] = $resultOptions["name"];
                    $data_options_field = array_merge($data_options_field, $array_dataResult);
                    $sections[$k]['fields'][$j]['fieldOptions'][] = $data_options_field;
                }
            }
        }

        return $sections;
    }

    public static function getResultConfigFormOptions($fieldId, $fieldType, $optionId, $label)
    {
        $array_data = array();
        $ng_model_name_parent_children = "";
        $result = array(
            "name" => $ng_model_name_parent_children,
            "data" => $array_data
        );

        switch ($fieldType) {
            case AskwerField::FIELD_TYPE_SIMPLE:// ES CUANDO S VA A SELECCIONAR X LO MENOS UNA
                $type = "radio";
                $ng_model_name_parent_children = 'formData2.selectedChekee' . $fieldId . ".name" . $optionId;
                break;
            case AskwerField::FIELD_TYPE_MULTIPLE:
                $type = "checkbox";
                $ng_model_name_parent_children = 'formData.selectedChekee' . $fieldId . ".childrenChekChekee_" . $optionId;
                break;
            case AskwerField::FIELD_TYPE_RATING:

                $type = "radio";
                $max = $label;
                $max_aux = (integer)$label;
                $array_ready = array();
                for ($i = 0; $i < $max; $i++) {
                    $array_ready[$i]['max'] = $max_aux;
                    $max_aux--;
                }
                $array_data["array"] = $array_ready;

                break;
            default:
                break;
        }

        $result = array(
            "name" => $ng_model_name_parent_children,
            "data" => $array_data
        );
        return $result;
    }

    public function saveAskwer($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'AskwerForm';
            $model = new AskwerForm();
            $modelAEA = new AskwerEntityAnswer();

            $educationalInstitutionByBusiness = $attributesPost['EducationalInstitutionByBusiness'];
            $askwerForm = $attributesPost[$modelName];
            $solutions = $askwerForm['solutions'];

            $askwer_form_id = $educationalInstitutionByBusiness['askwer_form_id'];
            $creation_date = Util::DateCurrent();
            $setPush = array(
                'askwer_form_id' => $askwer_form_id,
                'creation_date' => $creation_date,

            );
            $currentModel = $modelAEA;


            $attributesSet = $currentModel->getValuesModel(array('fillAble' => $currentModel->getfillable(), 'haystack' => $setPush, 'attributesData' => $currentModel->getAttributesData()));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => $currentModel::getRulesModel(),

            );
            $validateResult = $currentModel->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $modelAEA->fill($attributesSet);
                $success = $modelAEA->save();
                $askwer_entity_answer_id = $modelAEA->id;
                foreach ($solutions as $keySolution => $valueSolution) {//sections
                    //                -----soluciones----
//$keySolution=section_id///la secccion d las preguntas
                    foreach ($valueSolution as $keySolutionField => $fieldSolution) {//respuestas
//                        $keySolutionField=[field_id][field_type]
                        if ($fieldSolution != '' || $fieldSolution != null) {//only happens when not required
                            $solutions_key = explode('_', $keySolutionField);
                            if (count($solutions_key) > 2) {//comment_exists

                            } else {
                                $askwer_field_id = $solutions_key[0];
                                $field_type = $solutions_key[1];
                                $setPush["askwer_field_id"] = $askwer_field_id;
                                $setPush["solutions"] = json_encode($fieldSolution);
                                $setPush["askwer_entity_answer_id"] = $askwer_entity_answer_id;
                                $setPush["field_type"] = $field_type;
                                $modelAFV = new AskwerFieldValue();
                                $currentModel = $modelAFV;
                                $attributesSet = $currentModel->getValuesModel(array('fillAble' => $currentModel->getfillable(), 'haystack' => $setPush, 'attributesData' => $currentModel->getAttributesData()));
                                $paramsValidate = array(
                                    'inputs' => $attributesSet,
                                    'rules' => $currentModel::getRulesModel(),

                                );
                                $validateResult = $currentModel->validateModel($paramsValidate);
                                $success = $validateResult["success"];
                                if ($success) {
                                    $modelAFV->fill($attributesSet);
                                    $success = $modelAFV->save();
                                } else {
                                    $success = false;
                                    $msj = "Problemas al guardar  Solucion.";
                                    $errors = $validateResult["errors"];
                                }


                            }

                        }

                    }
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar  Soluciones Entidad.";
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

    public function getDataSolutionsAskwer($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        try {

            $modelAEA = new AskwerEntityAnswer();
            $educationalInstitutionByBusiness = $attributesPost['EducationalInstitutionByBusiness'];
            $askwer_form_id = $educationalInstitutionByBusiness['askwer_form_id'];
            $model = AskwerForm::find($askwer_form_id);

            if ($model) {
                $success = true;
                $modelEAAll = $model->answersByForm;
                $answers = array();
                $modelAFV = new AskwerFieldValue;
                foreach ($modelEAAll as $modelEA) {

                    $resultCurrent = array();
                    $askwer_entity_answer_id = $modelEA->id;
                    $paramsSearch = array("filters" => array("askwer_entity_answer_id" => $askwer_entity_answer_id));
                    $dataInformation = array();
                    $namesTestInspector = "Usuario Prueba";
                    $dataInformation["docente"] = $namesTestInspector;
                    $dataInformation["materia"] = "Testeo";
                    $row_solutions = $modelAFV->getDataObjectSolution($paramsSearch);
                    $resultCurrent["answers"] = $row_solutions;
                    $resultCurrent["user"] = $dataInformation;
                    array_push($answers, $resultCurrent);

                }
                $data = $answers;
            } else {
                $errors = array();
                $msj = 'No Existe Formularios Gestionados.';
                $success = false;
            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data,
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "data" => $data,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public function getDataSolutionsData($params)
    {
        $success = false;
        $msj = "Resultado";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        try {


            $askwer_entity_answer_id = $attributesPost['askwer_entity_answer_id'];

            $modelAEA = AskwerEntityAnswer::find($askwer_entity_answer_id);
            if ($modelAEA) {
                $askwer_form_id = $modelAEA->askwer_form_id;
                $model = AskwerForm::find($askwer_form_id);

                if ($model) {
                    $success = true;
                    $modelEAAll = $model->answersByForm;
                    $answers = array();
                    $modelAFV = new AskwerFieldValue;
                    $resultCurrent = array();
                    $paramsSearch = array("filters" => array("askwer_entity_answer_id" => $askwer_entity_answer_id));
                    $dataInformation = array();
                    $namesTestInspector = "Usuario Prueba";
                    $dataInformation["docente"] = $namesTestInspector;
                    $dataInformation["materia"] = "Testeo";
                    $row_solutions = $modelAFV->getDataObjectSolution($paramsSearch);
                    $resultCurrent["answers"] = $row_solutions;
                    $resultCurrent["user"] = $dataInformation;
                    array_push($answers, $resultCurrent);


                    $data = $answers;
                } else {
                    $errors = array();
                    $msj = 'No Existe este formulario.';
                    $success = false;
                }
            } else {
                $errors = array();
                $msj = 'No Existe Formulario Gestionado .';
                $success = false;
            }


            $result = [
                "errors" => $errors,
                "msg" => $msj,
                "message" => $msj,

                "success" => $success,
                "data" => $data,
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "data" => $data,
                "msg" => $msj,
                "message" => $msj,

                "errors" => $errors
            );
            return ($result);
        }
    }

    public function saveAskwerFireBrigade($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'AskwerForm';
            $model = new AskwerForm();
            $modelAEA = new AskwerEntityAnswer();
            $user = Auth::user();

            $educationalInstitutionByBusiness = $attributesPost['EducationalInstitutionByBusiness'];
            $askwerForm = $attributesPost[$modelName];
            $solutions = $askwerForm['solutions'];

            $askwer_form_id = $educationalInstitutionByBusiness['askwer_form_id'];
            $creation_date = Util::DateCurrent();
            $setPush = array(
                'askwer_form_id' => $askwer_form_id,
                'creation_date' => $creation_date,

            );
            $currentModel = $modelAEA;


            $attributesSet = $currentModel->getValuesModel(array('fillAble' => $currentModel->getfillable(), 'haystack' => $setPush, 'attributesData' => $currentModel->getAttributesData()));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => $currentModel::getRulesModel(),

            );
            $validateResult = $currentModel->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $modelAEA->fill($attributesSet);
                $success = $modelAEA->save();
                $askwer_entity_answer_id = $modelAEA->id;
                $fire_brigade_customer_business_by_request_id = $attributesPost['FireBrigadeCustomerBusinessRequestByAnswer']['id'];
                $stateForm = isset($attributesPost['FireBrigadeCustomerBusinessRequestByAnswer']['state_business']) ? $attributesPost['FireBrigadeCustomerBusinessRequestByAnswer']['state_business'] : \App\Models\FireBrigadeCustomerBusinessRequestByAnswer::STATE_REPROBATE;

                $fireBrigadeCustomerBusinessRequestByAnswerData = [
                    'fire_brigade_customer_business_by_request_id' => $fire_brigade_customer_business_by_request_id,
                    'askwer_entity_answer_id' => $askwer_entity_answer_id,
                    'state' => $stateForm,
                    'owner_id' => $user->id

                ];
                $modelCurrent = new \App\Models\FireBrigadeCustomerBusinessRequestByAnswer();
                $attributesSet = $fireBrigadeCustomerBusinessRequestByAnswerData;
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => $modelCurrent::getRulesModel(),

                );
                $validateResult = $modelCurrent->validateModel($paramsValidate);
                $success = $validateResult["success"];


                if ($success) {
                    $modelCurrent->fill($attributesSet);
                    $success = $modelCurrent->save();
                    $modelCurrent = \App\Models\FireBrigadeCustomerBusinessByRequest::find($fire_brigade_customer_business_by_request_id);
                    $stateRequest = \App\Models\FireBrigadeCustomerBusinessByRequest::STATE_REPROBATE;
                    if ($stateForm == \App\Models\FireBrigadeCustomerBusinessRequestByAnswer::STATE_APPROVED) {
                        $stateRequest = \App\Models\FireBrigadeCustomerBusinessByRequest::STATE_END;
                    }

                    $modelCurrent->state = $stateRequest;
                    $modelCurrent->save();
                    foreach ($solutions as $keySolution => $valueSolution) {//sections
                        //                -----soluciones----
//$keySolution=section_id///la secccion d las preguntas
                        foreach ($valueSolution as $keySolutionField => $fieldSolution) {//respuestas
//                        $keySolutionField=[field_id][field_type]
                            if ($fieldSolution != '' || $fieldSolution != null) {//only happens when not required
                                $solutions_key = explode('_', $keySolutionField);
                                if (count($solutions_key) > 2) {//comment_exists

                                } else {
                                    $askwer_field_id = $solutions_key[0];
                                    $field_type = $solutions_key[1];
                                    $setPush["askwer_field_id"] = $askwer_field_id;
                                    $setPush["solutions"] = json_encode($fieldSolution);
                                    $setPush["askwer_entity_answer_id"] = $askwer_entity_answer_id;
                                    $setPush["field_type"] = $field_type;
                                    $modelAFV = new AskwerFieldValue();
                                    $currentModel = $modelAFV;
                                    $attributesSet = $currentModel->getValuesModel(array('fillAble' => $currentModel->getfillable(), 'haystack' => $setPush, 'attributesData' => $currentModel->getAttributesData()));
                                    $paramsValidate = array(
                                        'inputs' => $attributesSet,
                                        'rules' => $currentModel::getRulesModel(),

                                    );
                                    $validateResult = $currentModel->validateModel($paramsValidate);
                                    $success = $validateResult["success"];
                                    if ($success) {
                                        $modelAFV->fill($attributesSet);
                                        $success = $modelAFV->save();
                                    } else {
                                        $success = false;
                                        $msj = "Problemas al guardar  Solucion.";
                                        $errors = $validateResult["errors"];
                                    }


                                }

                            }

                        }
                    }


                } else {
                    $success = false;
                    $msj = "Problemas al asignar respuestas.";
                    $errors = $validateResult["errors"];
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  Soluciones Entidad.";
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

}
