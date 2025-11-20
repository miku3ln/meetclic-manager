function getFormatterProcess(params) {
    var processName = params['processName'];
    var viewAll = params.hasOwnProperty('viewAll') ? params['viewAll'] : false;
    var structure = params['structure'];
    var vmCurrent = params['vmCurrent'];

    var $result;
    if (processName == 'products') {


        if (viewAll) {
            $result = {
                'check-list-manager': function (column, row) {
                    var key_id = row.id;
                    return '<input class="check-list-manager"  id="checkbox-' + key_id + '" name="select" type="checkbox" class="select-box" value="' + key_id + '">';
                },
                'description': function (column, row) {
                    var classStatus = "badge-success";

                    var classQuantityUnits = "badge-success";
                    var quantity_units = parseFloat(row.quantity_units != null ? row.quantity_units : 0);
                    if (quantity_units == 0) {
                        classQuantityUnits = "badge-danger";
                    } else if (quantity_units > 0 && quantity_units < 20) {
                        classQuantityUnits = "badge-warning";

                    } else if (quantity_units > 20) {
                        classQuantityUnits = "badge-success";

                    }
                    var variantColors = row.colors;
                    var variantSizes = row.sizes;
                    var dataCurrentGet = variantSizes;
                    var variantSizesHtml = [];
                    $.each(dataCurrentGet, function (key, value) {
                        variantSizesHtml.push(value.text);
                    });
                    variantSizesHtml = variantSizesHtml.join(",");
                    variantSizesHtml = variantSizesHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_sizes_data.label + '</span>:<span class=\'content-description__value\'>' + variantSizesHtml + ".</span></div>" : "";

                    dataCurrentGet = variantColors;
                    var variantColorsHtml = [];
                    $.each(dataCurrentGet, function (key, value) {
                        variantColorsHtml.push(value.text);
                    });

                    variantColorsHtml = variantColorsHtml.join(",");
                    variantColorsHtml = variantColorsHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_color_data.label + '</span>:<span class=\'content-description__value\'>' + variantColorsHtml + ".</span></div>" : "";
                    var shippingFeeAll = [];
                    if (row.height != null) {
                        shippingFeeAll = [
                            '<div class="content-description__details">',
                            "   <h2 class='content-description__title-details'>" + vmCurrent.configProcess.shipping.title + "</h2>",
                            "   <span class='content-description__information'><span class='content-description__title'>" + structure.height.label + '</span>:<span class=\'content-description__value\'>' + row.height + ".</span></div>",
                            "   <span class='content-description__information'><span class='content-description__title'>" + structure.length.label + '</span>:<span class=\'content-description__value\'>' + row.length + ".</span></div>",
                            "   <span class='content-description__information'><span class='content-description__title'>" + structure.width.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",
                            "   <span class='content-description__information'><span class='content-description__title'>" + structure.weight.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",

                            '</div >'

                        ];
                    }
                    shippingFeeAll = shippingFeeAll.join(" ");
                    var variantAll = [];
                    if (variantColorsHtml != '' || variantSizesHtml != '') {


                        variantAll = [
                            '<div class="content-description__details">',
                            "<h2 class='content-description__title-details'>" + vmCurrent.configProcess.variants.title + "</h2>",
                            variantColorsHtml == "" ? "" : variantColorsHtml,
                            variantSizesHtml == "" ? "" : variantSizesHtml,
                            '</div >'

                        ];
                    }
                    variantAll = variantAll.join(" ");
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    var description = row.description != null ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>"
                    ] : [];
                    description = description.join('');
                    var code_provider = row.code_provider != null ? ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code_provider.label + ":</span><span class='content-description__value'>" + row.code_provider + "</span>",
                        "</div>"] : [];
                    code_provider = code_provider.join('');

                    var code_product = row.code_product != null ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code_product.label + ":</span><span class='content-description__value'>" + row.code_product + "</span>",
                        "</div>"
                    ] : [];
                    code_product = code_product.join('');
                    var unitsCurrent = structure.hasOwnProperty('quantity_units') ? ["   <div class='content-description__information--quantity'>",
                        "        <span class='content-description__title'>" + structure.quantity_units.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classQuantityUnits + " '>" + quantity_units + "</span></span>",
                        "   </div>"] : [];
                    unitsCurrent = unitsCurrent.join('');
                    var result = [
                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.view_online.label + ":</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + (row.view_online ? "badge-success" : "badge-warning") + "'>" + (row.view_online ? "SI" : "NO") + "</span>" + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code.label + ":</span><span class='content-description__value'>" + row.code + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.has_tax.label + ":</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + (row.has_tax ? "badge-success" : "badge-info") + "'>" + (row.has_tax ? (row.tax_value) : "NO") + "</span>" + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.sale_price.label + ":</span><span class='content-description__value'>" + "<span class='badge badge--size-large badge-info'>" + parseFloat(row.sale_not_tax) + "</span>" + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'> Precio Venta:</span><span class='content-description__value'>" + "<span class='badge badge--size-large badge-warning'>" + parseFloat(row.sale_price) + "</span>" + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_trademark_id_data.label + ":</span><span class='content-description__value'>" + row.product_trademark + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_category_id_data.label + ":</span><span class='content-description__value'>" + row.product_category + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_subcategory_id_data.label + ":</span><span class='content-description__value'>" + row.product_subcategory + "</span>",
                        "</div>",

                        "<div class='content-description__information content-description__information--image'>",
                        unitsCurrent,
                        "   <img class='content-description__image' src='" + $resourceRoot + row.source + "'> ",
                        "</div>",
                        description,
                        variantAll,
                        shippingFeeAll,
                        "  <div class='content-description__information'>",
                        "       <span     class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span><span class='content-description__value'>" + row.product_measure_type + "</span>",
                        "  </div>",
                        "</div>"
                    ];

                    return result.join("");
                }
            };

        }

    } else if (processName == 'productsDiscounts') {

        $result = {
            'check-list-manager': function (column, row) {
                var key_id = row.id;
                return '<input class="check-list-manager"  id="checkbox-' + key_id + '" name="select" type="checkbox" class="select-box" value="' + key_id + '">';
            },
            'description': function (column, row) {

                var classStatus = "badge-success";
                var variantColors = row.colors;
                var variantSizes = row.sizes;
                var dataCurrentGet = variantSizes;
                var variantSizesHtml = [];
                $.each(dataCurrentGet, function (key, value) {
                    variantSizesHtml.push(value.text);
                });
                variantSizesHtml = variantSizesHtml.join(",");
                variantSizesHtml = variantSizesHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_sizes_data.label + '</span>:<span class=\'content-description__value\'>' + variantSizesHtml + ".</span></div>" : "";

                dataCurrentGet = variantColors;
                var variantColorsHtml = [];
                $.each(dataCurrentGet, function (key, value) {
                    variantColorsHtml.push(value.text);
                });

                variantColorsHtml = variantColorsHtml.join(",");
                variantColorsHtml = variantColorsHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_color_data.label + '</span>:<span class=\'content-description__value\'>' + variantColorsHtml + ".</span></div>" : "";
                var shippingFeeAll = [];
                if (row.height != null) {
                    shippingFeeAll = [
                        '<div class="content-description__details">',
                        "   <h2 class='content-description__title-details'>" + vmCurrent.configProcess.shipping.title + "</h2>",
                        "   <span class='content-description__information'><span class='content-description__title'>" + structure.height.label + '</span>:<span class=\'content-description__value\'>' + row.height + ".</span></div>",
                        "   <span class='content-description__information'><span class='content-description__title'>" + structure.length.label + '</span>:<span class=\'content-description__value\'>' + row.length + ".</span></div>",
                        "   <span class='content-description__information'><span class='content-description__title'>" + structure.width.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",
                        "   <span class='content-description__information'><span class='content-description__title'>" + structure.weight.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",
                        '</div >'

                    ];
                }

                shippingFeeAll = shippingFeeAll.join(" ");
                var variantAll = [];
                if (variantColorsHtml != '' || variantSizesHtml != '') {

                    variantAll = [
                        '<div class="content-description__details">',
                        "<h2 class='content-description__title-details'>" + vmCurrent.configProcess.variants.title + "</h2>",
                        variantColorsHtml == "" ? "" : variantColorsHtml,
                        variantSizesHtml == "" ? "" : variantSizesHtml,
                        '</div >'

                    ];
                }

                variantAll = variantAll.join(" ");
                if (row.status == "INACTIVE") {
                    classStatus = "badge-warning"
                }
                var description = row.description != null ? [
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                    "</div>"
                ] : [];
                description = description.join('');
                var code_provider = row.code_provider != null ? ["<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.code_provider.label + ":</span><span class='content-description__value'>" + row.code_provider + "</span>",
                    "</div>"] : [];
                code_provider = code_provider.join('');

                var code_product = row.code_product != null ? [
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.code_product.label + ":</span><span class='content-description__value'>" + row.code_product + "</span>",
                    "</div>"
                ] : [];
                code_product = code_product.join('');
                var result = [
                    "<div class='content-description'>",

                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.view_online.label + ":</span><span class='content-description__value'>" + (row.view_online ? "SI" : "NO") + "</span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.code.label + ":</span><span class='content-description__value'>" + row.code + "</span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.sale_price.label + ":</span><span class='content-description__value'>" + parseFloat(row.sale_price) + "</span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                    "</div>",

                    "<div class='content-description__information'>",
                    "   <span relation class='content-description__title'>" + structure.product_trademark_id_data.label + ":</span><span class='content-description__value'>" + row.product_trademark + "</span>",
                    "</div>",

                    "<div class='content-description__information'>",
                    "   <span relation class='content-description__title'>" + structure.product_category_id_data.label + ":</span><span class='content-description__value'>" + row.product_category + "</span>",
                    "</div>",

                    "<div class='content-description__information'>",
                    "   <span relation class='content-description__title'>" + structure.product_subcategory_id_data.label + ":</span><span class='content-description__value'>" + row.product_subcategory + "</span>",
                    "</div>",

                    "<div class='content-description__information'>",
                    "   <img class='content-description__image' src='" + $resourceRoot + row.source + "'> ",
                    "</div>",

                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" + structure.has_tax.label + ":</span><span class='content-description__value'>" + (row.has_tax ? "SI" : "NO") + "</span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span     class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span><span class='content-description__value'>" + row.product_measure_type + "</span>",
                    "</div>"
                    , "</div>"];

                return result.join("");
            }
        }


    }
    return $result;
}

