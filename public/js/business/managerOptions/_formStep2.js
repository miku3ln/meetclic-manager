var PortletTools = {
    init: function () {
        var e;
        var elementInitName = "m_portlet_antecedent_by_history_clinic";
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
                var t;
                toastr.warning("After fullscreen off event fired!"),
                (t = $(e.getBody()).find("> .m-scrollable")) && ((t = $(e.getBody()).find("> .m-scrollable")).css("height", t.data("original-height")),
                    mUtil.scrollerUpdate(t[0]))
            });
        var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");
        nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {

            newRegister("antecedent_by_history_clinic", "antecedentByHistoryClinic_form");
        });

        var e2;
        elementInitName = "m_portlet_clinical_by_history_clinic";
        toastr.options.showDuration = 1e3,
            (e2 = new mPortlet(elementInitName)).on("beforeCollapse", function (e) {
                setTimeout(function () {
                    toastr.info("Before collapse event fired!")
                }, 100)
            }),
            e2.on("beforeExpand", function (e) {

            }),
            e2.on("afterExpand", function (e) {
                setTimeout(function () {
                    toastr.warning("After expand event fired!")
                }, 2e3)
            }),
            e2.on("reload", function (e) {
                toastr.info("Leload event fired!"),
                    mApp.block(e.getSelf(), {
                        overlayColor: "#ffffff",
                        type: "loader",
                        state: "accent",
                        opacity: .3,
                        size: "lg"
                    }),
                    setTimeout(function () {
                        mApp.unblock(e.getSelf())
                    }, 2e3)
            }),
            e2.on("afterFullscreenOn", function (e) {
                toastr.warning("After fullscreen on event fired!");
                var t = $(e.getBody()).find("> .m-scrollable");
                t && (t.data("original-height", t.css("height")),
                    t.css("height", "100%"),
                    mUtil.scrollerUpdate(t[0]))
            }),
            e2.on("afterFullscreenOff", function (e) {
                var t;
                toastr.warning("After fullscreen off event fired!"),
                (t = $(e.getBody()).find("> .m-scrollable")) && ((t = $(e.getBody()).find("> .m-scrollable")).css("height", t.data("original-height")),
                    mUtil.scrollerUpdate(t[0]))
            });

        var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");

        nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {

            newRegister("clinical_by_history_clinic", "clinicalByHistoryClinic_form");
        });
    }
};
jQuery(document).ready(function () {
    PortletTools.init();
});



function newRegister(type, entityFrm) {
    var modalElement = $("#modal_" + type);
    var formManagerElement;
    formManagerElement = ("#" + entityFrm);
    var validateFormFunction;
    var action = $('#action_new-register_' + type).val();
    if (type == "antecedent_by_history_clinic") {
        modalElement.find('.modal-title').html('Agregar Antecedente');
        validateFormFunction = validateAntecedent;
    }
    if (type == "clinical_by_history_clinic") {
        modalElement.find('.modal-title').html('Agregar Examen Clinico');
        validateFormFunction = validateClinical;
    }
    let params = {
        action: action,
        validateFormFunction: validateFormFunction,
        modalElement: modalElement,
        formManagerElement: formManagerElement,
        request: {
            data: {patient_id: 1},
        }
    }
    getModalByParams(params);
}

function saveRegisterByType(type, entityFrm) {
    var success_message = "";
    var error_message = "";
    if (type == "antecedent_by_history_clinic") {
        success_message = "Antecedente  guardado";
        error_message = "Antecedente no guardado";
        functionInitBefore = function () {

            dataTable1.reload();

        }
    } else {
        success_message = "Examen Clinico  guardado";
        error_message = "Examen Clinico no guardado";
        functionInitBefore = function () {
            dataTable2.reload();
        }
    }

    var blockElement = "#modal_" + type + " .modal-content";
    var formManagerElement;
    formManagerElement = $("#" + entityFrm);
    var action = $('#action_save_' + type).val();

    var functionInitBefore;
    var modalElement = $("#modal_" + type);
    let params = {
        action: action,
        blockElement: blockElement,
        success_message: success_message,
        error_message: error_message,
        functionInitBefore: functionInitBefore,
        formManagerElement: formManagerElement,
        modalElement: modalElement
    }
    saveRegisterManagementByModal(params);
}

