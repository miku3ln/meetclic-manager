var currentDataLatLng;
var default_latitude = 0.3444677;
var default_longitude = -78.1222843;

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
function setValuesFrm(lat, lng){
    $("#business_street_lat").val(lat);
    $("#business_street_lng").val(lng);

}


