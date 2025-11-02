var componentThisTemplateConfigMailingByEmails;
Vue.component('template-config-mailing-by-emails-component', {
    template: '#template-config-mailing-by-emails-template',
    directives: {
        'init-map-current': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initGrid();
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
    validations: function () {
        var attributes = {
            "id": {},
            "email": {required, maxLength: Validators.maxLength(150), email: Validators.email},
            "type": {required},

        };
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.setManagerCurrent({
            data: this.configParams
        });
    },
    mounted: function () {
        componentThisBusiness = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    data: function () {

        var dataManager = {
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            tabCurrentSelector: '#information-template-config-mailing-by-emails',
            processName: "Registro Acción.",
            popoverShow: false,
            'model': null,
            modelView: null,
            dataTemplateConfigMailingByEmailsTypes: [
                {id: 0, text: 'Pagina Contáctanos.'},
                {id: 1, text: 'Pagina Servicios.'},
                {id: 2, text: 'Pagina Quienes Somos.'},
                {id: 3, text: 'Pagina Footer.'},
                {id: 4, text: 'Checkout Ventas .'}

            ],

            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            model_id: null,
            business_id: null,
            formConfig: {
                nameSelector: "#template-about-us-form",
                url: $('#action-template-config-mailing-by-emails-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Red Social.',
                successMessage: 'El TemplateAboutUs se guardo correctamente.',
                nameModel: "TemplateConfigMailingByEmails"
            },
            rowManager: null,
            template_information_id: null,
            showManager: false,
            //Grid config
            gridConfig: {
                selectorCurrent: "#template-config-mailing-by-emails-grid",
                url: $("#action-template-config-mailing-by-emails-getAdmin").val()
            },
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Eliminar",
                        "data-placement": "top",
                        "i-class": "  far fa-trash-alt",
                        "managerType": "deleteEntity"
                    },
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        setManagerCurrent: function (params) {
            var dataCurrent = params.data;
            this.model_id = dataCurrent.model_id;
            this.business_id = dataCurrent.business_id;
            this.configParams = dataCurrent;
        },
        getStructureForm: function () {
            var result = {
                email: {
                    id: "email",
                    name: "email",
                    label: "Email",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                type: {
                    id: "type",
                    name: "type",
                    label: "Tipo Pagina",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "email": null,
                "type": 0,
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
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm:getValidateForm,
        onClose() {
            this.popoverShow = false

        },
        onShow() {
            // This is called just before the popover is shown
            // Reset our popover form variables
            this.setManagerCurrent({
                data: this.configParams
            });
        },
        onShown() {
            // Called just after the popover has been shown
            // Transfer focus to the first input

        },
        onHidden() {

            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            };
            this.model_id = null;

        },


        initCurrentComponent: function () {

            this.initGridManager(this);
        },

        _deleteCurrent: function (rowManager) {
            var dataSend = {
                "TemplateConfigMailingByEmails": {
                    id: rowManager.id,
                    type: rowManager.type,
                    email: rowManager.email,
                    entity_id: this.business_id,
                    "template_information_id": this.model_id,
                    "business_id": this.business_id,

                }
            };
            var vCurrent = this;
            ajaxRequest($("#action-template-config-mailing-by-emails-deleteFrontend").val(), {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: vCurrent.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {
                        $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                        vCurrent.popoverShow = false;
                    }
                }
            });

        },
        _editCurrent: function (rowManager) {
            this.model.attributes = rowManager;
            this.$refs.refPopoverTemplateConfigMailingByEmails.$emit('open');
        },
        getViewEmpty: function () {
            var totalRows = this.dataTemplateConfigMailingByEmails.length;
            var result = totalRows == 0 ? true : false;
            return result;
        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _saveModel: function () {
            var dataSendResult = {
                "TemplateConfigMailingByEmails": {
                    id: this.model.attributes.id,
                    email: this.model.attributes.email,
                    type: this.model.attributes.type,
                    entity_id: this.business_id,
                    "template_information_id": this.model_id,
                    "business_id": this.business_id,

                }
            };
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
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent.popoverShow = false;
                        }
                    }
                });
            }
        },
        /*GRID*/
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
        _managerRowGrid: function (params) {
            var rowManager = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                this._editCurrent(rowManager);

            } else if (params.managerType == "deleteEntity") {
                this._deleteCurrent(rowManager);

            }
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
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: elementSelect,

            });
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {template_information_id: this.model_id};
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";
                    var type = row.type;
                    var typeDescription = '';
                    if (type == 0) {
                        typeDescription = 'Pagina Contáctanos';
                    } else if (type == 1) {
                        typeDescription = 'Pagina Servicios';
                    } else if (type == 2) {
                        typeDescription = 'Pagina Quienes Somos';
                    } else if (type == 3) {
                        typeDescription = 'Seccion Footer';
                    }
                    else if (type == 4) {
                        typeDescription = 'Checkout Tienda Virtual';
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.email.label + ":</span><span class='content-description__value'>" + row.email + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type.label + ":</span><span class='content-description__value'>" + typeDescription + "</span>",
                        "</div>",

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
                vmCurrent._gridManager(gridInit);
            });
        },
    }
})
;




