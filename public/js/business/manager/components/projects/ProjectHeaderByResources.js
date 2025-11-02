let componentThisInformationMail;
let configProcessModal = {//CPP-004
    'manager': UtilManagerCustomModel.getManagerData('project_header_by_resources'),
    'component': null,
};
Vue.component(configProcessModal.manager.modelProcess + '-component', {
    template: '#' + configProcessModal.manager.modelProcess + '-template',
    directives: {}, props: {
        params: {
            type: Object,
        }
    },
    created: function () {

    },
    beforeMount: function () {
        this.configParams = this.params;
    },
    mounted: function () {
        configProcessModal.component = this;
        this.initCurrentComponent();
    },


    validations: function () {
        let attributes = {
            "id": {},
            "type_multimedia": {required},
            "url": {required},
            "status": {required},
            "description": {required},

        };
        let result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        let dataManager = {
            businessId: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": "fas fa-pencil-alt",
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
                "title": "Sin Especificación",
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
            tabCurrentSelector: '#modal-' + configProcessModal.manager.modelProcess,
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#" + configProcessModal.manager.modelProcess + "-form",
                url: $('#action-' + configProcessModal.manager.modelProcess + '-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + configProcessModal.manager.modelName + '.',
                successMessage: 'El ' + configProcessModal.manager.modelName + ' se guardo correctamente.',
                nameModel: configProcessModal.manager.modelName
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#" + configProcessModal.manager.modelProcess + "-grid",
                url: $("#action-" + configProcessModal.manager.modelProcess + "-admin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            typeMultimediaData: [
                {
                    id: 0,
                    text: 'Imagen',
                },
                {
                    id: 1,
                    text: 'Archivo',
                },
                {
                    id: 2,
                    text: 'Url',
                }
            ],
            statusData: [
                {
                    id: 'ACTIVE',
                    text: 'ACTIVO',
                },
                {
                    id: 'INACTIVE',
                    text: 'INACTIVO',
                }
            ],
            manager_parent_id: null,
            ulrManager: null,
            managerUpload: {
                type: 0,
                urlManager: null,
                createUpdate: 0,
                change: false
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        getParamsUpload: function () {

            let result = '';
            let name = 'type_multimedia';
            if (this.$v["model"]["attributes"][name].$model == 0) {
                result = 'image/png,image/jpeg';
            } else if (this.$v["model"]["attributes"][name].$model == 1) {
                result = '.xlsx, .xls, .doc, .docx, .pdf';
            }
            return result;
        },
        getUrlManagerView(urlManager) {
            let result = '';
            if (this.$v["model"]["attributes"]['id'].$model != null) {
                if (this.managerUpload.change) {
                    result = urlManager;

                } else {
                    result = $resourceRoot + urlManager;
                }

            } else {
                result = urlManager;

            }
            return result;
        },
        handleFileUpload(event) {
            // UploadUtil.prototype.managerUploadModel
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                this.managerUpload.urlManager = e.target.result;
                let srcSource = window.URL.createObjectURL(file);
                if (this.$v["model"]["attributes"]['id'].$model != null) {
                    this.managerUpload.change = true;
                }
                if (this.$v["model"]["attributes"]['type_multimedia'] == 1) {
                    this.$v["model"]["attributes"]['url'].$model = file;
                    this.$v["model"]["attributes"]['url'].$touch();
                } else {
                    this.$v["model"]["attributes"]['url'].$model = file;
                    this.$v["model"]["attributes"]['url'].$touch();
                }

            };
            if (file) {

                reader.readAsDataURL(file);
            }
        },
        //MANAGER PROCESS
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs ["ref" + configProcessModal.manager.modelName + 'Modal'].show();

               this. _managerTypes({
                   type:'rebootGrid'
               });

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },
        initCurrentComponent: function () {
            this.initDataModal();
            this.initGridManager(this);
            this.$refs ["ref" + configProcessModal.manager.modelName + 'Modal'].show();


        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModal' + configProcessModal.manager.modelName
            });
        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs ["ref" + configProcessModal.manager.modelName + 'Modal'].hide();


        },
        initDataModal: function () {
            let rowCurrent = this.configParams.data;

            this.setDataInit(rowCurrent);
        },
        setDataInit: function (rowCurrent) {
            this.managerMenuConfig.view = false;
            let managerProcessMain = 'project_header';
            this.rowCurrent = rowCurrent;
            this.manager_parent_id = rowCurrent[managerProcessMain + "_id"];
            this.businessId = rowCurrent.businessId;
            this.labelsConfig.title = "Agregar Verificables " + ' a ' + rowCurrent[managerProcessMain + "Name"];
            this.managerInitAll = true;


            this._viewManager(2, null);

        },
//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
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
        _managerMenuGrid: function (index, menu) {
            let params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
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
        _managerRowGrid: function (params) {
            let rowCurrent = params.row;
            let rowId = params.id;
            if (params.managerType == "updateEntity") {
                let elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.type_multimedia = rowCurrent.type_multimedia;
                this.model.attributes.url = rowCurrent.url;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;

                this.managerUpload.urlManager = rowCurrent.url;
                this.managerUpload.type = rowCurrent.type_multimedia;
                this._viewManager(3, rowId);
            }
        },
        initGridParams: function () {
            return {
                manager_parent_id: this.manager_parent_id,
                businessId: this.businessId,

            };
        },
        initGridManager: function (vmCurrent) {
            let gridName = this.gridConfig.selectorCurrent;
            let urlCurrent = this.gridConfig.url;
            let $scope = this;
            let gridInit = $(gridName);
            gridInit.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                post: function () {
                    return {
                        grid_id: gridName,
                        filters: $scope.initGridParams(),
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


                        let stateRow = [
                            row.status == 'ACTIVE' ? '<span class="content-description__value badge badge--size-large badge-success">' : '<span class="content-description__value badge badge--size-large badge-warning">',
                            row.status == 'ACTIVE' ? 'ACTIVO' : 'INACTIVO',
                            '</span>'
                        ];
                        let urlViewSource = $resourceRoot + row.url;
                        stateRow = stateRow.join('');
                        let urlView = [];
                        if (row.type_multimedia == 0) {
                            urlView = [
                                '   <div  class="manager-upload-view-data__content-img">',
                                '      <img src="' + urlViewSource + '"   alt="Uploaded Image" class="manager-upload-view-data__img">',
                                '   </div">'

                            ];

                        } else if (row.type_multimedia == 1) {
                            urlView = [
                                '   <div  class="manager-upload-view-data__content-link">',
                                '      <a href="' + urlViewSource + '"   target="_blank" class="manager-upload-view-data__link">',
                                '            Descargar',
                                '      </a>',
                                '   </div">'

                            ];
                        } else if (row.type_multimedia == 2) {
                            urlView = [
                                '   <div  class="manager-upload-view-data__content-link">',
                                '      <a href="' + urlViewSource + '"   target="_blank" class="manager-upload-view-data__link">',
                                '            Ver',
                                '      </a>',
                                '   </div">'

                            ];
                        }

                        let result = [
                            "<div class='content-description'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Url:</span>" + urlView.join(''),
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripcion :</span><span class='content-description__value'>" + (row.description == null ? 'S/N' : row.description) + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span>" + stateRow,
                            "</div>",

                            "</div>"
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
//FORM CONFIG
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
                type_multimedia: {
                    id: "type_multimedia",
                    name: "type_multimedia",
                    label: "Tipo de Multimedia",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                url: {
                    id: "url",
                    name: "url",
                    label: "Url",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },

                status: {
                    id: "status",
                    name: "status",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            let result = {
                "id": null,
                "type_multimedia": 0,
                "status": 'ACTIVE',
                "url": null,
                "description": '',
            };
            return result;
        },

        getNameAttribute: function (name) {
            let result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value) {

            if (name == 'type_multimedia') {
                this.managerUpload.urlManager = null;
                this.managerUpload.type = value
                this.$v["model"]["attributes"]['url'].$model = null;
                this.$v["model"]["attributes"]['url'].$touch();
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

            let resultData =

                {
                    "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    "type_multimedia": this.$v.model.attributes.type_multimedia.$model,
                    "status": this.$v.model.attributes.status.$model,
                    "url": this.$v.model.attributes.url.$model,
                    "description": this.$v.model.attributes.description.$model,
                    "project_header_id": this.manager_parent_id,
                    managerUpload: this.managerUpload,
                    change: this.managerUpload.change

                };
            let result = {};
            result = resultData;
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
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
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
//others functions

    }
})
;




