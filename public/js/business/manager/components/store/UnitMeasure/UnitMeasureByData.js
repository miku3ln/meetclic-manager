var componentThisBusinessHistoryByData;
var configManagerData = {
    'model': "UnitMeasure",
    'camel': "unitMeasure",
    'name': "unit-measure",

};

function formatMeasureNumber(value, precision) {

    if (value === null || value === undefined || value === "") {
        return "-";
    }

    var number = parseFloat(value);

    if (isNaN(number)) {
        return "-";
    }

    precision = parseInt(precision);

    if (isNaN(precision) || precision < 0) {
        precision = 2;
    }

    /*
     * Unidad discreta:
     * Pieza, Unidad, Pollo, etc.
     */
    if (precision === 0) {
        return Math.round(number).toString();
    }

    /*
     * Redondear según precisión configurada
     */
    var formatted = number.toFixed(precision);

    /*
     * Limpiar ceros innecesarios:
     * 1.000  -> 1
     * 1.500  -> 1.5
     * 0.250  -> 0.25
     */
    formatted = formatted.replace(/\.?0+$/, "");

    return formatted;
}


function getMeasureConversionFactor(row) {

    /*
     * CUSTOM:
     * el factor fue definido explícitamente.
     */
    if (row.conversion_type === "CUSTOM") {
        return parseFloat(row.factor);
    }

    /*
     * STANDARD:
     * se puede calcular mediante factor_to_base.
     *
     * Ejemplo:
     * kg = 1000
     * g  = 1
     *
     * 1000 / 1 = 1000
     *
     * 1 kg = 1000 g
     */
    var fromFactor = parseFloat(row.from_unit_factor_to_base);
    var toFactor = parseFloat(row.to_unit_factor_to_base);

    if (
        !isNaN(fromFactor) &&
        !isNaN(toFactor) &&
        toFactor !== 0
    ) {
        return fromFactor / toFactor;
    }

    /*
     * Respaldo
     */
    return parseFloat(row.factor);
}

