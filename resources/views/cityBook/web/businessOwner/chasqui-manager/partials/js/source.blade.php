<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>
<script src="https://unpkg.com/three@0.147.0/build/three.min.js"></script>
<script src="https://unpkg.com/three@0.147.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://unpkg.com/three@0.147.0/examples/js/loaders/GLTFLoader.js"></script>
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>
<script src="
https://cdn.jsdelivr.net/npm/nipplejs@0.10.2/dist/nipplejs.min.js
"></script>
<script>
    /* ============================================================================
* Datos de ejemplo: itemsSources
* ========================================================================== */
    let itemsSources = [
        {
            id: "taita",
            title: "Taita Imbabura – Abuelo que despierta las montañas",
            subtitle: "Ñawi Hatun Yaya – Yaku Kawsay Tukuy Kuna",
            description: "Padre volcán de Imbabura, sabio y vigilante. Desde sus laderas nacen vientos, manantiales y semillas que dan vida a la provincia. Sus aguas bajan hacia la laguna y alimentan chacras y comunidades. Taita Imbabura es guía y protector, un anciano vivo que recuerda a la gente su relación con la tierra y el agua.",
            position: {lat: 0.20477, lng: -78.20639},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
            }
        },
        {
            id: "cerro-cusin",
            title: "Cerro Cusin – Guardián del paso fértil",
            subtitle: "Allpa Ñanpi Rikchar – Chacra Kamak",
            description: "Cusin es el cerro que cuida los caminos que unen comunidades. La neblina que lo envuelve baja hacia Yaku Mama, manteniendo húmeda y fértil la tierra. Protege a quienes caminan, trabajan y siembran, recordando que cada sendero y cada chacra dependen del agua y del respeto a la montaña.",
            position: {lat: 0.20435, lng: -78.20688},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/cusin.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcusin.png'
            }
        },
        {
            id: "mojanda",
            title: "Mojanda – Susurro del páramo y las lagunas",
            subtitle: "Sachayaku Mama – Uksha Yaku Tiyana",
            description: "En Mojanda el páramo respira y de él nacen lagunas frías y puras. Sus aguas limpian el espíritu y alimentan ríos que descienden hacia los valles. Es un apu que conversa con las nubes y trae la lluvia necesaria para la vida. Mojanda recuerda que la vida empieza donde nace el agua.",
            position: {lat: 0.20401, lng: -78.20723},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mojanda.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/mojanda.png'
            }
        },
        {
            id: "mama-cotacachi",
            title: "Mama Cotacachi – Madre que abraza la Pachamama",
            subtitle: "Allpa Mama – Warmi Rasu",
            description: "Volcán madre que protege a las familias, a las semillas y a los tejidos de la vida diaria. Junto a Taita Imbabura equilibra los ciclos de clima, lluvia y fertilidad. Sus nubes y aguas sostienen a las comunidades. Mama Cotacachi representa cuidado, refugio y amor que sostiene la vida.",
            position: {lat: 0.20369, lng: -78.20759},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mama-cotacachi.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/warmi-razu.png'
            }
        },
        {
            id: "coraza",
            title: "El Coraza – Espíritu de celebración y memoria",
            subtitle: "Kawsay Taki – Yuyay Ayllu",
            description: "El Coraza es el espíritu del danzante que une a la gente con los apus y las aguas. Su baile honra a Taita Imbabura, a Mama Cotacachi y a Yaku Mama. A través de la fiesta se agradece a la tierra y a los ancestros. Mantiene viva la memoria del pueblo y la fuerza de su identidad.",
            position: {lat: 0.20349, lng: -78.20779},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/coraza-one.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcoraza.png'
            }
        },
        {
            id: "lechero",
            title: "El Lechero – Árbol del encuentro y los deseos",
            subtitle: "Kawsay Ranti – Yaku Rikuna Sacha",
            description: "Árbol sagrado donde las personas dejan promesas, agradecimientos y recuerdos. Desde su altura contempla a los apus y a la laguna. Es un puente entre el corazón humano y la naturaleza. El Lechero recibe los deseos y los entrega al viento, conectándolos con el gran tejido de la vida.",
            position: {lat: 0.20316, lng: -78.20790},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lechero.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/lechero.png'
            }
        },
        {
            id: "lago-san-pablo",
            title: "Yaku Mama – La laguna viva de Imbabura",
            subtitle: "Yaku Mama – Kawsaycocha",
            description: "Laguna madre que recibe las aguas de Imbabura, Cusin, Mojanda y Cotacachi. Refleja a los apus y al cielo, y devuelve alimento, pesca y calma a las comunidades. Yaku Mama es un ser vivo que siente y escucha; su existencia recuerda que sin agua no hay vida ni memoria.",
            position: {lat: 0.20284, lng: -78.20802},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/yaku-mama.png'
            }
        },
        {
            id: "ayahuma-pacha",
            title: "Ayahuma – Espíritu que escucha la tierra",
            subtitle: "Aya Huma – Yuyay Uma",
            description: "Espíritu que representa conciencia, equilibrio y claridad. Ayahuma ayuda a escuchar la voz profunda de la tierra y a entender que cada decisión humana tiene efecto en la Pachamama. Acompaña los procesos de cambio y protege la conexión entre los apus, el agua y las comunidades.",
            position: {lat: 0.20184, lng: -78.20902},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/ayahuma.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/ayahuma.jpeg'
            }
        },
        {
            id: "corazon-pacha",
            title: "Corazón Pacha – Nodo de energía y vida",
            subtitle: "Pacha Sonkoy – Kawsay Tinkuy",
            description: "Lugar simbólico donde se encuentran los caminos del agua, la montaña y el ser humano. Es el centro energético de la zona, un punto donde todo late al mismo tiempo. Corazón Pacha recuerda que los apus, la laguna y la gente forman una sola familia dentro de la tierra viva.",
            position: {lat: 0.20084, lng: -78.21002},
            sources: {
                glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/corazon.glb',
                img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/corazon.jpeg'
            }
        }
    ];
    var $dataManager = <?php echo json_encode($dataManager) ?>;
