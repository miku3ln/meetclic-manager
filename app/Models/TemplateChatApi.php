<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class TemplateChatApi extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const TYPE_FACEBOOK = 0;

    protected $table = 'template_chat_api';

    protected $fillable = array(
        'type',//*
        'options',//*
        'page_id',
        'allow',//*
        'template_information_id'//*

    );
    protected $attributesData = [
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'options', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'page_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'allow', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'options';

    public static function getRulesModel()
    {
        $rules = ["type" => "required|numeric",
            "options" => "required",
            "page_id" => "max:45",
            "allow" => "required|numeric",
            "template_information_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.type,$this->table.options,$this->table.page_id,$this->table.allow,template_information.value as template_information,
template_information.id as template_information_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.page_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');;

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
        $data = [];
        DB::beginTransaction();
        try {
            $modelName = 'TemplateChatApi';
            $model = new TemplateChatApi();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TemplateChatApi::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $templateChatApiData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateChatApiData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();

                $template_information_id = $model->template_information_id;
                $paramsCurrent['filters'] = [
                    'template_information_id' => $template_information_id
                ];
                $paramsCurrent['filters']['type'] = self::TYPE_FACEBOOK;
                $logoMain = $this->getChatTypeFrontend($paramsCurrent);
                $data['manager']['facebook'] = $logoMain;
                $data['attributes'] = $attributesSet;
                $data['attributes']['type'] = $model->type;
                $data['attributes']['id'] = $model->id;
            } else {
                $success = false;
                $msj = "Problemas al guardar  TemplateChatApi.";
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
                "success" => $success,
                'data' => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
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
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.page_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getChatTypeFrontend($params)
    {
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.template_information_id,$this->table.options,$this->table.page_id,$this->table.allow,$this->table.type";
        $select = DB::raw($selectString);
        $query->select($select);
        $allow = 1;
        $template_information_id = $params['filters']['template_information_id'];
        $type = $params['filters']['type'];
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $query->where($this->table . '.type', '=', $type);
        $query->where($this->table . '.allow', '=', $allow);

        $result = $query->first();
        return $result;

    }

    public function getChatsTypesData($params)
    {
        $result = [];
        $paramsCurrent = $params;
        $paramsCurrent['filters']['type'] = self::TYPE_FACEBOOK;
        $logoMain = $this->getChatTypeFrontend($paramsCurrent);
        $result['facebook'] = $logoMain;
        return $result;

    }
}
