var mapObjCurrent;
var dataLayers = [];
var BlitzMap;
var optionsCenter = [];
var setCenterLatLng;
var required = Validators.required;
var minLength = Validators.minLength;
var between = Validators.between;
var $vD = null;

// define the tree-item component
var deleteData = [];


var currentValuesR = null;
var boundsLatLng;
var latlngData;
var curentMapR;
var componentThisRoute;
var routesComponent = Vue.component('routes-component', {
    template: '#routes-template',
    created: function () {

    },
    mounted: function () {
        componentThisRoute = this;
        this.initCurrentComponent();
        $vD = this.$v;
        currentValuesR = this;
        removeClassNotView();
    },
    validations: {
        modelRoutes: {
            attributes: {
                type: {
                    required
                },
                kml_structure: {
                    required
                },
                name: {
                    required,
                    minLength: minLength(4)
                },
                status: {},
                description: {
                    required,
                },
                src: {
                    required,
                },
                type_shortcut: {
                    required,

                },
                adventure_type: {}
            }
        },

    },
    computed: {

    },
    data: function () {

        var dataManager = {
            message: 'hello!',
            configParams: {},
            configMap: {
                buttons: {
                    clear: {
                        title: "Limpiar Mapa",
                        view: true
                    },
                    edit: {
                        title: "Editar",
                        view: false

                    },
                }
            },

            map: null,
            uploadElementsSelectors: {
                file: "#file_upload"

            },
            //uploads
            uploadConfig: {
                uploadElementsSelectors: {
                    file: "#file_upload",
                    image: "#file_upload_src"
                },
                labelsButtons: {
                    file: "Subir Kml.",
                    image: "Subir Imagen.",

                },
                viewUpload: {
                    image: "#preview-route-src"
                }
            },
            lblUploadName: "Upload Kml",
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            modelRoutes: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-routes',
            processName: "Rutas",
            formConfig: {
                nameSelector: "#business-by-routes-form",
                url: $('#action_routes_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'La ruta  se guardo correctamente.',
            },
            gridSelectorCurrent: "#routes-grid",
            submitStatus: "no",
            showManager: false,
            businessId: null,
            optionsShortcut: getDataShortCut(),
            optionsAdventureType: getDataAdventureType(),
            /*    ----GRID ----*/
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            },
            managerType: null,

        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        _viewManager: function (typeView) {
            this.resetForm();
            if (typeView == 1) {//create-update
                this.managerType = 1;
                this.showManager = true;
                this.managerMenuConfig.view = false;
                $(this.gridSelectorCurrent + "-header").hide();
                $(this.gridSelectorCurrent + "-footer").hide();
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;
                $(this.gridSelectorCurrent + "-footer").show();
                $(this.gridSelectorCurrent + "-header").show();
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.showManager = true;
                $(this.gridSelectorCurrent + "-footer").hide();
                $(this.gridSelectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM

            }
        },
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            var type = params.type;
            var dataGet = params.dataSend;
            var modelBusiness = dataGet.modelData;
            this.initCurrentComponent();
        },
        _dataChildren: function () {
            /* this.params.titleEvent = "Cambio evento";*/
            /*EVENT BUS*/
            if (false) {
                appInit.$emit('_updateTitleEvents', 'Vue data title');
            } else {

                this.$emit('_data-components-children', {
                    nameEvent: "_dataChildren",
                    nameComponent: "Routes",
                    response: this._data
                });
            }
            this.params.titleEvent = "Hola Cambiado";

        },
        /*FORM*/
        _submitForm: function (e) {
            console.log(e);
        },
        getAttributesForm: function () {
            var result = {
                type: 1,
                name: null,
                description: null,
                status: true,
                kml_structure: null,
                src: null,
                change: false,
                type_shortcut: 4,
                adventure_type: []
            };

            return result;
        },
        getStructureForm: function () {
            var result = {
                type:
                    {
                        id: "type",
                        name: "type",
                        label: "Tipo",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                description: {
                    name: "description",
                    label: "Descripción",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                name: {
                    name: "kml_structure",
                    label: "Nombre",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                status: {
                    name: "type",
                    label: "Estado",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                kml_structure: {
                    name: "kml_structure",
                    label: "Kml Estructura",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                src: {
                    name: "src",
                    label: "Imagen ",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                type_shortcut: {
                    name: "type_shortcut",
                    label: "Tipo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                }, adventure_type: {
                    name: "adventure_type",
                    label: "Que existe en la ruta?",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                }
            };

            return result;
        },
        getItemsCurrent: function () {

            var result = treeData;
            return result;
        },
        getLabelForm: function (nameId) {
            return viewGetLabelForm(nameId,this.modelRoutes);

        },

        /* validations*/
        hasErrorElement: function (nameElement, valueModel) {
            var msj = "";
            var hasError = false;
            if (!this.modelRoutes.init) {

                switch (nameElement) {
                    case 'name':
                        valueModel = valueModel ? valueModel : "";
                        var validationResult = Validator.value(valueModel).required();
                        msj = "";
                        if (Object.keys(validationResult["_messages"]).length) {
                            var msjCurrent = validationResult["_messages"];
                            msj = msjCurrent[0];
                            hasError = true;
                        } else {
                            hasError = false;
                        }
                        this.modelRoutesValidations[nameElement].required.error = hasError;
                        break;
                    case 'kml_structure':
                        valueModel = valueModel ? valueModel : "";
                        var validationResult = Validator.value(valueModel).required();
                        msj = "";
                        if (Object.keys(validationResult["_messages"]).length) {
                            var msjCurrent = validationResult["_messages"];
                            msj = msjCurrent[0];
                            hasError = true;
                        } else {
                            hasError = false;
                        }
                        this.modelRoutesValidations[nameElement].required.error = hasError;
                        break;
                }

            } else {
                hasError = false;
            }
            return !hasError;
        },
        getViewErrorElement: function (nameElement, objValidate) {
            var notView = true;
            if (objValidate.$dirty) {

                if (nameElement == "name") {
                    if (!objValidate.required) {
                        notView = false;
                    }
                    if (!objValidate.minLength) {
                        notView = false;

                    }
                }
            } else {
                notView = true;
            }
            return notView;//false=view,true=not-view
        },
        _setValueForm: function (name, value) {
            if (name == "kml_structure") {

            } else {
                this.modelRoutes.attributes[name] = value;
            }
            this.$v["modelRoutes"]["attributes"][name].$touch();
            this._valuesForm();
        },
        getClassErrorForm: function (nameElement, objValidate) {

            var result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            }

            return result;
        },
        deleteItemsKml: function (stringKml, deleteDataCurrent) {
            var result = {};
            var objKml = jQuery.parseJSON(stringKml);
            var routes = [];
            $.each(deleteDataCurrent, function (key, value) {
                var id = value.id;
                $.each(objKml.routes_drawing_data, function (keyKml, valueKml) {
                    if (valueKml.id != id) {
                        routes.push(valueKml);
                    }

                });
            });
            result = {routes_drawing_data: routes};

            return JSON.stringify(result);
        },
        _saveRoutes: function () {
            var kml_structure = this.modelRoutes.attributes.kml_structure;
            if (Object.keys(deleteData).length > 0) {
                kml_structure = this.deleteItemsKml(kml_structure, deleteData);
            }

            var dataSend = {
                id: this.modelRoutes.attributes.id,
                type: this.modelRoutes.attributes.type,
                name: this.modelRoutes.attributes.name,
                description: this.modelRoutes.attributes.description,
                status: this.modelRoutes.attributes.status ? "ACTIVE" : "INACTIVE",
                business_id: this.businessId,
                kml_structure: kml_structure,
                options_map: JSON.stringify(this.getOptionsMap()),
                deleteData: JSON.stringify(deleteData),
                change: this.modelRoutes.attributes.change,
                src: this.modelRoutes.attributes.src,
                type_shortcut: this.modelRoutes.attributes.type_shortcut,
                adventure_type: this.modelRoutes.attributes.adventure_type
            };
            var _this = this;
            _this.$v.$touch();
            if (this.$v.$invalid) {
                _this.submitStatus = 'error';

            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: _this.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: _this.formConfig.loadingMessage,
                    error_message: _this.formConfig.errorMessage,
                    success_message: _this.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            _this.resetForm(true);
                            $(_this.gridSelectorCurrent).bootgrid("reload");
                            _this._viewManager(2);
                        }
                    }
                }, true);
            }
        },
        resetForm: function (save) {
            deleteData = [];
            this.$v.$reset();
            $(this.uploadElementsSelectors.file).val("");
            this.modelRoutes = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };

            this.$v.modelRoutes.attributes.adventure_type.$model = [];

            this.modelRoutes.attributes.id = null;
            var srcImage = $notImageUrl;


            $(this.uploadConfig.viewUpload.image).attr("src", srcImage);
            $(this.uploadConfig.uploadElementsSelectors.file).val("");
            $(this.uploadConfig.uploadElementsSelectors.image).val("");

            this._deleteAll();
            if (save) {
                this._resetManagerGrid();
            }
        },
        _valuesForm: function (event) {
            this.modelRoutes.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = true;
            _this = this;
            if (!this.modelRoutes.attributes.kml_structure || !this.modelRoutes.attributes.name || !this.modelRoutes.attributes.description || !this.modelRoutes.attributes.src || this.modelRoutes.attributes.type_shortcut == null) {
                currentAllow = false;

            }
            return currentAllow;
        },
        setDataFormKml: function () {
            var resultData = BlitzMap.getDataMapLayersConfig();
            this.setValuesKml(resultData);
        },
        getDataKmlString: function (params) {
            resultData = params.resultData;
            var routes_drawing_data = resultData.object.overlays;
            result = {
                routes_drawing_data: routes_drawing_data
            }
            return result;
        },
        getOptionsMap: function () {
            var tmpMap = new Object;

            tmpMap.zoom = this.map.getZoom();
            tmpMap.tilt = this.map.getTilt();
            tmpMap.mapTypeId = this.map.getMapTypeId();

            tmpMap.center = {lat: this.map.getCenter().lat(), lng: this.map.getCenter().lng()};
            return tmpMap;
        },
        setOptionsMap: function () {


        },
        setStructureLayers: function (params) {

            latlngData = [];
            var dataLayers = [];
            var mapCurrentRoutes = this.map;
            var routeInformation = params.routeInformation;
            var typeGetData = params.typeGetData;//true=db,false=kml
            params['map'] = mapCurrentRoutes;
            _this = this;
            var resultStructure = getStructureRouteMap(params);
            dataLayers=resultStructure['layers'];
            latlngData=resultStructure['latLngData'];
            $.each(dataLayers, function (key, setPush) {
                BlitzMap._layerMap(setPush, mapCurrentRoutes);
            });
            //step 2
            mapOverlays = $.merge(mapOverlays, dataLayers);
            if (!typeGetData) {
                latlngData = getLatLngDataDB({
                    haystack: latlngData
                });
                boundsLatLng = getBounds(latlngData);
                mapCurrentRoutes.fitBounds(boundsLatLng);
            }


            var resultKML = {
                optionsKml: {
                    nameRoute: routeInformation.name ? routeInformation.name : routeInformation.nameRoute,
                    descriptionRoute: routeInformation.description ? routeInformation.description : routeInformation.descriptionRoute
                }

            };
            _this.setValuesKmlConfigForm({
                resultKML: resultKML
            });


        },
        //MANAGER PROCESS
        _managerRowGrid: function (params) {
            this._viewManager(3);
            var rowCurrent = params.row;
            var rowId = params.id;
            var haystack = rowCurrent.routes_drawing_data;


            this.setStructureLayers({
                haystack: haystack,
                routeInformation: rowCurrent,
                typeGetData: true
            });
            this.modelRoutes.attributes.id = rowId;
            this.modelRoutes.attributes["change"] = false;
            var srcImage = rowCurrent.src == 'nothing' ? $notImageUrl : rowCurrent.src;
            srcImage = $resourceRoot + srcImage;
            $(this.uploadConfig.viewUpload.image).attr("src", srcImage);
            this.modelRoutes.attributes["src"] = srcImage;
            this.modelRoutes.attributes.status = rowCurrent.status == "ACTIVE" ? true : false;
            this.modelRoutes.attributes.type_shortcut = rowCurrent.type_shortcut;
            this.$v.modelRoutes.attributes.type_shortcut.$model = rowCurrent.type_shortcut;
            var adventure_type_data = [];
            if (Object.keys(rowCurrent["adventure_type_data"]).length) {
                $.each(rowCurrent["adventure_type_data"], function (key, value) {
                    adventure_type_data.push(value["adventure_type"]);
                });
            }
            this.$v.modelRoutes.attributes.adventure_type.$model = adventure_type_data;

            /*---CONFIG MAP ---*/
            var optionsMap = jQuery.parseJSON(rowCurrent["options_map"]);

            this.map.setCenter(optionsMap.center);
            this.map.setZoom(optionsMap.zoom);
            curentMapR = this.map;

        },
        getMenuConfigGridRow: function (params) {
            $configModelEntityRoutes = {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "manager-type": "update"
                    }
                ]
            };
            var buttonsManagements = $configModelEntityRoutes["buttonsManagements"];
            var result = [];
            $.each(buttonsManagements, function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value,
                    rowId: params.rowId,
                    managerType: value["manager-type"],
                    params: params
                }
                result.push(setPush);
            });
            return result;
        },
        /*---------GRID--------*/
        _managerMenuGrid: function (key, menu) {
            if (menu.managerType == "update") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);

                this._managerRowGrid({
                    row: menu.params["rowData"],
                    id: menu.rowId
                });


            }

        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridSelectorCurrent;
            var urlCurrent = $("#action_routes_admin").val();
            var business_id = this.businessId;
            var paramsFilters = {
                business_id: business_id
            };
            let gridId = $(gridName);
            gridId.bootgrid({
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

                        var description = (row.description !== "null" && row.description) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Description:</span><span class='content-description__value'>" + (row.description) + "</span>",
                            "</div>",

                        ] : [];
                        description = description.join("");

                        var adventure_type_data = [];
                        if (Object.keys(row["adventure_type_data"]).length) {
                            $.each(row["adventure_type_data"], function (key, value) {
                                var adventure_type = value["adventure_type"];
                                var adventureInfo = getAdventureTypeById(adventure_type);
                                var infoText = adventureInfo.text;
                                adventure_type_data.push(infoText);
                            });
                        }
                        adventure_type_data = (Object.keys(adventure_type_data).length) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Que existe en la ruta:</span><span class='content-description__value'>" + (adventure_type_data.join()) + "</span>",
                            "</div>",

                        ] : [];
                        adventure_type_data = adventure_type_data.join("");

                        var typeShortcutData = getShortCutById(row.type_shortcut);
                        var result = [
                            "<div    class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + (typeShortcutData["text"]) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'>" + (row.status == "ACTIVE" ? "ACTIVO" : "INACTIVO") + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre</span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",
                            adventure_type_data,
                            description,
                            "<div class='content-description__information'>",
                            "   <img class='content-description__image' src='" + $resourceRoot + row.src + "'>",
                            "</div>",
                            "</div>"
                        ];
                        return result.join("");
                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridId, vmCurrent);
            });
        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            };
        },
        _destroyTooltip: function (selector) {
            $(selector).tooltip('hide');
        },
        _gridManager: function (elementSelect, vmCurrent) {
            var paramsGrid = {
                gridCurrentSelector: vmCurrent.gridSelectorCurrent
            };

            var selectorIdGrid = $(elementSelect).attr("id");
            var selectorCurrentTrManager = "#" + selectorIdGrid + " tbody tr";
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var rowId = dataRowId;
                var currentRowSelector;
                if (dataRowId) {
                    var instance_data_rows = $(paramsGrid.gridCurrentSelector).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                    $(currentRowSelector).removeClass("selected");
                    var newEventRow = false;
                    rowData = rowData[0];
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {

                        currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                        $(currentRowSelector).addClass("selected");
                        vmCurrent.managerMenuConfig = {
                            view: true,
                            menuCurrent: vmCurrent.getMenuConfigGridRow({rowData: rowData, rowId: dataRowId}),
                            rowId: dataRowId
                        };


                    }

                }

            });
        },
        /*---MODAL CURRENT--*/
        _closeModal: function () {
            closeModal();
        },
        initCurrentComponent: function () {

            this.initMap();
            this._initEventsUpload();
            this.initGridManager(this);

        },
        initMap: function () {
            BlitzMap = new UtilBlitzMap(
                {
                    isEditable: true,
                    currentManager: this
                }
            );

            BlitzMap.setMap('myMap', true, 'mapData');
            mapObjCurrent = BlitzMap.init(

            );
            this.map = mapObjCurrent;
            var mapCurrent = mapObjCurrent;
            var paramsAutocomplete = {mapCurrent: mapCurrent, marker: null, dataCurrent: []};
            this._initAutocomplete(paramsAutocomplete);
        },
        _initAutocomplete: function (params) {
            // Create the autocomplete object, restricting the search predictions to
            // geographical location types.

            var elementId = 'search-map-current';
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById(elementId), {types: ['geocode']});
            var mapCurrent = params['mapCurrent'];
            var mapInit = mapCurrent;
            var markerInit = params.marker;
            // Avoid paying for data that you don't need by restricting the set of
            // place fields that are returned to just the address components.
            autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);
            autocomplete.bindTo('bounds', mapInit);
            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            var _this = this;

            autocomplete.addListener('place_changed', function () {
                _this.fillInAddress({
                    autocomplete: this,
                    map: mapInit,
                    marker: markerInit
                });
            });
        },
        fillInAddress: function (params) {
            var map = params.map;
            var marker = params.marker;
            var autocomplete = params.autocomplete;

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.settitle(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            if (marker) {
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            }

        },
        _setMapFromEncoded: function () {
            BlitzMap.setMapFromEncoded(document.getElementById('encodedData').value);
        },
        _deleteAll: function () {
            BlitzMap.deleteAll();
            this.setDataFormKml();
            $("#file_upload").val(null);
        },
        _toggleEditable: function () {
            BlitzMap.toggleEditable();
        },
        _generateMapText: function () {
            var resultData = BlitzMap.getDataMapLayersConfig();
        },
        _generateKML: function () {
            BlitzMap.toKML();
        },
        _setMapFromKML: function () {
            BlitzMap.setMapFromKML(document.getElementById('kmlString').value);
        },

        //upload image
        _uploadDataImage: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.image).click();
            event.stopPropagation();
        },
        //upload kml
        _uploadData: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.file).click();
            event.stopPropagation();

        },
        setValuesKmlConfigForm: function (params) {

            var resultData = BlitzMap.getDataMapLayersConfig();
            var resultKML = params.resultKML;
            var nameRoute = resultKML.optionsKml.nameRoute;
            var descriptionRoute = resultKML.optionsKml.descriptionRoute;
            this.modelRoutes.attributes["name"] = nameRoute;
            this.modelRoutes.attributes["description"] = descriptionRoute;
            this.$v["modelRoutes"]["attributes"].description.$model = descriptionRoute;
            this.$v["modelRoutes"]["attributes"].name.$model = nameRoute;
            this.setValuesKml(resultData, true);


        },
        setValuesKml: function (resultKML, upload = false) {
            var kml_structure = this.getDataKmlString({
                resultData: resultKML
            });
            kml_structureResult = null;
            if (Object.keys(kml_structure.routes_drawing_data).length > 0) {
                kml_structureResult = JSON.stringify(kml_structure);
            }
            this.modelRoutes.attributes.kml_structure = (kml_structureResult);
        },
        _initEventsUpload: function () {
            var _this = this;
            var progress = document.querySelector('.percent');
//------------GESTION DE SUBIDA D IMAGENS---
            $(this.uploadConfig.uploadElementsSelectors.file).change(function () {
                var file = $(this)[0].files[0];
                progress.style.width = '0%';
                progress.textContent = '0%';
                if (file) {
                    if (file.type == "") {//format kml
                        var reader = new FileReader();
                        // Closure to capture the file information.
                        reader.readAsText(file);
                        _addListenerReaderUpload(reader);
                    } else {
                        alert("Formato no valido debe ser .kml");
                    }
                }
                return false;
            });
            $(this.uploadConfig.uploadElementsSelectors.image).change(function () {
                var file = $(this)[0].files[0];
                if (file) {
                    if (file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/svg+xml") {//format kml
                        var srcSource = window.URL.createObjectURL(file);
                        $(_this.uploadConfig.viewUpload.image).attr("src", srcSource);
                        _this.modelRoutes.attributes.src = file;
                        if (_this.modelRoutes.attributes.id) {
                            _this.modelRoutes.attributes.change = true;

                        }

                    } else {
                        alert("No es una imagen.");
                    }
                }
                return false;
            });

            function _addListenerReaderUpload(reader) {
                reader.addEventListener('loadstart', _readerUpload);
                reader.addEventListener('load', _readerUpload);
                reader.addEventListener('loadend', _readerUpload);
                reader.addEventListener('progress', _readerUpload);
                reader.addEventListener('error', _readerUpload);
                reader.addEventListener('abort', _readerUpload);
            }

            function _readerUpload(event) {

                if (event.type === "load") {
                    progress.style.width = '100%';
                    progress.textContent = '100%';
                    setTimeout("document.getElementById('progress_bar').className='';", 1000);
                    var nodesCurrent = $.parseHTML(event.target.result);
                    var params = {haystack: nodesCurrent, type: "fileReader"};
                    var resultKML = getKMLUpload(params);
                    var resultKMLString = resultKML.kmlString;
                    var resultKMLLayers = resultKML.object;
                    if (false) {
                        $("#kmlString").val(resultKMLString);
                        _this._setMapFromKML();
                    } else {
                        /* _this._deleteAll();*/
                        var rowCurrent = resultKML.optionsKml;
                        _this.setStructureLayers({
                            haystack: resultKMLLayers,
                            routeInformation: rowCurrent,
                            typeGetData: false
                        });
                    }
                } else if (event.type === "loadend") {

                } else if (event.type === "abort") {

                } else if (event.type === "loadstart") {
                    document.getElementById('progress_bar').className = 'loading';

                } else if (event.type === "error") {
                    switch (event.target.error.code) {
                        case event.target.error.NOT_FOUND_ERR:
                            alert('File Not Found!');
                            break;
                        case event.target.error.NOT_READABLE_ERR:
                            alert('File is not readable');
                            break;
                        case event.target.error.ABORT_ERR:
                            break; // noop
                        default:
                            alert('An error occurred reading this file.');
                    }
                    ;
                } else if (event.type === "progress") {
                    if (event.lengthComputable) {
                        var percentLoaded = Math.round((event.loaded / event.total) * 100);
                        // Increase the progress bar length.
                        if (percentLoaded < 100) {
                            progress.style.width = percentLoaded + '%';
                            progress.textContent = percentLoaded + '%';
                        }
                    }
                }
            }

        }
    },
    props: {
        parentData: {
            type: String,
            default: function () {
                return '';
            }
        }
        ,
        title: {
            type: String
        }
        ,
        messageParent: {
            type: String
        }
        ,
        params: {
            type: Object,
        },
        titleEvent: {
            type: String
        }

    }
    ,
    beforeMount() {
        this.configParams = this.params;
        // this.businessId = this.configParams.business_id;
        this.businessId = $businessManager.id;

    }
});

