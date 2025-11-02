var select2_patient = null;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;
var current_patient = null;
var modal_patient = null;
var details_portlet = null;
var form_patient = null;
var mConsultation_table = null;
var mConsultation_container = null;
var dataTable = null;
var currentMedicalCosultation = null;
var rows_selected = [];

$(function () {
    modal_patient = $('#modal');
    select2_patient = $('#patient_id');
    details_portlet = $('#details_portlet');
    mConsultation_container = $('#mConsultation_container');
    mConsultation_table = $('#mConsultation_table');
    currentMedicalCosultation = false;
    initStep1();


});

function newPatientStep1() {
    modal_patient.find('.modal-title').html('Nuevo Paciente');
    current_patient = null;
    getFormPatient($('#action_get_patients_form_step1').val());
}

function initStep1() {
    initSelect2(select2_patient, {
        width: '100%',
        ajax: {
            url: $('#action_load_patients_select2_step1').val(),
            dataType: 'json',
        },
    })
    .on('select2:select', function (e) {
        var data = e.params.data;
        current_patient = data.id;
        $('#patient_details').show();
        initPatientDetails();
        setValuePatientInformation(data);
        initStep2Managament();


    }).on("select2:unselecting", function (e) {
        details_portlet.html("<div class='alert alert-info alert-message-center ' role='alert'><strong> Bienvenido! </strong> Selecciona o Registra un paciente para comenzar. </div>");
        $('#medicalConsultation_portlet').hide();
        setValuePatientInformation(null);
    }).trigger('change');
}
function initStep2Managament(){
    PortletTools.init();
    initGridsStep2();
}
function initPatientDetails() {
    ajaxRequest($('#action_load_details_step1').val() + '/' + current_patient, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            details_portlet.html('');
            details_portlet.append(data.html);
            details_portlet.show();
            $('#medicalConsultation_portlet').show();
            initMedicalConsultation();

        }
    });
}

var rows_selected = [];

function initMedicalConsultation12() {
    console.log('initDatableAjax');
    dataTable = initDatableAjax($('#mConsultation_table'), {
        ajax: {
            url: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
            method: 'GET'
        },
        pageSize: 10,
        columns: [
            {
                field: "id",
                // title: '-',
                sortable: false, // disable sort for this column
                width: 'auto',
                // textAlign: 'center',
                // selector: {id: 'check-id', class: 'm-checkbox--solid m-checkbox--brand  m-id-check'},
                // template: function (t) {
                //     return '<input id=t.id class="m-checkbox--solid m-checkbox--brand  m-id-check" ></input>'
                // },
                template: function (row) {
                    return '<input type="checkbox" class="m-checkbox--solid m-checkbox--brand  m-id-check" value="' + row.id + '"  style="cursor: pointer;">';
                }
            },
            {
                field: "reason_consultation",
                title: "Razon",
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
            }, {
                field: "",
                width: 110,
                title: "Acciones",
                sortable: false,
                overflow: 'visible',
                template: function (row) {

                    return '<a href="#" onclick="deleteMedicalConsultation(' + row.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class=" far fa-trash-alt"></i>\
						</a>';
                }
            }
            // {
            //     field: "",
            //     width: 110,
            //     title: "Acciones",
            //     sortable: false,
            //     overflow: "visible",
            //     template: function (t) {
            //         return '<a href="javascript:;" onclick="editDoctor(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
            //     }
            // }
        ]
    });
    // on checkbox checked event


    $('#mConsultation_table.m_datatable tbody tr').on('click', 'input[class="m-id-check"]', function (e) {

        console.log('cloco')

    });
    return dataTable;
    // dataTable.reload();


    // dataTable = initDataTableAjax($('#mConsultation_table'), {
    //     processing: true,
    //     serverSide: true,
    //     url: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
    //     columns: [
    //         {"data": "name"},
    //         {
    //             "data": "status",
    //             'render': function (data, type, full, meta) {
    //                 if (data === 'ACTIVE') {
    //                     return '<span class="label label-sm label-success">Activo</span>';
    //                 } else {
    //                     return '<span class="label label-sm label-warning">Inactivo</span>';
    //                 }
    //             }
    //         },
    //         {},
    //     ],
    //
    // });
}

