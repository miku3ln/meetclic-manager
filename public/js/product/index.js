var modal_product = null;
var form_product = null;
var dataTable = null;
var current_product = null;
var select_category = null;

$(function () {

    modal_product = $('#modal');
    dataTable = initDatableAjax($('#product_table'), {
        ajax: {
            url: $('#action_load_products').val(),
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
                        'managerOnClick': 'editProduct(' + t.id + ')',
                        'classBtn': 'btn-success',
                        'classSpan': 'mdi mdi-pencil',

                    });
                    return buttons;

                }
            }
        ]
    })
});

function editProduct(id) {
    current_product = id;
    modal_product.find('.modal-title').html('Editar producto');
    getFormProduct($('#action_get_form').val() + '/' + id);
}

function newProduct() {
    modal_product.find('.modal-title').html('Crear Producto');
    getFormProduct($('#action_get_form').val());
}


function saveProductNew() {
    var action = current_product == null ? 'creada' : 'actualizada';
    if (form_product.valid()) {
        var data = new FormData();
        var poData = form_product.serializeArray();
        for (var i = 0; i < poData.length; i++)
            data.append(poData[i].name, poData[i].value);
        var files_data = files;
        $.each(files_data['img_products'], function (index, file) {
            data.append('files[' + index + ']', file);
        });
        ajaxRequest($('#action_save_product').val(), {
            type: 'POST',
            data: data,
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Existieron problemas al guardar Productos.',
            success_message: 'El producto se ' + action + ' correctamente',
            success_callback: function (data) {
                modal_product.modal('hide');
                dataTable.reload();
            }
        }, true);
    }
}

function getFormProduct(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_product.find('.container_modal').html('');
            modal_product.find('.container_modal').html(data.html);
            form_product = $("#product_form");
            validateFormProduct();
            modal_product.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            select_category = initSelect2($('#category_id'), {
                ajax: {
                    url: $('#action_load_categories_select2').val(),
                    dataType: 'json',
                },
                dropdownParent:$('#modal'),

            });
            if ($('#selected_category').val()) {
                setSelectedValueSelect2(select_category, $('#action_load_categories_select2').val(), $('#selected_category').val());
            }
            initDropZone();

        }
    });
}

files = [];
function initDropZone() {
    Dropzone.autoDiscover = false;
    var config = $(this).data();
    files['img_products'] = [];
    $("div#mydropzone").dropzone({
        url: $('#action_upload_image').val(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        params: config,
        uploadMultiple: true,
        autoProcessQueue: parseInt(config.autoProcessQueue) == 1 ? true : false,
        // autoProcessQueue: false,
        // resizeWidth: config.maxWidth,
        // resizeHeight: config.maxHeight,
        dictInvalidFileType: 'No se puede cargar imagenes de este tipo',
        dictRemoveFile: 'Eliminar',
        addRemoveLinks: true,
        acceptedFiles: config.accepteFiles,
        init: function () {
            var myDropzone = this;
            myDropzone.on("addedfile", function (file) {
                var d = this.options.params;
                /**Control for duplicate file*/
                if (this.files.length) {
                    var _i, _len;
                    for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
                    {
                        if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                            this.removeFile(file);
                        }
                    }
                }
                files['img_products'] = this.files;
            });
            myDropzone.on("success", function (file, response) {
                file.image_id = response.imageId;
            });
            myDropzone.on("error", function (file) {
                this.removeFile(file);
                showAlert('error', 'Ocurrio un error al guardar la imagen');
            });

            myDropzone.on("removedfile", function (file) {
                var d = this.options.params;
                files['img_products'] = this.files;
                if (file.image_id) {//send delete image to server only edit vendor
                    deleteImage(file.image_id);
                }
            });
            /* control for accepted Files Type*/
            myDropzone.accept = function (file, done) {
                var d = this.options.params;
                /*control for accepted types of images and dimentions*/
                if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
                    showAlert('warning', 'Solo se permiten imágenes en formato: *' + this.options.acceptedFiles);
                    return this.removeFile(file);
                }
            }
        }
    });
}

function deleteImage(id) {
    ajaxRequest($('#action_delete_image').val() + '/' + id, {
        type: 'POST',
        data: null,
        loading_message: 'Eliminando imagen...',
        error_message: 'Existieron problemas al eliminar la imagen .',
        success_message: 'Imagen eliminada exitosamente.',
        success_callback: function (data) {
            $('#' + id).remove();
        }
    });
}

function validateFormProduct() {
    form_product.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#product_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    }
                }
            },
            category_id: {
                required: true
            }
        },
        messages: {
            name: {
                remote: 'Ya existe un producto con ese nombre.'
            },
            category_id: {
                required: 'Seleccione una categoria.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            saveProductNew()
        }
    });
}

