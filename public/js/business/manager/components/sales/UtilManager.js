function managerLoading(params) {
    if ($("#manager-container").hasClass("not-view")) {
        $("#manager-container").removeClass("not-view");
        $(".manager-loading").addClass("not-view");
    }
}
function formatDate(params) {

    var date = params.date;
    var format = params.format;

    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    var formatDateResult;
    if (format == "Y-M-D") {
        formatDateResult = year + "-" + (1 + monthIndex) + "-" + day;
    } else if (format == "M-D-Y") {
        formatDateResult = monthIndex + "-" + day + "-" + year;

    } else if (format == "Y/M/D") {
        formatDateResult = year + "/" + (1 + monthIndex) + "/" + day;
    } else if (format == "M/D/Y") {
        formatDateResult = (1 + monthIndex) + "/" + day + "/" + year;

    }
    else if (format == "D/M/Y") {
        formatDateResult = day + "/" + (1 + monthIndex) + "/" + year;

    } else if (format == "D-M-Y") {
        formatDateResult = day + "-" + (1 + monthIndex) + "-" + year;

    }
    return formatDateResult;
}
function getCodeTypeIdentification(params) {
    var processName = params["processName"];
    var typeIdentificationId = params["typeIdentificationId"];

    var haystack = $processNameIdentificationData[processName];

    var needle = {};
    $.each(haystack, function (key, value) {
        if (key == typeIdentificationId) {
            needle = value;
        }
    });
    var result = {
        needle: needle
    }
    return result;
}
function UtilAdmin($scope) {
    $scope.regularPhraseNumberInvoice = /^(?:\D*\d){3}\D*$/;//number of tres digitos
    $scope.regularDigits = /^([0-9])*$/;
    $scope.validateNumberInvoiceType = function ($params) {
        var valueCurrent = $params["value"];
        var typeCurrent = $params["type"];
        var isValid = false;
        var regularPhrase = $scope.regularPhraseNumberInvoice;// 3 digitos y diferente de 000
        if (regularPhrase.test(valueCurrent)) {
            if (parseInt(valueCurrent) == 0) {
                isValid = false;
            } else {
                isValid = true;

            }
        } else {
            isValid = false;

        }
        return isValid;
    }
    $scope.validateDigits = function ($params) {
        var valueCurrent = $params["value"];
        var typeCurrent = $params["type"];
        var isValid = false;
        var regularPhrase = $scope.regularDigits;// 3 digitos y diferente de 000
        if (regularPhrase.test(valueCurrent)) {
            if (parseInt(valueCurrent) == 0) {
                isValid = false;
            } else {
                isValid = true;

            }
        } else {
            isValid = false;

        }
        return isValid;
    }
    $scope.viewDataFixed = function (value) {

        var result = $scope.getValueCustomer(value);
        return result;
    }
    $scope.getDateStringCurrentByFormat = function (params) {
        var format = params["format"];
        var dateArray = $dataDateCurrent.format.split("-");
        var result = "";
        var year = dateArray[0];
        var month = dateArray[1];
        var dayHoursArray = dateArray[2].split(" ");
        var day = dayHoursArray[0];
        var hours = dayHoursArray[0];

        if (format == "Y-M-D") {
            result = year + "-" + month + "-" + day;
        } else if (format == "M-D-Y") {
            result = month + "-" + day + "-" + year;

        } else if (format == "Y/M/D") {
            result = year + "/" + month + "/" + day;
        } else if (format == "M/D/Y") {
            result = month + "/" + day + "/" + year;

        }

        return result;

    }
    $scope.getValueCustomer = function (value) {

        var result = 0;
        if (value) {
            result = Math.round10(value, -2);
        }
        return result;
    }
    $scope.getValueCustomerUpDown = function (value, upDown, type = "decimal") {

        var result = 0;
        if (type == "floor") {

            if (value) {
                result = Math.floor10(value, upDown);
            }
        } else {
            if (value) {
                result = Math.round10(value, upDown);
            }
        }
        return result;
    }
    $scope.getResultFormatValue = function (value) {
        var result = 0;
        if (value) {
            result = Math.round10((value), -2);
        }
        return result;
    };
    $scope.searchDataByParams = function (params) {//aguja en un pajar
        var haystack = params.haystack;
        var needle = params.needle;
        var keySearch = params.keySearch;
        var result = [];
        angular.forEach(haystack, function (value) {
            if (needle == value[keySearch]) {
                result.push(value);
            }

        });
        return result;
    };
    $scope.sortByParams = function (params) {
        var orderByKey = params["orderByKey"];
        var haystack = params["haystack"];

        var sortData = haystack.sort(function (a, b) {
            if (a[orderByKey] > b[orderByKey]) {
                return 1;
            }
            if (a[orderByKey] < b[orderByKey]) {
                return -1;
            }
            // a must be equal to b
            return 0;
        });

        return sortData;
    };
    $scope.getStateInitialSituationDate = function () {
        var dateInit = "";
        if (Object.keys($dateManagerESI).length) {

            $dateCurrentState = $dateManagerESI["format"].split("-");
            dateInit = toDate($dateCurrentState[2] + "-" + $dateCurrentState[1] + "-" + $dateCurrentState[0], "-");
        } else {

            $dateCurrentState = $dataDateCurrent["format"].split("-");
            var stringDate = $dateCurrentState[2] + "-" + $dateCurrentState[1] + "-" + $dateCurrentState[0];
            dateInit = toDate(stringDate, "-");
        }

        return dateInit;
    }
}



/*
MODALS*/
var scopeModal;

