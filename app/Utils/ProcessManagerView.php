<?php

namespace App\Utils;

use App\Models\InformationAddressType;
use App\Models\VoucherType;
use App\Utils\Util;
use Auth;

class ProcessManagerView
{
    const PROCESS_SALES = 'SALES INVENTORY-SERVICES';
    const PROCESS_SALES_RENTAL = 'SALES INVENTORY-SERVICES-RENTAL';
    const PROCESS_CRM_MANAGER = 'CRM-MANAGER';

    const PROCESS_INVOICE_SALES = 'INVOICE SALES INVENTORY-SERVICES';
    public $pathsManagementProject = [];

    public function __construct(array $attributes = [])
    {
        $util = new \App\Utils\Util();
        $this->pathsManagementProject = $util->getPathsManagementProject();

    }
    public function processInvoiceSale($params)
    {
        $business_id = $params['filters']['business_id'];
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        $user = $dataUserManager['user'];
        $user_id = $user->id;
        $modelBusiness = new \App\Models\Business();
        $business = $modelBusiness->findByAttributes([
            'id' => $business_id
        ]);

        $success = false;
        //---DATA EntityAuthorizationConfiguration --
        $modelEAC = new \App\Models\EntityAuthorizationConfiguration();
        $type = $modelEAC::RETENTION_RECEIPT_TYPE;
        $state = $modelEAC::STATE_ACTIVE;
        $managerCurrentParams = [
            'entity_data_id' => $business_id
            , 'type' => $type
            , 'state' => $state
        ];


        $no_autorizacion_data = $modelEAC->findByAttributes($managerCurrentParams);
        $no_autorizacion = array();
//RETENTION_RECEIPT_TYPE
        if ($no_autorizacion_data) {
            $no_autorizacion = $no_autorizacion_data->attributes;
        }
//----BUSINESS INFORMATION--
        $util = new \App\Utils\Util();
        $managerUserInformation = $util->getDataManagerCurrentUser();
        $owner_id = $managerUserInformation['user']->id; //USER MANAGER CURRENT
        $params_data_search = array("user_id" => $owner_id);
        $modelBBE = new \App\Models\BusinessByEmployeeProfile();
        $model_epgu = $modelBBE->getUserEmployerInformation($params_data_search);

        $data_empresa = array();
        $data_empresa["user"]["nombres"] = "Administrador Total";
        $data_empresa["user"]["identificacion"] = "123456789";
        if ($model_epgu) {
            $data_empresa["user"]["nombres"] = $model_epgu->people_name . " " . $model_epgu->people_last_name;
            $data_empresa["user"]["identificacion"] = $model_epgu->identification_document;
        }

        $data_empresa["empresa"] = (array)$business;
        //InformationAddress
        $direccion_tipo_id = \App\Models\InformationAddressType::TYPE_BUSINESS;
        $modelIA = new \App\Models\InformationAddress();
        $params_data_search = array("main" => 1, "entity_type" => $modelIA::ENTITY_TYPE_BUSINESS, "entity_id" => $business_id, "information_address_type_id" => $direccion_tipo_id);
        $model_d = $modelIA->findByAttributes($params_data_search);

        $data_empresa["empresa"]["direccion"]["referencia"] = "Referencia no Asignada a la Empresa";
        $data_empresa["empresa"]["direccion"]["calles"] = "Calles no Asignada a la Empresa";
        $data_empresa["empresa"]["saludo"]["1"] = "LA BENDICIÓN DE JEHOVÁ ES LA QUE ENRIQUECE, Y NO AÑADE";
        $data_empresa["empresa"]["saludo"]["2"] = "TRISTEZA CON ELLA. PROVERBIOS 10:22";
        $data_empresa["empresa"]["gracias"] = "¡¡ GRACIAS POR SU COMPRA !!";
        $data_empresa["empresa"]["logo"] = URL($this->pathsManagementProject['baseUrlPublic'] . '/images/business/logos/logo_white_lyric.jpg');
        if ($model_d) {
            $direccion = $model_d->street_one;
            $referencia = $model_d->reference;
            if ($model_d->street_one != "") {
                $direccion = $model_d->street_one . " " . $model_d->street_two;
            }
            $data_empresa["empresa"]["direccion"]["referencia"] = $referencia;
            $data_empresa["empresa"]["direccion"]["calles"] = $direccion;
        }
        $dateCurrent = \App\Utils\Util::DateCurrent();
        $firstMonthDay = \App\Utils\Util::firstMonthDay();
        $dateInit = \App\Utils\Util::FormatDate($firstMonthDay, 'Y-m-d 00:00:00');
        $dateEnd = \App\Utils\Util::FormatDate($dateCurrent, 'Y-m-d H:i:s');
        $fecha_emision = \App\Utils\Util::FormatDate(\App\Utils\Util::DateCurrent(), "d-m-Y");
        $cssPrintInvoice = URL($this->pathsManagementProject['baseUrlPublic'] . '/print-manager/assets/invoice-sales.css');
        $managerRound = 4;
        $modelVT = new VoucherType();
        $typeOfProofData = $modelVT->getListTypeBouncher();
        $utilUUTA = new \App\Utils\Accounting\UtilUnifiedTransactionalAnnex;
        $processNameIdentificationData = $utilUUTA->getCodeDataAnnex();


        $dataDateCurrent = array("format" => $dateCurrent, "notFormat" => $util::FormatDate($dateCurrent, "H:i:s d/m/Y"));

        $data = [
            'managerRound' => $managerRound,
            'dataBusiness' => ($data_empresa),
            'processNameIdentificationData' => $processNameIdentificationData,
            'typeOfProofData' => $typeOfProofData,
            'dataDateCurrent' => $dataDateCurrent,
            'filters' => [
                'date' =>
                    [
                        'init' => $dateInit,
                        'end' => $dateEnd,
                        'emission' => $fecha_emision
                    ]
            ]
        ];
        $typeError = null;
        $typeCode = '';
        $typeCodeDescription = '';
        $msg = '';
        $paramsError = [];
        $isPartialError = false;

        $success = true;
        $managerError = [
            'typeError' => $typeError,
            'typeCode' => $typeCode,
            'typeCodeDescription' => $typeCodeDescription,
            'params' => $paramsError,
            'isPartialError' => $isPartialError

        ];

        $result = [
            'managerError' => $managerError,
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
        return $result;

    }
    public function processCRMManager($params)
    {
        $cssPrintDelivery = URL($this->pathsManagementProject['baseUrlPublic'] . '/print-manager/assets/crm-delivery.css');
        $logoBusiness = URL($this->pathsManagementProject['baseUrlPublic'] . '/images/business/logos/inka.png');

        $data = [

            'design' => [
                'resources' =>[
                    'logoBusiness'=>$logoBusiness
                ],
                'css' => [
                    'delivery' => $cssPrintDelivery
                ]
            ],


        ];
        $result = [

            'success' => true,
            'data' => $data,
            'msg' => ""
        ];
        return $result;

    }
    public function getManagerByProcess($params)
    {
        $processName = $params['processName'];
        $result = [];

        if ($processName == self::PROCESS_SALES) {

            $result = self::processSales($params);

        }else if ($processName == self::PROCESS_INVOICE_SALES) {
            $result = self::processInvoiceSale($params);

        } else if ($processName == self::PROCESS_SALES_RENTAL) {
            $result = self::processSalesRentalProduct($params);

        }
        else if ($processName == self::PROCESS_CRM_MANAGER) {
            $result = self::processCRMManager($params);

        }
        return $result;
    }
    public function processSalesRentalProduct($params)
    {
        $business_id = $params['filters']['business_id'];
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        $user = $dataUserManager['user'];
        $user_id = $user->id;
        $modelBusiness = new \App\Models\Business();
        $business = $modelBusiness->findByAttributes([
            'id' => $business_id
        ]);

        $success = false;
        //---DATA EntityAuthorizationConfiguration --
        $modelEAC = new \App\Models\EntityAuthorizationConfiguration();
        $type = $modelEAC::RETENTION_RECEIPT_TYPE;
        $state = $modelEAC::STATE_ACTIVE;
        $managerCurrentParams = [
            'entity_data_id' => $business_id
            , 'type' => $type
            , 'state' => $state
        ];


        $no_autorizacion_data = $modelEAC->findByAttributes($managerCurrentParams);
        $no_autorizacion = array();
//RETENTION_RECEIPT_TYPE
        if ($no_autorizacion_data) {
            $no_autorizacion = $no_autorizacion_data->attributes;
        }
//----BUSINESS INFORMATION--
        $util = new \App\Utils\Util();
        $managerUserInformation = $util->getDataManagerCurrentUser();
        $owner_id = $managerUserInformation['user']->id; //USER MANAGER CURRENT
        $params_data_search = array("user_id" => $owner_id);
        $modelBBE = new \App\Models\BusinessByEmployeeProfile();
        $model_epgu = $modelBBE->getUserEmployerInformation($params_data_search);

        $data_empresa = array();
        $data_empresa["user"]["nombres"] = "Administrador Total";
        $data_empresa["user"]["identificacion"] = "123456789";
        if ($model_epgu) {
            $data_empresa["user"]["nombres"] = $model_epgu->people_name . " " . $model_epgu->people_last_name;
            $data_empresa["user"]["identificacion"] = $model_epgu->identification_document;
        }

        $data_empresa["empresa"] = (array)$business;
        //InformationAddress
        $direccion_tipo_id = \App\Models\InformationAddressType::TYPE_BUSINESS;
        $modelIA = new \App\Models\InformationAddress();
        $params_data_search = array("main" => 1, "entity_type" => $modelIA::ENTITY_TYPE_BUSINESS, "entity_id" => $business_id, "information_address_type_id" => $direccion_tipo_id);
        $model_d = $modelIA->findByAttributes($params_data_search);

        $data_empresa["empresa"]["direccion"]["referencia"] = "Referencia no Asignada a la Empresa";
        $data_empresa["empresa"]["direccion"]["calles"] = "Calles no Asignada a la Empresa";
        $data_empresa["empresa"]["saludo"]["1"] = "LA BENDICIÓN DE JEHOVÁ ES LA QUE ENRIQUECE, Y NO AÑADE";
        $data_empresa["empresa"]["saludo"]["2"] = "TRISTEZA CON ELLA. PROVERBIOS 10:22";
        $data_empresa["empresa"]["gracias"] = "¡¡ GRACIAS POR SU COMPRA !!";
        $data_empresa["empresa"]["logo"] = URL($this->pathsManagementProject['baseUrlPublic'] . '/images/business/logos/logo_white_lyric.jpg');
        if ($model_d) {
            $direccion = $model_d->street_one;
            $referencia = $model_d->reference;
            if ($model_d->street_one != "") {
                $direccion = $model_d->street_one . " " . $model_d->street_two;
            }
            $data_empresa["empresa"]["direccion"]["referencia"] = $referencia;
            $data_empresa["empresa"]["direccion"]["calles"] = $direccion;
        }

        //TaxByBusiness
        $modelBBT = new \App\Models\TaxByBusiness();
        $ivaconfiguration = $modelBBT->getEntidadIvaConfiguracion([
            'filters' => [
                'business_id' => $business_id
            ]
        ]);

//TYPE PAYMENTS
        $modelTP = new \App\Models\TypesPayments();
        $getDataPagos = $modelTP->getDataPagos([]);
//-------------ALLOWS
//---INIT VIEW SUBPROCESOS DE LOS PROCESOS
//INIT RETENCIONES

        $allowViewRetentions = false;
        $modelAPT = new \App\Models\AllowProcessesThreads();
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_RETENCIONES;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewRetentions = true;
        }
//ESTABLECIMIENTO

        $allowViewEstablishment = $modelAPT::ventas_establecimiento;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_ESTABLECIMIENTO_CODIGO;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );
        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewEstablishment = true;
        }
