<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductByColor extends ModelManager
{

    protected $table = 'product_by_color';
    protected $fillable = array('product_id', 'product_color_id');
    protected $attributesData = [

    ];
    public $timestamps = false;
    protected $field_main = 'product_id';

    public static function getRulesModel()
    {
        $rules = ["product_id" => "required|numeric",
            "product_color_id" => "required|numeric"
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

        $selectString = "product.code as product,
product.id as product_id,
product_color.value as product_color,
product_color.id as product_color_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('product_color', 'product_color.id', '=', $this->table . '.product_color_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_color.value", 'like', '%' . $likeSet . '%');;

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
            $modelName = 'ProductByColor';
            $model = new ProductByColor();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ProductByColor::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $productByColorData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productByColorData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  ProductByColor.";
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
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('product_color', 'product_color.id', '=', $this->table . '.product_color_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_color.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getColorsProduct($params)
    {

        $product_id = $params['filters']['product_id'];
        $query = DB::table($this->table);
        $table_name_data = 'product_color';
        $orderField = $table_name_data.'.value';
        $table_name_data_key = 'product_color_id';
        $selectString = $table_name_data.".value,".$table_name_data.".value as text ,".$table_name_data.".color,".$table_name_data.".multicolored,".$table_name_data.'.id';
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join($table_name_data, $table_name_data . '.id', '=', $this->table . '.' . $table_name_data_key);
        $query->where($this->table . '.product_id', '=', $product_id);
        $query->orderBy($orderField, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
}
