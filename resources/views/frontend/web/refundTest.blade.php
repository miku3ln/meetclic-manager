<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$allowModalPaymentez = false;
?>
@extends('layouts.frontend')
@section('additional-styles')
    <style>
        .page-title.page-title--left {
            text-align: left;
        }
        /* Making the label break the flow */
        /* LABELS*/

        .form-group__label {
            position: absolute;
            top: 0;
            left: 0;
            user-select: none;
            z-index: 500;
        }

        .form-group__input + .form-group__label {
            z-index: 500;
        }

        .form-group__input + .form-group__label {
            transition: transform .25s, opacity .25s ease-in-out;
            transform-origin: 0 0;
            opacity: .5;
        }

        .form-group__input:focus + .form-group__label,
        .form-group__input:not(:placeholder-shown) + .form-group__label {
            transform: translate(.25em, -30%) scale(.8);
            opacity: .25;
        }

        .form-group__input + .form-group__label {
            position: absolute;
            top: .75em;
            left: .75em;
            display: inline-block;
            width: auto;
            margin: 0;
            padding: .75em;
            transition: transform .25s, opacity .25s, padding .25s ease-in-out;
            transform-origin: 0 0;
            color: rgba(255, 255, 255, .5);
        }

        .form-group__input:focus + .form-group__label,
        .form-group__input:not(:placeholder-shown) + .form-group__label {
            z-index: 500;
            padding-top: 8%;
            transform: translate(0, -2em) scale(.9);
            color: #666;
        }

        /*INPUTS*/
        /* Hide the browser-specific focus styles */
        .form-group--float-label .form-group__input:focus,
        .form-group--float-label .form-group__input:not(:placeholder-shown) {
            border-color: #666;
        }

        .form-group__input {
            color: rgba(44, 62, 80, .75);
            border-width: 0;
            z-index: 600;
        }

        .form-group__input:focus {
            outline: 0;
        }

        .form-group__input::placeholder {
            color: rgba(44, 62, 80, .5);
        }

        /* Make the label and field look identical on every browser */
        .form-group__label,
        .form-group__input {
            font: inherit;
            line-height: 1;
            display: block;
            width: 100%;
        }

        .form-group--float-label,
        .form-group__input {
            position: relative;
        }

        /* Input Style #1 */
        .form-group__input {
            transition: border-color .25s ease-in-out;
            border-bottom: 3px solid rgba(255, 255, 255, .05);
            background-color: transparent;
        }


        .form-group__input:focus,
        .form-group__input:not(:placeholder-shown) {
            border-color: rgba(255, 255, 255, .1);
        }

        .form-group__input {
            padding: 6% 6% 2.5% 5%;
            transition: border-color .25s ease-in-out;
            color: rgb(51, 51, 51);
            border: 1px solid rgb(97, 94, 94);
            border-radius: 5px;
            background-color: transparent;
        }


        /* Common Styles */
        /* Identical inputs on all browsers */
        .form-group--float-label.form-group__input:not(textarea),
        .form-group--float-label.form-group__input:not(textarea) {
            max-height: 4em;
        }


    </style>
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    <link href="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.css") }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('additional-scripts')
    @include('partials.plugins.resourcesJs',['axios'=>true])
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>

    <script>
        var appThisComponent = null;
        var appInit = new Vue(
            {
                el: '#app-management',
                directives: {},
                created: function () {

                },
                mounted: function () {
                    this.initCurrentComponent();
                    appThisComponent = this;
                    var $this = this;
                    $(document).ready(function () {
                        $this.loadPage = true;
                    });
                },

                validations: function () {
                    var attributes = {

                        "manager_id": {required},


                    };

                    var result = {
                        model: {//change
                            attributes: attributes
                        },
                    };
                    return result;

                },
                data: function () {
                    var result = {
                        titles: {typePayments: 'Metodos De Pago'},
                        model: {
                            attributes: this.getAttributesForm(),
                            structure: this.getStructureForm(),
                        },
                        typeName: 'main-deposit',
                        formConfig: {
                            nameSelector: "#source-logo-main-form",
                            url: "{{route('refundCreditCardSave', app()->getLocale()) }}",
                            loadingMessage: 'Guardando...',
                            errorMessage: 'Error al guardar Imagen.',
                            successMessage: 'Se guardo correctamente.',
                            nameModel: "TemplateBySource"
                        },
                        managerInitAll: false,
                        loadPage: false
                    };

                    return result;
                },
                methods: {
                    onListenElementsForm:onListenElementsForm,

                    /* FORM*/
                    getAttributesForm: function () {

                        var result = {

                            "manager_id": null,

                        };
                        return result;
                    },
                    getStructureForm: function () {
                        var result = {
                            manager_id: {
                                id: "manager_id",
                                name: "manager_id",
                                label: 'Dato',
                                required: {
                                    allow: true,
                                    msj: $formValidationsLabels.required,
                                    error: false
                                },
                            },

                        };
                        return result;
                    },
                    _setValueForm: function (name, value) {

                        this.model.attributes[name] = value;
                        this.$v["model"]["attributes"][name].$model = value;
                        this.$v["model"]["attributes"][name].$touch();
                        this.getValidateForm();

                    },
                    getClassErrorForm: function (nameElement, objValidate) {
                        var result = null;
                        result = {
                            "form-group--error": objValidate.$error,
                            'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
                        };

                        return result;
                    },

                    getValuesSave: function () {
                        var result = {

                            manager_id: this.model.attributes.manager_id
                        };
                        console.log(result);
                        return result;
                    },
                    _submitForm: function (e) {
                        console.log(e);
                    },
                    _resetForm: function (e) {
                        console.log(e);
                    },
                    initManagement: function () {

                    },
                    resetForm: function () {
                        this.$v.$reset();
                        this.model = {
                            attributes: this.getAttributesForm(),
                            structure: this.getStructureForm()
                        };
                        this.initManagement();
                        $('[data-method="accept_terms"]').slideUp();
                    },
                    _saveModel: function () {

                        var $this = this;
                        $this.$v.$touch();
                        var validateCurrent = this.validateForm();
                        var configAjax = {
                            blockElement: '',
                            loading_message: 'Anulando Orden.......',
                        };
                        if (validateCurrent) {
                            var dataSendResult = this.getValuesSave();
                            var dataSend = dataSendResult;
                            ajaxRequest(this.formConfig.url, {
                                type: 'POST',
                                data: dataSend,
                                blockElement: configAjax.blockElement,//opcional: es para bloquear el elemento
                                loading_message: configAjax.loading_message,
                                error_message: configAjax.error_message,
                                success_message: configAjax.success_message,
                                success_callback: function (response) {

                                    if (response.success) {
                                        $this.resetForm();

                                    }
                                }
                            }, true);
                        }

                    },
                    resetForm: function () {

                        this.$v.$reset();
                        this.model = {
                            attributes: this.getAttributesForm(),
                            structure: this.getStructureForm()
                        };
                        this.initManagement();

                    },
                    initCurrentComponent: function () {
                        this.getValidateForm();
                    }
                    ,
                    /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                    _updateParentByChildren: function (params) {
                        console.log(params);
                    }
                    , validateForm: function () {
                        var currentAllow = this.getValidateForm();
                        return currentAllow.success;
                    },
                    getNameAttribute: function (name) {
                        var result = this.formConfig.nameModel + "[" + name + "]";
                        return result;
                    },
                    getLabelForm: viewGetLabelForm,
                    getValidateForm: function () {
                        var success = true;
                        var attributeCurrent = "";

                        var errors = [];
                        if (
                            this.$v.model.attributes.manager_id.$invalid

                        ) {

                            if (this.$v.model.attributes.manager_id.$invalid) {
                                errors.push({
                                    "fields": ["manager_id"]
                                });

                            }


                            success = false;
                        }
                        var result = {
                            success: success,
                            errors: errors
                        };
                        return result;
                    },


                },

            })
        ;
        appInit.initManagement();
    </script>

