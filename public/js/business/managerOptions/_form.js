var modal_manager = null;
var form_manager = null;
var select2_patient = null;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;


var current_patient = null;
var modal_patient = null;
var form_patient = null;

$(function () {
    modal_patient = $('#modal');
    select2_patient = $('#patient_id');
    initStep1();
});

function editRegister(id) {
    modal_manager.find('.modal-title').html('Editar '+name_manager);
    getFormRegister($('#action_get_form').val() + '/' + id);
}

function newPatientStep1() {
    modal_patient.find('.modal-title').html('Nuevo Paciente');
    current_patient = null;
    getFormPatient($('#action_get_patients_form_step1').val());
}

function saveRegister() {
    if (form_manager.valid()) {
        ajaxRequest($('#action_save_'+model_entity).val(), {
            type: 'POST',
            data: form_manager.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el '+name_manager,
            success_message: 'El '+name_manager+' se guardo correctamente',
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
            form_manager = $("#"+model_entity+"_form");
            validateFormManager();
            modal_manager.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormManager() {
    form_manager.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                // remote: {
                //     url: $('#action_unique_name').val(),
                //     type: 'POST',
                //     data: {
                //         id: function () {
                //             return $('#antecedent_id').val();
                //         },
                //         _token: $('meta[name="csrf-token"]').attr('content'),
                //         name: function () {
                //             return $("#name").val().trim();
                //         },
                //     }
                // }
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una '+name_manager+' con ese nombre.'
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

function initStep1() {

    initSelect2($('#patient_id'), {
        width:'100%',
        ajax: {
            url: $('#action_load_patients_select2_step1').val(),
            dataType: 'json',
        },
    });
    select2_patient.on('select2:select', function (e) {
        var data = e.params.data;
        console.log(data)
        current_patient = data.id;
        $('#patient_details').show();
        initPatientDetails();
    });
}

function initPatientDetails() {


    ajaxRequest($('#action_load_details_step1').val()+'/'+current_patient, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            $('#details_portlet').html('');
            $('#details_portlet').append(data.html);
            $('#details_portlet').show();
            // $('#edit_patient_portlet').click(function () {
            //     getFormPatient($('#action_get_form').val() + '/' + current_patient);
            // })
        }
    });



}

function getFormPatient(action) {
    // if (current_doctor) {
    //
    //     $('#input_address').val($('#address_location').val());
    // }
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_patient.find('.container_modal').html('');
            modal_patient.find('.container_modal').html(data.html);
            form_patient = $("#step1_patient_form");
            modal_patient.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            initPatientForm()
        }
    });
}

function validateFormPatient() {
    form_patient.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
            },
            document: {
                required: true,
                remote: {
                    url: $('#action_validate_document_step1').val(),
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
                required: 'Campo Obligatorio.'
            },
            document: {
                required: 'Campo Obligatorio.',
                remote: 'Ya existe un paciente con ese documento.'
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

function initPatientForm(){
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

function savePatientStep1() {
    if (form_patient.valid()) {
        $('#address_location').val($('#input_address').val());
        $('#input_latitude').val(default_latitude);
        $('#input_longitude').val(default_longitude);

        ajaxRequest($('#action_save_patient_step1').val(), {
            type: 'POST',
            data: form_patient.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el paciente',
            success_message: 'El paciente se guardo correctamente',
            success_callback: function (data) {
                modal_patient.modal('hide');
                console.log(data);
                // initPatientDetails()
                // dataTable.reload();
            }
        });
    }
}
