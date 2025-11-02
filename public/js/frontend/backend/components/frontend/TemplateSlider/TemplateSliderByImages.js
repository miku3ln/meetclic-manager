var componentThisTemplateSliderByImages;
Vue.component('template-slider-by-images-component', {
    directives: {
        initEventUploads: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);

            }
        }
    },
    template: '#template-slider-by-images-template'
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        var $this = this;
        this.$root.$on("_templateSliderByImages", function (emitValue) {
            $this._managerTypes(emitValue);
        });

    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisTemplateSliderByImages = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "source": { required, maxLength: Validators.maxLength(350) },
            "title": {},
            "subtitle": {},
            "options_title": {},
            "button_name": { },
            "options_button": {},
            "button_link_manager": {},
            "options_subtitle": {},
            "options_all": {},
            "options_source": {},
            "status": { required },
            "position": { required },
            "type_button": { required },
            "type_multimedia": { required },
            change: {},
        };

        if (this.model.attributes.type_multimedia == 1) {
            attributes['title'] = { required };
            attributes['subtitle'] = { required };

        }
        if (this.model.attributes.type_button) {

            attributes['button_link_manager'] = { required };
            attributes['button_name'] = {  required, maxLength: Validators.maxLength(45) };

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
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    }, {
                        "title": "Traducción Administración",
                        "data-placement": "top",
                        "i-class": " fa fa-language",
                        "managerType": "languageEntity"
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
                "title": "Administracion  de Galeria",
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
            tabCurrentSelector: '#modal-template-slider-by-images',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#modal-template-slider-by-images",
                url: getUrlSaveSliderImages(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el TemplateSliderByImages.',
                successMessage: 'El TemplateSliderByImages se guardo correctamente.',
                nameModel: "TemplateSliderByImages"
            },
            //Grid config
            gridConfig: {
                selectorCurrent: "#template-slider-by-images-grid",
                url: getUrlAdminSliderImages()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            model_id: null,
            rowCurrent: null,
            configModalLanguageTemplateSliderByImages: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {

            this.initDataModal();
            this.initGridManager(this);
            this.$refs.refTemplateSliderByImagesModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalTemplateSliderByImages'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler

        },
        _cancel: function () {
            this.$refs.refTemplateSliderByImagesModal.hide();

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
                this.$refs.refTemplateSliderByImagesModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_templateSlider', params);
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
            var params = { managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData };
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
                };
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function (selectorSelect) {
            var vmCurrent = this;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: selectorSelect,

            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var selectorDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(selectorDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.position = parseInt(rowCurrent.position);

                this.model.attributes.change = false;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.subtitle = rowCurrent.subtitle;
                this.model.attributes.options_title = rowCurrent.options_title;
                this.model.attributes.button_name = rowCurrent.button_name;
                this.model.attributes.options_button = rowCurrent.options_button;
                this.model.attributes.options_subtitle = rowCurrent.options_subtitle;
                this.model.attributes.options_all = rowCurrent.options_all;
                this.model.attributes.options_source = rowCurrent.options_all;
                this.model.attributes.type_button = rowCurrent.type_button;
                if (this.model.attributes.type_button) {
                    var options_button = JSON.parse(this.model.attributes.options_button);
                    this.model.attributes.button_link_manager = options_button['data'][0]['link'];
                }
                this.model.attributes.type_multimedia = rowCurrent.type_multimedia;

                this._viewManager(3, rowId);
            } else if (params.managerType == 'languageEntity') {
                this.configModalLanguageTemplateSliderByImages.data = rowCurrent;
                if (this.configModalLanguageTemplateSliderByImages.viewAllow) {
                    this.$refs.refLanguageTemplateServices._setValueOfParent(
                        { type: "openModal", data: this.configModalLanguageTemplateSliderByImages }
                    );
                } else {
                    this.configModalLanguageTemplateSliderByImages.viewAllow = true;
                }
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                template_slider_id: this.model_id
            };
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {
                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var descriptionBackground = row.type_multimedia == 1 ? ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.subtitle.label + ":</span><span class='content-description__value'>" + row.subtitle + "</span>",
                        "</div>"] : [];
                    descriptionBackground = descriptionBackground.join('');
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.source.label + ":</span><img class='content-description__image' src='" + $resourceRoot + row.source + "'>",
                        "</div>",
                        descriptionBackground,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.position.label + ":</span><span class='content-description__value'>" + row.position + "</span>",
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
                source: {
                    id: "source",
                    name: "source",
                    label: "Imagen",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 350.",
                    },
                },
                position: {
                    id: "position",
                    name: "position",
                    label: "Posicion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 350.",
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
                    options: [{ "value": "ACTIVE", "text": "ACTIVE" }, { "value": "INACTIVE", "text": "INACTIVE" }]
                },
                title: {
                    id: "title",
                    name: "title",
                    label: "Titulo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                subtitle: {
                    id: "subtitle",
                    name: "subtitle",
                    label: "Subtitulo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_title: {
                    id: "options_title",
                    name: "options_title",
                    label: "Opciones Titulo",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                button_name: {
                    id: "button_name",
                    name: "button_name",
                    label: "Boton Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 45.",
                    },
                },
                button_link_manager: {
                    id: "button_link_manager",
                    name: "button_link_manager",
                    label: "Link",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }

                },
                options_button: {
                    id: "options_button",
                    name: "options_button",
                    label: "Opciones Boton",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_subtitle: {
                    id: "options_subtitle",
                    name: "options_subtitle",
                    label: "Opciones Subtitulo",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_all: {
                    id: "options_all",
                    name: "options_all",
                    label: "Opciones Fade",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_source: {
                    id: "options_source",
                    name: "options_source",
                    label: "Opciones Imagen",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                type_button: {
                    id: "type_button",
                    name: "type_button",
                    label: "Gestionar Botones",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{ "value": 1, "text": "SI" }, { "value": 0, "text": "NO" }]

                },
                type_multimedia: {
                    id: "type_multimedia",
                    name: "type_multimedia",
                    label: "Tipo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{ "value": 0, "text": "Background" }, { "value": 1, "text": "Background y Texto" }]

                },

            };
            return result;
        },
        getAttributesForm: function () {
            var options_all = [
                'data-transition="slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical"',
                'data-slotamount="default,default,default,default" data-hideafterloop="0" data-hideslideonmobile="off"',
                'data-easein="default,default,default,default" data-easeout="default,default,default,default"',
                'data-masterspeed="1010,default,default,default" data-thumb="" data-delay="7010" data-rotate="0,0,0,0"',
                'data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""',
                'data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""',
                'data-param10="" data-description=""'
            ];
            options_all = options_all.join('');

            var options_button = [
            ];
            options_button = options_button.join('');

            var options_subtitle = [
                'class="tp-caption   tp-resizeme"',
                'data-x="[\'center\',\'center\',\'center\',\'center\']" data-hoffset="[\'0\',\'3\',\'5\',\'0\']"',
                ' data-y="[\'top\',\'top\',\'top\',\'top\']" data-voffset="[\'230\',\'260\',\'339\',\'228\']" data-width="none"',
                'data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"',
                'data-frames=\'[{"delay":610,"speed":1500,"frame":"0","from":"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;","mask":"x:[100%];y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]\'',
                'data-textAlign="[\'inherit\',\'inherit\',\'inherit\',\'inherit\']" data-paddingtop="[0,0,0,0]"',
                'data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"',
                'style="z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;"'

            ];
            options_subtitle = options_subtitle.join('');


            var options_title = [
                'class="tp-caption   tp-resizeme"',
                'data-x="[\'center\',\'center\',\'center\',\'center\']" data-hoffset="[\'1\',\'1\',\'10\',\'-3\']"',
                ' data-y="[\'top\',\'middle\',\'middle\',\'middle\']" data-voffset="[\'279\',\'0\',\'-22\',\'-25\']"',
                'data-fontsize="[\'90\',\'90\',\'90\',\'60\']" data-lineheight="[\'110\',\'100\',\'100\',\'70\']" data-width="none"',
                ' data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"',
                ' data-frames=\'[{"delay":610,"split":"chars","splitdelay":0.05,"speed":1850,"split_direction":"forward","frame":"0","from":"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"}]\'',
                'data-textAlign="[\'inherit\',\'inherit\',\'inherit\',\'inherit\']" data-paddingtop="[0,0,0,0]"',
                'data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"',
                ' style="z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;"'
            ];
            options_title = options_title.join('');

            var options_source = [
                'data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg"',
                'data-no-retina'
            ];
            var button_name = 'not-button';
            var type_button = 0;
            var type_multimedia = 0;
            var button_link_manager = null;
            options_source = options_source.join('');
            var result = {
                "id": null,
                "source": null,
                "status": 'ACTIVE',
                "position": 0,
                change: false,
                "title": 'only-background',
                "subtitle": 'only-background',
                "options_title": options_title,
                "button_name": button_name,
                "options_button": options_button,
                "options_subtitle": options_subtitle,
                "options_all": options_all,
                "options_source": options_source,
                "type_button": type_button,
                type_multimedia: type_multimedia,
                button_link_manager: button_link_manager,


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
            var dataButtons = [


            ];
            buttonOne = {
                'name': this.$v.model.attributes.button_name.$model,
                link: this.$v.model.attributes.button_link_manager.$model
            };
            dataButtons.push(buttonOne);
            var options_buttons =
            {
                'data': dataButtons
            }
                ;
            options_buttons = JSON.stringify(options_buttons);
            var result = {

                "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                "source": this.$v.model.attributes.source.$model,
                "position": this.$v.model.attributes.position.$model,
                "status": this.$v.model.attributes.status.$model,
                "template_slider_id": this.model_id,
                "title": this.$v.model.attributes.title.$model,
                "subtitle": this.$v.model.attributes.subtitle.$model,
                "options_title": this.$v.model.attributes.options_title.$model,
                "button_name": this.$v.model.attributes.button_name.$model,
                "options_button": options_buttons,
                "options_subtitle": this.$v.model.attributes.options_subtitle.$model,
                "options_all": this.$v.model.attributes.options_all.$model,
                "options_source": this.$v.model.attributes.options_source.$model,
                change: this.$v.model.attributes.change.$model,
                type_button: this.$v.model.attributes.type_button.$model,
                type_multimedia: this.$v.model.attributes.type_multimedia.$model,
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
                    blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el selectoro
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
            var modelCurrent = params['modelCurrent'];

            var result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _uploadDataImage: function (eventSelector) {
            var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
                toElement: eventSelector.toElement
            });
            selectorFile = '#file-' + selectorFile;
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
        _initEventsUpload: function (params) {

            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];

            $.UploadUtil.managerUploadModel(params);


        }
    }
});


function getUrlAdminSliderImages() {
    $typeManager = $configPartial['typeManager'];
    $result = $("#action-template-slider-by-images-getAdmin").val();
    if ($typeManager == "managerActivitiesGamification") {
        $result = $("#action-template-slider-by-images-getAdminActivitiesGamification").val();

    } else if ($typeManager == "managerRewardsGamification") {
        $result = $("#action-template-slider-by-images-getAdminRewardsGamification").val();

    }
    return $result;
}

function getUrlSaveSliderImages() {
    $typeManager = $configPartial['typeManager'];
    $result = $('#action-template-slider-by-images-saveData').val();
    if ($typeManager == "managerActivitiesGamification") {
        $result = $('#action-template-slider-by-images-saveDataActivitiesGamification').val();

    } else if ($typeManager == "managerRewardsGamification") {
        $result = $('#action-template-slider-by-images-saveDataRewardsGamification').val();

    }
    return $result;
}
