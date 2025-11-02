var componentThisGamificationByRewards;
Vue.component('gamification-by-rewards-component', {
    template: '#gamification-by-rewards-template',
    directives: {
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2Manager: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._initS2Manager({
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


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisGamificationByRewards = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {}, "change": {},
            "source": {},
            "title": {required},
            "subtitle": {},
            "description": {required},
            "state": {required},
            "has_source": {},
            "points": {required},
            "entity": {},
            "entity_id_data": {},
            "percentage": {between: between(0, 100)},
            "amount": {},
            "specific": {}
        };
        if (this.model.attributes.has_source) {
            attributes['source'] = {required};
        }
        if (this.model.attributes.entity == 0) {
            attributes['percentage'] = {required, between: between(0, 100)};
        }
        if (this.model.attributes.specific == 3 || this.model.attributes.specific == 1) {
            attributes['entity_id_data'] = {required};

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
            manager_id: null,
            business_id: null,

            manager_key_name: 'gamification_id',
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
            tabCurrentSelector: '.modal-dialog',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#gamification-by-rewards-form",
                url: $('#action-gamification-by-rewards-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el GamificationByRewards.',
                successMessage: 'El GamificationByRewards se guardo correctamente.',
                nameModel: "GamificationByRewards"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#gamification-by-rewards-grid",
                url: $("#action-gamification-by-rewards-getAdmin").val()
            },
            showManager: false,
            managerType: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.gamification_id;
            this.business_id = $businessManager.id;// this.configParams.business_id;
            this.initGridManager(this);
            this.initDataModal();
            this.$refs.refGamificationByRewardsModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalGamificationByRewards'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refGamificationByRewardsModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                this.$refs.refGamificationByRewardsModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_businessByGamification', params);
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
                this._viewManager(3, rowId);
                this.resetForm();
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.subtitle = rowCurrent.subtitle;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.has_source = rowCurrent.has_source == 1 ? true : false;
                this.model.attributes.points = parseFloat(rowCurrent.points);
                this.model.attributes.entity = rowCurrent.entity;
                var row = rowCurrent;

                if (row.specific == 0 && row.entity == 0 && row.entity_id == -1) {

                }
                //type specific product -discount
                else if (row.specific == 1 && row.entity == 0 && row.entity_id != -1) {
                    this.model.attributes.entity_id_data_aux = {
                        id: rowCurrent.entity_id,
                        text: rowCurrent.entity_name
                    };
                }
                //type all services -discount
                else if (row.specific == 2 && row.entity == 0 && row.entity_id == -1) {

                }
                //type specific service -discount
                else if (row.specific == 3 && row.entity == 0 && row.entity_id != -1) {
                    this.model.attributes.entity_id_data_aux = {
                        id: rowCurrent.entity_id,
                        text: rowCurrent.entity_name
                    };
                }

                this.model.attributes.percentage = parseFloat(rowCurrent.percentage);
                this.model.attributes.amount = parseFloat(rowCurrent.amount);
                this.model.attributes.specific = parseInt(rowCurrent.specific);

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
                    var imgView = row.has_source ? [
                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + $publicAsset+ row.source + "'> ",
                        "</div>",

                    ] : [];
                    imgView = imgView.join('');
                    //type all product -discount
                    var detailsEntity = [];
                    if (row.specific == 0 && row.entity == 0 && row.entity_id == -1) {
                        detailsEntity = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Aplica:</span><span class='content-description__value'>A todos los Productos.</span>",
                            "</div>",
                        ];
                    }
                    //type specific product -discount
                    else if (row.specific == 1 && row.entity == 0 && row.entity_id != -1) {
                        detailsEntity = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Aplica:</span><span class='content-description__value'>" + row.entity_name + "</span>",
                            "</div>",
                        ];
                    }
                    //type all services -discount
                    else if (row.specific == 2 && row.entity == 0 && row.entity_id == -1) {
                        detailsEntity = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Aplica:</span><span class='content-description__value'> A todos los servicios.</span>",
                            "</div>",
                        ];
                    }
                    //type specific service -discount
                    else if (row.specific == 3 && row.entity == 0 && row.entity_id != -1) {
                        detailsEntity = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Aplica:</span><span class='content-description__value'>" + row.entity_name + "</span>",
                            "</div>",
                        ];
                    }
                    detailsEntity = detailsEntity.join('');
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",
                        imgView,
                        detailsEntity,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.subtitle.label + ":</span><span class='content-description__value'>" + row.subtitle + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.points.label + ":</span><span class='content-description__value'><span class='badge badge--size-large  badge-info '>" + row.points + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.percentage.label + ":</span><span class='content-description__value'>" + row.percentage + "</span>",
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
                "source": {
                    "field-options": {
                        "elementType": 11,
                        "elementTypeText": "Image Upload",
                        "required": true,
                        "name": "source"
                    },
                    "id": "source",
                    "name": "source",
                    "label": "Imagen",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "title": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "title"
                    },
                    "id": "title",
                    "name": "title",
                    "label": "Titulo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "subtitle": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "subtitle"
                    },
                    "id": "subtitle",
                    "name": "subtitle",
                    "label": "Subtitulo",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
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
                    "label": "Descripcion",
                    "required": {
                        "allow": true,
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
                    "label": "Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "has_source": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "has_source"
                    },
                    "id": "has_source",
                    "name": "has_source",
                    "label": "Añadir Imagen!",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "points": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "points"
                    },
                    "id": "points",
                    "name": "points",
                    "label": "Puntos Canjeo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "entity": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "entity"
                    },
                    "id": "entity",
                    "name": "entity",
                    "label": "Premio",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [
                        {"value": 0, "text": "Descuentos"},
                    ]
                },
                "entity_id_data": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "entity_id_data"
                    },
                    "id": "entity_id_data",
                    "name": "entity_id_data",
                    "label": "Product/Servicio",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "percentage": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "percentage"
                    },
                    "id": "percentage",
                    "name": "percentage",
                    "label": "Valor %",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    'between': {
                        "msj": "Debe estar entre ",
                        min: 0,
                        max: 100,

                    }
                },
                "amount": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "amount"
                    },
                    "id": "amount",
                    "name": "amount",
                    "label": "Cantidad",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "specific":
                    {
                        "field-options": {
                            "elementType": 2,
                            "elementTypeText": "CheckBox",
                            "required": false,
                            "name": "specific"
                        },
                        "id": "specific",
                        "name": "specific",
                        "label": "Aplica",
                        "required": {
                            "allow": false,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [
                           /* {"value": 0, "text": "Todos los Productos"},*/
                            {"value": 1, "text": "Producto en Especifico"},
                          /*  {"value": 2, "text": "Todos los Servicios"},*/
                            {"value": 3, "text": "Servicio en Especifico"},

                        ]
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "change": false,
                "source": null,
                "title": null,
                "subtitle": null,
                "description": null,
                "state": "ACTIVE",
                "has_source": true,
                "points": 0,
                "entity": 0,
                "entity_id_data": null,
                "percentage": 0,
                "amount": 0,
                "specific": 1
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
                    "source": this.$v.model.attributes.source.$model,
                    "title": this.$v.model.attributes.title.$model,
                    "subtitle": this.$v.model.attributes.subtitle.$model,
                    "description": this.$v.model.attributes.description.$model,
                    "state": this.$v.model.attributes.state.$model,
                    "has_source": this.$v.model.attributes.has_source.$model == null ? 0 : (this.$v.model.attributes.has_source.$model ? 1 : 0),
                    "gamification_id": this.manager_id,
                    "points": this.$v.model.attributes.points.$model,
                    "entity": this.$v.model.attributes.entity.$model,
                    "entity_id": this.$v.model.attributes.entity_id_data.$model == null ? -1 : (this.$v.model.attributes.entity_id_data.$model.id),
                    "percentage": this.$v.model.attributes.percentage.$model,
                    "amount": this.$v.model.attributes.amount.$model,
                    "specific": this.$v.model.attributes.specific.$model == null ? -1 : (this.$v.model.attributes.specific.$model)

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

            var result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _managerS2Products: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                this.model.attributes.entity_id_data= this.model.attributes.entity_id_data_aux;
                dataCurrent = [this.model.attributes.entity_id_data];

                var textCurrent = dataCurrent[0].text;
                var idCurrent = dataCurrent[0].id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-products-getBusinessProductsListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
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
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.entity_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.entity_id_data = null;
                _this._setValueForm('entity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _managerS2Services: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                this.model.attributes.entity_id_data= this.model.attributes.entity_id_data_aux;
                dataCurrent = [this.model.attributes.entity_id_data];

                var textCurrent = dataCurrent[0].text;
                var idCurrent = dataCurrent[0].id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-services-getBusinessServicesListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
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
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.entity_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.entity_id_data = null;
                _this._setValueForm('entity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
    }
})
;



