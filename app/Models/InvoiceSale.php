<?php

namespace App\Models;

use App\Utils\Accounting\BillingUtil;
use App\Utils\Accounting\UtilAccounting;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSale extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale';
    const tipo_comprobante_id_factura = 1;
    const tipo_comprobante_id_nota_de_venta = 1;
    protected $fillable = array(
        'customer_id',//*
        'invoice_code',//*
        'invoice_value',//*
        'discount_value',
        'status',//*
        'created_at',//*
        'user_id',//*
        'observations',
        'value_taxes',//*
        'subtotal',//*
        'invoice_date',//*
        'establishment',//*
        'emission_point',//*
        'voucher_type_id',//*
        'mixed_payment',//*
        'has_retention',//*
        'now_after_retention',//*
        'debt',//*
        'type_of_discount',//*
        'discount_type_invoice',//*
        'authorization_number',//*
        'type_of_document_issuance',//*


    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'discount_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ISSUED', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'observations', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'value_taxes', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'establishment', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'emission_point', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'voucher_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'mixed_payment', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'has_retention', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'now_after_retention', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'debt', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_of_discount', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'discount_type_invoice', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'authorization_number', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_of_document_issuance', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'invoice_code';

    public static function getRulesModel()
    {
        $rules = ["customer_id" => "required|numeric",
            "invoice_code" => "required|max:45",
            "invoice_value" => "required|numeric",
            "discount_value" => "numeric",
            "status" => "required",
            "created_at" => "required",
            "user_id" => "required|numeric",
            "value_taxes" => "required|numeric",
            "subtotal" => "required|numeric",
            "authorization_number" => "required|max:150",
            "invoice_date" => "required",
            "establishment" => "required|max:3",
            "emission_point" => "required|max:3",
            "voucher_type_id" => "required|numeric",
            "mixed_payment" => "required|numeric",
            "has_retention" => "required|numeric",
            "debt" => "required|numeric",
            "type_of_document_issuance" => "required|numeric",
            "type_of_discount" => "required|numeric",
            "discount_type_invoice" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getInvoiceSaleAdmin($params)
    {
        $utilCurrent = new UtilAccounting();
        $modelUtil = new  BillingUtil();

        $result = $this->getInvoiceSaleAdminData($params);

        $type = "sale";
        $rowsResult = [];
        foreach ($result["rows"] as $key => $rowManager) {
            $row = (array)$rowManager;
            $state = $row["estado"];
            $deuda = $row["deuda"];

            $invoice_id = $row["id"];
            $has_retencion = $row["has_retencion"];
            $customer_id = $row["customer_id"];

            if ($deuda == "1") {
                $dataInvoiceManager = $utilCurrent->getDataInvoiceManagerIndebtedness(
                    array("invoice_id" => $invoice_id, "type" => "sales")
                );
                $row["managerIndebtedness"] = $dataInvoiceManager;
            }
            $viewBillingData = $modelUtil->getViewBillingCurrent(array("invoiceId" => $invoice_id, "hasRetention" => $has_retencion, "type" => $type, "customer_id" => $customer_id));

            $result["rows"][$key] = array_merge($row, $viewBillingData);
        }

        return $result;
    }

    public function getInvoiceSaleAdminData($params)
    {
        $entidad_data_id = $params["filters"]["entidad_data_id"] == "" ? null : $params["filters"]["entidad_data_id"];
        $estado = $params["filters"]["estado"] == "" ? null : $params["filters"]["estado"];
        $tipo_comprobante_id = $params["filters"]["tipo_comprobante_id"] == "" ? null : $params["filters"]["tipo_comprobante_id"];
        $fecha_inicio = $params["filters"]["fecha_inicio"] == "" ? null : $params["filters"]["fecha_inicio"];
        $fecha_fin = $params["filters"]["fecha_fin"] == "" ? null : $params["filters"]["fecha_fin"];
        $supplyCustomerId = $params["filters"]["supplyCustomerId"] == "" ? null : $params["filters"]["supplyCustomerId"];

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

        $selectString = "$this->table.id,$this->table.customer_id,$this->table.invoice_code,$this->table.invoice_value,$this->table.discount_value,$this->table.status,$this->table.created_at,$this->table.user_id,$this->table.observations,$this->table.value_taxes,$this->table.subtotal,$this->table.authorization_number,$this->table.invoice_date,$this->table.establishment,$this->table.emission_point,$this->table.mixed_payment,$this->table.has_retention,$this->table.debt,$this->table.type_of_discount,$this->table.discount_type_invoice
        ,voucher_type.value as voucher_type,voucher_type.id as voucher_type_id
        ,customer.id customer_id,customer.business_reason razon_social,customer.identification_document identificacion
        ,people.name nombres,people.last_name apellidos
        ,$this->table.customer_id cliente_id,$this->table.mixed_payment pago_mixto, $this->table.has_retention has_retencion, $this->table.now_after_retention now_after_retencion, $this->table.debt deuda,$this->table.establishment establecimiento, $this->table.emission_point punto_emision, $this->table.invoice_code codigo_factura, CONCAT($this->table.establishment ,'-',$this->table.emission_point,'-',$this->table.invoice_code) codigo_factura_info, $this->table.authorization_number no_autorizacion, $this->table.invoice_value valor_factura, $this->table.discount_value valor_descuento, $this->table.status estado,DATE_FORMAT($this->table.created_at,'%d/%m/%Y')  fecha_creacion ,DATE_FORMAT($this->table.invoice_date,'%d/%m/%Y') fecha_factura, $this->table.user_id usuario_creacion_id, $this->table.observations observaciones, $this->table.value_taxes valor_impuestos, $this->table.subtotal
       ,voucher_type.value tipo ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('voucher_type', 'voucher_type.id', '=', $this->table . '.voucher_type_id');
        $query->join('entity_has_invoice_sale', $this->table . '.id', '=', 'entity_has_invoice_sale.factura_venta_id');
        $query->join('customer', $this->table . '.customer_id', '=', 'customer.id');
        $query->join('people', 'customer.people_id', '=', 'people.id');
        $query->where('entity_has_invoice_sale.entidad_data_id', '=', $entidad_data_id);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.invoice_code', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.name', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.last_name', 'like', '%' . $likeSet . '%');
                $query->orWhere('customer.identification_document', 'like', '%' . $likeSet . '%');
                $query->orWhere('customer.business_reason', 'like', '%' . $likeSet . '%');

            });

        }
        if ($estado) {

            $statusCurrentManager = [
                'EMITIDO' => 'ISSUED',
                'PENDIENTE' => 'PENDING',
                'ANULADO' => 'CANCELLED',


            ];
            $statusCurrent = $statusCurrentManager[$estado];

            $query->where($this->table . '.status', '=', $statusCurrent);
        }
        if ($tipo_comprobante_id) {
            $query->where($this->table . '.voucher_type_id', '=', $tipo_comprobante_id);


        }

        if ($fecha_fin && $fecha_inicio) {
            $query->where($this->table . '.invoice_date', '>=', $fecha_inicio);
            $query->where($this->table . '.invoice_date', '<=', $fecha_fin);

        }
        if ($supplyCustomerId) {

            $query->where('customer.id', '=', $supplyCustomerId);

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
            $modelName = 'InvoiceSale';
            $model = new InvoiceSale();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InvoiceSale::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $invoiceSaleData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $invoiceSaleData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  InvoiceSale.";
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

    public static function initAllowManagerProcess($params)
    {

        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();

        $modelED = new \App\Models\Business();
        $managerUserId = $dataUserManager['user']->id;//getUser
        $modelEAC = new \App\Models\EntityAuthorizationConfiguration();
        $businessId = $params["businessId"];
        $entityData = $modelED->getEntityManager($params);//getPlan
        $allow_cash_and_banks = $entityData->allow_cash_and_banks;

        $roles = array();
        $allowProcess = false;
        $errors = array();
        $rolesAllow = array();
        $allowRoles = false;
        $allowPlans = false;
        $processName = 'sales';
        $plan_basic_exist = false;
        $managerStepsConfig = array(
            'roles' => array(
                'success' => false,
                'error' => '',
                'typeError' => ''
            ),
            'plans' => array(
                'success' => false,
                'error' => '',
                'typeError' => ''

            ),
            'processCurrent' => array(
                'name' => $processName,
                'success' => false,
                'error' => '',
                'typeError' => '',
                'data' => array()

            ),
        );
        if ($allow_cash_and_banks == 1) {
            if (!$dataUserManager['isSuperAdmin']) {
                $ConstantCruge = new \App\Constants\CrugeConstants();
                $modelR = new \App\Models\Role();

                //Planes_GetPlan
                $roles = $dataUserManager['roles'];
                $needle = $modelR::ROL_BUSINESS_MANAGER;
                $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
                $allowRoleAdministration = false;
                if ($resultSearch['success']) {
                    $allowRoleAdministration = true;
                    $rolesAllow[] = $resultSearch['data'];
                } else {
                    $needle = $modelR::ROL_EMPLOYER_MANAGER;
                    $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
                    if ($resultSearch['success']) {
                        $allowRoleAdministration = true;
                        $rolesAllow[] = $resultSearch['data'];
                    } else {
                        $allowRoleAdministration = false;
                    }
                }

                $needle = $modelR::ROL_RECEPTIONIST_MANAGER;
                $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
                $allowRoleSales = false;
                if ($resultSearch['success']) {
                    $allowRoleSales = true;
                    $rolesAllow[] = $resultSearch['data'];
                } else {
                    $allowRoleSales = false;
                }
                $errorsCurrent = '';
                $allowRolesCurrent = false;
                $typeError = '';
                if (!$allowRoleSales && !$allowRoleAdministration) {
                    $errorsCurrent = 'Not Allow Role Current.!';
                    $typeError = 'config';
                } else {
                    $allowRolesCurrent = true;

                }
                if ($allowRolesCurrent) {
                    $modelEP = new \App\Models\EntityPlans();
                    $roadName = 'plans';
                    $successCurrent = $allowRolesCurrent;
                    $managerStepsConfig[$roadName]['success'] = $successCurrent;
                    $errorsCurrent = '';
                    if ($entityData) {
                        if ($entityData['entity_plans_id'] == $modelEP::LINE_PLAN_ID) {
                            $allowPlans = true;
                        } else if ($entityData['entity_plans_id'] == $modelEP::SIMPLE_PLAN_ID) {
                            $allowPlans = true;

                        } else if ($entityData['entity_plans_id'] == $modelEP::PRO_PLAN_ID) {
                            $allowPlans = true;

                        } else if ($entityData['entity_plans_id'] == $modelEP::BASIC_PLAN_ID) {
                            $allowPlans = true;
                            $plan_basic_exist = true;

                        } else {
                            $errorsCurrent = 'Not has Plane Config.';

                        }
                    } else {
                        $errorsCurrent = 'Not has Business Config.';

                    }

                    if ($allowPlans) {
                        $roadName = 'roles';
                        $successCurrent = $allowPlans;
                        $managerStepsConfig[$roadName]['success'] = $successCurrent;
                        $type = $modelEAC::INVOICE_SALES_TYPE;
                        $estado = $modelEAC::STATE_ACTIVE;
                        $paramsFilter = array("type" => $type, "state" => $estado, "entity_data_id" => $businessId);
                        $resultModel = $modelEAC->findByAttributes($paramsFilter);
                        $managerType = "DOCUMENTOS AUTORIZADOS NO CONFIGURADO!";
                        $result = $modelEAC::getValuesConfigByModel(array(
                            'model' => $resultModel,
                            'type' => $type,
                            'managerType' => $managerType,
                        ));
                        if ($result['allow']) {
                            $roadName = 'processCurrent';
                            if ($plan_basic_exist) {
                                $successCurrent = true;
                                $caseError = null;
                                if ($result['case'] != 5 && $result['case'] != 6) {
                                    $successCurrent = false;

                                    switch ($result['case']) {
                                        case 1.1:
                                            $caseError = '1.1.1';
                                            break;
                                        case 1.3:
                                            $caseError = '1.3.1';
                                            break;
                                        case 2.1:
                                            $caseError = '2.1.1';
                                            break;
                                        case 2.3:
                                            $caseError = '2.3.1';
                                            break;
                                        case 3:
                                            $caseError = '3.1';
                                            break;
                                    }
                                }
                                if ($successCurrent) {
                                    $managerStepsConfig[$roadName]['success'] = $successCurrent;
                                    $managerStepsConfig[$roadName]['data'] = $result;
                                } else {
                                    $errorsCurrent = 'PLAN NO SOPORTA LA CONFIGURACIÓN ESTABLECIDA';
                                    $typeError = 'config';
                                    $managerStepsConfig[$roadName]['success'] = $successCurrent;
                                    $managerStepsConfig[$roadName]['error'] = $errorsCurrent;
                                    $managerStepsConfig[$roadName]['typeError'] = $typeError;
                                    $managerStepsConfig[$roadName]['case'] = $caseError;

                                }

                            } else {
                                $successCurrent = $result['allow'];
                                $managerStepsConfig[$roadName]['success'] = $successCurrent;
                                $managerStepsConfig[$roadName]['data'] = $result;
                            }

                        } else {
                            $typeError = 'config';
                            $roadName = 'processCurrent';
                            $errorsCurrent = $result['value'];
                            $successCurrent = $result['allow'];
                            $managerStepsConfig[$roadName]['success'] = $successCurrent;
                            $managerStepsConfig[$roadName]['error'] = $errorsCurrent;
                            $managerStepsConfig[$roadName]['typeError'] = $typeError;
                            $managerStepsConfig[$roadName]['data'] = $result;


                        }

                    } else {
                        $typeError = '401';
                        $roadName = 'plans';
                        $errorsCurrent = $errorsCurrent;
                        $successCurrent = false;
                        $managerStepsConfig[$roadName]['success'] = $successCurrent;
                        $managerStepsConfig[$roadName]['error'] = $errorsCurrent;
                        $managerStepsConfig[$roadName]['typeError'] = $typeError;

                    }


                } else {
                    $roadName = 'roles';
                    $successCurrent = $allowPlans;
                    $managerStepsConfig[$roadName]['success'] = $successCurrent;
                    $managerStepsConfig[$roadName]['error'] = $errorsCurrent;
                    $typeError = 'config';
                    $managerStepsConfig[$roadName]['typeError'] = $typeError;

                }

            }
            $success = true;
            $error = '';
            $typeError = '';
            foreach ($managerStepsConfig as $key => $value) {
                if (!$value['success']) {
                    $success = $value['success'];
                    $error = $value['error'];
                    $typeError = $value['typeError'];
                    break;
                }
            }

            if ($dataUserManager['isSuperAdmin']) {

                $success = false;
                $error = 'Es Usuario Admin y existe un error';
                $typeError = 'admin';
            }
        } else {
            $success = true;
            $error = 'Puede realizar ventas asi no tenga personas asignadas caja ';
            $typeError = 'notCashAndBank';
        }

        $result = array(
            'entityData' => $entityData,
            'roles' => $roles,
            'managerStepsConfig' => $managerStepsConfig,
            'rolesAllow' => $rolesAllow,
            'success' => $success,
            'error' => $error,
            'typeError' => $typeError

        );

        return $result;

    }

    public $name_model = "InvoiceSale";
    public $name_model_anexo = "InvoiceSaleByTransactionalAnnex";
    public $name_model_factura_entidad = "EntityHasInvoiceSale";
    public $name_model_factura_transacciones = "InvoiceSaleByTransactions";
    public $name_model_factura_has_retenciones = "InvoiceSaleByRetention";
    public $name_model_factura_deuda = "PagosVentasHasEntidad";
    public $tipo_ingreso_io = 1;
    public $hasSeatBookInvoice = "InvoiceSaleByBookSeat";

    public function saveInvoicePointOfSales($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();

        $result = array();
        $fecha = \App\Utils\Util::DateCurrent();
        $entidad_data_id = 0; //para guardar d q empresa pertenece
        $asiento_id = 0;
        $invoiceId = 0;
        $success = false;

        $result = array();
        $msjError = "";
        $resultSaveAll = false;
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        $user = $dataUserManager['user'];
        $user_id = $user->id;
        DB::beginTransaction();
        try {

            $configPayment = $_POST["configPayment"];
            $detailsInvoice = $_POST["data_factura_detalle"];
            $headerInvoice = $_POST["data_factura_encabezado"];
            $headerRetention = isset($_POST["data_retenciones"]) ? $_POST["data_retenciones"] : array();
            $detailsRetention = isset($_POST["data_retenciones_detalle"]) ? $_POST["data_retenciones_detalle"] : array();

            $headerPaymentMethods = isset($_POST["data_factura_detalle_pagos"]) ? $_POST["data_factura_detalle_pagos"] : array();
            $detailsPaymentMethods = isset($_POST["data_factura_detalle_pagos"]) ? $_POST["data_factura_detalle_pagos"] : array();


//            -----INIT VARIABLES GLOBALES---
            //por el momento esta solo para factura
            //guardamos el encabezado de la fatura encabezado
            $exist_descuento = false; //para poder guardar en libro diario el descuento de un registro de factura
            $entidad_data_id = $_POST["data_factura_encabezado"]["entidad_id"]; //Q EMPRESA GESTIONA
            $owner_id = $user_id; //USUARIO QIEN GESTIONA
//            ---------ASIENTO 3-------
//COSTOS
            $modelCMA = new \App\Models\AccountingConfigModulesAccountByAccount();
            $modelIS = new \App\Models\InvoiceSale();
            $modelAC = new \App\Models\AccountingAccount();

            $model_cmc = $modelCMA->findByPk($modelCMA::$costo_de_ventas);

            $costo_cuenta_id = $model_cmc->accounting_account_id;
            $valor_costo = 0;
            $valor_inventario = 0;
            //-----END VARIABLES GLOBALES---
            //
//            ---guardado de FACTURAS----
            $diferencia = $_POST["data_factura_encabezado"]["diferencia"]; //con este trabajar
            $modelInvoice = new \App\Models\InvoiceSale();
            $cliente_id = $_POST["data_factura_encabezado"]["cliente_data"]["id"];


            $valor_descuento = $_POST["data_factura_encabezado"]["valor_descuento"];
            $tipo_comprobante_id = $modelIS::tipo_comprobante_id_factura;
//                      --CODIGO DOCUMENTO--

            $estado = $modelAC::$factura_estado_emitido;
            if ($_POST["configPayment"]["hasIndebtedness"] == "true") {
                $estado = $modelAC::$factura_estado_pendiente;
            }
            if ($valor_descuento > 0) {
                $exist_descuento = true;
            }
            $observaciones = "";


            $roundManager = \App\Utils\Accounting\UtilAccounting::managerRound;
            $INVOICE_TYPE = 0;
            $PRODUCTO_TYPE = 1;
            $INVOICE_TYPE_PERCENTAGE = 0;
            $PRODUCTO_TYPE_CASH = 1;
            $entityTypeCurrent = \App\Utils\Accounting\BillingUtil::ENTITY_TYPE_MANAGEMENT_SALES;
            $type_descuento_factura = (isset($_POST["data_factura_encabezado"]["type_descuento_factura"]) ? ($_POST["data_factura_encabezado"]["type_descuento_factura"] == "true" ? $INVOICE_TYPE : $PRODUCTO_TYPE) : $INVOICE_TYPE);
            $type_descuento = $INVOICE_TYPE_PERCENTAGE;
            if (isset($_POST["data_factura_encabezado"]["type_descuento"])) {
                $type_descuento = $_POST["data_factura_encabezado"]["type_descuento"] == "true" ? $INVOICE_TYPE_PERCENTAGE : $PRODUCTO_TYPE_CASH;
            }
            $type_discount = $type_descuento;
            $cash_management_current_id = isset($_POST["CashManagementCurrent"]['id']) ? $_POST["CashManagementCurrent"]['id'] : null;
            //            ---INIT FACTURA EVENTOS
            $pago_mixto = 0;
            $hasRetention = $configPayment["hasRetention"];
            $now_after_retencion = 0;
            $managerResultsProcess = $modelIS::initAllowManagerProcess(array(
                'businessId' => $entidad_data_id
            ));

            $allowManagerProcess = $managerResultsProcess['success'];
            $numberRowCodec = 1;
            if ($allowManagerProcess) {
                $type_of_document_issuance = 0;
                $allowSequential = false;

                if (isset($managerResultsProcess['managerStepsConfig']['processCurrent']['data']) && count($managerResultsProcess['managerStepsConfig']['processCurrent']['data']) > 0) {
                    $managerAuthorizationSettingsData = $managerResultsProcess['managerStepsConfig']['processCurrent']['data'];
                    $allowSequential = false;
                    $codeManagement = '-001';
                    if ($managerAuthorizationSettingsData['allow_authorization_code'] == 1 && $managerAuthorizationSettingsData['type_of_document_issuance'] == 0 && $managerAuthorizationSettingsData['type_process'] == 1) {
                        $allowSequential = true;
                        $codeManagement = '002';
                    } else if ($managerAuthorizationSettingsData['allow_authorization_code'] == 1 && $managerAuthorizationSettingsData['type_of_document_issuance'] == 1 && $managerAuthorizationSettingsData['type_process'] == 1) {
                        $allowSequential = true;
                        $codeManagement = '003';

                    } else if ($managerAuthorizationSettingsData['allow_authorization_code'] == 0 && $managerAuthorizationSettingsData['type_of_document_issuance'] == 0 && $managerAuthorizationSettingsData['type_process'] == 1) {
                        $allowSequential = true;
                        $codeManagement = '004';

                    }
                    $type_of_document_issuance = $managerAuthorizationSettingsData['type_of_document_issuance'];
                }
                $invoice_code = $_POST["data_factura_encabezado"]["codigo_factura"];
                if ($allowSequential) {
                    $numberRow = $modelIS->getNumberLastInvoice(array(
                        'business_id' => $entidad_data_id
                    ));
                    if (!$numberRow) {//When empty to registers by invoice table
                        $numberRowCodec = 1;

                    } else {
                        $numberRowCodec = $numberRow->codigo_factura + 1;
                    }
                    $invoice_code = $numberRowCodec;
                }

                $codigo_documento = $_POST["data_factura_encabezado"]["tipo_factura"]["text"] . " #" . $_POST["data_factura_encabezado"]["establecimiento"] . "-" . $_POST["data_factura_encabezado"]["punto_emision"] . "-" . $numberRowCodec;
                $type_of_document_issuance = $type_of_document_issuance;
                $TipoComprobante = $_POST["data_factura_encabezado"]['TipoComprobante'];
                $type_descuento = $_POST["data_factura_encabezado"]["type_descuento"] == "true" ? $INVOICE_TYPE_PERCENTAGE : $PRODUCTO_TYPE_CASH;
                $discount_type_invoice = (isset($_POST["data_factura_encabezado"]["type_descuento_factura"]) ? ($_POST["data_factura_encabezado"]["type_descuento_factura"] == "true" ? $INVOICE_TYPE : $PRODUCTO_TYPE) : $INVOICE_TYPE);
                $attributesSetInvoice = [
                    'customer_id' => $cliente_id,
                    'invoice_code' => $invoice_code,
                    'invoice_value' => $_POST["data_factura_encabezado"]["valor_factura"],
                    'discount_value' => $_POST["data_factura_encabezado"]["valor_descuento"],
                    'status' => $estado,
                    'created_at' => $fecha,
                    'user_id' => $owner_id,
                    'observations' => $observaciones,
                    'value_taxes' => $_POST["data_factura_encabezado"]["valor_impuestos"],
                    'subtotal' => $_POST["data_factura_encabezado"]["subtotal_encabezado"],
                    'invoice_date' => $_POST["data_factura_encabezado"]["fecha_factura_save"],
                    'establishment' => $_POST["data_factura_encabezado"]["establecimiento"],
                    'emission_point' => $_POST["data_factura_encabezado"]["punto_emision"],
                    'voucher_type_id' => $TipoComprobante['id'],
                    'mixed_payment' => $_POST["data_factura_encabezado"]["pago_mixto"],
                    'has_retention' => $_POST["data_factura_encabezado"]["has_retencion"],
                    'now_after_retention' => $_POST["data_factura_encabezado"]["now_after_retencion"],
                    'debt' => $_POST["data_factura_encabezado"]["deuda"],
                    'type_of_discount' => $type_descuento,
                    'discount_type_invoice' => $discount_type_invoice,
                    'authorization_number' => $_POST["data_factura_encabezado"]["no_autorizacion"] == '' ? 4565 : $_POST["data_factura_encabezado"]["no_autorizacion"],
                    'type_of_document_issuance' => $type_of_document_issuance,


                ];
                $paramsValidate = array(
                    'modelAttributes' => $attributesSetInvoice,
                    'rules' => self::getRulesModel(),

                );
                $validateInvoice = $this->validateModel($paramsValidate);

                if ($validateInvoice['success']) {
                    $modelInvoice->fill($attributesSetInvoice);
                    $modelInvoice->save();
                    $invoiceId = $modelInvoice->id;
                    if (($_POST["configPayment"]["hasIndebtedness"] == "true")) {//si existe diferencia esta pendiente
                        $modelIPendient = new \App\Models\InvoiceSaleByPendient();
                        if ($headerInvoice["pendiente"] == "t" && $hasRetention == "true") {

                            $resultInvoice = $diferencia - $_POST["data_retenciones"] ["Valor_retencion"];
                            $resultSum = number_format($resultInvoice, $roundManager, '.', '');//VALIDATION
                            $diferencia = $resultSum;
                        }

                        $attributesSetPendient = [
                            'indebtedness_paying' => $diferencia,
                            'invoice_sale_id' => $invoiceId,

                        ];
                        $paramsValidate = array(
                            'modelAttributes' => $attributesSetPendient,
                            'rules' => $modelIPendient::getRulesModel(),

                        );
                        $validateInvoice = $modelIPendient->validateModel($paramsValidate);

                        if ($validateInvoice['success']) {

                            $modelIPendient->fill($attributesSetPendient);
                            $modelIPendient->save();
                        } else {
                            $success = false;
                            $resultSaveAll = $success;
                            $msjError = "Error Pendiente ";
                            $resultSaveAll = false;
                            $result['success'] = $resultSaveAll;
                            throw new \Exception($msjError);
                        }
                    }

                    //                ---GUARDAR LOS TIPOS DE ANEXOS--
                    $params_save = array();
                    $model_atr = new \App\Models\InvoiceSaleByTransactionalAnnex;
                    $key_factura_name = "invoice_sale_id";
                    $gshc_id = $_POST["data_factura_encabezado"]["TipoComprobante"]["id"];

                    $gestion_sustento_has_comprobante_id = $gshc_id;
                    $params_save[$key_factura_name] = $invoiceId;
                    $params_save["management_livelihood_by_voucher_id"] = $gestion_sustento_has_comprobante_id;
                    $attributesSet = $params_save;
                    $paramsValidate = array(
                        'modelAttributes' => $attributesSet,
                        'rules' => $model_atr::getRulesModel(),

                    );
                    $validateCurrent = $model_atr->validateModel($paramsValidate);
                    if ($validateCurrent['success']) {
                        $model_atr->fill($attributesSet);
                        $model_atr->save();
                    } else {
                        $result['success']["AnexoTransaccionalRegistros"] = false;
                        $result['errors']["AnexoTransaccionalRegistros"] = $validateCurrent['errors'];
                    }
                    $success = true;
//    --------GUARDADA FACTURA EMPRESA---
                    $model_entidad_f = new \App\Models\EntityHasInvoiceSale();
                    $params_data = array();
                    $key_parent_factura = "factura_venta_id";
                    $params_data[$key_parent_factura] = $invoiceId;
                    $params_data["entidad_data_id"] = $entidad_data_id;
                    $model_entidad_f->fill($params_data);
                    $model_entidad_f->save();
                    //                ----end AGREGAR D QUE EMPRESA---
                    // INIT guarda factura detalle
                    $model_detalle_name = "FacturaDetalleVenta";
                    $modelKP = new AverageKardex();
                    $modelPTM = new ProductMeasureType();
                    $modelPTManager = new  ProductMeasureType();
                    $modelPBD = new ProductByDetails();

                    $type = "sale";
                    $modelPIManager = new \App\Models\ProductInventory();
                    foreach ($_POST["data_factura_detalle"] as $key => $value) {


                        $cantidad = $value["cantidad"];
                        $precio_venta = $value["precio_venta"];
                        $porcentaje_descuento = $value["porcentaje_descuento"];
                        $porcentaje_iva = $value["porcentaje_iva"];
                        $producto_id = $value['producto_id'];
                        $type_producto = isset($value["typeProduct"]) ? $value["typeProduct"] : "true"; //false producto,true=servicio
                        if ($type_producto == "true") {

                            /* KARDEX CURRENT*/
                            $measure_id = $value["measure_id"];
                            $measure_type_box = $value["measure_type_box"];
                            $measure_box_units = $value["measure_box_units"];
                            $managerTypeContent = $value["managerTypeContent"];
                            $currentKardexProduct = $modelKP->getCurrentKardexProduct(array("product_id" => $producto_id, "entidad_data_id" => $entidad_data_id));

                            $entidad_id = $invoiceId;
                            $entidad = "factura_venta";
                            $resultKardex = $modelKP->managementInputsOutputsInventory(array(
                                "dataKardexCurrent" => $currentKardexProduct,
                                "cantidad" => $cantidad,
                                "descuento" => $porcentaje_descuento,
                                "precio" => $precio_venta,
                                "type" => $type,
                                "producto_id" => $producto_id,
                                "entidad_data_id" => $entidad_data_id,
                                "entidad_id" => $entidad_id,
                                "entidad" => $entidad,
                                "entidad_fecha" => $fecha,
                                "documentInformation" => $codigo_documento,
                                "measure_id" => $measure_id,
                                "measure_type_box" => $measure_type_box,
                                "measure_box_units" => $measure_box_units,
                                "managerTypeContent" => $managerTypeContent,


                            ));

                            if ($resultKardex["success"]) {
                                $rowKardex = $resultKardex["rowKardex"];
                                $subt_kardex = number_format($rowKardex["subt_kardex"], $roundManager, '.', '');
                                $valor_costo += number_format($subt_kardex, $roundManager, '.', '');
                            }

                        }

                        $modelInvoiced = new \App\Models\InvoiceSaleByDetails();
                        $producto_id = $value["producto_id"];
                        $cantidad = $value["cantidad"];
                        $cantidad_unidades = $value["cantidad_unidades"];
                        $porcentaje_descuento = $value["porcentaje_descuento"];//$INVOICE DISCOUNT
                        $porcentaje_descuento_unidad = isset($value["porcentaje_descuento_unidad"]) ? $value["porcentaje_descuento_unidad"] : 0;
                        $valor_descuento = $value["valor_descuento"];
                        $valor_descuento_unidad = $value["valor_descuento_unidad"];
                        $precio_unitario = $value["precio_unitario"];
                        $precio_unitario_unidad = $value["precio_unitario_unidad"];
                        $tipo_gestion = $value["tipo_gestion"];
                        $porcentaje_iva = $value["porcentaje_iva"];
                        $subtotal = $value["subtotal_descuento"];
                        $typeProduct = $value["typeProduct"];
                        $description = isset($value["description"]) ? $value["description"] : "INVENTARIO";
                        $total = $value["total"];
                        $description = $description;
                        $type_product = $typeProduct == "false" ? 1 : 0;
                        $facturaVenta_id = $invoiceId;
                        $valor_kardex_promedio = ($value["kardex_promedio"] == "NaN") ? 0 : $value["kardex_promedio"];//cuando es servicio
                        $valor_kardex_promedio = $valor_kardex_promedio;
                        $ganancia = isset($value["ganancia"]) ? $value["ganancia"] : 0;


                        $attributesSet = [
                            'product_id' => $producto_id,//*
                            'quantity' => $cantidad,
                            'quantity_unit' => $cantidad_unidades,
                            'discount_percentage' => $porcentaje_descuento,
                            'discount_percentage_unit' => $porcentaje_descuento_unidad,
                            'discount_value' => $valor_descuento,
                            'discount_value_unit' => $valor_descuento_unidad,
                            'unit_price' => $precio_unitario,
                            'unit_price_unit' => $precio_unitario_unidad,
                            'management_type' => $tipo_gestion,
                            'tax_percentage' => $porcentaje_iva,
                            'subtotal' => $subtotal,//*
                            'total' => $total,//*
                            'description' => $description,
                            'product_type' => $type_product,
                            'invoice_sale_id' => $facturaVenta_id//*
                        ];
                        $paramsValidate = array(
                            'modelAttributes' => $attributesSet,
                            'rules' => $modelInvoiced::getRulesModel(),

                        );
                        $validateCurrent = $modelInvoiced->validateModel($paramsValidate);
                        $validateInvoiced = $validateCurrent['success'];
                        if ($validateInvoiced) {
                            $modelInvoiced->fill($attributesSet);
                            $modelInvoiced->save();
                            if ($type_producto == "true") {

                                /* PRODUCT CURRENT*/

                                $params_data_search = array('product_id' => $producto_id, "business_id" => $entidad_data_id);

                                $modelPI = $modelPIManager->findByAttributes($params_data_search);
                                $producto_inventario_current_id = null;
                                $allowKardex = count($currentKardexProduct);
                                if ($modelPI == null) {

                                } else {

                                    if ($resultKardex["success"]) {
                                        $rowKardex = $modelKP->getValuesInputsOutputsInventory($resultKardex);


                                        $attributesData = array_merge($rowKardex, (array)$modelPI);

                                        $modelPI->attributes = $attributesData;
                                        $modelPIManager->attributes = $attributesData;
                                        $validatePIManager = $modelPIManager->validate();
                                        $validatePI = $validatePIManager['success'];
                                        if ($validatePI) {
                                            $modelCurrentSave = new  \App\Models\ProductInventory();
                                            $modelPI = $modelCurrentSave->find($modelPI->id);
                                            $modelPI->fill($attributesData);
                                            $modelPI->save();
                                            $producto_inventario_current_id = $modelPI->id;

                                        } else {
                                            $msjError = "Factura ProductoInventario Error";
                                            $resultSaveAll = false;
                                            $result['success'] = $resultSaveAll;
                                            throw new \Exception($msjError);
                                        }
                                    } else {

                                        $msjError = "Factura KardexPromedio Error <br>";
                                        $resultSaveAll = false;

                                        foreach ($resultKardex["errors"] as $key => $value) {
                                            $msjError .= "" . $value . "<br>";
                                        }
                                        $result['success'] = $resultSaveAll;
                                        throw new \Exception($msjError);
                                    }

                                    /*   INIT   UNITY BOX*/

                                    $measure_id = $value["measure_id"];
                                    $producto_tipo_medida_id = $measure_id;
                                    $measure_type_box = $value["measure_type_box"];
                                    $measure_box_units = $value["measure_box_units"];

                                    $modelPTM = $modelPTManager->findByPk($measure_id);
                                    if ($measure_type_box == 0) {//container units

                                        $modelPD = $modelPBD->findByAttributes(array(
                                            "product_id" => $producto_id
                                        ));
                                        $managerTypeContent = $value["managerTypeContent"];
                                        $has_unity_box = true;
                                        $modelPBP = new \App\Models\ProductInventoryByPriceUnityBox();
                                        $pd_control_stock = $modelPD->stock_control;
                                        $pd_control_stock_inicial = $modelPD->initial_stock_control;

                                        $producto_inventario_id = $producto_inventario_current_id;
                                        $precio = $precio_venta;
                                        $precio_unity_box = ($precio) / $modelPTM->number_of_units;
                                        $eip_cantidad = $cantidad;
                                        $modelPBPUB = $modelPBP->findByAttributes(array(
                                            "product_inventory_id" => $producto_inventario_id
                                        ));
                                        if ($modelPBPUB) {

                                            $pbpb_id = $modelPBPUB->id;
                                            $resultPrices = $modelPBP->saveProductsInventoryProcessInvoice(array(
                                                "pd_control_stock" => $pd_control_stock,
                                                "pd_control_stock_inicial" => $pd_control_stock_inicial,
                                                "producto_tipo_medida_id" => $producto_tipo_medida_id,
                                                "precio_unity_box" => $precio_unity_box,
                                                "has_unity_box" => $has_unity_box,
                                                "createUpdate" => false,
                                                "producto_inventario_id" => $producto_inventario_id,
                                                "cantidad" => $eip_cantidad,
                                                "typeInvoice" => $type,
                                                "pbpb_id" => $pbpb_id,
                                                "managerTypeContent" => $managerTypeContent
                                            ));
                                            if ($resultPrices["success"]) {
                                                $resultSaveAll = true;

                                            } else {
                                                $msjError = "Error ProductoHasPrecios Invoice " . $type . $resultPrices["msj"];
                                                $resultSaveAll = false;
                                                $result['success'] = $resultSaveAll;
                                                throw new \Exception($msjError);

                                            }
                                        }


                                    }
                                    /*    END  UNITY BOX*/


                                }
                            }

                        } else {
                            $result['errors'][$key]["detalle"] = $validateCurrent['errors'];

                            $msjError = "Factura Detalle Error";
                            $resultSaveAll = false;
                            $result['success'] = $resultSaveAll;
                            throw new \Exception($msjError);
                        }
                    }

                    $costsValue = $valor_costo;
                    $headerInvoice["id"] = $invoiceId;

                    $typeManager = "sale";
                    $headerInvoice['codigo_factura'] = $numberRowCodec;
                    /* */
                    $params = array(
                        "typeManager" => $typeManager,
                        "key_relacion_transaccion" => "factura_venta_id",
                        "key_factura_deuda" => "factura_venta_id",
                        "models" => array(
                            "modelFactura" => "FacturaVenta",
                            "modelFacturaDetalle" => "FacturaDetalleVenta",
                            "modelHasFacturaTransacciones" => "FacturaVentaHasTransacciones",
                            "modelHasFacturaRetenciones" => "FacturaVentasHasRetenciones",
                            "modelPayHasFactura" => "PagosVentasHasEntidad",
                            "modelHasDeuda" => "PagosVentasHasEntidad"
                        ),
                        "tables" => array(
                            "tableFactura" => "factura_venta",
                            "tablelHasFacturaRetenciones" => "factura_ventas_has_retenciones",
                        ),
                        "invoice" => array("details" => $detailsInvoice, "header" => $headerInvoice),
                        "retention" => array("details" => $detailsRetention, "header" => $headerRetention),
                        "payment" => array("details" => $detailsPaymentMethods, "header" => $headerPaymentMethods),
                        "configPayment" => $configPayment,
                        "costsValue" => $costsValue,
                        "allow_cash_and_banks" => $_POST["allow_cash_and_banks"],
                        "entityId" => $entidad_data_id,
                        'user_id' => $user_id

                    );
                    //THIS FALTA
                    //SAVE ACCOUNTING
                    $accountingSeat = $this->getAllAccountingSeatProcess($params);

                    $fecha_factura = $headerInvoice["fecha_factura_save"];
                    foreach ($accountingSeat as $key => $row) {


                        $modelALD = new \App\Models\DailyBookSeat;


                        $setPushCurrent = [
                            'value' => $row['value'],
                            'description' => $row['descripcion'],
                            'created_at' => $row['fecha_creacion'],
                            'register_manager_date' => $row['fecha_factura'],
                            'status' => 'ACTIVE',
                            "entidad_data_id" => $entidad_data_id,

                        ];

                        $dataLibroDiario = $row["childrens"];

                        $paramsValidate = array(
                            'modelAttributes' => $setPushCurrent,
                            'rules' => $modelALD::getRulesModel(),

                        );
                        $validateCurrent = $modelALD->validateModel($paramsValidate);
                        $validateInvoiced = $validateCurrent['success'];
                        if ($validateInvoiced) {
                            $modelALD->fill($setPushCurrent);
                            $modelALD->save();
                            $asiento_libro_diario_id = $modelALD->id;

                            $modelSBI = new \App\Models\InvoiceSaleByBookSeat();
                            $key_relation_invoice = "invoice_sale_id";
                            $setPush = array(
                                "manager_type" => 0,
                                "created_at" => $fecha,
                                "daily_book_seat_id" => $asiento_libro_diario_id,

                                $key_relation_invoice => $invoiceId);
                            $modelSBI->fill($setPush);
                            $modelSBI->save();

                            foreach ($dataLibroDiario as $key => $libroDiario) {


                                $modelLD = new \App\Models\DiaryBook();

                                $attributesLD = [

                                    'value' => $libroDiario['valor'],//*
                                    'manager_type' => $libroDiario['type_ingreso'],//*
                                    'accounting_account_id' => $libroDiario['accounting_account_id'],//*
                                ];
                                $dataHas = $libroDiario["data"];
                                $setPushCurrent = $attributesLD;

                                $paramsValidate = array(
                                    'modelAttributes' => $setPushCurrent,
                                    'rules' => $modelLD::getRulesModel(),

                                );
                                $validateCurrent = $modelLD->validateModel($paramsValidate);
                                $validateInvoiced = $validateCurrent['success'];
                                if ($validateInvoiced) {
                                    $modelLD->fill($setPushCurrent);
                                    $modelLD->save();
                                    $libro_diario_id = $modelLD->id;
                                    if (isset($dataHas["isChildren"])) {//FacturaComprasHasRetenciones
                                        $parent = $dataHas["parent"];
                                        $modelParent = new $parent["model"];
                                        $attributesParent = $parent["attributes"];

                                        $modelParent->attributes = $attributesParent;
                                        $modelParent->fecha_factura = $attributesParent["fecha_factura"];
                                        $modelParent->fecha_creacion = $attributesParent["fecha_creacion"];
                                        if ($modelParent->validate()) {
                                            $modelParent->save();
                                            $dataHas["entidad_id"] = $modelParent->id;
                                            $success = true;
                                            $resultSaveAll = true;
                                        } else {
                                            $success = false;
                                            $resultSaveAll = $success;

                                            $msjError = "Error FacturaComprasHasRetenciones ";
                                            $resultSaveAll = false;
                                            $result['success'] = $resultSaveAll;
                                            foreach ($modelParent->errors as $key => $value) {

                                                $msjError .= " < br>" . $value;
                                            }
                                            throw new \Exception($msjError);
                                        }
                                    }
                                    if (isset($dataHas["save"])) {//modelHasFacturaTransacciones
                                        $dataTransaction = $dataHas["save"];
                                        $modelTransactions = new \App\Models\InvoiceSaleByTransactions;

                                        $attributesTransactions = [
                                            'percentage_discount' => 0,
                                            'value_discount' => 0,
                                            'subtotal' => $dataTransaction['attributes']['subtotal'],//*
                                            'total' => $dataTransaction['attributes']['total'],//*
                                            'account' => 0,
                                            'accounting_account_id' => $dataTransaction['attributes']['accounting_account_id'],//*
                                            'way_to_pay' => $dataTransaction['attributes']['forma_pago'],//*
                                            'type_payment_id' => $dataTransaction['attributes']['type_payment_id'],//*
                                            'invoice_sale_id' => $invoiceId//*

                                        ];


                                        $setPushCurrent = $attributesTransactions;

                                        $paramsValidate = array(
                                            'modelAttributes' => $attributesTransactions,
                                            'rules' => $modelTransactions::getRulesModel(),

                                        );
                                        $validateCurrent = $modelTransactions->validateModel($paramsValidate);
                                        $validateInvoiced = $validateCurrent['success'];
                                        if ($validateInvoiced) {
                                            $modelTransactions->fill($attributesTransactions);
                                            $modelTransactions->save();
                                            $success = true;
                                            $resultSaveAll = true;
                                        } else {
                                            $success = false;
                                            $resultSaveAll = $success;
                                            $msjError = "Error modelHasFacturaTransacciones ";
                                            $resultSaveAll = false;
                                            $result['success'] = $resultSaveAll;
                                            foreach ($validateCurrent['errors'] as $key => $value) {

                                                $msjError .= " < br>" . $value;
                                            }

                                            throw new \Exception($msjError);
                                        }
                                        $exist = isset($dataTransaction["save"]);
                                        if ($exist) {//payhasfactura
                                            $dataPay = $dataTransaction["save"];
                                            $modelPay = new $dataPay["model"];
                                            $attributesPay = $dataPay["attributes"];
                                            $modelPay->attributes = $attributesPay;
                                            if ($modelPay->validate()) {
                                                $modelPay->save();
                                                $success = true;
                                                $resultSaveAll = true;
                                            } else {
                                                $success = false;
                                                $resultSaveAll = $success;

                                                $msjError = "Error payhasfactura ";
                                                $resultSaveAll = false;
                                                $result['success'] = $resultSaveAll;
                                                foreach ($modelPay->errors as $key => $value) {

                                                    $msjError .= " < br>" . $value;
                                                }
                                                throw new \Exception($msjError);
                                            }
                                        }

                                    }
                                    $modelEHL = new   \App\Models\BusinessByDailyBookSeat;

                                    $setPushCurrent = [
                                        'daily_book_seat_id' => $asiento_libro_diario_id,//*
                                        'diary_book_id' => $libro_diario_id,//*
                                        'business_id' => $entidad_data_id,//*
                                        'entity' => $dataHas['entidad'],
                                        'entity_id' => $dataHas['entidad_id'],
                                        'user_id' => $dataHas['owner_id'],//*
                                        'level_4' => $dataHas['nivel_4'],
                                    ];
                                    $paramsValidate = array(
                                        'modelAttributes' => $setPushCurrent,
                                        'rules' => $modelEHL::getRulesModel(),

                                    );
                                    $validateCurrent = $modelEHL->validateModel($paramsValidate);
                                    $validateInvoiced = $validateCurrent['success'];

                                    if ($validateInvoiced) {
                                        $modelEHL->fill($setPushCurrent);
                                        $modelEHL->save();
                                        $success = true;
                                        $resultSaveAll = true;
                                    } else {
                                        $success = false;
                                        $resultSaveAll = $success;

                                        $msjError = "Error  \App\Models\BusinessByDailyBookSeat ";
                                        $resultSaveAll = false;
                                        $result['success'] = $resultSaveAll;
                                        foreach ($validateInvoiced['errors'] as $key => $value) {

                                            $msjError .= " < br>" . $value;
                                        }
                                        $result['success'] = $resultSaveAll;
                                        throw new \Exception($msjError);
                                    }
                                } else {
                                    $success = false;
                                    $resultSaveAll = $success;

                                    $msjError = "Error LibroDiario ";
                                    $resultSaveAll = false;
                                    $result['success'] = $resultSaveAll;
                                    $resultSaveAll = false;
                                    $result['errors'] = $validateCurrent['errors'];

                                    foreach ($validateCurrent['errors'] as $key => $value) {

                                        $msjError .= " < br>" . $value;
                                    }
                                    $result['success'] = $resultSaveAll;
                                    throw new \Exception($msjError);
                                }


                            }
                        } else {
                            $success = false;
                            $resultSaveAll = $success;
                            $msjError = "Error AsientoLibroDiario ";
                            $resultSaveAll = false;
                            foreach ($validateCurrent['errors'] as $key => $value) {

                                $msjError .= " < br>" . $value;
                            }
                            $result['success'] = $resultSaveAll;
                            throw new \Exception($msjError);
                        }

                    }

                    //SAVE ACCOUNTING
                    /*saveModelDataIndirect($params);*/
                    $allow_cash_and_banks = $_POST["allow_cash_and_banks"];
                    $mixedPayment = $_POST["configPayment"]['mixed'];//true=not breakdown,false=breakdown
                    if ($allow_cash_and_banks == true) {
                        if ($estado == 'PENDIENTE' && $mixedPayment == 'true') {// do nothing
                            $success = true;
                            $resultSaveAll = $success;

                        } else {
                            $typeProcess = "sales";
                            $modeCBM = new CashByMovement();
                            $modeCBB = new BankByMovement();

                            if ($configPayment["mixed"] == "false") {//PAYMENT MIXED
                                /*CASH*/

                                $dataAttributesCBM = $modeCBM->getDataAttributesDataIndirect(array(
                                    "haystack" => $detailsPaymentMethods,
                                    "date_current" => $fecha_factura,
                                    "entity_id" => $invoiceId,
                                ));
                                foreach ($dataAttributesCBM as $key => $value) {
                                    $type_payment = $value["type_payment"];
                                    $attributes = $value;
                                    $resultSave = $modeCBM->saveModelDataIndirect(array(
                                        "type_payment" => $type_payment,
                                        "typeProcess" => $typeProcess,
                                        "date_current" => $fecha_factura,
                                        "entidad_data_id" => $entidad_data_id,
                                        "attributes" => $attributes,
                                        "documentNumberInvoice" => $codigo_documento,
                                        'allowLog' => true,
                                        'cash_management_current_id' => $cash_management_current_id
                                    ));

                                    if (!$resultSave["success"]) {

                                        $success = false;
                                        $resultSaveAll = $success;
                                        $msjError = "Error saveModelDataIndirect " . $resultSave["msj"];
                                        $resultSaveAll = false;
                                        $result['success'] = $resultSaveAll;
                                        $result['errors'] = $resultSave["errors"];


                                        throw new \Exception($msjError);

                                    } else {
                                        $success = true;
                                        $resultSaveAll = $success;

                                    }

                                }


                                $dataAttributesCBB = $modeCBB->getDataAttributesDataIndirect(array(
                                    "haystack" => $detailsPaymentMethods,
                                    "date_current" => $fecha_factura,
                                    "entity_id" => $invoiceId,
                                ));

                                foreach ($dataAttributesCBB as $key => $value) {
                                    $type_payment = $value["type_payment"];

                                    $attributes = $value;
                                    $attributes['entity_type'] = $entityTypeCurrent;
                                    $paramsSendCurrent = array(
                                        "type_payment" => $type_payment,
                                        "typeProcess" => $typeProcess,
                                        "date_current" => $fecha_factura,
                                        "entidad_data_id" => $entidad_data_id,
                                        "attributes" => $attributes,
                                        "documentNumberInvoice" => $codigo_documento,
                                        'allowLog' => true,
                                        'cash_management_current_id' => $cash_management_current_id

                                    );

                                    $resultSave = $modeCBB->saveModelDataIndirect($paramsSendCurrent);

                                    if (!$resultSave["success"]) {
                                        $success = false;
                                        $resultSaveAll = $success;
                                        $msjError = "Error saveModelDataIndirect Bank " . $resultSave["msj"];
                                        $resultSaveAll = false;
                                        $result['success'] = $resultSaveAll;
                                        $result['errors'] = $resultSave["errors"];
                                        throw new \Exception($msjError);

                                    } else {
                                        $success = true;
                                        $resultSaveAll = $success;
                                        $success = $resultSaveAll;
                                    }

                                }

                            } else {
                                $totalConRetencion = $_POST["data_factura_encabezado"]["totalConRetencion"];
                                if (($_POST["allow_cash_and_banks"]) == 'true') {
                                    $generalInboxAccountId = -1;
                                    $modelCBU = new CashByUser;

                                    $resultCUBC = $modelCBU->getCashUserByCurrent(array("entidad_data_id" => $entidad_data_id));
                                    if ($resultCUBC) {
                                        $generalInboxAccountId = $resultCUBC["accounting_account_id"];
                                        $cash_id = $resultCUBC["cash_id"];

                                        $movement_type = 0;
                                        $accounting_account_id = $generalInboxAccountId;
                                        $cash_reason_id = 4;
                                        $entity_type = $entityTypeCurrent;
                                        $rode = $totalConRetencion;
                                        $details = "";
                                        $entity_id = $invoiceId;
                                        $transaction_type = 0;
                                        $available_balance = 0;
                                        $type_payment = TiposDePagos::TYPE_PAYMENT_CASH;
                                        $attributes = array(
                                            "cash_id" => $cash_id,
                                            "user_id" => $owner_id,
                                            "movement_type" => $movement_type,
                                            "cash_reason_id" => $cash_reason_id,
                                            "accounting_account_id" => $accounting_account_id,
                                            "details" => $details,
                                            "rode" => $rode,
                                            "date_current" => $fecha_factura,
                                            "transaction_type" => $transaction_type,
                                            "entity_type" => $entity_type,
                                            "entity_id" => $entity_id,
                                            "update_at" => $fecha,
                                            "available_balance" => $available_balance,
                                            "type_payment" => $type_payment,
                                        );

                                        $resultSave = $modeCBM->saveModelDataIndirect(array(
                                            "type_payment" => $type_payment,
                                            "typeProcess" => $typeProcess,
                                            "date_current" => $fecha_factura,
                                            "entidad_data_id" => $entidad_data_id,
                                            "attributes" => $attributes,
                                            "documentNumberInvoice" => $codigo_documento,
                                            'allowLog' => true,
                                            'cash_management_current_id' => $cash_management_current_id

                                        ));

                                        if (!$resultSave["success"]) {

                                            $success = false;
                                            $resultSaveAll = $success;
                                            $msjError = "Error " . $resultSave["msj"];
                                            $resultSaveAll = false;
                                            $result['success'] = $resultSaveAll;
                                            $result['errors'] = $resultSave["errors"];
                                            throw new \Exception($msjError);
                                        } else {
                                            $success = true;
                                            $resultSaveAll = $success;
                                        }

                                    } else {
                                        $success = false;
                                        $resultSaveAll = $success;
                                        $msjError = "Error get User Account Cash  ";
                                        $resultSaveAll = false;
                                        $result['success'] = $resultSaveAll;
                                        $result['errors'] = array();
                                        throw new \Exception($msjError);
                                    }
                                } else {

                                }


                            }

                        }


                    }

                } else {
                    $success = false;
                    $resultSaveAll = false;
                    $success = $resultSaveAll;
                    $result['success'] = $success;
                    $msj = "Error Al registrar la Factura . ";
                    $result['msj'] = $msj;
                    $msjError = $msj;
                    $errors = $validateInvoice["errors"];
                    $result['errors'] = $errors;
                    $resultSaveAll = false;
                    $result['success'] = $resultSaveAll;

                    throw new \Exception($msjError);
                }

            } else {

                $error = $managerResultsProcess['error'];
                $typeError = $managerResultsProcess['typeError'];
                $success = false;
                $resultSaveAll = false;
                $success = $resultSaveAll;
                $result['success'] = $success;
                $msj = $error;
                $result['msj'] = $msj;
                $result['errors'] = $modelInvoice->errors;
                $msjError = $msj;
                $resultSaveAll = false;
                $result['success'] = $resultSaveAll;

                throw new \Exception($msjError);
            }
            if ($resultSaveAll) {
                $resultSaveAll = true;
                $success = $resultSaveAll;

                DB::commit();

            } else {
                $success = false;

                DB::rollBack();

            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success


            ];
            $result['id_factura'] = $invoiceId;
            $result['invoiceCurrent'] = $modelInvoice->attributes;
            $result['success'] = $success;
            return ($result);
        } catch (\Exception $e) {
            $success = false;
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => 'Error interno Comuniquese con Soporte Tecnico.',
                "errors" => $errors,
                'msjServer' => $msj

            );
            DB::rollBack();
            return ($result);
        }

    }

    public function getNumberLastInvoice($params)
    {
        $businessId = $params["business_id"];
        $query = DB::table($this->table);
        $getSelectBeeString = "$this->table.invoice_code codigo_factura
 ";
        $sort = 'desc';

        $select = DB::raw($getSelectBeeString);
        $query->select($select);
        $query->join('entity_has_invoice_sale', $this->table . ".id", '=', 'entity_has_invoice_sale.factura_venta_id');
        $query->where('entity_has_invoice_sale.entidad_data_id', '=', $businessId);
        $query->orderBy($this->table . '.id', $sort);

        $result = $query->first();
        return $result;
    }

    public function getTypeDataInventory($details, $type)
    {
        $result = [];
        $haystack = $details;//stack consul
        $result = \App\Utils\Util::searchDataByParams(array("keySearch" => "typeProduct", "valueComparate" => $type, "haystack" => $haystack));
        return $result;
    }

    public function getAllAccountingSeatProcess($params)
    {
        $typeManager = $params["typeManager"];
        $user_id = $params["user_id"];

        $allow_cash_and_banks = $params["allow_cash_and_banks"];
        $entityId = $params["entityId"];
        $roundManager = \App\Utils\Accounting\UtilAccounting::managerRound;
        $utilAccounting = new \App\Utils\Accounting\UtilAccounting;
        $accountingSeatResult = array();
        $modelACMABC = new \App\Models\AccountingConfigModulesAccountByAccount;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$inventario_y_mercaderias);
        $inventoryAccountId = $model_cmc->accounting_account_id;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$ventas);
        $salesAccountId = $model_cmc->accounting_account_id;
        $model_cmc = $modelACMABC->findByPk($modelACMABC::$ventas_con_iva_gravado);
        $taxAccountId = $model_cmc->accounting_account_id;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$descuento_en_compras);
        $discoutnAccountId = $model_cmc->accounting_account_id;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$transportes_fletes);
        $freightAccountId = $model_cmc->accounting_account_id;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$clientes);
        $supplierCustomerAccountId = $model_cmc->accounting_account_id;


        $model_cmc = $modelACMABC->findByPk($modelACMABC::$descuento_en_ventas);
        $cuenta_save_factura_descuentos_id = $model_cmc->accounting_account_id;

        $model_cmc = $modelACMABC->findByPk($modelACMABC::$costo_de_ventas);
        $costsId = $model_cmc->accounting_account_id;

        /* --------PAYMENTS METHODS----*/
        $model_cmc = $modelACMABC->findByPk($modelACMABC::$tarjeta_de_credito);
        $creditCardAccountId = $model_cmc->accounting_account_id;

        $generalInboxAccountId = -1;

        if ($allow_cash_and_banks == 'false') {
            $model_cmc = $modelACMABC->findByPk($modelACMABC::$caja_general);
            $generalInboxAccountId = $model_cmc->accounting_account_id;
        } else {
            $modelCBU = new CashByUser;
            $resultCUBC = $modelCBU->getCashUserByCurrent(array("entidad_data_id" => $entityId));
            if ($resultCUBC) {
                $generalInboxAccountId = $resultCUBC["accounting_account_id"];
            }
        }
        /* STATES*/
        $configAccountId = $typeManager == "shopping" ? $modelACMABC::$cuentas_por_pagar : $modelACMABC::$cuentas_por_cobrar;
        $model_cmc = $modelACMABC->findByPk($configAccountId);
        $typeStatePaymentAccountId = $model_cmc->accounting_account_id;


        $owner_id = $user_id; //USUARIO QIEN GESTIONA

        $models = $params["models"];
        $tables = $params["tables"];

        $modelFactura = $models["modelFactura"];
        $tableFactura = $tables["tableFactura"];
        $modelFacturaDetalle = $models["modelFacturaDetalle"];

        $modelHasFacturaTransacciones = $models["modelHasFacturaTransacciones"];
        $modelHasFacturaRetenciones = $models["modelHasFacturaRetenciones"];
        $tablelHasFacturaRetenciones = $tables["tablelHasFacturaRetenciones"];
        $key_relacion_transaccion = $params["key_relacion_transaccion"];

        $modelPayHasFactura = $models["modelPayHasFactura"];
        $modelHasDeuda = $models["modelHasDeuda"];
        $key_factura_deuda = $params["key_factura_deuda"];

        $fecha = \App\Utils\Util::DateCurrent();
        $result = array();
        $detailsInvoice = $params["invoice"]["details"];
        $headerInvoice = $params["invoice"]["header"];
        $invoiceId = $headerInvoice["id"];

        $valor_impuestos = $headerInvoice["valor_impuestos"];
        $subtotal = $headerInvoice["sub_total"];
        $entidad_data_id = $headerInvoice["entidad_id"];

        $codigo_documento = $headerInvoice["tipo_factura"]["text"] . '  Nro ' . $headerInvoice["establecimiento"] . '-' . $headerInvoice["punto_emision"] . "-" . $headerInvoice["codigo_factura"];


        $taxesValue = $headerInvoice["valor_impuestos"];
        $fecha_factura = $headerInvoice["fecha_factura_save"];

        $costsValue = $params["costsValue"];

        $DEBE = \App\Models\DiaryBook::DEBE;
        $HABER = \App\Models\DiaryBook::HABER;

        $dataLibroDiario1 = array();
        $dataLibroDiario2 = array();
        $dataLibroDiario3 = array();

        $value_gestion = "V/R Registro de la " . $codigo_documento;
        $dataSet = array("value" => $value_gestion, "descripcion" => "esto es la descripsion del asiento", "fecha_creacion" => $fecha, "fecha_factura" => $fecha_factura, "childrens" => array());
        $numberSeat = 0;
        $accountingSeatResult[$numberSeat] = $dataSet;

        $inventoryData = $this->getTypeDataInventory($detailsInvoice, "true");
        $gastosData = $this->getTypeDataInventory($detailsInvoice, "false");
        $discountTotalInventory = 0;
        $discountTotalExpenses = 0;
        $sumInventoryAll = 0;
        $sumExpendAll = 0;
        $sumRetentionAll = 0;
        $msjOkCustomerManager = $typeManager == "shopping" ? "Pago" : "Cobro";

        $gastosDataAux = array();
        $inventoryDataAux = array();

        $allowThirdSeat = false;

        if (count($inventoryData) > 0) {
            $allowThirdSeat = true;
            /*INVENTARIO LD*/
            $subtotal = Util::sumData(array("haystack" => $inventoryData, "keyGetValue" => "subtotal"));
            $valor_descuento = \App\Utils\Util::sumData(array("haystack" => $inventoryData, "keyGetValue" => "valor_descuento"));
            $discountTotalInventory = $valor_descuento;
            $sumInventory = $subtotal - $valor_descuento;
            $sumInventoryAll = \App\Utils\Util::sumData(array("haystack" => $inventoryData, "keyGetValue" => "total"));

            $entityHas = array();
            $nivel_4 = "inventoryData";
            $entityHas = array("nivel_4" => $nivel_4, "libro_diario_id" => null, "asiento_libro_diario_id" => null, "entidad_data_id" => $entidad_data_id, "entidad" => "inventoryData", "entidad_id" => "-1", "owner_id" => $owner_id);
            $setPush = array("valor" => $sumInventory, "accounting_account_id" => $salesAccountId, "type_ingreso" => $HABER, "data" => $entityHas);
            array_push($inventoryDataAux, $setPush);

        }


        $allowValuesGastos = count($gastosData) > 0;
        if ($allowValuesGastos) {

            /*SERVICIOS LD*/
            $accountData = array();


            foreach ($gastosData as $key => $value) {

                $valor = $value["subtotal"];
                $accountingSeat = $value["cccountingSeat"];
                $accounting_account_id = $accountingSeat["id"];
                if (!in_array($accounting_account_id, $accountData)) {
                    array_push($accountData, $accounting_account_id);
                }
                $gastosData[$key]["accounting_account_id"] = $accounting_account_id;

            }


            foreach ($accountData as $key => $value) {
                $resultCurrent = \App\Utils\Util::searchDataByParams(array("keySearch" => "accounting_account_id", "valueComparate" => $value, "haystack" => $gastosData));
                $subtotal = \App\Utils\Util::sumData(array("haystack" => $resultCurrent, "keyGetValue" => "subtotal"));
                $valor_descuento = \App\Utils\Util::sumData(array("haystack" => $resultCurrent, "keyGetValue" => "valor_descuento"));
                $valor = $subtotal - $valor_descuento;
                $sumExpendAll += \App\Utils\Util::sumData(array("haystack" => $resultCurrent, "keyGetValue" => "total"));
                $discountTotalExpenses = $valor_descuento;
                $type_ingreso = $HABER;

                $setPush = array();
                $entityHas = array();
                $nivel_4 = "gastosData";
                $entityHas = array("nivel_4" => $nivel_4, "libro_diario_id" => null, "asiento_libro_diario_id" => null, "entidad_data_id" => $entidad_data_id, "entidad" => "gastosData", "entidad_id" => "-1", "owner_id" => $owner_id);
                $setPush = array("valor" => $valor, "accounting_account_id" => $value, "type_ingreso" => $type_ingreso, "data" => $entityHas);
                array_push($gastosDataAux, $setPush);

            }


        }

        $detailsRetention = $params["retention"]["details"];
        $headerRetention = $params["retention"]["header"];

        $detailsPaymentMethods = $params["payment"]["details"];
        $headerPaymentMethods = $params["payment"]["header"];

        $configPayment = $params["configPayment"];
        $retentionHasFactura = array();
        if (isset($headerInvoice["flete"]) && $headerInvoice["flete"] != "0") {
            /*FLETE LD*/
            $valor = $headerInvoice["flete"];
            $accounting_account_id = $freightAccountId;
            $type_ingreso = $DEBE;
            $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Transportes_fletes;
            $entityHas = array();
            $accounting_account_id = $freightAccountId;
            $entityHas = array("nivel_4" => $nivel_4, "libro_diario_id" => null, "asiento_libro_diario_id" => null, "entidad_data_id" => $entidad_data_id, "entidad" => "flete", "entidad_id" => "-1", "owner_id" => $owner_id);
            $setPush = array("valor" => $valor, "accounting_account_id" => $accounting_account_id, "type_ingreso" => $type_ingreso, "data" => $entityHas);
            array_push($dataLibroDiario1, $setPush);

        }
        if ($configPayment["hasRetention"] == "true") {

            $accounting_account_id = $supplierCustomerAccountId;
            $type_ingreso = $DEBE;
            $libro_diario_id = null;
            $asiento_libro_diario_id = null;
            $entidad = "hasRetention";
            $entidad_id = "-1";
            $entityHas = array();
            $entityHas["libro_diario_id"] = $libro_diario_id;
            $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
            $entityHas["entidad_data_id"] = $entidad_data_id;
            $entityHas["entidad"] = $entidad;
            $entityHas["entidad_id"] = $entidad_id;
            $entityHas["owner_id"] = $owner_id;
            $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Proveedores;
            $entityHas["nivel_4"] = $nivel_4;

            $setPush = array();

            $resultSum = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');

            $sumRetentionAll = Util::sumData(array("haystack" => $detailsRetention, "keyGetValue" => "valor_retenido"));

            $valor = number_format($resultSum - $sumRetentionAll, $roundManager, '.', '');

            $setPush["valor"] = $valor;
            $setPush["accounting_account_id"] = $accounting_account_id;
            $setPush["type_ingreso"] = $type_ingreso;
            $setPush["data"] = $entityHas;
            array_push($dataLibroDiario1, $setPush);

            /*retencion LD*/
            $sumRetentionAll = 0;
            foreach ($detailsRetention as $key => $value) {


                $sub_tipo_retencion_impuesto_id = $value["sub_tipo_retencion_id"];
                $fecha_creacion = $fecha;
                $valor_retenido = $value["valor_retenido"];
                $establecimiento = $headerRetention["establecimiento"];
                $punto_emision = $headerRetention["punto_emision"];

                $num_autorizacion = $headerRetention["no_autorizacion"];

                $num_retencion = $headerRetention["numero_retencion"];
                $fecha_factura = $headerRetention["fecha_factura_save"];
                $accounting_account_id = $value["accounting_account_id"];

                $data = array();
                $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Impuesto_a_la_renta;

                $entityHas = array(
                    "isChildren" => 1,
                    "nivel_4" => $nivel_4,
                    "libro_diario_id" => null,
                    "asiento_libro_diario_id" => null,
                    "entidad_data_id" => $entidad_data_id,
                    "entidad" => $tablelHasFacturaRetenciones,
                    "entidad_id" => "-1",
                    "owner_id" => $owner_id,
                    "parent" => array(
                        "model" => $modelHasFacturaRetenciones,
                        "attributes" => array(
                            "sub_tipo_retencion_impuesto_id" => $sub_tipo_retencion_impuesto_id,
                            "fecha_creacion" => Util::FechaActual(),
                            "valor_retenido" => $valor_retenido,
                            "establecimiento" => $establecimiento,
                            "punto_emision" => $punto_emision,
                            "num_autorizacion" => $num_autorizacion,
                            "num_retencion" => $num_retencion,
                            "fecha_factura" => $fecha_factura,
                            $key_factura_deuda => $invoiceId,

                        )
                    )
                );

                $setPush = array();
                $type_ingreso = $DEBE;

                $valor = $valor_retenido;
                $setPush["valor"] = $valor;
                $setPush["accounting_account_id"] = $accounting_account_id;
                $setPush["type_ingreso"] = $type_ingreso;
                $setPush["data"] = $entityHas;
                array_push($dataLibroDiario1, $setPush);
                $sumRetentionAll += $valor;
            }


        } else {
            $libro_diario_id = null;
            $asiento_libro_diario_id = null;
            $entidad = "notHasRetention";
            $entidad_id = "-1";


            $valor = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');


            $accounting_account_id = $supplierCustomerAccountId;
            $type_ingreso = $DEBE;
            $entityHas = array();
            $entityHas["libro_diario_id"] = $libro_diario_id;
            $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
            $entityHas["entidad_data_id"] = $entidad_data_id;
            $entityHas["entidad"] = $entidad;
            $entityHas["entidad_id"] = $entidad_id;
            $entityHas["owner_id"] = $owner_id;
            $nivel_4 = $typeManager == "shopping" ? \App\Models\BusinessByDailyBookSeat::$lvl_4_Proveedores : \App\Models\BusinessByDailyBookSeat::$lvl_4_Clientes;
            $entityHas["nivel_4"] = $nivel_4;

            $setPush = array();
            $setPush["valor"] = $valor;
            $setPush["accounting_account_id"] = $accounting_account_id;
            $setPush["type_ingreso"] = $type_ingreso;
            $setPush["data"] = $entityHas;

            array_push($dataLibroDiario1, $setPush);

        }
        if ($configPayment["mixed"] == "false") {//pagos

            $dataLibroDiario3 = array();
            $value_gestion = "V/R " . $msjOkCustomerManager . " de la " . $codigo_documento;
            $dataSet = array("value" => $value_gestion, "descripcion" => "esto es la descripsion del asiento", "fecha_creacion" => $fecha, "fecha_factura" => $fecha_factura, "childrens" => array());
            $numberSeat = 2;
            $accountingSeatResult[$numberSeat] = $dataSet;


            $total_pagos_desglozado = 0;


            if ($configPayment["hasIndebtedness"] == "true") {//sin deuda


            } else if ($configPayment["hasIndebtedness"] == "false") {

            }

            /*LD N*/
            foreach ($detailsPaymentMethods as $key => $value) {
                $type_payment_id = $value["type_payment_id"];

                $valor = $value["Valor"];
                $total_pagos_desglozado += $valor;
                $accounting_account_id = $value["Cuenta_save"];
                $type_ingreso = $typeManager == "shopping" ? $HABER : $DEBE;
                $entityHas = array();
                $libro_diario_id = null;
                $asiento_libro_diario_id = null;
                $entidad = "variosPagos";
                $entidad_id = "-1";
                $entityHas["libro_diario_id"] = $libro_diario_id;
                $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
                $entityHas["entidad_data_id"] = $entidad_data_id;
                $entityHas["entidad"] = $entidad;
                $entityHas["entidad_id"] = $entidad_id;
                $entityHas["owner_id"] = $owner_id;
//                               INIT TRANSACCIONES
                $documento = \App\Models\InvoiceSaleByTransactions::anyOneDocumentConfig;
                $Tipo_pago_save = $value["Tipo_pago_save"]; //del tipo de pago
                if ($Tipo_pago_save == 4) {//TRANSFERENCIAS BANCARIAS
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Bancos;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_sudsf;
                } else if ($Tipo_pago_save == 2) {//TARJETA DE CREDITO
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Obligaciones_financieras;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_tdc;
                } else if ($Tipo_pago_save == 3) {//CHEQUE
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Bancos;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_et;
                } else if ($Tipo_pago_save == 1) {//EFECTIVO
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Caja;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_ocudsf;
                } else if ($Tipo_pago_save == 5) {//DINERO electronico
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Bancos;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_de;
                } else if ($Tipo_pago_save == 6) {//TARJETA DE DEBITO
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Bancos;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_tdd;
                } else if ($Tipo_pago_save == 7) {//TARJETA PREPAGO
                    $nivel_4 = $typeManager == "shopping" ? \App\Models\BusinessByDailyBookSeat::$lvl_4_Proveedores : \App\Models\BusinessByDailyBookSeat::$lvl_4_Clientes;
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_tp;
                }
                $entityHas["nivel_4"] = $nivel_4;
                $params_ft = array();
                $params_ft[$key_relacion_transaccion] = $invoiceId;
                $params_ft["subtotal"] = $value["Valor"];
                $params_ft["total"] = $value["Valor"];
                $forma_pago = $documento;
                $params_ft["accounting_account_id"] = $value["Cuenta_save"];
                $params_ft["forma_pago"] = $forma_pago;
                $params_ft["type_payment_id"] = $type_payment_id;
                $entityHas["save"] = array("model" => $modelHasFacturaTransacciones, "attributes" => $params_ft);
                $setPush = array();
                $setPush["valor"] = $valor;
                $setPush["accounting_account_id"] = $accounting_account_id;
                $setPush["type_ingreso"] = $type_ingreso;
                $setPush["data"] = $entityHas;
                array_push($dataLibroDiario3, $setPush);

            }


            $entidad = $tableFactura;
            $entidad_id = $invoiceId;
            $setPush = array();
            $entityHas = array();
            $accounting_account_id = $supplierCustomerAccountId;
            $entityHas["libro_diario_id"] = null;
            $entityHas["asiento_libro_diario_id"] = null;
            $entityHas["entidad_data_id"] = $entidad_data_id;
            $entityHas["entidad"] = $entidad;
            $entityHas["entidad_id"] = $invoiceId;
            $entityHas["owner_id"] = $owner_id;
            $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Clientes;
            $entityHas["nivel_4"] = $nivel_4;

            $type_ingreso = $HABER;
            $setPush["valor"] = $total_pagos_desglozado;
            $setPush["accounting_account_id"] = $accounting_account_id;
            $setPush["type_ingreso"] = $type_ingreso;
            $setPush["data"] = $entityHas;
            array_push($dataLibroDiario3, $setPush);
            $numberSeat = 2;
            $accountingSeatResult[$numberSeat]["childrens"] = $dataLibroDiario3;

        } else if ($configPayment["mixed"] == "true") {//DPN


            $deudaDiferencia = 0;
            if ($configPayment["hasIndebtedness"] == "true") {//deuda

            } else if ($configPayment["hasIndebtedness"] == "false") {//sin deuda

                $dataLibroDiario3 = array();
                $value_gestion = "V/R " . $msjOkCustomerManager . " de la " . $codigo_documento;
                $dataSet = array("value" => $value_gestion, "descripcion" => "esto es la descripsion del asiento", "fecha_creacion" => $fecha, "fecha_factura" => $fecha_factura, "childrens" => array());
                $numberSeat = 2;
                $accountingSeatResult[$numberSeat] = $dataSet;
                if ($configPayment["wayToPay"] == "cash") {//cash
                    /*LD 1*/
                    $accounting_account_id = $generalInboxAccountId;
                    $entityHas = array();
                    $libro_diario_id = null;
                    $asiento_libro_diario_id = null;
                    $entidad = "hasIndebtednessCash";
                    $entidad_id = "-1";
                    $entityHas["libro_diario_id"] = $libro_diario_id;
                    $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
                    $entityHas["entidad_data_id"] = $entidad_data_id;
                    $entityHas["entidad"] = $entidad;
                    $entityHas["entidad_id"] = $entidad_id;
                    $entityHas["owner_id"] = $owner_id;
                    $entityHas["nivel_4"] = $nivel_4;
                    $type_ingreso = $DEBE;
                    $setPush = array();

                    $resultSum = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');
                    $valor = number_format($resultSum - $sumRetentionAll, $roundManager, '.', '');

                    $setPush["valor"] = $valor;
                    $setPush["accounting_account_id"] = $accounting_account_id;
                    $setPush["type_ingreso"] = $type_ingreso;
                    //                               INIT TRANSACCIONES
                    $params_ft = array();
                    $subtotal = $headerInvoice['subtotal_encabezado'];
                    $total = $headerInvoice['valor_factura'] - $sumRetentionAll;
                    $forma_pago = "";
                    $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_ocudsf;
                    if (isset($headerInvoice["por_efectivo_id"])) {
                        $documento = $headerInvoice["por_tarjeta_id"];
                    }


                    $forma_pago = $documento;
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Caja;

                    $params_ft[$key_relacion_transaccion] = $invoiceId;
                    $params_ft["subtotal"] = $subtotal;
                    $params_ft["total"] = $total;
                    $params_ft["accounting_account_id"] = $accounting_account_id;
                    $params_ft["forma_pago"] = $forma_pago;
                    $needleCode = \App\Utils\Accounting\UtilAccounting::codePaymentCash;
                    $type_payment_id = $utilAccounting->getTypePaymentByParams(array("needle" => $needleCode));
                    $params_ft["type_payment_id"] = $type_payment_id;

                    $entityHas["save"] = array("model" => $modelHasFacturaTransacciones, "attributes" => $params_ft);
                    $setPush["data"] = $entityHas;
                    array_push($dataLibroDiario3, $setPush);


                    /*LD 2*/

                    $accounting_account_id = $supplierCustomerAccountId;
                    $nivel_4 = $typeManager == "shopping" ? \App\Models\BusinessByDailyBookSeat::$lvl_4_Proveedores : \App\Models\BusinessByDailyBookSeat::$lvl_4_Clientes;
                    $entityHas = array();
                    $libro_diario_id = null;
                    $asiento_libro_diario_id = null;
                    $entidad = "hasIndebtednessCash";
                    $entidad_id = "-1";
                    $entityHas["libro_diario_id"] = $libro_diario_id;
                    $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
                    $entityHas["entidad_data_id"] = $entidad_data_id;
                    $entityHas["entidad"] = $entidad;
                    $entityHas["entidad_id"] = $entidad_id;
                    $entityHas["owner_id"] = $owner_id;
                    $entityHas["nivel_4"] = $nivel_4;
                    $type_ingreso = $HABER;
                    $setPush = array();
                    $resultSum = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');
                    $valor = number_format($resultSum - $sumRetentionAll, $roundManager, '.', '');

                    $setPush["valor"] = $valor;
                    $setPush["accounting_account_id"] = $accounting_account_id;
                    $setPush["type_ingreso"] = $type_ingreso;
                    $setPush["data"] = $entityHas;
                    array_push($dataLibroDiario3, $setPush);
                    $accounting_account_id = $generalInboxAccountId;
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Caja;
                } else if ($configPayment["wayToPay"] == "card") {//card
                    /*LD1*/


                    $accounting_account_id = $creditCardAccountId;
                    if (isset($headerInvoice["por_tarjeta_id"])) {
                        $accounting_account_id = $headerInvoice["por_tarjeta_id"];
                    }
                    $accounting_account_id = $accounting_account_id;
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Obligaciones_financieras;
                    $entityHas = array();
                    $libro_diario_id = null;
                    $asiento_libro_diario_id = null;
                    $entidad = "hasIndebtedness" . $configPayment["wayToPay"];
                    $entidad_id = "-1";
                    $entityHas["libro_diario_id"] = $libro_diario_id;
                    $entityHas["asiento_libro_diario_id"] = $asiento_libro_diario_id;
                    $entityHas["entidad_data_id"] = $entidad_data_id;
                    $entityHas["entidad"] = $entidad;
                    $entityHas["entidad_id"] = $entidad_id;
                    $entityHas["owner_id"] = $owner_id;
                    $entityHas["nivel_4"] = $nivel_4;
                    $type_ingreso = $DEBE;

                    $setPush = array();
                    $resultSum = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');
                    $valor = number_format($resultSum - $sumRetentionAll, $roundManager, '.', '');

                    $setPush["valor"] = $valor;
                    $setPush["accounting_account_id"] = $accounting_account_id;
                    $setPush["type_ingreso"] = $type_ingreso;


                    //                               INIT TRANSACCIONES
                    $params_ft = array();
                    $subtotal = $headerInvoice['subtotal_encabezado'];
                    $total = $headerInvoice['valor_factura'] - $sumRetentionAll;
                    $forma_pago = "";
                    if ($headerInvoice["por_tarjeta"] == "si") {

                        $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_tdc;
                        if (isset($headerInvoice["por_tarjeta_id"])) {
                            $documento = $headerInvoice["por_tarjeta_id"];
                        }
                        $accounting_account_id = $creditCardAccountId;
                        $forma_pago = $documento;
                        $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Obligaciones_financieras;
                    } else {

                        $documento = \App\Models\InvoiceSaleByTransactions::documento_gestion_ocudsf;
                        if (isset($headerInvoice["por_efectivo_id"])) {
                            $documento = $headerInvoice["por_tarjeta_id"];
                        }
                        $accounting_account_id = $generalInboxAccountId;
                        $forma_pago = $documento;
                        $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Caja;
                    }
                    $params_ft[$key_relacion_transaccion] = $invoiceId;
                    $params_ft["subtotal"] = $subtotal;
                    $params_ft["total"] = $total;
                    $params_ft["accounting_account_id"] = $accounting_account_id;
                    $params_ft["forma_pago"] = $forma_pago;
                    $needleCode = UtilAccounting::codePaymentCreditCard;
                    $type_payment_id = $utilAccounting->getTypePaymentByParams(array("needle" => $needleCode));
                    $params_ft["type_payment_id"] = $type_payment_id;
                    $entityHas["save"] = array("model" => $modelHasFacturaTransacciones, "attributes" => $params_ft);
                    $setPush["data"] = $entityHas;
                    array_push($dataLibroDiario3, $setPush);

                    /*LD 2*/
                    $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Caja;
                    $libro_diario_id = null;
                    $asiento_libro_diario_id = null;
                    $entidad = "hasIndebtedness" . $configPayment["wayToPay"];
                    $entidad_id = "-1";
                    $entityHas = array(
                        "nivel_4" => $nivel_4,
                        "libro_diario_id" => $libro_diario_id,
                        "asiento_libro_diario_id" => $asiento_libro_diario_id,
                        "entidad_data_id" => $entidad_data_id,
                        "entidad" => $entidad,
                        "entidad_id" => $entidad_id,
                        "owner_id" => $owner_id
                    );
                    $setPush = array();
                    $type_ingreso = $HABER;


                    $resultSum = number_format($sumExpendAll + $sumInventoryAll, $roundManager, '.', '');
                    $valor = number_format($resultSum - $sumRetentionAll, $roundManager, '.', '');

                    $accounting_account_id = $supplierCustomerAccountId;
                    $setPush = array(
                        "valor" => $valor,
                        "accounting_account_id" => $accounting_account_id,
                        "type_ingreso" => $type_ingreso,
                        "data" => $entityHas
                    );
                    array_push($dataLibroDiario3, $setPush);


                }
                $numberSeat = 2;
                $accountingSeatResult[$numberSeat]["childrens"] = $dataLibroDiario3;
            }


        }
        if ($allowThirdSeat) {


            $value_gestion = "V/R DISMINUCIÓN POR VENTA DESDE EL INVENTARIO";
            $dataSet = array("value" => $value_gestion, "descripcion" => "esto es la descripsion del asiento", "fecha_creacion" => $fecha, "fecha_factura" => $fecha_factura, "data" => array());
            $numberSeat = 1;
            $accountingSeatResult[$numberSeat] = $dataSet;


//Costos LD
            $setPush = array();
            $entityHas = array();
            $accounting_account_id = $costsId;
            $entityHas["libro_diario_id"] = null;
            $entityHas["asiento_libro_diario_id"] = null;
            $entityHas["entidad_data_id"] = $entidad_data_id;
            $entityHas["entidad"] = $key_factura_deuda;
            $entityHas["entidad_id"] = $invoiceId;
            $entityHas["owner_id"] = $owner_id;
            $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Costos_de_venta;
            $entityHas["nivel_4"] = $nivel_4;

            $type_ingreso = $DEBE;
            $setPush["valor"] = $costsValue;
            $setPush["accounting_account_id"] = $accounting_account_id;
            $setPush["type_ingreso"] = $type_ingreso;
            $setPush["data"] = $entityHas;
            array_push($dataLibroDiario2, $setPush);

//Inventory LD
            $setPush = array();
            $entityHas = array();
            $accounting_account_id = $inventoryAccountId;
            $entityHas["libro_diario_id"] = null;
            $entityHas["asiento_libro_diario_id"] = null;
            $entityHas["entidad_data_id"] = $entidad_data_id;
            $entityHas["entidad"] = $key_factura_deuda;
            $entityHas["entidad_id"] = $invoiceId;
            $entityHas["owner_id"] = $owner_id;
            $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Inventario_de_productos_terminados;
            $entityHas["nivel_4"] = $nivel_4;

            $type_ingreso = $HABER;
            $setPush["valor"] = $costsValue;
            $setPush["accounting_account_id"] = $accounting_account_id;
            $setPush["type_ingreso"] = $type_ingreso;
            $setPush["data"] = $entityHas;
            array_push($dataLibroDiario2, $setPush);
            $accountingSeatResult[$numberSeat]["childrens"] = $dataLibroDiario2;
        }


        /*TAX LD*/
        $entityHas = array();
        $nivel_4 = \App\Models\BusinessByDailyBookSeat::$lvl_4_Impuestos;
        $entityHas = array("nivel_4" => $nivel_4, "libro_diario_id" => null, "asiento_libro_diario_id" => null, "entidad_data_id" => $entidad_data_id, "entidad" => "compras_iva", "entidad_id" => "-1", "owner_id" => $owner_id);
        $setPush = array("valor" => $taxesValue, "accounting_account_id" => $taxAccountId, "type_ingreso" => $HABER, "data" => $entityHas);
        array_push($dataLibroDiario1, $setPush);

        if ($allowValuesGastos) {
            foreach ($gastosDataAux as $key => $value) {
                array_push($dataLibroDiario1, $value);
            }
        }

        if (count($inventoryData) > 0) {
            array_push($dataLibroDiario1, $inventoryDataAux[0]);
        }

        $numberSeat = 0;
        $accountingSeatResult[$numberSeat]["childrens"] = $dataLibroDiario1;

        $utilAccounting = new \App\Utils\Accounting\UtilAccounting;
        $accountingSeatResult = $utilAccounting->getAdjustAccountingEntries(array("haystack" => $accountingSeatResult));

        return $accountingSeatResult;
    }

    public function saveAnnulmentBilling($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();

        $result = array();
        $utilManager = new \App\Utils\Util();
        $fecha = $utilManager::DateCurrent();
        $entidad_data_id = 0; //para guardar d q empresa pertenece
        $asiento_id = 0;
        $invoiceId = 0;
        $success = false;

        $result = array();
        $msjError = "";
        $resultSaveAll = false;
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        $user = $dataUserManager['user'];
        $user_id = $user->id;
        DB::beginTransaction();
        try {
            $id = $attributesPost["rowInvoice"]["id"];
            $type = "sale";
            $modelName = new \App\Models\InvoiceSale();
            $entidad_data_id = $attributesPost["entidad_id"];
            $codeInvoice = $attributesPost["rowInvoice"]["codigo_factura_info"];
            $typeInvoiceDocument = $attributesPost["rowInvoice"]["tipo"];
            $fecha_factura = $attributesPost["rowInvoice"]["fecha_factura"];
            $dateAnnulment = $fecha_factura;
            $dateAnnulment = $utilManager::FormatDate($dateAnnulment, 'Y-m-d');
            $typeManager = 0;//registro de factura
            $params = array(
                "invoiceId" => $id,
                "type" => $type,
                "entidad_data_id" => $entidad_data_id,
                "typeManager" => $typeManager,
                "codeInvoice" => $codeInvoice,
                "type" => $type,
                "typeInvoiceDocument" => $typeInvoiceDocument,
                "dateAnnulment" => $dateAnnulment
            );
            $result = array();
            $msj = "";
            $success = true;
            $utilBilling = new \App\Utils\Accounting\BillingUtil;


            $dataSeatBookManager = $utilBilling->getSeatBookManager($params);
            $seatsDataInvoiceSave = $dataSeatBookManager["seatsDataInvoiceSave"];
            $detailsInvoice = $dataSeatBookManager["detailsInvoice"];
            $modelPI = new \App\Models\ProductInventory();

            $successProductsManager = $modelPI->saveManagerAnnulment(
                array(
                    "invoiceId" => $id,
                    "type" => $type,
                    "entidad_data_id" => $entidad_data_id,
                    "typeManager" => $typeManager,
                    "haystack" => $detailsInvoice,
                    "codeInvoice" => $codeInvoice,
                    "type" => $type,
                    "typeInvoiceDocument" => $typeInvoiceDocument,
                    "dateAnnulment" => $dateAnnulment

                )
            );

            $modelALD = new \App\Models\DailyBookSeat();
            $successSeatsManager = $modelALD->saveMultipleData(array("haystack" => $seatsDataInvoiceSave));

            if (!$successProductsManager["success"] || !$successSeatsManager["success"]) {
                $success = false;
                if (!$successProductsManager["success"] && !$successSeatsManager["success"]) {
                    $msj = "Error en los datos de gestion " . $successSeatsManager["msj"] . " & " . $successProductsManager["msj"];
                } else if (!$successSeatsManager["success"]) {
                    $msj = $successSeatsManager["msj"];

                } else if (!$successProductsManager["success"]) {
                    $msj = $successProductsManager["msj"];
                }
            }

            $model = $modelName->find($id);
            $model->status = "CANCELED";
            if ($model->save()) {
                $success = true;
                $resultSaveAll = $success;
            } else {
                $success = false;
                $resultSaveAll = $success;

            }
            if ($resultSaveAll) {
                $resultSaveAll = true;
                $success = $resultSaveAll;

                DB::commit();

            } else {
                $success = false;
                $success = $resultSaveAll;
                DB::rollBack();

            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success


            ];

            return ($result);
        } catch (\Exception $e) {
            $success = false;
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => 'Error interno Comuniquese con Soporte Tecnico.',
                "errors" => $errors,
                'msjServer' => $msj

            );
            DB::rollBack();
            return ($result);
        }

    }

    public function getInvoiceList($params)
    {
        $utilCurrent = new UtilAccounting;
        $modelUtil = new  BillingUtil;

        $result = $this->getInvoiceListManager($params);

        $type = "sale";
        $rowsResult = [];
        foreach ($result as $key => $rowManager) {
            $row = (array)$rowManager;
            $deuda = $row["deuda"];

            $invoice_id = $row["id"];
            $has_retencion = $row["has_retencion"];
            $customer_id = $row["customer_id"];

            if ($deuda == "1") {
                $dataInvoiceManager = $utilCurrent->getDataInvoiceManagerIndebtedness(
                    array("invoice_id" => $invoice_id, "type" => "sales")
                );
                $row["managerIndebtedness"] = $dataInvoiceManager;
            }
            $viewBillingData = $modelUtil->getViewBillingCurrent(array("invoiceId" => $invoice_id, "hasRetention" => $has_retencion, "type" => $type, "customer_id" => $customer_id));

            $result[$key] = array_merge($row, $viewBillingData);
        }

        return $result;
    }

    public function getInvoiceListManager($params)
    {
        $entidad_data_id = $params["filters"]["entidad_data_id"] == "" ? null : $params["filters"]["entidad_data_id"];
        $estado = !isset($params["filters"]["estado"]) || $params["filters"]["estado"] == "" ? null : $params["filters"]["estado"];
        $tipo_comprobante_id = !isset($params["filters"]["tipo_comprobante_id"]) || $params["filters"]["tipo_comprobante_id"] == "" ? null : $params["filters"]["tipo_comprobante_id"];
        $fecha_inicio = !isset($params["filters"]["fecha_inicio"]) || $params["filters"]["fecha_inicio"] == "" ? null : $params["filters"]["fecha_inicio"];
        $fecha_fin = !isset($params["filters"]["fecha_fin"]) || $params["filters"]["fecha_fin"] == "" ? null : $params["filters"]["fecha_fin"];
        $supplyCustomerId = !isset($params["filters"]["supplyCustomerId"]) || $params["filters"]["supplyCustomerId"] == "" ? null : $params["filters"]["supplyCustomerId"];

        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.customer_id,$this->table.invoice_code,$this->table.invoice_value,$this->table.discount_value,$this->table.status,$this->table.created_at,$this->table.user_id,$this->table.observations,$this->table.value_taxes,$this->table.subtotal,$this->table.authorization_number,$this->table.invoice_date,$this->table.establishment,$this->table.emission_point,$this->table.mixed_payment,$this->table.has_retention,$this->table.debt,$this->table.type_of_discount,$this->table.discount_type_invoice
        ,voucher_type.value as voucher_type,voucher_type.id as voucher_type_id
        ,customer.id customer_id,customer.business_reason razon_social,customer.identification_document identificacion
        ,people.name nombres,people.last_name apellidos
        ,$this->table.customer_id cliente_id,$this->table.mixed_payment pago_mixto, $this->table.has_retention has_retencion, $this->table.now_after_retention now_after_retencion, $this->table.debt deuda,$this->table.establishment establecimiento, $this->table.emission_point punto_emision, $this->table.invoice_code codigo_factura, CONCAT($this->table.establishment ,'-',$this->table.emission_point,'-',$this->table.invoice_code) codigo_factura_info, $this->table.authorization_number no_autorizacion, $this->table.invoice_value valor_factura, $this->table.discount_value valor_descuento, $this->table.status estado,DATE_FORMAT($this->table.created_at,'%d/%m/%Y')  fecha_creacion ,DATE_FORMAT($this->table.invoice_date,'%d/%m/%Y') fecha_factura, $this->table.user_id usuario_creacion_id, $this->table.observations observaciones, $this->table.value_taxes valor_impuestos, $this->table.subtotal
       ,voucher_type.value tipo
       , CONCAT('Factura Codigo Registro : ',$this->table.id,'# Documento:',$this->table.establishment,'-', $this->table.emission_point,'-',$this->table.invoice_code) text
        ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('voucher_type', 'voucher_type.id', '=', $this->table . '.voucher_type_id');
        $query->join('entity_has_invoice_sale', $this->table . '.id', '=', 'entity_has_invoice_sale.factura_venta_id');
        $query->join('customer', $this->table . '.customer_id', '=', 'customer.id');
        $query->join('people', 'customer.people_id', '=', 'people.id');
        $query->where('entity_has_invoice_sale.entidad_data_id', '=', $entidad_data_id);

        if (isset($params['search_value']["term"]) && $params['search_value']["term"] != null) {
            $searchValue = $params["filters"]['search_value']["term"];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.invoice_code', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.name', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.last_name', 'like', '%' . $likeSet . '%');
                $query->orWhere('customer.identification_document', 'like', '%' . $likeSet . '%');
                $query->orWhere('customer.business_reason', 'like', '%' . $likeSet . '%');
            });

        }
        if ($estado) {
            $statusCurrentManager = [
                'EMITIDO' => 'ISSUED',
                'PENDIENTE' => 'PENDING',
                'ANULADO' => 'CANCELLED',
            ];
            $statusCurrent = $statusCurrentManager[$estado];
            $query->where($this->table . '.status', '=', $statusCurrent);
        }
        if ($tipo_comprobante_id) {
            $query->where($this->table . '.voucher_type_id', '=', $tipo_comprobante_id);
        }
        if ($fecha_fin && $fecha_inicio) {
            $query->where($this->table . '.invoice_date', '>=', $fecha_inicio);
            $query->where($this->table . '.invoice_date', '<=', $fecha_fin);

        }
        if ($supplyCustomerId) {
            $query->where('customer.id', '=', $supplyCustomerId);
        }
        $query->limit(10)->orderBy($field, $sort);
        $result = $query->get()->toArray();
        return $result;
    }

}
