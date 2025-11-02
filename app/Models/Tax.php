<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class Tax extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    public $business_id;
    protected $fillable = array('name', 'value', 'status',

        'value',//*
        'percentage',//*
        'state'//*

    );
    public $timestamps = false;


    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'tax';

    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'percentage', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];


    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:45",
            "percentage" => "required|numeric",
            "state" => "required"
        ];
        return $rules;
    }

    public function citiesByTax()
    {
        return $this->hasMany(TaxByCity::class, 'tax_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'taxes_by_cities', 'tax_id', 'city_id');
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

        $selectString = "$this->table.id,$this->table.value,$this->table.percentage,$this->table.state";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.percentage', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'Tax';
            $model = new Tax();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = Tax::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $taxData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $taxData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  Tax.";
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
        $business_id = $params['filters']['business_id'];


        $query->where($this->table . '.percentage', '>', 0);
        $this->business_id = $business_id;
        $query->whereNotIn($this->table . '.id', function ($query) {

            $selectString = "tax_by_business.tax_id id";
            $select = DB::raw($selectString);
            $business_id=$this->business_id;
            $query->select($select)
                ->from('tax_by_business');
            $query->where('tax_by_business.business_id', '=', $business_id);

        });
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.percentage', 'like', '%' . $likeSet . '%');

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
}
