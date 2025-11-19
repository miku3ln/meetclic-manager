var latLngCurrent = {lat: 0.2314799, lng: -78.271874};
var $managerTitlesProcess = {
    'popupManagerGoogleMaps': {//TODO CHASQUI-MANAGEMENT
        'details': {
            'title': 'Titulo:',
            'subtitle': 'Subtitulo:',
            'description': 'Descripcion:',
            'file_glb': 'Archivo Modelo',
            'file_src': 'Imagen',
            'allowSource': 'Permitir Recursos?',

        },
        'colors': {
            'title': 'Estilos & Colores',
            'lineColor': 'Color de linea',
            'lineOpacity': 'Opacidad de linea(%)',
            'lineThickness': 'Groso de linea(px)',
        },
        'btnDelete': 'Eliminar',
        'btnCancel': 'Cancelar',
        'btnOk': 'OK',
        'btnReturn': 'Regresar>>',
        'btnInitColors': 'Personalizar Colores>>',

    }
};
var $greyscale_style = [
    {
        featureType: "road.highway",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "landscape",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "transit",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "poi",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "poi.park",
        stylers: [
            {
                visibility: "on"
            }
        ]
    },
    {
        featureType: "poi.park",
        elementType: "labels",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "poi.park",
        elementType: "geometry.fill",
        stylers: [
            {
                color: "#d3d3d3"
            },
            {
                visibility: "on"
            }
        ]
    },
    {
        featureType: "poi.medical",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "poi.medical",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "road",
        elementType: "geometry.stroke",
        stylers: [
            {
                color: "#cccccc"
            }
        ]
    },
    {
        featureType: "water",
        elementType: "geometry.fill",
        stylers: [
            {
                visibility: "on"
            },
            {
                color: "#cecece"
            }
        ]
    },
    {
        featureType: "road.local",
        elementType: "labels.text.fill",
        stylers: [
            {
                visibility: "on"
            },
            {
                color: "#808080"
            }
        ]
    },
    {
        featureType: "administrative",
        elementType: "labels.text.fill",
        stylers: [
            {
                visibility: "on"
            },
            {
                color: "#808080"
            }
        ]
    },
    {
        featureType: "road",
        elementType: "geometry.fill",
        stylers: [
            {
                visibility: "on"
            },
            {
                color: "#fdfdfd"
            }
        ]
    },
    {
        featureType: "road",
        elementType: "labels.icon",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "water",
        elementType: "labels",
        stylers: [
            {
                visibility: "off"
            }
        ]
    },
    {
        featureType: "poi",
        elementType: "geometry.fill",
        stylers: [
            {
                color: "#d2d2d2"
            }
        ]
    }
];
(function (func) {
    $.fn.addClass = function () { // replace the existing function on $.fn
        func.apply(this, arguments); // invoke the original function
        this.trigger('classChanged'); // trigger the custom event
        return this; // retain jQuery chainability
    };
})($.fn.addClass); // pass the original function as an argument

(function (func) {
    $.fn.removeClass = function () {
        func.apply(this, arguments);
        this.trigger('classChanged');
        return this;
    };
})($.fn.removeClass);


async function getValuesPost(params) {
    var result = null;
    var allow = params.allow;
    var urlValidate = params['urlValidate'];
    var paramsPost = params['paramsPost'];
    var value = params['value'];
    if (allow) {
        if (value === '') {
            result = true;
        } else {
            await axios.post(urlValidate, paramsPost)
                .then(response => {
                    result = response.data;

                })
                .catch(function (error) {

                    result = false;
                }).finally(() => {
                    console.log('finally');

                });
        }


    } else {
        if (value === '') {
            result = true;
        }
    }
    return result;

}

//VALIDATE ERRORS VUE JS FORMS
function getValidateForm(params) {
    var success = true;
    var errors = [];
    var notValidate = [
        '$model', "$invalid", '$dirty', '$anyDirty', '$error', "$anyError", '$pending', '$params'

    ];
    var modelAttributes = {};
    if (typeof (params) != 'undefined') {

        if (params.hasOwnProperty('model')) {
            modelAttributes = params.model.attributes;
        }

    } else {
        if (typeof (this.$v.model.attributes) == 'object') {
            modelAttributes = this.$v.model.attributes;
        }
    }

    $.each(modelAttributes, function (key, value) {
        var allowValidate = $.inArray(key, notValidate) == 0 ? false : true;
        if (allowValidate) {
            if (value.$invalid) {

                errors.push(
                    {
                        'field': value,
                        'name': key
                    }
                );
                success = false;
            }
        }
    });

    var result = {
        success: success,
        errors: errors
    };
    return result;
}


function makeToast(params) {
    var $msjCurrent = params.msj;
    var $titleCurrent = params.title;
    var $typeCurrent = params.type;
    this.$notify({
        type: $typeCurrent,
        title: $titleCurrent,
        duration: 0,
        content: $msjCurrent,

    }).then(() => {
        // resolve after dismissed
        console.log('dismissed');
    });
}

function _destroyTooltip(selector) {
    $(selector).tooltip('hide');
}

function _resetManagerGrid() {
    this.managerMenuConfig = {
        view: false,
        menuCurrent: [],
        rowId: null
    };
}

function _managerMenuGrid(index, menu) {
    var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
    this._managerRowGrid(params);
}

function getMenuConfig(params) {

    var result = [];
    $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
        var setPush = {
            title: value["title"],
            "data-placement": value["data-placement"],
            icon: value["i-class"],
            data: value, rowId: params.rowId,
            managerType: value["managerType"],
            params: params,
            isUrl: value["isUrl"],
            url: value["url"],
        }
        result.push(setPush);
    });
    return result;

}


function getObjectLength(dataCurrent) {
    return Object.keys(dataCurrent).length;
}

function getDataInstanciaBootgrid(element_obj) {
    var instance_data_rows = element_obj.data(".rs.jquery.bootgrid");
    return instance_data_rows;
}

function searchElementJson(obj, attr, value) {
    $element = [NaN, -1];
    $.each(obj, function (i, v) {
        if (v[attr] == value) {
            $element[0] = v;
            $element[1] = i;
            return false;
        }
    });
    return $element;
}

function deleteRowBootgrid(element_obj, row_id) {
    element_obj.bootgrid("remove", [row_id]);
}

function addRowBootgrid(element_obj, $row) {
    element_obj.bootgrid("append", [$row]);
}



function _gridManager(elementSelect) {
    var vmCurrent = this;
    var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
    elementSelect.find("tbody tr").on("click", function (e) {
        var self = $(this);
        var dataRowId = $(self[0]).attr("data-row-id");
        var selectorRow;
        if (dataRowId) {
            var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
            var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
            elementSelect.find("tr.selected").removeClass("selected");
            var newEventRow = false;
            if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                var removeRowId = vmCurrent.managerMenuConfig.rowId;
                if (dataRowId == removeRowId) {
                    selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                    $(selectorRow).removeClass("selected");
                    vmCurrent._resetManagerGrid();
                } else {

                    newEventRow = true;
                }
            } else {
                newEventRow = true;
            }
            if (newEventRow) {
                selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                $(selectorRow).addClass("selected");
                vmCurrent.managerMenuConfig = {
                    view: true,
                    menuCurrent: vmCurrent.getMenuConfig({
                        rowData: rowData[0],
                        rowId: dataRowId,
                        newEventRow: newEventRow
                    }),
                    rowId: dataRowId
                };
            } else {

                vmCurrent.managerMenuConfig = vmCurrent.managerMenuConfig;
                var menuCurrent = vmCurrent.getMenuConfig({
                    rowData: rowData[0],
                    rowId: dataRowId,
                    newEventRow: newEventRow
                });

            }

        }
    });
}

function _saveModel() {

    var dataSendResult = this.getValuesSave();
    var dataSend = dataSendResult;
    var $scope = this;
    $scope.$v.$touch();
    var validateCurrent = this.validateForm();
    if (!validateCurrent) {
        $scope.submitStatus = 'error';
    } else {

        ajaxRequest(this.formConfig.url, {
            type: 'POST',
            data: dataSend,
            blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
            loading_message: $scope.formConfig.loadingMessage,
            error_message: $scope.formConfig.errorMessage,
            success_message: $scope.formConfig.successMessage,
            success_callback: function (response) {
                if (response.success) {
                    $scope._resetManagerGrid();
                    $scope.resetForm();
                    $($scope.gridConfig.selectorCurrent).bootgrid("reload");
                    $scope._viewManager(2);
                }
            }
        });

    }


}

function validateForm() {
    var currentAllow = this.getValidateForm();
    return currentAllow.success;
}

function resetForm() {
    this.$v.$reset();
    this.model = {
        attributes: this.getAttributesForm(),
        structure: this.getStructureForm()
    };
    this.model.attributes.id = null;
}

function _viewManager(typeView, rowId) {
    this.resetForm();
    var selectorGrid = '';
    if (this.gridConfig) {
        selectorGrid = this.gridConfig.selectorCurrent;
    } else if (this.gridSelectorCurrent) {
        selectorGrid = this.gridSelectorCurrent;

    }
    if (typeView == 1) {//create
        this.showManager = true;
        this.managerMenuConfig.view = false;
        showHideGridHeaderFooter({
            selectorGrid: selectorGrid,
            hide: true,
        });
        this.managerType = 1;
        this.onInitEventClickTimerForm();//CHANGE-FORM
    } else if (typeView == 2) {//admin
        this.showManager = false;

        showHideGridHeaderFooter({
            selectorGrid: selectorGrid,
            hide: false,
        });
        if (this.managerType == 1) {
            this.managerMenuConfig.view = false;
            this.managerType = null;

        } else {
            this.managerMenuConfig.view = true;
        }
    } else if (typeView == 3) {//update
        this.showManager = true;
        showHideGridHeaderFooter({
            selectorGrid: selectorGrid,
            hide: true,
        });
        this.managerMenuConfig.view = false;
        this.managerType = 3;
        this.onInitEventClickTimerForm();//CHANGE-FORM

    }
}

function getViewErrorForm(objValidate) {
    var result = false;
    if (!objValidate.$dirty) {
        result = objValidate.$dirty ? (!objValidate.$error) : false;
    } else {
        result = objValidate.$error;
    }
    return result;
}

function getNameAttribute(name) {
    var result = this.formConfig.nameModel + "[" + name + "]";
    return result;
}

