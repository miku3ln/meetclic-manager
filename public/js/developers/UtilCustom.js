function getCategories() {
    var result;
    result = [
        {id: 1, text: "Comida & Bebida"},
        {id: 2, text: "Que Hacer"},
        {id: 3, text: "Compras"},
        {id: 4, text: "Servicios"}
    ];
    return result;
}

function getDataShortCut() {
    return [
        {value: 0, text: "Ruta Turistica"},
        {value: 1, text: "Ruta Transito"},
        {value: 2, text: "Ruta Historica"},
        {value: 3, text: "Ruta Tematica"},
        {value: 4, text: "Chakiñan"},
        {value: 5, text: "Atractivo Túristico"}
    ];
}

function getShortCutById(id) {
    var haystack = getDataShortCut();
    return haystack.filter(function (index) {
        return index.value == id;
    })[0];
}

function getDataAdventureType() {
    var resourceCurrent = $resourcesCustom + "frontend/wulpyme/adventureType/";
    return [
        {value: 0, text: "Apnea deporte", src: resourceCurrent + "apnea.png"},
        {
            value: 1,
            text: "Cicloturismo",
            src: resourceCurrent + "bicycleTouring.png"
        },
        {
            value: 2,
            text: "Bungee/Puenting",
            src: resourceCurrent + "bungee.jpg"
        },
        {value: 3, text: "Rafting", src: resourceCurrent + "rafting.png"},
        {value: 4, text: "Cabalgata", src: resourceCurrent + "ride.png"},
        {
            value: 5,
            text: "Montañismo/Andinismo",
            src: resourceCurrent + "mountaineering.png"
        },
        {value: 6, text: "Senderismo", src: resourceCurrent + "trekking.png"},
        {
            value: 7,
            text: "Ciclismo de montaña",
            src: resourceCurrent + "mountainBiking.png"
        },
        {value: 8, text: "Escalada", src: resourceCurrent + "climbing.png"},
        {
            value: 9,
            text: "Canopy/Tirolesas",
            src: resourceCurrent + "canopy.png"
        },
        {value: 10, text: "Camping", src: resourceCurrent + "camping.jpg"},
        {
            value: 11,
            text: "Overlanding",
            src: resourceCurrent + "overLanding.png"
        },
        {value: 12, text: "Rápel", src: resourceCurrent + "rappel.png"},
        {
            value: 13,
            text: "Vías ferratas",
            src: resourceCurrent + "viaFerrata.png"
        },
        {
            value: 14,
            text: "Barranquismo",
            src: resourceCurrent + "canyoning.png"
        },
        {
            value: 15,
            text: "Parapente",
            src: resourceCurrent + "paragliding.png"
        }
    ];
}

function getAdventureTypeById(id) {
    var haystack = getDataAdventureType();
    return haystack.filter(function (index) {
        return index.value == id;
    })[0];
}

/*https://developers.google.com/places/web-service/supported_types*/
function getPlaceTypes(type = null) {
    var placesTypes = [
        {type: 1, id: "accounting"},
        {type: 1, id: "airport"},
        {type: 1, id: "amusement_park"},
        {type: 1, id: "aquarium"},
        {type: 1, id: "art_gallery"},
        {type: 1, id: "atm"},
        {type: 1, id: "bakery"},
        {type: 1, id: "bank"},
        {type: 1, id: "bar"},
        {type: 1, id: "beauty_salon"},
        {type: 1, id: "bicycle_store"},
        {type: 1, id: "book_store"},
        {type: 1, id: "bowling_alley"},
        {type: 1, id: "bus_station"},
        {type: 1, id: "cafe"},
        {type: 1, id: "campground"},
        {type: 1, id: "car_dealer"},
        {type: 1, id: "car_rental"},
        {type: 1, id: "car_repair"},
        {type: 1, id: "car_wash"},
        {type: 1, id: "casino"},
        {type: 1, id: "cemetery"},
        {type: 1, id: "church"},
        {type: 1, id: "city_hall"},
        {type: 1, id: "clothing_store"},
        {type: 1, id: "convenience_store"},
        {type: 1, id: "courthouse"},
        {type: 1, id: "dentist"},
        {type: 1, id: "department_store"},
        {type: 1, id: "doctor"},
        {type: 1, id: "electrician"},
        {type: 1, id: "electronics_store"},
        {type: 1, id: "embassy"},
        {type: 1, id: "fire_station"},
        {type: 1, id: "florist"},
        {type: 1, id: "funeral_home"},
        {type: 1, id: "furniture_store"},
        {type: 1, id: "gas_station"},
        {type: 1, id: "gym"},
        {type: 1, id: "hair_care"},
        {type: 1, id: "hardware_store"},
        {type: 1, id: "hindu_temple"},
        {type: 1, id: "home_goods_store"},
        {type: 1, id: "hospital"},
        {type: 1, id: "insurance_agency"},
        {type: 1, id: "jewelry_store"},
        {type: 1, id: "laundry"},
        {type: 1, id: "lawyer"},
        {type: 1, id: "library"},
        {type: 1, id: "liquor_store"},
        {type: 1, id: "local_government_office"},
        {type: 1, id: "locksmith"},
        {type: 1, id: "lodging"},
        {type: 1, id: "meal_delivery"},
        {type: 1, id: "meal_takeaway"},
        {type: 1, id: "mosque"},
        {type: 1, id: "movie_rental"},
        {type: 1, id: "movie_theater"},
        {type: 1, id: "moving_company"},
        {type: 1, id: "museum"},
        {type: 1, id: "night_club"},
        {type: 1, id: "painter"},
        {type: 1, id: "park"},
        {type: 1, id: "parking"},
        {type: 1, id: "pet_store"},
        {type: 1, id: "pharmacy"},
        {type: 1, id: "physiotherapist"},
        {type: 1, id: "plumber"},
        {type: 1, id: "police"},
        {type: 1, id: "post_office"},
        {type: 1, id: "real_estate_agency"},
        {type: 1, id: "restaurant"},
        {type: 1, id: "roofing_contractor"},
        {type: 1, id: "rv_park"},
        {type: 1, id: "school"},
        {type: 1, id: "shoe_store"},
        {type: 1, id: "shopping_mall"},
        {type: 1, id: "spa"},
        {type: 1, id: "stadium"},
        {type: 1, id: "storage"},
        {type: 1, id: "store"},
        {type: 1, id: "subway_station"},
        {type: 1, id: "supermarket"},
        {type: 1, id: "synagogue"},
        {type: 1, id: "taxi_stand"},
        {type: 1, id: "train_station"},
        {type: 1, id: "transit_station"},
        {type: 1, id: "travel_agency"},
        {type: 1, id: "veterinary_care"},
        {type: 1, id: "zoo"},

        {type: 2, id: "administrative_area_level_1"},
        {type: 2, id: "administrative_area_level_2"},
        {type: 2, id: "administrative_area_level_3"},
        {type: 2, id: "administrative_area_level_4"},
        {type: 2, id: "administrative_area_level_5"},
        {type: 2, id: "colloquial_area"},
        {type: 2, id: "country"},
        {type: 2, id: "establishment"},
        {type: 2, id: "finance"},
        {type: 2, id: "floor"},
        {type: 2, id: "food"},
        {type: 2, id: "general_contractor"},
        {type: 2, id: "geocode"},
        {type: 2, id: "health"},
        {type: 2, id: "intersection"},
        {type: 2, id: "locality"},
        {type: 2, id: "natural_feature"},
        {type: 2, id: "neighborhood"},
        {type: 2, id: "place_of_worship"},
        {type: 2, id: "subpremise"},
        {type: 2, id: "sublocality_level_1"},
        {type: 2, id: "sublocality_level_2"},
        {type: 2, id: "sublocality_level_3"},
        {type: 2, id: "sublocality_level_4"},
        {type: 2, id: "sublocality"},
        {type: 2, id: "street_number"},
        {type: 2, id: "street_address"},
        {type: 2, id: "route"},
        {type: 2, id: "room"},
        {type: 2, id: "premise"},
        {type: 2, id: "postal_town"},
        {type: 2, id: "postal_code_suffix"},
        {type: 2, id: "postal_code_prefix"},
        {type: 2, id: "postal_code"},
        {type: 2, id: "post_box"},
        {type: 2, id: "point_of_interest"},
        {type: 2, id: "political"},
        {type: 3, id: "locality"},
        {type: 3, id: "sublocality"},
        {type: 3, id: "postal_code"},
        {type: 3, id: "country"},
        {type: 3, id: "administrative_area_level_1"},
        {type: 3, id: "administrative_area_level_2"}
    ];
    var result = placesTypes;
    if (type) {
        result = placesTypes.filter(function (index) {
            return index.type == type;
        });
    }
    return result;
}

function getRouteTypeIcon(type_shortcut) {
    var result;

    if (type_shortcut == 0) {
        result =
            pathDevelopers + "assets/images/markers/routes/tourist-route.png";
    } else if (type_shortcut == 1) {
        result =
            pathDevelopers + "assets/images/markers/routes/transit-route.png";
    } else if (type_shortcut == 2) {
        result =
            pathDevelopers +
            "assets/images/markers/routes/historical-route.png";
    } else if (type_shortcut == 3) {
        result =
            pathDevelopers + "assets/images/markers/routes/thematic-route.png";
    } else if (type_shortcut == 4) {
        result = pathDevelopers + "assets/images/markers/routes/chaki-ñan.png";
    } else if (type_shortcut == 5) {
        result = pathDevelopers + "assets/images/markers/routes/natural.png";
    } else if (type_shortcut == 5) {
        result = pathDevelopers + "assets/images/markers/routes/cultural.jpg";
    }

    return result;
}

