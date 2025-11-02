<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Multimedia;

class GamificationTypeActivity extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'gamification_type_activity';
    const SHARE_ID = 1;
    const SUBSCRIBE_ID = 2;
    const REFER_ID = 3;
    const CHECK_IN_ID = 4;
    const BUY_ID = 5;
    const PAYMENTS_ID = 6;

    protected $fillable = array(
        'source',//*
        'title',//*
        'subtitle',
        'description',//*
        'state',//*
        'has_source',//*
        'url_manager'//*

    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'has_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'url_manager', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'source';

    public static function getRulesModel()
    {
        $rules = ["source" => "required|max:350",
            "title" => "required",
            "description" => "required",
            "state" => "required",
            "has_source" => "required|numeric",
            "url_manager" => "required"
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

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.url_manager";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');


            });
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
            $modelName = 'GamificationTypeActivity';
            $model = new GamificationTypeActivity();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = GamificationTypeActivity::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $gamificationTypeActivityData = $attributesPost;
            $source = $gamificationTypeActivityData["source"];
            $pathSet = "/uploads/gamification/gamificationTypeActivity";
            $change = $gamificationTypeActivityData["change"];
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


                $source = $successMultimediaModel['source'];
                $gamificationTypeActivityData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $gamificationTypeActivityData, 'attributesData' => $this->attributesData));
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
                    $msj = "Problemas al guardar  GamificationTypeActivity.";
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
        $textValue = $this->table . '.title';
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
            //    $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');


            });

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataFrontend($params)
    {
        $sort = 'asc';
        $field = 'title';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.url_manager";
        $select = DB::raw($selectString);
        $query->select($select);

// sort
        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();


        return $result;
    }

}
