<script>
    class MapController {

        constructor(cfg) {
            this.cfg = Object.assign({
                zoom: 19, maxZoom: 25, position: [0.20830, -78.22798],
                tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileAttribution: '&copy; OpenStreetMap contribuyentes'
            }, cfg || {});
            this.map = null;
            this.layer = null;
            this.byId = {};
            this.appMapConfig = {
                zoom: {
                    WORLD: 0,          // Vista del planeta
                    CONTINENT: 2,      // Vista continental
                    COUNTRY: 5,        // País / región
                    CITY: 10,          // Ciudad

                    CITY_DETAIL: 12,   // Ciudad con buenas calles
                    NEIGHBORHOOD: 14,  // Barrios
                    STREET: 16,        // Vista de calles
                    HOUSE: 17,         // Casas (zoom recomendado)
                    BUILDING: 18,      // Muy cerca
                    MAX: 19            // Máximo recomendado por OSM
                },

                flyOptions: {
                    FAST: {duration: 0.35},
                    NORMAL: {duration: 0.7},
                    SLOW: {duration: 1.2}
                }
            };

        }

        initDrawOther(drawings) {
            let map = this.map;
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

                // 👉 Popup básico usando título, subcategoría y contenido
                var popupHtml = '<strong>' + (item.title || '') + '</strong><br>' +
                    '<em>' + (item.subtitle || '') + '</em><br>' +
                    (item.totem_category_name ? ('<br><b>Categoria:</b> ' + item.totem_category_name) : '') +
                    (item.totem_subcategory_name ? ('<br><b>Subcategoria:</b> ' + item.totem_subcategory_name) : '') +
                    (item.content ? ('<br><br>' + item.content) : '');

                //   layer.bindPopup(popupHtml);

                // 👉 Agregar al mapa
                layer.addTo(map);
            });
        }

        init(items) {
            this.map = L.map('map', {zoomControl: true}).setView(this.cfg.position, this.cfg.zoom);
            L.tileLayer(this.cfg.tileUrl, {
                maxZoom: this.cfg.maxZoom,
                attribution: this.cfg.tileAttribution
            }).addTo(this.map);
            this.layer = L.layerGroup().addTo(this.map);
            this.render(items);

            this.map.on('popupopen', (e) => {
                this._bindPopup(e);
                const mk = e.popup._source;
                if (mk) {
                    console.log("popupopen");
                    requestAnimationFrame(() => this.map.flyTo(mk.getLatLng(), this.appMapConfig.zoom.BUILDING, {duration: 0.35}));
                }
            });
        }

        render(items) {
            this.layer.clearLayers();
            this.byId = {};
            const bounds = [];
            items.forEach(it => {
                const icon = L.icon({
                    iconUrl: it.sources.img,
                    iconSize: [60, 60],
                    iconAnchor: [60, 60],
                    popupAnchor: [0, -40]
                });
                const mk = L.marker([it.position.lat, it.position.lng], {icon, title: it.title})
                    .bindPopup(this._popupHTML(it), {maxWidth: 320, autoPan: true, keepInView: true});
                mk.addTo(this.layer);
                mk.on('click', () => {
                    let currentZoom = this.map.getZoom();
                    console.log("click mk", currentZoom);
                    let setZoom = this.appMapConfig.zoom.BUILDING;
                    this.map.flyTo(
                        mk.getLatLng(),
                        setZoom,   // usa el zoom actual del mapa
                        {duration: 0.35}    // segundo parámetro son las options
                    );
                    //    mk.openPopup();
                });
                this.byId[it.id] = mk;
                bounds.push([it.position.lat, it.position.lng]);
            });
            if (bounds.length) this.map.fitBounds(bounds, {padding: [40, 40]});
        }

        _popupHTML(item) {
            console.log("_popupHTML", item);
            let clasViewGLB = "not-view";
            let allowViewGLB = !(item.sources.glb == null);
            if (allowViewGLB) {
                clasViewGLB = "";
            }
            return `

<article class="popup-card" data-popup-id="${item.id}">
<span class="badge bg-secondary popup-card__subcategory">Totem-${item.totem_subcategory_name}</span>
  <header class="popup-card__header">
    <img class="popup-card__img" src="${item.sources.img}" alt="${item.title}" loading="lazy">
    <div class="popup-card__titles ">

      <h4 class="popup-card__title color-primary--title">${item.title}</h4>
      <p class="popup-card__subtitle color-secondary--title">${item.subtitle}</p>
    </div>
  </header>
  <section class="popup-card__body"><p class="popup-card__description">${item.description}</p></section>
  <footer class="popup-card__footer">
    <button class="popup-card__btn popup-card__btn--primary not-view" data-action="center" data-id="${item.id}">Centrar aquí</button>
    <a class="popup-card__btn popup-card__btn--ghost color-secondary--title ${clasViewGLB}"
       data-action="view3d"
       data-id="${item.id}"
       rel="noopener noreferrer">Ver en 3D</a>
  </footer>
</article>`;
        }

        _bindPopup(e) {
            const root = e.popup.getElement();
            if (!root) return;

            L.DomEvent.disableClickPropagation(root);
            L.DomEvent.disableScrollPropagation(root);

            const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
            centerBtn?.addEventListener('click', (ev) => {
                ev.preventDefault();
                const id = centerBtn.getAttribute('data-id');
                console.log("click centerBtn");

                this.flyTo(id);
            }, {once: true});

            const idForWarm = root.querySelector('[data-action="view3d"]')?.dataset?.id;
            if (idForWarm) {
                ItemsStore.warmById(idForWarm).catch(() => {
                });
            }

            const onClick = (ev) => {
                console.log("onClick");
                const btn = ev.target.closest('[data-action="view3d"]');
                if (!btn) return;
                ev.preventDefault();
                ev.stopPropagation();

                const id = btn.dataset.id;
                const best = ItemsStore.getBestGlbUrl(id)
                    || ItemsStore.getItemById(id)?.sources?.glb
                    || '';

                if (!best) {
                    UI.setHint('No hay fuente GLB/USDZ.');
                    return;
                }

                setTimeout(() => window.Viewer.onMarkerSourceSelected({id, glbUrl: best}), 0);
            };

            root.addEventListener('click', onClick, {passive: false});
            this.map.once('popupclose', (evClose) => {
                if (evClose.popup === e.popup) root.removeEventListener('click', onClick);
            });
        }

        flyTo(id, zoom = 17) {
            const mk = this.byId[id];
            if (!mk) return;
            const ll = mk.getLatLng();
            console.log("click flyTo");

            this.map.flyTo(ll, this.appMapConfig.zoom.BUILDING, {duration: 0.35});
            mk.openPopup();
        }
    }
</script>
