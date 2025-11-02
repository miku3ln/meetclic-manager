let initS2;
let configProcessModal = {//CPP-004
    'manager': UtilManagerCustomModel.getManagerData('human_resources_organizational_chart_area_by_manager'),
    'nameProcess': 'HumanResourcesOrganizationalChartAreaByManager',
    'component': null,
};
Vue.component('business-by-employee-profile-component', {

    template: '#business-by-employee-profile-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput.onInitSelect2({
                    objSelector: el, model: paramsInput.model

                });


            }
        }

    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {

    },
    beforeMount: function () {
        this.configParams = this.params;


    },
    mounted: function () {
        configProcessModal.component = this;
        this.initCurrentComponent();
        removeClassNotView();

    },
    validations: function () {


        let attributes = {
            id: {},
            type_manager: {},//
            human_resources_employee_profile_id_data: {required},//

            range: {},//
        };


        let result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;
    },
    data: function () {
        let dataManager = {
            /*  ----MANAGER ENTITY---*/
            labelsConfig: {
                "title": "Agregar Persona Responsable",
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            configParams: {},
            tabCurrentSelector: '#modal-business-by-employee-profile',
            processName: "Gestion de Personal Responsable.",
            formConfig: {
                nameSelector: "#" + configProcessModal.manager.modelProcess + "-form",
                url: $("#action-" + configProcessModal.manager.modelProcess + "-save").val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + configProcessModal.nameProcess + '.',
                successMessage: 'El ' + configProcessModal.nameProcess + ' se guardo correctamente.',
                nameModel: configProcessModal.manager.modelName
            },
            allowReset: false,
            createUpdate: false,
            managerInitAll: false,
            rowCurrent: {},
            manager_parent_id: null,
            businessId: null,
            manager_id: null
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        //EVENTS OF CHILDREN
        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refBusinessByEmployeeProfileModal.show();
        },
        setDataInit: function (rowCurrent) {
            this.rowCurrent = rowCurrent;
            this.manager_parent_id = rowCurrent.human_resources_organizational_chart_area_id;
            this.businessId = rowCurrent.businessId;
            this.createUpdate = !!rowCurrent.id;
            this.manager_id = this.createUpdate ? rowCurrent.id : -1;
            this.labelsConfig.title = this.labelsConfig.title + ' a ' + rowCurrent.human_resources_organizational_chart_areaName;

            if (this.createUpdate) {
                this.model.attributes['type_manager'] = rowCurrent['type_manager'];
                this.model.attributes['human_resources_employee_profile_id_data'] = {
                    id: rowCurrent.human_resources_employee_profile_id,
                    text: rowCurrent.fullName,
                };
                this.model.attributes['range'] = rowCurrent.range;
                this.labelsConfig.title = "Actualizar Responsable" + ' a ' + rowCurrent.human_resources_organizational_chart_areaName;
            }

            this.managerInitAll = true;
            let option = new Option(rowCurrent.fullName, rowCurrent.human_resources_employee_profile_id, true, true);
            $('#human_resources_employee_profile_id_data').append(option).trigger('change');
        },
        initDataModal: function () {
            let rowCurrent = this.configParams.data;
            this.setDataInit(rowCurrent);
        },
        //MANAGER PROCESS
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refBusinessByEmployeeProfileModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },
        /*FORM*/
        getViewErrorForm: function (objValidate) {
            let result = false;
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }

            return result;
        },
        _submitForm: function (e) {
            e.preventDefault();
        },
        getStructureForm: function () {
            let result = {

                type_manager: {
                    id: "type_manager",
                    name: "type_manager",
                    label: "Tipo",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                human_resources_employee_profile_id_data: {
                    id: "human_resources_employee_profile_id",
                    name: "human_resources_employee_profile_id",
                    label: "Empleado",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },


                range: {
                    id: "range",
                    name: "range",
                    label: "Rango",
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

            let result = {
                type_manager: 1,
                human_resources_employee_profile_id_data: null,
                range: 1,
            };

            return result;
        },
        getNameAttribute: function (name) {
            let result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value) {

            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();


        },
        getClassErrorForm: function (nameElement, objValidate) {
            let result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };
            return result;
        },
        getErrorHas: function (model, type) {
            let result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            let result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {

            let data = {

                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                type_manager: this.$v.model.attributes.type_manager.$model,
                human_resources_organizational_chart_area_id: this.manager_parent_id,
                human_resources_employee_profile_id: this.$v.model.attributes.human_resources_employee_profile_id_data.$model == null ? null : this.$v.model.attributes.human_resources_employee_profile_id_data.$model.id,
                range: this.$v.model.attributes.range.$model,

            };
            let result = {};
            result[configProcessModal.manager.modelName] = data;
            return result;

        },
        _saveModel: function () {
            let dataSendResult = this.getValuesSave();
            let dataSend = dataSendResult;
            let $scope = this;
            $scope.$v.$touch();
            let validateCurrent = this.validateForm();
            if (!validateCurrent) {
                $scope.submitStatus = 'error';

            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: $scope.formConfig.loadingMessage,
                    error_message: $scope.formConfig.errorMessage,
                    success_message: $scope.formConfig.successMessage,
                    success_callback: function (response) {
                        $scope.allowReset = true;
                        $scope._hideModal();
                    }
                });
            }
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            let currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
            this.labelsConfig.title = "Agregar Persona Responsable";
        },
        getValidateForm: getValidateForm,
        /*modal*/
        _showModal: function () {

            if (!this.allowReset && !this.createUpdate) {

                this.resetForm();
            }
        },
        _hideModal: function () {
            this.resetForm();
            $('#human_resources_employee_profile_id_data').empty().trigger("change");


            if (this.allowReset) {
                this.allowReset = false;
                this._emitToParent({type: "rebootGrid"});
            }

            this._emitToParent({
                type: "resetProcess",
                name: "configModalBusinessByEmployeeProfile",
            });
            this.$refs.refBusinessByEmployeeProfileModal.hide();
        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refBusinessByEmployeeProfileModal.hide();
            this.managerInitAll = false;

            if (this.allowReset) {

                this._emitToParent({type: "rebootGrid"});
            }
        },
        getDataSelect2Profile() {
            return this.businessId;
        },
        onInitEmployeeProfile: function (params) {
            console.log('entra');
            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {

                dataCurrent = [this.model.attributes.human_resources_employee_profile_id_data];
            }
            let _this = this;
            let businessId = this.businessId;
            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-employee-profile-getFullNameListDataAreaAll").val(),
                    type: "get",
                    dataType: 'json',

                    data: function (term, page) {

                        let paramsFilters = {
                            filters: {
                                manager_parent_id: _this.manager_parent_id,
                                manager_id: _this.manager_id,
                                search_value: term,
                                businessId: _this.businessId
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
                width: '100%',


            });
            elementInit.on("change", function (e) {
                let dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.human_resources_employee_profile_id_data = dataCurrent[0];
                } else {
                    _this.model.attributes.human_resources_employee_profile_id_data = null;
                    _this._setValueForm('human_resources_employee_profile_id_data', null);

                }
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });

            initS2 = elementInit;
            if (valueCurrent) {
                _this.setValuesS2({
                    valueCurrent: valueCurrent,
                    elementS2: $(el),

                });
            }

        },
        setValuesS2: function (params) {
            let valueCurrentId = params['valueCurrent'];//id
            let elementS2 = params['elementS2'];
            /*
            if (valueCurrentId) {
                selected_roles = this.role_id_data_current;
                for (let rol_id in selected_roles) {
                    if (selected_roles.hasOwnProperty(rol_id)) {
                        let option = new Option(selected_roles[rol_id], rol_id, true, true);
                        elementS2.append(option).trigger('change');
                    }
                }
                dataCurrent = elementS2.select2('data');
                this.model.attributes.role_id_data = dataCurrent;

            }

             */
        }


    }
})
;