</script>
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

<script>
    /* ============================================================================
* CameraOverlayComposer: captura frames de cámara + canvas3D opcional
* ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.CameraOverlayComposer')
<script>
    /* ============================================================================
     * Plataforma + capacidades
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.Platform')
<script>
    /* ============================================================================
     * UI Manager (jQuery-friendly)
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.Ui')
<script>
    /* ============================================================================
     * Utilidades
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.DownloadUtils')
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.StatsUtils')
<script>
    /* ============================================================================
     * ModelViewerController (fallback <model-viewer>)
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.ModelViewerController')
<script>
    /* ============================================================================
     * AndroidWebXRController
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.AndroidWebXRController')
<script>
    /* ============================================================================
     * ViewerOrchestrator
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.ViewerOrchestrator')

<script>
    /* ============================================================================
     * Mapa (Leaflet)
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.MapController')

<script>
    /* ============================================================================
     * Device events
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.DeviceEvents')

<script>
    /* ============================================================================
     * AssetPreloader (precache GLB) + Verificador de cache
     * ========================================================================== */
</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.AssetPreloader')
<script>
    /* ============================================================================
     * ItemsStore + verificador de caché por item
     * ========================================================================== */

</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.ItemsStore')
<script>
    /* ============================================================================
    * canScreenCapture
    * ========================================================================== */

</script>
@include('cityBook.web.businessOwner.chasqui-manager.partials.js.canScreenCapture')

<script>
    /* ============================================================================
     * initPreCache
     * ========================================================================== */

</script>

@include('cityBook.web.businessOwner.chasqui-manager.partials.js.initPreCache')

