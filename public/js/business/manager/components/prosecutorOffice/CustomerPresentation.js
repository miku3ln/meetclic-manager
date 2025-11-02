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
var $configManagerProcessCurrent = {};
Vue.component($configProcess['entity-process-down'] + '-component', {

    components: {
        DateTimePicker: DateTimePicker
    },
    template: '#' + $configProcess['entity-process-down'] + '-template',
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
        $configManagerProcessCurrent = $configPartial;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: function () {
        var attributes = {
                //CUSTOMER
                id: {},
                customer_id: {required},
                customer_id_text: {},
                state: {},
                prosecution_process_number: {required},
                judical_process_number: {required},//
                date_of_presentation: {required},//
                due_date: {},//
                observation: {},//
                date_of_state: {},//
                date_of_presentation_hour: {required},//


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
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-' + $configProcess['entityCamel'],
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#" + $configProcess['entityCamel'] + "-form",
                url: $('#action-' + $configProcess['entity-process-down'] + '-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Proceso.',
                successMessage: 'El registro se guardo correctamente.',
                nameModel: $configProcess['model']
            },
            gridConfig: {
                selectorCurrent: "#" + $configProcess['entity-process-down'] + "-grid",
                url: $("#action-" + $configProcess['entity-process-down'] + "-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            typeIdentificationRuc: 1,
            peopleNationalityData: $configPartial["dataCatalogue"]["peopleNationality"],
            peopleProfessionData: $configPartial["dataCatalogue"]["peopleProfession"],
            peopleTypeIdentificationData: $configPartial["dataCatalogue"]["peopleTypeIdentification"],
            rucTypeData: $configPartial["dataCatalogue"]["rucType"],
            stateData: $configProcess["data"]["stateData"],

            managerCustomerSearch: {
                view: false,
                customersAll: [],
                map: null,
                viewLoading: true
            },
            configModalAddDataCustomer: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            business_id: null,
            //MODALS CONFIGURATION

            configModalChangeProcess: {
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
        onEmmitValidationForm: function () {


        },

        onListenValidationForm: function () {
            let _this = this;

            this.intervalForm = setInterval(function () {
                _this.onEmmitValidationForm();
            }, 2000); // El intervalo está en milisegundos (1 segundo = 1000 ms)

        },
        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            var componentName = "";
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            } else if (emitValues.type == "_saveModel") {
                componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
                var dataSave = emitValues.data;
                if (dataSave.isSave) {
                    var customerData = dataSave.data['CustomerManager'];
                    var option = new Option(customerData.text, customerData.id, true, true);
                    $('.customer_id').append(option).trigger('change');
                    this._setValueForm('customer_id', customerData.id);
                }

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
        getValuesDateIni: function (row) {
            var dateCurrent = row.date_of_presentation;
            var deliver_days = 0;
            var resultNew = addDaysByFormatString(dateCurrent, deliver_days);
            var success = false;
            var currentManagerDate = new Date();
            var resultCompare = compareToDates(resultNew, currentManagerDate);
            var day = resultNew.getDate();
            var month = resultNew.getMonth() + 1; // Meses en JavaScript son 0-indexados
            var year = resultNew.getFullYear();

            var dateDelivery = day + "/" + (month < 10 ? '0' : '') + month + "/" + year + " " + resultNew.getHours() + ":" + resultNew.getMinutes();
            var classColor = 'label label-info';
            var message = "S/N";
            if (resultCompare.typeCompare == 3) {
                classColor = 'label label-info';
                message = "Dia de Entrega.!";
                success = true;
            } else if (resultCompare.typeCompare == 1) {
                classColor = 'label label-warning';
                message = dateDelivery + " a " + resultCompare.valueView;
                success = true;

            } else if (resultCompare.typeCompare == 2) {
                classColor = 'label label-danger';
                message = dateDelivery + " pasado " + resultCompare.valueView;
                success = false;

            }
            return {
                classColor: classColor,
                message: message,
                dateDelivery: dateDelivery,
                resultCompare: resultCompare,
                success: success
            };
        },
        initGridManager: function (vmCurrent) {
            var $scope = this;
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


                        var managerInit = $scope.getValuesDateIni(row);

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

                        var stateInfo = $configProcess["data"]["stateData"].find(function (stateOrder) {
                            return stateOrder.id == row.state;
                        });
                        var presentation = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado de Proceso:</span><span class='content-description__value " + stateInfo.class + " '>" + (stateInfo.text) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'># Proceso Fiscal:</span><span class='content-description__value'>" + (row.prosecution_process_number) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'># Proceso Judicatura:</span><span class='content-description__value'>" + (row.prosecution_process_number) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Fecha de Inicio Presentacion:</span><span class='content-description__value " + managerInit.classColor + " '>" + (managerInit.message) + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Observaciones:</span><span class='content-description__value'>" + (row.observation) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'></span><span class='content-description__value center content-description__value--title'> Persona</span>",
                            "</div>",
                        ];
                        var result = [
                            "<div class='content-description'>",
                            presentation.join(""),

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
                this._viewManager(3, rowId);
                this.resetForm();
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;

                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.customer_id = rowCurrent.customer_id;
                this.model.attributes.customer_id_text = rowCurrent.identification_document + " - " + rowCurrent.name + " " + rowCurrent.last_name;


                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.owner_id = rowCurrent.owner_id;
                this.model.attributes.prosecution_process_number = rowCurrent.prosecution_process_number;
                this.model.attributes.judical_process_number = rowCurrent.judical_process_number;
                this.model.attributes.date_of_presentation = moment(rowCurrent.date_of_presentation).format("YYYY-MM-DD");
                this.model.attributes.date_of_presentation_hour = moment(rowCurrent.date_of_presentation).format("HH:mm:ss");


                this.model.attributes.observation = rowCurrent.observation;
                this.model.attributes.date_of_state = rowCurrent.date_of_state;
                this.model.attributes.business_id = rowCurrent.business_id;


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

        onAddCustomer: function () {
            this.configModalAddDataCustomer.viewAllow = true;
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

                customer_id: {
                    id: "customer_id",
                    name: "customer_id",
                    label: "Persona",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                state: {
                    id: "state",
                    name: "state",
                    label: "Estado Proceso",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                prosecution_process_number: {
                    id: "prosecution_process_number",
                    name: "prosecution_process_number",
                    label: "# Proceso Fiscal",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                judical_process_number: {
                    id: "judical_process_number",
                    name: "judical_process_number",
                    label: "# Proceso Judicatura",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                date_of_presentation: {
                    id: "date_of_presentation",
                    name: "date_of_presentation",
                    label: "Fecha de Inicio Presentacion",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                date_of_presentation_hour: {
                    id: "date_of_presentation_hour",
                    name: "date_of_presentation_hour",
                    label: "Hora Presentacion",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                due_date: {
                    id: "due_date",
                    name: "due_date",
                    label: "Fecha Culminacion",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                observation: {
                    id: "observation",
                    name: "observation",
                    label: "Observaciones",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

            };

            return result;
        },
        getAttributesForm: function () {


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
            var date_of_presentation = year + '-' + month + '-' + day;

            var timeString = moment(dateCurrent).format("HH:mm:ss");
            var result = {
                //PEOPLE
                customer_id: null,
                customer_id_text: '',
                state: 0,
                prosecution_process_number: null,
                judical_process_number: '',
                date_of_presentation: date_of_presentation,
                date_of_presentation_hour: timeString,

                observation: '',


            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: function (nameId) {
            var labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

            return labelName;
        },
        _setValueForm: function (name, value) {

            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: getClassErrorForm,
        getErrorHas: getErrorHas,
        getViewError: getViewErrorForm,
//Manager Model
        getValuesSave: function () {
            var data = {
                //CUSTOMER
                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                customer_id: this.$v.model.attributes.customer_id.$model,
                state: this.$v.model.attributes.state.$model,
                prosecution_process_number: this.$v.model.attributes.prosecution_process_number.$model,
                judical_process_number: this.$v.model.attributes.judical_process_number.$model,
                date_of_presentation: this.$v.model.attributes.date_of_presentation.$model + " " + this.$v.model.attributes.date_of_presentation_hour.$model,
                due_date: this.$v.model.attributes.due_date.$model,
                observation: this.$v.model.attributes.observation ? this.$v.model.attributes.observation.$model : -1,
                date_of_state: this.$v.model.attributes.date_of_state.$model,
                //  birthdate: moment(this.$v.model.attributes.birthdate.$model).format("YYYY-MM-DD"),
                business_id: _this.business_id,
            };
            var result = {};
            result[$configProcess['model']] = data;
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
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            $(".customer_id").val(null).trigger('change');

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
                this.$v.model["attributes"]["customer_id"]["$invalid"] ||
                this.$v.model["attributes"]["state"]["$invalid"] ||
                this.$v.model["attributes"]["prosecution_process_number"]["$invalid"] ||
                this.$v.model["attributes"]["judical_process_number"]["$invalid"] ||
                this.$v.model["attributes"]["date_of_presentation"]["$invalid"] ||
                this.$v.model["attributes"]["date_of_presentation_hour"]["$invalid"] ||
                this.$v.model["attributes"]["due_date"]["$invalid"] ||
                this.$v.model["attributes"]["observation"]["$invalid"]
            ) {

                if (this.$v.model["attributes"]["customer_id"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["customer_id"]
                    });
                }
                if (this.$v.model["attributes"]["state"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["state"]
                    });
                }
                if (this.$v.model["attributes"]["prosecution_process_number"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["prosecution_process_number"]
                    });
                }
                if (this.$v.model["attributes"]["judical_process_number"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["judical_process_number"]
                    });
                }
                if (this.$v.model["attributes"]["date_of_presentation"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["date_of_presentation"]
                    });
                }
                if (this.$v.model["attributes"]["date_of_presentation_hour"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["date_of_presentation_hour"]
                    });
                }
                if (this.$v.model["attributes"]["due_date"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["due_date"]
                    });
                }
                if (this.$v.model["attributes"]["observation"]["$invalid"]) {
                    errors.push({
                        "type": "form", "fields": ["observation"]
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
        _resetModel: function (model) {
            model.$reset();

        },
        _customersList: function (params) {
            var el = params.objSelector;
            _this = this;
            var allowGet = false;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione una Persona.",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-customer-getListS2Customer").val(),
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
                multiple: false,
                width: '100%'
            });
            elementInit.on('select2:select', function (e) {
                var dataCurrent = elementInit.select2('data');
                var dataSelect = e.params.data;
                var needle = dataSelect.id;
                _this._setValueForm('customer_id', dataCurrent[0]['id']);

            }).on("select2:unselecting", function (e) {
                console.log('unselecting');
                _this._setValueForm('customer_id', null);

            }).on("change", function (e) {

            });
            if (this.model.attributes.id) {
                var option = new Option(this.model.attributes.customer_id_text, this.model.attributes.customer_id, true, true);
                elementInit.append(option).trigger('change');
            }

        },


    }
})
;

