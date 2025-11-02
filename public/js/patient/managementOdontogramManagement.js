/*STEPS*/
/*1) CREACION DE ACCIONES*/
/*2) CREACION DE MODELO*/
/*3) CREACION DE CONTROLER*/
/*4) CREACION DE VISTAS*/
/*5) Asignaciones a sus acciones inputhide*/
/*6) Importar o realizar  inicializacion de funciones*/
var managementOdontogram = function ManagamentOdontogram(params) {
    /*  -----------INIT MANAGEMENT ODONTOGRAM---*/
    var initEventPortlet = false;
    var initEventGrid = false;

    var params = params;
    var managementEntityThis;//odontogram_by_patient
    var managementFrmThis;//odontogramByPatient
    var paramsInit;
    var allowManagement = true;
    if (typeof params !== "undefined") {
        if (mUtil.isset(params, "managementEntity") && mUtil.isset(params, "managementFrm")) {
            managementEntityThis = params.managementEntity;
            managementFrmThis = params.managementFrm;
            paramsInit = {managementEntity: managementEntityThis, managementFrm: managementFrmThis};
        } else {
            allowManagement = false;
        }
    } else {
        allowManagement = false;
    }

    var functionsObj = {
        initPortletEvents: function () {
            if (allowManagement) {
                initEventPortlet = true;
                let objectInstance = this;
                let managementTbl = managementEntityThis;
                let managementFrm = managementFrmThis;
                var e;
                var elementInitName = "m_portlet_admin_" + managementTbl;
                toastr.options.showDuration = 1e3,
                    (e = new mPortlet(elementInitName)).on("beforeCollapse", function (e) {

                    }),
                    e.on("afterCollapse", function (e) {

                    }),
                    e.on("beforeExpand", function (e) {

                    }),
                    e.on("afterExpand", function (e) {

                    }),
                    e.on("reload", function (e) {

                    }),
                    e.on("afterFullscreenOn", function (e) {
                        OdontogramView.afterFullScreenOn();
                    }),
                    e.on("afterFullscreenOff", function (e) {
                        OdontogramView.afterFullScreenOff();
                    });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {

                    var type = managementTbl;
                    var entityFrm = managementFrm + "_form"
                    var modalElement = $("#modal_" + type);
                    var formManagerElement;
                    formManagerElement = ("#" + entityFrm);
                    var validateFormFunction;
                    var action = $('#action_new-register_' + managementTbl).val();

                    modalElement.find('.modal-title').html('Agregar Odontograma');
                    validateFormFunction = initForms.odontogramByPatient();
                    let params = {
                        action: action,
                        validateFormFunction: validateFormFunction,
                        modalElement: modalElement,
                        formManagerElement: formManagerElement,
                        request: {
                            data: {patient_id: patient_id},
                        }
                    }
                    getModalByParams(params);
                });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=update-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {
                    var data_row_id = initGrids.odontogramByPatient().getCurrentId();
                    if (data_row_id) {
                        editOdontogram(data_row_id);
                    }


                });
                if (!functionsObj.getInitEventGrid()) {

                    this.initGrids();
                }
            } else {
                alert("params invalid init");
            }

        }, initGrids: function () {
            if (allowManagement) {
                var grid1 = {
                    element: "#admin_" + managementEntityThis,
                    element2: "grid-admin_" + managementEntityThis,

                    action: $('#action_admin_' + managementEntityThis).val(),
                    params: {history_clinic_id: history_clinic_id, patient_id: patient_id}
                };
                initGrids.odontogramByPatient().init(grid1);

            } else {
                alert("params init invalid");
            }
        }
        , editRowInfo: function (params) {
            console.log('params'), params;
        },
        getParamsManagementEdit: function (rowId) {

            var type = managementEntityThis;
            var entityFrm = managementFrmThis + "_form"
            var modalElement = $("#modal_" + type);
            var formManagerElement;
            formManagerElement = ("#" + entityFrm);
            var validateFormFunction;
            var action = $('#action_new-register_' + managementEntityThis).val();
            modalElement.find('.modal-title').html('Actualizar Odontograma');
            validateFormFunction = initForms.odontogramByPatient();

            result = {
                action: action,
                validateFormFunction: validateFormFunction,
                modalElement: modalElement,
                formManagerElement: formManagerElement,
                request: {
                    data: {id: rowId, patient_id: patient_id},
                }
            };


            return result;
        }, getInitEventPortlet: function () {
            return initEventPortlet;
        }, getInitEventGrid: function () {
            return initEventGrid;
        }, setInitEventGrid: function (value) {
            initEventGrid = value;
        }, initDentalPieceByOdontogramFrm: function (params) {
            var entityTbl = "dentalPieceByOdontogram";
            var entityTblName = "dental_piece_by_odontogram";
            var entityFrm = entityTbl + "_form"
            var modalElement = $("#modal_" + entityTblName);
            var formManagerElement;
            formManagerElement = $("#" + entityFrm);
            initForms.dentalPieceByOdontogram().resetForm(formManagerElement);
            initForms.dentalPieceByOdontogram().init(formManagerElement, params);
        }, resetDentalPieceByOdontogramFrm: function () {

        }, resetDentalPieceByOdontogramFrm: function () {

        }, initOdontogramDentalPieceByOdontogram: function (params) {
            OdontogramView.clearOdontogramsSvg();
            if (params.init) {
                var id = params.PlainObject.id;
                odontogram_by_patient_id = id;
                $(".content-render-odontogram").show();
                OdontogramView.getDataDentalPieceByOdontogramId(id);
            } else {
                $(".content-render-odontogram").hide();

            }

        }, getParamsInit: function () {

            return params;
        }


    };
    return functionsObj;
};

/*---------GRID MANAGAMENT--*/
function editOdontogram(id) {
    getModalByParams(OdontogramByPatient.getParamsManagementEdit(id));
}

