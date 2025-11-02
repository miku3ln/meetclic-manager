let componentThisHumanResourcesEmployeeProfile;
Vue.component('human-resources-employee-profile-component', {

    components: {
        DateTimePicker: DateTimePicker//https://vuejsexamples.com/vue-datetime-picker/
    },
    template: '#human-resources-employee-profile-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput._managerS2Departments({
                    objSelector: el, model: paramsInput.model

                });
            },

        },
        initS2ScheduleList2: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput.onEvent({
                    objSelector: el, model: paramsInput.model

                });
            },

        },
        initS2AreaList2: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput.onEvent({
                    objSelector: el, model: paramsInput.model

                });
            },

        },
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value
                let paramsInit = paramsInput['paramsInit'];
                let initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        },
        initSummerNote: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                let initMethod = paramsInput['initMethod'];
                initMethod({
                    elementInit: el
                });

            }
        }
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        let vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);

        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.businessId =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisHumanResourcesEmployeeProfile = this;
        this.initCurrentComponent();

        removeClassNotView();

    },

    validations: function () {
        let attributes = {
            //CUSTOMER
            id: {},
            human_resources_employee_profile_id: {},
            identification_document: {required},//
            people_type_identification_id_data: {required},//
            people_id_data: {},
            business_name: {},
            business_reason: {},
            //PEOPLE
            last_name: {required},
            name: {required},
            date_of_birth: {required},
            contract_date: {required},
            gender_data: {required},
            people_nationality_id_data: {required},
            human_resources_department_id_data: {required},
            human_resources_organizational_chart_area_id_data: {required},
            human_resources_schedule_type_id_data: {required},

            people_profession_id: {required},
            description: {},
            summary_web: {},
            allow_view_page_web: {},
            "source": {required},
            "change": {}
        };
        if (this.model.attributes.people_type_identification_id_data == this.typeIdentificationRuc) {
            attributes["business_name"] = {required};
            attributes["business_reason"] = {required};
        }
        if (this.model.attributes.summary_web) {

            attributes["summary_web"] = {required};
        }

        let result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        let dataManager = {

//**Modal*

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
                        "title": "Gestion de Usuario",
                        "data-placement": "top",
                        "i-class": "fa fa-unlock-alt",
                        "managerType": "managerUserEntity"
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
            tabCurrentSelector: '#tab-humanResourcesEmployeeProfile',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#human-resources-employee-profile-form",
                url: $('#action-human-resources-employee-profile-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Personal.',
                successMessage: 'El personal se guardo correctamente.',
                nameModel: "HumanResourcesEmployeeProfile"
            },
            gridConfig: {
                selectorCurrent: "#human-resources-employee-profile-grid",
                url: $("#action-human-resources-employee-profile-admin").val()
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
            /*-----SUBRPROCESS---*/
            configModalBusinessByEmployeeProfile: {
                title: "Title",
                viewAllow: false,
                data: []

            },
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

        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");


            } else if (emitValues.type == "resetProcess") {
                let nameCurrent = emitValues.name;
                this[nameCurrent].viewAllow = false;
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
        makeToast: function (params) {
            let $msjCurrent = params.msj;
            let $titleCurrent = params.title;
            let $typeCurrent = params.type;

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
            let gridName = this.gridConfig.selectorCurrent;
            let urlCurrent = this.gridConfig.url;
            let business_id = this.businessId;
            let paramsFilters = {
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

                        let userAddClass = row.user_id ? 'add-information-user' : 'not-add-information-user';

                        let rolesString = "";
                        if (row.user_id) {

                            let rolesCurrent = row['roles'];
                            let count = Object.keys(rolesCurrent).length;
                            let countAux = 0;
                            $.each(rolesCurrent, function (indexRow, valueRow) {
                                if (count - 1 == countAux) {
                                    rolesString += valueRow + '.';

                                } else {
                                    rolesString += valueRow + ',';

                                }
                                countAux++;
                            });
                        }

                        let userInformation = row.user_id ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'></span><span class='content-description__value title'> Usuario Información</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Usuario:</span><span class='content-description__value'>" + row.username + "</span>",
                            "</div>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Email:</span><span class='content-description__value'>" + row.email + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Roles:</span><span class='content-description__value'>" + rolesString + "</span>",
                            "</div>"
                        ] : [];
                        userInformation = userInformation.join('');


                        let description = (row.name !== "null" && row.name) ? [
                            "<div class='content-description__information content-description__information--image'>",

                            "   <img class='content-description__image' src='" + $resourceRoot + row.src + "'> ",
                            "</div>",
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
                            "   <span class='content-description__title'>Nacionalidad :</span><span class='content-description__value'>" + (row.people_nationality) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Profesión :</span><span class='content-description__value'>" + (row.people_profession) + "</span>",
                            "</div>",
                            userInformation,
                        ] : [];
                        description = description.join("");
                        let result = [
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
            let vmCurrent = this;
            let selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            elementSelect.find("tbody tr").on("click", function (e) {
                let self = $(this);
                let dataRowId = $(self[0]).attr("data-row-id");
                let selectorRow;
                if (dataRowId) {
                    let instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                    let rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    let newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        let removeRowId = vmCurrent.managerMenuConfig.rowId;
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
            let result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                let setPush = {
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
            let params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
        _managerRowGrid: function (params) {
            let rowCurrent = params.row;
            let rowId = params.id;
            let entityType = 1;
            if (params.managerType == "updateEntity") {
                let elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.human_resources_employee_profile_id = rowCurrent.human_resources_employee_profile_id;
                this.model.attributes.identification_document = rowCurrent.identification_document;
                this.model.attributes.people_type_identification_id_data = rowCurrent.people_type_identification_id;
                this.model.attributes.people_id_data = rowCurrent.people_id;
                this.model.attributes.business_name = rowCurrent.business_name;
                this.model.attributes.business_reason = rowCurrent.business_reason;

                //PEOPLE
                this.model.attributes.last_name = rowCurrent.last_name;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.date_of_birth = rowCurrent.date_of_birth;
                this.model.attributes.contract_date = rowCurrent.contract_date;

                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.summary_web = rowCurrent.summary_web;
                this.model.attributes.gender_data = rowCurrent.gender;
                // CUSTOMER INFORMATION
                this.model.attributes.people_nationality_id_data = rowCurrent.people_nationality_id;
                this.model.attributes.people_profession_id = rowCurrent.people_profession_id;
                this.model.attributes.human_resources_department_id_data = {
                    id: rowCurrent.human_resources_department_id,
                    text: rowCurrent.human_resources_department
                };
                this.model.attributes.allow_view_page_web = rowCurrent.allow_view_page_web;


                this.model.attributes.source = rowCurrent.src;


                this.model.attributes.human_resources_schedule_type_id_data = {
                    id: rowCurrent.human_resources_schedule_type_id,
                    text: rowCurrent.human_resources_shedule_type
                };

                this.model.attributes.human_resources_organizational_chart_area_id_data = {
                    id: rowCurrent.human_resources_organizational_chart_area_id,
                    text: rowCurrent.human_resources_organizational_chart_area
                };
                this._viewManager(3, rowId);


            } else if (params.managerType == "managerUserEntity") {

                this.configModalBusinessByEmployeeProfile.data = rowCurrent;
                if (this.configModalBusinessByEmployeeProfile.viewAllow) {
                    this.$refs.refBusinessByEmployeeProfile._setValueOfParent(
                        {type: "openModal", data: this.configModalBusinessByEmployeeProfile}
                    );
                } else {
                    this.configModalBusinessByEmployeeProfile.viewAllow = true;
                }

            } else if (params.managerType == "mailsEntity") {
                this.configModalInformationMail.data = {
                    entity_id: rowId,
                    entity_type: entityType,
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
                    entity_type: entityType,
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
                    entity_type: entityType,
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

            } else if (params.managerType == 'addressEntity') {

                this.configModalInformationAddress.data = {
                    entity_id: rowId,
                    entity_type: entityType,
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
            let result = false
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
            let result = {

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
                human_resources_department_id_data: {
                    id: "human_resources_department_id",
                    name: "human_resources_department_id",
                    label: "Departamento",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                human_resources_organizational_chart_area_id_data: {
                    id: "human_resources_organizational_chart_area_id",
                    name: "human_resources_organizational_chart_area_id",
                    label: "Areas",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                human_resources_schedule_type_id_data: {
                    id: "human_resources_schedule_type_id",
                    name: "human_resources_schedule_type_id",
                    label: "Horario",
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
                date_of_birth: {
                    id: "date_of_birth",
                    name: "date_of_birth",
                    label: "Fecha Nacimiento",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                contract_date: {
                    id: "contract_date",
                    name: "contract_date",
                    label: "Fecha Contrato",
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
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                summary_web: {
                    id: "summary_web",
                    name: "summary_web",
                    label: "Resumen Perfil",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                'allow_view_page_web': {
                    id: "allow_view_page_web",
                    name: "allow_view_page_web",
                    label: "Mostrar en la Web?",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        },
                    options: [{"value": 0, "text": "NO"}, {"value": 1, "text": "SI"}]
                },
                source: {
                    id: "source",
                    name: "source",
                    label: "Imagen",
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
            let result = {
                //PEOPLE
                last_name: null,
                name: null,
                date_of_birth: null,
                contract_date: null,
                gender_data: 0,
                description: null,
                summary_web: '',
                allow_view_page_web: 0,
                //CUSTOMER
                identification_document: null,
                people_type_identification_id_data: 2,
                business_name: null,
                business_reason: null,

                //CUSTOMER INFORMATION
                human_resources_employee_profile_id: null,
                people_nationality_id_data: 71,
                human_resources_department_id_data: null,
                human_resources_schedule_type_id_data: null,
                human_resources_organizational_chart_area_id_data: null,

                people_profession_id: 1,
                people_id_data: null,
                "source": null,
                "change": false
            };

            return result;
        },
        getNameAttribute: function (name) {
            let result = this.formConfig.nameModel + "[" + name + "]";
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

            let result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
        getErrorHas: function (model, type) {

            let result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            let result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {

            let result = {

                //CUSTOMER
                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                identification_document: this.$v.model.attributes.identification_document.$model,
                people_type_identification_id: this.$v.model.attributes.people_type_identification_id_data.$model,
                people_id: this.$v.model.attributes.people_id_data.$model,
                business_name: this.$v.model.attributes.business_name.$model,
                business_reason: this.$v.model.attributes.business_reason.$model,
                //CUSTOMER INFORMATION
                human_resources_employee_profile_id: this.$v.model.attributes.human_resources_employee_profile_id ? this.$v.model.attributes.human_resources_employee_profile_id.$model : -1,
                people_nationality_id: this.$v.model.attributes.people_nationality_id_data.$model,
                people_profession_id: this.$v.model.attributes.people_profession_id.$model,
                human_resources_department_id: this.$v.model.attributes.human_resources_department_id_data.$model.id,
                human_resources_schedule_type_id: this.$v.model.attributes.human_resources_schedule_type_id_data.$model.id,
                human_resources_organizational_chart_area_id: this.$v.model.attributes.human_resources_organizational_chart_area_id_data.$model.id,
                //PEOPLE
                last_name: this.$v.model.attributes.last_name.$model,
                name: this.$v.model.attributes.name.$model,
                date_of_birth: moment(this.$v.model.attributes.date_of_birth.$model).format("YYYY-MM-DD"),
                contract_date: moment(this.$v.model.attributes.contract_date.$model).format("YYYY-MM-DD"),
                gender: this.$v.model.attributes.gender_data.$model,
                age: 0,
                business_id: this.businessId,
                description: this.$v.model.attributes.description ? this.$v.model.attributes.description.$model : '',
                summary_web: this.$v.model.attributes.summary_web ? this.$v.model.attributes.summary_web.$model : '',
                allow_view_page_web: this.$v.model.attributes.allow_view_page_web.$model,
                "source": this.$v.model.attributes.source.$model,
                change: this.$v.model.attributes.change.$model,


            };
            return result;
        },
        _saveModel: function () {
            let dataSendResult = this.getValuesSave();
            let dataSend = dataSendResult;
            let vCurrent = this;
            vCurrent.$v.$touch();
            let validateCurrent = this.validateForm();
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


                            } else {

                            }
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent.resetForm();
                            vCurrent._viewManager(2);
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
            this.model.attributes.id = null;
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            let currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm: getValidateForm,
        _resetModel: function (model) {
            model.$reset();

        },
        _managerS2Departments: function (params) {
            let businessId = this.businessId;

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {

                dataCurrent = [this.model.attributes.human_resources_department_id_data];
            }
            let _this = this;
            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Menu Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-department-listAll").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        let parent_manager_id = -1;
                        let parent_manager = _this.model.attributes.human_resources_organizational_chart_area_id_data;
                        if (parent_manager != null && Object.keys(parent_manager).length) {
                            parent_manager_id = parent_manager.id;
                        }

                        let paramsFilters = {
                            filters: {
                                search_value: term,
                                businessId: businessId,
                                parent_manager_id: parent_manager_id
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
                width: '100%',
            });
            elementInit.on('select2:select', function (e) {
                let data = e.params.data;
                _this.model.attributes.human_resources_department_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.human_resources_department_id_data = null;
                _this._setValueForm('human_resources_department_id_data', null);
            });


        },
        onScheduleList2: function (params) {
            let businessId = this.businessId;

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            let keyManager = 'human_resources_schedule_type_id_data';
            if (valueCurrent) {

                dataCurrent = [this.model.attributes[keyManager]];
            }
            let _this = this;
            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Menu Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-schedule-type-listAll").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {

                        let paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
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
                width: '100%',
            });
            elementInit.on('select2:select', function (e) {
                let data = e.params.data;
                _this.model.attributes[keyManager] = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyManager] = null;
                _this._setValueForm(keyManager, null);
            });


        },
        onAreaList2: function (params) {
            let businessId = this.businessId;

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            let keyManager = 'human_resources_organizational_chart_area_id_data';
            if (valueCurrent) {

                dataCurrent = [this.model.attributes[keyManager]];
            }
            let _this = this;
            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Menu Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-organizational-chart-area-listAll").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {

                        let paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
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
                width: '100%',
            });
            elementInit.on('select2:select', function (e) {
                let data = e.params.data;
                _this.model.attributes[keyManager] = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyManager] = null;
                _this._setValueForm(keyManager, null);
            });


        },
//uploads methods
        _uploadDataImage: function (eventSelector) {

            selectorFile = '#file-' + 'source';
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
        getAttributesManagerUpload: function (params) {
            let nameField = params['nameField'];
            let modelCurrent = params['modelCurrent'];

            let result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _managerEventsUpload: function (params) {
            let selectorUpload = params['selectorUpload'];
            let selectorPreview = params['selectorPreview'];
            let modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        },
        _initSummerNote: function (params) {
            let elementInit = params['elementInit'];
            let fieldCurrent = $(elementInit).attr('id');
            let $this = this;
            if (this.model.attributes.id) {
                let htmlSet = this.model.attributes[fieldCurrent];
                $(elementInit).html(htmlSet);
            }
            $(elementInit).summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false,              // set focus to editable area after initializing summernote
                callbacks: {
                    onChange: function (contents, $editable) {

                        if ('<p><br></p>' == contents || '' == contents) {
                            $this.$v.model.attributes[fieldCurrent].$model = null;
                        } else {
                            $this.$v.model.attributes[fieldCurrent].$model = contents;
                        }
                    }
                }
            });


        }
    }
})
;

