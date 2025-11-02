<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\TemplateContactUs;

class TemplateConfigMailingByEmails extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_config_mailing_by_emails';

    protected $fillable = array(
        'email',//*
        'type',//*
        'template_information_id'//*

    );
    protected $attributesData = [
        ['column' => 'email', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'email';

    public static function getRulesModel()
    {
        $rules = ["email" => "required|email|max:150",
            "type" => "required|numeric",
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
        $template_information_id = $params['filters']['template_information_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.email,$this->table.type";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.email', 'like', '%' . $likeSet . '%');


        }
        $query->where($this->table . '.template_information_id', '=', $template_information_id);

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
        $data = array();

        DB::beginTransaction();
        try {
            $modelName = 'TemplateConfigMailingByEmails';
            $model = new TemplateConfigMailingByEmails();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TemplateConfigMailingByEmails::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $templateConfigMailingByEmailsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateConfigMailingByEmailsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  TemplateConfigMailingByEmails.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {

                $modelTCU = new TemplateContactUs();
                $business_id = $templateConfigMailingByEmailsData['business_id'];
                $template_information_id = $templateConfigMailingByEmailsData['template_information_id'];
                $data = $modelTCU->getContactUsData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,

                    ]

                ]);
                $data['business_id'] = $business_id;
                $data['model_id'] = $template_information_id;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                "data" => $data
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
        $query->join('template_config_mailing', 'template_config_mailing.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.email', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_config_mailing.user", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function deleteFrontend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        DB::beginTransaction();
        try {
            $modelName = 'TemplateConfigMailingByEmails';

            $model = TemplateConfigMailingByEmails::find($attributesPost[$modelName]['id']);
            $success = $model->delete();
            if ($success) {

            } else {
                $success = false;
                $msj = "Problemas al eliminar .";
                $errors = 'No se elimino.';
            }
            $attributesPost = $attributesPost[$modelName];

            if (!$success) {
                DB::rollBack();

            } else {
                $modelTCU = new TemplateContactUs();
                $business_id = $attributesPost['business_id'];
                $template_information_id = $attributesPost['template_information_id'];

                $data = $modelTCU->getContactUsData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,

                    ]

                ]);
                $data['business_id'] = $business_id;
                $data['model_id'] = $template_information_id;

                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data
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

    public function getListEmailsByBusiness($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.email";
        $select = DB::raw($selectString);
        $business_id = $params['filters']['business_id'];
        $type = $params['filters']['type'];

        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        $query->where($this->table . '.type', '=', $type);
        $query->where('template_information.business_id', '=', $business_id);

        $resultData = $query->get()->toArray();
        $result = [];
        foreach ($resultData as $key => $row) {

            $setPush = $row->email;
            $result[$key] = $setPush;
        }
        return $result;

    }

    public function getEmailByBusiness($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.email";
        $select = DB::raw($selectString);
        $business_id = $params['filters']['business_id'];
        $type = $params['filters']['type'];
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        $query->where($this->table . '.type', '=', $type);
        $query->where('template_information.business_id', '=', $business_id);
        $result = $query->get()->count() == 0 ? false : true;


        return $result;

    }
}
