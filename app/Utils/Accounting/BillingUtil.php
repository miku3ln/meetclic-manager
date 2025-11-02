<?php

namespace App\Utils\Accounting;

use Illuminate\Support\Facades\DB;
use Auth;

class BillingUtil
{
    const tblInvoiceBuy = "invoice_buy";
    const tblDetailsInvoiceBuy = "invoice_buy_by_details";
    const keyInvoiceBuyByDetails = "invoice_buy_id";
    const tblRetentionsBuy = "invoice_buy_by_retention";
    const keyRetentionsByBuy = "invoice_buy_id";
    const tblTransactionBuy = "invoice_buy_by_transactions";
    const keyTransactionByBuy = "invoice_buy_id";
    const tblATSByBuy = "invoice_buy_by_transactional_annex";
    const keyATSByBuy = "invoice_buy_id";

    const tblInvoiceSale = "invoice_sale";
    const tblDetailsInvoiceSale = "invoice_sale_by_details";
    const keyInvoiceSaleByDetails = "invoice_sale_id";
    const tblRetentionsSale = "invoice_sale_by_retention";
    const keyRetentionsBySale = "invoice_sale_id";
    const tblTransactionSale = "invoice_sale_by_transactions";
    const keyTransactionBySale = "invoice_sale_id";

    const tblATSBySale = "invoice_sale_by_transactional_annex";
    const keyATSBySale = "invoice_sale_id";


    const tblBySeatBookInvoiceSale = "invoice_sale_by_book_seat";
    const keyBySeatBookInvoiceSale = "invoice_sale_id";

    const tblBySeatBookInvoiceBuy = "invoice_buy_by_book_seat";
    const keyBySeatBookInvoiceBuy = "invoice_buy_id";

    const ENTITY_TYPE_MANAGEMENT_BUYS = 0;
    const ENTITY_TYPE_MANAGEMENT_SALES = 1;
    const ENTITY_TYPE_MANAGEMENT_RETURN_ON_PURCHASES = 2;
    const ENTITY_TYPE_MANAGEMENT_RETURN_ON_SALES = 3;
    const ENTITY_TYPE_MANAGEMENT_WALLETS = 4;

    public function getViewBillingCurrent($params)
    {

        $invoiceId = $params["invoiceId"];
        $hasRetention = $params["hasRetention"];

        $detailsData = $this->getDetailsBilling($params);

        $retentionsData = array();
        $transactionsData = $this->getTransactionsBilling($params);

        if ($hasRetention == "1") {
            $retentionsData = $this->getRetentionsBilling($params);
        }

        $customer = $this->getCustomerBilling($params);
        $atsData = $this->getATSDataBilling($params);
        $result = array(
            "manager" => array(
                "customer" => $customer,
                "detailsData" => $detailsData,
                "retentionsData" => $retentionsData,
                "transactionsData" => $transactionsData,
                "atsData" => $atsData
            )
        );

        return $result;
    }

    public function getDetailsBilling($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];

        $tableCurrent = self::tblDetailsInvoiceBuy;
        $relationCurrent = self::keyInvoiceBuyByDetails;
        $relationOne = 'product';
        $relationTwo = 'product_trademark';
        $relationThree = 'product_category';
        $relationFour = 'product_subcategory';
        if ($type == "sale") {

            $tableCurrent = self::tblDetailsInvoiceSale . "";
            $relationCurrent = self::keyInvoiceSaleByDetails;
        }
        $select = "$tableCurrent.id,$tableCurrent.product_id producto_id,$tableCurrent.quantity cantidad,$tableCurrent.quantity_unit cantidad_unidades,$tableCurrent.discount_percentage porcentaje_descuento,$tableCurrent.discount_percentage_unit porcentaje_descuento_unidad,$tableCurrent.discount_value valor_descuento,$tableCurrent.discount_value_unit valor_descuento_unidad,$tableCurrent.discount_value valor_descuento,$tableCurrent.discount_value_unit valor_descuento_unidad,$tableCurrent.unit_price precio_unitario,$tableCurrent.unit_price_unit precio_unitario_unidad,$tableCurrent.management_type tipo_gestion,$tableCurrent.tax_percentage porcentaje_iva,$tableCurrent.subtotal,$tableCurrent.total,$tableCurrent.description,$tableCurrent.product_type type_product
        ,$relationOne.code pr_codigo,$relationOne.name pr_nombre,$relationOne.product_trademark_id producto_marca_id,$relationOne.product_category_id producto_categoria_id,$relationOne.product_subcategory_id producto_subcategoria_id,$relationOne.product_measure_type_id producto_tipo_medida_id,$relationOne.description pr_descripcion,$relationOne.has_tax pr_has_iva,$relationOne.is_service pr_is_service
        ,$relationTwo.value pm_nombre
        ,$relationThree.value pc_nombre
        ";
        $selectString = $select;
        $field = $tableCurrent . '.id';
        $sort = 'ASC';
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.product_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $relationOne . '.product_trademark_id', '=', $relationTwo . '.id');
        $query->join($relationThree, $relationOne . '.product_category_id', '=', $relationThree . '.id');
        $query->join($relationFour, $relationOne . '.product_subcategory_id', '=', $relationFour . '.id');
        $query->where($tableCurrent . '.' . $relationCurrent, '=', $invoiceId);
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }

    public function getATSDataBilling($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];

        $tableCurrent = self::tblATSByBuy . "";
        $relationCurrent = self::keyATSByBuy;
        $relationOne = 'management_livelihood_by_voucher';
        $relationTwo = 'tax_support';
        $relationThree = 'voucher_type';
        $relationFour = 'people_type_identification';
        $type_manager = 0;
        if ($type == "sale") {
            $type_manager = 1;

            $tableCurrent = self::tblATSBySale . "";
            $relationCurrent = self::keyATSBySale;
        }
        $select = "$tableCurrent.management_livelihood_by_voucher_id gestion_sustento_has_comprobante_id,$tableCurrent.id,$tableCurrent.$relationCurrent
