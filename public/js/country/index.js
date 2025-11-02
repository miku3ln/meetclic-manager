var modal_country = null;
var form_country = null;
var dataTable = null;
var initTableCurrent = false;
$(function () {
    modal_country = $('#modal');
    if (!initTableCurrent) {


        initTableCurrent = true;
        dataTable = initDatableAjax($('#country_table'), {
            ajax: {
                url: $('#action_load_countries').val(),
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
                    field: "iso_codes",
                    title: "Codigo Iso",
                    sortable: 'asc',
                    filterable: false,
                    width: 150
                },
                {
                    field: "phone_code",
                    title: "Codigo Pais Llamada",
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
                            'managerOnClick': 'editCountry(' + t.id + ')',
                            'classBtn': 'btn-success',
                            'classSpan': 'mdi mdi-pencil',

                        });
                        return buttons;

                    }
                }
            ]
        });
    }
});

function editCountry(id) {
    modal_country.find('.modal-title').html('Editar país');
    getFormCountry($('#action_get_form').val() + '/' + id);
}

function newCountry() {
    modal_country.find('.modal-title').html('Crear país');
    getFormCountry($('#action_get_form').val());
}

function saveCountry() {
    if (form_country.valid()) {
        ajaxRequest($('#action_save_country').val(), {
            type: 'POST',
            data: form_country.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el país',
            success_message: 'El país se guardo correctamente',
            success_callback: function (response) {
                if (response.success) {

                    modal_country.modal('hide');
                    dataTable.reload();
                } else {
                    alert('Error al guardar.')
                }
            }
        });
    }
}

function getFormCountry(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {

            modal_country.find('.container_modal').html('');
            modal_country.find('.container_modal').html(data.html);
            form_country = $("#country_form");
            validateFormCountry();
            modal_country.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormCountry() {
    form_country.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#country_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            iso_codes: {
                required: true,
                maxlength: 8,
            },
            phone_code: {
                required: true,
                maxlength: 15,
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una país con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            console.log("sdfadfa");
            saveCountry();
        }
    });
}