//DESCUENTOS
        $allowViewDiscount = $modelAPT::ventas_descuento;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_DESCUENTOS;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewDiscount = true;
        }
//FECHA
        $allowViewDateForm = $modelAPT::ventas_fecha;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_FECHA;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);

        if ($modelSubProcess) {
            $allowViewDateForm = true;
        }
//FORMAS DE PAGO
        $allowViewWayPayments = false;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_FORMAS_PAGO;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewWayPayments = true;
        }

        //SUBPROCESS MANAGER
        $subprocessManager = array(
            "retenciones" => $allowViewRetentions,
            "retentions" => $allowViewRetentions,

            "establecimiento" => $allowViewEstablishment,
            "establishment" => $allowViewEstablishment,

            "descuento" => $allowViewDiscount,
            "discount" => $allowViewDiscount,

            "fecha" => $allowViewDateForm,
            "dateForm" => $allowViewDateForm,

            "formas_pago" => $allowViewWayPayments,
            "wayPayments" => $allowViewDateForm,

        );
        $procesos_all = array(
            "VENTAS_INVENTARIO" => $subprocessManager,
            "salesInventory" => $subprocessManager,

        );

        //----CUSTOMER DEFAULT---
        $dataFinalCustomer = array();
        $params_data_search = array();
        $modelBFC = new \App\Models\BusinessByFinalCustomer();
        $modelBBFC = $modelBFC->findByAttributes(array('business_id' => $business_id));

        $allowFinalCustomer = false;
        if ($modelBBFC) {
            $modelCustomer = new \App\Models\Customer();
            $modelC = $modelCustomer->findByAttributes(array('id' => $modelBBFC->customer_id));
            $allowFinalCustomer = true;
            $dataFinalCustomer = (array)$modelC;
            $params_data_search = array(
                "id" => $modelC->people_id
            );
            $modelP = new \App\Models\People();
            $model_persona = $modelP->findByAttributes($params_data_search);
            $text = "SN";
            $nombres_cliente = "SN";
            if ($model_persona) {
                $text = $modelC->identification_document . " " . $model_persona->name . " " . $model_persona->last_name;
                $nombres_cliente = $model_persona->name . " " . $model_persona->last_name;
            }
            if ($modelC->people_type_identification_id == 2) { // RUC
                $leftText = $modelC->business_reason == '' && $modelC->business_reason == '' ? $model_persona->name . " " . $model_persona->last_name : $modelC->business_reason;

                $text = $modelC->identification_document . " " . $leftText;
                $nombres_cliente = $leftText;
            }
            $dataFinalCustomer["direccion"] = "SN Y SN";
            $dataFinalCustomer["email"] = "SN Y SN";
            $dataFinalCustomer["telefono"] = "SN Y SN";
            $dataFinalCustomer["nombres_cliente"] = $nombres_cliente;
            $dataFinalCustomer["text"] = $text;
        }
