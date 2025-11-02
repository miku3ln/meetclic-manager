function blockPage(label) {
    mApp.blockPage({
        overlayColor: '#000000',
        type: 'loader',
        state: 'success',
        message: label
    });
}

function blockContainer(el, label) {
    mApp.block(el, {
        overlayColor: '#000000',
        type: 'loader',
        state: 'success',
        message: label
    });
}

function unblockPage() {
    mApp.unblockPage();
}

function unblockContainer(el) {
    mApp.unblock(el);
}

function getConfigFile(hasFile) {

}

var successFunctionResult = function (managerParams, data) {

    managerParams.blockElement ? unblockContainer(managerParams.blockElement) : unblockPage();


    if (data.hasOwnProperty('success')) {
        var successType = 'error';
        var message = 'Nada';
        if (data.success) {
            successType = 'success';
        }
        if (data.hasOwnProperty('message') || data.hasOwnProperty('msj') || data.hasOwnProperty('msg') || data.hasOwnProperty("errors")) {

            if (data.hasOwnProperty('message')) {
                message = data.message;
            }
            if (data.hasOwnProperty('msj')) {
                message = data.msj;

            }
            if (data.hasOwnProperty('msg')) {
                message = data.msg;

            }
            var messageCurrent = [];
            if (data.hasOwnProperty("errors")) {
                $.each(data.errors, function (index, value) {
                    messageCurrent.push(value);
                });
                message = message + ' ' + messageCurrent.join('');
            }
        }
        if (message == '' || message == ' ') {
            if (managerParams.params.hasOwnProperty("success_message")) {
                message = managerParams.params.success_message;
            }
        }
        showAlert(successType, message);
    } else {
        if (data.hasOwnProperty("exception")) {
            var message = 'No existe key message';
            if (data.hasOwnProperty("message")) {
                message = data.message;
            } else if (data.hasOwnProperty("msj")) {
                message = data.msj;
            } else if (data.hasOwnProperty("msg")) {
                message = data.msg;
            }
            showAlert('error', message);

        } else {
            if (data.hasOwnProperty("success") && !data.success) {//Error messages from frontend
                if (managerParams.params.hasOwnProperty("success_message")) {
                    showAlert('error', managerParams.params.success_message);
                }

            } else {
                if (managerParams.params.hasOwnProperty("success_message")) {
                    showAlert('success', managerParams.params.success_message);
                }

            }
        }

    }
    if (managerParams.params.hasOwnProperty("success_callback")) {
        managerParams.params.success_callback(data);
    }

};

function ajaxRequest(url, params, hasFileUpload) {
    var type = params.hasOwnProperty("type") ? params.type : 'GET';
    var blockElement = params.hasOwnProperty("blockElement") ? params.blockElement : null;
    var data = params.hasOwnProperty("data") ? params.data : [];
    var error_message = params.hasOwnProperty("error_message") ? params.error_message : 'Ha ocurrido un error durante la petición, inténtelo nuevamente.';
    var loading_message = params.hasOwnProperty("loading_message") ? params.loading_message : 'Cargando...';
    var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
    var processData = true;
    if (typeof hasFileUpload !== 'undefined' && hasFileUpload) {
        contentType = false;
        processData = false;

        var formData = new FormData();

        Object.entries(data).forEach(([key, value]) => {
            formData.append(key, value);
        });
        data = formData;
    }
    blockElement ? blockContainer(blockElement, loading_message) : blockPage(loading_message);
    var isUpload = (typeof hasFileUpload !== 'undefined' && hasFileUpload);
    var tokenInformation = $('meta[name="csrf-token"]').attr('content');
    var managerSendFunctions = {
        type: type,
        blockElement: blockElement,
        data: data,
        error_message: error_message,
        loading_message: loading_message,
        contentType: contentType,
        processData: processData,
        isUpload: isUpload,
        params: params
    };

    var paramsConfig = (isUpload) ? {
        url: url,
        type: type,
        // Form data
        //datos del formulario
        data: data,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: contentType,
        processData: processData,
        headers: {
            'X-CSRF-TOKEN': tokenInformation
        },
        beforeSend: function (jqXHR, settings) {
            if (params.hasOwnProperty("beforeSend")) {
                params.beforeSend(jqXHR, settings);
            }
        },
        error: function (data) {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            //Error messages from server
            if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                showAlert(data.status, data.message);
            } else { //Error messages from frontend
                showAlert('error', error_message);
            }
            if (params.hasOwnProperty("error_callback")) {
                params.error_callback(data);
            }
        },
        success: function (data) {
            successFunctionResult(managerSendFunctions, data);
        },
        complete: function () {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            if (params.hasOwnProperty("complete_callback")) {
                params.complete_callback();
            }
        }
    } : {
        url: url,
        type: type,
        dataType: 'json',
        data: data,
        contentType: contentType,
        processData: processData,
        headers: {
            'X-CSRF-TOKEN': tokenInformation
        },
        beforeSend: function (jqXHR, settings) {
            if (params.hasOwnProperty("beforeSend")) {
                params.beforeSend(jqXHR, settings);
            }
        },
        error: function (data) {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            //Error messages from server
            if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                showAlert(data.status, data.message);
            } else { //Error messages from frontend
                showAlert('error', error_message);
            }
            if (params.hasOwnProperty("error_callback")) {
                params.error_callback(data);
            }
        },
        success: function (data) {
            successFunctionResult(managerSendFunctions, data);
        },
        complete: function () {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            if (params.hasOwnProperty("complete_callback")) {
                params.complete_callback();
            }
        }
    };
    $.ajax(paramsConfig);
}

