var componentThisGamificationByProcess;
var footerGrid =
    "<div id='data-pagination'  id=\"{{ctx.id}}\" class=\"{{css.footer}}\">\n\
        <div class='col-md-6'>\n\
            <div  class='pagination'>\n\
                <p class=\"{{css.pagination}}\"></p>\n\
            </div>\n\
        </div>\n\
        <div class=\"col-md-6 infoBar\">\n\
            <p class=\"{{css.infos}}\"></p>\n\
        </div>\n\
</div>";

var emptyData = [null, undefined, '', ""];
Vue.component('gamification-by-process-component', {
    template: '#gamification-by-process-template',
    directives: {
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2GamificationTypeActivity: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2GamificationTypeActivity({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2Manager: {
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
        },
        initS2Entity: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.functionCurrent({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initQR: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var dataQr = paramsInput['dataQr'];
                renderQR(dataQr);

            }
        }
    }, props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;

    },
    beforeMount: function () {
        this.configParams = this.params;
        var modelCurrentBusiness = $modelDataManager["business"][0];
        this.business_id = modelCurrentBusiness['id'];
    },
    mounted: function () {
        componentThisGamificationByProcess = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var integerManager=Validators.integer;
        var attributes = {
            "id": {}, "change": {},
            "source": {required},
            "title": {required},
            "subtitle": {},
            "description": {required},
            "unique_code": {required},
            "state": {required},
            "execution_channel": {required},

            "has_source": {},
            "entity": {},
            "entity_id": {},
            "entity_id_data": {},
            "url_manager": {},
            "url_manager_data": {},

            "gamification_type_activity_id_data": {required},
            "tracking_type_id_data": {required},
            "tracking_source_id_data": {required},
            "campaign_code_template": {required},
            "is_url": {},
            "type_manager": {},
            "points": {required , integerManager,
                minValue: minValue(0)},
            gamification_by_points_id: {},

            vigencia: {
                required
            },
            valid_from: {},
            valid_until: {},
            frequency_limit_type: {},
            frequency_limit_value: {},
        };
        if (this.model.attributes.has_source) {
            attributes['source'] = {required};
        }
        if (this.model.attributes.is_url) {
            attributes['url_manager'] = {required};
            attributes['url_manager_data'] = {required};

        }
        if (this.model.attributes.entity == 1) {
            attributes['entity_id_data'] = {required};

        }

        if (this.model.attributes.vigencia) {
            attributes['valid_until'] = {required};
            attributes['valid_from'] = {required};

        }
        if (this.model.attributes.frequency_limit_type == 'TOTAL_LIMIT') {
            attributes['frequency_limit_value'] = {
                required,
                minValue: Validators.minValue(0)
            };


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
            manager_id: null,
            manager_key_name: 'gamification_id',
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
            tabCurrentSelector: '.modal-dialog',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#gamification-by-process-form",
                url: $('#action-gamification-by-process-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el GamificationByProcess.',
                successMessage: 'El GamificationByProcess se guardo correctamente.',
                nameModel: "GamificationByProcess"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#gamification-by-process-grid",
                url: $("#action-gamification-by-process-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            business_id: null,
            messageSectionsActivities: {
                0: {
                    'text': 'Tus clientes al Compartir el perfil de la empresa obtiene puntos configurados . '
                },
                1: {
                    'text': 'Tus clientes al Comprar,Referir,Compartir un producto o servicio  obtiene puntos configurados . '
                },
                2: {
                    'text': 'Tus clientes al Referir,Compartir una seccion de tu CMS obtiene puntos configurados . '
                },
                3: {
                    'text': 'Tus clientes al Compartir ,visualizar procesos como Buzon de sugerencias obtiene puntos  . '
                },
                4: {
                    'text': 'Tus clientes al Compartir ,visualizar procesos como Chaquiñanes Virtuales de tu empresa gana yapitas . '
                },
            },
            allowManagerUrl: {
                view: false,
                url: '',
                dataQr: {
                    text: '',
                    mode: 'image',
                },
                class: 'warning',
                message: 'Ingrese todos los campos necesarios.!',
                element: null,
                generateAllow: false
            },
            managementSection: {
                business: ['business-details', 'shop-business', 'gaming-business', 'rewards-business', 'rimay-kuna-business', 'chanichina-registers-business','suggestions-registers-business','rate-business'],
                product: ['product-details-business'],
                business_form: ['suggestions-business'],
                business_route: ['chaqui-business'],
                cms: ['cms-login', 'cms-pages', 'cms-core']
            },
            sectionsProcess: {
                one: 'Publicación',
                two: 'Identificación',
                three: 'Recompensa (Gamificación)',
                four: 'Contenido',
                five: 'Enlace',
                six: 'Tracking de campaña',
            },
            selected: null,
            entityManager: {
                names: {
                    0: {'name': ''}
                }
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        setManagerUrl: function (params) {
            var gamification_type_activity_id_data = params['gamification_type_activity_id_data'];
            var entity = params['entity'];
            var tracking_type_id_data = params['tracking_type_id_data'];
            var tracking_source_id_data = params['tracking_source_id_data'];
            var entity_id_data = params['entity_id_data'];
            var is_url = params['is_url'];
            var campaign_code_template = params['campaign_code_template'];
            var url_manager_data = params['url_manager_data'];

            var business = $modelDataManager.business[0];

            // ===== Helpers ES5 =====
            function isNil(v) {
                return v === null || v === undefined;
            }

            function isEmpty(v) {
                return isNil(v) || (typeof v === "string" && v.replace(/^\s+|\s+$/g, "") === "");
            }

            // Setter de resultado
            var setResult = function (url, cls, msg, missingList, allow) {
                this.allowManagerUrl.view = !!is_url;
                this.allowManagerUrl.url = url;
                this.allowManagerUrl.class = cls;
                this.allowManagerUrl.message = msg;
                this.allowManagerUrl.dataQr.text = url;
                this.allowManagerUrl.generateAllow = allow;
                this.allowManagerUrl.url = url;
                this.model.attributes.url_manager = url;
                this.$v.model.attributes.url_manager.$model = url;

                // opcional: guarda lista detallada para UI (si quieres)
                // this.allowManagerUrl.missing = missingList || [];
            }.bind(this);

            // ✅ Un solo FAIL consolidado
            function failConsolidated(missing) {

                // Mensaje único
                var msg = "Faltan datos para generar el enlace: " + missing.join(", ") + ".";
                return setResult(null, "warning", msg, missing, false);
            }

            // ✅ Un solo OK
            function ok(url) {

                return setResult(url, "success", "Enlace Generado", [], true);
            }

            // Normaliza entity
            var entityCode = String(entity);

            // ===== 1) Validación consolidada (solo una vez) =====
            var missing = [];

            if (!is_url) {
                missing.push("Activar URL");
            }
            if (isNil(tracking_type_id_data)) {
                missing.push("Tipo de interacción (evento)");
            }
            if (isNil(tracking_source_id_data)) {
                missing.push("Origen / Fuente de tráfico");
            }
            if (isEmpty(campaign_code_template)) {
                missing.push("Campaña (código)");
            }
            if (isNil(url_manager_data)) {
                missing.push("Destino / Página asociada");
            }

            // Si hay faltantes => 1 solo mensaje y se termina
            if (missing.length > 0) {
                return failConsolidated(missing);
            }

            // ===== 2) Ya tenemos url_manager_data =====
            var id = url_manager_data.id;
            var type = url_manager_data.type;

            // Construye URL con tracking
            function buildTrackedUrl(baseUrl) {
                var typeProcess = tracking_type_id_data && tracking_type_id_data.code;
                var sourceProcess = tracking_source_id_data && tracking_source_id_data.code;

                if (isNil(typeProcess)) typeProcess = "";
                if (isNil(sourceProcess)) sourceProcess = "";

                var qs =
                    "typeProcess=" + encodeURIComponent(String(typeProcess)) +
                    "&sourceProcess=" + encodeURIComponent(String(sourceProcess)) +
                    "&campaign_code=" + encodeURIComponent(String(campaign_code_template));

                return (baseUrl.indexOf("?") !== -1)
                    ? (baseUrl + "&" + qs)
                    : (baseUrl + "?" + qs);
            }

            // ===== 3) Reglas por entidad (también con 1 solo error consolidado) =====
            var urlBase = null;
            var urlCurrent = null;

            if (entityCode === "0") {
                // allowed
                var allowed = this.managementSection.business;
                if (allowed.indexOf(type) === -1) {
                    return failConsolidated(["Destino/Página no asociada a esta entidad"]);
                }

                if (!business || isEmpty(business.title)) {
                    return failConsolidated(["Negocio (business.title)"]);
                }

                urlBase = removePlaceholders(id) + "/" + business.title;
                urlCurrent = buildTrackedUrl(urlBase);
                return ok(urlCurrent);
            }
            var missingEntity = [];
            if (entityCode === "1") {
                // necesita entity_id_data.id
                missingEntity = [];

                if (isNil(entity_id_data) || isNil(entity_id_data.id)) {
                    missingEntity.push("Producto/Servicio asociado");
                }
                if (type !== "product-details-business") {
                    missingEntity.push("Destino correcto (product-details)");
                }

                if (missingEntity.length > 0) {
                    return failConsolidated(missingEntity);
                }

                urlBase = removePlaceholders(id) + "/" + entity_id_data.id;
                urlCurrent = buildTrackedUrl(urlBase);
                return ok(urlCurrent);
            }

            if (entityCode === "2") {
                urlBase = id;
                if (isEmpty(urlBase)) {
                    return failConsolidated(["URL directa (id)"]);
                }
                urlCurrent = buildTrackedUrl(urlBase);
                return ok(urlCurrent);
            }
            if (entityCode === "3") {
                // necesita entity_id_data.id
                missingEntity = [];

                if (isNil(entity_id_data) || isNil(entity_id_data.id)) {
                    missingEntity.push("Formulario no Asignado");
                }
                if (type !== "suggestions-business") {
                    missingEntity.push("No se ha seleccionado correctamente la url");
                }

                if (missingEntity.length > 0) {
                    return failConsolidated(missingEntity);
                }

                urlBase = removePlaceholders(id) + "/" + entity_id_data.id;
                urlCurrent = buildTrackedUrl(urlBase);
                return ok(urlCurrent);

            }
            if (entityCode === "4") {
                // necesita entity_id_data.id
                missingEntity = [];

                if (isNil(entity_id_data) || isNil(entity_id_data.id)) {
                    missingEntity.push("Chaquiña o Ruta no Seleccionada.!");
                }
                if (type !== "chaqui-business") {
                    missingEntity.push("No se ha seleccionado correctamente la url");
                }

                if (missingEntity.length > 0) {
                    return failConsolidated(missingEntity);
                }

                urlBase = removePlaceholders(id) + "/" + entity_id_data.id;
                urlCurrent = buildTrackedUrl(urlBase);
                return ok(urlCurrent);

            }
            return failConsolidated(["Entidad no soportada para generar enlace"]);
        },
        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.gamification_id;
            this.initGridManager(this);
            this.initDataModal();
            this.$refs.refGamificationByProcessModal.show();
        },
        _managerS2Products: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var $el = $(el);
            destroyS2($el);

            if (valueCurrentRowId) {

                dataCurrent = this.model.attributes.entity_id_data_aux;
                this.model.attributes.entity_id_data = dataCurrent;
                var textCurrent = dataCurrent.text;
                var idCurrent = dataCurrent.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-products-getBusinessProductsServicesListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
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
                _this.model.attributes.entity_id_data = data;
                _this.setManagerUrl(_this.getValuesManagerUrl());
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.entity_id_data = null;
                _this._setValueForm('entity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        getConversion:function(){
            var yapitas=this.$v.model.attributes.points.$model;
            var resultConversion = GamificationCountryReference.convertYapitasToMoney(
                window.GamificationCountryReferenceData,
                yapitas,
                2
            );
            var valueConversion = [
                "<span class='badge badge--size-large badge-info'>", yapitas," YAPITA",(yapitas>1?"S":"")," es igual ",resultConversion.unit_label," ",resultConversion.money,
                "</span>"
            ].join("");


            return valueConversion;
        },
        _managerS2Forms: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var $el = $(el);
            destroyS2($el);
            if (valueCurrentRowId) {

                dataCurrent = this.model.attributes.entity_id_data_aux;
                this.model.attributes.entity_id_data = dataCurrent;
                var textCurrent = dataCurrent.text;
                var idCurrent = dataCurrent.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-products-getAskwersListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
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
                _this.model.attributes.entity_id_data = data;
                _this.setManagerUrl(_this.getValuesManagerUrl());
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.entity_id_data = null;
                _this._setValueForm('entity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _managerS2Routes: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var $el = $(el);
            destroyS2($el);
            if (valueCurrentRowId) {
                dataCurrent = this.model.attributes.entity_id_data_aux;
                this.model.attributes.entity_id_data = dataCurrent;
                var textCurrent = dataCurrent.text;
                var idCurrent = dataCurrent.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-products-getRoutesListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: _this.business_id
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
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
                _this.model.attributes.entity_id_data = data;
                _this.setManagerUrl(_this.getValuesManagerUrl());
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.entity_id_data = null;
                _this._setValueForm('entity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalGamificationByProcess'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refGamificationByProcessModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refGamificationByProcessModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_businessByGamification', params);
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
        _managerTargetGrid: function (params) {
            console.log(params);
        },
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
                elementSelect: elementSelect,

            });
        },
        getDataFiltersUrlByEntity: function (entity) {
            var paramsFilter = null;
            if (entity == '0') {
                paramsFilter = {
                    types: this.managementSection.business
                };
            } else if (entity == '1') {
                paramsFilter = {
                    types: this.managementSection.product
                };
            } else if (entity == '3') {
                paramsFilter = {
                    types: this.managementSection.business_form
                };
            } else if (entity == '4') {
                paramsFilter = {
                    types: this.managementSection.business_route
                };
            } else if (entity == '2') {
                paramsFilter = {
                    types: this.managementSection.cms
                };
            }
            return paramsFilter;
        },
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
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.subtitle = rowCurrent.subtitle;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.execution_channel = rowCurrent.execution_channel;
                this.model.attributes.execution_channel = rowCurrent.execution_channel;
                this.model.attributes.campaign_code_template = rowCurrent.campaign_code_template;
                this.model.attributes.entity = rowCurrent.entity;
                this.model.attributes.entity_id = rowCurrent.entity_id;
                var row = rowCurrent;
                var entity = row.entity;
                if (!emptyData.includes(row.entity)) {
                    this.model.attributes.entity_id_data_aux = {
                        id: rowCurrent.entity_id,
                        text: rowCurrent.entity_name
                    };
                    this.model.attributes.entity_id_data = {
                        id: rowCurrent.entity_id,
                        text: rowCurrent.entity_name
                    };
                }

                this.model.attributes.url_manager = rowCurrent.url_manager;

                this.model.attributes.url_manager_data = {};
                this.model.attributes.gamification_type_activity_id_data = {
                    id: rowCurrent.gamification_type_activity_id,
                    text: rowCurrent.gamification_type_activity,

                };

                this.model.attributes.tracking_type_id_data = {
                    id: rowCurrent.tracking_type_code,
                    text: rowCurrent.tracking_type_name,
                    code: rowCurrent.tracking_type_code_view,
                };
                this.model.attributes.tracking_source_id_data = {
                    id: rowCurrent.tracking_source_code,
                    text: rowCurrent.tracking_source_name,
                    code: rowCurrent.tracking_source_code_view,
                };

                var is_url = rowCurrent.is_url == 1 ? true : false;
                this.model.attributes.is_url = is_url;
                this.model.attributes.type_manager = rowCurrent.type_manager == 1 ? true : false;
                this.model.attributes.points = parseFloat(rowCurrent.points);
                this.model.attributes.gamification_by_points_id = parseFloat(rowCurrent.gamification_by_points_id);
                this.model.attributes.unique_code = (rowCurrent.unique_code);

                if (is_url) {
                    var paramsFilter = this.getDataFiltersUrlByEntity(entity);
                    var dataCurrent = this.getUrlData(paramsFilter);
                    var keyManagerNeedle = 'url_manager';
                    var dataCurrentLink = this.model.attributes[keyManagerNeedle];
                    var res = findMostSimilarIndex(dataCurrent, dataCurrentLink);
                    var item = res.item;
                    this.model.attributes.url_manager_data = item;

                    this.setManagerUrl(this.getValuesManagerUrl({type: 1}));
                }
                var vigencia = false;

                if (!emptyData.includes(rowCurrent.valid_from) && !emptyData.includes(rowCurrent.valid_until)) {
                    vigencia = true;
                }
                if (rowCurrent.frequency_limit_type == "TOTAL_LIMIT") {
                    this.model.attributes.frequency_limit_value = rowCurrent.frequency_limit_value;
                }
                this.model.attributes.frequency_limit_type = rowCurrent.frequency_limit_type;
                this.model.attributes.vigencia = vigencia;
            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            var $this = this;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var haystackSections = this.model.structure.entity.options;
            var dataFrequencyData = this.model.structure.frequency_limit_type.frequencyOptions;

            var formatters = {
                'description': function (column, row) {
                    var rowCurrent = row;
                    var activityName = '';
                    var itemSection = haystackSections.find(x => (x.value) == row.entity) || null;

                    var itemFrequency = dataFrequencyData.find(x => (x.value) == row.frequency_limit_type) || null;

                    if (itemSection) {
                        activityName = itemSection.text;
                    }
                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning";
                    }

                    var classStatusChannel = "badge-success";
                    if (row.execution_channel == "DIGITAL") {
                        classStatusChannel = "badge-warning";
                    }
                    var entityData = [];
                    var vigencia = false;
                    var vigenciaData = [];
                    if (!emptyData.includes(rowCurrent.valid_from) && !emptyData.includes(rowCurrent.valid_until)) {

                        vigenciaData = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>¿Esta tarea tiene vigencia?:</span><span class='content-description__value'><span class='badge badge--size-large  badge-success'>SI</span> </span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Valido desde</span><span class='content-description__value'>24-07-1987 18:58 PM</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Valido hasta</span><span class='content-description__value'>24-07-1987 18:58 PM</span>",
                            "</div>",
                        ];
                    } else {
                        vigenciaData = ["<div class='content-description__information'>",
                            "   <span class='content-description__title'>¿Esta tarea tiene vigencia?:</span><span class='content-description__value'><span class='badge badge--size-large  badge-warning'>NO</span> </span>",
                            "</div>"];
                    }
                    var limitVigenciaData = [];
                    if (rowCurrent.frequency_limit_type == "TOTAL_LIMIT") {

                        limitVigenciaData = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Limite de Frecuencia:</span><span class='content-description__value'> " + itemFrequency.text + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Cantidad Veces:</span><span class='content-description__value'><span class='badge badge--size-large  badge-info'>" + rowCurrent.frequency_limit_value + "</span></span>",
                            "</div>",
                        ];
                    } else {
                        limitVigenciaData = [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Limite de Frecuencia:</span><span class='content-description__value'> " + itemFrequency.text + "</span>",
                            "</div>",
                        ];
                    }

                    if (!['0', 0, -1, null, undefined].includes(row.entity_id)) {
                     var labelCurrent=   $this.getLabelFormByEntity(row.entity);
                        entityData = [
                            "<div class='content-description__information'>",
                            "   <span relation class='content-description__title'>" + labelCurrent + ":</span><span class='content-description__value'>"+rowCurrent.entity_name+"</span>",
                            "</div>",

                        ];
                    }
                    var imgView = row.has_source ? [
                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + $publicAsset + row.source + "'> ",
                        "</div>",

                    ] : [];
                    imgView = imgView.join('');
                    var urlView = row.is_url ? [
                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.five + '</legend>',
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.url_manager.label + ":</span><span class='content-description__value'><a href='" + row.url_manager + "' target='_blank'>Pagina vista.</a></span>",
                        "</div>",

                    ] : [];
                    urlView = urlView.join('');

                    var result = [
                        "<div class='content-description'>",
                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.one + '</legend>',
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.execution_channel.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatusChannel + " '>" + row.execution_channel + "</span></span>",
                        "</div>",
                        vigenciaData.join(""),
                        limitVigenciaData.join(""),
                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.two + '</legend>',
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.unique_code.label + ":</span><span class='content-description__value'>" + row.unique_code + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.entity.label + ":</span><span class='content-description__value'>" + activityName + "</span>",
                        "</div>",
                        imgView,
                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.three + '</legend>',
                        entityData.join(''),
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.gamification_type_activity_id_data.label + ":</span><span class='content-description__value'>" + row.gamification_type_activity + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.points.label + ":</span><span class='content-description__value'>" + "<span class='badge badge--size-large  badge-info '>" + row.points + "</span> " + "</span>",
                        "</div>",
                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.four + '</legend>',
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.subtitle.label + ":</span><span class='content-description__value'>" + row.subtitle + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        urlView,

                        '<legend class="h6 mb-2 legend--section">' + $this.sectionsProcess.six + '</legend>',
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.campaign_code_template.label + ":</span><span class='content-description__value'>" + row.campaign_code_template + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.tracking_type_id_data.label + ":</span><span class='content-description__value'>" + row.tracking_type_name + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.tracking_source_id_data.label + ":</span><span class='content-description__value'>" + row.tracking_source_name + "</span>",
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
        getUrlData: function (params) {
            if (params) {
                var allowedTypes = params['types'];
                if (allowedTypes == undefined) {
                    return [];
                } else if (allowedTypes == 'all') {
                    return $modelDataManager.processData.urlTracking;
                } else {
                    var filtered = $modelDataManager.processData.urlTracking.filter(function (row) {
                        return allowedTypes.indexOf(row.type) !== -1;
                    });


                    return filtered;
                }

            } else {
                return [];
            }

        },
        getStructureForm: function () {
            var optionsDataUrl = this.getUrlData({types: 'all'});
            var result = {
                "source": {
                    "id": "source",
                    "name": "source",
                    "label": "Imagen",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "title": {
                    "id": "title",
                    "name": "title",
                    "label": "Titulo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "points": {
                    "id": "points",
                    "name": "points",
                    "label": "Yapitas otorgadas",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "subtitle": {
                    "id": "subtitle",
                    "name": "subtitle",
                    "label": "Subtitulo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "description": {
                    "id": "description",
                    "name": "description",
                    "label": "Descripcion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "state": {
                    "id": "state",
                    "name": "state",
                    "label": "Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "has_source": {
                    "id": "has_source",
                    "name": "has_source",
                    "label": "Agregar Imagen!",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "entity": {
                    "id": "entity",
                    "name": "entity",
                    "label": "Módulo / Sección",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                    "options": $modelDataManager.processData.sections

                },
                "entity_id": {
                    "id": "entity_id",
                    "name": "entity_id",
                    "label": "Entidad kEY",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },

                },
                "url_manager": {
                    "id": "url_manager",
                    "name": "url_manager",
                    "label": "Url",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": optionsDataUrl
                },
                "url_manager_data": {
                    "id": "url_manager_data",
                    "name": "url_manager_data",
                    "label": "Destino / Página asociada",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "execution_channel": {
                    "id": "execution_channel",
                    "name": "execution_channel",
                    "label": "Tipo de recurso",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "PHYSICAL", "text": "FISICA"}, {"value": "DIGITAL", "text": "DIGITAL"}]
                },
                "gamification_type_activity_id_data": {
                    "id": "gamification_type_activity_id_data",
                    "name": "gamification_type_activity_id_data",
                    "label": "Tipo de interacción",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "tracking_type_id_data": {
                    "id": "tracking_type_id_data",
                    "name": "tracking_type_id_data",
                    "label": "Tipo de interacción (evento)",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "tracking_source_id_data": {
                    "id": "tracking_source_id_data",
                    "name": "tracking_source_id_data",
                    "label": "Origen / Fuente de tráfico",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "campaign_code_template": {
                    "id": "campaign_code_template",
                    "name": "campaign_code_template",
                    "label": "Campaña (código)",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "is_url": {
                    "id": "is_url",
                    "name": "is_url",
                    "label": "¿Este recurso lleva a un enlace?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "unique_code": {
                    "id": "unique_code",
                    "name": "unique_code",
                    "label": "Código interno",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_manager":
                    {
                        "id": "type_manager",
                        "name": "type_manager",
                        "label": "Tipo Gestion",
                        "required": {
                            "allow": false,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    },
                "entity_id_data": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "entity_id_data"
                    },
                    "id": "entity_id_data",
                    "name": "entity_id_data",
                    "label": "Productos /Servicios ",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "vigencia": {

                    "id": "vigencia",
                    "name": "vigencia",
                    "label": "¿Esta tarea tiene vigencia?",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                valid_from: {
                    "id": "valid_from",
                    "name": "valid_from",
                    "label": "Fecha Inicio",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                valid_until: {
                    "id": "valid_until",
                    "name": "valid_until",
                    "label": "Fecha Fin",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                frequency_limit_type: {
                    "id": "frequency_limit_type",
                    "name": "frequency_limit_type",
                    "label": "Frecuencia",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    frequencyOptions: [
                        //     {value: "NONE", text: "Sin límite"},
                        {value: "ONCE", text: "Una vez"},
                        {value: "DAILY", text: "Diario"},
                        {value: "WEEKLY", text: "Semanal"},
                        {value: "MONTHLY", text: "Mensual"},
                        {value: "TOTAL_LIMIT", text: "Límite total (cantidad)"}
                    ]
                },
                frequency_limit_value: {
                    "id": "frequency_limit_value",
                    "name": "frequency_limit_value",
                    "label": "Cantidad",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
            };
            return result;
        },
        getAttributesForm: function () {
            var entytyTypeProductService = 1;
            var result = {
                "id": null,
                "change": false,
                "source": null,
                "title": null,
                "subtitle": null,
                "description": null,
                "state": "ACTIVE",
                "has_source": true,
                "entity": entytyTypeProductService,
                "entity_id": 0,
                "url_manager": '',
                "gamification_type_activity_id_data": null,
                "tracking_source_id_data": {
                    id: 1,
                    text: 'DEFAULT',
                    uid: 'SRC_DEFAULT',
                    code: 'default',
                    description: 'Fuente de tráfico no identificada'
                },
                "tracking_type_id_data": {
                    id: 1,
                    text: 'DEFAULT',
                    uid: 'SRC_DEFAULT',
                    code: 'default',
                    description: 'Tipo de interacción no especificado'
                },
                "campaign_code_template": '',
                "execution_channel": 'DIGITAL',

                "is_url": false,
                "type_manager": 1,
                "unique_code": null,

                "points": 1,
                "gamification_by_points_id": null,
                "entity_id_data": null,
                entity_id_data_aux: null,
                vigencia: false,
                valid_from: null,
                valid_until: null,
                frequency_limit_type: 'ONCE',
                frequency_limit_value: null,
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,
        getLabelFormByEntity: function (entity) {
            var result = "";
            var label = "";
            if (entity == 0) {
                label = "Empresas";
            } else if (entity == 1) {
                label = "Productos / Servicios";

            } else if (entity == 2) {
                label = "CMS SECTIONS";

            } else if (entity == 3) {
                label = "Formularios";

            } else if (entity == 4) {
                label = "Chaquiñanes(Caminos)";

            }
            result = label + "" + "<span class='form__label--required'>*</span>";
            return result;

        },
        onValidUntil: function (payload) {
            console.log("✅ OK:", payload);
        },
        onValidFrom: function (payload) {
            console.log("✅ OK:", payload);
        },
        onFreqStatus(p) {
            // p.status: warning|error|success
            // p.data: { type, value }
            console.log("status", p.status, p.data);

            if (this.$v.model.attributes.frequency_limit_value.$model) {
                this.$v.model.attributes.frequency_limit_value.$model = null;
                this.$v["model"]["attributes"].frequency_limit_value.$reset();
            }
        },
        getValuesManagerUrl: function (params) {
            var typeGet = params && params.hasOwnProperty('type') ? params.type : null;

            // type == 1 => valores directos (model.attributes)
            // cualquier otro caso (o sin params) => valores validados ($v...$model)
            var useRaw = (typeGet === 1);

            var src = useRaw ? this.model.attributes : this.$v.model.attributes;

            function pick(key) {
                // raw: src[key]
                // validated: src[key].$model
                return useRaw ? src[key] : (src[key] ? src[key].$model : null);
            }

            var result = {
                gamification_type_activity_id_data: pick('gamification_type_activity_id_data'),
                entity: pick('entity'),
                tracking_type_id_data: pick('tracking_type_id_data'),
                tracking_source_id_data: pick('tracking_source_id_data'),
                entity_id_data: pick('entity_id_data'),
                is_url: pick('is_url'),
                campaign_code_template: pick('campaign_code_template'),
                url_manager_data: pick('url_manager_data')
            };
            return result;
        },
        resetManagerUrl: function () {
            this.$v["model"]["attributes"]['url_manager_data'].$model = null;
            this.model.attributes['url_manager_data'] = null;
            this.$v["model"]["attributes"]['url_manager_data'].$touch();
            this.allowManagerUrl.generateAllow = false;
            this.allowManagerUrl.url = '';
            this.allowManagerUrl.class = 'warning';
            this.allowManagerUrl.element = null;
            this.allowManagerUrl.view = false;

            this.allowManagerUrl.message = 'Ingrese todos los campos necesarios.!';
        },
        _setValueForm: function (name, value) {

            if (name == 'entity') {
                this.model.attributes.entity_id_data_aux = {};
                this.model.attributes.entity_id_data = {};
            }
            if (["entity", "entity_id_data", "is_url", "campaign_code_template", "tracking_type_id_data", "tracking_source_id_data", 'url_manager', 'url_manager_data'].includes(name)) {
                if ('is_url' == name) {
                    if (!value) {
                        this.resetManagerUrl();
                    }


                }
                this.setManagerUrl(this.getValuesManagerUrl());
                if (name == "entity") {
                    if (this.$v.model.attributes.is_url.$model) {
                        this.resetUrlS2Manager();
                    }
                }
                if ('url_manager' == name) {

                    //this.$v["model"]["attributes"][name].$touch();
                }

            }
            if ("frequency_limit_value" == name) {
                if (parseInt(value) < 1) {
                    value = value * -1;
                }
            }
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();

        },
        getClassErrorForm: getClassErrorForm,
//Manager Model
        onDownloadQR: function () {
            downloadQR({
                format: 'png',
                'text': this.$v.model.attributes.url_manager.$model
            });
        },
        getValuesSave: function () {
            var isUrl = this.$v.model.attributes.is_url.$model == null ? 0 : (this.$v.model.attributes.is_url.$model ? 1 : 0);
            var result = {
                    "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    change: this.$v.model.attributes.change.$model,
                    "source": this.$v.model.attributes.source.$model,
                    "title": this.$v.model.attributes.title.$model,
                    "subtitle": this.$v.model.attributes.subtitle.$model,
                    "description": this.$v.model.attributes.description.$model,
                    "state": this.$v.model.attributes.state.$model,
                    "has_source": this.$v.model.attributes.has_source.$model == null ? 0 : (this.$v.model.attributes.has_source.$model ? 1 : 0),
                    "entity": this.$v.model.attributes.entity.$model,
                    "entity_id": this.$v.model.attributes.entity_id_data.$model == null ? 0 : (this.$v.model.attributes.entity_id_data.$model.id),
                    "url_manager": isUrl == 1 ? this.$v.model.attributes.url_manager.$model : 'not-url',
                    "gamification_id": this.manager_id,
                    "gamification_type_activity_id": this.$v.model.attributes.gamification_type_activity_id_data.$model.id,
                    "tracking_click_type_id": this.$v.model.attributes.tracking_type_id_data.$model.id,
                    "tracking_source_id": this.$v.model.attributes.tracking_source_id_data.$model.id,
                    "campaign_code_template": this.$v.model.attributes.campaign_code_template.$model,

                    "execution_channel": this.$v.model.attributes.execution_channel.$model,
                    "is_url": isUrl,
                    "type_manager": this.$v.model.attributes.type_manager.$model == null ? 0 : (this.$v.model.attributes.type_manager.$model ? 1 : 0),
                    "points": this.$v.model.attributes.points.$model,
                    "unique_code": this.$v.model.attributes.unique_code.$model,
                    "gamification_by_points_id": this.$v.model.attributes.gamification_by_points_id.$model


                }
            ;

            return result;
        },
        _saveModel: function () {


            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                alert('error');
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
            this.resetManagerUrl();
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions
        _managerEventsUpload: function (params) {
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        }, _managerS2GamificationTypeActivity: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.gamification_type_activity_id_data];


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
                    url: $("#action-gamification-type-activity-getListSelect2").val(),
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
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.gamification_type_activity_id_data = data;

            }).on("select2:unselecting", function (e) {
                _this.model.attributes.gamification_type_activity_id_data = null;
                _this._setValueForm('gamification_type_activity_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _managerS2TrackingType: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            let keyCurrent = "tracking_type_id_data";
            let dataCurrentModel = this.model.attributes[keyCurrent];
            var textCurrent = '';
            var idCurrent = -1;
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes[keyCurrent]];
                textCurrent = dataCurrent[0].text;
                idCurrent = dataCurrent[0].id;
            } else {
                textCurrent = dataCurrentModel.text;
                idCurrent = dataCurrentModel.id;
            }

            var option = new Option(textCurrent, idCurrent, true, true);
            $(el).append(option).trigger('change');
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-tracking-click-types-getListSelect2").val(),
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
                multiple: true,
                maximumSelectionLength: 1,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes[keyCurrent] = data;
                _this.setManagerUrl(_this.getValuesManagerUrl());
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyCurrent] = null;
                _this._setValueForm(keyCurrent, null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _managerS2TrackingSource: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            let keyCurrent = "tracking_source_id_data";
            let dataCurrentModel = this.model.attributes[keyCurrent];

            var textCurrent = '';
            var idCurrent = -1;
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes[keyCurrent]];
                textCurrent = dataCurrent[0].text;
                idCurrent = dataCurrent[0].id;
            } else {
                textCurrent = dataCurrentModel.text;
                idCurrent = dataCurrentModel.id;
            }

            var option = new Option(textCurrent, idCurrent, true, true);
            $(el).append(option).trigger('change');
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-tracking-sources-getListSelect2").val(),
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
                multiple: true,
                maximumSelectionLength: 1,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes[keyCurrent] = data;
                _this.setManagerUrl(_this.getValuesManagerUrl());
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyCurrent] = null;
                _this._setValueForm(keyCurrent, null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        //uploads methods
        _uploadDataImage: function (eventSelector) {
            var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
                toElement: eventSelector.toElement
            });
            selectorFile = '#file-' + selectorFile;
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
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
        resetUrlS2Manager: function () {
            //{rowId:model.attributes.id,functionCurrent:_managerS2UrlManager}
            var $el = $('#url_manager_data');
            var objSelector = {
                objSelector: $el,
                rowId: this.model.attributes.id,
            };
            if ($el.data('select2')) $el.select2('destroy');
            $el.empty();
            this._managerS2UrlManager(objSelector);
        },
        _managerS2UrlManager: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataUrlManager = this.getValuesManagerUrl();
            var entity = dataUrlManager['entity'];
            var paramsFilter = this.getDataFiltersUrlByEntity(entity);


            var dataCurrent = this.getUrlData(paramsFilter);
            var keyManager = 'url_manager_data';
            if (valueCurrentRowId) {
                var keyManagerNeedle = 'url_manager';
                var dataCurrentLink = this.model.attributes[keyManagerNeedle];
                var res = findMostSimilarIndex(dataCurrent, dataCurrentLink);
                var item = res.item;
                this.model.attributes.url_manager_data = item;
                if (item) {
                    var dataCurrentItem = item;
                    var textCurrent = dataCurrentItem.text;
                    var idCurrent = dataCurrentItem.id;
                    var option = new Option(textCurrent, idCurrent, true, true);
                    $(el).append(option).trigger('change');
                }

            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                multiple: true,
                maximumSelectionLength: 1,
                width: '100%'
            });
            this.allowManagerUrl.element = elementInit;
            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes[keyManager] = data;
                _this.$v.model.attributes.url_manager_data.$reset();
                _this.$v.model.attributes.url_manager_data.$error = false;
                _this.$v.model.attributes.url_manager_data.$dirty = true;
                _this.$v.model.attributes.url_manager_data.required = true;
                _this.$v.model.attributes.url_manager_data.$invalid = false;

                _this.$v.model.attributes.url_manager_data = data;
                _this.$v.model.attributes.url_manager_data.$touch();

                _this._setValueForm(keyManager, data);

            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyManager] = null;
                _this._setValueForm(keyManager, null);
                _this.$v.model.attributes.url_manager_data.$reset();
                _this.$v.model.attributes.url_manager_data.$dirty = true;
                _this.$v.model.attributes.url_manager_data.$error = true;
                _this.$v.model.attributes.url_manager_data.required = true;
                _this.$v.model.attributes.url_manager_data.$invalid = true;


                _this.$v.model.attributes.url_manager_data = null;
                _this.$v.model.attributes.url_manager_data.$touch();


            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        viewErrorMessage: function (params) {
            var attribute = params['attribute'];
            var objValidate = this.$v.model.attributes[attribute];

            return formInvalidFeedback({objValidate: objValidate});
        },
        getClassMessage: function (modelData) {
            var entity = modelData.entity.$model;
            var result = '';
            result = {"alert-info": true};
            if (entity == 0) {

                result = {"alert-warning": true};
            } else if (entity == 1) {
                result = {"alert-info": true};

            }

            return result;
        },
    }
})
;


function removePlaceholders(url) {
    return url.replace(/\{[^}]*\}/g, '').replace(/\/$/, '');
}

function destroyS2($el) {
    if ($el.data('select2')) $el.select2('destroy');
    $el.empty();
}
