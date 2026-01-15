var componentThisEventsTrailsProject;
function fullName(row) {
    const n = (row.people_name || '').trim();
    const l = (row.people_last_name || '').trim();
    const d = (row.identification_document || '').trim();

    return (""+d+": "+n + ' ' + l).trim();
}

function passengerTypeLabel(type) {
    var map = {
        ADULT: 'Adulto',
        SENIOR: 'Adulto mayor',
        CHILD: 'Niño',
        BABY: 'Bebé'
    };
    return map[type] || type || 'No definido';
}
function buildPassengerTable(rows) {
    if (!Array.isArray(rows) || rows.length === 0) {
        return '<p class="text-muted">Sin registros</p>';
    }

    var thead = `
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Edad</th>
        <th>Tipo</th>
      </tr>
    </thead>
  `;

    var tbody = rows.map(r => `
    <tr>
      <td>${fullName(r)}</td>
      <td>${r.passenger_age ?? ''}</td>
      <td>${passengerTypeLabel(r.passenger_type)}</td>
    </tr>
  `).join('');

    return `
    <table class="table table-bordered table-striped table-hover">
      ${thead}
      <tbody>${tbody}</tbody>
    </table>
  `;
}

Vue.component('points-sales-component', {
    components: {},
    template: '#points-sales-template',
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
        this.$root.$on("_pointsSales", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisEventsTrailsProject = this;

        this.managerCurrentBusiness = this.params.data;
        this.initCurrentComponent();
    },
    computed: {},

    data: function () {

        var dataManager = {
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [

                    {
                        "title": "Participar",
                        "data-placement": "top",
                        "i-class": "fa   fa-calendar",
                        "managerType": "managementTakePart",
                        "isUrl": false,

                    },
                    {
                        "title": "Administracion de Pagos",
                        "data-placement": "top",
                        "i-class": "fa fa-usd",
                        "managerType": "managementGetPayments",
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
                selectorCurrent: "#points-sales-grid",
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
            managerCurrentBusiness: null,

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
            if (params.managerType == "managementTakePart") {
                console.log(rowCurrent);
                this.configModalManagementFormEvent.data = rowCurrent;
                this.configModalManagementFormEvent.viewAllow = true;
            } else if (params.managerType == "managementGetPayments") {


                var dataSend = {
                    filters: {
                        events_trails_registration_points_id: rowCurrent.events_trails_registration_points_id
                    }
                };
                var tabCurrentSelector = '#modal-management-form-event';
                var loadingMessage = 'Obteniendo Informacion....';
                var errorMessage = 'Error al obtener!';
                ajaxRequestManager($('#action-management-getDataPaymentsManagement').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: loadingMessage,
                    error_message: errorMessage,
                    success_message: 'Se registro correctamente.',
                    success_callback: function (response) {

                        if (response.success) {

                            $scope.configModalManagementFormEventDetails.data = {
                                event: rowCurrent,
                                data: response.data
                            };
                            $scope.configModalManagementFormEventDetails.viewAllow = true;
                        }
                    }
                });
            }

        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var business_id = -1;
            var maritimeInformation = this.managerCurrentBusiness.maritimeInformation;
            var paramsFilters = {
                business_id: maritimeInformation.business_id

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
                        var data = row;

                        var $languageCurrent = null;
                        var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
                        var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);
                     var passager=   buildPassengerTable(data.details);
                        var result = [
                            "<div class='content-management-rows'>",

                            "  <div class='content-description__information'>",
                            "   <span class='content-description__title'>Empresa :</span><span class='content-description__value'>" + (data.business_title) + "</span>",
                            "  </div>",
                            "  <div class='content-description__information'>",
                            "   <span class='content-description__title'>Zarpe :</span><span class='content-description__value'>" + (formatDateTimeDMY(data.created_at)) + "</span>",
                            "  </div>",
                            "  <div class='content-description__information'>",
                            "   <span class='content-description__title'>Responsable  :</span><span class='content-description__value'>" + (data['responsible_name']) + "</span>",
                            "  </div>",
                            passager,
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

    }
})
;




