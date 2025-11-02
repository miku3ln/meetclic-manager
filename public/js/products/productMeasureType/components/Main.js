var componentThisProductMeasureType;
Vue.component('product-measure-type-component', {
    template: '#product-measure-type-template',
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        var $this = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $this._managerTypes(emitValue);
        });
    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisProductMeasureType = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(100)},
            "state": {required},
            "description": {},
            "abbreviation": {required, maxLength: Validators.maxLength(100)},
            "unit": {},
            "number_of_units": {},
            "prefix": {required, maxLength: Validators.maxLength(10)},
            "symbol": {required, maxLength: Validators.maxLength(10)}
        };
        if (this.model.attributes.unit == 1) {
            attributes['number_of_units'] = {
                required
            };
        }

        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        var dataManager = {
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },{
                        "title": "Traducción Administración",
                        "data-placement": "top",
                        "i-class": " fa fa-language",
                        "managerType": "languageEntity"
                    },
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
            tabCurrentSelector: '#tab-product-measure-type',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#product-measure-type-form",
                url: $('#action-product-measure-type-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ProductMeasureType.',
                successMessage: 'El ProductMeasureType se guardo correctamente.',
                nameModel: "ProductMeasureType"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#product-measure-type-grid",
                url: $("#action-product-measure-type-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            configModalLanguageProductMeasureType: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            }
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

            }else if (emitValues.type == "resetComponent") {
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
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.abbreviation = rowCurrent.abbreviation;
                this.model.attributes.unit = rowCurrent.unit == 1 ? true : false;
                this.model.attributes.number_of_units = parseFloat(rowCurrent.number_of_units);
                this.model.attributes.prefix = rowCurrent.prefix;
                this.model.attributes.symbol = rowCurrent.symbol;

                this._viewManager(3, rowId);
            }else if(params.managerType=='languageEntity'){
                this.configModalLanguageProductMeasureType.data = rowCurrent;
                if (this.configModalLanguageProductMeasureType.viewAllow) {
                    this.$refs.refLanguageProductMeasureType._setValueOfParent(
                        {type: "openModal", data: this.configModalLanguageProductMeasureType}
                    );
                } else {
                    this.configModalLanguageProductMeasureType.viewAllow = true;
                }
            }
        },
        initGridManager: function ($this) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
            var structure = $this.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    ;var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.abbreviation.label + ":</span><span class='content-description__value'>" + row.abbreviation + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.unit.label + ":</span><span class='content-description__value'>" + row.unit + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.number_of_units.label + ":</span><span class='content-description__value'>" + row.number_of_units + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.prefix.label + ":</span><span class='content-description__value'>" + row.prefix + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.symbol.label + ":</span><span class='content-description__value'>" + row.symbol + "</span>",
                        "</div>"
                        , "</div>"];

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
                value: {
                    id: "value",
                    name: "value",
                    label: "Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 100.",
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
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripción",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                abbreviation: {
                    id: "abbreviation",
                    name: "abbreviation",
                    label: "Abreviatura",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 100.",
                    },
                },
                unit: {
                    id: "unit",
                    name: "unit",
                    label: "Caja/Unidad",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                number_of_units: {
                    id: "number_of_units",
                    name: "number_of_units",
                    label: "Cantidad",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                prefix: {
                    id: "prefix",
                    name: "prefix",
                    label: "Prefijo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 10.",
                    },
                },
                symbol: {
                    id: "symbol",
                    name: "symbol",
                    label: "Simbolo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 10.",
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "value": null,
                "state": "ACTIVE",
                "description": null,
                "abbreviation": null,
                "unit": 0,
                "number_of_units": null,
                "prefix": null,
                "symbol": null
            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,
        _setValueForm: function (name, value) {

            if (name == 'unit') {
                if (this.model.attributes['number_of_units']) {

                    this.model.attributes['number_of_units'] = null;
                    this.$v["model"]["attributes"]['number_of_units'].$model = null;
                }
            }
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
//Manager Model

        getValuesSave: function () {

            var result = {
                ProductMeasureType:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "value": this.$v.model.attributes.value.$model,
                        "state": this.$v.model.attributes.state.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "abbreviation": this.$v.model.attributes.abbreviation.$model,
                        "unit": this.$v.model.attributes.unit.$model == null ? 0 : (this.$v.model.attributes.unit.$model ? 1 : 0),
                        "number_of_units": this.$v.model.attributes.unit.$model == null ? 1 : (this.$v.model.attributes.unit.$model ? this.$v.model.attributes.number_of_units.$model : 1),
                        "prefix": this.$v.model.attributes.prefix.$model,
                        "symbol": this.$v.model.attributes.symbol.$model

                    }
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

        getValidateForm:getValidateForm,
//others functions


    }
})
;




