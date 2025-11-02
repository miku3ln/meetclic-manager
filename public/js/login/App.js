const Validator = SimpleVueValidation.Validator;

Vue.use(SimpleVueValidation);//https://bootstrap-vue.js.org/docs/reference/validation/
Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model

var required = Validators.required;
var minLength = Validators.minLength;
var between = Validators.between;
var sameAs = Validators.sameAs;
var email = Validators.email;
var $vCurrent;
var $thisCurrent;
var appForm = new Vue({
        el: '#content-manager-login',
        created: function () {

        },
        mounted: function () {
            $vCurrent = this.$v;
            $thisCurrent = this;
            this.$v.modelRegister.attributes.password.$model = null;
            this.$v.$reset();
        },
        validations: {
            modelRegister: {
                attributes: {
                    name: {
                        required
                    },
                    email: {
                        required,
                        email
                    },
                    password: {
                        required,
                        minLength: minLength(6)
                    },
                    "password_confirmation": {
                        sameAsPassword: sameAs('password')
                    }
                }
            },

        },
        data: function () {
            $vCurrent = this.$v;
            return {
                btnLoginLabel: 'Iniciar Sesión!',
                btnRegisterLabel: 'Registrarse',
                msj: {
                    value: "",
                    view: false
                },
                loginConfig:
                    {
                        facebook: {
                            allow: false
                        }
                    },
                modelRegister: {
                    attributes: this.getAttributesFormRegister(),
                    structure: this.getStructureFormRegister(),
                },
            };
        },
        methods:
            {
                ...$methodsFormValid,
                check: function () {
                    this.checked = !this.checked;
                },
                _loginUser: function () {
                    var currentThisVue = this;
                    currentThisVue["msj"]["view"] = false;
                    currentThisVue["msj"]["value"] = "";
                    var elementBtn = $("#m_login_signin_submit");
                    var a = elementBtn, r = elementBtn.closest("form");
                    r.validate({
                        rules: {
                            email: {required: !0, email: !0},
                            password: {required: !0}
                        }
                    });
                    if (r.valid() && (a.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0))) {
                        var dataForm = r.serializeArray();
                        var email = dataForm[1].value;
                        var password = dataForm[2].value;
                        var paramsUser = {email: email, password: password, type: $("#typeLogin").val()};
                        r.submit();
                    }
                },
                loginFireBase: function (paramsUser) {
                    signInWithEmailAndPassword(paramsUser).then(data => {
                            r.submit();
                        }
                    ).catch(error => {
                        var code = error.code;
                        if (!code) {
                            code = "auth/user-not-found";
                        }
                        var msj = errorsLogin(code);
                        currentThisVue["msj"]["view"] = true;
                        currentThisVue["msj"]["value"] = msj;
                        removeLoading(elementBtn);

                    });
                },
                _goRegister: function () {
                    var elementBtn = $("#m_register");
                    var urlManager = elementBtn.attr("url");
                    window.location.href = urlManager;

                },
                createFirebase: function (paramsUser, rSubmit) {
                    var elementBtn = $("#btn-save-user");

                    var currentThisVue = this;
                    createUser(paramsUser).then(data => {
                            r.submit();
                        }
                    ).catch(error => {
                        var code = error.code;
                        var msj = errorsLogin(code);
                        currentThisVue["msj"]["view"] = true;
                        currentThisVue["msj"]["value"] = msj;
                        removeLoading(elementBtn);

                    });
                },
                _saveRegister: function () {

                    var currentThisVue = this;
                    currentThisVue["msj"]["view"] = false;
                    currentThisVue["msj"]["value"] = "";
                    var elementBtn = $("#btn-save-user");
                    this.$v.$touch();
                    var a = elementBtn, r = elementBtn.closest("form");
                    r.validate({
                        rules: {
                            email: {required: !0, email: !0},
                            password: {required: !0}
                        }
                    });
                    if (r.valid() && (a.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0))) {
                        var dataForm = r.serializeArray();
                        $("#typeLogin").val("firebase");
                        var email = dataForm[3].value;
                        var password = dataForm[4].value;
                        var paramsUser = {email: email, password: password, type: $("#typeLogin").val()};

                        r.submit();


                    }

                },

                /*FORM*/
                /* REGISTER*/
                setValueFormRegister: function (name, value) {

                    this.modelRegister.attributes[name] = value;
                    this.$v["modelRegister"]["attributes"][name].$touch();
                    this._valuesFormRegister();
                },
                _valuesFormRegister: function (event) {
                    this.modelRegister.init = false;
                    this.validateFormRegister();
                },
                validateFormRegister: function () {
                    var currentAllow = true;


                    if (this.$v.modelRegister.attributes.name.$error  || this.$v.modelRegister.attributes.email.$error || this.$v.modelRegister.attributes.password.$error || this.$v.modelRegister.attributes.password_confirmation.$error) {
                        currentAllow = false;
                    }
                    return currentAllow;
                },
                getClassErrorForm: function (nameElement, objValidate) {

                    var result = {
                        "has-danger": objValidate.$error,
                        'has-success': objValidate.$dirty ? (!objValidate.$error) : false
                    }

                    return result;
                },
                getViewErrorForm: function (nameElement, objValidate) {
                    var result = false;


                    if (!objValidate.$dirty) {
                        result = objValidate.$dirty ? (!objValidate.$error) : false;
                    } else {
                        result = objValidate.$error;
                    }

                    return result;
                },
                getLabelForm: function (nameId, type) {
                    var labelName = "";
                    if (type == 1) {
                        labelName = this.modelRegister.structure[nameId].label + (this.modelRegister.structure[nameId].required.allow ? "*" : "");
                    }
                    return labelName;
                },
                getAttributesFormRegister: function () {

                    var result = {
                        name: null,
                        email: null,
                        password: true,
                        password_confirmation: null,
                    };

                    return result;
                },
                getStructureFormRegister: function () {
                    var result = {
                        name:
                            {
                                id: "name",
                                name: "name",
                                label: "Nombre",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                        email: {
                            name: "email",
                            label: "Email",
                            required:
                                {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                }
                        },
                        password: {
                            name: "password",
                            label: "Password",
                            required:
                                {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                }
                        },
                        password_confirmation: {
                            name: "password",
                            label: "Password Confirmar",
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
            }
    })
;

function removeLoading(element) {
    element.removeClass("m-loader");
    element.removeClass("m-loader--light");
    element.removeClass("m-loader--light");
    element.removeAttr("disabled")
}
