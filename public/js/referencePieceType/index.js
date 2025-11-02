var modal_manager = null;
var form_manager = null;
var dataTable = null;
$(function () {
    modal_manager = $('#modal');
    dataTable = initDatableAjax($('#' + model_entity + '_table'), {
        ajax: {
            url: $('#action_load_' + model_entity + 's').val(),
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
                field: "color",
                title: "Color",
                template: function (t) {
                    var e = {
                        'style': {title:t.color, style: "style='background-color:"+t.color+";color:#ffffff;'"},
                    };

                    return '<span class="m-badge m-badge--wide" '+  e["style"].style + '>' + e["style"].title + "</span>"
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
                        'managerOnClick': 'editRegister(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })
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
            form_manager = $("#" + model_entity + "_form");
            validateFormManager();
            modal_manager.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });



            setTimeout(function () {
                var colorCurrent=$('input[name="color"]').val();
                var params={color:'#ffff'};
                if(colorCurrent){
                    params.color=  colorCurrent;
                }
                $('input[name="color"]').colorpicker(params);
            }, 1000)
        }
    });
}

function validateFormManager() {
    form_manager.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
            },
            "color":"required",

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
