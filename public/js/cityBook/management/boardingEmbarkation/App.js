function destroyS2($el) {
    if ($el.data('select2')) $el.select2('destroy');
    $el.empty();
}

var appInit = new Vue(
    {

        mounted: function () {
            this.initCurrentComponent();
            appThis = this;

            // 1) hoy (YYYY-MM-DD)
            var today = this.formatToday();

            // 2) setear límites
            this.reportConfig.limits.maxDate = today;

            // 3) primera vez: ambos = hoy
            this.reportConfig.filters.startDate = today;
            this.reportConfig.filters.endDate = today;

            // 4) validar
            this.validateReportFilters();

            if (this.managerCurrentBusiness.allowView) {


                this.initReports();

            }

        },
        directives: {
            initS2Manager: {
                inserted: function (el, binding, vnode) {
                    var paramsInput = binding.value || {};
                    var ctx = vnode.context;

                    // espera a que el DOM esté estable
                    ctx.$nextTick(function () {
                        // evita doble init si el nodo se reusa
                        var $el = $(el);
                        if ($el.hasClass("select2-hidden-accessible")) {
                            $el.select2("destroy");
                        }

                        if (typeof paramsInput._initS2Manager === "function") {
                            paramsInput._initS2Manager({
                                objSelector: el,
                                rowId: paramsInput.rowId
                            });
                        } else {
                            console.warn("initS2Manager: _initS2Manager no es función", paramsInput);
                        }
                    });
                },

                unbind: function (el) {
                    var $el = $(el);
                    if ($el.hasClass("select2-hidden-accessible")) {
                        $el.select2("destroy");
                    }
                }
            }
        },
        watch: {
            'reportConfig.filters.startDate': function () {
                // si movieron "Desde" y queda mayor que "Hasta", ajusta "Hasta" a "Desde"
                var s = this.reportConfig.filters.startDate;
                var e = this.reportConfig.filters.endDate;

                if (s && e && this.parseDateLocal(s) > this.parseDateLocal(e)) {
                    this.reportConfig.filters.endDate = s;
                }

                this.validateReportFilters();
            },

            'reportConfig.filters.endDate': function () {
                // si endDate supera hoy, lo recortamos a hoy (bloqueo duro)
                var max = this.reportConfig.limits.maxDate;
                var e = this.reportConfig.filters.endDate;

                if (e && max && this.parseDateLocal(e) > this.parseDateLocal(max)) {
                    this.reportConfig.filters.endDate = max;
                }

                this.validateReportFilters();
            },
        },
        el: '#app-management',
        created: function () {

        },
        data: {
            //MENU
            menuCurrent: [],
            configDataPointsSales: {
                title: "Registro de Habitaciones",
                data: null,
                titleEvent: "",
                business_id: null
            },
            managerProcessCurrent: {
                type: 0
            },
            model: {
                attributes: null,
                structure: null,
            },
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

                },

            },
            configDataRegisterForm: {
                title: "Registro de Habitaciones",
                data: null,
                titleEvent: "",
                business_id: null
            },

            reportConfig: {
                tz: 'America/Guayaquil',

                // limites
                limits: {
                    maxDate: '', // YYYY-MM-DD (hoy)
                },

                // filtros del formulario
                filters: {
                    startDate: '', // YYYY-MM-DD
                    endDate: '',   // YYYY-MM-DD
                },

                // estado UI
                state: {
                    canApply: false,
                    message: '',
                },

                // mensajes (si luego cambias textos, solo tocas aquí)
                messages: {
                    required: 'Selecciona "Desde" y "Hasta".',
                    invalid: 'Fecha inválida.',
                    startAfterEnd: '"Desde" no puede ser mayor que "Hasta".',
                    endAfterToday: '"Hasta" no puede ser mayor que hoy.',
                },

            },
            managerCurrentBusiness: {
                allowView: false,
                maritime_vessels_id: 1,
                arrival_time: "14/01/2026 11:04 AM",

                responsible: {
                    fullName: "Cesar Iban Alba",
                    document: "1002954889",

                },
                time: {
                    date: "",
                    hour: ""
                },
                maritimeInformation: {
                    maritime_vessels_id:null,
                    name: "Embarcaciòn Taita Imbabura",
                    business_id: 5,
                    source: "https://meetclic.com/public/uploads/business/information/logomuellecatalina.png"
                },
                dataSelect: null
            }
        },
        methods: {
            ...$methodsFormValid,
            ...$methodsProcessCurrent,
            /*FORM*/

            initCurrentComponent: function () {

            }, initManagement: function () {
                console.log("init app");
            },
            viewSelectInformation: function () {
                this.managerCurrentBusiness.allowView = true;
            },
            /*---EVENTS CHILDREN to Parent COMPONENTS----*/
            _updateParentByChildren: function (params) {
                console.log(params);


            },
            setDataManagerMaritime: function (params) {
                this.managerProcessCurrent.type = 0;
                this.managerCurrentBusiness.allowView = false;
                this.managerCurrentBusiness.maritimeInformation.name = params.text;
                this.managerCurrentBusiness.maritimeInformation.business_id = params.id;
                this.managerCurrentBusiness.maritimeInformation.source = $publicAsset + params.source;
                this.managerCurrentBusiness.maritimeInformation.maritime_vessels_id = params.id;//vessel
                this.managerCurrentBusiness.responsible.fullName = params.responsible_name;//vessel
                this.managerCurrentBusiness.responsible.document = params.identification_document;//vessel



                this.configDataRegisterForm.data = this.managerCurrentBusiness;
                this.configDataPointsSales.data = this.managerCurrentBusiness;


                setTimeout(() => {
                    console.log('Esto se ejecuta una sola vez después de 2 segundos');
                    this.managerCurrentBusiness.allowView = true;
                }, 0);

            },
            _managerS2Products: function (params) {
                var el = params.objSelector;
                var dataSelect = this.managerCurrentBusiness.dataSelect;
                var valueCurrentRowId = null;
                if (dataSelect) {
                    valueCurrentRowId = this.managerCurrentBusiness.dataSelect.id;
                }
                var dataCurrent = [];
                var $el = $(el);
                destroyS2($el);
                if (valueCurrentRowId) {
                    dataCurrent = dataSelect;
                    var textCurrent = dataCurrent.text;
                    var idCurrent = dataCurrent.id;
                    var option = new Option(textCurrent, idCurrent, true, true);
                    $(el).append(option).trigger('change');
                }
                var _this = this;
                var elementInit = $(el).select2({
                    allow: true,
                    placeholder: "Seleccione la Embarcaciòn",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-business-by-maritime").val(),
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
                    allowClear: false,
                    multiple: false,
                    width: '100%'
                });

                elementInit.on('select2:select', function (e) {
                    var data = e.params.data;
                    console.log("select", data);
                    _this.setDataManagerMaritime(data);

                }).on("select2:unselecting", function (e) {
                    console.log("null");
                }).on("select2:open", function (e) {
                    console.log("abierto");

                });
            },
            getSourceMaritime: function () {
                return this.managerCurrentBusiness.maritimeInformation.source;
            },
            setInitReports: function (params) {
                if (params.success) {
                    var data = params.data;

                    var dataInterval = data.dataIntervalTypePeople;
                    var dayGroups = {};
                    var dates = [...new Set(dataInterval.map(i => i.label))];

                    dataInterval.forEach(i => {
                        if (!dayGroups[i.type]) dayGroups[i.type] = {};
                        if (!dayGroups[i.type][i.label]) dayGroups[i.type][i.label] = 0;

                        dayGroups[i.type][i.label] += i.total;
                    });
                    console.log(dayGroups);
                    var dailySeries = Object.keys(dayGroups).map(type => ({
                        name: type,
                        data: dates.map(date => dayGroups[type][date] || 0)
                    }));

                    Highcharts.chart('chart-sources', {
                        title: {text: 'Clasificación por edad en el Periodo'},
                        chart: {type: 'area'},
                        xAxis: {categories: dates},
                        yAxis: {title: {text: '#Personas'}},
                        series: dailySeries
                    });
                    // 3. Daily interactions
                    var dataInterval = data.dataIntervalCompany;
                    dayGroups = {};
                    dates = [...new Set(dataInterval.map(i => i.label))];
                    dataInterval.forEach(i => {
                        if (!dayGroups[i.companyName]) dayGroups[i.companyName] = {};
                        dayGroups[i.companyName][i.label] = i.total;
                    });
                    dailySeries = Object.keys(dayGroups).map(type => ({
                        name: type,
                        data: dates.map(date => dayGroups[type][date] || 0)
                    }));
                    Highcharts.chart('chart-daily', {
                        title: {
                            text: 'Personas que abordaron en la Empresa.'
                        },
                        chart: {type: 'area'},
                        xAxis: {categories: dates},
                        yAxis: {title: {text: '#Personas'}},
                        series: dailySeries
                    });

                    var typesCurrent = data.resultTypes;

                    var usersSeries = typesCurrent.map(i => ({
                        name: `${i.type} - ${i.companyName}`,
                        y: i.total
                    }));
                    Highcharts.chart('chart-users', {
                        title: {
                            text: 'Clasificación por edad'
                        },
                        chart: {type: 'pie'},
                        series: [{name: 'Total', data: usersSeries}]
                    });

                    // 5. Click types
                    var clickGroups = {};

                    var clickTypes = [...new Set(typesCurrent.map(i => i.type))];
                    typesCurrent.forEach(i => {
                        if (!clickGroups[i.companyName]) clickGroups[i.companyName] = {};
                        clickGroups[i.companyName][i.type] = i.total;
                    });
                    var clickSeries = Object.keys(clickGroups).map(name => ({
                        name,
                        data: clickTypes.map(t => clickGroups[name][t] || 0)
                    }));
                    Highcharts.chart('chart-clicks', {
                        chart: {type: 'column'},
                        xAxis: {categories: clickTypes},
                        yAxis: {title: {text: 'Cantidad'}},
                        series: clickSeries
                    });
                } else {

                }

            },
            initReports: function () {
                var $this = this;
                var dataSend = {
                    date_from: this.reportConfig.filters.startDate,
                    date_to: this.reportConfig.filters.endDate,
                    business_id: this.managerCurrentBusiness.maritimeInformation.business_id,

                };

                ajaxRequestManager($("#action-management-reports").val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: ".tabs",//opcional: es para bloquear el elemento
                    loading_message: "Cargando Datos.!",
                    error_message: "No Existe Datos!",
                    success_message: "Datos Cargados.!",
                    success_callback: function (response) {
                        if (response.success) {
                            $(".report-tracking-web").removeClass("not-view");

                            $this.setInitReports(response);
                        } else {
                            $(".report-tracking-web").addClass("not-view");
                        }
                    }
                });
            },
            _managementProcess: function (type) {
                this.managerProcessCurrent.type = type;
                var vCurrent = this;

                if (type == 0) {
                    if (this.managerCurrentBusiness.allowView) {

                        this.initReports();
                    }
                }


            },
            validateReportFilters: function () {
                var cfg = this.reportConfig;
                var s = cfg.filters.startDate;
                var e = cfg.filters.endDate;
                var max = cfg.limits.maxDate;

                cfg.state.canApply = false;
                cfg.state.message = '';

                if (!s || !e) {
                    cfg.state.message = cfg.messages.required;
                    return;
                }

                var sd = this.parseDateLocal(s);
                var ed = this.parseDateLocal(e);
                var md = this.parseDateLocal(max);

                if (!sd || !ed) {
                    cfg.state.message = cfg.messages.invalid;
                    return;
                }

                if (sd > ed) {
                    cfg.state.message = cfg.messages.startAfterEnd;
                    return;
                }

                // restricción principal: no pasar de HOY
                if (ed > md) {
                    cfg.state.message = cfg.messages.endAfterToday;
                    return;
                }

                cfg.state.canApply = true;
                cfg.state.message = '';
            },

            // --- helpers fechas ---
            formatToday: function () {
                var d = new Date();
                return this.formatDateYYYYMMDD(d);
            },

            formatDateYYYYMMDD: function (d) {
                var y = d.getFullYear();
                var m = String(d.getMonth() + 1).padStart(2, '0');
                var day = String(d.getDate()).padStart(2, '0');
                return `${y}-${m}-${day}`;
            },

            // parse local: YYYY-MM-DD -> Date (sin UTC)
            parseDateLocal: function (yyyy_mm_dd) {
                if (!yyyy_mm_dd || !/^\d{4}-\d{2}-\d{2}$/.test(yyyy_mm_dd)) return null;
                const [y, m, d] = yyyy_mm_dd.split('-').map(Number);
                return new Date(y, m - 1, d, 0, 0, 0);
            },
        }
    })
;
appInit.initManagement();
