var componentThisProductByRouteMap;
Vue.component('product-by-route-map-component', {
    template: '#product-by-route-map-template',
    directives: {
        initS2RoutesMap: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2RoutesMap({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        'initMapPreview': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.method({
                    objSelector: el, data: paramsInput.data
                });
            }
        }, 'initSlickMapPreview': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.method({
                    objSelector: el, data: paramsInput.data
                });
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        this.initScriptsMap();
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.configParams = this.params;

        this.manager_id = this.configParams.data.id;
        var paramsSet = this.configParams.data.hasOwnProperty('management') ? this.configParams.data.management : {};
        if (paramsSet.hasOwnProperty('product_by_route_map_id')) {
            this.model.attributes.id = paramsSet.product_by_route_map_id;
            routes_map_id_data = paramsSet;
            this.model.attributes.routes_map_id_data = routes_map_id_data;

            var haystack = paramsSet.routes_drawing_data;
            var rowCurrent = this.configParams.data.management;


            this.mapManagement.data = {
                haystack: haystack,
                routeInformation: rowCurrent,
                typeGetData: true
            };
            this.mapManagement.view = true;
        }


    },
    mounted: function () {
        componentThisProductByRouteMap = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "routes_map_id_data": {required}
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
            manager_key_name: 'product_id',
            /*  ----MANAGER ENTITY---*/
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
                    cancel: "Cancelar",
                    delete: 'Eliminar'
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
                nameSelector: "#product-by-route-map-form",
                url: $('#action-product-by-route-map-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ProductByRouteMap.',
                successMessage: 'El ProductByRouteMap se guardo correctamente.',
                nameModel: "ProductByRouteMap"
            },
//Grid config

            showManager: true,
            managerType: null,
            mapManagement: {
                mapObject: null,
                data: {},
                dataLayers: {},
                managementMultimedia: {
                    view: false,
                    'htmlCurrent': '',
                    empty: [
                        '<div class="content-empty-data">',
                        '<h1> No existe galeria en este punto.',
                        '</div>',

                    ].join('')
                },

                view: false,
                selectorId: "map-preview"
            }, initLoadAll: false
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.id;
            this.changeLabels(this.configParams.data);
            this.initDataModal();
            this.$refs.refProductByRouteMapModal.show();
        },
        changeLabels: function (params) {
            var managerType = 1;
            if (params.hasOwnProperty('product_by_route_map_id')) {
                managerType = 2;
            } else {
                managerType = 1;

            }
            this.managerType = managerType;

        },
        _delete: function () {
            var $scope = this;
            var urlCurrent = $('#action-product-by-route-map-deleteRouteProduct').val();
            var dataSend = {
                id: this.model.attributes.id
            };
            var blockElement = '#modal-product-by-route-map';
            var loading_message = 'Eliminando...';
            var error_message = 'Error al eliminar.!';
            var success_message = 'Datos eliminados con exito!';
            ajaxRequest(urlCurrent, {
                type: 'POST',
                data: dataSend,
                blockElement: blockElement,//opcional: es para bloquear el elemento
                loading_message: loading_message,
                error_message: error_message,
                success_message: success_message,
                success_callback: function (response) {

                    if (response.success) {
                        $scope.resetForm();
                        $scope.changeLabels({});
                        $('#routes_map_id_data').val(null).trigger("change");
                        $scope.mapManagement.view=false;
                        $scope.mapManagement.managementMultimedia.view=false;
                    }


                }
            });

        },
        /*modal events*/
        _showModal: function () {
            var paramsSet = this.configParams.data.hasOwnProperty('management') ? this.configParams.data.management : {};

            var allowReset = true;
            if (paramsSet.hasOwnProperty('product_by_route_map_id')) {
                var allowReset = false;
            }
            if (allowReset) {

                this.resetForm();
            }

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalProductByRouteMap'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refProductByRouteMapModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refProductByRouteMapModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS

        /*Manager FORMS-AND VIEWS*/
        _viewManager: _viewManager,
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "product_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "product_id_data"
                    },
                    "id": "product_id_data",
                    "name": "product_id_data",
                    "label": "product id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "routes_map_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "routes_map_id_data"
                        },
                        "id": "routes_map_id_data",
                        "name": "routes_map_id_data",
                        "label": "Croquis-Chaquiñan",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "product_id_data": null, "routes_map_id_data": null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,


        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {

            var result = {
                ProductByRouteMap:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "product_id": this.configParams.data.id,
                        "routes_map_id": this.$v.model.attributes.routes_map_id_data.$model.id

                    }
            };

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                $scope.submitStatus = 'error';
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
                            var attributes = response.data.attributes;
                            $scope.changeLabels({
                                product_by_route_map_id: attributes['id']
                            });
                            $scope.model.attributes['id'] = attributes['id'];


                        }
                    }
                });

            }
        },
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();

        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions
        _managerS2RoutesMap: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            var elementS2 = $(el);
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.routes_map_id_data];
                var haystack = dataCurrent;

                initSelectMultiple({
                    haystack: dataCurrent,
                    elementS2: elementS2
                });
            }
            var business = $modelDataManager['business'][0];
            var business_id = business['id'];
            var $scope = this;
            var elementInit = elementS2.select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-routes-map-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        managerModalSelect2();
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: business_id
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
                width: '100%',
                tags: true,
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                $scope.model.attributes.routes_map_id_data = data;

                var haystack = data.routes_drawing_data;
                var rowCurrent = data;
                $scope.mapManagement.data = {
                    haystack: haystack,
                    routeInformation: rowCurrent,
                    typeGetData: true
                };
                $scope.mapManagement.view = true;

            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.routes_map_id_data = null;
                $scope._setValueForm('routes_map_id_data', null);
                $scope.mapManagement.view = false;
            });
        },
        initManagementMultimedia: function (params) {
            console.log(params);

            if (params.type == 'marker') {
                if (Object.keys(params.data).length > 0) {
                    this.mapManagement.managementMultimedia.htmlCurrent = this.getHtmlMultimedia({data: params.data});
                    this.mapManagement.managementMultimedia.view = true;
                } else {
                    this.mapManagement.managementMultimedia.view = false;

                }
            } else {
                this.mapManagement.managementMultimedia.view = false;

            }
        },
        //INIT DATA MULTIMEDIA
        getStructureMultimedia: function (params) {

        },
        initSlickMapPreview: function (params) {
            var objSelector = params.objSelector;
            $(objSelector).slick({
                lazyLoad: 'ondemand', // ondemand progressive anticipated
                infinite: true,
                dots: true,
            });
        },
        getHtmlMultimedia: function (params) {
            var data = params.data;

            var result = [];
            $.each(data, function (key, setPush) {
                var title = setPush['p_title'];
                var description =setPush['p_description'];
                var source=$resourceRoot+'/'+setPush['p_src'];
                var setPushCurrent = [

                    '<div class="content-wrapper-card">',
                    '  <img data-lazy="'+source+'"',
                    'data-srcset="'+source+'"',
                    ' >',
                    '<h1 class="content-wrapper-card__title">' + title + '</h1>',
                    '<p class="content-wrapper-card__description">' + description + '</p>',
                    '</div>',


                ];
                setPushCurrent=setPushCurrent.join('');
                result.push(setPushCurrent);

            });
            return result.join('');
        },
        //GOOGLE MAPS
        initScriptsMap: function () {
            var $scope = this;
            if (!window.slick) {
                $.getScript($('.slick').attr('source-three'), function (data, textStatus, jqxhr) {
                    window.slick = true;

                });
                $('head').append($('<link rel="stylesheet" type="text/css" />').attr('href', $('.slick').attr('source-one')));
                $('head').append($('<link rel="stylesheet" type="text/css" />').attr('href', $('.slick').attr('source-two')));

            }

            if (!window.google) {
                $.getScript($('.google-api').attr('source'), function (data, textStatus, jqxhr) {
                    console.log(data); // Data returned
                    console.log(textStatus); // Success
                    console.log(jqxhr.status); // 200
                    console.log("Load was performed. google");
                    $scope.initLoadAll = true;
                });
            } else {
                $scope.initLoadAll = true;

            }
            if (!window.Cluster) {
                $.getScript($('.google-api-markers').attr('source'), function (data, textStatus, jqxhr) {
                    console.log(data); // Data returned
                    console.log(textStatus); // Success
                    console.log(jqxhr.status); // 200
                    console.log("Load was performed. google marker");
                });
            }


        },
        initMapCurrent: function (params) {

            var $scope = this;
            var selectorId = params.data['selectorId'];
            this.greyscale_style = $greyscale_style;
            var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                name: "Greyscale"
            });
            var options_map = JSON.parse(params.data.data.routeInformation.options_map);
            var mapOptions = {
                title: "Ubicacion",
                panControl: true,
                /*  scrollwheel: true,*/
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                overviewMapControl: false,
                draggable: true,
                center: options_map.center,
                zoom: options_map.zoom,
                animation: google.maps.Animation.DROP,
                gestureHandling: 'cooperative'
            }
            map = new google.maps.Map(document.getElementById(selectorId), mapOptions);

            $scope.mapManagement.mapObject = map;


            latlngData = [];
            var dataLayers = [];
            var mapCurrentRoutes = map;
            var paramsManagement = this.mapManagement.data;
            var routeInformation = paramsManagement.routeInformation;
            var typeGetData = paramsManagement.typeGetData;//true=db,false=kml
            paramsManagement['map'] = mapCurrentRoutes;
            _this = this;
            var resultStructure = getStructureRouteMap(paramsManagement);
            dataLayers = resultStructure['layers'];
            latlngData = resultStructure['latLngData'];
            var mapOverlays = [];
            $.each(dataLayers, function (key, setPush) {
                console.log(setPush);
                functionCurrent = null;

                var infContent = [
                    '<div class="content-information">',
                    '   <h1>' + setPush.title + '</h1>',
                    '   <div class="content-information-description">',
                    setPush.content,

                    '   </div>',

                    '</div>'


                ];
                infContent = infContent.join('');

                functionCurrent = $scope.initManagementMultimedia;
                _setLayerMap(setPush, mapCurrentRoutes, infContent, functionCurrent);
            });
            //step 2
            mapOverlays = $.merge(mapOverlays, dataLayers);


        }
    }
})
;



