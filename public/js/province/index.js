var modal_province = null;
var form_province = null;
var select_country = null;
var dataTable = null;
var initTableCurrent=false;
$(function () {
    modal_province = $('#modal');
    if(!initTableCurrent){
        initTableCurrent=true;

        dataTable = initDatableAjax($('#province_table'), {
            ajax: {
                url: $('#action_load_provinces').val(),
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
                    field: "country",
                    title: "País",
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
                            'managerOnClick': 'editProvince(' + t.id + ')',
                            'classBtn': 'btn-success',
                            'classSpan': 'mdi mdi-pencil',

                        });
                        return buttons;

                    }
                }
            ]
        })

    }

});

function editProvince(id) {
    modal_province.find('.modal-title').html('Editar provincia');
    getFormProvince($('#action_get_form').val() + '/' + id);
}

function newProvince() {
    modal_province.find('.modal-title').html('Crear provincia');
    getFormProvince($('#action_get_form').val());
}

function saveProvince() {
    if (form_province.valid()) {
        ajaxRequest($('#action_save_province').val(), {
            type: 'POST',
            data: form_province.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar la provincia',
            success_message: 'La provincia se guardo correctamente',
            success_callback: function (data) {
                modal_province.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormProvince(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_province.find('.container_modal').html('');
            modal_province.find('.container_modal').html(data.html);
            form_province = $("#province_form");
            validateFormProvince();
            modal_province.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            select_country = initSelect2($('#country_id'), {
                ajax: {
                    url: $('#action_load_countries_select2').val(),
                    dataType: 'json',
                },
            });
            if ($('#selected_country').val()) {
                setSelectedValueSelect2(select_country, $('#action_load_countries_select2').val(), $('#selected_country').val());
            }
        }
    });
}

function validateFormProvince() {
    form_province.validate({
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
                            return $('#province_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            country_id: {
                required: true,
                maxlength: 64,
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una provincia con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function(form){
            saveProvince();
        }
    });
}
