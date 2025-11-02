var modal_doctor = null;
var form_doctor = null;
var dataTable = null;
var current_doctor = null;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;
$(function () {
    modal_doctor = $('#modal');
    dataTable = initDatableAjax($('#doctor_table'), {
        ajax: {
            url: $('#action_load_doctors').val(),
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
                        'managerOnClick': 'editDoctor(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })

});

function editDoctor(id) {
    modal_doctor.find('.modal-title').html('Editar Doctor');
    current_doctor = id;
    getFormDoctor($('#action_get_form').val() + '/' + id);
}


function initMyMap() {


    var map = new google.maps.Map(document.getElementById('my_map_location'), {
        center: {lat: parseFloat(default_latitude), lng: parseFloat(default_longitude)},
        zoom: 16,
        mapTypeId: 'roadmap',
        navigationControl: false,
        mapTypeControl: false,
        // scaleControl: false,
        // draggable: false,
    });

    var marker = new google.maps.Marker({
        position: {lat: parseFloat(default_latitude), lng: parseFloat(default_longitude)},
        map: map,
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('input_address');
    var searchBox = new google.maps.places.SearchBox(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        clearMarkers(marker);
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));
            default_latitude = place.geometry.location.lat();
            default_longitude = place.geometry.location.lng();
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
               bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    $('#search_btn_map').click(function (e) {
        e.preventDefault();
        // handleAction();
    });

    $("#input_address").keypress(function (e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            e.preventDefault();
            // handleAction();
        }
    });
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers(marker) {
    marker.setMap(null);
}


function newDoctor() {
    modal_doctor.find('.modal-title').html('Nuevo Doctor');
    current_doctor = null;
    getFormDoctor($('#action_get_form').val());
}



function saveDoctor() {
    if (form_doctor.valid()) {
        $('#address_location').val($('#input_address').val());
        $('#input_latitude').val(default_latitude);
        $('#input_longitude').val(default_longitude);

        ajaxRequest($('#action_save_doctor').val(), {
            type: 'POST',
            data: form_doctor.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el país',
            success_message: 'El doctor se guardo correctamente',
            success_callback: function (data) {
                modal_doctor.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getFormDoctor(action) {
    // if (current_doctor) {
    //
    //     $('#input_address').val($('#address_location').val());
    // }
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_doctor.find('.container_modal').html('');
            modal_doctor.find('.container_modal').html(data.html);
            form_doctor = $("#doctor_form");
            modal_doctor.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            initDoctorForm()
        }
    });
}

function validateFormDoctor() {
    form_doctor.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
            },
            document: {
                required: true,
                remote: {
                    url: $('#action_validate_document').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#doctor_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        document: function () {
                            return $("#document").val().trim();
                        }
                    }
                },
            },
            phone: {
                required: true,
            },
            movil: {
                required: true,
            }
        },
        messages: {
            name: {
                required: 'Campo Obligatorio.'
            },
            document: {
                required: 'Campo Obligatorio.',
                remote: 'Ya existe un Dr. con ese documento.'
            },
            phone: {
                required: 'Campo Obligatorio.'
            },
            movil: {
                required: 'Campo Obligatorio.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function(form){
            saveDoctor();
        }
    });
}

function initDoctorForm(){
    validateFormDoctor();
    $('#birthday_date').datepicker({
        format: "yyyy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        autoclose: true,
    });
    $('#input_address').val($('#address_location').val());
    default_latitude = current_doctor ? $('#input_latitude').val() : 0.3444677;
    default_longitude = current_doctor ? $('#input_longitude').val() : -78.1222843;
    initMyMap();
}
