var formsValidations = function FormsInit() {

    var functionsObjThis = {
        odontogramByPatient: function () {
            return {
                init: function (frmValidateElement) {
                    frmValidateElement.validate({
                        rules: {
                            description: {
                                required: true,
                            },
                            date: {
                                required: true,
                            }
                        },
                        messages: {
                            date: {
                                required: 'Fecha Obligatrio.'
                            },
                            description: {
                                required: 'Descripcion Obligatrio.'
                            }
                        },
                        errorElement: 'span',
                        errorClass: 'form-control-feedback',
                        highlight: validationHighlight,
                        success: validationSuccess,
                        errorPlacement: validationErrorPlacement,
                        submitHandler: function (form, event) {
                            event.preventDefault();
                            if (frmValidateElement.valid()) {
                                console.log("odontogram save");

                                saveRegisterOdontogram("odontogram_by_patient", "odontogramByPatient_form");
                            }
                            return false;
                        }


                    });

                    function saveRegisterOdontogram(type, entityFrm) {
                        var success_message = "";
                        var error_message = "";
                        var functionInitBefore = function () {

                        };
                        if (type == "odontogram_by_patient") {
                            success_message = "Odontogram  guardado";
                            error_message = "Odontogram no guardado";
                            functionInitBefore = function () {
                                $("#grid-admin_odontogram_by_patient").bootgrid("reload");
                            }
                        }

                        var blockElement = "#modal_" + type + " .modal-content";
                        var formManagerElement;
                        formManagerElement = $("#" + entityFrm);
                        var action = $('#action_save_' + type).val();

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

                    /*  ---INIT Plugin/*/
                    $('#date').datepicker({
                        format: "yyyy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        minDate: 0,
                        autoclose: true,
                    });
                }
            };
        },
        dentalPieceByOdontogram: function () {
            var initEvent=false;
            var objectThis = {

                init: function (frmValidateElement, data) {
                    frmValidateElement.validate({
                        /*onsubmit: false,*/
                        ignore: ":hidden",
                        rules: {
                            dental_piece_id: "required",
                            reference_piece_position_id: "required",
                            reference_piece_id: "required",
                            odontogramByPatient_id: "required",
                            description: "required"
                        },
                        messages: {
                            dental_piece_id: {
                                required: 'Campo Obligatorio.'
                            },
                            reference_piece_position_id: {
                                required: 'Campo Obligatorio.'
                            },
                            odontogramByPatient_id: {
                                required: 'Campo Obligatorio.'
                            }, reference_piece_id: {
                                required: 'Campo Obligatorio.'
                            },
                        },
                        errorElement: 'span',
                        errorClass: 'form-control-feedback',
                        highlight: validationHighlight,
                        success: validationSuccess,
                        errorPlacement: validationErrorPlacement,
                        submitHandler: function (form, event) {
                            event.preventDefault();
                            if (frmValidateElement.valid()) {
                                saveRegisterDentalPieceByOdontogram();
                            }
                            return false;
                        }
                    });

                    var selectorName = "reference_piece_id";
                    var action = $("#action_ListS2_reference_piece").val();
                    var params = [{
                        type: 'value', //selector or value
                        name: 'type',
                        element: saveDataOdontogram.type
                    }];
                    var selectInit = initSelect2($('#' + selectorName), {
                        ajax: {
                            url: action,
                            dataType: 'json',
                            params: params,
                        },
                    });


                    if ($('#selected_' + selectorName).val()) {
                        setSelectedValueSelect2(selectInit, action, $('#selected_' + selectorName).val());
                    }
                    if(!objectThis.getEventCancel()){

                        $("#btn_save_dental_piece_by_odontogram-cancel").on("click", function () {
                        objectThis.resetForm(frmValidateElement);
                        OdontogramView.resetIndividualByCurrent();
                        objectThis.initEventCancel();
                    });
                    }

                    $("#dental_piece_by_odontogram_id").val(data.dental_piece_by_odontogram_id);
                    $("#dental_piece_id").val(data.dental_piece_id);
                    $("#reference_piece_position_id").val(data.reference_piece_position_id);
                    $(".odontogram_by_patient_id").val(data.odontogram_by_patient_id);
                    $("#patient_id").val(data.patient_id);
                    $("#type").val(data.type);
                    $("#typeDPBO").val(data.typeDPBO);

                }, resetForm: function (eForm) {
                   /* eForm.resetForm();*/
                    var selectorName = "#reference_piece_id";
                    $(selectorName).empty().trigger("change");
                    $(contentElementFrm).hide();
                },initEventCancel:function(){
                    initEvent=true;
                },getEventCancel:function(){
                    return initEvent;
                }
            };
            return objectThis;
        },
        antecedentByHistoryClinic: function () {
            var objectThis = {
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
                            has_antecedent: {
                                required: 'Campo Obligatorio.'
                            }
                        },
                        errorElement: 'span',
                        errorClass: 'form-control-feedback',
                        highlight: validationHighlight,
                        success: validationSuccess,
                        errorPlacement: validationErrorPlacement,
                        submitHandler: function (form, event) {
                            event.preventDefault();
                            if (frmValidateElement.valid()) {
                                saveRegisterByType("antecedent_by_history_clinic", "antecedentByHistoryClinic_form");

                            }
                            return false;
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
            return objectThis;
        }, clinicalByHistoryClinic: function () {
            var objectThis = {
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
                            clinical_exam_id: {
                                required: 'Campo Obligatorio.'
                            }
                        },
                        errorElement: 'span',
                        errorClass: 'form-control-feedback',
                        highlight: validationHighlight,
                        success: validationSuccess,
                        errorPlacement: validationErrorPlacement,
                        submitHandler: function (form, event) {
                            event.preventDefault();
                            if (frmValidateElement.valid()) {
                                saveRegisterByType("clinical_by_history_clinic", "clinicalByHistoryClinic_form");
                            }
                            return false;

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
            return objectThis;
        }

    };
    return functionsObjThis;

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

function editRegisterByType(id, type, entityFrm) {

    var modalElement = $("#modal_" + type);
    var formManagerElement;
    formManagerElement = ("#" + entityFrm);
    var validateFormFunction;
    var action = $('#action_new-register_' + type).val();
    if (type == "antecedent_by_history_clinic") {
        modalElement.find('.modal-title').html('Actualizar Antecedente');
        validateFormFunction = initForms.antecedentByHistoryClinic();
    }
    if (type == "clinical_by_history_clinic") {
        modalElement.find('.modal-title').html('Actualizar Examen Clinico');
        validateFormFunction = initForms.clinicalByHistoryClinic();
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

function newRegisterStep2(type, entityFrm) {
    var modalElement = $("#modal_" + type);
    var formManagerElement;
    formManagerElement = ("#" + entityFrm);
    var validateFormFunction;
    var action = $('#action_new-register_' + type).val();
    if (type == "antecedent_by_history_clinic") {
        modalElement.find('.modal-title').html('Agregar Antecedente');
        validateFormFunction = initForms.antecedentByHistoryClinic();
    }
    if (type == "clinical_by_history_clinic") {
        modalElement.find('.modal-title').html('Agregar Examen Clinico');
        validateFormFunction = initForms.clinicalByHistoryClinic();
    }
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
}

function saveRegisterDentalPieceByOdontogram(frm) {

    var blockElement = "#modal_dental_piece_by_odontogram";
    var formManagerElement;
    formManagerElement = $("#dentalPieceByOdontogram_form");
    var type = "dental_piece_by_odontogram";
    var action = $('#action_save_' + type).val();
    var modalElement = $("#modal_" + type);
    var success_message = "Referencia Guardada";
    var error_message = "Referencia Guardada";

    let params = {
        action: action,
        blockElement: blockElement,
        success_message: success_message,
        error_message: error_message,
        functionInitBefore: functionInitBefore,
        formManagerElement: formManagerElement,

    }

    var formElement = params.formManagerElement;
    var action = params.action;
    var blockElement = params.blockElement;
    var loading_message = 'Guardando...';
    var success_message = params.success_message;
    var error_message = params.error_message;
    var functionInitBefore = params.functionInitBefore;
    ajaxRequest(action, {
        type: 'POST',
        data: formElement.serialize(),
        blockElement: blockElement,//opcional: es para bloquear el elemento
        loading_message: loading_message,
        error_message: error_message,
        success_message: success_message,
        success_callback: function (result) {
            OdontogramView.resetIndividualByCurrent();
            var item = result.data;
            var elementSearch = "";
            elementSearch = OdontogramView.getElementFormat(item);
            var objSvgSearch = OdontogramView.searchAllPieceObjSvgByElement(elementSearch);
            var type = item.reference_piece_type;
            if (objSvgSearch) {
                var colorSet = item.reference_piece_color;
                var dental_piece_by_odontogram_id = item.id;
                if (type == "COMPLETE") {//son poligonos y tiene cdaa poligono
                    objSvgSearch.removeClass("hide-element");
                    var objectSvgCurrent = OdontogramView.getObjectCurrentPiece();
                    objectSvgCurrent.attr("dental_piece_by_odontogram_id", dental_piece_by_odontogram_id);

                } else {
                    objSvgSearch.attr("dental_piece_by_odontogram_id", dental_piece_by_odontogram_id);
                }
                objSvgSearch.attr("fill", colorSet);
                objSvgSearch.attr("fill-opacity", "0.3");

            } else {
                console.log("no encontrado");
            }
            initForms.dentalPieceByOdontogram().resetForm(formManagerElement);

        }
    });
}
