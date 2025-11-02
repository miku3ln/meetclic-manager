var currentDataLatLng;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;
var dataLayer = [];

function initMyMap() {


    var map = new google.maps.Map(document.getElementById('my_map_location'), {
        center: {lat: parseFloat(default_latitude), lng: parseFloat(default_longitude)},
        zoom: 16,
        mapTypeId: 'roadmap',
        navigationControl: true,
        mapTypeControl: false,
        // scaleControl: false,
    });

    var marker = new google.maps.Marker({
        position: {lat: parseFloat(default_latitude), lng: parseFloat(default_longitude)},
        map: map,
        draggable: true
    });

    // Create the search box and link it to the UI element.
    $("#content-search-google-maps").hide();
    var input = document.getElementById('input_address');
    var searchBox = new google.maps.places.SearchBox(input);

    initEventsMap(map, searchBox);
    initEventsMarker(marker, map);

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function (e) {
        var places = searchBox.getPlaces();
        if (places.length == 0) {//search city not street

            return;
        } else {
            clearMarkers(marker);
        }

        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            // if (!place.geometry) {
            //     console.log("Returned place contains no geometry");
            //     return;
            // }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            var marker = (new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                draggable: true
            }));
            markers.push(marker);
            initEventsMarker(marker, map);
            setValuesLatLng(place.geometry.location.lat(), place.geometry.location.lng());
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    $('#search_btn_map').click(function (e) {
        e.preventDefault();
        // handleAction();
    });

    $("#input_address").keypress(function (e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            e.preventDefault();
            // handleAction();
        }
    });
}

function clearMarkers(marker) {
    marker.setMap(null);
}

function initEventsMap(map, searchBox) {
    // https://developers.google.com/maps/documentation/javascript/events?hl=es

    //UI Events
    var viewConsole = false;
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        if (viewConsole) {

            searchBox.setBounds(map.getBounds());
        }
    });

    map.addListener('click', function () {
        if (viewConsole) {
            console.log("click map");
        }

    });
    map.addListener('dblclick', function () {
        if (viewConsole) {
            console.log("dblclick map");
        }
    });
    map.addListener('mouseup', function () {
        if (viewConsole) {
            console.log("mouseup map");
        }
    });
    map.addListener('mousedown', function () {
        if (viewConsole) {
            console.log("mousedown map");
        }
    });
    map.addListener('mouseover', function () {
        if (viewConsole) {
            console.log("mouseover map");
        }
    });
    map.addListener('mouseout', function () {
        if (viewConsole) {
            console.log("mouseout map");
        }
    });

    map.addListener('zoom_changed', function () {
        console.log("zoom_changed map" + 'Zoom: ' + map.getZoom());
        if (viewConsole) {
            console.log("zoom_changed map" + 'Zoom: ' + map.getZoom());
        }
    });
}

function initEventsMarker(marker, map) {
    marker.addListener('click', function () {
        map.setZoom(17);
        map.setCenter(marker.getPosition());
    });
    marker.addListener('dragend', function (e) {

        setValuesLatLng(e.latLng.lat(), e.latLng.lng());

    });
}

function setValuesLatLng(lat, lng) {
    default_latitude = lat;
    default_longitude = lng;
    setValuesFrm(lat, lng);
}

function setValuesFrm(lat, lng) {
    $("#business_street_lat").val(lat);
    $("#business_street_lng").val(lng);

}


/*
-------------INIT--------*/


/*
if (false) {


    var database = firebase.database();
    var refCurrent = "business";
    var db = firebase.database();
    var firebaseOrdersCollection = database.ref().child(refCurrent);


,
    initEventsFBCurrent: function () {
        orderByChild = "wulpyme_user_id";
        searchTerm = $wulpyme_user_id;
        var _this = this;

        database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm).on('child_changed', function (snap) {
            //update_data_table(data.val().username, data.val().profile_picture, data.val().email, data.key)
            console.log("child_changed");

            _this.modelBusiness = snap.val();
            _this.modelBusiness["keyRef"] = snap.key;
            console.log(_this.modelBusiness["keyRef"]);

        });
        database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm).on('child_removed', function (data) {
            //remove_data_table(data.key)
        });
        database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm).on("value", function (snaps) {
            console.log("initial data loaded!", snaps.numChildren());
            if (snaps.numChildren()) {
                var valuesCurrent = [];
                valuesCurrent = snaps.val();

                $.each(valuesCurrent, function (index, snap) {
                    valuesCurrent = snap;
                    if (_this.initDataRows.count) {
                        _this.modelBusiness = valuesCurrent;
                    } else {

                        valuesCurrent["index"] = index;
                        _this.setConfiguration(valuesCurrent, false);
                    }

                });

                /!* _this.setConfiguration(snap.value(), true);*!/

            } else {
                _this.setConfiguration(null, true);

            }


        });
    }
,
    getRefSearch: function (params) {
        var type = params.type;
        var searchTerm = params.search;
        var initData = params.init;

        var searchKey = params.searchKey;
        var equals = params.equals;
        var ref;
        var orderByChild = searchKey;
        if (initData) {
            if (equals) {
                ref = database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm);
            } else {

                ref = database.ref(refCurrent).orderByChild(orderByChild)
                    .startAt(searchTerm)
                    .endAt(searchTerm + '~');
            }

        } else {
            ref = database.orderByChild(searchKey);
        }
        return ref;
    }
,
    searchData: function () {
        var ref = this.getRefSearch({init: true, searchKey: "title"});
        ref.once('value', this.showResults, errors);
    }
     ,
            showResults: function (snap, many = false) {
                var _this = this;
                if (many) {
                    this.initDataRows.count = snap.numChildren();

                    var name = snap.key;
                } else {
                    var valuesCurrent = snap.val();
                    if (valuesCurrent) {
                        valuesCurrent["index"] = snap.key;
                        this.setConfiguration(valuesCurrent, false);
                    } else {
                        this.setConfiguration(null, true);

                    }
                }


            }
            ,
            removeBusiness(row) {
                console.log(row);
            }
            ,  getDataRows: function () {
                var promiseResult = new Promise((resolve, reject) => {
                    database.ref(refCurrent).on("value", function (snap) {
                        console.log("initial data loaded!", snap.numChildren());
                        resolve(snap);
                    });

                });
                return promiseResult;
            }
             ,
            updateDataByParams: function (params) {
                var ref = params.ref;
                var updates_set = params.data;
                var updates = {};
                updates[ref] = updates_set;
                ref = database.ref(refCurrent);
                var promiseResult = new Promise((resolve, reject) => {
                    ref.update(updates).then(function (snapshot) {
                        resolve(snapshot);
                    }).catch(function (error) {

                        reject(error);
                    });

                });
                return promiseResult;
            }
            ,
            setDataByParams: function (data) {
                ref = database.ref(refCurrent);
                var promiseResult = new Promise((resolve, reject) => {
                    ref.push(data).then(function (snapshot) {
                        resolve(snapshot);
                    }).catch(function (error) {

                        reject(error);
                    });

                });
                return promiseResult;
            }

}
*/
var mapOverlays = [];

