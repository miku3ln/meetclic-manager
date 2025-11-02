var nameProcess = 'business-by-frequent-question';
var nameModel = 'BusinessByFrequentQuestion';
var configEntity = {
    'nameProcess': nameProcess,
    'eventName': '_businessByFrequentQuestion',
    objectProcess: null,
    formConfig: {
        nameSelector: "#" + nameProcess + "-form",
        url: $('#action-' + nameProcess + '-saveData').val(),
        loadingMessage: 'Guardando...',
        errorMessage: 'Error al guardar el Template News.',
        successMessage: 'El BusinessByFrequentQuestion se guardo correctamente.',
        nameModel: nameModel
    }
};
Vue.component(configEntity.nameProcess + '-component', {
    template: '#' + configEntity.nameProcess + '-template',
    directives: {
        initSummerNote: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var initMethod = paramsInput['initMethod'];
                initMethod({
                    elementInit: el
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
        var $this = this;
        this.$root.$on(configEntity.eventName, function (emitValue) {
            $this._managerTypes(emitValue);
        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.model_id = $businessManager.id;
    },
    mounted: function () {
        configEntity.objectProcess = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "title": {required, maxLength: Validators.maxLength(150)},
            "description": {required},
            "status": {required},
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
            tabCurrentSelector: '#tab-' + configEntity.nameProcess,
            processName: "Registro Acción.",
            formConfig: configEntity.formConfig,
//Grid config
            gridConfig: {
                selectorCurrent: "#" + configEntity.nameProcess + "-grid",
                url: $("#action-" + configEntity.nameProcess + "-getAdmin").val()
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

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
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
                };
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
                this._viewManager(3, rowId);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;
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
                    var classStatus = "badge-success";
                    var classMain = "badge-success";

                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }

                    var image = [];
                    image = image.join('');
                    var allow_source_data = [];
                    allow_source_data = allow_source_data.join('');
                    var result = [

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",


                        "<div class='content-description'>",
                        allow_source_data,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        image,

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
        _viewManager: _viewManager,
//FORM CONFIG
        getViewErrorForm: getViewErrorForm,
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                title: {
                    id: "title",
                    name: "title",
                    label: "Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                status: {
                    id: "status",
                    name: "status",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },


            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "title": null,
                "description": null,
                "status": "ACTIVE",
            };
            return result;
        },
        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,
        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
        getErrorHas:getErrorHas,
        getViewError: getViewError,
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm:validateForm,
        getValidateForm: getValidateForm,
//Manager Model
        getValuesSave: function () {
            var result = {
                "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                "title": this.$v.model.attributes.title.$model,
                "description": this.$v.model.attributes.description.$model,
                "status": this.$v.model.attributes.status.$model,
                "business_id": this.model_id,
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
//others functions
        _initSummerNote: function (params) {
            var elementInit = params['elementInit'];
            var fieldCurrent = $(elementInit).attr('id');
            var $this = this;
            if (this.model.attributes.id) {
                var htmlSet = this.model.attributes[fieldCurrent];
                $(elementInit).html(htmlSet);
            }
            $(elementInit).summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false,              // set focus to editable area after initializing summernote
                callbacks: {
                    onChange: function (contents, $editable) {

                        if ('<p><br></p>' == contents || '' == contents) {
                            $this.model.attributes[fieldCurrent] = null;
                        } else {
                            $this.model.attributes[fieldCurrent] = contents;
                        }
                    }
                }
            });


        }
    }
})
;




