var modal_category = null;
var form_category = null;
var dataTable = null;
$(function () {
    modal_category = $('#modal');
    dataTable = initDatableAjax($('#category_table'), {
        ajax: {
            url: $('#action_load_categories').val(),
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

                    var buttons = getButtonStringManager({
                        'managerOnClick': 'editCategory(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })
});

function editCategory(id) {
    modal_category.find('.modal-title').html('Editar categoría');
    getFormCategory($('#action_get_form').val() + '/' + id);
}

function newCategory() {
    modal_category.find('.modal-title').html('Crear categoría');
    getFormCategory($('#action_get_form').val());
}

function saveCategory() {
    if (form_category.valid()) {
        ajaxRequest($('#action_save_category').val(), {
            type: 'POST',
            data: form_category.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar la categoría',
            success_message: 'La categoría se guardo correctamente',
            success_callback: function (data) {
                modal_category.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormCategory(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_category.find('.container_modal').html('');
            modal_category.find('.container_modal').html(data.html);
            form_category = $("#category_form");
            validateFormCategory();
            modal_category.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormCategory() {
    form_category.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#category_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    },
                }
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una categoría con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function(form){
            saveCategory()
        }
    });
}
