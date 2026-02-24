<script>
    function destroyS2($el) {
        if ($el.data('select2')) $el.select2('destroy');
        $el.empty();
    }

    var appInit = new Vue(
        {
            beforeMount: function () {
                this.configDataRegisterForm.filters = this.getDatSendChildren();
                this.configDataRegisterForm.view_type = -1;
            },
            mounted: function () {

                this.initCurrentComponent();
                appThis = this;

            },
            directives: {
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
            watch: {},
            el: '#app-management',
            created: function () {

                this.$root.$on("app-management", function (emitValue) {
                    console.log("app-management", emitValue)
                    if (emitValue.componentName == "register-form") {
                        if (emitValue.type == "onReturnMain") {
                            this.onReturnMain();
                        }
                    }
                });

            },
            data: {
                formLabels: $dataManagerPage.formLanguageManagement,
                //MENU
                menuCurrent: [],
                managerProcessCurrent: {
                    type: 0
                },
                model: {
                    attributes: null,
                    structure: null,
                },

                configDataRegisterForm: {view_type: -9, data: null, filters: null},

                managerCurrentBusiness: {
                    time: {
                        hour: null, date: null,
                    },
                    maritimeInformation: {
                        allowView: false,
                        name: '',
                        business_id: null,
                        source: null,
                        maritime_vessel_id: null,

                    },
                    responsible: {
                        fullName: '',
                        document: '',

                    },

                },
                dataTypeDictionary: [{
                    id: 1, text: 'Kichwa - Castellano'
                },
                    {
                        id: 2, text: 'Castellano - Kichwa'
                    }
                ],
                modelFilters: {
                    typeDictionary: 1
                },

            },
            methods: {
                onSetValuesForm: function (type, value) {

                    this.sendDataChildren({
                        type:"rebootGrid",
                        "nameChild": 'grid-registers',
                        "data": this.modelFilters
                    });


                },
                ...$methodsFormValid,
                ...$methodsProcessCurrent,
                /*FORM*/
                onReturnMain: function () {
                    this.configDataRegisterForm.view_type = -1;
                    this.configDataRegisterForm.data = null;


                },
                initCurrentComponent: function () {

                }, initManagement: function () {
                    console.log("init app");
                },
                viewSelectInformation: function () {
                    this.managerCurrentBusiness.allowView = true;
                },
                /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                _updateParentByChildren: function (params) {
                    console.log(params);
                    if (params.child == "grid-registers") {
                        var dataCurrent = params.data;
                        var dataSend = null;
                        if (params.action == "managementUpdate") {
                            dataSend = {
                                id: dataCurrent.id,
                                status: dataCurrent.status,
                                translation_value: dataCurrent.translation_value,
                                usage_context: dataCurrent.usage_context,
                                value: dataCurrent.value,
                                description: dataCurrent.description,
                                diccionary_language_id: dataCurrent.diccionary_language_id,
                                letters_of_the_alphabet: dataCurrent.letters_of_the_alphabet,
                                dictionary_grammatical_class_id: dataCurrent.dictionary_grammatical_class_id,
                                dictionary_grammatical_class_name: dataCurrent.dictionary_grammatical_class_name,
                                audios: dataCurrent.audios,
                                pronunciations: dataCurrent.pronunciations,

                            };
                            this.configDataRegisterForm.data = dataSend;

                            this.configDataRegisterForm.view_type = 1;

                        }


                    }

                },
                getDatSendChildren: function () {
                    console.log("getDatSendChildren");
                    return {
                        dataTypeDictionary: this.dataTypeDictionary,
                        modelFilters: this.modelFilters
                    };
                },
                createRegisterForm: function () {
                    this.configDataRegisterForm.view_type = 0;


                },
                veRegisterForm: function () {
                    console.log("onSaveRegisterForm")
                    this.sendDataChildren({
                        "nameChild": 'grid-registers',
                        "data": {dat: 1}
                    });
                },
                sendDataChildren: function (params) {
                    var nameChild = params["nameChild"];
                    this.$root.$emit(nameChild, params);
                },

                _managementVesselList: function (params) {
                    var el = params.objSelector;
                    var dataSelect = this.managerCurrentBusiness.dataSelect;
                    var valueCurrentRowId = null;
                    if (dataSelect) {
                        valueCurrentRowId = this.managerCurrentBusiness.dataSelect.id;
                    }
                    var dataCurrent = [];
                    var $el = $(el);
                    destroyS2($el);
                    if (valueCurrentRowId) {
                        dataCurrent = dataSelect;
                        var textCurrent = dataCurrent.text;
                        var idCurrent = dataCurrent.id;
                        var option = new Option(textCurrent, idCurrent, true, true);
                        $(el).append(option).trigger('change');
                    }
                    var _this = this;
                    var elementInit = $(el).select2({
                        allow: true,
                        placeholder: "Seleccione la Embarcaciòn",
                        data: dataCurrent,
                        ajax: {
                            url: $("#action-management-business-by-vessel").val(),
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
                        console.log("select", data);
                        _this.setDataManagerMaritime(data);

                    }).on("select2:unselecting", function (e) {
                        console.log("null");
                        _this.setDataManagerMaritime(null);
                    }).on("select2:open", function (e) {
                        console.log("abierto");

                    });
                },


                _managementProcess: function (type) {
                    this.managerProcessCurrent.type = type;
                    var vCurrent = this;

                },

                // --- helpers fechas ---
                formatToday: function () {
                    var d = new Date();
                    return this.formatDateYYYYMMDD(d);
                },

                formatDateYYYYMMDD: function (d) {
                    var y = d.getFullYear();
                    var m = String(d.getMonth() + 1).padStart(2, '0');
                    var day = String(d.getDate()).padStart(2, '0');
                    return `${y}-${m}-${day}`;
                },

                // parse local: YYYY-MM-DD -> Date (sin UTC)
                parseDateLocal: function (yyyy_mm_dd) {
                    if (!yyyy_mm_dd || !/^\d{4}-\d{2}-\d{2}$/.test(yyyy_mm_dd)) return null;
                    const [y, m, d] = yyyy_mm_dd.split('-').map(Number);
                    return new Date(y, m - 1, d, 0, 0, 0);
                },
            }
        })
    ;
    appInit.initManagement();

</script>