//CASH
        $allowProcessBuySales = true;
        $modelCBU = new \App\Models\CashByUser;
        $resultSearch = null;
        $paymentTypeMix = true;
        $paymentType = false;

        if ($business->allow_cash_and_banks) {
            $resultSearch = $modelCBU->getAllowProcessByRole(array("processName" => "typeOfPaymentsMixed"));
            $paymentTypeMix = $resultSearch["success"];
        } else {
            $paymentTypeMix = true;
        }
        $viewProcessAllow = array(
            "paymentTypeMix" => $paymentTypeMix,
            "paymentType" => $paymentType,

        );

        $modelIS = new \App\Models\InvoiceSale();
        $managerResultsProcess = $modelIS->initAllowManagerProcess(array(
            'businessId' => $business_id
        ));

        $resultCUBC = $modelCBU->getCashUserByCurrent(array("entidad_data_id" => $business_id, 'user_id' => $user_id));
        $managementCash = [
            'cashCurrentUser' => $resultCUBC
        ];

        $modelC = new \App\Models\Caja();
        $dateCurrent = \App\Utils\Util::DateCurrent();
        $firstMonthDay = \App\Utils\Util::firstMonthDay();
        $dateInit = \App\Utils\Util::FormatDate($firstMonthDay, 'Y-m-d 00:00:00');
        $dateEnd = \App\Utils\Util::FormatDate($dateCurrent, 'Y-m-d H:i:s');
        $CashManagementCurrent = $modelC->getAllowManagement([
            'filters' => [
                'dateInit' => $dateInit,
                'dateEnd' => $dateEnd,
                'entidad_data_id' => $business_id,
                'user_id' => $user_id
            ]
        ]);

        if (!$business->allow_cash_and_banks) {

            $allowProcessBuySales = true;
        } else {

            if (!$resultSearch["success"]) {//not is ROLE MANAGER
                $allowProcessBuySales = true;
            } else {
                if ($resultCUBC == null) {
                    $allowProcessBuySales = false;
                }
            }
        }
        $fecha_emision = \App\Utils\Util::FormatDate(\App\Utils\Util::DateCurrent(), "d-m-Y");

        $business_id = $business->id;
        $type_gestion = "ventas_factura";
        $entidad_name_empresa = "autosur"; //change print type
        $type_disenio = $entidad_name_empresa;

        $entidad_name_modulo = "appEntidadData";
        $entidad_ctrl = "institucionHasAskwer";
        $entidad_name = "cliente";
        $cssPrintInvoice = URL($this->pathsManagementProject['baseUrlPublic'] . '/print-manager/assets/invoice-sales.css');
        $managerRound = 4;
        $data = [
            'managerRound' => $managerRound,
            'entidadid' => $business_id,
            'no_autorizacion' => ($no_autorizacion),
            'fecha_emision' => $fecha_emision,
            'ivaconfiguration' => $ivaconfiguration,
            'entidad_tipo' => 'entidadData',
            // Creacion del modulo
            'entidad_name_modulo' => $entidad_name_modulo,
            'entidad_name_ctrl' => $entidad_ctrl,
            //    ---GESTION DE BOTONES ADD--
            'gestion_data_view' => false,
            'data_empresa' => ($data_empresa),
            'type_disenio' => ($type_disenio),
            'getDataPagos' => ($getDataPagos),
            //    ----SUBPROCESOS ALLOW---
            'procesos_all' => ($procesos_all),
            'allProcess' => ($procesos_all),

            'dataFinalCustomer' => ($dataFinalCustomer),
            'allowFinalCustomer' => ($allowFinalCustomer),
            'viewProcessAllow' => ($viewProcessAllow),
            'managerResultsProcess' => ($managerResultsProcess),
            'managementCash' => ($managementCash),
            'CashManagementCurrent' => ($CashManagementCurrent),
            'design' => [
                'css' => [
                    'invoice' => $cssPrintInvoice
                ]
            ],


        ];
        $typeError = null;
        $typeCode = '';
        $typeCodeDescription = '';
        $msg = '';
        $paramsError = [];
        $isPartialError = false;

        if ($managerResultsProcess['success']) {

            if ($allowProcessBuySales) {

                if (!empty($ivaconfiguration)) { //ASIGNACION DE IVA CONFIGURADO VERIFICACION
                    /*-----GESTION DE FACTURA DETALLE----*/
                    $allowPrettyCash = $business->allow_cash_and_banks?$CashManagementCurrent['allow']:true;


                    if ($allowPrettyCash) {
                        $success = true;
                    } else {

                        $typeCode = '005';
                        $typeCodeDescription = '005-Process-error-CashManagementCurrent';
                        $typeError = 'manager-process';
                        $msg = '<div class="manager-results-type">';
                        $msg .= '    <div class="information-error">';
                        $msg .= '' . $CashManagementCurrent['msg'];
                        $msg .= '    </div>';
                        $msg .= '</div>';
                        $paramsError = array(
                            'title' => 'Error',
                            'description' => $msg,
                        );

                    }


                } else {

                    $typeCode = '004';
                    $typeCodeDescription = '004-Process-error-iva-configuration';
                    $typeError = 'manager-process';
                    if (empty($ivaconfiguration)) {
                        $msj_cod_fac = "Iva Configuración.";
                    }
                    $isPartialError = false;
                    $urlManager = url("managerBusiness/$business_id/managerTaxByBusiness");
                    $linkManager = "<a href='$urlManager'>" . '    No existe asignado un iva en la empresa.' . "</a>";
                    $msg = '<div class="manager-results-type">';
                    $msg .= '    <div class="information-error">';
                    $msg .= $linkManager;
                    $msg .= '    </div>';
                    $msg .= '</div>';

                    $paramsError = array(
                        'title' => $msj_cod_fac,
                        'description' => $msg,
                        'processName' => 'iva'

                    );

                }


            } else {
                $isPartialError = false;
                $typeCode = '003';
                $typeCodeDescription = '003-Process-error-allowProcessBuySales';
                $typeError = 'manager-process';
                $msg = '<div class="manager-results-type">';
                $msg .= '    <div class="information-error">';
                $msg .= '    No exite una caja asignada a tu cuenta.';
                $msg .= '    </div>';
                $msg .= '</div>';

                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );

            }
        } else {
            $error = $managerResultsProcess['error'];
            $typeError = $managerResultsProcess['typeError'];
            if ($typeError != '') {
                $isPartialError = true;
                $typeCode = '001';
                $typeCodeDescription = '001-Process-error';

                $msg = '<div class="content-description">' . $error . '</div>';
                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );
            } else {
                $isPartialError = true;
                $typeCode = '002';
                $typeCodeDescription = '002-Process-error';
                $typeError = '404';
                $msg = '<div class="content-description">Error desconocido</div>';
                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );

            }
        }

        $managerError = [
            'typeError' => $typeError,
            'typeCode' => $typeCode,
            'typeCodeDescription' => $typeCodeDescription,
            'params' => $paramsError,
            'isPartialError' => $isPartialError

        ];


        $result = [
            'managerError' => $managerError,
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
        return $result;

    }

    public function processSales($params)
    {
        $business_id = $params['filters']['business_id'];
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        $user = $dataUserManager['user'];
        $user_id = $user->id;
        $modelBusiness = new \App\Models\Business();
        $business = $modelBusiness->findByAttributes([
            'id' => $business_id
        ]);

        $success = false;
        //---DATA EntityAuthorizationConfiguration --
        $modelEAC = new \App\Models\EntityAuthorizationConfiguration();
        $type = $modelEAC::RETENTION_RECEIPT_TYPE;
        $state = $modelEAC::STATE_ACTIVE;
        $managerCurrentParams = [
            'entity_data_id' => $business_id
            , 'type' => $type
            , 'state' => $state
        ];


        $no_autorizacion_data = $modelEAC->findByAttributes($managerCurrentParams);
        $no_autorizacion = array();
//RETENTION_RECEIPT_TYPE
        if ($no_autorizacion_data) {
            $no_autorizacion = $no_autorizacion_data->attributes;
        }
//----BUSINESS INFORMATION--
        $util = new \App\Utils\Util();
        $managerUserInformation = $util->getDataManagerCurrentUser();
        $owner_id = $managerUserInformation['user']->id; //USER MANAGER CURRENT
        $params_data_search = array("user_id" => $owner_id);
        $modelBBE = new \App\Models\BusinessByEmployeeProfile();
        $model_epgu = $modelBBE->getUserEmployerInformation($params_data_search);

        $data_empresa = array();
        $data_empresa["user"]["nombres"] = "Administrador Total";
        $data_empresa["user"]["identificacion"] = "123456789";
        if ($model_epgu) {
            $data_empresa["user"]["nombres"] = $model_epgu->people_name . " " . $model_epgu->people_last_name;
            $data_empresa["user"]["identificacion"] = $model_epgu->identification_document;
        }

        $data_empresa["empresa"] = (array)$business;
        //InformationAddress
        $direccion_tipo_id = \App\Models\InformationAddressType::TYPE_BUSINESS;
        $modelIA = new \App\Models\InformationAddress();
        $params_data_search = array("main" => 1, "entity_type" => $modelIA::ENTITY_TYPE_BUSINESS, "entity_id" => $business_id, "information_address_type_id" => $direccion_tipo_id);
        $model_d = $modelIA->findByAttributes($params_data_search);

        $data_empresa["empresa"]["direccion"]["referencia"] = "Referencia no Asignada a la Empresa";
        $data_empresa["empresa"]["direccion"]["calles"] = "Calles no Asignada a la Empresa";
        $data_empresa["empresa"]["saludo"]["1"] = "LA BENDICIÓN DE JEHOVÁ ES LA QUE ENRIQUECE, Y NO AÑADE";
        $data_empresa["empresa"]["saludo"]["2"] = "TRISTEZA CON ELLA. PROVERBIOS 10:22";
        $data_empresa["empresa"]["gracias"] = "¡¡ GRACIAS POR SU COMPRA !!";
        $data_empresa["empresa"]["logo"] = URL($this->pathsManagementProject['baseUrlPublic'] . '/images/business/logos/logo_white_lyric.jpg');
        if ($model_d) {
            $direccion = $model_d->street_one;
            $referencia = $model_d->reference;
            if ($model_d->street_one != "") {
                $direccion = $model_d->street_one . " " . $model_d->street_two;
            }
            $data_empresa["empresa"]["direccion"]["referencia"] = $referencia;
            $data_empresa["empresa"]["direccion"]["calles"] = $direccion;
        }

        //TaxByBusiness
        $modelBBT = new \App\Models\TaxByBusiness();
        $ivaconfiguration = $modelBBT->getEntidadIvaConfiguracion([
            'filters' => [
                'business_id' => $business_id
            ]
        ]);
//TYPE PAYMENTS
        $modelTP = new \App\Models\TypesPayments();
        $getDataPagos = $modelTP->getDataPagos([]);
//-------------ALLOWS
//---INIT VIEW SUBPROCESOS DE LOS PROCESOS
//INIT RETENCIONES

        $allowViewRetentions = false;
        $modelAPT = new \App\Models\AllowProcessesThreads();
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_RETENCIONES;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewRetentions = true;
        }