Vue.component(configManagerData.name + '-by-data-component', {
    template: '#' + configManagerData.name + '-by-data-template',
    directives: {
        initManagerS2ToUnitMeasure: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.onInitS2({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initManagerS2FromUnitMeasure: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.onInitS2({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initConversionS2FromUnitMeasure: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.onInitS2({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initConversionS2ToUnitMeasure: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.onInitS2({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    }, props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        var vmCurrent = this;
        this.$root.$on("_" + configManagerData.camel + "ByData", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });

    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisBusinessHistoryByData = this;
        this.initCurrentComponent();
    },
    validations: function () {

        var attributes = {

            "id": {},
            "business_id": {
                required
            },

            "product_id_data": {},
            "from_unit_measure_id_data": {
                required
            },

            "to_unit_measure_id_data": {
                required
            },

            "factor": {
                required
            },

            "conversion_type": {
                required,
                maxLength: Validators.maxLength(50)
            },

            "description": {
                maxLength: Validators.maxLength(255)
            },

            "state": {},
            "change": {}

        };

        var result = {
            model: {
                attributes: attributes
            }
        };

        return result;
    },
    data: function () {

        var dataManager = {
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"

                    }
                    /*,{
                        "title": "Traducción Administración",
                        "data-placement": "top",
                        "i-class": " fa fa-language",
                        "managerType": "languageEntity"
                    },*/
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Conversiones",
                process: {
                    "payment": "Pagos"
                },
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#modal-' + configManagerData.name + '-by-data',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#" + configManagerData.name + "-by-data-form",
                url: $('#action-' + configManagerData.name + '-by-data-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + configManagerData.model + '.',
                successMessage: 'El  ' + configManagerData.model + ' se guardo correctamente.',
                nameModel: configManagerData.model + "ByData"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#" + configManagerData.name + "-by-data-grid",
                url: $("#action-" + configManagerData.name + "-by-data-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            //Uploads
            uploadConfig: {
                uploadElementsSelectors: {
                    image: "#file_source"
                },
                labelsButtons: {
                    image: "Subir Imagen.",

                },
                viewUpload: {
                    image: "#preview-source"
                }
            },
            model_id: null,
            rowCurrent: null,
            configModalData: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            managerResultConversion: {
                data: null,
                success: false,
                mapperResult: {
                    input: "",
                    output: ""
                }
            },
            formConversion: {
                to: "",
                from: "",
                from_data_id: null,
                to_data_id: null,
                amount: null,
                type: "string",

                typeData: [
                    {
                        id: "string", value: "Nombres de Medida"
                    },
                    {
                        id: "data", value: "Unidades de Medida"
                    }
                ],

            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initDataModal();
            this.initGridManager(this);
            var keyModal = "ref" + configManagerData.model + "ByDataModal";
            this.$refs[keyModal].show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModal' + configManagerData.model + "ByData"
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            var keyModal = "ref" + configManagerData.model + "ByDataModal";
            this.$refs[keyModal].hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
            this.rowCurrent = rowCurrent;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                var keyModal = "ref" + configManagerData.model + "ByDataModal";
                this.$refs[keyModal].show();


            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_' + configManagerData.camel, params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
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
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
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
                    params: params,
                    isUrl: value["isUrl"],
                    url: value["url"],
                }
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: elementSelect,

            });
        },
        setValuesModel: function (params) {

            var rowCurrent = params.rowCurrent;

            var conversionFactor = getMeasureConversionFactor(rowCurrent);
            var toPrecision = parseInt(
                rowCurrent.to_unit_decimal_precision
            ) || 0;

            var factorFormatted = formatMeasureNumber(
                conversionFactor,
                toPrecision
            );

            this.model.attributes.id = rowCurrent.id;

            this.model.attributes.business_id = rowCurrent.business_id;

            this.model.attributes.product_id = rowCurrent.product_id;

            this.model.attributes.product_id_data = null;

            this.model.attributes.from_unit_measure_id = rowCurrent.from_unit_measure_id;
            this.model.attributes.to_unit_measure_id = rowCurrent.to_unit_measure_id;

            this.model.attributes.from_unit_measure_id_data = {
                id: rowCurrent.from_unit_measure_id,
                text: rowCurrent.from_unit_measure + " (" + rowCurrent.from_unit_measure_symbol + ")",
                name: rowCurrent.from_unit_measure,
                symbol: rowCurrent.from_unit_measure_symbol,
                factor_to_base: rowCurrent.from_unit_factor_to_base,
                decimal_precision: rowCurrent.from_unit_decimal_precision,
                product_measure_type_id: rowCurrent.from_product_measure_type_id
            };
            this.model.attributes.to_unit_measure_id_data = {
                id: rowCurrent.to_unit_measure_id,
                text: rowCurrent.to_unit_measure + " (" + rowCurrent.to_unit_measure_symbol + ")",
                name: rowCurrent.to_unit_measure,
                symbol: rowCurrent.to_unit_measure_symbol,
                factor_to_base: rowCurrent.to_unit_factor_to_base,
                decimal_precision: rowCurrent.to_unit_decimal_precision,
                product_measure_type_id: rowCurrent.to_product_measure_type_id
            };

            this.model.attributes.factor = factorFormatted;

            this.model.attributes.conversion_type = rowCurrent.conversion_type;

            this.model.attributes.description = rowCurrent.description;

            this.model.attributes.state = rowCurrent.state;

            this.model.attributes.change = false;
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.resetForm();

                this.setValuesModel({
                    rowCurrent: rowCurrent
                });
                this.managerMenuConfig.view = false;
                this._viewManager(3, rowId);

            } else if (params.managerType == 'languageEntity') {
                this.configModalData.data = rowCurrent;
                if (this.configModalData.viewAllow) {
                    this.$refs.refLanguageBusinessHistoryByData._setValueOfParent(
                        {type: "openModal", data: this.configModalData}
                    );
                } else {
                    this.configModalData.viewAllow = true;
                }
            }
        },
        isFormConversionValid: function () {

            var isValid = false;
            if (this.formConversion.type == "string") {
                isValid = (this.formConversion.from !== '' &&
                    this.formConversion.to !== '' && this.formConversion.from !== this.formConversion.to);
            }
            if (this.formConversion.type === "data") {

                isValid = (
                    this.formConversion.amount !== null &&
                    this.formConversion.amount > 0 &&
                    this.formConversion.from_data_id !== null &&
                    this.formConversion.to_data_id !== null &&
                    this.formConversion.from_data_id !==
                    this.formConversion.to_data_id
                );
            }

            return !isValid;
        },
        setViewConversion: function (response) {
            this.managerResultConversion.success = response.success;
            var dataCurrent = response.data;
            this.managerResultConversion.mapperResult.output = "";
            this.managerResultConversion.mapperResult.input = "";
            if (this.managerResultConversion.success) {
                this.managerResultConversion.mapperResult.output = dataCurrent.output.quantity + "" + dataCurrent.output.symbol;
                this.managerResultConversion.mapperResult.input = dataCurrent.input.quantity + "" + dataCurrent.input.symbol;

            } else {
                this.makeToast({
                    msj: response.message, title: "Error de Conversion.!", "type": "warning"
                });

            }


        },
        resetViewConversion: function (all) {
            this.managerResultConversion.mapperResult.output = "";
            this.managerResultConversion.mapperResult.input = "";
            this.managerResultConversion.success = false;
            if (all) {
                this.formConversion.to = "";
                this.formConversion.from = "";
                this.formConversion.from_data_id = null;
                this.formConversion.to_data_id = null;
                this.formConversion.type = 'string';
                this.formConversion.amount = null;
            }


        },
        setValueConversionS2: function (name, value) {

            this.formConversion[name] = value;

        },
        onConversionData: function () {
            var dataSend = this.formConversion;
            if (dataSend.type == "data") {
                dataSend.from = dataSend.amount + "" + dataSend.from_data_id.symbol;
                dataSend.to = dataSend.to_data_id.symbol;

            }
            var $this = this;
            this.resetViewConversion();
            $.ajax({
                url: $("#action-unit-measure-measureConversionByType").val(),
                type: 'POST',
                data: dataSend,
                success: function (response) {
                    console.log('Respuesta:', response);
                    $this.setViewConversion(response);
                },

                error: function (xhr) {
                    console.error('Error:', xhr.responseJSON || xhr.responseText);
                }
            });
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_by_history_id: this.model_id

            };
            var structure = vmCurrent.model.structure;
            var conversionTypeConfig = {
                "STANDARD": {
                    className: "badge-primary",
                    text: "Estándar"
                },
                "CUSTOM": {
                    className: "badge-info",
                    text: "Personalizada"
                },
                "SCIENTIFIC": {
                    className: "badge-dark",
                    text: "Científica"
                },
                "COMMERCIAL": {
                    className: "badge-success",
                    text: "Comercial"
                },
                "PHARMACY": {
                    className: "badge-danger",
                    text: "Farmacéutica"
                },
                "RECIPE": {
                    className: "badge-warning",
                    text: "Receta"
                },
                "PRODUCTION": {
                    className: "badge-secondary",
                    text: "Producción"
                }
            };

            var formatters = {

                'description': function (column, row) {

                    var typeConfig = conversionTypeConfig[row.conversion_type] || {
                        className: "badge-secondary",
                        text: row.conversion_type || "Sin definir"
                    };

                    var classType = typeConfig.className;
                    var conversionTypeText = typeConfig.text;
                    var classState = row.state == 1
                        ? "badge-success"
                        : "badge-warning";

                    var stateText = row.state == 1
                        ? "ACTIVO"
                        : "INACTIVO";

                    /*
                     * UNIDAD ORIGEN
                     */
                    var fromName = row.from_unit_measure
                        ? row.from_unit_measure
                        : "-";

                    var fromSymbol = row.from_unit_measure_symbol
                        ? row.from_unit_measure_symbol
                        : "";

                    var fromPrecision = parseInt(
                        row.from_unit_decimal_precision
                    ) || 0;


                    /*
                     * UNIDAD DESTINO
                     */
                    var toName = row.to_unit_measure
                        ? row.to_unit_measure
                        : "-";

                    var toSymbol = row.to_unit_measure_symbol
                        ? row.to_unit_measure_symbol
                        : "";

                    var toPrecision = parseInt(
                        row.to_unit_decimal_precision
                    ) || 0;


                    /*
                     * FACTOR REAL DE CONVERSIÓN
                     */
                    var conversionFactor = getMeasureConversionFactor(row);

                    /*
                     * El resultado se muestra utilizando
                     * la precisión de la unidad destino.
                     */
                    var factorFormatted = formatMeasureNumber(
                        conversionFactor,
                        toPrecision
                    );


                    /*
                     * Factor almacenado.
                     * Lo limpiamos visualmente.
                     */
                    var factorStored = formatMeasureNumber(
                        row.factor,
                        Math.max(fromPrecision, toPrecision, 6)
                    );


                    /*
                     * TIPO DE VALOR
                     */
                    var fromPrecisionText = fromPrecision === 0
                        ? "Entero"
                        : fromPrecision + " decimales";

                    var toPrecisionText = toPrecision === 0
                        ? "Entero"
                        : toPrecision + " decimales";


                    var description = row.description
                        ? row.description
                        : "Sin descripción";


                    var productText = row.product_id
                        ? "Producto específico #" + row.product_id
                        : "Conversión general";


                    var businessText = row.business_id == 0
                        ? "Global"
                        : "Empresa #" + row.business_id;


                    var result = [

                        "<article class='measure-conversion'>",


                        // =====================================================
                        // 1. HEADER
                        // =====================================================

                        "<header class='measure-conversion__header'>",

                        "<div class='measure-conversion__header-main'>",

                        "<span class='measure-conversion__back'>",
                        "<i class='fas fa-chevron-left'></i>",
                        "</span>",

                        "<div class='measure-conversion__heading'>",

                        "<strong class='measure-conversion__title'>",
                        "Detalle de conversión",
                        "</strong>",

                        "<div class='measure-conversion__badges'>",

                        "<span class='badge " +
                        classType +
                        " measure-conversion__badge'>" +
                        conversionTypeText +
                        "</span>",

                        "<span class='badge " +
                        classState +
                        " measure-conversion__badge'>" +
                        stateText +
                        "</span>",

                        "</div>",

                        "</div>",

                        "</div>",

                        "<span class='measure-conversion__id'>#" +
                        row.id +
                        "</span>",

                        "</header>",


                        // =====================================================
                        // 2. RESUMEN DE CONVERSIÓN
                        // =====================================================

                        "<section class='measure-conversion__summary'>",

                        "<div class='measure-conversion__flow'>",


                        // ORIGEN
                        "<div class='measure-conversion__unit'>",

                        "<strong class='measure-conversion__unit-name'>" +
                        fromName +
                        "</strong>",

                        "<span class='measure-conversion__unit-symbol'>" +
                        fromSymbol +
                        "</span>",

                        "<span class='measure-conversion__unit-precision'>" +
                        fromPrecisionText +
                        "</span>",

                        "</div>",


                        // DIRECCIÓN
                        "<div class='measure-conversion__direction'>",

                        "<i class='fas fa-exchange-alt measure-conversion__direction-icon'></i>",

                        "</div>",


                        // DESTINO
                        "<div class='measure-conversion__unit'>",

                        "<strong class='measure-conversion__unit-name'>" +
                        toName +
                        "</strong>",

                        "<span class='measure-conversion__unit-symbol'>" +
                        toSymbol +
                        "</span>",

                        "<span class='measure-conversion__unit-precision'>" +
                        toPrecisionText +
                        "</span>",

                        "</div>",

                        "</div>",


                        // EQUIVALENCIA
                        "<div class='measure-conversion__formula'>",

                        "<i class='fas fa-check-circle measure-conversion__formula-icon'></i>",

                        "<span class='measure-conversion__formula-value'>",

                        "1 " +
                        fromSymbol +

                        " = " +

                        "<strong>" +
                        factorFormatted +
                        " " +
                        toSymbol +
                        "</strong>",

                        "</span>",

                        "</div>",

                        "</section>",


                        // =====================================================
                        // 3. DETALLES
                        // =====================================================

                        "<section class='measure-conversion__details'>",


                        // FACTOR
                        "<div class='measure-conversion__detail'>",

                        "<div class='measure-conversion__detail-icon'>",
                        "<i class='fas fa-calculator'></i>",
                        "</div>",

                        "<span class='measure-conversion__detail-label'>",
                        "Factor",
                        "</span>",

                        "<strong class='measure-conversion__detail-value'>" +
                        factorStored +
                        "</strong>",

                        "</div>",


                        // TIPO
                        "<div class='measure-conversion__detail'>",

                        "<div class='measure-conversion__detail-icon'>",
                        "<i class='fas fa-tag'></i>",
                        "</div>",

                        "<span class='measure-conversion__detail-label'>",
                        "Tipo",
                        "</span>",

                        "<strong class='measure-conversion__detail-value'>" +
                        row.conversion_type +
                        "</strong>",

                        "</div>",


                        // APLICACIÓN
                        "<div class='measure-conversion__detail'>",

                        "<div class='measure-conversion__detail-icon'>",
                        "<i class='fas fa-layer-group'></i>",
                        "</div>",

                        "<span class='measure-conversion__detail-label'>",
                        "Aplicación",
                        "</span>",

                        "<strong class='measure-conversion__detail-value'>" +
                        productText +
                        "</strong>",

                        "</div>",


                        // CONFIGURACIÓN
                        "<div class='measure-conversion__detail'>",

                        "<div class='measure-conversion__detail-icon'>",
                        "<i class='fas fa-globe'></i>",
                        "</div>",

                        "<span class='measure-conversion__detail-label'>",
                        "Configuración",
                        "</span>",

                        "<strong class='measure-conversion__detail-value'>" +
                        businessText +
                        "</strong>",

                        "</div>",


                        // DESCRIPCIÓN
                        "<div class='measure-conversion__detail measure-conversion__detail--description'>",

                        "<div class='measure-conversion__detail-icon'>",
                        "<i class='far fa-comment-alt'></i>",
                        "</div>",

                        "<div class='measure-conversion__description-content'>",

                        "<span class='measure-conversion__detail-label'>",
                        structure.description.label,
                        "</span>",

                        "<span class='measure-conversion__description-value'>" +
                        description +
                        "</span>",

                        "</div>",

                        "</div>",


                        "</section>",


                        "</article>"
                    ];

                    return result.join("");
                }

            };
            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: false,
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.showManager = true;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM

            }
        },
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

                business_id: {
                    id: "business_id",
                    name: "business_id",
                    label: "Empresa",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
                },

                product_id_data: {
                    id: "product_id_data",
                    name: "product_id_data",
                    label: "Producto",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: []
                },

                from_unit_measure_id_data: {
                    id: "from_unit_measure_id_data",
                    name: "from_unit_measure_id_data",
                    label: "Unidad Origen",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: []
                },

                to_unit_measure_id_data: {
                    id: "to_unit_measure_id_data",
                    name: "to_unit_measure_id_data",
                    label: "Unidad Destino",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: []
                },

                factor: {
                    id: "factor",
                    name: "factor",
                    label: "Factor de Conversión",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
                },

                conversion_type: {
                    id: "conversion_type",
                    name: "conversion_type",
                    label: "Tipo de Conversión",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        {"value": "STANDARD", "text": "Estándar"},
                        {"value": "CUSTOM", "text": "Personalizada"},
                        {"value": "SCIENTIFIC", "text": "Científica"},
                        {"value": "COMMERCIAL", "text": "Comercial"},
                        {"value": "PHARMACY", "text": "Farmacéutica"},
                        {"value": "RECIPE", "text": "Receta"},
                        {"value": "PRODUCTION", "text": "Producción"}
                    ]
                },

                description: {
                    id: "description",
                    name: "description",
                    label: "Descripción",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Caracteres excedidos a 255."
                    }
                },

                state: {
                    id: "state",
                    name: "state",
                    label: "Estado",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        {
                            "value": 1,
                            "text": "ACTIVO"
                        },
                        {
                            "value": 0,
                            "text": "INACTIVO"
                        }
                    ]
                }

            };

            return result;
        },
        getAttributesForm: function () {

            var result = {

                "id": null,

                "business_id": 0,

                "product_id": null,
                "product_id_data": null,

                "from_unit_measure_id": null,
                "from_unit_measure_id_data": null,

                "to_unit_measure_id": null,
                "to_unit_measure_id_data": null,

                "factor": 1,

                "conversion_type": "STANDARD",

                "description": null,

                "state": 1,

                "change": false

            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value) {

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

            var result = {};
            var key = "MeasureConversion";
            result[key] = {

                "id": this.$v.model.attributes.id.$model
                    ? this.$v.model.attributes.id.$model
                    : -1,

                "business_id": this.$v.model.attributes.business_id.$model,

                "product_id": this.$v.model.attributes.product_id_data.$model
                    ? this.$v.model.attributes.product_id_data.$model.id
                    : null,

                "from_unit_measure_id": this.$v.model.attributes.from_unit_measure_id_data.$model
                    ? this.$v.model.attributes.from_unit_measure_id_data.$model.id
                    : null,

                "to_unit_measure_id": this.$v.model.attributes.to_unit_measure_id_data.$model
                    ? this.$v.model.attributes.to_unit_measure_id_data.$model.id
                    : null,

                "factor": this.$v.model.attributes.factor.$model,

                "conversion_type": this.$v.model.attributes.conversion_type.$model,

                "description": this.$v.model.attributes.description.$model,

                "state": this.$v.model.attributes.state.$model,

                "change": this.$v.model.attributes.change.$model

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
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
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

        getValidateForm: getValidateForm,
        managerS2ToUnitMeasure: function (params) {

            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var keyCurrent = "to_unit_measure_id_data";

            if (valueCurrentRowId && this.model.attributes[keyCurrent]) {
                dataCurrent = [
                    this.model.attributes[keyCurrent]
                ];
            }

            var _this = this;

            var $element = $(el);
            var $modal = $element.closest('.modal');

            /*
             * Si ya estaba inicializado, destruirlo
             */
            if ($element.hasClass("select2-hidden-accessible")) {
                $element.select2('destroy');
            }

            var configSelect2 = {

                placeholder: "Seleccione",

                data: dataCurrent,

                allowClear: true,

                multiple: false,

                width: '100%',

                ajax: {

                    url: $("#action-unit-measure-getListSelect2").val(),

                    type: 'get',

                    dataType: 'json',

                    delay: 250,

                    data: function (params) {

                        return {
                            filters: {
                                search_value: params
                            }
                        };

                    },

                    processResults: function (data) {

                        return {
                            results: data
                        };

                    }

                }

            };

            configSelect2.dropdownParent = "#modal-unit-measure-data";


            var elementInit = $element.select2(
                configSelect2
            );


            /*
             * Seleccionar
             */
            elementInit.on('select2:select', function (e) {

                var data = e.params.data;

                _this.model.attributes[keyCurrent] = data;

                _this._setValueForm(
                    keyCurrent,
                    data
                );

            });


            /*
             * Limpiar
             */
            elementInit.on('select2:clear', function () {

                _this.model.attributes[keyCurrent] = null;

                _this._setValueForm(
                    keyCurrent,
                    null
                );

            });

        },
        managerS2FromUnitMeasure: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var keyCurrent = "from_unit_measure_id_data";

            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes[keyCurrent]];
            }

            var _this = this;

            /*
             * Buscar si el Select2 está dentro de un modal.
             */
            var $element = $(el);


            /*
             * Configuración Select2
             */
            var configSelect2 = {

                allow: true,

                placeholder: "Seleccione",

                data: dataCurrent,

                allowClear: true,

                multiple: false,

                width: '100%',

                ajax: {

                    url: $("#action-unit-measure-getListSelect2").val(),

                    type: 'get',

                    dataType: 'json',

                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term
                            }
                        };

                        return paramsFilters;
                    },

                    processResults: function (data, page) {

                        return {
                            results: data
                        };

                    }

                }

            };

            configSelect2.dropdownParent = "#modal-unit-measure-data";

            var elementInit = $element.select2(configSelect2);


            /*
             * SELECCIONAR
             */
            elementInit.on('select2:select', function (e) {

                var data = e.params.data;

                _this.model.attributes[keyCurrent] = data;

                _this._setValueForm(
                    keyCurrent,
                    data
                );

            });


            /*
             * QUITAR SELECCIÓN
             */
            elementInit.on("select2:unselecting", function (e) {

                _this.model.attributes[keyCurrent] = null;

                _this._setValueForm(
                    keyCurrent,
                    null
                );

            });

        },
        conversionS2ToUnitMeasure: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var keyCurrent = "to_data_id";

            var _this = this;

            var $element = $(el);

            var configSelect2 = {
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                allowClear: true,
                multiple: false,
                width: '100%',
                ajax: {

                    url: $("#action-unit-measure-getListSelect2").val(),

                    type: 'get',

                    dataType: 'json',

                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term
                            }
                        };

                        return paramsFilters;
                    },

                    processResults: function (data, page) {

                        return {
                            results: data
                        };

                    }

                }

            };

            configSelect2.dropdownParent = "#modal-unit-measure-data";
            var elementInit = $element.select2(configSelect2);

            /*
             * SELECCIONAR
             */
            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.setValueConversionS2(
                    keyCurrent,
                    data
                );

            });


            /*
             * QUITAR SELECCIÓN
             */
            elementInit.on("select2:unselecting", function (e) {
                _this.setValueConversionS2(
                    keyCurrent,
                    null
                );

            });

        },
        conversionS2FromUnitMeasure: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];


            var keyCurrent = "from_data_id";

            var _this = this;

            var $element = $(el);

            var configSelect2 = {
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                allowClear: true,
                multiple: false,
                width: '100%',
                ajax: {

                    url: $("#action-unit-measure-getListSelect2").val(),

                    type: 'get',

                    dataType: 'json',

                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term
                            }
                        };

                        return paramsFilters;
                    },

                    processResults: function (data, page) {

                        return {
                            results: data
                        };

                    }

                }

            };

            configSelect2.dropdownParent = "#modal-unit-measure-data";
            var elementInit = $element.select2(configSelect2);

            /*
             * SELECCIONAR
             */
            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.setValueConversionS2(
                    keyCurrent,
                    data
                );

            });


            /*
             * QUITAR SELECCIÓN
             */
            elementInit.on("select2:unselecting", function (e) {
                _this.setValueConversionS2(
                    keyCurrent,
                    null
                );

            });

        }
    }
})
;




