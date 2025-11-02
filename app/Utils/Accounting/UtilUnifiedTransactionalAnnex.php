<?php
namespace App\Utils\Accounting;

class UtilUnifiedTransactionalAnnex
{


    /*-----Transactional Annex------*/
    const buyCodeRUC = "01";
    const buyCodeCEDULA = "02";
    const buyCodePASSPORT = "03";

    const saleCodeRUC = "04";
    const saleCodeCEDULA = "05";
    const saleCodePASSPORT = "06";
    const saleCodeFINALCONSUMER = "07";

    const export = "09";

    const cardCreditRUC = "10";
    const cardCreditPASSPORT = "11";

    const financialPerformancesRUC = "12";
    const financialPerformancesCEDULA = "13";
    const financialPerformancesPASSPORT = "14";

    const fundsAndTrustsRUC = "15";
    const fundsAndTrustsCEDULA = "16";
    const fundsAndTrustsPASSTPORT = "17";

    const voidedProofs = "18";//comprobantes anulados

    const salePLACA = "19";
    const exportRUC = "20";
    const exportPASSTPORT = "21";


    const typeDocumentCEDULA = 1;
    const codeTypeDocumentCEDULA = "C";

    const typeDocumentRUC = 2;
    const codeTypeDocumentRUC = "R";

    const typeDocumentPASSPORT = 3;
    const codeTypeDocumentPASSPORT = "P";//PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR

    const typeDocumentFINALCONSUMER = 4;
    const codeTypeDocumentFINALCONSUMER = "F";

    const typeDocumentPLACA = 5;
    const typeDocumentWHITHOUT = 6;


    static $typeTransactionBuy = array(
        "code" => "1",
        "name" => "Compra"
    );
    static $typeTransactionSale = array(
        "code" => "2",
        "name" => "Venta"
    );
    static $typeTransactionExport = array(
        "code" => "3",
        "name" => "Exportación"
    );
    static $typeTransactionCreditCards = array(
        "code" => "4",
        "name" => "Tarjetas de Credito"
    );
    static $typeTransactionFinancialPerformances = array(
        "code" => "5",
        "name" => "Rendimientos Financieros"
    );
    static $typeTransactionFundsAndFinancial = array(
        "code" => "6",
        "name" => "Fondos y Financieros"
    );

    public function getCodeIdentificationType($params)
    {
        $result = "";
        $typeDocumentId = $params["typeDocumentId"];
        if (self::typeDocumentRUC == $typeDocumentId) {
            $result = self::codeTypeDocumentRUC;
        } else if (self::typeDocumentCEDULA == $typeDocumentId) {
            $result = self::codeTypeDocumentCEDULA;
        } else if (self::typeDocumentPASSPORT == $typeDocumentId) {
            $result = self::codeTypeDocumentPASSPORT;
        } else if (self::typeDocumentFINALCONSUMER == $typeDocumentId) {
            $result = self::codeTypeDocumentFINALCONSUMER;

        }
        return $result;
    }

    public function getCodeTipoEmision($params)
    {
        $result = "";
        $voucherTypeCode = $params["voucherTypeCode"];
        if ("01" == $voucherTypeCode) {//INVOICE
            $result = "F";
        } else if ("02" == $voucherTypeCode) {
            $result = "NV";

        } else if ("03" == $voucherTypeCode) {
            $result = "LC";
        } else if ("04" == $voucherTypeCode) {
            $result = "NC";


        }
        return $result;
    }

    public function getCodeTypeByTypeDocumentTransaction($params)
    {
        $type = $params["type"];
        $typeDocumentId = $params["typeDocumentId"];
        $resultDataCode = $this->getCodeDataAnnex();
        $haystack = $resultDataCode[$type];
        $result = $this->getCodeAnnex(array("haystack" => $haystack, "type" => $type, "typeDocumentId" => $typeDocumentId));
        return $result;
    }

