var componentThisMailingTemplate;
Vue.component('mailing-template-component', {
    template: '#mailing-template-template',
    directives: {
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }}
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
        componentThisMailingTemplate = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "change": {},
            "name": {required, maxLength: Validators.maxLength(150)},
            "message": {},
            "status": {required},
            "source_main": {required, maxLength: Validators.maxLength(250)},
            "type_template": {required}
        };
        if (this.model.attributes.type_template == 1) {
            attributes['message'] = {required};
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
            manager_key_name: 'business_id',
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
            tabCurrentSelector: '#tab-mailing-template',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#mailing-template-form",
                url: $('#action-mailing-template-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el MailingTemplate.',
                successMessage: 'El MailingTemplate se guardo correctamente.',
                nameModel: "MailingTemplate"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#mailing-template-grid",
                url: $("#action-mailing-template-getAdmin").val()
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
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.message = rowCurrent.message;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.source_main = rowCurrent.source_main;
                this.model.attributes.type_template = rowCurrent.type_template;

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

                    var messageData = row.type_template == 1 ?
                        ["<div class='content-description__information'>",
                            "   <span class='content-description__title'>" + structure.message.label + ":</span><span class='content-description__value'>" + row.message + "</span>",
                            "</div>"] : [];
                    messageData = messageData.join('');
                    var result = [
                        "<div class='content-description'>",


                        "<div class='content-description__information content-description__information--image'>",
                        "   <img class='content-description__image' src='" + $resourceRoot + row.source_main + "'> ",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",
                        messageData,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",


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

                "name": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 150,
                        "required": true,
                        "name": "name"
                    },
                    "id": "name",
                    "name": "name",
                    "label": "Nombre",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 150.",
                    },
                },
                "message": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "message"
                    },
                    "id": "message",
                    "name": "message",
                    "label": "Mensaje",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
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
                    "label": "Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },

                "source_main": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 250,
                        "required": true,
                        "name": "source_main"
                    },
                    "id": "source_main",
                    "name": "source_main",
                    "label": "Imagen Publicidad",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 250.",
                    },
                },
                "type_template":
                    {
                        "field-options": {
                            "elementType": 6,
                            "elementTypeText": "Input Number",
                            "min": 0,
                            "required": true,
                            "name": "type_template"
                        },
                        "id": "type_template",
                        "name": "type_template",
                        "label": "Tipo",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": 0, "text": "Fotografia"}, {"value": 1, "text": "Fotografia - Mensaje"}]

                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "change": false,
                "name": null,
                "message": '',
                "status": "ACTIVE",
                "source_main": null,
                "type_template": 0
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
                        "business_id": this.business_id,
                        "name": this.$v.model.attributes.name.$model,
                        "message": this.$v.model.attributes.type_template.$model==1?this.$v.model.attributes.message.$model:"NONE",
                        "status": this.$v.model.attributes.status.$model,
                        "source_main": this.$v.model.attributes.source_main.$model,
                        "type_template": this.$v.model.attributes.type_template.$model,
                change: this.$v.model.attributes.change.$model,


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
            if (nameField == 'source_main') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _managerEventsUpload: function (params) {
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        }
    }
})
;



