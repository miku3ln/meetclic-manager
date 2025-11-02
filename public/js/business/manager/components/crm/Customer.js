var componentThisCustomer;
var markers = [];
var markersClusterData = [];
var infoWindow = null;
//BUSINESS-MANAGER-CRM-ASSETS

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
var $configManagerProcessCurrent = {};
Vue.component('customer-component', {

    template: '#customer-template',
    components: {
        DateTimePicker: DateTimePicker
    },
    directives: {
        ...$directivesCustomer

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
        this.business_id = $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisCustomer = this;
        $configManagerProcessCurrent = $configPartial.resultProcess.data;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: validationsCustomer,
    data: function () {

        var dataManager = {

//**Modal*

            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": $buttonsManagements,
                "buttonsProcess": $buttonsProcess
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
            model: {//CUSTOMER-CREATE
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            formConfig: {//CUSTOMER-CREATE
                nameSelector: "#customer-form",
                url: $('#action-customer-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Cliente.',
                successMessage: 'El cliente se guardo correctamente.',
                nameModel: "Customer"
            },
            ...$dataManagerFieldsCustomer,//CUSTOMER-CREATE
            tabCurrentSelector: '#tab-customer',
            processName: "Registro Acción.",
            gridConfig: {
                selectorCurrent: "#customer-grid",
                url: $("#action-customer-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
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
            configModalDeliveryByBusinessManager: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            intervalForm: null,
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        ...$methodsManagerProcess,

        onEmmitOtherData: function (params) {

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
                            "   <span class='content-description__title'></span><span class='content-description__value center content-description__value--title'> Dirección</span>",
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
                        var phoneInformation = row.information_phone_id ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'></span><span class='content-description__value center content-description__value--title'> Telelfono/Personal</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + row.information_phone_type + "</span>",
                            "</div>",


                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'># Telefono:</span><span class='content-description__value'>" + row.information_phone_value + "</span>",
                            "</div>",
                        ] : [];
                        addressInformation = addressInformation.join('');
                        phoneInformation = phoneInformation.join('');

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
                            phoneInformation,

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
                }
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
            var entity_manager_id = $businessManager["id"];

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
                this.model.attributes.birthdate = moment(rowCurrent.birthdate).format("YYYY-MM-DD");
                this.model.attributes.gender_data = rowCurrent.gender;
                // CUSTOMER INFORMATION
                this.model.attributes.people_nationality_id_data = rowCurrent.people_nationality_id;
                this.model.attributes.people_profession_id_data = rowCurrent.people_profession_id;
                this.model.attributes.customer_by_information_id = rowCurrent.customer_by_information_id;
                this.model.attributes.information_address_id = null;
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

                } else {
                    this.model.attributes.information_address_id = null;
                    this.managerInformationAddress.allow = false;
                }
                this.model.attributes.information_phone_id = null;

                if (rowCurrent.information_phone_id) {
                    this.managerInformationPhone.allow = true;
                    this.model.attributes.information_phone_id = rowCurrent.information_phone_id;
                    this.model.attributes.information_phone_value = rowCurrent.information_phone_value;
                    this.model.attributes.information_phone_operator_id_data = {
                        id: rowCurrent.information_phone_operator_id,
                        text: rowCurrent.information_phone_operator
                    };
                    this.model.attributes.information_phone_type_id_data = {
                        id: rowCurrent.information_phone_type_id,
                        text: rowCurrent.information_phone_type
                    };


                } else {
                    this.model.attributes.information_phone_id = null;
                    this.managerInformationPhone.allow = false;


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
            } else if (params.managerType == "deliveryByBusinessManager") {
                var titleCurrent = rowCurrent.name + " " + rowCurrent.last_name;
                this.configModalDeliveryByBusinessManager.data = {
                    entity_id: rowId,
                    entity_manager_id: entity_manager_id,

                    rowCurrent: rowCurrent,
                    entity_type: 0,
                    labelsConfig: {
                        title: titleCurrent,
                        auxTitle: titleCurrent,

                    }
                };
                if (this.configModalDeliveryByBusinessManager.viewAllow) {
                    this.$refs.refInformationPhone._setValueOfParent(
                        {type: "openModal", data: this.configModalDeliveryByBusinessManager}
                    );
                } else {
                    this.configModalDeliveryByBusinessManager.viewAllow = true;
                }
            }
        },
        _managementSenMail: function () {
            this.configModalMailingByDataSend.viewAllow = true;
        },
        /*  EVENTS*/
        _viewManager: function (typeView, rowId) {
            _this = this;
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

                setTimeout(function () {
                    clearInterval(_this.intervalForm);
                    console.log('El temporizador se detuvo después de 1 segundo');
                }, 1000);
            } else if (typeView == 3) {//update
                this.showManager = true;
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        },
        /*FORM CUSTOMER-CREATE*/
        getViewErrorForm: function (objValidate) {
            var result = false
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }

            return result;
        },
        _submitForm: function (e) {//CUSTOMER-CREATE
            console.log(e);
        },
      ...$methodsCustomer,//CUSTOMER-CREATE
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
                            if (vCurrent.$v.model.attributes.id.$model) {
                                vCurrent._viewManager(2);
                            }
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent.resetForm();
                        }
                    }
                });
            }
        },
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
                console.log(valuesCurrent);
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
        ...$managerGoogleMaps,// CUSTOMER-CREATE

    }
})
;