function initMedicalConsultation() {
    console.log('initDatableAjax');
    // $('#mConsultation_table').DataTable( {
    //     select: {
    //         style: 'single'
    //     }
    // } );


    // $('#mConsultation_table').DataTable({
    //     language: {
    //         sProcessin: "Procesando...",
    //         sLengthMenu: "Mostrar _MENU_ registros",
    //         sZeroRecords: "No se encontraron resultados",
    //         sEmptyTable: "Ningún dato disponible en esta tabla",
    //         sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    //         sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
    //         sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    //         sInfoPostFix: "",
    //         sSearch: "Buscar:",
    //         sUrl: "",
    //         sInfoThousands: ",",
    //         sLoadingRecords: "Cargando...",
    //         oPaginate: {
    //             sFirst: "Primero",
    //             sLast: "Último",
    //             sNext: "Siguiente",
    //             sPrevious: "Anterior"
    //         },
    //         oAria: {
    //             sSortAscending: ": Activar para ordenar la columna de manera ascendente",
    //             sSortDescending: ": Activar para ordenar la columna de manera descendente"
    //         },
    //         lengthMenu: "  _MENU_ marcas"
    //     },
    //     ajax: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
    //     deferRender: true,
    //
    //     columns: [
    //         {"data": "name"},
    //         {
    //             "data": "status",
    //             'render': function (data, type, full, meta) {
    //                 if (data === 'ACTIVE') {
    //                     return '<span class="label label-sm label-success">Activo</span>';
    //                 } else {
    //                     return '<span class="label label-sm label-warning">Inactivo</span>';
    //                 }
    //             }
    //         },
    //     ],
    //     rowId: 'id',
    //     select: {
    //         style: 'single'
    //     },
    // });
    var config = {
        processing: true,
        ajax: {
            url: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
        },
        columns: [
            {"data": "name"},
            {
                "data": "status",
                'render': function (data, type, full, meta) {
                    if (data === 'ACTIVE') {
                        return '<span class="label label-sm label-success">Activo</span>';
                    } else {
                        return '<span class="label label-sm label-warning">Inactivo</span>';
                    }
                }
            },
            {"data":"created_at"}
        ],
        actions: [
            {
                label: 'Editar',
                icon: '<i class=" fas fa-pencil-alt" aria-hidden="true"></i>',
                js_handle: 'editProduct',
                color_btn: 'yellow-stripe'
            }
        ]
    };
    dataTable = initDataTableAjax($('#mConsultation_table'),config);

    $('#mConsultation_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            console.log('clik')

        }
    } );

}

function initDataTableAjax(el,config) {
    el.dataTable().fnDestroy();

    var ajax_config = {};
    if (typeof  config.ajax !== 'undefined') {
        ajax_config = config.ajax;
    } else {
        ajax_config.url = config.url
    }


    return el.DataTable({
        processing: config.processing ? config.processing : false,
        serverSide: config.serverSide ? config.serverSide : false,
        ajax: ajax_config,
        // ajax: $('#action_load_mConsultation_step1').val() + '/' + current_patient,
        language: {
            sProcessin: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            },
            lengthMenu: "  _MENU_ marcas"
        },
        // lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
        pageLength: 10,
        // pagingType: "full_numbers",
        order: [
            [0, "asc"]
        ],
        columnDefs: [
            {
                targets: 'actions',
                orderable: false,
                render: function (data, type, row, meta) {
                    var actions = '';
                    if (typeof config.actions !== 'undefined') {
                        config.actions.forEach(function (action) {
                            actions += '<a href="#" onclick="' + action.js_handle + '(' + row.id + ')"  ' +
                                'class="btn default btn-xs ' + action.color_btn + '" title="' + action.label + '" >' + action.icon + ' ' + action.label + ' </a>';
                        });
                    }
                    return actions;
                }
            },
            {
                'targets': 'check',
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox">';
                }
            }
        ],
        deferRender: true,

        columns: config.columns,
        rowCallback: function (row, data, dataIndex) {
            if (typeof config.rowCallback !== 'undefined' && typeof config.rowCallback === 'function') {
                config.rowCallback(row, data, dataIndex);
            }
        },
        initComplete: function (settings, json) {
            if (typeof config.initComplete !== 'undefined' && typeof config.initComplete === 'function') {
                config.initComplete(settings, json);
            }
        },
        drawCallback: function (settings) {
            var api = this.api();
            if (typeof config.drawCallback !== 'undefined' && typeof config.drawCallback === 'function') {
                config.drawCallback(settings, api);
            }
        }
    });

}

function getFormPatient(action) {
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
        submitHandler: function (form) {
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
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
        clearMarkers(marker);
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
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

function initPatientForm() {
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
    form_patient = $("#patient_form");
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
            success_callback: function (result) {
                if (result.success) {
                    current_patient = result.data.id;
                    setSelectedValueSelect2(select2_patient, $('#action_load_patients_select2_step1').val(), current_patient);
                    initPatientDetails();
                    modal_patient.modal('hide');
                }
            }
        });
    }
}

function deleteMedicalConsultation() {
}
