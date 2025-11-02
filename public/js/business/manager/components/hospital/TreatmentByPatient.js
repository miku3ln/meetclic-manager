var componentThisTreatmentByPatient;
Vue.component('treatment-by-patient-component', {
    components: {}
    , template: '#treatment-by-patient-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._manager({
                    objSelector: el, model: paramsInput.model
                });
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    computed: {},
    created: function () {
        var $scope = this;
        this.$root.$on("_treatmentByPatient", function (emitValue) {
            $scope._managerTypes(emitValue);
        });
        console.log('created');
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.manager_id = this.configParams.data.historyClinic.id;
        this.business_id = this.configParams.data.business.id;
        console.log('beforeMount');
    },
    mounted: function () {
        console.log('mounted');
        componentThisTreatmentByPatient = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "customer_id": {},
            "invoice_code": {required, maxLength: Validators.maxLength(45)},
            "invoice_value": {required},
            "discount_value": {},
            "status": {required},
            "user_id": {},
            "observations": {required},
            "value_taxes": {required},
            "subtotal": {required},
            "authorization_number": {required, maxLength: Validators.maxLength(150)},
            "invoice_date": {required},
            "establishment": {required, maxLength: Validators.maxLength(3)},
            "emission_point": {required, maxLength: Validators.maxLength(3)},
            "mixed_payment": {required},
            "has_retention": {required},
            "debt": {required},
            "freight": {required},
            "type_of_discount": {required},
            "discount_type_invoice": {required},
            "history_clinic_id_data": {},
            'product_id_data': {},
            items: {
                required,
                minLength: minLength(1),
                $each: {
                    product_id: {
                        required
                    },
                    quantity: {required},
                    quantity_unit: {},
                    discount_percentage: {},
                    discount_percentage_unit: {},
                    discount_value: {},
                    discount_value_unit: {},
                    unit_price: {},
                    unit_price_unit: {},
                    management_type: {},
                    tax_percentage: {},
                    subtotal: {},
                    total: {},
                    description: {},
                    product_type: {},
                }
            }
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
            manager_id: null,
            business_id: null,
            manager_key_name: 'history_clinic_id',
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Detalle de Tratamiento",
                        "data-placement": "top",
                        "i-class": " fas fa-list",
                        "managerType": "details"
                    },
                    {
                        "title": "Gestion de Pagos",
                        "data-placement": "top",
                        "i-class": " fas fa-cash-register",
                        "managerType": "managementPayment"
                    },

                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Informacion",
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
            tabCurrentSelector: '.tab-content',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#treatment-by-patient-form",
                url: $('#action-treatment-by-patient-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el TreatmentByPatient.',
                successMessage: 'El TreatmentByPatient se guardo correctamente.',
                nameModel: "TreatmentByPatient"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#treatment-by-patient-grid",
                url: $("#action-treatment-by-patient-getAdmin").val()
            },
            showManager: false,
            managerType: null,
