var modal_manager = null;
var form_manager = null;
var dataTable = null;
var current_patient = null;
var details_portlet = null;
var select2_patient = null;
var initForms=new formsValidations;
var initGrids=new gridConfigurations;
$(function () {

    modal_manager = $('#modal');
    select2_patient = $('#patient_id');
    dataTable = initDatableAjax($('#'+model_entity+'_table'), {
        ajax: {
            url: $('#action_load_'+model_entity+'s').val(),
            method: 'GET'
        },
        pageSize: 10,
        columns: [

            {
                field: "reason_consultation",
                title: "Descripcion",
                sortable: 'asc',
                width: 150
            },
            {
                field: "status",
                title: "Estado",
                template: function (t) {
                    var e = {
                        'ACTIVE': {title: "Activo", class: "m-badge--primary"},
                        'INACTIVE': {title: "Inactivo", class: " m-badge--metal"},
                    };
                    return '<span class="m-badge ' + e[t.status].class + ' m-badge--wide">' + e[t.status].title + "</span>"
                }
            },
            {
                field: "",
                width: 110,
                title: "Acciones",
                sortable: false,
                overflow: "visible",
                template: function (t) {
                    return '<a href="javascript:;" onclick="editRegister(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                }
            }
        ]
    })
    details_portlet = $('#details_portlet');
    mConsultation_container = $('#mConsultation_container');
    mConsultation_table = $('#mConsultation_table');
    // initStep1();
    select2_patient.on('select2:select', function (e) {
        var data = e.params.data;
        current_patient = data.id;
        initPatientDetails();
        console.log('consulta');
        // $('#medicalConsultation_portlet').html('');


    });
});

function editRegister(id) {
    modal_manager.find('.modal-title').html('Editar '+name_manager);
    getFormRegister($('#action_get_form').val() + '/' + id);
}

function newRegister() {
    getFormWizard($('#action_get_wizard').val());
}

function saveRegister() {
    if (form_manager.valid()) {
        ajaxRequest($('#action_save_'+model_entity).val(), {
            type: 'POST',
            data: form_manager.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el '+name_manager,
            success_message: 'El '+name_manager+' se guardo correctamente',
            success_callback: function (data) {
                modal_manager.modal('hide');
                dataTable.reload();
            }
        });
    }
}

var eventInvalid;
var rInvalid;
var msjErrorWizard = "There are some errors in your submission. Please correct them.";
var WizardDemo = function () {

    $("#m_wizard");
    var e, r, i = $("#m_form");
    return {
        init: function () {
            var n;
            $("#m_wizard"), i = $("#m_form"), (r = new mWizard("m_wizard", {startStep: 1})).on("beforeNext", function (r) {
                !0 !== e.form() && r.stop()
            }), r.on("change", function (e) {
                mUtil.scrollTop();
            }), e = i.validate({
                ignore: ":hidden",
                rules: getRulesRegister(),
                messages: getMessagesRules(),
                invalidHandler: function (e, r) {
                    eventInvalid = e;
                    eventInvalid = r;

                    if (e.invalid) {
                        $.each(eventInvalid.invalid, function (index, value) {

                        });
                    }
                    mUtil.scrollTop(), swal({
                        title: "",
                        text: msjErrorWizard,
                        type: "error",
                        icon: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    })
                },
                submitHandler: function (e) {
                    console.log("------------submitHandler---------");
                }
            }), (n = i.find('[data-wizard-action="submit"]')).on("click", function (r) {
                r.preventDefault(), e.form() && (mApp.progress(n), i.ajaxSubmit({
                    success: function () {
                        mApp.unprogress(n), swal({
                            title: "",
                            text: "The application has been successfully submitted!",
                            type: "success",
                            icon: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
                    }
                }))
            })
        }
    }
}();


function getRulesRegister() {
    return {
        // ---history_clinic=step=1--
        patient_id: {required: !0},
        status: {required: !0},
        //step=2
        //medicalConsultationByPatient
        reason_consultation: {required: !0},
        // ---medicalConsultationByPatient--
        reason_consultation: {required: !0},
        "medical_consultation_has_patient[]": {required: !0},
        "antecedent_has_history_clinic[]": {required: !0},
        accept: {required: !0}
    };
}

function getMessagesRules() {
    return {
        "account_communication[]": {required: "You must select at least one communication option"},
        accept: {required: "You must accept the Terms and Conditions agreement!"}
    };
}



function getFormWizard(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar wizard',
        success_callback: function (data) {
            console.log(data)
            // modal_manager.find('.container_modal').html('');
            // modal_manager.find('.container_modal').html(data.html);
            // form_manager = $("#"+model_entity+"_form");
            // validateFormManager();
            // modal_manager.modal({
            //     show: true,
            //     backdrop: 'static',
            //     keyboard: false // to prevent closing with Esc button (if you want this too)
            // });
            list_patient = $("#container_admin");
            list_patient.hide();
            form_patient = $("#container_wizard_form");
            form_patient.html("");
            form_patient.append(data.html);
            WizardDemo.init();
            select2_patient = $('#patient_id');
            initStep1();
            // WizardDemo.init();
        }
    });
}


function initStep1() {
    initSelect2(select2_patient, {
        width: '100%',
        ajax: {
            url: $('#action_load_patients_select2_step1').val(),
            dataType: 'json',
        },
    });
    select2_patient.on('select2:select', function (e) {
        var data = e.params.data;
        current_patient = data.id;
        // $('#patient_details').show();
        initPatientDetails();
        console.log('consulta');
        // $('#medicalConsultation_portlet').html('');


    });
    select2_patient.on("select2:unselecting", function (e) {
        details_portlet.html("<div class='alert alert-info alert-message-center ' role='alert'><strong> Bienvenido! </strong> Selecciona o Registra un paciente para comenzar. </div>");
        $('#medicalConsultation_portlet').hide();
    }).trigger('change');
}


function initPatientDetails() {
    ajaxRequest($('#action_load_details_step1').val() + '/' + current_patient, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            console.log('-8-8-8-8-8-8-')
            console.log(data)
            console.log('------DATA------')
            details_portlet.html('');
            details_portlet.append(data.html);
            details_portlet.show();
            $('#medicalConsultation_portlet').show();

                    initMedicalConsultation();

        }
    });
}

function validateFormManager() {
    form_manager.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                // remote: {
                //     url: $('#action_unique_name').val(),
                //     type: 'POST',
                //     data: {
                //         id: function () {
                //             return $('#antecedent_id').val();
                //         },
                //         _token: $('meta[name="csrf-token"]').attr('content'),
                //         name: function () {
                //             return $("#name").val().trim();
                //         },
                //     }
                // }
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una '+name_manager+' con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            saveRegister();
        }
    });
}