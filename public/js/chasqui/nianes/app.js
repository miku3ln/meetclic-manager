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
var urlBusiness = "routeView/";
$(window).resize(function () {
    setConfigMap();
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

var markersClusterData = [];
var infoWindow = null;
// explicit installation required in module environments
/*Vue.use(VueFire);*/
const app = new Vue(
    {
        el: '#app-management',
        created: function () {
            this.$on("_dataComponents", data => {

                console.log(data);
            });

        },
        data: function () {
            return {
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
                configDataSearchManager: {
                    configDataSearchManager: {
                        button: {
                            state: false
                        }
                    }
                }
            };
        },
        methods: {
            ...$methodsFormValid,

            /*  ---EVENTS CHILDREN****/
            _updateParentByChildren: function (params) {
                console.log(params);
                if (params.nameComponent == "SearchManager") {

                    if (params.nameEvent == "_viewManager") {
                        this._setMarkersView(
                            {
                                haystack: params.response.data
                            }
                        );
                    } else if (params.nameEvent == "_centerMarkerMap") {
                        this._setCenterByMarker(
                            {
                                data: params.response.data
                            }
                        );
                    } else if (params.nameEvent == "_resetValues") {
                        this._resetValuesMaps();
                    }
                }
            },
            _emitParentToChildren: function (type) {

                if (type == "closeMenu") {
                    var params = {
                        nameEvent: "_closeMenu",
                        nameComponent: "App",
                        response: {
                            button: {
                                state: false
                            }
                        }
                    };
                    this.$refs._emitParentToSearchManager._updateChildrenByParent(params);

                }

            },
            _resetValuesMaps: function () {
                markers.map(function (value, key) {
                    value.setMap(null);
                });
                markers = [];
                markersClusterData.map(function (value, key) {
                    value.clearMarkers();
                });
                markersClusterData = [];
            },
            initDataCurrent: function () {
                this.business = $dataBusiness;
            }, initManagement: function () {
                this.initDataCurrent();
                setConfigMap();
                this.mapCurrent = currentWulpy.initMap("#map");
                map = this.mapCurrent;

                /*  var myMarker = new google.maps.Marker({
                      map: map,
                      animation: google.maps.Animation.DROP,
                      position: myLatlng
                  });
                  addYourLocationButton(map, myMarker);*/

                var myoverlay = new google.maps.OverlayView();
                myoverlay.draw = function () {
                    // add an id to the layer that includes all the markers so you can use it in CSS
                    this.getPanes().markerLayer.id = 'markerLayer';
                };
                myoverlay.setMap(map);
                var dataMarker = this.business;
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
            viewModal() {
                this.$refs.myModalRef.show()
            },
            hideModal() {
                this.$refs.myModalRef.hide()
            },
            _setMarkersView: function (params) {
                var _this = this;
                var haystack = params.haystack;

                var mapCurrent = this.mapCurrent;

                $.each(haystack, function (index, valuesCurrent) {

                    var type_shortcut = valuesCurrent["type_shortcut"];
                    var title = valuesCurrent["name"];
                    var description = valuesCurrent.description != null ? valuesCurrent.description : "Sin descripcion";
                    var options_map = valuesCurrent["options_map"];
                    options_map = jQuery.parseJSON(options_map);
                    var routes_drawing_data = valuesCurrent["routes_drawing_data"];
                    var urlIcon = "";
                    urlIcon = getRouteTypeIcon(type_shortcut);

                    var lat = options_map["center"].lat;
                    var lng = options_map["center"].lng;


                    var currentId = valuesCurrent.id;

                    var urlCurrent = urlBusiness + valuesCurrent.id;
                    var urlImgRoute = randomItem(imagesManager);

                    var content = [
                        '<div class="window-info-details">',
                        '     <a target="_blank" href="' + urlCurrent + '" class="window-info-details__link">',
                        '       <div  class="content-resource">',
                        '        <img class="content-resource__img"',
                        '           src="' + urlImgRoute + '"',
                        '           alt="">',
                        '        </div>',
                        '      <div class="content-information">',
                        '           <div class="content-information__title"><h1 class="window-info-details__title">' + title + '</h1></div>',
                        '        <div class="content-information__description"><div class="content-information__description-value">' + description + '</div></div>',
                        '      </div>',
                        '    </a>',
                        '</div>'
                    ].join("");
                    var width = 30, height = 40;

                    var iconCurrent = {
                        url: urlIcon,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var marker_object = new google.maps.Marker({
                        draggable: false,
                        title: title,
                        animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(lat, lng),
                        icon: iconCurrent,
                        content: content,
                        map: mapCurrent,
                        id: currentId,
                        routes_drawing_data: routes_drawing_data,
                        options_map: options_map
                    });
                    markers.push(marker_object);

                    _this._markersCurrent(marker_object);


                });
                var markerCluster = null;

                if (getObjectLength(markers) > 0) {
                    var mcOptions = {

                            //imagePath: pathDevelopers + "assets/images/cluster/",
                            styles: [{
                                height: 53,
                                url: pathDevelopers + "assets/images/cluster/1.png",
                                width: 53,
                                fontFamily: "comic sans ms",
                                textSize: 15,
                                textColor: "red",
                                //color: #00FF00,
                            },
                                {
                                    height: 56,
                                    url: pathDevelopers + "assets/images/cluster/2.png",
                                    width: 56,
                                    fontFamily: "comic sans ms",
                                    textSize: 15,
                                    textColor: "red",
                                    color: "#00FF00",
                                },
                                {
                                    height: 66,
                                    url: pathDevelopers + "assets/images/cluster/3.png",
                                    width: 66
                                },
                                {
                                    height: 78,
                                    url: pathDevelopers + "assets/images/cluster/4.png",
                                    width: 78
                                },
                                {
                                    height: 90,
                                    url: pathDevelopers + "assets/images/cluster/5.png",
                                    width: 90
                                }]

                        }
                    ;
                    markerCluster = new MarkerClusterer(map, markers, mcOptions);
                    markersClusterData.push(markerCluster);

                }
            },
            setConfigurationMap: function (params) {
                var _this = this;
                var dataBusinessCurrent = params.dataBusinessCurrent;
                var urlBusiness = "wulpymeView/";
                var mapCurrent = this.mapCurrent;

                $.each(dataBusinessCurrent, function (index, valuesCurrent) {
                    var title = valuesCurrent.title;
                    var lat = valuesCurrent.street_lat;
                    var lng = valuesCurrent.street_lng;
                    var currentId = valuesCurrent.id;

                    var business_subcategories_id = valuesCurrent.business_subcategories_id;
                    var subcategory = getSubCategory(business_subcategories_id);
                    var urlIcon = "";
                    if (!subcategory) {
                        urlIcon = "https://furtaev.ru/preview/user_on_map.png";

                    } else {
                        urlIcon = subcategory.marker;
                    }
                    var urlCurrent = urlBusiness + valuesCurrent.id;
                    var description = valuesCurrent.description != null ? valuesCurrent.description : "Sin descripcion";
                    var content = [
                        '<div class="window-info-details">',
                        '   <a target="_blank" href="' + urlCurrent + '" >',
                        '       <img class="window-info-details__img"',
                        '       src="https://chicago.wpresidence.net/wp-content/uploads/2017/08/pexels-photo-279607-400x161.jpeg"',
                        '       alt="">',
                        '      <div class="row">',
                        '           <div class="col col-md-12"><h1 class="window-info-details__title">' + title + '</h1></div>',
                        '           <div class="col col-md-12"><div class="window-info-details__description">' + description + '</div></div>',
                        '      </div>',
                        '   </a>',
                        '</div>'].join("");
                    var width = 30, height = 40;

                    var iconCurrent = {
                        url: urlIcon,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var marker_object = new google.maps.Marker({
                        draggable: true,
                        title: title,
                        animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(lat, lng),
                        icon: iconCurrent,
                        content: content,
                        map: mapCurrent,
                        id: currentId,
                        optimized: false,
                    });
                    markers.push(marker_object);

                    _this._markersCurrent(marker_object);


                });
                var markerCluster = null;
                if (getObjectLength(markers) > 0) {
                    var mcOptions = {

                            //imagePath: pathDevelopers + "assets/images/cluster/",
                            styles: [{
                                height: 53,
                                url: pathDevelopers + "assets/images/cluster/1.png",
                                width: 53,
                                fontFamily: "comic sans ms",
                                textSize: 15,
                                textColor: "red",
                                //color: #00FF00,
                            },
                                {
                                    height: 56,
                                    url: pathDevelopers + "assets/images/cluster/2.png",
                                    width: 56,
                                    fontFamily: "comic sans ms",
                                    textSize: 15,
                                    textColor: "red",
                                    color: "#00FF00",
                                },
                                {
                                    height: 66,
                                    url: pathDevelopers + "assets/images/cluster/3.png",
                                    width: 66
                                },
                                {
                                    height: 78,
                                    url: pathDevelopers + "assets/images/cluster/4.png",
                                    width: 78
                                },
                                {
                                    height: 90,
                                    url: pathDevelopers + "assets/images/cluster/5.png",
                                    width: 90
                                }]

                        }
                    ;
                    markerCluster = new MarkerClusterer(map, markers, mcOptions);
                    markersClusterData.push(markerCluster);
                }

            },
            /*MAPS EVENTS*/
            _setCenterByMarker: function (params) {
                var positionCurrentSelect = params.data.position;
                var currentIdMarker = params.data.row.id;
                var latLng = new google.maps.LatLng(positionCurrentSelect.lat, positionCurrentSelect.lng);
                this.mapCurrent.panTo(latLng);
                this.mapCurrent.setZoom(18);

                markers.map(function (value, key) {
                    if (value.getAnimation() !== null) {
                        value.setAnimation(null);
                    }
                });
                markerCurrentData = markers.filter(function (value, key) {
                    return value.id == currentIdMarker;
                });
                if (getObjectLength(markerCurrentData)) {

                    this._animationMarker(markerCurrentData[0]);
                }
                /*  $('#markerLayer img').css('animation', type+ ' 1s infinite alternate');
                  $('#markerLayer img').css('-webkit-animation', type+ ' 1s infinite alternate')*/
            },
            _animationMarker: function (marker) {

                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            },

            _mapCurrent: function (params) {

                mapCurrent = params.mapCurrent;
                var _this = this;
                var geocoder = new google.maps.Geocoder();
//----clic en l map---
                google.maps.event.addListener(mapCurrent, 'click', function (e) {
                    _this._emitParentToChildren("closeMenu");
                    cont_fi = 0;
                    lat = e.latLng.lat();
                    lng = e.latLng.lng();
                    var timestamp = new Date().getTime();
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
                    console.log("zoom_changed");
                });
                mapCurrent.addListener('drag', function () {

                });
                mapCurrent.addListener('center_changed', function () {

                });
                google.maps.event.addListener(mapCurrent, 'idle', function () {
                    console.log("idle");
                });

            },
            _markersCurrent: function (marker) {

                var _this = this;
                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'dragstart', function () {
                    console.log("dragstart");
//            updateMarkerAddress('Dragging...');

                });

                google.maps.event.addListener(marker, 'drag', function () {

                });

                google.maps.event.addListener(marker, 'dragend', function () {

                });
                google.maps.event.addListener(marker, 'click', function () {
                    _this._emitParentToChildren("closeMenu");
                    if (infoWindow) {
                        infoWindow.close();
                    }
                    var htmlData = replaceAll(marker.content, "&lt;", "<");
                    htmlData = replaceAll(htmlData, '&gt;', '>');
                    var infoWindowOptions = {
                        content: htmlData,
                        maxWidth: 400
                    };
                    infoWindow = new google.maps.InfoWindow(infoWindowOptions);
                    infoWindow.open(map, marker);
                    currentLtLng = new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng());
                    map.panTo(currentLtLng);


                });
            }, _viewModalManager: function () {
                this.$refs.myModalRef.show();

            },
            setCurrentLatLngForm: function (latLngCurrent) {


                var element = $("#business_street_lat");
                element.val(latLngCurrent.lat);
                element = $("#business_street_lng");
                element.val(latLngCurrent.lng);
            },
        }

    })
;
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
                    title: "Contáctanos",
                    address: ""
                },
                contactHtml: '<h6><i class="icon-envelope"></i> CONTACTANOS</h6><ul class="list-unstyled"><li><b>Dirección:</b>Ecuador-Otavalo <br/> Piedrahita </li>' +
                    '<li><b>Teléfono:</b> 0979458500</li>' +
                    '<li><b>Email:</b> <a href="mailto:developers.dev26@gmail.com">mailto:developers.dev26@gmail.com</a></li>' +
                    ' </ul>' +
                    ''


            },
            methods: {
                onListenElementsForm:onListenElementsForm,

                removeBusiness: function (row) {
                    console.log(row);
                },

                initDabase: function () {

                }, initManagement: function () {

                },

            }
        });
    appTopHeader.initManagement();
}

