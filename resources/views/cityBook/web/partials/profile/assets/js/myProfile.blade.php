<!-- CMS-TEMPLATE-MY-PROFILE-JS-->

@include('partials.plugins.resourcesJs',['croppie'=>true])
@include('partials.plugins.resourcesJs',['toast'=>true])
@include('partials.plugins.resourcesJs',['blockUi'=>true])
<script>
    var $profileConfig = <?php echo json_encode($dataManagerPage['profileConfig']) ?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;


    var $initLoad = false;
</script>
<script>
    var $scope;
    var latLngCurrent = {lat: 0.2314799, lng: -78.271874};
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
                    initCrop: {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            paramsInput.initMethod({
                                objSelector: el, model: paramsInput.model
                            });
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
                    this.countriesData = $dataManagerPage["dataCatalogue"]['locationData'];
                    if (this.countriesData.hasOwnProperty('18')) {
                        this.provincesData = this.countriesData['18']['data'];
                        if (this.provincesData.hasOwnProperty('15')) {
                            this.citiesData = this.provincesData['15']['data'];
                            if (this.citiesData.hasOwnProperty('1')) {
                                this.zonesData = this.citiesData['1']['data'];
                            }

                        }
                    }
                    this.initManagement($profileConfig);
                },
                beforeMount: function () {
                    this.configParams = this.params;
                    this.business_id = null;
                },
                mounted: function () {
                    this.initCurrentComponent();
                    this.onInitEventClickTimerForm();//CHANGE-FORM

                },

                validations: function () {
                    var attributes = {

                        //PEOPLE
                        people_id_data: {},//update
                        last_name: {required},
                        name: {required},
                        birthdate: {required},
                        gender_data: {required},

                        //CUSTOMER
                        id: {},
                        customer_id: {},
                        identification_document: {required},//
                        people_type_identification_id_data: {required},//
                        business_name: {},
                        business_reason: {},
                        ruc_type_id_data: {},
                        business_id: {},
                        // CUSTOMER INFORMATION
                        customer_by_information_id: {},//update
                        people_nationality_id_data: {required},
                        people_profession_id_data: {required},
                        /*Address Information*/
                        "information_address_id": {},//update
                        "street_one": {},
                        "street_two": {},
                        "reference": {},
                        "state": {},
                        "entity_id": {},
                        "main": {},
                        "entity_type": {},
                        "information_address_type_id_data": {},
                        "has_location": {},
                        "options_map": {},
                        'information_address_location_current': {},
                        //LOCATION
                        'customer_profile_by_location_id': {},//update
                        countries_id: {required},
                        provinces_id: {required},
                        cities_id: {required},
                        zones_id: {required},
                        //PHONE
                        'information_phone_id': {},
                        'information_phone_value': {required},
                        'information_phone_operator_id': {},
                        'information_phone_type_id': {},
                        //network social
                        'information_social_network_id_one': {},
                        'information_social_network_value_one': {},
                        'information_social_network_type_id_one': {},
                        'information_social_network_id_two': {},
                        'information_social_network_value_two': {},
                        'information_social_network_type_id_two': {},

                        'information_social_network_id_three': {},
                        'information_social_network_value_three': {},
                        'information_social_network_type_id_three': {},

                        'information_social_network_id_four': {},
                        'information_social_network_value_four': {},
                        'information_social_network_type_id_four': {},

                        'information_social_network_id_five': {},
                        'information_social_network_value_five': {},
                        'information_social_network_type_id_five': {},

                        'information_social_network_id_six': {},
                        'information_social_network_value_six': {},
                        'information_social_network_type_id_six': {},

                        //ABOUT US
                        'users_by_about_us_id': {},//UPDATE
                        'user_by_about_us_description': {required},
                        'user_by_about_us_web': {},
                        customer_by_profile_id: {},
                        //USER
                        source: {required},
                        change: {},

                    };
                    if (this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc) {
                        attributes["business_name"] = {required};
                        attributes["business_reason"] = {required};
                        attributes["ruc_type_id_data"] = {required};
                        this.model.attributes.ruc_type_id_data = $dataManagerPage['attributesFormDefault']['ruc_type_id_natural'];

                    } else {
                        this.model.attributes.ruc_type_id_data = $dataManagerPage['attributesFormDefault']['ruc_type_id_any'];
                    }


                    if (this.managerInformationAddress.allow) {
                        attributes["street_one"] = {required, maxLength: Validators.maxLength(150)};
                        attributes["street_two"] = {required, maxLength: Validators.maxLength(150)};
                        attributes["reference"] = {required};
                        attributes["state"] = {required};
                        attributes["information_address_type_id_data"] = {required};
                        attributes["has_location"] = {required};
                        attributes["options_map"] = {required};
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
                            url: $('#action-customer-profile-save').val(),
                            loadingMessage: 'Guardando...',
                            errorMessage: 'Error al guardar.',
                            successMessage: 'El Perfil se guardo correctamente.',
                            nameModel: "Customer"
                        },
                        showManager: false,
                        managerType: null,
                        typeIdentificationRuc: $dataManagerPage['attributesFormDefault']['typeIdentificationRuc'],
                        peopleNationalityData: $dataManagerPage["dataCatalogue"]["peopleNationality"],//
                        peopleProfessionData: $dataManagerPage["dataCatalogue"]["peopleProfession"],//
                        peopleTypeIdentificationData: $dataManagerPage["dataCatalogue"]["peopleTypeIdentification"],//
                        rucTypeData: $dataManagerPage["dataCatalogue"]["rucType"],//
                        genderData: [
                            {value: 0, text: "HOMBRE"},
                            {value: 1, text: "MUJER"},
                            {value: 2, text: "LBTI"},
                            {value: 3, text: "OTROS"}
                        ],
                        managerInformationAddress: {
                            allow: true,
                            allowEdit: true,
                        },
                        business_id: null,
                        countriesData: [],
                        provincesData: [],
                        citiesData: [],
                        zonesData: [],
                        //load image
                        managerCreate: false,
                        initDataManagerConfig: {
                            loading: true,
                            ready: false,

                        },

                    };
                    return dataManager;
                },
                methods: {
                    ...$methodsFormValid,
                    initManagement: function (params) {
                        console.log(params);
                        if (params.success) {
                            var managerType = 'createEntity';
                            var row = {
                                id: null,
                                customer_id: null,
                                'identification_document': '',
                                'people_type_identification_id': '',
                                'people_id': '',
                                'business_name': '',
                                'business_reason': '',
                                'ruc_type_id': '',
                                //PEOPLE
                                'last_name': '',
                                'name': '',
                                'birthdate': '',
                                'gender': '',
                                // CUSTOMER INFORMATION
                                'people_nationality_id': '',
                                'people_profession_id': '',
                                'customer_by_information_id': '',
                                //Address Information
                                'information_address_id': '',
                                'street_one': '',
                                'street_two': '',
                                'reference': '',
                                'has_location': '',
                                'options_map': '',
                                'country_code_id': '',
                                'administrative_area_level_2': '',
                                'administrative_area_level_1': '',
                                'administrative_area_level_3': '',

                                //Location

                                'countries_id': $dataManagerPage['attributesFormDefault']['countries_id'],
                                'provinces_id': $dataManagerPage['attributesFormDefault']['provinces_id'],
                                'cities_id': $dataManagerPage['attributesFormDefault']['cities_id'],
                                'zones_id': $dataManagerPage['attributesFormDefault']['zones_id'],
                            };
                            var dataManager = params.data;
                            var user = dataManager.user;
                            if (params.successProfile) {

                                var Profile = dataManager.Profile;
                                var InformationAddress = dataManager.InformationAddress;
                                var InformationPhone = dataManager.InformationPhone;
                                var InformationSocialNetwork = dataManager.InformationSocialNetwork;
                                var UsersByAboutUs = dataManager.UsersByAboutUs;
                                var hasInformation = Object.keys(InformationAddress).length == 0 ? false : true;
                                var hasLocation = Profile.customer_profile_by_location_id ? true : false;
                                var hasAbout = Object.keys(UsersByAboutUs).length == 0 ? false : true;
                                var hasPhone = Object.keys(InformationPhone).length == 0 ? false : true;
                                var hasSocialNetwork = Object.keys(InformationSocialNetwork).length == 0 ? false : true;

                                row = {
                                    id: Profile.id,
                                    customer_id: Profile.customer_id,
                                    'identification_document': Profile.identification,
                                    'people_type_identification_id': Profile.people_type_identification_id,
                                    'people_id': Profile.people_id,
                                    'business_name': Profile.business_name,
                                    'business_reason': Profile.business_reason,
                                    'ruc_type_id': Profile.ruc_type_id,
                                    //PEOPLE
                                    'last_name': Profile.last_name,
                                    'name': Profile.first_name,
                                    'birthdate': Profile.birthdate,
                                    'gender': Profile.gender,
                                    //BY PROFILE
                                    'customer_by_profile_id': Profile.customer_by_profile_id,
                                    // CUSTOMER INFORMATION
                                    'people_nationality_id': Profile.people_nationality_id,
                                    'people_profession_id': Profile.people_profession_id,
                                    'customer_by_information_id': Profile.customer_by_information_id,
                                    //Address Information
                                    'information_address_id': hasInformation ? InformationAddress.information_address_id : null,
                                    'street_one': hasInformation ? InformationAddress.street_one : null,
                                    'street_two': hasInformation ? InformationAddress.street_two : null,
                                    'reference': hasInformation ? InformationAddress.reference : null,
                                    'has_location': hasInformation ? true : false,
                                    'options_map': hasInformation ? InformationAddress.options_map : null,
                                    'country_code_id': hasInformation ? InformationAddress.country_code_id : null,
                                    'administrative_area_level_2': hasInformation ? InformationAddress.administrative_area_level_2 : null,
                                    'administrative_area_level_1': hasInformation ? InformationAddress.administrative_area_level_1 : null,
                                    'administrative_area_level_3': hasInformation ? InformationAddress.administrative_area_level_3 : null,
                                    //Location
                                    'countries_id': hasLocation ? Profile.countries_id : $dataManagerPage['attributesFormDefault']['countries_id'],
                                    'provinces_id': hasLocation ? Profile.provinces_id : $dataManagerPage['attributesFormDefault']['provinces_id'],
                                    'cities_id': hasLocation ? Profile.cities_id : $dataManagerPage['attributesFormDefault']['cities_id'],
                                    'zones_id': hasLocation ? Profile.zones_id : $dataManagerPage['attributesFormDefault']['zones_id'],
                                    customer_profile_by_location_id: hasLocation ? Profile.customer_profile_by_location_id : null,//verify
                                    //About Us


                                };
                                managerType = 'updateEntity';
                                if (hasAbout) {
                                    row.users_by_about_us_id = UsersByAboutUs.id;
                                    row.user_by_about_us_web = UsersByAboutUs.web == 'null' ? '' : UsersByAboutUs.web;
                                    row.user_by_about_us_description = UsersByAboutUs.description;

                                }
                                if (hasSocialNetwork) {

                                    if (InformationSocialNetwork.hasOwnProperty('one')) {
                                        row.information_social_network_id_one = InformationSocialNetwork['one'].information_social_network_id;
                                        row.information_social_network_value_one = InformationSocialNetwork['one'].information_social_network;
                                        row.information_social_network_type_id_one = InformationSocialNetwork['one'].information_social_network_type_id;
                                    }


                                    if (InformationSocialNetwork.hasOwnProperty('two')) {
                                        row.information_social_network_id_two = InformationSocialNetwork['two'].information_social_network_id;
                                        row.information_social_network_value_two = InformationSocialNetwork['two'].information_social_network;
                                        row.information_social_network_type_id_two = InformationSocialNetwork['two'].information_social_network_type_id;
                                    }
                                    var currentNumber = 'three';
                                    if (InformationSocialNetwork.hasOwnProperty(currentNumber)) {
                                        row['information_social_network_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_id;
                                        row['information_social_network_value' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network;
                                        row['information_social_network_type_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_type_id;
                                    }
                                    currentNumber = 'four';
                                    if (InformationSocialNetwork.hasOwnProperty(currentNumber)) {
                                        row['information_social_network_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_id;
                                        row['information_social_network_value' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network;
                                        row['information_social_network_type_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_type_id;
                                    }
                                    currentNumber = 'five';
                                    if (InformationSocialNetwork.hasOwnProperty(currentNumber)) {
                                        row['information_social_network_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_id;
                                        row['information_social_network_value' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network;
                                        row['information_social_network_type_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_type_id;
                                    }
                                    currentNumber = 'six';
                                    if (InformationSocialNetwork.hasOwnProperty(currentNumber)) {
                                        row['information_social_network_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_id;
                                        row['information_social_network_value' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network;
                                        row['information_social_network_type_id' + '_' + currentNumber] = InformationSocialNetwork[currentNumber].information_social_network_type_id;
                                    }
                                }
                                if (hasPhone) {
                                    row.information_phone_id = InformationPhone.information_phone_id;
                                    row.information_phone_value = InformationPhone.information_phone;
                                    row.information_phone_operator_id = InformationPhone.information_phone_operator_id;
                                    row.information_phone_type_id = InformationPhone.information_phone_type_id;

                                }
                            }
                            if (user.avatarManager) {
                                row['source'] = user.avatar;

                            }
                            var rowCurrentManager = {
                                row: row,
                                managerType: managerType,
                            };

                            this._managerRowGrid(rowCurrentManager);
                        }

                    },

                    //EVENTS OF CHILDREN
                    _managerTypes: function (emitValues) {
                        if (emitValues.type == "rebootGrid") {

                        }
                    },
                    /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
                    initCurrentComponent: function () {


                    },
                    _managerRowGrid: function (params) {
                        var rowCurrent = params.row;
                        var rowId = params.id;
                        if (params.managerType == "updateEntity") {

                            this.resetForm();
                            this.model.attributes.id = rowCurrent.id;
                            this.model.attributes.customer_id = rowCurrent.customer_id;
                            this.model.attributes.business_id = rowCurrent.business_id;
                            this.model.attributes.identification_document = rowCurrent.identification_document;
                            this.model.attributes.people_type_identification_id_data = rowCurrent.people_type_identification_id;
                            this.model.attributes.people_id_data = rowCurrent.people_id;
                            this.model.attributes.business_name = rowCurrent.business_name;
                            this.model.attributes.business_reason = rowCurrent.business_reason;
                            this.model.attributes.ruc_type_id_data = rowCurrent.ruc_type_id;
                            //PEOPLE
                            this.model.attributes.last_name = rowCurrent.last_name;
                            this.model.attributes.name = rowCurrent.name;
                            this.model.attributes.birthdate = rowCurrent.birthdate;
                            this.model.attributes.gender_data = rowCurrent.gender;
                            // CUSTOMER INFORMATION
                            this.model.attributes.people_nationality_id_data = rowCurrent.people_nationality_id;
                            this.model.attributes.people_profession_id_data = rowCurrent.people_profession_id;
                            this.model.attributes.customer_by_information_id = rowCurrent.customer_by_information_id;
                            if (rowCurrent.information_address_id) {
                                this.managerInformationAddress.allow = true;
                                this.model.attributes.information_address_id = rowCurrent.information_address_id;
                                this.model.attributes.street_one = rowCurrent.street_one;
                                this.model.attributes.street_two = rowCurrent.street_two;
                                this.model.attributes.reference = rowCurrent.reference;
                                this.model.attributes.has_location = rowCurrent.has_location;
                                this.model.attributes.options_map = rowCurrent.options_map;
                                this.model.attributes.information_address_location_current = {
                                    country_code_id: rowCurrent.country_code_id,//*
                                    administrative_area_level_2: rowCurrent.administrative_area_level_2,//*
                                    administrative_area_level_1: rowCurrent.administrative_area_level_1,//*
                                    administrative_area_level_3: rowCurrent.administrative_area_level_3,
                                    options_map: rowCurrent.options_map
                                };

                            }
                            this.model.attributes.countries_id = rowCurrent.hasOwnProperty('countries_id') ? rowCurrent.countries_id : null;
                            this.model.attributes.provinces_id = rowCurrent.hasOwnProperty('provinces_id') ? rowCurrent.provinces_id : null;
                            this.model.attributes.cities_id = rowCurrent.hasOwnProperty('cities_id') ? rowCurrent.cities_id : null;
                            this.model.attributes.zones_id = rowCurrent.hasOwnProperty('zones_id') ? rowCurrent.zones_id : null;
                            this.model.attributes.customer_profile_by_location_id = rowCurrent.hasOwnProperty('customer_profile_by_location_id') ? rowCurrent.customer_profile_by_location_id : null;
                            if (rowCurrent.hasOwnProperty('source')) {
                                this.model.attributes.source = rowCurrent.source;
                                this.managerCreate = true;
                            }
                            if (rowCurrent.customer_by_profile_id) {
                                this.model.attributes.customer_by_profile_id = rowCurrent.customer_by_profile_id;

                            }
                            //
                            if (rowCurrent.hasOwnProperty('users_by_about_us_id')) {
                                this.model.attributes.users_by_about_us_id = rowCurrent.users_by_about_us_id;
                                this.model.attributes.user_by_about_us_web = rowCurrent.user_by_about_us_web;
                                this.model.attributes.user_by_about_us_description = rowCurrent.user_by_about_us_description;

                            }
                            if (rowCurrent.hasOwnProperty('information_social_network_id_one')) {
                                this.model.attributes.information_social_network_id_one = rowCurrent.information_social_network_id_one;
                                this.model.attributes.information_social_network_value_one = rowCurrent.information_social_network_value_one;
                                this.model.attributes.information_social_network_type_id_one = rowCurrent.information_social_network_type_id_one;


                            }
                            if (rowCurrent.hasOwnProperty('information_social_network_id_two')) {
                                this.model.attributes.information_social_network_id_two = rowCurrent.information_social_network_id_two;
                                this.model.attributes.information_social_network_value_two = rowCurrent.information_social_network_value_two;
                                this.model.attributes.information_social_network_type_id_two = rowCurrent.information_social_network_type_id_two;
                            }

                            var currentSocialNumber = 'three';
                            var currentKeySocialNumber = 'information_social_network_id' + '_' + currentSocialNumber;
                            if (rowCurrent.hasOwnProperty(currentKeySocialNumber)) {
                                this.model.attributes['information_social_network_id_' + currentSocialNumber] = rowCurrent['information_social_network_id_' + currentSocialNumber];

                                this.model.attributes['information_social_network_value_' + currentSocialNumber] = rowCurrent['information_social_network_value_' + currentSocialNumber];
                                this.model.attributes['information_social_network_type_id_' + currentSocialNumber] = rowCurrent['information_social_network_type_id_' + currentSocialNumber];
                            }

                            currentSocialNumber = 'four';
                            currentKeySocialNumber = 'information_social_network_id' + '_' + currentSocialNumber;
                            if (rowCurrent.hasOwnProperty(currentKeySocialNumber)) {
                                this.model.attributes['information_social_network_id_' + currentSocialNumber] = rowCurrent['information_social_network_id_' + currentSocialNumber];
                                this.model.attributes['information_social_network_value_' + currentSocialNumber] = rowCurrent['information_social_network_value_' + currentSocialNumber];
                                this.model.attributes['information_social_network_type_id_' + currentSocialNumber] = rowCurrent['information_social_network_type_id_' + currentSocialNumber];
                            }
                            currentSocialNumber = 'five';
                            currentKeySocialNumber = 'information_social_network_id' + '_' + currentSocialNumber;
                            if (rowCurrent.hasOwnProperty(currentKeySocialNumber)) {
                                this.model.attributes['information_social_network_id_' + currentSocialNumber] = rowCurrent['information_social_network_id_' + currentSocialNumber];
                                this.model.attributes['information_social_network_value_' + currentSocialNumber] = rowCurrent['information_social_network_value_' + currentSocialNumber];
                                this.model.attributes['information_social_network_type_id_' + currentSocialNumber] = rowCurrent['information_social_network_type_id_' + currentSocialNumber];
                            }
                            currentSocialNumber = 'six';
                            currentKeySocialNumber = 'information_social_network_id' + '_' + currentSocialNumber;
                            if (rowCurrent.hasOwnProperty(currentKeySocialNumber)) {
                                this.model.attributes['information_social_network_id_' + currentSocialNumber] = rowCurrent['information_social_network_id_' + currentSocialNumber];
                                this.model.attributes['information_social_network_value_' + currentSocialNumber] = rowCurrent['information_social_network_value_' + currentSocialNumber];
                                this.model.attributes['information_social_network_type_id_' + currentSocialNumber] = rowCurrent['information_social_network_type_id_' + currentSocialNumber];
                            }
                            if (rowCurrent.hasOwnProperty('information_phone_id')) {
                                this.model.attributes.information_phone_id = rowCurrent.information_phone_id;
                                this.model.attributes.information_phone_value = rowCurrent.information_phone_value;
                                this.model.attributes.information_phone_operator_id = rowCurrent.information_phone_operator_id;
                                this.model.attributes.information_phone_type_id = rowCurrent.information_phone_type_id;

                            }
                        }
                    },
                    /*FORM*/
                    _setValueSelect: function (field, value) {
                        if (field == 'countries_id') {
                            this.provincesData = this.countriesData[value]['data'];
                            this.citiesData = [];
                            this.zonesData = [];
                        } else if (field == 'provinces_id') {

                            this.citiesData = this.provincesData[value]['data'];
                            this.zonesData = [];

                        } else if (field == 'cities_id') {
                            this.zonesData = this.citiesData[value]['data'];
                        } else if (field == 'zones_id') {

                        }
                        this._setValueForm(field, value);
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

                            identification_document: {
                                id: "identification_document",
                                name: "identification_document",
                                label: "{{__('frontend.account.menu.profile.field.twelve')}}",//"ok # Identificación",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            people_type_identification_id_data: {
                                id: "people_type_identification_id",
                                name: "{{__('frontend.account.menu.profile.field.ten')}}",//ok
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
                                label: "{{__('frontend.account.menu.profile.field.business.name')}}",//ok "Razón Social",
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
                                label: "{{__('frontend.account.menu.profile.field.business.reason')}}",//ok"Razón Comercial",
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
                                label: "{{__('frontend.account.menu.profile.field.eleven')}}",//ok "Tipo de Ruc",
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
                                label: "{{__('frontend.account.menu.profile.field.thirteen')}}",//ok "Nacionalidad",
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
                                label: "{{__('frontend.account.menu.profile.field.fourteen')}}",//ok "Profesión",
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
                                label: "{{__('frontend.account.menu.profile.field.two')}}",//ok "Apellidos",
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
                                label: "{{__('frontend.account.menu.profile.field.one')}}",//ok "Nombres",
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
                                label: "{{__('frontend.account.menu.profile.field.sixteen')}}",// ok "Fecha Nacimiento",
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
                                label: "{{__('frontend.account.menu.profile.field.ten')}}",//"Edad",
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
                                label: "{{__('frontend.account.menu.profile.field.fifteen')}}",// ok "Género",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            /*  Address Information*/
                            countries_id: {
                                id: "countries_id",
                                name: "countries_id",
                                label: "{{__('address.one.title')}}",//ok "País",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            provinces_id: {
                                id: "provinces_id",
                                name: "provinces_id",
                                label: "{{__('address.two.title')}}",//ok "Estado/Provincia",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            cities_id: {
                                id: "cities_id",
                                name: "cities_id",
                                label: "{{__('address.three.title')}}",//ok "Ciudad",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            zones_id: {
                                id: "zones_id",
                                name: "zones_id",
                                label: "{{__('address.four.title')}}",//ok"Zona",
                                required:
                                    {
                                        allow: true,
                                        msj: "Campo requerido.",
                                        error: false
                                    }
                            },
                            street_one: {
                                id: "street_one",
                                name: "street_one",
                                label: "{{__('frontend.account.menu.profile.field.four.address.main')}}",//ok "Calle Principal",
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
                                label: "{{__('frontend.account.menu.profile.field.five.address.secondary')}}",//ok "Calle Secundaria",
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
                                label: "{{__('frontend.account.menu.profile.field.five.address.reference')}}",//ok "Referencia",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            has_location: {
                                id: "has_location",
                                name: "has_location",
                                label: "{{__('frontend.account.menu.profile.field.ten')}}",//"has location",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            options_map: {
                                id: "options_map",
                                name: "options_map",
                                label: "{{__('frontend.account.menu.profile.field.ten')}}",//"options map",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_phone_value: {
                                id: "information_phone_value",
                                name: "information_phone_value",
                                label: "{{__('frontend.account.menu.profile.field.three')}}",//ok "information_phone_value",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_one: {
                                id: "information_social_network_value_one",
                                name: "information_social_network_value_one",
                                label: "{{__('frontend.account.menu.profile.field.eighteen')}}",//"information_social_network_value_one",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_two: {
                                id: "information_social_network_value_two",
                                name: "information_social_network_value_two",
                                label: "{{__('frontend.account.menu.profile.field.nineteen')}}",// "information_social_network_value_two",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_three: {
                                id: "information_social_network_value_three",
                                name: "information_social_network_value_three",
                                label: "{{__('frontend.account.menu.profile.field.twentyone')}}",// "information_social_network_value_two",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_four: {
                                id: "information_social_network_value_four",
                                name: "information_social_network_value_four",
                                label: "{{__('frontend.account.menu.profile.field.twentytwo')}}",// "information_social_network_value_two",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_five: {
                                id: "information_social_network_value_five",
                                name: "information_social_network_value_five",
                                label: "{{__('frontend.account.menu.profile.field.twentythree')}}",// "information_social_network_value_two",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            information_social_network_value_six: {
                                id: "information_social_network_value_six",
                                name: "information_social_network_value_six",
                                label: "{{__('frontend.account.menu.profile.field.twentyfour')}}",// "information_social_network_value_two",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            user_by_about_us_description: {
                                id: "user_by_about_us_description",
                                name: "user_by_about_us_description",
                                label: "{{__('frontend.account.menu.profile.field.seven')}}",// "user_by_about_us_description",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                            user_by_about_us_web: {
                                id: "user_by_about_us_web",
                                name: "user_by_about_us_web",
                                label: "{{__('frontend.account.menu.profile.field.twenty')}}",// ok"user_by_about_us_web",
                                required: {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            },
                        };

                        return result;
                    },
                    getAttributesForm: function () {
                        var optionsMap = {
                            zoom: 6,
                            latLng: {

                                lat: latLngCurrent.lat,
                                lng: latLngCurrent.lng
                            }
                        };
                        var optionsMap = JSON.stringify(optionsMap);
                        var result = {
                            //PEOPLE
                            id: null,
                            last_name: null,
                            name: null,
                            birthdate: null,
                            business_id: this.business_id,
                            gender_data: $dataManagerPage['attributesFormDefault']['gender_data'],
                            //CUSTOMER
                            identification_document: null,
                            people_type_identification_id_data: $dataManagerPage['attributesFormDefault']['people_type_identification_id_data'],
                            business_name: null,
                            business_reason: null,
                            ruc_type_id_data: $dataManagerPage['attributesFormDefault']['ruc_type_id_any'],
                            //CUSTOMER INFORMATION
                            customer_id: null,
                            people_nationality_id_data: 71,
                            people_profession_id_data: 1,
                            customer_by_information: null,
                            people_id_data: null,
                            countries_id: $dataManagerPage['attributesFormDefault']['countries_id'],
                            provinces_id: $dataManagerPage['attributesFormDefault']['provinces_id'],
                            cities_id: $dataManagerPage['attributesFormDefault']['cities_id'],
                            zones_id: $dataManagerPage['attributesFormDefault']['zones_id'],
                            "street_one": null,
                            "street_two": null,
                            "reference": null,
                            "has_location": true,
                            "options_map": optionsMap,
                            "information_address_location_current": null,
                            information_address_type_id_data: $dataManagerPage['attributesFormDefault']['information_address_type_id_data'],
                            //phone
                            information_phone_id: null,
                            information_phone_value: null,//
                            information_phone_operator_id: $dataManagerPage['attributesFormDefault']['information_address_type_id_data'],
                            information_phone_type_id: $dataManagerPage['attributesFormDefault']['information_phone_type_id'],
                            'information_social_network_id_one': null,
                            'information_social_network_value_one': null,
                            'information_social_network_type_id_one': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_one'],//facebook 1

                            'information_social_network_id_two': null,
                            'information_social_network_value_two': null,
                            'information_social_network_type_id_two': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_two'],//instagram 2

                            'information_social_network_id_three': null,
                            'information_social_network_value_three': null,
                            'information_social_network_type_id_three': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_three'],//twitter 3

                            'information_social_network_id_four': null,
                            'information_social_network_value_four': null,
                            'information_social_network_type_id_four': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_four'],//linkedin 4

                            'information_social_network_id_five': null,
                            'information_social_network_value_five': null,
                            'information_social_network_type_id_five': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_five'],//youtube 5

                            'information_social_network_id_six': null,
                            'information_social_network_value_six': null,
                            'information_social_network_type_id_six': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_six'],//tiktok 6


                            customer_profile_by_location_id: null,
                            customer_by_profile_id: null,
                            users_by_about_us_id: null,
                            'user_by_about_us_description': null,
                            'user_by_about_us_web': null,
                            source: null,
                            change: false,
                        };

                        return result;
                    },
                    getNameAttribute: function (name) {
                        var result = this.formConfig.nameModel + "[" + name + "]";
                        return result;
                    },
                    getLabelForm: function (nameId) {
                        var resultLabel = viewGetLabelForm(nameId, this.model);
                        if (nameId == 'information_social_network_value_two') {
                            resultLabel = '<i class="fa fa-instagram"></i>' + resultLabel;
                        } else if (nameId == 'name') {
                            resultLabel = '<i class="fa fa-user-o"></i>' + resultLabel;
                        } else if (nameId == 'last_name') {
                            resultLabel = '<i class="fa fa-user-o"></i>' + resultLabel;

                        } else if (nameId == 'birthdate') {
                            resultLabel = '<i class="fa fa-calendar-o"></i>' + resultLabel;
                        } else if (nameId == 'business_reason') {
                            resultLabel = '<i class="fa fa-building"></i>' + resultLabel;
                        } else if (nameId == 'business_name') {
                            resultLabel = '<i class="fa fa-building"></i>' + resultLabel;
                        } else if (nameId == 'information_phone_value') {
                            resultLabel = '<i class="fa fa-phone"></i>' + resultLabel;
                        } else if (nameId == 'user_by_about_us_web') {
                            resultLabel = '<i class="fa fa-globe"></i>' + resultLabel;
                        } else if (nameId == 'street_one') {
                            resultLabel = '<i class="fa fa-map-marker"></i>' + resultLabel;
                        } else if (nameId == 'street_two') {
                            resultLabel = '<i class="fa fa-map-marker"></i>' + resultLabel;
                        } else if (nameId == 'information_social_network_value_one') {
                            resultLabel = '<i class="fa fa-facebook"></i>' + resultLabel;
                        }
                        return resultLabel;
                    },

                    _setValueForm: function (name, value) {
                        if (name == "people_type_identification_id_data") {
                            if (value == this.typeIdentificationRuc) {
                                this.$v["model"]["attributes"]["business_name"].$model = null;
                                this.$v["model"]["attributes"]["business_name"].$reset();
                                this.$v["model"]["attributes"]["business_reason"].$model = null;
                                this.$v["model"]["attributes"]["business_reason"].$reset();
                            }
                        }
                        this.model.attributes[name] = value;
                        this.$v["model"]["attributes"][name].$model = value;
                        this.$v["model"]["attributes"][name].$touch();
                    },
//Manager Model
                    getValuesSave: function () {
                        var information_address_location_current = typeof (this.$v.model.attributes.information_address_location_current.$model) == 'string' ? this.$v.model.attributes.information_address_location_current.$model : JSON.stringify(this.$v.model.attributes.information_address_location_current.$model);
                        ;
                        var result = {
                            //user
                            change: this.$v.model.attributes.change.$model,
                            source: this.$v.model.attributes.source.$model,
                            //CUSTOMER

                            id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                            customer_id: this.$v.model.attributes.customer_id.$model ? this.$v.model.attributes.customer_id.$model : -1,//key
                            identification_document: this.$v.model.attributes.identification_document.$model,
                            people_type_identification_id: this.$v.model.attributes.people_type_identification_id_data.$model,
                            business_name: this.$v.model.attributes.business_name.$model,
                            business_reason: this.$v.model.attributes.business_reason.$model,
                            ruc_type_id: this.$v.model.attributes.ruc_type_id_data.$model,
                            //CUSTOMER INFORMATION
                            people_nationality_id: this.$v.model.attributes.people_nationality_id_data.$model,
                            people_profession_id: this.$v.model.attributes.people_profession_id_data.$model,
                            //PEOPLE
                            people_id: this.$v.model.attributes.people_id_data.$model ? this.$v.model.attributes.people_id_data.$model : -1,//key
                            last_name: this.$v.model.attributes.last_name.$model,
                            name: this.$v.model.attributes.name.$model,
                            birthdate: moment(this.$v.model.attributes.birthdate.$model).format("YYYY-MM-DD"),
                            gender: this.$v.model.attributes.gender_data.$model,
                            business_id: this.$v.model.attributes.business_id.$model,
                            age: 0,
                            customer_by_information_id: this.$v.model.attributes.customer_by_information_id.$model ? this.$v.model.attributes.customer_by_information_id.$model : -1,//key
                            "information_address_type_id": 1,
                            "information_address_id": this.$v.model.attributes.information_address_id.$model ? this.$v.model.attributes.information_address_id.$model : -1,//key
                            "customer_by_profile_id": this.$v.model.attributes.customer_by_profile_id.$model ? this.$v.model.attributes.customer_by_profile_id.$model : -1,//key
                            "customer_profile_by_location_id": this.$v.model.attributes.customer_profile_by_location_id.$model ? this.$v.model.attributes.customer_profile_by_location_id.$model : -1,//key
                            //ABOUT
                            "users_by_about_us_id": this.$v.model.attributes.users_by_about_us_id.$model ? this.$v.model.attributes.users_by_about_us_id.$model : -1,//key
                            "zones_id": this.$v.model.attributes.zones_id.$model,
                            "street_one": this.$v.model.attributes.street_one.$model,
                            "reference": this.$v.model.attributes.reference.$model,
                            "street_two": this.$v.model.attributes.street_two.$model,
                            "has_location": 1,
                            "options_map": this.$v.model.attributes.options_map.$model,
                            "information_address_location_current": information_address_location_current,
                        };

                        result['information_social_network_id_one'] = this.$v.model.attributes.information_social_network_id_one.$model ? this.$v.model.attributes.information_social_network_id_one.$model : -1;//key
                        result['information_social_network_value_one'] = this.$v.model.attributes.information_social_network_value_one.$model;
                        result['information_social_network_type_id_one'] = this.$v.model.attributes.information_social_network_type_id_one.$model;

                        result['information_social_network_id_two'] = this.$v.model.attributes.information_social_network_id_two.$model ? this.$v.model.attributes.information_social_network_id_two.$model : -1;//key
                        result['information_social_network_value_two'] = this.$v.model.attributes.information_social_network_value_two.$model;
                        result['information_social_network_type_id_two'] = this.$v.model.attributes.information_social_network_type_id_two.$model;

                        var currentSocialNumber = 'three';
                        result['information_social_network_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model ? this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model : -1;//key
                        result['information_social_network_value_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_value_' + currentSocialNumber].$model;
                        result['information_social_network_type_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_type_id_' + currentSocialNumber].$model;


                         currentSocialNumber = 'four';
                        result['information_social_network_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model ? this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model : -1;//key
                        result['information_social_network_value_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_value_' + currentSocialNumber].$model;
                        result['information_social_network_type_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_type_id_' + currentSocialNumber].$model;

                        currentSocialNumber = 'five';
                        result['information_social_network_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model ? this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model : -1;//key
                        result['information_social_network_value_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_value_' + currentSocialNumber].$model;
                        result['information_social_network_type_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_type_id_' + currentSocialNumber].$model;


                        currentSocialNumber = 'six';
                        result['information_social_network_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model ? this.$v.model.attributes['information_social_network_id_' + currentSocialNumber].$model : -1;//key
                        result['information_social_network_value_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_value_' + currentSocialNumber].$model;
                        result['information_social_network_type_id_' + currentSocialNumber] = this.$v.model.attributes['information_social_network_type_id_' + currentSocialNumber].$model;

                        result['information_phone_id'] = this.$v.model.attributes.information_phone_id.$model ? this.$v.model.attributes.information_phone_id.$model : -1;//key
                        result['information_phone_value'] = this.$v.model.attributes.information_phone_value.$model;
                        result['information_phone_operator_id'] = this.$v.model.attributes.information_phone_operator_id.$model;
                        result['information_phone_type_id'] = this.$v.model.attributes.information_phone_type_id.$model;

                        result['users_by_about_us_id'] = this.$v.model.attributes.users_by_about_us_id.$model ? this.$v.model.attributes.users_by_about_us_id.$model : -1;
                        result['users_by_about_us_description'] = this.$v.model.attributes.user_by_about_us_description.$model;
                        result['users_by_about_us_web'] = this.$v.model.attributes.user_by_about_us_web.$model;


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

                                    if (response.success) {
                                        $scope.resetForm();
                                        $profileConfig = response.data;
                                        $scope.initManagement($profileConfig);
                                        $scope.managerCreate = true;

                                    } else {
                                        alert('error');
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
                        this.managerInformationAddress.allow = true;

                    },
                    _valuesForm: function (event) {
                        this.model.init = false;
                        this.validateForm();
                    },
                    validateForm: function () {
                        var currentAllow = this.getValidateForm();
                        console.log(currentAllow)
                        return currentAllow.success;
                    },
                    getValidateForm: function () {
                        var success = true;
                        var attributeCurrent = "";
                        var errors = [];
                        if (
                            this.$v.model["attributes"]["identification_document"]["$invalid"] ||
                            this.$v.model["attributes"]["people_type_identification_id_data"]["$invalid"] ||
                            this.$v.model["attributes"]["business_name"]["$invalid"] ||
                            this.$v.model["attributes"]["business_reason"]["$invalid"] ||
                            this.$v.model["attributes"]["ruc_type_id_data"]["$invalid"] ||
                            this.$v.model["attributes"]["people_nationality_id_data"]["$invalid"] ||
                            this.$v.model["attributes"]["last_name"]["$invalid"] ||
                            this.$v.model["attributes"]["name"]["$invalid"] ||
                            this.$v.model["attributes"]["birthdate"]["$invalid"] ||
                            this.$v.model["attributes"]["gender_data"]["$invalid"] ||
                            this.$v.model["attributes"]["information_phone_id"]["$invalid"] ||
                            this.$v.model["attributes"]["information_phone_value"]["$invalid"] ||
                            this.$v.model["attributes"]["information_phone_operator_id"]["$invalid"] ||
                            this.$v.model["attributes"]["information_phone_type_id"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_id_one"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_one"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_one"]["$invalid"] ||


                            this.$v.model["attributes"]["information_social_network_id_two"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_two"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_two"]["$invalid"] ||

                            this.$v.model["attributes"]["information_social_network_id_three"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_three"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_three"]["$invalid"] ||


                            this.$v.model["attributes"]["information_social_network_id_four"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_four"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_four"]["$invalid"] ||

                            this.$v.model["attributes"]["information_social_network_id_five"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_five"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_five"]["$invalid"] ||

                            this.$v.model["attributes"]["information_social_network_id_six"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_value_six"]["$invalid"] ||
                            this.$v.model["attributes"]["information_social_network_type_id_six"]["$invalid"] ||

                            this.$v.model["attributes"]["users_by_about_us_id"]["$invalid"] ||
                            this.$v.model["attributes"]["user_by_about_us_description"]["$invalid"] ||
                            this.$v.model["attributes"]["user_by_about_us_web"]["$invalid"] ||
                            this.$v.model["attributes"]["source"]["$invalid"]

                        ) {

                            if (this.$v.model["attributes"]["identification_document"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["identification_document"]
                                });
                            }
                            if (this.$v.model["attributes"]["people_type_identification_id_data"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["people_type_identification_id_data"]
                                });
                            }
                            if (this.$v.model["attributes"]["business_name"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["business_name"]
                                });
                            }
                            if (this.$v.model["attributes"]["business_reason"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["business_reason"]
                                });
                            }
                            if (this.$v.model["attributes"]["ruc_type_id_data"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["ruc_type_id_data"]
                                });
                            }
                            if (this.$v.model["attributes"]["people_nationality_id_data"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["people_nationality_id_data"]
                                });
                            }
                            if (this.$v.model["attributes"]["last_name"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["last_name"]
                                });
                            }
                            if (this.$v.model["attributes"]["name"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["name"]
                                });
                            }
                            if (this.$v.model["attributes"]["birthdate"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["birthdate"]
                                });
                            }

                            if (this.$v.model["attributes"]["gender_data"]["$invalid"]) {
                                errors.push({
                                    "type": "customer", "fields": ["gender_data"]
                                });
                            }

                            if (this.$v.model["attributes"]["information_phone_id"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_phone_id"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_phone_value"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_phone_value"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_phone_operator_id"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_phone_operator_id"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_phone_type_id"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_phone_type_id"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_id_one"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_one"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_one"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_one"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_one"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_one"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_id_one"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_one"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_two"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_two"]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_two"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_two"]
                                });
                            }
var currentSocialNumber='three';

                            if (this.$v.model["attributes"]["information_social_network_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_"+currentSocialNumber]
                                });
                            }

                             currentSocialNumber='four';

                            if (this.$v.model["attributes"]["information_social_network_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_"+currentSocialNumber]
                                });
                            }
                            currentSocialNumber='five';

                            if (this.$v.model["attributes"]["information_social_network_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_"+currentSocialNumber]
                                });
                            }
                            currentSocialNumber='six';

                            if (this.$v.model["attributes"]["information_social_network_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_id_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_value_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_value_"+currentSocialNumber]
                                });
                            }
                            if (this.$v.model["attributes"]["information_social_network_type_id_"+currentSocialNumber]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["information_social_network_type_id_"+currentSocialNumber]
                                });
                            }


                            if (this.$v.model["attributes"]["users_by_about_us_id"]["$invalid"]) {
                                errors.push({
                                    "type": "about_us", "fields": ["users_by_about_us_id"]
                                });
                            }
                            if (this.$v.model["attributes"]["user_by_about_us_description"]["$invalid"]) {
                                errors.push({
                                    "type": "about_us", "fields": ["user_by_about_us_description"]
                                });
                            }
                            if (this.$v.model["attributes"]["user_by_about_us_web"]["$invalid"]) {
                                errors.push({
                                    "type": "about_us", "fields": ["user_by_about_us_web"]
                                });
                            }
                            if (this.$v.model["attributes"]["source"]["$invalid"]) {
                                errors.push({
                                    "type": "information", "fields": ["source"]
                                });
                            }
                            success = false;

                        }

                        if (this.managerInformationAddress.allow) {
                            if (
                                this.$v.model.attributes.street_one.$invalid ||
                                this.$v.model.attributes.street_two.$invalid ||
                                this.$v.model.attributes.reference.$invalid ||
                                this.$v.model.attributes.options_map.$invalid
                            ) {
                                if (this.$v.model.attributes.street_one.$invalid) {
                                    errors.push({
                                        "fields": ["street_one"]
                                    });
                                }
                                if (this.$v.model.attributes.street_two.$invalid) {
                                    errors.push({
                                        "fields": ["street_two"]
                                    });
                                }
                                if (this.$v.model.attributes.reference.$invalid) {
                                    errors.push({
                                        "fields": ["reference"]
                                    });
                                }

                                if (this.$v.model.attributes.options_map.$invalid) {
                                    errors.push({
                                        "fields": ["options_map"]
                                    });
                                }
                                success = false;
                            }
                        }
                        var result = {
                            success: success,
                            errors: errors
                        };
                        return result;
                    },
                    _resetModel: function (model) {
                        model.$reset();
                    },
            onLinkProfile: function () {

                var dataSendResult = this.getValuesSave();
                console.log(dataSendResult);
            },
                    //Address Information
                    ...$managerGoogleMaps,

