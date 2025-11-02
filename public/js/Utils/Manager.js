var $methodsFormValid = {
    onInitEventClickTimerForm: onInitEventClickTimerForm,//CHANGE-FORM
    onInitEventClickForm: onInitEventClickForm,//CHANGE-FORM
    onListenElementsForm: onListenElementsForm,//CHANGE-FORM
};

function getCSSCurrentBootGrid() {


    //https://fontawesome.com/search?q=sort&o=r
    //fa fa-solid fa-sort-up
    //fa fa-solid fa-sort-down
    var result = {
        header: "bootgrid-header",
        table: "xywer-tbl-admin",
        iconRefresh: "remixicon-refresh-line",
        iconDown: "fa-sort-down",
        iconUp: "fa-sort-up",


    };

    return result;
}

function getValidateForm(params) {
    var success = true;
    var errors = [];
    var notValidate = [
        '$model', "$invalid", '$dirty', '$anyDirty', '$error', "$anyError", '$pending', '$params'

    ];
    var modelAttributes = {};
    if (typeof (params) != 'undefined') {

        if (params.hasOwnProperty('model')) {
            modelAttributes = params.model.attributes;
        }

    } else {
        if (typeof (this.$v.model.attributes) == 'object') {
            modelAttributes = this.$v.model.attributes;
        }
    }

    $.each(modelAttributes, function (key, value) {
        var allowValidate = $.inArray(key, notValidate) == 0 ? false : true;
        if (allowValidate) {
            if (value.$invalid) {

                errors.push(
                    {
                        'field': value,
                        'name': key
                    }
                );
                success = false;
            }
        }
    });

    var result = {
        success: success,
        errors: errors
    };
    return result;
}

function viewGetLabelForm(nameId, model) {
    var labelName;
    if (model) {
        labelName = model['structure'][nameId].label + (model['structure'][nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

    } else {
        labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

    }
    return labelName;
}
function onInitEventClickTimerForm(params) {
    var _this = this;
    var initData = setTimeout(function () {
        _this.onInitEventClickForm();
    }, 1000);
    setTimeout(function () {
        clearTimeout(initData);
        console.log('Temporizador original cancelado después de 5 segundos');
    }, 5000);
}
function onInitEventClickForm(params) {
    var _this = this;
    $('form').off('click');
    $('form').on('click', function (e) {
        if (e.target.nodeName == 'BUTTON' || e.target.nodeName === 'INPUT' || e.target.nodeName === 'SELECT' || e.target.nodeName === 'CHECKBOX' || e.target.nodeName === 'RADIO' || e.target.nodeName == 'SPAN' || e.target.nodeName === 'TEXTAREA' || e.target.nodeName === 'DIV') {
            var targetName = $(e.target).attr('name');
            var objectElement = null;
            var elementCurrentName = null;
            if (e.target.nodeName === 'DIV') {
                if ($(e.target).attr('class') == 'note-editable card-block') {

                    targetName = $(e.target).parent().parent().parent().find('textarea').attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                } else if ($(e.target).attr('class') == 'switch-button enabled') {
                    targetName = $(e.target).parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                } else if ($(e.target).attr('class') == 'button') {
                    targetName = $(e.target).parent().parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                }
            }

            if ($(e.target).attr('type') == 'file') {
                targetName = $(e.target).attr('name');
                elementCurrentName = getValuesEntity({
                    value: targetName
                });
            }
            if (e.target.nodeName == 'BUTTON') {
                if ($(e.target).attr('class') == 'datetime-picker__button') {
                    targetName = $(e.target).parent().attr('id');
                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });
                }
            }
            if (e.target.nodeName === 'SPAN') {
                if ($(e.target).attr('class') == 'select2-selection__rendered') {
                    elementCurrentName = $(e.target).attr('id').split('select2-')[1].split('-container')[0];
                } else if ($(e.target).attr('class') == 'select2-selection__placeholder') {
                    elementCurrentName = $(e.target).parent().attr('id').split('select2-')[1].split('-container')[0];
                }
            } else {
                var nameModel = _this.formConfig.nameModel;
                if (nameModel) {
                    if (_this.$v) {
                        if (_this.$v.model) {
                            elementCurrentName = getValuesEntity({
                                value: targetName
                            });

                        } else if (_this.$v.modelGallery) {
                            elementCurrentName = getValuesEntity({
                                value: targetName
                            });
                        } else if (false) {

                        }
                    }


                } else {

                    elementCurrentName = getValuesEntity({
                        value: targetName
                    });


                }
                // ;
            }
            if (_this.$v) {
                if (_this.$v.model) {
                    objectElement = _this.$v.model.attributes[elementCurrentName];

                } else if (_this.$v.modelGallery) {
                    objectElement = _this.$v.modelGallery.attributes[elementCurrentName];

                } else if (_this.$v.modelRoutes) {
                    objectElement = _this.$v.modelRoutes.attributes[elementCurrentName];

                } else if (_this.$v.modelPanorama) {
                    objectElement = _this.$v.modelPanorama.attributes[elementCurrentName];

                }
            } else {

            }

            if (objectElement && elementCurrentName) {
                _this.onListenElementsForm({
                    'element': elementCurrentName,
                    objectElement: objectElement
                });
            }


        }

    });

}
function $_initAutocomplete(params) {
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
}