function getClassErrorForm(nameElement, objValidate) {
    var result = null;
    result = {
        "form-group--error": objValidate.$error,
        'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
    };
    return result;
}

function _setValueForm(name, value) {
    this.model.attributes[name] = value;
    this.$v["model"]["attributes"][name].$model = value;
    this.$v["model"]["attributes"][name].$touch();
}

function getErrorHas(model, type) {

    var result = (model.$model == undefined || model.$model == "") ? true : false;
    return result;
}

function getViewError(model) {

    var result = (model.$dirty == true) ? true : false;
    return result;
}

function viewGetLabelForm(nameId, model) {
    var labelName;
    if (model) {
        labelName = model['structure'][nameId].label + (model['structure'][nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

    } else {
        labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

    }
    return labelName;
}

function onListenElementsForm(params) {
    params.objectElement.$touch();

}

var $methodsFormManager = {
    getLabelForm: viewGetLabelForm,//CHANGE-FORM
    _setValueForm: _setValueForm,//CHANGE-FORM
    getClassErrorForm: getClassErrorForm,//CHANGE-FORM
};
var $methodsFormValid = {
    onInitEventClickTimerForm: onInitEventClickTimerForm,//CHANGE-FORM
    onInitEventClickForm: onInitEventClickForm,//CHANGE-FORM
    onListenElementsForm: onListenElementsForm,//CHANGE-FORM
};

var $methodsManagerProcess = {
    viewProcessButton:viewProcessButton,

};
function viewProcessButton(params){
    var allowView=false;
    var haystack=this. configModelEntity.buttonsProcess;
    $.each(haystack, function (key, value) {
        if(value.type==params.type){
            allowView=true;
        }
    });

    return allowView;

}
var $shareManager = {
    getDataShare: $getDataShare,
    _shareType: $_shareType,

};

var $methodsBootgrid = {
    _destroyTooltip: _destroyTooltip,
    _resetManagerGrid: _resetManagerGrid,
    _managerMenuGrid: _managerMenuGrid,
    _gridManager: _gridManager,
    _managerTypes: _managerTypes
};

function _managerTypes(emitValues) {
    if (emitValues.type == "rebootGrid") {
        $(this.gridConfig.selectorCurrent).bootgrid("reload");
    } else if (emitValues.type == "resetComponent") {
        var componentName = emitValues.componentName;
        this[componentName].viewAllow = false;
        if (emitValues.allowReload) {
            $(this.gridConfig.selectorCurrent).bootgrid("reload");

        }
    }
}

var SHARE_TYPE_FACEBOOK = 1;
var SHARE_TYPE_WHATSAPP = 1;

function viewShare() {
    $(".container--manager").append("<div id='calc1'></div><div id='calc2'></div><div class='shareit'><a href='#' class='tweetit'><i class='fa fa-twitter'></i></a><a href='#' class='whatsappit'><i class='fa fa-whatsapp'></i></a><a href='#' class='linkedinit'><i class='fa fa-linkedin'></i></a><a href='#' class='facebookit'><i class='fa fa-facebook'></i></a><a href='#' class='googleit'><i class='fa fa-google-plus'></i></a></div>");

    var seltext = 'adlkadlkamdlkmdal';
    var via = 'a';
    var loc = 'https://meetclic.com';
    $(document).on("click", ".shareit a", function () {
        if ($(this).hasClass("tweetit")) window.open("https://twitter.com/share?text=" + seltext + "&amp;via=" + via, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=400');
        else if ($(this).hasClass("whatsappit")) window.open("https://api.whatsapp.com/send?text=" + seltext, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=400');
        else if ($(this).hasClass("linkedinit")) window.open("https://www.linkedin.com/shareArticle?mini=true&amp;url=" + loc + "&amp;title=" + seltext + "&amp;text=hola", '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=400');
        else if ($(this).hasClass("facebookit")) window.open("https://www.facebook.com/dialog/share?app_id=155994287915018&amp;href=" + loc + "&amp;quote=" + seltext, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=400');
        else if ($(this).hasClass("googleit")) window.open("https://plus.google.com/share?url=" + loc + "&amp;text=" + seltext, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=400');
        return false;
    });
}

function $_shareType(network) {
    console.log(network);
    this.networkManagerData = network;
    var paramsShare = this.getDataShare();
    console.log(paramsShare, this.informationShare);
    if (network.type == 0) {
        FB.ui(
            paramsShare,
            // callback
            function (response) {
                if (response && !response.error_message) {
                    var textManager = 'Se compartio con exito.';
                    $.NotificationApp.send({
                        heading: "Informacion!",
                        text: textManager,
                        position: 'bottom-left',
                        loaderBg: '#53BF82',
                        icon: 'success',
                        hideAfter: 5000

                    });
                } else {
                    console.log('Error while posting.');
                }
            }
        );
    } else if (network.type == 3) {

        var informationBusiness = this.informationShare;
        var phoneCurrent = this.informationShare.phone;
        let params = {
            dataParams: {
                phone: phoneCurrent,
                text: 'Saludos me comunico desde su Perfil de Meetclic:' + informationBusiness.urlManager,
            }


        };
        let urlCurrent = getUrlWhatsApp() + 'send?' + getStringParamsGet(params);
        window.open(urlCurrent);
    }

}

function $getDataShare() {

    var result = {
        title: 'Compartir',
        description: 'Descripcion',
        quote: "Comparte,Gana muchos premios con meetclic.",
        hashtags: "meetclic,products,migu3ln",
        'twitter-user': "vuejs",
        method: 'share',
        href: 'meetclic.com',
        picture: 'picture',
        caption: 'caption',
    };
    if (this.currentPage == 'authorSingle') {
        var informationBusiness = this.informationShare;
        var phoneCurrent = this.informationShare.phone;
        result = {
            title: informationBusiness.title,
            description: informationBusiness.descriptionData,
            quote: "Comparte,Gana muchos premios con meetclic.",
            hashtags: "meetclic,products,migu3ln",
            'twitter-user': "vuejs",
            method: 'share',
            href: informationBusiness.urlManager,
            picture: informationBusiness.source,
            caption: 'Transporte',
        };
    } else {
        var businessData = $dataManagerPage['business'];
        var hrefCurrent = businessData.hasOwnProperty('urlBusiness') ? businessData
            .urlBusiness : 'meetclic.com';
        result = {
            title: businessData.information.category + '-' + businessData.information.title,
            description: businessData.aboutUs.hasOwnProperty('description') ? businessData
                .aboutUs.description : 'Not Description.',
            quote: "Comparte,Gana muchos premios con meetclic.",
            hashtags: "meetclic,products,migu3ln",
            'twitter-user': "vuejs",
            method: 'share',
            href: hrefCurrent,
            picture: businessData.information.srcMain,
            caption: businessData.information.category,
        };
    }


    return result;
}

function onInitEventClickTimerForm(params) {
    var _this = this;
    var initData = setTimeout(function () {
        _this.onInitEventClickForm();
    }, 1000);
    setTimeout(function () {
        clearTimeout(initData);
        console.log('Temporizador original cancelado después de 5 segundos');
    }, 5000);
}

function getValuesEntity(params) {
    var result = null;
    if (params.value) {
        var valoresDentroParentesis = params.value.match(/\[(.*?)\]/);
        if (valoresDentroParentesis && valoresDentroParentesis.length > 1) {
            var valorDentroParentesis = valoresDentroParentesis[1];

            result = valorDentroParentesis;
        } else {
            result = null;

        }
    }


    return result;
}

function onInitEventClickForm(params) {
    var _this = this;
    $('form').off('click');
    $('form').on('click', function (e) {
        if (e.target.nodeName == 'BUTTON' || e.target.nodeName === 'INPUT' || e.target.nodeName === 'SELECT' || e.target.nodeName === 'CHECKBOX' || e.target.nodeName === 'RADIO' || e.target.nodeName == 'SPAN' || e.target.nodeName === 'TEXTAREA' || e.target.nodeName === 'DIV') {
            var targetName = $(e.target).attr('name');
            var objectElement = null;
            var elementCurrentName = null;
            if (e.target.nodeName === 'DIV') {
                if ($(e.target).attr('class') == 'note-editable card-block') {

                    targetName = $(e.target).parent().parent().parent().find('textarea').attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                } else if ($(e.target).attr('class') == 'switch-button enabled') {
                    targetName = $(e.target).parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                } else if ($(e.target).attr('class') == 'button') {
                    targetName = $(e.target).parent().parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                }
            }

            if ($(e.target).attr('type') == 'file') {
                targetName = $(e.target).attr('name');
                elementCurrentName = getValuesEntity({
                    value: targetName
                });
            }
            if (e.target.nodeName == 'BUTTON') {
                if ($(e.target).attr('class') == 'datetime-picker__button') {
                    targetName = $(e.target).parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                }
            }
            if (e.target.nodeName === 'SPAN') {
                if ($(e.target).attr('class') == 'select2-selection__rendered') {
                    elementCurrentName = $(e.target).attr('id').split('select2-')[1].split('-container')[0];
                } else if ($(e.target).attr('class') == 'select2-selection__placeholder') {
                    elementCurrentName = $(e.target).parent().attr('id').split('select2-')[1].split('-container')[0];
                }
            } else {
                var nameModel = _this.formConfig.nameModel;
                if (nameModel) {
                    if (_this.$v) {
                        if (_this.$v.model) {
                            elementCurrentName = getValuesEntity({
                                value: targetName
                            });

                        } else if (_this.$v.modelGallery) {
                            elementCurrentName = getValuesEntity({
                                value: targetName
                            });
                        } else if (false) {

                        }
                    }


                } else {

                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });


                }
                // ;
            }
            if (_this.$v) {
                if (_this.$v.model) {
                    objectElement = _this.$v.model.attributes[elementCurrentName];

                } else if (_this.$v.modelGallery) {
                    objectElement = _this.$v.modelGallery.attributes[elementCurrentName];

                } else if (_this.$v.modelRoutes) {
                    objectElement = _this.$v.modelRoutes.attributes[elementCurrentName];

                } else if (_this.$v.modelPanorama) {
                    objectElement = _this.$v.modelPanorama.attributes[elementCurrentName];

                }
            } else {

            }

            if (objectElement && elementCurrentName) {
                _this.onListenElementsForm({
                    'element': elementCurrentName,
                    objectElement: objectElement
                });
            }


        }

    });

}

function _managerCheckGrid(params) {

    var selectorInit = params['selectorInit'];
    var elementInit = params['elementInit'];
    this.managerCustomer = params['managerCustomerFunction'];
    var selectorGrid = selectorInit;
    this.initManagerData = {
        'selectorInit': selectorInit,
        'elementInit': elementInit,

    };
    var paramsCheck = {
        selectorInit: selectorInit

    };
    this.columnsPrint = [];
    this.rowsKeysData = params['rowsDataManager']['rowsKeysData'];
    this.rowsDataDetailsAll = params['rowsDataManager']['rowsDataDetailsAll'];
    this.rowsDataDetailsAllAux = [];
    this.rowsData = [];
    this.dataCheckListSelect = [];
    var $scope = this;
    this.managerCurrent = {
        columnsPrint: this.columnsPrint,
        rowsDataDetailsAll: this.rowsDataDetailsAll,
        rowsDataDetailsAllAux: this.rowsDataDetailsAllAux,
        rowsData: this.rowsData,
        dataCheckListSelect: this.dataCheckListSelect,
        rowsKeysData: this.rowsKeysData,

    };

    //STEP 1
    function initEventsGrid() {
        $scope.initValuesManager();
        var columnsPrint = $scope.columnsPrint;
        //        ---Variables datagrid---
        var elementInit = params.elementInit;
        var selectorInit = params.selectorInit;
        $scope.getDataSelected($scope.rowsKeysData);
        //        ----Agregar al bootgrid los respectivos check en cada fila
        //        $rowsData=contiene todos los ids seleccionados---
        setProp($scope.rowsKeysData);
        setElementValue($scope.rowsKeysData);
        $.each($scope.rowsKeysData, function (index, value) {
            rowId = value;
            setClassRowSelected(rowId, true);
        });

        //        -----Obtener los datos del paginado---
        var data_rows_page = elementInit.bootgrid("getCurrentRows");
        //        ---obtiene el ide dl paginado---
        var pageCurrent = elementInit.bootgrid("getCurrentPage");
        //        ------Realizar l cambio del html del encabezado----- unicamente la primera col del encabezado
        //debido a q es la primera columna dond s asigna los check
        $(selectorInit + " thead tr th:first-child");
        var elementModifier = $(selectorInit + " thead tr th:first-child");
        var string_html = '<input class="check-list-manager check-list-manager--all " my-directive id="checkbox-all-' + pageCurrent + '"  type="checkbox" value="all">'
        //        --------MEETODO PARA PODER GENERAR LA SELECCION-------
        elementModifier.html(string_html);
        //        ----Obtener todos los elementos seleccionados de este paginado guardaodos en el array data add
        var dataPageSelect = getSelectAllPag($scope.rowsKeysData, data_rows_page);
        //     ----set all n checkall--
        setPropAll(pageCurrent, dataPageSelect, data_rows_page);
        elementInit.find(".check-list-manager").on("click", function (e) {
            var key_element = $(this).attr("id");//obtener el elemento clickeado
            var rowIdCurrent = $(this).val();//obtener el elemento clickeado
            var isPropElement = $("#" + key_element).prop('checked');
            var element_array = [];
            if (rowIdCurrent == "all") {//todo seleccionar todos

                var element_array = getDataRows(data_rows_page);
                if (isPropElement == false) {//deseleccionar

                    removeDataArray(element_array);
                    $.each(element_array, function (index, value) {
                        setPropUnit(value, false);
                    });
                } else {//seleecciono
                    setDataRowsId(element_array);
                    $.each(element_array, function (index, value) {
                        setPropUnit(value, true);
                    });
                }

            } else {
                rowIdCurrent = parseInt(rowIdCurrent);
                element_array.push(rowIdCurrent);
                if (isPropElement == false) {//deseleccionar
                    removeDataArray(element_array);
                    setClassRowSelected(rowIdCurrent, false);

                } else {//seleecciono
                    setDataRowsId(element_array);
                    setClassRowSelected(rowIdCurrent, true);
                }
                var dataPageSelect = getSelectAllPag($scope.rowsKeysData, data_rows_page);
                setPropAll(pageCurrent, dataPageSelect, data_rows_page);

            }


            //            ---AGREGA LOS IDS ESCOGIDOS-*---

            setElementValue($scope.rowsKeysData);
            //Approductos.js
            $scope.getDataSelected($scope.rowsKeysData);

            $scope.emmitManager({
                columnsPrint: $scope.columnsPrint,
                rowsDataDetailsAll: $scope.rowsDataDetailsAll,
                rowsDataDetailsAllAux: $scope.rowsDataDetailsAllAux,
                rowsData: $scope.rowsData,
                dataCheckListSelect: $scope.dataCheckListSelect,
                rowsKeysData: $scope.rowsKeysData,

            });

        });
        elementInit.find("tbody tr").on("click", function (e) {
            var targetInitClick = $(e.target).hasClass('check-list-manager');
            if (!targetInitClick) {// click input checkbox
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var selectorChecklist = '#checkbox-' + dataRowId;
                var selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                if ($(selectorChecklist).prop('checked')) {//isCheck
                    $(selectorRow).removeClass("selected");
                } else {
                    $(selectorRow).addClass("selected");
                }
                $(selectorChecklist).click()
            }
            e.stopPropagation();
        }).not(".check-list-manager");


    }

    //STEP 2
    this.initValuesManager = function () {
        $scope.columnsPrint = [];
        $scope.columnsPrint = $scope.getDataColumnsPrint();
    }
    //STEP 3
    this.getDataColumnsPrint = function () {
        var result_data = [];
        var data = $($scope.initManagerData.selectorInit + "-grid-header ul.dropdown-menu.pull-right li input");
        $.each(data, function (value, key) {
            var name_key = $(value).attr("name");
            var name_key_checked = $(value).prop('checked');
            var string_data = '{"' + name_key + '":' + name_key_checked + '}';
            var obj_data = jQuery.parseJSON(string_data);
            result_data.push(obj_data);
        });
        return result_data;
    };

    //STEP 4,STEP 9 R10
    this.getDataSelected = function (dataCheckListSelect) {

        //        ---INIT RESETEO PRINT --
        $scope.initValuesManager();
        //        ---END RESETEO PRINT --

        var data = $scope.initManagerData.elementInit.bootgrid("getCurrentRows");
        $.each(data, function (key, value) {
            var needle = parseInt(value.id);
            var isNeedle = $.inArray(needle, $scope.rowsDataDetailsAllAux);
            if (isNeedle == -1) {
                $scope.rowsDataDetailsAllAux.push(needle);
                $scope.rowsDataDetailsAll.push(value);
            } else {
                $scope.updateDataRowRegisterDetails(needle, value);
            }
        });

        $scope.rowsData = [];
        $scope.dataCheckListSelect = dataCheckListSelect;
        var dataCurrent = dataCheckListSelect;
        $.each(dataCurrent, function (value, key) {
            var info_row = $scope.getDataRows(key);
            if (info_row) {
                $scope.rowsData.push(info_row);
            }
        });

    }
    /* STEP 4 R1*/
    $scope.getDataRows = function (needle) {
        var result = null;
        var data = $scope.rowsDataDetailsAll;
        $.each(data, function (value, key) {
            if (parseInt(key.id) == parseInt(needle)) {
                result = key;
                return result;
            }
        });
        return result;
    }
    /* STEP 4 R*/
    $scope.updateDataRowRegisterDetails = function (needle, value_set) {
        var result = {};
        var data = $scope.rowsDataDetailsAll;
        $.each(data, function (value, key) {
            if (parseInt(key.id) == parseInt(needle)) {
                result = key;
                $scope.rowsDataDetailsAll[value] = value_set;
                return result;
            }
        });
        return result;
    }
    initEventsGrid();

    $scope.emmitManager = function (dataManager) {
        $scope.managerCurrent = dataManager;
        $scope.managerCustomer($scope.managerCurrent);


    }

    //---asigna los valores seleccionados en el grid agregando un chek---
    //STEP5


    function setProp(data_add) {
        $.each(data_add, function (index, value) {
            key_element = value;
            $("#checkbox-" + key_element).prop('checked', true);
        });
    }

    //STEP 6,STEP 9 R9
    function setElementValue(data_rows) {
        var select_add = data_rows.join(",");
    }

    //STEP 7 ,STEP 9 R7
    function getSelectAllPag(data_all, data_row) {
        var element_array = [];
        $.each(data_row, function (index, value_1) {
            var isNeedle = $.inArray(value_1.id, data_all);
            if (isNeedle >= 0) {//si no esta agregado agregar
                element_array.push(value_1.id);
            }
        });
        return element_array;
    }

    //STEP 8,STEP 9 R8
    function setPropAll(key_element, all_selected, row_data) {
        var checked = false;
        if (all_selected.length == row_data.length) {//si es igual select all
            checked = true;
        }
        $("#checkbox-all-" + key_element).prop('checked', checked);
    }

    //STEP 9 R
    function getDataRows(data_rows) {
        var element_array = [];
        $.each(data_rows, function (index, value) {
            element_array.push(parseInt(value.id));
        });
        return element_array;

    }

    //---remueve datos del array agregado los valores
    //STEP 9 R1,STEP 9 R5
    function removeDataArray(data_remove) {
        $.each(data_remove, function (index, value) {
            var isNeedle = $.inArray(parseInt(value), $scope.rowsKeysData);
            if (isNeedle >= 0) {//si no esta agregado agregar
                $scope.rowsKeysData.splice($scope.rowsKeysData.indexOf(value), 1);
            }
        });
    }

    //STEP 9 R2,STEP 9 R4
    function setPropUnit(key_element, checked) {
        $("#checkbox-" + key_element).prop('checked', checked);
        setClassRowSelected(key_element, checked);
    }

    //---agrgar datos al arreglo la informacion ---
    //STEP 9 R3,STEP 9 R6
    function setDataRowsId(data_add) {
        $.each(data_add, function (index, value) {
            var isNeedle = $.inArray(value, $scope.rowsKeysData);
            if (isNeedle == -1) {//si no esta agregado agregar
                $scope.rowsKeysData.push(value);
            }
        });
    }

    function setClassRowSelected(rowId, checked) {
        var selectorGrid = $scope.initManagerData.selectorInit;
        var selectorRow = selectorGrid + " tr[data-row-id='" + rowId + "']";
        if (checked) {//isCheck
            if (!$(selectorRow).hasClass('selected')) {
                $(selectorRow).addClass("selected");
            }
        } else {
            $(selectorRow).removeClass("selected");
        }
    }

}

function getAjaxRequest(params) {
    var url = params.hasOwnProperty("url") ? params.url : 'none';
    var type = params.hasOwnProperty("type") ? params.type : 'GET';
    var dataType = params.hasOwnProperty("dataType") ? params.dataType : 'json';

    var blockElement = params.hasOwnProperty("blockElement") ? params.blockElement : null;
    var data = params.hasOwnProperty("data") ? params.data : [];
    var error_message = params.hasOwnProperty("error_message") ? params.error_message : 'Ha ocurrido un error durante la petición, inténtelo nuevamente.';
    var loading_message = params.hasOwnProperty("loading_message") ? params.loading_message : 'Cargando...';
    var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
    var tokenInformation = $('meta[name="csrf-token"]').attr('content');
    var processData = true;
    var paramsConfig = {
        url: url,
        type: type,
        dataType: dataType,
        // Form response
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
        error: function (response) {
            if (params.hasOwnProperty("errorCallback")) {
                params.errorCallback(response);
            }
        },
        success: function (response) {

            if (params.hasOwnProperty("successCallback")) {
                params.successCallback(response);
            }

        },
        complete: function () {
            if (params.hasOwnProperty("completeCallback")) {
                params.completeCallback();
            }
        }
    }
    $.ajax(paramsConfig);
}

function initApisSocialNetworks() {
    var appIdFacebook = '642760929635985';
    $.ajaxSetup({cache: true});
    $.getScript('https://connect.facebook.net/en_US/sdk.js', function () {
        FB.init({
            appId: appIdFacebook,
            version: 'v2.7' // or v2.1, v2.2, v2.3, ...
        });

    });
}

function getUrlWhatsApp() {
    var userAgentData = navigator.userAgentData;
    var typeSmarth = userAgentData.platform;

    var urlRoot = 'https://api.whatsapp.com/';
    switch (typeSmarth) {
        case 'Windows':
            urlRoot = 'https://web.whatsapp.com/';
            break;

        case 'Android':

            urlRoot = 'https://api.whatsapp.com/';
            break;
        case 'iOS':

            urlRoot = 'https://api.whatsapp.com/';
            break;
        default:
            urlRoot = 'https://api.whatsapp.com/';

    }
    var urlCurrent = urlRoot;
    var result = urlCurrent;
    console.log(typeSmarth, urlRoot);
    return result;

}

function getStringParamsGet(params) {
    var dataParams = params['dataParams'];
    var recursiveDecoded = decodeURIComponent($.param(dataParams));
    return recursiveDecoded;
}

function getGreyScaleStyle() {
    return $greyscale_style;
}

/*
GRIDS MANAGER METHODS*/
function showHideGridHeaderFooter(params) {
    var hide = params["hide"];
    var selectorGrid = params["selectorGrid"];
    var selectorHeaderGrid = selectorGrid + "-header";
    var selectorFooterGrid = selectorGrid + "-footer";

    if (hide) {
        $(selectorHeaderGrid).hide();
        $(selectorFooterGrid).hide();
    } else {
        $(selectorHeaderGrid).show();
        $(selectorFooterGrid).show();
    }
}

function getCSSCurrentBootGrid() {


    //https://fontawesome.com/search?q=sort&o=r
    //fa fa-solid fa-sort-up
    //fa fa-solid fa-sort-down
    var result = {
        header: "bootgrid-header",
        table: "xywer-tbl-admin",
        iconRefresh: "remixicon-refresh-line",
        iconDown: "fa-sort-down",
        iconUp: "fa-sort-up",


    };

    return result;
}

function initGridManager(params) {
    var gridNameSelector = params["gridNameSelector"];
    let gridInit = $(gridNameSelector);
    let paramsFilters = params["paramsFilters"];
    let method = params.hasOwnProperty("ajaxSettings").hasOwnProperty("method")
        ? params["ajaxSettings"]["method"]
        : "POST";
    let urlCurrent = params["urlCurrent"];
    //labels
    let loadingHtml = params.hasOwnProperty("labels").hasOwnProperty("loading")
        ? params["labels"]["loading"]
        : "Cargando...";
    let noResultsHtml = params
        .hasOwnProperty("labels")
        .hasOwnProperty("noResults")
        ? params["labels"]["noResults"]
        : "Sin Resultados!";
    let infosHtml = params.hasOwnProperty("labels").hasOwnProperty("infos")
        ? params["labels"]["infos"]
        : "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados";
    let searchHtml = params.hasOwnProperty("labels").hasOwnProperty("search")
        ? params["labels"]["search"]
        : "Ingrese lo que desee buscar.";
    let refreshHtml = params.hasOwnProperty("labels").hasOwnProperty("refresh")
        ? params["labels"]["refresh"]
        : "Actualizar";
    //css
    let headerCSS = params.hasOwnProperty("css").hasOwnProperty("header")
        ? params["css"]["header"]
        : "bootgrid-header";
    let tableCSS = params.hasOwnProperty("css").hasOwnProperty("table")
        ? params["css"]["table"]
        : "xywer-tbl-admin";
    let formattersCurrent = params.hasOwnProperty("formatters")
        ? params["formatters"]
        : {
            default: function (column, row) {
                console.log(row);
            }
        };
    var configCss = {
        header: headerCSS,
        table: tableCSS
    };
    var iconRefresh = params["iconRefresh"];
    var iconDown = params["iconDown"];
    var iconUp = params["iconUp"];


    configCss.iconRefresh = iconRefresh != null ? iconRefresh : getCSSCurrentBootGrid().iconRefresh;
    configCss.iconDown = iconDown != null ? iconDown : getCSSCurrentBootGrid().iconDown;
    configCss.iconUp = iconUp != null ? iconUp : getCSSCurrentBootGrid().iconUp;
    var templates = {};
    var templatesManager = params["templates"];

    if (typeof templatesManager !== 'undefined' && templatesManager !== null) {
        templateHeader = templatesManager["header"];
        if (typeof templateHeader !== 'undefined' && templateHeader !== null) {
            templates.header = templateHeader;

        }
    }


    var overWritePost = params.hasOwnProperty('overWritePost');
    var requestHandler = null;
    if (overWritePost) {
        requestHandler = params['overWritePost'];
    }
    var configCurrent = !overWritePost ? {
        ajaxSettings: {
            method: method
        },
        ajax: true,
        post: function () {
            return {
                filters: paramsFilters
            };
        },
        url: urlCurrent,
        labels: {
            loading: loadingHtml,
            noResults: noResultsHtml,
            infos: infosHtml,
            search: searchHtml,
            refresh: refreshHtml
        },
        templates: templates,
        css: configCss,
        formatters: formattersCurrent
    } : {
        ajaxSettings: {
            method: method
        },
        ajax: true,
        requestHandler: requestHandler,
        url: urlCurrent,
        labels: {
            loading: loadingHtml,
            noResults: noResultsHtml,
            infos: infosHtml
        },
        css: configCss,
        formatters: formattersCurrent
    };
    gridInit.bootgrid(configCurrent);

    return gridInit;
}

function _gridManagerRows(params) {
    let _thisCurrent = params["thisCurrent"];
    let elementSelect = params["elementSelect"];
    let isAngular = params.hasOwnProperty('isAngular');

    var selectorGrid = _thisCurrent.gridConfig.selectorCurrent;
    elementSelect.find("tbody tr").on("click", function (e) {
        var elementA = e.target;
        var self = $(this);
        var dataRowId = $(self[0]).attr("data-row-id");
        var targetTypeA = $(e.target).is("a");
        if (!targetTypeA) {
            var selectorRow;
            if (dataRowId) {
                var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                var rowData = searchElementJson(
                    instance_data_rows,
                    "id",
                    dataRowId
                ); //asi s obtiene los valores del registro en funcion d su id
                elementSelect.find("tr.selected").removeClass("selected");
                var newEventRow = false;
                if (_thisCurrent.managerMenuConfig.rowId) {
                    //ready selected
                    var removeRowId = _thisCurrent.managerMenuConfig.rowId;
                    if (dataRowId == removeRowId) {
                        selectorRow =
                            selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                        $(selectorRow).removeClass("selected");
                        _thisCurrent._resetManagerGrid();
                    } else {
                        newEventRow = true;
                    }
                } else {
                    newEventRow = true;
                }
                if (newEventRow) {
                    selectorRow =
                        selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                    $(selectorRow).addClass("selected");
                    _thisCurrent.managerMenuConfig = {
                        view: true,
                        menuCurrent: _thisCurrent.getMenuConfig({
                            rowData: rowData[0],
                            rowId: dataRowId
                        }),
                        rowId: dataRowId
                    };
                }
                if (isAngular) {
                    _thisCurrent.$apply();
                }
            }
        } else {
            if (_thisCurrent.hasOwnProperty('_managerTargetGrid')) {
                var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                var rowData = searchElementJson(
                    instance_data_rows,
                    "id",
                    dataRowId
                );
                _thisCurrent._managerTargetGrid({
                    rowData: rowData, target: e.target
                });
            } else {
                console.log('manager,not recoigner')
            }


        }


    });
}

/*
MENU*/

function UtilMenu(componentCurrent) {
    this.componentCurrent = componentCurrent;
    this._menuCurrent = function (
        typeManager,
        menu,
        indexParent,
        menuChildren,
        indexChildren
    ) {
        var vm = this.componentCurrent;
        var processNameIndex;
        this.resetMenuActives();
        if (typeManager) {
            //only menu
            processNameIndex = menu.type;
            $.each(this.componentCurrent.configModulesAllow, function (
                key,
                value
            ) {
                if (key == processNameIndex) {
                    vm.configModulesAllow[key].active = true;
                } else {
                    vm.configModulesAllow[key].active = false;
                }
            });
            $.each(this.componentCurrent.menuCurrent, function (key, value) {
                if (key == indexParent) {
                    vm.menuCurrent[key].active = true;
                }
            });
        } else if (typeManager == false) {
            //childrens
            processNameIndex = menuChildren.type;
            $.each(this.componentCurrent.configModulesAllow, function (
                key,
                value
            ) {
                if (key == processNameIndex) {
                    vm.configModulesAllow[key].active = true;
                } else {
                    vm.configModulesAllow[key].active = false;
                }
            });
            $.each(this.componentCurrent.menuCurrent, function (key, value) {
                if (key == indexParent) {
                    vm.menuCurrent[key].active = true;
                    if (value.isParent) {
                        $.each(value.parentData, function (
                            keyChildren,
                            valueChildren
                        ) {
                            if (keyChildren == indexChildren) {
                                vm.menuCurrent[key]["parentData"][
                                    keyChildren
                                    ].active = true;
                            }
                        });
                    }
                }
            });
        }
    };
    this.getMenuCurrent = function (haystack) {
        var result = [];
        $.each(haystack, function (key, value) {
            var setPush;
            if (value.isParent) {
                var parentDataAux = value.parentData;
                var setPushDataParent = [];
                $.each(parentDataAux, function (keyChildren, valueChildren) {
                    if (value.allow) {
                        setPush = {
                            title: valueChildren.title,
                            allow: valueChildren.allow,
                            type: keyChildren,
                            active: valueChildren.active,
                            isParent: false,
                            urlCurrent: valueChildren.urlCurrent
                        };

                        setPushDataParent.push(setPush);
                    }
                });

                setPush = {
                    title: value.title,
                    allow: value.allow,
                    type: key,
                    active: value.active,
                    isParent: value.isParent,
                    icon: value.icon,
                    parentData: setPushDataParent
                };
                result.push(setPush);
            } else {
                if (value.allow) {
                    setPush = {
                        title: value.title,
                        allow: value.allow,
                        type: key,
                        active: value.active,
                        isParent: value.isParent,
                        icon: value.icon,
                        urlCurrent: value.urlCurrent
                    };

                    result.push(setPush);
                }
            }
        });
        return result;
    };
}


!(function ($) {
    "use strict";
    var UploadUtil = function () {
        (this.$body = $("body")), (this.$window = $(window)), (this.types = []);
        this.typesImages = ["image/png", "image/jpeg", "image/svg+xml"];
        this.typesImagesIcon = ["image/x-icon","image/png", "image/jpeg", "image/svg+xml"];

        this.progress_bar_selector = "";
    };

    UploadUtil.prototype._readerUpload = function (event) {
        if (event.type === "load") {
            progress.style.width = "100%";
            progress.textContent = "100%";
        } else if (event.type === "loadend") {
        } else if (event.type === "abort") {
        } else if (event.type === "loadstart") {
            document.getElementById("progress_bar").className = "loading";
        } else if (event.type === "error") {
            switch (event.target.error.code) {
                case event.target.error.NOT_FOUND_ERR:
                    alert("File Not Found!");
                    break;
                case event.target.error.NOT_READABLE_ERR:
                    alert("File is not readable");
                    break;
                case event.target.error.ABORT_ERR:
                    break; // noop
                default:
                    alert("An error occurred reading this file.");
            }
        } else if (event.type === "progress") {
            if (event.lengthComputable) {
                var percentLoaded = Math.round(
                    (event.loaded / event.total) * 100
                );
                // Increase the progress bar length.
                if (percentLoaded < 100) {
                    progress.style.width = percentLoaded + "%";
                    progress.textContent = percentLoaded + "%";
                }
            }
        }
    };
    UploadUtil.prototype._addListenerReaderUpload = function (reader) {
        var $this = this;
        reader.addEventListener("loadstart", $this._readerUpload);
        reader.addEventListener("load", $this._readerUpload);
        reader.addEventListener("loadend", $this._readerUpload);
        reader.addEventListener("progress", $this._readerUpload);
        reader.addEventListener("error", $this._readerUpload);
        reader.addEventListener("abort", $this._readerUpload);
    };
    UploadUtil.prototype.getSelectorElementUploadFile = function (params) {
        var toElement = params["toElement"];
        var haystack = $(toElement)
            .attr("id")
            .split("-");
        var selector = "";
        $.each(haystack, function (key, value) {
            if (key != 0) {
                //this position is add al element selector main
                selector += value;
            }
        });

        return selector;
    };
    UploadUtil.prototype.managerUploadModel = function (params) {
        var _this = this;
        var selectorUpload = params["selectorUpload"];
        var selectorPreview = params["selectorPreview"];
        var modelCurrent = params["modelCurrent"];
        if (modelCurrent.attributes.id) {
            var nameSource = params["modelAttributeName"];
            var source = modelCurrent.attributes[nameSource];
            var srcSource = $resourceRoot + source;
            $(selectorPreview).attr("src", srcSource);
        }
        var modelAttributeName = params["modelAttributeName"];
        $(selectorUpload).change(function () {
            var file = $(this)[0].files[0];
            var srcSourceManager = _this.upload({
                typeUpload: "image",
                generateManager: "generateImage",
                fileElement: $(this)[0].files
            });
            if (srcSourceManager.success) {
                var srcSource = srcSourceManager.result;
                $(selectorPreview).attr("src", srcSource);
                modelCurrent.attributes[modelAttributeName] = file;
                if (modelCurrent.attributes.id) {
                    modelCurrent.attributes.change = true;
                }
            }

            return false;
        });
    };

    UploadUtil.prototype.upload = function (params) {
        var _this = this;
        var typeUpload = params["typeUpload"];
        var generateManager = params["generateManager"];

        var fileElement = params.hasOwnProperty("fileElement")
            ? params["fileElement"]
            : null;
        var result = {};
        if (typeUpload === "image") {
            if (generateManager == "generateImage") {
                var file = fileElement;

                if (fileElement instanceof FileList) {
                    file = fileElement[0];
                } else {
                    file = fileElement;
                }

                if ($.inArray(file.type, _this.typesImages) != -1) {
                    //format kml
                    var srcSource = window.URL.createObjectURL(file);
                    result = {
                        success: true,
                        result: srcSource
                    };
                } else {
                    result = {
                        success: false,
                        result: "",
                        error: "not-is-image"
                    };
                    alert("No es una imagen.");
                }
            } else if (generateManager == "generateIcon") {
                var file = fileElement;

                if (fileElement instanceof FileList) {
                    file = fileElement[0];
                } else {
                    file = fileElement;
                }
                if ($.inArray(file.type, _this.typesImagesIcon) != -1) {
                    //format kml
                    var srcSource = window.URL.createObjectURL(file);
                    result = {
                        success: true,
                        result: srcSource
                    };
                } else {
                    result = {
                        success: false,
                        result: "",
                        error: "not-is-image"
                    };
                    alert("No tiene el formato correcto.");
                }
            } else if (generateManager == "uploadImage") {
                if (fileElement.length == 0) {
                    result = {
                        success: false,
                        error: "not-image-selected",
                        result: ""
                    };
                } else {
                    var file = fileElement;

                    if (fileElement instanceof FileList) {
                        file = fileElement[0];
                    } else {
                        file = fileElement;
                    }
                    if ($.inArray(file.type, _this.typesImages) != -1) {
                        //format kml
                        console.log("upload image");
                        var managerContentImage = params.managerContentImage;
                        var managerUploadSelector =
                            params.managerUploadSelector;
                        var sourceSet = params.sourceSet;

                        var uploadPercentage = new UploadPercentage({
                            managerContentImage: managerContentImage,
                            managerUploadSelector: managerUploadSelector
                        });
                        var idSelectorUpload = params.idSelectorUpload;
                        var inputFileImage = document.getElementById(
                            idSelectorUpload
                        );

                        var file = inputFileImage.files[0];
                        var formData = new FormData();
                        formData.append("file", file);
                        formData.append("sourceSet", sourceSet);
                        if (params.dataSend) {
                            $.each(params.dataSend, function (key, value) {
                                formData.append(key, value);
                            });
                        }
                        var tokenInformation = $(
                            'meta[name="csrf-token"]'
                        ).attr("content");
                        var dataResult = null;
                        var dataResultError = true;
                        var urlCurrent = params.url;
                        $.ajax({
                            async: false,
                            url: urlCurrent,
                            type: "POST",
                            // Form data
                            //datos del formulario
                            data: formData,
                            //necesario para subir archivos via ajax
                            cache: false,
                            contentType: false,
                            headers: {
                                "X-CSRF-TOKEN": tokenInformation
                            },
                            processData: false,
                            //una vez finalizado correctamente
                            success: function (response) {
                                var responseJson = response;
                                dataResult = responseJson;
                                dataResultError = true;
                            },
                            //si ha ocurrido un error
                            error: function () {
                                uploadPercentage.endUploadProgress(); ////step 4 u
                                dataResultError = false;
                            },
                            beforeSend: function (xhr, data) {
                                uploadPercentage.initUploadProgress(); //step 1 u
                            },
                            complete: function (data) {
                                uploadPercentage.endUploadProgress(); //step 3 u
                            },
                            xhr: uploadPercentage.eventsXhr
                        });
                        result = {
                            success: dataResultError,
                            result: dataResult
                        };
                    } else {
                        result = {
                            success: false,
                            result: ""
                        };
                        alert("No es una imagen.");
                    }
                }
            }
        }
        return result;
    };

    ($.UploadUtil = new UploadUtil()), ($.UploadUtil.Constructor = UploadUtil);
})(window.jQuery);

function ajaxRequestManager(url, params, hasFileUpload) {
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
    blockElement ? blockContainerManager({
        selector: blockElement,
        msj: loading_message
    }) : blockPageManager({msj: loading_message});
    var tokenInformation = $('meta[name="csrf-token"]').attr('content');
    var paramsConfig = (typeof hasFileUpload !== 'undefined' && hasFileUpload) ? {
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

            blockElement ? unblockContainerManager({selector: blockElement}) : unblockPageManager();
            if(data.status==500){
                showAlertManager({type: 'error', message: data.responseJSON.message});
            }else{
                //Error messages from server
                if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                    showAlertManager({type: 'error', message: data.message});
                } else { //Error messages from frontend
                    showAlertManager({type: 'error', message: error_message});
                }
                if (params.hasOwnProperty("error_callback")) {
                    params.error_callback(data);
                }
            }

        },
        success: function (data) {
            blockElement ? unblockContainerManager({selector: blockElement}) : unblockPageManager();
            //Error messages from server
            if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                if (data.success) {
                    showAlertManager({type: 'success', message: data.message});
                } else {
                    showAlertManager({type: 'error', message: data.message});
                }
            } else { //Error messages from frontend
                if (!data.hasOwnProperty("success") || data.success) {
                    if (data.success) {
                        if (params.hasOwnProperty("success_message")) {
                            showAlertManager({type: 'success', message: params.success_message});
                        }
                    } else {
                        if (params.hasOwnProperty("success_message")) {
                            showAlertManager({type: 'error', message: params.success_message});
                        }
                    }

                } else {
                    if (data.hasOwnProperty("message") && !params.hasOwnProperty("error_message")) {

                        showAlertManager({type: 'error', message: data.message});
                    } else {

                        showAlertManager({type: 'error', message: error_message});
                    }
                }
            }
            if (params.hasOwnProperty("success_callback")) {
                params.success_callback(data);
            }
            if (params.hasOwnProperty("errorCallback")) {
                params.errorCallback(data);
            }
        },
        complete: function () {
            blockElement ? unblockContainerManager(blockElement) : unblockPageManager();
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
            blockElement ? unblockContainerManager({selector: blockElement}) : unblockPageManager();
            //Error messages from server
            if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                showAlertManager({type: 'error', message: data.message});
            } else { //Error messages from frontend
                showAlertManager({type: 'error', message: error_message});
            }
            if (params.hasOwnProperty("error_callback")) {
                params.error_callback(data);
            }
        },
        success: function (data) {
            blockElement ? unblockContainerManager({selector: blockElement}) : unblockPageManager();
            //Error messages from server
            if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                if (data.success) {
                    showAlertManager({type: 'success', message: data.message});
                } else {
                    showAlertManager({type: 'error', message: data.message});
                }
            } else { //Error messages from frontend
                if (!data.hasOwnProperty("success") || data.success) {
                    if (data.success) {
                        if (params.hasOwnProperty("success_message")) {
                            showAlertManager({type: 'success', message: params.success_message});
                        }
                    } else {
                        if (params.hasOwnProperty("success_message")) {
                            showAlertManager({type: 'error', message: params.success_message});
                        }
                    }

                } else {
                    if (data.hasOwnProperty("message") && !params.hasOwnProperty("error_message")) {

                        showAlertManager({type: 'error', message: data.message});
                    } else {

                        showAlertManager({type: 'error', message: error_message});
                    }
                }
            }
            if (params.hasOwnProperty("success_callback")) {
                params.success_callback(data);
            }
            if (params.hasOwnProperty("errorCallback")) {
                params.errorCallback(data);
            }
        },
        complete: function () {
            blockElement ? unblockContainerManager(blockElement) : unblockPageManager();
            if (params.hasOwnProperty("complete_callback")) {
                params.complete_callback();
            }
        }
    };
    $.ajax(paramsConfig);
}


