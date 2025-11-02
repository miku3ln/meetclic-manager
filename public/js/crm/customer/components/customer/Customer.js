var componentThisCustomer;
Vue.component('customer-component', {

    components: {
        DateTimePicker: DateTimePicker
    },
    template: '#customer-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Action({
                    objSelector: el, model: paramsInput.model

                });


            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        },
        resetModel: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._resetModel(paramsInput.model);


            },
        }
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
        componentThisCustomer = this;
        this.initCurrentComponent();
        console.log("mouted");
    },

    validations: function () {
        var attributes = {
            //CUSTOMER
            id: {},
            customer_id: {},
            customer_by_information_id: {},
            identification_document: {required},//
            people_type_identification_id_data: {required},//
            people_id_data: {},
            business_name: {},
            business_reason: {},
            ruc_type_id_data: {required},
            //PEOPLE
            last_name: {required},
            name: {required},
            birthdate: {required},
            gender_data: {required},
            // CUSTOMER INFORMATION
            people_nationality_id_data: {required},
            people_profession_id_data: {required},
        };
        if (this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc) {
            attributes["business_name"] = {required};
            attributes["business_reason"] = {required};
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

//**Modal*

            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
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
                url: $('#action_customer_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Cliente.',
                successMessage: 'El cliente se guardo correctamente.',
                nameModel: "Customer"
            },
            gridConfig: {
                selectorCurrent: "#customer-grid",
                url: $("#action_customer_admin").val()
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
            var paramsFilters = {};
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
                            description,
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
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.customer_id = rowCurrent.customer_id;
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
            };

            return result;
        },
        getAttributesForm: function () {
            var people_type_identification_id_data_others_id=3;
            var result = {
                //PEOPLE
                last_name: null,
                name: null,
                birthdate: null,
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

            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,
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

            var result = {
                Customer: {
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
                    age: 0,
                    customer_by_information_id: this.$v.model.attributes.customer_by_information_id ? this.$v.model.attributes.customer_by_information_id.$model : -1,

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
        getValidateForm:getValidateForm,
        _resetModel: function (model) {
            model.$reset();

        }

    }
})
;

