var componentThisEventsTrailsProject;
Vue.component('events-trails-project-component', {
    components: {
        DateTimePicker: DateTimePicker
    },
    template: '#events-trails-project-template',
    directives: {
        initS2EventsTrailsTypes: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2EventsTrailsTypes({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        "_upload-resource": {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._initEventsUpload({
                    objSelector: el
                });

            },
        }
    },
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


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisEventsTrailsProject = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    computed: {},
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(250)},
            "description": {},
            "status": {required},
            "date_init_project": {required},
            "date_end_project": {required},
            "events_trails_types_id_data": {required},
            "source": {required},
            "change": {},

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
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": "fas fa-pencil-alt",
                        "managerType": "updateEntity",
                        "isUrl": false,
                    },
                    {
                        "title": "Administrar Evento",
                        "data-placement": "top",
                        "i-class": "fa   fa-calendar",
                        "managerType": "managerBusiness",
                        "isUrl": true,
                        "url": "/eventsTrailsProject/manager/"
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

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-events-trails-project',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#events-trails-project-form",
                url: $('#action-events-trails-project-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el EventsTrailsProject.',
                successMessage: 'El EventsTrailsProject se guardo correctamente.',
                nameModel: "EventsTrailsProject"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#events-trails-project-grid",
                url: $("#action-events-trails-project-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            lblUploadName: "Subir Imagen.",
            uploadConfig: {
                uploadElementsSelectors: {
                    file: "#file_upload_img",

                },
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
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this._viewManager(3, rowId);
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.date_init_project = new Date(rowCurrent.date_init_project);
                this.model.attributes.date_end_project = new Date(rowCurrent.date_end_project);
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.events_trails_types_id_data = {
                    id: rowCurrent.events_trails_types_id,
                    text: rowCurrent.events_trails_types
                };


            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
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
                labels: {
                    loading: "Cargando...",
                    noResults: "Sin Resultados!",
                    infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
                },
                css: getCSSCurrentBootGrid(),
                formatters: {
                    'description': function (column, row) {
                        var result = [
                            "<div class='content-description'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'>" + row.status + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + row.events_trails_types + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + row.value + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripcion:</span><span class='content-description__value'>" + row.description + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Fecha Inicio:</span><span class='content-description__value'>" + row.date_init_project + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Fecha Fin:</span><span class='content-description__value'>" + row.date_end_project + "</span>",
                            "</div>",

                            "</div>"];

                        return result.join("");

                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager:_viewManager,
//FORM CONFIG
        getViewErrorForm:getViewErrorForm,
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                value: {
                    id: "value",
                    name: "value",
                    label: "Nombre Evento",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 250.",
                    },
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required: {
                        allow: false,
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
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                date_init_project: {
                    id: "date_init_project",
                    name: "date_init_project",
                    label: "Fecha Inicio",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                date_end_project: {
                    id: "date_end_project",
                    name: "date_end_project",
                    label: "Fecha Fin",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                events_trails_types_id_data: {
                    id: "events_trails_types_id_data",
                    name: "events_trails_types_id_data",
                    label: "Tipo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
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
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "value": null,
                "description": null,
                "status": 'ACTIVE',
                "date_init_project": null,
                "date_end_project": null,
                "events_trails_types_id_data": null,
                "source": null,
                "change": false
            };
            return result;
        },

        getNameAttribute:getNameAttribute,
        getLabelForm: viewGetLabelForm,
        _setValueForm:_setValueForm,
        getClassErrorForm:getClassErrorForm,
        getErrorHas:getErrorHas,
        getViewError: getViewError,
//Manager Model

        getValuesSave: function () {

            var result = {

                "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                "value": this.$v.model.attributes.value.$model,
                "description": this.$v.model.attributes.description.$model,
                "status": this.$v.model.attributes.status.$model,
                "date_init_project": moment(this.$v.model.attributes.date_init_project.$model).format("YYYY-MM-DD"),
                "date_end_project": moment(this.$v.model.attributes.date_end_project.$model).format("YYYY-MM-DD"),
                "business_id": this.business_id,
                "events_trails_types_id": this.$v.model.attributes.events_trails_types_id_data.$model.id,
                source: this.$v.model.attributes.source.$model,
                change: this.$v.model.attributes.change.$model,


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
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm: getValidateForm,
//others functions
        _managerS2EventsTrailsTypes: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.events_trails_types_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-events-trails-types-getListSelect2").val(),
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
                allowClear: true,
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.events_trails_types_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_room_levels_id_data = null;
                _this._setValueForm('events_trails_types_id_data', null);
            });
        },

        /*   UPLOAD IMAGE*/
        _uploadData: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.file).click();
            event.stopPropagation();

        },
        _initEventsUpload: function () {
            var _this = this;
            var srcSource = this.model.attributes.source;
            if (srcSource) {
                $(".content-box-image__preview").attr("src", $resourceRoot+srcSource);
            }
            $(this.uploadConfig.uploadElementsSelectors.file).change(function () {
                var file = $(this)[0].files[0];
                if (file) {
                    if (file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/svg+xml") {//format kml
                        var reader = new FileReader();
                        srcSource = window.URL.createObjectURL(file);
                        $(".content-box-image__preview").attr("src", srcSource);
                        _this.model.attributes.source = file;

                        if (_this.managerType == 3) {
                            _this.model.attributes.change = true;
                        }
                    } else {
                        alert("No es una imagen.");
                    }
                }
                return false;
            });

        },
    }
})
;




