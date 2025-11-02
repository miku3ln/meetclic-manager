var componentThisOdontogramByPatient;
var OdontogramView = null;
Vue.component('odontogram-by-patient-component', {
    template: '#odontogram-by-patient-template',
    directives: {
        initOdontogram: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el, model: paramsInput.model
                });
            },
        },
        initSelect2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el, model: paramsInput.model
                });
            },

        },
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        var $scope = this;
        this.odontogramApi = new renderOdontograms({scope: $scope});
        $(window).resize(function () {
            $scope.odontogramApi.resizeElementsSNAPSVG();
        });
    },
    mounted: function () {
        componentThisOdontogramByPatient = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "status": {required},
            "itemsManagement": {required},
            "description": {required},
            "date": {required},
            "history_clinic_id_data": {},
            items: {
                required,
                minLength: minLength(1),
                $each: {
                    "id": {},//form update
                    "status": {},//server
                    "description": {required},// form
                    "type": {required},//3 odontogram
                    "dental_piece_id": {required},//1 odontogram
                    "reference_piece_position_id": {required},//2 odontogram type name
                    "reference_piece_id": {required},//form select2
                    "odontogram_by_patient_id": {},
                    "typeDPBO": {},//4
                    'addPush': false,
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
            manager_key_name: 'history_clinic_id',
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
            tabCurrentSelector: '.tabs',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#odontogram-by-patient-form",
                url: $('#action-odontogram-by-patient-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el OdontogramByPatient.',
                successMessage: 'El OdontogramByPatient se guardo correctamente.',
                nameModel: "OdontogramByPatient"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#odontogram-by-patient-grid",
                url: $("#action-odontogram-by-patient-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            history_clinic_id: null,
            //ODONTOGRAM
            odontogramApi: null,
            initOdontogram: false,
            dataOdontogram: [],
            popoverConfigForm: this.getPopoverConfigForm()
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.historyClinic.id;
            this.history_clinic_id = this.configParams.data.historyClinic.id;
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
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
                elementSelect: elementSelect,

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
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.description = rowCurrent.description;

                this.model.attributes.date = rowCurrent.dateManagement;
                var dataSend = {
                    odontogram_by_patient_id: rowCurrent.id,

                };
                var blockElement = '.tabs';
                ajaxRequest($('#action-dental-piece-by-odontogram-getDataDentalPieceByOdontogramId').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: blockElement,//opcional: es para bloquear el elemento
                    loading_message: 'Cargando...',
                    error_message: 'Error en el sistema.!',
                    success_message: 'Datos cargados !',
                    success_callback: function (response) {
                        if (response.success) {

                            $scope.dataOdontogram = response.data;
                            $scope._viewManager(3, rowId);
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
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.date.label + ":</span><span class='content-description__value'>" + row.date + "</span>",
                        "</div>",

                        , "</div>"];

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
        _viewManager: function (typeView) {
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
        _submitForm: function (e) {
            console.log(e);

        },
        getStructureForm: function () {
            var result = {
                "status": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "status"
                    },
                    "id": "status",
                    "name": "status",
                    "label": "Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "description": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "description"
                    },
                    "id": "description",
                    "name": "description",
                    "label": "Descripcion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "date": {
                    "field-options": {"elementType": 4, "elementTypeText": "Date", "required": true, "name": "date"},
                    "id": "date",
                    "name": "date",
                    "label": "Fecha Registro",
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
                items: {
                    "description": {
                        "field-options": {
                            "elementType": 5,
                            "elementTypeText": "Text Area",
                            "required": true,
                            "name": "description"
                        },
                        "id": "description",
                        "name": "description",
                        "label": "Descripcion",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    },
                    "reference_piece_id": {
                        "field-options": {
                            "elementType": 5,
                            "elementTypeText": "Text Area",
                            "required": true,
                            "name": "description"
                        },
                        "id": "reference_piece_id",
                        "name": "reference_piece_id",
                        "label": "Referencia",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "status": "ACTIVE",
                "description": null,
                "date": null,
                "history_clinic_id_data": null,
                items: [],
                itemsManagement: null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,

        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {
            var items = [];

            var haystack = this.$v.model.attributes.items.$model;
            $.each(haystack, function (indexRow, valueRow) {
                items.push(valueRow);
            });
            var result = {
                OdontogramByPatient:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "status": this.$v.model.attributes.status.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "date": this.$v.model.attributes.date.$model,
                        "history_clinic_id": this.manager_id,
                        items: items

                    }
            };

            return result;
        },
        _saveModel: _saveModel,
        resetForm: function () {
            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
            this.popoverConfigForm = this.getPopoverConfigForm();
            this.dataOdontogram = [];
            this.initOdontogram = false;
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,
        getValidateForm: getValidateForm,
        getFormStateClassRowGridItem: function (params) {
            /*{'form-group--error': v.$error==true ,'form-group--success': v.$error==false  }*/
            console.log('getFormStateClassRowGridItem', params);
        },
        _setValueItemForm: function (params) {
            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            var haystack = this.$v.model.attributes.items.$each.$iter;

        },
        _deleteValueItemForm: function (params) {

            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            this.$v.model.attributes.items.$model.splice(indexCurrent, 1);

        },
        //ODONTOGRAM
        initSvg: function () {
            $scope = this;
            this.odontogramApi.initOdontogramsSvg(function (params) {
                console.log('ready management', params, $scope.dataOdontogram);
                $scope.initOdontogram = true;
                $scope.odontogramApi.setValuesOdontogramsSvg($scope.dataOdontogram);
            });

        },
        _viewFrmManagement: function (params) {
            console.log(params);
            this.popoverConfigForm.buttons.title = 'Agregar';
            this.popoverConfigForm.currentPieceObj = params.currentPieceObj;

            var initManagementCreateUpdate = params.initManagementCreateUpdate;
            var managementDataOdontogram = params.managementDataOdontogram;
            var initElement = params.initElement;
            var dental_piece_id = managementDataOdontogram['dental_piece_id'];
            var type = managementDataOdontogram['type'];
            var reference_piece_position_id = managementDataOdontogram['reference_piece_position_id'];
            var reference_piece_id = initManagementCreateUpdate ? null : -1;
            var odontogram_by_patient_id = initManagementCreateUpdate ? null : -1;
            var id = initManagementCreateUpdate ? null : -1;
            var description = initManagementCreateUpdate ? null : -1;
            var addPush = initManagementCreateUpdate ? false : true;
            var typeDPBO = managementDataOdontogram['typeDPBO'];
            var setPush = {
                "id": id,//form update
                "status": 'ACTIVE',//server
                "description": description,// form
                "type": type,//3 odontogram
                "dental_piece_id": dental_piece_id,//1 odontogram
                "reference_piece_position_id": reference_piece_position_id,//2 odontogram type name
                "reference_piece_id": reference_piece_id,//form select2
                "odontogram_by_patient_id": odontogram_by_patient_id,
                "typeDPBO": typeDPBO,//4
                'addPush': addPush,
            };
            this.deleteItemFormNotManagement();
            var position = reference_piece_position_id;
            if (initElement) {

                /*  popoverConfigForm.piecesSelect.options*/
                var managementPieces = this.countItemsManagementPieces({
                    needle: dental_piece_id,
                    'type': type,
                    position: position
                });
                this.popoverConfigForm.pieces.count = managementPieces.count;
                this.popoverConfigForm.piecesSelect.options = managementPieces.options;
                this.popoverConfigForm.piecesSelect.model = null;
                if (!initManagementCreateUpdate) {//update

                } else {
                    this.$v.model.attributes.items.$model.push(setPush);
                    var keySetPush = this.$v.model.attributes.items.$model.indexOf(setPush);
                    $vModel = this.$v.model.attributes.items.$each.$iter[keySetPush];
                    this.popoverConfigForm.v = $vModel;
                    this.popoverConfigForm.id = null;
                    this.popoverConfigForm.dataForm = setPush;
                    this.popoverConfigForm.key = keySetPush;
                    var targetCurrent = $(params.currentPieceObj.node).attr('id');
                    this.popoverConfigForm.target = targetCurrent;
                    this.showPopover();
                    this.allowValidItems();
                }
            } else {

                if (!initManagementCreateUpdate) {//update

                } else {
                    this.closePopover();

                }
            }


        },
        deleteItemFormNotManagement: function () {
            var allowDelete = this.popoverConfigForm.key != null && this.popoverConfigForm.addPush == false;
            if (allowDelete) {
                this.deleteItemModel({index: this.popoverConfigForm.key});
                this.popoverConfigForm.key = null;

            }
        },

        deleteItemModel: function (params) {
            var indexCurrent = params['index'];
            this.$v.model.attributes.items.$model.splice(indexCurrent, 1);

        },
        _closePopover() {


        },
        _showPopover() {


        },
        _shownPopover() {


        },
        closePopover() {
            this.popoverConfigForm.popoverShow = false;
            this.deleteItemFormNotManagement();
            this.allowValidItems();

        },
        closePopoverButton: function (index) {
            this.popoverConfigForm.addPush = false;
            var type = this.popoverConfigForm['dataForm']['type'];
            var dental_piece_id = this.popoverConfigForm['dataForm']['dental_piece_id'];
            var selector = '#' + this.popoverConfigForm.target;

            var dental_piece_piece = dental_piece_id;//CARIES
            var colorSet = '#fff';
            var reference_piece_color = colorSet;
            var reference_piece_name = '';
            var reference_piece_id = null;

            if (this.popoverConfigForm['dataForm']['reference_piece_id'] && this.popoverConfigForm['dataForm']['reference_piece_id'].hasOwnProperty('color')) {
                reference_piece_color = this.popoverConfigForm['dataForm']['reference_piece_id']['color'];
                reference_piece_id = this.popoverConfigForm['dataForm']['reference_piece_id']['id'];
                reference_piece_name = this.popoverConfigForm['dataForm']['reference_piece_id']['text'];
            }

            var reference_piece_position_id = this.popoverConfigForm['dataForm']['reference_piece_position_id'];
            var type = this.popoverConfigForm['dataForm']['type'];
            var reference_piece_type = type;
            var reference_piece_position_position = reference_piece_position_id;
            this.endManagementPiece({
                type: type,
                selector: selector,
                dental_piece_id: dental_piece_id,

            });
            this.closePopover();
            if (type == 'COMPLETE') {

                var setConfig = {
                    dental_piece_piece: dental_piece_piece,//*
                    reference_piece_id: reference_piece_id,//*
                    reference_piece_position_position: reference_piece_position_position,//*
                    reference_piece_type: reference_piece_type,//*
                    type: type,
                    reference_piece_color: reference_piece_color,
                    reference_piece_position_id: reference_piece_position_id
                };
                this.odontogramApi.resetCleanPiece(setConfig);
            } else {
                if (this.popoverConfigForm.currentPieceObj.attr('management-items')) {
                } else {
                    this.popoverConfigForm.currentPieceObj.attr("fill", reference_piece_color);
                    this.popoverConfigForm.currentPieceObj.attr("stroke", '#000000');
                    this.popoverConfigForm.currentPieceObj.attr("fill-opacity", "0");
                }
            }

        },
        showPopover() {
            this.popoverConfigForm.popoverShow = true;

        },
        _deleteFormPopoverItem: function (index) {
            /*delete new*/
            this.deleteItemModel({index: this.popoverConfigForm.key});
            var keySetPush = index;
            this.popoverConfigForm.key = keySetPush;
            $vModel = this.$v.model.attributes.items.$each.$iter[this.popoverConfigForm.key];
            this.popoverConfigForm.v = $vModel;
            var addPush = $vModel['addPush']['$model'];
            var dental_piece_id = $vModel['dental_piece_id']['$model'];
            var description = $vModel['description']['$model'];
            var id = $vModel['id']['$model'];
            var odontogram_by_patient_id = $vModel['odontogram_by_patient_id']['$model'];
            var reference_piece_id = $vModel['reference_piece_id']['$model'];
            var reference_piece_position_id = $vModel['reference_piece_position_id']['$model'];
            var status = $vModel['status']['$model'];
            var type = $vModel['type']['$model'];
            var typeDPBO = $vModel['typeDPBO']['$model'];
            this.popoverConfigForm['dataForm'] = {
                addPush: addPush,
                dental_piece_id: dental_piece_id,
                description: description,
                id: id,
                odontogram_by_patient_id: odontogram_by_patient_id,
                reference_piece_id: reference_piece_id,
                reference_piece_position_id: reference_piece_position_id,
                status: status,
                type: type,
                typeDPBO: typeDPBO,
            }
            this.allowValidItems();

            var dental_piece_name = 'No Name';
            var dental_piece_piece = dental_piece_id;//CARIES
            var reference_piece_color = this.popoverConfigForm['dataForm']['reference_piece_id']['color'];
            var reference_piece_id = this.popoverConfigForm['dataForm']['reference_piece_id']['id'];
            var reference_piece_name = this.popoverConfigForm['dataForm']['reference_piece_id']['text'];
            var reference_piece_type = this.popoverConfigForm['dataForm']['reference_piece_id']['type'];
            var reference_piece_position_id = this.popoverConfigForm['dataForm']['reference_piece_position_id'];
            var type = this.popoverConfigForm['dataForm']['type'];
            var reference_piece_position_position = reference_piece_position_id;
            var setConfig = {
                dental_piece_piece: dental_piece_piece,//*
                reference_piece_id: reference_piece_id,//*
                reference_piece_position_position: reference_piece_position_position,//*
                reference_piece_type: reference_piece_type,//*
                type: type,
                reference_piece_color: reference_piece_color,
                reference_piece_position_id: reference_piece_position_id
            };

            this.odontogramApi.resetCleanPiece(setConfig);
            var selector = '#' + this.popoverConfigForm.target;
            this.popoverConfigForm.addPush = false;
            this.closePopover();
            this.endManagementPiece({
                type: type,
                selector: selector,
                dental_piece_id: dental_piece_id,

            });
            this.deleteItemModel({index: keySetPush});

        },
        endManagementPiece: function (params) {
            var type = params['type'];
            var selector = params['selector'];
            var dental_piece_id = params['dental_piece_id'];

            if (type == 'INDIVIDUAL') {
                $(selector).removeClass('init-management-cara');
            } else {
                selector = '#pieza_' + dental_piece_id;
                $(selector).removeClass('piece-hover--management-complete');
                selector = '#hover_' + dental_piece_id;
                $(selector).removeClass('piece-hover--management');
            }
        },
        _addModelPopover: function (params) {
            var modelCurrent = params.v;
            var keySetPush = params.key;
            this.popoverConfigForm.addPush = true;
            this.popoverConfigForm.key = null;
            this.$v.model.attributes.items.$each.$iter[keySetPush]['$model']['addPush'] = true;
            this.popoverConfigForm.key = null;
            this.allowValidItems();
            var dental_piece_id = this.popoverConfigForm['dataForm']['dental_piece_id'];
            var dental_piece_name = 'No Name';
            var dental_piece_piece = dental_piece_id;//CARIES
            var description = this.popoverConfigForm['dataForm']['description']['$model'];
            var reference_piece_color = this.popoverConfigForm['dataForm']['reference_piece_id']['color'];
            var reference_piece_id = this.popoverConfigForm['dataForm']['reference_piece_id']['id'];
            var reference_piece_name = this.popoverConfigForm['dataForm']['reference_piece_id']['text'];
            var reference_piece_type = this.popoverConfigForm['dataForm']['reference_piece_id']['type'];
            var reference_piece_position_id = this.popoverConfigForm['dataForm']['reference_piece_position_id'];
            var type = this.popoverConfigForm['dataForm']['type'];
            var reference_piece_position_position = reference_piece_position_id;
            var setConfig = {
                dental_piece_piece: dental_piece_piece,//*
                reference_piece_id: reference_piece_id,//*
                reference_piece_position_position: reference_piece_position_position,//*
                reference_piece_type: reference_piece_type,//*
                type: type,
                reference_piece_color: reference_piece_color,
                reference_piece_position_id: reference_piece_position_id
            };

            this.odontogramApi.setConfigPiece(setConfig);
            var selector = '#' + this.popoverConfigForm.target;
            this.popoverConfigForm.addPush = false;
            this.closePopover();
            this.endManagementPiece({
                type: type,
                selector: selector,
                dental_piece_id: dental_piece_id,

            });
        },
        _setValueFormItemsPiecesSelect: function (keySetPush) {
            $vModel = this.$v.model.attributes.items.$each.$iter[keySetPush];
            this.popoverConfigForm.v = $vModel;
            this.popoverConfigForm.buttons.title = 'Actualizar';
        },
        allowValidItems: function () {
            var haystack = this.$v.model.attributes.items.$each.$iter;
            var allowSave = true;
            $.each(haystack, function (indexRow, valueRow) {
                if (valueRow['$model']['addPush'] == false) {
                    allowSave = null;
                }
            });
            this.$v.model.attributes.itemsManagement['$model'] = allowSave;

        },
        countItemsManagementPieces: function (params) {

            var haystack = this.$v.model.attributes.items.$each.$iter;
            var needle = params['needle'];
            var type = params['type'];
            var position = params['position'];
            var models = [];
            var count = 0;
            var options = [];
            $.each(haystack, function (indexRow, valueRow) {
                if (valueRow['$model']['addPush'] && needle == valueRow['$model']['dental_piece_id'] && type == valueRow['$model']['type'] && position == valueRow['$model']['reference_piece_position_id']) {
                    count++;
                    models.push(valueRow);
                    var text = valueRow['$model']['reference_piece_id']['text'];
                    options.push(
                        {
                            value: indexRow,
                            text: text,
                        }
                    );
                }
            });

            var result = {
                count: count,
                models: models,
                options: options
            }
            return result;
        },
        validateFormPopover: function (params) {

            var modelCurrent = params.v;
            var result = !modelCurrent.$invalid;
            return result;
        },
        _submitFormPopover: function (e) {
            console.log(e);

        },

        initS2ReferencePiece: function (params) {
            var el = params.objSelector;

            var dataCurrent = [];
            var $scope = this;
            var treatment_by_indebtedness_paying_init_id = this.manager_id;
            var type = this.popoverConfigForm.dataForm.type;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-reference-piece-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            search_value: term,
                            type: type

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
                var keySetPush = $scope.popoverConfigForm.key;
                $scope.popoverConfigForm.key = keySetPush;
                $scope.popoverConfigForm.v['reference_piece_id']['$model'] = data;
                $scope.$v.model.attributes.items.$each.$iter[keySetPush]['reference_piece_id']['$model'] = data;

            }).on("select2:unselecting", function (e) {
                var keySetPush = $scope.popoverConfigForm.key;
                var data = null;
                $scope.popoverConfigForm.key = keySetPush;
                $scope.popoverConfigForm.v['reference_piece_id']['$model'] = data;
                $scope.$v.model.attributes.items.$each.$iter[keySetPush]['reference_piece_id']['$model'] = data;

            });
        },
        getPopoverConfigForm: function () {
            var result = {
                popoverShow: false,
                dataForm: null,
                id: null,
                title: "Referencias Pieza",
                key: null,
                v: null,
                target: '',
                'addPush': false,
                buttons: {
                    create: 'Agregar',
                    update: 'Actualizar',
                    'title': 'Agregar',
                },
                pieces: {
                    count: 0,
                    items: []
                },
                piecesSelect: {
                    model: null,//is index
                    options: [],

                }

            };
            return result;
        },
    }
})
;



