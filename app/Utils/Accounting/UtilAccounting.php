<?php

namespace App\Utils\Accounting;

use Illuminate\Support\Facades\DB;

class UtilAccounting
{

    const indebtednessSale = "invoice_sale_by_pendient";
    const indebtednessBuy = "invoice_buy_by_pendient";

    const indebtednessInitSale = "invoice_sale_by_indebtedness_paying_init";
    const indebtednessInitBuy = "invoice_buy_by_indebtedness_paying_init";

    const indebtednessBreakDownSale = "invoice_sale_by_breakdown_payment";
    const indebtednessBreakDownBuy = "invoice_buy_by_breakdown_payment";

    const indebtednessBreakDownCollectionPaymentsSale = "invoice_sale_by_payment";
    const indebtednessBreakDownCollectionPaymentsBuy = "invoice_buy_by_payment";
    const viewRound = 2;
    const managerRound = 4;
    const gain = 30;

    /*Payment Methods*/
    /*Tabla 13*/
    const codePaymentCash = "01";
    const codePaymentCreditCard = "19";
    const codePaymentCreditDebt = "16";
    const codeEndorsementOfTitles = "21";
    const codeElectronicMoney = "17";

    public function getDataTypePayments()
    {
        $result = array();
        $typePaymentNoUseOfTheFinancialSystem = array(
            "id" => 1,
            "state" => "ACTIVE",
            "code" => "01",
            "name" => "SIN UTILIZACION DEL SISTEMA FINANCIERO",
        );
        array_push($result, $typePaymentNoUseOfTheFinancialSystem);
        $yourOwnCheck = array(
            "id" => 2,
            "state" => "INACTIVE",
            "code" => "02",
            "name" => "CHEQUE PROPIO",
        );
        array_push($result, $yourOwnCheck);
        $certifiedCheck = array(
            "id" => 3,

            "state" => "INACTIVE",
            "code" => "03",
            "name" => "CHEQUE CERTIFICADO",
        );
        array_push($result, $certifiedCheck);

        $cashiersCheck = array(
            "id" => 4,

            "state" => "INACTIVE",
            "code" => "04",
            "name" => "CHEQUE DE GERENCIA",
        );
        array_push($result, $cashiersCheck);

        $exteriorCheck = array(
            "id" => 5,

            "state" => "INACTIVE",
            "code" => "05",
            "name" => "CHEQUE DEL EXTERIOR",
        );
        array_push($result, $exteriorCheck);

        $accountDebit = array(
            "id" => 6,

            "state" => "INACTIVE",
            "code" => "06",
            "name" => "DÉBITO DE CUENTA",
        );
        array_push($result, $accountDebit);

        $bankOwnTransfer = array(
            "id" => 7,

            "state" => "INACTIVE",
            "code" => "07",
            "name" => "TRANSFERENCIA PROPIO BANCO ",
        );
        array_push($result, $bankOwnTransfer);

        $transferAnotherNationalBank = array(
            "id" => 8,

            "state" => "INACTIVE",
            "code" => "08",
            "name" => "TRANSFERENCIA OTRO BANCO NACIONAl",
        );
        array_push($result, $transferAnotherNationalBank);

        $externalBankTransfer = array(
            "id" => 9,

            "state" => "INACTIVE",
            "code" => "09",
            "name" => "TRANSFERENCIA BANCO EXTERIOR",
        );
        array_push($result, $externalBankTransfer);

        $nationalCreditCard = array(
            "id" => 10,

            "state" => "INACTIVE",
            "code" => "10",
            "name" => "TARJETA DE CRÉDITO NACIONAL",
        );
        array_push($result, $nationalCreditCard);

        $internationalCreditCard = array(
            "id" => 11,

            "state" => "INACTIVE",
            "code" => "11",
            "name" => "TARJETA DE CRÉDITO INTERNACIONAL",
        );
        array_push($result, $internationalCreditCard);

        $turn = array(
            "id" => 12,

            "state" => "INACTIVE",
            "code" => "12",
            "name" => "GIRO",
        );
        array_push($result, $turn);

        $depositInAccount = array(
            "id" => 13,
            "state" => "INACTIVE",
            "code" => "13",
            "name" => "DEPOSITO EN CUENTA (CORRIENTE/AHORROS)",
        );
        array_push($result, $depositInAccount);

        $inversionEndorsement = array(
            "id" => 14,

            "state" => "INACTIVE",
            "code" => "14",
            "name" => "ENDOSO DE INVERSIÒN ",
        );
        array_push($result, $inversionEndorsement);

        $debtCompensation = array(
            "id" => 15,

            "state" => "ACTIVE",
            "code" => "15",
            "name" => "COMPENSACIÓN DE DEUDAS",
        );
        array_push($result, $debtCompensation);

        $debit = array(
            "id" => 16,

            "state" => "ACTIVE",
            "code" => "16",
            "name" => "TARJETA DE DÉBITO ",
        );
        array_push($result, $debit);

        $electronicMoney = array(
            "id" => 17,

            "state" => "ACTIVE",
            "code" => "17",
            "name" => "DINERO ELECTRÓNICO ",
        );
        array_push($result, $electronicMoney);

        $prepaidCard = array(
            "id" => 18,

            "state" => "ACTIVE",
            "code" => "18",
            "name" => "TARJETA PREPAGO",
        );
        array_push($result, $prepaidCard);

        $creditCard = array(
            "id" => 19,

            "state" => "ACTIVE",
            "code" => "19",
            "name" => "TARJETA DE CRÉDITO",
        );
        array_push($result, $creditCard);

        $othersWithTheUseOfTheFinancialSystem = array(
            "id" => 20,

            "state" => "ACTIVE",
            "code" => "20",
            "name" => "OTROS CON UTILIZACION DEL SISTEMA FINANCIERO",
        );
        array_push($result, $othersWithTheUseOfTheFinancialSystem);

        $endorsementOfTitles = array(
            "id" => 21,

            "state" => "ACTIVE",
            "code" => "21",
            "name" => "ENDOSO DE TÍTULOS",
        );
        array_push($result, $endorsementOfTitles);
        return $result;

    }

