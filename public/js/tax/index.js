var modal_tax = null;
var modal_detail_cities = null;
var form_tax = null;
var dataTable = null;
var dataCitiesTable = null;
var select_cities = null;
var select_country = null;
var iniCity = true;
$(function () {
    modal_tax = $('#modal');
    modal_detail_cities = $('#modal-detail-cities');

    dataTable = initDatableAjax($('#tax_table'), {
        ajax: {
            url: $('#action_load_taxes').val(),
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
                field: "city",
                title: "Ciudad",
                sortable: 'asc',
                filterable: false,
                width: 160,
                template: function (t) {
                    var elements = t.city.split(',');
                    var result = t.city;
                    if (elements.length > 2) {
                        var e = {
                            'city': {
                                title: elements[0] + ',' + elements[1] + ', (+' + (elements.length - 2) + ')',
                                class: "detail-cities"
                            },
                        };
                        result = '<span onclick="showDetailCities(' + t.id + ')" class="' + e['city'].class + ' ">' + e['city'].title + " </span>";
                    }
                    return result

                }
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
                        'managerOnClick': 'editTax(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })

    dataCitiesTable = initDatableAjax($('#tax_cities_table'), {
        ajax: {
            url: $('#action_details_cities').val(),
            method: 'GET',
            params: {
                tax_id: 0
            }
        },
        pageSize: 10,
        columns: [
            {
                field: "name",
                title: "Nombre",
                sortable: 'asc',
                filterable: false,
                width: 150
            }
        ]
    })
});

function editTax(id) {
    modal_tax.find('.modal-title').html('Editar impuesto');
    getFormTax($('#action_get_form').val() + '/' + id);
}

function newTax() {
    modal_tax.find('.modal-title').html('Crear impuesto');
    getFormTax($('#action_get_form').val());
}

function saveTax() {
    $('#cities_id').val(select_cities.val());
    if (form_tax.valid()) {
        ajaxRequest($('#action_save_tax').val(), {
            type: 'POST',
            data: form_tax.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el impuesto',
            success_message: 'El impuesto se guardo correctamente',
            success_callback: function (data) {
                modal_tax.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormTax(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_tax.find('.container_modal').html('');
            modal_tax.find('.container_modal').html(data.html);
            form_tax = $("#tax_form");
            validateFormTax();
            modal_tax.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });

            select_country = initSelect2($('#select_country'), {
                dropdownParent:$('#wrapper_country'),
                ajax: {
                    url: $('#action_load_countries_select2').val(),
                    dataType: 'json',
                },
            });

            select_country.on('select2:select', function (e) {
                select_province.val(null).trigger("change");
                select_province.select2('enable');
                select_cities.val(null).trigger("change");
                select_cities.select2("enable", false);
            });
            select_country.on('select2:unselect', function (e) {
                select_province.val(null).trigger("change");
                select_province.select2("enable", false);
                select_cities.val(null).trigger("change");
                select_cities.select2("enable", false);
            });

            select_province = initSelect2($('#select_province'), {
                disabled: true,
                dropdownParent:$('#wrapper_province'),
                ajax: {
                    url: $('#action_load_province').val(),
                    dataType: 'json',
                    params: [{
                        type: 'selector', //selector or value
                        name: 'country_id',
                        element: select_country
                    }]
                },
            });

            select_province.on('select2:select', function (e) {
                select_cities.val(null).trigger("change");
                select_cities.select2('enable');
            });
            select_province.on('select2:unselect', function (e) {
                select_cities.val(null).trigger("change");
                select_cities.select2("enable", false)
            });


            select_cities = initSelect2($('#select_cities'), {
                multiple: true,
                disabled: true,
                dropdownParent:$('#wrapper_cities'),
                ajax: {
                    url: $('#action_load_cities').val(),
                    dataType: 'json',
                    params: [{
                        type: 'selector', //selector or value
                        name: 'province_id',
                        element: select_province
                    }]
                },
            });

            if ($('#selected_country').val()) {
                setSelectedValueSelect2(select_country, $('#action_load_countries_select2').val(), $('#selected_country').val());
            }
            if ($('#selected_province').val() && $('#selected_province').val() != '[]' ) {
                select_province.select2('enable');
                setSelectedValueSelect2(select_province, $('#action_load_province').val(), $('#selected_province').val());
            }
            if ($('#selected_cities').val() && $('#selected_cities').val() != '[]' ) {
                select_cities.select2('enable');
                setSelectedValueSelect2(select_cities, $('#action_load_cities').val(), $('#selected_cities').val());
            }

        }
    });
}

function validateFormTax() {
    form_tax.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#tax_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            "value": {
                required: true,
                number:true
            },
            country_id: {
                required: true,
            },
            province: {
                required: true,
            },
            cities: {
                required: true,
            },
        },
        messages: {
            name: {
                remote: 'Ya existe un impuesto con ese nombre.'
            },
            "value": {
                number: 'El impuesto debe ser un número.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function(form){
            saveTax();
        }

    });
}

function showDetailCities(id) {

    modal_detail_cities.find('.modal-title').html('Detalle Ciudades');
    var query = dataCitiesTable.getDataSourceQuery();
    query.tax_id = id;
    dataCitiesTable.setDataSourceQuery(query);
    dataCitiesTable.reload();
    modal_detail_cities.modal({
        show: true,
        backdrop: 'static',
        keyboard: false // to prevent closing with Esc button (if you want this too)
    });

}

function initTable(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_tax.find('.container_modal').html('');
            modal_tax.find('.container_modal').html(data.html);
            form_tax = $("#tax_form");
            validateFormTax();
            modal_tax.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });

            select_country = initSelect2($('#select_country'), {
                ajax: {
                    url: $('#action_load_countries_select2').val(),
                    dataType: 'json',
                },
            });

            select_country.on('select2:select', function (e) {
                select_cities.val(null).trigger("change");
                select_cities.select2('enable');
            });
            select_country.on('select2:unselect', function (e) {
                select_cities.val(null).trigger("change");
                select_cities.select2("enable", false)
            });


            select_cities = initSelect2($('#select_cities'), {
                multiple: true,
                disabled: true,
                ajax: {
                    url: $('#action_load_cities').val(),
                    dataType: 'json',
                    params: [{
                        type: 'selector', //selector or value
                        name: 'country_id',
                        element: select_country
                    }]
                },
            });

            if ($('#selected_country').val()) {
                setSelectedValueSelect2(select_country, $('#action_load_countries_select2').val(), $('#selected_country').val());
            }
            if ($('#selected_cities').val() && $('#selected_cities').val() != '[]') {
                select_cities.select2('enable');
                setSelectedValueSelect2(select_cities, $('#action_load_cities').val(), $('#selected_cities').val());
            }

        }
    });
}
