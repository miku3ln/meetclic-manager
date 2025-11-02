<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByIndebtednessPayingInit extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_indebtedness_paying_init';

    protected $fillable = array(
        'number_payments',//*
        'user_id',//*
        'invoice_sale_id'//*

    );
    protected $attributesData = [
        ['column' => 'number_payments', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["number_payments" => "required|numeric",
            "user_id" => "required|numeric",
            "invoice_sale_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.number_payments,$this->table.user_id,invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.number_payments', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
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


    public function saveIndebtedness($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $dataPost = $attributesPost['invoiceSaleByIndebtednessPayingInit'];

        $errors = array();
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $util = new \App\Utils\Util();
            $modelName = 'InvoiceSaleByIndebtednessPayingInit';
            $model = new InvoiceSaleByIndebtednessPayingInit();
            $createUpdate = true;


            $invoice_id = $dataPost["invoice"]["id"];
            $managerIndebtedness = $dataPost["managerIndebtedness"];
            $managerIndebtednessCurrent = $managerIndebtedness;
            $indebtednessInit = $managerIndebtedness["indebtednessInit"];
            $attributes = $indebtednessInit["data"];
            $relation_key = $indebtednessInit["relation_key"];


            $owner_id = $user->id;
            $attributesSet = [
                'number_payments' => $attributes['numero_pagos'],
                'user_id' => $owner_id,
            ];
            $attributesSet['user_id'] = $owner_id;
            $attributesSet[$relation_key] = $invoice_id;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $indebtednessBreakDown = $managerIndebtedness["indebtednessBreakDown"];
                $dataIndebtednessBreakDown = $indebtednessBreakDown["data"];
                $relation_key = $indebtednessBreakDown["relation_key"];

                $model->save();

                $indebtednessInit_id = $model->id;
                $managerIndebtednessCurrent["indebtednessInit"]["data"] = [
                    'factura_venta_id ' => $model->invoice_sale_id,
                    'numero_pagos' => $model->number_payments,
                    'owner_id' => $model->user_id,
                    'id' => $model->id,

                ];
                foreach ($dataIndebtednessBreakDown as $key => $row) {
                    $modelBreakDown = new \App\Models\InvoiceSaleByBreakdownPayment();

                    $fecha_pago_acuerdo = $util::FormatDate($row["fecha_pago_acuerdo"], "Y-m-d");

                    $pago_cantidad = $row["pago_cantidad"];
                    $state = $row["state"];
                    $setPushAttributes = [
                        'date_agreement' => $fecha_pago_acuerdo,//*
                        'payment_value' => $pago_cantidad,//*
                        'state_payment' => $state,//*
                        'user_id' => $owner_id,//*
                        'invoice_sale_by_indebtedness_paying_init_id' => $indebtednessInit_id//*
                    ];
                    $modelBreakDown->attributes = $setPushAttributes;
                    $resultSaveAllManager = $modelBreakDown->validate();
                    $resultSaveAll = $resultSaveAllManager['success'];
                    if ($resultSaveAll) {
                        $modelBreakDown->fill($setPushAttributes);
                        $modelBreakDown->save();
                        $currentId = $modelBreakDown->id;
                        $dataIndebtednessBreakDown[$key]["id"] = $currentId;
                    } else {

                        $result["errors"] = $resultSaveAllManager['errors'];
                        $msjError = "Error al guardar " . $modelName . " breakdown";
                        throw new \Exception($msjError);

                    }
                }
                $managerIndebtednessCurrent["indebtednessBreakDown"]["data"] = $dataIndebtednessBreakDown;


            } else {
                $success = false;
                $msj = "Problemas al guardar  InvoiceSaleByIndebtednessPayingInit.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                $resultSaveAll = false;
                DB::rollBack();

            } else {
                $resultSaveAll = true;

                DB::commit();
            }


            $msj = "Guardado Correctamente.";
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $resultSaveAll,
                'managerIndebtedness' => $managerIndebtednessCurrent
            ];


            return ($result);
        } catch (Exception $e) {
            $success = false;
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
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.number_payments', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