,$relationOne.tax_support_id sustento_tributario_id,$relationOne.voucher_type_id tipo_comprobante_id,$relationOne.people_type_identification_id tipo_identificacion_id,$relationOne.type_management type_manager
,$relationTwo.value sustento_tributario
,$relationFour.name tipo_identificacion
,$relationThree.value tipo_comprobante";

        $selectString = $select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.management_livelihood_by_voucher_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $relationOne . '.tax_support_id', '=', $relationTwo . '.id');
        $query->join($relationThree, $relationOne . '.voucher_type_id', '=', $relationThree . '.id');
        $query->join($relationFour, $relationOne . '.people_type_identification_id', '=', $relationFour . '.id');
        $query->where($tableCurrent . '.' . $relationCurrent, '=', $invoiceId);
        $query->where($relationOne . '.type_management', '=', $type_manager);
        $result = $query->first();
        $result = (array)$result;
        return count($result) ? $result : array();
    }

    public function getRetentionsBilling($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];

        $tableCurrent = self::tblRetentionsBuy . "";
        $relationCurrent = self::keyRetentionsByBuy;
        $relationOne = 'retention_tax_sub_type';
        $relationTwo = 'retention_tax_type';
        $relationThree = 'accounting_account';
        $select = "$tableCurrent.id,$tableCurrent.retention_tax_sub_type_id sub_tipo_retencion_impuesto_id,$tableCurrent.created_at fecha_creacion,$tableCurrent.retained_value valor_retenido,$tableCurrent.establishment establecimiento,$tableCurrent.emission_point punto_emision,$tableCurrent.number_authorization num_autorizacion,$tableCurrent.number_retention num_retencion,$tableCurrent.invoice_date fecha_factura
        ,$relationThree.id cc_id ,$relationThree.value cc_value,$relationThree.status cc_estado,$relationThree.description cc_descripcion,$relationThree.parent_key cc_parent_key,$relationThree.has_parent cc_has_parent,$relationThree.is_parent cc_is_parent,$relationThree.movement cc_movimiento,$relationThree.rfc cc_rfc,$relationThree.cost_center cc_centro_costo,$relationThree.base_amount cc_monto_base
       ,$relationOne.value stri_value,$relationOne.retention_tax_type_id tipo_retencion_impuesto_id,$relationOne.description stri_descripcion,$relationOne.percentage stri_porcentaje
       ,$relationTwo.value tri_value,$relationTwo.type tri_type";
        if ($type == "sale") {

            $tableCurrent = self::tblRetentionsSale . "";
            $relationCurrent = self::keyRetentionsBySale;
        }
        $selectString = $select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.retention_tax_sub_type_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $relationOne . '.retention_tax_type_id', '=', $relationTwo . '.id');
        $query->join($relationThree, $relationOne . '.accounting_account_id', '=', $relationThree . '.id');
        $query->where($tableCurrent . '.' . $relationCurrent, '=', $invoiceId);
        $result = $query->get()->toArray();

        return $result;
    }

    public function getTransactionsBilling($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];
