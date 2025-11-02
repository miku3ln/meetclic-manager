var modal_status = null;
var form_status = null;
var dataTable = null;
$(function () {
    modal_status = $('#modal');
    dataTable = initDatableAjax($('#order_status_table'), {
        ajax: {
            url: $('#action_load_status').val(),
            method: 'GET'
        },
        pageSize: 10,
        columns: [
            {
                field: "name",
                title: "Nombre",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
            {
                field: "value",
                title: "Valor",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
            {
                field: "weight",
                title: "Orden",
                sortable: 'asc',
                filterable: false,
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
                    var buttons = getButtonStringManager({
                        'managerOnClick': 'editStatus(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })
});

function editStatus(id) {
    modal_status.find('.modal-title').html('Editar estado de gestión');
    getFormStatus($('#action_get_form').val() + '/' + id);
}

function newStatus() {
    modal_status.find('.modal-title').html('Crear estado de gestión');
    getFormStatus($('#action_get_form').val());
}

function saveStatus() {
    if (form_status.valid()) {
        ajaxRequest($('#action_save_status').val(), {
            type: 'POST',
            data: form_status.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el estado de gestión',
            success_message: 'El estado de gestión se guardo correctamente',
            success_callback: function (data) {
                modal_status.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormStatus(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_status.find('.container_modal').html('');
            modal_status.find('.container_modal').html(data.html);
            form_status = $("#status_form");
            validateFormStatus();
            modal_status.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormStatus() {
    form_status.validate({
        rules: {
            name: {
                required: true,
                maxlength: 45,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#status_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            value: {
                required: true,
                maxlength: 45,
            },
            weight: {
                required: true,
                remote: {
                    url: $('#action_unique_weight').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#status_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
        },
        messages: {
            name: {
                remote: 'Ya existe un estado de gestión con ese nombre.'
            },
            weight: {
                remote: 'Ya existe un estado de gestión con este peso.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            saveStatus();
        }
    });
}