function unblockContainerManager(params) {
    var selectorCurrent = params.selector;

    if (!$(selectorCurrent).length) {
        unblockPageManager(params);
    } else {

        $(selectorCurrent).unblock();
    }
}

function blockContainerManager(params) {
    var selectorCurrent = params.selector;
    var managerCustom = params.hasOwnProperty('managerCustom');
    var configBlock = {};
    if (managerCustom) {
        configBlock = params.configBlock;
    } else {
        var msj = params.hasOwnProperty('msj') ? params.msj : "Cargando.....";
        configBlock = {message: '<h1>' + msj + '...</h1>'}

        /*   configBlock = {message: '<h1><img src="https://flevix.com/wp-content/uploads/2019/07/Ring-Preloader.gif" />' + msj + '...</h1>'}*/
    }
    if (!$(selectorCurrent).length) {
        blockPageManager(params);
    } else {

        $(selectorCurrent).block(configBlock);
    }
}

function blockPageManager(params) {
    var managerCustom = params.hasOwnProperty('managerCustom');
    var configBlock = {};
    if (managerCustom) {
        configBlock = params.configBlock;

    } else {
        var msj = params.hasOwnProperty('msj') ? params.msj : "Cargando.....";
        configBlock = {message: '<h1>' + msj + '...</h1>'}
    }
    $.blockUI(configBlock);
}