function getSubcategories() {
    var result;
    result = [
        {
            id: 1,
            text: "Restaurante",
            category_id: 1,
            categoryData: getCategory(1),
            marker: pathDevelopers + "assets/images/markers/restaurants.png"
        },
        {
            id: 2,
            text: "Bar",
            category_id: 1,
            categoryData: getCategory(1),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        },
        {
            id: 3,
            text: "Cafeteria",
            category_id: 1,
            categoryData: getCategory(1),
            marker: pathDevelopers + "assets/images/markers/cafeterias.png"
        },
        //OTHER
        {
            id: 4,
            text: "Parques",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/parques.png"
        },
        {
            id: 5,
            text: "Gimnasio",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/gimnasio.png"
        },
        {
            id: 6,
            text: "Galeria de Arte",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 7,
            text: "Atracciones",
            category_id: 2,
            categoryData: getCategory(2),
            marker:
                pathDevelopers +
                "assets/images/markers/parque_d_diversiones.png"
        },
        {
            id: 8,
            text: "Musica en vivo",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 9,
            text: "Cine",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/cine.png"
        },
        {
            id: 10,
            text: "Museo",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/museos.png"
        },
        {
            id: 11,
            text: "Biblioteca",
            category_id: 2,
            categoryData: getCategory(2),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        //OTHER
        {
            id: 12,
            text: "Tienda de Viveres",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 13,
            text: "Cosmeticos",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 14,
            text: "Concesionario de Autos",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 15,
            text: "Hogar & Jardin",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 16,
            text: "Almacen de Ropa",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 17,
            text: "Centro Comercial",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 18,
            text: "Electrodomesticos",
            category_id: 3,
            categoryData: getCategory(3),
            marker:
                pathDevelopers + "assets/images/markers/electrodomesticos.png"
        }, //
        {
            id: 19,
            text: "Supermercado",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/supermercados.png"
        },
        {
            id: 20,
            text: "Mercado",
            category_id: 3,
            categoryData: getCategory(3),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        //OTHER
        {
            id: 21,
            text: "Hotel",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/hoteles.png"
        },
        {
            id: 22,
            text: "Cajero Automatico",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 23,
            text: "Salon de Belleza",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 24,
            text: "Renta de Carros",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/renta_d_autos.png"
        },
        {
            id: 25,
            text: "Lavado en Seco",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/lavanderia.png"
        },
        {
            id: 26,
            text: "Gas",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 27,
            text: "Hospitales & Clinicas",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 28,
            text: "Librerias",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 29,
            text: "Correo & Envio",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 30,
            text: "Estacionamiento de Carros",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        }, //no
        {
            id: 31,
            text: "Asociacion",
            category_id: 4,
            categoryData: getCategory(4),
            marker: pathDevelopers + "assets/images/markers/bares.png"
        } //no
    ];
    return result;
}

function getCategory(categoryId) {
    var categories = getCategories();
    return categories.filter(function (index) {
        return index.id == categoryId;
    })[0];
}

function getSubCategory(subCategoryId) {
    var subCategories = getSubcategories();
    return subCategories.filter(function (index) {
        return index.id == subCategoryId;
    })[0];
}

function rad(x) {
    return (x * Math.PI) / 180;
}

function find_closest_marker(params) {
    var lat = params.latLng.lat();
    var lng = params.latLng.lng();
    var currentMarkers = params.currentMarkers;

    var R = 6371; // radius of earth in km
    var distances = [];
    var closest = -1;
    for (i = 0; i < currentMarkers.length; i++) {
        var mlat = currentMarkers[i].position.lat();
        var mlng = currentMarkers[i].position.lng();
        var dLat = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(lat)) *
            Math.cos(rad(lat)) *
            Math.sin(dLong / 2) *
            Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        distances[i] = d;
        if (closest == -1 || d < distances[closest]) {
            closest = i;
        }
    }

    return distances;
}

function find_closest_marker(event) {
    var distances = [];
    var closest = -1;
    for (i = 0; i < markers.length; i++) {
        var d = google.maps.geometry.spherical.computeDistanceBetween(
            markers[i].position,
            event.latLng
        );
        distances[i] = d;
        if (closest == -1 || d < distances[closest]) {
            closest = i;
        }
    }
    console.log("Closest marker is: " + markers[closest].getTitle());
}

function findNearestMarkerGMAP(params) {
    var latLng = params.latLng;
    var result = [];
    var currentMarkers = params.currentMarkers;
    var minDist = params.minDist ? params.minDist : 1000;
    result = currentMarkers.reduce((result, value) => {
        var d = google.maps.geometry.spherical.computeDistanceBetween(
            value.position,
            latLng
        );
        if (d < minDist) {
            result.push(value);
        }
        return result;
    }, []);

    return result;
}

/*
function find_closest_marker(params) {
    var lat = params.latLng.lat();
    var lng = params.latLng.lng();
    var currentMarkers = params.currentMarkers;

    var R = 6371; // radius of earth in km
    var distances = [];
    var closest = -1;
    for (i = 0; i < currentMarkers.length; i++) {
        var mlat = currentMarkers[i].position.lat();
        var mlng = currentMarkers[i].position.lng();
        var dLat = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        distances[i] = d;
        if (closest == -1 || d < distances[closest]) {
            closest = i;
        }
    }

    return distances;
}*/

function toggleBounce(marker) {
    marker.setAnimation(google.maps.Animation.BOUNCE);
}

function toggleBounceClean(marker) {
    marker.setAnimation(null);
}


/*
UPLOAD PERCENTAGE*/

/*
UPLOAD PERCENTAGE*/

function UploadPercentage(params) {
    var _this = this;
    this.managerContentImage = params.managerContentImage; //.progress
    this.managerUploadSelector = params.managerUploadSelector;

    this.initUploadProgress = function () {
        var elementConfig = this.getConfigUploadElements();
        var contentManagerUpload = elementConfig.managerUpload;
        var contentManagerImage = elementConfig.contentManagerImage;
        $(contentManagerUpload).show();
        $(contentManagerImage).hide();
        var bar = elementConfig.bar;
        var percent = elementConfig.percent;
        var percentVal = "0%";
        bar.css("width", percentVal);
        percent.html(percentVal);
    };

    this.setPercentage = function (percentage) {
        var elementConfig = this.getConfigUploadElements();
        var bar = elementConfig.bar;
        var percent = elementConfig.percent;
        var percentVal = percentage + "%";
        bar.css("width", percentVal);
        percent.html(percentVal);
    };

    this.getConfigUploadElements = function () {
        var contentManagerImage = $(this.managerContentImage); //.progress
        var managerBarSelector = $(
            this.managerUploadSelector + " :nth-child(1)"
        );
        var managerPercentSelector = $(
            this.managerUploadSelector + " :nth-child(2)"
        );
        var bar = managerBarSelector; //.progress__bar
        var percent = managerPercentSelector; //.progress__percent
        var managerUpload = $(this.managerUploadSelector); //
        return {
            contentManagerImage: contentManagerImage,
            bar: bar,
            percent: percent,
            managerUpload: managerUpload
        };
    };

    this.endUploadProgress = function () {
        var elementConfig = this.getConfigUploadElements();
        var contentManagerUpload = elementConfig.managerUpload;
        var contentManagerImage = elementConfig.contentManagerImage;

        var bar = elementConfig.bar;
        var percent = elementConfig.percent;
        bar.width("100%");
        percent.html("100%");
        $(contentManagerImage).show();
        $(contentManagerUpload).hide();
    };
    this.eventsXhr = function () {
        var jqXHR = null;
        if (window.ActiveXObject) {
            jqXHR = new window.ActiveXObject("Microsoft.XMLHTTP");
        } else {
            jqXHR = new window.XMLHttpRequest();
        }
        //Upload progress
        jqXHR.upload.addEventListener(
            "progress",
            function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = Math.round(
                        (evt.loaded * 100) / evt.total
                    );
                    //Do something with upload progress
                    _this.setPercentage(percentComplete);
                    //step 2 u
                    console.log("Uploaded percent", percentComplete);
                }
            },
            false
        );
        //Download progress
        jqXHR.addEventListener(
            "progress",
            function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = Math.round(
                        (evt.loaded * 100) / evt.total
                    );
                    //Do something with download progress
                    /*setPercentage(percentComplete);*/
                    console.log("Downloaded percent", percentComplete);
                }
            },
            false
        );
        return jqXHR;
    };
}

/**
 *         var paramsUpload = {
                                successCall: function (response) {
                                    if (response.success) {
                                    } else {
                                    }
                                },
                                element: file_temp_img.split("#")[1],
                                dataFile: 1,
                                managerContentImage: (".progress"),
                                managerUploadSelector: ("#managerUploadSelector"),
                                url_action_upload: $("#action_upload_resource").val()
                            }
 ;
 uploadResource(paramsUpload);
 * @param options
 */
function uploadResource(options) {
    var managerContentImage = options.managerContentImage;
    var managerUploadSelector = options.managerUploadSelector;
    var url_action_upload = options.url_action_upload;
    var uploadPercentage = new UploadPercentage({
        managerContentImage: managerContentImage,
        managerUploadSelector: managerUploadSelector
    });

    //información del formulario
    //    var inputFileImage = document.getElementById('file_temp_producto');
    var inputFileImage = document.getElementById(options.element);
    if (inputFileImage.files[0]) {
        var file = inputFileImage.files[0];
        var formData = new FormData();
        formData.append("file", file);
        //hacemos la petición ajax
        $.ajax({
            url: url_action_upload,
            type: "POST",
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            //una vez finalizado correctamente
            success: function (response) {
                if (options.successCall) {
                    options.successCall(response);
                    dataFileImagen = response;
                }
            },
            //si ha ocurrido un error
            error: function () {
                uploadPercentage.endUploadProgress(); ////step 4 u
            },
            beforeSend: function (xhr, data) {
                uploadPercentage.initUploadProgress(); //step 1 u
            },
            complete: function (data) {
                uploadPercentage.endUploadProgress(); //step 3 u
            },
            xhr: uploadPercentage.eventsXhr
        });
    }
}

function getLatLngDataDB(params) {
    var result = [];

    var haystack = params.haystack;

    $.each(haystack, function (indexRow, valueRow) {
        var type = valueRow.type;
        if (type == "marker") {
            var setPush = {
                lat: valueRow.haystack.lat,
                lng: valueRow.haystack.lng
            };
            result.push(setPush);
        } else if (type == "polyline" || type == "polygon") {
            $.each(valueRow.haystack, function (index, value) {
                var setPush = {
                    lat: parseFloat(value.lat),
                    lng: parseFloat(value.lng)
                };
                result.push(setPush);
            });
        } else if (type == "rectangle") {
            var setPush = {
                lat: valueRow.haystack.ne.lat,
                lng: valueRow.haystack.ne.lng
            };
            result.push(setPush);

            setPush = {
                lat: valueRow.haystack.sw.lat,
                lng: valueRow.haystack.sw.lng
            };
            result.push(setPush);
        } else if (type == "circle") {
            var setPush = {
                lat: parseFloat(valueRow.haystack.lat),
                lng: parseFloat(valueRow.haystack.lng)
            };
            result.push(setPush);
        }
    });

    return result;
}

