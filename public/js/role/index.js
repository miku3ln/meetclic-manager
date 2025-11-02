var modal_role = null;
var form_role = null;
var dataTable = null;
$(function () {
    modal_role = $('#modal');
    dataTable = initDatableAjax($('#role_table'), {
        ajax: {
            url: $('#action_load_roles').val(),
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
                    if (t.id != 1) {
                        var buttons = getButtonStringManager({
                            'managerOnClick': 'editRole(' + t.id + ')',
                            'classBtn': 'btn-success',
                            'classSpan': 'mdi mdi-pencil',

                        });
                        return buttons;

                    }
                }
            }
        ]
    })

});

function editRole(id) {
    modal_role.find('.modal-title').html('Editar Rol');
    getFormRole($('#action_get_form').val() + '/' + id);
}

function newRole() {
    modal_role.find('.modal-title').html('Crear Rol');
    getFormRole($('#action_get_form').val());
}

function saveRole() {
    if (form_role.valid()) {
        ajaxRequest($('#action_save_role').val(), {
            type: 'POST',
            data: form_role.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el rol',
            success_message: 'El rol se guardo correctamente',
            success_callback: function (data) {
                modal_role.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormRole(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_role.find('.container_modal').html('');
            modal_role.find('.container_modal').html(data.html);
            form_role = $("#role_form");
            validateFormRole();
            indent_actions();
            check_uncheck();
            modal_role.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormRole() {
    form_role.validate({
        ignore: [],
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#role_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            functions: {
                required: function (element) {
                    if ($("input[type='checkbox'][name='actions[]']:checked").length == 0) {
                        return true;
                    }
                    return false;
                }
            }
        },
        messages: {
            name: {
                remote: 'Ya existe un rol con ese nombre.'
            },
            functions: {
                required: "Seleccione al menos una funci&oacute;n"
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        //display error alert on form submit
        // invalidHandler: function (event, validator) {
        //     console.log(event, validator);
        //
        //     // var alert = $('#m_form_1_msg');
        //     // alert.removeClass('m--hide').show();
        //     mApp.scrollTo(alert, -200);
        // }
    });
}

function indent_actions() {
    $('[id ^= label_]').each(function () {
        if ($(this).attr('parent_id') != '') {
            var padding_left = $('#label_' + $(this).attr('parent_id')).css('padding-left');
            padding_left = padding_left.substring(0, padding_left.length - 2);
            var num_padding_left = parseInt(padding_left) + 40;
            $(this).css('padding-left', num_padding_left + 'px');
        }
    });
}

function check_uncheck() {
    $(':checkbox').each(function () {
        $(this).bind('click', function () {
            if ($(this).is(':checked')) { //Unchecked
                check_parent($(this).attr('id'));
                check_son($(this).attr('id'));
            } else {
                uncheck_parent($(this).attr('id'));
                uncheck_son($(this).attr('id'));
            }
        });
    });
}

function check_parent(id) {
    if ($('#' + id).attr('parent_id')) {
        var id_parent = $('#' + id).attr('parent_id');
        $('#' + id_parent).prop('checked', true);
        check_parent(id_parent);
    }
}

function check_son(id) {
    $(':input[parent_id = ' + id + ']').each(function () {
        $(this).prop('checked', true);
        check_son($(this).prop('id'));
    });
}

function uncheck_parent(id) {
    if ($('#' + id).attr('parent_id')) {
        var id_parent = $('#' + id).attr('parent_id');
        if (!has_brother(id_parent)) {
            $('#' + id_parent).prop('checked', false);
            uncheck_parent(id_parent);
        }
    }
}

function uncheck_son(id) {
    $(':input[parent_id = ' + id + ']').each(function () {
        $(this).prop('checked', false);
        uncheck_son($(this).prop('id'));
    });
}

function has_brother(id) {
    var count = 0;
    $(':input[parent_id = ' + id + ']').each(function () {
        if ($(this).prop('checked')) {
            count++;
        }
    });

    if (count > 0) {
        return true;
    } else {
        return false;
    }
}