//als
        $tableCurrent = self::tblTransactionBuy;
        $relationCurrent = self::keyTransactionByBuy;
        $relationOne = 'accounting_account';
        $relationTwo = 'types_payments';

        if ($type == "sale") {
            $tableCurrent = self::tblTransactionSale;
            $relationCurrent = self::keyTransactionBySale;

        }

        $select = "$tableCurrent.percentage_discount porcentaje_descuento,$tableCurrent.value_discount valor_descuento,$tableCurrent.subtotal,$tableCurrent.total,$tableCurrent.accounting_account_id contabilidad_cuenta_id,$tableCurrent.type_payment_id
        ,$relationOne.id cc_id,$relationOne.value cc_value,$relationOne.status cc_estado,$relationOne.description cc_descripcion,$relationOne.parent_key cc_parent_key,$relationOne.has_parent cc_has_parent,$relationOne.is_parent cc_is_parent,$relationOne.movement cc_movimiento,$relationOne.rfc cc_rfc,$relationOne.cost_center cc_centro_costo,$relationOne.base_amount cc_monto_base
     ,$relationTwo.description tp_descripcion,$relationTwo.code tp_code";
        $selectString = $select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.accounting_account_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $tableCurrent . '.type_payment_id', '=', $relationTwo . '.id');
        $query->where($tableCurrent . '.' . $relationCurrent, '=', $invoiceId);
        $result = $query->get()->toArray();
        return $result;
    }

    public function getCustomerBilling($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];
        $customer_id = $params["customer_id"];

        $relationOne = 'people';
        $relationTwo = 'people_type_identification';
        $relationThree = 'ruc_type';

        $tableCurrent = "proveedor";
        $relationCurrent = "id";
        $entidad = 8;
        $principal = 1;
        $direccion_tipo_id = 2;//trabajo

        $select = "$tableCurrent.id,$tableCurrent.identification_document identificacion,$tableCurrent.people_id persona_id,$tableCurrent.people_type_identification_id tipo_identificacion_id,$tableCurrent.proveedor_tipo,$tableCurrent.business_reason razon_social,$tableCurrent.business_name razon_comercial,$tableCurrent.ruc_type_id type_ruc_id