function getBtnCreate() {
    let result = '<li class="m-portlet__nav-item"><a  @click="newRegister()"href="#"  class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">';
    result += '<span>'
    result += '<i class="la la-plus"></i>'
    result += 'Crear'
    result += '</span>'
    result += '</a></li>';
    return result;
}

function getInfo() {
    let result = '<ul >';
    result += '<li v-for="row in business" class="user"' + '">';
    result += '<span>{{row.title}} </span>';
    result += '<button v-on:click="removeBusiness(row)">X</button>';
    result += '</li>';
    result += '</ul>';

    return result;
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
        /*  scrollwheel: true,*/
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


//        mcOptions = {styles: [{
//                    height: 53,
//                    url: themeUrl + "plugins/google-maps/images/m1.png",
//                    width: 53
//                },
//                {
//                    height: 56,
//                    url: themeUrl + "plugins/google-maps/images/m2.png",
//                    width: 56
//                },
//                {
//                    height: 66,
//                    url: themeUrl + "plugins/google-maps/images/m3.png",
//                    width: 66
//                },
//                {
//                    height: 78,
//                    url: themeUrl + "plugins/google-maps/images/m4.png",
//                    width: 78
//                },
//                {
//                    height: 90,
//                    url: themeUrl + "plugins/google-maps/m5.png",
//                    width: 90
//                }]}
////        var markerCluster = new MarkerClusterer(map, markerOptions, mcOptions);

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

    function getMessage(data) {
        var html_data = "";
        var key_id = data.id;
        html_data += "<div class='content-data-info' id='content-data-info-" + key_id + "'>";

        var title = data.nombres + " CI:" + data.identificacion;
        html_data += "<h1 id='content-informacion-title'>" + title + "</h1>";
        var telefono = data.telefono;
        var email = data.email;
        var direccion_cliente = data.direccion.calle_1 + " y " + data.direccion.calle_2;
        html_data += "<div id='content-informacion-table'>";
        html_data += "<table id='table-info'>";
        html_data += "<tbody>";
        //            DIRECCION
        html_data += "<tr class='tr-direccion'>";
        html_data += "<td class='col-info-name'>";
        html_data += "Dirección:";
        html_data += "</td>";
        html_data += "<td class='col-info-valor'>";
        html_data += direccion_cliente;
        html_data += "</td>";
        html_data += "</tr>";
//            TELEFONO
        html_data += "<tr class='tr-telefono'>";
        html_data += "<td class='col-info-name'>";
        html_data += "Telefono:";
        html_data += "</td>";
        html_data += "<td class='col-info-valor'>";
        html_data += telefono;
        html_data += "</td>";
        html_data += "</tr>";
//            EMAIL
        html_data += "<tr class='tr-telefono'>";
        html_data += "<td class='col-info-name'>";
        html_data += "Email:";
        html_data += "</td>";
        html_data += "<td class='col-info-valor'>";
        html_data += email;
        html_data += "</td>";
        html_data += "</tr>";

        html_data += "</tbody>"
        html_data += "</table>"
        html_data += "</div>"


        html_data += "</div >";
        return html_data;

    }


}
