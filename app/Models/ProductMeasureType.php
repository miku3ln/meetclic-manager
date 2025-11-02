<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductMeasureType extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_measure_type';
    const DEFAULT_ID = 1;

    protected $fillable = array(
        'value',//*
        'state',//*
        'description',
        'abbreviation',
        'unit',
        'number_of_units',
        'prefix',//*
        'symbol',
        'business_id',

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'abbreviation', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'unit', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'number_of_units', 'type' => 'double', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'prefix', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'symbol', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:100",
            "state" => "required",
            "abbreviation" => "max:100",
            "unit" => "numeric",
            "number_of_units" => "numeric",
            "prefix" => "required|max:10",
            "symbol" => "max:10"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.description,$this->table.abbreviation,$this->table.unit,$this->table.number_of_units,$this->table.prefix,$this->table.symbol";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.abbreviation', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.unit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.number_of_units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.prefix', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.symbol', 'like', '%' . $likeSet . '%');;

        }
        $business_id = isset($params['filters']['business_id'])?$params['filters']['business_id']:null;
        if ($business_id) {

            $query->where($this->table . '.business_id', '=', $business_id);

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
            $modelName = 'ProductMeasureType';
            $model = new ProductMeasureType();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ProductMeasureType::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $productMeasureTypeData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productMeasureTypeData, 'attributesData' => $this->attributesData));
            $business_id = isset($attributesPost[$modelName]['business_id'])?$attributesPost[$modelName]['business_id']:0;
            $attributesSet['business_id']=$business_id;
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
                $msj = "Problemas al guardar  ProductMeasureType.";
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
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.abbreviation', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.unit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.number_of_units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.prefix', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.symbol', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $resultData = $query->get()->toArray();
        $result = $resultData;
       /* foreach ($resultData as $key => $row) {
            $model = ProductMeasureType::find($row->id);
            $setPush = json_decode(json_encode($row), true);
            $relations = $model->measurementSubtype->pluck('name', 'id')->toArray();
            $setPush['relations'] = $relations;
            $result[] = $setPush;

        }*/

        return $result;

    }

    public function measurementSubtype()
    {
        return $this->belongsToMany(ProductMeasurementSubtype::class, 'product_measure_by_subtype', 'product_measure_type_id', 'product_measurement_subtype_id');
    }
}
