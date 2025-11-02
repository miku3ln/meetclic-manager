var componentThisBusinessAcademicOfferingsDataByInformation;
Vue.component('business-academic-offerings-data-by-information-component', {
    template: '#business-academic-offerings-data-by-information-template',
    directives: {
        initEventUploads: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        },
        initSummerNote: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var initMethod = paramsInput['initMethod'];
                initMethod({
                    elementInit: el
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
        this.$root.$on("_businessAcademicOfferingsByData", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.managementParent.id = this.params.data['id'];
    },
    mounted: function () {
        componentThisBusinessAcademicOfferingsDataByInformation = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "title": {required},
            "title_icon": {},
            "description": {required},
            "status": {required},
            "source": {maxLength: Validators.maxLength(350)},
            "allow_source_data": {},
            change: {},

        };
        if (this.model.attributes.allow_source_data) {
            attributes['source'] = {required, maxLength: Validators.maxLength(350)};
        }
        var result = {
            model: {//change
                attributes: attributes
            },
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

                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Servicios",
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
            tabCurrentSelector: '#modal-business-academic-offerings-data-by-information',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-academic-offerings-data-by-information-form",
                url: $('#action-business-academic-offerings-data-by-information-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessAcademicOfferingsDataByInformation.',
                successMessage: 'El BusinessAcademicOfferingsDataByInformation se guardo correctamente.',
                nameModel: "BusinessAcademicOfferingsDataByInformation"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-academic-offerings-data-by-information-grid",
                url: $("#action-business-academic-offerings-data-by-information-getAdmin").val()
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
            managementParent: {
                id: null,
                'keyName': 'business_academic_offerings_by_data_id'
            }
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initDataModal();
            this.initGridManager(this);
            this.$refs.refBusinessAcademicOfferingsDataByInformationModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalBusinessAcademicOfferingsDataByInformation'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refBusinessAcademicOfferingsDataByInformationModal.hide();

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
                this.$refs.refBusinessAcademicOfferingsDataByInformationModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_businessByAcademicOfferings', params);
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
                    url: value["url"]
                };
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
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.title_icon = rowCurrent.title_icon;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.allow_source = rowCurrent.allow_source == 1 ? true : false;
                this.model.attributes.change = false;
                this.model.attributes.title_icon = rowCurrent.title_icon;
                this.model.attributes.allow_source_data = rowCurrent.allow_source == 1 ? true : false;


                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;

            var paramsFilters = {};
            paramsFilters[this.managementParent.keyName] = this.managementParent.id;
            var structure = vmCurrent.model.structure;
            var formatters = {
                'description': function (column, row) {
                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var image = row.allow_source == 1 ? [


                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.source.label + ":</span><img class='content-description__image' src='" + $resourceRoot + row.source + "'>",
                        "</div>",
                    ] : [];
                    image = image.join('');
                    var allow_source_data = row.allow_source == 1 ? [


                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.allow_source_data.label + ":</span><span class='content-description__value'>" + (row.allow_source == 1 ? "SI" : "NO") + "</span>",
                        "</div>",
                    ] : [];
                    allow_source_data = allow_source_data.join('');
                    var result = [
                        "<div class='content-description'>",
                        allow_source_data,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",
                        image,

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
                title: {
                    id: "title",
                    name: "title",
                    label: "Titulo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]

                },
                title_icon: {
                    id: "title_icon",
                    name: "title_icon",
                    label: "Icono Titulo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
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
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                source: {
                    id: "source",
                    name: "source",
                    label: "Imagen",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 350.",
                    },
                },
                allow_source_data: {
                    id: "allow_source_data",
                    name: "allow_source_data",
                    label: "Permitir Imagen",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },


            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "title": null,
                "title_icon": null,
                "description": null,
                "status": "ACTIVE",
                "source": null,
                "allow_source_data": 0,
                "template_news_id_data": null,
                change: false,
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

            var result = {

                "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                "title": this.$v.model.attributes.title.$model,
                "description": this.$v.model.attributes.description.$model,
                "status": this.$v.model.attributes.status.$model,
                "title_icon": 'none',
                "source": this.$v.model.attributes.source.$model,
                "change": this.$v.model.attributes.change.$model,
                "allow_source": this.$v.model.attributes.allow_source_data.$model == null ? 0 : (this.$v.model.attributes.allow_source_data.$model ? 1 : 0),

            };
            result[this.managementParent.keyName] = this.managementParent.id;


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
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': this.uploadConfig.uploadElementsSelectors.image,
                    'selectorPreview': this.uploadConfig.viewUpload.image,
                    'modelCurrent': this.model.attributes,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _uploadDataImage: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.image).click();
            event.stopPropagation();
        },
        _initEventsUpload: function (params) {

            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var _this = this;
            var modelCurrent = _this.model;
            if (modelCurrent.attributes.id) {
                var srcSource = $resourceRoot + modelCurrent.attributes.source;
                $(selectorPreview).attr("src", srcSource);

            }
            var modelAttributeName = params['modelAttributeName'];
            var progress = document.querySelector('.percent');
//------------GESTION DE SUBIDA D IMAGENS---
            $(selectorUpload).change(function () {
                var file = $(this)[0].files[0];
                var srcSourceManager = $.UploadUtil.upload({
                    typeUpload: 'image',
                    generateManager: 'generateImage',
                    'fileElement': $(this)[0].files

                });
                if (srcSourceManager.success) {
                    var srcSource = srcSourceManager.result;
                    $(selectorPreview).attr("src", srcSource);
                    modelCurrent.attributes[modelAttributeName] = file;
                    if (modelCurrent.attributes.id) {
                        modelCurrent.attributes.change = true;

                    }
                }

                return false;
            });


        },
        _initSummerNote: function (params) {
            var elementInit = params['elementInit'];
            var fieldCurrent = $(elementInit).attr('id');
            var $this = this;
            if (this.model.attributes.id) {
                var htmlSet = this.model.attributes[fieldCurrent];
                $(elementInit).html(htmlSet);
            }
            $(elementInit).summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false,              // set focus to editable area after initializing summernote
                callbacks: {
                    onChange: function (contents, $editable) {

                        if ('<p><br></p>' == contents || '' == contents) {
                            $this.$v.model.attributes[fieldCurrent].$model = null;
                        } else {
                            $this.$v.model.attributes[fieldCurrent].$model = contents;
                        }
                    }
                }
            });


        }
    }
})
;




