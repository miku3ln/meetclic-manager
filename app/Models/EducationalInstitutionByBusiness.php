<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AskwerForm;

class EducationalInstitutionByBusiness extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'educational_institution_by_business';

    protected $fillable = array(
        'educational_institution_askwer_type_id',//*
        'business_id',//*
        'askwer_form_id',//*
        'create_user_id'//*

    );
    protected $attributesData = [
        ['column' => 'educational_institution_askwer_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'askwer_form_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'create_user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["educational_institution_askwer_type_id" => "required|numeric",
            "business_id" => "required|numeric",
            "askwer_form_id" => "required|numeric",
            "create_user_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,educational_institution_askwer_type.value as educational_institution_askwer_type,
educational_institution_askwer_type.id as educational_institution_askwer_type_id,
business.title as business,
business.id as business_id,
askwer_form.name as askwer_form,
askwer_form.id as askwer_form_id,
$this->table.create_user_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('educational_institution_askwer_type', 'educational_institution_askwer_type.id', '=', $this->table . '.educational_institution_askwer_type_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('askwer_form', 'askwer_form.id', '=', $this->table . '.askwer_form_id');
        $query->where("business.id", '=', $business_id);

        if ($params['searchPhrase'] != null) {

            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("askwer_form.name", 'like', '%' . $likeSet . '%');


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

            $createUpdate = true;
            if (isset($attributesPost[$modelName]["iha_id"]) && $attributesPost[$modelName]["iha_id"] != "null" && $attributesPost[$modelName]["iha_id"] != "-1") {
                $model = EducationalInstitutionByBusiness::find($attributesPost[$modelName]['iha_id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
                $model = new EducationalInstitutionByBusiness();
            }
            $user = Auth::user();
            $modelAF = new AskwerForm();
            $resultManager = $modelAF->saveManagerAskwer($params);
            if ($resultManager['success']) {
                $askwer_form_id = $resultManager['modelAttributes']['id'];
                $form_structure = $attributesPost[$modelName]['form_structure'];
                $form_structure = json_decode($form_structure, true);
                $resultManager = $modelAF->saveManagerAskwerSections(array(
                    'askwer_form_id' => $askwer_form_id,
                    'formStructure' => $form_structure,
                    'user' => $user

                ));

                if ($resultManager['success']) {
                    $educationalInstitutionByBusinessData = $attributesPost[$modelName];
                    $educationalInstitutionByBusinessData['askwer_form_id'] = $askwer_form_id;
                    $educationalInstitutionByBusinessData['create_user_id'] = $user->id;

                    $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $educationalInstitutionByBusinessData, 'attributesData' => $this->attributesData));
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
                        $msj = "Problemas al guardar  EducationalInstitutionByBusiness.";
                        $errors = $validateResult["errors"];
                    }
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Formulario Sections-Options";
                    $errors = $resultManager["errors"];
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  Formulario.";
                $errors = $resultManager["errors"];
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
        $query->join('educational_institution_askwer_type', 'educational_institution_askwer_type.id', '=', $this->table . '.educational_institution_askwer_type_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('askwer_form', 'askwer_form.id', '=', $this->table . '.askwer_form_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("educational_institution_askwer_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_form.name", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.create_user_id', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataAskwer($params)
    {
        $attributesPost = $params["attributesPost"];

        $msj = '';
        $errors = array();
        $success = true;
        $data = array();

        $id = $attributesPost['EducationalInstitutionByBusiness']['id'];
        $model = EducationalInstitutionByBusiness::find($id);
        if ($model) {
            $askwer_form_id = $model->askwer_form_id;
            $modelAF = AskwerForm::find($askwer_form_id);
            if ($modelAF) {
                $sections = AskwerForm::getStructureKo($modelAF);;
                $AskwerForm = array();
                $AskwerForm = $modelAF->attributes;
                $AskwerForm['sections'] = $sections;
                $data = array(
                    'AskwerForm' => $AskwerForm,
                    'EducationalInstitutionByBusiness' => $model->attributes
                );


            } else {
                $msj = 'No existe informacion formulario.';
                $success = false;
            }
        } else {
            $msj = 'No existe un formulario con aquella informacion.';
            $success = false;

        }

        $result = [
            'data' => $data,
            "errors" => $errors,
            "msj" => $msj,
            "success" => $success
        ];

        return ($result);
    }

    public function getDataAskwerForm($params)
    {
        $attributesPost = $params["attributesPost"];

        $msj = '';
        $errors = array();
        $success = true;
        $data = array();

        $id = $attributesPost['EducationalInstitutionByBusiness']['id'];
        $model = EducationalInstitutionByBusiness::find($id);
        if ($model) {
            $askwer_form_id = $model->askwer_form_id;
            $modelAF = AskwerForm::find($askwer_form_id);
            if ($modelAF) {
                $sections = AskwerForm::getDataAskwerForm($modelAF);;
                $AskwerForm = array();
                $AskwerForm = $modelAF->attributes;
                $AskwerForm['sections'] = $sections;
                $data = array(
                    'AskwerForm' => $AskwerForm,
                    'EducationalInstitutionByBusiness' => $model->attributes
                );


            } else {
                $msj = 'No existe informacion formulario.';
                $success = false;
            }
        } else {
            $msj = 'No existe un formulario con aquella informacion.';
            $success = false;

        }

        $result = [
            'data' => $data,
            "errors" => $errors,
            "msj" => $msj,
            "success" => $success
        ];

        return ($result);
    }
}