function onListenElementsForm(params) {
    params.objectElement.$touch();

}
//GOOGLE MAPS
var $managerGoogleMaps = {
    _initMap: $_initMap,
    managerStructureCurrentLocation: $managerStructureCurrentLocation,//ROOT DATA
    getStructureLocation: $getStructureLocation,
    getFormattedInformation: $getFormattedInformation,
    //MARKERS
    _markersCurrent: $_markersCurrent,
    fillInAddress: $fillInAddress,
    _mapCurrent: $_mapCurrent,
    _initAutocomplete: $_initAutocomplete,

};
function $_mapCurrent(params) {
    var mapCurrent = params.mapCurrent;
    var marker = params.marker;

    var dataCurrent = params.data;

    var vCurrent = this;
    mapCurrent.addListener('idle', function () {
        var latLngCurrent = {lng: mapCurrent.getCenter().lng(), lat: mapCurrent.getCenter().lat()};
        vCurrent.managerStructureCurrentLocation({
            type: "idle",
            "configSearch": {'latLng': latLngCurrent},
            data: dataCurrent,
            mapInit: mapCurrent,
            marker: marker
        });
    });

}

function $fillInAddress(params) {
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
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

}

function $_markersCurrent(params) {
    var $scope = this;
    var marker = params.marker;
    var dataCurrent = params.data;
    var mapCurrent = params.mapCurrent;
    google.maps.event.addListener(marker, 'dragend', function () {
        var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
        $scope.managerStructureCurrentLocation({
            type: "dragend",
            "configSearch": {'latLng': latLngCurrent},
            data: dataCurrent,
            mapInit: mapCurrent,
            marker: marker
        });
    });
    google.maps.event.addListener(marker, 'click', function () {
        var latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};
        if (marker.content) {

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
        }
        mapCurrent.panTo(latLngCurrent);
        mapCurrent.setZoom(17);

    });
}

function $getStructureLocation(params) {
    var haystack = params.haystack;
    var vCurrent = this;
    var options_map = params.options_map;
    var current_location_structure = {
        country_code_id: "",//*
        administrative_area_level_2: "",//*
        administrative_area_level_1: "",//*
        administrative_area_level_3: "",
        options_map: options_map
    };
    var haystackLocations = [["country", "political"], ["administrative_area_level_1", "political"], ["administrative_area_level_2", "political"]];
    $.each(haystackLocations, function (indexRow, valueRow) {
        var foundCurrent = vCurrent.getFormattedInformation(valueRow, haystack);
        var nameMain = valueRow[0];
        if (foundCurrent) {
            if (nameMain == "country") {
                current_location_structure["country_code_id"] = foundCurrent["place_id"];
            } else if (nameMain == "administrative_area_level_1") {
                current_location_structure["administrative_area_level_1"] = foundCurrent["place_id"];

            } else if (nameMain == "administrative_area_level_2") {
                current_location_structure["administrative_area_level_2"] = foundCurrent["place_id"];

            } else if (nameMain == "administrative_area_level_3") {
                current_location_structure["administrative_area_level_3"] = foundCurrent["place_id"];

            }
        }
    });

    var result = current_location_structure;
    return result;
}