function saveRegisterManagementByModal(params) {
    var formElement = params.formManagerElement;
    var action = params.action;
    var blockElement = params.blockElement;
    var loading_message = 'Guardando...';
    var success_message = params.success_message;
    var error_message = params.error_message;
    var functionInitBefore = params.functionInitBefore;
    var modalManagement = params.modalElement;
    if (formElement.valid()) {
        ajaxRequest(action, {
            type: 'POST',
            data: formElement.serialize(),
            blockElement: blockElement,//opcional: es para bloquear el elemento
            loading_message: loading_message,
            error_message: error_message,
            success_message: success_message,
            success_callback: function (data) {
                modalManagement.modal('hide');
                if (functionInitBefore) {
                    functionInitBefore.call();
                }
            }
        });
    }
}

var validateAntecedent = {
    init: function (frmValidateElement) {
        frmValidateElement.validate({
            rules: {
                history_clinic_id: {
                    required: true,
                },
                antecedent_id: {
                    required: true,
                },
                has_antecedent: {
                    required: true,
                }
            },
            messages: {
                /*       history_clinic_id: {
                           required: 'Campo Obligatorio.'
                       },

                       antecedent_id: {
                           required: 'Campo Obligatorio.'
                       },*/
                has_antecedent: {
                    required: 'Campo Obligatorio.'
                }
            },
            errorElement: 'span',
            errorClass: 'form-control-feedback',
            highlight: validationHighlight,
            success: validationSuccess,
            errorPlacement: validationErrorPlacement,
            submitHandler: function (form) {

            }


        });
        var selectorName = "antecedent_id";
        var action = $("#action_loadS2_antecedents").val();
        var selectInit = initSelect2($('#' + selectorName), {
            ajax: {
                url: action,
                dataType: 'json',
            },
        });


        if ($('#selected_' + selectorName).val()) {
            setSelectedValueSelect2(selectInit, action, $('#selected_' + selectorName).val());
        }

    }
};
var validateClinical = {
    init: function (frmValidateElement) {
        frmValidateElement.validate({
            rules: {
                history_clinic_id: {
                    required: true,
                },
                clinical_exam_id: {
                    required: true,
                }
            },
            messages: {
                /*       history_clinic_id: {
                           required: 'Campo Obligatorio.'
                       },

                       antecedent_id: {
                           required: 'Campo Obligatorio.'
                       },*/
                clinical_exam_id: {
                    required: 'Campo Obligatorio.'
                }
            },
            errorElement: 'span',
            errorClass: 'form-control-feedback',
            highlight: validationHighlight,
            success: validationSuccess,
            errorPlacement: validationErrorPlacement,
            submitHandler: function (form) {

            }


        });
        var selectorName = "clinical_exam_id";
        var action = $("#action_loadS2_clinical_exams").val();
        var selectInit = initSelect2($('#' + selectorName), {
            ajax: {
                url: action,
                dataType: 'json',
            },
        });


        if ($('#selected_' + selectorName).val()) {
            setSelectedValueSelect2(selectInit, action, $('#selected_' + selectorName).val());
        }

    }
};

function getModalByParams(params) {
    var action = params.action;
    var validateFormFunction = params.validateFormFunction;
    var modalElement = params.modalElement;
    var type = params.request && params.request.type ? params.request.type : "GET";
    var dataSend = params.request && params.request.data ? params.request.data : [];
    var error_message = params.error_message ? params.error_message : "Error al cargar formulario";

    ajaxRequest(action, {
        type: type,
        data: dataSend,
        error_message: error_message,
        success_callback: function (data) {
            modalElement.find('.container_modal').html('');
            modalElement.find('.container_modal').html(data.html);
            var formManagerElement = params.formManagerElement ? params.formManagerElement : null;
            if (formManagerElement) {
                if (validateFormFunction) {
                    var formManagerElement = $(formManagerElement);
                    validateFormFunction.init(formManagerElement);
                }
            }
            modalElement.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}