var modal_user = null;
var form_user = null;
var select_user = null;
var dataTable = null;
$(function () {
    modal_user = $('#modal');
    dataTable = initDatableAjax($('#user_table'), {
        ajax: {
            url: $('#action_load_users').val(),
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
            }, {
                field: "username",
                title: "Nombre de usuario",
                sortable: 'asc',
                filterable: false,
                width: 150
            }, {
                field: "email",
                title: "Email",
                sortable: 'asc',
                filterable: false,
                width: 150
            }, {
                field: "roles",
                title: "Roles",
                sortable: false,
                filterable: false,
                width: 170
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
                            'managerOnClick': 'editUser(' + t.id + ')',
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

function editUser(id) {
    modal_user.find('.modal-title').html('Editar usuario');
    getFormUser($('#action_get_form').val() + '/' + id);
}

function newUser() {
    modal_user.find('.modal-title').html('Crear Usuario');
    getFormUser($('#action_get_form').val());
}

function saveUser() {
    if (form_user.valid()) {
        $('#roles_id').val(select_user.val());
        ajaxRequest($('#action_save_user').val(), {
            type: 'POST',
            data: form_user.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el usuario',
            success_message: 'El usuario se guardo correctamente',
            success_callback: function (data) {
                modal_user.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormUser(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_user.find('.container_modal').html('');
            modal_user.find('.container_modal').html(data.html);
            form_user = $("#user_form");
            validateFormUser();
            modal_user.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            select_user = initSelect2($('#roles'), {
                ajax: {
                    url: $('#action_load_roles_select2').val(),
                    dataType: 'json',
                },
                multiple: true
            });
            var selected_roles = $('#selected_roles').val();
            if (selected_roles) {
                selected_roles = JSON.parse(selected_roles);
                for (var rol_id in selected_roles) {
                    if (selected_roles.hasOwnProperty(rol_id)) {
                        var option = new Option(selected_roles[rol_id], rol_id, true, true);
                        select_user.append(option).trigger('change');
                    }
                }
            }
            //switch
            $('#password-change').bootstrapSwitch({
                onText: "SI",
                offText: "NO"
            });
            $('#password-change').on('switchChange.bootstrapSwitch', function (event, state) {
                if (state) {
                    $('#container-password').show('slow');
                } else {
                    $('#container-password').hide('slow');
                    emptyPasswordFields();
                }
            });
        }
    });
}

function emptyPasswordFields() {
    $('#password_old').val('');
    $('#password').val('');
    $('#password_confirm').val('');
}

function validateFormUser() {
    form_user.validate({
        ignore: [],
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_email').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#user_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        email: function () {
                            return $("#email").val().trim();
                        },
                    }
                }
            },
            username: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_username').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#user_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        username: function () {
                            return $("#username").val().trim();
                        },
                    }
                }
            },
            name: {
                required: true
            },
            roles: {
                required: true
            },
            password_old: {
                required: function (e) {
                    return $('#user_id').val() && $('#password-change').prop('checked');
                },
                minlength: 8,
                remote: {
                    url: $('#action_check_password_old').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#user_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        password_old: function () {
                            return $("#password_old").val().trim();
                        }
                    }
                }
            },
            password: {
                required: function (e) {
                    return $('#user_id').val() == "" || $('#password-change').prop('checked');
                },
                minlength: 8
            },
            password_confirm: {
                required: function (e) {
                    return $('#user_id').val() == "" || $('#password-change').prop('checked');
                },
                equalTo: "#password",
                minlength: 8
            }
        },
        messages: {
            email: {
                remote: 'Ya existe una usuario con ese email.'
            },
            username: {
                remote: 'Ya existe una usuario con ese username.'
            },
            password_old: {
                remote: 'La contraseña actual no es la correcta.'
            },
            password_confirm: {
                equalTo: 'Las contraseñas no coinciden.'
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