    public function getTypePaymentByParams($params)
    {

        $needle = $params["needle"];
        $dataPayments = $this->getDataTypePayments();
        $resultSearch = \App\Utils\Util::searchDataByParams(array("haystack" => $dataPayments, "keySearch" => "code", "valueComparate" => $needle));
        return count($resultSearch) > 0 ? $resultSearch[0]["id"] : -1;

    }


    function getAdjustAccountingEntries($params)
    {
        $haystack = $params["haystack"];
        foreach ($haystack as $keySA => $row) {

            if (isset($row["data"])) {//buys
                $dataLibroDiario = $row["data"];
                $haystack[$keySA]["data"] = $this->getAccountingEntriesValid(array("haystack" => $dataLibroDiario));
            } else {
                $dataLibroDiario = $row["childrens"];//sales
                $haystack[$keySA]["data"] = $this->getAccountingEntriesValid(array("haystack" => $dataLibroDiario));

            }
        }

        return $haystack;
    }

    public
    function getAccountingEntriesValid($params)
    {
        $roundManager = UtilAccounting::managerRound;

        $haystack = $params["haystack"];
        $resultSumEntries = $this->sumAccountingEntries($params);


        $debeManager = $resultSumEntries["debe"];
        $totalItemsDebe = $debeManager["totalItems"];
        $totalSumDebe = $debeManager["totalSum"];

        $haberManager = $resultSumEntries["haber"];
        $totalItemsHaber = $haberManager["totalItems"];
        $totalSumHaber = $haberManager["totalSum"];

        $resultDebeDifHaber = $totalSumDebe - $totalSumHaber;

        $allowIncrement = false;
        $incrementDecrement = 0;
        if ($resultDebeDifHaber < 0) {
            $allowIncrement = true;
            $incrementDecrement = ($resultDebeDifHaber * -1) / $totalItemsDebe;


        } else if ($resultDebeDifHaber > 0) {
            $incrementDecrement = ($resultDebeDifHaber * -1) / $totalItemsDebe;
            $allowIncrement = true;
        }
        if ($allowIncrement) {
            $DEBE = \App\Models\DiaryBook::DEBE;
            $HABER = \App\Models\DiaryBook::HABER;
            foreach ($haystack as $keyDB => $libroDiario) {
                if ($libroDiario["type_ingreso"] == $DEBE) {
                    $resultValue = number_format($libroDiario["valor"] + $incrementDecrement, $roundManager, '.', '');
                    $haystack[$keyDB]["valor"] = $resultValue;
                }
            }
        }
        $result = $haystack;
        return $result;
    }

