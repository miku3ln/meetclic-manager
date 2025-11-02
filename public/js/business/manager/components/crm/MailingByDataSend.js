var componentThisMailingByDataSend;
Vue.component('mailing-by-data-send-component', {
    template: '#mailing-by-data-send-template',
    directives: {
        initS2Template: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.method({
                    objSelector: el
                });
            }
        },

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
        this.business_id = $businessManager.id;
    },
    mounted: function () {
        componentThisMailingByDataSend = this;
        this.initCurrentComponent();
        this.initGridManager(this);
    },
    validations: function () {
        var attributes = {

            //CUSTOMER
            customers_id: {},
            template_id: {required},
            all_customers: {required},

        };
        if (this.model.attributes.all_customers == 0) {
            attributes['customers_id'] = {required};
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
                "title": "Gestion de Envio de Correos/Whatsapp. ",
                process: {
                    "payment": "Pagos"
                },
                buttons: {
                    save: "Enviar Correos/Whatsapp",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#modal-mailing-by-data-send',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#mailing-by-data-send-form",
                url: $('#action-mailing-by-data-send-saveDataSend').val(),
                loadingMessage: 'Enviando...',
                errorMessage: 'Error al enviar los correos.',
                successMessage: 'Los correso se enviaron correctamente.',
                nameModel: "MailingByDataSend"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#mailing-by-data-send-grid",
                url: $("#action-customer-getAdminEmails").val(),
                rowsDataManager: {
                    rowsDataDetailsAll: [],
                    rowsKeysData: [],
                    rowsData: [],
                },
                optionsCurrentGrid: {
                    card: {
                        'type': 'warning',
                        title: 'Personas Agregadas',
                        data: [
                            {
                                title: 'Total',
                                type: 'warning',
                                'icon-class': 'fa fa-caret-down',
                                'value': '0',

                            }
                        ]
                    }
                }
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerId: null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initDataModal();

            this.$refs.refMailingByDataSendModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalMailingByDataSend'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refMailingByDataSendModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            var managerId = rowCurrent.id;
            this.managerId = managerId;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refMailingByDataSendModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN

//MANAGER PROCESS
        /*---------GRID--------*/
        resultsGrid: function (rowsKeysData) {
            var valueTotal = rowsKeysData.length;
            var card = {
                'type': valueTotal == 0 ? 'warning' : 'success',
                title: 'Productos Agregados',
                data: [
                    {
                        title: 'Total',
                        type: valueTotal == 0 ? 'warning' : 'success',
                        'icon-class': valueTotal == 0 ? 'fa fa-caret-down' : 'fa fa-caret-up',
                        'value': valueTotal,

                    }
                ],
                allow: valueTotal > 0

            };
            return card;
        },
        _managerCheckGrid: _managerCheckGrid,
        _eventCheckList: function (rowsManager) {

            var rowsKeysData = rowsManager.rowsKeysData;
            var rowsDataDetailsAll = rowsManager['rowsDataDetailsAll'];
            this.gridConfig.rowsDataManager['rowsKeysData'] = rowsKeysData;
            this.gridConfig.rowsDataManager['rowsDataDetailsAll'] = rowsDataDetailsAll;
            this.gridConfig.rowsDataManager['rowsData'] = rowsManager['rowsData'];
            var resultCard = this.resultsGrid(rowsKeysData);
            this.gridConfig.optionsCurrentGrid['card'] = resultCard;
            console.log(this.gridConfig.rowsDataManager['rowsKeysData']);

            if (resultCard.allow) {
                this.model.attributes.customers_id = true;
                this._setValueForm('customers_id', true);

            } else {
                this.model.attributes.customers_id = null;
                this._setValueForm('customers_id', null);

            }


        },
        _gridManager: function (params) {
            this._managerCheckGrid(params);

        },


        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var selectorCurrent = this.gridConfig.selectorCurrent;

            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                product_id: this.managerId
            };
            var structure = vmCurrent.model.structure;
            var formatters = {
                'check-list-manager': function (column, row) {
                    var key_id = row.id;
                    return '<input class="check-list-manager"  id="checkbox-' + key_id + '" name="select" type="checkbox" class="select-box" value="' + key_id + '">';
                },
                'description': function (column, row) {

                    var informationAddressMainPersonal=row.information_mail_value?[            "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Correo Personal:</span><span class='content-description__value'>" + (row.information_mail_value) + "</span>",
                        "</div>"]:[];
                    informationAddressMainPersonal=informationAddressMainPersonal.join('');
                    var informationPhoneMainPersonal=row.information_phone_value?[            "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Whatsapp #:</span><span class='content-description__value'>" + (row.information_phone_value) + "</span>",
                        "</div>"]:[];
                    informationPhoneMainPersonal=informationPhoneMainPersonal.join('');
                    var addressInformation = row.information_address_id ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'></span><span class='content-description__value center'> Dirección</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + row.information_address_type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Calle Pincipal:</span><span class='content-description__value'>" + row.street_one + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Calle Secundaria:</span><span class='content-description__value'>" + row.street_two + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Referencia:</span><span class='content-description__value'>" + row.reference + "</span>",
                        "</div>",
                    ] : [];

                    addressInformation = addressInformation.join('');

                    var description = (row.name !== "null" && row.name) ? [

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Nombres:</span><span class='content-description__value'>" + (row.name) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Apellidos:</span><span class='content-description__value'>" + (row.last_name) + "</span>",
                        "</div>",
                        informationAddressMainPersonal,
                        informationPhoneMainPersonal,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Tipo de Identificación:</span><span class='content-description__value'>" + (row.people_type_identification) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Identificación:</span><span class='content-description__value'>" + (row.identification_document) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Tipo de Ruc:</span><span class='content-description__value'>" + (row.ruc_type) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Nacionalidad :</span><span class='content-description__value'>" + (row.people_nationality) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Profesión :</span><span class='content-description__value'>" + (row.people_profession) + "</span>",
                        "</div>",

                    ] : [];
                    description = description.join("");
                    var result = [
                        "<div class='content-description'>",
                        description,
                        addressInformation,
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

            var params = {
                selectorInit: selectorCurrent,
                elementInit: gridInit,
                rowsDataManager: vmCurrent.gridConfig.rowsDataManager,
                managerCustomerFunction: vmCurrent._eventCheckList
            };
            gridInit.on("loaded.rs.jquery.bootgrid", function () {

                vmCurrent._gridManager(params);
            });
        },
        /*Manager FORMS-AND VIEWS*/

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

                identification_document: {
                    id: "identification_document",
                    name: "identification_document",
                    label: "# Identificación",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                people_type_identification_id_data: {
                    id: "people_type_identification_id",
                    name: "people_type_identification_id",
                    label: "Tipo de Identificación",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                business_name: {
                    id: "business_name",
                    name: "business_name",
                    label: "Razón Social",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                business_reason: {
                    id: "business_reason",
                    name: "business_reason",
                    label: "Razón Comercial",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                ruc_type_id_data: {
                    id: "ruc_type_id",
                    name: "ruc_type_id",
                    label: "Tipo de Ruc",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                people_nationality_id_data: {
                    id: "people_nationality_id",
                    name: "people_nationality_id",
                    label: "Nacionalidad",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                people_profession_id_data: {
                    id: "people_profession_id",
                    name: "people_profession_id",
                    label: "Profesión",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                last_name: {
                    id: "last_name",
                    name: "last_name",
                    label: "Apellidos",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                name: {
                    id: "name",
                    name: "name",
                    label: "Nombres",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                birthdate: {
                    id: "birthdate",
                    name: "birthdate",
                    label: "Fecha Nacimiento",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                age: {
                    id: "age",
                    name: "age",
                    label: "Edad",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                gender_data: {
                    id: "gender",
                    name: "gender",
                    label: "Género",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                /*  Address Information*/
                street_one: {
                    id: "street_one",
                    name: "street_one",
                    label: "Calle Principal",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                street_two: {
                    id: "street_two",
                    name: "street_two",
                    label: "Calle Secundaria",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                reference: {
                    id: "reference",
                    name: "reference",
                    label: "Referencia",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                has_location: {
                    id: "has_location",
                    name: "has_location",
                    label: "has location",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_map: {
                    id: "options_map",
                    name: "options_map",
                    label: "options map",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                customers_id: {
                    id: "customers_id",
                    name: "customers_id",
                    label: "Clientes",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                template_id: {
                    id: "template_id",
                    name: "template_id",
                    label: "Plantilla",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                all_customers: {
                    id: "all_customers",
                    name: "all_customers",
                    label: "Enviar a",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    "options": [{"value": 0, "text": "Seleccionados"}, {"value": 1, "text": "Todos"}]

                },

            };
            return result;

        },
        getAttributesForm: function () {
            var result = {
                //PEOPLE
                id: null,
                last_name: null,
                name: null,
                birthdate: null,
                business_id: this.business_id,
                gender_data: 0,
                //CUSTOMER
                identification_document: null,
                people_type_identification_id_data: null,
                business_name: null,
                business_reason: null,
                ruc_type_id_data: null,
                //CUSTOMER INFORMATION
                customer_id: null,
                people_nationality_id_data: 71,
                people_profession_id_data: 1,
                customer_by_information: null,
                people_id_data: null,
                "street_one": null,
                "street_two": null,
                "reference": null,
                "has_location": true,
                "options_map": null,
                "information_address_location_current": null,


                customers_id: null,
                template_id: null,
                all_customers: 0,

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
//Manager Model

        getValuesSave: function () {
            var business = $modelDataManager['business'][0];
            var business_id = business['id'];
            var result = {
                    all_customers: this.model.attributes.all_customers==0?false:true,
                    template: this.model.attributes.template_id,
                    business_id: business_id

                }
            ;
            if (this.model.attributes.all_customers == 0) {
                var customers = this.gridConfig.rowsDataManager['rowsData'];
                result['customers'] = customers;
            }

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

                            vCurrent.resetForm();
                            vCurrent._hideModal();
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

        _managerS2Templates: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var elementS2 = $(el);
            var business = $modelDataManager['business'][0];
            var business_id = business['id'];
            var $scope = this;
            var elementInit = elementS2.select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-mailing-template-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        managerModalSelect2();
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: business_id
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
                width: '100%',
                tags: true,
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;

                $scope._setValueForm('template_id', data);


            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.template_id = null;
                $scope._setValueForm('template_id', null);
            });
        },

    }
})
;




