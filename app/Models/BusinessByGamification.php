<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Gamification;


class BusinessByGamification extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_gamification';

    protected $fillable = array(
        'gamification_id',//*
        'business_id',//*
        'allow_exchange',//*
        'allow_exchange_business',//*
        'state'//*

    );
    protected $attributesData = [
        ['column' => 'gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'allow_exchange', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'allow_exchange_business', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'state';

    public static function getRulesModel()
    {
        $rules = ["gamification_id" => "required|numeric",
            "business_id" => "required|numeric",
            "allow_exchange" => "required|numeric",
            "allow_exchange_business" => "required|numeric",
            "state" => "required"
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

        $selectString = "$this->table.id,gamification.value ,
gamification.id as gamification_id,gamification.value_unit,gamification.description,
business.title as business,
business.id as business_id,
$this->table.allow_exchange,$this->table.allow_exchange_business,$this->table.state";
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($business_id) {
        $query->where($this->table . '.business_id', '=', $business_id);

        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where("gamification.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessByGamification';
            $model = new BusinessByGamification();
            $modelChildren = new Gamification();

            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByGamification::find($attributesPost[$modelName]['id']);
                $modelChildren = Gamification::find($attributesPost[$modelName]['gamification_id']);

                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $attributesSet = [
                'value' => $attributesPost[$modelName]['value'],
                'description' => $attributesPost[$modelName]['description'],
                'value_unit' => $attributesPost[$modelName]['value_unit'],
                'state' => $attributesPost[$modelName]['state'],

            ];
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => Gamification::getRulesModel(),

            );
            $validateResult = Gamification::validateModel($paramsValidate);
            $success = $validateResult["success"];

            if ($success) {
                $modelChildren->fill($attributesSet);
                $success = $modelChildren->save();
                $gamification_id = $modelChildren->id;
                $businessByGamificationData = $attributesPost[$modelName];
                $attributesSet = $businessByGamificationData;
                $attributesSet['gamification_id'] = $gamification_id;
                $attributesSet['allow_exchange_business'] = $attributesPost[$modelName]['allow_exchange_business'];
                $attributesSet['allow_exchange'] = $attributesPost[$modelName]['allow_exchange'];


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
                    $msj = "Problemas al guardar  BusinessByGamification.";
                    $errors = $validateResult["errors"];
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar  Gamificacion.";
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
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_exchange', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_exchange_business', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getGamificationFrontend($params)
    {
        $sort = 'asc';
        $field = 'title';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,gamification.value ,
gamification.id as gamification_id,gamification.value_unit,gamification.description,
business.title as business,
business.id as business_id,
$this->table.allow_exchange,$this->table.allow_exchange_business,$this->table.state";
        $business_id = $params['filters']['business_id'];

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);

        $query->orderBy($field, $sort);

        $result = $query->get()->first();
        return $result;
    }


}
