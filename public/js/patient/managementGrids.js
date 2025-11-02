var dataTable1;
var dataTable2;
var odontogramByPatientId;
var currentTreatmentPlanByPatient;

function initGridsStep2() {
    var history_clinic_id = 0;
    initAntecedent();
    initClinicalExam();
    // dataTable1 = initDatableAjax($('#admin_antecedent_by_history_clinic'), {
    //     ajax: {
    //         url: $('#action_admin_antecedents').val(),
    //         method: 'GET',
    //         params: {history_clinic_id: history_clinic_id, patient_id: patient_id}
    //     },
    //     pageSize: 10,
    //     columns: [
    //         {
    //             field: "antecedent_id",
    //             title: "Antecedente",
    //             sortable: 'asc',
    //             filterable: false,
    //             width: 150
    //         },
    //         {
    //             field: "has_antecedent",
    //             title: "Tipo Antecedente",
    //             sortable: 'asc',
    //             width: 150
    //         },
    //
    //         {
    //             field: "",
    //             width: 110,
    //             title: "Acciones",
    //             sortable: false,
    //             overflow: "visible",
    //             template: function (t) {
    //                 return '<a href="javascript:;" onclick="editRegisterByType(' + t.id + "," + "'antecedent_by_history_clinic'" + "," + "'antecedentByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
    //
    //             }
    //         }
    //     ]
    // });

    // dataTable2 = initDatableAjax($('#admin_clinical_by_history_clinic'), {
    //     ajax: {
    //         url: $('#action_admin_clinical_exams').val(),
    //         method: 'GET',
    //         params: {history_clinic_id: history_clinic_id, patient_id: patient_id}
    //     },
    //     pageSize: 10,
    //     columns: [
    //         {
    //             field: "clinical_exam_name",
    //             title: "Examen Clinico",
    //             sortable: 'asc',
    //             filterable: false,
    //             width: 150
    //         },
    //         {
    //             field: "pathology_description",
    //             title: "Descripcion Patologia",
    //             sortable: 'asc',
    //             width: 150
    //         },
    //
    //         {
    //             field: "",
    //             width: 110,
    //             title: "Acciones",
    //             sortable: false,
    //             overflow: "visible",
    //             template: function (t) {
    //                 return '<a href="javascript:;" onclick="editRegisterByType(' + t.id + "," + "'clinical_by_history_clinic'" + "," + "'clinicalByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
    //
    //             }
    //         }
    //     ]
    // });


}

var mGridInit = function (t, e) {
    var a = this, n = mUtil.get(t);
    var objectInit;
    if (n) {
        var o = {startStep: 1, manualStepForward: !1}, l = {
            construct: function (t) {
                return l.init(t)
            }, init: function (t) {
                return initGridByParams(e);

            }, build: function () {
                return initGridByParams(e);
            }
        };
        return a.setDefaults = function (t) {
            o = t
        }, l.construct.apply(a, [e]), a
    } else {
        alert("no that element");
    }

    function initGridByParams(params_bootgrid_admin) {
        objectInit = initGridEntidad(params_bootgrid_admin);
    }
};


