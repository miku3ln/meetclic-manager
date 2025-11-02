<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class AccountingConfigModulesAccountByAccount extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'accounting_config_modules_account_by_account';



    //-----------CAJA Y BANCOS 5----
    static $caja_general = 1;
    static $cheques_por_cobrar = 2;
    static $cheques_por_pagar = 3;
    static $caja_chica = 44;
    static $tarjeta_de_credito = 45;
    //-----------COMPRAS 21----
    static $iva_pagado = 4;
    static $ice_pagado = 5;
    static $descuento_en_compras = 6;
    static $descuento_solidario_en_compras = 7;
    static $retencion_iva_10p = 8;
    static $retencion_iva_20p = 9;
    static $retencion_iva_30p = 10;
    static $retencion_iva_70p = 11;
    static $retencion_iva_100p = 12;
    static $retencion_renta_1p = 13;
    static $retencion_renta_2p = 14;
    static $retencion_renta_5p = 15;
    static $retencion_renta_8p = 16;
    static $retencion_renta_10p = 17;
    static $otras_retenciones = 18;
    static $cuentas_por_pagar = 19; //SOLO L ASIGNE PERO ESTA VRIABLE S TOMARA DE LAS TIPOS PAGOS & CUENTAS $cxp_id
    static $anticipo_a_proveedores = 20;
    static $devolucion_de_compra = 21;
    static $proveedores = 42;
    static $transportes_fletes = 43;
    static $operationalCosts = 49;
    /*static $retencion_renta = 49;
    static $documentos_por_pagar = 51;*/
    //-----------INVENTARIOS 7----
    static $inventario_y_mercaderias = 22;
    static $sobrantes_de_inventario = 23;
    static $faltantes_de_inventario = 24;
    static $inventario_en_transito = 25;
    static $inventario_en_produccion = 26;
    static $costo_mano_obra = 27;
    static $costo_indirectos = 28;
    //-----------VENTAS 16----
    static $costo_de_ventas = 29;
    static $cuentas_por_cobrar = 30;
    static $retenciones_iva = 31;
    static $retenciones_renta = 32;
    static $ventas_con_iva_gravado = 33;
    static $ventas_tarifa_0p = 34;
    static $iva_cobrado = 35;
    static $descuento_en_ventas = 36;
    static $descuento_solidario_ventas = 37;
    static $anticipo_clientes = 38;
    static $ice_cobrado = 39;
    static $devolucion_de_venta_con_iva_gravado = 40;
    static $devolucion_de_venta_con_iva_0p = 41;
    static $clientes = 46;
    static $ventas = 47;
    static $servicesProvided = 48;

    /*static $documentos_por_cobrar = 52;
    static $devolucion_de_ventas = 50;*/
//--------TIPOS DE PAGOS--
    static $efectivo_id = 1; //$lvl_4_Caja
    static $tarjeta_de_credito_id = 2; //$instituciones_financieras
    static $cheque_id = 3; //bancos
    static $transferencia_bancarias_id = 4; //bancos
    static $dinero_electronico_id = 5; //
    static $tarjeta_de_debito_id = 6;
    static $tarjeta_prepago_id = 7;