    public function getCodeAnnex($params)
    {
        $haystack = $params["haystack"];
        $type = $params["type"];
        if ($type == "buys") {


        } else if ($type == "sales") {


        } else if ($type == "export") {


        } else if ($type == "credit") {


        } else if ($type == "financialPerformances") {


        } else if ($type == "fundsAndTrusts") {


        } else if ($type == "voidedProofs") {

        }
        $typeDocumentId = $params["typeDocumentId"];
        $result = "";

        foreach ($haystack as $key => $value) {
            if ($key == $typeDocumentId) {
                $result = $value;
            }

        }
        return $result;
    }

    public function getCodeDataAnnex()
    {
        /* Tabla 2: Tipo de Identificación*/
        $result = array();
        $result["buys"] = array(
            self::typeDocumentRUC =>array("value"=>self::buyCodeRUC,"text"=>"RUC") ,
            self::typeDocumentCEDULA => array("value"=>self::buyCodeCEDULA,"text"=>"CEDULA"),
            self::typeDocumentPASSPORT => array("value"=>self::buyCodePASSPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR"),
        );
        $result["sales"] = array(
            self::typeDocumentRUC => array("value"=>self::saleCodeRUC,"text"=>"RUC"),
            self::typeDocumentCEDULA =>array("value"=> self::saleCodeCEDULA,"text"=>"CEDULA"),
            self::typeDocumentPASSPORT =>array("value"=> self::saleCodePASSPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR"),
            self::typeDocumentFINALCONSUMER => array("value"=>self::saleCodeFINALCONSUMER,"text"=>"CONSUMIDOR FINAL"),
            self::typeDocumentPLACA => array("value"=>self::salePLACA,"text"=>"PLACA o RAMV/CPN"),
        );
        $result["credit"] = array(
            self::typeDocumentRUC => array("value"=>self::cardCreditRUC,"text"=>"RUC"),
            self::typeDocumentPASSPORT => array("value"=>self::cardCreditPASSPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR"),
        );
        $result["export"] = array(
            self::export=> array("value"=>self::typeDocumentWHITHOUT,"text"=>"-"),
            self::typeDocumentRUC =>array("value"=>self::exportRUC,"text"=>"RUC") ,
            self::typeDocumentPASSPORT => array("value"=>self::exportPASSTPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR"),
        );

        $result["financialPerformances"] = array(
            self::typeDocumentRUC => array("value"=>self::financialPerformancesRUC,"text"=>"RUC"),
            self::typeDocumentCEDULA => array("value"=>self::financialPerformancesCEDULA,"text"=>"CEDULA"),
            self::typeDocumentPASSPORT =>array("value"=>self::financialPerformancesPASSPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR") ,
        );
        $result["fundsAndTrusts"] = array(
            self::typeDocumentRUC => array("value"=>self::fundsAndTrustsRUC,"text"=>"RUC"),
            self::typeDocumentCEDULA => array("value"=>self::fundsAndTrustsCEDULA,"text"=>"CEDULA"),
            self::typeDocumentPASSPORT => array("value"=>self::fundsAndTrustsPASSTPORT,"text"=>"PASAPORTE / IDENTIFICACIÓN TRIBUTARIA DEL EXTERIOR"),
        );
        $result["voidedProofs"] = array(
            self::voidedProofs=>array("value"=>"","text"=>"-"),
        );

        return $result;
    }

    /* --------ANNEX INVOICE MANAGER--------*/
//**step 1

    public function getStructureTransactionalAnnex($params)
    {
        $modelI = new FacturaCompra;
        $modelID = new FacturaDetalleCompra;
        $modelHR = new FacturaComprasHasRetenciones;
        $utilA = new UtilAccounting;
        $result = array();
        $paramsCurrent = array(
            "filters" => $params["filters"],
            "type" => "buys",
            "modelsManager" => array(
                "details" => $modelID,
                "invoice" => $modelI,
                "retention" => $modelHR
            ));

        $buys = $this->getManagerTransactionalAnnex($paramsCurrent);

        $result["buys"] = $buys;

        $modelI = new FacturaVenta;
        $modelID = new FacturaDetalleVenta;
        $modelHR = new FacturaVentasHasRetenciones;
        $paramsCurrent = array(
            "filters" => $params["filters"],
            "type" => "sales",
            "modelsManager" => array(
                "details" => $modelID,
                "invoice" => $modelI,
                "retention" => $modelHR
            ));
        $sales = $this->getManagerTransactionalAnnex($paramsCurrent);
        $salesResult = array();
        $salesResult["customers"] = $this->getDataGroupByCustomer(array("haystack" => $sales["data"]));

        $sales = array_merge($salesResult, $sales);
        $result["sales"] = $sales;

        $result["managerBusiness"] = $utilA->getManagerBusiness($params);
        return $result;
    }

//** step 2 */

    public function getManagerTransactionalAnnex($params)
    {


        $sumnoI = 0.00;
        $sumrate0 = 0.00;
        $sumdifferentRate0 = 0.00;
        $sumnoTax = 0.00;
        $sumtax = 0.00;
        $sumtotal = 0.00;
        $sumsubtotal = 0.00;
        $modelsManager = $params["modelsManager"];
        $invoicesData = $modelsManager["invoice"]->getDataTransactionalAnnex($params);
        $type = $params["type"];
        foreach ($invoicesData as $key => $rowInvoice) {
            $id = $rowInvoice["id"];
            $typeDocumentId = $rowInvoice["tipo_identificacion_id"];
            $has_retencion = $rowInvoice["has_retencion"];
            $dataRetencion = array();
            if ($has_retencion == 1) {
                $dataRetencion = $modelsManager["retention"]->getDataRetencionInvoice(array("filters" => array("invoice_id" => $id)));
            }
            $detailsData = $modelsManager["details"]->getDataDetailsInvoice(array("filters" => array("invoice_id" => $id)));
            $invoicesData[$key]["detailsData"] = $detailsData;
            $invoicesData[$key]["dataRetencion"] = $dataRetencion;
            $invoicesData[$key]["TipoIDInformante"] = $this->getCodeTypeByTypeDocumentTransaction(array("typeDocumentId" => $typeDocumentId, "type" => $type));
            $keyAnnexManager = "manager_values_all";
            $valueAnnexManager = $this->getManagerAllValuesInvoice(array("haystackRow" => $invoicesData[$key]));
            $values_retention = $valueAnnexManager["values_retention"];
            $values_invoice = $valueAnnexManager["values_invoice"];
            $sumnoI += $values_invoice["noI"];
            $sumrate0 += $values_invoice["rate0"];
            $sumdifferentRate0 += $values_invoice["differentRate0"];
            $sumnoTax += $values_invoice["noTax"];
            $sumtotal += $values_invoice["total"];
            $sumsubtotal += $values_invoice["subtotal"];

            $invoicesData[$key][$keyAnnexManager] = $valueAnnexManager;

        }
        /* $data = $this->getDataGroupByTaxSupport(array("haystack" => $invoicesData));*/
        $data = $invoicesData;
        $result = array(
            "data" => $data,
            "totalInvoice" => array(
                "noI" => number_format($sumnoI, 2, '.', ''),
                "rate0" => number_format($sumrate0, 2, '.', ''),
                "differentRate0" => number_format($sumdifferentRate0, 2, '.', ''),
                "noTax" => number_format($sumnoTax, 2, '.', ''),
                "tax" => number_format($sumtax, 2, '.', ''),
                "total" => number_format($sumtotal, 2, '.', ''),
                "subtotal" => number_format($sumsubtotal, 2, '.', ''),

            ),
            "totalRetention" => array(
                "noI" => number_format($sumnoI, 2, '.', ''),
                "rate0" => number_format($sumrate0, 2, '.', ''),
                "differentRate0" => number_format($sumdifferentRate0, 2, '.', ''),
                "noTax" => number_format($sumnoTax, 2, '.', ''),
                "tax" => number_format($sumtax, 2, '.', ''),
                "total" => number_format($sumtotal, 2, '.', ''),
                "subtotal" => number_format($sumsubtotal, 2, '.', ''),

            ),
        );
        return $result;
    }

//** step 3 */
    public function getManagerAllValuesInvoice($params)
    {
        $result = array();
        $keyAnnexManager = "values_invoice";
        $result[$keyAnnexManager] = $this->getManagerValuesInvoice($params);
        $keyAnnexManager = "values_retention";
        $result[$keyAnnexManager] = $this->getManagerValuesRetention($params);

        return $result;
    }

//** step 4 */

    public function getManagerValuesInvoice($params)
    {

        $invoicesData = array();

        $haystackRow = $params["haystackRow"];
        $noIValue = 0;//noi
        $rate0Value = 0;//subtotal0%iva
        $differentRate0Value = 0;//subtotal 12%iva
        $noTaxValue = 0;//subtotal
        $tax = 0;//iva
        $sumSubtotal = 0;
        $sumTax = 0;
        $sumDiscount = 0;

        foreach ($haystackRow["detailsData"] as $key => $value) {
            $cant = $value["cantidad"];
            $punit = $value["precio_unitario"];
            $porcentaje_iva = $value["porcentaje_iva"];
            $porcentaje_descuento = $value["porcentaje_descuento"];
            $subtotalCurrent = $cant * $punit;
            $discountTotalCurrent = ($subtotalCurrent * $porcentaje_descuento / 100);
            $sumDiscount += $discountTotalCurrent;
            $taxCurrent = ($subtotalCurrent - $discountTotalCurrent) * $porcentaje_iva / 100;
            $sumTax += $taxCurrent;
            $sumSubtotal += $subtotalCurrent;
            if ($porcentaje_iva == 0) {
                $rate0Value += $subtotalCurrent;

            } else {
                $differentRate0Value += $subtotalCurrent;
                $tax += $taxCurrent;
            }
        }
        $noTaxValue = $noIValue + $rate0Value + $differentRate0Value;
        $total = $sumSubtotal - $sumDiscount + $sumTax;
        $keyAnnexManager = "noI";
        $invoicesData[$keyAnnexManager] = number_format($noIValue, 2, '.', '');
        $keyAnnexManager = "rate0";//0%
        $invoicesData[$keyAnnexManager] = number_format($rate0Value, 2, '.', '');
        $keyAnnexManager = "differentRate0";//!0%=,12% current config
        $invoicesData[$keyAnnexManager] = number_format($differentRate0Value, 2, '.', '');
        $keyAnnexManager = "noTax";
        $invoicesData[$keyAnnexManager] = number_format($noTaxValue, 2, '.', '');
        $keyAnnexManager = "tax";
        $invoicesData[$keyAnnexManager] = number_format($tax, 2, '.', '');

        $keyAnnexManager = "total";
        $invoicesData[$keyAnnexManager] = number_format($total, 2, '.', '');
        $keyAnnexManager = "subtotal";
        $invoicesData[$keyAnnexManager] = number_format($sumSubtotal, 2, '.', '');
        return $invoicesData;
    }

//** step 5 */

    public function getManagerValuesRetention($params)
    {
        $invoicesData = array();
        $haystackRow = $params["haystackRow"];

        $codeTax = 0;
        $valuePercentageTax = 0;
        $valueTotalTax = 0;

        $codeRent = 0.0;
        $valuePercentageRent = 0;
        $valueTotalRent = 0;

        $valueEstablecimiento = "0";
        $valuePuntoEmision = "0";
        $valueNumRetencion = "0";
        $valueFechaFactura = "";
        $valueNumAutorizacion = "";
        foreach ($haystackRow["dataRetencion"] as $key => $value) {

            $valueFechaFactura = $value["fecha_factura"];
            $valueEstablecimiento = $value["establecimiento"];
            $valuePuntoEmision = $value["punto_emision"];
            $valueNumRetencion = $value["num_retencion"];
            $valueNumAutorizacion = $value["num_autorizacion"];

            if ($value["type"] == 0) {//tax
                $codeTax = $value["code_retention"];
                $valuePercentageTax = $value["porcentaje"];
                $valueTotalTax = $value["valor_retenido"];
            } else {//rent
                $codeRent = $value["code_retention"];
                $valuePercentageRent = $value["porcentaje"];
                $valueTotalRent = $value["valor_retenido"];
            }
        }


        $keyAnnexManager = "codeTax";
        $invoicesData[$keyAnnexManager] = $codeTax;

        $keyAnnexManager = "percentageTax";
        $invoicesData[$keyAnnexManager] = number_format($valuePercentageTax, 2, '.', '');

        $keyAnnexManager = "totalTax";
        $invoicesData[$keyAnnexManager] = number_format($valueTotalTax, 2, '.', '');


        $keyAnnexManager = "codeRent";
        $invoicesData[$keyAnnexManager] = $codeRent;

        $keyAnnexManager = "percentageRent";
        $invoicesData[$keyAnnexManager] = number_format($valuePercentageRent, 2, '.', '');

        $keyAnnexManager = "totalRent";
        $invoicesData[$keyAnnexManager] = number_format($valueTotalRent, 2, '.', '');


        $keyAnnexManager = "establecimiento";
        $invoicesData[$keyAnnexManager] = $valueEstablecimiento;

        $keyAnnexManager = "punto_emision";
        $invoicesData[$keyAnnexManager] = $valuePuntoEmision;

        $keyAnnexManager = "num_retencion";
        $invoicesData[$keyAnnexManager] = $valueNumRetencion;

        $keyAnnexManager = "fecha_factura";
        $invoicesData[$keyAnnexManager] = $valueFechaFactura;

        $keyAnnexManager = "num_autorizacion";
        $invoicesData[$keyAnnexManager] = $valueNumAutorizacion;

        return $invoicesData;
    }

    public function getATS($params)
    {

        $managerAnnex = $this->getStructureTransactionalAnnex($params);

        $filtersData = $params["filters"];

        $objetoXML = new XMLWriter();

        // Estructura básica del XML
        $objetoXML->openURI("php://output");
        $managerBusiness = $managerAnnex["managerBusiness"];

        $managerSales = $managerAnnex["sales"];
        $managerBuys = $managerAnnex["buys"];
        $objetoXML->setIndent(true);
        $objetoXML->setIndentString("\t");
        $objetoXML->startDocument('1.0', 'utf-8');
        // Inicio del nodo raíz
        $objetoXML->startElement("iva");

        $objetoXML->startElement("TipoIDInformante");
        $objetoXML->text($managerBusiness["legalRepresentative"]["TipoIDInformante"]);
        $objetoXML->endElement();
        $objetoXML->startElement("IdInformante");
        $objetoXML->text($managerBusiness["legalRepresentative"]["IdInformante"]);
        $objetoXML->endElement();
        $objetoXML->startElement("razonSocial");
        $objetoXML->text($managerBusiness["legalRepresentative"]["razonSocial"]);
        $objetoXML->endElement();
        $objetoXML->startElement("Anio");
        $objetoXML->text($filtersData["year"]);
        $objetoXML->endElement();
        $objetoXML->startElement("Mes");
        $objetoXML->text($filtersData["month"]);
        $objetoXML->endElement();
        $objetoXML->startElement("numEstabRuc");
        $objetoXML->text("001");
        $objetoXML->endElement();
        $objetoXML->startElement("totalVentas");
        $totalSales = $managerSales["totalInvoice"]["differentRate0"] + $managerSales["totalInvoice"]["noI"] + $managerSales["totalInvoice"]["rate0"];
        $totalSales = number_format($totalSales, 2, '.', '');
        $objetoXML->text($totalSales);
        $objetoXML->endElement();
        $objetoXML->startElement("codigoOperativo");
        $objetoXML->text("IVA");
        $objetoXML->endElement();
        $buysData = $managerBuys["data"];
        if (count($buysData)) {
            $objetoXML->startElement("compras");

            foreach ($buysData as $keyBuy => $buy) {
                $objetoXML->startElement("detalleCompras");
                $valueSet = $buy["tax_support_code"];
                $objetoXML->startElement("codSustento");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["TipoIDInformante"];
                $objetoXML->startElement("tpIdProv");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["ruc_emitter"];//RUC,CE,PASSPORT
                $objetoXML->startElement("idProv");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["voucher_type_code"];
                $objetoXML->startElement("tipoComprobante");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = "NO";
                $objetoXML->startElement("parteRel");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["fechaRegistro"];
                $objetoXML->startElement("fechaRegistro");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["establecimiento"];
                $objetoXML->startElement("establecimiento");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["punto_emision"];
                $objetoXML->startElement("puntoEmision");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["codigo_factura"];
                $objetoXML->startElement("secuencial");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["fechaEmision"];
                $objetoXML->startElement("fechaEmision");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["no_autorizacion"];
                $objetoXML->startElement("autorizacion");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = 0.00;
                $objetoXML->startElement("baseNoGraIva");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));

                $objetoXML->endElement();

                $valueSet = $buy["manager_values_all"]["values_invoice"]["rate0"];
                $objetoXML->startElement("baseImponible");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $buy["manager_values_all"]["values_invoice"]["differentRate0"];
                $objetoXML->startElement("baseImpGrav");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));

                $objetoXML->endElement();

                $valueSet = 0.00;
                $objetoXML->startElement("baseImpExe");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));
                $objetoXML->endElement();

                $valueSet = 0.00;
                $objetoXML->startElement("montoIce");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));
                $objetoXML->endElement();

