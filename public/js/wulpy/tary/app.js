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


var database = firebase.database();
var refCurrent = "business";
var db = firebase.database();
var firebaseOrdersCollection = database.ref().child(refCurrent);


function initFirebaseEvents() {
    console.log("init fb");
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
    database.ref(refCurrent).on("value", function (snap) {
        console.log("initial data loaded!", snap.numChildren());
    });

}


Vue.component(
    'business-management-component',

    {
        props: ['business'],
        template: '#businessManagament',
        data() {
            return {
                checked: false,
                title: 'Check me',
            }
        },
        methods: {
            ...$methodsFormValid,
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
        ...$methodsFormValid,
        newRegister() {
            newRegister();
        }
    }
});

// explicit installation required in module environments
Vue.component('modal', {
    template: '#modal-template',
    mounted() {
        initCowJumpsOver();
    }
});



Vue.use(VueFire);
const app = new Vue(
    {
        el: '#app-management',

        firebase: {
            business: db.ref(refCurrent)
        },

        data: {

            btnRegisterLabel: 'Registrarse',
            msj: {
                value: "",
                view: false
            },
            wulpyMapUtil: function () {
                var currentWulpy = new WulpyMapUtil;
                return currentWulpy;
            },
            business: [],
            initLoadData: false,
            initDataRows: {
                count: 0,
            },
            showModal: false,
            modelBusiness: {
                street_lat: null,
                street_lng: null,
                business_subcategory_id: null,
                title: null,
                phone_value: null,
                street_1: null,
                street_2: null,
                page_url: null,
                description: null
            },
            titleModal: "Creación de Empresa",
            latLngCurrent: myLatlng,
            errors: [],
        },
        methods: {
            ...$methodsFormValid,
            getRefSearch: function (params) {
                var type = params.type;
                var searchTerm = params.search;
                var initData = params.init;

                var searchKey = params.searchKey;
                var equals = params.equals;
                var ref;
                var orderByChild = searchKey;
                if (initData) {

                    ref = database.ref(refCurrent).orderByChild(orderByChild)
                        .startAt(searchTerm)
                        .endAt(searchTerm + '~');

                    if (equals) {
                        ref = database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm);
                    }

                } else {
                    ref = database.orderByChild(searchKey);
                }
                return ref;
            },
            searchData: function () {
                var ref = this.getRefSearch({init: true, searchKey: "title"});
                ref.once('value', this.showResults, errors);
            },
            showResults: function (snap) {

            },
            removeBusiness(row) {
                console.log(row);
            },
            getDataRows: function () {
                var promiseResult = new Promise((resolve, reject) => {
                    database.ref(refCurrent).on("value", function (snap) {
                        console.log("initial data loaded!", snap.numChildren());
                        resolve(snap);
                    });

                });
                return promiseResult;
            },

            initDabase: function () {

            }, initManagement: function () {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "10000",
                    "timeOut": "10000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success("No topes a la mariposa tary !!");
                setConfigMap();
                console.log("OBJETC APP", this);
                this.mapCurrent = this.wulpyMapUtil().initMap("#map", this.business);
                this._mapCurrent(this.mapCurrent);


                var title = "Hola Tary Has Click";
                var lat = myLatlng.lat;
                var lng = myLatlng.lng;

                var width = 100, height = 120;
                var iconCurrent = {
                    url: "http://bestanimations.com/Animals/Insects/Butterflys/butterfly-animated-gif-45.gif",
                    scaledSize: new google.maps.Size(width, height), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };
                var content = "<div>" + title + "</div>";
                var marker_object = new google.maps.Marker({
                    draggable: false,
                    title: title,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(lat, lng),
                    icon: iconCurrent,
                    content:"<div> Hola tary esperemos te guste!!</div>"
                });
                var params_data = {map: map, marker: marker_object, content: content};
                marker_object.setAnimation(google.maps.Animation.BOUNCE);
                this.wulpyMapUtil().addMarker(params_data);

                this._markersCurrent(marker_object);
            },
            wulpyMapUtilMethods: function () {
                return WulpyMapUtil();
            }
            , _mapCurrent: function (mapCurrent) {
                var _this = this;

                var geocoder = new google.maps.Geocoder();
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
                    console.log('Zoom: ' + mapCurrent.getZoom());
                    window.setTimeout(function () {
                        var currentLtLng;
                        if (_this.modelBusiness.street_lat) {
                            currentLtLng = new google.maps.LatLng(_this.modelBusiness.street_lat, _this.modelBusiness.street_lng);
                        } else {
                            currentLtLng = new google.maps.LatLng(myLatlng.lat, myLatlng.lng);

                        }
                        mapCurrent.setCenter(currentLtLng);
                    }, 1000);

//            console.log("zoom_changed");
                });
                mapCurrent.addListener('drag', function () {

                    window.setTimeout(function () {
                        var currentLtLng;
                        if (_this.modelBusiness.street_lat) {
                            currentLtLng = new google.maps.LatLng(_this.modelBusiness.street_lat, _this.modelBusiness.street_lng);
                        } else {
                            currentLtLng = new google.maps.LatLng(myLatlng.lat, myLatlng.lng);

                        }
                        mapCurrent.setCenter(currentLtLng);
                    }, 1000);

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
                    console.log("dragstart");
//            updateMarkerAddress('Dragging...');

                });

                google.maps.event.addListener(marker, 'drag', function () {
//            updateMarkerStatus('Dragging...');
                    console.log("drag");
                    _this.latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
                });

                google.maps.event.addListener(marker, 'dragend', function () {
                    /!*   updateMarkerStatus('Drag ended');*!/
//        geocodePosition(marker.getPosition());
//        map.panTo(marker.getPosition());
                });
                google.maps.event.addListener(marker, 'click', function () {
                    var infoWindowOptions = {
                        content: marker.content
                    };
                    var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
                    infoWindow.open(map, marker);

                    _this.latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
                    _this.showModal = true;

                });
            },


        }
    });
