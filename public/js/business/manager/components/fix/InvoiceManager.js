
function processStep1Invoice(params) {
    headerInvoice(params);
    filtersAddPartInvoice(params);
    gridManagerInvoice(params);
}

function gridManagerInvoice(params) {
    var $scope = params["$scope"];
    var uiGridConstants = params["uiGridConstants"];
    $scope.getDataGridRepair = function (repair_id) {
        var dataCurrent = $scope.gridInvoiceOpts.data; //change
        var result = [];
        $.each(dataCurrent, function (key, value) {
            var setPush = {
                repair_id: repair_id,
                quantity: value['quantity'],
                product_color_id: value['product_color_id'],
                repair_product_by_business_id: value['repair_product_by_business_id'],
                product_trademark_id: value['product_trademark_id'],
            };
            result.push(setPush);

        });


        return result;
    };
    $scope.verifyManagerGridInvoice = function () {
        var success = true;
        var errors = [];
        var dataCurrent = $scope.gridInvoiceOpts.data; //change
        if (!$scope.isEmptyGridInvoice()) {
            $.each(dataCurrent, function (key, value) {

                if (!$.isNumeric(value['quantity'])) {
                    errors.push({msj: 'Valor no permitido en cantidad : ' + value['quantity'], type: 1, key: key});
                    success = false;
                }
            });
        } else {
            success = false;
            errors.push({msj: 'No existe Valores Agregados.', type: 0});
        }

        var result = {
            success: success,
            errors: errors,

        };
        return result;
    };
    $scope.deleteRow = function (row) {
        var index = $scope.gridInvoiceOpts.data.indexOf(row.entity);
        $scope.gridInvoiceOpts.data.splice(index, 1);
        $scope.getManagerAllowGrid();
    };
    $scope.getManagerAllowGrid = function () {
        return $scope.verifyManagerGridInvoice();

    };
    $scope.isEmptyGridInvoice = function () {
        var data_rows = $scope.gridInvoiceOpts.data.length;
        var result = false;
        if (data_rows > 0) {
            result = false;
        } else {
            result = true;
        }
        return result;
    };
    var columnsConfigInvoice = [
        {
            displayName: "Partes/Otros",
            name: "repair_product_by_business",
            enableCellEdit: false,
            width: "50%"
        },
        {
            displayName: "Cant",
            name: "quantity",
            enableCellEdit: true,
            enableCellEditOnFocus: true,
            width: "12%",
            type: "number",
            editableCellTemplate:
                "<div  class='div-input-data-cantidad'><form name=\"inputForm\"><input class ='form-controll input-data-cantidad' type=\"INPUT_TYPE\" ng-class=\"'input-data-cantidad' + col.uid\" ui-grid-editor ng-model=\"MODEL_COL_FIELD\"></form></div>"
        },
        {
            displayName: "Marca",
            name: "product_trademark",
            enableCellEdit: false,
            enableCellEditOnFocus: true,
            width: "14%"
        },
        {
            displayName: "Color",
            name: "product_color",
            enableCellEdit: false,
            enableCellEditOnFocus: true,
            width: "14%"
        },
        {
            name: " ",
            enableCellEdit: false,
            cellTemplate:
                '<button data-toggle="tooltip" data-placement="top" title="Eliminar" init-tooltip type="button" class="delete-data fas fa-trash-alt" ng-click="grid.appScope.deleteRow(row)"></button>',
            width: "10%"
        }
    ];
    $scope.rowTemplate = function () {
        return (
            "<div ng-class=\"{ 'add-data-element': grid.appScope.rowFormatter( row ) }\">" +
            '  <div ng-if="row.entity.merge">{{row.entity.title}}</div>' +
            '  <div ng-if="!row.entity.merge" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }"  ui-grid-cell></div>' +
            "</div>"
        );
    };
    $scope.gridApi = null;
    $scope.gridApiData = null;
    $scope.pushAllow = false;
    $scope.gridInvoiceOpts = {
        expandableRowHeight: 50,
        enableRowSelection: true,
        enableHorizontalScrollbar: uiGridConstants.scrollbars.NEVER,
        //        enableVerticalScrollbar: uiGridConstants.scrollbars.NEVER,
        columnDefs: columnsConfigInvoice,
        data: [],
        rowTemplate: $scope.rowTemplate(), //para poder poner las clases d qien esta asgianddo
        enableSorting: false,
        enableFiltering: false,
        //        --expander config--
        enableExpandableRowHeader: false,
        enableExpandable: false,
        onRegisterApi: function (gridApi) {
            grid_object = gridApi;
            $scope.gridApi = gridApi;
            expandibleob = gridApi.expandable;
            $scope.gridApiData = gridApi;
            $scope.gridApiData.edit.on.afterCellEdit($scope, function (
                rowEntity,
                colDef,
                newValue,
                oldValue
            ) {
                if (!newValue) {
                    //null
                    rowEntity["quantity"] = oldValue;
                }
                $scope.verifyManagerGridInvoice(); //riniciar los resultados
            });


        }
    };
    $scope.viewAddParts = function () {
        var allow_quantity,
            allow_product_trademark_id_data,
            allow_product_color_id_data,
            allow_repair_product_by_business_id_data = false;
        if ($scope.model.hasOwnProperty("addParts")) {
            allow_quantity = $scope.model.addParts.hasOwnProperty("quantity")
                ? true
                : false;
            allow_product_trademark_id_data = $scope.model.addParts.hasOwnProperty(
                "product_trademark_id_data"
            )
                ? $scope.model.addParts.product_trademark_id_data != null
                : false;
            allow_repair_product_by_business_id_data = $scope.model.addParts.hasOwnProperty(
                "repair_product_by_business_id_data"
            )
                ? $scope.model.addParts.repair_product_by_business_id_data !=
                null
                : false;
            allow_product_color_id_data = $scope.model.addParts.hasOwnProperty(
                "product_color_id_data"
            )
                ? $scope.model.addParts.product_color_id_data != null
                : false;
        }

        var result = false;
        if (
            allow_quantity &&
            allow_product_trademark_id_data &&
            allow_repair_product_by_business_id_data &&
            allow_product_color_id_data
        ) {
            result = true;
        }
        return result;
    };
    $scope.resetParts = function () {
        if ($scope.model.addParts) {

            $scope._destroyTooltip('#add-parts');
            $scope.model.addParts["quantity"] = null;
            $scope.model.addParts["product_color_id_data"] = null;
            $scope.model.addParts["product_trademark_id_data"] = null;
            $scope.model.addParts["repair_product_by_business_id_data"] = null;
            if ($scope.formManager.quantity) {

                $scope.formManager.quantity.$setUntouched();
                $scope.formManager.quantity.$setPristine();
                $scope.formManager.product_color_id_data.$setUntouched();
                $scope.formManager.product_color_id_data.$setPristine();
                $scope.formManager.product_trademark_id_data.$setUntouched();
                $scope.formManager.product_trademark_id_data.$setPristine();
                $scope.formManager.repair_product_by_business_id_data.$setUntouched();
                $scope.formManager.repair_product_by_business_id_data.$setPristine();
            }
        }
    };
    $scope._addParts = function (event) {
        if (event) {
            var allowPush = $scope.viewAddParts();
            if (allowPush) {
                var quantity = $scope.model.addParts.quantity,
                    product_color_id =
                        $scope.model.addParts.product_color_id_data.id,
                    product_color =
                        $scope.model.addParts.product_color_id_data.text,
                    repair_product_by_business_id =
                        $scope.model.addParts.repair_product_by_business_id_data
                            .id,
                    repair_product_by_business =
                        $scope.model.addParts.repair_product_by_business_id_data
                            .text,
                    product_trademark_id =
                        $scope.model.addParts.product_trademark_id_data.id,
                    product_trademark =
                        $scope.model.addParts.product_trademark_id_data.text;

                var setPush = {
                    quantity: quantity,
                    product_color_id: product_color_id,
                    product_color: product_color,
                    repair_product_by_business_id: repair_product_by_business_id,
                    repair_product_by_business: repair_product_by_business,
                    product_trademark_id: product_trademark_id,
                    product_trademark: product_trademark
                };
                $scope.gridInvoiceOpts.data.push(setPush);
                $scope.resetParts();
            } else {
                console.log("errr");
            }
        }
    };
    $scope.resetGridManagerParts = function () {
        $scope.resetParts();
        $scope.gridInvoiceOpts.data = [];
    }
}

