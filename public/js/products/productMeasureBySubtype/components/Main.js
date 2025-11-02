var componentThisProductMeasureBySubtype;
Vue.component('product-measure-by-subtype-component', {
    template: '#product-measure-by-subtype-template',
    directives: {
        initS2ProductMeasureType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductMeasureType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductMeasurementSubtype: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductMeasurementSubtype({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisProductMeasureBySubtype = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "product_measure_type_id_data": {required},
            "product_measurement_subtype_id_data": {required}
        };
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
                "buttonsManagements": []
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
            tabCurrentSelector: '#tab-product-measure-by-subtype',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#product-measure-by-subtype-form",
                url: $('#action-product-measure-by-subtype-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ProductMeasureBySubtype.',
                successMessage: 'El ProductMeasureBySubtype se guardo correctamente.',
                nameModel: "ProductMeasureBySubtype"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#product-measure-by-subtype-grid",
                url: $("#action-product-measure-by-subtype-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
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
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.product_measure_type_id_data = {
                    id: rowCurrent.product_measure_type_id,
                    text: rowCurrent.product_measure_type
                };
                this.model.attributes.product_measurement_subtype_id_data = {
                    id: rowCurrent.product_measurement_subtype_id,
                    text: rowCurrent.product_measurement_subtype
                };

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span><span class='content-description__value'>" + row.product_measure_type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span   11  class='content-description__title'>" + structure.product_measurement_subtype_id_data.label + ":</span><span class='content-description__value'>" + row.product_measurement_subtype + "</span>",
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
                vmCurrent._resetManagerGrid();

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
                    label: "Medida",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_measurement_subtype_id_data: {
                    id: "product_measurement_subtype_id_data",
                    name: "product_measurement_subtype_id_data",
                    label: "Tipo de Medida",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "product_measure_type_id_data": null, "product_measurement_subtype_id_data": null
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
            if (name == 'product_measure_type_id_data') {
                if (value == null) {
                    this.$v["model"]["attributes"]['product_measurement_subtype_id_data'].$model = null;
                }
            }
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
            var relations = [];
            $.each(this.$v.model.attributes.product_measurement_subtype_id_data.$model, function (key, value) {
                var setPush = value.id;
                relations.push(setPush);
            });
            var result = {
                ProductMeasureBySubtype:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model.id,
                        "product_measurement_subtype_id": this.$v.model.attributes.product_measurement_subtype_id_data.$model.id,
                        'relations': relations
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
        _managerS2ProductMeasureType: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.product_measure_type_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-measure-type-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.product_measure_type_id_data = data;

                var dataRelations = null;
                if (Object.keys(_this.$v.model.attributes.product_measure_type_id_data.$model.relations).length > 0) {
                    dataRelations = _this.$v.model.attributes.product_measure_type_id_data.$model.relations;
                }

                if (dataRelations) {
                    if ($("#product_measurement_subtype_id_data").val()) {
                        if ($("#product_measurement_subtype_id_data").val().length > 0) {
                            $("#product_measurement_subtype_id_data").val('').trigger('change');
                            _this.model.attributes.product_measurement_subtype_id_data = null;
                        }
                        var data = dataRelations;
                        _this.setValuesS2Multiple({
                            elementS2: $("#product_measurement_subtype_id_data"),
                            'data': data,
                            attribute_name: 'product_measurement_subtype_id_data'
                        });
                    }
                } else {
                    if ($("#product_measurement_subtype_id_data").val()) {
                        $("#product_measurement_subtype_id_data").val('').trigger('change');
                        _this.model.attributes.product_measurement_subtype_id_data = null;
                    }

                }

            }).on("select2:unselecting", function (e) {
                _this.model.attributes.product_measure_type_id_data = null;
                _this._setValueForm('product_measure_type_id_data', null);
            });
        }, _managerS2ProductMeasurementSubtype: function (params) {
            var el = params.objSelector

            var _this = this;

            var dataRelations = null;
            if (Object.keys(this.$v.model.attributes.product_measure_type_id_data.$model.relations).length > 0) {
                dataRelations = this.$v.model.attributes.product_measure_type_id_data.$model.relations;
            }


            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {
                    url: $("#action-product-measurement-subtype-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                width: '100%'
            });

            elementInit.on('change', function (e) {
                var data = elementInit.select2('data');
                if (Object.keys(data).length == 0) {
                    _this.model.attributes.product_measurement_subtype_id_data = null;
                    _this._setValueForm('product_measurement_subtype_id_data', null);
                } else {
                    _this.model.attributes.product_measurement_subtype_id_data = data;

                }
            });
            if (dataRelations) {
                var data = dataRelations;
                _this.setValuesS2Multiple({
                    elementS2: $(el),
                    'data': data,
                    attribute_name: 'product_measurement_subtype_id_data'
                });
            }
        },
        setValuesS2Multiple: function (params) {

            var attribute_name = params['attribute_name'];//id
            var elementS2 = params['elementS2'];
            setValuesS2Multiple(params);
            var dataCurrent = elementS2.select2('data');
            this.model.attributes[attribute_name] = dataCurrent;

        }
    }
})
;