//-------------PARENTS ROOTS---
//    no pertenece ala configuracion de cuentas si
//    **Cuentas id contabilidad_cuenta
    static $costos_ingresos = 130; //
    static $costo_de_venta_inventario = 134;
    protected $fillable = array(
        'accounting_account_id',//*
        'description',//*
        'code',//*
        'accounting_config_modules_types_id',//*
        'type_of_income',//*
        'status'//*

    );
    protected $attributesData = [
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'accounting_config_modules_types_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_of_income', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = ["accounting_account_id" => "required|numeric",
            "description" => "required",
            "code" => "required|max:45",
            "accounting_config_modules_types_id" => "required|numeric",
            "type_of_income" => "required|numeric",
            "status" => "required"
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

        $selectString = "$this->table.id,accounting_account.value as accounting_account,
accounting_account.id as accounting_account_id,
$this->table.description,$this->table.code,accounting_config_modules_types.value as accounting_config_modules_types,
accounting_config_modules_types.id as accounting_config_modules_types_id,
$this->table.type_of_income,$this->table.status";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('accounting_config_modules_types', 'accounting_config_modules_types.id', '=', $this->table . '.accounting_config_modules_types_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_config_modules_types.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_of_income', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'AccountingConfigModulesAccountByAccount';
            $model = new AccountingConfigModulesAccountByAccount();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AccountingConfigModulesAccountByAccount::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $accountingConfigModulesAccountByAccountData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $accountingConfigModulesAccountByAccountData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AccountingConfigModulesAccountByAccount.";
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
        $field = $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->field_main as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('accounting_config_modules_types', 'accounting_config_modules_types.id', '=', $this->table . '.accounting_config_modules_types_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_config_modules_types.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_of_income', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
    public function getConfigAccountsSystem()
    {
        $result = array(
            //-----------CAJA Y BANCOS----
            array(
                'id' => self::$caja_general,
                "text" => "Caja General",
            ),
            array(
                'id' => self::$cheques_por_cobrar,
                "text" => "Cheques por Cobrar",
            ),
            array(
                'id' => self::$cheques_por_pagar,
                "text" => "Cheques por Pagar",
            ),
            array(
                'id' => self::$caja_chica,
                "text" => "Caja Chica",
            ),
            array(
                'id' => self::$tarjeta_de_credito,
                "text" => "Tarjeta de Credito",
            ),
            //-----------COMPRAS----

            array(
                'id' => self::$iva_pagado,
                "text" => "Iva Pagado",
            ),
            array(
                'id' => self::$ice_pagado,
                "text" => "Ice Pagado",
            ),
            array(
                'id' => self::$descuento_en_compras,
                "text" => "Descuento en Compras",
            ),
            array(
                'id' => self::$descuento_solidario_en_compras,
                "text" => "Descuento solidario en compras",
            ),
            array(
                'id' => self::$retencion_iva_10p,
                "text" => "Retencion iva 10p",
            ),
            array(
                'id' => self::$retencion_iva_20p,
                "text" => "Retencion iva 20p",
            ),
            array(
                'id' => self::$retencion_iva_30p,
                "text" => "Retencion iva 30p",
            ),
            array(
                'id' => self::$retencion_iva_70p,
                "text" => "Retencion iva 70p",
            ),
            array(
                'id' => self::$retencion_iva_100p,
                "text" => "Retencion iva 100p",
            ),
            /*  array(
                  'id' => self::$retencion_renta_1p,
                  "text" => "Retencion renta 1p",
              ),*/
            array(
                'id' => self::$retencion_renta_2p,
                "text" => "Retencion renta 2p",
            ),
            array(
                'id' => self::$retencion_renta_5p,
                "text" => "Retencion renta 5p",
            ),
            array(
                'id' => self::$retencion_renta_8p,
                "text" => "Retencion renta 8p",
            ),
            array(
                'id' => self::$retencion_renta_10p,
                "text" => "Retencion renta 10p",
            ),
            array(
                'id' => self::$otras_retenciones,
                "text" => "Otras Retenciones",
            ),
            array(
                'id' => self::$cuentas_por_pagar,
                "text" => "Cuentas por pagar",
            ),
            array(
                'id' => self::$anticipo_a_proveedores,
                "text" => "Anticipo Proveedores",
            ),
            array(
                'id' => self::$devolucion_de_compra,
                "text" => "Devolucion de compra",
            ),
            array(
                'id' => self::$proveedores,
                "text" => "Proveeedores",
            ),
            array(
                'id' => self::$transportes_fletes,
                "text" => "Transporte Fletes",
            ),
            /*  array(
                  'id' => self::$retencion_iva_pagado,
                  "text" => "Retencion IVA PAGADO",
              ),*/
            /* array(
                 'id' => self::$retencion_renta,
                 "text" => "Retencion Renta",
             ),*/
            /* array(
                 'id' => self::$documentos_por_pagar,
                 "text" => "Documentos por pagar",
             ),*/
            //-----------INVENTARIOS----
            array(
                'id' => self::$inventario_y_mercaderias,
                "text" => "Inventario y Mercaderias",
            ),
            array(
                'id' => self::$sobrantes_de_inventario,
                "text" => "Sobrantes de Inventario",
            ),
            array(
                'id' => self::$faltantes_de_inventario,
                "text" => "Faltantes de Inventario",
            ),
            array(
                'id' => self::$inventario_en_transito,
                "text" => "Inventario en Transito",
            ),
            array(
                'id' => self::$inventario_en_produccion,
                "text" => "Inventario en produccion",
            ),
            array(
                'id' => self::$costo_mano_obra,
                "text" => "Costo mano de obra",
            ),
            array(
                'id' => self::$costo_indirectos,
                "text" => "Costos Indirectos",
            ),
            //-----------VENTAS----
            array(
                'id' => self::$costo_de_ventas,
                "text" => "Costo de Ventas",
            ),
            array(
                'id' => self::$cuentas_por_cobrar,
                "text" => "Cuentas por Cobrar",
            ),
            array(
                'id' => self::$retenciones_iva,
                "text" => "Retenciones Iva",
            ),
            array(
                'id' => self::$retenciones_renta,
                "text" => "Retenciones Renta",
            ),
            array(
                'id' => self::$ventas_con_iva_gravado,
                "text" => "Ventas Con iva gravado",
            ),
            array(
                'id' => self::$ventas_tarifa_0p,
                "text" => "Ventas tarifa 0P",
            ),
            array(
                'id' => self::$iva_cobrado,
                "text" => "Iva cobrado",
            ),
            array(
                'id' => self::$descuento_en_ventas,
                "text" => "Descuento en ventas",
            ),
            array(
                'id' => self::$descuento_solidario_ventas,
                "text" => "Descuento solidario ventas",
            ),
            array(
                'id' => self::$anticipo_clientes,
                "text" => "Anticipo clientes",
            ),
            array(
                'id' => self::$ice_cobrado,
                "text" => "Ice cobrado",
            ),
            array(
                'id' => self::$devolucion_de_venta_con_iva_gravado,
                "text" => "Devolucion de venta con iva gravado",
            ),
            array(
                'id' => self::$devolucion_de_venta_con_iva_0p,
                "text" => "Devolucion de venta con iva 0p",
            ),
            array(
                'id' => self::$clientes,
                "text" => "Clientes",
            ),
            array(
                'id' => self::$ventas,
                "text" => "Ventas",
            ),
            /*   array(
                   'id' => self::$documentos_por_cobrar,
                   "text" => "Documentos por cobrar",
               ),*/
            /*   array(
                   'id' => self::$devolucion_de_ventas,
                   "text" => "Devolucion de ventas",
               ),*/

            array(
                'id' => self::$costos_ingresos,
                "text" => "Costos Ingresos",
            ),
            array(
                'id' => self::$costo_de_venta_inventario,
                "text" => "Costo de venta inventario",
            )
        ,
            array(
                'id' => self::$servicesProvided,
                "text" => "Servicios Prestados",
            )


        );


        return $result;
    }

}
