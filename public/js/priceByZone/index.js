var modal_zone = null;
var form_prices = null;
var select_country = null;
var select_province = null;
var select_city = null;
var dataTable = null;
var isChanged;

$(function () {
    select_country = initSelect2($('#select_country'), {
        ajax: {
            url: $('#action_load_countries_select2').val(),
            dataType: 'json',
        },
    });
    select_province = initSelect2($('#select_province'), {
        disabled: true,
        ajax: {
            url: $('#action_load_provinces_select2').val(),
            dataType: 'json',
            params: [{
                type: 'selector', //selector or value
                name: 'country_id',
                element: select_country
            }]
        },
    });

    select_city = initSelect2($('#select_city'), {
        disabled: true,
        ajax: {
            url: $('#action_load_cities_select2').val(),
            dataType: 'json',
            params: [{
                type: 'selector', //selector or value
                name: 'province_id',
                element: select_province
            }]
        },
    });

    select_country.on('select2:select', function (e) {
        select_province.val(null).trigger("change");
        select_province.select2('enable');
    });

    select_country.on('select2:unselect', function (e) {
        select_province.val(null).trigger("change");
        select_city.val(null).trigger("change");
        select_province.select2("enable", false)
        select_city.select2("enable", false)
    });

    select_province.on('select2:select', function (e) {
        select_city.val(null).trigger("change");
        select_city.select2('enable');
    });

    select_province.on('select2:unselect', function (e) {
        select_city.val(null).trigger("change");
        select_city.select2("enable", false)
    });

    modal_zone = $('#modal');

    select_city.on('change', function () {
        if (select_city.val() != null) {
            $('#price_list').show();
            ajaxRequest($('#action_get_zones').val(), {
                type: 'GET',
                data: {city_id: select_city.val()},
                loading_message: 'Espere...',
                error_message: 'Error',
                success_callback: function (data) {
                    generateGrid(data, select_city.val());
                }
            });
        }
        else {
            $('#price_list').hide();
        }
    });
});

function generateGrid(data, city_id) {
    var columns = [{
        field: 'id',
        title: '#',
        sortable: 'asc',
        filterable: false,
        width: 25
    },{
        field: 'name',
        title: 'Producto',
        sortable: 'asc',
        filterable: false,
        width: 150
    }];
    $.each(data, function (index, value) {
        columns.push({
            field: value.id,
            title: value.name,
            filterable: false,
            sortable: false,
            width: 100,
            template: function (t) {
                return '<div class="form-group m-form__group" style="padding: 0px;">' +
                    '<div class="m-input-icon m-input-icon--left">' +
                    '<input name="price[' + t.id + '][' + value.id + ']" value="' + (t[value.id] ? t[value.id] : '') + '" type="text" class="form-control form-control-sm m-input" onchange="validateNumber(this)" placeholder="0.0000">' +
                    '<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-dollar"></i></span></span>' +
                    '</div>' +
                    '</div>';
            }
        })
    });
    if (dataTable) {
        dataTable.destroy();
    }
    dataTable = initDatableAjax($('#price_table'), {
        ajax: {
            url: $('#action_load_prices').val(),
            method: 'GET',
            params: {
                city_id: city_id
            }
        },
        pageSize: 10,
        columns: columns
    });
    isChanged = false;
    form_prices = $("#price_by_zone_form");
    dataTable.on('m-datatable--on-goto-page m-datatable--on-update-perpage m-datatable--on-sort', function (e, a) {
        if (isChanged) {
            var r = confirm("Desea guardar los cambios antes de continuar? En caso de cancelar se perderan los cambios.");
            isChanged = false;
            if (r == true) {
                savePrices();
            } else {
                return false;
            }
        }
    });
}

function validateNumber(e) {
    if ($.isNumeric($(e).val())) {
        (parseFloat($(e).val()).toFixed(4) === 'NaN' || parseFloat($(e).val()).toFixed(4) < 0) ? $(e).val('') : $(e).val(parseFloat($(e).val()).toFixed(4));
        isChanged = true;
    } else {
        $(e).val('');
    }
}

function savePrices() {
    ajaxRequest($('#action_save_prices').val(), {
        type: 'POST',
        data: form_prices.serialize(),
        blockElement: 'body',//opcional: es para bloquear el elemento
        loading_message: 'Guardando...',
        error_message: 'Ha ocurrido un error',
        success_message: 'Precios guardados correctamente',
        success_callback: function (data) {
            if (data.success) {
                dataTable.reload();
            }
        }
    });
}