function getBounds(haystack) {
    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < haystack.length; i++) {
        var latlng = {
            lat: haystack[i].lat,
            lng: haystack[i].lng
        };
        bounds.extend(latlng);
    }

    return bounds;
}

function randomItem(items) {
    return items[Math.floor(Math.random() * items.length)];
}

function escapeRegExp(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // $& means the whole matched string
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), "g"), replace);
}

/*
---google mapa---*/

function getKMLUpload(params) {
    var kmlNS = "http://www.opengis.net/kml/2.2";
    var gxNS = "http://www.google.com/kml/ext/2.2";
    var haystack = params.haystack;
    var result = [];
    var optionsKml = {
        nameRoute: "",
        descriptionRoute: "",
        styleRoute: {}
    };

    var setPush = '<?xml version="1.0" encoding="UTF-8" ?>' + "\n";
    result.push(setPush);
    setPush = '<kml xmlns="http://www.opengis.net/kml/2.2">' + "\n";
    result.push(setPush);
    result.push("<Document>" + "\n");
    var type = params.type;
    var typeFile = params.typeFile;

    var resultObj = [];
    if (type == "fileUpload") {
        $.each($(haystack).find("kml"), function (key, kml) {
            if (kml) {
                var nodesDocument = $(kml).find("Document");
                var valueDocument = nodesDocument[0];
                var placeMarkData = $(valueDocument).find("Placemark");
                if (placeMarkData) {
                    var resultData = getDataTypeLay({
                        data: placeMarkData
                    });

                    result = $.merge(result, resultData.string);
                    resultObj = resultData.object;
                }
            }
        });
    } else if (type == "fileReader") {
        nodesDocument = $(haystack).find("Document");
        if (nodesDocument) {
            var nameRoute = nodesDocument.children("name").html();
            var descriptionRoute = nodesDocument.children("description").html();

            style = $(nodesDocument).find("style#track");
            htmlCurrentStyle = null;
            $.each(style, function (key, value) {
                htmlCurrentStyle = $.parseHTML($(value).html());
            });
            if (htmlCurrentStyle) {
                var colorCurrent = $(htmlCurrentStyle[1]).find("color");
                var widthCurrent = $(htmlCurrentStyle[1]).find("width");
                optionsKml.style = {
                    color: colorCurrent,
                    widthCurrent: widthCurrent
                };
            }

            optionsKml.nameRoute = nameRoute;
            optionsKml.descriptionRoute = descriptionRoute;
            var valueDocument = nodesDocument;
            var placeMarkData = $(valueDocument).find("Placemark");
            if (placeMarkData) {
                var resultData = getDataTypeLay({
                    data: placeMarkData
                });
                result = $.merge(result, resultData.string);
                resultObj = resultData.object;
            }
        }
    }

    result.push("</Document>" + "\n");
    result.push("</kml>" + "\n");

    var resultStructure = {
        kmlString: result.join(""),
        object: resultObj,
        optionsKml: optionsKml
    };
    return resultStructure;
}

function getDataPolyline(params) {
    var resultObj = [];
    var resultString = [];
    var result = [];
    var fillColor = "";
    var fillOpacity = "";
    var strokeColor = "#ffff0000";
    var strokeOpacity = 1.0;
    var strokeWeight = 4;
    var description = "";
    var valuePlaceMark = params.valuePlaceMark;
    var typeGetData = params.type;

    var childrensInfo = $(valuePlaceMark).children();
    /*childrensInfo=name, description, atom:author, atom:link, extendeddata, timespan, styleurl, gx:multitrack*/
    /* name, description, styleurl, point, prevObject: at.fn.init(1)*/
    /* 2) linestring */
    var indexSearch = getValuesMultitrackMarker({
        childrensInfo: childrensInfo
    });
    var multitrack;
    var multitrackResult;
    var paths = [];
    if (typeGetData == "geo-tracker") {
        if (indexSearch >= 0) {
            multitrack = childrensInfo[indexSearch];
            multitrackResult = $(multitrack).children();
            setPush = "<LineString>";
            resultString.push(setPush + "\n");
            setPush = "     <extrude>1</extrude>";
            resultString.push(setPush + "\n");
            setPush = "     <altitudeMode>relativeToGround</altitudeMode>";
            resultString.push(setPush + "\n");
            setPush = "     <coordinates>";
            resultString.push(setPush + "\n");
            paths = [];

            var trackData = [];
            $.each($(multitrackResult), function (
                key,
                value
            ) {

                if (
                    "GX:TRACK" == value.tagName ||
                    "gx:track" == value.tagName
                ) {
                    trackData.push(value);
                }
            });
            $.each(trackData, function (
                keyPlaceMark,
                valuePlaceMark
            ) {
                var currentValuePoints = $(valuePlaceMark).children();

                $.each(currentValuePoints, function (
                    keyPoint,
                    valuePoint
                ) {
                    var currentName = $(valuePoint)[0].tagName;
                    console.log(valuePoint);
                    if (
                        "gx:coord" == currentName ||
                        "GX:COORD" == currentName
                    ) {
                        var coordinatesData = $(
                            $(valuePoint).children().prevObject[0]
                        )
                            .html()
                            .split(" ");
                        setPush =
                            "             " +
                            coordinatesData[0] +
                            "," +
                            coordinatesData[1] +
                            ",0\n";
                        resultString.push(setPush);

                        var coordinatesDataArray = coordinatesData;
                        var lat = parseFloat(coordinatesDataArray[1]);
                        var lng = parseFloat(coordinatesDataArray[0]);
                        paths.push({
                            lat: lat,
                            lng: lng
                        });
                    }

                });


            });
            setPush = "     </coordinates>";
            resultString.push(setPush + "\n");
            setPush = "</LineString>";
            resultString.push(setPush + "\n");

            name = "POLILINE";
            setPushLay = {
                path: paths,
                geodesic: true,
                type: "polyline",
                title: name,
                content: description,
                strokeColor: strokeColor,
                strokeOpacity: strokeOpacity,
                strokeWeight: strokeWeight
            };
            resultObj.push(setPushLay);
        }
    } else if (typeGetData == "MultiGeometry") {
        if (indexSearch >= 0) {
            multitrack = childrensInfo[indexSearch];
            multitrackResult = $(multitrack).children();
            setPush = "<LineString>";
            resultString.push(setPush + "\n");
            setPush = "     <extrude>1</extrude>";
            resultString.push(setPush + "\n");
            setPush = "     <altitudeMode>relativeToGround</altitudeMode>";
            resultString.push(setPush + "\n");
            setPush = "     <coordinates>";
            resultString.push(setPush + "\n");
            paths = [];

            var trackData = [];
            $.each($(multitrackResult), function (
                key,
                value
            ) {

                if (
                    "POLYGON" == value.tagName
                ) {
                    var setPushCoordinates = $(value).children().children();
                    trackData.push(setPushCoordinates);
                }
            });

            $.each(trackData, function (
                keyPlaceMark,
                valuePlaceMark
            ) {
                var currentValuePoints = $(valuePlaceMark).children();


                $.each(currentValuePoints, function (
                    keyPoint,
                    valuePoint
                ) {

                    var pointsCoords = valuePoint.innerText.split(" ")

                    //data points

                    $.each(pointsCoords, function (
                        keyCoord,
                        valueCoord
                    ) {
                        var coordinatesData = valueCoord.split(",");
                        setPush =
                            "             " +
                            coordinatesData[0] +
                            "," +
                            coordinatesData[1] +
                            ",0\n";
                        resultString.push(setPush);

                        var coordinatesDataArray = coordinatesData;
                        var lat = parseFloat(coordinatesDataArray[1]);
                        var lng = parseFloat(coordinatesDataArray[0]);
                        paths.push({
                            lat: lat,
                            lng: lng
                        });

                    });


                });


            });
            setPush = "     </coordinates>";
            resultString.push(setPush + "\n");
            setPush = "</LineString>";
            resultString.push(setPush + "\n");

            name = "POLILINE";
            setPushLay = {
                path: paths,
                geodesic: true,
                type: "polyline",
                title: name,
                content: description,
                strokeColor: strokeColor,
                strokeOpacity: strokeOpacity,
                strokeWeight: strokeWeight
            };
            resultObj.push(setPushLay);
        }
    } else {
        if (indexSearch >= 0) {
            multitrack = childrensInfo[indexSearch];
            multitrackResult = $(multitrack)
                .children("coordinates")
                .html()
                .split(" ");
            setPush = "<LineString>";
            resultString.push(setPush + "\n");
            setPush = "     <extrude>1</extrude>";
            resultString.push(setPush + "\n");
            setPush = "     <altitudeMode>relativeToGround</altitudeMode>";
            resultString.push(setPush + "\n");
            setPush = "     <coordinates>";
            resultString.push(setPush + "\n");
            paths = [];
            $.each(multitrackResult, function (keyPlaceMark, valuePlaceMark) {
                if (valuePlaceMark.length > 1) {
                    var coordinatesData = valuePlaceMark.split(",");
                    setPush =
                        "             " +
                        coordinatesData[0] +
                        "," +
                        coordinatesData[1] +
                        ",0\n";
                    resultString.push(setPush);

                    var coordinatesDataArray = coordinatesData;
                    var lat = parseFloat(coordinatesDataArray[1]);
                    var lng = parseFloat(coordinatesDataArray[0]);
                    paths.push({
                        lat: lat,
                        lng: lng
                    });
                }
            });
            setPush = "     </coordinates>";
            resultString.push(setPush + "\n");
            setPush = "</LineString>";
            resultString.push(setPush + "\n");

            name = "POLILINE";
            setPushLay = {
                path: paths,
                geodesic: true,
                type: "polyline",
                title: name,
                content: description,
                strokeColor: strokeColor,
                strokeOpacity: strokeOpacity,
                strokeWeight: strokeWeight
            };
            resultObj.push(setPushLay);
        }
    }

    return {
        string: resultString,
        obj: resultObj
    };
}

