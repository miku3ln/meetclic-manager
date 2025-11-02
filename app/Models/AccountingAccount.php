<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class AccountingAccount extends ModelManager
{
    public $lb_libro_diario;
    public $cuenta_tarjeta;
    public $cc_referencia;
    public $cc_monto;
    public $cc_efectivo;
    public $cc_tarjeta;
    public $cc_credito;
    public $cc_total_pagar;
    public $cc_total_paga_bancos;
    public $cc_iva;
//    public $pi_precio_compra_iva;
//    public $pi_precio_venta_iva;
    /**
     * @return ContabilidadCuenta
     */
    //    Esto  representa  l id d la tabla config_modules_cuentas
    static $factura_estado_emitido = "ISSUED";
    static $factura_estado_pendiente = "PENDING";
    static $factura_estado_cancelar = "CANCELLED";
    static $type_ingreso_d = 0; //ENTRADA
    static $type_ingreso_h = 1; //SALIDA
    static $caja_id = 1; //ENTRADA  //cuenta general en excell
    static $bancos_id = 2; //ENTRADA  //Banco Produbanco
//    static $bancos_id = 2;
    static $cxp_id = 19;  //OTRAS CUENTAS POR PAGAR ID 95 EN EXCEL;
    static $dxp_id = 51; //DUCUMENTOS POR PAGAR ID 92 EN EXCEL
    static $cxc_id = 30;
    static $dxc_id = 52; //
    static $clientes_id = 46;
//    static $prestamos_id = 7;
    static $caja_chica_id = 44;
    static $ventas_id = 46; //CLIENTES
    static $iva_en_ventas_id = 35; //IVA POR PAGAR
    static $iva_id = 4; //IVA POR COBRAR
    static $descuento_en_ventas_id = 36; //ESTO YA NO SE VA A UTILIZAR EN LA NUEVA VERSION
    static $devolucion_en_ventas_id = 50; //ESTE CUENTA YA NO SE VA UTILIZAR EN LAS DEVOLUCIONES ***************************
    static $compras_id = 42; //PROVEEDORES
    static $iva_en_compras_id = 4; //IVA PAGADO
    static $descuento_en_compras_id = 6; //ESTO YA NO SE VA A UTILIZARSE EN LA NUEVA VERSION
    static $devolucion_en_compras_id = 21; //ESTO YA NO SE VA A UTILIZARSE EN LA NUEVA VERSION
    static $tarjeta_de_credito_id = 45; // SOCIENDADES FINANCIERAS
    static $inventario_id = 22; // inventario de productos terminados
//    Cuentas x cobrar
    static $cuentas_por_cobrar_id = 30; // inventario de productos terminados
    //-----------------------------VENTAS--------------------
    static $transportes_fletes_id = 43;
//    ---------------------------COMPRAS-------------------------------------
    static $proveedores_id = 42; // inventario de productos terminados

    const ESTADO_ACTIVO = 'ACTIVO';

//---------DEPRESIACIONES PARENT--
    static $cuenta_depreciacion_gastos_parent_id = 177; //5.1.02.25. GASTOS
    static $cuenta_depreciacion_costos_gastos_parent_id = 242; //5.2.01.30
    static $cuenta_depreciacion_acumulada_parent_id = 53;
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'accounting_account';

    protected $fillable = array(
        'value',//*
        'status',//*
        'accounting_account_type_id',//*
        'accounting_level_id',//*
        'description',//*
        'parent_key',
        'has_parent',//*
        'is_parent',//*
        'movement',//*
        'rfc',//*
        'cost_center',//*
        'base_amount',//*
        'base_amount_percentage',
        'base_amount_value'

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'accounting_account_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'accounting_level_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'parent_key', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'has_parent', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'is_parent', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'movement', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'rfc', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'cost_center', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'base_amount', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'base_amount_percentage', 'type' => 'double', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'base_amount_value', 'type' => 'double', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:150",
            "status" => "required",
            "accounting_account_type_id" => "required|numeric",
            "accounting_level_id" => "required|numeric",
            "description" => "required",
            "parent_key" => "numeric",
            "has_parent" => "required|numeric",
            "is_parent" => "required|numeric",
            "movement" => "required|numeric",
            "rfc" => "required|numeric",
            "cost_center" => "required|numeric",
            "base_amount" => "required|numeric",
            "base_amount_percentage" => "numeric",
            "base_amount_value" => "numeric"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.status,accounting_account_type.value as accounting_account_type,
accounting_account_type.id as accounting_account_type_id,
accounting_level.value as accounting_level,
accounting_level.id as accounting_level_id,
$this->table.description,$this->table.parent_key,$this->table.has_parent,$this->table.is_parent,$this->table.movement,$this->table.rfc,$this->table.cost_center,$this->table.base_amount,$this->table.base_amount_percentage,$this->table.base_amount_value";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account_type', 'accounting_account_type.id', '=', $this->table . '.accounting_account_type_id');
        $query->join('accounting_level', 'accounting_level.id', '=', $this->table . '.accounting_level_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_account_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_level.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.parent_key', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_parent', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.is_parent', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.movement', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.rfc', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.cost_center', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount_percentage', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount_value', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'AccountingAccount';
            $model = new AccountingAccount();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AccountingAccount::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $accountingAccountData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $accountingAccountData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AccountingAccount.";
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
        $query->join('accounting_account_type', 'accounting_account_type.id', '=', $this->table . '.accounting_account_type_id');
        $query->join('accounting_level', 'accounting_level.id', '=', $this->table . '.accounting_level_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_account_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("accounting_level.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.parent_key', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_parent', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.is_parent', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.movement', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.rfc', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.cost_center', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount_percentage', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.base_amount_value', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
