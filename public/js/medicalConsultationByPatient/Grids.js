var gridCHHC;
var gridCHHCManagement = [];
var gridCHHCManagementIds = [];
var managementCHHC;

var gridAHHC;
var gridAHHCManagement;
var gridAHHCNCManagementIds = [];
var gridAHHCSNManagementIds = [];
var managementAHHC;

var mBootGridManagement = function (elementGrid, params = null) {
    node = mUtil.get(elementGrid);
    var objectCurrent = this;
    var keysSelectedBootgrid;
    var currentElementGrid = elementGrid;
    var currentParams = params;
    var gridName = elementGrid;
    functionsObj = {
        getCurrentRows: function (grid) {
            return grid.bootgrid("getCurrentRows");
        }, getCurrentPage: function (grid) {
            return grid.bootgrid("getCurrentPage");
        },
        managementHasAntecedent: function (gridId, selectDataSN, selectDataNC) {
//        -----Obtener los datos del paginado---
            var data_rows_page = this.getCurrentRows(gridId);
//        ---obtiene el ide dl paginado---
            var page_id = this.getCurrentPage(gridId);
//initUniqueCheckbox();
            // SN
            var element = setElementValue(selectDataSN);
            var array_page_select = getSelectAllPag(selectDataSN, data_rows_page);
            setPropByData(selectDataSN, "sn");
            setPropAll(page_id, array_page_select, data_rows_page, "sn");
            //NC
            var element = setElementValue(selectDataNC);
            var array_page_select = getSelectAllPag(selectDataNC, data_rows_page);
            setPropByData(selectDataNC, "nc");
            setPropAll(page_id, array_page_select, data_rows_page, "nc");
            initGridEventsAHHC(gridId);
        },
        managementHasExamnClinic: function (gridId, dataPathology) {
//        -----Obtener los datos del paginado---
            var data_rows_page = this.getCurrentRows(gridId);
//        ---obtiene el ide dl paginado---
            var page_id = this.getCurrentPage(gridId);
            setValuesTxtArea(dataPathology);
            initGridEventsCHHC(gridId);
        }

    };
    return functionsObj;

    function removeKeySNNCBYParams(type, aguja) {

        if (type == "sn") {
            removeItemById(aguja, gridAHHCNCManagementIds);
        } else {
            removeItemById(aguja, gridAHHCSNManagementIds);

        }
    }

    function removeItemById(aguja, pajar) {
        var exist_data = $.inArray(aguja, pajar);
        if (exist_data >= 0) {//si no esta agregado agregar
            pajar.splice(pajar.indexOf(aguja), 1);
        }
    }


    // -------FUNCTIONS AHHC---
    function initGridEventsAHHC(objectGrid) {
        objectGrid.find(".has_antecedent").on("click", function (e) {
            self = $(this);//esto es un elemento jquery puedes ir alos valores d este element
            var instance_data_rows = getDataInstanciaBootgrid(objectGrid);
            var data_row_id = self.data("row-id");//
            var data_row_type = self.data("row-type");//
            var data_rows_page = functionsObj.getCurrentRows(objectGrid);
            var page_id = functionsObj.getCurrentPage(objectGrid);
            var prop_element = self.prop('checked');
            if (prop_element) {//solo debe haber uno seleccioado
                removeKeySNNCBYParams(data_row_type, data_row_id);
                if (data_row_type == "sn") {
                    setPropCheckElement("nc", data_row_id, false);
                } else {
                    setPropCheckElement("sn", data_row_id, false);
                }
            }
            initManagementAHHC(data_row_id, data_row_type, "", self, data_rows_page, page_id);
        }).end();
    }

    function initCheckboxSNNC(page_id, gridManagementsId, data_rows_page, type) {
        var array_page_select = getSelectAllPag(gridManagementsId, data_rows_page);
        setPropAll(page_id, array_page_select, data_rows_page, type);
    }

    function initManagementAHHC(id, type, value, self, data_rows_page, page_id) {
        var key_element = id;//obtener el elemento clickeado
        var key_element_value = id;//obtener el elemento clickeado
        var prop_element = self.prop('checked');
        var element_array = [];
        if (key_element_value == "all") {//todo seleccionar todos
        } else {
            element_array.push(key_element_value);
            if (type == "sn") {
                if (prop_element == false) {//deseleccionar|
                    gridAHHCSNManagementIds = removeDataArray(element_array, gridAHHCSNManagementIds);
                } else {//seleecciono
                    gridAHHCSNManagementIds = setDataArray(element_array, gridAHHCSNManagementIds);
                }
            } else {
                if (prop_element == false) {//deseleccionar|
                    gridAHHCNCManagementIds = removeDataArray(element_array, gridAHHCNCManagementIds);
                } else {//seleecciono
                    gridAHHCNCManagementIds = setDataArray(element_array, gridAHHCNCManagementIds);
                }
            }
        }
    }

    function getDataRows(data_rows) {
        var element_array = [];
        $.each(data_rows, function (index, value) {
            element_array.push(value.id);
        });
        return element_array;
    }

    //---remueve datos del array agregado los valores
    function removeDataArray(data_remove, pajar) {
        $.each(data_remove, function (index, value) {
            var exist_data = $.inArray(value, pajar);
            if (exist_data >= 0) {//si no esta agregado agregar
                pajar.splice(pajar.indexOf(value), 1);
            }
        });
        return pajar;
    }

//---agrgar datos al arreglo la informacion ---
    function setDataArray(data_add, pajar) {
        $.each(data_add, function (index, value) {
            var exist_data = $.inArray(value, pajar);
            if (exist_data == -1) {//si no esta agregado agregar
                pajar.push(value);
            }
        });
        return pajar;
    }

    function getSelectAllPag(data_all, data_row) {
        var element_array = [];
        $.each(data_row, function (index, value_1) {
            var exist_data = $.inArray(value_1.id, data_all);
            if (exist_data >= 0) {//si no esta agregado agregar
                element_array.push(value_1.id);
            }
        });
        return element_array;
    }

    function setPropAll(key_element, all_selected, row_data, column) {
        var checked = false;
        if (all_selected.length == row_data.length) {//si es igual select all
            checked = true;
        }
        $("#checkbox-all-" + column + "-" + key_element).prop('checked', checked);
    }

    function setPropCheckElement(column, key_element, prop) {
        $("#checkbox-" + column + "-" + key_element).prop('checked', prop);
    }

//-----------NEWS FUNCTIONS--
//SELECT BOOTGRID

//---asigna los valores seleccionados en el grid agregando un chek---
    function setPropByData(data_add, column) {
        $.each(data_add, function (index, value) {
            key_element = value;
            setPropCheckElement(column, key_element, true);
        });
    }

    function setElementValue(data_rows) {
        var select_add = data_rows.join(",");
        return select_add;
    }


    function initUniqueCheckbox(gridName) {
        //        ------Realizar l cambio del html del encabezado----- unicamente la primera col del encabezado
//debido a q es la primera columna dond s asigna los check
        element_modificar = $("#" + gridName + " thead tr th:first-child");
        var string_html = '<input class="checkbox-select" id="checkbox-all-' + page_id + '"  type="checkbox" value="all">'
//        --------MEETODO PARA PODER GENERAR LA SELECCION-------
        element_modificar.html(string_html);
    }

    // -------FUNCTIONS CHHC---
    function initGridEventsCHHC(objectGrid) {
        objectGrid.find(".pathology_description").on("change", function (e) {
            self = $(this);//esto es un elemento jquery puedes ir alos valores d este element
            var instance_data_rows = getDataInstanciaBootgrid(objectGrid);
            var data_row_id = self.data("row-id");//
            var data_rows_page = functionsObj.getCurrentRows(objectGrid);
            var page_id = functionsObj.getCurrentPage(objectGrid);
            var valueTxtArea = self.val();

            var rowData = {};
            var exist_data = $.inArray(gridCHHCManagementIds, data_row_id);
            if (exist_data == -1) {//si no esta agregado agregar
                gridCHHCManagementIds.push(data_row_id);
                rowData = {id: data_row_id, value: valueTxtArea};
                gridCHHCManagement.push(rowData);
            } else {
                $.each(gridCHHCManagement, function (index, value_1) {
                    if (value_1.id == data_row_id) {
                        rowData = {id: data_row_id, value: valueTxtArea};
                        gridCHHCManagement[index] = rowData;
                    }
                });
            }


        }).end();
    }

    function setValuesTxtArea(data) {

        $.each(data, function (index, value_1) {
            var elementTxtArea = $("#pathology_description_" + value_1.id);
            elementTxtArea.val(value_1.value);
        });

    }
};