function getExistPolyline(params) {
    var valuePlaceMark = params.valuePlaceMark;
    var type = "none";
    type = "none";
    var valuesObj = $(valuePlaceMark).children();
    var isTracking = false;
    $.each(valuesObj, function (key, value) {
        var tagName = $(value)[0].tagName;
        console.log(tagName);
        if (tagName == "GX:MULTITRACK") {
            result = key;
            type = "geo-tracker";
            isTracking = true;
        } else if (tagName == "LINESTRING") {
            type = "linestring";
            isTracking = true;
        } else if (tagName == "MultiGeometry" || tagName == "MULTIGEOMETRY") {
            type = "MultiGeometry";
            isTracking = true;
        }
    });

    var result = {isTracking: isTracking, type: type};
    return result;
}

function getDataTypeLay(params) {
    var data = params.data;
    var resultString = [];
    var resultObj = [];

    $.each(data, function (keyPlaceMark, valuePlaceMark) {
        var isTrackingResult = getExistPolyline({
            valuePlaceMark: valuePlaceMark
        });
        var setPush = "      <Placemark>";
        resultString.push(setPush + "\n");
        var name = $(valuePlaceMark)
            .children("name")
            .html();
        var description = $(valuePlaceMark)
            .children("description")
            .html();
        setPush = "         <name>";
        resultString.push(setPush + "\n");
        setPush = "             <![CDATA[" + name + "]]>";
        resultString.push(setPush + "\n");
        setPush = "         </name>";
        resultString.push(setPush + "\n");
        setPush = "     <description>";
        resultString.push(setPush + "\n");
        setPush = "<![CDATA[" + description ? description : "" + "]]>";
        resultString.push(setPush + "\n");
        setPush = "     </description>";
        resultString.push(setPush + "\n");
        if (isTrackingResult.isTracking) {
            var resultTracking = getDataPolyline({
                type: isTrackingResult.type,
                valuePlaceMark: valuePlaceMark
            });

            resultString = $.merge(resultString, resultTracking.string);
            resultObj = $.merge(resultObj, resultTracking.obj);
        } else {
            var coordinatesData = $(valuePlaceMark)
                .children("Point")
                .children()
                .html();
            if (coordinatesData) {
                setPush = "<Point>";
                resultString.push(setPush + "\n");
                setPush = "<extrude>1</extrude>";
                resultString.push(setPush + "\n");
                setPush = "<altitudeMode>relativeToGround</altitudeMode>";
                resultString.push(setPush + "\n");
                setPush = "<coordinates>";
                resultString.push(setPush + "\n");
                setPush = coordinatesData;
                resultString.push(setPush + "\n");
                setPush = "</coordinates>";
                resultString.push(setPush + "\n");
                setPush = "</Point>";
                resultString.push(setPush + "\n");

                var coordinatesDataArray = $.trim(coordinatesData).split(",");
                var lat = parseFloat(coordinatesDataArray[1]);
                var lng = parseFloat(coordinatesDataArray[0]);
                var setPushLay = {
                    position: {lat: lat, lng: lng},
                    type: "marker",
                    title: name,
                    content: description
                };
                resultObj.push(setPushLay);
            } else {
                console.log("no hay points ");
            }
        }

        setPush = "     </Placemark>";
        resultString.push(setPush + "\n");
    });
    result = {
        string: resultString,
        object: resultObj
    };
    return result;
}

function getValuesMultitrackMarker(params) {
    var result = -1;
    var childrensInfo = params.childrensInfo;
    $.each(childrensInfo, function (key, value) {
        var tagName = $(value)[0].tagName;
        if (tagName == "GX:MULTITRACK") {
            result = key;
            return result;
        } else if (tagName == "LINESTRING") {
            result = key;
            return result;
        } else if (tagName == "MultiGeometry" || tagName == "MULTIGEOMETRY") {
            result = key;
            return result;
        }
    });

    return result;
}

function getOverLaysMaps(params) {
    var tmpOverlay, ovrOptions;
    var overlays = params.overlays;
    var _isEditable = params.isEditable;
    var properties = new Array(
        "fillColor",
        "fillOpacity",
        "strokeColor",
        "strokeOpacity",
        "strokeWeight",
        "icon"
    );
    var resultOverlays = [];
    for (var m = overlays.length - 1; m >= 0; m--) {
        ovrOptions = new Object();

        for (var x = properties.length; x >= 0; x--) {
            if (overlays[m][properties[x]]) {
                ovrOptions[properties[x]] = overlays[m][properties[x]];
            }
        }

        var currentIsEditable =
            _isEditable == true
                ? _isEditable
                : typeof overlays[m].editable == "boolean"
                    ? overlays[m].editable
                    : false;
        if (overlays[m].type == "polygon") {
            var tmpPaths = new Array();
            for (var n = 0; n < overlays[m].paths.length; n++) {
                var tmpPath = new Array();
                for (var p = 0; p < overlays[m].paths[n].length; p++) {
                    tmpPath.push(
                        new google.maps.LatLng(
                            overlays[m].paths[n][p].lat,
                            overlays[m].paths[n][p].lng
                        )
                    );
                }
                tmpPaths.push(tmpPath);
            }
            ovrOptions.paths = tmpPaths;
            tmpOverlay = new google.maps.Polygon(ovrOptions);
        } else if (overlays[m].type == "polyline") {
            //tracking

            var tmpPath = new Array();
            for (var p = 0; p < overlays[m].path.length; p++) {
                tmpPath.push(
                    new google.maps.LatLng(
                        overlays[m].path[p].lat,
                        overlays[m].path[p].lng
                    )
                );
            }
            ovrOptions.path = tmpPath;
            tmpOverlay = new google.maps.Polyline(ovrOptions);
        } else if (overlays[m].type == "rectangle") {
            var tmpBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(
                    overlays[m].bounds.sw.lat,
                    overlays[m].bounds.sw.lng
                ),
                new google.maps.LatLng(
                    overlays[m].bounds.ne.lat,
                    overlays[m].bounds.ne.lng
                )
            );
            ovrOptions.bounds = tmpBounds;
            tmpOverlay = new google.maps.Rectangle(ovrOptions);
        } else if (overlays[m].type == "circle") {
            var cntr = new google.maps.LatLng(
                overlays[m].center.lat,
                overlays[m].center.lng
            );
            ovrOptions.center = cntr;
            ovrOptions.radius = overlays[m].radius;
            tmpOverlay = new google.maps.Circle(ovrOptions);
        } else if (overlays[m].type == "marker") {
            var pos = new google.maps.LatLng(
                overlays[m].position.lat,
                overlays[m].position.lng
            );
            ovrOptions.position = pos;
            if (overlays[m].icon) {
                ovrOptions.icon = overlays[m].icon;
            }
            if (currentIsEditable) {
                ovrOptions.draggable = true;
            }
            tmpOverlay = new google.maps.Marker(ovrOptions);
        }
        tmpOverlay.type = overlays[m].type;
        if (currentIsEditable && overlays[m].type != "marker") {
            tmpOverlay.setEditable(true);
        }

        var uniqueid = uniqid();
        tmpOverlay.uniqueid = uniqueid;
        if (overlays[m].title) {
            tmpOverlay.title = overlays[m].title;
        } else {
            tmpOverlay.title = "";
        }

        if (overlays[m].content) {
            tmpOverlay.content = overlays[m].content;
        } else {
            tmpOverlay.content = "";
        }
        //save the overlay in the array
        resultOverlays.push(tmpOverlay);
    }

    return resultOverlays;
}

function uniqid() {
    var newDate = new Date();
    return newDate.getTime();
}

function getConfigMarker(params) {
    var options = params.options;
    var _map = params.map;
    var positionCurrent = null;


    if (typeof google !== 'undefined') {
        positionCurrent = new google.maps.LatLng(
            parseFloat(options.position.lat),
            parseFloat(options.position.lng)
        );
    } else {
        positionCurrent = {
            lat: parseFloat(options.position.lat),
            lng: parseFloat(options.position.lng),
        };
    }

    var data = options.hasOwnProperty('data') ? options.data : [];
    var setOptions = {
        map: _map,
        position: positionCurrent,
        title: options.title,
        type: options.type,
        content: options.content,
        data: data

    };
    setOptions = mergeObjects(setOptions, options);
    setOptions.position = positionCurrent;
    var result = null;
    if (typeof google !== 'undefined') {
        result = new google.maps.Marker(setOptions);
    } else {
        result = setOptions;
    }
    return result;
}

function getConfigPolygon(params) {
    var options = params.options;
    var _map = params.map;
    var paths = [];
    var pathsCurrent = options.paths;
    $.each(pathsCurrent, function (key, value) {
        paths.push({
            lat: parseFloat(value.lat),
            lng: parseFloat(value.lng)
        });
    });
    var setOptions = {
        paths: paths,
        strokeColor: options.strokeColor ? options.strokeColor : "#FF0000",
        strokeOpacity: options.strokeOpacity ? options.strokeOpacity : 0.8,
        strokeWeight: options.strokeWeight ? options.strokeWeight : 3,
        fillColor: options.fillColor ? options.fillColor : "#FF0000",
        fillOpacity: options.fillOpacity ? options.fillOpacity : 0.35
    };
    setOptions = mergeObjects(setOptions, options);
    setOptions.paths = paths;
    var result = null;
    if (typeof google !== 'undefined') {
        result = new google.maps.Polygon(setOptions);
        result.setMap(_map);
    } else {
        result = setOptions;
    }
    return result;
}

function getConfigPolyline(params) {
    var options = params.options;
    var _map = params.map;

    var paths = [];
    $.each(options.path, function (key, value) {
        paths.push({
            lat: parseFloat(value.lat),
            lng: parseFloat(value.lng)
        });
    });
    var strokeColor = options.strokeColor
        ? options.strokeColor == "#ffff0000"
            ? "#000000"
            : options.strokeColor
        : "#FF0000";
    var setOptions = {
        path: paths,
        geodesic: true,
        strokeColor: strokeColor,
        strokeOpacity: options.strokeOpacity ? options.strokeOpacity : 1,
        strokeWeight: options.strokeWeight ? options.strokeWeight : 3,
        type: options.type,
        content: options.content
    };
    setOptions = mergeObjects(setOptions, options);
    setOptions.path = paths;
    setOptions.strokeColor = strokeColor;
    var result = null;

    if (typeof google !== 'undefined') {
        result = new google.maps.Polyline(setOptions);
        result.setMap(_map);
    } else {
        result = setOptions;
    }
    return result;
}

