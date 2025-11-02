{{-- CMS -TEMPLATE-CHANGE-PASSWORD-ASSETS--}}
@include('partials.plugins.resourcesJs',['croppie'=>true])
@include('partials.plugins.resourcesJs',['toast'=>true])
@include('partials.plugins.resourcesJs',['blockUi'=>true])
@include('partials.plugins.resourcesJs',['axios'=>true])

<script>
    var $profileConfig = <?php echo json_encode($dataManagerPage['profileConfig'])?>;
    var $initLoad = false;
</script>
<script>
    var $scope;
    var appInit = new Vue(
        {
            el: '#app-management',
            directives: {
                resetModel: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        paramsInput._resetModel(paramsInput.model);
                    },
                },
            },
            props: {
                params: {
                    type: Object,
                }
            },
            created: function () {
                $scope = this;
                this.$root.$on("_updateParentByChildren", function (emitValue) {
                    $scope._managerTypes(emitValue);
                });
                this.initManagement($profileConfig);
            },
            beforeMount: function () {
                this.configParams = this.params;

            },
            mounted: function () {
                this.initCurrentComponent();
            },

            validations: function () {

                var attributes = {

                    password: {},
                    password_repeat: {},

                    password_old: {},
                    password_new: {},
                    change_password: {}
                };

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

                var result = {
                    model: {//change
                        attributes: attributes
                    },
                };
                return result;

            },
            data: function () {

                var dataManager = {
                    configParams: {},
                    labelsConfig: {},
                    lblBtnSave: "Guardar",
                    lblBtnClose: "Cerrar",
                    model: {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm(),
                    },
                    tabCurrentSelector: '#tab-customer',
                    processName: "Registro Acción.",
                    formConfig: {
                        nameSelector: "#customer-form",
                        url: $('#action-user-save-change-password').val(),
                        loadingMessage: 'Guardando...',
                        errorMessage: 'Error al guardar.',
                        successMessage: 'La contraseña se guardo correctamente.',
                        nameModel: "Customer"
                    },
                    showManager: false,
                    managerType: null,
                    //load image
                    managerCreate: false,
                    initDataManagerConfig: {
                        loading: true,
                        ready: false,
                    },
                    allowReset: false,
                    createUpdate: true,
                    managerInitAll: false,
                    managerInitGet: {

                        password_old: {
                            allow: false
                        },
                    },

                };
                return dataManager;
            },
            methods: {
                ...$methodsFormValid,
                initManagement: function (params) {
                    console.log('change-password')
                    this.onInitEventClickTimerForm();
                },

                //EVENTS OF CHILDREN
                _managerTypes: function (emitValues) {
                    if (emitValues.type == "rebootGrid") {

                    }
                },
                /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
                initCurrentComponent: function () {


                },
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
                        password: null,
                        change_password: true,
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
                    if (name == "password_old") {
                        this.managerInitGet[name].allow = true;
                    }
                    this.$v["model"]["attributes"][name].$model = value;
                    this.$v["model"]["attributes"][name].$touch();
                },
//Manager Model
                getValuesSave: function () {
                    var User = {

                        password: this.$v.model.attributes.password.$model,
                        password_old: this.$v.model.attributes.password_old.$model,
                        password_new: this.$v.model.attributes.password_new.$model,
                        change_password: this.$v.model.attributes.change_password.$model,


                    };
                    var result = {
                        User: User,

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
                        alert('Error');

                    } else {
                        ajaxRequestManager(this.formConfig.url, {
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
                    this.model.attributes.change_password = true;
                    this.labelsConfig.title = "Actualizar Usuario";
                    this.managerInitGet = {
                        password_old: {
                            allow: false
                        },
                    };
                    this.createUpdate = true;
                    this.$v.model.attributes.$reset();

                },
                resetForm: function () {
                    this.$v.$reset();
                    this.model = {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm()
                    };
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
                _resetModel: function (model) {
                    model.$reset();
                },

            }

        })
    ;

</script>
