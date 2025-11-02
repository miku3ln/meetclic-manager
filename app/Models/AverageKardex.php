<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class AverageKardex extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'average_kardex';
    const entrada = 0;
    const salidad = 1;
    const DEBE = 0;
    const HABER = 1;
    const INPUT = 0;
    const OUTPUT = 1;
    protected $fillable = array(
        'units',//*
        'price',//*
        'total',//*
        'created_at',
        'product_id',//*
        'income_type',//*
        'business_id',//*
        'transaction_details',
        'entity_id',
        'entity',
        'existing_amount',//*
        'existing_punitary',//*
        'existing_ptotal',//*
        'entity_date'

    );
    protected $attributesData = [
        ['column' => 'units', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'price', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'total', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'income_type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'transaction_details', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'entity', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'existing_amount', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'existing_punitary', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'existing_ptotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'price';

    public static function getRulesModel()
    {
        $rules = [
            "units" => "required|numeric",
            "price" => "required|numeric",
            "total" => "required|numeric",
            "product_id" => "required|numeric",
            "income_type" => "required|numeric",
            "business_id" => "required|numeric",
            "entity_id" => "numeric",
            "entity" => "max:45",
            "existing_amount" => "required|numeric",
            "existing_punitary" => "required|numeric",
            "existing_ptotal" => "required|numeric"
        ];
        return $rules;
    }


    public $keysManagerFieldsAfter = [];

    /*MANAGER MAINS*/
    public function __construct(array $params = [])
    {
        $this->keysManagerFieldsAfter = [
            'units' => 'unidades',//*
            'price' => 'precio',//*
            'total' => 'total',//*
            'created_at' => 'fecha_creacion',
            'product_id' => 'producto_id',//*
            'income_type' => 'tipo_ingreso',//*
            'business_id' => 'entidad_data_id',//*
            'transaction_details' => 'detalle_transaccion',
            'entity_id' => 'entidad_id',
            'entity' => 'entidad',
            'existing_amount' => 'cantidad_existente',//*
            'existing_punitary' => "punitario_existente",//*
            'existing_ptotal' => 'ptotal_existente',//*
            'entity_date' => 'entidad_fecha'
        ];

    }

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

        $selectString = "$this->table.id,$this->table.units,$this->table.price,$this->table.total,$this->table.created_at,product.code as product,
product.id as product_id,
$this->table.income_type,business.title as business,
business.id as business_id,
$this->table.transaction_details,$this->table.entity_id,$this->table.entity,$this->table.existing_amount,$this->table.existing_punitary,$this->table.existing_ptotal,$this->table.entity_date";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.income_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.transaction_details', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_amount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_punitary', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_ptotal', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_date', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'AverageKardex';
            $model = new AverageKardex();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AverageKardex::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $averageKardexData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $averageKardexData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AverageKardex.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.units', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.income_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.transaction_details', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_amount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_punitary', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.existing_ptotal', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_date', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getCurrentKardexProduct($params)
    {
        $product_id = $params["product_id"];
        $business_id = $params["entidad_data_id"];

        $selectString = "  $this->table.id,  $this->table.units unidades,$this->table.price precio,$this->table.total,$this->table.created_at fecha_creacion,$this->table.product_id producto_id,$this->table.income_type tipo_ingreso,$this->table.business_id entidad_data_id,$this->table.transaction_details detalle_transaccion,$this->table.entity_id entidad_id,$this->table.entity entidad,$this->table.existing_amount cantidad_existente,$this->table.existing_punitary punitario_existente,$this->table.existing_ptotal ptotal_existente,$this->table.entity_date entidad_fecha,$this->table.units unidades_parent,$this->table.existing_amount cantidad_existente_parent";
        $field = $this->table . '.created_at';
        $query = DB::table($this->table);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->where($this->table . '.product_id', '=', $product_id);
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->limit(1)->orderBy($field, 'DESC');
        $resultQuery = $query->first();
        $result = null;
        if ($resultQuery) {
            $result = (array)$resultQuery;
        }

        return $result;

    }

    public function managementInputsOutputsInventory($params)
    {


        $success = false;
        $modelKardex = null;
        $roundManager = \App\Utils\Accounting\UtilAccounting::managerRound;
        $created_at = \App\Utils\Util::DateCurrent();
        $processAnnulment = isset($params["process"]);
        $detalle_transaccion = "";
        $dataKardexCurrent = $params["dataKardexCurrent"];
        $cantidadIO = $params["cantidad"];//input-output
        $descuentoIO = $params["descuento"];//input-output
        $precioIO = $params["precio"];//input-output

        $producto_id = $params["producto_id"];
        $entidad_data_id = $params["entidad_data_id"];
        $entidad_id = $params["entidad_id"];
        $entidad = $params["entidad"];
        $entidad_fecha = $params["entidad_fecha"];

        $detailsTransaction = isset($params["detailsTransaction"]) ? $params["detailsTransaction"] : null;


        /*KARDEX CURRENT*/
        $valorKardexSet = 0;
        $cantidad_existente = isset($dataKardexCurrent["cantidad_existente"]) ? $dataKardexCurrent["cantidad_existente"] : 0;

        $type = $params["type"];
        $tipo_ingreso = self::DEBE;//entrada
        $precio = -1;
        $total = 0;
        $unidades = $cantidadIO;
        $cantidad_existente = 0;
        $p_unitario_existente = 0;
        $ptotal_existente = 0;


        $precio_unitario = $precioIO;
        $subtotal = $precio_unitario * $cantidadIO;
        $precio_kardex = 0;
        $subt_kardex = 0;
        $ganancia = 0;

        $documentInformation = $params["documentInformation"];
        $hasProduct = true;

        $price_unitary_exist_manager = 0;
        $amount_exist_manager = 0;
        $ptotal_exist_manager = 0;
        $typeManagerInputOutput = true;//input=true,output=false
        $income_type = isset($params["income_type"]) ? $params["income_type"] : null;
        if ($income_type == null) {
            if ($type == "sale") {
                $typeManagerInputOutput = false;

                $detalle_transaccion = $detailsTransaction == null ? ("Egreso de Mercaderia por Ventas " . $documentInformation) : $detailsTransaction . " " . $documentInformation;
            } else if ($type == "buy") {
                $typeManagerInputOutput = true;

                $detalle_transaccion = $detailsTransaction == null ? ("Ingreso de Mercaderia por Compras" . $documentInformation) : $detailsTransaction . " " . $documentInformation;
            }

        } else {
            $typeManagerInputOutput = $income_type;
            $detalle_transaccion = 'Sin especificacion';

            if ($detailsTransaction) {
                $detalle_transaccion = $detailsTransaction;

            }

        }

        if (isset($dataKardexCurrent['punitario_existente'])) {
            $price_unitary_exist_manager = $dataKardexCurrent["punitario_existente"];
            $amount_exist_manager = $dataKardexCurrent["cantidad_existente"];
            $ptotal_exist_manager = $dataKardexCurrent["ptotal_existente"];
        } else {

        }

        if (!$typeManagerInputOutput) {
            $measure_id = null;
            $measure_type_box = null;
            $measure_box_units = null;
            $managerTypeContent = isset($params["managerTypeContent"]) ? $params["managerTypeContent"] : 0;
            if (isset($params["measure_id"])) {
                $measure_id = $params["measure_id"];
                $measure_type_box = $params["measure_type_box"];
                $measure_box_units = $params["measure_box_units"];
            } else {

                /*  $producto_id=$params['producto_id'];
                  $modelP = new Producto();
                  $dataProduct = $modelP->getInformationProduct(array(
                      'id'=>$producto_id
                  ));

                  if ($dataProduct == false) {
                      $hasProduct = false;
                  } else {
                      $hasProduct = true;
                      $measure_id = $dataProduct["measure_id"];
                      $measure_type_box = $dataProduct["measure_type_box"];
                      $measure_box_units = $dataProduct["measure_box_units"];
                  }*/

            }

            $tipo_ingreso = self::HABER;//salida
            if ($managerTypeContent == 0) {//normal

                $p_unitario_existente = $price_unitary_exist_manager;
                $cantidad_existente = $amount_exist_manager - $cantidadIO;
                $ptotal_existente = $p_unitario_existente * $cantidad_existente;
                $precio = $p_unitario_existente;
                $total = $unidades * $precio;
                $precio_kardex = $precio;

            } else {//units of box
                if ($measure_type_box == 0) {//box with units
                    $modelPTMC = new \App\Models\ProductMeasureType();
                    $modelPTM = $modelPTMC->findByPk($measure_id);
                    $boxUnityCurrent = $cantidadIO / $modelPTM->cantidad_unidades;
                    $p_unitario_existente = $price_unitary_exist_manager;
                    $cantidad_existente = $amount_exist_manager - $boxUnityCurrent;
                    $ptotal_existente = $p_unitario_existente * $cantidad_existente;
                    $precio = $p_unitario_existente;
                    $total = $boxUnityCurrent * $precio;
                    $precio_kardex = $precio;
                    $unidades = $boxUnityCurrent;
                    $cantidadIO = $boxUnityCurrent;
                }

            }

        } else {


            $tipo_ingreso = self::DEBE;//entrada
            /*    CHANGE PRICE*/
            $subtotalIO = $cantidadIO * $precioIO;
            $valorDescuentoIO = $subtotalIO * $descuentoIO / 100;
            $totalCurrent = $subtotalIO - $valorDescuentoIO;
            $precio = $totalCurrent / $cantidadIO;
            $total = $precio * $cantidadIO;
            $cantidad_existente = $amount_exist_manager + $cantidadIO;
            $ptotal_existente = $ptotal_exist_manager + $total;
            $p_unitario_existente = $ptotal_existente / $cantidad_existente;
            $precio_kardex = $p_unitario_existente;
        }

        if ($processAnnulment) {
            $valorDescuentoIO = $precio_unitario * $descuentoIO / 100;
            $totalCurrent = $precio_unitario - $valorDescuentoIO;
            $precio = $totalCurrent;
            $total = $precio * $cantidadIO;
            $cantidad_existente = $amount_exist_manager - $unidades;
            $ptotal_existente = $ptotal_exist_manager - $total;
            if ($type == $typeManagerInputOutput) {
                $cantidad_existente = $amount_exist_manager + $unidades;
                $ptotal_existente = $ptotal_exist_manager + $total;
            }
            $p_unitario_existente = $ptotal_existente / $cantidad_existente;
        }


        $subt_kardex = number_format(($precio_kardex * $cantidadIO), $roundManager, '.', '');
        $ganancia = number_format(($subtotal - $subt_kardex), $roundManager, '.', '');

        $keysManagerFieldsAfter = $this->keysManagerFieldsAfter;
        $attributes = array(
            "income_type" => $tipo_ingreso,
            "units" => $unidades,
            "price" => number_format($precio, $roundManager, '.', ''),
            "total" => number_format($total, $roundManager, '.', ''),
            "existing_amount" => number_format($cantidad_existente, $roundManager, '.', ''),
            "existing_punitary" => number_format($p_unitario_existente, $roundManager, '.', ''),
            "existing_ptotal" => number_format($ptotal_existente, $roundManager, '.', ''),
            "transaction_details" => $detalle_transaccion,
            "product_id" => $producto_id,
            "business_id" => $entidad_data_id,
            "entity_id" => $entidad_id,
            "entity" => $entidad,
            "entity_date" => $entidad_fecha,
            'created_at' => $created_at

        );


        $model = new AverageKardex();
        $model->attributes = $attributes;
        $errors = array();
        $successManager = $model->validate();
        $success = $successManager['success'];
        if ($success) {
            $model->fill($attributes);
            $model->save();
            $modelKardex = $model->attributes;
            $success = true;

        } else {
            $errors = $model['errors'];
        }
        $rowKardex = array(
            "precio_unitario" => $precio_unitario,
            "subtotal" => $subtotal,
            "precio_kardex" => $precio_kardex,
            "subt_kardex" => $subt_kardex,
            "ganancia" => $ganancia
        );
        $rowKardex = array_merge($rowKardex, $attributes);
        $result = array(
            "success" => $success,
            "modelKardex" => $modelKardex,
            "errors" => $errors,
            "rowKardex" => $rowKardex
        );
        return $result;
    }

    public function getValuesInputsOutputsInventory($params)
    {
        $result = [];
        $resultKardex = $params['modelKardex'];
        $cantidad_unidades = $resultKardex["existing_amount"];
        $valor_kardex_promedio = $resultKardex["existing_punitary"];
        $precio_total = $resultKardex["existing_ptotal"];
        $result['quantity_units'] = $cantidad_unidades;
        $result['avarage_kardex_value'] = $valor_kardex_promedio;
        $result['total_price'] = $precio_total;
        return $result;
    }
}
