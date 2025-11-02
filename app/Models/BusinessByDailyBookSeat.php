<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class BusinessByDailyBookSeat extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_daily_book_seat';
//-----------TIPOS LIBRO DIARIO--
    static $gastos = "factura_gasto";
    static $gastos_devoluciones = "factura_detalle_devolucion_gasto";
    static $gastos_retenciones = "factura_gasto_has_retenciones";
    static $ventas = "factura_venta";
    static $ventas_devoluciones = "factura_detalle_devolucion_venta";
    static $ventas_retenciones = "factura_venta_has_transacciones";
    static $compras = "factura_compra";
    static $compras_devoluciones = "factura_detalle_devolucion_compra";
    static $compras_retenciones = "factura_compras_has_retenciones";
    static $estado_situacion_inicial = "estado_situacion_inicial";
    //    ---LVL 4 NAMES---
    static $lvl_4_Caja = "caja";
    static $lvl_4_Bancos = "bancos";
    static $lvl_4_Clientes = "clientes";
    static $lvl_4_Provisiones_incobrables = "provisiones_incobrables";
    static $lvl_4_Documentos_por_cobrar = "documentos_por_cobrar";
    static $lvl_4_Otras_cuentas_por_cobrar = "otras_cuentas_por_cobrar";
    static $lvl_4_Cuentas_por_cobrar_terceros = "cuentas_por_cobrar_terceros";
    static $lvl_4_Impuestos = "impuestos";
    static $lvl_4_Impuesto_a_la_renta = "impuesto_a_la_renta";
    static $lvl_4_Gastos_anticipados = "gastos_anticipados";
    static $lvl_4_Inventario_materia_prima = "inventario_materia_prima";
    static $lvl_4_Materia_prima_indirecta_confeccion = "materia_prima_indirecta_confeccion";
    static $lvl_4_Inventario_de_productos_en_proceso = "inventario_de_productos_en_proceso";
    static $lvl_4_Inventario_de_productos_terminados = "inventario_de_productos_terminados";
    static $lvl_4_Depreciables = "depreciables";
    static $lvl_4_Depreciacion_acumulada = "depreciacion_acumulada";
    static $lvl_4_No_depreciables = "no_depreciables";
    static $lvl_4_Proveedores = "proveedores";
    static $lvl_4_Obligaciones_con_el_personal = "obligaciones_con_el_personal";
    static $lvl_4_Deducciones_patronales = "deducciones_patronales";
    static $lvl_4_Obligaciones_financieras = "obligaciones_financieras";
    static $lvl_4_Impuestos_por_pagar = "impuestos_por_pagar";
//    static $lvl_4_Impuesto_a_la_renta = "impuesto_a_la_renta";
    static $lvl_4_Otras_cuentas_por_pagar = "otras_cuentas_por_pagar";
    static $lvl_4_Gastos_por_pagar = "gastos_por_pagar";
    static $lvl_4_Instituciones_financieras = "instituciones_financieras";
//    static $lvl_4_Obligaciones_con_el_personal = "obligaciones_con_el_personal";
    static $lvl_4_Prestamos_terceros = "prestamos_terceros";
    static $lvl_4_Capital = "capital";
    static $lvl_4_Ventas = "ventas";
    static $lvl_4_Otros_ingresos = "otros_ingresos";
    static $lvl_4_Costos_de_venta = "costos_de_venta";
    static $lvl_4_Consumo_materiales_indirectos = "consumo_materiales_indirectos";
    static $lvl_4_Mano_de_obra = "mano_de_obra";
    static $lvl_4_Costos_indirectos_de_Fabricacion = "costos_indirectos_de_fabricacion";
    static $lvl_4_Servicios_basicos = "servicios_basicos";
    static $lvl_4_Depreciaciones = "depreciaciones";
    static $lvl_4_Arriendo = "arriendo";
    static $lvl_4_Mantenimiento = "mantenimiento";
    static $lvl_4_Otros = "otros";
    static $lvl_4_Gastos_de_personal = "gastos_de_personal";
    static $lvl_4_Gastos_indirectos_servicios = "gastos_indirectos_servicios";
    static $lvl_4_Honorarios_profesionales = "honorarios_profesionales";
//    static $lvl_4_Mantenimiento = "mantenimiento";
    static $lvl_4_Impuestos_y_tasas = "impuestos_y_tasas";
//    static $lvl_4_Depreciaciones = "depreciaciones";
    static $lvl_4_Amortizaciones = "amortizaciones";
    static $lvl_4_Provisiones = "provisiones";
    static $lvl_4_Gastos_financieros = "gastos_financieros";
    static $lvl_4_Comisiones_bancarias = "comisiones_bancarias";
    static $lvl_4_Gastos_varios = "gastos_varios";
//    static $lvl_4_Impuesto_a_la_renta = "impuesto_a_la_renta";
    static $lvl_4_Cierres_de_rentas_y_gastos = "cierres_de_rentas_y_gastos";
    static $lvl_4_Cierres_CIF = "cierres_CIF";
    static $lvl_4_Transportes_fletes = "transportes_fletes";
    protected $fillable = array(
        'daily_book_seat_id',//*
        'diary_book_id',//*
        'business_id',//*
        'entity',
        'entity_id',
        'user_id',//*
        'level_4'

    );
    protected $attributesData = [
        ['column' => 'daily_book_seat_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'diary_book_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'level_4', 'type' => 'string', 'defaultValue' => '	SIN ASIGNAR', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'entity';

    public static function getRulesModel()
    {
        $rules = ["daily_book_seat_id" => "required|numeric",
            "diary_book_id" => "required|numeric",
            "business_id" => "required|numeric",
            "entity" => "max:100",
            "entity_id" => "numeric",
            "user_id" => "required|numeric",
            "level_4" => "max:150"
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

        $selectString = "$this->table.id,daily_book_seat.value as daily_book_seat,
daily_book_seat.id as daily_book_seat_id,
diary_book.value as diary_book,
diary_book.id as diary_book_id,
business.title as business,
business.id as business_id,
$this->table.entity,$this->table.entity_id,$this->table.user_id,$this->table.level_4";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('daily_book_seat', 'daily_book_seat.id', '=', $this->table . '.daily_book_seat_id');
        $query->join('diary_book', 'diary_book.id', '=', $this->table . '.diary_book_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("daily_book_seat.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("diary_book.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.level_4', 'like', '%' . $likeSet . '%');
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
        DB::beginTransaction();
        try {
            $modelName = 'BusinessByDailyBookSeat';
            $model = new BusinessByDailyBookSeat();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByDailyBookSeat::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessByDailyBookSeatData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessByDailyBookSeatData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByDailyBookSeat.";
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
        $query->join('daily_book_seat', 'daily_book_seat.id', '=', $this->table . '.daily_book_seat_id');
        $query->join('diary_book', 'diary_book.id', '=', $this->table . '.diary_book_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("daily_book_seat.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("diary_book.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.level_4', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