var gridConfigurations = function GridManagement() {
    var functionsObjThis = {
        odontogramByPatient: function () {
            var currentId;
            return {
                init: function (dataParams) {
                    var initFirst = true;
                    var grid1 = dataParams;
                    var paramsGrid = {};
                    var element = grid1.element2;
                    var url_admin = grid1.action;
                    var filters = {patient_id: patient_id};
                    var $btn_personalizado_object = {};

                    var formatter_items =
                        {
                            'status': function (column, row) {
                                var key_id = row.id;
                                var lbl = "Inactivo";
                                var classBadge = "m-badge--danger";
                                if (row.status == "ACTIVE") {
                                    lbl = "Activo";
                                    classBadge = "m-badge--success";
                                }
                                return '<span class="m-badge ' + classBadge + ' m-badge--wide m-badge--badge-status">' + lbl + '</span>';
                            }
                        };
                    var initGrid = new mGridInit(
                        element,
                        {
                            init_ajax: true,
                            method: "POST",
//        --------url compuest modal------
                            element: "#" + element,
                            url_get_data: url_admin,
                            object_formater: formatter_items,
                            grid_id: "#" + element,
                            filters: filters,
                            rowSelect: true,
                            selection: true,
                            keepSelection: false,
                            rowCount: 10,
                            loaded: function () {
                                $(".select-cell").hide();
                                var objectGrid = this.grid_obj;
                                /* ---------REINICIAR ALL MANAGEMENT PIEZAS ODONTOGRAM---*/
                                /*  formularios*/
                                var formManagerElement = $("#dentalPieceByOdontogram_form");
                                initForms.dentalPieceByOdontogram().resetForm(formManagerElement);
                                /*              //odontogram
                                              var paramsData = {init: false};
                                              OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);*/
                                initFirst = false;
                                if (!OdontogramByPatient.getInitEventGrid()) {//evita iniciar eventos propios del api
                                    objectGrid.on("click.rs.jquery.bootgrid", function (e, cols, PlainObject) {
                                        var selectArray = objectGrid.bootgrid("getSelectedRows");
                                        if (cols) {
                                            if (selectArray.length) {//sleccionado
                                                var paramsData = {PlainObject: PlainObject, init: true};
                                                functionsObjThis.odontogramByPatient().resetEvents(false, paramsData);

                                            } else {//deseleccionado
                                                var paramsData = {init: false};
                                                functionsObjThis.odontogramByPatient().resetEvents(true, paramsData);
                                            }

                                        }

                                    });
                                    objectGrid.on("select.rs.jquery.bootgrid", function (e, selectedRows) {
                                        console.log("select row", e, selectedRows);

                                    });
                                    objectGrid.on("deselected.rs.jquery.bootgrid", function (e, deselectedRows) {
                                        console.log("click deselected", e, deselectedRows);

                                    });
                                    OdontogramByPatient.setInitEventGrid(true);
                                }

                            }, load: function () {//antes d traer los datos
                                var paramsData = {init: false};
                                if (!initFirst) {
                                    functionsObjThis.odontogramByPatient().resetEvents(true, paramsData);
                                    initFirst = false;
                                }
                            }, initialized: function () {

                            }

                        }
                    );
                }, resetEvents: function (reset, data = null) {
                    var paramsInit = OdontogramByPatient.getParamsInit();
                    var elementEvent = $(".m-portlet__nav-item-update-admin_" + paramsInit.managementEntity);
                    if (reset) {
                        elementEvent.removeAttr("data-row-id");
                        elementEvent.addClass("hide-element");
                        functionsObjThis.odontogramByPatient().setCurrentId(null);
                    } else {
                        var id = data.PlainObject.id;
                        elementEvent.attr("data-row-id", id);
                        elementEvent.removeClass("hide-element");
                        functionsObjThis.odontogramByPatient().setCurrentId(id);
                    }
                    var paramsData = data;
                    OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);
                }, setCurrentId: function (id) {
                    odontogramByPatientId = id;
                }
                , getCurrentId: function () {
                    return odontogramByPatientId;
                }
            };
        }, treatmentPlanByPatient: function () {
            var currentId;
            return {
                init: function (dataParams) {
                    var initFirst = true;
                    var grid1 = dataParams;
                    var paramsGrid = {};
                    var element = grid1.element2;
                    var url_admin = grid1.action;
                    var filters = {patient_id: patient_id};
                    var $btn_personalizado_object = {};
                    var formatter_items =
                        {
                            'status': function (column, row) {
                                var key_id = row.id;
                                var lbl = "Inactivo";
                                var classBadge = "m-badge--danger";
                                if (row.status == "ACTIVE") {
                                    lbl = "Activo";
                                    classBadge = "m-badge--success";
                                }
                                return '<span class="m-badge ' + classBadge + ' m-badge--wide m-badge--badge-status">' + lbl + '</span>';
                            }
                        };
                    var initGrid = new mGridInit(
                        element,
                        {
                            init_ajax: true,
                            method: "POST",
//        --------url compuest modal------
                            element: "#" + element,
                            url_get_data: url_admin,
                            object_formater: formatter_items,
                            grid_id: "#" + element,
                            filters: filters,
                            rowSelect: true,
                            selection: true,
                            keepSelection: false,
                            loaded: function () {
                                var currentManagementInit = TreatmentPlanByPatient;
                                $(".select-cell").hide();
                                var objectGrid = this.grid_obj;
                                /* ---------REINICIAR ALL MANAGEMENT PIEZAS ODONTOGRAM---*/
                                /*  formularios*/
                                var formManagerElement = $("#dentalPieceByOdontogram_form");
                                initForms.dentalPieceByOdontogram().resetForm(formManagerElement);
                                initFirst = false;
                                if (!currentManagementInit.getInitEventGrid()) {//evita iniciar eventos propios del api

                                    objectGrid.on("click.rs.jquery.bootgrid", function (e, cols, PlainObject) {
                                        var selectArray = objectGrid.bootgrid("getSelectedRows");
                                        if (cols) {
                                            if (selectArray.length) {//sleccionado
                                                var paramsData = {PlainObject: PlainObject, init: true};
                                                functionsObjThis.treatmentPlanByPatient().resetEvents(false, paramsData);

                                            } else {//deseleccionado
                                                var paramsData = {init: false};
                                                functionsObjThis.treatmentPlanByPatient().resetEvents(true, paramsData);
                                            }

                                        }

                                    });
                                    objectGrid.on("select.rs.jquery.bootgrid", function (e, selectedRows) {
                                        console.log("select row", e, selectedRows);

                                    });
                                    objectGrid.on("deselected.rs.jquery.bootgrid", function (e, deselectedRows) {
                                        console.log("click deselected", e, deselectedRows);

                                    });
                                    currentManagementInit.setInitEventGrid(true);
                                }

                            }, load: function () {//antes d traer los datos
                                var paramsData = {init: false};
                                if (!initFirst) {
                                    functionsObjThis.treatmentPlanByPatient().resetEvents(true, paramsData);
                                    initFirst = false;
                                }
                            }

                        }
                    );
                }, resetEvents: function (reset, data = null) {
                    var paramsInit = TreatmentPlanByPatient.getParamsInit();
                    var elementEvent = $(".m-portlet__nav-item-update-admin_" + paramsInit.managementEntity);
                    var elementEventView = $(".m-portlet__nav-item-view-admin_" + paramsInit.managementEntity);

                    if (reset) {
                        elementEvent.removeAttr("data-row-id");
                        elementEvent.addClass("hide-element");

                        elementEventView.removeAttr("data-row-id");
                        elementEventView.addClass("hide-element");
                        functionsObjThis.treatmentPlanByPatient().setCurrentId(null);
                    } else {
                        var id = data.PlainObject.id;
                        elementEvent.attr("data-row-id", id);
                        elementEvent.removeClass("hide-element");
                        elementEventView.attr("data-row-id");
                        elementEventView.removeClass("hide-element");
                        functionsObjThis.treatmentPlanByPatient().setCurrentId(id);
                    }
                    var paramsData = data;
                }, setCurrentId: function (id) {
                    currentTreatmentPlanByPatient = id;
                }
                , getCurrentId: function () {
                    return currentTreatmentPlanByPatient;
                }
            };
        }, treatmentPlanByPatientForm: function () {
            var currentId;
            var currentObjGrid;
            var objThis;
            var bootgridElementInit;
            return objThis = {
                init: function (dataParams) {
                    var currentManagementInit = TreatmentPlanByPatientForm;
                    var initFirst = true;
                    var grid1 = dataParams;
                    var paramsGrid = {};
                    var element = grid1.element;
                    var $btn_personalizado_object = {};
                    bootgridElementInit = $("#" + element);
                    var formatter_items =
                        {
                            'remove-item': function (column, row) {
                                var key_id = row.id;
                                return '<a data-row-id="' + key_id + '"class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill remove-item-grid" title="Eliminar"><i class=" far fa-trash-alt"></i></a>';
                            }
                        };
                    var initGrid = new mGridInit(
                        element,
                        {

//        --------url compuest modal------
                            element: "#" + element,
                            object_formater: formatter_items,
                            grid_id: "#" + element,
                            rowCount: -1,
                            loaded: function () {
                                $.each($("#" + element + "-header").find("ul li"), function (i, v) {
                                    if ($(v).find("input[name=treatment_id]").length || $(v).find("input[name=discount]").length || $(v).find("input[name=remove-item]").length) {
                                        $(v).hide();
                                    }
                                });
                                $(".select-cell").hide();
                                var objectGrid = this.grid_obj;
                                /* ---------REINICIAR ALL MANAGEMENT PIEZAS ODONTOGRAM---*/
                                /*  formularios*/
                                var formManagerElement = $("#dentalPieceByOdontogram_form");
                                initForms.dentalPieceByOdontogram().resetForm(formManagerElement);
                                initFirst = false;
                                objectGrid.find(".remove-item-grid").on("click", function (e) {
                                    self = $(this);//esto es un elemento jquery puedes ir alos valores d este element
                                    var data_row_id = self.data("row-id");//
                                    objThis.deleteRow(objectGrid, data_row_id);
                                    initForms.treatmentPlanByPatient().modifyObjAuxSave(data_row_id);
                                }).end();
                                initForms.treatmentPlanByPatient().setValuesFormByAddTreatment(objectGrid);

                            }, load: function () {//antes d traer los datos

                            }, initialized: function () {
                                if (!initForms.treatmentPlanByPatient().isUpdate()) {
                                    if ($("#treatment_detail_by_treatment_data_aux").val() != "") {

                                        bootgridElementInit.bootgrid('append', JSON.parse($("#treatment_detail_by_treatment_data_aux").val()));
                                    }

                                }
                            }

                        }
                    );
                }, resetEvents: function (reset, data = null) {

                }, setCurrentId: function (id) {
                    odontogramByPatientId = id;
                }
                , getCurrentId: function () {
                    return odontogramByPatientId;
                }, deleteRow: function (objGrid, row_id) {
                    deleteRowBootgrid(objGrid, row_id);
                }, searchDeleteState: function () {

                }
            };
        }

    };

    return functionsObjThis;
}