function getConfigCircle(params) {
    var options = params.options;
    var _map = params.map;
    var lat = options.center.lat;
    var lng = options.center.lng;

    var cntr = null;
    if (typeof google !== 'undefined') {
        cntr = new google.maps.LatLng(lat, lng);
    } else {
        cntr = {
            lat: lat,
            lng: lng,

        };
    }
    var setOptions = {
        center: cntr,
        type: options.type,
        radius: options.radius,
        map: _map
    };
    setOptions = mergeObjects(setOptions, options);
    let result = null;
    if (typeof google !== 'undefined') {
        result = new google.maps.Circle(setOptions);
    } else {
        result = setOptions;
    }
    return result;
}

function getConfigRectangle(params) {
    var options = params.options;
    var _map = params.map;
    var bounds = {
        north: options.bounds.ne.lat,
        south: options.bounds.sw.lat,
        east: options.bounds.ne.lng,
        west: options.bounds.sw.lng
    };
    var strokeColor = options.strokeColor
        ? options.strokeColor == "#ffff0000"
            ? "#FF0000"
            : options.strokeColor
        : "#FF0000";
    var setOptions = {
        strokeColor: strokeColor,
        strokeOpacity: options.strokeOpacity ? options.strokeOpacity : 0.8,
        strokeWeight: options.strokeWeight ? options.strokeWeight : 2,
        fillColor: options.fillColor ? options.fillColor : "#FF0000",
        fillOpacity: options.fillOpacity ? options.fillOpacity : 0.35,
        bounds: bounds,
        map: _map,
        type: options.type
    };
    setOptions = mergeObjects(setOptions, options);
    setOptions.bounds = bounds;
    let result = null;
    if (typeof google !== 'undefined') {
        result = new google.maps.Rectangle(setOptions);

    } else {
        result = (setOptions);

    }
    return result;
}

function getCenterByType(params) {
    var objCurrent = params.obj;
    var type = params.type;
    var result;
    var latlng;
    if (type == "polygon") {
        latlng = polygonCenter(objCurrent);
    } else if (type == "polyline") {
        latlng = polygonCenter(objCurrent);
    } else if (type == "rectangle") {
        latlng = polygonCenter(objCurrent);
    } else if (type == "marker") {
        if (typeof google !== 'undefined') {
            latlng = objCurrent.getPosition();
        } else {
            latlng = objCurrent.position;
        }

    } else if (type == "circle") {
        latlng = objCurrent.getCenter();
    }
    result = {
        latlng: latlng,
        type: type
    };
    return result;
}

function polygonCenter(poly) {
    var lowx,
        highx,
        lowy,
        highy,
        lats = [],
        lngs = [];
    var vertices = [];
    if (poly.type == "rectangle") {

        if (poly.bounds.east) {
            vertices.push(poly.bounds.east);
            vertices.push(poly.bounds.north);
            vertices.push(poly.bounds.south);
            vertices.push(poly.bounds.west);

        } else {
            var lat = 0;
            var lng = 0;
            if (poly.bounds.ga) {
                lat = poly.bounds.ga.j;
                lng = poly.bounds.ga.l;
            } else if (poly.bounds.pa) {
                lat = poly.bounds.pa.g;
                lng = poly.bounds.pa.h;
            }

            vertices.push({
                lat: lat,
                lng: lng
            });
            lat = 0;
            lng = 0;
            if (poly.bounds.na) {
                lat = poly.bounds.na.j;
                lng = poly.bounds.na.l;
            } else if (poly.bounds.ka) {
                lat = poly.bounds.ka.g;
                lng = poly.bounds.ka.h;
            }

            vertices.push({
                lat: lat,
                lng: lng
            });
        }

    } else if (poly.type == "polygon") {

        if (typeof google !== 'undefined') {
            vertices = poly.getPath();
        } else {
            vertices = poly.paths;
        }
    } else {


        if (poly.type == "polyline") {

            vertices = poly.path;
        } else if (poly.type == "rectangle") {

        } else {
            if (typeof google !== 'undefined') {
                vertices = poly.getPath();
            } else {
                vertices = poly.paths;
            }
        }

    }
    for (var i = 0; i < vertices.length; i++) {
        if (poly.type == "rectangle") {
            lngs.push(vertices[i].lng);
            lats.push(vertices[i].lat);
        } else {
            if (typeof google !== 'undefined') {
                lngs.push(vertices.getAt(i).lng());
                lats.push(vertices.getAt(i).lat());
            } else {
                lngs.push(vertices[i].lng);
                lats.push(vertices[i].lat);
            }

        }
    }

    lats.sort();
    lngs.sort();
    lowx = lats[0];
    highx = lats[vertices.length - 1];
    lowy = lngs[0];
    highy = lngs[vertices.length - 1];
    center_x = lowx + (highx - lowx) / 2;
    center_y = lowy + (highy - lowy) / 2;
    let result = null;
    if (typeof google !== 'undefined') {
        result = new google.maps.LatLng(center_x, center_y);

    } else {
        result = {
            center_x: center_x,
            center_y: center_y,

        };

    }
    return result;
}

function getCenterDataLatLng(params) {
    var lowx,
        highx,
        lowy,
        highy,
        lats = [],
        lngs = [];

    var haystack = params.haystack;
    for (var i = 0; i < haystack.length; i++) {
        lngs.push(haystack[i].latlng.lng());
        lats.push(haystack[i].latlng.lat());
    }

    lats.sort();
    lngs.sort();
    lowx = lats[0];
    highx = lats[haystack.length - 1];
    lowy = lngs[0];
    highy = lngs[haystack.length - 1];
    center_x = lowx + (highx - lowx) / 2;
    center_y = lowy + (highy - lowy) / 2;

    return new google.maps.LatLng(center_x, center_y);
}

function getEditorContent(overlay) {
    var content =
        "<style>" +
        "#BlitzMapInfoWindow_container input:focus, #BlitzMapInfoWindow_container textarea:focus{border:2px solid #7DB1FF;} " +
        "#BlitzMapInfoWindow_container .BlitzMapInfoWindow_button{background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;} " +
        ".BlitzMapInfoWindow_button:hover{background-color:#2883CE;border-color:#05439F;} " +
        "</style>" +
        '<form style="height:100%"><div id="BlitzMapInfoWindow_container" style="height:100%">' +
        '<div id="BlitzMapInfoWindow_details">' +
        '<div style="padding-bottom:3px;">Title:&nbsp;&nbsp;<input type="text" id="BlitzMapInfoWindow_title" value="' +
        overlay.title +
        '" style="border:2px solid #dddddd;width:150px;padding:3px;" ></div>' +
        '<div style="padding-bottom:3px;">Description:<br><textarea id="BlitzMapInfoWindow_content" style="border:2px solid #dddddd;width:250px;height:115px;">' +
        overlay.content +
        "</textarea></div>" +
        "</div>" +
        '<div id="BlitzMapInfoWindow_styles" style="display:none;width:100%;">' +
        '<div style="height:25px;padding-bottom:2px;font-weight:bold;">Styles &amp; Colors</div>';

    if (
        overlay.type == "polygon" ||
        overlay.type == "circle" ||
        overlay.type == "rectangle"
    ) {
        var fillColor =
            overlay.fillColor == undefined ? "#000000" : overlay.fillColor;
        content +=
            '<div style="height:25px;padding-bottom:3px;">Fill Color: <input type="text" id="BlitzMapInfoWindow_fillcolor" value="' +
            fillColor +
            '" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

        var fillOpacity =
            overlay.fillOpacity == undefined ? 0.3 : overlay.fillOpacity;
        content +=
            '<div style="height:25px;padding-bottom:3px;">Fill Opacity(percent): <input type="text" id="BlitzMapInfoWindow_fillopacity" value="' +
            fillOpacity.toString() +
            '"  style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay(overlay)" ></div>';
    }
    if (overlay.type != "marker") {
        var strokeColor =
            overlay.strokeColor == undefined ? "#000000" : overlay.strokeColor;
        content +=
            '<div style="height:25px;padding-bottom:3px;">' + $managerTitlesProcess.popupManagerGoogleMaps.colors.lineColor + '<input type="text" id="BlitzMapInfoWindow_strokecolor" value="' +
            strokeColor +
            '" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

        var strokeOpacity =
            overlay.strokeOpacity == undefined ? 0.9 : overlay.strokeOpacity;
        content +=
            '<div style="height:25px;padding-bottom:3px;">' + $managerTitlesProcess.popupManagerGoogleMaps.colors.lineOpacity + '<input type="text" id="BlitzMapInfoWindow_strokeopacity" value="' +
            strokeOpacity.toString() +
            '" style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay(overlay)" ></div>';

        var strokeWeight =
            overlay.strokeWeight == undefined ? 3 : overlay.strokeWeight;
        content +=
            '<div style="height:25px;padding-bottom:3px;">' + $managerTitlesProcess.popupManagerGoogleMaps.colors.lineThickness + '<input type="text" id="BlitzMapInfoWindow_strokeweight" value="' +
            strokeWeight.toString() +
            '" style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay(overlay)" ></div>';
    } else {
        //var strokeColor = ( overlay.strokeColor == undefined )? "#000000":overlay.strokeColor;
        //content += '<div style="height:25px;padding-bottom:3px;">Line Color: <input type="text" id="BlitzMapInfoWindow_strokecolor" value="'+ strokeColor +'" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

        //var animation = overlay.getAnimation();
        //content += '<div style="height:25px;padding-bottom:3px;">Line Opacity(percent): <select id="BlitzMapInfoWindow_animation" style="border:2px solid #dddddd;width:30px;float:right" ><option value="none">None</option><option value="bounce">Bounce</option><option value="drop">Drop</option></div>';

        var icon = overlay.icon == undefined ? "" : overlay.icon;
        content +=
            '<div style="height:25px;padding-bottom:3px;">Icon(): <input type="text" id="BlitzMapInfoWindow_icon" value="' +
            icon.toString() +
            '" style="border:2px solid #dddddd;width:100px;float:right" ></div>';
    }
    content +=
        '</div><div style="position:relative; bottom:0px;"><input type="button" value="Delete" class="BlitzMapInfoWindow_button" onclick="BlitzMap.deleteOverlay()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;" title"Delete selected shape">&nbsp;&nbsp;' +
        '<input type="button" value="OK" class="BlitzMapInfoWindow_button" onclick="BlitzMap.closeInfoWindow()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;float:right;" title="Apply changes to the overlay">' +
        '<input type="button" value="Cancel" class="BlitzMapInfoWindow_button" onclick="this.form.reset();BlitzMap.closeInfoWindow()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;float:right;">' +
        '<div style="clear:both;"></div>' +
        '<input type="button" id="BlitzMapInfoWindow_toggle" title="Manage Colors and Styles" onclick="BlitzMap.toggleStyleEditor();return false;" style="border:0;float:right;margin-top:5px;cursor:pointer;background-color:#fff;color:#2883CE;font-family:Arial;font-size:12px;text-align:right;" value="Customize Colors&gt;&gt;" />';
    +'<div style="clear:both;"></div>';
    +"</div>";
    +"</div></form>";

    return content;
}

