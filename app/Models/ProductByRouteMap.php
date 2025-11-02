<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class ProductByRouteMap extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_by_route_map';

    protected $fillable = array(
        'product_id',//*
        'routes_map_id'//*

    );
    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'routes_map_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["product_id" => "required|numeric",
            "routes_map_id" => "required|numeric"
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

        $selectString = "$this->table.id,product.code as product,
product.id as product_id,
routes_map.name as routes_map,
routes_map.id as routes_map_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('routes_map', 'routes_map.id', '=', $this->table . '.routes_map_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
                $query->orWhere("routes_map.name", 'like', '%' . $likeSet . '%');
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
        $data = [];
        DB::beginTransaction();
        try {
            $modelName = 'ProductByRouteMap';
            $model = new ProductByRouteMap();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ProductByRouteMap::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $productByRouteMapData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productByRouteMapData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $data['attributes'] = $model->attributes;
            } else {
                $success = false;
                $msj = "Problemas al guardar  ProductByRouteMap.";
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
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('routes_map', 'routes_map.id', '=', $this->table . '.routes_map_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
                $query->orWhere("routes_map.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getRouteProduct($params)
    {
        $success = true;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        $data = [];


        $createUpdate = true;

        $model = ProductByRouteMap::findByAttribute('product_id',$attributesPost['product_id']);
        $data = [];
        $success = $model != false;
        if ($success) {

            $modelManagement = new \App\Models\BusinessByRoutesMap();
            $routes_map_id=$model->routes_map_id;
            $data = $modelManagement->getDataRoute([
                'filters' => [
                    'id' => $routes_map_id
                ]
            ]);
            $data['product_by_route_map_id']=$model->id;

        } else {
            $success = true;
            $msj = "Problemas al obtener  ProductByRouteMap.";

        }

        $result = [
            "errors" => $errors,
            "msj" => $msj,
            "success" => $success,
            'data' => $data
        ];


        return ($result);


    }
    public function deleteRouteProduct($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        $data = [];

        $model = ProductByRouteMap::find($attributesPost['id']);
        $data = [];
        $success = $model != false;
        if ($success) {
            $model->delete();
        } else {
            $success = false;
            $msj = "Problemas al eliminar  Croquis.";

        }
        $result = [
            "errors" => $errors,
            "msj" => $msj,
            "success" => $success,
            'data' => $data
        ];


        return ($result);


    }
}