function $getFormattedInformation(needle, haystack) {
    var result = null;
    $.each(haystack, function (indexRow, valueRow) {

        if (isEqualArrays(valueRow["types"], needle)) {
            result = valueRow
            return result;
        }
    });
    return result;
}
function $managerStructureCurrentLocation(params) {
    var $scope = this;
    var vCurrent = $scope;
    var type = params.type;
    var configSearch = params.configSearch;
    var mapInit = params.mapInit;
    var modelCurrentRow = null;
    modelCurrentRow = params.data;
    if (type == "_searchMap") {
    } else if (type == "idle") {

    } else if (type == "dragend") {


    }
    var options_map = null;
    var markerInit = params.marker;
    var geocoder = new google.maps.Geocoder();
    console.log('$managerStructureCurrentLocation');
    geocodeSearch({
        geocoder: geocoder,
        configSearch: configSearch,

    }).then(function (response) {
        var haystack = response.data;
        var dataSendParams = {};
        if (response.success) {
            if (type == "_searchMap") {

            } else if (type == "idle") {
                options_map = {
                    zoom: mapInit.getZoom(),
                    latLng: {
                        lat: markerInit.getPosition().lat(),
                        lng: markerInit.getPosition().lng()
                    }
                };
                dataSendParams = {
                    haystack: haystack,
                    vModel: modelCurrentRow,
                    options_map: options_map

                };
            } else if (type == "dragend") {
                options_map = {
                    zoom: mapInit.getZoom(),
                    latLng: {
                        lat: markerInit.getPosition().lat(),
                        lng: markerInit.getPosition().lng()
                    }

                };
                dataSendParams = {
                    haystack: haystack,
                    vModel: modelCurrentRow,
                    options_map: options_map
                };
            }
            var resultDataLocation = getDataLocationMap({
                data: dataSendParams,
                vCurrent: vCurrent,
                isErrorGoogle: false
            });
            vCurrent.model.attributes['options_map'] = resultDataLocation.optionsMap;
            vCurrent.model.attributes['information_address_location_current'] = resultDataLocation.information_address_location_current;
        }
    }).catch(function (response) {

        if (type == "_searchMap") {
            $scope.makeToast({
                "title": "Información",
                msj: "No existe información sobre este lugar:" + configSearch.address,
                "type": "warning"
            });
        }
        if (type == "idle") {

        }
        //ERROR DATA
        var resultDataLocation = getDataLocationMap({
            vCurrent: vCurrent,
            isErrorGoogle: true
        });
        vCurrent.model.attributes['options_map'] = resultDataLocation.optionsMap;
        vCurrent.model.attributes['information_address_location_current'] = resultDataLocation.information_address_location_current;
    });
}

function $_initMap(params) {
    $('.pac-container').remove();
    var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
        name: "Greyscale"
    });
    var mapOptions = {};


    var zoom = 15;
    if (params.data.model.options_map.$model) {
        var currentValue = params.data.model.options_map.$model;
        if (typeof (currentValue) == "string") {
            var mapOptionsRow = jQuery.parseJSON(currentValue);
            if (mapOptionsRow.zoom) {
                latLngCurrent = {
                    lat: parseFloat(mapOptionsRow.latLng.lat),
                    lng: parseFloat(mapOptionsRow.latLng.lng)
                };
                zoom = mapOptionsRow.zoom;
            }
        }
    }
    var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
    //var icon_mapa_url = pathDevelopers + "assets/images/markers/merceria.png";
    mapOptions = {
        title: "Ubicacion",
        panControl: true,
        scrollwheel: false,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        draggable: true,
        center: latLngCurrent,
        zoom: zoom,
        animation: google.maps.Animation.DROP,
        icon: icon_mapa_url

    };


    var objSelector = params.objSelector;
    var dataCurrent = params.data.model;
    var mapCurrent = new google.maps.Map(objSelector, mapOptions);
    var key = 1;

    var key_id = key;
    var info_name = "Mueva el Marker.";
    var msg = key_id + " " + info_name;

    var width = 40, height = 40;
    var urlIcon = "https://furtaev.ru/preview/user_on_map.png";
    var iconCurrent = {
        url: urlIcon,
        scaledSize: new google.maps.Size(width, height), // scaled size
    };
    var marker_object = new google.maps.Marker({
        draggable: true,
        title: info_name,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(latLngCurrent.lat, latLngCurrent.lng),
        icon: iconCurrent,
    });

    mapCurrent.mapTypes.set('greyscale_style', greyStyleMap);
    mapCurrent.setMapTypeId('greyscale_style');
    this._mapCurrent({
        mapCurrent: mapCurrent,
        marker: marker_object,
        data: dataCurrent,

    });
    marker_object.setMap(mapCurrent);
    this._markersCurrent({
        marker: marker_object,
        mapCurrent: mapCurrent,
        data: dataCurrent
    });
    mapCurrent.setCenter(latLngCurrent);
    var paramsAutocomplete = {
        mapCurrent: mapCurrent,
        marker: marker_object,
        dataCurrent: dataCurrent
    };
    this._initAutocomplete(paramsAutocomplete);
}
