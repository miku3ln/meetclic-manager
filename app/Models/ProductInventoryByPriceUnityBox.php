<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductInventoryByPriceUnityBox extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_inventory_by_price_unity_box';

    protected $fillable = array(
        'price',//*
        'product_inventory_id',//*
        'priority',//*
        'utility'//*

    );
    protected $attributesData = [
        ['column' => 'price', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_inventory_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'priority', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'utility', 'type' => 'double', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'price';

    public static function getRulesModel()
    {
        $rules = ["price" => "required|numeric",
            "product_inventory_id" => "required|numeric",
            "priority" => "required|numeric",
            "utility" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.price,product_inventory.sale_price as product_inventory,
product_inventory.id as product_inventory_id,
$this->table.priority,$this->table.utility";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_inventory', 'product_inventory.id', '=', $this->table . '.product_inventory_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_inventory.sale_price", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.priority', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.utility', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'ProductInventoryByPriceUnityBox';
            $model = new ProductInventoryByPriceUnityBox();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ProductInventoryByPriceUnityBox::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $productInventoryByPriceUnityBoxData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productInventoryByPriceUnityBoxData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  ProductInventoryByPriceUnityBox.";
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
        $query->join('product_inventory', 'product_inventory.id', '=', $this->table . '.product_inventory_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_inventory.sale_price", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.priority', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.utility', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveProductsInventoryProcessInvoice($params)
    {
        $createUpdate = $params["createUpdate"];
        $producto_tipo_medida_id = $params["producto_tipo_medida_id"];
        $pd_control_stock_inicial = $params["pd_control_stock_inicial"];
        $has_unity_box = $params["has_unity_box"];
        $precio_unity_box = $params["precio_unity_box"];
        $producto_inventario_id = $params["producto_inventario_id"];
        $typeInvoice = $params["typeInvoice"];

        $success = true;
        $msj = "";
        $errors = array();
        $modelManagerPTM = new \App\Models\ProductMeasureType();
        $modelManagerPBUI = new \App\Models\ ProductByUnityInventory();
        $modelManagerPIBPUB = new \App\Models\ ProductInventoryByPriceUnityBox();

        if ($createUpdate) {//create
            if ($producto_tipo_medida_id != "") {
                if ($pd_control_stock_inicial == "1") {
                    $modelPTM = $modelManagerPTM->findByPk($producto_tipo_medida_id);
                    if ($modelPTM->unit == 0) {
                        if ($has_unity_box == true) {
                            if ($precio_unity_box != null) {

                                $grid_rows_by_price = array(
                                    array(


                                        'price' => $precio_unity_box,//*
                                        'product_inventory_id' => $producto_inventario_id,//*
                                        'priority' => 1,//*
                                        'utility' => 10//*

                                    )
                                );

                                foreach ($grid_rows_by_price as $key => $value) {
                                    $precio = $value["price"];
                                    $utilidad = $value["utility"];
                                    $prioridad = $value["priority"];
                                    $data_push = array(
                                        "price" => $precio,
                                        "utility" => $utilidad,
                                        "priority" => $prioridad,
                                        "product_inventory_id" => $producto_inventario_id,
                                    );

                                    $model_php = new \App\Models\ ProductInventoryByPriceUnityBox();
                                    $model_php->attributes = $data_push;
                                    $entidad_position = "ProductoHasPrecios";
                                    $managerValidate = $model_php->validate();
                                    if ($managerValidate['success']) {
                                        $model_php->fill($data_push);
                                        $model_php->save();
                                    } else {

                                        $success = false;
                                        $errors = $managerValidate['errors'];
                                        $msj = "Error Prices ProductByPriceUnityBox";
                                        break;

                                    }
                                }
                            }

                        }


                        $modelPBPUB = new \App\Models\ ProductByUnityInventory();

                        $result['success'] = true;
                        $units = $modelPTM->number_of_units * $params["cantidad"];
                        $paramsSave = array(
                            "units" => $units,
                            "product_inventory_id" => $producto_inventario_id,

                        );
                        $modelPBPUB->attributes = $paramsSave;
                        $managerValidate = $modelPBPUB->validate();
                        if ($managerValidate['success']) {
                            $modelPBPUB->fill($paramsSave);
                            $modelPBPUB->save();

                        } else {

                            $success = false;
                            $errors = $managerValidate['errors'];
                            $msj = "Error Prices ProductByUnityInventory";


                        }
                    }
                }
            }
        } else {
            $pbpb_id = $params["pbpb_id"];
            if ($producto_tipo_medida_id != "") {
                if ($pd_control_stock_inicial == "1") {
                    $modelPTM = $modelManagerPTM->findByPk($producto_tipo_medida_id);

                    if ($modelPTM->unit == 0) {
                        if ($has_unity_box == true) {

                            if ($precio_unity_box != null) {

                                $grid_rows_by_price = array(
                                    array(
                                        'price' => $precio_unity_box,//*
                                        'product_inventory_id' => $producto_inventario_id,//*
                                        'priority' => 1,//*
                                        'utility' => 10//*
                                    )
                                );
                                if ($typeInvoice == "buy") {


                                    foreach ($grid_rows_by_price as $key => $value) {
                                        $id = $pbpb_id;
                                        $precio = $value["price"];
                                        $utilidad = $value["utility"];
                                        $prioridad = $value["priority"];
                                        $data_push = array(
                                            "price" => $precio,
                                            "utility" => $utilidad,
                                            "priority" => $prioridad,
                                            "product_inventory_id" => $producto_inventario_id,
                                        );
                                        $model_php = $modelManagerPIBPUB->findByPk($id);
                                        $model_php->attributes = $data_push;
                                        $managerValidate = $model_php->validate();

                                        if ($managerValidate['success']) {
                                            $model_php->fill($data_push);
                                            $model_php->save();
                                            $result['success'] = true;
                                        } else {
                                            $success = false;
                                            $errors = $managerValidate['errors'];
                                            $msj = "Error Prices Has";
                                            break;
                                        }
                                    }
                                } else {

                                }

                                $modelPBPUB = $modelManagerPBUI->findByAttributes(array(
                                    "product_inventory_id" => $producto_inventario_id
                                ));
                                $result['success'] = true;
                                $units = 0;
                                if ($typeInvoice == "buy") {
                                    $units = $modelPBPUB->units + ($modelPTM->number_of_units * $params["cantidad"]);
                                    $paramsSave = array(
                                        "units" => $units,
                                        "product_inventory_id" => $producto_inventario_id,

                                    );


                                    $modelPBPUB->attributes = $paramsSave;

                                    $managerValidate =$modelPBPUB->validate();

                                    if ($managerValidate['success']) {
                                        $modelPBPUB->fill($paramsSave);
                                        $modelPBPUB->save();

                                    } else {

                                        $success = false;
                                        $errors =$managerValidate['errors'];
                                        $msj = "Error Prices ProductByUnityInventory Update";


                                    }
                                } else {

                                    $managerTypeContent = $params["managerTypeContent"];
                                    if ($managerTypeContent == 0) {

                                        $unitsRegisterBDD = $modelPBPUB->units;
                                        $unitsCurrent = ($modelPTM->number_of_units * $params["cantidad"]);
                                        if ($unitsCurrent > $unitsRegisterBDD) {
                                            $success = false;
                                            $errors = array();
                                            $msj = "Error Units not Inventory";
                                        } else {
                                            $paramsSave = array(
                                                "units" => $units,
                                                "product_inventory_id" => $producto_inventario_id,

                                            );
                                            $modelPBPUB->attributes = $paramsSave;

                                            $managerValidate =$modelPBPUB->validate();

                                            if ($managerValidate['success']) {
                                                $modelPBPUB->fill($paramsSave);
                                                $modelPBPUB->save();

                                            } else {

                                                $success = false;
                                                $errors = $managerValidate['errors'];
                                                $msj = "Error Prices ProductByUnityInventory Update";


                                            }
                                        }
                                    } else {
                                        //sale by units of content box
                                        $unitsRegisterBDD = $modelPBPUB->units;

                                        $boxUnityCurrent = $params["cantidad"] / $modelPTM->number_of_units;
                                        $unitsCurrent = ($params["cantidad"]);

                                        if ($unitsCurrent > $unitsRegisterBDD) {
                                            $success = false;
                                            $errors = array();
                                            $msj = "Error Units not Inventory";
                                        } else {
                                            $units = $unitsRegisterBDD - $unitsCurrent;
                                            $paramsSave = array(
                                                "units" => $units,
                                                "producto_inventario_id" => $producto_inventario_id,

                                            );
                                            $modelPBPUB->attributes = $paramsSave;

                                            $managerValidate =$modelPBPUB->validate();

                                            if ($managerValidate['success']) {
                                                $modelPBPUB->save();

                                            } else {

                                                $success = false;
                                                $errors = $managerValidate['errors'];
                                                $msj = "Error Prices ProductByUnityInventory Update";


                                            }
                                        }
                                    }


                                }

                            }

                        }
                    }
                }
            }
        }
        $result = array(
            "success" => $success,
            "msj" => $msj,
            "errors" => $errors
        );
        return $result;

    }
    public function getPricesByProduct($params)
    {
        $producto_inventario_id = $params["producto_inventario_id"];
        $textValue = $this->table . '.' . $this->field_main;
        $field = 'priority';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.price precio,$this->table.product_inventory_id producto_inventario_id,$this->table.priority prioridad,$this->table.utility utilidad";
        $select = DB::raw($selectString);
        $query->select($select);

        $query->where($this->table . '.product_inventory_id', '=', $producto_inventario_id);
        $query->orderBy($field, 'ASC');
        $result = $query->get()->toArray();
        return $result;

    }
}
