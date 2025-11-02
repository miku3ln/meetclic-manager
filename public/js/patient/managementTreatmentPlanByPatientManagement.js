/*STEPS*/
/*1) CREACION DE ACCIONES*/
/*2) CREACION DE MODELO*/
/*3) CREACION DE CONTROLER*/
/*4) CREACION DE VISTAS*/
/*5) Asignaciones a sus acciones inputhide*/

/*6) Importar o realizar  inicializacion de funciones*/

function ManagementTreatmentPlanByPatient(params) {
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

                    }),
                    e.on("afterFullscreenOff", function (e) {


                    });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {
                    var entityCurrent = "treatmentPlanByPatientForm";
                    var action = $(this).attr("action");
                    var params = {action: action + "/" + patient_id, type: "GET", typeManagement: entityCurrent};
                    ManagementObj.loadDataByAjax(params);
                });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=update-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {
                    var entityCurrent = "treatmentPlanByPatientUpdate";
                    var action = $(this).attr("action");
                    var data_row_id = initGrids.treatmentPlanByPatient().getCurrentId();
                    var action = $(this).attr("action");
                    var params = {
                        action: action + "/" + patient_id + "/" + data_row_id,
                        type: "GET",
                        typeManagement: entityCurrent
                    };
                    ManagementObj.loadDataByAjax(params);
                });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=view-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {
                    var entityCurrent = "treatmentPlanByPatientView";
                    var action = $(this).attr("action");
                    var data_row_id = initGrids.treatmentPlanByPatient().getCurrentId();
                    var action = $(this).attr("action");
                    var params = {
                        action: action + "?patient_id" + patient_id + "&treatment_plan_by_patient_id?=" + data_row_id,
                        type: "GET",
                        typeManagement: entityCurrent
                    };
                    ManagementObj.loadDataByAjax(params);
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
                initGrids.treatmentPlanByPatient().init(grid1);

            } else {
                alert("params init invalid");
            }
        }
        , editRowInfo: function (params) {
            console.log('params'), params;
        }, getInitEventPortlet: function () {
            return initEventPortlet;
        }, getInitEventGrid: function () {
            return initEventGrid;
        }, setInitEventGrid: function (value) {
            initEventGrid = value;
        }, getParamsInit: function () {
            return params;
        }


    };
    return functionsObj;
};
