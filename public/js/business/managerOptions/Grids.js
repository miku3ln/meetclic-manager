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

var mGridInit = function (t, e) {
    var a = this, n = mUtil.get(t);
    var objectInit;
    if (n) {
        var o = {startStep: 1, manualStepForward: !1}, l = {
            construct: function (t) {
                return mUtil.data(n).has("bootgrid") ? a = mUtil.data(n).get("bootgrid") : (l.init(t), l.build(), mUtil.data(n).set("bootgrid", a)), a
            }, init: function (t) {
                initGridByParams(e);
            }, build: function () {
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

var dataTable1;
var dataTable2;

$(function () {


});

function editRegisterByType(id, type, entityFrm) {

    var modalElement = $("#modal_" + type);
    var formManagerElement;
    formManagerElement = ("#" + entityFrm);
    var validateFormFunction;
    var action = $('#action_new-register_' + type).val();
    if (type == "antecedent_by_history_clinic") {
        modalElement.find('.modal-title').html('Actualizar Antecedente');
        validateFormFunction = validateAntecedent;
    }
    if (type == "clinical_by_history_clinic") {
        modalElement.find('.modal-title').html('Actualizar Examen Clinico');
        validateFormFunction = validateClinical;
    }
    let params = {
        action: action,
        validateFormFunction: validateFormFunction,
        modalElement: modalElement,
        formManagerElement: formManagerElement,
        request: {
            data: {id: id, patient_id: 1},
        }
    }
    getModalByParams(params);
}