function headerInvoice(params) {
    var $scope = params["$scope"];
    $scope.formatState = function (state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span><img src="vendor/images/flags/' +
            state.element.value.toLowerCase() +
            '.png" class="img-flag" /> ' +
            state.text +
            "</span>"
        );
        return $state;
    };
    $scope.s2CustomerIdData = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: $urlBase+"/business/customer/listRepair",
            dataType: "json",
            data: function (term, page) {
                params = {
                    search_value: term,
                    business_id: $scope.business_id
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        }
    };
}

function filtersAddPartInvoice(params) {
    var $scope = params["$scope"];

    $scope.s2RepairProductByBusinessIdData = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url:  $urlBase+"/repairProductByBusiness/listSelect2",
            dataType: "json",
            data: function (term, page) {
                params = {
                    search_value: term,
                    business_id: $scope.business_id
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        }
    };
    $scope.s2ProductTrademarkIdData = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url:  $urlBase+"/productTrademark/listSelect2",
            dataType: "json",
            data: function (term, page) {
                params = {
                    search_value: term,
                    business_id: $scope.business_id
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        }
    };
    $scope.s2ProductColorIdData = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url:  $urlBase+"/productColor/listSelect2",
            dataType: "json",
            data: function (term, page) {
                params = {
                    search_value: term,
                    business_id: $scope.business_id
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        }
    };
}