                $valueSet = $buy["manager_values_all"]["values_invoice"]["tax"];
                $objetoXML->startElement("montoIva");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));
                $objetoXML->endElement();
                /*----RETENTION*-------*/
                $dataRetentionCurrent = $this->structureRetentionBuyTax($buy["manager_values_all"]["values_retention"]);
                foreach ($dataRetentionCurrent as $keyRetention => $retention) {
                    $valueSet = $retention["value"];
                    $objetoXML->startElement($retention["nameTag"]);//ok
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();
                }
                $valueSet = 0.00;
                $objetoXML->startElement("totbasesImpReemb");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));

                $objetoXML->endElement();

                /* pagoExterior*/
                $objetoXML->startElement("pagoExterior");

                $valueSet = "01";
                $objetoXML->startElement("pagoLocExt");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();
                $valueSet = "NA";
                $objetoXML->startElement("paisEfecPago");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();
                $valueSet = "NA";
                $objetoXML->startElement("aplicConvDobTrib");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();
                $valueSet = "NA";
                $objetoXML->startElement("pagExtSujRetNorLeg");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $objetoXML->endElement();
                if ($buy["has_retencion"] == "1") {


                    $objetoXML->startElement("air");//air
                    $objetoXML->startElement("detalleAir");

                    $valueSet = $buy["manager_values_all"]["values_retention"]["codeRent"];
                    $objetoXML->startElement("codRetAir");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = number_format($buy["manager_values_all"]["values_retention"]["totalRent"] * 100, 2, '.', '');
                    $objetoXML->startElement("baseImpAir");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = $buy["manager_values_all"]["values_retention"]["percentageRent"];
                    $objetoXML->startElement("porcentajeAir");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = $buy["manager_values_all"]["values_retention"]["totalRent"];
                    $objetoXML->startElement("valRetAir");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $objetoXML->endElement();//details
                    $objetoXML->endElement();//air

                    $valueSet = $buy["manager_values_all"]["values_retention"]["establecimiento"];
                    $objetoXML->startElement("estabRetencion1");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = $buy["manager_values_all"]["values_retention"]["punto_emision"];
                    $objetoXML->startElement("ptoEmiRetencion1");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();


                    $valueSet = $buy["manager_values_all"]["values_retention"]["num_retencion"];
                    $objetoXML->startElement("secRetencion1");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = $buy["manager_values_all"]["values_retention"]["num_autorizacion"];
                    $objetoXML->startElement("autRetencion1");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();

                    $valueSet = $buy["manager_values_all"]["values_retention"]["fecha_factura"];
                    $objetoXML->startElement("fechaEmiRet1");
                    $objetoXML->text($valueSet);
                    $objetoXML->endElement();
                }
                $objetoXML->endElement();

            }
            $objetoXML->endElement();
        }


        $salesDataCustomers = $managerSales["customers"];
        if (count($salesDataCustomers)) {
            $objetoXML->startElement("ventas");

            foreach ($salesDataCustomers as $keyBuy => $saleCustomer) {
                $objetoXML->startElement("detalleVentas");

                $valueSet = $saleCustomer["TipoIDInformante"];
                $objetoXML->startElement("tpIdCliente");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $saleCustomer["ruc_emitter"];
                $objetoXML->startElement("idCliente");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = "NO";//-----
                $objetoXML->startElement("parteRelVtas");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $saleCustomer["voucher_type_code"];
                $objetoXML->startElement("tipoComprobante");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $this->getCodeTipoEmision(array("voucherTypeCode" => $saleCustomer["voucher_type_code"]));
                $objetoXML->startElement("tipoEmision");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $resultValues = $this->getValuesDetailsAnnexSales($saleCustomer);
                $valueSet = $resultValues["numberVoucherType"];
                $objetoXML->startElement("numeroComprobantes");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = 0.00;
                $objetoXML->startElement("baseNoGraIva");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));

                $objetoXML->endElement();

                $valueSet = $resultValues["rate0"];
                $objetoXML->startElement("baseImponible");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));
                $objetoXML->endElement();


                $valueSet = $resultValues["differentRate0"];
                $objetoXML->startElement("baseImpGrav");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));
                $objetoXML->endElement();


                $valueSet = $resultValues["tax"];

                $objetoXML->startElement("montoIva");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();


                $valueSet = $resultValues["montoIce"];
                $objetoXML->startElement("montoIce");
                $objetoXML->text(number_format($valueSet, 2, '.', ''));

                $objetoXML->endElement();


                $valueSet = $resultValues["valorRetIva"];
                $objetoXML->startElement("valorRetIva");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $valueSet = $resultValues["valorRetRenta"];
                $objetoXML->startElement("valorRetRenta");
                $objetoXML->text($valueSet);
                $objetoXML->endElement();

                $objetoXML->endElement();

            }

            $objetoXML->endElement();

            $objetoXML->startElement("ventasEstablecimiento");

            $objetoXML->startElement("ventaEst");

            $valueSet = "001";
            $objetoXML->startElement("codEstab");
            $objetoXML->text($valueSet);
            $objetoXML->endElement();

            $valueSet = $totalSales;
            $objetoXML->startElement("ventasEstab");
            $objetoXML->text($valueSet);
            $objetoXML->endElement();

            $valueSet = 0;
            $objetoXML->startElement("ivaComp");
            $objetoXML->text(number_format($valueSet, 2, '.', ''));
            $objetoXML->endElement();

            $objetoXML->endElement();

            $objetoXML->endElement();
        }

        $objetoXML->endElement();//tax
        $objetoXML->endDocument(); // Final del documento

        return ($objetoXML);

    }

    public function structureRetentionBuyTax($params)
    {

        /*codeRent: "312"
codeTax: "725"
percentageRent: "1"
percentageTax: "30"
totalRent: "0.8150"
totalTax: "1.3680"*/
        $percentageCurrent = $params["percentageTax"];
        $valueCurrent = $params["totalTax"];
        $result = array(
            array(
                "percentage" => "10",
                "value" => 0,
                "nameTag" => "valRetBien10"
            ), array(
                "percentage" => "20",
                "value" => 0,
                "nameTag" => "valRetServ20"
            ),
            array(
                "percentage" => "30",
                "value" => 0,
                "nameTag" => "valorRetBienes"
            ),
            array(
                "percentage" => "50",
                "value" => 0,
                "nameTag" => "valRetServ50"
            ),
            array(
                "percentage" => "70",
                "value" => 0,
                "nameTag" => "valorRetServicios"
            ),
            array(
                "percentage" => "100",
                "value" => 0,
                "nameTag" => "valRetServ100"
            ),
        );

        foreach ($result as $key => $retention) {
            if ($retention["percentage"] == $percentageCurrent) {

                $result[$key]["value"] = number_format($valueCurrent, 2, '.', '');

            } else {
                $result[$key]["value"] = number_format($result[$key]["value"], 2, '.', '');
            }
        }
        return $result;
    }

    public function getDataGroupByCustomer($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        $auxResult = array();
        foreach ($haystack as $key => $rowInvoice) {

            $cliente_id = $rowInvoice["cliente_id"];
            if (!in_array($cliente_id, $auxResult)) {
                array_push($auxResult, $cliente_id);
                $keySearch = "cliente_id";
                $valueComparate = $cliente_id;
                $dataSearch = Util:: searchDataByParams(array("keySearch" => $keySearch, "haystack" => $haystack, "valueComparate" => $valueComparate));
                $groupByTaxSupport = $this->getDataGroupByTaxSupport(array("haystack" => $dataSearch));
                $setPush = array("dataInvoices" => $dataSearch, "groupByTaxSupport" => $groupByTaxSupport);
                $setPush = array_merge($setPush, $rowInvoice);
                array_push($result, $setPush);

            }
        }
        return $result;

    }


    public function getDataGroupByTaxSupport($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        $auxTaxSupportCode = array();
        foreach ($haystack as $key => $rowInvoice) {
            $id = $rowInvoice["id"];
            $tax_support_code = $rowInvoice["tax_support_code"];
            $tax_support = $rowInvoice["tax_support"];
            if (!in_array($tax_support_code, $auxTaxSupportCode)) {
                array_push($auxTaxSupportCode, $tax_support_code);
                $keySearch = "tax_support_code";
                $valueComparate = $tax_support_code;
                $dataTaxSupport = Util:: searchDataByParams(array("keySearch" => $keySearch, "haystack" => $haystack, "valueComparate" => $valueComparate));
                $setPush = array("id" => $id, "name" => $tax_support, "data" => $dataTaxSupport);
                array_push($result, $setPush);

            }
        }

        return $result;

    }

    public function getValuesDetailsAnnexSales($params)
    {

        $groupByTaxSupport = $params["groupByTaxSupport"];

        $numberVoucherType = 0;

        $noISum = 0;//noi
        $rate0Sum = 0;//subtotal0%iva
        $differentRate0Sum = 0;//subtotal 12%iva
        $noTaxSum = 0;//subtotal
        $taxSum = 0;//iva
        $subtotalSum = 0;
        $totalTaxRetention = 0;
        $totalRentRetention = 0;
        $montoIce = 0;
        foreach ($groupByTaxSupport as $key => $voucher) {

            $invoices = $voucher["data"];
            foreach ($invoices as $keyInvoice => $invoice) {
                $numberVoucherType++;
                $differentRate0Sum += $invoice["manager_values_all"]["values_invoice"]["differentRate0"];
                $noISum += $invoice["manager_values_all"]["values_invoice"]["noI"];
                $noTaxSum += $invoice["manager_values_all"]["values_invoice"]["noTax"];
                $rate0Sum += $invoice["manager_values_all"]["values_invoice"]["rate0"];
                $subtotalSum += $invoice["manager_values_all"]["values_invoice"]["subtotal"];
                $taxSum += $invoice["manager_values_all"]["values_invoice"]["tax"];
                if ($invoice["has_retencion"] == "1") {

                    $totalTaxRetention += $invoice["manager_values_all"]["values_retention"]["totalRent"];
                    $totalRentRetention += $invoice["manager_values_all"]["values_retention"]["totalTax"];

                }
            }

        }

        $result = array(
            "numberVoucherType" => $numberVoucherType,
            "noI" => number_format($noISum, 2, '.', ''),
            "rate0" => number_format($rate0Sum, 2, '.', ''),
            "differentRate0" => number_format($differentRate0Sum, 2, '.', ''),
            "tax" => number_format($taxSum, 2, '.', ''),
            "montoIce" => number_format($montoIce, 2, '.', ''),
            "valorRetIva" => number_format($totalTaxRetention, 2, '.', ''),
            "valorRetRenta" => number_format($totalRentRetention, 2, '.', '')
        );
        return $result;
    }

}