function showAlert(type = 'info', message, hideAfter = 45000, loaderBg = null) {
    var options = {};
    switch (type) {
        case 'success':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#5ba035',
                icon: type
            };

            break;
        case 'info':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#3b98b5',
                icon: type
            };

            break;
        case'warning':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#da8609',
                icon: type
            };
            break;
        case'error':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#bf441d',
                icon: type
            };
            break;
        default:
            options = {
                heading: "Not Compatible!",
                text: message,
                position: 'top-right',
                loaderBg: '#da8609',
                icon: type
            };
    }
    if (loaderBg) {
        options['loaderBg'] = loaderBg;
    }
    options.hideAfter = hideAfter;
    $.NotificationApp.send(options);
}


function validationHighlight(element) {
    $(element).parent().addClass('has-danger').removeClass('has-success');
}

function validationSuccess(element) {
    $(element).parent().removeClass('has-danger').removeClass('has-success');
}

function validationErrorPlacement(error, element) {
    if (element.parent('.input-group').length) {
        error.insertAfter(element.parent());
    } else {
        element.parent().append(error);
    }
}

function initSelect2(el, options) {
    var default_options = {
        placeholder: options.placeholder ? options.placeholder : '- Seleccione -',
        disabled: options.disabled ? options.disabled : false,
        multiple: options.multiple ? options.multiple : false,
        dropdownParent: options.dropdownParent ? options.dropdownParent : null,
        allowClear: true,
        ajax: {
            url: options.ajax.url,
            dataType: options.ajax.dataType ? options.ajax.dataType : 'json',
            delay: 250,
            data: function (params) {
                var parameters = {
                    q: params.term,
                    page: params.page,
                };
                if (options.ajax.params && $.isArray(options.ajax.params)) {
                    $.each(options.ajax.params, function (index, value) {
                        if (value.type == 'selector') {
                            parameters[value.name] = value.element.val();
                        } else if (value.type == 'value') {
                            parameters[value.name] = value.element;
                        }
                    });

                }
                return parameters;
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                return {
                    results: data
                };
                // params.page = params.page || 1;
                //
                // return {
                //     results: data.items,
                //     pagination: {
                //         more: (params.page * 30) < data.total_count
                //     }
                // };
            },
            cache: true
        },
        width: options.width ? options.width : '100%'
        // escapeMarkup: function (markup) {
        //     return markup;
        // }, // let our custom formatter work
        // minimumInputLength: 1,
        // templateResult: formatRepo,
        // templateSelection: formatRepoSelection
    };
    return el.select2(default_options);
}

function setSelectedValueSelect2(el, url, selectedValue) {
    var parameter = '';
    if (el[0].multiple) {
        parameter = url + '?ids=' + selectedValue;
    } else {
        parameter = url + '?id=' + selectedValue;
    }
    ajaxRequest(parameter, {
        type: 'GET',
        error_message: 'Error al cargar elemento seleccionado',
        success_callback: function (data) {
            // create the option and append to Select2
            if (data.length > 0) {
                $.each(data, function (index, value) {
                    var option = new Option(data[index].text, data[index].id, true, true);
                    el.append(option).trigger('change');
                })

            }
        }
    });
}

