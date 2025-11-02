class UtilManagerCustomModel {
    static getManagerData(nameProcess) {
        let haystack = nameProcess.split('_');
        let managerInfo = [];
        let managerInfoLowerFirst = [];
        let modelProcessData = [];
        haystack.forEach(function (value, index) {
            let valueCurrent = value;
            let managerString = valueCurrent.charAt(0).toUpperCase() + valueCurrent.slice(1);
            managerInfo.push(managerString);
            if (index === 0) {
                managerString = value;
                managerInfoLowerFirst.push(managerString);
            } else {
                managerInfoLowerFirst.push(managerString);
            }
            modelProcessData.push(value);
        });

        return {
            modelNameLowerFirst: managerInfoLowerFirst.join(''),
            modelName: managerInfo.join(''),
            modelProcess: modelProcessData.join('-'),
        };
    }
}

var $dataManagerFieldsCustomer = {
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
    managerInformationPhone: {
        allow: false,
        allowEdit: false,

    },
    managerCustomerSearch: {
        view: false,
        customersAll: [],
        map: null,
        viewLoading: true
    }

};
var $methodsCustomer = {
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
            },
            //PHONE
            information_phone_value: {
                id: "information_phone_value",
                name: "information_phone_value",
                label: "Número",
                required: {
                    allow: true,
                    msj: "Campo requerido.",
                    error: false
                },
                maxLength: {
                    msj: "# Carecteres Excedidos a 150.",
                },
            },
            information_phone_operator_id_data: {
                id: "information_phone_operator_id_data",
                name: "information_phone_operator_id_data",
                label: "Operadora",
                required: {
                    allow: true,
                    msj: "Campo requerido.",
                    error: false
                },
            },
            information_phone_type_id_data: {
                id: "information_phone_type_id_data",
                name: "information_phone_type_id_data",
                label: "Tipo",
                required: {
                    allow: true,
                    msj: "Campo requerido.",
                    error: false
                },
            }
        };

        return result;
    },
    getAttributesForm: function () {
        var people_type_identification_id_data_others_id = 3;
        var dateCurrent = new Date();

// Obtener el año actual
        var year = dateCurrent.getFullYear();

// Obtener el mes actual (los meses comienzan desde 0, por lo que se agrega 1)
        var month = dateCurrent.getMonth() + 1;
        if (month < 10) {
            month = '0' + month;
        }
// Obtener el día del mes actual
        var day = dateCurrent.getDate();
        if (day < 10) {
            day = '0' + day;
        }
// Obtener la hora actual
        var horas = dateCurrent.getHours();

// Obtener los minutos actuales
        var minutos = dateCurrent.getMinutes();

// Obtener los segundos actuales
        var segundos = dateCurrent.getSeconds();
        var birthdate = year + '-' + month + '-' + day;
        var information_phone_operator_id_data = null;
        if ($managerDefaultData.information_phone_operator) {
            information_phone_operator_id_data = $managerDefaultData.information_phone_operator;
        }

        var information_phone_type_id_data = null;
        if ($managerDefaultData.information_phone_type_personal_phone) {
            information_phone_type_id_data = $managerDefaultData.information_phone_type_personal_phone;
        }
        var result = {
            //PEOPLE
            id: null,
            last_name: null,
            name: null,
            birthdate: birthdate,
            business_id: this.business_id,
            gender_data: 0,
            //CUSTOMER
            identification_document: null,
            people_type_identification_id_data: people_type_identification_id_data_others_id,
            business_name: null,
            business_reason: null,
            ruc_type_id_data: null,
            //CUSTOMER INFORMATION
            customer_id: null,
            people_nationality_id_data: 71,
            people_profession_id_data: 1,
            customer_by_information: null,
            people_id_data: null,

            "street_one": null,
            "street_two": 'S/N',
            "reference": 'S/N',
            "has_location": true,
            "options_map": null,
            "information_address_location_current": null,

            //PHONE
            "information_phone_value": null,
            "information_phone_operator_id_data": information_phone_operator_id_data,
            "information_phone_type_id_data": information_phone_type_id_data
        };

        return result;
    },
    getNameAttribute: function (name) {
        var result = this.formConfig.nameModel + "[" + name + "]";
        return result;
    },
    getLabelForm: function (nameId) {
        var labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");
        if (nameId == 'name' || nameId == 'last_name') {
            labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

            if (this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc) {
                labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "  Contacto<span class='form__label--required'>*</span>" : "");

            }
        }
        return labelName;
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
        var customerData = {
            //CUSTOMER
            id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
            identification_document: this.$v.model.attributes.identification_document.$model,
            people_type_identification_id: this.$v.model.attributes.people_type_identification_id_data.$model,
            people_id: this.$v.model.attributes.people_id_data.$model,
            business_name: this.$v.model.attributes.business_name.$model,
            business_reason: this.$v.model.attributes.business_reason.$model,
            ruc_type_id: this.$v.model.attributes.ruc_type_id_data.$model,
            //CUSTOMER INFORMATION
            customer_id: this.$v.model.attributes.customer_id ? this.$v.model.attributes.customer_id.$model : -1,
            people_nationality_id: this.$v.model.attributes.people_nationality_id_data.$model,
            people_profession_id: this.$v.model.attributes.people_profession_id_data.$model,
            //PEOPLE
            last_name: this.$v.model.attributes.last_name.$model,
            name: this.$v.model.attributes.name.$model,
            birthdate: moment(this.$v.model.attributes.birthdate.$model).format("YYYY-MM-DD"),
            gender: this.$v.model.attributes.gender_data.$model,
            business_id: this.$v.model.attributes.business_id.$model,
            age: 0,
            customer_by_information_id: this.$v.model.attributes.customer_by_information_id ? this.$v.model.attributes.customer_by_information_id.$model : -1,

        };
        if (this.managerInformationAddress.allow) {
            customerData['information_address_type_id'] = 1;
            customerData['information_address_id'] = this.$v.model.attributes.information_address_id.$model ? this.$v.model.attributes.information_address_id.$model : -1;
            customerData['street_one'] = this.$v.model.attributes.street_one.$model;
            customerData['reference'] = this.$v.model.attributes.reference.$model;
            customerData['street_two'] = this.$v.model.attributes.street_two.$model;
            customerData['has_location'] = 1;
            customerData['options_map'] = this.$v.model.attributes.options_map.$model;
            customerData['information_address_location_current'] = this.$v.model.attributes.information_address_location_current.$model;


        }
        if (this.managerInformationPhone.allow) {
            customerData['information_phone_id'] = this.$v.model.attributes.information_phone_id.$model ? this.$v.model.attributes.information_phone_id.$model : -1;
            customerData['information_phone_value'] = this.$v.model.attributes.information_phone_value.$model;
            customerData['information_phone_operator_id'] = this.$v.model.attributes.information_phone_operator_id_data.$model;
            customerData['information_phone_type_id'] = this.$v.model.attributes.information_phone_type_id_data.$model;

        }

        var result = {
            Customer: customerData

        };


        return result;
    },
    resetForm: function () {

        this.$v.$reset();
        this.model = {
            attributes: this.getAttributesForm(),
            structure: this.getStructureForm()
        };
        this.managerInformationAddress.allow = false;
        this.managerInformationPhone.allow = false;
    },
    _valuesForm: function (event) {
        this.model.init = false;
        this.validateForm();
    },
    validateForm: function () {
        var currentAllow = this.getValidateForm();

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
            this.$v.model["attributes"]["gender_data"]["$invalid"]
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
                        "type": "address", "fields": ["street_one"]
                    });
                }
                if (this.$v.model.attributes.street_two.$invalid) {
                    errors.push({
                        "type": "address", "fields": ["street_two"]
                    });
                }
                if (this.$v.model.attributes.reference.$invalid) {
                    errors.push({
                        "type": "address", "fields": ["reference"]
                    });
                }

                if (this.$v.model.attributes.options_map.$invalid) {
                    errors.push({
                        "type": "address", "fields": ["options_map"]
                    });
                }
                success = false;
            }
        }
        if (this.managerInformationPhone.allow) {
            if (
                this.$v.model.attributes.information_phone_value.$invalid ||
                this.$v.model.attributes.information_phone_operator_id_data.$invalid ||
                this.$v.model.attributes.information_phone_type_id_data.$invalid
            ) {
                if (this.$v.model.attributes.information_phone_value.$invalid) {
                    errors.push({
                        "type": "phone", "fields": ["information_phone_value"]
                    });
                }
                if (this.$v.model.attributes.information_phone_operator_id_data.$invalid) {
                    errors.push({
                        "type": "phone", "fields": ["information_phone_operator_id_data"]
                    });
                }
                if (this.$v.model.attributes.information_phone_type_id_data.$invalid) {
                    errors.push({
                        "type": "phone", "fields": ["information_phone_type_id_data"]
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
    _managerS2InformationPhoneOperator: function (params) {
        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var dataCurrent = [];
        if (valueCurrentRowId) {

            dataCurrent = [this.model.attributes.information_phone_operator_id_data];

            var textCurrent = this.model.attributes.information_phone_operator_id_data.text;
            var idCurrent = this.model.attributes.information_phone_operator_id_data.id;
            var option = new Option(textCurrent, idCurrent, true, true);
            $(el).append(option).trigger('change');
        } else {
            if (this.model.attributes.information_phone_operator_id_data) {
                dataCurrent = [this.model.attributes.information_phone_operator_id_data];
                var textCurrent = this.model.attributes.information_phone_operator_id_data.text;
                var idCurrent = this.model.attributes.information_phone_operator_id_data.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }

        }
        var _this = this
        var elementInit = $(el).select2({
            allow: true,
            placeholder: "Seleccione",
            data: dataCurrent,
            ajax: {
                url: $("#action-information-phone-operator-getListSelect2").val(),
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
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            _this.model.attributes.information_phone_operator_id_data = data;
        }).on("select2:unselecting", function (e) {
            _this.model.attributes.lodging_room_levels_id_data = null;
            _this._setValueForm('information_phone_operator_id_data', null);
        }).on("select2:open", function (e) {
            managerModalSelect2();
        });
    },
    _managerS2InformationPhoneType: function (params) {
        var el = params.objSelector
        var valueCurrentRowId = params.rowId
        var dataCurrent = [];

        var _this = this;
        if (valueCurrentRowId) {

            dataCurrent = [this.model.attributes.information_phone_type_id_data];
            var textCurrent = this.model.attributes.information_phone_type_id_data.text;
            var idCurrent = this.model.attributes.information_phone_type_id_data.id;
            var option = new Option(textCurrent, idCurrent, true, true);
            $(el).append(option).trigger('change');
        } else {

            if (this.model.attributes.information_phone_type_id_data) {
                dataCurrent = [this.model.attributes.information_phone_type_id_data];
                var textCurrent = this.model.attributes.information_phone_type_id_data.text;
                var idCurrent = this.model.attributes.information_phone_type_id_data.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }


        }
        var elementInit = $(el).select2({
            allow: true,
            placeholder: "Seleccione",
            data: dataCurrent,
            ajax: {
                url: $("#action-information-phone-type-getListSelect2").val(),
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
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            _this.model.attributes.information_phone_type_id_data = data;
        }).on("select2:unselecting", function (e) {
            _this.model.attributes.lodging_room_levels_id_data = null;
            _this._setValueForm('information_phone_type_id_data', null);
        }).on("select2:open", function (e) {
            managerModalSelect2();
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

    onListenValidationForm: function () {//CUSTOMER-CREATE
        let _this = this;

        this.intervalForm = setInterval(function () {
            _this.onEmmitValidationForm();
        }, 2000); // El intervalo está en milisegundos (1 segundo = 1000 ms)

    },
    onEmmitValidationForm: function () {//CUSTOMER-CREATE
        var hasPeopleTax = this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc;
        if (hasPeopleTax) {
            if (this.managerInformationAddress.allow) {

            }
        } else {
            if (this.managerInformationAddress.allow) {

            }
        }

    },
};
var $directivesCustomer = {
    initS2InformationPhoneOperator: {
        inserted: function (el, binding, vnode, vm, arg) {
            var paramsInput = binding.value
            paramsInput._managerS2InformationPhoneOperator({
                objSelector: el, rowId: paramsInput.rowId
            });
        }
    }, initS2InformationPhoneType: {
        inserted: function (el, binding, vnode, vm, arg) {
            var paramsInput = binding.value
            paramsInput._managerS2InformationPhoneType({
                objSelector: el, rowId: paramsInput.rowId
            });
        }
    },
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
};

function getAttributesCustomer() {
    var $attributesCustomer = {
        //CUSTOMER
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
        'information_address_location_current': {},

        //Phone
        "information_phone_id": {},
        "information_phone_value": {},
        "information_phone_operator_id_data": {},
        "information_phone_type_id_data": {}

    };
    return $attributesCustomer;
}

function validationsCustomer() {
    var attributes = getAttributesCustomer();

    if (this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc) {
        attributes["business_name"] = {required};
        attributes["business_reason"] = {required};
        this.model.attributes.ruc_type_id_data = 1;
        attributes["ruc_type_id_data"] = {required};

    } else {
        this.model.attributes.ruc_type_id_data = 4;

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
    if (this.managerInformationPhone.allow) {
        attributes["information_phone_value"] = {required, maxLength: Validators.maxLength(150)};
        attributes["information_phone_operator_id_data"] = {};
        attributes["information_phone_type_id_data"] = {required};

    }
    var result = {
        model: {//change
            attributes: attributes
        },
    };
    return result;
}

function calculateTimeByDate(datePorLlegar, fechaActual) {
    var fechaLlegada = moment(datePorLlegar);
    var fechaActual = moment(fechaActual);

    var duracion = moment.duration(fechaLlegada.diff(fechaActual));
    var diferenciaFormat=duracion.format("d [dias], h [horas] ,m [minutos]");
    return diferenciaFormat;

}
function compareToDates(dateOne, dateTwo) {
    // Convierte las cadenas de fecha a objetos Date
    var fecha1 = (dateOne);
    var fecha2 = (dateTwo);
    // Compara las fechas
    var message = '';
    var typeCompare = -1;
    if (fecha1.getTime() > fecha2.getTime()) {
        message = "La fecha 1 es posterior a la fecha 2.";//PASO DE LA FECHA
        typeCompare = 1;

    } else if (fecha1.getTime() < fecha2.getTime()) {
        message = "La fecha 1 es anterior a la fecha 2.";//DENTRO DEL LIITE
        typeCompare = 2;

    } else if (fecha1.getTime() == fecha2.getTime()) {
        message = "Las fechas son iguales.";
        typeCompare = 3;

    }

    var diferenciaEnMilisegundos = Math.abs(fecha2 - fecha1);

    // Convierte la diferencia a días, horas, minutos y segundos
    var diferenciaEnSegundos = diferenciaEnMilisegundos / 1000;
    var segundos = Math.floor(diferenciaEnSegundos % 60);
    var diferenciaEnMinutos = diferenciaEnSegundos / 60;
    var minutos = Math.floor(diferenciaEnMinutos % 60);
    var diferenciaEnHoras = diferenciaEnMinutos / 60;
    var horas = Math.floor(diferenciaEnHoras % 24);
    var diferenciaEnDias = diferenciaEnHoras / 24;
    var dias = Math.floor(diferenciaEnDias);
    var valueView = "";


    if (dias > 0) {
        valueView += dias + (dias > 1 ? " dias" : " dia");
        valueView += " " + (horas + (horas > 1 ? " horas" : " hora")) + " ";
        valueView += " " + (minutos + (minutos > 1 ? " minutos" : " minuto")) + " ";
        valueView += " " + (segundos + (segundos > 1 ? " segundos" : " segundo")) + " ";

    } else if (horas > 0) {
        valueView += " " + (horas + (horas > 1 ? " horas" : " hora")) + " ";
        valueView += " " + (minutos + (minutos > 1 ? " minutos" : " minuto")) + " ";
        valueView += " " + (segundos + (segundos > 1 ? " segundos" : " segundo")) + " ";

    } else if (minutos > 0) {
        valueView += " " + (minutos + (minutos > 1 ? " minutos" : " minuto")) + " ";
        valueView += " " + (segundos + (segundos > 1 ? " segundos" : " segundo")) + " ";

    } else if (segundos > 0) {
        valueView += " " + (segundos + (segundos > 1 ? " segundos" : " segundo")) + " ";

    } else if (dias == 0 && horas == 0 && minutos == 0 && segundos == 0) {
        valueView += "Dia Actual.! ";

    }
    var date1 = moment(dateOne);
    var date2 = moment(dateTwo);
    const resultDates = moment.duration(date2.diff(date1));

    var diferenciaMinutos = date2.diff(date1, 'minutes');
    var diferenciaDias = date2.diff(date1, 'days');
    var diferenciaMeses = date2.diff(date1, 'months');
    var diferenciaYear = date2.diff(date1, 'years');

    var resultDifference = {
        one: {

            dias: dias,
            horas: horas,
            minutos: minutos,
            segundos: segundos
        }, two: {
            anios: diferenciaYear,
            meses: diferenciaMeses,
            dias: diferenciaDias,
            horas: horas,
            minutos: diferenciaMinutos,
            segundos: segundos
        }, three: {
            anios: resultDates.asYears(),
            meses: resultDates.asMonths(),
            dias: resultDates.asDays(),
            horas: resultDates.asHours(),
            minutos: resultDates.asMinutes(),
            segundos: resultDates.asSeconds()
        }

    };
    var type = -1;
    var difference = {message: "", value: 0}
    // Determina el resultado según las condiciones dadas

    if (diferenciaMinutos >= 60) {
        type = 1;
        difference.message = "La diferencia es mayor o igual a 60 minutos, ¡es hora!";
        difference.value = diferenciaMinutos;
    } else if (diferenciaDias >= 1 && diferenciaDias <= 30) {
        type = 2;

        difference.message = "La diferencia es mayor o igual a 1 día y menor a 30 días, ¡es un día!";
        difference.value = diferenciaDias;
    } else if (diferenciaMeses >= 1 && diferenciaMeses <= 12) {
        type = 3;

        return "La diferencia es mayor o igual a 1 mes y menor a 12 meses, ¡es un mes!";
        difference.value = diferenciaMeses;
    } else {
        type = 4;
        difference.message = "La diferencia no cumple ninguna de las condiciones especificadas.";
        difference.value = -1;

    }

    var diferenciaEnMilisegundos = Math.abs(dateOne - dateTwo);
    return {
        message: message,
        type: type,
        difference: difference,
        resultDifference: resultDifference,
        typeCompare: typeCompare,
        valueView: valueView,
        unix: diferenciaEnMilisegundos
    };
}

function stringToDate(dateString) {
    // Separa los componentes de la cadena de fecha
    var components = dateString.split(/[\s/:-]+/);

    // Determina el formato de la fecha (asume "año mes día" por defecto)
    var year, month, day;
    if (components.length === 3) {
        // Si hay tres componentes, podría ser "día mes año"
        if (components[0].length === 4) {
            // Es "año mes día"
            year = parseInt(components[0], 10);
            month = parseInt(components[1], 10) - 1;
            day = parseInt(components[2], 10);
        } else {
            // Es "día mes año"
            day = parseInt(components[0], 10);
            month = parseInt(components[1], 10) - 1;
            year = parseInt(components[2], 10);
        }
    } else if (components.length === 5) {

        day = parseInt(components[0], 10);
        month = parseInt(components[1], 10) - 1;
        year = parseInt(components[2], 10);

    } else {
        // Si no hay tres componentes, asume "año mes día"
        year = parseInt(components[0], 10);
        month = parseInt(components[1], 10) - 1;
        day = parseInt(components[2], 10);
    }

    // Obtiene los componentes específicos de la hora (si están presentes)
    var hour = components[3] ? parseInt(components[3], 10) : 0;
    var minute = components[4] ? parseInt(components[4], 10) : 0;
    var second = components[5] ? parseInt(components[5], 10) : 0;

    // Crea el objeto Date
    var date = new Date(year, month, day, hour, minute, second);

    // Valida si la fecha es válida
    if (
        isNaN(date.getFullYear()) ||
        isNaN(date.getMonth()) ||
        isNaN(date.getDate())
    ) {
        return null; // Devuelve null si la fecha no es válida
    }

    return date;
}
function addDaysByFormatString(dateCurrent, days) {
    var dateOriginal = stringToDate(dateCurrent);
    var newDate = new Date(dateOriginal);
    newDate.setDate(dateOriginal.getDate() + days);
    return newDate;
}
