var componentThisManagementFormEvent;
Vue.component('management-form-event-component', {
    template: '#management-form-event-template',
    directives: {


    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;
        console.log(this.configParams);

    },
    mounted: function () {
        componentThisManagementFormEvent = this;
        this.initCurrentComponent();
    },

    data: function () {

        var dataManager = {
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configParams: {},
            labelsConfig: {
                "title": "Formulario de Registro",
                "event": "",

                buttons: {
                    return: "Regresar",
                    verify: "Verificar",
                    manager: "Agregar al Carrito."
                },
                msg: {
                    customers_user: "Si no aparece tu nombre de usuario,Registrate o registra a tus amigos para poder seguir con los pasos de inscripcion."
                }
            },

            tabCurrentSelector: '#modal-management-form-event',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#management-form-event-form",
                url: $('#action-management-form-event-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ManagementFormEvent.',
                successMessage: 'El ManagementFormEvent se guardo correctamente.',
                nameModel: "ManagementFormEvent"
            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerCustomers: null,
            optionsTeams: [],
            optionsCategories: [],
            optionsSizes: [],
            optionsColors: [],
            optionsDistances: [],
            optionsManagementDistances: [],
            optionsManagementKits: [],
            modelAux: [],
            modelView: [],
            managementViews: {
                preview: false,
                management: true
            },
            preview: false
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            this.modelAux=  this.configParams;
            this.modelView = this.setManagementView();

            this.initDataModal();
            this.$refs.refManagementFormEventModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalManagementFormEvent'
            });
        },
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._resetComponent();

        },

        _cancel: function () {
            this.$refs.refManagementFormEventModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
            this.labelsConfig.event = rowCurrent.name;

        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refManagementFormEventModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_carouselEvents', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            }
        },

        managementData: function (params) {

        },
//MANAGER PROCESS

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

                team_id: {
                    id: "team_id",
                    name: "team_id",
                    label: "Equipo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                    data: []
                },
                distance_id: {
                    id: "distance_id",
                    name: "distance_id",
                    label: "Distancia/Precio",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                kit_id: {
                    id: "kit_id",
                    name: "kit_id",
                    label: "Kit",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }

                },
                user_id: {
                    id: "user_id",
                    name: "user_id",
                    label: "Nombre de Usuario",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                size_id: {
                    id: "size_id",
                    name: "size_id",
                    label: "Talla",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                color_id: {
                    id: "color_id",
                    name: "color_id",
                    label: "Color",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                category_id: {
                    id: "category_id",
                    name: "category_id",
                    label: "Categoria",
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
            var result = {
                team_id: null,
                distance_id: null,
                people: []

            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        getClassErrorForm: function (nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        }
        ,
//Manager Model
        resetForm: function () {


        }
       ,




//others functions

        getDistanceCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsDistances;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getTeamCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsTeams;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getCategoryCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsCategories;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getDataCurrent: function (params) {
            var needle = params['needle'];
            var haystack = params['haystack'];
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.id == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        setManagementView: function () {
            var haystack = this.modelAux.data.people;
            var people = [];

            var $scope = this;
            $.each(haystack, function (k, v) {


                var kits = v.data;
                var kitCurrent = [];
                $.each(kits, function (kKit, vKit) {
                    var has_size = vKit.size_id;
                    var has_color = vKit.color_id;
                    var nameKit = vKit.product;
                    var kitVariants = [];
                    if (has_size) {
                        var setPushKit = 'Talla:' + vKit.product_sizes;
                        kitVariants.push(setPushKit);

                    }
                    if (has_color) {

                        var setPushKit = 'Color:' + vKit.product_color;
                        kitVariants.push(setPushKit);
                    }

                    if (Object.keys(kitVariants).length > 0) {
                        nameKit = nameKit + ' - ' + kitVariants.join(',') + '<br>';
                    } else {
                        nameKit = nameKit + '<br>';

                    }
                    kitCurrent.push(nameKit);
                });

                var setPush = {

                    'one': {
                        'label': 'Participante Nro ' + (k + 1) + ' :',
                        'value': v.full_name,
                        'id': v.user_id
                    },
                    'two': {
                        'label': 'Tipo Doc :',
                        'value': '',
                    },
                    'three': {
                        'label': 'Nro Documento :',
                        'value': '',
                    },
                    'four': {
                        'label': 'Fecha de Nacimiento :',
                        'value': '',
                    },
                    'five': {
                        'label': 'Telefono :',
                        'value': '',
                    },
                    'six': {
                        'label': 'Correo Electronico',
                        'value': '',
                    },
                    'seven': {
                        'label': 'Genero',
                        'value': '',
                    },
                    'eight': {
                        'label': 'Categoria :',
                        'value': v.events_trails_type_of_categories,
                    },
                    'nine': {
                        'label': 'Kit :',
                        'value': kitCurrent.join(''),
                        'data': kits
                    },


                };
                people.push(setPush);


            });
            var team = this.modelAux.data. eventConfig.team;
            var distance =  this.modelAux.data. eventConfig.distance;
            var result = {
                team: team.events_trails_type_teams,
                team_id: team.id,
                distance: distance.events_trails_distances,
                distance_id: distance.id,
                people: people,
            };

            return result;
        },



    }
})
;


var appInit = new Vue(
    {
        el: '#app-management',
        directives: {},
        created: function () {

            var $scope = this;
            this.$root.$on("_carouselEvents", function (emitValue) {
                $scope._managerTypes(emitValue);
            });
        },
        mounted: function () {
            appThisComponent = this;
            var $this = this;
            $(document).ready(function () {
            });
        },
        data: function () {
            var result = {
                overriddenNetworks: {
                    "custom": {
                        "type": "popup"
                    },
                },

                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }

            };

            return result;
        },
        methods: {
            ...$methodsFormValid,

            initManagement: function () {
                console.log('init');
            }
            , _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false


                }
            }, _managementTakePart: function (params) {
                var id = params['id'];
                var dataCurrent = JSON.parse($('#' + id).attr('data'));


                var dataEvent = {
                    name: dataCurrent.eventConfig.event.events_trails_project,
                    id: dataCurrent.eventConfig.event.id,
                    people:dataCurrent.people,
                    eventConfig:dataCurrent.eventConfig
                };

                this.configModalManagementFormEvent.data = dataEvent;
                this.configModalManagementFormEvent.viewAllow = true;

            },
        }
    })
;
appInit.initManagement();
