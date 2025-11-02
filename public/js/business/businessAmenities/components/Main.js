var componentThisBusinessAmenities;
Vue.component('business-amenities-component', {
    template: '#business-amenities-template',
    directives: {
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2BusinessSubcategories: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2BusinessSubcategories({
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
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisBusinessAmenities = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {}, "change": {},
            "value": {required, maxLength: Validators.maxLength(150)},
            "description": {},
            "state": {required},
            "source": {},
            "type_source": {},
            "business_subcategories_id_data": {required}
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
            manager_id: null,
            manager_key_name: 'change_key',
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    }
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Informacion",
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-business-amenities',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-amenities-form",
                url: $('#action-business-amenities-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessAmenities.',
                successMessage: 'El BusinessAmenities se guardo correctamente.',
                nameModel: "BusinessAmenities"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-amenities-grid",
                url: $("#action-business-amenities-getAdmin").val()
            },
            showManager: false,
            managerType: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.id;
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
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
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
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.type_source = rowCurrent.type_source == 1 ? true : false;
                this.model.attributes.business_subcategories_id_data = {
                    id: rowCurrent.business_subcategories_id,
                    text: rowCurrent.business_subcategories
                };

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + row.source + "'> ",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_source.label + ":</span><span class='content-description__value'>" + row.type_source + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span   elementType='11'  class='content-description__title'>" + structure.business_subcategories_id_data.label + ":</span><span class='content-description__value'>" + row.business_subcategories + "</span>",
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
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: _viewManager,
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "value": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 150,
                        "required": true,
                        "name": "value"
                    },
                    "id": "value",
                    "name": "value",
                    "label": "value",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 150.",
                    },
                },
                "description": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "description"
                    },
                    "id": "description",
                    "name": "description",
                    "label": "description",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "state": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "state"
                    },
                    "id": "state",
                    "name": "state",
                    "label": "state",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "source": {
                    "field-options": {
                        "elementType": 11,
                        "elementTypeText": "Image Upload",
                        "required": true,
                        "name": "source"
                    },
                    "id": "source",
                    "name": "source",
                    "label": "source",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_source": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "type_source"
                    },
                    "id": "type_source",
                    "name": "type_source",
                    "label": "type source",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "business_subcategories_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "business_subcategories_id_data"
                        },
                        "id": "business_subcategories_id_data",
                        "name": "business_subcategories_id_data",
                        "label": "business subcategories id",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "change": false,
                "value": null,
                "description": null,
                "state": "ACTIVE",
                "source": null,
                "type_source": null,
                "business_subcategories_id_data": null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,

        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {

            var result = {
                    "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    change: this.$v.model.attributes.change.$model,
                    "value": this.$v.model.attributes.value.$model,
                    "description": this.$v.model.attributes.description.$model,
                    "state": this.$v.model.attributes.state.$model,
                    "source": this.$v.model.attributes.source.$model,
                    "type_source": this.$v.model.attributes.type_source.$model == null ? 0 : (this.$v.model.attributes.type_source.$model ? 1 : 0),
                    "business_subcategories_id": this.$v.model.attributes.business_subcategories_id_data.$model.id

                }
            ;

            return result;
        },
        _saveModel: function () {


            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                alert('error');
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
                }, true);

            }

        },
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions
        _managerEventsUpload: function (params) {
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        }, _managerS2BusinessSubcategories: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.business_subcategories_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-business-subcategories-getListSelect2").val(),
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
                _this.model.attributes.business_subcategories_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.business_subcategories_id_data = null;
                _this._setValueForm('business_subcategories_id_data', null);
            });
        },
        //uploads methods
        _uploadDataImage: function (eventSelector) {
            var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
                toElement: eventSelector.toElement
            });
            selectorFile = '#file-' + selectorFile;
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var modelCurrent = params['modelCurrent'];

            var result = {
                'selectorUpload': '#file-' + nameField,
                'selectorPreview': '#preview-' + nameField,
                'modelCurrent': modelCurrent,
                'modelAttributeName': nameField,
            };
            return result;
        },


    }
})
;