@endsection
@section('content')

    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title page-title--left">
                            Refound
                        </h2>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper" id='app-management'>
        <div class="checkout-page-wrapper">
            <div class="container--checkout">

                <div id="manager-shop-products">

                    <b-form id="checkout-form" @submit="_submitForm">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group form-group--float-label form-group--float-label--label"
                                     :class="getClassErrorForm('manager_id',$v.model.attributes.manager_id)">
                                    <input
                                        @change="_setValueForm('manager_id', $v.model.attributes.manager_id.$model)"
                                        v-model.trim="$v.model.attributes.manager_id.$model"
                                        name="OrderBillingCustomer[manager_id]" id="manager_id"
                                        type="text"
                                        placeholder="Ingrese Transacción Referencia"
                                        class="form-group__input"
                                        v-focus-select
                                        required>
                                    <label class='form-group__label '>Transacción Referencia*</label>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.manager_id.$error">
                                            <span v-if="!$v.model.attributes.manager_id.required">
                                <?php  echo "{{model.structure.manager_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <button
                                    v-on:click="_saveModel()"
                                    :disabled="!validateForm()"
                                    class="js-paymentez-checkout theme-button theme-button--small theme-button--alt theme-button--register"
                                    type="button"> Devolucion
                                </button>
                            </div>
                        </div>


                    </b-form>

                </div>

            </div>
        </div>

    </div>

@endsection
