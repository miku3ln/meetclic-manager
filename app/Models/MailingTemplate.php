<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class MailingTemplate extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'mailing_template';

    protected $fillable = array(
        'business_id',//*
        'name',//*
        'message',//*
        'status',//*
        'user_id',//*
        'source_main',//*
        'type_template'//*

    );
    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'message', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source_main', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_template', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",
            "name" => "required|max:150",
            "message" => "required",
            "status" => "required",
            "user_id" => "required|numeric",
            "source_main" => "required|max:250",
            "type_template" => "required|numeric"
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

        $selectString = "$this->table.id,business.title as business,
business.id as business_id,
$this->table.name,$this->table.message,$this->table.status,$this->table.user_id,$this->table.source_main,$this->table.type_template";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.message', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.source_main', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_template', 'like', '%' . $likeSet . '%');
            });;

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
        $user = Auth::user();

        try {
            $modelName = 'MailingTemplate';
            $model = new MailingTemplate();
            $modelMultimedia = new \App\Models\Multimedia;

            $createUpdate = true;
            $auxResource = "";

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = MailingTemplate::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source_main;

            } else {
                $createUpdate = true;
            }


            $dataManager = $attributesPost;
            $source = $dataManager["source_main"];
            $pathSet = "/uploads/mailing/templates";
            $change = $dataManager["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {

                $source = $successMultimediaModel['sourceServer'];

                $mailingTemplateData = $attributesPost;
                $mailingTemplateData['source_main'] = $source;
                $attributesSet = $mailingTemplateData;
                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  MailingTemplate.";
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


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


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

        $business_id = $params["filters"]['business_id'];
        $selectString = "$this->table.id,$textValue as text ,$this->table.name, $this->table.message, $this->table.source_main, $this->table.type_template";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.message', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.source_main', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_template', 'like', '%' . $likeSet . '%');
            });;

        }
        $query->where('business_id', '=', $business_id);
        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
