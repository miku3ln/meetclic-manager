<script id="grid-registers-script">

    function buildDocumentsRequireTable(rows) {
        if (!Array.isArray(rows) || rows.length === 0) {
            return '<p class="text-muted">Sin registros</p>';
        }

        var tbody = rows.map(r => `
<span class="badge badge--size-large badge--bee-points">(${r.code})${r.name}</span>`).join('');

        return `${tbody}
  `;
    }

    Vue.component('grid-registers-component', {
        components: {},
        template: '#grid-registers-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
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
            var vmCurrent = this;
            this.$root.$on("grid-registers", function (emitValue) {
                console.log("grid-registers", emitValue)
                vmCurrent._managerTypes(emitValue);
            });
            this.sendDataParent({action: 'created', child: this.nameComponent});


        },
        beforeMount: function () {
            this.configParams = this.params;
            this.sendDataParent({action: 'beforeMount', child: this.nameComponent});

        },
        mounted: function () {
            componentThisEventsTrailsProject = this;
            this.initCurrentComponent();

            this.sendDataParent({action: 'mounted', child: this.nameComponent});
        },
        computed: {},

        data: function () {

            var dataManager = {
                business_id: null,
                /*  ----MANAGER ENTITY---*/
                configModelEntity: {
                    "buttonsManagements": [


                        {
                            "title": "Editar Embarcacion",
                            "data-placement": "top",
                            "i-class": "fa fa-pencil",
                            "managerType": "managementUpdateVessel",
                            "isUrl": false,

                        },
                        {
                            "title": "Agregar Responsables",
                            "data-placement": "top",
                            "i-class": "fa fa-anchor",
                            "managerType": "maritimeVesselResponsibles",
                            "isUrl": false,

                        },
                    ]
                },
                managerMenuConfig: {
                    view: false,
                    menuCurrent: [],
                    rowId: null
                },
                configParams: {},
                labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
                processName: "Registro Acción.",

//Grid config
                gridConfig: {
                    selectorCurrent: "#grid-registers-grid",
                    url: $("#action-management-admin").val()
                },
                submitStatus: "no",
                showManager: false,
                managerType: null,
                search: {
                    needle: ''
                },
                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }, configModalManagementFormEventDetails: {
                    viewAllow: false
                },
                configMaritimeVesselResponsibles: {
                    viewAllow: false
                },
                managerCurrentBusiness: null,
                nameComponent: 'grid-registers',
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
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false;
                    this.configModalManagementFormEventDetails.viewAllow = false;


                }
            },
            /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
            makeToast: makeToast,
//MANAGER PROCESS
            /*---------GRID--------*/
            _destroyTooltip: _destroyTooltip,
            _resetManagerGrid: _resetManagerGrid,
            _managerMenuGrid: _managerMenuGrid,
            getMenuConfig: function (params) {
                var result = [];
                $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                    var setPush = {
                        title: value["title"],
                        isUrl: value["isUrl"],
                        url: value["url"],
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
            _gridManager: _gridManager,
            _managerRowGrid: function (params) {
                var $scope = this;
                var rowCurrent = params.row;
                var rowId = params.id;
                if (params.managerType == "managementUpdateVessel") {
                    console.log(rowCurrent);
                    this.configModalManagementFormEvent.data = rowCurrent;
                    this.configModalManagementFormEvent.viewAllow = true;

                    this.sendDataParent({
                        action: 'managementUpdateVessel',
                        child: this.nameComponent,
                        data: rowCurrent
                    });

                } else if (params.managerType == "maritimeVesselResponsibles") {
                    this.configMaritimeVesselResponsibles.data = rowCurrent;
                    this.configMaritimeVesselResponsibles.viewAllow = true;
                    this.sendDataParent({
                        action:params.managerType,
                        child: this.nameComponent,
                        data: rowCurrent
                    });
                }

            },
            initGridManager: function (vmCurrent) {
                var gridName = this.gridConfig.selectorCurrent;
                var urlCurrent = this.gridConfig.url;
                var business_id = -1;

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
                    labels: $labelsGridConfigDefault,
                    css: getCSSCurrentBootGrid(),
                    formatters: {
                        'description': function (column, row) {
                            var data = row;

                            var $languageCurrent = null;
                            var passager = buildDocumentsRequireTable(data.documents);
                            var result = [
                                "<div class='content-management-rows'>",

                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Tipo Tecnico :</span><span class='content-description__value'>" + (data.technical_info_type == 'N_A' ? "N/A" : "Memoria Tecnica") + "</span>",
                                "   </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Tipo de Embarque :</span><span class='content-description__value'>" + (data.vessel_type) + passager + "</span>",
                                "  </div>",

                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Muelle :</span><span class='content-description__value'>" + ((data.business_title)) + "</span>",
                                "  </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Nombre del Embarcacion :</span><span class='content-description__value'>" + ((data.name)) + "</span>",
                                "  </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Propietario :</span><span class='content-description__value'>" + ((data.owner_name)) + "</span>",
                                "  </div>",

                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Eslara :</span><span class='content-description__value'>" + (parseFloat(data.length)) + "(mt)" + "</span>",
                                "  </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Manga :</span><span class='content-description__value'>" + (parseFloat(data.beam)) + "(mt)" + "</span>",
                                "  </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Puntal :</span><span class='content-description__value'>" + (parseFloat(data.draft)) + "(cm)" + "</span>",
                                "  </div>",
                                "  <div class='content-description__information'>",
                                "   <span class='content-description__title'>Cantidad de Pasajeros :</span><span class='content-description__value'>" + ((data.passenger_capacity)) + "</span>",
                                "  </div>",


                                "</div>",


                            ];

                            return result.join("");

                        }

                    }
                }).on("loaded.rs.jquery.bootgrid", function () {
                    vmCurrent._resetManagerGrid();
                    vmCurrent._gridManager(gridInit);
                });
            },
            /*Manager FORMS-AND VIEWS*/
            _viewManager: _viewManager,
//FORM CONFIG
            getViewErrorForm: getViewErrorForm,
            _submitForm: function (e) {
                console.log(e);
            },

            sendDataParent: function (params) {
                this.$emit('_actions-emit', params);
            }

        }
    })
</script>
