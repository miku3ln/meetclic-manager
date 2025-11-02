/*STEPS*/
/*1) CREACION DE ACCIONES*/
/*2) CREACION DE MODELO*/
/*3) CREACION DE CONTROLER*/
/*4) CREACION DE VISTAS*/
/*5) Asignaciones a sus acciones inputhide*/
/*6) Importar o realizar  inicializacion de funciones*/
function ManagementTreatmentPlanByPatientForm(params) {
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
                    console.log("create");
                });
                var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=update-register]");
                nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {
                    console.log("edit");
                });
                if (!functionsObj.getInitEventGrid()) {
                    this.initGrids();
                }
            } else {
                alert("params invalid init");
            }

        }, initGrids: function () {
            if (allowManagement) {
                var gridParams = {
                    element: "grid-admin_" + managementEntityThis,
                };
                initGrids.treatmentPlanByPatientForm().init(gridParams);

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
            var id = params.id;
            odontogram_by_patient_id = id;
            var data = params.data;
            OdontogramView.setValuesOdontogramsSvg(data);
            functionsObj.viewOdontogram(true)
        }, getParamsInit: function () {

            return params;
        }, viewOdontogram: function (view) {
            if (view) {
                $(".content-render-odontogram").show();
            } else {
                $(".content-render-odontogram").hide();
            }


        },initValidationFrm:function(){
            var initParams  =functionsObj.getParamsInit()
            validateFormFunction = initForms.treatmentPlanByPatient();
            var frmValidation="#"+initParams.managementFrm+"_form";
            var frmObj=$(frmValidation);
            var paramsData;
            validateFormFunction.init(frmObj,paramsData);
        }


    };
    return functionsObj;
};