function unblockPageManager() {

    $.unblockUI();
}


function showAlertManager(params) {
    /*   https://kamranahmed.info/toast*/
    var type = params.hasOwnProperty('type') ? params.type : 'success';
    var message = params.hasOwnProperty('message') ? params.message : 'No existe mensaje.';
    var hideAfter = params.hasOwnProperty('hideAfter') ? params.hideAfter : 45000;
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
        case 'warning':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#da8609',
                icon: type
            };
            break;
        case 'error':
            options = {
                heading: "Informacion!",
                text: message,
                position: 'top-right',
                loaderBg: '#bf441d',
                icon: type
            };
            break;
    }
    sendToast(options);
}

function sendToast(options) {
    // default
    var hideAfter;
    if (!options.hideAfter) {
        hideAfter = false;
    } else {
        hideAfter = options.hideAfter;
    }
    var options = {
        heading: options.heading,
        text: options.text,
        position: options.position,
        loaderBg: options.loaderBg,
        icon: options.icon,
        hideAfter: hideAfter,
        stack: !options.stack ? options.stack : 1
    };

    if (options.showHideTransition)
        options.showHideTransition = options.showHideTransition;
    $.toast().reset('all');
    $.toast(options);
}

function initAutoCompleteGoogleMaps(params) {
    console.log(this._initEventsMapSearch);
    var typesSearch = ['address', 'establishment', 'geocode'];
    var mapCurrent = params.map;
    var types = params.hasOwnProperty('types') ? params.types : typesSearch;
    var map = mapCurrent;
    var inputSelectorId = params.inputSelectorId;
    var input = document.getElementById(inputSelectorId);
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name']);
    autocomplete.setTypes(types);
    var _managerSearch = params.hasOwnProperty('_managerSearch') ? params._managerSearch : null;
    searchPlaceAutoComplete({
        autocomplete: autocomplete,
        _managerSearch: _managerSearch
    });
    this.autocomplete = autocomplete;
}