    public
    function sumAccountingEntries($params)
    {
        $haystack = $params["haystack"];
        $debeSum = 0;
        $haberSum = 0;
        $DEBE = \App\Models\DiaryBook::DEBE;
        $HABER = \App\Models\DiaryBook::HABER;
        $totalItemsDebe = 0;
        $totalItemsHaber = 0;

        foreach ($haystack as $keyDB => $libroDiario) {

            if ($libroDiario["type_ingreso"] == $DEBE) {
                $debeSum += $libroDiario["valor"];

                $totalItemsDebe++;
            } else if ($libroDiario["type_ingreso"] == $HABER) {
                $haberSum += $libroDiario["valor"];


                $totalItemsHaber++;

            }

        }

        $result = array(
            "debe" => array("totalItems" => $totalItemsDebe, "totalSum" => $debeSum),
            "haber" => array("totalItems" => $totalItemsHaber, "totalSum" => $haberSum),

        );
        return $result;

    }

    public
    function getDataInvoiceManagerIndebtedness($params)
    {

        $invoice_id = $params["invoice_id"];
        $type = $params["type"];
        $table_indebtedness = "";
        $table_indebtedness_init = "";
        $table_indebtedness_init_breakdown = "";
        $table_indebtedness_collection_payments = "";
        if ($type == "buy") {
            $table_indebtedness = self::indebtednessBuy;
            $table_indebtedness_init = self::indebtednessInitBuy;
            $table_indebtedness_init_breakdown = self::indebtednessBreakDownBuy;
            $table_indebtedness_collection_payments = self::indebtednessBreakDownCollectionPaymentsBuy;
        } else {
            $table_indebtedness = self::indebtednessSale;
            $table_indebtedness_init = self::indebtednessInitSale;
            $table_indebtedness_init_breakdown = self::indebtednessBreakDownSale;
            $table_indebtedness_collection_payments = self::indebtednessBreakDownCollectionPaymentsSale;
        }

        $indebtednessData = $this->getDataInvoicePendient(
            array(
                "invoice_id" => $invoice_id,
                "table" => $table_indebtedness,
                "keyRelation" => $type == "buy" ? "invoice_buy_id" : "invoice_sale_id",

            )
        );
        $indebtednessInitData = $this->getDataInvoiceInit(
            array(
                "invoice_id" => $invoice_id,
                "table" => $table_indebtedness_init,
                "keyRelation" => $type == "buy" ? "invoice_buy_id" : "invoice_sale_id",

            )
        );

        $indebtednessBreakDownData = array();
        if ($indebtednessInitData) {
            $id = $indebtednessInitData->id;

            $indebtednessBreakDownData = $this->getDataBreakdown(
                array(
                    "id" => $id,
                    "table" => $table_indebtedness_init_breakdown,
                    "keyRelation" => $type == "buy" ? "invoice_buy_by_indebtedness_paying_init_id" : "invoice_sale_by_indebtedness_paying_init_id",

                )
            );

        }

        $paramsManager = array(
            "invoice_id" => $invoice_id,
            "type" => $type,
            "indebtedness" => array(
                "table" => $table_indebtedness,
                "relation_key" => $type == "buy" ? "invoice_buy_id" : "invoice_sale_id",
                "data" => $indebtednessData,
                "model" => $type == "buy" ? "InvoiceBuyByPendient" : "InvoiceSaleByPendient",
            ),
            "indebtednessInit" => array(
                "table" => $table_indebtedness_init,
                "relation_key" => $type == "buy" ? "invoice_buy_id" : "invoice_sale_id",
                "data" => $indebtednessInitData,
                "model" => $type == "buy" ? "invoiceBuyByIndebtednessPayingInit" : "invoiceSaleByIndebtednessPayingInit",
            ),
            "indebtednessBreakDown" => array(
                "table" => $table_indebtedness_init_breakdown,
                "data" => $indebtednessBreakDownData,
                "relation_key" => $type == "buy" ? "invoice_buys_indebtedness_paying_init_id" : "invoice_sales_indebtedness_paying_init_id",
                "model" => $type == "buy" ? "InvoiceBuyByBreakdownPayment" : "InvoiceSaleByBreakdownPayment",

            ),
            "indebtednessBreakDownCollectionPayments" => array(
                "table" => $table_indebtedness_collection_payments,
                "relation_key" => $type == "buy" ? "invoice_buys_indebtedness_paying_init_id" : "invoice_sales_indebtedness_paying_init_id",
                "model" => $type == "buy" ? "InvoiceBuyByPayment" : "InvoiceSaleByPayment",

            )
        );

        $result = $paramsManager;
        return $result;
    }
    public function getDataInvoiceInit($params)//invoice_sales_by_pendient
    {
        $invoice_id = $params["invoice_id"];
        $tableCurrent = $params["table"];
        $keyRelation = $params["keyRelation"];

        $select = "$tableCurrent.id,$tableCurrent.number_payments numero_pagos,$tableCurrent.invoice_sale_id factura_venta_id ,$tableCurrent.user_id owner_id  ";

        $selectString = $select;
        $field = $tableCurrent . '.id';
        $sort = 'ASC';
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($tableCurrent . '.' . $keyRelation, '=', $invoice_id);
        $query->orderBy($field, $sort);
        $result = $query->first();

        return ($result) ? $result : null;
    }

