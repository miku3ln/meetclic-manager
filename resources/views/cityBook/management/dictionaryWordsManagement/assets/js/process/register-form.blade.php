<script>

    var registerFormComponent = null;
    Vue.component('register-form-component', {
        components: {},
        template: '#register-form-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
                    });

                },
            },
            initS2Manager: {
                inserted: function (el, binding, vnode) {
                    var paramsInput = binding.value || {};
                    var ctx = vnode.context;

                    // espera a que el DOM esté estable
                    ctx.$nextTick(function () {
                        // evita doble init si el nodo se reusa
                        var $el = $(el);
                        if ($el.hasClass("select2-hidden-accessible")) {
                            $el.select2("destroy");
                        }

                        if (typeof paramsInput._initS2Manager === "function") {
                            paramsInput._initS2Manager({
                                objSelector: el,
                                rowId: paramsInput.rowId
                            });
                        } else {
                            console.warn("initS2Manager: _initS2Manager no es función", paramsInput);
                        }
                    });
                },

                unbind: function (el) {
                    var $el = $(el);
                    if ($el.hasClass("select2-hidden-accessible")) {
                        $el.select2("destroy");
                    }
                }
            }
        },
        props: {
            params: {
                type: Object,
            }
        },
        created: function () {
            var vmCurrent = this;
            this.$root.$on("_pointsSales", function (emitValue) {
                vmCurrent._managerTypes(emitValue);
            });

            registerFormComponent = this;
        },
        beforeMount: function () {

            if (
                this.params?.data &&
                this.params.data.id > -1 &&
                Array.isArray(this.params.data.audios)
            ) {
                this.uploadConfigPronunciation.existingFiles = this.getDataExistingFiles({
                    haystack: this.params.data.audios
                });
            }

            this.managerCurrentParamsParent = this.params.data;
        },
        mounted: function () {
            componentThisEventsTrailsProject = this;

            this.managerCurrentParamsParent = this.params.data;

        },
        beforeDestroy: function () {

        },
        computed: {},
        validations: function () {
            var attributes = null;

            attributes = {
                id: {},
                value: {required},
                description: {required},
                status: {required},
                translation_value: {required},
                usage_context: {required},
                dictionary_grammatical_class_data_id: {required},


            };

            var result = {
                model: {//change
                    attributes: attributes
                },
            };
            return result;

        },
        data: function () {
            const csrf = $('meta[name="csrf-token"]').attr('content');
            var dataManager = {
                formConfig: {
                    nameSelector: "#business-by-lodging-form",
                    url: $('#action-management-save').val(),
                    loadingMessage: 'Guardando...',
                    errorMessage: 'Error al guardar el ' + this.processName,
                    successMessage: 'La tarjeta de registro se guardo correctamente.',
                    nameModel: "Lodging"
                },
                labelsConfig: {},
                lblBtnSave: "Guardar",
                lblBtnClose: "Cerrar",
                rowId: null,
                model: {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm(),
                },
                managerCurrentParamsParent: null,
                clockIntervalId: null,

                showManager: true,
                managerType: null,
                rowCurrent: null,
                allowReload: false,
                uploadConfigPronunciation: {
                    baseUrl: $resourceManagementRoot,
                    nameKey: 'pronunciation_files_ids',
                    label: 'Pronunciación',
                    uploadUrl: $("#action-management-dictionaryPronunciationUpload").val(),
                    deleteUrl: $("#action-management-dictionaryPronunciationDelete").val(),
                    downloadBaseUrl: '/api/pronunciation/download/:id', // opcional
                    headers: {'X-CSRF-TOKEN': csrf},
                    existingFiles: [],
                    multiple: true,
                    accept: 'audio/*',
                    maxFiles: 1,
                    maxMb: 50,
                    fieldName: 'files[]',
                    extraData: () => this.extractDataMultimedia(),
                    onUploaded: (uploaded, res) => this.saveRegistersPronunciation(uploaded, res),
                    onDeleted: (file, res) => this.deleteRegisterPronunciation(file, res),
                }
            };

            return dataManager;
        },
        watch: {},

        methods: {
            getDataExistingFiles: function (params) {
                var haystack = params["haystack"] || [];
                var result = [];

                $.each(haystack, function (key, value) {

                    // description viene como STRING → hay que parsear
                    let meta = {};
                    try {
                        meta = JSON.parse(value.description || '{}');
                    } catch (e) {
                        console.warn('Error parseando description', value.description);
                    }

                    result.push({
                        id: value.id,
                        name: meta.original_name || value.value,
                        url: meta.url || value.source,
                        mime: meta.mime || '',
                        size: meta.size || 0
                    });

                });

                return result;
            },
            extractDataMultimedia() {
                var word_id = -1;
                if (this.params.data) {
                    word_id = this.params.data.id == -1 ? -1 : this.params.data.id;
                }
                if (this.rowId) {
                    word_id = this.rowId;
                }
                return {
                    dictionary_by_words_id: word_id,
                    group: 'pronunciation',

                };
            },

            saveRegistersPronunciation(uploaded, res) {
                console.log('uploaded:', uploaded);
                console.log('server response:', res);

                // ejemplo: si backend te devuelve data.word_id
                if (res?.data?.word_id) {
                    this.word_id = res.data.word_id;
                }
            },

            deleteRegisterPronunciation(file, res) {
                console.log('deleted file:', file);
                console.log('server response:', res);
            },
            ...$methodsFormValid,
            getLabelForm: viewGetLabelForm,
            getNameAttribute: getNameAttribute,
            getStructureForm: function () {
                var result = {
                    "status": {
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

                    dictionary_grammatical_class_data_id: {
                        id: "dictionary_grammatical_class_data_id",
                        name: "dictionary_grammatical_class_data_id",
                        label: "Clases Gramaticales",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },

                    value: {
                        id: "value",
                        name: "value",
                        label: "Palabra",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    description: {
                        id: "description",
                        name: "description",
                        label: "Descripcion",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    usage_context: {
                        id: "usage_context",
                        name: "usage_context",
                        label: "Contexto Uso",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    translation_value: {
                        id: "translation_value",
                        name: "translation_value",
                        label: "Traduccion",
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
            getDataGramaticalClass: function () {
                var dictionary_grammatical_class_id = this.params.data.dictionary_grammatical_class_id.split(",");
                var dictionary_grammatical_class_name = this.params.data.dictionary_grammatical_class_name.split(",");
                var dictionary_grammatical_class_data_id = [];
                $.each(dictionary_grammatical_class_id, function (key, value) {
                    var setPush = {
                        id: value,
                        text: dictionary_grammatical_class_name[key]
                    };
                    dictionary_grammatical_class_data_id.push(setPush);
                });
                var result = {
                    dictionary_grammatical_class_data_id: dictionary_grammatical_class_data_id,
                    dictionary_grammatical_class_id: dictionary_grammatical_class_id,
                    dictionary_grammatical_class_name: dictionary_grammatical_class_name
                };
                return result;
            },
            getAttributesForm: function () {
                var result = null;
                if (this.params.data) {
                    console.log("this.params.data", this.params.data)
                    var resultClassList = this.getDataGramaticalClass();
                    result = {
                        ...this.params.data,
                        dictionary_grammatical_class_data_id: resultClassList.dictionary_grammatical_class_data_id
                    };
                } else {
                    result = {
                        id: null,
                        value: null,
                        description: null,
                        status: 'ACTIVE',
                        translation_value: null,
                        usage_context: null,
                        dictionary_grammatical_class_data_id: null,
                    };
                }


                return result;
            },
            validateForm: function () {
                var currentAllow = this.getValidateForm();
                return currentAllow.success;
            },

            getValidateForm: function () {
                var result = getValidateForm({"model": this.$v.model});
                return result;
            },
            getValuesSave: function () {

                var result = {
                    DictionaryByWords: {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        value: this.$v.model.attributes.value.$model,
                        description: this.$v.model.attributes.description.$model,
                        status: this.$v.model.attributes.status.$model,
                        diccionary_language_id: 1,
                        translation_value: this.$v.model.attributes.translation_value.$model,
                        phonetic: "none",
                        usage_context: this.$v.model.attributes.usage_context.$model,
                        dictionary_grammatical_class_data_id: this.$v.model.attributes.dictionary_grammatical_class_data_id.$model,


                    },

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
                    ajaxRequestManager(this.formConfig.url, {
                        type: 'POST',
                        data: dataSend,
                        blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                        loading_message: vCurrent.formConfig.loadingMessage,
                        error_message: vCurrent.formConfig.errorMessage,
                        success_message: vCurrent.formConfig.successMessage,
                        success_callback: function (response) {
                            if (response.success) {

                                vCurrent.setSaveWord(response);
                            }
                        }
                    });
                }
            },
            setSaveWord: function (response) {
                console.log(response);
                if (response.success) {
                    var data=response.data;
                    this.rowId = data.id;
                    this.$v.model.attributes.id.$model = data.id;
                }
            },
            onReturnMain: function () {
                this._emitToParent({
                    type: 'onReturnMain',
                    'componentName': 'register-form'
                });
            },
            _setValueForm: async function (name, value) {
                // ✅ Fields fuera de people
                this.model.attributes[name] = value;
                this.$v["model"]["attributes"][name].$model = value;
                this.$v["model"]["attributes"][name].$touch();
            },
            getNameAttributePeople: function (index, name) {
                var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
                return result;
            },
            getClassErrorForm: getClassErrorForm,
            getViewErrorForm: function (nameElement, objValidate) {
                let resultValidate = getClassErrorForm(nameElement, objValidate);
                let result = resultValidate["form-group--error"];
                return result;
            },

            resetForm: function () {
                if (this.managerCurrentParamsParent) {

                } else {
                    this.$v.$reset();
                    this.model = {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm()
                    };
                    this.model.attributes.id = null;
                }


            },
            _submitForm: function (e) {
                console.log(e);
            },
            getDataByKey: function (params) {
                let result = null;
                var nameKey = params["nameKey"];
                if (!this.params.data) {
                    return result;

                }
                result = this.params.data[nameKey];

                return result;
            },
            initS2GramaticalClass: function (params) {
                var nameKey = "dictionary_grammatical_class_data_id";
                var el = params.objSelector;
                var dataSelect = this.getDataByKey({nameKey: "dictionary_grammatical_class_id"});
                var valueCurrentRowId = null;
                var dataCurrent = [];
                if (dataSelect) {
                    valueCurrentRowId = true;
                    var resultClassList = this.getDataGramaticalClass();
                    dataCurrent = resultClassList.dictionary_grammatical_class_data_id;
                    this._setValueForm(nameKey, resultClassList.dictionary_grammatical_class_id);

                }

                var $el = $(el);
                destroyS2($el);
                if (valueCurrentRowId) {
                    $el.prop('multiple', true); // 🔥 clave

                    dataCurrent.forEach(item => {
                        // evita duplicados
                        if ($el.find(`option[value="${item.id}"]`).length === 0) {
                            $el.append(new Option(item.text, item.id, false, false));
                        }
                    });

                    const ids = dataCurrent.map(x => String(x.id)); // ids como string
                    $el.val(ids).trigger('change'); // ✅ selecciona todos

                }
                var _this = this;
                var elementInit = $el.select2({
                    allow: true,
                    placeholder: "Seleccione Clases Gramaticales",
                    data: dataCurrent,
                    ajax: {
                        url: $("#action-management-grammaticalClassList").val(),
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
                    allowClear: false,
                    multiple: true,
                    width: '100%'
                });

                elementInit.on('select2:select', function (e) {
                    var selectedData = $(this).select2('data');


                    console.log('selectedData', selectedData);
                    var ids = selectedData.map(x => x.id);
                    _this._setValueForm(nameKey, ids);


                }).on("select2:unselecting", function (e) {
                    _this._setValueForm(nameKey, null);

                }).on("select2:open", function (e) {


                });
            },

            //MODAL
            _showModal: function () {
                this.resetForm();

            },
            _hideModal: function () {
                this._resetComponent();

            },

            _resetComponent: function () {
                this._emitToParent({
                    type: 'resetComponent',
                    'componentName': 'register-form',
                    allowReload: this.allowReload
                });
            },
            _emitToParent: function (params) {
                this.$root.$emit('app-management', params);
            },
            _saveModal: function (bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler
                this.handleSubmit();
            },
            _cancel: function () {
                this.$refs.modalRegisterForm.hide();

            },

        }
    })

</script>
