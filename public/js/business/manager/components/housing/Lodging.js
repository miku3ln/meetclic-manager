var deleteData = [];
var componentThisLodging;
var $latLngCurrent = {lat: 0.2314799, lng: -78.271874};
var $managerGeocoderAddressComponent = {
    'country_code_id': 'ChIJ1UuaqN2HI5ARAjecEQSvdp0',
    'administrative_area_level_1': 'ChIJXTdbeKE8Ko4Ra1N65thz2_c',
    'administrative_area_level_2': 'ChIJ8WXUfPdrKo4R2h0TE4mhAto',
    'administrative_area_level_3': '',
    options_map: {
        zoom: 15,
        latLng: {lat: $latLngCurrent.lat, lng: $latLngCurrent.lng}
    }
};
var lodgingComponent = Vue.component('lodging-component', {

        components: {
            DateTimePicker: DateTimePicker
        },
        template: '#lodging-template',
        directives: {
            initMapLodging: {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    if (paramsInput.v.has_information_additional.$model) {
                        paramsInput._initMap({
                            elementSelector: ".map-guests",
                            objSelector: $(el)[0],

                            data: paramsInput
                        });
                    }
                }
            },
            initS2: {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput._customersList({
                        objSelector: el, filters: paramsInput.filters

                    });


                }
            },
            'init-autocomplete-google': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod(paramsInput.params);


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
            this.businessId = $businessManager.id;// this.configParams.business_id;
        },
        mounted: function () {
            componentThisLodging = this;
            this.initCurrentComponent();
            removeClassNotView();
        },

        validations: function () {
            var attributes = null;

            attributes = {
                id: {},
                entry_at_data: {
                    required,
                },
                status_delivery: {},
                output_at_data: {},
                number_people: {
                    required,
                    minValue: minValue(1),

                },
                adults: {},
                children: {},
                number_rooms: {
                    required,
                    minValue: minValue(1),

                },
                total_value: {
                    required,
                    minValue: minValue(0),
                },
                payment_made: {},
                description: {},
                status: {},
                mainAdd: {},
                mainAddAllow: {},
                way_to_pay: {required},
                type_credit_card: {required},
                people: {
                    required,
                    minLength: minLength(1),
                    $each: {
                        allowAddPeopleS2: {},
                        people_id: {},
                        customer_id: {},
                        customer_by_information_id: {},
                        last_name: {
                            required
                        },
                        name: {
                            required
                        },
                        type_document: {
                            required,
                        },
                        document_number: {
                            required,
                        },
                        age: {
                            required,
                            minValue: minValue(0),
                        },
                        gender: {
                            required
                        },
                        //LodgingByCustomer
                        lodging_by_customer_id: {},
                        main: {},
                        has_information_additional: {},
                        people_nationality_id: {required},
                        people_profession_id: {required},
                        //LodgingCustomerAdditionalInformation
                        lodging_customer_additional_information_id: {},
                        information_mail_id: {},
                        information_phone_id: {},
                        information_mobile_id: {},
                        phone: {},
                        mobile: {},
                        mail: {required, email},
                        postal_code: {},
                        //LodgingByCustomerLocation
                        lodging_by_customer_location: {},
                        information_address_location_current_id: {}
                    }
                }
            };

            var result = {
                model: {//change
                    attributes: attributes
                },
            };
            return result;

        },
        data: function () {

            var dataManager = {
                createUpdate: false,
//**Modal*
                configModalLodgingRoomsState: {
                    title: "Title",
                    viewAllow: false,
                    data: []

                },
                configModalLodgingByPayment: {
                    title: "Title",
                    viewAllow: false,
                    data: []

                },
                configModalLodgingByArrived: {
                    title: "Title",
                    viewAllow: false,
                    data: []

                },
                configModalLodgingByTypeOfRoom: {
                    title: "Title",
                    viewAllow: false,
                    data: []

                },
                configModalLodgingDelivery: {
                    title: "Title",
                    viewAllow: false,
                    data: []

                },
                /*  ----MANAGER ENTITY---*/
                configModelEntity: $configModelEntityLodging,
                managerMenuConfig: {
                    view: false,
                    menuCurrent: [],
                    rowId: null
                },
                date: null,
                configParams: {},
                labelsConfig: {
                    "guest": "Huespedes Ingreso",
                    button: {
                        "guest": "Crear Huesped",
                        cancel: "Cancelar",
                        viewRoomsState: "Habitaciones",
                    },
                    manager: {
                        guest: "Huesped #  "
                    },
                    process: {
                        information: "Información Hospedaje",
                        guests: "Huespedes Ingreso",
                        address: "Dirección",
                        payment: "Pago Gestión",

                    }
                },
                lblBtnSave: "Guardar",
                lblBtnClose: "Cerrar",
                model: {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm(),
                },
                tabCurrentSelector: '#tab-lodging',
                processName: "Registro de Huespedes.",
                formConfig: {
                    nameSelector: "#business-by-lodging-form",
                    url: $('#action_lodging_save').val(),
                    loadingMessage: 'Guardando...',
                    errorMessage: 'Error al guardar el ' + this.processName,
                    successMessage: 'La tarjeta de registro se guardo correctamente.',
                    nameModel: "Lodging"
                },
                gridConfig: {
                    selectorCurrent: "#lodging-grid",
                    url: $("#action_lodging_admin").val(),
                    initGrid: false
                },
                submitStatus: "no",
                showManager: false,
                businessId: null,
                optionsTypeRooms: [],
                optionsPeopleNationality: $configPartial["dataCatalogue"]["peopleNationality"],
                optionsTypeDocument: $configPartial["dataCatalogue"]["peopleTypeIdentification"],
                optionsGender: [
                    {
                        value: 0, text: "Hombre"
                    },
                    {
                        value: 1, text: "Mujer"
                    },
                    {
                        value: 2, text: "LBTBI"
                    },
                    {
                        value: 3, text: "Otro"
                    }
                ],
                optionsPeopleProfession: $configPartial["dataCatalogue"]["peopleProfession"],
                mapCurrentData: [],
                /* ---PAYMENT---*/
                hasPayment: false,
                typeCreditCardOptions: [{
                    id: 0, text: "Diners", value: 0,
                }, {
                    id: 1, text: "Visa", value: 1
                }, {
                    id: 2, text: "Mastercard", value: 2
                }, {
                    id: 3, text: "Otras", value: 3
                }],
                wayToPayOptions: [
                    {id: 0, text: "Efectivo", value: 0},
                    {id: 1, text: "Tarjeta de Credito", value: 1},
                    {id: 2, text: "Cheque", value: 2}
                ],
                managerType: null,
                configAddPeopleS2: {label: "Clientes", allowAddPeopleS2: false, data: []},
                configManagerRooms: {viewRoomsStates: false, lable: "Habitaciones"},
            };
            return dataManager;
        },
        methods: {
            ...$methodsFormValid,

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
            _customersList: function (params) {
                var el = params.objSelector;
                var lodging_id = params.filters.lodging_id;
                _this = this;
                var elementInit = $(el).select2({
                    allow: true,
                    placeholder: "Seleccione Aplicacion",
                    ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                        url: $("#action_customer_getListSelect2NotLodging").val(),
                        type: "get",
                        dataType: 'json',
                        data: function (term, page) {
                            var paramsFilters = {
                                filters: {
                                    search_value: term,
                                    lodging_id: lodging_id,
                                    business_id: _this.businessId
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
                    width: '100%'
                });
                elementInit.on('select2:select', function (e) {
                    var data = e.params.data;
                    var lodging_by_customer_location = data.information_address_location_current_id ? {
                        information_address_location_current_id: data.information_address_location_current_id,
                        administrative_area_level_1: data.administrative_area_level_1,
                        administrative_area_level_2: data.administrative_area_level_2,
                        administrative_area_level_3: data.administrative_area_level_3,
                        options_map: data.options_map,

                    } : {};
                    var mailExist = data.mail ? true : false;
                    var people = {
                        main: false,
                        last_name: data.last_name,
                        name: data.name,
                        people_nationality_id: data.people_nationality_id,
                        people_profession_id: data.people_profession_id,
                        type_document: data.people_type_identification_id,
                        document_number: data.identification_document,
                        age: parseInt(data.age),
                        gender: data.gender,
                        mail: mailExist ? data.mail : null,
                        information_mail_id: mailExist ? data.information_mail_id : null,
                        information_mobile_id: data.mobile ? data.information_mobile_id : null,
                        information_phone_id: data.phone ? data.information_phone_id : null,
                        phone: data.phone,
                        mobile: data.mobile,
                        has_information_additional: data.information_address_location_current_id ? true : false,
                        allowAddPeopleS2: true,
                        people_id: data.people_id,
                        customer_id: data.customer_id,
                        customer_by_information_id: data.customer_by_information_id,
                        lodging_by_customer_id: null,
                        lodging_by_customer_location: lodging_by_customer_location
                    };
                    _this.configAddPeopleS2.data = people;
                    _this.configAddPeopleS2.allowAddPeopleS2 = true;
                    _this._addPeople();
                    elementInit.val(null).trigger("change");

                }).on("select2:unselecting", function (e) {


                });

            },
            //EVENTS OF CHILDREN
            _managerTypes: function (emitValues) {
                if (emitValues.type == "rebootGrid") {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                } else if (emitValues.type == "rebootConfig") {
                    var nameProcess = emitValues.nameProcess;
                    this[nameProcess].viewAllow = false;
                }
            },
            /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
            initCurrentComponent: function () {
                this.initGridUtil();

            },
            initGridUtil: function () {
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
                var business_id = this.businessId;
                var paramsFilters = {
                    business_id: business_id
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
                            var payment_made = row.payment_made;
                            var rooms_add_made = row.rooms_add_made;
                            var status_delivery = row.status_delivery;

                            var description = (row.description !== "null" && row.description) ? [
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Observaciones:</span><span class='content-description__value'>" + (row.description) + "</span>",
                                "</div>",

                            ] : [];
                            description = description.join("");
                            var paymentSpan = payment_made ? '<span class="badge badge--size-large badge-success">SI</span>' : '<span class="badge badge--size-large badge-danger">NO</span>';
                            var totalPeopleSpan = '<span class="badge badge--size-large badge-warning">' + (row.number_people) + '</span>';
                            var totalLodgingSpan = '<span class="badge badge--size-large badge-primary">' + (row.total_value) + '</span>';
                            var roomsAddMadeSpan = rooms_add_made ? '<span class="badge badge--size-large badge-success">SI</span>' : '<span class="badge badge--size-large badge-danger">NO</span>';
                            var statusDeliverySpan = status_delivery ? '<span class="badge badge--size-large badge-success">SI</span>' : '<span class="badge badge--size-large badge-danger">NO</span>';
                            var codecLodging = '<span class="badge badge--size-large badge-success">' + (row.id) + '</span>';

                            var result = [
                                "<div    class='content-description'>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Código Alojamiento: </span><span class='content-description__value'>" + (codecLodging) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Pago realizado: </span><span class='content-description__value'>" + (paymentSpan) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Habitaciones Asignadas!: </span><span class='content-description__value'>" + (roomsAddMadeSpan) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Habitaciones Entregadas!: </span><span class='content-description__value'>" + (statusDeliverySpan) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Fecha de Ingreso: </span><span class='content-description__value'>" + (row.entry_at) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Fecha de Salida: </span><span class='content-description__value'>" + (row.output_at) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'># de Personas: </span><span class='content-description__value'>" + totalPeopleSpan + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Adultos: </span><span class='content-description__value'>" + (row.adults == 0 ? "NO" : (row.adults == 1 ? "SI" : row.adults == "NULL" ? "" : "")) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Niños: </span><span class='content-description__value'>" + (row.children == 0 ? "NO" : (row.children == 1 ? "SI" : row.children == "NULL" ? "" : "")) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'># de Cuartos: </span><span class='content-description__value'>" + (row.number_rooms) + "</span>",
                                "</div>",
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Total: </span><span class='content-description__value'>" + (totalLodgingSpan) + "</span>",
                                "</div>",

                                description,
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
                elementSelect.find("tbody tr").on("click", function (e) {
                    var self = $(this);
                    var dataRowId = $(self[0]).attr("data-row-id");
                    var selectorRow;
                    if (dataRowId) {
                        var instance_data_rows = $(vmCurrent.gridConfig.selectorCurrent).bootgrid("getCurrentRows");
                        var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                        elementSelect.find("tr.selected").removeClass("selected");
                        var newEventRow = false;
                        if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                            var removeRowId = vmCurrent.managerMenuConfig.rowId;
                            if (dataRowId == removeRowId) {
                                selectorRow = vmCurrent.gridConfig.selectorCurrent + " tr[data-row-id='" + removeRowId + "']";
                                $(selectorRow).removeClass("selected");
                                vmCurrent._resetManagerGrid();
                            } else {

                                newEventRow = true;
                            }
                        } else {
                            newEventRow = true;
                        }
                        if (newEventRow) {
                            selectorRow = vmCurrent.gridConfig.selectorCurrent + " tr[data-row-id='" + dataRowId + "']";
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
            _viewRoomsState: function () {
                this.configModalLodgingRoomsState['data'] = {business_id: this.businessId};

                if (this.configModalLodgingRoomsState.viewAllow) {
                    this.$refs.refLodgingRoomsState._setValueOfParent(
                        {type: "openModal", data: this.configModalLodgingRoomsState}
                    );
                } else {
                    this.configModalLodgingRoomsState.viewAllow = true;
                }
            },
            _managerRowGrid: function (params) {
                var rowCurrent = params.row;
                var rowId = params.id;
                this.createUpdate = false;
                if (params.managerType == "paymentEntity") {

                    this.configModalLodgingByPayment.data = rowCurrent;
                    if (this.configModalLodgingByPayment.viewAllow) {
                        this.$refs.refLodgingByPayment._setValueOfParent(
                            {type: "openModal", data: this.configModalLodgingByPayment}
                        );
                    } else {
                        this.configModalLodgingByPayment.viewAllow = true;
                    }

                } else if (params.managerType == "roomsEntity") {

                    this.configModalLodgingByTypeOfRoom.data = rowCurrent;
                    if (this.configModalLodgingByTypeOfRoom.viewAllow) {
                        this.$refs.refLodgingByTypeOfRoom._setValueOfParent(
                            {type: "openModal", data: this.configModalLodgingByTypeOfRoom}
                        );
                    } else {
                        this.configModalLodgingByTypeOfRoom.viewAllow = true;
                    }

                } else if (params.managerType == "delivery") {

                    this.configModalLodgingDelivery.data = rowCurrent;
                    if (this.configModalLodgingDelivery.viewAllow) {
                        this.$refs.refLodgingDelivery._setValueOfParent(
                            {type: "openModal", data: this.configModalLodgingDelivery}
                        );
                    } else {
                        this.configModalLodgingDelivery.viewAllow = true;
                    }

                } else if (params.managerType == "arrivedEntity") {

                    this.configModalLodgingByArrived.data = rowCurrent;
                    if (this.configModalLodgingByArrived.viewAllow) {
                        this.$refs.refLodgingByArrived._setValueOfParent(
                            {type: "openModal", data: this.configModalLodgingByArrived}
                        );
                    } else {
                        this.configModalLodgingByArrived.viewAllow = true;
                    }

                } else if (params.managerType == "updateEntity") {
                    this.createUpdate = true;

                    var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                    this._destroyTooltip(elementDestroy);
                    this.managerMenuConfig.view = false;
                    this.resetForm();
                    this.model.attributes.id = rowCurrent.id;

                    this.model.attributes.entry_at_data = rowCurrent.entry_at;
                    this.model.attributes.output_at_data = rowCurrent.output_at;
                    this.model.attributes.number_rooms = parseFloat(rowCurrent.number_rooms);
                    this.model.attributes.number_people = parseFloat(rowCurrent.number_people);
                    this.model.attributes.adults = rowCurrent.adults == 1 ? true : false;
                    this.model.attributes.children = rowCurrent.children == 1 ? true : false;
                    this.model.attributes.payment_made = rowCurrent.payment_made == 1 ? true : false;
                    this.hasPayment = rowCurrent.payment_made == 1 ? true : false;
                    this.model.attributes.total_value = parseFloat(rowCurrent.total_value);
                    this.model.attributes.description = rowCurrent.description;
                    this.model.attributes.status_delivery = rowCurrent.status_delivery;


                    if (this.model.attributes.payment_made) {
                        var lodgingByPaymentData = rowCurrent["LodgingByPayment"];
                        var way_to_payData = [];
                        var type_credit_cardData = [];
                        $.each(lodgingByPaymentData, function (indexRow, valueRow) {
                            var way_to_pay = valueRow.way_to_pay;
                            way_to_payData.push(way_to_pay);
                            if (way_to_pay == 1) {
                                var lodgingByPaymentCreditCardData = valueRow["LodgingByPaymentCreditCard"];
                                $.each(lodgingByPaymentCreditCardData, function (indexRowLBPCCD, valueRowLBPCCD) {
                                    var type_credit_card = valueRowLBPCCD.type_credit_card;
                                    type_credit_cardData.push(type_credit_card);
                                });
                            }
                        });
                        this.model.attributes.way_to_pay = way_to_payData;
                        if (Object.keys(type_credit_cardData).length > 0) {
                            this.model.attributes.type_credit_card = type_credit_cardData;

                        }
                    }
                    //People
                    var People = [];
                    var peopleData = rowCurrent["People"];

                    $.each(peopleData, function (indexRow, valueRow) {
                        var setPush = {
                            allowAddPeopleS2: false,
                            people_id: valueRow.people_id,
                            customer_id: valueRow.customer_id,
                            customer_by_information_id: valueRow.customer_by_information_id,
                            last_name: valueRow.last_name,
                            name: valueRow.name,
                            type_document: valueRow.type_document,
                            document_number: valueRow.document_number,
                            age: parseInt(valueRow.age),
                            gender: valueRow.gender,
                            people_nationality_id: valueRow.people_nationality_id,
                            people_profession_id: valueRow.people_profession_id,
                            main: valueRow.main == 1 ? true : false,
                            has_information_additional: valueRow.has_information_additional == 1 ? true : false,
                            lodging_by_customer_id: valueRow.lodging_by_customer_id

                        };
                        if (valueRow.has_information_additional) {
                            setPush["phone"] = valueRow.phone;
                            setPush["mobile"] = valueRow.mobile;
                            setPush["lodging_customer_additional_information_id"] = valueRow.lodging_customer_additional_information_id;
                            setPush["mail"] = valueRow.mail;
                            setPush["information_mail_id"] = valueRow.information_mail_id;
                            setPush["information_mobile_id"] = valueRow.information_mobile_id;
                            setPush["information_phone_id"] = valueRow.information_phone_id;
                            setPush["postal_code"] = valueRow.postal_code;
                            setPush["lodging_by_customer_location"] = valueRow.lodging_by_customer_location;
                        } else {
                            setPush["phone"] = null;
                            setPush["mobile"] = null;
                            setPush["mail"] = null;
                            setPush["postal_code"] = null;
                            setPush["lodging_by_customer_location"] = null;
                        }
                        People.push(setPush);
                    });

                    this.model.attributes.people = People;
                    this._viewManager(3, rowId);
                }
            },
            /*  EVENTS*/
            _viewManager: function (typeView, rowId) {

                if (typeView == 1) {//create
                    this.showManager = true;
                    this.managerMenuConfig.view = false;

                    $(this.gridConfig.selectorCurrent + "-header").hide();
                    $(this.gridConfig.selectorCurrent + "-footer").hide();
                    $(this.gridConfig.selectorCurrent +' div.actions').hide();
                    this.resetForm();
                    var main = true;
                    var people = this.getAttributesPeople();
                    people.main = main;
                    people.has_information_additional = true;
                    this.model.attributes.people.push(people);
                    this.managerType = 1;
                    this.onInitEventClickTimerForm();//CHANGE-FORM
                } else if (typeView == 2) {//admin
                    this.createUpdate = false;
                    this.showManager = false;
                    $(this.gridConfig.selectorCurrent + "-footer").show();
                    $(this.gridConfig.selectorCurrent + "-header").show();
                    $(this.gridConfig.selectorCurrent +' div.actions').show();

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
                    $(this.gridConfig.selectorCurrent +' div.actions').hide();

                    this.managerMenuConfig.view = false;
                    this.managerType = 3;
                    this.onInitEventClickTimerForm();//CHANGE-FORM
                }
            },
            /*FORM*/
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

                    entry_at_data: {
                        id: "entry_at_data",
                        name: "entry_at_data",
                        label: "Fecha Ingreso",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    output_at_data: {
                        id: "output_at_data",
                        name: "output_at_data",
                        label: "Fecha Salida",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    number_people: {
                        id: "number_people",
                        name: "number_people",
                        label: "N° Personas",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    adults: {
                        id: "adults",
                        name: "adults",
                        label: "Adultos",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    children: {
                        id: "children",
                        name: "children",
                        label: "Niños",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    number_rooms: {
                        id: "number_rooms",
                        name: "number_rooms",
                        label: "N° Cuartos",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    total_value: {
                        id: "total_value",
                        name: "total_value",
                        label: "Total",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    payment_made: {
                        id: "payment_made",
                        name: "payment_made",
                        label: "Pagado",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    description: {
                        id: "description",
                        name: "description",
                        label: "Observaciones",
                        required:
                            {
                                allow: false,
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
                    type_document: {
                        id: "type_document",
                        name: "type_document",
                        label: "Tipo de Identificación",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    document_number: {
                        id: "document_number",
                        name: "document_number",
                        label: "Documento N°",
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
                    gender: {
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
                    people_nationality_id: {
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
                    people_profession_id: {
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
                    phone: {
                        id: "phone",
                        name: "phone",
                        label: "Teléfono",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    mobile: {
                        id: "mobile",
                        name: "mobile",
                        label: "Celular",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    mail: {
                        id: "mail",
                        name: "mail",
                        label: "E-mail",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    postal_code: {
                        id: "postal_code",
                        name: "postal_code",
                        label: "Cod. Postal",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    has_information_additional: {
                        id: "has_information_additional",
                        name: "has_information_additional",
                        label: "Información Adicional",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    mainAdd: {
                        id: "mainAdd",
                        name: "mainAdd",
                        label: "Representante",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    mainAddAllow: {
                        id: "mainAddAllow",
                        name: "mainAddAllow",
                        label: "Permitido",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    //payment
                    way_to_pay: {
                        id: "way_to_pay",
                        name: "way_to_pay",
                        label: "Forma de Pago",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    type_credit_card: {
                        id: "type_credit_card",
                        name: "type_credit_card",
                        label: "Tarjetas de Credito",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    }
                };

                return result;
            },
            getAttributesForm: function () {
                var result = {
                    entry_at_data: null,
                    output_at_data: null,
                    number_people: null,
                    adults: null,
                    children: null,
                    number_rooms: null,
                    total_value: null,
                    payment_made: null,
                    description: null,
                    status: true,
                    mainAddAllow: true,
                    has_information_additional: false,
                    //payment
                    way_to_pay: null,
                    type_credit_card: null,
                    people: [],
                    status_delivery: 0
                };

                return result;
            },
            getNameAttributePeople: function (index, name) {
                var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
                return result;
            },
            getNameAttribute: function (name) {
                var result = this.formConfig.nameModel + "[" + name + "]";
                return result;
            },
            getLabelForm: viewGetLabelForm,


            _setValueForm: function (name, value, position = null, model = null) {
                /*  way_to_pay: null,
                      type_credit_card: null*/
                var attributeCurrent;
                if (name == "payment_made") {
                    if (value) {// not-has
                        attributeCurrent = "way_to_pay";
                        this.$v.model.attributes[attributeCurrent].$model = null;
                        this.model.attributes[attributeCurrent] = null;
                        this.$v["model"]["attributes"][attributeCurrent].$reset();
                        attributeCurrent = "type_credit_card";
                        this.$v.model.attributes[attributeCurrent].$model = null;
                        this.model.attributes[attributeCurrent] = null;
                        this.$v["model"]["attributes"][attributeCurrent].$reset();
                    }
                } else if (name == "way_to_pay") {
                    attributeCurrent = "way_to_pay";
                    var allowViewCreditCard = false;
                    $.each(this.$v.model["attributes"][attributeCurrent].$model, function (indexRow, valueRow) {
                        if (valueRow == 1) {
                            allowViewCreditCard = true;
                        }

                    });
                    if (!allowViewCreditCard) {
                        attributeCurrent = "type_credit_card";
                        this.$v.model.attributes[attributeCurrent].$model = null;
                        this.model.attributes[attributeCurrent] = null;
                        this.$v["model"]["attributes"][attributeCurrent].$reset();
                    }
                }


                if ("last_name" == name || "main" == name ||
                    "name" == name ||
                    "people_nationality_id" == name ||
                    "people_profession_id" == name ||
                    "type_document" == name ||
                    "document_number" == name ||
                    "age" == name ||
                    "gender" == name ||
                    "mail" == name ||
                    "postal_code" == name ||
                    "phone" == name ||
                    "mobile" == name ||
                    "has_information_additional" == name

                ) {
                    model["$model"] = value;
                    model.$touch();
                } else {

                    this.model.attributes[name] = value;
                    this.$v["model"]["attributes"][name].$model = value;
                    this.$v["model"]["attributes"][name].$touch();
                }

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

                var People = this.getValuesPeopleAll(this.$v.model.attributes.people.$each.$iter);
                var payment_made = this.$v.model.attributes.payment_made.$model == null ? 0 : (this.$v.model.attributes.payment_made.$model == false ? 0 : 1);//error :(
                var LodgingByPayment = [];
                if (payment_made) {
                    var way_to_payData = this.$v.model.attributes.way_to_pay.$model;
                    var type_credit_cardData = this.$v.model.attributes.type_credit_card.$model;

                    $.each(way_to_payData, function (indexRow, valueRow) {
                        var way_to_pay = valueRow;
                        var setPush = {
                            way_to_pay: way_to_pay
                        };
                        if (valueRow == 1) {//credit card
                            var LodgingByPaymentCreditCard = [];
                            $.each(type_credit_cardData, function (indexRowCC, valueRowCC) {
                                var type_credit_card = valueRowCC;
                                var setPushCC = {
                                    type_credit_card: type_credit_card
                                };
                                LodgingByPaymentCreditCard.push(setPushCC);
                            });
                            setPush = {
                                way_to_pay: way_to_pay,
                                LodgingByPaymentCreditCard: LodgingByPaymentCreditCard
                            };
                        }
                        LodgingByPayment.push(setPush);
                    });
                }
                var result = {

                    id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    entry_at: moment(this.$v.model.attributes.entry_at_data.$model).format("YYYY-MM-DD h:mm:ss"),
                    output_at: this.$v.model.attributes.output_at_data.$model ? moment(this.$v.model.attributes.output_at_data.$model).format("YYYY-MM-DD h:mm:ss") : null,
                    number_people: this.$v.model.attributes.number_people.$model,
                    adults: this.$v.model.attributes.adults.$model == null ? 0 : (this.$v.model.attributes.adults.$model == true ? 1 : 0),
                    /*   this.businessId*/
                    children: this.$v.model.attributes.children.$model == null ? 0 : (this.$v.model.attributes.children.$model == true ? 1 : 0),
                    number_rooms: this.$v.model.attributes.number_rooms.$model,
                    total_value: this.$v.model.attributes.total_value.$model,
                    payment_made: payment_made,
                    description: this.$v.model.attributes.description.$model,
                    People: People,
                    business_id: this.businessId
                };
                if (payment_made) {
                    result["LodgingByPayment"] = LodgingByPayment;
                }
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
                                vCurrent.resetForm();
                                $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                                vCurrent._viewManager(2);
                            }
                        }
                    });
                }
            },
            resetForm: function () {
                deleteData = [];
                this.$v.$reset();
                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };
                this.model.attributes.id = null;
                this.mapCurrentData = [];
                /* ---PAYMENT---*/
                this.hasPayment = false;


            },
            _valuesForm: function (event) {
                this.model.init = false;
                this.validateForm();
            },
            validateForm: function () {
                var currentAllow = this.getValidateForm();
                return currentAllow.success;
            },
            getViewPeopleProcess: function () {
                var haystack = this.$v.model.attributes.people.$each.$iter;
                var result = Object.keys(haystack).length > 0
                return result;
            },
            allowDisabledPaymentMade: function () {
                var result = false;
                if (this.$v.model.attributes.id.$model != null) {//create

                    result = true;
                }
                return result;
            },
            getValuesPeopleAll: function (haystack) {

                var result = [];
                $.each(haystack, function (indexRow, valueRow) {
                    var modelCurrent = valueRow.$model;
                    var main = modelCurrent.main ? 1 : 0;
                    var has_information_additional = modelCurrent.has_information_additional ? 1 : 0;
                    var LodgingCustomerAdditionalInformation = {};
                    var LodgingByCustomerLocation = {};
                    if (has_information_additional) {
                        LodgingCustomerAdditionalInformation = {
                            phone: modelCurrent.phone ? modelCurrent.phone : "",
                            mobile: modelCurrent.mobile ? modelCurrent.mobile : "",
                            information_phone_id: modelCurrent.information_phone_id ? modelCurrent.information_phone_id : "",
                            information_mobile_id: modelCurrent.information_mobile_id ? modelCurrent.information_mobile_id : "",
                            mail: modelCurrent.mail,
                            postal_code: modelCurrent.postal_code ? modelCurrent.postal_code : "",
                            lodging_customer_additional_information_id: valueRow.lodging_customer_additional_information_id.$model,
                            information_mail_id: modelCurrent.information_mail_id,
                        };
                        var lodging_by_customer_location_id = null;
                        var information_address_location_current_id = null;

                        var managerGeocoderAddressComponent = {
                            'country_code_id': $managerGeocoderAddressComponent.country_code_id,
                            administrative_area_level_2: $managerGeocoderAddressComponent.administrative_area_level_2,
                            administrative_area_level_1: $managerGeocoderAddressComponent.administrative_area_level_1,
                            administrative_area_level_3: $managerGeocoderAddressComponent.administrative_area_level_3,
                            'options_map': $managerGeocoderAddressComponent.options_map
                        };
                        if (valueRow.lodging_by_customer_location.$model) {
                            managerGeocoderAddressComponent = {
                                'country_code_id': valueRow.lodging_by_customer_location.$model.country_code_id,
                                administrative_area_level_2: valueRow.lodging_by_customer_location.$model.administrative_area_level_2,
                                administrative_area_level_1: valueRow.lodging_by_customer_location.$model.administrative_area_level_1,
                                administrative_area_level_3: valueRow.lodging_by_customer_location.$model.administrative_area_level_3,
                                'options_map': valueRow.lodging_by_customer_location.$model.options_map

                            }
                        } else {

                        }
                        if (valueRow.lodging_by_customer_location.$model) {
                            lodging_by_customer_location_id=valueRow.lodging_by_customer_location.$model.lodging_by_customer_location_id;
                            information_address_location_current_id=valueRow.lodging_by_customer_location.$model.information_address_location_current_id;

                        }
                        LodgingByCustomerLocation = {//set value
                            country_code_id: managerGeocoderAddressComponent.country_code_id,
                            administrative_area_level_2: managerGeocoderAddressComponent.administrative_area_level_2,
                            administrative_area_level_1: managerGeocoderAddressComponent.administrative_area_level_1,
                            administrative_area_level_3: managerGeocoderAddressComponent.administrative_area_level_3,
                            options_map: JSON.stringify(managerGeocoderAddressComponent.options_map),
                            lodging_by_customer_location_id: lodging_by_customer_location_id,
                            information_address_location_current_id: information_address_location_current_id,
                        };

                    }
                    var setPush = {
                        LodgingByCustomer: {
                            main: main,
                            has_information_additional: has_information_additional,
                            customer_by_information_id: modelCurrent.customer_by_information_id,
                            people_nationality_id: modelCurrent.people_nationality_id,
                            people_profession_id: modelCurrent.people_profession_id,
                            lodging_by_customer_id: valueRow.lodging_by_customer_id.$model
                        },
                        last_name: modelCurrent.last_name,
                        name: modelCurrent.name,
                        type_document: modelCurrent.type_document,
                        document_number: modelCurrent.document_number,
                        age: modelCurrent.age,
                        gender: modelCurrent.gender,
                        people_id: valueRow.people_id.$model,
                        customer_id: valueRow.customer_id.$model,
                        allowAddPeopleS2: valueRow.allowAddPeopleS2.$model,

                    };

                    if (has_information_additional) {
                        setPush.LodgingByCustomer.LodgingCustomerAdditionalInformation = LodgingCustomerAdditionalInformation;
                        setPush.LodgingByCustomer.LodgingByCustomerLocation = LodgingByCustomerLocation;

                    }
                    result.push(setPush);

                });
                return result;
            },
            getValidatePeopleAll: function (haystack) {
                var $peopleErrors = [];
                var setPush = {};
                var allEmptyRows = true;
                if (Object.keys(haystack).length > 0) {
                    allEmptyRows = false;
                    $.each(haystack, function (indexRow, valueRow) {
                        if (valueRow.last_name.$invalid || valueRow.age.$invalid || valueRow.document_number.$invalid || valueRow.gender.$invalid || valueRow.people_profession_id.$invalid || valueRow.type_document.$invalid || valueRow.people_nationality_id.$invalid) {
                            if (valueRow.last_name.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "last_name",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.age.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "age",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.document_number.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "document_number",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.gender.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "gender",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.people_profession_id.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "people_profession_id",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.type_document.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "type_document",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }

                            if (valueRow.people_nationality_id.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "people_nationality_id",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                        }
                        if (valueRow.has_information_additional.$model) {//

                            if (valueRow.mail.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "mail",
                                    "type": "row_information_additional"
                                }
                                $peopleErrors.push(setPush);

                            }

                        }
                    });
                } else {

                    setPush = {
                        "type": "row_all"
                    }
                    $peopleErrors.push(setPush);
                }
                var success = Object.keys($peopleErrors).length == 0 ? false : true;
                var result = {
                    success: success,
                    errors: $peopleErrors,
                    empty: allEmptyRows
                }
                return result;
            },
            getValidateForm: function () {
                var success = true;
                var attributeCurrent = "";
                var $invalidWayToPay = false;
                var $invalidTypeCreditCard = false;
                var errors = [];
                var $peopleInValid = false;
                if (this.hasPayment) {
                    attributeCurrent = "way_to_pay";
                    var allowViewCreditCard = false;
                    $invalidWayToPay = this.$v.model["attributes"][attributeCurrent]["$invalid"];
                    $.each(this.$v.model["attributes"][attributeCurrent].$model, function (indexRow, valueRow) {
                        if (valueRow == 1) {
                            allowViewCreditCard = true;
                        }
                    });
                    if (allowViewCreditCard) {
                        attributeCurrent = "type_credit_card";
                        $invalidTypeCreditCard = this.$v.model["attributes"][attributeCurrent]["$invalid"];
                    }

                }
                var $peopleValidate = this.getValidatePeopleAll(this.$v.model.attributes.people.$each.$iter);
                if ($peopleValidate.success) {
                    $peopleInValid = true;
                    errors.push(
                        {
                            "type": "people", "fields": $peopleValidate.errors
                        }
                    );
                }

                if (
                    $peopleInValid ||
                    this.$v.model["attributes"]["entry_at_data"]["$invalid"] ||
                    this.$v.model["attributes"]["output_at_data"]["$invalid"] ||
                    this.$v.model["attributes"]["number_people"]["$invalid"] ||
                    this.$v.model["attributes"]["adults"]["$invalid"] ||
                    this.$v.model["attributes"]["children"]["$invalid"] ||
                    this.$v.model["attributes"]["number_rooms"]["$invalid"] ||
                    this.$v.model["attributes"]["total_value"]["$invalid"] ||
                    this.$v.model["attributes"]["payment_made"]["$invalid"] ||
                    this.$v.model["attributes"]["description"]["$invalid"] ||
                    $invalidWayToPay ||
                    $invalidTypeCreditCard

                ) {


                    if (this.$v.model["attributes"]["entry_at_data"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["entry_at_data"]
                        });
                    }
                    if (this.$v.model["attributes"]["output_at_data"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["output_at_data"]
                        });
                    }
                    if (this.$v.model["attributes"]["number_people"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["number_people"]
                        });
                    }
                    if (this.$v.model["attributes"]["adults"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["adults"]
                        });
                    }
                    if (this.$v.model["attributes"]["children"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["children"]
                        });
                    }
                    if (this.$v.model["attributes"]["number_rooms"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["number_rooms"]
                        });
                    }
                    if (this.$v.model["attributes"]["total_value"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["total_value"]
                        });
                    }
                    if (this.$v.model["attributes"]["payment_made"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["payment_made"]
                        });
                    }
                    if (this.$v.model["attributes"]["description"]["$invalid"]) {
                        errors.push({
                            "type": "lodging", "fields": ["description"]
                        });
                    }
                    if ($invalidWayToPay) {
                        errors.push({
                            "type": "payment", "fields": ["way_to_pay"]
                        });
                    }
                    if ($invalidTypeCreditCard) {
                        errors.push({
                            "type": "paymentCreditCard", "fields": ["type_credit_card"]
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
//PROCESS NEWS
            getClassGuest: function (modelData) {
                var result = modelData.main.$model ? "warning" : "secondary";
                return result;
            },
            getLabelTitleGuest: function (index, modelData) {
                var result = this.labelsConfig.manager.guest + "" + index + (modelData.main.$model ? (" Principal") : "");
                return result;
            },
//people
            getAttributesPeople: function () {
                var main = false;
                var result = {
                    id: null,
                    main: main,
                    last_name: "",
                    name: "",
                    people_nationality_id: null,
                    people_profession_id: null,
                    information_mobile_id: null,
                    information_phone_id: null,
                    phone: null,
                    mobile: null,
                    type_document: null,
                    document_number: "",
                    age: 0,
                    gender: null,
                    mail: null,
                    information_mail_id: null,
                    has_information_additional: false,
                    allowAddPeopleS2: false
                };

                return result;
            },
            _addPeople: function () {
                var main = this.model.attributes["mainAdd"];
                var people = [];
                if (this.configAddPeopleS2.allowAddPeopleS2) {
                    people = this.configAddPeopleS2.data;
                    people.main = main;
                    this.configAddPeopleS2.data = [];
                    this.configAddPeopleS2.allowAddPeopleS2 = false;
                } else {
                    people = this.getAttributesPeople();
                    people.main = main;

                }
                if (main) {
                    people.has_information_additional = true;
                }
                this.model.attributes.people.push(people);
                this.setConfigViewAddAllow();
            },
            _removePeople: function (index, vModel) {
                if (vModel.allowAddPeopleS2.$model == false || vModel.allowAddPeopleS2.$model) {
                    if (vModel.allowAddPeopleS2.$model) {
                        this.model.attributes.people.splice(index, 1);
                        this.setConfigViewAddAllow();
                        var mapCurrentData = this.getMapCurrentData(index, vModel);
                        if (mapCurrentData) {
                            this.mapCurrentData.splice(mapCurrentData.index, 1);
                        }
                        if (!this.$v.model.attributes.people.required) {
                            this.$v.model.attributes.people.$reset();
                        }

                    } else {
                        if (vModel.people_id.$model == null) {
                            this.model.attributes.people.splice(index, 1);
                            this.setConfigViewAddAllow();
                            var mapCurrentData = this.getMapCurrentData(index, vModel);
                            if (mapCurrentData) {
                                this.mapCurrentData.splice(mapCurrentData.index, 1);
                            }
                            if (!this.$v.model.attributes.people.required) {
                                this.$v.model.attributes.people.$reset();
                            }
                        }
                    }
                }

            },
            getValueViewAddAllow: function () {
                var mainAddAllow = false;
                if (!this.$v.model.attributes.people.required) {
                    mainAddAllow = false;
                } else {
                    $.each(this.model.attributes.people, function (indexRow, valueRow) {
                        if (valueRow.main) {
                            mainAddAllow = true;
                            return mainAddAllow;
                        }
                    });
                }
                return mainAddAllow;

            },
            setConfigViewAddAllow: function () {
                var mainAddAllow = this.getValueViewAddAllow();
                this.model.attributes["mainAddAllow"] = mainAddAllow;
                this.model.attributes["mainAdd"] = null;
            },
            getIdManagerGuest: function (index, v) {
                var result = "manager-information-" + index;
                return result;
            },
            getIdManagerGuestMap: function (index, v) {
                var result = "input-information-" + index;
                return result;
            },
            getIdManagerGuestMapContent: function (index, v) {
                var result = "manager-map-" + index;
                return result;
            },

            /*MAP */
            _initMap: function (params) {
                var paramsAutocomplete = {index: params.data.index, v: params.data.v};

                var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                    name: "Greyscale"
                });
                var mapOptions = {};

                if (params.data.v.lodging_by_customer_location.$model) {
                    if (typeof (params.data.v.lodging_by_customer_location.$model.options_map) == "string") {
                        mapOptions = jQuery.parseJSON(params.data.v.lodging_by_customer_location.$model.options_map);
                        if (mapOptions.zoom) {
                            $latLngCurrent = {
                                lat: parseFloat(mapOptions.latLng.lat),
                                lng: parseFloat(mapOptions.latLng.lng)
                            };
                        }
                    }
                }

                var zoom = $managerGeocoderAddressComponent.options_map.zoom;
                var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
                mapOptions = {
                    title: "Ubicacion",
                    panControl: true,
                    scrollwheel: false,
                    mapTypeControl: false,
                    scaleControl: true,
                    streetViewControl: false,
                    overviewMapControl: false,
                    draggable: true,
                    center: $latLngCurrent,
                    zoom: zoom,
                    animation: google.maps.Animation.DROP,
                    icon: icon_mapa_url

                };
                var objSelector = params.objSelector;

                var dataCurrent = params.data;
                var mapCurrent = new google.maps.Map(objSelector, mapOptions);
                var key = 1;

                var key_id = key;
                var info_name = "Mueva el Marker.";
                var msg = key_id + " " + info_name;

                var width = 40, height = 40;
                var urlIcon = "https://furtaev.ru/preview/user_on_map.png";
                var iconCurrent = {
                    url: urlIcon,
                    scaledSize: new google.maps.Size(width, height), // scaled size
                };
                var marker_object = new google.maps.Marker({
                    draggable: true,
                    title: info_name,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng($latLngCurrent.lat, $latLngCurrent.lng),
                    icon: iconCurrent,
                });

                mapCurrent.mapTypes.set('greyscale_style', greyStyleMap);
                mapCurrent.setMapTypeId('greyscale_style');
                this._mapCurrent({
                    mapCurrent: mapCurrent,
                    data: dataCurrent
                });
                marker_object.setMap(mapCurrent);
                this._markersCurrent({
                    marker: marker_object,
                    data: dataCurrent
                });
                var dataManager = params.data;
                var idCurrent = dataManager.index;
                mapCurrent.setCenter($latLngCurrent);
                this.mapCurrentData.push({
                    id: idCurrent,
                    "map": mapCurrent,
                    marker: marker_object
                });

                this._initAutocomplete(paramsAutocomplete);

            },
            getMapCurrentData: function (index, vModel) {
                var needle = index;
                var foundCurrent = null;
                $.each(this.mapCurrentData, function (indexRow, valueRow) {
                    if (valueRow.id == needle) {
                        foundCurrent = {index: indexRow, data: valueRow};
                        return valueRow;
                    }
                });
                return foundCurrent;
            },
            _mapCurrent: function (params) {
                var mapCurrent = params.mapCurrent;
                var dataCurrent = params.data;

                var vCurrent = this;
                mapCurrent.addListener('idle', function () {

                    var latLngCurrent = {lng: mapCurrent.getCenter().lng(), lat: mapCurrent.getCenter().lat()};
                    vCurrent.managerDataLodgingByCustomerLocation({
                        type: "idle", "configSearch": {'latLng': latLngCurrent}, data: dataCurrent
                    });
                });

            },
            _markersCurrent: function (params) {
                var vCurrent = this;
                var marker = params.marker;
                var dataCurrent = params.data;

                google.maps.event.addListener(marker, 'dragend', function () {
                    var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
                    vCurrent.managerDataLodgingByCustomerLocation({
                        type: "dragend", "configSearch": {'latLng': latLngCurrent}, data: dataCurrent
                    });
                });
                google.maps.event.addListener(marker, 'click', function () {
                    var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};

                });
            },
            _initAutocomplete: function (params) {
                // Create the autocomplete object, restricting the search predictions to
                // geographical location types.
                var index = params.index;
                var v = params.v;

                var elementId = this.getIdManagerGuestMap(index, v);
                autocomplete = new google.maps.places.Autocomplete(
                    document.getElementById(elementId), {types: ['geocode']});

                var mapObjCurrent = this.getMapCurrentData(params.index, params.v);
                var mapInit = mapObjCurrent.data.map;
                var markerInit = mapObjCurrent.data.marker;
                // Avoid paying for data that you don't need by restricting the set of
                // place fields that are returned to just the address components.
                autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);
                autocomplete.bindTo('bounds', mapInit);
                // When the user selects an address from the drop-down, populate the
                // address fields in the form.
                var _this = this;

                autocomplete.addListener('place_changed', function () {
                    _this.fillInAddress({
                        autocomplete: this,
                        map: mapInit,
                        marker: markerInit
                    });
                });
            },
            fillInAddress: function (params) {
                var map = params.map;
                var marker = params.marker;
                var autocomplete = params.autocomplete;

                // Get each component of the address from the place details,
                // and then fill-in the corresponding field on the form.
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            },
            managerDataLodgingByCustomerLocation: function (params) {
                var vCurrent = this;
                var type = params.type;
                var configSearch = params.configSearch;

                var idCurrent = null;

                var modelCurrentRow = null;
                var indexCurrentRow = null;
                if (type == "_searchMap") {
                    modelCurrentRow = params.dataManager.vModel;
                    indexCurrentRow = params.dataManager.index;
                    idCurrent = indexCurrentRow;

                } else if (type == "idle") {
                    modelCurrentRow = params.data.v;
                    indexCurrentRow = params.data.index;
                    idCurrent = indexCurrentRow;

                } else if (type == "dragend") {
                    modelCurrentRow = params.data.v;
                    indexCurrentRow = params.data.index;
                    idCurrent = indexCurrentRow;

                }
                var mapObjCurrent = vCurrent.getMapCurrentData(indexCurrentRow, modelCurrentRow);
                var mapInit = mapObjCurrent.data.map;
                var markerInit = mapObjCurrent.data.marker;
                var geocoder = new google.maps.Geocoder();
                geocodeSearch({
                    geocoder: geocoder,
                    configSearch: configSearch,

                }).then(function (response) {
                    var haystack = response.data;
                    var dataSendParams = {};
                    if (response.success) {
                        if (type == "_searchMap") {

                            var locationCurrent = response.data[0].geometry.location;
                            markerInit.setPosition(locationCurrent);
                            mapInit.panTo(locationCurrent);
                            mapInit.setZoom(6);
                            options_map = {
                                zoom: mapInit.getZoom(),
                                latLng: {lat: markerInit.getPosition().lat(), lng: markerInit.getPosition().lng()}
                            };
                            dataSendParams = {
                                haystack: haystack,
                                vModel: modelCurrentRow,
                                index: indexCurrentRow,
                                options_map: options_map

                            };
                        } else if (type == "idle") {
                            options_map = {
                                zoom: mapInit.getZoom(),
                                latLng: {lat: markerInit.getPosition().lat(), lng: markerInit.getPosition().lng()}
                            };
                            dataSendParams = {
                                haystack: haystack,
                                vModel: modelCurrentRow,
                                index: indexCurrentRow,
                                options_map: options_map

                            };
                        } else if (type == "dragend") {
                            options_map = {
                                zoom: mapInit.getZoom(),
                                latLng: {lat: markerInit.getPosition().lat(), lng: markerInit.getPosition().lng()}

                            };
                            dataSendParams = {
                                haystack: haystack,
                                vModel: modelCurrentRow,
                                index: indexCurrentRow,
                                options_map: options_map
                            };
                        }
                        vCurrent.setStructureLodgingByCustomerLocation(dataSendParams);
                    }
                }).catch(function (response) {

                    if (type == "_searchMap") {
                        vCurrent.makeToast({
                            "title": "Información", msj: "No existe información sobre este lugar:" + configSearch.address,
                            "type": "warning"
                        });
                    }
                    if (type == "idle") {

                    }
                });
            },
            setStructureLodgingByCustomerLocation: function (params) {
                var haystack = params.haystack;
                var idCurrent = params.index;
                var vCurrent = this;
                var options_map = params.options_map;
                var lodging_by_customer_location = {
                    country_code_id: "",//*
                    administrative_area_level_2: "",//*
                    administrative_area_level_1: "",//*
                    administrative_area_level_3: "",
                    options_map: options_map
                }
                var haystackLocations = [["country", "political"], ["administrative_area_level_1", "political"], ["administrative_area_level_2", "political"]];
                $.each(haystackLocations, function (indexRow, valueRow) {
                    var foundCurrent = vCurrent.getFormattedInformation(valueRow, haystack);
                    var nameMain = valueRow[0];
                    if (foundCurrent) {
                        if (nameMain == "country") {
                            lodging_by_customer_location["country_code_id"] = foundCurrent["place_id"];
                        } else if (nameMain == "administrative_area_level_1") {
                            lodging_by_customer_location["administrative_area_level_1"] = foundCurrent["place_id"];

                        } else if (nameMain == "administrative_area_level_2") {
                            lodging_by_customer_location["administrative_area_level_2"] = foundCurrent["place_id"];

                        } else if (nameMain == "administrative_area_level_3") {
                            lodging_by_customer_location["administrative_area_level_3"] = foundCurrent["place_id"];

                        }
                    }
                });
                if (params.vModel.lodging_by_customer_location["$model"]) {
                    lodging_by_customer_location["lodging_by_customer_location_id"] = params.vModel.lodging_by_customer_location["$model"].lodging_by_customer_location_id;
                    lodging_by_customer_location["lodging_by_customer_id"] = params.vModel.lodging_by_customer_location["$model"].lodging_by_customer_id;
                    lodging_by_customer_location["information_address_location_current_id"] = params.vModel.lodging_by_customer_location["$model"].information_address_location_current_id;

                }
                params.vModel.lodging_by_customer_location["$model"] = lodging_by_customer_location;
            },
            getFormattedInformation: function (needle, haystack) {
                var result = null;
                $.each(haystack, function (indexRow, valueRow) {

                    if (isEqualArrays(valueRow["types"], needle)) {
                        result = valueRow
                        return result;
                    }
                });
                return result;

            },
            _searchMap: function (index, vModel) {
                var selectorCurrent = this.getIdManagerGuestMap(index, vModel);
                var address = $("#" + selectorCurrent).val();
                this.managerDataLodgingByCustomerLocation({
                    type: "_searchMap", "configSearch": {'address': address}, dataManager: {
                        index: index, vModel: vModel
                    }
                });
            },
            /*---PAYMENT---*/
            getViewTypeCreditCard: function (hasPayment, modelCurrent) {
                var result = false;
                if (hasPayment) {
                    if (modelCurrent.$model) {
                        $.each(modelCurrent.$model, function (indexRow, valueRow) {
                            if (valueRow == 1) {
                                result = true;
                            }

                        });
                    }
                }
                return result;
            },

        },

    })
;

