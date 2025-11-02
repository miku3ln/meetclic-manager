/*
var init_map = false;
var map;
var markers_opens = [];
var myLatlng = {lat: 0.2314799, lng: -78.271874};
var zoom = 15;
var markers = [];
$(window).resize(function () {
    setConfigMap();
});

function getConfigMap() {
    result = {
        width: $(window).width(),
        height: $(window).height(),
    }
    return result;
}

function setConfigMap() {
    var config = getConfigMap();
    var porcent = config.height * 0.2 / 100;
    $("#map").css({"widht": config.width + "px", "height": (config.height - porcent) + "px"});
}


function WulpyMapUtil() {

    // Grey Scale
    var greyscale_style = [{
        "featureType": "road.highway",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "landscape",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "transit",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi.park",
        "stylers": [{
            "visibility": "on"
        }]
    }, {
        "featureType": "poi.park",
        "elementType": "labels",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
            "color": "#d3d3d3"
        }, {
            "visibility": "on"
        }]
    }, {
        "featureType": "poi.medical",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi.medical",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
            "color": "#cccccc"
        }]
    }, {
        "featureType": "water",
        "elementType": "geometry.fill",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#cecece"
        }]
    }, {
        "featureType": "road.local",
        "elementType": "labels.text.fill",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#808080"
        }]
    }, {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#808080"
        }]
    }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#fdfdfd"
        }]
    }, {
        "featureType": "road",
        "elementType": "labels.icon",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "water",
        "elementType": "labels",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi",
        "elementType": "geometry.fill",
        "stylers": [{
            "color": "#d2d2d2"
        }]
    }];
    this.greyscale_style = greyscale_style;
    var greyStyleMap = new google.maps.StyledMapType(greyscale_style, {
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
    var icon_mapa_url;
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

    this.initMap = function (init_map_element) {
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
//                    var content = $scope.getMessage(value);
        var content = "<div>Informacion</div>";
        var params_data = {map: map, marker: marker_object, content: content};
        addMarker(params_data);
        eventsMap(map)
        $(init_map_element).show();
        init_map = true;
        map.mapTypes.set('greyscale_style', greyStyleMap);
        map.setMapTypeId('greyscale_style');


    }

    function closeAllMarker() {
        angular.forEach(markers_opens, function (value_marker, key) {
            value_marker.close();
        });
        markers_opens = [];
    }

    function eventsMap(map_data) {
//----clic en l map---
        google.maps.event.addListener(map_data, 'click', function (e) {
            console.log("addListener map_data click");
            cont_fi = 0;
            lat = e.latLng.lat();
            lng = e.latLng.lng();
            var timestamp = new Date().getTime()
            params = {data: {lat: lat, lng: lng, timestamp: timestamp, cont_fi: cont_fi}, bdd_node: "coordenadas"};
            console.log(params);

        });
        google.maps.event.addListener(map_data, 'dblclick', function (e) {
            console.log("addListener map_data dblclick");

        });
        google.maps.event.addListener(map_data, 'mouseup', function (e) {
//            console.log("addListener map_data mouseup");

        });
        google.maps.event.addListener(map_data, 'mousedown', function (e) {
//            console.log("addListener map_data mousedown");

        });
        google.maps.event.addListener(map_data, 'mouseover', function (e) {
//            console.log("addListener map_data mouseover");

        });
        google.maps.event.addListener(map_data, 'mouseout', function (e) {
//            console.log("addListener map_data mouseout");

        });
        map_data.addListener('zoom_changed', function () {
            console.log('Zoom: ' + map_data.getZoom());
//            console.log("zoom_changed");
        });
        map_data.addListener('center_changed', function () {
//            console.log("center_changed");
        });
    }

    function addMarker(params) {
        var markerOptions = params.marker;
        var map = params.map;
        var content = params.content;
        markers.push(markerOptions); // add marker to array
        markerOptions.setMap(map);
        eventsMarker(markerOptions, map);
        google.maps.event.addListener(markerOptions, 'click', function () {
            console.log("click init ");

            var key_search = markerOptions.id;
            console.log(markerOptions);
            var entidad_key = (2);
//            markerOptions.setAnimation(google.maps.Animation.BOUNCE);
//            if (markerOptions.getAnimation() !== null) {
//                markerOptions.setAnimation(null);
//            } else {
//            }
////            -- - si es l mismo para cerrar--
//
            var infoWindowOptions = {
                content: content
            };
            var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
            infoWindow.open(map, markerOptions);
            map.setCenter(markerOptions.getPosition());
            map.setZoom(15);
            markers_opens.push(infoWindow);
        });
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

    function eventsMarker(marker_data, map) {

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

function InitProces() {

}

var app;
var db;
var refCurrent = "business";
$(function () {

})
$(window).on("load", initApp);

/!*


*!/
var database;
function initFirebaseEvents() {
     database = firebase_obj.database();
    db = firebase.database();
    var firebaseOrdersCollection = database.ref().child(refCurrent);
    database.ref(refCurrent).on('child_added', function (data) {
        console.log("child_ad");
    });
    database.ref(refCurrent).on('child_changed', function (data) {
        //update_data_table(data.val().username, data.val().profile_picture, data.val().email, data.key)
        console.log("child_changed");

    });
    database.ref(refCurrent).on('child_removed', function (data) {
        //remove_data_table(data.key)
    });

}

function initApp() {

    initFirebaseEvents();
    Vue.component('button-counter', {
        data: function () {
            return {
                count: 0
            }
        },
        template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
    });

    Vue.component(
        'business-management-component',

        {
            props: ['business'],
            template: '#businessManagament',
            data() {
                return {
                    checked: false,
                    title: 'Check me',
                    /!*    data: [{
                            "id": 1,
                            "name": "ALEX",

                        }]*!/
                }
            },
            methods: {
                check() {
                    this.checked = !this.checked;
                }
            }
        }
    );
    Vue.component('btn-create-component', {
        data: function () {
            return {
                count: 0
            }
        },
        template: getBtnCreate(),
        methods: {
            newRegister() {
                newRegister();
            }
        }
    });
    Vue.component('ul-component', {
        props: ['business', "users"],
        template: getInfo(),
        methods:
            {
                removeBusiness(row) {
                    console.log(row);
                }
            }
    });

    Vue.use(VueFire);

    app = new Vue(
        {
            el: '#app-management',

            firebase: {
                business: db.ref(refCurrent)
            },

            /!*    data: function () {
                    return {
                        businessOther: db.ref(refCurrent)
                    }

                },*!/
            data: {
                dataBusiness: function () {
                    return {
                        businessOther: db.ref(refCurrent)
                    }
                },
                btnRegisterLabel: 'Registrarse',
                msj: {
                    value: "",
                    view: false
                },
                wulpyMapUtil: function () {
                    var currentWulpy = new WulpyMapUtil;
                    return currentWulpy;
                }

            },
            methods: {
                removeBusiness(row) {
                    console.log(row);
                },
                greet: function (event) {
                    alert('Hello ' + this.name + '!')
                    // `event` is the native DOM event
                    if (event) {
                        alert(event.target.tagName)
                    }
                },
                initDabase: function () {

                }, initManagement: function () {
                    this.initDabase();


                },
                wulpyMapUtilMethods: function () {
                    return WulpyMapUtil();
                }
            },

        });
    setConfigMap();
    var currentWulpy = new WulpyMapUtil;
    currentWulpy.initMap("#map");



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
}*/
