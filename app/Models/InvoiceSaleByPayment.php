<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByPayment extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_payment';

    protected $fillable = array(
        'payment_date',//*
        'state_payment',//*
        'details',
        'types_payments_by_account_id',//*
        'accounting_account_id',
        'user_id',//*
        'invoice_sale_by_breakdown_payment_id',//*
        'invoice_sale_by_indebtedness_paying_init_id'//*

    );
    protected $attributesData = [
        ['column' => 'payment_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state_payment', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'details', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'types_payments_by_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_by_breakdown_payment_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_by_indebtedness_paying_init_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'payment_date';

    public static function getRulesModel()
    {
        $rules = ["payment_date" => "required",
            "state_payment" => "required|numeric",
            "types_payments_by_account_id" => "required|numeric",
            "accounting_account_id" => "numeric",
            "user_id" => "required|numeric",
            "invoice_sale_by_breakdown_payment_id" => "required|numeric",
            "invoice_sale_by_indebtedness_paying_init_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdminPayments($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        $search_value = isset($params["searchPhrase"]) ? $params["searchPhrase"] : null;
        $key_relation = "invoice_sale_by_indebtedness_paying_init_id";//change
        $relationOne = 'accounting_account';
        $relationTwo = 'types_payments_by_account';
        $relationThree = 'types_payments';

        $table_relation = "invoice_sale_by_indebtedness_paying_init";
        $id_relation = isset($params["filters"]['invoice_sales_indebtedness_paying_init_id']) ? $params["filters"]['invoice_sales_indebtedness_paying_init_id'] : null;
        $key_relation_children = "invoice_sale_by_breakdown_payment_id";//change
        $table_relation_children = "invoice_sale_by_breakdown_payment";//change
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $formatGroup = "%d/%m/%Y";

        $selectString = "$this->table.id,DATE_FORMAT($this->table.payment_date,'$formatGroup') fecha_pago,$this->table.state_payment state_indebtedness,$this->table.details nota,$this->table.types_payments_by_account_id typos_de_pagos_has_cuenta_entidad_id,$this->table.user_id owner_id,$this->table.$key_relation_children,$this->table.$key_relation
        , DATE_FORMAT($table_relation_children.date_agreement, '$formatGroup') fecha_pago_acuerdo, ROUND($table_relation_children.payment_value,2) pago_cantidad
,$relationOne.description contabilidad_cuenta
,$relationThree.value typos_de_pagos";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($table_relation_children, $table_relation_children . '.id', '=', $this->table . '.' . $key_relation_children);
        $query->join($relationOne, $this->table . '.accounting_account_id', '=', 'accounting_account.id');
        $query->join($relationTwo, $this->table . '.types_payments_by_account_id', '=', $relationTwo . '.id');
        $query->join($relationThree, $relationTwo . '.types_payments_id', '=', $relationThree . '.id');

        $query->join($table_relation, $table_relation . '.id', '=', $this->table . '.' . $key_relation);

        $query->where($this->table . '.invoice_sale_by_indebtedness_paying_init_id', '=', $id_relation);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.details', 'like', '%' . $likeSet . '%');

            });

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


    public function savePayment($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $entityName = "InvoiceSaleByPayment";
            $managerCurrentKey = "indebtednessBreakDownCollectionPayments";
            $dataPost = $attributesPost[$entityName];
            $invoice_id = $dataPost["invoice"]["id"];
            $entidad_data_id = $dataPost["entidad_data_id"];

            $managerIndebtedness = $dataPost["managerIndebtedness"];
            $managerCurrentData = $managerIndebtedness[$managerCurrentKey];
            $parentData = $managerIndebtedness["indebtednessInit"];
            $invoice_sale_by_indebtedness_paying_init_id=$parentData['data']['id'];
            $attributes = $managerCurrentData["data"];
            $manager_relation_key = 'invoice_sale_by_indebtedness_paying_init_id ';
            /*S2*/
            $keyS2 = "invoice_indebtedness_paying_init_id";
            $invoice_indebtedness_paying_init_data = $attributes[$keyS2];
            $invoice_indebtedness_paying_init_id = $attributes['invoice_sales_indebtedness_paying_init_id'];


            $keyS2 = "tipos_de_pagos_id_tipopago";
            $tipos_de_pagos_id_tipopago_data = $attributes[$keyS2];
            $tipos_de_pagos_id = $tipos_de_pagos_id_tipopago_data["id"];

            $keyS2 = "contabilidad_cuenta_id";
            $contabilidad_cuenta_id_data = $attributes[$keyS2];
            $contabilidad_cuenta_id = $contabilidad_cuenta_id_data["id"];
            $types_payments_by_account_id = $contabilidad_cuenta_id_data["types_payments_by_account_id"];

            $modelTDPHC = new \App\Models\TypesPaymentsByAccount();
            $modelTDPHC = $modelTDPHC->findByAttributes(array("id" => $types_payments_by_account_id));

            $modelName = 'InvoiceSaleByPayment';
            $model = new InvoiceSaleByPayment();
            $modelNameCurrent = $managerCurrentData["model"];
            $modelCurrent = $model;
            $tableNameCurrent = $managerCurrentData["table"];

            $owner_id = $user->id;
            $keyGet = "fecha_pago";
            $valueCurrent = $attributes[$keyGet];
            $datePaymentCurrent = $valueCurrent;

            $keyGet = "nota";
            $valueCurrent = isset($attributes[$keyGet]) ? $attributes[$keyGet] : "";
            $details = $valueCurrent;

            $valueCurrent = $modelTDPHC->id;
            $types_payments_by_account_id = $valueCurrent;


            $valueCurrent = $attributes['invoice_indebtedness_paying_init_id']['id'];
            $manager_relation_key_id = $valueCurrent;
//            -----VALIDATION STATE PAYMENT---
            $state = 1;

            $modelBreakdownCurrentManager = new \App\Models\InvoiceSaleByBreakdownPayment();
            $modelBreakdownCurrent = $modelBreakdownCurrentManager->findByAttributes(array("id" => $manager_relation_key_id));

            $datePaymentBreakdown = $modelBreakdownCurrent->date_agreement;
            $date1 = new \DateTime($datePaymentBreakdown);
            $date2 = new \DateTime($datePaymentCurrent);
            if ($datePaymentBreakdown >= $datePaymentCurrent) {//pago antes del dia
                $state = 1;
            } else {//
                $state = 0;

            }
            $attributesCurrent = [
                'payment_date' => $datePaymentCurrent,//*
                'state_payment' => $state,//*
                'details' => $details,
                'types_payments_by_account_id' => $types_payments_by_account_id,//*
                'accounting_account_id' => $contabilidad_cuenta_id,
                'user_id' => $owner_id,//*
                'invoice_sale_by_breakdown_payment_id' => $manager_relation_key_id,//*
                'invoice_sale_by_indebtedness_paying_init_id' => $invoice_indebtedness_paying_init_id//*

            ];
            $modelCurrent->attributes = $attributesCurrent;


            $createUpdate = true;

            $attributesSet = $attributesCurrent;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            $resultSaveAll = $success;
            if ($success) {
                $fecha = \App\Utils\Util::DateCurrent();
                $diff = $date1->diff($date2);
                $DEBE = DiaryBook::DEBE;
                $HABER = DiaryBook::HABER;
                $typeManager = "sales";//change
                $modelInvoice = new \App\Models\InvoiceSale();

                $type = $typeManager == "shopping" ? "buy" : "sales";


                $configAccountId = $typeManager == "shopping" ? AccountingConfigModulesAccountByAccount::$proveedores : AccountingConfigModulesAccountByAccount::$clientes;
                $seatTitle = $typeManager == "shopping" ? "V/R Pago cuentas por Pagar" : "V/R Cobro cuentas por Cobrar";
                $modelACMAB = new AccountingConfigModulesAccountByAccount();
                $model_cmc = $modelACMAB->findByPk($configAccountId);

                $supplierCustomerAccountId = $model_cmc->accounting_account_id;
                $modelCurrent->fill($attributesSet);
                $resultSaveAll = $modelCurrent->save();
                $modelBreakdownCurrent = \App\Models\InvoiceSaleByBreakdownPayment::find($modelBreakdownCurrent->id);
                $modelBreakdownCurrent->state_payment = 0;
                $resultSaveAll = $modelBreakdownCurrent->save();
                if ($resultSaveAll) {

                    $valuePaymentCurrent = $modelBreakdownCurrent->payment_value;
                    $model_ald = new \App\Models\DailyBookSeat();
                    $attributesSetCurrent = [
                        'value' => $seatTitle,//*
                        'description' => 'none',
                        'created_at' => $fecha,
                        'register_manager_date' => $fecha,//*
                        'entidad_data_id' => $entidad_data_id,//*
                        'status' => 'ACTIVE'//*

                    ];
                    $model_ald->attributes = $attributesSetCurrent;

                    $resultSaveAllManager = $model_ald->validate();
                    $resultSaveAll = $resultSaveAllManager['success'];
                    if ($resultSaveAll) {
                        $model_ald->fill($attributesSetCurrent);
                        $model_ald->save();
                        $model_ld = new DiaryBook();
                        $type_ingreso = $typeManager == "shopping" ? $DEBE : $HABER;
                        $attributesSetCurrent = [
                            'value' => $valuePaymentCurrent,//*
                            'manager_type' => $type_ingreso,//*
                            'accounting_account_id' => $supplierCustomerAccountId//*

                        ];
                        $model_ld->attributes = $attributesSetCurrent;

                        $resultSaveAllManager = $model_ld->validate();
                        $resultSaveAll = $resultSaveAllManager['success'];
                        if ($resultSaveAll) {
                            $model_ld->fill($attributesSetCurrent);
                            $model_ld->save();
                            $model_edhld = new BusinessByDailyBookSeat();

                            $attributesSetCurrent = [
                                'daily_book_seat_id' => $model_ald->id,//*
                                'diary_book_id' => $model_ld->id,//*
                                'business_id' => $entidad_data_id,//*
                                'entity' => $tableNameCurrent,
                                'entity_id' => $modelCurrent->id,
                                'user_id' => $owner_id,//*
                                'level_4' => ''

                            ];

                            $model_edhld->attributes = $attributesSetCurrent;
                            $resultSaveAllManager = $model_edhld->validate();
                            $resultSaveAll = $resultSaveAllManager['success'];
                            if ($resultSaveAll) {
                                $model_edhld->fill($attributesSetCurrent);
                                $model_edhld->save();

                            } else {

                                $msj_error = "Error EntidadHasDataLibroDiario 1 Registro Error";
                                throw new \Exception($msj_error);
                            }

                        } else {
                            $msj_error = "Error LD 1 Registro Error";
                            throw new \Exception($msj_error);
                        }

                        $model_ld = new DiaryBook();

                        $type_ingreso = $typeManager == "shopping" ? $HABER : $DEBE;
                        $attributesSetCurrent = [
                            'value' => $valuePaymentCurrent,//*
                            'manager_type' => $type_ingreso,//*
                            'accounting_account_id' => $contabilidad_cuenta_id//*

                        ];
                        $model_ld->attributes = $attributesSetCurrent;
                        $resultSaveAllManager = $model_ld->validate();
                        $resultSaveAll = $resultSaveAllManager['success'];
                        if ($resultSaveAll) {
                            $model_ld->fill($attributesSetCurrent);
                            $model_ld->save();

                            $model_edhld = new BusinessByDailyBookSeat();
                            $attributesSetCurrent = [
                                'daily_book_seat_id' => $model_ald->id,//*
                                'diary_book_id' => $model_ld->id,//*
                                'business_id' => $entidad_data_id,//*
                                'entity' => $tableNameCurrent,
                                'entity_id' => $modelCurrent->id,
                                'user_id' => $owner_id,//*
                                'level_4' => ''

                            ];
                            $model_edhld->attributes = $attributesSetCurrent;
                            $resultSaveAllManager = $model_edhld->validate();
                            $resultSaveAll = $resultSaveAllManager['success'];
                            if ($resultSaveAll) {
                                $model_edhld->fill($attributesSetCurrent);
                                $model_edhld->save();

                            } else {
                                $msj_error = "Error EntidadHasDataLibroDiario 2 Registro Error";
                                throw new \Exception($msj_error);
                            }

                        } else {
                            $msj_error = "Error LD 2 Registro Error";
                            throw new \Exception($msj_error);
                        }
                        $success = true;

                    } else {
                        $msj_error = "Error ALD Registro Error";

                        $result['errors'] = $resultSaveAllManager['errors'];
                        throw new \Exception($msj_error);
                    }
                } else {

                    $msj_error = "Actualizacion Breakdwon Registro Error";
                    throw new \Exception($msj_error);
                }

            } else {
                $success = false;
                $msj = "Pago Registro Error.";
                $errors = $validateResult["errors"];
            }

            $paymentAll = true;
            $modelSearchBreakdown = new \App\Models\InvoiceSaleByBreakdownPayment();


            $modelCurrentview = $modelSearchBreakdown->findAllByAttributes(array('invoice_sale_by_indebtedness_paying_init_id' => $invoice_indebtedness_paying_init_id, "state_payment" => "1"));
            $paymentAll = count($modelCurrentview) == 0;

            if ($paymentAll) {
                $modelInvoiceCurrent = $modelInvoice->find($invoice_id);
                $modelInvoiceCurrent->status = "ISSUED";

                $resultSaveAll = $modelInvoiceCurrent->save();
                if ($resultSaveAll) {

                } else {
                    $msj_error = "Actualizacion Invoice Registro Error";
                    throw new \Exception($msj_error);
                }
            }

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }

            $utilCurrent = new \App\Utils\Accounting\UtilAccounting;


            $dataInvoiceManager = $utilCurrent->getDataInvoiceManagerIndebtedness(
                array("invoice_id" => $invoice_id, "type" => $type)
            );

            $result = [
                "errors" => [],
                "msj" => "Guardado Correctament",
                "success" => $resultSaveAll
            ];
            $result["managerIndebtedness"] = $dataInvoiceManager;


            return ($result);
        } catch (\Exception $e) {
            DB::rollBack();
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
        $query->join('types_payments_by_account', 'types_payments_by_account.id', '=', $this->table . '.types_payments_by_account_id');
        $query->join('invoice_sale_by_breakdown_payment', 'invoice_sale_by_breakdown_payment.id', '=', $this->table . '.invoice_sale_by_breakdown_payment_id');
        $query->join('invoice_sale_by_indebtedness_paying_init', 'invoice_sale_by_indebtedness_paying_init.id', '=', $this->table . '.invoice_sale_by_indebtedness_paying_init_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.payment_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state_payment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.details', 'like', '%' . $likeSet . '%');
                $query->orWhere("types_payments_by_account.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.accounting_account_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale_by_breakdown_payment.date_agreement", 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale_by_indebtedness_paying_init.id", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListAllSaleByInit($params)
    {
        $invoice_sale_by_indebtedness_paying_init_id = $params['invoice_sale_by_indebtedness_paying_init_id'];
        $resultNotInData = DB::table($this->table)->select(DB::raw($this->table . '.invoice_sale_by_breakdown_payment_id id'))->where($this->table . '.invoice_sale_by_indebtedness_paying_init_id', '=', $invoice_sale_by_indebtedness_paying_init_id)->get()->toArray();
        $resultNotIn = [];
        foreach ($resultNotInData as $key => $row) {
            $resultNotIn[] = $row->id;
        }

        return $resultNotIn;
    }
}
