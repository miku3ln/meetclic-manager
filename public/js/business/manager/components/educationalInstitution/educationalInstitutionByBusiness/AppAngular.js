var btn_save_entidad;//
var entidad_data_id;
var modelAskwer;
var data_new = true;
var form_element = '#askwer-form-form';
var $modelAskwerInit;
var app = angular.module('app', [
    'ngSanitize',
    'ui.bootstrap',
    'ngMaterial', //PARA EL MODAL
    'ngAnimate',
]);
var $scopeCurrent;
var business_id = $modelDataManager["business"][0].id;
var control = app.controller('managerController', function (
    $scope,
    $http
) {

    $scopeCurrent = $scope;
    console.log('hi ready');
    $scope.section = null;
    $scope.sections = [];
    $scope.sectionsView = function () {
        console.log("s");
        return $scope.sections.length==0?false:true;
    }
    $scope.viewsManager = {
        form: false,
        admin: true,
        results: false,
        managerForm: false,

    };
    $scope.dataManager = {
        business_id: business_id,
        /*  ----MANAGER ENTITY---*/
        configModelEntity: {
            "buttonsManagements": [
                {
                    "title": "Actualizar",
                    "data-placement": "top",
                    "i-class": " fas fa-pencil-alt",
                    "managerType": "updateEntity"
                },
                {
                    "title": "Ver formularios",
                    "data-placement": "top",
                    "i-class": " fas fa-pencil-alt-square-o",
                    "managerType": "viewEntity"
                },
                {
                    "title": "Resultados",
                    "data-placement": "top",
                    "i-class": "fa fa fa-list",
                    "managerType": "viewResults"
                }
            ]
        },
        managerMenuConfig: {
            view: false,
            menuCurrent: [],
            rowId: null
        },
        configParams: {},
        labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
//form config
        tabCurrentSelector: '#tab-educational-institution-by-business',
        processName: "Registro Acción.",
        formConfig: {
            nameSelector: "#educational-institution-by-business-form",
            url: $('#action-educational-institution-by-business-saveData').val(),
            loadingMessage: 'Guardando...',
            errorMessage: 'Error al guardar el EducationalInstitutionByBusiness.',
            successMessage: 'El EducationalInstitutionByBusiness se guardo correctamente.',
            nameModel: "EducationalInstitutionByBusiness"
        },
//Grid config
        gridConfig: {
            selectorCurrent: "#educational-institution-by-business-grid",
            url: $("#action-educational-institution-by-business-getAdmin").val()
        },
        submitStatus: "no",
        showManager: false,
        managerType: null,
    };

    $scope.initGridManagerApp = function () {
        gridManager($scope);
        $scope.initGridManager($scope);
    };
    $scope.initGridManagerApp();
    AskwerUtil($scope);
}).directive("initToolTip", function () {
    return {
        link: function (scope, element, attrs, controller, transcludeFn) {
            $(element[0]).tooltip();
        }
    };

});

