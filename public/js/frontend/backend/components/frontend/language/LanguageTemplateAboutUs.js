var componentThisLanguageTemplateAboutUs;
Vue.component('language-template-about-us-component', {
    template: '#language-template-about-us-template',
    directives: {
        initS2Language: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Language({
                    objSelector: el, rowId: paramsInput.rowId
                });
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
    },
    props: {
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
        componentThisLanguageTemplateAboutUs = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(200)},
            "state": {required},
            "description": {},
            "subtitle": {maxLength: Validators.maxLength(250)},
            "language_id_data": {required},
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
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Eliminar",
                        "data-placement": "top",
                        "i-class": " fas fa-trash-alt",
                        "managerType": "deleteEntity"
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
                "title": "Administracion Traduccion",
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
            tabCurrentSelector: '#modal-language-template-about-us',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#language-template-about-us-form",
                url: $('#action-language-template-about-us-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el LanguageTemplateAboutUs.',
                successMessage: 'El LanguageTemplateAboutUs se guardo correctamente.',
                nameModel: "LanguageTemplateAboutUs"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#language-template-about-us-grid",
                url: $("#action-language-template-about-us-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {

            this.initDataModal();
            this.initGridManager(this);
            this.$refs.refLanguageTemplateAboutUsModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalLanguageTemplateAboutUs'
            });
        },
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._resetComponent();

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refLanguageTemplateAboutUsModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                this.$refs.refLanguageTemplateAboutUsModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_templateAboutUs', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

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
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
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
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.subtitle = rowCurrent.subtitle;
                this.model.attributes.language_id_data = {id: rowCurrent.language_id, text: rowCurrent.language};
                this._viewManager(3, rowId);
            } else if (params.managerType == "deleteEntity") {
                var rowId = params.id;
                var dataSend = {
                    id: rowId
                };
                $this = this;
                ajaxRequest($('#action-language-template-about-us-setDelete').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $this.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: 'Eliminando....',
                    error_message: 'No se elimino!',
                    success_message: 'Se elimino correctamente.',
                    success_callback: function (response) {

                        if (response.success) {
                            $this._resetManagerGrid();
                            $($this.gridConfig.selectorCurrent).bootgrid("reload");
                        }
                    }
                });
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                template_about_us_id: this.model_id
            };
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    ;var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title '>" + structure.language_id_data.label + ":</span><span class='content-description__value content-description__value--language'>" + row.language + "</span>",

                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.subtitle.label + ":</span><span class='content-description__value'>" + row.subtitle + "</span>",
                        "</div>",
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
                value: {
                    id: "value",
                    name: "value",
                    label: "Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 200.",
                    },
                },
                state: {
                    id: "state",
                    name: "state",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
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
                subtitle: {
                    id: "subtitle",
                    name: "subtitle",
                    label: "Subtitulo",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 250.",
                    },
                },
                language_id_data: {
                    id: "language_id_data",
                    name: "language_id_data",
                    label: "Idioma",
                    required: {
                        allow: true,
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
                "value": null,
                "state": "ACTIVE",
                "description": null,
                "subtitle": null,
                "language_id_data": null,

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
//Manager Model

        getValuesSave: function () {

            var result = {
                LanguageTemplateAboutUs:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "value": this.$v.model.attributes.value.$model,
                        "state": this.$v.model.attributes.state.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "subtitle": this.$v.model.attributes.subtitle.$model,
                        "language_id": this.$v.model.attributes.language_id_data.$model.id,
                        "template_about_us_id": this.model_id

                    }
            };

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $this = this;
            $this.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                $this.submitStatus = 'error';

            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $this.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: $this.formConfig.loadingMessage,
                    error_message: $this.formConfig.errorMessage,
                    success_message: $this.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            $this._resetManagerGrid();
                            $this.resetForm();
                            $($this.gridConfig.selectorCurrent).bootgrid("reload");
                            $this._viewManager(2);
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
//others functions
        _managerS2Language: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.language_id_data];
                var textCurrent = dataCurrent[0].text;
                var idCurrent = dataCurrent[0].id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-language-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        console.log('init data');
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        console.log('init processResults');

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.language_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.language_id_data = null;
                _this._setValueForm('language_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
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
                            $this.model.attributes[fieldCurrent] = null;
                        } else {
                            $this.model.attributes[fieldCurrent] = contents;
                        }
                    }
                }
            });


        }

    }
})
;




