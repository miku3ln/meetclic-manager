var modal_manager = null;
var form_manager = null;
var dataTable = null;
$(function () {
    modal_manager = $('#modal');
    // dataTable = initDatableAjax($('#'+model_entity+'_table'), {
    //     ajax: {
    //         url: $('#action_load_'+model_entity+'s').val(),
    //         method: 'GET'
    //     },
    //     pageSize: 10,
    //     columns: [
    //         {
    //             field: "name",
    //             title: "Nombre",
    //             sortable: 'asc',
    //             filterable: false,
    //             width: 150
    //         },
    //         {
    //             field: "description",
    //             title: "Descripcion",
    //             sortable: 'asc',
    //             width: 150
    //         },
    //         {
    //             field: "status",
    //             title: "Estado",
    //             template: function (t) {
    //                 var e = {
    //                     'ACTIVE': {title: "Activo", class: "m-badge--primary"},
    //                     'INACTIVE': {title: "Inactivo", class: " m-badge--metal"},
    //                 };
    //                 return '<span class="m-badge ' + e[t.status].class + ' m-badge--wide">' + e[t.status].title + "</span>"
    //             }
    //         },
    //         {
    //             field: "",
    //             width: 110,
    //             title: "Acciones",
    //             sortable: false,
    //             overflow: "visible",
    //             template: function (t) {
    //                 return '<a href="javascript:;" onclick="editRegister(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
    //             }
    //         }
    //     ]
    // })
});

function editRegister(id) {
    modal_manager.find('.modal-title').html('Editar ' + name_manager);
    getFormRegister($('#action_get_form').val() + '/' + id);
}

function newRegister() {
    modal_manager.find('.modal-title').html('Crear ' + name_manager);
    getFormRegister($('#action_get_form').val());
}

function saveRegister() {
    if (form_manager.valid()) {
        ajaxRequest($('#action_save_' + model_entity).val(), {
            type: 'POST',
            data: form_manager.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el ' + name_manager,
            success_message: 'El ' + name_manager + ' se guardo correctamente',
            success_callback: function (data) {
                console.log(data);
                modal_manager.modal('hide');
            }
        });
    }
}

function getFormRegister(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_manager.find('.container_modal').html('');
            modal_manager.find('.container_modal').html('');
            modal_manager.find('.modal-dialog').addClass("modal-lg");
            modal_manager.find('.container_modal').html(data.html);
            form_manager = $("#" + model_entity + "_form");
            validateFormManager();
            modal_manager.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            initMyMap();
        }
    });
}

function validateFormManager() {
    form_manager.validate({
        rules: {
            title: {
                required: true,
                maxlength: 64,
            },
            page_url: {
                url: true,
            },
            business_subcategory_id: "required",
            "street_1": "required",
            "street_lat_lng": "required",
            "phone_value": "required",

        },
        messages: {
            name: {
                remote: 'Ya existe una ' + name_manager + ' con ese nombre.'
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



/*
var modal_manager = null;
var form_manager = null;
var dataTable = null;
$(function () {
    modal_manager = $('#modal');
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

});

function editRegister(id) {
    modal_manager.find('.modal-title').html('Editar '+name_manager);
    getFormRegister($('#action_get_form').val() + '/' + id);
}

function newRegister() {
    modal_manager.find('.modal-title').html('Crear '+name_manager);
    getFormRegister($('#action_get_form').val());
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

function getFormRegister(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_manager.find('.container_modal').html('');
            modal_manager.find('.container_modal').html(data.html);
            form_manager = $("#"+model_entity+"_form");
            validateFormManager();
            modal_manager.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
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
}*/
