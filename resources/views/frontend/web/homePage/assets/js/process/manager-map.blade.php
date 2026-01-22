<script id="map-manager-script">
    function uniqueBusinesses(list) {
        const map = new Map();

        (list || []).forEach(item => {
            const id = item?.business_id;
            if (id == null) return;

            // si ya existe, no lo vuelve a meter (sin repetidos)
            if (!map.has(id)) map.set(id, item);
        });

        return Array.from(map.values());
    }

    function simulateBounce(marker) {
        const originalLatLng = marker.getLatLng();  // Obtener las coordenadas originales del marcador

        // Número de saltos
        const bounceCount = 5;
        let bounceCounter = 0;

        // Función para mover el marcador hacia arriba y hacia abajo
        function bounceStep() {
            if (bounceCounter < bounceCount) {
                // Mover el marcador hacia arriba
                marker.setLatLng([originalLatLng.lat + 0.0005, originalLatLng.lng]);

                // Esperar un poco antes de moverlo hacia abajo
                setTimeout(function () {
                    // Moverlo hacia abajo
                    marker.setLatLng([originalLatLng.lat, originalLatLng.lng]);

                    // Incrementar el contador de saltos
                    bounceCounter++;

                    // Llamar a la siguiente etapa de rebote
                    bounceStep();
                }, 200); // Tiempo de espera entre saltos (200ms)
            }
        }

        // Iniciar el proceso de rebote
        bounceStep();
    }

    function buildMapPopupHtml(data) {

        const close = [
            '<div class="infoBox-close">',
            '<i class="fa fa-times"></i>',
            '</div>'
        ];

        const category = [
            '<div class="map-popup-category">',
            data.category || '',
            '</div>'
        ];

        const image = [
            '<a href="', data.href || '#', '" class="listing-img-content fl-wrap">',
            '<img src="', data.img || '', '" alt="', data.title || '', '">',
            '</a>'
        ];

        const ratingStars = [];
        const stars = Math.max(0, Math.min(5, parseInt(data.rating || 0, 10)));
        for (let i = 0; i < stars; i++) {
            ratingStars.push('<i class="fa fa-star"></i>');
        }

        const rating = [
            '<div class="card-popup-raining map-card-rainting" data-starrating="', stars, '">',
            ratingStars.join(''),
            '<span class="map-popup-reviews-count">( ',
            data.reviewsCount || 0,
            ' reviews )</span>',
            '</div>'
        ];

        const titleBlock = [
            '<div class="listing-title fl-wrap">',
            '<h4>',
            '<a href="', data.href || '#', '">',
            data.title || '',
            '</a>',
            '</h4>',

            '<span class="map-popup-location-info">',
            '<i class="fa fa-map-marker"></i>',
            data.address || '',
            '</span>',

            '<span class="map-popup-location-phone">',
            '<i class="fa fa-phone"></i>',
            data.phone || '',
            '</span>',
            '</div>'
        ];

        const content = [
            '<div class="listing-content fl-wrap">',
            rating.join(''),
            titleBlock.join(''),
            '</div>'
        ];

        const popup = [
            '<div class="map-popup">',
            close.join(''),
            category.join(''),
            image.join(''),
            content.join(''),
            '</div>'
        ];

        const wrap = [
            '<div class="map-popup-wrap">',
            popup.join(''),
            '</div>'
        ];

        // ✅ STRING FINAL
        return wrap.join('');
    }

    Vue.component('map-manager-component', {
        template: '#map-manager-template',
        directives: {
            resetModel: {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput._resetModel(paramsInput.model);


                },
            },

        },
        props: {
            params: {
                type: Object,
            }
        },
        created: function () {
            var vmCurrent = this;
            this.$root.$on(this.nameComponent, function (emitValue) {
                console.log("emitValue", emitValue);
                if (emitValue.type == "addMarkers") {
                    var data = emitValue["data"];
                    const groups = uniqueBusinesses(data);
                    console.log(groups);
                    vmCurrent.addMarkers(groups)
                } else if ("click-map-item" == emitValue.type) {

                }

            });
            this.sendDataParent({action: 'created', child: this.nameComponent});

        },
        beforeMount: function () {

        },
        mounted: function () {
            var latLng = this.params.data.latLng;
            this.initDataBusiness({latLng: latLng});

        },
        data: function () {
            var dataManager = {
//**Modal*
                /*  ----MANAGER ENTITY---*/
                configModelEntity: {
                    "buttonsManagements": []
                },
                businessCreate: false,
                dataMapConfiguration: {
                    map: null,
                    data: [],
                    dataMarkers: [],
                }, nameComponent: "map-manager"
            };
            return dataManager;
        },
        methods: {
            ...$methodsFormValid,
            initDataBusiness: function (params) {
                var latLng = params["latLng"];
                this.initLeafletMap({latLng: latLng});


            },
            initLeafletMap: function (params) {
                $this = this;
                var dataCurrent = this.params.data.tasks;
                const groups = uniqueBusinesses(dataCurrent);
                const mapElement = $('#map-main');  // Seleccionar el contenedor con jQuery
                var latLng = params["latLng"];
                const map = L.map(mapElement[0]).setView(latLng, 13); // Establece la vista inicial
                this.dataMapConfiguration.map = map;
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                }).addTo(map);
                $this.addMarkers(groups)
                map.scrollWheelZoom.disable(); // Desactiva el zoom con la rueda del ratón
                // map.dragging.disable(); // Desactiva el desplazamiento del mapa con el ratón
                // Capturar clics en el mapa para agregar nuevos marcadores
                let $sope = this;

                map.on('click', function (event) {
                    //$sope.generateViewDataPosition({event:event,customIcon:customIcon,map:map});

                });

// fuerza el load si ya está inicializado por el setView
// (normalmente no hace falta, pero ayuda en algunos casos)
                map.whenReady(function () {
                    console.log('✅ whenReady: mapa listo');
                    $this.sendDataParent({
                        action: 'whenReady',
                        child: $this.nameComponent,
                        data: $this.dataMapConfiguration
                    });


                });


            },
            addMarker: function (marker) {
                const customIcon = L.icon({
                    iconUrl: $publicAsset + '/templates/cityBookHtml/images/marker.png', // URL de la imagen del ícono
                    iconSize: [32, 32],  // Tamaño del ícono
                    iconAnchor: [16, 32], // Punto de anclaje del ícono (donde se coloca en el mapa)
                    popupAnchor: [0, -32], // Ajusta la posición del popup respecto al ícono
                });
                var map = this.dataMapConfiguration.map;
                var latLang = [marker.business_lat, marker.business_lng];

                const html = buildMapPopupHtml({
                    category: 'Ocio',
                    href: $urlRouteBusiness + "/" + marker.business_name,
                    img: 'http://localhost:4949/meetclic-manager/public/uploads/business/information/default-turismo-acuatico.png',
                    title: marker.business_name,
                    address: 'Piedrahita , Buenos Aires',
                    phone: '0985339457',
                    rating: 5,
                    reviewsCount: 2
                });

                const markerCurrent = L.marker(latLang, {icon: customIcon, bouncing: true}).addTo(map)
                    .bindPopup(html);
                markerCurrent.on('mouseover', function (e) {

                    console.log("mouseover", e);
                });

                // Capturar el evento de salir el mouse del marcador
                markerCurrent.on('mouseout', function (e) {
                    console.log("mouseout", e);

                });

            }, addMarkers: function (markers) {
                $this = this;

                $.each(markers, function (key, marker) {
                    $this.addMarker(marker);
                });
            },
            initBounceMarker: function () {
                // Quitar la clase 'bouncing' para detener el rebote
                // e.target._icon.classList.remove('bouncing'); // Eliminar el rebote cuando el mouse sale
                // Agregar la clase 'bouncing' al ícono del marcador
                // e.target._icon.classList.add('bouncing'); // Aplicar el rebote al pasar el mouse
                console.log(this.dataMapConfiguration.dataMarkers)
                let marker = this.dataMapConfiguration.dataMarkers[0];

                const icon = marker._icon; // Obtener el ícono del marcador
                if (icon.classList.contains('leaflet-marker-icon--bouncing')) {
                    icon.classList.remove('leaflet-marker-icon--bouncing');
                } else {
                    // Si no tiene la clase 'bouncing', la añadimos
                    icon.classList.add('leaflet-marker__icon--bouncing');
                }
                if (!marker.options.bouncing) {

                    marker.options.bouncing = true;  // Marcamos que el rebote está activado
                } else {

                    marker.options.bouncing = false;  // Marcamos que el rebote está detenido
                }
                simulateBounce(marker);
            },
            generateViewDataPosition: function (params) {
                var {event, customIcon, map} = params;
                const latlng = event.latlng; // Obtener las coordenadas del clic

                // Crear un nuevo marcador con el ícono personalizado
                const newMarker = L.marker(latlng, {icon: customIcon}).addTo(map);
                console.log(newMarker);
                // Agregar un popup al nuevo marcador con el HTML proporcionado
                newMarker.bindPopup(`
      <div class="map-popup-wrap">
        <div class="map-popup">
          <div class="infoBox-close">
            <i class="fa fa-times"></i>
          </div>
          <div class="map-popup-category">Oficios / Servicios</div>
          <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic" class="listing-img-content fl-wrap">
            <img src="https://meetclic.com/public/uploads/business/information/1745413604_bomberos.jpg" alt="">
          </a>
          <div class="listing-content fl-wrap">
            <div class="card-popup-raining map-card-rainting" data-starrating="2">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <span class="map-popup-reviews-count">( 1 reviews )</span>
            </div>
            <div class="listing-title fl-wrap">
              <h4>
                <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic">Meetclic</a>
              </h4>
              <span class="map-popup-location-info">
                <i class="fa fa-map-marker"></i>Piedrahita y Buenos Aires, Buenos AIRE
              </span>
              <span class="map-popup-location-phone">
                <i class="fa fa-phone"></i>0985339457
              </span>
            </div>
          </div>
        </div>
      </div>
    `).openPopup();
            },
            sendDataParent: function (params) {
                this.$emit('_actions-emit', params);
            }

            //BUSINESS


        }
    });


</script>