function initAntecedent() {
    var config = {
        processing: true,
        ajax: {
            url: $('#action_admin_antecedents').val() + '/' + current_patient,
        },
        columns: [
            {"data": "name"},
            {
                "data": "status",
                'render': function (data, type, full, meta) {
                    console.log('aaaaaaaa');
                    console.log(data);
                    if (data === 1) {
                        return '<span class="label label-sm label-success">SI</span>';
                    } else {
                        return '<span class="label label-sm label-warning">NO</span>';
                    }
                }
            },
            {
                "data": "id",
                'render': function (data, type, full, meta) {
                    return '<a href="javascript:;" onclick="editRegisterByType(' + data + "," + "'antecedent_by_history_clinic'" + "," + "'antecedentByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';

                }
            },
        ],

    };
    dataTable1 = initDataTableAjax($('#admin_antecedent_by_history_clinic'), config);

    // $('#admin_antecedent_by_history_clinic tbody').on( 'click', 'tr', function () {
    //     if ( $(this).hasClass('selected') ) {
    //         $(this).removeClass('selected');
    //
    //     }
    //     else {
    //         dataTable.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
    //         console.log('clik')
    //
    //     }
    // } );

}

function initClinicalExam() {
    var config = {
        processing: true,
        ajax: {
            url: $('#action_admin_clinical_exams').val() + '/' + current_patient,
        },
        columns: [
            {"data": "name"},
            {"data": "description"},
            {
                "data": "id",
                'render': function (data, type, full, meta) {
                    return '<a href="javascript:;" onclick="editRegisterByType(' + data + "," + "'clinical_by_history_clinic'" + "," + "'clinicalByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                }
            },
        ],

    };
    dataTable2 = initDataTableAjax($('#admin_clinical_by_history_clinic'), config);

    // $('#admin_antecedent_by_history_clinic tbody').on( 'click', 'tr', function () {
    //     if ( $(this).hasClass('selected') ) {
    //         $(this).removeClass('selected');
    //
    //     }
    //     else {
    //         dataTable.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
    //         console.log('clik')
    //
    //     }
    // } );

}

function initDataTableAjax(el, config) {
    el.dataTable().fnDestroy();

    var ajax_config = {};
    if (typeof  config.ajax !== 'undefined') {
        ajax_config = config.ajax;
    } else {
        ajax_config.url = config.url
    }


    return el.DataTable({
        processing: config.processing ? config.processing : false,
        serverSide: config.serverSide ? config.serverSide : false,
        ajax: ajax_config,
        // ajax: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
        language: {
            sProcessin: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            },
            lengthMenu: "  _MENU_ marcas"
        },
        // lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
        pageLength: 10,
        // pagingType: "full_numbers",
        order: [
            [0, "asc"]
        ],
        columnDefs: [
            {
                targets: 'actions',
                orderable: false,
                render: function (data, type, row, meta) {
                    var actions = '';
                    if (typeof config.actions !== 'undefined') {
                        config.actions.forEach(function (action) {
                            actions += '<a href="#" onclick="' + action.js_handle + '(' + row.id + ')"  ' +
                                'class="btn default btn-xs ' + action.color_btn + '" title="' + action.label + '" >' + action.icon + ' ' + action.label + ' </a>';
                        });
                    }
                    return actions;
                }
            },
            {
                'targets': 'check',
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox">';
                }
            }
        ],
        deferRender: true,

        columns: config.columns,
        rowCallback: function (row, data, dataIndex) {
            if (typeof config.rowCallback !== 'undefined' && typeof config.rowCallback === 'function') {
                config.rowCallback(row, data, dataIndex);
            }
        },
        initComplete: function (settings, json) {
            if (typeof config.initComplete !== 'undefined' && typeof config.initComplete === 'function') {
                config.initComplete(settings, json);
            }
        },
        drawCallback: function (settings) {
            var api = this.api();
            if (typeof config.drawCallback !== 'undefined' && typeof config.drawCallback === 'function') {
                config.drawCallback(settings, api);
            }
        }
    });

}