app.initManagement();
var lastRef;

function initCowJumpsOver() {
    var cow = $("#cow"),
        foo = $("#mask"),
        bang = $("#bang"),
        drop = $(".drop"),
        legL = $(".legl"),
        legR = $(".legr"),
        overlapThreshold = "20%",
        animation = moo().pause(),
        boundingBox = document.getElementById("boundingBox");

    TweenMax.set(cow, {
        svgOrigin: "321.05, 323.3",
        rotation: 50
    });

    TweenMax.set(foo, {
        y: 0
    });

    TweenMax.set([legL, legR], {
        rotation: 0
    });

    TweenMax.set(bang, {
        visibility: "visible",
        opacity: 0
    });

    Draggable.create(cow, {
        type: "rotation",
        throwProps: true,
        onDrag: test,
        onThrowUpdate: test
    });

    function test(e) {
        var rotation = this.target._gsTransform.rotation % 360;
        if (rotation < -180) {
            rotation += 360;

        }
        updateBounds(this.target);
        if (rotation < 12 && rotation > -12 && !animation.isActive()) {
            animation.restart();
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "10000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("La ciencia no nos ha enseñado ,aun asi la locura es o no lo mas sublime de la inteligencia. :) feliz no cumpleaños");
        }
    }

    function updateBounds(element) {
        var bounds = element.getBoundingClientRect(),
            style = boundingBox.style,
            doc = document.documentElement,
            scrollY = Math.max(doc.scrollTop, document.body.scrollTop);
        style.top = (bounds.top + scrollY) + "px";
        style.left = bounds.left + "px";
        style.width = bounds.width + "px";
        style.height = bounds.height + "px";
    }

    function moo() {
        var tl = new TimelineMax();
        tl.add("woah");
        tl.fromTo(bang, 0.75, {opacity: 0}, {opacity: 1, ease: Back.easeOut}, "woah")
            .fromTo(mask, 0.75, {y: 0}, {y: -6, ease: Back.easeOut}, "woah")
            .fromTo(legR, 0.75, {rotation: 0}, {rotation: -8, transformOrigin: "0 100%", ease: Back.easeOut}, "woah")
            .fromTo(legL, 0.75, {rotation: 0}, {rotation: 8, transformOrigin: "100% 100%", ease: Back.easeOut}, "woah")
            .fromTo(bang, 0.25, {opacity: 1}, {opacity: 0, ease: Circ.easeIn}, "woah+=0.75")
            .fromTo(mask, 0.25, {y: -6}, {y: 0, ease: Circ.easeIn}, "woah+=1")
            .fromTo(legR, 0.25, {rotation: -8}, {rotation: 0, transformOrigin: "0 100%", ease: Circ.easeOut}, "woah+=1")
            .fromTo(legL, 0.25, {rotation: 8}, {
                rotation: 0,
                transformOrigin: "100% 100%",
                ease: Circ.easeOut
            }, "woah+=1");
        return tl;
    }

    updateBounds(cow[0]);
}

function searchFirebase(searchTerm) {
    var type = "name";
    var equal = false;
    var ref = searchType({search: searchTerm, searchKey: "title"});
    ref.once('value', showResults, errors);
}


function showResults(snap) {
    if (snap) {
        console.log(snap.val());
    }
}

function errors(snap) {
    console.log(snap);
}

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
            ...$methodsFormValid,
            removeBusiness(row) {
                console.log(row);
            },

            initDabase: function () {

            }, initManagement: function () {

            },

        }
    });
appTopHeader.initManagement();

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
//                    var content = $scope.getMessage(value);

        console.log(data);
        if (data) {
            $.each(data, function (index, value) {
                console.log(index, value);
                /*        var content = "<div>Informacion</div>";
                        var params_data = {map: map, marker: marker_object, content: content};
                        addMarker(params_data);
                        console.log(value);*/


            });
        }
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

            var paramsSearch = {
                latLng: e.latLng, currentMarkers: markers
            };
            $.each(markers, function (index, markerCurrent) {
                toggleBounceClean(markerCurrent);
            });
            var resultMarkersNearest = findNearestMarkerGMAP(paramsSearch);


            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("Existe : " + Object.keys(resultMarkersNearest).length + " cerca de ud.");
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

    this.addMarker = function (params) {
        var markerOptions = params.marker;
        var map = params.map;
        var content = params.content;
        markers.push(markerOptions); // add marker to array
        markerOptions.setMap(map);
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