function gridManager($scope) {
    /*---------GRID--------*/
    $scope._destroyTooltip = function (selector) {
        $(selector).tooltip('hide');
    };
    $scope._resetManagerGrid = function () {
        $scope.dataManager.managerMenuConfig = {
            view: false,
            menuCurrent: [],
            rowId: null
        };
    };
    $scope._managerMenuGrid = function (index, menu) {
        var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
        $scope._managerRowGrid(params);
    };
    $scope.getMenuConfig = function (params) {
        var result = [];
        $.each($scope.dataManager.configModelEntity["buttonsManagements"], function (key, value) {
            var setPush = {
                title: value["title"],
                "data-placement": value["data-placement"],
                icon: value["i-class"],
                data: value, rowId: params.rowId,
                managerType: value["managerType"],
                params: params
            }
            result.push(setPush);
        });
        return result;
    };
    $scope._gridManager = function (elementSelect) {
        var vmCurrent = $scope;
        var selectorGrid = vmCurrent.dataManager.gridConfig.selectorCurrent;
        vmCurrent._resetManagerGrid();
        elementSelect.find("tbody tr").on("click", function (e) {
            var self = $(this);
            var dataRowId = $(self[0]).attr("data-row-id");
            var selectorRow;
            $scope.dataManager.managerMenuConfig.view = false;
            $scope.$apply();
            if (dataRowId) {
                var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                elementSelect.find("tr.selected").removeClass("selected");
                var newEventRow = false;
                if (vmCurrent.dataManager.managerMenuConfig.rowId) {//ready selected
                    var removeRowId = vmCurrent.dataManager.managerMenuConfig.rowId;
                    if (dataRowId == removeRowId) {
                        selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                        $(selectorRow).removeClass("selected");
                        vmCurrent._resetManagerGrid();
                    } else {

                        newEventRow = true;
                    }
                } else {
                    newEventRow = true;
                }
                if (newEventRow) {
                    selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                    $(selectorRow).addClass("selected");
                    vmCurrent.dataManager.managerMenuConfig = {
                        view: true,
                        menuCurrent: vmCurrent.getMenuConfig({rowData: rowData[0], rowId: dataRowId}),
                        rowId: dataRowId
                    };
                }
                $scope.$apply();
            }
        });
        $scope.$apply();
    };
    $scope._managerRowGrid = function (params) {
        var rowCurrent = params.row;
        var rowId = params.id;
        var dataSend;
        if (params.managerType == "updateEntity") {
            var elementDestroy = ("#a-menu-" + $scope.dataManager.managerMenuConfig.rowId);
            $scope._destroyTooltip(elementDestroy);
            dataSend = {
                EducationalInstitutionByBusiness: {
                    id: rowId
                },
            };
            ajaxRequest($('#action-educational-institution-askwer-type-getDataAskwer').val(), {
                type: 'POST',
                data: dataSend,
                blockElement: $scope.dataManager.tabCurrentSelector,//
                loading_message: 'Cargando...',
                error_message: 'Error al cargar informacion.',
                success_message: 'Informacion Cargada.',
                success_callback: function (response) {

                    if (response.success) {
                        var dataResponse = response.data;
                        dataResponse['AskwerForm']['educational_institution_askwer_type_id'] = rowCurrent.educational_institution_askwer_type_id;
                        dataResponse['AskwerForm']['educational_institution_askwer_type'] = rowCurrent.educational_institution_askwer_type;

                        $modelAskwerInit.setDataManager(dataResponse);
                        $scope._viewManager(3, rowId);
                    } else {
                        var errorsCurrent = response.msj;

                    }
                    $scope.$apply();
                }
            });

        } else if (params.managerType == "viewEntity") {
            dataSend = {
                EducationalInstitutionByBusiness: {
                    id: rowId
                },
            };
            ajaxRequest($('#action-educational-institution-by-business-getDataAskwerForm').val(), {
                type: 'POST',
                data: dataSend,
                blockElement: $scope.dataManager.tabCurrentSelector,//
                loading_message: 'Cargando...',
                error_message: 'Error al cargar informacion.',
                success_message: 'Informacion Cargada.',
                success_callback: function (response) {

                    if (response.success) {
                        var dataResponse = response.data;

                        data_form_askwer = dataResponse;
                        $scope.generateAskwerFormFields(dataResponse);
                        $scope._viewManager(4, rowId);
                    } else {
                        var errorsCurrent = response.msj;

                    }
                    $scope.$apply();
                }
            });
        } else if (params.managerType == "viewResults") {

        }
    };
    $scope.initGridManager = function (vmCurrent) {
        var gridName = $scope.dataManager.gridConfig.selectorCurrent;
        var urlCurrent = $scope.dataManager.gridConfig.url;
        var paramsFilters = {
            business_id: $scope.dataManager.business_id
        };
        let gridInit = $(gridName);
        gridInit.bootgrid({
            ajaxSettings: {
                method: "POST"
            },
            ajax: true,
            post: function () {
                return {
                    grid_id: gridName,
                    filters: paramsFilters
                };
            },
            url: urlCurrent,
            labels: {
                loading: "Cargando...",
                noResults: "Sin Resultados!",
                infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
            },
            css: getCSSCurrentBootGrid(),
            formatters: {
                'description': function (column, row) {
                    var result = [
                        " <div class = 'content-description' > ",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Tipo Formulario:</span><span class='content-description__value'>" + row.educational_institution_askwer_type + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Nombre Formulario:</span><span class='content-description__value'>" + row.askwer_form + "</span>",
                        "</div>",
                        "</div>",
                    ];

                    return result.join("");

                }

            }
        }).on("loaded.rs.jquery.bootgrid", function () {
            vmCurrent._resetManagerGrid();
            vmCurrent._gridManager(gridInit);
        });
    };
    /*Manager FORMS-AND VIEWS*/
    $scope._viewManager = function (typeView, rowId) {

        $scope.viewsManager = {
            form: false,
            admin: false,
            results: false,
            managerForm: false,
        };
        if (typeView == 1) {//create
            $scope.dataManager.showManager = true;
            $scope.dataManager.managerMenuConfig.view = false;
            $($scope.dataManager.gridConfig.selectorCurrent + "-header").hide();
            $($scope.dataManager.gridConfig.selectorCurrent + "-footer").hide();
            /*  $scope.resetForm();*/
            $scope.dataManager.managerType = 1;
            $scope.viewsManager.form = true;

            initS2Types({
                objSelector: ('#AskwerForm_educational_institution_askwer_type_id_data'),
                data: []
            });
        } else if (typeView == 2) {//admin

            $modelAskwerInit.resetAll();
            $scope.dataManager.showManager = false;
            $($scope.dataManager.gridConfig.selectorCurrent + "-footer").show();
            $($scope.dataManager.gridConfig.selectorCurrent + "-header").show();
            if ($scope.dataManager.managerType == 1) {
                $scope.dataManager.managerMenuConfig.view = false;
                $scope.dataManager.managerType = null;

            } else {
                $scope.dataManager.managerMenuConfig.view = true;
            }
            $scope.viewsManager.admin = true;
        } else if (typeView == 3) {//update
            $scope.dataManager.showManager = true;
            $($scope.dataManager.gridConfig.selectorCurrent + "-footer").hide();
            $($scope.dataManager.gridConfig.selectorCurrent + "-header").hide();
            $scope.dataManager.managerMenuConfig.view = false;
            $scope.dataManager.managerType = 3;
            $scope.viewsManager.form = true;


        } else if (typeView == 4) {//update

            $($scope.dataManager.gridConfig.selectorCurrent + "-footer").hide();
            $($scope.dataManager.gridConfig.selectorCurrent + "-header").hide();
            $scope.dataManager.managerMenuConfig.view = false;
            $scope.dataManager.managerType = 4;

            $scope.viewsManager.managerForm = true;
        }
    };

}

