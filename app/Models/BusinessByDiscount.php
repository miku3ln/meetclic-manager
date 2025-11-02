<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class BusinessByDiscount extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_discount';


    const TYPE_PERCENTAGE = 0;
    const TYPE_AMOUNT_FIX = 1;
    const TYPE_FREE_SHIPPING = 2;
    const TYPE_BUY_X_GET_Y = 3;

    const TYPE_APPLY_COMPLETE_ORDER = 1;
    const TYPE_ADD_CUSTOMERS_NONE = 0;
    const TYPE_ADD_SELECT_CUSTOMERS = 1;
    const TYPE_ADD_SELECT_GROUP_CUSTOMERS = 1;

    const TYPE_APPLY_PRODUCTS = 0;


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
        'created_at',
        'updated_at',
        'deleted_at'

    );
    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_apply', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'value', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_limit', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'has_limit_end', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'limit_init', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'limit_end', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'minimum_requirements', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'apply_amount_min_products', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'amount_min_use', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_add_customers', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'code';

    public function products()
    {
        $parentKeyCurrent = 'business_by_discount_id';
        $childrenKeyCurrent = 'product_id';
        $childrenClass = BusinessByDiscount::class;
        $childrenTable = 'discount_by_products';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    public static function getTypes()
    {
        return [
            [
                "id" => self:: TYPE_PERCENTAGE, 'text' => 'Porcentaje',
            ],
            [
                "id" => self:: TYPE_AMOUNT_FIX, 'text' => 'Valor Fijo',
            ],
            [

                "id" => self:: TYPE_FREE_SHIPPING, "text" => 'Envio Gratuito',
            ],
            [

                "id" => self:: TYPE_BUY_X_GET_Y, "text" => 'Compra X y Obtiene Y',


            ]

        ];
    }

    public static function getTypesApply()
    {
        return [
            [
                "id" => self:: TYPE_APPLY_COMPLETE_ORDER, 'text' => 'Orden Completa',
            ],
            [
                "id" => self:: TYPE_APPLY_PRODUCTS, 'text' => 'Aplicar a Productos',
            ],


        ];
    }

    public static function getRulesModel()
    {
        $rules = ["code" => "required|max:150",
            "name" => "required",
            "type" => "required|numeric",
            "type_apply" => "required|numeric",
            "value" => "required|numeric",
            "has_limit" => "required|numeric",
            "has_limit_end" => "required|numeric",
            "business_id" => "required|numeric",
            "minimum_requirements" => "required|numeric",
            "apply_amount_min_products" => "required|numeric",
            "amount_min_use" => "required|numeric",
            "type_add_customers" => "required|numeric",
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

        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.type,$this->table.type_apply,$this->table.value,$this->table.has_limit,$this->table.has_limit_end,$this->table.limit_init,$this->table.limit_end,business.title as business,
business.id as business_id,
$this->table.minimum_requirements,$this->table.apply_amount_min_products,$this->table.amount_min_use,$this->table.type_add_customers,$this->table.state,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at
,(SELECT COUNT(discount_by_products.business_by_discount_id)  FROM discount_by_products where business_by_discount.id=discount_by_products.business_by_discount_id ) total";

        $select = DB::raw($selectString);

        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_apply', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_limit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_limit_end', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.limit_init', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.limit_end', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.minimum_requirements', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.apply_amount_min_products', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.amount_min_use', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_add_customers', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'BusinessByDiscount';
            $model = new BusinessByDiscount();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByDiscount::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessByDiscountData = $attributesPost[$modelName];
            if ($createUpdate) {
                $businessByDiscountData['code'] = isset($businessByDiscountData['code']) ? $businessByDiscountData['code'] : uniqid('CODE-');
            }
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessByDiscountData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();

                $keys_manager = $attributesPost[$modelName]['products_id_data'];
                $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                $model->products()->sync($keys_manager);
            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByDiscount.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_apply', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_limit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_limit_end', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.limit_init', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.limit_end', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.minimum_requirements', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.apply_amount_min_products', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.amount_min_use', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_add_customers', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
