<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;

class BusinessByDiscounts extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_discount';
    const TYPE_PERCENTAGE=0;
    const TYPE_AMOUNT_FIX=1;
    const TYPE_FREE_SHIPPING=2;
    const TYPE_BUY_X_GET_Y=3;

    const TYPE_APPLY_COMPLETE_ORDER=1;
    const TYPE_ADD_CUSTOMERS_NONE=0;
    const TYPE_ADD_SELECT_CUSTOMERS=1;
    const TYPE_ADD_SELECT_GROUP_CUSTOMERS=1;

    const TYPE_APPLY_PRODUCTS=0;


    const HAS_LIMIT_NOT = 0;
    const HAS_LIMIT_YES = 1;
    const HAS_LIMIT_END_NOT = 0;
    const HAS_LIMIT_END_YES = 1;

    const MINIMUM_REQUIREMENTS_NONE = 0;//NONE
    const MINIMUM_REQUIREMENTS_MPA = 1;//Minimum purchase amount
    const MINIMUM_REQUIREMENTS_MQOA = 2;//Minimum quantity of articles

    const AMOUNT_MIN_USE_FOREVER = 0;//FOREVER USES
    const AMOUNT_MIN_USE_LIMIT = 1;//LIMIT USE

    protected $fillable = array(
        'code',//*
        'name',//*
        'type',//*
        'type_apply',//*
        'value',//*
        'has_limit',//*
        'has_limit_end',//*
        'limit_init',
        'limit_end',
        'business_id',//*
        'minimum_requirements',//*
        'apply_amount_min_products',//*
        'amount_min_use',//*
        'type_add_customers',//*
        'state',//*


    );
    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_apply', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'value', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_limit', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_limit_end', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'limit_init', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'limit_end', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'minimum_requirements', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'apply_amount_min_products', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'amount_min_use', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_add_customers', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'state', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = true;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            'code' =>'required|max:150',//*
            'name'=>'required',//*
            'type'=>'required|numeric',//*
            'type_apply'=>'required|numeric',//*
            'value'=>'required|numeric',//*
            'has_limit'=>'required|numeric',//*
            'has_limit_end'=>'required|numeric',//*
            'limit_init'=>'required',
            'limit_end'=>'required',
            'business_id'=>'required|numeric',//*
            'minimum_requirements'=>'required|numeric',//*
            'apply_amount_min_products'=>'required|numeric',//*
            'amount_min_use'=>'required|numeric',//*
            'type_add_customers'=>'required|numeric',//*
            'state'=>'required',//*
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

        $selectString = "$this->table.id,$this->table.name,$this->table.state,$this->table.description,language.value as language,
language.id as language_id,
product.name as product,
product.id as product_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            $query->orWhere("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product.name", 'like', '%' . $likeSet . '%');;

        }
        $entity_name = 'product_id';
        $entity_id = $params['filters'][$entity_name];
        $query->where($this->table . '.' . $entity_name, '=', $entity_id);
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
            $modelName = 'BusinessByDiscounts';
            $model = new BusinessByDiscounts();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByDiscounts::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $BusinessByDiscountsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $BusinessByDiscountsData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];

            $language_id = $attributesPost[$modelName]['language_id'];
            $entity_manager_key = 'product_id';
            $entity_manager_id = $attributesPost[$modelName]['product_id'];

            if ($success) {
                $model->fill($attributesSet);
                if ($attributesSet['state'] == 'ACTIVE') {
                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {

                        $idCurrent = $attributesPost[$modelName]["id"];
                        BusinessByDiscounts::where('state', 'ACTIVE')
                            ->where($entity_manager_key, '=', $entity_manager_id)
                            ->where('language_id', '=', $language_id)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['state' => 'INACTIVE']);
                    } else {
                        BusinessByDiscounts::where('state', 'ACTIVE')
                            ->where($entity_manager_key, '=', $entity_manager_id)
                            ->where('language_id', '=', $language_id)
                            ->update(['state' => 'INACTIVE']);
                    }
                }
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByDiscounts.";
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
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            $query->orWhere("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product.name", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function setDelete($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $id = $params["id"];
        $errors = array();
        DB::beginTransaction();
        try {
            $model = BusinessByDiscounts::find($id);
            if ($model) {
                $success = $model->delete();
                if (!$success) {
                    $msj = 'No se elimino correctamente.';

                } else {
                    $msj = 'Eliminado correctamente.';

                }
            } else {

                $msj = 'No existe informacion.';
            }
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
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
}
