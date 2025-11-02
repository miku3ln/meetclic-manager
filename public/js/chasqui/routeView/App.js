/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Define a new component called button-counter
var init_map = false;
var map;
var markers_opens = [];
var myLatlng = {lat: 0.2314799, lng: -78.271874};
var zoom = 15;
var markers = [];
mapOverlays = [];
$(window).resize(function () {
    setConfigMap();
    initHeaderSticky();
});

function getConfigMap() {
    result = {
        width: $(window).width(),
        height: $(window).height() - $('.header-area').height(),
    }
    return result;
}

function setConfigMap() {
    var config = getConfigMap();
    var porcent = config.height * 0.2 / 100;
    $("#map").css({"widht": config.width + "px", "height": (config.height - porcent) + "px"});
}

var currentWulpy = new WulpyMapUtil();
var infoWindow = null;
// explicit installation required in module environments
/*Vue.use(VueFire);*/
const app = new Vue(
    {
        el: '#app-management',
        data: {

            btnRegisterLabel: 'Registrarse',
            titleModal: "Creación de Empresa",
            msj: {
                value: "",
                view: false
            },
            business: [],
            initLoadData: false,
            initDataRows: {
                count: 0,
            },
            mapCurrent: null,
            map: null,
            modelBusiness: {},
            /*PANORAMA*/
            configDataPanorama: [],
            routeConfigCurrent: null,
            /*Information*/
            configDataInformation: {
                title: $dataRoute["information"]["name"],
                description: $dataRoute["information"]["description"],
                configDataAdventureType: {
                    title: "Que existe en la Ruta.",
                    data: $dataRoute["adventure_type_data"]
                }
            },
            //VIEW DETAILS
            configDataViewMarkerInformation: {
                data: [],
                view: false
            },
            configDataLegend: {
                title: "Legend Map",
                dataLegend: [

                    {
                        type: 0,//line
                        title: "Lineas Clasificación",
                        data: [
                            {
                                icon: pathDevelopers + "assets/images/legend/line3.jpg",
                                title: "Via Asfaltada",
                                type: 1,
                            },
                            {
                                icon: pathDevelopers + "assets/images/legend/line1.png",
                                title: "Via Empedrada",
                                type: 1,
                            },
                            {
                                icon: pathDevelopers + "assets/images/legend/line2.png",
                                title: "Via Transitable",
                                type: 1,
                            },

                        ]
                    }

                ]
            },
            infWindow: null,
            configDataRoutesDrawing: {
                view: false,
                data: [],
            }
        },
        methods: {
            ...$methodsFormValid,
            _emitParentToChildren: function (paramsData) {


                var params = {
                    nameEvent: "_initPanorama",
                    nameComponent: "App",
                    data: paramsData

                };
                this.$refs._emitParentToViewMarkerInformation.$refs._emitParentToPanorama._updateChildrenByParent(params);

            },
            /* ------VIEW INFORMATION MARKER------*/

            _viewModalManager: function (params) {

                var currentMarkerId = params["marker"]["rd_id"];
                var resultMarkers = $dataBusiness["dataPanorama"].filter(function (index) {
                    return index.routes_drawing_id == currentMarkerId;
                });

                if (getObjectLength(resultMarkers) > 0) {
                    this._emitParentToChildren(params);
                    $("#container-data").addClass("active-search");
                    this.setValueRoutesDrawing({type: "panorama"});


                } else {//only window
                    this.setValueRoutesDrawing({marker: params.marker, type: "viewMarker"});

                }
            },
            setValueRoutesDrawing: function (params) {
                var dataSend = params.data;
                var type = params.type;

                var data = [];
                var nameComponent = "App";
                var nameEvent = "configDataManager";
                if (this.configDataRoutesDrawing.view) {
                    this.configDataRoutesDrawing.view = false;
                    data = [];
                    this.configDataRoutesDrawing.data = {
                        title: "",
                        content: ""
                    };
                    data = this.configDataRoutesDrawing;

                } else {
                    if (type == "panorama") {
                        this.configDataRoutesDrawing.view = false;
                        data = [];
                        this.configDataRoutesDrawing.data = {
                            title: "",
                            content: ""
                        };
                        data = this.configDataRoutesDrawing;
                    } else if (type == "latLng") {
                        this.configDataRoutesDrawing.view = false;
                        data = [];
                        this.configDataRoutesDrawing.data = {
                            title: "",
                            content: ""
                        };
                        data = this.configDataRoutesDrawing;
                    } else {
                        this.configDataRoutesDrawing.view = true;
                        this.configDataRoutesDrawing.data = {
                            title: params.marker["title"],
                            content: params.marker["content"]
                        };
                        data = this.configDataRoutesDrawing;
                    }

                }
                var paramsSend = {
                    nameComponent: nameComponent,
                    nameEvent: nameEvent,
                    data: data
                };
                this.$refs._emitParentToRoutesDrawing._updateChildrenByParent(paramsSend);
            },
            openInfoWindow: function (params) {
                var marker = params.marker;
                /*overlay, latLng, content*/
                var div = document.createElement('div');
                var htmlData = replaceAll(marker.content, "&lt;", "<");
                div.innerHTML = [
                    '<div class="content-window">',
                    '   <div class="content-information">',
                    '       <h1 class="content-information__title">',
                    marker.title,
                    '       </h1>',
                    '       <div class="content-information__description">',
                    htmlData,
                    '       </div>',
                    '   </div>',
                    '</div>',
                ].join("");
                var latLng = marker.position;
                setStyle(div, {height: "100%"});
                this.infWindow.setContent(div);
                this.infWindow.setPosition(latLng);
                this.map.panTo(latLng);
                this.infWindow.relatedOverlay = marker;
                this.infWindow.open(this.map);

            },
            _viewModal: function () {
                console.log("show");


            },
            _hideModal: function () {
                console.log("hide");

                $("#container-data").removeClass("active-search");
            },
            getTitleModal: function () {

                return this.configDataViewMarkerInformation.title;
            },
            /*---------ROUTES----*/
            initRoutesDrawing: function (rowCurrent) {
                /*---CONFIG MAP ---*/
                if (rowCurrent["information"]["options_map"]) {

                    this.setStructureLayers({
                        haystack: rowCurrent["haystack"]
                    });
                    var optionsMap = jQuery.parseJSON(rowCurrent["information"]["options_map"]);
                    this.map.panTo(optionsMap.center);
                    this.map.setZoom(optionsMap.zoom);
                }


            },
            setStructureLayers: function (params) {
                latlngData = [];
                var dataLayers = [];
                var mapCurrentRoutes = this.map;
                var optionsCenter = [];
                var haystack = params.haystack;
                _this = this;
                $.each(haystack, function (key, value) {
                    var typeLayer = value["rd_type"];
                    var id = value["id"];
                    var rd_name = value["rd_name"] ? value["rd_name"] : "";
                    var rd_description = value["rd_description"] ? value["rd_description"] : "";
                    var rd_id = value["rd_id"];
                    var routes_drawing_id = value["routes_drawing_id"];

                    var setPush = null;
                    var options = jQuery.parseJSON(value["rd_options_type"]);
                    options = mergeObjects(options, {
                        title: rd_name,
                        type: typeLayer,
                        content: rd_description,
                        id: id,
                        rd_id: rd_id,
                        routes_drawing_id: routes_drawing_id
                    });

                    var path = [];
                    switch (typeLayer) {
                        case "marker":
                            var width = 31, height = 41;
                            var subCategories = getSubcategories();
                            var randData = subCategories[Math.floor(Math.random() * subCategories.length)];
                            var urlIcon = randData.marker;
                            var iconCurrent = {
                                url: urlIcon,
                                scaledSize: new google.maps.Size(width, height), // scaled size
                            };
                            options = mergeObjects(options, {
                                icon: iconCurrent,
                            });
                            path = options.position;
                            setPush = getConfigMarker({
                                options: options,
                                map: mapCurrentRoutes
                            });
                            _this._markersCurrent(setPush);
                            break;
                        case "polygon":
                            path = options.paths[0];//[]
                            options.paths = path;
                            setPush = getConfigPolygon({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;

                        case "polyline":
                            path = options.path;//[]
                            options.path = path;
                            setPush = getConfigPolyline({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;
                        case "rectangle":
                            path = options.bounds;//4 points ne,sw
                            setPush = getConfigRectangle({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;
                        case "circle":
                            path = options.center;//lat-lng
                            setPush = getConfigCircle({
                                options: options,
                                map: mapCurrentRoutes
                            });
                            break;

                    }

                    if (setPush) {
//step 1
                        latlngData.push({
                            type: typeLayer,
                            haystack: path
                        });
                        dataLayers.push(setPush);
                        /*  BlitzMap._layerMap(setPush, mapCurrentRoutes);*/
                        var setPushCenter = getCenterByType({
                            obj: setPush,
                            type: typeLayer,
                            path: path
                        });
                        optionsCenter.push(setPushCenter);
                    }
                });
                //step 2
                mapOverlays = dataLayers;

            },
            initDataCurrent: function () {
                this.business = $dataBusiness.business;
                this.configDataPanorama = {
                    data: $dataBusiness["dataPanorama"],
                    resources: $dataResourcesPanorama
                };
                this.modelBusiness = this.business[0];
            },
            initManagement: function () {
                initHeaderSticky();
                this.initDataCurrent();
                setConfigMap();
                this.mapCurrent = currentWulpy.initMap("#map");
                this.map = this.mapCurrent;
                this.infWindow = new google.maps.InfoWindow();
                this.infWindow.setMap(this.map);
                var routes_drawing_data = $dataRoute["routes_drawing_data"];
                this.initRoutesDrawing({
                    haystack: routes_drawing_data,
                    information: $dataRoute["information"]
                });
                this.routeConfigCurrent = {
                    haystack: routes_drawing_data,
                    information: $dataRoute["information"]
                };
                var dataMarker = [];
                this._mapCurrent({
                    mapCurrent: this.mapCurrent,
                    initMarker: {data: dataMarker, createUpdate: false}
                });

            },
            wulpyMapUtilMethods: function () {
                return WulpyMapUtil();
            },
            _closeModal: function () {

                /*closeModal();*/
            },
            setConfigurationMap: function (params) {
                var _this = this;
                var dataBusinessCurrent = params.dataBusinessCurrent;
                var urlBusiness = "chaskyView/"
                $.each(dataBusinessCurrent, function (index, valuesCurrent) {
                    var title = valuesCurrent.title;
                    var lat = valuesCurrent.street_lat;
                    var lng = valuesCurrent.street_lng;
                    var business_subcategories_id = valuesCurrent.business_subcategories_id;
                    var subcategory = getSubCategory(business_subcategories_id);
                    var urlIcon = "";
                    if (!subcategory) {
                        urlIcon = "https://furtaev.ru/preview/user_on_map.png";

                    } else {
                        urlIcon = subcategory.marker;
                    }
                    var urlCurrent = urlBusiness + valuesCurrent.id;
                    var htmlData = replaceAll(valuesCurrent.description, "&lt;", "<");
                    htmlData = replaceAll(htmlData, '&gt;', '>');
                    var content = [
                        '<div class="info-details">',
                        '      <div class="row">',
                        '           <div class="col col-md-12"><h1>' + title + '</h1></div>',
                        '           <div class="col col-md-12"><p>' + htmlData + '</p></div>',
                        '      </div>',

                        '</div>'].join("");
                    var width = 50, height = 60;

                    var iconCurrent = {
                        url: urlIcon,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // originzoom_changed
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var marker_object = new google.maps.Marker({
                        draggable: true,
                        title: title,
                        animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(lat, lng),
                        icon: iconCurrent,
                        content: content
                    });
                    var params_data = {map: map, marker: marker_object, content: content};
                    currentWulpy.addMarker(params_data);
                    _this._markersCurrent(marker_object);


                });


                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: pathDevelopers + "assets/images/cluster/"});

            },
            /*MAPS EVENTS*/
            _mapCurrent: function (params) {

                mapCurrent = params.mapCurrent;
                var _this = this;
                var geocoder = new google.maps.Geocoder();
                mapCurrent.addListener('idle', function () {

                });
//----clic en l map---
                google.maps.event.addListener(mapCurrent, 'click', function (e) {
                    cont_fi = 0;
                    lat = e.latLng.lat();
                    lng = e.latLng.lng();
                    var timestamp = new Date().getTime()
                    params = {
                        data: {lat: lat, lng: lng, timestamp: timestamp, cont_fi: cont_fi},
                        bdd_node: "coordenadas"
                    };


                    geocoder.geocode({'latLng': e.latLng}, function (results, status) {
                        _this.setValueRoutesDrawing({type: "latLng"});

                        /*  if (status == google.maps.GeocoderStatus.OK) {
                              if (results[1]) {
                                  console.log(results[1].formatted_address);
                                  console.log(results);

                              }
                          } else {
                              alert("Geocoder failed due to: " + status);
                          }*/
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
                    /*          var rowCurrent = _this.routeConfigCurrent;
                              var optionsMap = jQuery.parseJSON(rowCurrent["information"]["options_map"]);
                              _this.map.panTo(optionsMap.center);*/


                });
                mapCurrent.addListener('drag', function () {


//            console.log("zoom_changed");
                });
                mapCurrent.addListener('center_changed', function () {
//            console.log("center_changed");
                });

            },
            _markersCurrent: function (marker) {

                var _this = this;
                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'dragstart', function () {

                });

                google.maps.event.addListener(marker, 'drag', function () {

                });

                google.maps.event.addListener(marker, 'dragend', function () {

                });
                google.maps.event.addListener(marker, 'click', function () {
                    _this._viewModalManager({marker: marker});
                });
            },
            setCurrentLatLngForm: function (latLngCurrent) {
                var element = $("#business_street_lat");
                element.val(latLngCurrent.lat);
                element = $("#business_street_lng");
                element.val(latLngCurrent.lng);
            }
        }
    });
app.initManagement();
if (false) {


    var appTopHeader = new Vue(
        {
            el: '#slidetop',

            data: {

                why: {
                    title: "Porqué Wulpy?",
                    "content": "Este proyecto tiene como finalidad consolidar una metodología de elaboración de estrategias de desarrollo de la enseñanza y aprendizaje, para el proceso del desarrollo turístico sostenible y sustentable, a través de la creación, uso y ejecución de las Tics sobre la base de acciones participativas y de inclusión social." +
                        "\n" +
                        "Quieres crear chakiñanes y rutas turisticas? Wulpy es tu mejor opción!! Contáctanos!! "
                },
                contact: {
                    title: "Contactanos",
                    address: ""
                },
                contactHtml: '<h6><i class="icon-envelope"></i> CONTACTANOS</h6><ul class="list-unstyled"><li><b>Dirección:</b>Ecuador-Otavalo <br/> Piedrahita </li>' +
                    '<li><b>Teléfono:</b> 0979458500</li>' +
                    '<li><b>Email:</b> <a href="mailto:developers.dev26@gmail.com">mailto:developers.dev26@gmail.com</a></li>' +
                    ' </ul>' +
                    ''


            },
            methods: {
                ...$methodsFormValid,
                initManagement: function () {

                },

            }
        });
    appTopHeader.initManagement();
}
if (false) {

    var appManager = new Vue(
        {
            el: '#manager-content',

            data: {
                managerUrlMain: "/wulpyme",
                logoMain: "https://www.meistertask.com/embed/at/8558696/large/94ee8830399669e47fd0ae6438e36870adb3c550.png"
            },
            methods: {
                ...$methodsFormValid,
                initManagement: function () {

                },

            }
        });
    appManager.initManagement();
}

/*
-------------INIT--------*/

function WulpyMapUtil() {
    var mapCurrent;
    // Grey Scale

    this.greyscale_style = $greyscale_style;
    var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
        name: "Greyscale"
    });
    var mapOptions = {
        title: "Ubicacion",
        panControl: true,
        scrollwheel: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        draggable: true,
        center: myLatlng,
        zoom: zoom,
        animation: google.maps.Animation.DROP,
//        position: new google.maps.LatLng(myLatlng.lat, myLatlng.lng),
//                mapTypeId: google.maps.MapTypeId.,
//                scrollwheel: true,
        icon: icon_mapa_url

    }

//----INIT MAP
    var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
    var mapOptions = {
        title: "Ubicacion",
        panControl: true,

        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        draggable: true,
        center: myLatlng,
        zoom: zoom,
        animation: google.maps.Animation.DROP,
//        position: new google.maps.LatLng(myLatlng.lat, myLatlng.lng),
//                mapTypeId: google.maps.MapTypeId.,
//                scrollwheel: true,
        icon: icon_mapa_url,
        gestureHandling: 'cooperative'
    }
    this.map;
    this.initMap = function (init_map_element, data) {
        var name_empresa = "Wulpy";
        map = new google.maps.Map($(init_map_element)[0], mapOptions);
        /!*   $scope.eventsMap($scope.map);*!/
        var key = 1;
        var latitud = myLatlng.lat;
        var longitud = myLatlng.lng;
        var key_id = key;
        var info_name = name_empresa;
        var mssg = key_id + " " + info_name;
        var marker_object = new google.maps.Marker({
            draggable: false,
            title: info_name,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(latitud, longitud),
            icon: icon_mapa_url,
        });
        init_map = true;
        map.mapTypes.set('greyscale_style', greyStyleMap);
        map.setMapTypeId('greyscale_style');
        this.map = map;
        return this.map;

    }

    function closeAllMarker() {
        angular.forEach(markers_opens, function (value_marker, key) {
            value_marker.close();
        });
        markers_opens = [];
    }


    this.latLngCurrent = null;
    var _this = this;
    this.addMarker = function (params) {
        var markerOptions = params.marker;
        var map = params.map;
        var content = params.content;
        markers.push(markerOptions); // add marker to array
        markerOptions.setMap(map);
    }

    function eventsMarker(marker_data) {

        // Add dragging event listeners.
        google.maps.event.addListener(marker_data, 'dragstart', function () {
            console.log("dragstart");
//            updateMarkerAddress('Dragging...');

        });

        google.maps.event.addListener(marker_data, 'drag', function () {
//            updateMarkerStatus('Dragging...');
            console.log("drag");
            /!*$scope.updateMarkerPosition(marker_data.getPosition());*!/
        });

        google.maps.event.addListener(marker_data, 'dragend', function () {
            /!*   updateMarkerStatus('Drag ended');*!/
//        geocodePosition(marker.getPosition());
//        map.panTo(marker.getPosition());
        });
    }


}

function managerSticky(params) {
    $window = params['$window'];
    $headerSticky = params['$headerSticky'];
    var viewSticky = $window.scrollTop() >= 200 && $window.width() > 767;
    if (viewSticky) {
        $headerSticky.show();
    } else {
        $headerSticky.hide();

    }
}

function initHeaderSticky() {
    var $window = $(window);
    $headerSticky = $('.header-sticky');
    /*managerSticky({
        '$window': $window,
        '$headerSticky': $headerSticky,
    });*/
    $window.on('scroll', function () {
        /*     if ($window.scrollTop() >= 200 && $window.width() > 767) {
                 $headerSticky.addClass('is-sticky');
             } else {
                 $headerSticky.removeClass('is-sticky');
             }*/

    });
    var positionCurrent =null;
    var positionViewInformation = null;
    if($window.width()>768){
         positionCurrent = $('.header-navigation-area').position().top;
         positionViewInformation = (positionCurrent * 2.70)+'px';
    }else{
        positionCurrent = $('.header-mobile-navigation').position().top;
        positionViewInformation = (positionCurrent * 2.70)+'px';
    }

    $('.content-view-information-title').css({
        top: positionViewInformation,
    });
    $('.content-view-information-description').css({
        top: positionViewInformation,
    });

}