//manager image
                    initCropProfileImage: function (params) {
                        var $scope = this;

                        var paramsConfig = {
                            'selector': '#upload-demo',
                            'selectorContainerMain': '.upload-demo',
                            'selectorManagerInput': "#file-upload-profile-image",
                            '_onLoadImage': function (params) {
                                console.log('onload', params);

                            },
                            '_onUpdate': function (params) {
                                console.log(params);
                                params.event.stopPropagation();
                                if (this.imageInit) {
                                    //preload
                                    this.getResultImage({type: 'rawcanvas'}).then(result => {
                                            var inputFileManager = $($scope.managerCrop.selectorManagerInput)[0].files[0];
                                            if (inputFileManager) {

                                                var filename = inputFileManager.name;
                                                var type = inputFileManager.type;
                                                var urlCurrent = result.toDataURL();
                                                var mimeType = type;
                                                urlToFile(urlCurrent, filename, mimeType).then(result => {
                                                    var fileCurrent = result;
                                                    $scope.$v.model.attributes.source.$model = fileCurrent;
                                                    $scope.model.attributes.source = fileCurrent;
                                                    if ($scope.managerCreate) {
                                                        $scope.model.attributes.change = true;
                                                    }
                                                    $scope.managerCrop.initLoadFirst = true;
                                                });

                                            }
                                        }
                                    );
                                    this.imageInit = null;
                                } else {
                                    console.log('not init');
                                    this.getResultImage({type: 'rawcanvas'}).then(result => {
                                            var inputFileManager = $($scope.managerCrop.selectorManagerInput)[0].files[0];
                                            if (inputFileManager) {

                                                var filename = inputFileManager.name;
                                                var type = inputFileManager.type;
                                                var urlCurrent = result.toDataURL();
                                                var mimeType = type;
                                                urlToFile(urlCurrent, filename, mimeType).then(result => {
                                                    var fileCurrent = result;
                                                    $scope.$v.model.attributes.source.$model = fileCurrent;
                                                    $scope.model.attributes.source = fileCurrent;
                                                    if ($scope.managerCreate) {
                                                        $scope.model.attributes.change = true;
                                                    }
                                                    $scope.managerCrop.initLoadFirst = true;
                                                });
                                            }

                                        }
                                    );


                                }
                                return true;
                            },
                        };

                        this.managerCrop = {
                            selector: paramsConfig.selector,
                            selectorContainerMain: paramsConfig.selectorContainerMain,
                            selectorManagerInput: paramsConfig.selectorManagerInput,
                            initLoadFirst: false,

                        };


                        if ($scope.managerCreate) {
                            paramsConfig['imageInit'] = $scope.model.attributes.source;
                        }
                        paramsConfig['boundaryWidth'] = 300;
                        paramsConfig['boundaryHeight'] = 300;
                        paramsConfig['viewportWidth'] = 250;
                        paramsConfig['viewportHeight'] = 250;


                        initUploadCrop(paramsConfig);
                    },

                }

            })
    ;

</script>