function UtilBlitzMap(paramsConfig) {

    var mapObj, mapOptions, drwManager, infWindow, currentMapIndex;
    var isEditable = (paramsConfig && paramsConfig.isEditable) ? paramsConfig.isEditable : false;
    var currentManager = (paramsConfig && paramsConfig.currentManager) ? paramsConfig.currentManager : null;
    var notifyErrors = true;
    var colorPicker;
    var mapContainerId, sideBar, mapDiv, mapStorageId;
    var routeUnit = "metric";
    var dirRenderer;
    var dirService;
    var dirTravelMode;
    var dirAvoidHighways = false;
    var dirAvoidTolls = false;
    var dirProvideRouteAlternatives = false;
    var dirRouteUnit;
    var dirOptimizeWaypoints = false;
    var geoXml = null;

    /* -------CONFIG PARAMS------*/
    this.mapOptions = null;
    this.infWindow = null;
    this.isEditable = isEditable;
    this.map = null;
    var _this = this;
    var $this = this;


    /*****************************************
     *
     * Function Init()
     * This function initializes the BlitzMap
     *
     *****************************************/
    this.getValuesConfig = function (params) {
        console.log(this, _this);
    };
    this.initMap = function (params) {
        console.log(params);
        this.markers = [];
        this.allowEmmitEventsParent = params.hasOwnProperty('allowEmmitEventsParent') ? params.allowEmmitEventsParent : false;
        this.$parentThis = null;
        if (this.allowEmmitEventsParent) {
            this.$parentThis = params.parentThis;
        }
        var lat = (params && params.lat) ? params.lat : 0.22229121000317115;
        var lng = (params && params.lng) ? params.lng : -78.26220911073837;
        var mapTypeId = (params && params.mapType) ? params.mapType : "roadmap";
        var allowViewExample = (params && params.allowViewExample) ? params.allowViewExample : false;
        this.zoomCurrent = (params && params.options && params.options.zoom) ? params.options.zoom : 4;

        if(params.hasOwnProperty('options')){
            lat=params.options.center.lat;
            lng=params.options.center.lng;
        }
        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: this.zoomCurrent,
            mapTypeId: mapTypeId
        };
        _this.mapOptions = mapOptions;
        //create a common infoWindow object
        infWindow = new google.maps.InfoWindow();
        _this.infWindow = infWindow;
        if (_this.isEditable) {
            //initialize a common Drawing Manager object
            //we will use only one Drawing Manager
            drwManager = new google.maps.drawing.DrawingManager({
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.MARKER,
                        google.maps.drawing.OverlayType.CIRCLE,
                        google.maps.drawing.OverlayType.RECTANGLE,
                        google.maps.drawing.OverlayType.POLYGON,
                        google.maps.drawing.OverlayType.POLYLINE
                    ]
                },
                markerOptions: {editable: true, draggable: true}, 		// markers created are editable by default
                circleOptions: {editable: true},		// circles created are editable by default
                rectangleOptions: {editable: true},	// rectangles created are editable by default
                polygonOptions: {editable: true},		// polygons created are editable by default
                polylineOptions: {editable: true},		// polylines created are editable by default
            });
        }


        if (mapDiv) {
            mapObj = new google.maps.Map(mapDiv, mapOptions);
            infWindow.setMap(mapObj);
            if (_this.isEditable) {
                console.log("isEditable");
                drwManager.setMap(mapObj);
                google.maps.event.addListener(infWindow, "domready", _this.pickColor);
                google.maps.event.addListener(drwManager, "overlaycomplete", _this.overlayDone);

            }

            if (mapStorageId) {
                //mapData is passed in a HTML input as JSON string
                //create overlays using that data
                if (allowViewExample) {

                    _this.setMapData(document.getElementById(mapStorageId).value);
                }
            }

            //var ctaLayer = new google.maps.KmlLayer('http://possible.in/test3.kml');
            //ctaLayer.setMap(mapObj);
            dirRenderer = new google.maps.DirectionsRenderer();
            dirRenderer.setMap(mapObj);
            dirRenderer.setPanel(document.getElementById(mapContainerId + '_directions'));
            dirService = new google.maps.DirectionsService();
            dirTravelMode = google.maps.TravelMode.DRIVING;
            dirAvoidHighways = false;
            dirAvoidTolls = false;
            dirProvideRouteAlternatives = true;
            dirRouteUnit = google.maps.UnitSystem.METRIC;
            dirOptimizeWaypoints = true;

            mapObj.addListener('idle', function () {


            });
        }

        _this.map = mapObj;
        return mapObj;
    };


    /**************************************************
     * function setMap()
     * parameters:
     *        divId    : String, Id of HTML DIV element in which the gMap will be created
     *        edit    : Boolean(optional:default=false), tells you if the map objects can be edited or not
     *        inputId : String(optional), Id of HTML element which will be used to store/pass the serialized MAP data
     *
     **************************************************/
    this.setMap = function (divId, edit, inputId) {

        if (typeof divId == "string") {
            if (document.getElementById(divId)) {
                mapContainerId = divId;
                mapDiv = document.createElement('div');
                mapDiv.id = divId + "_map";
                _this.setStyle(mapDiv, {height: "100%", width: "100%", position: "absolute", "zIndex": 1, left: "0"});
                document.getElementById(mapContainerId).appendChild(mapDiv);
                sideBar = document.createElement('div');
                sideBar.id = divId + "_sidebar";
                _this.setStyle(sideBar, {
                    height: "100%",
                    width: "250px",
                    display: "none",
                    "backgroundColor": "#e6e6e6",
                    "borderLeft": "5px solid #999",
                    position: "absolute",
                    "zIndex": "1",
                    right: "0",
                    fontFamily: "Arial",
                    overflowY: 'auto'
                });

                document.getElementById(mapContainerId).appendChild(sideBar);
                _this.setStyle(document.getElementById(mapContainerId), {position: "relative"});
                sideBar.innerHTML =
                    '<div style="padding:10px 0 0 26px;">'
                    + '<style> div#' + sideBar.id + ' a.travelMode{ height:37px;width:32px;display:block;float:left;margin:0; background-position:bottom;background-repeat:no-repeat;outline:0;}'
                    + ' div#' + sideBar.id + ' a.travelMode:hover{ cursor:pointer; background-position:top;}'
                    + ' div#' + sideBar.id + ' span.route_row_menu{ font-size:12px;font-family:Arial; color:#ff0000; cursor:pointer; } '
                    + ' div#' + mapContainerId + '_route div.route_row span{ width:20px;height:20px;display:inline-block; text-align:center; } '
                    + ' div#' + mapContainerId + '_route_options{ font-size:12px; } '
                    + ' div#' + mapContainerId + '_directions{ font-size:12px; }'
                    + '</style>'
                    + '<a id="' + mapContainerId + '_mode_drive" href="javascript:void(0)" class="travelMode" style="background-image:url(images/car.png);background-position:top;" onclick="BlitzMap.setTravelMode( google.maps.TravelMode.DRIVING, this )" ></a>'
                    + '<a id="' + mapContainerId + '_mode_walk" href="javascript:void(0)" class="travelMode" style="background-image:url(images/walk.png);" onclick="BlitzMap.setTravelMode( google.maps.TravelMode.WALKING, this)"></a>'
                    + '<a id="' + mapContainerId + '_mode_bicycle" href="javascript:void(0)" class="travelMode" style="background-image:url(images/bicycle.png);" onclick="BlitzMap.setTravelMode( google.maps.TravelMode.BICYCLING, this )"></a>'
                    //+ '<a id="'+divId + '_mode_public" href="javascript:void(0)" class="travelMode" style="background-image:url(images/public.png);" onclick="BlitzMap.setTravelMode( google.maps.TravelMode.PUBLIC, this )"></a>'
                    + '<div style="clear:both;"></div>'
                    + '</div>'
                    + '<div id="' + mapContainerId + '_route" style="margin:5px 5px 5px;">'
                    + '<div id="' + mapContainerId + '_route_row_0" class="route_row"><span id="' + mapContainerId + '_route_row_0_title">A</span> <input  id="' + mapContainerId + '_route_row_0_dest" type="text" /><img id="' + mapContainerId + '_route_row_0_remove" alt="X" height="20" width="20" onclick="BlitzMap.removeDestination(this)" style="cursor:pointer;display:none;" /></div>'
                    + '<div id="' + mapContainerId + '_route_row_1" class="route_row"><span id="' + mapContainerId + '_route_row_1_title">B</span> <input  id="' + mapContainerId + '_route_row_1_dest" type="text" /><img id="' + mapContainerId + '_route_row_1_remove" alt="X" height="20" width="20" onclick="BlitzMap.removeDestination(this)" style="cursor:pointer;display:none;" /></div>'
                    + '</div>'
                    + '<div id="' + mapContainerId + '_route_menu" style="margin:5px 5px 5px 30px;">'
                    + '<span class="route_row_menu" onclick="BlitzMap.addDestination()">Add destination</span> - '
                    + '<span id="' + mapContainerId + '_route_opt_btn" class="route_row_menu" onclick="BlitzMap.toggleRouteOptions()">Show Options</span>'
                    + '</div>'
                    + '<div id="' + mapContainerId + '_route_options" style="margin:5px 5px;display:none;">'
                    + '<div style="float:right">'
                    + '<span id="' + mapContainerId + '_route_unit_km" onclick="BlitzMap.setRouteUnit( google.maps.UnitSystem.METRIC )">Km</span> / '
                    + '<span id="' + mapContainerId + '_route_unit_mi" class="route_row_menu"  onclick="BlitzMap.setRouteUnit( google.maps.UnitSystem.IMPERIAL )">Miles</span>'
                    + '</div>'
                    + '<div style="margin-left:20px">'
                    + '<input id="' + mapContainerId + '_route_avoid_hw" type="checkbox" value="avoidHighways" onclick="BlitzMap.setAvoidHighways(this)" /><label for="' + mapContainerId + '_route_avoid_hw">Avoid highways</label><br/>'
                    + '<input id="' + mapContainerId + '_route_avoid_toll" type="checkbox" value="avoidTolls" onclick="BlitzMap.setAvoidTolls(this)" /><label for="' + mapContainerId + '_route_avoid_toll">Avoid tolls</label> '
                    + '</div>'
                    + '</div>'
                    + '<div style="margin:0 0 10px 30px">'
                    + '<input type="button" onclick="BlitzMap.getRoute()" value="Get Directions">'
                    + '</div>'
                    + '<div style="clear:both;"></div>'
                    + '<div id="' + mapContainerId + '_directions" style="">'
                    + '</div>';
            } else {
                alert("BlitzMap Error: The DIV id you supplied for generating GMap is not present in the document.");
            }
        } else {
            alert("BlitzMap Error: The DIV id you supplied for generating GMap is invalid. It should be a string representing the Id of Div element in which you want to create the map.")
        }

        if (edit == true) {
            isEditable = true;
        }

        if (typeof inputId == "string") {

            if (document.getElementById(inputId)) {
                mapStorageId = inputId;

            } else {
                notify("BlitzMap Error: The INPUT id you supplied for storing the JSON string is not present in the document.");
            }
        }
    }

    this.setAvoidHighways = function (obj) {
        dirAvoidHighways = obj.checked;
    }

    this.setAvoidTolls = function (obj) {
        dirAvoidTolls = obj.checked;
    }

    this.setTravelMode = function (mode, menuObj) {
        dirTravelMode = mode;
        _this.setStyle(document.getElementById(mapContainerId + '_mode_drive'), {backgroundPosition: "bottom"});
        _this.setStyle(document.getElementById(mapContainerId + '_mode_walk'), {backgroundPosition: "bottom"});
        _this.setStyle(document.getElementById(mapContainerId + '_mode_bicycle'), {backgroundPosition: "bottom"});
        _this.setStyle(menuObj, {backgroundPosition: "top"});
    }

    this.getRoute = function () {
        var start, end;
        var waypts = [];
        var routeDiv = document.getElementById(mapContainerId + '_route');

        for (var i = 0; i < routeDiv.children.length; i++) {
            if (i == 0) {
                start = routeDiv.children[i].children[1].value;
            } else if (i == routeDiv.children.length - 1) {
                end = routeDiv.children[i].children[1].value;
            } else {
                waypts.push({
                    location: routeDiv.children[i].children[1].value,
                    stopover: true
                });
            }
        }

        var request = {
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: false,
            travelMode: dirTravelMode,
            avoidHighways: dirAvoidHighways,
            avoidTolls: dirAvoidTolls,
            provideRouteAlternatives: dirProvideRouteAlternatives,
            unitSystem: dirRouteUnit,
            optimizeWaypoints: dirOptimizeWaypoints
        };

        dirService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                dirRenderer.setDirections(response);
                /*var summaryPanel = document.getElementById( mapContainerId + '_directions' );
                summaryPanel.innerHTML = "";
                for( var j=0; j < response.routes.length; j++ ) {
                    var route = response.routes[j];

                    // For each route, display summary information.
                    for (var i = 0; i < route.legs.length; i++) {
                      var routeSegment = i+1;
                      summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
                      summaryPanel.innerHTML += route.legs[i].start_address + " to ";
                      summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
                      summaryPanel.innerHTML += route.legs[i].distance.text + "<br /><br />";
                    }
                }*/
            }
        });

    }


    this.addDestination = function () {
        var routeDiv = document.getElementById(mapContainerId + '_route');
        var routeNum = routeDiv.children.length;
        if (routeNum == 8) {
            alert("You have reached maximum number of destinations that can be searched with Google Directions API.")
            return;
        }
        var newDest = document.createElement('div');
        newDest.id = mapContainerId + '_route_row_' + routeNum.toString();
        newDest.className = 'route_row';

        newDest.innerHTML = '<span id="' + mapContainerId + '_route_row_' + routeNum + '_title">' + String.fromCharCode(65 + routeNum) + '</span> '
            + '<input id="' + mapContainerId + '_route_row_' + routeNum + '_dest" type="text" />'
            + '<img id="' + mapContainerId + '_route_row_' + routeNum + '_remove" alt="X" height="20" width="20" onclick="BlitzMap.removeDestination(this)" style="cursor:pointer" />';
        routeDiv.appendChild(newDest);
        for (var i = 0; i < routeDiv.children.length; i++) {
            if (i < 2 && routeDiv.children.length <= 2) {
                routeDiv.children[i].children[2].style.display = "none";
            } else {
                routeDiv.children[i].children[2].style.display = "inline";
            }
        }
    }

    this.removeDestination = function (obj) {
        var rowDiv = obj.parentNode;
        var routeDiv = rowDiv.parentNode;
        routeDiv.removeChild(rowDiv);

        for (var i = 0; i < routeDiv.children.length; i++) {
            routeDiv.children[i].id = mapContainerId + '_route_row_' + i;
            routeDiv.children[i].children[0].id = mapContainerId + '_route_row_' + i + '_title';
            routeDiv.children[i].children[0].innerHTML = String.fromCharCode(65 + i)
            routeDiv.children[i].children[1].id = mapContainerId + '_route_row_' + i + '_dest';

            routeDiv.children[i].children[2].id = mapContainerId + '_route_row_' + i + '_remove'
            if (i < 2 && routeDiv.children.length <= 2) {
                routeDiv.children[i].children[2].style.display = "none";
            } else {
                routeDiv.children[i].children[2].style.display = "inline";
            }
        }
    }

    this.setRouteUnit = function (unt) {
        dirRouteUnit = unt;
        if (dirRouteUnit == google.maps.UnitSystem.IMPERIAL) {
            document.getElementById(mapContainerId + '_route_unit_mi').className = "";
            document.getElementById(mapContainerId + '_route_unit_km').className = "route_row_menu";
        } else {
            document.getElementById(mapContainerId + '_route_unit_mi').className = "route_row_menu";
            document.getElementById(mapContainerId + '_route_unit_km').className = "";
        }
    }

    this.toggleRouteOptions = function () {
        if (_this.getStyle(document.getElementById(mapContainerId + "_route_options"), "display") == "block") {
            _this.setStyle(document.getElementById(mapContainerId + "_route_options"), {display: "none"});
            document.getElementById(mapContainerId + "_route_opt_btn").innerHTML = "Show Options";

        } else {
            _this.setStyle(document.getElementById(mapContainerId + "_route_options"), {display: "block"});
            document.getElementById(mapContainerId + "_route_opt_btn").innerHTML = "Hide Options";
        }

    }


    this.overlayDone = function (event) {
        console.log("overlayDone");
        var uniqueid = uniqid();
        event.overlay.uniqueid = uniqueid;
        event.overlay.title = "";
        event.overlay.content = "";
        event.overlay.type = event.type;
        mapOverlays.push(event.overlay);
        dataLayers = mapOverlays;

        _this._layerMap(event.overlay);
        _this.openInfowindow(event.overlay, _this.getShapeCenter(event.overlay), _this.getEditorContent(event.overlay));
    }


    this.getShapeCenter = function (shape) {
        if (shape.type == "marker") {
            return shape.position;
        } else if (shape.type == "circle") {
            return shape.getCenter();
        } else if (shape.type == "rectangle") {
            return new google.maps.LatLng((shape.getBounds().getSouthWest().lat() + shape.getBounds().getNorthEast().lat()) / 2, (shape.getBounds().getSouthWest().lng() + shape.getBounds().getNorthEast().lng()) / 2)
        } else if (shape.type == "polygon") {
            return shape.getPaths().getAt(0).getAt(0);
        } else if (shape.type == "polyline") {
            return shape.getPath().getAt(Math.round(shape.getPath().getLength() / 3));
        }
    }

    this._layerMap = function (overlay) {
        google.maps.event.addListener(overlay, "click", function (clkEvent) {
            var infContent = "";
            if (isEditable) {
                infContent = _this.getEditorContent(overlay);

            } else {
                infContent = _this.GetContent(overlay);
            }

            _this.openInfowindow(overlay, clkEvent.latLng, infContent);

        });
        google.maps.event.addListener(overlay, "bounds_changed", function () {
            console.log("bounds_changed");

        });
    }

    this.GetContent = function (overlay) {
        var content =
            '<div><h3>' + overlay.title + '</h3>' + overlay.content + '<br></div>'
            + _this.GetInfoWindowFooter(overlay);
        return content;
    }

    this.GetInfoWindowFooter = function (overlay) {
        var content =
            '<div id="' + mapContainerId + '_dirContainer" style="bottom:0;padding-top:3px; font-size:13px;font-family:arial">'
            + '<div  style="border-top:1px dotted #999;">'
            + '<style>.BlitzMap_Menu:hover{text-decoration:underline; }</style>'
            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;" onclick="BlitzMap.getDirections()">Directions</span>'
            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Search nearby</span>'
            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Save to map</span>'
            + '</div></div>';
        return "";
    }


    this.getDirections = function () {
        _this.setStyle(sideBar, {display: "block"});
        _this.setStyle(mapDiv, {width: "70%"});
        google.maps.event.trigger(mapObj, 'resize');
        //mapObj.panTo( mapObj.getBounds() );

    }


    this.openInfowindow = function (overlay, latLng, content) {
        var div = document.createElement('div');
        div.innerHTML = content;
        _this.setStyle(div, {height: "100%"});
        infWindow.setContent(div);
        infWindow.setPosition(latLng);
        infWindow.relatedOverlay = overlay;
        var t = overlay.get('fillColor');
        infWindow.open(mapObj);
    }

    this.getEditorContent = function (overlay) {

        var managerColors = '<input type="button" id="BlitzMapInfoWindow_toggle" title="Manage Colors and Styles" onclick="BlitzMap.toggleStyleEditor();return false;" style="border:0;float:right;margin-top:5px;cursor:pointer;background-color:#fff;color:#2883CE;font-family:Arial;font-size:12px;text-align:right;" value="Customize Colors&gt;&gt;" />';
        var content = '<style>'
            + '#BlitzMapInfoWindow_container input:focus, #BlitzMapInfoWindow_container textarea:focus{border:2px solid #7DB1FF;} '
            + '#BlitzMapInfoWindow_container .BlitzMapInfoWindow_button{background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;} '
            + '.BlitzMapInfoWindow_button:hover{background-color:#2883CE;border-color:#05439F;} '
            + '</style>'

            + '<form style="height:100%"><div id="BlitzMapInfoWindow_container" style="height:100%">'
            + '<div id="BlitzMapInfoWindow_details">'
            + '<div style="padding-bottom:3px;">Title:&nbsp;&nbsp;<input type="text" id="BlitzMapInfoWindow_title" value="' + overlay.title + '" style="border:2px solid #dddddd;width:150px;padding:3px;" ></div>'
            + '<div style="padding-bottom:3px;">Description:<br><textarea id="BlitzMapInfoWindow_content" style="border:2px solid #dddddd;width:250px;height:115px;">' + overlay.content + '</textarea></div>'
            + '</div>'
            + '<div id="BlitzMapInfoWindow_styles" style="display:none;width:100%;">'
            + '<div style="height:25px;padding-bottom:2px;font-weight:bold;">Styles &amp; Colors</div>';

        if (overlay.type == 'polygon' || overlay.type == 'circle' || overlay.type == 'rectangle') {

            var fillColor = (overlay.fillColor == undefined) ? "#000000" : overlay.fillColor;
            content += '<div style="height:25px;padding-bottom:3px;">Fill Color: <input type="text" id="BlitzMapInfoWindow_fillcolor" value="' + fillColor + '" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

            var fillOpacity = (overlay.fillOpacity == undefined) ? 0.3 : overlay.fillOpacity;
            content += '<div style="height:25px;padding-bottom:3px;">Fill Opacity(percent): <input min="0" max="1" type="number" id="BlitzMapInfoWindow_fillopacity" value="' + fillOpacity.toString() + '"  style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay()" ></div>';

        }
        if (overlay.type != 'marker') {

            var strokeColor = (overlay.strokeColor == undefined) ? "#000000" : overlay.strokeColor;
            content += '<div style="height:25px;padding-bottom:3px;">Line Color: <input type="text" id="BlitzMapInfoWindow_strokecolor" value="' + strokeColor + '" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

            var strokeOpacity = (overlay.strokeOpacity == undefined) ? 0.9 : overlay.strokeOpacity;
            content += '<div style="height:25px;padding-bottom:3px;">Line Opacity(percent): <input min="0" max="1"  type="number" id="BlitzMapInfoWindow_strokeopacity" value="' + strokeOpacity.toString() + '" style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay()" ></div>';

            var strokeWeight = (overlay.strokeWeight == undefined) ? 3 : overlay.strokeWeight;
            content += '<div style="height:25px;padding-bottom:3px;">Line Thickness(pixels): <input min="0"  type="number" id="BlitzMapInfoWindow_strokeweight" value="' + strokeWeight.toString() + '" style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay()" ></div>';

        } else {

            //var strokeColor = ( overlay.strokeColor == undefined )? "#000000":overlay.strokeColor;
            //content += '<div style="height:25px;padding-bottom:3px;">Line Color: <input type="text" id="BlitzMapInfoWindow_strokecolor" value="'+ strokeColor +'" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

            //var animation = overlay.getAnimation();
            //content += '<div style="height:25px;padding-bottom:3px;">Line Opacity(percent): <select id="BlitzMapInfoWindow_animation" style="border:2px solid #dddddd;width:30px;float:right" ><option value="none">None</option><option value="bounce">Bounce</option><option value="drop">Drop</option></div>';

            var icon = (overlay.icon == undefined) ? "" : overlay.icon;
            content += '<div style="height:25px;padding-bottom:3px;">Icon(): <input type="text" id="BlitzMapInfoWindow_icon" value="' + icon.toString() + '" style="border:2px solid #dddddd;width:100px;float:right" ></div>';
            managerColors = "";
        }
        content += '</div><div style="position:relative; bottom:0px;"><input type="button" value="Delete" class="BlitzMapInfoWindow_button" onclick="BlitzMap.deleteOverlay()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;" title"Delete selected shape">&nbsp;&nbsp;'
            + '<input type="button" value="OK" class="BlitzMapInfoWindow_button" onclick="BlitzMap.closeInfoWindow()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;float:right;" title="Apply changes to the overlay">'
            + '<input type="button" value="Cancel" class="BlitzMapInfoWindow_button" onclick="this.form.reset();BlitzMap.closeInfoWindow()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;float:right;">'
            + '<div style="clear:both;"></div>'
            + managerColors;
        +'<div style="clear:both;"></div>';
        +'</div>';
        +'</div></form>'


        return content;
    }


    this.pickColor = function () {

        if (document.getElementById('BlitzMapInfoWindow_fillcolor')) {
            var bgcolor = new jscolor.color(document.getElementById('BlitzMapInfoWindow_fillcolor'), {})
        }
        if (document.getElementById('BlitzMapInfoWindow_strokecolor')) {
            var bdColor = new jscolor.color(document.getElementById('BlitzMapInfoWindow_strokecolor'), {})
        }


    }

    this.deleteOverlay = function () {
        if (infWindow.relatedOverlay.id) {
            deleteData.push(
                {
                    id: infWindow.relatedOverlay.id,
                    rd_id: infWindow.relatedOverlay.rd_id
                }
            );
        }
        infWindow.relatedOverlay.setMap(null);

        infWindow.close();
    }

    this.closeInfoWindow = function () {
        this.updateOverlay();
        infWindow.close();
    }

    this.updateOverlay = function () {
        infWindow.relatedOverlay.title = document.getElementById('BlitzMapInfoWindow_title').value;
        infWindow.relatedOverlay.content = document.getElementById('BlitzMapInfoWindow_content').value;

        if (infWindow.relatedOverlay.type == 'polygon' || infWindow.relatedOverlay.type == 'circle' || infWindow.relatedOverlay.type == 'rectangle') {

            infWindow.relatedOverlay.setOptions({fillColor: '#' + document.getElementById('BlitzMapInfoWindow_fillcolor').value.replace('#', '')});
            _this.setStyle(document.getElementById('BlitzMapInfoWindow_fillcolor'), {'background-color': '#' + document.getElementById('BlitzMapInfoWindow_fillcolor').value.replace('#', '')});

            infWindow.relatedOverlay.setOptions({fillOpacity: Number(document.getElementById('BlitzMapInfoWindow_fillopacity').value)});
        }

        if (infWindow.relatedOverlay.type != 'marker') {
            infWindow.relatedOverlay.setOptions({strokeColor: '#' + document.getElementById('BlitzMapInfoWindow_strokecolor').value.replace('#', '')});

            infWindow.relatedOverlay.setOptions({strokeOpacity: Number(document.getElementById('BlitzMapInfoWindow_strokeopacity').value)});

            infWindow.relatedOverlay.setOptions({strokeWeight: Number(document.getElementById('BlitzMapInfoWindow_strokeweight').value)});
        } else {
            infWindow.relatedOverlay.setOptions({icon: document.getElementById('BlitzMapInfoWindow_icon').value});
        }
        if (currentManager) {

            currentManager.setDataFormKml();
        }
    }


    this.toggleStyleEditor = function () {
        var tmp = document.getElementById('BlitzMapInfoWindow_details');
        var tmp1 = document.getElementById('BlitzMapInfoWindow_styles');
        if (tmp) {
            if (this.getStyle(tmp, "display") == 'none') {
                _this.setStyle(tmp1, {display: "none"});
                document.getElementById('BlitzMapInfoWindow_toggle').value = "Customize Colors>>"
                _this.setStyle(tmp, {display: "block"});

            } else {
                _this.setStyle(tmp, {display: "none"});
                document.getElementById('BlitzMapInfoWindow_toggle').value = "Back>>"
                _this.setStyle(tmp1, {display: "block"});
            }

        }
    }


    this.notify = function (msg) {
        if (notifyErrors) {
            alert(msg);
        }
    }


    this.setMapData = function (jsonString) {
        if (jsonString.length == 0) {
            return false;
        }
        var inputData = JSON.parse(jsonString);
        if (inputData.zoom) {
            mapObj.setZoom(inputData.zoom);
        } else {
            mapObj.setZoom(10);
        }

        if (inputData.tilt) {
            mapObj.setTilt(inputData.tilt);
        } else {
            mapObj.setTilt(0);
        }

        if (inputData.mapTypeId) {
            mapObj.setMapTypeId(inputData.mapTypeId);
        } else {
            mapObj.setMapTypeId("hybrid");
        }

        if (inputData.center) {
            mapObj.setCenter(new google.maps.LatLng(inputData.center.lat, inputData.center.lng));
        } else {
            mapObj.setCenter(new google.maps.LatLng(19.006295, 73.309021));
        }
        var mapOverlaysCurrent = getOverLaysMaps({
            overlays: inputData.overlays,
            isEditable: isEditable
        });
        mapOverlays = mapOverlaysCurrent;
        $.each(mapOverlaysCurrent, function (key, tmpOverlay) {
            tmpOverlay.setMap(mapObj);
            _this._layerMap(tmpOverlay);
        });

    }

    this.setEditable = function (editable) {
        isEditable = editable;
        for (var i = 0; i < mapOverlays.length; i++) {
            if (mapOverlays[i].getMap() != null) {
                mapOverlays[i].setOptions({editable: isEditable});
            }
        }
    }

    this.toggleEditable = function () {
        isEditable = !isEditable;
        for (var i = 0; i < mapOverlays.length; i++) {
            if (mapOverlays[i].getMap() != null) {
                if (mapOverlays[i].setEditable) mapOverlays[i].setEditable(isEditable);
                ;
            }
        }
    }

    this.setMapFromEncoded = function (encodedString) {
        if (encodedString.length == 0) {
            return false;
        }
        var pointsArray = google.maps.geometry.encoding.decodePath(encodedString);
        var tmpBounds = new google.maps.LatLngBounds();
        for (var i = 0; i < pointsArray.length; i++) {
            tmpBounds.extend(pointsArray[i]);
        }
        var tmpOverlay;
        var ovrOptions = new Object();
        var properties = new Array('fillColor', 'fillOpacity', 'strokeColor', 'strokeOpacity', 'strokeWeight', 'icon');
        ovrOptions.strokeWidth = 2;
        ovrOptions.strokeColor = "#0000FF";
        ovrOptions.strokeOpacity = 0.8;
        ovrOptions.fillColor = "#0000FF";
        ovrOptions.fillOpacity = 0.2;
        ovrOptions.paths = [pointsArray];
        tmpOverlay = new google.maps.Polygon(ovrOptions);

        tmpOverlay.type = "polygon";
        tmpOverlay.setMap(mapObj);
        mapObj.fitBounds(tmpBounds);
        tmpOverlay.setEditable(true);

        var uniqueid = uniqid();
        tmpOverlay.uniqueid = uniqueid;
        /*		if( inputData.overlays[m].title ){
            tmpOverlay.title = inputData.overlays[m].title;
            }else{ */
        tmpOverlay.title = "";
        /* } */

        /* if( inputData.overlays[m].content ){
            tmpOverlay.content = inputData.overlays[m].content;
        }else{ */
        tmpOverlay.content = "";
        /* } */

        //attach the click listener to the overlay
        _this._layerMap(tmpOverlay);

        //save the overlay in the array
        mapOverlays.push(tmpOverlay);
        dataLayers = mapOverlays;

    }

    this.setMapFromKML = function (kmlString) {
        if (kmlString.length == 0) {
            return false;
        }
        if (typeof geoXML3 == "undefined") { // check for include of geoxml3 parser
            // http://code.google.com/p/geoxml3/
            alert("geoxml3.js not included");
            return;
        }
        if (!geoXml)
            geoXml = new geoXML3.parser({
                map: mapObj,
                zoom: false,
                suppressInfoWindows: true
            });

        geoXml.parseKmlString(kmlString);

        var tmpOverlay, ovrOptions;
        for (var m = 0; m < geoXml.docs[0].placemarks.length; m++) {
            if (geoXml.docs[0].placemarks[m].Polygon) {

                tmpOverlay = geoXml.docs[0].placemarks[m].polygon;
                if (isEditable) {
                    tmpOverlay.setEditable(true);
                }
                tmpOverlay.type = "polygon";
            } else if (geoXml.docs[0].placemarks[m].LineString) {

                tmpOverlay = geoXml.docs[0].placemarks[m].polyline;
                if (isEditable) {
                    tmpOverlay.setEditable(true);
                }
                tmpOverlay.type = "polyline";
            } else if (geoXml.docs[0].placemarks[m].Point) {

                tmpOverlay = geoXml.docs[0].placemarks[m].marker;
                tmpOverlay.type = "marker";
            }

            if (tmpOverlay) {

                var uniqueid = uniqid();

                tmpOverlay.uniqueid = uniqueid;
                if (geoXml.docs[0].placemarks[m].name) {
                    tmpOverlay.title = geoXml.docs[0].placemarks[m].name;
                } else {
                    tmpOverlay.title = "";
                }

                if (geoXml.docs[0].placemarks[m].description) {
                    tmpOverlay.content = geoXml.docs[0].placemarks[m].description;
                } else {
                    tmpOverlay.content = "";
                }

                //attach the click listener to the overlay
                _this._layerMap(tmpOverlay);

                //save the overlay in the array
                mapOverlays.push(tmpOverlay);
            }
            dataLayers = mapOverlays;
            mapObj.fitBounds(geoXml.docs[0].bounds);
        }
    }

    this.deleteAll = function () {
        for (var i = 0; i < mapOverlays.length; i++) {
            mapOverlays[i].setMap(null)
        }
        mapOverlays = [];
        dataLayers = mapOverlays;

    }

    this.mapToObject = function () {
        var tmpMap = new Object;
        var tmpOverlay, paths;
        tmpMap.zoom = mapObj.getZoom();
        tmpMap.tilt = mapObj.getTilt();
        tmpMap.mapTypeId = mapObj.getMapTypeId();
        tmpMap.center = {lat: mapObj.getCenter().lat(), lng: mapObj.getCenter().lng()};
        tmpMap.overlays = new Array();
        tmpMap.overlays = getLayersMap({haystack: mapOverlays});
        return tmpMap;

    }

    this.getDataMapLayersConfig = function () {
        var resultObj = _this.mapToObject();
        var resultString = JSON.stringify(resultObj);

        if (mapStorageId) {
            document.getElementById(mapStorageId).value = resultString;
        }
        var result = {
            string: resultString,
            object: resultObj
        }
        return result;
    }

    this.drawCircle = function (point, radius, dir) {
        var d2r = Math.PI / 180;   // degrees to radians
        var r2d = 180 / Math.PI;   // radians to degrees
        var earthsradius = 6378137; // 6378137 is the radius of the earth in meters

        var points = 64;

        // find the raidus in lat/lon
        var rlat = (radius / earthsradius) * r2d;
        var rlng = rlat / Math.cos(point.lat() * d2r);


        var extp = new Array();
        if (dir == 1) {
            var start = 0;
            var end = points + 1
        } // one extra here makes sure we connect the
        else {
            var start = points + 1;
            var end = 0
        }
        for (var i = start; (dir == 1 ? i < end : i > end); i = i + dir) {
            var theta = Math.PI * (i / (points / 2));
            ey = point.lng() + (rlng * Math.cos(theta)); // center a + radius x * cos(theta)
            ex = point.lat() + (rlat * Math.sin(theta)); // center b + radius y * sin(theta)
            extp.push(new google.maps.LatLng(ex, ey));
            bounds.extend(extp[extp.length - 1]);
        }
        // alert(extp.length);
        return extp;
    }

    this.toKML = function () {
        var result = _this.mapToObject();
        var xw = new XMLWriter('UTF-8');
        xw.formatting = 'indented';//add indentation and newlines
        xw.indentChar = ' ';//indent with spaces
        xw.indentation = 2;//add 2 spaces per level

        xw.writeStartDocument();
        xw.writeStartElement('kml');
        xw.writeAttributeString("xmlns", "http://www.opengis.net/kml/2.2");
        xw.writeStartElement('Document');

        for (var i = 0; i < result.overlays.length; i++) {
            xw.writeStartElement('Placemark');
            xw.writeStartElement('name');
            xw.writeCDATA(result.overlays[i].title);
            xw.writeEndElement();
            xw.writeStartElement('description');
            xw.writeCDATA(result.overlays[i].content);
            xw.writeEndElement();
            if (result.overlays[i].type == "marker") {

                xw.writeStartElement('Point');
                xw.writeElementString('extrude', '1');
                xw.writeElementString('altitudeMode', 'relativeToGround');
                xw.writeElementString('coordinates', result.overlays[i].position.lng.toString() + "," + result.overlays[i].position.lat.toString() + ",0");
                xw.writeEndElement();

            } else if (result.overlays[i].type == "polygon" || result.overlays[i].type == "rectangle" || result.overlays[i].type == "circle") {
                xw.writeStartElement('Polygon');
                xw.writeElementString('extrude', '1');
                xw.writeElementString('altitudeMode', 'relativeToGround');

                if (result.overlays[i].type == "rectangle") {
                    //its a polygon
                    xw.writeStartElement('outerBoundaryIs');
                    xw.writeStartElement('LinearRing');
                    xw.writeStartElement("coordinates");
                    xw.writeString(result.overlays[i].bounds.sw.lng + "," + result.overlays[i].bounds.sw.lat + ",0");
                    xw.writeString(result.overlays[i].bounds.ne.lng + "," + result.overlays[i].bounds.sw.lat + ",0");
                    xw.writeString(result.overlays[i].bounds.ne.lng + "," + result.overlays[i].bounds.ne.lat + ",0");
                    xw.writeString(result.overlays[i].bounds.sw.lng + "," + result.overlays[i].bounds.ne.lat + ",0");
                    xw.writeEndElement();
                    xw.writeEndElement();
                    xw.writeEndElement();
                }
                if (result.overlays[i].type == "circle") {
                    //its a polygon
                    xw.writeStartElement('outerBoundaryIs');
                    xw.writeStartElement('LinearRing');
                    xw.writeStartElement("coordinates");
                    var d2r = Math.PI / 180;   // degrees to radians
                    var r2d = 180 / Math.PI;   // radians to degrees
                    var earthsradius = 6378137; // 6378137 is the radius of the earth in meters
                    var dir = 1; // clockwise

                    var points = 64;

                    // find the raidus in lat/lon
                    var rlat = (result.overlays[i].radius / earthsradius) * r2d;
                    var rlng = rlat / Math.cos(result.overlays[i].center.lat * d2r);

                    var extp = new Array();
                    if (dir == 1) {
                        var start = 0;
                        var end = points + 1
                    } // one extra here makes sure we connect the line
                    else {
                        var start = points + 1;
                        var end = 0
                    }
                    for (var j = start; (dir == 1 ? j < end : j > end); j = j + dir) {
                        var theta = Math.PI * (j / (points / 2));
                        ey = result.overlays[i].center.lng + (rlng * Math.cos(theta)); // center a + radius x * cos(theta)
                        ex = result.overlays[i].center.lat + (rlat * Math.sin(theta)); // center b + radius y * sin(theta)
                        xw.writeString(ey + "," + ex + ",0");
                    }
                    xw.writeEndElement();
                    xw.writeEndElement();
                    xw.writeEndElement();
                } else {
                    var type = result.overlays[i].type;
                    var currrentLength = 0;
                    if (type == "polyline") {

                    } else if (type == "rectangle") {

                    } else if (type == "polygon") {
                        currrentLength = result.overlays[i].paths.length;
                    }
                    for (var j = 0; j < currrentLength; j++) {
                        if (j == 0) {
                            xw.writeStartElement('outerBoundaryIs');
                        } else {
                            xw.writeStartElement('innerBoundaryIs');
                        }
                        xw.writeStartElement('LinearRing');
                        xw.writeStartElement("coordinates");
                        for (var k = 0; k < result.overlays[i].paths[j].length; k++) {
                            xw.writeString(result.overlays[i].paths[j][k].lng + "," + result.overlays[i].paths[j][k].lat + ",0");
                        }
                        xw.writeEndElement();
                        xw.writeEndElement();
                        xw.writeEndElement();
                    }
                }
                xw.writeEndElement();

            } else if (result.overlays[i].type == "polyline") {
                xw.writeStartElement('LineString');
                xw.writeElementString('extrude', '1');
                xw.writeElementString('altitudeMode', 'relativeToGround');
                xw.writeStartElement("coordinates");
                for (var j = 0; j < result.overlays[i].path.length; j++) {
                    xw.writeString(result.overlays[i].path[j].lng + "," + result.overlays[i].path[j].lat + ",0");
                }
                xw.writeEndElement();
                xw.writeEndElement();

            }

            xw.writeEndElement(); // END PlaceMarker
        }

        xw.writeEndElement();
        xw.writeEndElement();
        xw.writeEndDocument();

        var xml = xw.flush(); //generate the xml string
        xw.close();//clean the writer
        xw = undefined;//don't let visitors use it, it's closed
        //set the xml
        document.getElementById('kmlString').value = xml;
    }

    this.getStyle = function (elem, prop) {

        if (document.defaultView && document.defaultView.getComputedStyle) {
            return document.defaultView.getComputedStyle(elem, null).getPropertyValue(prop);
        } else if (elem.currentStyle) {
            var ar = prop.match(/\w[^-]*/g);
            var s = ar[0];
            for (var i = 1; i < ar.length; ++i) {
                s += ar[i].replace(/\w/, ar[i].charAt(0).toUpperCase());
            }
            return elem.currentStyle[s];
        } else {
            return 0;
        }
    }

    this.setStyle = function (domElem, styleObj) {

        if (typeof styleObj == "object") {
            for (var prop in styleObj) {
                domElem.style[prop] = styleObj[prop];
            }
        }
    }
    this.setCenter = function (latlng) {

        mapObj.setCenter(latlng);


    }
    this.getOverLays = function () {

        return mapOverlays;
    };

    this.markerEventCurrent = {
        'eventName': '',
        'data': null
    };
    this.markerMainConfig = {
        marker: null
    };
    this.addMarker = function (params) {
        var markerOptions = params.marker;
        var map = params.map;
        var content = params.content;
        this.markers.push(markerOptions); // add marker to array
        markerOptions.setMap(map);
        if (params.hasOwnProperty('main')) {

            $this.markerMainConfig = {
                marker: markerOptions
            };
        }
    }
    this._markersCurrent = function (marker) {


        var eventName = '';
        google.maps.event.addListener(marker, 'dragstart', function () {
            console.log("dragstart");
            if (_this.allowEmmitEventsParent) {
                var typeEvent = 'dragstart';
                var dataCurrent = marker;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            eventName = 'dragstart';
            $this.markerEventCurrent = {
                'eventName': eventName,
                'data': marker
            };
        });

        google.maps.event.addListener(marker, 'drag', function () {

            if (_this.allowEmmitEventsParent) {
                var typeEvent = 'drag';
                var dataCurrent = marker;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            eventName = 'drag';
            $this.markerEventCurrent = {
                'eventName': eventName,
                'data': marker
            };
        });

        google.maps.event.addListener(marker, 'dragend', function () {

            if (_this.allowEmmitEventsParent) {
                var typeEvent = 'dragend';
                var dataCurrent = marker;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            eventName = 'dragend';
            $this.markerEventCurrent = {
                'eventName': eventName,
                'data': marker
            };
        });
        google.maps.event.addListener(marker, 'click', function () {
            if (_this.allowEmmitEventsParent) {
                var typeEvent = 'click';
                var dataCurrent = {
                    map:$this.map,
                    marker:marker
                };
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            eventName = 'click';
            $this.markerEventCurrent = {
                'eventName': eventName,
                'data': marker
            };
        });
    };
    this.optionsEventsMap = {
        bounds_changed: {
            data: null,
            eventInit: false
        },
        click: {
            data: null,
            eventInit: false
        },
        dblclick: {
            data: null,
            eventInit: false
        },
        mouseup: {
            data: null,
            eventInit: false
        },
        mousedown: {
            data: null,
            eventInit: false
        },
        mouseover: {
            data: null,
            eventInit: false
        },
        zoom_changed: {
            data: null,
            eventInit: false
        },

        mouseout: {
            data: null,
            eventInit: false
        }
    };
    this._mapOptions = function (params) {
        var map = params.map;
        var typeEvent = '';
        var dataCurrent = {};
        var nameEvent = '';
        map.addListener('bounds_changed', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'bounds_changed';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'bounds_changed';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });

        map.addListener('click', function () {

            if (_this.allowEmmitEventsParent) {
                typeEvent = 'click_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'click_map';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('dblclick', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'dblclick_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'dblclick';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('mouseup', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'mouseup_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'mouseup';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('mousedown', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'mousedown_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'mousedown';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('mouseover', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'mouseover_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'mouseover';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('mouseout', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'mouseout_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'mouseout';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });

        map.addListener('zoom_changed', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'zoom_changed_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'zoom_changed';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
        map.addListener('dragend', function () {
            if (_this.allowEmmitEventsParent) {
                typeEvent = 'dragend_map';
                dataCurrent = map;
                _this.$parentThis._managerEvents({
                    typeEvent: typeEvent,
                    data: dataCurrent
                });
            }
            nameEvent = 'dragend';
            _this.optionsEventsMap[nameEvent] = {
                data: map,
                eventInit: true
            };
        });
    };
}

