var componentThisGamificationByProcess;
Vue.component('gamification-by-process-component', {
    template: '#gamification-by-process-template',
    directives: {
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2GamificationTypeActivity: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2GamificationTypeActivity({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2Manager: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._initS2Manager({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    }, props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;

    },
    beforeMount: function () {
        this.configParams = this.params;
        var modelCurrentBusiness = $modelDataManager["business"][0];
        this.business_id = modelCurrentBusiness['id'];
    },
    mounted: function () {
        componentThisGamificationByProcess = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {}, "change": {},
            "source": {},
            "title": {required},
            "subtitle": {},
            "description": {required},
            "unique_code": {required},
            "state": {required},
            "has_source": {},
            "entity": {},
            "entity_id": {},
            "entity_id_data": {},
            "url_manager": {},
            "gamification_type_activity_id_data": {required},
            "is_url": {},
            "type_manager": {},
            "points": {required},
            gamification_by_points_id: {}
        };
        if (this.model.attributes.has_source) {
            attributes['source'] = {required};
        }
        if (this.model.attributes.is_url) {
            attributes['url_manager'] = {required};
        }
        if (this.model.attributes.entity == 1) {
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
                nameSelector: "#gamification-by-process-form",
                url: $('#action-gamification-by-process-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el GamificationByProcess.',
                successMessage: 'El GamificationByProcess se guardo correctamente.',
                nameModel: "GamificationByProcess"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#gamification-by-process-grid",
                url: $("#action-gamification-by-process-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            business_id: null,
            messageSectionsActivities: {
                0: {
                    'text': 'Tus clientes al Compartir el perfil de la empresa obtiene puntos configurados . '
                },
                1: {
                    'text': 'Tus clientes al Comprar,Referir,Compartir un producto o servicio  obtiene puntos configurados . '
                },
                2: {
                    'text': 'Tus clientes al Referir,Compartir una noticia obtiene puntos configurados . '
                },
                3: {
                    'text': 'Tus clientes al Compartir la  tienda obtiene puntos configurados . '
                },

            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.gamification_id;
            this.initGridManager(this);
            this.initDataModal();
            this.$refs.refGamificationByProcessModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalGamificationByProcess'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refGamificationByProcessModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refGamificationByProcessModal.show();

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
        _managerTargetGrid: function (params) {
            console.log(params);
        },
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
                this._viewManager(3, rowId);
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.subtitle = rowCurrent.subtitle;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.has_source = rowCurrent.has_source == 1 ? true : false;
                this.model.attributes.entity = rowCurrent.entity;
                this.model.attributes.entity_id = rowCurrent.entity_id;
                var row = rowCurrent;
                if (row.entity == 1) {
                    this.model.attributes.entity_id_data_aux = {
                        id: rowCurrent.entity_id,
                        text: rowCurrent.product_name
                    };
                }

                this.model.attributes.url_manager = rowCurrent.url_manager;
                this.model.attributes.gamification_type_activity_id_data = {
                    id: rowCurrent.gamification_type_activity_id,
                    text: rowCurrent.gamification_type_activity
                };
                this.model.attributes.is_url = rowCurrent.is_url == 1 ? true : false;
                this.model.attributes.type_manager = rowCurrent.type_manager == 1 ? true : false;
                this.model.attributes.points = parseFloat(rowCurrent.points);
                this.model.attributes.gamification_by_points_id = parseFloat(rowCurrent.gamification_by_points_id);

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
                    var activityName = '';

                    if (row.entity == 1) {
                        activityName = '"' + row.product_name + '"';
                    } else if (row.entity == 0) {
                        activityName = '"' + "Sección Pagina Web" + '"';

                    } else if (row.entity == 2) {
                        activityName = '"' + "Sección Noticias" + '"';

                    } else if (row.entity == 3) {
                        activityName = '"' + "Sección Tienda" + '"';

                    } else if (row.entity == 4) {
                        activityName = '"' + "Sección Descuentos" + '"';

                    } else if (row.entity == 5) {
                        activityName = '"' + "Sección Gana con Nosotros" + '"';

                    } else if (row.entity == 6) {
                        activityName = '"' + "Sección Contáctanos" + '"';

                    }

                    activityName = activityName + ' y acumula ' + "<span class='badge badge--size-large  badge-info '>" + row.points + "</span> " + structure.points.label;
                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var imgView = row.has_source ? [
                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + $publicAsset + row.source + "'> ",
                        "</div>",

                    ] : [];
                    imgView = imgView.join('');
                    var urlView = row.is_url ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.url_manager.label + ":</span><span class='content-description__value'><a href='" + row.url_manager + "' target='_blank'>Pagina vista.</a></span>",
                        "</div>",

                    ] : [];
                    urlView = urlView.join('');
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.gamification_type_activity_id_data.label + ":</span><span class='content-description__value'>" + row.gamification_type_activity + ' : ' + activityName + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.subtitle.label + ":</span><span class='content-description__value'>" + row.subtitle + "</span>",
                        "</div>",
                        imgView,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        urlView,

                        "</div>"];

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
                    "id": "title",
                    "name": "title",
                    "label": "Titulo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "points": {
                    "id": "points",
                    "name": "points",
                    "label": "Puntos",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "subtitle": {
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
                    "id": "has_source",
                    "name": "has_source",
                    "label": "Agregar Imagen!",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "entity": {
                    "id": "entity",
                    "name": "entity",
                    "label": "Seccion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                    "options": [
                        {"value": 0, "text": "Perfil Empresarial"},
                        {"value": 1, "text": "Productos/Servicios"},
                        /*         {"value": 2, "text": "Noticias"},
                                 {"value": 3, "text": "Tienda"},
                                 {"value": 4, "text": "Descuentos"},
                                 {"value": 5, "text": "Gana con Nosotros"},
                                 {"value": 6, "text": "Contáctanos"},
         */
                    ]

                },
                "entity_id": {
                    "id": "entity_id",
                    "name": "entity_id",
                    "label": "Entidad kEY",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },

                },
                "url_manager": {
                    "id": "url_manager",
                    "name": "url_manager",
                    "label": "Url",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "gamification_type_activity_id_data": {
                    "id": "gamification_type_activity_id_data",
                    "name": "gamification_type_activity_id_data",
                    "label": "Tipo de Actividad",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "is_url": {
                    "id": "is_url",
                    "name": "is_url",
                    "label": "Tiene Url?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "unique_code": {
                    "id": "unique_code",
                    "name": "unique_code",
                    "label": "Código",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_manager":
                    {
                        "id": "type_manager",
                        "name": "type_manager",
                        "label": "Tipo Gestion",
                        "required": {
                            "allow": false,
                            "msj": "Campo requerido.",
                            "error": false
                        },
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

            };
            return result;
        },
        getAttributesForm: function () {
            var entytyTypeProductService = 1;
            var result = {
                "id": null,
                "change": false,
                "source": null,
                "title": null,
                "subtitle": null,
                "description": null,
                "state": "ACTIVE",
                "has_source": true,
                "entity": entytyTypeProductService,
                "entity_id": 0,
                "url_manager": 'not-url',
                "gamification_type_activity_id_data": null,
                "is_url": false,
                "type_manager": 1,
                "unique_code": null,

                "points": 1,
                "gamification_by_points_id": null,
                "entity_id_data": null,
                entity_id_data_aux: null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,
        _setValueForm: function (name, value) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
            if (name == 'entity') {
                this.model.attributes.entity_id_data_aux = {};
                this.model.attributes.entity_id_data = {};
            }

        },
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
                    "entity": this.$v.model.attributes.entity.$model,
                    "entity_id": this.$v.model.attributes.entity_id_data.$model == null ? 0 : (this.$v.model.attributes.entity_id_data.$model.id),
                    "url_manager": this.$v.model.attributes.url_manager.$model,
                    "gamification_id": this.manager_id,
                    "gamification_type_activity_id": this.$v.model.attributes.gamification_type_activity_id_data.$model.id,
                    "is_url": this.$v.model.attributes.is_url.$model == null ? 0 : (this.$v.model.attributes.is_url.$model ? 1 : 0),
                    "type_manager": this.$v.model.attributes.type_manager.$model == null ? 0 : (this.$v.model.attributes.type_manager.$model ? 1 : 0),
                    "points": this.$v.model.attributes.points.$model,
                    "unique_code": this.$v.model.attributes.unique_code.$model,
                    "gamification_by_points_id": this.$v.model.attributes.gamification_by_points_id.$model

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
        }, _managerS2GamificationTypeActivity: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.gamification_type_activity_id_data];


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
                    url: $("#action-gamification-type-activity-getListSelect2").val(),
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
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.gamification_type_activity_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.gamification_type_activity_id_data = null;
                _this._setValueForm('gamification_type_activity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
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

                dataCurrent = this.model.attributes.entity_id_data_aux;
                this.model.attributes.entity_id_data = dataCurrent;
                var textCurrent = dataCurrent.text;
                var idCurrent = dataCurrent.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-products-getBusinessProductsServicesListSelect2").val(),
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
        getClassMessage: function (modelData) {
            var entity = modelData.entity.$model;
            var result = '';
            if (entity == 0) {

                result = {"alert-warning": true};
            } else if (entity == 1) {
                result = {"alert-info": true};

            }

            return result;
        },
    }
})
;