function InitModalsAccountants($scope, $uibModal) {

    $scope.openManagerModalAccountant = function (params) {
        var typeManager = params.typeManager;
        var templateUrl = params.modalConfig.templateUrl;
        var sizeModal = (params.modalConfig) ? params.modalConfig["size"] : "lg";
        var modalInstance =
            $uibModal
                .open({
                        windowClass: 'my-modal',
                        size: sizeModal,
                        animation: true,
                        resolve: {
                            paramsCurrent: function () {
                                return params;
                            }
                        },
                        templateUrl: templateUrl,
                        controller: function ($scope, $uibModalInstance) {

                            if (typeManager == "Indebtedness") {
                                IndebtednessUtil($scope, $uibModalInstance, params)
                            } else if (typeManager == "ViewBilling") {
                                ViewBillingUtil($scope, $uibModalInstance, params);
                            } else if (typeManager == "AnnulmentBilling") {
                                AnnulmentBillingUtil($scope, $uibModalInstance, params);
                            }

                        }
                    }
                )
        ;

        modalInstance.closed.then(function () {
            managerCurrentModal = false;
        });


    };

}
function AnnulmentBillingUtil($scope, $uibModalInstance, params) {
    managerCurrentModal = true;
    $scope.loadData = false;
    UtilAdmin($scope);


    $scope.initManagerData = params;
    $uibModalInstance.rendered.then(function () {
        $scope.loadData = true;
        $scope.initEventsCurrent();
    });
    scopeModal = $scope;
    $scope.htmlTitle = "<span> Factura</span>";
    $scope.managerViewHtml = "";
    $scope.lblModalSave = "Anular";
    $scope.lblModalDismiss = "Cancelar";
    $scope.paramsCurrent = params;
    $scope.getViewBilling = function () {
        var typeBilling = $scope.initManagerData.typeBilling;
        var billingInformation = $scope.initManagerData.data;
        var billingManager = billingInformation.manager;
        var billingCustomer = billingManager.customer;
        var billingDetails = billingManager.detailsData;
        var billingRetentions = billingManager.retentionsData;
        var billingTransactions = billingManager.transactionsData;
        var headerBilling = $scope.getHeader();
        var billingAtsData = billingManager.atsData;

        var retentionHtml = "";
        retentionHtml = $scope.getRetention(
            {
                haystack: billingRetentions,
                typeBilling: typeBilling,
                "billingCustomer": billingCustomer,
                billingInformation: billingInformation,
                "billingAtsData": billingAtsData
            }
        );

        var detailsHtml = $scope.getDetails(
            {
                haystack: billingDetails,
                typeBilling: typeBilling,
                transactionsData: billingTransactions,
                billingRetentions: billingRetentions,
                billingInformation: billingInformation,

            }
        );
        var result = [
            headerBilling,
            retentionHtml,
            detailsHtml

        ];

        return result.join("");
    }
    $scope.getHeader = function () {
        var logoBusiness = $resourcesManager["logoBusiness"];
        var tdLogoBusiness = "<img class='billing-information-th-logo__img' src='" + logoBusiness + "'>";
        var typeBilling = $scope.initManagerData.typeBilling;
        var billingInformation = $scope.initManagerData.data;

        var billingManager = billingInformation.manager;
        var billingCustomer = billingManager.customer;


        var billingTransactions = billingManager.transactionsData;
        var htmlCustomer = typeBilling == "sales" ? "Cliente" : "Proveedor";
        var htmlCustomerName = billingCustomer.information.ti_code == "R" ? billingCustomer.information.razon_social : billingCustomer.information.p_nombres + " " + billingCustomer.information.p_apellidos;

        var tdBillingInformation = [
            '<table class="invoice-information">',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">RUC/CI</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.identificacion + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">' + htmlCustomer + '</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + htmlCustomerName + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Tipo Comprobante</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.tipo + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Nro</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.codigo_factura_info + '</span> </th>',
            '</tr>',
            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Nro Autorización</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.no_autorizacion + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Fecha de Factura</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.fecha_factura + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Fecha de Registro</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.fecha_creacion + '</span> </th>',
            '</tr>',

            ' </table>'].join("");
        var tdCustomerInformation = [
            '<table class="invoice-information-customer">',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Dirección</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.address + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Teléfono</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.phone + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Email</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.email + '</span> </th>',
            '</tr>'


        ];

        if (typeBilling == "buys") {
            tdCustomerInformation.push('<tr class="invoice-information-customer-tr">');
            tdCustomerInformation.push('<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Contacto</span> </th>');
            tdCustomerInformation.push('<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + (billingCustomer.information.p_nombres + " " + billingCustomer.information.p_apellidos) + '</span> </th>');
            tdCustomerInformation.push('</tr>');
        }
        tdCustomerInformation.push(
            ' </table>');
        tdCustomerInformation = tdCustomerInformation.join("");
        var result = [
            '<table class="billing-information">',
            '   <tr class="billing-information-tr1">',
            '       <th  class="billing-information-th-logo">' + tdLogoBusiness + '</th>',
            '       <th  class="billing-information-th-invoice-information" rowspan="2">' + tdBillingInformation + '</th>',
            '   </tr>',
            '   <tr  class="billing-information-tr2">',
            '       <th>' + tdCustomerInformation + '</th>',
            '   </tr>',
            ' </table>'


        ];

        return result.join("");

    }
    $scope.getRetention = function (params) {
        var haystack = params.haystack;
        var typeBilling = params.typeBilling;
        var nameCustomer = typeBilling == "buys" ? "Proveedor" : "Cliente";
        var billingCustomer = params.billingCustomer;
        var billingInformation = params.billingInformation;
        var has_retencion = billingInformation.has_retencion;

        var codeTypeCustomer = getCodeTypeIdentification({
            processName: typeBilling,
            typeIdentificationId: billingCustomer.information.tipo_identificacion_id
        });
        var taxSupport = params.billingAtsData.sustento_tributario;
        var valueCodeCustomer = Object.keys(codeTypeCustomer.needle).length ? codeTypeCustomer.needle.value : "error code";
        var tdTypeIdentification = "<span class='billing-retention-th__title'>Tipo de identificación " + nameCustomer + " </span><span class='billing-retention-th__value'>" + valueCodeCustomer + "</span>  ";
        var tdRetention2 = "<span class='billing-retention-th__title'>Sustento Tributario</span><span class='billing-retention-th__value'>" + taxSupport + "</span>  ";
        var tdRetention = "<span class='billing-retention-th__title'>Retención</span><span class='billing-retention-th__value'>" + (has_retencion == 1 ? "SI" : "NO") + "</span>  ";

        var trManagerRetentionsType = [
            '   <tr class="billing-retention-manager">',
            '       <th  class="billing-retention-th" colspan="2">' + tdRetention2 + '</th>',
            '   </tr>',
        ].join("");
        var result = [
            '<table class="billing-retention">',
            '   <tr class="billing-retention-tr1">',
            '       <th  class="billing-retention-th">' + tdTypeIdentification + ' </th>',
            '       <th  class="billing-retention-th" >' + tdRetention + '</th>',
            '   </tr>',
            trManagerRetentionsType,
            ' </table>'


        ];

        return result.join("");
    }
    $scope.viewRetentionDetails = false;
    $scope._viewDetailsRetention = function () {

        $scope.viewRetentionDetails = $scope.viewRetentionDetails ? false : true;
    }
    $scope.initEventsCurrent = function () {
        $(".billing-details-header-retentions-tr").on("click", function () {
            $(".billing-details-header-retentions-details").hasClass("not-view") ? $(".billing-details-header-retentions-details").removeClass("not-view") : $(".billing-details-header-retentions-details").addClass("not-view");
        });
    }
    $scope.getDetails = function (params) {
        var haystack = params.haystack;
        var typeBilling = params.typeBilling;
        var transactionsData = params.transactionsData;
        var trManagers = [];
        var trManagersPayments = [];

        var billingRetentions = params.billingRetentions;
        var billingInformation = params.billingInformation;
        var has_retencion = billingInformation.has_retencion;

        $.each(transactionsData, function (index, value) {
            var setPush = '   <tr class="billing-details-header-payments-results-tr">';
            trManagersPayments.push(setPush);

            setPush = '         <th class="billing-details-header-payments-results-th-header title">' + (value["tp_code"] + "-" + value["tp_descripcion"]) + '</th>';
            trManagersPayments.push(setPush);
            setPush = '         <th class="billing-details-header-payments-results-th-header value">' + ($scope.getValueCustomer(value["total"])) + '</th>';
            trManagersPayments.push(setPush);
            setPush = '      </tr>';
            trManagersPayments.push(setPush);
        });

        var tableManagersRetentions = [];
        var detailsRetentionSubtotal = [];
        var $totalRetentions = 0;
        var $rowspan = 6;
        if (has_retencion == 1) {
            var trManagersRetentions = [];
            $rowspan = 7;
            var trManagersRetentionsRows = [];


            $.each(billingRetentions, function (index, value) {
                var setPush = '   <tr class="billing-details-header-retentions-details-results-tr">';
                trManagersRetentionsRows.push(setPush);

                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + (value["cc_value"]) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["stri_value"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["tri_value"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["stri_porcentaje"])) + '%</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ($scope.getValueCustomer(value["valor_retenido"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '      </tr>';
                trManagersRetentionsRows.push(setPush);

                $totalRetentions += parseFloat(value["valor_retenido"]);
            });
            trManagersRetentions = trManagersRetentions.join("");
            trManagersRetentionsRows = trManagersRetentionsRows.join("");

            var trManagersRetentionsDetails = [

                '<table class="billing-details-header-retentions-details not-view" >',
                '   <tr class="billing-details-header-retentions-details-tr " >',
                '       <th  class="billing-details-header-retentions-details-th-header title">Contabilidad</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Base Imponible para Retención.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Impuesto.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Porcentaje.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Valor Retenido.</th>',
                '   </tr>',
                trManagersRetentionsRows,
                ' </table>'
            ];

            trManagersRetentionsDetails = trManagersRetentionsDetails.join("");
            tableManagersRetentions = [
                '<table class="billing-details-header-retentions" >',
                '   <tr class="billing-details-header-retentions-tr" >',
                '       <th  class="billing-details-header-retentions-th-header title">Valor Retencion</th>',
                '       <th  class="billing-details-header-retentions-th-header title"> $' + $scope.getValueCustomer($totalRetentions) + '</th>',
                '   </tr>',
                trManagersRetentions,
                ' </table>'
                , trManagersRetentionsDetails

            ];

            detailsRetentionSubtotal = [
                '   <tr class="billing-details-footer-tr">',
                '     <th class="billing-details-footer-th results-left result-invoice-title">Retenido</th>',
                '     <th class="billing-details-footer-th results-right result-invoice-value">' + $scope.getValueCustomer($totalRetentions) + '</th>',
                '   </tr>',]
        }

        trManagersPayments = trManagersPayments.join("");
        tableManagersRetentions = tableManagersRetentions.join("");
        var $dataPaymentTypes = [
            tableManagersRetentions,
            '<table class="billing-details-header-payments">',
            '   <tr class="billing-details-header-payments-tr">',
            '       <th  class="billing-details-header-payments-th-header title">Formato de Pago</th>',
            '       <th  class="billing-details-header-payments-th-header title">Valor</th>',
            '   </tr>',
            trManagersPayments,
            ' </table>'];
        var percentageTaxCurrent = "";
        var $subtotal0Total = 0;
        var $subtotalTaxTotal = 0;
        var $subtotalTotal = 0;
        var $discountTotal = 0;
        var $total = 0
        var notTax = 0;
        var $taxTotal = 0;
        $.each(haystack, function (index, value) {


            var taxPercentageCurrent = value["porcentaje_iva"];
            var cantCurrent = $scope.getValueCustomer(value["cantidad"]);
            var priceCurrent = $scope.getValueCustomer(value["precio_unitario"]);
            var percentageDiscountCurrent = $scope.getValueCustomer(value["porcentaje_descuento"]);

            var subtotalCurrent = (cantCurrent * priceCurrent);
            var discountCurrent = $scope.getValueCustomer((subtotalCurrent * percentageDiscountCurrent / 100));
            $discountTotal += discountCurrent;
            var taxCurrent = ((subtotalCurrent - discountCurrent) * taxPercentageCurrent / 100);
            $taxTotal += taxCurrent;
            var totalCurrent = subtotalCurrent - discountCurrent + taxCurrent;
            $total += totalCurrent;
            var classTax = "not-tax";
            if (taxPercentageCurrent == 0) {
                $subtotal0Total += subtotalCurrent;
            } else {
                percentageTaxCurrent = taxPercentageCurrent;
                $subtotalTaxTotal += subtotalCurrent;
                classTax = "has-tax";
            }


            var setPush = '   <tr class="billing-details-tr">';
            trManagers.push(setPush);
            var valueSet = value["pr_codigo"];
            setPush = '       <th  class="billing-details-th code">' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = cantCurrent;
            setPush = '       <th  class="billing-details-th cant" > ' + valueSet + '</th>';
            trManagers.push(setPush);
            var type_product = value["type_product"];
            valueSet = value["pr_nombre"] + " " + (type_product == 1 ? "/" + value["description"] : "");
            setPush = '       <th  class="billing-details-th description" > ' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(value["precio_unitario"]);
            setPush = '       <th  class="billing-details-th price" >' + valueSet + '</th>';
            trManagers.push(setPush);


            valueSet = $scope.getValueCustomer(subtotalCurrent);
            setPush = '       <th  class="billing-details-th subtotal" >' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = discountCurrent;
            setPush = '       <th  class="billing-details-th discount" > ' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(taxCurrent);
            setPush = '       <th  class="billing-details-th tax ' + classTax + '" >' + valueSet + ' </th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(totalCurrent);
            setPush = '       <th  class="billing-details-th total" > ' + valueSet + '</th>';
            trManagers.push(setPush);
            setPush = '   </tr>';
            trManagers.push(setPush);

        });
        trManagers = trManagers.join("");
        $subtotal0Total = $scope.getValueCustomer($subtotal0Total);
        $subtotalTaxTotal = $scope.getValueCustomer($subtotalTaxTotal);
        $subtotal = $scope.getValueCustomer($subtotalTotal + $subtotalTaxTotal);
        $discountTotal = $scope.getValueCustomer($discountTotal);
        $taxTotal = $scope.getValueCustomer($taxTotal);
        $total = $scope.getValueCustomer($total - $totalRetentions);
        $dataPaymentTypes = $dataPaymentTypes.join("");
        detailsRetentionSubtotal = detailsRetentionSubtotal.join("");
        var result = [
            '<table class="billing-details-header">',
            '   <tr class="billing-details-header-tr">',
            '       <th  class="billing-details-header-th code">COD PRINC. </th>',
            '       <th  class="billing-details-header-th cant" > CANT.</th>',
            '       <th  class="billing-details-header-th description" > DESCRIPCION.</th>',
            '       <th  class="billing-details-header-th price" > P.UNIT.</th>',
            '       <th  class="billing-details-header-th subtotal" > SUB TOTAL.</th>',
            '       <th  class="billing-details-header-th discount" > DESC.</th>',
            '       <th  class="billing-details-header-th tax" > IVA.</th>',
            '       <th  class="billing-details-header-th total" > TOTAL.</th>',
            '   </tr>',
            trManagers,
            ' </table>',
            '<table class="billing-details-footer">',
            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th payment-types " rowspan="' + $rowspan + '">' + $dataPaymentTypes + '</th>',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal 0%</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $subtotal0Total + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal ' + percentageTaxCurrent + '%</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $subtotalTaxTotal + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + ($subtotal) + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Descuento</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $discountTotal + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">IVA</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $taxTotal + '</th>',
            '   </tr>',
            detailsRetentionSubtotal,
            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Total</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $total + '</th>',
            '   </tr>',

            ' </table>',


        ];


        return result.join("");

    }
    $scope.managerViewHtml = $scope.getViewBilling();
    $scope._saveManager = function () {
        var btn_save_entidad_modal = $("#btn-manager-step1").ladda();
//        ---CUANDO SON PADRES--
        var url_gestion = $scope.paramsCurrent["step1"]["url"];
        var dataSend = {
            rowInvoice: $scope.paramsCurrent["data"],
            entidad_id: entidad_id
        }
        var params_gestion = {
                async: true,
                url: url_gestion, //accion dond vamos a realizar la gestion
                data: dataSend, //paramatros para realizar l proceso
                beforeCall: function () {//funcion antes d ejecutarse el procesos
                    btn_save_entidad_modal.ladda('start');
                },
                successCall: function (response) {

//              ----INIT MOSTRAR VALORES REALES---
//              ----END MOSTRAR VALORES REALES---
                    var color_save = "#e7493b";
                    var msj = "Registro Guardado.";

                    if (response.success) {

                    } else {
                        msj = response.msj;
                        color_save = "#e7493b";
                    }
                    var $params = {title: "Registro. ", color: color_save, icon: "fa fa-info", content: msj};
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                    $scope.resetBootgridManager($scope.paramsCurrent["step1"]["gridSelectorElement"]);
                    $scope._dismiss();
                    $scope.$apply();
                },

                errorCall: function (response) {
                    var statusText = response.statusText;
                    var status = response.status;
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: statusText
                    };
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                }

            }
        ;
        gestionInformacion(params_gestion);

    };
    $scope._dismiss = function () {
        $uibModalInstance.dismiss('cancel');
    };
    $scope.resetBootgridManager = function (elementSelector) {
        $(elementSelector).bootgrid("reload");
    }
}
function ViewBillingUtil($scope, $uibModalInstance, params) {
    managerCurrentModal = true;
    $scope.loadData = false;
    UtilAdmin($scope);
    $scope.initManagerData = params;
    $uibModalInstance.rendered.then(function () {
        $scope.loadData = true;
        $scope.initEventsCurrent();
    });
    scopeModal = $scope;
    $scope.htmlTitle = "<span> Factura</span>";
    $scope.managerViewHtml = "";
    $scope.getViewBilling = function () {

        var typeBilling = $scope.initManagerData.typeBilling;
        var billingInformation = $scope.initManagerData.data;
        var billingManager = billingInformation.manager;
        var billingCustomer = billingManager.customer;
        var billingDetails = billingManager.detailsData;
        var billingRetentions = billingManager.retentionsData;
        var billingTransactions = billingManager.transactionsData;
        var headerBilling = $scope.getHeader();
        var billingAtsData = billingManager.atsData;

        var retentionHtml = "";
        retentionHtml = $scope.getRetention(
            {
                haystack: billingRetentions,
                typeBilling: typeBilling,
                "billingCustomer": billingCustomer,
                billingInformation: billingInformation,
                "billingAtsData": billingAtsData
            }
        );

        var detailsHtml = $scope.getDetails(
            {
                haystack: billingDetails,
                typeBilling: typeBilling,
                transactionsData: billingTransactions,
                billingRetentions: billingRetentions,
                billingInformation: billingInformation,

            }
        );
        var result = [
            headerBilling,
            retentionHtml,
            detailsHtml

        ];

        return result.join("");
    }
    $scope.getHeader = function () {
        var logoBusiness = $resourcesManager["logoBusiness"];
        var tdLogoBusiness = "<img class='billing-information-th-logo__img' src='" + logoBusiness + "'>";
        var typeBilling = $scope.initManagerData.typeBilling;
        var billingInformation = $scope.initManagerData.data;

        var billingManager = billingInformation.manager;
        var billingCustomer = billingManager.customer;


        var billingTransactions = billingManager.transactionsData;
        var htmlCustomer = typeBilling == "sales" ? "Cliente" : "Proveedor";
        var htmlCustomerName = billingCustomer.information.ti_code == "R" ? billingCustomer.information.razon_social : billingCustomer.information.p_nombres + " " + billingCustomer.information.p_apellidos;

        var tdBillingInformation = [
            '<table class="invoice-information">',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">RUC/CI</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.identificacion + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">' + htmlCustomer + '</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + htmlCustomerName + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Tipo Comprobante</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.tipo + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Nro</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.codigo_factura_info + '</span> </th>',
            '</tr>',
            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Nro Autorización</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.no_autorizacion + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Fecha de Factura</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.fecha_factura + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-tr">',
            '<th class="invoice-information-th title"><span class="invoice-information-th__title">Fecha de Registro</span> </th>',
            '<th class="invoice-information-th value"><span class="invoice-information-th__value">' + billingInformation.fecha_creacion + '</span> </th>',
            '</tr>',

            ' </table>'].join("");
        var tdCustomerInformation = [
            '<table class="invoice-information-customer">',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Dirección</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.address + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Teléfono</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.phone + '</span> </th>',
            '</tr>',

            '<tr class="invoice-information-customer-tr">',
            '<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Email</span> </th>',
            '<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + billingCustomer.email + '</span> </th>',
            '</tr>'


        ];

        if (typeBilling == "buys") {
            tdCustomerInformation.push('<tr class="invoice-information-customer-tr">');
            tdCustomerInformation.push('<th class="invoice-information-customer-th title"><span class="invoice-information-customer-th__title">Contacto</span> </th>');
            tdCustomerInformation.push('<th class="invoice-information-customer-th value"><span class="invoice-information-customer-th__value">' + (billingCustomer.information.p_nombres + " " + billingCustomer.information.p_apellidos) + '</span> </th>');
            tdCustomerInformation.push('</tr>');
        }
        tdCustomerInformation.push(
            ' </table>');
        tdCustomerInformation = tdCustomerInformation.join("");
        var result = [
            '<table class="billing-information">',
            '   <tr class="billing-information-tr1">',
            '       <th  class="billing-information-th-logo">' + tdLogoBusiness + '</th>',
            '       <th  class="billing-information-th-invoice-information" rowspan="2">' + tdBillingInformation + '</th>',
            '   </tr>',
            '   <tr  class="billing-information-tr2">',
            '       <th>' + tdCustomerInformation + '</th>',
            '   </tr>',
            ' </table>'


        ];

        return result.join("");

    }
    $scope.getRetention = function (params) {
        var haystack = params.haystack;
        var typeBilling = params.typeBilling;
        var nameCustomer = typeBilling == "buys" ? "Proveedor" : "Cliente";
        var billingCustomer = params.billingCustomer;
        var billingInformation = params.billingInformation;
        var has_retencion = billingInformation.has_retencion;

        var codeTypeCustomer = getCodeTypeIdentification({
            processName: typeBilling,
            typeIdentificationId: billingCustomer.information.tipo_identificacion_id
        });
        var taxSupport = params.billingAtsData.sustento_tributario;
        var valueCodeCustomer = Object.keys(codeTypeCustomer.needle).length ? codeTypeCustomer.needle.value : "error code";
        var tdTypeIdentification = "<span class='billing-retention-th__title'>Tipo de identificación " + nameCustomer + " </span><span class='billing-retention-th__value'>" + valueCodeCustomer + "</span>  ";
        var tdRetention2 = "<span class='billing-retention-th__title'>Sustento Tributario</span><span class='billing-retention-th__value'>" + taxSupport + "</span>  ";
        var tdRetention = "<span class='billing-retention-th__title'>Retención</span><span class='billing-retention-th__value'>" + (has_retencion == 1 ? "SI" : "NO") + "</span>  ";

        var trManagerRetentionsType = [
            '   <tr class="billing-retention-manager">',
            '       <th  class="billing-retention-th" colspan="2">' + tdRetention2 + '</th>',
            '   </tr>',
        ].join("");
        var result = [
            '<table class="billing-retention">',
            '   <tr class="billing-retention-tr1">',
            '       <th  class="billing-retention-th">' + tdTypeIdentification + ' </th>',
            '       <th  class="billing-retention-th" >' + tdRetention + '</th>',
            '   </tr>',
            trManagerRetentionsType,
            ' </table>'


        ];

        return result.join("");
    }
    $scope.viewRetentionDetails = false;
    $scope._viewDetailsRetention = function () {

        $scope.viewRetentionDetails = $scope.viewRetentionDetails ? false : true;
    }
    $scope.initEventsCurrent = function () {
        $(".billing-details-header-retentions-tr").on("click", function () {
            $(".billing-details-header-retentions-details").hasClass("not-view") ? $(".billing-details-header-retentions-details").removeClass("not-view") : $(".billing-details-header-retentions-details").addClass("not-view");
        });
    }
    $scope.getDetails = function (params) {
        var haystack = params.haystack;
        var typeBilling = params.typeBilling;
        var transactionsData = params.transactionsData;
        var trManagers = [];
        var trManagersPayments = [];

        var billingRetentions = params.billingRetentions;
        var billingInformation = params.billingInformation;
        var has_retencion = billingInformation.has_retencion;

        $.each(transactionsData, function (index, value) {
            var setPush = '   <tr class="billing-details-header-payments-results-tr">';
            trManagersPayments.push(setPush);

            setPush = '         <th class="billing-details-header-payments-results-th-header title">' + (value["tp_code"] + "-" + value["tp_descripcion"]) + '</th>';
            trManagersPayments.push(setPush);
            setPush = '         <th class="billing-details-header-payments-results-th-header value">' + ($scope.getValueCustomer(value["total"])) + '</th>';
            trManagersPayments.push(setPush);
            setPush = '      </tr>';
            trManagersPayments.push(setPush);
        });

        var tableManagersRetentions = [];
        var detailsRetentionSubtotal = [];
        var $totalRetentions = 0;
        var $rowspan = 6;
        if (has_retencion == 1) {
            var trManagersRetentions = [];
            $rowspan = 7;
            var trManagersRetentionsRows = [];


            $.each(billingRetentions, function (index, value) {
                var setPush = '   <tr class="billing-details-header-retentions-details-results-tr">';
                trManagersRetentionsRows.push(setPush);

                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + (value["cc_value"]) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["stri_value"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["tri_value"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ((value["stri_porcentaje"])) + '%</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '         <th class="billing-details-header-retentions-details-results-th-header value">' + ($scope.getValueCustomer(value["valor_retenido"])) + '</th>';
                trManagersRetentionsRows.push(setPush);
                setPush = '      </tr>';
                trManagersRetentionsRows.push(setPush);

                $totalRetentions += parseFloat(value["valor_retenido"]);
            });
            trManagersRetentions = trManagersRetentions.join("");
            trManagersRetentionsRows = trManagersRetentionsRows.join("");

            var trManagersRetentionsDetails = [

                '<table class="billing-details-header-retentions-details not-view" >',
                '   <tr class="billing-details-header-retentions-details-tr " >',
                '       <th  class="billing-details-header-retentions-details-th-header title">Contabilidad</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Base Imponible para Retención.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Impuesto.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Porcentaje.</th>',
                '       <th  class="billing-details-header-retentions-details-th-header title">Valor Retenido.</th>',
                '   </tr>',
                trManagersRetentionsRows,
                ' </table>'
            ];

            trManagersRetentionsDetails = trManagersRetentionsDetails.join("");
            tableManagersRetentions = [
                '<table class="billing-details-header-retentions" >',
                '   <tr class="billing-details-header-retentions-tr" >',
                '       <th  class="billing-details-header-retentions-th-header title">Valor Retencion</th>',
                '       <th  class="billing-details-header-retentions-th-header title"> $' + $scope.getValueCustomer($totalRetentions) + '</th>',
                '   </tr>',
                trManagersRetentions,
                ' </table>'
                , trManagersRetentionsDetails

            ];

            detailsRetentionSubtotal = [
                '   <tr class="billing-details-footer-tr">',
                '     <th class="billing-details-footer-th results-left result-invoice-title">Retenido</th>',
                '     <th class="billing-details-footer-th results-right result-invoice-value">' + $scope.getValueCustomer($totalRetentions) + '</th>',
                '   </tr>',]
        }

        trManagersPayments = trManagersPayments.join("");
        tableManagersRetentions = tableManagersRetentions.join("");
        var $dataPaymentTypes = [
            tableManagersRetentions,
            '<table class="billing-details-header-payments">',
            '   <tr class="billing-details-header-payments-tr">',
            '       <th  class="billing-details-header-payments-th-header title">Formato de Pago</th>',
            '       <th  class="billing-details-header-payments-th-header title">Valor</th>',
            '   </tr>',
            trManagersPayments,
            ' </table>'];
        var percentageTaxCurrent = "";
        var $subtotal0Total = 0;
        var $subtotalTaxTotal = 0;
        var $subtotalTotal = 0;
        var $discountTotal = 0;
        var $total = 0
        var notTax = 0;
        var $taxTotal = 0;
        $.each(haystack, function (index, value) {


            var taxPercentageCurrent = value["porcentaje_iva"];
            var cantCurrent = $scope.getValueCustomer(value["cantidad"]);
            var priceCurrent = $scope.getValueCustomer(value["precio_unitario"]);
            var percentageDiscountCurrent = $scope.getValueCustomer(value["porcentaje_descuento"]);

            var subtotalCurrent = (cantCurrent * priceCurrent);
            var discountCurrent = $scope.getValueCustomer((subtotalCurrent * percentageDiscountCurrent / 100));
            $discountTotal += discountCurrent;
            var taxCurrent = ((subtotalCurrent - discountCurrent) * taxPercentageCurrent / 100);
            $taxTotal += taxCurrent;
            var totalCurrent = subtotalCurrent - discountCurrent + taxCurrent;
            $total += totalCurrent;
            var classTax = "not-tax";
            if (taxPercentageCurrent == 0) {
                $subtotal0Total += subtotalCurrent;
            } else {
                percentageTaxCurrent = taxPercentageCurrent;
                $subtotalTaxTotal += subtotalCurrent;
                classTax = "has-tax";
            }


            var setPush = '   <tr class="billing-details-tr">';
            trManagers.push(setPush);
            var valueSet = value["pr_codigo"];
            setPush = '       <th  class="billing-details-th code">' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = cantCurrent;
            setPush = '       <th  class="billing-details-th cant" > ' + valueSet + '</th>';
            trManagers.push(setPush);
            var type_product = value["type_product"];
            valueSet = value["pr_nombre"] + " " + (type_product == 1 ? "/" + value["description"] : "");

            setPush = '       <th  class="billing-details-th description" > ' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(value["precio_unitario"]);
            setPush = '       <th  class="billing-details-th price" >' + valueSet + '</th>';
            trManagers.push(setPush);


            valueSet = $scope.getValueCustomer(subtotalCurrent);
            setPush = '       <th  class="billing-details-th subtotal" >' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = discountCurrent;
            setPush = '       <th  class="billing-details-th discount" > ' + valueSet + '</th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(taxCurrent);
            setPush = '       <th  class="billing-details-th tax ' + classTax + '" >' + valueSet + ' </th>';
            trManagers.push(setPush);

            valueSet = $scope.getValueCustomer(totalCurrent);
            setPush = '       <th  class="billing-details-th total" > ' + valueSet + '</th>';
            trManagers.push(setPush);
            setPush = '   </tr>';
            trManagers.push(setPush);

        });
        trManagers = trManagers.join("");
        $subtotal0Total = $scope.getValueCustomer($subtotal0Total);
        $subtotalTaxTotal = $scope.getValueCustomer($subtotalTaxTotal);
        $subtotal = $scope.getValueCustomer($subtotalTotal + $subtotalTaxTotal);
        $discountTotal = $scope.getValueCustomer($discountTotal);
        $taxTotal = $scope.getValueCustomer($taxTotal);
        $total = $scope.getValueCustomer($total - $totalRetentions);
        $dataPaymentTypes = $dataPaymentTypes.join("");
        detailsRetentionSubtotal = detailsRetentionSubtotal.join("");
        var result = [
            '<table class="billing-details-header">',
            '   <tr class="billing-details-header-tr">',
            '       <th  class="billing-details-header-th code">COD PRINC. </th>',
            '       <th  class="billing-details-header-th cant" > CANT.</th>',
            '       <th  class="billing-details-header-th description" > DESCRIPCION.</th>',
            '       <th  class="billing-details-header-th price" > P.UNIT.</th>',
            '       <th  class="billing-details-header-th subtotal" > SUB TOTAL.</th>',
            '       <th  class="billing-details-header-th discount" > DESC.</th>',
            '       <th  class="billing-details-header-th tax" > IVA.</th>',
            '       <th  class="billing-details-header-th total" > TOTAL.</th>',
            '   </tr>',
            trManagers,
            ' </table>',
            '<table class="billing-details-footer">',
            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th payment-types " rowspan="' + $rowspan + '">' + $dataPaymentTypes + '</th>',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal 0%</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $subtotal0Total + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal ' + percentageTaxCurrent + '%</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $subtotalTaxTotal + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Subtotal</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + ($subtotal) + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Descuento</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $discountTotal + '</th>',
            '   </tr>',

            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">IVA</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $taxTotal + '</th>',
            '   </tr>',
            detailsRetentionSubtotal,
            '   <tr class="billing-details-footer-tr">',
            '     <th class="billing-details-footer-th results-left result-invoice-title">Total</th>',
            '     <th class="billing-details-footer-th results-right result-invoice-value">' + $total + '</th>',
            '   </tr>',

            ' </table>',


        ];


        return result.join("");

    }
    $scope.managerViewHtml = $scope.getViewBilling();

}
function IndebtednessUtil($scope, $uibModalInstance, params) {
    managerCurrentModal = true;
    $scope.loadData = false;
    UtilAdmin($scope);
    $scope.getMenuTabs = function () {
        return {
            0: {
                id: "report-1", text: "Credito", "active": true
            },
            1: {
                id: "report-1", text: "Pagos/Cobros ", "active": false
            }


        };
    }
    $scope.saveBreakdownPayments = false;
    $scope.menuTabs = $scope.getMenuTabs();
    $scope.selectorIndebtednessBreakdown = "#indebtedness-breakdown-grid";
    $scope.indebtednessBreakdownData = [];
    $scope.initBreakdown = false;
    $scope.selectorIndebtednessBreakdownCollection = "#indebtedness-breakdown-collection-grid";
    $scope._viewTab = function (params) {
        var key = params.key;
        $.each($scope.menuTabs, function (index, value) {
            $scope.menuTabs[index]["active"] = false;
        });

        $scope.menuTabs[key]["active"] = true;

        if (key == 0) {
            if ($scope.saveBreakdownPayments) {
                $scope.setDataBreakdownPayments();
                $scope.saveBreakdownPayments = false;
            }
        } else if (key == 1) {

        }
    }


    var dataManager = params.data;
    $scope.titleModal = "Gestion";
    $scope.lblModalSave = "Guardar";
    $scope.initManagerSteps = false;
    $scope.htmlTitle = "";
    $scope.trafficLightManagerCurrent = function () {
        var managerIndebtedness = $scope.paramsCurrent.data["managerIndebtedness"];
        var indebtednessBreakDown = managerIndebtedness["indebtednessBreakDown"];
        var hasIndebtedness = false;
        var supplyCustomer = "";
        var breakdownPayment = 0;
        $.each(indebtednessBreakDown.data, function (index, value) {
            if (value.state == "1") {

                hasIndebtedness = true;
            } else {
                breakdownPayment++;
            }

        });
        var classSpan = "badge badge-success";
        if (hasIndebtedness) {
            classSpan = "badge badge-warning";
        }
        supplyCustomer = $scope.paramsCurrent.data.razon_social + " <br> Documento # " + $scope.paramsCurrent.data.codigo_factura_info + " ";
        var breakdownState = breakdownPayment + "/" + Object.keys(indebtednessBreakDown.data).length;
        $scope.htmlTitle = supplyCustomer + "<br>  Credito-" + "<span class='" + classSpan + "'>" + breakdownState + "</span>";
    }
    $uibModalInstance.rendered.then(function () {

        $scope.initGridStep1();
        var gridId = $($scope.selectorIndebtednessBreakdown);
        var dataPush = [];
        if ($scope.initManagerSteps) {//update
            $scope.initGridStep2();
            dataPush = $scope.getDataCurrentBreakdown();
            $scope.indebtednessBreakdownData = dataPush;

        } else {//create
            $scope._generateDataPayments();
            dataPush = $scope.indebtednessBreakdownData;
            $scope.paramsCurrent.data["managerIndebtedness"]["data"] = dataPush;
        }
        gridId.bootgrid('append', dataPush);
        $scope.initBreakdown = true;
        $scope.trafficLightManagerCurrent();

        $scope.loadData = true;
    });
    scopeModal = $scope;
    $scope.fieldsManager = null;
    $scope.modelSriManager = null;
    $scope.lblBtnStep2 = "Registrar";
    $scope.dataManagerModel = {};
    $scope.fieldsManager = [
        {//0
            id: "id",
            name: "id",
            label: "Id",
            required: "1",
        },
        {//1
            id: "numero_pagos",//razon social
            name: "numero_pagos",
            label: "# Pagos",
            required: "1",
            type: "number",
            typeElement: "input",
            typeElementData: "",
            typeElementSize: "150",
            value: null,
            visible: 1
        },
        {//2
            id: "indebtedness_paying",
            name: "indebtedness_paying",
            label: "Monto Deuda",
            required: "1",
            type: "number",
            typeElement: "date",
            value: null,
            visible: 1
        },
        {//3
            id: "type_breakdown",
            name: "type_breakdown",
            label: "Tipo",
            required: "1",
            type: "number",
            typeElement: "date",
            value: null,
            visible: 1
        },
        {//4
            id: "day_number",
            name: "day_number",
            label: "Numero de Dias",
            required: "1",
            type: "number",
            typeElement: "number",
            value: null,
            visible: 1
        },
    ];
    $scope._typeBreakdown = function () {

    }
    $scope.dataManagerModelStep2 = {};
    $scope.fieldsManagerStep2 = [

        {//0
            id: "id",
            name: "id",
            label: "Id",
            required: "1",
        },
        {//1
            id: "fecha_pago",//razon social
            name: "fecha_pago",
            label: "Fecha Pago",
            required: "1",
            type: "date",
            typeElement: "date",
            typeElementData: "",
            typeElementSize: "150",
            value: null,
            visible: 1
        },
        {//2
            id: "nota",
            name: "nota",
            label: "Detalle",
            required: "0",
            type: "text",
            typeElement: "textarea",
            value: null,
            visible: 1
        },
        {//3
            id: "tipos_de_pagos_id_tipopago",
            name: "tipos_de_pagos_id_tipopago",
            label: "Tipo de Pago",
            required: "1",
            type: "S2",
            typeElement: "S2",
            value: null,
            visible: 1
        }, {//4
            id: "contabilidad_cuenta_id",
            name: "contabilidad_cuenta_id",
            label: "Cuenta Contable",
            required: "1",
            type: "S2",
            typeElement: "S2",
            value: null,
            visible: 1
        },
        {//5
            id: "invoice_indebtedness_paying_init_id",
            name: "invoice_indebtedness_paying_init_id",
            label: "Pago-Credito",
            required: "1",
            type: "S2",
            typeElement: "S2",
            value: null,
            visible: 1
        },
    ];
    $scope.select2OptionsPayment = {
        allowClear: true,
        delay: 250,
        type: "POST",
        ajax: {
            url:  params["step2"]["urlS2"],
            dataType: 'json',
            data: function (term, page) {

                params = $scope.getParams(term);
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    };
    $scope.getParams = function (term) {
        var indebtednessInit = $scope.paramsCurrent.data["managerIndebtedness"]["indebtednessInit"];
        var indebtednessBreakDown = $scope.paramsCurrent.data["managerIndebtedness"]["indebtednessBreakDown"];

        var idRelation = indebtednessInit.data ? indebtednessInit.data.id : 0;
        var params = "";
        if (term) {

            params = '{"search_value":' + term + ',"' + indebtednessBreakDown.relation_key + '" :' + idRelation + '}';
        } else {
            params = '{"' + indebtednessBreakDown.relation_key + '" :' + idRelation + '}';
        }
        params = JSON.parse(params);

        return params;
    }
    $scope.select2OptionsTypePayment = {
        allowClear: true,
        delay: 250,
        type: "post",
        ajax: {
            url:$('#action-typesPayments-getPaymentsCurrentS2').val(),
            dataType: 'json',
            data: function (term, page) {
                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    };
    $scope.select2OptionsAccountants = {
        allowClear: true,
        delay: 250,
        type: "post",
        ajax: {
            url:$('#action-typesPaymentsByAccount-getAccountingPaymentsS2').val(),
            dataType: 'json',
            data: function (term, page) {
                var tipo_pago = $scope.dataManagerModelStep2[$scope.fieldsManagerStep2[3].id] ? $scope.dataManagerModelStep2[$scope.fieldsManagerStep2[3].id].id : -1;
                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                    tipo_pago: tipo_pago
                };
                return params;
            },
            results: function (data, page) {

                return {results: data};
            }
        },
    };
    $scope.initValuesForm = function (params) {


    }
    $scope.resetForm = function (form) {
        if (form) {
            form.$setPristine();
            form.$setUntouched();
        }
    }

    $scope.getDataSend = function (params) {
        var current = params.current;
        var dataManagerModel = params.dataManagerModel;
        var indebtednessBreakdownData = params.indebtednessBreakdownData;

        var paramsCurrentManager = current;
        var $managerIndebtedness = paramsCurrentManager.data["managerIndebtedness"];
        var nameModel = $managerIndebtedness["indebtednessInit"]["model"];
        var dataSend = '{"' + nameModel + '": {"invoice":{},"managerIndebtedness":{}}}';

        var invoice = {id: paramsCurrentManager.data.id};
        $managerIndebtedness["indebtednessBreakDown"]["data"] = indebtednessBreakdownData;
        var indebtednessInitData = dataManagerModel;
        $managerIndebtedness["indebtednessInit"]["data"] = indebtednessInitData;
        dataSend = JSON.parse(dataSend);
        var keyModel = nameModel;
        dataSend[keyModel]["invoice"] = invoice;
        dataSend[keyModel]["managerIndebtedness"] = $managerIndebtedness;
        dataSend[keyModel]["entidad_data_id"] = entidad_id;
        return dataSend;
    }
    $scope._handleManager = function () {
        var btn_save_entidad_modal = $("#btn-manager-step1").ladda();
        var paramsManager = {
            current: $scope.paramsCurrent,
            dataManagerModel: $scope.dataManagerModel,
            indebtednessBreakdownData: $scope.indebtednessBreakdownData
        }
        var dataSend = $scope.getDataSend(paramsManager);

//        ---CUANDO SON PADRES--
        var url_gestion = $scope.paramsCurrent["step1"]["url"];
        var params_gestion = {
                async: true,
                url: url_gestion, //accion dond vamos a realizar la gestion
                data: dataSend, //paramatros para realizar l proceso
                beforeCall: function () {//funcion antes d ejecutarse el procesos
                    btn_save_entidad_modal.ladda('start');
                },
                successCall: function (response) {

//              ----INIT MOSTRAR VALORES REALES---
//              ----END MOSTRAR VALORES REALES---
                    var color_save = "#e7493b";
                    var msj = "Registro Guardado.";

                    if (response.success) {
                        $scope.dataManagerModel = response.managerIndebtedness.indebtednessInit["data"];
                        $scope.dataManagerModel.numero_pagos = parseFloat($scope.dataManagerModel.numero_pagos);
                        $scope.dataManagerModel.indebtedness_paying = parseFloat(response.managerIndebtedness.indebtedness.data.indebtedness_paying);
                        var dataCurrent = $scope.indebtednessBreakdownData;
                        $scope.removeDataBreakdownPayments(dataCurrent);
                        $scope.initManagerSteps = true;
                        var gridManager = $("#facturas-grid");
                        gridManager.bootgrid("reload");
                        $scope.setDataBreakdownPayments();
                        $scope.paramsCurrent["data"]["managerIndebtedness"] = response.managerIndebtedness;
                        $scope.paramsCurrent["data"]["managerIndebtedness"]["indebtednessInit"]["data"] = $scope.dataManagerModel;
                        $scope.initGridStep2();
                        $scope.trafficLightManagerCurrent();
                    } else {
                        msj = response.msj;
                        color_save = "#e7493b";
                    }
                    var $params = {title: "Registro. ", color: color_save, icon: "fa fa-info", content: msj};
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                    $scope.$apply();
                },

                errorCall: function (response) {
                    var statusText = response.statusText;
                    var status = response.status;
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: statusText
                    };
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                }

            }
        ;
        gestionInformacion(params_gestion);

    };
    $scope.setDataBreakdownPayments = function () {
        dataPush = $scope.getDataCurrentBreakdown();
        var gridId = $($scope.selectorIndebtednessBreakdown);
        gridId.bootgrid('append', dataPush);
    }
    $scope.removeDataBreakdownPayments = function (dataCurrent) {
        console.log("removeDataBreakdownPayments");
        var element_obj = $($scope.selectorIndebtednessBreakdown);

        $.each(dataCurrent, function (index, value) {
            console.log("remove", value);
            var row_id = value.id;
            element_obj.bootgrid('remove', [row_id]);
        });


    }
    $scope.getDataSendStep2 = function (params) {
        var current = params.current;
        var dataManagerModel = params.dataManagerModel;
        var indebtednessBreakdownData = params.indebtednessBreakdownData;

        var paramsCurrentManager = current;
        var $managerIndebtedness = paramsCurrentManager.data["managerIndebtedness"];
        var nameModelManager = $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["model"];
        var dataSend = '{"' + nameModelManager + '": {"invoice":{},"managerIndebtedness":{}}}';

        var invoice = {id: paramsCurrentManager.data.id};
        $managerIndebtedness["indebtednessBreakDown"]["data"] = indebtednessBreakdownData;
        /*MNANAGER*/
        var indebtednessInitData = dataManagerModel;
        $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["data"] = indebtednessInitData;
        var keyRelation = $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["relation_key"];
        var idRelation = $managerIndebtedness["indebtednessInit"]["data"]["id"];
        $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["data"][keyRelation] = idRelation;
        fecha_pago = moment($managerIndebtedness["indebtednessBreakDownCollectionPayments"]["data"]["fecha_pago"]).format("YYYY-MM-DD");
        $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["data"]["fecha_pago"] = fecha_pago;

        dataSend = JSON.parse(dataSend);
        var keyModel = $managerIndebtedness["indebtednessBreakDownCollectionPayments"]["model"];
        dataSend[keyModel]["invoice"] = invoice;
        dataSend[keyModel]["managerIndebtedness"] = $managerIndebtedness;
        dataSend[keyModel]["entidad_data_id"] = entidad_id;
        return dataSend;
    }
    $scope._handleManagerStep2 = function () {
        var btn_save_entidad_modal = $("#btn-manager-step2").ladda();
        var paramsManager = {
            current: $scope.paramsCurrent,
            dataManagerModel: $scope.dataManagerModelStep2,
            indebtednessBreakdownData: $scope.indebtednessBreakdownData
        }
        var dataSend = $scope.getDataSendStep2(paramsManager);

//        ---CUANDO SON PADRES--
        var url_gestion = $scope.paramsCurrent["step2"]["url"];
        var params_gestion = {
                async: true,
                url: url_gestion, //accion dond vamos a realizar la gestion
                data: dataSend, //paramatros para realizar l proceso
                beforeCall: function () {//funcion antes d ejecutarse el procesos
                    btn_save_entidad_modal.ladda('start');
                },
                successCall: function (response) {

//              ----INIT MOSTRAR VALORES REALES---
//              ----END MOSTRAR VALORES REALES---
                    var color_save = "#e7493b";
                    var msj = "Registro Guardado.";

                    if (response.success) {
                        var managerIndebtedness = response.managerIndebtedness;
                        var dataCurrent = $scope.indebtednessBreakdownData;
                        $scope.removeDataBreakdownPayments(dataCurrent);
                        $scope.dataManagerModelStep2 = {};
                        $scope.formManagerStep2.$setUntouched();
                        $scope.formManagerStep2.$setPristine();
                        var gridId = $($scope.selectorIndebtednessBreakdownCollection);
                        gridId.bootgrid("reload");
                        var gridManager = $("#facturas-grid");
                        gridManager.bootgrid("reload");
                        $scope.saveBreakdownPayments = true;

                        $scope.paramsCurrent["data"]["managerIndebtedness"] = managerIndebtedness;

                        $scope.trafficLightManagerCurrent();

                    } else {
                        msj = response.msj;
                        color_save = "#e7493b";
                    }
                    var $params = {title: "Registro. ", color: color_save, icon: "fa fa-info", content: msj};
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                    $scope.$apply();
                },

                errorCall: function (response) {
                    var statusText = response.statusText;
                    var status = response.status;
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: statusText
                    };
                    msjSystem($params);
                    btn_save_entidad_modal.ladda('stop');
                }

            }
        ;
        gestionInformacion(params_gestion);

    };
    $scope.initGridStep2 = function () {

        var gridId = $($scope.selectorIndebtednessBreakdownCollection);
        var relationId = $scope.paramsCurrent["data"]["managerIndebtedness"]["indebtednessInit"]["data"]["id"];
        var keyId = $scope.paramsCurrent["data"]["managerIndebtedness"]["indebtednessBreakDownCollectionPayments"]["relation_key"];
        var filters = {
            keyId: relationId
        };
        var filters = '{"' + keyId + '": ' + relationId + '}';
        filters = JSON.parse(filters);
        gridId.bootgrid({
            ajaxSettings: {
                method: "POST"
            },
            ajax: true,
            post: function () {
                return {
                    grid_id: $scope.selectorIndebtednessBreakdownCollection,
                    filters: filters
                };
            },
            url: baseUrl + params["step2"]["admin"],
            labels: {
                loading: "Cargando...",
                noResults: "Sin Resultados!",
                infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
            },
            css: {
                header: "bootgrid-header",
                table: "xywer-tbl-admin"

            },
            formatters: {
                'commands': function (column, row) {
                    return '<a  class="btn btn-primary btn-xs command-edit" data-toggle="tooltip" data-placement="top" title="Edit" data-row-id="' + row.id + '"><i class="fa fa-pencil"></i></a>';
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function () {
            $('[data-column-id="commands"]').css('width', '100px');
            $('[data-toggle="tooltip"]').tooltip();
            var dataRows = gridId.bootgrid("getCurrentRows");

            $.each(dataRows, function (key, valueRow) {

                var rowId = valueRow.id;
                var currentGridSelector = gridId.attr("id");
                var selectorRow = $("#" + currentGridSelector + " tr[data-row-id='" + rowId + "']");
                console.log(selectorRow);
                var classState = "success-state";
                if (valueRow.state_indebtedness == "0") {
                    classState = "warning-state";
                }
                selectorRow.addClass(classState);
            });
            gridId.find(".command-view").on("click", function (e) {


            }).end().find(".command-edit").on("click", function (e) {
                var self = $(this);
                var rowId = self.data("row-id");
                var currentGrid = $("#" + gridName);
                var instance_data_rows = getDataInstanciaBootgrid(currentGrid);
                var $row_data_info = searchElementJson(instance_data_rows.currentRows, 'id', rowId);//asi s obtiene los valores del registro en funcion d su id
                var dataCurrent = $row_data_info[0];

            });
        });


    }


    $scope.handleDismiss = function () {
        $uibModalInstance.dismiss('cancel');
    };


    $scope.invoice_by_pendient = {};
    $scope.invoice_indebtedness_paying_init = {};
    $scope.paramsCurrent = params;
    $scope.initManagerData = function (data) {
        $scope.invoice_by_pendient = {};
        $scope.invoice_indebtedness_paying_init = {};
        var managerIndebtedness = data.managerIndebtedness;
        var indebtedness = managerIndebtedness.indebtedness;
        $scope.invoice_by_pendient = indebtedness;
        $scope.initManagerSteps = false;
        var keySet = "indebtedness_paying";
        $scope.dataManagerModel[keySet] = $scope.getValueCustomer(indebtedness.data.indebtedness_paying);
        keySet = "numero_pagos";
        $scope.dataManagerModel[keySet] = 1;

        if (managerIndebtedness.indebtednessInit.data) {
            $scope.initManagerSteps = true;
            $scope.invoice_indebtedness_paying_init = managerIndebtedness.indebtednessInit.data;
            keySet = "id";
            $scope.dataManagerModel[keySet] = $scope.invoice_indebtedness_paying_init.id;
            keySet = "numero_pagos";
            $scope.dataManagerModel[keySet] = parseInt($scope.invoice_indebtedness_paying_init.numero_pagos);

        } else {

        }


    }


    $scope.initGridStep1 = function () {
        var gridId = $($scope.selectorIndebtednessBreakdown);
        gridId.bootgrid({
            labels: {
                loading: "Cargando...",
                noResults: "Sin Resultados!",
                infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
            },
            css: {
                header: "bootgrid-header",
                table: "xywer-tbl-admin"

            },
            formatters: {
                'pago_cantidad': function (column, row) {
                    var html = "";
                    var rowId = row.id;
                    var classEdit = "";
                    if ($scope.dataManagerModel[$scope.fieldsManager[3].id]) {
                        var elementManager = "<div id='content-input-" + rowId + "' data-row-id='" + rowId + "'><input type='number' class='form-group manager-pago_cantidad' data-row-id='" + rowId + "' value='" + $scope.getValueCustomer(row.pago_cantidad) + "'></div>";
                        elementManager += "<div  class='not-view' id='content-view-" + rowId + "' data-row-id='" + rowId + "'><span class='span-view-pago-cantidad'> " + row.pago_cantidad + "</span></div>";
                        html = "<div  class='span-value__pago_cantidad--edit' data-row-id='" + rowId + "'>" + elementManager + "</div>";

                    } else {

                        html = "<span  class='span-value__pago_cantidad' data-row-id='" + rowId + "'>" + $scope.getValueCustomer(row.pago_cantidad) + "</span>";
                    }

                    return html;
                },
                'state': function (column, row) {
                    console.log(row);
                    var html = "";
                    var rowId = row.id;
                    var classSpan = "badge-success";
                    var status = row.state == "1" ? "Por Pagar" : "Pagado";
                    if (row.state == "1") {
                        classSpan = "badge-warning";
                    }
                    html = "<span  class='badge " + classSpan + " span-value__pago_cantidad' data-row-id='" + rowId + "'>" + status + "</span>";
                    return html;
                },
            }
        }).on("loaded.rs.jquery.bootgrid", function () {
            gridId.find(".fecha_pago_acuerdo").on("click", function (e) {
                var self = $(this);
                var rowId = self.data("row-id");


            });
            gridId.find(".manager-pago_cantidad").on("blur", function (e) {
                var self = $(this);
                var rowId = self.data("row-id");
                var valueCurrent = self.val();
                valueCurrent = valueCurrent ? valueCurrent : 0;
                $.each($scope.paramsCurrent.data.managerIndebtedness["indebtednessBreakDown"]["data"], function (index, value) {
                    if (value["id"] == rowId) {
                        $scope.paramsCurrent.data.managerIndebtedness["indebtednessBreakDown"]["data"][index]["pago_cantidad"] = valueCurrent;
                        $scope.indebtednessBreakdownData[index]["pago_cantidad"] = valueCurrent;
                    }
                });
                $scope.$apply();

            });
        });

        return gridId;
    }
    $scope.getDataCurrentBreakdown = function () {
        var result = $scope.paramsCurrent["data"] ["managerIndebtedness"]["indebtednessBreakDown"]["data"];
        return result;

    }
    $scope._validateManager = function () {
        var totalIndebtedness = 0;
        $scope.totalIndebtedness = 0;
        $.each($scope.indebtednessBreakdownData, function (index, value) {
            totalIndebtedness += parseFloat(value["pago_cantidad"]);
        });
        var okManager = true;
        totalIndebtedness = totalIndebtedness.toFixed(3);
        if (totalIndebtedness <= 0 || totalIndebtedness < $scope.dataManagerModel[$scope.fieldsManager[2].id]) {
            okManager = false;
        }
        $scope.totalIndebtedness = totalIndebtedness;
        return okManager;
    }
    $scope._generateDataPayments = function () {


        var result = [];
        var intervalDays = 30;
        if ($scope.dataManagerModel[$scope.fieldsManager[3].id]) {
            intervalDays = $scope.dataManagerModel[$scope.fieldsManager[4].id] ? $scope.dataManagerModel[$scope.fieldsManager[4].id] : 1;
        }
        var dateCurrentString = $scope.getDateStringCurrentByFormat({
            "format": "M/D/Y"
        });
        var numberPayments = $scope.dataManagerModel["numero_pagos"];
        var valueIndebtednessPaying = $scope.dataManagerModel["indebtedness_paying"];

        var dataCurrent = $scope.indebtednessBreakdownData;
        $scope.removeDataBreakdownPayments(dataCurrent);

        if (numberPayments && numberPayments > 0) {
            var fecha = new Date(dateCurrentString);
            var pago_cantidad = valueIndebtednessPaying / numberPayments;
            pago_cantidad = pago_cantidad.toFixed(3);
            fecha.setDate(fecha.getDate() + intervalDays);
            var fecha_pago_acuerdo = fecha;
            fecha_pago_acuerdo = formatDate({
                date: fecha_pago_acuerdo,
                "format": "D-M-Y"
            });
            var setPush = {
                id: 0,
                fecha_pago_acuerdo: fecha_pago_acuerdo,
                pago_cantidad: pago_cantidad,
                state: 1
            };
            result.push(setPush);
            for (var i = 1; i < numberPayments; i++) {
                fecha.setDate(fecha.getDate() + intervalDays);
                setPush = {
                    id: i,
                    fecha_pago_acuerdo: formatDate({
                        date: fecha,
                        "format": "D-M-Y"
                    }),
                    pago_cantidad: pago_cantidad,
                    state: 1
                };
                result.push(setPush);
            }
            $scope.paramsCurrent.data.managerIndebtedness["indebtednessBreakDown"]["data"] = result;
        }

        $scope.indebtednessBreakdownData = result;
        if ($scope.initBreakdown) {
            var element_obj = $($scope.selectorIndebtednessBreakdown);
            element_obj.bootgrid('append', result);
        }

        $scope.trafficLightManagerCurrent();
    }
    $scope.initManagerData(dataManager);
    /*------VALIDATION FORM---------*/
    $scope._getClassFormGroup = function (elementNameOption, form) {
        /*https://docs.angularjs.org/api/ng/type/form.FormController#$pristine*/
        var result = "";
        var $pristine = form.$pristine;
        var elementNameValidate = elementNameOption.id;
        var required = form[elementNameValidate].$error["required"];
        var touched = form[elementNameValidate].$touched;
        var errorForm = false;
        if (!$pristine) {
            if (required && touched) {
                result = "has-error";
                errorForm = true;
            } else if (!(required && touched)) {
                result = "has-success-";
                errorForm = false;
            }
        } else {
            result = "has-init";
            errorForm = false;
        }
        return errorForm;

    }
    $scope._getMsjErrorsElementForm = function (form, elementNameOption) {
        var msj = "";
        var elementKey = elementNameOption;
        if (form[elementKey].$error.required) {

            msj = "El campo es obligatorio.";
        } else if (form[elementKey].$error.max) {
            msj = "El campo sobrepasa al valor maximo.";


        } else if (form[elementKey].$error.maxlength) {
            msj = "El campo sobrepasa al valor maximo.";


        } else if (form[elementKey].$error.min) {
            msj = "El campo sobrepasa al valor min.";
            view = true;

        } else if (form[elementKey].$error.number) {
            msj = "El campo no es number";


        } else if (form[elementKey].$error.url) {
            msj = "El campo no es url";
            view = true;

        } else if (form[elementKey].$error.date) {
            msj = "El campo no es date";


        } else if (form[elementKey].$error.time) {
            msj = "El campo no es time";


        }
        return msj;
    }
    $scope._viewContainer = function (form, elementNameOption) {
        var elementKey = elementNameOption;
        return (form.$submitted || form[elementKey].$touched);
    }
    $scope._viewErrorsElementForm = function (form, elementNameOption) {
        var view = false;
        var elementKey = elementNameOption;
        if (form[elementKey]) {

            if (form[elementKey].$error.required) {
                view = true;
            } else if (form[elementKey].$error.max) {
                view = true;
            } else if (form[elementKey].$error.maxlength) {

                view = true;

            } else if (form[elementKey].$error.min) {

                view = true;

            } else if (form[elementKey].$error.number) {

                view = true;

            } else if (form[elementKey].$error.url) {

                view = true;

            } else if (form[elementKey].$error.date) {

                view = true;

            } else if (form[elementKey].$error.time) {

                view = true;

            }
        }
        return view;
    }
}
