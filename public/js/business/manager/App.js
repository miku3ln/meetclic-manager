/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * https://fullcalendar.io/docs/vue
 * BUSINESS-MANAGER-MENU-JS
 */
let init_map = false;
let map;
let markers_opens = [];
let myLatlng = {lat: 0.2314799, lng: -78.271874};
let zoom = 15;

let currentWulpy = null;
if (typeof (WulpyMapUtil) != 'undefined') {
    /* let currentWulpy = new WulpyMapUtil({
         myLatlng: myLatlng,
         zoom: zoom,
         markers: markers,
         init_map: init_map,

     });*/
}
let appThis = null;
/*https://codepen.io/laylajune/pen/OXzBWg*/
let appInit = new Vue(
        {
            directives: {
                "_upload-resource": {
                    inserted: function (el, binding, vnode, vm, arg) {
                        let paramsInput = binding.value;
                        paramsInput._initEventsUpload({
                            objSelector: el
                        });

                    }
                },

            },
            created: function () {
                let vmCurrent = this;
                this.$root.$on("_updateParentByChildren", function (emitValue) {
                    vmCurrent._managerTypes(emitValue);

                });
            },
            mounted: function () {
                console.log("mounted");
                this.initCurrentComponent();
                appThis = this;
                this.initMenuCurrent();
                removeClassNotView();

            },
            el: '#app-management',
            created: function () {

                let modelData = Object.keys($modelDataManager["business"]).length > 0 ? $modelDataManager["business"][0] : null;
                if (modelData) {
                    if (Object.keys(modelData).length > 0) {
                        this.setValuesModelBusiness({
                            modelData: modelData
                        });
                    }

                }
            },
            data: {
                //MENU
                menuCurrent: [],
                modelDataManager: [],
                businessCreate: false,
                btnRegisterLabel: 'Registrarse',
                msj: {
                    value: "",
                    view: false
                },
                business: [],
                initLoadData: false,
                initDataRows: {
                    count: 0,
                },
                showModal: false,
                mapCurrent: null,
                latLngCurrent: myLatlng,
                titleModal: "Creación de Empresa",
                errors: [],
                name: null,
                age: null,
                movie: null,
                counter: 0,
                title: "Hola",
                lblUploadName: "Subir Imagen.",
                modelBusiness: {
                    id: null,
                    street_lat: null,
                    street_lng: null,
                    business_subcategories_id: null,
                    title: null,
                    phone_value: null,
                    street_1: null,
                    street_2: null,
                    page_url: null,
                    description: null,
                    countries_id: null,
                    email: null,
                    "source": null,
                    change: false
                },
                business_id: null,
//VM-002
                /*---CONFIG TABS----*/
                /*---   6.1)Config Menu  App Main----*/
                configModulesAllow: $configModulesAllow,
                //CONFIG DATA BY BUSINESS VM-001
                managerProcessBusiness: $managerProcessBusiness,

            },
            methods: {
                ...$methodsFormValid,

                managerProcessActive: function (processName) {
                    let vm = this;
                    if (vm.configModulesAllow.hasOwnProperty(processName)) {
                        vm.configModulesAllow[processName].active = true;
                    } else {
                        console.log("no s ha configurado ");
                    }
                },
                //menu
                initMenuCurrent: function () {
                    let vm = this;
                    let menuProcess = $configPartial['menuCurrent']['menu'];
                    let processName;
                    if ($configPartial['menuCurrent']['configModulesAllow']['allow']) {
                        if ($configPartial['menuCurrent']['configModulesAllow']['isParent']) {
                            processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyParent'];
                            vm.managerProcessActive(processName);

                        } else {
                            processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyChildren'];
                            vm.managerProcessActive(processName);

                        }
                    }

                    this.menuCurrent = this.getMenuCurrent(menuProcess);
                }
                ,
                resetMenuActives: function () {
                    let _this = this;
                    $.each(this.menuCurrent, function (key, value) {
                        let isParent = value.isParent;
                        _this.menuCurrent[key]['active'] = false;
                        if (isParent) {
                            $.each(value.parentData, function (keyChildren, valueChildren) {
                                _this.menuCurrent[key]['parentData'][keyChildren]['active'] = false;
                            });
                        }
                    });

                }
                ,
                _menuItem: function (typeMenu, url) {
                    if ($('body').hasClass('m-aside-left--minimize')) {

                        let managerUrl = url;
                        window.location.href = managerUrl;
                    }
                }
                ,
                _menuCurrent: function (typeManager, menu, indexParent, menuChildren, indexChildren) {
                    let vm = this;
                    let processNameIndex;
                    this.resetMenuActives();
                    if (typeManager) {//only menu
                        processNameIndex = menu.type;
                        $.each(this.configModulesAllow, function (key, value) {
                            if (key == processNameIndex) {
                                vm.configModulesAllow[key].active = true;
                            } else {
                                vm.configModulesAllow[key].active = false;

                            }
                        });
                        $.each(this.menuCurrent, function (key, value) {
                            if (key == indexParent) {
                                vm.menuCurrent[key].active = true;

                            }
                        });
                    } else if (typeManager == false) {//childrens
                        processNameIndex = menuChildren.type;
                        $.each(this.configModulesAllow, function (key, value) {
                            if (key == processNameIndex) {
                                vm.configModulesAllow[key].active = true;
                            } else {
                                vm.configModulesAllow[key].active = false;

                            }
                        });
                        $.each(this.menuCurrent, function (key, value) {
                            if (key == indexParent) {
                                vm.menuCurrent[key].active = true;
                                if (value.isParent) {
                                    $.each(value.parentData, function (keyChildren, valueChildren) {
                                        if (keyChildren == indexChildren) {
                                            vm.menuCurrent[key]["parentData"][keyChildren].active = true;
                                        }
                                    });
                                }
                            }


                        });
                    }
                }
                ,
                getIconClassMenu: function (menu, indexParent, indexChildren) {
                    let ovrOptions = new Object();
                    ovrOptions[menu.icon] = menu.icon ? true : false;
                    let result = menu.icon;
                    return result;
                }
                ,
                menuInitSaveFirst: function () {
                    this.initMenuCurrent();

                }
                ,
                getMenuCurrent: function (haystack) {
                    let result = [];
                    $.each(haystack, function (key, value) {
                        let setPush;
                        if (value.isParent) {

                            let parentDataAux = value.parentData;
                            let setPushDataParent = [];
                            $.each(parentDataAux, function (keyChildren, valueChildren) {
                                if (value.allow) {
                                    setPush = {
                                        title: valueChildren.title,
                                        allow: valueChildren.allow,
                                        type: keyChildren,
                                        active: true,
                                        isParent: false,
                                        urlCurrent: valueChildren.urlCurrent,
                                    };

                                    setPushDataParent.push(setPush);
                                }

                            });

                            setPush = {
                                title: value.title,
                                allow: value.allow,
                                type: key,
                                active: true,
                                isParent: value.isParent,
                                icon: value.icon,
                                parentData: setPushDataParent
                            };
                            result.push(setPush);
                        } else {
                            if (value.allow) {
                                setPush = {
                                    title: value.title,
                                    allow: value.allow,
                                    type: key,
                                    active: true,
                                    isParent: value.isParent,
                                    icon: value.icon,
                                    urlCurrent: value.urlCurrent,

                                };

                                result.push(setPush);
                            }
                        }
                    });
                    return result;
                }
                ,
                /*FORM*/
                _submitForm: function (e) {
                    console.log(e);
                }
                ,
                initCurrentComponent: function () {

                }
                ,
                _initEventsUpload: function () {
                    let _this = this;
                    $(this.uploadConfig.uploadElementsSelectors.file).change(function () {
                        let file = $(this)[0].files[0];
                        if (file) {
                            if (file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/svg+xml") {//format kml
                                let reader = new FileReader();
                                srcSource = window.URL.createObjectURL(file);
                                $(".content-box-image__preview").attr("src", srcSource);
                                _this.modelBusiness.source = file;
                                if (_this.businessCreate) {
                                    _this.modelBusiness.change = true;
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
                            console.log(" ready", event.target.result);
                        } else if (event.type === "loadend") {

                        } else if (event.type === "abort") {
                            console.log("abort");
                        } else if (event.type === "loadstart") {
                            console.log("loadstart");

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
                        } else if (event.type === "progress") {

                            console.log("progress", event.loaded);
                            if (event.lengthComputable) {
                                let percentLoaded = Math.round((event.loaded / event.total) * 100);
                                // Increase the progress bar length.
                                if (percentLoaded < 100) {

                                }
                            }
                        }
                    }

                }
                ,
                uploadResourceAjax: function () {
                    url_action_upload = $("#uploadResourceBusiness").val();
                    let paramsUpload = {
                        managerUploadSelector: "#container_selector_image",
                        managerProgressSelector: ".progress-business",
                        url_action_upload: url_action_upload,
                        element: _this.uploadConfig.uploadElementsSelectors.file.split("#")[1],
                        successCall: function (response) {
                            if (response.success) {

                            } else {

                            }
                        }
                    };
                    uploadResource(paramsUpload);
                }
                ,
                _uploadData: function (event) {
                    $(this.uploadConfig.uploadElementsSelectors.file).click();
                    event.stopPropagation();

                },
                setManagerBusinessInformationProcess: function (params) {
                    let modelData = params.modelData;
                    let haystack = this.managerProcessBusiness;
                    for (let item in haystack) {
                        this.managerProcessBusiness[item].business_id = modelData.id;
                    }
                }
                ,
                setValuesModelBusiness: function (params) {// VM-001-001
                    this.setManagerBusinessInformationProcess(params)
                    //CPP-0113
                    /* 6.4)Events(Click) Config Params let iables send to components [setValuesModelBusiness]*/
                    let modelData = params.modelData;
                    this.business_id = modelData.id;
                    this.modelBusiness = modelData;
                    this.modelBusiness.source = modelData.source;
                    this.businessCreate = true;
                    let srcSource = this.modelBusiness.source;
                    this.managerProcessBusiness.configDataGamificationTypeActivity.data = modelData;
                    this.managerProcessBusiness.managerChat[0].url = this.getUrlContact();


                },
                _setChat: function () {
                    this.managerChat[0].url = this.getUrlContact();
                },
                getBusinessId: function () {
                    let business_id = Object.keys($modelDataManager["business"]).length > 0 ? $modelDataManager["business"][0]["id"] : null;
                    return business_id;
                },
                /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                _updateParentByChildren: function (params) {
                    console.log(params);
                },
                _routeProcess: function (params) {
                    /*  this.$refs.childRoutes._setValueOfParent(params);*/
                },
                _saveBusiness: function () {
                    _this = this;
                    let businessInfo;
                    if (
                        this.modelBusiness.business_subcategories_id
                        && this.modelBusiness.phone_value
                        && this.modelBusiness.title
                        && this.modelBusiness.street_1
                        && this.modelBusiness.street_2
                        && this.modelBusiness.countries_id
                        && this.modelBusiness.email
                        && this.modelBusiness.description
                        && this.modelBusiness.source
                    ) {
                        name_manager = "Negocio";

                        if (this.businessCreate) {//update
                            businessInfo = {
                                id: this.business_id,
                                street_lat: this.latLngCurrent.lat,
                                street_lng: this.latLngCurrent.lng,
                                business_subcategories_id: this.modelBusiness.business_subcategories_id,
                                title: this.modelBusiness.title,
                                phone_value: this.modelBusiness.phone_value,
                                street_1: this.modelBusiness.street_1,
                                street_2: this.modelBusiness.street_2 ? this.modelBusiness.street_2 : "",
                                page_url: this.modelBusiness.page_url ? this.modelBusiness.page_url : "",
                                description: this.modelBusiness.description ? this.modelBusiness.description : "",
                                wulpyme_user_id: $wulpyme_user_id,
                                source: this.modelBusiness.source,
                                change: this.modelBusiness.change,
                                email: this.modelBusiness.email,
                                countries_id: this.modelBusiness.countries_id
                            };

                        } else {//create
                            businessInfo = {
                                street_lat: this.latLngCurrent.lat,
                                street_lng: this.latLngCurrent.lng,
                                business_subcategories_id: this.modelBusiness.business_subcategories_id,
                                title: this.modelBusiness.title,
                                phone_value: this.modelBusiness.phone_value,
                                street_1: this.modelBusiness.street_1,
                                street_2: this.modelBusiness.street_2 ? this.modelBusiness.street_2 : "",
                                page_url: this.modelBusiness.page_url ? this.modelBusiness.page_url : "",
                                description: this.modelBusiness.description ? this.modelBusiness.description : "",
                                wulpyme_user_id: $wulpyme_user_id,
                                source: this.modelBusiness.source,
                                change: this.modelBusiness.change,
                                email: this.modelBusiness.email,
                                countries_id: this.modelBusiness.countries_id

                            };

                        }

                        this.setCurrentLatLngForm(this.latLngCurrent);

                        form_manager = $("#business-form");
                        let dataManager = businessInfo;
                        let name_manager = "Negocio";
                        ajaxRequest($('#action_business_save').val(), {
                                type: 'POST',
                                data: dataManager,
                                blockElement: '#tab-business',//opcional: es para bloquear el elemento
                                loading_message: 'Guardando...',
                                error_message: 'Error al guardar el ' + name_manager,
                                success_message: 'El ' + name_manager + ' se guardo correctamente',
                                success_callback: function (response) {


                                    let modelData = response.modelData;
                                    if (!_this.businessCreate) {
                                        _this.businessCreate = true;
                                        _this.menuInitSaveFirst();
                                    }
                                    _this.setValuesModelBusiness({
                                        modelData: modelData
                                    });


                                }
                            }, true
                        );

                    }

                    this.errors = [];

                    if (
                        !this.modelBusiness.street_lat
                        || !this.modelBusiness.street_lng
                        || !this.modelBusiness.business_subcategories_id
                        || !this.modelBusiness.phone_value
                        || !this.modelBusiness.street_1
                        || !this.modelBusiness.street_2
                        || !this.modelBusiness.countries_id
                        || !this.modelBusiness.email
                        || !this.modelBusiness.description
                        || !this.modelBusiness.source
                    ) {

                        if (!this.modelBusiness.business_subcategories_id) {
                            this.errors.push("Subcategoria es requerido.");

                        }
                        if (!this.modelBusiness.phone_value) {
                            this.errors.push("Telefono es requerido.");

                        }
                        if (!this.modelBusiness.street_1) {
                            this.errors.push("Calle principal  es requerido.");

                        }
                        if (!this.modelBusiness.street_1) {
                            this.errors.push("Calle secundaria  es requerido.");

                        }
                        if (!this.modelBusiness.title) {
                            this.errors.push("Empresa  es requerido.");

                        }
                        if (!this.modelBusiness.countries_id) {
                            this.errors.push("Pais  es requerido.");

                        }
                        if (!this.modelBusiness.email) {
                            this.errors.push("Email  es requerido.");

                        }
                        if (!this.modelBusiness.description) {
                            this.errors.push("Descripcion  es requerido.");

                        }
                        if (!this.modelBusiness.source) {
                            this.errors.push("Imagen es requerido.");

                        }
                    }

                }
                ,
                getModelBusiness: function () {
                    let resultData = null;
                    this.modelDataManager = $modelDataManager;
                    this.businessCreate = (Object.keys($modelDataManager["business"]).length > 0);
                    if (this.businessCreate) {
                        let modelBusiness = $modelDataManager["business"][0];
                        resultData = modelBusiness;
                    }
                    return resultData;
                }
                ,
                setConfigurationMap: function (valuesCurrent = null, createUpdate) {
                    let currentLtLng;
                    let _this = this;
                    let marker_object;
                    if (!createUpdate) {//update
                        this.initDataRows.count = 1;
                        let title = valuesCurrent.title;
                        let lat = valuesCurrent.street_lat;
                        let lng = valuesCurrent.street_lng;
                        let business_subcategories_id = valuesCurrent.business_subcategories_id;
                        let subcategory = getSubCategory(business_subcategories_id);
                        let urlIcon = "";
                        if (!subcategory) {
                            urlIcon = "https://furtaev.ru/preview/user_on_map.png";

                        } else {
                            urlIcon = subcategory.marker;
                        }
                        let content = "<div>" + title + "</div>";
                        let width = 30, height = 40;

                        let iconCurrent = {
                            url: urlIcon,
                            scaledSize: new google.maps.Size(width, height), // scaled size
                            origin: new google.maps.Point(0, 0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        };
                        marker_object = new google.maps.Marker({
                            draggable: true,
                            title: title,
                            animation: google.maps.Animation.DROP,
                            position: new google.maps.LatLng(lat, lng),
                            icon: iconCurrent,
                            content: content
                        });
                        let params_data = {map: map, marker: marker_object, content: content};
                        currentWulpy.addMarker(params_data);
                        _this._markersCurrent(marker_object);
                        let index = valuesCurrent.index;
                        _this.modelBusiness = valuesCurrent;
                        _this.modelBusiness["keyRef"] = index;
                        myLatlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
                        currentLtLng = new google.maps.LatLng(lat, lng);
                        map.setCenter(myLatlng);

                    } else {
                        this.initDataRows.count = 0;
                        let title = "Mueva el marker";
                        let lat = myLatlng.lat;
                        let lng = myLatlng.lng;
                        let width = 30, height = 40;
                        let iconCurrent = {
                            url: "https://furtaev.ru/preview/user_on_map.png",
                            scaledSize: new google.maps.Size(width, height), // scaled size
                            origin: new google.maps.Point(0, 0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        };
                        let content = "<div>" + title + "</div>";
                        marker_object = new google.maps.Marker({
                            draggable: true,
                            title: title,
                            animation: google.maps.Animation.tweeners,
                            position: new google.maps.LatLng(lat, lng),
                            icon: iconCurrent,
                            content: content
                        });
                        let params_data = {map: map, marker: marker_object, content: content};


                        currentWulpy.addMarker(params_data);
                        _this._markersCurrent(marker_object);

                        currentLtLng = new google.maps.LatLng(lat, lng);

                    }

                    this.mapCurrent.setCenter(currentLtLng);
                    let mapCurrent = this.mapCurrent;
                    let paramsAutocomplete = {mapCurrent: mapCurrent, marker: marker_object};
                    this._initAutocomplete(paramsAutocomplete);
                }
                ,
                _initAutocomplete: function (params) {
                    // Create the autocomplete object, restricting the search predictions to
                    // geographical location types.initMenuCurrent

                    let elementId = 'search-map-current';
                    autocomplete = new google.maps.places.Autocomplete(
                        document.getElementById(elementId), {types: ['geocode']});
                    let mapCurrent = params['mapCurrent'];
                    let mapInit = mapCurrent;
                    let markerInit = params.marker;
                    // Avoid paying for data that you don't need by restricting the set of
                    // place fields that are returned to just the address components.
                    autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);
                    autocomplete.bindTo('bounds', mapInit);
                    // When the user selects an address from the drop-down, populate the
                    // address fields in the form.
                    let _this = this;

                    autocomplete.addListener('place_changed', function () {
                        _this.fillInAddress({
                            autocomplete: this,
                            map: mapInit,
                            marker: markerInit
                        });
                    });
                }
                ,
                fillInAddress: function (params) {
                    let map = params.map;
                    let marker = params.marker;
                    let autocomplete = params.autocomplete;

                    // Get each component of the address from the place details,
                    // and then fill-in the corresponding field on the form.
                    let place = autocomplete.getPlace();
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
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);  // Why 17? Because it looks good.
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                }
                ,
                initMapCurrent: function () {
                    if (currentWulpy) {


                        this.mapCurrent = currentWulpy.initMap("#map");
                        let dataMarker = this.getModelBusiness();
                        let createUpdate = true;
                        if (dataMarker) {
                            createUpdate = false;
                        }
                        this._mapCurrent({
                            mapCurrent: this.mapCurrent,
                            initMarker: {data: dataMarker, createUpdate: createUpdate}
                        });

                        let currentLtLng;
                        if (dataMarker) {
                            currentLtLng = {lat: dataMarker.street_lat, lng: dataMarker.street_lng};

                        } else {

                            currentLtLng = {lat: myLatlng.lat, lng: myLatlng.lng};

                        }
                        this.setPositionMapCenter(currentLtLng);
                        $.each(markers, function (key, value) {
                            value.setMap(null);
                        });
                        this.setConfigurationMap(dataMarker, createUpdate);
                        markers = [];
                    }
                }
                ,
                initManagement: function () {

                    let dataMarker = this.getModelBusiness();
                    let createUpdate = true;
                    if (dataMarker) {
                        this.modelBusiness = dataMarker;
                        createUpdate = false;
                        this.initDataManagerBusiness(dataMarker);
                        this.managerProcessBusiness.configDataSchedules["schedules"] = $modelDataManager["schedules"];
                    } else {
                        this.managerProcessBusiness.configDataSchedules["schedules"] = [
                            {
                                id: "monday", name: "monday", text: "Lunes", modelDay: false,
                                configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "tuesday", name: "tuesday", text: "Martes", modelDay: false,
                                configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "wednesday",
                                name: "wednesday",
                                text: "Miercoles",
                                modelDay: false,
                                configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "thursday", name: "thursday", text: "Jueves", modelDay: false, configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "friday", name: "friday", text: "Viernes", modelDay: false, configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "saturday", name: "saturday", text: "Sabado", modelDay: false, configTypeSchedule: {
                                    type: false,//24 hours
                                    data: []
                                },
                            },
                            {
                                id: "sunday", name: "sunday", text: "Domingo", modelDay: false, configTypeSchedule: {
                                    type: false,//24 hours

                                    data: []
                                },
                            }
                        ];
                    }


                }
                ,
                setPositionMapCenter: function (currentLtLng) {
                    currentLtLng = new google.maps.LatLng(parseFloat(currentLtLng.lat), parseFloat(currentLtLng.lng));
                    this.mapCurrent.setCenter(currentLtLng);
                }
                ,
                initDataManagerBusiness: function (data) {
                    this.titleModal = data.title;
                }
                ,
                _mapCurrent: function (params) {

                    mapCurrent = params.mapCurrent;
                    let _this = this;
                    let geocoder = new google.maps.Geocoder();
                    mapCurrent.addListener('idle', function () {

                    });
//----clic en l map---
                    google.maps.event.addListener(mapCurrent, 'click', function (e) {
                        cont_fi = 0;
                        lat = e.latLng.lat();
                        lng = e.latLng.lng();
                        let timestamp = new Date().getTime()
                        params = {
                            data: {lat: lat, lng: lng, timestamp: timestamp, cont_fi: cont_fi},
                            bdd_node: "coordenadas"
                        };


                        geocoder.geocode({'latLng': e.latLng}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                    console.log(results[1].formatted_address);
                                    console.log(results);

                                }
                            } else {
                                alert("Geocoder failed due to: " + status);
                            }
                        });

                    });
                    google.maps.event.addListener(mapCurrent, 'dblclick', function (e) {
                        console.log("addListener map_data dblclick");

                    });


                    google.maps.event.addListener(mapCurrent, 'mouseup', function (e) {
//            console.log("addListener map_data mouseup");

                    });
                    google.maps.event.addListener(mapCurrent, 'mousedown', function (e) {
//            console.log("addListener map_data mousedown");

                    });
                    google.maps.event.addListener(mapCurrent, 'mouseover', function (e) {
//            console.log("addListener map_data mouseover");

                    });
                    google.maps.event.addListener(mapCurrent, 'mouseout', function (e) {
//            console.log("addListener map_data mouseout");

                    });
                    mapCurrent.addListener('zoom_changed', function () {

                    });
                    mapCurrent.addListener('drag', function () {

                    });
                    mapCurrent.addListener('center_changed', function () {

                    });
                }
                ,
                _markersCurrent: function (marker) {
                    let _this = this;
                    // Add dragging event listeners.
                    google.maps.event.addListener(marker, 'dragstart', function () {
                        console.log("dragstart");
//            updateMarkerAddress('Dragging...');

                    });

                    google.maps.event.addListener(marker, 'drag', function () {
                        _this.latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
                        currentLtLng = _this.latLngCurrent;


                    });

                    google.maps.event.addListener(marker, 'dragend', function () {

                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        if (false) {

                            let infoWindowOptions = {
                                content: marker.content
                            };
                            let infoWindow = new google.maps.InfoWindow(infoWindowOptions);
                            infoWindow.open(map, marker);
                        }

                        _this.latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};

                        _this._viewModalManager({lng: marker.getPosition().lng(), lat: marker.getPosition().lat()});

                        currentLtLng = _this.latLngCurrent;

                        window.setTimeout(function () {
                            _this.setPositionMapCenter(currentLtLng);
                        }, 1000);
                    });
                }
                ,
                _viewModalManager: function () {

                }
                ,
                setCurrentLatLngForm: function (latLngCurrent) {
                    let element = $("#business_street_lat");
                    element.val(latLngCurrent.lat);
                    element = $("#business_street_lng");
                    element.val(latLngCurrent.lng);
                },
                getUrlContact: function () {
                    let params = {
                        dataParams: {
                            phone: '+593' + this.modelBusiness.phone_value,
                            text: this.modelBusiness.description,
                        }


                    };
                    let urlCurrent = 'https://web.whatsapp.com/send?' + getStringParamsGet(params);
                    let result = urlCurrent;
                    /*      let  result = 'https://web.whatsapp.com/send?phone=+593989351482&amp;text=Deseo%20m%C3%A1s%20informaci%C3%B3n%20de:%20%20https://cuponcity.ec/quito/belleza/renueva-imagen-y-luce-cambio-look-genia-retoque-mechas-1-corte-puntas-make-beauty';*/
                    return result;
                }


            }
        })
;
appInit.initManagement();

function showResults(snap) {
    if (snap) {
        console.log(snap.val());
    }
}

function errors(snap) {
    console.log(snap);
}

function closeModal() {
    appInit.$refs.myModalRef.hide();
}

function removeClassNotView() {
    $(".manager-process.not-view").removeClass('not-view');
}


function getStringParamsGet(params) {
    let dataParams = params['dataParams'];
    let recursiveDecoded = decodeURIComponent($.param(dataParams));
    return recursiveDecoded;
}

function ManagerModel() {
    function getManagerData(nameProcess) {
        let haystack = nameProcess.split('-');
        let managerInfo = [];
        let managerInfoLowerFirst = [];

        $.each(haystack, function (index, value) {
            let managerString = value.charAt(0).toUpperCase() + value[0].slice(1);
            managerInfo.push(managerString);
            if (index === 0) {
                managerString = value;
                managerInfoLowerFirst.push(managerString);
            } else {
                managerInfoLowerFirst.push(managerString);

            }

        });

        return {
            modelNameLowerFirst: managerInfoLowerFirst.join(''),
            modelName: managerInfo.join(''),
            modelProcess: nameProcess,

        };


    }
}


