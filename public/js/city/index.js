var modal_city = null;
var form_city = null;
var select_country = null;
var select_province = null;
var dataTable = null;
var current_city = null;
var map = null;
var initTableCurrent=false;

function viewManagerButton() {
    if ($('#select_province').val() && $('#select_country').val() ) {
        $('#add-city').show();
    }else{
        $('#add-city').hide();

    }
}

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

    select_country.on('select2:select', function (e) {
        select_province.val(null).trigger("change");
        select_province.select2('enable');
        viewManagerButton();

    });

    select_province.on('select2:unselect', function (e) {

        viewManagerButton();
    });


    select_province.on('select2:select', function (e) {

        viewManagerButton();

    });

    select_country.on('select2:unselect', function (e) {
        select_province.val(null).trigger("change");
        select_province.select2("enable", false);
        viewManagerButton();
    });



    modal_city = $('#modal');
if(!initTableCurrent){
    initTableCurrent=true;
    dataTable = initDatableAjax($('#city_table'), {
        ajax: {
            url: $('#action_load_cities').val(),
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
                        'managerOnClick': 'editCity(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })

}

    select_province.on('change', function () {
        if (select_province.val() != null) {
            $('#city_list').show();
            var query = dataTable.getDataSourceQuery();
            query.province_id = $(this).val();
            dataTable.setDataSourceQuery(query);
            dataTable.reload();
        } else {
            $('#city_list').hide();
        }
    });

});

function editCity(id) {
    modal_city.find('.modal-title').html('Editar Ciudad');
    current_city = id;
    getFormCity($('#action_get_form').val() + '/' + id);
}

function newCity() {
    if ($('#select_province').val()) {

        modal_city.find('.modal-title').html('Crear Ciudad');
        current_city = null;
        getFormCity($('#action_get_form').val());
    } else {
        showAlert('warning', 'Seleccione una Provincia/Estado.');
    }
}

function saveCity() {
    if (form_city.valid()) {
        ajaxRequest($('#action_save_city').val(), {
            type: 'POST',
            data: form_city.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar la ciudad',
            success_message: 'La ciudad se guardo correctamente',
            success_callback: function (data) {
                modal_city.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormCity(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_city.find('.container_modal').html('');
            modal_city.find('.container_modal').html(data.html);
            form_city = $("#city_form");
            validateFormCity();
            setTimeout(function () {
                initMap();
                initAutocomplete();
            }, 1000)
            modal_city.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });


        }
    });
}


function validateFormCity() {
    $('#province_id').val(select_province.val());
    form_city.validate({
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
                            return $('#city_id').val();
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
                remote: 'Ya existe una ciudad con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            saveCity()
        }
    });
}

function initMap() {
    var lat = parseFloat("-0.16569591");
    var lng = parseFloat("-78.48122120");
    if (current_city != null) {
        lat = parseFloat($('#latitude').val());
        lng = parseFloat($('#longitude').val());
    } else {
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
    var default_position = {lat: lat, lng: lng};
    var marker;
    map = new GMaps({
        div: '#city_map',
        zoom: 14,
        center: default_position,
        bounds_changed: function () {
            marker.setPosition(map.getCenter());
            var lt = marker.getPosition().lat();
            var lg = marker.getPosition().lng();
            $('#latitude').val(lt.toFixed(8));
            $('#longitude').val(lg.toFixed(8));
        },
    });
     marker = map.createMarker({
        position: default_position,
    });

    map.addMarker(marker);

}

var autocomplete;

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById('name')),
        {types: ['(cities)'], componentRestrictions: {country: "EC"}});//validar region
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    map.setCenter({lat: lat, lng: lng});
}

function geolocate() {
    $('.pac-container').css('z-index', '1500');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
                position.coords.latitude, position.coords.longitude);
            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
                geolocation));
        });
    }
}