//MANAGEMENT GRID INVOICE
            mixedPaymentData: [
                {value: 1, text: 'Contado'},
                {value: 0, text: 'Credito'},

            ],
            invoiceDataManagement: {
                header: {
                    invoice_value: 0,// TOTAL
                    discount_value: 0,// DISCOUNT,
                    'value_taxes': 0,// SUBTOTAL 12 %*
                    'subtotal': 0,//* SUBTOTAL 0%*
                    'debt': 0,
                    'freight': 0,
                },
                body: {
                    details: []
                }
            },
            invoiceDataManagementResults: {
                header: {
                    invoice_value: 0,// TOTAL
                    discount_value: 0,// DISCOUNT,
                    'value_taxes': 0,// SUBTOTAL 12 %*
                    'subtotal': 0,//* SUBTOTAL 0%*
                    'debt': 0,
                    'freight': 0,
                },
                body: {
                    details: []
                }
            },
            //PROCESS
            configModalTreatmentByIndebtednessPayingInit: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },


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

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = this.gridConfig.selectorCurrent;
            elementSelect.find("tbody tr").on("click", function (e) {

                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var targetTypeA = $(e.target).is("a");
                if (!targetTypeA) {
                    var selectorRow;
                    if (dataRowId) {
                        var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                        var rowData = searchElementJson(
                            instance_data_rows,
                            "id",
                            dataRowId
                        ); //asi s obtiene los valores del registro en funcion d su id
                        elementSelect.find("tr.selected").removeClass("selected");
                        var newEventRow = false;
                        if ($scope.managerMenuConfig.rowId) {
                            //ready selected
                            var removeRowId = $scope.managerMenuConfig.rowId;
                            if (dataRowId == removeRowId) {
                                selectorRow =
                                    selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                                $(selectorRow).removeClass("selected");
                                $scope._resetManagerGrid();
                            } else {
                                newEventRow = true;
                            }
                        } else {
                            newEventRow = true;
                        }
                        if (newEventRow) {
                            selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                            rowData = rowData[0];
                            $(selectorRow).addClass("selected");

                            var menuCurrent = $scope.getMenuConfig({
                                rowData: rowData,
                                rowId: dataRowId
                            });

                            var menuCurrentManagement = [];
                            $.each(menuCurrent, function (key, value) {
                                var setPush = value;
                                var allowPush = false;
                                if (value.managerType == 'managementPayment' && rowData.debt == 1) {
                                    allowPush = true;
                                } else if (value.managerType == 'details') {
                                    allowPush = true;

                                }
                                if (allowPush) {
                                    menuCurrentManagement.push(setPush);
                                }
                            });
                            $scope.managerMenuConfig = {
                                view: true,
                                menuCurrent: menuCurrentManagement,
                                rowId: dataRowId
                            };
                        }

                    }
                }


            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            var $scope = this;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.customer_id = rowCurrent.customer_id;
                this.model.attributes.invoice_code = rowCurrent.invoice_code;
                this.model.attributes.invoice_value = parseFloat(rowCurrent.invoice_value);
                this.model.attributes.discount_value = parseFloat(rowCurrent.discount_value);
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.user_id = rowCurrent.user_id;
                this.model.attributes.observations = rowCurrent.observations;
                this.model.attributes.value_taxes = parseFloat(rowCurrent.value_taxes);
                this.model.attributes.subtotal = parseFloat(rowCurrent.subtotal);
                this.model.attributes.authorization_number = rowCurrent.authorization_number;
                this.model.attributes.invoice_date = rowCurrent.invoice_date;
                this.model.attributes.establishment = rowCurrent.establishment;
                this.model.attributes.emission_point = rowCurrent.emission_point;
                this.model.attributes.mixed_payment = rowCurrent.mixed_payment;
                this.model.attributes.has_retention = rowCurrent.has_retention;
                this.model.attributes.debt = rowCurrent.debt;
                this.model.attributes.freight = rowCurrent.freight;
                this.model.attributes.type_of_discount = rowCurrent.type_of_discount;
                this.model.attributes.discount_type_invoice = rowCurrent.discount_type_invoice;
                this._viewManager(3, rowId);
            } else if (params.managerType == "managementPayment") {


                var dataSend = {
                    filters: {
                        treatment_by_patient_id: rowCurrent.id,
                    }
                };
                var blockElement = '.tabs';
                ajaxRequest($('#action-treatment-by-indebtedness-paying-init-getManagement').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: blockElement,//opcional: es para bloquear el elemento
                    loading_message: 'Cargando...',
                    error_message: 'Error en el sistema.!',
                    success_message: 'Datos cargados !',
                    success_callback: function (response) {
                        if (response.success) {
                            $scope.configModalTreatmentByIndebtednessPayingInit.data = {
                                TreatmentByPatient: rowCurrent,
                                'TreatmentByIndebtednessPayingInit': response.data
                            };

                            if ($scope.configModalTreatmentByIndebtednessPayingInit.viewAllow) {
                                $scope.$refs.refTreatmentByIndebtednessPayingInit._setValueOfParent(
                                    {type: "openModal", data: $scope.configModalTreatmentByIndebtednessPayingInit}
                                );
                            } else {
                                $scope.configModalTreatmentByIndebtednessPayingInit.viewAllow = true;
                            }
                        }
                    }
                });

            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {
                    var classStatus = "badge-success";
                    var rowStatus = 'PAGADO';
                    if (row.status == "PENDING") {
                        rowStatus = 'PENDIENTE';
                        classStatus = "badge-warning";
                    }

                    var description = row.observations == null || row.observations == 'null' ? [''] : ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.observations.label + ":</span><span class='content-description__value'>" + row.observations + "</span>",
                        "</div>"];

                    description = description.join('');
                    var value_taxes = parseFloat(row.value_taxes);
                    var taxConfig = 12;
                    var subtotal = parseFloat(row.subtotal);
                    var taxCurrentTotal = value_taxes * taxConfig / 100;
                    var resultsValue = [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Subtotal " + taxConfig + "%:</span><span class='content-description__value'>" + value_taxes + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Subtotal 0%:</span><span class='content-description__value'>" + subtotal + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>IVA</span><span class='content-description__value'>" + taxCurrentTotal + "</span>",
                        "</div>",
                    ];
                    resultsValue = resultsValue.join('');
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + rowStatus + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.invoice_date.label + ":</span><span class='content-description__value'>" + row.invoice_date + "</span>",
                        "</div>",
                        resultsValue,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.invoice_value.label + ":</span><span class='content-description__value'>" + row.invoice_value + "</span>",
                        "</div>",
                        description,
                        "</div>"];

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
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: _viewManager,
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "customer_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "customer_id"
                    },
                    "id": "customer_id",
                    "name": "customer_id",
                    "label": "Cliente",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "invoice_code": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 45,
                        "required": true,
                        "name": "invoice_code"
                    },
                    "id": "invoice_code",
                    "name": "invoice_code",
                    "label": "Codigo Factura",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 45.",
                    },
                },
                "invoice_value": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "invoice_value"
                    },
                    "id": "invoice_value",
                    "name": "invoice_value",
                    "label": "Total",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "discount_value": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "discount_value"
                    },
                    "id": "discount_value",
                    "name": "discount_value",
                    "label": "Total Descuento",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "status": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "PENDING", "text": "PENDING"}, {
                            "value": "ISSUED",
                            "text": "ISSUED"
                        }, {"value": "COLLECTED", "text": "COLLECTED"}, {"value": "CANCELED", "text": "CANCELED"}],
                        "required": true,
                        "name": "status"
                    },
                    "id": "status",
                    "name": "status",
                    "label": "Estado de Pago",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "PENDING", "text": "PENDIENTE"}, {
                        "value": "ISSUED",
                        "text": "PAGADA"
                    }]
                },
                "user_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "user_id"
                    },
                    "id": "user_id",
                    "name": "user_id",
                    "label": "Usuario",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "observations": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "observations"
                    },
                    "id": "observations",
                    "name": "observations",
                    "label": "Tratamiento Descripcion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "value_taxes": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "value_taxes"
                    },
                    "id": "value_taxes",
                    "name": "value_taxes",
                    "label": "Total Impuestos",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "subtotal": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "subtotal"
                    },
                    "id": "subtotal",
                    "name": "subtotal",
                    "label": "Subtotal",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "authorization_number": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 150,
                        "required": true,
                        "name": "authorization_number"
                    },
                    "id": "authorization_number",
                    "name": "authorization_number",
                    "label": "# Autorizacion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 150.",
                    },
                },
                "invoice_date": {
                    "field-options": {
                        "elementType": 4,
                        "elementTypeText": "Date",
                        "required": true,
                        "name": "invoice_date"
                    },
                    "id": "invoice_date",
                    "name": "invoice_date",
                    "label": "Fecha Emitida",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "establishment": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 3,
                        "required": true,
                        "name": "establishment"
                    },
                    "id": "establishment",
                    "name": "establishment",
                    "label": "Establecimiento",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 3.",
                    },
                },
                "emission_point": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 3,
                        "required": true,
                        "name": "emission_point"
                    },
                    "id": "emission_point",
                    "name": "emission_point",
                    "label": "Punto de Emision",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 3.",
                    },
                },
                "mixed_payment": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "mixed_payment"
                    },
                    "id": "mixed_payment",
                    "name": "mixed_payment",
                    "label": "Estado de Pago",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "has_retention": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "has_retention"
                    },
                    "id": "has_retention",
                    "name": "has_retention",
                    "label": "Retencion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "debt": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "debt"
                    },
                    "id": "debt",
                    "name": "debt",
                    "label": "Tiene Deuda?",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "freight": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "freight"
                    },
                    "id": "freight",
                    "name": "freight",
                    "label": "freight",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_of_discount": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "type_of_discount"
                    },
                    "id": "type_of_discount",
                    "name": "type_of_discount",
                    "label": "type of discount",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "discount_type_invoice": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "discount_type_invoice"
                    },
                    "id": "discount_type_invoice",
                    "name": "discount_type_invoice",
                    "label": "discount type invoice",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "history_clinic_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "history_clinic_id_data"
                        },
                        "id": "history_clinic_id_data",
                        "name": "history_clinic_id_data",
                        "label": "history clinic id",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    },
                'product_id_data': {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "history_clinic_id_data"
                    },
                    "id": "product_id_data",
                    "name": "product_id_data",
                    "label": "Producto / Servicio",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var manager_id = this.manager_id ? this.params.data.historyClinic.id : this.manager_id;
            this.invoiceDataManagement = this.getInitValuesInvoice(manager_id);
            var headerData = this.invoiceDataManagement.header;
            var result = {
                "id": null,
                "customer_id": null,
                "invoice_code": headerData.invoice_code,
                "invoice_value": headerData.invoice_value,
                "discount_value": headerData.discount_value,
                "status": "ISSUED",
                "user_id": null,
                "observations": headerData.observations,
                "value_taxes": headerData.value_taxes,
                "subtotal": headerData.subtotal,
                "authorization_number": headerData.authorization_number,
                "invoice_date": headerData.invoice_date,
                "establishment": headerData.establishment,
                "emission_point": headerData.emission_point,
                "mixed_payment": headerData.mixed_payment,
                "has_retention": headerData.has_retention,
                "debt": headerData.debt,
                "freight": headerData.freight,
                "type_of_discount": headerData.type_of_discount,
                "discount_type_invoice": headerData.discount_type_invoice,
                "history_clinic_id_data": headerData.history_clinic_id,
                items: []
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,

        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {
            var customer_id = this.params.data.historyClinic.customer_id;
            var items = [];
            var history_clinic_id = this.params.data.historyClinic.id;
            var haystack = this.$v.model.attributes.items.$model;
            $.each(haystack, function (indexRow, valueRow) {
                items.push(valueRow);
            });
            var debt = this.$v.model.attributes.status.$model == 'ISSUED' ? 0 : 1;
            var result = {
                TreatmentByPatient:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "customer_id": customer_id,
                        "invoice_code": this.$v.model.attributes.invoice_code.$model,
                        "invoice_value": this.$v.model.attributes.invoice_value.$model,
                        "discount_value": this.$v.model.attributes.discount_value.$model,
                        "status": this.$v.model.attributes.status.$model,
                        "observations": this.$v.model.attributes.observations.$model,
                        "value_taxes": this.$v.model.attributes.value_taxes.$model,
                        "subtotal": this.$v.model.attributes.subtotal.$model,
                        "authorization_number": this.$v.model.attributes.authorization_number.$model,
                        "invoice_date": this.$v.model.attributes.invoice_date.$model,
                        "establishment": this.$v.model.attributes.establishment.$model,
                        "emission_point": this.$v.model.attributes.emission_point.$model,
                        "mixed_payment": this.$v.model.attributes.mixed_payment.$model,
                        "has_retention": this.$v.model.attributes.has_retention.$model,
                        "debt": debt,
                        "freight": this.$v.model.attributes.freight.$model,
                        "type_of_discount": this.$v.model.attributes.type_of_discount.$model,
                        "discount_type_invoice": this.$v.model.attributes.discount_type_invoice.$model,
                        "history_clinic_id": history_clinic_id
                        , items: items
                    }
            };

            return result;
        },
        _saveModel: function () {


            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                $scope.submitStatus = 'error';
            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: $scope.formConfig.loadingMessage,
                    error_message: $scope.formConfig.errorMessage,
                    success_message: $scope.formConfig.successMessage,
                    success_callback: function (response) {
                        if (response.success) {
                            $scope._resetManagerGrid();
                            $scope.resetForm();
                            $($scope.gridConfig.selectorCurrent).bootgrid("reload");
                            $scope._viewManager(2);
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
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions
        getInitValuesInvoice: function (history_clinic_id) {
            var result = {
                header: {
                    customer_id: null,//*
                    invoice_code: 0,//*
                    invoice_value: 0,//*
                    discount_value: 0,
                    'status': 'ISSUED',//*
                    observations: '',
                    'value_taxes': 0,//*
                    'subtotal': 0,//*
                    'authorization_number': 0,//*
                    'invoice_date': null,//*
                    'establishment': 0,
                    'emission_point': 0,
                    'mixed_payment': 1,
                    'has_retention': 0,//sin retencion
                    'debt': 0,
                    'freight': 0,
                    'type_of_discount': 2,//anyone
                    'discount_type_invoice': 2,//anyone
                    'history_clinic_id': history_clinic_id
                },
                dataItems: [],


            };
            return result;
        },

        _managerS2ProductService: function (params) {
            var el = params.objSelector
            var modelCurrent = params.model;
            var dataCurrent = [];
            var $scope = this;
            var business_id = this.business_id;
            var isService = true;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-getProductService").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: business_id,
                                isService: isService
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
                var data = e.params.data;
                $scope._addProductService({
                    data: data,

                });
                elementInit.val(null).trigger("change");
            });
        },
        _addProductService: function (params) {
            var data = params['data'];
            console.log(data);
            var isService = data.isService;
            var product_id = data.id;
            var quantity = 1;
            var quantity_unit = 1;
            var discount_percentage = 0;
            var discount_percentage_unit = 0;
            var discount_value = 0;
            var discount_value_unit = 0;
            var unit_price = data.sale_price;
            var unit_price_unit = 0;
            var management_type = 'U';
            var tax_percentage = data.tax_percentage;
            var subtotal = unit_price - (((quantity * unit_price) * tax_percentage) / 100);
            var total = subtotal;
            var description = data.text;
            var product_type = isService;
            var createUpdate = true;

            var setPush = {
                product_id: product_id,
                quantity: quantity,
                quantity_unit: quantity_unit,
                discount_percentage: discount_percentage,
                discount_percentage_unit: discount_percentage_unit,
                discount_value: discount_value,
                discount_value_unit: discount_value_unit,
                unit_price: unit_price,
                unit_price_unit: unit_price_unit,
                management_type: management_type,
                tax_percentage: tax_percentage,
                subtotal: subtotal,
                total: total,
                description: description,
                product_type: product_type,
            };

            var haystack = this.$v.model.attributes.items.$each.$iter;
            var successNeedle = false;
            var dataNeedle = null;


            $.each(haystack, function (indexRow, valueRow) {
                if (product_id == valueRow.product_id['$model']) {
                    successNeedle = true;
                    dataNeedle = {
                        index: indexRow,
                        value: valueRow,
                    };
                }
            });
            var resultNeedle = {
                success: successNeedle,
                data: dataNeedle,

            }
            if (resultNeedle.success) {//update
                var dataRowCurrentManagement = resultNeedle.data;
                var dataRowCurrent = dataRowCurrentManagement.value;

                quantity = parseInt(dataRowCurrent.quantity['$model']) + 1;
                subtotal = unit_price - (((quantity * unit_price) * tax_percentage) / 100);
                setPush = {
                    product_id: product_id,
                    quantity: quantity,
                    quantity_unit: quantity_unit,
                    discount_percentage: discount_percentage,
                    discount_percentage_unit: discount_percentage_unit,
                    discount_value: discount_value,
                    discount_value_unit: discount_value_unit,
                    unit_price: unit_price,
                    unit_price_unit: unit_price_unit,
                    management_type: management_type,
                    tax_percentage: tax_percentage,
                    subtotal: subtotal,
                    total: total,
                    description: description,
                    product_type: product_type,


                };
                this.$v.model.attributes.items.$model[dataRowCurrentManagement.index] = setPush;
                this.$v.model.attributes.items.$each.$iter[dataRowCurrentManagement.index]['quantity']['$model'] = quantity;
                this.$v.model.attributes.items.$each.$iter[dataRowCurrentManagement.index]['subtotal']['$model'] = subtotal;
                this.$v.model.attributes.items.$each.$iter[dataRowCurrentManagement.index]['total']['$model'] = total;


            } else {//create
                this.$v.model.attributes.items.$model.push(setPush);
            }
            haystack = this.$v.model.attributes.items.$each.$iter;
            var resultInvoice = this.getManagementResultsInvoice({
                haystack: haystack
            });
            this.setManagementResultsInvoice(resultInvoice);
        },
        getFormStateClassRowGridItem: function (params) {
            /*{'form-group--error': v.$error==true ,'form-group--success': v.$error==false  }*/
            console.log('getFormStateClassRowGridItem', params);
        },
        _setValueItemForm: function (params) {
            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            var haystack = this.$v.model.attributes.items.$each.$iter;
            var resultInvoice = this.getManagementResultsInvoice({
                haystack: haystack
            });
            this.setManagementResultsInvoice(resultInvoice);
        },
        _deleteValueItemForm: function (params) {

            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            this.$v.model.attributes.items.$model.splice(indexCurrent, 1);
            var haystack = this.$v.model.attributes.items.$each.$iter;
            var resultInvoice = this.getManagementResultsInvoice({
                haystack: haystack
            });
            this.setManagementResultsInvoice(resultInvoice);
        },
        getManagementResultsInvoice: function (params) {
            var invoice_value = 0;
            var discount_value = 0;
            var value_taxes = 0;
            var subtotal = 0;
            var debt = 0;
            var freight = 0;
            var haystack = params['haystack'];
            var details = [];
            var discountNotTax = 0;
            var discountTax = 0;

            $.each(haystack, function (indexRow, valueRow) {
                var quantity = parseFloat(valueRow.quantity['$model']);
                var unit_price = parseFloat(valueRow.unit_price['$model']);


                var discount_percentage = parseFloat(valueRow.discount_percentage['$model']);
                var valueTotal = quantity * unit_price;
                var tax_percentage = parseFloat(valueRow.tax_percentage['$model']);
                var discountCurrent = 0;
                if (discount_percentage > 0) {
                    discountCurrent = (valueTotal * discount_percentage) / 100;
                    discount_value += discountCurrent;
                }
                var subtotalCurrent = valueTotal - discount_value;
                if (tax_percentage > 0) {
                    value_taxes += subtotalCurrent;
                    if (discount_percentage > 0) {
                        discountTax += discount_value;
                    }
                } else {
                    subtotal += subtotalCurrent;
                    if (discount_percentage > 0) {
                        discountNotTax += discount_value;
                    }
                }
                var totalCurrent = 0;
                details[indexRow] = valueRow;
                details[indexRow]['quantity']['$model'] = quantity;
                details[indexRow]['subtotal']['$model'] = subtotalCurrent;
                details[indexRow]['discount_value']['$model'] = discount_value;
                details[indexRow]['total']['$model'] = totalCurrent;
            });
            var taxCurrentManagement = ((value_taxes - discountTax) * 12) / 100;
            invoice_value = value_taxes + subtotal - discount_value + taxCurrentManagement;
            var result = {
                header: {
                    invoice_value: invoice_value,// TOTAL
                    discount_value: discount_value,// DISCOUNT,
                    'value_taxes': value_taxes,// SUBTOTAL 12 %*
                    'subtotal': subtotal,//* SUBTOTAL 0%*
                    'debt': debt,
                    'freight': freight,
                },
                body: {
                    details: details
                }
            };
            return result;
        },
        setManagementResultsInvoice: function (params) {

            this.invoiceDataManagementResults = params;
            var headerCurrent = params.header;
            var keySetManager = 'invoice_value';
            this.$v.model.attributes[keySetManager].$model = headerCurrent[keySetManager];
            keySetManager = 'value_taxes';
            this.$v.model.attributes[keySetManager].$model = headerCurrent[keySetManager];
            keySetManager = 'subtotal';
            this.$v.model.attributes[keySetManager].$model = headerCurrent[keySetManager];

        }


    }
})
;



