var componentThisBusinessByEmployeeProfile;
var initS2;
Vue.component('business-by-employee-profile-component', {

    template: '#business-by-employee-profile-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Roles({
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
        componentThisBusinessByEmployeeProfile = this;
        this.initCurrentComponent();
        removeClassNotView();

    },
    validations: function () {


        var attributes = {
            username: {
                required,
                isUnique(value) {
                    var urlValidate = $("#action-users-uniqueUserName").val();
                    var params = {
                        username: value
                    };
                    var user_id = this.model.attributes.user_id;
                    if (user_id) {
                        params['id'] = user_id;
                    }
                    var paramsPost = {
                        allow: this.managerInitGet.username.allow,
                        value: value,
                        paramsPost: params,
                        urlValidate: urlValidate
                    };
                    var result = null;
                    if (value === '') {
                        result = true;
                    } else {
                        if (this.managerInitGet.username.allow) {
                            result = getValuesPost(paramsPost);
                        } else {
                            result = true;

                        }
                    }
                    return result;

                }
            },
            name: {required},
            email: {
                required,
                isUnique(value) {
                    var urlValidate = $("#action-users-uniqueUserEmail").val();
                    var params = {
                        email: value
                    };
                    var user_id = this.model.attributes.user_id;
                    if (user_id) {
                        params['id'] = user_id;
                    }
                    var paramsPost = {
                        allow: this.managerInitGet.email.allow,
                        value: value,
                        paramsPost: params,
                        urlValidate: urlValidate
                    };
                    var result = null;

                    if (value === '') {
                        result = true;
                    } else {
                        if (this.managerInitGet.email.allow) {
                            result = getValuesPost(paramsPost);
                        } else {
                            result = true;

                        }
                    }
                    return result;
                }
            },
            password: {},
            password_repeat: {},
            role_id_data: {required},
            user_id: {},
            id: {},
            human_resources_employee_profile_id: {},
            status: {},
            password_old: {},
            password_new: {},
            change_password: {}
        };
        if (!this.createUpdate) {
            attributes['password'] = null;
            attributes['password_repeat'] = null;

            attributes['password'] = {
                required,
                minLength: minLength(6)
            };
            attributes['password_repeat'] = {
                sameAsPassword: Validators.sameAs('password')

            };

        } else {
            if (this.createUpdate && this.model.attributes.change_password) {
                attributes['password'] = {};
                attributes['password_repeat'] = {};
                attributes['password_new'] = {
                    required,
                    minLength: minLength(6)
                };
                attributes['password_repeat'] = {
                    sameAsPassword: Validators.sameAs('password_new')

                };

                attributes['password_old'] = {
                    required,
                    isUnique(value) {
                        var urlValidate = $("#action-users-equalsUserPassword").val();
                        var params = {
                            password_old: value
                        };
                        var user_id = this.model.attributes.user_id;
                        if (user_id) {
                            params['id'] = user_id;
                        }
                        var paramsPost = {
                            allow: this.managerInitGet.password_old.allow,
                            value: value,
                            paramsPost: params,
                            urlValidate: urlValidate
                        };
                        var result = null;

                        if (value === '') {
                            result = true;
                        } else {
                            if (this.managerInitGet.password_old.allow) {
                                result = getValuesPost(paramsPost);
                            } else {
                                result = true;

                            }
                        }
                        return result;
                    }
                };

            }
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
            labelsConfig: {
                "title": "Registro Usuario",
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
            processName: "Gestion de Usuario.",
            formConfig: {
                nameSelector: "#business-by-employee-profile-form",
                url: $('#action-business-by-employee-profile-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'Se guardo correctamente.',
                nameModel: "BusinessByEmployeeProfile"
            },
            allowReset: false,
            createUpdate: false,
            statusData: [{id: 'ACTIVE', value: 'ACTIVO'}, {id: 'INACTIVE', value: 'INACTIVO'}],
            managerInitAll: false,
            managerInitGet: {
                username: {
                    allow: false
                },
                password_old: {
                    allow: false
                },
                email: {
                    allow: false
                },
            },
            rowCurrent:{}
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
            this.rowCurrent=rowCurrent;
            this.human_resources_employee_profile_id = rowCurrent.id;
            this.business_id = rowCurrent.business_id;
            this.createUpdate = rowCurrent.user_id ? true : false;
            if (this.createUpdate) {
                this.model.attributes['id'] = rowCurrent['business_by_employee_profile_id'];
                this.model.attributes['user_id'] = rowCurrent.user_id;
                this.model.attributes['username'] = rowCurrent.username;
                this.model.attributes['email'] = rowCurrent.email;
                this.model.attributes['status'] = rowCurrent.status_users == 'ACTIVE' ? true : false;
                this.model.attributes['human_resources_employee_profile_id'] = rowCurrent['human_resources_employee_profile_id'];
                var role_id_data = rowCurrent['roles'];
                this.role_id_data_current = role_id_data;
                var valueCurrent = this.model.attributes['id'];
                this.setValuesS2({
                    valueCurrent: valueCurrent,
                    elementS2: $('#role_id_data'),

                });
                this.labelsConfig.title = "Actualizar Usuario";
            }

            this.managerInitAll = true;
        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
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
            var result = false;
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
            var result = {
                //payment
                username: {
                    id: "username",
                    name: "username",
                    label: "Usuario",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                email: {
                    id: "email",
                    name: "email",
                    label: "E-mail",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                role_id_data: {
                    id: "role_id_data",
                    name: "role_id_data",
                    label: "Roles",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                status: {
                    id: "status",
                    name: "status",
                    label: "Estado",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                change_password: {
                    id: "change_password",
                    name: "change_password",
                    label: "Cambiar Contraseña",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                password_new: {
                    id: "password_new",
                    name: "password_new",
                    label: "Password Nueva",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                password_repeat: {
                    id: "password_repeat",
                    name: "password_repeat",
                    label: "Repetir Password",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                password: {
                    id: "password",
                    name: "password",
                    label: "Password",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                password_old: {
                    id: "password_old",
                    name: "password_old",
                    label: "Password Anterior",
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

            var result = {
                username: null,
                password: null,
                name: 'init-manager-name',
                email: null,
                role_id_data: [],
                status: true,
                change_password: false,
                password_old: null,
                password_new: null,
                password_repeat: null,

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
            if (name == "username") {
                this.managerInitGet[name].allow = true;
            } else if (name == "password_old") {
                this.managerInitGet[name].allow = true;
            } else if (name == "email") {
                this.managerInitGet[name].allow = true;
            }
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
        getErrorHas: function (model, type) {
            var result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {
            var role_id_data = [];
            $.each(this.$v.model.attributes.role_id_data.$model, function (key, value) {
                var setPush = value.id;
                role_id_data.push(setPush);
            });
            role_id_data = role_id_data.join(',');
            this.model.attributes['name'] = this.rowCurrent.name + ' ' + this.rowCurrent.last_name;

            var BusinessByEmployeeProfile = {
                username: this.$v.model.attributes.username.$model,
                status: this.$v.model.attributes.status.$model ? 'ACTIVE' : 'INACTIVE',
                name: this.$v.model.attributes.name.$model,
                email: this.$v.model.attributes.email.$model,
                password: this.$v.model.attributes.password.$model,
                password_old: this.$v.model.attributes.password_old.$model,
                password_new: this.$v.model.attributes.password_new.$model,
                change_password: this.$v.model.attributes.change_password.$model,
                role_id_data: role_id_data,
                business_id: this.business_id,
                human_resources_employee_profile_id: this.human_resources_employee_profile_id,
                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : "-1",
                user_id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.user_id.$model : "-1",

            };
            var result = {
                BusinessByEmployeeProfile: BusinessByEmployeeProfile,
                business_id: this.business_id,
                human_resources_employee_profile_id: this.human_resources_employee_profile_id
            };

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
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
                        $scope.resetChangePassword({
                            response: response
                        });
                    }
                });
            }
        },
        resetChangePassword: function (params) {
            this.model.attributes.password_new = null;
            this.model.attributes.password_old = null;
            this.model.attributes.password_repeat = null;
            this.model.attributes.change_password = false;
            this.model.attributes['id'] = params.response.models['BusinessByEmployeeProfile']['business_by_employee_profile_id'];
            this.model.attributes['user_id'] = params.response.models['User'].user_id;
            this.labelsConfig.title = "Actualizar Usuario";
            this.managerInitGet = {
                username: {
                    allow: false
                },
                password_old: {
                    allow: false
                },
                email: {
                    allow: false
                },
            };
            this.createUpdate = true;
            this.$v.model.attributes.$reset();

        },
        resetForm: function () {
            if (initS2) {

                initS2.val(null).trigger("change");
            }
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };

            this.$v.model.attributes.$reset();
            this.managerInitAll = false;
            this.managerInitGet = {
                username: {
                    allow: false
                },
                password_old: {
                    allow: false
                },
                email: {
                    allow: false
                },
            };
            this.$v.$reset();

        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm:getValidateForm,
        /*modal*/
        _showModal: function () {

            if (!this.allowReset && !this.createUpdate) {

                this.resetForm();
            }
        },
        _hideModal: function () {
            this.resetForm();
            if (this.allowReset) {
                this.allowReset = false;
                this._emitToParent({type: "rebootGrid"});
            }

            this._emitToParent({
                type: "resetProcess",
                name: "configModalBusinessByEmployeeProfile",
            });
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
        }, _managerS2Roles: function (params) {
            console.log('entra');
            var el = params.objSelector;
            var valueCurrent = params.model;
            var dataCurrent = [];
            var _this = this;
            var businessId = null;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-roles-listAll").val(),
                    type: "get",
                    dataType: 'json',

                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
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


                width: '100%',


            });
            elementInit.on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.role_id_data = dataCurrent;
                } else {
                    _this.model.attributes.role_id_data = null;
                    _this._setValueForm('role_id_data', null);

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
            var valueCurrentId = params['valueCurrent'];//id
            var elementS2 = params['elementS2'];
            if (valueCurrentId) {
                selected_roles = this.role_id_data_current;
                for (var rol_id in selected_roles) {
                    if (selected_roles.hasOwnProperty(rol_id)) {
                        var option = new Option(selected_roles[rol_id], rol_id, true, true);
                        elementS2.append(option).trigger('change');
                    }
                }
                dataCurrent = elementS2.select2('data');
                this.model.attributes.role_id_data = dataCurrent;

            }
        }


    }
})
;

