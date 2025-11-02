var componentThisPatient;
Vue.component('patient-component', {
    template: '#patient-template',
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
        var $scope = this;
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

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id = $businessManager.id;//this.configParams.business_id;
        this.manager_id = this.business_id;
    },
    mounted: function () {
        componentThisPatient = this;
        this.initCurrentComponent();
        removeClassNotView();
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
            has_representative: {},
            representative_fullname: {},

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
            //ABOUT US
            'users_by_about_us_id': {},//UPDATE
            'user_by_about_us_description': {required},
            'user_by_about_us_web': {},
            customer_by_profile_id: {},
            //USER
            source: {},
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
        if (this.model.attributes.has_representative) {
            attributes["representative_fullname"] = {required};

        } else {
            attributes["representative_fullname"] = {};

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
            manager_id: null,
            manager_key_name: 'business_id',
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Historial Clinico",
                        "data-placement": "top",
                        "i-class": "far fa-hospital",
                        "managerType": "managementHistoryClinic"
                    },
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Informacion",
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
            tabCurrentSelector: '.content-form',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#patient-form",
                url: $('#action-patient-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Patient.',
                successMessage: 'El Patient se guardo correctamente.',
                nameModel: "Patient"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#patient-grid",
                url: $("#action-patient-getAdmin").val()
            },
            managerViews: {
                createUpdate: false,
                admin: true,

            },
            managerType: null,
            //OPTIONS CRM

            typeIdentificationRuc: $dataManagerPage['attributesFormDefault']['typeIdentificationRuc'],
            peopleNationalityData: $dataManagerPage["dataCatalogue"]["peopleNationality"],
            peopleProfessionData: $dataManagerPage["dataCatalogue"]["peopleProfession"],
            peopleTypeIdentificationData: $dataManagerPage["dataCatalogue"]["peopleTypeIdentification"],
            rucTypeData: $dataManagerPage["dataCatalogue"]["rucType"],
            genderData: [
                {value: 0, text: "HOMBRE"},
                {value: 1, text: "MUJER"},
                {value: 2, text: "LGBTI"},
                {value: 3, text: "OTROS"}
            ],
            managerInformationAddress: {
                allow: true,
                allowEdit: true,
            },
            countriesData: [],
            provincesData: [],
            citiesData: [],
            zonesData: [],
            //load image
            managerCreate: false,
            configDataAntecedentByHistoryClinic: {
                ready: false,
                viewLoading: true,
                contentManagement: '.tabs',
                urlManager: {
                    createUpdate: $('#action-antecedent-by-history-clinic-saveData').val(),
                    getData: $('#action-antecedent-by-history-clinic-getAdmin').val()
                },
                loadingMessage: 'Cargando...',
                errorMessage: 'Error al cargar informacion.',
                successMessage: '',
                data: [],
                viewAllow: false,
                msg: {
                    'success': 'Se Registro correctamente.',
                    'error': 'No se Registro la informacion.',
                    'management': 'Gestionando.....',

                }
            },
            configDataMedicalConsultationByPatient: {
                ready: false,
                viewLoading: true,
                contentManagement: '.tabs',
                urlManager: {
                    createUpdate: $('#action-antecedent-by-history-clinic-saveData').val(),
                    getData: $('#action-antecedent-by-history-clinic-getAdmin').val()
                },
                loadingMessage: 'Cargando...',
                errorMessage: 'Error al cargar informacion.',
                successMessage: '',
                data: [],
                viewAllow: false,
                msg: {
                    'success': 'Se Registro correctamente.',
                    'error': 'No se Registro la informacion.',
                    'management': 'Gestionando.....',

                }
            },
            configDataPatient: {
                viewAllow: true,
                data: null
            },

            configDataTreatmentByPatient: {
                ready: false,
                viewLoading: true,
                contentManagement: '.tabs',
                urlManager: {
                    createUpdate: $('#action-antecedent-by-history-clinic-saveData').val(),
                    getData: $('#action-antecedent-by-history-clinic-getAdmin').val()
                },
                loadingMessage: 'Cargando...',
                errorMessage: 'Error al cargar informacion.',
                successMessage: '',
                data: [],
                viewAllow: false,
                msg: {
                    'success': 'Se Registro correctamente.',
                    'error': 'No se Registro la informacion.',
                    'management': 'Gestionando.....',

                }
            },
            configDataOdontogramByPatient: {
                ready: false,
                viewLoading: true,
                contentManagement: '.tabs',
                urlManager: {
                    createUpdate: $('#action-antecedent-by-history-clinic-saveData').val(),
                    getData: $('#action-antecedent-by-history-clinic-getAdmin').val()
                },
                loadingMessage: 'Cargando...',
                errorMessage: 'Error al cargar informacion.',
                successMessage: '',
                data: [],
                viewAllow: false,
                msg: {
                    'success': 'Se Registro correctamente.',
                    'error': 'No se Registro la informacion.',
                    'management': 'Gestionando.....',

                }
            },
            rowData: null,
            patientData: {
                header: '',
                information: '',
                'clinicalSummary': {
                    'antecedents': ''
                }
            },
            ageCurrent: '',
            processName:{
                'one':'Datos Informativos',
                'two':'Contactarse',
                'three':'Direccion',

            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initGridManager(this);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
                elementSelect: elementSelect,

            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            var business = {
                id: this.manager_id
            };
            this.rowData = rowCurrent;
            var $scope = this;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.customer_id = rowCurrent.customer_id;
                this.model.attributes.business_id = rowCurrent.business_id;
                this.model.attributes.identification_document = rowCurrent.identification;
                this.model.attributes.people_type_identification_id_data = rowCurrent.people_type_identification_id;
                this.model.attributes.people_id_data = rowCurrent.people_id;
                this.model.attributes.business_name = rowCurrent.business_name;
                this.model.attributes.has_representative = rowCurrent.has_representative == 1 ? true : false;
                this.model.attributes.representative_fullname = rowCurrent.representative_fullname;

                this.model.attributes.business_reason = rowCurrent.business_reason;
                this.model.attributes.ruc_type_id_data = rowCurrent.ruc_type_id;
                //PEOPLE
                this.model.attributes.last_name = rowCurrent.last_name;
                this.model.attributes.name = rowCurrent.first_name;
                this.model.attributes.birthdate = rowCurrent.birthdate;

                var year = rowCurrent.birthdate.split('-')[0];
                var ageCurrent = calcAge(year);
                this.model.structure['birthdate']['labelText'] = ageCurrent + ' Años.';
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
                    this.model.attributes.has_location = rowCurrent.has_location == 1 ? true : false;
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
                if (rowCurrent.hasOwnProperty('information_phone_id')) {
                    this.model.attributes.information_phone_id = rowCurrent.information_phone_id;
                    this.model.attributes.information_phone_value = rowCurrent.information_phone_value;
                    this.model.attributes.information_phone_operator_id = rowCurrent.information_phone_operator_id;
                    this.model.attributes.information_phone_type_id = rowCurrent.information_phone_type_id;

                }


                this._viewManager(3, rowId);


            } else if (params.managerType == "managementHistoryClinic") {
                this.initPartialsClinical({
                    historyClinic: rowCurrent,
                    business: business
                });
                this._viewManager(4, rowCurrent);
                this.configDataPatient.viewAllow = true;
                $scope.configDataPatient.data = {historyClinic: rowCurrent, business: business};
            }
        },
        initPartialsClinical: function (params) {
            var historyClinic = params.historyClinic;
            var patientHeader = [
                "<div class='content-description__information-process'>",
                "   <span class='content-description__title-process'>Nombres:</span><span class='content-description__value-process'>" + (historyClinic.first_name) + ' ' + (historyClinic.last_name) + "</span>",
                "</div>",
                "<div class='content-description__information-process'>",
                "   <span class='content-description__title-process'>Identificación:</span><span class='content-description__value-process'>" + (historyClinic.identification) + "</span>",
                "</div>",

            ];
            this.patientData.header = patientHeader.join('');
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {

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

                    var description = (row.first_name !== "null" && row.first_name) ? [

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Nombres:</span><span class='content-description__value'>" + (row.first_name) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Apellidos:</span><span class='content-description__value'>" + (row.last_name) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Tipo de Identificación:</span><span class='content-description__value'>" + (row.people_type_identification) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Identificación:</span><span class='content-description__value'>" + (row.identification) + "</span>",
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

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        resetManagerViews: function () {
            this.managerViews = {
                createUpdate: false,
                admin: true,
                management: false
            };
        },
        _viewManager: function (typeView) {
            this.resetManagerViews();
            if (typeView == 1) {//create
                this.managerViews.createUpdate = true;
                this.managerViews.admin = false;

                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.managerViews.admin = true;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: false,
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.managerViews.createUpdate = true;
                this.managerViews.admin = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.managerMenuConfig.view = false;
                this.onInitEventClickTimerForm();//CHANGE-FORM

            } else if (typeView == 4) {//management

                $scope = this;
                $scope.managerViews.management = true;
                $scope.managerViews.admin = false;
                showHideGridHeaderFooter({
                    selectorGrid: $scope.gridConfig.selectorCurrent,
                    hide: true,
                });
            }
            this.managerType = typeView;
        },
//FORM CONFIG
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
                has_representative: {
                    id: "has_representative",
                    name: "has_representative",
                    label: "Tiene Representante?",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                representative_fullname: {
                    id: "representative_fullname",
                    name: "representative_fullname",
                    label: "Nombre Completo Representante?",
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
                    labelText: "",

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
                countries_id: {
                    id: "countries_id",
                    name: "countries_id",
                    label: "País",
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
                    label: "Estado/Provincia",
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
                    label: "Ciudad",
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
                    label: "Zona",
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
                information_phone_value: {
                    id: "information_phone_value",
                    name: "information_phone_value",
                    label: "Celular",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                information_social_network_value_one: {
                    id: "information_social_network_value_one",
                    name: "information_social_network_value_one",
                    label: "Facebook",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                information_social_network_value_two: {
                    id: "information_social_network_value_two",
                    name: "information_social_network_value_two",
                    label: "",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                user_by_about_us_description: {
                    id: "user_by_about_us_description",
                    name: "user_by_about_us_description",
                    label: "Sobre Ti.",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                user_by_about_us_web: {
                    id: "user_by_about_us_web",
                    name: "user_by_about_us_web",
                    label: "# Telf Convencional",
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
                representative_fullname: null,
                has_representative: false,

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
                "options_map": null,
                "information_address_location_current": null,
                information_address_type_id_data: $dataManagerPage['attributesFormDefault']['information_address_type_id_data'],
                //phone
                information_phone_id: null,
                information_phone_value: null,//
                information_phone_operator_id: $dataManagerPage['attributesFormDefault']['information_address_type_id_data'],
                information_phone_type_id: $dataManagerPage['attributesFormDefault']['information_phone_type_id'],
                'information_social_network_id_one': null,
                'information_social_network_value_one': null,
                'information_social_network_type_id_one': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_one'],//facebook
                'information_social_network_id_two': null,
                'information_social_network_value_two': null,
                'information_social_network_type_id_two': $dataManagerPage['attributesFormDefault']['information_social_network_type_id_two'],
                customer_profile_by_location_id: null,
                customer_by_profile_id: null,
                users_by_about_us_id: null,
                'user_by_about_us_description': 'Config information default not about',
                'user_by_about_us_web': null,
                source: null,
                change: false,

            };

            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,
        _setValueForm: function (name, value) {
            if (name == "people_type_identification_id_data") {
                if (value == this.typeIdentificationRuc) {
                    this.$v["model"]["attributes"]["business_name"].$model = null;
                    this.$v["model"]["attributes"]["business_name"].$reset();
                    this.$v["model"]["attributes"]["business_reason"].$model = null;
                    this.$v["model"]["attributes"]["business_reason"].$reset();
                }
            } else if (name == 'birthdate') {
                var year = value.split('-')[0];
                var ageCurrent = calcAge(year);
                this.model.structure[name]['labelText'] = ageCurrent + ' Años.';


            }
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {
            var information_address_location_current = typeof (this.$v.model.attributes.information_address_location_current.$model) == 'string' ? this.$v.model.attributes.information_address_location_current.$model : JSON.stringify(this.$v.model.attributes.information_address_location_current.$model);

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
                has_representative: this.$v.model.attributes.has_representative.$model == null ? 0 : (this.$v.model.attributes.has_representative.$model ? 1 : 0),
                representative_fullname: this.$v.model.attributes.representative_fullname.$model,

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
                            $scope._resetManagerGrid();
                            $scope.resetForm();
                            $($scope.gridConfig.selectorCurrent).bootgrid("reload");

                            $scope._viewManager(2);
                        }
                    }
                }, true);
            }
        },
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

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
//others functions

        /*CRM*/
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
                    'options_map': '',

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
        _setValueSelect: function (field, value) {
            if (field == 'countries_id') {
                this._setValueForm('provinces_id', null);
                this._setValueForm('cities_id', null);
                this._setValueForm('zones_id', null);
                this.provincesData = this.countriesData[value]['data'];
                this.citiesData = [];
                this.zonesData = [];
            } else if (field == 'provinces_id') {
                var dataSet = [];
                if (value != undefined) {
                    dataSet = this.provincesData[value]['data'];
                }
                this.citiesData = dataSet;
                this.zonesData = [];

                this._setValueForm('cities_id', null);
                this._setValueForm('zones_id', null);


            } else if (field == 'cities_id') {
                var dataSet = [];
                if (value != undefined) {
                    dataSet = this.citiesData[value]['data'];
                }
                this._setValueForm('zones_id', null);
                this.zonesData = dataSet;
            } else if (field == 'zones_id') {

            }


            this._setValueForm(field, value);
        },
        //Address Information
        ...$managerGoogleMaps,

//manager image
        initCropProfileImage: function (params) {
            var $scope = this;

            function initManagement(urlCurrent, filename, mimeType) {
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

            var paramsConfig = {
                'selector': '#upload-demo',
                'selectorContainerMain': '.upload-demo',
                'selectorManagerInput': "#file-upload-profile-image",
                '_onLoadImage': function (params) {
                    console.log('_onLoadImage', params);

                },
                '_onUpdate': function (params) {
                    console.log(params, '_onUpdate');
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
                                    initManagement(urlCurrent, filename, mimeType);

                                }
                            }
                        );
                        this.imageInit = null;
                    } else {

                        this.getResultImage({type: 'rawcanvas'}).then(result => {
                                var inputFileManager = $($scope.managerCrop.selectorManagerInput)[0].files[0];
                                if (inputFileManager) {

                                    var filename = inputFileManager.name;
                                    var type = inputFileManager.type;
                                    var urlCurrent = result.toDataURL();
                                    var mimeType = type;
                                    initManagement(urlCurrent, filename, mimeType);
                                } else if ($scope.managerCreate == false) {
                                    var filename = 'image-default';
                                    var type = 'png';
                                    var urlCurrent = result.toDataURL();
                                    var mimeType = type;
                                    initManagement(urlCurrent, filename, mimeType);
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
            if ($scope.managerCreate == false) {
                /*    paramsConfig['imageInit'] =       '/images/profile-not-image.png';
                    var valueImage= $publicAsset +'/images/profile-not-image.png';
                    $($scope.managerCrop.selectorManagerInput).val(valueImage);*/

            }
            paramsConfig['boundaryWidth'] = 300;
            paramsConfig['boundaryHeight'] = 300;
            paramsConfig['viewportWidth'] = 250;
            paramsConfig['viewportHeight'] = 250;
            initUploadCrop(paramsConfig);
        },
        resetConfigManagementProcess: function () {
            this.configDataAntecedentByHistoryClinic.data = [];
            this.configDataAntecedentByHistoryClinic.viewAllow = false;
            this.configDataMedicalConsultationByPatient.data = [];
            this.configDataMedicalConsultationByPatient.viewAllow = false;
            this.configDataTreatmentByPatient.data = [];
            this.configDataTreatmentByPatient.viewAllow = false;

            this.configDataOdontogramByPatient.data = [];
            this.configDataOdontogramByPatient.viewAllow = false;
            this.configDataPatient.viewAllow = false;
            this.configDataPatient.data = null;

        },
        _managementProcess: function (type) {

            $scope = this;
            var business = {
                id: this.manager_id
            };
            var row = $scope.rowData;
            this.resetConfigManagementProcess();
            if (type == 1) {
                var managementCurrent = $scope.configDataAntecedentByHistoryClinic;
                $scope.configDataAntecedentByHistoryClinic.data = row;
                var dataSend = {history_clinic_id: row.id};
                ajaxRequestManager(managementCurrent.urlManager.getData, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: '.content',//opcional: es para bloquear el elemento
                    loading_message: managementCurrent.loadingMessage,
                    error_message: managementCurrent.errorMessage,
                    success_message: managementCurrent.successMessage,
                    success_callback: function (response) {
                        if (response.success) {
                            console.log(response);
                            $scope.configDataAntecedentByHistoryClinic.viewAllow = true;
                            $scope.configDataAntecedentByHistoryClinic.data = {
                                antecedents: response.data,
                                historyClinic: row
                            };


                        }
                    }
                });
            } else if (type == 2) {
                $scope.configDataMedicalConsultationByPatient.data = {historyClinic: row, business: business};
                $scope.configDataMedicalConsultationByPatient.viewAllow = true;


            } else if (type == 3) {
                $scope.configDataTreatmentByPatient.data = {historyClinic: row, business: business};
                $scope.configDataTreatmentByPatient.viewAllow = true;


            } else if (type == 4) {
                $scope.configDataOdontogramByPatient.data = {historyClinic: row, business: business};
                $scope.configDataOdontogramByPatient.viewAllow = true;


            } else if (type == 0) {
                this.configDataPatient.viewAllow = true;
                $scope.configDataPatient.data = {historyClinic: row, business: business};


            }
        },
        _updatePatient: function () {

        },


    }
})
;