function getLayersMap(params) {//TODO CHASQUI-MANAGEMENT
    var haystack = params.haystack;
    var result = [];
    for (var i = 0; i < haystack.length; i++) {
        if (haystack[i].getMap() == null) {
            continue;
        }
        tmpOverlay = new Object();
        tmpOverlay.type = haystack[i].type;
        tmpOverlay.title = haystack[i].title;
        tmpOverlay.content = haystack[i].content;
        tmpOverlay.title = haystack[i].title;

        if (haystack[i]["id"]) {
            tmpOverlay.id = haystack[i]["id"];
            tmpOverlay.rd_id = haystack[i]["rd_id"];
            tmpOverlay.routes_drawing_id = haystack[i]["routes_drawing_id"];
        }

        if (haystack[i].fillColor) {
            tmpOverlay.fillColor = haystack[i].fillColor;
        }

        if (haystack[i].fillOpacity) {
            tmpOverlay.fillOpacity = haystack[i].fillOpacity;
        }

        if (haystack[i].strokeColor) {
            tmpOverlay.strokeColor = haystack[i].strokeColor;
        }

        if (haystack[i].strokeOpacity) {
            tmpOverlay.strokeOpacity = haystack[i].strokeOpacity;
        }

        if (haystack[i].strokeWeight) {
            tmpOverlay.strokeWeight = haystack[i].strokeWeight;
        }

        if (haystack[i].icon) {
            tmpOverlay.icon = haystack[i].icon;
        }

        if (mapOverlays[i].flat) {
            tmpOverlay.flat = mapOverlays[i].flat;
        }

        if (haystack[i].type == "polygon") {
            tmpOverlay.totem_subcategory_id = mapOverlays[i].totem_subcategory_id;
            tmpOverlay.paths = new Array();
            paths = haystack[i].getPaths();
            for (var j = 0; j < paths.length; j++) {
                tmpOverlay.paths[j] = new Array();
                for (var k = 0; k < paths.getAt(j).length; k++) {
                    tmpOverlay.paths[j][k] = {
                        lat: paths
                            .getAt(j)
                            .getAt(k)
                            .lat()
                            .toString(),
                        lng: paths
                            .getAt(j)
                            .getAt(k)
                            .lng()
                            .toString()
                    };
                }
            }
        } else if (haystack[i].type == "polyline") {
            tmpOverlay.totem_subcategory_id = mapOverlays[i].totem_subcategory_id;
            tmpOverlay.path = new Array();
            path = haystack[i].getPath();
            for (var j = 0; j < path.length; j++) {
                tmpOverlay.path[j] = {
                    lat: path
                        .getAt(j)
                        .lat()
                        .toString(),
                    lng: path
                        .getAt(j)
                        .lng()
                        .toString()
                };
            }
        } else if (haystack[i].type == "circle") {
            tmpOverlay.totem_subcategory_id = mapOverlays[i].totem_subcategory_id;
            tmpOverlay.center = {
                lat: haystack[i].getCenter().lat(),
                lng: haystack[i].getCenter().lng()
            };
            tmpOverlay.radius = haystack[i].radius;
        } else if (haystack[i].type == "rectangle") {
            tmpOverlay.totem_subcategory_id = mapOverlays[i].totem_subcategory_id;
            tmpOverlay.bounds = {
                sw: {
                    lat: haystack[i]
                        .getBounds()
                        .getSouthWest()
                        .lat(),
                    lng: haystack[i]
                        .getBounds()
                        .getSouthWest()
                        .lng()
                },
                ne: {
                    lat: haystack[i]
                        .getBounds()
                        .getNorthEast()
                        .lat(),
                    lng: haystack[i]
                        .getBounds()
                        .getNorthEast()
                        .lng()
                }
            };
        } else if (haystack[i].type == "marker") {
            tmpOverlay.position = {
                lat: mapOverlays[i].getPosition().lat(),
                lng: mapOverlays[i].getPosition().lng()
            };

            tmpOverlay.file_glb = mapOverlays[i].file_glb;//TODO CHASQUI-MANAGEMENT
            tmpOverlay.file_src = mapOverlays[i].file_src;
            tmpOverlay.totem_subcategory_id = mapOverlays[i].totem_subcategory_id;
        }

        result.push(tmpOverlay);
    }

    return result;
}

function mergeObjects(obj, src) {
    Object.keys(src).forEach(function (key) {
        obj[key] = src[key];
    });
    return obj;
}

function addYourLocationButton(map, marker) {
    var controlDiv = document.createElement("div");

    var firstChild = document.createElement("button");
    firstChild.style.backgroundColor = "#fff";
    firstChild.style.border = "none";
    firstChild.style.outline = "none";
    firstChild.style.width = "28px";
    firstChild.style.height = "28px";
    firstChild.style.borderRadius = "2px";
    firstChild.style.boxShadow = "0 1px 4px rgba(0,0,0,0.3)";
    firstChild.style.cursor = "pointer";
    firstChild.style.marginRight = "10px";
    firstChild.style.padding = "0";
    firstChild.title = "Your Location";
    controlDiv.appendChild(firstChild);

    var secondChild = document.createElement("div");
    secondChild.style.margin = "5px";
    secondChild.style.width = "18px";
    secondChild.style.height = "18px";
    secondChild.style.backgroundImage =
        "url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-2x.png)";
    secondChild.style.backgroundSize = "180px 18px";
    secondChild.style.backgroundPosition = "0 0";
    secondChild.style.backgroundRepeat = "no-repeat";
    firstChild.appendChild(secondChild);

    /*   google.maps.event.addListener(map, 'center_changed', function () {
           secondChild.style['background-position'] = '0 0';
       });*/

    firstChild.addEventListener("click", function () {
        var imgX = "0",
            animationInterval = setInterval(function () {
                imgX = imgX === "-18" ? "0" : "-18";
                secondChild.style["background-position"] = imgX + "px 0";
            }, 500);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latlng = new google.maps.LatLng(
                    position.coords.latitude,
                    position.coords.longitude
                );
                map.setCenter(latlng);
                clearInterval(animationInterval);
                secondChild.style["background-position"] = "-144px 0";
            });
        } else {
            clearInterval(animationInterval);
            secondChild.style["background-position"] = "0 0";
        }
    });

    controlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
}

function getRowsColsStructure(params) {
    var $haystack = params["haystack"];
    var $countData = Object.keys($haystack).length;
    var $columnsDiv = params["columnsDiv"] ? params["columnsDiv"] : 3;
    var $rowsTotal = $countData / $columnsDiv;
    var $isMultiple =
        getTypeOfValueIntFloat($rowsTotal).typeNumber == 0 ? true : false;

    if ($isMultiple) {
        var $rowsTotalAux = $rowsTotal.toString();
        var $numberSections = $rowsTotalAux.split(".");
        var $decimalInt = $numberSections[1];
        $decimalInt = "0." + $decimalInt;
        var $valueRemaining = 1 - $decimalInt;

        $rowsTotal = $rowsTotal + $valueRemaining;
    }
    var $result = [];
    var $countTravel = 0;
    var $rowsTotalCurrent = 0;
    $rowsTotalCurrent = $rowsTotal;
    for (var $i = 0; $i < $rowsTotalCurrent; $i++) {
        var $dataColumn = [];
        for (var $j = 0; $j < $columnsDiv; $j++) {
            if ($haystack[$countTravel]) {
                var $setPush = $haystack[$countTravel];
                $dataColumn.push($setPush);
            }
            $countTravel++;
        }
        var $setPushRow = {data: $dataColumn};
        $result.push($setPushRow);
    }

    return $result;
}

function getTypeOfValueIntFloat($value) {
    var type = typeof $value;
    var typeNumber = null;
    if (type === "number") {
        if ($value % 1 === 0) {
            typeNumber = 1;
        } else {
            typeNumber = 0;
        }
    } else {
        // not a number
        typeNumber = null;
    }
    var result = {
        type: type,
        typeNumber: typeNumber
    };
    return result;
}

function setStyle(domElem, styleObj) {
    if (typeof styleObj == "object") {
        for (var prop in styleObj) {
            domElem.style[prop] = styleObj[prop];
        }
    }
}


function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}

//-----FUNCIONES PARA BOOTGRID--
//---METODO EN L CUAL VERIFICA SI EXISTE UNA POSICION DENTRO DE UN ARRAY
function issetMeet(array_objeto, key_objeto) {
    //      if (typeof obj.foo !== 'undefined') {
    //        console.log(" existe");
    //    } else {
    //        console.log("no ex")
    //    }
    //    EXAMPLE
    //    var obj = {
    //        "key1": "k1",
    //        "key2": "k2",
    //        "key3": "k3",
    //        "key4222": {
    //            "keyF": "kf"
    //        }
    //    };
    //
    //    if ("key4222" in obj)
    //        console.log("has keyF in obj");
    var isset_result = false; //no existe posicion
    if (key_objeto in array_objeto) {
        isset_result = true;
        return isset_result;
    }
    return isset_result;
}

