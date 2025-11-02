var validate_first = false;
var before_url = "";
/*-------------INIT UPLOAD---------*/
//-----imagen---
var input_swicht_name_1;
var input_swicht_objet_1;
//----typo de cliente---
var input_swicht_name_2;
var input_swicht_objet_2;
//------------Variables Subida de Imagenes------------
//---------PARAMETROS Y ASIGNACIONES DE DATOS---
var change_img;
var input_img_id = "#" + $EntidadInfo.images.img1;
var input_img_change_id = "#" + $EntidadInfo["change"].imgchg1;
var dataFileImagen = {success: false};
var content_img;//name
var content_img_obj;
var prev_row_img;//name
var prev_row_img_obj;
var select_row_img;//name
var select_row_img_obj;
var btn_upload_img;//name
var btn_upload_img_obj;
var file_temp_img;//name
var file_temp_img_obj;
var prev_img;//name
var prev_img_obj;
//    ---------entidades imagens--
content_img = $EntidadInfo["upload-img"].content_img;
prev_row_img = $EntidadInfo["upload-img"].prev_row_img;
select_row_img = $EntidadInfo["upload-img"].select_row_img;
btn_upload_img = $EntidadInfo["upload-img"].btn_upload_img;
file_temp_img = $EntidadInfo["upload-img"].file_temp_img;
prev_img = $EntidadInfo["upload-img"].prev_img;
//-----------action--------
var url_action_upload = baseUrl + 'multimedia/multimedia/ajaxUploadTemp';
//var url_imagen_no_asignada = themeUrl + "/img/imagen_no_disponible.jpg";
var url_imagen_no_asignada = themeUrl + "/images/backend/imagen_no_disponible.jpg";

/*-------------END UPLOAD---------*/
function uploadData($scope) {
    $scope.initUpload = false;
    $scope.initLoadEventsUpload = function () {

        console.log(file_temp_img);
        $(file_temp_img).on("click", function () {
            console.log(this, dataFileImagen.success);
        });

        $(file_temp_img).change(function () {
            var file = $(file_temp_img)[0].files[0];
            var x = $(file_temp_img).val();
            if (file) {
                $type_extencion = file.type.split("/");
                extension_allow = extencionsAllow($type_extencion[0], $type_extencion[1]);
                if (extension_allow) {
                    upload({
                        successCall: function (data) {
                            var upload_allow = false;
                            var data_set = "";
                            var change_img = false;
                            var error = false;
                            var data_set_url = "";
                            if (data.success) {
                                upload_allow = true;
                                data_set_url = data.data.src;
                                data_set = data.data.name;
                                change_img = true;
                            } else {
                                change_img = false;
                                data_set = before_url;
                                data_set_url = data_set;
                            }


                            if (!upload_allow) {// hay carga d imagen correcta

                                if ($scope.gestion_data[$scope.section.fields[keyDataManager].id]) {
                                    data_set = $scope.gestion_data[$scope.section.fields[keyDataManager].id];
                                    error = true;
                                    data_set_url = data_set;

                                }
                            }
                            var params = {
                                element_gestion: $scope.section.fields[keyDataManager].id,
                                error: error,
                                data_set: data_set
                            };
                            $scope.setValidationElement(params);

                            $(input_img_change_id).val(change_img);
                            $(prev_img).attr('src', data_set_url);//previa imagen
                            var key_data_name = "change_url";
                            $scope.gestion_data[key_data_name] = change_img;
                        }, element: file_temp_img.split("#")[1],
                        dataFile: 1
                    });
                } else {
                    bootbox.alert('El archivo seleccionado no es una imagen');
                }
            } else {
                console.log("empty");
            }

        });
        //------------GESTION DE SUBIDA D IMAGENS---
        $(btn_upload_img).click(function () {

            var error = false;
            if (!validate_first) {
                error = true;
                validate_first = true;
            } else {
                if ($scope.gestion_data[$scope.section.fields[keyDataManager].id]) {
                    error = true;
                }
            }
            var params = {
                element_gestion: $scope.section.fields[keyDataManager].id,
                error: error,
                data_set: $scope.gestion_data[$scope.section.fields[keyDataManager].id]
            };
            $scope.setValidationElement(params);
            if (dataFileImagen.success) {
                $(file_temp_img).click();
            } else {
                $(file_temp_img).click();
            }
            return false;
        });
    }

    var keyDataManager = 4;
    $scope.url_img_obj = {
        prev_img: "",
        btn_upload_img: "",
        file_temp_img: ""
    };

    $scope.setValidationElement = function (params) {
        var element_gestion = params.element_gestion;
        var error = params.error;
        if (error) {//sin errors
            $scope.gestion_data_frm[element_gestion].$touched = false;
            $scope.gestion_data_frm[element_gestion].$error = {};
            var key_data_name = element_gestion;
            $scope.gestion_data[key_data_name] = params.data_set;
        } else {
            $scope.gestion_data_frm[element_gestion].$touched = true;
            $scope.gestion_data_frm[element_gestion].$error = {required: true};
            var key_data_name = element_gestion;
            $scope.gestion_data[key_data_name] = params.data_set;
        }
        $scope.$apply();
    }


    function upload(options) {
//información del formulario
//    var inputFileImage = document.getElementById('file_temp_producto');
        var inputFileImage = document.getElementById(options.element);
        if (inputFileImage.files[0]) {
            var file = inputFileImage.files[0];
            var formData = new FormData();
            formData.append('file', file);
            //hacemos la petición ajax
            $.ajax({
                url: url_action_upload,
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //una vez finalizado correctamente
                success: function (data) {
                    var json = JSON.parse(data);
                    if (options.successCall) {
                        options.successCall(json);
                        console.log(options.dataFile);
                        if (options.dataFile == 0) {
//                        dataFileAlbum = json;

                        }
                        if (options.dataFile == 1) {
                            dataFileImagen = json;

                        }
                    }

                },
                //si ha ocurrido un error
                error: function (data) {
                    $(prev_img).attr('src', before_url);
                },
                beforeSend: function (xhr, data) {
                    before_url = $(prev_img).attr('src');
                    $(prev_img).attr('src', themeUrl + 'plantilla_backend/assets/global/img/loader/flat/3.gif');
                    $(prev_img).addClass('tamano');
                },
                complete: function (data) {
                    var obj_result = jQuery.parseJSON(data.responseText);
                    if (obj_result.success == false) {
                        $(prev_img).attr('src', before_url);
                        alert(obj_result.errors);
                    }
                    $(prev_img).removeClass('tamano');
                }
            });
        }
    }

    $scope.setImagePreview = function (data_set_url) {
        if (data_set_url) {

            $(prev_img).attr('src', data_set_url);//previa imagen
        } else {
            $(prev_img).attr('src', "");//previa imagen

        }
    }


}
