<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductInventory extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_inventory';

    protected $fillable = array(
        'business_id',//*
        'avarage_kardex_value',
        'tax',
        'quantity_units',
        'sale_price',//*
        'total_price',
        'product_id',//*
        'tax_id',//*
        'profit',//*
        'profit_type',//*
        'note',
        'sale_price2',//*
        'sale_price3',//*
        'sale_price4'//*

    );
    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'avarage_kardex_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'tax', 'type' => 'string', 'defaultValue' => 'NO', 'required' => 'false'],
        ['column' => 'quantity_units', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'sale_price', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'total_price', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'tax_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'profit', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'profit_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'note', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'sale_price2', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'sale_price3', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'sale_price4', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'sale_price';

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",
            "avarage_kardex_value" => "numeric",
            "quantity_units" => "numeric",
            "sale_price" => "required|numeric",
            "total_price" => "numeric",
            "product_id" => "required|numeric",
            "tax_id" => "required|numeric",
            "profit" => "required|numeric",
            "profit_type" => "required|numeric",
            "sale_price2" => "required|numeric",
            "sale_price3" => "required|numeric",
            "sale_price4" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.business_id,$this->table.avarage_kardex_value,$this->table.tax,$this->table.quantity_units,$this->table.sale_price,$this->table.total_price,product.code as product,
product.id as product_id,
tax.value as tax,
tax.id as tax_id,
$this->table.profit,$this->table.profit_type,$this->table.note,$this->table.sale_price2,$this->table.sale_price3,$this->table.sale_price4";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.avarage_kardex_value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.tax', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity_units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.total_price', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("tax.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.profit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.profit_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.note', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price2', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price3', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price4', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'ProductInventory';
            $model = new ProductInventory();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ProductInventory::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $productInventoryData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productInventoryData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  ProductInventory.";
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
        $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.avarage_kardex_value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.tax', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity_units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.total_price', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("tax.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.profit', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.profit_type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.note', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price2', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price3', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.sale_price4', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }


    public function getListProductISales($params)
    {
        $search_value = $params["filters"]["search_value"];
        $entidad_data_id = $params["filters"]["entidad_data_id"]; //d qien es
        $tableCurrentMain = $this->table;
        $tableCurrentSecond = 'product';
        $tableCurrentThird = 'product_measure_type';
        $tableCurrentFour = 'tax';
        $tableCurrentFive = 'product_by_details';

        $text = ' ' . $tableCurrentSecond . '.code codigo,' . $tableCurrentSecond . '.is_service,' . $tableCurrentSecond . '.name nombre,' . $tableCurrentSecond . '.description descripcion';
        $selectString = $tableCurrentMain . '.id row_gestion_id,' . $tableCurrentMain . '.quantity_units cantidad_unidades,' . $tableCurrentMain . '.profit ganancia, ' . $tableCurrentMain . '.business_id establecimiento_id,  ' . $tableCurrentMain . '.avarage_kardex_value valor_kardex_promedio,' . $tableCurrentMain . '.sale_price precio_venta,' . $tableCurrentMain . '.sale_price precio_venta1, ' . $tableCurrentMain . '.sale_price2 precio_venta2, ' . $tableCurrentMain . '.sale_price3 precio_venta3, ' . $tableCurrentMain . '.quantity_units inventario,' . $tableCurrentMain . '.total_price precio_total ,' . $tableCurrentMain . '.product_id id,  ROUND((( (' . $tableCurrentMain . '.sale_price*' . $tableCurrentFour . '.percentage)/100)+' . $tableCurrentMain . '.sale_price) , 2) precio_unitario
,' . $text . ',' . $tableCurrentSecond . '.code codigo,CONCAT(' . $tableCurrentSecond . '.name, " ",' . $tableCurrentSecond . '.description) detalle
,' . $tableCurrentFour . '.percentage porcentaje_iva,' . $tableCurrentFour . '.id iva_id,' . $tableCurrentFour . '.percentage porcentaje, ' . $tableCurrentFour . '.id as id_iva
,' . $tableCurrentThird . '.id ptm_id,' . $tableCurrentThird . '.value ptm_name,' . $tableCurrentThird . '.unit ptm_type_box,' . $tableCurrentThird . '.number_of_units ptm_type_box_units';


        $query = DB::table($this->table);

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin($tableCurrentSecond, $tableCurrentMain . '.product_id', '=', $tableCurrentSecond . '.id');
        $query->leftJoin($tableCurrentThird, $tableCurrentSecond . '.product_measure_type_id', '=', $tableCurrentThird . '.id');
        $query->leftJoin($tableCurrentFive, $tableCurrentSecond . '.id', '=', $tableCurrentFive . '.product_id');
        $query->leftJoin($tableCurrentFour, $tableCurrentFive . '.tax_id', '=', $tableCurrentFour . '.id');
        $query->where($tableCurrentMain . '.business_id', '=', $entidad_data_id);
        $query->where($tableCurrentMain . '.quantity_units', '>', 0);
        $query->where($tableCurrentMain . '.sale_price', '>', 0);
        $query->where($tableCurrentSecond . '.is_service', '=', 0);


        if ($search_value) {
            $likeSet = $search_value;
            $tablesCurrents = [
                'tableCurrentMain' => $tableCurrentMain,
                'tableCurrentSecond' => $tableCurrentSecond,
                'tableCurrentThird' => $tableCurrentThird,
                'tableCurrentFour' => $tableCurrentFour,
                'tableCurrentFive' => $tableCurrentFive,

            ];
            $query->where(function ($query) use ($likeSet, $tablesCurrents
            ) {
                $query->where($tablesCurrents['tableCurrentMain'] . '.codigo', 'like', '%' . $likeSet . '%');
                $query->orWhere($tablesCurrents['tableCurrentSecond'] . '.nombre', 'like', '%' . $likeSet . '%');
                $query->orWhere($tablesCurrents['tableCurrentSecond'] . '.descripcion', 'like', '%' . $likeSet . '%');

            });
        }
        $query->limit(50);
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListProductSSales($params)
    {

        $search_value = $params["filters"]["search_value"];
        $entidad_data_id = $params["filters"]["entidad_data_id"]; //d qien es
        $tableCurrentMain = $this->table;
        $tableCurrentSecond = 'product';
        $tableCurrentThird = 'product_measure_type';
        $tableCurrentFour = 'tax';
        $tableCurrentFive = 'product_by_details';
        $tableCurrentSix = 'business_by_services';
        $tableCurrentSeven = 'accounting_account';


        $text = ' ' . $tableCurrentSecond . '.code codigo,' . $tableCurrentSecond . '.is_service,' . $tableCurrentSecond . '.name nombre,' . $tableCurrentSecond . '.description descripcion';
        $selectString = $tableCurrentMain . '.id row_gestion_id,' . $tableCurrentMain . '.quantity_units cantidad_unidades,' . $tableCurrentMain . '.profit ganancia, ' . $tableCurrentMain . '.business_id establecimiento_id,' . $tableCurrentMain . '.sale_price precio_venta,' . $tableCurrentMain . '.sale_price precio_venta1, ' . $tableCurrentMain . '.sale_price2 precio_venta2, ' . $tableCurrentMain . '.sale_price3 precio_venta3, ' . $tableCurrentMain . '.total_price precio_total ,' . $tableCurrentMain . '.product_id id,  ROUND((( (' . $tableCurrentMain . '.sale_price*' . $tableCurrentFour . '.percentage)/100)+' . $tableCurrentMain . '.sale_price) , 2) precio_unitario
,' . $text . ',' . $tableCurrentSecond . '.code codigo,CONCAT(' . $tableCurrentSecond . '.name, " ",' . $tableCurrentSecond . '.description) detalle
,' . $tableCurrentFour . '.percentage porcentaje_iva,' . $tableCurrentFour . '.id iva_id,' . $tableCurrentFour . '.percentage porcentaje, ' . $tableCurrentFour . '.id as id_iva
,' . $tableCurrentThird . '.id ptm_id,' . $tableCurrentThird . '.value ptm_name,' . $tableCurrentThird . '.unit ptm_type_box,' . $tableCurrentThird . '.number_of_units ptm_type_box_units
,' . $tableCurrentSeven . '.value nivel_4 ,' . $tableCurrentSeven . '.description cuenta_contable ,' . $tableCurrentSeven . '.id cuenta_contable_id,' . $tableCurrentSeven . '.value cuenta_contable_codigo,' . $tableCurrentSeven . '.id contabilidad_cuenta_id';


        $query = DB::table($this->table);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin($tableCurrentSecond, $tableCurrentMain . '.product_id', '=', $tableCurrentSecond . '.id');
        $query->leftJoin($tableCurrentThird, $tableCurrentSecond . '.product_measure_type_id', '=', $tableCurrentThird . '.id');
        $query->leftJoin($tableCurrentFive, $tableCurrentSecond . '.id', '=', $tableCurrentFive . '.product_id');
        $query->leftJoin($tableCurrentFour, $tableCurrentFive . '.tax_id', '=', $tableCurrentFour . '.id');
        $query->leftJoin($tableCurrentSix, $tableCurrentMain . '.product_id', '=', $tableCurrentSix . '.product_id');
        $query->leftJoin($tableCurrentSeven, $tableCurrentSix . '.accounting_account_id', '=', $tableCurrentSeven . '.id');

        $query->where($tableCurrentMain . '.business_id', '=', $entidad_data_id);
        $query->where($tableCurrentMain . '.sale_price', '>', 0);
        $query->where($tableCurrentSecond . '.is_service', '=', 1);

        if ($search_value) {
            $likeSet = $search_value;
            $tablesCurrents = [
                'tableCurrentMain' => $tableCurrentMain,
                'tableCurrentSecond' => $tableCurrentSecond,
                'tableCurrentThird' => $tableCurrentThird,
                'tableCurrentFour' => $tableCurrentFour,
                'tableCurrentFive' => $tableCurrentFive,

            ];
            $query->where(function ($query) use ($likeSet, $tablesCurrents
            ) {
                $query->where($tablesCurrents['tableCurrentMain'] . '.codigo', 'like', '%' . $likeSet . '%');
                $query->orWhere($tablesCurrents['tableCurrentSecond'] . '.nombre', 'like', '%' . $likeSet . '%');
                $query->orWhere($tablesCurrents['tableCurrentSecond'] . '.descripcion', 'like', '%' . $likeSet . '%');

            });
        }
        $query->limit(50);
        $result = $query->get()->toArray();
        return $result;
    }

    public function saveManagerAnnulment($params)
    {
        $result = array();

        $haystack = $params["haystack"];
        $factura_id = $params["invoiceId"];
        $dateAnnulment = isset($params["dateAnnulment"]) ? $params["dateAnnulment"] : \App\Utils\Util::DateCurrent();

        $codeInvoice = $params["codeInvoice"];
        $type = $params["type"];
        $typeInvoiceDocument = $params["typeInvoiceDocument"];

        $entidad_data_id = $params["entidad_data_id"];

        $success = count($haystack) == 0 ? false : true;

        $msj = "Ningun Registro existente Producto Inventario";

        $dataConfig = array();
        $errors = array();
        $products = array(
            "inventoryData" => array(),
            "otherData" => array(),

        );
        foreach ($haystack as $keyAS => $rowCurrent) {
            $row = (array)$rowCurrent;
            $setPushPush = array();
            $type_product = $row["type_product"];
            $setPushPush = $row;
            if ($type_product == "0") {
                $products["inventoryData"][] = $setPushPush;
            } else {
                $products["otherData"][] = $setPushPush;

            }

        }
        $success = count($haystack) == 0 ? false : true;

        if (count($products['inventoryData']) == 0) {
            $dataConfig['inventoryDataCount'] = 0;

            $success = true;
        }
        if (count($products['otherData']) == 0) {
            $dataConfig['otherDataCount'] = 0;


        }

        $modelKP = new \App\Models\AverageKardex();

        $modelPHP = new \App\Models\ProductInventoryByPriceUnityBox();

        $dateCurrent = $dateAnnulment;
        $fecha_factura = $dateCurrent;
        $codigo_documento = $codeInvoice;
        $modelPI = new \App\Models\ProductInventory();
        $UtilAccounting = new \App\Utils\Accounting\UtilAccounting;
        foreach ($products["inventoryData"] as $keyAS => $row) {
            $cantidad = $row["cantidad"];
            $precio_unitario = $row["precio_unitario"];
            $discount = $row["porcentaje_descuento"];
            $totalDiscount = $precio_unitario - ($precio_unitario * $discount / 100);
            $total = $row["total"];
            $producto_id = $row["producto_id"];
            $precio_venta = $precio_unitario;
            $porcentaje_descuento = $discount;
            /*  'business_id',//*
          'avarage_kardex_value',
          'tax',
          'quantity_units',
          'sale_price',//*
          'total_price',
          'product_id',//*
          'tax_id',//*
          'profit',//*
          'profit_type',//*
          'note',
          'sale_price2',//*
          'sale_price3',//*
          'sale_price4'//**/
            $params_data_search = array('product_id' => $producto_id, "business_id" => $entidad_data_id);
            $model_pi = $modelPI->findByAttributes($params_data_search);

            if ($model_pi) {
                /* KARDEX CURRENT*/
                $currentKardexProduct = $modelKP->getCurrentKardexProduct(array("product_id" => $producto_id, "entidad_data_id" => $entidad_data_id));

                $id_inventario = $model_pi->id;
                $tipo_ganancia = $model_pi->profit_type;
                $allowUpdatePrices = false;
                $pricesData = array();

                if ($tipo_ganancia == "0") {
                    $allowUpdatePrices = true;

                    $pricesData = $modelPHP->getPricesByProduct(array("producto_inventario_id" => $id_inventario));
                }

                $entidad_id = $factura_id;
                $entidad = $type == "buy" ? "invoice_buy" : "invoice_sale";
                $detailsTransaction = "Anulacion " . $typeInvoiceDocument;
                $paramsCurrent = array(
                    "dataKardexCurrent" => $currentKardexProduct,
                    "cantidad" => $cantidad,
                    "descuento" => $porcentaje_descuento,
                    "precio" => $precio_venta,
                    "type" => $type,
                    "producto_id" => $producto_id,
                    "entidad_data_id" => $entidad_data_id,
                    "entidad_id" => $entidad_id,
                    "entidad" => $entidad,
                    "entidad_fecha" => $fecha_factura,
                    "documentInformation" => $codigo_documento,
                    "detailsTransaction" => $detailsTransaction,
                    "process" => "annulment"
                );

                $resultKardex = $modelKP->managementInputsOutputsInventory($paramsCurrent);

                if ($resultKardex["success"]) {
                    $cantidad_unidades = $resultKardex["modelKardex"]["existing_amount"];
                    $valor_kardex_promedio = $resultKardex["modelKardex"]["existing_punitary"];
                    $precio_total = $resultKardex["modelKardex"]["existing_ptotal"];


                    $idCurrent = $model_pi->id;
                    $model_pi = new  \App\Models\ProductInventory();
                    $model_pi = $model_pi->find($idCurrent);
                    $model_pi->quantity_units = $cantidad_unidades;
                    $model_pi->avarage_kardex_value = $valor_kardex_promedio;
                    $model_pi->total_price = $precio_total;
                    $validatePICurrent = $model_pi->validate();
                    $validatePI = $validatePICurrent['success'];

                    if ($validatePI) {
                        $resultSave=$model_pi->save();

                        if ($type == "buy") {
                            if ($allowUpdatePrices) {
                                $roundManager = $UtilAccounting::managerRound;
                                $precio_venta = 0;
                                $precio_venta1 = 0;
                                $precio_venta2 = 0;
                                $precio_venta3 = 0;

                                foreach ($pricesData as $key => $price) {
                                    $priceCurrent = $valor_kardex_promedio + ($price["utilidad"] * $valor_kardex_promedio / 100);
                                    $priceCurrent = number_format($priceCurrent, $roundManager, '.', '');
                                    $pricesData[$key]["precio"] = $priceCurrent;
                                }


                                foreach ($pricesData as $key => $price) {
                                    $priceCurrent = $price["precio"];
                                    if ($price["prioridad"] == 1) {
                                        $precio_venta = $priceCurrent;
                                        $precio_venta1 = $priceCurrent;
                                    } else if ($price["prioridad"] == 2) {
                                        $precio_venta2 = $priceCurrent;
                                    } else if ($price["prioridad"] == 3) {
                                        $precio_venta3 = $priceCurrent;
                                    }
                                }
                                $attributes = array(
                                    "precio_venta" => $precio_venta,
                                    "precio_venta1" => $precio_venta1,
                                    "precio_venta2" => $precio_venta2,
                                    "precio_venta3" => $precio_venta3,
                                    "tipo_ganancia" => $tipo_ganancia

                                );
                                $model_pi->attributes = $attributes;

                                $success = $model_pi->validate();
                                if ($success) {
                                    $model_pi->save();
                                    foreach ($pricesData as $key => $price) {
                                        $idCurrent = $price["id"];
                                        $modelPHP = ProductoHasPrecios::model()->findByPk($idCurrent);
                                        $modelPHP->attributes = $price;
                                        $success = $modelPHP->validate();

                                        if ($success) {
                                            $modelPHP->save();
                                        } else {
                                            $success = false;
                                            $msj = "Producto Inventario has prices actualizado ";
                                            $errors = $modelPHP->errors;
                                            break;
                                        }
                                    }

                                } else {
                                    $success = false;
                                    $msj = "Producto Inventario no actualizado prices";
                                    $errors = $model_pi->errors;
                                    break;
                                }


                            }
                        }
                    } else {
                        $success = false;
                        $msj = "Producto Inventario no actualizado";
                        $errors = $model_pi->errors;
                        break;
                    }
                } else {
                    $success = false;
                    $msj = "Kardex no actualizado";
                    $errors = $resultKardex["errors"];
                    break;
                }
            } else {
                $success = false;
                $msj = "No existe producto en el sistema.";
                $errors = array();
                break;
            }

        }

        $result["msj"] = $msj;
        $result["success"] = $success;
        $result["dataConfig"] = $dataConfig;

        $result["errors"] = $errors;


        return $result;
    }

}
