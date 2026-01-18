<script id="register-form-responsible">

    var registerFormComponent = null;
    Vue.component('register-form-responsible-component', {
        components: {},
        template: '#register-form-responsible-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
                    });

                },
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
            this.initCurrentComponent();

        },
        beforeDestroy: function () {

        },
        computed: {},
        validations: function () {
            var attributes = null;

            attributes = {
                id: {},
                customer_data_id: {required},
                role: {required},
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
                    url: $('#action-management-responsibles-save').val(),
                    loadingMessage: 'Guardando...',
                    errorMessage: 'Error al guardar el ' + this.processName,
                    successMessage: 'La tarjeta de registro se guardo correctamente.',
                    nameModel: "Lodging"
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
                componentName: "register-form-responsible",
                configModelEntity: {
                    "buttonsManagements": [
                        {
                            "title": "Eliminar Responsable",
                            "data-placement": "top",
                            "i-class": "fa fa-pencil",
                            "managerType": "managementResponsibleDelete",
                            "isUrl": false,

                        },

                    ]
                },
                gridConfig: {
                    selectorCurrent: "#grid-registers-responsible-grid",
                    url: $("#action-management-responsibles-admin").val()
                },
            };

            return dataManager;
        },
        methods: {
            ...$methodsFormValid,
            getLabelForm: viewGetLabelForm,
            getNameAttribute: getNameAttribute,
            getStructureForm: function () {
                var result = {
                    "role": {
                        "id": "role",
                        "name": "role",
                        "label": "Rol",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": "CAPITAN", "text": "Capitan"}, {
                            "value": "OPERADOR",
                            "text": "Operador"
                        }, {"value": "RESPONSABLE", "text": "Responsable"}]
                    },
                    customer_data_id: {
                        id: "customer_data_id",
                        name: "customer_data_id",
                        label: "Responsable",
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
                    result = {
                        id: null,
                        customer_data_id: null,
                        role: 'RESPONSABLE',
                    };
                } else {
                    result = {
                        id: null,
                        customer_data_id: null,
                        role: 'RESPONSABLE',
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
                    MaritimeVesselResponsibles: {
                        maritime_vessel_id: this.managerCurrentParamsParent.maritime_vessel_id,
                        customer_id: this.$v.model.attributes.customer_data_id.$model.id,
                        role: this.$v.model.attributes.role.$model,
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
                    'componentName': this.componentName
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
                this.$v.$reset();
                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };
                this.model.attributes.id = null;

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
            _businessCustomer: function (params) {
                var el = params.objSelector;
                var nameKey = "customer_data_id";
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
                    placeholder: "Seleccione Responsable",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-listS2CustomerResponsibles").val(),
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
            _resetComponent: function () {
                this._emitToParent({
                    type: 'resetComponent',
                    'componentName': this.componentName,
                    allowReload: this.allowReload
                });
            },
            _emitToParent: function (params) {
                this.$root.$emit('app-management', params);
            },


            //GRID

            initCurrentComponent: function () {

                this.initGridManager(this);
            },

            initGridManager: function (vmCurrent) {
                var gridName = this.gridConfig.selectorCurrent;
                var urlCurrent = this.gridConfig.url;
                var business_id = -1;
                var maritime_vessel_id = this.params.data.maritime_vessel_id;
                var paramsFilters = {
                    maritime_vessel_id: maritime_vessel_id
                };
                console.log(paramsFilters)
                let gridInit = $(gridName);
                var optionsRole = {
                    "CAPITAN": "Capitan",
                    "OPERADOR": "Operador",
                    "RESPONSABLE": "Responsable",

                };
                gridInit.bootgrid({
                    ajaxSettings: {
                        method: "POST"
                    },
                    ajax: true,
                    post: function () {
                        return {
                            grid_id: gridName,
                            filters: paramsFilters
                        };
                    },
                    url: urlCurrent,
                    labels: $labelsGridConfigDefault,
                    css: getCSSCurrentBootGrid(),
                    formatters: {
                        'description': function (column, row) {

                            var data = row;
                            console.log(optionsRole,data.role)
                            var result = [
                                "<div class='content-management-rows'>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Rol :</span><span class='content-description__value'>" + (optionsRole[data.role]) + "</span>",
                                "   </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Responsable :</span><span class='content-description__value'>" + (data.owner_document+":"+data.owner_name+"")+ " </span>",
                                "   </div>",
                                "</div>",


                            ];

                            return result.join("");

                        }

                    }
                }).on("loaded.rs.jquery.bootgrid", function () {
                    vmCurrent._resetManagerGrid();
                    vmCurrent._gridManager(gridInit);
                });

            },
            _gridManager: _gridManager,
            _managerRowGrid: function (params) {
                var $scope = this;
                var rowCurrent = params.row;
                var rowId = params.id;
                if (params.managerType == "managementResponsibleDelete") {


                }

            },
            _destroyTooltip: _destroyTooltip,
            _resetManagerGrid: _resetManagerGrid,
            getMenuConfig: function (params) {
                var result = [];
                $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                    var setPush = {
                        title: value["title"],
                        isUrl: value["isUrl"],
                        url: value["url"],
                        "data-placement": value["data-placement"],
                        icon: value["i-class"],
                        data: value, rowId: params.rowId,
                        managerType: value["managerType"],
                        params: params
                    }
                    result.push(setPush);
                });
                return result;
            },
        }
    })

</script>