function initSelectMultiple(params) {
    var haystack = params.haystack;
    var elementS2 = params.elementS2;
    for (var row in haystack) {


    }
    $.each(haystack, function (key, value) {
        var option = new Option(value['text'], value, true, true);
        elementS2.append(option).trigger('change');
    });

}


function getStructureRouteMap(params) {//TODO CHASQUI-MANAGEMENT
    var latLngData = [];
    var dataLayers = [];
    var mapCurrentRoutes = params['map'];
    var optionsCenter = [];
    var haystack = params.haystack;
    var routeInformation = params.routeInformation;
    var typeGetData = params.typeGetData;//true=db,false=kml
    if (typeGetData) {//DB

        $.each(haystack, function (key, value) {
            var typeLayer = value["rd_type"];
            var id = value["id"];
            var rd_name = value["rd_name"] ? value["rd_name"] : "";
            var subtitle = value["rd_subtitle"] ? value["rd_subtitle"] : "";

            var rd_description = value["rd_description"] ? value["rd_description"] : "";
            var rd_id = value["rd_id"];
            var routes_drawing_id = value["routes_drawing_id"];
            var totem_subcategory_id = value["totem_subcategory_id"];


            var setPush = null;
            var options = jQuery.parseJSON(value["rd_options_type"]);
            options = mergeObjects(options, {
                title: rd_name,
                subtitle: subtitle,
                type: typeLayer,
                content: rd_description,
                id: id,
                rd_id: rd_id,
                routes_drawing_id: routes_drawing_id,
                totem_subcategory_id:totem_subcategory_id
            });

            var path = [];
            switch (typeLayer) {
                case "marker":
                    var data = value.hasOwnProperty('data') ? value["data"] : [];
                    path = options.position;
                    options['data'] = data;

                    options['file_src'] = value["rd_src"];
                    options['file_glb'] = value["rd_src_glb"];

                    setPush = getConfigMarker({
                        options: options,
                        map: mapCurrentRoutes
                    });

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
                latLngData.push({
                    type: typeLayer,
                    haystack: path
                });
                dataLayers.push(setPush);

                var setPushCenter = getCenterByType({
                    obj: setPush,
                    type: typeLayer,
                    path: path
                });
                optionsCenter.push(setPushCenter);
            }
        });
    } else {
        $.each(haystack, function (key, layer) {
            var setPush = null;
            var path = [];
            var typeLayer = layer.type;
            console.log('KML READ', typeLayer);
            if (typeLayer == "marker") {
                setPush = getConfigMarker({
                    options: layer,
                    map: mapCurrentRoutes
                });
                path = layer.position;


            } else if (typeLayer == "polyline") {
                setPush = getConfigPolyline({
                    options: layer,
                    map: mapCurrentRoutes
                });
                path = layer.path;

            }
            if (setPush) {
//step 1
                latLngData.push({
                    type: typeLayer,
                    haystack: path
                });
                dataLayers.push(setPush);

                var setPushCenter = getCenterByType({
                    obj: setPush,
                    type: layer.type,
                    path: path
                });
                optionsCenter.push(setPushCenter);

            }
        });
    }
    var result = {layers: dataLayers, latLngData: latLngData, optionsCenter: optionsCenter};
    return result;


}

function _setLayerMap(overlay, mapObj, content, functionCurrent = null) {
    var $scope = this;
    var infWindow = new google.maps.InfoWindow();
    this.setStyle = function (domElem, styleObj) {

        if (typeof styleObj == "object") {
            for (var prop in styleObj) {
                domElem.style[prop] = styleObj[prop];
            }
        }
    }
    this.openInfoWindow = function (overlay, latLng, content) {

        var div = document.createElement('div');
        div.innerHTML = content;
        this.setStyle(div, {height: "100%"});
        infWindow.setContent(div);
        infWindow.setPosition(latLng);
        infWindow.relatedOverlay = overlay;
        var t = overlay.get('fillColor');
        infWindow.open(mapObj);
    }
    google.maps.event.addListener(overlay, "click", function (clkEvent) {

        $scope.openInfoWindow(overlay, clkEvent.latLng, content);
        if (functionCurrent) {
            functionCurrent(overlay);
        }

    });
    google.maps.event.addListener(overlay, "bounds_changed", function () {
        console.log("bounds_changed");

    });
}

