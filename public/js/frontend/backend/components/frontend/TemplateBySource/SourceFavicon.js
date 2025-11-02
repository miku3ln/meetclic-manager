var componentThisSourceFavicon;
var emptyManagerImage = 'https://image.shutterstock.com/image-vector/picture-vector-icon-no-image-260nw-1350441335.jpg';
Vue.component('source-favicon-component', {
    template: '#source-favicon-template',
    directives: {
        initEventUpload: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.initCurrentComponent();
    },
    mounted: function () {
        componentThisSourceFavicon = this;


    },
    validations: function () {
        var attributes = {
            "id": {},
            "source": {maxLength: Validators.maxLength(250)},
            "source_type": {},
            change: {},
            value: {},

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
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#source-favicon-manager',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#source-favicon-form",
                url: $('#action-template-by-source-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar Imagen.',
                successMessage: 'Se guardo correctamente.',
                nameModel: "TemplateBySource"
            },
            model_id: null,
            rowCurrent: null,
            source_type: 1,
            value: 'Favicon',
            typeName: 'favicon',
            business_id: null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            var dataImages = this.configParams.data;//all images
            var filters = this.configParams.filters;//all images
            var rowCurrent = dataImages['favicon'];
            if (rowCurrent) {
                var attributes = {
                    "id": rowCurrent.id,
                    "source": rowCurrent.source,
                    "source_type": rowCurrent.source_type,
                    "value": rowCurrent.value,
                    change: false,
                };
                this.model.attributes = attributes;
            }
            this.model_id = filters.model_id;
            this.business_id = filters.business_id;

            this.rowCurrent = rowCurrent;

        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

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
                    label: "Favicon ",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]

                },
                source_type: {
                    id: "source_type",
                    name: "source_type",
                    label: "Tipo/Ubicacion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                value: {
                    id: "value",
                    name: "value",
                    label: "Titulo",
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
                "source": null,
                "source_type": 1,
                "value": null,
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
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model

        getValuesSave: function () {

            var result = {

                "id": this.model.attributes.id ? this.model.attributes.id : -1,
                "source": this.model.attributes.source,
                "source_type": this.source_type,
                "value": this.value,
                "change": this.model.attributes.change,
                "template_information_id": this.model_id,
                business_id: this.business_id
            };
            return result;
        },
        _saveModel: function () {
            var updateCreate = this.$v.model.attributes.id.$model ? true : false;

            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                alert('Error en el formulario.');

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
                            var attributes = response.data.attributes;
                            vCurrent.resetForm();
                            vCurrent.model.attributes = attributes;
                            vCurrent.model.attributes.change = false;
                            var elementCurrent = vCurrent.getIdManagerUploads(0);
                            $("#" + elementCurrent).attr('src',  $resourceRoot+attributes.source)
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

        getValidateForm:getValidateForm,
//others functions
        _managerEventsUpload: function (params) {
            var $this = this;
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            if (modelCurrent.attributes.id) {
                var srcSource = $resourceRoot+ modelCurrent.attributes.source;
                $(selectorPreview).attr("src", srcSource);
            } else {
                var srcSource = emptyManagerImage;
                $(selectorPreview).attr("src", srcSource);
            }
            var modelAttributeName = params['modelAttributeName'];
            $(selectorUpload).change(function () {
                var file = $(this)[0].files[0];

                var srcSourceManager = $.UploadUtil.upload({
                    typeUpload: 'image',
                    generateManager: 'generateIcon',
                    'fileElement': $(this)[0].files

                });

                if (srcSourceManager.success) {
                    var srcSource = srcSourceManager.result;
                    $(selectorPreview).attr("src", srcSource);
                    $this.model.attributes[modelAttributeName] = file;
                    if ($this.model.attributes.id) {
                        $this.model.attributes.change = true;

                    }
                    $this._saveModel();
                }

                return false;
            });


        },
        //uploads methods
        _uploadDataImage: function (eventSelector) {

            var selectorFile = '#file-' + 'source' + '-' + this.typeName;
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var modelCurrent = params['modelCurrent'];

            var result = {
                'selectorUpload': '#file-' + nameField + '-' + this.typeName,
                'selectorPreview': '#preview-' + nameField + '-' + this.typeName,
                'modelCurrent': modelCurrent,
                'modelAttributeName': nameField,
            };

            return result;
        },
        getIdManagerUploads: function (type) {
            var result = '';
            if (type == 0) {//preview
                result = 'preview-source-' + this.typeName;
            } else if (type == 1) {//input file
                result = 'file-source-' + this.typeName;
            } else if (type == 2) {//manager upload progress
                result = 'progress-source-' + this.typeName;
            }
            return result;
        }

    }
})
;




