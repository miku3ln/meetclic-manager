<script>
    function initWhatsapp() {
        if ($dataManager.business && $dataManager.business.dataPhoneWhatsapp && $dataManager.business.dataPhoneWhatsapp.urlWhatsapp != '') {
            var urlWhatsapp = getUrlWhatsApp() + $dataManager.business.dataPhoneWhatsapp.urlWhatsapp;
            console.log(urlWhatsapp);
            $("#companyWhatsapp").attr("href", urlWhatsapp);
        }
    }
    function hasUploadsPath(url) {
        let result = url.indexOf("/uploads/") !== -1;
        return result;
    }
    function pathTieneArchivo(path) {
        // Quita posibles "/" del final
        path = path.replace(/\/+$/, '');

        const partes = path.split('/');
        const ultimo = partes[partes.length - 1];

        // Si el último fragmento tiene un punto, asumimos que es archivo
        return ultimo.includes('.');
    }
    var $itemsOtherDraw = [];
    if ($dataManager.allow) {
        let dataItemsMap =
            getStructureRouteMap({
                map: "",
                haystack: $dataManager.dataRoute.routes_drawing_data,
                typeGetData: true
            });
        let haystack = dataItemsMap.layers;
        let itemsSourcesAux = [];
        var defaultMarker = "/wulpy/developers/assets/images/markers/excursiones.png";
        $.each(haystack, function (key, value) {
            let isMarker = false;
            let setPush = {
                id: value.id,
                title: value.title,
                subtitle: value.subtitle,
                description: value.content,
                position: null,
                sources: null,
                routes_map_id: value.routes_map_id,
                totem_category_code: value.totem_category_code,
                totem_category_id: value.totem_category_id,
                totem_category_name: value.totem_category_name,
                totem_subcategory_code: value.totem_subcategory_code,
                totem_subcategory_id: value.totem_subcategory_id,
                totem_subcategory_name: value.totem_subcategory_name,
                totem_subcategory_real_id: value.totem_subcategory_real_id,
            };
            if (value.type == "marker") {
                var srcCurrent = "";
                let sources = {glb: null, img: null};
                if (typeof value.dataSource.src_glb !== 'undefined') {
                    srcCurrent = value["dataSource"].src_glb;
                    let isManagerSystem = hasUploadsPath(srcCurrent);
                    if (isManagerSystem) {
                        let existData = pathTieneArchivo(srcCurrent);
                        if (!existData) {
                            srcCurrent = defaultMarker;
                        }
                        srcCurrent = window.$dataManagerPage?.['public-root'] + srcCurrent;
                    }
                    sources.glb = srcCurrent;
                }
                srcCurrent = value["dataSource"].src;
                let isManagerSystem = hasUploadsPath(srcCurrent);
                if (isManagerSystem) {
                    let existData = pathTieneArchivo(srcCurrent);
                    if (!existData) {
                        srcCurrent = defaultMarker;
                    }
                    srcCurrent = window.$dataManagerPage?.['public-root'] + srcCurrent;
                }
                sources.img = srcCurrent;
                setPush.sources = sources;
                setPush.position = value.position;

                itemsSourcesAux.push(setPush);


            } else {

                $itemsOtherDraw.push(value);
            }

        });
        console.log("DOMContentLoaded (jQuery ready)");
        if (itemsSourcesAux.length > 0) {
            itemsSources = [];
            itemsSources = itemsSourcesAux;

        }
    }
    function addRoutesDrawingToMap(map, drawings) {
        if (!Array.isArray(drawings)) {
            console.warn('drawings no es un array');
            return;
        }

        drawings.forEach(function (item) {
            var type = item.type; // "rectangle", "polygon", "polyline", etc.
            var layer = null;

            // Opciones comunes de estilo
            var strokeColor = item.strokeColor || '#000000';
            var strokeWeight = item.strokeWeight || 2;
            var strokeOpacity = (typeof item.strokeOpacity !== 'undefined') ? item.strokeOpacity : 1;
            var fillColor = item.fillColor || strokeColor;
            var fillOpacity = (typeof item.fillOpacity !== 'undefined') ? item.fillOpacity : 0.2;

            var baseOptions = {
                color: strokeColor,
                weight: strokeWeight,
                opacity: strokeOpacity
            };

            // RECTÁNGULO
            if (type === 'rectangle' && item.bounds) {
                var b = item.bounds;
                // Leaflet espera [ [southLat, westLng], [northLat, eastLng] ]
                var southWest = L.latLng(b.south, b.west);
                var northEast = L.latLng(b.north, b.east);
                var bounds = L.latLngBounds(southWest, northEast);

                layer = L.rectangle(bounds, Object.assign({}, baseOptions, {
                    fillColor: fillColor,
                    fillOpacity: fillOpacity
                }));
            }

            // POLÍGONO
            else if (type === 'polygon' && Array.isArray(item.paths)) {
                var latLngsPolygon = item.paths.map(function (p) {
                    return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                });

                layer = L.polygon(latLngsPolygon, Object.assign({}, baseOptions, {
                    fillColor: fillColor,
                    fillOpacity: fillOpacity
                }));
            }

            // POLILÍNEA
            else if (type === 'polyline' && Array.isArray(item.path)) {
                var latLngsLine = item.path.map(function (p) {
                    return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                });

                layer = L.polyline(latLngsLine, baseOptions);
            }

            // Si no se reconoció el tipo o faltan datos, salimos
            if (!layer) {
                console.warn('No se pudo crear layer para item id:', item.id, 'type:', type);
                return;
            }

            // 👉 Opcional: guardar meta-datos dentro del layer
            layer._totemMeta = {
                id: item.id,
                rd_id: item.rd_id,
                routes_drawing_id: item.routes_drawing_id,
                routes_map_id: item.routes_map_id,
                totem_category_code: item.totem_category_code,
                totem_category_id: item.totem_category_id,
                totem_category_name: item.totem_category_name,
                totem_subcategory_code: item.totem_subcategory_code,
                totem_subcategory_id: item.totem_subcategory_id,
                totem_subcategory_name: item.totem_subcategory_name,
                title: item.title,
                subtitle: item.subtitle,
                content: item.content
            };
            // 👉 Agregar al mapa
            layer.addTo(map);
        });
    }
    function getStructureRouteMap(params) {
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
                var rd_description = value["rd_description"] ? value["rd_description"] : "";
                var rd_id = value["rd_id"];
                var routes_drawing_id = value["routes_drawing_id"];
                var rd_subtitle = value["rd_subtitle"];
                var routes_map_id = value["routes_map_id"];
                var totem_category_code = value["totem_category_code"];

                var totem_category_id = value["totem_category_id"];
                var totem_category_name = value["totem_category_name"];
                var totem_subcategory_code = value["totem_subcategory_code"];
                var totem_subcategory_id = value["totem_subcategory_id"];
                var totem_subcategory_name = value["totem_subcategory_name"];
                var totem_subcategory_real_id = value["totem_subcategory_real_id"];

                var setPush = null;
                var options = jQuery.parseJSON(value["rd_options_type"]);
                options = mergeObjects(options, {
                    title: rd_name,
                    type: typeLayer,
                    content: rd_description,
                    id: id,
                    rd_id: rd_id,
                    routes_drawing_id: routes_drawing_id,
                    subtitle: rd_subtitle,
                    routes_map_id: routes_map_id,
                    totem_category_code: totem_category_code,
                    totem_category_id: totem_category_id,
                    totem_category_name: totem_category_name,
                    totem_subcategory_code: totem_subcategory_code,
                    totem_subcategory_id: totem_subcategory_id,
                    totem_subcategory_name: totem_subcategory_name,
                    totem_subcategory_real_id: totem_subcategory_real_id,

                });

                var path = [];
                switch (typeLayer) {
                    case "marker":
                        var data = value.hasOwnProperty('data') ? value["data"] : [];
                        path = options.position;
                        options['data'] = data;
                        options['dataSource'] = {};
                        if (value.rd_src == null) {
                            options['dataSource']["src"] = "https://meetclic.com/public/wulpy/developers/assets/images/markers/artesanias.png";
                        } else {
                            options['dataSource']["src"] = value.rd_src;
                        }
                        if (value.rd_src_glb == null) {
                        } else {
                            options['dataSource']["src_glb"] = value.rd_src_glb;
                        }
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
</script>
