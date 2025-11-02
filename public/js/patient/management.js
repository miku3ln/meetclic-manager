var managementElementContentAll;
var managementElementRender;
var MenuInit;
var OdontogramByPatient;
var patient_id;
var initForms;
var initGrids;
/*----ADD new--*/
var TreatmentPlanByPatient;
var TreatmentPlanByPatientForm;
var history_clinic_id;
var OdontogramView = new renderOdontograms();
var AntecedentsClinicalDocuments;
var dataTable1;
var dataTable2;

$(function () {

})

function initManagement() {


    var functionsObjThis = {
        initEventsByType: function (typeManagement, params = null) {
            console.log("init" + typeManagement);
            functionsObjThis.initTooltips(typeManagement, params );
            if (typeManagement == "odontogramByPatient") {
                var managementEntity = "odontogram_by_patient";
                var managementFrm = "odontogramByPatient";
                contentParentMeasure = "#m_portlet_admin_" + managementEntity;
                OdontogramView.initOdontogramsSvg();
                OdontogramByPatient = new managementOdontogram({
                    managementEntity: managementEntity,
                    "managementFrm": managementFrm
                });
                OdontogramByPatient.initPortletEvents();
            }
            else if (typeManagement == "treatmentPlanByPatient") {
                var managementEntity = "treatment_plan_by_patient";
                var managementFrm = "treatmentPlanByPatient";
                contentParentMeasure = "#m_portlet_admin_" + managementEntity;

                TreatmentPlanByPatient = new ManagementTreatmentPlanByPatient({
                    managementEntity: managementEntity,
                    "managementFrm": managementFrm
                });
                TreatmentPlanByPatient.initPortletEvents();
            }
            else if (typeManagement == "treatmentPlanByPatientForm") {
                var managementEntity = "treatment_plan_by_patient";
                var managementFrm = "treatmentPlanByPatient";
                contentParentMeasure = "#m_portlet_admin_" + managementEntity;

                TreatmentPlanByPatientForm = new ManagementTreatmentPlanByPatientForm({
                    managementEntity: managementEntity,
                    "managementFrm": managementFrm
                });
                TreatmentPlanByPatientForm.initPortletEvents();
                TreatmentPlanByPatientForm.initValidationFrm();
                OdontogramView.initOdontogramsSvg(function (result) {
                    var currentParams = {
                        init: params.data["allowData"],
                        data: params.data["DentalPieceByOdontogram"],
                        id: params.data["allowData"] ? params.data["OdontogramByPatient"].id : null,
                    };
                    TreatmentPlanByPatientForm.initOdontogramDentalPieceByOdontogram(currentParams);
                });


            }
            else if (typeManagement == "treatmentPlanByPatientView") {
                /*     var managementEntity = "treatment_plan_by_patient";
                     var managementFrm = "treatmentPlanByPatient";
                     contentParentMeasure = "#m_portlet_admin_" + managementEntity;

                     TreatmentPlanByPatientForm = new ManagementTreatmentPlanByPatientForm({
                         managementEntity: managementEntity,
                         "managementFrm": managementFrm
                     });
                     TreatmentPlanByPatientForm.initPortletEvents();
                     TreatmentPlanByPatientForm.initValidationFrm();
                     OdontogramView.initOdontogramsSvg(function (result) {
                         var currentParams = {
                             init: params.data["allowData"],
                             data: params.data["DentalPieceByOdontogram"],
                             id: params.data["allowData"] ? params.data["OdontogramByPatient"].id : null,
                         };
                         TreatmentPlanByPatientForm.initOdontogramDentalPieceByOdontogram(currentParams);
                     });*/


            }
            else if (typeManagement == "treatmentPlanByPatientUpdate") {
                var managementEntity = "treatment_plan_by_patient";
                var managementFrm = "treatmentPlanByPatient";
                contentParentMeasure = "#m_portlet_admin_" + managementEntity;

                TreatmentPlanByPatientForm = new ManagementTreatmentPlanByPatientForm({
                    managementEntity: managementEntity,
                    "managementFrm": managementFrm
                });
                TreatmentPlanByPatientForm.initPortletEvents();
                TreatmentPlanByPatientForm.initValidationFrm();
                OdontogramView.initOdontogramsSvg(function (result) {
                    var currentParams = {
                        init: params.data["allowData"],
                        data: params.data["DentalPieceByOdontogram"],
                        id: params.data["allowData"] ? params.data["OdontogramByPatient"].id : null,
                    };
                    TreatmentPlanByPatientForm.initOdontogramDentalPieceByOdontogram(currentParams);
                });


            } else if (typeManagement == "clinicDocumentByPatient") {
                console.log('click')
                initClinicalDocuments();
            }else if (typeManagement == "patient") {
                console.log('clickabc')
                $('#data-render').hide();
                // initClinicalDocuments();
            }

        },
        setHtmlByElement: function (html, element) {
            element.html("");
            element.html(html);
        }, loadDataByAjax: function (params) {
            var action = params.action;
            var type = params.type ? params.type : "POST";
            var data = params.data ? params.data : null;
            var typeManagement = params.typeManagement ? params.typeManagement : null;
            var blockElement = $(managementElementContentAll);
            var loading_message = "Cargando...";
            var error_message = 'Error al cargar Informacion';
            var optionsAjax = {};
            if (data) {
                optionsAjax = {
                    type: type,
                    blockElement: blockElement,
                    loading_message: loading_message,
                    error_message: error_message,
                    data: data,
                    beforeSend: function () {
                        console.log("init");
                    },
                    success_callback: function (data) {
                        functionsObjThis.setHtmlByElement(data.html, $(managementElementRender));
                        functionsObjThis.initEventsByType(typeManagement, data);
                    }
                };
            } else {
                optionsAjax = {
                    type: type,
                    blockElement: blockElement,
                    loading_message: loading_message,
                    error_message: error_message,
                    beforeSend: function () {
                        console.log("init");
                    },
                    success_callback: function (data) {
                        functionsObjThis.setHtmlByElement(data.html, $(managementElementRender));
                        functionsObjThis.initEventsByType(typeManagement, data);
                        functionsObjThis.initBadgeByType(typeManagement, data);

                    }
                };
            }
            ajaxRequest(action, optionsAjax);
        }, initManagement: function (params) {
            var data = params;
            functionsObjThis.setHtmlByElement(data.html, $('#container-management'));
            managementElementContentAll = ".m-portlet__management-content";
            managementElementRender = ".m-section__management-data-render";
            MenuInit = new ManagementMenu();
            initForms = new formsValidations;
            initGrids = new gridConfigurations;
            MenuInit.initEventsMenu();
            Dashboard.init();
            patient_id = current_patient;
            $('#edit_patient_portlet').click(function () {
                getFormPatientModal($('#action_get_patients_form_step1').val() + '/' + current_patient);
            });
            MenuInit.viewMenuAllow();
            $('#container-management').show();
        },
        initBadgeByType: function (typeManagement, result) {

            if (typeManagement == "odontogramByPatient") {
                var view = result["data"]["allowData"];

                var selector = ".m-nav__item-odontogram-by-patient";
                var classSet = "m-badge--success";
                var textSet = "A";
                if (!view) {
                    classSet = "m-badge--danger";
                    textSet = "I";
                }
                $(selector).children().removeClass("m-badge--danger");
                $(selector).children().removeClass("m-badge--success");
                $(selector).show();
                $(selector).children().addClass(classSet);
                $(selector).children().text(textSet);
            }
        }, initTooltips: function () {
            $(".tooltip.fade.show.bs-tooltip-bottom").remove();
            $('[data-toggle="tooltip"]').tooltip();

        }
    };

    return functionsObjThis;

}