    public function getDataInvoicePendient($params)//invoice_sales_by_pendient
    {
        $invoice_id = $params["invoice_id"];
        $tableCurrent = $params["table"];
        $keyRelation = $params["keyRelation"];

        $select = "$tableCurrent.id,$tableCurrent.indebtedness_paying,$tableCurrent.invoice_sale_id factura_venta_id";

        $selectString = $select;
        $field = $tableCurrent . '.id';
        $sort = 'ASC';
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($tableCurrent . '.' . $keyRelation, '=', $invoice_id);
        $query->orderBy($field, $sort);
        $result = $query->first();

        return ($result) ? $result : null;
    }

    public
    function getDataBreakdown($params)
    {

        $id = $params["id"];
        $tableCurrent = $params["table"];
        $keyRelation = $params["keyRelation"];
        $select = "$tableCurrent.id ,$tableCurrent.date_agreement fecha_pago_acuerdo,$tableCurrent.payment_value pago_cantidad,$tableCurrent.state_payment state,$tableCurrent.user_id owner_id,$tableCurrent.invoice_sale_by_indebtedness_paying_init_id invoice_sales_indebtedness_paying_init_id  ,$tableCurrent.description descripcion";

        $selectString=$select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($tableCurrent . '.' . $keyRelation, '=', $id);
        $result = $query->get()->toArray();

        return $result;
    }