function searchPlaceAutoComplete(params) {
    var autocomplete = params.autocomplete;
    var _managerSearch = params.hasOwnProperty('_managerSearch') ? params._managerSearch : null;
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            if (_managerSearch) {
                _managerSearch({
                    success: false,
                    data: {
                        needle: place
                    }
                });
            }
            console.log(place);
            return;
        }
        // If the place has a geometry, then present it on a map.
        var typeViewPort = null;
        if (place.geometry.viewport) {
            typeViewPort = true;
        } else {
            typeViewPort = false;

        }
        var address = [];
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ];
        }
        if (_managerSearch) {
            _managerSearch({
                success: true,
                data: {
                    needle: place,
                    haystack: place,
                    address: address,
                    typeViewPort: typeViewPort
                }
            });
        }
    });

}

function codeAddressGoogleMaps(params) {
    var address = params.address;
    var _managerSearch = params.hasOwnProperty('_managerSearch') ? params._managerSearch : null;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == 'OK') {
            if (_managerSearch) {
                _managerSearch({
                    success: true,
                    data: {
                        needle: address,
                        status: status,
                        results: results,

                    }
                });
            }
        } else {
            if (_managerSearch) {
                _managerSearch({
                    success: false,
                    data: {
                        status: status,
                    }
                });
            }

        }
    });
}

