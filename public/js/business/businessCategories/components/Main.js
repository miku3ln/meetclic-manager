var componentThisBusinessCategories;
Vue.component('business-categories-component', {
    template: '#business-categories-template',
    directives: {
        initEventUploadSrc: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
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
        componentThisBusinessCategories = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {}, "change": {},
            "name": {required, maxLength: Validators.maxLength(45)},
            "status": {required},
            "src": {required},
            "has_icon": {},
            "icon_class": {required, maxLength: Validators.maxLength(20)},
            "description": {required}
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
                    },  {
                        "title": "Subcategorias",
                        "data-placement": "top",
                        "i-class": " fa fa-list-alt",
                        "managerType": "addSubcategory"
                    },
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
            tabCurrentSelector: '#tab-business-categories',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-categories-form",
                url: $('#action-business-categories-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessCategories.',
                successMessage: 'El BusinessCategories se guardo correctamente.',
                nameModel: "BusinessCategories"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-categories-grid",
                url: $("#action-business-categories-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            configModalBusinessSubcategories:{
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
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.src = rowCurrent.src;
                this.model.attributes.has_icon = rowCurrent.has_icon == 1 ? true : false;
                this.model.attributes.icon_class = rowCurrent.icon_class;
                this.model.attributes.description = rowCurrent.description;

                this._viewManager(3, rowId);
            }else   if (params.managerType == "addSubcategory") {

                this.configModalBusinessSubcategories.data = rowCurrent;
                if (this.configModalBusinessSubcategories.viewAllow) {
                    this.$refs.refBusinessSubcategories._setValueOfParent(
                        {type: "openModal", data: this.configModalBusinessSubcategories}
                    );
                } else {
                    this.configModalBusinessSubcategories.viewAllow = true;
                }
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
                    var srcHtml= row.src=='no-manager' ||row.src=='manager'?[]:[

                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + row.src + "'> ",
                        "</div>",
                    ];
                    srcHtml=srcHtml.join('');
                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",
srcHtml,

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.has_icon.label + ":</span><span class='content-description__value'>" + row.has_icon + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.icon_class.label + ":</span><span class='content-description__value'>" + row.icon_class + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
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
                "name": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 45,
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
                        "msj": "# Carecteres Excedidos a 45.",
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
                "src": {
                    "field-options": {
                        "elementType": 11,
                        "elementTypeText": "Image Upload",
                        "required": true,
                        "name": "src"
                    },
                    "id": "src",
                    "name": "src",
                    "label": "Imagen",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "has_icon": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "Tiene Icono?"
                    },
                    "id": "has_icon",
                    "name": "has_icon",
                    "label": "has icon",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "icon_class": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 20,
                        "required": true,
                        "name": "icon_class"
                    },
                    "id": "icon_class",
                    "name": "icon_class",
                    "label": "Icono Name",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 20.",
                    },
                },
                "description":
                    {
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
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "change": false,
                "name": null,
                "status": "ACTIVE",
                "src": null,
                "has_icon": null,
                "icon_class": null,
                "description": null
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
                    "name": this.$v.model.attributes.name.$model,
                    "status": this.$v.model.attributes.status.$model,
                    "src": this.$v.model.attributes.src.$model,
                    "has_icon": this.$v.model.attributes.has_icon.$model == null ? 0 : (this.$v.model.attributes.has_icon.$model ? 1 : 0),
                    "icon_class": this.$v.model.attributes.icon_class.$model,
                    "description": this.$v.model.attributes.description.$model

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



