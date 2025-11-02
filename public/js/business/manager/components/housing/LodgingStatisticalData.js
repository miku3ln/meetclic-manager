var componentThisLodgingStatisticalData;
var resultStatics = {};
var pdfObjectInit;
Vue.component('lodging-statistical-data-component', {

    template: '#lodging-statistical-data-template',
    directives: {},
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
        console.log('created');

    },
    beforeMount: function () {
        this.configParams = this.params;
       // this.businessId = this.configParams.business_id;
        this.businessId = $businessManager.id;
        console.log('beforeMount');

    },
    mounted: function () {
        componentThisLodgingStatisticalData = this;
        this.initCurrentComponent()

        removeClassNotView();
        console.log('mounted');

    },

    validations: function () {
        var attributes = {
            date_init: {
                required,
            },
            date_end: {
                required,
            },
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
            configParams: {},
            labelsConfig: {},
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-lodgingStatisticalData',
            processName: "Reportes Estadisticos.",
            formConfig: {
                nameSelector: "#business-by-lodging-statistical-data-form",
                url: $('#action_lodging_statistical_data_results').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al obtener los resultados.',
                successMessage: 'Resultados obtenidos correctamente.',
                nameModel: "Lodging"
            },
            submitStatus: "no",
            showManager: false,
            businessId: null,
            managerType: null,
            reportsConfig: {
                income: {
                    "selector": "container-income-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Ingresos",
                        msj: "No existe registros para mostrar resultados.",

                    }
                },
                incomePeople: {
                    "selector": "container-income-people-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Personas",
                        msj: "No existe registros para mostrar resultados.",

                    }
                },
                incomePeopleArrived: {
                    "selector": "container-income-people-arrived-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Como llegaron las Personas al lugar.",
                        msj: "No existe registros para mostrar resultados.",

                    }
                },
                incomePeopleArrivedReasons: {
                    "selector": "container-income-people-arrived-reasons-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Razones que llegaron las Personas al lugar.",
                        msj: "No existe registros para mostrar resultados.",

                    }
                },
                incomePeopleCountriesArrived: {
                    "selector": "container-income-people-countries-arrived-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Nacionalidades que llegaron a hospedarse.",
                        msj: "No existe registros para mostrar resultados.",

                    }
                },
                incomeTypesPayment: {
                    "selector": "container-income-types-payment-data-lodging",
                    view: false,
                    msjEmpty: {
                        title: "Formas de pagos.",
                        msj: "No existe registros para mostrar resultados.",

                    }
                }
            },

            configDownLoad: {
                allow: false,
                pdf: {
                    allow: false
                }
            }
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        initCurrentComponent: function () {

            var dateCurrent = $dateCurrentData["not-format"].split(" ")[1];
            var dateManager = dateCurrent.split("/");
            dateManager = dateManager[2] + "-" + dateManager[1] + "-" + dateManager[0];
            this.model.attributes.date_end = dateManager;
            this.model.attributes.date_init = dateManager;
            this._viewReport(true);


        },
        isEmptyReports: function () {
            this.reportsConfig.incomePeopleArrived.view = false;
            this.reportsConfig.incomePeopleArrivedReasons.view = false;
            this.reportsConfig.incomePeopleCountriesArrived.view = false;
            this.reportsConfig.incomePeople.view = false;
            this.reportsConfig.incomeTypesPayment.view = false;
            this.reportsConfig.income.view = false;

        },
        initReports: function (params) {
            this.configDownLoad.allow = true;
            var incomeDataLodging = params["income-data-lodging"];
            var categories = params["categories"];
            var dateLimit = params["date-limit"];
            var totalIncome = incomeDataLodging.length == 0 ? 0 : incomeDataLodging.reduce(function (valorAnterior, valorActual, indice, vector) {
                return valorAnterior + valorActual;
            });
            this.reportsConfig.income.view = incomeDataLodging.length != 0;

            /*Types Payment*/
            var incomeTypesPaymentDataLodging = params["income-types-payment-data-lodging"];
            var seriesIncomeTypesPayment = incomeTypesPaymentDataLodging["series"];

            /*People*/
            var incomePeopleDataLodging = params["income-people-data-lodging"];
            var seriesIncomePeople = incomePeopleDataLodging["series"];

            /*People Arrived*/
            var incomePeopleArrivedDataLodging = params["income-people-arrived-data-lodging"];
            var seriesIncomePeopleArrived = incomePeopleArrivedDataLodging["series"];

            /*People Arrived Reasons*/
            var incomePeopleArrivedReasonsDataLodging = params["income-people-arrived-reasons-data-lodging"];
            var seriesIncomePeopleArrivedReasons = incomePeopleArrivedReasonsDataLodging["series"];

            /*People Arrived Countries*/
            var incomePeopleCountriesArrivedDataLodging = params["income-people-countries-arrived-data-lodging"];
            var seriesIncomePeopleCountriesArrived = incomePeopleCountriesArrivedDataLodging["series"];

            var selectorCurrent = this.reportsConfig.income.selector;
            if (this.reportsConfig.income.view) {
                this.configDownLoad.allow = true;

                var reportColumnIncome = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Ingresos Hospedaje <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    labels: {
                        items: [{
                            html: 'Total Ingresos',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'black'
                            }
                        }]
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: [{
                        type: 'column',
                        name: 'Ingresos',
                        color: '#ff8f1a',
                        data: incomeDataLodging
                    },
                        {
                            type: 'pie',
                            name: 'Total Valores',
                            data: [{
                                name: 'Total',
                                y: totalIncome,
                                color: "#ff8f1a"// Jane's color
                            }],
                            center: [100, 80],
                            size: 100,
                            showInLegend: false,
                            dataLabels: {
                                enabled: false
                            }
                        }
                    ],
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "$ Monto"

                        }
                    },

                });
            }
            selectorCurrent = this.reportsConfig.incomeTypesPayment.selector;
            if (this.reportsConfig.incomeTypesPayment.view) {
                this.configDownLoad.allow = true;

                var reportColumnIncomeTypesPayment = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Formas de Pago Hospedajes <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    labels: {
                        items: [{
                            html: 'Total Formas de Pagos',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'black'
                            }
                        }]
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: seriesIncomeTypesPayment,
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "Valores"

                        }
                    },

                });
            }
            selectorCurrent = this.reportsConfig.incomePeople.selector;
            if (this.reportsConfig.incomePeople.view) {
                this.configDownLoad.allow = true;

                var reportColumnIncomePeople = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Ingresos Personas Hospedaje <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    labels: {
                        items: [{
                            html: 'Totales',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'black'
                            }
                        }]
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: seriesIncomePeople,
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "Valores"

                        }
                    },

                });
            }
            selectorCurrent = this.reportsConfig.incomePeopleArrived.selector;
            if (this.reportsConfig.incomePeopleArrived.view) {
                this.configDownLoad.allow = true;


                var reportColumnIncomePeopleArrived = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Como llegaron al lugar las Personas <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    labels: {
                        items: [{
                            html: 'Totales',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'black'
                            }
                        }]
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: seriesIncomePeopleArrived,
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "Valores"

                        }
                    },

                });
            }
            selectorCurrent = this.reportsConfig.incomePeopleCountriesArrived.selector;
            if (this.reportsConfig.incomePeopleCountriesArrived.view) {
                this.configDownLoad.allow = true;


                var reportColumnIncomePeopleCountriesArrived = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Nacionalidades que llegaron a hospedarse <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: seriesIncomePeopleCountriesArrived,
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "Valores"

                        }
                    },

                });
            }
            selectorCurrent = this.reportsConfig.incomePeopleArrivedReasons.selector;
            if (this.reportsConfig.incomePeopleArrivedReasons.view) {

                this.configDownLoad.allow = true;

                var reportColumnIncomePeopleArrivedReasons = Highcharts.chart(selectorCurrent, {
                    title: {
                        text: 'Razón para llegar al lugar las Personas <br>' + dateLimit,
                        style: {
//                                    "color": "#34495E",
//                                    "fontSize": "108px",
//                                    "font-family": "Courier New",
                        },
                        useHTML: true
                    },
                    labels: {
                        items: [{
                            html: 'Totales',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'black'
                            }
                        }]
                    },
                    chart: {
                        backgroundColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                            stops: [
                                [0, "#e6e6e6"], //background
                            ]
                        },
                        borderColor: '#ff5e18',
                        borderWidth: 2,
                        className: 'highcharts--container',
                        plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                        plotBorderColor: '#CCCCCC',
                        plotBorderWidth: 1
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: seriesIncomePeopleArrivedReasons,
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        gridLineColor: '#B3B3B3',
                        labels: {
                            style: {
                                color: '#B3B3B3'
                            }
                        },
                        lineColor: '#B3B3B3',
                        minorGridLineColor: '#B3B3B3',
                        tickColor: '#B3B3B3',
                        tickWidth: 1,
                        title: {
                            style: {
                                color: '#B3B3B3'
                            },
                            text: "Valores"

                        }
                    },

                });
            }
        },
        /*---MODAL CURRENT--*/
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

                date_init: {
                    id: "date_init",
                    name: "date_init",
                    label: "Fecha Inicio",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                date_end: {
                    id: "date_end",
                    name: "date_end",
                    label: "Fecha Fin",
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
                date_init: null,
                date_end: null,
            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value, position = null, model = null) {
            var attributeCurrent;
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
                Lodging: {
                    date_init: this.$v.model.attributes.date_init.$model,
                    date_end: this.$v.model.attributes.date_end.$model,
                    business_id: this.businessId
                }

            };


            return result;
        },
        managerReportsData: function (response) {
            if (response.successResults) {
                this.generatePdf(response.dataResults);
                var dateInitList = this.model.attributes.date_init.split("-");
                var dateEndList = this.model.attributes.date_end.split("-");

                var dateInit = dateInitList[2] + "/" + dateInitList[1] + "/" + dateInitList[0];
                var dateEnd = dateEndList[2] + "/" + dateEndList[1] + "/" + dateEndList[0];
                var dateLimit = dateInit + " - " + dateEnd;
                var $categories = response.dataManager.categories;
                var incomeDataLodging = response.dataManager.incomeDataLodging;
                /*INCOME PEOPLE*/
                var incomePeopleDataLodging = response.dataManager["incomePeopleDataLodging"];
                this.reportsConfig.incomePeople.view = incomePeopleDataLodging.length != 0;
                var countPeople = 0;
                var countRooms = 0;
                var people = [];
                var rooms = [];

                var man = [];
                var countMan = 0;
                var female = [];
                var countFemale = 0;
                var lgbti = [];
                var countLgbti = 0;
                var others = [];
                var countOthers = 0;
                if (this.reportsConfig.incomePeople.view) {
                    people = incomePeopleDataLodging["people"];
                    if (people.length > 0) {
                        countPeople = people.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }


                    rooms = incomePeopleDataLodging["rooms"];
                    if (rooms.length > 0) {
                        countRooms = rooms.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }

                    var genders = incomePeopleDataLodging.genders;

                    man = genders["man"];
                    if (man.length > 0) {
                        countMan = man.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }


                    female = genders["female"];
                    if (female.length > 0) {
                        countFemale = female.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }


                    lgbti = genders["lgbti"];
                    if (lgbti.length > 0) {
                        countLgbti = lgbti.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }


                    others = genders["others"];
                    if (others.length > 0) {

                        countOthers = others.reduce(function (valorAnterior, valorActual, indice, vector) {
                            return valorAnterior + valorActual;
                        });
                    }
                }
                /*INCOME TYPE PAYMENTS*/
                var incomeTypesPaymentDataLodging = response.dataManager["incomeTypesPaymentDataLodging"];
                this.reportsConfig.incomeTypesPayment.view = incomeTypesPaymentDataLodging.view;
                var seriesTypesPaymentData = incomeTypesPaymentDataLodging["series"];

                /*INCOME ARRIVED*/
                var incomeArrivedDataLodging = response.dataManager["incomeArrivedDataLodging"];
                this.reportsConfig.incomePeopleArrived.view = incomeArrivedDataLodging.view;
                var seriesPeopleArrivedData = incomeArrivedDataLodging["series"];
                /*   Reasons People*/
                var incomeArrivedReasonsDataLodging = response.dataManager["incomeArrivedReasonsDataLodging"];
                var seriesPeopleArrivedReasonsData = incomeArrivedReasonsDataLodging["series"];
                this.reportsConfig.incomePeopleArrivedReasons.view = incomeArrivedReasonsDataLodging.view;
                /*Countries People*/
                var incomeArrivedCountriesDataLodging = response.dataManager["incomePeopleCountriesDataLodging"];
                var seriesPeopleCountriesArrivedData = incomeArrivedCountriesDataLodging["series"];
                this.reportsConfig.incomePeopleCountriesArrived.view = incomeArrivedCountriesDataLodging.view;
                var params = {
                    "date-limit": dateLimit,
                    "income-people-arrived-data-lodging": {
                        series: seriesPeopleArrivedData
                    },
                    "income-people-arrived-reasons-data-lodging": {
                        series: seriesPeopleArrivedReasonsData
                    },
                    "income-people-countries-arrived-data-lodging": {
                        series: seriesPeopleCountriesArrivedData
                    },
                    "income-people-data-lodging": {
                        series: [{
                            type: 'column',
                            name: 'Personas',
                            color: "#91c3d6",
                            data: people
                        }, {
                            type: 'column',
                            name: 'Habitaciones',
                            color: "#d6b2bf",
                            data: rooms
                        }, {
                            type: 'column',
                            name: 'Hombres',
                            color: "#ff5e18",
                            data: man
                        }, {
                            type: 'column',
                            name: 'Mujeres',
                            color: "#ffb907",
                            data: female
                        }, {
                            type: 'column',
                            name: 'LGBTI',
                            color: "#2fd6be",
                            data: lgbti
                        }, {
                            type: 'column',
                            name: 'Otros',
                            color: "#31d698",
                            data: others
                        },
                            {
                                type: 'pie',
                                name: 'Total',
                                data: [{
                                    name: 'Personas',
                                    y: countPeople,
                                    color: "#91c3d6"
                                }, {
                                    name: 'Habitaciones',
                                    y: countRooms,
                                    color: "#d6b2bf",

                                }, {
                                    name: 'Hombres',
                                    y: countMan,
                                    color: "#ff5e18",
                                }, {
                                    name: 'Mujeres',
                                    y: countFemale,
                                    color: "#ffb907",
                                }, {
                                    name: 'LGBTI',
                                    y: countLgbti,
                                    color: "#2fd6be",
                                }, {
                                    name: 'Otros',
                                    y: countOthers,
                                    color: "#31d698",
                                }
                                ],
                                center: [100, 80],
                                size: 100,
                                showInLegend: false,
                                dataLabels: {
                                    enabled: false
                                }
                            }]
                    },
                    "income-types-payment-data-lodging": {
                        series: seriesTypesPaymentData
                    },
                    "income-data-lodging": incomeDataLodging,
                    "categories": $categories
                };
                this.initReports(params);
            } else {
                this.isEmptyReports();
            }
        },
        _viewReport: function (typeInit) {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();

            ajaxRequest(this.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: vCurrent.formConfig.successMessage,
                success_callback: function (response) {
                    resultStatics = response;
                    vCurrent.managerReportsData(response);
                }
            });

        },
        resetForm: function () {
            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm: getValidateForm,
        generatePdf: function (dataResults) {
            var docDefinition = this.getStructurePdf(dataResults);
            pdfObjectInit = pdfMake.createPdf(docDefinition);
            pdfObjectInit.getDataUrl(function (data) {
                $('#iframe-pdf').attr('src', data);
            });
            this.configDownLoad.pdf = true;
            var _this = this;
            $('#iframe-pdf').on('load', function () {
                _this.configDownLoad.pdf = true;
            });

        },
        _generatePdf: function () {
            pdfObjectInit.print();
        },
        getStructurePdf: function (dataResults) {
            var content = [
                "TARJETA DE REGISTROS DE HUESPEDES",
                "Nombre Establecimiento:" + $modelDataManager["business"][0].title,
                "Dirección:" + $modelDataManager["business"][0].street_1 + " " + $modelDataManager["business"][0].street_2,
                '\n',
                "Datos Generales",
                '\n',];
            var dataLodging = dataResults;
            $.each(dataLodging, function (key, value) {
                console.log(value);
                var setPush = "Fecha Ingreso:" + value.entry_at + "  " + "Fecha Salida:" + value.delivery_date;
                content.push(setPush);
                var setPush1 = "Tipo de Habitaciones: ";
                var setPush2 = "# de Habitaciones ";
                var rooms = value["LodgingByTypeOfRoom"];
                var roomsNumbers = "";
                var roomsTypes = "";
                $.each(rooms, function (keyRoom, valueRoom) {
                    roomsNumbers += valueRoom["room_number"] + ",";
                    roomsTypes += valueRoom["name"] + ",";
                });

                setPush2 += roomsNumbers;
                setPush1 += roomsTypes;
                content.push("\n");
                content.push(setPush1);
                content.push(setPush2);
                content.push("\n");
                var bodyPeople = [];
                var headerPeopleTitle = ['Apellidos/Nombres', 'Nacionalidad', '# Identificación', 'Género', "Edad"];
                bodyPeople.push(headerPeopleTitle);
                var people = value["People"];
                $.each(people, function (keyPeople, valuePeople) {
                    var setPushPeople = [valuePeople.last_name + " " + valuePeople.name, valuePeople.people_nationality_text, valuePeople.document_number, valuePeople.gender, valuePeople.age];
                    bodyPeople.push(setPushPeople);
                });

                var peopleTable = {
                    style: 'tableExample',
                    table: {
                        widths: ['*', '*', '*', '*', '*'],
                        body: bodyPeople
                    }
                };
                content.push(peopleTable);
            });
            var docDefinition = {
                content: content,
                styles: {
                    "not-borders": {
                        border: [false, false, false, false]
                    },
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    subheader: {
                        fontSize: 16,
                        bold: true,
                        margin: [0, 10, 0, 5]
                    },
                    tableExample: {
                        margin: [0, 5, 0, 15]
                    },
                    tableHeader: {
                        bold: true,
                        fontSize: 13,
                        color: 'black'
                    }
                },
                // a string or { width: number, height: number }
                pageSize: 'A5',

                // by default we use portrait, you can change it to landscape if you wish
                pageOrientation: 'landscape',

                // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                pageMargins: [10, 10, 10, 10],
            };
            return docDefinition;
        }
    }
})
;