//Need GeoXml.JS
//https://www.netdelight.be/kml/index.php
function initDrawingKmlGoogleMaps(params) {
    var mapObj = params.map;
    var kmlGetType = params.kmlGetType;
    var mapOverlays = [];
    this.mapOverlays = [];
    this.geoXml = null;
    this.bounds = null;
    var bounds = null;
    var _this = this;
    if (mapObj && typeof (geoXML3) != 'undefined') {
        var configGeo = {
            map: mapObj,
            zoom: false,
            /*  suppressInfoWindows: true,*/
            singleInfoWindow: true,
            afterParse: useTheData
        }
        geoXml = new geoXML3.parser(configGeo);
        if (kmlGetType == 0) {//string
            var kmlString = params.kmlString;
            if (kmlString.length == 0) {
                console.log('not allow draw kml');
            } else {
                geoXml.parseKmlString(kmlString);
            }
        } else {//get server
            var routeSource = params.source;
            geoXml.parse(routeSource);
        }

        var tmpOverlay, ovrOptions;

        function useTheData(docs) {
            console.log(docs);
            for (var m = 0; m < docs[0].placemarks.length; m++) {
                console.log(docs[0].placemarks[m]);

                if (docs[0].placemarks[m].Polygon) {
                    tmpOverlay = docs[0].placemarks[m].polygon;
                    if (typeof (isEditable) != 'undefined') {
                        tmpOverlay.setEditable(true);
                    }
                    tmpOverlay.type = "polygon";
                } else if (docs[0].placemarks[m].LineString) {

                    tmpOverlay = docs[0].placemarks[m].polyline;
                    if (isEditable) {
                        tmpOverlay.setEditable(true);
                    }
                    tmpOverlay.type = "polyline";
                } else if (docs[0].placemarks[m].Point) {

                    tmpOverlay = docs[0].placemarks[m].marker;
                    tmpOverlay.type = "marker";
                }
                var uniqueid = uniqid();
                tmpOverlay.uniqueid = uniqueid;
                if (docs[0].placemarks[m].name) {
                    tmpOverlay.title = docs[0].placemarks[m].name;
                } else {
                    tmpOverlay.title = "";
                }

                if (docs[0].placemarks[m].description) {
                    tmpOverlay.content = docs[0].placemarks[m].description;
                } else {
                    tmpOverlay.content = "";
                }
                //attach the click listener to the overlay
                _this._attachListener(
                    {
                        layer: tmpOverlay,
                        _hoverLay: typeof (params._hoverLay) != 'undefined' ? params._hoverLay : null,
                        _clickLay: typeof (params._clickLay) != 'undefined' ? params._clickLay : null,
                        'map': mapObj
                    }
                );
                //save the overlay in the array
                mapOverlays.push(tmpOverlay);
            }
            bounds = docs[0].bounds;
            this.mapOverlays = mapOverlays;
            this.bounds = bounds;
            if (typeof (params._eventManager) != 'undefined') {
                params._eventManager({
                    bounds: bounds,
                    layers: mapOverlays,

                });
            }

            this.geoXml = geoXml;
        }

    } else {
        console.log('not allow draw kml');
    }

    this._attachListener = _attachListener
}

function uniqid() {
    var newDate = new Date;
    return newDate.getTime();
}