    public
    function getTrafficLight($params)
    {
        $model_hfv = EntidadHasFacturaVenta::model()->getFacturaEntidad($_POST);
        foreach ($model_hfv as $key_hfv => $value_hfv) {
            $model_pvhe = PagosVentasHasEntidad::model()->find("factura_venta_id=" . $value_hfv["factura_venta_id"]);
            if (isset($model_pvhe)) {
                $suma_pendiente = $model_pvhe->monto_deuda + $suma_pendiente;
                $model_fvpd = FacturaVentaPagoDesgloce::model()->find("pagos_ventas_has_entidad_id=" . $model_pvhe->id);
                if (isset($model_fvpd)) {
                    if ($model_pvhe->id == $model_fvpd->pagos_ventas_has_entidad_id) {
                        $model_fvpf = FacturaVentaPagosFechas::model()->findAll("factura_venta_pago_desgloce_id=" . $model_pvhe->id . " and estado_gestion=" . "1");
                        foreach ($model_fvpf as $key => $value) {
                            if ($value["estado_gestion"] == 1) {
                                $suma_pendiente_pagos = $suma_pendiente_pagos + $value["pago_cantidad"];
                            } else if ($value["estado_gestion"] == 0) {
                                $suma_pendiente_pediente = $suma_pendiente_pediente + $value["pago_cantidad"];
                            }
                        }

                        $model_fvpf = FacturaVentaPagosFechas::model()->findAll("factura_venta_pago_desgloce_id=" . $model_pvhe->id . " and estado_gestion=" . "0");
                        foreach ($model_fvpf as $key => $value) {
                            $fecha_em = explode(" ", $fecha);
                            if (strtotime($value["fecha_pago_acuerdo"]) < strtotime($fecha_em[0])) {
                                $retrasados = $retrasados + $value["pago_cantidad"];
                            }
                        }
                    }
                }
            }

            $model_fv = FacturaVenta::model()->findByPk($value_hfv["factura_venta_id"]);

            if ($model_fv->estado == "EMITIDO") {
                $suma_pagados = $model_fv->valor_factura + $suma_pagados;
            }
            $suma_estimados = $model_fv->valor_factura + $suma_estimados;
        }
    }


    public
    function getManagerBusiness($params)
    {
        $utilUTA = new UtilUnifiedTransactionalAnnex;
        $result = array();
        $entidad_data_id = $params["filters"]["entidad_data_id"];
        $model_ehrl = EntidadHasRepresentanteLegal::model()->findByAttributes(array('entidad_data_id' => $entidad_data_id));
        $model_ehc = EntidadHasContador::model()->findByAttributes(array('entidad_data_id' => $entidad_data_id));
        $modelE = EntidadData::model()->findByAttributes(array('id' => $entidad_data_id));
        $legalAccountant = array();
        $legalRepresentative = array();
        if ($model_ehc && $model_ehrl) {
            $model_epr = EmpleadoPerfil::model()->findByAttributes(array('id' => $model_ehrl->empleado_perfil_id));

            $legalRepresentative["IdInformante"] = $model_epr->identificacion;
            $legalRepresentative["tipo_identificacion_id"] = $model_epr->tipo_identificacion_id;
            $typeDocumentId = $model_epr->tipo_identificacion_id;
            $legalRepresentative["TipoIDInformante"] = $utilUTA->getCodeIdentificationType(array("typeDocumentId" => $typeDocumentId));
            $legalRepresentative["razonSocial"] = $modelE->razon_social;

            $model_epc = EmpleadoPerfil::model()->findByAttributes(array('id' => $model_ehc->empleado_perfil_id));
            $legalAccountant["IdInformante"] = $model_epc->identificacion;
            $legalAccountant["tipo_identificacion_id"] = $model_epc->tipo_identificacion_id;
            $typeDocumentId = $model_epc->tipo_identificacion_id;
            $legalAccountant["TipoIDInformante"] = $utilUTA->getCodeIdentificationType(array("typeDocumentId" => $typeDocumentId));
            $legalAccountant["razonSocial"] = "NO EXISTE CONFIG";

        }
        $result["legalRepresentative"] = $legalRepresentative;
        $result["legalAccountant"] = $legalAccountant;

        return $result;

    }


}