function initDatableAjax(el, options) {
    var default_option = {
        data: {
            type: 'remote',
            source: {
                read: {
                    url: options.ajax.url,
                    method: options.ajax.method ? options.ajax.method : 'GET',
                    // custom headers
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    params: {
                        query: options.ajax.params || {}
                    },
                    map: function (raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                }
            },
            pageSize: options.pageSize ? options.pageSize : 10,
            saveState: {
                cookie: true,
                webstorage: true
            },
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true
        },
        layout: {
            theme: 'default',
            class: 'm-datatable--brand',
            scroll: true,
            height: null,
            footer: false,
            header: true,
            smoothScroll: {
                scrollbarShown: true
            },
            spinner: {
                overlayColor: '#000000',
                opacity: 0,
                type: 'loader',
                state: 'brand',
                message: true
            },
            icons: {
                sort: {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
                pagination: {
                    next: 'la la-angle-right',
                    prev: 'la la-angle-left',
                    first: 'la la-angle-double-left',
                    last: 'la la-angle-double-right',
                    more: 'la la-ellipsis-h'
                },
                rowDetail: {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'}
            }
        },
        sortable: true,
        pagination: true,
        // columns definition
        columns: options.columns,
        toolbar: {
            layout: ['pagination', 'info', "search"],
            placement: ['bottom'],  //'top', 'bottom'
            items: {
                pagination: {
                    type: 'default',
                    pages: {
                        desktop: {
                            layout: 'default',
                            pagesNumber: 6
                        },
                        tablet: {
                            layout: 'default',
                            pagesNumber: 3
                        },
                        mobile: {
                            layout: 'compact'
                        }
                    },
                    navigation: {
                        prev: true,
                        next: true,
                        first: true,
                        last: true
                    },
                    pageSizeSelect: [5, 10, 20, 30, 50, 100]
                },
                info: true
            }
        },
        translate: {
            records: {
                processing: 'Espere ...',
                noRecords: 'No hay resultado'
            },
            toolbar: {
                pagination: {
                    items: {
                        default: {
                            first: 'Inicio',
                            prev: 'Anterior',
                            next: 'Siguiente',
                            last: 'Ultimo',
                            more: 'Mas páginas',
                            input: 'Numero de página',
                            select: 'Registros por página'
                        },
                        info: 'Mostrando {{start}} - {{end}} de {{total}} registros'
                    }
                }
            }
        }
    };
    return el.mDatatable(default_option);
}


$(function () {
    if (jQuery.validator) {

        jQuery.extend(jQuery.validator.messages, {
            required: 'Este campo es obligatorio.',
            textOnly: 'Este campo admite s&oacute;lo texto.',
            alphaNumeric: 'Este campo admite s&oacute;lo caracteres alfa - num&eacute;ricos.',
            date: 'Este campo tiene un formato dd/mm/YYYY.',
            dateISO: 'Este campo tiene un formato YYYY-mm-dd.',
            digits: 'Este campo admite solo d&iacute;gitos.',
            number: 'Este campo admite solo n&uacute;meros enteros o decimales.',
            alphaNumericSpecial: 'Este campo admite s&oacute;lo caracteres alfa - num&eacute;ricos.',
            email: 'Este campo admite el formato <i>direccion@dominio.com</i>.',
            url: "Ingrese un URL v&aacute;lido.",
            numberDE: "Bitte geben Sie eine Nummer ein.",
            percentage: "Este campo debe tener un porcentaje v&aacute;lido.",
            validarUserName: "Nombre de Usuario no v\u00E1lido.",
            creditcard: "Ingrese un n&uacute;mero de tarjeta de cr&eacute;dito v&aacute;lido.",
            equalTo: "Las direcciones de correo no coinciden.",
            notEqualTo: "Ingrese un valor diferente.",
            accept: "Ingrese un valor con una extensi&oacute;n v&aacute;lida.",
            maxlength: $.validator.format("Este campo debe tener m&aacute;ximo {0} caracteres."),
            minlength: $.validator.format("Este campo debe tener m&iacute;nimo {0} caracteres."),
            rangelength: $.validator.format("Ingrese un valor entre {0} y {1} caracteres."),
            range: $.validator.format("Ingrese un valor entre {0} y {1}."),
            max: $.validator.format("Ingrese un valor menor o igual a {0}."),
            min: $.validator.format("Ingrese un valor mayor o igual a {0}."),
            cedulaEcuador: "Por favor ingrese una c&eacute;dula v&aacute;lida.",
            dateLessThan: $.validator.format("Ingrese una fecha menor o igual a {0}."),
            dateMoreThan: $.validator.format("Ingrese una fecha mayor o igual a {0}."),
            minStrict_zero: 'El valor debe ser mayor o igual a cero',
            minStrict: 'Ingrese un valor mayor a cero',
            dateLessThanDate: 'La fecha "Desde" debe ser menor o igual a la fecha en el campo "Hasta".',
            extension: 'Ingrese un archivo con una extensi\u00F3n jpg, jpeg o png.'
        });
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if ($.fn.datepicker) {

        if ($.fn.datepicker.dates) {
            $.fn.datepicker.dates['en'] = {
                days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Limpiar",
                format: "yyyy-mm-dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
        }
    }


    $('.m-menu__item--active').parents('li').addClass('m-menu__item--open');
});


function setValuesS2Multiple(params) {

    var elementS2 = params['elementS2'];
    var data = params['data'];
    var dataCurrent = data;
    for (var keyData in dataCurrent) {
        if (dataCurrent.hasOwnProperty(keyData)) {
            var option = new Option(dataCurrent[keyData], keyData, true, true);
            elementS2.append(option).trigger('change');
        }
    }


}

function getButtonStringManager($params) {
    var managerOnClick = $params['managerOnClick'];
    var classSpan = $params['classSpan'] ? $params['classSpan'] : "mdi mdi-pencil";
    var classBtn = $params['classBtn'] ? $params['classBtn'] : "btn-success";

    var button = [
        '<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">',
        ' <div class="btn-group btn-group-sm">',
        '   <button onclick="' + managerOnClick + '" type="button" class="tabledit-edit-button btn ' + classBtn + ' active" style="float: none;">',
        '       <span class="' + classSpan + '"></span>',
        '  </button>',
        '</div>',
        '</div>'

    ];
    button = button.join('');

    return button;
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
        return 'iOS';

    } else if (userAgent.match(/Android/i)) {

        return 'Android';
    } else {
        return 'unknown';
    }
}