//ESTABLECIMIENTO

        $allowViewEstablishment = $modelAPT::ventas_establecimiento;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_ESTABLECIMIENTO_CODIGO;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );
        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewEstablishment = true;
        }
//DESCUENTOS
        $allowViewDiscount = $modelAPT::ventas_descuento;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_DESCUENTOS;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewDiscount = true;
        }
//FECHA
        $allowViewDateForm = $modelAPT::ventas_fecha;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_FECHA;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);

        if ($modelSubProcess) {
            $allowViewDateForm = true;
        }
//FORMAS DE PAGO
        $allowViewWayPayments = false;
        $processNameAllow = $modelAPT::PROCESO_VENTAS_INVENTARIO;
        $subprocessName = $modelAPT::SUBPROCESO_VENTAS_INVENTARIO_FORMAS_PAGO;
        $allow = 1;
        $params_data_search = array(
            'filters' => [
                "business.id" => $business_id,
                "allow_processes_threads.name_process" => $processNameAllow,
                "allow_processes_threads.thread_name" => $subprocessName,
                "allow_processes_threads.allow" => $allow,
            ]

        );

        $modelSubProcess = $modelAPT->findByAttributesByProcessBusiness($params_data_search);
        if ($modelSubProcess) {
            $allowViewWayPayments = true;
        }

        //SUBPROCESS MANAGER
        $subprocessManager = array(
            "retenciones" => $allowViewRetentions,
            "establecimiento" => $allowViewEstablishment,
            "descuento" => $allowViewDiscount,
            "fecha" => $allowViewDateForm,
            "formas_pago" => $allowViewWayPayments,
        );
        $procesos_all = array(
            "VENTAS_INVENTARIO" => $subprocessManager,
        );

        //----CUSTOMER DEFAULT---
        $dataFinalCustomer = array();
        $params_data_search = array();
        $modelBFC = new \App\Models\BusinessByFinalCustomer();
        $modelBBFC = $modelBFC->findByAttributes(array('business_id' => $business_id));

        $allowFinalCustomer = false;
        if ($modelBBFC) {
            $modelCustomer = new \App\Models\Customer();
            $modelC = $modelCustomer->findByAttributes(array('id' => $modelBBFC->customer_id));
            $allowFinalCustomer = true;
            $dataFinalCustomer = (array)$modelC;
            $params_data_search = array(
                "id" => $modelC->people_id
            );
            $modelP = new \App\Models\People();
            $model_persona = $modelP->findByAttributes($params_data_search);
            $text = "SN";
            $nombres_cliente = "SN";
            if ($model_persona) {
                $text = $modelC->identification_document . " " . $model_persona->name . " " . $model_persona->last_name;
                $nombres_cliente = $model_persona->name . " " . $model_persona->last_name;
            }
            if ($modelC->people_type_identification_id == 2) { // RUC
                $leftText=$modelC->business_reason == '' && $modelC->business_reason == '' ? $model_persona->name . " " . $model_persona->last_name : $modelC->business_reason;

                $text = $modelC->identification_document . " " . $leftText;
                $nombres_cliente =$leftText;
            }
            $dataFinalCustomer["direccion"] = "SN Y SN";
            $dataFinalCustomer["email"] = "SN Y SN";
            $dataFinalCustomer["telefono"] = "SN Y SN";
            $dataFinalCustomer["nombres_cliente"] = $nombres_cliente;
            $dataFinalCustomer["text"] = $text;
        }
