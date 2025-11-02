var componentThisTemplatePayments;
Vue.component('template-payments-component', {
    template: '#template-payments-template',
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
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.model_id = this.configParams.model_id;
    },
    mounted: function () {
        componentThisTemplatePayments = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "type_payment": {required},
            "status": {required},
            "type_manager": {},
            "user": {required, maxLength: Validators.maxLength(150)},
            "password": {required, maxLength: Validators.maxLength(150)},
            "test_id": {},
            "test_secret": {},
            "live_id": {},
            "live_secret": {},
            "msj_to_customer": {},
            "manager_type_modal": {}
        };
        if (this.model.attributes.type_payment == 2) {//deposit

            this.model.structure['user']['label'] = 'Nombre Banco';
            this.model.structure['password']['label'] = '# Cuenta Bancaria';
            this.labelUser = 'Nombre Banco *';
            this.labelPassword = 'Cuenta Bancaria *';
            attributes['test_id'] = {};
            attributes['test_secret'] = {};
            attributes['live_id'] = {};
            attributes['live_secret'] = {};

        } else if (this.model.attributes.type_payment == 0) {//paypal
            this.labelUser = 'Usuario *';
            this.labelPassword = 'Contraseña *';

        } else if (this.model.attributes.type_payment == 1) {//CREDIT CARDS
            this.labelUser = 'Usuario *';
            this.labelPassword = 'Contraseña *';
            attributes['live_id'] = {required};
            attributes['live_secret'] = {required};
            attributes['user'] = {};
            attributes['password'] = {};
            attributes['test_id'] = {required};
            attributes['test_secret'] = {required};
        } else if (this.model.attributes.type_payment == 3) {//CREDIT CARDS
            this.labelUser = 'Usuario *';
            this.labelPassword = 'Contraseña *';
            attributes['live_id'] = {required};
            attributes['live_secret'] = {required};
            attributes['user'] = {};
            attributes['password'] = {};
            attributes['test_id'] = {required};
            attributes['test_secret'] = {required};
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
            model_id: null,
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
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-template-payments',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#template-payments-form",
                url: $('#action-template-payments-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el TemplatePayments.',
                successMessage: 'El TemplatePayments se guardo correctamente.',
                nameModel: "TemplatePayments"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#template-payments-grid",
                url: $("#action-template-payments-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            labelUser: 'Usuario',
            labelPassword: 'Contraseña',

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
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: vmCurrent,
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
                this.model.attributes.type_payment = rowCurrent.type_payment;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.type_manager = rowCurrent.type_manager == 1 ? true : false;
                this.model.attributes.user = rowCurrent.user;
                this.model.attributes.password = rowCurrent.password;
                this.model.attributes.test_id = rowCurrent.test_id;
                this.model.attributes.test_secret = rowCurrent.test_secret;
                this.model.attributes.live_id = rowCurrent.live_id;
                this.model.attributes.live_secret = rowCurrent.live_secret;
                this.model.attributes.production_allow = rowCurrent.production_allow == 1 ? true : false;
                this.model.attributes.msj_to_customer = rowCurrent.msj_to_customer;
                this.model.attributes.manager_type_modal = rowCurrent.manager_type_modal == 1 ? true : false;

                if (rowCurrent.type_payment == 2) {
                    this.model.attributes.test_id = 'Test Bank';
                    this.model.attributes.type_manager = true;
                    this.model.attributes.manager_type_modal = true;
                    this.model.attributes.test_secret = 'Test Secrete Bank';
                    this.model.attributes.live_id = 'Live  Bank';
                    this.model.attributes.live_secret = 'Live  Secret Bank';
                }
                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                template_information_id: this.model_id
            };
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";


                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var type_paymentString = '';
                    if (row.type_payment == 0) {
                        type_paymentString = "PayPal";
                    } else if (row.type_payment == 2) {
                        type_paymentString = "Deposito Bancario";
                    } else if (row.type_payment == 1) {
                        type_paymentString = "Tarjetas de Credito";
                    } else if (row.type_payment == 3) {
                        type_paymentString = "PayPhone";
                    }
                    var type_managerString = 'Modo Produccion';
                    if (row.type_manager == 0) {
                        type_managerString = "Modo Test";
                    }

                    var descriptionPayment = row.type_payment == 2 ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Banco:</span><span class='content-description__value'>" + row.user + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'># Cuenta:</span><span class='content-description__value'>" + row.password + "</span>",
                        "</div>",

                    ] : (row.type_payment == 1 ? [

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_manager.label + ":</span><span class='content-description__value'>" + type_managerString + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>CLIENT :</span><span class='content-description__value'>" + row.live_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>CLIENT KEY:</span><span class='content-description__value'>" + row.live_secret + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>SERVER:</span><span class='content-description__value'>" + row.test_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>SERVER KEY:</span><span class='content-description__value'>" + row.test_secret + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.manager_type_modal.label + ":</span><span class='content-description__value'>" + (row.manager_type_modal == 1 ? 'Modal' : 'Sin Modal') + "</span>",
                        "</div>"
                    ] : [

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_manager.label + ":</span><span class='content-description__value'>" + type_managerString + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.user.label + ":</span><span class='content-description__value'>" + row.user + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.password.label + ":</span><span class='content-description__value'>" + row.password + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.test_id.label + ":</span><span class='content-description__value'>" + row.test_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.test_secret.label + ":</span><span class='content-description__value'>" + row.test_secret + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.live_id.label + ":</span><span class='content-description__value'>" + row.live_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.live_secret.label + ":</span><span class='content-description__value'>" + row.live_secret + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.manager_type_modal.label + ":</span><span class='content-description__value'>" + (row.manager_type_modal == 1 ? 'Modal' : 'Sin Modal') + "</span>",
                        "</div>"
                    ]);
                    descriptionPayment = descriptionPayment.join('');
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_payment.label + ":</span><span class='content-description__value'>" + type_paymentString + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",
                        descriptionPayment

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
                type_payment: {
                    id: "type_payment",
                    name: "type_payment",
                    label: "Tipo de Pago",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": 0, "text": "PayPal"}, {"value": 2, "text": "Deposito Bancario"}, {
                        "value": 1,
                        "text": "Paymentes"
                    },{"value": 3, "text": "Payphone"}]

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
                msj_to_customer: {
                    id: "msj_to_customer",
                    name: "msj_to_customer",
                    label: "Mensaje al Usuario",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                type_manager: {
                    id: "type_manager",
                    name: "type_manager",
                    label: "Activar Producción",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                manager_type_modal: {
                    id: "manager_type_modal",
                    name: "manager_type_modal",
                    label: "Modal Proceso",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                user: {
                    id: "user",
                    name: "user",
                    label: "Usuario",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                password: {
                    id: "password",
                    name: "password",
                    label: "Contraseña",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                test_id: {
                    id: "test_id",
                    name: "test_id",
                    label: "Codigo Id Test",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                test_secret: {
                    id: "test_secret",
                    name: "test_secret",
                    label: "Codigo Secreto Test",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                live_id: {
                    id: "live_id",
                    name: "live_id",
                    label: "Codigo Id Producción",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                live_secret: {
                    id: "live_secret",
                    name: "live_secret",
                    label: "Codigo Secreto Producción",
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
                "type_payment": 0,
                "status": "ACTIVE",
                "type_manager": false,
                "user": null,
                "password": null,
                "test_id": null,
                "test_secret": null,
                "live_id": null,
                "live_secret": null,
                "manager_type_modal": false
            };
            return result;
        },
        getLabelsKeysApi: function (field) {
            var result = 'none';
            if (this.model.attributes.type_payment == 0) {//paypal
                result = this.getLabelForm(field);
            } else if (this.model.attributes.type_payment == 1) {//credit paymentez
                if (field == 'live_id') {
                    result = 'CLIENT ' + (this.model.structure[field].required.allow ? "*" : "");
                } else if (field == 'live_secret') {
                    result = 'CLIENT KEY ' + (this.model.structure[field].required.allow ? "*" : "");

                } else if (field == 'test_id') {
                    result = 'SERVER ' + (this.model.structure[field].required.allow ? "*" : "");
                } else if (field == 'test_secret') {
                    result = 'SERVER KEY ' + (this.model.structure[field].required.allow ? "*" : "");
                }

            } else if (this.model.attributes.type_payment == 2) {//bank

            }else if (this.model.attributes.type_payment == 3) {//credit paymentez
                if (field == 'live_id') {
                    result = 'CLIENT ' + (this.model.structure[field].required.allow ? "*" : "");
                } else if (field == 'live_secret') {
                    result = 'CLIENT KEY ' + (this.model.structure[field].required.allow ? "*" : "");

                } else if (field == 'test_id') {
                    result = 'SERVER ' + (this.model.structure[field].required.allow ? "*" : "");
                } else if (field == 'test_secret') {
                    result = 'SERVER KEY ' + (this.model.structure[field].required.allow ? "*" : "");
                }

            }
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
//Manager Model

        getValuesSave: function () {

            var user = (this.$v.model.attributes.type_payment.$model == 2 || this.$v.model.attributes.type_payment.$model == 0) ? this.$v.model.attributes.user.$model : 'paymentez-user';
            var password = (this.$v.model.attributes.type_payment.$model == 2 || this.$v.model.attributes.type_payment.$model == 0) ? this.$v.model.attributes.password.$model : 'paymentez-password';

            var result = {
                TemplatePayments:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "type_payment": this.$v.model.attributes.type_payment.$model,
                        "status": this.$v.model.attributes.status.$model,
                        "template_information_id": this.model_id,
                        "type_manager": this.$v.model.attributes.type_manager.$model == null ? 0 : (this.$v.model.attributes.type_manager.$model ? 1 : 0),
                        "user": user,
                        "password": password,
                        "test_id": this.$v.model.attributes.test_id.$model,
                        "test_secret": this.$v.model.attributes.test_secret.$model,
                        "live_id": this.$v.model.attributes.live_id.$model,
                        "live_secret": this.$v.model.attributes.live_secret.$model,
                        "msj_to_customer": this.$v.model.attributes.msj_to_customer.$model ? this.$v.model.attributes.msj_to_customer.$model : '',
                        "manager_type_modal": this.$v.model.attributes.manager_type_modal.$model == null ? 0 : (this.$v.model.attributes.manager_type_modal.$model ? 1 : 0),


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

        getValidateForm: getValidateForm,
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




