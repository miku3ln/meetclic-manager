var componentThisUnitMeasure;
var configManager = {
    'model': "UnitMeasure",
    'camel': "unitMeasure",
    'name': "unit-measure",

};
Vue.component(configManager.name + '-component', {
    template: '#' + configManager.name + '-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $this = this;
        this.$root.$on("_" + configManager.camel, function (emitValue) {
            $this._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.model_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisUnitMeasure = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {

        var attributes = {
            "id": {},

            "product_measure_type_id_data": {
                required
            },

            "name": {
                required,
                maxLength: Validators.maxLength(100)
            },

            "symbol": {
                required,
                maxLength: Validators.maxLength(100)
            },

            "factor_to_base": {
                required
            },

            "is_base": {},

            "decimal_precision": {},

            "state": {
                required
            },

            "change": {},
        };

        var result = {
            model: {
                attributes: attributes
            },
        };

        return result;
    },
    data: function () {

        var dataManager = {
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                  /*  {
                        "title": "Agregar Conversiones",
                        "data-placement": "top",
                        "i-class": " fas fa-ruler",
                        "managerType": "managerData"
                    }*/

                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-unit-measure',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#" + configManager.name + "-form",
                url: $('#action-' + configManager.name + '-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Template News.',
                successMessage: 'El ' + configManager.model + ' se guardo correctamente.',
                nameModel: configManager.model
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#" + configManager.name + "-grid",
                url: $("#action-unit-measure-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            //Uploads
            uploadConfig: {
                uploadElementsSelectors: {
                    image: "#file_source"
                },
                labelsButtons: {
                    image: "Subir Imagen.",

                },
                viewUpload: {
                    image: "#preview-source"
                }
            },
            configModalUnitMeasureByData: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },

        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initGridManager(this);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: function (params) {
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
        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: function (selector) {
            $(selector).tooltip('hide');
        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null
            };
        },
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
        getMenuConfig: function (params) {
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
        },
        _gridManager: function (elementSelect) {
            var $this = this;
            var selectorGrid = $this.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $this,
                elementSelect: elementSelect,

            });
        },
        setValuesModel: function (params) {

            var rowCurrent = params.rowCurrent;

            this.model.attributes.id = rowCurrent.id;
            this.model.attributes.product_measure_type_id = rowCurrent.product_measure_type_id;
            this.model.attributes.product_measure_type_id_data =
                this.model.structure.product_measure_type_id_data.options.find(function (item) {
                    return parseInt(item.id) === parseInt(rowCurrent.product_measure_type_id);
                }) || null;

            this.model.attributes.name = rowCurrent.name;

            this.model.attributes.symbol = rowCurrent.symbol;

            this.model.attributes.factor_to_base = rowCurrent.factor_to_base;

            this.model.attributes.is_base = rowCurrent.is_base;

            this.model.attributes.decimal_precision = rowCurrent.decimal_precision;

            this.model.attributes.state = rowCurrent.state;

            this.model.attributes.change = false;
        },
        managerConversion: function (rowCurrent) {
            var keyData = "configModal" + configManager.model + "ByData";
            this[keyData].data = rowCurrent;
            if (this[keyData].viewAllow) {
                this.$refs.refBusinessHistoryByData._setValueOfParent(
                    {type: "openModal", data: this.configModalBusinessHistoryByData}
                );
            } else {
                this[keyData].viewAllow = true;
            }
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.setValuesModel({
                    rowCurrent: rowCurrent
                });
                this._viewManager(3, rowId);
            } else if (params.managerType == 'languageEntity') {

            } else {

                this.managerConversion(rowCurrent);
            }
        },
        initGridManager: function ($this) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {

                business_id: this.model_id

            };
            var structure = $this.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var classState = "badge-success";
                    var classBase = "badge-warning";

                    if (row.state == "INACTIVE") {
                        classState = "badge-warning";
                    }

                    if (row.is_base == 1) {
                        classBase = "badge-success";
                    }

                    var result = [

                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span>",
                        "   <span class='content-description__value'>",
                        "       <span class='badge badge--size-large " + classState + "'>" + row.state + "</span>",
                        "   </span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span>",
                        "   <span class='content-description__value'>" + (row.product_measure_type || "-") + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span>",
                        "   <span class='content-description__value'>" + (row.name || "-") + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.symbol.label + ":</span>",
                        "   <span class='content-description__value'>" + (row.symbol || "-") + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.factor_to_base.label + ":</span>",
                        "   <span class='content-description__value'>" + row.factor_to_base + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.is_base.label + ":</span>",
                        "   <span class='content-description__value'>",
                        "       <span class='badge badge--size-large " + classBase + "'>" + (row.is_base == 1 ? "Sí" : "No") + "</span>",
                        "   </span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.decimal_precision.label + ":</span>",
                        "   <span class='content-description__value'>" + row.decimal_precision + "</span>",
                        "</div>",

                        "</div>"
                    ];

                    return result.join("");
                }
            };

            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                $this._resetManagerGrid();
                $this._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
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
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        },
//FORM CONFIG
        getViewErrorForm: function (objValidate) {
            var result = false
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }
            return result;
        },
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                product_measure_type_id_data: {
                    id: "product_measure_type_id_data",
                    name: "product_measure_type_id_data",
                    label: "Tipo de Medida",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        {
                            id: 1,
                            value: "Masa",
                            text: "Masa",
                            description: "Medición de peso de productos o sustancias",
                            abbreviation: "KG",
                            unit: 0,
                            number_of_units: 1,
                            prefix: "kg",
                            symbol: "kg",
                            business_id: 0
                        },
                        {
                            id: 2,
                            value: "LONGITUD",
                            text: "LONGITUD",
                            description: "Medición de distancia o tamaño lineal",
                            abbreviation: "M",
                            unit: 0,
                            number_of_units: 1,
                            prefix: "m",
                            symbol: "m",
                            business_id: 0
                        },
                        {
                            id: 3,
                            value: "VOLUMEN",
                            text: "VOLUMEN",
                            description: "Medición de capacidad de líquidos o espacios",
                            abbreviation: "L",
                            unit: 1,
                            number_of_units: 12,
                            prefix: "l",
                            symbol: "l",
                            business_id: 0
                        },
                        {
                            id: 4,
                            value: "AREA",
                            text: "AREA",
                            description: "Medición de superficie o extensión",
                            abbreviation: "M2",
                            unit: 1,
                            number_of_units: 2,
                            prefix: "m2",
                            symbol: "m2",
                            business_id: 0
                        },
                        {
                            id: 5,
                            value: "UNIDAD",
                            text: "UNIDAD",
                            description: "Medición discreta para productos no convertibles",
                            abbreviation: "UNI",
                            unit: 0,
                            number_of_units: 1,
                            prefix: "u",
                            symbol: "u",
                            business_id: 0
                        }
                    ]
                },

                name: {
                    id: "name",
                    name: "name",
                    label: "Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Caracteres Excedidos a 100.",
                    },
                },

                symbol: {
                    id: "symbol",
                    name: "symbol",
                    label: "Símbolo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Caracteres Excedidos a 100.",
                    },
                },

                factor_to_base: {
                    id: "factor_to_base",
                    name: "factor_to_base",
                    label: "Factor de Conversión",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                is_base: {
                    id: "is_base",
                    name: "is_base",
                    label: "Unidad Base",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        {
                            "value": 0,
                            "text": "No"
                        },
                        {
                            "value": 1,
                            "text": "Sí"
                        }
                    ]
                },

                decimal_precision: {
                    id: "decimal_precision",
                    name: "decimal_precision",
                    label: "Precisión Decimal",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                state: {
                    id: "state",
                    name: "state",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        {
                            "value": "ACTIVE",
                            "text": "ACTIVE"
                        },
                        {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }
                    ]
                },
            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,

                "product_measure_type_id": null,
                "product_measure_type_id_data": null,

                "name": null,
                "symbol": null,
                "factor_to_base": 1,
                "is_base": 0,
                "decimal_precision": 2,
                "state": "ACTIVE",

                "change": false,

            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value) {

            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: function (nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
        getErrorHas: function (model, type) {

            var result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model

        getValuesSave: function () {
            var result = {};
            var key = configManager.model;
            result[key] = {

                "id": this.$v.model.attributes.id.$model
                    ? this.$v.model.attributes.id.$model
                    : -1,

                "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model
                    ? this.$v.model.attributes.product_measure_type_id_data.$model.id
                    : null,

                "name": this.$v.model.attributes.name.$model,

                "symbol": this.$v.model.attributes.symbol.$model,

                "factor_to_base": this.$v.model.attributes.factor_to_base.$model,

                "is_base": this.$v.model.attributes.is_base.$model,

                "decimal_precision": this.$v.model.attributes.decimal_precision.$model,

                "state": this.$v.model.attributes.state.$model,

                "change": this.$v.model.attributes.change.$model,

            };

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            vCurrent._resetManagerGrid();
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
                        }
                    }
                });
            }
        },
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm: getValidateForm,
//others functions
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': this.uploadConfig.uploadElementsSelectors.image,
                    'selectorPreview': this.uploadConfig.viewUpload.image,
                    'modelCurrent': this.model.attributes,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _uploadDataImage: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.image).click();
            event.stopPropagation();
        },
        _initEventsUpload: function (params) {

            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var _this = this;
            var modelCurrent = _this.model;
            if (modelCurrent.attributes.id) {
                var srcSource = $resourceRoot + modelCurrent.attributes.source;
                $(selectorPreview).attr("src", srcSource);

            }
            var modelAttributeName = params['modelAttributeName'];
            var progress = document.querySelector('.percent');
//------------GESTION DE SUBIDA D IMAGENS---
            $(selectorUpload).change(function () {
                var file = $(this)[0].files[0];
                var srcSourceManager = $.UploadUtil.upload({
                    typeUpload: 'image',
                    generateManager: 'generateImage',
                    'fileElement': $(this)[0].files

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


        },

    }
})
;