//CASH
        $allowProcessBuySales = true;
        $modelCBU = new \App\Models\CashByUser;
        $resultSearch = null;
        $paymentTypeMix = true;
        $paymentType = false;

        if ($business->allow_cash_and_banks) {
            $resultSearch = $modelCBU->getAllowProcessByRole(array("processName" => "typeOfPaymentsMixed"));
            $paymentTypeMix = $resultSearch["success"];
        } else {
            $paymentTypeMix = true;
        }
        $viewProcessAllow = array(
            "paymentTypeMix" => $paymentTypeMix,
            "paymentType" => $paymentType,

        );

        $modelIS = new \App\Models\InvoiceSale();
        $managerResultsProcess = $modelIS->initAllowManagerProcess(array(
            'businessId' => $business_id
        ));

        $resultCUBC = $modelCBU->getCashUserByCurrent(array("entidad_data_id" => $business_id, 'user_id' => $user_id));
        $managementCash = [
            'cashCurrentUser' => $resultCUBC
        ];

        $modelC = new \App\Models\Caja();
        $dateCurrent = \App\Utils\Util::DateCurrent();
        $firstMonthDay = \App\Utils\Util::firstMonthDay();
        $dateInit = \App\Utils\Util::FormatDate($firstMonthDay, 'Y-m-d 00:00:00');
        $dateEnd = \App\Utils\Util::FormatDate($dateCurrent, 'Y-m-d H:i:s');
        $CashManagementCurrent = $modelC->getAllowManagement([
            'filters' => [
                'dateInit' => $dateInit,
                'dateEnd' => $dateEnd,
                'entidad_data_id' => $business_id,
                'user_id' => $user_id
            ]
        ]);

        if (!$business->allow_cash_and_banks) {
            $allowProcessBuySales = true;
        } else {

            if (!$resultSearch["success"]) {//not is ROLE MANAGER
                $allowProcessBuySales = true;
            } else {
                if ($resultCUBC == null) {
                    $allowProcessBuySales = false;
                }
            }
        }
        $fecha_emision = \App\Utils\Util::FormatDate(\App\Utils\Util::DateCurrent(), "d-m-Y");

        $business_id = $business->id;
        $type_gestion = "ventas_factura";
        $entidad_name_empresa = "autosur"; //change print type
        $type_disenio = $entidad_name_empresa;

        $entidad_name_modulo = "appEntidadData";
        $entidad_ctrl = "institucionHasAskwer";
        $entidad_name = "cliente";
        $managerRound = 4;
        $data = [
            'managerRound' => $managerRound,
            'entidadid' => $business_id,
            'no_autorizacion' => ($no_autorizacion),
            'fecha_emision' => $fecha_emision,
            'ivaconfiguration' => $ivaconfiguration,
            'entidad_tipo' => 'entidadData',
            // Creacion del modulo
            'entidad_name_modulo' => $entidad_name_modulo,
            'entidad_name_ctrl' => $entidad_ctrl,
            //    ---GESTION DE BOTONES ADD--
            'gestion_data_view' => false,
            'data_empresa' => ($data_empresa),
            'type_disenio' => ($type_disenio),
            'getDataPagos' => ($getDataPagos),
            //    ----SUBPROCESOS ALLOW---
            'procesos_all' => ($procesos_all),
            'dataFinalCustomer' => ($dataFinalCustomer),
            'allowFinalCustomer' => ($allowFinalCustomer),
            'viewProcessAllow' => ($viewProcessAllow),
            'managerResultsProcess' => ($managerResultsProcess),
            'managementCash' => ($managementCash),
            'CashManagementCurrent' => ($CashManagementCurrent),

        ];
        $typeError = null;
        $typeCode = '';
        $typeCodeDescription = '';
        $msg = '';
        $paramsError = [];
        $isPartialError = false;

        if ($managerResultsProcess['success']) {
            if ($allowProcessBuySales) {
                if (!empty($ivaconfiguration)) { //ASIGNACION DE IVA CONFIGURADO VERIFICACION
                    /*-----GESTION DE FACTURA DETALLE----*/
                    $allowPrettyCash = $CashManagementCurrent['allow'];
                    if ($allowPrettyCash) {
                        $success = true;


                    } else {

                        $typeCode = '005';
                        $typeCodeDescription = '005-Process-error-CashManagementCurrent';
                        $typeError = 'manager-process';
                        $msg = '<div class="manager-results-type">';
                        $msg .= '    <div class="information-error">';
                        $msg .= '' . $CashManagementCurrent['msg'];
                        $msg .= '    </div>';
                        $msg .= '</div>';
                        $paramsError = array(
                            'title' => 'Error',
                            'description' => $msg,
                        );

                    }


                } else {

                    $typeCode = '004';
                    $typeCodeDescription = '004-Process-error-iva-configuration';
                    $typeError = 'manager-process';
                    if (empty($ivaconfiguration)) {
                        $msj_cod_fac = "Iva Configuración.";
                    }
                    $isPartialError = false;
                    $paramsError = array(
                        'title' => $msj_cod_fac,
                        'description' => $msg,
                        'processName' => 'iva'

                    );

                }


            } else {
                $isPartialError = false;
                $typeCode = '003';
                $typeCodeDescription = '003-Process-error-allowProcessBuySales';
                $typeError = 'manager-process';
                $msg = '<div class="manager-results-type">';
                $msg .= '    <div class="information-error">';
                $msg .= '    No exite una caja asignada a tu cuenta.';
                $msg .= '    </div>';
                $msg .= '</div>';

                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );

            }
        } else {
            $error = $managerResultsProcess['error'];
            $typeError = $managerResultsProcess['typeError'];
            if ($typeError != '') {
                $isPartialError = true;
                $typeCode = '001';
                $typeCodeDescription = '001-Process-error';

                $msg = '<div class="content-description">' . $error . '</div>';
                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );
            } else {
                $isPartialError = true;
                $typeCode = '002';
                $typeCodeDescription = '002-Process-error';
                $typeError = '404';
                $msg = '<div class="content-description">Error desconocido</div>';
                $paramsError = array(
                    'title' => 'Error',
                    'description' => $msg,
                );

            }
        }

        $managerError = [
            'typeError' => $typeError,
            'typeCode' => $typeCode,
            'typeCodeDescription' => $typeCodeDescription,
            'params' => $paramsError,
            'isPartialError' => $isPartialError

        ];

        $result = [
            'managerError' => $managerError,
            'success' => true,
            'data' => $data,
            'msg' => $msg
        ];
        return $result;

    }

    public function managerAllowProcess($params)
    {

    }

}