var dataTable1;
var dataTable2;

function initGridsStep2() {
    var history_clinic_id = 0;
    dataTable1 = initDatableAjax($('#admin_antecedent_by_history_clinic'), {
        ajax: {
            url: $('#action_admin_antecedents').val(),
            method: 'GET',
            params: {history_clinic_id: history_clinic_id, patient_id: patient_id}
        },
        pageSize: 10,
        columns: [
            /*{
                field: "antecedent_name",
                title: "Antecedente",
                sortable: 'asc',
                filterable: false,
                width: 150
            },*/
            {
                field: "has_antecedent",
                title: "Tipo Antecedente",
                sortable: 'asc',
                width: 150
            },

            {
                field: "",
                width: 110,
                title: "Acciones",
                sortable: false,
                overflow: "visible",
                template: function (t) {
                    return '<a href="javascript:;" onclick="editRegisterByType(' + t.id + "," + "'antecedent_by_history_clinic'" + "," + "'antecedentByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';

                }
            }
        ]
    });
    dataTable2 = initDatableAjax($('#admin_clinical_by_history_clinic'), {
        ajax: {
            url: $('#action_admin_clinical_exams').val(),
            method: 'GET',
            params: {history_clinic_id: history_clinic_id, patient_id: patient_id}
        },
        pageSize: 10,
        columns: [
            {
                field: "clinical_exam_name",
                title: "Examen Clinico",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
            {
                field: "pathology_description",
                title: "Descripcion Patologia",
                sortable: 'asc',
                width: 150
            },

            {
                field: "",
                width: 110,
                title: "Acciones",
                sortable: false,
                overflow: "visible",
                template: function (t) {
                    return '<a href="javascript:;" onclick="editRegisterByType(' + t.id + "," + "'clinical_by_history_clinic'" + "," + "'clinicalByHistoryClinic_form'" + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';

                }
            }
        ]
    });

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
            return {
                init: function (dataParams) {

                    var grid1 = dataParams;
                    var paramsGrid = {};
                    var element = grid1.element2;
                    var url_admin = grid1.action;
                    var filters = {patient_id: patient_id};
                    var $btn_personalizado_object = {};
                    var formatter_items =
                        {
                            'formatters-multiple-modificable': function (column, row) {
                                var key_id = row.id;
                                return '<span style="overflow: visible; width: 110px;"><a data-row-id="' + key_id + '" class="event-edit-row m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a></span>';
                            },
                            'status': function (column, row) {
                                var key_id = row.id;
                                var lbl = "Inactivo";
                                var classBadge = "m-badge--danger";
                                if (row.status == "ACTIVE") {
                                    lbl = "Activo";
                                    classBadge = "m-badge--success";
                                }
                                return '<span class="m-badge ' + classBadge + ' m-badge--wide">' + lbl + '</span>';
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
                                $(".select-cell").hide();
                                var objectGrid = this.grid_obj;
                                /* ---------REINICIAR ALL MANAGEMENT PIEZAS ODONTOGRAM---*/
                                /*  formularios*/
                                var formManagerElement = $("#dentalPieceByOdontogram_form");
                                initForms.dentalPieceByOdontogram().resetForm(formManagerElement);
                                //odontogram
                                var paramsData = {init: false};
                                OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);
                                var selectArray = objectGrid.bootgrid("getSelectedRows");
                                if (selectArray.length) {//sleccionado
                                    OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);
                                    var id = selectArray[0];
                                    $("tr[data-row-id='" + id + "']").click();
                                }

                                objectGrid.find(".event-edit-row").on("click", function (e) {
                                    self = $(this);//esto es un elemento jquery puedes ir alos valores d este element
                                    var instance_data_rows = getDataInstanciaBootgrid(objectGrid);
                                    var data_row_id = self.data("row-id");//
                                    var data_row_type = self.data("row-type");//
                                    editOdontogram(data_row_id);

                                }).end();
                                if (!OdontogramByPatient.getInitEventGrid()) {//evita iniciar eventos propios del api
                                    objectGrid.on("click.rs.jquery.bootgrid", function (e, cols, PlainObject) {
                                        if (cols) {
                                            var selectArray = objectGrid.bootgrid("getSelectedRows");
                                            if (selectArray.length) {//sleccionado
                                                var paramsData = {PlainObject: PlainObject, init: true};
                                                OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);
                                            } else {//deseleccionado
                                                var paramsData = {PlainObject: PlainObject, init: false};
                                                OdontogramByPatient.initOdontogramDentalPieceByOdontogram(paramsData);

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

                            }
                        }
                    );
                }
            };
        }

    };

    return functionsObjThis;
}