function _attachListener(params) {
    var infWindow = new google.maps.InfoWindow();
    var mapObj = params.map;
    var overlay = params.layer;
    var _this = this;
    this.setStyle = function (domElem, styleObj) {

        if (typeof styleObj == "object") {
            for (var prop in styleObj) {
                domElem.style[prop] = styleObj[prop];
            }
        }
    }
    this.openInfowindow = function (overlay, latLng, content) {
        var div = document.createElement('div');
        div.innerHTML = content;
        _this.setStyle(div, {height: "100%"});
        infWindow.setContent(div);
        infWindow.setPosition(latLng);
        infWindow.relatedOverlay = overlay;
        var t = overlay.get('fillColor');
        infWindow.open(mapObj);
    }

    this.getContent = function (overlay) {
        var content =
            '<div><h3>' + overlay.title + '</h3>' + overlay.content + '<br></div>';
        return content;
    }

    google.maps.event.addListener(overlay, "click", function (event) {


        console.log('click');
        if (typeof (params._clickLay) != 'undefined') {
            if (params._clickLay) {

                params._clickLay({
                    sucess: true,
                    data: {
                        overlay: overlay,
                        event: event
                    }
                });
            }
        }
    });
    google.maps.event.addListener(overlay, "mouseover", function (event) {
        var infContent = _this.getContent(overlay);
        /*   _this.openInfowindow(overlay, event.latLng, infContent);
           console.log('mouseover');*/
        if (typeof (params._hoverLay) != 'undefined') {
            if (params._hoverLay) {
                params._hoverLay({
                    sucess: true,
                    data: {
                        overlay: overlay,
                        event: event
                    }
                });
            }
        }
    });
    google.maps.event.addListener(overlay, "mouseout", function (event) {
        /*
                infWindow.close();
                console.log('mouseover');*/
        if (typeof (params._outLay) != 'undefined') {
            if (params._outLay) {
                params._outLay({
                    sucess: true,
                    data: {
                        overlay: overlay,
                        event: event
                    }
                });
            }
        }
    });
}

function urlToFile(url, filename, mimeType) {
    return (fetch(url)
            .then(function (res) {
                return res.arrayBuffer();
            })
            .then(function (buf) {
                return new File([buf], filename, {type: mimeType});
            })
    );
}

function resizeImg(params = {}) {
    var scaleFactor = params.hasOwnProperty('scaleFactor') ? params.scaleFactor : null;
    var canvas = params.canvas;

    var c = canvas;
    var ctx = c.getContext('2d');
    var iw = canvas.width;
    var ih = canvas.height;
    c.width = iw * scaleFactor;
    c.height = ih * scaleFactor;
    ctx.drawImage(img, 0, 0, iw * scaleFactor, ih * scaleFactor);
    var scaledImg = new Image();
    scaledImg.onload = function () {
        // scaledImg is a scaled imageObject for upload/download
        // For testing, just append it to the DOM
        document.body.appendChild(scaledImg);
    }
    scaledImg.src = c.toDataURL();
}

function returnFileSize(number) {
    var type = '';
    var value = 0;
    var text = '';
    if (number < 1024) {

        type = 'bytes';
        value = number;
        text = number + type;
    } else if (number >= 1024 && number < 1048576) {

        type = 'KB';
        value = (number / 1024).toFixed(1);
        text = value + type;

    } else if (number >= 1048576) {
        type = 'MB';
        value = (number / 1048576).toFixed(1);
        text = value + type;
    }
    var result = {
        type: type,
        value: value,
        text: text
    };
    return result;
}

//GOOGLE MAPS
var $managerGoogleMaps = {
    _initMap: $_initMap,
    managerStructureCurrentLocation: $managerStructureCurrentLocation,//ROOT DATA
    getStructureLocation: $getStructureLocation,
    getFormattedInformation: $getFormattedInformation,
    //MARKERS
    _markersCurrent: $_markersCurrent,
    fillInAddress: $fillInAddress,
    _mapCurrent: $_mapCurrent,
    _initAutocomplete: $_initAutocomplete,

};

function $_initAutocomplete(params) {
    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.

    var elementId = 'search-map-current';
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById(elementId), {types: ['geocode']});
    var mapCurrent = params['mapCurrent'];
    var mapInit = mapCurrent;
    var markerInit = params.marker;
    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);
    autocomplete.bindTo('bounds', mapInit);
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    var _this = this;

    autocomplete.addListener('place_changed', function () {
        _this.fillInAddress({
            autocomplete: this,
            map: mapInit,
            marker: markerInit
        });
    });
}

function $_initMap(params) {
    $('.pac-container').remove();
    var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
        name: "Greyscale"
    });
    var mapOptions = {};


    var zoom = 15;
    if (params.data.model.options_map.$model) {
        var currentValue = params.data.model.options_map.$model;
        if (typeof (currentValue) == "string") {
            var mapOptionsRow = jQuery.parseJSON(currentValue);
            if (mapOptionsRow.zoom) {
                latLngCurrent = {
                    lat: parseFloat(mapOptionsRow.latLng.lat),
                    lng: parseFloat(mapOptionsRow.latLng.lng)
                };
                zoom = mapOptionsRow.zoom;
            }
        }
    }
    var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
    //var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
    mapOptions = {
        title: "Ubicacion",
        panControl: true,
        scrollwheel: false,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        draggable: true,
        center: latLngCurrent,
        zoom: zoom,
        animation: google.maps.Animation.DROP,
        icon: icon_mapa_url

    };


    var objSelector = params.objSelector;
    var dataCurrent = params.data.model;
    var mapCurrent = new google.maps.Map(objSelector, mapOptions);
    var key = 1;

    var key_id = key;
    var info_name = "Mueva el Marker.";
    var msg = key_id + " " + info_name;

    var width = 40, height = 40;
    var urlIcon = "https://furtaev.ru/preview/user_on_map.png";
    var iconCurrent = {
        url: urlIcon,
        scaledSize: new google.maps.Size(width, height), // scaled size
    };
    var marker_object = new google.maps.Marker({
        draggable: true,
        title: info_name,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(latLngCurrent.lat, latLngCurrent.lng),
        icon: iconCurrent,
    });

    mapCurrent.mapTypes.set('greyscale_style', greyStyleMap);
    mapCurrent.setMapTypeId('greyscale_style');
    this._mapCurrent({
        mapCurrent: mapCurrent,
        marker: marker_object,
        data: dataCurrent,

    });
    marker_object.setMap(mapCurrent);
    this._markersCurrent({
        marker: marker_object,
        mapCurrent: mapCurrent,
        data: dataCurrent
    });
    mapCurrent.setCenter(latLngCurrent);
    var paramsAutocomplete = {
        mapCurrent: mapCurrent,
        marker: marker_object,
        dataCurrent: dataCurrent
    };
    this._initAutocomplete(paramsAutocomplete);
}

function $fillInAddress(params) {
    var map = params.map;
    var marker = params.marker;
    var autocomplete = params.autocomplete;

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    var place = autocomplete.getPlace();
    if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

}

function $_mapCurrent(params) {
    var mapCurrent = params.mapCurrent;
    var marker = params.marker;

    var dataCurrent = params.data;

    var vCurrent = this;
    mapCurrent.addListener('idle', function () {
        var latLngCurrent = {lng: mapCurrent.getCenter().lng(), lat: mapCurrent.getCenter().lat()};
        vCurrent.managerStructureCurrentLocation({
            type: "idle",
            "configSearch": {'latLng': latLngCurrent},
            data: dataCurrent,
            mapInit: mapCurrent,
            marker: marker
        });
    });

}

function $_markersCurrent(params) {
    var $scope = this;
    var marker = params.marker;
    var dataCurrent = params.data;
    var mapCurrent = params.mapCurrent;
    google.maps.event.addListener(marker, 'dragend', function () {
        var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
        $scope.managerStructureCurrentLocation({
            type: "dragend",
            "configSearch": {'latLng': latLngCurrent},
            data: dataCurrent,
            mapInit: mapCurrent,
            marker: marker
        });
    });
    google.maps.event.addListener(marker, 'click', function () {
        var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
        if (marker.content) {

            if (infoWindow) {
                infoWindow.close();
            }
            var htmlData = replaceAll(marker.content, "&lt;", "<");
            htmlData = replaceAll(htmlData, '&gt;', '>');
            var infoWindowOptions = {
                content: htmlData,
                maxWidth: 400
            };
            infoWindow = new google.maps.InfoWindow(infoWindowOptions);
            infoWindow.open(map, marker);
            currentLtLng = new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng());
        }
        mapCurrent.panTo(latLngCurrent);
        mapCurrent.setZoom(17);

    });
}

function $getFormattedInformation(needle, haystack) {
    var result = null;
    $.each(haystack, function (indexRow, valueRow) {

        if (isEqualArrays(valueRow["types"], needle)) {
            result = valueRow
            return result;
        }
    });
    return result;
}

function $getStructureLocation(params) {
    var haystack = params.haystack;
    var vCurrent = this;
    var options_map = params.options_map;
    var current_location_structure = {
        country_code_id: "",//*
        administrative_area_level_2: "",//*
        administrative_area_level_1: "",//*
        administrative_area_level_3: "",
        options_map: options_map
    };
    var haystackLocations = [["country", "political"], ["administrative_area_level_1", "political"], ["administrative_area_level_2", "political"]];
    $.each(haystackLocations, function (indexRow, valueRow) {
        var foundCurrent = vCurrent.getFormattedInformation(valueRow, haystack);
        var nameMain = valueRow[0];
        if (foundCurrent) {
            if (nameMain == "country") {
                current_location_structure["country_code_id"] = foundCurrent["place_id"];
            } else if (nameMain == "administrative_area_level_1") {
                current_location_structure["administrative_area_level_1"] = foundCurrent["place_id"];

            } else if (nameMain == "administrative_area_level_2") {
                current_location_structure["administrative_area_level_2"] = foundCurrent["place_id"];

            } else if (nameMain == "administrative_area_level_3") {
                current_location_structure["administrative_area_level_3"] = foundCurrent["place_id"];

            }
        }
    });

    var result = current_location_structure;
    return result;
}