var initS2TypesData = false;

function initS2Types(params) {

    var el = params.objSelector;
    var data = params.data;
    var dataCurrent = [];
    if (data.length > 0) {
        dataCurrent = data;
    }
    if (initS2TypesData) {
        $(el).select2('destroy');
        initS2TypesData = false;
    }
    var elementInit = $(el).select2({
        allow: true,
        placeholder: "Seleccione Aplicacion",
        data: dataCurrent,
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: $("#action-educational-institution-askwer-type-getListSelect2").val(),
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                var paramsFilters = {filters: {search_value: term, business_id: business_id}};
                return paramsFilters;
            },
            processResults: function (data, page) {
                return {results: data};
            }
        },
        allowClear: true,
        multiple: false,
        width: '100%'
    });
    elementInit.on('select2:select', function (e) {
        var data = e.params.data;
        /*_this.model.attributes.lodging_type_of_room_id_data = data;*/

        $modelAskwerInit.setValues({
            nameAttributes: 'educational_institution_askwer_type_id_data',
            valueAttributes: data,

        });
        $('#AskwerForm_educational_institution_askwer_type_id').val(data.id);
    }).on("select2:unselecting", function (e) {
        $modelAskwerInit.setValues({
            nameAttributes: 'educational_institution_askwer_type_id_data',
            valueAttributes: null,

        });
        $('#AskwerForm_educational_institution_askwer_type_id').val(null);

    });
    initS2TypesData = true;

}

$(function () {
    /*  https://craftpip.github.io/jquery-confirm/*/

    removeClassNotView();
    initManagerKO();
});

function initManagerKO() {
    $.fn.editable.defaults.mode = 'inline';
    $modelAskwerInit = new AskwerViewModel({business_id: business_id});
    ko.applyBindings($modelAskwerInit);
    $('textarea').autosize();
    $('#askwer-form-form').validate();
    $('a#show-preloaded-fields').fancybox({'hideOnOverlayClick': false, 'showCloseButton': false});
    validacionCampoMaximoRating();
}