function addRowEmpty(params) {
    //id dl grid o clase
    //    <span class="title-info"> <i class="fa fa-info"></i> Informacion</span>
    //params_empty
    //()
    var element_query = params.element;
    var array_element = element_query.split("#");
    if (array_element.length > 1) {
        for (var i = 0; i < array_element.length; i++) {
            if (array_element[i] != "") {
                element_query = array_element[i];
                break;
            }
        }
    }
    var title = params.title;
    var subtitle = params.subtitle;
    var icon = params.icon;
    var selector_empty = "#" + element_query + " tbody tr td.no-results";
    if ($(selector_empty).hasClass("no-results")) {
        //bacia
        $(selector_empty + ".no-results").html("");

        var html_empty =
            '<span class="title-info-empty"> <i class="' +
            icon +
            ' table-i-empty"></i> ' +
            title +
            "</span>" +
            '<span class="title-info-data-empty"> ' +
            subtitle +
            "</span>";
        $(selector_empty + ".no-results").html(html_empty);

        $(selector_empty + ".no-results")
            .parent()
            .removeClass("tr-empty");
        $(selector_empty + ".no-results")
            .parent()
            .addClass("tr-empty");
    } else {
    }
}

//AGREGAR INFORMACION
function setIconsPagination() {
    $("#data-pagination div div ul.pagination li.first a").html(
        '<i class="fa fa-step-backward"></i>'
    ); //para poder coger l primero
    $("#data-pagination div div ul.pagination li.last a").html(
        '<i class="fa  fa-step-forward"></i>'
    ); //para poder coger l primero
    $("ul.pagination li.first a").html('<i class="fa fa-step-backward"></i>'); //para poder coger l primero
    $("ul.pagination li.last a").html('<i class="fa  fa-step-forward"></i>'); //para poder coger l primero
}

function deleteRowBootgrid(element_obj, row_id) {
    element_obj.bootgrid("remove", [row_id]);
}

function addRowBootgrid(element_obj, $row) {
    element_obj.bootgrid("append", [$row]);
}

function getDataInstanciaBootgrid(element_obj) {
    var instance_data_rows = element_obj.data(".rs.jquery.bootgrid");
    return instance_data_rows;
}

function initGridEntidad(params, scope) {
    //    CONFIGURACION DEL BOOTGRID
    //http://www.jquery-bootgrid.com/
    var params_init = params;
    var element = params_init.element; //puede ser id/clase
    var gridId = $(element); //elemento cual vamos a inicializar el grid

    //DEPENDE D LA FUNCION Q REALIZAMOS EN L SERVER...
    var method = issetMeet(params_init, "method") ? params_init.method : "POST";
    var init_ajax = issetMeet(params_init, "init_ajax")
        ? params_init.init_ajax
        : false; //para obtener valores desde alguna accion
    var filters = issetMeet(params_init, "filters") ? params_init.filters : {};
    var url_get_data = issetMeet(params_init, "url_get_data")
        ? params_init.url_get_data
        : "";
    //    ----labels--
    var loading = issetMeet(params_init, "loading")
        ? params_init.loading
        : "<div id='div-loading'>Cargando...</div>";
    var noResults = issetMeet(params_init, "noResults")
        ? params_init.noResults
        : "<div class='empty-data'>Sin Resultados!</div>";
    var infos = issetMeet(params_init, "infos")
        ? params_init.infos
        : "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados";
    //  ----------- css
    var header = issetMeet(params_init, "header")
        ? params_init.header
        : "bootgrid-header";
    var table = issetMeet(params_init, "table")
        ? params_init.table
        : "m-datatable__table xywer-tbl-admin";
    var left = issetMeet(params_init, "left")
        ? params_init.left
        : "m-datatable__cell"; //rows header
    //    ---PERMITE REALIZAR FUNCIONES PROPIAS ENVIADAS X EL USUARIO--
    var loadedFunction = issetMeet(params_init, "loaded")
        ? params_init.loaded
        : null;
    var loadFunction = issetMeet(params_init, "load") ? params_init.load : null;
    var initializeFunction = issetMeet(params_init, "initialize")
        ? params_init.initialize
        : null;
    var initializedFunction = issetMeet(params_init, "initialized")
        ? params_init.initialized
        : null;

    var labels_objeto = {
        loading: loading,
        noResults: noResults,
        infos: infos,
        search: "Buscar"
    };
    var css_objecto = {
        header: header,
        table: table,
        left: left,
        footer: "m-datatable__pager m-datatable--paging-loaded clearfix"
    };
    //        ----INICIALIZAR EMPTY DATA--
    var params_empty = issetMeet(params, "empty")
        ? params
        : {
            title: "Información",
            subtitle: "No existe resultados",
            icon: "fa fa-info"
        };

    //    ---FORMATTER--
    var btn_personalizado_object_data = issetMeet(
        params_init,
        "btn_personalizado_object_data"
    )
        ? params_init.btn_personalizado_object_data
        : {};
    //---------------------------LOS COMANDS X DEFECTO YA DEBEN O COMO NO DEBEN EXISTIR PARA LA GESTION----------
    var commands_default = {
        commands: function (column, row) {
            $commands_btns = "";
            var $entidad_row_id = row.id;
            var entidad_grid = "";
            $.each(btn_personalizado_object_data, function (
                key_a,
                value_a_options
            ) {
                var entidad_gestion = key_a;
                var entidad_tipo = "";
                var $class_a = "";
                var $datatoogle_a = "";
                var $dataplacement_a = "";
                var $title_a = "";
                var $btn_class = "";
                var $i_class = "";
                var $url = "#";
                var $url_action = "";
                var $ng_click = "";
                var $ng_model = "";
                var $gestion = "";
                var $url_action_active = false;
                var $modal_type = "lg";
                $.each(value_a_options, function (key_a_option, value_a) {
                    switch (key_a_option) {
                        case "command-class":
                            $class_a = value_a;
                            break;
                        case "action":
                            $url_action_active = value_a;
                            break;
                        case "data-toggle":
                            $datatoogle_a = value_a;
                            break;
                        case "data-placement":
                            $dataplacement_a = value_a;
                            break;
                        case "title":
                            $title_a = value_a;
                            break;
                        case "button-class":
                            $btn_class = value_a;
                            break;
                        case "i-class":
                            $i_class = value_a;
                            break;
                        case "url":
                            $url = value_a;
                            break;
                        case "entidad_tipo":
                            $entidad_tipo = value_a;
                            break;
                        case "modal_type":
                            $modal_type = value_a;
                            break;
                        case "ng-click":
                            $ng_click = value_a;
                            break;
                        case "ng-model":
                            $ng_model = value_a;
                            break;
                        case "gestion":
                            $gestion = value_a;
                            break;
                    }
                });
                //para redirigir a otra pagina
                var $href = "";
                if ($url_action_active == "true") {
                    $href = "href='" + $url + "/entidad_id/" + row.id + "'";
                }
                $commands_btns +=
                    ' <a  gestion="' +
                    $gestion +
                    '"   ng-model="' +
                    $ng_model +
                    '"  ng-click="' +
                    $ng_click +
                    '" row-id="' +
                    $entidad_row_id +
                    ' "  modal_type =' +
                    $modal_type +
                    "  " +
                    $href +
                    ' entidad_tipo="' +
                    $entidad_tipo +
                    '" url="' +
                    $url +
                    '"  entidad="' +
                    entidad_grid +
                    '"  class="' +
                    $class_a +
                    '"  data-toggle="' +
                    $datatoogle_a +
                    '"  data-placement="' +
                    $dataplacement_a +
                    '" title="' +
                    $title_a +
                    '" data-row-id="' +
                    $entidad_row_id +
                    '"><i class="' +
                    $i_class +
                    '"></i></a>';
            });
            return $commands_btns;
        }
    };

    var formatters = {};
    formatters = commands_default;
    //    ---esto es para poder realizar manipulacion de cada row por cada columna darle estilos y diseños
    var object_formater_columns = issetMeet(params_init, "object_formater")
        ? params_init.object_formater
        : {};
    //    ----Solo si existe por lo menos uno agregar----
    if (Object.keys(object_formater_columns).length > 0) {
        formatters = $.extend(commands_default, object_formater_columns);
    }
    var footer_bst2 = '<div class="{{css.footer}}">';
    footer_bst2 += "      <div  class='ul-content'>";
    footer_bst2 += ' <pagination class="{{css.pagination}}"></pagination>';
    footer_bst2 += "      </div>";
    footer_bst2 += "      <div  class='info-content'>";
    footer_bst2 += ' <infos class="{{css.infos}}"></infos>';
    footer_bst2 += "      </div>";
    footer_bst2 += "</div>";

    function initFeatureTable() {
        $('[data-column-id="commands"]').css("width", "350px");
        $('[data-toggle="tooltip"]').tooltip();
        $(element)
            .find("tbody")
            .addClass("m-datatable__body ps ps--active-x ps--active-y");
        $(element)
            .find("tbody tr")
            .addClass("m-datatable__row");
        $(element)
            .find("thead tr th")
            .addClass("m-datatable__cell m-datatable__cell--sort");
    }

    function initEventClick() {
        if (initEvents == false) {
            initEvents = true;
            $(".ul-content ul li a").on("click", function () {
                console.log("t", $(this));
            });
        }
    }

    var templates_objeto = {
        footer: footer_bst2
    };
    //    -----Options----
    //permite para la seleccion de los objetos d cada fila---
    var selection = issetMeet(params_init, "selection")
        ? params_init.selection
        : false;
    var multiSelect = issetMeet(params_init, "multiSelect")
        ? params_init.multiSelect
        : false;
    var keepSelection = issetMeet(params_init, "keepSelection")
        ? params_init.keepSelection
        : false;
    var rowSelect = issetMeet(params_init, "rowSelect")
        ? params_init.rowSelect
        : false;
    var rowCount = issetMeet(params_init, "rowCount")
        ? params_init.rowCount
        : 10;
    var sorting = issetMeet(params_init, "sorting")
        ? params_init.sorting
        : true;
    var init_gestion = {
        rowCount: rowCount,
        selection: selection,
        multiSelect: multiSelect,
        keepSelection: keepSelection,
        rowSelect: rowSelect,
        labels: labels_objeto,
        css: css_objecto,
        templates: templates_objeto,
        formatters: formatters,
        sorting: sorting
    };
    $search_params = {
        grid_id: element,
        filters: filters
    };
    if (init_ajax) {
        //si envian parametros para inicializar desde ajax agregamos las posiciones
        init_gestion["url"] = url_get_data;
        init_gestion["post"] = function () {
            return $search_params;
        };
        init_gestion["ajaxSettings"] = {
            method: method
        };
        init_gestion["ajax"] = true;
    } else {
        templates_objeto["footer"] = "";
    }

    function initDropDownItems() {
        $.each($(element + "-header").find("ul li"), function (i, v) {
            if ($(v).find("input[name=id]").length) {
                $(v).hide();
            }
        });
    }

    var initEvents = false;
    //    -------INICIA EL BOOTGRID---
    gridId
        .on("load.rs.jquery.bootgrid", function (e) {
            //AQUI CAPTURAMOS LOS EVENTOS DEL BOOTGRID
            initCSSPagination();
            initDropDownItems();
            if (loadFunction) {
                //estos metodos s ocacionan cuando s envia ejecutarse luego de inicializar
                var perrins_params = {
                    id: "perro",
                    gato: "adad",
                    grid_obj: gridId,
                    e: e
                };
                loadFunction.call(perrins_params);
            }
        })
        .on("initialize.rs.jquery.bootgrid", function (e) {
            //AQUI CAPTURAMOS LOS EVENTOS DEL BOOTGRID

            if (initializeFunction) {
                //estos metodos s ocacionan cuando s envia ejecutarse luego de inicializar
                var perrins_params = {
                    id: "perro",
                    gato: "adad",
                    grid_obj: gridId,
                    e: e
                };
                initializeFunction.call(perrins_params);
            }
        })
        .on("initialized.rs.jquery.bootgrid", function (e) {
            //AQUI CAPTURAMOS LOS EVENTOS DEL BOOTGRID

            if (initializedFunction) {
                //estos metodos s ocacionan cuando s envia ejecutarse luego de inicializar
                var perrins_params = {
                    id: "perro",
                    gato: "adad",
                    grid_obj: gridId,
                    e: e
                };
                initializedFunction.call(perrins_params);
            }
        })
        .bootgrid(init_gestion)
        .on("loaded.rs.jquery.bootgrid", function () {
            //AQUI CAPTURAMOS LOS EVENTOS DEL BOOTGRID
            initCSSPagination();
            initFeatureTable();

            //  initEventClick();
            //        ---generar los drop--
            var params_empty_add = {
                title: params_empty.title,
                subtitle: params_empty.subtitle,
                icon: params_empty.icon,
                element: params.element
            };
            addRowEmpty(params_empty_add);
            setIconsPagination(); //ico

            //-------INICIALIZAR FUNCTIONS EXTRAS---
            if (loadedFunction) {
                //estos metodos s ocacionan cuando s envia ejecutarse luego de inicializar
                var perrins_params = {
                    id: "perro",
                    gato: "adad",
                    grid_obj: gridId
                };
                loadedFunction.call(perrins_params);
            }

            //      --------------PODEMOS AGREGAR VARIOS EVENTOS O VARIAS CLASES PARA PODER UTILIZARLES LUEGO ---
        });

    function initCSSPagination() {
        $.each($(".ul-content ul li"), function (i, v) {
            if (
                !(
                    $(v).hasClass("first") ||
                    $(v).hasClass("prev") ||
                    $(v).hasClass("last") ||
                    $(v).hasClass("next")
                )
            ) {
                if (!$(v).hasClass("m-datatable__pager-link")) {
                    $(v).addClass("m-datatable__pager-link");
                }
            } else {
                if ($(v).hasClass("prev") || $(v).hasClass("next")) {
                    $(v).hide();
                }
                if (!$(v).hasClass("m-datatable__pager-link")) {
                    $(v).addClass("m-datatable__pager-link");
                }
            }
        });
        var currentPage = $(element).bootgrid("getCurrentPage");
        if (currentPage == 0) {
            currentPage = "1";
        }

        $(".m-datatable__pager-link--active").removeClass(
            "m-datatable__pager-link--active"
        );
        $(".page-" + currentPage).addClass("m-datatable__pager-link--active");
    }

    return gridId;
}

