var modal_patient = null;
var form_patient = $('#patient_form');
var list_patient = $("#container_patients");//admin patients
var dataTable = null;
var map = null;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;
var current_patient = null;
$(function () {
    modal_patient = $('#modal');
    dataTable = initDatableAjax($('#patient_table'), {
        ajax: {
            url: $('#action_load_patients').val(),
            method: 'GET'
        },
        pageSize: 10,
        columns: [
            {
                field: "document",
                title: "Documento",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
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
                    var html = "";
                    // html = '<a href="javascript:;" onclick="editPatient(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                    html += '<a href="javascript:;" onclick="managementPatient(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Gestión de Paciente"><i class="flaticon-cogwheel-2"></i></a>';
                    return html;
                }
            }
        ]
    })
});
var ManagementObj;

function managementPatient(id) {
    current_patient = id;
    list_patient = $("#container_patients");
    list_patient.hide();
    ManagementObj = new initManagement();
    ajaxRequest($('#action_get_management').val() + '/' + current_patient, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            ManagementObj.initManagement(data);

        }
    });
}

function editPatient(id) {
    current_patient = id;
    list_patient = $("#container_patients");
    list_patient.hide();
    form_patient = $("#container_patient_form");
    form_patient.html("");
    initPatientDetails();
}

function newPatient() {
    getFormPatient($('#action_get_form').val());
}

function savePatient() {
    if ($('#patient_form').valid()) {
        $('#address_location').val($('#input_address').val());
        $('#input_latitude').val(default_latitude);
        $('#input_longitude').val(default_longitude);

            ajaxRequest($('#action_save_patient').val(), {
                type: 'POST',
                data: $('#patient_form').serialize(),
                blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
                loading_message: 'Guardando...',
                error_message: 'Error al guardar el paciente',
                success_message: 'El paciente se guardo correctamente',
                success_callback: function (result) {
                    if (result.success) {
                        current_patient = result.data.id;
                        // initPatientDetails();
                        // current_patient = id;
                        $('#address_location').val('');
                        $('#input_latitude').val('');
                        $('#input_longitude').val('');
                        $('#container_patient_form').hide();
                        modal_patient.modal('hide');
                        list_patient = $("#container_patients");
                        list_patient.hide();
                        ManagementObj = new initManagement();
                        ajaxRequest($('#action_get_management').val() + '/' + current_patient, {
                            type: 'GET',
                            error_message: 'Error al cargar formulario',
                            success_callback: function (data) {
                                ManagementObj.initManagement(data);

                            }
                        });
                    }
                }
            });

    }
}

function getFormPatient(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            $('#details_portlet').hide();
            list_patient = $("#container_patients");
            list_patient.hide();
            form_patient = $("#container_patient_form");
            form_patient.html("");
            form_patient.append(data.html);
            initPatientFormCreate()
        }
    });

}

// var initMyMap = function () {
//
//     default_latitude = current_patient ? $('#input_latitude').val() : default_latitude;
//     default_longitude = current_patient ? $('#input_longitude').val() : default_longitude;
//     var map = new GMaps({
//         div: '#my_map_location',
//         lat: default_latitude,
//         lng: default_longitude
//     });
//     // if (current_patient) {
//     map.addMarker({
//         lat: default_latitude,
//         lng: default_longitude
//     });
//     // }
//
//     var handleAction = function () {
//         var text = $.trim($('#input_address').val());
//         GMaps.geocode({
//             address: text,
//             callback: function (results, status) {
//                 if (status == 'OK') {
//                     var latlng = results[0].geometry.location;
//                     default_latitude = latlng.lat();
//                     default_longitude = latlng.lng();
//                     map.setCenter(latlng.lat(), latlng.lng());
//                     map.addMarker({
//                         lat: latlng.lat(),
//                         lng: latlng.lng()
//                     });
//                     mApp.scrollTo($('#my_map_location'));
//                 }
//             }
//         });
//     }
//
//     $('#search_btn_map').click(function (e) {
//         e.preventDefault();
//         handleAction();
//     });
//
//     $("#input_address").keypress(function (e) {
//         var keycode = (e.keyCode ? e.keyCode : e.which);
//         if (keycode == '13') {
//             e.preventDefault();
//             handleAction();
//         }
//     });
// }

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

function initPatientFormCreate() {
    if (current_patient) {

        $('#input_address').val($('#address_location').val());
    }
    validateFormPatient();
    $('#send').click(function () {
        setTimeout(function () {  // Control to show ajax loader in Chrome/IE
            savePatient();
        }, 50);
    });

    $("#cancel").click(function () {
        window.location.reload()
    });

    $('#birthday_date').datepicker({
        format: "yyyy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        autoclose: true,
    });
    initMyMap();
}

function initPatientFormModal() {
    validateFormPatient();
    $('#birthday_date').datepicker({
        format: "yyyy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        autoclose: true,
    });
    $('#input_address').val($('#address_location').val());
    default_latitude = current_patient ? $('#input_latitude').val() : 0.3444677;
    default_longitude = current_patient ? $('#input_longitude').val() : -78.1222843;
    initMyMap();
}

function initPatientDetails() {


    ajaxRequest($('#action_load_details').val() + '/' + current_patient, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            $('#address_location').val('');
            $('#input_latitude').val('');
            $('#input_longitude').val('');
            $('#form_portlet').hide();
            $('#details_portlet').html('');
            $('#details_portlet').append(data.html);
            $('#details_portlet').show();
            $('#edit_patient_portlet').click(function () {
                getFormPatient($('#action_get_form').val() + '/' + current_patient);
            })
        }
    });


}

function removeNumbers(text) {
    var cont = 0;
    for (var i = text.length - 1; i >= 0; i--) {
        if ($.isNumeric(text[i])) {
            cont++;
        }
        else {
            return text.substr(0, text.length - cont);
        }
    }
}

function changeButton(el, status) {
    if (status === 'ACTIVE') {
        $(el).removeClass('btn-success');
        $(el).children().removeClass('la-check');
        $(el).addClass('btn-danger');
        $(el).children().addClass('la-trash-o');
        $(el).attr('title', 'Desactivar');
    } else if (status === 'INACTIVE') {
        $(el).removeClass('btn-danger');
        $(el).children().removeClass('la-trash-o');
        $(el).addClass('btn-success');
        $(el).children().addClass('la-check');
        $(el).attr('title', 'Activar');
    }
}

function validateFormPatient() {
    $('#patient_form').validate({
        rules: {
            name: {
                required: true,
                maxlength: 128
            },
            document: {
                required: true,
                remote: {
                    url: $('#action_validate_document').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#patient_id').val();
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
                required: 'Campo obligatorio'
            },
            document: {
                required: 'Campo Obligatorio.',
                remote: 'Ya existe un Paciente con ese documento.'
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
        submitHandler: function (form) {
            savePatient();
        }
    });
}