<script>
    /* ============================================================================
     * Helpers de debug de cache (opcional)
     * ========================================================================== */
    window.CacheDebug = {
        async logAll() {
            const items = ItemsStore.getItems();
            for (const it of items) {
                const info = await ItemsStore.getCacheInfo(it.id);
                console.log('[CacheDebug] item', it.id, info);
            }
        },
        async logOne(id) {
            const info = await ItemsStore.getCacheInfo(id);
            console.log('[CacheDebug] item', id, info);
        }
    };
    /* ============================================================================
     * Bootstrap — usando jQuery
     * ========================================================================== */
    let itemsSourcesAux = [];

    function verifyStatePanelCollapsed() {
        $("#btn-capture").removeClass("btn-view-data-cam");
        $("#joystick-zone").removeClass("btn-view-data-cam-joystick-zone");
        const companyPanel = document.getElementById('companyPanelHeader');
        companyPanel.classList.contains('company-panel--collapsed')
        if (companyPanel.classList.contains('company-panel--collapsed')) {
            $("#btn-capture").removeClass("btn-view-data-cam");
            $("#joystick-zone").removeClass("btn-view-data-cam-joystick-zone");

        } else {
            $("#btn-capture").addClass("btn-view-data-cam");
            $("#joystick-zone").addClass("btn-view-data-cam-joystick-zone");

        }

    }

    $(function () {
            initWhatsapp();
            ItemsStore.setItems(itemsSources);
            UI.bind();
            window.Viewer = new ViewerOrchestrator();
            const mapCtl = new MapController({});
            initPreCache({mapCtl: mapCtl});
            mapCtl.initDrawOther($itemsOtherDraw);
            DeviceEvents.attach();
            UI.$reticle?.addEventListener('click', async () => {
                await window.Viewer.handleReticleTap();
            });
            UI.$back?.addEventListener('click', async () => {
                await window.Viewer.destroy();
                window.disableJoystick();

            });
            UI.$capture?.addEventListener('click', async () => {
                await window.Viewer.onCaptureGpu();
            });

            const companyPanel = document.getElementById('companyPanelHeader');
            companyPanel.addEventListener('click', () => {
                companyPanel.classList.toggle('company-panel--collapsed');
                const body = document.querySelector('.company-panel__body');
                if (companyPanel.classList.contains('company-panel--collapsed')) {
                    body.style.display = 'none';

                } else {
                    body.style.display = 'block';

                }
                verifyStatePanelCollapsed(false);
            });
            const btnMoreInfo = document.getElementById('btnMoreInfo');
            const companyDescriptionEl = document.getElementById('companyDescription');
            btnMoreInfo.addEventListener('click', () => {
                const isExpanded = btnMoreInfo.dataset.expanded === 'true';
                const full = companyDescriptionEl.dataset.full;
                const short = companyDescriptionEl.dataset.short || full;
                if (isExpanded) {
                    btnMoreInfo.textContent = 'Ver más';
                    btnMoreInfo.dataset.expanded = 'false';
                } else {
                    // Mostrar descripción completa
                    //    companyDescriptionEl.textContent = full;
                    btnMoreInfo.textContent = 'Ver menos';
                    btnMoreInfo.dataset.expanded = 'true';
                }
            });
            btnMoreInfo.click();
            initJoystickZone();
        }
    );
    const JoystickState = {
        enabled: false,
        manager: null
    };

    function initJoystickZone() {
        function isViewerReady() {
            if (!window.Viewer) return false;
            if (typeof window.Viewer.isActive === 'function') {
                return window.Viewer.isActive();
            }
            return !!window.Viewer.state?.controller;
        }

        const zoneEl = document.getElementById('joystick-zone');
        if (!zoneEl) return;

        const options = {
            zone: zoneEl,
            mode: 'static',
            position: {left: '50%', top: '50%'},
            size: 120,
            color: '#4C4CFF', // azulClic
            restOpacity: 0.8,
            lockX: false,
            lockY: false
        };

        const manager = nipplejs.create(options);
        JoystickState.manager = manager;
        JoystickState.enabled = false;  // arranca DESHABILITADO

        // ---- Parámetros de comportamiento del joystick ----
        const DEAD_ZONE = 0.25;   // un poco más grande para que no tiemble
        const BASE_STEP = 0.2;    // antes 2 → ahora MUCHO más suave
        const EXTRA_STEP = 0.8;    // antes 8 → rango total ~0.2–1.0 grados
        // Throttle de tiempo (ms)
        const MIN_INTERVAL = 40;   // ~25fps, suficiente para sentirse fluido
        let lastTime = 0;
        let viewerType = "";
        manager.on('move', function (evt, data) {
            if (!JoystickState.enabled) return;
            if (!data || !data.vector || !data.angle) return;
            const now = performance.now();
            if (now - lastTime < MIN_INTERVAL) return; // ⏱️ throttle
            lastTime = now;
            const angle = data.angle.degree;   // 0 dcha, 90 arriba, 180 izq, 270 abajo
            const force = data.force || 0;
            if (force < DEAD_ZONE) return;
            // step proporcional pero pequeño
            let step = BASE_STEP + (force - DEAD_ZONE) * (EXTRA_STEP / (1 - DEAD_ZONE));
            if (step < BASE_STEP) step = BASE_STEP;
            if (step > BASE_STEP + EXTRA_STEP) step = BASE_STEP + EXTRA_STEP;

            if (!isViewerReady()) return;

            // Mapeo por cuadrantes
            if (angle >= 45 && angle < 135) {
                // ARRIBA
                viewerType = "ARRIBA";
                window.Viewer.rotateModelUp(step);
            } else if (angle >= 135 && angle < 225) {
                // IZQUIERDA
                viewerType = "IZQUIERDA";
                // si a nivel visual sientes que va al lado contrario,
                // aquí puedes cambiar Right por Left
                window.Viewer.rotateModelRight(step);

            } else if (angle >= 225 && angle < 315) {
                // ABAJO
                viewerType = "ABAJO";
                window.Viewer.rotateModelDown(step);

            } else {
                // DERECHA (0–45 y 315–360)
                viewerType = "DERECHA";
                window.Viewer.rotateModelLeft(step);
            }

            console.log('Joystick:', viewerType, 'step:', step.toFixed(3));
        });

        manager.on('end', function () {
            // aquí podrías resetear algo si lo necesitas
        });

        window.enableJoystick = function () {
            JoystickState.enabled = true;
            zoneEl.style.display = 'block';
            zoneEl.classList.add('joystick--enabled');
            zoneEl.classList.remove('joystick--disabled');
        };

        window.disableJoystick = function () {
            JoystickState.enabled = false;
            zoneEl.classList.add('joystick--disabled');
            zoneEl.classList.remove('joystick--enabled');
        };

        zoneEl.classList.add('joystick--disabled');
        zoneEl.classList.add('btn-view-data-cam-joystick-zone');
    }


</script>
