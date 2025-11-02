var componentThisDentalPieceByOdontogram;
Vue.component('dental-piece-by-odontogram-component', {
    template: '#dental-piece-by-odontogram-template',
    directives: {
        initS2DentalPiece: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2DentalPiece({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ReferencePiecePosition: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ReferencePiecePosition({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ReferencePiece: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ReferencePiece({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2OdontogramByPatient: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2OdontogramByPatient({
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

        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisDentalPieceByOdontogram = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "status": {required},
            "description": {},
            "type": {required},
            "dental_piece_id_data": {required},
            "reference_piece_position_id_data": {required},
            "reference_piece_id_data": {required},
            "odontogram_by_patient_id_data": {required}
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
            tabCurrentSelector: '#tab-dental-piece-by-odontogram',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#dental-piece-by-odontogram-form",
                url: $('#action-dental-piece-by-odontogram-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el DentalPieceByOdontogram.',
                successMessage: 'El DentalPieceByOdontogram se guardo correctamente.',
                nameModel: "DentalPieceByOdontogram"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#dental-piece-by-odontogram-grid",
                url: $("#action-dental-piece-by-odontogram-getAdmin").val()
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
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.type = rowCurrent.type;
                this.model.attributes.dental_piece_id_data = {
                    id: rowCurrent.dental_piece_id,
                    text: rowCurrent.dental_piece
                };
                this.model.attributes.reference_piece_position_id_data = {
                    id: rowCurrent.reference_piece_position_id,
                    text: rowCurrent.reference_piece_position
                };
                this.model.attributes.reference_piece_id_data = {
                    id: rowCurrent.reference_piece_id,
                    text: rowCurrent.reference_piece
                };
                this.model.attributes.odontogram_by_patient_id_data = {
                    id: rowCurrent.odontogram_by_patient_id,
                    text: rowCurrent.odontogram_by_patient
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
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type.label + ":</span><span class='content-description__value'>" + row.type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.dental_piece_id_data.label + ":</span><span class='content-description__value'>" + row.dental_piece + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.reference_piece_position_id_data.label + ":</span><span class='content-description__value'>" + row.reference_piece_position + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.reference_piece_id_data.label + ":</span><span class='content-description__value'>" + row.reference_piece + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span   elementType='11'  class='content-description__title'>" + structure.odontogram_by_patient_id_data.label + ":</span><span class='content-description__value'>" + row.odontogram_by_patient + "</span>",
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
                "status": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "status"
                    },
                    "id": "status",
                    "name": "status",
                    "label": "status",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
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
                "type": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "PERMANENT", "text": "PERMANENT"}, {
                            "value": "TEMPORARY",
                            "text": "TEMPORARY"
                        }],
                        "required": true,
                        "name": "type"
                    },
                    "id": "type",
                    "name": "type",
                    "label": "type",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "PERMANENT", "text": "PERMANENT"}, {
                        "value": "TEMPORARY",
                        "text": "TEMPORARY"
                    }]
                },
                "dental_piece_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "dental_piece_id_data"
                    },
                    "id": "dental_piece_id_data",
                    "name": "dental_piece_id_data",
                    "label": "dental piece id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "reference_piece_position_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "reference_piece_position_id_data"
                    },
                    "id": "reference_piece_position_id_data",
                    "name": "reference_piece_position_id_data",
                    "label": "reference piece position id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "reference_piece_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "reference_piece_id_data"
                    },
                    "id": "reference_piece_id_data",
                    "name": "reference_piece_id_data",
                    "label": "reference piece id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "odontogram_by_patient_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "odontogram_by_patient_id_data"
                        },
                        "id": "odontogram_by_patient_id_data",
                        "name": "odontogram_by_patient_id_data",
                        "label": "odontogram by patient id",
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
                "status": "ACTIVE",
                "description": null,
                "type": null,
                "dental_piece_id_data": null,
                "reference_piece_position_id_data": null,
                "reference_piece_id_data": null,
                "odontogram_by_patient_id_data": null
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
                DentalPieceByOdontogram:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "status": this.$v.model.attributes.status.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "type": this.$v.model.attributes.type.$model,
                        "dental_piece_id": this.$v.model.attributes.dental_piece_id_data.$model.id,
                        "reference_piece_position_id": this.$v.model.attributes.reference_piece_position_id_data.$model.id,
                        "reference_piece_id": this.$v.model.attributes.reference_piece_id_data.$model.id,
                        "odontogram_by_patient_id": this.$v.model.attributes.odontogram_by_patient_id_data.$model.id

                    }
            };

            return result;
        },
        _saveModel: _saveModel,
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions
        _managerS2DentalPiece: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.dental_piece_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-dental-piece-getListSelect2").val(),
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
                _this.model.attributes.dental_piece_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.dental_piece_id_data = null;
                _this._setValueForm('dental_piece_id_data', null);
            });
        }, _managerS2ReferencePiecePosition: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.reference_piece_position_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-reference-piece-position-getListSelect2").val(),
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
                _this.model.attributes.reference_piece_position_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.reference_piece_position_id_data = null;
                _this._setValueForm('reference_piece_position_id_data', null);
            });
        }, _managerS2ReferencePiece: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.reference_piece_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-reference-piece-getListSelect2").val(),
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
                _this.model.attributes.reference_piece_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.reference_piece_id_data = null;
                _this._setValueForm('reference_piece_id_data', null);
            });
        }, _managerS2OdontogramByPatient: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.odontogram_by_patient_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-odontogram-by-patient-getListSelect2").val(),
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
                _this.model.attributes.odontogram_by_patient_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.odontogram_by_patient_id_data = null;
                _this._setValueForm('odontogram_by_patient_id_data', null);
            });
        },

    }
})
;



