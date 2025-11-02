var componentThisCustomer;
var markers = [];
var markersClusterData = [];
var infoWindow = null;
var mcOptions = {

        //imagePath: pathDevelopers + "assets/images/cluster/",
        styles: [{
            height: 53,
            url: pathDevelopers + "assets/images/cluster/1.png",
            width: 53,
            fontFamily: "comic sans ms",
            textSize: 15,
            textColor: "red",
            //color: #00FF00,
        },
            {
                height: 56,
                url: pathDevelopers + "assets/images/cluster/2.png",
                width: 56,
                fontFamily: "comic sans ms",
                textSize: 15,
                textColor: "red",
                color: "#00FF00",
            },
            {
                height: 66,
                url: pathDevelopers + "assets/images/cluster/3.png",
                width: 66
            },
            {
                height: 78,
                url: pathDevelopers + "assets/images/cluster/4.png",
                width: 78
            },
            {
                height: 90,
                url: pathDevelopers + "assets/images/cluster/5.png",
                width: 90
            }]

    }
;
var markerCluster = null;

Vue.component('customer-component', {

    components: {
        DateTimePicker: DateTimePicker
    },
    template: '#customer-template',
    directives: {
        initS2CustomerSearch: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._customersList({
                    objSelector: el, filters: paramsInput.filters

                });


            }
        },
        resetModel: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._resetModel(paramsInput.model);
            },
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
        initMapSearchCustomers: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._initMap({
                    elementSelector: ".map-guests",
                    objSelector: $(el)[0],
                    data: paramsInput
                });

            }
        },
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);

        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisCustomer = this;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: function () {
        var attributes = {
                //CUSTOMER
                count_add: {required},
                main_add: {required},
                customer: {
                    required,
                    minLength: minLength(1),
                    $each: {
                        id: {},
                        customer_id: {},
                        business_id: {},
                        customer_by_information_id: {},
                        identification_document: {required},//
                        people_type_identification_id_data: {required},//
                        people_id_data: {},
                        business_name: {},
                        business_reason: {},
                        ruc_type_id_data: {},
                        //PEOPLE
                        last_name: {required},
                        name: {required},
                        birthdate: {required},
                        gender_data: {required},
                        // CUSTOMER INFORMATION
                        people_nationality_id_data: {required},
                        people_profession_id_data: {required},
//INFORMATION PHONE
                        information_phone_id: {},
                        information_phone_value: {required},
                        //INFORMATION EMAIL
                        information_mail_id: {},
                        information_mail_value: {},
                        /*Address Information*/
                        "information_address_id": {},
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
                        'information_address_location_current': {}
                    }
                },

            }
        ;

        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        var dataManager = {
            dataSave: [],
//**Modal*

            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    /*  {
                          "title": "Actualizar",
                          "data-placement": "top",
                          "i-class": " fas fa-pencil-alt",
                          "managerType": "updateEntity"
                      },*/
                    {
                        "title": "Direcciones",
                        "data-placement": "top",
                        "i-class": "fas fa-map-marker-alt",
                        "managerType": "addressEntity"
                    },
                    {
                        "title": "Telefonos",
                        "data-placement": "top",
                        "i-class": "fas fa-phone-square-alt",
                        "managerType": "phonesEntity"
                    },
                    {
                        "title": "Emails",
                        "data-placement": "top",
                        "i-class": "fas fa-envelope-open-text",
                        "managerType": "mailsEntity"
                    },
                    {
                        "title": "Redes Sociales",
                        "data-placement": "top",
                        "i-class": "fas fa-share-alt-square",
                        "managerType": "socialNetworksEntity"
                    },
                    {
                        "title": "Usuario",
                        "data-placement": "top",
                        "i-class": "fas fa-user-lock",
                        "managerType": "userEntity"
                    },
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {},
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-customer-data',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#customer-form",
                url: $('#action-customer-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Cliente.',
                successMessage: 'El cliente se guardo correctamente.',
                nameModel: "Customer"
            },
            gridConfig: {
                selectorCurrent: "#customer-grid",
                url: $("#action-customer-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            typeIdentificationRuc: 1,
            peopleNationalityData: $configPartial["dataCatalogue"]["peopleNationality"],
            peopleProfessionData: $configPartial["dataCatalogue"]["peopleProfession"],
            peopleTypeIdentificationData: $configPartial["dataCatalogue"]["peopleTypeIdentification"],
            rucTypeData: $configPartial["dataCatalogue"]["rucType"],
            genderData: [
                {value: 0, text: "HOMBRE"},
                {value: 1, text: "MUJER"},
                {value: 2, text: "LGBTI"},
                {value: 3, text: "OTROS"}
            ],
            managerInformationAddress: {
                allow: false,
                allowEdit: false,

            },
            managerCustomerSearch: {
                view: false,
                customersAll: [],
                map: null,
                viewLoading: true
            },
            business_id: null,
            //MODALS CONFIGURATION
            configModalInformationMail: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalInformationSocialNetwork: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalInformationPhone: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalInformationAddress: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalMailingByDataSend: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalEventByAssistance: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            }

        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        getNameAttributePeople: function (index, name) {
            var result = index + "_" + name;
            return result;
        },
        getLabelTitleRegister: function (index, modelData) {
            var isMain = modelData.main.$model;
            var result = "Registro " + (parseInt(index) + 1) + (modelData.main.$model ? (" Principal") : "");
            return result;
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
        initCurrentComponent: function () {
            this.initGridManager(this);

        },
        /*---MODAL CURRENT--*/
        _closeModal: function () {
            closeModal();
        },
        //MANAGER PROCESS
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
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_id: this.business_id
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
                    infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
                },
                css: getCSSCurrentBootGrid(),
                formatters: {
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

                        var description = (row.name !== "null" && row.name) ? [

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombres:</span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Apellidos:</span><span class='content-description__value'>" + (row.last_name) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo de Identificación:</span><span class='content-description__value'>" + (row.people_type_identification) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Identificación:</span><span class='content-description__value'>" + (row.identification_document) + "</span>",
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

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
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
                };
                result.push(setPush);
            });
            return result;
        },
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
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

                this._viewManager(3, rowId);

            } else if (params.managerType == "mailsEntity") {
                this.configModalInformationMail.data = {
                    entity_id: rowId,
                    entity_type: 0,
                    labelsConfig: {
                        title: 'Gestión de Emails. '
                    }
                };
                if (this.configModalInformationMail.viewAllow) {
                    this.$refs.refInformationMail._setValueOfParent(
                        {type: "openModal", data: this.configModalInformationMail}
                    );
                } else {
                    this.configModalInformationMail.viewAllow = true;
                }

            } else if (params.managerType == "phonesEntity") {

                this.configModalInformationPhone.data = {
                    entity_id: rowId,
                    entity_type: 0,
                    labelsConfig: {
                        title: 'Gestión de Telefonos. '
                    }
                };
                if (this.configModalInformationPhone.viewAllow) {
                    this.$refs.refInformationPhone._setValueOfParent(
                        {type: "openModal", data: this.configModalInformationPhone}
                    );
                } else {
                    this.configModalInformationPhone.viewAllow = true;
                }
            } else if (params.managerType == "socialNetworksEntity") {
                this.configModalInformationSocialNetwork.data = {
                    entity_id: rowId,
                    entity_type: 0,
                    labelsConfig: {
                        title: 'Gestión de Redes Sociales. '
                    }
                };
                if (this.configModalInformationSocialNetwork.viewAllow) {
                    this.$refs.refInformationSocialNetwork._setValueOfParent(
                        {type: "openModal", data: this.configModalInformationSocialNetwork}
                    );
                } else {
                    this.configModalInformationSocialNetwork.viewAllow = true;
                }

            } else if (params.managerType == "userEntity") {

            } else if (params.managerType == 'addressEntity') {

                this.configModalInformationAddress.data = {
                    entity_id: rowId,
                    entity_type: 0,
                    labelsConfig: {
                        title: 'Gestión de Direcciones. '
                    }
                };
                if (this.configModalInformationAddress.viewAllow) {
                    this.$refs.refInformationAddress._setValueOfParent(
                        {type: "openModal", data: this.configModalInformationAddress}
                    );
                } else {
                    this.configModalInformationAddress.viewAllow = true;
                }
            }
        },
        _managementSenMail: function () {
            this.configModalMailingByDataSend.viewAllow = true;
        },
        _managementEventAssistance: function () {
            this.configModalEventByAssistance.viewAllow = true;
        },
        /*  EVENTS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                $(this.gridConfig.selectorCurrent + "-header").hide();
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;
                $(this.gridConfig.selectorCurrent + "-footer").show();
                $(this.gridConfig.selectorCurrent + "-header").show();
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.showManager = true;
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
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
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                count_add: {
                    id: "count_add",
                    name: "count_add",
                    label: "# Invitados",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                main_add: {
                    id: "main_add",
                    name: "main_add",
                    label: "Representante",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                customer: {
                    main: {
                        id: "main",
                        name: "main",
                        label: "Es representante?",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
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
                    /*EMAIL INFORMATION*/
                    information_mail_value: {
                        id: "information_mail_value",
                        name: "information_mail_value",
                        label: "Correo Electronico",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    information_phone_value: {
                        id: "information_phone_value",
                        name: "information_phone_value",
                        label: "# Whatsapp",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    /*  Address Information*/
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
                    }
                },

            };

            return result;
        },
        getAttributesForm: function () {
            var result = {
                //PEOPLE
                count_add: 0,
                main_add: null,
                customer: []
            };

            return result;
        },
        getAttributesPeople: function () {
            var people_type_identification_id_data_others_id = 3;
            var result = {
                id: null,
                last_name: null,
                name: null,
                main: false,
                birthdate: '2021-06-06',
                business_id: this.business_id,
                gender_data: 0,
                //CUSTOMER
                identification_document: null,
                people_type_identification_id_data: people_type_identification_id_data_others_id,
                business_name: null,
                business_reason: null,
                ruc_type_id_data: null,
                information_phone_id: null,
                information_phone_value: null,
                information_mail_id: null,
                information_mail_value: null,

                //CUSTOMER INFORMATION
                customer_id: null,
                people_nationality_id_data: 71,
                people_profession_id_data: 1,
                customer_by_information: null,
                people_id_data: null,
                "street_one": null,
                "street_two": null,
                "reference": null,
                "has_location": false,
                "options_map": null,
                "information_address_location_current": null
            };
            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: function (nameId) {
            var labelName = '';
            if (nameId == 'count_add') {
                labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "*" : "");

            } else {
                labelName = this.model.structure['customer'][nameId].label + (this.model.structure['customer'][nameId].required.allow ? "*" : "");

            }
            return labelName;
        },
        _setValueForm: function (name, value) {
            $scope = this;
            if (name == "count_add") {
                var pushDataModel = $scope.getAttributesPeople();
                this.model.attributes['customer'] = [];
                this.dataSave = [];
                this.$v.model.attributes.customer = [];
                this.$v.model.attributes.customer.$reset();
                for (var i = 0; i < value; i++) {
                    $scope._addPeople();
                }

            }
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        _addPeople: function () {
            var people = this.getAttributesPeople();
            this.model.attributes.customer.push(people);

        },
        _setValueFormPeople: function (index, name, value, model) {
            $scope = this;
            if (name == "main") {//rerurn
                var haystack = this.$v.model.attributes['customer'].$model;
                $.each(haystack, function (index, valuesCurrent) {
                    $scope.$v.model.attributes['customer'].$model[index].main = false;
                });

            }
            this.model.attributes['customer'][index][name] = value;
            this.$v.model.attributes.customer.$model[index][name] = value;
            this.$v["model"]["attributes"]['customer']['$each'][index][name].$model = value;
            this.$v["model"]["attributes"]['customer']['$each'][index][name].$touch();
            model["$model"] = value;
            model.$touch();
        },
        getClassErrorForm: function (index, nameElement, objValidate) {
            var result = null;
            if (index == -1) {
                result = {
                    "form-group--error": objValidate.$error,
                    'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
                };
            } else {
                var objValidateCurrent = this.$v.model.attributes['customer']['$each'][index][nameElement];
                result = {
                    "form-group--error": objValidateCurrent.$error,
                    'form-group--success': objValidateCurrent.$dirty ? (!objValidateCurrent.$error) : false
                };
            }


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

            var $scope = this;
            var haystack = this.$v.model.attributes.customer.$model;
            var customerData = [];
            $.each(haystack, function (index, valuesCurrent) {
                var thisData = valuesCurrent;
                //CUSTOMER
                var setPushCurrent = {
                    id: thisData.id ? thisData.id : -1,
                    main: thisData.main,
                    identification_document: thisData.identification_document,
                    people_type_identification_id: thisData.people_type_identification_id_data,
                    people_id: thisData.people_id_data,
                    business_name: thisData.business_name,
                    business_reason: thisData.business_reason,
                    ruc_type_id: thisData.ruc_type_id_data,
                    //CUSTOMER INFORMATION
                    customer_id: thisData.customer_id ? thisData.customer_id : -1,
                    people_nationality_id: thisData.people_nationality_id_data,
                    people_profession_id: thisData.people_profession_id_data,
                    //PEOPLE
                    last_name: thisData.last_name,
                    name: thisData.name,
                    birthdate: moment(thisData.birthdate).format("YYYY-MM-DD"),
                    gender: thisData.gender_data,
                    business_id: thisData.business_id,
                    age: 0,
                    customer_by_information_id: thisData.customer_by_information_id ? thisData.customer_by_information_id : -1,
                    information_phone_id: thisData.information_phone_id ? thisData.information_phone_id : null,
                    information_phone_value: thisData.information_phone_value,
                    information_mail_id: thisData.information_mail_id ? thisData.information_mail_id : null,
                    information_mail_value: thisData.information_mail_value,

                };
                if (thisData.has_location) {
                    setPushCurrent["information_address_type_id"] = 1;
                    setPushCurrent["information_address_id"] = thisData.information_address_id ? thisData.information_address_id : -1;
                    setPushCurrent["street_one"] = thisData.street_one;
                    setPushCurrent["reference"] = thisData.reference;
                    setPushCurrent["street_two"] = thisData.street_two;
                    setPushCurrent["has_location"] = 1;
                    setPushCurrent["options_map"] = thisData.options_map;
                    setPushCurrent["information_address_location_current"] = thisData.information_address_location_current;

                }
                customerData.push(setPushCurrent);

            });

            var result = {
                Customer: customerData
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
                            vCurrent._resetManagerGrid();
                            vCurrent._viewManager(2);

                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent.resetForm();
                        } else {

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
            this.managerInformationAddress.allow = false;

        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            var haystack = this.$v.model.attributes.customer.$model;
            var allowOk = false;
            $.each(haystack, function (index, valuesCurrent) {
                if (valuesCurrent.main == 'on') {
                    allowOk = true;
                }
            });

            if (allowOk) {
                this._setValueForm('main_add', true);

            } else {
                this._setValueForm('main_add', null);

            }


            return currentAllow.success;
        },
        getValidateForm: getValidateForm,
        _resetModel: function (model) {
            model.$reset();
        },
        _initMapSearchCustomers: function (params) {
            var containerHeight = $('#app-management').height();
            containerHeight = containerHeight - containerHeight * 33.9 / 100
            $('.map-guests').css('height', containerHeight + 'px');
            var modelBusiness = $modelDataManager["business"][0];
            $('.pac-container').remove();
            var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                name: "Greyscale"
            });
            var mapOptions = {};
            var latLngCurrent = {lat: modelBusiness.street_lat, lng: modelBusiness.street_lng};

            var zoom = 7;


            var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
            mapOptions = {
                title: modelBusiness.title,
                panControl: true,
                scrollwheel: true,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                overviewMapControl: false,
                draggable: true,
                center: latLngCurrent,
                zoom: zoom,
                animation: google.maps.Animation.DROP,
                icon: icon_mapa_url

            };


            var objSelector = params.objSelector;
            var dataCurrent = params.data.model;
            var mapCurrent = new google.maps.Map(objSelector, mapOptions);
            var key = 1;

            var key_id = key;
            var info_name = modelBusiness.description ? modelBusiness.description : 'Ubicación de la Empresa.';
            var msg = key_id + " " + info_name;

            var width = 40, height = 40;
            var urlIcon = "https://furtaev.ru/preview/user_on_map.png";
            var iconCurrent = {
                url: urlIcon,
                scaledSize: new google.maps.Size(width, height), // scaled size
            };
            mapCurrent.mapTypes.set('greyscale_style', greyStyleMap);
            mapCurrent.setMapTypeId('greyscale_style');

            mapCurrent.setCenter(latLngCurrent);
            var paramsAutocomplete = {mapCurrent: mapCurrent, marker: null, dataCurrent: dataCurrent};
            this._initAutocomplete(paramsAutocomplete);
            this.managerCustomerSearch.map = mapCurrent;
            markerCluster = new MarkerClusterer(mapCurrent, null, mcOptions);


            var paramsSet = {
                'haystack': this.managerCustomerSearch.customersAll, map: mapCurrent
            };

            this._setMarkersView(paramsSet);

        },
        searchMarker: function (params) {
            var haystack = params['haystack'];
            var needle = params['needle'];
            var result = null;
            $.each(haystack, function (index, valuesCurrent) {

                if (valuesCurrent.id == needle) {
                    result = {index: index, value: valuesCurrent}
                    return result;

                }
            });

            return result;
        },
        _viewSearchCustomer: function (type) {
            if (type) {
                this.getAllCustomersInformationAddress();

            } else {
                this.managerCustomerSearch.view = false;
            }

        },
        _resetValuesMaps: function () {
            markers.map(function (value, key) {
                value.setMap(null);
            });
            markers = [];
            if (markerCluster) {

                markerCluster.clearMarkers();
            }
        },
        _setMarkersView: function (params) {
            var _this = this;
            var haystack = params.haystack;
            var mapCurrent = params.map;
            $.each(haystack, function (index, valuesCurrent) {


                var title = valuesCurrent["text"];
                var description = valuesCurrent.description != null ? valuesCurrent.description : "Sin descripcion";
                var options_map = valuesCurrent["options_map"];
                options_map = jQuery.parseJSON(options_map);
                var currentId = valuesCurrent.id;
                var needle = currentId;

                var searchMarker = _this.searchMarker({
                    haystack: markers,
                    'needle': needle,
                });

                if (searchMarker == null) {


                    var urlIcon = getRouteTypeIcon(0);
                    var lat = parseFloat(options_map["latLng"].lat);
                    var lng = parseFloat(options_map["latLng"].lng);
                    var address = valuesCurrent.street_one + " y " + valuesCurrent.street_two + ',' + valuesCurrent.reference + ".";
                    var content = [
                        '<div class="window-info-details">',
                        '      <div class="content-information">',
                        '           <div class="content-information__title"><h3 class="window-info-details__title">' + title + '</h3></div>',
                        '        <div class="content-information__description"><div class="content-information__description-title">Nacionalidad: </div><div class="content-information__description-value">' + valuesCurrent['people_profession'] + '</div></div>',
                        '        <div class="content-information__description"><div class="content-information__description-title">Profesion: </div><div class="content-information__description-value">' + valuesCurrent['people_nationality'] + '</div></div>',
                        valuesCurrent['mail'] ? '        <div class="content-information__description"><div class="content-information__description-title">Email: </div><div class="content-information__description-value">' + valuesCurrent['mail'] + '</div></div>' : '',
                        '        <div class="content-information__description"><div class="content-information__description-title">Direccion: </div><div class="content-information__description-value">' + address + '</div></div>',

                        '      </div>',

                        '</div>'
                    ].join("");
                    var width = 30, height = 40;

                    var iconCurrent = {
                        url: urlIcon,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var marker_object = new google.maps.Marker({
                        draggable: false,
                        title: title,
                        animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(lat, lng),
                        icon: iconCurrent,
                        content: content,
                        map: mapCurrent,
                        id: currentId,
                        options_map: options_map
                    });
                    markers.push(marker_object);
                    var eventMarkerParams = {
                        marker: marker_object,
                        mapCurrent: mapCurrent,
                        data: [],
                        'allowManager': false
                    };
                    _this._markersCurrent(eventMarkerParams);
                    markerCluster.addMarker(marker_object);
                }

            });

        },
        _customersList: function (params) {
            var el = params.objSelector;
            _this = this;
            var allowGet = false;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione un Cliente.",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-customer-getListS2InformationAddress").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
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
                width: '100%'
            });
            elementInit.on('select2:select', function (e) {
                var dataCurrent = elementInit.select2('data');
                var dataSelect = e.params.data;
                var needle = dataSelect.id;
                var searchMarker = _this.searchMarker({
                    haystack: markers,
                    'needle': needle,
                });
                if (searchMarker) {
                    var marker = searchMarker['value'];
                    var mapCurrent = _this.managerCustomerSearch.map;
                    var currentLtLng = new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng());
                    mapCurrent.panTo(currentLtLng);
                    mapCurrent.setZoom(17);
                } else {
                    if (dataCurrent.length != 0) {
                        var paramsSet = {
                            'haystack': dataCurrent, map: _this.managerCustomerSearch.map
                        };
                        _this._setMarkersView(paramsSet);

                    }
                }


            }).on("select2:unselecting", function (e) {


            }).on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length == 0) {

                    _this._resetValuesSelect2();
                }

            });


        },
        _resetValuesSelect2: function () {
            this._resetValuesMaps();
            var paramsSet = {
                'haystack': this.managerCustomerSearch.customersAll, map: this.managerCustomerSearch.map
            };
            this._setMarkersView(paramsSet);

        },
        getAllCustomersInformationAddress: function (selectChangeEmpty) {
            this._resetValuesMaps();
            this.managerCustomerSearch.viewLoading = true;
            var dataSend = {
                filters: {
                    business_id: this.business_id
                }
            };
            var vCurrent = this;
            getData({
                url: $('#action-customer-getListAllInformationAddress').val(),
                dataSend: dataSend,
                type: 'POST',
                blockElement: vCurrent.tabCurrentSelector
            }).then(response => {
                vCurrent.managerCustomerSearch.viewLoading = false;
                vCurrent.managerCustomerSearch.customersAll = response;
                vCurrent.managerCustomerSearch.view = true;

            }).catch(response => {

            });

        },
//Address Information
        ...$managerGoogleMaps




    }
})
;

