<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class RepairByDetailsParts extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'repair_by_details_parts';

    protected $fillable = array(
        'repair_id',//*
        'quantity',//*
        'product_color_id',//*
        'repair_product_by_business_id',//*
        'product_trademark_id'//*

    );
    protected $attributesData = [
        ['column' => 'repair_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'quantity', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_color_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'repair_product_by_business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_trademark_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["repair_id" => "required|numeric",
            "quantity" => "required|numeric",
            "product_color_id" => "required|numeric",
            "repair_product_by_business_id" => "required|numeric",
            "product_trademark_id" => "required|numeric"
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

        $selectString = "$this->table.id,repair.register_manager_date as repair,
repair.id as repair_id,
$this->table.quantity,product_color.value as product_color,
product_color.id as product_color_id,
repair_product_by_business.name as repair_product_by_business,
repair_product_by_business.id as repair_product_by_business_id,
product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('repair', 'repair.id', '=', $this->table . '.repair_id');
        $query->join('product_color', 'product_color.id', '=', $this->table . '.product_color_id');
        $query->join('repair_product_by_business', 'repair_product_by_business.id', '=', $this->table . '.repair_product_by_business_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("repair.register_manager_date", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_color.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("repair_product_by_business.name", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');;

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
            $modelName = 'RepairByDetailsParts';
            $model = new RepairByDetailsParts();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = RepairByDetailsParts::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $repairByDetailsPartsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $repairByDetailsPartsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  RepairByDetailsParts.";
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
        $query->join('repair', 'repair.id', '=', $this->table . '.repair_id');
        $query->join('product_color', 'product_color.id', '=', $this->table . '.product_color_id');
        $query->join('repair_product_by_business', 'repair_product_by_business.id', '=', $this->table . '.repair_product_by_business_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("repair.register_manager_date", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_color.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("repair_product_by_business.name", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDetailsParts($params)
    {

        $repair_id = $params['filters']['repair_id'];
        $selectString = "$this->table.id,
$this->table.quantity,product_color.value as product_color,
product_color.id as product_color_id,
repair_product_by_business.name as repair_product_by_business,
repair_product_by_business.id as repair_product_by_business_id,
product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id";
        $query = DB::table($this->table);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_color', 'product_color.id', '=', $this->table . '.product_color_id');
        $query->join('repair_product_by_business', 'repair_product_by_business.id', '=', $this->table . '.repair_product_by_business_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->where($this->table . '.repair_id', '=', $repair_id);

        $result = $query->get()->toArray();
        return $result;

    }
}
