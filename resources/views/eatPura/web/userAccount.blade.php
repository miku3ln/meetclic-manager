{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/eatPura/';
        $assetsRoot = $resourcePathServer . 'assets/backline/';
$urlCurrentSearch=route('search',app()->getLocale());

@endphp
@extends('layouts.eatPura')
@section('additional-modal')
    <!-- My Card with Address -->

    <div class="offcanvas offcanvas-end my-cart-width" tabindex="-1" id="location">
        <div
            class="offcanvas-header px-4 py-3 d-flex align-items-center justify-content-start gap-3 bg-danger text-white">
            <a href="#" class="link-light" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="lni lni-arrow-left fs-5 d-flex"></i></a>
            <h6 class="offcanvas-title" id="locationLabel">Enter your area or apartment name</h6>
        </div>
        <div class="offcanvas-body p-0">
            <!-- search -->
            <div class="p-4 bg-light">
                <div class="input-group bg-white rounded-3 border py-1">
                    <a href="#" class="input-group-text bg-transparent border-0 rounded-0 px-3"><i
                            class="icofont-search"></i></a>
                    <input type="text" class="form-control bg-transparent border-0 rounded-0 ps-0"
                           placeholder="Try J P Nagar, Andheri West etc.."
                           aria-label="Try J P Nagar, Andheri West etc..">
                </div>
                <a href="#" class="link-dark" data-bs-dismiss="offcanvas" aria-label="Close">
                    <div class="d-flex align-items-center gap-2 text-danger pt-3">
                        <i class="icofont-location-arrow"></i>
                        <p class="m-0">Use my Current location</p>
                    </div>
                </a>
            </div>
            <!-- Saved Address -->
            <div class="border-bottom p-4">
                <p class="text-black text-uppercase small">Saved Addresses</p>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="w-75">
                        <a href="#" class="link-dark" data-bs-dismiss="offcanvas" aria-label="Close">
                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                <i class="lni lni-home text-muted fs-5"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Home</h6>
                                    <p class="text-muted text-truncate mb-0 small">H.No. 2834 Street, 784 Sector,
                                        Ludhiana, Punjab</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <a href="#" class="link-dark">
                        <div class="bg-light rounded-circle icon-sm">
                            <i class="icofont-share fs-5 text-dark-emphasis"></i>
                        </div>
                    </a>
                </div>
            </div>
            <!-- recent search -->
            <div class="p-4">
                <p class="text-black text-uppercase small">Recent Searches</p>
                <a href="#" class="link-dark" data-bs-dismiss="offcanvas" aria-label="Close">
                    <div class="d-flex align-items-center gap-3 osahan-mb-1">
                        <i class="lni lni-map-marker text-muted fs-5"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Ludhiana</h6>
                            <p class="text-muted text-truncate mb-0 small">87997 Street, 784 Sector, Ludhiana,
                                Punjab</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection


@section('additional-styles')
    <style>
        .map-guests {
            height: 350px;
            width: 100%;
        }

    </style>
@endsection
@section('additional-scripts-vue-before')

    <script>
        function getDataParents() {
            var result = {
                name: "al3x"
            };
            result.configModalInformationAddress = {
                data: {
                    entity_id: 1,
                    labelsConfig: {
                        title: "",

                    },
                    entity_type: 2
                }

            };

            return result;
        }

        $dataParent = getDataParents();
    </script>
@endsection
@section('additional-init-script-vue')

    <script id="additional-scripts-vue">
        $dataParent.initComponentManager = {
            modalAddress: false,
        }
        console.log(69);
        $methodsShopPage.onViewModalAddressByType = onViewModalAddressByType;
        $methodsShopPage.initCurrentComponentUserAccount = initCurrentComponentUserAccount;

        function onViewModalAddressByType(params) {
            this.initComponentManager.modalAddress = true;
            this.$refs.refInformationAddress.showModal(params);

        }

        function initCurrentComponentUserAccount() {

        }
    </script>
    <script type="text/x-template" id="information-address-template">
        <div>
            <!-- Add Address modal-->
            <div class="modal fade" id="addaddress" tabindex="-1" aria-hidden="true" ref="refModalAddress">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 rounded-4 overflow-hidden">
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-6">

                                    <b-row>
                                        <b-col md="12">
                                            <div class="floating-panel-manager not-view">
                                                <input id="search-map-current"
                                                       class="floating-panel-manager__search"
                                                       type="textbox"
                                                       value="Ecuador"
                                                       v-on:click="_initClassSearch()"
                                                       v-focus-select
                                                >

                                            </div>
                                            <div class="map-guests"
                                                 v-initMapCurrent="{model:$v.model.attributes,_initMap:_initMap}"
                                                 id="manager-map">

                                            </div>
                                        </b-col>
                                    </b-row>

                                </div>
                                <div class="col-lg-6 p-4">
                                    <button type="button" class="btn-close float-end shadow-none"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                            id="close-manager-address"
                                    ></button>
                                    <div class="mb-3 pe-5">
                                        <h5 class="fw-bold mb-1"><?php echo "{{managerLabels.title}}" ?></h5>
                                        <p class="text-muted small m-0">This allow us to find you easily and give you
                                            timely
                                            delivery experience </p>
                                    </div>
                                    <div class="d-block ">
                                        <b-form id="informationAddressForm" v-on:submit.prevent="_submitForm"
                                                @change="handleFormChange">

                                            <div class="row">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-4">
                                                        <div class="form-floating h-100">
                                                            <select class="form-select"

                                                                    v-model.trim="$v.model.attributes.courtesy_title.$model"
                                                                    v-bind:id="getNameAttribute('courtesy_title')"
                                                                    v-bind:name="getNameAttribute('courtesy_title')"

                                                            >
                                                                <option value="1" selected>Mr</option>
                                                                <option value="2">Mrs</option>
                                                                <option value="3">Miss</option>
                                                            </select>
                                                            <label       v-bind:for="getNameAttribute('courtesy_title')">Sr. Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-floating h-100">
                                                            <input type="text" class="form-control"
                                                                   v-model.trim="$v.model.attributes.courtesy_name.$model"
                                                                   v-bind:id="getNameAttribute('courtesy_name')"
                                                                   v-bind:name="getNameAttribute('courtesy_name')"

                                                                   placeholder="name" value="David">
                                                            <label       v-bind:for="getNameAttribute('courtesy_name')">Receiver's name</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <b-container v-if="allowManager">
                                                <input v-model="model.attributes.id" type="hidden"
                                                       v-bind:id="getNameAttribute('id')"
                                                       v-bind:name="getNameAttribute('id')"
                                                >


                                                <b-row>
                                                    <b-col md="4">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('state',$v.model.attributes.state)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("state")'></label>
                                                            <div class="content-element-form">
                                                                <select v-model.trim="$v.model.attributes.state.$model"
                                                                        v-bind:id="getNameAttribute('state')"
                                                                        v-bind:name="getNameAttribute('state')"
                                                                        class="form-control m-input"
                                                                        @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                                                >
                                                                    <option
                                                                        v-for="(row,index) in model.structure.state.options"
                                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>

                                                    </b-col>
                                                    <b-col md="4">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('main',$v.model.attributes.main)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("main")'></label>
                                                            <div class="content-element-form">


                                                                <switch-button
                                                                    v-on:toggle="_setValueForm('main', $v.model.attributes.main.$model)"
                                                                    v-model="$v.model.attributes.main.$model"
                                                                    color="#34bfa3">
                                                                </switch-button>
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.main.$error">
      <span v-if="!$v.model.attributes.main.required">
       <?php echo "{{model.structure.main.required.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>

                                                    </b-col>
                                                </b-row>


                                                <b-row>
                                                    <b-col md="6">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('information_address_type_id_data',$v.model.attributes.information_address_type_id_data)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("information_address_type_id_data")'></label>
                                                            <div class="content-element-form">
                                                                <input
                                                                    v-model="$v.model.attributes.information_address_type_id_data.model"
                                                                    type="hidden"
                                                                    v-bind:id="getNameAttribute('information_address_type_id_data')"
                                                                    v-bind:name="getNameAttribute('information_address_type_id_data')"
                                                                    @change="_setValueForm('information_address_type_id_data', $v.model.attributes.information_address_type_id_data.$model)"
                                                                >
                                                                <select id="information_address_type_id_data"
                                                                        class="form-control m-select2 "
                                                                        v-initS2InformationAddressType="{rowId:model.attributes.id,_managerS2InformationAddressType:_managerS2InformationAddressType}"
                                                                >
                                                                </select>
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.information_address_type_id_data.$error">
      <span v-if="!$v.model.attributes.information_address_type_id_data.required">
       <?php echo "{{model.structure.information_address_type_id_data.required.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="12">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('street_one',$v.model.attributes.street_one)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("street_one")'></label>
                                                            <div class="content-element-form">
                                                                <input
                                                                    v-model.trim="$v.model.attributes.street_one.$model"
                                                                    type="text"
                                                                    v-bind:id="getNameAttribute('street_one')"
                                                                    v-bind:name="getNameAttribute('street_one')"
                                                                    class="form-control m-input"
                                                                    @change="_setValueForm('street_one', $v.model.attributes.street_one.$model)"
                                                                    v-focus-select
                                                                >
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.street_one.$error">
      <span v-if="!$v.model.attributes.street_one.required">
       <?php echo "{{model.structure.street_one.required.msj}}" ?>
      </span>
                                                                    <span
                                                                        v-if="!$v.model.attributes.street_one.maxLength">
       <?php echo "{{model.structure.street_one.maxLength.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>

                                                    </b-col>
                                                    <b-col md="12">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('street_two',$v.model.attributes.street_two)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("street_two")'></label>
                                                            <div class="content-element-form">
                                                                <input
                                                                    v-model.trim="$v.model.attributes.street_two.$model"
                                                                    type="text"
                                                                    v-bind:id="getNameAttribute('street_two')"
                                                                    v-bind:name="getNameAttribute('street_two')"
                                                                    class="form-control m-input"
                                                                    @change="_setValueForm('street_two', $v.model.attributes.street_two.$model)"
                                                                    v-focus-select
                                                                >
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.street_two.$error">
      <span v-if="!$v.model.attributes.street_two.required">
       <?php echo "{{model.structure.street_two.required.msj}}" ?>
      </span>
                                                                    <span
                                                                        v-if="!$v.model.attributes.street_two.maxLength">
       <?php echo "{{model.structure.street_two.maxLength.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>

                                                    </b-col>

                                                </b-row>


                                                <b-row>
                                                    <b-col md="12">
                                                        <div class="form-group"
                                                             :class="getClassErrorForm('reference',$v.model.attributes.reference)">
                                                            <label class="form__label "
                                                                   v-html='getLabelForm("reference")'></label>
                                                            <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.reference.$model"
    v-bind:id="getNameAttribute('reference')"
    v-bind:name="getNameAttribute('reference')"
    @change="_setValueForm('reference', $v.model.attributes.reference.$model)"
    v-focus-select
></textarea>
                                                            </div>
                                                            <div class="content-message-errors">
                                                                <b-form-invalid-feedback
                                                                    :state="!$v.model.attributes.reference.$error">
      <span v-if="!$v.model.attributes.reference.required">
       <?php echo "{{model.structure.reference.required.msj}}" ?>
      </span>
                                                                </b-form-invalid-feedback>
                                                            </div>
                                                        </div>

                                                    </b-col>

                                                </b-row>


                                            </b-container>


                                        </b-form>


                                        <div class="d-block__manager-buttons">
                                            <button type="button"
                                                    :disabled="!validateForm()"
                                                    class="btn btn-success " v-on:click="_saveModel()">
                                                <?php echo "{{lblBtnSave}}" ?>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- location offcanvas -->


        </div>

    </script>
    <script type="text/x-template" id="admin-information-address-template">
        <div>
            <!-- Add Address modal-->
            <div ref="refAdminAddress">
            </div>
        </div>

    </script>

    @include('eatPura.web.partials.assets.js-validate')

    <script>
        var initLoad = false;
        var componentThisInformationAddress;

        Vue.component('information-address-component', {
            template: '#information-address-template',
            directives: {
                initS2InformationAddressType: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value
                        paramsInput._managerS2InformationAddressType({
                            objSelector: el, rowId: paramsInput.rowId
                        });
                    }
                },
                initMapCurrent: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        paramsInput._initMap({
                            elementSelector: ".map-guests",
                            objSelector: $(el)[0],
                            data: paramsInput
                        });

                    }
                },
            }, props: {
                params: {
                    type: Object,
                }
            },
            created: function () {
            },

            beforeMount: function () {
                this.configParams = this.params;
                this.entity_id = this.configParams.data.entity_id;
                this.labelsConfig.title = this.configParams.data.labelsConfig.title;
                this.entity_type = this.configParams.data.entity_type;

            },
            mounted: function () {
                componentThisInformationAddress = this;
                this.initCurrentComponent();
                this.initModalEvents();
                this.allowManager = true;
            },

            beforeUnmount() {
                this.removeModalEvents();
            },
            data: function () {

                var dataManager = {
                    state: {
                        firstName: "Alex"
                    },
                    allowManager: false,
                    managerLabels: {
                        title: "Creacion"
                    },
                    business_id: null,
                    /*  ----MANAGER ENTITY---*/
                    configModelEntity: {
                        "buttonsManagements": [
                            {
                                "title": "Actualizar",
                                "data-placement": "top",
                                "i-class": "fas fa-pencil-alt",
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
                        "title": "Huespedes Pago",
                        process: {
                            "payment": "Pagos"
                        },
                        buttons: {
                            save: "Guardar",
                            update: "Actualizar",
                            cancel: "Cancelar"
                        }
                    },

//form config
                    model: {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm(),
                    },
                    tabCurrentSelector: '#modal-information-address',
                    processName: "Registro Acción.",
                    formConfig: {
                        nameSelector: "#modal-information-address",
                        url: $('#action-information-address-saveData').val(),
                        loadingMessage: 'Guardando...',
                        errorMessage: 'Error al guardar el InformationAddress.',
                        successMessage: 'El InformationAddress se guardo correctamente.',
                        nameModel: "InformationAddress"
                    },
                    submitStatus: "no",
                    showManager: false,
                    managerType: null,
                    lblBtnSave: "Guardar"
                };


                return dataManager;
            },
            validations: function () {

                var attributes = {
                    "id": {},
                    "street_one": {required, maxLength: Validators.maxLength(150)},
                    "street_two": {required, maxLength: Validators.maxLength(150)},
                    "reference": {required},
                    "state": {required},
                    "entity_id": {},
                    "main": {required},
                    "entity_type": {},
                    "information_address_type_id_data": {required},
                    "has_location": {required},
                    "options_map": {required},
                    information_address_location_current: {},
                    "courtesy_title": {required},
                    "courtesy_name": {required},

                };
                var result = {
                    model: {//change
                        attributes: attributes
                    },
                };
                return result;

            },
            methods: {
                ...$methodsFormValid,
                handleFormChange: function (event) {
                    const fieldName = event.target.name;
                    const fieldValue = event.target.value;
                },
                showModal(params) {
                    var title = params.type == 1 ? "Actualizacion" : "Creacion";
                    this.managerLabels.title = title;
                    const modal = new bootstrap.Modal(this.$refs.refModalAddress);
                    modal.show();
                },
                hideModal() {
                    const modal = bootstrap.Modal.getInstance(this.$refs.refModalAddress);
                    if (modal) modal.hide();
                },
                initModalEvents() {
                    this.$refs.refModalAddress.addEventListener('shown.bs.modal', this.onModalShown);
                    this.$refs.refModalAddress.addEventListener('hidden.bs.modal', this.onModalHidden);
                },
                removeModalEvents() {
                    this.$refs.refModalAddress.removeEventListener('shown.bs.modal', this.onModalShown);
                    this.$refs.refModalAddress.removeEventListener('hidden.bs.modal', this.onModalHidden);
                },
                onModalShown() {
                    console.log('Modal is now shown');
                    // Puedes emitir un evento al componente padre si lo necesitas
                    this.$emit('modalShown');
                },
                onModalHidden() {
                    console.log('Modal is now hidden');
                    // Emitir un evento o realizar otras acciones
                    this.$emit('modalHidden');
                },
                initCurrentComponent: function () {
                    this.initDataModal();
                },
                /*modal events*/
                _showModal: function () {
                    this.resetForm();

                },
                _hideModal: function () {
                    this._emitToParent({
                        type: 'resetComponent',
                        'componentName': 'configModalInformationAddress'
                    });

                },
                _saveModal: function (bvModalEvt) {
                    // Prevent modal from closing
                    bvModalEvt.preventDefault();
                    // Trigger submit handler
                    this.handleSubmit();
                },
                _cancel: function () {
                    this.$refs.refInformationAddressModal.hide();

                },
                initDataModal: function () {
                    var rowCurrent = this.configParams.data;
                },
                _setValueOfParent: function (params) {
                    if (params.type == "openModal") {
                        this.configParams = params.data;

                        this.initDataModal();
                        this.$refs.refInformationAddressModal.show();

                    }
                },
                _emitToParent: function (params) {
                    this.$root.$emit('_updateParentByChildren', params);
                },
//EVENTS OF CHILDREN
                _managerTypes: function (emitValues) {
                    if (emitValues.type == "rebootGrid") {
                        //$(this.gridConfig.selectorCurrent).bootgrid("reload");

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
                        state: {
                            id: "state",
                            name: "state",
                            label: "Estado",
                            required: {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            },
                            options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                        },
                        entity_id: {
                            id: "entity_id",
                            name: "entity_id",
                            label: "entity id",
                            required: {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            },
                        },
                        main: {
                            id: "main",
                            name: "main",
                            label: "Principal",
                            required: {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            },
                        },
                        entity_type: {
                            id: "entity_type",
                            name: "entity_type",
                            label: "entity type",
                            required: {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            },
                        },
                        information_address_type_id_data: {
                            id: "information_address_type_id_data",
                            name: "information_address_type_id_data",
                            label: "Tipo",
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
                        courtesy_title: {
                            id: "courtesy_title",
                            name: "courtesy_title",
                            label: "Sr/Miss",
                            required: {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            },
                        },
                        courtesy_name: {
                            id: "courtesy_name",
                            name: "courtesy_name",
                            label: "Nombre",
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
                        "street_one": null,
                        "street_two": null,
                        "reference": null,
                        "state": 'ACTIVE',
                        "entity_id": null,
                        "main": false,
                        "entity_type": null,
                        "information_address_type_id_data": null,
                        "has_location": true,
                        "options_map": null,
                        "information_address_location_current": null,
                        "courtesy_title": null,
                        "courtesy_name": null,

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
                    var result = {
                        InformationAddress:
                            {
                                "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                                "street_one": this.$v.model.attributes.street_one.$model,
                                "street_two": this.$v.model.attributes.street_two.$model,
                                "reference": this.$v.model.attributes.reference.$model,
                                "state": this.$v.model.attributes.state.$model,
                                "entity_id": this.entity_id,
                                "main": this.$v.model.attributes.main.$model ? 1 : 0,
                                "entity_type": this.entity_type,
                                "information_address_type_id": this.$v.model.attributes.information_address_type_id_data.$model.id,
                                "has_location": 1,
                                "options_map": this.$v.model.attributes.options_map.$model,
                                "information_address_location_current": this.$v.model.attributes.information_address_location_current.$model,
                                "courtesy_title": this.$v.model.attributes.courtesy_title.$model,
                                "courtesy_name": this.$v.model.attributes.courtesy_name.$model,

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
                                    vCurrent.resetForm();
                                   // $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                                    $("#close-manager-address").click();
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
                _managerS2InformationAddressType: function (params) {
                    var el = params.objSelector;
                    var valueCurrentRowId = params.rowId;
                    var dataCurrent = [];
                    if (valueCurrentRowId) {
                        dataCurrent = [this.model.attributes.information_address_type_id_data];
                        var textCurrent = this.model.attributes.information_address_type_id_data.text;
                        var idCurrent = this.model.attributes.information_address_type_id_data.id;
                        var option = new Option(textCurrent, idCurrent, true, true);
                        $(el).append(option).trigger('change');
                    }
                    var _this = this;
                    var elementInit = $(el).select2({
                        allow: true,
                        placeholder: "Seleccione",
                        data: dataCurrent,
                        ajax: {
                            url: $("#action-information-address-type-getListSelect2").val(),
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
                        allowClear: true,
                        multiple: true,
                        maximumSelectionLength: 1,

                        width: '100%'
                    }).on("select2:open", function (e) {
                        managerModalSelect2();
                    });

                    elementInit.on('select2:select', function (e) {
                        var data = e.params.data;
                        _this.model.attributes.information_address_type_id_data = data;
                    }).on("select2:unselecting", function (e) {
                        _this.model.attributes.lodging_room_levels_id_data = null;
                        _this._setValueForm('information_address_type_id_data', null);
                    });
                },

                /* ----MAPS-----*/
                /*MAP */
                _initClassSearch: function () {
                    if (!$('.pac-container').hasClass('pac-container--view-modal')) {

                        $('.pac-container').addClass('pac-container--view-modal');
                    }
                },
                ...$managerGoogleMaps,
            },


        });

        Vue.component('admin-information-address-component', {
            template: '#admin-information-address-template',
            directives: {


            }, props: {
                params: {
                    type: Object,
                }
            },
            created: function () {
            },

            beforeMount: function () {
                this.configParams = this.params;
                this.entity_id = this.configParams.data.entity_id;
                this.labelsConfig.title = this.configParams.data.labelsConfig.title;
                this.entity_type = this.configParams.data.entity_type;

            },
            mounted: function () {
                this.initCurrentComponent();
                this.allowManager = true;
            },

            beforeUnmount() {
                this.removeModalEvents();
            },
            data: function () {

                var dataManager = {
                    state: {
                        firstName: "Alex"
                    },
                    allowManager: false,
                    managerLabels: {
                        title: "Creacion"
                    },
                    business_id: null,
                    /*  ----MANAGER ENTITY---*/
                    configModelEntity: {
                        "buttonsManagements": [
                            {
                                "title": "Actualizar",
                                "data-placement": "top",
                                "i-class": "fas fa-pencil-alt",
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
                        "title": "Huespedes Pago",
                        process: {
                            "payment": "Pagos"
                        },
                        buttons: {
                            save: "Guardar",
                            update: "Actualizar",
                            cancel: "Cancelar"
                        }
                    },
                    tabCurrentSelector: '#admin-modal-information-address',
                    processName: "Registro Acción.",
//Grid config
                    gridConfig: {
                        selectorCurrent: "#information-address-grid",
                        url: $("#action-information-address-getAdmin").val()
                    },
                    submitStatus: "no",
                    showManager: false,
                    managerType: null,
                    lblBtnSave: "Guardar"
                };


                return dataManager;
            },

            methods: {


                initCurrentComponent: function () {
                    this.initGridManager(this);
                },
                _managerTypes: function (emitValues) {
                    if (emitValues.type == "rebootGrid") {
                        $(this.gridConfig.selectorCurrent).bootgrid("reload");

                    }
                },
                /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
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
                            params: params
                        }
                        result.push(setPush);
                    });
                    return result;
                },
                _gridManager: function (elementSelect) {
                    var vmCurrent = this;
                    var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
                    elementSelect.find("tbody tr").on("click", function (e) {
                        var self = $(this);
                        var dataRowId = $(self[0]).attr("data-row-id");
                        var selectorRow;
                        if (dataRowId) {
                            var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                            var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                            elementSelect.find("tr.selected").removeClass("selected");
                            var newEventRow = false;
                            if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                                var removeRowId = vmCurrent.managerMenuConfig.rowId;
                                if (dataRowId == removeRowId) {
                                    selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                                    $(selectorRow).removeClass("selected");
                                    vmCurrent._resetManagerGrid();
                                } else {

                                    newEventRow = true;
                                }
                            } else {
                                newEventRow = true;
                            }
                            if (newEventRow) {
                                selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                                $(selectorRow).addClass("selected");
                                vmCurrent.managerMenuConfig = {
                                    view: true,
                                    menuCurrent: vmCurrent.getMenuConfig({rowData: rowData[0], rowId: dataRowId}),
                                    rowId: dataRowId
                                };
                            }

                        }
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
                        this.model.attributes.street_one = rowCurrent.street_one;
                        this.model.attributes.street_two = rowCurrent.street_two;
                        this.model.attributes.reference = rowCurrent.reference;
                        this.model.attributes.state = rowCurrent.state;
                        this.model.attributes.entity_id = rowCurrent.entity_id;
                        this.model.attributes.main = rowCurrent.main == 0 ? false : true;
                        this.model.attributes.entity_type = rowCurrent.entity_type;
                        this.model.attributes.information_address_type_id_data = {
                            id: rowCurrent.information_address_type_id,
                            text: rowCurrent.information_address_type
                        };
                        this.model.attributes.has_location = rowCurrent.has_location;
                        this.model.attributes.options_map = rowCurrent.options_map;
                        this.model.attributes.courtesy_title = rowCurrent.courtesy_title;
                        this.model.attributes.courtesy_name = rowCurrent.courtesy_name;

                        this._viewManager(3, rowId);
                    }
                },
                initGridManager: function (vmCurrent) {
                    var gridName = this.gridConfig.selectorCurrent;
                    var urlCurrent = this.gridConfig.url;

                    var paramsFilters = {
                        entity_id: this.entity_id,
                        entity_type: this.entity_type,

                    };
                    let gridInit = $(gridName);
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
                        labels: {
                            loading: "Cargando...",
                            noResults: "Sin Resultados!",
                            infos: "Mostrando <?php echo "{{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados" ?>"
                        },
                        css: getCSSCurrentBootGrid(),
                        formatters: {
                            'description': function (column, row) {

                                var mainRow = [
                                    row.main ? '<span class="content-description__value badge badge--size-large badge-success">' : '<span class="content-description__value badge badge--size-large badge-warning">',
                                    row.main ? 'SI' : 'NO',
                                    '</span>'
                                ];
                                var stateRow = [
                                    row.state == 'ACTIVE' ? '<span class="content-description__value badge badge--size-large badge-success">' : '<span class="content-description__value badge badge--size-large badge-warning">',
                                    row.state == 'ACTIVE' ? 'ACTIVO' : 'INACTIVO',
                                    '</span>'
                                ];
                                mainRow = mainRow.join('');
                                stateRow = stateRow.join('');
                                var result = [
                                    "<div class='content-description'>",
                                    "<div class='content-description__information'>",
                                    "   <span class='content-description__title'>Estado:</span>" + stateRow,
                                    "</div>",
                                    "<div class='content-description__information'>",
                                    "   <span class='content-description__title'>Principal:</span>" + mainRow,
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
                                    "</div>"
                                ];

                                return result.join("");

                            }

                        }
                    }).on("loaded.rs.jquery.bootgrid", function () {
                        vmCurrent._resetManagerGrid();
                        vmCurrent._gridManager(gridInit);
                    });
                },
                /*Manager FORMS-AND VIEWS*/
                getViewErrorForm: function (objValidate) {
                    var result = false
                    if (!objValidate.$dirty) {
                        result = objValidate.$dirty ? (!objValidate.$error) : false;
                    } else {
                        result = objValidate.$error;
                    }
                    return result;
                },

            },


        });

    </script>
@endsection


@section('content-manager')
    <div class="actions">
        <input id="action-information-address-saveData" type="hidden"
               value="{{route("saveCustomerAddressInformationShop", app()->getLocale())}}"/>

        <input id="action_saveCustomerAddressInformationShop" type="hidden"
               value="{{ route('saveCustomerAddressInformationShop',app()->getLocale()) }}"/>
        <input id="action-information-address-type-getListSelect2" type="hidden"
               value="{{action("Information\InformationAddressTypeController@getListSelect2")}}"/>
    </div>
    <section class="p-0">
        <div class="container p-0">
            <div
                class="row rounded-4 border osahan-my-account-page border-secondary-subtle g-0 col-lg-8 mx-auto overflow-hidden">
                <div class="col-lg-3 border-bottom bg-white">
                    <div class="nav d-flex justify-content-center my-account-pills" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <button class="nav-link d-flex flex-column active" id="v-pills-my-address-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#v-pills-my-address" type="button" role="tab"
                                aria-controls="v-pills-my-address" aria-selected="true">
                            <i class="lni lni-map"></i>Address
                        </button>
                        <button class="nav-link d-flex flex-column" id="v-pills-my-order-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-my-order" type="button" role="tab"
                                aria-controls="v-pills-my-order"
                                aria-selected="false">
                            <i class="lni lni-list"></i>My Order
                        </button>
                        <button class="nav-link d-flex flex-column" id="v-pills-my-wallet-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-my-wallet" type="button" role="tab"
                                aria-controls="v-pills-my-wallet" aria-selected="false">
                            <i class="lni lni-wallet"></i>My Wallet
                        </button>
                        <a class="nav-link d-flex flex-column" href="{{route('logout', app()->getLocale())}}"><i
                                class="lni lni-key"></i>{{__('frontend.buttons.logout')}}</a>
                    </div>
                </div>
                <div class="col-lg-9 bg-light">
                    <div class="tab-content p-3" id="v-pills-tabContent">
                        <!-- my address -->
                        <div class="tab-pane fade show active" id="v-pills-my-address" role="tabpanel"
                             tabindex="0">


                            <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                <h4 class="m-0">My Addresses</h4>
                                <information-address-component
                                    ref="refInformationAddress"
                                    :params="configModalInformationAddress"
                                >
                                </information-address-component>
                                <a
                                    @click="onViewModalAddressByType({type:0})"
                                    class="btn btn-danger d-flex align-items-center rounded-pill text-link text-decoration-none btn-sm text-start"
                                ><i
                                        class="icofont-plus-circle me-2"></i>Add New <span
                                        class="d-none d-lg-block ms-1">Address</span>

                                </a>
                            </div>
                            <div
                                class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3 osahan-my-addresses">
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-home text-muted fs-5"></i>
                                                <div class="pe-4 overflow-hidden">
                                                    <h6 class="fw-bold mb-1">Home</h6>
                                                    <p class="text-muted text-truncate mb-0 small">H.No. 2834 Street,
                                                        784 Sector, Ludhiana, Punjab</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small" data-bs-toggle="modal"
                                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt fs-6"></i><br>Edit</a>
                                            <a href="#" class="link-dark small" data-bs-toggle="modal"
                                               data-bs-target="#trash"><i class="lni lni-trash-can fs-6"></i><br>Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-map-marker text-muted fs-5"></i>
                                                <div class="pe-4 overflow-hidden">
                                                    <h6 class="fw-bold mb-1">Ludhiana</h6>
                                                    <p class="text-muted text-truncate mb-0 small">87997 Street, 784
                                                        Sector, Ludhiana, Punjab</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small" data-bs-toggle="modal"
                                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt fs-6"></i><br>Edit</a>
                                            <a href="#" class="link-dark small" data-bs-toggle="modal"
                                               data-bs-target="#trash"><i class="lni lni-trash-can fs-6"></i><br>Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-briefcase text-muted fs-5"></i>
                                                <div class="pe-4 overflow-hidden">
                                                    <h6 class="fw-bold mb-1">Office</h6>
                                                    <p class="text-muted text-truncate mb-0 small">9878, 784 Sector,
                                                        Ludhiana, Punjab</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small" data-bs-toggle="modal"
                                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt fs-6"></i><br>Edit</a>
                                            <a href="#" class="link-dark small" data-bs-toggle="modal"
                                               data-bs-target="#trash"><i class="lni lni-trash-can fs-6"></i><br>Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-home text-muted fs-5"></i>
                                                <div class="pe-4 overflow-hidden">
                                                    <h6 class="fw-bold mb-1">Home</h6>
                                                    <p class="text-muted text-truncate mb-0 small">H.No. 2834 Street,
                                                        784 Sector, Ludhiana, Punjab</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small" data-bs-toggle="modal"
                                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt fs-6"></i><br>Edit</a>
                                            <a href="#" class="link-dark small" data-bs-toggle="modal"
                                               data-bs-target="#trash"><i class="lni lni-trash-can fs-6"></i><br>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- my orders -->
                        <div class="tab-pane fade" id="v-pills-my-order" role="tabpanel"
                             tabindex="0">
                            <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                <h4 class="m-0">My Orders</h4>
                            </div>
                            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3 osahan-my-orders">
                                <div class="col">
                                    <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails"
                                         aria-controls="viewdetails"
                                         class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-shopping-basket text-success fs-4"></i>
                                                <div>
                                                    <small
                                                        class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Delivered</small>
                                                    <h6 class="fw-bold mb-1 d-flex align-items-center">ORD049190212
                                                        &#183; <span class="text-danger fw-normal ms-2"> $186</span>
                                                    </h6>
                                                    <p class="text-muted text-truncate mb-0 small">Placed on wed, 19 Oct
                                                        23, 12:55 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small"><i class="lni lni-eye fs-6"></i><br>View
                                                Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails"
                                         aria-controls="viewdetails"
                                         class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-shopping-basket text-success fs-4"></i>
                                                <div>
                                                    <small
                                                        class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Delivered</small>
                                                    <h6 class="fw-bold mb-1 d-flex align-items-center">ORD065763273
                                                        &#183; <span class="text-danger fw-normal ms-2"> $876</span>
                                                    </h6>
                                                    <p class="text-muted text-truncate mb-0 small">Placed on wed, 22
                                                        oct'22, 12:55 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small"><i class="lni lni-eye fs-6"></i><br>View
                                                Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails"
                                         aria-controls="viewdetails"
                                         class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-shopping-basket text-success fs-4"></i>
                                                <div>
                                                    <small
                                                        class="badge bg-danger-subtle text-danger rounded-pill fw-normal small-sm mb-2">Cancelled</small>
                                                    <h6 class="fw-bold mb-1 d-flex align-items-center">ORD065763273
                                                        &#183; <span class="text-danger fw-normal ms-2"> $976</span>
                                                    </h6>
                                                    <p class="text-muted text-truncate mb-0 small">Placed on wed, 22
                                                        oct'22, 12:55 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <a href="#" class="small"><i class="lni lni-eye fs-6"></i><br>View
                                                Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- my wallet -->
                        <div class="tab-pane fade" id="v-pills-my-wallet" role="tabpanel"
                             tabindex="0">
                            <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                <h4 class="m-0">My Balance</h4>
                                <h4 class="fw-bold text-danger m-0">$75</h4>
                            </div>
                            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3">
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-circle-plus text-muted fs-5"></i>
                                                <div class="lh-sm">
                                                    <h6 class="fw-bold text-success mb-1">Cashback</h6>
                                                    <p class="text-truncate mb-2 small">Transaction ID: 50919487</p>
                                                    <small class="text-muted">On 23 Oct 18, 03:13 PM</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <span class="text-success fw-bold h6 m-0">+$75</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-circle-minus text-muted fs-5"></i>
                                                <div class="lh-sm">
                                                    <h6 class="fw-bold text-danger mb-1">Purchase</h6>
                                                    <p class="text-truncate mb-2 small">Transaction ID: 50919487</p>
                                                    <small class="text-muted">On 23 Oct 18, 03:13 PM</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <span class="text-danger fw-bold h6 m-0">-$75</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div
                                        class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                                        <div class="w-75">
                                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                                <i class="lni lni-circle-plus text-muted fs-5"></i>
                                                <div class="lh-sm">
                                                    <h6 class="fw-bold text-success mb-1">Cashback</h6>
                                                    <p class="text-truncate mb-2 small">Transaction ID: 50919487</p>
                                                    <small class="text-muted">On 23 Oct 18, 03:13 PM</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                            <span class="text-success fw-bold h6 m-0">+$75</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