function getModalByParams(params) {
    var action = params.action;
    var validateFormFunction = params.validateFormFunction;
    var modalElement = params.modalElement;
    var type =
        params.request && params.request.type ? params.request.type : "GET";
    var dataSend =
        params.request && params.request.data ? params.request.data : [];
    var error_message = params.error_message
        ? params.error_message
        : "Error al cargar formulario";

    ajaxRequest(action, {
        type: type,
        data: dataSend,
        error_message: error_message,
        success_callback: function (data) {
            modalElement.find(".container_modal").html("");
            modalElement.find(".container_modal").html(data.html);
            modalElement.modal({
                show: true,
                backdrop: "static",
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            var formManagerElement = params.formManagerElement
                ? params.formManagerElement
                : null;
            if (formManagerElement) {
                if (validateFormFunction) {
                    var formManagerElement = $(formManagerElement);
                    validateFormFunction.init(formManagerElement);
                }
            }
        }
    });
}

function saveRegisterManagementByModal(params) {
    var formElement = params.formManagerElement;
    var action = params.action;
    var blockElement = params.blockElement;
    var loading_message = "Guardando...";
    var success_message = params.success_message;
    var error_message = params.error_message;
    var functionInitBefore = params.functionInitBefore;
    var modalManagement = params.modalElement;
    if (formElement.valid()) {
        ajaxRequest(action, {
            type: "POST",
            data: formElement.serialize(),
            blockElement: blockElement, //opcional: es para bloquear el elemento
            loading_message: loading_message,
            error_message: error_message,
            success_message: success_message,
            success_callback: function (data) {
                modalManagement.modal("hide");
                if (functionInitBefore) {
                    functionInitBefore.call();
                }
            }
        });
    }
}

function generateNumberAleatory(min, max) {
    var num = Math.round(Math.random() * (max - min) + min);
    return num;
}

function getData(params) {
    var url = params.url;
    var dataSend = params.dataSend;
    var type = params.type;
    var blockElement = params.blockElement;

    var result = new Promise((resolve, reject) => {
        var paramsSend = {
            type: type,
            data: dataSend,
            blockElement: blockElement,
            loading_message: "Cargando...",
            error_message: "Error al obtener informacion.",
            success_message: "Informacion obtenida.",
            success_callback: function (response) {
                resolve(response);
            },
            errorCallback: function (response) {
                reject(response);
            }
        };
        ajaxRequest(url, paramsSend);
    });

    return result;
}

function disabledDateCalendar(data) {
    if (!$(".glyphicon.glyphicon-chevron-right").hasClass("right-button")) {
        $(".glyphicon.glyphicon-chevron-right")
            .removeClass("glyphicon-chevron-right")
            .removeClass("glyphicon")
            .addClass("fas fa-caret-right")
            .addClass("right-button");
    }
    if (!$(".glyphicon.glyphicon-chevron-left").hasClass("right-button")) {
        $(".glyphicon.glyphicon-chevron-left")
            .removeClass("glyphicon-chevron-left")
            .removeClass("glyphicon")
            .addClass("fas fa-caret-left")
            .addClass("left-button");
    }

    var date = data.date,
        mode = data.mode;
    var dateStringCalendar =
        date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    var dateCurrentCalendar = moment(dateStringCalendar);
    var dateCurrent = moment(dateStringCurrent);
    var resultDif = 0;
    var result = false;
    if (mode == "day") {
        resultDif = dateCurrent.diff(dateCurrentCalendar, "days");
        if (resultDif < 0) {
            result = true;
        }
    }
    return result;
}

function getDayClass(data) {
    var date = data.date,
        mode = data.mode;
    if (mode === "day") {
        var dayToCheck = new Date(date).setHours(0, 0, 0, 0);
        for (var i = 0; i < eventsDate.length; i++) {
            var currentDay = new Date(eventsDate[i].date).setHours(0, 0, 0, 0);
            if (dayToCheck === currentDay) {
                return eventsDate[i].status;
            }
        }
    }

    return "";
}

function managerModalSelect2() {
    $('span.select2-container').removeClass('select2-container-modal');
    $('span.select2-container').addClass('select2-container-modal');
}


getUrlContactWhatsApp = function (params) {

    var text = params['dataParams']['text'];
    var phoneCurrent = params['dataParams']['phone'];

    var typeSmarth = getMobileOperatingSystem();
    var urlRoot = '';
    var paramsPost = {
        dataParams: {
            text: text,
            phone: phoneCurrent,
        }

    };
    switch (typeSmarth) {
        case 'unknown':
            urlRoot = 'https://web.whatsapp.com/send?';
            break;

        case 'Android':

            paramsPost = {
                dataParams: {
                    text: text,
                }
            };
            urlRoot = 'https://wa.me/' + phoneCurrent + '?';

            break;
        case 'iOS':

            paramsPost = {
                dataParams: {
                    text: text,
                }
            };
            urlRoot = 'https://wa.me/' + phoneCurrent + '?';
            break;

    }


    var urlCurrent = urlRoot + getStringParamsGet(paramsPost);
    var result = urlCurrent;

    return result;
}

function getStringParamsGet(params) {
    var dataParams = params['dataParams'];
    var recursiveDecoded = decodeURIComponent($.param(dataParams));
    return recursiveDecoded;
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
        return 'iOS';

    } else if (userAgent.match(/Android/i)) {

        return 'Android';
    } else {
        return 'unknown';
    }
}

function msjSystem($data) {
    var $params = {};
    $params.title = $data.title ? $data.title : "Sin titulo";
    $params.color = $data.color ? $data.color : "#5384AF";
    $params.timeout = $data.timeout ? $data.timeout : 8000;
    $params.icon = $data.icon ? $data.icon : 8000;
    $params.content = $data.content ? $data.content : "nada";
    $params.type = $data.type ? $data.type : "info";

    showAlert($params.type, $params.content, 45000, $params.color);
}

function gestionInformacion(options) {
    var $url = options.url;
    var $async = options.async == true ? true : false;
    var $type = options.type ? options.type : "POST"; //GET
    var $data_formulario = options.data;
    var $dataType = options.dataType ? options.dataType : "json";

    $.ajax({
        type: $type,
        async: $async,
        url: baseUrl + $url,
        data: $data_formulario,
        dataType: $dataType,
        beforeSend: function (xhr) {
            //Acciones a reaqlizar antes del envio
            if (options.beforeCall) {
                options.beforeCall();
            }
        },
        success: function (data) {
            options.successCall(data);
        },
        error: function (data) {
            options.errorCall(data);
        },
        statusCode: {
            404: function (data) {
                return data;
            },
            401: function (data) {
                return data;

            }
            ,
            500: function (data) {
                return data;


            }, 400: function (data) {
                return data;


            }

        },
    });
}
