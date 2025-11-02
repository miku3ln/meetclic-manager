<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EventsTrailsByKit extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_by_kit';

    protected $fillable = array(
        'entity_type',//*
        'entity_id',//*
        'status',//*
        'events_trails_project_id'//*

    );
    protected $attributesData = [
        ['column' => 'entity_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'events_trails_project_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'status';

    public static function getRulesModel()
    {
        $rules = ["entity_type" => "required|numeric",
            "entity_id" => "required|numeric",
            "status" => "required",
            "events_trails_project_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }
        $tableEntity = 'product';
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$this->table.id,$this->table.entity_type as entity ,$this->table.entity_type,$this->table.entity_id,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
";
        $selectString .= ",$tableEntity.view_online,$tableEntity.code,$tableEntity.name,$tableEntity.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$tableEntity.source,$tableEntity.description,$tableEntity.code_provider,$tableEntity.code_product,$tableEntity.has_tax,$tableEntity.is_service,$tableEntity.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage";


        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join($tableEntity, $tableEntity . '.id', '=', $this->table . '.entity_id');

        $query->join('business_by_products', $tableEntity . '.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $tableEntity . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $this->table . '.id');
        $query->join('product_category', 'product_category.id', '=', $tableEntity . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $tableEntity . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $tableEntity . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $tableEntity . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($tableEntity . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($tableEntity . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($tableEntity . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($tableEntity . '.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }
        $query->where('business_by_products.business_id', '=', $business_id);
        $events_trails_project_id = isset($params['filters']['events_trails_project_id']) ? $params['filters']['events_trails_project_id'] : null;
        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);

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

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);

        $modelColor = new \App\Models\ProductByColor();
        $modelSize = new \App\Models\ProductBySizes();

        foreach ($result['rows'] as $key => $row) {
            $entity_id = $row->entity_id;
            $entity_type = $row->entity_type;
            $dataRow = (array)$row;
            $product_id = $entity_id;
            $result['rows'][$key] = $dataRow;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;

        }


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
            $modelName = 'EventsTrailsByKit';
            $model = new EventsTrailsByKit();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsByKit::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $eventsTrailsByKitData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsByKitData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EventsTrailsByKit.";
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
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getKitsByEvent($params)
    {
        $result = $this->getManagementKitsByEvent($params);

        $modelColor = new \App\Models\ProductByColor();
        $modelSize = new \App\Models\ProductBySizes();
        foreach ($result as $key => $row) {
            $entity_id = $row->entity_id;
            $entity_type = $row->entity_type;
            $dataRow = (array)$row;
            $product_id = $entity_id;
            $result[$key] = $dataRow;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result[$key]['colors'] = $colors;
            $result[$key]['sizes'] = $sizes;

        }


        return $result;
    }

    public function getManagementKitsByEvent($params)

    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $tableEntity = 'product';
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$this->table.id,$this->table.entity_type as entity ,$this->table.entity_type,$this->table.entity_id,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
";
        $selectString .= ",$tableEntity.view_online,$tableEntity.code,$tableEntity.name,$tableEntity.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$tableEntity.source,$tableEntity.description,$tableEntity.code_provider,$tableEntity.code_product,$tableEntity.has_tax,$tableEntity.is_service,$tableEntity.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join($tableEntity, $tableEntity . '.id', '=', $this->table . '.entity_id');
        $query->join('business_by_products', $tableEntity . '.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $tableEntity . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $this->table . '.id');
        $query->join('product_category', 'product_category.id', '=', $tableEntity . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $tableEntity . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $tableEntity . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $tableEntity . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');


        $query->where('business_by_products.business_id', '=', $business_id);
        $events_trails_project_id = isset($params['filters']['events_trails_project_id']) ? $params['filters']['events_trails_project_id'] : null;
        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);


        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();


        return $result;

    }
}