function $managerStructureCurrentLocation(params) {
    var $scope = this;
    var vCurrent = $scope;
    var type = params.type;
    var configSearch = params.configSearch;
    var mapInit = params.mapInit;
    var modelCurrentRow = null;
    modelCurrentRow = params.data;
    if (type == "_searchMap") {
    } else if (type == "idle") {

    } else if (type == "dragend") {


    }
    var options_map = null;
    var markerInit = params.marker;
    var geocoder = new google.maps.Geocoder();
    console.log('$managerStructureCurrentLocation');
    geocodeSearch({
        geocoder: geocoder,
        configSearch: configSearch,

    }).then(function (response) {
        var haystack = response.data;
        var dataSendParams = {};
        if (response.success) {
            if (type == "_searchMap") {

            } else if (type == "idle") {
                options_map = {
                    zoom: mapInit.getZoom(),
                    latLng: {
                        lat: markerInit.getPosition().lat(),
                        lng: markerInit.getPosition().lng()
                    }
                };
                dataSendParams = {
                    haystack: haystack,
                    vModel: modelCurrentRow,
                    options_map: options_map

                };
            } else if (type == "dragend") {
                options_map = {
                    zoom: mapInit.getZoom(),
                    latLng: {
                        lat: markerInit.getPosition().lat(),
                        lng: markerInit.getPosition().lng()
                    }

                };
                dataSendParams = {
                    haystack: haystack,
                    vModel: modelCurrentRow,
                    options_map: options_map
                };
            }
            var resultDataLocation = getDataLocationMap({
                data: dataSendParams,
                vCurrent: vCurrent,
                isErrorGoogle: false
            });
            vCurrent.model.attributes['options_map'] = resultDataLocation.optionsMap;
            vCurrent.model.attributes['information_address_location_current'] = resultDataLocation.information_address_location_current;
        }
    }).catch(function (response) {

        if (type == "_searchMap") {
            $scope.makeToast({
                "title": "Información",
                msj: "No existe información sobre este lugar:" + configSearch.address,
                "type": "warning"
            });
        }
        if (type == "idle") {

        }
        //ERROR DATA
        var resultDataLocation = getDataLocationMap({
            vCurrent: vCurrent,
            isErrorGoogle: true
        });
        vCurrent.model.attributes['options_map'] = resultDataLocation.optionsMap;
        vCurrent.model.attributes['information_address_location_current'] = resultDataLocation.information_address_location_current;
    });
}

function geocodeSearch(params) {
    var geoCoderCurrent = params.geocoder;
    var configSearch = params["configSearch"];
    var response;
    var result = new Promise((resolve, reject) => {
        geoCoderCurrent.geocode(configSearch, function (results, status) {
            if (status === "OK") {
                response = {
                    msj: "",
                    data: results,
                    success: true
                };
                resolve(response);
            } else {
                response = {
                    msj: "Browser doesn't support Geolocation",
                    data: results,
                    success: false
                };
                reject(response);
            }
        });
    });
    return result;
}

function getCurrentLocation() {
    var result = new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    resolve(pos);
                },
                function () {
                    reject({
                        msj: "Browser doesn't support "
                    });
                }
            );
        } else {
            reject({
                msj: "Browser doesn't support Geolocation"
            });
        }
    });
    return result;
}

function isEqualArrays(a, b) {
    // if length is not equal
    if (a.length != b.length) return false;
    else {
        // comapring each element of array
        for (var i = 0; i < a.length; i++) if (a[i] != b[i]) return false;
        return true;
    }
}

function initUploadCrop(params) {
    this.selectorCrop = params['selector'];
    this.selectorContainerMain = params['selectorContainerMain'];
    this.selectorManagerInput = params['selectorManagerInput'];
    this._onLoadImage = params.hasOwnProperty('_onLoadImage') ? params['_onLoadImage'] : null;
    this.imageInit = params.hasOwnProperty('imageInit') ? params['imageInit'] : null;
    var imageDefault = $publicAsset + '/images/profile-not-image.png';
    if (params.hasOwnProperty('imageDefault')) {
        this.imageDefault = params['imageDefault'];
    } else {
        this.imageDefault = imageDefault;
    }


    this._onUpdate = params.hasOwnProperty('_onUpdate') ? params['_onUpdate'] : null;
    this.style = {
        viewport: {
            width: params.hasOwnProperty('viewportWidth') ? params.viewportWidth : 485,
            height: params.hasOwnProperty('viewportHeight') ? params.viewportHeight : 294,
        },
        boundary: {
            width: params.hasOwnProperty('boundaryWidth') ? params.boundaryWidth : 500,
            height: params.hasOwnProperty('boundaryHeight') ? params.boundaryHeight : 500,
        },

    };

    var $scope = this;
    var $uploadCrop;
    this.getResultImage = function (params) {
        var resultSize = params.hasOwnProperty('resultSize') ? params.resultSize : {
            width: 1200,
            height: 800
        };
        /*   var size = 'viewport';*/
        var size = 'viewport';
        var type = params.hasOwnProperty('type') ? params.type : 'canvas';
        var configResult = {
            type: type,
            size: size,
            resultSize: resultSize,
            quality: 0
        };
        var result = null;
        return this.cropCurrent.croppie('result', configResult);

    };
    this.getResultFile = function () {
        return $(this.selectorManagerInput)[0].files;
    };
    var contEvent = false;

    this._eventCustom = null;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var allow = true;
            var files = input.files;
            if (files.length > 0) {
                for (var i = 0; i <= files.length - 1; i++) {

                    const fsize = files.item(i).size;
                    var managerSize = returnFileSize(fsize);
                    if (managerSize.type == 'MB') {
                        if (managerSize.value > 4) {
                            allow = false;
                        }
                    }
                }
            }

            if (allow) {

                $($scope.selectorContainerMain).addClass('ready');
                var reader = new FileReader();
                reader.onload = function (e) {
                    $scope.cropCurrent.croppie('bind', {
                        url: e.target.result,
                        zoom: 0
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                    if ($scope._onLoadImage) {
                        $scope._onLoadImage({
                            event: e,
                            data: e.target.result
                        })
                    }

                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('Imagen demasiada grande.');
            }
        } else {
            console.log("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    function initEvent() {

    }

    var configManager = {
        /*enableExif: true,*/
        viewport: {
            width: this.style.viewport.width,
            height: this.style.viewport.height,
            type: 'square'
        },
        boundary: {
            width: this.style.boundary.width,
            height: this.style.boundary.height,
        },
        showZoomer: true,
        enableResize: false,
        enableOrientation: true,
        mouseWheelZoom: 'ctrl'
    };
    if (this.imageInit) {

        var imageInit = this.imageInit;
        configManager['url'] = $publicAsset + imageInit;
        configManager['zoom'] = 0;


    } else {
        configManager['url'] = this.imageDefault;
        configManager['zoom'] = 0;

    }

    $(this.selectorManagerInput).on('change', function () {
        readFile(this);
    });

    $uploadCrop = $(this.selectorCrop).croppie(configManager);
    this.cropCurrent = $uploadCrop;


    $cropObject = $uploadCrop;
    if (this.imageInit) {
        $uploadCrop.croppie('bind', {
            'url': configManager['url'],
            zoom: 0
        });
        $($scope.selectorContainerMain).addClass('ready');
    } else {
        var urlView = this.imageDefault;
        $uploadCrop.croppie('bind', {
            'url': urlView,
            zoom: 0
        });
        $($scope.selectorContainerMain).addClass('ready');
    }
    this.cropCurrent.on('update.croppie', function (ev, cropData) {
        if ($scope._onUpdate) {
            $scope._onUpdate({
                event: ev,
                data: cropData
            })
        }
        ev.stopPropagation();
        return true;
    });
}

jQuery.extend({
    compare: function (arrayA, arrayB) {
        if (arrayA.length != arrayB.length) {
            return false;
        }
        // sort modifies original array
        // (which are passed by reference to our method!)
        // so clone the arrays before sorting
        var a = jQuery.extend(true, [], arrayA);
        var b = jQuery.extend(true, [], arrayB);
        a.sort();
        b.sort();
        for (var i = 0, l = a.length; i < l; i++) {
            if (a[i] !== b[i]) {
                return false;
            }
        }
        return true;
    }
});
Date.prototype.toInputFormat = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
};

function calcAge(date) {

    var hoy = new Date();
    var dateHappy = new Date(date);
    var age = hoy.getFullYear() - dateHappy.getFullYear();
    var m = hoy.getMonth() - dateHappy.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < dateHappy.getDate())) {
        age--;
    }
    return age;
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    console.log(userAgent);
    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
        return 'iOS';

    } else if (userAgent.match(/Android/i)) {

        return 'Android';
    } else {
        return 'unknown';
    }
}

function getValueCustomer(value) {

    var result = 0;
    if (value) {
        result = Math.round10(value, -2);
    }
    return result;
}

function getValueCustomerUpDown(value, upDown, type = "decimal") {
    var result = 0;
    if (type == "floor") {

        if (value) {
            result = Math.floor10(value, upDown);
        }
    } else {
        if (value) {
            result = Math.round10(value, upDown);
        }
    }
    return result;
}

function getResultFormatValue(value) {
    var result = 0;
    if (value) {
        result = Math.round10((value), -2);
    }
    return result;
}

(function () {
    /**
     * Ajuste decimal de un número.
     *
     * @param {String}  tipo  El tipo de ajuste.
     * @param {Number}  valor El numero.
     * @param {Integer} exp   El exponente (el logaritmo 10 del ajuste base).
     * @returns {Number} El valor ajustado.
     */
    function decimalAdjust(type, value, exp) {
        // Si el exp no está definido o es cero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // Si el valor no es un número o el exp no es un entero...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function (value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function (value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function (value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
})();

function getDataLocationMap(params) {
    var vCurrent = params['vCurrent'];
    var $scope = vCurrent;
    var result = {};
    if (params.isErrorGoogle) {

        var $information_address_location_current = {
            country_code_id: 'ChIJ1UuaqN2HI5ARAjecEQSvdp0',
            administrative_area_level_2: 'ChIJ8WXUfPdrKo4R2h0TE4mhAto',
            administrative_area_level_3: '',
            administrative_area_level_1: 'ChIJXTdbeKE8Ko4Ra1N65thz2_c',

        };
        $information_address_location_current = JSON.stringify($information_address_location_current);
        var options_map = {"zoom": 15, "latLng": {"lat": 0.2314799, "lng": -78.271874}};
        optionsMap = JSON.stringify(options_map);

        result['optionsMap'] = optionsMap;
        result['information_address_location_current'] = $information_address_location_current;
    } else {
        var dataSendParams = params['data'];
        var options_map = dataSendParams['options_map'];

        var resultStructure = $scope.getStructureLocation(dataSendParams);
        var optionsMap = JSON.stringify(options_map);

        var $information_address_location_current = JSON.stringify(resultStructure);
        result['optionsMap'] = optionsMap;
        result['information_address_location_current'] = $information_address_location_current;

    }

    return result;
}
