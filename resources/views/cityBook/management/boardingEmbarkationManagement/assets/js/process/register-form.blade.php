<script>

    var registerFormComponent = null;
    Vue.component('register-form-component', {
        components: {},
        template: '#register-form-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
                    });

                },
            },
            initS2Manager: {
                inserted: function (el, binding, vnode) {
                    var paramsInput = binding.value || {};
                    var ctx = vnode.context;

                    // espera a que el DOM esté estable
                    ctx.$nextTick(function () {
                        // evita doble init si el nodo se reusa
                        var $el = $(el);
                        if ($el.hasClass("select2-hidden-accessible")) {
                            $el.select2("destroy");
                        }

                        if (typeof paramsInput._initS2Manager === "function") {
                            paramsInput._initS2Manager({
                                objSelector: el,
                                rowId: paramsInput.rowId
                            });
                        } else {
                            console.warn("initS2Manager: _initS2Manager no es función", paramsInput);
                        }
                    });
                },

                unbind: function (el) {
                    var $el = $(el);
                    if ($el.hasClass("select2-hidden-accessible")) {
                        $el.select2("destroy");
                    }
                }
            }
        },
        props: {
            params: {
                type: Object,
            }
        },
        created: function () {
            var vmCurrent = this;
            this.$root.$on("_pointsSales", function (emitValue) {
                vmCurrent._managerTypes(emitValue);
            });

            registerFormComponent = this;
        },
        beforeMount: function () {

            this.managerCurrentParamsParent = this.params.data;
        },
        mounted: function () {
            componentThisEventsTrailsProject = this;
            this.managerCurrentParamsParent = this.params.data;

        },
        beforeDestroy: function () {

        },
        computed: {},
        validations: function () {
            var attributes = null;

            attributes = {
                id: {},
                passenger_capacity: {required},
                state: {required},
                draft: {required},
                beam: {required},
                length: {required},
                owner_customer_data_id: {required},
                name: {required},
                maritime_vessel_type_data_id: {required},
                business_data_id: {required},
                technical_info_type: {required},


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
                formConfig: {
                    nameSelector: "#business-by-lodging-form",
                    url: $('#action-management-save').val(),
                    loadingMessage: 'Guardando...',
                    errorMessage: 'Error al guardar el ' + this.processName,
                    successMessage: 'La tarjeta de registro se guardo correctamente.',
                    nameModel: "Lodging"
                },
                labelsConfig: {
                    "guest": "Huespedes Ingreso",
                    button: {
                        "guest": "Crear Huesped",
                        cancel: "Cancelar",
                        viewRoomsState: "Habitaciones",
                    },
                    manager: {
                        guest: "Huesped #  "
                    },
                    process: {
                        information: "Información Hospedaje",
                        guests: "Huespedes Ingreso",
                        address: "Dirección",
                        payment: "Pago Gestión",

                    }
                },
                lblBtnSave: "Guardar",
                lblBtnClose: "Cerrar",
                model: {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm(),
                },
                managerCurrentParamsParent: null,
                clockIntervalId: null,

                showManager: true,
                managerType: null,
                rowCurrent: null,
                allowReload: false,

            };

            return dataManager;
        },
        watch: {
            'model.attributes.people': {
                deep: true,
                handler: function (people) {
                    console.log("people", people);
                    var vm = this;
                    people = people || [];

                }
            }
        },

        methods: {
            ...$methodsFormValid,
            getLabelForm: viewGetLabelForm,
            getNameAttribute: getNameAttribute,
            getStructureForm: function () {
                var result = {
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
                    "technical_info_type": {
                        "id": "technical_info_type",
                        "name": "technical_info_type",
                        "label": "Tipo Tecnico",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": "MEMORIA_TECNICA", "text": "Memora Tecnica"}, {
                            "value": "N_A",
                            "text": "N/A"
                        }]
                    },

                    maritime_vessel_type_data_id: {
                        id: "maritime_vessel_type_data_id",
                        name: "maritime_vessel_type_data_id",
                        label: "Tipo de Embarque",
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
                        label: "Nombre de la Embarcación",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    owner_customer_data_id: {
                        id: "owner_customer_data_id",
                        name: "owner_customer_data_id",
                        label: "Propietario",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    length: {
                        id: "length",
                        name: "length",
                        label: "Eslora(mt)",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    beam: {
                        id: "beam",
                        name: "beam",
                        label: "Manga(mt)",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    draft: {
                        id: "draft",
                        name: "draft",
                        label: "Puntal(cm)",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    passenger_capacity: {
                        id: "passenger_capacity",
                        name: "passenger_capacity",
                        label: "Cantidad de Pasajeros",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    business_data_id: {
                        id: "business_data_id",
                        name: "business_data_id",
                        label: "Muelle",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },

                };

                return result;
            },

            getAttributesForm: function () {
                var result = null;
                if (this.params.data) {
                    result = {...this.params.data};
                } else {
                    result = {
                        id: null,
                        passenger_capacity: null,
                        draft: null,
                        beam: null,
                        length: null,
                        owner_customer_data_id: null,
                        name: null,
                        state: 'ACTIVE',
                        maritime_vessel_type_data_id: null,
                        business_data_id: null,
                        technical_info_type: 'N_A',


                    };
                }


                return result;
            },
            validateForm: function () {
                var currentAllow = this.getValidateForm();
                return currentAllow.success;
            },

            getValidateForm: function () {
                var result = getValidateForm({"model": this.$v.model});
                return result;
            },
            getValuesSave: function () {

                var result = {
                    MaritimeVessels: {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        business_id: this.$v.model.attributes.business_data_id.$model.id,
                        maritime_vessel_type_id: this.$v.model.attributes.maritime_vessel_type_data_id.$model.id,
                        name: this.$v.model.attributes.name.$model,
                        length: this.$v.model.attributes.length.$model,
                        beam: this.$v.model.attributes.beam.$model,
                        draft: this.$v.model.attributes.draft.$model,
                        passenger_capacity: this.$v.model.attributes.passenger_capacity.$model,
                        owner_customer_id: this.$v.model.attributes.owner_customer_data_id.$model.id,
                        technical_info_type: this.$v.model.attributes.technical_info_type.$model,
                        state: this.$v.model.attributes.state.$model,
                    },

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
                    ajaxRequestManager(this.formConfig.url, {
                        type: 'POST',
                        data: dataSend,
                        blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                        loading_message: vCurrent.formConfig.loadingMessage,
                        error_message: vCurrent.formConfig.errorMessage,
                        success_message: vCurrent.formConfig.successMessage,
                        success_callback: function (response) {
                            if (response.success) {
                                vCurrent.resetForm();
                            }
                        }
                    });
                }
            },
            onReturnMain: function () {
                this._emitToParent({
                    type: 'onReturnMain',
                    'componentName': 'register-form'
                });
            },
            _setValueForm: async function (name, value) {
                // ✅ Fields fuera de people
                this.model.attributes[name] = value;
                this.$v["model"]["attributes"][name].$model = value;
                this.$v["model"]["attributes"][name].$touch();
            },
            getNameAttributePeople: function (index, name) {
                var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
                return result;
            },
            getClassErrorForm: getClassErrorForm,
            getViewErrorForm: function (nameElement, objValidate) {
                let resultValidate = getClassErrorForm(nameElement, objValidate);
                let result = resultValidate["form-group--error"];
                return result;
            },

            resetForm: function () {
                if (this.managerCurrentParamsParent) {

                } else {
                    this.$v.$reset();
                    this.model = {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm()
                    };
                    this.model.attributes.id = null;
                }


            },
            _submitForm: function (e) {
                console.log(e);
            },
            getDataByKey: function (params) {
                let result = null;
                var nameKey = params["nameKey"];
                if (!this.params.data) {
                    return result;

                }
                result = this.params.data[nameKey];

                return result;
            },
            _vesselTypes: function (params) {
                var nameKey = "maritime_vessel_type_data_id";
                var el = params.objSelector;
                var dataSelect = this.getDataByKey({nameKey: nameKey});
                var valueCurrentRowId = null;
                if (dataSelect) {
                    valueCurrentRowId = dataSelect.id;
                    this._setValueForm(nameKey, dataSelect);

                }
                var dataCurrent = [];
                var $el = $(el);
                destroyS2($el);
                if (valueCurrentRowId) {
                    dataCurrent = dataSelect;
                    var textCurrent = dataCurrent.text;
                    var idCurrent = dataCurrent.id;
                    var option = new Option(textCurrent, idCurrent, true, true);
                    $(el).append(option).trigger('change');
                }
                var _this = this;
                var elementInit = $(el).select2({
                    allow: true,
                    placeholder: "Seleccione Tipo de Embarcacion",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-vesselTypesList").val(),
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
                    allowClear: false,
                    multiple: false,
                    width: '100%'
                });

                elementInit.on('select2:select', function (e) {
                    var data = e.params.data;
                    _this._setValueForm(nameKey, data);


                }).on("select2:unselecting", function (e) {
                    _this._setValueForm(nameKey, null);

                }).on("select2:open", function (e) {


                });
            },
            _businessCustomer: function (params) {
                var el = params.objSelector;
                var nameKey = "owner_customer_data_id";
                var dataSelect = this.getDataByKey({nameKey: nameKey});
                var valueCurrentRowId = null;
                if (dataSelect) {
                    valueCurrentRowId = dataSelect.id;
                    this._setValueForm(nameKey, dataSelect);

                }
                var dataCurrent = [];
                var $el = $(el);
                destroyS2($el);
                if (valueCurrentRowId) {
                    dataCurrent = dataSelect;
                    var textCurrent = dataCurrent.text;
                    var idCurrent = dataCurrent.id;
                    var option = new Option(textCurrent, idCurrent, true, true);
                    $(el).append(option).trigger('change');
                }
                var _this = this;
                var elementInit = $(el).select2({
                    allow: true,
                    placeholder: "Seleccione Propietario",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-listS2Customer").val(),
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
                    allowClear: false,
                    multiple: false,
                    width: '100%'
                });

                elementInit.on('select2:select', function (e) {
                    var data = e.params.data;
                    _this._setValueForm(nameKey, data);


                }).on("select2:unselecting", function (e) {
                    _this._setValueForm(nameKey, null);

                }).on("select2:open", function (e) {


                });
            },
            _businessManager: function (params) {
                var el = params.objSelector;
                var nameKey = "business_data_id";
                var dataSelect = this.getDataByKey({nameKey: nameKey});
                var valueCurrentRowId = null;
                if (dataSelect) {
                    valueCurrentRowId = dataSelect.id;
                    this._setValueForm(nameKey, dataSelect);

                }
                var dataCurrent = [];
                var $el = $(el);
                destroyS2($el);
                if (valueCurrentRowId) {
                    dataCurrent = dataSelect;
                    var textCurrent = dataCurrent.text;
                    var idCurrent = dataCurrent.id;
                    var option = new Option(textCurrent, idCurrent, true, true);
                    $(el).append(option).trigger('change');
                }
                var _this = this;
                var elementInit = $(el).select2({
                    allow: true,
                    placeholder: "Seleccione Muelle",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-business-by-maritime").val(),
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
                    allowClear: false,
                    multiple: false,
                    width: '100%'
                });

                elementInit.on('select2:select', function (e) {
                    var data = e.params.data;
                    _this._setValueForm(nameKey, data);


                }).on("select2:unselecting", function (e) {
                    _this._setValueForm(nameKey, null);

                }).on("select2:open", function (e) {


                });
            },
            //MODAL
            _showModal: function () {
                this.resetForm();

            },
            _hideModal: function () {
                this._resetComponent();

            },

            _resetComponent: function () {
                this._emitToParent({
                    type: 'resetComponent',
                    'componentName': 'register-form',
                    allowReload: this.allowReload
                });
            },
            _emitToParent: function (params) {
                this.$root.$emit('app-management', params);
            },
            _saveModal: function (bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler
                this.handleSubmit();
            },
            _cancel: function () {
                this.$refs.modalRegisterForm.hide();

            },
            getDataManagerDocuments: function (data) {
                console.log(data);
                var result = "<span>No existe informacion</span>";

                if (data.$model && data.$model.documents) {
                    var setData = [];
                    setData.push("<div class='manager-content-documents'>");
                    $.each(data.$model.documents, function (index, value) {
                        var setPush = '<span class="badge badge--size-large badge--bee-points">' + value.name + '</span>';
                        setData.push(setPush);

                    });
                    setData.push("</div>");
                    result = setData.join("");
                }
                return result;
            }
        }
    })

</script>
