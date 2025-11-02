<?php

namespace App\Models;

use Auth;
use Illuminate\Support\Facades\DB;

class AskwerField extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';


    const FIELD_TYPE_TEXT = 1;//text
    const FIELD_TYPE_SIMPLE = 2;//radio buttons 1
    const FIELD_TYPE_MULTIPLE = 3;//check box
    const FIELD_TYPE_BOOLEAN = 4;//toogle yes-not
    const FIELD_TYPE_DATE = 5;//fecha
    const FIELD_TYPE_RATING = 6;//estrella
    const FIELD_TYPE_TEXTAREA = 7;//text area
    const FIELD_TYPE_DROP = 8;//text area

    const WIDGET_TYPE_TEXT = 1;
    const WIDGET_TYPE_RADIO = 2;
    const WIDGET_TYPE_CHECKBOX = 3;
    const WIDGET_TYPE_BOOLEAN = 4;
    const WIDGET_TYPE_DATE = 5;
    const WIDGET_TYPE_STAR_RATING = 6;
    const WIDGET_TYPE_TEXTAREA = 7;
    const WIDGET_TYPE_SELECT = 8;

    const VALIDATION_TYPE_REQUIRED = 'required';
    const VALIDATION_TYPE_COMMENT_ALLOW = 'comment_allow';

    const VALIDATION_TYPE_NUMERICAL = 'numerical';
    const VALIDATION_TYPE_DIGITS = 'digits';
    const VALIDATION_TYPE_EMAIL = 'email';
    const VALIDATION_TYPE_URL = 'url';
    protected $table = 'askwer_field';

    protected $fillable = array(
        'label',//*
        'field_type',//*
        'widget_type',
        'validations',
        'weight',
        'askwer_section_id',//*
        'description',
        'style_option',
        'element_configuration',
        'comment_allow'//*

    );
    protected $attributesData = [
        ['column' => 'label', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'field_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'widget_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'validations', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'weight', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'askwer_section_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'style_option', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'element_configuration', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'comment_allow', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'label';

    public function optionsByField()
    {
        return $this->hasMany(AskwerOption::class, 'askwer_field_id');
    }

    public static function getRulesModel()
    {
        $rules = ["label" => "required",
            "field_type" => "required|numeric",
            "widget_type" => "numeric",
            "weight" => "numeric",
            "askwer_section_id" => "required|numeric",
            "comment_allow" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.label,$this->table.field_type,$this->table.widget_type,$this->table.validations,$this->table.weight,askwer_section.name as askwer_section,
askwer_section.id as askwer_section_id,
$this->table.description,$this->table.style_option,$this->table.element_configuration,$this->table.comment_allow";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('askwer_section', 'askwer_section.id', '=', $this->table . '.askwer_section_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.label', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.field_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.widget_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.validations', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.weight', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_section.name", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.style_option', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.element_configuration', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.comment_allow', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'AskwerField';
            $model = new AskwerField();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AskwerField::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $askwerFieldData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $askwerFieldData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AskwerField.";
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
        $query->join('askwer_section', 'askwer_section.id', '=', $this->table . '.askwer_section_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.label', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.field_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.widget_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.validations', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.weight', 'like', '%' . $likeSet . '%');
            $query->orWhere("askwer_section.name", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.style_option', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.element_configuration', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.comment_allow', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
