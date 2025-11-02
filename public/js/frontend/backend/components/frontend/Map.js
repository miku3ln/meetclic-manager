var componentThisMap;
var BlitzMap;
Vue.component('map-component', {
    template: '#map-template',
    directives: {
        'init-map-current': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                $this = paramsInput.this;
                $this.initMap();
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.initData = this.configParams;
        this.template_information_id = this.configParams.template_information_id;
        this.id = this.configParams.id;

    },
    mounted: function () {
        componentThisMap = this;
        this.initCurrentComponent();
    },
    data: function () {

        var dataManager = {
            map: null,
            mapConfig: {
                'selectorInit': 'myMapCurrent'
            }
            , initData: null,
            viewManagerSave: false,
            blitzMap: null,
            id: null,
            template_information_id: null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {


        },
//EVENTS OF CHILDREN
        initMap: function (params) {
            var isEditable = this.initData.hasOwnProperty('isEditable') ? this.initData['isEditable'] : false;
            BlitzMap = new UtilBlitzMap(
                {
                    isEditable: isEditable,
                    currentManager: this
                }
            );
            var mapSelector = this.mapConfig.selectorInit;
            BlitzMap.setMap(mapSelector, true, 'mapData');
            var latLng = this.initData.latLng;

            var options = {
                latLng, allowEmmitEventsParent: true,
                parentThis: this
            };
            if (this.initData.options_map) {
                options = {
                    latLng, allowEmmitEventsParent: true,
                    parentThis: this,
                    options:this.initData.options_map
                };
            }
            mapObjCurrent = BlitzMap.initMap(options
            )
            ;
            this.map = mapObjCurrent;


            var urlIcon = this.initData.icon? $resourceRoot+this.initData.icon: "https://furtaev.ru/preview/user_on_map.png";
            var content = "<div>" + this.initData.description + "</div>";
            var width = 30, height = 40;
            var iconCurrent = {
                url: urlIcon,
                scaledSize: new google.maps.Size(width, height), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            var markerObject = new google.maps.Marker({
                draggable: true,
                title: this.initData.title,
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(latLng.lat, latLng.lng),
                icon: iconCurrent,
                content: content,
                'main': true
            });
            var params_data = {map: mapObjCurrent, marker: markerObject, content: content, main: true};
            BlitzMap.addMarker(params_data);
            BlitzMap._markersCurrent(markerObject);


            BlitzMap._mapOptions(
                {
                    map: this.map
                }
            );
            var mapCurrent = mapObjCurrent;
            var paramsAutocomplete = {mapCurrent: mapCurrent, marker: markerObject, dataCurrent: []};
            this._initAutocomplete(paramsAutocomplete);

            this.blitzMap = BlitzMap;
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
            this._managerEvents({
                typeEvent: 'searchMap',
                data: place
            });
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
        setDataFormKml: function () {
            var resultData = BlitzMap.getDataMapLayersConfig();
            this.setValuesKml(resultData);
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
        getDataKmlString: function (params) {
            var resultData = params.resultData;
            var routes_drawing_data = resultData.object.overlays;
            var result = {
                routes_drawing_data: routes_drawing_data
            };
            return result;
        },
        _managerEvents: function (params) {

            if (params.typeEvent == 'click' || params.typeEvent == 'dragend' || params.typeEvent == 'zoom_changed_map'|| params.typeEvent == 'dragend_map') {
                var position = {lat: 0, lng: 0};
                var options_map = null;
                if (params.typeEvent == 'click') {
                    position = {lat: params.data.marker.position.lat(), lng: params.data.marker.position.lng};
                } else if (params.typeEvent == 'dragend') {
                    this.viewManagerSave = true;

                    position = {lat: params.data.position.lat(), lng: params.data.position.lng};
                } else if (params.typeEvent == 'zoom_changed_map') {

                    this.viewManagerSave = true;

                }
                else if (params.typeEvent == 'dragend_map') {

                    this.viewManagerSave = true;

                }
            }

            this.$root.$emit("_updateValuesMap", params);

        },
        getOptionsMap: function () {
            var tmpMap = new Object;

            tmpMap.zoom = this.map.getZoom();
            tmpMap.title = this.map.getTilt();
            tmpMap.mapTypeId = this.map.getMapTypeId();
            tmpMap.center = {lat: this.map.getCenter().lat(), lng: this.map.getCenter().lng()};
            return tmpMap;
        },
        getLatLngCurrent: function () {

        },
        _saveOptionsMap: function () {
            var options_map = this.getOptionsMap();
            var lat = this.blitzMap.markerMainConfig.marker.position.lat();
            var lng = this.blitzMap.markerMainConfig.marker.position.lng();
            var $this = this;
            var dataSendResult = {

                "Business": {
                    id: this.id,
                    options_map: JSON.stringify(options_map),
                    street_lat: lat,
                    street_lng: lng,
                    template_information_id: this.template_information_id,


                }
            };
            var dataSend = dataSendResult;
            ajaxRequest($('#action-business-saveDataFrontend').val(), {
                type: 'POST',
                data: dataSend,
                blockElement: ("#tab-template-contact-us"),//opcional: es para bloquear el elemento
                loading_message: 'Iniciando.....',
                error_message: 'Error al actualizar información.',
                success_message: 'Actuzalizado Correctamente.',
                success_callback: function (response) {

                    if (response.success) {
                        var dataSave = response['data'];
                        var business = dataSave['business'];

                    }

                    $this.viewManagerSave = false;

                }
            });
        }
    }
})
;