,$relationOne.name p_nombres,$relationOne.last_name p_apellidos
,$relationTwo.name ti_value,$relationTwo.code ti_code
,$relationThree.name tr_value";
        if ($type == "sale") {
            $direccion_tipo_id = 1;//trabajo
            $entidad = 0;
            $tableCurrent = "customer";
            $relationCurrent = "id";
            $select = "$tableCurrent.id,$tableCurrent.identification_document identificacion,$tableCurrent.people_id persona_id,$tableCurrent.people_type_identification_id tipo_identificacion_id,$tableCurrent.business_reason razon_social,$tableCurrent.business_name razon_comercial,$tableCurrent.ruc_type_id type_ruc_id
,$relationOne.name p_nombres,$relationOne.last_name p_apellidos
,$relationTwo.name ti_value,$relationTwo.code ti_code
,$relationThree.name tr_value";
        }


        $selectString = $select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.people_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $tableCurrent . '.people_type_identification_id', '=', $relationTwo . '.id');
        $query->join($relationThree, $tableCurrent . '.ruc_type_id', '=', $relationTwo . '.id');
        $query->where($tableCurrent . '.' . $relationCurrent, '=', $customer_id);
        $resultInformation = $query->first();


        $address = "Sin Gestionar.";
        $modelAddress = new \App\Models\InformationAddress();
        $modelAddress = $modelAddress->findByAttributes(array(
            "entity_type" => $entidad,
            "entity_id" => $customer_id,
            "main" => $principal,
            "information_address_type_id" => $direccion_tipo_id
        ));

        if ($modelAddress) {
            $address = $modelAddress->street_one . " y " . $modelAddress->street_two . ".";

        }
        $email = "Sin Gestionar.";
        $modelEmail = new \App\Models\InformationMail;
        $modelEmail = $modelEmail->findByAttributes(array(
            "entity_type" => $entidad,
            "entity_id" => $customer_id,
            "main" => $principal,
        ));
        if ($modelEmail) {
            $email = $modelEmail->value;

        }
        $phone = "Sin Gestionar.";
        $modelPhone = new \App\Models\InformationPhone;
        $modelPhone = $modelPhone->findByAttributes(array(
            "entity_type" => $entidad,
            "entity_id" => $customer_id,
            "main" => $principal,
        ));
        if ($modelPhone) {
            $phone = $modelPhone->value;

        }
        $result = array(
            "information" => $resultInformation ? $resultInformation : array(),
            "address" => $address,
            "email" => $email,
            "phone" => $phone


        );
        return $result;
    }

    /*----SEAT INVOICE----*/
    public function getSeatBookManager($params)
    {
        $detailsData = $this->getDetailsBilling($params);

        $haystackSeats = $this->getSeatBookData($params);

        $seatDataInvoice = $this->getGroupSeatData($haystackSeats);

        $seatsDataInvoiceSave = $this->getStructureSeatsSave(array(
            "haystack" => $seatDataInvoice,
            "entidad_data_id" => $params["entidad_data_id"],
            "type" => $params["type"],
            "invoiceId" => $params["invoiceId"],
            "dateAnnulment" => $params["dateAnnulment"]
        ));

        $result = array(
            "detailsInvoice" => $detailsData,
            "seatsDataInvoiceSave" => $seatsDataInvoiceSave

        );
        return $result;
    }

    public function getSeatBookData($params)
    {
        $invoiceId = $params["invoiceId"];
        $type = $params["type"];
        $typeManager = $params["typeManager"];
        $relationOne = 'daily_book_seat';
        $relationTwo = 'business_by_daily_book_seat';
        $relationThree = 'diary_book';
        $relationFour = 'accounting_account';

        $tableCurrent = self::tblBySeatBookInvoiceBuy;
        $relationCurrent = self::keyBySeatBookInvoiceBuy;

        if ($type == "sale") {

            $tableCurrent = self::tblBySeatBookInvoiceSale;
            $relationCurrent = self::keyBySeatBookInvoiceSale;
        }
        $select = $tableCurrent . ".manager_type type_gestion,$tableCurrent.id
,$relationOne.value al_value,$relationOne.id al_id
,$relationThree.accounting_account_id ld_contabilidad_cuenta_id,$relationThree.manager_type ld_type_ingreso,$relationThree.value ld_valor
,$relationFour.value cc_value,$relationFour.description cc_descripcion";
        $selectString = $select;
        $query = DB::table($tableCurrent);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $tableCurrent . '.daily_book_seat_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $relationOne . '.id', '=', $relationTwo . '.daily_book_seat_id');
        $query->join($relationThree, $relationTwo . '.diary_book_id', '=', $relationThree . '.id');
        $query->join($relationFour, $relationThree . '.accounting_account_id', '=', $relationFour . '.id');

        $query->where($tableCurrent . '.' . $relationCurrent, '=', $invoiceId);
        $query->where($tableCurrent . '.' . 'manager_type', '=', $typeManager);
        $result = $query->get()->toArray();

        return $result;
    }

    public function getGroupSeatData($haystack)
    {

        $result = array();
        $utilManager = new \App\Utils\Util();

        $seats = array();
        foreach ($haystack as $key => $valueCurrent) {
            $value = (array)$valueCurrent;
            $seatId = $value["al_id"];
            $al_value = $value["al_value"];


            if (!in_array($seatId, $seats)) {

                array_push($seats, $seatId);
                $dataSeatsBook = $utilManager::searchDataByParams(array(
                    "keySearch" => "al_id",
                    "valueComparate" => $seatId,
                    "haystack" => $haystack
                ));
                array_push($result, array("data" => $dataSeatsBook, "seatId" => $seatId, "al_value" => $al_value));
            }

        }

        return $result;
    }

    public function getStructureSeatsSave($params)
    {
        $utilManager = new \App\Utils\Util();
        $haystack = $params["haystack"];
        $entidad_data_id = $params["entidad_data_id"];
        $type = $params["type"];
        $invoiceId = $params["invoiceId"];
        $dateCurrent = isset($params["dateAnnulment"]) ? $params["dateAnnulment"] : $utilManager::DateCurrent();
        $seatDataInvoice = $haystack;
        $seatsManager = array();
        $user = Auth::user();
        $owner_id = $user->id; //USUARIO QIEN GESTIONA

        foreach ($seatDataInvoice as $key => $row) {
            $al_value = $row["al_value"];
            $dataPush = array();
            foreach ($row["data"] as $keySeat => $rowSeatCurrent) {
                $rowSeat = (array)$rowSeatCurrent;
                $contabilidad_cuenta_id = $rowSeat["ld_contabilidad_cuenta_id"];
                $valor = $rowSeat["ld_valor"];
                $type_ingreso = $rowSeat["ld_type_ingreso"] == "0" ? 1 : 0;
                $setPushBook = array();
                $setPushBook["value"] = $valor;
                $setPushBook["accounting_account_id"] = $contabilidad_cuenta_id;
                $setPushBook["manager_type"] = $type_ingreso;
                $setPush = array(
                    "attributes" => $setPushBook,
                    "relation" => array(
                        "entidad_data_id" => $entidad_data_id,
                        "entidad" => $type == "buy" ? "invoice_buy" : "invoice_sale",
                        "entidad_id" => $invoiceId,
                        "owner_id" => $owner_id
                    )
                );
                array_push($dataPush, $setPush);

            }
            $value = $al_value . " Anulación";
            $attributes = array(
                "value" => $value,
                "description" => "Anulacion de una factura.",
                "created_at" => $dateCurrent,
                "register_manager_date" => $dateCurrent,
                "status" => "ACTIVE",
                "entidad_data_id" => $entidad_data_id
            );
            $setPush = array(
                "attributes" => $attributes,
                "data" => $dataPush
            );
            array_push($seatsManager, $setPush);
        }

        return $seatsManager;
    }
}
